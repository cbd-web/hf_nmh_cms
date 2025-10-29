<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Survey extends CI_Controller {

	/**
	 * MAIN CMS CONTROLLER
	 * ihmsMedia CMS
	 * Roland Ihms
	 */
	function Survey()
	{
		parent::__construct();
		$this->load->model('survey_model');
		//force_ssl();
	}
	


	//+++++++++++++++++++++++++++
	//SURVEYS
	//++++++++++++++++++++++++++
	public function surveys()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/surveys/surveys');

		}else{

			$this->load->view('home');

		}
	}

	//+++++++++++++++++++++++++++
	//add new survey
	//++++++++++++++++++++++++++

	public function add_survey()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/surveys/add_survey');

		}else{

			$this->load->view('home');

		}


	}


	//+++++++++++++++++++++++++++
	//SUBMIT
	//++++++++++++++++++++++++++
	public function submit()
	{
		if($this->input->post()){
			
			
			$data['answer'] = '';
			foreach($this->input->post() as $row => $key){
				
				if($row == 'email'){
					
					$data['email'] = $this->input->post('email', TRUE);
					
				}elseif($row == 'fullname'){
					
					$data['name'] = $this->input->post('fullname', TRUE);
					
				}elseif($row == 'age'){
					
					$data['age'] = $this->input->post('age', TRUE);
					
				}elseif($row == 'cellphone'){
					
					$data['cell'] = $this->input->post('cellphone', TRUE);
				
				}elseif($row == 'survey_id'){
					
					$data['survey_id'] = $this->input->post('survey_id', TRUE);
				
				}elseif($row == 'bus_id'){
					
					$data2['bus_id'] = $this->input->post('bus_id', TRUE);
					
				}else{
					
					$clean = str_replace("q_","",$row);
					if(is_array($row)){
						
						foreach($row as $frow){
							
							$data['answer'][$clean] = $frow; 	
							
						}
						
					}else{
						$data['answer'][$clean] = $key; 
						
					}
					
					
				}
				//echo '<br />'.$row . ' - ' .$key;
			}
			
			$data['answer'] = json_encode($data['answer']);
			$data['bus_id'] = $data2['bus_id'];
			$this->db->where('email', $data['email']);
			$this->db->where('bus_id', $data2['bus_id']);
			$test = $this->db->get('subscribers');
			
			if($test->result()){
				
					
				
			}else{
				
				
			}
			
			//INSERT SURVEY FEEDBACK
			$this->db->insert('survey_feedback', $data);
			
			//var_dump($this->input->post());
		}
	}
	
	//+++++++++++++++++++++++++++
	//INSERT CONTACT
	//++++++++++++++++++++++++++
	public function add_contacts()
	{
		if($this->input->post()){
			
			$email = $this->input->post('email', TRUE);
			
			//test existing
			
		}
	}	
	//+++++++++++++++++++++++++++
	//SHOW SURVEY
	//++++++++++++++++++++++++++
	public function show($slug, $touch = '')
	{
		
		//$this->load->driver('cache');
		//if ( ! $foo = $this->cache->file->get('survey_'.$slug.$touch)){
		  $this->db->where('slug', $slug);
		  $survey = $this->db->get('surveys');		
		 

		  if($survey->result()){
			  
 			  $survey = $survey->row_array();
			  $survey['leadcapture'] = TRUE;
			  $survey['color_primary'] = $survey['color_primary'];
			  $survey['color_secondary'] = $survey['color_secondary'];
		 
		 			
				//OLD MUTUAL
			  if($survey['bus_id'] == '7799'){
					
					if($touch == 'touch'){
						
						$foo = $this->load->view('old_mutual/survey_touch', $survey); 
						
					}else{
						
						$foo = $this->load->view('old_mutual/survey', $survey); 
					}
					
					 
					
			  }elseif($survey['bus_id'] == '3272') {
				  
				  $foo = $this->load->view('ntb/survey', $survey); 
				  
				  
			  }else{
					
					$foo = $this->load->view('survey/view', $survey);  
					
			  }		 
		 
		  }else{
			 show_404();
		  }

		
			//$this->cache->file->save('survey_'.$slug.$touch, $foo, 7200);	
		//}
	}
	//+++++++++++++++++++++++++++
	//SHOW SURVEY DYNAMIC LINK
	//++++++++++++++++++++++++++
	public function showfor($slug, $id = '')
	{

		  $this->db->where('slug', $slug);
		  $survey = $this->db->get('surveys');		

		  if($survey->result()){
			  
 			  $survey = $survey->row_array();
			  $survey['leadcapture'] = TRUE;
			  $survey['color_primary'] = $survey['color_primary'];
			  $survey['color_secondary'] = $survey['color_secondary'];

			  $sub = $this->db->where('subscriber_id', $id);
			  $sub = $this->db->get('subscribers');
			  if($sub->result()){
				  $sub = $sub->row_array();
				  $survey['leadcapture'] = FALSE;
				  $survey['fullname'] = $sub['name'].' '.$sub['sname'];
				  $survey['email'] = $sub['email'];
				  //$survey['age'] = $sub['dob'];
				  $survey['cell'] = $sub['phone'];

			  }else{
				  $survey['leadcapture'] = TRUE;

				  
			  }
			  
			  //OLD MUTUAL
			  if($survey['bus_id'] == '7799'){
	
				  $foo = $this->load->view('old_mutual/survey_dynamic', $survey); 
	  
			  }else{
				  
				  $foo = $this->load->view('survey/view', $survey);  
				  
			  }
			  
		  }else{
			  
			show_404();  
			  
		  }


	}
	
	
	
	//+++++++++++++++++++++++++++
	//UPDATE QUESTION
	//++++++++++++++++++++++++++
	public function update_survey_question($id)
	{

		 $this->survey_model->update_survey_question($id);
		

	}
	//+++++++++++++++++++++++++++
	//UPDATE QUESTION DO
	//++++++++++++++++++++++++++
	public function update_survey_question_do($id)
	{

		 $this->survey_model->update_survey_question_do($id);
		

	}	
	//+++++++++++++++++++++++++++
	//update QUESTION sequence
	//++++++++++++++++++++++++++

	public function update_question_sequence($id , $sequence)
	{
		
		    $data['sequence'] = $sequence;
			$this->db->where('question_id' , $id);
			$this->db->update('survey_questions', $data);

		
	}

	//+++++++++++++++++++++++++++
	//ADD PAGE DO
	//++++++++++++++++++++++++++	
	function add_survey_do()
	{
		if($this->session->userdata('admin_id')){

			$this->survey_model->add_survey_do();

		}

	}

	//+++++++++++++++++++++++++++
	//update survey
	//++++++++++++++++++++++++++

	public function update_survey($survey_id)
	{
		if($this->session->userdata('admin_id')){

			$page = $this->db->where('survey_id', $survey_id);
			$page = $this->db->get('surveys');
			$page = $page->row_array();
			$page['settings'] = $this->get_config();

			$this->load->view('admin/surveys/update_survey', $page);

		}else{

			$this->load->view('home');

		}


	}


	//Update SURVEY
	function update_survey_do()
	{
					
		$this->survey_model->update_survey_do();
	}	
	//DELETE SURVEY
	function delete_survey($survey_id)
	{
			
			$this->db->where('survey_id' , $survey_id);
			$this->db->delete('surveys');
			//$this->session->set_flashdata('msg','Survey removed successfully');
			//LOG
			$this->admin_model->system_log('delete_survey-'. $survey_id);
			$data['basicmsg'] = 'Survey removed successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);</script>";
			
	}
	
	//SURVEY QUESTIONS
	function testt()
	{
		
		$str = 'test3,test2,test1';
		echo $str .'<br />';
		
		$array = explode("," , $str);
		$ser =serialize($array); 
		echo $ser.'<br />';
		echo unserialize($ser).'<br />';
		
		
		echo var_dump($array).'<br />';
		
	}
	
	//SURVEY QUESTIONS
	function survey_questions($survey_id)
	{
			
 		$this->survey_model->survey_questions($survey_id);
			
	}
	
	
	//DELETE QUESTION
	function delete_survey_question($id)
	{
			
			$this->db->where('question_id' , $id);
			$this->db->delete('survey_questions');
						//LOG
			$this->admin_model->system_log('delete_question-'. $id);
			$data['basicmsg'] = 'Question removed successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);</script>";
			
	}
	
	//DELETE FEEDBACK
	function delete_survey_feedback($id)
	{
			
			$this->db->where('feedback_id' , $id);
			$this->db->delete('survey_feedback');
						//LOG
			$this->admin_model->system_log('delete_survey-'. $survey_id);
			$data['basicmsg'] = 'Feedback removed successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);</script>";
			
	}
	//ADD TO CONTACTS
	function add_contact($id)
	{
			
 		$this->survey_model->add_contact($id);
					
	}
	//SURVEY FEEDBACK
	function survey_feedback($survey_id)
	{
			
		$this->survey_model->survey_feedback($survey_id);
			
	}	
	
	//GET QUESTION NAEM
	function get_question($id){
		
		$this->db->where('question_id', $id);
		$q = $this->db->get('survey_questions');
		
		if($q->result()){
			
			$row = $q->row_array();	
			$question = $row['questions'];
		}else{
			
			$question = 'No Found';
		}
		return $question;	
		
	}
	//SURVEY QUESTIONS
	function add_survey_question_do($survey_id)
	{
		$this->survey_model->add_survey_question_do($survey_id);
	}
	
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//REPORTING
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	function view_survey_report($survey_id)
	{
		$this->survey_model-> view_survey_report($survey_id);	
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//EXPORT SURVEY
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	function export_survey_report($survey_id, $name)
	{
		$this->survey_model->export_survey_report($survey_id, $name);	
		
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//EXPORT
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	function export_survey_test()
	{
		
 		$this->survey_model->export_survey_test();	
		
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

	//+++++++++++++++++++++++++++
	//GET ACCCOUNT SETTINGS
	//++++++++++++++++++++++++++

	public function get_config()
	{

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('config');
		if($query->result()){

			$row = $query->row_array();
			return $row['components'];

		}else{

			return '';
		}

	}



}

/* End of file admin.php */
/* Location: ./application/controllers/welcome.php */