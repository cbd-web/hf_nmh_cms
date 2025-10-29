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
						<a href="<?php echo site_url('/');?>publication/publications/">Publications</a><span class="divider">/</span>
					</li>
                    <li>
						Add Publication
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Publications</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="pub-add" name="pub-add" method="post" action="<?php echo site_url('/');?>publication/add_publication_do" class="form-horizontal">
                             <fieldset>
    
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Publication Title" value="">
                                            </div>
                                          </div>
                             			  <div class="control-group">
											 <label class="control-label" for="pub_date">Issue Date</label>
											<div class="controls">
													 <div class="input-append date" id="dob" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
													  <input type="text"  name="issue_date" id="issue_date" value="<?php echo '1985-10-19'; ?>" readonly>
													  <span class="add-on"><i class="icon-calendar"></i></span>
													</div> 
													<span class="help-block" style="font-size:11px">Select the date the post is published</span>
											</div> 
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Post URL Slug eg: /about-us" value="">  
                                            </div>
                                          </div>
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Publication Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
                                                </div>
                                           </div>
                                         
                                               <div class="control-group">
                                                   <label class="control-label" for="metaT">Meta Title:</label>
                                                    <div class="controls">
                                                        <textarea name="metaT" style="display:block" class="span6"></textarea>
                                                        <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                                     </div>
                                               </div>
                                          
                                           
                                            
                                             <div class="control-group">
                                                    <label class="control-label" for="metaD">Meta Description:</label>
                                                    <div class="controls">
                                                         <textarea name="metaD" style="display:block" class="span6"></textarea>
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Publication</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
 
                
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
	<script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
	
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
	
	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a publication title"});
				$('#title').popover('show');
				$('#title').focus();
		
/*		}else if($('#redactor_content').val() == 0){
	
				$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
				$('#redactor_content_msg').popover('show');
				$('#redactor_content_msg').focus();	*/	
			
		}else{
	
			submit_form();
			
		}
	});
	
	
	function submit_form(){
			
			var frm = $('#pub-add');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'publication/add_publication_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Publication');
					
				}
			});	
	
	}
	
	</script>
</body>
</html>