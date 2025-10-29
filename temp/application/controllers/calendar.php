<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller {


	 function calendar()
	{
		parent::__construct();
		$this->load->model('calendar_model');

		//force_ssl();
	}
	public function index()
	{
		
		
	
	}
	
	
	function event($event_id)
	{

		 $data['event'] = $this->calendar_model->get_event($event_id);
		 $this->load->view('calendar/view',$data);	
		
	}
	
	function reload()
	{

		  $this->load->view('admin/inc/calendar_inc');
		  
 
	}
	function reload_upcoming()
	{

		 $this->calendar_model->upcoming_events();

	}
	
	function show_event($event_id)
	{

		   $data = $this->calendar_model->get_event($event_id);
		   if($data['allday'] == 'false'){
			   
			   $date = date('F j, g:i a',strtotime($data['startdate'])). ' til ' . date('g:i a',strtotime($data['enddate'])); 
			   
		   }else{
			   
			   if(date('d',strtotime($data['startdate'])) == date('d',strtotime($data['enddate']))){
				   
				   $date = date('D jS F',strtotime($data['startdate']));
				   
			   }else{
				  
				  $date = date('D jS F',strtotime($data['startdate'])). ' til ' . date('D jS F',strtotime($data['enddate'])); 
				   
			   }
			   
			   
		   }
		   echo "<div class='span8'>".$data['description']."<br /><font style='font-size:12px;font-style:italic'>".$date."</font></div>
		   			<div class='span4'>
					<h5>
					".$data['creator']."</h5></div>
		   		 <script type='text/javascript'>
		   			$('#event_title').html('".$data['title']."');
				</script>";	
 
	}
	
	function show_event_edit($event_id)
	{

		   $data = $this->calendar_model->get_event($event_id);

		   if($data['allday'] == 'false'){
			   
			  $date = date('F j, g:i a',strtotime($data['startdate'])). ' til ' . date('g:i a',strtotime($data['enddate'])); 
			   
		   }else{
			   
			   if(date('d',strtotime($data['startdate'])) == date('d',strtotime($data['enddate']))){
				   
				   $date = date('D jS F',strtotime($data['startdate']));
				   
			   }else{
				  
				  $date = date('D jS F',strtotime($data['startdate'])). ' til ' . date('D jS F',strtotime($data['enddate'])); 
				   
			   }
   
		   }
		   
			
			 $btn = "$('#edit_btn').show();
			 		$('#edit_btn').attr('href','javascript:delete_story(".$event_id.")');
			 ";  
			   
		  
		   echo "<div class='span5'>".$data['description']."<br /><font style='font-size:12px;font-style:italic'>".$date."</font></div>
		   			<div class='span4'>
					<h5>
					".$data['creator']."</h5></div>
		   		 <script type='text/javascript'>
		   			$('#event_title').html('".$data['title']."');".
					$btn."
				</script>";	
 
				
			
	}
	
	public function add_event()
	{
		
		$content = $this->input->post('content');
		$description = $this->input->post('description',FALSE);
		$title = $this->input->post('title', TRUE);
		$startdate = $this->input->post('startdate', TRUE);
		$enddate = $this->input->post('enddate', TRUE);
		$allday = $this->input->post('allday', TRUE);
		$type = $this->input->post('type', TRUE);
	    $creator = $this->session->userdata('u_name');
		$url = "javascript:show_event('')";
		$bus_id = $this->session->userdata('bus_id');
		$insertdata = array(
				'title'=> $title ,
				'startdate'=> $startdate,
				'enddate'=> $enddate,
				'allday'=> $allday ,
				'description'=> html_entity_decode($description),
				'url' => $url,
				'creator' => $creator,
				'type' => strtolower($type),
				'bus_id'=> $bus_id
		);
		
		$this->db->insert('calendar_events', $insertdata);
		
		//GET ID
		$this->db->where('title',$title);
		$this->db->where('creator',$creator);
		$this->db->where('description',html_entity_decode($description));
		$row = $this->db->get('calendar_events');
		$row = $row->row_array();
		$event_id = $row['event_id'];
		
		$data['url'] = "javascript:show_event('".$event_id."')";
 		//Update URl FIELD
		$this->db->where('event_id',$event_id);
		$this->db->update('calendar_events',$data);

	
	}
	
	
	public function change_event()
	{

		
		$event_id = $this->input->post('id', TRUE);
		$days = $this->input->post('days', TRUE);
		$minutes = $this->input->post('minutes', TRUE);
		$allday = $this->input->post('allday', TRUE);

		
		
		////GET ID
		$this->db->where('event_id',$event_id);
		$row = $this->db->get('calendar_events');
		$row = $row->row_array();
		$creatordb = $this->session->userdata('u_name');
		$OGstart = strtotime($row['startdate']);
		$OGend = strtotime($row['enddate']);
		
		$Nstart = strtotime(" ".$days ." day", $OGstart);
		$Nstart = strtotime($minutes ." minutes", $Nstart);
		
		$Nend = strtotime($days ." day", $OGend);
		$Nend = strtotime($minutes ." minutes", $Nend);
		
		
		
		$insertdata = array(
			
			'startdate'=> date('Y-m-d H:i:s' , $Nstart),
			'enddate'=>  date('Y-m-d H:i:s' ,$Nend),
			'allday'=> $allday 
			
		);
		
		$this->db->where('event_id', $event_id);
		$this->db->update('calendar_events', $insertdata);
		echo '<script type="text/javascript">$("#modal-event-change").modal("hide");reload_calendar();</script>';

	}
	
	
	public function extend_event()
	{

		$event_id = $this->input->post('id', TRUE);
		$days = $this->input->post('days', TRUE);
		$minutes = $this->input->post('minutes', TRUE);
		//$allday = $this->input->post('allday', TRUE);

		
		////GET ID
		$this->db->where('event_id',$event_id);
		$row = $this->db->get('calendar_events');
		$row = $row->row_array();
		$creatordb = $row['creator'];
		$OGstart = strtotime($row['startdate']);
		$OGend = strtotime($row['enddate']);
		
		
		$Nend = strtotime($days ." day", $OGend);
		$Nend = strtotime($minutes ." minutes", $Nend);
		//HAS PRIVELEDGES
		if($logged_in_owner != 'yes'){
			
			if(trim($creator) == trim($creatordb)){
				
				$insertdata = array(

					'enddate'=>  date('Y-m-d H:i:s' ,$Nend)
					
				);
				
				$this->db->where('event_id', $event_id);
				$this->db->update('calendar_events', $insertdata);
				/*echo '<script type="text/javascript">$("#modal-event-change").modal("hide");</script>';*/
				echo 'Changed';
			//NO PRIVELEDGES	
			}else{
				
				
				echo '<script type="text/javascript">
					  var x =  event.clientX + document.body.scrollLeft;
					 var y = event.clientY + document.body.scrollTop;
					 $("#modal-event-msg").css({ top: (y-10)+"px", left: (x-190)+"px"}).fadeIn().delay("2000").fadeOut();
					 $("#event_modal_msg").html("<h3>Sorry!</h3>You do not have permission to change this event"); 									  					</script>';
				
				
			}
		//OWNER LOGGED IN	
		}else{
			
			$insertdata = array(
					
					'enddate'=>  date('Y-m-d H:i:s' ,$Nend)

			  );
			  
			  $this->db->where('event_id', $event_id);
			  $this->db->update('calendar_events', $insertdata);
			 /*echo '<script type="text/javascript">$("#modal-event-change").modal("hide");</script>';*/
				echo 'Changed';
			
		}
	}
	
	//DELETE EVENT
	function delete_event($event_id)
	{
		 
			$this->db->where('event_id' , $event_id);
			$this->db->delete('calendar_events');
	
	}	
	
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */