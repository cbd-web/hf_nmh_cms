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
						<a href="<?php echo site_url('/');?>itinerary/tours/">Tours</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>itinerary/update_tour/<?php echo $tour_id ?>">Update Tour</a><span class="divider">/</span>
					</li>
					<li>
						<a href="<?php echo site_url('/');?>itinerary/update_itinerary/<?php echo $itinerary_id ?>">Update Itinerary</a><span class="divider">/</span>
					</li>										
                    <li>
						Update Itinerary Price
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span8">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Update Itinerary Price:</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                  	  	<p>
							<form id="update-price" name="update-price" method="post" action="<?php echo site_url('/');?>itinerary/update_price_do" class="form-horizontal">
							<input name="tour_id" type="hidden" value="<?php echo $tour_id; ?>">
							<input name="itinerary_id" type="hidden" value="<?php echo $itinerary_id; ?>">
							<input name="id" type="hidden" value="<?php echo $price_id; ?>">
                             <fieldset>

								  <div class="control-group">
									<label class="control-label" for="title">Title</label>
									<div class="controls">
											<input type="text" class="span6" id="title" name="title" placeholder="Tour title" value="<?php echo $title; ?>">
									</div>
								  </div>
										

								  <div class="control-group">
									<label class="control-label" for="title">In Season (N$)</label>
									<div class="controls">
											<input type="text" class="span6" id="h_price" name="h_price" placeholder="Insert In Season Price" value="<?php echo $h_price; ?>">
									</div>
								  </div>


								  <div class="control-group">
									<label class="control-label" for="title">Off Season (N$)</label>
									<div class="controls">
											<input type="text" class="span6" id="l_price" name="l_price" placeholder="Insert Off Season Price" value="<?php echo $l_price; ?>">
									</div>
								  </div>
								  
								  <div id="result_msg"></div>
								  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Price</button>
                                           
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
    
	<script type="text/javascript">
	
	$(document).ready(function(){
		
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
			
		var frm = $('#update-price');
		//frm.submit();
		$('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'itinerary/update_price_do'; ?>' ,
			success: function (data) {
				
				 $('#result_msg').html(data);
				 $('#butt').html('Update Price');
				
			}
		});	
	}
	
	
	</script>
</body>
</html>