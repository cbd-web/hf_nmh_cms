<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {
	/**
	 * @var CI_Session
	 */
	public $session;
	/**
	 * @var Admin_model
	 */
	public $admin_model;
	/**
	 * @var Google_model
	 */
	public $google_model;

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Main()
	{
		parent::__construct();
		$this->load->model('main_model');
		ini_set('display_errors', 1);
		//force_ssl();
	}
	




	function unsubscribe($bus_id, $token) {

		$this->load->library('encrypt');

		$email = $this->encrypt->decode($token);

		$this->db->where('email', $email);
		$this->db->where('bus_id', $bus_id);
		$this->db->delete('subscribers');

		echo 'You have successfully unsubscribed from our Newsletter';	

	}


	//+++++++++++++++++++++++++++
	//MAIN
	//++++++++++++++++++++++++++
	public function index()
	{
		$this->load->view('home');             
	}
	
	//+++++++++++++++++++++++++++
	//TEST
	//++++++++++++++++++++++++++
	public function test_email()
	{
		$this->load->model('email_model');
		$this->email_model->test_email();    
	}	
	//+++++++++++++++++++++++++++
	//TEST
	//++++++++++++++++++++++++++
	public function test()
	{
		$browser = new Buzz\Browser();
        $response = $browser->get('http://www.google.com');

        echo $browser->getLastRequest()."\n";
        echo $response;            
	}	
	
	//+++++++++++++++++++++++++++
	//PAGE
	//++++++++++++++++++++++++++
	public function page($slug)
	{	
		$page = $this->main_model->get_page($slug);
		if($slug == 'contact'){
			$page['contact'] = 'yes';
		}
		if($slug == 'staff-profiles'){
			$page['staff'] = 'yes';
		}
		$this->load->view('page', $page);
	}
	//+++++++++++++++++++++++++++
	//CONTACT US PAGE
	//++++++++++++++++++++++++++
	public function contact()
	{	
		$page = $this->main_model->get_page('contact');
		$page['contact'] = 'yes';
		$this->load->view('page', $page);
	}
	//+++++++++++++++++++++++++++
	//POST
	//++++++++++++++++++++++++++
	public function post($slug)
	{	
		$page = $this->main_model->get_post($slug);
		$this->load->view('post', $page);
	}
	//+++++++++++++++++++++++++++
	//NEWS
	//++++++++++++++++++++++++++
	public function news($query = '')
	{	
		$posts['query'] = '';//$this->main_model->get_posts($query);
		$posts['title'] = $this->config->item('site_title'). ' News';
		$posts['heading'] =  'keeping you informed...';
		
		$this->load->view('blogroll', $posts);
	}
	//+++++++++++++++++++++++++++
	//CATEGORIES
	//++++++++++++++++++++++++++
	public function category($cat_id, $cat_name)
	{	
		$posts['query'] = "SELECT * FROM posts JOIN post_cat_int ON posts.post_id = post_cat_int.post_id WHERE post_cat_int.cat_id = '".$cat_id."'";
		$posts['title'] = 'News by category';
		$posts['heading'] = $this->config->item('site_name'). $this->clean_url_str($cat_name, $replace=array(), $delimiter=' ');
		
		$this->load->view('blogroll', $posts);
	}


	//+++++++++++++++++++++++++++
	//EXTERNAL SIGN UP NEWSLETTER
	//++++++++++++++++++++++++++
	public function signup_newsletter()
	{
		//http://cms.my.na/main/signup_newsletter/
        //$http_origin = $_SERVER['HTTP_ORIGIN'];
		$this->output->set_header("Access-Control-Allow-Origin: *");
		$this->output->set_header( "Access-Control-Allow-Methods: POST, GET, PUT, DELETE, OPTIONS" );
		$this->output->set_header( 'Access-Control-Allow-Headers: content-type' );
		$this->output->set_header( 'Access-Control-Allow-Headers: X-PINGOTHER' );
		$this->output->set_header( 'Access-Control-Request-Headers: X-PINGOTHER' );
        $this->output->set_header( 'Access-Control-Request-Headers: X-Requested-With, Content-Type\n' );

        //$this->output->set_content_type( 'multipart/form-data' );
        $this->output->_display();
		//PReflight
		if($_SERVER['REQUEST_METHOD'] == "OPTIONS"){

			//$this->output->set_output( "*" );
			//$this->output->set_header("Access-Control-Allow-Credentials: true");
			//echo 'OPTIONS';


		}elseif($_SERVER['REQUEST_METHOD'] == "POST" || $_SERVER['REQUEST_METHOD'] == "GET"){

			$this->load->library('user_agent');

			if(!$this->agent->is_robot())
			{
				if($_SERVER['REQUEST_METHOD'] == "POST"){
					$bus_id = $this->input->post('bus_id');
					$name = $this->input->post('name');
					$sname = $this->input->post('sname');
					$email = $this->input->post('email');
				}else{

					$bus_id = $this->input->get('bus_id');
					$name = $this->input->get('name');
					$sname = $this->input->get('sname');
					$email = urldecode($this->input->get('email'));
				}


				//TEST IF EXIST
				$q = $this->db->where('bus_id', $bus_id);
				$q = $this->db->where('email', trim($email));
				$q = $this->db->get('subscribers');
                $val = true;
                $o = '';
				//VALIDATE INPUT
				if (!filter_var($email, FILTER_VALIDATE_EMAIL))
				{
					$val = false;
                    $o['res'] = $val;
                    $o['msg'] = '<div class="alert alert-warning"><h3>Oops, Sorry</h3>Email address is not valid: '.$email.'</div>';
					//die();
				}elseif(strlen(trim($name)) < 2){

                    $val = false;
                    $o['res'] = $val;
                    $o['msg'] = '<div class="alert alert-warning"><h3>Oops, Sorry</h3>Name is not valid: '.$name.'</div>';

                }

				if($val){

                    //TEST EXISTING
                    if ($q->result())
                    {
                        $o['res'] = false;
                        $o['msg'] = '<div class="alert alert-warning"><h3>Oops, Sorry</h3>
						Your subscription is already active for: '.$email.'</div>';

                    }
                    else
                    {
                        $data['type'] = 'general';
                        $data['email'] = trim($email);
                        $data['email'] = trim($email);
                        $data['bus_id'] = trim($bus_id);
                        $data['name'] = trim($name);
                        $data['sname'] = trim($sname);

                        $this->db->insert('subscribers', $data);
                        $o['res'] = true;
                        $o['msg'] = '<div class="alert alert-success"><h3>Congratulations</h3>
											Your subscription has been activated.</div>';
                    }


                }

                if($this->input->is_ajax_request()) {

                    $this->output
                        ->set_content_type('application/json')->set_output(json_encode($o));


                }else{



                       echo '<!DOCTYPE html>
						<html lang="en">
						<head>

							<!-- start: Meta -->
							<meta charset="utf-8">
							<title>Subscription - My Namibia&trade;</title>
							<meta name="description" content="">
							<meta name="author" content="Roland Ihms">
							<!-- end: Meta -->

							<!-- start: Mobile Specific -->
							<meta name="viewport" content="width=device-width, initial-scale=1">
							<!-- end: Mobile Specific -->

							<!-- start: CSS -->
							<link id="bootstrap-style" href="' . base_url('/') . 'admin_src/css/bootstrap.min.css" rel="stylesheet">
							<link href="' . base_url('/') . 'admin_src/css/bootstrap-responsive.min.css" rel="stylesheet">
							<link href="' . base_url('/') . 'admin_src/css/bootstrap-colorpicker.min.css" rel="stylesheet">

							<link id="base-style-responsive" href="' . base_url('/') . 'admin_src/css/style-responsive.css" rel="stylesheet">


							<!--[if lt IE 7 ]>
							<link id="ie-style" href="' . base_url('/') . 'admin_src/css/style-ie.css" rel="stylesheet">
							<![endif]-->
							<!--[if IE 8 ]>
							<link id="ie-style" href="' . base_url('/') . 'admin_src/css/style-ie.css" rel="stylesheet">
							<![endif]-->
							<!--[if IE 9 ]>
							<![endif]-->

							<!-- end: CSS -->


							<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
							<!--[if lt IE 9]>
							  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
							<![endif]-->

							<!-- start: Favicon -->
							<link rel="shortcut icon" href="' . base_url('/') . 'admin_src/img/favicon.ico">
							<!-- end: Favicon -->
							<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
							<script src="https://cdnjs.cloudflare.com/ajax/libs/tinymce/7.9.1/tinymce.min.js"></script>

						</head>
						<body>

							<div class="container">
								<div class="row">

									<div class="span12 text-center">

										<p class="clearfix">&nbsp;</p>


											'.$o['msg'].'


									</div>

								</div>

							</div>
							<script>

								window.setTimeout(redirect, 3000);


								function redirect(){
									window.history.back()
									close();

								}

							</script>
						</body>
						</html>
						';




                }


			}//end if robot





		}else{
            $o['res'] = false;
            $o['error'] = 'No Valid Request was sent';
            $this->output
                ->set_content_type('application/json')->set_output(json_encode($o));
            //echo json_encode($o);


        }





	}





	//+++++++++++++++++++++++++++
	//CONTACT US SUBMISSION
	//++++++++++++++++++++++++++
	public function contact_do()
	{
		$email = $this->input->post('email', TRUE);
		$name = $this->input->post('name', TRUE);
		$msg = $this->input->post('msg', TRUE);
		$captcha = $this->input->post('captcha', TRUE);
		$x = $this->input->post('x', TRUE);
		$y = $this->input->post('y', TRUE);
		
		//VALIDATE INPUT
		if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
			$val = FALSE;
			$error = 'Email address is not valid.';	
			
		}elseif($name == ''){
			$val = FALSE;
			$error = 'Please provide us with your full name.';	
		//CORRECT CAPTCHA
		}elseif(($x + $y) != $captcha){
			$val = FALSE;
			$error = 'Your answer did not match.';
						
		}else{
			$val = TRUE;
		}
		
		$settings = $this->get_settings();
		//IF VALIDATED
		if($val == TRUE){
			
				 $data1 = array(
				  'name'=> $name ,
				  'email'=> $email ,
				  'body'=> $msg ,
				  'type'=> 'enquiry',
				  'email_to' => $settings['contact_email'],
				  'subject' => 'Enquiry from '.$name
				);
				//GET WHK LOCAL DATE
			date_default_timezone_set('Africa/Windhoek');
			$time = date("r"); // local time
				$insertdata1 = array(
				  'name'=> $name ,
				  'email'=> $email ,
				  'body'=> $msg ,
				  'type'=> 'enquiry',
				   'datetime' => date('y-m-d h:i:S',strtotime($time)),

				);
			//SEND EMAIL LINK
			$this->load->model('email_model');	
			$this->email_model->send_enquiry($data1);	
			
			$this->db->insert('enquiries',$insertdata1);
			
			
			$data['basicmsg'] = 'Thanks, '. $name. '! We have succesfully sent your enquiry.' ;

			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					$("#msg").val("").empty();
					</script>
					';	
		
		//IF NOT VALIDATED	
		}else{

			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';	
			
		}
	
	
			
	}
	
	public function contact_ajax($bus_id)
	{
		$email = $this->input->post('email', TRUE);
		$name = $this->input->post('name', TRUE);
		$msg = $this->input->post('msg', TRUE);
		$captcha = $this->input->post('captcha', TRUE);
		$x = $this->input->post('x', TRUE);
		$y = $this->input->post('y', TRUE);
		
		//VALIDATE INPUT
		if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
			$val = FALSE;
			$error = 'Email address is not valid.';	
			
		}elseif($name == ''){
			$val = FALSE;
			$error = 'Please provide us with your full name.';	
		//CORRECT CAPTCHA
		}elseif(($x + $y) != $captcha){
			$val = FALSE;
			$error = 'Your security answer did not match. What is '.$x . ' + ' . $y;
						
		}else{
			$val = TRUE;
		}
		
		//IF VALIDATED
		if($val == TRUE){

     	$settings = $this->get_settings();

				$data1 = array(
				  'name'=> $name ,
				  'email'=> $email ,
				  'body'=> $msg ,
				  'type'=> 'enquiry',
				  'email_to' => $settings['contact_email'],
				  'subject' => 'Enquiry from '.$name
				);
			//GET WHK LOCAL DATE
			date_default_timezone_set('Africa/Windhoek');
			$time = date("r"); // local time
				$insertdata1 = array(
				  'name'=> $name ,
				  'email'=> $email ,
				  'body'=> $msg ,
				  'type'=> 'enquiry',
				  'datetime' => date('y-m-d h:i:S',strtotime($time)),

				);
			//SEND EMAIL LINK
			$this->load->model('email_model');	
			$this->email_model->send_enquiry($data1);	
			
			$this->db->insert('enquiries',$insertdata1);

			$data['basicmsg'] = 'Thanks, '. $name. '! We have succesfully sent your enquiry.' ;
			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					$("#msg").setCode("");
					</script>
					';	
		
		//IF NOT VALIDATED	
		}else{

			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';	
			
		}
	
			
	}
	//+++++++++++++++++++++++++++
	//SUBMIT COMMENT
	//++++++++++++++++++++++++++
	public function submit_comment()
	{
		
		$this->load->library('user_agent');
		//TEST IF ROBOT
		if ($this->agent->is_robot())
		{
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		Sorry, only humans can discuss this matter!</div>';	
		
		//IS HUMAN
		}else{
			
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('name', TRUE);
			$msg = strip_tags($this->input->post('body', TRUE));
			$post_id = $this->input->post('post_id', TRUE);

			//VALIDATE INPUT
			if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
				$val = FALSE;
				$error = 'Email address is not valid.';	
				
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your name.';	
			
			}else{
				$val = TRUE;
			}
			
			
			//IF VALIDATED
			if($val == TRUE){
				//GET WHK LOCAL DATE
				date_default_timezone_set('Africa/Windhoek');
				$time = date("r"); // local time
					 $data1 = array(
					  'name'=> $name ,
					  'email'=> $email ,
					  'cont_id'=> $post_id ,
					  'body'=> $msg ,
					  'type'=> 'comment',
					  'datetime' => date('y-m-d h:i:S',strtotime($time)),
					  'status' => 'moderate'
					);

				
				$this->db->insert('comments',$data1);
				$msgpre = str_replace("'"," ", strip_tags($msg));
				//BUILD PREVIEW
				$pre = "<div class='comment'><div class='commentbox right'><div class='arrow'></div><h3 class='commentbox-title'>".$name ."<span class='pull-right'>Being moderated</span></h3><div class='popover-content'>".$msgpre."<small style='color:#CCC'>".date('y-m-d h:i:S',strtotime($time))."</small></div></div></div><br />";
				
				$data['basicmsg'] = 'Thanks, '. $name. '! You your comment will be moderated..' ;
	
				echo '<div class="alert alert-success">
						<button type="button" class="close" data-dismiss="alert">×</button>
						'.$data['basicmsg'].'</div>
						<script type="text/javascript">
						
							$(".redactor").html("").empty();
							$("#comment_id").prepend("'.$pre.'");
							console.log("'.$pre.'");
							//load_comments();
						
						</script>
						';	
			
			//IF NOT VALIDATED	
			}else{
	
				$data['error'] = $error;
				echo '<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">×</button>
						'.$data['error'].'</div>';	
				
			}
		
		}
			
	}



	//+++++++++++++++++++++++++++
	//VIEW EMAIL
	//++++++++++++++++++++++++++
	public function email($id)
	{

		$this->db->where('email_id', $id);
		$q = $this->db->get('emails');



		if($q->result()){

			$row = $q->row();
			$this->db->where('bus_id', $row->bus_id);
			$template = $this->db->get('email_templates');

			if($template->result()){

				$trow = $template->row();

				//SNIPPEt
				$snippet = $this->admin_model->shorten_string(strip_tags($row->body), 18);

				//REPLACE snippet and Link with dynamic content
				//teaser
				$header = str_replace('{{teaser}}', $snippet, $trow->header);

				//link
				$header = str_replace('{{link}}', '', $header);
				$out = $header;
				$out .= $row->body;
				$out .= $trow->footer;

				echo $out;

			}



			

		}else{


			echo 'Email not found, please check back later';
			//$this->load->view('email/body_news', $data);

		}



	}


	//+++++++++++++++++++++++++++
	//LOAD COMMENTS
	//++++++++++++++++++++++++++
	public function load_comments($post_id)
	{
		
		$this->main_model->get_comments($post_id);
	}
	//+++++++++++++++++++++++++++
	//GET SETTINGS
	//++++++++++++++++++++++++++		 
		 
	function get_settings(){

		$test = $this->db->get('settings');
		return $test->row_array();	

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