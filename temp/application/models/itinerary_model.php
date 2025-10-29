<?php
class Itinerary_model extends CI_Model{
	
 	function itinerary_model(){
  		//parent::CI_model();			
 	}
	
	
	
	//+++++++++++++++++++++++++++
	//LOAD HIGHLIGHT TYPE SELECT LIST
	//++++++++++++++++++++++++++
	
	function get_high_type_select($type_id="")
	{
		
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->get('i_highlight_types');
		  
		  if($query->result()){
			
			foreach($query->result() as $row){
				
				if($type_id == $row->type_id) { $selected = 'selected'; } else { $selected = ''; }
				
				echo '
					<option value="'.$row->type_id.'" '.$selected.'>'.$row->type.'</option>
				';
			}
		 }
	}
	
	
	
	//+++++++++++++++++++++++++++
	//LOAD DESTINATION TYPE SELECT LIST
	//++++++++++++++++++++++++++
	
	function get_dest_type_select($type_id="")
	{
		
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->get('i_destination_types');
		  
		  if($query->result()){
			
			foreach($query->result() as $row){
				
				if($type_id == $row->type_id) { $selected = 'selected'; } else { $selected = ''; }
				
				echo '
					<option value="'.$row->type_id.'" '.$selected.'>'.$row->type.'</option>
				';
			}
		 }
	}


	//+++++++++++++++++++++++++++
	//LOAD ACCOMMODATION TYPE SELECT LIST
	//++++++++++++++++++++++++++
	
	function get_acc_type_select($type_id="")
	{
		
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->get('i_accommodation_types');
		  
		  if($query->result()){
			
			foreach($query->result() as $row){
				
				if($type_id == $row->type_id) { $selected = 'selected'; } else { $selected = ''; }
				
				echo '
					<option value="'.$row->type_id.'" '.$selected.'>'.$row->type.'</option>
				';
			}
		 }
	}	
	
	
	//+++++++++++++++++++++++++++
	//LOAD TOURS SELECT LIST
	//++++++++++++++++++++++++++
	
	function get_tours_select($tour_id="")
	{
		
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->select('title');
		  $query = $this->db->select('tour_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('i_tours');
		  
		  if($query->result()){
			
			foreach($query->result() as $row){
				
				if($tour_id == $row->tour_id) { $selected = 'selected'; } else { $selected = ''; }
				
				echo '
					<option value="'.$row->tour_id.'" '.$selected.'>'.$row->title.'</option>
				';
			}
		 }
	}		
	
	
	
	
	 //+++++++++++++++++++++++++++
	 //GET SPECIAL DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_special($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('special_id', $id);
		  $query = $this->db->get('i_tour_specials');
		  
		  return $query->row_array(); 
	
	 }
	 


	//+++++++++++++++++++++++++++
	//GET ALL SPECIALS
	//++++++++++++++++++++++++++
	public function get_all_specials()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_tour_specials');
		  
		  if($query->result()){
			echo'<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:34%;font-weight:normal">Valid Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr class="myDragClass" id="row-'.$row->special_id.'">
						<input type="hidden" value="'.$row->special_id.'" />
						<td style="width:6%">'.$status.'</td>
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_special/'.$row->special_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->tour.'</div></a></td>
						<td style="width:34%">'.date('Y-m-d',strtotime($row->valid_from)).' - '.date('Y-m-d',strtotime($row->valid_to)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_special/'.$row->special_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_special('.$row->special_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var special_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_special_sequence/"+special_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Specials added</h3>
					No specials have been added. to add a new special please click on the add special button on the right</div>';
		  
		 }
				
		
	}	




	//+++++++++++++++++++++++++++
	//ADD SPECIALS DO
	//++++++++++++++++++++++++++	
	function add_special_do()
	{
		if($this->session->userdata('admin_id')){
		
			$tour_id = $this->input->post('tour', TRUE);
			
			//GET TOUR TITLE
			$this->db->select('title');
			$this->db->where('tour_id', $tour_id);
			$typ = $this->db->get('i_tours');
			
			$row = $typ->row();
			
			$tour = $row->title;				
			
			$valid_from = $this->input->post('valid_from', TRUE);
			$valid_to = $this->input->post('valid_to', TRUE);
				
			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			$bus_id = $this->session->userdata('bus_id');
						
			$val = TRUE;
			
			if($val == TRUE){
				
					$insertdata = array(
					  'tour'=> $tour ,
					  'tour_id'=> $tour_id ,
					  'valid_from'=> $valid_from ,
					  'valid_to'=> $valid_to ,
					  'description'=> $body ,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_tour_specials', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_tour_special-'.$tour);
					
					//success redirect	
					$this->session->set_flashdata('msg','Tour Special added successfully');
					$data['basicmsg'] = 'Tour Special has been added successfully';
					

					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_special/'.$id.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = '';
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}		
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE SPECIAL DO
	//++++++++++++++++++++++++++	
	function update_special_do() 
	{
		if($this->session->userdata('admin_id')){
			
			$tour_id = $this->input->post('tour', TRUE);
			
			//GET TOUR TITLE
			$typ = $this->db->select('title');
			$typ = $this->db->where('tour_id', $tour_id);
			$typ = $this->db->get('i_tours');
			
			$row = $typ->row();
			
			$tour = $row->title;				
			
			$featured = $this->input->post('featured', TRUE);
			
			$valid_from = $this->input->post('valid_from', TRUE);
			$valid_to = $this->input->post('valid_to', TRUE);
			
			$bus_id = $this->session->userdata('bus_id');
			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

			$id = $this->input->post('id', TRUE);		
			
			$status = $this->input->post('status', TRUE);

			$val = TRUE;

			
			if($val == TRUE){
				
					$updatedata = array(
					  'tour'=> $tour ,
					  'tour_id'=> $tour_id ,
					  'valid_from'=> $valid_from ,
					  'valid_to'=> $valid_to ,
					  'featured'=> $featured ,
					  'description'=> $body ,
					  'status'=> $status
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('special_id' , $id);
					$this->db->update('i_tour_specials', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_tour_special-'. $tour);
					$data['basicmsg'] = 'Tour Special has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 
	//+++++++++++++++++++++++++++
	//DELETE SPECIAL DO
	//++++++++++++++++++++++++++
	function delete_special_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
						  			
				
			  //delete from database
			  $this->db->where('special_id', $id);
			  $this->db->delete('i_tour_specials');
	  
			  			  
			  //LOG
			  $this->admin_model->system_log('delete_tour_special-'.$id);
			  $this->session->set_flashdata('msg','Tour Special deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }


	
	
	
	
	
//-------------------DESTINATIONS MANAGEMENT-------------------------//
//------------------------------------------------------------------// 	



	 //+++++++++++++++++++++++++++
	 //GET DESTINATION DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_destination($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('destination_id', $id);
		  $query = $this->db->get('i_destinations');
		  
		  return $query->row_array(); 
	
	 }
	 
	//+++++++++++++++++++++++++++
	//GET ALL DESTINATIONS
	//++++++++++++++++++++++++++
	public function get_all_destinations()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'DESC');
		  $query = $this->db->get('i_destinations');
		  
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr id="row-'.$row->destination_id.'">
						<td style="width:6%">'.$status.'</td>
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_destination/'.$row->destination_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_destination/'.$row->destination_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_destination('.$row->destination_id.')">
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
			 		<h3>No Destinations added</h3>
					No destinations have been added. to add a new destination please click on the add destination button on the right</div>';
		  
		 }
				
		
	}
	 
	//+++++++++++++++++++++++++++
	//ADD DESTINATIONS DO
	//++++++++++++++++++++++++++	
	function add_destination_do()
	{
		if($this->session->userdata('admin_id')){
		
			$title = $this->input->post('title', TRUE);

			$type_id = $this->input->post('type', TRUE);
			
			if($type_id != '0') {
			
			//GET TYPE TITLE
			$typ = $this->db->select('type');
			$typ = $this->db->where('type_id', $type_id);
			$typ = $this->db->get('i_destination_types');
			
			$row = $typ->row();
			
			$type = $row->type;		
			
			} else {
				
				$type = '';	
				
			}
			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			
			$bus_id = $this->session->userdata('bus_id');
		
				
			$slug = $this->clean_url_str($title);


			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Destination title Required';
											
			}else{
				$val = TRUE;
			}
	
			if($val == TRUE){
				
					$insertdata = array(
					  'title'=> $title ,
					  'type_id'=>$type_id ,
					  'type'=> $type,
					  'description'=> $body ,
					  'lat' => '-22.5632824' ,
					  'lng' => '17.0707275' ,
					  'slug'=> $slug,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_destinations', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_destination-'.$title);
					
					//success redirect	
					$this->session->set_flashdata('msg','Destination added successfully');
					$data['basicmsg'] = 'Destination has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_destination/'.$id.'/";
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
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE DESTINATION DO
	//++++++++++++++++++++++++++	
	function update_destination_do() 
	{
		if($this->session->userdata('admin_id')){
			
			$title = $this->input->post('title', TRUE);	
			
			$type_id = $this->input->post('type', TRUE);
			
			if($type_id != '0') {
			
			//GET TYPE TITLE
			$typ = $this->db->select('type');
			$typ = $this->db->where('type_id', $type_id);
			$typ = $this->db->get('i_destination_types');
			
			$row = $typ->row();
			
			$type = $row->type;		
			
			} else {
				
				$type = '';	
				
			}
				
			$lat = $this->input->post('lat', TRUE);	
			$lng = $this->input->post('lng', TRUE);		
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$video = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('video', FALSE)));
			$id = $this->input->post('id', TRUE);		
			$slug = $this->clean_url_str($title);
			
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');	
			
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Description Title Required';	
			}else{
				$val = TRUE;
			}
			
			if($val == TRUE){
				
					$updatedata = array(
						  'title'=> $title ,
						  'type_id'=>$type_id ,
						  'type'=> $type,						  
						  'lat'=> $lat ,
						  'lng'=> $lng ,
						  'status'=> $status ,
						  'description'=> $body ,
						  'video'=> $video ,
						  'slug'=> $slug
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('destination_id' , $id);
					$this->db->update('i_destinations', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_itinerary_destination-'. $title);
					$data['basicmsg'] = 'Destination has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 
	//+++++++++++++++++++++++++++
	//DELETE DESTINATION DO
	//++++++++++++++++++++++++++
	function delete_destination_do($id ){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  //unlink pictures	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('type_id', $id);
			  $query = $this->db->where('type', 'destination');
			  $query = $this->db->get('i_images');
				
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					$file =  BASE_URL.'assets/itinerary/images/' . $row->img_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
					
				  }			
			  }				
				
			  //delete from database
			  $this->db->where('destination_id', $id);
			  $this->db->delete('i_destinations');
			  
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('type_id', $id);
			  $this->db->where('type', 'destination');
			  $this->db->delete('i_images');			  
			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_destination-'.$id);
			  $this->session->set_flashdata('msg','Destination deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	 





//-------------------ACCOMMODATION MANAGEMENT-------------------------//
//------------------------------------------------------------------// 	

	 //+++++++++++++++++++++++++++
	 //GET ACCOMMODATION DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_accommodation($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('accommodation_id', $id);
		  $query = $this->db->get('i_accommodations');
		  
		  return $query->row_array(); 
	
	 }
	 
	//+++++++++++++++++++++++++++
	//GET ALL ACCOMMODATIONS
	//++++++++++++++++++++++++++
	public function get_all_accommodations()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'DESC');
		  $query = $this->db->get('i_accommodations');
		  
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr id="row-'.$row->accommodation_id.'">
						<td style="width:6%">'.$status.'</td>
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_accommodation/'.$row->accommodation_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_accommodation/'.$row->accommodation_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_accommodation('.$row->accommodation_id.')">
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
			 		<h3>No Accommodations added</h3>
					No accommodations have been added. to add a new accommodation please click on the add accommodation button on the right</div>';
		  
		 }
				
		
	}
	 
	//+++++++++++++++++++++++++++
	//ADD ACCOMMODATION DO
	//++++++++++++++++++++++++++	
	function add_accommodation_do()
	{
		if($this->session->userdata('admin_id')){
		
			$title = $this->input->post('title', TRUE);
			$type_id = $this->input->post('type', TRUE);
			
			
			if($type_id != '0') {
			
			//GET TYPE TITLE
			$typ = $this->db->select('type');
			$typ = $this->db->where('type_id', $type_id);
			$typ = $this->db->get('i_accommodation_types');
			
			$row = $typ->row();
			
			$type = $row->type;	
			
			} else { 
			
			$type = '';	
			
			}

			
			
			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$website = $this->input->post('website', TRUE);
			$email = $this->input->post('email', TRUE);
			$phone = $this->input->post('phone', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$destination = $this->input->post('destination', TRUE);
			
			$bus_id = $this->session->userdata('bus_id');
						
			$slug = $this->clean_url_str($title);


			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Accommodation title Required';
											
			}else{
				$val = TRUE;
			}
	
			if($val == TRUE){
				
					$insertdata = array(
					  'title'=> $title ,
					  'type_id'=> $type_id ,
					  'type'=> $type ,
					  'description'=> $body ,
					  'website'=> $website ,
					  'email'=> $email ,
					  'phone'=> $phone ,
					  'fax'=> $fax ,
					  'destination'=> $destination ,
					  'lat' => '-22.5632824' ,
					  'lng' => '17.0707275' ,
					  'slug'=> $slug,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_accommodations', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_accommodation-'.$title);
					
					//success redirect	
					$this->session->set_flashdata('msg','Accommodation added successfully');
					$data['basicmsg'] = 'Accommodation has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_accommodation/'.$id.'/";
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
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE ACCOMMODATION DO
	//++++++++++++++++++++++++++	
	function update_accommodation_do() 
	{
		if($this->session->userdata('admin_id')){
			
			$title = $this->input->post('title', TRUE);	
			
			$type_id = $this->input->post('type', TRUE);
			
			if($type_id != '0') {
			
			//GET TYPE TITLE
			$typ = $this->db->select('type');
			$typ = $this->db->where('type_id', $type_id);
			$typ = $this->db->get('i_accommodation_types');
			
			$row = $typ->row();
			
			$type = $row->type;	
			
			} else { 
			
			$type = '';	
			
			}		
			
			$website = $this->input->post('website', TRUE);
			$email = $this->input->post('email', TRUE);
			$phone = $this->input->post('phone', TRUE);
			$fax = $this->input->post('fax', TRUE);	
			$destination = $this->input->post('destination', TRUE);			
			$lat = $this->input->post('lat', TRUE);	
			$lng = $this->input->post('lng', TRUE);		
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$video = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('video', FALSE)));
			$id = $this->input->post('id', TRUE);		
			$slug = $this->clean_url_str($title);
			
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');	
			
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Description Title Required';	
			}else{
				$val = TRUE;
			}
			
			if($val == TRUE){
				
					$updatedata = array(
					  'title'=> $title ,
					  'type_id'=> $type_id ,
					  'type'=> $type ,						  
					  'lat'=> $lat ,
					  'lng'=> $lng ,
					  'status'=> $status ,
					  'description'=> $body ,
					  'video'=> $video ,
					  'website'=> $website ,
					  'email'=> $email ,
					  'phone'=> $phone ,
					  'fax'=> $fax ,	
					  'destination'=> $destination ,					  
					  'slug'=> $slug
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('accommodation_id' , $id);
					$this->db->update('i_accommodations', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_itinerary_accommodation-'. $title);
					$data['basicmsg'] = 'Accommodation has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 
	//+++++++++++++++++++++++++++
	//DELETE ACCOMMODATION DO
	//++++++++++++++++++++++++++
	function delete_accommodation_do($id ){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  //unlink pictures	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('type_id', $id);
			  $query = $this->db->where('type', 'accommodation');
			  $query = $this->db->get('i_images');
				
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					$file =  BASE_URL.'assets/itinerary/images/' . $row->img_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
					
				  }			
			  }				
				
			  //delete from database
			  $this->db->where('accommodation_id', $id);
			  $this->db->delete('i_accommodations');
			  
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('type_id', $id);
			  $this->db->where('type', 'accommodation');
			  $this->db->delete('i_images');			  
			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_accommodation-'.$id);
			  $this->session->set_flashdata('msg','Accommodation deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }





//-------------------HIGHLIGHTS MANAGEMENT-------------------------//
//------------------------------------------------------------------// 	

	 //+++++++++++++++++++++++++++
	 //GET HIGHLIGHT DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_highlight($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('highlight_id', $id);
		  $query = $this->db->get('i_highlights');
		  
		  return $query->row_array(); 
	
	 }
	 
	//+++++++++++++++++++++++++++
	//GET ALL HIGHLIGHTS
	//++++++++++++++++++++++++++
	public function get_all_highlights()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'DESC');
		  $query = $this->db->get('i_highlights');
		  
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr id="row-'.$row->highlight_id.'">
						<td style="width:6%">'.$status.'</td>
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_highlight/'.$row->highlight_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_highlight/'.$row->highlight_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_highlight('.$row->highlight_id.')">
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
			 		<h3>No Highlights added</h3>
					No highlights have been added. to add a new highlight please click on the add highlight button on the right</div>';
		  
		 }
				
		
	}
	 
	//+++++++++++++++++++++++++++
	//ADD HIGHLIGHT DO
	//++++++++++++++++++++++++++	
	function add_highlight_do()
	{
		if($this->session->userdata('admin_id')){
		
			$title = $this->input->post('title', TRUE);
			
			$type_id = $this->input->post('type', TRUE);
			
			if($type_id != '0') {
			
			//GET TYPE TITLE
			$typ = $this->db->select('type');
			$typ = $this->db->where('type_id', $type_id);
			$typ = $this->db->get('i_highlight_types');
			
			$row = $typ->row();
			
			$type = $row->type;	
			
			} else { 
			
			$type = '';	
			
			}
			
			$destination = $this->input->post('destination', TRUE);	
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			$bus_id = $this->session->userdata('bus_id');
						
			$slug = $this->clean_url_str($title);


			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Highlight title Required';
											
			}else{
				$val = TRUE;
			}
	
			if($val == TRUE){
				
					$insertdata = array(
					  'title'=> $title ,
					  'type'=> $type,
					  'type_id'=> $type_id,
					  'description'=> $body ,
					  'destination'=> $destination , 
					  'lat' => '-22.5632824' ,
					  'lng' => '17.0707275' ,
					  'slug'=> $slug,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_highlights', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_highlight-'.$title);
					
					//success redirect	
					$this->session->set_flashdata('msg','Highlight added successfully');
					$data['basicmsg'] = 'Highlight has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_highlight/'.$id.'/";
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
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE HIGHLIGHT DO
	//++++++++++++++++++++++++++	
	function update_highlight_do() 
	{
		if($this->session->userdata('admin_id')){
			
			$title = $this->input->post('title', TRUE);	

			$type_id = $this->input->post('type', TRUE);
			
			if($type_id != '0') {
			
			//GET TYPE TITLE
			$typ = $this->db->select('type');
			$typ = $this->db->where('type_id', $type_id);
			$typ = $this->db->get('i_highlight_types');
			
			$row = $typ->row();
			
			$type = $row->type;	
			
			} else { 
			
			$type = '';	
			
			}			
			
			
			$destination = $this->input->post('destination', TRUE);				
			$lat = $this->input->post('lat', TRUE);	
			$lng = $this->input->post('lng', TRUE);		
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$id = $this->input->post('id', TRUE);		
			$slug = $this->clean_url_str($title);
			
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');	
			
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Highlight Title Required';	
			}else{
				$val = TRUE;
			}
			
			if($val == TRUE){
				
					$updatedata = array(
					  'title'=> $title ,
					  'type'=> $type,
					  'type_id'=> $type_id,						  
					  'lat'=> $lat ,
					  'lng'=> $lng ,
					  'status'=> $status ,
					  'description'=> $body ,
					  'destination'=> $destination , 						  
					  'slug'=> $slug
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('highlight_id' , $id);
					$this->db->update('i_highlights', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_itinerary_highlight-'. $title);
					$data['basicmsg'] = 'Highlight has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 
	//+++++++++++++++++++++++++++
	//DELETE HIGHLIGHT DO
	//++++++++++++++++++++++++++
	function delete_highlight_do($id ){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  //unlink pictures	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('type_id', $id);
			  $query = $this->db->where('type', 'highlight');
			  $query = $this->db->get('i_images');
				
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					$file =  BASE_URL.'assets/itinerary/images/' . $row->img_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
					
				  }			
			  }				
				
			  //delete from database
			  $this->db->where('highlight_id', $id);
			  $this->db->delete('i_highlights');
			  
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('type_id', $id);
			  $this->db->where('type', 'highlight');
			  $this->db->delete('i_images');			  
			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_highlight-'.$id);
			  $this->session->set_flashdata('msg','Highlight deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }




//-------------------ACTIVITIES MANAGEMENT-------------------------//
//------------------------------------------------------------------// 	

	 //+++++++++++++++++++++++++++
	 //GET ACTIVITY DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_activity($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('activity_id', $id);
		  $query = $this->db->get('i_activities');
		  
		  return $query->row_array(); 
	
	 }
	 
	//+++++++++++++++++++++++++++
	//GET ALL ACTIVITIES
	//++++++++++++++++++++++++++
	public function get_all_activities()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'DESC');
		  $query = $this->db->get('i_activities');
		  
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr id="row-'.$row->activity_id.'">
						<td style="width:6%">'.$status.'</td>
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_activity/'.$row->activity_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_activity/'.$row->activity_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_activity('.$row->activity_id.')">
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
			 		<h3>No Highlights added</h3>
					No activities have been added. to add a new activity please click on the add activity button on the right</div>';
		  
		 }
				
		
	}
	 
	//+++++++++++++++++++++++++++
	//ADD ACTIVITY DO
	//++++++++++++++++++++++++++	
	function add_activity_do()
	{
		if($this->session->userdata('admin_id')){
		
			$title = $this->input->post('title', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			$bus_id = $this->session->userdata('bus_id');
						
			$slug = $this->clean_url_str($title);


			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Activity title Required';
											
			}else{
				$val = TRUE;
			}
	
			if($val == TRUE){
				
					$insertdata = array(
					  'title'=> $title ,
					  'description'=> $body ,
					  'slug'=> $slug,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_activities', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_activity-'.$title);
					
					//success redirect	
					$this->session->set_flashdata('msg','Activity added successfully');
					$data['basicmsg'] = 'Activity has been added successfully';
					

					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_activity/'.$id.'/";
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
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE ACTIVITY DO
	//++++++++++++++++++++++++++	
	function update_activity_do() 
	{
		if($this->session->userdata('admin_id')){
			
			$title = $this->input->post('title', TRUE);					
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$video = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('video', FALSE)));
			$id = $this->input->post('id', TRUE);		
			$slug = $this->clean_url_str($title);
			
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');	
			
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Activity Title Required';	
			}else{
				$val = TRUE;
			}
			
			if($val == TRUE){
				
					$updatedata = array(
						  'title'=> $title ,
						  'status'=> $status ,
						  'description'=> $body ,
						  'video'=> $video ,						  
						  'slug'=> $slug
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('activity_id' , $id);
					$this->db->update('i_activities', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_itinerary_activity-'. $title);
					$data['basicmsg'] = 'Activity has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 
	//+++++++++++++++++++++++++++
	//DELETE ACTIVITY DO
	//++++++++++++++++++++++++++
	function delete_activity_do($id ){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  //unlink pictures	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('type_id', $id);
			  $query = $this->db->where('type', 'activity');
			  $query = $this->db->get('i_images');
				
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					$file =  BASE_URL.'assets/itinerary/images/' . $row->img_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
					
				  }			
			  }				
				
			  //delete from database
			  $this->db->where('activity_id', $id);
			  $this->db->delete('i_activities');
			  
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('type_id', $id);
			  $this->db->where('type', 'activity');
			  $this->db->delete('i_images');			  
			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_activity-'.$id);
			  $this->session->set_flashdata('msg','Activity deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }




//-------------------TOUR TYPES MANAGEMENT-------------------------//
//------------------------------------------------------------------// 	

	 //+++++++++++++++++++++++++++
	 //GET TOUR TYPE DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_tour_type($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('type_id', $id);
		  $query = $this->db->get('i_tour_types');
		  
		  return $query->row_array(); 
	
	 }
	 
	//+++++++++++++++++++++++++++
	//GET ALL TOUR TYPES
	//++++++++++++++++++++++++++
	public function get_all_tour_types()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_tour_types');
		  
		  if($query->result()){
			echo'<table cellpadding="0" id="sortable" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr class="myDragClass" id="row-'.$row->type_id.'">
						<input type="hidden" value="'.$row->type_id.'" />
						<td style="width:6%">'.$status.'</td>
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_tour_type/'.$row->type_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_tour_type/'.$row->type_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_tour_type('.$row->type_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var type_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_tour_type_sequence/"+type_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Tour types added</h3>
					No tour types have been added. to add a new tour type please click on the add tour type button on the right</div>';
		  
		 }
				
		
	}
	 
	//+++++++++++++++++++++++++++
	//ADD TOUR TYPE DO
	//++++++++++++++++++++++++++	
	function add_tour_type_do()
	{
		if($this->session->userdata('admin_id')){
		
			$title = $this->input->post('title', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			$bus_id = $this->session->userdata('bus_id');
						
			$slug = $this->clean_url_str($title);


			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Tour Type title Required';
											
			}else{
				$val = TRUE;
			}
	
			if($val == TRUE){
				
					$insertdata = array(
					  'title'=> $title ,
					  'description'=> $body ,
					  'slug'=> $slug,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_tour_types', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_tour_type-'.$title);
					
					//success redirect	
					$this->session->set_flashdata('msg','Tour Type added successfully');
					$data['basicmsg'] = 'Tour Type has been added successfully';
					

					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_tour_type/'.$id.'/";
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
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE TOUR TYPE DO
	//++++++++++++++++++++++++++	
	function update_tour_type_do() 
	{
		if($this->session->userdata('admin_id')){
			
			$title = $this->input->post('title', TRUE);					
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$id = $this->input->post('id', TRUE);		
			$slug = $this->clean_url_str($title);
			
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');	
			
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Tour Type Title Required';	
			}else{
				$val = TRUE;
			}
			
			if($val == TRUE){
				
					$updatedata = array(
						  'title'=> $title ,
						  'status'=> $status ,
						  'description'=> $body ,						  
						  'slug'=> $slug
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('type_id' , $id);
					$this->db->update('i_tour_types', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_itinerary_tour_type-'. $title);
					$data['basicmsg'] = 'Tour Type has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 

	//+++++++++++++++++++++++++++
	//DELETE TOUR TYPE DO
	//++++++++++++++++++++++++++
	function delete_tour_type_do($id ){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
							
				
			  //delete from database
			  $this->db->where('type_id', $id);
			  $this->db->delete('i_tour_types');
			  

			  //LOG
			  $this->admin_model->system_log('delete_itinerary_tour_type-'.$id);
			  $this->session->set_flashdata('msg','Tour Type deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }




//-------------------TOURS MANAGEMENT-------------------------//
//------------------------------------------------------------------// 	

	 //+++++++++++++++++++++++++++
	 //GET TOUR DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_tour($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('tour_id', $id);
		  $query = $this->db->get('i_tours');
		  
		  return $query->row_array(); 
	
	 }
	 
	//+++++++++++++++++++++++++++
	//GET ALL TOURS
	//++++++++++++++++++++++++++
	public function get_all_tours()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_tours');
		  
		  if($query->result()){
			echo'<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr class="myDragClass" id="row-'.$row->tour_id.'">
						<input type="hidden" value="'.$row->tour_id.'" />
						<td style="width:6%">'.$status.'</td>
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_tour/'.$row->tour_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_tour/'.$row->tour_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_tour('.$row->tour_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var tour_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_tour_sequence/"+tour_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Tours added</h3>
					No tours have been added. to add a new tour please click on the add tour button on the right</div>';
		  
		 }
				
		
	}
	 
	//+++++++++++++++++++++++++++
	//ADD TOUR DO
	//++++++++++++++++++++++++++	
	function add_tour_do()
	{
		if($this->session->userdata('admin_id')){
		
			$title = $this->input->post('title', TRUE);
			$languages = $this->input->post('languages', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			$bus_id = $this->session->userdata('bus_id');
						
			$slug = $this->clean_url_str($title);


			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Tour title Required';
											
			}else{
				$val = TRUE;
			}
	
			if($val == TRUE){
				
					$insertdata = array(
					  'title'=> $title ,
					  'languages'=> $languages ,
					  'description'=> $body ,
					  'slug'=> $slug,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_tours', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_tour-'.$title);
					
					//success redirect	
					$this->session->set_flashdata('msg','Tour added successfully');
					$data['basicmsg'] = 'Tour has been added successfully';
					

					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_tour/'.$id.'/";
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
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE TOUR DO
	//++++++++++++++++++++++++++	
	function update_tour_do() 
	{
		if($this->session->userdata('admin_id')){
			
			$title = $this->input->post('title', TRUE);			
			$languages = $this->input->post('languages', TRUE);	
			$metaD = $this->input->post('metaD', TRUE);		
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$id = $this->input->post('id', TRUE);		
			$slug = $this->clean_url_str($title);
			
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');	
			
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Tour Title Required';	
			}else{
				$val = TRUE;
			}
			
			if($val == TRUE){
				
					$updatedata = array(
						  'title'=> $title ,
						  'languages'=> $languages ,
						  'status'=> $status ,
						  'description'=> $body ,
						  'metaD'=> $metaD ,						  
						  'slug'=> $slug
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('tour_id' , $id);
					$this->db->update('i_tours', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_itinerary_tour-'. $title);
					$data['basicmsg'] = 'Tour has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 
	//+++++++++++++++++++++++++++
	//DELETE TOUR DO
	//++++++++++++++++++++++++++
	function delete_tour_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  //unlink pictures	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('type_id', $id);
			  $query = $this->db->where('type', 'tour');
			  $query = $this->db->get('i_images');
				
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					$file =  BASE_URL.'assets/itinerary/images/' . $row->img_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
					
				  }			
			  }
			  
			  //unlink documents	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('tour_id', $id);
			  $query = $this->db->get('i_tour_docs');
				
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					$file =  BASE_URL.'assets/itinerary/documents/' . $row->doc_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
					
				  }			
			  }				  			
				
			  //delete from database
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_tours');
			  
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_itinerary');
			  
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_prices');
			  
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_days');
			  
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_day_accommodations');
			  
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_day_activities');
			  
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_day_destinations');				  		  			  			  			  
			  
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_tour_highlights');			  			  
			  
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('type_id', $id);
			  $this->db->where('type', 'tour');
			  $this->db->delete('i_images');
			  
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_tour_docs');			  			  
			  
			  			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_tour-'.$id);
			  $this->session->set_flashdata('msg','Tour deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	
	
	
	//+++++++++++++++++++++++++++
	//GET TOUR HIGHLIGHTS
	//++++++++++++++++++++++++++
	public function get_tour_highlights($tour_id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  
		  $query = $this->db->where('tour_id', $tour_id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_tour_highlights');
		  
		  if($query->result()){
			echo'<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->th_id.'">
						<td style="width:80%">
						<input type="hidden" value="'.$row->th_id.'" />
						<a style="cursor:pointer" href="'.site_url('/').'itinerary/update_highlight/'.$row->highlight_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_tour_highlight('.$row->th_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var th_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_tour_highlight_sequence/"+th_id+"/'.$tour_id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Tour Highlights added</h3>
					No tour highlights have been added. to add a new highlight please add or search a highlight click on the add highlight button</div>';
		  
		 }
				
		
	}

	//+++++++++++++++++++++++++++
	//ADD TOUR HIGHLIGHT DO
	//++++++++++++++++++++++++++

	public function add_tour_highlight_do()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO TABLE
		$data['title'] = $this->input->post('highlight');
		$data['bus_id'] = $bus_id;
		$data['lat'] = '-22.5632824';
		$data['lng'] = '17.0707275';		
		
		$tour_id = $this->input->post('tour_id');	
		
		//TEST DUPLICATE ENTRIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('i_highlights');
		
		if($result1->num_rows() == 0){			
			$data['slug'] = $this->clean_url_str($data['title']);
			$data['status'] = 'live';
			$this->db->insert('i_highlights', $data);
		}
		
		//GET NEW HIGHLIGHT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('i_highlights');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('tour_id', $tour_id);
		$result = $this->db->get('i_tour_highlights');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['highlight_id'] = $row['highlight_id'];
			$data2['tour_id'] = $tour_id;	
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('i_tour_highlights', $data2);	
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE TOUR HIGHLIGHT DO
	//++++++++++++++++++++++++++
	function delete_tour_highlight_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			
				
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('th_id', $id);
			  $this->db->delete('i_tour_highlights');			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_tour_highlight-'.$id);
			  $this->session->set_flashdata('msg','Tour Highlight deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }		
	


	//+++++++++++++++++++++++++++
	//LOAD HIGHLIGHTS TYPEHEAD
	//++++++++++++++++++++++++++
	function load_highlight_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->where('bus_id', $bus_id);		
		$query = $this->db->get('i_highlights');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){
			
			$id = $row->highlight_id;
			$highlight = addslashes($row->title); 
			
			if($x == ($query->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$highlight."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }





	//+++++++++++++++++++++++++++
	//GET TOUR ACCOMMODATION
	//++++++++++++++++++++++++++
	public function get_tour_accommodations($tour_id)
	{
		$bus_id = $this->session->userdata('bus_id');


		$query = $this->db->where('tour_id', $tour_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('i_tour_accommodations');

		if($query->result()){
			echo'<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->ta_id.'">
						<td style="width:80%">
						<input type="hidden" value="'.$row->ta_id.'" />
						<a style="cursor:pointer" href="'.site_url('/').'itinerary/update_accommodation/'.$row->accommodation_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_tour_accommodation('.$row->ta_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">


					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};

					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {

						},
						stop: function(e, info) {

						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");

							  sibs.each(function(i,item){
									var ta_id = $(this).val(), index = i;

									 $.ajax({
										type: "post",

										url: "'. site_url('/').'itinerary/update_tour_accommodation_sequence/"+ta_id+"/'.$tour_id.'/"+index ,
										success: function (data) {

										}
								});

							  });


						}

					}).disableSelection();
				</script>';

		}else{

			echo '<div class="alert">
			 		<h3>No Tour Accommodations added</h3>
					No tour accommodations have been added. to add a new accommodation please add or search a accommodation click on the add accommodation button</div>';

		}


	}

	//+++++++++++++++++++++++++++
	//ADD TOUR ACCOMMODATION DO
	//++++++++++++++++++++++++++

	public function add_tour_accommodation_do()
	{

		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO TABLE
		$data['title'] = $this->input->post('accommodation');
		$data['bus_id'] = $bus_id;
		$data['lat'] = '-22.5632824';
		$data['lng'] = '17.0707275';

		$tour_id = $this->input->post('tour_id');

		//TEST DUPLICATE ENTRIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('i_accommodations');

		if($result1->num_rows() == 0){
			$data['slug'] = $this->clean_url_str($data['title']);
			$data['status'] = 'live';
			$this->db->insert('i_accommodations', $data);
		}

		//GET NEW ACCOMMODATION ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('i_accommodations');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('tour_id', $tour_id);
		$result = $this->db->get('i_tour_accommodations');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['accommodation_id'] = $row['accommodation_id'];
			$data2['tour_id'] = $tour_id;
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('i_tour_accommodations', $data2);
		}

	}

	//+++++++++++++++++++++++++++
	//DELETE TOUR ACCOMMODATION DO
	//++++++++++++++++++++++++++
	function delete_tour_accommodation_do($id){

		if($this->session->userdata('admin_id')) {

			$bus_id = $this->session->userdata('bus_id');



			$this->db->where('bus_id', $bus_id);
			$this->db->where('ta_id', $id);
			$this->db->delete('i_tour_accommodations');


			//LOG
			$this->admin_model->system_log('delete_tour_accommodation-'.$id);
			$this->session->set_flashdata('msg','Tour Accommodation deleted successfully');

		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}



	//+++++++++++++++++++++++++++
	//GET TOUR DESTINATIONS
	//++++++++++++++++++++++++++
	public function get_tour_destinations($tour_id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  
		  $query = $this->db->where('tour_id', $tour_id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_tour_destinations');
		  
		  if($query->result()){
			echo'<table id="sortable5" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->td_id.'">
						<td style="width:80%">
						<input type="hidden" value="'.$row->td_id.'" />
						<a style="cursor:pointer" href="'.site_url('/').'itinerary/update_destination/'.$row->destination_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_tour_destination('.$row->td_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable5 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable5 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var td_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_tour_destination_sequence/"+td_id+"/'.$tour_id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Tour Destinations added</h3>
					No tour destinations have been added. to add a new destination please add or search a destination click on the add destination button</div>';
		  
		 }
				
		
	}

	//+++++++++++++++++++++++++++
	//ADD TOUR DESTINATION DO
	//++++++++++++++++++++++++++

	public function add_tour_destination_do()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO TABLE
		$data['title'] = $this->input->post('destination');
		$data['bus_id'] = $bus_id;
		$data['lat'] = '-22.5632824';
		$data['lng'] = '17.0707275';		
		
		$tour_id = $this->input->post('tour_id');	
		
		//TEST DUPLICATE ENTRIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('i_destinations');
		
		if($result1->num_rows() == 0){			
			$data['slug'] = $this->clean_url_str($data['title']);
			$data['status'] = 'live';
			$this->db->insert('i_destinations', $data);
		}
		
		//GET NEW HIGHLIGHT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('i_destinations');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('tour_id', $tour_id);
		$result = $this->db->get('i_tour_destinations');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['destination_id'] = $row['destination_id'];
			$data2['tour_id'] = $tour_id;	
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('i_tour_destinations', $data2);	
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE TOUR DESTINATION DO
	//++++++++++++++++++++++++++
	function delete_tour_destination_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			
				
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('td_id', $id);
			  $this->db->delete('i_tour_destinations');			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_tour_destination-'.$id);
			  $this->session->set_flashdata('msg','Tour Destination deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }		
	


	//+++++++++++++++++++++++++++
	//GET TOUR ITINERARIES
	//++++++++++++++++++++++++++
	public function get_itineraries($tour_id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  
		  $query = $this->db->where('tour_id', $tour_id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'DESC');
		  $query = $this->db->get('i_itinerary');
		  
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Days</th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr id="row-'.$row->itinerary_id.'">
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_itinerary/'.$row->itinerary_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$this->get_title('i_tour_types','type_id',$row->type_id).'</div></a></td>
						<td style="width:20%">'.$this->get_day_count($row->itinerary_id).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_itinerary/'.$row->itinerary_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_itinerary('.$row->itinerary_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix"></div>
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Tour Itineraries added</h3>
					No tour itineraries have been added. to add a new itinerary please click on the add new itinerary button</div>';
		  
		 }
				
		
	}
	
	 function get_itinerary($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('itinerary_id', $id);
		  $query = $this->db->get('i_itinerary');
		  
		  return $query->row_array(); 
	
	 }	
	
	//+++++++++++++++++++++++++++
	//ADD ITINERARY DO
	//++++++++++++++++++++++++++	
	function add_itinerary_do()
	{
		if($this->session->userdata('admin_id')){
		
			$tour_id = $this->input->post('tour_id', TRUE);
			$type = $this->input->post('type', TRUE);
			$price_heading = $this->input->post('price_heading', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$valid = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('valid', FALSE)));
			
			$bus_id = $this->session->userdata('bus_id');
			
			//check if itinerary exists
			 $query = $this->db->where('tour_id', $tour_id);
			 $query = $this->db->where('bus_id', $bus_id);
			 $query = $this->db->where('type_id', $type);
			 $query = $this->db->get('i_itinerary');
				
			 if($query->result()){	
			 
			 	$val = FALSE;
				echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>ERROR: Sorry, you already uploaded a itinerary with this style. Please try again</div>
				 
				 ';

			 
			 } else {
				 
				 $val = TRUE;

			 }
			 		
			
			 if($val == TRUE){
				
					$insertdata = array(
					  'tour_id'=> $tour_id,
					  'type_id'=> $type,
					  'description'=> $body,
					  'valid'=> $valid,
					  'price_heading'=> $price_heading,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_itinerary', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_tour_itinerary-'.$id);
					
					//success redirect	
					$this->session->set_flashdata('msg','Itinerary added successfully');
					$data['basicmsg'] = 'Itinerary has been added successfully';
					

					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_itinerary/'.$id.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = 'Attempt failed';
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}		
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	} 
	 

	//+++++++++++++++++++++++++++
	//UPDATE ITINERARY DO
	//++++++++++++++++++++++++++	
	function update_itinerary_do() 
	{
		if($this->session->userdata('admin_id')){
			
			//$type = $this->input->post('type', TRUE);					
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$valid = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('valid', FALSE)));
			$price_heading = $this->input->post('price_heading', TRUE);
			$id = $this->input->post('id', TRUE);		
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');	
			
		  

			$val = TRUE;

			
			if($val == TRUE){
				
					$updatedata = array(
						  //'type_id'=> $type ,
						  'status'=> $status ,
						  'description'=> $body,
						  'price_heading'=> $price_heading,
						  'valid'=> $valid
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('itinerary_id' , $id);
					$this->db->update('i_itinerary', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_itinerary_tour_itinerary-'. $id);
					$data['basicmsg'] = 'Itinerary has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 
	//+++++++++++++++++++++++++++
	//DELETE ITINERARY DO
	//++++++++++++++++++++++++++
	function delete_itinerary_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  //unlink documents	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('itinerary_id', $id);
			  $query = $this->db->get('i_tour_docs');
				
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					$file =  BASE_URL.'assets/itinerary/documents/' . $row->doc_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
					
				  }			
			  }				  			
				
			  //delete from database
			  $this->db->where('itinerary_id', $id);
			  $this->db->delete('i_itinerary');
			  
			  $this->db->where('itinerary_id', $id);
			  $this->db->delete('i_prices');
			  
			  $this->db->where('itinerary_id', $id);
			  $this->db->delete('i_days');
			  
			  $this->db->where('itinerary_id', $id);
			  $this->db->delete('i_day_accommodations');
			  
			  $this->db->where('itinerary_id', $id);
			  $this->db->delete('i_day_activities');
			  
			  $this->db->where('itinerary_id', $id);
			  $this->db->delete('i_day_destinations');				  		  			  			  			  		  			  
			   
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('tour_id', $id);
			  $this->db->delete('i_tour_docs');			  			  
			  
			  			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary-'.$id);
			  $this->session->set_flashdata('msg','Itinerary deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	



	//+++++++++++++++++++++++++++
	//GET DAY COUNT
	//++++++++++++++++++++++++++
	public function get_day_count($id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('itinerary_id', $id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('i_days');
		  
		  return $query->num_rows();
		  		
	}


	//+++++++++++++++++++++++++++
	//GET ITINERARY SELECT
	//++++++++++++++++++++++++++
	public function get_style_select() {

		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('i_tour_types');
			
		  if($query->result()){
			  
			  foreach($query->result() as $row){
				  
				echo '<option value="'.$row->type_id.'">'.$row->title.'</option>';
				
			  }			
		  }			
	}
	

	

	//+++++++++++++++++++++++++++
	//GET ITINERARY PRICES
	//++++++++++++++++++++++++++
	public function get_itinerary_prices($id) {

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->where('itinerary_id', $id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('i_prices');
			
		  if($query->result()){
			echo'<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:25%;font-weight:normal">Hi Price (N$)</th>
						<th style="width:25%;font-weight:normal">Lo Price (N$)</th>
						<th style="width:30%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->price_id.'">
						<td style="width:30%">
						<input type="hidden" value="'.$row->price_id.'" />
						<div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></td>
						<td style="width:25%">'.$row->h_price.'</td>
						<td style="width:25%">'.$row->l_price.'</td>
						<td style="width:30%;text-align:right">
						
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_price/'.$row->price_id.'"><i class="icon-pencil"></i></a>						
						
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_price('.$row->price_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var price_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_price_sequence/"+price_id+"/'.$id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Itinerary Prices added</h3>
					No itinerary prices have been added.</div>';
		  
		 }		
	}
	
	
	 function get_price($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('price_id', $id);
		  $query = $this->db->get('i_prices');
		  
		  return $query->row_array(); 
	
	 }		
	
	
	//+++++++++++++++++++++++++++
	//ADD PRICE DO
	//++++++++++++++++++++++++++	
	function add_price_do()
	{
		if($this->session->userdata('admin_id')){
		
			$itinerary_id = $this->input->post('itinerary_id', TRUE);
			$tour_id = $this->input->post('tour_id', TRUE);
			$title = $this->input->post('title', TRUE);
			$h_price = $this->input->post('h_price', TRUE);
			$l_price = $this->input->post('l_price', TRUE);
			
/*			$high_price = preg_replace( '/[^0-9]/', '', $h_price );
			$low_price = preg_replace( '/[^0-9]/', '', $l_price );
*/
			
			$bus_id = $this->session->userdata('bus_id');
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Price Title Required';	
			}else{
				$val = TRUE;
			}
			 		
			
			 if($val == TRUE){
				
					$insertdata = array(
					  'itinerary_id'=> $itinerary_id ,
					  'tour_id'=> $tour_id ,
					  'title'=> $title ,
					  'h_price'=> $h_price ,
					  'l_price'=> $l_price ,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_prices', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_price-'.$id);
					
					//success redirect	
					$this->session->set_flashdata('msg','Itinerary Price added successfully');
					$data['basicmsg'] = 'Itinerary Price has been added successfully';
					

					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_itinerary/'.$itinerary_id.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = 'Attempt failed';
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}		
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE PRICE DO
	//++++++++++++++++++++++++++	
	function update_price_do()
	{
		if($this->session->userdata('admin_id')){
			
			$id = $this->input->post('id', TRUE);
			$itinerary_id = $this->input->post('itinerary_id', TRUE);
			$tour_id = $this->input->post('tour_id', TRUE);
			$title = $this->input->post('title', TRUE);
			$h_price = $this->input->post('h_price', TRUE);
			$l_price = $this->input->post('l_price', TRUE);

/*			$high_price = preg_replace( '/[^0-9]/', '', $h_price );
			$low_price = preg_replace( '/[^0-9]/', '', $l_price );*/

			
			$bus_id = $this->session->userdata('bus_id');
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Price Title Required';	
			}else{
				$val = TRUE;
			}
			 		
			
			 if($val == TRUE){
				
					$updatedata = array(
					  'title'=> $title ,
					  'h_price'=> $h_price ,
					  'l_price'=> $l_price
					);				
				
				
					$this->db->where('bus_id', $bus_id);
					$this->db->where('price_id', $id);
					$this->db->update('i_prices', $updatedata);

					
					//LOG
					$this->admin_model->system_log('update_itinerary_price-'.$id);
					
					//success redirect	
					$this->session->set_flashdata('msg','Itinerary Price Updated successfully');
					$data['basicmsg'] = 'Itinerary Price has been updated successfully';
					

					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_itinerary/'.$itinerary_id.'/";
					</script>
					';
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = 'Attempt failed';
					echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}		
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	
	
			
	
	//+++++++++++++++++++++++++++
	//DELETE PRICE DO
	//++++++++++++++++++++++++++
	function delete_price_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  $this->db->where('price_id', $id);
			  $this->db->delete('i_prices');
			  			  			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_price-'.$id);
			  $this->session->set_flashdata('msg','Price deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	



	 //+++++++++++++++++++++++++++
	 //GET DAY DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_day($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('day_id', $id);
		  $query = $this->db->get('i_days');
		  
		  return $query->row_array(); 
	
	 }
	 
	//+++++++++++++++++++++++++++
	//GET Days
	//++++++++++++++++++++++++++
	public function get_days($id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  
		  $query = $this->db->where('itinerary_id', $id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_days');
		  
		  if($query->result()){
			echo'<table id="sortable2" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:50%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Date</th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->day_id.'">
						<input type="hidden" value="'.$row->day_id.'" />
						<td style="width:50%"><a style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_day/'.$row->day_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Entry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'itinerary/update_day/'.$row->day_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_day('.$row->day_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable2 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable2 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var day_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_day_sequence/"+day_id+"/'.$id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Itinerary Days added</h3>
					No days have been added. to add a new day please click on the add new day button</div>';
		  
		 }
				
		
	}
	 
	//+++++++++++++++++++++++++++
	//ADD DAY DO
	//++++++++++++++++++++++++++	
	function add_day_do()
	{
		if($this->session->userdata('admin_id')){
		
			$tour_id = $this->input->post('tour_id', TRUE);
			$type_id = $this->input->post('type_id', TRUE);
			$itinerary_id = $this->input->post('itinerary_id', TRUE);
			
			$title = $this->input->post('title', TRUE);
			$days = $this->input->post('days', TRUE);
			$distance = $this->input->post('distance', TRUE);
			$inclusive = $this->input->post('inclusive', TRUE);
			$basis = $this->input->post('basis', TRUE);
			$activity_inc = $this->input->post('activity_inc', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			$bus_id = $this->session->userdata('bus_id');
						
			$slug = $this->clean_url_str($days.$title);


			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Day title Required';
											
			}else{
				$val = TRUE;
			}
	
			if($val == TRUE){
				
					$insertdata = array(
					  'tour_id'=> $tour_id ,
					  'type_id'=> $type_id ,
					  'itinerary_id'=> $itinerary_id ,
					  'title'=> $title ,
					  'days'=> $days ,
					  'distance'=> $distance ,
					  'inclusive'=> $inclusive ,
					  'basis'=> $basis, 
					  'activity'=> $activity_inc, 
					  'description'=> $body ,
					  'slug'=> $slug,
					  'bus_id'=>$bus_id
					);				
				
				
					$this->db->insert('i_days', $insertdata);
					$id = $this->db->insert_id();
					
					//LOG
					$this->admin_model->system_log('add_new_itinerary_day-'.$title);
					
					//success redirect	
					$this->session->set_flashdata('msg','Day added successfully');
					$data['basicmsg'] = 'Day has been added successfully';
					

					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'itinerary/update_day/'.$id.'/";
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
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE DAY DO
	//++++++++++++++++++++++++++	
	function update_day_do() 
	{
		if($this->session->userdata('admin_id')){
			
			$title = $this->input->post('title', TRUE);				
			$days = $this->input->post('days', TRUE);	
			$distance = $this->input->post('distance', TRUE);
			$inclusive = $this->input->post('inclusive', TRUE);	
			$basis = $this->input->post('basis', TRUE);	
			$activity_inc = $this->input->post('activity_inc', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			$id = $this->input->post('id', TRUE);
					
			$slug = $this->clean_url_str($days.$title);
			
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');	
			
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Day Title Required';	
			}else{
				$val = TRUE;
			}
			
			if($val == TRUE){
				
					$updatedata = array(
						  'title'=> $title ,
						  'days'=> $days ,
						  'status'=> $status ,
						  'description'=> $body ,
						  'distance'=> $distance ,
						  'inclusive'=> $inclusive ,
						  'basis'=> $basis ,
						  'activity'=> $activity_inc, 						  
						  'slug'=> $slug
					 );				
				
					$this->db->where('bus_id' , $bus_id);
					$this->db->where('day_id' , $id);
					$this->db->update('i_days', $updatedata);
					
					//LOG
					$this->admin_model->system_log('update_itinerary_day-'. $title);
					$data['basicmsg'] = 'Day has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
	}	 
	 
	//+++++++++++++++++++++++++++
	//DELETE DAY DO
	//++++++++++++++++++++++++++
	function delete_day_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
								  			
			  
			  $this->db->where('day_id', $id);
			  $this->db->delete('i_days');
			  
			  $this->db->where('day_id', $id);
			  $this->db->delete('i_day_accommodations');
			  
			  $this->db->where('day_id', $id);
			  $this->db->delete('i_day_activities');
			  
			  $this->db->where('day_id', $id);
			  $this->db->delete('i_day_destinations'); 
			  			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_day-'.$id);
			  $this->session->set_flashdata('msg','Day deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	


	
	
	//+++++++++++++++++++++++++++
	//GET DAY DESTINAIONS
	//++++++++++++++++++++++++++
	public function get_day_destinations($day_id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  		  
		  $query = $this->db->where('day_id', $day_id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_day_destinations');
		  
		  if($query->result()){
			echo'<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->id.'">
						<td style="width:80%">
						<input type="hidden" value="'.$row->id.'" />
						<a style="cursor:pointer" href="'.site_url('/').'itinerary/update_destination/'.$row->destination_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_day_destination('.$row->id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_day_destination_sequence/"+id+"/'.$day_id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Day Destinations added</h3>
					No day destinations have been added.
				   </div>';
		  
		 }
				
		
	}

	//+++++++++++++++++++++++++++
	//ADD DAY DESTINATION DO
	//++++++++++++++++++++++++++

	public function add_day_destination_do()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO TABLE
		$data['title'] = $this->input->post('destination');
		$data['bus_id'] = $bus_id;
		$data['lat'] = '-22.5632824';
		$data['lng'] = '17.0707275';		
		
		$day_id = $this->input->post('day_id');	
		$tour_id = $this->input->post('tour_id');
		$itinerary_id = $this->input->post('itinerary_id');	
		
		//TEST DUPLICATE ENTRIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('i_destinations');
		
		if($result1->num_rows() == 0){			
			$data['slug'] = $this->clean_url_str($data['title']);
			$data['status'] = 'live';
			$this->db->insert('i_destinations', $data);
		}
		
		//GET NEW HIGHLIGHT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('i_destinations');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('day_id', $day_id);
		$result = $this->db->get('i_day_destinations');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['tour_id'] = $tour_id;
			$data2['itinerary_id'] = $itinerary_id;
			$data2['destination_id'] = $row['destination_id'];
			$data2['day_id'] = $day_id;	
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('i_day_destinations', $data2);	
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE DAY DESTINATION DO
	//++++++++++++++++++++++++++
	function delete_day_destination_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('id', $id);
			  $this->db->delete('i_day_destinations');			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_day_destination-'.$id);
			  $this->session->set_flashdata('msg','Day Destination deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }		
	

	//+++++++++++++++++++++++++++
	//LOAD DESTINATIONS TYPEHEAD
	//++++++++++++++++++++++++++
	function load_destination_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->where('bus_id', $bus_id);		
		$query = $this->db->get('i_destinations');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){
			
			$id = $row->destination_id;
			$destination = addslashes($row->title);
			
			if($x == ($query->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$destination."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }



	//+++++++++++++++++++++++++++
	//GET DAY HIGHLIGHTS
	//++++++++++++++++++++++++++
	public function get_day_highlights($day_id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  		  
		  $query = $this->db->where('day_id', $day_id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_day_highlights');
		  
		  if($query->result()){
			echo'<table id="sortable5" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->id.'">
						<td style="width:80%">
						<input type="hidden" value="'.$row->id.'" />
						<a style="cursor:pointer" href="'.site_url('/').'itinerary/update_highlight/'.$row->highlight_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_day_highlight('.$row->id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable5 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable5 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_day_highlight_sequence/"+id+"/'.$day_id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Day Highlights added</h3>
					No day highlights have been added.
				   </div>';
		  
		 }
				
		
	}


	//+++++++++++++++++++++++++++
	//ADD DAY HIGHLIGHT DO
	//++++++++++++++++++++++++++

	public function add_day_highlight_do()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO TABLE
		$data['title'] = $this->input->post('highlight');
		$data['bus_id'] = $bus_id;
		$data['lat'] = '-22.5632824';
		$data['lng'] = '17.0707275';		
		
		$day_id = $this->input->post('day_id');	
		$tour_id = $this->input->post('tour_id');
		$itinerary_id = $this->input->post('itinerary_id');	
		
		//TEST DUPLICATE ENTRIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('i_highlights');
		
		if($result1->num_rows() == 0){			
			$data['slug'] = $this->clean_url_str($data['title']);
			$data['status'] = 'live';
			$this->db->insert('i_highlights', $data);
		}
		
		//GET NEW HIGHLIGHT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('i_highlights');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('day_id', $day_id);
		$result = $this->db->get('i_day_highlights');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['tour_id'] = $tour_id;
			$data2['itinerary_id'] = $itinerary_id;
			$data2['highlight_id'] = $row['highlight_id'];
			$data2['day_id'] = $day_id;	
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('i_day_highlights', $data2);	
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE DAY HIGHLIGHT DO
	//++++++++++++++++++++++++++
	function delete_day_highlight_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('id', $id);
			  $this->db->delete('i_day_highlights');			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_day_highlight-'.$id);
			  $this->session->set_flashdata('msg','Day Highlight deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }






	//+++++++++++++++++++++++++++
	//GET DAY ACCOMMODATION
	//++++++++++++++++++++++++++
	public function get_day_accommodations($day_id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  		  
		  $query = $this->db->where('day_id', $day_id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_day_accommodations');
		  
		  if($query->result()){
			echo'<table id="sortable2" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->id.'">
						<td style="width:80%">
						<input type="hidden" value="'.$row->id.'" />
						<a style="cursor:pointer" href="'.site_url('/').'itinerary/update_accommodation/'.$row->accommodation_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_day_accommodation('.$row->id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable2 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable2 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_day_accommodation_sequence/"+id+"/'.$day_id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Day Accommodations added</h3>
					No day accommodations have been added.
				   </div>';
		  
		 }
				
		
	}

	//+++++++++++++++++++++++++++
	//ADD DAY ACCOMMODATION DO
	//++++++++++++++++++++++++++

	public function add_day_accommodation_do()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO TABLE
		$data['title'] = $this->input->post('accommodation');
		$data['bus_id'] = $bus_id;
		$data['lat'] = '-22.5632824';
		$data['lng'] = '17.0707275';		
		
		$day_id = $this->input->post('day_id');	
		$tour_id = $this->input->post('tour_id');
		$itinerary_id = $this->input->post('itinerary_id');	
				
		//TEST DUPLICATE ENTRIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('i_accommodations');
		
		if($result1->num_rows() == 0){			
			$data['slug'] = $this->clean_url_str($data['title']);
			$data['status'] = 'live';
			$this->db->insert('i_accommodations', $data);
		}
		
		//GET NEW ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('i_accommodations');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('day_id', $day_id);
		$result = $this->db->get('i_day_accommodations');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['accommodation_id'] = $row['accommodation_id'];
			$data2['day_id'] = $day_id;	
			$data2['tour_id'] = $tour_id;	
			$data2['itinerary_id'] = $itinerary_id;	
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('i_day_accommodations', $data2);	
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE DAY ACCOMMODATION DO
	//+++++++++++++++++++++++++++
	function delete_day_accommodation_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('id', $id);
			  $this->db->delete('i_day_accommodations');			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_day_accommodation-'.$id);
			  $this->session->set_flashdata('msg','Day Accommodation deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }		
	

	//+++++++++++++++++++++++++++
	//LOAD ACCOMMODATION TYPEHEAD
	//+++++++++++++++++++++++++++
	function load_accommodation_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->where('bus_id', $bus_id);		
		$query = $this->db->get('i_accommodations');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){
			
			$id = $row->accommodation_id;
			$accommodation = addslashes($row->title); 
			
			if($x == ($query->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$accommodation."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }








	//+++++++++++++++++++++++++++
	//GET DAY ACTIVITIES
	//++++++++++++++++++++++++++
	public function get_day_activities($day_id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  		  
		  $query = $this->db->where('day_id', $day_id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('i_day_activities');
		  
		  if($query->result()){
			echo'<table id="sortable3" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->id.'">
						<td style="width:80%">
						<input type="hidden" value="'.$row->id.'" />
						<a style="cursor:pointer" href="'.site_url('/').'itinerary/update_activity/'.$row->activity_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_day_activity('.$row->id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable3 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable3 tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_day_accommodation_sequence/"+id+"/'.$day_id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Day Activities added</h3>
					No day activities have been added.
				   </div>';
		  
		 }
				
		
	}

	//+++++++++++++++++++++++++++
	//ADD DAY ACTIVITY DO
	//++++++++++++++++++++++++++

	public function add_day_activity_do()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO TABLE
		$data['title'] = $this->input->post('activity');
		$data['bus_id'] = $bus_id;
		$data['lat'] = '-22.5632824';
		$data['lng'] = '17.0707275';		
		
		$day_id = $this->input->post('day_id');
		$tour_id = $this->input->post('tour_id');
		$itinerary_id = $this->input->post('itinerary_id');
			
		
		//TEST DUPLICATE ENTRIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('i_activities');
		
		if($result1->num_rows() == 0){			
			$data['slug'] = $this->clean_url_str($data['title']);
			$data['status'] = 'live';
			$this->db->insert('i_activities', $data);
		}
		
		//GET NEW ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('i_activities');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('day_id', $day_id);
		$result = $this->db->get('i_day_activities');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['activity_id'] = $row['activity_id'];
			$data2['day_id'] = $day_id;	
			$data2['tour_id'] = $tour_id;	
			$data2['itinerary_id'] = $itinerary_id;	
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('i_day_activities', $data2);	
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE DAY ACTIVITY DO
	//+++++++++++++++++++++++++++
	function delete_day_activity_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('id', $id);
			  $this->db->delete('i_day_activities');			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_day_activity-'.$id);
			  $this->session->set_flashdata('msg','Day Activity deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }		
	

	//+++++++++++++++++++++++++++
	//LOAD ACTIVITY TYPEHEAD
	//+++++++++++++++++++++++++++
	function load_activity_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->where('bus_id', $bus_id);		
		$query = $this->db->get('i_activities');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){
			
			$id = $row->activity_id;
			$activity = addslashes($row->title); 
			
			if($x == ($query->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$activity."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }










	//+++++++++++++++++++++++++++
	//GET TITLE
	//++++++++++++++++++++++++++
	public function get_title($type, $type_id, $id)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->select('title');
		  $query = $this->db->where($type_id, $id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get($type);
		  
		  if($query->result()){
			  
		  	$row = $query->row();
			return $row->title;
		  
		  } else {
			  
			  return '';
			  
		  }
		  		
	}


	//+++++++++++++++++++++++++++
	//UPLOAD IMAGES
	//++++++++++++++++++++++++++
	
	function add_images()
	{
		
		 $this->load->library('upload');  // NOTE: always load the library outside the loop
		 $type_id = $_REQUEST['type_id'];
		 $type = $_REQUEST['type'];
		 
		 $bus_id = $this->session->userdata('bus_id');
	
		 if(isset($_FILES['file']['name'])){
				$this->total_count_of_files = count($_FILES['file']['name']);
				/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */
		 
				 for($i=0; $i<$this->total_count_of_files; $i++)
				 {
				
				   $_FILES['userfile']['name']    = $_FILES['file']['name'];
				   $_FILES['userfile']['type']    = $_FILES['file']['type'];
				   $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
				   $_FILES['userfile']['error']       = $_FILES['file']['error'];
				   $_FILES['userfile']['size']    = $_FILES['file']['size'];
				
				   
				   $config['upload_path'] = BASE_URL.'assets/itinerary/images/';
				   $config['allowed_types'] = 'jpg|jpeg|gif|png|JPEG|JPG|PNG|GIF';
				   $config['overwrite']     = FALSE;
				   $config['max_size']	= '0';
				   $config['max_width']  = '8324';
				   $config['max_height']  = '8550';
				   $config['min_width']  = '200';
				   $config['min_height']  = '200';
				   $config['remove_spaces']  = TRUE;
				   $config['encrypt_name']  = TRUE;
				   
				
				  $this->upload->initialize($config);
				
					  if($this->upload->do_upload())
					  {
						//$file = array('upload_data'
						  $data = array('upload_data' => $this->upload->data());
						  $file =  $this->upload->file_name;
						  $oname =  $this->upload->orig_name;
						  $width = $this->upload->image_width;
						  $height = $this->upload->image_height;
						  	
							if (($width > 1000) || ($height > 1200)){
	 								
									$this->load->model('image_model');
									$this->image_model->downsize_image($file);
											
							}

							  //populate array with values
							  $data = array(
								  'img_file'=> $file,
								  'type' => $type,
								  'type_id' => $type_id,
								  'bus_id' => $bus_id
							  );
							 
							//insert into database
							 $this->db->insert('i_images',$data);
							 
							 //crop 
							  $data['filename'] = $file;
							  //$data['width'] = $this->upload->image_width;
							  //$data['height'] = $this->upload->image_height;
							  $val = TRUE;
							 // $image = base_url('/') . 'assets/business/gallery/'.$file;
							 
							  //$this->output->set_header("HTTP/1.0 200 OK");
						
						
					  }else{
						//ERROR
							$val = FALSE;
							$data['error'] =  $this->upload->display_errors();
					  }
				 }
				 //redirect
				 if($val == TRUE){
					  
				 $data['basicmsg'] = 'Image added successfully!';
				 $msg = "<div class='alert alert-success'>
						 <button type='button' class='close' data-dismiss='alert'>×</button>
						". $data['basicmsg']."
						 </div>";
				 
				 echo '<div class="alert alert-success">
						 <button type="button" class="close" data-dismiss="alert">×</button>
						'. $data['basicmsg'].'
						 </div>
					<script type="text/javascript">
						$("#doc_msg").html('. $msg.');
						//show_docs();
					</script>';
					
				 }else{
					 
					 echo '<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">×</button>'
							 . $data['error'].'
							 </div>
							 <script type="text/javascript">
								console.log("error");
								
							</script>';
				 }
		 }else{
			  echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						 No Files Selected - Please select some files and try again
						 </div><script type="text/javascript">
							console.log("error");
							
						</script>';
			 
		 }
		
	}
	//+++++++++++++++++++++++++++
	//LOAD IMAGES
	//++++++++++++++++++++++++++
	
	function load_images($type, $type_id)
	{
		
		  $bus_id = $this->session->userdata('bus_id');
		  
		  //$query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->where('type', 'gal_img');
		  $query = $this->db->where('type_id', $type_id);
		  $query = $this->db->where('type', $type);
		  $query = $this->db->get('i_images');
		  
		  if($query->result()){
			echo'<ul class="thumbnails">';
			
			foreach($query->result() as $row){
			
				echo '<li  class="img-polaroid">
						<img src="'.S3_URL.'assets/itinerary/images/'.$row->img_file.'" width="100px" style="width:100px;display:inline-block" />
						
					  </li>';
			}
			
			
			echo '
				</ul>';
			
		 }
		
	}
	
	//+++++++++++++++++++++++++++
	//LOAD IMAGES SORTABLE
	//+++++++++++++++++++++++++++		 
	 
	function load_images_update($type, $type_id){
			
		$query = $this->db->where('type_id', $type_id);
		$query = $this->db->where('type', $type);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('i_images');

		if($query->result()){
			
			echo'<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%"> 
				<thead>
					<tr style="font-size:14px">
						<th style="width:20%;font-weight:normal"></th>
           				<th style="width:30%;font-weight:normal"></th>
						<th style="width:30%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				if($row->featured == 'Y') { $featured = '<span class="label label-success">Featured</span>'; } else { $featured = ''; }
				
				echo '<tr class="myDragClass">
				
						<td style="width:20%">
						<input type="hidden" value="'.$row->image_id.'" />
						<img src="'.S3_URL.'assets/itinerary/images/'.$row->img_file.'" width="200px" style="width:100px;display:inline-block" class="img-polaroid"/></td>
						<td style="width:30%"><div style="text-decoration:none;top:0;left:0;right:0;bottom:0;border:none"><strong>'
						.$row->title.'</strong><br>'.$featured.' </div></td>
            			<td style="width:30%"><div style="font-weight:bold;font-size:11px;top:0;left:0;right:0;bottom:0;border:none">'
						.$row->description.'</div></td>
						<td style="width:20%;text-align:right">
						<a title="Edit image" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_image('.$row->image_id.')"><i class="icon-pencil"></i></a>
						<a href="#" onclick="delete_image('.$row->image_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
						</td>
						
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var image_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_img_sequence/"+image_id+"/'.$type.'/'.$type_id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
			
		}else{
			 echo '<div class="alert">
			 		<h3>No Images added</h3>
					No images have been added.</div>';
			
		}

	}
	
	//+++++++++++++++++++++++++++
	//UPDATE IMAGE
	//++++++++++++++++++++++++++

	public function update_image_do()
	{
		    $title = $this->input->post('title', TRUE);
			$body = $this->input->post('content', TRUE);
			$featured = $this->input->post('featured', TRUE);
			$url = $this->input->post('img_url', TRUE);
			$id = $this->input->post('id', TRUE);

			$val = TRUE;


			if($val == TRUE){
		
				$updatedata = array(
					  'title'=> $title ,
					  'featured'=> $featured ,
					  'description'=> $body,
					  'img_url'=> $url		  
				);				
				
				$this->db->where('image_id' , $id);
				$this->db->update('i_images', $updatedata);						

				//LOG
				$this->admin_model->system_log('update_itinerary_image-'. $id);
				$data['basicmsg'] = 'Image has been updated successfully';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
			
	}	

	//+++++++++++++++++++++++++++
	//DELETE IMAGE DO
	//++++++++++++++++++++++++++
	function delete_image_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  //unlink pictures	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('image_id', $id);
			  $query = $this->db->get('i_images');
				
			  if($query->result()){
				  
					$row = $query->row();  
					  
					$file =  BASE_URL.'assets/itinerary/images/' . $row->img_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
			
			  }				
				
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('image_id', $id);
			  $this->db->delete('i_images');			  
			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_image-'.$id);
			  $this->session->set_flashdata('msg','Image deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	
	//+++++++++++++++++++++++++++
	//LOAD DOCUMENTS SORTABLE
	//+++++++++++++++++++++++++++		 
	 
	function load_documents_update($id){
			
		$query = $this->db->where('itinerary_id', $id);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('i_tour_docs');

		if($query->result()){
			
			echo'<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%"> 
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
           				<th style="width:30%;font-weight:normal"></th>
						<th style="width:40%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				$link = S3_URL.'assets/itinerary/documents/'.$row->doc_file;
				
				$ext = substr($row->title, strpos($row->title, '.'), strlen($row->title));
				
				if($ext == '.doc' || $ext == '.docx'){
					
					$icon = '<img src="'.base_url('/').'admin_src/img/doc_icon.png" >';
						
				}elseif($ext == '.pdf'){
					
					$icon = '<img src="'.base_url('/').'admin_src/img/pdf_icon.png" >';
					
				}elseif($ext == '.xls' || $ext == '.xlsx'){
						
					$icon = '<img src="'.base_url('/').'admin_src/img/xls_icon.png" >';

				}elseif(strtolower($ext) == '.jpg' || strtolower($ext) == '.png' ||  strtolower($ext) == '.gif'){
						
					$icon = '<img src="'.base_url('/').'admin_src/img/img_icon.png" class="img-responsive" >';
				}
				
				echo '<tr class="myDragClass">
				
						<td style="width:10%">
						<input type="hidden" value="'.$row->doc_id.'" />
						'.$icon.'
						</td>
						<td style="width:30%"><div style="text-decoration:none;top:0;left:0;right:0;bottom:0;border:none"><strong>'.$row->title.'</strong></div></td>
            			<td style="width:40%">'.$row->doc_file.'</td>
						<td style="width:20%;text-align:right">
						<a title="Edit document" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_doc('.$row->doc_id.')"><i class="icon-pencil"></i></a>
						<a href="#" onclick="delete_doc('.$row->doc_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
						</td>
						
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

					
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var doc_id = $(this).val(), index = i;
									
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'itinerary/update_img_sequence/"+doc_id+"/'.$id.'/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
			
		}else{
			 echo '<div class="alert">
			 		<h3>No Documents added</h3>
					No documents have been added.</div>';
			
		}

	}
	
	//+++++++++++++++++++++++++++
	//UPDATE DOCUMENT
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		    $title = $this->input->post('title', TRUE);
			$body = $this->input->post('content', TRUE);
			$id = $this->input->post('id', TRUE);

			$val = TRUE;


			if($val == TRUE){
		
				$updatedata = array(
					  'title'=> $title ,
					  'description'=> $body	  
				);				
				
				$this->db->where('doc_id' , $id);
				$this->db->update('i_tour_docs', $updatedata);						

				//LOG
				$this->admin_model->system_log('update_itinerary_document-'. $id);
				$data['basicmsg'] = 'Document has been updated successfully';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
			
	}		
	
		
	
	//+++++++++++++++++++++++++++
	//DELETE DOCUMENT DO
	//++++++++++++++++++++++++++
	function delete_document_do($id){
      	
		if($this->session->userdata('admin_id')) {
			
			  $bus_id = $this->session->userdata('bus_id');
				
			  //unlink pictures	
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('doc_id', $id);
			  $query = $this->db->get('i_tour_docs');
				
			  if($query->result()){
				  
					$row = $query->row();  
					  
					$file =  BASE_URL.'assets/itinerary/documents/' . $row->doc_file; # build the full path		
					
					if (file_exists($file)) {
						unlink($file);
					}
			
			  }				
				
			  $this->db->where('bus_id', $bus_id);
			  $this->db->where('doc_id', $id);
			  $this->db->delete('i_tour_docs');			  
			  
			  
			  
			  //LOG
			  $this->admin_model->system_log('delete_itinerary_document-'.$id);
			  $this->session->set_flashdata('msg','Document deleted successfully');
								
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	
	
	
	
	
	//+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS Chunked
	//++++++++++++++++++++++++++
	
	public function plupload_server() 
	{

			  
			$targetDir = BASE_URL.'assets/itinerary/documents/';

 			
            //$cleanupTargetDir = false; // Remove old files
            //$maxFileAge = 60 * 60; // Temp file age in seconds
 
            // 5 minutes execution time
            @set_time_limit(5 * 60);
 
            // Uncomment this one to fake upload time
            // usleep(5000);
 
            // Get parameters
            $chunk = isset($_REQUEST["chunk"]) ? $_REQUEST["chunk"] : 0;
            $chunks = isset($_REQUEST["chunks"]) ? $_REQUEST["chunks"] : 0;
			$fileName = isset($_REQUEST["name"]) ? $_REQUEST["name"] : '';
 			$itinerary_id = $_REQUEST['itinerary_id'];
			$tour_id = $_REQUEST['tour_id'];
			
			$oname = $_FILES['file']['name'];
			
            // Clean the fileName for security reasons
            $fileName = preg_replace('/[^\w\._]+/', '', $fileName);
 
            // Make sure the fileName is unique but only if chunking is disabled
            if ($chunks < 2 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) 
                {
                    $ext = strrpos($fileName, '.');
                    $fileName_a = substr($fileName, 0, $ext);
                    $fileName_b = substr($fileName, $ext);
 
                    $count = 1;
                    while (file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName_a . '_' . $count . $fileName_b))
                            $count++;
 
                    $fileName = $fileName_a . '_' . $count . $fileName_b;

                }
 
            // Create target dir
            if (!file_exists($targetDir)){
                    @mkdir($targetDir);
			}
            if (isset($_SERVER["HTTP_CONTENT_TYPE"])){
                    $contentType = $_SERVER["HTTP_CONTENT_TYPE"];
			}
            if (isset($_SERVER["CONTENT_TYPE"])){
                    $contentType = $_SERVER["CONTENT_TYPE"];
			}
            // Handle non multipart uploads older WebKit versions didn't support multipart in HTML5
            if (strpos($contentType, "multipart") !== false) 
                {
                    if (isset($_FILES['file']['tmp_name']) && is_uploaded_file($_FILES['file']['tmp_name'])) {
							  // Open temp file
							  $out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
							  if ($out)
								{
							   // Read binary input stream and append it to temp file
							   $in = fopen($_FILES['file']['tmp_name'], "rb");
							 
							   if ($in) {
								while ($buff = fread($in, 4096))
								 fwrite($out, $buff);
							   } else
								die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
							   fclose($in);
							   fclose($out);
							   @unlink($_FILES['file']['tmp_name']);
							  	
					 		 } 
                   			 else
							  die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
										} 
									else
									 die('{"jsonrpc" : "2.0", "error" : {"code": 103, "message": "Failed to move uploaded file."}, "id" : "id"}');
								 } 
							 else
								 {
							// Open temp file
							$out = fopen($targetDir . DIRECTORY_SEPARATOR . $fileName, $chunk == 0 ? "wb" : "ab");
							if ($out) 
								{
									// Read binary input stream and append it to temp file
									$in = fopen("php://input", "rb");
			 
									if ($in) {
											while ($buff = fread($in, 4096))
													fwrite($out, $buff);
									} else
											die('{"jsonrpc" : "2.0", "error" : {"code": 101, "message": "Failed to open input stream."}, "id" : "id"}');
			 
							fclose($in);
							fclose($out);
							} 
							else
							 die('{"jsonrpc" : "2.0", "error" : {"code": 102, "message": "Failed to open output stream."}, "id" : "id"}');
						}
							
					 if ($chunk < 1 && file_exists($targetDir . DIRECTORY_SEPARATOR . $fileName)) {		
						 //Insert DB
						$this->insert_tour_docs($itinerary_id, $tour_id, $fileName, $oname);
					 }
					// Return JSON-RPC response
					die('{"jsonrpc" : "2.0", "result" : "'.$fileName.'", "id" : '.$itinerary_id.', "oname" : "'.$oname.'"}');
			 
        }

	//++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS INSERT DB
	//++++++++++++++++++++++++++
	
	function insert_tour_docs($itinerary_id, $tour_id, $file, $oname)
	{
		  $bus_id = $this->session->userdata('bus_id');

		  //populate array with values
		  $data = array(
			  'itinerary_id' => $itinerary_id,  
			  'tour_id' => $tour_id,  
			  'doc_file'=> $file,
			  'title' => $oname,
			  'bus_id' => $bus_id          
		   
		  );						 
		  //insert into database
		   $this->db->insert('i_tour_docs',$data); 
		   //$doc_id = $this->db->insert_id();
	}















	 	 

	 //+++++++++++++++++++++++++++
	 //GET NEXT PRODUCT ID
	 //++++++++++++++++++++++++++   
	   
	 function get_next_product_id($product_id){
	   	

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '".$bus_id."' AND product_id > '".$product_id."' ORDER BY product_id ASC LIMIT 1", FALSE);
		  
		 	
		  
		  if($query->result()){
			 
			  $row = $query->row();
			  
			  return $row->pid;
				 			  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   return $row2->minpid; 			 
			   
		  }
	
	 }
	 



	 
	 //+++++++++++++++++++++++++++
	 //GET PROJECT DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_next_product($product_id){
	   	

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '".$bus_id."' AND product_id > '".$product_id."' ORDER BY product_id ASC LIMIT 1", FALSE);
		  
		 	
		  
		  if($query->result()){
			 
			  $row = $query->row();
			  
		  
			  echo '<a href="'.site_url('/').'product/update_product/'.$row->pid.'" class="btn btn-inverse btn">View Next Product</a>';
				 
				  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   echo '<a href="'.site_url('/').'product/update_product/'.$row2->minpid.'" class="btn btn-inverse btn">View Next Product</a>'; 			 
			 
			  
		  }
	
	 }
	 
	 //+++++++++++++++++++++++++++
	 //GET PROJECT DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_prev_product($product_id){
	   	

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '".$bus_id."' AND product_id < '".$product_id."' ORDER BY product_id DESC LIMIT 1", FALSE);
		  
		 	
		  
		  if($query->result()){
			 
			  $row = $query->row();
			  
		  
			  echo '<a href="'.site_url('/').'product/update_product/'.$row->pid.'" class="btn btn-inverse btn">View Prev Product</a>&nbsp;';
				 
				  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(product_id) AS maxpid, MIN(product_id) AS minpid FROM products WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   echo '<a href="'.site_url('/').'product/update_product/'.$row2->maxpid.'" class="btn btn-inverse btn">View Prev Product</a>&nbsp;'; 			 
			 
			  
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