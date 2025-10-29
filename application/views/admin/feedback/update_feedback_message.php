<?php 
  
$this->load->view('admin/inc/header');

$role = $this->session->userdata('role');

switch($status) {
	case 'open':
	$status_icn = '<span class="label label-important label-large">open</span>';
	break;
	case 'review':
	$status_icn = '<span class="label label-warning">review</span>';
	break;	
	case 'closure':
	$status_icn = '<span class="label label-warning">closure</span>';
	break;		
	case 'closed':
	$status_icn = '<span class="label label-success">closed</span>';
	break;					
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
						<a href="<?php echo site_url('/');?>admin/feedback/">Feedback</a><span class="divider">/</span>
					</li>
                    <li>
						Manage Process: <?php echo $ref_no;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Post: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					<div class="hero-unit">
						<?php echo $status_icn; ?><br />
						<strong>Ref no: </strong><?php echo $ref_no; ?><br />
						<strong>Sent on: </strong><?php echo date("d-m-y g:i a",strtotime($list_date)); ?><br />
						<strong>From: </strong><?php echo $fname . ' ' . $sname; ?><br />
						<strong>Email: </strong><?php echo $email; ?><br />
						<strong>Cellphone: </strong><?php echo $cellphone; ?><br />
						<strong>Country: </strong><?php echo $country; ?><br />
						<strong>Type: </strong><?php echo ucwords(str_replace("_", " ", $type)) ; ?><br />
						<strong>Topic: </strong><?php echo $topic; ?><br />
						
						
						<strong>Message:</strong>
						<p><?php echo $message; ?></p>	
						<hr />
						<?php echo $this->admin_model->get_feedback_process($msg_id); ?>

						
						
						
					</div>	
                  	  	<p>
							<form id="feedback-update" name="feedback-update" method="post" action="" class="form-horizontal">
                             <fieldset>
								<input type="hidden" name="msg_id"  value="<?php if(isset($msg_id)){echo $msg_id;}?>">
								<input type="hidden" name="autosave" id="autosave"  value="true">
								<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
								<input type="hidden" name="content" id="content"  value="">
								
								<?php if($role == 'feedback_update' || $role == 'feedback_closure') { if($status == 'open') {  ?>

										<label class="control-label" for="update1">Update 1:</label>

											<textarea name="update1" class="span12" style="display:block"></textarea>

								   <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Process</button>
								   <?php } ?>
								   
								  <?php  if($status == 'review') { ?>

										<label class="control-label" for="update2">Update 2:</label>

											<textarea name="update2" class="span12" style="display:block"></textarea>

								   <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Process</button>
								   <?php } } ?> 
								   
								   
								  <?php if($role == 'feedback_closure') { if($status == 'closure') { ?>

									<label class="control-label" for="closure">Closure:</label>

									<textarea name="closure" class="span12" style="display:block"></textarea>

								   <button type="submit" class="btn btn-inverse btn pull-right" id="close">Close Ticket</button>
								   <button type="submit" class="btn btn-inverse btn pull-right" id="butt" style="margin-right:10px;">Update Process</button>
								   
								  <?php }  } ?> 
								   							   							   								   
								  <div id="result_msg"></div>

                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
                
                
                 <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Post Sidebar</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content">
                  	  	<div class="alert">
                        This is the secondary smaller post column. Please select what component you would like to display.
                        </div>
                        <p>
							<!--<a href="#" onClick="$('#gallery_cont').slideToggle();" class="btn "><i class="icon-picture"></i> Gallery</a>
                            <a href="#" class="btn "><i class="icon-envelope"></i> Contact Us</a>-->
		             	</p>                  
                 		
                   </div>       
                  
				</div>
                
                <div class="box span4">
					
				</div>
                
                
                <div class="box span4">
					
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
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
						
		
		$('.redactor_content').redactor({ 	
					fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
					imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video','file', 'table', 'link','|',
					 'alignment', '|', 'horizontalrule'],
					linebreaks: true,
					focus:true,
					plugins: ['fullscreen', 'fontcolor', 'fontsize','fontfamily']
		});
		$('#dob').datepicker()	
	});
		
	
	$('#butt').bind('click' , function(e) {
	

		e.preventDefault();
		//Validate

			submit_form();
			
	});
	
	$('#close').bind('click' , function(e) {
	
		
		e.preventDefault();
		//Validate

			close_form();
			
	});	
	

	
	function submit_form(){
			
			var frm = $('#feedback-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_feedback_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Process');
					 
					 location.reload(true);
					
				}
			});	
	
	}
	
	function close_form(){
			
			var frm = $('#feedback-update');
			//frm.submit();
			$('#close').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/close_feedback_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#close').html('Close Ticket');
					 
					location.reload(true);
				}
			});	
	
	}	
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The entry has not been saved.'; 
			
		 }
		 
	};
	
	$('input').change(function() {

	  $('#autosave').val('false');
	});
	$('.redactor_box').live('click', function() {

	  $('#autosave').val('false');
	});
	

	
	function reply_enquiry(){
			
			console.log('t=yes');
			var frm = $('#sendmail'), btn = $('#send_mail_btn');
			btn.html('<img src="<?php echo base_url('/').'admin_src/img/spinner-mini.gif';?>" /> Sending...');
				$.ajax({
					  method: 'post',
					  cache: false,
					  data: frm.serialize(),
					  url: "<?php echo site_url('/');?>admin/reply_enquiry/",
					  success: function(data) {
						
							$('#reply_msg').html(data);
							btn.html('<i class="icon-envelope"></i> Send');
						 }
					});
	
	
	}
	
	
	
	
	</script>
</body>
</html>