      <!-- start: Main Menu -->
			<div class="span2 main-menu-span">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
						<li><a href="<?php echo site_url('/');?>super_admin/home"><i class="icon-home icon-white"></i><span class="hidden-tablet"> Dashboard </span></a></li>
						
                        <li><a class="submenu" href="<?php echo site_url('/').'super_admin/pages/';?>"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> All Pages</span></a></li>
						<li><a class="submenu" href="<?php echo site_url('/').'super_admin/posts/';?>"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> All Posts</span></a></li>
                        <li><a href="<?php echo site_url('/');?>super_admin/categories/"><i class="icon-folder-open icon-white"></i><span class="hidden-tablet"> Categories</span></a></li>
                        
                        <?php echo $this->admin_model->get_main_nav();?>

                       <!-- <li>
							<a class="dropmenu" href="#"><i class="icon-file icon-white"></i><span class="hidden-tablet"> Images</span></a>
							<ul>
								<li><a class="submenu" href="<?php echo site_url('/');?>super_admin/galleries/"><i class="fa-icon-file-alt"></i><span class="hidden-tablet"> Galleries</span></a></li>
                                <li><a class="submenu" href="<?php echo site_url('/');?>super_admin/images/"><i class="fa-icon-picture"></i><span class="hidden-tablet"> All Images</span></a></li>
								<?php $this->admin_model->get_galleries_nav();?>
                                
							</ul>	
						</li>-->
              
                        <li><a href="<?php echo site_url('/');?>super_admin/users/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Users</span></a></li>
                        <li><a href="<?php echo site_url('/');?>super_admin/enquiries/"><i class="fa-icon-question-sign icon-white"></i><span class="hidden-tablet"> Enquiries</span></a></li>
                        <li><a href="<?php echo site_url('/');?>super_admin/settings/"><i class="fa-icon-cogs icon-white"></i><span class="hidden-tablet"> Settings</span></a></li>
                        <li><a href="<?php echo site_url('/');?>super_admin/accounts/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Accounts</span></a></li>
                        <li><a href="<?php echo site_url('/');?>super_admin/add_account/"><i class="fa-icon-group icon-white"></i><span class="hidden-tablet"> Add New Account</span></a></li>
                        <li><a href="<?php echo $this->session->userdata('url');?>"><i class="icon-play icon-white"></i><span class="hidden-tablet"> Go to website</span></a></li>
                        
					</ul>
				</div><!--/.well -->
			</div><!--/span-->
			<!-- end: Main Menu -->
            
            
            
            