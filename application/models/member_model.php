<?php
class Member_model extends CI_Model
{

	function member_model()
	{
		//parent::CI_model();

	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //members
	 * //END
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */


	//+++++++++++++++++++++++++++
	//GET member DETAILS
	//+++++++++++++++++++++++++++
	function get_member($member_id)
	{

		$query = $this->db->where('member_id', $member_id);
		$query = $this->db->get('members');
		return $query->row_array();

	}


	//+++++++++++++++++++++++++++
	//GET ALL members
	//++++++++++++++++++++++++++
	public function get_all_members()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('members');

		if ($query->result()) {
			echo '
			<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
							<th style="width:20%;font-weight:normal">Name </th>
						<th style="width:34%;font-weight:normal">Type </th>
						<th style="width:15%;font-weight:normal">Membership Number</th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach ($query->result() as $row) {

				$status = '<span class="label label-success">Live</span>';

				if ($row->status == 'draft') {
					$status = '<span class="label label-warning">Draft</span>';
				}

				echo '<tr class="myDragClass"> 
					<input type="hidden" value="' . $row->member_id . '" />
					<td style="width:6%">' . $status . '</td>
					<td style="width:20%"><a style="cursor:pointer" 
					href="' . site_url('/') . 'member/update_member/' . $row->member_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->title . ' ' . $row->name . ' ' . $row->name . '</div></a></td>
					<td style="width:15%">' . $row->type . '</td>
					<td style="width:34%">' . $row->membership_number . '</td>
					<td style="width:15%;text-align:right">
					<a title="Edit member" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
					href="' . site_url('/') . 'member/update_member/' . $row->member_id . '"><i class="icon-pencil"></i></a>
					<a title="Delete member" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_member(' . $row->member_id . ')">
					<i class="icon-trash icon-white"></i></a></td>
				  </tr>';
			}

			echo '</tbody>
			</table>
			<hr />
			<div class="clearfix" style="height:30px;"></div>
			<script type="text/javascript">
				// Return a helper with preserved width of cells
				var fixHelper = function(e, ui) {
					ui.children().each(function() {
						$(this).width($(this).width());
					});
					return ui;
				};

				$("#sortable tbody").sortable({
					helper: fixHelper,
					connectWith: "tr",
					start: function(e, info) {

					},
					stop: function(e, info) {

						//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
						info.item.after(info.item.parents("tr"));
						var sibs = $("#sortable tbody").find("input:hidden");

						sibs.each(function(i,item){
								var advert_id = $(this).val(), index = i;
								console.log(member_id+" "+index);
								$.ajax({
									type: "post",

									url: "' . site_url('/') . 'member/update_member_sequence/"+member_id+"/"+index ,
									success: function (data) {

									}

							});

						});

					}

				}).disableSelection();
			</script>';

		} else {

			echo '<div class="alert">
		 		<h3>No members added</h3>
				No members have been added. to add a new member please click on the add member button on the right</div>';

		}

	}


	//+++++++++++++++++++++++++++
	//ADD member DO
	//++++++++++++++++++++++++++	
	function add_member_do()
	{
		$title = $this->input->post('title', TRUE);
		$middle_name = $this->input->post('middle_name', TRUE);
		$name = $this->input->post('name', TRUE);
		$type = $this->input->post('membership_type', TRUE);
		$membership_number = $this->input->post('membership_number', TRUE);
		$sequence = 0;
		$bus_id = $this->session->userdata('bus_id');


		//VALIDATE INPUT
		if ($name == '') {
			$val = FALSE;
			$error = 'Member Name Required';
		} elseif (!$this->session->userdata('admin_id')) {

			$val = FALSE;
			$error = 'You are logged out. Please sign in again.';
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Page Content Required';	

		} else {
			$val = TRUE;
		}

		$insertdata = array(
			'title' => $title,
			'middle_name' => $middle_name,
			'name' => $name,
			'type' => $type,
			'membership_number' => $membership_number,
			'sequence' => $sequence,
			'bus_id' => $bus_id,
			'status' => 'draft',
		);

		if ($val == TRUE) {

			$this->db->insert('members', $insertdata);
			$memberid = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_member-' . $name);
			//success redirect	
			$this->session->set_flashdata('msg', 'member added successfully');
			$data['basicmsg'] = 'Accountant has been added successfully';
			echo "
				<script type='text/javascript'>
				var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
			            noty(options);
				window.location = '" . site_url('/') . "member/update_member/" . $memberid . "/';
				</script>
				";

		} else {
			$data['id'] = $this->session->userdata('id');
			$data['error'] = $error;
			echo "
				<script type='text/javascript'>
				var options = {'text':'" . $data['error'] . "','layout':'bottomLeft','type':'error'};
			            noty(options);
				
				</script>
				";
			$this->output->set_header("HTTP/1.0 200 OK");
		}
	}

	function get_hod($hod)
	{

		$bus_id = $this->session->userdata('bus_id');
		$this->db->order_by('name', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('people');


		if ($query->result()) {
			foreach ($query->result() as $row) {
				echo '<option value="' . $row->people_id . '" ' . (($row->people_id == $hod) ? 'selected' : '') . '>' . $row->name . ' ' . $row->lname . '</option>';
			}
		} else {

			echo '<div class="alert"> No People Added</div>';

		}


	}
	//+++++++++++++++++++++++++++
	//UPDATE member DO
	//++++++++++++++++++++++++++++	
	function update_member_do()
	{
		$title = $this->input->post('title');
		$middle_name = $this->input->post('middle_name');
		$surname = $this->input->post('surname');
		$name = $this->input->post('name');
		$type = $this->input->post('type');
		$membership_number = $this->input->post('membership_number');
		$sequence = $this->input->post('sequence');
		$bus_id = $this->input->post('bus_id');
		$id = $this->input->post('member_id');
		$status = $this->input->post('status');

		//VALIDATE INPUT
		if ($name == '') {
			$val = FALSE;
			$error = 'Memeber Name Required';

		} elseif (!$this->session->userdata('admin_id')) {

			$val = FALSE;
			$error = 'You are logged out. Please sign in again.';
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			/*}elseif(strip_tags($body) == ''){
																																																										$val = FALSE;
																																																										$error = 'Page Content Required';*/

		} else {
			$val = TRUE;
		}

		$insertdata = array(

			'title' => $title,
			'middle_name' => $middle_name,
			'surname' => $surname,
			'name' => $name,
			'type' => $type,
			'membership_number' => $membership_number,
			'sequence' => $sequence,
			'bus_id' => $bus_id,
			'status' => strtolower($status)
		);

		if ($val == TRUE) {

			$this->db->where('member_id', $id);
			$this->db->update('members', $insertdata);
			//success redirect	
			$data['member_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_member-' . $id);

			$data['basicmsg'] = 'Accountant has been updated successfully';
			echo "<script>var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		} else {

			echo "<script>var options = {'text':'" . $error . "','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}



	//+++++++++++++++++++++++++++
	//DELETE member
	//++++++++++++++++++++++++++++	
	function delete_member($member_id)
	{

		if ($this->session->userdata('admin_id')) {

			$bus_id = $this->session->userdata('bus_id');

			//delete from database
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('member_id', $member_id);
			$query = $this->db->delete('members');


			//LOG
			$this->admin_model->system_log('delete_member-' . $member_id);
			$this->session->set_flashdata('msg', 'member deleted successfully');
			echo '<script type="text/javascript">
			   window.location = "' . site_url('/') . 'member/members/";
			  </script>';


		} else {

			redirect(site_url('/') . 'admin/logout/', 'refresh');

		}
	}


	//Get Main member Typehead
	function load_member_typehead()
	{

		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('members');

		$result = 'var subjects = [';
		$x = 0;
		foreach ($test->result() as $row) {

			$id = $row->member_id;
			$member = $row->title;

			if ($x == ($test->num_rows() - 1)) {

				$str = '';

			} else {

				$str = ' , ';

			}

			$result .= "'" . $member . "' " . $str;
			$x++;

		}

		$result .= '];';
		return $result;

	}

	//Get categories for sidebar
	function get_members_current($type_id, $type)
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('type', $type);
		$query = $this->db->where('type_id', $type_id);
		$query = $this->db->get('member_content_int');

		if ($query->result()) {

			foreach ($query->result() as $row) {

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_member(' . $row->bc_id . ')"><i class="icon-remove icon-white"></i> ' . $row->member . '</span>';

			}

		} else {

			echo '<div class="alert"> No members added</div>';

		}

	}

	//++++++++++++++++++++++++++++++++++++++++
	//ADD member AND INTERSECTION FOR PRODUCT
	//++++++++++++++++++++++++++++++++++++++++

	public function add_member_item()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO members
		$data['title'] = $this->input->post('member_name');
		$data['bus_id'] = $bus_id;
		$type_id = $this->input->post('type_id');
		$type = $this->input->post('type');

		//TEST DUPLICATE members
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('members');

		if ($result1->num_rows() == 0) {
			$this->db->insert('members', $data);
		}

		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('members');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('member', $data['cat_name']);
		$this->db->where('type', $type);
		$this->db->where('type_id', $type_id);
		$result = $this->db->get('member_content_int');

		if ($result->num_rows() == 0) {
			//INSERT INTO INTERSECTION TABLE
			$data2['member_id'] = $row['member_id'];
			$data2['type_id'] = $type_id;
			$data2['type'] = $type;
			$data2['member'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('member_content_int', $data2);
		}

	}


	//DELETE member PRODUCT
	public function delete_member_item($id)
	{
		$this->db->where('bc_id', $id);
		$this->db->delete('member_content_int');

	}



	//Shorten String
	function shorten_string($phrase, $max_words)
	{

		$phrase_array = explode(' ', $phrase);

		if (count($phrase_array) > $max_words && $max_words > 0) {

			$phrase = implode(' ', array_slice($phrase_array, 0, $max_words)) . '...';
		}

		return $phrase;

	}


	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_url_str($str, $replace = array(), $delimiter = '-')
	{
		if (!empty($replace)) {
			$str = str_replace((array) $replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		return $clean;
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_slug_str($str, $replace = array(), $delimiter = '-', $type)
	{
		if (!empty($replace)) {
			$str = str_replace((array) $replace, ' ', $str);
		}

		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);

		//test Databse
		//$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$this->db->where('slug', $clean);
		$res = $this->db->get($type);

		if ($res->result()) {

			$clean = $clean . '-' . rand(0, 99);
			return $clean;

		} else {

			return $clean;
		}

	}

}
?>