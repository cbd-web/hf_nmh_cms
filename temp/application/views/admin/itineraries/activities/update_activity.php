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
						<a href="<?php echo site_url('/');?>itinerary/activities/">Activities</a><span class="divider">/</span>
					</li>
                    <li>
						Update Activities: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Activity: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="activity-update" name="activity-update" method="post" action="<?php echo site_url('/');?>itinerary/update_activity_do" class="form-horizontal">
                             <fieldset>
								<input type="hidden" name="id" value="<?php if(isset($activity_id)){echo $activity_id;}?>">
								<input type="hidden" name="lat" id="lat" value="<?php echo $lat; ?>">
								<input type="hidden" name="lng" id="lng" value="<?php echo $lng; ?>">
								<input type="hidden" name="autosave" id="autosave"  value="true">
								<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
										  
								  <div class="control-group">
									<label class="control-label" for="title">Status</label>
									<div class="controls">
										<div class="btn-group" data-toggle="buttons-radio">
										  <button type="button" class="btn btn-primary<?php if($status == 'draft'){ echo ' active';}?>">draft</button>
										  <button type="button" class="btn btn-primary<?php if($status == 'live'){ echo ' active';}?>">live</button>
										</div>
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Title</label>
									<div class="controls">
											<input type="text" class="span6" id="title" name="title" placeholder="Activity title" value="<?php if(isset($title)){echo $title;}?>">
									</div>
								  </div>
																																													  
					
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											
											<textarea  class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
										</div>
								   </div>
								   
							  	  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Video:</label>
										<div class="controls">
											<textarea  class="redactor_content loading_img" id="redactor_content" name="video" style="display:block"><?php if(isset($video)){echo $video;}?></textarea>
											<span class="help-block" style="font-size:11px">Paste the embed code from YouTube here</span> 
										</div>
								   </div>									   
								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Activity</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               </div> 
                <div class="row-fluid">
				
            
                <div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Gallery Images</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	
                         <div id="gallery_images">   
                            <?php $this->itinerary_model->load_images_update('activity', $activity_id);?>
                        </div>
                        
                                   
                  </div>
				</div>
            
				 <div class="box span6" id="gallery_cont">
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
    <script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
    
    <!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/plupload.full.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>


    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    

	<script type="text/javascript">
	
	$(document).ready(function(){
		
		$('div.btn-group button').live('click', function(){
			
			$('#status').attr('value', $(this).html());
		});		
	
		$('input').change(function() {
	
		  $('#autosave').val('false');
		});
		$('.redactor_box').live('click', function() {
	
		  $('#autosave').val('false');
		});

		
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
	
	});

	
	$('#butt').click(function(e) {

		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a product title"});
				$('#title').popover('show');
				$('#title').focus();

		}else{
	
			submit_form();
			
		}
	});
		
	
	function submit_form(){
			
		var frm = $('#activity-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'itinerary/update_activity_do';?>' ,
			success: function (data) {
				 $('#autosave').val('true');
				 $('#result_msg').html(data);
				 $('#butt').html('Update Activity');
				
			}
		});
	}
			
	window.onbeforeunload = function() {		 
		 if($('#autosave').val() == 'false'){
			return 'The activity has not been saved.';
		 }
	};
	
	
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
	
		<?php //$info = $this->itinerary_model->get_images('activity', $activity_id); ?>
		
		$("#uploader").pluploadQueue({
			// General settings
			runtimes : 'html5,gears,flash,silverlight,browserplus,html4',
			url : '<?php echo site_url('/')?>itinerary/add_images/',
			max_file_size : '10mb',
			chunk_size : '1mb',
			unique_names : true,
			multipart_params: {type_id : '<?php echo $activity_id; ?>',type : 'activity'},
	
			// Resize images on clientside if we can
			resize : {width : 800, height : 600, quality : 90},
	
			// Specify what files to browse for
			filters : [
				{title : "Images", extensions : "jpg,JPG,jpeg,gif,GIF,png,PNG"}
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
					load_images();
				},
	
				Error: function(up, args) {
					// Called when a error has occured
					//log('[error] ', args);
				}
			}
		});
	});
	
	
	function load_images(){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>itinerary/load_images_update/activity/<?php echo $activity_id; ?>/<?php echo rand(0,9999);?>",
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
						  url: "<?php echo site_url('/');?>itinerary/delete_image/"+id+"/",
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
						url: "<?php echo site_url('/');?>itinerary/update_image/"+id+"/<?php echo rand(0,9999);?>",
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

	$('#modal-image-delete').on('hidden', function () {
		$('modal-image-delete').unbind('show'); // or $(this)        
	});
	
	
	</script>
</body>
</html>