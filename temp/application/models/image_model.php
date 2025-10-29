<?php
class Image_model extends CI_Model{
	
 	function image_model(){
  		//parent::CI_model();
		//LOAD library
		$this->load->library('image_lib');	
 	}
	
	
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNSIZE THE DRAG N DROP IMAGE UPLOAD
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_image($file, $w = 0, $h = 0){
		
		//error_reporting(E_ALL);
		if($w == 0){
			
			$w = 800;	
			
		}
		if($h == 0){
			
			$h = 1600;	
			
		}	
		
		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => ('./assets/images/' . $file),
		   'master_dim' => 'auto',
		   'width' => $w,
		   'height' => $h,
		   'maintain_ratio' => true
		  ); 
		 
		 ini_set('memory_limit','64M');
		 $this->load->library('image_lib');
		  $this->image_lib->initialize($config); 
		  if ( ! $this->image_lib->resize()) 
		  { 
			 	$data['error'] = $this->image_lib->display_errors();
			   	return $data;
		  } 
		  $this->image_lib->clear(); 
		 return;
		 }	


	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CROP -- 3 IMAGES $ GALLERY (thumb,cubed,original)
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	
	function crop(){
			
			$x = $this->input->post('x');
			$y = $this->input->post('y');
			$pro_id = $this->input->post('pro_id');
			$img_id = $this->input->post('img_id');
			$filename = $this->input->post('filename');
			$gfolder = $this->input->post('gfolder');
			$folder = $this->input->post('folder');
			$targ_w = $this->input->post('targ_w');
			$targ_h = $this->input->post('targ_h');
			$o_wid = $this->input->post('o_wid');
			$o_hei = $this->input->post('o_hei');
			
			$x2 = $this->input->post('x2');
			$y2 = $this->input->post('y2');
			$w = $this->input->post('w');
			$h = $this->input->post('h');
				
				//THE MAGIC

				$configc['image_library'] = 'GD2';
				$configc['source_image'] = './assets/' . $pro_id . '/children/' . $filename ;
				$config['new_image'] = './assets/' . $pro_id . '/children/cover/' . $filename ;
					$configc['create_thumb'] = FALSE;
				$configc['maintain_ratio'] = FALSE;
				$configc['x_axis'] = $x;
				$configc['y_axis'] = $y;
				$configc['width'] = $w;
				$configc['height'] = $h;
	
				  $this->image_lib->initialize($configc); 
				  $this->image_lib->crop();
			
				$this->image_lib->clear();
				
				if ($h > $targ_h){
					
					//$this->downsize_thumb($filename);
				}

			//r$edirect
			return;
		
		}



	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CROP IMAGE
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	function crop_cover_photo(){

		ini_set('memory_limit', '512M');
		$x = $this->input->post('x');
		$y = $this->input->post('y');
		$filename = $this->input->post('path');
		$path = $this->input->post('absolute_path');
		$folder = $this->input->post('folder');
		$targ_w = $this->input->post('targ_w');
		$targ_h = $this->input->post('targ_h');
		$o_wid = $this->input->post('o_wid');
		$o_hei = $this->input->post('o_hei');

		$x2 = $this->input->post('x2');
		$y2 = $this->input->post('y2');
		$w = $this->input->post('w');
		$h = $this->input->post('h');

		//THE MAGIC

		$configc['image_library'] = 'GD2';
		$configc['source_image'] = $path ;
		$config['new_image'] = $path;
		$configc['create_thumb'] = FALSE;
		$configc['maintain_ratio'] = FALSE;
		$configc['x_axis'] = $x;
		$configc['y_axis'] = $y;
		$configc['width'] = $w;
		$configc['height'] = $h;

		$this->image_lib->initialize($configc);
		$this->image_lib->crop();

		$this->image_lib->clear();
		//Downsize
		//$this->downsize_cover($path);

		//r$edirect
		return;

	}



	//downsize image
	function downsize_cover($file){

		$config = array(
			'image_library' => 'GD2',
			'source_image' => $file,
			'master_dim' => 'x',
			'width' => '750',
			'height' => '300',
			'maintain_ratio' => true
		);


		$this->image_lib->initialize($config);
		if ( ! $this->image_lib->resize())
		{
			$data['error'] = $this->image_lib->display_errors();
			return $data;
		}
		$this->image_lib->clear();
		return;
	}

	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CONVERT IMAGE TO JPEG
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	//downsize image
	function convert_jpeg($inputJ, $outputJ){

		$input_file = $inputJ;
		$output_file = $outputJ;

		$input = imagecreatefrompng($input_file);
		list($width, $height) = getimagesize($input_file);
		$output = imagecreatetruecolor($width, $height);
		$white = imagecolorallocate($output,  255, 255, 255);
		imagefilledrectangle($output, 0, 0, $width, $height, $white);
		imagecopy($output, $input, 0, 0, 0, 0, $width, $height);
		imagejpeg($output, $output_file);
		//imagedestroy(base_url('/').'assets/products/images/'.$file);

		if(file_exists($inputJ)){

			unlink( $inputJ);

		}
		return TRUE;

	}





}
?>