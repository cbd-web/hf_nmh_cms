<?php
class People_model extends CI_Model{
	
 	function people_model(){
  		//parent::CI_model();
			
 	}

	 //+++++++++++++++++++++++++++
	 //GET MEMBER DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_member($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
			
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('people_id', $id);
		  $query = $this->db->get('people');
		  
		  return $query->row_array(); 
	
	 }
	 
	//DELETE MEMBER
	function delete_member($id){
      	
		if($this->session->userdata('admin_id')){
							
			  $bus_id = $this->session->userdata('bus_id');
			  
			  //delete from database
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('people_id', $id);
			  $this->db->delete('people');
			  
			  
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('people_id', $id);
			  $this->db->delete('page_people_int');
			  
			  //LOG
			  $this->admin_model->system_log('delete_company_member-'.$id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'people/members/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	 
	 

	//+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++	
	function update_member_do()
	{
			$title = $this->input->post('title', TRUE);
			$name = $this->input->post('name', TRUE);
			$lname = $this->input->post('lname', TRUE);
			$position = $this->input->post('position', TRUE);
			$profession = $this->input->post('profession', TRUE);
			$education = $this->input->post('education', TRUE);
			$nationality = $this->input->post('nationality', TRUE);
			$experience = $this->input->post('experience', TRUE);
			$specialization = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$email = $this->input->post('email', TRUE);
			$tel = $this->input->post('tel', TRUE);
		    $fax = $this->input->post('fax', TRUE);
			$cell = $this->input->post('cell', TRUE);
		    $location = $this->input->post('location', TRUE);
			$status = $this->input->post('status', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$sequence = $this->input->post('sequence', TRUE);
			
			$id = $this->input->post('member_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');
	
			$val = TRUE;
			
				$insertdata = array(
					  'title'=> $title ,
					  'name'=> $name ,
					  'lname'=> $lname ,
					  'position'=> $position ,
					  'profession'=> $profession ,
					  'education'=> $education ,
					  'nationality'=> $nationality ,
					  'specialization'=> $specialization ,
					  'experience'=> $experience ,
					  'email'=> $email ,
					  'tel'=> $tel ,
					  'fax'=> $fax ,
					  'cell'=> $cell ,
					  'location'=> $location ,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'status'=> $status,
					  'sequence'=> $sequence
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('people_id' , $id);
					$this->db->update('people', $insertdata);
					//success redirect	
					$data['people_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update-comapny-member-'. $id);
					$data['basicmsg'] = 'Member has been updated successfully'.strtolower($status);
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
			$title = $this->input->post('title', TRUE);
			$name = $this->input->post('name', TRUE);
			$lname = $this->input->post('lname', TRUE);
			$position = $this->input->post('position', TRUE);
			$profession = $this->input->post('profession', TRUE);
			$education = $this->input->post('education', TRUE);
			$nationality = $this->input->post('nationality', TRUE);
			$experience = $this->input->post('experience', TRUE);
			$specialization = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$email = $this->input->post('email', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$cell = $this->input->post('cell', TRUE);
		    $location = $this->input->post('location', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);

			$bus_id = $this->session->userdata('bus_id');
			
			$val = TRUE;
			
			$insertdata = array(
					  'name'=> $name ,
					  'title'=> $title ,
					  'lname'=> $lname ,
					  'position'=> $position ,
					  'profession'=> $profession ,
					  'education'=> $education ,
					  'nationality'=> $nationality ,
					  'specialization'=> $specialization ,
					  'experience'=> $experience ,
					  'email'=> $email ,
					  'tel'=> $tel ,
					  'fax'=> $fax ,
					  'cell'=> $cell ,
					  'location'=> $location ,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'bus_id'=>$bus_id
					);
	
			
			if($val == TRUE){
				
					$this->db->insert('people', $insertdata);
					$peopleid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_company_member-'.$name.' '.$lname);
					//success redirect	
					$this->session->set_flashdata('msg','Member added successfully');
					$data['basicmsg'] = 'Member has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'people/update_member/'.$peopleid.'/";
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
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_all_members()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'ASC');
		  $query = $this->db->get('people');
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Name </th>
						<th style="width:20%;font-weight:normal">Position </th>
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
				echo '<tr>
						<td style="width:6%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" 
						href="'.site_url('/').'people/update_member/'.$row->people_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->name.' '.$row->lname.'</div></a></td>
						<td style="width:20%">'.$row->position.'</td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit member" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'people/update_member/'.$row->people_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Member" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_member('.$row->people_id.')">
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
					No Entries have been added. to add a new entry please click on the add member button on the right</div>';
		  
		 }
				
		
	}



	//+++++++++++++++++++++++++++
	//GET CATEGORY LIST
	//++++++++++++++++++++++++++
	public function get_category_list()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_cats');
		  
		  echo '
		  <select class="span10" name="parent">
		  <option value="0">Choose Category Parent</option>
		  <option value="0">None</option>';		  
		  
		  if($query->result()){
			
			foreach($query->result() as $row){				
				echo '<option value="'.$row->cat_id.'">'.$row->cat_name.'</option>';
			}

		  }
		 
		  echo '</select>';
		
	}
	
	//+++++++++++++++++++++++++++
	//GET PRODUCTS CATEGORY LIST
	//++++++++++++++++++++++++++
	public function get_product_category_list($cat_id=0)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('product_cats');
		  
		  
		  if($query->result()){
			
			foreach($query->result() as $row){	
			
			
			if($cat_id == $row->cat_id) { $selected = "selected"; }	else { 	$selected = ""; }
						
				echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$row->cat_name.'</option>';
			}

		  }
		
	}	


	//+++++++++++++++
	//DELETE CATEGORY
	//+++++++++++++++

	public function delete_category($id)
	{
		
	    $bus_id = $this->session->userdata('bus_id');
						
		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_id', $id);
		$this->db->delete('people_categories');			

	}


	//+++++++++++++++
	//ADD CATEGORY
	//+++++++++++++++	
	public function add_category()
	{
		$bus_id = $this->session->userdata('bus_id');
		
			
		//INSERT INTO CATEGORIES
		$cat_name = $this->input->post('category_name');

		$slug = $this->clean_url_str($cat_name);


		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $cat_name);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('people_categories');
		
		if($result1->num_rows() == 0){

			$insertdata = array(
			  'cat_name'=> $cat_name ,
			  'slug'=> $slug ,
			  'bus_id'=> $bus_id,
			);			
			
			$this->db->insert('people_categories', $insertdata);	
		}
		
		//GET NEW CAT ID
/*		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result = $this->db->get('categories');
		$row = $result->row_array();*/

		
	}	

	//Get Main Categories Typehead
	function load_category_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);		
		$test = $this->db->get('people_categories');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){
			
			$id = $row->cat_id;
			$cat = $row->cat_name;
			
			if($x == ($test->num_rows()-1)){
				
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
	
	 //Get categories for sidebar
	function get_categories_current($people_id){
      	
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->where('bus_id', $bus_id);		
		$query = $this->db->where('people_id', $people_id);
		$query = $this->db->get('people_cat_int');
		if($query->result()){
			
			foreach($query->result() as $row){
				
				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category('.$row->id.')"><i class="icon-remove icon-white"></i> '.$row->cat_name.'</span>';
				
			}
				
			
		}else{
			
			echo '<div class="alert"> No Categories added</div>';
			
		}
		
			  
    }
	
	//+++++++++++++++++++++++++++
	//ADD CATEGORY AND INTERSECTION FOR MEMBER
	//++++++++++++++++++++++++++

	public function add_category_member()
	{
		 $bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$people_id = $this->input->post('people_id_cat');	
		
		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('people_categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('people_categories', $data);	
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_name', $data['cat_name']);
		$result = $this->db->get('people_categories');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('people_id', $people_id);
		$result = $this->db->get('people_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['cat_id'] = $row['cat_id'];
			$data2['people_id'] = $people_id;	
			$data2['cat_name'] = $data['cat_name'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('people_cat_int', $data2);	
		}
		
	}
	
	
	//DELETE CATEGIRY MEMBER
	public function delete_category_member($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('people_cat_int');
		
	}				
	
	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('people_categories');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr>
						<td style="width:6%">'.$row->cat_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->cat_name.'</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_category('.$row->cat_id.')">
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
			 
			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';  
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