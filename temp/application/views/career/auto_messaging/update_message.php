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
            <li>Home</li><li>Manage Automated Messages</li>
        </ol>

    </div>
    <!-- END RIBBON -->

    <div id="content">

        <div class="row">
            <div class="col-xs-12 col-sm-7 col-md-7 col-lg-4">
                <h1 class="page-title txt-color-blueDark">
                    <!-- PAGE HEADER -->
                    <i class="fa-fw fa fa-envelope"></i>
                    Manage Automated Message
                        <span>&gt;
                            <?php echo $title; ?>
                        </span>
                </h1>
            </div>

        </div>

        <!-- MAIN CONTENT -->
        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable" style="margin-bottom:50px">


            <div class="jarviswidget" id="wid-id-0" role="widget">

                <header role="heading">
                    <h2><strong>Manage</strong> <i><?php echo $title; ?></i> - Email Message</h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                </header>

                <!-- widget div-->
                <div role="content">

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">
                        <form id="msg-update" name="msg-update" method="post" action="<?php echo site_url('/');?>career/update_message_do" class="smart-form">
                            <input type="hidden" name="msg_id" value="<?php echo $msg_id; ?>">

                            <section>
                                <label class="label">Subject</label>
                                <label class="input">
                                    <input type="text" id="subject" name="subject" placeholder="Message Subject" value="<?php if(isset($subject)){echo $subject;} ?>">
                                </label>
                            </section>

                            <section>
                                <label class="label">Message Body</label>
                                <label class="textarea">
                                    <textarea id="redactor_content" class="redactor_content" rows="4" name="body"><?php if(isset($msg_body)){echo $msg_body;} ?></textarea> </label>
                                <div class="note">

                                </div>
                            </section>

                            <footer>
                                <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                    UPDATE MESSAGE
                                </button>
                            </footer>
                        </form>
                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>


            <div class="jarviswidget" id="wid-id-0" role="widget">

                <header role="heading">
                    <h2><strong>Manage</strong> <i><?php echo $title; ?></i> - SMS Message</h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                </header>

                <!-- widget div-->
                <div role="content">

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">
                        <form id="sms-update" name="sms-update" method="post" action="<?php echo site_url('/');?>career/update_sms_do" class="smart-form">
                            <input type="hidden" name="msg_id" value="<?php echo $msg_id; ?>">

                            <section>
                                <label class="label">Message Body</label>
                                <label class="textarea">
                                    <textarea rows="4" name="sms_body"><?php if(isset($sms_body)){echo $sms_body;} ?></textarea> </label>
                                <div class="note">

                                </div>
                            </section>

                            <footer>
                                <button type="submit" name="submit" class="btn btn-primary pull-left" id="sms-butt">
                                    UPDATE MESSAGE
                                </button>
                            </footer>
                        </form>
                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>


        </article>


        <article class="col-xs-12 col-sm-6 col-md-6 col-lg-6 sortable-grid ui-sortable" style="margin-bottom:50px">


            <div class="jarviswidget" id="wid-id-0" role="widget">

                <header role="heading">
                    <h2><strong>Merge</strong> <i>Tags</i></h2>

                    <span class="jarviswidget-loader"><i class="fa fa-refresh fa-spin"></i></span>
                </header>

                <!-- widget div-->
                <div role="content">

                    <!-- widget edit box -->
                    <div class="jarviswidget-editbox">

                    </div>
                    <!-- end widget edit box -->

                    <!-- widget content -->
                    <div class="widget-body">
                        <div class="row-fluid">
                            <blockquote>
                                <p>*|POSITION|*</p>
                                <small>This tag identifies the Career Position</small>
                            </blockquote>

                            <blockquote>
                                <p>*|CLIENT|*</p>
                                <small>This tag identifies the Client assigned to Vacancy</small>
                            </blockquote>

                            <blockquote>
                                <p>*|INTERVIEW_TOPIC|*</p>
                                <small>This tag identifies the Topic of the interview</small>
                            </blockquote>

                            <blockquote>
                                <p>*|INTERVIEW_VENUE|*</p>
                                <small>This tag identifies the Venue where the interview will take place</small>
                            </blockquote>

                            <blockquote>
                                <p>*|INTERVIEW_DATE|*</p>
                                <small>This tag identifies the Date when the interview will take place</small>
                            </blockquote>

                            <blockquote>
                                <p>*|INTERVIEW_TIME|*</p>
                                <small>This tag identifies the Time when the interview will take place</small>
                            </blockquote>

                            <blockquote>
                                <p>*|DELIVER_DATE|*</p>
                                <small>This tag identifies the Delivery Date for the Assessment Email Pack</small>
                            </blockquote>

                            <blockquote>
                                <p>*|ASSESS_VENUE|*</p>
                                <small>This tag identifies the Venue where the Assessment will take place</small>
                            </blockquote>

                            <blockquote>
                                <p>*|ASSESS_DATE|*</p>
                                <small>This tag identifies the Date when the Assessment will take place</small>
                            </blockquote>

                        </div>
                    </div>
                    <!-- end widget content -->

                </div>
                <!-- end widget div -->

            </div>



        </article>

        <!-- END MAIN CONTENT -->
    </div>

</div>
<!-- END MAIN PANEL -->

<?php $this->load->view('career/inc/footer');?>

<script type='text/javascript' src="<?php echo base_url('/'); ?>admin_src/js/jquery.form.min.js"></script>

<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>

<script>

    $(document).ready(function() {

        /* ---------- Text Editor ---------- */
        $('.redactor_content').redactor({
            buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
                'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image',
                'video', 'file', 'table', 'link', '|',
                'alignment', '|', 'horizontalrule'],
            linebreaks: true,
            focus: true,
            plugins: ['fullscreen', 'fontcolor', 'fontsize', 'fontfamily']
        });

        pageSetUp();

        $('#butt').click(function(e) {

            e.preventDefault();
            //Validate
            if($('#subject').val().length == 0){

                $('#subject').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Subject Required", content:"Please supply us with a message subject"});
                $('#subject').popover('show');
                $('#subject').focus();

            }else{

                var frm = $('#msg-update');
                //frm.submit();
                $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
                $.ajax({
                    type: 'post',
                    data: frm.serialize(),
                    url: '<?php echo site_url('/').'career/update_message_do';?>' ,
                    success: function (data) {

                        $.smallBox({
                            title : "Message Updated!",
                            content : "Operation Success",
                            color : "#659265",
                            iconSmall : "fa fa-check fa-2x fadeInRight animated"
                        });

                        $('#butt').html('Update Message');

                    }
                });

            }
        });

        $('#sms-butt').click(function(e) {

            e.preventDefault();
            //Validate


            var frm = $('#sms-update');
            //frm.submit();
            $('#sms-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/update_sms_do';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "SMS Message Updated!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated"
                    });

                    $('#sms-butt').html('Update Message');

                }
            });

        });

    });


</script>

</body>
</html>