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
            <li><a href="<?php echo site_url('/'); ?>career">Home</a></li><li><a href="<?php echo site_url('/'); ?>career/clients">Clients</a></li><li>Update Client</li>
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
                    CLIENTS
                    <span>&gt;
                        Update Client: <strong><?php echo $client_name; ?></strong>
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
                        <h2>Client Update Form</h2>

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
                            <form id="client-update" name="cclient-update" method="post" action="<?php echo site_url('/');?>career/update_client_do" class="smart-form">
                                <input type="hidden" name="client_id"  value="<?php if(isset($vac_client_id)){echo $vac_client_id;}?>">

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
                                            <label class="label">Client Name</label>
                                            <label class="input">
                                                <input type="text" id="title" name="title" placeholder="Client Name" value="<?php if(isset($client_name)){echo $client_name;} ?>">
                                            </label>
                                        </section>
                                        <section class="col col-4">
                                            <label class="label">Email</label>
                                            <label class="input">
                                                <input type="text" class="span8" id="email" name="email" placeholder="Client Email" value="<?php if(isset($email)){echo $email;} ?>">
                                            </label>
                                        </section>
                                    </div>


                                <footer>
                                    <button type="submit" name="submit" class="btn btn-primary pull-left" id="butt">
                                        UPDATE CLIENT
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

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                        <header>
                            &nbsp;<h2><i class="fa fa-lg fa-fw fa-tag"></i> Client Login Tokens</h2>
                        </header>

                        <!-- widget div-->
                        <div role="content">
                            <button data-toggle="modal" data-target="#myToken" class="btn btn-info">ADD TOKEN</button>

                            <div id="curr-tokes">
                            <?php echo $this->career_model->get_client_tokens($vac_client_id); ?>
                            </div>
                        </div>

                    </div>


            </article>

            <article class="col-xs-12 col-sm-12 col-md-4 col-lg-4">


                <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                    <header>
                        &nbsp;<h2><i class="fa fa-lg fa-fw fa-briefcase"></i> Client Vacancies</h2>


                    </header>

                    <!-- widget div-->
                    <div role="content">
                        <?php echo $this->career_model->get_client_vacancies($vac_client_id); ?>

                    </div>

                </div>


            </article>


        </div>


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->

<div class="modal fade" id="myToken" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Upload Client Token</h4>
            </div>
            <div class="modal-body">
                <form id="token-add" name="tokenform" class="smart-form" method="post" action="<?php echo site_url('/');?>career/add_client_token_do">
                    <input type="hidden" name="length" value="10">
                    <input type="hidden" name="client" value="<?php if(isset($vac_client_id)){echo $vac_client_id;}?>">
                    <input type="hidden" name="client_name" value="<?php if(isset($client_name)){echo $client_name;} ?>">
                    <div class="row-fluid">

                        <fieldset>

                        <section>
                            <label class="label">Email</label>
                            <label class="input">
                                <input type="text" class="span8" id="email" name="email" placeholder="Client Email" value="<?php if(isset($email)){echo $email;} ?>">
                            </label>
                        </section>

                        <section>

                            <label class="input">
                                <label class="label">Generate Token</label>
                                <input type="text" name="row_password" class="input-sm" placeholder="Generate Token">
                            </label>
                            <input type="button" class="btn btn-info btn-sm btn-block" value="Generate" onClick="generate();" tabindex="2">
                            <div class="note">
                                <strong>Note:</strong> Please make sure you copied the token in a safe place before submitting.
                            </div>
                        </section>

                        <section>
                            Pick client documents
                            <label class="input">
                                <input type="text" list="list" id="doc-item">
                                <datalist id="list">
                                    <?php echo $this->career_model->get_client_docs_select($vac_client_id); ?>
                                </datalist>
                                <button type="button" class="btn btn-info btn-sm btn-block" id="add-doc">Add Document</button>
                            </label>
                        </section>
                        <div id="doc-files-box"></div>
                        </fieldset>

                        <fieldset>
                            <section>
                                <label class="label">Expiry Date</label>
                                <label class="input">
                                    <i class="icon-append fa fa-calendar"></i>
                                    <input type="text" data-dateformat="dd.mm.yyyy" name="expiry_date" id="datepicker">
                                </label>
                            </section>

                            <section>
                                <label class="checkbox">
                                    <input type="checkbox" name="send_pass" value="Y">
                                    <i></i>Send token to client</label>
                            </section>
                        </fieldset>

                    </div>
                    <div style="clear: both"></div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="token-butt" class="btn btn-primary">
                    Upload Token
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="modal fade" id="myTokenUpdate" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Update Client Token</h4>
            </div>
            <div class="modal-body" id="update_q_body">

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">
                    Cancel
                </button>
                <button type="button" id="update_token_butt" class="btn btn-primary">
                    Update Token
                </button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<?php $this->load->view('career/inc/footer');?>
<script type='text/javascript' src="<?php echo base_url('/'); ?>admin_src/js/jquery.form.min.js"></script>


<script type="text/javascript">



    // START AND FINISH DATE
    $('#datepicker').datepicker({
        dateFormat: 'dd.mm.yy',
        prevText: '<i class="fa fa-chevron-left"></i>',
        nextText: '<i class="fa fa-chevron-right"></i>',
        onSelect: function (selectedDate) {
            $('#finishdate').datepicker('option', 'minDate', selectedDate);
        }
    });

    function randomPassword(length) {

        var chars = "abcdefghijklmnopqrstuvwxyz!@#$%^&*()-+<>ABCDEFGHIJKLMNOP1234567890";
        var pass = "";
        for (var x = 0; x < length; x++) {
            var i = Math.floor(Math.random() * chars.length);
            pass += chars.charAt(i);
        }
        return pass;
    }

    function generate() {

        tokenform.row_password.value = randomPassword(tokenform.length.value);
    }

    $( "#add-doc" ).click(function() {
        var x = $('#doc-item').val();
        var z = $('#list');
        var val = $(z).find('option[value="' + x + '"]');
        var endval = val.attr('data-id');

        $('<input>').attr({
            type: 'hidden',
            name: 'filo[]',
            id: 'file'+endval,
            value: endval
        }).appendTo('#token-add');

        var frm_e = '<span class="label label-default" id="doc-'+endval+'" style="padding:5px"> '+x+' <a href="javascript:void(0)" style="color:#a90329" class="del-doc" data-id="'+endval+'"><i class="fa fa-trash-o pull-right" style="margin:4px"></i></a></span>';

        $('#doc-files-box').append(frm_e);

    });

    $('#doc-files-box').on('click', '.del-doc', function(e)
    {
        e.preventDefault();

        var id = $(this).attr("data-id");

        $('#doc-'+id).remove();
        $('#file'+id).remove();

    });


    $('#token-butt').click(function(e) {



        e.preventDefault();
        //Validate
        if($('#title').val().length == 0){

            $('#expiry_date').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Expiry Date Required", content:"Please supply us with a expiry date"});
            $('#expiry_date').popover('show');
            $('#expiry_date').focus();


        }else{

            var frm = $('#token-add');
            //frm.submit();
            $('#token-butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/add_client_token_do';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "Client Token Uploaded!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $("#token-add")[0].reset();
                    $('#myToken').modal('hide');

                    reload_tokens();

                    $('#token-butt').html('Upload Token');

                }
            });

        }
    });


    $('#butt').click(function(e) {

        e.preventDefault();
        //Validate
        if($('#title').val().length == 0){

            $('#title').popover({  delay: { show: 100, hide: 3000 },placement:"top",html: true,trigger: "manual", title:"Client Name Required", content:"Please supply us with a client name"});
            $('#title').popover('show');
            $('#title').focus();


        }else{

            var frm = $('#client-update');
            //frm.submit();
            $('#butt').html('<img src="<?php echo base_url('/').'admin_src/img/loading_white.gif';?>" /> Working...');
            $.ajax({
                type: 'post',
                data: frm.serialize(),
                url: '<?php echo site_url('/').'career/update_client_do';?>' ,
                success: function (data) {

                    $.smallBox({
                        title : "Entry Updated!",
                        content : "Operation Success",
                        color : "#659265",
                        iconSmall : "fa fa-check fa-2x fadeInRight animated",
                        timeout : 4000
                    });

                    $('#result_msg').html(data);
                    $('#butt').html('Update Client');

                }
            });

        }
    });

    function delete_token(id){

        $.SmartMessageBox({
            title : "<span style='color:#c00; font-weight:bold'>Delete Token</span>",
            content : "The entry will be deleted permanently! Click <strong><u>YES</u></strong> to Delete Token. Click <strong><u>NO</u></strong> to Cancel.",
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                $.ajax({
                    url: "<?php echo site_url('/');?>career/delete_client_token_do/"+id+"/",
                    success: function(data) {
                        reload_tokens();
                        $("#ta").prop("checked", false);
                    }
                });

                $.smallBox({
                    title : "Token Deleted!",
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000
                });
            }

        });
        //e.preventDefault();

    }

    function reload_tokens(){


        $.ajax({
            type: 'get',
            url: '<?php echo site_url('/').'career/reload_client_tokens/'.$vac_client_id.'/'; ?>',
            success: function (data) {

                $('#curr-tokes').html(data);

            }
        });
    }

    </script>

</body>
</html>