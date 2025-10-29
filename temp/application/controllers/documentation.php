<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Documentation extends CI_Controller {

	/**
	 * CSV CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
 	function __construct() {
        parent::__construct();

	    //force_ssl();
    }
 
    function index() {
      
	  	$this->load->view('help/home');
	  
    }


	function users() {

		$this->load->view('help/users');

	}

	function categories() {

		$this->load->view('help/categories');

	}

	function dashboard() {

		$this->load->view('help/dashboard');

	}

	function documents() {

		$this->load->view('help/documents');

	}

	function images() {

		$this->load->view('help/images');

	}

	function menu() {

		$this->load->view('help/menu');

	}

	function news() {

		$this->load->view('help/news');

	}

	function pages() {

		$this->load->view('help/pages');

	}

	function sliders() {

		$this->load->view('help/sliders');

	}

}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */