<?php $this->load->view('admin/inc/header');?>
    <script type='text/javascript' src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
	<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery-ui-1.10.3.custom.min.js"></script>

<body>



	<?php $this->load->view('admin/inc/nav_top');?>

		

	<div class="container-fluid">

		<div class="row-fluid">

			<?php $this->load->view('admin/inc/nav_main');?>

			<div id="content" class="span10">

			<!-- start: Content -->

			<div>

				<hr>

				<ul class="breadcrumb">

					<li>

						<a href="<?php echo site_url('/');?>">Home</a> <span class="divider">/</span>

					</li>

					<li>

						<a href="#">News Ticker</a>

					</li>

				</ul>

				<hr>

			</div>

			

			<div class="row-fluid sortable">

				<div class="box span8">

					<div class="box-header">

						<h2><i class="icon-th"></i><span class="break"></span>All News Tickers</h2>

						<div class="box-icon">

							<a href="#" class="btn-close"><i class="icon-remove"></i></a>

						</div>

					</div>

					<div class="box-content" id="curr_cats">

                  	  	<?php $this->ticker_model->get_all_tickers();?>
                                        

                  </div>

				</div>

                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">

					<div class="box-header">

						<h2><i class="icon-list"></i><span class="break"></span>News Ticker Stats</h2>

						<div class="box-icon">

							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>

							<a href="#" class="btn-close"><i class="icon-remove"></i></a>

						</div>

					</div>

					<div class="box-content">

					</div>

				</div><!--/span-->

                

  

                

                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">

					<div class="box-header">

						<h2><i class="icon-list"></i><span class="break"></span>Legend</h2>

						<div class="box-icon">

							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>

							<a href="#" class="btn-close"><i class="icon-remove"></i></a>

						</div>

					</div>

					<div class="box-content">

 

                     <div class="well">



                      <p><a title="Delete the sidebar" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Ticker</p>

                      

					</div>

                    <a onClick="add_ticker()" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New Ticker</a> 

		    		</div>

				</div><!--/span-->

                

			</div>

			

			<hr>

			

			<div class="row-fluid">
	

			</div>

			

			<hr>
     		<!-- end: Content -->

			</div><!--/#content.span10-->

		</div><!--/fluid-row-->

				

		<div class="modal hide fade" id="modal-add">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h3>Add News Ticker</h3>

          </div>

          <div class="modal-body">

            <form id="ticker-add" name="ticker-add" method="post" action="<?php echo site_url('/');?>ticker/add_ticker_do" class="form-horizontal">
            
             <div class="control-group">
                  <label class="control-label" for="title">Title</label>
                <div class="controls">
                   <input type="text" id="title" name="title" placeholder="Title" value="">                    
                </div>
              </div>
             <div class="control-group">
                  <label class="control-label" for="link">Link</label>
                <div class="controls">
                   <input type="text" id="link" name="link" placeholder="Link" value="">                  
                </div>
              </div>			  		  
			  			  
              <div class="control-group">
                	<h5>Body</h5>
                   <textarea id="ticker" name="body"></textarea>                    
                
              </div>

            </form>


          </div>

          <div class="modal-footer">

            <a onClick="$('#modal-add').modal('hide');" class="btn">Close</a>

            <a href="#" class="btn btn-primary">Add Entry</a>

          </div>

        </div>

        

        <div class="modal hide fade" id="modal-ticker-delete">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h3>Delete Entry</h3>

          </div>

          <div class="modal-body">

            <div class="alert">

                <button type="button" class="close" data-dismiss="alert">&times;</button>

                 <strong>Please Note!</strong> Are you sure you want to delete the current entry? All entry details will be removed. This process is not reversible.

            </div>

        

          </div>

          <div class="modal-footer">

            <a onClick="$('#modal-ticker-delete').modal('hide');" class="btn">Close</a>

            <a href="#" class="btn btn-primary">Delete Entry</a>

          </div>

        </div>

        <div class="modal hide fade" id="modal-update">

          <div class="modal-header">

            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>

            <h3>Update News Ticker</h3>

          </div>

          <div class="modal-body" id="update_content">

            

          </div>

          <div class="modal-footer">

            <a onClick="$('#modal-update').modal('hide');" class="btn">Close</a>

            <a onClick="update_ticker_do()" id="update_ticker_btn" class="btn btn-primary">Update Entry</a>

          </div>

        </div>

        <div class="clearfix"></div>



	<?php $this->load->view('admin/inc/footer');?>

	</div><!--/.fluid-container-->

	<script type="text/javascript">
	
	$(document).ready(function(e) {
		
			
       
			/* ---------- Text Editor ---------- */
			$('#ticker').redactor({ 	
						fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
						imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
						imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
						buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
						'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
						'video','file', 'table','|',
						 'alignment', '|', 'horizontalrule']
			});	
			
			
			
			$('div.btn-group button').live('click', function(){
				
				$('#status_edit').attr('value', $(this).html());
			});   
	    
    });
		
		
		function delete_ticker(id){


			$('#modal-ticker-delete').bind('show', function() {

				//var id = $(this).data('id'),

					removeBtn = $(this).find('.btn-primary');

						

					removeBtn.unbind('click').click(function(e) { 

						e.preventDefault();	

						$.ajax({

						  url: "<?php echo site_url('/');?>ticker/delete_ticker/"+id+"/",

						  success: function(data) {

							

							$('footer').html(data);

							$('#modal-ticker-delete').modal('hide');

							window.location = '<?php echo site_url('/');?>ticker/news_ticker';

						  }

						});

						

					});

			}).modal({ backdrop: true });

		}

		function add_ticker(){

			  $('#modal-add').bind('show', function() {

					  var removeBtn = $(this).find('.btn-primary');

					  removeBtn.unbind('click').click(function(e) { 

						  e.preventDefault();

						  var frm = $('#ticker-add');

						  removeBtn.html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');

						  $.ajax({

							type: "post",

							data: frm.serialize(),

							url: "<?php echo site_url('/');?>ticker/add_ticker_do",

							success: function(data) {

							  removeBtn.html('Add Entry');

							  $('#msg').html(data);

							  $('#modal-add').modal('hide');

							  window.location = '<?php echo site_url('/');?>ticker/news_ticker';

							}

						  });

						  

					  });

			  }).modal({ backdrop: true });

			  

		  }			

		  

		  function update_ticker(id){

			  $('#modal-update').bind('show', function() {

						  $.ajax({

							type: "get",

							url: "<?php echo site_url('/');?>ticker/get_ticker/"+id,

							success: function(data) {

							  $('#update_content').html(data);

							}

						  });
	  

			  }).modal({ backdrop: true });

		  }

		  function update_ticker_do(){

					var frm = $('#ticker-update');

					$('#update_ticker_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');

					$.ajax({

					  type: "post",

					  data: frm.serialize(),

					  url: "<?php echo site_url('/');?>ticker/update_ticker_do",

					  success: function(data) {

						

						$('#update_ticker_btn').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Update Entry');

						$('#msg').html(data);

						$('#modal-update').modal('hide');

						window.location = '<?php echo site_url('/');?>ticker/news_ticker';

					  }

					});



		  }
		  
		  


	</script>

</body>

</html>