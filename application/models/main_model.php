<?php
class Main_model extends CI_Model{
	
 	function main_model(){
  		//parent::CI_model();
			
 	}
	
	//+++++++++++++++++++++++++++
	//GET PAGE
	//++++++++++++++++++++++++++
	function get_page($slug){
			
		$test = $this->db->where('slug', $slug);
		$test = $this->db->get('pages');
		return $test->row_array();	

	}	
	//+++++++++++++++++++++++++++
	//GET POST
	//++++++++++++++++++++++++++
	function get_post($slug){
			
		$test = $this->db->where('slug', $slug);
		$test = $this->db->get('posts');
		return $test->row_array();	

	}
	
	//+++++++++++++++++++++++++++
	//GET POST
	//++++++++++++++++++++++++++
	function get_posts($query){
		
		if($query == ''){
				
			$test = $this->db->where('status', 'live');
			$test = $this->db->order_by('datetime', 'DESC');
			$test = $this->db->get('posts');
			
		}else{
			
			$test = $this->db->query($query, FALSE);
			
		}
		if($test->result()){
			
			foreach($test->result() as $row){

					  /*<img src="'.base_url('/').'img/timbthumb.php?src='.$avatar['image'].'&q=100&w=40&h=40'.'" class="img-polaroid" style="float:left;margin:0px 5px 5px 0px"/>*/
					echo '<div class="comment well">
						     <div class="commentbox">
								<div class="arrow"></div>
								<h3 class="commentbox-title"><font style="font-size:16px">'.
							$row->title .'</font><small class="pull-right" style="font-size:12px;">'.date('d M Y',strtotime($row->datetime)).'</small></h3>
							 <div class="popover-content">'.substr(strip_tags($row->body),0,160).'
							 <div class="clearfix" style="height:10px;"></div>
							 <a href="'.site_url('/').'news/'.$row->slug.'/" class="btn pull-right">Read more</a>
							 <div class="clearfix" style="height:40px;"></div>
							</div>
							</div>
							</div>
							<br />';
				
				
			}
			
		}

	}
		
	//+++++++++++++++++++++++++++
	//GET POST
	//++++++++++++++++++++++++++
	function get_home_posts(){
			
		$test = $this->db->where('status', 'live');
		$test = $this->db->order_by('datetime', 'DESC');
		$test = $this->db->limit('2');
		$test = $this->db->get('posts');
		
		if($test->result()){
			echo '<h3>News</h3>';
			foreach($test->result() as $row){

					  /*<img src="'.base_url('/').'img/timbthumb.php?src='.$avatar['image'].'&q=100&w=40&h=40'.'" class="img-polaroid" style="float:left;margin:0px 5px 5px 0px"/>*/
					echo '<div class="comment">
						     <div class="well well-small">
								<div class="arrow"></div>
								<h5 class="commentbox-title"><font style="font-size:16px">'.
							  substr($row->title, 0,19) .'</font><small class="pull-right" style="font-size:12px;">'.date('d M Y',strtotime($row->datetime)).'</small></h5>
							 <div class="popover-content">'.substr(strip_tags($row->body),0,160).'
							 <div class="clearfix" style="height:10px;"></div>
							 <a href="'.site_url('/').'news/'.$row->slug.'/" class="btn btn-mini pull-right">Read more</a>
							 <div class="clearfix" style="height:20px;"></div>
							</div>
							</div>
							</div>
							';
				
				
			}
			
		}

	}
	
	//+++++++++++++++++++++++++++
	//GET COMMENT FORM
	//++++++++++++++++++++++++++
	function get_comments_form($comments, $post_id){
		
		   if(isset($comments) & $comments == 'no'){
					
			
			}elseif(isset($comments) & $comments == 'private'){
				
				$this->show_private_comment_form($post_id);
				
			}elseif(isset($comments) & $comments == 'allow'){
				
				$this->show_comment_form($post_id);
				
			}
			
	}
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW REGISTERED COMMENT FORM
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++		

	function show_private_comment_form($post_id){

		$button_txt1 = "<img src='".base_url("/")."img/load.gif' /> Submitting...";
		$button_txt2 = "<i class='icon-comment'></i> Submit Comment";
		if($this->session->userdata('user_id')){

			echo '<h4>Leave a comment</h4>
				   <form id="commentfrm" name="commentfrm" method="post" action="'.site_url('/').'main/submit_comment/">
					   <input type="hidden" value="'.$post_id.'" name="post_id" />
					   <input type="hidden" value="'.$this->session->userdata('user_id').'" name="user_id" />
					   <textarea rows="3"  class="redactor span6" name="body"></textarea>
					   <br />
					   <button type="submit" id="commentbut" class="btn pull-right"><i class="icon-comment"></i> Submit Comment</button>
				   </form>
				   <div class="clearfix" style="height:20px;"></div>
				   <div id="comment_msg"></div>
				   
				   <script type="text/javascript">
					$("#commentbut").bind("click" , function(e) {
							e.preventDefault();
							var frm = $("#commentfrm");
							$("#commentbut").html("'.$button_txt1.'");
							$.ajax({
								type: "post",
								url: "'. site_url("/").'main/submit_comment/" ,
								data: frm.serialize(),
								success: function (data) {
									 $("#comment_msg").html(data);
									 $("#commentbut").html("'.$button_txt2.'");
								}
							});	
					});
					
					function load_comments(){
						
						$.ajax({
								type: "get",
								url: "'. site_url("/").'main/load_comments/'.$post_id.'" ,
								success: function (data) {
									 $("#comment_id").html(data);
								}
							});	
						
					}
				   </script>';
		
		}else{
			
			echo 'Please Login or Register';
			
		}
		
		
    }
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//SHOW REGISTERED COMMENT FORM
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++		

	function show_comment_form($post_id){

		$button_txt1 = "<img src='".base_url("/")."img/load.gif' /> Submitting...";
		$button_txt2 = "<i class='icon-comment'></i> Submit Comment";
		if($this->session->userdata('user_id')){

			echo '<h4>Leave a comment</h4>
				   <form id="commentfrm" name="commentfrm" method="post" action="'.site_url('/').'main/submit_comment/">
					   <input type="hidden" value="'.$post_id.'" name="post_id" />
					   <input type="hidden" value="'.$this->session->userdata('name').'" placeholder="Your Name" name="name" />
					   <input type="hidden" class="span3" value="'.$this->session->userdata('email').'" placeholder="Your Email" name="email" />
					   <textarea rows="3"  class="redactor span6" name="body"></textarea>
					   <br />
					   <button type="submit" id="commentbut" class="btn pull-right"><i class="icon-comment"></i> Submit Comment</button>
				   </form>
				   <div class="clearfix" style="height:20px;"></div>
				   <div id="comment_msg"></div>
				   
				   <script type="text/javascript">
					$("#commentbut").bind("click" , function(e) {
							e.preventDefault();
							var frm = $("#commentfrm");
							$("#commentbut").html("'.$button_txt1.'");
							$.ajax({
								type: "post",
								url: "'. site_url("/").'main/submit_comment/" ,
								data: frm.serialize(),
								success: function (data) {
									 $("#comment_msg").html(data);
									 $("#commentbut").html("'.$button_txt2.'");
								}
							});	
					});
					function load_comments(){
						
						$.ajax({
								type: "get",
								url: "'. site_url("/").'main/load_comments/'.$post_id.'" ,
								success: function (data) {
									 $("#comment_id").html(data);
								}
							});	
						
					}	
				   </script>';
		
		}else{
			
			echo '<h4>Leave a comment</h4>
				   <form class="well" id="commentfrm" name="commentfrm" method="post" action="'.site_url('/').'main/submit_comment/">
					   <input type="hidden" value="'.$post_id.'" name="post_id" />
					   <input type="text" class="span6 pull-right" value="" placeholder="Your Name" name="name" />
					   <input type="text" class="span6" value="" placeholder="Your Email" name="email" />
					   <textarea rows="3"  class="redactor span12" name="body"></textarea>
					   <br />
					   <button type="submit" id="commentbut" class="btn btn-inverse pull-right"><i class="icon-comment icon-white"></i> Submit Comment</button>
					   <div id="comment_msg"></div>
				   <div class="clearfix" style="height:20px;"></div>
				   </form>
				   <div id="comment_msg"></div>
				   
				   <script type="text/javascript">
					$("#commentbut").bind("click" , function(e) {
							e.preventDefault();
							var frm = $("#commentfrm");
							$("#commentbut").html("'.$button_txt1.'");
							$.ajax({
								type: "post",
								url: "'. site_url("/").'main/submit_comment/" ,
								data: frm.serialize(),
								success: function (data) {
									 $("#comment_msg").html(data);
									 $("#commentbut").html("'.$button_txt2.'");
								}
							});	
					});
					function load_comments(){
						
						$.ajax({
								type: "get",
								url: "'. site_url("/").'main/load_comments/'.$post_id.'" ,
								success: function (data) {
									 $("#comment_id").html(data);
								}
							});	
						
					}	
				   </script>';
			
		}
		
		
    }
	
	//+++++++++++++++++++++++++++
	//GET COMMENTS
	//++++++++++++++++++++++++++
	function get_comments($post_id){

		//GET COMMENTS
		$test = $this->db->where('cont_id', $post_id);
		$test = $this->db->where('status', 'live');
		$test = $this->db->get('comments');
		
		if($test->result()){
			echo '<h4>All comments</h4>';	
			foreach($test->result() as $row){
				
					  
					  /*<img src="'.base_url('/').'img/timbthumb.php?src='.$avatar['image'].'&q=100&w=40&h=40'.'" class="img-polaroid" style="float:left;margin:0px 5px 5px 0px"/>*/
					echo '<div class="comment">
						     <div class="commentbox right">
								<div class="arrow"></div>
								<h3 class="commentbox-title">'.
							$row->name .'</h3>
							 <div class="popover-content">'.$row->body.'
							<small style="color:#CCC">'.date('M d',strtotime($row->datetime)).'</small></div>
							</div>
							</div>
							<br />';
				
			}
			
		}else{
			
		}

	}
	//+++++++++++++++++++++++++++
	//LOAD COMMENTS
	//++++++++++++++++++++++++++
	function load_comments($post_id){

		//GET COMMENTS
		$test = $this->db->where('cont_id', $post_id);
		$test = $this->db->get('comments');
		return $test->row_array();	

	}
		
	//+++++++++++++++++++++++++++
	//GET NAVIGATION
	//++++++++++++++++++++++++++
	function get_navigation(){
			
		$test = $this->db->where('status', 'live');
		$test = $this->db->order_by('title', 'ASC');
		$pages = $this->db->get('pages');
		
		if($pages->result()){
			
			foreach($pages->result() as $page_row){
				
				$active = '';
				if($this->uri->segment('1') == $page_row->slug){
					
					$active = ' class="active"';
				}
				
				echo '<li '.$active.'><a href="'.site_url('/').'page/'.$page_row->slug.'/">'.$page_row->title.'</a></li>';	
				
			}
			$test = $this->db->where('status', 'live');
			$posts = $this->db->get('posts');
			
			if($posts->result()){
					echo '<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown">News <b class="caret"></b></a>
							<ul class="dropdown-menu pull-right"> 
								<li><a href="'.site_url('/').'news/" ><h5>All News</h5></a></li>
								<li class="divider"></li>
							';
								foreach($posts->result() as $post_row){
									
									echo '<li style="padding:0px 10px;min-width:280px"><a  class="well" href="'.site_url('/').'news/'.$post_row->slug.'/">
									<span class="pull-left">'.substr($post_row->title,0,15).'</span><span class="pull-right" style="font-size:10px">'.date('d M Y',strtotime($post_row->datetime)).'</span></a></li>';	
									
								}
					echo ' </ul>
                		</li>';
			}
			
		}else{
			
				
		}

	}
	
	//+++++++++++++++++++++++++++
	//GET SUB NAVIGATION PAGES
	//++++++++++++++++++++++++++
	function get_navigation_pages(){
			
		$test = $this->db->where('status', 'live');
		$test = $this->db->order_by('page_id', 'ASC');
		$pages = $this->db->get('pages');
		
		if($pages->result()){
			
			foreach($pages->result() as $page_row){
				
				$active = '';
				if($this->uri->segment('1') == $page_row->slug){
					
					$active = ' class="active"';
				}
				
				echo '<li '.$active.'><a href="'.site_url('/').'page/'.$page_row->slug.'/">'.$page_row->title.'</a></li>';	
				
			}
			
			
		}else{
			
				
		}

	}
	//+++++++++++++++++++++++++++
	//GET SUB NAVIGATION PAGES
	//++++++++++++++++++++++++++
	function get_navigation_posts(){
			
		$test = $this->db->where('status', 'live');
		$pages = $this->db->get('posts');
		
		if($pages->result()){
			
			foreach($pages->result() as $page_row){
				
				$active = '';
				if($this->uri->segment('1') == $page_row->slug){
					
					$active = ' class="active"';
				}
				
				echo '<li '.$active.'><a href="'.site_url('/').'news/'.$page_row->slug.'/">'.$page_row->title.'</a></li>';	
				
			}
			
			
		}else{
			
				
		}

	}
	//+++++++++++++++++++++++++++
	//GET SUB NAVIGATION CATEGORIES
	//++++++++++++++++++++++++++
	function get_navigation_categories(){
			
		//$test = $this->db->where('status', 'live');
		$pages = $this->db->get('categories');
		
		if($pages->result()){
			
			foreach($pages->result() as $page_row){
				
				$active = '';
				if($this->uri->segment('1') == $page_row->cat_name){
					
					$active = ' class="active"';
				}
				
				echo '<li '.$active.'><a href="'.site_url('/').'main/category/'.$page_row->cat_id.'/'.$this->clean_url_str($page_row->cat_name).'/">'.$page_row->cat_name.'</a></li>';	
				
			}
			
			
		}else{
			
				
		}

	}
	
	//+++++++++++++++++++++++++++
	//GET GALLERY SPECIFIC IMAGEs
	//++++++++++++++++++++++++++
	public function get_sidebar_content($content)
	{

			
		  if( substr($content, 0, strpos($content,'_')) == 'page'){
			  
			  $page_id =  substr($content, (strpos($content,'_') + 1), strlen($content));
			  $query = $this->db->where('page_id', $page_id);
			  $query = $this->db->get('sidebars');
			  
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					  $this->load_sidebar_content($row);
				  }
			  }else{
				 
				// echo '<div class="alert">
				 		//No Sidebar Added</div>'; 
				
			  }

			  
		  }elseif(substr($content, 0, strpos($content,'_')) == 'post'){
			  
			  $post_id =  substr($content, (strpos($content,'_') + 1), strlen($content));
			  $query = $this->db->where('post_id', $post_id);
			  $query = $this->db->get('sidebars');
			  
			  if($query->result()){
				  
				  foreach($query->result() as $row){
					  
					  $this->load_sidebar_content($row);
				  }
			  }else{
				 
				// echo '<div class="alert">
				 		//No Sidebar Added</div>'; 
				 
			  }
			  
		  }else{
			  
			
		  }
					
		//echo $content . '     -  ' .substr($content, 0, strpos($content,'_')) . '    -   ' .substr($content, (strpos($content,'_') + 1), strlen($content));
			 
	
		
	}
	//+++++++++++++++++++++++++++
	//LOAD SIDEBAR CONTENTS
	//++++++++++++++++++++++++++		 
	 
	function load_sidebar_content($row){
		
		$type = substr($row->type, 0, strpos($row->type,'_'));
		$id = substr($row->type, (strpos($row->type,'_')+ 1) , strlen($row->type) );
		
		if($type == 'gallery'){
			
			//echo $id;
		
			$this->load_gallery_images($id);

			
		}elseif($type == 'contact'){
			
			echo 'Gallery';
		}else{
			
			echo $row->type;
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//load gallery images
	//++++++++++++++++++++++++++
	
	function load_gallery_images($gal_id)
	{
		  $x = 0;
 		  $effect = 'slide';
		  $query = $this->db->where('type', 'gal_img');
		  $query = $this->db->where('gal_id', $gal_id);
		  $query = $this->db->get('images');
		  if($query->result()){
				
				echo '<div id="carousel'.$gal_id.'" class="carousel carousel_mini '.$effect.'">
							 
						<!-- Carousel items -->
						<div class="carousel-inner">';
				
				foreach($query->result() as $row){
					$active = '';
					if($x == 0){
					
						$active = 'active';
						
					}
					echo '<div class="item '.$active.'">
								  <img src="'.base_url('/').'assets/images/'.$row->img_file.'" alt="" > 
						 </div>';
					$x ++;
				}
			
			
			   echo '
			   		</div>
				     <!-- Carousel nav -->
					  <a class="carousel-control left" href="#carousel'.$gal_id.'" data-slide="prev">&lsaquo;</a>
					  <a class="carousel-control right" href="#carousel'.$gal_id.'" data-slide="next">&rsaquo;</a>
				</div>
				<script type="text/javascript">
				$(document).ready(function(){
					$("#carousel'.$gal_id.'").carousel();
				});
				</script>
				';
			
		 }else{
			 
			 echo ' No images added';
			
		 }

  
		
	}

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	
		//setlocale(LC_ALL, 'en_US.UTF8');
		function clean_url_str($str, $replace=array(), $delimiter='-') {
			if( !empty($replace) ) {
				$str = str_replace((array)$replace, ' ', $str);
			}
		
			$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
			$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
			$clean = strtolower(trim($clean, '-'));
			$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		
			return $clean;
		}


}
?>