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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/vacancies">Vacancies</a></li><li>Vacancy Applicants</li>
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
                    VACANCY APPLICANTS
                    <span> <strong><?php echo $title; ?></strong>
                    </span>
                </h1>
            </div>

        </div>

        <div class="row">

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="cont-div" style="display:none">

                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                    <header>
                        &nbsp;<h2><i class="fa fa-lg fa-fw fa-users"></i> Compare List</h2>

                    </header>

                    <!-- widget div-->
                    <div role="content">
                        <pre>
                        <table id="list" class="table table-striped" border="1" style="border: 0;">


                        </table>
                        </pre>
                    </div>

                </div>

            </article>

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">

                    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget">

                        <header>
                            &nbsp;<h2><i class="fa fa-lg fa-fw fa-users"></i> Long List</h2>
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
                                <form action="" method="post" id="action_multi_long_files" name="action_multi_long_files" class="form">
                                    <input type="hidden" name="vid" value="<?php echo $vacancy_id ?>">
                                	<?php echo $this->career_model->get_vacancy_applicants($vacancy_id, 'long'); ?>

                                        <select id="long_bulk" class="form-control" name="long_bulk">
                                            <option value="0">Bulk Actions</option>
                                            <option value="1">Remove Selected</option>
                                            <option value="2">Short list Selected</option>
                                            <option value="3">Compare</option>
                                            <option value="4">Export to CSV</option>
                                        </select>
                                </form>
                                <input type="checkbox" id="ta" onClick="toggle(this)" /> Check all applicants
                            </div>


                        </div>


                    </div>


            </article>

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                        <header>
                            &nbsp;<h2><i class="fa fa-lg fa-fw fa-users"></i> Short List</h2>

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
                                <form action="" method="post" id="action_multi_short_files" name="action_multi_short_files" class="form">
                                    <input type="hidden" name="vid" value="<?php echo $vacancy_id; ?>">
                                    <input type="hidden" name="message_body" id="message_body" value="">
                                    <input type="hidden" name="vacancy" value="<?php echo $title; ?>">

                                	<?php echo $this->career_model->get_vacancy_applicants($vacancy_id, 'short'); ?>

                                    <select id="short_bulk" class="form-control" name="short_bulk" >
                                        <option value="0">Bulk Actions</option>
                                        <option value="1">Remove Selected</option>
                                        <option value="2">Long list Selected</option>
                                        <option value="3">Compare</option>
                                        <option value="4">Export to CSV</option>
                                        <option value="5">Email Applicants</option>
                                    </select>
                                </form>    
                                <input type="checkbox" id="ta" onClick="toggle(this)" /> Check all applicants

                            </div>

                        </div>

                    </div>


            </article>

        </div>


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->

<div class="modal fade" id="myMessage" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Compile Message</h4>
            </div>
            <div class="modal-body" id="message_body">
                <section>
                    <label class="label">Vacancy Description</label>
                    <label class="textarea">
                        <textarea id="redactor_content" class="redactor_content" rows="4" name="body"></textarea>
                    </label>
                    <button type="button" id="message_butt" class="btn btn-primary">
                        Send Message
                    </button>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
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

        $("#long_bulk").change(function() {
            var long_bulk = ($(this).val());
            if(long_bulk != 0) {

                bulk_long_action(long_bulk);

            }
        });

        $("#short_bulk").change(function() {

            var short_bulk = ($(this).val());

            if(short_bulk != 0) {

                bulk_short_action(short_bulk);

            }

        });
    });


        function toggle(source) {
          checkboxes = document.getElementsByName('app_files[]');
          for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
          }
        }

    function bulk_long_action(long_bulk){

        if(long_bulk == 1) {

            var message = "Selected entries will be deleted permanently! Click <strong><u>YES</u></strong> to delete entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Delete Level Entries</span>";
            var on_success  = "Entries successfully removed";

        }

        if(long_bulk == 2) {

            var message = "Selected entries will be short listed! Click <strong><u>YES</u></strong> to short list entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Short List Entries</span>";
            var on_success  = "Entries successfully short listed";

        }

        if(long_bulk == 3) {

            var message = "Selected entries will be compared! Click <strong><u>YES</u></strong> to compare entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Compare Entries</span>";
            var on_success  = "Entries successfully compared";

        }

        if(long_bulk == 4) {

            var message = "Selected entries will be exported to CSV! Click <strong><u>YES</u></strong> to export entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Export Entries to CSV</span>";
            var on_success  = "Entries successfully exported";

        }

        var frm = $('#action_multi_long_files');

        $.SmartMessageBox({
            title : title,
            content : message,
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    type: 'post',
                    dataType: 'json',

                    data: frm.serialize(),
                    url: '<?php echo site_url('/') ?>career/action_long_bulk/'+long_bulk,
                    success: function(data) {

                        if(data.output == 'remove') {

                            reload_lists();

                        }

                        if(data.output == 'short') {

                            reload_lists();

                        }

                        if(data.output == 'compare') {

                            $("#list").empty();
                            $("#cont-div").show();

                            $.each(data.app_list, function(key, val) {

                                $("#list").append(val);

                            });

                        }

                        if(data.output == 'export') {

                            window.location = "<?php echo site_url('/').'career/app_csv_download/'.$vacancy_id; ?>";
                        }

                        $.smallBox({
                            title : on_success,
                            content : "Operation Success",
                            color : "#659265",
                            iconSmall : "fa fa-check fa-2x fadeInRight animated",
                            timeout : 4000,
                        });

                        document.getElementByName('action_multi_long_files')[0].reset();

                    }
                });


            } else {

                document.getElementsByName('action_multi_long_files')[0].reset();
            }

        });


        //e.preventDefault();

    }


    function bulk_short_action(short_bulk){

        if(short_bulk == 1) {

            var message = "Selected entries will be deleted permanently! Click <strong><u>YES</u></strong> to delete entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Delete Level Entries</span>";
            var on_success  = "Entries successfully removed";
            var box = true;

        }

        if(short_bulk == 2) {

            var message = "Selected entries will be long listed! Click <strong><u>YES</u></strong> to long list entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Short List Entries</span>";
            var on_success  = "Entries successfully long listed";
            var box = true;

        }

        if(short_bulk == 3) {

            var message = "Selected entries will be compared! Click <strong><u>YES</u></strong> to compare entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Compare Entries</span>";
            var on_success  = "Entries successfully compared";
            var box = true;

        }

        if(short_bulk == 4) {

            var message = "Selected entries will be exported to CSV! Click <strong><u>YES</u></strong> to export entries. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Export Entries to CSV</span>";
            var on_success  = "Entries successfully exported";
            var box = true;

        }

        if(short_bulk == 5) {

            var message = "Send email to selected entries! Click <strong><u>YES</u></strong> to send message. Click <strong><u>NO</u></strong> to Cancel process.";
            var title = "<span style='color:#c00; font-weight:bold'>Export Entries to CSV</span>";
            var on_success  = "Message successfully sent";
            var box = false;


        }

        if(box == true) {

            $.SmartMessageBox({
                title : title,
                content : message,
                buttons : '[No][Yes]'
            }, function(ButtonPressed) {
                if (ButtonPressed === "Yes") {

                    var frm = $('#action_multi_short_files');

                    $.ajax({
                        type: 'post',
                        dataType: 'json',

                        data: frm.serialize(),
                        url: '<?php echo site_url('/') ?>career/action_short_bulk/'+short_bulk,
                        success: function(data) {

                            if(data.output == 'remove') {

                                reload_lists();

                            }

                            if(data.output == 'short') {

                                reload_lists();

                            }

                            if(data.output == 'compare') {

                                $("#list").empty();
                                $("#cont-div").show();

                                $.each(data.app_list, function(key, val) {


                                    $("#list").append(val);


                                });

                            }

                            if(data.output == 'export') {

                                window.location = "<?php echo site_url('/').'career/app_csv_download/'.$vacancy_id; ?>";
                            }

                            $.smallBox({
                                title : on_success,
                                content : "Operation Success",
                                color : "#659265",
                                iconSmall : "fa fa-check fa-2x fadeInRight animated",
                                timeout : 4000,
                            });

                            document.getElementByName('action_multi_short_files')[0].reset();

                        }
                    });


                } else {

                    document.getElementByName('action_multi_short_files')[0].reset();
                }

            });

        } else {

            $('#myMessage').modal('show');

        }

        //e.preventDefault();

    }


    $('#message_butt').click(function(e) {

        e.preventDefault();

        var text = $('textarea#redactor_content').val();

        $("#message_body").val(text);

        var frm = $('#action_multi_short_files');
        //frm.submit();
        $('#message_butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
        $.ajax({
            type: 'post',
            data: frm.serialize(),
            url: '<?php echo site_url('/').'career/send_applicant_message';?>' ,
            success: function (data) {

                $.smallBox({
                    title : "Message Sent!",
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });

                $('#message_butt').html('Send Messagey');

            }
        });

    });




    function reload_lists() {

        window.location = "<?php echo site_url('/').'career/vacancy_applicants/'.$vacancy_id; ?>";

    }



	$( ".apps" ).click(function() {
	 
	 	var id = $(this).attr("data-id");

        $("#cont-div").show();

		 $.ajax({
			type: 'get',
            dataType: 'json',
			url: "<?php echo site_url('/'); ?>career/get_applicant_details/"+id,
			success: function(data) {

                $.each(data.app_list, function(key, val) {


                    $("#list").append(val);


                });

			}
		});			
	 
	});

    function action_applicant(id, name){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Sort Applicant: "+name+"</span>",
            content : "Please choose a listing category.",
            buttons : '[Cancel][Remove][Long List][Short List]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Long List") {

				list_applicant(id, 'long');
            }
			
            if (ButtonPressed === "Short List") {

				list_applicant(id, 'short');
            }
			
            if (ButtonPressed === "Remove") {

				list_applicant(id, 'remove');
            }						

        });
        //e.preventDefault();

    }
	
	function list_applicant(id, status) {
		
		 $.ajax({
			type: 'get',
			url: "<?php echo site_url('/'); ?>career/sort_applicant/"+id+"/"+status,
			success: function(data) {

				location.reload();
			}
		});	
	}




    </script>

</body>
</html>