<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Forum extends CI_Controller {

	/**
	 * CSV CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
 	function forum() {
		
        parent::__construct();
        //error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
		$this->load->model(array('admin_model','forum_model'));
		//force_ssl();
       
    }
 
    function index() {
      
	  	echo 'Going Nowhere Slowly!';
	  
    }
 	 //+++++++++++++++++++++++++++
	//Load USERS
	//++++++++++++++++++++++++++

	public function users()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/forum/users');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	//GET USER
	function get_forum_user($id){

		$this->db->where('forum_users_id', $id);
		$query = $this->db->get('forum_users');
			
			if($query->result()){
				
				$row = $query->row_array();
				
				echo '<form id="user-update" name="user-update" method="post" action="'.site_url('/').'forum/update_forum_user_do" class="form-horizontal">
    						<input type="hidden" id="user_id" name="user_id" value="'.$row['forum_users_id'].'">  
							<div class="control-group">
								  <label class="control-label" for="uname">First Name</label>
								<div class="controls">
								   <input type="text" id="uname" name="uname" placeholder="First Name" value="'.$row['fname'].'">                    
								</div>
				  </div>
							 <div class="control-group">
								  <label class="control-label" for="sname">Surname</label>
								<div class="controls">
								   <input type="text" id="sname" name="sname" placeholder="Surname" value="'.$row['sname'].'">                    
								</div>
							 </div>
							  <div class="control-group">
								  <label class="control-label" for="uposition">User Rights</label>
								<div class="controls">
									<select name="uposition" id="uposition">
									  <option value="editor">Editor</option>
									  <option value="admin">Admin</option>
									 
									</select>                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="type">Type</label>
								<div class="controls">
								   '.$this->forum_model->get_user_types($row['f_type_id']).'                
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uemail">User Email</label>
								<div class="controls">
								   <input type="text" id="uemail" name="uemail" placeholder="User Email" value="'.$row['email'].'">                    
								</div>
							 </div>
							 <div class="control-group">
								  <label class="control-label" for="uuserpass">User Password</label>
								<div class="controls">
								   <input type="password" id="uuserpass" name="uuserpass" placeholder="User Password" value="">                    
								</div>
							 </div>  
							   
								
						</form>';
					

			}else{
					
				$this->session->set_flashdata('error', 'User not found');	
			}
	}
	//+++++++++++++++++++++++++++
	//LOGIN FUNCTIONS
	//++++++++++++++++++++++++++
	function login()
	{
			
			
		$this->output->set_header("Access-Control-Allow-Origin: *");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
		
		$this->output->set_content_type( 'multipart/form-data' );
		$this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';
			
		}elseif($_SERVER['REQUEST_METHOD'] == "POST"){
			
				$email = $this->input->post('email', TRUE);
				$pass = $this->input->post('password', TRUE);
				$sess = $this->input->post('rememberme', TRUE);
				$redirect = $this->input->post('redirect', TRUE);
				
				//MATCH CREDENTIALS
				$row = $this->forum_model->validate_password($email,$pass);
				if($row['bool'] == TRUE){
						
						//HASH PASSWORD AGAIN
						$pass_new = $this->forum_model->hash_password($email,$pass);
						//create user array
						 $data = array(
						  /* 'user_agent' => $this->agent->browser() . ' ver ' . $this->agent->version(),*/
						   'last_login' => date("Y-m-d H:i:s"),
						   'pass' => $pass_new
						);
						
						if ($sess == TRUE) {
						//$this->session->cookie_monster();	
						}
						//GET SETTINGS
						
						$query = $this->db->where('bus_id', $row['bus_id']);
						$query = $this->db->get('settings');
						$settings = $query->row_array();
						
						$sess_array = array(
							'forum_users_id' => $row['forum_users_id'],
							'bus_id' => $row['bus_id'],
							'u_name' => $row['fname'],
							'last_login' => $row['last_login'],
							'site_title' => $settings['title'],
							'url' => $settings['url'],
							'img_file' => $row['img_file'],
							'role' => $row['type'],
							'redirect' => $redirect
						);
						
						
						//$this->session->set_userdata($sess_array);
	
						$this->db->where('forum_users_id', $row['forum_users_id']);
						$this->db->update('forum_users', $data);
						
						//LOG
						$this->admin_model->system_log('forum_log_in-'. $row['fname']) ;
	
						
						//--------------
						//Redirect
						if($this->input->post('redirect')){
	
							if(strpos($redirect, 'login') !== false){
	
								//redirect(site_url('/').'admin/home/', 'refresh');
	
							}else{
	
								//redirect($redirect, 'refresh');
	
							}
	
							
						}else{
							
	
							//redirect(site_url('/').'admin/home/', 'refresh');	
							
						}
						
						$out = array_merge($row, $sess_array);
						//echo json_encode($out);
						$this->output ->set_content_type('application/json');
						echo json_encode($out);				
				//NO MATCHING CREDENTIALS
				}else{
				
					$data['error'] = 'No matching records found!';
					//echo $this->encode($pass) .' ' ;
					//$this->load->view('admin/login' , $data);
					$this->output ->set_content_type('application/json');
					echo json_encode($data);
				}
		}else{

			$data['error'] = 'We only accept the post method';

			echo json_encode($data);
		}
	}
	
	//ADD	
	function add_forum_user_do(){
			
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$position = $this->input->post('position', TRUE);
			$pass = $this->input->post('userpass', TRUE);
			
			$bus_id = $this->session->userdata('bus_id');
			//TEST IF EXISTING
			$this->db->where('email', $email);
			$query = $this->db->get('forum_users');
			//EMAIL EXISTS
			if($query->result()){
				
				$this->session->set_flashdata('error', 'Email addres already in use');		

			}else{
					
				$insertdata = array(
								  'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position,
								  'bus_id'=> $bus_id,
								  'pass'=> $this->admin_model->hash_password($email,$pass)
					);
				$this->db->insert('forum_users',$insertdata);
				$id = $this->db->insert_id();
				$this->session->set_flashdata('msg', 'Successfully added forum user '.$id);

				$this->register_email($id);


			}
			


	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//EXPORT USERS
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function export_users()
	{
		$this->forum_model->export_users();

	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//+SEND WELCOME EMAIL
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	function register_email($id)
	{
		$this->forum_model->register_email($id);
	}
	//UPDATE	
	function update_forum_user_do(){
			
			$email = $this->input->post('uemail', TRUE);
			$name = $this->input->post('uname', TRUE);
			$sname = $this->input->post('sname', TRUE);
			$position = $this->input->post('uposition', TRUE);
			$pass = $this->input->post('uuserpass', TRUE);
			$id = $this->input->post('user_id', TRUE);
			$type = $this->input->post('f_type_id', TRUE);
			
			if($pass == ''){
				
				$insertdata = array(
								   'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position,
								  'f_type_id' => $type
					);
				
				
				
			}else{
				
				$insertdata = array(
								   'fname'=> $name ,
								  'sname'=> $sname ,
								  'email'=> $email ,
								  'type'=> $position,
								  'f_type_id' => $type,
								  'pass'=> $this->admin_model->hash_password($email,$pass)
					);
				
				
			}
			
			  $this->db->where('forum_users_id', $id);
			  $this->db->update('forum_users',$insertdata);
			  $this->session->set_flashdata('msg', 'Successfully updated forum user');	
			


	}
	
	
	
	//+++++++++++++++++++++++++++
	//DELETE USER
	//++++++++++++++++++++++++++

	public function delete_user($id)
	{
		$this->db->where('forum_users_id', $id);
		$this->db->delete('forum_users');
		//LOG
		$this->admin_model->forumtem_log('delete-forumtem-user'. $id);
		$this->session->set_flashdata('msg', 'Successfully deleted forumtem user');	
	}
	
 	
	//+++++++++++++++++++++++++++
	//TOPICS
	//++++++++++++++++++++++++++
	//
	//
	//
	//+++++++++++++++++++++++++++
	//ADD TOPICS AND INTERSECTION FOR POST
	//++++++++++++++++++++++++++
 	 //+++++++++++++++++++++++++++
	//Load USERS
	//++++++++++++++++++++++++++

	public function topics()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/forum/topics');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	public function add_topic_do()
	{
		 $bus_id = $this->session->userdata('bus_id');
		
		//INSERT INTO CATEGORIES
		$data['topic_name'] = $this->input->post('topic_name');
		$data['bus_id'] = $bus_id;
		$post_id = $this->input->post('forum_discussion_id');	
		//TEST DUPLICATE CATEGORIES
		$this->db->where('topic_name', $data['topic_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('forum_topics');
		
		if($result1->num_rows() == 0){
			$this->db->insert('forum_topics', $data);	
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('topic_name', $data['topic_name']);
		$result = $this->db->get('forum_topics');
		$row = $result->row_array();
		
		//TEST DUPLICATE INTERSECTION
		$this->db->where('topic_name', $data['topic_name']);
		$this->db->where('forum_discussion_id', $post_id);
		$result = $this->db->get('forum_topic_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE		
			$data2['topic_id'] = $row['topic_id'];
			$data2['forum_discussion_id'] = $post_id;	
			$data2['topic_name'] = $data['topic_name'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('forum_topic_int', $data2);	
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_category($forum_discussion_id)
	{
		$this->forum_model->get_topics_current($forum_discussion_id);
		
	}
	
		//+++++++++++++++++++++++++++
	//DELETE CATEGORY INTERSECTION
	//++++++++++++++++++++++++++

	public function delete_category($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('forum_topic_int');
		
	}
	//+++++++++++++++++++++++++++
	//ADD CATEGORY GENERLA
	//++++++++++++++++++++++++++

	public function add_topic_do_general()
	{
		 $bus_id = $this->session->userdata('bus_id');		
		//INSERT INTO CATEGORIES
		$data['topic_name'] = $this->input->post('topic_name');
		$data['bus_id'] = $bus_id;
		$post_id = $this->input->post('topic_id_cat');	
		//TEST DUPLICATE CATEGORIES
		$this->db->where('topic_name', $data['topic_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('forum_topics');
		
		if($result1->num_rows() == 0){
			$this->db->insert('forum_topics', $data);	
		}
		//GET NEW CAT ID
		$this->db->where('topic_name', $data['topic_name']);
		$this->db->where('bus_id', $bus_id);
		$result = $this->db->get('forum_topics');
		$row = $result->row_array();

		
	}

	
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY ALL
	//++++++++++++++++++++++++++

	public function reload_topic_all()
	{
		$this->forum_model->get_all_topics();
		
	}
	//+++++++++++++++++++++++++++
	//RELOAD CATEGORY
	//++++++++++++++++++++++++++

	public function reload_topics($post_id)
	{
		$this->forum_model->get_topics_current($post_id);
		
	}
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY INTERSECTION
	//++++++++++++++++++++++++++

	public function delete_topic($id)
	{
		$this->db->where('topic_id', $id);
		$this->db->delete('forum_topics');
		
	}
	//+++++++++++++++++++++++++++
	//DELETE CATEGORY MAIN
	//++++++++++++++++++++++++++

	public function delete_topic_main($id)
	{
		$this->db->where('cat_id', $id);
		$this->db->delete('forum_topics');
		
	}


	//+++++++++++++++++++++++++++
	//COMMENTS
	//++++++++++++++++++++++++++
	//
	//
	//
	//+++++++++++++++++++++++++++
	//ADD COMMENTS AND INTERSECTION FOR COMMENTS
	//++++++++++++++++++++++++++
 	 //+++++++++++++++++++++++++++
	//Load COMMENTS
	//++++++++++++++++++++++++++]


	public function comments()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/forum/comments');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}


	
	//+++++++++++++++++++++++++++
	//DISCUSSIONS
	//++++++++++++++++++++++++++
	//
	//
	//
	//+++++++++++++++++++++++++++
	//ADD DISCUSSIONS AND INTERSECTION FOR DISCUSSIONS
	//++++++++++++++++++++++++++
 	 //+++++++++++++++++++++++++++
	//Load DISCUSSIONS
	//++++++++++++++++++++++++++]
		//+++++++++++++++++++++++++++
	//Load DISCUSSIONS
	//++++++++++++++++++++++++++

	public function discussions()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/forum/discussions');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//add new DISCUSSIONS
	//++++++++++++++++++++++++++

	public function add_discussion()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/forum/add_discussion');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
		//+++++++++++++++++++++++++++
	//add new discussion
	//++++++++++++++++++++++++++

	public function update_discussion($forum_discussion_id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->db->where('forum_discussion_id', $forum_discussion_id);
			$this->db->where('bus_id', $this->session->userdata('bus_id'));
			$discussion = $this->db->get('forum_discussions');
			if($discussion->result()){
				$discussion = $discussion->row_array();
			}else{
				$discussion = '';
			}
			$discussion['settings'] = $this->forum_model->get_config();
			
			$this->load->model('my_namibia_model');
			$this->load->view('admin/forum/update_discussion', $discussion);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}
	//+++++++++++++++++++++++++++
	//ADD PAGE DO
	//++++++++++++++++++++++++++	
	function add_discussion_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$url = $this->input->post('url', TRUE);
			$feat_doc = $this->input->post('feat_doc', TRUE);
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$discussion_parent = $this->input->post('parent', TRUE);
			$discussion_template = $this->input->post('template', TRUE);
			$discussion_sequence = $this->input->post('sequence', TRUE);
			//$id = $this->input->post('forum_discussion_id', TRUE);
			 $bus_id = $this->session->userdata('bus_id');
		  
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'forum_discussions');
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Discussion title Required';
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Discussion Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
					  'title'=> $title,
					  'heading'=> $heading,
					  'body'=> $body,
					  'metaD'=> $metaD,
					  'metaT'=> $metaT,
					  'slug'=> $slug,
					  'url'=> $url,
					  'document'=> $feat_doc,
					  'bus_id'=>$bus_id,
					  'parent'=> $discussion_parent,
					  'template'=> $discussion_template,
					  'sequence'=> $discussion_sequence
					);
			
	
			
			if($val == TRUE){
				
					
					$this->db->insert('forum_discussions', $insertdata);
					$discussionid = $this->db->insert_id();
					//LOG
					$this->admin_model->system_log('add_new_discussion-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Discussion added successfully');
					$data['basicmsg'] = 'Discussion has been added successfully';
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);
					window.location = '".site_url('/')."forum/update_discussion/".$discussionid."/';
					</script>
					";
			}else{
					$data['id'] = $this->session->userdata('id');
					$data['error'] = $error;
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				            noty(options);
					
					</script>
					";
					$this->output->set_header("HTTP/1.0 200 OK");
				
			}
	}	
	 //+++++++++++++++++++++++++++
	//UPDATE PAGE
	//++++++++++++++++++++++++++	
	function update_discussion_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$url = $this->input->post('url', TRUE);
			$feat_doc = $this->input->post('feat_doc', TRUE);			
			$status = $this->input->post('status', TRUE);
			$discussion_downloads = $this->input->post('p_downloads', TRUE);
			$discussion_sidebars = $this->input->post('p_sidebars', TRUE);
			$discussion_people = $this->input->post('p_people', TRUE);
			
			
			$discussion_features = array();
			
			if($discussion_sidebars != "") {
				
				array_push($discussion_features, $discussion_sidebars);

			}
			
			if($discussion_downloads != "") {
				
				array_push($discussion_features, $discussion_downloads);
				
			}
			
			if($discussion_people != "") {
				
				array_push($discussion_features, $discussion_people);
				
			}			
			
			//print_r($discussion_features);
			
			$discussion_features = json_encode($discussion_features);
			
						
			
			//IE 9 FIX
			if($this->input->post('content')){
				$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			}else{
				$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content2', FALSE)));
			}
			$heading = $this->input->post('heading', TRUE);
			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('forum_discussion_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
		 	$discussion_parent = $this->input->post('parent', TRUE);
			$discussion_sequence = $this->input->post('sequence', TRUE);
			$discussion_template = $this->input->post('template', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Discussion title Required';
			
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			/*}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Discussion Content Required';*/	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
						  'title'=> $title ,
						  'status'=> strtolower($status),
						  'heading'=> $heading ,
						  'body'=> $body ,
						  'metaD'=> $metaD,
						  'metaT'=> $metaT,
						  'slug'=> $slug ,
						  'url'=> $url,
						  'document'=> $feat_doc,								  
						  'bus_id'=>$bus_id,
						  'parent'=> $discussion_parent,
						  'discussion_features'=> $discussion_features,
						  'sequence'=> $discussion_sequence,
						  'template'=> $discussion_template
					);
			
	
			
			if($val == TRUE){
				
					$this->db->where('forum_discussion_id' , $id);
					$this->db->update('forum_discussions', $insertdata);
					//success redirect	
					$data['forum_discussion_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_discussion-'. $id);
					
					
					
					$data['basicmsg'] = 'Discussion has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}
	//DELETE DISCUSION
	function delete_discussion($forum_discussion_id){
      	
		if($this->session->userdata('admin_id')){
			
		
			  //delete from database
			  $test = $this->db->where('forum_discussion_id', $forum_discussion_id);
			  $this->db->delete('forum_discussions');
			  //LOG
			  $this->admin_model->system_log('delete_discussion-'.$forum_discussion_id);
			  $this->session->set_flashdata('msg','Discussion deleted successfully');
			  echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'forum/discussions/";
				  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }
	
		  
		 	
	//+++++++++++++++++++++++++++
	//update_comment_status
	//++++++++++++++++++++++++++
	public function update_comment_status($id, $str)
	{
		if($this->session->userdata('admin_id')){
			
			$data['status'] = $str;
			$this->db->where('com_id', $id);
			$this->db->update('forum_comments', $data);
			
			//GET SETTINGS TITLE AND EMAIL FROM
			$settings = $this->admin_model->get_settings();
			
			//SEND Notifications to involved users
			if($str == 'live'){
				
				//SEND Notifications to user who submitted
				$res = $this->forum_model->send_comment_approval($id, $settings);
				
				//var_dump($res);
				$this->forum_model->send_new_comment_notification($res->cont_id, $settings);
					
			}

			
		}
			
	} 
			
		
				 	
	//+++++++++++++++++++++++++++
	//update_comment_status
	//++++++++++++++++++++++++++
	public function delete_comment($id)
	{
		if($this->session->userdata('admin_id')){
			
			
			$this->db->where('com_id', $id);
			$this->db->delete('forum_comments');
			
			
		}
			
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
			//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
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
		
		  
}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */