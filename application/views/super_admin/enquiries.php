<?php $this->load->view('admin/inc/header');?>
<body>

	<?php $this->load->view('super_admin/inc/nav_top');?>
		
	<div class="container-fluid">
		<div class="row-fluid">
			<?php $this->load->view('super_admin/inc/nav_main');?>
			<div id="content" class="span10">
			<!-- start: Content -->
			<div>
				<hr>
				<ul class="breadcrumb">
					<li>
						<a href="<?php echo site_url('/');?>">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Enquiries</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Enquiries</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats">
                  	  	<?php $this->super_admin_model->get_all_enquiries();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Enquiry Stats</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<?php //$this->google_model->load_overview();?>
					</div>
				</div><!--/span-->
                
  
                
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Legend</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                    
                   
                     <div class="well">

                      <p><a title="Delete the enquiry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Enquiry</p>
                      
					</div>
                    
		    		</div>
				</div><!--/span-->
                
			</div>
			
			<hr>
			
			<div class="row-fluid">
				
				
				
			</div>
			
			<hr>
			

			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				

        <div class="modal hide fade" id="modal-enquiry-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Enquiry</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current enquiry? All enquiry details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-enquiry-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Enquiry</a>
          </div>
        </div>
        
 		<div class="modal hide fade" id="modal-view">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Enquiry</h3>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-view').modal('hide');" class="btn">Close</a>
            <a onClick="reply_email()" class="btn btn-primary">Reply</a>
          </div>
        </div>
        
        
        <div class="clearfix"></div>
				
       

            
	
	<?php $this->load->view('admin/inc/footer');?>
	</div><!--/.fluid-container-->
	<script type="text/javascript">
		function delete_enquiry(id){
			  
			$('#modal-enquiry-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_enquiry/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-enquiry-delete').modal('hide');
							window.location = '<?php echo site_url('/');?>admin/enquiries';
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

						
		function view_enquiry(id){
			  
			$('#modal-view').bind('show', function() {
				    
					modal_cont = $(this).find('.modal-body');
					$.ajax({
						  cache: false,
						  url: "<?php echo site_url('/');?>admin/get_enquiry/"+id+"/",
						  success: function(data) {
							
							modal_cont.html(data);
							
						  }
						});
					
					Btn = $(this).find('.btn-primary');	
					Btn.unbind('click').click(function(e) { 
						
					});
			}).modal({ backdrop: true });
		}	


						

	</script>
</body>
</html>