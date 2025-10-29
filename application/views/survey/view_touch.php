<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="keywords" content="Webcam, Intouch">
		<meta name="description" content="Webcam, Intouch">
		<meta name="author" content="Intouch Interactive Marketing">
		<base href="http://localhost/events.my.na/old_mutual/students/">
		<title>Students Questionaire</title>
		<link rel="shortcut icon" href="img/favicon.ico">

		<link rel="stylesheet" href="css/style.css">

		<script src="js/jquery-2.1.0.min.js"></script>
		<script type="text/javascript">
			$(function() {
				fieldWithCurrentFocus = document.getElementById('fullname');
			});
		</script>

		<script language="javascript">
			function cleareverything(){
				if (document.survey_frm.fullname.value == "ENTER YOUR FULL NAME")
				{document.survey_frm.fullname.value = ""}
				
				
				if (document.survey_frm.email.value == "ENTER YOUR EMAIL")
				{document.survey_frm.email.value = ""}
				
				if (document.survey_frm.cellphone.value == "ENTER CELLPHONE")
				{document.survey_frm.cellphone.value = ""}
			}
		</script>

		<script type="text/javascript">
			function processInput(val)
			{
				fieldWithCurrentFocus.value = fieldWithCurrentFocus.value + val;
				return false;
			}

			function processDelete(val)
			{
				var str = fieldWithCurrentFocus.value;
				fieldWithCurrentFocus.value = str.substring(0, str.length-1);
				return false;
			}
		</script>
	</head>

	<body>
		<div class="screen">
            <a href="" style="float:right; position:absolute; right:250px; top:40px"><img src="images/refresh.png" /></a>
            <img class="vignette" src="images/vignette.jpg">
			<a href="index.php">
				<img class="logo" src="images/logo.png">
			</a>
			<img class="keyboard_hive" src="images/keyboard_hive.png">
			<img class="chopper" src="images/chopper.png" style="top:120px;left:260px;">

			<form class="form" role="form" name="myform" id="survey_frm" method="post" enctype="multipart/form-data">
            	
                
            	<input type="hidden" value="<?php echo $survey_id;?>" name="survey_id">
            	<input type="hidden" value="<?php echo $bus_id;?>" name="bus_id">
				<div id="step1" style="position:relative">
                    <div class="fields">
                        <input type="text" class="input_top" name="fullname" id="fullname" placeholder="Full Name" tabindex="1">
                        <input type="text" class="input_midd" name="age" id="age" placeholder="Age eg:21" tabindex="2">
                        <input type="text" class="input_midd" name="email" id="email" placeholder="Email" tabindex="3">
                        <input type="text" class="input_bottom" name="cellphone" id="cellphone" placeholder="Cell phone" tabindex="4">
                        <a title="Next" onClick="next_step(2)" class="continue" style="top:270px; right:-150px;"></a>
                    </div>
                 </div>
                 <?php $this->survey_model->get_survey_question($survey_id);?>

    
                    <div class="keyboard">
                        <a title="Dream Next" id="submit_answer" class="continue" style="display:none"></a>
                        <input type="button" title="Submit Next" class="submit submit_dream" value="">
    					<div class="row" style="width:auto; top:0; left:80px">
                            <img onclick="cleareverything(); processInput('0')" src="images/key_0.png">
                            <img onclick="cleareverything(); processInput('1')" src="images/key_1.png">
                            <img onclick="cleareverything(); processInput('2')" src="images/key_2.png">
                            <img onclick="cleareverything(); processInput('3')" src="images/key_3.png">
                            <img onclick="cleareverything(); processInput('4')" src="images/key_4.png">
                            <img onclick="cleareverything(); processInput('5')" src="images/key_5.png">
                            <img onclick="cleareverything(); processInput('6')" src="images/key_6.png">
                            <img onclick="cleareverything(); processInput('7')" src="images/key_7.png">
                            <img onclick="cleareverything(); processInput('8')" src="images/key_8.png">
                            <img onclick="cleareverything(); processInput('9')" src="images/key_9.png">
                        </div>
                        <div class="row" style="width:auto; top:70px; left:40px">
                            <img onclick="cleareverything(); processInput('Q')" src="images/key_Q.png">
                            <img onclick="cleareverything(); processInput('W')" src="images/key_W.png">
                            <img onclick="cleareverything(); processInput('E')" src="images/key_E.png">
                            <img onclick="cleareverything(); processInput('R')" src="images/key_R.png">
                            <img onclick="cleareverything(); processInput('T')" src="images/key_T.png">
                            <img onclick="cleareverything(); processInput('Y')" src="images/key_Y.png">
                            <img onclick="cleareverything(); processInput('U')" src="images/key_U.png">
                            <img onclick="cleareverything(); processInput('I')" src="images/key_I.png">
                            <img onclick="cleareverything(); processInput('O')" src="images/key_O.png">
                            <img onclick="cleareverything(); processInput('P')" src="images/key_P.png">

                        </div>
                        <div class="row" style="width:auto; top:140px; left:0px">
                            <img onclick="cleareverything(); processInput('A')" src="images/key_A.png">
                            <img onclick="cleareverything(); processInput('S')" src="images/key_S.png">
                            <img onclick="cleareverything(); processInput('D')" src="images/key_D.png">
                            <img onclick="cleareverything(); processInput('F')" src="images/key_F.png">
                            <img onclick="cleareverything(); processInput('G')" src="images/key_G.png">
                            <img onclick="cleareverything(); processInput('H')" src="images/key_H.png">
                            <img onclick="cleareverything(); processInput('J')" src="images/key_J.png">
                            <img onclick="cleareverything(); processInput('K')" src="images/key_K.png">
                            <img onclick="cleareverything(); processInput('@')" src="images/key_at.png">
                            <img onclick="cleareverything(); processInput('L')" src="images/key_L.png">
                            <img onclick="processDelete()" src="images/key_DELETE.png">

                        </div>
                        <div class="row" style=" width:auto; top:210px; left:40px">
                            <img onclick="cleareverything(); processInput('Z')" src="images/key_Z.png">
                            <img onclick="cleareverything(); processInput('X')" src="images/key_X.png">
                            <img onclick="cleareverything(); processInput('C')" src="images/key_C.png">
                            <img onclick="cleareverything(); processInput('V')" src="images/key_V.png">
                            <img onclick="cleareverything(); processInput('B')" src="images/key_B.png">
                            <img onclick="cleareverything(); processInput('N')" src="images/key_N.png">
                            <img onclick="cleareverything(); processInput('M')" src="images/key_M.png">
                            <img onclick="cleareverything(); processInput('-')" src="images/key_-.png">
                            <img onclick="cleareverything(); processInput('.')" src="images/key_..png">
                            <img onclick="cleareverything(); processInput(' ')" src="images/key_SPACE.png">

                        </div>

                    </div>
			
			</form>
		
			<div style="width:105px; height:55px; background:url(images/intouch.png); position:absolute; left:10px; bottom:35px"></div>
		</div>
				
		<!-- js -->
		<script src="js/jquery.easing.min.js"></script>

		<script>
			$(document).ready(function(){
				$(".screen,.vignette,.chopper,.fields,.submit_dream").hide();
				$( ".row img" ).hover(
					function() {
						$(this).animate({"width":"60px","height":"65px","padding":"10px"},200);
					}, function() {
						$(this).stop(true,true).css({"width":"80px","height":"85px","padding":"0px"},0);
					}
				);
			});
			  
			function show_body() {
				$(function(){
					$(".screen").fadeIn(1000,'easeOutCubic');
					$(".vignette").slideDown(1000,'easeOutCubic');
					$(".logo").animate({"bottom":"0px"},1000,'easeOutCubic');
					$(".win_your").delay(1000).fadeIn(0,1).animate({"right":"50px","top":"20px"},1000,'easeOutCubic');
					$(".every_dream").delay(1000).animate({"right":"20px"},1000,'easeOutCubic');
					$(".win_your").delay(1000).fadeIn(1000,'easeOutCubic');

					$(".keyboard_hive").delay(1500).animate({"left":"0"},1000,'easeOutCubic');
					$(".fields").delay(1000).fadeIn(1000,'easeOutCubic');
					$(".keyboard").delay(1000).animate({"left":"185px"},1000,'easeOutCubic');
					
					$(".chopper").delay(2000).fadeIn(1000,'easeOutCubic',looper);
					function looper(){
						$(".chopper").animate({'top':'100px'},3000,'easeInCubic').animate({'top':'80px'},3000,'easeOutCubic',looper);
					};
					
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
				
				if(validateForm()){
					var current = $('#step'+(step - 1)), next = $('#step'+step), prev = $('#step'+(step - 2));
					
					current.animate({"left":"-1885px"},400,'easeOutCubic');
					next.fadeIn();
				}
				
			}


			function final_submit() {
				
					var frm = $('#survey_frm');
					$.ajax({
							type: "POST",
							url: "<?php echo site_url('/');?>survey/submit/",
							data: frm.serialize(),
							success: function(data) {
								// console.log(data);
								$(".continue").fadeOut(1000);
								$(".fields").animate({'top':'-500px'},500,'easeInCubic');
								$(".screen").delay(500).animate({'top':'40px'},500,'easeOutCubic');

								//fieldWithCurrentFocus = document.getElementById('wish');
							}
						});
				
			}
			function updateFocus() {
				var id = $(this).attr('id');
				fieldWithCurrentFocus = document.getElementById(id);
			}
			
			function validateForm()
					{
						var v = true;
						var s = "";
						if ($("#cellphone").val() == "" || $("#cellphone").val() == "ENTER CELLPHONE") {
							v = false;
							s += "Please enter your Cellphone\n\r";
							$("#cellphone").val("ENTER CELLPHONE")
							fieldWithCurrentFocus = document.getElementById('cellphone');
						}
						if ($("#email").val() == "" || $("#email").val() == "ENTER YOUR EMAIL") {
							v = false;
							s += "Please enter your Email\n\r";
							$("#email").val("ENTER YOUR EMAIL")
							fieldWithCurrentFocus = document.getElementById('email');
						}
						if ($("#fullname").val() == "" || $("#fullname").val() == "ENTER YOUR FULL NAME") {
							v = false;
							s += "Please enter your Last Name\n\r";
							$("#lastname").val("ENTER YOUR LAST NAME")
							fieldWithCurrentFocus = document.getElementById('lastname');
						}
					
						if(!v) alert(s);
						return v;
					}
			
			
		</script>

	</body>
</html>