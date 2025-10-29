<?php $this->load->view('admin/inc/header');?>
<script type="text/javascript" src="//maps.googleapis.com/maps/api/js?v=3&sensor=false&libraries=places" ></script>
<link href="<?php echo base_url('/');?>plupload/js/jquery.plupload.queue/css/jquery.plupload.queue.css" rel="stylesheet">
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
						<a href="<?php echo site_url('/');?>itinerary/destinations/">Destinations</a><span class="divider">/</span>
					</li>
                    <li>
						Update Destinations: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Destination: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="destination-update" name="destination-update" method="post" action="<?php echo site_url('/');?>itinerary/update_destination_do" class="form-horizontal">
                             <fieldset>
								<input type="hidden" name="id" value="<?php if(isset($destination_id)){echo $destination_id;}?>">
								<input type="hidden" name="lat" id="lat" value="<?php echo $lat; ?>">
								<input type="hidden" name="lng" id="lng" value="<?php echo $lng; ?>">
								<input type="hidden" name="autosave" id="autosave"  value="true">
								<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
										  
								  <div class="control-group">
									<label class="control-label" for="title">Status</label>
									<div class="controls">
										<div class="btn-group" data-toggle="buttons-radio">
										  <button type="button" class="btn btn-primary<?php if($status == 'draft'){ echo ' active';}?>">draft</button>
										  <button type="button" class="btn btn-primary<?php if($status == 'live'){ echo ' active';}?>">live</button>
										</div>
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Title</label>
									<div class="controls">
											<input type="text" class="span6" id="title" name="title" placeholder="Destination title" value="<?php if(isset($title)){echo $title;}?>">
									</div>
								  </div>

								  <div class="control-group">
									<label class="control-label" for="title">Type</label>
									<div class="controls">
										<select name="type">
											<option value="0">Choose a Destination type</option>
											<?php echo $this->itinerary_model->get_dest_type_select($type_id); ?>
										</select>
									</div>
								  </div>
																																													  
					
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											
											<textarea  class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
										</div>
								   </div>
								   
							  	  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Video:</label>
										<div class="controls">
											<textarea  class="redactor_content loading_img" id="redactor_content" name="video" style="display:block"><?php if(isset($video)){echo $video;}?></textarea>
											<span class="help-block" style="font-size:11px">Paste the embed code from YouTube here</span> 
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
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Destination</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               </div> 
                <div class="row-fluid">
				
            
                <div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Gallery Images</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	
                         <div id="gallery_images">   
                            <?php $this->itinerary_model->load_images_update('destination', $destination_id);?>
                        </div>
                        
                                   
                  </div>
				</div>
            
				 <div class="box span6" id="gallery_cont">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add Images</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

                       
                        <div id="uploader">
                            <p>You browser doesn't have Flash, Silverlight, Gears, BrowserPlus or HTML5 support.</p>
                        </div>
		             	 
                        <div id="doc_msg"></div>
                                  
                  </div>
				</div>			            
                
			</div>
			
			<hr>
				
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
 		<div class="modal hide fade" id="modal-image-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Image</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current image? The image will be removed from the content you added it to.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-image-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Image</a>
          </div>
        </div>
        
        <div class="modal hide fade" id="modal-img-update">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Update Image</h3>
			</div>
			<div class="modal-body loading" id="img_update_body">
				 
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
			</div>
		</div>      
        
        <div class="clearfix"></div>
		
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->

        <!-- Third party script for BrowserPlus runtime (Google Gears included in Gears runtime now) -->
    <script type="text/javascript" src="http://bp.yahooapis.com/2.4.21/browserplus-min.js"></script>
    
    <!-- Load plupload and all it's runtimes and finally the jQuery queue widget -->
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/plupload.full.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/')?>plupload/js/jquery.plupload.queue/jquery.plupload.queue.js"></script>


    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    

	<script type="text/javascript">
	
	$(document).ready(function(){
		
		initialize(); 
		
		$('div.btn-group button').live('click', function(){
			
			$('#status').attr('value', $(this).html());
		});		
	
		$('input').change(function() {
	
		  $('#autosave').val('false');
		});
		$('.redactor_box').live('click', function() {
	
		  $('#autosave').val('false');
		});

		
		/* ---------- Text Editor ---------- */
		$('.redactor_content').redactor({ 	
					fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
					imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', 'underline',  '|', 
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
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a product title"});
				$('#title').popover('show');
				$('#title').focus();

		}else{
	
			submit_form();
			
		}
	});
		
	
	function submit_form(){
			
		var frm = $('#destination-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'itinerary/update_destination_do';?>' ,
			success: function (data) {
				 $('#autosave').val('true');
				 $('#result_msg').html(data);
				 $('#butt').html('Update Destination');
				
			}
		});
	}
			
	window.onbeforeunload = function() {		 
		 if($('#autosave').val() == 'false'){
			return 'The destination has not been saved.';
		 }
	};
	

	function load_maps_js(){ 
		initialize(); console.log('hi'); 
	}	


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
	
		<?php //$info = $this->itinerary_model->get_images('destination', $destination_id); ?>
		
		$("#uploader").pluploadQueue({
			// General settings
			runtimes : 'html5,gears,flash,silverlight,browserplus,html4',
			url : '<?php echo site_url('/')?>itinerary/add_images/',
			max_file_size : '10mb',
			chunk_size : '1mb',
			unique_names : true,
			multipart_params: {type_id : '<?php echo $destination_id; ?>',type : 'destination'},
	
			// Resize images on clientside if we can
			resize : {width : 800, height : 600, quality : 90},
	
			// Specify what files to browse for
			filters : [
				{title : "Images", extensions : "jpg,JPG,jpeg,gif,GIF,png,PNG"}
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
					load_images();
				},
	
				Error: function(up, args) {
					// Called when a error has occured
					//log('[error] ', args);
				}
			}
		});
	});
	
	
	function load_images(){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>itinerary/load_images_update/destination/<?php echo $destination_id; ?>/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#gallery_images').empty();
			  $('#gallery_images').html(data);

			}
		  });			
			
	}
	function delete_image(id){
			  
			$('#modal-image-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>itinerary/delete_image/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-image-delete').modal('hide');
							 load_images();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		

	
	function update_image(id){
			  
			$('#modal-img-update').bind('show', function() {
					
					  $.ajax({
						cache: false, 
						method: "post",
						url: "<?php echo site_url('/');?>itinerary/update_image/"+id+"/<?php echo rand(0,9999);?>",
						success: function(data) {
						  $('#img_update_body').empty();
						  $('#img_update_body').html(data);
						  //$('#modal-doc-update').modal('hide');
						  
						}
					});
					
			}).modal({ backdrop: true });
	}
	
	$('#modal-img-update').on('hidden', function () {
		$('#modal-img-update').unbind('show'); // or $(this)        
	});

	$('#modal-image-delete').on('hidden', function () {
		$('modal-image-delete').unbind('show'); // or $(this)        
	});
	
	
	
	</script>
</body>
</html>