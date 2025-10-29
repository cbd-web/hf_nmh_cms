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
						<a href="#">Add New Account</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Account</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	      <p>
							<form id="settings-update" name="settings-update" method="post" action="<?php echo site_url('/');?>super_admin/add_account_do" class="form-horizontal">
                             <fieldset class="well"><h4>Website Details</h4>
    										
                                          <input type="hidden" name="set_id"  value="<?php if(isset($set_id)){echo $set_id;}?>">  
                                          <div class="control-group">
                                            <label class="control-label" for="title">Website Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Website title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>
                                          
                                          <div class="control-group">
                                                    <label class="control-label" for="metaD">Description:</label>
                                                    <div class="controls">
                                                         <textarea name="metaD" style="display:block" class="span6"><?php if(isset($description)){echo $description;}?></textarea>
                                                         <span class="help-block" style="font-size:11px">A quick summary of the company. No more than 160 characters</span>
                                                    </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="url">Website URL</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="url" name="url" placeholder="http://yourdomain.com" value="<?php if(isset($url)){echo $url;}?>">
                                                    <span class="help-block" style="font-size:11px">the email address to be used for enquiries</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="contact_email">Contact Us Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="contact_email" name="contact_email" placeholder="you@yourdomain.com" value="<?php if(isset($contact_email)){echo $contact_email;}?>">
                                                    <span class="help-block" style="font-size:11px">the email address to be used for enquiries</span>
                                            </div>
                                          </div>
                           				 <div class="control-group">
                                            <label class="control-label" for="ga_id">Google Analytics Profile ID</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="ga_id" name="ga_id" placeholder="1811162" value="<?php if(isset($GA_profile)){echo $GA_profile;}?>">
                                                    <span class="help-block" style="font-size:11px">the google analytics profile id for the domain</span>
                                            </div>
                                          </div>
                                           <div class="control-group">
                                            <label class="control-label" for="ga_id">Google Analytics Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="ga_email" name="ga_email" placeholder="ypu@gmail.com" value="<?php if(isset($GA_email)){echo $GA_email;}?>">
                                                    <span class="help-block" style="font-size:11px">the google analytics email for the account to which the domain is linked</span>
                                            </div>
                                          </div>
                            			  <div class="control-group">
                                            <label class="control-label" for="ga_id">Google Analytics Password</label>
                                            <div class="controls">
                                                    <input type="password" class="span6" id="ga_pass" name="ga_pass" placeholder="" value="<?php if(isset($GA_pass)){echo $GA_pass;}?>">
                                                    <span class="help-block" style="font-size:11px">the google analytics password</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                                <label class="control-label" for="redactor_content">Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                                                </div>
                                           </div>
                                           
                               </fieldset>
                               
                                <fieldset class="well"><h4>Account details</h4>
    										
        
                                          <div class="control-group">
                                            <label class="control-label" for="acc_email">Login Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="acc_email" name="acc_email" placeholder="you@yourdomain.com" value="<?php if(isset($acc_email)){echo $acc_email;}?>">
                                                    <span class="help-block" style="font-size:11px">the email address to be used to login to the CMS</span>
                                            </div>
                                          </div>
                           				
                            			  <div class="control-group">
                                            <label class="control-label" for="acc_pass">Password</label>
                                            <div class="controls">
                                                    <input type="password" class="span6" id="acc_pass" name="acc_pass" placeholder="" value="">
                                                    <span class="help-block" style="font-size:11px">the password to login to the CMS</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="bus_id">My Namibia Business ID</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="bus_id" name="bus_id" placeholder="My Namibia Business ID" value="<?php if(isset($bus_id)){echo $bus_id;}?>">
                                            </div>
                                          </div>
  
    
                               </fieldset>
                               
                                   <fieldset class="well"><h4>Package details</h4>

                                          <div class="control-group">
                                            <label class="control-label" for="components">Components</label>
                                            <div class="controls">
                                                   
                                                    <select multiple="multiple"  class="span6" size="8" id="components" name="components">
                                                      <option value="analytics">Analytics</option>
                                                      <option value="email_marketing">Email marketing</option>
                                                      <option value="projects">Projects</option>
                                                      <option value="products">Products</option>
                                                      <option value="events">Events</option>
                                                    </select>
                                            </div>
                                          </div>
                                         
                                           <div class="control-group">
                                            <label class="control-label" for="languages">Additional Languages</label>
                                            <div class="controls">
                                                
                                                    <select multiple="multiple"  class="span6" size="4"  id="languages" name="languages">
                                                      <option value="default" selected>Default</option>
                                                      <option value="german">German</option>
                                                      <option value="french">French</option>
                                                      <option value="italian">Italian</option>
                                                      <option value="spanish">Spanish</option>
                                                      
                                                    </select>
                                            </div>
                                          </div>   
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add New Account</button>
                                           
                               </fieldset>  
                                
                             </form>
		             	</p>	
                                        
                  </div>
				</div>

                
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
                    
                      <p><a title="Update your settings" rel="tooltip" class="btn btn-inverse btn disabled" >Add New Account</a> - Add New Account</p>
                     
                      
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
				
		
        
        <div class="clearfix"></div>
		
				
	
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
	<script type="text/javascript">
			/* ---------- Text Editor ---------- */
	$('#redactor_content').redactor({ 	
				imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
				buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
				'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
				'video', 'table','|',
				 'alignment', '|', 'horizontalrule']
	});
	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true, title:"Title Required", content:"Please supply us with a post title"});
				$('#title').popover('show');
				$('#title').focus();
		
		
		}else{
	
			submit_form();
			
		}
	});
	
	$('div.btn-group button').live('click', function(){
		
		$('#status').attr('value', $(this).html());
	});
	
	function submit_form(){
			
			var frm = $('#settings-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_settings_do';?>' ,
				success: function (data) {
					 
					 $('#result_msg').html(data);
					 $('#butt').html('Add New Account');
					
				}
			});	
	
	}
	</script>
</body>
</html>