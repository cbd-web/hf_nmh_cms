<?php
class Marathon_model extends CI_Model{
	
 	function marathon_model(){
  		//parent::CI_model();
			
 	}
	
	
	
	
	
	public function export_members_csv() {

		$this->load->dbutil();
		$this->load->helper('download');
		
		$bus_id = $this->session->userdata('bus_id');	
		
		 $query = $this->db->query("SELECT B.ref_no AS Reference_No, A.name AS Subscriber_Name, A.gender AS Gender, A.dob AS Date_of_Birth, A.email AS Email, A.phone AS Contact_Number, A.country AS Country, A.city AS Town, A.region AS Region, A.club AS Club, A.school AS School, B.distance AS Race_Distance, B.category AS Race_Category, B.age AS Age_on_Race, B.tshirt AS Tshirt_Size FROM subscribers AS A, marathon_subscribers AS B WHERE A.bus_id = '".$bus_id."' AND A.subscriber_id = B.subscriber_id", FALSE);	
		
		//echo $this->dbutil->csv_from_result($query);	
		
		$delimiter = ",";
		$newline = "\r\n";
		
		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
		
		force_download('Lucky_Star_Marathon_Subscribers_'.date('d.m.Y').'.csv', $data); 
		
	}
	
	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_all_members($type)
	{
		 // $query = $this->db->order_by('datetime', 'ASC');
		 $bus_id = $this->session->userdata('bus_id');	
			 
		  $query = $this->db->query("SELECT * FROM subscribers AS A, marathon_subscribers AS B WHERE A.bus_id = '".$bus_id."' AND A.subscriber_id = B.subscriber_id", FALSE);	
			 


		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:10%;font-weight:bold">Ref No</th>
						<th style="width:15%;font-weight:bold">Name </th>
						<th style="width:20%;font-weight:bold">Distance </th>
						<th style="width:10%;font-weight:bold">Category </th>
						<th style="width:10%;font-weight:bold">Town </th>
						<th style="width:20%;font-weight:bold">Email</th>
						<th style="width:15%;font-weight:bold"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr>
						
						<td style="width:10%">'.$row->ref_no.'</td>
						<td style="width:15%"><a style="cursor:pointer" 
						href="'.site_url('/').'admin/update_marathon_subscriber/'.$row->subscriber_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->name.'</div></a></td>
            			<td style="width:20%">'.$row->distance.'</td>
						<td style="width:10%">'.$row->category.'</td>
						<td style="width:10%">'.$row->city.'</td>
						<td style="width:20%;">'.$row->email.'</td>
						<td style="width:15%;text-align:right">
						<a title="Edit '.$type.'" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_marathon_subscriber/'.$row->subscriber_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Subscriber" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_member('.$row->subscriber_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div><a href="'.site_url('/').'admin/export_members_csv/">Export to CSV</a></div>
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Subscribers added</h3>
					No Subscribers have been added.</div>';
		  
		 }
				
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++	
	function update_member_do()
	{
			$name = $this->input->post('name', TRUE);
			$gender = $this->input->post('gender', TRUE);
			$dob = $this->input->post('dob', TRUE);
			$email = $this->input->post('email', TRUE);
			$phone = $this->input->post('phone', TRUE);
			$region = $this->input->post('region', TRUE);
			$club = $this->input->post('club', TRUE);
			$school = $this->input->post('school', TRUE);
			$city = $this->input->post('city', TRUE);
			$country = $this->input->post('country', TRUE);
			$bus_id = $this->session->userdata('bus_id');
			$id = $this->input->post('id', TRUE);
			
			$distance = $this->input->post('distance', TRUE);
			$category = $this->input->post('category', TRUE);
			$age = $this->input->post('age', TRUE);
			$shirt = $this->input->post('shirt', TRUE);

		 
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
			
				$insertdata1 = array(
					  'name'=> $name ,
					  'gender'=> $gender ,
					  'dob'=> $dob,
					  'email'=> $email,
					  'phone'=> $phone,
					  'club'=> $club,
					  'school'=> $school,
					  'region'=> $region, 
					  'city'=> $city,
					  'country'=> $country,
					  'bus_id' => $bus_id
					);
					
				$insertdata2 = array(
					  'distance'=> $distance ,
					  'category'=> $category ,
					  'age'=> $age,
					  'tshirt'=> $shirt, 
					  'bus_id' => $bus_id
					);					
			
	
			
			if($val == TRUE){
				
						
					$this->db->where('subscriber_id' , $id);
					$this->db->update('subscribers', $insertdata1);
		
					$this->db->where('subscriber_id' , $id);
					$this->db->update('marathon_subscribers', $insertdata2);

					
					//LOG
					$this->admin_model->system_log('update_'.$member_type.'-'. $id);
					$data['basicmsg'] = 'Subscriber has been updated successfully';
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
			$member_type = $this->input->post('member_type', TRUE);
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
								  'type'=> $type,
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
					
					//LOG
					$this->admin_model->system_log('add_new_'.$member_type.'-'.$title);
					//success redirect	
					$data['basicmsg'] = ucwords($member_type).' added successfully';
					$this->session->set_flashdata('msg',$data['basicmsg']);

					 echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);
					  window.location = '".site_url('/')."admin/".$member_type."';
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
		 
	function get_member($id){
		
		$bus_id = $this->session->userdata('bus_id');		
		$query = $this->db->query("SELECT * FROM subscribers AS A, marathon_subscribers AS B WHERE A.bus_id = '".$bus_id."' AND A.subscriber_id = '".$id."' AND A.subscriber_id = B.subscriber_id", FALSE);	
			

		return $query->row_array();	

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