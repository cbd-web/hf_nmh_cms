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
						<a href="#">My Namibia / HAN</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All My Namibia / HAN</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

                           
							<form id="settings-update" name="settings-update" method="post" action="<?php echo site_url('/');?>admin/settings_update_do" class="form-horizontal">
                             <fieldset>
    										
                                          <input type="hidden" name="bus_id"  value="<?php if(isset($ID)){echo $ID;}?>">  
                                          <div class="control-group">
                                            <label class="control-label" for="title">Website Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Website title" value="<?php if(isset($BUSINESS_NAME)){echo $BUSINESS_NAME;}?>">
                                            </div>
                                          </div>

		
                                          <div class="control-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="controls">
                            
                                                     <input type="text" class="span6" id="email" name="email" placeholder="Email" value="<?php if(isset($BUSINESS_EMAIL)){echo $BUSINESS_EMAIL;}?>">
                                                    
                                            </div>
                                          </div>
                                         
                                          <div class="control-group">
                                            <label class="control-label" for="tel">Telephone</label>
                                            <div class="controls">
                                                    <input type="text" id="tel" class="span6" name="tel" placeholder="eg: 061231234" value="<?php if(isset($BUSINESS_TELEPHONE)){echo $BUSINESS_TELEPHONE;}?>">
                                                 
                                            </div>
                                          </div>
                                          
                                          <div class="control-group">
                                            <label class="control-label" for="fax">Fax</label>
                                            <div class="controls">
                            
                                                    <input type="text" id="fax" class="span6" name="fax" placeholder="eg: 061231234" value="<?php if(isset($BUSINESS_FAX)){echo $BUSINESS_FAX;}?>">
                                           
                                            </div>
                                          </div>
                                          
                                         
                                          <div class="control-group">
                                            <label class="control-label" for="cell">Cellphone</label>
                                            <div class="controls">
                            
                                                    <input type="text" id="cell" class="span6" name="cell" placeholder="eg: 0811234567" value="<?php if(isset($BUSINESS_CELLPHONE)){echo $BUSINESS_CELLPHONE;}?>">
                                               
                                            </div>
                                          </div>
                                          
                                          <div class="control-group">
                                            <label class="control-label" for="url">Website</label>
                                            <div class="controls">
                            
                                                    <input type="text" id="url" class="span6" name="url" placeholder="eg: www.example.com.na" value="<?php if(isset($BUSINESS_URL)){echo $BUSINESS_URL;}?>">
                                                
                                            </div>
                                          </div>
                                           
                                            <div class="control-group">
                                            <label class="control-label" for="pobox">PO BOX</label>
                                            <div class="controls">
                            
                                                    <input type="text" id="pobox" class="span6" name="pobox" placeholder="eg: 9012 Windhoek" value="<?php if(isset($BUSINESS_POSTAL_BOX)){echo $BUSINESS_POSTAL_BOX;}?>">
                                               
                                            </div>
                                          </div>
                                          
                                          <div class="control-group">
                                            <label class="control-label" for="address">Physical Address</label>
                                            <div class="controls">
                                                
                                                    <input type="text" id="address" class="span6" name="address" placeholder="eg: 12 Sam Nujoma Drive" value="<?php if(isset($BUSINESS_PHYSICAL_ADDRESS)){echo $BUSINESS_PHYSICAL_ADDRESS;}?>"/>
                                               
                                            </div>
                                          </div>

                                          <div class="control-group">
                                                <label class="control-label" for="redactor_content">Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" name="content" style="display:block"><?php if(isset($BUSINESS_DESCRIPTION)){echo $BUSINESS_DESCRIPTION;}?></textarea>
                                                </div>
                                           </div>
                                              
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update My Namibia / HAN</button>
                                           
                               </fieldset> 
                             </form>
		             		
                                        
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
								   $img = $BUSINESS_LOGO_IMAGE_NAME;
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
                                           <input type="hidden" id="bus_id" name="bus_id" value="<?php echo $ID;?>">
                                            <input type="hidden" id="bus_name" name="bus_name" value="<?php echo $BUSINESS_NAME;?>">
                                
                                           
                                           <div class="row-fluid">
                                               <div style="height:100px;" class="span2">
                                                 
                                                   <img id="avatar" src="<?php echo $fake_file;?>" style="float:left;position:absolute;border:1px solid #333333;width:100px; height:100px" />
                                                   <input type="file" class="" id="userfile" style="display:none" name="userfile"> 
                                                   
                                               </div>
                                               <div class="span8  pull-right"> 
                                                    <a href="javascript:void(0)" class="btn btn-large btn-block" onClick="$('#userfile').click();">Browse</a>
                                                    <button type="submit"  class="btn btn-large btn-block btn-inverse" id="imgbut"><i class="icon-picture icon-white"></i> <?php if($BUSINESS_LOGO_IMAGE_NAME != ''){ echo 'Update Logo';}else{ echo 'Add Logo';} ?></button>
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
                    
                      <p><a title="Update your settings" rel="tooltip" class="btn btn-inverse btn disabled" >Update My Namibia / HAN</a> - Update My Namibia / HAN</p>
                     
                      
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
	$('#butt').bind('click', function(e) {
	
		
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
				url: '<?php echo site_url('/').'admin/update_my_namibia_do';?>' ,
				success: function (data) {
					 
					 $('#result_msg').html(data);
					 $('#butt').html('Update My Namibia / HAN');
					
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