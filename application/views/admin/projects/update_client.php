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
						<a href="<?php echo site_url('/');?>project/projects/">Projects</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>project/clients/">Clients</a><span class="divider">/</span>
					</li>
                    <li>
						Update Client: <?php echo $client_name; ?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Client: <?php echo $client_name; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="client-update" name="client-update" method="post" action="<?php echo site_url('/');?>project/update_client_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="client_id"  value="<?php if(isset($client_id)){echo $client_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
											  <div class="control-group">
												<label class="control-label" for="title">Client</label>
												<div class="controls">
														<input type="text" class="span6" id="client" name="client" placeholder="Client name" value="<?php if(isset($client_name)){echo $client_name;}?>">
												</div>
											  </div>


                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Product URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="title">Email</label>
											 <div class="controls">
												 <input type="text" class="span6" id="email" name="email" placeholder="Client Email" value="<?php if(isset($email)){echo $email;}?>">
											 </div>
										 </div>
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Client Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                                                </div>
                                           </div>
										   
                                         <div class="control-group">
                                            <label class="control-label" for="url_link">Website URL (http://)</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="link" name="website" placeholder="eg. www.website.com"  value="<?php if(isset($website)){echo $website;}?>">
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="metaD">Meta Description:</label>
											 <div class="controls">
												 <textarea name="metaD" style="display:block" class="span6"><?php if(isset($metaD)){echo $metaD;}?></textarea>
												 <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther project.</span>
											 </div>
										 </div>
                                          
                                          <div id="result_msg"></div>
										  
										  <button type="submit" class="btn btn-inverse btn pull-right" id="butt" style="margin-right:10px;">Update Client</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
                
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->admin_model->get_featured_image('client', $client_id);?>
                        
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
		/* ---------- Text Editor ---------- */
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
	
	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#client').val().length == 0){
				
				$('#client').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Client Name Required", content:"Please supply us with a client name"});
				$('#client').popover('show');
				$('#client').focus();
		
		//}else if($('#redactor_content').val() == 0){
//	
//				$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
//				$('#redactor_content_msg').popover('show');
//				$('#redactor_content_msg').focus();		
					
			
		}else{
	
			submit_form();
			
		}
	});
	
	$('div.btn-group button').live('click', function(){
		
		$('#status').attr('value', $(this).html());
	});
	
	function submit_form(){
			
			var frm = $('#client-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'project/update_client_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Client');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The client has not been saved.';
			
		 }
		 
	};
	$('input').change(function() {

	  $('#autosave').val('false');
	});
	$('.redactor_box').live('click', function() {

	  $('#autosave').val('false');
	});
	
		//Featured image
	$('#imgbut').bind('click', function() {
		
		
		var avataroptions = { 
			target:        '#avatar_msg',
			url:       	   '<?php echo site_url('/').'admin/add_featured_image';?>' ,
			beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
			uploadProgress: function(event, position, total, percentComplete) {
								var percentVal = percentComplete + '%';
								probar.width(percentVal)
								
							},
			 complete: function(xhr) {
								procover.hide();
								probar.width('0%');
								 $('#avatar_msg').html(xhr.responseText);
								 $('#imgbut').html('Update Image');
							}				
	
		}; 
	
		var frm = $('#add-img');
		var probar = $('#procover .bar');
		var procover = $('#procover');
	
		$('#imgbut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
		procover.show();
		frm.ajaxForm(avataroptions);
		$('#autosave').val('true');
	});
		
	
	</script>
</body>
</html>