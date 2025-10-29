<?php
class Converter_model extends CI_Model{
	
 	function converter_model(){
  		//parent::CI_model();
			
 	}

	//+++++++++++++++++++++++++++
	//GET BRANCH SELECT
	//++++++++++++++++++++++++++
	public function get_branch_select($rid=0)
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('ccyb_branches');
		  
		  
		  if($query->result()){
			
			foreach($query->result() as $row){	
			
			
			if($rid == $row->ccyb_id) { $selected = "selected"; }	else { 	$selected = ""; }
						
				echo '<option value="'.$row->ccyb_id.'" '.$selected.'>'.$row->ccyb_branch.'</option>';
			}

		  }
		
	}
	
	
	//+++++++++++++++++++++++++++
	//GET CODE SELECT
	//++++++++++++++++++++++++++
	public function get_code_select($cid=0)
	{
		  
		  $query = $this->db->get('ccyc_codes');
		  		  
		  if($query->result()){
			
			foreach($query->result() as $row){	
			
				if($cid == $row->ccyc_id) { $selected = "selected"; }	else { 	$selected = ""; }
							
					echo '<option value="'.$row->ccyc_id.'" '.$selected.'>'.$row->ccyc_code.'</option>';
					
				}

		  }
		
	}	
	
	//+++++++++++++++++++++++++++
	//GET TYPE SELECT
	//++++++++++++++++++++++++++
	public function get_type_select($tid=0)
	{
		
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('ccyt_types');
		  
		  
		  if($query->result()){
			
			foreach($query->result() as $row){	
			
				if($tid == $row->ccyt_id) { $selected = "selected"; }	else { 	$selected = ""; }
							
					echo '<option value="'.$row->ccyt_id.'" '.$selected.'>'.$row->ccyt_name.'</option>';
				}

		  }
		
	}		
	

	//+++++++++++++++++++++++++++
	//GET ALL RATES
	//++++++++++++++++++++++++++
	public function get_all_rates()
	{
		  
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT * FROM ccyr_rates AS a
		  							 
									 LEFT JOIN ccyb_branches AS b on a.ccyr_branch_id = b.ccyb_id
									 
									 LEFT JOIN ccyc_codes AS c on a.ccyr_cyy_code = c.ccyc_id

									 INNER JOIN ccyt_types AS d on a.ccyr_ccyt_type = d.ccyt_id
									 
									 WHERE a.bus_id = '".$bus_id."'", FALSE); 
		   
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:25%;font-weight:normal">Branch </th>
						<th style="width:10%;font-weight:normal">Code </th>
						<th style="width:10%;font-weight:normal">Type </th>
						<th style="width:10%;font-weight:normal">Cost Rate</th>
						<th style="width:10%;font-weight:normal">Margin Adj</th>
						<th style="width:15%;font-weight:normal">Rate</th>
						<th style="width:10%;font-weight:normal">Cyclic No</th>
						<th style="width:10%;font-weight:normal">State</th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
			
				echo '<tr>
						<td style="width:25%">'.$row->ccyb_branch.'</td>
						<td style="width:10%">'.$row->ccyc_code.'</td>
            			<td style="width:10%">'.$row->ccyt_name.'</td>
						<td style="width:10%">'.$row->ccyr_cost_rate.'</td>
						<td style="width:10%">'.$row->ccyr_margin_adj.'</td>
						<td style="width:15%">'.$row->ccyr_rate.'</td>
						<td style="width:10%">'.$row->ccyr_cyclic_no.'</td>
						<td style="width:10%">'.$row->ccyr_state.'</td>
						<td style="width:15%;text-align:right">
						<a title="Edit Rate" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'converter/update_rate/'.$row->ccyr_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Rate" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_rate('.$row->ccyr_id.')"><i class="icon-trash icon-white"></i></a></td>
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
			 		<h3>No Rates added</h3>
					No rates have been added. to add a new rate please click on the add rate button on the right</div>';
		  
		 }
		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//ADD RATE DO
	//++++++++++++++++++++++++++	
	function add_rate_do()
	{
		
		$branch = $this->input->post('branch', TRUE);
		$code = $this->input->post('code', TRUE);
		$type = $this->input->post('type', TRUE);
		$cost_rate = $this->input->post('cost_rate', TRUE);
		$margin = $this->input->post('margin', TRUE);
		$inverted = $this->input->post('inverted', TRUE);
		
		$bus_id = $this->session->userdata('bus_id');
		

		//GET STATE	
		$query = $this->db->query("SELECT * FROM ccyt_types WHERE bus_id = '".$bus_id."' AND ccyt_id = '".$type."'", FALSE);
		
		if($query->result()){
			
			$row = $query->row(); 
			
			$state = $row->ccyt_state;
			$cyclic = $row->ccyt_cyclic_no;
			$ind = $row->ccyt_margin_ind;

			//GET RATE	
			if($ind == 'S') {

				$rate = $cost_rate + $margin;
			
			}
			
			if($ind == 'B') {
				

				$rate = $cost_rate - $margin;
			
			}
			
			
		}
									
		$insertdata = array(
		  'bus_id' => $bus_id,
		  'ccyr_branch_id' => $branch,
		  'ccyr_cyy_code' => $code,
		  'ccyr_ccyt_type' => $type,
		  'ccyr_cost_rate' => $cost_rate,
		  'ccyr_margin_adj' => $margin,
		  'ccyr_rate' => $rate,
		  'ccyr_cyclic_no' => $cyclic,
		  'ccyr_state' => $state,
		  'inverted' => $inverted

		);
						
					
		$this->db->insert('ccyr_rates', $insertdata);
		$rateid = $this->db->insert_id();
		
		
		//LOG
		$this->admin_model->system_log('add_new_rate-'.$branch);
		//success redirect	
		$this->session->set_flashdata('msg','Rate added successfully');
		$data['basicmsg'] = 'Rate has been added successfully';
		echo '<div class="alert alert-success">
		<button type="button" class="close" data-dismiss="alert">×</button>
		'.$data['basicmsg'].'</div>
		<script type="text/javascript">
		window.location = "'.site_url('/').'converter/rates/";
		</script>
		';


	}
	
	
	//+++++++++++++++++++++++++++
	//UPDATE RATE DO
	//++++++++++++++++++++++++++	
	function update_rate_do()
	{
		
		$rate_id = $this->input->post('rate_id', TRUE);
		$branch = $this->input->post('branch', TRUE);
		$code = $this->input->post('code', TRUE);
		$type = $this->input->post('type', TRUE);
		$cost_rate = $this->input->post('cost_rate', TRUE);
		$margin = $this->input->post('margin', TRUE);
		$inverted = $this->input->post('inverted', TRUE);
		
		$bus_id = $this->session->userdata('bus_id');
		


		//GET STATE	
		$query = $this->db->query("SELECT * FROM ccyt_types WHERE bus_id = '".$bus_id."' AND ccyt_id = '".$type."'", FALSE);
		
		if($query->result()){
			
			$row = $query->row(); 
			
			$state = $row->ccyt_state;
			$cyclic = $row->ccyt_cyclic_no;
			$ind = $row->ccyt_margin_ind;

			//GET RATE	
			if($ind == 'S') {
				
				$rate = ($cost_rate / 100) * $margin;
				$rate = $cost_rate + $rate;
			
			}
			
			if($ind == 'B') {
				
				$rate = ($cost_rate / 100) * $margin;
				$rate = $cost_rate - $rate;	
			
			}
			
			if($ind == 'N') {
				
				$rate = $cost_rate;

			}						
			
			 
		} else {
			
			$state = '';
			$cyclic = '';
			$rate = '';
			
		}
									
		$insertdata = array(
		  'bus_id' => $bus_id,
		  'ccyr_branch_id' => $branch,
		  'ccyr_cyy_code' => $code,
		  'ccyr_ccyt_type' => $type,
		  'ccyr_cost_rate' => $cost_rate,
		  'ccyr_margin_adj' => $margin,
		  'ccyr_rate' => $rate,
		  'ccyr_cyclic_no' => $cyclic,
		  'ccyr_state' => $state,
		  'inverted' => $inverted
		);
						
					
		$this->db->where('ccyr_id', $rate_id);
		$this->db->update('ccyr_rates', $insertdata);
		$rateid = $this->db->insert_id();
		
		
		//LOG
		$this->admin_model->system_log('rate-'. $rate_id);
		$data['basicmsg'] = 'Rate has been updated successfully';
		echo '<script type="text/javascript">
		window.location = "'.site_url('/').'converter/rates/";
		</script>';


	}	


	 //+++++++++++++++++++++++++++
	 //GET RATE
	 //++++++++++++++++++++++++++   
	   
	 function get_rate($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT * FROM ccyr_rates WHERE ccyr_id = '".$id."' AND bus_id = '".$bus_id."'", FALSE);
		  
		  return $query->row_array(); 
	
	 }
	 
	 
	//DELETE RATE
	function delete_rate($id){
      	
		if($this->session->userdata('admin_id')){
				
			  //delete from database
			  $test = $this->db->where('ccyr_id', $id);
			  $this->db->delete('ccyr_rates');
			  
			  //LOG
			  $this->admin_model->system_log('delete_rate-'.$id);
			  $this->session->set_flashdata('msg','Rate deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'converter/rates/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
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