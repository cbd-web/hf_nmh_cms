<?php $this->load->view('admin/inc/header');?>
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
						<a href="<?php echo site_url('/');?>itinerary/tours/">Tours</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>itinerary/update_tour/<?php echo $tour_id ?>">Update Tour</a><span class="divider">/</span>
					</li>					
                    <li>
						Update Tour Itinerary: <?php echo $this->itinerary_model->get_title('i_tours','tour_id',$tour_id); ?> : <?php echo $this->itinerary_model->get_title('i_tour_types','type_id',$type_id); ?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Tour Itinerary: <?php echo $this->itinerary_model->get_title('i_tours','tour_id',$tour_id); ?> : <?php echo $this->itinerary_model->get_title('i_tour_types','type_id',$type_id); ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="itinerary-update" name="itinerary-update" method="post" action="<?php echo site_url('/');?>itinerary/update_itinerary_do" class="form-horizontal">
                             <fieldset>
								<input type="hidden" name="id" value="<?php if(isset($itinerary_id)){echo $itinerary_id;}?>">
								<input type="hidden" name="tour_id" value="<?php if(isset($tour_id)){echo $tour_id;}?>">
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
								  																																			  
					
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											<textarea  class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
										</div>
								   </div>
								   
								   
							  	  <div class="control-group">
									<label class="control-label" for="title">Price Heading</label>
									<div class="controls">
										<input type="text" class="span6" id="price_heading" name="price_heading" placeholder="Price Heading" value="<?php if(isset($price_heading)){echo $price_heading;}?>">
									</div>
								  </div>								   
								   
								  <div class="control-group">
									<label class="control-label" for="title">Pricing Disclarity</label>
									<div class="controls">
										<textarea  class="redactor_content loading_img" id="redactor_content" name="valid" style="display:block"><?php if(isset($valid)){echo $valid;}?></textarea>
									</div>
								  </div>
										
								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Itinerary</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               </div> 
			   
			   
			<div class="row-fluid">
            
            
				<div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Itinerary Days</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  		<?php echo $this->itinerary_model->get_days($itinerary_id); ?>
						<a href="<?php echo site_url('/');?>itinerary/add_day/<?php echo $tour_id; ?>/<?php echo $itinerary_id; ?>/<?php echo $type_id; ?>" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New Day</a> 
                    </div>
				 </div>
				 
				<div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Itinerary Prices</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<div id="curr_cats">
						<?php echo $this->itinerary_model->get_itinerary_prices($itinerary_id); ?>
						<a href="<?php echo site_url('/');?>itinerary/add_price/<?php echo $tour_id; ?>/<?php echo $itinerary_id; ?>" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add Price</a>
						</div>
                    </div>
				 </div>				 
				 
				 
               </div> 			   
			   
			   
			   
                <div class="row-fluid">
				
            
                <div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Itinerary Documents</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	
                         <div id="list_documents">   
                            <?php $this->itinerary_model->load_documents_update($itinerary_id);?>
                        </div>
                        
                                   
                  </div>
				</div>
            
				 <div class="box span6">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add Documents</h2>
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
				
 		<div class="modal hide fade" id="modal-doc-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Document</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current document? The document will be removed from the content you added it to.
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
		
		
        <div class="modal hide fade" id="modal-price-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Itinerary Price</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-price-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Itinerary Price</a>
          </div>
        </div>	
		
		
        <div class="modal hide fade" id="modal-day-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Itinerary Day</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-day-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Tour Itinerary</a>
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
	
		submit_form();
			
	});
		
	
	function submit_form(){
			
		var frm = $('#itinerary-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'itinerary/update_itinerary_do';?>' ,
			success: function (data) {
				 $('#autosave').val('true');
				 $('#result_msg').html(data);
				 $('#butt').html('Update Itinerary');
				
			}
		});
	}
			
	window.onbeforeunload = function() {		 
		 if($('#autosave').val() == 'false'){
			return 'The itinerary has not been saved.';
		 }
	};
	
	
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
	
		<?php //$info = $this->itinerary_model->get_images('tour', $tour_id); ?>
		
		$("#uploader").pluploadQueue({
			
			// General settings
			runtimes : 'silverlight,flash,gears,html5,browserplus,html4',
			url : '<?php echo site_url('/')?>itinerary/plupload_server/',
			max_file_size : '100mb',
			chunk_size : '1mb',
			unique_names : true,
			multipart_params : {"tour_id" : "<?php echo $tour_id ?>","itinerary_id" : "<?php echo $itinerary_id ?>"},
	
			// Resize images on clientside if we can
			//resize : {width : 2200, height : 240, quality : 90},
	
			// Specify what files to browse for
			filters : [
				{title : "Documents", extensions : "pdf,doc,docx,DOC,DOCX,PDF,xls,xlsx,XLS"}
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
	
	
	function load_documents(){
	  
		  $.ajax({
			cache: false,
			method: "post",  
			url: "<?php echo site_url('/');?>itinerary/load_documents_update/<?php echo $itinerary_id; ?>/<?php echo rand(0,9999);?>",
			success: function(data) {
			  $('#list_documents').empty();
			  $('#list_documents').html(data);

			}
		  });			
			
	}
	function delete_doc(id){
			  
			$('#modal-doc-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>itinerary/delete_document/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-doc-delete').modal('hide');
							 load_documents();
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
		

	
		function update_doc(id){
				  
				$('#modal-doc-update').bind('show', function() {
						
						  $.ajax({
							cache: false, 
							method: "post",
							url: "<?php echo site_url('/');?>itinerary/update_document/"+id+"/<?php echo rand(0,9999);?>",
							success: function(data) {
							  $('#doc_update_body').empty();
							  $('#doc_update_body').html(data);
							  //$('#modal-doc-update').modal('hide');
							  
							}
						});
						
				}).modal({ backdrop: true });
		}	
	
			
			
			function delete_price(id){
				  
				$('#modal-price-delete').bind('show', function() {
					//var id = $(this).data('id'),
						removeBtn = $(this).find('.btn-primary');
							
						removeBtn.unbind('click').click(function(e) { 
							e.preventDefault();	
							$.ajax({
							  url: "<?php echo site_url('/');?>itinerary/delete_price/"+id+"/",
							  success: function(data) {
								
								$('footer').html(data);
								$('#modal-price-delete').modal('hide');
								
								$("#row-"+id).remove();
								
							  }
							});
							
						});
				}).modal({ backdrop: true });
			}
		
			
			function reload_prices(id){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'itinerary/reload_prices_all/';?>'+id ,
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

			function delete_day(id){
				  
				$('#modal-day-delete').bind('show', function() {
					//var id = $(this).data('id'),
						removeBtn = $(this).find('.btn-primary');
							
						removeBtn.unbind('click').click(function(e) { 
							e.preventDefault();	
							$.ajax({
							  url: "<?php echo site_url('/');?>itinerary/delete_day/"+id+"/",
							  success: function(data) {
								
								$('footer').html(data);
								$('#modal-day-delete').modal('hide');
								
								$("#row-"+id).remove();
								
							  }
							});
							
						});
				}).modal({ backdrop: true });
			}
			
	$('#modal-doc-update').on('hidden', function () {
		$('#modal-doc-update').unbind('show'); // or $(this)        
	});

	$('#modal-doc-delete').on('hidden', function () {
		$('modal-doc-delete').unbind('show'); // or $(this)        
	});	
	
	$('#modal-day-delete').on('hidden', function () {
		$('modal-day-delete').unbind('show'); // or $(this)        
	});	
	
	$('#modal-price-delete').on('hidden', function () {
		$('modal-price-delete').unbind('show'); // or $(this)        
	});					
	
	
	</script>
</body>
</html>