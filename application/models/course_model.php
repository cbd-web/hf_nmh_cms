<?php
class Course_model extends CI_Model
{

	function course_model()
	{
		//parent::CI_model();

	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //courses
	 * //END
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */


	//DELETE CATEGIRY MEMBER
	public function delete_category_course($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('course_cat_int');

	}

	//Get categories for sidebar
	function get_categories_current($course_id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('course_id', $course_id);
		$query = $this->db->get('course_cat_int');
		if($query->result()){

			foreach($query->result() as $row){

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category('.$row->id.')"><i class="icon-remove icon-white"></i> '.$row->cat_name.'</span>';

			}


		}else{

			echo '<div class="alert"> No Categories added</div>';

		}


	}
	function get_schools_for_course($school){

		$bus_id = $this->session->userdata('bus_id');

		$this->db->select('title');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('faculties');

		
		if($query->result()){
			foreach($query->result() as $row){
				echo '<option value="'.$row->title.'" '. (($row->title == $school) ? 'selected' : '' ).'>'.$row->title.'</option>';
			}
		}else{

			echo '<div class="alert"> No Faculties added</div>';

		}


	}
	//+++++++++++++++++++++++++++
	//GET course DETAILS
	//+++++++++++++++++++++++++++
	function get_course($course_id){

		$query = $this->db->where('course_id', $course_id);
		$query = $this->db->get('courses');
		return $query->row_array();	

	}
	public function add_category_course()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$pub_id = $this->input->post('course_id_cat');

		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('course_categories');

		if($result1->num_rows() == 0){
			$this->db->insert('course_categories', $data);
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_name', $data['cat_name']);
		$result = $this->db->get('course_categories');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('course_id', $course_id);
		$result = $this->db->get('course_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['cat_id'] = $row['cat_id'];
			$data2['course_id'] = $course_id;
			$data2['cat_name'] = $data['cat_name'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('course_cat_int', $data2);
		}

	}

	//+++++++++++++++++++++++++++
	//GET ALL courses
	//++++++++++++++++++++++++++
	public function get_all_courses()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->order_by('sequence','ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('courses');

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
					<input type="hidden" value="'.$row->course_id.'" />
					<td style="width:6%">'.$status.'</td>
					<td style="width:20%"><a style="cursor:pointer" 
					href="'.site_url('/').'course/update_course/'.$row->course_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					.$row->title.'</div></a></td>
					<td style="width:34%">'.substr(strip_tags($row->body),0,80).'</td>
					<td style="width:15%">'.date('M d Y',strtotime($row->listing_date)).'</td>
					<td style="width:15%;text-align:right">
					<a title="Edit course" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
					href="'.site_url('/').'course/update_course/'.$row->course_id.'"><i class="icon-pencil"></i></a>
					<a title="Delete course" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_course('.$row->course_id.')">
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
								console.log(course_id+" "+index);
								$.ajax({
									type: "post",

									url: "'. site_url('/').'course/update_course_sequence/"+course_id+"/"+index ,
									success: function (data) {

									}

							});

						});

					}

				}).disableSelection();
			</script>';

		}else{
		 
		 echo '<div class="alert">
		 		<h3>No courses added</h3>
				No courses have been added. to add a new course please click on the add course button on the right</div>';

		}
		
	}


	//+++++++++++++++++++++++++++
	//ADD course DO
	//++++++++++++++++++++++++++	
	function add_course_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$bus_id = $this->session->userdata('bus_id');
	  
		if($slug == ''){
			
			$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'courses');
				
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

				$this->db->insert('courses', $insertdata);
				$courseid = $this->db->insert_id();
				//LOG
				$this->admin_model->system_log('add_new_course-'.$title);
				//success redirect	
				$this->session->set_flashdata('msg','course added successfully');
				$data['basicmsg'] = 'course has been added successfully';
				echo "
				<script type='text/javascript'>
				var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
			            noty(options);
				window.location = '".site_url('/')."course/update_course/".$courseid."/';
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


	 //+++++++++++++++++++++++++++
	//UPDATE course DO
	//++++++++++++++++++++++++++++	
	function update_course_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);		
			$status = $this->input->post('status', TRUE);
			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

			$faculty = $this->input->post('school', TRUE);
			$level = $this->input->post('level', TRUE);
			$type = $this->input->post('type', TRUE);
			$duration = $this->input->post('duration', TRUE);
			$requirements = $this->input->post('requirements', TRUE);
			$campuses = $this->input->post('campuses', TRUE);
			$mode = $this->input->post('mode', TRUE);
			$quote = $this->input->post('quote', TRUE);
			$quote_author = $this->input->post('quote_author', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('course_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
			$sequence = ($this->input->post('sequence', TRUE) != '') ? $this->input->post('sequence', TRUE) : 0;
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'course Title Required';
			
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
				  'faculty'=> $faculty,
				  'level'=> $level,
				  'type'=> $type,
				  'duration'=> $duration,
				  'requirements'=> $requirements,
				  'campuses'=> $campuses,
				  'mode'=> $mode,
				  'quote'=> $quote,
				  'quote_author'=> $quote_author,
				  'slug'=> $slug ,								  
				  'bus_id'=>$bus_id,
				  'sequence'=> $sequence
				);

			if($val == TRUE){
				
					$this->db->where('course_id' , $id);
					$this->db->update('courses', $insertdata);
					//success redirect	
					$data['course_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_course-'. $id);

					$data['basicmsg'] = 'course has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}


	
	//+++++++++++++++++++++++++++
	//DELETE course
	//++++++++++++++++++++++++++++	
	function delete_course($course_id){
      	
		if($this->session->userdata('admin_id')){

			$bus_id = $this->session->userdata('bus_id');

			//delete from database
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('course_id', $course_id);
			$query =  $this->db->delete('courses');


			//LOG
			$this->admin_model->system_log('delete_course-'.$course_id);
			$this->session->set_flashdata('msg','course deleted successfully');
			echo '<script type="text/javascript">
			   window.location = "'.site_url('/').'course/courses/";
			  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }


	//Get Main course Typehead
	function load_course_typehead(){

		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('courses');

		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){

			$id = $row->course_id;
			$course = $row->title;

			if($x == ($test->num_rows()-1)){

				$str = '';

			}else{

				$str = ' , ';

			}

			$result .= "'".$course."' ". $str;
			$x ++;

		}

		$result .= '];';
		return $result;

	}

	//Get categories for sidebar
	function get_courses_current($type_id, $type){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('type', $type);
		$query = $this->db->where('type_id', $type_id);
		$query = $this->db->get('course_content_int');

		if($query->result()){

			foreach($query->result() as $row){

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_course('.$row->bc_id.')"><i class="icon-remove icon-white"></i> '.$row->course.'</span>';

			}

		}else{

			echo '<div class="alert"> No courses added</div>';

		}

	}

	//++++++++++++++++++++++++++++++++++++++++
	//ADD course AND INTERSECTION FOR PRODUCT
	//++++++++++++++++++++++++++++++++++++++++

	public function add_course_item()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO courses
		$data['title'] = $this->input->post('course_name');
		$data['bus_id'] = $bus_id;
		$type_id = $this->input->post('type_id');
		$type = $this->input->post('type');

		//TEST DUPLICATE courses
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('courses');

		if($result1->num_rows() == 0){
			$this->db->insert('courses', $data);
		}

		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('courses');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('course', $data['cat_name']);
		$this->db->where('type', $type);
		$this->db->where('type_id', $type_id);
		$result = $this->db->get('course_content_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['course_id'] = $row['course_id'];
			$data2['type_id'] = $type_id;
			$data2['type'] = $type;
			$data2['course'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('course_content_int', $data2);
		}

	}


	//DELETE course PRODUCT
	public function delete_course_item($id)
	{
		$this->db->where('bc_id', $id);
		$this->db->delete('course_content_int');

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