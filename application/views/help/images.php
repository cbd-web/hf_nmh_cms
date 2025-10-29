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
						<a href="#">Images</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Images</h2>
					</div>
					<div class="box-content">

						<p><b>IMAGES</b></p>

						<p>Images tab consist of three sub-tabs <b>Galleries, All Images and List Galleries.</b></p>

						<p><i><b>Galleries</b></i></p>

						<p>All galleries, lists all galleries by Title, Description and Date. On top of the galleries is the searching option and records viewing option.</p>

						<p>Figure 1</p>
						<p><img src="<?php echo base_url('/');?>img/help/images/all-galleries.png"></p>

						<p><b><i>Add Gallery</i></b></p>
						<p>Add new gallery option handles the creation of a new gallery in the CMS.</p>
						<p>Figure 2</p>
						<p><img src="<?php echo base_url('/');?>img/help/images/add-new-gallery.png"></p>

						<p><b><i>Gallery Details</i></b></p>
						<p>Fill in the user details and click ADD GALLERY button</p>
						<p>Figure 3</p>
						<p><img src="<?php echo base_url('/');?>img/help/images/gallery-form.png"></p>

						<p><b><i>Edit Gallery / upload image into Gallery</i></b></p>
						<p>To edit a gallery click the gallery’s title or a grey button with a pen icon in the gallery list.</p>
						<p>Figure 4</p>
						<p><img src="<?php echo base_url('/');?>img/help/images/edit-gallery.png"></p>

						<p>To add images into a gallery drag and drop file(s) into a box on the right hand side box, click “Start upload”.</p>
						<p>Figure 5</p>
						<p><img src="<?php echo base_url('/');?>img/help/images/add-image.png"></p>
						<p>Figure 6</p>
						<p><img src="<?php echo base_url('/');?>img/help/images/upload-image.png"></p>

						<p>Listing all uploaded files in the gallery. The list shows the file title, edit option and the delete option.</p>
						<p>Figure 7</p>
						<p><img src="<?php echo base_url('/');?>img/help/images/list-images.png"></p>

						<p>To edit a file click on the pen icon and the pop up box will appear, fill in all the required details and click Update image.</p>
						<p>Figure 8</p>
						<p><img src="<?php echo base_url('/');?>img/help/images/edit-file.png"></p>
						
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
									<td valign="top" ><p><b>Images</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p><b>Add Gallery</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Gallery Details</p></td>
									<td valign="top" ><p>3</p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Edit/Upload Image to Gallery</p></td>
									<td valign="top" ><p>2</p></td>
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