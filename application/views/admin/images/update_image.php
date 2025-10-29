<?php $this->load->view('admin/inc/header');

$data['width'] = $width;
$data['height'] = $height;
$data['type'] = $type;
$data['attr'] = $attr;
$data['filename'] = base_url('/').$img;
$data['img'] = $img;
$data['url'] = $url;
$data['image'] = $_SERVER['DOCUMENT_ROOT'] . '/'.$img;

?>
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
						<a href="#">Update Image</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Update Image</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">


						<ul class="nav nav-tabs" id="myTab">
							<li class="active"><a href="#crop" data-toggle="tab">Crop Photo</a></li>
							<li><a href="#rotate" data-toggle="tab">Rotate Photo</a></li>
							<li><a href="#effects" data-toggle="tab">Photo effects</a></li>

						</ul>

						<div class="tab-content">

							<div class="tab-pane active" id="crop"><?php $this->load->view('admin/images/crop_cover', $data);?></div>
							<div class="tab-pane" id="rotate"><?php $this->load->view('admin/images/image_rotation', $data);?></div>
							<div class="tab-pane" id="effects">
								<div class="alert alert-block">
									<h3>Coming Soon</h3>
									Add some personality to your photos by adding great image effects and filters right from your my.na dashboard.
									come back soon.
								</div>
							</div>

						</div>

                                        
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
		
        
        <div class="modal hide fade" id="modal-gallery-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Gallery</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current gallery? The gallery will be removed from the content you added it to.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-gallery-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Gallery</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
			<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
        
        
	<script type="text/javascript">
		function delete_gallery(id){
			  
			$('#modal-gallery-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_gallery/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-gallery-delete').modal('hide');
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}

	</script>
</body>
</html>