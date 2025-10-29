<?php $this->load->view('admin/inc/header');?>
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
						Add New Member
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Member</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="member-add" name="member-add" method="post" action="<?php echo site_url('/');?>people/add_member_do" class="form-horizontal">
                             <fieldset>
										 <div class="control-group">
											 <label class="control-label" for="name">Title</label>
											 <div class="controls">
												 <input type="text" class="span6" id="title" name="title" placeholder="Title" value="">
											 </div>
										 </div>
                                          <div class="control-group">
                                            <label class="control-label" for="name">Name</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="name" name="name" placeholder="First Name" value="">
                                            </div>
                                          </div>
                                      	  <div class="control-group">
                                            <label class="control-label" for="lname">Surname</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="lname" name="lname" placeholder="Surname" value="">
                                            </div>
                                          </div>
                                      	  <div class="control-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="email" name="email" placeholder="Email" value="">
                                            </div>
                                          </div>
                                      	  <div class="control-group">
                                            <label class="control-label" for="tel">Telephone</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="tel" name="tel" placeholder="Telephone Number" value="">
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="tel">Fax</label>
											 <div class="controls">
												 <input type="text" class="span6" id="fax" name="fax" placeholder="Fax Number" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="email">Cellphone</label>
											 <div class="controls">
												 <input type="text" class="span6" id="cell" name="cell" placeholder="Cellphone Number" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="location">Location</label>
											 <div class="controls">
												 <input type="text" class="span6" id="location" name="location" placeholder="Location" value="">
											 </div>
										 </div>
										  											  									  										  										  
                             			  <div class="control-group">
                                            <label class="control-label" for="position">Position</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="position" name="position" placeholder="Position" value="">
                                            </div>
                                          </div>
										  
                             			  <div class="control-group">
                                            <label class="control-label" for="profession">Profession</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="profession" name="profession" placeholder="Profession" value="">
                                            </div>
                                          </div>
										  
                             			  <div class="control-group">
                                            <label class="control-label" for="experience">Experience</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="experience" name="experience" placeholder="Experience" value="">
                                            </div>
                                          </div>										  										  
										  
                                          <div class="control-group">
                                            <label class="control-label" for="education">Education</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="education" name="education" placeholder="Education" value="">  
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="nationality">Nationality</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="nationality" name="nationality" placeholder="Nationality" value="">  
                                            </div>
                                          </div>										  
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Specialization:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
                                                </div>
                                           </div>
                                         
                                               <div class="control-group">
                                                   <label class="control-label" for="metaT">Meta Title:</label>
                                                    <div class="controls">
                                                        <textarea name="metaT" style="display:block" class="span6"></textarea>
                                                        <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                                     </div>
                                               </div>
                                          
                                           
                                            
                                             <div class="control-group">
                                                    <label class="control-label" for="metaD">Meta Description:</label>
                                                    <div class="controls">
                                                         <textarea name="metaD" style="display:block" class="span6"></textarea>
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Member</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               
               <div class="box span4">

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
	<script type="text/javascript">
	
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
	
	$('#butt').click(function(e) {
	
		
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
	
	
	function submit_form(){
			
			var frm = $('#member-add');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'people/add_member_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Post');
					
				}
			});	
	
	}
	
	</script>
</body>
</html>