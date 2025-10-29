  <?php $this->load->view('admin/inc/header');?>
<!-- <link href="<?php echo base_url('/');?>admin_src/css/datepicker.css" rel="stylesheet"> -->
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
						<a href="<?php echo site_url('/');?>admin/posts/">Posts</a><span class="divider">/</span>
					</li>
                    <li>
						Update Post: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Post: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="post-update" name="post-update" method="post" action="<?php echo site_url('/');?>admin/update_post_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="post_id"  value="<?php if(isset($post_id)){echo $post_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                            <input type="hidden" name="comments" id="comments"  value="<?php if(isset($comments)){echo $comments;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Post title" value="<?php if(isset($title)){echo $title;}?>">
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
                                            <label class="control-label" for="comments">Comments</label>
                                            <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" class="btn btn-primary comments<?php if($comments == 'allow'){ echo ' active';}?>">Allow</button>
                                                      <button type="button" class="btn btn-primary comments<?php if($comments == 'no'){ echo ' active';}?>">No</button>
                                                      <button type="button" class="btn btn-primary comments<?php if($comments == 'private'){ echo ' active';}?>">Private</button>
                                                    </div>
                                            </div>
                                          </div>
                           				 <div class="control-group">
                                            <label class="control-label" for="title">Heading</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="heading" name="heading" placeholder="Post Heading" value="<?php if(isset($heading)){echo $heading;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional, give your post a sub heading (h2)</span>
                                            </div>
                                          </div>
										  
										  <?php echo $this->admin_model->get_post_lang_option_selected($language); ?>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Post URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Post Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content" name="content" style="display:block"><?php echo str_replace("cms2.my.na","d3rp5jatom3eyn.cloudfront.net/cms", $body); ?></textarea>
                                                </div>
                                           </div>

								 			<?php $this->admin_model->get_post_templates($post_template);?>

<!-- 								 		<div class="control-group">
                                                    <label class="control-label" for="pub_date">Publish date</label>
                                                    <div class="controls">
                                                             <div class="input-append date" id="dob" data-date="<?php if (isset($datetime)){echo date('Y-m-d',strtotime($datetime));}else{ echo date();}?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                                              <input type="text"  name="pub_date" id="pub_date" value="<?php if (isset($datetime)){echo date('Y-m-d',strtotime($datetime));}else{ echo date();}?>" readonly>
                                                              <span class="add-on"><i class="icon-calendar"></i></span>
                                                            </div> 
                                                            <span class="help-block" style="font-size:11px">Select the date the post is published</span>
                                                    </div> 
                                         </div> -->

		                                <div class="control-group">
		                                    <label class="control-label" for="pub_date">Publish Date</label>
		                                    <div class="controls">
		                                        <div class="input-append date" id="dob">
		                                            <input type="text" name="pub_date" id="pub_date" value="<?php if (isset($datetime)){echo date('Y-m-d H:i:s',strtotime($datetime));}else{ echo date();}?>" readonly>
		                                            <span class="add-on"><i class="icon-calendar"></i></span>
		                                        </div>
		                                        <span class="help-block" style="font-size:11px">Select the date the post is published</span>
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
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther post.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
                                          
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Post</button>
                                           <a href="<?php echo $this->session->userdata('url');?>/post/<?php echo $slug;?>/" target="_blank" style="margin: 0px 10px" class="btn pull-right btn-inverse"><i class="icon-search icon-white"></i> Preview</a>
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
						<?php $this->load->view('admin/inc/categories_inc');?>
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
                        
						<?php $this->admin_model->get_featured_image('post', $post_id);?>
                        
                        </p>                  
                  </div>
				</div>                
                
                 <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Post Sidebar</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content">
                  	  	<div class="alert">
                        This is the secondary smaller post column. Please select what component you would like to display.
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
                                <?php
								$this->admin_model->get_all_galleries_select();
								?>
								<div id="gal_box">
								<?php	
								$this->admin_model->get_sidebar_content('post_'.$post_id);
								?>
								</div>
                            </div>
                           
                           
                            <div id="doc_msg"></div>
                         </div>
                         <div class="clearfix" style="height:20px"></div>    
                        
                       
 
                   </div>       
                  
				</div>
                
                <div class="box span4">
					
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
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    <!-- <script type="text/javascript" src="<?php // echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script> -->
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datetimepicker.min.js"></script>
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
		//$('#dob').datepicker()

        $('#dob').datetimepicker({
            format: 'dd-MM-yyyy hh:mm:ss',
            language: 'pt-BR'
        });

	});
		
	
	$('#butt').bind('click' , function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a post title"});
				$('#title').popover('show');
				$('#title').focus();
/*		
		}else if($('#redactor_content').val() == 0){
	
				$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
				$('#redactor_content_msg').popover('show');
				$('#redactor_content_msg').focus();		*/
			
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

	
	function attach_gallery(){
			
			var gal_id = $('#gallery_select').val();
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/update_sidebar/post/'.$post_id.'/gallery/';?>'+gal_id ,
				success: function (data) {

					load_images(gal_id);
				}
			});	
	
	}
	
	function remove_gallery(gal_id){
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/remove_sidebar/post/'.$post_id.'/gallery/';?>'+gal_id ,
				success: function (data) {
					
					 $('#gallery_images').html(data);
				}
			});	
	
	}
	
	function submit_form(){
			
			var frm = $('#post-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_post_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Post');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The post has not been saved.'; 
			
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
	
	
	function load_images(gal_id){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>admin/load_gallery_images/"+gal_id,
			success: function(data) {
			  $('#gal_box').append(data);

			}
		  });			
			
	}
	
	
	
	
	</script>
</body>
</html>