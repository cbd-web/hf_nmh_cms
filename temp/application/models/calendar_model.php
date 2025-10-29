<?php
class Calendar_model extends CI_Model{
	
 	function calendar_model(){
  		//parent::CI_model();
			
 	}

		  /**
++++++++++++++++++++++++++++++++++++++++++++
//EVENTS
//END
++++++++++++++++++++++++++++++++++++++++++++	
 */ 	
		
function get_events(){
	
	   $bus_id = $this->session->userdata('bus_id');
	   $query = $this->db->query("SELECT event_id as id,title,startdate as start, DATE_FORMAT(startdate, '%Y-%m-%d %H:%i' ) AS startDate,url, enddate, allday as allDay FROM calendar_events WHERE bus_id = '".$bus_id."' ORDER BY startDate DESC");  


		if($query->result()){
			$x = 0;

			foreach($query->result() as $row){
				
				$event_id = $row->id;
				$allDay = $row->allDay;
				$title = $row->title;
				$start = date('Y-m-d H:i',strtotime($row->start));
				$url = $row->url;
				$end = date('Y-m-d H:i',strtotime($row->enddate));
				
				$past_event = ' color: "#C60"';
				if(date('y-m-d',strtotime($row->start)) < date('y-m-d',time())){
				  $past_event = ' textColor: "#ccc", color: "#fff", className :"fc-event-skin-past"';
				}
				
				if($x == $query->num_rows()){
					
					$comma = '';
				}else{
					
					$comma = ',';
				}
				echo '{ id: "'.$event_id.'",allDay: '.$allDay.', title: "'.substr($title,'0','15').'",start: "'.$start.'", end: "'.$end.'", url: "'.$url.'",'.$past_event.'}'.$comma;
				//$arr[] = $row;	
			    $x++;
				
			}
			//echo json_encode($arr);

		}else{
			
			echo '{}';
		}
	
}


function get_birthdays(){
		
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->query("SELECT child_id as id, CONCAT(`fname`, ' ', `sname`) as title,dob as start, DATE_FORMAT(dob, '%m-%d %H:%i' ) AS startDate, 'javascript:show_bday()' as url, dob as end FROM children WHERE bus_id = '".$bus_id."' ORDER BY startDate DESC");
		
		if($query->result()){
			$x = 1;
			
			foreach($query->result() as $row){
				
				$child_id = $row->id;
				$title = $row->title;
				$start = 'new Date(y, "'.(date('m',strtotime($row->start)) -1).'","'.date('d',strtotime($row->start)).'")';
				$url = 'google.com';
				$end = 'new Date(y, "'.(date('m',strtotime($row->start)) -1).'","'.date('d',strtotime($row->start)).'")';
				
				if($x == $query->num_rows()){
					
					$comma = '';
				}else{
					
					$comma = ',';
				}
				echo '{ id: "'.$child_id .'",allDay: true, title: "'.substr($title,'0','15').'",start: '.$start.', color: "#f8800b"}'.$comma;
				//$arr[] = $row;	
			    $x++;
			}
			//echo json_encode($arr);
			
		}else{
			
			echo '{}';
		}
	
} /**
++++++++++++++++++++++++++++++++++++++++++++
//EVENTS
//GET All
++++++++++++++++++++++++++++++++++++++++++++	
 */ 		
	function get_event($event_id){
      	
		
        $test = $this->db->from('calendar_events');
		$test = $this->db->where('event_id', $event_id);
		
		$test = $this->db->get();
		$test = $test->row_array();
		return $test;		  
    }	



	//GET RECENT EVENTS
	function upcoming_events(){
			
			$bus_id = $this->session->userdata('bus_id');
			$query = $this->db->query("SELECT * from calendar_events WHERE startdate > NOW() AND bus_id = '".$bus_id."' ORDER BY startdate ASC LIMIT 4",FALSE);
			 
			if($query->num_rows() > 0){
				foreach($query->result() as $row2){
						
						$event_id = $row2->event_id;
						$title = $row2->title;
						$description = $row2->description;
						$startdate = $row2->startdate;
						$enddate = $row2->enddate;
						$allday = $row2->allday;
						$data = $this->calendar_model->get_event($event_id);
					
						if($allday == 'false'){
			   
							$date = date('F j, g:i a',strtotime($data['startdate'])). ' til ' . date('g:i a',strtotime($data['enddate'])); 
							   
						   }else{
							   
							   if(date('d',strtotime($data['startdate'])) == date('d',strtotime($data['enddate']))){
								   
								   $date = date('D jS F',strtotime($data['startdate']));
								   
							   }else{
								  
								  $date = date('D jS F',strtotime($data['startdate'])). ' til ' . date('D jS F',strtotime($data['enddate'])); 
								   
							   }
				   
						   }

					
					
                      echo'<div class="box-header">
								<h2><i class="icon-calendar"></i><span class="break"></span>'.
										$title .'</h2>
							</div>
							<div class="box-content">
							 '.$this->shorten_string($description,10).'
							  <div class="clearfix"></div>
							  <a style="float:right;margin:0 3px;cursor:pointer" class="btn" onclick="javascript:show_event('.$event_id.')" rel="tooltip" title="View"><i class="icon-eye-open"></i></a>
								<small style="color:#CCC">'.$date.'</small>
								<div class="clearfix" style="height:20px"></div>
							</div><br />';
							
						
						
				}
			}
		
		if(isset($query)){
				
			return $query;
			
		}else{
			
			return '<div class="alert">
        		 <button type="button" class="close" data-dismiss="alert">×</button>
            	 No new learning stories have been added
       		 </div>';
		}
			
    }
	

		  /**
++++++++++++++++++++++++++++++++++++++++++++
//BOOKINGS
//END
++++++++++++++++++++++++++++++++++++++++++++	
 */ 	
		
function get_bookings(){
	
	   $bus_id = $this->session->userdata('bus_id');
	   $query = $this->db->query("SELECT booking_id as id,name,arrival ,DATE_FORMAT(arrival, '%Y-%m-%d %H:%i' ) AS startDate,type, departure FROM bookings WHERE bus_id = '".$bus_id."' AND type = 'confirmed' ORDER BY arrival DESC");  


		if($query->result()){
			$x = 0;

			foreach($query->result() as $row){
				
				$event_id = $row->id;
				$allDay = 'true';
				$title = $row->name;
				$start = date('Y-m-d H:i',strtotime($row->startDate));
				$url = $row->type;
				$end = date('Y-m-d H:i',strtotime($row->departure));
				
				$past_event = ' color: "#C60"';
				if(date('y-m-d',strtotime($row->start)) < date('y-m-d',time())){
				  $past_event = ' textColor: "#ccc", color: "#fff", className :"fc-event-skin-past"';
				}
				
				if($x == $query->num_rows()){
					
					$comma = '';
				}else{
					
					$comma = ',';
				}
				echo '{ id: "'.$event_id.'",allDay: '.$allDay.', title: "'.substr($title,'0','15').'",start: "'.$start.'", end: "'.$end.'", url: "'.$url.'",'.$past_event.'}'.$comma;
				//$arr[] = $row;	
			    $x++;
				
			}
			//echo json_encode($arr);

		}else{
			
			echo '{}';
		}
	
}




	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}	
	function connect_main_db(){
		
		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'root';
		$config_db['password'] = 'my-child123';
		$config_db['database'] = 'child';
		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
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