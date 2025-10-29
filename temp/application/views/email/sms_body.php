<style type="text/css">

.iphone{
	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
	background: url('<?php echo base_url('/');?>img/sms/iphone.png') no-repeat;
	padding: 110px 35px;
	height:600px;



}

.iphone p{
	font-family: "Helvetica Neue", Arial, Helvetica, sans-serif;
	font-size:14px;
	width:auto;
	max-width:230px;
	font-weight:bold;

}

div{


}
</style>
<div class="row-fluid">

	<div class="span4">
		&nbsp;
	</div>
	<div class="span4">
		<div class="iphone">
			<p><?php if(isset($body)){ echo $body; }?></p>
		</div>

	</div>

	<div class="span4">
		&nbsp;
	</div>
</div>

