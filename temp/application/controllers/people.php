<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class People extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function People()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('people_model');
		//force_ssl();
	}
	
	//+++++++++++++++++++++++++++
	//MEMBERS
	//++++++++++++++++++++++++++

	public function members()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/people/members');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD MEMBER
	//++++++++++++++++++++++++++

	public function add_member()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/people/add_member');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD MEMBER DO
	//++++++++++++++++++++++++++

	public function add_member_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->people_model->add_member_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//DELETE MEMBER DO
	//++++++++++++++++++++++++++

	public function delete_member($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->people_model->delete_member($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}		

	
	//+++++++++++++++++++++++++++
	//UPDATE MEMBER DO
	//++++++++++++++++++++++++++

	public function update_member_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->people_model->update_member_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}					

	 //+++++++++++++++++++++++++++
	 //update member
	 //++++++++++++++++++++++++++
	
	 public function update_member($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $member = $this->people_model->get_member($id);
			   $this->load->view('admin/people/update_member', $member);
		   
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
			
			$this->load->view('admin/people/categories');
			
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
			
			$this->people_model->add_category();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD CATEGORY MEMBER
	//++++++++++++++++++++++++++

	public function add_category_member()
	{
		if($this->session->userdata('admin_id')){
			
			$this->people_model->add_category_member();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	

	//+++++++++++++++++++++++++++
	//DELETE CATEGORY MEMBER
	//++++++++++++++++++++++++++

	public function delete_category_member($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->people_model->delete_category_member($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY MEMBERS
	//++++++++++++++++++++++++++

	public function reload_category_members($people_id)
	{
		$this->people_model->get_categories_current($people_id);
		
	}	
	
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY
	//++++++++++++++++++++++++++

	public function delete_category($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->people_model->delete_category($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->people_model->get_all_categories();
		
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