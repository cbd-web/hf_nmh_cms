<?php
class Calculator_model extends CI_Model{
	
 	function calculator_model(){
  		//parent::CI_model();
			
 	}

	//+++++++++++++++++++++++++++
	//GET ALL FEES
	//++++++++++++++++++++++++++
	public function get_all_fees($id, $type)
	{
		  
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT fees FROM ".$type." WHERE bus_id = '".$bus_id."' AND id = '".$id."'", FALSE);
		   
		  if($query->result()){
			  
				$row = $query->row(); 
				
				if($row->fees != "") {
					
				echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
					<thead>
						<tr style="font-size:14px">
							<th style="width:45%;font-weight:normal">Range </th>
							<th style="width:45%;font-weight:normal">Value </th>
							<th style="width:10%;font-weight:normal"></th>
						</tr>
					</thead>
					<tbody>';					
					
					$items = json_decode($row->fees);
					
					foreach($items as $key) {
							
					echo '<tr>
							<td style="width:45%">'.$key[0].'</td>
							<td style="width:45%">'.$key[1].'</td>
							<td style="width:10%;text-align:right"></td>
						  </tr>';
					}
					
				echo '</tbody>
					</table>';				
						
				} else {
					
				 echo '<div class="alert"><h3>No Fees added</h3></div>';				
					
				}
			  
		  }
		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//ADD FEE
	//++++++++++++++++++++++++++	
	function add_fee()
	{
		$type = $this->input->post('type', TRUE);
		$id = $this->input->post('id', TRUE);
		$range = $this->input->post('range', TRUE);
		$amount = $this->input->post('amount', TRUE);
		$bus_id = $this->session->userdata('bus_id');
		
		$val = true;
		
		if($range == '') { $val = false; }
		if($amount == '') { $val = false; }
		
		if($val == true) {
			
			$query = $this->db->query("SELECT fees FROM ".$type." WHERE id = '".$id."' AND bus_id = '".$bus_id."'", FALSE);
			
			if($query->result()){
				
				$row = $query->row(); 
				
				if($row->fees != "") {
				
					$items = json_decode($row->fees);
					
					array_push($items, array($range,$amount));
					
					$new_items = json_encode($items);
					
					$insertdata1 = array(
					  'fees'=> $new_items ,
					);
					
					$this->db->where('id', $id);	
					$this->db->where('bus_id', $bus_id);					
					$this->db->update($type,$insertdata1);						
					
				} else {
					
					$items = array(array($range,$amount));
					
					//$items = array($item);
					
					$new_items = json_encode($items);
									
					$insertdata1 = array(
					  'fees'=> $new_items ,
					);
					
					$this->db->where('id', $id);	
					$this->db->where('bus_id', $bus_id);					
					$this->db->update($type,$insertdata1);						
					
				}
			}
		}
	}


	 //+++++++++++++++++++++++++++
	 //GET CALCULATORS
	 //++++++++++++++++++++++++++   
	   
	 function get_calculators(){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
		  
		  $tbl = '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
				</thead>
				<tbody>';
		  
		  //Bond Cost Calculator
		  $query = $this->db->query("SELECT id, type FROM calc_bond_costs WHERE bus_id = '".$bus_id."'", FALSE);
		  
		  if($query->result()){
			 $row = $query->row();  
			 $tbl.= '
			 <tr>
			 <td style="width:90%">Bond Cost Calculator</td>
			 <td style="width:10%; text-align:right">
				<a title="Edit Calculator" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'calculator/update_calc_bond_costs/'.$row->id.'/'.$row->type.'"><i class="icon-pencil"></i></a>
				<a title="Delete Calculator" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_calculator('.$row->id.')"><i class="icon-trash icon-white"></i></a>			 
			 </td>
			 </tr>'; 
			  
		  }

		  //Transfer Cost Calculator
		  $query2 = $this->db->query("SELECT id, type FROM calc_transfer_costs WHERE bus_id = '".$bus_id."'", FALSE);
		  
		  if($query2->result()){
			 $row2 = $query2->row();  
			 $tbl.= '
			 <tr>
			 <td style="width:90%">Transfer Cost Calculator</td>
			 <td style="width:10%; text-align:right">
				<a title="Edit Calculator" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'calculator/update_calc_transfer_costs/'.$row2->id.'/'.$row2->type.'"><i class="icon-pencil"></i></a>
				<a title="Delete Calculator" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_calculator('.$row2->id.')"><i class="icon-trash icon-white"></i></a>			 
			 </td>
			 </tr>'; 
			  
		  }

		  //Transfer Cost Calculator
		  $query3 = $this->db->query("SELECT id, type FROM calc_member_interest WHERE bus_id = '".$bus_id."'", FALSE);
		  
		  if($query3->result()){
			 $row3 = $query3->row();  
			 $tbl.= '
			 <tr>
			 <td style="width:90%">Members Interest Calculator</td>
			 <td style="width:10%; text-align:right">
				<a title="Edit Calculator" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'calculator/update_calc_member_interest/'.$row3->id.'/'.$row3->type.'"><i class="icon-pencil"></i></a>
				<a title="Delete Calculator" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_calculator('.$row3->id.')"><i class="icon-trash icon-white"></i></a>			 
			 </td>
			 </tr>'; 
			  
		  }		  
		  
		  $tbl.= '</tbody></table>';

		  echo $tbl; 
	
	 }

	 //+++++++++++++++++++++++++++
	 //GET CALCULATOR
	 //++++++++++++++++++++++++++   
	   
	 function get_calculator($id, $type){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->query("SELECT * FROM ".$type." WHERE id = '".$id."' AND bus_id = '".$bus_id."'", FALSE);
		  
		  return $query->row_array(); 
	
	 }
	 
	 
	//DELETE CALCULATOR
	function delete_calculator($id, $type){
      	
		if($this->session->userdata('admin_id')){
				
			  //delete from database
			  $test = $this->db->where('id', $id);
			  $this->db->delete($type);
			  
			  //LOG
			  $this->admin_model->system_log('delete_calculator-'.$id);
			  $this->session->set_flashdata('msg','Calculator deleted successfully');
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
	function update_calculator_do()
	{
		
			$type = $this->input->post('type', TRUE);
			$id = $this->input->post('id', TRUE);
			$status = $this->input->post('status', TRUE);
			$bus_id = $this->session->userdata('bus_id');
			
			if($type == 'calc_bond_costs') {
				
				$vat = $this->input->post('vat', TRUE);	
				$stamp_duty = $this->input->post('stamp_duty', TRUE);
				$office_fee = $this->input->post('office_fee', TRUE);
				$sundries = $this->input->post('sundries', TRUE);
				
				$insertdata = array(
					  'vat'=> $vat,
					  'stamp_duty'=> $stamp_duty,
					  'office_fee'=> $office_fee,
					  'sundries'=> $sundries,
					  'status'=> $status
					);						
				
			}
			
			if($type == 'calc_transfer_costs') {
				
				$vat = $this->input->post('vat', TRUE);	
				$office_fee = $this->input->post('office_fee', TRUE);
				$sundries = $this->input->post('sundries', TRUE);	
				
				$insertdata = array(
					  'vat'=> $vat,
					  'office_fee'=> $office_fee,
					  'sundries'=> $sundries,
					  'status'=> $status
					);					
				
			}
			
			if($type == 'calc_member_interest') {
				
				$vat = $this->input->post('vat', TRUE);	
				$office_fee = $this->input->post('office_fee', TRUE);
				$sundries = $this->input->post('sundries', TRUE);	
				
				$insertdata = array(
					  'vat'=> $vat,
					  'office_fee'=> $office_fee,
					  'sundries'=> $sundries,
					  'status'=> $status
					);					
				
			}						
			
			
	
			$val = TRUE;
			

			
	
			
			if($val == TRUE){
				
					$this->db->where('id' , $id);
					$this->db->update($type, $insertdata);
					//success redirect	
					$data['people_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update-calculator-'. $type);
					$data['basicmsg'] = 'Calculator has been updated successfully'.strtolower($status);
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
	function add_calculator_do()
	{
			$type = $this->input->post('calculator', TRUE);

			$bus_id = $this->session->userdata('bus_id');
			
			$val = TRUE;
			
			//CHECK IF BUSINESS ALREADY HAS CALCULATOR
			
			$insertdata = array(
				'bus_id'=>$bus_id,
				'type'=>$type
			);
	
			
			if($val == TRUE){
				
					$this->db->insert($type, $insertdata);
					$id = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_calculator-'.$type);
					//success redirect	
					$this->session->set_flashdata('msg','Calculator added successfully');
					$data['basicmsg'] = 'Calculator has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'calculator/update_'.$type.'/'.$id.'/'.$type.'"
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