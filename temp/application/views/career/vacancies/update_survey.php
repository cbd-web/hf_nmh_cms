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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/vacancy_survey">MR Survey</a></li><li>Update Survey</li>
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
                    MINIMUM REQUIREMENTS SURVEY
                    <span>&gt;
                        Update MR Survey: <strong><?php echo $title; ?></strong>
                    </span>
                </h1>
            </div>

        </div>

        <!-- Vacancy Table -->
        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" role="widget">

                    <header role="heading">
                        <span class="widget-icon"> <i class="fa fa-comments"></i> </span>
                        <h2>Survey Update Form</h2>

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
                            <form id="survey-update" name="survey-update" method="post" action="<?php echo site_url('/');?>career/update_vacancy_survey_do" class="smart-form">
                                <input type="hidden" name="survey_id"  value="<?php if(isset($survey_id)){echo $survey_id;}?>">

                                <header>

                                        <i class="fa fa-lg fa-fw fa-calendar"></i> <strong>Entry published on:</strong> <?php echo date('d-M-Y',strtotime($listing_date)); ?>

                                </header>

                                <fieldset>

                                    <div class="row">
                                        <section class="col col-12">

                                            <label><h4>Active</h4></label>
                                            <span class="onoffswitch">
                                            <?php
                                            switch($status) {
                                                case 'live':
                                                    $checked = 'checked';
                                                    break;
                                                case 'draft':
                                                    $checked = '';
                                                    break;
                                            }

                                            ?>
                                                <input type="checkbox" name="status" class="onoffswitch-checkbox" id="st3" <?php echo $checked; ?>>
                                            <label class="onoffswitch-label" for="st3">
                                                <div class="onoffswitch-inner" data-swchon-text="YES" data-swchoff-text="NO"></div>
                                                <div class="onoffswitch-switch"></div>
                                            </label>
                                            </span>
                                            </section>
                                    </div>

                                    <div class="row">
                                        <section class="col col-4">
                                            <label class="label">Title</label>
                                            <label class="input">
                                                <input type="text" id="title" name="title" placeholder="Vacancy title" value="<?php if(isset($title)){echo $title;} ?>">
                                            </label>
                                        </section>
                                    </div>


                                    <section>
                                        <label class="label">Survey Description</label>
                                        <label class="textarea">
                                            <textarea id="redactor_content" class="redactor_content" rows="4" name="body"><?php if(isset($body)){echo $body;} ?></textarea> </label>
                                        <div class="note">

                                        </div>
                                    </section>
                                </fieldset>

                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPDATE ENTRY
                                    </button>
                                </footer>

                            </form>

                        </div>

                    </div>
                    <!-- end widget div -->



                </div>



            </article>

        </div>

        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                        <header>
                            &nbsp;<h2><i class="fa fa-lg fa-fw fa-question"></i> MINIMUM REQUIREMENT ENTRIES</h2>

                        </header>

                        <!-- widget div-->
                        <div role="content">

                            <!-- widget edit box -->
                            <div class="jarviswidget-editbox">
                                <!-- This area used as dropdown edit box -->

                            </div>
                            <!-- end widget edit box -->

                            <!-- widget content -->
                            <div class="widget-body">

                                    <button data-toggle="modal" data-target="#myQuestion" class="btn btn-info">ADD MIMIMUM REQUIREMENT</button>
                                    <form action="" method="post" id="action_multi_files" class="form">
                                        <div class="note pull-right">
                                            <strong>Note:</strong> You can update the sequence of entires by dragging and dropping them.
                                        </div>
                                    <div class="row-fluid" id="question_div">

                                        <?php echo $this->career_model->vacancy_survey_questions($survey_id); ?>

                                    </div>
                                        <div class="row">
                                            <div class="col-md-3 col-lg-3">
                                                <select id="bulk" class="form-control" name="bulk" >
                                                    <option value="0">Bulk Actions</option>
                                                    <option value="1">Delete Selected</option>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-lg-3">

                                            </div>
                                        </div>
                                    </form>
                            </div>

                        </div>

                    </div>


            </article>


        </div>


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->

<div class="modal fade" id="myQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Add Minimum Requirement</h4>
            </div>
            <div class="modal-body">
                <form id="survey_question_add" class="smart-form" method="post" action="<?php echo site_url('/');?>career/add_vacancy_survey_question_do">
                <input type="hidden" name="survey_id"  value="<?php if(isset($survey_id)){echo $survey_id;}?>">
                <div class="row-fluid">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label>Mimimum Requirement</label>
                            <textarea class="form-control" rows="3" name="question" id="question" required></textarea>
                            <br>
                        </div>

                        <div class="form-group">
                            <label>Help text</label>
                            <textarea class="form-control" rows="3" name="help"></textarea>
                            <br>
                        </div>

                        <div class="form-group">
                            <label class="checkbox">
                            <input type="checkbox" name="elaborate">
                            <i></i>Elaborate</label>

                            <div class="note">
                                <strong>Note:</strong> Please check if candidate has to elaborate.
                            </div>
                        </div>
                    </div>
                </div>
                <div style="clear: both"></div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="question_butt" class="btn btn-primary">
                    Upload Requirement
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<div class="modal fade" id="myUpdateQuestion" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Update Minimum Requirement</h4>
            </div>
            <div class="modal-body" id="update_q_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="update_question_butt" class="btn btn-primary">
                    Update Requirement
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php $this->load->view('career/inc/footer');?>
<script type='text/javascript' src="<?php echo base_url('/'); ?>admin_src/js/jquery.form.min.js"></script>

<script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
<script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>


<script type="text/javascript">


    function update_question(id){

        var  cont = $('#update_q_body');
        cont.empty().addClass('loading_img');
        $.ajax({
            url: "<?php echo site_url('/');?>career/update_vacancy_survey_question/"+id+"/",
            success: function(data) {
                cont.removeClass('loading_img').html(data);
                $('#update_q_body').html(data);

            }
        });


    }


    function bulk_action(bulk){

        if(bulk == 1) {

            var message = "Selected entries will be deleted permanently! Click <strong><u>YES</u></strong> to delete entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Delete Entries</span>";
            var on_success  = "Entries successfully removed";

        }


        $.SmartMessageBox({
            title : title,
            content : message,
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                var frm = $('#action_multi_files');

                if(bulk == 1) {

                    $.ajax({
                        type: 'post',
                        data: frm.serialize(),
                        url: '<?php echo site_url('/') ?>career/action_vacancy_survey_questions_bulk/'+bulk,
                        success: function(data) {

                            reload_questions();

                            $("#action_multi_files")[0].reset();

                        }
                    });

                }


                $.smallBox({
                    title : on_success,
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000,
                });



            }

        });


        //e.preventDefault();

    }

    $('#answer_btn_add').bind('click', function(e){

        e.preventDefault();
        var div = $('#q_answers_pre'), input = $('#q_answers'), fake = $('#answer_select'), q_item = "'"+fake.val()+"'";

        if(fake.val() != ''){
            input.val(fake.val()+","+input.val());
            div.append('<div class="row" style="background-color:#efefef; padding:2px; padding-bottom: 4px; margin:2px " id="u_'+fake.val()+'"><div class="col-md-10"><label class="radio"><input type="radio" name="correct_answer" value="'+fake.val()+'"><i></i>'+fake.val()+' </label></div><div class="col-md-2"><button type="button" class="close pull-right" style="margin-top:4px" onclick="remove_item_u('+q_item+')">&times;</button></div></div>');
            fake.val('');
        }
    });


    function remove_item_u(qitem) {

        $('#u_'+qitem).remove();

        var input = $('#q_answers');

        var string = input.val();

        var newstring = remove(string,qitem); // newstring will contain "1,2,3,5"

        input.val(newstring);
    }


    function remove(string,to_remove)
    {

        var elements=string.split(',');
        var remove_index=elements.indexOf(to_remove);
        elements.splice(remove_index,1);
        var result=elements.join(',');
        return result;

    }


    $(document).ready(function() {

        $("#bulk").change(function() {

            var bulk = ($(this).val());

            if(bulk != 0) {

                bulk_action(bulk);

            }

        });


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
        if($('#title').val().length == 0){

            $('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Title Required", content:"Please supply us with a survey title"});
            $('#title').popover('show');
            $('#title').focus();


        }else{

            var frm = $('#survey-update');
            //frm.submit();
            $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/update_vacancy_survey_do';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "Entry Updated!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $('#result_msg').html(data);
                    $('#butt').html('Update Vacancy');

                }
            });

        }
    });

    $('#question_butt').click(function(e) {

        e.preventDefault();
        //Validate
        if($('#question').val().length == 0){

            $('#question').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Question Required", content:"Please supply us with a Question"});
            $('#question').popover('show');
            $('#question').focus();


        }else{

            var frm = $('#survey_question_add');
            //frm.submit();
            $('#question_butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/add_vacancy_survey_question_do';?>' ,
                success: function (data) {

                    $("#survey_question_add")[0].reset();
                    $('#q_answers_pre').empty();
                    $('#myQuestion').modal('hide');
                    $('#q_answers').val('');
                    $('#answer_select').val('');

                    $.smallBox({
                        title : "Question Added!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $('#result_msg').html(data);
                    $('#question_butt').html('Upload Question');
                    reload_questions();
                }
            });

        }
    });


    $('#update_question_butt').click(function(e) {

        e.preventDefault();
        //Validate
        if($('#question_u').val().length == 0){

            $('#question_u').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Question Required", content:"Please supply us with a Question"});
            $('#question_u').popover('show');
            $('#question_u').focus();


        }else{

            var frm = $('#vacancy_survey_question_update');
            //frm.submit();
            $('#update_question_butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/update_vacancy_survey_question_do';?>' ,
                success: function (data) {

                    $("#vacancy_survey_question_update")[0].reset();
                    $('#q_answers_pre_u').empty();
                    $('#myUpdateQuestion').modal('hide');
                    $('#q_answers_u').val('');
                    $('#answer_select_u').val('');

                    $.smallBox({
                        title : "Question Updated!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $('#result_msg').html(data);
                    $('#update_question_butt').html('Update Question');
                    reload_questions();
                }
            });

        }
    });





    function delete_question(id, title){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Delete Entry: "+title+"</span>",
            content : "The entry will be deleted permanently! Click <strong><u>YES</u></strong> to Delete File. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    url: "<?php echo site_url('/');?>career/delete_vacancy_survey_question_do/"+id+"/",
                    success: function(data) {
                        reload_questions();
                        $("#ta").prop("checked", false);
                    }
                });

                $.smallBox({
                    title : "Entry: "+title+" Deleted!",
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });
            }

        });
        //e.preventDefault();

    }

    function reload_questions(){

        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'career/reload_vacancy_questions/'.$survey_id; ?>' ,
            success: function (data) {

                $('#question_div').html(data);

            }
        });
    }



    </script>

</body>
</html>