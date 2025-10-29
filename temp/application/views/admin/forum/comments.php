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
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Comments</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<?php $this->forum_model->get_all_comments();?>
                                        
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
    
    		<div class="modal hide fade" id="modal-comment-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Comment</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a data-dismiss="modal" aria-hidden="true" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete</a>
          </div>
        </div>
        
    </div><!--/.fluid-container-->
        
        
	<script type="text/javascript">

		function delete_comment(id){
			  
			$('#modal-comment-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>forum/delete_comment/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-comment-delete').modal('hide');
							
							$("#tr_"+id).fadeOut().empty();
							//window.location.reload();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		
		
		function update_comment_status(id, str){
			 
			 var cog = $('#cog_'+id);
			 cog.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" />');
			 
			 $.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'forum/update_comment_status/';?>'+id+'/'+str,
				success: function (data) {
					
					if(str == 'moderate'){
						$("#btn_"+id).attr("onclick","update_comment_status("+id+",'live');").html('<i class="icon-play"></i> Activate');
						$('#mod_'+id).fadeIn();
					}else{
						$('#mod_'+id).fadeOut();
						$("#btn_"+id).attr("onclick","update_comment_status("+id+",'moderate');").html('<i class="icon-pause"></i> Deactivate');
					}
					 cog.html('<i class="icon-cog"></i>');
					//reload_businesses();	 
				}
			});	
	
			
		}
	</script>
</body>
</html>