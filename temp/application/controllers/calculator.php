<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Calculator extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Calculator()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('calculator_model');
		//force_ssl();
	}


	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function index()
	{
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/calculators/calculators');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	}	

	 //+++++++++++++++++++++++++++
	 //LOAD CALCULATORS VIEW
	 //++++++++++++++++++++++++++
	 public function calculators()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/calculators/calculators');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }	 


	 //+++++++++++++++++++++++++++
	 //ADD FEE
	 //++++++++++++++++++++++++++
	
	 public function add_fee()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->calculator_model->add_fee();
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }		 

	 //+++++++++++++++++++++++++++
	 //ADD CALCULATOR
	 //++++++++++++++++++++++++++
	
	 public function add_calculator()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/calculators/add_calculator');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //ADD CALCULATOR
	 //++++++++++++++++++++++++++
	
	 public function add_calculator_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->calculator_model->add_calculator_do();
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }	
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE CALCULATOR DO
	 //++++++++++++++++++++++++++
	
	 public function update_calculator_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->calculator_model->update_calculator_do();
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }		  
	 

	 //+++++++++++++++++++++++++++
	 //UPDATE BOND CALC
	 //++++++++++++++++++++++++++
	
	 public function update_calc_bond_costs($id, $type)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $calc = $this->calculator_model->get_calculator($id, $type);
			   $this->load->view('admin/calculators/update_calc_bond_costs', $calc);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }	
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE TRANSFER CALC
	 //++++++++++++++++++++++++++
	
	 public function update_calc_transfer_costs($id, $type)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $calc = $this->calculator_model->get_calculator($id, $type);
			   $this->load->view('admin/calculators/update_calc_transfer_costs', $calc);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }	
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE MEMEBR INTEREST CALC
	 //++++++++++++++++++++++++++
	
	 public function update_calc_member_interest($id, $type)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $calc = $this->calculator_model->get_calculator($id, $type);
			   $this->load->view('admin/calculators/update_calc_member_interest', $calc);
		   
		  }else{
		   
		   	   $this->load->view('admin/login');
		   
		  }
	 }		 	   	


	//+++++++++++++++++++++++++++
	//DELETE CALCULATOR
	//++++++++++++++++++++++++++
	function delete_calculator($id, $type){
      	
		if($this->session->userdata('admin_id')){
					
			$this->calculator_model->delete_calculator($id, $type);
						
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }			 


	//+++++++++++++++++++++++++++
	//RELOAD FEES
	//++++++++++++++++++++++++++

	public function reload_fees($id, $type)
	{
		$this->calculator_model->get_all_fees($id, $type);
		
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