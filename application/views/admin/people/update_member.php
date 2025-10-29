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
						<a href="<?php echo site_url('/');?>people/members/">Company Members</a><span class="divider">/</span>
					</li>
                    <li>
						Update Member: <?php echo $name.' '.$lname;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Member: <?php echo $name.' '.$lname;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="member-update" name="member-update" method="post" action="<?php echo site_url('/');?>people/update_member_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="member_id"  value="<?php if(isset($people_id)){echo $people_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
											
                                          <div class="control-group">
                                            <label class="control-label" for="status">Status</label>
                                            <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" class="btn btn-primary status<?php if($status == 'draft'){ echo ' active';}?>">draft</button>
                                                      <button type="button" class="btn btn-primary status<?php if($status == 'live'){ echo ' active';}?>">live</button>
                                                    </div>
                                            </div>
                                          </div>
										 <div class="control-group">
											 <label class="control-label" for="name">Title</label>
											 <div class="controls">
												 <input type="text" class="span6" id="title" name="title" placeholder="First Name" value="<?php if(isset($title)){echo $title;}?>">
											 </div>
										 </div>
                                          <div class="control-group">
                                            <label class="control-label" for="name">Name</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="name" name="name" placeholder="First Name" value="<?php if(isset($name)){echo $name;}?>">
                                            </div>
                                          </div>
                                      	  <div class="control-group">
                                            <label class="control-label" for="lname">Surname</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="lname" name="lname" placeholder="Surname" value="<?php if(isset($lname)){echo $lname;}?>">
                                            </div>
                                          </div>
                                      	  <div class="control-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>">
                                            </div>
                                          </div>
                                      	  <div class="control-group">
                                            <label class="control-label" for="tel">Telephone</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="tel" name="tel" placeholder="Telephone Number" value="<?php if(isset($tel)){echo $tel;}?>">
                                            </div>
                                          </div>
										 <div class="control-group">
											 <label class="control-label" for="fax">Fax</label>
											 <div class="controls">
												 <input type="text" class="span6" id="fax" name="fax" placeholder="Fax Number" value="<?php if(isset($fax)){echo $fax;}?>">
											 </div>
										 </div>
                                     	  <div class="control-group">
                                            <label class="control-label" for="email">Cellphone</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="cell" name="cell" placeholder="Cellphone Number" value="<?php if(isset($cell)){echo $cell;}?>">
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="location">Location</label>
											 <div class="controls">
												 <input type="text" class="span6" id="location" name="location" placeholder="Location" value="<?php if(isset($location)){echo $location;}?>">
											 </div>
										 </div>

                             			  <div class="control-group">
                                            <label class="control-label" for="position">Position</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="position" name="position" placeholder="Position" value="<?php if(isset($position)){echo $position;}?>">
                                            </div>
                                          </div>
										  
                             			  <div class="control-group">
                                            <label class="control-label" for="profession">Profession</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="profession" name="profession" placeholder="Profession" value="<?php if(isset($profession)){echo $profession;}?>">
                                            </div>
                                          </div>
										  
	                             		  <div class="control-group">
                                            <label class="control-label" for="experience">Experience</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="experience" name="experience" placeholder="Experience" value="<?php if(isset($experience)){echo $experience;}?>">
                                            </div>
                                          </div>									  											  
										  
                                          <div class="control-group">
                                            <label class="control-label" for="education">Education</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="education" name="education" placeholder="Education" value="<?php if(isset($education)){echo $education;}?>">  
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="nationality">Nationality</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="nationality" name="nationality" placeholder="Nationality" value="<?php if(isset($nationality)){echo $nationality;}?>">  
                                            </div>
                                          </div>										  
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Specialization:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"><?php if(isset($specialization)){echo $specialization;}?></textarea>
                                                </div>
                                           </div>
										   
											
                                       	  <div class="control-group">
                                            <label class="control-label" for="sequence">Sequence:</label>
                                            <div class="controls">
                                                    <input name="sequence" type="text" class="span1" id="sequence" value="<?php if(isset($sequence)){echo $sequence;}?>">  
                                            		<span class="help-block" style="font-size:11px">Set the sequence of the page</span>
                                            </div>
                                 		  </div>						   
                                         
                                               <div class="control-group">
                                                   <label class="control-label" for="metaT">Meta Title:</label>
                                                    <div class="controls">
                                                        <textarea name="metaT" style="display:block" class="span6"><?php if(isset($metaT)){echo $metaT;}?></textarea>
                                                        <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                                     </div>
                                               </div>
                                          
                                           
                                            
                                             <div class="control-group">
                                                    <label class="control-label" for="metaD">Meta Description:</label>
                                                    <div class="controls">
                                                         <textarea name="metaD" style="display:block" class="span6"><?php if(isset($metaD)){echo $metaD;}?></textarea>
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
                                          
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Member</button> 
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
			</div>
			<div class="row-fluid sortable">
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Category</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
						<?php $this->load->view('admin/people/inc/categories_inc');?>
                        </p>                  
                  </div>
				</div>
                
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->admin_model->get_featured_image('people', $people_id);?>
                        
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
		if($('#name').val().length == 0){
				
				$('#name').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a name"});
				$('#name').popover('show');
				$('#name').focus();
			
		}else{
	
			submit_form();
			
		}
	});
	
	$('div.btn-group button.status').live('click', function(){

		$('#status').attr('value', $(this).html());
	});
	
	
	function submit_form(){
			
			var frm = $('#member-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'people/update_member_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Member');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The member has not been saved.'; 
			
		 }
		 
	};
	
	$('input').change(function() {

	  $('#autosave').val('false');
	});
	$('.redactor_box').live('click', function() {

	  $('#autosave').val('false');
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
	

	</script>
</body>
</html>