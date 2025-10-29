<?php
class Faculty_model extends CI_Model
{

	function faculty_model()
	{
		//parent::CI_model();

	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //faculties
	 * //END
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */


	//+++++++++++++++++++++++++++
	//GET faculty DETAILS
	//+++++++++++++++++++++++++++
	function get_faculty($faculty_id){

		$query = $this->db->where('faculty_id', $faculty_id);
		$query = $this->db->get('faculties');
		return $query->row_array();	

	}


	//+++++++++++++++++++++++++++
	//GET ALL faculties
	//++++++++++++++++++++++++++
	public function get_all_faculties()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->order_by('sequence','ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('faculties');

		if($query->result()){
			echo'
			<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
							<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:34%;font-weight:normal">Body </th>
						<th style="width:15%;font-weight:normal">Listing date</th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

		foreach($query->result() as $row){

			$status = '<span class="label label-success">Live</span>';

			if($row->status == 'draft'){
				$status = '<span class="label label-warning">Draft</span>';
			}

			echo '<tr class="myDragClass"> 
					<input type="hidden" value="'.$row->faculty_id.'" />
					<td style="width:6%">'.$status.'</td>
					<td style="width:20%"><a style="cursor:pointer" 
					href="'.site_url('/').'faculty/update_faculty/'.$row->faculty_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					.$row->title.'</div></a></td>
					<td style="width:34%">'.substr(strip_tags($row->body),0,80).'</td>
					<td style="width:15%">'.date('M d Y',strtotime($row->listing_date)).'</td>
					<td style="width:15%;text-align:right">
					<a title="Edit faculty" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
					href="'.site_url('/').'faculty/update_faculty/'.$row->faculty_id.'"><i class="icon-pencil"></i></a>
					<a title="Delete faculty" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_faculty('.$row->faculty_id.')">
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
								var advert_id = $(this).val(), index = i;
								console.log(faculty_id+" "+index);
								$.ajax({
									type: "post",

									url: "'. site_url('/').'faculty/update_faculty_sequence/"+faculty_id+"/"+index ,
									success: function (data) {

									}

							});

						});

					}

				}).disableSelection();
			</script>';

		}else{
		 
		 echo '<div class="alert">
		 		<h3>No faculties added</h3>
				No faculties have been added. to add a new faculty please click on the add faculty button on the right</div>';

		}
		
	}


	//+++++++++++++++++++++++++++
	//ADD faculty DO
	//++++++++++++++++++++++++++	
	function add_faculty_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$bus_id = $this->session->userdata('bus_id');
	  
		if($slug == ''){
			
			$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'faculties');
				
		}else{
			
			$slug = $this->clean_url_str($slug);
			
		}
		
		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Faculty Title Required';
		}elseif(!$this->session->userdata('admin_id')){
			
			$val = FALSE;
			$error = 'You are logged out. Please sign in again.';
		//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
				
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Page Content Required';	
						
		}else{
			$val = TRUE;
		}
		
			$insertdata = array(
			  'title'=> $title,
			  'body'=> $body,
			  'metaD'=> $metaD,
			  'metaT'=> $metaT,
			  'slug'=> $slug,
			  'bus_id'=>$bus_id
			);

		if($val == TRUE){

				$this->db->insert('faculties', $insertdata);
				$facultyid = $this->db->insert_id();
				//LOG
				$this->admin_model->system_log('add_new_faculty-'.$title);
				//success redirect	
				$this->session->set_flashdata('msg','faculty added successfully');
				$data['basicmsg'] = 'faculty has been added successfully';
				echo "
				<script type='text/javascript'>
				var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
			            noty(options);
				window.location = '".site_url('/')."faculty/update_faculty/".$facultyid."/';
				</script>
				";

		}else{
				$data['id'] = $this->session->userdata('id');
				$data['error'] = $error;
				echo "
				<script type='text/javascript'>
				var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
			            noty(options);
				
				</script>
				";
				$this->output->set_header("HTTP/1.0 200 OK");
		}
	}

	function get_hod($hod){

		$bus_id = $this->session->userdata('bus_id');
		$this->db->order_by('name','ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('people');

		
		if($query->result()){
			foreach($query->result() as $row){
				echo '<option value="'.$row->people_id.'" '. (($row->people_id == $hod) ? 'selected' : '' ).'>'.$row->name.' ' . $row->lname .'</option>';
			}
		}else{

			echo '<div class="alert"> No People Added</div>';

		}


	}
	 //+++++++++++++++++++++++++++
	//UPDATE faculty DO
	//++++++++++++++++++++++++++++	
	function update_faculty_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);		
			$status = $this->input->post('status', TRUE);
			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

			$vision = $this->input->post('vision', TRUE);
			$website = $this->input->post('website', TRUE);
			$mission = $this->input->post('mission', TRUE);
			$objectives = $this->input->post('objectives', TRUE);
			$our_values = $this->input->post('our_values', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$head = $this->input->post('head', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('faculty_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
			$sequence = $this->input->post('sequence', TRUE) != '' ? $this->input->post('sequence', TRUE) : 0;
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'faculty Title Required';
			
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			/*}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Page Content Required';*/	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
				  'title'=> $title ,
				  'status'=> strtolower($status),
				  'body'=> $body,
				  'metaD'=> $metaD,
				  'metaT'=> $metaT,
				  'head'=> $head,
				  'vision'=> $vision,
				  'website'=> $website,
				  'mission'=> $mission,
				  'objectives'=> $objectives,
				  'our_values'=> $our_values,
				  'slug'=> $slug ,								  
				  'bus_id'=>$bus_id,
				  'sequence'=> $sequence
				);

			if($val == TRUE){
				
					$this->db->where('faculty_id' , $id);
					$this->db->update('faculties', $insertdata);
					//success redirect	
					$data['faculty_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_faculty-'. $id);

					$data['basicmsg'] = 'faculty has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}


	
	//+++++++++++++++++++++++++++
	//DELETE faculty
	//++++++++++++++++++++++++++++	
	function delete_faculty($faculty_id){
      	
		if($this->session->userdata('admin_id')){

			$bus_id = $this->session->userdata('bus_id');

			//delete from database
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('faculty_id', $faculty_id);
			$query =  $this->db->delete('faculties');


			//LOG
			$this->admin_model->system_log('delete_faculty-'.$faculty_id);
			$this->session->set_flashdata('msg','faculty deleted successfully');
			echo '<script type="text/javascript">
			   window.location = "'.site_url('/').'faculty/faculties/";
			  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }


	//Get Main faculty Typehead
	function load_faculty_typehead(){

		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('faculties');

		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){

			$id = $row->faculty_id;
			$faculty = $row->title;

			if($x == ($test->num_rows()-1)){

				$str = '';

			}else{

				$str = ' , ';

			}

			$result .= "'".$faculty."' ". $str;
			$x ++;

		}

		$result .= '];';
		return $result;

	}

	//Get categories for sidebar
	function get_faculties_current($type_id, $type){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('type', $type);
		$query = $this->db->where('type_id', $type_id);
		$query = $this->db->get('faculty_content_int');

		if($query->result()){

			foreach($query->result() as $row){

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_faculty('.$row->bc_id.')"><i class="icon-remove icon-white"></i> '.$row->faculty.'</span>';

			}

		}else{

			echo '<div class="alert"> No faculties added</div>';

		}

	}

	//++++++++++++++++++++++++++++++++++++++++
	//ADD faculty AND INTERSECTION FOR PRODUCT
	//++++++++++++++++++++++++++++++++++++++++

	public function add_faculty_item()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO faculties
		$data['title'] = $this->input->post('faculty_name');
		$data['bus_id'] = $bus_id;
		$type_id = $this->input->post('type_id');
		$type = $this->input->post('type');

		//TEST DUPLICATE faculties
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('faculties');

		if($result1->num_rows() == 0){
			$this->db->insert('faculties', $data);
		}

		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('faculties');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('faculty', $data['cat_name']);
		$this->db->where('type', $type);
		$this->db->where('type_id', $type_id);
		$result = $this->db->get('faculty_content_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['faculty_id'] = $row['faculty_id'];
			$data2['type_id'] = $type_id;
			$data2['type'] = $type;
			$data2['faculty'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('faculty_content_int', $data2);
		}

	}


	//DELETE faculty PRODUCT
	public function delete_faculty_item($id)
	{
		$this->db->where('bc_id', $id);
		$this->db->delete('faculty_content_int');

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


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_slug_str($str, $replace=array(), $delimiter='-' , $type) {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		
		//test Databse
		//$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$this->db->where('slug', $clean);
		$res = $this->db->get($type);
		
		if($res->result()){
			
			$clean = $clean .'-'.rand(0,99);
			return $clean;
			
		}else{
			
			return $clean;
		}

	}

}
?>