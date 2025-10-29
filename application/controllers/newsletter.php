<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Newsletter extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Newsletter()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('newsletter_model');
		//force_ssl();
	}
	
	//+++++++++++++++++++++++++++
	//MEMBERS
	//++++++++++++++++++++++++++

	public function newsletters()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/mcn_newsletter/newsletters');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//ADD NEWSLETTER
	//++++++++++++++++++++++++++

	public function add_newsletter()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/mcn_newsletter/add_newsletter');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}

	
	//+++++++++++++++++++++++++++
	//ADD NEWSLETTER DO
	//++++++++++++++++++++++++++
	public function add_newsletter_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->newsletter_model->add_newsletter_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}


	//+++++++++++++++++++++++++++
	//ADD PARAGRAPH DO
	//++++++++++++++++++++++++++
	public function add_paragraph_do()
	{
		if($this->session->userdata('admin_id')){

			$this->newsletter_model->add_paragraph_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE NEWSLETTER DO
	//++++++++++++++++++++++++++

	public function delete_newsletter($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->newsletter_model->delete_newsletter($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}

	//+++++++++++++++++++++++++++
	//DELETE NEWSLETTER DO
	//++++++++++++++++++++++++++

	public function delete_paragraph($id)
	{
		if($this->session->userdata('admin_id')){

			$this->newsletter_model->delete_paragraph($id);

		}else{

			$this->load->view('admin/login');

		}

	}

	
	//+++++++++++++++++++++++++++
	//UPDATE NEWSLETTER DO
	//++++++++++++++++++++++++++

	public function update_newsletter_do()
	{
		if($this->session->userdata('admin_id')){
			
			$this->newsletter_model->update_newsletter_do();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}					

	 //+++++++++++++++++++++++++++
	 //update newsletter
	 //++++++++++++++++++++++++++
	
	 public function update_newsletter($id)
	 {
		  if($this->session->userdata('admin_id')){
		   
			   $data = $this->newsletter_model->get_newsletter($id);
			   $this->load->view('admin/mcn_newsletter/update_newsletter', $data);
		   
		  }else{
		   
		   		$this->load->view('admin/login');
		   
		  }
	  
	  
	 }



	//+++++++++++++++++++++++++++
	//UPDATE PARAGRAPH DO
	//++++++++++++++++++++++++++

	public function update_paragraph_do()
	{
		if($this->session->userdata('admin_id')){

			$this->newsletter_model->update_paragraph_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	//+++++++++++++++++++++++++++
	//update paragraph
	//++++++++++++++++++++++++++

	public function update_paragraph($id)
	{
		if($this->session->userdata('admin_id')){

			$data = $this->newsletter_model->get_paragraph($id);
			$this->load->view('admin/mcn_newsletter/update_paragraph', $data);

		}else{

			$this->load->view('admin/login');

		}


	}
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY MEMBERS
	//++++++++++++++++++++++++++

	public function reload_paragraphs($id)
	{
		$this->newsletter_model->get_all_paragraphs($id);
		
	}


	public function add_news_image()
	{
		if($this->session->userdata('admin_id')){

			$this->newsletter_model->add_news_image();

		}else{

			redirect(site_url('/').'admin/logout');

		}


	}


	public function remove_news_image($type, $id)
	{

		$this->db->where('paragraph_id', $id);
		$query = $this->db->get('mcn_paragraphs');

		if($query->result()){

			$row = $query->row_array();

			$file =  BASE_URL.'assets/images/' . $row[$type]; # build the full path

			if (file_exists($file)) {
				unlink($file);
			}

			$data = array(
				$type => ''
			);


			$this->db->where('paragraph_id', $id);
			$this->db->update('mcn_paragraphs', $data);
			echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'Image removed.','layout':'bottomLeft','type':'success'};
					  noty(options);

					  </script>";


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