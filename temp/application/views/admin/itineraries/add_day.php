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
						<a href="<?php echo site_url('/');?>itinerary/update_itinerary/<?php echo $itinerary_id ?>">Update Itinerary</a><span class="divider">/</span>
					</li>										
                    <li>
						Add Itinerary Day:
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Day: <?php echo $this->itinerary_model->get_title('i_tours','tour_id',$tour_id); ?> : <?php echo $this->itinerary_model->get_title('i_tour_types','type_id',$type_id); ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="add-day" name="add-day" method="post" action="<?php echo site_url('/');?>itinerary/add_day_do" class="form-horizontal">
							<input name="tour_id" type="hidden" value="<?php echo $tour_id ?>">
							<input name="type_id" type="hidden" value="<?php echo $type_id ?>">
							<input name="itinerary_id" type="hidden" value="<?php echo $itinerary_id ?>">
                             <fieldset>
								  <div class="control-group">
									<label class="control-label" for="title">Days</label>
									<div class="controls">
											<input type="text" class="span6" id="days" name="days" placeholder="No of days" value="">
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Title</label>
									<div class="controls">
											<input type="text" class="span6" id="title" name="title" placeholder="Day title" value="">
									</div>
								  </div>
										
								  <div class="control-group">
									<label class="control-label" for="title">Distance</label>
									<div class="controls">
											<input type="text" class="span6" id="distance" name="distance" placeholder="Approximate Distance" value="">
									</div>
								  </div>																	  
					
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											
											<textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
										</div>
								   </div>
								   
								  <div class="control-group">
									<label class="control-label" for="title">Basis</label>
									<div class="controls">
										<textarea  class="redactor_content loading_img" id="redactor_content" name="basis" style="display:block"></textarea>
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Activities Included</label>
									<div class="controls">
										<textarea  class="redactor_content loading_img" id="redactor_content" name="activity_inc" style="display:block"></textarea>
									</div>
								  </div>								  	

								  <div class="control-group">
									<label class="control-label" for="title">Inclusive</label>
									<div class="controls">
										<textarea  class="redactor_content loading_img" id="redactor_content" name="inclusive" style="display:block"></textarea>
									</div>
								  </div>								   
								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Day</button>
                                           
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
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', 'underline', '|', 
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
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a title"});
				$('#title').popover('show');
				$('#title').focus();	
			
		}else{
	
			submit_form();
			
		}
	});
	
	
	function submit_form(){
			
			var frm = $('#add-day');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'itinerary/add_day_do'; ?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Tour');
					
				}
			});	
	
	}
	
	
	</script>
</body>
</html>