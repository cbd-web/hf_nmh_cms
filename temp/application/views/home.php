<?php 
echo $this->load->view('inc/header');?>

    <style type="text/css">
      html,body {
        padding-top: 10px;
        padding-bottom: 40px;
          background:url('<?php echo base_url('/');?>admin_src/img/background.jpg') no-repeat;
          background-size: cover;
			
      }

    
      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
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
<div class="wrap">
    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container">
	  
     <!-- START THE FEATURETTES -->
     <!-- Three columns of text below the carousel -->
      <div class="row">
        <div class="span12">
         <div class="clearfix" style="height:20px"></div>
            <p class="lead text-center"><img src="<?php echo base_url('/');?>admin_src/img/logo2.png" style="max-width:180px"/></p>
            <h4 class="featurette-heading text-center" style="color: #FFF;">My Namibia &trade; <br /><small class="muted">CMS</small></h4>
               <div class="container text-center" style="max-width:320px">  
                 <form class="form-signin" method="post" action="<?php echo base_url('/');?>admin/login">
                    
                    <h5 class="form-signin-heading  text-left">Please sign in</h5>
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
                    <label class="checkbox  text-left">
                      <input type="checkbox" value="remember-me"> Remember me
                    </label>
                    
                    <button class="btn btn-inverse pull-right" type="submit"><i class="icon-lock icon-white"></i> Sign in</button>
                    <div class="clearfix" style="height:20px;">&nbsp;</div>
                  </form>

               </div> 
                
        </div><!-- /.span4 -->
      </div><!-- /.row -->
	
      <!-- /END THE FEATURETTES -->	
    




	<div class="clearfix" style="height:30px;"></div>
    </div><!-- /.container -->
    <div id="push"></div>
    
    
</div><!-- /.wrap -->

<?php //echo $this->load->view('inc/footer');?>
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
    <script src="<?php echo base_url('/');?>js/bootstrap.min.js"></script> 
    <script>
      !function ($) {
        $(function(){
          $('[rel="tooltip"],[data-rel="tooltip"]').tooltip({"placement": "bottom",delay: { show: 400, hide: 200 }});
          $('#myCarousel').carousel()
        })
      }(window.jQuery)
    </script>
    
  </body>
</html>
