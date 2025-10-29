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
						<a href="<?php echo site_url('/');?>product/products">Products</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Manufacturers</a>
					</li>					
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Product Manufacturers</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats">
                  	  	<?php $this->product_model->get_all_manufacturers();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Manufacturer Stats</h2>
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
						<h2><i class="icon-list"></i><span class="break"></span>Add Manufacturer</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					 <div class="clearfix" style="height:20px;"></div> 
                       <form id="manufacturer_add" name="manufacturer_add" method="post" action="<?php echo site_url('/');?>product/add_manufacturer_do" class="form-inline">
                             <fieldset>                      
                            <div class="input-append span12">
                              <input class="span8" id="appendedInputButtons" type="text" name="manufacturer" placeholder="Manufacturer name..." value="">
                              <button class="btn btn-inverse btn" id="btn_cat" onClick="add_manufacturer();" type="button"><i class="icon-plus-sign icon-white"></i> Add Manufacturer</button>
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

                      <p><a title="Delete the manufacturer" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Manufacturer</p>
                      
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
		
        
        <div class="modal hide fade" id="modal-manufacturer-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Manufacturer</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current manufacturer? All manufacturer details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-manufacturer-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Manufacturer</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
		<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    
	<script type="text/javascript">
		function delete_manufacturer(id){
			  
			$('#modal-manufacturer-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>product/delete_manufacturer/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-manufacturer-delete').modal('hide');
							reload_manufacturer();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

						
						function add_manufacturer(){
			
							
							//Validate
							if($('#appendedInputButtons').val().length == 0){
									
									$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a manufacturer name"});
									$('#appendedInputButtons').popover('show');
									$('#appendedInputButtons').focus();
							
							}else{
								
								
								var frm = $('#manufacturer_add');
								//frm.submit();
								$('#btn_cat').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
								$.ajax({
									type: 'post',
									data: frm.serialize(),
									url: '<?php echo site_url('/').'product/add_manufacturer';?>' ,
									success: function (data) {
										
										 $('#result_msg').html(data);
										 $('#btn_cat').html('<i class="icon-plus-sign icon-white"></i> Add Manufacturer');
										 reload_manufacturer();
										 document.getElementById("appendedInputButtons").value = "";

										 var options = {'text':'Manufacturer added successfully','layout':'bottomLeft','type':'success'};
				  						 noty(options);
									}
								});	
					
								
							}		
						
						}
						
					
						function reload_manufacturer(){
			
								$.ajax({
									type: 'get',
									url: '<?php echo site_url('/').'product/reload_manufacturer_all/';?>' ,
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
		
							<?php echo $this->product_model->load_manufacturer_typehead();?>
	
				
							$('#appendedInputButtons').typeahead({source: subjects}) 
					
						});
						

	</script>
</body>
</html>