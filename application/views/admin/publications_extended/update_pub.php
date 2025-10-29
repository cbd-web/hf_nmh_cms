  <?php $this->load->view('admin/inc/header');?>
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
						<a href="<?php echo site_url('/');?>publication_extended/publications/">Publications</a><span class="divider">/</span>
					</li>
                    <li>
						Update Publication: <?php echo $title; ?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Publication: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="pub-update" name="pub-update" method="post" action="<?php echo site_url('/');?>publication_extended/update_publication_do" class="form-horizontal">
                             <fieldset>
										<input type="hidden" name="pub_id"  value="<?php if(isset($pub_id)){echo $pub_id;}?>">
										<input type="hidden" name="autosave" id="autosave"  value="true">
										<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Publication Title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="heading">Heading</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="heading" name="heading" placeholder="Publication Heading" value="<?php if(isset($heading)){echo $heading;}?>">
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
                                            <label class="control-label" for="doc_no">Doc No</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="doc_no" name="doc_no" placeholder="Publication doc_no" value="<?php if(isset($doc_no)){echo $doc_no;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="filename">Filename</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="filename" name="filename" placeholder="Original filename" value="<?php if(isset($filename)){echo $filename;}?>">
                                            </div>
                                          </div>
<!--                                           <div class="control-group">
                                            <label class="control-label" for="clean_filename">Clean Filename</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="clean_filename" name="clean_filename" placeholder="Clean Filename" value="<?php if(isset($clean_filename)){echo $clean_filename;}?>" disabled>
                                            </div>
                                          </div> -->
                           				 <div class="control-group">
											<label class="control-label" for="pub_date">Issue Date</label>
											<div class="controls">
													 <div class="input-append date" id="dob" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
													  <input type="text"  name="issue_date" id="issue_date" value="<?php if (isset($issue_date)){echo date('Y-m-d',strtotime($issue_date));}else{ echo '1985-10-19';}?>" readonly>
													  <span class="add-on"><i class="icon-calendar"></i></span>
													</div> 
													<span class="help-block" style="font-size:11px">Select the date this issue is published</span>
											</div> 
                                          </div>

                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Post URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Post Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
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
                                          
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Publication</button> 
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
			</div>

			<div class="row-fluid">

                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->admin_model->get_featured_image('pub', $pub_id);?>
                        
                        </p>                  
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
							<?php $this->load->view('admin/publications_extended/inc/categories_inc');?>
						</p>
					</div>
				</div>

				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>File Manager</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

						<div id="result_doc"><?php echo $this->publication_extended_model->load_doc($pub_id); ?></div>

<!-- 						<label class="radio"><input type="radio" name="upload_type" value="u_link" id="u-link" style="margin-right:10px" checked="checked">Link</label>

						<label class="radio"><input type="radio" name="upload_type" value="u_upld" id="u-upld" style="margin-right:10px">Upload New</label>

						<label class="radio"><input type="radio" name="upload_type" value="u_exist" id="u-exist" style="margin-right:10px">Choose Existing</label>


							<hr> -->

<!-- 							<div class="row-fluid" id="upload-link" style="display:none">
								<form id="file-update2" name="file-update2" method="post" action="<?php echo site_url('/');?>publication_extended/update_publication_file_do" class="form-horizontal">
									<input type="hidden" name="pub_id"  value="<?php if(isset($pub_id)){echo $pub_id;}?>">
								<label>Publication Link</label>
								<input type="text" class="span12" id="link" name="link" placeholder="Copy link here" value="<?php if(isset($link)){echo $link;}?>">
								<button type="submit" class="btn btn-inverse btn" id="file-butt2" style="margin-top: 10px">Manage Publication Link</button>
								</form>
							</div> -->

							<div id="upload-new">
								<?php $this->publication_extended_model->get_pub_doc($pub_id, $title); ?>
							</div>

<!-- 							<div id="upload-existing" style="display:none">
								<form id="file-update" name="file-update" method="post" action="<?php echo site_url('/');?>publication_extended/update_publication_file_do" class="form-horizontal">
									<input type="hidden" name="pub_id"  value="<?php if(isset($pub_id)){echo $pub_id;}?>">
								<select name="link" class="span12">
									<?php $this->publication_extended_model->select_doc(); ?>
									<button type="submit" class="btn btn-inverse btn" id="file-butt" style="margin-top: 10px">Manage Publication Link</button>
								</select>
								</form>
							</div> -->

					</div>
				</div>


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
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
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
		$('#dob').datepicker();


			//Upload Document
			$('#docbut').bind('click', function() {

				$('#docbut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');

				var avataroptions = {
					target:        '#avatar_msg',
					url:       	   '<?php echo site_url('/').'publication_extended/add_pub_doc';?>' ,
					beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
					uploadProgress: function(event, position, total, percentComplete) {
						var percentVal = percentComplete + '%';
						probar.width(percentVal)

					},
					complete: function(xhr) {
						procover.hide();
						probar.width('0%');
						reload_doc();
						$('#docbut').html('ADD DOCUMENT');
					}

				};

				var frm = $('#add-pub-doc');
				var probar = $('#procover1 .bar');
				var procover = $('#procover1');


				procover.show();
				frm.ajaxForm(avataroptions);
				$('#autosave').val('true');
			});

	});


		// $('input[type=radio][name=upload_type]').change(function() {
		// 	if (this.value == 'u_link') {
		// 		$('#upload-new').hide();
		// 		$('#upload-link').show();
		// 		$('#upload-existing').hide();
		// 	}
		// 	else if (this.value == 'u_upld') {
		// 		$('#upload-new').show();
		// 		$('#upload-link').hide();
		// 		$('#upload-existing').hide();

		// 	} else if (this.value == 'u_exist') {
		// 		$('#upload-new').hide();
		// 		$('#upload-link').hide();
		// 		$('#upload-existing').show();
		// 	}
		// });

	
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

		// $('#file-butt').bind('click' , function(e) {


		// 	e.preventDefault();

		// 	var frm = $('#file-update');
		// 	//frm.submit();
		// 	$('#file-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		// 	$.ajax({
		// 		type: 'post',
		// 		data: frm.serialize(),
		// 		url: '<?php echo site_url('/').'publication_extended/update_publication_file_do'; ?>' ,
		// 		success: function (data) {
		// 			$('#result_msg').html(data);
		// 			$('#file-butt').html('Manage Publication Link');

		// 			reload_doc();

		// 		}
		// 	});
		// });


		// $('#file-butt2').bind('click' , function(e) {


		// 	e.preventDefault();

		// 	var frm = $('#file-update2');
		// 	//frm.submit();
		// 	$('#file-butt2').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		// 	$.ajax({
		// 		type: 'post',
		// 		data: frm.serialize(),
		// 		url: '<?php echo site_url('/').'publication_extended/update_publication_file_do'; ?>' ,
		// 		success: function (data) {
		// 			$('#result_msg').html(data);
		// 			$('#file-butt2').html('Manage Publication Link');

		// 			reload_doc();
		// 		}
		// 	});


		// });








	
	$('div.btn-group button.status').live('click', function(){

		$('#status').attr('value', $(this).html());
	});

	$('div.btn-group button.comments').live('click', function(){
		
		$('#comments').attr('value', $(this).html());
	});

	
	
	function submit_form(){
			
			var frm = $('#pub-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'publication_extended/update_publication_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Publication');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The publication has not been saved.'; 
			
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
	
	function reload_doc ()
		{

			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'publication_extended/reload_doc/'.$pub_id;?>' ,
				success: function (data) {
					$('#result_doc').html(data);
				}
			});
		}

		function remove_doc(id){

			$.ajax({
				type: "get",

				url: "<?php echo site_url('/').'publication_extended/remove_featured_document/'; ?>"+id,
				success: function (data) {
					$('#result_msg').html(data);
					reload_doc();

				}
			});

		}
	
	</script>
</body>
</html>