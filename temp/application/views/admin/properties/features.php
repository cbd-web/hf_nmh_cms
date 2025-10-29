<?php $this->load->view('admin/inc/header');?>
<script type='text/javascript' src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>

<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery-ui-1.10.3.custom.min.js"></script>
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
						<a href="<?php echo site_url('/');?>property/properties/">Properties</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Features</a>
					</li>					
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All PROPERTY FEATURES</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats">
                  	  	<?php $this->property_model->get_all_features();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Feature Stats</h2>
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
						<h2><i class="icon-list"></i><span class="break"></span>Add Feature</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					 <div class="clearfix" style="height:20px;"></div> 
                       <form id="feature_add" name="feature_add" method="post" action="<?php echo site_url('/');?>property/add_feature" class="form-inline">
						   <fieldset>
                            <div class="input-append span12">
                              <input class="span8" id="appendedInputButtons" type="text" name="feature" placeholder="Feature name..." value="">
                              <button class="btn btn-inverse btn" id="btn_cat" onClick="add_feature()" type="button"><i class="icon-plus-sign icon-white"></i> Add Feature</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form>
                    
                    
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

                      <p><a title="Delete the feature" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Feature</p>
                      
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
		
        
        <div class="modal hide fade" id="modal-feature-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Feature</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current feature? All feature details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-feature-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Feature</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
		<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    
	<script type="text/javascript">
		function delete_feature(id){
			  
			$('#modal-feature-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>property/delete_feature/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-feature-delete').modal('hide');
							reload_features();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

						
						function add_feature(){
			
							
							//Validate
							if($('#appendedInputButtons').val().length == 0){
									
									$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a feature name"});
									$('#appendedInputButtons').popover('show');
									$('#appendedInputButtons').focus();
							
							}else{
								
								
								var frm = $('#feature_add');
								//frm.submit();
								$('#btn_cat').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
								$.ajax({
									type: 'post',
									data: frm.serialize(),
									url: '<?php echo site_url('/').'property/add_feature';?>' ,
									success: function (data) {
										
										 $('#result_msg').html(data);
										 $('#btn_cat').html('<i class="icon-plus-sign icon-white"></i> Add Feature');
										 reload_features();
										 document.getElementById("appendedInputButtons").value = "";

										 var options = {'text':'Feature added successfully','layout':'bottomLeft','type':'success'};
				  						 noty(options);
									}
								});	
					
								
							}		
						
						}
						
					
						function reload_features(){
			
								$.ajax({
									type: 'get',
									url: '<?php echo site_url('/').'property/reload_features_all/';?>' ,
									success: function (data) {
										
										 $('#curr_cats').html(data);
										 $('.datatable').dataTable({
											"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
											"sPaginationType": "bootstrap",
											"oLanguage": {
											"sLengthMenu": "_MENU_"
											}
										} );
									}
								});	
						
						
						}
											
						
						
						$(document).ready(function() {
		
							<?php echo $this->property_model->load_feature_typehead();?>
	
				
							$('#appendedInputButtons').typeahead({source: subjects}) 
					
						});
						

	</script>
</body>
</html>