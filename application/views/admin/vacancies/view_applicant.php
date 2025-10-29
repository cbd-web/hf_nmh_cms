<?php $this->load->view('admin/inc/header');?>
<?php $bio = $this->vacancy_model->get_applicant_bio($ID); ?>
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
						<a href="<?php echo site_url('/');?>vacancy/vacancies/">Vacancies</a><span class="divider">/</span>
					</li>
                    <li>
						Applicant: <?php echo $CLIENT_NAME . ' ' . $CLIENT_SURNAME; ?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Applicant: <?php echo $CLIENT_NAME . ' ' .$CLIENT_SURNAME; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					
					<div class="box-content">


							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-pro" href="#collapsePro">
									<h1>Profile ></h1>
								  </a>
								</div>
								<div id="collapsePro" class="accordion-body collapse">
								  <div class="accordion-inner">
										<div class="row-fluid">
											<div class="span2">
												<?php echo $this->vacancy_model->get_applicant_avatar($ID); ?>
											</div>										
											<div class="span10">					
			
											<h1>Applicant Details:</h1>
											<table class="table table-striped">
												<tr><td><strong>Name: </strong></td><td> <?php echo $CLIENT_NAME .' '. $CLIENT_SURNAME; ?> (<?php echo $CLIENT_GENDER; ?>)</td></tr>
												<tr><td><strong>Date of Birth: </strong></td><td> <?php echo date('d M Y', strtotime($CLIENT_DATE_OF_BIRTH)); ?></td></tr>
												<tr><td><strong>Email: </strong></td><td> <?php echo $CLIENT_EMAIL; ?></td></tr>
												<tr><td><strong>Tel: </strong></td><td> <?php echo $CLIENT_TELEPHONE; ?></td></tr>
												<tr><td><strong>Cell: </strong></td><td> <?php echo $CLIENT_CELLPHONE; ?></td></tr>
												<tr><td><strong>Nationality: </strong></td><td> <?php echo $nationality; ?></td></tr>
												<tr><td><strong>Country: </strong></td><td> <?php echo $this->vacancy_model->get_country($CLIENT_COUNTRY); ?></td></tr>
												<tr><td><strong>Region: </strong></td><td> <?php echo $this->vacancy_model->get_region($CLIENT_REGION); ?></td></tr>
												<tr><td><strong>City: </strong></td><td> <?php echo $this->vacancy_model->get_city($CLIENT_CITY); ?></td></tr>
												<tr><td><strong>Racial Advantage: </strong></td><td> <?php echo $bee; ?></td></tr>
												<tr><td><strong>Drivers Licence: </strong></td><td> <?php echo $drivers; ?> (<?php echo $drivers_type; ?>)</td></tr>
												<tr><td><strong>Disabled: </strong></td><td> <?php echo $disabled; ?> <?php if($disabled == 'Y') { echo '<br>'.$disability; } ?></td></tr>
											</table>
											</div>
										</div>
										
								  </div>
								</div>
							  </div>

							
							
							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion-bio" href="#collapseBio">
									<h1>Biography ></h1>
								  </a>
								</div>
								<div id="collapseBio" class="accordion-body collapse">
								  <div class="accordion-inner">
								  
									<div class="row-fluid">
									
									<?php echo $bio['biography']; ?>
									</div>
										
								  </div>
								</div>
							  </div>
							
							
							<div class="accordion" id="accordion2">
							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseOne">
									<h1>Education & Courses ></h1>
								  </a>
								</div>
								<div id="collapseOne" class="accordion-body collapse">
								  <div class="accordion-inner">
									
									
									<div class="row-fluid">
										<h4>Secondary Education</h4>
										<pre style="padding:0px">
										<table class="table table-striped table-responsive" style="margin:0px">
											<thead>
												<tr>
													<th>Name of School</th>
													<th>Duration</th>
													<th>Highest Grade Passed</th>
												</tr>
											</thead>
											<tbody>
												<?php echo $this->vacancy_model->get_education('secondary', $ID); ?>
											</tbody>
										</table>
										</pre>
									</div>
										
									<div class="row-fluid">
										<h4>Tertiary Education</h4>
										<pre style="padding:0px">
										<table class="table table-striped table-responsive" style="margin:0px">
											<thead>
												<tr>
													<th>Name of Institution</th>
													<th>Field of Study</th>
													<th>Duration</th>
													<th>Highest Qualification</th>
												</tr>
											</thead>
											<tbody>
												<?php echo $this->vacancy_model->get_education('tertiary', $ID); ?>
											</tbody>
										</table>
										</pre>					
									</div>
									<div class="row-fluid">
										<h4>Courses</h4>
										<pre style="padding:0px">
										<table class="table table-striped table-responsive" style="margin:0px">
											<thead>
												<tr>
													<th>Name of Course</th>
													<th>Duration</th>
													<th>Institution</th>
												</tr>
											</thead>
											<tbody>
												<?php echo $this->vacancy_model->get_education('course', $ID); ?>
											</tbody>
										</table>
										</pre>						
									</div>
								  </div>
								</div>
							  </div>
							  
							  
							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion2" href="#collapseTwo">
									<h1>Experience & Skills ></h1>
								  </a>
								</div>
								<div id="collapseTwo" class="accordion-body collapse">
								  <div class="accordion-inner">
								  
									
									<div class="row-fluid">
										<h4>Disciplines</h4>
										<?php $this->vacancy_model->get_app_disciplines($ID); ?>						
									</div>

									<div class="row-fluid">
										<h4>Experience</h4>
										<?php $this->vacancy_model->get_app_categories($ID); ?>						
									</div>
									
									<div class="row-fluid">
										<h4>Skills</h4>
										<?php $this->vacancy_model->get_app_skills($ID); ?>					
									</div>
										
								  </div>
								</div>
							  </div>
							  
							  
							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3" href="#collapseThree">
									<h1>Achievements ></h1>
								  </a>
								</div>
								<div id="collapseThree" class="accordion-body collapse">
								  <div class="accordion-inner">
									
										
									<div class="row-fluid">
										<pre style="padding:0px">
										<table class="table table-striped table-responsive" style="margin:0px">
											<thead>
												<tr>
													<th>Achievement</th>
													<th>Organisation</th>
													<th>Receive date</th>
												</tr>
											</thead>
											<tbody>
												<?php echo $this->vacancy_model->get_achievements($ID); ?>
											</tbody>
										</table>
										</pre>							
									</div>
										
								  </div>
								</div>
							  </div>	
							  
							  
							  
							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion4" href="#collapseFour">
									<h1>Emplyment History ></h1>
								  </a>
								</div>
								<div id="collapseFour" class="accordion-body collapse">
								  <div class="accordion-inner">
									
										
									<div class="row-fluid">
										<pre style="  overflow: auto;word-wrap: normal;white-space: pre;">
										<table class="table table-striped table-responsive" style="margin:0px">
											<thead>
												<tr>
													<th>Company</th>
													<th>Position</th>
													<th>Business Type</th>
													<th>Job level</th>
													<th>Job Type</th>
													<th>Salary Type</th>
													<th>Salary</th>
													<th>Frequency</th>
													<th>Benefits</th>
													<th>Duration</th>
												</tr>
											</thead>
											<tbody>
												<?php echo $this->vacancy_model->get_employments($ID); ?>
											</tbody>
										</table>
										</pre>							
									</div>
										
								  </div>
								</div>
							  </div>
							  						  
							  
							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion5" href="#collapseFive">
									<h1>Languages ></h1>
								  </a>
								</div>
								<div id="collapseFive" class="accordion-body collapse">
								  <div class="accordion-inner">
									
									<div>
									<pre style="padding:0px">
									<table class="table table-striped table-responsive" style="margin:0px">
										<thead>
											<tr>
												<th>Language</th>
												<th>Read</th>
												<th>Write</th>
												<th>Speak</th>
												<th>First Language</th>
											</tr>
										</thead>
										<tbody>
											<?php echo $this->vacancy_model->get_languages($ID); ?>
										</tbody>
									</table>
									</pre>							
									</div>
										
								  </div>
								</div>
							  </div>
							  
							  							  
							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion6" href="#collapseSix">
									<h1>References ></h1>
								  </a>
								</div>
								<div id="collapseSix" class="accordion-body collapse">
								  <div class="accordion-inner">
									
									<div>
									<pre style="padding:0px">
									<table class="table table-striped table-responsive" style="margin:0px">
										<thead>
											<tr>
												<th>Name</th>
												<th>Organisation</th>
												<th>Contact Number</th>
												<th>Contact Email</th>
											</tr>
										</thead>
										<tbody>
											<?php echo $this->vacancy_model->get_references($ID); ?>
										</tbody>
									</table>
									</pre>							
									</div> 	
										
								  </div>
								</div>
							  </div>
							  
							  
							  <div class="accordion-group">
								<div class="accordion-heading">
								  <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion7" href="#collapseSeven">
									<h1>Leisure & Interests ></h1>
								  </a>
								</div>
								<div id="collapseSeven" class="accordion-body collapse">
								  <div class="accordion-inner">
									
									<div class="row-fluid">

										<?php echo $leisure; ?>
						
									</div> 	
										
								  </div>
								</div>
							  </div>							  							  								  						  
							  
										  
							</div>							
							
							<hr>
							<button class="btn btn-inverse" onClick="get_applicant_dump(<?php echo $ID; ?>)">Dump Applicant Details <i class="icon-download icon-white"></i> </button>
															            
                  </div>
				</div>
				
			</div>	
			
		<div class="row-fluid sortable">
		   <div class="box span12">
				<div class="box-header">
					<h2><i class="icon-th"></i><span class="break"></span>Applied for the following vacancies</h2>
					<div class="box-icon">
						<a href="#" class="btn-close"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="box-content">
				<table class="table table-striped table-responsive" style="margin:0px">
					<thead>
						<tr>
							<th>Application</th>
							<th>listing_date</th>
							<th>Status</th>
						</tr>
					</thead>
					<tbody id="app-list">
						<?php echo $this->vacancy_model->get_applications($ID); ?>
					</tbody>
				</table>
				</div>
			</div>
		</div>
		
		
		<div class="row-fluid sortable">

                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>CV Document</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php if($bio['cv']) { ?>
                  	  	<pre><?php echo $bio['cv']; ?> <a href="<?php echo NA_URL; ?>assets/vacancies/documents/cv/<?php echo $bio['cv']; ?>" target="_blank" class="btn btn-small btn-inverse pull-right"><i class="icon-download icon-white" style="color:#fff"></i></a></pre>               
                    <?php } ?>
					</div>
				</div>
				
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>ID Document</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php if($bio['id_doc']) { ?>
                  	  	<pre><?php echo $bio['id_doc']; ?> <a href="<?php echo NA_URL; ?>assets/vacancies/documents/id/<?php echo $bio['id_doc']; ?>" target="_blank" class="btn btn-small btn-inverse pull-right"><i class="icon-download icon-white" style="color:#fff"></i></a></pre>                  
                    <?php } ?>
					</div>
				</div>
				
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Drivers License</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php if($bio['license_doc']) { ?>
                  	  	<pre><?php echo $bio['license_doc']; ?> <a href="<?php echo NA_URL; ?>assets/vacancies/documents/license/<?php echo $bio['license_doc']; ?>" target="_blank" class="btn btn-small btn-inverse pull-right"><i class="icon-download icon-white" style="color:#fff"></i></a></pre>                  
                    <?php } ?>
					</div>
				</div>		
		
		
		</div>
		
	</div>
</div>	
		
	

        <div class="modal hide fade" id="modal-status-update">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Update Application Status</h3>
          </div>
          <div class="modal-body">
				<form id="update-status" name="update-status" method="post" action="<?php echo site_url('/');?>vacancy/update_status" class="form-horizontal">
					<input type="hidden" name="applicant_id" id="app-id" value="">
					<input type="hidden" name="vacancy_id" id="vac-id" value="">
					<select name="status">
						<option value="">Select Option</option>
						<option value="shortlist">Shortlist</option>
						<option value="longlist">Longlist</option>
						<option value="decline">Decline</option>
						<option value="pending">Pending</option>
					</select>
					<button type="submit" class="btn btn-inverse btn pull-right upbtn" id="butt">Update Status</button>
				</form>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-status-update').modal('hide');" class="btn">Close</a>
          </div>
        </div>

				
        <div class="clearfix"></div>
		
		<iframe src="" id="export_frame" allowtransparency="true" style="width:0; height:0"></iframe>
		
		<?php $this->load->view('admin/inc/footer');?>
		</div><!--/.fluid-container-->

	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    

	<script type="text/javascript">

	
		function update_status(vid, aid){
			  
			$('#modal-status-update').bind('show', function() {
				//var id = $(this).data('id'),
					updateBtn = $(this).find('.upbtn');

					$("#app-id").val(aid);
					$("#vac-id").val(vid);

					updateBtn.unbind('click').click(function(e) {

						var frm = $('#update-status');

						e.preventDefault();	
						$.ajax({
						  type: 'post',
						  data: frm.serialize(),							
						  url: "<?php echo site_url('/');?>vacancy/update_status/",
						  success: function(data) {

							$('#modal-status-update').modal('hide');
							$('footer').html(data);

							  reload_apps(aid);
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
	

		
	
		function get_applicant_dump(id) {

				var bus_id = <?php echo $this->session->userdata('bus_id'); ?>

				$('#export_frame').attr("src","<?php echo NA_URL.'vacancy/get_applicant_dump/'; ?>"+id+"/"+bus_id )

		}

		function reload_apps(aid){
			$.ajax({
				type: 'get',
				url: "<?php echo site_url('/');?>vacancy/reload_apps/<?php echo $ID; ?>",
				success: function(data) {

					$('#app-list').html(data);


				}
			});
		}
	
	
	</script>
</body>
</html>