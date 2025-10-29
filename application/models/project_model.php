<?php
class Project_model extends CI_Model{
	
 	function project_model(){
  		//parent::CI_model();
			
 	}


	//+++++++++++++++++++++++++++
	//GET PROJECT DETAILS
	//++++++++++++++++++++++++++

	function get_project($project_id){

		$test = $this->db->where('project_id', $project_id);
		$test = $this->db->get('projects');
		return $test->row_array();

	}



	//+++++++++++++++++++++++++++
	//GET TESTIMONIALS
	//++++++++++++++++++++++++++
	public function get_all_testimonials($project_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('project_id', $project_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('project_testimonials');

		if($query->result()){
			echo'<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->testimonial_id.'">
						<input type="hidden" value="'.$row->testimonial_id.'" />
						<td style="width:80%"><div style="top:0;left:0;right:0;bottom:0;border:none"><strong>'.$row->title.'</strong></div><div>'.$row->body.'</div></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_testimonial('.$row->testimonial_id.')">
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

					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {

						},
						stop: function(e, info) {

						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");

							  sibs.each(function(i,item){
									var id = $(this).val(), index = i;

									 $.ajax({
										type: "post",

										url: "'. site_url('/').'project/update_testimonial_sequence/"+id+"/'.$project_id.'/"+index ,
										success: function (data) {

										}
								});

							  });


						}

					}).disableSelection();
				</script>';

		}else{

			echo '<div class="alert">
			 		<h3>No Testimonials added</h3>
					No testimonials have been added.
				   </div>';

		}


	}


	//+++++++++++++++++++++++++++
	//ADD TESTIMONIAL DO
	//++++++++++++++++++++++++++

	public function add_testimonial_do()
	{

		$bus_id = $this->session->userdata('bus_id');
		//INSERT INTO TABLE
		$data['bus_id'] = $bus_id;

		$project_id = $this->input->post('project_id');
		$title = $this->input->post('t_title');
		$body = $this->input->post('testimonial');


		$insertdata = array(
			'project_id'=> $project_id ,
			'title'=> $title ,
			'body'=> $body ,
			'bus_id'=>$bus_id
		);


		$this->db->insert('project_testimonials', $insertdata);


	}

	//+++++++++++++++++++++++++++
	//DELETE TESTIMONIAL DO
	//++++++++++++++++++++++++++
	function delete_testimonial_do($id){

		if($this->session->userdata('admin_id')) {

			$bus_id = $this->session->userdata('bus_id');

			$this->db->where('bus_id', $bus_id);
			$this->db->where('testimonial_id', $id);
			$this->db->delete('project_testimonials');

			//LOG
			$this->admin_model->system_log('delete_project_testimonial-'.$id);
			$this->session->set_flashdata('msg','Testimonial deleted successfully');

		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}





	//+++++++++++++++++++++++++++
	//GET PAGE PEOPLE
	//++++++++++++++++++++++++++
	public function get_all_people($project_id)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('project_id', $project_id);
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('project_people_int');

		if($query->result()){
			echo'<table id="sortable1" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Name </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="row-'.$row->id.'">
						<input type="hidden" value="'.$row->id.'" />
						<td style="width:80%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->name.'</div></td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_people('.$row->id.')">
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

					$("#sortable1 tbody").sortable({
						helper: fixHelper,
						connectWith: "tr",
						start: function(e, info) {

						},
						stop: function(e, info) {

						  	//console.log("stop:"+info.item.html()+" "+$(this).find("input:hidden").val());
							info.item.after(info.item.parents("tr"));
							 var sibs = $("#sortable1 tbody").find("input:hidden");

							  sibs.each(function(i,item){
									var id = $(this).val(), index = i;

									 $.ajax({
										type: "post",

										url: "'. site_url('/').'project/update_people_sequence/"+id+"/'.$project_id.'/"+index ,
										success: function (data) {

										}
								});

							  });


						}

					}).disableSelection();
				</script>';

		}else{

			echo '<div class="alert">
			 		<h3>No People added</h3>
					No people have been added.
				   </div>';

		}


	}



	//+++++++++++++++++++++++++++
	//GET PEOPLE SELECT
	//++++++++++++++++++++++++++
	public function get_people_select()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('people');

		if($query->result()){

			foreach($query->result() as $row){
				echo '<option value="'.$row->people_id.'">'.$row->name.' '.$row->lname.'</option>';
			}


		}else{

			echo '';

		}
	}


	//+++++++++++++++++++++++++++
	//ADD PAGE PEOPLE DO
	//++++++++++++++++++++++++++

	public function add_people_do()
	{

		$bus_id = $this->session->userdata('bus_id');
		//INSERT INTO TABLE
		$data['bus_id'] = $bus_id;

		$project_id = $this->input->post('project_id');
		$people_id = $this->input->post('people');


		//TEST DUPLICATE INTERSECTION
		$this->db->where('people_id', $people_id);
		$this->db->where('project_id', $project_id);
		$result = $this->db->get('project_people_int');


		if($result->num_rows() == 0){

			//GET NAME
			$this->db->select('lname');
			$this->db->select('name');
			$this->db->where('people_id', $people_id);
			$query = $this->db->get('people');
			$row = $query->row();
			$name = $row->name.' '.$row->lname;

			//INSERT INTO INTERSECTION TABLE
			$data2['people_id'] = $people_id;
			$data2['project_id'] = $project_id;
			$data2['name'] = $name;
			$data2['bus_id'] = $bus_id;
			$this->db->insert('project_people_int', $data2);
		}

	}

	//+++++++++++++++++++++++++++
	//DELETE PEOPLE DO
	//++++++++++++++++++++++++++
	function delete_people_do($id){

		if($this->session->userdata('admin_id')) {

			$bus_id = $this->session->userdata('bus_id');

			$this->db->where('bus_id', $bus_id);
			$this->db->where('id', $id);
			$this->db->delete('project_people_int');

			//LOG
			$this->admin_model->system_log('delete_project_person-'.$id);
			$this->session->set_flashdata('msg','Person deleted successfully');

		}else{

			redirect(site_url('/').'admin/logout/','refresh');

		}
	}



	//LOAD PEOPLE TYPEHEAD
	function load_people_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('people');

		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){

			$id = $row->people_id;
			$cat = $row->name.' '.$row->lname;

			if($x == ($query->num_rows()-1)){

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






	//+++++++++++++++++++++++++++
	//GET ALL PROJECTS
	//++++++++++++++++++++++++++
	public function get_all_projects()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->query("SELECT * FROM projects AS a

								   LEFT JOIN project_clients AS b ON a.client_id = b.client_id

								   WHERE a.bus_id = '".$bus_id."' ORDER BY a.review ASC", FALSE);


		if($query->result()){

			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:34%;font-weight:normal">Title </th>
						<th style="width:30%;font-weight:normal">Client </th>
						<th style="width:10%;font-weight:normal">Type</th>
						<th style="width:10%;font-weight:normal">Date</th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				switch($row->type) {
					case '0':
						$type = 'None';
						break;
					case '1':
						$type = 'Current';
						break;
					case '2':
						$type = 'Completed';
						break;
					case '3':
						$type = 'For Sale';
						break;
				}

				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}

				echo '<tr>
						<td style="width:6%">'.$status.'</td>
						<td style="width:34%"><a style="cursor:pointer" href="'.site_url('/').'project/update_project/'.$row->project_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
            			<td style="width:30%">'.$row->client_name.'</td>
						<td style="width:10%">'.$type.'</td>
						<td style="width:10%">'.date('Y-m-d',strtotime($row->review)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit project" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'project/update_project/'.$row->project_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Project" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_project('.$row->project_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}

			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

				</script>';

		}else{

			echo '<div class="alert">
			 		<h3>No Projects added</h3>
					No projects have been added. To add a new project please click on the add project button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//GET MANUFACTURER DETAILS
	//++++++++++++++++++++++++++

	function get_client($client_id){
		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('client_id', $client_id);
		$test = $this->db->get('project_clients');
		return $test->row_array();

	}


	//+++++++++++++++++++++++++++
	//GET ALL CLIENTS
	//++++++++++++++++++++++++++
	public function get_all_clients()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('project_clients');
		if($query->result()){
			echo'

			<table cellpadding="0" id="sortable" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Client </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr class="myDragClass">
					  <input type="hidden" value="'.$row->client_id.'" />
						<td style="width:6%">'.$row->client_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->client_name.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Edit client" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'project/update_client/'.$row->client_id.'"><i class="icon-pencil"></i></a>
            			<a title="Delete client" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_client('.$row->client_id.')">
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
									var client_id = $(this).val(), index = i;
									 $.ajax({
										type: "post",

										url: "'. site_url('/').'project/update_client_sequence/"+client_id+"/"+index ,
										success: function (data) {

										}
								});

							  });


						}

					}).disableSelection();
				</script>';

		}else{

			echo '<div class="alert"><h3>No Clients added</h3> No clients have been added. Add one by using the tool on the right</div>';
		}


	}

	//+++++++++++++++++++
	//DELETE CLIENT
	//+++++++++++++++++++

	public function delete_client($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('client_id', $id);
		$this->db->delete('project_clients');

	}


	//+++++++++++++++
	//ADD CLIENT
	//+++++++++++++++
	public function add_client()
	{
		$bus_id = $this->session->userdata('bus_id');


		//INSERT INTO CATEGORIES
		$client = $this->input->post('client');

		$slug = $this->clean_url_str($client);


		//TEST DUPLICATE
		$this->db->where('client_name', $client);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('project_clients');

		if($result1->num_rows() == 0){

			$insertdata = array(
				'client_name'=> $client ,
				'slug'=> $slug ,
				'bus_id'=> $bus_id,
			);

			$this->db->insert('project_clients', $insertdata);
		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE CLIENT
	//++++++++++++++++++++++++++
	function update_client_do()
	{
		$client = $this->input->post('client', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$website = $this->input->post('website', TRUE);
		$email = $this->input->post('email', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$id = $this->input->post('client_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$input = trim($website, '/');

		if($website != "") {
			// If scheme not included, prepend it
			if (!preg_match('#^http(s)?://#', $input)) {
				$website = 'http://' . $input;
			}
		} else {

			$website = "";

		}



		//VALIDATE INPUT
		if($client == ''){
			$val = FALSE;
			$error = 'Client name required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'client_name'=> $client ,
			'body'=> $body ,
			'website'=> $website ,
			'email'=> $email ,
			'slug'=> $slug,
			'metaD'=> $metaD,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$this->db->where('client_id' , $id);
			$this->db->update('project_clients', $insertdata);
			//success redirect
			$data['client_id'] = $id;

			//LOG
			$this->admin_model->system_log('update_client-'. $id);
			$data['basicmsg'] = 'Client has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}




	//Get Client Typehead
	function load_client_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('project_clients');

		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){

			$id = $row->client_id;
			$cat = $row->client_name;

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






	//+++++++++++++++++++++++++++
	//GET PROJECT CLIENTS
	//++++++++++++++++++++++++++
	public function get_project_clients($client_id=0)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('project_clients');


		if($query->result()){

			foreach($query->result() as $row){


				if($client_id == $row->client_id) { $selected = "selected"; }	else { 	$selected = ""; }


				echo '<option value="'.$row->client_id.'" '.$selected.'>'.$row->client_name.'</option>';
			}

		}

	}





	//+++++++++++++++
	//ADD CATEGORY
	//+++++++++++++++
	public function add_category()
	{
		$bus_id = $this->session->userdata('bus_id');


		//INSERT INTO CATEGORIES
		$cat_name = $this->input->post('category_name');

		$slug = $this->clean_url_str($cat_name);


		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $cat_name);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('pub_categories');

		if($result1->num_rows() == 0){

			$insertdata = array(
				'cat_name'=> $cat_name ,
				'slug'=> $slug ,
				'bus_id'=> $bus_id,
			);

			$this->db->insert('project_categories', $insertdata);
		}

		//GET NEW CAT ID
		/*		$this->db->where('cat_name', $data['cat_name']);
                $this->db->where('bus_id', $bus_id);
                $result = $this->db->get('categories');
                $row = $result->row_array();*/


	}

	//Get Main Categories Typehead
	function load_category_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('project_categories');

		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){

			$id = $row->cat_id;
			$cat = $row->cat_name;

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
	function get_categories_current($project_id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('project_id', $project_id);
		$query = $this->db->get('project_cat_int');
		if($query->result()){

			foreach($query->result() as $row){

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category('.$row->id.')"><i class="icon-remove icon-white"></i> '.$row->cat_name.'</span>';

			}


		}else{

			echo '<div class="alert"> No Categories added</div>';

		}


	}

	//+++++++++++++++++++++++++++
	//ADD CATEGORY AND INTERSECTION FOR MEMBER
	//++++++++++++++++++++++++++

	public function add_category_project()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$data['cat_name'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$project_id = $this->input->post('project_id_cat');

		//TEST DUPLICATE CATEGORIES
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('project_categories');

		if($result1->num_rows() == 0){
			$this->db->insert('project_categories', $data);
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_name', $data['cat_name']);
		$result = $this->db->get('project_categories');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('cat_name', $data['cat_name']);
		$this->db->where('project_id', $project_id);
		$result = $this->db->get('project_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['cat_id'] = $row['cat_id'];
			$data2['project_id'] = $project_id;
			$data2['cat_name'] = $data['cat_name'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('project_cat_int', $data2);
		}

	}


	//DELETE CATEGIRY PROJECT
	public function delete_category_project($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('project_cat_int');

	}

	//+++++++++++++++
	//DELETE CATEGORY
	//+++++++++++++++

	public function delete_category($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_id', $id);
		$this->db->delete('project_categories');

	}

	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('project_categories');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
           				<th style="width:40%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>
						<td style="width:5%">'.$row->cat_id.'</td>
						<td style="width:40%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->cat_name.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Edit category" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'project/update_category/'.$row->cat_id.'"><i class="icon-pencil"></i></a>
            			<a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_category('.$row->cat_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}


			echo '</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">

				</script>';

		}else{

			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';
		}


	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY DETAILS
	//++++++++++++++++++++++++++

	function get_category($category_id){
		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->where('cat_id', $category_id);
		$test = $this->db->get('project_categories');
		return $test->row_array();

	}

	//+++++++++++++++++++++++++++
	//UPDATE CATEGORY
	//++++++++++++++++++++++++++
	function update_category_do()
	{
		$cat_name = $this->input->post('cat_name', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$id = $this->input->post('cat_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');


		//VALIDATE INPUT
		if($cat_name == ''){
			$val = FALSE;
			$error = 'Category title Required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif(strip_tags($body) == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'cat_name'=> $cat_name ,
			'body'=> $body ,
			'slug'=> $slug,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$this->db->where('cat_id' , $id);
			$this->db->update('project_categories', $insertdata);
			//success redirect

			//LOG
			$this->admin_model->system_log('update_project_category-'. $id);
			$data['basicmsg'] = 'Category has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

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