<?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet">
<link href="<?php echo base_url('/');?>admin_src/css/datepicker.css" rel="stylesheet">
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
						<a href="#">Sliders</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Sliders</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="sliders">
                  	  	<?php $this->admin_model->get_all_sliders();?>
                                        
                  </div>
				</div>
            
                
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Add Slider</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					 	<div id="uploader">
                            <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
                        </div>
		             	 
                        <div id="doc_msg"></div>
                    
					</div>
				</div><!--/span-->
                
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Legend</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                    
                   
                     <div class="well">

                      <p><a title="Delete the slider" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Slider</p>
                      
					</div>
		    		</div>
				</div><!--/span-->
                
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
		
        
        <div class="modal hide fade" id="modal-doc-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Slider</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current slider? All slider details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-doc-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Slider</a>
          </div>
        </div>
        
        <div class="modal hide fade" id="modal-slider-update">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Update Slider</h3>
			</div>
			<div class="modal-body loading" id="doc_update_body">
				 
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
                <a onClick="update_slider_do()" id="update_slider_btn" class="btn btn-primary">Update Slider</a>
			</div>
		</div>
        
        <div class="clearfix"></div>
		
		<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
        
    <!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
    <!-- <script type="text/javascript" src="//bp.yahooapis.com/2.4.21/browserplus-min.js"></script> -->
	<script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/browserplus-min.js"></script>
    
    
    <!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/v2/plupload.full.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/v2/jquery.plupload.queue/jquery.plupload.queue.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>

	<script type="text/javascript">
	
		$(document).ready(function(e) {

			
			
			$('div.btn-group button').live('click', function(){
				
				$('#status_edit').attr('value', $(this).html());
			});   
	    
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
			runtimes : 'html5,silverlight,flash,gears,browserplus,html4',
			url : '<?php echo site_url('/')?>admin/plupload_server/sliders',
			max_file_size : '10mb',
			chunk_size : '1mb',
			unique_names : true,
			multipart_params: {project_id : '0'},
	
			// Resize images on clientside if we can
			resize : {width : 1920, height : 1024, quality : 90},
	
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
					load_sliders();
				},
	
				Error: function(up, args) {
					// Called when a error has occured
					//log('[error] ', args);
				}
			}*/
						// Post init events, bound after the internal events
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
	                load_sliders();
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
	
	
	function delete_slider(id){
			  
			$('#modal-doc-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_slider/"+id,
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-doc-delete').modal('hide');
							window.location = "<?php echo current_url('/');?>";
						  }
						});
						
					});
			}).modal({ backdrop: true });
	}
	
	function update_slider(id){
			  
			$('#modal-slider-update').bind('show', function() {
					
					  $.ajax({
						cache: false, 
						method: "post",
						url: "<?php echo site_url('/');?>admin/get_slider/"+id+"/<?php echo rand(0,9999);?>",
						success: function(data) {
						  $('#doc_update_body').empty();
						  $('#doc_update_body').html(data);
						  //$('#modal-doc-update').modal('hide');
						  
						}
					});
					
			}).modal({ backdrop: true });
	}
	
	
	
	function load_sliders(){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>admin/get_all_sliders/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#sliders').empty().html(data);
			  
			  	$('.datatable').dataTable({
					"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
					"sPaginationType": "bootstrap",
					"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
					}
				} );
			 

			}
		  });			
			
	}
			function update_slider_do(){
				
					  var frm = $('#slider-update');
					  $('#update_slider_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
					  $.ajax({
						type: "post",
						data: frm.serialize(),
						url: "<?php echo site_url('/');?>admin/update_slider_do",
						success: function(data) {
						  
						  $('#update_slider_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Update Slider');
						  $('#msg').html(data);
						  $('#modal-slider-update').modal('hide');
						  window.location = '<?php echo site_url('/');?>admin/sliders';
						}
					  });
					
				
			}					

	</script>
</body>
</html>