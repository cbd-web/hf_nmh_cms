<?php $this->load->view('admin/inc/header');?>
<body>
	
		<?php $this->load->view('admin/inc/nav_top');?>
		
		<div class="container-fluid">
		<div class="row-fluid">
			<?php $this->load->view('help/inc/nav_main');?>
			<div id="content" class="span10">
			<!-- start: Content -->
			
			<div>
				<hr>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Documentation</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span12" onTablet="span12" onDesktop="span12">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Documentation</h2>
					</div>
					<div class="box-content">

						<div class="clearfix"></div>
					</div>
				</div><!--/span-->

			</div>
			
			<hr>

			<div class="sortable row-fluid ui-sortable">

				<a href="<?php echo site_url('/');?>documentation/users/" class="quick-button span2">
					<i class="fa-icon-group"></i>
					<p>Users</p>

				</a>
				<a href="<?php echo site_url('/');?>documentation/pages/" class="quick-button span2">
					<i class="fa-icon-file"></i>
					<p>Pages</p>

				</a>
				<a href="<?php echo site_url('/');?>documentation/news/" class="quick-button span2">
					<i class="fa-icon-copy"></i>
					<p>News</p>

				</a>
				<a href="<?php echo site_url('/');?>documentation/categories/" class="quick-button span2">
					<i class="fa-icon-folder-open"></i>
					<p>Categories</p>

				</a>
				<a href="<?php echo site_url('/');?>documentation/menu/" class="quick-button span2">
					<i class="fa-icon-envelope"></i>
					<p>Menu</p>

				</a>
				<a href="<?php echo site_url('/');?>documentation/images/" class="quick-button span2">
					<i class="fa-icon-picture"></i>
					<p>Images</p>

				</a>

			</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		<div class="clearfix"></div>

		<?php $this->load->view('admin/inc/footer');?>
	</div><!--/.fluid-container-->

	
</body>
</html>