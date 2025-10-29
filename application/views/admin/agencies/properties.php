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
						<a href="#">Agency Properties</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span10">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Agency Properties</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<div class="alert">Please check all Properties you wish to feature, and click on the "Save List" Button to store the changes.</div>
					<form id="feat-update" name="feat-update" method="post" action="<?php echo site_url('/'); ?>admin/update_property_feature_do">
						<input type="hidden" value="<?php echo $id; ?>" name="agent">
					<?php $this->my_namibia_model->get_all_agent_properties($id); ?>
					<button name="agent_submit" id="butt" type="submit" class="btn btn-inverse" />Save List</button>
					</form>
					</div>
				</div>
	
			</div>

		<!-- end: Content -->
		</div><!--/#content.span10-->
	</div><!--/fluid-row-->
			
	<?php $this->load->view('admin/inc/footer');?>
</div><!--/.fluid-container-->
 <div id="result_msg"></div>       
 <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>       
 <script type="text/javascript">

	$(document).ready(function(){
	
		$('#butt').click(function(e) {
			
			e.preventDefault();
			submit_form();
		
		});


		
	});


	function submit_form(){
			
		var frm = $('#feat-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'admin/update_property_feature_do';?>' ,
			success: function (data) {

				
				 $('#result_msg').html(data);
				 $('#butt').html('Save List');
				
			}
		});	
	
	}

</script>
</body>
</html>