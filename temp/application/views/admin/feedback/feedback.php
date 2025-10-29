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
						<a href="#">Feedback</a>
					</li>
				</ul>
				<hr>
			</div>
		
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Response Enquiries</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats"><?php $this->admin_model->get_all_feedback();?></div>
				</div>
			</div>
		</div>

		<!-- end: Content -->
	</div><!--/#content.span12-->
			
        <div class="modal hide fade" id="modal-feedback-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Message</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current message? All message details will be lost.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-feedback-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Message</a>
          </div>
        </div>

	

<?php $this->load->view('admin/inc/footer');?>

</div><!--/.fluid-container-->

<script type="text/javascript">
	function delete_message(id){
		  
		$('#modal-feedback-delete').bind('show', function() {
			//var id = $(this).data('id'),
				removeBtn = $(this).find('.btn-primary');
					
				removeBtn.unbind('click').click(function(e) { 
					e.preventDefault();	
					$.ajax({
					  url: "<?php echo site_url('/');?>admin/delete_feedback/"+id+"/",
					  success: function(data) {
						
						$('footer').html(data);
						$('#modal-feedback-delete').modal('hide');
						window.location = '<?php echo site_url('/');?>admin/feedback';
					  }
					});
					
				});
		}).modal({ backdrop: true });
	}

						



					

</script>
</body>
</html>