<?php $this->load->view('admin/inc/header');

$settings = $this->property_model->get_settings();

$prefix = $settings['prefix'];

$date = date('dmYs');

$ref_no = $prefix.'-'.$date;

?>
<link href="<?php echo base_url('/');?>admin_src/css/datepicker.css" rel="stylesheet">
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
						<a href="<?php echo site_url('/');?>">Home</a> <span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>property/properties/">Properties</a><span class="divider">/</span>
					</li>
                    <li>
						Add New Property
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Property</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="property-add" name="property-add" method="post" action="<?php echo site_url('/');?>property/add_property_do" class="form-horizontal">

							 <input type="hidden" value="For Sale" name="status_type" id="status-type">
							 <input type="hidden" value="Residential" name="property_type" id="property-type">
							 <input type="hidden" value="House" name="building_type" id="building-type">

                             <fieldset>
    
                                          <div class="control-group">
                                            <label class="control-label" for="title">Title</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="title" name="title" placeholder="Property title" value="">
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label" for="title">Heading</label>
											 <div class="controls">
												 <input type="text" class="span6" id="heading" name="heading" placeholder="Property heading" value="">
											 </div>
										 </div>

										  <div class="control-group">
											 <label class="control-label" for="ref_no">Reference Number</label>
											 <div class="controls">
												 <input type="text" class="span6" id="ref_no" name="ref_no" placeholder="Property Reference Number" value="<?php echo $ref_no; ?>">
											 </div>
										  </div>


										 <div class="control-group">
											 <label class="control-label">Property Status</label>
											 <div class="controls">
												 <select name="prop_status">
													 <option value="current">Current</option>
													 <option value="completed">Completed</option>
													 <option value="sold">Sold</option>
												 </select>
											 </div>
										 </div>


										  <div class="control-group">
                                            <label class="control-label">Type</label>
                                            <div class="controls">
												<select name="sub_type" id="sub-type">
													<?php echo $this->property_model->get_category_select(3408) ?>
												</select>
                                            </div>
                                          </div>

										 <div class="control-group">
											 <label class="control-label">Property Type</label>
											 <div class="controls">
												 <select name="sub_sub_type" id="sub-sub-type">
													 <?php echo $this->property_model->get_category_select(3408,3409) ?>
												 </select>
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label">Building Type</label>
											 <div class="controls">
												 <select name="sub_sub_sub_type" id="sub-sub-sub-type">
													 <?php echo $this->property_model->get_category_select(3408,3409,3411) ?>
												 </select>
											 </div>
										 </div>


										 <div class="control-group">
											 <label class="control-label" for="category">Location</label>
											 <div class="controls">
												 <select name="location" id="property_location">
													 <?php echo $this->property_model->get_location_list('Windhoek'); ?>
												 </select>
											 </div>
										 </div>

										 <div class="control-group">
											 <label class="control-label" for="category">Suburb</label>
											 <div class="controls">
												 <select name="suburb" id="property_suburb">
													 <?php echo $this->property_model->get_suburb_list('Windhoek'); ?>
												 </select>
											 </div>
										 </div>


								         <div class="control-group">
                                            <label class="control-label" for="price">Price (N$)</label>
                                            <div class="controls">
                                                    <input type="text" class="span6" id="price" name="price" onkeypress="return isNumberKey(event)" placeholder="Price" value="">
													<span id="money-preview" style="margin-left:10px"></span>
                                            </div>

                                         </div>

                            
                                          <div class="control-group" id="redactor_content_msg">
                                                <label class="control-label" for="redactor_content">Property Body:</label>
                                                <div class="controls">
                                                    
                                                    <textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
                                                </div>
                                           </div>

										 <div class="control-group">
											 <label class="control-label" for="pub_date">Publish date</label>
											 <div class="controls">
												 <div class="input-append date" id="property_date" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
													 <input type="text" name="property_date" value="<?php echo date('Y-m-d'); ?>">
													 <span class="add-on"><i class="icon-calendar"></i></span>
												 </div>
												 <span class="help-block" style="font-size:11px">Select the date the property is published</span>
											 </div>
										 </div>


										   <div class="control-group">
											   <label class="control-label" for="metaT">Meta Title:</label>
												<div class="controls">
													<textarea name="metaT" style="display:block" class="span6"></textarea>
													<span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
												 </div>
										   </div>

                                           
                                            
										   <div class="control-group">
												<label class="control-label" for="metaD">Meta Description:</label>
												<div class="controls">
													 <textarea name="metaD" style="display:block" class="span6"></textarea>
													 <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther product.</span>
												</div>
										   </div>

                                          <div id="result_msg"></div>
                                          <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Property</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               
                
                
			</div>
			
			<hr>
			
			<div class="row-fluid">
				
				
				
			</div>
			
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
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>	
	<script type="text/javascript">
	
	$(document).ready(function(){

		var money_pre = $('#money-preview');
		$('#price').on('input', function () {

			var temp = parseFloat($(this).val() + '.' + $('#price_c').val());
			money_pre.html('N$ ' + temp.formatMoney(2, '.', ','));

		});
		$('#price_c').on('input', function () {

			var temp = parseFloat($('#price').val() + '.' + $(this).val());
			money_pre.html('N$ ' + temp.formatMoney(2, '.', ','));

		});


					/* ---------- Text Editor ---------- */
		$('.redactor_content').redactor({ 	
					fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
					imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video','file', 'table', 'link','|',
					 'alignment', '|', 'horizontalrule'],
					linebreaks: true,
					focus:true,
					plugins: ['fullscreen', 'fontcolor', 'fontsize','fontfamily']
		});
		
		$('#property_date').datepicker();
	
	});


	$("#property_location").change(function() {

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/'); ?>property/get_suburb_select/'+$(this).val(),
			success: function (data) {

				$("#property_suburb").html(data);

			}
		});

	});


	$('#butt').click(function(e) {


		e.preventDefault();
		//Validate
		if($('#title').val().length == 0){

			$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a product title"});
			$('#title').popover('show');
			$('#title').focus();

			//}else if($('#redactor_content').val() == 0){
//
//				$('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
//				$('#redactor_content_msg').popover('show');
//				$('#redactor_content_msg').focus();


		}else{

			submit_form();

		}
	});

	function submit_form(){

			var sub_type = $('#sub-type option:selected').text();
			var sub_sub_type = $('#sub-sub-type option:selected').text();
			var sub_sub_sub_type = $('#sub-sub-sub-type option:selected').text()

			$('#status-type').val(sub_type);
			$('#property-type').val(sub_sub_type);
			$('#building-type').val(sub_sub_sub_type);



			var frm = $('#property-add');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'property/add_property_do';?>' ,
				success: function (data) {

					$('#result_msg').html(data);
					$('#butt').html('Add Property');

				}
			});
	
	}


	$("#sub-type").change(function() {

		$.ajax({
			type: 'get',
			dataType: 'json',
			url: '<?php echo site_url('/'); ?>property/get_sub_select/'+$(this).val(),
			success: function (data) {

				$("#sub-sub-type").html(data.sub_sub_data);
				$("#sub-sub-sub-type").html(data.sub_sub_sub_data);

			}
		});

	});

	$("#sub-sub-type").change(function() {

		var sub_type = $('#sub-type').val();

		$.ajax({
			type: 'get',
			dataType: 'json',
			url: '<?php echo site_url('/'); ?>property/get_sub_sub_select/'+sub_type+'/'+$(this).val(),
			success: function (data) {

				$("#sub-sub-sub-type").html(data.sub_sub_sub_data);

			}
		});

	});

	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : event.keyCode
		if (charCode > 31 && (charCode < 48 || charCode > 57))
			return false;
		return true;
	}



	Number.prototype.formatMoney = function (c, d, t) {
		var n = this,
			c = isNaN(c = Math.abs(c)) ? 2 : c,
			d = d == undefined ? "." : d,
			t = t == undefined ? "," : t,
			s = n < 0 ? "-" : "",
			i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
			j = (j = i.length) > 3 ? j % 3 : 0;
		return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
	};

	</script>
</body>
</html>