<?php $this->load->view('career/inc/header');?>

<body class="">

<?php $this->load->view('career/inc/head');?>
<?php $this->load->view('career/inc/nav_main');?>


<div id="main" role="main">

    <!-- RIBBON -->
    <div id="ribbon">

				<span class="ribbon-button-alignment">
					<span id="refresh" class="btn btn-ribbon" data-action="resetWidgets" data-title="refresh"  rel="tooltip" data-placement="bottom" data-original-title="<i class='text-warning fa fa-warning'></i> Warning! This will reset all your widget settings." data-html="true">
						<i class="fa fa-refresh"></i>
					</span>
				</span>

        <!-- breadcrumb -->
        <ol class="breadcrumb">
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/departments">Departments</a></li><li>Update Department</li>
        </ol>

    </div>
    <!-- END RIBBON -->

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <!-- PAGE HEADER -->
                    <i class="fa-fw fa fa-suitcase"></i>
                    DEPARTMENTS
                    <span>&gt;
                        Update Department: <strong><?php echo $department; ?></strong>
                    </span>
                </h1>
            </div>

        </div>

        <!-- Vacancy Table -->
        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" role="widget">

                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
                        <h2>Department Update Form</h2>

                        <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span></header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->
                            <input class="form-control" type="text">
                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form id="department-update" name="department-update" method="post" action="<?php echo site_url('/');?>career/update_department_do" class="smart-form">
                                <input type="hidden" name="department_id"  value="<?php if(isset($department_id)){echo $department_id;}?>">

                                <header>

                                        <i class="fa fa-lg fa-fw fa-calendar"></i> <strong>Entry published on:</strong> <?php echo date('d-M-Y',strtotime($listing_date)); ?>

                                </header>

                                <fieldset>

                                    <div class="row">
                                        <section class="col col-12">

                                            <label><h4>Active</h4></label>
                                            <span class="onoffswitch">
                                            <?php
                                            switch($status) {
                                                case 'live':
                                                    $checked = 'checked';
                                                    break;
                                                case 'draft':
                                                    $checked = '';
                                                    break;
                                            }

                                            ?>
                                                <input type="checkbox" name="status" class="onoffswitch-checkbox" id="st3" <?php echo $checked; ?>>
                                            <label class="onoffswitch-label" for="st3">
                                                <div class="onoffswitch-inner" data-swchon-text="YES" data-swchoff-text="NO"></div>
                                                <div class="onoffswitch-switch"></div>
                                            </label>
                                            </span>
                                            </section>
                                    </div>

                                    <div class="row">
                                        <section class="col col-4">
                                            <label class="label">Department</label>
                                            <label class="input">
                                                <input type="text" id="department" name="department" placeholder="Department" value="<?php if(isset($department)){echo $department;} ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Contact Person</label>
                                            <label class="input">
                                                <input type="text" id="contact_name" name="contact_name" placeholder="Contact Person" value="<?php if(isset($contact_name)){echo $contact_name;} ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Email</label>
                                            <label class="input">
                                                <input type="text" class="span8" id="email" name="email" placeholder="Client Email" value="<?php if(isset($email)){echo $email;} ?>">
                                            </label>
                                        </section>
                                    </div>


                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPDATE DEPARTMENT
                                    </button>
                                </footer>

                            </form>

                        </div>

                    </div>
                    <!-- end widget div -->



                </div>



            </article>

        </div>

    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->


<?php $this->load->view('career/inc/footer');?>
<script type='text/javascript' src="<?php echo base_url('/'); ?>admin_src/js/jquery.form.min.js"></script>


<script type="text/javascript">



    $('#butt').click(function(e) {

        e.preventDefault();
        //Validate
        if($('#department').val().length == 0){

            $('#department').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Department Required", content:"Please supply us with a department name"});
            $('#department').popover('show');
            $('#department').focus();


        }else{

            var frm = $('#department-update');
            //frm.submit();
            $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/update_department_do';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "Entry Updated!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $('#result_msg').html(data);
                    $('#butt').html('UPDATE DEPARTMENT');

                }
            });

        }
    });

    </script>

</body>
</html>