<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Upload extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('upload_model');
		$this->load->database();
	}

	function index()
	{
		error_reporting(E_ALL | E_STRICT);

		$data['type'] = 'image';
		$data['file_type'] = 'gif|jpe?g|png';
		$data['path'] = 'images/';
		$data['size'] = '100';
		$data['w'] = '100';
		$data['h'] = '100';
		//GET PATH OF UPLOAD
		if($path = $this->input->get('path')){

			$data['path'] = $path;

		}

		//GET SIZE OF UPLOAD
		if($size = $this->input->get('size')){

			$data['size'] = $size;

		}
		//GET TYPE OF UPLOAD
		if($data['file_type'] = $this->input->get('file_type')){


		}
		//GET SIZE OF UPLOAD
		if($data['w'] = $this->input->get('w')){

		}
		//GET SIZE OF UPLOAD
		if($data['h'] = $this->input->get('h')){

		}



		$option = array(

			'upload_dir' => BASE_URL.$data['path'],
			'upload_url' => base_url('/').$data['path'],

		);

		//if(isset($files['files'][0])){
			//GET THUMBNAIL
			if($data['thumb'] = $this->input->get('thumb')){

				$option['image_versions']['thumbnail'] = array(

					'max_width' => $data['thumb'] ,
					'max_height' => $data['thumb'],
					'crop' => true
				);

			}

			$result = $this->load->library("UploadHandler", $option);

			$files = $this->uploadhandler->response;

			$file = $files['files'][0]->name;
			$size = $files['files'][0]->size;
			$vtype = $files['files'][0]->type;

			var_dump($files);
 		die();

			//var_dump($_FILES);
			if(isset($files) && count($files) > 0 ){

				//populate array with values
				$name = $files['files'][0]->name;
				//CLEAN and UNIQUE
				//$data['name1'] = trim(basename(stripslashes($name)), ".\x00..\x20");
				$data['clean'] = preg_replace('/\\.[^.\\s]{3,4}$/', '', $name);
				$data['ext'] = pathinfo($name, PATHINFO_EXTENSION);
				//$data['name'] = md5($data['clean'].date('y-m-d h:i:s')).'.'.$data['ext'];
				$data['name'] = $name;
				$data['upload_url'] = $option['upload_url'].$data['name'];
				//echo json_encode($data);
				//GET TYPE OF UPLOAD
				if($type = $this->input->get('upload_type')){

					//FEATURED IMAGE
					if($type == 'featured_image' || $type == 'gallery_image'){

						$this->upload_model->add_featured_image($data);
						$s3path = 'assets/images/'.$data['name'];

					}
					//FEATURED IMAGE
					if($type == 'document'){

						$this->upload_model->add_document($data);
						$s3path = 'assets/documents/'.$data['name'];

					}
					//echo $data['name']. ' '.$option['upload_dir'];
					//UPLOAD S3
					/*$this->load->model('sync_model');
					if($this->sync_model->upload_s3($s3path)){

						//$out .= ' >> Image Uploaded to S3! ';

					}else{

						//$out .= ' << Image NOT Uploaded to S3! ';

					}*/


				}




			}



		//}//end file is set

		//var_dump($files);

	}
}