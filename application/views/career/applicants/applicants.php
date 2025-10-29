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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li>Applicants</li>
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
                    APPLICANTS
                    <span>&gt;
                        List of all applicants
                    </span>
                </h1>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
                <a class="btn btn-primary btn-lg pull-right" href="<?php echo site_url('/') ?>career/add_applicant"><i class="glyphicon glyphicon-plus"></i> ADD APPLICANT</a>
            </div>
        </div>

        <!-- Vacancy Table -->
        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>All Applicants Listed</h2>
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

                            <div  id="curr_app">
                                <?php echo $this->career_model->get_all_applicants(); ?>
                            </div>

                                <div class="row-fluid">
                                    <div class="col-md-3 col-lg-3">
                                        <select id="bulk" class="form-control" name="bulk" >
                                            <option value="0">Bulk Actions</option>
                                            <option value="1">Delete Selected</option>
                                            <option value="2">Change status to active</option>
                                            <option value="3">Change status to draft</option>
                                            <option value="4">Change status to archive</option>
                                            <option value="5">Export to CSV</option>
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

<div class="modal fade" id="mySearch" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Advanced Filter</h4>
            </div>
            <div class="modal-body">
                <form id="filter-form" name="filter_form" class="smart-form" method="post" action="<?php echo site_url('/');?>career/filter_applicants">

                    <div class="row-fluid">

                        <fieldset>
                            <section>
                                <label class="label">Vacancies</label>
                                <label class="select">

                                    <select name="vac_select" id="vac-select">
                                        <option value="0">Select a Vacancy</option>
                                        <?php echo $this->career_model->get_vacancy_filter(); ?>

                                    </select>
                                    <i></i>
                                </label>
                            </section>
                            <section style="display:none" id="lists">
                                <label class="label">List Type</label>
                                <div class="inline-group">
                                    <label class="radio">
                                        <input type="radio" name="list_type" value="longlist">
                                        <i></i>Long List</label>
                                    <label class="radio">
                                        <input type="radio" name="list_type" value="shortlist">
                                        <i></i>Short List</label>
                                    <label class="radio">
                                        <input type="radio" name="list_type" value="none">
                                        <i></i>None</label>

                                </div>
                            </section>
                            <section>
                                <label class="label">Industries</label>
                                <label class="select">

                                    <select name="ind_select">
                                        <option value="0">Select a Industry</option>
                                        <?php echo $this->career_model->get_industry_filter(); ?>

                                    </select>
                                    <i></i>
                                </label>
                            </section>
                            <section>
                                <label class="label">Disciplines</label>
                                <label class="select">

                                    <select name="dis_select">
                                        <option value="0">Select a Discipline</option>
                                        <?php echo $this->career_model->get_disc_filter(); ?>

                                    </select>
                                    <i></i>
                                </label>
                            </section>

                            <section class="col-md-2">

                            </section>
                        </fieldset>


                    </div>
                    <div style="clear: both"></div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="filter-butt" class="btn btn-primary">
                    Filter Results
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('career/inc/footer');?>

<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $( "#vac-select" ).change(function() {
        var val = ($(this).val());

        if(val == '0') { $('#lists').hide(); } else { $('#lists').show(); }
    });


    $('#filter-butt').click(function(e) {

        e.preventDefault();


            var frm = $('#filter-form');
            //frm.submit();
            $('#filter-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/filter_applicants';?>' ,
                success: function (data) {

                    // Apply the filter
                    $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {

                        otable
                            .column( $(this).parent().index()+':visible' )
                            .search( this.value )
                            .draw();

                    } );
                    /* END COLUMN FILTER */

                    /* COLUMN SHOW - HIDE */
                    $('#datatable_col_reorder').dataTable({
                        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
                        "t"+
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                        "autoWidth" : true,
                        "oLanguage": {
                            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                        },
                        "preDrawCallback" : function() {
                            // Initialize the responsive datatables helper once.
                            if (!responsiveHelper_datatable_col_reorder) {
                                responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
                            }
                        },
                        "rowCallback" : function(nRow) {
                            responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
                        },
                        "drawCallback" : function(oSettings) {
                            responsiveHelper_datatable_col_reorder.respond();
                        }
                    });

                    /* END COLUMN SHOW - HIDE */

                    /* TABLETOOLS */
                    $('#datatable_tabletools').dataTable({

                        // Tabletools options:
                        //   https://datatables.net/extensions/tabletools/button_options
                        "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
                        "t"+
                        "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
                        "oLanguage": {
                            "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
                        },
                        "oTableTools": {
                            "aButtons": [
                                "copy",
                                "csv",
                                "xls",
                                {
                                    "sExtends": "pdf",
                                    "sTitle": "SmartAdmin_PDF",
                                    "sPdfMessage": "SmartAdmin PDF Export",
                                    "sPdfSize": "letter"
                                },
                                {
                                    "sExtends": "print",
                                    "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                                }
                            ],
                            "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
                        },
                        "autoWidth" : true,
                        "preDrawCallback" : function() {
                            // Initialize the responsive datatables helper once.
                            if (!responsiveHelper_datatable_tabletools) {
                                responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
                            }
                        },
                        "rowCallback" : function(nRow) {
                            responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
                        },
                        "drawCallback" : function(oSettings) {
                            responsiveHelper_datatable_tabletools.respond();
                        }
                    });


                    $('#curr_app').html(data);


                    $('#filter-butt').html('Filter results');
                    $('#mySearch').modal('hide');

                }
            });


    });


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

        if(bulk == 5) {

            var message = "Selected entries status will be added to a CSV file and will be downloaded! Click <strong><u>YES</u></strong> to change entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Add to CSV and download</span>";
            var on_success  = "Entries added to CSV and is busy downloading";

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
                    url: '<?php echo site_url('/') ?>career/action_applicants_bulk/'+bulk,
                    success: function(data) {

                        reload_applicants();

                        if(bulk == 5) {
                            window.location = "<?php echo site_url('/') ?>career/csv_download";
                        }


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
            tablet : 1024,
            phone : 480
        };

        $('#dt_basic').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-12 hidden-xs'l>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_dt_basic) {
                    responsiveHelper_dt_basic = new ResponsiveDatatablesHelper($('#dt_basic'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_dt_basic.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_dt_basic.respond();
            }
        });

        /* END BASIC */

        /* COLUMN FILTER  */
        var otable = $('#datatable_fixed_column').DataTable({
            //"bFilter": false,
            //"bInfo": false,
            //"bLengthChange": false
            //"bAutoWidth": false,
            //"bPaginate": false,
            //"bStateSave": true // saves sort state using localStorage
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6 hidden-xs'f><'col-sm-6 col-xs-12 hidden-xs'<'toolbar'>>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-xs-12 col-sm-6'p>>",
            "autoWidth" : true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_fixed_column) {
                    responsiveHelper_datatable_fixed_column = new ResponsiveDatatablesHelper($('#datatable_fixed_column'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_datatable_fixed_column.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_fixed_column.respond();
            }

        });



        // Apply the filter
        $("#datatable_fixed_column thead th input[type=text]").on( 'keyup change', function () {

            otable
                .column( $(this).parent().index()+':visible' )
                .search( this.value )
                .draw();

        } );
        /* END COLUMN FILTER */

        /* COLUMN SHOW - HIDE */
        $('#datatable_col_reorder').dataTable({
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'C>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "autoWidth" : true,
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_col_reorder) {
                    responsiveHelper_datatable_col_reorder = new ResponsiveDatatablesHelper($('#datatable_col_reorder'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_datatable_col_reorder.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_col_reorder.respond();
            }
        });

        /* END COLUMN SHOW - HIDE */

        /* TABLETOOLS */
        $('#datatable_tabletools').dataTable({

            // Tabletools options:
            //   https://datatables.net/extensions/tabletools/button_options
            "sDom": "<'dt-toolbar'<'col-xs-12 col-sm-6'f><'col-sm-6 col-xs-6 hidden-xs'T>r>"+
            "t"+
            "<'dt-toolbar-footer'<'col-sm-6 col-xs-12 hidden-xs'i><'col-sm-6 col-xs-12'p>>",
            "oLanguage": {
                "sSearch": '<span class="input-group-addon"><i class="glyphicon glyphicon-search"></i></span>'
            },
            "oTableTools": {
                "aButtons": [
                    "copy",
                    "csv",
                    "xls",
                    {
                        "sExtends": "pdf",
                        "sTitle": "SmartAdmin_PDF",
                        "sPdfMessage": "SmartAdmin PDF Export",
                        "sPdfSize": "letter"
                    },
                    {
                        "sExtends": "print",
                        "sMessage": "Generated by SmartAdmin <i>(press Esc to close)</i>"
                    }
                ],
                "sSwfPath": "js/plugin/datatables/swf/copy_csv_xls_pdf.swf"
            },
            "autoWidth" : true,
            "preDrawCallback" : function() {
                // Initialize the responsive datatables helper once.
                if (!responsiveHelper_datatable_tabletools) {
                    responsiveHelper_datatable_tabletools = new ResponsiveDatatablesHelper($('#datatable_tabletools'), breakpointDefinition);
                }
            },
            "rowCallback" : function(nRow) {
                responsiveHelper_datatable_tabletools.createExpandIcon(nRow);
            },
            "drawCallback" : function(oSettings) {
                responsiveHelper_datatable_tabletools.respond();
            }
        });

        });


        function reload_applicants(){

            $.ajax({
                type: 'get',
                url: '<?php echo site_url('/').'career/reload_applicants_all/' ;?>' ,
                success: function (data) {

                    $('#curr_app').html(data);
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

    function delete_applicant(id, title){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Delete Entry: "+title+"</span>",
            content : "The entry will be deleted permanently! Click <strong><u>YES</u></strong> to Delete File. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    url: "<?php echo site_url('/');?>career/delete_applicant_do/"+id+"/",
                    success: function(data) {
                        reload_applicants();
                        $("#ta").prop("checked", false);
                    }
                });

                $.smallBox({
                    title : "Entry: "+title+" Deleted!",
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated"
                });
            }

        });
        //e.preventDefault();

    }

    </script>

</body>
</html>