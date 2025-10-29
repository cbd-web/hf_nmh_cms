<?php $this->load->view('admin/inc/header');?>

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
						<a href="<?php echo site_url('/');?>admin/email_marketing/">Email Marketing</a><span class="divider">/</span>
					</li>
                    <li>
						Compose
					</li>
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
            
            <form id="sendmail" name="sendmail" method="post" action="<?php echo site_url('/');?>admin/send_email" >
				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Please select some recipients</h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content loading_img" style="width:100%" id="subscriber_div">
                  	  	<p>
							<?php //echo $this->email_model->show_email_recipients();?>
		             	</p>                  
                  </div>
				</div>
               
                <div class="box span8 noMargin" onTablet="span12" onDesktop="span8">
					<div class="box-header">
						<h2><i class="icon-list"></i><span class="break"></span>Compose Email</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">
                    
                      <div id="email_comp">	
                          <input type="text" class="span8" style="font-size:22px;line-height:32px;height:40px;padding:5px" onKeyDown="$('#title').popover('destroy');" id="title" name="title" placeholder="Subject..." />
                          <input type="radio" style="display:none" name="recipient" id="radio_all" value="all">
                          <input type="radio" style="display:none" name="recipient" id="radio_2" value="none">
                          <input type="hidden" id="admin_id" name="admin_id" value="<?php echo $admin_id?>">
                          <textarea id="redactor_content" style="display:none" name="content"></textarea>
                          <div class="clearfix" style="height:20px;"></div>
                          <button type="submit" id="send_mail_btn" class="btn btn-large pull-right"><i class="icon-envelope"></i> Send Newsletter</button>
                          <a href="javascript:preview();" class="btn btn-large pull-right" style="margin-right:10px;"><i class="icon-check"></i> Preview</a>
                      </div>
                      <div id="email_preview"></div>
                      <a href="javascript:close_preview();" class="btn btn-large pull-right hide" id="pre_butt" style="margin-right:10px;"><i class="icon-remove"></i> Back</a>   
                      
                      <div class="clearfix" style="height:40px;"></div>
					</div>
				</div><!--/span-->
                
               
                
                
            </form>    
			</div>
			
			<hr>
			
			<div class="row-fluid">
				
				
				
			</div>
			
			<hr>
			

			
			<!-- end: Content -->
			</div><!--/#content.span10-->
		</div><!--/fluid-row-->
				
		 <?php 
         //+++++++++++++++++
         //MODAL HTML
         //+++++++++++++++++
         ?>  
           
        <div id="modal-email" class="modal hide fade">
            <div class="modal-header">
              <a onClick="javascript:$('#modal-email').modal('hide')" href="#" class="close">&times;</a>
              <h3>Send Emails?</h3>
            </div>
            <div class="modal-body">
             Are you sure you want to send the email to the selected recipients?
             <div id="result_cover"></div>
                    <p id="result_msg"></p> 
                    <div class="progress progress-striped active" id="barcover" style="display:none">
                        <div class="bar bar-warning" id="barProgress" style="width: 0%;"></div>
                    </div>
            </div>
            <div class="modal-footer">
              <a href="#" id="send_email_yes" class="btn btn-primary">Yes, Send</a>
              <a onClick="javascript:$('#modal-email').modal('hide')" href="#" class="btn secondary">Close</a>
            </div>
        </div>
		
        <div class="clearfix"></div>
	<?php $this->load->view('admin/inc/footer');?>
    </div><!--/.fluid-container-->
    
    <script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datepicker.js"></script>
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type="text/javascript">
	$(document).ready(function(e) {
        
  
		/* ---------- Text Editor ---------- */
		$('#redactor_content').redactor({ 	
					
					imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
					imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
					buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
					'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
					'video','file', 'table', 'link','|',
					 'alignment', '|', 'horizontalrule'],
					linebreaks: true,
					focus:true,
					plugins: ['fullscreen', 'fontcolor', 'fontsize','fontfamily']
		});
		
		$('#dob').datepicker();
		
		//Load Members
		$.get('<?php echo site_url('/'). 'admin/ajax_load_subscribers/';?>', function(data) {
			  	$('#subscriber_div').html(data).removeClass('loading_img');
			  		$('#subscriber_table').dataTable( {
					  	"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span6'i><'span6'p>>",
						"sPaginationType": "bootstrap",
						"oLanguage": {
							"sLengthMenu": "_MENU_ "
						},
						"aaSorting":[],
						"bSortClasses": false
			
					} );
					$('.dataTables_paginate').parent().removeClass('span6').addClass('span12');
					$('#subscriber_table_length').find('select').addClass('span6');
					$('#subscriber_table_length').parent().removeClass('span6').addClass('span4');
					$('#subscriber_table_filter').parent().removeClass('span6').addClass('span8');	
					
					
			});
			
	
	});
	

	
	
	function preview(){
	
	    var content = $('#email_comp'), str = $('#redactor_content').val(), butt = $('#pre_butt'), preview = $('#email_preview');
		content.slideUp();
		//loading.addClass('loading_img');
	
		$.ajax({
			type: 'post',
			cache: false,
			data:{mailbody: str},
			url: '<?php echo site_url('/').'admin/preview_email/';?>' ,
			success: function (data) {
					
				preview.html(data);
				butt.show();
				preview.slideDown();
			}
		});	
	
	}

	function close_preview(){
	
	    var content = $('#email_comp'), butt = $('#pre_butt'), preview = $('#email_preview');
		content.slideDown();
		preview.slideUp();
		butt.hide();
		
	
	}
	
	
	$('#send_mail_btn').bind('click', function(e){ 
		
		e.preventDefault();
		if(!$('#title').val().length == 0){
			
				$('#modal-email').bind('show', function() {
						
						$('#send_email_yes').unbind('click').click( function() { 	

								var bar = $('#barcover .bar'),  loading = $('#loading_img');
								var barcover = $('#barcover');
								var frm = $('#sendmail');
								barcover.show();
								frm.attr('action','<?php echo site_url('/').'admin/send_email/';?>');
								
								$('#send_email_yes').html('<img src="<?php echo base_url('/').'admin_src/img/spinner-mini.gif';?>" /> Sending...');
									
									$.ajax({
										type: 'post',
										cache: false,
										data: frm.serialize(),
										url: '<?php echo site_url('/').'admin/send_email/';?>' ,
										success: function (data) {
											//barcover.hide();
											
											$('#result_cover').html(data);
										}
									});	
								
						});		
						
					})
					.modal({ backdrop: true });	
		}else{
			
			$('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Subject Required", content:"Please give the newsletter a valid and enticing subject line."});
			$('#title').popover('show');
			$('#title').focus();
				
		}			
	
});

	
	</script>
</body>
</html>