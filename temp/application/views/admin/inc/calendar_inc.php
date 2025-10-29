<div class="popover top" style="left:20%;top:10%" id="modal-event-msg">
  <a onclick="javascript:$('#modal-event-msg').hide()" style="float:right;margin:2px 5px 0 0 " class="close">&times;</a> 
  <div class="arrow"></div>
    <div class="popover-content">
      <p id="event_modal_msg"></p>
    </div>
    
</div>

<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//ADD EVENT
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
 <div id="modal-event" class="modal hide fade">
    <div class="modal-header">
      <a onclick="javascript:$('#modal-event').modal('hide')" class="close">&times;</a>
      <h3>Add New Event</h3>
    </div>
    <div class="modal-body">
      <p>To add a new event please give it a title, short description and set if it should be visible to parents</p>
       <form id="add_event" method="post"> 
       	  <input type="text" class="span5" id="title" name="title" placeholder="Event title..." />
          
            <div class="btn-group pull-right" data-toggle="buttons-radio">
              <button type="button" class="btn active">Public</button>
              <button type="button" class="btn">Internal</button>
            </div>
            <div class="clearfix" style="height:40px"></div>
          <input type="hidden" id="type" name="type" value="public"/>
          <input type="hidden" id="add_start" name="add_start" value=""/>
          <input type="hidden" id="add_allday" name="add_allday" value=""/>
          <input type="hidden" id="add_end" name="add_start" value=""/>
          <textarea id="redactor_content" name="content"></textarea>
      </form>
    </div>
    <div class="modal-footer">
      <a onclick="javascript:add_event()" id="btn_add" class="btn btn-primary" >Add Event</a>
      <a onclick="javascript:$('#modal-event').modal('hide')" class="btn secondary">Cancel</a>
    </div>
</div>


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
<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//CHANGE EVENT
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>
 <div id="modal-event-change" class="modal hide fade">
    <div class="modal-header">
      <a onclick="javascript:$('#modal-event-change').modal('hide')" class="close">&times;</a>
      <h3>Change the Event</h3>
    </div>
    <div class="modal-body">
      <p>Are you sure you want to change the Event?</p>
       <p id="event_change_msg"></p>
    </div>
    <div class="modal-footer"> 
      <a class="btn btn-primary"><i class="icon-pencil"></i> Change</a> 
      <a onclick="javascript:$('#modal-event-change').modal('hide')" class="btn">Close</a>
    </div>
</div>

<?php   /**
++++++++++++++++++++++++++++++++++++++++++++
//MODAL MESSAGE
++++++++++++++++++++++++++++++++++++++++++++	
 */  
 ?>

    
    <script type='text/javascript' src="<?php echo base_url('/');?>admin_src/redactor/plugins/fullscreen.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontcolor.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontsize.js"></script>
    <script src="<?php echo base_url('/');?>admin_src/redactor/plugins/fontfamily.js"></script>
	<script type='text/javascript'>

	$(document).ready(function() {
 		
		//Fire editor
		$('#redactor_content').redactor({ 	
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
 
		var date = new Date();
		//date = date.setDate(date.getDate() - 3);
		var d = date.getDate();

		var m = date.getMonth();

		var y = date.getFullYear();

		var calendar = $('#main_calendar').fullCalendar({
			
			height: 650, 
			contentHeight: 600,
			header: {
				left: 'title',
				right: 'prev,next today,month,agendaWeek,agendaDay'
			},
			
			selectable: true,

			selectHelper: true,

			select: function(start, end, allDay) {
				
				//var testdate = start;
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

			editable: true,
			
			
			events:[ <?php $this->calendar_model->get_events();?>]
					
			

		});

		

	});
	
$('div.btn-group button').bind('click', function(){

   $("#type").attr('value', $(this).html());
})

function show_event(id){
	
	var eventa = $('#event_body');
	$('#event_title').html('');
	eventa.html('<img style="display: block; margin-left: auto; margin-right: auto; " src="<?php echo base_url('/').'admin_src/img/loading_img.gif" />';?>');
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


function reload_calendar(){
	
			$('#main_calendar').empty().addClass('loading_img');
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'calendar/reload/';?>',
				success: function (data) {

					$('#cal_script').html(data);
					
					$('#redactor_content').redactor({ 	
						buttons: ['html', '|', 'formatting', '|', 'bold', 'italic', 'deleted', '|', 
						'unorderedlist', 'orderedlist', 'outdent', 'indent', '|',
						'table', 'link', '|',
						'fontcolor', 'backcolor', '|', 'alignment', '|', 'horizontalrule']	
					});
					$('[rel=tooltip]').tooltip();
					$('#main_calendar').removeClass('loading_img'); 
					reload_upcoming(); 
				}
			});
												

}

function reload_upcoming(){
	

			$('#upcoming_events').addClass('loading_img'); 
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'calendar/reload_upcoming/';?>',
				success: function (data) {

					$('#upcoming_events').html(data);
					$('#upcoming_events').removeClass('loading_img'); 
					$('[rel=tooltip]').tooltip();  
				}
			});
												

}

function delete_story(id){
	  
			$('#edit_btn').html('Removing...')
			$.ajax({
				type: 'get',
				url: '<?php echo site_url('/').'calendar/delete_event/';?>'+id,
				success: function (data) {
					
					$('#edit_btn').html('<i class="icon-remove"></i> Delete')
					$('#modal-event-show').modal('hide');
					reload_calendar();
				}
			});
	
}

function add_event(){

		  //do the database magic
		  var title = $('#title').val();
		  var start = $('#add_start').val();
		  var end = $('#add_end').val();
		  var allDay = $('#add_allday').val();
		  var content = $('#redactor_content').val();
		  var etype = $('#type').val();
		  //$('#content').html(content);
		  
			  $('#btn_add').html('Adding Event...');
			  $.ajax({
				  type: 'post',
				  url: '<?php echo site_url('/').'calendar/add_event/';?>' ,
				  data: {
					  title: title, 
					  description: content, 
					  startdate: start, 
					  enddate: end, 
					  allday: allDay,
					  type: etype
					  },
				  success: function (data) {
					  
					  reload_calendar();
					  $('#modal-event').modal('hide');
					  $('#btn_add').html('Event Added'); 
				  }
			  });

}
</script>    
