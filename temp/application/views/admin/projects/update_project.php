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
						<a href="<?php echo site_url('/');?>project/projects/">Projects</a><span class="divider">/</span>
					</li>
					<li>
						Update Project: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>






			<div class="row-fluid sortable">



				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Project: <?php echo $title;?></h2>
					</div>
					<div class="box-content">



						<p>
						<form id="project-update" name="project-update" method="post" action="<?php echo site_url('/');?>project/update_project_do" class="form-horizontal">
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
									<label class="control-label" for="status">Status</label>
									<div class="controls">
										<div class="btn-group" data-toggle="buttons-radio">
											<button type="button" class="btn btn-primary status<?php if($status == 'draft'){ echo ' active';}?>">Draft</button>
											<button type="button" class="btn btn-primary status<?php if($status == 'live'){ echo ' active';}?>">Live</button>
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

								<div class="control-group">
									<label class="control-label" for="sale_price">Feature Project</label>
									<div class="controls">
										<input name="featured" type="checkbox" value="Y" <?php if($featured == 'Y') { echo "checked"; } ?>>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="type">Client</label>
									<div class="controls">
										<select name="client_id">
											<option value="0">Select a Client</option>
											<?php echo $this->project_model->get_project_clients($client_id); ?>
										</select>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="title">Location</label>
									<div class="controls">
										<input type="text" class="span6" id="location" name="location" placeholder="Location" value="<?php if(isset($location)){echo $location;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="type">Type</label>
									<div class="controls">
										<select name="type">
											<option <?php if($type == 0){echo 'selected="selected"'; }?> value="0" >None</option>
											<option <?php if($type == 1){echo 'selected="selected"'; }?> value="1" >Current</option>
											<option <?php if($type == 2){echo 'selected="selected"'; }?> value="2" >Completed</option>
											<option <?php if($type == 3){echo 'selected="selected"'; }?> value="3" >For Sale</option>
										</select>
									</div>
								</div>


								<div class="control-group" id="redactor_content_msg">
									<label class="control-label" for="redactor_content">Project Body:</label>
									<div class="controls">
										<textarea id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body; }?></textarea>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="slug">Video Link</label>
									<div class="controls">
										<input type="text" class="span6" id="video" name="video" placeholder="Project Video" value="<?php if(isset($video)){echo $video;}?>">
									</div>
								</div>


								<div class="control-group">
									<label class="control-label" for="pate">Publish date</label>
									<div class="controls">
										<div class="input-append date" id="pdate" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
											<input type="text" name="pub_date" id="pub_date" value="<?php if (isset($review)){echo date('Y-m-d',strtotime($review));}else{ echo '1985-10-19';}?>" readonly>
											<span class="add-on"><i class="icon-calendar"></i></span>
										</div>
										<span class="help-block" style="font-size:11px">Select the date the project is published</span>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="cdate">Completion date</label>
									<div class="controls">
										<div class="input-append date" id="cdate" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
											<input type="text"  name="comp_date" id="comp_date" value="<?php if (isset($completion_date)){echo date('Y-m-d',strtotime($completion_date));}else{ echo date('Y-m-d');}?>" >
											<span class="add-on"><i class="icon-calendar"></i></span>
										</div>
										<span class="help-block" style="font-size:11px">Select the date the project is completed</span>
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
			</div>


			<div class="row-fluid sortable">
				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<p>

							<?php $this->admin_model->get_featured_image('project', $project_id);?>

						</p>
					</div>
				</div>
				<div class="box span4">
					<div class="box-header">
						<h2>Gallery</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

						<div id="gallery_images">
							<?php $this->admin_model->get_sidebar_content('project_'.$project_id);?>
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
							<?php $this->load->view('admin/projects/inc/categories_inc');?>
						</p>
					</div>
				</div>


			</div>


			<div class="row-fluid sortable">

				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>People</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form id="people_add" name="people_add" method="post" action="<?php echo site_url('/');?>project/add_project_people" class="form-inline">
							<fieldset>
								<input type="hidden" name="project_id"  value="<?php if(isset($project_id)){echo $project_id;}?>">
								<div class="input-append span12">

									<select name="people">
										<?php echo $this->project_model->get_people_select(); ?>
									</select>
									<button class="btn btn-inverse btn" id="btn_ppl" onClick="add_people();" type="button"><i class="icon-plus-sign icon-white"></i> Add Person</button>
								</div>
								<div class="clearfix" style="height:30px;"></div>
							</fieldset>
						</form>
						<div id="curr_ppl">
							<?php echo $this->project_model->get_all_people($project_id); ?>
						</div>
					</div>
				</div>

				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Testimonials</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form id="testimonial_add" name="testimonial_add" method="post" action="<?php echo site_url('/');?>project/add_project_testimonial" class="form-inline">
							<fieldset>
								<input type="hidden" name="project_id"  value="<?php if(isset($project_id)){echo $project_id;}?>">
								<div class="input-append span12">
									<div class="control-group">
										<label class="control-label" for="title">Title</label>
										<div class="controls">
											<input type="text" id="t_title" class="span11" name="t_title" placeholder="Testimonial title" value="">
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="metaT">Description:</label>
										<div class="controls">
											<textarea name="testimonial" style="display:block" class="span11"></textarea>

										</div>
									</div>
									<button class="btn btn-inverse btn" id="btn_tst" type="button"><i class="icon-plus-sign icon-white"></i> Add Testimonial</button>
								</div>
								<div class="clearfix" style="height:30px;"></div>
							</fieldset>
						</form>
						<div id="curr_tst">
							<?php echo $this->project_model->get_all_testimonials($project_id); ?>
						</div>
					</div>
				</div>

			</div>

			<hr>





			<!-- end: Content -->
		</div><!--/#content.span10-->
	</div><!--/fluid-row-->



	<div class="clearfix"></div>


	<div class="modal hide fade" id="modal-people-delete">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Delete Person</h3>
		</div>
		<div class="modal-body">
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
			</div>

		</div>
		<div class="modal-footer">
			<a onClick="$('#modal-people-delete').modal('hide');" class="btn">Close</a>
			<a href="#" class="btn btn-primary">Delete Person</a>
		</div>
	</div>


	<div class="modal hide fade" id="modal-testimonial-delete">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Delete Testimonial</h3>
		</div>
		<div class="modal-body">
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
			</div>

		</div>
		<div class="modal-footer">
			<a onClick="$('#modal-testimonial-delete').modal('hide');" class="btn">Close</a>
			<a href="#" class="btn btn-primary tst">Delete Testimonial</a>
		</div>
	</div>

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


		$('#redactor_content').redactor({

			fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
			imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
			imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
			buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
				'video','file', 'table', 'link','|',
				'alignment', '|', 'horizontalrule']
		});
		$('#pdate').datepicker();
		$('#cdate').datepicker()
	});



	$('div.btn-group button').live('click', function(){

		$('#status').attr('value', $(this).html());
	});




	function attach_gallery(){

		var gal_id = $('#gallery_select').val();

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/update_sidebar/project/'.$project_id.'/gallery/';?>'+gal_id ,
			success: function (data) {

				load_images(gal_id);
			}
		});

	}

	function remove_gallery(gal_id){

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/remove_sidebar/project/'.$project_id.'/gallery/';?>'+gal_id ,
			success: function (data) {

				$('#gallery_images').html(data);
			}
		});

	}

	function submit_form(){

		var frm = $('#project-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'project/update_project_do';?>' ,
			success: function (data) {
				$('#autosave').val('true');
				$('#result_msg').html(data);
				$('#butt').html('Update Project');

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
			url: "<?php echo site_url('/');?>admin/load_gallery_images/"+gal_id+"/<?php echo rand(0,9999);?>",
			success: function(data) {
				$('#gallery_images').empty();
				$('#gallery_images').html(data);

			}
		});

	}


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


	function add_people(){

		var frm = $('#people_add');
		//frm.submit();
		$('#btn_ppl').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'project/add_people';?>' ,
			success: function (data) {

				$('#result_msg').html(data);
				$('#btn_ppl').html('<i class="icon-plus-sign icon-white"></i> Add Person');
				reload_people(<?php echo $project_id; ?>);
				var options = {'text':'Person added successfully','layout':'bottomLeft','type':'success'};
				noty(options);
			}
		});

	}


	function delete_people(id){

		$('#modal-people-delete').bind('show', function() {
			//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo site_url('/');?>project/delete_people/"+id+"/",
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
			url: '<?php echo site_url('/').'project/reload_people_all/';?>'+id ,
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




	$('#btn_tst').click(function(e) {

		if($('#t_title').val().length == 0){

			$('#t_title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a testimonial title"});
			$('#t_title').popover('show');
			$('#t_title').focus();


		}else {

			var frm = $('#testimonial_add');
			//frm.submit();
			$('#btn_tst').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'project/add_testimonial';?>',
				success: function (data) {

					$('#result_msg').html(data);
					$('#btn_tst').html('<i class="icon-plus-sign icon-white"></i> Add Testimonial');
					reload_testimonials(<?php echo $project_id; ?>);
					var options = {'text': 'Testimonial added successfully', 'layout': 'bottomLeft', 'type': 'success'};
					noty(options);
				}
			});

		}

	});


	function delete_testimonial(id){

		$('#modal-testimonial-delete').bind('show', function() {
			//var id = $(this).data('id'),
			removeBtn = $(this).find('.tst');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo site_url('/');?>project/delete_testimonial/"+id+"/",
					success: function(data) {

						$('footer').html(data);
						$('#modal-testimonial-delete').modal('hide');

						$("#row-"+id).remove();

					}
				});

			});
		}).modal({ backdrop: true });
	}


	function reload_testimonials(id){

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'project/reload_testimonials_all/';?>'+id ,
			success: function (data) {

				$('#curr_tst').html(data);
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



</script>
</body>
</html>