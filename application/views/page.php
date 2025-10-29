<?php
 //+++++++++++++++++
 //LOAD HEADER
 //Prepare Variables array to pass into header
 //+++++++++++++++++
 $header['title'] = $title. ' - Erongo Med' ;
 $header['metaD'] =  $metaD;

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
           
        <div class="span12">
        <img src="<?php echo base_url('/');?>img/symbol.png" width="222" height="174" style="position:relative;margin-top:-130px;float:right;z-index:5" alt="">
        	 <ul class="breadcrumb">
              <li><a href="#">Home</a> <span class="divider">/</span></li>
              <li class="active"><?php if(isset($title)){echo $title;}?></li>
            </ul> 
        </div>
        
      </div>
      <div class="row-fluid">
           
        <div class="span8">
        	<h2><?php if(isset($heading)){echo $heading;}?></h2>
            <?php if(isset($body)){echo $body;}
			if(isset($contact)){
			
				$this->load->view('inc/contact');	
			}
			
			?>
        </div>
        
        <div class="span4 text-right">
          <h4>Pages</h4>
          <ul style="list-style:none; font-weight:bold"><?php echo $this->main_model->get_navigation_pages();?></ul>
          <h4>News</h4>
          <ul style="list-style:none; font-weight:bold"><?php echo $this->main_model->get_navigation_posts();?></ul>
          <h4>Categories</h4>
          <ul style="list-style:none; font-weight:bold"><?php echo $this->main_model->get_navigation_categories();?></ul>
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
