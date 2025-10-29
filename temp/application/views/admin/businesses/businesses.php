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
							<a href="#">Businesses</a>
						</li>
					</ul>
					<hr>
				</div>
			
				<div class="row-fluid sortable">
					<div class="box span6">
						<div class="box-header">
							<h2><i class="icon-th"></i><span class="break"></span>All Businesses</h2>
							<div class="box-icon">
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<?php $this->my_namibia_model->get_all_businesses();?>
					 	</div>
					</div>
					<div class="box span6">
						<div class="box-header">
							<h2><i class="icon-th"></i><span class="break"></span>Selected Businesses</h2>
							<div class="box-icon">
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content" id="curr_bus">
							<?php $this->my_namibia_model->get_selected_businesses();?>                                  
					 	</div>
					</div>					
					
				</div>
			
		
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
        
		<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
        
 <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
 
 <script type="text/javascript">

	$(document).ready(function(){

	});

	
	
	function add_business(bid){
			
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'admin/add_business_do/';?>'+bid ,
			success: function (data) {

				
				 reload_businesses();
				 $('#result_msg').html(data);
				 
				
			}
		});	
	
	}	
	
	
	function remove_business(bid){
			
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'admin/remove_business_do/';?>'+bid ,
			success: function (data) {

				
				 reload_businesses();
				 $('#result_msg').html(data);
				 
				
			}
		});	
	
	}		
	
	
	function reload_businesses(){
	
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/reload_businesses/' ;?>' ,
			success: function (data) {
				
				$('#curr_bus').html(data);
				$('.datatable').dataTable();

			}
		});	
	
	}	

</script>
</body>
</html>