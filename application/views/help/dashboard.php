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
						<a href="#">Dashboard</a>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid">
				<div class="box span8" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-calendar"></i><span class="break"></span>Dashboard</h2>
					</div>
					<div class="box-content">

						<p><b>DASHBOARD</b></p>

						<p><b>Getting Started</b></p>

						<p><b><i>What is a CMS (Content Management System)?</i></b></p>

						<p>A content management system (CMS) is a computer software system for organizing and facilitating collaborative creation of documents and other content. For our purposes, a CMS is deployed as web application for easily managing web sites/content. CMS‟s make web page content management simple for even non-technical users, allowing designated users to change most aspects of their sites themselves, without the intervention of a web developer. Anyone with basic word processing skills can easily learn to manage the CMS deployed for your website</p>

						<p><b><i>What is a CMS (Content Management System)?</i></b></p>

						<p>Up until recently, changes to INTOUCH websites were done primarily by web developers themselves. This meant that, whenever clients had a page update, these changes had to be sent to the developers to post on their behalf. The process, while more centralized, doesn’t facilitate timely delivery of web content, nor does it necessarily encourage clients to keep their sites up-to-date, of their own accord.</p>
						<p>In a CMS, pages and content can be added via a browser interface without requiring users to understand “web” languages such as HTML and CSS (although knowing these languages makes the process even easier).</p>

						<p><b><i>Objective of this Manual</i></b></p>

						<p>The objectives of this manual are to:</p>

						<ul>
							<li>Help you understand why your site is being converted to a content management system.</li>
							<li>Provide you with hands-on instructions for managing your CMS, for both the front (the “visitor” area) and back-end (the “administrative” area) of your site.</li>
						</ul>

						<p>This manual guide is divided into different sections explaining each component. This has been done because CMS.MY.NA has lot of components and these components or plugins are enabled according to the client’s website requirements. For an example a Real Estate website CMS doesn’t have the same components as a Restaurant website CMS.</p>
						<p>So our clients only need to learn how to use the right components of the CMS for their websites. </p>
					
						<p><b>System Summary</b></p>

						<p>By the time you have received this manual, I’m pretty sure you should already have access to the initial configured of the CMS representing your web site. We already explain what a CMS is and why CMS.MY.NA, here we just want to go a little bit deep about this CMS. (Don’t get me wrong this is not a technical manual, hey).</p>
						<p>If you are a web developer or already have a thorough understanding of the CMS or programming languages, this will be interesting and if you are none of the mentioned above you will likely want to skip this beginner’s manual and proceed directly.</p>

						<p><b>LOGIN</b></p>

						<p>In the web browser navigate to this URL (http://cms.my.na/)</p>
						<p>And enter your login details to login (Email address and Password).</p>

						<p>Figure 1</p>

						<p><img src="<?php echo base_url('/');?>img/help/dashboard/login.png"></p>

						<p>If you want the system to remember your credentials next time you visit check the “Stay signed in” box.</p>

						<p><b>TOP BAR</b></p>

						<p>CMS.MY.NA (Figure 2). Allocated on top of the page, the top bar displays the client organization name on the left and user settings on the right side.</p>

						<p>Figure 2</p>

						<p><img src="<?php echo base_url('/');?>img/help/dashboard/topbar.png"></p>

						<p><b>DASHBOARD</b></p>

						<p>When a user logged in, she/he is directed to the main page “Dashboard”. The Dashboard consists of website statistics.</p>

						<p>Figure 3</p>

						<p><img src="<?php echo base_url('/');?>img/help/dashboard/dashboard.png"></p>
						
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
									<td valign="top" ><p><b>Dashboard</b></p></td>
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