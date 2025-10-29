						
                       
                        <form id="category_add" name="category_add" method="post" action="<?php echo site_url('/');?>publication/add_category_pub" class="form-inline">
                            <fieldset>
    						<input type="hidden" name="pub_id_cat"  value="<?php if(isset($pub_id)){echo $pub_id;}?>">
                            <div class="input-append span12">
                            <input class="span8"<?php if(!isset($pub_id)){echo ' disabled' ;}?> id="appendedInputButtons" type="text" name="category_name" placeholder="Category name..."value="">
                              <button class="btn btn-inverse btn" id="btn_cat" <?php if(!isset($pub_id)){echo ' title="Please Save the entry below" rel="tooltip" ' ;}?> onClick="add_category();" type="button"><i class="icon-plus-sign icon-white"></i> Add Category</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div> 
                           </fieldset> 
                        </form> 
                      	<div id="curr_cats">
						  <?php
                            if(isset($pub_id)){
                            
                                $this->publication_model->get_categories_current($pub_id);
                             }	
                                
                            ?>
                        </div>
                        <script type="text/javascript">

						
						function add_category(){


							//Validate
							if($('#appendedInputButtons').val().length == 0){

									$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a category name"});
									$('#appendedInputButtons').popover('show');
									$('#appendedInputButtons').focus();

							}else if($('#pub_id_cat').val() == ''){

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
									url: '<?php echo site_url('/').'publication/add_category_pub';?>' ,
									success: function (data) {

										 $('#result_msg').html(data);
										 $('#btn_cat').html('<i class="icon-plus-sign icon-white"></i> Add Category');
										 reload_category();
									}
								});


							}

						}


						function delete_category(id){

								$.ajax({
									type: 'get',
									url: '<?php echo site_url('/').'publication/delete_category_pub/';?>'+id ,
									success: function (data) {

									 reload_category();
									}
								});


						}
						function reload_category(){

								$.ajax({
									type: 'get',
									url: '<?php echo site_url('/').'publication/reload_category_pub/'.$pub_id;?>' ,
									success: function (data) {

										 $('#curr_cats').html(data);

									}
								});


						}
						$(document).ready(function() {

							<?php echo $this->publication_model->load_category_typehead();?>


							$('#appendedInputButtons').typeahead({source: subjects})

						});
						
						
						
					
						</script>  