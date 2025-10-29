  <?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>admin_src/css/datepicker.css" rel="stylesheet">
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
						<a href="<?php echo site_url('/');?>admin/faq/">FAQ</a><span class="divider">/</span>
					</li>
                    <li>
						Update FAQ: <?php echo $question;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update PFAQ: <?php echo $question;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="faq-update" name="faq-update" method="post" action="<?php echo site_url('/');?>admin/update_faq_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="faq_id"  value="<?php if(isset($faq_id)){echo $faq_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="question">Question</label>
                                            <div class="controls">
                                               <input type="text" class="span6" id="question" name="question" placeholder="Question" value="<?php if(isset($question)){echo $question;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="status">Status</label>
                                            <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" class="btn btn-primary status<?php if($status == 'draft'){ echo ' active';}?>">Draft</button>
                                                      <button type="button" class="btn btn-primary status<?php if($status == 'live'){ echo ' active';}?>">Live</button>
                                                    </div>
                                            </div>
                                          </div>
										  
										  
										  <div class="control-group">
											<label class="control-label" for="topic">Topic</label>
											<div class="controls">
												<select name="topic">
													<?php echo $this->admin_model->get_topic_option_select_list($topic_id); ?>
												</select> 												 
											</div>
										  </div>  
										                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Answer:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content" name="answer" style="display:block"><?php if(isset($answer)){echo $answer;}?></textarea>
                                                </div>
                                           </div>
                                         
    
                                       	  <div class="control-group">
                                            <label class="control-label" for="sequence">Sequence:</label>
                                            <div class="controls">
                                                    <input name="sequence" type="text" class="span1" id="sequence" value="<?php if(isset($sequence)){echo $sequence;}?>" size="3" maxlength="3">  
                                            		<span class="help-block" style="font-size:11px">Set the sequence of the FAQ entry</span>
                                            </div>
                                 		  </div>
                                          
                                          <div id="result_msg"></div>
                                          
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update FAQ Entry</button> 
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>            
                
			</div>
			
			<hr>
			
			<div class="row-fluid"></div>
			
			<hr>
				
		<!-- end: Content -->
		</div><!--/#content.span10-->
	</div><!--/fluid-row-->
			
		
    <div class="clearfix"></div>
		
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
	
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
						
		
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
		$('#dob').datepicker()	
	});
		
	
	$('#butt').bind('click' , function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#question').val().length == 0){
				
				$('#question').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Question Required", content:"Please supply us with a question"});
				$('#question').popover('show');
				$('#question').focus();
			
		}else{
	
			submit_form();
			
		}
	});
	
	$('div.btn-group button.status').live('click', function(){

		$('#status').attr('value', $(this).html());
	});

	$('div.btn-group button.comments').live('click', function(){
		
		$('#comments').attr('value', $(this).html());
	});

	
	
	function submit_form(){
			
			var frm = $('#faq-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_faq_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update FAQ Entry');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The entry has not been saved.'; 
			
		 }
		 
	};
	
	$('input').change(function() {

	  $('#autosave').val('false');
	});
	
	$('.redactor_box').live('click', function() {

	  $('#autosave').val('false');
	});
	
	
	
</script>
</body>
</html>