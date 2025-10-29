<?php $this->load->view('admin/inc/header');?>
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
						<a href="<?php echo site_url('/');?>itinerary/specials/specials">Specials</a><span class="divider">/</span>
					</li>
                    <li>
						Add New Tour Special
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Tour Special</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="add-special" name="add-special" method="post" action="<?php echo site_url('/');?>itinerary/add_special_do" class="form-horizontal">
                             <fieldset>

								  <div class="control-group">
									<label class="control-label" for="title">Choose a Tour</label>
									<div class="controls">
										<select name="tour">
											<?php echo $this->itinerary_model->get_tours_select(); ?>
										</select>
									</div>
								  </div>	
									
									 <div class="control-group">
										<label class="control-label" for="pub_date">Valid From</label>
										<div class="controls">
											 <div class="input-append date" id="date_start" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
											  <input type="text"  name="valid_from" id="valid_from" value="<?php echo date('Y-m-d'); ?>" readonly>
											  <span class="add-on"><i class="icon-calendar"></i></span>
											</div> 
											<span class="help-block" style="font-size:11px">Select the special start date</span>
										</div> 
									 </div>	
									 
									 <div class="control-group">
										<label class="control-label" for="pub_date">Valid To</label>
										<div class="controls">
											 <div class="input-append date" id="date_end" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
											  <input type="text"  name="valid_to" id="valid_to" value="<?php echo date('Y-m-d'); ?>" readonly>
											  <span class="add-on"><i class="icon-calendar"></i></span>
											</div> 
											<span class="help-block" style="font-size:11px">Select the special end date</span>
										</div> 
									 </div>																  
					
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											<textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
										</div>
								   </div>
								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Special</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
				</div>
               

			</div>
			
			<hr>
			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
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
		
		$('#date_start').datepicker();
		$('#date_end').datepicker();		
		
		
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
		
	});
	
	
	$('#butt').click(function(e) {
	
		
		e.preventDefault();
		submit_form();

	});
	
	
	function submit_form(){
			
		var frm = $('#add-special');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'itinerary/add_special_do'; ?>' ,
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#butt').html('Add Special');
				
			}
		});	
	
	}
	
	
	</script>
</body>
</html>