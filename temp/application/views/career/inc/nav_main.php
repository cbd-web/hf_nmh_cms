<aside id="left-panel">

	<!-- User info -->
	<div class="login-info">
		<span> <!-- User image size is adjusted inside CSS, it should stay as it -->
			<a href="javascript:void(0);" id="show-shortcut" data-action="toggleShortcut">
				<span>
					<strong>Career Component</strong>
				</span>
				<i class="fa fa-angle-down"></i>
			</a>
		</span>
	</div>
	<!-- end user info -->

	<!-- NAVIGATION : This navigation is also responsive-->
	<nav>
		<ul>
			<li>
				<a href="<?php echo site_url('/'); ?>career/" title="Dashboard"><i class="fa fa-lg fa-fw fa-home"></i> <span class="menu-item-parent">Dashboard</span></a>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-briefcase"></i> <span class="menu-item-parent">Vacancies</span></a>
				<ul>
					<li><a href="<?php echo site_url('/'); ?>career/vacancies">Vacancy List</a></li>
					<li><a href="<?php echo site_url('/'); ?>career/minimum_requirements">Minimum Requirements</a></li>
					<li><a href="<?php echo site_url('/'); ?>career/industry_categories">Industry Categories</a></li>
					<li><a href="<?php echo site_url('/'); ?>career/disciplines">Disciplines</a></li>
					<li><a href="<?php echo site_url('/'); ?>career/locations">Locations</a></li>
					<li><a href="<?php echo site_url('/'); ?>career/management">Management Levels</a></li>
				</ul>
			</li>
			<li>
				<a href="<?php echo site_url('/'); ?>career/departments"><i class="fa fa-lg fa-fw fa-building"></i> <span class="menu-item-parent">Departments</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('/'); ?>career/clients"><i class="fa fa-lg fa-fw fa-umbrella"></i> <span class="menu-item-parent">Clients</span></a>
			</li>
			<li>
				<a href="<?php echo site_url('/'); ?>career/applicants"><i class="fa fa-lg fa-fw fa-users"></i> <span class="menu-item-parent">Applicants</span></a>
			</li>
			<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-microphone"></i> <span class="menu-item-parent">Interviews</span></a>
				<ul>
					<li><a href="<?php echo site_url('/'); ?>career/job_files">Job Files</a></li>
					<li><a href="<?php echo site_url('/'); ?>career/panellists">Panellists</a></li>
					<li><a href="<?php echo site_url('/'); ?>career/interview_survey">Interview Survey</a></li>
				</ul>
			</li>
			<!--<li>
				<a href="#"><i class="fa fa-lg fa-fw fa-envelope"></i> <span class="menu-item-parent">Automated Messages</span></a>
				<ul>
					<li><a href="<?php //echo site_url('/'); ?>career/messages">List Messages</a></li>
					<?php //echo $this->career_model->get_am_nav(); ?>
				</ul>
			</li>-->
		</ul>
	</nav>


	<span class="minifyme" data-action="minifyMenu">
		<i class="fa fa-arrow-circle-left hit"></i>
	</span>

</aside>