<?php
class Map_model extends CI_Model{
	
 	function map_model(){
  		//parent::CI_model();
			
 	}


	function get_destination_markers($id) {

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->query("SELECT * FROM map_markers WHERE bus_id = '".$bus_id."' AND map_id = '".$id."' AND status = 'live'", FALSE);

		if($query->result()){

			$i=1;
			foreach($query->result() as $row){

				echo "['<h1>".$row->title."</h1>".$row->body."', '".$row->lat."', ".$row->lng.", ".$i."],";

				$i++;
			}

		}

	}


	 //+++++++++++++++++++++++++++
	 //GET MAP DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_map($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('map_id', $id);
		  $query = $this->db->get('maps');
		  
		  return $query->row_array(); 
	
	 }

	//+++++++++++++++++++++++++++
	//GET MAP DETAILS
	//++++++++++++++++++++++++++

	function get_marker($id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('marker_id', $id);
		$query = $this->db->get('map_markers');

		return $query->row_array();

	}
	 
	//DELETE MAP
	function delete_map($id){
      	
		if($this->session->userdata('admin_id')){
							
			  $bus_id = $this->session->userdata('bus_id');
			  
			  //delete from database
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('map_id', $id);
			  $this->db->delete('maps');
			  
			  
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('map_id', $id);
			  $this->db->delete('map_markers');
			  
			  //LOG
			  $this->admin_model->system_log('delete_map-'.$id);
			  $this->session->set_flashdata('msg','Map deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'map/maps/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE MAP
	//++++++++++++++++++++++++++	
	function update_map_do()
	{
			$title = $this->input->post('title', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$status = $this->input->post('status', TRUE);
			$id = $this->input->post('map_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');

			$slug = $this->clean_url_str($title);
	
			$val = TRUE;
			
				$insertdata = array(
					  'title'=> $title ,
					  'body'=> $body ,
					  'slug'=> $slug ,
					  'status'=> $status
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('map_id' , $id);
					$this->db->update('maps', $insertdata);
					
					//LOG
					$this->admin_model->system_log('update-map-'. $id);
					$data['basicmsg'] = 'Map has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}



	//+++++++++++++++++++++++++++
	//ADD MAP DO
	//++++++++++++++++++++++++++	
	function add_map_do()
	{
			$title = $this->input->post('title', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

			$bus_id = $this->session->userdata('bus_id');

			$slug = $this->clean_url_str($title);
			
			$val = TRUE;
			
			$insertdata = array(
				'bus_id'=> $bus_id ,
				'title'=> $title ,
				'body'=> $body ,
				'slug'=> $slug
			);
	
			
			if($val == TRUE){
				
					$this->db->insert('maps', $insertdata);
					$mapid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_map-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Map added successfully');
					$data['basicmsg'] = 'Map has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'map/update_map/'.$mapid.'/";
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
	//GET ALL MAPS
	//++++++++++++++++++++++++++
	public function get_all_maps()
	{
		  $bus_id = $this->session->userdata('bus_id');

		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'ASC');
		  $query = $this->db->get('maps');

		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:60%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr>
						<td style="width:10%">'.$status.'</td>
						<td style="width:60%"><a style="cursor:pointer"
						href="'.site_url('/').'map/update_map/'.$row->map_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Map" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'map/update_map/'.$row->map_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Map" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_map('.$row->map_id.')">
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
			 		<h3>No Maps added</h3>
					No Maps have been added. to add a new entry please click on the add map button on the right</div>';
		  
		 }
				
		
	}


	//+++++++++++++++++++++++++++
	//GET ALL MARKERS
	//++++++++++++++++++++++++++
	public function get_all_markers($id)
	{
		  $bus_id = $this->session->userdata('bus_id');

		  $query = $this->db->where('map_id', $id);
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('map_markers');

		  if($query->result()){

			echo'
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title</th>
           				<th style="width:30%;font-weight:normal">Coordinates</th>
           				<th style="width:20%;font-weight:normal">Date</th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr>
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer"
						href="'.site_url('/').'map/update_marker/'.$row->marker_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:30%">'.$row->lat.', '.$row->lng.'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Marker" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'map/update_marker/'.$row->marker_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Marker" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_marker('.$row->marker_id.','.$row->map_id.')">
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
			 
			echo '<div class="alert"><h3>No Markers added</h3> No markers have been added. Add one by using the tool on the right</div>';
		 }
			
		
	}

	//+++++++++++++++++++++++++++
	//ADD MARKER DO
	//++++++++++++++++++++++++++
	function add_marker_do()
	{
		$title = $this->input->post('title', TRUE);
		$map_id = $this->input->post('map_id', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$lat = $this->input->post('lat', TRUE);
		$lng = $this->input->post('lng', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);

		$val = TRUE;

		$insertdata = array(
			'bus_id'=> $bus_id ,
			'map_id'=> $map_id ,
			'title'=> $title ,
			'lat'=> $lat ,
			'lng'=> $lng ,
			'body'=> $body ,
			'slug'=> $slug ,
			'status'=> 'live'
		);


		if($val == TRUE){

			$this->db->insert('map_markers', $insertdata);
			$markerid = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_map_marker-'.$title);
			//success redirect
			$this->session->set_flashdata('msg','Map Marker added successfully');
			$data['basicmsg'] = 'Map Marker has been added successfully';

			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'map/update_map/'.$map_id.'/";
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
	//UPDATE MARKER DO
	//++++++++++++++++++++++++++
	function update_marker_do()
	{
		$title = $this->input->post('title', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$status = $this->input->post('status', TRUE);
		$map_id = $this->input->post('map_id', TRUE);
		$marker_id = $this->input->post('marker_id', TRUE);
		$lat = $this->input->post('lat', TRUE);
		$lng = $this->input->post('lng', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);

		$val = TRUE;

		$insertdata = array(
			'title'=> $title ,
			'body'=> $body ,
			'lat'=> $lat ,
			'lng'=> $lng ,
			'slug'=> $slug ,
			'status'=> $status
		);



		if($val == TRUE){

			$this->db->where('marker_id' , $marker_id);
			$this->db->update('map_markers', $insertdata);

			//LOG
			$this->admin_model->system_log('update-marker-'. $title);
			$data['basicmsg'] = 'Marker has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}

	//DELETE MARKER
	function delete_marker($id, $mid){

		if($this->session->userdata('admin_id')){

			$bus_id = $this->session->userdata('bus_id');



			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('marker_id', $id);
			$this->db->delete('map_markers');

			//LOG
			$this->admin_model->system_log('delete_marker-'.$id);
			$this->session->set_flashdata('msg','Marker deleted successfully');
			echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'map/update_map/'.$mid.'";
				  </script>';


		}else{

			redirect(site_url('/').'admin/logout/','refresh');

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