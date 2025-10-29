<?php
class Members_model extends CI_Model{
	
 	function members_model(){
  		//parent::CI_model();
			
 	}
	
	
	public function get_subscriber_cats($id) {
		
			  $bus_id = $this->session->userdata('bus_id');
		
			  $query = $this->db->query("SELECT *
			  
			  							 FROM subscriber_type AS a 
										 
										 WHERE a.bus_id = '".$bus_id."'", FALSE);	
			
			if($query->result()){
				
				foreach($query->result() as $row){
					
					
			  		$query2 = $this->db->query("SELECT id FROM subscriber_type_int WHERE subscriber_id = '".$id."' AND type_id = '".$row->sub_type_id."'", FALSE);					
					
					$row2 = $query2->row();
					
					if($query2->result()){ $checked = 'checked'; } else { $checked = ''; }
					
					echo '<input name="type[]" type="checkbox" value="'.$row->sub_type_id.'" '.$checked.' /> '.$row->type.'<br>';
					
				}
				
			}
		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_all_members($type)
	{
		 // $query = $this->db->order_by('datetime', 'ASC');
		 $bus_id = $this->session->userdata('bus_id');	
		 if($type == 'members'){
			 
			  $query = $this->db->query("SELECT *, a.member_id AS id, c.type AS type_name
			  
			  							 FROM members AS a 
			  							 
										 LEFT JOIN subscriber_type_int AS b ON a.member_id = b.subscriber_id
										 
										 LEFT JOIN subscriber_type AS c ON b.type_id = c.sub_type_id
										 
										 WHERE a.bus_id = '".$bus_id."' GROUP BY a.subscriber_id", FALSE);		 
			 
		 }else{
			 
			  $query = $this->db->query("SELECT *, a.subscriber_id AS id, c.type AS type_name
			  
			  							 FROM subscribers AS a 
			  							 
										 LEFT JOIN subscriber_type_int AS b ON a.subscriber_id = b.subscriber_id
										 
										 LEFT JOIN subscriber_type AS c ON b.type_id = c.sub_type_id
										 
										 WHERE a.bus_id = '".$bus_id."' GROUP BY a.subscriber_id", FALSE);	
			 
		 }

		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:20%;font-weight:bold">Name </th>
						<th style="width:15%;font-weight:bold">Phone </th>
						<th style="width:25%;font-weight:bold">Type </th>
						<th style="width:10%;font-weight:bold">City </th>
						<th style="width:15%;font-weight:bold">Email</th>
						<th style="width:15%;font-weight:bold"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$str = $row->id.", '".$type."'";
				echo '<tr>
						
						<td style="width:20%"><a style="cursor:pointer"
						href="'.site_url('/').'admin/update_'.$type.'/'.$row->id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->name.'</div></a></td>
            			<td style="width:15%">'.$row->phone.'</td>
						<td style="width:25%">'.$row->type_name.'</td>
						<td style="width:10%">'.$row->city.'</td>
						<td style="width:25%;">'.$row->email.'</td>
						<td style="width:15%;text-align:right">
						<a title="Edit '.$type.'" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_'.$type.'/'.$row->id.'"><i class="icon-pencil"></i></a>
						<a title="Delete '.$type.'" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_member('.$str.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No '.ucwords($type).' added</h3>
					No '.ucwords($type).' have been added. to add a one please click on the add '.ucwords($type).' button on the right</div>';
		  
		 }
				
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++	
	function update_member_do()
	{
			$member_type = $this->input->post('member_type', TRUE);
			$title = $this->input->post('name', TRUE);
			$abr = $this->input->post('abreviation', TRUE);
			$contact = $this->input->post('contact', TRUE);
			$email = $this->input->post('email', TRUE);
			//$type = $this->input->post('type', TRUE);
			$phone = $this->input->post('phone', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$region = $this->input->post('region', TRUE);
			$city = $this->input->post('city', TRUE);
			$address = $this->input->post('address', TRUE);
			$website = $this->input->post('website', TRUE);
			$bus_id = $this->session->userdata('bus_id');
			$id = $this->input->post('id', TRUE);

		 
			//VALIDATE INPUT
			//if($title == ''){
				//$val = FALSE;
				//$error =  ucwords($member_type).' Name Required';
			if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
				$val = FALSE;
				$error = 'Email address is not valid.';			
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'name'=> $title ,
								  'abreviation'=> $abr ,
								  'contact'=> $contact,
								  'email'=> $email,
								  'phone'=> $phone,
								  'fax'=> $fax, 
								  'region'=> $region, 
								  'city'=> $city,
								  'bus_id' => $bus_id,
								  'address'=> $address,
								  'website'=> $website
					);
			
	
			
			if($val == TRUE){
				
				
					if($member_type == 'members'){
						
						$this->db->where('member_id' , $id);
						$this->db->update('members', $insertdata);
											
						
					}elseif($member_type == 'subscribers'){
						
						$this->db->where('subscriber_id' , $id);
						$this->db->update('subscribers', $insertdata);
						
					}				


					
					//LOG
					$this->admin_model->system_log('update_'.$member_type.'-'. $id);
					$data['basicmsg'] = 'Member has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	
	//+++++++++++++++++++++++++++
	//UPDATE SUBSCRIBER TYPES DO
	//++++++++++++++++++++++++++	
	function update_subscriber_types_do()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		$id = $this->input->post('id', TRUE);
		
		$this->db->where('bus_id', $bus_id);
		$this->db->where('subscriber_id', $id);
		$this->db->delete('subscriber_type_int');	
		
		
		foreach($this->input->post('type') as $item){

			$insertdata = array(
				  'bus_id'=> $bus_id ,
				  'type_id'=> $item,
				  'subscriber_id'=> $id
			);
					
			$this->db->insert('subscriber_type_int', $insertdata);		  
		  
		}		
		
			

/*	  	$query = $this->db->query("SELECT *
	  
								   FROM subscriber_type AS a 
								 
								   WHERE a.bus_id = '".$bus_id."'", FALSE);			
		

			if($query->result()){
				
				foreach($query->result() as $row){
									
					
					if($query2->result()){ $checked = 'checked'; } else { $checked = ''; }
					
					echo '<input name="type_'.$row->sub_type_id.'" type="checkbox" value="'.$row->sub_type_id.'" '.$checked.' /> '.$row->type.'<br>';
					
				}
				
			}	*/	
		
	}



	//+++++++++++++++++++++++++++
	//UPDATE SUBSCRIBER STATUS
	//++++++++++++++++++++++++++
	function update_member_status($status, $member_id, $type_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$o = array();

		if($status != 'delete') {

			$insertdata = array(
				'status'=> $status
			);

			$member_update = $this->db->where('bus_id', $bus_id);
			$member_update = $this->db->where('subscriber_id' , $member_id);
			$member_update = $this->db->update('subscribers', $insertdata);

			if($member_update) {

				//success redirect
				$o['success'] = true;
				$o['reload'] = true;
				$o['msg'] = 'Subscriber status updated successfully';

				//Send email when user account is made live
				if($status == 'live') {

					$member_details = $this->db->where('bus_id', $bus_id);
					$member_details = $this->db->where('subscriber_id' , $member_id);
					$member_details = $this->db->get('subscribers');

					if($member_details->result()) {

						$r = $member_details->row();

						$email = $r->email;
						$name = trim($r->name.' '.$r->sname);

						$settings = $this->get_settings();

						//BUILD EMAIL BODY
						$msg_final = 'Hi, '.ucwords($name).' <br /><br /> 
									  Your account has been activated and you are now able to login!<br /><br />
									  Have a great day<br /><br />
									  '.$settings['title'].'<br /><br />';

						$view['email'] = $email;
						$view['body'] = $msg_final;

						$data1 = array(
							'name'=> $settings['title'],
							'email'=> 'noreply@my.na',  //$settings['contact_email'] ,
							'body'=> $this->load->view('email/body_sss',$view, TRUE) ,
							'type'=> 'register',
							'email_to' => $email,
							'subject' => 'Account Approved - Simonis Storm Securities'
						);

						//SEND EMAIL LINK -- UNCOMMENT!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
						$this->load->model('email_model');
						$this->email_model->send_enquiry($data1);

					} else {}

				} //end of confirmation email when status is set to 'live'

			} else {

				$o['success'] = false;
				$o['reload'] = true;
				$o['msg'] = 'Oops! Something went wrong. Please try again later.';

			}

		} else {

			//Delete member
			$member_delete = $this->db->where('bus_id', $bus_id);
			$member_delete = $this->db->where('type', 'Members');
			$member_delete = $this->db->where('subscriber_id', $member_id);
			$member_delete = $this->db->delete('subscribers');

			if($member_delete){

				if ($type_id != 0) {

					$this->db->where('subscriber_id', $member_id);
					$this->db->where('type_id', $type_id);
					$this->db->delete('subscriber_type_int');

				}

				//Log
				$this->admin_model->system_log('delete_member-'.$member_id);

				$o['success'] = true;
				$o['reload'] = false;
				$o['msg'] = 'Subscriber deleted successfully!';

			} else {

				$o['success'] = false;
				$o['reload'] = true;
				$o['msg'] = 'Oops! This user did not sign up as a client!';

			}

		}

		echo json_encode($o);

	}


	//+++++++++++++++++++++++++++
	//GET SETTINGS
	//++++++++++++++++++++++++++		 
		 
	function get_settings(){
		
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('settings');
		return $test->row_array();	

	}


	//++++++++++++++++++++++++++++++++
	//UPDATE SUBSCRIBER PASSWORD DO
	//++++++++++++++++++++++++++++++++
	function update_subscriber_pwd_do($password)
	{

		$this->load->helper('form');

		//VALIDATE USER INPUT
		$this->load->library('form_validation');

		$this->form_validation->set_rules('pwd_new', 'Password', 'trim|required|matches[pwd_confirm]');
		$this->form_validation->set_rules('pwd_confirm', 'Confirmed Password', 'trim|required');

		//VALIDATE INPUT
		if($this->form_validation->run() == FALSE){

			$data['id'] = $this->session->userdata('id');

			echo '<div class="alert alert-danger">'.validation_errors().'</div>';

			//$o['msg'] = '<div class="alert alert-danger">'.validation_errors().'</div>';

			//echo json_encode($o);

			//$data['error'] = validation_errors();

			//  echo "<script>
			//   $.noty.closeAll()
			//   var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
			//   noty(options);
			//   </script>";
			// $this->output->set_header("HTTP/1.0 200 OK");

		} else {

			$bus_id = $this->session->userdata('bus_id');
			$id = $this->input->post('id', TRUE);
			$password = $this->input->post('pwd_new', TRUE);

			//ENCRYPT PASSWORD
			$enc_password = md5($password);

			$updated_password = array(
				'password' => $enc_password
			);

			$this->db->where('bus_id', $bus_id);
			$this->db->where('subscriber_id', $id);
			$this->db->update('subscribers', $updated_password);

			//success redirect
			$data['basicmsg'] = 'Subscriber password updated successfully';
			$this->session->set_flashdata('msg',$data['basicmsg']);

			 echo "<script>
			  $.noty.closeAll()
			  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
			  noty(options);
			  window.location = '".site_url('/')."admin/update_subscribers/".$id."';
			  </script>";

		}

	}


	//+++++++++++++++++++++++++++++++++
	//CHECK IF SUBSCRIBER IS LOGGED IN
	//+++++++++++++++++++++++++++++++++
	function get_subscriber_login_status_do($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('subscriber_id', $id);
		$query = $this->db->get('login_log');

		if($query->result()){

			$r = $query->row_array();

			$type = $r->type;

			echo '
			<div class="box span4">
				<div class="box-header">
					<h2><i class="icon-th"></i><span class="break"></span>Logout '.ucwords($type).'</h2>
					<div class="box-icon">
						<a href="#" class="btn-close"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="box-content">
					<form id="logout-subscriber" name="logout-subscriber" method="post" action="'.site_url('/').'admin/logout_subscriber_do" class="form-horizontal">
						<input type="hidden" name="id" value="'.$id.'">
						<p>The user is currently logged in.</p>
						<hr>
						<button type="submit" class="btn btn-inverse btn" id="btn_logout_subscriber">Logout Subscriber</button>
					</form>
					<div id="result_msg4"></div>                 
				</div>
			</div>
			';

		} else {


		}

	}


	//+++++++++++++++++++++++++++
	//LOGOUT SUBSCRIBER DO
	//+++++++++++++++++++++++++++
	function logout_subscriber_do()
	{

		$bus_id = $this->session->userdata('bus_id');
		$id = $this->input->post('id', TRUE);

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('subscriber_id', $id);
		$test = $this->db->delete('login_log');

		if($test){

			//success redirect
			$data['basicmsg'] = 'Subscriber logged out successfully';
			$this->session->set_flashdata('msg',$data['basicmsg']);

			 echo "<script>
			  $.noty.closeAll()
			  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
			  noty(options);
			  window.location = '".site_url('/')."admin/update_subscribers/".$id."';
			  </script>";

		} else {

			$data['error'] = 'Oops! Something went wrong. Please try again later.';

			echo "
				<script>
					$.noty.closeAll()
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
					noty(options);
				</script>
			";

			$this->output->set_header("HTTP/1.0 200 OK");

		}

	}
	
	
	//+++++++++++++++++++++++++++
	//ADD MEMBER DO
	//++++++++++++++++++++++++++	
	function add_member_do()
	{
			$member_type = $this->input->post('member_type', TRUE);
			$title = $this->input->post('name', TRUE);
			$abr = $this->input->post('abreviation', TRUE);
			$contact = $this->input->post('contact', TRUE);
			$email = $this->input->post('email', TRUE);
			//$type = $this->input->post('type', TRUE);
			$phone = $this->input->post('phone', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$region = $this->input->post('region', TRUE);
			$city = $this->input->post('city', TRUE);
			$address = $this->input->post('address', TRUE);
			$website = $this->input->post('website', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		  	
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = ucwords($member_type). ' Name Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			//}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';	
//							
			}else{
				$val = TRUE;
			}
			
					$insertdata = array(
					  'name'=> $title ,
					  'abreviation'=> $abr ,
					  'contact'=> $contact,
					  'email'=> $email,
					  'phone'=> $phone,
					  'fax'=> $fax, 
					  'region'=> $region, 
					  'city'=> $city,
					  'bus_id'=> $bus_id,
					  'address'=> $address,
					  'website'=> $website
					);
					
		
			
	
			
			if($val == TRUE){
				
					if($member_type == 'members'){
						
						$this->db->insert('members', $insertdata);
						
					}elseif($member_type == 'subscribers'){
						
						$this->db->insert('subscribers', $insertdata);
						
					}
					
					$id = $this->db->insert_id();
					
/*					$insertdata2 = array(
					  'bus_id'=> $bus_id ,
					  'subscriber_id'=> $id ,
					  'type_id'=> $type
					);
						
					$this->db->insert('subscriber_type_int', $insertdata2);*/
					
					//LOG
					$this->admin_model->system_log('add_new_'.$member_type.'-'.$title);
					//success redirect	
					$data['basicmsg'] = ucwords($member_type).' added successfully';
					$this->session->set_flashdata('msg',$data['basicmsg']);

					 echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);
					  window.location = '".site_url('/')."admin/update_subscribers/".$id."';
					  </script>";		
					
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					 echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
					  noty(options);
					  </script>";
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}

	//+++++++++++++++++++++++++++
	//GET MEMBER DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_member($id, $type){
		
		$bus_id = $this->session->userdata('bus_id');
		
		if($type == 'subscribers'){
			
			$test = $this->db->query("SELECT *, a.subscriber_id AS sid FROM subscribers AS a
									
								      LEFT JOIN subscriber_type_int AS b on a.subscriber_id = b.subscriber_id
									
								      WHERE a.bus_id = '".$bus_id."' AND a.subscriber_id = '".$id."' ");			
			

		}elseif($type == 'members'){
			
			
			$test = $this->db->query("SELECT *, a.member_id AS mid FROM members AS a
									
								   LEFT JOIN subscriber_type_int AS b on a.member_id = b.subscriber_id
									
								   WHERE a.bus_id = '".$bus_id."' AND a.member_id = '".$id."' ");				
			
		}

		return $test->row_array();	

	}			

	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+eNcryption Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	/*Hash password*/
	
	function hash_password($username, $password){
		
		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . $this->config->item('encryption_key') . strtolower($username));
		
		// Prefix the password with the salt
		$hash = $salt . $password;
		
		// Hash the salted password a bunch of times
		for ( $i = 0; $i < 100000; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}
		
		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;
		return $hash;
		
	}
	

	/*Validate password*/
	
	function validate_password($username, $password){
		
		$sql = $this->db->query("SELECT *
			  					FROM `members`
								WHERE
				  			   `email` = '".$username."' LIMIT 1",TRUE);
		
		$res = array();	 
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){
				
			$r = $sql->row_array();
			//Store value for return
			$res['fname'] = $r['fname'];
			$res['admin_id'] = $r['admin_id'];
			$res['img_file'] = $r['img_file'];
			$res['last_login'] = $r['last_login'];
			// The first 64 characters of the hash is the salt
			$salt = substr($r['pass'], 0, 64);
			
			$hash = $salt . $password;
			
			// Hash the password as we did before
			for ( $i = 0; $i < 100000; $i ++ ) {
			  $hash = hash('sha256', $hash);
			}
			
			$hash = $salt . $hash;
			
			if ( $hash == $r['pass'] ) {
			  
			   $res['bool'] = TRUE;
			   //break;
			}else{
			  
			   $res['bool'] = FALSE;
				
			}
		}else{//no username match
			
			$res['bool'] = FALSE;
		}

		return $res;
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


}
?>