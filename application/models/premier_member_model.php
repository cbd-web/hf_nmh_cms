<?php
class Premier_member_model extends CI_Model{
	
 	function Premier_member_model(){
  		//parent::CI_model();
	    $this->load->library('encrypt');
		
 	}

	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_all_orders()
	{

		$bus_id = $this->session->userdata('bus_id');


		$query = $this->db->query("SELECT * FROM product_orders AS A

 								   LEFT JOIN premier_members AS B ON A.member_id = B.member_id

 								   WHERE A.bus_id = '".$bus_id."' ORDER BY A.listing_date DESC", FALSE);


		if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:5%;font-weight:bold"></th>
						<th style="width:15%;font-weight:bold">Company </th>
						<th style="width:20%;font-weight:bold">Name </th>
						<th style="width:15%;font-weight:bold">Ref No. </th>
						<th style="width:25%;font-weight:bold">Listing date </th>
						<th style="width:10%;font-weight:bold">File</th>
						<th style="width:10%;font-weight:bold"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				if($row->actioned == 'N') {

					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_order('.$row->order_id.',0,'.$row->member_id.')"><i class="icon-remove icon-red"></i></a>';

				} else {

					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_order('.$row->order_id.',1,'.$row->member_id.')"><i class="icon-ok icon-green"></i></a>';

				}

				echo '<tr id="row-'.$row->order_id.'">
						<td style="width:5%" id="act-'.$row->order_id.'">'.$actioned.'</td>
						<td style="width:15%">'.$row->company.'</td>
            			<td style="width:20%">'.$row->name.' '.$row->surname.'</td>
						<td style="width:15%">'.$row->ref_no.'</td>
						<td style="width:25%">'.$row->listing_date.'</td>
						<td style="width:10%;"><a href="http://premiersalesnam.com/assets/documents/orders/'.$row->link.'" target="_blank">Download Order</a></td>
						<td style="width:10%;text-align:right">
						<a title="View Order" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="http://premiersalesnam.com/assets/documents/orders/'.$row->link.'" target="_blank"><i class="icon-eye-open"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_order('.$row->order_id.','.$row->member_id.')">
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
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_member_result($id)
	{
			
		$query = $this->db->where('member_id', $id);
		$query = $this->db->get('premier_members');
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
		$company = $this->input->post('company', TRUE);
		$tel = $this->input->post('tel', TRUE);
		$email = $this->input->post('email', TRUE);
		$address = $this->input->post('address', TRUE);
		$country = $this->input->post('country', TRUE);
		$city = $this->input->post('city', TRUE);
		$type = $this->input->post('type', TRUE);
		
		$insertdata = array(
			  'name'=> $name,
			  'surname'=> $surname,
			  'company'=> $company,
			  'address'=> $address,
			  'tel'=> $tel,
			  'email'=> $email,
			  'city'=> $city,
			  'country'=> $country,
			  'type'=> $type		  
		);			
			
		$this->db->where('member_id' , $id);
		$this->db->where('bus_id' , $bus_id);
		$this->db->update('premier_members', $insertdata);
			
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
		
		if($pass == $pass2) {
		
			$password = md5($pass);
			
			$insertdata = array(
				  'password'=> $password,
				  'p_forget'=> $pass		  
			);
			
				
			$this->db->where('member_id' , $id);
			$this->db->where('bus_id' , $bus_id);
			$this->db->update('premier_members', $insertdata);
			
			echo 'success';	
		
		} else {
		
			echo 'failed';	
			
		}


	}	


	//+++++++++++++++++++++++++++
	//GET MEMBER ORDER HISTORY
	//++++++++++++++++++++++++++
	public function get_member_order_history($id)
	{

		 $bus_id = $this->session->userdata('bus_id');	

			 
		 $query = $this->db->query("SELECT * FROM product_orders WHERE bus_id = '".$bus_id."' AND member_id ='".$id."'  ORDER BY listing_date DESC", FALSE);	

 
		  if($query->result()){
			  
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:5%;font-weight:bold"></th>
						<th style="width:35%;font-weight:bold">Order No </th>
						<th style="width:25%;font-weight:bold">listing_date </th>
						<th style="width:35%;font-weight:bold"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				if($row->actioned == 'N') { 
					
					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_order('.$row->order_id.',0,'.$row->member_id.')"><i class="icon-remove icon-red"></i></a>'; 
					
				} else {
					
					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_order('.$row->order_id.',1,'.$row->member_id.')"><i class="icon-ok icon-green"></i></a>'; 
					
				}
				
				echo '<tr>
						<td style="width:5%">'.$actioned.'</td>
						<td style="width:35%">'.$row->ref_no.'</td>
            			<td style="width:35%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">				
						<a title="View Order" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="http://premiersalesnam.com/assets/documents/orders/'.$row->link.'" target="_blank"><i class="icon-eye-open"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_order('.$row->order_id.','.$row->member_id.')">
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
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_all_members()
	{

		 $bus_id = $this->session->userdata('bus_id');	

			 
		 $query = $this->db->query("SELECT * FROM premier_members WHERE bus_id = '".$bus_id."' ORDER BY company ASC", FALSE);	


		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:5%;font-weight:bold"></th>
						<th style="width:15%;font-weight:bold">Company </th>
						<th style="width:20%;font-weight:bold">Name </th>
						<th style="width:15%;font-weight:bold">Phone </th>
						<th style="width:25%;font-weight:bold">Email </th>
						<th style="width:10%;font-weight:bold">Country </th>
						<th style="width:10%;font-weight:bold"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				if($row->active == 'N') { 
					
					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_member('.$row->member_id.',0)"><i class="icon-remove icon-red"></i></a>'; 
					
				} else {
					
					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_member('.$row->member_id.',1)"><i class="icon-ok icon-green"></i></a>'; 
					
				}
				
				echo '<tr>
						<td style="width:5%">'.$actioned.'</td>
						<td style="width:15%">'.$row->company.'</td>
            			<td style="width:20%">'.$row->name.' '.$row->surname.'</td>
						<td style="width:15%">'.$row->tel.'</td>
						<td style="width:25%">'.$row->email.'</td>
						<td style="width:10%;">'.$row->country.'</td>
						<td style="width:10%;text-align:right">				
						<a title="View Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'premier_members/view_member/'.$row->member_id.'"><i class="icon-eye-open"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_member('.$row->member_id.')">
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
			  $query = $this->db->where('member_id', $id);
			  $this->db->delete('premier_members');

			/*	$file =  BASE_URL.'assets/documents/' . $doc; # build the full path		
				
				if (file_exists($file)) {
					unlink($file);
				}
			*/			  	  
			  
			  //LOG
			  $this->admin_model->system_log('delete_member-'.$id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'premier_members/members/";
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
			

			
			$this->db->where('member_id' , $id);
			$this->db->where('bus_id' , $bus_id);
			$this->db->update('premier_members', $insertdata);
			
			if($status == 0) {
				// SEND MAILS
				$query = $this->db->where('member_id', $id);
				$query = $this->db->get('premier_members');
				
				$row = $query->row();	
				
				$msg = '';
				$msg .= '<p>
						<h3>Premeier Sales Login Details</h3>
						Hi '.$row->name.' '.$row->surname.'<br><br>Your Premier Sales Account has been activated.<br><br>Your login details are:<br><br>
						<strong>Username: </strong>'.$row->email.'<br>
						<strong>Password: </strong>'.$row->p_forget.'<br><br>
	
						</p>';
						
				$subject = 'Member details from Premier Sales';
			
				 $data1 = array(
				  'name'=>  'Premier Sales',
				  'email'=> 'noreply@premiersales.com',
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
				   window.location = "'.site_url('/').'premier_members/members/";
				  </script>';
						
			
	
    }
	
	//+++++++++++++++++++++++++++
	//ACTION FEEDBACK
	//++++++++++++++++++++++++++	
	function send_details_do($id){
      	
			$bus_id = $this->session->userdata('bus_id');	

			$query = $this->db->where('member_id', $id);
			$query = $this->db->get('premier_members');
			
			$row = $query->row();	
			
			$msg = '';
			$msg .= '<p>
					<h3>Premeier Sales Login Details</h3>
					Hi '.$row->name.' '.$row->surname.'<br><br>Your Premier Sales login details are:<br><br>
					<strong>Username: </strong>'.$row->email.'<br>
					<strong>Password: </strong>'.$row->p_forget.'<br><br>

					</p>';
					
			$subject = 'Member details from Premier Sales';
		
			 $data1 = array(
			  'name'=>  'Premier Sales',
			  'email'=> 'noreply@premiersales.com',
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
	
	
	//+++++++++++++++++++++++++++
	//DELETE ORDER
	//++++++++++++++++++++++++++	
	function delete_order_do($id, $mid){
      	
		if($this->session->userdata('admin_id')){
			
			  $bus_id = $this->session->userdata('bus_id');
			  //delete from database1
			  
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('order_id', $id);
			  $this->db->delete('product_orders');
			  	  
			  
			  //LOG
			  $this->admin_model->system_log('delete_orderr-'.$id);
			  $this->session->set_flashdata('msg','Order deleted successfully');
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }	
	
	//+++++++++++++++++++++++++++
	//ACTION ORDER
	//++++++++++++++++++++++++++	
	function action_order_do($id,$status,$mid){
      	
		$bus_id = $this->session->userdata('bus_id');	
		
			if($status == 0) { $actioned = 'Y'; }
			if($status == 1) { $actioned = 'N'; }
		
			$insertdata = array(
				  'actioned'=> $actioned		  
			);
			

			
			$this->db->where('order_id' , $id);
			$this->db->where('bus_id' , $bus_id);
			$this->db->update('product_orders', $insertdata);
			  
		  
			  //LOG
			  $this->admin_model->system_log('action-order-'.$id);
			  $this->session->set_flashdata('msg','Order actioned successfully');
						
			
	
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