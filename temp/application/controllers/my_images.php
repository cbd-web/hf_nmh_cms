<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class My_images extends CI_Controller {
	/**
	 OWNERS
	 */
	function my_images()
	{
		parent::__construct();
		$this->load->model('image_model');
		$this->load->library('encrypt');
		//force_ssl();
	}

	public function index()
	{
		echo 'Going Nowhere slowly!';
		
	}

   function UploudToNMHS3($fileURL, $S3Dir, $filename_Plus_Extension)
	{
		$query =   http_build_query(array(
			'fileURL' => $fileURL,
			'S3Dir' => $S3Dir,
			'filename_Plus_Extension' => $filename_Plus_Extension,
			'SecretKey' => 'NMHServer123FilesAKIA44MUTREB73NBQLK7'
		));

		$ch    = curl_init('https://cdn.nmh.com.na:2083/api/Upload' . '?' . $query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		$response = curl_exec($ch);
		return json_decode($response);
	}


	public function edit($img = '')
	{


		$this->load->library('user_agent');
		$img = rawurldecode($this->encrypt->decode($img,  $this->config->item('encryption_key')));

		//GET CURRENT URL
		$data['url'] = $this->agent->referrer();
		//BUILD ABSOLUTE PATH
		$data['absolute_path'] = BASE_URL.$img;
		//Get Image path
		$data['folder'] = substr($img, 0 , (strlen($img) - strlen(basename($img))));
		$data['path'] = base_url('/').$img;

		//GET IMAGE DIMENSIONS ETC
		list($data['width'], $data['height'], $data['type'], $data['attr']) = getimagesize(base_url('/') . $img);


		$data['filename'] =	$img;
		$data['img'] = $img;
		$this->load->view('admin/images/update_image', $data);
		//var_dump($data);
	}

	
    //ADD IMAGE FROM REDACTOR
	function redactor_add_image()
	{
		$bus_id = $this->session->userdata('bus_id'); 
		//$file = $_POST['redactor_file'];
		$img = $this->input->post('file', TRUE);
		
		if(isset($_FILES['file']['name'])){
			
				   $_FILES['userfile']['name']    = $_FILES['file']['name'];
				   $_FILES['userfile']['type']    = $_FILES['file']['type'];
				   $_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
				   $_FILES['userfile']['error']       = $_FILES['file']['error'];
				   $_FILES['userfile']['size']    = $_FILES['file']['size'];
				
				
		}
			//upload file

			$config['upload_path'] = BASE_URL.'assets/images/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';

			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					//$data['pro_id'] = $pro_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'{ "filelink": "error" }'; 
					//$this->output->set_header("HTTP/1.0 403 ERROR");
					
			}	
			else
			{	
			
			
			//$file = array('upload_data'
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   	//delete old photo
			//$this->delete_old_child_photo($child_id,$pro_id);
			//$this->update_cover_book_image($child_id,$pro_id,$file);
					  
				if (($width > 1200) || ($height > 1400)){
 
					    //$this->image_model->downsize_image($file);
								
				}

				//$this->load->model('s3_model');
				//$this->s3_model->upload_s3('assets/images/' . $file);

				$cdn = $this->UploudToNMHS3(base_url('assets/images/' . $file), 'mynamibia-eu/cms/assets/images', $file, false);
				$file2 = str_replace('https://cdn.nmh.com.na:2083/S3Server/mynamibia-eu/cms/assets/images/', '', $cdn->filePath);

 
				 //populate array with values
				$insertdata = array(
					
					'type' => 'img',
					'img_file' => $file2,
					'bus_id'=> $bus_id 

        		);
				//insert into database
				
				$this->db->insert('images',$insertdata);
				
			   	$data['filename'] = $file;
				
				$image = S3_URL . 'assets/images/'.$file2;
			   //redirect 
			    echo '{"filelink": "'.$image.'"}';
				exit;
		}	
		
	}


	 //+++++++++++++++++++++++++++
	//UPLOAD DOCUMENTS
	//++++++++++++++++++++++++++
	
	function redactor_add_file()
	{
		 	$bus_id = $this->session->userdata('bus_id'); 
			//$file = $_POST['redactor_file'];
			$img = $this->input->post('file', TRUE);
			//upload file

			$config['upload_path'] = './assets/documents/';
			$config['allowed_types'] = 'doc|docx|pdf|ppt|pptx|xls|xlsx';

			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					//$data['pro_id'] = $pro_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'{ "filelink": "" }'; 
					//$this->output->set_header("HTTP/1.0 403 ERROR");
					
			}	
			else
			{
			
			
			//$file = array('upload_data'
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$oname =  $this->upload->orig_name;
	
			//$this->load->model('s3_model');
			//$this->s3_model->upload_s3('assets/documents/' . $file);

            $cdn = $this->UploudToNMHS3(base_url('assets/documents/' . $file), 'mynamibia-eu/cms/assets/documents', $file, false);
            //$file = str_replace('https://cdn.nmh.com.na:2083/S3Server/mynamibia-eu/cms/assets/documents/', '', $cdn->filePath);			

 
				 //populate array with values
				$insertdata = array(
					
					'title' => $oname,
					'doc_file' => $file,
					'bus_id'=> $bus_id 

        		);
				//insert into database
				
				$this->db->insert('documents',$insertdata);
				
			   	$data['filename'] = $file;
				
				$doc = base_url('/') . 'assets/documents/'.$file;
			   //redirect 
			    echo '{"filelink": "'.$doc.'"}';
				exit;
		}	
	}
	

/**
++++++++++++++++++++++++++++++++++++++++++++
//
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
GALLERY 	
++++++++++++++++++++++++++++++++++++++++++++
//
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
*/
function add_gallery(){
	
	 $this->load->library('upload');  // NOTE: always load the library outside the loop
	 $child_id = $this->input->post('child_id', TRUE);
	 $story_id = $this->input->post('story_id1', TRUE);
	 $pro_id = $this->input->post('pro_id', TRUE);
	 $this->total_count_of_files = count($_FILES['files']['name']);
	 /*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */
	
	 for($i=0; $i<$this->total_count_of_files; $i++)
	 {
	
	   $_FILES['userfile']['name']    = $_FILES['files']['name'][$i];
	   $_FILES['userfile']['type']    = $_FILES['files']['type'][$i];
	   $_FILES['userfile']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
	   $_FILES['userfile']['error']       = $_FILES['files']['error'][$i];
	   $_FILES['userfile']['size']    = $_FILES['files']['size'][$i];
	
	   
	   $config['upload_path'] = './assets/' . $pro_id . '/children/';
	   $config['allowed_types'] = 'jpg|jpeg|gif|png';
	   $config['overwrite']     = FALSE;
	   $config['max_size']	= '0';
	   $config['max_width']  = '8324';
	   $config['max_height']  = '8550';
	   $config['min_width']  = '200';
	   $config['min_height']  = '200';
	   $config['remove_spaces']  = TRUE;
	   $config['encrypt_name']  = TRUE;
	   
	
	  $this->upload->initialize($config);
	
		  if($this->upload->do_upload())
		  {
			//$file = array('upload_data'
			  $data = array('upload_data' => $this->upload->data());
			  $file =  $this->upload->file_name;
			  $width = $this->upload->image_width;
			  $height = $this->upload->image_height;	
			  //delete old photo
			  //$this->delete_old_child_photo($child_id,$pro_id);
			  //$this->update_pro_book_image($child_id,$pro_id,$file);
					   
				  if (($width > 850) || ($height > 700)){
						  
						  $this->load->model('gallery_model');
						  $str = 'children';	 
						  $this->gallery_model->downsize_image($file,$pro_id,$str);
								  
				  }
  					
  				  
				  //populate array with values
				  $data = array(
					  'child_id' => $child_id,
					  'story_id' => $story_id,  
					  'img_file'=> $file
				   
				  );
				  //IF NEW LS
				  if($story_id == '0'){
				 
					  //insert into database
					  
					  $this->db->insert('gallery_images',$data);
				  }else{
					  
					  $this->db->insert('gallery_images',$data);
				  }
				  //load respective view 
				 $data['pro_id'] = $pro_id;
				 
				 //crop 
				  $data['filename'] = $file;
				  $data['width'] = $this->upload->image_width;
				  $data['height'] = $this->upload->image_height;
				  $data['info'] = $this->owner_model->get_child($child_id);
				  $data['parents'] = $this->owner_model->get_parents($pro_id);
				  $image = base_url('/') . 'assets/' . $pro_id.'/children/'.$file;
				 //redirect 
				  $data['basicmsg'] = 'Photo added successfully!';
				  echo '<div class="alert alert-success">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  '. $data['basicmsg'].'
					   </div>
					   <script type="text/javascript">
					  
					   show_gallery('.$story_id.');
					   </script>
					   ';
				  //$this->output->set_header("HTTP/1.0 200 OK");
				  exit;
			
		  }else{
			//ERROR
				$data['pro_id'] = $pro_id;
				$data['error'] =  $this->upload->display_errors();
				echo 
				'<div class="alert alert-error">
				<button type="button" class="close" data-dismiss="alert">×</button>'
				 . $data['error'].'
				 </div><script type="text/javascript">
					console.log("error");
					$("#gal-cover").hide();
				</script>'; 
				exit;
			
		  }
	 }
	

}



	 //+++++++++++++++++++++++++++
	//GET IMAGES FOR EDITOR
	//++++++++++++++++++++++++++
			
	function show_upload_images_json()
	{
		

			
	}	
			
function add_gallery_do()
	{
		$img = $this->input->post('userfile', TRUE);
			$child_id = $this->input->post('child_id', TRUE);
			$story_id = $this->input->post('story_id', TRUE);
			$pro_id = $this->input->post('pro_id', TRUE);
			//upload file

			$config['upload_path'] = './assets/' . $pro_id . '/children/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['file_name']	= $pro_id . '-' . $child_id . '-' .  date('m-y-d') . 'pro-pic' . rand(0,100). '.jpg';
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					$data['pro_id'] = $pro_id;
					$data['error'] =  $this->upload->display_errors();
					echo 
					'<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>'
           			 . $data['error'].'
       				 </div><script type="text/javascript">
					 	$("#gal-cover").hide();
				    </script>'; 
					//$this->output->set_header("HTTP/1.0 403 ERROR");
					
			}	
			else
			{	
			
			
			//$file = array('upload_data'
			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
		    $height = $this->upload->image_height;	
		   	//delete old photo
			//$this->delete_old_child_photo($child_id,$pro_id);
			//$this->update_pro_book_image($child_id,$pro_id,$file);
					 
				if (($width > 850) || ($height > 700)){
						
						$this->load->model('gallery_model');
						$str = 'children';	 
						$this->gallery_model->downsize_image($file,$pro_id,$str);
								
				}


			   //populate array with values
				$data = array(
					'child_id' => $child_id,
					'story_id' => $story_id,  
			     	'img_file'=> $file
				 
        		);
				//insert into database
				
				$this->db->insert('gallery_images',$data);
				
				//load respective view 
			   $data['pro_id'] = $pro_id;
			   
			   //crop 
			   	$data['filename'] = $file;
				$data['width'] = $this->upload->image_width;
				$data['height'] = $this->upload->image_height;
				$data['info'] = $this->owner_model->get_child($child_id);
				$data['parents'] = $this->owner_model->get_parents($pro_id);
				$image = base_url('/') . 'assets/' . $pro_id.'/children/'.$file;
			   //redirect 
			    $data['basicmsg'] = 'Photo added successfully!';
				echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'. $data['basicmsg'].'
       				 </div>
					 <script type="text/javascript">show_gallery("'.$story_id.'");</script>
					 ';
				$this->output->set_header("HTTP/1.0 200 OK");
		}
	}



	/**
	++++++++++++++++++++++++++++++++++++++++++++
	CROP IMAGE
	++++++++++++++++++++++++++++++++++++++++++++
	 */

	//CROP COVER PHOTO
	function crop_cover()
	{
		ini_set('memory_limit', '512M');
		$img = $this->input->post('filename', TRUE);
		$path = $this->input->post('path', TRUE);
		$url = $this->input->post('url', TRUE);
		$this->load->model('image_model');
		$this->image_model->crop_cover_photo($img);

		$data['error'] =  $this->image_lib->display_errors();

		$data['basicmsg'] = 'Image cropped successfully!';
		$data['filename'] =	$img;
		$data['img'] = $img;

		echo '
				<div class="alert alert-success">'.$data['basicmsg'].'</div>
				<script type="text/javascript">

					$("#cropbox").attr("src" , "'.$path.'?'.rand(0,9999).'");
					window.location = "'.$url.'";
				  </script>';
		//redirect($url, 'refresh');


	}



	/*
	++++++++++++++++++++++++++++++++++++++++++++
	// ROTATE IMAGES
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++
	*/

	//ROTATE GALLERY PHOTO
	function rotate()
	{
		$this->load->library('image_lib');
		$angle = $this->input->post('angle', TRUE);
		$file = $this->input->post('img_file_rotate', TRUE);
		$path = $this->input->post('absolute_path_rotate',TRUE);
		$url = $this->input->post('url_rotate',TRUE);
		$config['image_library'] = 'GD2';
		$config['source_image']	= $path;

		$config['rotation_angle'] = $angle;
		//90 right =270
		//90 left = 90

		$this->image_lib->initialize($config);

		if ( ! $this->image_lib->rotate())
		{

			echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						'.$this->image_lib->display_errors() .'
       				 </div>';
		}else{

			$str = $file.'?v='.rand(0,999);
			echo '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						Image rotated successfully.
       				 </div>
					 <script type="text/javascript">
					  $("#rotate_img_div").delay(3000).removeClass("loading_img");
					  $("#rotate_img").fadeIn("1000").attr("src", "'.$str.'");
					 </script>
					 ';
		}

		$this->image_lib->clear();


	}





}
	
	
	
	

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */