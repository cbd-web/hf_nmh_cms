<?php
class Twitter extends CI_Controller {

	public function __construct()
	{

		parent::__construct();
		$this->load->model('twitter_model');

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function get_twitter(){

		$this->twitter_model->get_twitter();


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function get_twitter_timeline(){

		$this->twitter_model->get_twitter_timeline();


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//GET
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function get_twitter_v2(){

		$this->twitter_model->get_twitter_v2();

	}





}