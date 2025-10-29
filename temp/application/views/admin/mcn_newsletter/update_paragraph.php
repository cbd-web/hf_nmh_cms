<?php $this->load->view('admin/inc/header');?>

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
						<a href="<?php echo site_url('/'); ?>newsletter/update_newsletter/<?php echo $newsletter_id ?>">Update Newsletter</a><span class="divider">/</span>
					</li>
					<li>
						Update Newsletter Paragraph:
					</li>
				</ul>
				<hr>
			</div>

			<hr>
			<div class="container">
				<?php $this->load->view('admin/mcn_newsletter/inc/news_'.$para_type);?>
				<hr>
				<a href="<?php echo site_url('/'); ?>newsletter/update_newsletter/<?php echo $newsletter_id ?>" class="btn btn-inverse btn"><< BACK</a>
			</div>


			<hr>



			<!-- end: Content -->
		</div><!--/#content.span10-->
	</div><!--/fluid-row-->



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


		$('#redactor_content').redactor({

			fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
			imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
			imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
			buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
				'video','file', 'table', 'link','|',
				'alignment', '|', 'horizontalrule']
		});


		//Featured image
		$('#imgbut').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg',
				url:       	   '<?php echo site_url('/').'newsletter/add_news_image';?>' ,
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



		$('#imgbut_one').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg_one',
				url:       	   '<?php echo site_url('/').'newsletter/add_news_image';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg_one').html(xhr.responseText);
					$('#imgbut_one').html('Update Image');
				}

			};

			var frm = $('#add-img-one');
			var probar = $('#procover_one .bar');
			var procover = $('#procover_one');

			$('#imgbut_one').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});



	$('#imgbut_two').bind('click', function() {


		var avataroptions = {
			target:        '#avatar_msg_two',
			url:       	   '<?php echo site_url('/').'newsletter/add_news_image';?>' ,
			beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				probar.width(percentVal)

			},
			complete: function(xhr) {
				procover.hide();
				probar.width('0%');
				$('#avatar_msg_two').html(xhr.responseText);
				$('#imgbut_two').html('Update Image');
			}

		};

		var frm = $('#add-img-two');
		var probar = $('#procover_two .bar');
		var procover = $('#procover_two');

		$('#imgbut_two').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
		procover.show();
		frm.ajaxForm(avataroptions);
		$('#autosave').val('true');
	});


		$('#imgbut_three').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg_three',
				url:       	   '<?php echo site_url('/').'newsletter/add_news_image';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg_three').html(xhr.responseText);
					$('#imgbut_three').html('Update Image');
				}

			};

			var frm = $('#add-img-three');
			var probar = $('#procover_three .bar');
			var procover = $('#procover_three');

			$('#imgbut_three').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});


		$('#imgbut_left').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg_left',
				url:       	   '<?php echo site_url('/').'newsletter/add_news_image';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg_left').html(xhr.responseText);
					$('#imgbut_left').html('Update Image');
				}

			};

			var frm = $('#add-img-left');
			var probar = $('#procover_left .bar');
			var procover = $('#procover_left');

			$('#imgbut_left').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});

		$('#imgbut_right').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg_right',
				url:       	   '<?php echo site_url('/').'newsletter/add_news_image';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg_right').html(xhr.responseText);
					$('#imgbut_right').html('Update Image');
				}

			};

			var frm = $('#add-img-right');
			var probar = $('#procover_right .bar');
			var procover = $('#procover_right');

			$('#imgbut_right').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});

		$('#imgbut_banner').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg_banner',
				url:       	   '<?php echo site_url('/').'newsletter/add_news_image';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg_banner').html(xhr.responseText);
					$('#imgbut_banner').html('Update Image');
				}

			};

			var frm = $('#add-img-banner');
			var probar = $('#procover_banner .bar');
			var procover = $('#procover_banner');

			$('#imgbut_banner').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});



	});


	$('#butt').click(function(e) {

		e.preventDefault();

		var frm = $('#paragraph-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'newsletter/update_paragraph_do';?>' ,
			success: function (data) {
				$('#autosave').val('true');
				$('#result_msg').html(data);
				$('#butt').html('Update Paragraph');

			}
		});

	});



</script>
</body>
</html>