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
						<a href="#">Forum</a>
					</li>
					<li>
						<a href="#">Users</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Users</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats">
						<div class="well well-mini">

							<p class="text-right">
								<a class="btn btn-primary" onClick="export_report()" id="export_btn"><i class="icon-share icon-white"></i> Export Users</a>
								<a onClick="add_forum_user()" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New User</a>
							</p>
						</div>

                  	  	<?php $this->forum_model->get_all_users();?>
                                       
                  </div>
				</div>
            </div>
            <div class="row-fluid sortable">    
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>User Stats</h2>
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

                      <p><a title="Delete the user" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete User</p>
                      
					</div>
                    <a onClick="add_forum_user()" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New User</a> 
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
            <h3>Add forum user</h3>
          </div>
          <div class="modal-body">
            <form id="user-add" name="user-add" method="post" action="<?php echo site_url('/');?>forum/add_forum_user_do" class="form-horizontal">
            
            <div class="control-group">
                  <label class="control-label" for="name">User Name</label>
                <div class="controls">
                   <input type="text" id="name" name="name" placeholder="User Name" value="">                    
                </div>
             </div>
              <div class="control-group">
                  <label class="control-label" for="sname">Surname</label>
                <div class="controls">
                   <input type="text" id="sname" name="sname" placeholder="Surname" value="">                    
                </div>
             </div>
              <div class="control-group">
                  <label class="control-label" for="position">User Position</label>
                <div class="controls">
                    <select name="position" id="position">
                      <option value="editor">Editor</option>
                      <option value="admin">Admin</option>
                     
                    </select>                    
                </div>
             </div>
             <div class="control-group">
                  <label class="control-label" for="type">Type</label>
                <div class="controls">
                   <?php echo $this->forum_model->get_user_types(0);?>                
                </div>
             </div>
             
             
             
             <div class="control-group">
                  <label class="control-label" for="email">User Email</label>
                <div class="controls">
                   <input type="text" id="email" name="email" placeholder="User Email" value="">                    
                </div>
             </div>
             <div class="control-group">
                  <label class="control-label" for="userpass">User Password</label>
                <div class="controls">
                   <input type="password" id="userpass" name="userpass" placeholder="User Password" value="">                    
                </div>
             </div>  
               
                
            </form>
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-add').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Add user</a>
          </div>
        </div>
        
        <div class="modal hide fade" id="modal-user-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the User</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current user? All user details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-user-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete User</a>
          </div>
        </div>
        
        
        
        <div class="modal hide fade" id="modal-update">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Update forum user</h3>
          </div>
          <div class="modal-body" id="update_content">
            
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-update').modal('hide');" class="btn">Close</a>
            <a onClick="update_forum_user_do()" id="update_user_btn" class="btn btn-primary">Update user</a>
          </div>
        </div>
        <div class="clearfix"></div>
				
       

            
	
	<?php $this->load->view('admin/inc/footer');?>
	</div><!--/.fluid-container-->
	<iframe id="export_frame" src="" allowtransparency="true" frameborder="0" style="width:0;height:0"></iframe>
	<script type="text/javascript">
		function delete_user(id){
			  
			$('#modal-user-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>forum/delete_user/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-user-delete').modal('hide');
							window.location = '<?php echo site_url('/');?>forum/users';
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

						
			
						
						
				function add_forum_user(){
						
						$('#modal-add').bind('show', function() {
								
								var removeBtn = $(this).find('.btn-primary');
								
								removeBtn.unbind('click').click(function(e) { 
									e.preventDefault();
									var frm = $('#user-add');
									removeBtn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
									$.ajax({
									  type: "post",
									  data: frm.serialize(),
									  url: "<?php echo site_url('/');?>forum/add_forum_user_do",
									  success: function(data) {
										removeBtn.html('Add User');
										$('#msg').html(data);
										$('#modal-add').modal('hide');
										window.location = '<?php echo site_url('/');?>forum/users';
									  }
									});
									
								});
						}).modal({ backdrop: true });
						
					}			
					
					function update_forum_user(id){
						
						$('#modal-update').bind('show', function() {
								
									$.ajax({
									  type: "get",
									  url: "<?php echo site_url('/');?>forum/get_forum_user/"+id,
									  success: function(data) {
										
										$('#update_content').html(data);
									  }
									});
									
							
						}).modal({ backdrop: true });
						
					}
					
					
					function update_forum_user_do(){
						
							  var frm = $('#user-update');
							  $('#update_user_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
							  $.ajax({
								type: "post",
								data: frm.serialize(),
								url: "<?php echo site_url('/');?>forum/update_forum_user_do",
								success: function(data) {
								  
								  $('#update_user_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Update User');
								  $('#msg').html(data);
								  $('#modal-update').modal('hide');
								  window.location = '<?php echo site_url('/');?>forum/users';
								}
							  });
							
						
					}




		function export_report(){

			var btn = $('#export_btn'), frame = $('#export_frame');
			btn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'get',
				url: "<?php echo site_url('/');?>forum/export_users/",
				success: function(data) {
					//cont.html(data).removeClass('loading_img');
					btn.html('<i class="icon-share icon-white"></i> Export Report');
					frame.attr('src','<?php echo site_url('/');?>forum/export_users/');
				}
			});


		}

	</script>
</body>
</html>