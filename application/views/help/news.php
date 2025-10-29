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
						<a href="#">News/Blog</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>News/Blog</h2>
					</div>
					<div class="box-content">

						<p><b>NEWS/BLOG POSTS</b></p>

						<p>This option handles the News/Blog posts.</p>

						<p>Figure 1</p>
						<p><img src="<?php echo base_url('/');?>img/help/news-blog/news-posts.png"></p>

						<p><b><i>Add a New Post</i></b></p>
						<p>To add a new post click on a “Add New Post” button</p>
						<p>Figure 2</p>
						<p><img src="<?php echo base_url('/');?>img/help/news-blog/add-post.png"></p>

						<p>Fill in all the required details and click “Add Post” to save the post.</p>
						<p>Figure 3</p>
						<p><img src="<?php echo base_url('/');?>img/help/news-blog/post-form.png"></p>

						<p>Category option, classified the news posts. Type the category name into the input box and click “Add Category”.</p>
						<p>Figure 4</p>
						<p><img src="<?php echo base_url('/');?>img/help/news-blog/post-category.png"></p>

						<p><b><i>Edit Post</i></b></p>
						<p>To edit a post click the post’s title or a grey button with a pen icon in the post list.</p>
						<p>Figure 5</p>
						<p><img src="<?php echo base_url('/');?>img/help/news-blog/edit-post.png"></p>

						<p>To let users to view the post on the website change the Status to LIVE, to hide it from the website visitors put the status on Draft. To allow website visitors to comment on the post change the comments to Allow.</p>					
						<p>Figure 6</p>
						<p><img src="<?php echo base_url('/');?>img/help/news-blog/post-status.png"></p>

						<p>There are options for Featured Image, post sidebar and gallery attachment. The feature image is always the image that displayed on the website.</p>
						<p>Figure 7</p>
						<p><img src="<?php echo base_url('/');?>img/help/news-blog/post-featured.png"></p>
						<p>Don’t forget to save afterward, click Update Post button to save.</p>

						<p><b><i>Delete Post</i></b></p>
						<p>To delete a post click the post’s orange button with a dustbin icon in the post list.</p>
						<p>Figure 8</p>
						<p><img src="<?php echo base_url('/');?>img/help/news-blog/delete-post.png"></p>

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