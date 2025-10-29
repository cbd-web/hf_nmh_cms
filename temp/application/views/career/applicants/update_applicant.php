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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/applicants">Applicants</a></li><li>Update Applicant</li>
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
                    APPLICANTS
                    <span>&gt;
                        Update Applicant: <strong><?php if(isset($CLIENT_NAME)) { echo $CLIENT_NAME.' '.$CLIENT_SURNAME; } ?></strong>
                    </span>
                </h1>
            </div>

        </div>

        <!-- Vacancy Table -->
        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="well well-sm">

                    <div class="row">

                        <div class="col-sm-12 col-md-12 col-lg-6">
                            <div class="well well-light well-sm no-margin no-padding">

                                <div class="row">


                                    <div class="col-sm-12">

                                        <div class="row">

                                            <div class="col-sm-3 profile-pic">
                                                <?php echo $this->career_model->get_applicant_avatar($ID); ?>
                                            </div>

                                            <div class="col-sm-6">
                                                <h1><?php echo $CLIENT_NAME; ?> <span class="semi-bold"><?php echo $CLIENT_SURNAME; ?></span>
                                                    <br>
                                                    <small><?php echo $job_title; ?></small></h1>

                                                <ul class="list-unstyled">
                                                    <li>
                                                        <p class="text-muted"><strong>Current Salary:</strong> <?php echo $current_tcc; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Expected Salary:</strong> <?php echo $expected_tcc; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Qualification:</strong> <?php echo $qualification; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Nationality:</strong> <?php echo $nationality; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Country:</strong> <?php echo $country; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Region:</strong> <?php echo $region; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>City:</strong> <?php echo $city; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Marital Status:</strong> <?php echo $marital_status; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Gender:</strong> <?php echo $CLIENT_GENDER; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Date of Birth:</strong> <?php echo $CLIENT_DATE_OF_BIRTH; ?> | <strong>Age:</strong> <?php echo $age; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Ethnicity:</strong> <?php echo $ethnic; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted"><strong>Drivers License:</strong> <?php echo $drivers; ?></p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted">
                                                            <i class="fa fa-phone"></i>&nbsp;&nbsp;<?php echo $CLIENT_TELEPHONE; ?></span>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted">
                                                            <i class="fa fa-mobile"></i>&nbsp;&nbsp;<?php echo $CLIENT_CELLPHONE; ?></span>
                                                        </p>
                                                    </li>
                                                    <li>
                                                        <p class="text-muted">
                                                            <i class="fa fa-envelope"></i>&nbsp;&nbsp;<a href="mailto:<?php echo $CLIENT_EMAIL; ?>"><?php echo $CLIENT_EMAIL; ?></a>
                                                        </p>
                                                    </li>

                                                </ul>
                                                <br>
                                                <p class="font-md">
                                                    <i>A little about me...</i>
                                                </p>
                                                <p>

                                                    <?php echo $biography; ?>

                                                </p>
                                                <br>

                                            </div>


                                        </div>

                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-sm-12">

                                        <hr>

                                        <div class="padding-10">

                                            <ul class="nav nav-tabs tabs-pull-left">
                                                <li class="active">
                                                    <a href="#a1" data-toggle="tab">Education</a>
                                                </li>
                                                <li>
                                                    <a href="#a2" data-toggle="tab">Experience</a>
                                                </li>
                                                <li>
                                                    <a href="#a3" data-toggle="tab">Achievements</a>
                                                </li>
                                                <li>
                                                    <a href="#a4" data-toggle="tab">Employment</a>
                                                </li>
                                                <li>
                                                    <a href="#a5" data-toggle="tab">Languages</a>
                                                </li>
                                                <li>
                                                    <a href="#a6" data-toggle="tab">References</a>
                                                </li>
                                            </ul>

                                            <div class="tab-content padding-top-10">
                                                <div class="tab-pane fade in active" id="a1">

                                                    <div class="row-fluid">
                                                        <h4>Secondary Education</h4>
                                                            <pre style="padding:0px">
                                                            <table class="table table-striped table-responsive" style="margin:0px">
                                                                <thead>
                                                                <tr>
                                                                    <th>Name of School</th>
                                                                    <th>Duration</th>
                                                                    <th>Highest Grade Passed</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php echo $this->career_model->get_education('secondary', $ID); ?>
                                                                </tbody>
                                                            </table>
                                                            </pre>
                                                                        </div>

                                                                        <div class="row-fluid">
                                                                            <h4>Tertiary Education</h4>
                                                            <pre style="padding:0px">
                                                            <table class="table table-striped table-responsive" style="margin:0px">
                                                                <thead>
                                                                <tr>
                                                                    <th>Name of Institution</th>
                                                                    <th>Field of Study</th>
                                                                    <th>Duration</th>
                                                                    <th>Highest Qualification</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php echo $this->career_model->get_education('tertiary', $ID); ?>
                                                                </tbody>
                                                            </table>
                                                            </pre>
                                                                        </div>
                                                                        <div class="row-fluid">
                                                                            <h4>Courses</h4>
                                                            <pre style="padding:0px">
                                                            <table class="table table-striped table-responsive" style="margin:0px">
                                                                <thead>
                                                                <tr>
                                                                    <th>Name of Course</th>
                                                                    <th>Duration</th>
                                                                    <th>Institution</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                <?php echo $this->career_model->get_education('course', $ID); ?>
                                                                </tbody>
                                                            </table>
                                                            </pre>
                                                    </div>

                                                </div>
                                                <div class="tab-pane fade" id="a2">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <h2><strong>Disciplines</strong></h2>
                                                        <?php $this->career_model->get_app_disciplines($ID); ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <h2><strong>Industries</strong></h2>
                                                        <?php $this->career_model->get_app_industries($ID); ?>
                                                        </div>
                                                    </div>
                                                    <hr>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                        <h2><strong>Skills</strong></h2>
                                                        <?php $this->career_model->get_app_skills($ID); ?>
                                                            </div>
                                                    </div>

                                                </div><!-- end tab -->

                                                <div class="tab-pane fade" id="a3">
                                                    <pre style="padding:0px">
                                                    <table class="table table-striped table-responsive" style="margin:0px">
                                                        <thead>
                                                        <tr>
                                                            <th>Achievement</th>
                                                            <th>Organisation</th>
                                                            <th>Receive date</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php echo $this->career_model->get_achievements($ID); ?>
                                                        </tbody>
                                                    </table>
                                                    </pre>
                                                </div><!-- end tab -->

                                                <div class="tab-pane fade" id="a4">
                                                    <pre style="padding:0px">
                                                    <table class="table table-striped table-responsive" style="margin:0px">
                                                        <thead>
                                                        <tr>
                                                            <th>Company</th>
                                                            <th>Position</th>
                                                            <th>Industry Type</th>
                                                            <th>Job level</th>
                                                            <th>Job Type</th>
                                                            <th>Salary Type</th>
                                                            <th>Salary</th>
                                                            <th>Frequency</th>
                                                            <th>Benefits</th>
                                                            <th>Duration</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php echo $this->career_model->get_employments($ID); ?>
                                                        </tbody>
                                                    </table>
                                                    </pre>
                                                </div><!-- end tab -->

                                                <div class="tab-pane fade" id="a5">
                                                    <pre style="padding:0px">
                                                    <table class="table table-striped table-responsive" style="margin:0px">
                                                        <thead>
                                                        <tr>
                                                            <th>Language</th>
                                                            <th>Read</th>
                                                            <th>Write</th>
                                                            <th>Speak</th>
                                                            <th>First Language</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php echo $this->career_model->get_languages($ID); ?>
                                                        </tbody>
                                                    </table>
                                                    </pre>
                                                </div><!-- end tab -->

                                                <div class="tab-pane fade" id="a6">
                                                    <pre style="padding:0px">
                                                    <table class="table table-striped table-responsive" style="margin:0px">
                                                        <thead>
                                                        <tr>
                                                            <th>Name</th>
                                                            <th>Organisation</th>
                                                            <th>Contact Number</th>
                                                            <th>Contact Email</th>
                                                            <th></th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php echo $this->career_model->get_references($ID); ?>
                                                        </tbody>
                                                    </table>
                                                    </pre>
                                                </div><!-- end tab -->
                                            </div>

                                        </div>

                                    </div>

                                </div>


                                <div class="well" style="background-color: #fff">
                                    <h2>Manage Password</h2>
                                    <form action="<?php echo site_url('/');?>vacancy/reset_profile_password" method="post" id="update-password" class="smart-form client-form">
                                        <input name="email" type="hidden" value="<?php echo $CLIENT_EMAIL; ?>">
                                        <input name="app_id" type="hidden" value="<?php echo $applicant_id; ?>">
                                        <fieldset>
                                            <div class="row">
                                                <section class="col col-4">
                                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                        <input type="password" name="pass" placeholder="Password" id="pass">
                                                </section>

                                                <section class="col col-4">
                                                    <label class="input"> <i class="icon-append fa fa-lock"></i>
                                                        <input type="password" name="pass2" placeholder="Confirm password" id="pass2">
                                                </section>

                                                <section class="col col-4">
                                                    <button type="submit" class="btn btn-primary btn-sm" id="pass-butt">
                                                        Reset Password
                                                    </button>
                                                </section>
                                            </div>
                                        </fieldset>
                                    </form>
                                </div>
                                <!-- end row -->

                            </div>

                        </div>


                        <div class="col-sm-12 col-md-12 col-lg-6">

                            <div class="well" style="background-color: #fff">
                                <a href="<?php echo NA_URL.'vacancy/get_applicant_dump/'.$ID; ?>" title="Download CV File" rel="tooltip" style="cursor:pointer"><span class="btn btn-mini btn-info"><i class="glyphicon glyphicon-download-alt"></i> DOWNLOAD CAREER BUNDLE</span></a>
                                <h2>Manage Documents</h2>
                                <p>Drop files into the box below to upload them to the system. </p>
                                <div class="widget-body">
                                    <form class="dropzone" id="mydropzone">
                                        <input type="hidden" value="<?php echo $client_id; ?>" name="client_id">
                                        <input type="hidden" value="basic" name="level">
                                        <div class="dz-default dz-message"><span><span class="text-center"><span class="font-lg visible-xs-block visible-sm-block visible-lg-block"><span class="font-lg"><i class="fa fa-caret-right text-danger"></i> Drop files <span class="font-xs">to upload</span></span><span>&nbsp;&nbsp;<h4 class="display-inline"> (Or Click)</h4></span></span></span></span></div>
                                    </form>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <form action="<?php echo NA_URL; ?>vacancy/add_applicant_docs" method="post" id="action_multi_files" class="form">
                                                <input type="hidden" value="<?php echo $client_id; ?>" name="client_id">
                                                <div id="curr_docs">
                                                    <?php echo $this->career_model->get_applicant_docs($ID); ?>
                                                </div>
                                                <!--<select id="bulk" class="form-control" name="bulk" >
                                                    <option value="0">Bulk Actions</option>
                                                    <option value="1">Delete Selected</option>
                                                    <option value="2">Zip and Download Selected</option>
                                                </select>-->
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!--<form method="post" class="well padding-bottom-10" id="message-form">
                                <input type="hidden" name="sender_id" value="<?php //echo $this->session->userdata('admin_id'); ?>">
                                <input type="hidden" name="receiver_id" value="<?php //echo $ID; ?>">
                                <input type="hidden" name="sender_name" value="<?php //echo $this->session->userdata('full_name'); ?>">
                                <textarea rows="2" placeholder="Type your message here" id="message" name="message" class="form-control"></textarea>
                                <div class="margin-top-10">
                                    <button type="submit" class="btn btn-sm btn-primary" id="message-butt">
                                        Post
                                    </button>
                                    <!--<a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Location"><i class="fa fa-location-arrow"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Voice"><i class="fa fa-microphone"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add Photo"><i class="fa fa-camera"></i></a>
                                    <a href="javascript:void(0);" class="btn btn-link profile-link-btn" rel="tooltip" data-placement="bottom" title="" data-original-title="Add File"><i class="fa fa-file"></i></a>
                                </div>
                            </form>

                        <div id="curr_messages"> <?php //echo $this->career_model->get_app_messages($ID); ?></div>-->


                        </div>


                    </div>

                </div>



            </article>

        </div>

        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

            </article>

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

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

<script src="<?php echo base_url('/'); ?>admin_src/smart/js/plugin/dropzone/dropzone.min.js"></script>


<script type="text/javascript">


    Dropzone.autoDiscover = false;

    $("#mydropzone").dropzone({

        url: "<?php echo NA_URL.'vacancy/add_applicant_docs'; ?>",
        addRemoveLinks : true,

        maxFilesize: 5.,
        dictResponseError: 'Error uploading file!',
        init: function() {
            this.on("complete", function() {

                reload_documents();
                $("#ta").prop("checked", false);

            });
        }
    });

    $( ".replia" ).click(function() {

        var message_id = $(this).attr("data-id");
        var receive_id = $(this).attr("data-rec-id");
        var text = $('#reply_message_'+message_id).val();

        $.ajax({
            type: 'post',

            url: '<?php echo site_url('/').'career/post_app_reply';?>' ,
            data: {
                sender_name: 'Christian Botha',
                sender_id: '1',
                message_id: message_id,
                receiver_id: receive_id,
                message: text
            },
            success: function (data) {

                $.smallBox({
                    title : "Reply Message Posted!",
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });

                reload_messages();

                $('#reply-butt-'+message_id).html('<i class="fa fa-reply"></i> Reply');

            }
        });


    });

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


    $('#pass-butt').bind('click',function(e) {

        e.preventDefault();

        var frm = $('#update-password');
        var val = '';

        $('#pass-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');


        var pass = $('#pass').val();
        var pass2 = $('#pass2').val();

        if(pass) {
            if(pass2){
                if(pass == pass2) {
                    val = 'true';
                } else {
                    val = 'false';
                }
            } else {
                val = 'false';
            }

        } else {
            val = 'false';
        }


        if(val == 'true') {


            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'vacancy/reset_profile_password'; ?>',
                success: function (dataresult) {

                    $('#pass-butt').html('Reset Password');


                    $.smallBox({
                        title: "Operation Success",
                        content: "Password Updated!",
                        color: "#659265",
                        iconSmall: "fa fa-check fa-2x fadeInRight animated",
                        timeout: 4000
                    });



                }
            });

        } else {

            $('#pass-butt').html('Reset Password');

            $.smallBox({
                title: "Operation Failed",
                content: "Please try again!",
                color: "#C46A69",
                iconSmall: "fa fa-check fa-2x fadeInRight animated",
                timeout: 4000
            });

        }

    });


    $(document).ready(function() {

        /* ---------- Text Editor ---------- */
        $('.redactor_content').redactor({
            fileUpload: '<?php echo site_url('/')?>my_images/redactor_add_file/',
            imageGetJson: '<?php echo site_url('/')?>my_images/show_upload_images_json/',
            imageUpload: '<?php echo site_url('/')?>my_images/redactor_add_image',
            buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
                'unorderedlist', 'orderedlist', 'outdent', 'indent',
                'video', 'table', 'link','|',
                'alignment', '|', 'horizontalrule'],
            linebreaks: true,
            focus:true,
            plugins: ['fullscreen', 'fontcolor', 'fontsize','fontfamily']
        });

        pageSetUp();


    });

    $('#message-butt').click(function(e) {

        e.preventDefault();
        //Validate
        if($('#message').val().length == 0){

            $('#message').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Message Required", content:"Please supply us with a message"});
            $('#message').popover('show');
            $('#message').focus();


        }else{

            var frm = $('#message-form');
            //frm.submit();
            $('#message-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/post_app_message';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "Message Posted!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $("#message-form")[0].reset();

                    $('#result_msg').html(data);
                    $('#message-butt').html('Post');

                    reload_messages();

                }
            });

        }
    });


    // START FEATURE SUBMIT
    $('#imgbut').bind('click', function(e) {

        //e.preventDefault();

        var avataroptions = {
            target:        '#feature_msg',
            url:       	   '<?php echo site_url('/').'career/add_featured_image'; ?>' ,
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


    function reload_messages(){

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'career/reload_applicant_messages/'.$ID; ?>' ,
            success: function (data) {

                $('#curr_messages').html(data);

            }
        });
    }

    function delete_document(id, title){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Delete File: "+title+"</span>",
            content : "The file will be deleted permanently! Click <strong><u>YES</u></strong> to Delete File. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    type: 'get',
                    url: "<?php echo NA_URL; ?>vacancy/delete_applicant_document_do/"+id+"/",
                    success: function(data) {

                        reload_documents();

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

    function reload_documents(){

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'career/reload_applicant_documents/'.$ID.'/'; ?>',
            success: function (data) {

                $('#curr_docs').html(data);

            }
        });
    }



    </script>

</body>
</html>