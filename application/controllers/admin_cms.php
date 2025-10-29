<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_cms extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Admin_cms()
	{
		parent::__construct();
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model(array('admin_model_multi','google_model'));
	}
	
	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function index()
	{
		redirect(site_url('/').'admin_cms/home','refresh');	
	}
	
	public function home()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/home_multi');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	
	public function ajax_load_home()
	{
		$this->google_model->load_overview();
		
	}
	public function ajax_load_home2()
	{
		 $this->google_model->traffic_graph();
			
		 $this->google_model->organic_keywords();
		
	}
	public function ajax_load_calendar()
	{
		$this->load->model('calendar_model_multi');
		$this->load->view('admin/inc/calendar_inc_multi');
		
	}
	//+++++++++++++++++++++++++++
	//MEMBERS
	//++++++++++++++++++++++++++

	public function members()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('members_model_multi');
			$this->load->view('admin/members/members');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	//DELETE IMAGE
	function delete_member($mem_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('member_id', $mem_id);
			  $this->db->delete('members');
			  //LOG
			  $this->admin_model_multi->system_log('delete_member-'.$mem_id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin_cms/members/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin_cms/logout/','refresh');
				
		}
    }
	//+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++

	public function update_member($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('members_model_multi');
			$gallery = $this->members_model_multi->get_member($mem_id);
			$this->load->view('admin/members/update_member', $gallery);
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new MEMEBR
	//++++++++++++++++++++++++++

	public function add_member()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/members/add_member');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD MEMBER
	//++++++++++++++++++++++++++	
	function add_member_do()
	{
		$this->load->model('members_model_multi');
		$this->members_model_multi->add_member_do();
	}
	//+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++	
	function update_member_do()
	{
		$this->load->model('members_model_multi');
		$this->members_model_multi-> update_member_do();
	}
	//+++++++++++++++++++++++++++
	//IMAGES/GALLERIES
	//++++++++++++++++++++++++++

	public function images()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/images/images');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	
	//DELETE IMAGE
	function delete_image($img_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('img_id', $img_id);
			  $this->db->delete('images');
			  //LOG
			  $this->admin_model_multi->system_log('delete_image-'.$img_id);
			  $this->session->set_flashdata('msg','Image deleted successfully');
			  echo '<script type="text/javascript">
				  
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin_cms/logout/','refresh');
				
		}
    }
	

	public function galleries()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/images/galleries');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//add new gallery
	//++++++++++++++++++++++++++

	public function add_gallery()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/images/add_gallery');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD GALLERY DO
	//++++++++++++++++++++++++++	
	function add_gallery_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$style = $this->input->post('style', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			
			//$id = $this->input->post('page_id', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Gallery title Required';
					
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
								  'description'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT, 
								  'style'=> $style, 
								  'slug'=> $slug
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('galleries', $insertdata);
					//LOG
					$this->admin_model_multi->system_log('add_new_gallery-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Gallery added successfully');
					$data['basicmsg'] = 'Gallery has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin_cms/galleries/";
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
	//add new project
	//++++++++++++++++++++++++++

	public function update_gallery($gal_id)
	{
		if($this->session->userdata('admin_id')){
			
			$gallery = $this->admin_model_multi->get_gallery($gal_id);
			$this->load->view('admin/images/update_gallery', $gallery);
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE GALLERY
	//++++++++++++++++++++++++++	
	function update_gallery_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);

			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('gallery_id', TRUE);
			$style = $this->input->post('style', TRUE);
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Gallery title Required';
					
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
								  'title'=> $title ,
								  'description'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT, 
								  'style'=> $style, 
								  'slug'=> $slug
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('gal_id' , $id);
					$this->db->update('galleries', $insertdata);
					//success redirect	
					$data['gallery_id'] = $id;
					
					//LOG
					$this->admin_model_multi->system_log('update_gallery-'. $id);
					$data['basicmsg'] = 'Gallery has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	
	//+++++++++++++++++++++++++++
	//UPDATE SIDEBAR
	//++++++++++++++++++++++++++

	public function update_sidebar($ctype, $cid, $stype, $sid )
	{
		if($this->session->userdata('admin_id')){
			
			//DELETE OLD RECORDS
			$this->db->where($ctype.'_id', $cid);
			$this->db->where('type', $stype.'_'.$cid);
			$this->db->delete('sidebars');
			
			//insert new 
			$data[$ctype.'_id'] = $cid;
			$data['type'] = $stype.'_'.$sid;
			
			$this->db->insert('sidebars',$data);
			
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//REMOVE GALLERY SIDEBAR
	//++++++++++++++++++++++++++

	public function remove_sidebar($ctype, $cid, $stype, $sid)
	{
		if($this->session->userdata('admin_id')){
			
			//DELETE OLD RECORDS
			$this->db->where($ctype.'_id', $cid);
			$this->db->where('type', $stype.'_'.$sid);
			$this->db->delete('sidebars');
			
			$this->admin_model_multi->get_sidebar_content($ctype.'_'.$cid);
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	
	
	//+++++++++++++++++++++++++++
	//PROJECTS
	//++++++++++++++++++++++++++

	public function projects()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/projects/projects');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//add new project
	//++++++++++++++++++++++++++

	public function add_project()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/projects/add_project');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new project
	//++++++++++++++++++++++++++

	public function update_project($project_id)
	{
		if($this->session->userdata('admin_id')){
			
			$project = $this->admin_model_multi->get_project($project_id);
			$this->load->view('admin/projects/update_project', $project);
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//load_documents
	//++++++++++++++++++++++++++

	public function load_documents($project_id)
	{
		
		$this->admin_model_multi->get_project_docs($project_id);
		
				
	}
	
	//+++++++++++++++++++++++++++
	//delete document
	//++++++++++++++++++++++++++

	public function delete_document($doc_id)
	{
		$this->db->where('doc_id', $doc_id);
		$query = $this->db->get('project_documents');
		
		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/documents/' . $row['doc_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('doc_id', $doc_id);
			$this->db->delete('project_documents');
			$this->session->set_flashdata('msg','Document removed successfully');		
			
		}
			
	}

	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document($doc_id)
	{
		$this->db->where('doc_id', $doc_id);
		$query = $this->db->get('project_documents');
		
		if($query->result()){
			$row = $query->row_array();
			
			echo '<div class="row-fluid">
					<form id="document-update" name="document-update" method="post" action="'. site_url('/').'admin_cms/update_document_do" >
                       <fieldset>
                        <input type="hidden" id="update_doc_id" name="update_doc_id" value="'.$doc_id.'" />
                        <div class="control-group">
                              <label class="control-label" for="doc_title">Title</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="doc_title" name="doc_title" placeholder="Document title eg: Appendix A" value="'.$row['title'].'">
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="doc_name">Name</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="doc_name" name="doc_name" placeholder="Document name" value="'.$row['description'].'">
                              </div>
                        </div>
						<input type="submit" id="update_doc_but" value="Update Document" class="btn btn-primary pull-right" />
                      </fieldset>
                  </form>
				</div>
				<script type="text/javascript">
					$("#update_doc_but").click(function(e){
						  
						  e.preventDefault();	
						  
						  var frm = $("#document-update");
						  
						  $.ajax({
							cache: false,
							url: "'. site_url("/").'admin_cms/update_document_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {
							  
							  load_documents();
							  $("#modal-doc-update").modal("hide");
							  
							}
						  });
		
					});
				
				</script>
				
				';	
			
		}
			
	}
	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		$this->admin_model_multi->update_document_do();
			
	}				       
	//+++++++++++++++++++++++++++
	//ADD PROJECT DO
	//++++++++++++++++++++++++++	
	function add_project_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Project title Required';
					
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
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'review'=> date('Y-m-d h:i:s',strtotime($pubdate)),
								  'slug'=> $slug
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('projects', $insertdata);
					//LOG
					$this->admin_model_multi->system_log('add_new_project-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Project added successfully');
					$data['basicmsg'] = 'Project has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin_cms/projects/";
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
	//UPDATE PROJECT
	//++++++++++++++++++++++++++	
	function update_project_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$status = $this->input->post('status', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('project_id', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Project title Required';
					
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
								  'title'=> $title ,
								  'status'=> strtolower($status),
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'review'=> date('Y-m-d h:i:s',strtotime($pubdate)),
								  'slug'=> $slug 
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('project_id' , $id);
					$this->db->update('projects', $insertdata);
					//success redirect	
					$data['project_id'] = $id;
					
					//LOG
					$this->admin_model_multi->system_log('update_project-'. $id);
					$data['basicmsg'] = 'Project has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	//DELETE PROJECT
	function delete_project($project_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('project_id', $project_id);
			  $this->db->delete('projects');
			  //LOG
			  $this->admin_model_multi->system_log('delete_project-'.$project_id);
			  $this->session->set_flashdata('msg','Project deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin_cms/projects/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin_cms/logout/','refresh');
				
		}
    }
	

	
	 //+++++++++++++++++++++++++++
	//upload project docs 
	//++++++++++++++++++++++++++
	
	function add_project_docs()
	{
		
		$this->admin_model_multi->add_project_docs();
		
	}
	
	
	//+++++++++++++++++++++++++++
	//upload gallery images
	//++++++++++++++++++++++++++
	
	function add_gallery_images()
	{
		
		$this->admin_model_multi->add_gallery_images();
		
	}
	
	//+++++++++++++++++++++++++++
	//load gallery images For sidebars
	//++++++++++++++++++++++++++
	
	function load_gallery_images($gal_id)
	{
		
		$this->admin_model_multi->load_gallery_images($gal_id);
		
	}
	
	//+++++++++++++++++++++++++++
	//load gallery images
	//++++++++++++++++++++++++++
	
	function load_gallery_images_update($gal_id)
	{
		
		$this->admin_model_multi->load_gallery_images_update($gal_id);
		
	}
	//+++++++++++++++++++++++++++
	//PAGES
	//++++++++++++++++++++++++++

	public function pages()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/pages/pages');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//add new page
	//++++++++++++++++++++++++++

	public function add_page()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/pages/add_page');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new page
	//++++++++++++++++++++++++++

	public function update_page($page_id)
	{
		if($this->session->userdata('admin_id')){
			
			$page = $this->admin_model_multi->get_page($page_id);
			$this->load->view('admin/pages/update_page', $page);
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD PAGE DO
	//++++++++++++++++++++++++++	
	function add_page_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($body == ''){
				$val = FALSE;
				$error = 'Page Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('pages', $insertdata);
					//LOG
					$this->admin_model_multi->system_log('add_new_page-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Page added successfully');
					$data['basicmsg'] = 'Page has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin_cms/pages/";
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
	//UPDATE PAGE
	//++++++++++++++++++++++++++	
	function update_page_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$status = $this->input->post('status', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('page_id', TRUE);

			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
					
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
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug 
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('page_id' , $id);
					$this->db->update('pages', $insertdata);
					//success redirect	
					$data['page_id'] = $id;
					
					//LOG
					$this->admin_model_multi->system_log('update_page-'. $id);
					$data['basicmsg'] = 'Page has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	//DELETE PAGE
	function delete_page($page_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('page_id', $page_id);
			  $this->db->delete('pages');
			  //LOG
			  $this->admin_model_multi->system_log('delete_page-'.$page_id);
			  $this->session->set_flashdata('msg','Page deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin_cms/pages/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin_cms/logout/','refresh');
				
		}
    }
	//+++++++++++++++++++++++++++
	//COMMENTS
	//++++++++++++++++++++++++++

	public function comments()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/posts/comments');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	//DELETE COMMENT
	function delete_comment($id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $this->db->where('com_id', $id);
			  $this->db->delete('comments');
			  //LOG
			  $this->admin_model_multi->system_log('delete_comment-'.$id);
			  $this->session->set_flashdata('msg','Comment deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin_cms/comments/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin_cms/logout/','refresh');
				
		}
    }
	//VIEW COMMENT
	function view_comment($id){

			  $this->db->where('com_id', $id);
			  $query = $this->db->get('comments');
			  
			  if($query->result()){
				  
					$row = $query->row();
					echo '<div class="well">'.$row->body.'<br /><br /><span style="font-size:10px">'.$row->name.'</span></div>';  
				  
			  }
						
	
    }
	//MODERATE COMMENT
	function update_comment_status($id, $status){

		if($this->session->userdata('admin_id')){
			
			  $data['status'] = $status;	
		 	  $this->db->where('com_id', $id);
			  $query = $this->db->update('comments', $data);
			  $this->session->set_flashdata('msg','Comment updated successfully');
					
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin_cms/comments/";
				  </script>';
			 
		}else{
			
			redirect(site_url('/').'admin_cms/logout/','refresh');
				
		} 
			 
						
	
    }
		
	//+++++++++++++++++++++++++++
	//POSTS
	//++++++++++++++++++++++++++

	public function posts()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/posts/posts');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//add new post
	//++++++++++++++++++++++++++

	public function add_post()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/posts/add_post');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//update post
	//++++++++++++++++++++++++++

	public function update_post($post_id)
	{
		if($this->session->userdata('admin_id')){
			
			$post = $this->admin_model_multi->get_post($post_id);
			$this->load->view('admin/posts/update_post', $post);
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}

	
	//+++++++++++++++++++++++++++
	//ADD POST DO
	//++++++++++++++++++++++++++	
	function add_post_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = htmlentities($this->input->post('content', FALSE));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Post title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($body == ''){
				$val = FALSE;
				$error = 'Post Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'datetime'=> date('Y-m-d H:i:s'),
								  'slug'=> $slug
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('posts', $insertdata);
					//LOG
					$this->admin_model_multi->system_log('add_new_post-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Post added successfully');
					$data['basicmsg'] = 'Post has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin_cms/posts/";
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
	//UPDATE PAGE
	//++++++++++++++++++++++++++	
	function update_post_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$status = $this->input->post('status', TRUE);
			$comments = $this->input->post('comments', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('post_id', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);

			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Post title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Post Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
								  'title'=> $title ,
								  'status'=> strtolower($status),
								  'comments'=> strtolower($comments),
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'datetime  '=> date('Y-m-d h:i:s',strtotime($pubdate)),
								  'slug'=> $slug 
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('post_id' , $id);
					$this->db->update('posts', $insertdata);
					//success redirect	
					
					//LOG
					$this->admin_model_multi->system_log('update_post-'. $id);
					$data['basicmsg'] = 'Post has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	//DELETE PAGE
	function delete_post($post_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('post_id', $post_id);
			  $this->db->delete('posts');
			  //LOG
			  $this->admin_model_multi->system_log('delete_post-'.$post_id);
			  $this->session->set_flashdata('msg','Post deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin_cms/posts/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin_cms/logout/','refresh');
				
		}
    }
	
	public function home2()
	{

		$this->load->library('ga_api');

		// Set new profile id if not the default id within your config document
		$this->ga = $this->ga_api->login()->init(array('profile_id' => $this->session->userdata('GA_profile')));
		
		// Query Google metrics and dimensions
		// Documentation: http://code.google.com/apis/analytics/docs/gdata/dimsmets/dimsmets.html)
		$data = $this->ga_api->login()
			->dimension('date')
			->metric('visitors, visits')
			->when('1 month ago', 'yesterday')
			->get_array();
		
		// Also please note, if you using default values you still need to init()

   		// Also please note, if you using default values you still need to init()
		$c = 0;$x = 0;
		foreach($data as $key => $value){
				   if($key != 'summary'){	
						$comma = ',';
								 
						if($c == 29){
							$comma = '';
						 }
							   
						 $final = $value['visitors'];
						
						 echo '['.$c.', ' .$final. ']'.$comma;
						 $c ++;
				   }
				}
		echo 'TOTAL: ' .$x .' Total records: '.$c;
		var_dump($data);
	}
	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login()
	{
			
			$email = $this->input->post('email', TRUE);
			$pass = $this->input->post('pass', TRUE);
			$sess = $this->input->post('rememberme', TRUE);
			$redirect = $this->input->post('redirect', TRUE);
			
			//MATCH CREDENTIALS
			$row = $this->admin_model_multi->validate_password($email,$pass);
			if($row['bool'] == TRUE){
					
					//HASH PASSWORD AGAIN
					$pass_new = $this->admin_model_multi->hash_password($email,$pass);
					//create user array
					 $data = array(
					  /* 'user_agent' => $this->agent->browser() . ' ver ' . $this->agent->version(),*/
					   'last_login' => date("Y-m-d H:i:s"),
					   'pass' => $pass_new
					);
					
					if ($sess == TRUE) {
					//$this->session->cookie_monster();	
					}
					//GET SETTINGS
					$this->db->select('GA_profile, GA_pass, GA_email');
					$this->db->from('settings');
					$query = $this->db->get();
					$settings = $query->row_array();

					$this->session->set_userdata('admin_id', $row['admin_id']);
					$this->session->set_userdata('bus_id', $row['bus_id']);
					$this->session->set_userdata('u_name', $row['fname']);
					$this->session->set_userdata('last_login', $row['last_login']);
					$this->session->set_userdata('GA_profile', $settings['GA_profile']);
					$this->session->set_userdata('GA_email',  $settings['GA_email']);
					$this->session->set_userdata('GA_pass', $settings['GA_pass']);
					$this->session->set_userdata('img_file', $row['img_file']);
					$this->db->where('admin_id', $row['admin_id']);
					$this->db->update('admin', $data);
					
					//LOG
					$this->admin_model_multi->system_log('system_log_in-'. $row['fname']) ;
					//--------------
					//Redirect
					if($this->input->post('redirect')){
						
						redirect($redirect, 'refresh');
						
					}else{
						
						$this->session->set_flashdata('msg', 'Logged in successful. Last login was on ' .date('l jS \of F Y h:i:s A',strtotime($row['last_login'])));
						redirect(site_url('/').'admin_cms/home/', 'refresh');	
						
					}
				
				
			//NO MATCHING CREDENTIALS
			}else{
			
				$data['error'] = 'No matching records found!';
				//echo $this->encode($pass) .' ' ;
				$this->load->view('admin/login_multi' , $data);
			
			}
				
	}


	function logout(){

		$this->session->sess_destroy();  
		redirect(site_url('/'),'refresh');

	}


	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//BACKBONE AJAX CALLS
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++	
 */	
	//GET USERS	
	function get_pages(){

		$this->admin_model_multi->get_pages();
	

	}	
	
	
	
	
	
	//+++++++++++++++++++++++++++
	//ADD CATEGORY AND INTERSECTION FOR POST
	//++++++++++++++++++++++++++

	public function add_category_do()
	{
		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$post_id = $this->input->post('post_id_cat');	
		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$result1 = $this->db->get('categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('categories', $data);	
		}
		//GET NEW CAT ID
		$this->db->where('cat_name', $data['cat_name']);
		$result = $this->db->get('categories');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('post_id', $post_id);
		$result = $this->db->get('post_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['cat_id'] = $row['cat_id'];
			$data2['post_id'] = $post_id;	
			$data2['cat_name'] = $data['cat_name'];
			$this->db->insert('post_cat_int', $data2);	
		}
		
	}
	//+++++++++++++++++++++++++++
	//ADD CATEGORY GENERLA
	//++++++++++++++++++++++++++

	public function add_category_do_general()
	{
		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$post_id = $this->input->post('post_id_cat');	
		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$result1 = $this->db->get('categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('categories', $data);	
		}
		//GET NEW CAT ID
		$this->db->where('cat_name', $data['cat_name']);
		$result = $this->db->get('categories');
		$row = $result->row_array();

		
	}
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->admin_model_multi->get_all_categories();
		
	}
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY
	//++++++++++++++++++++++++++

	public function reload_category($post_id)
	{
		$this->admin_model_multi->get_categories_current($post_id);
		
	}
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY INTERSECTION
	//++++++++++++++++++++++++++

	public function delete_category($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('post_cat_int');
		
	}
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY MAIN
	//++++++++++++++++++++++++++

	public function delete_category_main($id)
	{
		$this->db->where('cat_id', $id);
		$this->db->delete('categories');
		
	}
	//+++++++++++++++++++++++++++
	//Load CATEGORIES
	//++++++++++++++++++++++++++

	public function categories()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/categories');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
	}
	
	
	 //+++++++++++++++++++++++++++
	//Load USERS
	//++++++++++++++++++++++++++

	public function users()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/users');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
	}
	//GET USER
	function get_sys_user($id){

		$this->db->where('admin_id', $id);
		$query = $this->db->get('admin');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<form id="user-update" name="user-update" method="post" action="'.site_url('/').'admin_cms/update_sys_user_do" class="form-horizontal">
    						<input type="hidden" id="user_id" name="user_id" value="'.$row['admin_id'].'">  
							<div class="control-group">
								  <label class="control-label" for="uname">First Name</label>
								<div class="controls">
								   <input type="text" id="uname" name="uname" placeholder="First Name" value="'.$row['fname'].'">                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="sname">Surname</label>
								<div class="controls">
								   <input type="text" id="sname" name="sname" placeholder="Surname" value="'.$row['sname'].'">                    
								</div>
							 </div>
							  <div class="control-group">
								  <label class="control-label" for="uposition">User Rights</label>
								<div class="controls">
									<select name="uposition" id="uposition">
									  <option value="editor">Editor</option>
									  <option value="admin">Admin</option>
									 
									</select>                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uemail">User Email</label>
								<div class="controls">
								   <input type="text" id="uemail" name="uemail" placeholder="User Email" value="'.$row['email'].'">                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uuserpass">User Password</label>
								<div class="controls">
								   <input type="password" id="uuserpass" name="uuserpass" placeholder="User Password" value="">                    
								</div>
							 </div>  
							   
								
						</form>';
					

			}else{
					
				$this->session->set_flashdata('error', 'User not found');	
			}
	}
	
	
	//ADD	
	function add_sys_user_do(){
			
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$position = $this->input->post('position', TRUE);
			$pass = $this->input->post('userpass', TRUE);
			//TEST IF EXISTING
			$this->db->where('email', $email);
			$query = $this->db->get('admin');
			//EMAIL EXISTS
			if($query->result()){
				
				$this->session->set_flashdata('error', 'Email addres already in use');		

			}else{
					
				$insertdata = array(
								  'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position,
								  
								  'pass'=> $this->admin_model_multi->hash_password($email,$pass)
					);
					$this->db->insert('admin',$insertdata);
					$this->session->set_flashdata('msg', 'Successfully added system user');	
			}
			


	}
	//UPDATE	
	function update_sys_user_do(){
			
			$email = $this->input->post('uemail', TRUE);
			$name = $this->input->post('uname', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$position = $this->input->post('uposition', TRUE);
			$pass = $this->input->post('uuserpass', TRUE);
			$id = $this->input->post('user_id', TRUE);
			
			if($pass == ''){
				
				$insertdata = array(
								   'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position
					);
				
				
				
			}else{
				
				$insertdata = array(
								   'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position,
								  
								  'pass'=> $this->admin_model_multi->hash_password($email,$pass)
					);
				
				
			}
			
			  $this->db->where('admin_id', $id);
			  $this->db->update('admin',$insertdata);
			  $this->session->set_flashdata('msg', 'Successfully updated system user');	
			


	}
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY INTERSECTION
	//++++++++++++++++++++++++++

	public function delete_user($id)
	{
		$this->db->where('admin_id', $id);
		$this->db->delete('admin');
		//LOG
		$this->admin_model_multi->system_log('delete-system-user'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted system user');	
	}
	
	//+++++++++++++++++++++++++++
	//SETTINGS
	//++++++++++++++++++++++++++

	public function settings()
	{
		if($this->session->userdata('admin_id')){
			
			$settings = $this->admin_model_multi->get_settings();
			$this->load->view('admin/settings', $settings);
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE SETTINGS
	//++++++++++++++++++++++++++	
	function update_settings_do()
	{
			$title = $this->input->post('title', TRUE);
			$description = $this->input->post('metaD', TRUE);
			$cemail = $this->input->post('contact_email', TRUE);
			$ga_id = $this->input->post('ga_id', TRUE);
			$ga_email = $this->input->post('ga_email', TRUE);
			$ga_pass = $this->input->post('ga_pass', TRUE);
			$id = $this->input->post('set_id', TRUE);
			

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
								  'description'=> $description
								  
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('set_id' , $id);
					$this->db->update('settings', $insertdata);
					//success redirect	
					$this->session->set_userdata('GA_profile', $ga_id);
					$this->session->set_userdata('GA_email',  $ga_email);
					$this->session->set_userdata('GA_pass',$ga_pass);
					//LOG
					$this->admin_model_multi->system_log('update_settings-'. $id);
					$data['basicmsg'] = 'Settings have been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	//+++++++++++++++++++++++++++
	//CONTACT FORM SUBMISSIONS
	//++++++++++++++++++++++++++

	public function enquiries()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/enquiries');
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//DELETE ENQUIRY
	//++++++++++++++++++++++++++

	public function delete_enquiry($id)
	{
		$this->db->where('enq_id', $id);
		$this->db->delete('enquiries');
		//LOG
		$this->admin_model_multi->system_log('delete-enquiry'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted the enquiry');	
	}
		//+++++++++++++++++++++++++++
	//DELETE ENQUIRY
	//++++++++++++++++++++++++++

	public function get_enquiry($id)
	{
		$this->db->where('enq_id', $id);
		$query = $this->db->get('enquiries');

			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<p>'.$row['name'].'</p>';
				echo '<p class="well">'.$row['body'].'</p>';	
				echo '<em>'.date('l jS \of F Y h:i:s A',strtotime($row['datetime'])).'</em>';
				
			}else{
					
				$this->session->set_flashdata('error', 'Enquiry not found');	
			}
	}
	
	
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING
	//++++++++++++++++++++++++++

	public function email_marketing()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('email_model');
			$this->load->view('admin/email_marketing', $gallery);
			
		}else{
			
			$this->load->view('admin/login_multi');
			
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING PREVIEW EMAIL
	//++++++++++++++++++++++++++

	public function preview_email()
	{
		
		$data['preview'] = 'true';
		$data['body'] = html_entity_decode($this->input->post('mailbody', TRUE));
		//$data['body'] = urldecode($body);
		
		$this->load->view('email/body_news', $data);	

	}	
	 
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING SEND EMAIL
	//++++++++++++++++++++++++++

	public function send_email()
	{
		
		$this->load->model('email_model');
		$this->email_model->send_email();
	}
	  
	//+++++++++++++++++++++++++++
	//ENCRYPRION FUNCTIONS
	//++++++++++++++++++++++++++
	
	public function encrypt()
	{
		//$str = str_replace('_-_','@',$str);
		$str = 'roland@my.na';
		$pass = '123';
		echo $this->admin_model_multi->hash_password($str,$pass);	
		
	}
	
	public function decrypt($str,$pass)
	{
		
		//echo $this->encrypt_model->hash_password($str,$pass);	
		
		$row = $this->admin_model_multi->validate_password($str,$pass);
		if($this->admin_model_multi->validate_password($str,$pass)){
			
			echo 'YES';
		
		}else{
			
			echo 'No';
			
		}
		
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

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */