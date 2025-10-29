<?php $this->load->view('admin/inc/header');?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCAOkM6OcNcGw_lN-l2yCSxlbxgMAxk6as&extension=.js" ></script>
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
						Update Map: <?php echo $title;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Map: <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="marker-update" name="marker-update" method="post" action="<?php echo site_url('/');?>map/update_marker_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="map_id"  value="<?php if(isset($map_id)){echo $map_id;}?>">
								 			<input type="hidden" name="marker_id"  value="<?php if(isset($marker_id)){echo $marker_id;}?>">
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
                                            <label class="control-label" for="name">Map Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Map Title" value="<?php if(isset($title)){echo $title;}?>">
                                            </div>
                                          </div>

                                      	  <div class="control-group">
                                            <label class="control-label" for="lname">Slug</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="slug" name="slug" placeholder="Slug" value="<?php if(isset($slug)){echo $slug;}?>">
                                            </div>
                                          </div>

                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Map Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"><?php if(isset($body)){echo $body;}?></textarea>
                                                </div>
                                           </div>

                                          
                                          <div id="result_msg"></div>
                                          
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Map</button>
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
			</div>
			<div class="row-fluid ">
                <div class="box span6">

					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Map Icon</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<p>

							<?php //$this->admin_model->get_featured_image('people', $people_id);?>

						</p>
					</div>


					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Markers</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<a href="<?php echo site_url('/');?>map/add_marker/<?php echo $map_id; ?>" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New Marker</a>
                  	  	<p>
						<?php echo $this->map_model->get_all_markers($map_id); ?>
                        </p>                  
                  </div>
				</div>
                
                <div class="box span6">
					<div id="mapWrapper2" style="height:600px"></div>
				</div>                
                
                
			</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->

		<div class="modal hide fade" id="modal-marker-delete">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Delete the Entry</h3>
			</div>
			<div class="modal-body">
				<div class="alert">
					<button type="button" class="close" data-dismiss="alert">&times;</button>
					<strong>Please Note!</strong> Are you sure you want to delete the current entry? All details will be removed. This process is not reversible.
				</div>

			</div>
			<div class="modal-footer">
				<a onClick="$('#modal-marker-delete').modal('hide');" class="btn">Close</a>
				<a href="#" class="btn btn-primary">Delete Entry</a>
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
			
			var frm = $('#map-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'map/update_map_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Map');
					
				}
			});	
	
	}
	
	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The map has not been saved.';
			
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
	

	</script>

	<script>


		initialize_do2();

		function initialize_do2() {

			var locations = [

				<?php echo $this->map_model->get_destination_markers($map_id); ?>

			];

			var map = new google.maps.Map(document.getElementById('mapWrapper2'), {
				zoom: 6,
				center: new google.maps.LatLng(-22.5632824, 17.0707275),
				mapTypeId: google.maps.MapTypeId.ROADMAP,
				scrollwheel: false
			});

			var infowindow = new google.maps.InfoWindow();

			var marker, i;

			for (i = 0; i < locations.length; i++) {
				marker = new google.maps.Marker({
					position: new google.maps.LatLng(locations[i][1], locations[i][2]),
					map: map
				});

				google.maps.event.addListener(marker, 'click', (function(marker, i) {
					return function() {
						infowindow.setContent(locations[i][0]);
						infowindow.open(map, marker);
					}
				})(marker, i));
			}
		}


	</script>

	<script type="text/javascript">
		function delete_marker(id,mid){

			$('#modal-marker-delete').bind('show', function() {
				//var id = $(this).data('id'),
				removeBtn = $(this).find('.btn-primary');

				removeBtn.unbind('click').click(function(e) {
					e.preventDefault();
					$.ajax({
						url: "<?php echo site_url('/');?>map/delete_marker/"+id+"/"+mid,
						success: function(data) {

							$('footer').html(data);
							$('#modal-marker-delete').modal('hide');

						}
					});

				});
			}).modal({ backdrop: true });
		}

	</script>

</body>
</html>