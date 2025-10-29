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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/panellists">Panellists</a></li><li>Add Pannelist</li>
        </ol>

    </div>
    <!-- END RIBBON -->

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <!-- PAGE HEADER -->
                    <i class="fa-fw fa fa-user"></i>
                    PANELLISTS
                    <span>&gt;
                        Add new Panellist
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
                        <span class="widget-icon"> <i class="fa fa-edit"></i> </span>

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
                            <form id="panallist-add" name="panallist-add" method="post" action="<?php echo site_url('/');?>career/add_panellist_do" class="smart-form">
                                <header>
                                    Panellist Upload Form
                                </header>

                                <fieldset>
                                    <div class="row">
                                        <section class="col col-4">
                                            <label class="label">Name</label>
                                            <label class="input">
                                                <input type="text" id="name" name="name" placeholder="Name" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Surname</label>
                                            <label class="input">
                                                <input type="text" id="surname" name="surname" placeholder="Surname" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Email</label>
                                            <label class="input">
                                                <input type="text" id="email" name="email" placeholder="Email" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Choose Panellist Type</label>
                                            <label class="select">
                                                <select name="type">
                                                    <option value="none">Select Type</option>
                                                    <option value="potentia">Potentia</option>
                                                    <option value="client">Client</option>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">Password</label>
                                            <label class="input">
                                                <input type="password" id="pass" name="pass" placeholder="Password" value="">
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">Password Again</label>
                                            <label class="input">
                                                <input type="password" id="pass2" name="pass2" placeholder="Password Again" value="">
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                                <label class="checkbox">
                                                    <input type="checkbox" name="send_pass" value="Y">
                                                    <i></i>Check to send password to panellist</label>

                                        </section>

                                    </div>

                                </fieldset>

                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPLOAD PANELLIST
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


<script type="text/javascript">


</script>

</body>
</html>