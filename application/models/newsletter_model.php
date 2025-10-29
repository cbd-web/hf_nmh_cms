<?php
class Newsletter_model extends CI_Model{
	
 	function newsletter_model(){
  		//parent::CI_model();
			
 	}

	 //+++++++++++++++++++++++++++
	 //GET NEWSLETTER DETAILS
	 //++++++++++++++++++++++++++   
	   
	 function get_newsletter($id){
		 
	   	  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);	
		  $query = $this->db->where('newsletter_id', $id);
		  $query = $this->db->get('mcn_newsletter');
		  
		  return $query->row_array();
	
	 }


	//+++++++++++++++++++++++++++
	//GET PARAGRAPH DETAILS
	//++++++++++++++++++++++++++

	function get_paragraph($id){

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('paragraph_id', $id);
		$query = $this->db->get('mcn_paragraphs');

		return $query->row_array();

	}

	 
	//DELETE NEWSLETTER
	function delete_newsletter($id){
      	
		if($this->session->userdata('admin_id')){
							
			  $bus_id = $this->session->userdata('bus_id');
			  
			  //delete from database
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('newsletter_id', $id);
			  $this->db->delete('mcn_newsletter');
			  
			  
			  $query = $this->db->where('bus_id', $bus_id);
			  $query = $this->db->where('newsletter_id', $id);
			  $this->db->delete('mcn_paragraphs');
			  
			  //LOG
			  $this->admin_model->system_log('delete_newsletter-'.$id);
			  $this->session->set_flashdata('msg','Newsletter deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'newsletter/newsletters/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }


	//DELETE PARAGRAPH
	function delete_paragraph($id){

		if($this->session->userdata('admin_id')){

			$bus_id = $this->session->userdata('bus_id');

			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('paragraph_id', $id);
			$this->db->delete('mcn_paragraphs');

			//LOG
			$this->admin_model->system_log('delete_paragraph-'.$id);
			$this->session->set_flashdata('msg','Paragraph deleted successfully');


		}else{

		}
	}


	//+++++++++++++++++++++++++++
	//UPDATE NEWSLETTER
	//++++++++++++++++++++++++++	
	function update_newsletter_do()
	{
			$title = $this->input->post('title', TRUE);
			$listing_date = $this->input->post('listing_date', TRUE);
			$status = $this->input->post('status', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);

			$slug = $this->clean_url_str($title);
			
			$id = $this->input->post('newsletter_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');
	
			$val = TRUE;
			
				$insertdata = array(
					  'title'=> $title ,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'status'=> strtolower($status),
					  'listing_date'=> $listing_date,
					  'slug'=> $slug
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('newsletter_id' , $id);
					$this->db->update('mcn_newsletter', $insertdata);
					//success redirect	
					$data['people_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update-newsletter-'. $id);
					$data['basicmsg'] = 'Newsletter has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}


	//+++++++++++++++++++++++++++
	//UPDATE PARAGRAPH
	//++++++++++++++++++++++++++
	function update_paragraph_do()
	{
		$title = $this->input->post('title', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

		$news_id = $this->input->post('newsletter_id', TRUE);
		$para_id = $this->input->post('paragraph_id', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		$val = TRUE;

		$insertdata = array(
			'title'=> $title ,
			'body'=> $body
		);

		if($val == TRUE){

			$this->db->where('paragraph_id' , $para_id);
			$this->db->update('mcn_paragraphs', $insertdata);

			//LOG
			$this->admin_model->system_log('update-paragraph-'. $para_id);
			$data['basicmsg'] = 'Newsletter Paragraph has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}



	//+++++++++++++++++++++++++++
	//ADD NEWSLETTER DO
	//++++++++++++++++++++++++++	
	function add_newsletter_do()
	{
			$title = $this->input->post('title', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);

			$slug = $this->clean_url_str($title);

			$bus_id = $this->session->userdata('bus_id');
			
			$val = TRUE;
			
			$insertdata = array(
					  'title'=> $title ,
					  'slug'=> $slug ,
				      'type'=> 'internal',
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'bus_id'=>$bus_id
					);
	
			
			if($val == TRUE){
				
					$this->db->insert('mcn_newsletter', $insertdata);
					$newsid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_newsletter-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Newsletter added successfully');
					$data['basicmsg'] = 'Newsletter has been added successfully';
					
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'newsletter/update_newsletter/'.$newsid.'/";
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
	//ADD PARAGRAPH DO
	//++++++++++++++++++++++++++
	function add_paragraph_do()
	{
		$newsletter_id = $this->input->post('newsletter_id', TRUE);
		$type = $this->input->post('para_type', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		//GET MAX SEQUENCE
		$query = $this->db->query("SELECT MAX(sequence) AS maxpid FROM mcn_paragraphs WHERE newsletter_id = '".$newsletter_id."'", FALSE);
		if($query->result()){

			$row = $query->row();

			$sequence = $row->maxpid+1;

		} else {
			$sequence = 0;
		}


		$insertdata = array(
			'newsletter_id'=> $newsletter_id ,
			'para_type'=> $type ,
			'sequence'=> $sequence,
			'bus_id'=>$bus_id
		);

		$this->db->insert('mcn_paragraphs', $insertdata);
		$id = $this->db->insert_id();

		redirect(site_url('/').'newsletter/update_paragraph/'.$id,'refresh');

	}
	

	//+++++++++++++++++++++++++++
	//GET ALL NEWSLETTERS
	//++++++++++++++++++++++++++
	public function get_all_newsletters()
	{
		  $bus_id = $this->session->userdata('bus_id');

		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->order_by('listing_date', 'ASC');
		  $query = $this->db->get('mcn_newsletter');

		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
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
						href="'.site_url('/').'newsletter/update_newsletter/'.$row->newsletter_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Newsletter" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'newsletter/update_newsletter/'.$row->newsletter_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Newsletter" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_newsletter('.$row->newsletter_id.')">
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
					No Entries have been added. to add a new entry please click on the add newsletter button on the right</div>';

		 }


	}

	//+++++++++++++++++++++++++++
	//GET ALL PARAGRAPHS
	//++++++++++++++++++++++++++
	public function get_all_paragraphs($newsletter_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT * FROM mcn_paragraphs WHERE newsletter_id = '".$newsletter_id."' ORDER BY sequence ASC", FALSE);

		if($query->result()){


			foreach($query->result() as $row){

				if($row->para_type == 'banner_img') {

					$body = '
					<div class="row-fluid">
					<img src="'.S3_URL.'assets/images/'.$row->banner_img.'" style="width:100%">
					</div>
					';

				}

				if($row->para_type == 'img_txt') {

					$body = '
					<div class="row-fluid">
						<div class="span4">
							<img src="'.S3_URL.'assets/images/'.$row->left_img.'" style="width:100%">
						</div>
						<div class="span8">
						'.$row->body.'
						</div>
					</div>
					';

				}

				if($row->para_type == 'txt_img') {

					$body = '
					<div class="row-fluid">
						<div class="span8">
						'.$row->body.'
						</div>
						<div class="span4">
							<img src="'.S3_URL.'assets/images/'.$row->right_img.'" style="width:100%">
						</div>

					</div>
					';

				}

				if($row->para_type == 'txt') {

					$body = '
					<div class="row-fluid">
						<div class="span12">
						'.$row->body.'
						</div>
					</div>
					';

				}

				if($row->para_type == 'gallery') {

					$body = '
					<div class="row-fluid">
						<div class="span4">
							<img src="'.S3_URL.'assets/images/'.$row->img_1.'" style="width:100%">
						</div>
						<div class="span4">
							<img src="'.S3_URL.'assets/images/'.$row->img_2.'" style="width:100%">
						</div>
						<div class="span4">
							<img src="'.S3_URL.'assets/images/'.$row->img_3.'" style="width:100%">
						</div>
					</div>
					';

				}


				echo '<div class="row-fluid" id="row-'.$row->paragraph_id.'">
					  '.$body.'<br>
					  <div>
						<a title="Edit Paragraph" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'newsletter/update_paragraph/'.$row->paragraph_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Paragraph" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_paragraph('.$row->paragraph_id.')">
						<i class="icon-trash icon-white"></i></a>
					  </div>
					  </div><hr>';
			}

		}else{

			echo '<div class="alert">
			 		<h3>No Entries added</h3>
					No Entries have been added. to add a new entry please click on the add paragraph button on top</div>';

		}


	}


	function get_news_image($type, $id, $vol) {

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('paragraph_id', $id);
		$query = $this->db->get('mcn_paragraphs');

		$row = $query->row();

		if($row->$type != ''){

			$str = "$('#feat_img_".$vol."').html('');";
			$row = $query->row_array();
			echo '<div id="feat_img_'.$vol.'"><div class="img-polaroid"><img src="'.S3_URL.'assets/images/'.$row[$type].'" style="width:100%" />
				  <p style="padding:10px 10px 0px 0px;text-align:right">
				  <a href="javascript:void(0);" onclick="remove_img('.$id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
				  </p></div></div>';

			$str = "$('#userfile_".$vol."').click();$('#imgbut_".$vol."').removeClass('disabled');";
			echo '<div id="add_img_'.$vol.'" style="display:none">
					 <form action="'. site_url('/').'newsletter/add_news_image/" method="post" accept-charset="utf-8" id="add-img-'.$vol.'" name="add-img-'.$vol.'" enctype="multipart/form-data">
						<fieldset>
						<input type="file" class="" id="userfile_'.$vol.'" style="display:none" name="userfile">
						<input type="hidden" name="type_id" value="'. $id.'">
						<input type="hidden" name="type" value="'. $type.'">
						<input type="hidden" name="vol" value="'. $vol.'">
						<div id="avatar_msg_'.$vol.'"></div>
						<div class="progress progress-striped active" id="procover_'.$vol.'" style="display:none;margin-top:20px">
								   <div class="bar bar-warning" style="width: 0%;"></div>
						</div>

						<a href="javascript:void(0)" onClick="'.$str.'" class="btn">Select Image</a>
						<button type="submit" class="btn btn-inverse" id="imgbut_'.$vol.'">Add featured Image</button>
						</fieldset>
					  </form>
					  </div>

				  ';

		}else{

			$str = "$('#userfile_".$vol."').click();$('#imgbut_".$vol."').removeClass('disabled');";
			echo '<div id="feat_img_'.$vol.'"><div class="alert">No featured image selected</div></div>
				<div id="add_img_'.$vol.'">
				 <form action="'. site_url('/').'newsletter/add_news_image/" method="post" accept-charset="utf-8" id="add-img-'.$vol.'" name="add-img-'.$vol.'" enctype="multipart/form-data">
				  	<fieldset>
					<input type="file" class="" id="userfile_'.$vol.'" style="display:none" name="userfile">
					<input type="hidden" name="type_id" value="'. $id.'">
					<input type="hidden" name="type" value="'. $type.'">
					<input type="hidden" name="vol" value="'. $vol.'">
					<div id="avatar_msg_'.$vol.'"></div>
                    <div class="progress progress-striped active" id="procover_'.$vol.'" style="display:none;margin-top:20px">
                               <div class="bar bar-warning" style="width: 0%;"></div>
                    </div>

					<a href="javascript:void(0)" onClick="'.$str.'" class="btn">Select Image</a>
					<button type="submit" class="btn btn-inverse disabled" id="imgbut_'.$vol.'">Add featured Image</button>
					</fieldset>
				  </form>
				  </div>';


		}

		echo ' <script type="text/javascript">
				  	function remove_img(id){
						$("#add_img_'.$vol.'").fadeIn();
				  		$("#feat_img_'.$vol.'").empty();

						$.ajax({
							type: "get",

							url: "'. site_url('/').'newsletter/remove_news_image/'.$type.'/"+id ,
							success: function (data) {


							}
						});

					}
				  </script>';

	}







	//+++++++++++++++++++++++++++
	//ADD NEWS IMAGE
	//++++++++++++++++++++++++++

	function add_news_image()
	{
		$img = $this->input->post('userfile', TRUE);
		$id = $this->input->post('type_id', TRUE);
		$type = $this->input->post('type', TRUE);
		$vol = $this->input->post('vol', TRUE);

		//upload file
		$config['upload_path'] = BASE_URL .'assets/images/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']	= '12000';
		$config['max_width']  = '8324';
		$config['max_height']  = '8550';
		$config['min_width']  = '200';
		$config['min_height']  = '200';
		$config['remove_spaces']  = TRUE;
		$config['encrypt_name']  = TRUE;
		//$config['file_name']  = trim(substr($img, 0, 80));

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{

			$data['error'] =  $this->upload->display_errors();
			echo 'hi';

		}
		else
		{
			//LOAD library
			$this->load->library('image_lib');

			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;

			$format = substr($file,(strlen($file) - 4),4);
			$str = substr($file,0,(strlen($file) - 4));

			if (($width > 1950) || ($height > 900)){

				$this->load->model('image_model');
				$this->image_model->downsize_image($file, '1800', '1000');

			}

			//populate array with values
			$data = array(
				$type => $file
			);

			$this->db->where('paragraph_id', $id);
			$this->db->update('mcn_paragraphs', $data);

			$item_id = $this->db->insert_id();

			$data['filename'] = $file;
			$data['width'] = $this->upload->image_width;
			$data['height'] = $this->upload->image_height;
			$image = S3_URL . 'assets/images/'.$file;
			//redirect
			$data['basicmsg'] = 'Image added successfully!';
			$str = '<div id="feat_img_'.$vol.'"><div class="img-polaroid"><img src="'.$image.'"  style="width:100%" /><p style="padding:10px 10px 0px 0px;text-align:right"><i class="icon-pencil icon-white"></i></a><a href="javascript:void(0);" onclick="remove_img('.$id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p></div></div>';
			echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);
					  $('#feat_img_".$vol."').html('".$str."');
					  $('#add-img-".$vol."').fadeOut();
					  </script>";



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