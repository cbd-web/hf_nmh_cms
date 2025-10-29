<?php
//++++++++++++++++++++++++++++++++++++
// MY CHILD.CO>NZ
//  HEADER INCLUDE
//  ROLAND IHMS
//++++++++++++++++++++++++++++++++++++

//load general variables and header
			

$rand = rand(0,9999);	
?>
<div class="row-fluid">
 	<div class="span8">
           <h3>Rotate the Photo</h3>
              <hr />
              <div id="rotate_img_div" style="min-height:300px;width:100%">
              	<img src="<?php echo $filename.'?='. $rand;?>" id="rotate_img" class="img-polaroid"/>
              </div>
               <br /><br />
                <div id="rotate_msg"></div>
                
         <a style="float:left;margin-right:5px" href="javascript:rotate_img(270);" id="90_clock" class="btn btn-inverse"><i class="icon-refresh icon-white"></i> 90&deg; clockwise</a>
           <a style="float:left;margin-right:5px" href="javascript:rotate_img(90);" id="90_counter" class="btn btn-inverse"><i class="icon-refresh icon-white"></i> 90&deg; counter-clockwise</a>
            <a style="float:left;margin-right:5px" href="<?php echo $url;?>" class="btn btn-inverse"><i class="icon-remove-sign icon-white"></i> Return</a>
          <form id="rotate" name="rotate" method="post" action="<?php echo site_url('/');?>my_images/rotate">
          	<input type="hidden" id="img_file" name="img_file" value="<?php echo $filename; ?>">
            <input type="hidden" id="absolute_path_rotate" name="absolute_path_rotate" value="<?php echo $absolute_path; ?>" />
            <input type="hidden" id="path_rotate" name="path_rotate" value="<?php echo $path; ?>" />
            <input type="hidden" id="url_rotate" name="url_rotate" value="<?php echo $url ?>" />
          <br />
         

        </form>  
        </div>
        <div class="span4">
  		  <div class="popover top" style="margin-top:60px;display:block;position:relative;width:90%">
               
                <h3 class="popover-title">Legend<i class="icon-info-sign icon-white pull-right"></i></h3>
                <div class="popover-content">
                  
                         <p><i class="icon-info-sign"></i> - Rotate the image</p>
                         <p><i class="icon-refresh"></i> - Rotate 90&deg; clockwise</p>
                         <p><i class="icon-refresh"></i> Rotate 90&deg; counter clockwise</p>
                         <p><i class="icon-remove-sign"></i> - Cancel and return</p>
                            

                
                </div>
              </div>

        </div>
</div>        
<script type="text/javascript">       


function rotate_img(angle){
	
			var frm = $('#rotate');
			
			delete_thumb_cache('<?php echo $filename;?>');
		
			$('#rotate_img').fadeOut("1000").attr('src','');
			$('#rotate_img_div').addClass('loading_img');
			$.ajax({
				type: 'post',
           		url: '<?php echo site_url('/').'my_images/rotate/';?>'+angle ,
				data: {img_file_rotate: '<?php echo $filename;?>', absolute_path_rotate: '<?php echo $absolute_path; ?>', angle: angle, },
				success: function (data) {
					
					$('#rotate_msg').html(data);
					 
				}
			});	
}


function delete_thumb_cache(str){
	
			
			$.ajax({
				type: 'get',
           		url: '<?php echo base_url('/').'img/delete_thumb.php?str=';?>'+str ,
				success: function (data) {
					
					$('#effect_msg').html(data);
					
				}
			});	
}

</script>