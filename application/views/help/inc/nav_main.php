<?php 
$role = $this->session->userdata('role'); 

//if($role == 'admin' || $role == 'editor'){  ?>
      <!-- start: Main Menu -->
			<div class="span2 main-menu-span">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="<?php echo site_url('/');?>documentation/dashboard/"><i class="icon-home icon-white"></i><span class="hidden-tablet"> Dashboard </span></a></li>
						<li><a href="<?php echo site_url('/');?>documentation/users/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Users</span></a></li>
                        <li><a href="<?php echo site_url('/');?>documentation/pages/"><i class="fa-icon-briefcase icon-white"></i><span class="hidden-tablet"> Pages</span></a></li>
                        <li><a href="<?php echo site_url('/');?>documentation/news/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> News</span></a></li>
                        <li><a href="<?php echo site_url('/');?>documentation/categories/"><i class="fa-icon-question-sign icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
                        <li><a href="<?php echo site_url('/');?>documentation/menu/"><i class="fa-icon-cogs icon-white"></i><span class="hidden-tablet"> Menu</span></a></li>
						<li><a href="<?php echo site_url('/');?>documentation/images/"><i class="fa-icon-cogs icon-white"></i><span class="hidden-tablet"> Images</span></a></li>
						<li><a href="<?php echo site_url('/');?>documentation/sliders/"><i class="fa-icon-cogs icon-white"></i><span class="hidden-tablet"> Sliders</span></a></li>
						<li><a href="<?php echo site_url('/');?>documentation/documents/"><i class="fa-icon-cogs icon-white"></i><span class="hidden-tablet"> Documents</span></a></li>
                        <li><a target="_blank" href="<?php echo $this->session->userdata('url');?>"><i class="icon-play icon-white"></i><span class="hidden-tablet"> Go to website</span></a></li>
                        
					</ul>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- end: Main Menu -->


 	<?php //} ?>
 
           
            
            
            