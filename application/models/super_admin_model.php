<?php
class Super_admin_model extends CI_Model{
	
 	function super_admin_model(){
  		//parent::CI_model();
			
 	}
	
	//+++++++++++++++++++++++++++
	//GET NAVIGATION
	//++++++++++++++++++++++++++
	function get_navigation(){
			

		$test = $this->db->where('status', 'live');
		$pages = $this->db->get('pages');
		
		echo '<ol class="sortable">';

		if($pages->result()){
			
			foreach($pages->result() as $page_row){
				
				echo '<li id="page_'.$page_row->page_id.'">
                         <div class="box">
                               <div class="box-header">
                                    <h2><i class="icon-list"></i><span class="break"></span>'.$page_row->title.'</h2>
                                    <div class="box-icon">
                                           <a href="#" class="disclose btn-close"><i class="icon-remove"></i></a>
                                     </div>    
                                </div>
                         </div>
                      </li>';
			}
			
			//GET POSTS
			
			$test = $this->db->where('status', 'live');
			$posts = $this->db->get('posts');
			
			if($posts->result()){
				
					echo '<li id="post_0">
							 <div class="box">
								   <div class="box-header">
										<h2><i class="icon-list"></i><span class="break"></span>News</h2>
										<div class="box-icon">
											   <a href="#" class="disclose btn-close"><i class="icon-remove"></i></a>
										 </div>    
									</div>
							 </div>
                      	
							 <ol>';
								
									foreach($posts->result() as $post_row){
										
										echo '<li id="post_'.$post_row->post_id.'">
												<div class="box">
													   <div class="box-header">
															<h2><i class="icon-list"></i><span class="break"></span>'.$post_row->title.'</h2>
															<div class="box-icon">
																   <a href="#" class="disclose btn-close"><i class="icon-remove"></i></a>
															 </div>    
														</div>
												 </div>
											  </li>'; 
									}
						echo ' </ol>
							</li>';
			}
			
		}else{
			  
			   echo '<div class="alert">
			 		<h3>No Pages added</h3>
					No Pages or posts have been added. Please add some content first</div>';	
				
		}

	}
		
	//+++++++++++++++++++++++++++
	//SHOW MENU
	//++++++++++++++++++++++++++

	public function show_menu($menu)
	{
		
		$myMenu = explode('&', $menu);
		
		if(count($myMenu) > 0){
			
			echo '<ol class="sortable">';
			
				foreach($myMenu as $row){
					
					$substr = substr($row,strpos($row, '[') +1);
					$type = substr($row, 0,4);
					//$id = substr($row,strpos($row, '[') +1 , strpos($row, '='));
					$id = substr($substr, 0, strpos($substr, ']', 1));
					$parent = substr($row, strpos($row, '=') +1 , strlen($row));

					$content = $this->get_content_title($type, $id);
					
					if($parent == 'null'){
						
						$sub_link = $this->get_menu_sub($type, $id, $menu);					
						echo '<li id="'.$type.'_'.$id.'">                        
									<div class="box">
										   <div class="box-header">
												<h2><i class="icon-list"></i><span class="break"></span>'.$content['title'].' <em><code>'. $type. '</code></em></h2>
												<div class="box-icon">
													   <a href="#" class="disclose btn-close"><i class="icon-remove"></i></a>
												 </div>    
											</div>
									 </div>'.
										$sub_link.
								'
								</li> ';
					
					}else{
						
											

						
					}

					
					
					//echo 'Type: '. $type. ' --  ID: '.$id.' Parent: '.$parent.'<br/>';
					
				}
			
			echo '</ol>';
		}else{
			
			
			 echo '<div class="alert">
			 		<h3>No Menu added</h3>
					No menu has been added. to add a new menu please click on the add menu button on the right</div>';	
					
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//GET MENU SUB LINKS
	//++++++++++++++++++++++++++
	public function get_menu_sub($type1, $id_1, $menu)
	{
		$myMenu = explode('&', $menu);
		
		if(count($myMenu) > 0){
				$str = '';
				foreach($myMenu as $row){
					
					$substr = substr($row,strpos($row, '[') +1);
					$type = substr($row, 0,4);
					//$id = substr($row,strpos($row, '[') +1 , strpos($row, '='));
					$id = substr($substr, 0, strpos($substr, ']', 1));
					$parent = substr($row, strpos($row, '=') +1 , strlen($row));
					
					if($parent == $id_1){
							
							$content = $this->get_content_title($type, $id);
							
							$str .= '<ol>
									<li id="'.$type.'_'.$id.'">                        
										<div class="box">
											   <div class="box-header">
													<h2><i class="icon-list"></i><span class="break"></span>'.$content['title'].'  <em><code>'. $type. '</code></em></h2>
													<div class="box-icon">
														   <a href="#" class="disclose btn-close"><i class="icon-remove"></i></a>
													 </div>    
												</div>
										 </div>
									</li>
								</ol> ';
						
					}
					
				}
			return $str;	
		}			  
	}	
	//+++++++++++++++++++++++++++
	//GET CONTENT TITLE
	//++++++++++++++++++++++++++
	public function get_content_title($type, $id)
	{
		if($type == 'page'){
			
			$this->db->where('page_id', $id);
			$query = $this->db->get('pages');	
			
		}else{
			
			$this->db->where('post_id', $id);
			$query = $this->db->get('posts');	
			
		}
		
		if($id == 0){
			
			$row['title'] = 'News';
			return $row;
			
		}else{
		
			return $query->row_array();
		}
			  
	}
	//+++++++++++++++++++++++++++
	//Updte Menu
	//++++++++++++++++++++++++++
	public function update_menu_do()
	{
			$menu = $this->input->post('menu', TRUE);
			
			$query = $this->db->get('menus');
			
			$insertdata = array(
							  'bus_id'=> $bus_id ,
							  'menu'=> $menu
							  
			);
			
			if($query->result()){
				
				$this->db->where('bus_id' , $bus_id);
				$this->db->update('menus', $insertdata);
				
			}else{

				$this->db->insert('menus', $insertdata);
				
			}

			
			//LOG
			  $this->admin_model->system_log('update_menu-'. $bus_id);
			  $data['basicmsg'] = 'Menu has been updated successfully';
			  echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);</script>";
			  
	}
	
	//+++++++++++++++++++++++++++
	//BUILD MENU
	//++++++++++++++++++++++++++
	public function build_menu()
	{
		  
		  $query = $this->db->get('pages');
		 
		 if($query->result()){
			
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Menu added</h3>
					No menu has been added. to add a new menu please click on the add menu button on the right</div>';
		  
		 }
				
		
	}
	//+++++++++++++++++++++++++++
	//GET ALL GALLERIES
	//++++++++++++++++++++++++++
	public function get_all_galleries()
	{
		  
		  $query = $this->db->order_by('datetime', 'ASC');
		  $query = $this->db->get('galleries');
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:40%;font-weight:normal">Description </th>
						<th style="width:20%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){

				echo '<tr>
						
						<td style="width:30%"><a style="cursor:pointer" 
						href="'.site_url('/').'admin/update_gallery/'.$row->gal_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:40%">'.strip_tags(substr($row->description,0,80)).'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->review)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Gallery" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_gallery/'.$row->gal_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Gallery" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_gallery('.$row->gal_id.')">
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
			 		<h3>No Galleries added</h3>
					No galleries have been added. to add a new gallery please click on the add gallery button on the right</div>';
		  
		 }
				
		
	}
	
	//+++++++++++++++++++++++++++
	//GET ALL GALLERIES FOR SELECT
	//++++++++++++++++++++++++++
	public function get_all_galleries_select()
	{

		  $query = $this->db->order_by('datetime', 'ASC');
		  $query = $this->db->get('galleries');
		  if($query->result()){
			echo'<select name="gallery_select" class="span12" id="gallery_select">
				    <option value="0">No Gallery</option>';
				
			foreach($query->result() as $row){

				echo '<option value="'.$row->gal_id.'">'.$row->title.'</option>';;
			}
			
			
			echo '</select><br />
			
				 <a href="#" onclick="attach_gallery()" class="btn btn-inverse"><i class="icon-plus-sign icon-white"></i> Add Gallery</a>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		No Galleries added</div>';
		  
		 }
				
		
	}
	//+++++++++++++++++++++++++++
	//GET GALLERY DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_gallery($gal_id){
			
		$test = $this->db->where('gal_id', $gal_id);
		$test = $this->db->get('galleries');
		return $test->row_array();	

	}

	//+++++++++++++++++++++++++++
	//GET ALL PROJECTS
	//++++++++++++++++++++++++++
	public function get_all_projects()
	{

		  $query = $this->db->order_by('review', 'ASC');
		  $query = $this->db->get('projects');
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:29%;font-weight:normal">Body </th>
						<th style="width:10%;font-weight:normal">Meta Title </th>
						<th style="width:15%;font-weight:normal">Meta Description </th>
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
						<td style="width:20%"><a style="cursor:pointer" 
						href="'.site_url('/').'admin/update_project/'.$row->project_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:29%">'.strip_tags(substr($row->body,0,80)).'</td>
						<td style="width:10%">'.$row->metaT.'</td>
						<td style="width:15%">'.$row->metaD.'</td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->review)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit project" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_project/'.$row->project_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Project" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_project('.$row->project_id.')">
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
			 		<h3>No Projects added</h3>
					No projects have been added. to add a new project please click on the add project button on the right</div>';
		  
		 }
				
		
	}

	//+++++++++++++++++++++++++++
	//GET ALL IMAGEs
	//++++++++++++++++++++++++++
	public function get_all_images()
	{

		  $query = $this->db->order_by('datetime', 'DESC');
		  $query = $this->db->get('images');
		  if($query->result()){
			echo'<ul  class="thumbnails">';
			
			foreach($query->result() as $row){
			
				echo '<li  class="img-polaroid">
						<img src="'.base_url('/').'assets/images/'.$row->img_file.'" width="200px" style="width:200px" />
						<p style="padding:10px 0px 0px 10px;"><a href="#" onclick="delete_image('.$row->img_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p>
					  </li>';
			}
			
			
			echo '</ul>
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Images added</h3>
					No images have been added. to add a new image please please insert it into some content on the website</div>';
		  
		 }
				
		
	}
	//+++++++++++++++++++++++++++
	//GET GALLERY SPECIFIC IMAGEs
	//++++++++++++++++++++++++++
	public function get_sidebar_content($content)
	{
		  if(is_numeric($content)){
		
				  $query = $this->db->where('gal_id', $gal_id);
				  $query = $this->db->get('images');
				  if($query->result()){
					echo'<ul  class="thumbnails">';
					
					foreach($query->result() as $row){
					
						echo '<li  class="img-polaroid">
								<img src="'.base_url('/').'assets/images/'.$row->img_file.'" width="120px" style="width:120px" />
								<p style="padding:10px 0px 0px 10px;"><a href="#" onclick="delete_image('.$row->img_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p>
							  </li>';
					}
					
					
					echo '</ul>
						<script type="text/javascript">
							
						</script>';
					
				}else{
					 
					 echo ' <p>Select Gallery to attach</p>
						<div class="alert">
						<h3>No Gallery added</h3>
						No gallery have been added. to add a gallery into the content please insert select it below</div>';
						$this->get_all_galleries_select();
				  
				 }
		
		//SPECIFIC TO A POST OR PAGE VALUE
		}else{
			
				if( substr($content, 0, strpos($content,'_')) == 'page'){
					
					$page_id =  substr($content, (strpos($content,'_') + 1), strlen($content));
					$query = $this->db->where('page_id', $page_id);
					$query = $this->db->get('sidebars');
					
					if($query->result()){
						
						foreach($query->result() as $row){
							
							$this->load_sidebar_content($row);
						}
					}else{
						$this->get_all_galleries_select();
						
					}

					
				}elseif(substr($content, 0, strpos($content,'_')) == 'post'){
					
					$post_id =  substr($content, (strpos($content,'_') + 1), strlen($content));
					$query = $this->db->where('post_id', $post_id);
					$query = $this->db->get('sidebars');
					
					if($query->result()){
						
						foreach($query->result() as $row){
							
							$this->load_sidebar_content($row);
						}
					}else{
						$this->get_all_galleries_select();
						
					}
					
				}else{
					
				  
				}
					
		//echo $content . '     -  ' .substr($content, 0, strpos($content,'_')) . '    -   ' .substr($content, (strpos($content,'_') + 1), strlen($content));
			 
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//LOAD SIDEBAR CONTENTS
	//++++++++++++++++++++++++++		 
	 
	function load_sidebar_content($row){
		
		$type = substr($row->type, 0, strpos($row->type,'_'));
		$id = substr($row->type, (strpos($row->type,'_')+ 1) , strlen($row->type) );
		
		if($type == 'gallery'){
			
			//echo $id;
			echo '<div style="display:inline-block">';
			$this->load_gallery_images($id);
			echo '</div>';
			
		}elseif($type == 'contact'){
			
			echo 'Gallery';
		}else{
			
			echo $row->type;
		}
		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//GET PROJECT DOCUMENTS
	//++++++++++++++++++++++++++		 
	 
	function get_project_docs($project_id){
			
		$test = $this->db->where('project_id', $project_id);
		$test = $this->db->order_by('sequence', 'ASC');
		$test = $this->db->get('project_documents');
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
						<input type="hidden" value="'.$row->doc_id.'" />
						<img src="'.base_url('/').'admin_src/img/pdf_icon.png" width="20" height="20" width="20px;height:20px" /></td>
						<td style="width:20%"><div style="font-weight:bold;font-size:11px;top:0;left:0;right:0;bottom:0;border:none">'
						.$row->description.'</div></td>
            			<td style="width:50%"><a href="'.base_url('/').'assets/documents/'.$row->doc_file.'" target+"_blank"><div style="text-decoration:none;top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
						<td style="width:20%;text-align:right">
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
									var doc_id = $(this).val(), index = i;
									console.log(doc_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'admin/update_doc_sequence/"+doc_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
			
		}else{
			 echo '<div class="alert">
			 		<h3>No Documents added</h3>
					No project documents have been added. to add a new document please click on the add document button </div>';
			
		}

	}
	
	//+++++++++++++++++++++++++++
	//upload gallery images
	//++++++++++++++++++++++++++
	
	function add_gallery_images()
	{
		
		 //$this->load->library('image_lib');	
		 $this->load->library('upload');  // NOTE: always load the library outside the loop
		 $gallery_id = $_REQUEST['gallery_id'];
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
						  	
							if (($width > 1000) || ($height > 1200)){
	 								
									$this->load->model('image_model');
									$this->image_model->downsize_image($file);
											
							}

							  //populate array with values
							  $data = array(
								  'gal_id' => $project_id,  
								  'img_file'=> $file,
								  'type' => 'gal_img',
								  'bus_id' => $bus_id,
								  'gal_id' => $gallery_id
							   	  
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
	//load gallery images
	//++++++++++++++++++++++++++
	
	function load_gallery_images($gal_id)
	{
		
		  //$bus_id = $this->session->userdata('bus_id');
		  //$query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->where('type', 'gal_img');
		  $query = $this->db->where('gal_id', $gal_id);
		  $query = $this->db->get('images');
		  if($query->result()){
			echo'<ul class="thumbnails">';
			
			foreach($query->result() as $row){
			
				echo '<li  class="img-polaroid">
						<img src="'.base_url('/').'assets/images/'.$row->img_file.'" width="100px" style="width:100px;display:inline-block" />
						
					  </li>';
			}
			
			
			echo '
				</ul>
				<p style="padding:10px 0px 0px 10px;text-align:right"><a href="#" onclick="remove_gallery('.$row->gal_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i> Remove Gallery</a></p>
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			 echo ' <p>Select Gallery to attach</p>
					<div class="alert">
			 		<h3>No Gallery added</h3>
					No gallery have been added. to add a gallery into the content please insert select it below</div>';
		  			$this->get_all_galleries_select();
		 }
		
	}
	
	//+++++++++++++++++++++++++++
	//load gallery images For gallery Update
	//++++++++++++++++++++++++++
	
	function load_gallery_images_update($gal_id)
	{
		
		  $query = $this->db->where('type', 'gal_img');
		  $query = $this->db->where('gal_id', $gal_id);
		  $query = $this->db->get('images');
		  if($query->result()){
			echo'<ul class="thumbnails">';
			
			foreach($query->result() as $row){
			
				echo '<li  class="img-polaroid">
						<img src="'.base_url('/').'assets/images/'.$row->img_file.'" width="100px" style="width:100px;display:inline-block" />
						<p style="padding:10px 0px 0px 10px;text-align:right"><a href="#" onclick="delete_image('.$row->img_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p>
					  </li>';
			}
			
			
			echo '
				</ul>
				
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			 echo ' <p>Select Gallery to attach</p>
					<div class="alert">
			 		<h3>No Gallery added</h3>
					No gallery have been added. to add a gallery into the content please insert select it below</div>';
		  			$this->get_all_galleries_select();
		 }
		
	}
	 //+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS
	//++++++++++++++++++++++++++
	
	function add_project_docs()
	{
		 $bus_id = $this->session->userdata('bus_id');
		 //$this->load->library('image_lib');	
		 $this->load->library('upload');  // NOTE: always load the library outside the loop
		 $project_id = $_REQUEST['project_id'];
		
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
				
				   
				   $config['upload_path'] = BASE_URL.'assets/documents/';
				   $config['allowed_types'] = 'jpg|jpeg|gif|png|doc|docx|pdf';
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
						
						  //GET DOcumnet sequence
						  $this->db->where('project_id' ,$project_id);
						  $query = $this->db->get('project_documents');
						  if($query->result()){
							 
							 $seq = 'Appendix '. $query->num_rows(); 	  
							
						  }else{
							  
							  $seq = 'Appendix 1'; 
							  
						  }
							  //populate array with values
							  $data = array(
								  'project_id' => $project_id,  
								  'doc_file'=> $file,
								  'title' => $oname,
								  'bus_id' => $bus_id,
								  'description' => $seq
							   
							  );
							 
							//insert into database
							 $this->db->insert('project_documents',$data);
							 
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
	//UPDATE DOCUMENT
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		    $title = $this->input->post('doc_title', TRUE);
			$name = $this->input->post('doc_name', TRUE);
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
							  'description'=> $name
							  
			);
		
	
			
			if($val == TRUE){
				
					$this->db->where('doc_id' , $id);
					$this->db->update('project_documents', $insertdata);
					//success redirect	
					
					
					//LOG
					$this->admin_model->system_log('update_document-'. $id);
					$data['basicmsg'] = 'Document has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
			
	}		
	

	//+++++++++++++++++++++++++++
	//GET PROJECT DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_project($project_id){
			
		$test = $this->db->where('project_id', $project_id);
		$test = $this->db->get('projects');
		return $test->row_array();	

	}
	
	
	//+++++++++++++++++++++++++++
	//GET ALL PAGES
	//++++++++++++++++++++++++++
	public function get_all_pages()
	{

		  $query = $this->db->get('pages');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:34%;font-weight:normal">Body </th>
						<th style="width:15%;font-weight:normal">Account </th>
						<th style="width:10%;font-weight:normal">Meta Description </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				
				$acc = $this->get_account($row->bus_id);
				
				echo '<tr>
						<td style="width:6%">'.$status.'</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="'.site_url('/').'admin/update_page/'.$row->page_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:34%">'.substr(strip_tags($row->body),0,80).'</td>
						<td style="width:15%">'.$acc['title'].'</td>
						<td style="width:10%">'.substr(strip_tags($row->metaD),0,80).'</td>
						<td style="width:15%;text-align:right">
						<a title="Edit Page" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_page/'.$row->page_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Page" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_page('.$row->page_id.')">
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
			 		<h3>No Pages added</h3>
					No pages have been added. to add a new page please click on the add page button on the right</div>';
		  
		 }
		  
				
				
		
	}
	
	
		
	//+++++++++++++++++++++++++++
	//GET ACCOUNT DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_account($bus_id){
			
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('settings');
		
		if($test->result()){
			
			return $test->row_array();
			
		}else{
			
			$data['title'] = 'No Account';
		}
			

	}
	//+++++++++++++++++++++++++++
	//GET PAGE DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_page($page_id){
			
		$test = $this->db->where('page_id', $page_id);
		$test = $this->db->get('pages');
		return $test->row_array();	

	}
	
	//+++++++++++++++++++++++++++
	//GET ALL COMMENTS
	//++++++++++++++++++++++++++
	public function get_all_comments()
	{

		  $query = $this->db->order_by('datetime','DESC');
		  $query = $this->db->get('comments');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Name </th>
						<th style="width:40%;font-weight:normal">Body </th>
						<th style="width:15%;font-weight:normal">Comment Date </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$str_live = "'".$row->com_id."', 'live'";
				$str_moderate = "'".$row->com_id."', 'moderate'";
				$status = '<a href="javascript:void" onclick="update_status('.$str_live.')"><span class="label label-warning">Moderate</span></a>';
				$btn = '<a class="btn btn-mini btn-warning" href="javascript:void" onclick="update_status('.$str_live.')"><i class="icon-off"></i></a>';
				if($row->status == 'live'){
					$status = '<a href="javascript:void" onclick="update_status('.$str_moderate.')"><span class="label label-success">Live</span></a>';
					$btn = '<a class="btn btn-mini btn-success" href="javascript:void" onclick="update_status('.$str_moderate.')"><i class="icon-play icon-white"></i></a>';
				}
				echo '<tr>
						<td style="width:10%">'.$status.'</td>
						<td style="width:20%">'.$row->name.'</td>
            			<td style="width:40%">'.strip_tags(substr($row->body,0,80)).'</td>
						<th style="width:15%;font-weight:normal">'.date('M d Y h:i',strtotime($row->datetime)).'</th>
						<td style="width:15%;text-align:right">'
						.$btn.'
						<a title="Edit Comment" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="view_comment('.$row->com_id.')"><i class="icon-search"></i></a>
						<a title="Delete Comment" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_comment('.$row->com_id.')">
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
			 		<h3>No Comments added</h3>
					No comments have been made. </div>';
		  
		 }
		  
		
		
	}

	
	//+++++++++++++++++++++++++++
	//GET ALL POSTS
	//++++++++++++++++++++++++++
	public function get_all_posts()
	{
		  
		  $query = $this->db->get('posts');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:29%;font-weight:normal">Body </th>
						<th style="width:15%;font-weight:normal">Account </th>
						<th style="width:10%;font-weight:normal">Meta Description </th>
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
				
				$acc = $this->get_account($row->bus_id);
				echo '<tr>
						<td style="width:6%">'.$status.'</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="'.site_url('/').'admin/update_post/'.$row->post_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:29%">'.substr(strip_tags($row->body),0,80).'</td>
						<td style="width:15%">'.$acc['title'].'</td>
						<td style="width:10%">'.substr(strip_tags($row->metaD),0,80).'</td>
						<th style="width:5%;font-weight:normal">'.date('M d Y',strtotime($row->datetime)).'</th>
						<td style="width:15%;text-align:right">
						<a title="Edit Post" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_post/'.$row->post_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Post" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_post('.$row->post_id.')">
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
			 		<h3>No Posts added</h3>
					No posts have been added. to add a new post please click on the add post button on the right</div>';
		  
		 }
		  
		  
				
				
		
	}
	//+++++++++++++++++++++++++++
	//GET POST DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_post($post_id){
			
		$test = $this->db->where('post_id', $post_id);
		$test = $this->db->get('posts');
		return $test->row_array();	

	}
	//+++++++++++++++++++++++++++
	//LIST GALLERIES FOR NAV
	//++++++++++++++++++++++++++		 
		 
	function get_galleries_nav(){
			
		$test = $this->db->get('galleries');
		
		if($test->result()){
			echo '<li>
                    <a class="dropmenu" href="#"><span class="hidden-tablet"> List Galleries<i class="icon-chevron-right"></i></span></a>
                     <ul>';
			foreach($test->result() as $row){
				
				echo '<li><a class="submenu" href="'.site_url('/').'admin/update_gallery/'.$row->gal_id.'/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> '.$row->title.'</span></a></li>';	
			}
			
			echo '</ul>	
              </li>';
		}

	}
	//+++++++++++++++++++++++++++
	//LIST PAGES FOR NAV
	//++++++++++++++++++++++++++		 
		 
	function get_pages_nav(){
			
		$test = $this->db->get('pages');
		
		if($test->result()){
			echo '<li>
                    <a class="dropmenu" href="#"><span class="hidden-tablet"> List Pages<i class="icon-chevron-right"></i></span></a>
                     <ul>';
			foreach($test->result() as $row){
				
				echo '<li><a class="submenu" href="'.site_url('/').'admin/update_page/'.$row->page_id.'/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> '.$row->title.'</span></a></li>';	
			}
			
			echo '</ul>	
              </li>';
		}

	}
	//+++++++++++++++++++++++++++
	//GET POSTS FOR NAV
	//++++++++++++++++++++++++++		 
		 
	function get_posts_nav(){
			
		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('posts');
		
		if($test->result()){
			echo '<li>
                    <a class="dropmenu" href="#"><span class="hidden-tablet"> List Posts <i class="icon-chevron-right"></i></span></a>
                     <ul>';
			foreach($test->result() as $row){
				
				echo '<li><a class="submenu" href="'.site_url('/').'admin/update_post/'.$row->post_id.'/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> '.$row->title.'</span></a></li>';	
			}
			
			echo '</ul>	
              </li>';
		}

	}
	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{

		  $query = $this->db->get('categories');
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
	 //Get categories for sidebar
	function get_categories_current($post_id){
      	
		
		$test = $this->db->where('post_id', $post_id);
		$test = $this->db->get('post_cat_int');
		if($test->result()){
			
			foreach($test->result() as $row){
				
				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category('.$row->id.')"><i class="icon-remove icon-white"></i> '.$row->cat_name.'</span>';
				
			}
				
			
		}else{
			
			echo '<div class="alert"> No Categories added</div>';
			
		}
		
			  
    }	
	
	//Get Main Categories Typehead
	function load_category_typehead(){
		
		$test = $this->db->get('categories');
		
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
	
	
	 //Get Main Categories
	function get_categories(){

		$test = $this->db->get('categories');
		return $test;	  
    }		 	
   		
    //GEt Current Categories
	function get_current_categories($post_id){

		$test = $this->db->where('BUSINESS_ID', $post_id);
		$test = $this->db->get('i_tourism_category');
		return $test;
				  
    }
	
	
	//+++++++++++++++++++++++++++
	//ADD New Account
	//++++++++++++++++++++++++++	
	function add_account_do()
	{
			$title = $this->input->post('title', TRUE);
			$description = $this->input->post('metaD', TRUE);
			$cemail = $this->input->post('contact_email', TRUE);
			$ga_id = $this->input->post('ga_id', TRUE);
			$ga_email = $this->input->post('ga_email', TRUE);
			$ga_pass = $this->input->post('ga_pass', TRUE);
			$id = $this->input->post('set_id', TRUE);
			$url = prep_url($this->input->post('url', TRUE));
			$email = $this->input->post('acc_email', TRUE);
			$bus_id = $this->input->post('bus_id', TRUE);
			$pass = $this->input->post('acc_pass', TRUE);

			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Website title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif(strip_tags($description) == ''){
				$val = FALSE;
				$error = 'Website description or tagline Required';	
							
			}else{
				$val = TRUE;
			}
			
			$insertdata = array(
							  'title'=> $title ,
							  'GA_profile'=> $ga_id,
							  'GA_pass'=> $ga_pass ,
							  'GA_email'=> $ga_email ,
							  'contact_email'=> $cemail ,
							  'description'=> $description,
							  'url'=> $url
							  
				);
			
	
			
			if($val == TRUE){
				
					$this->db->where('set_id' , $id);
					$this->db->update('settings', $insertdata);
					//success redirect	
					//LOG
					$this->super_admin_model->system_log('update_settings-'. $id);
					$data['basicmsg'] = 'Settings have been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	//+++++++++++++++++++++++++++
	//GET ALL USERS
	//++++++++++++++++++++++++++
	public function get_all_users()
	{

		  $query = $this->db->get('admin');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:15%;font-weight:normal">Name </th>
           				<th style="width:20%;font-weight:normal">Email </th>
						<th style="width:25%;font-weight:normal">Account </th>
						<th style="width:10%;font-weight:normal">Type </th>
						<th style="width:10%;font-weight:normal">Created </th>
						<th style="width:10%;font-weight:normal">Last Login </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$type = '<div class="label">admin</div>';
				if($row->type == 'editor'){
					
					$type = '<div class="label label-important">editor</div>';
					
				}elseif($row->type == 'super'){
					
					$type = '<div class="label label-danger">superuser</div>';
				}
				
				$acc = $this->get_account($row->bus_id);
				
				echo '<tr>
						<td style="width:15%">'.$row->fname. ' ' .$row->sname.'</td>
						<td style="width:20%">' .$row->email.'</td>
						<td style="width:25%">' .$acc['title'].'</td>
						<td style="width:10%">' .$type.'</td>
						<td style="width:10%">' .date('Y-m-D',strtotime($row->startdate)).'</td>
						<td style="width:10%">' .date('Y-m-D',strtotime($row->last_login)).'</td>
            			<td style="width:10%;text-align:right">
						<a title="Edit User" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="update_sys_user('.$row->admin_id.')"><i class="icon-pencil"></i></a>
						<a title="Delete User" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_user('.$row->admin_id.')">
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
			 		<h3>No Users added</h3>
					No users have been added. to add a new user please click on the add user button on the right</div>';
		  
		 }
			
		
	}
	
	//+++++++++++++++++++++++++++
	//GET SETTINGS
	//++++++++++++++++++++++++++		 
		 
	function get_settings(){
		
		$test = $this->db->get('settings');
		return $test->row_array();	

	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//DISPLAY NOTIFICATION
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function notify_msg(){
	    if($this->session->flashdata('msg')){
			echo "<script>var options = {'text':'".$this->session->flashdata('msg')."','layout':'bottomLeft','type':'success'};
				  noty(options);</script>";	
		}
		if($this->session->flashdata('error')){
			echo "<script>var options = {'text':'".$this->session->flashdata('error')."','layout':'bottomLeft','type':'error'};
				  noty(options);</script>";	
		}
		if($this->session->flashdata('notice')){
			echo "<script>var options = {'text':'".$this->session->flashdata('error')."','layout':'bottomLeft','type':'alert'};
				  noty(options);</script>";	
		}
	}


    //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//INSERT SYSTEM LOG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function system_log($type){
	        
		  //INSERT INTO LOG TABLE
		$logdata = array(
						'admin_id'=> $this->session->userdata('admin_id'),
						'name'=> $this->session->userdata('u_name') ,
						'bus_id'=> $this->session->userdata('bus_id') ,
						'TYPE'=> $type
		  );
		$this->db->insert('admin_log', $logdata);
	}

 

	//+++++++++++++++++++++++++++
	//GET DASHBOARD NAVIGATION
	//++++++++++++++++++++++++++		 
		 
	function get_dashboard_navigation(){
		
		
		$users = $this->db->count_all_results('admin');
		
		
		$pages = $this->db->count_all_results('pages');
		
		
		$posts = $this->db->count_all_results('posts');

		
		$cats = $this->db->count_all_results('categories');

		
		$imgs = $this->db->count_all_results('images');
		
	
		$enq = $this->db->count_all_results('enquiries');
		
		echo '<a href="'.site_url('/').'super_admin/users/" class="quick-button span2">
					<i class="fa-icon-group"></i>
					<p>Users</p>
					<span class="notification">'.$users.'</span>
				</a>
				<a href="'.site_url('/').'super_admin/pages/" class="quick-button span2">
					<i class="fa-icon-file"></i>
					<p>Pages</p>
					<span class="notification">'.$pages.'</span>
				</a>
				<a href="'.site_url('/').'super_admin/posts/" class="quick-button span2">
					<i class="fa-icon-copy"></i>
					<p>Posts</p>
					<span class="notification">'.$posts.'</span>
				</a>
				<a href="'.site_url('/').'super_admin/categories/" class="quick-button span2">
					<i class="fa-icon-folder-open"></i>
					<p>Categories</p>
					<span class="notification">'.$cats.'</span>
				</a>
				<a href="'.site_url('/').'super_admin/enquiries/" class="quick-button span2">
					<i class="fa-icon-envelope"></i>
					<p>Messages</p>
					<span class="notification">'.$enq.'</span>
				</a>
				<a href="'.site_url('/').'super_admin/images/" class="quick-button span2">
					<i class="fa-icon-picture"></i>
					<p>Images</p>
					<span class="notification">'.$imgs.'</span>
				</a>';	

	}



	//+++++++++++++++++++++++++++
	//GET MAIN NAVIGATION FROM CONFIG
	//++++++++++++++++++++++++++		 
		 
	function get_main_nav(){
		
		$config = $this->db->get('config');
		
		if($config->result()){
			
			$row = $config->row_array();
			$components = explode(",",$row['components']);
		    foreach($components as $comps){
				
				if($comps == 'projects'){
				
					echo '<li><a href="'.site_url('/').'admin/projects/"><i class="fa-icon-book icon-white"></i><span class="hidden-tablet"> Projects</span></a></li>';	
					
				}
				if($comps == 'email'){
				
					echo '<li><a href="'. site_url('/').'admin/email_marketing/"><i class="fa-icon-envelope icon-white"></i><span class="hidden-tablet"> Email Marketing</span></a></li>
                          <li><a href="'. site_url('/').'admin/members/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Members</span></a></li>';	
					
				}	
				
			}
		}
		
		

	}


	//+++++++++++++++++++++++++++
	//GET LANGUAGE PAGES FOR EDIT
	//++++++++++++++++++++++++++		 
		 
	function get_language_pages($settings, $page_id){
		
		$set = str_getcsv($settings, ",");
		
		if(count($set) > 0){

					
			foreach($set as $row){
				
				
					//GERMAN
					if (strpos($row,'german') !== false) {
						
						$this->db->where('page_id', $page_id);
						$query = $this->db->get('pages_german');

									$row = $query->row_array();
									$data['titleD'] = $row['title'];
									$data['headingD'] = $row['heading'];
									$data['bodyD'] = $row['body'];
									$data['slugD'] = $row['slug'];
									$data['metaDD'] = $row['metaD'];
									$data['mateTD'] = $row['metaT'];
									$data['language'] = 'german';
									
									$this->load->view('admin/pages/inc/languages', $data);

						
					}
						
					
			}
			
			
		}else{
			
			
			
		}

		
	
				
	}

	//+++++++++++++++++++++++++++
	//GET DASHBOARD SYSTEM LOGS
	//++++++++++++++++++++++++++		 
		 
	function get_system_logs(){
		

		$this->db->order_by('datetime', 'DESC');
		$this->db->limit('10');
		$query = $this->db->get('admin_log');
		echo '<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>System Log</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">';
							if($query->result()){
								
								echo  '<ul class="tickets">';
								foreach($query->result() as $row){
									
									echo substr($row->type,0,strpos('-',0,$row->type));
								
									
									echo '<li class="ticket">
											<a href="#">
												<span class="header">
													<span class="title">'.substr($row->type,0,strpos($row->type,'-',0)).'</span>
													<span class="number">[ #'.$row->log_id.' ]</span>
												</span>	
												<span class="content">
													
													<span class="name">'.$row->name.'</span>
													
													<span class="date">'.date('jS \of F Y h:i:s A',strtotime($row->datetime)).'</span>
												</span>	                                                        
											</a>
										</li>';
									
								}
								echo '</ul>';
							}
					
						echo '
					</div>
				</div><!--/span-->';			

	}



	//+++++++++++++++++++++++++++
	//GET ALL PENQUIRIES
	//++++++++++++++++++++++++++
	public function get_all_enquiries()
	{

		  $query = $this->db->order_by('datetime', 'DESC');
		  $query = $this->db->get('enquiries');
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
           				<th style="width:20%;font-weight:normal">From</th>
						<th style="width:40%;font-weight:normal">Body </th>
						<th style="width:15%;font-weight:normal">Account </th>
						<th style="width:15%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				$acc = $this->get_account($row->bus_id);
				echo '<tr>
						<td style="width:2%"></td>
						<td style="width:20%">'.$row->name.'<br /><font style="font-size:10px;">'.$row->email.'</font></td>
						<td style="width:40%">'.strip_tags(substr($row->body,0,80)).'</td>
						<td style="width:15%;">'.$acc['title'].'</td>
						<td style="width:15%">'.date("m-d-y g:i a",strtotime($row->datetime)).'</td>
						<td style="width:10%;text-align:right">
						<a title="View Enquiry" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						onclick="view_enquiry('.$row->enq_id.')"><i class="icon-zoom-in"></i></a>
						<a title="Delete Enquiry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_enquiry('.$row->enq_id.')">
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
			 		<h3>No Enquiries Found</h3>
					No penquiries have been made. Once the contact form has been used it will show the enquiry here</div>';
		  
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
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+eNcryption Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	/*Hash password*/
	
	function hash_password($username, $password){
		
		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . $this->config->item('encryption_key') . strtolower($username));
		
		// Prefix the password with the salt
		$hash = $salt . $password;
		
		// Hash the salted password a bunch of times
		for ( $i = 0; $i < 100000; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}
		
		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;
		return $hash;
		
	}
	

	/*Validate password*/
	
	function validate_password($username, $password){
			
		 
		$sql = $this->db->query("SELECT *
			  					FROM `admin`
								WHERE bus_id = '0' AND 
				  			   `email` = '".$username."' LIMIT 1",TRUE);
		
		$res = array();	 
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){
				
			$r = $sql->row_array();
			//Store value for return
			$res['fname'] = $r['fname'];
			$res['admin_id'] = $r['admin_id'];
			$res['img_file'] = $r['img_file'];
			$res['last_login'] = $r['last_login'];
			$res['bus_id'] = $r['bus_id'];
			// The first 64 characters of the hash is the salt
			$salt = substr($r['pass'], 0, 64);
			
			$hash = $salt . $password;
			
			// Hash the password as we did before
			for ( $i = 0; $i < 100000; $i ++ ) {
			  $hash = hash('sha256', $hash);
			}
			
			$hash = $salt . $hash;
			
			if ( $hash == $r['pass'] ) {
			  
			   $res['bool'] = TRUE;
			   //break;
			}else{
			  
			   $res['bool'] = FALSE;
				
			}
		}else{//no username match
			
			$res['bool'] = FALSE;
		}

		return $res;
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	
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