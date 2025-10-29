<?php $this->session->sess_destroy(); ?>

<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if IE 7]>    <html class="no-js lt-ie9 lt-ie8" lang="en"> <![endif]-->
<!--[if IE 8]>    <html class="no-js lt-ie9" lang="en"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="en"> <!--<![endif]-->
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="description" content="">
	<meta name="author" content="">
	<title>ihmsMedia CMS</title>
	<meta name="viewport" content="width=device-width">
 
	<link rel="stylesheet" href="<?php echo base_url('/');?>admin_src/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url('/');?>admin_src/css/general.css">
	<link rel="shortcut icon" href="<?php echo base_url('/');?>admin_src/favicon.ico">
<!--    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="https://ebooks.my-child.co.nz/144.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="https://ebooks.my-child.co.nz/114.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="https://ebooks.my-child.co.nz/72.png">
    <link rel="apple-touch-icon-precomposed" href="https://ebooks.my-child.co.nz/57.png">-->
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/js/bootstrap.min.js"></script>

    <style type="text/css">
      html,body {
        padding-top: 40px;
        padding-bottom: 40px;
		width:100%;
		height:100%;
          background:url('<?php echo base_url('/');?>admin_src/img/background.jpg') no-repeat;
          background-size: cover;
			
      }

    
      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;

		background-color:#fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
        margin-bottom: 10px;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
</head>

<body>

 <div class="container">
				
      <form class="form-signin" method="post" action="<?php echo base_url('/');?>admin/login">
          <p class="lead text-center"><img src="<?php echo base_url('/');?>admin_src/img/logo2.png" /></p>
        <h5 class="form-signin-heading">Please sign in</h5>
          <?php if(isset($error)){ ?>
            <div class="alert alert-error">
             <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $error; ?>
            </div>
            <?php
            }//end error
            if(isset($basicmsg)){ ?>
            <div class="alert alert-success">
             <button type="button" class="close" data-dismiss="alert">×</button>
                <?php echo $basicmsg; ?>
            </div>
            <?php
            }
            ?>                  
        <input type="text" class="input-block-level" name="email" id="email" placeholder="Email address">
        <input type="password" class="input-block-level" name="pass" id="pass" placeholder="Password">
	      <input type="hidden" name="redirect" value="<?php echo current_url('/');?>">
        <label class="checkbox">
          <input type="checkbox" value="remember-me"> Remember me
        </label>
        
        <button class="btn btn-inverse pull-right" type="submit"><i class="icon-lock icon-white"></i> Sign in</button>
        <div class="clearfix" style="height:20px;">&nbsp;</div>
      </form>

	<img alt="ihmsMedia Dashboard" class="pull-left" style="position:absolute;bottom:10px;right:10px;width:110px" src="<?php echo base_url('/');?>admin_src/img/logo_cms_sml.png" />
 </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->


</body>
</html>