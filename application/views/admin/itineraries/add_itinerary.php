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
						<a href="<?php echo site_url('/');?>itinerary/tours/">Tours</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>itinerary/update_tour/<?php echo $tour_id ?>">Update Tour</a><span class="divider">/</span>
					</li>					
                    <li>
						Add New Tour Itinerary
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Tour Itinerary</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="add-itinerary" name="add-itinerary" method="post" action="<?php echo site_url('/');?>itinerary/add_itinerary_do" class="form-horizontal">
							<input name="tour_id" type="hidden" value="<?php echo $tour_id; ?>">
                             <fieldset>

								  <div class="control-group">
									<label class="control-label" for="title">Choose Itinerary Style</label>
									<div class="controls">
										<select name="type" class="span6">
											<?php echo $this->itinerary_model->get_style_select(); ?>
										</select>
									</div>
								  </div>
																												  
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											
											<textarea id="tinymce" class="tinymce" name="content"></textarea>
										</div>
								   </div>
								   
							  	  <div class="control-group">
									<label class="control-label" for="title">Price Heading</label>
									<div class="controls">
											<input type="text" class="span6" id="price_heading" name="price_heading" placeholder="Price Heading" value="">
									</div>
								  </div>									   
								   
								  <div class="control-group">
									<label class="control-label" for="title">Pricing Disclarity</label>
									<div class="controls">
										<textarea  class="redactor_content loading_img" id="redactor_content" name="valid" style="display:block"></textarea>
									</div>
								  </div>
								  
								  							   
								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Itinerary</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               

			</div>
			
			<hr>
			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
        <div class="clearfix"></div>
		
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    <script type="text/javascript" src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>	
	<script type="text/javascript">
	
	$(document).ready(function(){
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
			
			var frm = $('#add-itinerary');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'itinerary/add_itinerary_do'; ?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Tour');
					
				}
			});	
	
	}
	
	
	</script>
</body>
</html>