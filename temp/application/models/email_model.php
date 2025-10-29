<?php

class Email_model extends CI_Model
{

	function email_model()
	{
		//parent::CI_model();
		$this->load->library('email');
	}


//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+GMAIL SMTP
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//		$config['protocol']='smtp';  
//		$config['smtp_host']='ssl://smtp.googlemail.com';  
//		$config['smtp_port']='465';  
//		$config['smtp_timeout']='30';  
//		$config['smtp_user']='info@my-child.co.nz';  
//		$config['smtp_pass']='namibia1'; 

//MANDRILL		
//		$config['protocol']='smtp';  
//		$config['smtp_host']='smtp.mandrillapp.com';  
//		$config['smtp_port']='587';  
//		$config['smtp_timeout']='30';  
//		$config['smtp_user']='roland@my.na';  
//		$config['smtp_pass']='d3tAlotpZNobGiCfRk3Miw'; 



	//NEW SERVER
	function send_enquiry($var)
	{

		$this->load->library('email');	

		$this->email->initialize(array(
			'protocol' => 'mail' , //Protocol SMTP on shared hosting issue
			'smtp_host' => 'tls://email-smtp.eu-west-1.amazonaws.com',
			'smtp_port' => '587',
			'mailtype' => 'html',
			'smtp_user' => 'AKIAIEDWIYXIABCFGGFQ',
			'smtp_pass' => 'Ahxb1+zvPa8Eq6zgDuZEkdhNwPBZSRQPOBSVQ/AqW7YA'));

		$this->email->set_newline("\r\n");


		$this->email->from('no-reply@intouchsrv.com');
		$this->email->to($var['email_to']);
		$this->email->cc($var['email_cc']);
		$this->email->subject($var['subject']);
		$this->email->message($var['body']);

		if($attachments != '') {
			$this->email->attach($var['attachments']);
		}
		

		$this->email->send();		
	

	}	


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND ENQUIRY EMAIL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//HTML
	function send_enquiry3($var)
	{
		/*			$config['mailtype'] = 'html';
					$this->email->initialize($config);
					$this->email->from($var['email'],$var['name']);
					//GET CONTACT US EMAIL
					$business = $this->get_contact();

					$this->email->reply_to($var['email'],$var['name']);
					$this->email->to($business['contact_email']);
					//$this->email->cc('another@another-example.com');
					//$this->email->bcc('them@their-example.com');
					//build body

					$data['email'] = $var['email'];
					$data['base'] = base_url('/');
					$data['name'] = $var['name'];
					$data['msg'] = $var['body'];

					$body1 = $this->load->view('email/body_enquiry',$data , true);

					$this->email->subject('Enquiry via the Website');
					$this->email->message($body1);
					//$this->email->attach('./img/icons/logo.png');

					$this->email->send();
					return;*/

		$this->load->config('mandrill');

		$this->load->library('mandrill');

		$mandrill_ready = null;

		try
		{

			$this->mandrill->init($this->config->item('mandrill_api_key'));
			$mandrill_ready = true;
			//echo 'yes';
		}
		catch (Mandrill_Exception $e)
		{

			$mandrill_ready = false;
			//echo 'no';
		}

		if ($mandrill_ready)
		{

			$to = array(array('email' => $var['email_to']));
			//Send us some email!
			$email = array(
				'html'       => $var['body'], //Consider using a view file
				'text'       => strip_tags($var['body']),
				'subject'    => $var['subject'],
				'headers' => array('Reply-To' => $var['from_email']),
				'from_email' => 'no-reply@my.na',
				'from_name'  => $var['name'],
				'to'         => $to
			);

			$result = $this->mandrill->messages_send($email);

		}

		return;
	}


	//++++++++++++++++++++++++++++++++++++++++++++
	//PASS PARAMETERS AND SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++		
	function send_mail2($HTML, $subject, $mandrill, $FROM_EMAIL, $FROM_NAME, $TAG, $important = true, $global_merge = '', $merge = '')
	{

		$this->load->config('mandrill');

		$this->load->library('mandrill');

		$mandrill_ready = null;
		$result = '';
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

			//Send us some email!
			$email = array(
				'html'                      => $HTML, //Consider using a view file
				'text'                      => strip_tags($HTML),
				'subject'                   => $subject,
				'from_email'                => $FROM_EMAIL,
				'from_name'                 => $FROM_NAME,
				'tags'                      => $TAG,
				'to'                        => $mandrill,
				'google_analytics_domains'  => array('cms.my.na'),
				'google_analytics_campaign' => 'forum_email',
				'important'                 => $important,
				'global_merge_vars'         => $global_merge,
				'merge_vars'                => $merge
			);

			$result = $this->mandrill->messages_send($email);

		}

		return $result;

	}

	//NEW SERVER
	function send_mail($HTML, $subject, $mandrill, $FROM_EMAIL, $FROM_NAME, $TAG, $important = true, $global_merge = '', $merge = '')
	{

		$this->load->library('email');	

		$this->email->initialize(array(
			'protocol' => 'mail' , //Protocol SMTP on shared hosting issue
			'smtp_host' => 'tls://email-smtp.eu-west-1.amazonaws.com',
			'smtp_port' => '587',
			'mailtype' => 'html',
			'smtp_user' => 'AKIAIEDWIYXIABCFGGFQ',
			'smtp_pass' => 'Ahxb1+zvPa8Eq6zgDuZEkdhNwPBZSRQPOBSVQ/AqW7YA'));

		$this->email->set_newline("\r\n");


		$this->email->from('no-reply@intouchsrv.com');
		$this->email->to($mandrill);
		$this->email->subject($var['subject']);
		$this->email->message($HTML);


		$this->email->send();		
	

	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET SETTINGS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//HTML
	function get_contact()
	{
		$query = $this->db->get('settings');
		$row = $query->row_array();

		return $row;

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW EMAIL RECIPIENTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function show_email_recipients2($type = '', $sub_cat = ''){

		$bus_id = $this->session->userdata('bus_id');
		//GET ALL CATEGORIES
		$subs = $this->db->query("SELECT  DISTINCT(subscriber_type_int.type_id), subscriber_type.type FROM subscriber_type_int
                                  JOIN subscriber_type ON subscriber_type.sub_type_id = subscriber_type_int.type_id
                                  WHERE subscriber_type_int.bus_id = '".$bus_id."'");
		//$exh = $this->db->query("SELECT DISTINCT(type) FROM exhibitors2 WHERE bus_id = '".$bus_id."'");
		//SELECTION
		echo '<div class="btn-group">
				<button class="btn">Recipients</button>
				<button class="btn dropdown-toggle" data-toggle="dropdown">
				  <span class="caret"></span>
				</button>
				<ul class="dropdown-menu">
				  <li class="nav-header">Contacts</li>
				  <li><a tabindex="-3" onClick="select_rec('."'subscribers', ''".');" href="javascript:void(0);">All Contacts</a></li>';

		if($subs->result()){

			foreach($subs->result() as $row){

				echo '<li><a tabindex="-1" onClick="select_rec('."'subscribers', '".$row->type_id."'".');" href="javascript:void(0);">'.ucwords(str_replace("_", " " ,$row->type)).'</a></li>';
			}

		}


		/*echo 	  '<li class="nav-header">Exhibitors</li>
				  <li><a tabindex="-3" onClick="select_rec('."'exhibitors', ''".');" href="javascript:void(0);">All Exhibitors</a></li>';*/



		/*if($exh->result()){

			foreach($exh->result() as $row2){

				echo '<li><a tabindex="-3" onClick="select_rec('."'exhibitors', '".$row2->type."'".');" href="javascript:void(0);">'.ucwords(str_replace("_", " " ,$row2->type)).'</a></li>';
			}

		}*/


		echo	'</ul>
			  </div>';





		if($type == 'exhibitors'){
			$str = ucwords($type).'2';
			if($sub_cat != ''){
				$str = ucwords( rawurldecode($sub_cat) ) . ' '.ucwords(rawurldecode($type));
				$query = $this->db->query("SELECT exhibitor_id as id, exhibitor as name FROM ".rawurldecode($type).'2'." WHERE bus_id = ".$bus_id." AND type = '". rawurldecode($sub_cat) ."'");

			}else{

				$query = $this->db->query("SELECT exhibitor_id as id, exhibitor as name, type FROM ".rawurldecode($type).'2'." WHERE bus_id = ".$bus_id."");
			}


		}else{
			$str = 'Contacts';

			if($sub_cat != ''){
				$str = ucwords(  rawurldecode($sub_cat) ) . ' '.ucwords($type);

				$query = $this->db->query("SELECT subscribers.subscriber_id as id, CONCAT(subscribers.name, ' ',subscribers.sname) as name FROM subscribers
                                  JOIN subscriber_type_int ON subscribers.subscriber_id = subscriber_type_int.subscriber_id
                                  JOIN subscriber_type ON subscriber_type.sub_type_id = subscriber_type_int.type_id
                                  WHERE subscriber_type_int.bus_id = '".$bus_id."' AND subscriber_type_int.type_id = '". rawurldecode($sub_cat) ."' LIMIT 10");
			}else{

				$query = $this->db->query("SELECT subscriber_id as id, name as name, type FROM subscribers WHERE bus_id = ".$bus_id." LIMIT 10");
			}


		}


		echo '<input type="hidden" id="stype" name="stype" value="'. $type.'">
			  <input type="hidden" id="subscriber_category" name="subscriber_category" value="'. rawurldecode($sub_cat) .'">';
		if($query->result()){
			echo'<h4>'.$str.'</h4>
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="subscriber_table" width="100%">
				<thead>
					<tr style="font-weight:bold">

           				<th style="width:60%">Name </th>
						<th style="width:20%">Type </th>
						<th style="width:20%;text-align:right" rel="tooltip" title="Select All"><input type="checkbox" name="selectall" id="selectall"  /></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				$str = "'".$row->ID."','main'";
				$java = "load_ajax_cat_sub('".$row->id."')";
				echo '<tr>

						<td style="width:60%">'.$row->name . ' </td>
						<td style="width:20%">'.$row->type . ' </td>
					  	<td style="width:20%; text-align:right"><input type="checkbox" class="case" name="recipients['.$row->id.']" value="'. $row->id.'"></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				$(document).ready(function(){

					$("#selectall").bind("click", function () {
						  $(".case").attr("checked", this.checked);
						  $(".case").parent().addClass("checked");
					});

					$(".case").click(function(){

						if($(".case").length == $(".caseT:checked").length) {
							$("#selectall").attr("checked", "checked");
						} else {
							$("#selectall").removeAttr("checked");
							 $("#selectall").parent().removeClass("checked");
						}

					});
				});
				</script>';

		}else{

			echo '<div class="alert">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		No '.$str.' have been added</div> ';

		}

	}
//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW EMAIL RECIPIENTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function show_email_recipients($type = '', $sub_cat = ''){

		$bus_id = $this->session->userdata('bus_id');
		//GET ALL CATEGORIES
		$subs = $this->db->query("SELECT  DISTINCT(subscriber_type_int.type_id),COUNT( subscriber_type_int.type_id) as total, subscriber_type.type FROM subscriber_type_int
                                  JOIN subscriber_type ON subscriber_type.sub_type_id = subscriber_type_int.type_id
                                  JOIN subscribers ON subscribers.subscriber_id = subscriber_type_int.subscriber_id
                                  WHERE subscriber_type_int.bus_id = '".$bus_id."' AND (subscribers.email != '' OR subscribers.email != null) GROUP BY  subscriber_type_int.type_id");
		//$exh = $this->db->query("SELECT DISTINCT(type) FROM exhibitors2 WHERE bus_id = '".$bus_id."'");
		$out = '';

		$total = 0;
		if($subs->result()){

			foreach($subs->result() as $row){
				$total = $total + $row->total;
				$out .= '<li><a tabindex="-1" data-total="'.$row->total.'"  href="javascript:void(0);">'.ucwords(str_replace("_", " " ,$row->type)).' ('.$row->total.')
                            <input type="checkbox" class="case pull-right" name="categories[]" value="'. $row->type_id.'" data-total="'.$row->total.'" data-value="'.$row->type.'"></a></li>';
			}

		}
		//SELECTION
		$out1 = '
                <input type="text" id="srch_email" class="span12" name="srch_name" value="" placeholder="Find by name">
                <div class="todo">
                <ul class="todo-list "  style="max-height:300px;  overflow: hidden;overflow-y:scroll;">
				  <li class="nav-header">Contacts</li>
				  <li><a tabindex="-1" href="javascript:void(0);">All Contacts ('.$total.')<input type="checkbox" name="selectall" class="pull-right" id="selectall"  data-total="'.$total.'" data-value="All Contacts"/></a></li>';

		echo	$out1.$out.'</ul>
                <p>&nbsp;</p>
                <input type="hidden" name="recipients" id="recipients" value="">
                <div class="row-fluid">
                    <div id="email_res" class="span10"></div>
                    <div id="email_total" class="span2 text-right">0</div>
                </div>

                <div id="no_recip"><div class="alert">No Recipients selected</div></div>
			  </div>

			  <script type="text/javascript">
				$(document).ready(function(){


                    var bestPictures = new Bloodhound({
                      datumTokenizer: Bloodhound.tokenizers.obj.whitespace("value"),
                      queryTokenizer: Bloodhound.tokenizers.whitespace,
                      prefetch: "'.site_url('/').'admin/find_subscribers/?query='.'",
                      remote: {
                        url: "'.site_url('/').'admin/find_subscribers/?query=%QUERY'.'",
                        wildcard: "%QUERY"
                      },
                      limit: 10
                    });

                    $("#srch_email").typeahead({
                          minLength: 0,
                          highlight: true
                        }, {
                          name: "best-pictures",

                          display: "value",
                          source: bestPictures,
                          templates: {
                            empty: [
                              "<p class='."'alert'".' style='."'margin:0px 10px'".'>",
                                "unable to find any contacts that match the current query",
                              "</p>"
                            ].join("\n"),
                            suggestion: Handlebars.compile("<div><a href='."'{{link}}'".'>{{value}} – <small>{{email}}</small></a></div>")
                      }
                    });

					$("#selectall").bind("click", function () {
						  var tot = $(this).attr("data-total"), nam = $(this).attr("data-value");
						  $(".case").attr("checked", this.checked);
						  $(".case").parent().addClass("checked");
                          if(!$(this).is(":checked")){

                              remove_category(this.value, nam, 0, true);
                          }else{

                              add_category(this.value, nam, tot, true);
                          }
					});

					$(".case").click(function(){

                        var tot = $(this).attr("data-total"), nam = $(this).attr("data-value");

                        if(!$(this).is(":checked")){

                            remove_category(this.value, nam, tot, false);
                        }else{

                            add_category(this.value, nam, tot, false);
                        }

						if($(".case").length == $(".caseT:checked").length) {
							$("#selectall").attr("checked", "checked");

						} else {
							$("#selectall").removeAttr("checked");
							$("#selectall").parent().removeClass("checked");

						}

					});
				});
				</script>';



		echo '<input type="hidden" id="stype" name="stype" value="'. $type.'">
              <input type="hidden" id="category" name="category" value="">
			  <input type="hidden" id="subscriber_category" name="subscriber_category" value="'. rawurldecode($sub_cat) .'">';


	}

	//++++++++++++++++++++++++++++++++++++++++++++
	//FIND SUBSCRIBERS
	//++++++++++++++++++++++++++++++++++++++++++++
	function find_subscribers()
	{
		if($str = rawurldecode($this->input->get('query', TRUE)))
		{
			$bus_id = $this->session->userdata('bus_id');
			$tq1 = "SELECT CONCAT(name,' ',sname) as name,phone, email, subscriber_id FROM subscribers WHERE (name LIKE '%" . $str . "%' OR sname LIKE '%" . $str . "%' OR email LIKE '%" . $str . "%') AND bus_id = '".$bus_id."' ORDER BY name ASC LIMIT 15";
			$query = $this->db->query($tq1, false);
			$out = array();
			if ($query->result())
			{

				foreach ($query->result() as $row)
				{

					$name = $row->name;

					if($row->email == '' || $row->email == null){

						$array = explode(" ", $name);
					}else{

						$array = explode(" ", $name. " ".$row->email);

					}
					if($row->phone != '' || $row->phone != null)
					{
						array_push($array, $row->phone);
					}
					$temp = implode('","', $array);
					//$link1 = "<a href='".site_url('/').$row->link.'">';
					$t = array(

						"email"   => $row->email,
						"phone" => $row->phone,
						"link"  => "javascript:add_recipient('". $row->subscriber_id . "','".preg_replace("/[^a-zA-Z0-9]/", "",$row->name)."')",
						"value"  => $name,
						"tokens" => $array

					);
					array_push($out, $t);


				}

			}
			echo json_encode($out);

			$this->output->set_content_type('application/json');
		}
	}

	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL
	//++++++++++++++++++++++++++++++++++++++++++++
	function send_email()
	{
		if($this->session->userdata('admin_id')){
			$browser_view = '';
			//GET EMAIL FILDS
			$recipients = $this->input->post('recipients',TRUE);
			$subject = $this->input->post('title',TRUE);
			$body = $this->input->post('content',FALSE);
			$type = $this->input->post('stype',FALSE);
			$subscriber_category = $this->input->post('subscriber_category',FALSE);
			$categories = $this->input->post('categories',FALSE);
			$email_id = $this->input->post('email_id',FALSE);
			$bus_id = $this->session->userdata('bus_id');

			// if($bus_id == '10591'){ $browser_view = '<tr style="font-size: 12px; text-align:center;"><td><a target="_blank" href="'.site_url('/').'email/'.$email_id.'">View this email in browser.</a></td></tr><br><br>'; }

			// $body = $browser_view .''. $body;

			$attachment = $this->input->post('byte_content',FALSE);
			$mime = $this->input->post('mime',FALSE);
			$file_name = $this->input->post('file_name',FALSE);

			$count = 0;
			$rec_array[] = array();
			$all_array = array();
			//GET BUSINESS DETAILS
			$settings = $this->admin_model->get_settings();
			$business = $settings['title'];
			$admin_id = $this->session->userdata('admin_id');

			$recipientsA = json_decode($recipients);
			//INSERT AS SENT EMAIL INTO EMAILS TABLE
			//INSERT INTO EMAILS
			$insert['bus_id'] =$bus_id;
			$insert['title'] = $subject;
			$insert['body'] = $body;
			$insert['status'] = 'sent';
			$insert['admin_id'] =    $admin_id;
			$insert['attachment'] =  $attachment;
			$insert['mime'] =  $mime;
			$insert['file_name'] =  $file_name;
			if($email_id == 0){
				$this->db->insert('emails', $insert);
				$email_id = $this->db->insert_id();
			}else{

				$this->db->where('email_id', $email_id);
				$this->db->update('emails', $insert);

			}

			//var_dump($recipientsA). ' '. var_dump($categories);

			//ALL SELECTED
			if(isset($_POST['selectall'])){
				//echo 'all';
				//SUBSCRIBERS OR EXHIBITORS
				if($type == 'subscribers'){


					$query = $this->db->query("SELECT CONCAT(name,' ' ,sname) as name, email FROM subscribers WHERE (email != '' OR email != null) AND bus_id = '".$bus_id."'");

					/*$query = $this->db->query("SELECT CONCAT(subscribers.name,' ', subscribers.sname) as name FROM subscribers
											  LEFT JOIN subscriber_type_int ON subscriber_type_int.subscriber_id = subscribers.subscriber_id
											  WHERE subscriber_type_int.type_id = '".$subscriber_category."'
											  ");*/

				}


				foreach($query->result() as $row){

					//BUILD MANDRILL ARRAY
					$mandrill = array(array('email' => $row->email ));

					//SEND MANDRILL
					$from_email =  $settings['contact_email'];

					$count ++;

					$data['ADMIN_ID'] = $admin_id;
					$data['EMAIL_ID'] = $email_id;
					$data['FROM'] = $from_email;
					$data['FROM_NAME'] = $settings['title'];;
					$data['ID'] = $data['ADMIN_ID'].'-'.$count;
					$data['SUBJECT'] = $subject;
					$data['BODY'] = '';
					$data['TO'] = $row->email;
					$data['NAME'] = $row->name;

					//$this->db->insert('email_queue',$data);

					//BUILD RECIPIENT ARRAY
					//array_push($rec_array[$type], $row->subscriber_id);

					//BUILD BATCH INSERT ARRAY
					array_push($all_array, $data);


				}

				//INSERT BATCH ALL
				$this->db->insert_batch('email_queue',$all_array);


				//INSERT AS SENT EMAIL INTO EMAILS TABLE
				//INSERT INTO EMAILS
				$insert['bus_id'] = 0;
				$insert['title'] = $subject;
				$insert['body'] = $body;
				$insert['status'] = 'sent';
				$insert['recipients'] = json_encode($rec_array[$type]);
				$insert['admin_id'] =  $admin_id;


				//var_dump($rec_array[$type]);

				//SUCCESS MESSAGE
				$this->session->set_flashdata('msg',$count.' emails sent');
				$str = "Successfully queued ".$count." emails.";
				echo "<script>var options = {'text':'".$str."','layout':'bottomLeft','type':'success'};
						  noty(options);
						   $('#send_email_yes').html('Sent');
						   $('#modal-email').modal('hide');
						  </script>";


				//ONLY SELECTED
			}elseif(count($recipientsA) > 0 || count($categories) > 0) {
				//echo 'some';
				//SELECTED recipients
				if(count($recipientsA) > 0){


					foreach($recipientsA as $value) {

						$row = $this->get_subscriber($value);

						$data['ADMIN_ID'] =  $admin_id;
						$data['EMAIL_ID'] = $email_id;
						$data['FROM'] = $settings['contact_email'];
						$data['FROM_NAME'] = $settings['title'];
						$data['ID'] = $data['ADMIN_ID'].'-'.$count;
						$data['SUBJECT'] = $subject;
						$data['BODY'] = '';
						$data['TO'] = $row['email'];
						$data['NAME'] = $row['name'];

						//$this->db->insert('email_queue',$data);

						//BUILD RECIPIENT ARRAY
						//array_push($rec_array, $value);

						array_push($all_array, $data);
						$count ++;
					}

				}


				if(count($categories) > 0){

					//SELECTED CATEGORIES
					foreach($categories as $value2) {

						$cat = $this->db->query("SELECT CONCAT(a.name,' ',a.sname) as name,a.email
                                             FROM subscribers AS a
                                             JOIN subscriber_type_int AS b ON a.subscriber_id = b.subscriber_id
                                             WHERE a.bus_id = '" . $bus_id . "' AND (a.email != '' OR a.email != null) AND b.type_id = '".$value2."' GROUP BY a.subscriber_id ");



						if($cat->result()){

							foreach($cat->result() as $crow){

								$data['ADMIN_ID'] = $admin_id;
								$data['EMAIL_ID'] = $email_id;
								$data['FROM'] = $settings['contact_email'];
								$data['FROM_NAME'] = $settings['title'];
								$data['ID'] = $data['ADMIN_ID'].'-'.$count;
								$data['SUBJECT'] = $subject;
								$data['BODY'] = '';
								$data['TO'] = $crow->email;
								$data['NAME'] = $crow->name;

								//$this->db->insert('email_queue',$data);

								//BUILD RECIPIENT ARRAY
								//array_push($rec_array, $value);

								array_push($all_array, $data);
								$count ++;

							}



						}


					}

				}
				//ONLY IF SELECTED
				if(count($recipientsA) > 0 || count($categories) > 0)
				{
					//var_dump($all_array);
					//INSERT BATCH ALL
					$this->db->insert_batch('email_queue', $all_array);
				}
				//var_dump($rec_array);
				//LOG ACTION
				$this->admin_model->system_log('sent_email-'. $count);
				//SUCCESS MESSAGE
				$this->session->set_flashdata('msg',$count.' emails sent');
				$str = "Successfully queued ".$count." emails.";
				echo "<script>var options = {'text':'".$str."','layout':'bottomLeft','type':'success'};
					            noty(options);
								 $('#send_email_yes').html('Sent');
								 $('#modal-email').modal('hide');
								</script>";


				//NO RECIPIENTS SELECTED
			}else{

				//$this->session->set_flashdata('msg','Please select some recipients.');
				$str = "Please select some recipients.";
				echo "<script>var options = {'text':'".$str."','layout':'bottomLeft','type':'error'};
					  noty(options);
					   $('#send_email_yes').html('Yes, Send');
					   $('#modal-email').modal('hide');
					  </script>";


			}
			//echo 'Only selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count .' = ' .$num;



			//NOT LOGGED IN
		}else{

			redirect('/admin/logout/', 'refresh');

		}

	}







	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND EMAIL 
	//++++++++++++++++++++++++++++++++++++++++++++	
	function send_newsletter_do2($HTML, $TEXT, $subject, $mandrill, $business, $from_email)
	{

		$this->load->config('mandrill');

		$this->load->library('mandrill');

		$mandrill_ready = null;

		try
		{

			$this->mandrill->init($this->config->item('mandrill_api_key'));
			$mandrill_ready = true;
			echo 'yes';
		}
		catch (Mandrill_Exception $e)
		{

			$mandrill_ready = false;
			echo 'no';
		}

		if ($mandrill_ready)
		{

			//Send us some email!
			$email = array(
				'html'       => $HTML, //Consider using a view file
				'text'       => $TEXT,
				'subject'    => $subject,
				'headers' => array('Reply-To' => $from_email),
				'from_email' => 'no-reply@my.na',
				'from_name'  => $business,
				'to'         => $mandrill
			);

			$result = $this->mandrill->messages_send($email);

		}


	}



	//NEW SERVER
	function send_newsletter_do($HTML, $TEXT, $subject, $mandrill, $business, $from_email)
	{

		$this->load->library('email');	

		$this->email->initialize(array(
			'protocol' => 'mail' , //Protocol SMTP on shared hosting issue
			'smtp_host' => 'tls://email-smtp.eu-west-1.amazonaws.com',
			'smtp_port' => '587',
			'mailtype' => 'html',
			'smtp_user' => 'AKIAIEDWIYXIABCFGGFQ',
			'smtp_pass' => 'Ahxb1+zvPa8Eq6zgDuZEkdhNwPBZSRQPOBSVQ/AqW7YA'));

		$this->email->set_newline("\r\n");


		$this->email->from('no-reply@intouchsrv.com');
		$this->email->to($mandrill);
		$this->email->subject($var['subject']);
		$this->email->message($HTML);


		$this->email->send();		
	

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//UPDATE MSG STATUS
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function update_msg_status($msg_id, $status, $type)
	{

		if ($type == 'Business')
		{

			$data = array(
				'status' => $status
			);

		}
		else
		{
			$data = array(
				'status_client' => $status
			);


		}

		$this->db->where('msg_id', $msg_id);
		$this->db->update('u_business_messages', $data);


	}
	//+++++++++++++++++++++++++++
	//GET MEMBER DETAILS
	//++++++++++++++++++++++++++		 

	function get_member($mem_id)
	{

		$test = $this->db->where('member_id', $mem_id);
		$test = $this->db->get('members');

		return $test->row_array();

	}
	//+++++++++++++++++++++++++++
	//GET MEMBER DETAILS
	//++++++++++++++++++++++++++		 

	function get_subscriber($id)
	{

		$test = $this->db->where('subscriber_id', $id);
		$test = $this->db->get('subscribers');

		return $test->row_array();

	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET MSG
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function get_message($msg_id)
	{

		$test = $this->db->from('u_business_messages');
		$test = $this->db->where('msg_id', $msg_id);
		//$test = $this->db->where('status', 'unread');
		$test = $this->db->get();

		return $test->row_array();

	}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SEND ENQUIRY EMAIL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//HTML
	function test_email()
	{
		$config['mailtype'] = 'html';
		$this->email->initialize($config);
		$this->email->from('roland@my.na', 'Roland');
		//GET CONTACT US EMAIL
		//$business = $this->get_contact();

		$this->email->reply_to('roland@my.na', 'Roland');
		$this->email->to('roland@intouch.com.na');
		//$this->email->cc('another@another-example.com');
		//$this->email->bcc('them@their-example.com');
		//build body

		$data['email'] = 'roland@my.na';
		$data['base'] = base_url('/');
		$data['name'] = 'Roland';
		$data['msg'] = '<div class="col-lg-12">
			<h1 class="featurette-heading" style="margin-top:0px">Oondundu Mineral Resources</h1>          	
            <div>
                <span></span>
                <span></span>
                <span></span>
            </div>
            
            <h1>First featurette heading. <span class="text-muted">Itll blow your mind.</span></h1>
			<p class="lead">Donec ullamcorper nulla non metus auctor fringilla. Vestibulum id ligula porta felis euismod semper. Praesent commodo cursus magna, vel scelerisque nisl consectetur. Fusce dapibus, tellus ac cursus commodo.</p>
			<br>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum quis sem non risus scelerisque pellentesque nec et justo. Duis erat lacus, scelerisque gravida orci eu, pretium rutrum lorem. In mollis suscipit dictum. Aliquam erat volutpat. Curabitur quis vehicula justo, a tincidunt elit. Phasellus ut tincidunt mi. Nam nunc enim, tempor ut consectetur eu, dictum a magna. Aliquam nulla nisl, dictum in gravida et, sodales sit amet nulla.<br>
			<br>
			<blockquote>
				Aliquam nulla nisl, dictum in gravida et, sodales sit amet nulla.
			</blockquote>
			<br>
			Phasellus sagittis, lorem eget iaculis sollicitudin, eros lacus rhoncus leo, vel tristique lacus urna at tellus. Maecenas auctor hendrerit dui vitae feugiat. Phasellus tristique odio ut convallis vestibulum. Etiam viverra, ipsum non elementum luctus, nisl ipsum accumsan ante, a tincidunt dui sapien a turpis. Nullam lacinia risus scelerisque diam posuere, at malesuada nunc tristique. Morbi fermentum pretium sapien non mollis. Aliquam erat volutpat. Aenean adipiscing diam vitae magna vulputate, in viverra libero tempus. Sed congue sem sit amet quam venenatis feugiat. Aliquam commodo mi non nunc ultricies, eget placerat ante congue. Vivamus sed ornare neque, sit amet lobortis eros. Nunc sed tortor sem. Pellentesque ultricies porttitor erat rutrum suscipit. Suspendisse at turpis lacus.<br>
			Maecenas faucibus sagittis mi et porta. Vestibulum accumsan dui felis. Integer commodo mi at ipsum pretium pretium. Nullam congue orci non sollicitudin fringilla. Cras in mi molestie, vestibulum lectus ultrices, vehicula lacus. Nullam aliquam vitae elit nec egestas. Pellentesque ullamcorper, eros mollis vulputate ullamcorper, neque ante ullamcorper ipsum, nec rutrum nisl nulla ac sapien. Morbi ac rutrum purus. Sed accumsan tellus sapien, dignissim interdum sapien convallis sit amet. Cras posuere dui dui, eget condimentum quam posuere ac. Praesent iaculis rutrum molestie. In egestas vel libero ut faucibus.<br>
			<br>
			Suspendisse massa massa, molestie a nisl in, sollicitudin fermentum felis. Phasellus eu mi vitae leo hendrerit cursus eget ac neque. Mauris fringilla nulla id eros sollicitudin hendrerit. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Pellentesque vehicula nulla at velit luctus, id consequat velit ultrices. Etiam sagittis nec elit at pretium. Morbi vitae lobortis magna. In porta elit a condimentum vulputate. Sed imperdiet eros ac laoreet ultricies. Morbi sit amet ultricies purus. Nam interdum sapien nisi, feugiat ultricies dui lacinia et. Mauris eu turpis risus. Phasellus sem mauris, mattis sed facilisis quis, dignissim ac felis. Morbi sit amet posuere tellus, vitae vehicula turpis. Aenean et metus arcu.<br>
			<br>        </div>';

		$body1 = $data['msg'];

		$this->email->subject('Enquiry via the Website');
		$this->email->message($body1);
		//$this->email->attach('./img/icons/logo.png');

		$this->email->send();

		return;


	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET EMAILS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_emails($status = '')
	{

		if ($status == '')
		{
			$str = 'Emails';
			$bus_id = $this->session->userdata('bus_id');
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->get('emails');
		}
		else
		{

			$str = ucwords($status) . ' emails ';
			$bus_id = $this->session->userdata('bus_id');
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('status', $status);
			$query = $this->db->get('emails');

		}

		echo '<div class="box span12 noMargin" onTablet="span12" onDesktop="span12">
			<div class="box-header">
				<h2><i class="icon-list"></i><span class="break"></span>Emails</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div>
			</div>
			<div class="box-content">
			<div class="clearfix" style="width:100%"></div>';

		if ($query->result())
		{
			echo '
			<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
				<thead>
					<tr style="font-weight:bold">
						<th style="width:5%">Status</th>
						<th style="width:15%">Subject</th>
           				<th style="width:25%">Body </th>
           				<th style="width:5%" title="Open Rate" rel="tooltip">O/R </th>
           				<th style="width:5%" title="Click through Rate" rel="tooltip">CTR </th>
						<th style="width:5%">Sends </th>
						<th style="width:5%">Opens </th>
						<th style="width:5%">Clicks </th>
						<th style="width:5%">Unsubscribes </th>
						<th style="width:5%">Bounces </th>
						<th style="width:10%">Date</th>
						<th style="width:15%"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row)
			{

				$str = "'" . $row->email_id . "','yes' , 'product_reviews'";
				$str2 = "'" . $row->email_id . "','no' ,'product_reviews'";

				if ($row->status == 'sent')
				{
					$tool = 'title="Stop this review" rel="tooltip"';
					$button = '<span class="badge badge-success"><i title="Has been sent" rel="tooltip" class="icon-play icon-white"></i> Sent</span>';
					$button2 = '<a href="javascript:approve_review(' . $str2 . ')"><i class="icon-ban-circle"></i></a>';

				}
				else
				{
					$tool = 'title="Approve this review" rel="tooltip"';
					$button = '<span class="badge badge-important"><i title="Draft" rel="tooltip" class="icon-pause icon-white"></i> Draft</span>';
					$button2 = '<a href="javascript:approve_review(' . $str . ')"><i class="icon-ok"></i></a>';

				}

				$count = (array) (json_decode($row->recipients));
				$z = 0;

				if (count($count) > 0)
				{
					foreach ($count as $roww => $val)
					{
						//echo $roww . '<br />';
						$z = $z + count($val);

					}

				}


				if($row->sends != 0) {
					$ctr = ($row->clicks / $row->sends) * 100;
				} else {
					$ctr = 0;
				}
				

				if ($ctr <= 10)
				{

					$ctr = '<span class="badge badge-danger">' . round($ctr) . ' %</span>';
				}
				else
				{

					$ctr = '<span class="badge badge-success">' . round($ctr) . ' %</span>';
				}

				if($row->sends != 0) {

					$opr = ($row->unique_opens / $row->sends) * 100;

				} else {

					$opr = '';

				}

				if ($opr <= 10)
				{

					$opr = '<span class="badge badge-danger">' . round($opr) . ' %</span>';
				}
				else
				{

					$opr = '<span class="badge badge-success">' . round($opr) . ' %</span>';
				}
				echo '<tr id="tr-' . $row->email_id . '">
						<td style="width:5%">' . $button . '</td>
						<td style="width:15%"><a href="javascript:compose_email(' . $row->email_id . ');">' . $row->title . '</a></td>
						<td style="width:25%">' . $this->shorten_string(strip_tags($row->body), 15) . '</td>
						<td style="width:5%">' . $opr . '</td>
						<td style="width:5%">' . $ctr . '</td>
						<td style="width:5%">' . $row->sends . '</td>
						<td style="width:5%">' . $row->opens . '</td>
						<td style="width:5%">' . $row->clicks . '</td>
						<td style="width:5%">' . $row->unsubscribes . '</td>
						<td style="width:5%">' . ($row->soft_bounces + $row->hard_bounces) . '</td>
						<td style="width:10%">' . date('Y-m-d h:i', strtotime($row->datetime)) . '</td>

						<th style="width:15%; text-align:right"><a href="javascript:compose_email(' . $row->email_id . ');"  title="Continue editing" rel="tooltip" class="btn btn-mini"><i class="icon-pencil"></i></a>
							<a target="_blank" href="javascript:load_logs(' . $row->email_id . ');" title="View the email Analytics" rel="tooltip" class="btn btn-mini btn-success"><i class="icon-random icon-white"></i></a>
							<a target="_blank" href="javascript:delete_email(' . $row->email_id . ');" title="Delete the email" rel="tooltip" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
						</th>
					  </tr>';
			}


			echo '</tbody>
				</table>

				<hr />
				<div class="clearfix" style="height:30px;"></div>
				';

		}
		else
		{


			echo '<div class="alert">No ' . $str . ' Saved</div>';

		}

		echo '</div>
			</div><!--/span-->';

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET EMAILS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_email_count()
	{

		$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$q = $this->db->get('emails');

		$x = 0;
		$y = 0;
		$z = 0;
		if ($q->result())
		{

			foreach ($q->result() as $row)
			{

				if ($row->status == 'sent')
				{

					$y++;

				}
				if ($row->status == 'draft')
				{

					$z++;

				}

				$x++;

			}


		}

		echo '<a href="javascript:get_emails(' . "'draft'" . ')" class="quick-button span2" >
				<i class="fa-icon-download-alt" ></i >
				<p >Draft Emails </p >
				<span class="notification" >' . $z . '</span >
				</a >
				<a href="javascript:get_emails(' . "'sent'" . ')" class="quick-button span2" >
				<i class="fa-icon-share-alt" ></i >
				<p >Sent Emails </p >
				<span class="notification" >' . $y . '</span >
				</a >
				<a href="javascript:get_emails(' . "''" . ')" class="quick-button span2" >
				<i class="fa-icon-inbox" ></i >
				<p >Saved Emails </p >
				<span class="notification" >' . $x . '</span >
				</a >';

	}



	//+++++++++++++++++++++++++++
	//GET EMAIL LOGS
	//++++++++++++++++++++++++++
	public function get_email_logs($query, $date_from, $date_to, $tags, $senders, $limit)
	{

		//$this->load->model('email_model');
		$result = $this->get_email_logs_mandrill($query, $date_from, $date_to, $tags, $senders, $limit = 3000);
		//var_dump($result);
		//echo $query;
		if (count($result) > 0)
		{


			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" id="email_logs_tbl" class="table table-striped datatable"  width="100%">
						<thead>
							<tr style="font-size:14px">

								<th style="width:20%;font-weight:bold">To</th>
								<th style="width:20%;font-weight:bold">Subject </th>
								<th style="width:10%;font-weight:bold">Date </th>
								<th style="width:10%;font-weight:bold">Status </th>
								<th style="width:5%;font-weight:bold">Opens </th>
								<th style="width:5%;font-weight:bold">Clicks </th>
								<th style="width:20%;font-weight:bold">Data</th>
								<th style="width:10%;font-weight:bold"></th>
							</tr>
						</thead>
						<tbody>';

			foreach ($result as $row => $key)
			{


				if (is_array($key))
				{
					$str = '';
					foreach ($key as $subkey)
					{

						if (is_array($subkey))
						{
							$x = 0;
							foreach ($subkey as $subsubkey)
							{


								foreach ($subsubkey as $subsubsubkey => $s_key)
								{

									if ($subsubsubkey == 'destination_ip' || $subsubsubkey == 'location' || $subsubsubkey == 'ua')
									{

										if ($x < 3)
										{
											$str .= '<span class="badge">' . $s_key . ' </span> ';
										}
										$x++;
									}

								}
							}


						}

					}


				}
				$open = '<span class="badge badge-success">' . $key['opens'] . '</span>';
				if ($key['opens'] == 0)
				{

					$open = '<span class="badge badge-important">' . $key['opens'] . '</span>';

				}
				$clicks = '<span class="badge badge-success">' . $key['clicks'] . '</span>';
				if ($key['clicks'] == 0)
				{

					$clicks = '<span class="badge badge-important">' . $key['clicks'] . '</span>';

				}
				echo '<tr>

								<td style="width:20%">' . $key['email'] . '</td>
								<td style="width:20%">' . $key['subject'] . '</td>
								<td style="width:10%">' . date("D d M Y h:i:s A", $key['ts']) . '</td>
								<td style="width:10%">' . $key['state'] . '</td>
								<td style="width:5%">' . $open . '</td>
								<td style="width:5%">' . $clicks . '</td>
								<td style="width:20%;text-align:right">' . $str . '</td>
								<td style="width:10%;text-align:right">
								<a title="View Content" rel="tooltip" class="btn btn-mini disabled" style="cursor:pointer"
								onclick="view_enquiry()"><i class="icon-zoom-in"></i></a>
								<a title="Re-send Email" rel="tooltip" class="btn btn-mini btn-danger disabled" style="cursor:pointer" onclick="delete_enquiry()">
								<i class="icon-play icon-white"></i></a></td>
							  </tr>';

			}


			echo '</tbody>
						</table>
						<hr />
						<div class="clearfix" style="height:30px;"></div>
						<script type="text/javascript">

						</script>';


		}
		else
		{

			echo '<div class="alert">No Emails have been sent in the last 30 days</div>';


		}


	}

	//+++++++++++++++++++++++++++
	//GET EMAIL LOGS
	//++++++++++++++++++++++++++
	public function get_email_stats($query, $date_from, $date_to, $tags, $senders, $limit)
	{


		$this->load->config('mandrill');

		$this->load->library('mandrill');

		$mandrill_ready = null;

		try
		{

			$this->mandrill->init($this->config->item('mandrill_api_key'));
			$mandrill_ready = true;
			$result = 'yes';
		}
		catch (Mandrill_Exception $e)
		{
			echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			$mandrill_ready = false;
			$result = 'no';
			throw $e;
		}

		if ($mandrill_ready)
		{


			$result = $this->mandrill->tags_list();

		}

		//var_dump($result);
		return $result;
		//var_dump($result);
		//echo $query;
		if (count($result) > 0)
		{


		}


	}



	//+++++++++++++++++++++++++++
	//GET EMAIL LOGS
	//++++++++++++++++++++++++++
	public function get_email_logs_mandrill($query, $date_from, $date_to, $tags, $senders, $limit)
	{


		/*		echo "
				<div id='response'></div>
				<script type='text/javascript' src='https://mandrillapp.com/api/docs/js/mandrill.js'></script>
				<script type='text/javascript'>

						function onSuccessLog(arr) {
							$('#response').append('<h2>' + JSON.stringify(arr.length) + ' messages match your search</h2>');
							if (arr.length >= 1) {
							  for (var i=0; i < arr.length; i++) {
								$('#response').append('<h3>Message ' + (i+1) + ': ' + JSON.stringify(arr[i].email) + '</h3><ol>');
								$('#response').append('<li>Date: ' + Date(JSON.stringify(arr[i].ts) * 1000).toString() + '</li>');
								$('#response').append('<li>Subject: ' + JSON.stringify(arr[i].subject) + '</li>');
								$('#response').append('<li>State: ' + JSON.stringify(arr[i].state) + '</li></ol>');
								}
							}
						}

						function onErrorLog(obj) {
							$('#response').text(JSON.stringify(obj));
						}

						// create a new instance of the Mandrill class with your API key
						var m = new mandrill.Mandrill('d3tAlotpZNobGiCfRk3Miw');

						params = {

							".'"limit":"15",
							"senders":["no-reply@bcxgroup.com"]'."
						};
						// get the results for messages.search using the parameters from above

						m.messages.search(params, function(res) {
								onSuccessLog(res);
							}, function(err) {
								onErrorLog(err);
							}
						);

				</script>
				";*/


		$this->load->config('mandrill');

		$this->load->library('mandrill');

		$mandrill_ready = null;

		try
		{

			$this->mandrill->init($this->config->item('mandrill_api_key'));
			$mandrill_ready = true;
			$result = 'yes';
		}
		catch (Mandrill_Exception $e)
		{
			echo 'A mandrill error occurred: ' . get_class($e) . ' - ' . $e->getMessage();
			$mandrill_ready = false;
			$result = 'no';
			throw $e;
		}

		if ($mandrill_ready)
		{


			$result = $this->mandrill->messages_search($query, $date_from, $date_to, $tags, $senders, $limit);

		}

		//var_dump($result);
		return $result;


	}


	//+++++++++++++++++++++++++++
	//GET EMAIL CONTENT
	//++++++++++++++++++++++++++
	public function get_deal_content()
	{

		if ($this->session->userdata('bus_id') == 336)
		{

			$this->get_deal_content_trip();

		}
		else
		{
			$this->get_myna_product_content();

		}

	}

	//+++++++++++++++++++++++++++
	//GET EMAIL CONTENT
	//++++++++++++++++++++++++++
	public function get_deal_content_trip()
	{
		$this->load->model('my_namibia_model');

		$db = $this->my_namibia_model->connect_trip_db();

		$db->where('DATE_TO >=', date("Y-m-d H:i:s", strtotime("-1 day")));
		$q = $db->get('itineraries');

		if ($q->result())
		{
			echo '<div style="height:300px; overflow-y: scroll">
					<ul class="nav nav-pills nav-stacked">';
			foreach ($q->result() as $row)
			{

				$title = ucwords(filter_var(utf8_decode($row->TITLE), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
				echo '<li id="it-' . $row->ID . '"><a href="javascript:add_content(' . "'itineraries'," . $row->ID . ');">' . $this->shorten_string($title, 6) . ' <i class="icon-plus pull-right"></i></a></li>';
				//echo $row->TITLE;


			}
			echo '</ul>
				</div>';
		}


	}

	//+++++++++++++++++++++++++++
	//GET EMAIL CONTENT
	//++++++++++++++++++++++++++
	public function get_myna_product_content()
	{
		$this->load->model('my_namibia_model');

		$db = $this->my_namibia_model->connect_my_db();

		$db->where('bus_id', $this->session->userdata('bus_id'));
		$db->where('status', 'live');

		$db->order_by('listing_date', 'DESC');
		$db->limit(30);
		$q = $db->get('products');

		if ($q->result())
		{
			echo '<div style="height:300px; overflow-y: scroll">
					<ul class="nav nav-pills nav-stacked">';
			foreach ($q->result() as $row)
			{

				$title = ucwords(filter_var(utf8_decode($row->title), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
				echo '<li id="it-' . $row->product_id . '"><a href="javascript:add_content(' . "'products'," . $row->product_id . ');">' . $this->shorten_string($title, 6) . ' <i class="icon-plus pull-right"></i></a></li>';
				//echo $row->TITLE;


			}
			echo '</ul>
				</div>';
		}


	}




	//+++++++++++++++++++++++++++
	//GET EMAIL CONTENT
	//++++++++++++++++++++++++++
	public function get_cms_product_content()
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT * FROM products WHERE bus_id = '" . $bus_id . "' ORDER BY title ASC");

		if ($query->result())
		{
			echo '<div style="height:300px; overflow-y: scroll">
					<ul class="nav nav-pills nav-stacked">';
			foreach ($query->result() as $row)
			{

				$title = ucwords(filter_var(utf8_decode($row->title), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
				echo '<li id="it-' . $row->product_id . '"><a href="javascript:add_cms_content(' . "'products'," . $row->product_id . ');">' . $this->shorten_string($title, 6) . ' <i class="icon-plus pull-right"></i></a></li>';
				//echo $row->TITLE;


			}
			echo '</ul>
				</div>';
		}


	}




	//+++++++++++++++++++++++++++
	//EMAIL MARKETING BUILD CONTENT
	//++++++++++++++++++++++++++
	function build_email_content($type, $id)
	{
		$this->load->model('my_namibia_model');

		if ($type == 'itineraries')
		{

			$db = $this->my_namibia_model->connect_trip_db();

			//$q = $db->where('ID', $id);
			$q = $db->query("SELECT itineraries.*, itineraries_images.IMAGE_NAME, itineraries_images.IMAGE_EXTENSION , continents.TITLE as CONTINENT,
							countries.TITLE as COUNTRY

							FROM itineraries
							JOIN itineraries_images ON itineraries.ID = itineraries_images.ITINERARY_FK
							JOIN itineraries_countries ON itineraries.ID = itineraries_countries.ITINERARY_FK
							JOIN countries ON itineraries_countries.COUNTRY_FK = countries.ID
							JOIN continents ON countries.CONTINENT_FK = continents.ID

							WHERE itineraries.ID = '" . $id . "' LIMIT 1");
			$out = 'NONE';
			if ($q->result())
			{


				$row = $q->row();

				//IMAGES
				if ($row->BANNER_IMAGE_NAME != '')
				{

					$img1 = base_url('/') . 'img/timbthumb.php?src=http://trip.com.na/public/uploads/images/itineraries/' . $row->BANNER_IMAGE_NAME . '_big' . $row->BANNER_IMAGE_EXTENSION . '&w=560';


				}
				else
				{

					$img1 = base_url('/') . 'img/timbthumb.php?src=http://trip.com.na/public/uploads/images/itineraries/' . $row->IMAGE_NAME . '_big' . $row->IMAGE_EXTENSION . '&w=560';
				}

				$url = 'http://trip.com.na/view/destinations/' . $this->clean_url_str($row->CONTINENT, '', '_') . '/' . $this->clean_url_str($row->COUNTRY, '', '_') . '/' . $row->SLUG;

				$date = date('Y-m-d', strtotime($row->DATE_FROM)) . ' til ' . date('Y-m-d', strtotime($row->DATE_TO));
				$title = ucwords(filter_var(utf8_decode($row->TITLE), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
				$descr = ucwords(filter_var(utf8_decode($row->DESCRIPTION), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));

				$out = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td colspan="2">
									<h1>' . $title . '</h1>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<h4>Valid From ' . $date . '</h4>
								</td>
							</tr>
							<tr>
								<td colspan="2">
									<img src="' . $img1 . '" style="max-width:560px" alt="Download Image To view" title="Download Image To view" mc:label="body_image" mc:edit="body_image" mc:allowtext >
									<br />
								</td>
							</tr>
							<tr>
								<td colspan="2">
									' . $this->shorten_string(strip_slashes(html_entity_decode($descr)), 50) . '
								</td>
							</tr>
							<tr>
								<td style="width:45%;text-align:center">
									<h1><span style="font-size:15px">N$</span> ' . number_format($row->PRICE) . ' <span style="font-size:15px">per Adult</span></h1>
								</td>
								<td style="width:45%;text-align:center">
									<a href="' . $url . '/" class="btn" style="text-decoration:none; color:#fff">View</a>
								</td>
							</tr>
						</table>
						<p>&nbsp;</p>
						<br /><br />
						<img src="' . base_url('/') . 'img/email/trip/hr.jpg">
						<br /><br />
						<p>&nbsp;</p>
						';


			}
			echo $out;

		}
		else
		{

			$this->load->model('my_namibia_model');
			$this->load->model('trade_model');
			$db = $this->my_namibia_model->connect_my_db();
			$settings = $this->admin_model->get_settings();
			$q = $db->query("SELECT u_business.BUSINESS_NAME,
                                      products.*,products_buy_now.amount,products_buy_now.buy_now_id, trade_rating.rating, trade_rating.review, trade_rating.created_at,
                                      product_extras.*,product_images.img_file, product_questions.question_id,product_categories.category_name,
                                      group_concat(trade_rating.rating,'-_-',trade_rating.type,'-_-',REPLACE(trade_rating.review, ',', ' '),'-_-',trade_rating.created_at) as rating_a,
                                      MAX(product_auction_bids.amount) as current_bid
                                      FROM products
                                      JOIN u_client ON u_client.ID = products.client_id
                                      LEFT JOIN product_extras ON products.product_id = product_extras.product_id
                                      LEFT JOIN product_categories ON product_categories.cat_id = products.sub_sub_cat_id
                                      LEFT JOIN products_buy_now ON products.product_id = products_buy_now.product_id
                                      LEFT JOIN u_business ON products.bus_id = u_business.ID
                                      LEFT JOIN trade_rating ON trade_rating.buy_now_id = products_buy_now.buy_now_id
                                      LEFT JOIN product_images ON products.product_id = product_images.product_id
                                      LEFT JOIN product_questions ON product_questions.product_id = products.product_id
                                      LEFT JOIN product_auction_bids ON product_auction_bids.product_id = products.product_id AND product_auction_bids.type = 'bid'
							        WHERE products.product_id = '" . $id . "' GROUP BY products.product_id LIMIT 1");
			$out = 'NONE';
			if ($q->result()) {


				$row = $q->row();

				//IMAGES
				if ($row->img_file != '') {

					$img1 = base_url('/') . 'img/timbthumb.php?src=' . NA_SITE_URL . 'assets/products/images/' . $row->img_file . '&w=580&h=300';


				} else {

					$img1 = base_url('/') . 'img/product_blank.jpg';
				}

				$url = $settings['url'] . 'product/' . $row->product_id . '/' . $this->clean_url_str($row->title, '', '_') . '/';

				$date = date('Y-m-d', strtotime($row->start_date)) . ' til ' . date('Y-m-d', strtotime($row->end_date));
				$title = ucwords(filter_var(utf8_decode($row->title), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
				$descr = ucwords(filter_var(utf8_decode($row->description), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
				$extras = $this->trade_model->show_extras_short($row->extras);

				$ex_str = '<td colspan="2" style="width:45%;padding: 20px 10px;vertical-align:top">
									' . $this->shorten_string(strip_slashes(html_entity_decode($descr)), 100) . '
							</td>';
				if (strlen($extras) > 2) {

					$ex_str = '<td style="width:45%;text-align:left ;padding: 10px">
									' . $extras . '
								</td>
								<td  style="width:45%;padding: 20px 10px;vertical-align:top">
									' . $this->shorten_string(strip_slashes(html_entity_decode($descr)), 100) . '
								</td>';

				}

				//IF BUY NOW
				if ($row->listing_type == 'S') {
					if ($row->status == 'sold') {
						$price['str'] = ' Sold';
					} else {
						if ($row->sub_cat_id == 3410) {
							$price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->trade_model->smooth_price($row->sale_price) . '</span> pm';
						} else {
							$price['str'] = '<span style=" font-size:12px">N$</span><span itemprop="price"> ' . $this->trade_model->smooth_price($row->sale_price) . '</span>';
						}
						if ($row->por == 'Y') {

							$price['str'] = '<span itemprop="price"> POR</span> <span style=" font-size:12px">Price On Request</span>';

						}

					}

				} else {

					$price = $this->trade_model->get_current_bid($row->current_bid) ;
					$price['str'] = $price['str'] .' <span style="font-size:10px">Current Bid</span>';

				}

				$ribbon = $this->trade_model->get_product_ribbon($row->product_id, $row->extras, $row->featured, $row->listing_type, $row->start_price, $row->sale_price, $row->start_date, $row->end_date, $row->listing_date, $row->status, '_sml');
				$out = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td colspan="2" style="padding: 10px;text-align:center;" align="center">

									<h1 align="center" style="text-align:center; font-size:50px;color:'.$settings['brand_primary'].';" class="upper yellow big_icon">' . $title . '</h1>
								</td>
							</tr>
							<tr>
								<td colspan="2" style="padding: 10px">
									<h2>' . $ribbon . '</h2>
								</td>
							</tr>
							<tr >
								<td colspan="2" style="padding: 10px"  class="white_box">
									<img src="' . $img1 . '" class="inline_img" style="max-width:580px" alt="Download Image To view" title="Download Image To view">
									<br />
								</td>
							</tr>
							<tr>
							    ' . $ex_str . '
							</tr>
							<tr>
								<td style="width:45%;text-align:center ;padding: 10px">
									<h1> ' . $price['str'] . ' </h1>
								</td>
								<td style="width:45%;text-align:right;padding: 10px">
									<a href="' . $url . '/" class="btn" style="text-decoration:none;color:#fff">View Item</a>
								</td>
							</tr>
							<tr>
							    <td colspan="2"><p>&nbsp;</p></td>
							</tr>
						</table>
						<br />

						<p>&nbsp;</p>
						';


			}
			echo $out;



		}

	}







	//+++++++++++++++++++++++++++
	//EMAIL MARKETING BUILD CONTENT
	//++++++++++++++++++++++++++
	function build_cms_email_content($type, $id)
	{

		$bus_id = $this->session->userdata('bus_id');

		if($type = 'products') {

			$settings = $this->admin_model->get_settings();
			$q = $this->db->query("SELECT *, A.title AS product_title, A.slug AS product_slug FROM products AS A
		  						   LEFT JOIN product_cats AS B on A.category = B.cat_id
								   LEFT JOIN product_types AS C on A.product_type = C.type_id
								   LEFT JOIN images AS D on A.product_id = D.type_id AND D.type = 'product' AND D.bus_id = '" . $bus_id . "'
								   WHERE A.bus_id = '" . $bus_id . "' AND A.product_id = '" . $id . "'
									");
			$out = 'NONE';
			if ($q->result()) {


				$row = $q->row();

				//IMAGES
				if ($row->img_file != '') {

					$img1 = CMS_URL . 'assets/images/' . $row->img_file;


				} else {

					$img1 = base_url('/') . 'img/product_blank.jpg';
				}

				$url = $settings['url'] . '/product/' . $row->product_slug . '/';

				$title = ucwords(filter_var(utf8_decode($row->product_title), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
				$descr = ucwords(filter_var(utf8_decode($row->description), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));

				if($row->sale_price != '0.00') {
					$price = 'Was <span style="text-decoration: line-through">N$'.$row->start_price.'</span><br>Now N$'.$row->sale_price;
				} else {
					$price = 'N$'.$row->start_price;

				}



				$out = '<table border="0" cellpadding="0" cellspacing="0" width="100%">
							<tr>
								<td colspan="2" style="padding: 10px;text-align:center;" align="center">

									<h2 align="center" style="text-align:center; font-size:50px;color:' . $settings['brand_primary'] . ';" class="upper yellow big_icon">' . $title . '</h2>
								</td>
							</tr>
							<tr >
								<td colspan="2" style="padding: 10px; text-align:center"  class="white_box">
									<img src="' . $img1 . '" class="inline_img" style="max-width:300px" alt="Download Image To view" title="Download Image To view">
									<br />
								</td>
							</tr>
							<tr>
								<td style="width:45%;text-align:center ;padding: 10px">
									<h1> ' . $price . ' </h1>
								</td>
								<td style="width:45%;text-align:right;padding: 10px">
									<a href="' . $url . '" class="btn" style="text-decoration:none;color:#fff">View Item</a>
								</td>
							</tr>
							<tr>
							    <td colspan="2"><p>&nbsp;</p></td>
							</tr>
						</table>
						<br />


						';


			}
			echo $out;

		}
	}


	function show_newsletter_email($email_id){

		$str = '';

		$q = $this->db->query("SELECT * FROM email_templates WHERE template_id = 8 ");

		if ($q->result()) {

			$row = $q->row();

			$str .= $row->header;

			$q2 = $this->db->query("SELECT * FROM emails WHERE email_id = $email_id ");

			if ($q2->result()) {

				$row2 = $q2->row();

				$str .= '<h2>'.$row2->title.'</h2>';

				$str .= $row2->body;
			}


			$str .= $row->footer;

		}

		return $str;

	}






	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace = array(), $delimiter = '-')
	{
		if (! empty($replace))
		{
			$str = str_replace((array) $replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
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

}

?>
