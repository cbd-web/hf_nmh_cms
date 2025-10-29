<form id="sendmail" name="sendmail" method="post" action="<?php echo site_url('/');?>admin/send_sms" >

	<div class="row-fluid">
		<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
			<div class="box-header">
				<h2><i class="icon-th"></i><span class="break"></span>Please select some recipients</h2>
				<div class="box-icon">
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div>
			</div>
			<div class="box-content" id="subscriber_div">

					<?php echo $this->sms_model->show_sms_recipients();?>

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
				<div class="alert alert-block ">
					<button type="button" class="close" data-dismiss="alert">×</button>
					<h3 class="alert-heading">Coming Soon</h3>
					<p>Include dynamic content in your SMS campaigns like special deals, products and other content. Watch this space
					</p>

				</div>
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
					<h3 class="alert-heading">Why Use SMS Marketing?</h3>
					<p>Mobile marketing is growing fast, and there’s no sign that it’ll slow down anytime soon. As people increasingly
						tote their smartphones and tablets everywhere they go, marketers have realized that mobile is a key opportunity to engage with customers.
					</p>
					<ul>
						<li>Mobile marketing ad spend grew more than 100 percent in 2013</li>
						<li>The open rate of SMS is 98 percent compared with 22 percent for emails.</li>
						<li>Text messages can be 8x more effective at engaging customers.</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="box span12 noMargin">
			<div class="box-header">
				<h2><i class="icon-list"></i><span class="break"></span>Compose sms</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
					<a href="#" class="btn-close"><i class="icon-remove"></i></a>
				</div>
			</div>
			<div class="box-content" id="compose_div">

				<div id="sms_comp">
					<input type="text" class="span8" style="font-size:22px;line-height:32px;height:40px;padding:5px" value="<?php if(isset($title)){ echo $title;}else{ echo '';}?>" onKeyDown="$('#title').popover('destroy');" id="title" name="title" placeholder="Campaign title" />
					<input type="radio" style="display:none" name="recipient" id="radio_all" value="all">
					<input type="radio" style="display:none" name="recipient" id="radio_2" value="none">
					<input type="hidden" id="admin_id" name="admin_id" value="<?php echo $admin_id?>">
					<input type="hidden" id="sms_id" name="sms_id" value="<?php if(isset($sms_id)){ echo $sms_id;}else{ echo '0';}?>">
					<textarea id="redactor_content" style="display:none" name="content"><?php if(isset($body)){ echo $body;}else{ echo '';}?></textarea>
					<div class="clearfix" style="height:20px;"></div>
					<div class="badge" id="text_count">0/160</div>
					<button type="submit" id="send_mail_btn" class="btn pull-right btn-primary"><i class="icon-envelope  icon-white"></i> Send SMS</button>
					<a href="javascript:preview();" class="btn pull-right" style="margin-right:10px;"><i class="icon-search"></i> Preview</a>
					<a href="javascript:save_work();" id="save_btn" class="btn pull-right btn-success" style="margin-right:10px;"><i class="icon-inbox icon-white"></i> Save</a>
				</div>
				<div id="sms_preview"></div>
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


		//* ---------- Text Editor ---------- *//*
		$('#redactor_content').redactor({


			 buttons: [
			 'html', '|'
			 ],
			 linebreaks: true,
			 focus: true,
			 plugins: ['fullscreen']
	    });


		$('#send_mail_btn').bind('click', function(e){

			e.preventDefault();
			if(!$('#title').val().length == 0){

				$('#modal-sms').bind('show', function() {

					$('#send_sms_yes').unbind('click').click( function() {

						var bar = $('#barcover .bar'),  loading = $('#loading_img');
						var barcover = $('#barcover');
						var frm = $('#sendmail');
						barcover.show();
						frm.attr('action','<?php echo site_url('/').'admin/send_sms/';?>');

						$('#send_sms_yes').html('<img src="<?php echo base_url('/').'admin_src/img/spinner-mini.gif';?>" /> Sending...');

						$.ajax({
							type: 'post',
							cache: false,
							data: frm.serialize(),
							url: '<?php echo site_url('/').'admin/send_sms/';?>' ,
							success: function (data) {
								//barcover.hide();
								save = true;
								$('#result_cover').html(data);
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
		$('.redactor_editor').live('click', function() {

			save = false;
			//console.log(save);
		});
		$('.redactor_editor').keyup( function() {

			save = false;
			//console.log(save);
		});

		$('.redactor_editor').keyup( function() {

			count_chars();

		});

		count_chars();

	});


	function count_chars(){

		var leng = $('.redactor_editor'), div = $('#text_count');


		if(leng.html().length > 160){

			leng.popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Too many Characters", content:"There are only 160 characters to utilize in a SMS."});
			leng.popover('show');
			leng.focus();
			div.html(leng.html().length+' /160').addClass('badge-important');

		}else{
			div.html(leng.html().length+' /160').removeClass('badge-important');
			leng.popover('destroy');
		}


	}

	function add_content(type, id){

		var editor = $('.redactor_editor'), loading = $('#it-'+id);
		loading.addClass('loading_img');
		//build content
		$.ajax({
			type: 'get',
			cache: false,
			url: '<?php echo site_url('/').'admin/build_sms_content/';?>'+type+'/'+id ,
			success: function (data) {
				//barcover.hide();

				editor.append(data);
				loading.removeClass('loading_img');
			}
		});




	}


</script>