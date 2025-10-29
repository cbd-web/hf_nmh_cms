<?php $this->load->view('admin/inc/header');?>
<style type="text/css">

		.placeholder {
			outline: 1px dashed #4183C4;
			/*-webkit-border-radius: 3px;
			-moz-border-radius: 3px;
			border-radius: 3px;
			margin: -1px;*/
		}

		.mjs-nestedSortable-error {
			background: #fbe3e4;
			border-color: transparent;
		}

		ol {
			margin: 0;
			padding: 0;
			padding-left: 30px;
		}

		ol.sortable, ol.sortable ol {
			margin: 0 0 0 40px;
			padding: 0;
			list-style-type: none;
		}

		ol.sortable {
			margin: 4em 0;
		}

		.sortable li {
			margin: 5px 0 0 0;
			padding: 0;
		}

		.sortable li div  {

			padding: 6px;
			margin: 0;
			cursor: move;
			
		}

		.sortable li.mjs-nestedSortable-branch div {
			background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #f0ece9 100%);
			background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#f0ece9 100%);

		}

		.sortable li.mjs-nestedSortable-leaf div {
			background: -moz-linear-gradient(top,  #ffffff 0%, #f6f6f6 47%, #bcccbc 100%);
			background: -webkit-linear-gradient(top,  #ffffff 0%,#f6f6f6 47%,#bcccbc 100%);

		}

		li.mjs-nestedSortable-collapsed.mjs-nestedSortable-hovering div {
			border-color: #999;
			background: #fafafa;
		}

		.disclose {
			cursor: pointer;
			width: 10px;
			display: none;
		}

		.sortable li.mjs-nestedSortable-collapsed > ol {
			display: none;
		}

		.sortable li.mjs-nestedSortable-branch > div > .disclose {
			display: inline-block;
		}

		.sortable li.mjs-nestedSortable-collapsed > div > .disclose > span:before {
			content: '+ ';
		}

		.sortable li.mjs-nestedSortable-expanded > div > .disclose > span:before {
			content: '- ';
		}
		
		.box-content .box-icon .btn-close{float:right;margin-top:-5px;padding-top:0px; display:inline-block}

</style>

<body>
	
		<?php $this->load->view('admin/inc/nav_top');?>
		
		<div class="container-fluid">
		<div class="row-fluid">
			<?php $this->load->view('admin/inc/nav_main');?>
			<div id="content" class="span10">
			<!-- start: Content -->
			
			<div>
				<hr>
				<ul class="breadcrumb">
					<li>
						<a href="#">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="#">Menu</a>
					</li>
				</ul>
				<hr>
			</div>
			
			
            
           <!--sortable row1 -->
			<div class=" row-fluid">
				<!--menu row 1 -->
                <div class="box noMargin span12" ontablet="span12" ondesktop="span12">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Menu</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						    
                            <?php
                                 $this->admin_model->get_all_menus();
								
								?>
                            <form id="menu-update" name="menu-update" method="post" action="<?php echo site_url('/');?>admin/update_menu_do" class="form-horizontal">
                             <fieldset>
                            	<input type="hidden" id="menu_txt" name="menu" value="<?php echo $menu;?>" />
	                             <a href="<?php echo site_url('/');?>admin/update_menu/0" type="submit" class="btn btn-default btn pull-right" >Add Menu</a>
                             </fieldset>    
                            </form>
					</div>
				</div>

                
                
			</div>
			<!--end sortable row1 -->
            
            
			<hr>

				
			<hr>

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		<div class="modal hide fade" id="myModal">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">×</button>
				<h3>Settings</h3>
			</div>
			<div class="modal-body">
				<p>Here settings can be configured...</p>
			</div>
			<div class="modal-footer">
				<a href="#" class="btn" data-dismiss="modal">Close</a>
				<a href="#" class="btn btn-primary">Save changes</a>
			</div>
		</div>
		
        <div class="clearfix"></div>
        <div id="cal_script"></div>        
	
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    <script type="text/javascript" src="<?php echo base_url('/');?>admin_src/js/jquery.mjs.nestedSortable.js"></script>
    
	<script type="text/javascript">
		$(document).ready(function(){


		    $('select').selectpicker({
			    liveSearch: true,
			    size: 4
		    });


			
				$('ol.sortable').nestedSortable({
					forcePlaceholderSize: true,
					handle: 'div',
					helper:	'clone',
					items: 'li',
					opacity: .6,
					placeholder: 'placeholder',
					revert: 250,
					tabSize: 25,
					tolerance: 'pointer',
					toleranceElement: '> div',
					maxLevels: 3,
		
					isTree: true,
					expandOnHover: 700,
					startCollapsed: true
				});
		
				$('.disclose').on('click', function() {
					$(this).closest('li').remove();
				})
		
				$('#serialize').click(function(){
					serialized = $('ol.sortable').nestedSortable('serialize');
					$('#serializeOutput').text(serialized+'\n\n');
				})
		
				$('#toHierarchy').click(function(e){
					hiered = $('ol.sortable').nestedSortable('toHierarchy', {startDepthCount: 0});
					hiered = dump(hiered);
					(typeof($('#toHierarchyOutput')[0].textContent) != 'undefined') ?
					$('#toHierarchyOutput')[0].textContent = hiered : $('#toHierarchyOutput')[0].innerText = hiered;
				})
		
				$('#toArray').click(function(e){
					arraied = $('ol.sortable').nestedSortable('toArray', {startDepthCount: 0});
					arraied = dump(arraied);
					$('#menu_txt').val(arraied);
					(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
					$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
				})
			
			
			

				
		  	   $('#butt').bind('click', function(e) {

					e.preventDefault();
					var frm = $('#menu-update');
					
					arraied = $('ol.sortable').nestedSortable('serialize');
					
					$('#menu_txt').val(arraied);
					console.log(arraied);
					
					
					//frm.submit();
					$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
					$.ajax({
						type: 'post',
						data: frm.serialize(),
						url: '<?php echo site_url('/').'admin/update_menu_do';?>' ,
						success: function (data) {
							 
							 $('#result_msg').html(data);
							 $('#butt').html('Save Menu');
							
						}
					});	
			   });
				
			  $('div.btn-group button').live('click', function(){
				  
				  $('#status').attr('value', $(this).html());
			  });
  

		});
		
		function dump(arr,level) {
					var dumped_text = "";
					if(!level) level = 0;
			
					//The padding given at the beginning of the line.
					var level_padding = "";
					for(var j=0;j<level+1;j++) level_padding += "    ";
			
					if(typeof(arr) == 'object') { //Array/Hashes/Objects
						for(var item in arr) {
							var value = arr[item];
			
							if(typeof(value) == 'object') { //If it is an array,
								dumped_text += level_padding + "'" + item + "' ...\n";
								dumped_text += dump(value,level+1);
							} else {
								dumped_text += level_padding + "'" + item + "' => \"" + value + "\"\n";
							}
						}
					} else { //Strings/Chars/Numbers etc.
						dumped_text = "===>"+arr+"<===("+typeof(arr)+")";
					}
					return dumped_text;
		}

	</script>
    
</body>
</html>