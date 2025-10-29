<?php $this->load->view('admin/inc/header');?>
<script type='text/javascript' src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery-ui-1.10.3.custom.min.js"></script>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places" ></script>
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
						Update Vendor: <?php echo $title; ?>
					</li>
				</ul>
				<hr>
			</div>

			<div class="row-fluid sortable">


				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Vendor: <?php echo $title; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<p>
						<form id="vendor-update" name="vendor-update" method="post" action="<?php echo site_url('/');?>vendor/update_vendor_do" class="form-horizontal">
							<fieldset>
								<input type="hidden" name="vendor_id"  value="<?php if(isset($vendor_id)){echo $vendor_id;}?>">
								<input type="hidden" name="autosave" id="autosave"  value="true">
								<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">

								<div class="control-group">
									<label class="control-label" for="status">Status</label>
									<div class="controls">
										<div class="btn-group" data-toggle="buttons-radio">
											<button type="button" class="btn btn-primary status<?php if($status == 'draft'){ echo ' active';}?>">draft</button>
											<button type="button" class="btn btn-primary status<?php if($status == 'live'){ echo ' active';}?>">live</button>
										</div>
									</div>
								</div>



								<div class="control-group">
									<label class="control-label" for="sale_price">Featured Vendor</label>
									<div class="controls">
										<input name="featured" type="checkbox" value="Y" <?php if($featured == 'Y') { echo "checked"; } ?>>
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="name">Vendor Name</label>
									<div class="controls">
										<input type="text" class="span6" id="title" name="title" placeholder="Vendor Name" value="<?php if(isset($title)){echo $title;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="type_s">Vendor Category</label>
									<div class="controls">
										<select name="cat_id" id="cat-change">
											<?php echo $this->vendor_model->get_all_vendor_cat_option($cat_id); ?>
										</select>
										<div id="cat-loader"></div>
									</div>

								</div>

								<div id="curr-types"><?php echo $this->vendor_model->get_vendor_groups($cat_id, $vendor_id); ?></div>


								<div class="control-group">
									<label class="control-label" for="price_from">Price Range From (N$)</label>
									<div class="controls">
										<input type="text" class="span6" id="price_from" name="price_from" placeholder="Price Range From" value="<?php if(isset($price_from)){echo $price_from;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="price_to">Price Range To (N$)</label>
									<div class="controls">
										<input type="text" class="span6" id="price_to" name="price_to" placeholder="Price Range To" value="<?php if(isset($price_to)){echo $price_to;}?>">
									</div>
								</div>


								<div class="control-group">
									<label class="control-label" for="tel">Telephone Number</label>
									<div class="controls">
										<input type="text" class="span6" id="tel" name="tel" placeholder="Telephone Number" value="<?php if(isset($tel)){echo $tel;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="cell">Cellphone Number</label>
									<div class="controls">
										<input type="text" class="span6" id="cell" name="cell" placeholder="Cellphone Number" value="<?php if(isset($cell)){echo $cell;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="fax">Fax Number</label>
									<div class="controls">
										<input type="text" class="span6" id="fax" name="fax" placeholder="Fax Number" value="<?php if(isset($fax)){echo $fax;}?>">
									</div>
								</div>


								<div class="control-group">
									<label class="control-label" for="email">Email</label>
									<div class="controls">
										<input type="text" class="span6" id="email" name="email" placeholder="Email" value="<?php if(isset($email)){echo $email;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="website">Website URL</label>
									<div class="controls">
										<input type="text" class="span6" id="website" name="website" placeholder="Website URL" value="<?php if(isset($website)){echo $website;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="postal">Postal Address</label>
									<div class="controls">
										<input type="text" class="span6" id="postal" name="postal" placeholder="Postal Address" value="<?php if(isset($postal)){echo $postal;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="address">Physical Address</label>
									<div class="controls">
										<input type="text" class="span6" id="address" name="address" placeholder="Physical Address" value="<?php if(isset($address)){echo $address;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="type_s">Vendor Region</label>
									<div class="controls">
										<select name="region">
											<?php echo $this->vendor_model->get_region_option($region); ?>
										</select>
									</div>
								</div>


								<div class="control-group">
									<label class="control-label" for="type_s">Vendor Town</label>
									<div class="controls">
										<select name="town">
											<?php echo $this->vendor_model->get_town_option($town); ?>
										</select>
									</div>
								</div>


								<div class="control-group">
									<label class="control-label" for="facebook">Facebook</label>
									<div class="controls">
										<input type="text" class="span6" id="facebook" name="facebook" placeholder="Facebook" value="<?php if(isset($facebook)){echo $facebook;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="google_plus">Google Plus</label>
									<div class="controls">
										<input type="text" class="span6" id="google_plus" name="google_plus" placeholder="Google Plus" value="<?php if(isset($google_plus)){echo $google_plus;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="instagram">Instagram</label>
									<div class="controls">
										<input type="text" class="span6" id="instagram" name="instagram" placeholder="Instagram" value="<?php if(isset($instagram)){echo $instagram;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="youtube">YouTube</label>
									<div class="controls">
										<input type="text" class="span6" id="youtube" name="youtube" placeholder="YouTube" value="<?php if(isset($youtube)){echo $youtube;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="twitter">Twitter</label>
									<div class="controls">
										<input type="text" class="span6" id="twitter" name="twitter" placeholder="Twitter" value="<?php if(isset($twitter)){echo $twitter;}?>">
									</div>
								</div>

								<div class="control-group">
									<label class="control-label" for="flickr">Flickr</label>
									<div class="controls">
										<input type="text" class="span6" id="flickr" name="flickr" placeholder="Flickr" value="<?php if(isset($flickr)){echo $flickr;}?>">
									</div>
								</div>


								<div class="control-group">
									<label class="control-label" for="pinterest">Pinterest</label>
									<div class="controls">
										<input type="text" class="span8" id="pinterest" name="pinterest" placeholder="Pinterest" value="<?php if(isset($pinterest)){echo $pinterest;}?>">
									</div>
								</div>

								<div class="control-group" id="redactor_content_msg">
									<label class="control-label" for="redactor_content">Vendor Body</label>
									<div class="controls">

										<textarea id="redactor_content" class="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
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

								<button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Vendor</button>
							</fieldset>
						</form>
						</p>
					</div>
				</div>
			</div>


			<div class="row-fluid sortable">
				<div class="box-header">
					<h2><i class="icon-th"></i><span class="break"></span>Vendor Features</h2>
					<div class="box-icon">
						<a href="#" class="btn-close"><i class="icon-remove"></i></a>
					</div>
				</div>
				<div class="box-content">

					<div class="control-group">
						<a href="#myFeature" role="button" class="btn btn-inverse btn" data-toggle="modal">Add Vendor Feature</a>
					</div>

					<div id="curr-features">
						<?php echo $this->vendor_model->get_vendor_features($vendor_id); ?>
					</div>

				</div>
			</div>

			<div class="row-fluid sortable">


				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured Logo</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<p>

							<?php $this->admin_model->get_featured_logo('vendor_logo', $vendor_id);?>

						</p>
					</div>

				</div>

				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Featured Cover</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<p>

							<?php $this->admin_model->get_featured_image('vendor_cover', $vendor_id);?>

						</p>
					</div>
					<hr>
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Vendor Gallery</h2>
						<div class="box-icon">

						</div>
					</div>
					<div class="box-content">

						<div class="box-content">

							<div id="gallery_images">
								<?php $this->admin_model->get_sidebar_content('vendor_'.$vendor_id);?>
							</div>


							<div id="doc_msg"></div>
						</div>

					</div>

				</div>


				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Location Map</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<form id="map-update" name="map-update" method="post" action="<?php echo site_url('/');?>vendor/update_map">
							<input type="hidden" name="lat" id="lat" value="<?php echo $lat; ?>">
							<input type="hidden" name="lng" id="lng" value="<?php echo $lng; ?>">
							<input type="hidden" name="vendor_id"  value="<?php echo $vendor_id; ?>">
						<div class="control-group">
							<label class="control-label" for="title">Location</label>
							<div class="controls">
								<input type="text" class="span6" id="pac-input">
							</div>
						</div>


						<div class="control-group" id="map-canvas" style="height:400px">


						</div>
							<button type="submit" class="btn btn-inverse btn" id="map-butt">Update Map</button>
						</form>
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

	<div class="modal hide fade" id="myFeature">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Add Vendor Feature</h3>
		</div>
		<div class="modal-body">
			<div class="row-fluid">
				<form id="add-feature" name="add-feature" method="post" action="<?php echo site_url('/');?>vendor/add_vendor_feature">
					<input type="hidden" name="vendor_id"  value="<?php if(isset($vendor_id)){echo $vendor_id;}?>">
					<div class="control-group">
						<label class="control-label" for="name">Feature Title</label>
						<div class="controls">
							<input type="text" class="span12" id="f_title" name="title" placeholder="Feature Title">
						</div>
					</div>
					<div class="control-group" id="redactor_content_msg">
						<label class="control-label" for="redactor_content">Feature Body</label>
						<div class="controls">

							<textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
						</div>
					</div>
					<button type="submit" class="btn btn-inverse btn" id="feat-butt">Add Feature</button>
				</form>
			</div>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
		</div>
	</div>



	<div class="modal hide fade" id="modal-feature-delete">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Delete Vendor Feature</h3>
		</div>
		<div class="modal-body">
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
			</div>

		</div>
		<div class="modal-footer">
			<a onClick="$('#modal-feature-delete').modal('hide');" class="btn">Close</a>
			<a href="#" class="btn btn-primary del_feat_btn">Delete Feature</a>
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


	$('#cat-change').on('change', function() {

		var cid = this.value;

		$('#cat-loader').html('<img src="<?php echo base_url('/').'admin_src/img/spinner-mini.gif';?>" /> Working...');

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'vendor/reload_vendor_cat_types/'.$vendor_id.'/'; ?>'+cid ,
			success: function (data) {

				$('#curr-types').html(data);

				$('#cat-loader').html('');
			}
		});

	});


	$('#map-butt').bind('click' , function(e) {


		e.preventDefault();

		var frm = $('#map-update');
		//frm.submit();
		$('#map-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'vendor/update_map';?>' ,
			success: function (data) {
				$('#result_msg').html(data);
				$('#map-butt').html('Update Map');

			}
		});


	});

	$('#feat-butt').bind('click' , function(e) {


		e.preventDefault();

		var frm = $('#add-feature');
		//frm.submit();
		$('#feat-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'vendor/add_vendor_feature';?>' ,
			success: function (data) {
				$('#result_msg').html(data);
				$('#feat-butt').html('Add Feature');
				$('#myFeature').modal('toggle');

				reload_features();

			}
		});


	});


	$('#butt').bind('click' , function(e) {


		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){

			$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a title"});
			$('#title').popover('show');
			$('#title').focus();

		}else{

			submit_form();

		}
	});

	$('div.btn-group button.status').live('click', function(){

		$('#status').attr('value', $(this).html());
	});


	function submit_form(){

		var frm = $('#vendor-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'vendor/update_vendor_do';?>' ,
			success: function (data) {
				$('#autosave').val('true');
				$('#result_msg').html(data);
				$('#butt').html('Update Vendor');

			}
		});

	}


	window.onbeforeunload = function() {

		if($('#autosave').val() == 'false'){
			return 'The vendor has not been saved.';

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


	//Featured Logo
	$('#logobut').bind('click', function() {


		var avataroptions = {
			target:        '#avatar_msg2',
			url:       	   '<?php echo site_url('/').'admin/add_featured_logo';?>' ,
			beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
			uploadProgress: function(event, position, total, percentComplete) {
				var percentVal = percentComplete + '%';
				probar.width(percentVal)

			},
			complete: function(xhr) {
				procover.hide();
				probar.width('0%');
				$('#avatar_msg2').html(xhr.responseText);
				$('#logobut').html('Update Logo');
			}

		};

		var frm = $('#add-logo');
		var probar = $('#procover2 .bar');
		var procover = $('#procover2');

		$('#logobut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
		procover.show();
		frm.ajaxForm(avataroptions);
		$('#autosave').val('true');
	});


	function attach_gallery(){

		var gal_id = $('#gallery_select').val();

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/update_sidebar/vendor/'.$vendor_id.'/gallery/';?>'+gal_id ,
			success: function (data) {

				load_images(gal_id);
			}
		});

	}

	function remove_gallery(gal_id){

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/remove_sidebar/vendor/'.$vendor_id.'/gallery/';?>'+gal_id ,
			success: function (data) {

				$('#gallery_images').html(data);
			}
		});

	}

	function delete_feature(id){

		$('#modal-feature-delete').bind('show', function() {

			removeBtn = $(this).find('.del_feat_btn');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: '<?php echo site_url('/'); ?>vendor/delete_vendor_feature/'+id,
					success: function(data) {

						$('footer').html(data);
						$('#modal-feature-delete').modal('hide');

						$('#tab-'+id).remove();

					}
				});

			});

		}).modal({ backdrop: true });
	}


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

	function reload_features(){

		$.ajax({
			cache: false,
			method: "get",
			url: "<?php echo site_url('/');?>vendor/reload_vendor_features/<?php echo $vendor_id; ?>",
			success: function(data) {

				$('#curr-features').html(data);

			}
		});

	}


</script>

<script>


	initialize();

	function initialize() {

		var map, markers = [], myLatlng = new google.maps.LatLng( '<?php echo $lat; ?>' , '<?php echo $lng; ?>' );
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
</script>
</body>
</html>