<?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet">
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places" ></script>

<?php $next_product = $this->property_model->get_next_product_id($property_id); ?>

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
						<a href="<?php echo site_url('/');?>property/properties/">Properties</a><span class="divider">/</span>
					</li>
                    <li>
						Update Product: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Property: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="property-update" name="property-update" method="post" action="<?php echo site_url('/');?>property/update_property_do" class="form-horizontal">
                             <fieldset>
									<input type="hidden" name="property_id"  value="<?php if(isset($property_id)){echo $property_id;}?>">
									<input type="hidden" name="autosave" id="autosave"  value="true">
									<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
								    <input type="hidden" value="<?php echo $type; ?>" name="status_type" id="status-type">
								    <input type="hidden" value="<?php echo $sub_type; ?>" name="property_type" id="property-type">
								    <input type="hidden" value="<?php echo $sub_sub_type; ?>" name="building_type" id="building-type">

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
										 <label class="control-label" for="title">Title</label>
										 <div class="controls">
											 <input type="text" class="span6" id="title" name="title" placeholder="Property title" value="<?php echo $title; ?>">
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label" for="title">Heading</label>
										 <div class="controls">
											 <input type="text" class="span6" id="heading" name="heading" placeholder="Property heading" value="<?php echo $heading; ?>">
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label" for="slug">Slug</label>
										 <div class="controls">
											 <input type="text" class="span6" id="slug" name="slug" placeholder="Product URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label" for="ref_no">Reference Number</label>
										 <div class="controls">
											 <input type="text" class="span6" id="ref_no" name="ref_no" placeholder="Property Reference Number" value="<?php echo $ref_no; ?>">
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label">Property Status</label>
										 <div class="controls">
											 <select name="prop_status">
												 <option value="current" <?php if($prop_status == 'current') { echo "selected"; } ?>>Current</option>
												 <option value="completed" <?php if($prop_status == 'completed') { echo "selected"; } ?>>Completed</option>
												 <option value="sold" <?php if($prop_status == 'sold') { echo "selected"; } ?>>Sold</option>
											 </select>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label">Feature Property</label>
										 <div class="controls">
											 <input name="featured" type="checkbox" value="Y" <?php if($featured == 'Y') { echo "checked"; } ?>>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label">Property Sold</label>
										 <div class="controls">
											 <input name="sold" type="checkbox" value="Y" <?php if($sold == 'Y') { echo "checked"; } ?>>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label">Show Map</label>
										 <div class="controls">
											 <input name="show_map" type="checkbox" value="Y" <?php if($show_map == 'Y') { echo "checked"; } ?>>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label">Both For Sale / To Rent</label>
										 <div class="controls">
											 <input name="both_types" type="checkbox" value="Y" <?php if($both_types == 'Y') { echo "checked"; } ?>>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label">Type</label>
										 <div class="controls">
											 <select name="sub_type" id="sub-type">
												 <?php echo $this->property_model->get_category_select('3408',0,0,0, $sub_cat_id) ?>
											 </select>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label">Property Type</label>
										 <div class="controls">
											 <select name="sub_sub_type" id="sub-sub-type">
												 <?php echo $this->property_model->get_category_select('3408',$sub_cat_id,0,0,$sub_sub_cat_id) ?>
											 </select>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label">Building Type</label>
										 <div class="controls">
											 <select name="sub_sub_sub_type" id="sub-sub-sub-type">
												 <?php echo $this->property_model->get_category_select('3408',$sub_cat_id,$sub_sub_cat_id,0,$sub_sub_sub_cat_id) ?>
											 </select>
										 </div>
									 </div>


									 <div class="control-group">
										 <label class="control-label" for="category">Location</label>
										 <div class="controls">
											 <select name="location" id="property_location">
												 <?php echo $this->property_model->get_location_list($location); ?>
											 </select>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label" for="category">Suburb</label>
										 <div class="controls">
											 <select name="suburb" id="property_suburb">
												 <?php echo $this->property_model->get_suburb_list($location, $suburb); ?>
											 </select>
										 </div>
									 </div>


									 <div class="control-group">
										 <label class="control-label" for="price">Price (N$)</label>
										 <div class="controls">
											 <input type="text" class="span6" id="price" name="price" placeholder="Price" value="<?php echo $price; ?>" onkeypress="return isNumberKey(event)">
											 <span id="money-preview" style="margin-left:10px"><?php echo $price; ?></span>
										 </div>
									 </div>


									 <div class="control-group" id="redactor_content_msg">
										 <label class="control-label" for="redactor_content">Property Body:</label>
										 <div class="controls">

											 <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"><?php echo $body; ?></textarea>
										 </div>
									 </div>

									 <div class="control-group">
										 <label class="control-label" for="pub_date">Publish date</label>
										 <div class="controls">
											 <div class="input-append date" id="property_date" data-date="<?php if (isset($property_date)){echo date('Y-m-d',strtotime($property_date));}else{ echo date('Y-m-d');}?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
												 <input type="text" name="property_date" value="<?php if (isset($property_date)){echo date('Y-m-d',strtotime($property_date));}else{ echo date('Y-m-d');}?>">
												 <span class="add-on"><i class="icon-calendar"></i></span>
											 </div>
											 <span class="help-block" style="font-size:11px">Select the date the property is published</span>
										 </div>
									 </div>


									 <div class="control-group">
										 <label class="control-label" for="metaT">Meta Title:</label>
										 <div class="controls">
											 <textarea name="metaT" style="display:block" class="span6"><?php echo $metaT; ?></textarea>
											 <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
										 </div>
									 </div>



									 <div class="control-group">
										 <label class="control-label" for="metaD">Meta Description:</label>
										 <div class="controls">
											 <textarea name="metaD" style="display:block" class="span6"><?php echo $metaD; ?></textarea>
											 <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther product.</span>
										 </div>
									 </div>
                                          
                                          <div id="result_msg"></div>
										  <?php echo $this->property_model->get_prev_product($property_id); ?>
                                          <?php echo $this->property_model->get_next_product($property_id); ?>
										  
										  <button type="submit" class="btn btn-inverse btn pull-right" id="butt" style="margin-right:10px;">Update Property</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>
                  </div>

					<div class="box">
						<div class="box-header">
							<h2><i class="icon-th"></i><span class="break"></span>Property Features</h2>
							<div class="box-icon">
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<div class="row-fluid">
								<form id="feature-add" name="feature-add" method="post" action="<?php echo site_url('/');?>property/add_property_feature">
									<input type="hidden" name="property_id"  value="<?php if(isset($property_id)){echo $property_id;}?>">
									<div class="control-group">
										<label class="control-label" for="title">Choose Feature</label>
										<div class="controls">
											<select class="span12" name="feature">
												<option value="none">Choose a feature</option>
												<?php echo $this->property_model->get_feature_list(); ?>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label" for="title">Feature Info</label>
										<div class="controls">
											<textarea id="body" name="body" class="span12"></textarea>
										</div>
									</div>
									<div class="control-group">
										<button type="submit" class="btn btn-inverse btn" id="feat-butt">Add Feature</button>
									</div>
								</form>
							</div>
							<div class="row-fluid" id="feature_box">

								<?php $this->property_model->get_property_features($property_id); ?>

							</div>
						</div>
					</div>


					<div class="box">
						<div class="box-header">
							<h2><i class="icon-th"></i><span class="break"></span>Add Property Map Location</h2>
							<div class="box-icon">
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<p>
							<form id="location-add" name="location-add" method="post" action="<?php echo site_url('/');?>property/add_location_do" >
								<input type="hidden" name="lat" id="lat" value="">
								<input type="hidden" name="lng" id="lng" value="">
								<input type="hidden" value="<?php echo $property_id; ?>" name="property_id">
								<fieldset>


									<div class="control-group">
										<label class="control-label" for="title">Location</label>
										<div class="controls">
											<input type="text" class="span6" id="pac-input">
										</div>
									</div>




									<div class="control-group" id="map-canvas" style="height:400px">


									</div>

									<div id="result_msg"></div>
									<button type="submit" class="btn btn-inverse btn pull-right" id="map-butt">Add Location</button>

								</fieldset>
							</form>
							</p>
						</div>
					</div>


				</div>
                 <div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Property Components</h2>
						<div class="box-icon">
							
						</div>
					</div>
					<div class="box-content">
                  	  	<div class="alert">
                        Please select what component you would like to display.
                        </div>
						<h2>Facebook Share</h2>
                        <p>
						<div class="fb-share-button" data-href="http://154.0.162.107/~sspcom/beta/index.php/property/<?php echo $slug; ?>" data-layout="button_count" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2F154.0.162.107%2F%7Esspcom%2Fbeta%2Findex.php%2Fproperty%2F<?php echo $slug; ?>&amp;src=sdkpreparse">Share</a></div>
		             	</p>                  
                 		<hr>
                        <div class="box-header">
                            <h2>Gallery</h2>
                            <div class="box-icon">
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            
                            <div id="gallery_images">   
                                <?php  $this->admin_model->get_sidebar_content('property_'.$property_id);?>
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
                        
						<?php $this->admin_model->get_featured_image('property', $property_id);?>
                        
                        </p>                  
                  </div>
				</div>

				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Property Agents</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div class="row-fluid">
							<form id="agent-add" name="agent-add" method="post" action="<?php echo site_url('/');?>property/add_property_agent">
								<input type="hidden" name="property_id"  value="<?php if(isset($property_id)){echo $property_id;}?>">
								<input type="hidden" name="agent_name" id="agent_name" value="" />
								<div class="control-group">
									<label class="control-label" for="title">Choose Agent</label>
									<div class="controls">
										<select class="span12" name="agent" onchange="document.getElementById('agent_name').value=this.options[this.selectedIndex].text">
											<option value="none">Choose an Agent</option>
											<?php echo $this->property_model->get_agent_list(); ?>
										</select>
									</div>
								</div>
								<div class="control-group">
									<button type="submit" class="btn btn-inverse btn" id="agent-butt">Add Agent</button>
								</div>
							</form>
						</div>
						<div class="row-fluid" id="agent_box">

							<?php $this->property_model->get_property_agents($property_id); ?>

						</div>
					</div>
				</div>

				<div class="box span4" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Add Property Documents</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div id="uploader">
							<p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
						</div>
						<div id="doc_msg"></div>
						<div id="documents">
							<?php $this->property_model->get_all_documents($property_id);?>
						</div>
					</div>
				</div><!--/span-->



			</div>
			
			<hr>
			
			<div class="row-fluid">

				
				
			</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		 <div class="modal hide fade" id="modal-feature-delete">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Delete Feature</h3>
			</div>
			<div class="modal-body">
				<p>The feature will be removed from the Property. This process is not reversible.</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Delete Feature</a>
			</div>
		</div>

		<div class="modal hide fade" id="modal-agent-delete">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Delete Agent</h3>
			</div>
			<div class="modal-body">
				<p>The agent will be removed from the Property. This process is not reversible.</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Delete Agent</a>
			</div>
		</div>


		<div class="modal hide fade" id="modal-doc-delete">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Delete the Document</h3>
			</div>
			<div class="modal-body">
				<div class="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Please Note!</strong> Are you sure you want to delete the current document? All document details will be removed. This proces is not reversible.
				</div>

			</div>
			<div class="modal-footer">
				<a onClick="$('#modal-doc-delete').modal('hide');" class="btn">Close</a>
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
        
        <div class="clearfix"></div>
		
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->


    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>

	<script type="text/javascript" src="https://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
	<!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
	<script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/plupload.full.js"></script>
	<script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>
    



	<script type="text/javascript">



	$(document).ready(function(){


		var money_pre = $('#money-preview');

		var temp = parseFloat($('#price').val());
		money_pre.html('N$ ' + temp.formatMoney(2, '.', ','));


		$('#price').on('input', function () {

			var temp = parseFloat($(this).val() + '.' + $('#price_c').val());
			money_pre.html('N$ ' + temp.formatMoney(2, '.', ','));

		});
		$('#price_c').on('input', function () {

			var temp = parseFloat($('#price').val() + '.' + $(this).val());
			money_pre.html('N$ ' + temp.formatMoney(2, '.', ','));

		});

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

		$('#property_date').datepicker();
		initialize();
	});


	$("#property_location").change(function() {

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/'); ?>property/get_suburb_select/'+$(this).val(),
			success: function (data) {

				$("#property_suburb").html(data);

			}
		});

	});


	$("#sub-type").change(function() {

		$.ajax({
			type: 'get',
			dataType: 'json',
			url: '<?php echo site_url('/'); ?>property/get_sub_select/'+$(this).val(),
			success: function (data) {

				$("#sub-sub-type").html(data.sub_sub_data);
				$("#sub-sub-sub-type").html(data.sub_sub_sub_data);

			}
		});

	});

	$("#sub-sub-type").change(function() {

		var sub_type = $('#sub-type').val();

		$.ajax({
			type: 'get',
			dataType: 'json',
			url: '<?php echo site_url('/'); ?>property/get_sub_sub_select/'+sub_type+'/'+$(this).val(),
			success: function (data) {

				$("#sub-sub-sub-type").html(data.sub_sub_sub_data);

			}
		});

	});


	$('#feat-butt').click(function(e) {

		e.preventDefault();
		//Validate

			var frm = $('#feature-add');
			//frm.submit();
			$('#feat-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'property/add_property_feature';?>' ,
				success: function (data) {
					$('#autosave').val('true');
					$('#doc_msg').html(data);
					$('#feat-butt').html('Add Feature');
					$("#feature-add")[0].reset();

					load_features();

				}
			});


	});

	$('#agent-butt').click(function(e) {

		e.preventDefault();
		//Validate

		var frm = $('#agent-add');
		//frm.submit();
		$('#agent-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'property/add_property_agent';?>' ,
			success: function (data) {
				$('#autosave').val('true');
				$('#agent-butt').html('Add Agent');
				$("#agent-add")[0].reset();

				load_agents();

			}
		});


	});


	function load_features(){

		$.ajax({
			cache: false,
			method: "post",
			url: "<?php echo site_url('/');?>property/load_property_features/<?php echo $property_id;?>",
			success: function(data) {
				$('#feature_box').empty();
				$('#feature_box').html(data);

			}
		});

	}

	function load_agents(){

		$.ajax({
			cache: false,
			method: "post",
			url: "<?php echo site_url('/');?>property/load_property_agents/<?php echo $property_id;?>",
			success: function(data) {
				$('#agent_box').empty();
				$('#agent_box').html(data);

			}
		});

	}


	function delete_feature(id){

		$('#modal-feature-delete').bind('show', function() {
			//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo site_url('/');?>property/delete_property_feature/"+id+"/",
					success: function(data) {

						$('footer').html(data);
						$('#modal-feature-delete').modal('hide');
						load_features();
					}
				});

			});
		}).modal({ backdrop: true });
	}


	function delete_agent(id){

		$('#modal-agent-delete').bind('show', function() {
			//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo site_url('/');?>property/delete_property_agent/"+id+"/",
					success: function(data) {

						$('footer').html(data);
						$('#modal-agent-delete').modal('hide');
						load_agents();
					}
				});

			});
		}).modal({ backdrop: true });
	}


	$('#map-butt').click(function(e) {

		e.preventDefault();

		var frm = $('#location-add');
		//frm.submit();
		$('#map-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'property/add_location_do';?>' ,
			success: function (data) {

				$('footer').html(data);
				$('#map-butt').html('Add Location');

			}
		});

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

			var sub_type = $('#sub-type option:selected').text();
			var sub_sub_type = $('#sub-sub-type option:selected').text();
			var sub_sub_sub_type = $('#sub-sub-sub-type option:selected').text()

			$('#status-type').val(sub_type);
			$('#property-type').val(sub_sub_type);
			$('#building-type').val(sub_sub_sub_type);

			var frm = $('#property-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'property/update_property_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Property');
					
				}
			});	
	
	}
	
	function attach_gallery(){
			
			var gal_id = $('#gallery_select').val();
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/update_sidebar/property/'.$property_id.'/gallery/';?>'+gal_id ,
				success: function (data) {

					load_images(gal_id);
				}
			});	
	
	}
	
	function remove_gallery(gal_id){
			
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'admin/remove_sidebar/property/'.$property_id.'/gallery/';?>'+gal_id ,
				success: function (data) {
					
					 $('#gallery_images').html(data);
				}
			});	
	
	}	
	
	
	
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The property has not been saved.';
			
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
	
		function delete_property(id){
			  
			$('#modal-property-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>property/delete_property/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-property-delete').modal('hide');
							
							window.location.href = "<?php echo site_url('/').'property/update_property/'.$next_product; ?>";
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}




	$(function() {
		function log() {
			var str = "";

			plupload.each(arguments, function(arg) {
				var row = "";

				if (typeof(arg) != "string") {
					plupload.each(arg, function(value, key) {
						// Convert items in File objects to human readable form
						if (arg instanceof plupload.File) {
							// Convert status to human readable
							switch (value) {
								case plupload.QUEUED:
									value = 'QUEUED';
									break;

								case plupload.UPLOADING:
									value = 'UPLOADING';
									break;

								case plupload.FAILED:
									value = 'FAILED';
									break;

								case plupload.DONE:
									value = 'DONE';
									break;
							}
						}

						if (typeof(value) != "function") {
							row += (row ? ', ' : '') +  value;
							$('#doc_msg').append(value)
						}
					});

					str += row + " ";
				} else {
					str += arg + " ";
				}
			});

			//$('#doc_msg').append(str);
		}




		$("#uploader").pluploadQueue({



			// General settings
			runtimes : 'silverlight,flash,gears,html5,browserplus,html4',
			url : '<?php echo site_url('/')?>property/plupload_server/documents/',
			max_file_size : '100mb',
			chunk_size : '1mb',
			unique_names : true,
			multipart_params : {"property_id" : "<?php echo $property_id; ?>"},

			// Resize images on clientside if we can
			//resize : {width : 2200, height : 240, quality : 90},

			// Specify what files to browse for
			filters : [
				{title : "Documents", extensions : "pdf,doc,docx,DOC,DOCX,PDF,xls,xlsx,XLS,jpg,JPG,jpeg,JPEG,png,PNG,GIF,gif,kmz,KMZ,kml,KML"}
			],

			// Flash settings
			flash_swf_url : '<?php echo base_url('/')?>plupload/js/plupload.flash.swf',

			// Silverlight settings
			silverlight_xap_url : '<?php echo base_url('/')?>plupload/js/plupload.silverlight.xap',

			// Post init events, bound after the internal events
			init : {


				FileUploaded: function(up, file, info) {
					// Called when a file has finished uploading
					//log( info);
					load_documents();
				},

				Error: function(up, args) {
					// Called when a error has occured
					//log('[error] ', args);
				}
			}
		});

	});


	function delete_document(id){

		$('#modal-doc-delete').bind('show', function() {
			//var id = $(this).data('id'),
			removeBtn = $(this).find('.btn-primary');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo site_url('/');?>property/delete_document/"+id+"/documents",
					success: function(data) {

						$('footer').html(data);
						$('#modal-doc-delete').modal('hide');
						window.location = "<?php echo current_url('/');?>";
					}
				});

			});
		}).modal({ backdrop: true });
	}

	function update_document(id){

		$('#modal-doc-update').bind('show', function() {

			$.ajax({
				cache: false,
				method: "post",
				url: "<?php echo site_url('/');?>property/update_document/"+id+"/documents/<?php echo rand(0,9999);?>",
				success: function(data) {
					$('#doc_update_body').empty();
					$('#doc_update_body').html(data);
					//$('#modal-doc-update').modal('hide');

				}
			});

		}).modal({ backdrop: true });
	}



	function load_documents(){

		$.ajax({
			cache: false,
			method: "post",
			url: "<?php echo site_url('/');?>property/get_all_documents/<?php echo $property_id; ?>",
			success: function(data) {
				$('#documents').empty().html(data);

				$('.datatable').dataTable({
					"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
					"sPaginationType": "bootstrap",
					"oLanguage": {
						"sLengthMenu": "_MENU_ records per page"
					}
				} );


			}
		});

	}




	function initialize() {

		var map, markers = [], myLatlng = new google.maps.LatLng( '<?php if($lat != '') { echo $lat; } else { echo '-22.5632824'; } ?>' , '<?php if($lng != '') { echo $lng; } else { echo '17.0707275'; } ?>' );
		var mapOptions = {
			zoom: 7,
			mapTypeControl: true,
			center: myLatlng,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);


		var marker = new google.maps.Marker({
			position: myLatlng,
			map: map, // handle of the map
			draggable:true
		});

		google.maps.event.addListener(
			marker,
			'drag',
			function() {
				document.getElementById('lat').value = marker.position.lat();
				document.getElementById('lng').value = marker.position.lng();
			}
		);

		// Create the search box and link it to the UI element.
		var input = /** @type {HTMLInputElement} */(
			document.getElementById('pac-input'));


		var searchBox = new google.maps.places.SearchBox(
			/** @type {HTMLInputElement} */(input));

		// Listen for the event fired when the user selects an item from the
		// pick list. Retrieve the matching places for that item.
		google.maps.event.addListener(searchBox, 'places_changed', function() {
			var places = searchBox.getPlaces();

			// For each place, get the icon, place name, and location.
			//markers = [];
			//var bounds = new google.maps.LatLngBounds();
			for (var i = 0, place; place = places[i]; i++) {

				marker.setPosition(place.geometry.location);
				map.setCenter(place.geometry.location);

				document.getElementById('lat').value = marker.position.lat();
				document.getElementById('lng').value = marker.position.lng();
				// console.log(place.geometry.location.ob);
				//markers.push(marker);

				//bounds.extend(place.geometry.location);
			}

			//map.fitBounds(bounds);
		});

		// Bias the SearchBox results towards places that are within the bounds of the
		// current map's viewport.
		google.maps.event.addListener(map, 'bounds_changed', function() {
			var bounds = map.getBounds();
			searchBox.setBounds(bounds);
		});


	}


	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}



	Number.prototype.formatMoney = function (c, d, t) {
		var n = this,
			c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
			j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};


	</script>

	<div id="fb-root"></div>
	<script>(function(d, s, id) {
			var js, fjs = d.getElementsByTagName(s)[0];
			if (d.getElementById(id)) return;
			js = d.createElement(s); js.id = id;
			js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.7&appId=287335411399195";
			fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>


</body>
</html>