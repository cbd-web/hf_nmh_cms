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
						Update Special: <?php echo $tour;?>
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span> Update Special For: <?php echo $tour; ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="special-update" name="special-update" method="post" action="<?php echo site_url('/');?>itinerary/update_special_do" class="form-horizontal">
                             <fieldset>
								<input type="hidden" name="id" value="<?php if(isset($special_id)){echo $special_id;}?>">
								<input type="hidden" name="autosave" id="autosave"  value="true">
								<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
										  
								  <div class="control-group">
									<label class="control-label" for="title">Status</label>
									<div class="controls">
										<div class="btn-group" data-toggle="buttons-radio">
										  <button type="button" class="btn btn-primary<?php if($status == 'draft'){ echo ' active';}?>">draft</button>
										  <button type="button" class="btn btn-primary<?php if($status == 'live'){ echo ' active';}?>">live</button>
										</div>
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Choose a Tour</label>
									<div class="controls">
										<select name="tour">
											<?php echo $this->itinerary_model->get_tours_select($tour_id); ?>
										</select>
									</div>
								  </div>
								  
								  	
								 <div class="control-group">
									<label class="control-label" for="sale_price">Featured</label>
									<div class="controls">
									<input name="featured" type="checkbox" value="Y" <?php if($featured == 'Y') { echo "checked"; } ?>>
									</div>
								  </div>
										  
								 <div class="control-group">
										<label class="control-label" for="pub_date">Valid From</label>
										<div class="controls">
											 <div class="input-append date" id="date_start" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
											  <input type="text"  name="valid_from" id="valid_from" value="<?php if (isset($valid_from)){echo date('Y-m-d',strtotime($valid_from));}else{ echo date('Y-m-d');}?>" readonly>
											  <span class="add-on"><i class="icon-calendar"></i></span>
											</div> 
											<span class="help-block" style="font-size:11px">Select the special start date</span>
										</div>			
								 </div>
								 
								  <div class="control-group">
										<label class="control-label" for="pub_date">Valid To</label>
										<div class="controls">
											 <div class="input-append date" id="date_end" data-date="<?php echo date('Y-m-d'); ?>" data-date-format="yyyy-mm-dd" data-date-viewmode="years">
											  <input type="text"  name="valid_to" id="valid_to" value="<?php if (isset($valid_to)){echo date('Y-m-d',strtotime($valid_to));}else{ echo date('Y-m-d');}?>" readonly>
											  <span class="add-on"><i class="icon-calendar"></i></span>
											</div> 
											<span class="help-block" style="font-size:11px">Select the special end date</span>
										</div> 										  
								  </div>																																													  
					
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											
											<textarea  class="redactor_content loading_img" id="redactor_content" name="content" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
										</div>
								   </div>

								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Special</button>
                                           
                               </fieldset> 
                             </form>
		             	</p>                  
                  </div>
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


    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>
    

	<script type="text/javascript">
	
	$(document).ready(function(){

		$('#date_start').datepicker();
		$('#date_end').datepicker();		
		
		$('div.btn-group button').live('click', function(){
			
			$('#status').attr('value', $(this).html());
		});		
	
		$('input').change(function() {
	
		  $('#autosave').val('false');
		});
		$('.redactor_box').live('click', function() {
	
		  $('#autosave').val('false');
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
		
		
	
	});

	
	$('#butt').click(function(e) {

		e.preventDefault();
		//Validate

		submit_form();
			
	});
		
	
	function submit_form(){
			
		var frm = $('#special-update');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'itinerary/update_special_do';?>' ,
			success: function (data) {
				 $('#autosave').val('true');
				 $('#result_msg').html(data);
				 $('#butt').html('Update Special');
				
			}
		});
	}
			
	window.onbeforeunload = function() {		 
		 if($('#autosave').val() == 'false'){
			return 'The special has not been saved.';
		 }
	};
	

	
	</script>
</body>
</html>