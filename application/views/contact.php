<?php
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = 'Contact Us - Erongo Med' ;
 $header['metaD'] =  'Have a question or just wanna get hold of us. Contact us here';

 $this->load->view('inc/header', $header);
 
 //ADDITIONAL RESOURCES
 //add css, IE7 js files here before the head tag 
echo $this->load->view('inc/header');?>

<div class="wrap">
  <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" style="height:230px;">
    
      <div class="carousel-inner" style="height:290px;">
      <img src="<?php echo base_url('/');?>img/red_square3.jpg" style="position:absolute;" />
        <div class="item active">
         
          <div class="container">
            <div class="carousel-caption">
             <h1 class="heading"><?php if(isset($title)){echo $title;}?></h1>
            </div>
          </div>
        </div>
        
    
    </div><!-- /.carousel -->
    <div id="slider_bot"></div>
</div>


    <!-- Marketing messaging and featurettes
    ================================================== -->
    <!-- Wrap the rest of the page in another container to center all the content. -->

    <div class="container" id="content_cont">

      <div class="row-fluid">
           
        <div class="span8">
        	 <ul class="breadcrumb">
              <li><a href="#">Home</a> <span class="divider">/</span></li>
              <li class="active"><?php if(isset($title)){echo $title;}?></li>
            </ul> 
        	<h2><?php if(isset($heading)){echo $heading;}?></h2>
            <?php if(isset($body)){echo $body;}?>
        </div>
        
        <div class="span4">
        
        </div>	
           
      </div>
      <hr />
      
    </div><!-- /.container -->
    <div id="push"></div>
    
    
</div><!-- /.wrap -->

<?php echo $this->load->view('inc/footer');?>
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
