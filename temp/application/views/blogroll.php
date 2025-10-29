<?php 
echo $this->load->view('inc/header');?>

<div class="wrap">
  <!-- Carousel
    ================================================== -->
    <div id="myCarousel" class="carousel slide" style="height:230px;">
      <div class="carousel-inner" style="height:290px;background:url(<?php echo base_url('/');?>img/red_square4.jpg)">
        <div class="item active">
         
          <div class="container">
            <div class="carousel-caption">
             <h1 class="heading"><?php if(isset($title)){echo $title;}?></h1>
             <h2 class="heading" style="color: #FFF"><?php if(isset($heading)){echo $heading;}?></h2>
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
                 <ul class="breadcrumb">
                  <li><a href="#">Home</a> <span class="divider">/</span></li>
                  <li><a href="<?php echo site_url('/');?>main/news/">News</a> <span class="divider">/</span></li>
                  <li class="active"><?php if(isset($title)){echo $title;}?></li>
                </ul> 
            </div>
            
          </div>
          <div class="row-fluid">
               
            <div class="span8">
               
                <?php 
				
					$this->main_model->get_posts($query);
				?>
                <hr />
      			
                <?php if(isset($comments)){ $this->main_model->get_comments_form($comments, $post_id); ?> 
				  <div id="comment_id"><?php $this->main_model->get_comments($post_id);?></div>
				<?php }?>
            </div>
            
            <div class="span4 text-right">
             <?php 
			  //$this->load->view('inc/staff_inc');
			  //$this->main_model->get_sidebar_content('post_'.$post_id);?>
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
