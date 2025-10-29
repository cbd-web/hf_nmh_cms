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
						<a href="<?php echo site_url('/');?>video/galleries/">Video Galleries</a><span class="divider">/</span>
					</li>
                    <li>
						Update Video Gallery: <?php echo $title;?>
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
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Gallery</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
                
               
                
			</div>

			
			<div class="row-fluid">
            
                <div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Gallery Videos</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	
						<div id="gallery_videos">
                            <?php $this->video_model->load_gallery_videos_update($gal_id);?>
                        </div>
                        
                                   
                  </div>
				</div>
            
				 <div class="box span6" id="gallery_cont">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add Videos</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form id="video-add" name="video-add" method="post" action="<?php echo site_url('/');?>video/add_video_do">
							<input type="hidden" name="gallery_id"  value="<?php if(isset($gal_id)){echo $gal_id;}?>">
							<div class="control-group">
								<label class="control-label" for="title">Title</label>
								<div class="controls">
									<input type="text" id="title" name="title" placeholder="Video title"  class="span12">
								</div>
							</div>
							<div class="control-group">
								<label class="control-label" for="heading">Heading</label>
								<div class="controls">
									<input type="text" id="heading" name="heading" placeholder="Video heading"  class="span12">
								</div>
							</div>
							<div class="control-group">
								<small>Click on the video icon and paste the YouTube embed code and click "Add Video"</small>
								<div class="controls">
									<textarea id="video" name="video" class="span12"></textarea>
								</div>
							</div>
							<div class="control-group">
								<button type="submit" class="btn btn-inverse btn" id="vid-butt">Add Video</button>
							</div>
						</form>
                        <div id="doc_msg"></div>
                                  
                  	</div>
				</div>
                

				
				
			</div>
			
			
            
			<div class="row-fluid">

			</div>
            <hr>
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		<div class="modal hide fade" id="modal-video-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Video</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current video? The video will be removed from the content you added it to.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-video-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Video</a>
          </div>
        </div>
        
        <div class="modal hide fade" id="modal-vid-update">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Update Video</h3>
			</div>
			<div class="modal-body loading" id="vid_update_body">
				 
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


		/* ---------- Text Editor ---------- */
		$('#redactor_video').redactor({
			buttons: ['html', '|', 'video']
		});

		$('div.btn-group button').live('click', function(){

			$('#style').attr('value', $(this).html());
		});

		load_videos();
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


	$('#vid-butt').click(function(e) {


		e.preventDefault();
		//Validate
		if($('#redactor_video').value == ''){

			$('#redactor_video').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a video embed script"});
			$('#redactor_video').popover('show');
			$('#redactor_video').focus();


		}else{

			var frm = $('#video-add');
			//frm.submit();
			$('#vid-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'video/add_video_do';?>' ,
				success: function (data) {
					$('#autosave').val('true');
					$('#doc_msg').html(data);
					$('#vid-butt').html('Add Video');
					$("#video-add")[0].reset();
					$('.red_vid').html('');

					load_videos();

				}
			});

		}
	});
	

	
	function submit_form(){
			
			var frm = $('#gallery-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'video/update_gallery_do';?>' ,
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
	

	
	function load_videos(){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>video/load_gallery_videos_update/<?php echo $gal_id;?>/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#gallery_videos').empty();
			  $('#gallery_videos').html(data);

			}
		  });			
			
	}
	function delete_video(id){
			  
			$('#modal-video-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>video/delete_video/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-video-delete').modal('hide');
							 load_videos();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		

	
	function update_video(id){
			  
			$('#modal-vid-update').bind('show', function() {
					
					  $.ajax({
						cache: false, 
						method: "post",
						url: "<?php echo site_url('/');?>video/update_gallery_video/"+id+"/<?php echo rand(0,9999);?>",
						success: function(data) {
						  $('#vid_update_body').empty();
						  $('#vid_update_body').html(data);
						  //$('#modal-doc-update').modal('hide');
						  
						}
					});
					
			}).modal({ backdrop: true });
	}
	
	
	
		
		
	</script>
</body>
</html>