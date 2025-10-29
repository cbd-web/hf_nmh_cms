<?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>admin_src/css/datepicker.css" rel="stylesheet">
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
						<a href="<?php echo site_url('/');?>admin/<?php echo $member_type;?>/"><?php echo $member_type;?></a><span class="divider">/</span>
					</li>
                    <li>
						Add New <?php echo ucwords($member_type);?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New <?php echo ucwords($member_type);?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="<?php echo $member_type;?>-update" name="<?php echo $member_type;?>-update" method="post" action="<?php echo site_url('/');?>admin/add_member_do" class="form-horizontal">
                                                    <fieldset>
    										<input type="hidden" name="<?php echo $member_type;?>_id"  value="<?php if(isset($id)){echo $id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="member_type" id="member_type"  value="<?php echo $member_type;?>">
                                          
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="name" name="name" placeholder="<?php echo ucwords($member_type);?> Name" value="<?php if(isset($name)){echo $name;}?>">
                                            </div>
                                          </div>
                                         <div class="control-group">
                                            <label class="control-label" for="abreviation">Abreviation</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="abreviation" name="abreviation" placeholder="<?php echo ucwords($member_type);?> Abreviation" value="<?php if(isset($abreviation)){echo $abreviation;}?>">  
                                            </div>
                                          </div>
                                        
                           				 <div class="control-group">
                                            <label class="control-label" for="title">Contact</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="contact" name="contact" placeholder="<?php echo ucwords($member_type);?> Contact" value="<?php if(isset($contact)){echo $contact;}?>">
                            
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="email" name="email" placeholder="<?php echo ucwords($member_type);?> Email" value="<?php if(isset($email)){echo $email;}?>">  
                                            </div>
                                          </div>
                            				
                                         <div class="control-group">
                                            <label class="control-label" for="type">Type</label>
                                            <div class="controls">
                                                 <?php $this->admin_model->get_subscriber_types($type = '');?>
                                            </div>
                                          </div>
                                          
                            				
                                         <div class="control-group">
                                            <label class="control-label" for="phone">Phone</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="phone" name="phone" placeholder="<?php echo ucwords($member_type);?> Phone" value="<?php if(isset($phone)){echo $phone;}?>">  
                                            </div>
                                          </div>
                                          
                                         <div class="control-group">
                                            <label class="control-label" for="fax">Fax</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="fax" name="fax" placeholder="<?php echo ucwords($member_type);?> Fax" value="<?php if(isset($fax)){echo $fax;}?>">  
                                            </div>
                                          </div>                                          
                                          
                                         <div class="control-group">
                                            <label class="control-label" for="region">Region</label>
                                            <div class="controls">
                                                    
                                                    <select  class="span6" id="region" name="region">
                                                        <option value="Caprivi">Caprivi</option>
                                                        <option value="Erongo">Erongo</option>
                                                        <option value="Hardap">Hardap</option>
                                                        <option value="Karas">Karas</option>
                                                        <option value="Khomas">Khomas</option>
                                                        <option value="Kunene">Kunene</option>
                                                        <option value="Ohangwena">Ohangwena</option>
                                                        <option value="Okavango">Okavango</option>
                                                        <option value="Omaheke">Omaheke</option>
                                                        <option value="Omusati">Omusati</option>
                                                        <option value="Oshana">Oshana</option>
                                                        <option value="Oshikoto">Oshikoto</option>
                                                        <option value="Otjozondjupa">Otjozondjupa</option>
                                                    </select>  
                                            </div>
                                          </div>                                           
                                          
                                         <div class="control-group">
                                            <label class="control-label" for="city">City</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="city" name="city" placeholder="City" value="<?php if(isset($city)){echo $city;}?>">  
                                            </div>
                                          </div>                                             
                                          
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content"><?php echo ucwords($member_type);?> Address:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" name="address" style="display:block"><?php if(isset($address)){echo $address;}?></textarea>
                                                </div>
                                           </div>
                                         
                                         <div class="control-group">
                                            <label class="control-label" for="website">Website</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="website" name="website" placeholder="Website" value="<?php if(isset($website)){echo $website;}?>">  
                                            </div>
                                          </div> 
                                         
                                            <!-- <div class="control-group">
                                                    <label class="control-label" for="pub_date">Publish date</label>
                                                    <div class="controls">
                                                             <div class="input-append date" id="dob" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                                              <input type="text"  name="pub_date" id="pub_date" value="<?php if (isset($review)){echo date('Y-m-d',strtotime($review));}else{ echo '1985-10-19';}?>" readonly>
                                                              <span class="add-on"><i class="icon-calendar"></i></span>
                                                            </div> 
                                                            <span class="help-block" style="font-size:11px">Select the date the member is published</span>
                                                    </div> 
                                               </div>-->
       
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add <?php echo ucwords($member_type);?></button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               
                
                
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
		
        <div class="clearfix"></div>
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
	
	$(document).ready(function(){
		/* ---------- Text Editor ---------- */
		$('#redactor_content').redactor({ 	
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video', 'table','|',
					 'alignment', '|', 'horizontalrule']
		});
		
		$('#dob').datepicker()	
	
	});
	
	$('#butt').bind('click', function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#name').val().length == 0){
				
				$('#name').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a <?php echo $type;?> title"});
				$('#name').popover('show');
				$('#name').focus();
		
		//}else if($('#redactor_content').val() == 0){
//	
//				$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
//				$('#redactor_content_msg').popover('show');
//				$('#redactor_content_msg').focus();		
//			
			
		}else{
	
			submit_form();
			
		}
	});
	
	
	function submit_form(){
			
			var frm = $('#<?php echo $member_type;?>-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/add_member_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add <?php echo ucwords($member_type);?>');
					
				}
			});	
	
	}
	
	</script>
</body>
</html>