<?php
class Magnet_member_model extends CI_Model{
	
 	function Magnet_member_model(){
  		//parent::CI_model();
	    $this->load->library('encrypt');
		
 	}

	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_member_result($id)
	{
			
		$query = $this->db->where('subscriber_id', $id);
		$query = $this->db->get('magnet_subscribers');
		return $query->row_array();	

	}
	

	//+++++++++++++++++++++++++++
	//UPDATE MEMBER DO
	//++++++++++++++++++++++++++
	public function update_member_do()
	{
		$bus_id = $this->session->userdata('bus_id');
			
		$id = $this->input->post('member_id', TRUE);
		$name = $this->input->post('name', TRUE);
		$surname = $this->input->post('surname', TRUE);
		$type = $this->input->post('type', TRUE);
		$company = $this->input->post('company', TRUE);
		$tel = $this->input->post('tel', TRUE);
		$email = $this->input->post('email', TRUE);
		$country = $this->input->post('country', TRUE);
		$city = $this->input->post('city', TRUE);

		
		$insertdata = array(
			  'name'=> $name,
			  'sname'=> $surname,
			  'company'=> $company,
			  'type'=> $type,
			  'phone'=> $tel,
			  'email'=> $email,
			  'city'=> $city,
			  'country'=> $country,
			  'type'=> $type		  
		);			
			
		$this->db->where('subscriber_id' , $id);
		$this->db->where('bus_id' , $bus_id);
		$this->db->update('magnet_subscribers', $insertdata);
			
		$this->admin_model->system_log('update_member-'. $id);
		
		
		
		$data['basicmsg'] = 'Member has been updated successfully';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				noty(options);</script>";
	}



	//+++++++++++++++++++++++++++
	//UPDATE PASSWORD
	//++++++++++++++++++++++++++
	public function update_password_do()
	{
		$bus_id = $this->session->userdata('bus_id');	
		$pass = $this->input->post('pass', TRUE);
		$pass2 = $this->input->post('pass2', TRUE);
		$id = $this->input->post('id', TRUE);
		$send_user = $this->input->post('send_user', TRUE);
		
		if($pass == $pass2) {

			$password = md5($pass);
			
			$insertdata = array(
				  'password'=> $password
			);
			
				
			$this->db->where('subscriber_id' , $id);
			$this->db->where('bus_id' , $bus_id);
			$this->db->update('magnet_subscribers', $insertdata);

			if($send_user == 'true') {

				$this->send_details_do($id, $pass);

			}

			echo 'success';	
		
		} else {
		
			echo 'failed';	
			
		}


	}	


	

	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_all_members()
	{

		 $bus_id = $this->session->userdata('bus_id');	

			 
		 $query = $this->db->query("SELECT * FROM magnet_subscribers WHERE bus_id = '".$bus_id."' ORDER BY name ASC", FALSE);	


		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:5%;font-weight:bold"></th>				
						<th style="width:20%;font-weight:bold">Name </th>
						<th style="width:15%;font-weight:bold">Company </th>
						<th style="width:15%;font-weight:bold">Phone </th>
						<th style="width:25%;font-weight:bold">Email </th>
						<th style="width:10%;font-weight:bold">Country </th>
						<th style="width:10%;font-weight:bold"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				if($row->status == 'draft') { 
					
					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_member('.$row->subscriber_id.',0)"><i class="icon-remove icon-red"></i></a>'; 
					
				} else {
					
					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_member('.$row->subscriber_id.',1)"><i class="icon-ok icon-green"></i></a>'; 
					
				}
				
				echo '<tr>
						<td style="width:5%">'.$actioned.'</td>
						
            			<td style="width:20%">'.$row->name.' '.$row->sname.'</td>
						<td style="width:15%">'.$row->company.'</td>
						<td style="width:15%">'.$row->phone.'</td>
						<td style="width:25%">'.$row->email.'</td>
						<td style="width:10%;">'.$row->country.'</td>
						<td style="width:10%;text-align:right">				
						<a title="View Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'magnet_members/view_member/'.$row->subscriber_id.'"><i class="icon-eye-open"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_member('.$row->subscriber_id.')">
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
			 		<h3>No Entries added</h3>
					No Entries have been added.
				   </div>';
		  
		 }
				
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE MEMBER
	//++++++++++++++++++++++++++	
	function delete_member_do($id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database1
			  $query = $this->db->where('subscriber_id', $id);
			  $this->db->delete('magnet_subscribers');

			/*	$file =  BASE_URL.'assets/documents/' . $doc; # build the full path		
				
				if (file_exists($file)) {
					unlink($file);
				}
			*/			  	  
			  
			  //LOG
			  $this->admin_model->system_log('delete_member-'.$id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'magnet_members/members/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }	
	
	//+++++++++++++++++++++++++++
	//ACTION FEEDBACK
	//++++++++++++++++++++++++++	
	function action_member_do($id,$status){
      	
		$bus_id = $this->session->userdata('bus_id');	
		
			if($status == 0) { $actioned = 'Y'; }
			if($status == 1) { $actioned = 'N'; }
		
			$insertdata = array(
				  'active'=> $actioned		  
			);
			

			
			$this->db->where('subscriber_id' , $id);
			$this->db->where('bus_id' , $bus_id);
			$this->db->update('magnet_subscribers', $insertdata);
			
			if($status == 0) {
				// SEND MAILS
				$query = $this->db->where('member_id', $id);
				$query = $this->db->get('magnet_subscribers');
				
				$row = $query->row();	
				
				$msg = '';
				$msg .= '<p>
						<h3>Magnet Login Details</h3>
						Hi '.$row->name.' '.$row->surname.'<br><br>Your Magnet Account has been activated.<br><br>Your login details are:<br><br>
						<strong>Username: </strong>'.$row->email.'<br>
						<strong>Password: </strong>'.$row->p_forget.'<br><br>
	
						</p>';
						
				$subject = 'Member details from Magnet';
			
				 $data1 = array(
				  'name'=>  'Magnert',
				  'email'=> 'noreply@magnet.com.na',
				  'body'=> $msg ,
				  'type'=> 'enquiry',
				  'email_to' => $row->email,
				  'subject' => $subject
				  );
				
							
			
				//SEND EMAIL LINK
				
				$this->load->model('email_model'); 
				$this->email_model->send_enquiry($data1);	
			
			}
			  
		  
			  //LOG
			  $this->admin_model->system_log('action-member-'.$id);
			  $this->session->set_flashdata('msg','Member actioned successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'magnet_members/members/";
				  </script>';
						
			
	
    }
	
	//+++++++++++++++++++++++++++
	//ACTION FEEDBACK
	//++++++++++++++++++++++++++	
	function send_details_do($id, $pass){
      	
			$bus_id = $this->session->userdata('bus_id');	

			$query = $this->db->where('subscriber_id', $id);
			$query = $this->db->get('magnet_subscribers');
			
			$row = $query->row();	
			
			$msg = '';
			$msg .= '<p>
					<h3>Magnet Login Details</h3>
					Hi '.$row->name.' '.$row->sname.'<br><br>Your Magnet Subscriber login details are:<br><br>
					<strong>Username: </strong>'.$row->email.'<br>
					<strong>Password: </strong>'.$pass.'<br><br>

					</p>';
					
			$subject = 'Member details from Magnet';
		
			 $data1 = array(
			  'name'=>  'Magnet',
			  'email'=> 'noreply@magnet.com.na',
			  'body'=> $msg ,
			  'type'=> 'enquiry',
			  'email_to' => $row->email,
			  'subject' => $subject
			  );
			
						
		
			//SEND EMAIL LINK
			
			$this->load->model('email_model'); 
			$this->email_model->send_enquiry($data1);
		  
		  //LOG
		  $this->admin_model->system_log('send-member-details'.$row->company);


	
    }
	

				

	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
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