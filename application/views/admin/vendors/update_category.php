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
						<a href="<?php echo site_url('/');?>vendor/categories">Categories</a><span class="divider">/</span>
					</li>
                    <li>
						Update Category: <?php echo $cat_name; ?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Category: <?php echo $cat_name; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="category-update" name="category-update" method="post" action="<?php echo site_url('/');?>vendor/update_category_do" class="form-horizontal">
                             <fieldset>
    										<input type="hidden" name="cat_id"  value="<?php if(isset($cat_id)){echo $cat_id;}?>">
                                            <input type="hidden" name="autosave" id="autosave"  value="true">

										  
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="cat_name" placeholder="Category title" value="<?php if(isset($cat_name)){echo $cat_name;}?>">
                                            </div>
                                          </div>

                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Category Description:</label>
                                                <div class="controls">
                                                    
                                                    <textarea  class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($cat_body)){echo $cat_body;} ?></textarea>
                                                </div>
                                           </div>
										   
                                          
                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Category</button>
								 		  <a href="#myGroup" role="button" class="btn btn-inverse btn pull-left" data-toggle="modal">Add New Features Group</a>


                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               </div>

                <div class="row-fluid">

					<?php echo $this->vendor_model->get_cat_groups($cat_id); ?>

				</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
       
        
        <div class="clearfix"></div>

		<div id="myGroup" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3>Add Feature Group</h3>
			</div>
			<div class="modal-body">
				<form id="group-add" name="group-add" method="post" action="<?php echo site_url('/');?>vendor/add_group">
					<fieldset>
						<input type="hidden" name="cat_id"  value="<?php if(isset($cat_id)){echo $cat_id;}?>">

						<div class="control-group">
							<label class="control-label" for="title">Group Title</label>
							<div class="controls">
								<input type="text" id="group_title" name="title" placeholder="Group Title" style="width:90%">
							</div>
						</div>


						<div id="result_msg"></div>
						<button type="submit" class="btn btn-inverse btn" id="group-butt">Add Group</button>


					</fieldset>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
			</div>
		</div>

		
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->


	<div class="modal hide fade" id="modal-type-delete">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Delete Group Type</h3>
		</div>
		<div class="modal-body">
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
			</div>

		</div>
		<div class="modal-footer">
			<a onClick="$('#modal-type-delete').modal('hide');" class="btn">Close</a>
			<a href="#" class="btn btn-primary del_btn">Delete Group Type</a>
		</div>
	</div>


	<div class="modal hide fade" id="modal-group-delete">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			<h3>Delete Group</h3>
		</div>
		<div class="modal-body">
			<div class="alert">
				<button type="button" class="close" data-dismiss="alert">&times;</button>
				<strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
			</div>

		</div>
		<div class="modal-footer">
			<a onClick="$('#modal-group-delete').modal('hide');" class="btn">Close</a>
			<a href="#" class="btn btn-primary group_del_btn">Delete Group</a>
		</div>
	</div>


    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    

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


	$('#group-butt').click(function(e) {


		e.preventDefault();
		//Validate
		if($('#group_title').val().length == 0){

			$('#group_title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a group title"});
			$('#group_title').popover('show');
			$('#group_title').focus();



		}else{

			var frm = $('#group-add');
			//frm.submit();
			$('#group-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'vendor/add_group';?>' ,
				success: function (data) {

					$('#butt').html('Add Group');
					$('#myGroup').modal('toggle');
					location.reload();

				}
			});

		}
	});


	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a category title"});
				$('#title').popover('show');
				$('#title').focus();
			
					
			
		}else{
	
			submit_form();
			
		}
	});

	
	
	function submit_form(){
			
			var frm = $('#category-update');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'vendor/update_category_do';?>' ,
				success: function (data) {
					 $('#autosave').val('true');
					 $('#result_msg').html(data);
					 $('#butt').html('Update Category');
					
				}
			});	
	
	}


	function delete_group(id){

		$('#modal-group-delete').bind('show', function() {

			removeBtn = $(this).find('.group_del_btn');

			removeBtn.unbind('click').click(function(e) {
				e.preventDefault();
				$.ajax({
					url: "<?php echo site_url('/');?>vendor/delete_group/"+id+"/",
					success: function(data) {

						$('footer').html(data);
						$('#modal-group-delete').modal('hide');
						location.reload();

					}
				});

			});
		}).modal({ backdrop: true });
	}

	
	window.onbeforeunload = function() {
   		 
		 if($('#autosave').val() == 'false'){
			return 'The category has not been saved.';
			
		 }
		 
	};

		
	
	</script>
</body>
</html>