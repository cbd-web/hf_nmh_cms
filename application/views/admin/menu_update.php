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
							<a href="<?php echo site_url('/');?>admin/menu/">Menus</a> <span class="divider">/</span>
						</li>
						<li>
							<a href="">Update Menu <?php if(isset($title)){echo $title;}?></a>
						</li>
					</ul>
					<hr>
				</div>



				<!--sortable row1 -->
				<div class=" row-fluid">
					<!--menu row 1 -->
					<div class="box noMargin span8" ontablet="span8" ondesktop="span8">
						<div class="box-header">
							<h2><i class="icon-list"></i><span class="break"></span>Menu</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
									<form id="menu-update" name="menu-update" method="post" action="<?php echo site_url('/');?>admin/update_menu_do" class="form-horizontal">


			                             <fieldset>

			                                <input type="hidden" id="menu_txt" name="menu" value="<?php echo $menu;?>" />
				                             <input type="hidden" name="menu_id"  value="<?php if(isset($menu_id)){echo $menu_id;}?>">
				                             <input type="hidden" name="autosave" id="autosave"  value="true">
				                             <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
				                             <input type="hidden" name="type" id="type"  value="<?php if(isset($type)){echo $type;}?>">
				                             <input type="hidden" name="position" id="position"  value="<?php if(isset($position)){echo $position;}?>">

				                             <div class="control-group">
					                             <label class="control-label">Title</label>
					                             <div class="controls">
						                             <input type="text" id="title" name="title" placeholder="Menu title" value="<?php if(isset($title)){echo $title;}?>">
					                             </div>
											 </div>
				                             <div class="control-group">
					                             <label class="control-label" for="title">Status</label>
					                             <div class="controls">

						                             <div class="inline-group">
							                             <label class="radio">
								                             <input type="radio" data-name="status" data-value="live" name="status_temp" <?php if($status == 'live'){ echo ' checked="checked"';}?> >
								                             <i></i>Live</label>
							                             <label class="radio">
								                             <input type="radio" data-name="status" data-value="draft" name="status_temp" <?php if($status == 'draft'){ echo ' checked="checked"';}?>>
								                             <i></i>Draft</label>

						                             </div>

				                                </div>
					                         </div>
				                             <br />
				                             <div class="control-group">
					                             <label class="control-label" for="type">Position</label>
					                             <div class="controls">

					                             <div class="inline-group">
						                             <label class="radio">
							                             <input type="radio" data-name="position" data-value="top" name="position_temp" <?php if($position == 'top'){ echo ' checked="checked"';}?> >
							                             <i></i>Top</label>
						                             <label class="radio">
							                             <input type="radio" data-name="position" data-value="left" name="position_temp" <?php if($position == 'left'){ echo ' checked="checked"';}?>>
							                             <i></i>Left</label>
						                             <label class="radio">
							                             <input type="radio" data-name="position" data-value="right" name="position_temp" <?php if($position == 'right'){ echo ' checked="checked"';}?> >
							                             <i></i>Right</label>
						                             <label class="radio">
							                             <input type="radio" data-name="position" data-value="bottom" name="position_temp" <?php if($position == 'bottom'){ echo ' checked="checked"';}?>>
							                             <i></i>Bottom</label>
					                             </div>

				                                </div>
				                             </div>
				                             <br />
				                             <div class="control-group">
					                             <label class="control-label"  for="type">Type</label>
					                             <div class="controls">

						                             <div class="inline-group">
							                             <label class="radio">
								                             <input type="radio" data-name="type" data-value="main" name="type_temp" <?php if($type == 'main'){ echo ' checked="checked"';}?> >
								                             <i></i>Main</label>
							                             <label class="radio">
								                             <input type="radio" data-name="type" data-value="middle" name="type_temp" <?php if($type == 'sub'){ echo ' checked="checked"';}?>>
								                             <i></i>Middle</label>
							                             <label class="radio">
								                             <input type="radio" data-name="type" data-value="sub" name="type_temp" <?php if($type == 'sub'){ echo ' checked="checked"';}?> >
								                             <i></i>Sub</label>
							                             <label class="radio">
								                             <input type="radio" data-name="type" data-value="footer" name="type_temp" <?php if($type == 'footer'){ echo ' checked="checked"';}?> >
								                             <i></i>Footer</label>
							                             <label class="radio">
								                             <input type="radio" data-name="type" data-value="other" name="type_temp" <?php if($type == 'other'){ echo ' checked="checked"';}?> >
								                             <i></i>Other</label>
						                             </div>

					                             </div>
					                         </div>
			                             </fieldset>
										<div class="control-group">
											<?php
											if($menu == ''){

												$this->admin_model->show_menu($menu);

											}else{

												$this->admin_model->show_menu($menu);

											}

											?>
										</div>

					                            <button type="submit" class="btn btn-default btn pull-right" id="butt">Save Menu</button>
										<div class="clearfix">&nbsp;</div>
										<div id="result_msg"></div>
										<!--<a id="toArray" class="btn btn-primary" >Array</a>
										<p id="log_txt"></p>
										<pre id="toArrayOutput"></pre>-->
		                            </form>
						</div>

					</div>



					<div class="box noMargin span4" ontablet="span4" ondesktop="span4">
						<div class="box-header">
							<h2><i class="icon-list"></i><span class="break"></span>Menu</h2>
							<div class="box-icon">
								<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
								<a href="#" class="btn-close"><i class="icon-remove"></i></a>
							</div>
						</div>
						<div class="box-content">
							<?php $this->admin_model->get_pages_nav_builder();?>

						</div>
					</div>


				</div>





				<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->

		<div class="clearfix">&nbsp;</div>
	<?php $this->load->view('admin/inc/footer');?>
</div>
    
    <script type="text/javascript" src="<?php echo base_url('/');?>admin_src/js/jquery.mjs.nestedSortable.js"></script>
    
	<script type="text/javascript">
		$(document).ready(function(){


		   /* $('select').selectpicker({
			    liveSearch: true,
			    size: 4
		    });*/

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
		
				$('.rem_men').on('click', function() {
					console.log(this+'yeah');
					$(this).closest('li').remove();
				});
		
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
					$('#log_txt').html(arraied);
					(typeof($('#toArrayOutput')[0].textContent) != 'undefined') ?
					$('#toArrayOutput')[0].textContent = arraied : $('#toArrayOutput')[0].innerText = arraied;
				})
			
			
			

				
		  	   $('#butt').bind('click', function(e) {

					e.preventDefault();
					var frm = $('#menu-update');
					
					arraied = $('ol.sortable').nestedSortable('serialize');
					
					$('#menu_txt').val(arraied);
			       // $('#log_txt').html(arraied);
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



			  $('div.btn-group button').on('click', function(){
				  
				  $('#status').attr('value', $(this).html());
			  });

			$('div.inline-group input').on('click', function(){

				var name = $(this).data('name'), val = $(this).data('value');
				$('#'+name).attr('value', val);
				console.log
			});
			$('#post-update :input').change(function() {

				$('#autosave').val('false');
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