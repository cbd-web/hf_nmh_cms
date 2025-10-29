<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Tools extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function __construct()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('converter_model');
		//force_ssl();
	}


	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function update_subscribers()
	{
		  //$test = $this->db->where('bus_id', 453);
		 // $test = $this->db->where('bus_id', 453);
		  $test = $this->db->query('SELECT subscribers.*,subscriber_type_int.type_id  FROm subscribers
									LEFT JOIN subscriber_type_int ON subscriber_type_int.subscriber_id = subscribers.subscriber_id
									WHERE subscribers.bus_id = 453
									');
		  $x = 0;
		  if($test->result()){
			  
				foreach($test->result() as $row){
					
					if($row->type_id == null){
						
						$insert['bus_id'] = 453;
						$insert['subscriber_id'] = $row->subscriber_id;
						$insert['type_id'] = 140;
						$insert['type_name'] = 'subscribers';
						$this->db->insert('subscriber_type_int', $insert);
						$x ++;
					}
					
				}
				  
		  }
		  echo $x.' records';
	}	

	 


}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */