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
						<a href="<?php echo site_url('/');?>admin/charts/">Charts</a><span class="divider">/</span>
					</li>
                    <li>
						Update Chart: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">

				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Chart: <?php echo $title;?></h2>
						<div class="box-icon">
                        	<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="chart-update" name="chart-update" method="post" action="<?php echo site_url('/');?>admin/update_chart_do" class="form-horizontal">
								<input type="hidden" name="id"  value="<?php echo $chart_id; ?>">
								<input type="hidden" name="autosave" id="autosave"  value="true">
								<input type="hidden" name="active" id="active"  value="<?php if(isset($active)){echo $active;}?>">	
														
                             			<fieldset>

                                       	<div class="control-group">
                                            <label class="control-label" for="title">Status</label>
                                            <div class="controls">
                                                    <div class="btn-group" data-toggle="buttons-radio">
                                                      <button type="button" class="btn btn-primary <?php if($active == 'N'){ echo 'active';}?>">Draft</button>
                                                      <button type="button" class="btn btn-primary <?php if($active == 'Y'){ echo 'active';}?>">Live</button>
                                                    </div>
                                            </div>
                                          </div>  
										    
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span12" id="title" name="title" placeholder="Chart title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>
										  
                             			  <div class="control-group">
                                            <label class="control-label" for="title">Heading</label>
                                            <div class="controls">
                                                    <input type="text" class="span12" id="heading" name="heading" placeholder="Chart Heading" value="<?php if(isset($heading)){echo $heading;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional, give your chart a sub heading (h2)</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span12" id="slug" name="slug" placeholder="Chart URL Slug eg: /misc-chart" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>
                            										  									  

									  	  <div class="control-group">
											<label class="control-label" for="category">Chart Category</label>
											<div class="controls">
												<select name="category">
													<?php echo $this->chart_model->get_category_option_select_list($cat_id); ?>
												</select> 
											</div>
										  </div>
										  
									  	  <div class="control-group">
											<label class="control-label" for="type">Chart Type</label>
											<div class="controls">
												<select name="type">
													<option value="line" <?php if($type=='line') { echo 'selected'; } ?>>Line Chart</option>
													<option value="bar" <?php if($type=='bar') { echo 'selected'; } ?>>Bar Chart</option>
													<option value="pie" <?php if($type=='pie') { echo 'selected'; } ?>>Pie Chart</option>
												</select> 
											</div>
										  </div>
										  
										  
                                          <div class="control-group">
                                            <label class="control-label" for="title">X-Axis Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span12" id="x_title" name="x_title" placeholder="X-Axis Title" value="<?php if(isset($x_title)){echo $x_title;}?>">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="title">Y-Axis Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span12" id="y_title" name="y_title" placeholder="X-Axis Title" value="<?php if(isset($y_title)){echo $y_title;}?>">
                                            </div>
                                          </div>										  										  
										  								  
                            							
                                          <div class="control-group">
                                            <label class="control-label" for="sequence">Sequence:</label>
                                            <div class="controls">
                                                    <input name="sequence" type="text" class="span1" id="sequence" value="<?php if(isset($sequence)){echo $sequence;}?>" size="3" maxlength="3">  
                                            </div>
                                 		  </div>
                                          
                                           
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Chart Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
                                                </div>
                                           </div>
										   
										   										   
                                         
                                               <div class="control-group">
                                                   <label class="control-label" for="metaT">Meta Title:</label>
                                                    <div class="controls">
                                                        <textarea name="metaT" style="display:block" class="span12"><?php if(isset($metaT)){echo $metaT;}?></textarea>
                                                        <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                                     </div>
                                               </div>
                                          
                                           
                                            
                                             <div class="control-group">
                                                    <label class="control-label" for="metaD">Meta Description:</label>
                                                    <div class="controls">
                                                         <textarea name="metaD" style="display:block" class="span12"><?php if(isset($metaD)){echo $metaD;}?></textarea>
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
                                                    </div>
                                               </div>
                                          
                                         <div id="result_msg"></div>
                                         <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Chart</button>
                                           
                               </fieldset> 
                             </form>						
		             	</p>                                         
                  </div>
				</div>
                
			</div>
			
			<div class="row-fluid">
			<a href="#addDataset" role="button" class="btn btn-inverse btn" data-toggle="modal">Add Dataset</a>
			</div>
			
			<div id="dataset_view">
			<?php echo $this->chart_model->get_datasets($chart_id); ?>
			</div>
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
			
		</div><!--/fluid-row-->
				
		
        <div class="clearfix"></div>
		
		
		<div class="modal hide fade" id="addDataset">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Add Dataset</h3>
			</div>
			<div class="modal-body">
				<div class="row-fluid">
				<form id="add-dataset" name="add-dataset" method="post" action="<?php echo site_url('/');?>admin/add_dataset_do" >
				<input type="hidden" name="chart_id"  value="<?php echo $chart_id; ?>">
					<fieldset>
						<input type="text" id="set_title" class="span12" name="set_title" placeholder="Dataset title" value="">		
					</fieldset>
					<button type="submit" class="btn btn-inverse btn pull-right" id="add-set-butt">Add Dataset</button>				
				</form>
				</div>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
			</div>
		</div>			


        <div class="modal hide fade" id="modal-datarow-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Datarow</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the datarow? All datarow details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-datarow-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Datarow</a>
          </div>
        </div>
		
        <div class="modal hide fade" id="modal-dataset-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Dataset</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the dataset? All dataset details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-dataset-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Dataset</a>
          </div>
        </div>				
		
		
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/js/bootstrap-colorpicker.min.js"></script>
	
	<script type="text/javascript">
	
	var delay = 100;
	var isLoading = false;
	var isDirty = false;	
	
	
	$(document).ready(function(){	
		
		$('.color_primary').colorpicker();				
	
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
		
				


		$('#butt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#title').val().length == 0){
					
					$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a chart title"});
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
		
		
		$( ".b-d" ).each(function(index, value) {
		  $(this).click(function(e){
			e.preventDefault();
			
			var id = $(this).attr("id");
			
			var suffix = id.match(/\d+/);
			
			console.log($(this).attr("id"));
			
			update_dataset(suffix);
			});
		});
	
		
		
		
		
		
		$('#add-set-butt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#set_title').val().length == 0){
					
					$('#set_title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a dataset title"});
					$('#set_title').popover('show');
					$('#set_title').focus();
			
	/*		}else if($('#redactor_content').val() == 0){
		
					$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
					$('#redactor_content_msg').popover('show');
					$('#redactor_content_msg').focus();	*/		
				
			}else{
	
				add_data_set();
				
			}
		});
				
		
		
		$('div.btn-group button').live('click', function(){
			
			$('#active').attr('value', $(this).html());
		});
	
		$('#chart-update :input').change(function() {
	
		  $('#autosave').val('false');
		});
		$('.redactor_box').live('click', function() {
	
		  $('#autosave').val('false');
		});
		
		
	});
		

	
	function submit_form(){
			
			var frm = $('#chart-update'), content = $('#redactor_content').text();
			
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_chart_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Chart');
					 //$('#test_msg').append(frm.serialize());
				}
			});	
	
	}
	
	function add_data_set(){
			
			var frm = $('#add-dataset');
			
			$('#add-set-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/add_dataset_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#add-set-butt').html('Add dataset');
					 //$('#test_msg').append(frm.serialize());
					 
					 reload_datasets();					 
					 
					 $('#addDataset').modal('hide');
					 
					 
				}
			});	
	
	}
	
	function update_dataset(id){
			
			var frm = $('#dataset-update-'+id);
			
			$('#data-butt-'+id).html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_dataset_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#data-butt-'+id).html('Update Dataset');
					 //$('#test_msg').append(frm.serialize());
				}
			});	
	
	}	
	
	function add_data_row(did,cid){
			
			
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/add_datarow_do/'; ?>'+did+'/'+cid,
			success: function (data) {
				$('#result_msg').html(data);
				reload_datasets();	 
			}
		});				
				
	
	}


	
	function reload_datasets(){
			
			$.ajax({
				type: 'get',
				cache:false,
				url: '<?php echo site_url('/').'admin/reload_datasets/'.$chart_id; ?>',
				success: function (data) {
					 
					$('#dataset_view').html(data);
					$('.btn-minimize').click(function(e){
						e.preventDefault();
						var $target = $(this).parent().parent().next('.box-content');
						if($target.is(':visible')) $('i',$(this)).removeClass('icon-chevron-up').addClass('icon-chevron-down');
						else 					   $('i',$(this)).removeClass('icon-chevron-down').addClass('icon-chevron-up');
						$target.slideToggle();
					});	
					$('.color_primary').colorpicker();
					
					$( ".b-d" ).each(function(index, value) {
					  $(this).click(function(e){
						e.preventDefault();
						
						var id = $(this).attr("id");
						
						var suffix = id.match(/\d+/);
						
						console.log($(this).attr("id"));
						
						update_dataset(suffix);
						});
					});					
								 
				}
			});	
	
	}
	

		function delete_dataset(id){
			  
			$('#modal-dataset-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/remove_dataset/"+id+"/",
						  success: function(data) {
							
							$('#result_msg').html(data);
							reload_datasets();
							$('#modal-dataset-delete').modal('hide');
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

			

		function delete_datarow(id,cid,did){
			  
			$('#modal-datarow-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/remove_datarow/"+id+"/"+cid+"/"+did,
						  success: function(data) {
							
							$('#result_msg').html(data);
							reload_datasets();
							$('#modal-datarow-delete').modal('hide');
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}	
	
	
	
	function clone_input(id, did) {
	
		var txto = $("#label_"+id+"_"+did).val();
		$(".label_"+id).val(txto);	
		
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





		
	
	</script>
</body>
</html>