<?php 
$role = $this->session->userdata('role'); 

if($role == 'admin' || $role == 'editor'){  ?>
      <!-- start: Main Menu -->
			<div class="span2 main-menu-span">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="<?php echo site_url('/');?>admin/home"><i class="icon-home icon-white"></i><span class="hidden-tablet"> Dashboard </span></a></li>
                        <?php echo $this->admin_model->get_main_nav();?>
                        <li>
							<a class="dropmenu" href="#"><i class="icon-picture icon-white"></i><span class="hidden-tablet"> Images</span></a>
							<ul>
								<li><a class="submenu" href="<?php echo site_url('/');?>admin/galleries/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> Galleries</span></a></li>
                                <li><a class="submenu" href="<?php echo site_url('/');?>admin/images/"><i class="fa-icon-picture"></i><span class="hidden-tablet"> All Images</span></a></li>
								<li><a class="submenu" href="<?php echo site_url('/');?>admin/gallery_categories/"><i class="fa-icon-folder-open"></i><span class="hidden-tablet"> Categories</span></a></li>
								<?php $this->admin_model->get_galleries_nav();?>
							</ul>	
						</li>
                        <li><a href="<?php echo site_url('/');?>admin/documents/"><i class="fa-icon-briefcase icon-white"></i><span class="hidden-tablet"> Documents</span></a></li>
                        
                        <li><a href="<?php echo site_url('/');?>admin/users/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Users</span></a></li>
                        <li><a href="<?php echo site_url('/');?>admin/enquiries/"><i class="fa-icon-question-sign icon-white"></i><span class="hidden-tablet"> Enquiries</span></a></li>
                        <li><a href="<?php echo site_url('/');?>admin/settings/"><i class="fa-icon-cogs icon-white"></i><span class="hidden-tablet"> Settings</span></a></li>
                        <li><a target="_blank" href="<?php echo $this->session->userdata('url');?>"><i class="icon-play icon-white"></i><span class="hidden-tablet"> Go to website</span></a></li>
						<li><a target="_blank" href="<?php echo site_url('/');?>documentation/"><i class="fa-icon-question-sign icon-white"></i><span class="hidden-tablet"> Documentation</span></a></li>
					</ul>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- end: Main Menu -->
			
			
			
			
 	<?php } if($role == 'feedback_update' || $role == 'feedback_closure' || $role == 'feedback_visitor'){  ?>
     <!-- start: Main Menu -->
			<div class="span2 main-menu-span">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="<?php echo site_url('/');?>admin/home"><i class="icon-home icon-white"></i><span class="hidden-tablet"> Dashboard </span></a></li>
                
                        <?php echo $this->admin_model->get_main_nav();?>

                        
					</ul>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- end: Main Menu --> 
 
 
 	<?php } ?>
 
           
            
            
            