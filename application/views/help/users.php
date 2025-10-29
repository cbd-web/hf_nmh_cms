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
						<a href="#">Users</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Users</h2>
					</div>
					<div class="box-content">
						
						<p><b>USERS</b></p>

						<p>This component create users, people who will be in charge of updating and maintain the website content, there are two types of users: <b>Admin</b> and <b>Editor.</b></p>

						<p>Figure 1</p>

						<p><img src="<?php echo base_url('/');?>img/help/users/users.png"></p>

						<p><b><i>Add user</i></b></p>

						<p>To add a new user; click on the black button Add New User</p>

						<p>Figure 2</p>
						<p><img src="<?php echo base_url('/');?>img/help/users/add user.png"></p>

						<p>Fill in the user details and click Add user</p>

						<p>Figure 3</p>
						<p><img src="<?php echo base_url('/');?>img/help/users/popup.png"></p>
						<p><b><i>Edit user</i></b></p>

						<p>To edit a user click the Grey button with a pen icon in the user list.</p>

						<p>Figure 4</p>
						<p><img src="<?php echo base_url('/');?>img/help/users/edit user.png"></p>
						<p><b><i>Delete User</i></b></p>

						<p>To delete a user click the red button with a dustbin icon in the user list.</p>

						<p>Figure 5</p>
						<p><img src="<?php echo base_url('/');?>img/help/users/delete user.png"></p>
						<div class="clearfix"></div>
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
									<td valign="top" ><p><b>Users</b></p></td>
									<td valign="top" ><p><b>2</b></p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Add User</p></td>
									<td valign="top" ><p>2</p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Edit User</p></td>
									<td valign="top" ><p>3</p></td>
								</tr>

								<tr>
									<td valign="top" ><p>Delete User</p></td>
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