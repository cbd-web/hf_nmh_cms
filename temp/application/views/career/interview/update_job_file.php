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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/job_files">Job Files</a></li><li>Update Job File</li>
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
                    UPDATE JOB FILE
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
                        <h2>Job File Update Form</h2>

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
                            <form id="job-update" name="job-update" method="post" action="<?php echo site_url('/');?>career/update_job_file_do" class="smart-form">
                                <input type="hidden" name="job_id"  value="<?php if(isset($job_id)){echo $job_id;}?>">

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
                                            <label class="label">Choose Interview Vacancy</label>
                                            <label class="select">
                                                <select name="vacancy">
                                                    <option value="0">Select Vacancy</option>
                                                    <?php echo $this->career_model->get_job_vacancies_select($vacancy_id); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Choose Interview Survey</label>
                                            <label class="select">
                                                <select name="survey">
                                                    <option value="0">Select Survey</option>
                                                    <?php echo $this->career_model->get_job_survey_select($survey_id); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>


                                    </div>

                                </fieldset>

                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPDATE JOB FILE
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

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                    <header>
                        &nbsp;<h2><i class="fa fa-lg fa-fw fa-users"></i> Assign Panellists</h2>

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
                            <form id="pan-add" name="pan-add" method="post" action="<?php echo site_url('/');?>career/add_job_panellist_do" class="smart-form">
                                <input type="hidden" name="job_id"  value="<?php if(isset($job_id)){echo $job_id;}?>">
                                <label class="select">
                                    <select name="panellist">
                                        <option value="0">Select a Panellist</option>
                                        <?php echo $this->career_model->get_job_panellist_select(); ?>
                                    </select>
                                    <i></i>
                                </label>
                                <footer>
                                <button type="submit" name="submit" class="btn btn-primary btn-md" id="pan-butt">
                                    ADD PANELLIST
                                </button>
                                </footer>
                            </form>
                            <div id="curr_pans">
                            <?php echo $this->career_model->get_all_job_panellists($job_id); ?>
                            </div>
                        </div>

                    </div>

                </div>


            </article>

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                    <header>
                        &nbsp;<h2><i class="fa fa-lg fa-fw fa-list"></i> Short List Applicants</h2>

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
                            <?php echo $this->career_model->get_all_job_shortlist($vacancy_id); ?>
                        </div>

                    </div>

                </div>


            </article>

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                    <header>
                        &nbsp;<h2><i class="fa fa-lg fa-fw fa-file-pdf-o"></i> Vacancy Documents</h2>

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
                            <?php echo $this->career_model->get_all_job_documents($vacancy_id); ?>
                        </div>

                    </div>

                </div>


            </article>

        </div>


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->



<?php $this->load->view('career/inc/footer');?>



<script type="text/javascript">


    $('#pan-butt').click(function(e) {

        e.preventDefault();
        //Validate

            var frm = $('#pan-add');
            //frm.submit();
            $('#pan-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/add_job_panellist_do';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "Entry Updated!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $('#result_msg').html(data);
                    $('#pan-butt').html('ADD PANELLIST');

                    reload_panellists();

                }
            });


    });


    function remove_panellist(id, name){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Remove Panellist: "+name+"</span>",
            content : "The panellist will be removed from this job file! Click <strong><u>YES</u></strong> to Remove Panellist. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    type: 'get',
                    url: "<?php echo site_url('/'); ?>career/remove_job_panellist_do/"+id+"/",
                    success: function(data) {

                        reload_panellists();

                    }
                });

                $.smallBox({
                    title : "Panellist: "+name+" Removed!",
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });
            }

        });
        //e.preventDefault();

    }


    function reload_panellists(){

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'career/reload_job_panellists/'.$job_id.'/'; ?>' ,
            success: function (data) {

                $('#curr_pans').html(data);

            }
        });
    }


</script>

</body>
</html>