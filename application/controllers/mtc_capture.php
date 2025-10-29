<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Mtc_capture extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Mtc_capture()
	{
		parent::__construct();
		//force_ssl();
	}
	 

	function get_roadshow_report() {

		$query = $this->db->query("SELECT * FROM mtc_capture GROUP BY MSISDN ORDER BY listing_date ASC", FALSE);

		$this->load->dbutil();
		$this->load->helper('download');

		$delimiter = ",";
		$newline = "\r\n";

		$data = $this->dbutil->csv_from_result($query, $delimiter, $newline);

		force_download('mtc_roadshow_capture_'.date('dmY').'.csv', $data);

	}
	
	
}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */