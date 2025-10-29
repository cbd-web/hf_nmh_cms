<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Advert extends CI_Controller {


	 function advert()
	{
		parent::__construct();
		$this->load->model('advert_model');
		$this->load->model('branch_model');
		//force_ssl();
	}

	//+++++++++++++++++++++++++++ 
	//EVENTS
	//++++++++++++++++++++++++++

	public function adverts()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/adverts/adverts');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//add new advert
	//++++++++++++++++++++++++++

	public function add_advert()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/adverts/add_advert');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	//+++++++++++++++++++++++++++
	//ADD EVENT DO
	//++++++++++++++++++++++++++

	public function add_advert_do()
	{
		if($this->session->userdata('admin_id')){

			$this->advert_model->add_advert_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//update advert
	//++++++++++++++++++++++++++

	public function update_advert($advert_id)
	{
		if($this->session->userdata('admin_id')){
			
			$advert = $this->advert_model->get_advert($advert_id);
			//$advert['settings'] = $this->get_config();
			
			//$this->load->model('my_namibia_model');
			$this->load->view('admin/adverts/update_advert', $advert);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE EVENT DO
	//++++++++++++++++++++++++++

	public function update_advert_do()
	{
		if($this->session->userdata('admin_id')){

			$this->advert_model->update_advert_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE EVENT DO
	//++++++++++++++++++++++++++

	public function delete_advert($advert_id)
	{
		if($this->session->userdata('admin_id')){

			$this->advert_model->delete_advert($advert_id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//CATEGORIES
	//++++++++++++++++++++++++++

	public function categories()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/adverts/categories');

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

			$this->advert_model->add_category();

		}else{

			$this->load->view('admin/login');

		}

	}


	public function add_advert_category()
	{
		if($this->session->userdata('admin_id')){

			$this->advert_model->add_advert_category();

		}else{

			$this->load->view('admin/login');

		}

	}


	public function add_advert_page()
	{
		if($this->session->userdata('admin_id')){

			$this->advert_model->add_advert_page();

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

			$this->advert_model->delete_category($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	public function delete_category_advert($id)
	{
		if($this->session->userdata('admin_id')){

			$this->advert_model->delete_category_event($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	public function delete_page_advert($id)
	{
		if($this->session->userdata('admin_id')){

			$this->advert_model->delete_page_advert($id);

		}else{

			$this->load->view('admin/login');

		}

	}	


	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++
	public function reload_category_all()
	{
		$this->advert_model->get_all_categories();

	}


	public function reload_category_adverts($advert_id)
	{
		$this->advert_model->get_categories_current($advert_id);

	}

	public function reload_page_adverts($advert_id)
	{
		$this->advert_model->get_pages_current($advert_id);

	}	


	// //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// //CLEAN BUSINESS NAME
	// //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	// //setlocale(LC_ALL, 'en_US.UTF8');
	// function clean_url_str($str, $replace=array(), $delimiter='-') {
	// 	if( !empty($replace) ) {
	// 		$str = str_replace((array)$replace, ' ', $str);
	// 	}

	// 	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	// 	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	// 	$clean = strtolower(trim($clean, '-'));
	// 	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	// 	return $clean;
	// }


	// //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// //CLEAN BUSINESS URL SLUG
	// //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	// //setlocale(LC_ALL, 'en_US.UTF8');
	// function clean_slug_str($str, $replace=array(), $delimiter='-' , $type) {
	// 	if( !empty($replace) ) {
	// 		$str = str_replace((array)$replace, ' ', $str);
	// 	}

	// 	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	// 	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	// 	$clean = strtolower(trim($clean, '-'));
	// 	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

	// 	//test Databse
	// 	//$this->db->where('bus_id', $this->session->userdata('bus_id'));
	// 	$this->db->where('slug', $clean);
	// 	$res = $this->db->get($type);

	// 	if($res->result()){

	// 		$clean = $clean .'-'.rand(0,99);
	// 		return $clean;

	// 	}else{

	// 		return $clean;
	// 	}


	// }


}



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */