<?php $this->load->view('admin/inc/header');?>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3&libraries=places&key=AIzaSyCjLvWeVU2ZciTQlr9tRAzeveUTpt21IB8" ></script>
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
						<a href="<?php echo site_url('/');?>map/maps/">Maps</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>map/maps/update_map/<?php echo $map_id; ?>">Update Map</a><span class="divider">/</span>
					</li>
                    <li>
						Add New Map
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Map</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="marker-add" name="marker-add" method="post" action="<?php echo site_url('/');?>map/add_marker_do" class="form-horizontal">
							<input type="hidden" name="lat" id="lat" value="">
							<input type="hidden" name="lng" id="lng" value="">
							<input type="hidden" value="<?php echo $map_id; ?>" name="map_id">
                             <fieldset>

                                          <div class="control-group">
                                            <label class="control-label" for="name">Marker Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Map Title" value="">
                                            </div>
                                          </div>
                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Marker Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
                                                </div>
                                           </div>

										 <div class="control-group">
											 <label class="control-label" for="title">Location</label>
											 <div class="controls">
												 <input type="text" class="span6" id="pac-input">
											 </div>
										 </div>


										 <div class="control-group" id="map-canvas" style="height:400px">


										 </div>
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Marker</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               
               <div class="box span4">

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
	
	$('#butt').click(function(e) {
	
		
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
	
	
	function submit_form(){
			
			var frm = $('#marker-add');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'map/add_marker_do';?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Marker');
					
				}
			});	
	
	}


		initialize();

		function initialize() {

			var map, markers = [], myLatlng = new google.maps.LatLng( '-22.5632824' , '17.0707275' );
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