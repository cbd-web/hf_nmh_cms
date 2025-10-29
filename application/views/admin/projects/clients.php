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
						<a href="<?php echo site_url('/');?>project/projects">Projects</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Clients</a>
					</li>					
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Clients</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats">
                  	  	<?php $this->project_model->get_all_clients();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Client Stats</h2>
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
						<h2><i class="icon-list"></i><span class="break"></span>Add Client</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					 <div class="clearfix" style="height:20px;"></div> 
                       <form id="client_add" name="client_add" method="post" action="<?php echo site_url('/');?>project/add_client_do" class="form-inline">
                             <fieldset>                      
                            <div class="input-append span12">
                              <input class="span8" id="appendedInputButtons" type="text" name="client" placeholder="Client name..." value="">
                              <button class="btn btn-inverse btn" id="btn_cat" onClick="add_project_client()" type="button"><i class="icon-plus-sign icon-white"></i> Add Client</button>
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

                      <p><a title="Delete the client" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Client</p>
                      
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
		
        
        <div class="modal hide fade" id="modal-client-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Client</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current client? All client details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-client-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Client</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
		<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    
	<script type="text/javascript">
		function delete_client(id){
			  
			$('#modal-client-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>project/delete_client/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-client-delete').modal('hide');
							reload_client();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

						
						function add_project_client(){
			
							
							//Validate
							if($('#appendedInputButtons').val().length == 0){
									
									$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a client name"});
									$('#appendedInputButtons').popover('show');
									$('#appendedInputButtons').focus();
							
							}else{
								
								
								var frm = $('#client_add');
								//frm.submit();
								$('#btn_cat').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
								$.ajax({
									type: 'post',
									data: frm.serialize(),
									url: '<?php echo site_url('/').'project/add_client';?>' ,
									success: function (data) {
										
										 $('#result_msg').html(data);
										 $('#btn_cat').html('<i class="icon-plus-sign icon-white"></i> Add Client');
										 reload_client();
										 document.getElementById("appendedInputButtons").value = "";

										 var options = {'text':'Client added successfully','layout':'bottomLeft','type':'success'};
				  						 noty(options);
									}
								});	
					
								
							}		
						
						}
						
					
						function reload_client(){
			
								$.ajax({
									type: 'get',
									url: '<?php echo site_url('/').'project/reload_client_all/';?>' ,
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
		
							<?php echo $this->project_model->load_client_typehead();?>
	
				
							$('#appendedInputButtons').typeahead({source: subjects}) 
					
						});
						

	</script>
</body>
</html>