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

						<a href="#">Sidebars</a>

					</li>

				</ul>

				<hr>

			</div>

			

			<div class="row-fluid sortable">

				<div class="box span8">

					<div class="box-header">

						<h2><i class="icon-th"></i><span class="break"></span>All Sidebars</h2>

						<div class="box-icon">

							<a href="#" class="btn-close"><i class="icon-remove"></i></a>

						</div>

					</div>

					<div class="box-content" id="curr_cats">

                  	  	<?php $this->admin_model->get_all_sidebars();?>

                                        

                  </div>

				</div>

                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">

					<div class="box-header">

						<h2><i class="icon-list"></i><span class="break"></span>Sidebar Stats</h2>

						<div class="box-icon">

							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>

							<a href="#" class="btn-close"><i class="icon-remove"></i></a>

						</div>

					</div>

					<div class="box-content">

					<?php //$this->google_model->load_overview();?>

					</div>

				</div><!--/span-->

                

  

                

                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">

					<div class="box-header">

						<h2><i class="icon-list"></i><span class="break"></span>Legend</h2>

						<div class="box-icon">

							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>

							<a href="#" class="btn-close"><i class="icon-remove"></i></a>

						</div>

					</div>

					<div class="box-content">

 

                     <div class="well">



                      <p><a title="Delete the sidebar" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Sidebar</p>

                      

					</div>

                    <a onClick="add_sidebar()" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New Sidebar</a> 

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

				

		<div class="modal hide fade" id="modal-add">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h3>Add System sidebar</h3>

          </div>

          <div class="modal-body">

            <form id="sidebar-add" name="sidebar-add" method="post" action="<?php echo site_url('/');?>admin/add_sidebar_do" class="form-horizontal">
            
             <div class="control-group">
                  <label class="control-label" for="title">Sidebar Title</label>
                <div class="controls">
                   <input type="text" id="title" name="sidebar_title" placeholder="Sidebar Title" value="">
                   <span class="help-block" style="font-size:11px">The title of the sidebar to help you identify it</span>                    
                </div>
              </div>
			  <div class="control-group">
			 		<h5>Sidebar Type</h5>
					<select name="sidebar_type" id="sidebar_type">
						<option value="">None</option>
						<option value="gallery">Gallery</option>
						<option value="downloads">Downloads</option>
						<option value="contact">Contact</option>
						<option value="feature_image">Feature Image</option>
					</select>
			  </div>
			  
			  <div class="control-group" id="sidebar_div" style="display:none">
			 		<h5>Select Gallery</h5>
					<?php echo $this->admin_model->get_select_gallery(); ?>
			  </div>			  
			  			  
              <div class="control-group">
                	<h5>Sidebar HTML</h5>
                   <textarea id="sidebar" name="sidebar_content"></textarea>                    
                
              </div>

            </form>


          </div>

          <div class="modal-footer">

            <a onClick="$('#modal-add').modal('hide');" class="btn">Close</a>

            <a href="#" class="btn btn-primary">Add sidebar</a>

          </div>

        </div>

        

        <div class="modal hide fade" id="modal-sidebar-delete">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h3>Delete the Sidebar</h3>

          </div>

          <div class="modal-body">

            <div class="alert">

                <button type="button" class="close" data-dismiss="alert">&times;</button>

                 <strong>Please Note!</strong> Are you sure you want to delete the current sidebar? All sidebar details will be removed. This proces is not reversible.

            </div>

        

          </div>

          <div class="modal-footer">

            <a onClick="$('#modal-sidebar-delete').modal('hide');" class="btn">Close</a>

            <a href="#" class="btn btn-primary">Delete Sidebar</a>

          </div>

        </div>

        <div class="modal hide fade" id="modal-update">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h3>Update Sidebar</h3>

          </div>

          <div class="modal-body" id="update_content">

            

          </div>

          <div class="modal-footer">

            <a onClick="$('#modal-update').modal('hide');" class="btn">Close</a>

            <a onClick="update_sidebar_do()" id="update_sidebar_btn" class="btn btn-primary">Update sidebar</a>

          </div>

        </div>

        <div class="clearfix"></div>



	<?php $this->load->view('admin/inc/footer');?>

	</div><!--/.fluid-container-->

	<script type="text/javascript">
	
	$(document).ready(function(e) {
		

			
		$('#sidebar_type').on('change', function(){
					
					if($(this).val() == 'gallery'){
						
						$('#sidebar_div').slideDown();
						
					}else{
						
						$('#sidebar_div').slideUp();
						
					}
					
		});





			/* ---------- Text Editor ---------- */
			$('#sidebar').redactor({
						fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
						imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
						imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
						buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
						'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
						'video','file', 'table', 'link','|',
						 'alignment', '|', 'horizontalrule']
			});



			$('div.btn-group button').live('click', function(){
				
				$('#status_edit').attr('value', $(this).html());
			});   
	    
    });
		
		
		function delete_sidebar(id){


			$('#modal-sidebar-delete').bind('show', function() {

				//var id = $(this).data('id'),

					removeBtn = $(this).find('.btn-primary');

						

					removeBtn.unbind('click').click(function(e) { 

						e.preventDefault();	

						$.ajax({

						  url: "<?php echo site_url('/');?>admin/delete_sidebar/"+id+"/",

						  success: function(data) {

							

							$('footer').html(data);

							$('#modal-sidebar-delete').modal('hide');

							window.location = '<?php echo site_url('/');?>admin/sidebars';

						  }

						});

						

					});

			}).modal({ backdrop: true });

		}

		function add_sidebar(){

			  $('#modal-add').bind('show', function() {

					  var removeBtn = $(this).find('.btn-primary');

					  removeBtn.unbind('click').click(function(e) { 

						  e.preventDefault();

						  var frm = $('#sidebar-add');

						  removeBtn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');

						  $.ajax({

							type: "post",

							data: frm.serialize(),

							url: "<?php echo site_url('/');?>admin/add_sidebar_do",

							success: function(data) {

							  removeBtn.html('Add Sidebar');

							  $('#msg').html(data);

							  $('#modal-add').modal('hide');

							  window.location = '<?php echo site_url('/');?>admin/sidebars';

							}

						  });

						  

					  });

			  }).modal({ backdrop: true });

			  

		  }			

		  

		  function update_sidebar(id){

			  $('#modal-update').bind('show', function() {

						  $.ajax({

							type: "get",

							url: "<?php echo site_url('/');?>admin/get_sidebar/"+id,

							success: function(data) {

							  $('#update_content').html(data);

							}

						  });
	  

			  }).modal({ backdrop: true });

		  }

		  function update_sidebar_do(){

					var frm = $('#sidebar-update');

					$('#update_sidebar_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');

					$.ajax({

					  type: "post",

					  data: frm.serialize(),

					  url: "<?php echo site_url('/');?>admin/update_sidebar_do",

					  success: function(data) {

						

						$('#update_sidebar_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Update Sidebar');

						$('#msg').html(data);

						$('#modal-update').modal('hide');

						window.location = '<?php echo site_url('/');?>admin/sidebars';

					  }

					});



		  }
		  
		  


	</script>

</body>

</html>