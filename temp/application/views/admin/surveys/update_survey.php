<?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>admin_src/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link href="<?php echo base_url('/');?>admin_src/css/bootstrap-colorpicker.min.css" rel="stylesheet">


<style type="text/css">
.myDragClass:hover{ cursor:move}

</style>
<body>
	
	<?php $this->load->view('admin/inc/nav_top');?>
		
	<div class="container-fluid">
		<div class="row-fluid">
			<?php $this->load->view('admin/inc/nav_main');?>
			<div id="content" class="span10">
			<!-- start: Content -->
			
			<div>
				<hr>
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo site_url('/');?>">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>survey/surveys/">Surveys</a><span class="divider">/</span>
					</li>
                    <li>
						Update Survey: <?php if(isset($title)){echo $title;}?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span9">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Update Survey</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="survey-update" name="survey-update" method="post" action="<?php echo site_url('/');?>survey/update_survey_do/" class="form-horizontal">
                             <fieldset>
    									<input type="hidden" name="survey_id"  value="<?php if(isset($survey_id)){echo $survey_id;}?>">
                                        <input type="hidden" name="type"  value="<?php if(isset($type)){echo $type;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Survey title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>

                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Survey URL Slug eg: /surveys-seminar" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>
                                      
                                          <div class="control-group">
                                            <label class="control-label" for="color_primary">Primary Color</label>
                                            <div class="controls">
                                                     <div class="input-append color_primary">
                                                        <input type="text" value="<?php if(isset($color_primary)){echo $color_primary;}?>" name="color_primary" class="form-control" />
                                                        <span class="add-on"><i></i></span>
                                                    </div>  
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="color_secondary">Secondary Color</label>
                                            <div class="controls">
                                                     <div class="input-append color_secondary">
                                                        <input type="text" name="color_secondary" value="<?php if(isset($color_secondary)){echo $color_secondary;}?>" class="form-control" />
                                                        <span class="add-on"><i></i></span>
                                                    </div>  
                                            </div>
                                          </div>
                                          
                                         <div class="control-group">
                                                  <label class="control-label" for="startdate">Start date</label>
                                                  <div class="controls">
                                                           <div class="input-append date" id="startdate">
                                                            <input type="text"  name="datetime"  value="<?php if (isset($datetime)){echo $datetime;}else{ echo date('Y-m-d h:i:s');}?>" data-format="dd-MM-yyyy hh:mm:ss" >
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                          </div> 
                                                          <span class="help-block" style="font-size:11px">Select the startdate for the survey</span>
                                                  </div> 
                                          </div>
                                       
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Survey Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
                                                </div>
                                           </div>
                                         
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Survey</button>
                                           <a href="<?php echo site_url('/');?>survey/show/<?php echo $slug;?>/" target="_blank" style="margin: 0px 10px" class="btn pull-right btn-inverse"><i class="icon-search icon-white"></i> Preview</a>  
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               
               <div class="box span3">
                	<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Background Image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                   	<?php $this->admin_model->get_featured_image('survey', $survey_id);?>
                    </div>
               
               </div>
                
                
			</div>
			
			<hr>
			
			<div class="row-fluid">
				<div class="box span4">
                
                	<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Questions</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="question_div">
                   		<div class="loading_img" style="min-height:100px;width:100%"></div>
                    </div>
                    
                    
                </div>
				<div class="box span8">
                        <div class="box-header">
                            <h2><i class="icon-th"></i><span class="break"></span>Survey Entries</h2>
                            <div class="box-icon">
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                        	<div class="well well-mini">
                                <a class="btn btn-inverse" onClick="view_report()"><i class="icon-eye-open icon-white"></i> View Report</a>
                                <a class="btn btn-primary" onClick="export_report()" id="export_btn"><i class="icon-share icon-white"></i> Export Report</a>
                            </div>    
                        	<div id="feedback">
                       			<div class="loading_img" style="min-height:100px;width:100%"></div>
                            </div>
                        </div>
                </div>
			</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
        
        
        
		<form id="survey_question_add" method="post" action="<?php echo site_url('/');?>survey/add_survey_question_do">		
		<div class="modal hide fade" id="modal-question-add">
			
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Add Question</h3>
			</div>
			<div class="modal-body">
				
                       <div class="control-group">
                            <label class="control-label" for="question">Question</label>
                            <div class="controls">
                                    <input type="text" class="span5" id="question" name="question" placeholder="Question" value="">
                            </div>
                       </div>
                       <div class="control-group">
                            <label class="control-label" for="helptext">Help text</label>
                            <div class="controls">
                                    <input type="text" class="span5" id="helptext" name="helptext" placeholder="Question" value="">
                            </div>
                       </div>


                       <div class="control-group">
                            <label class="control-label" for="video_url">Video URL</label>
                            <div class="controls">
                                    <input type="text" class="span5" id="video_url" name="video_url" placeholder="Video URL" value="">
                            </div>
                       </div>
                       <div class="control-group">
                            <label class="control-label" for="website_url">Website URL</label>
                            <div class="controls">
                                    <input type="text" class="span5" id="website_url" name="website_url" placeholder="Website URL" value="">
                            </div>
                       </div>

                       <div class="control-group">
                            <label class="control-label" for="q_type">Type</label>
                            <div class="controls">
                                <div class="btn-group" data-toggle="buttons-radio">
                                  <button type="button" class="btn btn-primary active">Input</button>
                                  <button type="button" class="btn btn-primary">Text</button>
                                  <button type="button" class="btn btn-primary">Checkbox</button>
                                  <button type="button" class="btn btn-primary">Radio</button>
                                </div> 
                                <input type="hidden" name="q_type" value="" id="q_type"> 
                                <span class="help-block" style="font-size:11px">Input is a normal textbox with 200 character limit. Text area is used for long answers and checkbox are pre-defined values.</span>    
                            </div>
                       </div>

                       <div id="answers_div" class="control-group hide">
                            <label class="control-label" for="answers">Answers</label>
                            <div class="controls">
                                <input type="text" class="search-query" id="answer_select" value="">
                                <button type="submit" class="btn" id="answer_btn_add">Add</button>
                                <input type="hidden" name="q_answers" value="" id="q_answers">
                                <div id="q_answers_pre"></div>     
                            </div>
                       </div>
                
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<button type="submit" class="btn btn-inverse btn pull-right" id="q_butt">Add Question</button>
			</div>
            
		</div>
		</form>
        <form id="survey_question_update" method="post" action="<?php echo site_url('/');?>survey/update_survey_question_do">	
       <div class="modal hide fade" id="modal-question-update">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Update the Question</h3>
          </div>
          <div class="modal-body"  id="update_q_body" style="width:90%">

        
          </div>
          <div class="modal-footer">
            <a data-dismiss="modal" class="btn">Close</a>
            <a href="#" class="btn btn-update btn-primary">Update Question</a>
          </div>
        </div>
        </form>
        
        
        <div class="modal hide fade" id="modal-question-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Question</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current question? All event details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a data-dismiss="modal" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Question</a>
          </div>
        </div>
        
         <div class="modal hide fade" id="modal-feedback-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Feedback</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current feedback? All feedback details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a data-dismiss="modal" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Feedback</a>
          </div>
        </div>
        
        
       <div class="modal fade hide " style="left:40px; top:40px; right:40px; bottom:40px;width:auto; margin:0" id="modal-view-report">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Preview</h3>
          </div>
          <div class="modal-body"  style="bottom:0px; height:auto; max-height:90%;" id="view_report">
           <div class="loading_img" style="min-height:100px;width:100%"></div>
        
          </div>
         
        </div>
        
        <iframe id="export_frame" src="" allowtransparency="true" frameborder="0" style="width:0;height:0"></iframe>           
        <div class="clearfix"></div>
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datetimepicker.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/bootstrap-colorpicker.min.js"></script>
   
	<script type="text/javascript">
	$(document).ready(function(){
		/* ---------- Text Editor ---------- */
		$('.redactor_content').redactor({ 	
					fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
					imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video','file', 'table', 'link','|',
					 'alignment', '|', 'horizontalrule'],
					linebreaks: true,
					focus:true,
					plugins: ['fullscreen', 'fontcolor', 'fontsize','fontfamily']
		});
		
		$('.color_primary').colorpicker();
		$('.color_secondary').colorpicker();
		$('#startdate').datetimepicker({
		  language: 'en',
		  pick12HourFormat: true
		});
		
		
		load_questions();
	
		get_feedback();
	
		$('div.btn-group button').live('click', function(){
			
			var val = $(this).html(), cont = $('#answers_div');
			
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
		
		$('#answer_btn_add').bind('click', function(e){
		
			e.preventDefault();
			var div = $('#q_answers_pre'), input = $('#q_answers'), fake = $('#answer_select');
			
			if(fake.val() != ''){
				input.val(fake.val()+","+input.val());
				div.append('<div><input type="radio" name="correct_answer" value="'+fake.val()+'"> '+fake.val()+'</div>');
				fake.val('');
			}
		});
		
	
		$('#butt').click(function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#title').val().length == 0){
					
					$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a survey title"});
					$('#title').popover('show');
					$('#title').focus();
			
	/*		}else if($('#redactor_content').val() == 0){
		
					$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Survey Body", content:"Please supply us with some survey content"});
					$('#redactor_content_msg').popover('show');
					$('#redactor_content_msg').focus();		*/
				
			}else{
		
				submit_form();
				
			}
		});
		
		
		
		//Featured image
		$('#imgbut').bind('click', function() {
			
			
			var avataroptions = { 
				target:        '#avatar_msg',
				url:       	   '<?php echo site_url('/').'admin/add_featured_image';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
									var percentVal = percentComplete + '%';
									probar.width(percentVal)
									
								},
				 complete: function(xhr) {
									procover.hide();
									probar.width('0%');
									 $('#avatar_msg').html(xhr.responseText);
									 $('#imgbut').html('Update Image');
								}				
		
			}; 
		
			var frm = $('#add-img');
			var probar = $('#procover .bar');
			var procover = $('#procover');
		
			$('#imgbut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});
			
		
		
	});	


	function delete_question(id){
		  
		$('#modal-question-delete').bind('show', function() {
			//var id = $(this).data('id'),
				removeBtn = $(this).find('.btn-primary');
					
				removeBtn.unbind('click').click(function(e) { 
					e.preventDefault();
					removeBtn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');	
					$.ajax({
					  url: "<?php echo site_url('/');?>survey/delete_survey_question/"+id+"/",
					  success: function(data) {
						removeBtn.html('Delete Question');
						$('footer').html(data);
						$('#modal-question-delete').modal('hide');
						load_questions();
					  }
					});
					
				});
		}).modal({ backdrop: true });
	}
	
	function update_question(id){
		
		var  cont = $('#update_q_body');
		cont.empty().addClass('loading_img');
		$.ajax({
				url: "<?php echo site_url('/');?>survey/update_survey_question/"+id+"/",
				success: function(data) {
				  cont.removeClass('loading_img').html(data);
				  $('#update_q_body').html(data);

				}
			  });
	
		$('#modal-question-update').bind('show', function() {
			//var id = $(this).data('id'),
				removeBtn = $(this).find('.btn-update');
				var frm = $('#survey_question_update');	
				removeBtn.unbind('click').click(function(e) { 
					e.preventDefault();
					removeBtn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');	
					$.ajax({
					  method: "POST",
					  data: frm.serialize(),	
					  url: "<?php echo site_url('/');?>survey/update_survey_question_do/"+id+"/",
					  success: function(data) {
						removeBtn.html('Update Question');
						
						$('#modal-question-update').modal('hide');
						load_questions();
					  }
					});
					
				});
		}).modal({ backdrop: true });
	}
	
	
	function add_question(){
		
			$('#modal-question-add').bind('show', function() {
				//var id = $(this).data('id'),
					var removeBtn = $(this).find('.btn-inverse');
					var frm = $('#survey_question_add');	
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						removeBtn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');	
						$.ajax({
						  type: 'post',
						  data: frm.serialize(),
						  url: "<?php echo site_url('/');?>survey/add_survey_question_do/<?php echo $survey_id;?>/",
						  success: function(data) {
							$('footer').html(data);
							removeBtn.html('Add Question');	
							$('#modal-question-add').modal('hide');
							$('#q_answers_pre').empty();
							$('#q_answers').val('');
							$('#answer_select').val('');
							$('#question').val('');
							$('#helptext').val('');
							load_questions();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		
		
	}

	function view_report(){
		 var cont = $('#view_report');
		cont.empty().addClass('loading_img');
			$('#modal-view-report').bind('show', function() {

					$.ajax({
						  type: 'get',
						  url: "<?php echo site_url('/');?>survey/view_survey_report/<?php echo $survey_id;?>/",
						  success: function(data) {
							cont.html(data).removeClass('loading_img');
	
							
						  }
					});
						
					
			}).modal({ backdrop: true });
		
		
	}
	function export_report(){
			
			var btn = $('#export_btn'), frame = $('#export_frame');
			btn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
					type: 'get',
					url: "<?php echo site_url('/');?>survey/export_survey_report/<?php echo $survey_id.'/'.$slug;?>/",
					success: function(data) {
					  //cont.html(data).removeClass('loading_img');
						btn.html('<i class="icon-share icon-white"></i> Export Report');
					    frame.attr('src','<?php echo site_url('/');?>survey/export_survey_report/<?php echo $survey_id.'/'.$slug;?>');
					}
			});
			
			
	}
 
	function submit_form(){
			
			var frm = $('#survey-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'survey/update_survey_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Update Survey');
					
				}
			});	
	
	}
	
	
	
	function get_feedback(){
		
			$.get('<?php echo site_url('/'). 'survey/survey_feedback/'.$survey_id.'/';?>', function(data) {
			  		$('#feedback').html(data);
			  		$('#survey_entries_tbl').dataTable( {
					  	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ "
						},
						"aaSorting":[],
						"bSortClasses": false
			
					} );
					$('#survey_entries_tbl_paginate').parent().removeClass('span6').addClass('span12');
					$('#survey_entries_tbl_table_length').find('select').addClass('span6');
					$('#survey_entries_tbl_table_length').parent().removeClass('span6').addClass('span4');
					$('#survey_entries_tbl_table_filter').parent().removeClass('span6').addClass('span8');	
			});
		
	}
	
	function load_questions(){
		
		//Load Members
		$.get('<?php echo site_url('/'). 'survey/survey_questions/'.$survey_id.'/';?>', function(data) {
			  	$('#question_div').html(data).removeClass('loading_img');
			  		/*$('#subscriber_table').dataTable( {
					  	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ "
						},
						"aaSorting":[],
						"bSortClasses": false
			
					} );
					$('.dataTables_paginate').parent().removeClass('span6').addClass('span12');
					$('#subscriber_table_length').find('select').addClass('span6');
					$('#subscriber_table_length').parent().removeClass('span6').addClass('span4');
					$('#subscriber_table_filter').parent().removeClass('span6').addClass('span8');	*/
					
					
			});
		
	}
	
	  function delete_feedback(id){
			
		  $('#modal-feedback-delete').bind('show', function() {
			  //var id = $(this).data('id'),
				  removeBtn = $(this).find('.btn-primary');
					  
				  removeBtn.unbind('click').click(function(e) { 
					  e.preventDefault();	
					  $.ajax({
						url: "<?php echo site_url('/');?>survey/delete_survey_feedback/"+id+"/",
						success: function(data) {
						  
						  $('footer').html(data);
						  $('#modal-feedback-delete').modal('hide');
						  get_feedback();
						}
					  });
					  
				  });
		  }).modal({ backdrop: true });
	  }	

	</script>
</body>
</html>