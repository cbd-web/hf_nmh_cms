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
						<a href="<?php echo site_url('/');?>admin/projects/">Projects</a><span class="divider">/</span>
					</li>
                    <li>
						Update Project: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Project: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="project-update" name="project-update" method="post" action="<?php echo site_url('/');?>admin/update_project_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="project_id"  value="<?php if(isset($project_id)){echo $project_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Project title" value="<?php if(isset($title)){echo $title;}?>">
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

                           				 <div class="control-group">
                                            <label class="control-label" for="title">Heading</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="heading" name="heading" placeholder="Project Heading" value="<?php if(isset($heading)){echo $heading;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional, give your project a sub heading (h2)</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Project URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Project Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                                                </div>
                                           </div>
                                         
                                             <div class="control-group">
                                                    <label class="control-label" for="pub_date">Publish date</label>
                                                    <div class="controls">
                                                             <div class="input-append date" id="dob" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                                              <input type="text"  name="pub_date" id="pub_date" value="<?php if (isset($review)){echo date('Y-m-d',strtotime($review));}else{ echo '1985-10-19';}?>" readonly>
                                                              <span class="add-on"><i class="icon-calendar"></i></span>
                                                            </div> 
                                                            <span class="help-block" style="font-size:11px">Select the date the project is published</span>
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
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther project.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Project</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Project Documents</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							List of documents attached to <em><?php if(isset($title)){echo $title;} ?></em>.</p>
                        <div id="project_docs">   
                            <?php $this->admin_model->get_project_docs($project_id);?>
                        </div>
                        <div id="uploader" style="display:none">
                            <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
                        </div>
		             	 
                        <div id="doc_msg"></div>
                        <a onClick="$('#uploader').slideToggle();" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add Documents</a>                  
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
				
		 <div class="modal hide fade" id="modal-doc-delete">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Delete Document</h3>
			</div>
			<div class="modal-body">
				<p>The document will be removed from the Project. This process is not reversible.</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
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
	$(document).ready(function(){
		/* ---------- Text Editor ---------- */
		$('#redactor_content').redactor({ 	
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video', 'table','|',
					 'alignment', '|', 'horizontalrule']
		});
		
		$('#dob').datepicker()	
	
	});
	
	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a project title"});
				$('#title').popover('show');
				$('#title').focus();
		
		//}else if($('#redactor_content').val() == 0){
//	
//				$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
//				$('#redactor_content_msg').popover('show');
//				$('#redactor_content_msg').focus();		
					
			
		}else{
	
			submit_form();
			
		}
	});
	
	$('div.btn-group button').live('click', function(){
		
		$('#status').attr('value', $(this).html());
	});
	
	function submit_form(){
			
			var frm = $('#project-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_project_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Project');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The project has not been saved.'; 
			
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
			url : '<?php echo site_url('/')?>admin/plupload_server/project_docs',
			max_file_size : '50mb',
			chunk_size : '1mb',
			unique_names : true,
			multipart_params: {project_id : '<?php echo $project_id;?>'},
	
			// Resize images on clientside if we can
			resize : {width : 320, height : 240, quality : 90},
	
			// Specify what files to browse for
			filters : [
				{title : "Documents", extensions : "pdf,doc,docx,DOC,DOCX,PDF,xls,xlsx,XLS"}
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
						  url: "<?php echo site_url('/');?>admin/delete_document/"+id+"/project_docs",
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
						url: "<?php echo site_url('/');?>admin/update_document/"+id+"/project_docs/<?php echo rand(0,9999);?>",
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
			url: "<?php echo site_url('/');?>admin/load_documents/<?php echo $project_id;?>/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#project_docs').empty();
			  $('#project_docs').html(data);

			}
		  });			
			
	}
	</script>
</body>
</html>