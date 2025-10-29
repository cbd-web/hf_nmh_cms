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
                        Update Event: <?php echo $title;?>
                    </li>
                </ul>
                <hr>
            </div>

            <div class="row-fluid sortable">

                <div class="box span12">
                    <div class="box-header">
                        <h2><i class="icon-th"></i><span class="break"></span> Update Event: <?php echo $title;?></h2>
                        <div class="box-icon">
                            <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
                            <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <p>
                        <form id="event-update" name="event-update" method="post" action="<?php echo site_url('/');?>event/update_event_do" class="form-horizontal">
                            <fieldset>
                                <input type="hidden" name="event_id"  value="<?php if(isset($event_id)){echo $event_id;}?>">
                                <input type="hidden" name="autosave" id="autosave"  value="true">
                                <input type="hidden" name="status" id="status"  value="<?php if(isset($status)){echo $status;}?>">
                                <div class="control-group">
                                    <label class="control-label" for="title">Title</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="title" name="title" placeholder="Event title" value="<?php if(isset($title)){echo $title;}?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="heading">Heading</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="heading" name="heading" placeholder="Event heading" value="<?php if(isset($heading)){echo $heading;}?>">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label" for="title">Status</label>
                                    <div class="controls">
                                        <div class="btn-group" data-toggle="buttons-radio">
                                            <button type="button" class="btn btn-primary<?php if($status == 'draft'){ echo ' active';}?>">draft</button>
                                            <button type="button" class="btn btn-primary<?php if($status == 'live'){ echo ' active';}?>">live</button>
                                        </div>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label" for="slug">Slug</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="slug" name="slug" placeholder="Page URL Slug eg: /about-us" value="<?php if(isset($slug)){echo $slug;}?>">
                                        <span class="help-block" style="font-size:11px">The URL paramenter. eg: http://www.example.com/my-event</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="slug">Type</label>
                                    <div class="controls">
                                        <select name="type">
                                            <option value="public" <?php if($type == 'public') { echo 'selected'; }?>>Public</option>
                                            <option value="internal" <?php if($type == 'internal') { echo 'selected'; }?>>Private</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Location</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="location" name="location" placeholder="Location" value="<?php if(isset($location)){echo $location;}?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Venue</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="venue" name="venue" placeholder="Venue" value="<?php if(isset($venue)){echo $venue;}?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Duration</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="duration" name="duration" placeholder="Event Duration" value="<?php if(isset($duration)){echo $duration;}?>">
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Contact Details</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="contact" name="contact" placeholder="Contact Details" value="<?php if(isset($contact)){echo $contact;}?>">
                                    </div>
                                </div>


                                <div class="control-group" id="redactor_content_msg">
                                    <label class="control-label" for="redactor_content">Event Body:</label>
                                    <div class="controls">

                                        <textarea class="redactor_content loading_img" id="redactor_content" name="description" style="display:block"><?php if(isset($description)){echo $description;}?></textarea>
                                    </div>
                                </div>


                                <div class="control-group">
                                    <label class="control-label" for="pub_date">Start Date</label>
                                    <div class="controls">
                                        <div class="input-append date" id="datetimepicker1">
                                            <input type="text"  name="startdate" id="start-date" value="<?php if (isset($startdate)){echo date('d-m-Y H:i:s',strtotime($startdate));}else{ echo date();}?>" readonly>
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                        <span class="help-block" style="font-size:11px">Select a start date</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="pub_date">End Date</label>
                                    <div class="controls">
                                        <div class="input-append date" id="datetimepicker2" >
                                            <input type="text"  name="enddate" id="end-date" value="<?php if (isset($enddate)){echo date('d-m-Y H:i:s',strtotime($enddate));}else{ echo date();}?>" readonly>
                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                        </div>
                                        <span class="help-block" style="font-size:11px">Select a end date</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="title">Web Link</label>
                                    <div class="controls">
                                        <input type="text" class="span6" id="web_link" name="web_link" placeholder="Web Link" value="<?php if(isset($web_link)){echo $web_link;}?>">
                                        <span class="help-block"  style="font-size:11px">Please paste full url eg: http://www.myweblink.com </span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="metaT">Meta Title:</label>
                                    <div class="controls">
                                        <textarea name="metaT" style="display:block" class="span6"><?php if(isset($metaT)){echo $metaT;}?></textarea>
                                        <span class="help-block"  style="font-size:11px">If input given the default title is overridden. Good for SEO purposes. No longer than 70 characters</span>
                                    </div>
                                </div>

                                <div class="control-group">
                                    <label class="control-label" for="metaD">Meta Description:</label>
                                    <div class="controls">
                                        <textarea name="metaD" style="display:block" class="span6"><?php if(isset($metaD)){echo $metaD;}?></textarea>
                                        <span class="help-block" style="font-size:11px">This is an invisible tag that search engines use to evaluate in their ranking metrics. 160 characters. Must be unique to any onther page.</span>
                                    </div>
                                </div>

                                <div id="result_msg"></div>
                                <button type="submit" class="btn btn-inverse btn pull-right" id="butt">Update Event</button>

                            </fieldset>
                        </form>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row-fluid sortable">

                <div class="box span4">
                    <div class="box-header">
                        <h2><i class="icon-th"></i><span class="break"></span>Featured image</h2>
                        <div class="box-icon">
                            <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <p>

                            <?php $this->admin_model->get_featured_image('event', $event_id);?>

                        </p>
                    </div>
                </div>
                <div class="box span4">
                    <div class="box-header">
                        <h2><i class="icon-th"></i><span class="break"></span>Category</h2>
                        <div class="box-icon">
                            <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <p>
                            <?php $this->load->view('admin/events/inc/categories_inc');?>
                        </p>
                    </div>
                </div>
                <div class="box span4">
                    <div class="box-header">
                        <h2><i class="icon-th"></i><span class="break"></span>Post Sidebar</h2>
                        <div class="box-icon">

                        </div>
                    </div>
                    <div class="box-content">
                        <div class="alert">
                            This is the secondary smaller post column. Please select what component you would like to display.
                        </div>
                        <p>
                            <!--<a href="#" onClick="$('#gallery_cont').slideToggle();" class="btn "><i class="icon-picture"></i> Gallery</a>
                            <a href="#" class="btn "><i class="icon-envelope"></i> Contact Us</a>-->
                        </p>

                        <div class="box-header">
                            <h2>Gallery</h2>
                            <div class="box-icon">
                                <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                            </div>
                        </div>
                        <div class="box-content">

                            <div id="gallery_images">
                                <?php $this->admin_model->get_sidebar_content('event_'.$event_id);?>
                            </div>


                            <div id="doc_msg"></div>
                        </div>
                        <div class="clearfix" style="height:20px"></div>



                    </div>

                </div>



            </div>

            <hr>



            <!-- end: Content -->
        </div><!--/#content.span10-->
    </div><!--/fluid-row-->


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

    var delay = 100;
    var isLoading = false;
    var isDirty = false;


    $(document).ready(function(){


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



        $('#butt').bind('click',function(e) {
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



        $('div.btn-group button').live('click', function(){

            $('#status').attr('value', $(this).html());
        });

        $('#recipe-update :input').change(function() {

            $('#autosave').val('false');
        });
        $('.redactor_box').live('click', function() {

            $('#autosave').val('false');
        });

        //Featured image
        $('#imgbut').bind('click', function() {


            var avataroptions = {
                target:        '#avatar_msg',
                url:       	   '<?php echo site_url('/').'admin/add_featured_image';?>' ,
                beforeSend:    function() {var percentVal = '0%';probar.width(percentVal)},
                uploadProgress: function(event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    probar.width(percentVal)

                },
                complete: function(xhr) {
                    procover.hide();
                    probar.width('0%');
                    $('#avatar_msg').html(xhr.responseText);
                    $('#imgbut').html('Update Image');
                }

            };

            var frm = $('#add-img');
            var probar = $('#procover .bar');
            var procover = $('#procover');

            $('#imgbut').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Uploading...');
            procover.show();
            frm.ajaxForm(avataroptions);
            $('#autosave').val('true');
        });

    });



    function submit_form(){

        var frm = $('#event-update'), content = $('#redactor_content').text();

        $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
        $.ajax({
            type: 'post',
            //data: frm.serialize()+'&content2='+content,
            data: frm.serialize(),
            url: '<?php echo site_url('/').'event/update_event_do';?>' ,
            success: function (dataresult) {
                $('#autosave').val('true');
                $('#result_msg').html(dataresult);
                $('#butt').html('Update Event');
                //$('#test_msg').append(frm.serialize());
            }
        });

    }



    function attach_gallery(){

        var gal_id = $('#gallery_select').val();

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'admin/update_sidebar/event/'.$event_id.'/gallery/';?>'+gal_id ,
            success: function (data) {

                load_images(gal_id);
            }
        });

    }

    function remove_gallery(gal_id){

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'admin/remove_sidebar/event/'.$event_id.'/gallery/';?>'+gal_id ,
            success: function (data) {

                $('#gallery_images').html(data);
            }
        });

    }

    function load_images(gal_id){

        $.ajax({
            cache: false,
            method: "post",
            url: "<?php echo site_url('/');?>admin/load_gallery_images/"+gal_id+"/<?php echo rand(0,9999);?>",
            success: function(data) {
                $('#gallery_images').empty();
                $('#gallery_images').html(data);

            }
        });

    }



    //IE 9 Fix
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }

</script>
</body>
</html>