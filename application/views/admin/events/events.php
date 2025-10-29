<?php $this->load->view('admin/inc/header');?>
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
                        <a href="#">Events</a>
                    </li>
                </ul>
                <hr>
            </div>

            <div class="row-fluid sortable">


                <div class="box span8">
                    <div class="box-header">
                        <h2><i class="icon-th"></i><span class="break"></span>All Events</h2>
                        <div class="box-icon">
                            <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">
                        <?php $this->event_model->get_all_events();?>

                    </div>
                </div>

                <div class="box span4 noMargin" onTablet="span12" onDesktop="span4">
                    <div class="box-header">
                        <h2><i class="icon-list"></i><span class="break"></span>Legend</h2>
                        <div class="box-icon">
                            <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
                            <a href="#" class="btn-close"><i class="icon-remove"></i></a>
                        </div>
                    </div>
                    <div class="box-content">


                        <div class="well">

                            <p><a title="Update the event" rel="tooltip" class="btn btn-mini" style="cursor:pointer"><i class="icon-pencil"></i></a> - Update Event</p>
                            <p><a title="Delete the event" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer"><i class="icon-trash icon-white"></i></a> - Delete Event</p>

                        </div>



                        <a href="<?php echo site_url('/');?>event/add_event/" class="btn btn-inverse"><i class="fa-icon-plus-sign"></i> Add New Event</a>
                    </div>
                </div><!--/span-->

            </div>

            <hr>

            <div class="row-fluid">



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


    <div class="modal hide fade" id="modal-event-delete">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h3>Delete the Event</h3>
        </div>
        <div class="modal-body">
            <div class="alert">
                <button type="button" class="close" data-dismiss="alert">&times;</button>
                <strong>Please Note!</strong> Are you sure you want to delete the current event? All event details will be removed. This process is not reversible.
            </div>

        </div>
        <div class="modal-footer">
            <a onClick="$('#modal-event-delete').modal('hide');" class="btn">Close</a>
            <a href="#" class="btn btn-primary">Delete Event</a>
        </div>
    </div>

    <div class="clearfix"></div>

    <?php $this->load->view('admin/inc/footer');?>
</div><!--/.fluid-container-->


<script type="text/javascript">
    function delete_event(id){

        $('#modal-event-delete').bind('show', function() {
            //var id = $(this).data('id'),
            removeBtn = $(this).find('.btn-primary');

            removeBtn.unbind('click').click(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "<?php echo site_url('/');?>event/delete_event/"+id+"/",
                    success: function(data) {

                        $('footer').html(data);
                        $('#modal-event-delete').modal('hide');

                    }
                });

            });
        }).modal({ backdrop: true });
    }

</script>
</body>
</html>