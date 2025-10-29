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
						<a href="#">Comments</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Comments</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<?php $this->admin_model->get_all_comments();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Comment Stats</h2>
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
                    
                      <p><a title="View the comment" rel="tooltip" class="btn btn-mini" style="cursor:pointer"><i class="icon-search"></i></a> - View Comment</p>
                      <p><a title="Delete the comment" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Comment</p>
                      <p><a title="Make comment Live" rel="tooltip" class="btn btn-mini btn-warning" style="cursor:pointer"><i class="icon-off"></i></a> - Publish Comment</p>
                       <p><a title="Pause the Comment" rel="tooltip" class="btn btn-mini btn-success" style="cursor:pointer"><i class="icon-play"></i></a> - Pause the Comment</p>
					</div>
						
                    
                    
                    <!--<a href="<?php echo site_url('/');?>admin/add_comment/" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New Comment</a> -->
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
				
		<div class="modal hide fade" id="view_comment">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Comment</h3>
			</div>
			<div class="modal-body" id="view_comment_body">
				
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				
			</div>
		</div>
		
        
        <div class="modal hide fade" id="modal-comment-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Comment</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current comment? All comment details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-comment-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Comment</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
		
        	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
        
	<script type="text/javascript">
		function delete_comment(id){
			  
			$('#modal-comment-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_comment/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-comment-delete').modal('hide');
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		function view_comment(id){
			  
			$('#view_comment').bind('show', function() {
		
				  $.ajax({
					url: "<?php echo site_url('/');?>admin/view_comment/"+id+"/",
					success: function(data) {
					  
					  $('#view_comment_body').html(data);
					  
					}
					});

			}).modal({ backdrop: true });
		}
		function update_status(id, status){
				 
			  $.ajax({
					url: "<?php echo site_url('/');?>admin/update_comment_status/"+id+"/"+status+"/",
					success: function(data) {
					   $('footer').html(data);
					
					  
					}
				});

		}
	</script>
</body>
</html>