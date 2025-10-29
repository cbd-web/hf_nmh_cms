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
						Add New Vacancy
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Vacancy</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="vacancy-add" name="vacancy-add" method="post" action="<?php echo site_url('/');?>vacancy/add_vacancy_do" class="form-horizontal">
                             <fieldset>
    
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span8" id="title" name="title" placeholder="Vacancy title" value="">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="ref_no">Reference Number</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="ref_no" name="ref_no" placeholder="Reference Number" value="">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="location">Location</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="location" name="location" placeholder="Location" value="">
                                            </div>
                                          </div>										  										  
										  
                                      	 <div class="control-group">
											<label class="control-label" for="pub_date">Start Date</label>
											<div class="controls">
												 <div class="input-append date" id="date_start" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
												  <input type="text"  name="start_date" id="start_date" value="<?php echo date('Y-m-d'); ?>" readonly>
												  <span class="add-on"><i class="icon-calendar"></i></span>
												</div> 
												<span class="help-block" style="font-size:11px">Select the vacancy start date</span>
											</div> 
                                         </div>	
										 
                                      	 <div class="control-group">
											<label class="control-label" for="pub_date">End Date</label>
											<div class="controls">
												 <div class="input-append date" id="date_end" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
												  <input type="text"  name="end_date" id="end_date" value="<?php echo date('Y-m-d'); ?>" readonly>
												  <span class="add-on"><i class="icon-calendar"></i></span>
												</div> 
												<span class="help-block" style="font-size:11px">Select the vacancy end date</span>
											</div> 
                                         </div>
										 
                                      	 <div class="control-group">
											<label class="control-label">Select Career Category</label>
											<div class="controls">
												<select name="career">
												<option value="0">Select Career Category</option>
												<?php echo $this->vacancy_model->get_career_categories_select(); ?>
												</select>
											</div>
                                         </div>
										 										 										 										 										 									  									  
   
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Vacancy</button>
                                           
                               </fieldset> 
                             </form>
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
		
        <div class="clearfix"></div>
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
	
	$(document).ready(function(){
				
		$('#date_start').datepicker();
		$('#date_end').datepicker();
						
	});
	
	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a vacancy title"});
				$('#title').popover('show');
				$('#title').focus();
				
			
		}else{
	
			submit_form();
			
		}
	});
	
	
	function submit_form(){
			
			var frm = $('#vacancy-add');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'vacancy/add_vacancy_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Vacancy');
					
				}
			});	
	
	}
	
	
	</script>
</body>
</html>