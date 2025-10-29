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
						<a href="#">Settings</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Settings</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	      <p>
							<form id="settings-update" name="settings-update" method="post" action="<?php echo site_url('/');?>admin/update_settings_do" class="form-horizontal">
                             <fieldset>
    										
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
                                                    <input type="text" class="span6" id="ga_id" name="ga_id" placeholder="1811162" value="<?php if(isset($GA_profile)){echo $GA_profile;}?>" readonly>
                                                    <span class="help-block" style="font-size:11px">the google analytics profile id for the domain</span>
                                            </div>
                                          </div>
                                           <div class="control-group">
                                            <label class="control-label" for="ga_id">Google Analytics Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="ga_email" name="ga_email" placeholder="ypu@gmail.com" value="<?php if(isset($GA_email)){echo $GA_email;}?>" readonly>
                                                    <span class="help-block" style="font-size:11px">the google analytics email for the account to which the domain is linked</span>
                                            </div>
                                          </div>
                            			  <div class="control-group">
                                            <label class="control-label" for="ga_id">Google Analytics Password</label>
                                            <div class="controls">
                                                    <input type="password" class="span6" id="ga_pass" name="ga_pass" placeholder="" value="" readonly>
                                                    <span class="help-block" style="font-size:11px">the google analytics password</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                                <label class="control-label" for="redactor_content">Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                                                </div>
                                           </div>
                                         
                                              
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Settings</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>	
                                        
                  </div>
				</div>

                                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Logo</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                                <form action="<?php echo site_url('/')?>members/add_logo/<?php echo $ID;?>" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">  
                                 <fieldset>

                                      <div class="control-group">
                                      <div class="controls">
                                        
                                  <?php 
								  
								   $row = $this->my_namibia_model->get_info(); 
								   $img = $row['BUSINESS_LOGO_IMAGE_NAME'];
								   //Build image string
									$format = substr($img,(strlen($img) - 4),4);
									$str = substr($img,0,(strlen($img) - 4));
									
									if($img != ''){
										
										if(strpos($img,'.') == 0){
								
											$format = '.jpg';
											$fake_file = NA_URL.'img/timbthumb.php?w=200&h=200&src='.NA_URL.'assets/business/photos/'.$img . $format;
											
										}else{
											
											$fake_file = NA_URL.'img/timbthumb.php?w=200&h=200&src='.NA_URL.'assets/business/photos/'.$img;
											
										}
										
									}else{
										
										$fake_file = NA_URL.'img/timbthumb.php?w=200&h=200&src='.NA_URL.'img/bus_blank.png';	
										
									}
								  
								?>
                                           <input type="hidden" id="id" name="id" value="<?php echo $this->session->userdata('id');?>">
                                           <input type="hidden" id="bus_id" name="bus_id" value="<?php echo  $row['ID'];?>">
                                            <input type="hidden" id="bus_name" name="bus_name" value="<?php echo $ $row['BUSINESS_NAME'];?>">
                                
                                           
                                           <div class="row-fluid">
                                               <div style="height:100px;" class="span2">
                                                 
                                                   <img id="avatar" src="<?php echo $fake_file;?>" style="float:left;position:absolute;border:1px solid #333333;width:100px; height:100px" />
                                                   <input type="file" class="" id="userfile" style="display:none" name="userfile"> 
                                                   
                                               </div>
                                               <div class="span8  pull-right"> 
                                                    <a href="javascript:void(0)" class="btn btn-large btn-block" onClick="$('#userfile').click();">Browse</a>
                                                    <button type="submit"  class="btn btn-large btn-block btn-inverse" id="imgbut"><i class="icon-picture icon-white"></i> <?php if( $row['BUSINESS_LOGO_IMAGE_NAME'] != ''){ echo 'Update Logo';}else{ echo 'Add Logo';} ?></button>
                                               </div>
                                            </div>	
                                            
                                        </div>
                                         <div id="avatar_msg"></div>
                                         <div class="progress progress-striped active" id="procover" style="display:none;margin-top:20px">
                                              <div class="bar bar-warning" style="width: 0%;"></div>
                                          </div>
                                        
                                        
                                      </div>
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
                    
                      <p><a title="Update your settings" rel="tooltip" class="btn btn-inverse btn disabled" >Update Settings</a> - Update Settings</p>
                     
                      
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
					 $('#butt').html('Update Settings');
					
				}
			});	
	
	}
	
	$('#imgbut').bind('click', function() {
	
	
		var avataroptions = { 
			target:        '#avatar_msg',
			url:       	   '<?php echo NA_SITE_URL.'members/add_logo_ajax';?>' ,
			beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
			uploadProgress: function(event, position, total, percentComplete) {
								var percentVal = percentComplete + '%';
								probar.width(percentVal)
								
							},
			 complete: function(xhr) {
								procover.hide();
								probar.width('0%');
								 $('#avatar_msg').html(xhr.responseText);
								 $('#imgbut').html('<i class="icon-picture icon-white"></i> Update Logo');
							}				
	
		}; 
	
		var frm = $('#add-img');
		var probar = $('#procover .bar');
		var procover = $('#procover');
	
		$('#imgbut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
		procover.show();
		frm.ajaxForm(avataroptions);
	});
	 
	 function logo_upload_success(url){
		
		$('#avatar').attr('src', url); 
		 
	 }
	
    </script>
</body>
</html>