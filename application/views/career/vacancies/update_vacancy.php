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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/vacancies">Vacancies</a></li><li>Update Vacancy</li>
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
                    VACANCIES
                    <span> <strong><?php echo $title; ?></strong>
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
                        <h2>Vacancy Update Form</h2>

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
                            <form id="vacancy-update" name="vacancy-update" method="post" action="<?php echo site_url('/');?>career/update_vacancy_do" class="smart-form">
                                <input type="hidden" name="vacancy_id"  value="<?php if(isset($vacancy_id)){echo $vacancy_id;}?>">

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
                                            <label class="label">Title</label>
                                            <label class="input">
                                                <input type="text" id="title" name="title" placeholder="Vacancy title" value="<?php if(isset($title)){echo $title;} ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Reference Number</label>
                                            <label class="input">
                                                <input type="text" class="span8" id="ref_no" name="ref_no" placeholder="Reference Number" value="<?php if(isset($ref_no)){echo $ref_no;} ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Client</label>
                                            <label class="select">
                                                <select name="client">
                                                    <option value="0">Select Client</option>
                                                    <?php echo $this->career_model->get_clients_select($client_id); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Department</label>
                                            <label class="select">
                                                <select name="department">
                                                    <option value="0">Select Department</option>
                                                    <?php echo $this->career_model->get_departments_select($department_id); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Location</label>
                                            <label class="select">
                                                <select name="location">
                                                    <option value="0">Select Location</option>
                                                    <?php echo $this->career_model->get_career_locations_select($location); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">Start Date</label>
                                            <label class="input">
                                                <i class="icon-append fa fa-calendar"></i>
                                                <input type="text" data-dateformat="dd.mm.yyyy" name="start_date" id="datepicker" value="<?php if (isset($start_date)){echo date('d.m.Y',strtotime($start_date));}else{ echo date('d.m.Y');} ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">End Date</label>
                                            <label class="input">
                                                <i class="icon-append fa fa-calendar"></i>
                                                <input type="text" data-dateformat="dd.mm.yyyy" name="end_date" id="datepicker2" value="<?php if (isset($end_date)){echo date('d.m.Y',strtotime($end_date));}else{ echo date('d.m.Y');} ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Industry Category</label>
                                            <label class="select">
                                                <select name="industry">
                                                    <option value="0">Select Category</option>
                                                    <?php echo $this->career_model->get_industry_categories_select($industry_id); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Filed of Study/Discipline Category</label>
                                            <label class="select">
                                                <select name="discipline">
                                                    <option value="0">Select Category</option>
                                                    <?php echo $this->career_model->get_discipline_categories_select($discipline_id); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Management Level</label>
                                            <label class="select">
                                                <select name="level">
                                                    <?php echo $this->career_model->get_management_select($level); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Vacancy Type</label>
                                            <label class="select">
                                                <select name="vac_type">
                                                    <option value="public" <?php if($type == 'public') { echo 'selected'; } ?>>Public</option>
                                                    <option value="internal" <?php if($type == 'internal') { echo 'selected'; } ?>>Internal</option>
                                                    <option value="all" <?php if($type == 'all') { echo 'selected'; } ?>>Public / Internal</option>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>

                                    </div>

                                    <section>
                                        <label class="label">Vacancy Description</label>
                                        <label class="textarea">
                                            <textarea id="redactor_content" class="redactor_content" rows="4" name="body"><?php if(isset($body)){echo $body;} ?></textarea> </label>
                                        <div class="note">

                                        </div>
                                    </section>
                                </fieldset>

                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPDATE VACANCY
                                    </button>
                                </footer>

                            </form>

                        </div>

                    </div>
                    <!-- end widget div -->



                </div>



            </article>

        </div>

        <div class="row">
            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                    <header>
                        &nbsp;<h2><i class="fa fa-lg fa-fw fa-question"></i> MINIMUM REQUIREMENT ENTRIES</h2>

                    </header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">

                            <button data-toggle="modal" data-target="#myQuestion" class="btn btn-info">ADD MIMIMUM REQUIREMENT</button>
                            <form action="" method="post" id="action_multi_mr_files" class="form">
                                <div class="note pull-right">
                                    <strong>Note:</strong> You can update the sequence of entires by dragging and dropping them.
                                </div>
                                <div class="row" id="question_div">

                                    <?php echo $this->career_model->vacancy_mr_questions($vacancy_id); ?>

                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-lg-12">
                                        <select id="mr_bulk" class="form-control" name="mr_bulk" >
                                            <option value="0">Bulk Actions</option>
                                            <option value="1">Delete Selected</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-lg-3">

                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>

                </div>


            </article>
        </div>

        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                        <header>
                            &nbsp;<h2><i class="fa fa-lg fa-fw fa-camera"></i> Featured Image</h2>

                        </header>

                        <!-- widget div-->
                        <div role="content">

                            <!-- widget edit box -->
                            <div class="jarviswidget-editbox">
                                <!-- This area used as dropdown edit box -->

                            </div>
                            <!-- end widget edit box -->

                            <!-- widget content -->
                            <div class="widget-body">
                                <?php $this->career_model->get_featured_image($vacancy_id);?>
                            </div>

                        </div>

                    </div>


            </article>

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                    <header>
                        &nbsp;<h2><i class="fa fa-lg fa-fw fa-file-pdf-o"></i> Documents (Basic)</h2>

                    </header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form class="dropzone" id="mydropzone1">
                                <input type="hidden" value="<?php echo $vacancy_id; ?>" name="vacancy_id">
                                <input type="hidden" value="<?php echo $bus_id; ?>" name="bus_id">
                                <input type="hidden" value="basic" name="level">
                                <div class="dz-default dz-message"><span><span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp;&nbsp;<h4 class="display-inline"> (Or Click)</h4></span></span></span></span></div>
                            </form>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?php echo NA_URL; ?>vacancy/action_vacancy_docs_bulk" method="post" id="action_multi_files1" class="form">
                                        <input type="hidden" value="<?php echo $title; ?>" name="title">
                                        <input type="hidden" value="<?php echo $bus_id; ?>" name="bus_id">
                                        <input type="hidden" value="basic" name="level">
                                        <div id="curr_docs1">
                                        <?php echo $this->career_model->get_vacancy_docs($vacancy_id, 'basic'); ?>
                                        </div>
                                        <select id="bulk1" class="form-control" name="bulk" >
                                            <option value="0">Bulk Actions</option>
                                            <option value="1">Delete Selected</option>
                                            <option value="2">Zip and Download Selected</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>



                    </div>

                </div>


            </article>

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                    <header>
                        &nbsp;<h2><i class="fa fa-lg fa-fw fa-file-pdf-o"></i> Documents (Advanced)</h2>

                    </header>

                    <!-- widget div-->
                    <div role="content">

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <!-- widget content -->
                        <div class="widget-body">
                            <form class="dropzone" id="mydropzone2">
                                <input type="hidden" value="<?php echo $vacancy_id; ?>" name="vacancy_id">
                                <input type="hidden" value="<?php echo $bus_id; ?>" name="bus_id">
                                <input type="hidden" value="advanced" name="level">
                                <div class="dz-default dz-message"><span><span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp;&nbsp;<h4 class="display-inline"> (Or Click)</h4></span></span></span></span></div>
                            </form>
                            <hr>
                            <div class="row">
                                <div class="col-md-12">
                                    <form action="<?php echo NA_URL; ?>vacancy/action_vacancy_docs_bulk" method="post" id="action_multi_files2" class="form">
                                        <input type="hidden" value="<?php echo $title; ?>" name="title">
                                        <input type="hidden" value="<?php echo $bus_id; ?>" name="bus_id">
                                        <input type="hidden" value="advanced" name="level">
                                        <div id="curr_docs2">
                                            <?php echo $this->career_model->get_vacancy_docs($vacancy_id, 'advanced'); ?>
                                        </div>
                                        <select id="bulk2" class="form-control" name="bulk" >
                                            <option value="0">Bulk Actions</option>
                                            <option value="1">Delete Selected</option>
                                            <option value="2">Zip and Download Selected</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>


            </article>



        </div>


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->

<div class="modal fade" id="myQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Add Minimum Requirement</h4>
            </div>
            <div class="modal-body">
                <form id="mr_question_add" class="smart-form" method="post" action="<?php echo site_url('/');?>career/add_vacancy_mr_question_do">
                    <input type="hidden" name="vacancy_id"  value="<?php if(isset($vacancy_id)){echo $vacancy_id;}?>">
                    <div class="row-fluid">
                        <div class="col-md-12">

                            <div class="form-group">
                                <label>MR Category</label>
                                <label class="select">
                                    <select name="mr_category">
                                        <option value="0">Select a Category</option>
                                        <?php echo $this->career_model->get_vacancy_mr_select(); ?>
                                    </select>
                                    <i></i>
                                </label>
                                <br>
                            </div>

                            <div class="form-group">
                                <label>Mimimum Requirement</label>
                                <textarea class="form-control" rows="3" name="question" id="question" required></textarea>
                                <br>
                            </div>

                            <div class="form-group">
                                <label>Help text</label>
                                <textarea class="form-control" rows="3" name="help"></textarea>
                                <br>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">
                                    <input type="checkbox" name="answer">
                                    <i></i>Request Yes/No Answer</label>

                                <div class="note">
                                    <strong>Note:</strong> Please check if candidate has to answer with Yes or No.
                                </div>
                                <br>
                            </div>
                            <div class="form-group">
                                <label class="checkbox">
                                    <input type="checkbox" name="elaborate">
                                    <i></i>Elaborate</label>

                                <div class="note">
                                    <strong>Note:</strong> Please check if candidate has to elaborate.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div style="clear: both"></div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="question_butt" class="btn btn-primary">
                    Upload Requirement
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="myUpdateQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Update Minimum Requirement</h4>
            </div>
            <div class="modal-body" id="update_q_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="update_question_butt" class="btn btn-primary">
                    Update Requirement
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('career/inc/footer');?>
<script type='text/javascript' src="<?php echo base_url('/'); ?>admin_src/js/jquery.form.min.js"></script>

<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>

<script src="<?php echo base_url('/'); ?>admin_src/smart/js/plugin/dropzone/dropzone.min.js"></script>


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


    function bulk_action(bulk, lev){

        if(bulk == 1) {

            var message = "Selected files will be deleted permanently! Click <strong><u>YES</u></strong> to delete entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Delete Document Files</span>";
            var on_success  = "Files successfully removed";

        }


        if(bulk == 2) {

            var message = "Selected files status will be zipped and downloaded! Click <strong><u>YES</u></strong> to download entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Zip and Download Files</span>";
            var on_success  = "Files successfully zipped and downloaded";

        }

        $.SmartMessageBox({
            title : title,
            content : message,
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                var frm = $('#action_multi_files'+lev);

                if(bulk == 1) {

                    $.ajax({
                        type: 'post',
                        data: frm.serialize(),
                        url: '<?php echo NA_URL; ?>career/action_vacancy_docs_bulk/',
                        success: function(data) {

                            reload_documents(lev);

                            $("#action_multi_files"+lev)[0].reset();

                        }
                    });

                }

                if(bulk == 2) {

                    document.getElementById("action_multi_files"+lev).submit();
                    $("#action_multi_files"+lev)[0].reset();
                }


                $.smallBox({
                    title : on_success,
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000,
                });



            } else {

                $("#action_multi_files"+lev)[0].reset();
            }

        });


        //e.preventDefault();

    }

    $(document).ready(function() {

        $("#bulk1").change(function() {

            var bulk = ($(this).val());

            if(bulk != 0) {

                bulk_action(bulk, '1');

            }

        });

        $("#bulk2").change(function() {

            var bulk = ($(this).val());

            if(bulk != 0) {

                bulk_action(bulk, '2');

            }

        });


        //DROPZONE FILES
        Dropzone.autoDiscover = false;


        $("#mydropzone1").dropzone({

            url: "<?php echo NA_URL.'vacancy/add_vacancy_docs'; ?>",
            addRemoveLinks : true,

            maxFilesize: 5.,
            dictResponseError: 'Error uploading file!',
            init: function() {
                this.on("complete", function() {

                    reload_documents('1');
                    $("#ta").prop("checked", false);

                });
            }
        });

        $("#mydropzone2").dropzone({

            url: "<?php echo NA_URL.'vacancy/add_vacancy_docs'; ?>",
            addRemoveLinks : true,

            maxFilesize: 5.,
            dictResponseError: 'Error uploading file!',
            init: function() {
                this.on("complete", function() {

                    reload_documents('2');
                    $("#ta").prop("checked", false);

                });
            }
        });

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

    $('#butt').click(function(e) {

        e.preventDefault();
        //Validate
        if($('#title').val().length == 0){

            $('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a vacancy title"});
            $('#title').popover('show');
            $('#title').focus();

        }else{

            var frm = $('#vacancy-update');
            //frm.submit();
            $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/update_vacancy_do';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "Entry Updated!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $('#result_msg').html(data);
                    $('#butt').html('Update Vacancy');

                }
            });

        }
    });


    // START FEATURE SUBMIT
    $('#imgbut').bind('click', function(e) {

        //e.preventDefault();

        var avataroptions = {
            target:        '#feature_msg',
            url:       	   '<?php echo NA_URL.'vacancy/add_vacancy_image'; ?>' ,
            beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
            uploadProgress: function(event, position, total, percentComplete) {
                var percentVal = percentComplete + '%';
                probar.width(percentVal)

            },
            complete: function(xhr) {
                procover.hide();
                probar.width('0%');
                $('#feature_msg').html(xhr.responseText);
                $('#imgbut').html('Update Image');
                //notify('Avatar Successfully Uploaded', 'Congratulations', '#739E73', '2000', 'fa fa-check fadeInLeft animated');

            }

        };

        var frm = $('#add-img');
        var probar = $('#procover .progress-bar');
        var procover = $('#procover');

        $('#imgbut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
        procover.show();
        frm.ajaxForm(avataroptions);


    });


    function delete_document(id, title, lev){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Delete File: "+title+"</span>",
            content : "The file will be deleted permanently! Click <strong><u>YES</u></strong> to Delete File. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    type: 'get',
                    url: "<?php echo NA_URL; ?>vacancy/delete_vacancy_document_do/"+id+"/",
                    success: function(data) {

                        reload_documents(lev);

                    }
                });

                $.smallBox({
                    title : "File: "+title+" Deleted!",
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });
            }

        });
        //e.preventDefault();

    }


    function reload_documents(lev){

        if(lev == '1') { var level = 'basic'; }
        if(lev == '2') { var level = 'advanced'; }

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'career/reload_vacancy_documents/'.$vacancy_id.'/'; ?>'+level ,
            success: function (data) {

                $('#curr_docs'+lev).html(data);

            }
        });
    }



    function update_question(id){

        var  cont = $('#update_q_body');
        cont.empty().addClass('loading_img');
        $.ajax({
            url: "<?php echo site_url('/');?>career/update_vacancy_mr_question/"+id+"/",
            success: function(data) {
                cont.removeClass('loading_img').html(data);
                $('#update_q_body').html(data);

            }
        });


    }

    function bulk_mr_action(bulk){

        if(bulk == 1) {

            var message = "Selected entries will be deleted permanently! Click <strong><u>YES</u></strong> to delete entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Delete Entries</span>";
            var on_success  = "Entries successfully removed";

        }


        $.SmartMessageBox({
            title : title,
            content : message,
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                var frm = $('#action_multi_mr_files');

                if(bulk == 1) {

                    $.ajax({
                        type: 'post',
                        data: frm.serialize(),
                        url: '<?php echo site_url('/') ?>career/action_vacancy_mr_bulk/'+bulk,
                        success: function(data) {

                            reload_questions();

                            $("#action_multi_mr_files")[0].reset();

                        }
                    });

                }


                $.smallBox({
                    title : on_success,
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000,
                });



            }

        });


        //e.preventDefault();

    }

    $(document).ready(function() {

        $("#mr_bulk").change(function () {

            var bulk = ($(this).val());

            if (bulk != 0) {

                bulk_mr_action(bulk);

            }

        });


        $('#question_butt').click(function(e) {

            e.preventDefault();
            //Validate
            if($('#question').val().length == 0){

                $('#question').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Question Required", content:"Please supply us with a Question"});
                $('#question').popover('show');
                $('#question').focus();


            }else{

                var frm = $('#mr_question_add');
                //frm.submit();
                $('#question_butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
                $.ajax({
                    type: 'post',
                    data: frm.serialize(),
                    url: '<?php echo site_url('/').'career/add_vacancy_mr_question_do';?>' ,
                    success: function (data) {

                        $("#mr_question_add")[0].reset();
                        $('#q_answers_pre').empty();
                        $('#myQuestion').modal('hide');
                        $('#q_answers').val('');
                        $('#answer_select').val('');

                        $.smallBox({
                            title : "Minimum Requirement Question Added!",
                            content : "Operation Success",
                            color : "#659265",
                            iconSmall : "fa fa-check fa-2x fadeInRight animated",
                            timeout : 4000
                        });

                        $('#result_msg').html(data);
                        $('#question_butt').html('Upload Question');
                        reload_questions();
                    }
                });

            }
        });


        $('#update_question_butt').click(function(e) {

            e.preventDefault();
            //Validate
            if($('#question_u').val().length == 0){

                $('#question_u').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Question Required", content:"Please supply us with a Minimum Requirement"});
                $('#question_u').popover('show');
                $('#question_u').focus();


            }else{

                var frm = $('#vacancy_mr_question_update');
                //frm.submit();
                $('#update_question_butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
                $.ajax({
                    type: 'post',
                    data: frm.serialize(),
                    url: '<?php echo site_url('/').'career/update_vacancy_mr_question_do';?>' ,
                    success: function (data) {

                        $("#vacancy_mr_question_update")[0].reset();
                        $('#q_answers_pre_u').empty();
                        $('#myUpdateQuestion').modal('hide');
                        $('#q_answers_u').val('');
                        $('#answer_select_u').val('');

                        $.smallBox({
                            title : "Question Updated!",
                            content : "Operation Success",
                            color : "#659265",
                            iconSmall : "fa fa-check fa-2x fadeInRight animated",
                            timeout : 4000
                        });

                        $('#result_msg').html(data);
                        $('#update_question_butt').html('Update Question');
                        reload_questions();
                    }
                });

            }
        });


    });

    function delete_question(id, title){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Delete Entry: "+title+"</span>",
            content : "The entry will be deleted permanently! Click <strong><u>YES</u></strong> to Delete File. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    url: "<?php echo site_url('/');?>career/delete_vacancy_mr_question_do/"+id+"/",
                    success: function(data) {
                        reload_questions();
                        $("#ta").prop("checked", false);
                    }
                });

                $.smallBox({
                    title : "Entry: "+title+" Deleted!",
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });
            }

        });
        //e.preventDefault();

    }

    function reload_questions(){

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'career/reload_vacancy_questions/'.$vacancy_id; ?>' ,
            success: function (data) {

                $('#question_div').html(data);

            }
        });
    }

    </script>

</body>
</html>