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
						<a href="<?php echo site_url('/');?>converter/rates/">Currency Converter Rates</a><span class="divider">/</span>
					</li>
                    <li>
						Add New Rate
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Rate</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="rate-add" name="rate-add" method="post" action="<?php echo site_url('/');?>converter/add_rate_do" class="form-horizontal">
                             <fieldset>
    
                                      	 <div class="control-group">
											<label class="control-label">Select a Branch</label>
											<div class="controls">
												<select name="branch">
												<option value="0">Select a Branch</option>
												<?php echo $this->converter_model->get_branch_select(); ?>
												</select>
											</div>
                                         </div>
										  
                                      	 <div class="control-group">
											<label class="control-label">Select a Code</label>
											<div class="controls">
												<select name="code">
												<option value="0">Select a Code</option>
												<?php echo $this->converter_model->get_code_select(); ?>
												</select>
											</div>
                                         </div>

                                      	 <div class="control-group">
											<label class="control-label">Select a Type</label>
											<div class="controls">
												<select name="type">
												<option value="0">Select a Type</option>
												<?php echo $this->converter_model->get_type_select(); ?>
												</select>
											</div>
                                         </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="location">Cost Rate</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="cost_rate" name="cost_rate" placeholder="Cost Rate" value="">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="location">Margin Adjustment</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="margin" name="margin" placeholder="Margin Adjustment" value="">
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="location">Is rate inverted?</label>
											 <div class="controls">
												 <select name="inverted">
													 <option value="N">No</option>
													 <option value="Y">Yes</option>
												 </select>
											 </div>
										 </div>

                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Rate</button>
                                           
                               </fieldset> 
                             </form>
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
    

	<script type="text/javascript">
	

	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		
			var frm = $('#rate-add');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'converter/add_rate_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Rate');
					
				}
			});	
	});
	
	
	
	</script>
</body>
</html>