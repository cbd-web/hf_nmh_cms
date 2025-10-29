<?php $this->load->view('admin/inc/header');?>
<body>

	<?php $this->load->view('admin/inc/nav_top');?>
		
	<div class="container-fluid" id="chat_content">
	
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
						<a href="#">Helpdesk</a> <span class="divider">/</span>
					</li>
					<li>
						Support Chat: Ticket No. <?php echo $ticket ?>
					</li>					
				</ul>
				<hr>
			</div>
			
			<div class="row-fluid sortable">
				<div class="box span12">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>Support Chat: Ticket No. <?php echo $ticket ?></h2>
						<div class="box-icon">
							<a href="#" class="btn-close"><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content" id="curr_cats">
						<table class="table table-striped" id="ticket-body">
						 <?php echo $this->admin_model->get_chat_content($ticket); ?>
						</table>
						<form name="add-quick-message" id="add-quick-message" method="post" action="<?php echo site_url('/'); ?>admin/add_quick_message" enctype="multipart/form-data">
						<input name="ticket" type="hidden" value="<?php echo $ticket; ?>" />
						<div class="form-group">
						<textarea style="width:99%" placeholder="Write a reply..." name="chat_body" id="textarea-expand"></textarea>
						</div>
						<div class="form-group">
						<button  type="submit" id="submit-message">
							Send
						</button>
						<a href="<?php echo site_url('/'); ?>admin/close_ticket/<?php echo $ticket; ?>" class="btn btn-inverse pull-right">
							Close Ticket
						</a>
						</div>
						</form>                 
                  </div>
				</div>
			</div>
			

		<!-- end: Content -->
		</div><!--/#content.span10-->
	</div><!--/fluid-row-->
				
         
	
	<?php $this->load->view('admin/inc/footer');?>
	</div><!--/.fluid-container-->
	<script type="text/javascript">
	
	$(document).ready(function() {

		$('#submit-message').click(function(e) {
		
			var chat_val = true;
				
				e.preventDefault();
				//Validate
				if($('#textarea-expand').val().length == 0){
						
						$('#textarea-expand').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Message Required", content:"Please enter some text"});
						$('#textarea-expand').popover('show');
						$('#textarea-expand').focus();
						var chat_val = false;
				
				} else {
				
					$('#textarea-expand').popover('hide');
					var chat_val = true;	
					
				}
				
				if(chat_val == true) {
					
				submit_message();
					
				}
				
					
			});			
		
	});
	
	function submit_message(){
			
		var frm = $('#add-quick-message');
		
		
		$('#submit-message').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			
			type: 'post',
			//data: frm.serialize()+'&content2='+content,
			data: frm.serialize(),
			url: '<?php echo site_url('/').'admin/add_quick_message/'; ?>',
			success: function() {
				 $('#submit-message').html('Send');
				 reload_chat();
				 document.getElementById("add-quick-message").reset();
	
				 
			}		
			
		});	
		
	}
	
	setInterval(function (){
        reload_chat();
		
      },10000);		
	
	
	function reload_chat(){
		
	var $elem = $('#chat_content');
	var ticket = <?php echo $ticket; ?>
	
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/reload_chat_all/' ;?>'+ticket,
			success: function (data) {
				
				$('#ticket-body').html(data);
				$('html, body').animate({scrollTop: $elem.height()}, 800);
			}
		});	
	
	}		

				
						
</script>
</body>
</html>