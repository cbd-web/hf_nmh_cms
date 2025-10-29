<!DOCTYPE html>
<html lang="en">
<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title><?php if(isset($title)){echo $title;}else{ echo '';}?></title>
	<meta name="description" content="<?php if(isset($metaD)){echo $metaD;}else{ echo '';}?>">
	<meta name="author" content="Roland Ihms">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="<?php echo base_url('/');?>admin_src/css/bootstrap.min.css" rel="stylesheet">
	<link id="base-style" href="<?php echo base_url('/');?>admin_src/css/style.css" rel="stylesheet">
	<link href='//fonts.googleapis.com/css?family=Oxygen:400,700' rel='stylesheet' type='text/css'>
	
	<!-- end: CSS -->

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  <script src="https://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
    <link rel="shortcut icon" href="../assets/ico/favicon.png">
     
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/js/bootstrap.min.js"></script>                              
  	<style type="text/css">
	
		h1,h2,h3,h4{color:<?php echo $color_primary;?>; font-family:Oxygen; font-size:2em}
		p,div,body{color:<?php echo $color_primary;?>}
		.popover-title, .popover-content{color:#333}
	</style>
  
  </head>
  <?php $img = $this->survey_model->get_featured_image_front($survey_id, 'survey', $bus_id);?>
   <?php if($img){ 
                
              $img_feat = $img;
                   
     }else{ 
     
              $img_feat = 'images/background.png';
     
    }?>
	<body style="background: url(<?php echo $img_feat;?>); background-size:cover; padding-top:100px;">
  		<a href="" style="float:right; position:absolute; right:250px; top:40px" class="btn"><i class="icon-retweet"></i></a>
		<div class="container" id="main">
        	<form class="form" role="form" name="myform" id="survey_frm" method="post" enctype="multipart/form-data">
                <input type="hidden" value="<?php echo $survey_id;?>" name="survey_id">
                <input type="hidden" value="<?php echo $bus_id;?>" name="bus_id">
                
                 <div id="step0" class="text-center">
                    <div class="row-fluid">
                        <div class="span12">
                        	<h2><?php echo $title;?></h2>
                            <?php if(isset($description)){echo $description;}?>
                        </div>
                    
                    </div>
                </div>
                
                <div id="step1" class="text-center <?php if(!$leadcapture){ echo 'hide';}?>">
                    <div class="row-fluid">
                        <div class="span12">
                        	<h2>Please complete the survey</h2>
                            <input type="text" class="span10 hide" name="fullname" id="fullname" placeholder="Full Name" tabindex="1" value="<?php if(isset($fullname)){echo $fullname;}else{ echo '';}?>">
                         
                        </div>
                    
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <input type="text" class="span10 hide" name="age" id="age" placeholder="Age eg:21" tabindex="2"  value="<?php if(isset($age)){echo $age;}else{ echo '';}?>">
                        </div>
                    
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <input type="text" class="span10 hide" name="email" id="email" placeholder="Email" tabindex="3"  value="<?php if(isset($email)){echo $email;}else{ echo '';}?>">
                            
                        </div>
                    
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            <input type="text" class="span10 hide" name="cellphone" id="cellphone" placeholder="Cell phone" tabindex="4"  value="<?php if(isset($cell)){echo $cell;}else{ echo '';}?>">
                        </div>
                    
                    </div> 
                    <div class="row-fluid">
                        <div class="span12">
                            <a title="Next" onClick="next_step(2)" class="btn">Proceed</a>
                        </div>
                    
                    </div>
                </div>

                 <?php $this->survey_model->get_survey_question($survey_id, $step = '', $leadcapture);?>

			</form>
		
		</div>
		
        
        <div class="container hide" id="msg">
        
        	<div class="row-fluid text-center">
            	<div class="span10">
                		
                        <h1 class="text-center" style="font-size:3em" id="name_msg">Thank You, </h1>
                		<p>Have a great day further.</p>
                </div>
            
            </div>
        
        
        </div>
        		
		<!-- js -->
		<script src="<?php echo base_url('/');?>old_mutual/js/jquery.easing.min.js"></script>

		<script>
			$(document).ready(function(){
				

			});
			  
			function show_body() {
				$(function(){

					$("input").delay(1000).fadeIn(1000,'easeOutCubic');
					$(".keyboard").delay(1000).animate({"left":"185px"},1000,'easeOutCubic');

					$('#fullname').focus(updateFocus);
					$('#age').focus(updateFocus);
					$('#email').focus(updateFocus);
					$('#cellphone').focus(updateFocus);



					/*// submit user form
					$(".continue").click(function() {
						// validate form
						var v = validateForm();
						if(!v) return false;

						$.ajax({
							type: "POST",
							url: "php/post_user_form.php",
							data: $(".form").serialize(),
							success: function(data) {
								// console.log(data);
								$(".submit_dream").show();
								$(".continue").fadeOut(1000);
								$(".fields").animate({'top':'-500px'},500,'easeInCubic');
								$(".textbox").delay(500).animate({'top':'40px'},500,'easeOutCubic');

								fieldWithCurrentFocus = document.getElementById('wish');
							}
						});
					});
*/



				});
			};
			window.onload = show_body;




			function next_step(step) {

					
					var current = $('#step'+(step - 1)), next = $('#step'+step), prev = $('#step'+(step - 2));
					if(step == 2){
						
						if($('#fullname').val().length == 0){
					
							$('#fullname').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a your full name"});
							$('#fullname').popover('show');
							$('#fullname').focus();
							
						}else if($('#email').val().length == 0){
							$('#email').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Email Required", content:"Please supply us with a your valid email address"});
							$('#email').popover('show');
							$('#email').focus();
						}else{
							
							current.hide();
							next.fadeIn();
							
						}
						
					}else{
						
						current.hide();
						next.fadeIn();
						
					}
					//current.animate({"left":"-2885px"},100,'easeOutCubic').addClass('hide');


			}


			function final_submit() {
				
					var frm = $('#survey_frm');
					$.ajax({
							type: "POST",
							url: "<?php echo site_url('/');?>survey/submit/",
							data: frm.serialize(),
							success: function(data) {
								// console.log(data);
								$("#main").fadeOut(500);
								$("#msg").slideDown();
								$("#name_msg").html('Thank You, '+$('#fullname').val());

								//fieldWithCurrentFocus = document.getElementById('wish');
							}
						});
				
			}
			function updateFocus() {
				var id = $(this).attr('id');
				fieldWithCurrentFocus = document.getElementById(id);
			}
			

			
			
		</script>

	</body>
</html>