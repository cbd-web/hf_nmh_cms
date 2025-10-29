<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Cron_jobs extends CI_Controller
{

	/**
	 * Adverts Functionality Controller for My.Na
	 * Roland Ihms

	 */

	function Cron_jobs()
	{
		parent::__construct();
		//$this->load->model('cron_model');
	}


	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL QUEUE
	//++++++++++++++++++++++++++++++++++++++++++++
	function send_email_queue_()
	{

		$query = $this->db->limit('200');
		$query = $this->db->get('email_queue');
		$x = 0;
		$temp = '';
		$out = '';
		if ($query->result())
		{

			foreach ($query->result() as $row)
			{

				$HTML = $row->BODY;
				$subject = $row->SUBJECT;
				$mandrill = array($row->TO);
				$FROM_EMAIL = $row->FROM;
				$FROM_NAME = $row->FROM_NAME;


				if ($row->ADMIN_ID == 0)
				{

					$TAG['client_id'] = 'client-' . $row->CLIENT_ID;
				}
				else
				{

					$TAG['admin_id'] = 'admin-' . $row->ADMIN_ID;

				}
				//DUPLICATE FAILSAFE
				if ($row->TO != $temp)
				{

					if ($this->send_email($HTML, $subject, $mandrill, $FROM_EMAIL, $FROM_NAME, $TAG, true))
					{
						//insert log
						$this->db->insert('email_queue_log', $row);

						//delete
						$this->db->where('MAIL_ID', $row->MAIL_ID);
						$this->db->delete('email_queue');
						$temp = $row->TO;
						$x++;
						$out .= $row->TO . '<br />';
					}
					else
					{

						$out .= '!!!!!Double Up' . $row->TO . '<br />';

					}

				}


			}


		}

		//echo $x . ' emails sent';

		//ONLY SEND IF BIG LIST
		if ($x > 1)
		{

			$to1 = array(array('email' => 'roland@my.na'));
			$subject1 = "CMS Email Queue";
			$message = "We have succesfully sent " . $x . " event emails. From: " . $FROM_EMAIL . " Subject: " . $subject . '<br /><br />' . $out;
			$from1 = "no-reply@my.na";
			$headers = "From:" . $from1 . "\r\n" .
				"CC: christian@intouch.com.na";
			$TAG1 = array('tags' => 'cron_note');
			//mail($to,$subject,$message,$headers);
			$this->send_email($message, $subject1, $to1, $from1, 'My Events', $TAG1);
		}
	}


	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL QUEUE
	//++++++++++++++++++++++++++++++++++++++++++++
	function send_email_queue()
	{


		//$query = $this->db->limit('200');
		/*$q = $this->db->query("SELECT DISTINCT(email_queue.EMAIL_ID),emails.body, emails.title,emails.title,emails.email_id,emails.mime,emails.file_name,
								CAST(emails.attachment AS CHAR(1000000) CHARACTER SET utf8) as attachment, email_templates.header, email_templates.footer  FROM email_queue
                                JOIN emails ON email_queue.EMAIL_ID = emails.email_id
                                LEFT JOIN email_templates ON emails.bus_id = email_templates.bus_id
                                GROUP BY email_queue.EMAIL_ID LIMIT 1");*/

		$q = $this->db->query("SELECT email_queue.TO,email_queue.NAME,emails.bus_id,emails.EMAIL_ID,emails.body, emails.title,emails.title,emails.email_id,emails.mime,emails.file_name,
								CAST(emails.attachment AS CHAR(1000000) CHARACTER SET utf8) as attachment, email_templates.header, email_templates.footer
								FROM email_queue
								JOIN emails ON email_queue.EMAIL_ID = emails.email_id
								LEFT JOIN email_templates ON emails.bus_id = email_templates.bus_id
								LIMIT 1");

		$x = 0;
		$temp = '';
		$out = '';

		if ($q->result())
		{
			//var_dump($q->result());
			$attachment = '';
			$mime = '';
			$file_name = '';
			//BUILD BODY
			//GET EMAIL TEMPLATE
			foreach ($q->result() as $rowT)
			{

				if ($rowT->header != null)
				{

					//SNIPPEt
					$snippet = $this->shorten_string(strip_tags($rowT->body), 18);

					//REPLACE snippet and Link with dynamic content
					//teaser
					$header = str_replace('{{teaser}}', $snippet, $rowT->header);

					//link
					$link = 'Email not displaying correctly? View this email in your browser <a href="' . site_url('/') . 'main/email/' . $rowT->email_id . '">here</a>';
					$header = str_replace('{{link}}', $link, $header);

					$this->load->library('encrypt');

					$token = $this->encrypt->encode($rowT->TO);

					$unsubscribe = '<a href="'.site_url('/').'main/unsubscribe/'.$rowT->bus_id.'/'.$token.'">Unsubscribe from Newsletter</a>';

					$out = $header;
					$out .= $rowT->body;
					$out .= $rowT->footer;
					$out .= $unsubscribe;

					$HTML = $out;
					//ATTACHMENT
					if(strlen(trim($rowT->attachment)) != 0){

						$attachment = $rowT->attachment;
						$mime = $rowT->mime;
						$file_name = $rowT->file_name;
					}
				}
				else
				{
					$data2['body'] = $rowT->body;
					$data2['name'] = $rowT->NAME;
					$HTML = $this->load->view('email/body_news', $data2, true);
					//echo $rowT->attachment.'<br />';
					//ATTACHMENT
					if(strlen(trim($rowT->attachment)) != 0){

						$attachment = $rowT->attachment;
						$mime = $rowT->mime;
						$file_name = $rowT->file_name;
					}

				}
			}

			foreach ($q->result() as $row1)
			{

				$query = $this->db->query("SELECT * FROM email_queue WHERE EMAIL_ID = '" . $row1->EMAIL_ID . "' LIMIT 50");

				$array_to = array();
				$global_merge = array();
				$merge = array();
				$to = array();
				foreach ($query->result() as $row)
				{


					if (! filter_var($row->TO, FILTER_VALIDATE_EMAIL) === false)
					{


						//$HTML = $row->BODY;
						$subject = $row->SUBJECT;

						//BUILD ARRAY FOR EMAILS
						$d = array('email' => $row->TO, 'name' => $row->NAME);

						array_push($array_to, $d);

						//$mandrill = array(array('email' => $row->TO ));

						//BUILD MERGE VARIABLES
						$global = array(

							'name'    => 'link1',
							'content' => 'global_content'

						);
						array_push($global_merge, $global);

						$m = array(

							'rcpt' => $row->TO,
							'vars' => array(array(

								'name'    => 'name',
								'content' => $row->NAME

							))

						);
						array_push($merge, $m);

						$TAG['client_id'] = 'email_id_' . $row->EMAIL_ID;


						$FROM_EMAIL = $row->FROM;
						$FROM_NAME = $row->FROM_NAME;

						//insert log
						$this->db->insert('email_queue_log', $row);

						//delete
						$this->db->where('MAIL_ID', $row->MAIL_ID);
						$this->db->delete('email_queue');

						$out .= $row->TO . '<br />';


						$x++;
					}else{

						//delete
						$this->db->where('MAIL_ID', $row->MAIL_ID);
						$this->db->delete('email_queue');

					}

				}

				echo '<br /><br />';
				//var_dump($array_to);
				//ADD EMAIL LIST TO MANDRILL ARRAY
				$mandrill = $array_to;

				var_dump($array_to);
				//SEND MASS EMAIL
				if ($out .= $this->send_email($HTML, $subject, $mandrill, $FROM_EMAIL, $FROM_NAME, $TAG, true, $global_merge, $merge, $attachment, $file_name, $mime))
				{


				}
				else
				{

					$out .= '!!!!!Double Up' . $row->TO . '<br />';

				}

				echo ' : ' . $row1->EMAIL_ID . '<br />';
				echo $x . '<br /><br />';


			}


		}

		echo $x . ' emails sent';

		//ONLY SEND IF BIG LIST
		if ($x > 1)
		{

			$to1 = array(array('email' => 'roland@my.na'), array('email' => 'christian@intouch.com.na'));
			$subject1 = "CMS Email Queue v2";
			$message = "We have succesfully sent " . $x . " CMS mass emails. From: " . $FROM_EMAIL . " Subject: " . $subject . '<br /><br />' . $out;
			$from1 = "no-reply@my.na";
			$headers = "From:" . $from1 . "\r\n" .
				"CC: christian@intouch.com.na";
			$TAG1 = array('tags' => 'cron_note');
			//mail($to,$subject,$message,$headers);
			$this->send_email($message, $subject1, $to1, $from1, 'My CMS Mass Mail', $TAG1);
		}
	}



	//++++++++++++++++++++++++++++++++++++++++++++
	//PASS PARAMETERS AND SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++
	function send_email2($HTML, $subject, $mandrill, $FROM_EMAIL, $FROM_NAME, $TAG, $important = false, $global_merge = '', $merge = '',$attachment = null, $file_name = '', $mime = '')
	{

		$this->load->config('mandrill');

		$this->load->library('mandrill');

		$mandrill_ready = null;

		try
		{

			$this->mandrill->init($this->config->item('mandrill_api_key'));
			$mandrill_ready = true;

		}
		catch (Mandrill_Exception $e)
		{

			$mandrill_ready = false;

		}

		if ($mandrill_ready)
		{

			$attachments[] = array();
			if($attachment != null){

				//echo 'attachment 1: '.$attachment.'<br />';

				//$test = base64_encode(file_get_contents(BASE_URL.'admin_src/img/logo_cms_sml.png'));

				//echo $test.'<br />';

				$temp = str_replace('[removed]', '',   $attachment);
				$temp = str_replace('data:'.$mime.';base64,', '',   $temp);

				$raw = $temp;

				$attachment_encoded = $raw;


				$attachments[] = array(
					'content' => $attachment_encoded,
					'type' => $mime,
					'name' => $file_name
				);



			}


			//Send us some email!
			$email = array(
				'html'                      => $HTML, //Consider using a view file
				'text'                      => $this->strip_html_tags($HTML),
				'subject'                   => $subject,
				'headers' => array('Reply-To' => $FROM_EMAIL),
				'from_email' => 'no-reply@my.na',
				'from_name'                 => $FROM_NAME,
				'tags'                      => $TAG,
				'to'                        => $mandrill,
				'google_analytics_domains'  => array('my.na'),
				'google_analytics_campaign' => 'mail',
				'important'                 => true,
				'global_merge_vars'         => $global_merge,
				'merge_vars'                => $merge,
				'attachments' => $attachments
			);

			//var_dump($email);
			$result = $this->mandrill->messages_send($email);

		}

		return $mandrill_ready;

	}


//++++++++++++++++++++++++++++++++++++++++++++
	//PASS PARAMETERS AND SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++
	function send_email($HTML, $subject, $mandrill, $FROM_EMAIL, $FROM_NAME, $TAG, $important = false, $global_merge = '', $merge = '',$attachment = null, $file_name = '', $mime = '')
	{
	

			$to = '';
			$batch = array();
			$x=1;

			$variables = '{';

			$numItems = count($mandrill);

			foreach($mandrill as $row) {

				$to .= $row['email'].',';

				$variables .= '"'.$row['email'].'": {"first":"'.$row['name'].'", "id":'.$x.'}';

				if($x !== $numItems) { $variables .= ','; }


				//$chunk = array($row['email'] => array('first' => $row['name'], 'id' => $x));

				//array_push($batch, $chunk);

				$x++;
			}

			$variables .= '}';


		  $ch = curl_init();
		  curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
		  curl_setopt($ch, CURLOPT_USERPWD, 'api:eb91cba47d4373280fc8430cbc962134-f45b080f-65e1a0a9');
		  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		  curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
		  curl_setopt($ch, CURLOPT_URL, 
		              'https://api.mailgun.net/v2/mailman.intouch.com.na/messages');

		

	 	  curl_setopt($ch, CURLOPT_POSTFIELDS, 
          array('from' => $FROM_NAME .'<'.$FROM_EMAIL.'>',
                  'to' => $to,
                  'recipient-variables' => $variables,
                  'subject' => $subject,
                  'html' => $HTML
          ));

		

		  $result = curl_exec($ch);
		

		  curl_close($ch);

	}	


	//To remove all the hidden text not displayed on a webpage
	function strip_html_tags($str)
	{
		$str = preg_replace('/(<|>)\1{2}/is', '', $str);
		$str = preg_replace(
			array(// Remove invisible content
				'@<head[^>]*?>.*?</head>@siu',
				'@<style[^>]*?>.*?</style>@siu',
				'@<script[^>]*?.*?</script>@siu',
				'@<noscript[^>]*?.*?</noscript>@siu',
			),
			"", //replace above with nothing
			$str);
		$str = $this->replaceWhitespace($str);
		$str = strip_tags($str);

		return $str;
	} //function strip_html_tags ENDS

	//To replace all types of whitespace with a single space
	function replaceWhitespace($str)
	{
		$result = $str;
		foreach (array(
			         "  ", " \t", " \r", " \n",
			         "\t\t", "\t ", "\t\r", "\t\n",
			         "\r\r", "\r ", "\r\t", "\r\n",
			         "\n\n", "\n ", "\n\t", "\n\r",
		         ) as $replacement)
		{
			$result = str_replace($replacement, $replacement[0], $result);
		}

		return $str !== $result ? $this->replaceWhitespace($result) : $result;
	}


	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND SMS QUEUE
	//++++++++++++++++++++++++++++++++++++++++++++
	function send_sms_queue()
	{


		$query = $this->db->limit('100');
		$query = $this->db->get('sms_queue');
		$x = 0;
		if ($query->result())
		{

			foreach ($query->result() as $row)
			{

				$phone = $row->phone;
				$text = strip_tags($row->body);

				echo '<br />' . $phone . '<br />';

				$val = $this->validate_cell($phone, $text);

				if ($val['bool'])
				{

					//$this->send_sms_do($val['phone'], $text);

					if ($this->send_sms_do($val['phone'], $text))
					{

						//insert log
						$this->db->insert('sms_queue_log', $row);

						//delete
						$this->db->where('sms_queue_id', $row->sms_queue_id);
						$this->db->delete('sms_queue');
						$x++;


					}
					else
					{


					}

				}
				else
				{

					//delete do not LOG
					$this->db->where('sms_queue_id', $row->sms_queue_id);
					$this->db->delete('sms_queue');
				}


			}

			echo $x . ' SMS sent';

		}

		//echo $x . ' emails sent';
	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SVALIDATE CELL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//HTML
	function validate_cell($num, $txt)
	{

		//CLEAN
		$to = trim(preg_replace('/[^0-9]/', '', $num));
		$final = '';

		$first = substr($to, 0, 1);
		$first2 = substr($to, 0, 2);
		$first3 = substr($to, 0, 3);
		$val = false;
		$data['error'] = 'Malformed';
		//REMOVE 0027
		if ($first == '0' && $first2 == '0')
		{

			$to = substr($to, 2, strlen($to));
		}
		//override
		$first = substr($to, 0, 1);
		$first2 = substr($to, 0, 2);
		$first3 = substr($to, 0, 3);
		$length = strlen($to);

		//STRIP 264
		if ($first3 == '264')
		{

			$to = substr($to, 3, strlen($to));
			//override
			$first = substr($to, 0, 1);
			$first2 = substr($to, 0, 2);
			$first3 = substr($to, 0, 3);
			$length = strlen($to);
			//remove leading 0


		}
		if ($first == 0)
		{

			$to = substr($to, 1, strlen($to));
			//override
			$first = substr($to, 0, 1);
			$first2 = substr($to, 0, 2);
			$first3 = substr($to, 0, 3);
			$length = strlen($to);
		}
		//SMS
		if ($to != '' && $length <= 13)
		{

			//too long
			if ($length >= 10 && $first != 0)
			{

				$val = false;
				$data['error'] = 'Too many digits';
				$final = $to;

			}
			elseif ($length < 9)
			{

				$val = false;
				$data['error'] = 'Must be 10 digits';
				$final = $to;

				//REMOVE 0
			}
			elseif ($length == 10 && ($first3 == '081' || $first3 == '085'))
			{

				$final2 = substr($to, 1, strlen($to));
				$final = '264' . $final2;
				$val = true;

			}
			elseif ($length == 9 && ($first2 == '81' || $first2 == '85'))
			{

				//$final2 = substr($to, 1, strlen($to));
				$final = '264' . $to;
				$val = true;

				//IF NOT 081 or 085
			}
			elseif ($first2 != '81' || $first2 != '85')
			{

				$data['error'] = 'Not a namibian 081 or 085 Number';
				$final = '264' . $to;
				$val = false;

			}
			else
			{

				$final = '264' . $to;
				$val = false;

			}


			//VALIDATE NUMBER
			if ($val)
			{

				$data['bool'] = true;
				$data['phone'] = $final;
				$data['error'] = '';

				return $data;

			}
			else
			{

				$data['bool'] = false;
				$data['phone'] = $final;

				return $data;
			}
			//echo $num .'     length: ' .$length.' first: '.$first.' first2: '.$first2.' first3: ' .$first3.' whole: ' .$final.'   == '.$data['error'].' <br />';

		}

	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND SMS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//HTML
	function send_sms_do($to, $txt, $a = 'N', $shortcode = '77677')
	{
//		//SMS Service
//		//http://intouch.it.na/index.php?app=webservices&format=json&
//		//pass token, username
//		$baseUrl = 'http://intouch.it.na/index.php?app=webservices&format=json&';
//		$username = 'intouch';
//		$token = '777770e9a5120c289884c865eabff944';
//
//		// $to = '264818254455';
//		//$to = '264818863437';
//		$message = rawurlencode(substr($txt, 0 ,160));
//
//		$from = '77677';
//
//		$url = $baseUrl . 'ta=pv&u='.$username.'&h='.$token.'&to='.$to.'&msg='.$message;
//
//		/*$result = file_get_contents($url);
//
//		if($result === false ){
//
//			return FALSE;
//
//		}else{
//
//			return TRUE;
//
//		}*/
//
//		// Create a curl handle to a non-existing location
//		$ch = curl_init($url);
//		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//		$json = '';
//		if( ($json = curl_exec($ch) ) === false)
//		{
//
//			$this->session->set_flashdata('error', 'Curl error: ' . curl_error($ch));
//			return FALSE;
//		}
//		else
//		{
//			return TRUE;
//		}
//
//		// Close handle
//		curl_close($ch);


		//LOAD LIBRARIES FOR API AND SEND SMS
		$this->load->library('curl');
		$this->load->library('rest', array(
			'server'    => 'http://sms.my.na/api/sms/',
			'http_user' => 'myna_ma$ster',
			'http_pass' => '#$5_jh56_hdgd',
			'http_auth' => 'basic' // or 'digest'
		));

		if ($a != 'N')
		{
			$user = $this->rest->get('send', array('number' => $to, 'msg' => $txt, 'actioned' => 'Y', 'shortcode' => $shortcode), 'json');

		}
		else
		{

			$user = $this->rest->get('send', array('number' => $to, 'msg' => $txt,'actioned' => 'N', 'shortcode' => $shortcode), 'json');

		}


		return $user;

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND SMS MTC
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//HTML
	function send_sms_MTC($to, $txt, $a = 'N', $shortcode = '77677')
	{



		//LOAD LIBRARIES FOR API AND SEND SMS
		$this->load->library('curl');
		$this->load->library('rest', array(
			'server'    => 'http://sms.my.na/api/sms/',
			'http_user' => 'myna_ma$ster',
			'http_pass' => '#$5_jh56_hdgd',
			'http_auth' => 'basic' // or 'digest'
		));

		if ($a != 'N')
		{
			$user = $this->rest->get('sendMTC', array('number' => $to, 'msg' => $txt, 'actioned' => 'Y', 'shortcode' => $shortcode), 'json');

		}
		else
		{

			$user = $this->rest->get('sendMTC', array('number' => $to, 'msg' => $txt, 'shortcode' => $shortcode), 'json');

		}


		return $user;

	}

	//+++++++++++++++++++++++++++
	//SMS PROMO
	//++++++++++++++++++++++++++
	public function sms_curl()
	{
		$payload['number'] = '0898863437';
		$payload['msg'] = 'hello from Curl again and again One last';
		$params = http_build_query($payload, null, '&');
		$u = 'myna_ma$ster';
		$p = '#$5_jh56_hdgd';
		//echo $params;

		$process = curl_init('http://sms.my.na/api/sms/send/?' . $params);
		curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
		//curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
		//curl_setopt($process, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($process, CURLOPT_HEADER, 1);
		curl_setopt($process, CURLOPT_HTTPAUTH, constant('CURLAUTH_BASIC'));
		curl_setopt($process, CURLOPT_USERPWD, $u . ":" . $p);
		curl_setopt($process, CURLOPT_TIMEOUT, 30);
		curl_setopt($process, CURLOPT_HTTPGET, true);
		curl_setopt($process, CURLOPT_RETURNTRANSFER, true);
		//curl_setopt($process, CURLOPT_VERBOSE, true);
		$return = curl_exec($process);
		curl_close($process);
		var_dump($return);


	}

	//+++++++++++++++++++++++++++
	//SMS PROMO
	//++++++++++++++++++++++++++
	public function sms_promo()
	{


		//+++++++++++++++++++++++++++
		//GET PROMOs
		//++++++++++++++++++++++++++
		$p = $this->db->where('is_active', 'Y');
		$p = $this->db->get('sms_promo');
		$x = 0;
		if ($p->result())
		{

			//GET ALL SMS
			$this->load->model('sms_model');
			$smsdb = $this->sms_model->connect_sms_db();

			//LOOP EACH PROMO
			foreach ($p->result() as $prow)
			{

				//IMPORT and RESPONSE
				//import the sms number into contacts
				//send a response
				if ($prow->type == 'import_response')
				{

					//+++++++++++++++++++++++++++
					//SEARCH MATCHING SMS
					//++++++++++++++++++++++++++
					$q = $smsdb->query("SELECT * FROM sms_incoming
								   WHERE SUBSTRING(message,1,4) = '" . $prow->keyword . "' AND actioned = 'N'");

					//LOOP EACH SMS in Queue
					if ($q->result())
					{

						foreach ($q->result() as $irow)
						{

							//IMPORT
							$data['phone'] = $irow->from_address;

							//SEND RESPONSE
							$msg = $prow->response;
							$val = $this->send_sms_do($irow->from_address, $msg);

							echo $irow->from_address . $val;
							//UPDATE SMS table to actinoe = Y
							$update['actioned'] = 'Y';
							$smsdb->where('id', $irow->id);
							$smsdb->update('sms_incoming', $update);

							echo $msg . ' sent </br>';
							$x++;
						}


					}//end for each import response entries
					//+++++++++++++++++++++++++++

				}


			}//end foreach Promo

		}//end if PROMO available


	}
	//+++++++++++++++++++++++++++
	//GET MTC FEEDBACK
	//++++++++++++++++++++++++++
	public function mtc_feedback()
	{


		//+++++++++++++++++++++++++++
		//GET FEEDBACK
		//++++++++++++++++++++++++++
		$this->load->model('sms_model');
		$smsdb = $this->sms_model->connect_sms_db();

		$p = $smsdb->query("SELECT sms_outgoing_mtc.* , sms_incoming.message as in_message ,sms_incoming.actioned as income_actioned FROM sms_incoming
                            JOIN sms_outgoing_mtc ON sms_incoming.from_address = sms_outgoing_mtc.to_address AND sms_incoming.actioned = 'N'
                            WHERE sms_outgoing_mtc.created_at BETWEEN DATE_SUB(NOW() , INTERVAL 30 MINUTE)
                            AND NOW()
                            AND sms_incoming.created_at BETWEEN DATE_SUB(NOW() , INTERVAL 30 MINUTE)
                            AND NOW()
                            AND sms_incoming.actioned = 'N'
                            GROUP BY sms_outgoing_mtc.id
                            ORDER BY sms_outgoing_mtc.created_at DESC");
		//WHERE sms_incoming.from_address = '264814479995'
		$x = 0;
		if ($p->result())
		{

			//LOOP EACH FEEDBACK
			foreach ($p->result() as $row)
			{

				//GET MH ID FROM OUTGOING RESPONSE
				//MATCH MH ID
				$str = urldecode($row->message);
				var_dump($row);
				echo '<br /><br />' . $str;
				if (strpos($str, 'MTC'))
				{

					$start = strpos($str, 'MTC');
					$stop = strpos($str, '.') - $start;
					$m_id = substr($str, $start, $stop);

					//SEE IF RESPONDED
					$r = $smsdb->query("SELECT sms_incoming.*,mtc_mh_feedback.sms_incoming_id  FROM sms_incoming
                                        LEFT JOIN mtc_mh_feedback ON sms_incoming.id = mtc_mh_feedback.sms_incoming_id
                                        WHERE DATE(sms_incoming.created_at) = CURDATE() AND sms_incoming.from_address = '" . $row->to_address . "'
                                        AND sms_incoming.actioned = 'N'

                                        ORDER BY sms_incoming.created_at DESC
                                        LIMIT 1");
					//IF FEEDBACK FROUND
					if ($r->result())
					{

						//GET FEEDBACK RESPONSE
						$prow = $r->row();
						echo '<br /><br />';
						var_dump($prow);
						//GET RATING
						$rating = preg_replace("/[^0-9]/", "", $prow->message);

						//NO FEDDBACK FOR SMS ID
						if ($prow->sms_incoming_id == null)
						{

							//BUILD ARRAY
							$data = array(

								'from_address'    => $row->to_address,
								'mh_id'           => $row->mh_id,
								'name'            => '',
								'rating'          => $rating,
								'sms_incoming_id' => $prow->id,
								'agent_id'        => $row->agent_id
							);

							//INSERT
							$smsdb->insert('mtc_mh_feedback', $data);

							//UPDATE TO ACTIONED
							$pdata['actioned'] = 'Y';
							$smsdb->where('id', $prow->id);
							$smsdb->update('sms_incoming', $pdata);

							//SEND CONFIRMATION
							$msg = 'Thank you for your valued feedback';
							$val = $this->send_sms_MTC($prow->from_address, $msg, $a = 'Y', '98901');


						}
						else
						{

							//ALREADY LEFT FEEDBACK


						}


					}
					else
					{
						//DO NOTHING no feedback found

					}


				}
				else
				{


					//DO NOTHING


				}//end if MTC response


			}//end foreach Feedback

		}//end if


	}


	//+++++++++++++++++++++++++++
	//GET IQMS FEEDBACK
	//++++++++++++++++++++++++++
	public function iqms_feedback()
	{


		//+++++++++++++++++++++++++++
		//GET FEEDBACK
		//++++++++++++++++++++++++++
		$this->load->model('sms_model');
		$smsdb = $this->sms_model->connect_sms_db();


		$p = $smsdb->query("SELECT * FROM sms_outgoing_iqms
							WHERE actioned = 'N' AND created_at BETWEEN DATE_SUB(NOW() , INTERVAL 30 MINUTE) AND NOW()
							");

		//WHERE sms_incoming.from_address = '264814479995'
		$x = 0;
		if ($p->result())
		{

			//LOOP EACH FEEDBACK
			foreach ($p->result() as $row)
			{

				//GET MH ID FROM OUTGOING RESPONSE
				//MATCH MH ID
				$str = urldecode($row->message);
				var_dump($row);
				echo '<br /><br />' . $str;
				/*if (strpos($str, 'MTC'))
				{*/

					$start = strpos($str, 'MTC');
					$stop = strpos($str, '.') - $start;
					$m_id = substr($str, $start, $stop);


					//QUERY
					$s = "SELECT sms_incoming.*,iqms_feedback.sms_incoming_id  FROM sms_incoming
                                        LEFT JOIN iqms_feedback ON sms_incoming.id = iqms_feedback.sms_incoming_id
                                        WHERE DATE(sms_incoming.created_at) = CURDATE() AND sms_incoming.from_address = '" . $row->to_address . "'
                                        AND sms_incoming.actioned = 'N'
                                        ORDER BY sms_incoming.created_at DESC
                                        LIMIT 1";
					//SEE IF RESPONDED
					$r = $smsdb->query($s);

					echo '<br /><br />'.$s;

					//IF FEEDBACK FROUND
					if ($r->result())
					{

						//GET FEEDBACK RESPONSE
						$prow = $r->row();
						echo ' yes <br /><br />';
						var_dump($prow);
						//GET RATING
						$rating = preg_replace("/[^0-9]/", "", $prow->message);

						//NO FEDDBACK FOR SMS ID
						if ($prow->sms_incoming_id == null)
						{

							//BUILD ARRAY
							$data = array(

								'from_address'    => $row->to_address,
								'client_id'       => $row->client_id,
								'client_branch_id'=> $row->client_branch_id,
								'employee_id'     => $row->employee_id,
								'name'            => '',
								'rating'          => $rating,
								'sms_incoming_id' => $prow->id,

							);

							//INSERT
							$smsdb->insert('iqms_feedback', $data);

							//UPDATE TO ACTIONED incoming
							$pdata['actioned'] = 'Y';
							$smsdb->where('id', $prow->id);
							$smsdb->update('sms_incoming', $pdata);

							//SEND CONFIRMATION
							$msg = 'Thank you for your valued feedback';
							$val = $this->send_sms_do($prow->from_address, $msg, $a = 'Y', '77677');



							//UPDATE TO ACTIONED OUTGOING
							$pdata1['actioned'] = 'Y';
							$smsdb->where('id', $row->id);
							$smsdb->update('sms_outgoing_iqms', $pdata1);

						}
						else
						{

							//ALREADY LEFT FEEDBACK


						}


					}
					else
					{
						//DO NOTHING no feedback found

					}


				/*}
				else
				{


					//DO NOTHING


				}//end if MTC response*/


			}//end foreach Feedback

		}//end if


	}


	//+++++++++++++++++++++++++++
	//BACKUP DATABASE SYSTEM
	//++++++++++++++++++++++++++
	//BACKUPS
	//+++++++++++++++++++++++++++
	//BACKUP DATABASE SYSTEM
	//++++++++++++++++++++++++++
	public function backup_db_system()
	{
		$this->load->model('cron_model');
		$this->cron_model->backup_db_system();
		$to1 = array(array('email' => 'roland@my.na'), array('email' => 'christian@intouch.com.na'));
		$subject1 = "CMS SYSTEM Backup DB Notification";
		$message = "We have succesfully backed up the CMS database";
		$from1 = "no-reply@my.na";
		$headers = "From:" . $from1;
		$TAG1 = array('tags' => 'cron_note_backup');
		//mail($to,$subject,$message,$headers);
		$this->send_email($message, $subject1, $to1, $from1, 'CMS Backup Cron', $TAG1);
	}
	//+++++++++++++++++++++++++++
	//EMAIL STATS PER TAG
	//++++++++++++++++++++++++++
	//
	//
	//
	//+++++++++++++++++++++++++++
	//EMAIL STATS PER TAG
	//++++++++++++++++++++++++++
	public function get_email_tags_stats($id = '')
	{
		$this->load->model('cron_model');
		$this->cron_model->get_email_tags_stats();


	}
	//+++++++++++++++++++++++++++
	//EMAIL WEBHOOK FOR EVERY EVENT
	//++++++++++++++++++++++++++
	//
	//
	//
	//+++++++++++++++++++++++++++
	//EMAIL STATS PER TAG
	//++++++++++++++++++++++++++
	//+++++++++++++++++++++++++++
	//EMAIL WEBHOOK TO MANDRILL
	//++++++++++++++++++++++++++
	function email_events()
	{

		/* $http_origin = $_SERVER['HTTP_ORIGIN'];

		 if ($http_origin == "https://teamnamibia.my.na" || $http_origin == "https://ncci.my.na")
		 {
			 //$this->output->set_header("Access-Control-Allow-Origin: ".$http_origin);
		 }*/

		$this->output->set_header("Access-Control-Allow-Origin: * ");
		$this->output->set_header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS");
		$this->output->set_header('Access-Control-Allow-Headers: content-type');
		$this->output->set_header('Access-Control-Allow-Headers: X-PINGOTHER');
		$this->output->set_header('Access-Control-Request-Headers: X-PINGOTHER');

		$this->output->set_content_type('multipart/form-data');
		$this->output->_display();
		//PReflight
		if ($_SERVER['REQUEST_METHOD'] == "OPTIONS")
		{

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';

		}
		elseif ($_SERVER['REQUEST_METHOD'] == "POST")
		{


			/**/

			$this->insert_email_events();


		}

	}

	//+++++++++++++++++++++++++++
	//INSERT EMAIL EVENTS
	//++++++++++++++++++++++++++
	function insert_email_events()
	{

		if (isset($_POST['mandrill_events']))
		{

			$data['mandrill_events'] = $_POST['mandrill_events'];

			//$this->db->insert('email_events', $data);

			$row = json_decode($_POST['mandrill_events']);
			//$a2 = $_POST['mandrill_events'];

			$x = 0;
			$x2 = 0;

			//test tags ARRAY
			if (is_array($row[0]->msg->tags))
			{

				//LOOP TAGS
				foreach ($row[0]->msg->tags as $trow)
				{

					if ($x2 == 0)
					{

						if (substr($trow, 0, 9) == 'email_id_')
						{

							//echo 'Yup;';
							$email_id = str_replace('email_id_', '', $trow);

							$in['email_id'] = $email_id;
							$in['tag'] = $trow;

							$x2++;

						}
						else
						{

							$in['email_id'] = 0;

							$in['tag'] = $trow;


						}

					}

				}

			}
			$in['status'] = $row[0]->event;
			$in['mandrill_events'] = json_encode($row[0]);
			$this->db->insert('email_events', $in);

			// echo $row[0]->event . ' ' . $row[0]->msg->subject . ' Tags: - ' . $email_id . '< br />';
			$x++;

		}
		else
		{


		}

		//echo $x .' Records';

	}


	//Shorten String
	function shorten_string($phrase, $max_words)
	{

		$phrase_array = explode(' ', $phrase);

		if (count($phrase_array) > $max_words && $max_words > 0)
		{

			$phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . '...';
		}

		return $phrase;

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CACHE EMAIL FILE
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function cacheObject($url, $name, $age = 86400)
	{
		// directory in which to store cached files
		$cacheDir = BASE_URL . "application/views/email/cache/";
		// cache filename constructed from MD5 hash of URL
		$filename = $cacheDir . $name;
		// default to fetch the file
		$cache = true;
		// but if the file exists, don't fetch if it is recent enough
		if (file_exists($filename))
		{
			$cache = (filemtime($filename) < (time() - $age));
		}
		// fetch the file if required
		if ($cache)
		{

			if (copy($url, $filename))
			{
				// update timestamp to now
				touch($filename);
			}
			else
			{
				echo '<div class="alert">Could not fetch the feed. Please try again in a few minutes</div>';;
			}

		}

		// return the cache filename
		return $filename;
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */