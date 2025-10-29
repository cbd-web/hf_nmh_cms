<?php
class Survey_model extends CI_Model{
	
 	function survey_model(){
  		//parent::CI_model();
			
 	}


	//+++++++++++++++++++++++++++
	//GET FEATURED IMAGE FRONT
	//++++++++++++++++++++++++++

	function get_featured_image_front($id, $type, $bus_id){


		$this->db->where('bus_id', $bus_id);
		$this->db->where('type', $type);
		$this->db->where('type_id', $id);

		$query = $this->db->get('images');

		if($query->result()){

			$row = $query->row();
			$img = S3_URL.'assets/images/'.$row->img_file;

			return $img;

		}else{

			return FALSE;

		}


	}

	//+++++++++++++++++++++++++++
	//ADD PAGE DO
	//++++++++++++++++++++++++++	
	function add_survey_do()
	{
			$content = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			$title = $this->input->post('title', TRUE);
			$date = $this->input->post('datetime', TRUE);
			$type = $this->input->post('type', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$creator = $this->session->userdata('u_name');
			$url = "";
			$bus_id = $this->session->userdata('bus_id');
			//$id = $this->input->post('page_id', TRUE);

		  
			if($slug == ''){
				
				$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'pages');
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
//				$val = FALSE;
//				$error = 'Page title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Page Content Required';	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
						'title'=> $title ,
						'datetime'=> $date,
						'description'=> $content,
						'url' => $url,
						'slug' => $slug,
						'creator' => $creator,
						'type' => strtolower($type),
						'bus_id'=> $bus_id
				);

			if($val == TRUE){
				
					
					$this->db->insert('surveys', $insertdata);
					$id = $this->db->insert_id();
					
					
					//LOG
					$this->admin_model->system_log('add_new_survey-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Survey added successfully');
					$data['basicmsg'] = 'Survey has been added successfully';
					echo "
					<script type='text/javascript'>
					var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);
					window.location = '".site_url('/')."survey/update_survey/".$id."/';
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
	//Update SURVEY
	function update_survey_do()
	{
			
			$content = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
			
			$title = $this->input->post('title', TRUE);
			$datetime = $this->input->post('datetime', TRUE);
			
			$type = $this->input->post('type', TRUE);
			$creator = $this->session->userdata('u_name');
			
			$bus_id = $this->session->userdata('bus_id');
			$id = $this->input->post('survey_id', TRUE);
			$slug = $this->input->post('slug', TRUE);
			$color_primary = $this->input->post('color_primary', TRUE);
			$color_secondary = $this->input->post('color_secondary', TRUE);
			$url = "javascript:show_event('".$id."')";
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
//				$val = FALSE;
//				$error = 'Page title Required';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			/*}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Page Content Required';*/	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
						'title'=> $title ,
						'datetime'=>  date('Y-m-d H:i:s' ,strtotime($datetime)),
						'description'=> $content,
						'url' => $url,
						'slug' => $slug,
						'creator' => $creator,
						'type' => strtolower($type),
						'bus_id'=> $bus_id,
						'color_secondary' => $color_secondary,
						'color_primary' => $color_primary
				);
	
			
			if($val == TRUE){
				
					$this->db->where('survey_id' , $id);
					$this->db->update('surveys', $insertdata);
					//success redirect	
					$data['survey_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_survey-'. $id);
					
					
					
					$data['basicmsg'] = 'Survey has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
			
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
			
			$this->db->where('survey_id' , $survey_id);
			$this->db->order_by('sequence', 'ASC');
			$q = $this->db->get('survey_questions');
			echo '<div class="well well-mini">
					<a class="btn btn-inverse" onclick="add_question()"><i class="icon-question-sign icon-white"></i> Add Question</a>
				  </div>';
			if($q->result()){
				echo'
					<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable" id="sortable" width="100%">
						<thead>
							<tr style="font-size:14px">
								<th style="width:45%;font-weight:normal">Question </th>
								<th style="width:45%;font-weight:normal">Answers </th>
								<th style="width:10%;min-width:60px;;font-weight:normal"></th>
							</tr>
						</thead>
						<tbody>';
				foreach($q->result() as $row){
					
					$array = json_decode($row->answers);
					$ans = '';
					if(count($array) > 0){
						
						foreach($array as $roww){

							if($row->correct_answer == $roww){
								$ca = 'badge-success';
							} else { $ca = ''; }
							
							$ans .= '<span class="badge '.$ca.'">'.$roww.'</span> ';
							
						}
						
					}
					echo '<tr class="myDragClass">
							<td>
							<input type="hidden" value="'.$row->question_id.'" />
							'.$row->questions.'</td>
							<td>'.$ans.'</td>
							<td style="width:10%;min-width:60px;;font-weight:normal"><a onClick="delete_question('.$row->question_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
								<a onClick="update_question('.$row->question_id.')" class="btn btn-mini btn-success"><i class="icon-pencil icon-white"></i></a>
							</td>
						  </tr>';	
						
				}
				echo '</tbody>
				</table>
				<script type="text/javascript">
				
									
					// Return a helper with preserved width of cells
					var fixHelper = function(e, ui) {
						ui.children().each(function() {
							$(this).width($(this).width());
						});
						return ui;
					};
					
					$("#sortable tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {
						 
						},
						stop: function(e, info) {
							
						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable tbody").find("input:hidden");
						  
							  sibs.each(function(i,item){
									var img_id = $(this).val(), index = i;
									console.log(img_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'survey/update_question_sequence/"+img_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				
				</script>
				
				';	
				
			}else{
				
				echo '<div class="alert">No Questions added</div>';
				
			}
			
	}
	
	
	//DELETE QUESTION
	function delete_survey_question($id)
	{
			
			$this->db->where('question_id' , $id);
			$this->db->delete('survey_questions');
						//LOG
			$this->admin_model->system_log('delete_question-'. $survey_id);
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
			
			$this->db->where('feedback_id' , $id);
			$f = $this->db->get('survey_feedback');
			$f = $f->row_array();
			$this->db->where('email', $f['email']);
			$this->db->where('bus_id', $f['bus_id']);
			$test = $this->db->get('subscribers');
			if($test->result()){
				
				$data['name'] = $f['name'];
				$data['email'] = $f['email'];
				$data['dob'] = date('Y-m-d', strtotime('-'.$f['age'].' day', date()));
				$data['phone'] = $f['cell'];
				$this->db->insert('subscribers', $data);	
				
				//LOG
				$this->admin_model->system_log('contact_added-'. $id);
				$data['basicmsg'] = 'Contact Added';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						  noty(options);</script>";
			}else{
				
				
				$data['basicmsg'] = 'Contact Already Exists';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'error'};
						  noty(options);</script>";
				
			}
			
			
	}
	//SURVEY FEEDBACK
	function survey_feedback($survey_id)
	{
			
			$this->db->where('survey_id' , $survey_id);
			$q = $this->db->get('survey_feedback');
			
			if($q->result()){
				echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" id="survey_entries_tbl" class="table table-striped datatable"  width="100%">
						<thead>
							<tr style="font-size:14px">
								<th style="width:10%;font-weight:normal">Name </th>
								<th style="width:50%;max-width:300px;font-weight:normal">Answers </th>
								<th style="width:15%;font-weight:normal">Email </th>
								<th style="width:10%;font-weight:normal">Cell </th>
								<th style="width:5%;font-weight:normal">Age </th>
								<th style="width:10%;font-weight:normal"> </th>
							</tr>
						</thead>
						<tbody>';
				foreach($q->result() as $row){

					if($row->answer != '""'){

						$array = get_object_vars(json_decode($row->answer));

						$ans = '';
						if(count($array) > 0){
							
							foreach($array as $roww => $key){
								
								if(is_array($key)){
									$q = $this->get_question($roww);
									$val = '';
									foreach($key as $rowf => $keyf){
										
										$val .= $keyf. ' - ';
										
									}
									$ans .= '<span class="badge" title="'.$q.'" rel="tooltip" style="white-space: normal;">' .$val.'</span> ';
									
								}else{
									$q = $this->get_question($roww);
									$ans .= '<span class="badge" title="'.$q.'" rel="tooltip" style="white-space: normal;">' .$key.'</span> ';									
								}
								

								
							}
							
						}
						echo '<tr>
								<td>'.$row->name.'</td>
								<td style="width:50%;max-width:300px;font-weight:normal">'.$ans.'</td>
								<td>'.$row->email.'</td>
								<td>'.$row->cell.'</td>
								<td>'.$row->age.'</td>
								<td><a class="btn btn-mini btn-danger" title="Delete Feedback" rel="tooltip" onclick="delete_feedback('.$row->feedback_id.')"><i class="icon-trash icon-white"></i></a>
									<a class="btn btn-mini btn-success" title="Add User as Contact" rel="tooltip" onclick="add_contact('.$row->feedback_id.')"><i class="icon-user icon-white"></i></a>
								</td>
							  </tr>';
					}	
						
				}
				echo '</tbody>
				</table>
				<script type="text/javascript">
					$(document).ready(function(){	
						  
						$("[rel=tooltip]").tooltip();	  
					});
				
				</script>
				
				';	
				
			}else{
				
				echo '<div class="alert">No Feedback has been left</div>';
				
			}
			
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
			$question = $this->input->post('question',TRUE);
			$answer = $this->input->post('q_answers',TRUE);
			$answer  = substr($answer, 0 , (strlen($answer) - 1));
			$answer  = json_encode(explode(",",$answer));
			$type = $this->input->post('q_type',TRUE);
			$correct_answer = $this->input->post('correct_answer',TRUE);
			$help = $this->input->post('helptext',TRUE);
			$video_url = $this->input->post('video_url',TRUE);
			$website_url = $this->input->post('website_url',TRUE);

			if($correct_answer == '0') {

				$correct_answer = '';

			}


			if($question != ''){
				
				if($type == ''){ $type = 'Input';}
				
				$insertdata = array(
							'questions'=> $question ,
							'survey_id'=> $survey_id,
							'answers' => $answer,
							'correct_answer' => $correct_answer,
							'help_text' => $help,
							'video_url' => $video_url,
							'website_url' => $website_url,
							'type' => strtolower($type),
							'sequence'=> 0
				);
				$this->db->insert('survey_questions', $insertdata);
				
				//LOG
				$this->admin_model->system_log('add_question-'. $survey_id);
				$data['basicmsg'] = 'Question Added';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						  noty(options);</script>";
						  
			}else{

				$data['basicmsg'] = 'Please fill in the question field';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'error'};
						  noty(options);</script>";	
				
			}
	}
	//+++++++++++++++++++++++++++
	//UPDATE QUESTION
	//++++++++++++++++++++++++++
	public function update_survey_question($id)
	{

		  $this->db->where('question_id', $id);
		  $q = $this->db->get('survey_questions');		
		  
		  if($q->result()){
			  $q = $q->row();
			  $i = '';$t = '';$c = '';$r ='';
			  if($q->type == 'input'){
				 $i = 'active'; 
			  }elseif($q->type == 'text'){
				 $t = 'active'; 
			  }elseif($q->type == 'checkbox'){
				$c = 'active';  
			  }elseif($q->type == 'radio'){	 	  
				$r = 'active';   
			  }
			  
			  //ANSWERS
			  $ans = '';$ans_c = '';$show = 'hide';
			  $arr = json_decode($q->answers);
			  if(is_array($arr)){
					$ans = '';
					if(count($arr) > 0 && $q->answers != '[""]'){
						$show = '';
						foreach($arr as $row => $key){
							$ans_c .= "".$key.",";

							if($q->correct_answer == $key) { $selected = 'checked'; } else { $selected = ''; }

							$ans .= '<div><input type="radio" name="correct_answer" value="'.$key.'" '.$selected.'> '.$key.'</div> ';
						}
					}
					 	
				
			  }

			  echo '		
						   <div class="control-group">
								<label class="control-label" for="question">Question</label>
								<div class="controls">
										<input type="text" class="span5" id="question_u" name="question_u" placeholder="Question" value="'.$q->questions.'">
										<input type="hidden" name="q_type_id" value="'.$q->question_id.'"> 
								</div>
						   </div>
						   <div class="control-group">
								<label class="control-label" for="helptext">Help text</label>
								<div class="controls">
										<input type="text" class="span5" id="helptext_u" name="helptext_u" placeholder="Question" value="'.$q->help_text.'">
								</div>
						   </div>

						   <div class="control-group">
								<label class="control-label" for="video_url_u">Video URL</label>
								<div class="controls">
										<input type="text" class="span5" id="video_url_u" name="video_url_u" placeholder="Video URL" value="'.$q->video_url.'">
								</div>
						   </div>
						   <div class="control-group">
								<label class="control-label" for="website_url_u">Website URL</label>
								<div class="controls">
										<input type="text" class="span5" id="website_url_u" name="website_url_u" placeholder="Website URL" value="'.$q->website_url.'">
								</div>
						   </div>
	
						   <div class="control-group">
								<label class="control-label" for="q_type_u">Type</label>
								<div class="controls">
									<div class="btn-group" data-toggle="buttons-radio">
									  <button type="button" class="btn btn-primary '.$i.'">Input</button>
									  <button type="button" class="btn btn-primary '.$t.'">Text</button>
									  <button type="button" class="btn btn-primary '.$c.'">Checkbox</button>
									  <button type="button" class="btn btn-primary '.$r.'">Radio</button>
									</div> 
									<input type="hidden" name="q_type_u" value="'.$q->type.'" id="q_type_u"> 
									<span class="help-block" style="font-size:11px">Input is a normal textbox with 200 character limit. Text area is used for long answers and checkbox are pre-defined values.</span>    
								</div>
						   </div>
	
						   <div id="answers_div_u" class="control-group '.$show.'">
								<label class="control-label" for="answers">Answers</label>
								<div class="controls">
									<input type="text" class="search-query" id="answer_select_u" value="">
									<button type="submit" class="btn" id="answer_btn_add_u">Add</button>
									<button type="submit" class="btn" id="answer_btn_remove_u">Clear</button>
									<input type="hidden" name="q_answers_u" value="'.$ans_c.'" id="q_answers_u">
									<div id="q_answers_pre_u">'.$ans.'</div>     
								</div>
						   </div>';
					
			echo "<script type='text/javascript'>
					$(document).ready(function(){
						
							$('div.btn-group button.btn-primary').live('click', function(){
								
								var val = $(this).html(), cont = $('#answers_div_u');
								
								if(val == 'Checkbox'){
									
									$('#q_type').attr('value', val);
									cont.slideDown();
								}else if(val == 'Radio'){
									
									$('#q_type').attr('value', val);
									cont.slideDown();
									
								}else{
									
									$('#q_type').attr('value', val);
									cont.slideUp();
								}
								
								
							});
							
							 $('#answer_btn_remove_u').bind('click', function(e){
								 
									e.preventDefault();
									var div = $('#q_answers_pre_u'), input = $('#q_answers_u'), fake = $('#answer_select_u');
									
									input.val('');
									div.empty();
									fake.val('');
							});
							
							 $('#answer_btn_add_u').bind('click', function(e){
			
									e.preventDefault();
									var div = $('#q_answers_pre_u'), input = $('#q_answers_u'), fake = $('#answer_select_u');
									
									if(fake.val() != ''){
										input.val(fake.val()+','+input.val());
										div.append('<div><input type=\"radio\" name=\"correct_answer\" value=\"'+fake.val()+'\"> '+fake.val()+'</div>');
										fake.val('');
									}
							 });

							
							
						});
						

					</script>
					";
			  
		  }else{
			  
			echo '<div class="alert">Question not found, Sorry!</div>';  
			  
		  }
		

	}
	
	//+++++++++++++++++++++++++++
	//UPDATE QUESTION DO
	//++++++++++++++++++++++++++
	public function update_survey_question_do()
	{

		 	$question = $this->input->post('question_u',TRUE);
			$answer = $this->input->post('q_answers_u',TRUE);
			$answer  = substr($answer, 0 , (strlen($answer) - 1));
			$answer  = json_encode(explode(",",$answer));
			$correct_answer = $this->input->post('correct_answer',TRUE);
			$type = $this->input->post('q_type_u',TRUE);
			$help = $this->input->post('helptext_u',TRUE);
			$video_url = $this->input->post('video_url_u',TRUE);
			$website_url = $this->input->post('website_url_u',TRUE);
			$id = $this->input->post('q_type_id',TRUE);

			if($correct_answer == '0') {

				$correct_answer = '';

			}


			if($question != ''){
				
				if($type == ''){ $type = 'Input';}
				
				$insertdata = array(
							'questions'=> $question ,
							'answers' => $answer,
							'correct_answer' => $correct_answer,
							'help_text' => $help,
							'video_url' => $video_url,
							'website_url' => $website_url,
							'type' => strtolower($type),
							'sequence'=> 0
				);
				
				$this->db->where('question_id', $id);
				$this->db->update('survey_questions', $insertdata);
				
				//LOG
				$this->admin_model->system_log('update_question-'. $survey_id);
				$data['basicmsg'] = 'Question Updated';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						  noty(options);</script>";
						  
			}else{

				$data['basicmsg'] = 'Please fill in the question field';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'error'};
						  noty(options);</script>";	
				
			}

	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//REPORTING
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	function view_survey_report($survey_id)
	{
		$this->db->where('survey_id', $survey_id);
		$q = $this->db->get('survey_questions');
		
		if($q->result()){
			
			//ASSIGN COUNT ANSWER ARRAYS
			foreach($q->result() as $qrow){
				
				//echo $qrow->answers.'<br />';
				if($qrow->answers == '[""]'){
					$count_q_a[$qrow->question_id][] = '';
				}else{
					$a = json_decode($qrow->answers);
					//print_r((array) $a);
					foreach($a as $r1 => $r1k){
							//echo $r1k;
							$count_q_a[$qrow->question_id][$r1k] = '';
						
					}
				}
					
			}
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable" >
					<thead>
						<tr style="font-size:14px">
							<th style="width:30%;font-weight:normal">Question </th>
							<th style="width:60%;max-width:300px;font-weight:normal">Answers </th>
							<th style="width:10%;font-weight:normal"> </th>
						</tr>
					</thead>
					<tbody>';
			
			//LOOP FEEDBACK ARRAY
			$this->db->where('survey_id', $survey_id);
			$f = $this->db->get('survey_feedback');
			$fanswers = array();
			$fanswers_temp = array();
			$answers = array();
			if($f->result()){
				$temp = '';
				foreach($f->result() as $frow){
					
					$temp = get_object_vars(json_decode($frow->answer));
					array_push($answers, $temp);	
				}
				//var_dump($temp);
				//echo '----<br />';
				
				//echo '----<br />';
				$x = 0;$ix = 0;$x1 = 0; $x2 = 0;
				foreach($answers as $arrow => $arrkey){
					
					foreach($arrkey as $subrow => $subkey){
						//echo $subrow.' sub: '.$subkey. '<br />';
						if(is_array($subkey)){
							$temp_key = '';
							foreach($subkey as $subsubrow => $subsubkey){
								
								$fanswers[$subrow][$ix] = $subsubkey;

								//count amounts
								$count_q_a[$subrow][$subsubkey] = $count_q_a[$subrow][$subsubkey] +1;
								//echo $ix . ' x1: '.$x1.' x2: '.$x2.' temp: '.$temp_key. ' sub: '.$subsubkey.' = ' .$count_q_a[$subsubkey] . '<br />';
								
								$temp_key = $subsubkey;
								$ix ++;	
							}

						}else{
							
							
							$count_q_a[$subrow][$subkey] = $count_q_a[$subrow][$subkey] +1;
							$fanswers[$subrow][$x] = $subkey;
							
						}
						$x ++;
						//echo $subrow . ' ' .$subkey;
					}
					//echo var_dump($arrkey) . ' ' .$arrow;
						
				}
				
				//var_dump($fanswers);
				//echo '----<br />';
				
			}
			//var_dump($answers);
			//var_dump($count_q_a);
			//LOOP EACH Q
			foreach($q->result() as $qrow){
				$ans = '';$z = 0;
				//GET ANSWERS
				if($fanswers[$qrow->question_id]){
					
					foreach($fanswers[$qrow->question_id] as $ans_row){
						if($z == 0){
							
							$ans .= '<span class="badge">'.$ans_row.'</span> ';	
						}else{
							
							$ans .= '<span class="badge">'.$ans_row.'</span> ';	
						}
						
						
					}
						
					
				}
				$fstr = '';
				//GET PREDEFINED VALUES
				if($qrow->type == 'checkbox' || $qrow->type == 'radio'){
					$fstr .='<font style="font-size:10px;">Answer Summary</font><br />';
					
					$ct ='';$cx = 0;
					foreach($count_q_a[$qrow->question_id] as $r => $rk){
						
						if($count_q_a[$qrow->question_id][$r] > 0){
							$fstr .= '<span class="label label-success">'.$r .' : <strong>'.$rk .'<strong></span><br />';
						}
					}
					
					//$fstr = implode(",",$count_q_a);
					
				}
				
				echo '<tr>
						<td style="width:20%;font-weight:normal">'.$qrow->questions.'<br />'.$fstr.'</td>
						<td style="width:70%;max-width:800px;overflow:hidden;font-weight:normal">'.$ans.'</td>
						<td style="width:10%;font-weight:normal"></td>
					  </tr>';	
				
				
			}//end Q
			
			echo '</tbody>
				</table>';
			//var_dump($answers);	
		}//end if results
		
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//EXPORT
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	function export_survey_report($survey_id, $name)
	{
		
		//LOOP FEEDBACK ARRAY
		$this->db->where('survey_id', $survey_id);
		$f = $this->db->get('survey_feedback');
		$answers = array();
		$array = array();
		$questions ='';
		$qstr ='';
		if($f->result()){
			$temp = '';

			//GET QUESTIONS
			$this->db->where('survey_id', $survey_id);
			$q = $this->db->get('survey_questions');
			$questions;
			$qx = 0;
			$qcount = 0;
			if($q->result()){
				$qcount = $q->num_rows();
				//COLUMN HEADERS
				$array = array(
					array("id", "Name", "Email", "Cell", "Age")
					);
				
				foreach($q->result() as $row){
					//BUILD Q Column
					if($qx == 0){
						$questions = $row->questions;
						array_push($array[0], $questions);
						
					}else{
						$questions = $row->questions;
						array_push($array[0], $questions);
					}
						
					
				}
				
			}

				  
			foreach($f->result() as $frow){
				$z = 0;	
				//PUT ANSWERS INTO COLUMNS
				$tempq = get_object_vars(json_decode($frow->answer));
				foreach($tempq as $temprow => $tempkey){
					
					if(is_array($tempkey)){
						$y = 0;
						$k = '';
						foreach($tempkey as $subrow => $subkey){
							
							
							if($z == 0){
								if($k == $subrow){
									
									if(count($tempkey) == 1){
										
										$qstr .= "".$subkey."";
									}else{
										
										$qstr .= "".$subkey." - ";
									}
									
									
								}else{
									
									$qstr .= "".$subkey."";
								}
							}else{
								if($k == $subrow){
									$qstr .= " - ".$subkey."";
								}else{
									$qstr .= ",".$subkey."";
									
								}
							}
							//echo $subrow. ' ' .$subkey.'<br />';
							$k = $subrow;
							$y ++;
						}
						
						$z ++;
						
					}else{
						
					
						if($z == 0){
							$qstr .= "".$tempkey."";
							
						}else{
							$qstr .= ",".$tempkey."";
							
						}
						
						$z ++;
					}

					
					$tempq = '';
					$z ++;
				}
				
				$str_final = explode(",",$qstr);
				$temp = explode(",", $frow->feedback_id.",". "".$frow->name.",".$frow->email.",'".$frow->cell."',".$frow->age."");
				$fin = array_merge($temp, $str_final);
				array_push($array, $fin);
				
				$qstr = '';
					
			}//end foreach feedback

			
		}
		$this->load->helper('csv');
		//var_dump($array);
		echo array_to_csv($array, 'survey_'.$name.'.csv');
		//echo array_to_csv($array);
		
	}

		
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//EXPORT
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	function export_survey_test()
	{
		$array = array(
		array('Last Name', 'First Name', 'Gender'),
			array('Furtado', 'Nelly', 'female'),
			array('Twain', 'Shania', 'female'),
			array('Farmer', 'Mylene', 'female')
		);
		 
		$this->load->helper('csv');
		var_dump($array);
		echo array_to_csv($array);
 		
		
	}	
	
	
	
	//+++++++++++++++++++++++++++
	//GET PUBLIC SETTINGS
	//++++++++++++++++++++++++++		 
		 
	function get_public_settings($event_id){
		
		$event = $this->db->where('event_id', $event_id);
		$event = $this->db->get('calendar_events');
		
		if($event->result()){
			
			$row = $event->row();
			$test = $this->db->where('bus_id', $row->bus_id);
			$test = $this->db->get('settings');
			return $test->row_array();	
	
			
		}


	}
	
	//+++++++++++++++++++++++++++
	//GET ALL EVENTS
	//++++++++++++++++++++++++++
	public function get_all_surveys()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('surveys');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:34%;font-weight:normal">Listing Date </th>
						<th style="width:40%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr>
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer"
						href="'.site_url('/').'survey/update_survey/'.$row->survey_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:34%">'.date('d-m-Y H:i:s' ,strtotime($row->datetime)).'</td>
						<td style="width:40%;text-align:right">
						<a title="Edit Survey" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'survey/update_survey/'.$row->survey_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Survey" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_survey('.$row->survey_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
				
				</script>';
			
		  }else{
			 
			 echo '<div class="alert">
			 		<h3>No Survey added</h3>
					No surveys have been added. To add a new survey please click on the add button on the right</div>';
		  
		 }
		  
				
				
		
	}
	
	
	
	//+++++++++++++++++++++++++++
	//GET ALL SERVEY QUESTIONS LSIT
	//++++++++++++++++++++++++++
	public function get_survey_question_list($survey_id, $step = '', $leadcapture)
	{
		 
		  $query = $this->db->where('survey_id', $survey_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('survey_questions');
		  if($query->result()){
			  

			
			foreach($query->result() as $row){
					
					$input = $row->type;

					
					echo '<div id="step'.$y.'" class="row-fluid text-center '. $step_str. '">
								<div class="span12">
								
								<label><h2>'.$row->questions.'</h2></label>
								';
								if($row->type == 'text'){	
									echo '<textarea name="q_'.$row->question_id.'" id="q_'.$row->question_id.'" class="span10" placeholder="" tabindex="'.$x.'"></textarea>';
										 
								}elseif($row->type == 'checkbox'){
									//echo $row->answers;
									$arr = json_decode($row->answers);
									//var_dump($arr);
									if(count($arr) > 0){
										echo '<div style="clear:both;width:100%;text-align:center">';
										$cc = 0;
										foreach($arr as $r => $k){
											
											echo '<div style="margin:10px;padding:10px 30px;text-align:right;width:30%;" class="btn">
													<input type="checkbox" style="left:30px;float:right" value="'.$k.'" id="q_'.$row->question_id.$z.'" name="q_'.$row->question_id.'[]" />
													<label for="q_'.$row->question_id.$z.'" style="margin-right:20px; ">'.$k.'</label>
												  	
												  </div>	
													';
											$cc ++;
										}
										echo '</div>';
									}
									
								}elseif($row->type == 'radio'){
								
									$arr = json_decode($row->answers);
									//var_dump($arr);
									if(count($arr) > 0){
										echo '<div style="clear:both;width:100%;">';
										foreach($arr as $r => $k){
											
											echo '<div style="margin:10px;padding:10px 30px;text-align:right;width:30%;" class="btn">
													<input type="radio" style="left:30px;float:right" value="'.$k.'" id="q_'.$row->question_id.$z.'" name="q_'.$row->question_id.'" />
												  	<label for="q_'.$row->question_id.$z.'" style="margin-right:20px; ">'.$k.'</label>
												  </div>	
													';
											
										}
										echo '</div>';
									}
									
								}else{
									echo '<input type="text" class="span10" name="q_'.$row->question_id.'" id="q_'.$row->question_id.'" placeholder="" tabindex="'.$x.'">';
									
									
								}
								$help= '';
								if($row->help_text != ''){
									
									$help= '<p style="text-align:center; clear:both">'.$row->help_text.'</p>';
								}
								
					echo '
							 '.$help.'
							</div>
							'.$btn.'
						</div>';

				}
				
				//LOOP JAVA
				echo '<script type="text/javascript">
							$(document).ready(function(){
						';
						foreach($query->result() as $row2){
						
							echo '$("#q_'.$row2->question_id.'").focus(updateFocus);';
						
						}
				echo '    });
					</script>';
			
		  }else{
			 
			 echo '<div class="alert">
			 		<h3>No Survey added</h3>
					No surveys have been added. To add a new survey please click on the add button on the right</div>';
		  
		 }
	
	}	
	
	
	
	
	
	//+++++++++++++++++++++++++++
	//GET ALL SERVEY QUESTIONS WIZARD
	//++++++++++++++++++++++++++
	public function get_survey_question($survey_id, $step = '', $leadcapture)
	{
		 
		  $query = $this->db->where('survey_id', $survey_id);
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->get('survey_questions');
		  if($query->result()){
			$x = 1;
			$y = 2;
			$z = 3;
			$count = count($query->result());
			$step_str = 'hide';

			
			foreach($query->result() as $row){
					
					$input = $row->type;

					if($x == 1){
						
						if($step != ''){
							
							$step_str = '';
								
						}	
						if(!$leadcapture){
							$step_str = '';		
						}
					}
					

					
					if($count == $x){
						$btn = '<a title="Next" onClick="final_submit()" class="btn" >Next</a>';
					}else{
						
						$btn = '<a title="Next" onClick="next_step('.$z.')" class="btn">Next</a>';	
					}
					
					echo '<div id="step'.$y.'" class="row-fluid text-center '. $step_str. '">
								<div class="span12">
								
								<label><h2>'.$row->questions.'</h2></label>
								';
								if($row->type == 'text'){	
									echo '<textarea name="q_'.$row->question_id.'" id="q_'.$row->question_id.'" class="span10" placeholder="" tabindex="'.$x.'"></textarea>';
										 
								}elseif($row->type == 'checkbox'){
									//echo $row->answers;
									$arr = json_decode($row->answers);
									//var_dump($arr);
									if(count($arr) > 0){
										echo '<div style="clear:both;width:100%;text-align:center">';
										$cc = 0;
										foreach($arr as $r => $k){
											
											echo '<div style="margin:10px;padding:10px 30px;text-align:right;width:30%;" class="btn">
													<input type="checkbox" style="left:30px;float:right" value="'.$k.'" id="q_'.$row->question_id.$z.'" name="q_'.$row->question_id.'[]" />
													<label for="q_'.$row->question_id.$z.'" style="margin-right:20px; ">'.$k.'</label>
												  	
												  </div>	
													';
											$cc ++;
										}
										echo '</div>';
									}
									
								}elseif($row->type == 'radio'){
								
									$arr = json_decode($row->answers);
									//var_dump($arr);
									if(count($arr) > 0){
										echo '<div style="clear:both;width:100%;">';
										foreach($arr as $r => $k){
											
											echo '<div style="margin:10px;padding:10px 30px;text-align:right;width:30%;" class="btn">
													<input type="radio" style="left:30px;float:right" value="'.$k.'" id="q_'.$row->question_id.$z.'" name="q_'.$row->question_id.'" />
												  	<label for="q_'.$row->question_id.$z.'" style="margin-right:20px; ">'.$k.'</label>
												  </div>	
													';
											
										}
										echo '</div>';
									}
									
								}else{
									echo '<input type="text" class="span10" name="q_'.$row->question_id.'" id="q_'.$row->question_id.'" placeholder="" tabindex="'.$x.'">';
									
									
								}
								$help= '';
								if($row->help_text != ''){
									
									$help= '<p style="text-align:center; clear:both">'.$row->help_text.'</p>';
								}
								
					echo '
							 '.$help.'
							</div>
							'.$btn.'
						</div>';
					$y ++;
					$x ++;
					$z ++;
					$step_str = 'hide'; 
				}
				
				//LOOP JAVA
				echo '<script type="text/javascript">
							$(document).ready(function(){
						';
						foreach($query->result() as $row2){
						
							echo '$("#q_'.$row2->question_id.'").focus(updateFocus);';
						
						}
				echo '    });
					</script>';
			
		  }else{
			 
			 echo '<div class="alert">
			 		<h3>No Survey added</h3>
					No surveys have been added. To add a new survey please click on the add button on the right</div>';
		  
		 }
	
	}	
	//+++++++++++++++++++++++++++
	//GET SURVEYS SELECT
	//++++++++++++++++++++++++++
	public function get_surveys_select()
	{
		
		$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$get = $this->db->get('surveys');
		if($get->result()){
			
			echo '<select name="survey_inc" class="span6">
					   <option value="0">None</option>';
			foreach($get->result() as $row){
				
				echo '<option value="'.$row->survey_id.'">'.$row->title.'</option>';	
				
			}
			echo '</select>';
		}

	}
	
	//+++++++++++++++++++++++++++
	//GET PUBLIC SETTINGS
	//++++++++++++++++++++++++++		 
		 
	function get_settings($bus_id){

		$test = $this->db->where('bus_id', $bus_id);
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
		$this->db->where('bus_id', $this->session->userdata('bus_id'));
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
?>