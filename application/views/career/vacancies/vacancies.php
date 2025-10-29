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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li>Vacancies</li>
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
                    <span>&gt;
                        List of all vacancies
                    </span>
                </h1>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
                <a class="btn btn-primary btn-lg pull-right" href="<?php echo site_url('/') ?>career/add_vacancy"><i class="glyphicon glyphicon-plus"></i> ADD NEW VACANCY</a>
            </div>
        </div>

        <!-- Vacancy Table -->
        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>All Vacancies Listed</h2>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->



                        <div class="widget-body no-padding">

                            <form action="" method="post" id="action_multi_files" class="form">
                            <div  id="curr_vac">
                            <?php $this->career_model->get_all_vacancies(); ?>
                            </div>

                                <div class="row-fluid">
                                    <div class="col-md-3 col-lg-3">
                                        <select id="bulk" class="form-control" name="bulk" >
                                            <option value="0">Bulk Actions</option>
                                            <option value="1">Delete Selected</option>
                                            <option value="2">Change status to live</option>
                                            <option value="3">Change status to draft</option>
                                            <option value="4">Change status to archive</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3 col-lg-3">

                                    </div>
                                </div>
                                <div class="clearfix" style="height:30px;"></div>
                            </form>
                            <hr>
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

<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">

    // DO NOT REMOVE : GLOBAL FUNCTIONS!


    function bulk_action(bulk){

        if(bulk == 1) {

            var message = "Selected entries will be deleted permanently! Click <strong><u>YES</u></strong> to delete entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Delete Vacancy Entries</span>";
            var on_success  = "Entries successfully removed";

        }

        if(bulk == 2) {

            var message = "Selected entries status will be changed to live! Click <strong><u>YES</u></strong> to change entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Change status to live</span>";
            var on_success  = "Entries status successfully changed";

        }

        if(bulk == 3) {

            var message = "Selected entries status will be changed to draft! Click <strong><u>YES</u></strong> to change entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Change status to draft</span>";
            var on_success  = "Entries status successfully changed";

        }

        if(bulk == 4) {

            var message = "Selected entries status will be changed to archive! Click <strong><u>YES</u></strong> to change entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Change status to archive</span>";
            var on_success  = "Entries status successfully changed";

        }

        $.SmartMessageBox({
            title : title,
            content : message,
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                var frm = $('#action_multi_files');

                $.ajax({
                    type: 'post',
                    data: frm.serialize(),
                    url: '<?php echo site_url('/') ?>career/action_vacancy_bulk/'+bulk,
                    success: function(data) {

                        reload_vacancies();


                        $("#action_multi_files")[0].reset();

                    }
                });

                $.smallBox({
                    title : on_success,
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000,
                });



            } else {

                $("#action_multi_files")[0].reset();
            }

        });


        //e.preventDefault();

    }


    $(document).ready(function() {

        $("#bulk").change(function() {

            var bulk = ($(this).val());

            if(bulk != 0) {

                bulk_action(bulk);

            }


        });

        pageSetUp();

            /* BASIC ;*/
            var responsiveHelper_dt_basic = undefined;
            var responsiveHelper_datatable_fixed_column = undefined;
            var responsiveHelper_datatable_col_reorder = undefined;
            var responsiveHelper_datatable_tabletools = undefined;

            var breakpointDefinition = {
                tablet: 1024,
                phone: 480
            };

            $('#dt_basic').dataTable({
                "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                "t" +
                "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                "autoWidth": true,
                "oLanguage": {
                    "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                },
                "preDrawCallback": function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelper_dt_basic) {
                        responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                    }
                },
                "rowCallback": function (nRow) {
                    responsiveHelper_dt_basic.createExpandIcon(nRow);
                },
                "drawCallback": function (oSettings) {
                    responsiveHelper_dt_basic.respond();
                }
            });

            /* END BASIC */

        });


        function reload_vacancies(){

            $.ajax({
                type: 'get',
                url: '<?php echo site_url('/').'career/reload_vacancies_all/' ;?>' ,
                success: function (data) {

                    $('#curr_vac').html(data);
                    /* BASIC ;*/
                    var responsiveHelper_dt_basic = undefined;
                    var responsiveHelper_datatable_fixed_column = undefined;
                    var responsiveHelper_datatable_col_reorder = undefined;
                    var responsiveHelper_datatable_tabletools = undefined;

                    var breakpointDefinition = {
                        tablet: 1024,
                        phone: 480
                    };

                    $('#dt_basic').dataTable({
                        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>" +
                        "t" +
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
                        "autoWidth": true,
                        "oLanguage": {
                            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                        },
                        "preDrawCallback": function () {
                            // Initialize the responsive datatables helper once.
                            if (!responsiveHelper_dt_basic) {
                                responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                            }
                        },
                        "rowCallback": function (nRow) {
                            responsiveHelper_dt_basic.createExpandIcon(nRow);
                        },
                        "drawCallback": function (oSettings) {
                            responsiveHelper_dt_basic.respond();
                        }
                    });

                }
            });
        }

    function delete_vacancy(id, title){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Delete Entry: "+title+"</span>",
            content : "The entry will be deleted permanently! Click <strong><u>YES</u></strong> to Delete File. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    url: "<?php echo site_url('/');?>career/delete_vacancy_do/"+id+"/",
                    success: function(data) {
                        reload_vacancies();
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

    </script>

</body>
</html>