<?php $this->load->view('admin/inc/header'); ?>	
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
						<a href="<?php echo site_url('/');?>magnet_members/members">Magnet Members</a> <span class="divider">/</span>
					</li>
					<li>
						<?php echo $name.' ',$sname; ?>
					</li>					
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Member Details</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                          <form action="<?php echo site_url('/')?>premier_members/update_member_do" method="post" enctype="multipart/form-data" name="update-member" id="update-member" class="form-horizontal" >
							<input type="hidden" name="member_id"  value="<?php if(isset($member_id)){echo $member_id;}?>">
							<input type="hidden" name="autosave" id="autosave"  value="true">

							<fieldset>
                                <div class="control-group">
									<label class="control-label" for="name">First Name</label>
									<div class="controls">
									<input type="text" id="name" name="name" placeholder="First Name" value="<?php echo $name; ?>" class="span6" >
									</div>
                                </div>
								
                                <div class="control-group">
									<label class="control-label" for="surname">Surname</label>
									<div class="controls">
									<input type="text" id="surname" name="surname" placeholder="Surname" value="<?php echo $sname; ?>" class="span6" >
									</div>
                                </div>								
								
                                <div class="control-group">
									<label class="control-label" for="company">Company</label>
									<div class="controls">								
                               	 		<input type="text" id="company" name="company" placeholder="Company" value="<?php echo $company; ?>" class="span6">
									</div>
                                </div>
                                <div class="control-group">
									<label class="control-label" for="tel">Telephone</label>
									<div class="controls">									
                                		<input type="text" id="tel" name="tel" placeholder="Telephone" value="<?php echo $phone; ?>" class="span6">
									</div>
                                </div>																												
                                <div class="control-group">
									<label class="control-label" for="email">Email</label>
									<div class="controls">									
                               		 <input type="text" id="email" name="email" placeholder="Email" value="<?php echo $email; ?>" class="span6">
									</div>
                                </div>
                                <div class="control-group">
									<label class="control-label" for="country">Country</label>
									<div class="controls">									
                                		<input type="text" id="country" name="country" placeholder="Country" value="<?php echo $country; ?>" class="span6">
									</div>
                                </div> 
                                <div class="control-group">
									<label class="control-label" for="city">City</label>
									<div class="controls">								
                               		 <input type="text" id="city" name="city" placeholder="City" value="<?php echo $city; ?>" class="span6">
									</div>
                                </div>
								<div class="control-group">
									<label class="control-label" for="city">Nationality</label>
									<div class="controls">
										<input type="text" id="type" name="type" placeholder="Nationality" value="<?php echo $type; ?>" class="span6">
									</div>
								</div>

															
                                <div class="control-group">
								<div id="result_msg"></div>
                                <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Member</button>
                                </div>	
                             </fieldset>   
                            </form>							
						<hr>
                  </div>
				</div>
				

				
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Update Member Password</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
										
						<div class="alert alert-success" id="result_msg" style="display:none"></div>
						<a href="#modal-new-pass" role="button" class="btn btn-inverse" data-toggle="modal"><i class="icon-lock icon-white"></i> New Password</a>
						
						<div class="clearfix" style="height:20px;">&nbsp;</div>	
								
					</div>
				</div><!--/span-->
									
				
			</div>

			
			<hr>

			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		
        
        <div class="modal hide fade" id="modal-new-pass">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Update Member Password</h3>
          </div>
          <div class="modal-body">
			  <form class="form-signin" id="change-password" method="post" action="<?php echo site_url('/');?>magnet_members/update_password">
				<input name="id" type="hidden" value="<?php echo $subscriber_id; ?>">
				<input type="password" class="input-block-level" name="pass" id="pass" placeholder="Enter Password">
				<div class="alert alert-warning" id="pass-div" style="display:none"></div>
				<input type="password" class="input-block-level" name="pass2" id="pass2" placeholder="Enter Password Again">
				<div class="alert alert-warning" id="pass2-div" style="display:none"></div>
				<div><input type="checkbox" name="send_user" value="true">Email user details?</div>
				<button class="btn btn-inverse pull-right" type="submit" id="passbutt"><i class="icon-lock icon-white"></i> Update Password</button>
				<div class="alert alert-success" id="message-div" style="display:none"></div>
				<div class="clearfix" style="height:20px;">&nbsp;</div>
			  </form>
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-new-pass').modal('hide');" class="btn">Close</a>
          </div>
        </div>
 
        <div class="modal hide fade" id="modal-order-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Entry</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-order-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Entry</a>
          </div>
        </div> 
 
        
        <div class="clearfix"></div>
		
		
		
		
			<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
	
    
	<script type="text/javascript">


		$('#butt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#name').val().length == 0){
					
					$('#name').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a member name"});
					$('#name').popover('show');
					$('#name').focus();
			
	/*		}else if($('#redactor_content').val() == 0){
		
					$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
					$('#redactor_content_msg').popover('show');
					$('#redactor_content_msg').focus();	*/		
				
			}else{
	
				submit_form();
				
			}
		});




		$('#passbutt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#pass').val().length == 0){
					
					$('#pass-div').html("Please supply us with a password");
					$('#pass-div').show('slow');
					$('#pass-div').focus();
					
					var val = 'false'
			} else {
				
				var val = 'true';
				$('#pass-div').hide('slow');
				
			}
			
			if($('#pass2').val() == 0){
		
					$('#pass2-div').html("Please supply us with the password again");
					$('#pass2-div').show('slow');
					$('#pass2-div').focus();	
					
					var val2 = 'false';
					
				
			} else {
				
				var val2 = 'true';
				$('#pass2-div').hide('slow');
				
			}
			
			if (val == 'true' && val2 == 'true' ) {
				
				$('#pass-div').hide('slow');
				$('#pass2-div').hide('slow');
				
				var pass1 = $('#pass').val();
				var pass2 = $('#pass2').val();
				
				if(pass1 != pass2) 
				{ 
				
					$('#pass2-div').html("The Passwords don not match. Please try again"); 
					$('#pass2-div').show('slow');
				
				} else { 
				
					update_password_submit();
				
				}
				

				
			}
		});
		

		function submit_form(){
				
				var frm = $('#update-member');
				
				$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					//data: frm.serialize()+'&content2='+content,
					data: frm.serialize(),
					url: '<?php echo site_url('/').'magnet_members/update_member_do';?>' ,
					success: function (dataresult) {
						 $('#autosave').val('true');
						 $('#result_msg').html(dataresult);
						 $('#butt').html('Update Member');
						 //$('#test_msg').append(frm.serialize());
					}
				});	
		
		}
		


		function update_password_submit(){
				
				var frm = $('#change-password');
				
				$('#passbutt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '<?php echo site_url('/').'magnet_members/update_password';?>' ,
					success: function (dataresult) {
						 $('#message-div').html(dataresult);
						 $('#passbutt').html('<i class="icon-lock icon-white"></i> Update Password');
						 
						 if(dataresult=='success') {
							 $('#message-div').html("Password Updated!");
							 $('#modal-new-pass').modal('hide');
							 $('#result_msg').html('<button type="button" class="close" data-dismiss="alert">&times;</button>Password Updated!');
							 
						 } else {
							
							$('#pass2-div').html("An Error Ocurred. Please try again.");
							  
							 
						 }
						 
						 //$('#test_msg').append(frm.serialize());
					}
				});	
		
		}

		function send_member_details(){
			
			$('#sendbutt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Sending...');
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/');?>magnet_members/send_details/<?php echo $subscriber_id; ?>',
				success: function (data) {
					 
					$('#result_msg').html('<button type="button" class="close" data-dismiss="alert">&times;</button>Member Details Sent!');
					$('#result_msg').show('slow');
					$('#sendbutt').html('<i class="icon-envelope icon-white"></i> Send Member Details');
				}
			});	
			  
						
		}


	</script>		
	 
</body>
</html>