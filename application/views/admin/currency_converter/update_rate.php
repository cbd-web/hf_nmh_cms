<?php $this->load->view('admin/inc/header');?>
    <script type='text/javascript' src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery-ui-1.10.3.custom.min.js"></script>

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
						<a href="<?php echo site_url('/');?>converter/rates/">Currency Converter - Rates</a><span class="divider">/</span>
					</li>
                    <li>
						Update Rate: <?php echo $ccyr_id; ?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">

				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Rate: <?php echo $ccyr_id; ?></h2>
						<div class="box-icon">
                        	<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="rate-update" name="rate-update" method="post" action="<?php echo site_url('/');?>converter/update_rate_do" class="form-horizontal">
                             <fieldset>
    									<input type="hidden" name="rate_id"  value="<?php if(isset($ccyr_id)){echo $ccyr_id;}?>">
                                        <input type="hidden" name="autosave" id="autosave"  value="true">
										
										
                                      	 <div class="control-group">
											<label class="control-label">Select a Branch</label>
											<div class="controls">
												<select name="branch">
												<option value="0">Select a Branch</option>
												<?php echo $this->converter_model->get_branch_select($ccyr_branch_id); ?>
												</select>
											</div>
                                         </div>
										  
                                      	 <div class="control-group">
											<label class="control-label">Select a Code</label>
											<div class="controls">
												<select name="code">
												<option value="0">Select a Code</option>
												<?php echo $this->converter_model->get_code_select($ccyr_cyy_code); ?>
												</select>
											</div>
                                         </div>

                                      	 <div class="control-group">
											<label class="control-label">Select a Type</label>
											<div class="controls">
												<select name="type">
												<option value="0">Select a Type</option>
												<?php echo $this->converter_model->get_type_select($ccyr_ccyt_type); ?>
												</select>
											</div>
                                         </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="location">Cost Rate</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="cost_rate" name="cost_rate" placeholder="Cost Rate" value="<?php echo $ccyr_cost_rate; ?>">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="location">Margin Adjustment</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="margin" name="margin" placeholder="Margin Adjustment" value="<?php echo $ccyr_margin_adj; ?>">
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="location">Is rate inverted?</label>
											 <div class="controls">
												 <select name="inverted">
													 <option value="N" <?php if($inverted == 'N') { echo 'selected'; } ?>>No</option>
													 <option value="Y" <?php if($inverted == 'Y') { echo 'selected'; } ?>>Yes</option>
												 </select>
											 </div>
										 </div>

                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Rate</button>
                                         
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

	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
	<script type="text/javascript">	
	
	
	$(document).ready(function(){
						
		$('#butt').bind('click',function(e) {
			e.preventDefault();
			
			var frm = $('#rate-update');
			
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'converter/update_rate_do';?>' ,
				success: function (dataresult) {
					 $('#autosave').val('true');
					 $('#result_msg').html(dataresult);
					 $('#butt').html('Update Rate');
				}
			});	
		});
		
	});

			
	
	
	//IE 9 Fix
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}		
	
	</script>
</body>
</html>