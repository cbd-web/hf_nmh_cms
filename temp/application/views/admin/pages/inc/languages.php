
              <form id="page-update_<?php echo $language;?>" name="page-update_<?php echo $language;?>" method="post" action="<?php echo site_url('/');?>admin/update_page_do_language/<?php echo $language;?>" class="form-horizontal">
               <fieldset>
                              <input type="hidden" name="page_id_<?php echo $language;?>"  value="<?php if(isset($pageID)){echo $pageID;}?>">
                              <input type="hidden" name="autosave_<?php echo $language;?>" id="autosave_<?php echo $language;?>"  value="true">
                            <div class="control-group">
                              <label class="control-label" for="title_<?php echo $language;?>">Title</label>
                              <div class="controls">
                                      <input type="text" class="span6" id="title_<?php echo $language;?>" name="title_<?php echo $language;?>" placeholder="<?php echo ucwords($language);?> Page title" value="<?php if(isset($titleD)){echo $titleD;}?>">
                              </div>
                            </div>
            
                           <div class="control-group">
                              <label class="control-label" for="heading_<?php echo $language;?>">Heading</label>
                              <div class="controls">
                                      <input type="text" class="span6" id="heading_<?php echo $language;?>" name="heading_<?php echo $language;?>" placeholder="Page Heading" value="<?php if(isset($headingD)){echo $headingD;}?>">
                                      <span class="help-block" style="font-size:11px">Optional, give your page a sub heading (h2)</span>
                              </div>
                            </div>
                            <div class="control-group">
                              <label class="control-label" for="slug_<?php echo $language;?>">Slug</label>
                              <div class="controls">
                                      <input type="text" class="span6" id="slug_<?php echo $language;?>" name="slug_<?php echo $language;?>" placeholder="Page URL Slug eg: /about-us" value="<?php if(isset($slugD)){echo $slugD;}?>">  
                              </div>
                            </div>


                            <?php $this->admin_model->get_page_templates($page_template);?>

                                          
                            <div class="control-group" id="redactor_content_msg_<?php echo $language;?>">
                                  <label class="control-label" for="redactor_content_<?php echo $language;?>"><?php echo $language;?>Page Body:</label>
                                  <div class="controls">
                                      
                                      <textarea class="redactor_content" id="redactor_content_<?php echo $language;?>" name="content_<?php echo $language;?>" style="display:block"><?php if(isset($bodyD)){echo $bodyD;}?></textarea>
                                  </div>
                             </div>
                           
                                 <div class="control-group">
                                     <label class="control-label" for="metaT_<?php echo $language;?>">Meta Title:</label>
                                      <div class="controls">
                                          <textarea name="metaT_<?php echo $language;?>" style="display:block" class="span6"><?php if(isset($metaTD)){echo $metaTD;}?></textarea>
                                          <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                       </div>
                                 </div>
                            
                             
                              
                               <div class="control-group">
                                      <label class="control-label" for="metaD_<?php echo $language;?>">Meta Description:</label>
                                      <div class="controls">
                                           <textarea name="metaD_<?php echo $language;?>" style="display:block" class="span6"><?php if(isset($metaDD)){echo $metaDD;}?></textarea>
                                           <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
                                      </div>
                                 </div>
                            
                            <div id="result_msg_<?php echo $language;?>"></div>
                            <button type="submit" class="btn btn-inverse btn pull-right" id="butt_<?php echo $language;?>">Update Page</button>
                            <a href="<?php echo $this->session->userdata('url').'/'.$language;?>/page/<?php echo $slugD;?>/" target="_blank" style="margin: 0px 10px" class="btn pull-right btn-inverse"><i class="icon-search icon-white"></i> Preview</a> 
                 </fieldset> 
               </form>

<script type="text/javascript">

		
	$('#butt_<?php echo $language;?>').bind('click', function(e) {
	
		
		e.preventDefault();
		//Validate
		if($('#title_<?php echo $language;?>').val().length == 0){
				
				$('#title_<?php echo $language;?>').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a page title"});
				$('#title_<?php echo $language;?>').popover('show');
				$('#title_<?php echo $language;?>').focus();
		
		}else{
	
			submit_form_<?php echo $language;?>();
			
		}
	});

	
	function submit_form_<?php echo $language;?>(){
			
			var frm = $('#page-update_<?php echo $language;?>');
			//frm.submit();
			$('#butt_<?php echo $language;?>').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/');?>admin/update_page_do_language/<?php echo $language;?>' ,
				success: function (data) {
					 //$('#autosave').val('true');
					 $('#result_msg_<?php echo $language;?>').html(data);
					 $('#butt_<?php echo $language;?>').html('Update Page');
					
				}
			});	
	
	}
	
	
</script>	