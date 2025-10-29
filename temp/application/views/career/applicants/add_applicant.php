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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/applicants">Applicants</a></li><li>Add Applicant</li>
        </ol>

    </div>
    <!-- END RIBBON -->

    <!-- MAIN CONTENT -->
    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <!-- PAGE HEADER -->
                    <i class="fa-fw fa fa-users"></i>
                    Applicants
                    <span>&gt;
                        Add new Applicant
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
                        <h2>Applicant Upload Form</h2>

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
                            <form id="applicant-add" name="applicant-add" method="post" action="<?php echo site_url('/');?>career/add_applicant_do" class="smart-form">
                                <header>
                                    Applicant Upload Form
                                </header>

                                <fieldset>
                                    <div class="row">
                                        <section class="col col-4">
                                            <label class="label">First Name</label>
                                            <label class="input">
                                                <input type="text" id="fname" name="fname" placeholder="First Name" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Middle Name</label>
                                            <label class="input">
                                                <input type="text" id="mname" name="mname" placeholder="Middle Name" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Last Name</label>
                                            <label class="input">
                                                <input type="text" id="lname" name="lname" placeholder="Last Name" value="">
                                            </label>
                                        </section>
                                    </div>

                                    <div class="row">
                                        <section class="col col-4">
                                            <label class="label">Date of Birth</label>
                                            <label class="input">
                                                <i class="icon-append fa fa-calendar"></i>
                                                <input type="text" value="<?php echo date('d.m.Y'); ?>" data-dateformat="dd.mm.yyyy" name="dob" id="datepicker">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Age</label>
                                            <label class="input">
                                                <input type="text" id="age" name="age" placeholder="Age" value="">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Gender</label>
                                            <label class="select">
                                                <select name="gender">
                                                    <option value="">Select Gender</option>
                                                    <option value="F">Female</option>
                                                    <option value="M">Male</option>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>
                                    </div>

                                    <div class="row">

                                        <section class="col col-4">
                                            <label class="label">Nationality</label>
                                            <label class="input">
                                                <input type="text" id="nationality" name="nationality" placeholder="Nationality" value="">
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">Ethnicity</label>
                                            <label class="select">
                                                <select name="ethnic">
                                                    <option value="">Select Ethicity</option>
                                                    <option value="Black">Black</option>
                                                    <option value="White">White</option>
                                                    <option value="White">Colored</option>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">Marital Status</label>
                                            <label class="select">
                                                <select name="marital">
                                                    <option value="">Select Marital Status</option>
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                    <option value="Seperated">Seperated</option>
                                                    <option value="Divorced">Divorced</option>
                                                    <option value="Widowed">Widowed</option>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>

                                    </div>

                                </fieldset>

                                    <fieldset>
                                    <div class="row">

                                        <section class="col col-3">
                                            <label class="label">Current Job Title</label>
                                            <label class="input">
                                                <input type="text" id="job_title" name="job_title" placeholder="Job Title" value="">
                                            </label>
                                        </section>

                                        <section class="col col-3">
                                            <label class="label">Highest Qualification</label>
                                            <label class="input">
                                                <input type="text" id="qualify" name="qualify" placeholder="Highest Qualification" value="">
                                            </label>
                                        </section>

                                        <section class="col col-3">
                                            <label class="label">Current Salary</label>
                                            <label class="input">
                                                <input type="text" id="c_salary" name="c_salary" placeholder="Current Salary" value="">
                                            </label>
                                        </section>

                                        <section class="col col-3">
                                            <label class="label">Expected Salary</label>
                                            <label class="input">
                                                <input type="text" id="e_salary" name="e_salary" placeholder="Expected Salary" value="">
                                            </label>
                                        </section>

                                    </div>
                                    </fieldset>

                                    <fieldset>
                                    <div class="row">

                                        <section class="col col-4">
                                            <label class="label">Telephone Number</label>
                                            <label class="input">
                                                <input type="text" id="tel" name="tel" placeholder="Telephone Number" value="">
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">Cellphone Number</label>
                                            <label class="input">
                                                <input type="text" id="cell" name="cell" placeholder="Cellphone Number" value="">
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">Email</label>
                                            <label class="input">
                                                <input type="text" id="email" name="email" placeholder="Email" value="">
                                            </label>
                                        </section>

                                    </div>

                                    <div class="row">

                                        <section class="col col-4">
                                            <label class="label">Country</label>
                                            <label class="select">
                                                <select name="country">
                                                    <option value="">Select Country</option>
                                                    <?php echo $this->career_model->get_country_select(); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">Region</label>
                                            <label class="select">
                                                <select name="region">
                                                    <option value="">Select Region</option>
                                                    <?php echo $this->career_model->get_region_select(); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>

                                        <section class="col col-4">
                                            <label class="label">City</label>
                                            <label class="select">
                                                <select name="city">
                                                    <option value="">Select City</option>
                                                    <?php echo $this->career_model->get_city_select(); ?>
                                                </select>
                                                <i></i>
                                            </label>
                                        </section>


                                    </div>

                                        <div class="row">
                                            <section class="col col-6">
                                                <label class="label">Physical Address</label>
                                                <label class="textarea">
                                                    <textarea class="form-control" rows="4" name="physical"></textarea>
                                                </label>
                                            </section>
                                            <section class="col col-6">
                                                <label class="label">Postal Address</label>
                                                <label class="textarea">
                                                    <textarea class="form-control" rows="4" name="postal"></textarea>
                                                </label>

                                            </section>
                                            <section class="col col-4">
                                                <label class="label">Level</label>
                                                <label class="select">
                                                    <select name="level">
                                                        <option value="basic">Select a Level</option>
                                                        <option value="junior">Junior management</option>
                                                        <option value="admin">Admin level</option>
                                                        <option value="executive">Executive</option>
                                                    </select>
                                                    <i></i>
                                                </label>
                                            </section>
                                        </div>


                                </fieldset>

                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPLOAD APPLICANT
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


    $('#butt').click(function(e) {

        e.preventDefault();
        //Validate
        if($('#email').val().length == 0){

            $('#email').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Email Required", content:"Please supply us with a email"});
            $('#email').popover('show');
            $('#email').focus();


        }else{

            var frm = $('#applicant-add');
            //frm.submit();
            $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/add_applicant_do';?>' ,
                success: function (data) {

                    if (data == 'email_exists') {

                        $.smallBox({
                            title: "User with this email already exists!",
                            content: "Operation Fail",
                            color: "#c26565",
                            iconSmall: "fa fa-check fa-2x fadeInRight animated",
                            timeout: 4000
                        });

                     } else if( data == 'error') {

                        $.smallBox({
                            title: "There was an error uploading!",
                            content: "Operation Fail",
                            color: "#c26565",
                            iconSmall: "fa fa-check fa-2x fadeInRight animated",
                            timeout: 4000
                        });

                     } else {

                        window.location.href = "<?php echo site_url('/').'career/update_applicant/'; ?>"+data;

                     }


                    $('#butt').html('Upload Applicant');

                }
            });

        }
    });


    </script>

</body>
</html>