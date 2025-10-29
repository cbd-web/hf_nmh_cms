<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Vacancy extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Vacancy()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('vacancy_model');
		//force_ssl();
	}


	function upload_potentia() {

		$this->vacancy_model->upload_potentia();


	}


	//+++++++++++++++++++++++++++
	//RESET PASSWORD
	//++++++++++++++++++++++++++
	public function reset_profile_password()
	{

		$this->vacancy_model->reset_profile_password();

	}


	//+++++++++++++++++++++++++++
	//UPDATE STATUS
	//++++++++++++++++++++++++++

	public function update_status()
	{
		if($this->session->userdata('admin_id')){

			$this->vacancy_model->update_status();

		}else{

			$this->load->view('admin/login');

		}
	}




	//+++++++++++++++++++++++++++
	//Dump Applicants
	//++++++++++++++++++++++++++

	public function dump_applicants()
	{
		if($this->session->userdata('admin_id')){

			$this->vacancy_model->dump_applicants();

		}else{

			$this->load->view('admin/login');

		}
	}


	//+++++++++++++++++++++++++++
	//VIEW VACANCY APPLICANT
	//++++++++++++++++++++++++++

	public function filter_applicants()
	{
		if($this->session->userdata('admin_id')){

			$this->vacancy_model->filter_applicants();

		}else{

			$this->load->view('admin/login');

		}
	}


	 //+++++++++++++++++++++++++++
	 //VIEW VACANCY APPLICANT
	 //++++++++++++++++++++++++++
	
	 public function view_applicant($id)
	 {
		  if($this->session->userdata('admin_id')){
		   		
			   $applicant = $this->vacancy_model->get_applicant($id);
			   $this->load->view('admin/vacancies/view_applicant', $applicant);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }


	 //+++++++++++++++++++++++++++
	 //LOAD APPLICANTS VIEW
	 //++++++++++++++++++++++++++
	 public function applicants()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/vacancies/applicants');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 
	//+++++++++++++++++++++++++++
	//DELETE APPLICANT DO
	//++++++++++++++++++++++++++
	function delete_applicant($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->vacancy_model->delete_applicant_do($id);
						
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }		 
	 

	 //+++++++++++++++++++++++++++
	 //LOAD VACANCIES VIEW
	 //++++++++++++++++++++++++++
	 public function vacancies()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/vacancies/vacancies');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD ADD VACANCY VIEW
	 //++++++++++++++++++++++++++
	
	 public function add_vacancy()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/vacancies/add_vacancy');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 

	 //+++++++++++++++++++++++++++
	 //LOAD UPDATE VACANCY VIEW
	 //++++++++++++++++++++++++++
	
	 public function update_vacancy($vacancy_id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $vacancy = $this->vacancy_model->get_vacancy($vacancy_id);
			   $this->load->view('admin/vacancies/update_vacancy', $vacancy);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }	  	


	//+++++++++++++++++++++++++++
	//GET APPLICANT DUMP
	//++++++++++++++++++++++++++	
	function get_applicant_dump($id)
	{
		$this->vacancy_model->get_applicant_dump($id);
	}

	//+++++++++++++++++++++++++++
	//ADD VACANCY DO
	//++++++++++++++++++++++++++	
	function add_vacancy_do()
	{
		$this->vacancy_model->add_vacancy_do();
	}
	
	
	//+++++++++++++++++++++++++++
	//UPDATE VACANCY DO
	//++++++++++++++++++++++++++	
	function update_vacancy_do()
	{
		$this->vacancy_model->update_vacancy_do();
	}
	

	//+++++++++++++++++++++++++++
	//DELETE VACANCY DO
	//++++++++++++++++++++++++++
	function delete_vacancy($vacancy_id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->vacancy_model->delete_vacancy_do($vacancy_id);
						
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }	

	//+++++++++++++++++++++++++++
	//GET SUB CATEGORY SELECT
	//++++++++++++++++++++++++++	
	function get_sub_category_select($id) {		
		
		$this->vacancy_model->get_sub_categories_select($id);

	}
	
	//+++++++++++++++++++++++++++
	//GET SUB SUB CATEGORY SELECT
	//++++++++++++++++++++++++++	
	function get_sub_sub_category_select($id) {		
		
		$this->vacancy_model->get_sub_sub_categories_select($id);

	}			 


	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function add_featured_image()
	{
		if($this->session->userdata('admin_id')){
			
			$this->vacancy_model->add_featured_image();
			
		}else{
			
			redirect(site_url('/').'admin/logout');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function remove_featured_image($id)
	{
		$this->vacancy_model->remove_featured_image($id);
	}
	
	//+++++++++++++++++++++++++++
	//ADD FEATURED DOCUMENT
	//++++++++++++++++++++++++++

	public function add_featured_document()
	{
		if($this->session->userdata('admin_id')){
			
			$this->vacancy_model->add_featured_document();
			
		}else{
			
			redirect(site_url('/').'admin/logout');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	public function remove_featured_document($id)
	{
		$this->vacancy_model->remove_featured_document($id);
	}
	
	//+++++++++++++++++++++++++++
	//CATEGORIES
	//++++++++++++++++++++++++++

	public function categories()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/vacancies/categories');
			
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
			
			$this->vacancy_model->add_category();
			
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
			
			$this->vacancy_model->delete_category($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category_all()
	{
		$this->vacancy_model->get_all_categories();
		
	}

	//+++++++++++++++++++++++++++
	//RELOAD Applicants
	//++++++++++++++++++++++++++

	public function reload_apps($id)
	{
		$this->vacancy_model->get_applications($id);

	}
	
	
	
	//+++++++++++++++++++++++++++
	//DISCIPLINES
	//++++++++++++++++++++++++++

	public function disciplines()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/vacancies/disciplines');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	

	//+++++++++++++++++++++++++++
	//ADD DISCIPLINE
	//++++++++++++++++++++++++++

	public function add_discipline()
	{
		if($this->session->userdata('admin_id')){
			
			$this->vacancy_model->add_discipline();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	

	//+++++++++++++++++++++++++++
	//DELETE DISCIPLINE
	//++++++++++++++++++++++++++

	public function delete_discipline($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->vacancy_model->delete_discipline($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}	
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_discipline_all()
	{
		$this->vacancy_model->get_all_disciplines();
		
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