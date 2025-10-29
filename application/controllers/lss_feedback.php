<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Lss_feedback extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Lss_feedback()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('lss_feedback_model');
		//force_ssl();
	}
	

	 function csv_dump() {

		 $type = $this->input->post('type', TRUE);

		 $bus_id = $this->session->userdata('bus_id');

		 if($type == 'crewing') {

			 $query = $this->db->query("SELECT name, company, phone, email, crew_1 AS answer_1, crew_2 AS answer_2, crew_3 AS answer_3, crew_4 AS answer_4, crew_5 AS answer_5, crew_6 AS answer_6, crew_7 AS answer_7, crew_8 AS answer_8  FROM lss_feedback2 WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);

		 }

		 if($type == 'procurement') {

			 $query = $this->db->query("SELECT name, company, phone, email, procure_1 AS answer_1, procure_2 AS answer_2, procure_3 AS answer_3, procure_4 AS answer_4, procure_5 AS answer_5, procure_6 AS answer_6 FROM lss_feedback2 WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);

		 }

		 if($type == 'vessel') {

			 $query = $this->db->query("SELECT name, company, phone, email, va_1 AS answer_1, va_2 AS answer_2, va_3 AS answer_3, va_4 AS answer_4, va_5 AS answer_5, va_6 AS answer_6, va_7 AS answer_7 FROM lss_feedback2 WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);

		 }

		 if($type == 'warehousing') {

			 $query = $this->db->query("SELECT name, company, phone, email, warehouse_1 AS answer_1, warehouse_2 AS answer_2, warehouse_3 AS answer_3 FROM lss_feedback2 WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);

		 }

		 if($type == 'financing') {

			 $query = $this->db->query("SELECT name, company, phone, email, finance_1 AS answer_1, finance_2 AS answer_2, finance_3 AS answer_3 FROM lss_feedback2 WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);

		 }

		 if($type == 'all') {

			 $query = $this->db->query("SELECT * FROM lss_feedback2 WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);

		 }

		 $this->load->dbutil();
		 $this->load->helper('download');

		 $delimiter = ",";
		 $newline = "\r\n";

		 $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);

		 force_download('Lss_Feedback_'.$type.'_'.date('d.m.Y').'.csv', $data);

	 }

	 //+++++++++++++++++++++++++++
	 //LOAD FEEDBACK VIEW
	 //++++++++++++++++++++++++++
	 public function feedback()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/lss_feedback/feedback');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	   	
	
	
	//+++++++++++++++++++++++++++
	//UPDATE VACANCY DO
	//++++++++++++++++++++++++++	
	function view_feedback($id)
	{
		$data = $this->lss_feedback_model->get_feedback_result($id);
		
		$this->load->view('admin/lss_feedback/view_feedback', $data);
	}
	

	//+++++++++++++++++++++++++++
	//DELETE FEEDBACK DO
	//++++++++++++++++++++++++++
	function delete_feedback($feedback_id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->lss_feedback_model->delete_feedback_do($feedback_id);
						
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
	//+++++++++++++++++++++++++++
	//ACTION FEEDBACK DO
	//++++++++++++++++++++++++++
	function action_feedback($feedback_id, $status){
      	
		if($this->session->userdata('admin_id')){
					
			$this->lss_feedback_model->action_feedback_do($feedback_id, $status);
						
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
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