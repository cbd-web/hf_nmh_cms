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
						<a href="#"><?php echo ucwords($type);?></a>
					</li>
				</ul>
				<hr>
			</div>

			<div class="row-fluid sortable">

				<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Legend</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">


						<div class="well">

							<p><a title="Update the member" rel="tooltip" class="btn btn-mini" style="cursor:pointer"><i class="icon-pencil"></i></a> - Update <?php echo ucwords($type);?></p>
							<p><a title="Delete the member" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete <?php echo ucwords($type);?></p>

						</div>



						<a href="<?php echo site_url('/');?>admin/add_<?php echo $type;?>/" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New <?php echo ucwords($type);?></a>
					</div>
				</div><!--/span-->

				<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span><?php echo ucwords($type);?> Category</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<?php if($type == 'subscribers'){ ?>
							<div class="clearfix" style="height:20px;"></div>
							<form id="category_add" name="category_add" method="post" action="<?php echo site_url('/');?>admin/add_sub_type_do" class="form-inline">
								<fieldset>
									<input type="hidden" name="type"  value="<?php echo $type; ?>">
									<div class="input-append span12">
										<input class="span8" id="appendedInputButtons" type="text" name="category_name" placeholder="Category name..." value="">
										<button class="btn btn-inverse btn" id="btn_cat" onClick="add_category();" type="button"><i class="icon-plus-sign icon-white"></i> Add Category</button>
									</div>
									<div class="clearfix" style="height:30px;"></div>
								</fieldset>
							</form>
						<?php } ?>
						<div id="sub_types"><?php $this->admin_model->get_all_sub_categories();?></div>
					</div>
				</div><!--/span-->



				<div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Import a CSV File</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

						<div id="feat_img"><div class="alert">Select a file for Upload</div></div>
						<div id="add_file">
							<form action="<?php site_url('/');?>csv/import_subscribers/0" method="post" accept-charset="utf-8" id="add-file" name="add-file" enctype="multipart/form-data">
								<fieldset>
									<input type="file" id="userfile" style="display:none;width:0;height:0;" name="userfile">
									<input type="hidden" name="type_id" value="">
									<input type="hidden" name="type" value="">
									<div id="avatar_msg"></div>
									<div class="progress progress-striped active" id="procover" style="display:none;margin-top:20px">
										<div class="bar bar-warning" style="width: 0%;"></div>
									</div>

									<a href="javascript:void(0)" onClick="$('#userfile').click();$('#filebut').removeClass('disabled');" class="btn">Select File</a>
									<button type="submit" class="btn btn-inverse disabled" id="filebut">Upload File</button>
									<a href="<?php echo site_url('/');?>assets/documents/csv/import_contacts_template.csv" target="_blank" class="btn btn-info pull-right">Get CSV Template</a>

								</fieldset>
							</form>
						</div>

					</div>
				</div><!--/span-->


			</div>


			<div class="row-fluid sortable">


				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All <?php echo ucwords($type);?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" style="width:98%">
						<div class="well well-mini">
							<a class="btn btn-primary" onClick="export_report()" id="export_btn"><i class="icon-share icon-white"></i> Export Contacts</a>
						</div>
						<div  id="members_cont"  class="loading_img" style="min-width:100%">
							&nbsp;
						</div>
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


	<div class="modal hide fade" id="modal-member-delete">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Delete the <?php echo ucwords($type);?></h3>
		</div>
		<div class="modal-body">
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Please Note!</strong> Are you sure you want to delete the current <?php echo ucwords($type);?>? All <?php echo ucwords($type);?> details will be removed. This proces is not reversible.
			</div>

		</div>
		<div class="modal-footer">
			<a onClick="$('#modal-member-delete').modal('hide');" class="btn">Close</a>
			<a href="#" class="btn btn-primary">Delete <?php echo ucwords($type);?></a>
		</div>
	</div>

	<div class="clearfix"></div>
	<iframe id="export_frame" src="" allowtransparency="true" frameborder="0" style="width:0;height:0"></iframe>
	<?php $this->load->view('admin/inc/footer');?>
</div><!--/.fluid-container-->

<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
<script type="text/javascript">

	$(document).ready(function(){

		reload_members()
		//Featured image
		$('#filebut').bind('click', function() {


			var avataroptions = {
				target:        '#avatar_msg',
				url:       	   '<?php echo site_url('/').'csv/upload_subscriber_csv/';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
					var percentVal = percentComplete + '%';
					probar.width(percentVal)

				},
				complete: function(xhr) {
					procover.hide();
					probar.width('0%');
					$('#avatar_msg').html(xhr.responseText);
					$('#filebut').html('Upload File').addClass('disabled');
				}

			};

			var frm = $('#add-file');
			var probar = $('#procover .bar');
			var procover = $('#procover');

			$('#filebut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);

		});

	});


	function delete_member(id, type){

		$('#modal-member-delete').bind('show', function() {
			//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo site_url('/');?>admin/delete_"+type+"/"+id+"/",
					success: function(data) {

						$('footer').html(data);
						$('#modal-member-delete').modal('hide');

					}
				});

			});
		}).modal({ backdrop: true });
	}

	function add_category(){


		//Validate
		if($('#appendedInputButtons').val().length == 0){

			$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a category name"});
			$('#appendedInputButtons').popover('show');
			$('#appendedInputButtons').focus();

		}else if($('#post_id_cat').val() == ''){

			$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Save the Post", content:"Please add the post and then add categories"});
			$('#appendedInputButtons').popover('show');
			$('#appendedInputButtons').focus();

		}else{


			var frm = $('#category_add');
			//frm.submit();
			$('#btn_cat').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/add_sub_type_do';?>' ,
				success: function (data) {

					$('#result_msg').html(data);
					$('#btn_cat').html('<i class="icon-plus-sign icon-white"></i> Add Category');
					reload_category();
					var options = {'text':'Category added successfully','layout':'bottomLeft','type':'success'};
					noty(options);
				}
			});


		}

	}

	function export_report(){

		var btn = $('#export_btn'), frame = $('#export_frame');
		btn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		/*$.ajax({
			type: 'get',
			url: "<?php echo site_url('/');?>csv/export_subscribers_report/",
			success: function(data) {
				//cont.html(data).removeClass('loading_img');
				btn.html('<i class="icon-share icon-white"></i> Export Report');
				frame.attr('src','<?php echo site_url('/');?>csv/export_subscribers_report/');
			}
		});*/
		
		if(frame.attr('src','<?php echo site_url('/');?>csv/export_subscribers_report/')){
			btn.html('<i class="icon-share icon-white"></i> Export Report');
			
		}

	}

	function delete_category(id){

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/delete_subscriber_category/';?>'+id ,
			success: function (data) {
				var options = {'text':'Category deleted successfully','layout':'bottomLeft','type':'success'};
				noty(options);
				reload_category();

			}
		});


	}


	function reload_category(){

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/reload_sub_category_all/';?>' ,
			success: function (data) {

				$('#sub_types').html(data);

			}
		});


	}

	function reload_members(){
		$.get('<?php echo site_url('/'). 'admin/ajax_load_members/'.$type;?>', function(data) {
			$('#members_cont').html(data).removeClass('loading_img');
			$('.datatable').dataTable({
				"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
				"sPaginationType": "bootstrap",
				"oLanguage": {
					"sLengthMenu": "_MENU_ records per page"
				}
			} );
		});
	}

</script>
</body>
</html>