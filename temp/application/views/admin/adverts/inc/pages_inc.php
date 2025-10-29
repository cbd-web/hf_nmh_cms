						
<form id="page_add" name="page_add" method="post" action="<?php echo site_url('/');?>advert/add_advert_page" class="form-inline">
    <fieldset>
	<input type="hidden" name="advert_id" value="<?php if(isset($advert_id)){echo $advert_id;}?>">
    <div class="input-append span12">
    <input class="span8"<?php if(!isset($advert_id)){echo ' disabled' ;}?> id="appendedInputButtons3" type="text" name="page_name" placeholder="Page name..."value="">
      <button class="btn btn-inverse btn" id="btn_page" <?php if(!isset($advert_id)){echo ' title="Please Save the entry below" rel="tooltip" ' ;}?> onClick="add_page();" type="button"><i class="icon-plus-sign icon-white"></i> Add Page</button>
    </div>
    <div class="clearfix" style="height:30px;"></div> 
   </fieldset> 
</form> 
<div id="curr_pages">
  <?php 
    if(isset($advert_id)){
        $this->advert_model->get_pages_current($advert_id);
    }   
  ?>
</div>
<script type="text/javascript">

	function add_page(){

		//Validate
		if($('#appendedInputButtons3').val().length == 0){

				$('#appendedInputButtons3').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a page name"});
				$('#appendedInputButtons3').popover('show');
				$('#appendedInputButtons3').focus();

		}else{
						
			var frm = $('#page_add');
			//frm.submit();
			$('#btn_page').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
			$.ajax({
				type: 'post',
				data: frm.serialize(),
				url: '<?php echo site_url('/').'advert/add_advert_page'; ?>' ,
				success: function (data) {
					
					$('#result_msg').html(data);
					$('#btn_page').html('<i class="icon-plus-sign icon-white"></i> Add Page');
					reload_page();

				}
			});	

		}		

	}

	function delete_page(id){

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'advert/delete_page_advert/'; ?>'+id ,
			success: function (data) {
				reload_page();
			}
		});

	}

	function reload_page(){

		$.ajax({
			type: 'get',
			url: '<?php echo site_url('/').'advert/reload_page_adverts/'.$advert_id; ?>' ,
			success: function (data) {
				
				 $('#curr_pages').html(data);
				 
			}
		});

	}

	$(document).ready(function() {

		<?php echo $this->advert_model->load_page_typehead();?>

		$('#appendedInputButtons3').typeahead({source: subjects}) 

	});
						
</script>  