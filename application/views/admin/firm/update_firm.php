<?php $this->load->view('admin/inc/header'); ?>


<body>

    <?php $this->load->view('admin/inc/nav_top'); ?>

    <div class="container-fluid">
        <div class="row-fluid">
            <?php $this->load->view('admin/inc/nav_main'); ?>
            <div id="content" class="span10">
                <!-- start: Content -->

                <div>
                    <hr>
                    <ul class="breadcrumb">
                        <li>
                            <a href="<?php echo site_url('/'); ?>">Home</a> <span class="divider">/</span>
                        </li>
                        <li>
                            <a href="<?php echo site_url('/'); ?>firm/firms/">Firms</a><span class="divider">/</span>
                        </li>
                        <li>
                            Update Firm: <?php echo $company; ?>
                        </li>
                    </ul>
                    <hr>
                </div>

                <div class="row-fluid sortable">

                    <div class="box span8">
                        <div class="box-header">
                            <h2><i class="icon-th"></i><span class="break"></span> Update firm: <?php echo $company; ?>
                            </h2>
                            <div class="box-icon">
                                <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            <p>
                            <form id="firm-update" name="firm-update" method="post"
                                action="<?php echo site_url('/'); ?>firm/update_firm_do" class="form-horizontal">
                                <fieldset>
                                    <input type="hidden" name="firm_id" value="<?php if (isset($firm_id)) {
                                        echo $firm_id;
                                    } ?>">
                                    <input type="hidden" name="autosave" id="autosave" value="true">
                                    <input type="hidden" name="status" id="status" value="<?php if (isset($status)) {
                                        echo $status;
                                    } ?>">
                                    <div class="control-group">
                                        <label class="control-label" for="company">Company</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="company" name="company"
                                                placeholder="Company Name" value="<?php if (isset($company)) {
                                                    echo $company;
                                                } ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="title">Status</label>
                                        <div class="controls">
                                            <div class="btn-group" data-toggle="buttons-radio">
                                                <button type="button" class="btn btn-primary<?php if ($status == 'draft') {
                                                    echo ' active';
                                                } ?>">Draft</button>
                                                <button type="button" class="btn btn-primary<?php if ($status == 'live') {
                                                    echo ' active';
                                                } ?>">Live</button>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="name">Name</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="name" name="name"
                                                placeholder="Page URL Slug eg: /about-us" value="<?php if (isset($name)) {
                                                    echo $name;
                                                } ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="middle_name">Middle Name</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="middle_name" name="middle_name"
                                                placeholder="Firm Middle Name" value="<?php if (isset($middle_name)) {
                                                    echo $middle_name;
                                                } ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="number_practice">Pracitce Number</label>
                                        <div class="controls">
                                            <input type="number" class="span6" id="number_practice"
                                                name="number_practice" placeholder="Firm Practice Number" value="<?php if (isset($number_practice)) {
                                                    echo $number_practice;
                                                } ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="email">Email:</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="email" name="email"
                                                placeholder="Firm email" value="<?php if (isset($email)) {
                                                    echo $email;
                                                } ?>">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="sequence">Sequence:</label>
                                        <div class="controls">
                                            <input name="sequence" type="text" class="span1" id="sequence" value="<?php if (isset($sequence)) {
                                                echo $sequence;
                                            } ?>" size="3" maxlength="3">
                                            <span class="help-block" style="font-size:11px">Set the sequence of the
                                                firm</span>
                                        </div>
                                    </div>


                                    <div id="result_msg"></div>
                                    <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update
                                        Firm</button>
                                </fieldset>
                            </form>
                            </p>
                        </div>
                    </div>

                    <div class="box span4">
                        <div class="box-header">
                            <h2><i class="icon-th"></i><span class="break"></span>Firm Sidebar</h2>
                            <div class="box-icon">

                            </div>
                        </div>
                        <div class="box-content">
                            <div class="alert">
                                This is the secondary smaller firm column. Please select what component you would
                                like to display.
                            </div>
                            <p>
                                <!--<a href="#" onClick="$('#gallery_cont').slideToggle();" class="btn "><i class="icon-picture"></i> Gallery</a>
                            <a href="#" class="btn "><i class="icon-envelope"></i> Contact Us</a>-->
                            </p>
                        </div>
                    </div>

                    <div class="box span4">
                        <div class="box-header">
                            <h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
                            <div class="box-icon">
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            <p>

                                <?php $this->admin_model->get_featured_image('firm', $firm_id); ?>

                            </p>
                        </div>
                    </div>
                </div>

                <hr>

                <div class="row-fluid"></div>

                <hr>

                <!-- end: Content -->
            </div>
            <!--/#content.span10-->
        </div>
        <!--/fluid-row-->

        <div class="modal hide fade" id="myModal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">×</button>
                <h3>Settings</h3>
            </div>
            <div class="modal-body">
                <p>Here settings can be configured...</p>
            </div>
            <div class="modal-footer">
                <a href="#" class="btn" data-dismiss="modal">Close</a>
                <a href="#" class="btn btn-primary">Save changes</a>
            </div>
        </div>

        <div class="clearfix"></div>

        <?php $this->load->view('admin/inc/footer'); ?>
    </div>
    <!--/.fluid-container-->
    <script type='text/javascript' src="<?php echo base_url('/'); ?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/'); ?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/'); ?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/'); ?>admin_src/redactor/plugins/fontfamily.js"></script>
    <script type='text/javascript' src="<?php echo base_url('/'); ?>admin_src/js/jquery.form.min.js"></script>
    <script type="text/javascript">
        var delay = 100;
        var isLoading = false;
        var isDirty = false;


        $(document).ready(function () {


            $('.redactor_content').redactor({
                fileUpload: '<?php echo site_url('/') ?>my_images/redactor_add_file/',
                imageGetJson: '<?php echo site_url('/') ?>my_images/show_upload_images_json/',
                imageUpload: '<?php echo site_url('/') ?>my_images/redactor_add_image',
                buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|',
                    'unorderedlist', 'orderedlist', 'outdent', 'indent', '|', 'image',
                    'video', 'file', 'table', 'link', '|',
                    'alignment', '|', 'horizontalrule'
                ],
                linebreaks: true,
                focus: true,
                plugins: ['fullscreen', 'fontcolor', 'fontsize', 'fontfamily']
            });



            $('#butt').bind('click', function (e) {


                e.preventDefault();
                //Validate
                if ($('#company').val().length == 0) {

                    $('#company').popover({
                        delay: {
                            show: 100,
                            hide: 3000
                        },
                        placement: "top",
                        html: true,
                        trigger: "manual",
                        title: "Title Required",
                        content: "Please supply us with a firm title"
                    });
                    $('#company').popover('show');
                    $('#company').focus();

                    /*		}else if($('#redactor_content').val() == 0){
                        
                                    $('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
                                    $('#redactor_content_msg').popover('show');
                                    $('#redactor_content_msg').focus();	*/

                } else {

                    submit_form();

                }
            });

            $('div.btn-group button').live('click', function () {

                $('#status').attr('value', $(this).html());
            });


            $('#firm-update :input').change(function () {

                $('#autosave').val('false');
            });
            $('.redactor_box').live('click', function () {

                $('#autosave').val('false');
            });

            //Featured image
            $('#imgbut').bind('click', function () {


                var avataroptions = {
                    target: '#avatar_msg',
                    url: '<?php echo site_url('/') . 'admin/add_featured_image'; ?>',
                    beforeSend: function () {
                        var percentVal = '0%';
                        probar.width(percentVal)
                    },
                    uploadProgress: function (event, position, total, percentComplete) {
                        var percentVal = percentComplete + '%';
                        probar.width(percentVal)

                    },
                    complete: function (xhr) {
                        procover.hide();
                        probar.width('0%');
                        $('#avatar_msg').html(xhr.responseText);
                        $('#imgbut').html('Update Image');
                    }

                };

                var frm = $('#add-img');
                var probar = $('#procover .bar');
                var procover = $('#procover');

                $('#imgbut').html(
                    '<img src="<?php echo base_url('/') . 'admin_src/img/loading_white.gif'; ?>" /> Uploading...'
                );
                procover.show();
                frm.ajaxForm(avataroptions);
                $('#autosave').val('true');
            });

        });



        function submit_form() {

            var frm = $('#firm-update'),
                content = $('#redactor_content').text();

            $('#butt').html('<img src="<?php echo base_url('/') . 'admin_src/img/loading_white.gif'; ?>" /> Working...');
            $.ajax({
                type: 'post',
                //data: frm.serialize()+'&content2='+content,
                data: frm.serialize(),
                url: '<?php echo site_url('/') . 'firm/update_firm_do'; ?>',
                success: function (dataresult) {
                    $('#autosave').val('true');
                    $('#result_msg').html(dataresult);
                    $('#butt').html('Update firm');
                    //$('#test_msg').append(frm.serialize());
                }
            });

        }

        //IE 9 Fix
        function htmlEntities(str) {
            return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        }



        window.onbeforeunload = function () {

            if ($('#autosave').val() == 'false') {
                return 'The firm has not been saved.';

            }

        };
    </script>
</body>

</html>