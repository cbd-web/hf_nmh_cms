<?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet">
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
						<a href="#">Documents</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Documents</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="documents">
					<form action="" method="post" id="action_multi_files" class="form">
                  	  	<?php $this->admin_model->get_all_documents();?>
						 <select name="category" id="catval">
							<option value="">Choose a Category</option>
							<?php echo $this->admin_model->get_cat_option_list(); ?>
						 </select>
						 <input name="apply-action" id="apply-action" type="submit" value="Apply Action" class="btn btn-default btn-xs" style="margin-top:-10px;">						
					</form>
                     <div id="result_msg"></div>                   
                  </div>
				</div>
            
                
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Add Document</h2>
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

                      <p><a title="Delete the document" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Document</p>
                      
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
            <h3>Delete the Document</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current document? All document details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-doc-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Document</a>
          </div>
        </div>
        
        <div class="modal hide fade" id="modal-doc-update">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Update Document</h3>
			</div>
			<div class="modal-body loading" id="doc_update_body">
				 
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
			</div>
		</div>
        
        <div class="clearfix"></div>
		
		<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
        
    <!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
    <script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
    
    <!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/plupload.full.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
    
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>

	<script type="text/javascript">
	
	

	
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
							$('#doc_msg').append(value)
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
			runtimes : 'silverlight,flash,gears,html5,browserplus,html4',
			url : '<?php echo site_url('/')?>admin/plupload_server/documents/',
			max_file_size : '100mb',
			chunk_size : '100mb',
			unique_names : true,
			multipart_params : {"project_id" : "0"},
	
			// Resize images on clientside if we can
			//resize : {width : 2200, height : 240, quality : 90},
	
			// Specify what files to browse for
			filters : [
				{title : "Documents", extensions : "pdf,doc,docx,DOC,DOCX,PDF,xls,xlsx,XLS,jpg,JPG,jpeg,JPEG,png,PNG,GIF,gif,kmz,KMZ,kml,KML"}
			],
	
			// Flash settings
			flash_swf_url : '<?php echo base_url('/')?>plupload/js/plupload.flash.swf',
	
			// Silverlight settings
			silverlight_xap_url : '<?php echo base_url('/')?>plupload/js/plupload.silverlight.xap',
	
			// Post init events, bound after the internal events
			init : {


				FileUploaded: function(up, file, info) {
					// Called when a file has finished uploading
					//log( info);
					load_documents();
				},
	
				Error: function(up, args) {
					// Called when a error has occured
					//log('[error] ', args);
				}
			}
		});
		
	});
	
	
	function delete_document(id){
			  
			$('#modal-doc-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_document/"+id+"/documents",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-doc-delete').modal('hide');
							window.location = "<?php echo current_url('/');?>";
						  }
						});
						
					});
			}).modal({ backdrop: true });
	}
	
	function update_document(id){
			  
			$('#modal-doc-update').bind('show', function() {
					
					  $.ajax({
						cache: false, 
						method: "post",
						url: "<?php echo site_url('/');?>admin/update_document/"+id+"/documents/<?php echo rand(0,9999);?>",
						success: function(data) {
						  $('#doc_update_body').empty();
						  $('#doc_update_body').html(data);
						  //$('#modal-doc-update').modal('hide');
						  
						}
					});
					
			}).modal({ backdrop: true });
	}
	
	
	
	function load_documents(){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>admin/get_all_documents/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#documents').empty().html(data);
			  
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
						
	$('#apply-action').on('click', function(e){
			
		e.preventDefault();
	
		category_multi_add();	  
		//					
	});
	
	function category_multi_add(){
	
			var frm = $('#action_multi_files');
			
			$.ajax({
			  type: 'post',
			  data: frm.serialize(),	
			  url: '<?php echo site_url('/') ?>admin/category_multi_add/',
			  success: function(dataresult) {
				  $('#result_msg').html(dataresult);
			  }
			});	

	}	
	
	
	</script>
</body>
</html>