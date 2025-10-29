<?php $this->load->view('admin/inc/header');?>
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
						<a href="<?php echo site_url('/');?>itinerary/accommodations/">Accommodations</a><span class="divider">/</span>
					</li>
                    <li>
						Add New Accommodation
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Add New Accommodation</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="add-accommodation" name="add-accommodation" method="post" action="<?php echo site_url('/');?>itinerary/add_accommodation_do" class="form-horizontal">
                             <fieldset>

								  <div class="control-group">
									<label class="control-label" for="title">Title</label>
									<div class="controls">
											<input type="text" class="span6" id="title" name="title" placeholder="Accommodation title" value="">
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Type</label>
									<div class="controls">
										<select name="type">
											<option value="0">Choose a Accommodation type</option>
											<?php echo $this->itinerary_model->get_acc_type_select(); ?>
										</select>
									</div>
								  </div>								  

								  <div class="control-group">
									<label class="control-label" for="title">Website</label>
									<div class="controls">
											<input type="text" class="span6" id="website" name="website" placeholder="Website URL" value="">
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Email</label>
									<div class="controls">
											<input type="text" class="span6" id="email" name="email" placeholder="Email" value="">
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Phone</label>
									<div class="controls">
											<input type="text" class="span6" id="phone" name="phone" placeholder="Phone Number" value="">
									</div>
								  </div>								  

								  <div class="control-group">
									<label class="control-label" for="title">Fax</label>
									<div class="controls">
											<input type="text" class="span6" id="fax" name="fax" placeholder="Fax Number" value="">
									</div>
								  </div>
								  
								  <div class="control-group">
									<label class="control-label" for="title">Destination</label>
									<div class="controls">
										<input class="span6" id="appendedInputButtons1" type="text" name="destination" placeholder="Search Destination...">
									</div>
								  </div>																	  
					
								  <div class="control-group" id="redactor_content_msg">
										<label class="control-label" for="redactor_content">Description:</label>
										<div class="controls">
											
											<textarea id="redactor_content" class="redactor_content" name="content" style="display:block"></textarea>
										</div>
								   </div>
								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Accommodation</button>
                                           
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
    
    <script type="text/javascript" src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>	
	<script type="text/javascript">
	
	$(document).ready(function(){
		
		<?php echo $this->itinerary_model->load_destination_typehead();?>

		$('#appendedInputButtons1').typeahead({source: subjects}) 	
				
		/* ---------- Text Editor ---------- */
		$('.redactor_content').redactor({ 	
					fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
					imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', 'underline',  '|', 
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
		if($('#title').val().length == 0){
				
				$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a title"});
				$('#title').popover('show');
				$('#title').focus();	
			
		}else{
	
			submit_form();
			
		}
	});
	
	
	function submit_form(){
			
			var frm = $('#add-accommodation');
			//frm.submit();
			$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'itinerary/add_accommodation_do'; ?>' ,
				success: function (data) {
					
					 $('#result_msg').html(data);
					 $('#butt').html('Add Accommodation');
					
				}
			});	
	
	}
	
	
	</script>
</body>
</html>