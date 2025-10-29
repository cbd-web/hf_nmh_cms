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
						<a href="<?php echo site_url('/');?>vendor/vendors/">Vendors</a><span class="divider">/</span>
					</li>
                    <li>
						Add New Vendor
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Vendor</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="vendor-add" name="vendor-add" method="post" action="<?php echo site_url('/');?>vendor/add_vendor_do" class="form-horizontal">
                             <fieldset>
    
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span8" id="title" name="title" placeholder="Vendor title" value="">
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="type_s">Vendor category</label>
											 <div class="controls">
												 <select name="cat_id">
													 <?php echo $this->vendor_model->get_all_vendor_cat_option(); ?>
												 </select>
											 </div>
										 </div>


										 <div class="control-group">
											 <label class="control-label" for="price_from">Price Range From</label>
											 <div class="controls">
												 <input type="text" class="span8" id="price_from" name="price_from" placeholder="Price Range From" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="price_to">Price Range To</label>
											 <div class="controls">
												 <input type="text" class="span8" id="price_to" name="price_to" placeholder="Price Range To" value="">
											 </div>
										 </div>

								 		  <div class="control-group">
                                            <label class="control-label" for="tel">Telephone Number</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="tel" name="tel" placeholder="Telephone Number" value="">
                                            </div>
                                          </div>
										  
                                          <div class="control-group">
                                            <label class="control-label" for="cell">Cellphone Number</label>
                                            <div class="controls">
                                              <input type="text" class="span8" id="cell" name="cell" placeholder="Cellphone Number" value="">
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="fax">Fax Number</label>
											 <div class="controls">
												 <input type="text" class="span8" id="fax" name="fax" placeholder="Fax Number" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="email">Email</label>
											 <div class="controls">
												 <input type="text" class="span8" id="email" name="email" placeholder="Email" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="website">Website URL</label>
											 <div class="controls">
												 <input type="text" class="span8" id="website" name="website" placeholder="Website URL" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="postal">Postal Address</label>
											 <div class="controls">
												 <input type="text" class="span8" id="postal" name="postal" placeholder="Postal Address" value="">
											 </div>
										 </div>


										 <div class="control-group">
											 <label class="control-label" for="address">Physical Address</label>
											 <div class="controls">
												 <input type="text" class="span8" id="address" name="address" placeholder="Physical Address" value="">
											 </div>
										 </div>


										 <div class="control-group">
											 <label class="control-label" for="type_s">Vendor Region</label>
											 <div class="controls">
												 <select name="region">
													 <?php echo $this->vendor_model->get_region_option(); ?>
												 </select>
											 </div>
										 </div>


										 <div class="control-group">
											 <label class="control-label" for="type_s">Vendor Town</label>
											 <div class="controls">
												 <select name="town">
													 <?php echo $this->vendor_model->get_town_option(); ?>
												 </select>
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="facebook">Facebook</label>
											 <div class="controls">
												 <input type="text" class="span8" id="facebook" name="facebook" placeholder="Facebook" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="google_plus">Google Plus</label>
											 <div class="controls">
												 <input type="text" class="span8" id="google_plus" name="google_plus" placeholder="Google Plus" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="instagram">Instagram</label>
											 <div class="controls">
												 <input type="text" class="span8" id="instagram" name="instagram" placeholder="Instagram" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="youtube">YouTube</label>
											 <div class="controls">
												 <input type="text" class="span8" id="youtube" name="youtube" placeholder="YouTube" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="twitter">Twitter</label>
											 <div class="controls">
												 <input type="text" class="span8" id="twitter" name="twitter" placeholder="Twitter" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="flickr">Flickr</label>
											 <div class="controls">
												 <input type="text" class="span8" id="flickr" name="flickr" placeholder="Flickr" value="">
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="pinterest">Pinterest</label>
											 <div class="controls">
												 <input type="text" class="span8" id="pinterest" name="pinterest" placeholder="Pinterest" value="">
											 </div>
										 </div>


										 <div class="control-group" id="redactor_content_msg">
											 <label class="control-label" for="redactor_content">Vendor Body:</label>
											 <div class="controls">

												 <textarea id="tinymce" class="tinymce" name="content"></textarea>
											 </div>
										 </div>

   
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Vendor</button>
                                           
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

	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
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

	});
	
	$('#butt').click(function(e) {


		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){

			$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a vacancy title"});
			$('#title').popover('show');
			$('#title').focus();


		}else{

			submit_form();

		}
	});


	function submit_form(){

		var frm = $('#vendor-add');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'vendor/add_vendor_do';?>' ,
			success: function (data) {

				$('#result_msg').html(data);
				$('#butt').html('Add Vendor');

			}
		});

	}
	
	
	</script>
</body>
</html>