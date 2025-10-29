<div class="row-fluid sortable">


	<div class="box span12">
		<div class="box-header">
			<h2><i class="icon-th"></i><span class="break"></span> Update Calculator: <?php echo $title;?></h2>
			<div class="box-icon">
				<a href="#" class="btn-close"><i class="icon-remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			<p>
				<form id="calc-update" name="calc-update" method="post" action="<?php echo site_url('/');?>calculator/update_calculator_do" class="form-horizontal">
			 		<fieldset>
						<input type="hidden" name="id"  value="<?php if(isset($id)){echo $id;}?>">
						<input type="hidden" name="type"  value="<?php if(isset($type)){echo $type;}?>">
						<input type="hidden" name="autosave" id="autosave"  value="true">
						<input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
						
					  <div class="control-group">
						<label class="control-label" for="status">Status</label>
						<div class="controls">
							<div class="btn-group" data-toggle="buttons-radio">
							  <button type="button" class="btn btn-primary status<?php if($status == 'draft'){ echo ' active';}?>">draft</button>
							  <button type="button" class="btn btn-primary status<?php if($status == 'live'){ echo ' active';}?>">live</button>
							</div>
						</div>
					  </div>											
						
					  <div class="control-group">
						<label class="control-label" for="name">Vat</label>
						<div class="controls">
								<input type="number" class="span6" id="vat" name="vat" placeholder="VAT (%)" value="<?php if(isset($vat)){echo $vat;}?>">
						</div>
					  </div>
					  
					  <div class="control-group">
						<label class="control-label" for="name">Stamp Duty</label>
						<div class="controls">
								<input type="text" class="span6" id="stamp_duty" name="stamp_duty" placeholder="Stamp Duty" value="<?php if(isset($stamp_duty)){echo $stamp_duty;}?>">
						</div>
					  </div>
					  
					  <div class="control-group">
						<label class="control-label" for="name">Office Fee</label>
						<div class="controls">
								<input type="text" class="span6" id="office_fee" name="office_fee" placeholder="Office Fee" value="<?php if(isset($office_fee)){echo $office_fee;}?>">
						</div>
					  </div>
					  
					  <div class="control-group">
						<label class="control-label" for="name">Sundries & Postage + 15% VAT</label>
						<div class="controls">
								<input type="text" class="span6" id="sundries" name="sundries" placeholder="Sundries & Postage + 15% VAT" value="<?php if(isset($sundries)){echo $sundries;}?>">
						</div>
					  </div>									  									  										  
					  
					  <div id="result_msg"></div>
					  
					  <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Calculator</button> 
			   </fieldset> 
			 </form>							
			</p>                  
	  </div>
	</div>
</div>
<div class="row-fluid sortable">
	<div class="box span4">
		<div class="box-header">
			<h2><i class="icon-th"></i><span class="break"></span>Bond Cost Fees</h2>
			<div class="box-icon">
				<a href="#" class="btn-close"><i class="icon-remove"></i></a>
			</div>
		</div>
		<div class="box-content">
			
			<?php ?>                
	  </div>
	</div>          
</div>


