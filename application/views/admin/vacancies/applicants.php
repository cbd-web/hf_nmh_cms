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
						<a href="#">Applicants</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Applicants</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="filter-box">
                  	  	<?php $this->vacancy_model->get_all_applicants();?>
                                        
                  </div>
				</div>

                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Filter Applicants</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<h4>Filter By Vacancy</h4>
						<form id="filter-app-vacancy" name="filter-app-vacancy" method="post" action="<?php echo site_url('/');?>vacancy/filter_applicants" class="form-horizontal">
							<input type="hidden" name="filter_type" value="vacancy" >
						 <div class="control-group">
							 <div class="input-append">
								<select name="ids">
								<option value="0">Select a Vacancy</option>
								<?php echo $this->vacancy_model->get_vacancy_filter(); ?>
								</select>
								<button class="btn btn-inverse btn" id="filter-1" type="submit">Filter</button>
							</div>
						 </div>											
						</form>
						
						<hr>
						<h4>Filter By Discipline</h4>
						<form id="filter-app-discipline" name="filter-app-discipline" method="post" action="<?php echo site_url('/');?>vacancy/filter_applicants" class="form-horizontal">
							<input type="hidden" name="filter_type" value="discipline" >
						 <div class="control-group">
							 <div class="input-append">
								<select name="ids">
								<option value="0">Select a Discipline</option>
								<?php echo $this->vacancy_model->get_disc_filter(); ?>
								</select>
								<button class="btn btn-inverse btn" id="filter-2" type="submit">Filter</button>
							</div>
						 </div>											
						</form>

						<hr>
						<h4>Filter By Type</h4>
						<form id="filter-app-types" name="filter-app-types" method="post" action="<?php echo site_url('/');?>vacancy/filter_applicants" class="form-horizontal">
							<input type="hidden" name="filter_type" value="app_type" >
							<div class="control-group">
								<div class="input-append">
									<select name="ids">
										<option value="0">Select a Applicant Type</option>
										<option value="vacancy">Vacancy Applicant</option>
										<option value="intern">Intern Applicant</option>
									</select>
									<button class="btn btn-inverse btn" id="filter-3" type="submit">Filter</button>
								</div>
							</div>
						</form>
					</div>
				</div><!--/span-->


                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Applicant Stats</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php //$this->google_model->load_overview();?>
					</div>
				</div><!--/span-->
                
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
                    
                      <p><a title="View Applicant" rel="tooltip" class="btn btn-mini" style="cursor:pointer"><i class="icon-eye-open"></i></a> - Update Applicant</p>
                      <p><a title="Delete Applicant" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Applicant</p>
                      
					 </div>
						
					</div>
				</div><!--/span-->
                
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
		
        
        <div class="modal hide fade" id="modal-applicant-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Applicant</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current applicant? All applicant details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-applicant-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Applicant</a>
          </div>
        </div>
        
        <div class="clearfix"></div>

		<iframe src="" id="export_frame" allowtransparency="true" style="width:0; height:0"></iframe>
		
			<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
        
        
	<script type="text/javascript">
		function delete_applicant(id){
			  
			$('#modal-applicant-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>vacancy/delete_applicant/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-vacancy-delete').modal('hide');
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}



		$('#filter-1').click(function(e) {


			e.preventDefault();
			var frm = $('#filter-app-vacancy');
			$('#filter-1').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'vacancy/filter_applicants';?>' ,
				success: function (data) {

					$('#filter-box').html(data);
					$('#filter-1').html('Filter');

					$('.datatable').dataTable({
						"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ records per page"
						}
					} );

				}
			});


		});


		$('#filter-2').click(function(e) {


			e.preventDefault();
			var frm = $('#filter-app-discipline');
			$('#filter-2').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'vacancy/filter_applicants';?>' ,
				success: function (data) {

					$('#filter-box').html(data);
					$('#filter-2').html('Filter');

					$('.datatable').dataTable({
						"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ records per page"
						}
					} );
				}
			});


		});


		$('#filter-3').click(function(e) {


			e.preventDefault();
			var frm = $('#filter-app-types');
			$('#filter-3').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'vacancy/filter_applicants';?>' ,
				success: function (data) {

					$('#filter-box').html(data);
					$('#filter-3').html('Filter');

					$('.datatable').dataTable({
						"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ records per page"
						}
					} );
				}
			});


		});


		function dump_applicants() {


				$('#export_frame').attr("src","<?php echo site_url('/').'vacancy/dump_applicants/'; ?>" );

		}


	</script>
</body>
</html>