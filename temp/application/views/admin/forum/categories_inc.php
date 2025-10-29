						
                       <div style="overflow:hidden">
                        <form id="category_add" name="category_add" method="post" action="<?php echo site_url('/');?>forum/add_topic_do" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="forum_discussion_id"  value="<?php if(isset($forum_discussion_id)){echo $forum_discussion_id;}?>">                        
                            <div class="input-append">
                              <input class="span8"<?php if(!isset($forum_discussion_id)){echo ' disabled' ;}?> id="appendedInputButtons" type="text" name="topic_name" placeholder="Topic name..." value="">
                              <button class="btn btn-inverse btn" id="btn_cat" <?php if(!isset($forum_discussion_id)){echo ' title="Please Save the post below" rel="tooltip" ' ;}?> onClick="add_category();" type="button"><i class="icon-plus-sign icon-white"></i> Add Topic</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form> 
                      	<div id="curr_cats">
						  <?php 
                            if(isset($forum_discussion_id)){
                            
                                $this->forum_model->get_topics_current($forum_discussion_id);
                             }	
                                
                            ?>
                        </div>
                        </div>
                        <script type="text/javascript">

						
						function add_category(){
			
							
							//Validate
							if($('#appendedInputButtons').val().length == 0){
									
									$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a category name"});
									$('#appendedInputButtons').popover('show');
									$('#appendedInputButtons').focus();
							
							}else if($('#post_id_cat').val() == ''){
								
								    $('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Save the Post", content:"Please add the post and then add categories"});
									$('#appendedInputButtons').popover('show');
									$('#appendedInputButtons').focus();
							
							}else{
								
								
								var frm = $('#category_add');
								//frm.submit();
								$('#btn_cat').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
								$.ajax({
									type: 'post',
									data: frm.serialize(),
									url: '<?php echo site_url('/').'forum/add_topic_do';?>' ,
									success: function (data) {
										
										 $('#result_msg').html(data);
										 $('#btn_cat').html('<i class="icon-plus-sign icon-white"></i> Add Topic');
										 reload_category();
									}
								});	
					
								
							}		
						
						}
						
						
						function delete_category(id){
			
								$.ajax({
									type: 'get',
									url: '<?php echo site_url('/').'forum/delete_category/';?>'+id ,
									success: function (data) {
										
									 reload_category();	 
									}
								});	
						
						
						}
						function reload_category(){
			
								$.ajax({
									type: 'get',
									url: '<?php echo site_url('/').'forum/reload_category/'.$forum_discussion_id;?>' ,
									success: function (data) {
										
										 $('#curr_cats').html(data);
										 
									}
								});	
						
						
						}
						$(document).ready(function() {
		
							<?php echo $this->forum_model->load_topic_typehead();?>
	
				
							$('#appendedInputButtons').typeahead({source: subjects}) 
					
						});
						
						
						
					
						</script>  