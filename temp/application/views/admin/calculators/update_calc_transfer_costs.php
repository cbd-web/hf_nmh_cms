<?php $this->load->view('admin/inc/header'); ?>
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
						<a href="<?php echo site_url('/');?>calculator/">Calculators</a><span class="divider">/</span>
					</li>
                    <li>
						Update Transfer Costs Calculator
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Calculator: Transfer Costs</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
						<form id="calc-update" name="calc-update" method="post" action="<?php echo site_url('/');?>calculator/update_calculator_do" class="form-horizontal">
							<fieldset>
								<input type="hidden" name="id"  value="<?php if(isset($id)){echo $id;}?>">
								<input type="hidden" name="type"  value="<?php if(isset($type)){echo $type;}?>">
								<input type="hidden" name="autosave" id="autosave"  value="true">
								<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
								
							  <div class="control-group">
								<label class="control-label" for="status">Status</label>
								<div class="controls">
									<div class="btn-group" data-toggle="buttons-radio">
									  <button type="button" class="btn btn-primary status<?php if($status == 'draft'){ echo ' active';}?>">draft</button>
									  <button type="button" class="btn btn-primary status<?php if($status == 'live'){ echo ' active';}?>">live</button>
									</div>
								</div>
							  </div>											
								
							  <div class="control-group">
								<label class="control-label" for="name">Vat</label>
								<div class="controls">
										<input type="number"  step="0.01" class="span6" id="vat" name="vat" placeholder="VAT (%)" value="<?php if(isset($vat)){echo $vat;}?>">
								</div>
							  </div>
							  <div class="control-group">
								<label class="control-label" for="name">Office Fee</label>
								<div class="controls">
										<input type="text" class="span6" id="office_fee" name="office_fee" placeholder="Office Fee" value="<?php if(isset($office_fee)){echo $office_fee;}?>">
								</div>
							  </div>
							  
							  <div class="control-group">
								<label class="control-label" for="name">Sundries & Postage + 15% VAT</label>
								<div class="controls">
										<input type="text" class="span6" id="sundries" name="sundries" placeholder="Sundries & Postage + 15% VAT" value="<?php if(isset($sundries)){echo $sundries;}?>">
								</div>
							  </div>									  									  										  
							  
							  <div id="result_msg"></div>
							  
							  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Calculator</button> 
					   </fieldset> 
					 </form>
		             	</p>                  
                  </div>
				</div>
			</div>
			<div class="row-fluid sortable">
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Bond Cost Fees</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<form id="add-fee" name="add-fee" method="post" action="<?php echo site_url('/');?>calculator/add_fee" class="form-horizontal">
							<input type="hidden" name="id"  value="<?php if(isset($id)){echo $id;}?>">
							<input type="hidden" name="type"  value="<?php if(isset($type)){echo $type;}?>">						
							<div class="control-group">
							<input type="text" id="range" name="range" placeholder="Range">
							<input type="text" id="amount" name="amount" placeholder="Amount">
							</div>
							<div class="control-group">
							<button type="submit" class="btn btn-inverse" id="butt2">Add Fee</button> 
						</div>
						</form>
						<div id="fee-list">
							<?php echo $this->calculator_model->get_all_fees($id, $type); ?>  
						</div>              
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
			
	$('#butt').bind('click' , function(e) {	
		e.preventDefault();
		
		var frm = $('#calc-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'calculator/update_calculator_do';?>' ,
			success: function (data) {
				 $('#autosave').val('true');
				 $('#result_msg').html(data);
				 $('#butt').html('Update Calculator');
				
			}
		});	
	});
	
	$('#butt2').bind('click' , function(e) {	
		e.preventDefault();
		
		var frm = $('#add-fee');
		//frm.submit();
		$('#butt2').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'calculator/add_fee';?>' ,
			success: function (data) {
				 $('#autosave').val('true');
				 $('#result_msg').html(data);
				 $('#butt2').html('Add Fee');
				 
				 reload_fees();
				
			}
		});	
	});	
	
	$('div.btn-group button.status').live('click', function(){

		$('#status').attr('value', $(this).html());
	});
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The calculator has not been saved.'; 
			
		 }
		 
	};
	
	$('input').change(function() {
	  $('#autosave').val('false');
	});
	$('.redactor_box').live('click', function() {
	  $('#autosave').val('false');
	});

	function reload_fees(){
			
			$.ajax({
				type: 'get',
				cache:false,
				url: '<?php echo site_url('/').'calculator/reload_fees/'.$id.'/'.$type; ?>',
				success: function (data) {
					 
					 $('#fee-list').html(data);
				}
			});	
	
	}	

	</script>
</body>
</html>