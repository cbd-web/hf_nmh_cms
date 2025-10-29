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
						<a href="#">Pages</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Pages</h2>
					</div>
					<div class="box-content">

						<p><b>PAGES</b></p>

						<p>List all pages on the website, with options to sort them by Title, Body, Parent and Page Template. One can use a search form to search for a certain page in the CMS.</p>

						<p>Figure 1</p>
						<p><img src="<?php echo base_url('/');?>img/help/pages/pages.png"></p>

						<p><b><i>Add a Page</i></b></p>
						<p>To add a new page, click on the black button “Add New Page”</p>
						<p>Figure 2</p>
						<p><img src="<?php echo base_url('/');?>img/help/pages/add-new-page.png"></p>

						<p><b><i>Page details</i></b></p>
						<p>Fill in all the information:</p>
						<p><b>Title:</b> This is the page title, the page title is the most important on-page ranking factors and page title tag shows up in Search Engine Result Pages.</p>
						<p><b>Heading:</b> This is the page heading, usually used within the website as the page header.</p>
						<p><b>Slug:</b> The page URL.</p>
						<p><b>Parent:</b> Page parents us- full in the breadcrumbs.</p>
						<p><b>Sequence:</b> The position of the page in the page list.</p>
						<p><b>Page Template:</b> This is the template of the page, the look and feel.</p>
						<p><b>Page body:</b> The page content text, images and media.</p>
						<p><b>Website URL:</b> Not real optional.</p>
						<p><b>Featured Document:</b> These are page attached documents available for downloading or just viewing in the CMS.</p>
						<p><b>Meta Title:</b> Text that tell the browsers (or other web services) specific information about the page. Simply, it “explains” the page so a browser can understand it.</p>
						<p><b>Meta Description:</b> The purpose of a Meta description tag is to provide a brief and concise summary of the website's content.</p>
						<p>Figure 3</p>
						<p><img src="<?php echo base_url('/');?>img/help/pages/create-page.png"></p>

						<p>After filling all required details click on the "Add Page" button to save the page. See figure 3</p>

						<p><b><i>Edit Page</i></b></p>
						<p>To edit a page click on the page title or on the pencil button in the page list.</p>
						<p>Figure 4</p>
						<p><img src="<?php echo base_url('/');?>img/help/pages/edit-page.png"></p>

						<p>To allow website visitors to view the page, change the page status to “LIVE” and “Draft” to hide it from the visitors (Draft status recommended when the page is under development).</p>
						<p>Figure 5</p>
						<p><img src="<?php echo base_url('/');?>img/help/pages/live.png"></p>
						<p>Figure 6</p>
						<p><img src="<?php echo base_url('/');?>img/help/pages/page-options.png"></p>

						<p><b>Page Sidebar:</b> Attach page sidebar content.</p>
						<p><b>Featured Image:</b> Upload page featured image.</p>
						<p><b>Gallery:</b> You can attach a certain gallery to the page to be displayed on that page.</p>
						<p><b>Contact Form:</b> Page contact form.</p>

						<p><b><i>Page Search and Records view</i></b></p>
						<p>These two functions allow you to get easy access to a certain page in the CMS; the record per page limits the number of pages to be displayed in the list and the search for specific page.</p>
						<p>Figure 7</p>
						<p><img src="<?php echo base_url('/');?>img/help/pages/search.png"></p>

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