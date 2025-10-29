<?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>admin_src/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
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
						Add New Survey
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Survey</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="survey-update" name="survey-update" method="post" action="<?php echo site_url('/');?>survey/add_survey_do" class="form-horizontal">
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
                                                  <label class="control-label" for="startdate">Date</label>
                                                  <div class="controls">
                                                           <div class="input-append date" id="startdate">
                                                            <input type="text"  name="datetime"  value="<?php if (isset($datetime)){echo $datetime;}else{ echo date('Y-m-d H:i:s');}?>" data-format="yyyy-MM-dd HH:mm:ss" >
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
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Survey</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               
                
                
			</div>
			
			<hr>
			
			<div class="row-fluid">
				
				
				
			</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>
		
        <div class="clearfix"></div>
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datetimepicker.min.js"></script>
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
		$('#startdate').datetimepicker({
		  language: 'en',
		  pick24HourFormat: true
		});
		$('#enddate').datetimepicker({
		  language: 'en',
		  pick24HourFormat: true
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
		
		$('div.btn-group button').live('click', function(){
			
			var val = $(this).html(), cont = $('#end_day_');
			
			if(val == 'Yes'){
				
				$('#allday').attr('value', 'true');
				//cont.slideUp();
				
			}else{
				
				$('#allday').attr('value', 'false');
				//cont.slideDown();
			}
			
			
		});
	});	
	
	
	function submit_form(){
			
			var frm = $('#survey-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'survey/add_survey_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Survey');
					
				}
			});	
	
	}
	
	</script>
</body>
</html>