<?php
class Accountant_model extends CI_Model
{

	function accountant_model()
	{
		//parent::CI_model();

	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //accountants
	 * //END
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */


	//+++++++++++++++++++++++++++
	//GET accountant DETAILS
	//+++++++++++++++++++++++++++
	function get_accountant($accountant_id)
	{

		$query = $this->db->where('accountant_id', $accountant_id);
		$query = $this->db->get('accountants');
		return $query->row_array();

	}


	//+++++++++++++++++++++++++++
	//GET ALL accountants
	//++++++++++++++++++++++++++
	public function get_all_accountants()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('accountants');

		if ($query->result()) {
			echo '
			<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
							<th style="width:20%;font-weight:normal">Name </th>
						<th style="width:34%;font-weight:normal">Email </th>
						<th style="width:15%;font-weight:normal">Company</th>
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
					<input type="hidden" value="' . $row->accountant_id . '" />
					<td style="width:6%">' . $status . '</td>
					<td style="width:20%"><a style="cursor:pointer" 
					href="' . site_url('/') . 'accountant/update_accountant/' . $row->accountant_id . '"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					. $row->name . '</div></a></td>
					<td style="width:34%">' . $row->email . '</td>
					<td style="width:15%">' . $row->company . '</td>
					<td style="width:15%;text-align:right">
					<a title="Edit accountant" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
					href="' . site_url('/') . 'accountant/update_accountant/' . $row->accountant_id . '"><i class="icon-pencil"></i></a>
					<a title="Delete accountant" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_accountant(' . $row->accountant_id . ')">
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
								console.log(accountant_id+" "+index);
								$.ajax({
									type: "post",

									url: "' . site_url('/') . 'accountant/update_accountant_sequence/"+accountant_id+"/"+index ,
									success: function (data) {

									}

							});

						});

					}

				}).disableSelection();
			</script>';

		} else {

			echo '<div class="alert">
		 		<h3>No accountants added</h3>
				No accountants have been added. to add a new accountant please click on the add accountant button on the right</div>';

		}

	}


	//+++++++++++++++++++++++++++
	//ADD accountant DO
	//++++++++++++++++++++++++++	
	function add_accountant_do()
	{
		$company = $this->input->post('company', TRUE);
		$name = $this->input->post('name', TRUE);
		$email = $this->input->post('email', TRUE);
		$sequence = 0;
		$bus_id = $this->session->userdata('bus_id');


		//VALIDATE INPUT
		if ($company == '') {
			$val = FALSE;
			$error = 'Accountant Name Required';
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
			'company' => $company,
			'name' => $name,
			'email' => $email,
			'sequence' => $sequence,
			'bus_id' => $bus_id
		);

		if ($val == TRUE) {

			$this->db->insert('accountants', $insertdata);
			$accountantid = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_accountant-' . $company);
			//success redirect	
			$this->session->set_flashdata('msg', 'accountant added successfully');
			$data['basicmsg'] = 'Accountant has been added successfully';
			echo "
				<script type='text/javascript'>
				var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
			            noty(options);
				window.location = '" . site_url('/') . "accountant/update_accountant/" . $accountantid . "/';
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
	//UPDATE accountant DO
	//++++++++++++++++++++++++++++	
	function update_accountant_do()
	{
		$company = $this->input->post('company', TRUE);
		$name = $this->input->post('name', TRUE);
		$status = $this->input->post('status', TRUE);
		$name = $this->input->post('name', TRUE);
		$email = $this->input->post('email', TRUE);
		$id = $this->input->post('accountant_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');
		$sequence = $this->input->post('sequence', TRUE) != '' ? $this->input->post('sequence', TRUE) : 0;

		//VALIDATE INPUT
		if ($company == '') {
			$val = FALSE;
			$error = 'Company Name Required';

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
			'company' => $company,
			'name' => $name,
			'status' => strtolower($status),
			'email' => $email,
			'bus_id' => $bus_id,
			'sequence' => $sequence,
		);

		if ($val == TRUE) {

			$this->db->where('accountant_id', $id);
			$this->db->update('accountants', $insertdata);
			//success redirect	
			$data['accountant_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_accountant-' . $id);

			$data['basicmsg'] = 'Accountant has been updated successfully';
			echo "<script>var options = {'text':'" . $data['basicmsg'] . "','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		} else {

			echo "<script>var options = {'text':'" . $error . "','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}



	//+++++++++++++++++++++++++++
	//DELETE accountant
	//++++++++++++++++++++++++++++	
	function delete_accountant($accountant_id)
	{

		if ($this->session->userdata('admin_id')) {

			$bus_id = $this->session->userdata('bus_id');

			//delete from database
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('accountant_id', $accountant_id);
			$query = $this->db->delete('accountants');


			//LOG
			$this->admin_model->system_log('delete_accountant-' . $accountant_id);
			$this->session->set_flashdata('msg', 'accountant deleted successfully');
			echo '<script type="text/javascript">
			   window.location = "' . site_url('/') . 'accountant/accountants/";
			  </script>';


		} else {

			redirect(site_url('/') . 'admin/logout/', 'refresh');

		}
	}


	//Get Main accountant Typehead
	function load_accountant_typehead()
	{

		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('accountants');

		$result = 'var subjects = [';
		$x = 0;
		foreach ($test->result() as $row) {

			$id = $row->accountant_id;
			$accountant = $row->title;

			if ($x == ($test->num_rows() - 1)) {

				$str = '';

			} else {

				$str = ' , ';

			}

			$result .= "'" . $accountant . "' " . $str;
			$x++;

		}

		$result .= '];';
		return $result;

	}

	//Get categories for sidebar
	function get_accountants_current($type_id, $type)
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('type', $type);
		$query = $this->db->where('type_id', $type_id);
		$query = $this->db->get('accountant_content_int');

		if ($query->result()) {

			foreach ($query->result() as $row) {

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_accountant(' . $row->bc_id . ')"><i class="icon-remove icon-white"></i> ' . $row->accountant . '</span>';

			}

		} else {

			echo '<div class="alert"> No accountants added</div>';

		}

	}

	//++++++++++++++++++++++++++++++++++++++++
	//ADD accountant AND INTERSECTION FOR PRODUCT
	//++++++++++++++++++++++++++++++++++++++++

	public function add_accountant_item()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO accountants
		$data['title'] = $this->input->post('accountant_name');
		$data['bus_id'] = $bus_id;
		$type_id = $this->input->post('type_id');
		$type = $this->input->post('type');

		//TEST DUPLICATE accountants
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('accountants');

		if ($result1->num_rows() == 0) {
			$this->db->insert('accountants', $data);
		}

		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('accountants');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('accountant', $data['cat_name']);
		$this->db->where('type', $type);
		$this->db->where('type_id', $type_id);
		$result = $this->db->get('accountant_content_int');

		if ($result->num_rows() == 0) {
			//INSERT INTO INTERSECTION TABLE
			$data2['accountant_id'] = $row['accountant_id'];
			$data2['type_id'] = $type_id;
			$data2['type'] = $type;
			$data2['accountant'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('accountant_content_int', $data2);
		}

	}


	//DELETE accountant PRODUCT
	public function delete_accountant_item($id)
	{
		$this->db->where('bc_id', $id);
		$this->db->delete('accountant_content_int');

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