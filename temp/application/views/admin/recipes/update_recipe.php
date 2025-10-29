<?php $this->load->view('admin/inc/header');?>
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
						<a href="<?php echo site_url('/');?>admin/recipes/">Recipes</a><span class="divider">/</span>
					</li>
                    <li>
						Update Recipe: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">

				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Recipe: <?php echo $title;?></h2>
						<div class="box-icon">
                        	<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="recipe-update" name="recipe-update" method="post" action="<?php echo site_url('/');?>admin/update_recipe_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="recipe_id"  value="<?php if(isset($recipe_id)){echo $recipe_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Recipe title" value="<?php if(isset($title)){echo $title;}?>">
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
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Page URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>"> 
                                                    <span class="help-block" style="font-size:11px">The URL paramenter. eg: http://www.example.com/about-us</span> 
                                            </div>
                                          </div>
										  
									  	  <div class="control-group">
											<label class="control-label" for="category">Recipe Category</label>
											<div class="controls">
												<select name="category">
													<?php echo $this->admin_model->get_recipe_category_option_select_list($cat_id); ?>
												</select> 
											</div>
										  </div>
										                                                                          
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content loading_img" id="redactor_content" name="description" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
                                                </div>
                                           </div>

                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Instructions:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content loading_img" id="redactor_content" name="instructions" style="display:block"><?php if(isset($instructions)){echo $instructions;}?></textarea>
                                                </div>
                                           </div>
										   
                          				   <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Notes:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content loading_img" id="redactor_content" name="notes" style="display:block"><?php if(isset($notes)){echo $notes;}?></textarea>
                                                </div>
                                           </div>
										   
                                          <div class="control-group">
                                            <label class="control-label" for="title">Preperation Time</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="prep" name="prep" placeholder="Preperation Time" value="<?php if(isset($prep)){echo $prep;}?>">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="title">Cooking Time</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="cook" name="cook" placeholder="Cooking Time" value="<?php if(isset($cook)){echo $cook;}?>">
                                            </div>
                                          </div>										  		
										   
                                          <div class="control-group">
                                            <label class="control-label" for="title">Serves</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="serves" name="serves" placeholder="Serves" value="<?php if(isset($serves)){echo $serves;}?>">
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
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Recipe</button>
                                         
                               </fieldset> 
                             </form>
		             	</p>                                         
                  </div>
				</div>
            </div>
			<div class="row-fluid sortable">
                
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
                        
						<?php $this->admin_model->get_featured_image('recipe', $recipe_id);?>
                        
                        </p>                  
                  </div>
				</div>
				
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Ingredients</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                       <button type="button" class="btn btn-inverse btn" onclick="add_ingredient(<?php echo $recipe_id; ?>)">Add Ingredient</button>
					   <button type="button" class="btn btn-inverse btn" onclick="add_product_ingredient(<?php echo $recipe_id; ?>)">Add Product Ingredient</button>
						
						<div id="ingredient-list">
						<?php $this->admin_model->get_all_ingredients($recipe_id);?>
                        </div>               
                  </div>
				</div>
				
                <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Copyright Info</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                        <form id="update-copyright" name="update-copyright" method="post" action="<?php echo site_url('/');?>admin/update_recipe_copyright" class="form-horizontal">
						<input type="hidden" name="recipe_id"  value="<?php if(isset($recipe_id)){echo $recipe_id;}?>">
						
						  <div class="control-group">
							<label class="control-label" for="title">Original Recipe By</label>
							<div class="controls">
									<input type="text" class="span12" id="original_by" name="original_by" placeholder="Original Recipe By" value="<?php if(isset($original_by)){echo $original_by;}?>">
							</div>
						  </div>
						  
						  <div class="control-group">
							<label class="control-label" for="title">Recipe Photo By</label>
							<div class="controls">
									<input type="text" class="span12" id="photo_by" name="photo_by" placeholder="Recipe Photo By" value="<?php if(isset($photo_by)){echo $photo_by;}?>">
							</div>
						  </div>						  
										  
						<button type="submit" class="btn btn-inverse btn pull-right" id="copy-butt">Update Info</button>
						</form>             
                  </div>
				</div>								
				
				
			</div>

			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
        <div class="modal hide fade" id="modal-ingredient-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Remove the Ingredient</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current ingredient? This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-ingredient-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Ingredient</a>
          </div>
        </div>
        
        <div class="clearfix"></div>


        <div class="modal hide fade" id="modal-ingredient-add">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Add a Ingredient</h3>
          </div>
          <div class="modal-body" >

				<form id="ingredient-add" name="ingredient-add" method="post" action="<?php echo site_url('/');?>admin/add_ingredient" class="form-horizontal">
					<input type="hidden" name="recipe_id"  value="<?php if(isset($recipe_id)){echo $recipe_id;}?>">
					<input name="ingredient" id="ingredient" type="text">
					<button type="submit" class="btn btn-inverse btn add-ing" id="ing-butt">Add Ingredient</button>
				</form>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-ingredient-add').modal('hide');" class="btn">Close</a>
          </div>
        </div>
		

        <div class="modal hide fade" id="modal-product-ingredient-add">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Add a Product Ingredient</h3>
          </div>
          <div class="modal-body" >

				<form id="product-ingredient-add" name="product-ingredient-add" method="post" action="<?php echo site_url('/');?>admin/add_product_ingredient" class="form-horizontal">
					<input type="hidden" name="recipe_id"  value="<?php if(isset($recipe_id)){echo $recipe_id;}?>">
					<input name="ingredient" id="ingredient" placeholder="Enter Info eg. 2 teaspoons of" type="text">					
					<select name="product">
						<option value="">Choose a Product</option>
						<?php echo $this->admin_model->get_recipe_products(); ?>
					</select>
					
					<button type="submit" class="btn btn-inverse btn product-add-ing" id="product-ing-butt">Add Product Ingredient</button>
				</form>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-product-ingredient-add').modal('hide');" class="btn">Close</a>
          </div>
        </div>		

		
        <div class="modal hide fade" id="modal-ingredient-update">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Update the Ingredient</h3>
          </div>
          <div class="modal-body" >

					<form id="ingredient-update" name="ingredient-update" method="post" class="form-horizontal">
					<div class="control-group" id="update-form-body"></div>
					<div class="control-group">
					<button type="submit" class="btn btn-inverse btn" id="upd-butt">Update Ingredient</button>
					</div>
					</form>	
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-ingredient-update').modal('hide');" class="btn">Close</a>
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
	
	var delay = 100;
	var isLoading = false;
	var isDirty = false;	
	
	
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
		
		$('#dob').datepicker();
		


		$('#butt').bind('click',function(e) {
			e.preventDefault();
			//Validate
			if($('#title').val().length == 0){
					
					$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a recipe title"});
					$('#title').popover('show');
					$('#title').focus();
				
			}else{
	
				submit_form();
				
			}
		});
		

		$('#copy-butt').bind('click',function(e) {
		
			
			e.preventDefault();

			var frm = $('#update-copyright');
			
			$('#copy-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_recipe_copyright';?>' ,
				success: function (dataresult) {
					 $('#autosave').val('true');
					 $('#result_msg').html(dataresult);
					 $('#copy-butt').html('Update Info');
					 //$('#test_msg').append(frm.serialize());
				}
			});	

		});	
		
		
		$('#ing-butt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#ingredient').val().length == 0){
					
					$('#ingredient').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Ingredient Required", content:"Please supply us with a ingredient"});
					$('#ingredient').popover('show');
					$('#ingredient').focus();
				
			}else{
	
				submit_ingredient();
				
			}		
			

		});	
		
		$('#upd-butt').bind('click',function(e) {
		
			
			e.preventDefault();
			//Validate
			if($('#upd-ingredient').val().length == 0){
					
					$('#upd-ingredient').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Ingredient Required", content:"Please supply us with a ingredient"});
					$('#upd-ingredient').popover('show');
					$('#upd-ingredient').focus();
				
			}else{
	
				update_ingredient();
				
			}		
			

		});				
		
		
		$('div.btn-group button').live('click', function(){
			
			$('#status').attr('value', $(this).html());
		});
	
		$('#recipe-update :input').change(function() {
	
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
			
			var frm = $('#recipe-update'), content = $('#redactor_content').text();
			
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_recipe_do';?>' ,
				success: function (dataresult) {
					 $('#autosave').val('true');
					 $('#result_msg').html(dataresult);
					 $('#butt').html('Update Recipe');
					 //$('#test_msg').append(frm.serialize());
				}
			});	
	
	}
	
	
	function update_ingredient(){
			
			var frm = $('#ingredient-update');
			
			$('#upd-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				//data: frm.serialize()+'&content2='+content,
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_ingredient/'; ?>' ,
				success: function (dataresult) {
					 $('#autosave').val('true');
					 $('#result_msg').html(dataresult);
					 $('#upd-butt').html('Update Ingredient');
					 
					 $('#modal-ingredient-update').modal('hide');
					 
					 reload_ingredients();
				}
			});	
	
	}		
	

	function open_update_ingredient(iid, rid){
			
			$('#modal-ingredient-update').modal('show');
			
			$.ajax({
				type: 'get',
				cache:false,
				url: '<?php echo site_url('/').'admin/update_ingredient_form/'; ?>'+iid+'/'+rid,
				success: function (data) {
					 
					 $('#update-form-body').html(data);
				}
			});	
	
	}


	function reload_ingredients(){
			
			$.ajax({
				type: 'get',
				cache:false,
				url: '<?php echo site_url('/').'admin/reload_ingredients/'.$recipe_id; ?>',
				success: function (data) {
					 
					 $('#ingredient-list').html(data);
				}
			});	
	
	}	
		
		function delete_ingredient(id){
			  
			$('#modal-ingredient-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_ingredient/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-ingredient-delete').modal('hide');
							reload_ingredients();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		
		function add_ingredient(id){
			 
			var frm = $('#ingredient-add'); 
			  
			$('#modal-ingredient-add').bind('show', function() {
				//var id = $(this).data('id'),
					addBtn = $(this).find('.add-ing');
						
					addBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  type: 'post',
						  url: "<?php echo site_url('/');?>admin/add_ingredient/"+id+"/",
						  data: frm.serialize(),
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-ingredient-add').modal('hide');
							reload_ingredients();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		
		function add_product_ingredient(id){
			 
			var frm = $('#product-ingredient-add'); 
			  
			$('#modal-product-ingredient-add').bind('show', function() {
				//var id = $(this).data('id'),
					addBtn = $(this).find('.product-add-ing');
						
					addBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  type: 'post',
						  url: "<?php echo site_url('/');?>admin/add_product_ingredient/",
						  data: frm.serialize(),
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-product-ingredient-add').modal('hide');
							reload_ingredients();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}				
	
	
	//IE 9 Fix
	function htmlEntities(str) {
		return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
	}		
	
	</script>
</body>
</html>