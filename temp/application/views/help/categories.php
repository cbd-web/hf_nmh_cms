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
						<a href="#">Category</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Category</h2>
					</div>
					<div class="box-content">

						<p><b>CATEGORIES</b></p>

						<p>This component allows the user to add or delete categories</p>

						<p>Figure 1</p>

						<p><img src="<?php echo base_url('/');?>img/help/category/category.png"></p>

						<p><b><i>Add Category</i></b></p>

						<p>To add a category, type a category name in the add category input box and click “Add Category”</p>

						<p>Figure 2</p>

						<p><img src="<?php echo base_url('/');?>img/help/category/add-cat.png"></p>

						<p><b><i>Delete Category</i></b></p>

						<p>To delete a category, click the orange button with a dustbin icon.</p>

						<p>Figure 3</p>

						<p><img src="<?php echo base_url('/');?>img/help/category/delete-cat.png"></p>
						
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
									<td valign="top" ><p><b>Category</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Add Category</p></td>
									<td valign="top" ><p>2</p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Delete Category</p></td>
									<td valign="top" ><p>4</p></td>
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