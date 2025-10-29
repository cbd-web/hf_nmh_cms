<link rel="stylesheet" href="<?php echo base_url('/');?>admin_src/css/jquery.Jcrop.css" type="text/css" />
<?php
//++++++++++++++++++++++++++++++++++++
// MY NAMIBIA 
//  CROP INCLUDE
//  ROLAND IHMS
//++++++++++++++++++++++++++++++++++++

			
	$rand = rand(0,9999);
	$filename = $filename;
	$orig_w = $width;
	$orig_h = $height;
   
	
	
	//Save Folder
	$folder =  base_url('/') . $path;
	$gfolder =  base_url('/') . $path;
	
	$targ_w = 750;
	$targ_h = 300;
	
	$ratio = $targ_w / $targ_h;
?>
 <form action="<?php echo site_url('/');?>my_images/crop_cover" method="post" enctype="multipart/form-data" id="frm-crop" onSubmit="return checkCoords();">
<div class="row-fluid"> 
    
    <div class="span12">
           <h3>Crop photo</h3>
            
              <div class="jcrop">
        	  	<div class="loading_img" id="pre_loader" style="width:100%; height:200px"></div>
                <img src="<?php echo $filename.'?='. $rand;?>" id="cropbox" class="img-polaroid hide"/><br /><br />
          		
             
                <input type="hidden" id="filename" name="filename" value="<?php echo $image ?>" />
                <input type="hidden" id="absolute_path" name="absolute_path" value="<?php echo $absolute_path; ?>" />
                <input type="hidden" id="path" name="path" value="<?php echo $path; ?>" />
                <input type="hidden" id="url" name="url" value="<?php echo $url ?>" />
                <input type="hidden" id="folder" name="folder" value="<?php echo $folder ?>" />
                <input type="hidden" id="targ_w" name="targ_w" value="<?php echo $targ_w ?>" />
                <input type="hidden" id="targ_h" name="targ_h" value="<?php echo $targ_h ?>" />
                <input type="hidden"  id="o_wid" name="o_wid" value="<?php echo $orig_w ?>" />
                <input type="hidden"  id="o_hei" name="o_hei" value="<?php echo $orig_h ?>" />
                <input type="hidden" id="x" name="x" />
                <input type="hidden" id="boxwidth" name="boxwidth" />
                <input type="hidden"  id="y" name="y" />
                <input type="hidden"  id="x2" name="x2" />
                <input type="hidden"  id="y2" name="y2" />
                <input type="hidden"  id="w" name="w" />
                <input type="hidden"  id="h" name="h" />

           
           
           </div> 
      </div>
</div>
<div class="row-fluid"> 
      <div class="span3">
               <div id="crop_msg"></div>
               <button type="submit" class="btn btn-inverse" id="btn_crop" alt="Crop" title="Crop Image"><i class="icon-retweet icon-white"></i> Crop Image</button>
               <a style="float:left;margin-right:5px" href="<?php echo $url;?>" class="btn btn-inverse"><i class="icon-remove-sign icon-white"></i> Return</a>
      
      </div> 
     <div class="span9">
            <div class="popover top" style="float:right;margin-top:0px;display:block;position:relative;width:80%">
               
                <h3 class="popover-title">Legend<i class="icon-info-sign icon-white pull-right"></i></h3>
                <div class="popover-content">
                  
                          <p><i class="icon-info-sign"></i> - Set image area to be cropped</p>
                          <p><i class="icon-retweet"></i> - Crop the image</p>
                          <p><i class="icon-remove-sign"></i> - Cancel and return</p>
                          

                 
                </div>
              </div>

       
          
           <div class="jcrop">
           <!-- <h3>Preview</h3>
            
             	<div style="width:300px;height:105px;background:#fff;overflow:hidden;">
                
    				<img src="<?php echo $filename.'?='. $rand?>" id="preview_cover_img" />
    			</div>-->
			 
          </div>
   </div>
</div>   
 </form>   
        <script  src="<?php echo base_url('/');?>admin_src/js/jquery.Jcrop.min.js"></script>

        <script type="text/javascript">


			$(document).ready(function(e) {
                
				$('#btn_crop').bind('click', function(e){
					
					
						e.preventDefault();
						var frm = $('#frm-crop');
						//frm.submit();
						$('#btn_crop').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');
						$.ajax({
							type: 'post',
							url: '<?php echo site_url('/').'my_images/crop_cover';?>' ,
							data: frm.serialize(),
							success: function (data) {
								
								 $('#crop_msg').html(data);
								 $('#btn_crop').html('<i class="icon-retweet icon-white"></i> Crop Image');
								 
								 
							}
						});		
				
				});
				
				start_crop();
				
            });	

			
			function start_crop(){
					

					$('#cropbox').Jcrop({
						trueSize: [<?php echo $orig_w?>,<?php echo $orig_h?>],
						boxWidth: <?php echo $orig_w?>,
						//minSize: [<?php echo $targ_w?>,<?php echo $targ_h?>],
						//aspectRatio: <?php echo $ratio;?>,
						setSelect: [ 0, 0, <?php echo $targ_w?>,<?php echo $targ_h?>],
						bgColor:     'black',
						bgOpacity:   .4,
						onSelect: updateCoords,
						onChange: updateCoords
					});	
					$('#pre_loader').hide();
					setTimeout($('#cropbox').fadeIn(), 2000);
					
			}
			
			

			function updateCoords(c)
			{
				showPreview(c);
				$('#x').val(c.x);
				$('#y').val(c.y);
				$('#w').val(c.w);
				$('#h').val(c.h);
				$('#boxwidth').val('Box width: '+$('#cropbox').width());
			};

			function checkCoords()
			{
				if (parseInt($('#w').val())) return true;
				alert('Please select a crop region then press submit.');
				return false;
			};

			function showPreview(coords)
				{
					var rx = 300 / coords.w;
					var ry = 200 / coords.h;
					
					$("#preview_cover_img").css({
						width: Math.round(rx*<?php echo $targ_w;?>)+'px',
						height: Math.round(ry*<?php echo $targ_h;?>)+'px',
						marginLeft:'-'+  Math.round(rx*coords.x)+'px',
						marginTop: '-'+ Math.round(ry*coords.y)+'px'
					});
					
				}
				
				



</script>  