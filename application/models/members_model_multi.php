<?php
class Members_model_multi extends CI_Model{
	
 	function members_model_multi(){
  		//parent::CI_model();
			
 	}
	
	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_all_members()
	{
		 // $query = $this->db->order_by('datetime', 'ASC');
		  $bus_id = $this->session->userdata('bus_id');	
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('members');
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:30%;font-weight:bold">Name </th>
						<th style="width:15%;font-weight:bold">Phone </th>
						<th style="width:10%;font-weight:bold">Type </th>
						<th style="width:10%;font-weight:bold">City </th>
						<th style="width:20%;font-weight:bold">Email</th>
						<th style="width:15%;font-weight:bold"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr>
						
						<td style="width:30%"><a style="cursor:pointer" 
						href="'.site_url('/').'admin/update_member/'.$row->member_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->name.'</div></a></td>
            			<td style="width:15%">'.$row->phone.'</td>
						<td style="width:10%">'.$row->type.'</td>
						<td style="width:10%">'.$row->city.'</td>
						<td style="width:20%;">'.$row->email.'</td>
						<td style="width:15%;text-align:right">
						<a title="Edit Member" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_member/'.$row->member_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Member" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_member('.$row->member_id.')">
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
			 		<h3>No Members added</h3>
					No members have been added. to add a new gallery please click on the add members button on the right</div>';
		  
		 }
				
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++	
	function update_member_do()
	{
			$title = $this->input->post('name', TRUE);
			$abr = $this->input->post('abreviation', TRUE);
			$contact = $this->input->post('contact', TRUE);
			$email = $this->input->post('email', TRUE);
			$type = $this->input->post('type', TRUE);
			$phone = $this->input->post('phone', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$region = $this->input->post('region', TRUE);
			$city = $this->input->post('city', TRUE);
			$address = $this->input->post('address', TRUE);
			$website = $this->input->post('website', TRUE);
			$bus_id = $this->session->userdata('bus_id');
			$id = $this->input->post('member_id', TRUE);
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Member Name Required';
					
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
								  'type'=> $type,
								  'phone'=> $phone,
								  'fax'=> $fax, 
								  'region'=> $region, 
								  'city'=> $city,
								  'bus_id' => $bus_id,
								  'address'=> $address,
								  'website'=> $website
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('member_id' , $id);
					$this->db->update('members', $insertdata);
					//success redirect	
					$data['member_id'] = $id;
					
					//LOG
					$this->admin_model_multi->system_log('update_member-'. $id);
					$data['basicmsg'] = 'Member has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	//+++++++++++++++++++++++++++
	//ADD MEMBER DO
	//++++++++++++++++++++++++++	
	function add_member_do()
	{
			$title = $this->input->post('name', TRUE);
			$abr = $this->input->post('abreviation', TRUE);
			$contact = $this->input->post('contact', TRUE);
			$email = $this->input->post('email', TRUE);
			$type = $this->input->post('type', TRUE);
			$phone = $this->input->post('phone', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$region = $this->input->post('region', TRUE);
			$city = $this->input->post('city', TRUE);
			$address = $this->input->post('address', TRUE);
			$website = $this->input->post('website', TRUE);
	
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Member Name Required';
					
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
								  'type'=> $type,
								  'phone'=> $phone,
								  'fax'=> $fax, 
								  'region'=> $region, 
								  'city'=> $city,
								  'address'=> $address,
								  'website'=> $website
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('members', $insertdata);
					//LOG
					$this->admin_model_multi_multi->system_log('add_new_member-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Member added successfully');
					$data['basicmsg'] = 'Gallery has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/members/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
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