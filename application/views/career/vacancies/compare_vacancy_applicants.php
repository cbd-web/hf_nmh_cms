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

            <article class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                    <div class="jarviswidget jarviswidget-sortable" id="wid-id-0" data-widget-editbutton="false" role="widget" style="">

                        <header>
                            &nbsp;<h2><i class="fa fa-lg fa-fw fa-users"></i> Compare List</h2>

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

                                	<?php echo $this->career_model->get_compare_applicants($vacancy_id); ?>

                            </div>


                        </div>


                    </div>


            </article>

        </div>


    </div>
    <!-- END MAIN CONTENT -->


</div>
<!-- END MAIN PANEL -->

<div class="modal fade" id="myDetails" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    &times;
                </button>
                <h4 class="modal-title" id="myModalLabel">Applicant Details</h4>
            </div>
            <div class="modal-body" id="applicant_body">

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


<script type="text/javascript">


    $(document).ready(function() {

        $("#long_bulk").change(function() {

            var long_bulk = ($(this).val());

            if(long_bulk != 0) {

                bulk_long_action(long_bulk);

            }

        });

    });


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


        $.SmartMessageBox({
            title : title,
            content : message,
            buttons : '[No][Yes]'
        }, function(ButtonPressed) {
            if (ButtonPressed === "Yes") {

                var frm = $('#action_multi_long_files');

                $.ajax({
                    type: 'post',
                    data: frm.serialize(),
                    url: '<?php echo site_url('/') ?>career/action_long_bulk/'+long_bulk,
                    success: function(data) {

                        $("#action_long_files")[0].reset();

                    }
                });

                $.smallBox({
                    title : on_success,
                    content : "Operation Success",
                    color : "#659265",
                    iconSmall : "fa fa-check fa-2x fadeInRight animated",
                    timeout : 4000,
                });



            } else {

                $("#action_long_files")[0].reset();
            }

        });


        //e.preventDefault();

    }


	$( ".app" ).click(function() {
	 
	 	var id = $(this).attr("data-id");

		 $.ajax({
			type: 'get',
			url: "<?php echo site_url('/'); ?>career/get_applicant_details/"+id,
			success: function(data) {

				$('#applicant_body').html(data);
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