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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/clients">Clients</a></li><li>Masterfiles</li>
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
                    <?php echo $client_name; ?> Masterfiles
                    <span>&gt;
                        List of all files & directories
                    </span>
                </h1>
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
                        <h2>All Directories Listed</h2>
                    </header>

                    <!-- widget div-->
                    <div>

                        <!-- widget edit box -->
                        <div class="jarviswidget-editbox">
                            <!-- This area used as dropdown edit box -->

                        </div>
                        <!-- end widget edit box -->

                        <div class="widget-body no-padding">

                            <div class="widget-body">

                                <div class="col-lg-4">
                                    <div class="tree smart-form" style="margin-bottom:20px">
                                        <ul>
                                            <?php echo $this->career_model->get_master_structure($vac_client_id); ?>
                                        </ul>
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <div style="margin-top:20px" id="master-box">
                                    <?php echo $this->career_model->get_all_masterfiles(); ?>
                                    </div>
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

<div class="modal fade" id="myFiles" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Upload Masterfiles</h4>
            </div>
            <div class="modal-body">

                <form class="dropzone" id="mydropzone">
                    <input type="hidden" name="directory" id="directory"  value="">
                    <input type="hidden" value="<?php echo $this->session->userdata('bus_id'); ?>" name="bus_id">
                    <div class="dz-default dz-message"><span><span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp;&nbsp;<h4 class="display-inline"> (Or Click)</h4></span></span></span></span></div>
                </form>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php $this->load->view('career/inc/footer');?>

<script type='text/javascript' src="<?php echo base_url('/'); ?>admin_src/js/jquery.form.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>
<script src="<?php echo base_url('/'); ?>admin_src/smart/js/plugin/dropzone/dropzone.min.js"></script>


<script type="text/javascript">

    $(document).ready(function() {

        //DROPZONE FILES
        Dropzone.autoDiscover = false;


        $('#mydropzone').dropzone({

            url: '<?php echo NA_URL; ?>vacancy/add_masterfiles',
            addRemoveLinks : true,

            maxFilesize: 5.,
            dictResponseError: 'Error uploading file!',
            init: function() {
                this.on('complete', function() {


                    var id = $('#directory').val()


                    reload_masterfiles(id);


                });
            }
        });




        $( ".spot" ).click(function() {
            var id = $(this).attr("data-id");

            $.ajax({
                type: 'get',
                url: '<?php echo site_url('/').'career/reload_masterfiles/' ;?>'+id ,
                success: function (data) {

                    $('#master-box').html(data);

                    $('#dt_basic').dataTable({

                    });

                    $("#directory").val(id);

                }
            });

        });

        pageSetUp();

        var responsiveHelper_dt_basic = undefined;

        $('#dt_basic').dataTable({

        });

        // PAGE RELATED SCRIPTS

        $('.tree > ul').attr('role', 'tree').find('ul').attr('role', 'group');
        $('.tree').find('li:has(ul)').addClass('parent_li').attr('role', 'treeitem').find(' > span').attr('title', 'Collapse this branch').on('click', function(e) {
            var children = $(this).parent('li.parent_li').find(' > ul > li');
            if (children.is(':visible')) {
                children.hide('fast');
                $(this).attr('title', 'Expand this branch').find(' > i').removeClass().addClass('fa fa-lg fa-plus-circle');
            } else {
                children.show('fast');
                $(this).attr('title', 'Collapse this branch').find(' > i').removeClass().addClass('fa fa-lg fa-minus-circle');
            }
            e.stopPropagation();
        });

    });

    function reload_masterfiles(id){

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/'); ?>career/reload_masterfiles/'+id ,
            success: function (data) {

                $('#master-box').html(data);

                $('#dt_basic').dataTable({

                });

                $('#myFiles').modal('hide');

            }
        });

    }

</script>

</body>
</html>