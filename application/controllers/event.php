<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Event extends CI_Controller {


	 function event()
	{
		parent::__construct();
		$this->load->model('event_model');

		//force_ssl();
	}

	//+++++++++++++++++++++++++++
	//EVENTS
	//++++++++++++++++++++++++++

	public function events()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/events/events');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD EVENT
	//++++++++++++++++++++++++++

	public function add_event()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/events/add_event');

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//ADD EVENT DO
	//++++++++++++++++++++++++++

	public function add_event_do()
	{
		if($this->session->userdata('admin_id')){

			$this->event_model->add_event_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE EVENT DO
	//++++++++++++++++++++++++++

	public function delete_event($id)
	{
		if($this->session->userdata('admin_id')){

			$this->event_model->delete_event($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE EVENT DO
	//++++++++++++++++++++++++++

	public function update_event_do()
	{
		if($this->session->userdata('admin_id')){

			$this->event_model->update_event_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//update event
	//++++++++++++++++++++++++++

	public function update_event($id)
	{
		if($this->session->userdata('admin_id')){

			$event = $this->event_model->get_event($id);
			$this->load->view('admin/events/update_event', $event);

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

			$this->load->view('admin/events/categories');

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

			$this->event_model->add_category();

		}else{

			$this->load->view('admin/login');

		}

	}

	public function add_event_category()
	{
		if($this->session->userdata('admin_id')){

			$this->event_model->add_event_category();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE CATEGORY MEMBER
	//++++++++++++++++++++++++++

	public function delete_category_event($id)
	{
		if($this->session->userdata('admin_id')){

			$this->event_model->delete_category_event($id);

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

			$this->event_model->delete_category($id);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->event_model->get_all_categories();

	}

	public function reload_category_events($event_id)
	{
		$this->event_model->get_categories_current($event_id);

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



/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */