<?php
class Upload_model extends CI_Model{
	
 	function upload_model(){
  		//parent::CI_model();
		//LOAD library
		//$this->load->library('image_lib');
 	}
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function add_featured_image($data){

		$img = $this->input->post('userfile', true);
		$id = $this->input->post('type_id', true);
		$type = $this->input->post('type', true);
		$bus_id = $this->input->post('bus_id', true);
		//LOAD library
		$this->load->library('image_lib');

		$dim = getimagesize($data['upload_url']);

		if (($dim[0] > 1950) || ($dim[1] > 900))
		{

			$this->load->model('image_model');
			$this->image_model->downsize_image($data['upload_url'], '1800', '1000');

		}

		//populate array with values
		$data1 = array(
			'img_file' => $data['name'],
			'bus_id'   => $bus_id,
			'type'     => $type,
			'type_id'  => $id
		);

		$this->db->insert('images', $data1);

		$item_id = $this->db->insert_id();

		$data['filename'] = $data['name'];
		$data['width'] = $dim[0];
		$data['height'] = $dim[1];
		$data['image'] = $data['upload_url'];
		//redirect
		$data['basicmsg'] = 'Image added successfully!';

		return json_encode($data);

	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function add_document($data){


		$id = $this->input->post('type_id', true);
		$type = $this->input->post('type', true);
		$bus_id = $this->input->post('bus_id', true);

		//populate array with values
		$data1 = array(
			'project_id'  => 0,
			'doc_file'    => $data['name'],
			'title'       => $data['name'],
			'bus_id'      => $bus_id,
			'description' => '',
			'extension'   => $data['ext']

		);
		//insert into database
		$this->db->insert('documents', $data1);
		//$doc_id = $this->db->insert_id();

		$item_id = $this->db->insert_id();

		$data['filename'] = $data['name'];

		$data['image'] = $data['upload_url'];
		//redirect
		$data['basicmsg'] = 'Document added successfully!';

		return json_encode($data);

	}

}
?>