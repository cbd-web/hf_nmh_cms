<?php
class Event_model extends CI_Model
{

	function event_model()
	{
		//parent::CI_model();

	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //EVENTS
	 * //END
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */


	function get_event($event_id){

		$test = $this->db->from('calendar_events');
		$test = $this->db->where('event_id', $event_id);

		$test = $this->db->get();
		$test = $test->row_array();
		return $test;
	}


	public function get_all_events()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('startdate', 'DESC');
		$query = $this->db->get('calendar_events');

		if ($query->result()) {
			echo '<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
           				<th style="width:10%;font-weight:normal">Type </th>
						<th style="width:20%;font-weight:normal">Start Date </th>
						<th style="width:20%;font-weight:normal">End Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {
				$status = '<span class="label label-success">Live</span>';
				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr>
						<td style="width:6%">' . $status . '</td>
						<td style="width:30%"><a style="cursor:pointer"
						href="' . site_url('/') . 'event/update_event/' . $row->event_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . '</div></a></td>
						<td style="width:10%">' . $row->type . '</td>
						<td style="width:20%">' . date('Y-m-d', strtotime($row->startdate)) . '</td>
						<td style="width:20%">' . date('Y-m-d', strtotime($row->enddate)) . '</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Event" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="' . site_url('/') . 'event/update_event/' . $row->event_id . '"><i class="icon-pencil"></i></a>
						<a title="Delete Event" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_event(' . $row->event_id . ')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

				</script>';

		} else {

			echo '<div class="alert">
			 		<h3>No Entries added</h3>
					No Entries have been added. to add a new entry please click on the add event button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//ADD EVENT DO
	//++++++++++++++++++++++++++
	function add_event_do()
	{
		$description = $this->input->post('description',FALSE);
		$title = $this->input->post('title', TRUE);
		$heading = $this->input->post('heading', TRUE);
		$location = $this->input->post('location', TRUE);

		$venue = $this->input->post('venue', TRUE);
		$contact = $this->input->post('contact', TRUE);
		$duration = $this->input->post('duration', TRUE);

		$startdate = $this->input->post('startdate', TRUE);
		$enddate = $this->input->post('enddate', TRUE);
		$web_link = $this->input->post('web_link', TRUE);

		$startdate = date("Y-m-d H:i:s", strtotime($startdate));
		$enddate = date("Y-m-d H:i:s", strtotime($enddate));

		$sd = date("Y-m-d", strtotime($startdate));
		$ed = date("Y-m-d", strtotime($enddate));

		$datetime1 = new DateTime($sd);
		$datetime2 = new DateTime($ed);

		if($datetime2 > $datetime1) { $allday = 'true'; } else {  $allday = 'false'; }

		if($datetime1 > $datetime2) { $val = FALSE; $error = 'ERROR: Please make sure your end date is larger that your start date'; } else { $val = TRUE; }

		$type = $this->input->post('type', TRUE);
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);

		$creator = $this->session->userdata('u_name');
		$url = "javascript:show_event('')";

		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);

		$insertdata = array(
			'title'=> $title ,
			'heading'=> $heading ,
			'startdate'=> $startdate,
			'enddate'=> $enddate,
			'allday'=> $allday ,
			'web_link'=> $web_link ,
			'description'=> html_entity_decode($description),
			'slug'=> $slug,
			'location' => $location,
			'venue' => $venue,
			'duration' => $duration,
			'contact' => $contact,
			'url' => $url,
			'creator' => $creator,
			'type' => strtolower($type),
			'metaT' => $metaT,
			'metaD' => $metaD,
			'bus_id'=> $bus_id
		);


		if ($val == TRUE) {

			$this->db->insert('calendar_events', $insertdata);
			$id = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_event-' . $title);
			//success redirect
			$this->session->set_flashdata('msg', 'Event added successfully');
			$data['basicmsg'] = 'Event has been added successfully';

			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['basicmsg'] . '</div>
					<script type="text/javascript">
					window.location = "' . site_url('/') . 'event/update_event/' . $id . '/";
					</script>
					';
		} else {
			$data['id'] = $this->session->userdata('id');
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		' . $data['error'] . '</div>';
			$this->output->set_header("HTTP/1.0 200 OK");

		}
	}



	//+++++++++++++++++++++++++++
	//UPDATE EVENT
	//++++++++++++++++++++++++++
	function update_event_do()
	{
		$id = $this->input->post('event_id',FALSE);
		$description = $this->input->post('description',FALSE);
		$title = $this->input->post('title', TRUE);
		$heading = $this->input->post('heading', TRUE);
		$location = $this->input->post('location', TRUE);
		$venue = $this->input->post('venue', TRUE);
		$contact = $this->input->post('contact', TRUE);
		$duration = $this->input->post('duration', TRUE);
		$startdate = $this->input->post('startdate', TRUE);
		$enddate = $this->input->post('enddate', TRUE);
		$web_link = $this->input->post('web_link', TRUE);

		$startdate = date("Y-m-d H:i:s", strtotime($startdate));
		$enddate = date("Y-m-d H:i:s", strtotime($enddate));

		$sd = date("Y-m-d", strtotime($startdate));
		$ed = date("Y-m-d", strtotime($enddate));

		$datetime1 = new DateTime($sd);
		$datetime2 = new DateTime($ed);

		if($datetime2 > $datetime1) { $allday = 'true'; } else {  $allday = 'false'; }

		if($datetime1 > $datetime2) { $val = FALSE; $error = 'ERROR: Please make sure your end date is larger that your start date'; } else { $val = TRUE; }

		$type = $this->input->post('type', TRUE);
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);

		$creator = $this->session->userdata('u_name');
		$url = "javascript:show_event('')";

		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);

		$status = $this->input->post('status', TRUE);

		$insertdata = array(
			'title'=> $title ,
			'heading'=> $heading ,
			'status'=> $status,
			'startdate'=> $startdate,
			'enddate'=> $enddate,
			'allday'=> $allday ,
			'web_link'=> $web_link ,
			'description'=> html_entity_decode($description),
			'slug'=> $slug,
			'location' => $location,
			'venue' => $venue,
			'duration' => $duration,
			'contact' => $contact,
			'url' => $url,
			'type' => strtolower($type),
			'metaT' => $metaT,
			'metaD' => $metaD,
			'bus_id'=> $bus_id
		);



		if($val == TRUE){

			$this->db->where('event_id' , $id);
			$this->db->update('calendar_events', $insertdata);
			//success redirect
			$data['event_id'] = $id;

			//LOG
			$this->admin_model->system_log('update-event-'. $id);
			$data['basicmsg'] = 'Event has been updated successfully'.strtolower($status);
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}






	public function add_category()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO TOPICS
		$data['title'] = $this->input->post('category');
		$data['bus_id'] = $bus_id;

		//TEST DUPLICATE CATEGORIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('event_categories');

		if($result1->num_rows() == 0){
			$this->db->insert('event_categories', $data);
		}


	}

	public function delete_category($id)
	{
		$this->db->where('cat_id', $id);
		$this->db->delete('event_categories');

	}

	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('event_categories');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>
						<input type="hidden" value="'.$row->cat_id.'" />
						<td style="width:6%">'.$row->cat_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					.$row->title.'</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_event_category('.$row->cat_id.')">
						<i class="icon-trash icon-white"></i></a></td>

					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>';

		}else{

			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';
		}


	}

	//DELETE EVENT
	function delete_event($id){

		if($this->session->userdata('admin_id')){

			$bus_id = $this->session->userdata('bus_id');

			//delete from database
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('event_id', $id);
			$this->db->delete('calendar_events');


			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('event_id', $id);
			$this->db->delete('events_cat_int');

			//LOG
			$this->admin_model->system_log('delete_event-'.$id);
			$this->session->set_flashdata('msg','Event deleted successfully');
			echo '<script type="text/javascript">
				   window.location = "'.site_url('/').'event/events/";
				  </script>';


		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}


	//+++++++++++++++++++++++++++
	//GET CATEGORY
	//++++++++++++++++++++++++++

	function get_category($cat_id){

		$cat = $this->db->select('title');
		$cat = $this->db->where('cat_id', $cat_id);
		$cat = $this->db->get('event_categories');

		if($cat->result()){

			$row = $cat->row();

			return $row->title;

		} else {

			return 'none';

		}

	}


	public function add_event_category()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$data['title'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$event_id = $this->input->post('event_id_cat');

		//TEST DUPLICATE CATEGORIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('event_categories');

		if($result1->num_rows() == 0){
			$this->db->insert('event_categories', $data);
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('event_categories');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('event_id', $event_id);
		$result = $this->db->get('events_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['cat_id'] = $row['cat_id'];
			$data2['event_id'] = $event_id;
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('events_cat_int', $data2);
		}

	}

	//DELETE CATEGIRY EVENT
	public function delete_category_event($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('events_cat_int');

	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY OPTION LIST
	//++++++++++++++++++++++++++
	public function get_category_option_list()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('event_categories');
		if($query->result()){

			foreach($query->result() as $row){
				echo '<option value="'.$row->cat_id.'">'.$row->title.'</option>';
			}

		}else{

		}

	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY OPTION SELECT LIST
	//++++++++++++++++++++++++++
	public function get_category_option_select_list($id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('event_categories');
		if($query->result()){


			foreach($query->result() as $row){

				if($id == $row->cat_id) { $sel = 'selected'; } else { $sel = ''; }

				echo '<option value="'.$row->cat_id.'" '.$sel.'>'.$row->title.'</option>';
			}


		}else{

		}

	}


	//Get Main Categories Typehead
	function load_category_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('event_categories');

		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){

			$id = $row->cat_id;
			$cat = $row->title;

			if($x == ($test->num_rows()-1)){

				$str = '';

			}else{

				$str = ' , ';

			}

			$result .= "'".$cat."' ". $str;
			$x ++;

		}

		$result .= '];';
		return $result;

	}


	//Get categories for sidebar
	function get_categories_current($event_id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('event_id', $event_id);
		$query = $this->db->get('events_cat_int');
		if($query->result()){

			foreach($query->result() as $row){

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category('.$row->id.')"><i class="icon-remove icon-white"></i> '.$row->title.'</span>';

			}


		}else{

			echo '<div class="alert"> No Categories added</div>';

		}


	}


	//Shorten String
	function shorten_string($phrase, $max_words) {

		$phrase_array = explode(' ',$phrase);

		if(count($phrase_array) > $max_words && $max_words > 0){

			$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}

		return $phrase;

	}


	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace=array(), $delimiter='-') {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}

}
?>