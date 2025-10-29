<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Admin()
	{
		parent::__construct();
		error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model(array('admin_model','google_model'));
	}
	
	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function index()
	{
		redirect(site_url('/').'admin/home','refresh');	
	}
	
	//+++++++++++++++++++++++++++
	//MY NAMIBIA / HAN Update
	//++++++++++++++++++++++++++
	public function my_namibia()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$data = $this->my_namibia_model->get_info();
			$this->load->view('admin/my_namibia', $data);						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
	}

	
	//+++++++++++++++++++++++++++
	//MY NAMIBIA / HAN Update
	//++++++++++++++++++++++++++
	public function update_my_namibia_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$this->my_namibia_model->update_my_namibia_do();						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
	}
	//+++++++++++++++++++++++++++
	//MY NAMIBIA / HAN ADD LOGO
	//++++++++++++++++++++++++++
	public function add_logo_ajax()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('my_namibia_model');
			$this->my_namibia_model->add_logo_ajax();						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
	}
	
	
	public function home()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/home');
			
		}else{
			
			$this->load->view('admin/login');
			
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
		$this->load->model('calendar_model');
		$this->load->view('admin/inc/calendar_inc');
		
	}
	
	public function ajax_load_bookings()
	{
		$this->load->model('calendar_model');
		$this->load->view('admin/bookings/calendar_inc');
		
	}
	
	//+++++++++++++++++++++++++++
	//MENU BUILDER
	//++++++++++++++++++++++++++

	public function menu()
	{
		if($this->session->userdata('admin_id')){
			
			$bus_id = $this->session->userdata('bus_id');
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->get('menus');
			
			if($query->result()){
				
				$row = $query->row_array();
				$menu['menu'] = $row['menu'];
				
				
			}else{
				
				$menu['menu'] = ''; 
				
			}
			
			$this->load->view('admin/menu', $menu);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//SHOW MENU
	//++++++++++++++++++++++++++

	public function show_menu($menu)
	{
		
		$this->admin_model->show_menu($menu);
		
		
	}
			
	//+++++++++++++++++++++++++++
	//Updte Menu
	//++++++++++++++++++++++++++
	public function update_menu_do()
	{
		if($this->session->userdata('admin_id')){

			$this->admin_model->update_menu_do();						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
	}
			
	//+++++++++++++++++++++++++++
	//SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function subscribers()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('members_model');
			$type['type'] = 'subscribers'; 
			$this->load->view('admin/members/members', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//add new SUBSCRIBER
	//++++++++++++++++++++++++++

	public function add_subscribers()
	{
		if($this->session->userdata('admin_id')){
			$type['member_type'] = 'subscribers';
			$this->load->view('admin/members/add_member', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
		//DELETE IMAGE
	function delete_subscribers($mem_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('subscriber_id', $mem_id);
			  $this->db->delete('subscribers');
			  //LOG
			  $this->admin_model->system_log('delete_member-'.$mem_id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin/subscribers/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }
	//+++++++++++++++++++++++++++
	//UPDATE SUBSCRIBER
	//++++++++++++++++++++++++++

	public function update_subscribers($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('members_model');
			$member = $this->members_model->get_member($mem_id, 'subscribers');
			$member['member_type'] = 'subscribers';
			$this->load->view('admin/members/update_member', $member);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}	
	
	

	//+++++++++++++++++++++++++++
	//SLIDERS
	//++++++++++++++++++++++++++

	public function sliders()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/sliders/sliders');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//+++++++++++++++++++++++++++
	//update Slider sequence
	//++++++++++++++++++++++++++

	public function update_slider_sequence($slider_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('slider_id' , $slider_id);
			$this->db->update('sliders', $data);

		
	}
	//+++++++++++++++++++++++++++
	//GET ALL SLIDERS
	//++++++++++++++++++++++++++

	public function get_all_sliders()
	{
		$this->admin_model->get_all_sliders();
	}
	
	//+++++++++++++++++++++++++++
	//DELETE SLIDER
	//++++++++++++++++++++++++++

	public function delete_slider($id)
	{
		$this->db->where('slider_id', $id);
		$query = $this->db->get('sliders');
		

		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/images/' . $row['img_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('slider_id', $id);
			$this->db->delete('sliders');
			$this->session->set_flashdata('msg','Slider removed successfully');		
			
		}
			
	}
	//GET SLIDER
	function get_slider($id, $x){

		$this->db->where('slider_id', $id);
		$query = $this->db->get('sliders');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				if($row['status'] == 'draft'){
					
					$live = '';
					$draft = 'active';	
					
				}else{
					
					$live = 'active';
					$draft = '';	
				}
				
				echo '<form id="slider-update" name="slider-update" method="post" action="'.site_url('/').'admin/update_slider_do" class="form-horizontal">
    						<input type="hidden" id="slider_id_edit" name="slider_id_edit" value="'.$row['slider_id'].'">  
							<input type="hidden" name="status_edit" id="status_edit"  value="'. $row['status'].'">
							<div class="control-group">
								  <label class="control-label" for="title_edit">Slider Title</label>
								<div class="controls">
								   <input type="text" id="title_edit" name="title_edit" value="'.$row['title'].'">                    
								</div>
							</div>
							 <div class="control-group">
								  <label class="control-label" for="slide_link">Slider Link</label>
								<div class="controls">
								   <input type="text" id="slide_link" name="slide_link" placeholder="Slider Link" value="'.$row['slug'].'">                    
								</div>
							 </div>
						   <div class="control-group">
							  <label class="control-label" for="status">Status</label>
							  <div class="controls">
									  <div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">Draft</button>
										<button type="button" class="btn btn-primary '.$live.'">Live</button>
									  </div>
							  </div>
							</div>
							<div class="control-group">
                				<h5>Slider Text</h5>
                   				<textarea id="slider_edit" name="slider_edit">'.$row['body'].'</textarea>                    
                
            				</div> 
	
					</form>
					
					<script type="text/javascript">
					
									$("#slider_edit").redactor({ 	
											fileUpload: "'. site_url('/').'my_images/redactor_add_file/",
											imageGetJson: "'. site_url('/').'my_images/show_upload_images_json/",
											imageUpload: "'. site_url('/').'my_images/redactor_add_image",
											buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
											"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
											"video","file", "table","|",
											 "alignment", "|", "horizontalrule"]
									});
					
					</script>
					
					';
					

			}else{
					
				$this->session->set_flashdata('error', 'Slider not found');	
			}
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE
	//++++++++++++++++++++++++++	
	function update_slider_do(){
			
			$status = strtolower($this->input->post('status_edit', TRUE));
			$title = $this->input->post('title_edit', TRUE);
			$url = $this->input->post('slide_link', TRUE);
			$id = $this->input->post('slider_id_edit', TRUE);
			$slider = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('slider_edit', FALSE)));

							
			$insertdata = array(
							  'title'=> $title ,
							  'slug'=> $url ,
							  'body'=> $slider ,
							  'status'=> $status
				);

			$this->db->where('slider_id', $id);
			$this->db->update('sliders',$insertdata);
			$this->session->set_flashdata('msg', 'Successfully updated slider');	


	}
	
	//+++++++++++++++++++++++++++
	//TESTIMONIALS
	//++++++++++++++++++++++++++

	public function testimonials()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/testimonials/testimonials');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//GET TESTIMONIAL FOR EDIT
	function get_testimonial($id){

		$this->db->where('testimonial_id', $id);
		$query = $this->db->get('testimonials');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				if($row['status'] == 'draft'){
					
					$live = '';
					$draft = 'active';	
					
				}else{
					
					$live = 'active';
					$draft = '';	
				}
				
				echo '<form id="testimonial-update" name="testimonial-update" method="post" action="'.site_url('/').'admin/update_testimonial_do" class="form-horizontal">
    						<input type="hidden" id="testimonial_id_edit" name="testimonial_id_edit" value="'.$row['testimonial_id'].'">  
							<input type="hidden" name="status_edit" id="status_edit"  value="'. $row['status'].'">
							<div class="control-group">
								  <label class="control-label" for="title_edit">Testimonial Title</label>
								<div class="controls">
								   <input type="text" id="title_edit" name="title_edit" value="'.$row['title'].'">                    
								</div>
</div>
							 <div class="control-group">
								  <label class="control-label" for="name_edit">Testimonial Reference</label>
								<div class="controls">
								   <input type="text" id="name_edit" name="name_edit" placeholder="Testimonial Reference" value="'.$row['heading'].'">                    
								</div>
							 </div>
						   <div class="control-group">
							  <label class="control-label" for="status">Status</label>
							  <div class="controls">
									  <div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">Draft</button>
										<button type="button" class="btn btn-primary '.$live.'">Live</button>
									  </div>
							  </div>
							</div>
							<div class="control-group">
                				<h5>Testimonial</h5>
                   				<textarea id="testimonial_edit" name="testimonial_edit">'.$row['body'].'</textarea>                    
                
            				</div> 
	
					</form>
					
					<script type="text/javascript">
					
									$("#testimonial_edit").redactor({ 	
											fileUpload: "'. site_url('/').'my_images/redactor_add_file/",
											imageGetJson: "'. site_url('/').'my_images/show_upload_images_json/",
											imageUpload: "'. site_url('/').'my_images/redactor_add_image",
											buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
											"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
											"video","file", "table","|",
											 "alignment", "|", "horizontalrule"]
									});
					
					</script>
					
					';
					

			}else{
					
				$this->session->set_flashdata('error', 'Testimonial not found');	
			}
	}
	//+++++++++++++++++++++++++++
	//TESTIMONIALS ADD 
	//++++++++++++++++++++++++++
	
		function add_testimonial_do(){
			
			$title = $this->input->post('title', TRUE);
			$name = $this->input->post('name', TRUE);
			$testimonial = $this->input->post('testimonial', TRUE);
			
			$bus_id = $this->session->userdata('bus_id');

					
			$insertdata = array(
							  'title'=> $title ,
							  'heading'=> $name ,
							  'body'=> $testimonial ,
							  'bus_id'=> $bus_id
							  
				);
			$this->db->insert('testimonials',$insertdata);
			$this->session->set_flashdata('msg', 'Successfully added testimonial');	

	}
	//+++++++++++++++++++++++++++
	//UPDATE
	//++++++++++++++++++++++++++	
	function update_testimonial_do(){
			
			$status = strtolower($this->input->post('status_edit', TRUE));
			$title = $this->input->post('title_edit', TRUE);
			$name = $this->input->post('name_edit', TRUE);
			$testimonial = $this->input->post('testimonial_edit', TRUE);
			$id = $this->input->post('testimonial_id_edit', TRUE);
		
				
			$insertdata = array(
							  'title'=> $title ,
							  'heading'=> $name ,
							  'body'=> $testimonial ,
							  'status'=> $status
				);

			$this->db->where('testimonial_id', $id);
			$this->db->update('testimonials',$insertdata);
			$this->session->set_flashdata('msg', 'Successfully updated testimonial');	


	}
	
	//+++++++++++++++++++++++++++
	//DELETE TESTIMONIAL
	//++++++++++++++++++++++++++

	public function delete_testimonial($id)
	{
		$this->db->where('testimonial_id', $id);
		$this->db->delete('testimonials');
		//LOG
		$this->admin_model->system_log('delete-testimonial'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted testimonial');	
	}
		
	//+++++++++++++++++++++++++++
	//SIDEBARS
	//++++++++++++++++++++++++++

	public function sidebars()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/sidebars');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//+++++++++++++++++++++++++++
	//SIDEBAR ADD 
	//++++++++++++++++++++++++++
	
		function add_sidebar_do(){
			
			$title = $this->input->post('sidebar_title', TRUE);
			$sidebar = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('sidebar_content', FALSE))); 
			
			$bus_id = $this->session->userdata('bus_id');

					
			$insertdata = array(
							  'title'=> $title ,
							  'body'=> $sidebar ,
							  'bus_id'=> $bus_id
							  
				);
			$this->db->insert('sidebar_content',$insertdata);
			$this->session->set_flashdata('msg', 'Successfully added sidebar');	

	}
	
	

	//GET SIDEBAR FOR EDIT
	function get_sidebar($id){

		$this->db->where('sidebar_id', $id);
		$query = $this->db->get('sidebar_content');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				if($row['status'] == 'draft'){
					
					$live = '';
					$draft = 'active';	
					
				}else{
					
					$live = 'active';
					$draft = '';	
				}
				
				echo '<form id="sidebar-update" name="sidebar-update" method="post" action="'.site_url('/').'admin/update_sidebar_do" class="form-horizontal">
    						<input type="hidden" id="sidebar_id_edit" name="sidebar_id_edit" value="'.$row['sidebar_id'].'">  
							<input type="hidden" name="status_edit" id="status_edit"  value="'. $row['status'].'">
							<div class="control-group">
								  <label class="control-label" for="title_edit">Sidebar Title</label>
								<div class="controls">
								   <input type="text" id="title_edit" name="title_edit" value="'.$row['title'].'">                    
								</div>
							 </div>

						   <div class="control-group">
							  <label class="control-label" for="status">Status</label>
							  <div class="controls">
									  <div class="btn-group" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">Draft</button>
										<button type="button" class="btn btn-primary '.$live.'">Live</button>
									  </div>
							  </div>
							</div>
							<div class="control-group">
                				<h5>Sidebar</h5>
                   				<textarea id="sidebar_edit" name="sidebar_edit">'.$row['body'].'</textarea>                    
                
            				</div> 
	
					</form>
					
					<script type="text/javascript">
					
									$("#sidebar_edit").redactor({ 	
											fileUpload: "'. site_url('/').'my_images/redactor_add_file/",
											imageGetJson: "'. site_url('/').'my_images/show_upload_images_json/",
											imageUpload: "'. site_url('/').'my_images/redactor_add_image",
											buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
											"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
											"video","file", "table","|",
											 "alignment", "|", "horizontalrule"]
									});
					
					</script>
					
					';
					

			}else{
					
				$this->session->set_flashdata('error', 'Sidebar not found');	
			}
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE SIDEBAR
	//++++++++++++++++++++++++++	
	function update_sidebar_do(){
			
			$status = strtolower($this->input->post('status_edit', TRUE));
			$title = $this->input->post('title_edit', TRUE);
			$sidebar = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('sidebar_edit', FALSE))); 
			$id = $this->input->post('sidebar_id_edit', TRUE);
		
				
			$insertdata = array(
							  'title'=> $title ,
							  'body'=> $sidebar ,
							  'status'=> $status
				);

			$this->db->where('sidebar_id', $id);
			$this->db->update('sidebar_content',$insertdata);
			$this->session->set_flashdata('msg', 'Successfully updated sidebar');	


	}
	//+++++++++++++++++++++++++++
	//DELETE TESTIMONIAL
	//++++++++++++++++++++++++++

	public function delete_sidebar($id)
	{
		$this->db->where('sidebar_id', $id);
		$this->db->delete('sidebar_content');
		//LOG
		$this->admin_model->system_log('delete-sidebar'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted sidebar');	
	}
		
	//+++++++++++++++++++++++++++
	//MEMBERS
	//++++++++++++++++++++++++++

	public function members()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->model('members_model');
			$type['type'] = 'members'; 
			$this->load->view('admin/members/members', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//DELETE IMAGE
	function delete_members($mem_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('member_id', $mem_id);
			  $this->db->delete('members');
			  //LOG
			  $this->admin_model->system_log('delete_member-'.$mem_id);
			  $this->session->set_flashdata('msg','Member deleted successfully');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin/members/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }
	//+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++

	public function update_members($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('members_model');
			$member = $this->members_model->get_member($mem_id, 'members');
			$member['member_type'] = 'members';
			$this->load->view('admin/members/update_member', $member);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new MEMEBR
	//++++++++++++++++++++++++++

	public function add_members()
	{
		if($this->session->userdata('admin_id')){
			$type['member_type'] = 'members';
			$this->load->view('admin/members/add_member', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD MEMBER
	//++++++++++++++++++++++++++	
	function add_member_do()
	{
		$this->load->model('members_model');
		$this->members_model->add_member_do();
	}
	//+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++	
	function update_member_do()
	{
		$this->load->model('members_model');
		$this->members_model-> update_member_do();
	}
	
	
	//+++++++++++++++++++++++++++
	//DOCUMENTS
	//++++++++++++++++++++++++++

	public function documents()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/documents/documents');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}

	
	
	
	//+++++++++++++++++++++++++++
	//IMAGES/GALLERIES
	//++++++++++++++++++++++++++

	public function images()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/images/images');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	
	//DELETE IMAGE
	function delete_image($img_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('img_id', $img_id);
			  $this->db->delete('images');
			  //LOG
			  $this->admin_model->system_log('delete_image-'.$img_id);
			  $this->session->set_flashdata('msg','Image deleted successfully');
			  echo '<script type="text/javascript">
				  
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_gallery_image($img_id)
	{
		$this->db->where('img_id', $img_id);
		
		$query = $this->db->get('images');

		if($query->result()){
			$row = $query->row_array();
			
			echo '<div class="row-fluid">
					<form id="image-update" name="image-update" method="post" action="'. site_url('/').'admin/update_image_do" >
                       <fieldset>
                        <input type="hidden" id="update_img_id" name="update_img_id" value="'.$img_id.'" />
                        <div class="control-group">
                              <label class="control-label" for="img_title">Title</label>
                              <div class="controls">
                                      <input type="text" class="span12" id="img_title" name="img_title" placeholder="Image title" value="'.$row['title'].'">
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="img_name">Body</label>
                              <div class="controls">
                                      
									  <textarea  name="img_body" class="redactor" style="display:block">'.$row['body'].'</textarea>
                              </div>
                        </div>
						<input type="submit" id="update_img_but" value="Update Image" class="btn btn-primary pull-right" />
                      </fieldset>
                  </form>
				</div>
				<script type="text/javascript">
					
					
					  $(".redactor").redactor({ 	
								  buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
								  "unorderedlist", "orderedlist", "outdent", "indent", "|","image",
								  "video", "table","|",
								   "alignment", "|", "horizontalrule"]
					  });
					
					$("#update_img_but").click(function(e){
						  
						  e.preventDefault();	
						  
						  var frm = $("#image-update");
						  
						  $.ajax({
							cache: false,
							url: "'. site_url("/").'admin/update_image_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {
							  
							  load_images();
							  $("#modal-img-update").modal("hide");
							  
							}
						  });
		
					});
				
				</script>
				
				';	
			
		}
			
	}
	
	//+++++++++++++++++++++++++++
	//update Image
	//++++++++++++++++++++++++++

	public function update_image_do()
	{
		$this->admin_model->update_image_do();
			
	}
	
	public function galleries()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/images/galleries');
			
		}else{
			
			$this->load->view('admin/login');
			
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
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD GALLERY DO
	//++++++++++++++++++++++++++	
	function add_gallery_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$style = $this->input->post('style', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		
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
								  'slug'=> $slug,
								  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('galleries', $insertdata);
					//LOG
					$this->admin_model->system_log('add_new_gallery-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Gallery added successfully');
					$data['basicmsg'] = 'Gallery has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/galleries/";
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
			
			$gallery = $this->admin_model->get_gallery($gal_id);
			$this->load->view('admin/images/update_gallery', $gallery);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	 //+++++++++++++++++++++++++++
	//UPDATE GALLERY
	//++++++++++++++++++++++++++	
	function update_gallery_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);

			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('gallery_id', TRUE);
			$style = $this->input->post('style', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		  
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
								  'slug'=> $slug,
								  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('gal_id' , $id);
					$this->db->update('galleries', $insertdata);
					//success redirect	
					$data['gallery_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_gallery-'. $id);
					$data['basicmsg'] = 'Gallery has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
		
	//+++++++++++++++++++++++++++
	//delete gallery
	//++++++++++++++++++++++++++

	public function delete_gallery($gal_id)
	{
		
		$this->db->where('gal_id', $gal_id);
		$query = $this->db->get('images');
		
		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/images/' . $row['img_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('gal_id', $gal_id);
			$this->db->delete('images');
			
			
		}
		
		$this->db->where('gal_id', $gal_id);
		$this->db->delete('galleries');
		$this->session->set_flashdata('msg','Gallery removed successfully');
		echo '<script type="text/javascript">
				window.location = "'.site_url('/').'admin/galleries/"
				
			</script>';	
			
	}
	//+++++++++++++++++++++++++++
	//UPDATE SIDEBAR
	//++++++++++++++++++++++++++

	public function update_sidebar($ctype, $cid, $stype, $sid )
	{
		if($this->session->userdata('admin_id')){
			
			$bus_id = $this->session->userdata('bus_id');
			//DELETE OLD RECORDS
			$this->db->where($ctype.'_id', $cid);
			$this->db->where('type', $stype);
			$this->db->where('bus_id', $bus_id);
			$this->db->delete('sidebars');
			
			//insert new 
			$data[$ctype.'_id'] = $cid;
			$data['type'] = $stype;
			$data['bus_id'] = $bus_id;
			$data['type_id'] = $sid;
			$this->db->insert('sidebars',$data);
			
			
		}else{
			
			$this->load->view('admin/login');
			
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
			$this->db->where('type', $stype);
			$this->db->where('type_id', $sid);
			$this->db->delete('sidebars');
			
			$this->admin_model->get_sidebar_content($ctype.'_'.$cid);
			
		}else{
			
			$this->load->view('admin/login');
			
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
			
			$this->load->view('admin/login');
			
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
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new project
	//++++++++++++++++++++++++++

	public function update_project($project_id)
	{
		if($this->session->userdata('admin_id')){
			
			$project = $this->admin_model->get_project($project_id);
			$this->load->view('admin/projects/update_project', $project);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//load_documents for Project
	//++++++++++++++++++++++++++

	public function load_documents($project_id)
	{
		
		$this->admin_model->get_project_docs($project_id);
		
				
	}
	//+++++++++++++++++++++++++++
	//load_documents
	//++++++++++++++++++++++++++

	public function get_all_documents()
	{
		
		$this->admin_model->get_all_documents();
		
				
	}
	//+++++++++++++++++++++++++++
	//delete document
	//++++++++++++++++++++++++++

	public function delete_document($doc_id, $type)
	{
		$this->db->where('doc_id', $doc_id);
		
		if($type == 'project_docs'){
			
			$query = $this->db->get('project_documents');
			$del = 'project_documents';
		}else{
			
			$query = $this->db->get('documents');
			$del = 'documents';
		}
		
		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/documents/' . $row['doc_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('doc_id', $doc_id);
			$this->db->delete($del);
			$this->session->set_flashdata('msg','Document removed successfully');		
			
		}
			
	}

	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document($doc_id, $type)
	{
		$this->db->where('doc_id', $doc_id);
		
		if($type == 'project_docs'){
			
			$query = $this->db->get('project_documents');
		}else{
			
			$query = $this->db->get('documents');
			
		}
		
		if($query->result()){
			$row = $query->row_array();
			
			if($row['download'] == 'no'){
					
					$live = '';
					$draft = 'active';	
					
			}else{
					
					$live = 'active';
					$draft = '';	
			}
			
			echo '<div class="row-fluid">
					<form id="document-update" name="document-update" method="post" action="'. site_url('/').'admin/update_document_do" >
                       <fieldset>
                        <input type="hidden" id="update_doc_id" name="update_doc_id" value="'.$doc_id.'" />
						<input type="hidden" id="doc_type" name="doc_type" value="'.$type.'" />
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
						   <div class="control-group">
							  <label class="control-label" for="download">Available in Downloads</label>
							  <div class="controls">
									  <div class="btn-group download" data-toggle="buttons-radio">
										<button type="button" class="btn btn-primary '.$draft.'">No</button>
										<button type="button" class="btn btn-primary '.$live.'">Yes</button>
									  </div>
							  </div>
							  <input type="hidden" name="download" id="download"  value="'. $row['download'].'">
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
							url: "'. site_url("/").'admin/update_document_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {
							  
							  load_documents();
							  $("#modal-doc-update").modal("hide");
							  
							}
						  });
		
					});
					
								
			
				$("div.download button").live("click", function(){
					
					$("#download").attr("value", $(this).html());
				}); 
				</script>
				
				';	
			
		}
			
	}
	//+++++++++++++++++++++++++++
	//update Doc sequence
	//++++++++++++++++++++++++++

	public function update_doc_sequence($doc_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('doc_id' , $doc_id);
			$this->db->update('project_documents', $data);

		
	}
	
	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_document_do()
	{
		$this->admin_model->update_document_do();
			
	}				       
	//+++++++++++++++++++++++++++
	//ADD PROJECT DO
	//++++++++++++++++++++++++++	
	function add_project_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$type = $this->input->post('type', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		
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
								  'slug'=> $slug,
								  'type'=> $type,
								  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('projects', $insertdata);
					//LOG
					$this->admin_model->system_log('add_new_project-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Project added successfully');
					$data['basicmsg'] = 'Project has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/projects/";
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
			$type = $this->input->post('type', TRUE);
			$status = $this->input->post('status', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('project_id', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		  
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
								  'slug'=> $slug,
								  'type'=> $type,
								  'bus_id'=>$bus_id 
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('project_id' , $id);
					$this->db->update('projects', $insertdata);
					//success redirect	
					$data['project_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_project-'. $id);
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
			  $this->admin_model->system_log('delete_project-'.$project_id);
			  $this->session->set_flashdata('msg','Project deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/projects/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//upload project docs 
	//++++++++++++++++++++++++++
	
	function plupload_server($document)
	{
		//Document is for distinguisj=hing between projects and normal documents
		$this->admin_model->plupload_server($document);
		
	}
	
	 //+++++++++++++++++++++++++++
	//upload project docs 
	//++++++++++++++++++++++++++
	
	function add_project_docs()
	{
		$document = 'project_docs';
		$this->admin_model->add_project_docs($document);
		
	}
	
	//+++++++++++++++++++++++++++
	//upload DOCUMENTS
	//++++++++++++++++++++++++++
	
	function add_documents()
	{
		$document = 'documents';
		$this->admin_model->add_project_docs($document);
		
	}
	
	//+++++++++++++++++++++++++++
	//upload gallery images
	//++++++++++++++++++++++++++
	
	function add_gallery_images()
	{
		
		$this->admin_model->add_gallery_images();
		
	}
	//+++++++++++++++++++++++++++
	//update Gall Image sequence
	//++++++++++++++++++++++++++

	public function update_img_sequence($img_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('img_id' , $img_id);
			$this->db->update('images', $data);

		
	}
	//+++++++++++++++++++++++++++
	//load gallery images For sidebars
	//++++++++++++++++++++++++++
	
	function load_gallery_images($gal_id)
	{
		
		$this->admin_model->load_gallery_images($gal_id);
		
	}
	
	//+++++++++++++++++++++++++++
	//load gallery images
	//++++++++++++++++++++++++++
	
	function load_gallery_images_update($gal_id)
	{
		
		$this->admin_model->load_gallery_images_update($gal_id);
		
	}
	//+++++++++++++++++++++++++++
	//PAGES
	//++++++++++++++++++++++++++

	public function pages()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/pages/pages');
			
		}else{
			
			$this->load->view('admin/login');
			
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
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//add new page
	//++++++++++++++++++++++++++

	public function update_page($page_id)
	{
		if($this->session->userdata('admin_id')){
			
			$page = $this->admin_model->get_page($page_id);
			$page['settings'] = $this->get_config();
			$this->load->view('admin/pages/update_page', $page);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD PAGE DO
	//++++++++++++++++++++++++++	
	function add_page_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$page_parent = $this->input->post('page_parent', TRUE);
			$page_sequence = $this->input->post('page_sequence', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			 $bus_id = $this->session->userdata('bus_id');
		  
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'pages');
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
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
								  'title'=> $title ,
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug,
								  'bus_id'=>$bus_id,
								  'page_parent'=> $page_parent,
								  'page_sequence'=> $page_sequence
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('pages', $insertdata);
					$pageid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_page-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Page added successfully');
					$data['basicmsg'] = 'Page has been added successfully';
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);
					window.location = '".site_url('/')."admin/update_page/".$pageid."/';
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
	//UPDATE PAGE
	//++++++++++++++++++++++++++	
	function update_page_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$status = $this->input->post('status', TRUE);
			
			//IE 9 FIX
			if($this->input->post('content')){
				$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			}else{
				$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content2', FALSE)));
			}
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('page_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
		 	$page_parent = $this->input->post('page_parent', TRUE);
			$page_sequence = $this->input->post('page_sequence', TRUE);
			$page_template = $this->input->post('page_template', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
			
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
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug ,
								  'bus_id'=>$bus_id,
								  'page_parent'=> $page_parent,
								  'page_sequence'=> $page_sequence,
								  'page_template'=> $page_template
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('page_id' , $id);
					$this->db->update('pages', $insertdata);
					//success redirect	
					$data['page_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_page-'. $id);
					
					
					
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
			  $this->admin_model->system_log('delete_page-'.$page_id);
			  $this->session->set_flashdata('msg','Page deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/pages/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//UPDATE PAGE LANGUAGES
	//++++++++++++++++++++++++++	
	function update_page_do_language($language)
	{
			$title = $this->input->post('title_'.$language, TRUE);
			$slug = $this->input->post('slug_'.$language, TRUE);
			$status = $this->input->post('status_'.$language, TRUE);
			//$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content_'.$language,FALSE)));
			$heading = $this->input->post('heading_'.$language, TRUE);
			$metaT = $this->input->post('metaT_'.$language, TRUE);
			$metaD = $this->input->post('metaD_'.$language, TRUE);
			$id = $this->input->post('page_id_'.$language, TRUE);

		 	$bus_id = $this->session->userdata('bus_id');
			$page_template = $this->input->post('page_template_'.$language, TRUE);
		 
		 	if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
		 
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Page title Required';
			
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
								  'heading'=> $heading ,
								  'body'=> $body ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'slug'=> $slug ,
								  'bus_id'=>$bus_id,
								  'page_id'=> $id,
								  'page_template'=> $page_template
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('page_id', $id);
					$hasrow = $this->db->get('pages_'.$language);
					//UPDATE
					if($hasrow->result()){
				
							$this->db->where('page_id' , $id);
							$this->db->update('pages_'.$language, $insertdata);
					//NEW	
					}else{
						
						
							$this->db->insert('pages_'.$language, $insertdata);
						
						
					}
		
					//success redirect	
					$data['page_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_page-'. $id);
					$data['basicmsg'] = 'Page has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
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
			
			$this->load->view('admin/login');
			
		}	
	}
	//DELETE COMMENT
	function delete_comment($id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $this->db->where('com_id', $id);
			  $this->db->delete('comments');
			  //LOG
			  $this->admin_model->system_log('delete_comment-'.$id);
			  $this->session->set_flashdata('msg','Comment deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/comments/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
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
				   window.location = "'.site_url('/').'admin/comments/";
				  </script>';
			 
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
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
			
			$this->load->view('admin/login');
			
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
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//update post
	//++++++++++++++++++++++++++

	public function update_post($post_id)
	{
		if($this->session->userdata('admin_id')){
			
			$post = $this->admin_model->get_post($post_id);
			$this->load->view('admin/posts/update_post', $post);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	
	//+++++++++++++++++++++++++++
	//ADD POST DO
	//++++++++++++++++++++++++++	
	function add_post_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$bus_id = $this->session->userdata('bus_id');
		 
			
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'posts');
					
			}else{
				
				$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'posts');
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Post title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
//					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Post Content Required';	
							
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
								  'slug'=> $slug,
								  'bus_id'=> $bus_id
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('posts', $insertdata);
					$postid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_post-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Post added successfully');
					$data['basicmsg'] = 'Post has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/update_post/'.$postid.'/";
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
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('post_id', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
		    $bus_id = $this->session->userdata('bus_id');
		    
			
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'posts');
					
			}else{
				
				$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'posts');
				
			}
			
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Post title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
							
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
								  'slug'=> $slug,
								  'bus_id'=> $bus_id 
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('post_id' , $id);
					$this->db->update('posts', $insertdata);
					//success redirect	
					
					//LOG
					$this->admin_model->system_log('update_post-'. $id);
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
			  $this->admin_model->system_log('delete_post-'.$post_id);
			  $this->session->set_flashdata('msg','Post deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/posts/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
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
			$row = $this->admin_model->validate_password($email,$pass);
			if($row['bool'] == TRUE){
					
					//HASH PASSWORD AGAIN
					$pass_new = $this->admin_model->hash_password($email,$pass);
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
					
					$query = $this->db->where('bus_id', $row['bus_id']);
					$query = $this->db->get('settings');
					$settings = $query->row_array();

					$this->session->set_userdata('admin_id', $row['admin_id']);
					$this->session->set_userdata('bus_id', $row['bus_id']);
					$this->session->set_userdata('u_name', $row['fname']);
					$this->session->set_userdata('last_login', $row['last_login']);
					$this->session->set_userdata('GA_profile', $settings['GA_profile']);
					$this->session->set_userdata('GA_email',  $settings['GA_email']);
					$this->session->set_userdata('GA_pass', $settings['GA_pass']);
					$this->session->set_userdata('site_title',  $settings['title']);
					$this->session->set_userdata('url', $settings['url']);
					$this->session->set_userdata('img_file', $row['img_file']);
					$this->db->where('admin_id', $row['admin_id']);
					$this->db->update('admin', $data);
					
					//LOG
					$this->admin_model->system_log('system_log_in-'. $row['fname']) ;
					//DISPLAY Settings incomplete
					if($this->session->userdata('url') == ''){
						
						$this->session->set_flashdata('error', 'Website settings incomplete. Please update your settings');
							
					}
					
					//--------------
					//Redirect
					if($this->input->post('redirect')){
						
						redirect($redirect, 'refresh');
						
					}else{
						
						$this->session->set_flashdata('msg', 'Logged in successful. Last login was on ' .date('l jS \of F Y h:i:s A',strtotime($row['last_login'])));
						redirect(site_url('/').'admin/home/', 'refresh');	
						
					}
				
				
			//NO MATCHING CREDENTIALS
			}else{
			
				$data['error'] = 'No matching records found!';
				//echo $this->encode($pass) .' ' ;
				$this->load->view('admin/login' , $data);
			
			}
				
	}


	function logout(){

		$this->session->sess_destroy();  
		redirect(site_url('/'),'301');
		//$this->index();
	}


	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//BACKBONE AJAX CALLS
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++	
 */	
	//GET USERS	
	function get_pages(){

		
		$this->admin_model->get_pages();
	

	}	
	
	
	
	//+++++++++++++++++++++++++++
	//ADD SUBSCRIBER CATEGORIES
	//++++++++++++++++++++++++++

	public function add_sub_type_do()
	{
		 $bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO CATEGORIES
		$data['type'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;

		//TEST DUPLICATE CATEGORIES
		$this->db->where('type', $data['type']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('subscriber_type');
		
		if($result1->num_rows() == 0){
			$this->db->insert('subscriber_type', $data);	
		}

		
		
	}
	
	
	//+++++++++++++++++++++++++++
	//LOAD SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function ajax_load_members($type)
	{
		$this->load->model('members_model');
		$this->members_model->get_all_members($type);
		
	}
	
	//+++++++++++++++++++++++++++
	//LOAD EMAIL SUBSCRIBERS
	//++++++++++++++++++++++++++

	public function ajax_load_subscribers()
	{
		$this->load->model('email_model');
		$this->email_model->show_email_recipients();
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD SUBSCRIBER TYPES
	//++++++++++++++++++++++++++

	public function reload_sub_category_all()
	{
		$this->admin_model->get_all_sub_categories();
		
	}
	
	//+++++++++++++++++++++++++++
	//DELETE SUBSCRIBER CATEGORY
	//++++++++++++++++++++++++++

	public function delete_subscriber_category($id)
	{
		$bus_id = $this->session->userdata('bus_id');
		$this->db->where('sub_type_id', $id);
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('subscriber_type');
		
	}
	//+++++++++++++++++++++++++++
	//ADD CATEGORY AND INTERSECTION FOR POST
	//++++++++++++++++++++++++++

	public function add_category_do()
	{
		 $bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$post_id = $this->input->post('post_id_cat');	
		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
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
			$data2['bus_id'] = $bus_id;
			$this->db->insert('post_cat_int', $data2);	
		}
		
	}
	//+++++++++++++++++++++++++++
	//ADD CATEGORY GENERLA
	//++++++++++++++++++++++++++

	public function add_category_do_general()
	{
		 $bus_id = $this->session->userdata('bus_id');		
		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$post_id = $this->input->post('post_id_cat');	
		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('categories');
		
		if($result1->num_rows() == 0){
			$this->db->insert('categories', $data);	
		}
		//GET NEW CAT ID
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result = $this->db->get('categories');
		$row = $result->row_array();

		
	}

	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->admin_model->get_all_categories();
		
	}
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY
	//++++++++++++++++++++++++++

	public function reload_category($post_id)
	{
		$this->admin_model->get_categories_current($post_id);
		
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
			
			$this->load->view('admin/login');
			
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
			
			$this->load->view('admin/login');
			
		}
		
	}
	//GET USER
	function get_sys_user($id){

		$this->db->where('admin_id', $id);
		$query = $this->db->get('admin');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<form id="user-update" name="user-update" method="post" action="'.site_url('/').'admin/update_sys_user_do" class="form-horizontal">
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
			
			$bus_id = $this->session->userdata('bus_id');
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
								  'bus_id'=> $bus_id,
								  'pass'=> $this->admin_model->hash_password($email,$pass)
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
								  
								  'pass'=> $this->admin_model->hash_password($email,$pass)
					);
				
				
			}
			
			  $this->db->where('admin_id', $id);
			  $this->db->update('admin',$insertdata);
			  $this->session->set_flashdata('msg', 'Successfully updated system user');	
			


	}
	
	
	
	//+++++++++++++++++++++++++++
	//DELETE USER
	//++++++++++++++++++++++++++

	public function delete_user($id)
	{
		$this->db->where('admin_id', $id);
		$this->db->delete('admin');
		//LOG
		$this->admin_model->system_log('delete-system-user'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted system user');	
	}
	
	//+++++++++++++++++++++++++++
	//SETTINGS
	//++++++++++++++++++++++++++

	public function settings()
	{
		if($this->session->userdata('admin_id')){
			$this->load->model('my_namibia_model');
			$settings = $this->admin_model->get_settings();
			$this->load->view('admin/settings', $settings);
			
		}else{
			
			$this->load->view('admin/login');
			
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
			$url = prep_url($this->input->post('url', TRUE));

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
					$this->session->set_userdata('GA_profile', $ga_id);
					$this->session->set_userdata('GA_email',  $ga_email);
					$this->session->set_userdata('GA_pass',$ga_pass);
					$this->session->set_userdata('site_title',$title);
					$this->session->set_userdata('url',$url);
					//LOG
					$this->admin_model->system_log('update_settings-'. $id);
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
			
			$this->load->view('admin/login');
			
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
		$this->admin_model->system_log('delete-enquiry'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted the enquiry');	
	}
	

	//+++++++++++++++++++++++++++
	//RELOAD CHAT ALL
	//++++++++++++++++++++++++++

	public function reload_chat_all($ticket)
	{
		$this->admin_model->get_chat_content($ticket);
		
	}	

	public function helpdesk()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/helpdesk');
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}	


	
	//+++++++++++++++++++++++++++
	//HELPDESK
	//++++++++++++++++++++++++++
	public function support_chat($ticket)
	{	
		if($this->session->userdata('admin_id')){
		$bus_id = $this->session->userdata('bus_id');
			
		$data['ticket'] = $ticket;
		
		$insertdata = array('status'=> 'active');	
		
		$this->db->where('bus_id' , $bus_id);
		$this->db->where('ticket_id' , $ticket);
		$this->db->update('support_tickets', $insertdata);		
		
		$this->load->view('admin/support_chat', $data);
		
		}else{
			
			$this->load->view('admin/login');
			
		}			
		
		
	}	
	
		
	public function add_quick_message()
	{
			
		$this->admin_model->add_quick_message();
		
		
	}
	
	public function close_ticket($ticket)
	{
		
		$bus_id = $this->session->userdata('bus_id');
		$insertdata = array('status'=> 'closed');
	
		$this->db->where('bus_id' , $bus_id);
		$this->db->where('ticket_id' , $ticket);
		$this->db->update('support_tickets', $insertdata);
				
		$this->load->view('admin/helpdesk');
		
		
		
	}		
	
	//+++++++++++++++++++++++++++
	//GET ENQUIRY
	//++++++++++++++++++++++++++

	public function get_enquiry($id)
	{
		$this->db->where('enq_id', $id);
		$query = $this->db->get('enquiries');

			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<div id="reply_view"><p>'.$row['name'].'</p>';
				echo '<div class="well">'.$row['body'].'</div>';	
				echo '<em>'.date('l jS \of F Y h:i:s A',strtotime($row['datetime'])).'</em></div>';
				
				echo '<div id="reply_txt" class="hide" style="margin-top:30px;">
						  <form id="sendmail" onsubmit="return validateMyForm();" name="sendmail" method="post" action="'.site_url('/').'admin/reply_enquiry" >
							  <input type="hidden" id="" name="name" value="'.$row['name'].'">
							  <input type="hidden" id="" name="enq_id" value="'.$id.'">
							  <input type="hidden" id="" name="email" value="'.$row['email'].'">
							  <textarea id="redactor_content" class="redactor" name="content"><p>&nbsp</p><p>--------------------------</p>
							  <p>From: '.$row['name'].'</p><p>'.$row['body'].'</p><em> Time: '.date('l jS \of F Y h:i:s A',strtotime($row['datetime'])).'</em>
							  <p>--------------------------</p></textarea>
							  <div class="clearfix" style="height:20px;"></div>
							  <div id="reply_msg"></div>
							  <button type=button" onclick="reply_enquiry()" id="send_mail_btn" class="btn pull-right"><i class="icon-envelope"></i> Send</button>
						  </form>
						  <script type="text/javascript">
						  			
									function validateMyForm()
									{
									 	return false;
									 	//reply_enquiry();
									 
									}
									console.log("poes");
									$(".redactor").redactor({ 	
												
												imageGetJson: "' .site_url('/').'my_images/show_upload_images_json/",
												imageUpload: "'.site_url('/').'my_images/redactor_add_image",
												buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|", 
												"unorderedlist", "orderedlist", "outdent", "indent", "|","image",
												"video", "table", "link","|",
												 "alignment", "|", "horizontalrule"]
									});
						  
						  </script>
					  </div>
					  ';	  
				
				
			}else{
					
				$this->session->set_flashdata('error', 'Enquiry not found');	
			}
	}
	
	
	//+++++++++++++++++++++++++++
	//REPLY ENQUIRY
	//++++++++++++++++++++++++++

	public function reply_enquiry()
	{
		if($this->session->userdata('admin_id')){
			
			$this->admin_model->reply_enquiry();
			
		}else{
			
			redirect(site_url('/').'admin/logout');
			
		}
		
		
	}
	
	
		//+++++++++++++++++++++++++++
	//MEMBERS
	//++++++++++++++++++++++++++

	public function bookings()
	{
		if($this->session->userdata('admin_id')){
			

			$this->load->view('admin/bookings/bookings', $type);
			
		}else{
			
			$this->load->view('admin/login');
			
		}	
	}
	//DELETE IMAGE
	function delete_booking($booking_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('booking_id', $booking_id);
			  $this->db->delete('bookings');
			  //LOG
			  $this->admin_model->system_log('delete_booking-'.$booking_id);
			  $this->session->set_flashdata('msg','Booking removed from system');
			  echo '<script type="text/javascript">
				  window.location = "'.site_url('/').'admin/bookings/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'/admin/logout/','refresh');
				
		}
    }
	//+++++++++++++++++++++++++++
	//UPDATE BOOKING
	//++++++++++++++++++++++++++

	public function update_booking($mem_id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->load->model('members_model');
			$member = $this->members_model->get_member($mem_id, 'members');
			$member['member_type'] = 'members';
			$this->load->view('admin/members/update_member', $member);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	//MODERATE BOOKINGS
	function update_booking_status($id, $status, $type){

		if($this->session->userdata('admin_id')){

			  $data[$type] = $status;	
		 	  $this->db->where('booking_id', $id);
			  $query = $this->db->update('bookings', $data);
			  $this->session->set_flashdata('msg','Booking updated successfully');
					
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/bookings/";
				  </script>';
			 
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		} 
			 
						
	
    }
	
	
	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function add_featured_image()
	{
		if($this->session->userdata('admin_id')){
			
			$this->admin_model->add_featured_image();
			
		}else{
			
			redirect(site_url('/').'admin/logout');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function remove_featured_image($type, $id)
	{
		$this->db->where('type', $type);
		$this->db->where('type_id', $id);
		$query = $this->db->get('images');
		
		if($query->result()){
			$row = $query->row_array();
			$file =  BASE_URL.'assets/images/' . $row['img_file']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			$this->db->where('type', $type);
		    $this->db->where('type_id', $id);
			$this->db->delete('images');
			 echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'Image removed.','layout':'bottomLeft','type':'success'};
					  noty(options);
					
					  </script>";		 
						 	
			
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
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	
	//+++++++++++++++++++++++++++
	//EMAIL MARKETING PREVIEW EMAIL
	//++++++++++++++++++++++++++

	public function preview_email()
	{
		
		$data['preview'] = 'true';
		//$data['body'] = html_entity_decode($this->input->post('mailbody', TRUE));
		$data['body'] = $this->input->post('mailbody', FALSE);
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
	//GET ACCCOUNT SETTINGS
	//++++++++++++++++++++++++++

	public function get_config()
	{
		
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('config');
		if($query->result()){
			
			$row = $query->row_array();
			return $row['components'];
			
		}else{
			
			return '';	
		}
		
	}
	
	 
	 //+++++++++++++++++++++++++++
	 //PRODUCTS
	 //++++++++++++++++++++++++++
	
	 public function products()
	 {
		  if($this->session->userdata('admin_id')){
		   
		   	$this->load->view('admin/products/products');
		   
		  }else{
		   
		   	$this->load->view('admin/login');
		   
		  } 
	 } 
	  //+++++++++++++++++++++++++++
	 //GET SUB CATEGORIES PRODUCT
	 //++++++++++++++++++++++++++
	
	 public function get_product_sub_cats($check, $tid, $id)
	 {
	   $this->admin_model->get_all_product_category_types($check, $tid, $id);
	 }                                             
	
	
	 //+++++++++++++++++++++++++++
	 //add new product
	 //++++++++++++++++++++++++++
	
	 public function add_product()
	 {
		  if($this->session->userdata('admin_id')){
		   
				$this->load->view('admin/products/add_product');
		   
		  }else{
		   
				 $this->load->view('admin/login');
		   
		  }
	  
	 }
	 
	 
	 //+++++++++++++++++++++++++++
	 //update product
	 //++++++++++++++++++++++++++
	
	 public function update_product($product_id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $product = $this->admin_model->get_product($product_id);
			   $this->load->view('admin/products/update_product', $product);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	  
	  
	 }
	
	//+++++++++++++++++++++++++++
	//ADD PRODUCT DO
	//++++++++++++++++++++++++++	
	function add_product_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$sku = $this->input->post('sku', TRUE);
			$type = $this->input->post('type', TRUE);
			$type_s = $this->input->post('type_s', TRUE);
			$url_link = $this->input->post('url_link', TRUE);
			$start_price = $this->input->post('start_price', TRUE);
			$sale_price = $this->input->post('sale_price', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			//$id = $this->input->post('page_id', TRUE);
			$bus_id = $this->session->userdata('bus_id');

			$input = trim($url_link, '/');
			
			if($url_link != "") {
			// If scheme not included, prepend it
			if (!preg_match('#^http(s)?://#', $input)) {
				$url_link = 'http://' . $input;
			}
			} else {
			
			$url_link = "";
				
			}

		
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Product title Required';
					
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
								  'sku_code'=> $sku ,
								  'category'=> $type ,
								  'category_type'=> $type_s ,
								  'description'=> $body ,
								  'start_price'=> $start_price ,
								  'sale_price'=> $sale_price ,
								  'url_link'=> $url_link ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'listing_date'=> date('Y-m-d h:i:s',strtotime($pubdate)),
								  'slug'=> $slug,
								  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){

					$this->db->insert('products', $insertdata);
					//LOG
					$this->admin_model->system_log('add_new_product-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Product added successfully');
					$data['basicmsg'] = 'Product has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'admin/products/";
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
	//UPDATE PRODUCT
	//++++++++++++++++++++++++++	
	function update_product_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$status = $this->input->post('status', TRUE);
			$sku = $this->input->post('sku', TRUE);
			$type = $this->input->post('type', TRUE);
			$type_s = $this->input->post('type_s', TRUE);
			$url_link = $this->input->post('url_link', TRUE);			
			$start_price = $this->input->post('start_price', TRUE);
			$sale_price = $this->input->post('sale_price', TRUE);			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('product_id', TRUE);
			$pubdate = $this->input->post('pub_date', TRUE);
			$bus_id = $this->session->userdata('bus_id');
	
			$input = trim($url_link, '/');
			
			if($url_link != "") {
			// If scheme not included, prepend it
			if (!preg_match('#^http(s)?://#', $input)) {
				$url_link = 'http://' . $input;
			}
			} else {
			
			$url_link = "";
				
			}
		  
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Product title Required';
					
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
								  'heading'=> $heading ,
								  'sku_code'=> $sku ,
								  'category'=> $type ,
								  'category_type'=> $type_s ,
								  'description'=> $body ,
								  'start_price'=> $start_price ,
								  'sale_price'=> $sale_price ,
								  'url_link'=> $url_link ,
								  'metaD'=> $metaD,
								  'metaT'=> $metaT,
								  'listing_date'=> date('Y-m-d h:i:s',strtotime($pubdate)),
								  'slug'=> $slug,
								  'status'=> strtolower($status),
								  'bus_id'=>$bus_id
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('product_id' , $id);
					$this->db->update('products', $insertdata);
					//success redirect	
					$data['product_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_product-'. $id);
					$data['basicmsg'] = 'Product has been updated successfully'.strtolower($status);
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	
	//DELETE PRODUCT
	function delete_product($product_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('product_id', $product_id);
			  $this->db->delete('products');
			  //LOG
			  $this->admin_model->system_log('delete_product-'.$product_id);
			  $this->session->set_flashdata('msg','Product deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'admin/products/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }



	//+++++++++++++++++++++++++++
	//UNSUBSCRIBE
	//++++++++++++++++++++++++++
	public function unsubscribe($email)
	{	
		$email = rawurldecode($this->encrypt->decode($email,  $this->config->item('encryption_key')));
		$this->db->where('email', $email);
		$this->db->delete('subscribers');
		
		
	}
	 
	  
	//+++++++++++++++++++++++++++
	//ENCRYPRION FUNCTIONS
	//++++++++++++++++++++++++++
	
	public function encrypt($email, $pass)
	{
		$str = str_replace('_-_','@',$email);
//		$str = 'sme@my.na';
//		$pass = '123';
		echo $this->admin_model->hash_password($str,$pass);	
		
	}
	
	public function decrypt($str,$pass)
	{
		
		//echo $this->encrypt_model->hash_password($str,$pass);	
		
		$row = $this->admin_model->validate_password($str,$pass);
		if($this->admin_model->validate_password($str,$pass)){
			
			echo 'YES';
		
		}else{
			
			echo 'No';
			
		}
		
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS NAME
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

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */