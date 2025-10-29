<?php $this->load->view('career/inc/header');?>

<link href="<?php echo base_url('/');?>admin_src/redactor/redactor/redactor.css" rel="stylesheet">

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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/job_files">Job Files</a></li><li>Add Job File</li>
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
                    JOB FILES
                    <span>&gt;
                        Add new Job File
                    </span>
                </h1>
            </div>

        </div>

        <!-- Vacancy Table -->
        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" role="widget">
                    <!-- widget options:
                        usage: <div class="jarviswidget" id="wid-id-0" data-widget-editbutton="false">

                        data-widget-colorbutton="false"
                        data-widget-editbutton="false"
                        data-widget-togglebutton="false"
                        data-widget-deletebutton="false"
                        data-widget-fullscreenbutton="false"
                        data-widget-custombutton="false"
                        data-widget-collapsed="true"
                        data-widget-sortable="false"

                    -->
                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
                        <h2>Vacancy Upload Form</h2>

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
                            <form id="vacancy-add" name="vacancy-add" method="post" action="<?php echo site_url('/');?>career/add_job_file_do" class="smart-form">
                                <header>
                                    Job File Upload Form
                                </header>

                                <fieldset>
                                    <div class="row">
                                        <section class="col col-4">
                                            <label class="label">Title</label>
                                            <label class="input">
                                                <input type="text" id="title" name="title" placeholder="Job File Title" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Choose Interview Vacancy</label>
                                            <label class="select">
                                                <select name="vacancy">
                                                    <option value="0">Select Vacancy</option>
                                                    <?php echo $this->career_model->get_job_vacancies_select(); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Choose Interview Survey</label>
                                            <label class="select">
                                                <select name="survey">
                                                    <option value="0">Select Survey</option>
                                                    <?php echo $this->career_model->get_job_survey_select(); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>

                                    </div>

                                </fieldset>

                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPLOAD JOB FILE
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

<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>

<script type="text/javascript">

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    // START AND FINISH DATE
    $('#datepicker').datepicker({
        dateFormat: 'dd.mm.yy',
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        onSelect: function (selectedDate) {
            $('#finishdate').datepicker('option', 'minDate', selectedDate);
        }
    });

    $('#datepicker2').datepicker({
        dateFormat: 'dd.mm.yy',
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        onSelect: function (selectedDate) {
            $('#finishdate2').datepicker('option', 'minDate', selectedDate);
        }
    });




    $(document).ready(function() {

        /* ---------- Text Editor ---------- */
        $('.redactor_content').redactor({
            fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
            imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
            imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
            buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
                'unorderedlist', 'orderedlist', 'outdent', 'indent', '|','image',
                'video','file', 'table', 'link','|',
                'alignment', '|', 'horizontalrule'],
            linebreaks: true,
            focus:true,
            plugins: ['fullscreen', 'fontcolor', 'fontsize','fontfamily']
        });

        pageSetUp();


    });





</script>

</body>
</html>