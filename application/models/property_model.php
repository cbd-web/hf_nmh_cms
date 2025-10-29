<?php
class Property_model extends CI_Model{
	
 	function property_model(){
  		//parent::CI_model();
			
 	}


	function get_category_select($main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0, $sci = 0) {

		$data = json_decode($this->property_model->get_myna_categories($main_cat_id, $sub_cat_id, $sub_sub_cat_id, $sub_sub_sub_cat_id));

		//var_dump($data);

		$select='';

		if(isset($data->categories)) {
			foreach ($data->categories as $sel) {

				if($sel->cat_id == $sci) { $selected = 'selected';} else {$selected = '';}

				$select .= '<option value="' . $sel->cat_id . '" '.$selected.'>' . $sel->category_name . '</option>';

			}
		}

		return $select;

	}


	public function get_myna_categories($main_cat_id = 0, $sub_cat_id = 0, $sub_sub_cat_id = 0, $sub_sub_sub_cat_id = 0)
	{
		$qstr = '';
		//MAIN CAT
		if($main_cat_id != 0)
		{
			$qstr .= '?main_cat_id='.$main_cat_id;
		}
		//SUB CAT
		if($sub_cat_id != 0)
		{
			$qstr .= '&sub_cat_id='.$sub_cat_id;
		}
		//MAIN CAT
		if($sub_sub_cat_id != 0 )
		{
			$qstr .= '&sub_sub_cat_id='.$sub_sub_cat_id;
		}
		//MAIN CAT
		if($sub_sub_sub_cat_id != 0)
		{
			$qstr .= '&sub_sub_sub_cat_id='.$sub_sub_sub_cat_id;
		}

		$this->load->driver('cache', array('adapter' => 'file', 'backup' => 'apc'));

		if ( ! $o = $this->cache->get('product_cats_'.$main_cat_id.'_'.$sub_cat_id.'_'.$sub_sub_cat_id.'_'.$sub_sub_sub_cat_id))
		{
			$o = file_get_contents(NA_SITE_URL . 'products_api/categories/' . $qstr);
			$this->cache->save('product_cats_'.$main_cat_id.'_'.$sub_cat_id.'_'.$sub_sub_cat_id.'_'.$sub_sub_sub_cat_id, $o, 8000000);
		}

		return $o;

	}

	//+++++++++++++++++++++++++++
	//GET LOCATION LIST
	//++++++++++++++++++++++++++
	public function get_location_list($loc="")
	{

		$query = $this->db->order_by('location', 'ASC');
		$query = $this->db->get('locations');


		if($query->result()){

			foreach($query->result() as $row){

				if($loc == $row->location) {

					$selected = 'selected';

				} else {

					$selected = '';



				}

				echo '<option value="'.$row->location.'" '.$selected.'>'.$row->location.'</option>';

			}

		}

	}

	//+++++++++++++++++++++++++++
	//GET SUBURB LIST
	//++++++++++++++++++++++++++
	public function get_suburb_list($loc="", $sub="")
	{

		$query = $this->db->query("SELECT * FROM suburbs AS A

								   LEFT JOIN locations AS B ON A.location_id = B.location_id

								   WHERE B.location = '".$loc."' ORDER BY A.suburb ASC", FALSE);


		if($query->result()){

			foreach($query->result() as $row){

				if($sub == $row->suburb) { $selected = 'selected'; } else { $selected = ''; }

				echo '<option value="'.$row->suburb.'" '.$selected.'>'.$row->suburb.'</option>';

			}

		} else {

			echo '<option value=""></option>';

		}

	}



	 //+++++++++++++++++++++++++++
	 //GET PROPERTY DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_property($id){

	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $this->db->where('bus_id', $bus_id);
		  $this->db->where('property_id', $id);
		  $query = $this->db->get('properties');

		  return $query->row_array();
	
	 }
	 
	 
	//DELETE PROPERTY
	function delete_property($id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('property_id', $id);
			  $this->db->delete('properties');
			  //LOG
			  $this->admin_model->system_log('delete_property-'.$id);
			  $this->session->set_flashdata('msg','Property deleted successfully');
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	 

	 //+++++++++++++++++++++++++++
	 //GET NEXT PROPERTY ID
	 //++++++++++++++++++++++++++   
	   
	 function get_next_product_id($property_id){

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT property_id AS pid FROM properties WHERE bus_id = '".$bus_id."' AND property_id > '".$property_id."' ORDER BY property_id ASC LIMIT 1", FALSE);

		  if($query->result()){
			 
			  $row = $query->row();
			  
			  return $row->pid;
				 			  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(property_id) AS maxpid, MIN(property_id) AS minpid FROM properties WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   return $row2->minpid; 			 
			   
		  }
	
	 }
	 



	 
	 //+++++++++++++++++++++++++++
	 //GET PROPERTY DETAILS NEXT
	 //++++++++++++++++++++++++++   
	   
	 function get_next_product($property_id){
	   	

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT property_id AS pid FROM properties WHERE bus_id = '".$bus_id."' AND property_id > '".$property_id."' ORDER BY property_id ASC LIMIT 1", FALSE);
		  
		 	
		  
		  if($query->result()){
			 
			  $row = $query->row();
			  
		  
			  echo '<a href="'.site_url('/').'property/update_property/'.$row->pid.'" class="btn btn-inverse btn">View Next Property</a>';
				 
				  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(property_id) AS maxpid, MIN(property_id) AS minpid FROM properties WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   echo '<a href="'.site_url('/').'property/update_property/'.$row2->minpid.'" class="btn btn-inverse btn">View Next Property</a>';
			 
			  
		  }
	
	 }
	 
	 //+++++++++++++++++++++++++++
	 //GET PROPERTY DETAILS PREV
	 //++++++++++++++++++++++++++   
	   
	 function get_prev_product($property_id){
	   	

		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT property_id AS pid FROM properties WHERE bus_id = '".$bus_id."' AND property_id < '".$property_id."' ORDER BY property_id DESC LIMIT 1", FALSE);
		  
		 	
		  
		  if($query->result()){
			 
			  $row = $query->row();
			  
		  
			  echo '<a href="'.site_url('/').'property/update_property/'.$row->pid.'" class="btn btn-inverse btn">View Prev Property</a>&nbsp;';
				 
				  

		  } else {
			  
			   $query2 = $this->db->query("SELECT MAX(property_id) AS maxpid, MIN(property_id) AS minpid FROM properties WHERE bus_id = '".$bus_id."'", FALSE);
			   
			   $row2 = $query2->row();
			   
			   echo '<a href="'.site_url('/').'property/update_property/'.$row2->maxpid.'" class="btn btn-inverse btn">View Prev Property</a>&nbsp;';
			 
			  
		  }
	
	 }		 




	 //+++++++++++++++++++++++++++
	//UPDATE PROPERTY
	//++++++++++++++++++++++++++	
	function update_property_do()
	{

			$title = $this->input->post('title', TRUE);

			$heading = $this->input->post('heading', TRUE);

			$property_date = $this->input->post('property_date', TRUE);

			$ref_no = $this->input->post('ref_no', TRUE);

			$sub_type = $this->input->post('sub_type', TRUE);
			$sub_sub_type = $this->input->post('sub_sub_type', TRUE);
			$sub_sub_sub_type = $this->input->post('sub_sub_sub_type', TRUE);

			$prop_status = $this->input->post('prop_status', TRUE);

			$status_type = $this->input->post('status_type', TRUE);
			$status_type = strtolower(preg_replace('![^a-z0-9]+!i','-',$status_type));

			$property_type = $this->input->post('property_type', TRUE);
			$property_type = strtolower(preg_replace('![^a-z0-9]+!i','-',$property_type));

			$building_type = $this->input->post('building_type', TRUE);
			$building_type = strtolower(preg_replace('![^a-z0-9]+!i','-',$building_type));

			$price = $this->input->post('price', TRUE);

			$location = $this->input->post('location', TRUE);

			$suburb = $this->input->post('suburb', TRUE);

			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$status = $this->input->post('status', TRUE);
			$featured = $this->input->post('featured', TRUE);
			$sold = $this->input->post('sold', TRUE);
			$show_map = $this->input->post('show_map', TRUE);
			$both_types = $this->input->post('both_types', TRUE);

			$slug = $this->input->post('slug', TRUE);


			$id = $this->input->post('property_id', TRUE);

			$bus_id = $this->session->userdata('bus_id');

		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Property title Required';
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					'title'=> $title ,
					'heading'=> $heading ,
					'property_date'=> $property_date ,
					'body'=> $body ,
					'prop_status' => $prop_status ,
					'ref_no'=> $ref_no ,
					'type'=> $status_type ,
					'sub_type'=> $property_type ,
					'sub_sub_type'=> $building_type ,
					'sub_cat_id'=> $sub_type ,
					'sub_sub_cat_id'=> $sub_sub_type ,
					'sub_sub_sub_cat_id'=> $sub_sub_sub_type ,
					'price'=> $price ,
					'location'=> $location ,
					'suburb'=> $suburb ,
					'metaD'=> $metaD,
					'metaT'=> $metaT,
					'slug'=> $slug,
					'featured'=> $featured,
					'sold'=> $sold,
					'show_map'=> $show_map,
					'both_types'=> $both_types,
					'status'=> strtolower($status)
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('property_id' , $id);
					$this->db->update('properties', $insertdata);
					//success redirect	
					$data['property_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_property-'. $id);
					$data['basicmsg'] = 'Property has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}



	//+++++++++++++++++++++++++++
	//ADD MAP LOCATION
	//++++++++++++++++++++++++++
	function add_location_do()
	{
		$lat = $this->input->post('lat', TRUE);
		$lng = $this->input->post('lng', TRUE);

		$id = $this->input->post('property_id', TRUE);

		$insertdata = array(
			'lat'=> $lat ,
			'lng'=> $lng
		);



			$this->db->where('property_id' , $id);
			$this->db->update('properties', $insertdata);
			//success redirect
			$data['property_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_property_map-'. $id);
			$data['basicmsg'] = 'Property Map has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
			noty(options);</script>";


	}



	//+++++++++++++++++++++++++++
	//ADD PROPERTY DO
	//++++++++++++++++++++++++++	
	function add_property_do()
	{
			$title = $this->input->post('title', TRUE);

			$heading = $this->input->post('heading', TRUE);

			$property_date = $this->input->post('property_date', TRUE);

			$ref_no = $this->input->post('ref_no', TRUE);

			$sub_type = $this->input->post('sub_type', TRUE);
			$sub_sub_type = $this->input->post('sub_sub_type', TRUE);
			$sub_sub_sub_type = $this->input->post('sub_sub_sub_type', TRUE);

			$status_type = $this->input->post('status_type', TRUE);
			$status_type = strtolower(preg_replace('![^a-z0-9]+!i','-',$status_type));

			$property_type = $this->input->post('property_type', TRUE);
			$property_type = strtolower(preg_replace('![^a-z0-9]+!i','-',$property_type));

			$building_type = $this->input->post('building_type', TRUE);
			$building_type = strtolower(preg_replace('![^a-z0-9]+!i','-',$building_type));

			$price = $this->input->post('price', TRUE);

			$location = $this->input->post('location', TRUE);
			//$location = strtolower(preg_replace('![^a-z0-9]+!i','-',$location));

			$prop_status = $this->input->post('prop_status', TRUE);

			$suburb = $this->input->post('suburb', TRUE);
			//$suburb = strtolower(preg_replace('![^a-z0-9]+!i','-',$suburb));

			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);

			$bus_id = $this->session->userdata('bus_id');

		    $slug = $this->clean_url_str($title);
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Property title Required';
					
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
				  'title'=> $title ,
				  'heading'=> $heading ,
				  'property_date'=> $property_date ,
				  'body'=> $body ,
				  'prop_status' => $prop_status ,
				  'ref_no'=> $ref_no ,
				  'type'=> $status_type ,
				  'sub_type'=> $property_type ,
				  'sub_sub_type'=> $building_type ,
				  'sub_cat_id'=> $sub_type ,
				  'sub_sub_cat_id'=> $sub_sub_type ,
				  'sub_sub_sub_cat_id'=> $sub_sub_sub_type ,
				  'price'=> $price ,
				  'location'=> $location ,
				  'suburb'=> $suburb ,
				  'metaD'=> $metaD,
				  'metaT'=> $metaT,
				  'slug'=> $slug,
				  'bus_id'=>$bus_id
			);
	
			
			if($val == TRUE){
				
					$this->db->insert('properties', $insertdata);
					$propid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_property-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Property added successfully');
					$data['basicmsg'] = 'Property has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'property/update_property/'.$propid.'/";
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
	//GET ALL PROPERTIES
	//++++++++++++++++++++++++++
	public function get_all_properties()
	{
		  $bus_id = $this->session->userdata('bus_id');

		  
		  $query = $this->db->query("SELECT * FROM properties WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC
									");
		  
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:15%;font-weight:normal">Type </th>
						<th style="width:15%;font-weight:normal">Property Type </th>
						<th style="width:15%;font-weight:normal">Building Type </th>
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
				echo '<tr id="row-'.$row->property_id.'">
						<td style="width:6%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" 
						href="'.site_url('/').'property/update_property/'.$row->property_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:15%">'.$row->type.'</td>
						<td style="width:15%">'.$row->sub_type.'</td>
						<td style="width:15%">'.$row->sub_sub_type.'</td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Property" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'property/update_property/'.$row->property_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Property" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_property('.$row->property_id.')">
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
			 		<h3>No Properties added</h3>
					No properties have been added. To add a new property please click on the add property button on the right</div>';
		  
		 }
				
		
	}



	//+++++++++++++++++++++++++++
	//GET PROPERTY FEATURES LIST
	//++++++++++++++++++++++++++
	public function get_feature_list()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('property_features');
		if($query->result()){

			foreach($query->result() as $row){

				echo '<option value="'.$row->feature.'">'.$row->feature.'</option>';

			}
		}
	}



	//+++++++++++++++++++++++++++
	//GET ALL PROPERTY FEATURES
	//++++++++++++++++++++++++++
	public function get_property_features($id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('property_id', $id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('property_feature_int');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:40%;font-weight:normal">Feature </th>
						<th style="width:40%;font-weight:normal">Info </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->feature.'</div></td>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->body.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Delete Feature" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_feature('.$row->id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>';
		}else{

			echo '<div class="alert"><h3>No Features added</h3> No features have been added. Add one by using the tool on the right</div>';
		}


	}


	//+++++++++++++++++++++++++++
	//GET ALL FEATURES
	//++++++++++++++++++++++++++
	public function get_all_features()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('property_features');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:65%;font-weight:normal">Feature </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->feature.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Delete Feature" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_feature('.$row->feature_id.')">
						<i class="icon-trash icon-white"></i></a></td>

					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>';

		}else{

			echo '<div class="alert"><h3>No Features added</h3> No features have been added. Add one by using the tool on the right</div>';
		}


	}


	//+++++++++++++++
	//ADD FEATURE
	//+++++++++++++++
	public function add_feature()
	{
		$bus_id = $this->session->userdata('bus_id');


		//INSERT INTO FEATURES
		$feature = $this->input->post('feature');

		$slug = $this->clean_url_str($feature);


		//TEST DUPLICATE
		$this->db->where('feature', $feature);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('property_features');

		if($result1->num_rows() == 0){

			$insertdata = array(
				'feature'=> $feature ,
				'slug'=> $slug ,
				'bus_id'=> $bus_id,
			);

			$this->db->insert('property_features', $insertdata);
		}

	}


	//+++++++++++++++
	//ADD FEATURE
	//+++++++++++++++
	public function add_property_feature()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO FEATURES
		$feature = $this->input->post('feature');
		$body = $this->input->post('body');
		$property_id = $this->input->post('property_id');

		if($feature != 'none'){

			$insertdata = array(
				'bus_id'=> $bus_id ,
				'property_id'=> $property_id ,
				'feature'=> $feature ,
				'body'=> $body ,
			);

			$this->db->insert('property_feature_int', $insertdata);
		}

	}



	//+++++++++++++++++++
	//DELETE FEATURE
	//+++++++++++++++++++

	public function delete_feature($id)
	{

		$bus_id = $this->session->userdata('bus_id');


		$this->db->where('bus_id', $bus_id);
		$this->db->where('feature_id', $id);
		$this->db->delete('property_features');

	}

	//+++++++++++++++++++
	//DELETE PROPERTY FEATURE
	//+++++++++++++++++++

	public function delete_property_feature($id)
	{

		$bus_id = $this->session->userdata('bus_id');


		$this->db->where('bus_id', $bus_id);
		$this->db->where('id', $id);
		$this->db->delete('property_feature_int');

	}



	//Get Main FEATURE Typehead
	function load_feature_typehead(){

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$query = $this->db->get('property_features');

		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){

			$id = $row->feature_id;
			$cat = $row->feature;

			if($x == ($query->num_rows()-1)){

				$str = '';

			}else{

				$str = ' , ';

			}

			$result .= "'".$cat."' ". $str;
			$x ++;

		}

		$result .= '];';
		return $result;

	}


	//+++++++++++++++++++++++++++
	//GET ALL PROPERTY AGENTS
	//++++++++++++++++++++++++++
	public function get_property_agents($id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('property_id', $id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('property_agent_int');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Agent </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->agent_name.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Delete Agent" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_agent('.$row->pa_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>';
		}else{

			echo '<div class="alert"><h3>No Agents added</h3> No agents have been added. Add one by using the tool on the top</div>';
		}


	}


	//+++++++++++++++++++++++++++
	//GET PROPERTY AGENT LIST
	//++++++++++++++++++++++++++
	public function get_agent_list()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('people');
		if($query->result()){

			foreach($query->result() as $row){

				echo '<option value="'.$row->people_id.'">'.$row->name.' '.$row->lname.'</option>';

			}
		}
	}

	//+++++++++++++++
	//ADD AGENT
	//+++++++++++++++
	public function add_property_agent()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO FEATURES
		$agent = $this->input->post('agent');
		$agent_name = $this->input->post('agent_name');
		$property_id = $this->input->post('property_id');

		if($agent != 'none'){

			$insertdata = array(
				'bus_id'=> $bus_id ,
				'property_id'=> $property_id ,
				'people_id'=> $agent,
				'agent_name'=> $agent_name
			);

			$this->db->insert('property_agent_int', $insertdata);
		}

	}

	//+++++++++++++++++++
	//DELETE PROPERTY AGENT
	//+++++++++++++++++++

	public function delete_property_agent($id)
	{

		$bus_id = $this->session->userdata('bus_id');


		$this->db->where('bus_id', $bus_id);
		$this->db->where('pa_id', $id);
		$this->db->delete('property_agent_int');

	}

	function load_agent_typehead(){

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$query = $this->db->get('people');

		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){

			$id = $row->people_id;
			$cat = $row->name.' '.$row->lname;

			if($x == ($query->num_rows()-1)){

				$str = '';

			}else{

				$str = ' , ';

			}

			$result .= "'".$cat."' ". $str;
			$x ++;

		}

		$result .= '];';
		return $result;

	}


	//+++++++++++++++++++++++++++
	//GET ALL DOCUMENTS
	//++++++++++++++++++++++++++
	public function get_all_documents($pid)
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('property_id', $pid);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('property_documents');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">

				<tbody>';

			foreach($query->result() as $row){

				$link = base_url('/').'assets/documents/'.$row->doc_file;

				$ext = substr($row->title, strpos($row->title, '.'), strlen($row->title));

				if($ext == '.doc' || $ext == '.docx'){

					$icon = '<img src="'.base_url('/').'admin_src/img/doc_icon.png" >';

				}elseif($ext == '.pdf'){

					$icon = '<img src="'.base_url('/').'admin_src/img/pdf_icon.png" >';

				}elseif($ext == '.xls' || $ext == '.xlsx'){

					$icon = '<img src="'.base_url('/').'admin_src/img/xls_icon.png" >';

				}elseif(strtolower($ext) == '.jpg' || strtolower($ext) == '.png' ||  strtolower($ext) == '.gif'){

					$icon = '<img src="'.base_url('/').'admin_src/img/img_icon.png" >';
				}

				echo '<tr>
						<td style="width:5%"><input name="doc_files[]" type="checkbox" value="'.$row->doc_id.'" id="ts"></td>
						<td style="width:5%">'.$icon.'</td>
						<td style="width:30%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></td>

            			<td style="width:15%;text-align:right">
						<a title="Edit document" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						onclick="update_document('.$row->doc_id.')"><i class="icon-pencil"></i></a>
						<a title="Delete Document" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_document('.$row->doc_id.')">
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

			echo '<div class="alert"><h3>No Documents added</h3> No documents have been added. Add one by using the tool on the right</div>';
		}


	}


	//+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS Chunked
	//++++++++++++++++++++++++++

	public function plupload_server($document)
	{

		if($document == 'sliders'){

			$targetDir = BASE_URL.'assets/images/';

		}elseif($document == 'documents'){

			$targetDir = BASE_URL.'assets/documents/';

		}elseif($document == 'project_docs'){

			$targetDir = BASE_URL.'assets/documents/';

		}else{
			$targetDir = BASE_URL.'assets/documents/';
		}



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
		$property_id = $_REQUEST['property_id'];
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
			$this->insert_property_docs($property_id, $fileName, $oname , $document);
		}
		// Return JSON-RPC response
		die('{"jsonrpc" : "2.0", "result" : "'.$fileName.'", "id" : '.$property_id.', "oname" : "'.$oname.'"}');

	}

	//+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS INSERT DB
	//++++++++++++++++++++++++++

	function insert_property_docs($property_id, $file,  $oname, $document)
	{
		$bus_id = $this->session->userdata('bus_id');

			//GET DOcumnet sequence
			$this->db->where('property_id' ,$property_id);
			$query = $this->db->get('property_documents');
			if($query->result()){

				$seq = 'Appendix '. $query->num_rows();

			}else{

				$seq = 'Appendix 1';

			}
			//populate array with values
			$data = array(
				'property_id' => $property_id,
				'doc_file'=> $file,
				'title' => $oname,
				'bus_id' => $bus_id,
				'sequence' => $seq

			);
			//insert into database
			$this->db->insert('property_documents',$data);



	}


	//+++++++++++++++++++++++++++
	//UPDATE DOCUMENT
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		$title = $this->input->post('doc_title', TRUE);
		$name = $this->input->post('doc_name', TRUE);
		$doc_type = $this->input->post('doc_type', TRUE);
		$id = $this->input->post('update_doc_id', TRUE);

		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Document title Required';

		}elseif($name == ''){
			$val = FALSE;
			$error = 'Documant Name Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'doc_type'=> $doc_type ,
			'description'=> $name

		);



		if($val == TRUE){

			$this->db->where('doc_id' , $id);
			$this->db->update('property_documents', $insertdata);


			//LOG
			$this->admin_model->system_log('update_property_document-'. $id);
			$data['basicmsg'] = 'Document has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}

	}


	function get_settings(){

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$query = $this->db->get('settings');
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