<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Magnet_members extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Magnet_members()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('magnet_member_model');
		//force_ssl();
	}
	

	 

	 //+++++++++++++++++++++++++++
	 //LOAD MEMBER VIEW
	 //++++++++++++++++++++++++++
	 public function members()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/magnet_members/members');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }
	   	
	
	
	//+++++++++++++++++++++++++++
	//VIEW MEMBER
	//++++++++++++++++++++++++++	
	function view_member($id)
	{
		$data = $this->magnet_member_model->get_member_result($id);
		
		$this->load->view('admin/magnet_members/view_member', $data);
	}
	

	//+++++++++++++++++++++++++++
	//UPDATE MEMBER
	//++++++++++++++++++++++++++
	function update_member_do(){
      	
		if($this->session->userdata('admin_id')){
					
			$this->magnet_member_model->update_member_do();
						
		} else {
			
			redirect(site_url('/').'admin/logout/','refresh');

		}
    }

	//+++++++++++++++++++++++++++
	//DELETE MEMBER
	//++++++++++++++++++++++++++
	function delete_member($id){
      	
		if($this->session->userdata('admin_id')){
					
			$this->magnet_member_model->delete_member_do($id);
						
		} else {
			
			redirect(site_url('/').'admin/logout/','refresh');

		}
    }
	
	//+++++++++++++++++++++++++++
	//ACTION MEMBER DO
	//++++++++++++++++++++++++++
	function action_member($id, $status){
      	
		if($this->session->userdata('admin_id')){

			$this->magnet_member_model->action_member_do($id, $status);

		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
    }
	
			
	//+++++++++++++++++++++++++++
	//SEND MEMBER DETAILS
	//++++++++++++++++++++++++++
	function send_details($id){
      	
		if($this->session->userdata('admin_id')){

			$this->magnet_member_model->send_details_do($id);

		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
    }
	
	//+++++++++++++++++++++++++++
	//UPDATE PASSWORD
	//++++++++++++++++++++++++++
	function update_password(){
      	
		if($this->session->userdata('admin_id')){

			$this->magnet_member_model->update_password_do();

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