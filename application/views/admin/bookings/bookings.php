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
						<a href="#">Bookings</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>All Bookings</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<?php $this->admin_model->get_all_bookings();?>
                                        
                  </div>
				</div>
                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Booking Stats</h2>
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
                      <p class="alert">Update a booking status and payment by clicking on the corresponding buttons</p>
                      <p><a title="Update the booking" rel="tooltip" class="btn btn-mini" style="cursor:pointer"><i class="icon-zoom-in"></i></a> - View Booking</p>
                      <p><a title="Delete the booking" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Booking</p>
                      
					</div>
					
					</div>
				</div><!--/span-->
                
			</div>
			
			<hr>
			
            <div class="row-fluid">
				
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Calendar</h2>
					</div>
					<div class="box-content">
                      <div id="cal_holder">
                          <div id="main_calendar"></div>
                      </div>
                      <div class="clearfix"></div>
					</div>	
				</div><!--/span-->
				
			  	<div class="box span4" onTablet="span8" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Upcoming</h2>
					</div>
					<div class="box-content">
                      <div id="upcoming_events">
                          
                      </div>
                      <div class="clearfix"></div>
					</div>	
				</div><!--/span-->

			</div>
            
			<div class="row-fluid">
				
				
				
			</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
        <div id="cal_script"></div>
        		
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
		
        
        <div class="modal hide fade" id="modal-booking-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Booking</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current booking? All booking details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-booking-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Booking</a>
          </div>
        </div>
        
         <div class="modal hide fade" id="modal-view">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Enquiry</h3>
          </div>
          <div class="modal-body">
            
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-view').modal('hide');" class="btn">Close</a>
            <a href="javascript:void(0)" class="btn btn-primary">Reply</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
			<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
        
        
	<script type="text/javascript">
		
		
		
		function delete_booking(id){
			  
			$('#modal-booking-delete').bind('show', function() {
				//var id = $(this).data('id'),
					removeBtn = $(this).find('.btn-primary');
						
					removeBtn.unbind('click').click(function(e) { 
						e.preventDefault();	
						$.ajax({
						  url: "<?php echo site_url('/');?>admin/delete_booking/"+id+"/",
						  success: function(data) {
							
							$('footer').html(data);
							$('#modal-booking-delete').modal('hide');
							
						  }
						});
						
					});
			}).modal({ backdrop: true });
		}


		function load_calendar(){
			
		
	       $.get('<?php echo site_url('/'). 'admin/ajax_load_bookings/';?>', function(data) {
			  $('#cal_script').html(data);
			  
			});
		}


		
								
		function view_enquiry(id){
			  
			$('#modal-view').bind('show', function() {
				    
					modal_cont = $(this).find('.modal-body');
					$.ajax({
						  cache: false,
						  url: "<?php echo site_url('/');?>admin/get_enquiry/"+id+"/",
						  success: function(data) {
							
							modal_cont.html(data);
							
						  }
						});
					
					Btn = $(this).find('.btn-primary');
					Btn.show();	
					Btn.unbind('click').click(function(e) { 
						
						Btn.fadeOut();
						$('#reply_view').slideUp();
						$('#reply_txt').slideDown();
						
					});
			}).modal({ backdrop: true });
		}	


		function reply_enquiry(){
			  	
				console.log('t=yes');
				var frm = $('#sendmail');
				
					$.ajax({
						  method: 'post',
						  cache: false,
						  data: frm.serialize(),
						  url: "<?php echo site_url('/');?>admin/reply_enquiry/",
						  success: function(data) {
							
								$('#reply_msg').html(data);

							 }
						});
		
		
		}
		
		function update_booking_status(id, status, type){
				 
			  $.ajax({
					url: "<?php echo site_url('/');?>admin/update_booking_status/"+id+"/"+status+"/"+type,
					success: function(data) {
					   $('footer').html(data);
					
					  
					}
				});

		}
		
		
		$(document).ready(function(){
			
												
	
			
			load_calendar();
			
		});
		
			
	</script>
</body>
</html>