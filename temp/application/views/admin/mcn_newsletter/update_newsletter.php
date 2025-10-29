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
						<a href="<?php echo site_url('/');?>newsletter/newsletters/">Newsletters</a><span class="divider">/</span>
					</li>
					<li>
						Update Newsletter: <?php echo $title; ?>
					</li>
				</ul>
				<hr>
			</div>






			<div class="row-fluid sortable">



				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Newsletter: <?php echo $title; ?></h2>
					</div>
					<div class="box-content">



						<p>
						<form id="newsletter-update" name="newstetter-update" method="post" action="<?php echo site_url('/');?>newsltetter/update_newsletter_do" class="form-horizontal">
							<fieldset>
								<input type="hidden" name="newsletter_id"  value="<?php if(isset($newsletter_id)){echo $newsletter_id;}?>">
								<input type="hidden" name="autosave" id="autosave"  value="true">
								<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
								<div class="control-group">
									<label class="control-label" for="title">Title</label>
									<div class="controls">
										<input type="text" class="span6" id="title" name="title" placeholder="Newsletter title" value="<?php if(isset($title)){echo $title;}?>">
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
									<label class="control-label" for="slug">Slug</label>
									<div class="controls">
										<input type="text" class="span6" id="slug" name="slug" placeholder="Project URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">
									</div>
								</div>



								<div class="control-group">
									<label class="control-label" for="listing_date">Publish date</label>
									<div class="controls">
										<div class="input-append date" id="listing_date" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
											<input type="text" name="listing_date" id="listing_date" value="<?php if(isset($listing_date)){echo date('Y-m-d',strtotime($listing_date));} ?>">
											<span class="add-on"><i class="icon-calendar"></i></span>
										</div>
										<span class="help-block" style="font-size:11px">Select the date the newsletter is published</span>
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
								<button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Newsletter</button>

							</fieldset>
						</form>
						</p>
					</div>
				</div>
			</div>

			<div class="row-fluid sortable">

				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Newsletter Paragraphs</h2>
					</div>
					<div class="box-content">
						<a href="#myModal" type="button" class="btn btn-inverse btn" data-toggle="modal">Add New Paragraph</a>
						<hr>
						<div class="row-fluid" id="paragraph-box">

							<?php echo $this->newsletter_model->get_all_paragraphs($newsletter_id); ?>

						</div>

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

							<?php $this->admin_model->get_featured_image('newsletter', $newsletter_id);?>

						</p>
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



	<div class="clearfix"></div>

	<div class="modal hide fade" id="modal-paragraph-delete">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Delete the Paragraph</h3>
		</div>
		<div class="modal-body">
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Please Note!</strong> Are you sure you want to delete the current paragraph? All details will be removed. This proces is not reversible.
			</div>

		</div>
		<div class="modal-footer">
			<a onClick="$('#modal-newsletter-delete').modal('hide');" class="btn">Close</a>
			<a href="#" class="btn btn-primary">Delete Paragraph</a>
		</div>
	</div>

	<div id="myModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="width:800px; left:44%">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3 id="myModalLabel">Upload New Paragraph</h3>
		</div>
		<div class="modal-body">
			<p>
			<form id="paragraph-add" name="paragraph-add" method="post" action="<?php echo site_url('/');?>newsletter/add_paragraph_do">
				<input type="hidden" name="newsletter_id"  value="<?php if(isset($newsletter_id)){echo $newsletter_id;}?>">



				<div class="control-group" id="redactor_content_msg">
					<label class="control-label" for="redactor_content">Paragraph Type:</label>
					<div class="controls">
						<select name="para_type" class="disabled">
							<option value="banner_img">Banner Image</option>
							<option value="img_txt">Image Left - Text Right</option>
							<option value="txt_img">Text Left - Image Right</option>
							<option value="txt">Text Only</option>
							<option value="gallery">Image Gallery</option>
						</select>
					</div>
					<hr>
					<button type="submit" class="btn btn-inverse btn">Upload Paragraph</button>
				</div>
			</form>
			</p>
		</div>
		<div class="modal-footer">

			<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
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

		$('#listing_date').datepicker();
	});



	$('div.btn-group button').live('click', function(){

		$('#status').attr('value', $(this).html());
	});




	function attach_gallery(){

		var gal_id = $('#gallery_select').val();

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/update_sidebar/project/'.$newsletter_id.'/gallery/';?>'+gal_id ,
			success: function (data) {

				load_images(gal_id);
			}
		});

	}

	function remove_gallery(gal_id){

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/remove_sidebar/project/'.$newsletter_id.'/gallery/';?>'+gal_id ,
			success: function (data) {

				$('#gallery_images').html(data);
			}
		});

	}

	function submit_form(){

		var frm = $('#newsletter-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'newsletter/update_newsletter_do';?>' ,
			success: function (data) {
				$('#autosave').val('true');
				$('#result_msg').html(data);
				$('#butt').html('Update Newsletter');

			}
		});

	}


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

			$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a newsletter title"});
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




	function reload_paragraphs() {

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'newsletter/reload_paragraphs/'.$newsletter_id; ?>' ,
			success: function (data) {

				$('#paragraph-box').html(data);
			}
		});

	}

	function delete_paragraph(id){

		$('#modal-paragraph-delete').bind('show', function() {
			//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo site_url('/');?>newsletter/delete_paragraph/"+id+"/",
					success: function(data) {

						$('footer').html(data);
						$('#modal-paragraph-delete').modal('hide');

						$("#row-"+id).remove();

					}
				});

			});
		}).modal({ backdrop: true });
	}


</script>
</body>
</html>