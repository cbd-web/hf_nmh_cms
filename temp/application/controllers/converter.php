<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Converter extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Converter()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('converter_model');
		//force_ssl();
	}


	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function index()
	{
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/currency_converter/rates');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	}	

	 //+++++++++++++++++++++++++++
	 //LOAD CALCULATORS VIEW
	 //++++++++++++++++++++++++++
	 public function rates()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/currency_converter/rates');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }	 

	 

	 //+++++++++++++++++++++++++++
	 //ADD RATE
	 //++++++++++++++++++++++++++
	
	 public function add_rate()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->load->view('admin/currency_converter/add_rate');
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 //+++++++++++++++++++++++++++
	 //ADD RATE DO
	 //++++++++++++++++++++++++++
	
	 public function add_rate_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->converter_model->add_rate_do();
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 

	 //+++++++++++++++++++++++++++
	 //UPDATE RATE
	 //++++++++++++++++++++++++++
	
	 public function update_rate($id)
	 {
		  if($this->session->userdata('admin_id')){
			  
		   	   $data = $this->converter_model->get_rate($id);
			   $this->load->view('admin/currency_converter/update_rate', $data);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }
	 
	 	
	 
	 //+++++++++++++++++++++++++++
	 //UPDATE RATE DO
	 //++++++++++++++++++++++++++
	
	 public function update_rate_do()
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $this->converter_model->update_rate_do();
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	 }		  
	 



	//++++++++++++++++++++++++++
	//DELETE CALCULATOR
	//++++++++++++++++++++++++++
	function delete_rate($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->converter_model->delete_rate($id);
						
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }			 


}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */