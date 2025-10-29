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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li>Disciplines</li>
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
                    DISCIPLINES
                    <span>&gt;
                        List of all disciplines
                    </span>
                </h1>

                <div class="well">
                    <form name="add-discipline" id="add-discipline" method="post" action="<?php echo site_url('/') ?>career/add_discipline_do" enctype="multipart/form-data">
                        <div class="input-group">
                            <input class="form-control" type="text" name="discipline" id="discipline" placeholder="Discipline Name...">
                            <div class="input-group-btn">
                                <button class="btn btn-default btn-primary" type="submit" id="butt">
                                    <i class="fa fa-plus"></i> Add Discipline
                                </button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>

            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">

            </div>
        </div>

        <!-- Vacancy Table -->
        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="jarviswidget jarviswidget-color-darken" id="wid-id-0" data-widget-editbutton="false">

                    <header>
                        <span class="widget-icon"> <i class="fa fa-table"></i> </span>
                        <h2>All Disciplines Listed</h2>
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
                            <div  id="curr_disc">
                            <?php $this->career_model->get_all_disciplines(); ?>
                            </div>

                                <div class="row-fluid">
                                    <div class="col-md-3 col-lg-3">
                                        <select id="bulk" class="form-control" name="bulk" >
                                            <option value="0">Bulk Actions</option>
                                            <option value="1">Delete Selected</option>
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

    $('#butt').click(function(e) {

        e.preventDefault();
        //Validate
        if($('#discipline').val().length == 0){

            $('#discipline').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Discipline Required", content:"Please supply us with a discipline"});
            $('#discipline').popover('show');
            $('#discipline').focus();


        }else{

            var frm = $('#add-discipline');
            //frm.submit();
            $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/add_discipline_do';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "Entry Uploaded!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $('#result_msg').html(data);
                    $('#butt').html('Add Discipline');
                    reload_disciplines();

                    $("#add-discipline")[0].reset();
                }
            });

        }
    });


    function bulk_action(bulk){

        if(bulk == 1) {

            var message = "Selected entries will be deleted permanently! Click <strong><u>YES</u></strong> to delete entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Delete Discipline Entries</span>";
            var on_success  = "Entries successfully removed";

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
                    url: '<?php echo site_url('/') ?>career/action_discipline_bulk/'+bulk,
                    success: function(data) {

                        reload_disciplines();


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


        function reload_disciplines(){

            $.ajax({
                type: 'get',
                url: '<?php echo site_url('/').'career/reload_disciplines_all/' ;?>' ,
                success: function (data) {

                    $('#curr_disc').html(data);
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

    function delete_discipline(id, title){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Delete Entry: "+title+"</span>",
            content : "The entry will be deleted permanently! Click <strong><u>YES</u></strong> to Delete File. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    url: "<?php echo site_url('/');?>career/delete_discipline_do/"+id+"/",
                    success: function(data) {
                        reload_disciplines();

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