<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Publication extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function __construct()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('publication_model');
		//force_ssl();
	}


	//+++++++++++++++++++++++++++
	//upload gallery images
	//++++++++++++++++++++++++++
	
	function add_gallery_images()
	{
		
		$this->publication_model->add_gallery_images();
		
	}


	//+++++++++++++++++++++++++++
	//load gallery images
	//++++++++++++++++++++++++++
	
	function load_gallery_images_update($pub_id)
	{
		
		$this->publication_model->load_gallery_images_update($pub_id);
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE CATEGORY DO
	//++++++++++++++++++++++++++

	public function update_category_do()
	{
		if($this->session->userdata('admin_id')){

			$this->publication_model->update_category_do();

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

			$category = $this->publication_model->get_category($category_id);
			$this->load->view('admin/publications/update_category', $category);

		}else{

			$this->load->view('admin/login');

		}


	}


	//+++++++++++++++++++++++++++
	//Publications
	//++++++++++++++++++++++++++

	public function publications()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/publications/publications');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}

	//+++++++++++++++++++++++++++
	//add new publication
	//++++++++++++++++++++++++++

	public function add_publication()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/publications/add_pub');

		}else{

			$this->load->view('admin/login');

		}


	}
	//+++++++++++++++++++++++++++
	//update publication
	//++++++++++++++++++++++++++

	public function update_publication($pub_id)
	{
		if($this->session->userdata('admin_id')){

			$pub = $this->admin_model->get_publication($pub_id);
			$this->load->view('admin/publications/update_pub', $pub);

		}else{

			$this->load->view('admin/login');

		}


	}



	//+++++++++++++++++++++++++++
	//ADD PUBLICATION DO
	//++++++++++++++++++++++++++
	function add_publication_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$issue_date = $this->input->post('issue_date', TRUE);
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$bus_id = $this->session->userdata('bus_id');


		if($slug == ''){

			$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'publications', 'add');

		}else{

			$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'publications');

		}

		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Publication title Required';
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
			'title'=> $title,
			'body'=> $body,
			'issue_date'=> $issue_date,
			'metaD'=> $metaD,
			'metaT'=> $metaT,
			'slug'=> $slug,
			'bus_id'=> $bus_id
		);



		if($val == TRUE){


			$this->db->insert('publications', $insertdata);
			$pubid = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_publication-'.$title);
			//success redirect
			$this->session->set_flashdata('msg','Publication added successfully');
			$data['basicmsg'] = 'Publication has been added successfully';
			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">�</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'publication/update_publication/'.$pubid.'/";
					</script>
					';
		}else{
			$data['id'] = $this->session->userdata('id');
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">�</button>
            		'.$data['error'].'</div>';
			$this->output->set_header("HTTP/1.0 200 OK");

		}
	}

	//+++++++++++++++++++++++++++
	//UPDATE PUBLICATION
	//++++++++++++++++++++++++++
	function update_publication_do()
	{
		$title = $this->input->post('title', TRUE); 
		$slug = $this->input->post('slug', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$issue_date = $this->input->post('issue_date', TRUE);
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$bus_id = $this->session->userdata('bus_id');
		$pub_id = $this->input->post('pub_id', TRUE);
		$status = $this->input->post('status', TRUE);
		$pub_type = $this->input->post('pub_type', TRUE);


		if($slug == ''){

			$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'publications');

		}else{


			$slug = $this->clean_slug_str($slug, $replace=array(), $delimiter='-' , 'publications');

		}


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Publication title Required';

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
			'type'=> strtolower($pub_type),
			'body'=> $body ,
			'issue_date'=> $issue_date,
			'metaD'=> $metaD,
			'metaT'=> $metaT,
			'slug'=> $slug,
			'bus_id'=> $bus_id
		);



		if($val == TRUE){

			$this->db->where('pub_id' , $pub_id);
			$this->db->update('publications', $insertdata);
			//success redirect

			//LOG
			$this->admin_model->system_log('update_publication-'. $pub_id);
			$data['basicmsg'] = 'Publication has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}


	//+++++++++++++++++++++++++++
	//UPDATE PUBLICATION
	//++++++++++++++++++++++++++
	function update_publication_file_do()
	{
		$link = $this->input->post('link', TRUE);
		$bus_id = $this->session->userdata('bus_id');
		$pub_id = $this->input->post('pub_id', TRUE);

		//VALIDATE INPUT
		if($link == ''){
			$val = FALSE;
			$error = 'Publication File Required';

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
			'link'=> $link
		);



		if($val == TRUE){

			$this->db->where('bus_id' , $bus_id);
			$this->db->where('pub_id' , $pub_id);
			$this->db->update('publications', $insertdata);
			//success redirect

			//LOG
			$this->admin_model->system_log('update-publication-file'. $pub_id);
			$data['basicmsg'] = 'Publication file has been added successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}


	//+++++++++++++++++++++++++++
	//ADD NSA DOC
	//++++++++++++++++++++++++++

	public function add_pub_doc()
	{
		if($this->session->userdata('admin_id')){

			$this->publication_model->add_pub_doc();

		}else{

			redirect(site_url('/').'admin/logout');

		}


	}


	public function remove_featured_document($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$insertdata = array(
			'link'=> ''
		);

		$this->db->where('bus_id' , $bus_id);
		$this->db->where('pub_id' , $id);
		$this->db->update('publications', $insertdata);

		//LOG
		$this->admin_model->system_log('remove-publication-file-link');
		$data['basicmsg'] = 'Publication file has been added successfully unlikend from this publication';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

	}


	//DELETE PUBLICATION
	function delete_publication($pub_id){

		if($this->session->userdata('admin_id')){


			//delete from database
			$test = $this->db->where('pub_id', $pub_id);
			$this->db->delete('publications');
			//LOG
			$this->admin_model->system_log('delete_publication-'.$pub_id);
			$this->session->set_flashdata('msg','Publication deleted successfully');
			echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'publication/publications/";
				  </script>';


		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}


	//+++++++++++++++++++++++++++
	//CATEGORIES
	//++++++++++++++++++++++++++

	public function categories($id=0)
	{
		if($this->session->userdata('admin_id')){

			$data['id'] = $id;
			$this->load->view('admin/publications/categories', $data);
			
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
			
			$this->publication_model->add_category();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD CATEGORY MEMBER
	//++++++++++++++++++++++++++

	public function add_category_pub()
	{
		if($this->session->userdata('admin_id')){
			
			$this->publication_model->add_category_pub();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}

	//+++++++++++++++++++++++++++
	//RELOAD DOC
	//++++++++++++++++++++++++++

	public function reload_doc($pub_id)
	{
		$this->publication_model->load_doc($pub_id);
	}

	//+++++++++++++++++++++++++++
	//DELETE CATEGORY MEMBER
	//++++++++++++++++++++++++++

	public function delete_category_pub($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->publication_model->delete_category_pub($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY MEMBERS
	//++++++++++++++++++++++++++

	public function reload_category_pub($pub_id)
	{
		$this->publication_model->get_categories_current($pub_id);
		
	}	
	
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY
	//++++++++++++++++++++++++++

	public function delete_category($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->publication_model->delete_category($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all($id)
	{
		$this->publication_model->get_all_categories($id);
		
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