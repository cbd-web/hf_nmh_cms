<?php $this->load->view('admin/inc/header');
//Assign the type id

	

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
						<a href="<?php echo site_url('/');?>admin/marathon_subscribers/">Subscribers List</a><span class="divider">/</span>
					</li>
                    <li>
						Update <?php echo $ref_no;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Subscriber - Ref No: <?php echo $ref_no;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="<?php echo $member_type;?>-update" name="<?php echo $member_type;?>-update" method="post" action="<?php echo site_url('/');?>admin/update_member_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="id"  value="<?php echo $subscriber_id; ?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
											
										<h4>Race Details</h4>
										
                                          <div class="control-group">
                                            <label class="control-label" for="title">Distance</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="distance" name="distance" placeholder="Distance" value="<?php if(isset($distance)){echo $distance;}?>">
                                            </div>
                                          </div>
      
                                 		 <div class="control-group">
                                            <label class="control-label" for="title">Category</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="category" name="category" placeholder="Category" value="<?php if(isset($category)){echo $category;}?>">
                                            </div>
                                          </div>
										  
                                 		 <div class="control-group">
                                            <label class="control-label" for="title">Age at Race</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="age" name="age" placeholder="Age at Race" value="<?php if(isset($age)){echo $age;}?>">
                                            </div>
                                          </div>

                                 		 <div class="control-group">
                                            <label class="control-label" for="title">T-shirt Size</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="shirt" name="shirt" placeholder="T-shirt Size" value="<?php if(isset($tshirt)){echo $tshirt;}?>">
                                            </div>
                                          </div>											  
										  											  											
											
										<hr>
										<h4>Member Details</h4>
											
                                          <div class="control-group">
                                            <label class="control-label" for="title">Name</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="name" name="name" placeholder="Name" value="<?php if(isset($name)){echo $name;}?>">
                                            </div>
                                          </div>
      
                                 		 <div class="control-group">
                                            <label class="control-label" for="title">Gender</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="gender" name="gender" placeholder="Gender" value="<?php if(isset($gender)){echo $gender;}?>">
                                            </div>
                                          </div>
										  
                                 		 <div class="control-group">
                                            <label class="control-label" for="title">Date of Birth</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="dob" name="dob" placeholder="Date of Birth" value="<?php if(isset($dob)){echo $dob;}?>">
                                            </div>
                                          </div>										  
                                        
                                          <div class="control-group">
                                            <label class="control-label" for="email">Email</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>">  
                                            </div>
                                          </div>
                            				
                                         <div class="control-group">
                                            <label class="control-label" for="phone">Phone</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="phone" name="phone" placeholder="Phone" value="<?php if(isset($phone)){echo $phone;}?>">  
                                            </div>
                                          </div>
                                                                                 
                                          
                                         <div class="control-group">
                                            <label class="control-label" for="region">Country</label>
                                            <div class="controls">
                                                  <input type="text" class="span6" id="country" name="country" placeholder="Country" value="<?php if(isset($country)){echo $country;}?>"> 
                                            </div>
                                          </div> 
										  
                                         <div class="control-group">
                                            <label class="control-label" for="region">Region</label>
                                            <div class="controls">
                                                  <input type="text" class="span6" id="region" name="region" placeholder="Region" value="<?php if(isset($region)){echo $region;}?>"> 
                                            </div>
                                          </div>                                           
                                          
                                         <div class="control-group">
                                            <label class="control-label" for="club">Club</label>
                                            <div class="controls">
                                                  <input type="text" class="span6" id="club" name="club" placeholder="Club" value="<?php if(isset($club)){echo $club;}?>"> 
                                            </div>
                                          </div>
										  
                                         <div class="control-group">
                                            <label class="control-label" for="club">School</label>
                                            <div class="controls">
                                                  <input type="text" class="span6" id="school" name="school" placeholder="School" value="<?php if(isset($school)){echo $school;}?>"> 
                                            </div>
                                          </div> 										  										  
										  
                                         <div class="control-group">
                                            <label class="control-label" for="city">City/Town</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="city" name="city" placeholder="City" value="<?php if(isset($city)){echo $city;}?>">  
                                            </div>
                                          </div>                                             
                                          
       
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update <?php echo ucwords($member_type);?></button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
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
				url: '<?php echo site_url('/').'admin/update_marathon_member_do';?>' ,
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