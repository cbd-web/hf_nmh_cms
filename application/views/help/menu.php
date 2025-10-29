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
						<a href="<?php echo site_url('/');?>">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>documentation/">Documentation</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Menu</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Menu</h2>
					</div>
					<div class="box-content">

						<p><b>MENU</b></p>

						<p>The MENU allows you to customize your website Menu Tab. To add a tab to the menu, drag and drop the tab into the menu.</p>

						<p>Figure 1</p>
						<p><img src="<?php echo base_url('/');?>img/help/menu/menu.png"></p>

						<p><b><i>Add A Tab</i></b></p>
						<p>To create a drop down menu, drag and drop any page you want to appear as a drop down under the main page half way as shown below. Figure 6 illustrates both the CMS menu and the website results.</p>
						<p>Figure 2</p>
						<p><img src="<?php echo base_url('/');?>img/help/menu/sub-menu.png"></p>
						<p>Figure 3</p>
						<p><img src="<?php echo base_url('/');?>img/help/menu/demo.png"></p>
						
					</div>
				</div><!--/span-->
				<div class="box span4" onTablet="span4" onDesktop="span4">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Table of content</h2>
					</div>
					<div class="box-content">

						<table class="table" cellspacing="0" cellpadding="0" >
							<tbody>
								<tr>
									<td valign="top" ><p><b>Menu</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p><b>Add A Tab</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>
							</tbody>
						</table>

						<div class="clearfix"></div>
					</div>
				</div><!--/span-->
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