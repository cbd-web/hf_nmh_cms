<form id="sendmail" name="sendmail" method="post" action="<?php echo site_url('/');?>admin/send_email" >

	<div class="row-fluid">
		<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
			<div class="box-header">
				<h2><i class="icon-th"></i><span class="break"></span>Please select some recipients</h2>
				<div class="box-icon">
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div>
			</div>
			<div class="box-content" id="subscriber_div">
				<div class="loading_img" style="width:100%; height:50px"></div>
			</div>
		</div>

		<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
			<div class="box-header">
				<h2><i class="icon-th"></i><span class="break"></span>Include Content</h2>
				<div class="box-icon">
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div> 
			</div>
			<div class="box-content" >
				<?php //echo $this->email_model->get_deal_content();?>

				<?php if($bus_id='10591') { echo $this->email_model->get_cms_product_content(); } ?>
			</div>
		</div>

		<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
			<div class="box-header">
				<h2><i class="icon-th"></i><span class="break"></span>Why</h2>
				<div class="box-icon">
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div>
			</div>
			<div class="box-content">
				<div class="alert alert-block ">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h3 class="alert-heading">Why Use EMAIL Marketing?</h3>
					<p>Email is by far the most effective way of directly affecting your bottom line and actually growing your business
					</p>
					<ul>
						<li>There are more than 3.2 billion email accounts today. 95% of online consumers use email and, 91% check their email at least once a day</li>
						<li>Email doesn’t die, it needs to be killed. Email sits there inside your subscriber’s inbox </li>
						<li>60% marketers say email marketing is producing ROI and 32% believe it will eventually.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="box span12 noMargin">
			<div class="box-header">
				<h2><i class="icon-list"></i><span class="break"></span>Compose Email</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div>
			</div>
			<div class="box-content" id="compose_div">

				<div id="email_comp">
					<input type="text" class="span8" style="font-size:22px;line-height:32px;height:40px;padding:5px" value="<?php if(isset($title)){ echo $title;}else{ echo '';}?>" onKeyDown="$('#title').popover('destroy');" id="title" name="title" placeholder="Subject..." />
					<input type="radio" style="display:none" name="recipient" id="radio_all" value="all">
					<input type="radio" style="display:none" name="recipient" id="radio_2" value="none">
					<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $admin_id?>">
					<input type="hidden" id="email_id" name="email_id" value="<?php if(isset($email_id)){ echo $email_id;}else{ echo '0';}?>">


					<!-- <?php 

						// if(BUS_ID == '10591'){ echo '<a target="_blank" href="'.site_url('/').'email/'.$email_id.'">View this email in browser.</a>'; }
						// if($bus_id == '10591'){ echo '<a target="_blank" href="'.site_url('/').'email/'.$email_id.'">View this email in browser.</a>'; }
					?> -->

					<textarea id="redactor_content" style="display:none" name="content"><?php if(isset($body)){ if($bus_id == '10591'){ echo '<a style="font-size:12px; text-align: center; width: 100%;" target="_blank" href="'.site_url('/').'email/'.$email_id.'">View this email in browser.</a><br><br>'; } echo $body; }else{ echo '';}?></textarea>
					<div class="clearfix" style="height:20px;"></div>

					<div class="row-fluid">
						<div class="span4">
							<input type="file" id="fileinput" class="btn"/>
							<input type="checkbox" id="attach_file" name="attach_file"> Attach File?
							<input type="hidden" id="byte_content" name="byte_content" value="<?php echo $attachment;?>">
							<input type="hidden" id="mime" name="mime" value="<?php echo $mime;?>">
							<input type="hidden" id="file_name" name="file_name" value="<?php echo $file_name;?>">

						</div>
						<div class="span2">
							<div id="byte_range">
								<?php

									if(strlen(trim($attachment)) > 0){

										if(substr($mime, 0, 5) == 'image'){

											echo '<img src="'.base_url('/').'admin_src/img/img_icon.png"> '.$file_name;

										}else if(strtolower($mime) == 'application/pdf'){

											echo '<img src="'.base_url('/').'admin_src/img/pdf_icon.png"> '.$file_name;

										} else {

											echo $file_name;

										}


									}

								?>

							</div>
						</div>
						<div class="span6">

							<button type="submit" id="send_mail_btn" class="btn pull-right btn-primary"><i class="icon-envelope  icon-white"></i> Send Email</button>
							<a href="javascript:preview();" class="btn pull-right" style="margin-right:10px;"><i class="icon-search"></i> Preview</a>
							<a href="javascript:save_work();" id="save_btn" class="btn pull-right btn-success" style="margin-right:10px;"><i class="icon-inbox icon-white"></i> Save</a>

						</div>

					</div>


				</div>
				<div id="email_preview"></div>
				<div class="clearfix" style="height:40px;"></div>
				<a href="javascript:close_preview();" class="btn pull-right hide" id="pre_butt" style="margin-right:10px;"><i class="icon-remove"></i> Back</a>

				<div class="clearfix" style="height:40px;"></div>
			</div>
		</div><!--/span-->
	</div>


</form>
<script type="text/javascript">
	$(document).ready(function()
	{
		//Load Members
		$.get('<?php echo site_url('/'). 'admin/ajax_load_subscribers/subscribers';?>', function(data) {
			$('#subscriber_div').html(data).removeClass('loading_img');
			/*$('#subscriber_table').dataTable( {
				"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ "
				},
				"aaSorting":[],
				"bSortClasses": false

			} );
			$('.dataTables_paginate').parent().removeClass('span6').addClass('span12');
			$('#subscriber_table_length').find('select').addClass('span6');
			$('#subscriber_table_length').parent().removeClass('span6').addClass('span4');
			$('#subscriber_table_filter').parent().removeClass('span6').addClass('span8');*/


		});

		//* ---------- Text Editor ---------- *//*
		$('#redactor_content').redactor({

			 imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
			 imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
			 buttons: [
			 'html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
			 'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image',
			 'video', 'file', 'table', 'link', '|',
			 'alignment', '|', 'horizontalrule'
			 ],
			 linebreaks: true,
			 focus: true,
			 plugins: ['fullscreen', 'fontcolor', 'fontsize', 'fontfamily']
	    });

		$('#subscriber_table').dataTable( {
			"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
				"sLengthMenu": "_MENU_ "
			},
			"aaSorting":[],
			"bSortClasses": false

		} );

		$('#send_mail_btn').bind('click', function(e){

			e.preventDefault();
			if(!$('#title').val().length == 0){

				$('#modal-email').bind('show', function() {

					$('#send_email_yes').unbind('click').click( function() {

						var bar = $('#barcover .bar'),  loading = $('#loading_img');
						var barcover = $('#barcover');
						var frm = $('#sendmail');
						barcover.show();
						frm.attr('action','<?php echo site_url('/').'admin/send_email/';?>');

						$('#send_email_yes').html('<img src="<?php echo base_url('/').'admin_src/img/spinner-mini.gif';?>" /> Sending...');

						$.ajax({
							type: 'post',
							cache: false,
							data: frm.serialize(),
							url: '<?php echo site_url('/').'admin/send_email/';?>' ,
							success: function (data) {
								//barcover.hide();
								save = true;
								$('#result_cover').html(data);
								barcover.hide();
								window.setTimeout(function(){

									//window.location.reload();

								}, 3000);
							}
						});

					});

				})
					.modal({ backdrop: true });
			}else{

				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Subject Required", content:"Please give the newsletter a valid and enticing subject line."});
				$('#title').popover('show');
				$('#title').focus();

			}

		});

		$('#sendmail :input').change(function() {

			save = false;
			//console.log(save);
		});
		$('.redactor_editor').on('click', function() {

			save = false;
			//console.log(save);
		});
		$('.redactor_editor').keyup( function() {

			save = false;
			//console.log(save);
		});

	});


	function handleFileSelect(evt) {

		//var files = document.getElementById('fileinput').files;


		var files = evt.target.files; // FileList object
		/*if (!files.length) {
		 alert('Please select a file!');
		 return;
		 }*/
		// Loop through the FileList and render image files as thumbnails.
		for (var i = 0, f; f = files[i]; i++)
		{

			/*// Only process image files.
			 if (!f.type.match('image.*'))
			 {
			 continue;
			 }*/

			var reader = new FileReader();

			// Closure to capture the file information.
			reader.onload = (function (theFile)
			{
				return function (e)
				{
					// console.log(theFile.size / 1024);
					var size = (theFile.size / 1024);

					if(size < 2048){
						var mime = theFile.type;
						document.getElementById('mime').value = mime;
						document.getElementById('byte_content').value = e.target.result;
						document.getElementById('file_name').value = theFile.name;
						console.log(e.target.result);

						// Render thumbnail.
						var span = document.createElement('span');
						span.innerHTML = [theFile.name].join('');
						document.getElementById('byte_range').insertBefore(span, null);

					}else{

						var file_ = $('#fileinput');
						file_.attr('rel', 'tooltip').attr('title', 'The file is too big '+Math.round(size/1024)+' MB. Max is 2 MB');
						file_.tooltip('show');
					}

				};
			})(f);

			// Read in the image file as a data URL.
			reader.readAsDataURL(f);

		}

	}


	document.getElementById('fileinput').addEventListener('change', handleFileSelect, false);

	function add_content(type, id){

		var editor = $('.redactor_editor'), loading = $('#it-'+id);
		loading.addClass('loading_img');
		//build content
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'admin/build_email_content/';?>'+type+'/'+id ,
			success: function (data) {
				//barcover.hide();

				editor.append(data);
				loading.removeClass('loading_img');
			}
		});




	}

	function add_cms_content(type, id){

		var editor = $('.redactor_editor'), loading = $('#it-'+id);
		loading.addClass('loading_img');
		//build content
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'admin/build_cms_email_content/';?>'+type+'/'+id ,
			success: function (data) {
				//barcover.hide();

				editor.append(data);
				loading.removeClass('loading_img');


			}
		});




	}


</script>