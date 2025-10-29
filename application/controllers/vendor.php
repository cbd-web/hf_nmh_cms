<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vendor extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Vendor()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('vendor_model');
		//force_ssl();
	}


	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function index()
	{

		if($this->session->userdata('admin_id')){

			$this->load->view('admin/vendors/vendors');

		}else{

			$this->load->view('admin/login');

		}


	}

	//+++++++++++++++++++++++++++
	//VENDORS
	//++++++++++++++++++++++++++
	public function vendors()
	{

		if($this->session->userdata('admin_id')){

			$this->load->view('admin/vendors/vendors');

		}else{

			$this->load->view('admin/login');

		}


	}

	//+++++++++++++++++++++++++++
	//ADD VENDOR
	//++++++++++++++++++++++++++
	public function add_vendor()
	{

		if($this->session->userdata('admin_id')){

			$this->load->view('admin/vendors/add_vendor');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD VENDOR DO
	//++++++++++++++++++++++++++
	public function add_vendor_do()
	{

		if($this->session->userdata('admin_id')){

			$this->vendor_model->add_vendor_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//UPDATE VENDOR
	//++++++++++++++++++++++++++
	public function update_vendor($id)
	{

		if($this->session->userdata('admin_id')){

			$vendor = $this->vendor_model->get_vendor($id);

			$this->load->view('admin/vendors/update_vendor', $vendor);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE VENDOR DO
	//++++++++++++++++++++++++++
	public function update_vendor_do()
	{

		if($this->session->userdata('admin_id')){

			$this->vendor_model->update_vendor_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE VENDOR
	//++++++++++++++++++++++++++

	public function delete_vendor($id)
	{
		if($this->session->userdata('admin_id')){

			$this->vendor_model->delete_vendor($id);

		}else{

			$this->load->view('admin/login');

		}

	}



	//+++++++++++++++++++++++++++
	//UPDATE MAP DO
	//++++++++++++++++++++++++++
	public function update_map()
	{

		if($this->session->userdata('admin_id')){

			$this->vendor_model->update_map();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD VENDOR FEATURE
	//++++++++++++++++++++++++++
	public function add_vendor_feature()
	{

		if($this->session->userdata('admin_id')){

			$this->vendor_model->add_vendor_feature();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//UPDATE FEATURE SEQUENCE
	//++++++++++++++++++++++++++

	public function update_feature_sequence($feat_id , $sequence)
	{

		$data['sequence'] = $sequence;
		$this->db->where('feature_id' , $feat_id);
		$this->db->update('vendor_features', $data);

	}


	//+++++++++++++++++++++++++++
	//DELETE VENDOR FEATURE
	//++++++++++++++++++++++++++

	public function delete_vendor_feature($id)
	{
		if($this->session->userdata('admin_id')){

			$this->vendor_model->delete_vendor_feature($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//RELOAD VENDOR FEATURES
	//++++++++++++++++++++++++++

	public function reload_vendor_features($vid)
	{
		$this->vendor_model->get_vendor_features($vid);

	}



	//+++++++++++++++++++++++++++
	//RELOAD VENDOR CAT TYPES
	//++++++++++++++++++++++++++

	public function reload_vendor_cat_types($vid,$cid)
	{
		$this->vendor_model->get_vendor_groups($cid,$vid);

	}



	//+++++++++++++++++++++++++++
	//CATEGORIES
	//++++++++++++++++++++++++++

	public function categories()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/vendors/categories');

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

			$this->vendor_model->add_category();

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

			$this->vendor_model->update_category_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE CATEGORY
	//++++++++++++++++++++++++++

	public function update_category($id)
	{
		if($this->session->userdata('admin_id')){

			$cat = $this->vendor_model->get_category($id);

			$this->load->view('admin/vendors/update_category', $cat);

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

			$this->vendor_model->delete_category($id);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->vendor_model->get_all_categories();

	}

	//+++++++++++++++++++++++++++
	//ADD GROUP TYPE
	//++++++++++++++++++++++++++

	public function add_group_type()
	{
		if($this->session->userdata('admin_id')){

			$this->vendor_model->add_group_type();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//RELOAD GROUP TYPES
	//++++++++++++++++++++++++++

	public function reload_group_types($id)
	{
		echo $this->vendor_model->get_group_types($id);

	}


	//+++++++++++++++++++++++++++
	//DELETE GROUP
	//++++++++++++++++++++++++++

	public function delete_group($id)
	{
		if($this->session->userdata('admin_id')){

			$this->vendor_model->delete_group($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE GROUP TYPE
	//++++++++++++++++++++++++++

	public function delete_group_type($id)
	{
		if($this->session->userdata('admin_id')){

			$this->vendor_model->delete_group_type($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD GROUP
	//++++++++++++++++++++++++++

	public function add_group()
	{
		if($this->session->userdata('admin_id')){

			$this->vendor_model->add_group();

		}else{

			$this->load->view('admin/login');

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