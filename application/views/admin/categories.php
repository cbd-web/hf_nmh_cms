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
						<a href="#">Categories</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Categories</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats">
                  	  	<?php $this->admin_model->get_all_categories();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Category Stats</h2>
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
						<h2><i class="icon-list"></i><span class="break"></span>Add Category</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
					 <div class="clearfix" style="height:20px;"></div> 
                       <form id="category_add" name="category_add" method="post" action="<?php echo site_url('/');?>admin/add_category_do" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="post_id_cat"  value="<?php if(isset($post_id)){echo $post_id;}?>">                        
                            <div class="input-append span12">
                              <input class="span8" id="appendedInputButtons" type="text" name="category_name" placeholder="Category name..." value="">
                              <button class="btn btn-inverse btn" id="btn_cat" onClick="add_category();" type="button"><i class="icon-plus-sign icon-white"></i> Add Category</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form>
                    
                    
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

                      <p><a title="Delete the category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Category</p>
                      
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
		
        
        <div class="modal hide fade" id="modal-category-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Category</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current category? All category details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-category-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Category</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
		<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->


	<script type="text/javascript">




		function delete_category(id){
			  
			$('#modal-category-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_category/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-category-delete').modal('hide');
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}


		function add_category(){


			//Validate
			if($('#appendedInputButtons').val().length == 0){

					$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a category name"});
					$('#appendedInputButtons').popover('show');
					$('#appendedInputButtons').focus();

			}else if($('#post_id_cat').val() == ''){

				    $('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Save the Post", content:"Please add the post and then add categories"});
					$('#appendedInputButtons').popover('show');
					$('#appendedInputButtons').focus();

			}else{


				var frm = $('#category_add');
				//frm.submit();
				$('#btn_cat').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '<?php echo site_url('/').'admin/add_category_do_general';?>' ,
					success: function (data) {

						 $('#result_msg').html(data);
						 $('#btn_cat').html('<i class="icon-plus-sign icon-white"></i> Add Category');
						 reload_category();
						 var options = {'text':'Category added successfully','layout':'bottomLeft','type':'success'};
                         noty(options);
					}
				});


			}

		}


		function delete_category(id){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'admin/delete_category_main/';?>'+id ,
					success: function (data) {
					var options = {'text':'Category deleted successfully','layout':'bottomLeft','type':'success'};
                    noty(options);
					 reload_category();

					}
				});


		}
		function reload_category(){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'admin/reload_category_all/';?>' ,
					success: function (data) {

						 $('#curr_cats').html(data);
						 $('.datatable').dataTable({
							"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
							"sPaginationType": "bootstrap",
							"oLanguage": {
							"sLengthMenu": "_MENU_"
							}
						} );
					}
				});


		}
		$(document).ready(function() {

			<?php echo $this->admin_model->load_category_typehead();?>


			$('#appendedInputButtons').typeahead({source: subjects});


			// Return a helper with preserved width of cells
			var fixHelper = function(e, ui) {
				ui.children().each(function() {
					$(this).width($(this).width());
				});
				return ui;
			};

			$("#sortable tbody").sortable({
				helper: fixHelper,
				connectWith: "tr",
				start: function(e, info) {

				},
				stop: function(e, info) {

					//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
					info.item.after(info.item.parents("tr"));
					var sibs = $("#sortable tbody").find("input:hidden");

					sibs.each(function(i,item){
						var img_id = $(this).val(), index = i;
						console.log(img_id+" "+index);
						$.ajax({
							type: "post",

							url: "<?php echo site_url('/');?>admin/update_category_sequence/"+img_id+"/"+index ,
							success: function (data) {

							}
						});

					});


				}

			}).disableSelection();


		});
						

	</script>
</body>
</html>