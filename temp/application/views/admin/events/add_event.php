<?php $this->load->view('admin/inc/header');?>
<link href="<?php echo base_url('/');?>admin_src/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<body>

<?php $this->load->view('admin/inc/nav_top');?>

<div class="container-fluid">
    <div class="row-fluid">
        <?php $this->load->view('admin/inc/nav_main');?>
        <div id="content" class="span10">
            <!-- start: Content -->

            <div>
                <hr>
                <ul class="breadcrumb">
                    <li>
                        <a href="<?php echo site_url('/');?>">Home</a> <span class="divider">/</span>
                    </li>
                    <li>
                        <a href="<?php echo site_url('/');?>event/events/">Events</a><span class="divider">/</span>
                    </li>
                    <li>
                        Add New Event
                    </li>
                </ul>
                <hr>
            </div>

            <div class="row-fluid sortable">


                <div class="box span8">
                    <div class="box-header">
                        <h2><i class="icon-th"></i><span class="break"></span>Add New Event</h2>
                        <div class="box-icon">
                            <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <p>
                        <form id="event-add" name="event-add" method="post" action="<?php echo site_url('/');?>calendar/add_event_do" class="form-horizontal">
                            <fieldset>

                                <div class="control-group">
                                    <label class="control-label" for="title">Title</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="title" name="title" placeholder="Event title" value="">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="heading">Heading</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="heading" name="heading" placeholder="Event heading" value="">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="type">Type</label>
                                    <div class="controls">
                                        <select name="type">
                                            <option value="public">Public</option>
                                            <option value="internal">Private</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Duration</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="duration" name="duration" placeholder="Event Duration" value="">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Contact Details</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="contact" name="contact" placeholder="Contact Details" value="">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Location</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="location" name="location" placeholder="Location" value="">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Venue</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="venue" name="venue" placeholder="Venue" value="">
                                    </div>
                                </div>

                                <div class="control-group" id="redactor_content_msg">
                                    <label class="control-label" for="redactor_content">Event Body:</label>
                                    <div class="controls">

                                        <textarea class="redactor_content" name="description" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label" for="pub_date">Start Date</label>
                                    <div class="controls">
                                        <div class="input-append date" id="datetimepicker1">
                                            <input type="text"  name="startdate" id="start-date" value="<?php echo date('d-m-Y h:i:s'); ?>" readonly>
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                        <span class="help-block" style="font-size:11px">Select a start date</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="pub_date">End Date</label>
                                    <div class="controls">
                                        <div class="input-append date" id="datetimepicker2" >
                                            <input type="text"  name="enddate" id="end-date" value="<?php echo date('d-m-Y h:i:s'); ?>" readonly>
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                        <span class="help-block" style="font-size:11px">Select a end date</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Web Link</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="web_link" name="web_link" placeholder="Web Link" value="">
                                        <span class="help-block"  style="font-size:11px">Please paste full url eg: http://www.myweblink.com </span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="metaT">Meta Title:</label>
                                    <div class="controls">
                                        <textarea name="metaT" style="display:block" class="span6"></textarea>
                                        <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="metaD">Meta Description:</label>
                                    <div class="controls">
                                        <textarea name="metaD" style="display:block" class="span6"></textarea>
                                        <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
                                    </div>
                                </div>

                                <div id="result_msg"></div>
                                <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Add Event</button>

                            </fieldset>
                        </form>
                        </p>
                    </div>
                </div>

            </div>

            <hr>


            <!-- end: Content -->
        </div><!--/#content.span10-->
    </div><!--/fluid-row-->

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
    <?php $this->load->view('admin/inc/footer');?>
</div><!--/.fluid-container-->
<script type="text/javascript" src="<?php echo base_url('/')?>admin_src/js/bootstrap-datetimepicker.min.js"></script>
<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/js/jquery.form.min.js"></script>

<script type="text/javascript">

    $(document).ready(function() {

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


        $('#datetimepicker1').datetimepicker({
            format: 'dd-MM-yyyy hh:mm:ss',
            language: 'pt-BR'
        });

        $('#datetimepicker2').datetimepicker({
            format: 'dd-MM-yyyy hh:mm:ss',
            language: 'pt-BR'
        });


    });


    $('#butt').click(function(e) {


        e.preventDefault();
        //Validate
        if($('#title').val().length == 0){

            $('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a recipe title"});
            $('#title').popover('show');
            $('#title').focus();


        }else{

            submit_form();

        }
    });


    function submit_form(){

        var frm = $('#event-add');
        //frm.submit();
        $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
        $.ajax({
            type: 'post',
            data: frm.serialize(),
            url: '<?php echo site_url('/').'event/add_event_do';?>' ,
            success: function (data) {

                $('#result_msg').html(data);
                $('#butt').html('Add Event');

            }
        });

    }

</script>
</body>
</html>