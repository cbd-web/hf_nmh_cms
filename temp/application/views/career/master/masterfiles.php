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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li>Masterfiles</li>
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
                    Masterfiles
                    <span>&gt;
                        List of all directories
                    </span>
                </h1>
            </div>

            <div class="col-xs-12 col-sm-5 col-md-5 col-lg-8">
                <a class="btn btn-primary btn-lg pull-right" href="<?php echo site_url('/') ?>career/add_vacancy"><i class="glyphicon glyphicon-plus"></i> ADD NEW DIRECTORY</a>
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

                                <div class="tree smart-form">
                                    <ul>
                                        <?php echo $this->career_model->get_master_structure(); ?>

                                    </ul>
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



<?php $this->load->view('career/inc/footer');?>

<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/jquery.dataTables.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.colVis.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.tableTools.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatables/dataTables.bootstrap.min.js"></script>
<script src="<?php echo base_url('/');?>admin_src/smart/js/plugin/datatable-responsive/datatables.responsive.min.js"></script>

<script type="text/javascript">

    // DO NOT REMOVE : GLOBAL FUNCTIONS!

    $(document).ready(function() {

        pageSetUp();

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

    })

</script>

</body>
</html>