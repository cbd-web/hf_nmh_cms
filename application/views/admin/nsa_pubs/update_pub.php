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
						<a href="<?php echo site_url('/');?>admin/nsa_pubs/">Publications</a><span class="divider">/</span>
					</li>
                    <li>
						Update Publication: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">

				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Publication: <?php echo $title;?></h2>
						<div class="box-icon">
                        	<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="pub-update" name="pub-update" method="post" action="<?php echo site_url('/');?>admin/update_nsa_pub_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="pub_id" value="<?php if(isset($pub_id)){echo $pub_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($active)){echo $active;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Publication title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="title">Status</label>
                                            <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" class="btn btn-primary<?php if($active == 'Draft'){ echo ' active';}?>" >Draft</button>
                                                      <button type="button" class="btn btn-primary<?php if($active == 'Live'){ echo ' active';}?>" >Live</button>
                                                    </div>
                                            </div>
                                          </div>

                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Page URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>

									  	  <div class="control-group">
											<label class="control-label" for="category">Category</label>
											<div class="controls">
												<select name="category">
													<?php echo $this->nsa_pub_model->get_category_option_select_list($cat_id); ?>
												</select> 
											</div>
										  </div>  
										  
										  
                                         <div class="control-group">
											<label class="control-label" for="pub_date">Publish date</label>
											<div class="controls">
													 <div class="input-append date" id="dob" data-date="<?php if (isset($listing_date)){echo date('Y-m-d',strtotime($listing_date));}else{ echo date();}?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
													  <input type="text"  name="listing_date" id="listing_date" value="<?php if (isset($listing_date)){echo date('Y-m-d',strtotime($listing_date));}else{ echo date();}?>" readonly>
													  <span class="add-on"><i class="icon-calendar"></i></span>
													</div> 
													<span class="help-block" style="font-size:11px">Select the date the post is published</span>
											</div> 
                                         </div>										  										  										                            
							
                                       	  <div class="control-group">
                                            <label class="control-label" for="sequence">Sequence:</label>
                                            <div class="controls">
                                                    <input name="sequence" type="text" class="span1" id="sequence" value="<?php if(isset($sequence)){echo $sequence;}?>" size="3" maxlength="3">  
                                            		<span class="help-block" style="font-size:11px">Set the sequence of the page</span>
                                            </div>
                                 		  </div>
										  										   								   
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Publication</button>
                               </fieldset> 
                             </form>
		             	</p>                                         
                  </div>
				</div>
            </div>
                
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Publication Document</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="reload_area1">
                  	  	<p>
                        
						<?php $this->nsa_pub_model->get_pub_doc($pub_id, 'doc', $title);?>
                        
                        </p>                  
                  </div>
				</div> 
				
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Publication Dataset</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="reload_area2">
                  	  	<p>
                        
						<?php $this->nsa_pub_model->get_pub_doc($pub_id, 'data');?>
                        
                        </p>                  
                  </div>
				</div>   				            
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				

        <div class="clearfix"></div>
		
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
	<script type="text/javascript">
	
	
	$(document).ready(function(){
						
		$('#dob').datepicker();	
		
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
	
		$('#pub-update :input').change(function() {
	
		  $('#autosave').val('false');
		});
		

		//Upload Document
		$('#docbut').bind('click', function() {
			
			
			var avataroptions = { 
				target:        '#avatar_msg',
				url:       	   '<?php echo site_url('/').'admin/add_nsa_doc';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
									var percentVal = percentComplete + '%';
									probar.width(percentVal)
									
								},
				 complete: function(xhr) {
									procover.hide();
									probar.width('0%');
									reload_area1();
								}				
		
			}; 
		
			var frm = $('#add-nsa-doc');
			var probar = $('#procover .bar');
			var procover = $('#procover');
		
			$('#docbut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});
		
		//Upload Document
		$('#docbut2').bind('click', function() {
			
			
			var avataroptions = { 
				target:        '#avatar_msg',
				url:       	   '<?php echo site_url('/').'admin/add_nsa_doc';?>' ,
				beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
				uploadProgress: function(event, position, total, percentComplete) {
									var percentVal = percentComplete + '%';
									probar.width(percentVal)
									
								},
				 complete: function(xhr) {
									procover.hide();
									probar.width('0%');
									reload_area2();
								}				
		
			}; 
		
			var frm = $('#add-nsa-data');
			var probar = $('#procover2 .bar');
			var procover = $('#procover2');
		
			$('#docbut2').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
			procover.show();
			frm.ajaxForm(avataroptions);
			$('#autosave').val('true');
		});		

		
});
		

	
	function submit_form(){
			
			var frm = $('#pub-update');
			
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_nsa_pub_do';?>' ,
				success: function (dataresult) {
					 $('#autosave').val('true');
					 $('#result_msg').html(dataresult);
					 $('#butt').html('Update Publication');
					 //$('#test_msg').append(frm.serialize());
				}
			});	
	
	}
	
	//IE 9 Fix
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}
	


	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The page has not been saved.'; 
			
		 }
		 
	};
	
	function reload_area2() {
	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'admin/reload_area/'.$pub_id.'/data'; ?>' ,
		success: function (data) {
			
			 $('#reload_area2').html(data);

		}
	});
		
	}
	
	function reload_area1() {

	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'admin/reload_area/'.$pub_id.'/doc'; ?>' ,
		success: function (data) {
			
			 $('#reload_area1').html(data);

		}
	});		
			
	}	
	

	function remove_doc(id, typ){
		
		$.ajax({
			type: "get",
			
			url: "<?php echo site_url('/').'admin/remove_featured_document/'; ?>"+id+"/"+typ,
			success: function (data) {
				
				location.reload();
				
/*				reload_area1();
				reload_area2();*/
				
			}
		});
		
	}
	
		
	
	</script>
</body>
</html>