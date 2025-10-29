<?php
 
class Csv_model extends CI_Model {
 
    function __construct() {
        parent::__construct();
 
    }

	//+++++++++++++++++++++++++++
	//UPLOAD CSV FILE
	//++++++++++++++++++++++++++

    function upload_csv() {     
			
			$file = $this->input->post('userfile', TRUE);
			
			//upload file
			$config['upload_path'] = BASE_URL .'assets/documents/csv/';
	        $config['allowed_types'] = 'text/plain|text|csv|csv';
			$config['max_size']	= '8024';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload()){

					$data['error'] =  $this->upload->display_errors();

					 echo "<script>
					$.noty.closeAll()
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				  	noty(options);
					
					</script>";	
					
					return FALSE;  
					
			}else{	
				
				
				$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
				return $config['upload_path'].$file;
			
			}

    }
 
    function insert_csv($data) {
        $this->db->insert('addressbook', $data);
    }
	
	
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//EXPORT
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	function export_subscribers_report()
	{

		$bus_id = $this->session->userdata('bus_id');
		$name = $this->session->userdata('site_title');
		//GET SUBSCRIBERS
		$q = $this->db->query("SELECT subscribers.*, group_concat(subscriber_type.type) as type FROM subscribers 
								LEFT JOIN subscriber_type_int ON subscribers.subscriber_id = subscriber_type_int.subscriber_id
								LEFT JOIN subscriber_type ON subscriber_type.sub_type_id = subscriber_type_int.type_id
								WHERE subscribers.bus_id = '" . $bus_id . "'
								GROUP BY subscribers.subscriber_id
								", false);

		$this->load->helper('csv');
		//var_dump($array);
		echo query_to_csv($q, true, 'subscribers_' . $name . '.csv');
		//echo array_to_csv($array);

	}
	
	
}