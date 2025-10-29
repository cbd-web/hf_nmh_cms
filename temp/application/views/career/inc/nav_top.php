
    <noscript>
        <div class="alert alert-block span10">
            <h4 class="alert-heading">Warning!</h4>
            <p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
        </div>
    </noscript>
<!-- start: Navigation -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" target="_blank" href="<?php echo base_url('/');?>" style="color:#FFF; font-size:16px;text-shadow:none"> <span class="hidden-phone"></span><?php echo $this->session->userdata('site_title');?></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						<?php //CACHING
						if($this->session->userdata('caching') == 'Y'){

							echo '<li>
										<a class="btn" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Clean the website cache" href="'.site_url('/').'admin/clean_cache/?redirect='.current_url('/').'">
											<i class=" icon-refresh icon-white"></i>
										</a>
									</li>';
						}
                        ?>

						<li>
							<a class="btn" target="_blank" href="<?php echo $this->session->userdata('url');?>">
								<i class="icon-play icon-white"></i>
							</a>
						</li>
						<li>
							<a class="btn" href="<?php echo site_url('/');?>documentation/">
								<i class="icon-question-sign icon-white"></i>
							</a>
						</li>
						<li>
							<a class="btn" href="<?php echo site_url('/');?>admin/settings">
								<i class="icon-wrench icon-white"></i>
							</a>
						</li>
						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="icon-user icon-white"></i>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li><a href="<?php echo site_url('/');?>admin/settings"><i class="icon-user"></i> Profile</a></li>
								<li><a href="<?php echo site_url('/');?>admin/logout/"><i class="icon-off"></i> Logout</a></li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	<!-- start: Header -->