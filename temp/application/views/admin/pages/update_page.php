<?php $this->load->view('admin/inc/header');


$set = str_getcsv($settings, ",");

$btn_list = '';

if(count($set) > 0){

	

	foreach($set as $row){
		
			
	

			//FRENCH
			if (strpos($row,'french') !== false) {
			
				$btn_list.= '<li id="french-li"><a class="lang-btn" data-language="french" data-id="'.$page_id.'" style="cursor:pointer">French</a></li>';	
				
			}
			
			//RUSSIAN
			if (strpos($row,'russian') !== false) {
			
				$btn_list.= '<li id="russian-li"><a class="lang-btn" data-language="russian" data-id="'.$page_id.'" style="cursor:pointer">Russian</a></li>';	
				
			}
			
			//PORTUGUESE
			if (strpos($row,'portuguese') !== false) {
			
				$btn_list.= '<li id="portuguese-li"><a class="lang-btn" data-language="portuguese" data-id="'.$page_id.'" style="cursor:pointer">Portuguese</a></li>';	
				
			}
			
			//SPANISH
			if (strpos($row,'spanish') !== false) {
			
				$btn_list.= '<li id="spanish-li"><a class="lang-btn" data-language="spanish" data-id="'.$page_id.'" style="cursor:pointer">Spanish</a></li>';	
				
			}	
			
			//GERMAN
			if (strpos($row,'german') !== false) {
			
				$btn_list.= '<li id="german-li"><a class="lang-btn" data-language="german" data-id="'.$page_id.'" style="cursor:pointer">German</a></li>';	
				
			}			
			
														
			
	}
	
	$btn_list.= '<li class="active" id="english-li"><a href="'.current_url().'" class="lang-btn" data-language="english" data-id="'.$page_id.'" style="cursor:pointer">English</a></li>';
}

?>
    <script type='text/javascript' src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery-ui-1.10.3.custom.min.js"></script>

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
						<a href="<?php echo site_url('/');?>admin/pages/">Pages</a><span class="divider">/</span>
					</li>
                    <li>
						Update Page: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
				
			
			
			

			
			<div class="row-fluid sortable">
				
				
				
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Page: <?php echo $title;?></h2>
					</div>
					<div class="box-content">

						<ul class="nav tab-menu nav-tabs">
							<?php echo $btn_list; ?>
						</ul>
											
                  	  	<p>
						<div class="tab-content" id="language-cont">
							<form id="page-update" name="page-update" method="post" action="<?php echo site_url('/');?>admin/update_page_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="page_id"  value="<?php if(isset($page_id)){echo $page_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Page title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="title">Status</label>
                                            <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" class="btn btn-primary<?php if($status == 'draft'){ echo ' active';}?>">Draft</button>
                                                      <button type="button" class="btn btn-primary<?php if($status == 'live'){ echo ' active';}?>">Live</button>
                                                    </div>
                                            </div>
                                          </div>

                           				 <div class="control-group">
                                            <label class="control-label" for="title">Heading</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="heading" name="heading" placeholder="Page Heading" value="<?php if(isset($heading)){echo $heading;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional, give your page a sub heading (h2)</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Page URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>"> 
                                                    <span class="help-block" style="font-size:11px">The URL paramenter. eg: http://www.example.com/about-us</span> 
                                            </div>
                                          </div>
                            
                            										  
										  <?php print $this->admin_model->slct_parent_page_list($page_parent, $page_id); ?>
                            
							
                                       	  <div class="control-group">
                                            <label class="control-label" for="sequence">Sequence:</label>
                                            <div class="controls">
                                                    <input name="page_sequence" type="text" class="span1" id="sequence" value="<?php if(isset($page_sequence)){echo $page_sequence;}?>" size="3" maxlength="3">  
                                            		<span class="help-block" style="font-size:11px">Set the sequence of the page</span>
                                            </div>
                                 		  </div>
											
                                          <?php $this->admin_model->get_page_templates($page_template);?> 
										 
										  
										  <div class="control-group">
											<label class="control-label" for="page_features">Page Features</label>
											  <div class="controls">
													<?php $this->admin_model->get_page_features($page_id);?> 
											  </div>										  
										  </div> 
                                                                        
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Page Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php echo str_replace("cms2.my.na","d3rp5jatom3eyn.cloudfront.net/cms", $body); ?></textarea>
                                                </div>
                                           </div>
										   
										   
                             			  <div class="control-group">
                                            <label class="control-label" for="title">Icon</label>
                                            <div class="controls">
													<textarea name="icon" class="span6" style="display:block"><?php if(isset($icon)){echo $icon;}?></textarea>
                                                    <span class="help-block" style="font-size:11px">Optional (Copy script image script here)</span>
                                            </div>
                                          </div>

                             			  <div class="control-group">
                                            <label class="control-label" for="title">Website URL</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="url" name="url" placeholder="Website URL: eg http://www.test.com" value="<?php if(isset($url)){echo $url;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional</span>
                                            </div>
                                          </div>
										  										   
                             			  <div class="control-group">
                                            <label class="control-label" for="title">Featured Document</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="feat_doc" name="feat_doc" placeholder="Featured Document" value="<?php if(isset($document)){echo $document;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional (Paste direct link to document)</span>
                                            </div>
                                          </div>										   
										   										   
										   
										   
                                         
                                               <div class="control-group">
                                                   <label class="control-label" for="metaT">Meta Title:</label>
                                                    <div class="controls">
                                                        <textarea name="metaT" style="display:block" class="span6"><?php if(isset($metaT)){echo $metaT;}?></textarea>
                                                        <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                                     </div>
                                               </div>
                                          
                                           
                                            
                                             <div class="control-group">
                                                    <label class="control-label" for="metaD">Meta Description:</label>
                                                    <div class="controls">
                                                         <textarea name="metaD" style="display:block" class="span6"><?php if(isset($metaD)){echo $metaD;}?></textarea>
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Page</button>
                                          <a href="<?php echo $this->session->userdata('url');?>/page/<?php echo $slug;?>/" target="_blank" style="margin: 0px 10px" class="btn pull-right btn-inverse"><i class="icon-search icon-white"></i> Preview</a> 
                               </fieldset> 
                             </form>
							 </div>
		             	</p>                                         
                  </div>
				</div>
            </div>
			
			
			<div class="row-fluid sortable">
                 <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Page Sidebar</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content">
                  	  	<div class="alert">
                        This is the secondary smaller page column. Please select what component you would like to display.
                        </div>
                        <p>
							<!--<a href="#" onClick="$('#gallery_cont').slideToggle();" class="btn "><i class="icon-picture"></i> Gallery</a>
                            <a href="#" class="btn "><i class="icon-envelope"></i> Contact Us</a>-->
		             	</p>                  
                 		
                        <div class="box-header">
                            <h2>Gallery</h2>
                            <div class="box-icon">
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            
                            <div id="gallery_images">   
                                <?php
								$this->admin_model->get_all_galleries_select();
								?>
								<div id="gal_box">
								<?php	
								$this->admin_model->get_sidebar_content('page_'.$page_id);
								?>
								</div>
                            </div>
                           
                           
                            <div id="doc_msg"></div>
                         </div>
                         <div class="clearfix" style="height:20px"></div>    
                         <div class="box-header">
                            <h2>Contact Form</h2>
                            <div class="box-icon">
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            <p>
                                Contact Form for <em><?php if(isset($title)){echo $title;} ?></em>.</p>
                 			<p id="test_msg"></p>
                       </div>
 
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
                        
						<?php $this->admin_model->get_featured_image('page', $page_id);?>
                        
                        </p>                  
                  </div>
				</div>
                
                <?php 
				$feature_downloads = $this->admin_model->check_page_feature('downloads', $page_id); 
				$feature_sidebars = $this->admin_model->check_page_feature('sidebars', $page_id); 
				$feature_people = $this->admin_model->check_page_feature('people', $page_id);
				?>

                <div id="people_div" class="box span4  <?php if($feature_people != 'people'){ echo 'hide';};?>">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>People</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                       <form id="people_add" name="people_add" method="post" action="<?php echo site_url('/');?>admin/add_page_people" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="page_id"  value="<?php if(isset($page_id)){echo $page_id;}?>">                         
                            <div class="input-append span12">
							
							<select name="people">
								<?php echo $this->admin_model->get_people_select(); ?>
							</select>
                              <button class="btn btn-inverse btn" id="btn_ppl" onClick="add_people();" type="button"><i class="icon-plus-sign icon-white"></i> Add Person</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form>
						<div id="curr_ppl">
						<?php echo $this->admin_model->get_page_people($page_id); ?>
						</div>                
                  </div>
				</div>

				
                <div id="downloads_div" class="box span4  <?php if($feature_downloads != 'downloads'){ echo 'hide';};?>">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Downloads</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->admin_model->get_downloads('page', $page_id);?>
                        
                        </p>                  
                  </div>
				</div>
				

                <div id="sidebars_div" class="box span4  <?php if($feature_sidebars != 'sidebars'){ echo 'hide';};?>">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Sidebars</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->admin_model->get_page_sidebars('page_side', $page_id);?>
                        
                        </p>                  
                  </div>
				</div>				
				
				
                <div id="business_div" class="box span4 <?php if($page_template != 'My_businesses'){ echo 'hide';};?>">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>My Businesses</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div id="bus_list">
						
						<?php $this->my_namibia_model->get_selected_businesses($page_id); ?>
							
						</div>
						
						<input name="bname" id="bname" type="text" style="width:97%">
						
                  	  	 <div id="my_na_div">
                                
                         </div>                   
                  </div>
				</div>				
				
                
			</div>
           
		   
		   <?php //$this->admin_model->get_language_pages($settings, $page_id);?>
                
               
			
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
		
        <div class="modal hide fade" id="modal-people-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Page Person</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-people-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Day Person</a>
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
	<script type="text/javascript">
	
	var delay = 1000;
	var isLoading = false;
	var isDirty = false;	
	
	
	$(document).ready(function(){

	$(".lang-btn").click(function(){
		
		var lang = $(this).attr('data-language');
		var id = $(this).attr('data-id');
		
		$('#english-li').removeClass("active");
		$('#german-li').removeClass("active");
		$('#russian-li').removeClass("active");
		$('#french-li').removeClass("active");
		$('#portuguese-li').removeClass("active");
			
		
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/get_language_page/'; ?>'+lang+'/'+id ,
				success: function (dataresult) {
					 
					$('#language-cont').html(dataresult);
					
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
					
					$('#'+lang+'-li').addClass("active");				

				}
			});			
		
	});		
						
	
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
		
		$('#dob').datepicker();
		
		$("#bname").keydown(function(){
			isDirty = true;
			reloadSearch();
		 });		
		
			$('#page_sidebars').change(function(){
				
				$("#sidebars_div").toggle(this.checked);
				
			});
			
			$('#page_downloads').change(function(){
				
				$("#downloads_div").toggle(this.checked);
				
			});	
			
			$('#page_people').change(function(){			
				
				$("#people_div").toggle(this.checked);
				
			});								
	
		
		
/*		$('#page_temp_div').on('change', function(){
			
			if($(this).val() == 'downloads'){
				
				$('#downloads_div').slideDown();
				
			}else{
				
				$('#downloads_div').slideUp();
				
			}
			
			if($(this).val() == 'my_businesses'){
				
				$('#business_div').slideDown();
				
			}else{
				
				$('#business_div').slideUp();
				
			}
			
			if($(this).val() == 'sidebars'){
				
				$('#sidebars_div').slideDown();
				
			}else{
				
				$('#sidebars_div').slideUp();
				
			}						
			
		});*/
		
		$('#save_download_btn').bind('click',function(e) {
			
			e.preventDefault();
			var frm = $('#download_frm');
			
			$('#save_download_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/add_downloads';?>' ,
				success: function (dataresult) {
					 
					 $('#result_msg').html(dataresult);
					 $('#save_download_btn').html('<i class="icon-check icon-white"></i> Save Downloads');
					 //$('#test_msg').append(frm.serialize());
				}
			});		
			
		});
		
		
		$('#save_sidebars_btn').bind('click',function(e) {
			
			e.preventDefault();
			var frm = $('#sidebars_frm');
			
			$('#save_sidebars_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/add_page_sidebars';?>' ,
				success: function (dataresult) {
					 
					 $('#result_msg').html(dataresult);
					 $('#save_sidebars_btn').html('<i class="icon-check icon-white"></i> Save Sidebars');
					 //$('#test_msg').append(frm.serialize());
				}
			});		
			
		});		
		

		$('#butt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#title').val().length == 0){
					
					$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a page title"});
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
		
		$('div.btn-group button').live('click', function(){
			
			$('#status').attr('value', $(this).html());
		});
	
		$('#page-update :input').change(function() {
	
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
		
});
		

	
	function submit_form(){
			
			var frm = $('#page-update'), content = $('#redactor_content').text();
			
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_page_do';?>' ,
				success: function (dataresult) {
					 $('#autosave').val('true');
					 $('#result_msg').html(dataresult);
					 $('#butt').html('Update Page');
					 //$('#test_msg').append(frm.serialize());
				}
			});	
	
	}
	
	//IE 9 Fix
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}
	
	
	function attach_gallery(){
			
			var gal_id = $('#gallery_select').val();
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/update_sidebar/page/'.$page_id.'/gallery/';?>'+gal_id ,
				success: function (data) {

					load_images(gal_id);
				}
			});	
	
	}
	
	function remove_gallery(gal_id){
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/remove_sidebar/page/'.$page_id.'/gallery/';?>'+gal_id ,
				success: function (data) {
					
					 $('#gal_box').html(data);
				}
			});	
	
	}
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The page has not been saved.'; 
			
		 }
		 
	};

	
	function load_images(gal_id){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>admin/load_gallery_images/"+gal_id,
			success: function(data) {
			  $('#gal_box').append(data);

			}
		  });			
			
	}
	
	 //Name Search
	 function reloadSearch(){
	
			if(!isLoading){
					var q = $("#bname").val();
						 if($.trim(q).length != 0){
								isLoading = true;
								 var div = $("#my_na_div");
								 div.show();
								 div.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');	
		
								 $.get("<?php echo site_url('/').'admin/get_my_business_name/';?>"+q, function(data) {
									div.html(data);
								  });
								 
								 // enforce the delay
								 setTimeout(function(){
								   isLoading=false;
								   if(isDirty){
									 isDirty = false;
									 reloadSearch();
								   }
								 }, delay);
						
						 }else{
							 
							$("#my_na_div").empty(); 
							 
						 }
			}
		
	}	
	
	function add_business(id){
			
			$('#my_na_bus_id').val(id);
			
			$('#cbus_'+id).hide();
			
			$.ajax({
				type: 'get',
				cache:false,
				url: '<?php echo site_url('/').'admin/add_my_business_name/'.$page_id; ?>/'+id+'/' ,
				success: function (data) {
					 
					 $('#my_msg').html(data);
					 reload_businesses();
					
					
					//console.log('hello');
				}
			});	
	
	}
	
	function reload_businesses(){
			
			$.ajax({
				type: 'get',
				cache:false,
				url: '<?php echo site_url('/').'admin/reload_businesses/'.$page_id; ?>',
				success: function (data) {
					 
					 $('#bus_list').html(data);
				}
			});	
	
	}	
	
	function remove_business(bid){
		
		$('#busi_'+bid).hide();
			
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/remove_business_do/';?>'+bid+'/<?php echo $page_id; ?>',
			success: function (data) {
				
				//reload_businesses();	 
			}
		});	
	
	}
	
	
	
		function add_people(){			
				
				var frm = $('#people_add');
				//frm.submit();
				$('#btn_ppl').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '<?php echo site_url('/').'admin/add_page_people';?>' ,
					success: function (data) {
						
						 $('#result_msg').html(data);
						 $('#btn_ppl').html('<i class="icon-plus-sign icon-white"></i> Add Person');
						 reload_people(<?php echo $page_id; ?>);
						 var options = {'text':'Person added successfully','layout':'bottomLeft','type':'success'};
						 noty(options);
					}
				});	
	
		}
		
		
		function delete_page_people(id){
			  
			$('#modal-people-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_page_people/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-people-delete').modal('hide');
							
							$("#row-"+id).remove();
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
	
		
		function reload_people(id){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'admin/reload_page_people_all/';?>'+id ,
					success: function (data) {
						
						 $('#curr_ppl').html(data);
						 $('.datatable').dataTable({
							"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
							"sPaginationType": "bootstrap",
							"oLanguage": {
							"sLengthMenu": "_MENU_"
							}
						} );
					}
				});	
		
		
		}

				
	
	</script>
</body>
</html>