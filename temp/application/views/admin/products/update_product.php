<?php $this->load->view('admin/inc/header');?>

<?php $next_product = $this->admin_model->get_next_product_id($product_id); ?>
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
						<a href="<?php echo site_url('/');?>admin/products/">Products</a><span class="divider">/</span>
					</li>
                    <li>
						Update Product: <?php echo $title; ?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">

				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Product: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="product-update" name="product-update" method="post" action="<?php echo site_url('/');?>admin/update_product_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="product_id"  value="<?php if(isset($product_id)){echo $product_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">
                                            <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                            <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Product title" value="<?php if(isset($title)){echo $title;}?>">
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
                                                    <input type="text" class="span6" id="heading" name="heading" placeholder="Product Heading" value="<?php if(isset($heading)){echo $heading;}?>">
                                                    <span class="help-block" style="font-size:11px">Optional, give your product a sub heading (h2)</span>
                                            </div>
                                          </div>
                                          <div class="control-group">
                                            <label class="control-label" for="slug">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Product URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">  
                                            </div>
                                          </div>
										  
										  <div class="control-group">
                                            <label class="control-label" for="sku">SKU Code</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="sku" name="sku" placeholder="SKU Code"  value="<?php if(isset($sku_code)){echo $sku_code;}?>">
                                            </div>
                                          </div>										  
										  
										  <div class="control-group">
                                            <label class="control-label" for="slug">Category</label>
                                            <div class="controls">
												<select name="type" onChange="load_sub_cats(this.value)">
													<?php echo $this->admin_model->get_all_product_categories($category); ?>
												</select>
                                            </div>
                                          </div>
										  										  
 
										  <div class="control-group">
                                            <label class="control-label" for="type_s">Category Type</label>
                                            <div class="controls">
												<select name="type_s" class="disabled" id="sub_cat_div">
													<?php echo $this->admin_model->get_all_product_category_types(1, $category_type, $category); ?>
												</select>
                                            </div>
                                          </div>
										  
										  <div class="control-group">
                                            <label class="control-label" for="slug">Manufacturer</label>
                                            <div class="controls">
												<select name="manufacturer">
													<option value="">Select a Manufacturer</option>
													<?php echo $this->admin_model->get_all_product_manufacturers($manufacturer); ?>
												</select>
                                            </div>
                                          </div>										                                         										  
										  
                                         <div class="control-group">
                                            <label class="control-label" for="start_price">Start Price (N$)</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="start_price" name="start_price" placeholder="Start Price"  value="<?php if(isset($start_price)){echo $start_price;}?>">
                                            </div>
                                          </div>
										  
                                         <div class="control-group">
                                            <label class="control-label" for="sale_price">Sale Price (N$)</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="sale_price" name="sale_price" placeholder="Sale Price" value="<?php if(isset($sale_price)){echo $sale_price;}?>">
                                            </div>
                                          </div>
										  
										  										  
                                         <div class="control-group">
                                            <label class="control-label" for="sale_price">Special</label>
                                            <div class="controls">
											<input name="special" type="checkbox" value="Y" <?php if($special == 'Y') { echo "checked"; } ?>>
                                            </div>
                                          </div>
										                              
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Product Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
                                                </div>
                                           </div>
										   
                                         <div class="control-group">
                                            <label class="control-label" for="url_link">URL (http://)</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="url_link" name="url_link" placeholder="eg. www.website.com"  value="<?php if(isset($url_link)){echo $url_link;}?>">
                                            </div>
                                          </div>										   
                                         
                                             <div class="control-group">
                                                    <label class="control-label" for="pub_date">Publish date</label>
                                                    <div class="controls">
                                                             <div class="input-append date" id="dob" data-date="1985-10-19" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
                                                              <input type="text"  name="pub_date" id="pub_date" value="<?php if (isset($listing_date)){echo date('Y-m-d',strtotime($listing_date));}?>" readonly>
                                                              <span class="add-on"><i class="icon-calendar"></i></span>
                                                            </div> 
                                                            <span class="help-block" style="font-size:11px">Select the date the product is published</span>
                                                    </div> 
                                               </div>

											 <div class="control-group">
												 <label class="control-label" for="sequence">Sequence:</label>
												 <div class="controls">
													 <input name="sequence" type="text" class="span1" id="sequence" value="<?php if(isset($sequence)){echo $sequence;}?>" size="3" maxlength="3">
													 <span class="help-block" style="font-size:11px">Set the sequence of the product</span>
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
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther product.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
										  <?php echo $this->admin_model->get_prev_product($product_id); ?> 
                                          <?php echo $this->admin_model->get_next_product($product_id); ?> 
										  
										  <button type="submit" class="btn btn-inverse btn pull-right" id="butt" style="margin-right:10px;">Update Product</button>  
										  
										  <button type="button" class="btn btn-danger btn pull-right" onclick="delete_product(<?php echo $product_id; ?>)" style="margin-right:10px;">Delete Product</button>  
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
                 <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Product Components</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content">
                  	  	<div class="alert">
                        Please select what component you would like to display.
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
                                <?php $this->admin_model->get_sidebar_content('product_'.$product_id);?>
                            </div>
                           
                           
                            <div id="doc_msg"></div>
                         </div>
                         <div class="clearfix" style="height:20px"></div>    
                         
 
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
                        
						<?php $this->admin_model->get_featured_image('product', $product_id);?>
                        
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
				
		 <div class="modal hide fade" id="modal-doc-delete">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Delete Document</h3>
			</div>
			<div class="modal-body">
				<p>The document will be removed from the Product. This process is not reversible.</p>
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
		
        <div class="modal hide fade" id="modal-product-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Product</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current product? All product details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-product-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Product</a>
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
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a product title"});
				$('#title').popover('show');
				$('#title').focus();
		
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
			
			var frm = $('#product-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'admin/update_product_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Product');
					
				}
			});	
	
	}
	
	function attach_gallery(){
			
			var gal_id = $('#gallery_select').val();
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/update_sidebar/product/'.$product_id.'/gallery/';?>'+gal_id ,
				success: function (data) {

					load_images(gal_id);
				}
			});	
	
	}
	
	function remove_gallery(gal_id){
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/remove_sidebar/product/'.$product_id.'/gallery/';?>'+gal_id ,
				success: function (data) {
					
					 $('#gallery_images').html(data);
				}
			});	
	
	}	
	
	
	
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The product has not been saved.'; 
			
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
	
	function load_images(gal_id){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>admin/load_gallery_images/"+gal_id+"/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#gallery_images').empty();
			  $('#gallery_images').html(data);

			}
		  });			
			
	}
	
	function load_sub_cats(id){
			
			
			//frm.submit();
			//$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/get_product_sub_cats/0/0/';?>'+id ,
				success: function (data) {
					
					 $('#sub_cat_div').html(data);
					
					
				}
			});	
	
	}
	
		function delete_product(id){
			  
			$('#modal-product-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_product/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-product-delete').modal('hide');
							
							window.location.href = "<?php echo site_url('/').'admin/update_product/'.$next_product; ?>";
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}			
	
	</script>
</body>
</html>