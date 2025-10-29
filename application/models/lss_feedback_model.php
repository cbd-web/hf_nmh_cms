<?php
class Lss_feedback_model extends CI_Model{
	
 	function lss_feedback_model(){
  		//parent::CI_model();
	    $this->load->library('encrypt');
		
 	}

	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_feedback_result($id)
	{
			
		$query = $this->db->where('feedback_id', $id);
		$query = $this->db->get('lss_feedback2');
		return $query->row_array();	

	}
	
	public function get_rating($rate) {
		
		switch($rate) {
		
			case 0:
			$rated = '0';
			break;
			case 1:
			$rated = '25';
			break;
			case 2:
			$rated = '50';
			break;
			case 3:
			$rated = '75';
			break;
			case 4:
			$rated = '100';
			break;											
			
		}
		
		return $rated;
	}
	

	public function get_overall_rating($rates) {
	
	
		$sum = array_sum($rates);
		$count = count($rates);
			
		$total = $sum / $count;
		
		return $total;
	}	


	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_all_feedback()
	{
		 // $query = $this->db->order_by('datetime', 'ASC');
		 $bus_id = $this->session->userdata('bus_id');	

			 
		 $query = $this->db->query("SELECT * FROM lss_feedback2 WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);	


		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:5%;font-weight:bold"></th>
						<th style="width:15%;font-weight:bold">Company </th>
						<th style="width:20%;font-weight:bold">Name </th>
						<th style="width:15%;font-weight:bold">Phone </th>
						<th style="width:25%;font-weight:bold">Email </th>
						<th style="width:10%;font-weight:bold">Overall</th>
						<th style="width:10%;font-weight:bold"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				if($row->actioned == 'N') { 
					
					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_feedback('.$row->feedback_id.',0)"><i class="icon-remove icon-red"></i></a>'; 
					
				} else {
					
					$actioned = '<a title="Action Entry" rel="tooltip" style="cursor:pointer" onclick="action_feedback('.$row->feedback_id.',1)"><i class="icon-ok icon-green"></i></a>'; 
					
				}
				
				echo '<tr>
						<td style="width:5%">'.$actioned.'</td>
						<td style="width:15%">'.$row->company.'</td>
            			<td style="width:20%">'.$row->name.'</td>
						<td style="width:15%">'.$row->phone.'</td>
						<td style="width:25%">'.$row->email.'</td>
						<td style="width:10%;">'.$row->lss_overall.'</td>
						<td style="width:10%;text-align:right">				
						<a title="View Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'lss_feedback/view_feedback/'.$row->feedback_id.'"><i class="icon-eye-open"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_feedback('.$row->feedback_id.')">
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
	//DELETE SUBSCRIBERS
	//++++++++++++++++++++++++++	
	function delete_feedback_do($id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database1
			  $query = $this->db->where('feedback_id', $id);
			  $this->db->delete('lss_feedback2');
			  	  
			  
			  //LOG
			  $this->admin_model->system_log('delete_feedback-'.$id);
			  $this->session->set_flashdata('msg','Feedback deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'lss_feedback/feedback/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }	
	
	//+++++++++++++++++++++++++++
	//ACTION FEEDBACK
	//++++++++++++++++++++++++++	
	function action_feedback_do($id,$status){
      	
		$bus_id = $this->session->userdata('bus_id');	
		
			if($status == 0) { $actioned = 'Y'; }
			if($status == 1) { $actioned = 'N'; }
		
			$insertdata = array(
				  'actioned'=> $actioned		  
			);
			

			
			$this->db->where('feedback_id' , $id);
			$this->db->where('bus_id' , $bus_id);
			$this->db->update('lss_feedback2', $insertdata);
			  
		  
			  //LOG
			  $this->admin_model->system_log('action_feedback-'.$id);
			  $this->session->set_flashdata('msg','Feedback actioned successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'lss_feedback/feedback/";
				  </script>';
						
			
	
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