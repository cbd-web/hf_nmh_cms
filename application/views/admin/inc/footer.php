    <footer id="admin_footer">
        <p>
            <span style="text-align:left;float:left">&copy; <a href="http://www.rolandihms.me" target="_blank">roland ihms</a> <?php date('y');?></span>
            <span style="text-align:right;float:right"><a href="http://intouch.com.na"><img alt="ihmsMedia Dashboard" class="pull-left" style="width:110px" src="<?php echo base_url('/');?>admin_src/img/logo_cms_sml.png" /></a></span>
        </p>

    </footer>


	<?php //$this->output->enable_profiler(TRUE);?>
	<!-- start: JavaScript-->



	<script src="<?php echo base_url('/');?>admin_src/js/jquery-migrate-1.0.0.min.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/jquery-ui-1.10.0.custom.min.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/jquery.ui.touch-punch.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/bootstrap.min.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/bootstrap-select.min.js"></script>

    <script src='<?php echo base_url('/');?>admin_src/js/fullcalendar.min.js'></script>

    <script src='<?php echo base_url('/');?>admin_src/js/jquery.dataTables.min.js'></script>

    <script src="<?php echo base_url('/');?>admin_src/js/excanvas.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/js/jquery.flot.min.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/js/jquery.flot.pie.min.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/js/jquery.flot.stack.js"></script>
	<script src="<?php echo base_url('/');?>admin_src/js/jquery.flot.resize.min.js"></script>
	
	<script src="<?php echo base_url('/');?>admin_src/js/jquery.chosen.min.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/jquery.uniform.min.js"></script>
    
    <script src="<?php echo base_url('/');?>admin_src/redactor/redactor/redactor.min.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/jquery.noty.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/jquery.iphone.toggle.js"></script>   

    <script src="<?php echo base_url('/');?>admin_src/js/jquery.masonry.min.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/jquery.knob.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/jquery.sparkline.min.js"></script>

    <script src="<?php echo base_url('/');?>admin_src/js/custom.js"></script>
		

	<?php $this->admin_model->notify_msg();?>
	<!-- end: JavaScript-->