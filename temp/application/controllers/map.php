<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Map extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Map()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('map_model');
		//force_ssl();
	}
	
	//+++++++++++++++++++++++++++
	//MAPS
	//++++++++++++++++++++++++++

	public function maps()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/maps/maps');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD MAP
	//++++++++++++++++++++++++++

	public function add_map()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/maps/add_map');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD MAP DO
	//++++++++++++++++++++++++++

	public function add_map_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->map_model->add_map_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//DELETE MAP DO
	//++++++++++++++++++++++++++

	public function delete_map($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->map_model->delete_map($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}		

	
	//+++++++++++++++++++++++++++
	//UPDATE MAP DO
	//++++++++++++++++++++++++++

	public function update_map_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->map_model->update_map_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}					

	 //+++++++++++++++++++++++++++
	 //UPDATE MAP
	 //++++++++++++++++++++++++++
	
	 public function update_map($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $map = $this->map_model->get_map($id);
			   $this->load->view('admin/maps/update_map', $map);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }

	 }

	//+++++++++++++++++++++++++++
	//ADD MARKER
	//++++++++++++++++++++++++++

	public function add_marker($id)
	{
		if($this->session->userdata('admin_id')){

			$data['map_id'] = $id;

			$this->load->view('admin/maps/add_marker', $data);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//ADD MARKER DO
	//++++++++++++++++++++++++++

	public function add_marker_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->map_model->add_marker_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE MARKER
	//++++++++++++++++++++++++++

	public function update_marker($id)
	{
		if($this->session->userdata('admin_id')){

			$marker = $this->map_model->get_marker($id);
			$this->load->view('admin/maps/update_marker', $marker);

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//UPDATE MARKER DO
	//++++++++++++++++++++++++++

	public function update_marker_do()
	{
		if($this->session->userdata('admin_id')){

			$this->map_model->update_marker_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE MARKER
	//++++++++++++++++++++++++++

	public function delete_marker($id, $mid)
	{
		if($this->session->userdata('admin_id')){
			
			$this->map_model->delete_marker($id, $mid);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	

	
	//+++++++++++++++++++++++++++
	//RELOAD MARKERS ALL
	//++++++++++++++++++++++++++

	public function reload_markers_all()
	{
		$this->map_model->get_all_markers();
		
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