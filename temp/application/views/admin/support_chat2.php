<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Help Desk</title>

<link id="bootstrap-style" href="<?php echo base_url('/');?>admin_src/css/bootstrap.min.css" rel="stylesheet">


<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/js/bootstrap.min.js"></script>
	


</head>
<body>
<div class="modal-header">
<h4 class="modal-title">Logistics Support Services: Help Desk</h4>
</div>
<div class="modal-body">
<table class="table table-striped" id="ticket-body">
 <?php echo $this->admin_model->get_chat_content($ticket); ?>
</table>
<form name="add-quick-message" id="add-quick-message" method="post" action="<?php echo site_url('/'); ?>admin/add_quick_message" enctype="multipart/form-data">
<input name="ticket" type="hidden" value="<?php echo $ticket; ?>" />
<div class="form-group">
<textarea class="form-control" placeholder="Write a reply..." name="chat_body" id="textarea-expand"></textarea>
</div>
<div class="form-group">
<button  type="submit" id="submit-message">
	Send
</button>
</div>
</form>
</div>

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
	
	var ticket = <?php echo $ticket; ?>
	
		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'admin/reload_chat_all/' ;?>'+ticket,
			success: function (data) {
				
				 $('#ticket-body').html(data);

			}
		});	
	
	}		

				
						
</script>

</body>
</html>
