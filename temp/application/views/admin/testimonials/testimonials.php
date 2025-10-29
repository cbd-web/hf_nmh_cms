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
						<a href="#">Testimonials</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Testimonials</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats">
                  	  	<?php $this->admin_model->get_all_testimonials();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Testimonial Stats</h2>
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

                      <p><a title="Delete the testimonial" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Testimonial</p>
                      
					</div>
                    <a href="<?php echo site_url('/');?>admin/add_testimonial/" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New Testimonial</a> 
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
				
		<div class="modal hide fade" id="modal-add">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Add Testimonial</h3>
          </div>
          <div class="modal-body">
            <form id="testimonial-add" name="testimonial-add" method="post" action="<?php echo site_url('/');?>admin/add_testimonial_do" class="form-horizontal">
            
            <div class="control-group">
                  <label class="control-label" for="title">Testimonial Title</label>
                <div class="controls">
                   <input type="text" id="title" name="title" placeholder="Testimonial Title" value="">
                   <span class="help-block" style="font-size:11px">The title or person who left the testimonial eg: John Smith</span>                    
                </div>
             </div>
             <div class="control-group">
                  <label class="control-label" for="name">Testimonial Reference</label>
                <div class="controls">
                   <input type="text" id="name" name="name" placeholder="Testimonial Reference" value="">
                   <span class="help-block" style="font-size:11px">The company or orginasation the person represents eg: Microsoft</span>                    
                </div>
             </div>

             
              <div class="control-group">
                	<h5>Testimonial</h5>
                   <textarea id="testimonial" name="testimonial"></textarea>                    
                
             </div>
			 
			 <div class="control-group">
			 	<?php $this->admin_model->get_featured_image('testimonial', $page_id);?>
			 </div> 
			 
            </form>
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-add').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Add testimonial</a>
          </div>
        </div>
        
        <div class="modal hide fade" id="modal-testimonial-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Testimonial</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current testimonial? All testimonial details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-testimonial-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Testimonial</a>
          </div>
        </div>
        
        
        
        <div class="modal hide fade" id="modal-update">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Update Testimonial</h3>
          </div>
          <div class="modal-body" id="update_content">
            
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-update').modal('hide');" class="btn">Close</a>
            <a onClick="update_testimonial_do()" id="update_testimonial_btn" class="btn btn-primary">Update testimonial</a>
          </div>
        </div>
        <div class="clearfix"></div>
				
       

            
	
	<?php $this->load->view('admin/inc/footer');?>
	</div><!--/.fluid-container-->
	<script type="text/javascript">
	
	$(document).ready(function(e) {
       
			/* ---------- Text Editor ---------- */
			$('#testimonial').redactor({ 	
						fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
						imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
						imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
						buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
						'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
						'video','file', 'table','|',
						 'alignment', '|', 'horizontalrule']
			});	
			
			
			
			$('div.btn-group button').live('click', function(){
				
				$('#status_edit').attr('value', $(this).html());
			});   
	    
    });	
		

	
			
		function delete_testimonial(id){
			  
			$('#modal-testimonial-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_testimonial/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-testimonial-delete').modal('hide');
							window.location = '<?php echo site_url('/');?>admin/testimonials';
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

						
			
						
						
		function add_testimonial(){
				
				$('#modal-add').bind('show', function() {
						
						var removeBtn = $(this).find('.btn-primary');
						
						removeBtn.unbind('click').click(function(e) { 
							e.preventDefault();
							var frm = $('#testimonial-add');
							removeBtn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
							$.ajax({
							  type: "post",
							  data: frm.serialize(),
							  url: "<?php echo site_url('/');?>admin/add_testimonial_do",
							  success: function(data) {
								removeBtn.html('Add Testimonial');
								$('#msg').html(data);
								$('#modal-add').modal('hide');
								window.location = '<?php echo site_url('/');?>admin/testimonials';
							  }
							});
							
						});
				}).modal({ backdrop: true });
				
			}			
			
			function update_testimonial(id){
				
				$('#modal-update').bind('show', function() {
						
						$.ajax({
							  type: "get",
							  url: "<?php echo site_url('/');?>admin/get_testimonial/"+id,
							  success: function(data) {
								
									$('#update_content').html(data);
										
	  
							  }
						});
							
					
				}).modal({ backdrop: true });
				
			}
			
			
			function update_testimonial_do(){
				
					  var frm = $('#testimonial-update');
					  $('#update_testimonial_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
					  $.ajax({
						type: "post",
						data: frm.serialize(),
						url: "<?php echo site_url('/');?>admin/update_testimonial_do",
						success: function(data) {
						  
						  $('#update_testimonial_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Update Testimonial');
						  $('#msg').html(data);
						  $('#modal-update').modal('hide');
						  window.location = '<?php echo site_url('/');?>admin/testimonials';
						}
					  });
					
				
			}
					
							
						

						

	</script>
</body>
</html>