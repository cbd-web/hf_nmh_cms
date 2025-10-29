<div id="main_calendar"></div>

<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//SHOW EVENT
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
 <div id="modal-event-show" class="modal hide fade">
    <div class="modal-header">
      <a onclick="javascript:$('#modal-event-show').modal('hide')" class="close">&times;</a>
      <h3 id="event_title"></h3>
    </div>
    <div class="modal-body">
      <p id="event_body" style="min-height:130px"></p>
       
    </div>
    <div class="modal-footer"> 
      <a id="edit_btn" href="" class="btn btn-primary"><i class="icon-remove"></i> Remove</a> 
      <a onclick="javascript:$('#modal-event-show').modal('hide')" class="btn">Close</a>
    </div>
</div>

<link type="text/css" href="<?php echo base_url('/');?>admin_src/css/fullcalendar.css"  rel="stylesheet">
<script src='<?php echo base_url('/');?>admin_src/js/fullcalendar.min.js'></script>
    

<script type='text/javascript'>

	$(document).ready(function() {

 
		var date = new Date();

		var d = date.getDate();

		var m = date.getMonth();

		var y = date.getFullYear();

		var calendar = $('#main_calendar').fullCalendar({
			
			height: 650, 
			contentHeight: 600,
			header: {
				left: 'title',
				right: 'prev,next today,month,agendaWeek'
			},
			
			selectable: true,

			selectHelper: true,

			select: function(start, end, allDay) {
				
				if (date > start) {

					 var x =  event.clientX + document.body.scrollLeft;
					 var y = event.clientY + document.body.scrollTop;
					 $('#modal-event-msg').css({ top: (y-180)+'px', left: (x-190)+'px'}).fadeIn().delay('2000').fadeOut();
					 $('#event_modal_msg').html('<h3>Date in the past!</h3>Please select a date in the future'); 
					
					
           		 } else {
				
					$('#modal-event').unbind('show').bind('show', function() {
	
						$('#add_start').val($.fullCalendar.formatDate(start, "yyyy-MM-dd HH:mm:ss"));
						$('#add_end').val($.fullCalendar.formatDate(end, "yyyy-MM-dd HH:mm:ss"));
						$('#add_allday').val(allDay);
						
					}).modal({ backdrop: true }).stop();
				
				}
				calendar.fullCalendar('unselect');

			},//end select
			
			eventResize: function(event,dayDelta,minuteDelta, revertFunc) {
                      
					   $.ajax({
								type: 'post',
								cache: false,
								url: '<?php echo site_url('/').'calendar/extend_event/';?>',
								data: {
									id: event.id,
									days: dayDelta, 
									minutes:  minuteDelta
									},
								success: function (data) {
									$('#event_change_msg').html(data);
								}
							});
            },//end resize
						
			eventDrop: function(event,dayDelta,minuteDelta,allDay,revertFunc) {

				$('#modal-event-change').bind('show', function() {
					
					$('#event_change_msg').html('');
					removeBtn = $(this).find('.btn-primary'),
		
					removeBtn.unbind('click').click(function(e) {
						
						e.preventDefault();
						
							removeBtn.html('Changing Event...');
							$.ajax({
								type: 'post',
								cache: false,
								url: '<?php echo site_url('/').'calendar/change_event/';?>',
								data: {
									id: event.id,
									days: dayDelta, 
									minutes:  minuteDelta,
									allday: allDay
									},
								success: function (data) {
									$('#event_change_msg').html(data);
									removeBtn.html('Change');
									 
								}
							});
					});
				}).modal({ backdrop: true });
				
				//if (!confirm("Are you sure about this change?")) {
					//revertFunc();
				//}
				revertFunc();
			},

			editable: false,
			
			
			events:[ <?php $this->main_model->get_events();?>]
					
			

		});

		

	});

function show_event(id){
	
	var eventa = $('#event_body');
	$('#event_title').html('');
	eventa.html('<img style="display: block; margin-left: auto; margin-right: auto; " src="<?php echo base_url('/').'img/loading_img.gif" />';?>');
	$('#modal-event-show').unbind('show').bind('show', function() {
				//var id = $(this).data('id'),

							$.ajax({
								type: 'get',
								url: '<?php echo site_url('/').'calendar/show_event_edit/';?>'+id ,
								success: function (data) {
							       
									eventa.html(data); 
								}
							});
												
			
				}).modal({ backdrop: true });
	
}


</script>    
