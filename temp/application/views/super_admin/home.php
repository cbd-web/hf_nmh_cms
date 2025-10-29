<?php $this->load->view('admin/inc/header');?>
<body>

	<div id="overlay">
		<ul>
		  <li class="li1"></li>
		  <li class="li2"></li>
		  <li class="li3"></li>
		  <li class="li4"></li>
		  <li class="li5"></li>
		  <li class="li6"></li>
		</ul>
	</div>	
		<?php $this->load->view('super_admin/inc/nav_top');?>
		
		<div class="container-fluid">
		<div class="row-fluid">
			<?php $this->load->view('super_admin/inc/nav_main');?>
			<div id="content" class="span10">
			<!-- start: Content -->
			
			<div>
				<hr>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Dashboard</a>
					</li>
				</ul>
				<hr>
			</div>
			
			
			
			<div class="row-fluid loading_img" id="stat_overview">		
				
			<?php //$this->google_model->load_overview();?>
					
			</div>
			
			<hr>
			
            <div class="row-fluid loading_img" id="stat_overview2">		
				
			<?php //$this->google_model->traffic_graph();
			
				  //$this->google_model->organic_keywords();
			?>
					
			</div>
			
			<hr>
            
           
			<div class="sortable row-fluid">
				
			 <?php $this->super_admin_model->get_dashboard_navigation();
			
				
			?>	
				
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
						<h2><i class="icon-calendar"></i><span class="break"></span>Upcoming Events</h2>
					</div>
					<div class="box-content">
                      <div id="upcoming_events">
                          
                      </div>
                      <div class="clearfix"></div>
					</div>	
				</div><!--/span-->

			</div>
				
			<hr>

			<div class="row-fluid">

			   <?php $this->super_admin_model->get_system_logs();
          
              
              ?>	
				
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
		
        <div class="clearfix"></div>
        <div id="cal_script"></div>        
	
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
	<script type="text/javascript">
		$(document).ready(function(){
			
			$.get('<?php echo site_url('/'). 'admin/ajax_load_home/';?>', function(data) {
			  $('#stat_overview').html(data).removeClass('loading_img');
			  
			});
		
			$.get('<?php echo site_url('/'). 'admin/ajax_load_home2/';?>', function(data) {
			  $('#stat_overview2').html(data).removeClass('loading_img');
			  
			});
			
			setTimeout(load_calendar, 2000);
			
		});
		
		function load_calendar(){
			
		
	       $.get('<?php echo site_url('/'). 'admin/ajax_load_calendar/';?>', function(data) {
			  $('#cal_script').html(data);
			  
			});
		}
		
	</script>
    
</body>
</html>