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
                            <a href="<?php echo site_url('/'); ?>member/members/">Members</a><span
                                class="divider">/</span>
                        </li>
                        <li>
                            Add New Member
                        </li>
                    </ul>
                    <hr>
                </div>

                <div class="row-fluid sortable">


                    <div class="box span8">
                        <div class="box-header">
                            <h2><i class="icon-th"></i><span class="break"></span>Add New Member</h2>
                            <div class="box-icon">
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">
                            <p>
                            <form id="member-update" name="member-update" method="post"
                                action="<?php echo site_url('/'); ?>member/add_member_do" class="form-horizontal">
                                <fieldset>
                                    <div class="control-group">
                                        <label class="control-label" for="title">Title</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="title" name="title"
                                                placeholder="Title">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="name">Name</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="name" name="name" placeholder="Name">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="middle_name">Middle Name</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="middle_name" name="middle_name"
                                                placeholder="Middle Name">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="membership_type">Membership Type</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="membership_type" name="membership_type"
                                                placeholder="Membership Type">
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="membership_number">Membership Number</label>
                                        <div class="controls">
                                            <input type="text" class="span6" id="membership_number"
                                                name="membership_number" placeholder="Membership Number">
                                        </div>
                                    </div>

                                    <div id="result_msg"></div>
                                    <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add
                                        Member</button>

                                </fieldset>
                            </form>
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
    <script type="text/javascript">
        /* ---------- Text Editor ---------- */
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

        $('#butt').click(function (e) {


            e.preventDefault();
            //Validate
            if ($('#name').val().length == 0) {

                $('#name').popover({
                    delay: {
                        show: 100,
                        hide: 3000
                    },
                    placement: "top",
                    html: true,
                    trigger: "manual",
                    title: "Title Required",
                    content: "Please supply us with a member title"
                });
                $('#name').popover('show');
                $('#name').focus();

                /*		}else if($('#redactor_content').val() == 0){
                    
                                $('#redactor_content_msg').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Page Body", content:"Please supply us with some page content"});
                                $('#redactor_content_msg').popover('show');
                                $('#redactor_content_msg').focus();		*/

            } else {

                submit_form();

            }
        });


        function submit_form() {

            var frm = $('#member-update');
            //frm.submit();
            $('#butt').html('<img src="<?php echo base_url('/') . 'admin_src/img/loading_white.gif'; ?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/') . 'member/add_member_do'; ?>',
                success: function (data) {

                    $('#result_msg').html(data);
                    $('#butt').html('Add member');

                }
            });

        }
    </script>
</body>

</html>