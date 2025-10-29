<?php
class Publication_extended_model extends CI_Model{
	
 	function publication_extended_model(){
  		//parent::CI_model();
			
 	}


	//+++++++++++++++++++++++++++
	//GET CATEGORY DETAILS
	//++++++++++++++++++++++++++

	function get_category($category_id){
		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('cat_id', $category_id);
		$test = $this->db->get('pub_categories');
		return $test->row_array();

	}


	//+++++++++++++++++++++++++++
	//UPDATE CATEGORY
	//++++++++++++++++++++++++++
	function update_category_do()
	{
		$cat_name = $this->input->post('cat_name', TRUE);
		$cat_icon = $this->input->post('cat_icon', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$id = $this->input->post('cat_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');


		//VALIDATE INPUT
		if($cat_name == ''){
			$val = FALSE;
			$error = 'Category title Required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'cat_name'=> $cat_name ,
			'cat_icon'=> $cat_icon ,
			'cat_desc'=> $body ,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$this->db->where('cat_id' , $id);
			$this->db->update('pub_categories', $insertdata);
			//success redirect

			//LOG
			$this->admin_model->system_log('update_publication_category-'. $id);
			$data['basicmsg'] = 'Category has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}


	//+++++++++++++++++++++++++++
	//GET CATEGORY LIST
	//++++++++++++++++++++++++++
	public function get_category_list()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('pub_categories');

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


	function category_back($id) {

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_id', $id);
		$query = $this->db->get('pub_categories');

		$query = $this->db->query("SELECT product_id AS pid FROM products WHERE bus_id = '".$bus_id."' AND product_id > '".$product_id."' ORDER BY product_id ASC LIMIT 1", FALSE);

	}

	//+++++++++++++++++++++++++++
	//GET PARENT NAME
	//++++++++++++++++++++++++++

	function get_parent($parent_id){

		if($parent_id != 0) {
			$bus_id = $this->session->userdata('bus_id');

			$this->db->select('cat_name');
			$this->db->where('bus_id', $bus_id);
			$this->db->where('cat_id', $parent_id);
			$query = $this->db->get('pub_categories');

			$row = $query->row();

			return $row->cat_name;

		} else {

			return 'none';

		}

	}

	function get_cat_sub($cat_id, $typ){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('parent_id', $cat_id);
		$query = $this->db->get('pub_categories');

		if($query->result()){

			$nr = $query->num_rows();

			if($typ == 'num') {

				return $nr;

			} else {

				return '<a title="View sub categories" rel="tooltip" class="btn btn-mini btn-inverse" style="cursor:pointer" href="'.site_url('/').'publication_extended/categories/'.$cat_id.'"><i class="icon-plus icon-white"></i></a>';

			}


		} else {

			if($typ == 'num') {
				return 'none';
			}

		}

	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY LIST
	//++++++++++++++++++++++++++
	public function select_doc()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('documents');

		echo '
		  <option value="0">Choose a document</option>';

			if($query->result()){

				foreach($query->result() as $row){
					echo '<option value="'.$row->doc_file.'">'.$row->title.'</option>';
				}

			}

		echo '</select>';

	}


	public function load_doc($pid) {

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->select('link');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('pub_id', $pid);
		$query = $this->db->get('publications_extended');

		if($query->result()){

			$row = $query->row();

			if($row->link != '') {

				echo '<div class="alert alert-info"><strong>Current file:</strong> ' . $row->link . ' <a href="javascript:void(0);" onclick="remove_doc('.$pid.')" class="btn btn-mini btn-danger pull-right"><i class="icon-trash icon-white"></i></a></div>';

			}


		}
	}


	public function get_pub_doc($pid, $title) {

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('pub_id', $pid);
		$query = $this->db->get('publications_extended');

		if($query->result()){

			$row = $query->row();


					$str = "$('#userfile1').click();";

					echo '
						<form action="'. site_url('/').'publication_extended/add_pub_doc/" method="post" accept-charset="utf-8" id="add-pub-doc" name="add-pub-doc" enctype="multipart/form-data">
						<input type="hidden" name="pid" value="'. $pid.'">
						<input type="hidden" name="title" value="'. $title.'">
						<input type="file" class="" id="userfile1" name="userfile">
						<div class="progress progress-striped active" id="procover1" style="display:none;margin-top:20px">
							<div class="bar bar-warning" style="width: 0%;"></div>
						</div>
						<button type="submit" class="btn btn-inverse" id="docbut">Add Document</button>
						</form>
						';

		}
	}

	
	
	


	//+++++++++++++++++++++++++++
	//GET ALL PUBLICATIONS
	//++++++++++++++++++++++++++
	public function get_all_publications()
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('publications_extended');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Issue Date </th>
						<th style="width:5%;font-weight:normal">Published </th>
						<th style="width:15%;font-weight:normal"></th>
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
						<td style="width:20%"><a style="cursor:pointer"
						href="'.site_url('/').'publication_extended/update_publication/'.$row->pub_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					.$row->title.'</div></a></td>
            			<td style="width:29%">'.$row->issue_date.'</td>
						<th style="width:5%;font-weight:normal">'.date('M d Y',strtotime($row->listing_date)).'</th>
						<td style="width:15%;text-align:right">
						<a title="Edit Publication" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'publication_extended/update_publication/'.$row->pub_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Publication" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_pub('.$row->pub_id.')">
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
			 		<h3>No Publications added</h3>
					No posts have been added. to add a new post please click on the add post button on the right</div>';

		}

	}
	//+++++++++++++++++++++++++++
	//GET POST DETAILS
	//++++++++++++++++++++++++++

	function get_publication($pub_id){

		$query = $this->db->where('pub_id', $pub_id);
		$query = $this->db->get('publications_extended');
		return $query->row_array();

	}




	//+++++++++++++++
	//DELETE CATEGORY
	//+++++++++++++++

	public function delete_category($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_id', $id);
		$this->db->delete('pub_categories');

	}


	//+++++++++++++++
	//ADD CATEGORY
	//+++++++++++++++
	public function add_category()
	{
		$bus_id = $this->session->userdata('bus_id');


		//INSERT INTO CATEGORIES
		$cat_name = $this->input->post('category_name');
		$parent = $this->input->post('parent');

		$slug = $this->clean_url_str($cat_name);


		//TEST DUPLICATE CATEGORIES
		$this->db->where('parent_id', $parent);
		$this->db->where('cat_name', $cat_name);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('pub_categories');

		if($result1->num_rows() == 0){

			$insertdata = array(
				'cat_name'=> $cat_name ,
				'slug'=> $slug ,
				'parent_id'=> $parent ,
				'bus_id'=> $bus_id,
			);

			$this->db->insert('pub_categories', $insertdata);
		}


	}

	//Get Main Categories Typehead
	function load_category_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('pub_categories');

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
	function get_categories_current($pub_id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('pub_id', $pub_id);
		$query = $this->db->get('pub_cat_int_extended');
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

	public function add_category_pub()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$pub_id = $this->input->post('pub_id_cat');

		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('pub_categories');

		if($result1->num_rows() == 0){
			$this->db->insert('pub_categories', $data);
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_name', $data['cat_name']);
		$result = $this->db->get('pub_categories');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('pub_id', $pub_id);
		$result = $this->db->get('pub_cat_int_extended');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['cat_id'] = $row['cat_id'];
			$data2['pub_id'] = $pub_id;
			$data2['cat_name'] = $data['cat_name'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('pub_cat_int_extended', $data2);
		}

	}


	//DELETE CATEGIRY MEMBER
	public function delete_category_pub($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('pub_cat_int_extended');

	}



	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories($parent)
	{
		$bus_id = $this->session->userdata('bus_id');


		$query = $this->db->query("SELECT A.cat_name as og_category,A.cat_id as main_cat_id, C.parent_id AS back_id, B.cat_name as sub_category,B.cat_id as sub_cat_id, COUNT(B.parent_id) as rows, C.cat_name as parent_name

									FROM pub_categories AS A
									LEFT JOIN pub_categories AS B ON A.cat_id = B.parent_id
									LEFT JOIN pub_categories AS C ON A.parent_id = C.cat_id
									WHERE A.parent_id = '".$parent."' AND A.bus_id = '".$bus_id."'
									GROUP BY A.cat_id
									", FALSE);

		$row2 = $query->row();

		if($parent != '0') {
			if ($row2 != '0') {
				echo '<a href="' . site_url('/') . 'publication_extended/categories/' . $row2->back_id . '" class="btn btn-xs btn-inverse"><< Category Back</a>';
			}
		}

		if($query->result()){



			echo'
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
           				<th style="width:40%;font-weight:normal">Category </th>
						<th style="width:20%;font-weight:normal">Parent </th>
						<th style="width:20%;font-weight:normal">Sub Categories </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				if($row->rows > 0) { $sub = '<a title="View sub categories" rel="tooltip" class="btn btn-mini btn-inverse" style="cursor:pointer" href="'.site_url('/').'publication_extended/categories/'.$row->main_cat_id.'"><i class="icon-plus icon-white"></i></a>'; } else {$sub = '';}
				echo '<tr>
						<td style="width:5%">'.$row->main_cat_id.'</td>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->og_category.'</div></td>
						<td style="width:20%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->parent_name.'</div></td>
						<td style="width:20%">'.$row->rows.'</td>
            			<td style="width:15%;text-align:right">
            			'.$sub.'
            			<a title="Edit category" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'publication_extended/update_category/'.$row->main_cat_id.'"><i class="icon-pencil"></i></a>
            			<a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_category('.$row->main_cat_id.')">
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
		
		
	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	function add_pub_doc()
	{
			$doc = $this->input->post('userfile', TRUE);
			$pid = $this->input->post('pid', TRUE);
			$title = $this->input->post('title', TRUE);
			$file = NULL;

			$enc_doc = md5($doc.date('Y m d s').rand(9, 99999)).'.pdf';

			//upload file
			$config['upload_path'] = BASE_URL .'assets/publications_extended/';
			$config['allowed_types'] = 'pdf|doc|docx|csv|xls|xlsx';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = FALSE;
			//$config['file_name']  = trim(substr($img, 0, 80));
			$config['file_name']  = $enc_doc;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{

					$data['error'] =  $this->upload->display_errors();

					echo "<script>
					$.noty.closeAll()
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
					noty(options);

					</script>";	

			}
			else
			{

				//$data = array('upload_data' => $this->upload->data());
				$file = $this->upload->file_name;

				
				
				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));	
				

				 // //populate array with values
				 //  $data1 = array( 
					// 'doc_file'=> $file,
					// 'bus_id' => $this->session->userdata('bus_id'),
					// 'title' => $this->upload->file_name
				 //  );

				 //  //insert into database
				 //  $this->db->insert('documents',$data1);

				//populate array with values
				$data_doc = array(
					'link'=> $enc_doc,
					'bus_id' => $this->session->userdata('bus_id')
				);


				$this->db->where('pub_id' , $pid);
				$this->db->update('publications_extended',$data_doc);


				//$data['filename'] = $file;

				 //redirect 
				  $data['basicmsg'] = 'Document added successfully!';
			  	  //echo $this->get_pub_doc();
				  echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);
					  $('#add_img').fadeOut();
					  </script>";		 
						 
					

		}

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