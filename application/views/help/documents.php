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
						<a href="#">Documents</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Documents</h2>
					</div>
					<div class="box-content">

						<p><b>DOCUMENTS</b></p>

						<p>This section handles the uploading of documents into the CMS.</p>

						<p>Figure 1</p>
						<p><img src="<?php echo base_url('/');?>img/help/documents/docs.png"></p>

						<p><b><i>Add Documents</i></b></p>
						<p>To add documents click Add files in the box at the right-hand side and click “Start Upload”. One can upload more than 2 files at the same-time.</p>
						<p>Figure 2</p>
						<p><img src="<?php echo base_url('/');?>img/help/documents/add-doc.png"></p>
						<p>Figure 3</p>
						<p><img src="<?php echo base_url('/');?>img/help/documents/upload-docs.png"></p>

						<p><b><i>Edit Documents</i></b></p>
						<p>To edit the document click the grey button.</p>
						<p>Figure 4</p>
						<p><img src="<?php echo base_url('/');?>img/help/documents/edit-doc.png"></p>
						<p>Fill in the document details: Title, name and indicate if visitor can download the document</p>
						<p>Figure 5</p>
						<p><img src="<?php echo base_url('/');?>img/help/documents/edit-doc-details.png"></p>

						<p><b><i>Delete Documents</i></b></p>
						<p>To delete the document click the red button</p>
						<p>Figure 6</p>
						<p><img src="<?php echo base_url('/');?>img/help/documents/edit-doc.png"></p>
						
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
									<td valign="top" ><p><b>Documents</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Add Documents</p></td>
									<td valign="top" ><p>2</p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Edit Documents</p></td>
									<td valign="top" ><p>3</p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Delete Documents</p></td>
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