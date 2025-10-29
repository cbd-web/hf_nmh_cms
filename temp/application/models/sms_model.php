<?php
class Sms_model extends CI_Model{
	
 	function sms_model(){
  		//parent::CI_model();


 	}




	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET SMS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_sms($status = '')
	{

		if($status == ''){
			$str = 'SMS';
			$bus_id = $this->session->userdata('bus_id');
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->get('sms');
		}else{

			$str = ucwords($status). ' sms ';
			$bus_id = $this->session->userdata('bus_id');
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('status', $status);
			$query = $this->db->get('sms');

		}

		$bus_id = $this->session->userdata('bus_id');
		$settings = $this->db->where('bus_id', $bus_id);
		$settings = $this->db->get('sms_config');

		if($settings->result())
		{
			$settings = $settings->row_array();
			$sms_rate = ($settings['sms_rate'] / 100);
			$shortcode = $settings['shortcode'];

			echo '<div class="box span12 noMargin" onTablet="span12" onDesktop="span12">
			<div class="box-header">
				<h2><i class="icon-list"></i><span class="break"></span>SMS</h2>
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
		                        <th style="width:30%">Body </th>
								<th style="width:5%">Count </th>
								<th style="width:15%">Cost</th>
								<th style="width:15%">Date</th>
								<th style="width:15%"></th>
							</tr>
						</thead>
						<tbody>';

				foreach ($query->result() as $row)
				{
					//GET COUNT
					$cost = 0; $total_sends = 0;
					$c =$this->db->query("SELECT COUNT(*) as total FROM sms_queue_log WHERE bus_id = '".$bus_id."' AND sms_id = '".$row->sms_id."'");
					if($c->result()){

						$crow = $c->row();
						$total_sends = $crow->total;
						$cost = $crow->total * $sms_rate;

					}

					$str = "'" . $row->sms_id . "','yes' , 'product_reviews'";
					$str2 = "'" . $row->sms_id . "','no' ,'product_reviews'";

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

					$total = $z * $sms_rate;

					echo '<tr id="tr-' . $row->sms_id . '">
						<td style="width:5%">' . $button . '</td>
						<td style="width:15%"><a href="javascript:compose_sms(' . $row->sms_id . ');">' . $row->title . '</a></td>
						<td style="width:30%">' . $this->shorten_string(strip_tags($row->body), 15) . '</td>
						<td style="width:5%">' . $total_sends. '</td>
						<td style="width:15%"><div class="btn btn-mini btn-success">Total N$ ' . number_format($cost , 2) . '</div></td>
						<td style="width:15%">' . date('Y-m-d h:i', strtotime($row->datetime)) . '</td>
						<th style="width:15%; text-align:right"><a href="javascript:compose_sms(' . $row->sms_id . ');"  title="Continue editing" rel="tooltip" class="btn btn-mini"><i class="icon-pencil"></i></a>
							<a target="_blank" href="javascript:load_logs(' . $row->sms_id . ');" title="View the sms Analytics" rel="tooltip" class="btn btn-mini btn-success"><i class="icon-random icon-white"></i></a>
							<a target="_blank" href="javascript:delete_sms(' . $row->sms_id . ');" title="Delete the sms" rel="tooltip" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
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

		}else{

			echo 'No SMS Config Found';

		}

	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET SMS COSTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_sms_costs($month = '')
	{

		$bus_id = $this->session->userdata('bus_id');
		$settings = $this->db->where('bus_id', $bus_id);
		$settings = $this->db->get('sms_config');

		$total = 0;
		if($settings->result())
		{
			$settings = $settings->row_array();
			$sms_rate = ($settings['sms_rate'] / 100);
			$shortcode = $settings['shortcode'];
			$limit = $settings['limit'];

			if($month != ''){

				$q =$this->db->query("SELECT COUNT(*) as total FROM sms_queue_log WHERE bus_id = '".$bus_id."' AND YEAR(datetime) = YEAR(CURDATE()) AND MONTH(datetime) = MONTH(CURDATE())");

			}else{

				$q =$this->db->query("SELECT COUNT(*) as total FROM sms_queue_log WHERE bus_id = '".$bus_id."'");

			}

			if($q->result()){

				$row = $q->row();
				$total = $row->total * $sms_rate;

			}

			echo $total;

		}else{

			echo 'No SMS Config Found';

		}


	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET SMS COSTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function cost_dashboard($month = '')
	{

		$bus_id = $this->session->userdata('bus_id');
		$settings = $this->db->where('bus_id', $bus_id);
		$settings = $this->db->get('sms_config');

		$total = 0;
		if($settings->result())
		{
			$settings = $settings->row_array();
			$sms_rate = ($settings['sms_rate'] / 100);
			$shortcode = $settings['shortcode'];
			$limit = $settings['limit'];

			if($month != ''){

				$q =$this->db->query("SELECT COUNT(*) as total FROM sms_queue_log WHERE bus_id = '".$bus_id."' AND YEAR(datetime) = YEAR(CURDATE()) AND MONTH(datetime) = MONTH(CURDATE())");

			}else{

				$q =$this->db->query("SELECT COUNT(*) as total FROM sms_queue_log WHERE bus_id = '".$bus_id."'");

			}

			if($q->result()){

				$row = $q->row();
				$total = $row->total * $sms_rate;
				$total_sent = $row->total;

			}

			echo '<div class="row-fluid">

                    <div class="span4  text-center" onTablet="span4" onDesktop="span4">
						<div class="circleStatsItem lightorange">
							<i class="fa-icon-bar-chart"></i>
							<span class="percent">%</span>
							<input type="text" value="'.(($total / $limit) * 100).'" class="lightOrangeCircle" />
						</div>
						<div class="box-small-title">Monthly Usage</div>
					</div>
					<div class="span4 text-center" onTablet="span4" onDesktop="span4">
                    	<div class="circleStatsItem green">
                        	<i class="fa-icon-money"></i>

							<span class="percent">N$</span>
                        	<input type="text" value="'.number_format($total,2).'" class="greenCircle" />
                    	</div>
						<div class="box-small-title">Total Cost</div>
					</div>

					<div class="span4 text-center" onTablet="span4" onDesktop="span4">
                    	<div class="circleStatsItem blue" >
							<i class="fa-icon-dashboard"></i>
                        	<input type="text" value="'.$total_sent.'" class="blueCircle"  />
                    	</div>
						<div class="box-small-title">SMS Sent</div>
					</div>
				</div>
					';


			echo '<script>

					$(document).ready(function(e) {

							$(".greenCircle").knob({
								"min":0,
								"max":'.$limit.',
								"readOnly": true,
								"width": 120,
								"height": 120,
								"fgColor": "#b9e672",
								"dynamicDraw": true,
								"thickness": 0.2,
								"tickColorizeValues": true,
								"skin":"tron"
							});
							$(".lightOrangeCircle").knob({
								"min":0,
								"max":"100",
								"readOnly": true,
								"width": 120,
								"height": 120,
								"fgColor": "#f4a70c",
								"dynamicDraw": true,
								"thickness": 0.2,
								"tickColorizeValues": true,
								"skin":"tron"
							});
							$(".blueCircle").knob({
								"min":0,
								"max":'.($limit / $sms_rate) .',
								"readOnly": true,
								"width":120,
								"height": 120,
								"fgColor": "#2FABE9",
								"dynamicDraw": true,
								"thickness": 0.2,
								"tickColorizeValues": true,
								"skin":"tron"
							});

					});
				</script>';


		}else{

			echo 'No SMS Config Found';

		}


	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET ESMS COUNT
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function get_sms_count()
	{

		$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$q = $this->db->get('sms');

		$x = 0; $y = 0;$z = 0;
		if($q->result()){

			foreach($q->result() as $row){

				if($row->status == 'sent'){

					$y ++;

				}
				if($row->status == 'draft'){

					$z ++;

				}

				$x ++;

			}


		}

		echo '<a href="javascript:get_smss('."'draft'".')" class="quick-button span2" >
				<i class="fa-icon-download-alt" ></i >
				<p >Draft SMSs </p >
				<span class="notification" >'.$z.'</span >
				</a >
				<a href="javascript:get_smss('."'sent'".')" class="quick-button span2" >
				<i class="fa-icon-share-alt" ></i >
				<p >Sent SMSs </p >
				<span class="notification" >'.$y.'</span >
				</a >
				<a href="javascript:get_smss('."''".')" class="quick-button span2" >
				<i class="fa-icon-inbox" ></i >
				<p >Saved SMSs </p >
				<span class="notification" >'.$x.'</span >
				</a >';

	}



	//++++++++++++++++++++++++++++++++++++++++++++
	//SEND SMS
	//++++++++++++++++++++++++++++++++++++++++++++
	function send_sms()
	{
		if($this->session->userdata('admin_id')){
			//GET EMAIL FILDS
			$recipients = $this->input->post('recipients',TRUE);
			$subject = $this->input->post('title',TRUE);
			$body = $this->input->post('content',FALSE);
			$type = $this->input->post('stype',FALSE);
			$subscriber_category = $this->input->post('subscriber_category',FALSE);
			$sms_id = $this->input->post('sms_id',FALSE);
			$bus_id = $this->session->userdata('bus_id');
			$count = 0;
			$rec_array = array();
			//GET BUSINESS DETAILS
			$settings = $this->admin_model->get_settings();
			$business = $settings['title'];


			//INSERT AS SENT EMAIL INTO EMAILS TABLE
			//INSERT INTO EMAILS
			$insert['bus_id'] = $bus_id;
			$insert['title'] = $subject;
			$insert['body'] = $body;
			$insert['status'] = 'sent';
			$insert['admin_id'] =   $this->session->userdata('admin_id');

			if($sms_id == 0){
				$this->db->insert('sms', $insert);
				$sms_id = $this->db->insert_id();
			}else{



			}


			//CREDIT LIMITS
			$sms_settings = $this->db->where('bus_id', $bus_id);
			$sms_settings = $this->db->get('sms_config');

			$total = 0;
			if($sms_settings->result())
			{
				$sms_settings = $sms_settings->row_array();
				$sms_rate = ($sms_settings['sms_rate'] / 100);
				$shortcode = $sms_settings['shortcode'];
				$limit = $sms_settings['limit'];
				$total = 0;
			}else{

				echo '<div class="alert alert-warning">Credit Limit Reached!</div>';
				die();
				return false;
			}

			//USAGE
			$sms_usage = $this->db->query("SELECT COUNT(bus_id) as count FROM sms_queue_log WHERE bus_id = '".$bus_id."' AND YEAR(datetime) = YEAR(CURDATE()) AND MONTH(datetime) = MONTH(CURDATE())");
			if($sms_usage->result()){
				$urow = $sms_usage->row();
				$sms_usage = $urow->count;
				$sms_usage = $sms_usage * $sms_rate;

			}else{

				$sms_usage = 0;
			}



			//ALL SELECTED
			if(isset($_POST['selectall'])){

				//SUBSCRIBERS OR EXHIBITORS
				if($subscriber_category != ''){

					$query = $this->db->where('type', $subscriber_category);
					$query = $this->db->where('bus_id', $bus_id);
					$query = $this->db->where('phone !=', '');
					$query = $this->db->get('subscribers');

				}else{

					$query = $this->db->where('bus_id', $bus_id);
					$query = $this->db->where('phone !=', '');
					$query = $this->db->get('subscribers');

				}

				foreach($query->result() as $row){

					//CREDIT LIMIT
					if($sms_usage >= $limit){
						$str = "You have reached your credit limit";
						echo "<script>var options = {'text':'".$str."','layout':'bottomLeft','type':'error'};
					            noty(options);
								 $('#send_sms_yes').html('Sent');
								 $('#modal-sms').modal('hide');
								</script>";
						die();
					}else{
						//SEND MANDRILL
						$from_email =  $settings['contact_email'];


						$data2['body'] = $body;

						$body1 = $body;


						$data['admin_id'] = $this->session->userdata('admin_id');

						//VALIDATE MOBILE NUMBER
						$val = $this->validate_cell($row->phone);

						if($val['bool']){
							$data['shortcode'] = $settings['contact_email'];
							$data['from_name'] = $settings['title'];
							$data['sms_id'] = $sms_id;
							$data['subject'] = $subject;
							$data['body'] = $body1;
							$data['phone'] = $val['phone'];
							$data['bus_id'] = $bus_id;
							$data['to_name'] = $row->name . ' '.$row->sname;

							$this->db->insert('sms_queue',$data);
							//BUILD RECIPIENT ARRAY
							array_push($rec_array, $row->subscriber_id);

							//CREDIT LIMIT
							$total = $total + $sms_rate;
							$sms_usage = $sms_usage + $total;
							$count ++;
						}else{

							//REPORT BAD NUMBER
							$error['bus_id'] = $bus_id;
							$error['subscriber_id'] = $row->subscriber_id;
							$error['error'] = $val['error'].'-'.$val['phone'];
							$this->db->insert('sms_error', $error);

						}



					}



				}


				$insert['recipients'] = json_encode($rec_array);
				if($sms_id == 0){
					$this->db->insert('sms', $insert);

				}else{
					$this->db->where('sms_id', $sms_id);
					$r = $this->db->get('sms');
					$rr = $r->row_array();
					if($rr['recipients'] != '' && $rr['recipients'] != 'null'){

						$temp = json_decode($rr['recipients']);

						if(count($temp) > 0){

							foreach((array)$temp as $tv){

								array_push($rec_array, $tv);
							}

						}

						$insert['recipients'] = json_encode($rec_array);


					}
					//var_dump($rec_array);
					$this->db->where('sms_id', $sms_id);
					$this->db->update('sms', $insert);

				}

				//echo $row['fname'] .' '.$row['sname'].'<br />';

				//var_dump($rec_array[$type]);

				//SUCCESS MESSAGE
				$this->session->set_flashdata('msg',$count.' SMS sent');
				$str = "Successfully queued ".$count." SMSs.";
				echo "<script>var options = {'text':'".$str."','layout':'bottomLeft','type':'success'};
						  noty(options);
						   $('#send_sms_yes').html('Sent');
						   $('#modal-sms').modal('hide');
						  </script>";


				//ONLY SELECTED
			}elseif(!empty($_POST['recipients'])) {

				$num = count($_POST['recipients']);
				foreach($_POST['recipients'] as $value)
				{

					//CREDIT LIMIT
					if ($sms_usage >= $limit)
					{
						$str = "You have reached your credit limit";
						echo "<script>var options = {'text':'".$str."','layout':'bottomLeft','type':'error'};
					            noty(options);
								 $('#send_sms_yes').html('Sent');
								 $('#modal-sms').modal('hide');
								</script>";
						die();
					}
					else
					{

						$row = $this->get_subscriber($value);

						$body1 = $body;

						$data['admin_id'] = $this->session->userdata('admin_id');

						//VALIDATE MOBILE NUMBER
						$val = $this->validate_cell($row['phone']);
						//var_dump($val);
						if($val['bool'])
						{

							$data['shortcode'] = $settings['contact_email'];
							$data['from_name'] = $settings['title'];
							$data['sms_id'] = $sms_id;
							$data['subject'] = $subject;
							$data['body'] = $body1;
							$data['phone'] = $val['phone'];
							$data['bus_id'] = $bus_id;
							$data['to_name'] = $row['name'] . ' ' . $row['sname'];

							$this->db->insert('sms_queue', $data);

							//BUILD RECIPIENT ARRAY
							array_push($rec_array, $value);
							$count++;

							//CREDIT LIMIT
							$total = $total + $sms_rate;
							$sms_usage = $sms_usage + $total;
						}else{

							//REPORT BAD NUMBER
							$error['bus_id'] = $bus_id;
							$error['subscriber_id'] = $value;
							$error['error'] = $val['error'].'-'.$val['phone'];
							$this->db->insert('sms_error', $error);

						}

					}
				}
				$insert['recipients'] = json_encode($rec_array);
				if($sms_id == 0){
					$this->db->insert('sms', $insert);

				}else{
					$this->db->where('sms_id', $sms_id);
					$r = $this->db->get('sms');
					$rr = $r->row_array();
					if($rr['recipients'] != '' && $rr['recipients'] != 'null'){

						$temp = json_decode($rr['recipients']);

						if(count($temp) > 0){

							foreach((array)$temp as $tv){

								array_push($rec_array, $tv);
							}

						}

						$insert['recipients'] = json_encode($rec_array);


					}
					//var_dump($rec_array);
					$this->db->where('sms_id', $sms_id);
					$this->db->update('sms', $insert);

				}
				//var_dump($rec_array);
				//LOG ACTION
				$this->admin_model->system_log('sent_sms-'. $count);
				//SUCCESS MESSAGE
				$this->session->set_flashdata('msg',$count.' SMS s sent');
				$str = "Successfully  queued ".$count." SMSs.";
				echo "<script>var options = {'text':'".$str."','layout':'bottomLeft','type':'success'};
					            noty(options);
								 $('#send_sms_yes').html('Sent');
								 $('#modal-sms').modal('hide');
								</script>";


				//NO RECIPIENTS SELECTED
			}else{

				$this->session->set_flashdata('msg','Please select some recipients.');
				$str = "Please select some recipients.";
				echo "<script>var options = {'text':'".$str."','layout':'bottomLeft','type':'error'};
					  noty(options);
					   $('#send_sms_yes').html('Yes, Send');
					   $('#modal-sms').modal('hide');
					  </script>";


			}
			//echo 'Only selected<br />Recipients: '.$recipients.'<br />Title: ',$subject.'<br />Body: '.$body.'<br />count: '.$count .' = ' .$num;



			//NOT LOGGED IN
		}else{

			redirect('/admin/logout/', 'refresh');

		}

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SMS LOGS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function load_sms_logs($id = '')
	{

		$bus_id = $this->session->userdata('bus_id');
		$settings = $this->db->where('bus_id', $bus_id);
		$settings = $this->db->get('sms_config');


		if($settings->result()){

			$settings = $settings->row_array();

			//var_dump($settings);

			$sms_rate = ($settings['sms_rate'] / 100);
			$shortcode = $settings['shortcode'];

				if($id != ''){

					$this->db->where('sms_id', $id);
					$q = $this->db->get('sms_queue_log');

					$str = 'SMS logs for: ';

					if($q->result()){

						$row = $q->row();

						$query = 'campaign:"'.$row->title.'"';
						$str = 'SMS logs for: '.$row->title;
					}



				}else
				{

					$str = 'All SMS logs';
					$query = '*';
					$this->db->where('bus_id', $bus_id);
					$q = $this->db->get('sms_queue_log');

				}
				$out = '';$total = 0;
				if($q->result()){

					$out .= '<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" class="table table-striped" id="example" width="100%">
								<thead>
									<tr style="font-weight:bold">
										<th style="width:5%">Status</th>
										<th style="width:15%">Campaign</th>
										<th style="width:15%">Mobile No:</th>
				                        <th style="width:25%">Body </th>
				                        <th style="width:10%">From </th>
										<th style="width:5%">Cost </th>
										<th style="width:20%">Date</th>
										<th style="width:5%"></th>
									</tr>
								</thead>
								<tbody>';

					foreach($q->result() as $row){



						$button = '<span class="badge badge-success"><i title="Has been sent" rel="tooltip" class="icon-play icon-white"></i> Sent</span>';

						$out .= '<tr id="tr-'.$row->sms_queue_id.'">
									<td style="width:5%">'.$button.'</td>
									<td style="width:15%">'.$row->subject.'</td>
									<td style="width:15%">'.$row->phone.'</td>
									<td style="width:15%">'.$this->shorten_string(strip_tags($row->body), 10).'</td>
									<td style="width:10%">'.$shortcode.'</td>
									<td style="width:5%">N$ '.number_format($sms_rate, 2).'</td>
									<td style="width:20%">'.date('Y-m-d h:i',strtotime($row->datetime)).'</td>

									<td style="width:5%; text-align:right">
										<a target="_blank" href="javascript:void(0);" title="Sorry, you cannot delete the log" rel="tooltip" class="btn btn-mini btn-danger disabled"><i class="icon-trash icon-white"></i></a>
									</td>
							  </tr>';

						$total = $total + $sms_rate;

					}

					$out .= '</tbody>
					</table>
					<hr />
					<div class="clearfix" style="height:30px;"></div>
					';

				}

				//echo '<pre>' .$settings['contact_email'].'</pre>';
				echo '<div class="box span12 noMargin" onTablet="span12" onDesktop="span12">
						<div class="box-header">
							<h2><i class="icon-list"></i><span class="break"></span>'.$str.'</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<div class="clearfix" style="width:100%"></div>';

				echo $out;

				echo '<div class="btn btn-large btn-success pull-right">Total Cost: N$ '.number_format($total, 2).'</div><div class="clearfix" style="width:100%"></div>';

				echo '  </div>
					</div>';

		}else{


			echo 'SMS Config could not be found';

		}

	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW SMS RECIPIENTS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function show_sms_recipients($type = 'subscribers', $sub_cat = ''){

		$bus_id = $this->session->userdata('bus_id');
		//GET ALL CATEGORIES
		$subs = $this->db->query("SELECT DISTINCT(type) FROM subscribers WHERE bus_id = '".$bus_id."' AND phone != ''");


		$str = ucwords($type);

		$str = 'Contacts';

		if($sub_cat != ''){
			$str = ucwords(  rawurldecode($sub_cat) ) . ' '.ucwords($type);
			$query = $this->db->query("SELECT subscriber_id as id, name as name, type FROM subscribers WHERE bus_id = ".$bus_id." AND type = '". rawurldecode($sub_cat) ."' AND phone != ''");

		}else{

			$query = $this->db->query("SELECT subscriber_id as id, name as name, type FROM subscribers WHERE bus_id = ".$bus_id." AND phone != ''");
		}

		//SELECTION
		echo '<div class="alert">
                	<button type="button" class="close" data-dismiss="alert">×</button>
					<h3 class="alert-heading">Select recipients</h3>
                    Include some SMS recipients. Select a specific category from the button above. To select all recipients please click the check box.
              </div>
              <div class="btn-group">
					<button class="btn">'.$str.'</button>
					<button class="btn dropdown-toggle" data-toggle="dropdown">
					  <span class="caret"></span>
					</button>
					<ul class="dropdown-menu">
					  <li class="nav-header">Contacts</li>
					  <li><a tabindex="-3" onClick="select_rec('."'subscribers', ''".');" href="javascript:void(0);">All Contacts</a></li>';

		if($subs->result()){

			foreach($subs->result() as $row){

				echo '<li><a tabindex="-3" onClick="select_rec('."'subscribers', '".$row->type."'".');" href="javascript:void(0);">'.ucwords(str_replace("_", " " ,$row->type)).'</a></li>';
			}

		}


		echo	'</ul>
			  </div>
			  <div class="clearfix" style="height:30px;"></div>
			 ';



		echo '<input type="hidden" id="stype" name="stype" value="'. $type.'">
			  <input type="hidden" id="subscriber_category" name="subscriber_category" value="'. rawurldecode($sub_cat) .'">';
		if($query->result()){
			echo'
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


	//+++++++++++++++++++++++++++
	//CHECK CREDIT
	//++++++++++++++++++++++++++

	function check_credit(){

		$bus_id = $this->session->userdata('bus_id');
		//CREDIT LIMITS
		$sms_settings = $this->db->where('bus_id', $bus_id);
		$sms_settings = $this->db->get('sms_config');

		$data['bool'] = TRUE;
		$data['error'] = '';
		$data['limit'] = 0;
		$data['sms_rate'] = 0;
		if($sms_settings->result())
		{
			$sms_settings = $sms_settings->row_array();
			$sms_rate = ($sms_settings['sms_rate'] / 100);
			$shortcode = $sms_settings['shortcode'];
			$data['limit'] = $sms_settings['limit'];
			$total = 0;

			//USAGE
			$sms_usage = $this->db->query("SELECT COUNT(bus_id) as count FROM sms_queue_log WHERE bus_id = '".$bus_id."' AND YEAR(datetime) = YEAR(CURDATE()) AND MONTH(datetime) = MONTH(CURDATE())");
			if($sms_usage->result()){
				$urow = $sms_usage->row();
				$sms_usage = $urow->count;
				$data['sms_rate'] = $sms_usage * $sms_rate;

			}else{

				$data['sms_rate'] = 0;
			}

			if($data['sms_rate'] >= $data['limit']){

				$data['error'] =  '<div class="alert alert-warning"><h3>Credit Limit Reached!</h3>Credit Limit Reached! Speak to our Sales team to purchase more credits. info@intouch.com.na</div>';
				$data['bool'] = FALSE;

			}else{

				$data['error'] = '';
				$data['bool'] = TRUE;
			}


		}else{

			$data['error'] = '<div class="alert alert-warning"><h3>SMS marketing has not been setup</h3>SMS marketing has not been setup. Speak to our Sales team to set it up. info@intouch.com.na</div>';
			$data['bool'] = FALSE;

		}

		return $data;

	}


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SVALIDATE CELL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//HTML
	function validate_cell($num)
	{

		//CLEAN
		$to = trim(preg_replace('/[^0-9]/', '', $num));
		$final = '';

		$first = substr($to ,0,1);
		$first2 = substr($to ,0,2);
		$first3 = substr($to, 0, 3);
		$val = FALSE;
		$data['error'] = 'Malformed';
		//REMOVE 0027
		if($first == '0' && $first2 == '0'){

			$to = substr($to,2,strlen($to));
		}
		//override
		$first = substr($to ,0,1);
		$first2 = substr($to ,0,2);
		$first3 = substr($to, 0, 3);
		$length = strlen($to);

		//STRIP 264
		if($first3 == '264'){

			$to = substr($to,3,strlen($to));
			//override
			$first = substr($to ,0,1);
			$first2 = substr($to ,0,2);
			$first3 = substr($to, 0, 3);
			$length = strlen($to);
			//remove leading 0


		}
		if($first == 0){

			$to = substr($to,1,strlen($to));
			//override
			$first = substr($to ,0,1);
			$first2 = substr($to ,0,2);
			$first3 = substr($to, 0, 3);
			$length = strlen($to);
		}
		//SMS
		if($to != '' && $length <= 13){

			//too long
			if($length >= 10 && $first != 0){

				$val = FALSE;
				$data['error'] = 'Too many digits';
				$final = $to;

			}elseif($length < 9){

				$val = FALSE;
				$data['error'] = 'Must be 10 digits';
				$final = $to;

				//REMOVE 0
			}elseif($length == 10 && ($first3 == '081' || $first3 == '085')){

				$final2 = substr($to, 1, strlen($to));
				$final = '264'.$final2;
				$val = TRUE;

			}elseif($length == 9 && ($first2 == '81' || $first2 == '85')){

				//$final2 = substr($to, 1, strlen($to));
				$final = '264'.$to;
				$val = TRUE;

				//IF NOT 081 or 085
			}elseif($first2 != '81' || $first2 != '85'){

				$data['error'] = 'Not a namibian 081 or 085 Number';
				$final = '264'.$to;
				$val = FALSE;

			}else{

				$final ='264'. $to;
				$val = FALSE;

			}




			//VALIDATE NUMBER
			if($val){

				$data['bool'] = true;
				$data['phone'] = $final;
				$data['error'] = '';
				return $data;

			}else{

				$data['bool'] = false;
				$data['phone'] = $final;

				return $data;
			}


		}

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET INCOMING
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//HTML
	function get_incoming()
	{

		$bus_id = $this->session->userdata('bus_id');


		//SMS CONFIG
		$sms_settings = $this->db->where('bus_id', $bus_id);
		$sms_settings = $this->db->get('sms_config');

		if($sms_settings->result()){


			$sms_settings = $sms_settings->row_array();

			$sms_rate = ($sms_settings['sms_rate'] / 100);
			$shortcode = $sms_settings['shortcode'];
			$data['limit'] = $sms_settings['limit'];
			$key = $sms_settings['keyword'];


			//GET CURRENT PROMOTIONS
			//GET PROMOs
			$p = $this->db->where('bus_id', $bus_id);
			$p = $this->db->where('is_active', 'Y');
			$p = $this->db->get('sms_promo');
			$x = 0;

			//IF PROMOTIONS
			if($p->result()){

				$promo = $p->row();
				echo '<div class="box span12 noMargin" onTablet="span12" onDesktop="span12">
						<div class="box-header">
							<h2><i class="icon-list"></i><span class="break"></span>Incoming SMSs</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
						<div class="alert alert-info"><h3>Current Active Campaigns</h3>
							<p><strong>Shortcode:</strong> '.$promo->shortcode.'</p>
							<p><strong>Promo Type:</strong> '.ucwords(str_replace("_"," ",$promo->type)).'</p>
							<p><strong>Response</strong> '.$promo->response.'</p>
							<p><strong>Keyword:</strong> '.$promo->keyword.'</p>
							<p class="text-right"><a onclick="update_campaign('.$promo->sms_promo_id.')" class="btn"><i class="icon-pencil"></i> Update</a></p>
						</div>';

				//GET INCOMING SMS FROM THE MY SMS DB
				$smsdb = $this->connect_sms_db();

				$q = $smsdb->query("SELECT * FROM sms_incoming WHERE to_address = '".$shortcode."' AND SUBSTRING(message, 1,4) = '".$key."'");
				//$q = $smsdb->order_by('created_at', 'DESC');
				//$q = $smsdb->get('sms_incoming');

				if($q->result()){

					echo '
						<table cellpadding="0" cellspacing="0" style="font-size:12px" border="0" id="recip_tb" class="table table-striped" width="100%">
								<thead>
									<tr style="font-weight:bold">
										<th style="width:5%">Status</th>
										<th style="width:15%">Mobile No:</th>
				                        <th style="width:10%">Shortcode</th>
				                        <th style="width:10%">Status</th>
				                        <th style="width:30%">Message </th>
										<th style="width:10%">Cost</th>
										<th style="width:10%">Date</th>
										<th style="width:10%">Date</th>
									</tr>
								</thead>
								<tbody>';
					foreach($q->result() as $row){

						$words = explode(' ',$row->message);

						$action = '<span class="badge badge-warning">No</span>';
						if($row->actioned == 'Y'){

							$action = '<span class="badge badge-success">Yes</span>';
						}


						echo '<tr id="tr-'.$row->sms_queue_id.'">
									<td style="width:5%"></td>
									<td style="width:15%">'.$row->from_address.'</td>
									<td style="width:10%">'.$row->to_address.'</td>
									<td style="width:10%">'.$action.'</td>
									<td style="width:30%">'.$this->shorten_string(strip_tags($row->message), 10).'</td>
									<td style="width:10%">N$ '.number_format($sms_rate, 2).'</td>
									<td style="width:10%">'.date('Y-m-d h:i',strtotime($row->created_at)).'</td>

									<td style="width:10%; text-align:right">
										<a target="_blank" href="javascript:void(0);" title="Sorry, you cannot delete the log" rel="tooltip" class="btn btn-mini btn-danger disabled"><i class="icon-trash icon-white"></i></a>
									</td>
							  </tr>';

						$total = $total + $sms_rate;

					}

					echo '
					</tbody>
					</table>
					';



				}else{

					echo '<div class="alert alert-warning"><h3>No Incoming SMS received</h3>No SMSs have come through for your keyword</div>';


				}//no incoming SMS

				echo '</div>
					</div>';

			}else{


				echo '<div class="alert alert-warning"><h3>No Current Campaigns</h3>No SMS Marketing Campaigns have been setup</div>';

			}//no campaigns


		}else{

			echo '<div class="alert alert-warning"><h3>SMS marketing has not been setup</h3>SMS marketing has not been setup. Speak to our Sales team to set it up. info@intouch.com.na</div>';


		}//no config



	}

	//+++++++++++++++++++++++++++
	//EMAIL MARKETING - GET PROMO
	//++++++++++++++++++++++++++

	public function get_promo_update($id)
	{

		//GET PROMOs
		$p = $this->db->where('sms_promo_id', $id);
		$p = $this->db->get('sms_promo');
		$x = 0;

		//IF PROMOTIONS
		if($p->result())
		{

			$promo = $p->row();
			$astr = '';
			$nstr = 'active';
			$active = '';
			if($promo->is_active == 'Y'){

				$astr = 'active';
				$nstr = '';

			}
			$ir = '';
			$in = '';
			if($promo->type == 'import_response'){

				$ir = 'active';
				$in = '';

			}
			if($promo->type == 'incoming'){

				$ir = '';
				$in = 'active';

			}
			echo '<form id="promo-update" name="promo-update" method="post" action="'.site_url('/').'admin/update_promo_do" class="form-horizontal">
					          <input type="hidden" name="sms_promo_id" value="'.$promo->sms_promo_id.'">
                              <div class="control-group">
                                <label class="control-label" for="title">Active</label>
                                <div class="controls">
                                        <div class="btn-group active" data-toggle="buttons-radio">
                                          <button type="button" class="btn btn-primary '.$nstr.'">No</button>
                                          <button type="button" class="btn btn-primary '.$astr.'">Yes</button>
                                        </div>
                                </div>
                                <input type="hidden" name="is_active" id="pis_active"  value="'.$promo->is_active.'">
                              </div>
                              <div class="control-group">
                                <label class="control-label" for="ptype">Type</label>
                                <div class="controls">
                                        <div class="btn-group type" data-toggle="buttons-radio">
                                          <button type="button" class="btn btn-primary '.$ir.'">Import Response</button>
                                          <button type="button" class="btn btn-primary '.$in.'">Incoming</button>
                                        </div>
                                </div>
                                <input type="hidden" name="type" id="ptype"  value="'.$promo->type.'">
                              </div>
							 <div class="control-group">
								  <label class="control-label" for="response">Response</label>
								<div class="controls">
								   <textarea id="response" name="response" placeholder="Response" >'.$promo->response.'</textarea>
								</div>
							 </div>
						</form>';


		}else{

			echo 'Not Found';
		}
	}


	//+++++++++++++++++++++++++++
	//GET MEMBER DETAILS
	//++++++++++++++++++++++++++

	function get_member($mem_id){

		$test = $this->db->where('member_id', $mem_id);
		$test = $this->db->get('members');
		return $test->row_array();

	}
	//+++++++++++++++++++++++++++
	//GET MEMBER DETAILS
	//++++++++++++++++++++++++++

	function get_subscriber($id){

		$test = $this->db->where('subscriber_id', $id);
		$test = $this->db->get('subscribers');
		return $test->row_array();

	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}
	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}

	//connect to tourism db
	function connect_sms_db(){


		if($_SERVER["REMOTE_ADDR"]=="localhost" || $_SERVER["REMOTE_ADDR"]=="::1"){

			/*$config_db['username'] = 'root';
			$config_db['password'] = '';
			$config_db['database'] = 'smsmy_live';*/
			$config_db['hostname'] = 'nmh-db-1-cluster.cluster-cxonbylt4aio.eu-west-1.rds.amazonaws.com';
			$config_db['username'] = 'root';
			$config_db['password'] = 'OANdyn14784';
			$config_db['database'] = 'sms_my_na';
			$config_db['port']     = 3306;
		}else{

			//connect to main database
/*			$config_db['hostname'] = 'localhost';
			$config_db['username'] = 'smsmy_admin';
			$config_db['password'] = "TWao\yi'ogx|`9F;#Anu";
			$config_db['database'] = 'smsmy_live';*/
			$config_db['hostname'] = 'nmh-db-1-cluster.cluster-cxonbylt4aio.eu-west-1.rds.amazonaws.com';
			$config_db['username'] = 'root';
			$config_db['password'] = 'OANdyn14784';
			$config_db['database'] = 'sms_my_na';
			$config_db['port']     = 3306;

		}

		$config_db['dbdriver'] = 'mysqli';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = FALSE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
	}

}
?>
