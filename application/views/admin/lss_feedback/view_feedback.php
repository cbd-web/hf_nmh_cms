<?php $this->load->view('admin/inc/header');

$total_array = array();

//CREW//
$crew_array = array();

$crew_1 = $this->lss_feedback_model->get_rating($crew_1);
if($crew_1 != '0') { array_push($crew_array, $crew_1); } else { $crew_1 = 'Not Rated'; }

$crew_2 = $this->lss_feedback_model->get_rating($crew_2);
if($crew_2 != '0') { array_push($crew_array, $crew_2); } else { $crew_2 = 'Not Rated'; }

$crew_3 = $this->lss_feedback_model->get_rating($crew_3);
if($crew_3 != '0') { array_push($crew_array, $crew_3); } else { $crew_3 = 'Not Rated'; }

$crew_4 = $this->lss_feedback_model->get_rating($crew_4);
if($crew_4 != '0') { array_push($crew_array, $crew_4); } else { $crew_4 = 'Not Rated'; }

$crew_5 = $this->lss_feedback_model->get_rating($crew_5);
if($crew_5 != '0') { array_push($crew_array, $crew_5); } else { $crew_5 = 'Not Rated'; }

$crew_6 = $this->lss_feedback_model->get_rating($crew_6);
if($crew_6 != '0') { array_push($crew_array, $crew_6); } else { $crew_6 = 'Not Rated'; }

$crew_7 = $this->lss_feedback_model->get_rating($crew_7);
if($crew_7 != '0') { array_push($crew_array, $crew_7); } else { $crew_7 = 'Not Rated'; }

$crew_8 = $this->lss_feedback_model->get_rating($crew_8);
if($crew_8 != '0') { array_push($crew_array, $crew_8); } else { $crew_8 = 'Not Rated'; }


if (!empty($crew_array)) { 

	$overall_crew_result = round($this->lss_feedback_model->get_overall_rating($crew_array), 2); 
	array_push($total_array, $overall_crew_result);

} else { 

	$overall_crew_result = 'Not Rated';

}


//PROCUREMENT//
$pro_array = array();

$pro_1 = $this->lss_feedback_model->get_rating($procure_1);
if($pro_1 != '0') { array_push($pro_array, $pro_1); } else { $pro_1 = 'Not Rated'; }

$pro_2 = $this->lss_feedback_model->get_rating($procure_2);
if($pro_2 != '0') { array_push($pro_array, $pro_2); } else { $pro_2 = 'Not Rated'; }

$pro_3 = $this->lss_feedback_model->get_rating($procure_3);
if($pro_3 != '0') { array_push($pro_array, $pro_3); } else { $pro_3 = 'Not Rated'; }

$pro_4 = $this->lss_feedback_model->get_rating($procure_4);
if($pro_4 != '0') { array_push($pro_array, $pro_4); } else { $pro_4 = 'Not Rated'; }

$pro_5 = $this->lss_feedback_model->get_rating($procure_5);
if($pro_5 != '0') { array_push($pro_array, $pro_5); } else { $pro_5 = 'Not Rated'; }

$pro_6 = $this->lss_feedback_model->get_rating($procure_6);
if($pro_6 != '0') { array_push($pro_array, $pro_6); } else { $pro_6 = 'Not Rated'; }



if (!empty($pro_array)) { 

	$overall_pro_result = round($this->lss_feedback_model->get_overall_rating($pro_array), 2); 
	array_push($total_array, $overall_pro_result);

} else { 

	$overall_pro_result = 'Not Rated';

}




//VESSEL AGENCY//
$va_array = array();

$va_1 = $this->lss_feedback_model->get_rating($va_1);
if($va_1 != '0') { array_push($va_array, $va_1); } else { $va_1 = 'Not Rated'; }

$va_2 = $this->lss_feedback_model->get_rating($va_2);
if($va_2 != '0') { array_push($va_array, $va_2); } else { $va_2 = 'Not Rated'; }

$va_3 = $this->lss_feedback_model->get_rating($va_3);
if($va_3 != '0') { array_push($va_array, $va_3); } else { $va_3 = 'Not Rated'; }

$va_4 = $this->lss_feedback_model->get_rating($va_4);
if($va_4 != '0') { array_push($va_array, $va_4); } else { $va_4 = 'Not Rated'; }

$va_5 = $this->lss_feedback_model->get_rating($va_5);
if($va_5 != '0') { array_push($va_array, $va_5); } else { $va_5 = 'Not Rated'; }

$va_6 = $this->lss_feedback_model->get_rating($va_6);
if($va_6 != '0') { array_push($va_array, $va_6); } else { $va_6 = 'Not Rated'; }

$va_7 = $this->lss_feedback_model->get_rating($va_7);
if($va_7 != '0') { array_push($va_array, $va_7); } else { $va_7 = 'Not Rated'; }


if (!empty($va_array)) { 

	$overall_va_result = round($this->lss_feedback_model->get_overall_rating($va_array), 2); 
	array_push($total_array, $overall_va_result);

} else { 

	$overall_va_result = 'Not Rated';

}



//CLEARANCE//
$clear_array = array();

$clear_1 = $this->lss_feedback_model->get_rating($clear_1);
if($clear_1 != '0') { array_push($clear_array, $clear_1); } else { $clear_1 = 'Not Rated'; }

$clear_2 = $this->lss_feedback_model->get_rating($clear_2);
if($clear_2 != '0') { array_push($clear_array, $clear_2); } else { $clear_2 = 'Not Rated'; }

$clear_3 = $this->lss_feedback_model->get_rating($clear_3);
if($clear_3 != '0') { array_push($clear_array, $clear_3); } else { $clear_3 = 'Not Rated'; }

$clear_4 = $this->lss_feedback_model->get_rating($clear_4);
if($clear_4 != '0') { array_push($clear_array, $clear_4); } else { $clear_4 = 'Not Rated'; }

$clear_5 = $this->lss_feedback_model->get_rating($clear_5);
if($clear_5 != '0') { array_push($clear_array, $clear_5); } else { $clear_5 = 'Not Rated'; }

$clear_6 = $this->lss_feedback_model->get_rating($clear_6);
if($clear_6 != '0') { array_push($clear_array, $clear_6); } else { $clear_6 = 'Not Rated'; }

$clear_7 = $this->lss_feedback_model->get_rating($clear_7);
if($clear_7 != '0') { array_push($clear_array, $clear_7); } else { $clear_7 = 'Not Rated'; }

$clear_8 = $this->lss_feedback_model->get_rating($clear_8);
if($clear_8 != '0') { array_push($clear_array, $clear_8); } else { $clear_8 = 'Not Rated'; }



if (!empty($clear_array)) { 

	$overall_clear_result = round($this->lss_feedback_model->get_overall_rating($clear_array), 2); 
	array_push($total_array, $overall_clear_result);

} else { 

	$overall_clear_result = 'Not Rated';

}


//WAREHOUSE//
$ware_array = array();

$ware_1 = $this->lss_feedback_model->get_rating($warehouse_1);
if($ware_1 != '0') { array_push($ware_array, $ware_1); } else { $ware_1 = 'Not Rated'; }

$ware_2 = $this->lss_feedback_model->get_rating($warehouse_2);
if($ware_2 != '0') { array_push($ware_array, $ware_2); } else { $ware_2 = 'Not Rated'; }

$ware_3 = $this->lss_feedback_model->get_rating($warehouse_3);
if($ware_3 != '0') { array_push($ware_array, $ware_3); } else { $ware_3 = 'Not Rated'; }



if (!empty($ware_array)) { 

	$overall_ware_result = round($this->lss_feedback_model->get_overall_rating($ware_array), 2); 
	array_push($total_array, $overall_ware_result);

} else { 

	$overall_ware_result = 'Not Rated';

}


//FINANCE//
$fin_array = array();

$fin_1 = $this->lss_feedback_model->get_rating($finance_1);
if($fin_1 != '0') { array_push($fin_array, $fin_1); } else { $fin_1 = 'Not Rated'; }

$fin_2 = $this->lss_feedback_model->get_rating($finance_2);
if($fin_2 != '0') { array_push($fin_array, $fin_2); } else { $fin_2 = 'Not Rated'; }

$fin_3 = $this->lss_feedback_model->get_rating($finance_3);
if($fin_3 != '0') { array_push($fin_array, $fin_3); } else { $fin_3 = 'Not Rated'; }


if (!empty($fin_array)) { 

	$overall_fin_result = round($this->lss_feedback_model->get_overall_rating($fin_array), 2); 
	array_push($total_array, $overall_fin_result);

} else { 

	$overall_fin_result = 'Not Rated';

}


if (!empty($total_array)) {

	$overall_total_result = round($this->lss_feedback_model->get_overall_rating($total_array), 2);

	//array_push($total_array, $total_array);

} else { 

	$overall_total_result = 'No Departments Rated';

}


?>	
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
						<a href="<?php echo site_url('/');?>lss_feedback/feedback">Feedback</a> <span class="divider">/</span>
					</li>
					<li>
						Feedback Results for <?php echo $name; ?>
					</li>					
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>General Details</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped">
							<tr><td style="width:10%"><strong>Company:</strong></td><td><?php echo $company; ?></td></tr>
							<tr><td><strong>Name:</strong></td><td><?php echo $name; ?></td></tr>
							<tr><td><strong>Phone:</strong></td><td><?php echo $phone; ?></td></tr>
							<tr><td><strong>Email:</strong></td><td><?php echo $email; ?></td></tr>
						</table>
						<h4>In which areas do you think our business needs improvement?</h4>
						<pre><?php echo $improve; ?></pre>
						
						<h4>What other services you want LSS to offer?</h4>
						<pre><?php echo $other_services; ?></pre>
						
						<h4>Comments</h4>
						<pre><?php echo $comments; ?></pre>		
						
						<h4>Would you recommend LSS Service to your friends, colleagues, and business partners?</h4>
						<pre><?php echo $recommend; ?></pre>
						
						<h4>Total Overall Rating:</h4>	
						<h1><?php echo $overall_total_result; ?>%</h1>															
						            
                  </div>
				  
				  <div class="box-content">
				  		<h2>Crewing</h2>
						How satisfied are you with LSS accuracy and timeliness of below Crewing aspects.
						<table class="table table-striped">
							<tr><td style="width:80%;"><strong>Was there a good response to your correspondence and feedback?</strong></td><td style="text-align:right"><?php echo $crew_1; ?></td></tr>
							<tr><td><strong>Were your arrangements confirmed before your arrival?</strong></td><td style="text-align:right"><?php echo $crew_2; ?></td></tr>
							<tr><td><strong>Was your meet and assist service on time?</strong></td><td style="text-align:right"><?php echo $crew_3; ?></td></tr>
							<tr><td><strong>Were our drivers helpful and friendly?</strong></td><td style="text-align:right"><?php echo $crew_4; ?></td></tr>
							<tr><td><strong>Was the assistance given helpful?</strong></td><td style="text-align:right"><?php echo $crew_5; ?></td></tr>
							<tr><td><strong>Was your driver always reachable?</strong></td><td style="text-align:right"><?php echo $crew_6; ?></td></tr>
							<tr><td><strong>Did the crewing department demonstrate good problem solving skills?</strong></td><td style="text-align:right"><?php echo $crew_7; ?></td></tr>
							<tr><td><strong>Was our crewing team / driver easily identifiable upon your arrival?</strong></td><td style="text-align:right"><?php echo $crew_8; ?></td></tr>
							<tr><td><strong>Overall Rating for Crewing:</strong></td><td style="text-align:right"><?php echo $overall_crew_result; ?></td></tr>
						</table>				  
				  
				  </div>
				  
				  <div class="box-content">
				  		<h2>Procurement</h2>
						How satisfied are you with LSS accuracy and timeliness of below Procurement aspects.
						<table class="table table-striped">
							<tr><td style="width:80%;"><strong>Did you experience a timely response to your quotation request?</strong></td><td style="text-align:right"><?php echo $pro_1; ?></td></tr>
							<tr><td><strong>Were you properly introduced to your procurement agent?</strong></td><td style="text-align:right"><?php echo $pro_2; ?></td></tr>
							<tr><td><strong>Were your deliveries on time?</strong></td><td style="text-align:right"><?php echo $pro_3; ?></td></tr>
							<tr><td><strong>Were the items delivered to your satisfaction and to a good standard / quality?</strong></td><td style="text-align:right"><?php echo $pro_4; ?></td></tr>
							<tr><td><strong>How would you rate your agent’s product knowledge?</strong></td><td style="text-align:right"><?php echo $pro_5; ?></td></tr>
							<tr><td><strong>Did your agent demonstrate good problem solving skills?</strong></td><td style="text-align:right"><?php echo $pro_6; ?></td></tr>
							<tr><td><strong>Overall Rating for Procurement:</strong></td><td style="text-align:right"><?php echo $overall_pro_result; ?></td></tr>
						</table>				  
				  
				  </div>
				  

				  <div class="box-content">
				  		<h2>Vesel Agency</h2>
						How satisfied are you with LSS accuracy and timeliness of below Clearing & Forwarding aspects.
						<table class="table table-striped">
							<tr><td style="width:80%;"><strong>Are you satisfied with your Clearing and Forwarding agent’s response time to your queries?</strong></td><td style="text-align:right"><?php echo $clear_1; ?></td></tr>
							<tr><td><strong>Did your agent have good telephonic etiquette and were they always reachable?</strong></td><td style="text-align:right"><?php echo $clear_2; ?></td></tr>
							<tr><td><strong>Did you receive your rates / quotation in a timely manner?</strong></td><td style="text-align:right"><?php echo $clear_3; ?></td></tr>
							<tr><td><strong>Did you receive updates from your Clearing and Forwarding agent on a daily basis?</strong></td><td style="text-align:right"><?php echo $clear_4; ?></td></tr>
							<tr><td><strong>Did your Clearing and Forwarding agent handle your consignment professionally?</strong></td><td style="text-align:right"><?php echo $clear_5; ?></td></tr>
							<tr><td><strong>Was your consignment handled with care and safety?</strong></td><td style="text-align:right"><?php echo $clear_6; ?></td></tr>
							<tr><td><strong>Was your consignment delivered efficiently and on time?</strong></td><td style="text-align:right"><?php echo $clear_7; ?></td></tr>
							<tr><td><strong>Did your Clearing and Forwarding agent show good problem solving skills?</strong></td><td style="text-align:right"><?php echo $clear_8; ?></td></tr>
							<tr><td><strong>Overall Rating for Clearing & Forwarding:</strong></td><td style="text-align:right"><?php echo $overall_clear_result; ?></td></tr>
						</table>
				  </div>			  			  
				  

				  <div class="box-content">
				  		<h2>Warehousing</h2>
						How satisfied are you with LSS accuracy and timeliness of below Warehousing aspects.
						<table class="table table-striped">
							<tr><td style="width:80%;"><strong>Did you experience a timely response to your quotation request?</strong></td><td style="text-align:right"><?php echo $ware_1; ?></td></tr>
							<tr><td><strong>Was the delivery of your consignment to and from our warehousing facility efficient and on time?</strong></td><td style="text-align:right"><?php echo $ware_2; ?></td></tr>
							<tr><td><strong>Were you satisfied with your rates / quotation?</strong></td><td style="text-align:right"><?php echo $ware_3; ?></td></tr>
							<tr><td><strong>Overall Rating for Warehousing:</strong></td><td style="text-align:right"><?php echo $overall_ware_result; ?></td></tr>
						</table>
				  </div>
				  
				  <div class="box-content">
				  		<h2>Financing</h2>
						How satisfied are you with LSS accuracy and timeliness of below Financing aspects.
						<table class="table table-striped">
							<tr><td style="width:80%;"><strong>Do you receive invoices as per your requirements/procedures?</strong></td><td style="text-align:right"><?php echo $fin_1; ?></td></tr>
							<tr><td><strong>Do you receive the statement on time, i.e. after month-end?</strong></td><td style="text-align:right"><?php echo $fin_2; ?></td></tr>
							<tr><td><strong>Are your queries regarding your account attended to within reasonable time frame?</strong></td><td style="text-align:right"><?php echo $fin_3; ?></td></tr>
							<tr><td><strong>Overall Rating for Financing:</strong></td><td style="text-align:right"><?php echo $overall_fin_result; ?></td></tr>
						</table>
				  </div>				  
				  
				  
				</div>
				
        
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
		
        
        <div class="modal hide fade" id="modal-feedback-delete">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete Entry</h3>
          </div>
          <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All details will be removed. This proces is not reversible.
            </div>
        
          </div>
          <div class="modal-footer">
            <a onClick="$('#modal-feedback-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Entry</a>
          </div>
        </div>
        
        <div class="clearfix"></div>
		
			<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
        
</body>
</html>