<?php
class Publication_model extends CI_Model{
	function UploudToNMHS3($fileURL, $S3Dir, $filename_Plus_Extension)
    {
        $query =   http_build_query(array(
            'fileURL' => $fileURL,
            'S3Dir' => $S3Dir,
            'filename_Plus_Extension' => $filename_Plus_Extension,
            'SecretKey' => 'NMHServer123FilesAKIA44MUTREB73NBQLK7'
        ));

        $ch    = curl_init('https://cdn.nmh.com.na:2083/api/Upload' . '?' . $query);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        return json_decode($response);
    }
 	function publication__model(){
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
	//load gallery images For gallery Update
	//++++++++++++++++++++++++++
	
	function load_gallery_images_update($pub_id){
			
		$this->db->where('type', 'publication');
		$this->db->where('type_id', $pub_id);
		$test = $this->db->order_by('sequence', 'ASC');
		$test = $this->db->get('images');

		if($test->result()){
			
			echo'<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%"> 
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
           				<th style="width:20%;font-weight:normal"></th>
						<th style="width:50%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($test->result() as $row){
				
				echo '<tr class="myDragClass">
				
						<td style="width:10%">
						<input type="hidden" value="'.$row->img_id.'" />
						<img src="'.S3_URL.'assets/images/'.$row->img_file.'" width="100px" style="width:100px;display:inline-block"  class="img-polaroid"/></td>
						<td style="width:20%"><div style="text-decoration:none;top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></td>
            			<td style="width:50%"><div style="font-weight:bold;font-size:11px;top:0;left:0;right:0;bottom:0;border:none">'
						.$row->body.'</div></td>
						<td style="width:20%;text-align:right">
						<a title="Edit image" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_image('.$row->img_id.')"><i class="icon-pencil"></i></a>
						<a href="#" onclick="delete_image('.$row->img_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
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
									var img_id = $(this).val(), index = i;
									console.log(img_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'admin/update_img_sequence/"+img_id+"/"+index ,
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
	//upload gallery images
	//++++++++++++++++++++++++++
	
	function add_gallery_images()
	{
		
		 $this->load->library('upload');  // NOTE: always load the library outside the loop
		 $pub_id = $_REQUEST['pub_id'];
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
				
				   
				   $config['upload_path'] = BASE_URL.'assets/images/';
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


						  //$this->load->model('s3_model');
						  //$this->s3_model->upload_s3('assets/images/' . $file);
 						 
                          $cdn = $this->UploudToNMHS3(base_url('assets/images/' . $file), 'mynamibia-eu/cms/assets/images/', $oname);
                          //var_dump(
                          $file = str_replace('https://cdn.nmh.com.na:2083/S3Server/mynamibia-eu/cms/assets/images/', '', $cdn->filePath);
		

						  //populate array with values
						  $data = array(
							  'img_file'=> $file,
							  'type' => 'publication',
							  'bus_id' => $bus_id,
							  'type_id' => $pub_id

						  );

						//insert into database
						 $this->db->insert('images',$data);

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
					  
				 $data['basicmsg'] = 'Document added successfully!';
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

				return '<a title="View sub categories" rel="tooltip" class="btn btn-mini btn-inverse" style="cursor:pointer" href="'.site_url('/').'publication/categories/'.$cat_id.'"><i class="icon-plus icon-white"></i></a>';

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
		$query = $this->db->get('publications');

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
		$query = $this->db->get('publications');

		if($query->result()){

			$row = $query->row();


					$str = "$('#userfile1').click();";

					echo '
						<form action="'. site_url('/').'publication/add_pub_doc/" method="post" accept-charset="utf-8" id="add-pub-doc" name="add-pub-doc" enctype="multipart/form-data">
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
		$query = $this->db->get('publications');
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
						href="'.site_url('/').'publication/update_publication/'.$row->pub_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					.$row->title.'</div></a></td>
            			<td style="width:29%">'.$row->issue_date.'</td>
						<th style="width:5%;font-weight:normal">'.date('M d Y',strtotime($row->listing_date)).'</th>
						<td style="width:15%;text-align:right">
						<a title="Edit Publication" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'publication/update_publication/'.$row->pub_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Pupblication" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_pub('.$row->pub_id.')">
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
		$query = $this->db->get('publications');
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
		$query = $this->db->get('pub_cat_int');
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
		$result = $this->db->get('pub_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['cat_id'] = $row['cat_id'];
			$data2['pub_id'] = $pub_id;
			$data2['cat_name'] = $data['cat_name'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('pub_cat_int', $data2);
		}

	}


	//DELETE CATEGIRY MEMBER
	public function delete_category_pub($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('pub_cat_int');

	}



	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories($parent)
	{
		$bus_id = $this->session->userdata('bus_id');


		$query = $this->db->query("SELECT A.cat_name as og_category,A.cat_id as main_cat_id, C.parent_id AS back_id, B.cat_name as sub_category,B.cat_id as sub_cat_id, COUNT(B.parent_id) as 'rows', C.cat_name as parent_name

									FROM pub_categories AS A
									LEFT JOIN pub_categories AS B ON A.cat_id = B.parent_id
									LEFT JOIN pub_categories AS C ON A.parent_id = C.cat_id
									WHERE A.parent_id = '".$parent."' AND A.bus_id = '".$bus_id."'
									GROUP BY A.cat_id
									", FALSE);

		$row2 = $query->row();

		if($parent != '0') {
			if ($row2 != '0') {
				echo '<a href="' . site_url('/') . 'publication/categories/' . $row2->back_id . '" class="btn btn-xs btn-inverse"><< Category Back</a>';
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

				if($row->rows > 0) { $sub = '<a title="View sub categories" rel="tooltip" class="btn btn-mini btn-inverse" style="cursor:pointer" href="'.site_url('/').'publication/categories/'.$row->main_cat_id.'"><i class="icon-plus icon-white"></i></a>'; } else {$sub = '';}
				echo '<tr>
						<td style="width:5%">'.$row->main_cat_id.'</td>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->og_category.'</div></td>
						<td style="width:20%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->parent_name.'</div></td>
						<td style="width:20%">'.$row->rows.'</td>
            			<td style="width:15%;text-align:right">
            			'.$sub.'
            			<a title="Edit category" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'publication/update_category/'.$row->main_cat_id.'"><i class="icon-pencil"></i></a>
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

			//upload file
			$config['upload_path'] = BASE_URL .'assets/documents/';
			$config['allowed_types'] = 'pdf|doc|docx|csv|xls|xlsx';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = FALSE;
			//$config['file_name']  = trim(substr($img, 0, 80));
			
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

				$this->load->model('s3_model');
				$this->s3_model->upload_s3('assets/documents/' . $file);
		
	
				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));	
				


				 //populate array with values 
				  $data1 = array( 
					'doc_file'=> $file,
					'bus_id' => $this->session->userdata('bus_id'),
					'title' => $this->upload->file_name
				  );

				  //insert into database
				  $this->db->insert('documents',$data1);

				//populate array with values
				  
				$data_doc = array(
					'link'=> $file,
					'bus_id' => $this->session->userdata('bus_id')
				);


				$this->db->where('pub_id' , $pid);
				$this->db->update('publications',$data_doc);


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