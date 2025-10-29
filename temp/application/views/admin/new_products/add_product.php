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
						<a href="<?php echo site_url('/');?>product/products/">Products</a><span class="divider">/</span>
					</li>
                    <li>
						Add New Product
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Product</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="product-update" name="product-update" method="post" action="<?php echo site_url('/');?>product/add_product_do" class="form-horizontal">
                             <fieldset>
    
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Product title" value="">
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
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Product URL Slug eg: /about-us" value="">  
                                            </div>
                                          </div>
										  
										  
                                         <div class="control-group">
                                            <label class="control-label" for="sku">SKU Code</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="sku" name="sku" placeholder="SKU Code" value="">
                                            </div>
                                          </div>										  
										  
										  <div class="control-group">
                                            <label class="control-label" for="category">Category</label>
                                            <div class="controls">
												<select name="category">
												<option value="0">Select Category</option>
													<?php echo $this->product_model->get_product_category_list(); ?>
												</select>
                                            </div>
                                          </div>									  
                                          										  
										  
                                         <div class="control-group">
                                            <label class="control-label" for="start_price">Start Price (N$)</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="start_price" name="start_price" placeholder="Start Price" value="">
                                            </div>
                                          </div>
										  
                                         <div class="control-group">
                                            <label class="control-label" for="sale_price">Sale Price (N$)</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="sale_price" name="sale_price" placeholder="Sale Price" value="">
                                            </div>
                                          </div>											  										  
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Product Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
                                                </div>
                                           </div>


                                         <div class="control-group">
                                            <label class="control-label" for="url_link">URL (http://)</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="url_link" name="url_link" placeholder="eg. www.website.com" value="">
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
                                                         <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther product.</span>
                                                    </div>
                                               </div>
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Product</button>
                                           
                               </fieldset> 
                             </form>
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
    
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>	
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
	

	
	function submit_form(){
			
			var frm = $('#product-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'product/add_product_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Product');
					
				}
			});	
	
	}
	
	
	</script>
</body>
</html>