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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/departments">Departments</a></li><li>Add Department</li>
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
                    Clients
                    <span>&gt;
                        Add new Department
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
                        <h2>Department Upload Form</h2>

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
                            <form id="client-add" name="client-add" method="post" action="<?php echo site_url('/');?>career/add_department_do" class="smart-form">
                                <header>
                                    Client Upload Form
                                </header>

                                <fieldset>
                                    <div class="row">
                                        <section class="col col-4">
                                            <label class="label">Department</label>
                                            <label class="input">
                                                <input type="text" id="department" name="department" placeholder="Department" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Contact Person</label>
                                            <label class="input">
                                                <input type="text" id="contact_name" name="contact_name" placeholder="Contact Person" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Email</label>
                                            <label class="input">
                                                <input type="text" class="span8" id="email" name="email" placeholder="Email" value="">
                                            </label>
                                        </section>
                                    </div>

                                </fieldset>

                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPLOAD DEPARTMENT
                                    </button>
                                </footer>

                            </form>

                        </div>
                        <!-- end widget content -->

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

</body>
</html>