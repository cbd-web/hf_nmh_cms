<form id="branch_add" name="branch_add" method="post" action="<?php echo site_url('/');?>branch/add_branch_product" class="form-inline">
	<fieldset>
	<input type="hidden" name="product_id_branch"  value="<?php if(isset($product_id)){ echo $product_id; } ?>">
	<div class="input-append span12">
	<input class="span8"<?php if(!isset($product_id)){echo ' disabled' ;}?> id="appendedInputButtons" type="text" name="branch_name" placeholder="Branch name..." value="">
	  <button class="btn btn-inverse btn" id="btn_cat" onClick="add_branch();" type="button"><i class="icon-plus-sign icon-white"></i> Add Branch</button>
	</div>
	<div class="clearfix" style="height:30px;"></div>
   </fieldset>
</form>
<div id="curr_branches">
	<?php

	if(isset($product_id)) {

		$this->branch_model->get_branches_current($product_id);

	}

	?>
</div>

<script type="text/javascript">

function add_branch(){

	//Validate
	if($('#appendedInputButtons').val().length == 0){

			$('#appendedInputButtons').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Name Required", content:"Please supply us with a branch name"});
			$('#appendedInputButtons').popover('show');
			$('#appendedInputButtons').focus();

	}else{

		var frm = $('#branch_add');
		//frm.submit();
		$('#btn_cat').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
		$.ajax({
			type: 'post',
			data: frm.serialize(),
			url: '<?php echo site_url('/').'branch/add_branch_product';?>' ,
			success: function (data) {
				 $('#result_msg').html(data);
				 $('#btn_cat').html('<i class="icon-plus-sign icon-white"></i> Add Branch');
				 reload_category();
			}
		});

	}

}

function delete_branch(id){

	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'branch/delete_branch_product/';?>'+id ,
		success: function (data) {

		 reload_branches();
		}
	});

}

function reload_branches(){

	$.ajax({
		type: 'get',
		url: '<?php echo site_url('/').'branch/reload_branch_product/'.$product_id;?>' ,
		success: function (data) {

			 $('#curr_branches').html(data);

		}
	});
}

$(document).ready(function() {

	<?php echo $this->branch_model->load_branch_typehead();?>
	$('#appendedInputButtons').typeahead({source: subjects})

});

</script>