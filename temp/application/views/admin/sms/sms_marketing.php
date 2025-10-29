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
						<a href="<?php echo site_url('/');?>admin/sms_marketing/">SMS Marketing</a><span class="divider">/</span>
					</li>
                    <li>
						Home
					</li>
				</ul>
				<hr>
			</div>

			<div class="row-fluid sortable">

				<a href="javascript:compose_sms('0')" id="compose" class="quick-button span2">
					<i class="fa-icon-edit"></i>
					<p>New sms</p>

				</a>
				<a href="javascript:load_logs('')" class="quick-button span2">
					<i class="fa-icon-random"></i>
					<p>sms Statistics</p>
					<span class="notification green">Coming Soon</span>
				</a>
				<?php $this->sms_model->get_sms_count();?>
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

							<div class="span4 noMargin" onTablet="span4" onDesktop="span4">

								<div class="alert alert-block ">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<h3 class="alert-heading">New SMS Marketing Tool</h3>
									<p>Welcome to the new sms marketing tool from the My Namibia CMS. You can now create customized sms messages and send them to your clients. Every sms campaign
									   can be analyzed with the analytics tool, helping you track and monitor incorrect sms addresses opens and the ccost estimates of the smss.
									</p>

								</div>

							</div>

							<div class="span4 noMargin" onTablet="span4" onDesktop="span4" >

									<div id="cost_dashboard"></div>

<!--									<div class="row-fluid">
										<div class="span6">
											<a class="btn btn-success"> N$ <?php /*number_format($this->sms_model->get_sms_costs($month = ''), 2);*/?></a> Total SMS Cost

										</div>
										<div class="span6">

											<a class="btn btn-success"> N$ <?php /*number_format($this->sms_model->get_sms_costs($month = 'now'), 2);*/?></a> <?php /*echo date('F');*/?> Estimate
										</div>
									</div>-->

							</div>

							<div class="span4 noMargin" onTablet="span4" onDesktop="span4">
								<div class="alert alert-block ">
									<button type="button" class="close" data-dismiss="alert">×</button>
									<h3 class="alert-heading">Button Legend</h3>
									<p>
										<a href="javascript:void();" title="" rel="tooltip" class="btn btn-mini" data-original-title="Continue editing"><i class="icon-pencil"></i></a> - Continue updating/editing the current sms
									</p>
									<p>
										<a target="_blank" href="javascript:void();" title="" rel="tooltip" class="btn btn-mini btn-danger" data-original-title="Delete the sms"><i class="icon-trash icon-white"></i></a> - Delete the sms and all its contents
									</p>
									<p>
										<a target="_blank" href="javascript:void();" title="" rel="tooltip" class="btn btn-mini btn-success" data-original-title="View the sms Analytics"><i class="icon-random icon-white"></i></a> - View the sms statistics, opens and click throughs
									</p>
								</div>

							</div>

						</div>


					</div>
				</div>
			</div>

			<hr>

			<div class="row-fluid sortable" id="content_div">
				<?php $this->sms_model->get_sms();?>

			</div>
			
			<hr>
			
			<div class="row-fluid" id="logs">


			</div>

			<hr>

			<div class="row-fluid sortable" id="incoming_div">
					<?php $this->sms_model->get_incoming();?>

			</div>

			<hr>
			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		 <?php 
         //+++++++++++++++++
         //MODAL HTML
         //+++++++++++++++++
         ?>  
           
        <div id="modal-sms" class="modal hide fade">
            <div class="modal-header">
	            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
              <h3>Send smss?</h3>
            </div>
            <div class="modal-body">
             Are you sure you want to send the sms to the selected recipients?
             <div id="result_cover"></div>
                    <p id="result_msg"></p> 
                    <div class="progress progress-striped active" id="barcover" style="display:none">
                        <div class="bar bar-warning" id="barProgress" style="width: 0%;"></div>
                    </div>
            </div>
            <div class="modal-footer">
              <a href="#" id="send_sms_yes" class="btn btn-primary">Yes, Send</a>
              <a data-dismiss="modal" aria-hidden="true" class="btn secondary">Close</a>
            </div>
        </div>


		<div id="modal-sms-delete" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Delete sms?</h3>
			</div>
			<div class="modal-body">
				Are you sure you want to delete the sms?

			</div>
			<div class="modal-footer">
				<a href="#" id="delete_sms_yes" class="btn btn-primary">Yes, Delete</a>
				<a data-dismiss="modal" aria-hidden="true" class="btn secondary">Close</a>
			</div>
		</div>



		<div id="modal-sms-campaign" class="modal hide fade">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>SMS Campaign</h3>
			</div>
			<div class="modal-body" id="promo_body">




			</div>
			<div class="modal-footer">
				<a id="update_promo_btn"  class="btn btn-primary">Update</a>
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
	<script type="text/javascript">

	var save = true;
	$(document).ready(function(e) {

		
		//Load Members
		$.get('<?php echo site_url('/'). 'admin/get_incoming_sms/';?>', function(data) {
			  	    $('#incoming_div').html(data).removeClass('loading_img');
			  		$('#recip_tb').dataTable( {
					  	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ "
						},
						"aaSorting":[],
						"bSortClasses": false
			
					} );
					$('.dataTables_paginate').parent().removeClass('span6').addClass('span12');
					$('#recip_tb_length').find('select').addClass('span6');
					$('#recip_tb_length').parent().removeClass('span6').addClass('span4');
					$('#recip_tb_filter').parent().removeClass('span6').addClass('span8');
					
					
		});

		load_cost_dashboard();


		$('div.btn-group.active button').live('click', function(){

			if($(this).html() == 'Yes'){

				$('#pis_active').attr('value','Y');

			}else{

				$('#pis_active').attr('value','N');

			}
			//console.log('active'+$(this).html());
		});


		$('div.btn-group.type button').live('click', function(){

			if($(this).html() == 'Import Response'){

				$('#ptype').attr('value','import_response');

			}else{

				$('#ptype').attr('value','incoming');

			}
			//console.log('type'+$(this).html());
		});

	});

	window.onbeforeunload = function() {

		if(save === false){
			return 'The sms has not been saved.';

		}

	};

	function delete_sms(id){


		$('#modal-sms-delete').bind('show', function() {

			$('#delete_sms_yes').unbind('click').click( function() {

				$('#delete_sms_yes').html('<img src="<?php echo base_url('/').'admin_src/img/spinner-mini.gif';?>" /> Deleting...');

				$.ajax({
					type: 'get',
					cache: false,
					url: '<?php echo site_url('/').'admin/delete_sms/';?>'+id ,
					success: function (data) {
						//barcover.hide();
						$('#tr-'+id).hide();
						$('#delete_sms_yes').html('Deleted');
						$('#modal-sms-delete').modal('hide');
					}
				});

			});

		}).modal({ backdrop: true });


	}


	function update_campaign(id){


		$('#modal-sms-campaign').bind('show', function() {

				$.ajax({
					type: 'get',
					cache: false,
					url: '<?php echo site_url('/').'admin/get_promo_update/';?>'+id ,
					success: function (data) {
						//barcover.hide();
						$('#promo_body').html(data);

						$('#response').redactor({
							buttons: [
								'html', '|'
							],
							linebreaks: true,
							focus: true,
							plugins: ['fullscreen']
						});

						$('#update_promo_btn').bind('click', function(){

							update_campaign_do(id);

						});


					}
				});

		}).modal({ backdrop: true });

	}

	function update_campaign_do(id){

		$.ajax({
			type: 'post',
			cache: false,
			data: $('form#promo-update').serialize(),
			url: '<?php echo site_url('/').'admin/do_promo_update/';?>'+id ,
			success: function (data) {
				//barcover.hide();

				$('#modal-sms-campaign').modal('hide');
			}
		});


	}

	function load_cost_dashboard(){


		$.get('<?php echo site_url('/'). 'admin/ajax_load_cost_dashboard/';?>', function(data) {
			$('#cost_dashboard').html(data);

		});
	}
	function compose_sms(id){

		if(test_save()){

			$('#content_div').html('').addClass('loading_img');

			$.get('<?php echo site_url('/'). 'admin/compose_sms/';?>'+id, function(data) {

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
			url: '<?php echo site_url('/').'admin/save_sms/';?>' ,
			success: function (data) {
				btn.html('<i class="icon-share"></i> Save sms');
				$('#sms_preview').html(data);
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
			url: '<?php echo site_url('/').'admin/ajax_load_sms_subscribers/';?>'+str+'/'+encodeURIComponent(type) ,
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


	function get_smss(str){

		if(test_save()){

			$('#content_div').html('').addClass('loading_img');

			$.get('<?php echo site_url('/'). 'admin/get_smss/';?>'+str, function(data) {

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
	
	    var content = $('#sms_comp'), str = $('#redactor_content').val(), butt = $('#pre_butt'), preview = $('#sms_preview'), box = $('#compose_div');
		content.slideUp();
		box.addClass('loading_img');
		var $frame = $('<iframe style="width:100%; height:800px" frameborder="0" allowfullscreen="true" allowtransparency="true">');
		preview.html( $frame );
		$.ajax({
			type: 'post',
			cache: false,
			data:{mailbody: str},
			url: '<?php echo site_url('/').'admin/preview_sms/';?>' ,
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
			url: '<?php echo site_url('/').'admin/load_sms_logs/';?>'+str ,
			success: function (data) {

				$('#logs').html(data).removeClass('loading_img');

				$("[rel='tooltip']").tooltip();
			}
		});


	}


	function close_preview(){
	
	    var content = $('#sms_comp'), butt = $('#pre_butt'), preview = $('#sms_preview');
		content.slideDown();
		preview.slideUp();
		butt.hide();
		
	
	}
	
	


	
	</script>
</body>
</html>