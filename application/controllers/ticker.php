<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Ticker extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Ticker()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('ticker_model');
		//force_ssl();
	}
	 

	 //+++++++++++++++++++++++++++
	 //LOAD VACANCIES VIEW
	 //++++++++++++++++++++++++++
	 public function news_ticker()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/ticker/ticker');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	 	
	//+++++++++++++++++++++++++++
	//update Ticker sequence
	//++++++++++++++++++++++++++

	public function update_ticker_sequence($ticker_id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('ticker_id' , $ticker_id);
			$this->db->update('news_ticker', $data);

		
	}	
	
	
	//+++++++++++++++++++++++++++
	//TICKER ADD 
	//++++++++++++++++++++++++++
	
	function add_ticker_do(){
		
		$this->ticker_model->add_ticker_do();

	}
	
	

	//GET TICKER FOR EDIT
	function get_ticker($id){

		$this->ticker_model->get_ticker($id);
		
	}
	
	//+++++++++++++++++++++++++++
	//UPDATE TICKER
	//++++++++++++++++++++++++++	
	function update_ticker_do(){
			
		$this->ticker_model->update_ticker_do();

	}
	
	//+++++++++++++++++++++++++++
	//DELETE TICKER
	//++++++++++++++++++++++++++

	public function delete_ticker($id)
	{
		$this->db->where('ticker_id', $id);
		$this->db->delete('news_ticker');
		//LOG
		$this->admin_model->system_log('delete-ticker'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted entry');	
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