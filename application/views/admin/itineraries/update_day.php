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
						<a href="<?php echo site_url('/');?>itinerary/tours/">Tours</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>itinerary/update_tour/<?php echo $tour_id ?>">Update Tour</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>itinerary/update_itinerary/<?php echo $itinerary_id ?>">Update Itinerary</a><span class="divider">/</span>
					</li>										
                    <li>
						Update Itinerary Day: <?php echo $title; ?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Day: <?php echo $this->itinerary_model->get_title('i_tours','tour_id',$tour_id); ?> : <?php echo $this->itinerary_model->get_title('i_tour_types','type_id',$type_id); ?> : <?php echo $title;?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="day-update" name="day-update" method="post" action="<?php echo site_url('/');?>itinerary/update_day_do" class="form-horizontal">
                             <fieldset>
								<input type="hidden" name="id" value="<?php if(isset($day_id)){echo $day_id;}?>">
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
									<label class="control-label" for="title">Days</label>
									<div class="controls">
											<input type="text" class="span6" id="days" name="days" placeholder="No Days" value="<?php if(isset($days)){echo $days;}?>">
									</div>
								  </div>

								  <div class="control-group">
									<label class="control-label" for="title">Title</label>
									<div class="controls">
											<input type="text" class="span6" id="title" name="title" placeholder="Tour title" value="<?php if(isset($title)){echo $title;}?>">
									</div>
								  </div>

								  <div class="control-group">
									<label class="control-label" for="title">Distance</label>
									<div class="controls">
											<input type="text" class="span6" id="distance" name="distance" placeholder="Approximate Distance" value="<?php if(isset($distance)){echo $distance;}?>">
									</div>
								  </div>									  																																												  
					
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											
											<textarea  class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
										</div>
								   </div>
								   
								  <div class="control-group">
									<label class="control-label" for="title">Basis</label>
									<div class="controls">
										<textarea  class="redactor_content loading_img" id="redactor_content" name="basis" style="display:block"><?php if(isset($basis)){echo $basis;}?></textarea>
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Activities Included</label>
									<div class="controls">
										<textarea  class="redactor_content loading_img" id="redactor_content" name="activity_inc" style="display:block"><?php if(isset($activity)){echo $activity;}?></textarea>
									</div>
								  </div>								  									   
								   
								  <div class="control-group">
									<label class="control-label" for="title">Inclusive</label>
									<div class="controls">
										<textarea  class="redactor_content loading_img" id="redactor_content" name="inclusive" style="display:block"><?php if(isset($inclusive)){echo $inclusive;}?></textarea>
									</div>
								  </div>									   

								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Day</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               </div> 
			   
			   
			<div class="row-fluid">
            
           			 
				<div class="box span3">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Day Destinations</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                       <form id="destination_add" name="destination_add" method="post" action="<?php echo site_url('/');?>itinerary/add_day_destination" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="day_id"  value="<?php if(isset($day_id)){echo $day_id;}?>">  
							  <input type="hidden" name="tour_id"  value="<?php if(isset($tour_id)){echo $tour_id;}?>">  
							  <input type="hidden" name="itinerary_id"  value="<?php if(isset($itinerary_id)){echo $itinerary_id;}?>">                        
                            <div class="input-append span12">
                              <input class="span8" id="appendedInputButtons1" type="text" name="destination" placeholder="Search Destination..." value="">
                              <button class="btn btn-inverse btn" id="btn_dest" onClick="add_destination();" type="button"><i class="icon-plus-sign icon-white"></i> Add</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form>
						<div id="curr_dest">
						<?php echo $this->itinerary_model->get_day_destinations($day_id); ?>
						</div>
                    </div>
				 </div>	
				 
				 
				<div class="box span3">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Day Highlights</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                       <form id="highlight_add" name="highlight_add" method="post" action="<?php echo site_url('/');?>itinerary/add_day_highlight" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="day_id"  value="<?php if(isset($day_id)){echo $day_id;}?>">  
							  <input type="hidden" name="tour_id"  value="<?php if(isset($tour_id)){echo $tour_id;}?>">  
							  <input type="hidden" name="itinerary_id"  value="<?php if(isset($itinerary_id)){echo $itinerary_id;}?>">                        
                            <div class="input-append span12">
                              <input class="span8" id="appendedInputButtons4" type="text" name="highlight" placeholder="Search Highlight..." value="">
                              <button class="btn btn-inverse btn" id="btn_dest" onClick="add_highlight();" type="button"><i class="icon-plus-sign icon-white"></i> Add</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form>
						<div id="curr_high">
						<?php echo $this->itinerary_model->get_day_highlights($day_id); ?>
						</div>
                    </div>
				 </div>					 
				 
				 
				<div class="box span3">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Day Accommodations</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                       <form id="accommodation_add" name="accommodation_add" method="post" action="<?php echo site_url('/');?>itinerary/add_day_accommodation" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="day_id"  value="<?php if(isset($day_id)){echo $day_id;}?>"> 
							  <input type="hidden" name="tour_id"  value="<?php if(isset($tour_id)){echo $tour_id;}?>">  
							  <input type="hidden" name="itinerary_id"  value="<?php if(isset($itinerary_id)){echo $itinerary_id;}?>"> 							                         
                            <div class="input-append span12">
                              <input class="span7" id="appendedInputButtons2" type="text" name="accommodation" placeholder="Search Accommodation..." value="">
                              <button class="btn btn-inverse btn" id="btn_acc" onClick="add_accommodation();" type="button"><i class="icon-plus-sign icon-white"></i> Add</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form>
						<div id="curr_acc">
						<?php echo $this->itinerary_model->get_day_accommodations($day_id); ?>
						</div>
                    </div>
				 </div>					 		 
				 

				<div class="box span3">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Day Activities</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                       <form id="activity_add" name="activity_add" method="post" action="<?php echo site_url('/');?>itinerary/add_day_activity" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="day_id"  value="<?php if(isset($day_id)){echo $day_id;}?>">  
							  <input type="hidden" name="tour_id"  value="<?php if(isset($tour_id)){echo $tour_id;}?>">  
							  <input type="hidden" name="itinerary_id"  value="<?php if(isset($itinerary_id)){echo $itinerary_id;}?>"> 							                        
                            <div class="input-append span12">
                              <input class="span8" id="appendedInputButtons3" type="text" name="activity" placeholder="Search Activity..." value="">
                              <button class="btn btn-inverse btn" id="btn_act" onClick="add_activity();" type="button"><i class="icon-plus-sign icon-white"></i> Add</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form>
						<div id="curr_act">
						<?php echo $this->itinerary_model->get_day_activities($day_id); ?>
						</div>
                    </div>
				 </div>		

				 
               </div> 			   
			   
			<hr>
				
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				


		
        <div class="modal hide fade" id="modal-destination-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Day Destination</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-destination-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Day Destination</a>
          </div>
        </div>
		
		
        <div class="modal hide fade" id="modal-accommodation-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Day Accommodation</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-accommodation-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Day Accommodation</a>
          </div>
        </div>		
		

        <div class="modal hide fade" id="modal-activity-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Day Activity</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-activity-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Day Activity</a>
          </div>
        </div>
		
		
        <div class="modal hide fade" id="modal-highlight-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Day Highlight</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-highlight-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Day Highlight</a>
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
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', 'underline', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video','file', 'table', 'link','|',
					 'alignment', '|', 'horizontalrule'],
					linebreaks: true,
					focus:true,
					plugins: ['fullscreen', 'fontcolor', 'fontsize','fontfamily']
		});	
		
		
		<?php echo $this->itinerary_model->load_destination_typehead();?>


		$('#appendedInputButtons1').typeahead({source: subjects}) 	
		
		
		<?php echo $this->itinerary_model->load_accommodation_typehead();?>


		$('#appendedInputButtons2').typeahead({source: subjects}) 	
		
		
		<?php echo $this->itinerary_model->load_activity_typehead();?>


		$('#appendedInputButtons3').typeahead({source: subjects}) 
		
		
		<?php echo $this->itinerary_model->load_highlight_typehead();?>


		$('#appendedInputButtons4').typeahead({source: subjects}) 								
					
	
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
			
		var frm = $('#day-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'itinerary/update_day_do';?>' ,
			success: function (data) {
				 $('#autosave').val('true');
				 $('#result_msg').html(data);
				 $('#butt').html('Update Day');
				
			}
		});
	}
			
	window.onbeforeunload = function() {		 
		 if($('#autosave').val() == 'false'){
			return 'The day has not been saved.';
		 }
	};
	
	
	

		function add_destination(){
	
			//Validate
			if($('#appendedInputButtons1').val().length == 0){
					
					$('#appendedInputButtons1').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Destination Required", content:"Please supply us with a destination"});
					$('#appendedInputButtons1').popover('show');
					$('#appendedInputButtons1').focus();
			
			}else if($('#tour_id').val() == ''){
				
					$('#appendedInputButtons1').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Save the Destination", content:"Please add the day and then add destinations"});
					$('#appendedInputButtons1').popover('show');
					$('#appendedInputButtons1').focus();
			
			}else{
				
				
				var frm = $('#destination_add');
				//frm.submit();
				$('#btn_dest').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '<?php echo site_url('/').'itinerary/add_day_destination';?>' ,
					success: function (data) {
						
						 $('#result_msg').html(data);
						 $('#btn_dest').html('<i class="icon-plus-sign icon-white"></i> Add');
						 reload_destinations(<?php echo $day_id; ?>);
						 var options = {'text':'Destination added successfully','layout':'bottomLeft','type':'success'};
						 noty(options);
					}
				});	
	
				
			}		
		
		}
		
		
		function delete_day_destination(id){
			  
			$('#modal-destination-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>itinerary/delete_day_destination/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-destination-delete').modal('hide');
							
							$("#row-"+id).remove();
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
	
		
		function reload_destinations(id){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'itinerary/reload_day_destinations_all/';?>'+id ,
					success: function (data) {
						
						 $('#curr_dest').html(data);
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




		function add_accommodation(){
	
			//Validate
			if($('#appendedInputButtons2').val().length == 0){
					
					$('#appendedInputButtons2').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Accommodation Required", content:"Please supply us with a accommodation"});
					$('#appendedInputButtons2').popover('show');
					$('#appendedInputButtons2').focus();
			
			}else if($('#tour_id').val() == ''){
				
					$('#appendedInputButtons2').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Save the Accommodation", content:"Please add the day and then add accommodations"});
					$('#appendedInputButtons2').popover('show');
					$('#appendedInputButtons2').focus();
			
			}else{
				
				
				var frm = $('#accommodation_add');
				//frm.submit();
				$('#btn_acc').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '<?php echo site_url('/').'itinerary/add_day_accommodation';?>' ,
					success: function (data) {
						
						 $('#result_msg').html(data);
						 $('#btn_acc').html('<i class="icon-plus-sign icon-white"></i> Add');
						 reload_accommodations(<?php echo $day_id; ?>);
						 var options = {'text':'Accommodation added successfully','layout':'bottomLeft','type':'success'};
						 noty(options);
					}
				});	
	
				
			}		
		
		}
		
		
		function delete_day_accommodation(id){
			  
			$('#modal-accommodation-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>itinerary/delete_day_accommodation/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-accommodation-delete').modal('hide');
							
							$("#row-"+id).remove();
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
	
		
		function reload_accommodations(id){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'itinerary/reload_day_accommodations_all/';?>'+id ,
					success: function (data) {
						
						 $('#curr_acc').html(data);
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




		function add_activity(){
	
			//Validate
			if($('#appendedInputButtons3').val().length == 0){
					
					$('#appendedInputButtons3').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Activity Required", content:"Please supply us with a Activity"});
					$('#appendedInputButtons3').popover('show');
					$('#appendedInputButtons3').focus();
			
			}else if($('#tour_id').val() == ''){
				
					$('#appendedInputButtons3').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Save the Activity", content:"Please add the day and then add activities"});
					$('#appendedInputButtons3').popover('show');
					$('#appendedInputButtons3').focus();
			
			}else{
				
				
				var frm = $('#activity_add');
				//frm.submit();
				$('#btn_act').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '<?php echo site_url('/').'itinerary/add_day_activity';?>' ,
					success: function (data) {
						
						 $('#result_msg').html(data);
						 $('#btn_act').html('<i class="icon-plus-sign icon-white"></i> Add');
						 reload_activities(<?php echo $day_id; ?>);
						 var options = {'text':'Activity added successfully','layout':'bottomLeft','type':'success'};
						 noty(options);
					}
				});	
	
				
			}		
		
		}
		
		
		function delete_day_activity(id){
			  
			$('#modal-activity-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>itinerary/delete_day_activity/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-activity-delete').modal('hide');
							
							$("#row-"+id).remove();
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
	
		
		function reload_activities(id){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'itinerary/reload_day_activity_all/';?>'+id ,
					success: function (data) {
						
						 $('#curr_act').html(data);
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
		
		
		
		function add_highlight(){
	
			//Validate
			if($('#appendedInputButtons4').val().length == 0){
					
					$('#appendedInputButtons4').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Highlight Required", content:"Please supply us with a highlight"});
					$('#appendedInputButtons4').popover('show');
					$('#appendedInputButtons4').focus();
			
			}else if($('#tour_id').val() == ''){
				
					$('#appendedInputButtons4').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Save the Highlight", content:"Please add the day and then add highlights"});
					$('#appendedInputButtons4').popover('show');
					$('#appendedInputButtons4').focus();
			
			}else{
				
				
				var frm = $('#highlight_add');
				//frm.submit();
				$('#btn_high').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
				$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '<?php echo site_url('/').'itinerary/add_day_highlight';?>' ,
					success: function (data) {
						
						 $('#result_msg').html(data);
						 $('#btn_high').html('<i class="icon-plus-sign icon-white"></i> Add');
						 reload_highlights(<?php echo $day_id; ?>);
						 var options = {'text':'Highlight added successfully','layout':'bottomLeft','type':'success'};
						 noty(options);
					}
				});	
	
				
			}		
		
		}
		
		
		function delete_day_highlight(id){
			  
			$('#modal-highlight-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>itinerary/delete_day_highlight/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-highlight-delete').modal('hide');
							
							$("#row-"+id).remove();
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}
	
		
		function reload_highlights(id){

				$.ajax({
					type: 'get',
					url: '<?php echo site_url('/').'itinerary/reload_day_highlights_all/';?>'+id ,
					success: function (data) {
						
						 $('#curr_high').html(data);
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
		
	
	$('#modal-activity-delete').on('hidden', function () {
		$('modal-activity-delete').unbind('show'); // or $(this)        
	});	
	
	$('#modal-accommodation-delete').on('hidden', function () {
		$('modal-accommodation-delete').unbind('show'); // or $(this)        
	});
	
	$('#modal-destination-delete').on('hidden', function () {
		$('modal-destination-delete').unbind('show'); // or $(this)        
	});			
	
	$('#modal-highlight-delete').on('hidden', function () {
		$('modal-highlight-delete').unbind('show'); // or $(this)        
	});			
		
	
	</script>
</body>
</html>