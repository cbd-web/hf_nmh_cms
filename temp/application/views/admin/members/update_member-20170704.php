<?php $this->load->view('admin/inc/header');
//Assign the type id

if($member_type == 'subscribers'){
	
	$id = $sid;
	
}else{
	
	$id = $mid;
	
}

?>

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
						<a href="<?php echo site_url('/');?>admin/<?php echo $member_type;?>/"><?php echo ucwords($member_type). $id;?></a><span class="divider">/</span>
					</li>
                    <li>
						Update <?php echo ucwords($member_type);?>: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update <?php echo ucwords($member_type);?>: <?php echo $name;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="<?php echo $member_type;?>-update" name="<?php echo $member_type;?>-update" method="post" action="<?php echo site_url('/');?>admin/update_member_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="id"  value="<?php if(isset($id)){echo $id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                            <input type="hidden" name="member_type" id="member_type"  value="<?php echo $member_type;?>">
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

<!--                                           <div class="control-group">
                                            <label class="control-label" for="pwd">Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="pwd" name="pwd" placeholder="<?php echo ucwords($member_type);?> Password" value="<?php if(isset($email)){echo $email;}?>">  
                                            </div>
                                          </div> -->
                            				
<!--                                         <div class="control-group">
                                            <label class="control-label" for="type">Type</label>
                                            <div class="controls">
                                                  
                                                    <?php //$this->admin_model->get_subscriber_types($type_id); ?>
                                                    

                                            </div>
                                          </div>-->
                                          
                            				
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
                                                  
                                                    <select class="span6" id="region" name="region">
                                                        <option value="Caprivi" <?php if($region == 'Caprivi'){echo 'selected';}?>>Caprivi</option>
                                                        <option value="Erongo" <?php if($region == 'Erongo'){echo 'selected';}?>>Erongo</option>
                                                        <option value="Hardap" <?php if($region == 'Hardap'){echo 'selected';}?>>Hardap</option>
                                                        <option value="Karas" <?php if($region == 'Karas'){echo 'selected';}?>>Karas</option>
                                                        <option value="Khomas" <?php if($region == 'Khomas'){echo 'selected';}?>>Khomas</option>
                                                        <option value="Kunene" <?php if($region == 'Kunene'){echo 'selected';}?>>Kunene</option>
                                                        <option value="Ohangwena" <?php if($region == 'Ohangwena'){echo 'selected';}?>>Ohangwena</option>
                                                        <option value="Okavango" <?php if($region == 'Okavango'){echo 'selected';}?>>Okavango</option>
                                                        <option value="Omaheke" <?php if($region == 'Omaheke'){echo 'selected';}?>>Omaheke</option>
                                                        <option value="Omusati" <?php if($region == 'Omusati'){echo 'selected';}?>>Omusati</option>
                                                        <option value="Oshana" <?php if($region == 'Oshana'){echo 'selected';}?>>Oshana</option>
                                                        <option value="Oshikoto" <?php if($region == 'Oshikoto'){echo 'selected';}?>>Oshikoto</option>
                                                        <option value="Otjozondjupa" <?php if($region == 'Otjozondjupa'){echo 'selected';}?>>Otjozondjupa</option>
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
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update <?php echo ucwords($member_type);?></button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
				
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Subscriber Types</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					
						<form id="type-update" name="type-update" method="post" action="<?php echo site_url('/');?>admin/update_subscriber_types_do" class="form-horizontal">
                  	  	<input type="hidden" name="id"  value="<?php if(isset($id)){echo $id;}?>">
						<?php echo $this->members_model->get_subscriber_cats($id) ?>
						<hr>
						<button type="submit" class="btn btn-inverse btn" id="sbutt">Update Subscriber Types</button>
						</form>
                        <div id="result_msg2"></div>                 
                  </div>
				</div>


                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Update <?php echo ucwords($member_type);?> Password</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

						<form id="pwd-update" name="pwd-update" method="post" action="<?php echo site_url('/');?>admin/update_subscriber_pwd_do" class="form-horizontal">
                  	  	<input type="hidden" name="id"  value="<?php if(isset($id)){echo $id;}?>">

						<div class="control-group">
							<input type="password" class="span10" id="pwd_new" name="pwd_new" placeholder="<?php echo ucwords($member_type);?> Password">
						</div>

						<div class="control-group">
							<input type="password" class="span10" id="pwd_confirm" name="pwd_confirm" placeholder="<?php echo ucwords($member_type);?> Confirm Password">
						</div>
						<hr>
						<button type="submit" class="btn btn-inverse btn" id="btn_pwd">Update Subscriber Password</button>
						</form>
                        <div id="result_msg3"></div>                 
                  </div>
				</div>				
				
				
				
                <div class="box span4">
					<!--<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span><?php echo ucwords($member_type);?> Documents</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							List of documents attached to <em><?php if(isset($title)){echo $title;} ?></em>.</p>
                        <div id="member_docs">   
                            <?php //$this->admin_model->get_member_docs($member_id);?>
                        </div>
                        <div id="uploader" style="display:none">
                            <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
                        </div>
		             	 
                        <div id="doc_msg"></div>
                        <a onClick="$('#uploader').slideToggle();" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add Documents</a>                  
                  </div>-->
				</div>
                
                
			</div>   
			
			<hr>
			
			<div class="row-fluid">
				
				
				
			</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		 <div class="modal hide fade" id="modal-doc-delete">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Delete Document</h3>
			</div>
			<div class="modal-body">
				<p>The document will be removed from the <?php echo ucwords($member_type);?>. This process is not reversible.</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Delete Document</a>
			</div>
		</div>
        
        
        <div class="modal hide fade" id="modal-doc-update">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Update Document</h3>
			</div>
			<div class="modal-body loading" id="doc_update_body">
				 
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
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
	
	
	$('#sbutt').bind('click' ,function(e) {
			
		e.preventDefault();
		
			var frm = $('#type-update');
			//frm.submit();
			$('#sbutt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_subscriber_types_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg2').html(data);
					 $('#sbutt').html('Update Subscriber Types');
					
				}
			});			

	});


	//UPDATE SUBSCRIBER PASSWORD
	$('#btn_pwd').bind('click' ,function(e) {
			
		e.preventDefault();
		
			var frm = $('#pwd-update');
			//frm.submit();
			$('#btn_pwd').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_subscriber_pwd_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg3').html(data);
					 $('#btn_pwd').html('Update Subscriber Password');
					
				}
			});

	});	
	
	
	
	
	$('#butt').bind('click' ,function(e) {
	
		
		e.preventDefault();
		//Validate
		//if($('#name').val().length == 0){
//				
//				$('#name').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a member title"});
//				$('#name').popover('show');
//				$('#name').focus();
		
		//}else if($('#redactor_content').val() == 0){
//	
//				$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
//				$('#redactor_content_msg').popover('show');
//				$('#redactor_content_msg').focus();		
					
			
		//}else{
	
			submit_form();
			
		//}
	});
	
	$('div.btn-group button').live('click', function(){
		
		$('#status').attr('value', $(this).html());
	});
	
	function submit_form(){
			
			var frm = $('#<?php echo $member_type;?>-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_member_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update <?php echo ucwords($member_type);?>');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The member has not been saved.'; 
			
		 }
		 
	};
	$('input').change(function() {

	  $('#autosave').val('false');
	});
	$('.redactor_box').live('click', function() {

	  $('#autosave').val('false');
	});
	
	
	
	</script>
</body>
</html>