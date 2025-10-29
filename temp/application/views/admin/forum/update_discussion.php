<?php $this->load->view('admin/inc/header');

?>
    <script type='text/javascript' src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery-ui-1.10.3.custom.min.js"></script>

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
						<a href="#">Forum</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>forum/discussions/">Discussions</a><span class="divider">/</span>
					</li>
                    <li>
						Update Discussion: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
				
			
			
			

			
			<div class="row-fluid sortable">
				
				
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Discussion: <?php echo $title;?></h2>
					</div>
					<div class="box-content">
			
						<div class="tab-content" id="language-cont">
                        
                        	

                        
							<form id="discussion-update" name="discussion-update" method="post" action="<?php echo site_url('/');?>admin/update_discussion_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="forum_discussion_id"  value="<?php if(isset($forum_discussion_id)){echo $forum_discussion_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                         
                                          <div class="row-fluid">
                                                <div class="span8">
                                                     <div class="control-group">
                                                        <label class="control-label" for="title">Title</label>
                                                        <div class="controls">
                                                                <input type="text" class="span10" id="title" name="title" placeholder="Discussion title" value="<?php if(isset($title)){echo $title;}?>">
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
                                                </div>
                                               
                                          </div>
                                         

                           				 <div class="control-group">
                                            <label class="control-label" for="title">Heading</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="heading" name="heading" placeholder="Discussion Heading" value="<?php if(isset($heading)){echo $heading;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional, give your discussion a sub heading (h2)</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Discussion URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>"> 
                                                    <span class="help-block" style="font-size:11px">The URL paramenter. eg: http://www.example.com/about-us</span> 
                                            </div>
                                          </div>
                            
                            										  
										  <?php print $this->forum_model->slct_parent_discussion_list($parent, $forum_discussion_id); ?>
                            
							
                                       	  <div class="control-group">
                                            <label class="control-label" for="sequence">Sequence:</label>
                                            <div class="controls">
                                                    <input name="discussion_sequence" type="text" class="span1" id="sequence" value="<?php if(isset($sequence)){echo $sequence;}?>" size="3" maxlength="3">  
                                            		<span class="help-block" style="font-size:11px">Set the sequence of the discussion</span>
                                            </div>
                                 		  </div>
											
                                          <?php $this->forum_model->get_discussion_templates($template);?> 
										 
										  
										 
                                                                        
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Discussion Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                                                </div>
                                           </div>
										   
										   
                             			  <div class="control-group">
                                            <label class="control-label" for="title">Website URL</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="url" name="url" placeholder="Website URL: eg http://www.test.com" value="<?php if(isset($url)){echo $url;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional</span>
                                            </div>
                                          </div>
										  										   
                             			  <div class="control-group">
                                            <label class="control-label" for="title">Featured Document</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="feat_doc" name="feat_doc" placeholder="Featured Document" value="<?php if(isset($document)){echo $document;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional (Paste direct link to document)</span>
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
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther discussion.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Discussion</button>
                                          <a href="<?php echo $this->session->userdata('url');?>/forum/discussion/<?php echo $slug;?>/" target="_blank" style="margin: 0px 10px" class="btn pull-right btn-inverse"><i class="icon-search icon-white"></i> Preview</a> 
                               </fieldset> 
                             </form>
                                                     

							 </div>
		             	                                       
                  </div>
				</div>
            </div>
			
			
			<div class="row-fluid sortable">
                 <div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Discussion Sidebar</h2>
						<div class="box-icon">

						</div>
					</div>
					<div class="box-content">
                  	  	
                        	
                          <label>Topic</label>
                          <span class="help-block" style="font-size:11px">Select What topic the discussion is about</span>
                          <?php $this->load->view('admin/forum/categories_inc');?>
                        	
                        <div class="alert">
                        This is the secondary smaller discussion column. Please select what component you would like to display.
                        </div>
                        <p>
							<!--<a href="#" onClick="$('#gallery_cont').slideToggle();" class="btn "><i class="icon-picture"></i> Gallery</a>
                            <a href="#" class="btn "><i class="icon-envelope"></i> Contact Us</a>-->
		             	</p>                  
                 		
                        <div class="box-header">
                            <h2>Gallery</h2>
                            <div class="box-icon">
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            
                            <div id="gallery_images">   
                                <?php $this->admin_model->get_sidebar_content('discussion_'.$forum_discussion_id);?>
                            </div>
                           
                           
                            <div id="doc_msg"></div>
                         </div>
                         <div class="clearfix" style="height:20px"></div>    
                         
                   </div>       
                  
				</div>
                
                <div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->admin_model->get_featured_image('discussion', $forum_discussion_id);?>
                        
                        </p>                  
                  </div>
				</div>
                
                <?php 
				$feature_downloads = $this->forum_model->check_discussion_feature('downloads', $forum_discussion_id); 
				$feature_sidebars = $this->forum_model->check_discussion_feature('sidebars', $forum_discussion_id); 
				//$feature_people = $this->admin_model->check_discussion_feature('people', $forum_discussion_id);
				?>
			</div>
            <div class="row-fluid">
                <div id="people_div" class="box span6  <?php //if($feature_people != 'people'){ echo 'hide';};?>">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>People</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                       <form id="people_add" name="people_add" method="post" action="<?php echo site_url('/');?>admin/add_discussion_people" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="forum_discussion_id"  value="<?php if(isset($forum_discussion_id)){echo $forum_discussion_id;}?>">                         
                            <div class="input-append">
							
                                <select name="people">
                                    <?php echo $this->admin_model->get_people_select(); ?>
                                </select>
                              <button class="btn btn-inverse btn" id="btn_ppl" onClick="add_people();" type="button"><i class="icon-plus-sign icon-white"></i> Add Person</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form>
						<div id="curr_ppl">
						<?php //echo $this->admin_model->get_discussion_people($forum_discussion_id); ?>
						</div>                
                  </div>
				</div>

				
                <div id="downloads_div" class="box span6  <?php if($feature_downloads != 'downloads'){ echo 'hide';};?>">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Downloads</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->admin_model->get_downloads('discussion', $forum_discussion_id);?>
                        
                        </p>                  
                  </div>
				</div>
				

                <div id="sidebars_div" class="box span4  <?php if($feature_sidebars != 'sidebars'){ echo 'hide';};?>">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Sidebars</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->forum_model->get_discussion_sidebars('discussion_side', $forum_discussion_id);?>
                        
                        </p>                  
                  </div>
				</div>				
				
				
                <div id="business_div" class="box span4 <?php if($template != 'my_businesses'){ echo 'hide';};?>">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>My Businesses</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div id="bus_list">
						
						<?php $this->my_namibia_model->get_selected_businesses($forum_discussion_id); ?>
							
						</div>
						
						<input name="bname" id="bname" type="text" style="width:97%">
						
                  	  	 <div id="my_na_div">
                                
                         </div>                   
                  </div>
				</div>				
				
                
			</div>
           
		   <div class="row-fluid">
            	<div id="comments_div" class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Discussion Comments</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
	                  <?php $this->forum_model->get_discussion_comments($forum_discussion_id);?>
                   </div>
           		</div>
           </div>
		   <?php //$this->admin_model->get_language_discussions($settings, $forum_discussion_id);?>
                
               
			
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
		
        <div class="modal hide fade" id="modal-people-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Discussion Person</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-people-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Day Person</a>
          </div>
        </div>		
		
		<div class="modal hide fade" id="modal-comment-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Comment</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a data-dismiss="modal" aria-hidden="true" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete</a>
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
		
	$(".lang-btn").click(function(){
		
		var lang = $(this).attr('data-language');
		var id = $(this).attr('data-id');
		
		$('#english-li').removeClass("active");
		$('#german-li').removeClass("active");
		$('#russian-li').removeClass("active");
		$('#french-li').removeClass("active");
		$('#portuguese-li').removeClass("active");
			
		
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/get_language_discussion/'; ?>'+lang+'/'+id ,
				success: function (dataresult) {
					 
					$('#language-cont').html(dataresult);
					
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
					
					$('#'+lang+'-li').addClass("active");				

				}
			});			
		
	});		
						
	
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
		
		$('#dob').datepicker();
		
		$("#bname").keydown(function(){
			isDirty = true;
			reloadSearch();
		 });		
		
			$('#discussion_sidebars').change(function(){
				
				$("#sidebars_div").toggle(this.checked);
				
			});
			
			$('#discussion_downloads').change(function(){
				
				$("#downloads_div").toggle(this.checked);
				
			});	
			
			$('#discussion_people').change(function(){			
				
				$("#people_div").toggle(this.checked);
				
			});								
	
		
		
/*		$('#discussion_temp_div').on('change', function(){
			
			if($(this).val() == 'downloads'){
				
				$('#downloads_div').slideDown();
				
			}else{
				
				$('#downloads_div').slideUp();
				
			}
			
			if($(this).val() == 'my_businesses'){
				
				$('#business_div').slideDown();
				
			}else{
				
				$('#business_div').slideUp();
				
			}
			
			if($(this).val() == 'sidebars'){
				
				$('#sidebars_div').slideDown();
				
			}else{
				
				$('#sidebars_div').slideUp();
				
			}						
			
		});*/
		
		$('#save_download_btn').bind('click',function(e) {
			
			e.preventDefault();
			var frm = $('#download_frm');
			
			$('#save_download_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/add_downloads';?>' ,
				success: function (dataresult) {
					 
					 $('#result_msg').html(dataresult);
					 $('#save_download_btn').html('<i class="icon-check icon-white"></i> Save Downloads');
					 //$('#test_msg').append(frm.serialize());
				}
			});		
			
		});
		
		
		$('#save_sidebars_btn').bind('click',function(e) {
			
			e.preventDefault();
			var frm = $('#sidebars_frm');
			
			$('#save_sidebars_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/add_discussion_sidebars';?>' ,
				success: function (dataresult) {
					 
					 $('#result_msg').html(dataresult);
					 $('#save_sidebars_btn').html('<i class="icon-check icon-white"></i> Save Sidebars');
					 //$('#test_msg').append(frm.serialize());
				}
			});		
			
		});		
		

		$('#butt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#title').val().length == 0){
					
					$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a discussion title"});
					$('#title').popover('show');
					$('#title').focus();
			
	/*		}else if($('#redactor_content').val() == 0){
		
					$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Discussion Body", content:"Please supply us with some discussion content"});
					$('#redactor_content_msg').popover('show');
					$('#redactor_content_msg').focus();	*/		
				
			}else{
	
				submit_form();
				
			}
		});
		
		$('div.btn-group button').live('click', function(){
			
			$('#status').attr('value', $(this).html());
		});
	
		$('#discussion-update :input').change(function() {
	
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
			
			var frm = $('#discussion-update'), content = $('#redactor_content').text();
			
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'forum/update_discussion_do';?>' ,
				success: function (dataresult) {
					 $('#autosave').val('true');
					 $('#result_msg').html(dataresult);
					 $('#butt').html('Update Discussion');
					 //$('#test_msg').append(frm.serialize());
				}
			});	
	
	}
	
	//IE 9 Fix
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}
	
	
	function attach_gallery(){
			
			var gal_id = $('#gallery_select').val();
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/update_sidebar/discussion/'.$forum_discussion_id.'/gallery/';?>'+gal_id ,
				success: function (data) {

					load_images(gal_id);
				}
			});	
	
	}
	
	function remove_gallery(gal_id){
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/remove_sidebar/discussion/'.$forum_discussion_id.'/gallery/';?>'+gal_id ,
				success: function (data) {
					
					 $('#gallery_images').html(data);
				}
			});	
	
	}
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The discussion has not been saved.'; 
			
		 }
		 
	};

	
	function load_images(gal_id){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>admin/load_gallery_images/"+gal_id+"/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#gallery_images').empty();
			  $('#gallery_images').html(data);

			}
		  });			
			
	}
	
	 //Name Search
	 function reloadSearch(){
	
			if(!isLoading){
					var q = $("#bname").val();
						 if($.trim(q).length != 0){
								isLoading = true;
								 var div = $("#my_na_div");
								 div.show();
								 div.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');	
		
								 $.get("<?php echo site_url('/').'admin/get_my_business_name/';?>"+q, function(data) {
									div.html(data);
								  });
								 
								 // enforce the delay
								 setTimeout(function(){
								   isLoading=false;
								   if(isDirty){
									 isDirty = false;
									 reloadSearch();
								   }
								 }, delay);
						
						 }else{
							 
							$("#my_na_div").empty(); 
							 
						 }
			}
		
	}	
	
	function add_business(id){
			
			$('#my_na_bus_id').val(id);
			
			$('#cbus_'+id).hide();
			
			$.ajax({
				type: 'get',
				cache:false,
				url: '<?php echo site_url('/').'admin/add_my_business_name/'.$forum_discussion_id; ?>/'+id+'/' ,
				success: function (data) {
					 
					 $('#my_msg').html(data);
					 reload_businesses();
					
					
					//console.log('hello');
				}
			});	
	
	}
	
	function reload_businesses(){
			
			$.ajax({
				type: 'get',
				cache:false,
				url: '<?php echo site_url('/').'admin/reload_businesses/'.$forum_discussion_id; ?>',
				success: function (data) {
					 
					 $('#bus_list').html(data);
				}
			});	
	
	}	
	
	function remove_business(bid){
		
		$('#busi_'+bid).hide();
			
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/remove_business_do/';?>'+bid+'/<?php echo $forum_discussion_id; ?>',
			success: function (data) {
				
				//reload_businesses();	 
			}
		});	
	
	}
	
	
	
		function add_people(){			
				
				var frm = $('#people_add');
				//frm.submit();
				$('#btn_ppl').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '<?php echo site_url('/').'admin/add_discussion_people';?>' ,
					success: function (data) {
						
						 $('#result_msg').html(data);
						 $('#btn_ppl').html('<i class="icon-plus-sign icon-white"></i> Add Person');
						 reload_people(<?php echo $forum_discussion_id; ?>);
						 var options = {'text':'Person added successfully','layout':'bottomLeft','type':'success'};
						 noty(options);
					}
				});	
	
		}
		
		
		function delete_discussion_people(id){
			  
			$('#modal-people-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_discussion_people/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-people-delete').modal('hide');
							
							$("#row-"+id).remove();
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
	
		
		function reload_people(id){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'admin/reload_discussion_people_all/';?>'+id ,
					success: function (data) {
						
						 $('#curr_ppl').html(data);
						 $('.datatable').dataTable({
							"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
							"sPaginationType": "bootstrap",
							"oLanguage": {
							"sLengthMenu": "_MENU_"
							}
						} );
					}
				});	
		
		
		}	
	
			
		function delete_comment(id){
			  
			$('#modal-comment-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>forum/delete_comment/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-comment-delete').modal('hide');
							
							$("#comment_box_"+id).fadeOut().empty();
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		
		
		function update_comment_status(id, str){
			 
			 $.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'forum/update_comment_status/';?>'+id+'/'+str,
				success: function (data) {
					
					if(str == 'moderate'){
						$("#btn_"+id).attr("onclick","update_comment_status("+id+",'live');").html('<i class="icon-play"></i> Activate');
						$('#mod_'+id).fadeIn();
					}else{
						$('#mod_'+id).fadeOut();
						$("#btn_"+id).attr("onclick","update_comment_status("+id+",'moderate');").html('<i class="icon-pause"></i> Deactivate');
					}
					
					//reload_businesses();	 
				}
			});	
	
			
		}
		
	</script>
</body>
</html>