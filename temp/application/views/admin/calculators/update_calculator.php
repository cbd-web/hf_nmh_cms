<?php $this->load->view('admin/inc/header');

switch($type) {
	case 'calc_bond_costs':	
	$title = 'Bond Cost Calculator';
	break;
}

?>
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
						<a href="<?php echo site_url('/');?>calculator/claculators/">Calculators</a><span class="divider">/</span>
					</li>
                    <li>
						Update Calculator
					</li>
				</ul>
				<hr>
			</div>
			
			<?php $this->load->view('admin/calculators/inc/'.$type);?>
			

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
	

	</script>
</body>
</html>