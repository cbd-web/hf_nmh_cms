<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Video extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Video()
	{
		parent::__construct();
		//error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model('video_model');
		// force_ssl();
	}



	 //+++++++++++++++++++++++++++
	 //LOAD VIDEOS
	 //++++++++++++++++++++++++++
	 public function galleries()
	 {
		  if($this->session->userdata('admin_id')){
			$this->load->view('admin/videos/galleries');
		  }else{
			$this->load->view('admin/login'); 
		  } 
	 }

	//+++++++++++++++++++++++++++
	//add new gallery
	//++++++++++++++++++++++++++

	public function add_gallery()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/videos/add_gallery');

		}else{

			$this->load->view('admin/login');

		}


	}



	//+++++++++++++++++++++++++++
	//ADD VIDEO DO
	//++++++++++++++++++++++++++
	function add_video_do()
	{
		$video = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('video', FALSE)));
		$title = $this->input->post('title', TRUE);
		$heading = $this->input->post('heading', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		$id = $this->input->post('gallery_id', TRUE);


		//VALIDATE INPUT
		if($video == ''){
			$val = FALSE;
			$error = 'Video Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'heading'=> $heading ,
			'vid_file'=> $video ,
			'gal_id'=> $id ,
			'bus_id'=> $bus_id
		);



		if($val == TRUE){


			$this->db->insert('videos', $insertdata);
			//LOG
			$this->admin_model->system_log('add_new_video-'.$title);
			//success redirect
			$this->session->set_flashdata('msg','Video added successfully');
			$data['basicmsg'] = 'Video has been added successfully';
			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'
            	  </div>
					';
		}else{
			$data['id'] = $this->session->userdata('id');
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
			$this->output->set_header("HTTP/1.0 200 OK");

		}
	}





	//+++++++++++++++++++++++++++
	//ADD GALLERY DO
	//++++++++++++++++++++++++++
	function add_gallery_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		//$id = $this->input->post('page_id', TRUE);

		if($slug == ''){

			$slug = $this->clean_url_str($title, $replace=array(), $delimiter='-' , 'gallery', 'add');

		}else{

			$slug = $this->clean_url_str($slug, $replace=array(), $delimiter='-' , 'gallery', 'add');

		}

		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Gallery title Required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';
//
		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'description'=> $body ,
			'metaD'=> $metaD,
			'metaT'=> $metaT,
			'slug'=> $slug,
			'bus_id'=> $bus_id
		);



		if($val == TRUE){


			$this->db->insert('video_galleries', $insertdata);
			//LOG
			$this->admin_model->system_log('add_new_gallery-'.$title);
			//success redirect
			$this->session->set_flashdata('msg','Gallery added successfully');
			$data['basicmsg'] = 'Gallery has been added successfully';
			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'video/galleries/";
					</script>
					';
		}else{
			$data['id'] = $this->session->userdata('id');
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
			$this->output->set_header("HTTP/1.0 200 OK");

		}
	}


	public function update_vid_sequence($vid_id , $sequence)
	{

		$data['sequence'] = $sequence;
		$this->db->where('vid_id' , $vid_id);
		$this->db->update('videos', $data);


	}
	//+++++++++++++++++++++++++++
	//load gallery images For sidebars
	//++++++++++++++++++++++++++

	function load_gallery_videos($gal_id)
	{

		$this->video_model->load_gallery_videos($gal_id);

	}

	//+++++++++++++++++++++++++++
	//load gallery images
	//++++++++++++++++++++++++++

	function load_gallery_videos_update($gal_id)
	{

		$this->video_model->load_gallery_videos_update($gal_id);

	}


	public function update_gallery($gal_id)
	{
		if($this->session->userdata('admin_id')){

			$gallery = $this->video_model->get_gallery($gal_id);
			$this->load->view('admin/videos/update_gallery', $gallery);

		}else{

			$this->load->view('admin/login');

		}


	}


	//+++++++++++++++++++++++++++
	//update document
	//++++++++++++++++++++++++++

	public function update_gallery_video($vid_id)
	{
		$this->db->where('vid_id', $vid_id);

		$query = $this->db->get('videos');

		if($query->result()){
			$row = $query->row_array();

			echo '<div class="row-fluid">
					<form id="video-update" name="image-update" method="post" action="'. site_url('/').'video/update_video_do" >
                       <fieldset>
                        <input type="hidden" id="update_vid_id" name="update_vid_id" value="'.$vid_id.'" />
                        <div class="control-group">
                              <label class="control-label" for="vid_title">Title</label>
                              <div class="controls">
                                    <input type="text" class="span12" id="vid_title" name="vid_title" placeholder="Video title" value="'.$row['title'].'">
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="vid_heading">Heading</label>
                              <div class="controls">
                                    <input type="text" class="span12" id="vid_heading" name="vid_heading" placeholder="Video heading" value="'.$row['heading'].'">
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="vid_body">Body</label>
                              <div class="controls">
									<textarea  name="vid_body" class="redactor" style="display:block">'.$row['body'].'</textarea>
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="vid_icon">Icon</label>
                              <div class="controls">
                                    <input type="text" class="span12" id="vid_icon" name="vid_icon" placeholder="Icon" value="'.$row['icon'].'">
                                    <span class="help-block" style="font-size:11px">eg: arrow-up, arrow-down</span>
                              </div>
                        </div>
                        <div class="control-group">
                              <label class="control-label" for="vid_url">Link</label>
                              <div class="controls">
                                    <input type="text" class="span12" id="vid_url" name="vid_url" placeholder="Song URL" value="'.$row['url'].'">
                              </div>
                        </div>
						<input type="submit" id="update_vid_but" value="Update Video" class="btn btn-primary pull-right" />
                      </fieldset>
                  </form>
				</div>
				<script type="text/javascript">


					  $(".redactor").redactor({
								  buttons: ["html", "|", "formatting", "|", "bold", "italic", "deleted", "|",
								  "unorderedlist", "orderedlist", "outdent", "indent", "|","image",
								  "video", "table","|",
								   "alignment", "|", "horizontalrule"]
					  });

					$("#update_vid_but").click(function(e){

						  e.preventDefault();

						  var frm = $("#video-update");

						  $.ajax({
							cache: false,
							url: "'. site_url("/").'video/update_video_do/'.rand(0,99999).'",
							method : "post",
							data: frm.serialize(),
							success: function(data) {

							  load_videos();
							  $("#modal-vid-update").modal("hide");

							}
						  });

					});

				</script>

				';

		}

	}


	public function update_video_do()
	{
		$this->video_model->update_video_do();

	}


	//+++++++++++++++++++++++++++
	//UPDATE GALLERY
	//++++++++++++++++++++++++++
	function update_gallery_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);

		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$id = $this->input->post('gallery_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Gallery title Required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'description'=> $body ,
			'metaD'=> $metaD,
			'metaT'=> $metaT,
			'slug'=> $slug,
			'bus_id'=> $bus_id
		);



		if($val == TRUE){

			$this->db->where('gal_id' , $id);
			$this->db->update('video_galleries', $insertdata);
			//success redirect
			$data['gallery_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_gallery-'. $id);
			$data['basicmsg'] = 'Gallery has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}


	//DELETE VIDEO
	function delete_video($vid_id){

		if($this->session->userdata('admin_id')){


			//delete from database
			$test = $this->db->where('vid_id', $vid_id);
			$this->db->delete('videos');
			//LOG
			$this->admin_model->system_log('delete_video-'.$vid_id);
			$this->session->set_flashdata('msg','Video deleted successfully');
			echo '<script type="text/javascript">

				  </script>';


		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}


	//+++++++++++++++++++++++++++
	//delete gallery
	//++++++++++++++++++++++++++

	public function delete_gallery($gal_id)
	{

		$this->db->where('gal_id', $gal_id);
		$query = $this->db->get('videos');

		if($query->result()){

			$row = $query->row_array();
			$this->db->where('gal_id', $gal_id);
			$this->db->delete('videos');

		}

		$this->db->where('gal_id', $gal_id);
		$this->db->delete('video_galleries');
		$this->session->set_flashdata('msg','Gallery removed successfully');
		echo '<script type="text/javascript">
				window.location = "'.site_url('/').'video/galleries/"

			</script>';

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