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
						<a href="<?php echo site_url('/');?>vacancy/vacancies/">Vacancies</a><span class="divider">/</span>
					</li>
                    <li>
						Update Vacancy: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Vacancy: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="product-update" name="product-update" method="post" action="<?php echo site_url('/');?>admin/update_vacancy_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="vacancy_id"  value="<?php if(isset($vacancy_id)){echo $vacancy_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
										  
                                          <div class="control-group">
                                            <label class="control-label" for="title">Status</label>
                                            <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" class="btn btn-primary<?php if($status == 'draft'){ echo ' active';}?>">Draft</button>
                                                      <button type="button" class="btn btn-primary<?php if($status == 'live'){ echo ' active';}?>">Live</button>
                                                    </div>
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Product title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="ref_no">Reference Number</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="ref_no" name="ref_no" placeholder="Reference Number" value="<?php if(isset($ref_no)){echo $ref_no;}?>">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="location">Location</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="location" name="location" placeholder="Location" value="<?php if(isset($location)){echo $location;}?>">
                                            </div>
                                          </div>										    										  										  
										
                                      	 <div class="control-group">
												<label class="control-label" for="pub_date">Start Date</label>
												<div class="controls">
													 <div class="input-append date" id="date_start" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
													  <input type="text"  name="start_date" id="start_date" value="<?php if (isset($start_date)){echo date('Y-m-d',strtotime($start_date));}else{ echo date('Y-m-d');}?>" readonly>
													  <span class="add-on"><i class="icon-calendar"></i></span>
													</div> 
													<span class="help-block" style="font-size:11px">Select the vacancy start date</span>
												</div>			
                                         </div>
										 
										  <div class="control-group">
												<label class="control-label" for="pub_date">End Date</label>
												<div class="controls">
													 <div class="input-append date" id="date_end" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
													  <input type="text"  name="end_date" id="end_date" value="<?php if (isset($end_date)){echo date('Y-m-d',strtotime($end_date));}else{ echo date('Y-m-d');}?>" readonly>
													  <span class="add-on"><i class="icon-calendar"></i></span>
													</div> 
													<span class="help-block" style="font-size:11px">Select the vacancy end date</span>
												</div> 										  
										  </div>
										  
                                       	 <div class="control-group">
											<label class="control-label">Select Grading</label>
											<div class="controls">
												<select name="grading">
												<option value="0">Select Grading Category</option>
													<option value="Paterson A2" <?php if($grading == 'Paterson A2') { echo 'selected'; } ?>>Paterson A2</option>
													<option value="Paterson A3" <?php if($grading == 'Paterson A3') { echo 'selected'; } ?>>Paterson A3</option>
													<option value="Paterson B1" <?php if($grading == 'Paterson B1') { echo 'selected'; } ?>>Paterson B1</option>
													<option value="Paterson B2" <?php if($grading == 'Paterson B2') { echo 'selected'; } ?>>Paterson B2</option>
													<option value="Paterson B3" <?php if($grading == 'Paterson B3') { echo 'selected'; } ?>>Paterson B3</option>
													<option value="Paterson B4" <?php if($grading == 'Paterson B4') { echo 'selected'; } ?>>Paterson B4</option>
													<option value="Paterson BL" <?php if($grading == 'Paterson BL') { echo 'selected'; } ?>>Paterson BL</option>
													<option value="Paterson BU" <?php if($grading == 'Paterson BU') { echo 'selected'; } ?>>Paterson BU</option>
													<option value="Paterson C1" <?php if($grading == 'Paterson C1') { echo 'selected'; } ?>>Paterson C1</option>
													<option value="Paterson C2" <?php if($grading == 'Paterson C2') { echo 'selected'; } ?>>Paterson C2</option>
													<option value="Paterson C3" <?php if($grading == 'Paterson C3') { echo 'selected'; } ?>>Paterson C3</option>
													<option value="Paterson C4" <?php if($grading == 'Paterson C4') { echo 'selected'; } ?>>Paterson C4</option>
													<option value="Paterson CL" <?php if($grading == 'Paterson CL') { echo 'selected'; } ?>>Paterson CL</option>
													<option value="Paterson CU" <?php if($grading == 'Paterson CU') { echo 'selected'; } ?>>Paterson CU</option>
													
													<option value="Towers Watson Band 6" <?php if($grading == 'Towers Watson Band 6') { echo 'selected'; } ?>>Towers Watson Band 6</option>
													<option value="Towers Watson Band 5" <?php if($grading == 'Towers Watson Band 5') { echo 'selected'; } ?>>Towers Watson Band 5</option>
													<option value="Towers Watson Band 4" <?php if($grading == 'Towers Watson Band 4') { echo 'selected'; } ?>>Towers Watson Band 4</option>
													
												</select>
											</div>
                                         </div>											  
										 
                                       	 <div class="control-group">
											<label class="control-label">Select Career Category</label>
											<div class="controls">
												<select name="career">
												<option value="0">Select Career Category</option>
												<?php echo $this->vacancy_model->get_career_categories_select($career_id); ?>
												</select>
											</div>
                                         </div>	
										 
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="secondary_education">Secondary Education:</label>
                                                <div class="controls">
													<select name="secondary_education">
														<option value="">Choose a Option</option>
														<option value="10" <?php if($secondary_education == '10') { echo 'selected'; } ?>>Grade 10</option>
														<option value="12" <?php if($secondary_education == '12') { echo 'selected'; } ?>>Grade 12</option>
														<?php //echo $this->vacancy_model->get_qualifications('secondary', $secondary_education); ?>
													</select>
                                                </div>
                                           </div>
										   
<!--                                         <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="tertiary_education">Tertiary Education:</label>
                                                <div class="controls">
													<select name="tertiary_education">
														<option value="">Choose a Option</option>
														<?php //echo $this->vacancy_model->get_qualifications('tertiary', $tertiary_education); ?>
													</select>
                                                </div>
                                           </div>	-->								   										                                										  										  
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Vacancy Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea  class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                                                </div>
                                           </div>
										   
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Vacancy</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               </div> 
                <div class="row-fluid">
				
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->vacancy_model->get_featured_image($vacancy_id); ?>
                        
                        </p>                  
                    </div>
				</div>

                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured Document</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->vacancy_model->get_featured_document($vacancy_id); ?>
                        
                        </p>                  
                    </div>
				</div>
				
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Vacancy Applicants</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->vacancy_model->get_vacancy_applicants($vacancy_id); ?>
                        
                        </p>                  
                    </div>
				</div>   				            
                
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
		/* ---------- Text Editor ---------- */
		$('.redactor_content').redactor({ 	
					fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
					imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video','file', 'table', 'link','|',
					 'alignment', '|', 'horizontalrule'],
					linebreaks: true,
					focus:true,
					plugins: ['fullscreen', 'fontcolor', 'fontsize','fontfamily']
		});
		
		$('#date_start').datepicker();
		$('#date_end').datepicker();
					
	
	});

	
	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a product title"});
				$('#title').popover('show');
				$('#title').focus();
			
					
			
		}else{
	
			submit_form();
			
		}
	});
	
		$('div.btn-group button').live('click', function(){
			
			$('#status').attr('value', $(this).html());
		});
	
	
	function submit_form(){
			
			var frm = $('#product-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'vacancy/update_vacancy_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Vacancy');
					
				}
			});	
	
	}
		
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The product has not been saved.'; 
			
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
			url:       	   '<?php echo NA_SITE_URL.'vacancy/add_featured_image';?>' ,
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
	
		//Featured image
	$('#docbut').bind('click', function() {
		
		
		var avataroptions = { 
			target:        '#avatar_msg2',
			url:       	   '<?php echo NA_SITE_URL.'vacancy/add_featured_document';?>' ,
			beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
			uploadProgress: function(event, position, total, percentComplete) {
								var percentVal = percentComplete + '%';
								probar.width(percentVal)
								
							},
			 complete: function(xhr) {
								procover.hide();
								probar.width('0%');
								 $('#avatar_msg2').html(xhr.responseText);
							}				
	
		}; 
	
		var frm = $('#add-doc');
		var probar = $('#procover2 .bar');
		var procover = $('#procover2');
	
		$('#docbut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
		procover.show();
		frm.ajaxForm(avataroptions);
		$('#autosave').val('true');
	});
		
	
	</script>
</body>
</html>