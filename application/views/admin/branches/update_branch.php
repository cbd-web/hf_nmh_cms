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
						<a href="<?php echo site_url('/');?>branch/branches/">Branches</a><span class="divider">/</span>
					</li>
                    <li>
						Update Branch: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">

				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Branch: <?php echo $title; ?></h2>
						<div class="box-icon">
                        	<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="branch-update" name="branch-update" method="post" action="<?php echo site_url('/');?>branch/update_branch_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="branch_id"  value="<?php if(isset($branch_id)){echo $branch_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Branch Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Branch title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="title">Status</label>
                                            <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" class="btn btn-primary<?php if($status == 'draft'){ echo ' active';}?>">Draft</button>
                                                      <button type="button" class="btn btn-primary<?php if($status == 'live'){ echo ' active';}?>">Live</button>
                                                    </div>
                                            </div>
                                          </div>
										  
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Branch Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                                                </div>
                                           </div>										  

                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Page URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="link">Link</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="link" name="link" placeholder="Call To Action Link" value="<?php if(isset($link)){echo $link;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="programs">Programs Offered</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="programs" name="programs" placeholder="Programmes Offered" value="<?php if(isset($programs)){echo $programs;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="activities">Activities</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="activities" name="activities" placeholder="Activities" value="<?php if(isset($activities)){echo $activities;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="facilities">Facilities</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="facilities" name="facilities" placeholder="Facilities" value="<?php if(isset($facilities)){echo $facilities;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="head">Branch Head</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="head" name="head" placeholder="Head of The Branch" value="<?php if(isset($head)){echo $head;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="phone">Phone Number</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="phone" name="phone" placeholder="General Contact Phone Number" value="<?php if(isset($Phone)){echo $Phone;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="email" name="email" placeholder="General Contact Email Address" value="<?php if(isset($Email)){echo $Email;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="address">Physical Address</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="address" name="address" placeholder="Physical Address" value="<?php if(isset($Address)){echo $Address;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="googleMap">Google Map</label>
                                            <div class="controls">
													<textarea name="googleMap" rows="10" style="display:block" class="span6"><?php if(isset($googleMap)){echo $googleMap;}?></textarea>
													<span class="help-block"  style="font-size:11px">Please ensure to past iframe from Google Maps and change the height to 100%</span>
                                            </div>
                                          </div>
							
                                       	  <div class="control-group">
                                            <label class="control-label" for="sequence">Sequence:</label>
                                            <div class="controls">
                                                    <input name="sequence" type="text" class="span1" id="sequence" value="<?php if(isset($sequence)){echo $sequence;}?>" size="3" maxlength="3">  
                                            		<span class="help-block" style="font-size:11px">Set the sequence of the branch</span>
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
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Branch</button>
                               </fieldset> 
                             </form>
		             	</p>                                         
                  </div>
				</div>
                
                 <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Branch Sidebar</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content">
                  	  	<div class="alert">
                        This is the secondary smaller branch column. Please select what component you would like to display.
                        </div>
                        <p>
							<!--<a href="#" onClick="$('#gallery_cont').slideToggle();" class="btn "><i class="icon-picture"></i> Gallery</a>
                            <a href="#" class="btn "><i class="icon-envelope"></i> Contact Us</a>-->
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
                        
						<?php $this->admin_model->get_featured_image('branch', $branch_id);?>
                        
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
	<script type="text/javascript">
	
	var delay = 100;
	var isLoading = false;
	var isDirty = false;	
	
	
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
		
		

		$('#butt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#title').val().length == 0){
					
					$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a branch title"});
					$('#title').popover('show');
					$('#title').focus();
			
	/*		}else if($('#redactor_content').val() == 0){
		
					$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
					$('#redactor_content_msg').popover('show');
					$('#redactor_content_msg').focus();	*/		
				
			}else{
	
				submit_form();
				
			}
		});
		
		$('div.btn-group button').live('click', function(){
			
			$('#status').attr('value', $(this).html());
		});
		
	
		$('#branch-update :input').change(function() {
	
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
		
});
		

	
	function submit_form(){
			
			var frm = $('#branch-update'), content = $('#redactor_content').text();
			
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'branch/update_branch_do';?>' ,
				success: function (dataresult) {
					 $('#autosave').val('true');
					 $('#result_msg').html(dataresult);
					 $('#butt').html('Update Branch');
					 //$('#test_msg').append(frm.serialize());
				}
			});	
	
	}
	
	//IE 9 Fix
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}
	
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The branch has not been saved.';
			
		 }
		 
	};
		
	
	</script>
</body>
</html>