<?php $this->load->view('admin/inc/header');?>
<style type="text/css">

	.vector-map {
		height: 430px;
		width: 100%;
		padding: 10px;
	}
	.fill-a, .fill-b {
		width: 20px;
		text-align: right;
		overflow: hidden;
		text-overflow: ellipsis;
		display: block;
		background: #fff;
		padding-right: 4px;
		position: absolute;
		left: 0;
		margin-top: -7px;
		font-weight: 700;
	}
	.icon-plus-sign , .fa-plus{
		background-position: 0 -96px;
	}
	.icon-minus-sign {
		background-position: -24px -96px;
	}
	.jvectormap-zoomin, .jvectormap-zoomout {
		position: absolute;
		background: #292929;
		padding: 4px;
		width: 22px;
		height: 22px;
		cursor: pointer;
		line-height: 10px;
		text-align: center;
		font-size: 14px;
		border-radius: 2px;
		-webkit-border-radius: 2px;
		-moz-border-radius: 2px;
		box-shadow: inset 0 -2px 0 rgba(0,0,0,.05);
		-moz-box-shadow: inset 0 -2px 0 rgba(0,0,0,.05);
		-webkit-box-shadow: inset 0 -2px 0 rgba(0,0,0,.05);
		background-color: #fff;
		border: 1px solid #bfbfbf;
	}
	.jvectormap-zoomin:hover,.jvectormap-zoomout:hover{background:#eee;border-color:#d9d9d9}.jvectormap-zoomin{top:0}.jvectormap-zoomout{top:24px}
	#heat-fill{display:block;position:relative;margin-bottom:20px;background:#333;height:7px;width:200px;background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAMgAAAABCAIAAAAU3Xa1AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyFpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuNS1jMDE0IDc5LjE1MTQ4MSwgMjAxMy8wMy8xMy0xMjowOToxNSAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENDIChXaW5kb3dzKSIgeG1wTU06SW5zdGFuY2VJRD0ieG1wLmlpZDowMDE4MkZGMzMzOTgxMUUzODZBQUNFQUNFOTk0NEUxRiIgeG1wTU06RG9jdW1lbnRJRD0ieG1wLmRpZDowMDE4MkZGNDMzOTgxMUUzODZBQUNFQUNFOTk0NEUxRiI+IDx4bXBNTTpEZXJpdmVkRnJvbSBzdFJlZjppbnN0YW5jZUlEPSJ4bXAuaWlkOjAwMTgyRkYxMzM5ODExRTM4NkFBQ0VBQ0U5OTQ0RTFGIiBzdFJlZjpkb2N1bWVudElEPSJ4bXAuZGlkOjAwMTgyRkYyMzM5ODExRTM4NkFBQ0VBQ0U5OTQ0RTFGIi8+IDwvcmRmOkRlc2NyaXB0aW9uPiA8L3JkZjpSREY+IDwveDp4bXBtZXRhPiA8P3hwYWNrZXQgZW5kPSJyIj8+rG8MDAAAAM5JREFUeNpUUtESwyAIg8ft9v8/W4ElBPWKV1AIiKEeEWVuVlWjINSVONBnirQDxukNgcuyTQsBzLHMDsLIQQw+nIL71JqNJ5GZJXApFNpmtlagQjfS2xGbkFA4Iwu+hu0sK3Wl3nOwNv7TvPrWk3X0eW9dK1pU9hK2eTuWb2ySJmlziutA3iBxmblPNvA5PNsuUpoDY80+Z0SW1IRpDEqwC58C14tsr1f8le8si0aojdADr/1UjaclsFashX8GGkL9wDxtRsV6ft/PX4ABADRzhOVIOJaAAAAAAElFTkSuQmCC)}.fill-b{text-align:left;position:absolute;right:0;left:auto;top:0;width:60px;padding-left:4px;padding-right:0}
</style>
<link rel="stylesheet" type="text/css" href="<?php echo base_url('/');?>admin_src/bootstrap-daterangepicker-master/daterangepicker-bs2.css" />
<body>

	<div id="overlay">
		<ul>
		  <li class="li1"></li>
		  <li class="li2"></li>
		  <li class="li3"></li>
		  <li class="li4"></li>
		  <li class="li5"></li>
		  <li class="li6"></li>
		</ul>
        <img src="//www.my.na/img/my-na-logo-black.png" alt="My Namibia" />
	</div>	
		<?php $this->load->view('admin/inc/nav_top');?>
		
	<div class="container-fluid">
		<div class="row-fluid">
			<?php $this->load->view('admin/inc/nav_main');?>
			<div id="content" class="span10">
			<!-- start: Content -->
			<hr>
			<div class="row-fluid">

				<div class="span6">

					<ul class="breadcrumb" style="margin-top:0px">
						<li>
							<a href="#">Home</a> <span class="divider">/</span>
						</li>
						<li>
							<a href="#">Dashboard</a>
						</li>
					</ul>

				</div>
				<div class="span6">

				</div>

			</div>

			<hr>
			
           
			<div class="sortable row-fluid">
				
			 <?php $this->admin_model->get_dashboard_navigation();
			
				
			?>	
				
			</div>
			
			<hr>

			<div class="row-fluid">

			   <?php $this->admin_model->get_system_logs(); ?>	
				
			</div>
				
			<hr>

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
        <div class="clearfix"></div>    
	
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
	<script src="<?php echo base_url('/')?>admin_src/js/vectormap/jquery-jvectormap-1.2.2.min.js"></script>
	<script src="<?php echo base_url('/')?>admin_src/js/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){


		});
	</script>
</body>
</html>