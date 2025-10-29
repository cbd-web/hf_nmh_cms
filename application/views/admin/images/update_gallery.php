<?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet">
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
						<a href="<?php echo site_url('/');?>admin/galleries/">Galleries</a><span class="divider">/</span>
					</li>
                    <li>
						Update Gallery: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Gallery: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="gallery-update" name="gallery-update" method="post" action="<?php echo site_url('/');?>admin/update_gallery_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="gallery_id"  value="<?php if(isset($gal_id)){echo $gal_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Gallery title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>

                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Gallery URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Gallery Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
                                                </div>
                                           </div>
                                         <div class="control-group">
                                                <label class="control-label" for="style">Style</label>
                                                <div class="controls">
                                                       <div class="btn-group" data-toggle="buttons-radio">
                                                          <button type="button" class="btn btn-primary <?php if($style == 'Slide'){ echo 'active';}?>">Slide</button>
                                                          <button type="button" class="btn btn-primary <?php if($style == 'Fade'){ echo 'active';}?>">Fade</button>
                                                          <!--<button type="button" class="btn btn-primary">Right</button>-->
                                                        </div>
                                                        <input type="hidden" name="style" id="style"  value="<?php if(isset($style)){echo $style;}?>">
                                                        <span class="help-block" style="font-size:11px">Optional, give your gallery a style. Fade effect, slide effect etc</span>
                                                </div>
                                           </div>
<!--                                               <div class="control-group">
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
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther gallery.</span>
                                                    </div>
                                               </div>-->
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Gallery</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
                
               
                
			</div>

			
			<div class="row-fluid">


            
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Gallery Images</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	
                         <div id="gallery_images">   
                            <?php $this->admin_model->load_gallery_images_update($gal_id);?>
                        </div>
                        
                                   
                  </div>
				</div>
            
				 <div class="box span4" id="gallery_cont">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add Images</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

                       
                        <div id="uploader">
                            <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
                        </div>
		             	 
                        <div id="doc_msg"></div>
                                  
                  </div>



				</div>


				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Category</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<p>
							<?php $this->load->view('admin/images/inc/categories_inc');?>
						</p>
					</div>
				</div>
				
			</div>
			
			
            
			<div class="row-fluid">

			</div>
            <hr>
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		<div class="modal hide fade" id="modal-image-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Image</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current image? The image will be removed from the content you added it to.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-image-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Image</a>
          </div>
        </div>
        
        <div class="modal hide fade" id="modal-img-update">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Update Image</h3>
			</div>
			<div class="modal-body loading" id="img_update_body">
				 
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
			</div>
		</div>
        
        <div class="clearfix"></div>
		
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
   
   

        <!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/browserplus-min.js"></script>
    
    <!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/plupload.full.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
	<script type="text/javascript">
	
	$(document).ready(function(){
		
		
		
			/* ---------- Text Editor ---------- */
		$('#redactor_content').redactor({ 	
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video', 'table','|',
					 'alignment', '|', 'horizontalrule']
		});
		$('div.btn-group button').live('click', function(){
			
			$('#style').attr('value', $(this).html());
		});
		
		load_images();
	});
	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a gallery title"});
				$('#title').popover('show');
				$('#title').focus();
		
		/*}else if($('#redactor_content').val() == 0){
	
				$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Gallery Body", content:"Please supply us with some gallery content"});
				$('#redactor_content_msg').popover('show');
				$('#redactor_content_msg').focus();			
			*/
		}else{
	
			submit_form();
			
		}
	});
	
	$('div.btn-group button').live('click', function(){
		
		$('#status').attr('value', $(this).html());
	});
	
	function submit_form(){
			
			var frm = $('#gallery-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_gallery_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Gallery');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The gallery has not been saved.'; 
			
		 }
		 
	};
	$('input').change(function() {

	  $('#autosave').val('false');
	});
	$('.redactor_box').live('click', function() {

	  $('#autosave').val('false');
	});
	
	
	$(function() {
		function log() {
			var str = "";
	
			plupload.each(arguments, function(arg) {
				var row = "";
	
				if (typeof(arg) != "string") {
					plupload.each(arg, function(value, key) {
						// Convert items in File objects to human readable form
						if (arg instanceof plupload.File) {
							// Convert status to human readable
							switch (value) {
								case plupload.QUEUED:
									value = 'QUEUED';
									break;
	
								case plupload.UPLOADING:
									value = 'UPLOADING';
									break;
	
								case plupload.FAILED:
									value = 'FAILED';
									break;
	
								case plupload.DONE:
									value = 'DONE';
									break;
							}
						}
	
						if (typeof(value) != "function") {
							row += (row ? ', ' : '') +  value;
							// $('#doc_msg').append(value)
						}
					});
	
					str += row + " ";
				} else { 
					str += arg + " ";
				}
			});
	
			//$('#doc_msg').append(str);
		}
	
		$("#uploader").pluploadQueue({
			// General settings
			runtimes : 'html5,gears,flash,silverlight,browserplus,html4',
			url : '<?php echo site_url('/')?>admin/add_gallery_images/',
			max_file_size : '10mb',
			chunk_size : '1mb',
			unique_names : true,
			multipart_params: {gallery_id : '<?php echo $gal_id;?>'},
	
			// Resize images on clientside if we can
			resize : {width : 1920, height : 1024, quality : 90, preserve_headers: true},
	
			// Specify what files to browse for
			/*filters : [
				{title : "Sliders", extensions : "png,PNG,jpg,JPG,JPEG,jpeg,gif,GIF"}
			],*/
			filters : {
		            // Maximum file size
		            max_file_size : '10mb',
		            // Specify what files to browse for
		            mime_types: [
		                {title : "Image files", extensions : "png,PNG,jpg,JPG,JPEG,jpeg,gif,GIF"}
		                
		            ]
		     },
			// Flash settings
			/*flash_swf_url : '<?php echo base_url('/')?>plupload/js/plupload.flaspg,gif,pngh.swf',
	
			// Silverlight settings
			silverlight_xap_url : '<?php echo base_url('/')?>plupload/js/plupload.silverlight.xap',*/
	
	        // Flash settings
	        flash_swf_url : '<?php echo base_url('/')?>plupload/js/v2/Moxie.swf',
	     
	        // Silverlight settings
	        silverlight_xap_url : '<?php echo base_url('/')?>plupload/js/v2/Moxie.xap',
	
			// Post init events, bound after the internal events
			/*init : {


				FileUploaded: function(up, file, info) {
					// Called when a file has finished uploading
					//log( info);
					load_images();
				},
	
				Error: function(up, args) {
					// Called when a error has occured
					//log('[error] ', args);
				}
			}*/

			init : {
	           /* PostInit: function() {
	                // Called after initialization is finished and internal event handlers bound
	                log('[PostInit]');
	                 
	                document.getElementById('uploadfiles').onclick = function() {
	                    uploader.start();
	                    return false;
	                };
	            },*/
	 
	            Browse: function(up) {
	                // Called when file picker is clicked
	                log('[Browse]');
	            },
	 
	            Refresh: function(up) {
	                // Called when the position or dimensions of the picker change
	                log('[Refresh]');
	            },
	  
	            StateChanged: function(up) {
	                // Called when the state of the queue is changed
	                log('[StateChanged]', up.state == plupload.STARTED ? "STARTED" : "STOPPED");
	            },
	  
	            QueueChanged: function(up) {
	                // Called when queue is changed by adding or removing files
	                log('[QueueChanged]');
	            },
	 
	            OptionChanged: function(up, name, value, oldValue) {
	                // Called when one of the configuration options is changed
	                log('[OptionChanged]', 'Option Name: ', name, 'Value: ', value, 'Old Value: ', oldValue);
	            },
	 
	            BeforeUpload: function(up, file) {
	                // Called right before the upload for a given file starts, can be used to cancel it if required
	                log('[BeforeUpload]', 'File: ', file);
	            },
	  
	            UploadProgress: function(up, file) {
	                // Called while file is being uploaded
	                log('[UploadProgress]', 'File:', file, "Total:", up.total);
	            },
	 
	            FileFiltered: function(up, file) {
	                // Called when file successfully files all the filters
	                log('[FileFiltered]', 'File:', file);
	            },
	  
	            FilesAdded: function(up, files) {
	                // Called when files are added to queue
	                log('[FilesAdded]');
	  
	                plupload.each(files, function(file) {
	                    log('  File:', file);
	                });
	            },
	  
	            FilesRemoved: function(up, files) {
	                // Called when files are removed from queue
	                log('[FilesRemoved]');
	  
	                plupload.each(files, function(file) {
	                    log('  File:', file);
	                });
	            },
	  
	            FileUploaded: function(up, file, info) {
	                // Called when file has finished uploading
	                log('[FileUploaded] File:', file, "Info:", info);
	                load_images();
	            },
	  
	            ChunkUploaded: function(up, file, info) {
	                // Called when file chunk has finished uploading
	                log('[ChunkUploaded] File:', file, "Info:", info);

	            },
	 
	            UploadComplete: function(up, files) {
	                // Called when all files are either uploaded or failed
	                log('[UploadComplete]');
	            },
	 
	            Destroy: function(up) {
	                // Called when uploader is destroyed
	                log('[Destroy] ');
	            },
	  
	            Error: function(up, args) {
	                // Called when error occurs
	                log('[Error] ', args);
	            }
	        }
		});
	});
	
	function load_images(){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>admin/load_gallery_images_update/<?php echo $gal_id;?>/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#gallery_images').empty();
			  $('#gallery_images').html(data);

			}
		  });			
			
	}
	function delete_image(id){
			  
			$('#modal-image-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_image/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-image-delete').modal('hide');
							 load_images();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		

	
	function update_image(id){
			  
			$('#modal-img-update').bind('show', function() {
					
					  $.ajax({
						cache: false, 
						method: "post",
						url: "<?php echo site_url('/');?>admin/update_gallery_image/"+id+"/<?php echo rand(0,9999);?>",
						success: function(data) {
						  $('#img_update_body').empty();
						  $('#img_update_body').html(data);
						  //$('#modal-doc-update').modal('hide');
						  
						}
					});
					
			}).modal({ backdrop: true });
	}


	$('#modal-img-update').on('hidden', function () {
		$('#modal-img-update').unbind('show'); // or $(this)
	});
		
		
	</script>
</body>
</html>