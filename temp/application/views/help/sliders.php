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
						<a href="#">Sliders</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Sliders</h2>
					</div>
					<div class="box-content">

						<p><b>SLIDERS</b></p>

						<p>Figure 1</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/slides.png"></p>

						<p><b><i>Add Slider</i></b></p>
						<p>To add slider image click Add files in the box at the right-hand side and click “Start Upload”. One can upload more than 2 files at the same-time.</p>
						<p>Figure 2</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/add-files.png"></p>
						<p>Figure 3</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/start-uploading.png"></p>

						<p><b><i>Update Slider</i></b></p>
						<p>To update the slider’s image click the blue button.</p>
						<p>Figure 4</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/edit-slide-image.png"></p>
						
						<p><b>Crop Photo</b></p>
						<p>Move the cropping slider with the mouse cursor, to the desire image size and click “Crop image”. Click return button to go back to the slider list.</p>
						<p>Figure 5</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/crop-image.png"></p>

						<p><b>Rotate Photo</b></p>
						<p>Rotate image clockwise or counter-clockwise.</p>
						<p>Figure 6</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/rotate-image.png"></p>

						<p><b><i>Edit Slider</i></b></p>
						<p>To edit the slider’s image click the grey pen button.</p>
						<p>Figure 7</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/edit-slider.png"></p>

						<p>Fill in the slider details: Slider Title, Slider Link, Slider Text and Status “Draft or Live”</p>
						<p>Figure 8</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/slider-pop.png"></p>


						<p><b><i>Delete Slider</i></b></p>
						<p>To delete the slider’s image click the red button</p>
						<p>Figure 9</p>
						<p><img src="<?php echo base_url('/');?>img/help/sliders/delete-slider.png"></p>

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
									<td valign="top" ><p><b>Sliders</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p><b>Add Slider</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p><b>Update Slider</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p><b>Crop Image</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p><b>Rotate Image</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p><b>Edit Slider</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p><b>Delete Slider</b></p></td>
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