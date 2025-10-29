
<?php $x = rand(1,9);
	  $y = rand(1,9);
?>	  
	  

 <div class="span12">
   <form action="<?php echo site_url('/')?>main/contact_do/" method="post" accept-charset="utf-8" id="contact-us" name="contact-us">
    <input type="hidden" id="x" name="x" value="<?php echo $x;?>"/>
    <input type="hidden" id="y" name="y" value="<?php echo $y;?>"/>
    <div class="control-group">
        <label class="control-label" for="name">Full Name</label>
        <div class="controls">
          <input type="text" class="span8" id="name" name="name" placeholder="eg: John Smith">
        </div>
      </div>
      <div class="control-group">
        <label class="control-label" for="email">Email Address</label>
        <div class="controls">
          <input type="text" class="span8" id="email" name="email" placeholder="eg: john@example.com">
        </div>
      </div>
       <div class="control-group">
        <label class="control-label" for="msg">Message/Enquiry:</label>
        <div class="controls">
          <textarea rows="3"  class="redactor span8" id="msg" name="msg"></textarea>
        </div>
      </div>
      
      <div class="control-group">
       
          
          <label class="control-label" for="captcha">Security question: (<?php echo $x . ' + ' . $y ; ?>)</label>
           <div class="controls">
          	 <input type="text" id="captcha" class="span3" name="captcha" placeholder="<?php echo $x . ' + ' . $y . ' ='; ?>">
           </div>
          <span class="help-block" style="font-size:11px">To keep automated bots and trawlers from filling the form<br /> please answer the simple security question</span>
          <button type="submit" id="contactbut" class="btn pull-right btn-large btn-inverse clearfix"><i class="icon-envelope icon-white"></i> Send Message</button>
        
      </div>
    </form>
 	
    <div id="contact_msg"></div>
    
 </div>
<script type="text/javascript">

$('#contactbut').click(function(e) {
		
		e.preventDefault();
		var frm = $('#contact-us');
		//frm.submit();
		$('#contactbut').html('<img src="<?php echo base_url('/').'img/load.gif';?>" /> Sending...');
		$.ajax({
			type: 'post',
			url: '<?php echo site_url('/').'main/contact_do/';?>' ,
			data: frm.serialize(),
			success: function (data) {
				
				 $('#contact_msg').html(data);
				 $('#contactbut').html('<i class="icon-envelope"></i> Send Message');
				 
				 
			}
		});	

});
</script>