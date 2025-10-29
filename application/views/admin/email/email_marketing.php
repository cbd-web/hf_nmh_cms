<?php $this->load->view('admin/inc/header');?>
<style type="text/css">

	.tt-input{width:100%;min-width:300px}
	.typeahead,
	.tt-query,
	.tt-hint {
		width: 100%;
		height: 30px;
		padding: 8px 12px;
		font-size: 14px;
		line-height: 30px;
		border: 2px solid #ccc;
		-webkit-border-radius: 8px;
		-moz-border-radius: 8px;
		border-radius: 8px;
		outline: none;
	}

	.typeahead {
		background-color: #fff;
	}

	.typeahead:focus {
		border: 2px solid #0097cf;
	}

	.tt-query {
		-webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		-moz-box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
		box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.075);
	}

	.tt-hint {
		color: #999
	}

	.tt-menu {
		width: 100%;
		margin: -10px 0px 12px 0;
		padding: 8px 0;
		background-color: #fff;
		border: 1px solid #ccc;
		border: 1px solid rgba(0, 0, 0, 0.2);
		-webkit-border-radius: 8px;
		-moz-border-radius: 8px;
		border-radius: 8px;
		-webkit-box-shadow: 0 5px 10px rgba(0,0,0,.2);
		-moz-box-shadow: 0 5px 10px rgba(0,0,0,.2);
		box-shadow: 0 5px 10px rgba(0,0,0,.2);
	}

	.tt-suggestion {
		padding: 3px 20px;
		font-size: 14px;
		line-height: 24px;
	}

	.tt-suggestion:hover, .tt-suggestion a:hover  {
		cursor: pointer;
		color: #fff;
		background-color: #0097cf;
		text-decoration: none;
	}

	.tt-suggestion.tt-cursor {
		color: #fff;
		background-color: #0097cf;

	}

	.tt-suggestion p {
		margin: 0;
	}

</style>
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
							<a href="<?php echo site_url('/');?>admin/email_marketing/">Email Marketing</a><span class="divider">/</span>
						</li>
						<li>
							Home
						</li>
					</ul>
					<hr>
				</div>

				<div class="row-fluid sortable">

					<a href="javascript:compose_email('0')" id="compose" class="quick-button span2">
						<i class="fa-icon-edit"></i>
						<p>New Email</p>

					</a>
					<a href="javascript:load_logs('')" class="quick-button span2">
						<i class="fa-icon-random"></i>
						<p>Email Statistics</p>
						<span class="notification green">NEW</span>
					</a>
					<?php $this->email_model->get_email_count();?>
					<a href="" class="quick-button span2">
						<i class="fa-icon-refresh"></i>
						<p>Reload Page</p>

					</a>
				</div>

				<hr>

				<div class="row-fluid" id="help_div">

					<div class="box span12 noMargin" onTablet="span12" onDesktop="span12">
						<div class="box-header">
							<h2><i class="icon-question-sign"></i><span class="break"></span></h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">

							<div class="row-fluid">

								<div class="span8 noMargin" onTablet="span8" onDesktop="span8">

									<div class="alert alert-block ">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<h3 class="alert-heading">New Email Marketing Tool</h3>
										<p>Welcome to the new email marketing tool from the My Namibia CMS. You can now create customized fully branded email templates and send them to your clients. Every email campaign
											can be analyzed with the analytics tool, helping you track and monitor incorrect email addresses opens and the click through rate of the emails.
										</p>
									</div>

								</div>


								<div class="span4 noMargin" onTablet="span4" onDesktop="span4">
									<div class="alert alert-block ">
										<button type="button" class="close" data-dismiss="alert">×</button>
										<h3 class="alert-heading">Button Legend</h3>
										<p>
											<a href="javascript:void();" title="" rel="tooltip" class="btn btn-mini" data-original-title="Continue editing"><i class="icon-pencil"></i></a> - Continue updating/editing the current email
										</p>
										<p>
											<a target="_blank" href="javascript:void();" title="" rel="tooltip" class="btn btn-mini btn-danger" data-original-title="Delete the email"><i class="icon-trash icon-white"></i></a> - Delete the email and all its contents
										</p>
										<p>
											<a target="_blank" href="javascript:void();" title="" rel="tooltip" class="btn btn-mini btn-success" data-original-title="View the email Analytics"><i class="icon-random icon-white"></i></a> - View the email statistics, opens and click throughs
										</p>
									</div>
								</div>

							</div>


						</div>
					</div>
				</div>

				<hr>

				<div class="row-fluid sortable" id="content_div">

					<?php $this->email_model->get_emails();?>

				</div>

				<hr>

				<div class="row-fluid" id="logs">



				</div>





				<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->

		<?php
		//+++++++++++++++++
		//MODAL HTML
		//+++++++++++++++++
		?>

		<div id="modal-email" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Send Emails?</h3>
			</div>
			<div class="modal-body">
				Are you sure you want to send the email to the selected recipients?
				<div id="result_cover"></div>
				<p id="result_msg"></p>
				<div class="alert" id="barcover" style="display:none">
					<div class="bar bar-warning" id="barProgress" style="width: 0%;"></div>
					Please be patient while we compile and add the Emails into the outgoing queue.
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" id="send_email_yes" class="btn btn-primary">Yes, Send</a>
				<a data-dismiss="modal" aria-hidden="true" class="btn secondary">Close</a>
			</div>
		</div>


		<div id="modal-email-delete" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Delete Email?</h3>
			</div>
			<div class="modal-body">
				Are you sure you want to delete the email?

			</div>
			<div class="modal-footer">
				<a href="#" id="delete_email_yes" class="btn btn-primary">Yes, Delete</a>
				<a data-dismiss="modal" aria-hidden="true" class="btn secondary">Close</a>
			</div>
		</div>


		<div class="clearfix"></div>
		<?php $this->load->view('admin/inc/footer');?>
	</div><!--/.fluid-container-->

	<script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/js/typeahead.bundle.js?v1"></script>
	<script src="<?php echo base_url('/');?>admin_src/js/handlebars.js?v1"></script>
	<script type="text/javascript">

		var save = true;
		var recip_arr = [], cat_arr = [];
		$(document).ready(function(e) {







		});

		window.onbeforeunload = function() {

			if(save === false){
				return 'The email has not been saved.';

			}

		};


		function add_recipient(id, email){

			var cont = $('#email_res'), recips = $('#recipients'), e_total = $('#email_total');


			if(email.length > 0){
				console.log(recip_arr);
				//test if exists
				var index = indexOf.call(recip_arr, id);

				if(index == -1){
					recip_arr.push(id);
					$('#no_recip').hide();
					cont.append('<div class="badge" id="recip_id_'+id+'">'+email+'</div>&nbsp;');
					recips.val(JSON.stringify(recip_arr));
					e_total.html( parseInt(e_total.html()) + 1);
				}


			}
			console.log($('#recipients').val() + ' ' + $('#category').val());


		}

		function add_category(id, name, total, all){

			var cont = $('#email_res'), recips = $('#category'), e_total = $('#email_total');


			if(name.length > 0){


				//test if exists
				var index = indexOf.call(cat_arr, id);

				if(index == -1){
					cat_arr.push(id);
					$('#no_recip').hide();
					cont.append('<div class="badge" id="cat_id_'+id+'">'+name+'</div>&nbsp;');


					if(all == true){
						e_total.html(parseInt(total));
						//console.log("true");
					}else{
						e_total.html( parseInt(e_total.html()) + parseInt(total));
						//console.log("false");
					}
					recips.val(JSON.stringify(cat_arr));

				}


			}
			//console.log(index+' '+recip_arr);
			console.log($('#recipients').val() + ' ' + $('#category').val());

		}

		function remove_category(id, name, total, all){

			var cont = $('#email_res'), recips = $('#category'), e_total = $('#email_total');


			if(name.length > 0){


				//test if exists
				var index = cat_arr.indexOf( id);


				cat_arr.splice(index, id);
				$('#no_recip').hide();
				$('#cat_id_'+id).remove();



				if(all == true){
					e_total.html(parseInt(total));
					console.log("true");
				}else{
					e_total.html( parseInt(e_total.html()) - parseInt(total));
					console.log("false");
				}
				recips.val(JSON.stringify(cat_arr));

			}
			//console.log(index+' '+recip_arr);
			console.log($('#recipients').val() + ' ' + $('#category').val());

		}

		var indexOf = function(needle) {
			if(typeof Array.prototype.indexOf === 'function') {
				indexOf = Array.prototype.indexOf;
			} else {
				indexOf = function(needle) {
					var i = -1, index = -1;

					for(i = 0; i < this.length; i++) {
						if(this[i] === needle) {
							index = i;
							break;
						}
					}

					return index;
				};
			}

			return indexOf.call(this, needle);
		};

		function delete_email(id){


			$('#modal-email-delete').bind('show', function() {

				$('#delete_email_yes').unbind('click').click( function() {

					$('#delete_email_yes').html('<img src="<?php echo base_url('/').'admin_src/img/spinner-mini.gif';?>" /> Deleting...');

					$.ajax({
						type: 'get',
						cache: false,
						url: '<?php echo site_url('/').'admin/delete_email/';?>'+id ,
						success: function (data) {
							//barcover.hide();
							$('#tr-'+id).hide();
							$('#delete_email_yes').html('Deleted');
							$('#modal-email-delete').modal('hide');
						}
					});

				});

			}).modal({ backdrop: true });


		}


		function compose_email(id){

			if(test_save()){

				$('#content_div').html('').addClass('loading_img');

				$.get('<?php echo site_url('/'). 'admin/compose_email/';?>'+id, function(data) {

					$('#content_div').html(data).removeClass('loading_img');
					$("[rel='tooltip']").tooltip();
				});
			}else{

				$('#save_btn').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"PLease Save your Work", content:"Do not loose your work by saving your work below."});
				$('#save_btn').popover('show');
				$('#save_btn').focus();

			}

		}



		function save_work(){
			var frm = $('#sendmail'), btn = $('#save_btn');
			btn.html('Working...');
			$.ajax({
				type: 'POST',
				cache: false,
				data:frm.serialize(),
				url: '<?php echo site_url('/').'admin/save_email/';?>' ,
				success: function (data) {
					btn.html('<i class="icon-share"></i> Save Email');
					$('#email_preview').html(data);
					save = true;
				}
			});

		}

		function select_rec(str, type){

			var content = $('#subscriber_div');
			content.fadeOut();
			content.addClass('loading_img');

			$.ajax({
				type: 'post',
				cache: false,
				data:{mailbody: str},
				url: '<?php echo site_url('/').'admin/ajax_load_subscribers/';?>'+str+'/'+encodeURIComponent(type) ,
				success: function (data) {

					content.html(data);
					content.removeClass('loading_img');
					content.fadeIn();
					$('#subscriber_table').dataTable( {
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
					$('#subscriber_table_filter').parent().removeClass('span6').addClass('span8');
				}
			});

		}


		function get_emails(str){

			if(test_save()){

				$('#content_div').html('').addClass('loading_img');

				$.get('<?php echo site_url('/'). 'admin/get_emails/';?>'+str, function(data) {

					$('#content_div').html(data).removeClass('loading_img');
					$("[rel='tooltip']").tooltip();
				});

			}else{

				$('#save_btn').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"PLease Save your Work", content:"Do not loose your work by saving your work below."});
				$('#save_btn').popover('show');
				$('#save_btn').focus();

			}


		}

		function preview(){

			var content = $('#email_comp'), str = $('#redactor_content').val(), butt = $('#pre_butt'), preview = $('#email_preview'), box = $('#compose_div');
			content.slideUp();
			box.addClass('loading_img');
			var $frame = $('<iframe style="width:100%; height:800px" frameborder="0" allowfullscreen="true" allowtransparency="true">');
			preview.html( $frame );
			$.ajax({
				type: 'post',
				cache: false,
				data:{mailbody: str},
				url: '<?php echo site_url('/').'admin/preview_email/';?>' ,
				success: function (data) {

					box.removeClass('loading_img');
					butt.show();
					preview.slideDown();

					var doc = $frame[0].contentWindow.document;
					var $body = $('body',doc);
					$body.html(data);


				}
			});

		}


		function test_save(){

			if(save === true){

				return true;

			}else{


				return false;

			}

		}


		function load_logs(str){
			$('#logs').html('').addClass('loading_img');
			$.ajax({
				type: 'post',
				cache: false,
				data:{mailbody: str},
				url: '<?php echo site_url('/').'admin/load_email_logs/';?>'+str ,
				success: function (data) {

					$('#logs').html(data);
					$('#logs').removeClass('loading_img');
					$("[rel='tooltip']").tooltip();

					$('#email_logs_tbl').dataTable( {
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
					$('#subscriber_table_filter').parent().removeClass('span6').addClass('span8');
				}
			});


		}


		function close_preview(){

			var content = $('#email_comp'), butt = $('#pre_butt'), preview = $('#email_preview');
			content.slideDown();
			preview.slideUp();
			butt.hide();


		}





	</script>
</body>
</html>