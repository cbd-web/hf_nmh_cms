<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Project extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Project()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('project_model');
		//force_ssl();
	}
	
	//+++++++++++++++++++++++++++
	//PRODUCTS
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
	//UPDATE CATEGORY DO
	//++++++++++++++++++++++++++

	public function update_category_do()
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->update_category_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//update category
	//++++++++++++++++++++++++++

	public function update_category($category_id)
	{
		if($this->session->userdata('admin_id')){

			$category = $this->project_model->get_category($category_id);
			$this->load->view('admin/projects/update_category', $category);

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

	public function update_project($project_id)
	{
		if($this->session->userdata('admin_id')){

			$project = $this->project_model->get_project($project_id);
			$this->load->view('admin/projects/update_project', $project);

		}else{

			$this->load->view('admin/login');

		}


	}

	//+++++++++++++++++++++++++++
	//ADD PROJECT DO
	//++++++++++++++++++++++++++
	function add_project_do()
	{
		$title = $this->input->post('title', TRUE);
		$location = $this->input->post('location', TRUE);
		$client_id = $this->input->post('client_id', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$type = $this->input->post('type', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$heading = $this->input->post('heading', TRUE);
		$video = $this->input->post('video', TRUE);
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$pubdate = $this->input->post('pub_date', TRUE);
		$comp_date = $this->input->post('comp_date', TRUE);
		//$id = $this->input->post('page_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		if($slug == ''){
			$slug = $this->clean_url_str($title, $replace=array(), $delimiter='-' , 'project', 'add');
		}else{
			$slug = $this->clean_url_str($slug, $replace=array(), $delimiter='-' , 'project', 'add');
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
			'client_id'=> $client_id ,
			'title'=> $title ,
			'location'=> $location ,
			'video'=> $video ,
			'heading'=> $heading ,
			'body'=> $body ,
			'metaD'=> $metaD,
			'metaT'=> $metaT,
			'review'=> date('Y-m-d h:i:s',strtotime($pubdate)),
			'completion_date'=> date('Y-m-d h:i:s',strtotime($comp_date)),
			'slug'=> $slug,
			'type'=> $type,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$this->db->insert('projects', $insertdata);
			$project_id = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_project-'.$title);
			//success redirect
			$this->session->set_flashdata('msg','Project added successfully');
			$data['basicmsg'] = 'Project has been added successfully';
			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'project/update_project/'.$project_id.'";
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
	//ADD TESTIMONIAL DO
	//+++++++++++++++++++++++++++
	public function add_testimonial()
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->add_testimonial_do();

		}else{

			$this->load->view('admin/login');

		}
	}

	//+++++++++++++++++++++++++++
	//DELETE TESTIMONIAL DO
	//++++++++++++++++++++++++++
	function delete_testimonial($id){

		if($this->session->userdata('admin_id')){

			$this->project_model->delete_testimonial_do($id);

		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}


	//+++++++++++++++++++++++++++++++
	//UPDATE TESTIMONIAL SEQUENCE
	//+++++++++++++++++++++++++++++++
	public function update_testimonial_sequence($id, $project_id, $sequence)
	{

		$data['sequence'] = $sequence;

		$this->db->where('project_id' , $project_id);
		$this->db->where('testimonial_id' , $id);
		$this->db->update('project_testimonials', $data);

	}


	//++++++++++++++++++++++++++++
	// RELOAD TESTIMONIALS ALL
	//++++++++++++++++++++++++++++

	public function reload_testimonials_all($id)
	{
		$this->project_model->get_all_testimonials($id);

	}



	//+++++++++++++++++++++++++++
	//ADD PEOPLE DO
	//+++++++++++++++++++++++++++
	public function add_people()
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->add_people_do();

		}else{

			$this->load->view('admin/login');

		}
	}

	//+++++++++++++++++++++++++++
	//DELETE PEOPLE DO
	//++++++++++++++++++++++++++
	function delete_people($id){

		if($this->session->userdata('admin_id')){

			$this->project_model->delete_people_do($id);

		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}


	//+++++++++++++++++++++++++++++++
	//UPDATE PEOPLE SEQUENCE
	//+++++++++++++++++++++++++++++++
	public function update_people_sequence($id, $project_id, $sequence)
	{

		$data['sequence'] = $sequence;

		$this->db->where('project_id' , $project_id);
		$this->db->where('id' , $id);
		$this->db->update('project_people_int', $data);

	}


	//++++++++++++++++++++++++++++
	// RELOAD PAGE PEOPLE ALL
	//++++++++++++++++++++++++++++

	public function reload_people_all($id)
	{
		$this->project_model->get_all_people($id);

	}




	//+++++++++++++++++++++++++++
	//UPDATE PROJECT
	//++++++++++++++++++++++++++
	function update_project_do()
	{
		$client_id = $this->input->post('client_id', TRUE);
		$title = $this->input->post('title', TRUE);
		$location= $this->input->post('location', TRUE);
		$video = $this->input->post('video', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$type = $this->input->post('type', TRUE);
		$status = $this->input->post('status', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$heading = $this->input->post('heading', TRUE);
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$id = $this->input->post('project_id', TRUE);
		$pubdate = $this->input->post('pub_date', TRUE);
		$comp_date = $this->input->post('comp_date', TRUE);
		$bus_id = $this->session->userdata('bus_id');
		$featured = $this->input->post('featured', TRUE);

		if($featured == 'Y') { $featured = 'Y'; } else { $featured = 'N'; }

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
			'client_id'=> $client_id ,
			'title'=> $title ,
			'location'=> $location ,
			'video'=> $video ,
			'status'=> strtolower($status),
			'heading'=> $heading ,
			'body'=> $body ,
			'metaD'=> $metaD,
			'metaT'=> $metaT,
			'review'=> date('Y-m-d h:i:s',strtotime($pubdate)),
			'completion_date'=> date('Y-m-d h:i:s',strtotime($comp_date)),
			'slug'=> $slug,
			'type'=> $type,
			'featured'=> $featured,
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
				   window.location = "'.site_url('/').'project/projects/";
				  </script>';


		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}




	//+++++++++++++++++++++++++++
	//CLIENTS
	//++++++++++++++++++++++++++

	public function clients()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/projects/clients');

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//ADD CLIENT
	//++++++++++++++++++++++++++

	public function add_client()
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->add_client();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE CLIENT DO
	//++++++++++++++++++++++++++

	public function update_client_do()
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->update_client_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//update client
	//++++++++++++++++++++++++++

	public function update_client($client_id)
	{
		if($this->session->userdata('admin_id')){

			$client = $this->project_model->get_client($client_id);
			$this->load->view('admin/projects/update_client', $client);

		}else{

			$this->load->view('admin/login');

		}


	}

	//+++++++++++++++++++++++++++
	//DELETE CLIENT
	//++++++++++++++++++++++++++

	public function delete_client($id)
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->delete_client($id);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//RELOAD CLIENTS ALL
	//++++++++++++++++++++++++++

	public function reload_client_all()
	{
		$this->project_model->get_all_clients();

	}

	//+++++++++++++++++++++++++++
	//update client sequence
	//++++++++++++++++++++++++++

	public function update_client_sequence($man_id , $sequence)
	{

		$data['sequence'] = $sequence;
		$this->db->where('client_id' , $man_id);
		$this->db->update('project_clients', $data);


	}



	//+++++++++++++++++++++++++++
	//CATEGORIES
	//++++++++++++++++++++++++++

	public function categories()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/projects/categories');

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//ADD CATEGORY
	//++++++++++++++++++++++++++

	public function add_category()
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->add_category();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE CATEGORY
	//++++++++++++++++++++++++++

	public function delete_category($id)
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->delete_category($id);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->project_model->get_all_categories();

	}


	//+++++++++++++++++++++++++++
	//ADD CATEGORY MEMBER
	//++++++++++++++++++++++++++

	public function add_category_project()
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->add_category_project();

		}else{

			$this->load->view('admin/login');

		}

	}

	public function delete_category_project($id)
	{
		if($this->session->userdata('admin_id')){

			$this->project_model->delete_category_project($id);

		}else{

			$this->load->view('admin/login');

		}

	}



	public function reload_category_project($project_id)
	{
		$this->project_model->get_categories_current($project_id);

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