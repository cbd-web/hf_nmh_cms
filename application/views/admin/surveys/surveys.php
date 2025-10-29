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
						<a href="#">Surveys</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Surveys</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<?php $this->survey_model->get_all_surveys();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Survey Stats</h2>
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
                    
                      <p><a title="Update the survey" rel="tooltip" class="btn btn-mini" style="cursor:pointer"><i class="icon-pencil"></i></a> - Update Survey</p>
                      <p><a title="Delete the survey" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Survey</p>
                      
					</div>
						
                    
                    
                    <a href="<?php echo site_url('/');?>survey/add_survey/" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New Survey</a>
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
		
        
        <div class="modal hide fade" id="modal-survey-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Survey</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current survey? All survey details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-survey-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Survey</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
			<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
        
        
	<script type="text/javascript">
		function delete_survey(id){
			  
			$('#modal-survey-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						removeBtn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
						
						$.ajax({
						  url: "<?php echo site_url('/');?>survey/delete_survey/"+id+"/",
						  success: function(data) {
							removeBtn.html('Delete Survey');
							$('footer').html(data);
							$('#modal-survey-delete').modal('hide');
							window.location = "<?php echo current_url('/');?>";
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

	</script>
</body>
</html>