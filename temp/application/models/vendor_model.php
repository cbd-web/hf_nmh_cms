<?php
class Vendor_model extends CI_Model{
	
 	function vendor_model(){
  		//parent::CI_model();
	    $this->load->library('encrypt');
		
 	}



	//+++++++++++++++++++++++++++
	//GET TOWNS
	//++++++++++++++++++++++++++
	public function get_town_option($town)
	{

		$query = $this->db->get('nam_towns');
		if($query->result()){


			foreach($query->result() as $row){

				if($town == $row->town) { $selected = 'selected="selected"'; } else { $selected = ''; }
				echo '<option value="'.$row->town.'" '.$selected.'>'.$row->town.'</option>';

			}


		}else{

		}
	}


	//+++++++++++++++++++++++++++
	//GET TOWNS
	//++++++++++++++++++++++++++
	public function get_region_option($region)
	{

		$query = $this->db->get('regions');
		if($query->result()){


			foreach($query->result() as $row){

				if($region == $row->region) { $selected = 'selected="selected"'; } else { $selected = ''; }
				echo '<option value="'.$row->region.'" '.$selected.'>'.$row->region.'</option>';

			}


		}else{

		}
	}


	//+++++++++++++++++++++++++++
	//GET VENDOR DETAILS
	//++++++++++++++++++++++++++

	function get_vendor($id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('vendor_id', $id);
		$query = $this->db->get('vendors');

		return $query->row_array();

	}

	//+++++++++++++++++++++++++++
	//GET VENDOR CATEGORY LIST
	//++++++++++++++++++++++++++
	public function get_all_vendor_cat_option($cid)
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('vendor_categories');
		if($query->result()){


			foreach($query->result() as $row){

				if($cid == $row->cat_id) { $selected = 'selected="selected"'; } else { $selected = ''; }
				echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$row->cat_name.'</option>';

			}


		}else{

		}
	}


	function get_vendor_features($vid) {

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('vendor_id', $vid);
		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->get('vendor_features');

		if($query->result()){

			echo'<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:40%;font-weight:normal">Title</th>
           				<th style="width:40%;font-weight:normal">Body</th>
						<th style="width:20%;font-weight:normal; text-align: right">Action</th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr class="myDragClass" id="tab-'.$row->feature_id.'">

						<td style="width:40%"><input type="hidden" value="'.$row->feature_id.'" />'.$row->title.'</td>
						<td style="width:40%">'.$row->body.'</td>
						<td style="width:20%;text-align:right">
							<a title="Edit Feature" rel="tooltip" class="btn btn-mini" style="cursor:pointer" onclick="update_feature('.$row->feature_id.')"><i class="icon-pencil"></i></a>
							<a title="Delete Feature" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_feature('.$row->feature_id.')"><i class="icon-trash icon-white"></i></a></td>

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
									var feat_id = $(this).val(), index = i;

									 $.ajax({
										type: "post",

										url: "'. site_url('/').'vendor/update_feature_sequence/"+feat_id+"/"+index ,
										success: function (data) {

										}
								});

							  });


						}

					}).disableSelection();
				</script>';


		}else{
			echo '<div class="alert">
			 		<h3>No Features added</h3>
					No vendor features have been added. To add a new feature please click on the "Add Vendor Feature" button </div>';

		}

	}


	//+++++++++++++++++++++++++++
	//ADD VENDOR FEATURE
	//++++++++++++++++++++++++++
	function add_vendor_feature()
	{
		$id = $this->input->post('vendor_id', TRUE);
		$title = $this->input->post('title', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$bus_id = $this->session->userdata('bus_id');


		$insertdata = array(
			'title'=> $title ,
			'body'=> $body ,
			'bus_id'=> $bus_id,
			'vendor_id'=> $id
		);


		$this->db->insert('vendor_features', $insertdata);

		//LOG
		$this->admin_model->system_log('add_vendor_feature'.$id);
		$data['basicmsg'] = 'Vendor Feature has been added successfully';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						noty(options);</script>";

	}


	//+++++++++++++++
	//DELETE VENDOR FEATURE
	//+++++++++++++++

	public function delete_vendor_feature($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('feature_id', $id);
		$this->db->delete('vendor_features');

	}



	//+++++++++++++++
	//DELETE VENDOR
	//+++++++++++++++

	public function delete_vendor($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('vendor_id', $id);
		$this->db->delete('vendors');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('vendor_id', $id);
		$this->db->delete('vendor_features');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('vendor_id', $id);
		$this->db->delete('vendor_types_int');

	}



	//+++++++++++++++++++++++++++
	//ADD VENDOR DO
	//++++++++++++++++++++++++++
	function add_vendor_do()
	{
		$title = $this->input->post('title', TRUE);
		$price_from = $this->input->post('price_from', TRUE);
		$price_to = $this->input->post('price_to', TRUE);
		$tel = $this->input->post('tel', TRUE);
		$cell = $this->input->post('cell', TRUE);
		$fax = $this->input->post('fax', TRUE);
		$email = $this->input->post('email', TRUE);
		$website = $this->input->post('website', TRUE);
		$postal = $this->input->post('postal', TRUE);
		$address = $this->input->post('address', TRUE);

		$region = $this->input->post('region', TRUE);
		$town = $this->input->post('town', TRUE);

		$cat_id = $this->input->post('cat_id', TRUE);
		$facebook = $this->input->post('facebook', TRUE);
		$google_plus = $this->input->post('google_plus', TRUE);
		$instagram = $this->input->post('instagram', TRUE);
		$youtube = $this->input->post('youtube', TRUE);
		$twitter = $this->input->post('twitter', TRUE);
		$flickr = $this->input->post('flickr', TRUE);
		$pinterest = $this->input->post('pinterest', TRUE);



		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

		$slug = $this->clean_url_str($title);

		$bus_id = $this->session->userdata('bus_id');

		$val = TRUE;

		$insertdata = array(
			'title'=> $title ,
			'price_from'=> $price_from,
			'price_to'=> $price_to,
			'slug'=> $slug ,
			'tel'=> $tel ,
			'cell'=> $cell ,
			'fax'=> $fax ,
			'email'=> $email ,
			'website'=> $website ,
			'postal'=> $postal ,
			'address'=> $address ,
			'region'=> $region ,
			'town'=> $town ,
			'facebook'=> $facebook ,
			'google_plus'=> $google_plus ,
			'instagram'=> $instagram ,
			'youtube'=> $youtube ,
			'twitter'=> $twitter ,
			'flickr'=> $flickr ,
			'pinterest'=> $pinterest ,
			'body'=> $body ,
			'cat_id'=> $cat_id ,
			'lat' => '-22.5632824',
			'lng' => '17.0707275',
			'bus_id'=>$bus_id
		);


		if($val == TRUE){

			$this->db->insert('vendors', $insertdata);
			$vendorid = $this->db->insert_id();
			//LOG
			$this->admin_model->system_log('add_new_vendor-'.$title);
			//success redirect
			$this->session->set_flashdata('msg','Vendor added successfully');
			$data['basicmsg'] = 'Vendor has been added successfully';

			echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'vendor/update_vendor/'.$vendorid.'/";
					</script>
					';
		}else{
			$data['id'] = $this->session->userdata('id');
			$data['error'] = $error;
			echo '<div class="alert alert-error">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['error'].'</div>';
			$this->output->set_header("HTTP/1.0 200 OK");

		}
	}


	//+++++++++++++++++++++++++++
	//UPDATE MAP
	//++++++++++++++++++++++++++
	function update_map()
	{

		$lat = $this->input->post('lat', TRUE);
		$lng = $this->input->post('lng', TRUE);
		$id = $this->input->post('vendor_id', TRUE);
		$bus_id = $this->session->userdata('bus_id');


		$insertdata = array(
			'lat'=> $lat ,
			'lng'=> $lng
		);


		$this->db->where('vendor_id' , $id);
		$this->db->update('vendors', $insertdata);

		//LOG
		$this->admin_model->system_log('update_vendor_map'.$id);
		$data['basicmsg'] = 'Vendor Map has been updated successfully';
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						noty(options);</script>";

	}




	//+++++++++++++++++++++++++++
	//UPDATE VENDOR
	//++++++++++++++++++++++++++
	function update_vendor_do()
	{

		$title = $this->input->post('title', TRUE);
		$price_from = $this->input->post('price_from', TRUE);
		$price_to = $this->input->post('price_to', TRUE);
		$tel = $this->input->post('tel', TRUE);
		$cat_id = $this->input->post('cat_id', TRUE);
		$cell = $this->input->post('cell', TRUE);
		$fax = $this->input->post('fax', TRUE);
		$email = $this->input->post('email', TRUE);
		$website = $this->input->post('website', TRUE);
		$postal = $this->input->post('postal', TRUE);
		$address = $this->input->post('address', TRUE);

		$region = $this->input->post('region', TRUE);
		$town = $this->input->post('town', TRUE);

		$status = $this->input->post('status', TRUE);
		$facebook = $this->input->post('facebook', TRUE);
		$google_plus = $this->input->post('google_plus', TRUE);
		$instagram = $this->input->post('instagram', TRUE);
		$youtube = $this->input->post('youtube', TRUE);
		$twitter = $this->input->post('twitter', TRUE);
		$flickr = $this->input->post('flickr', TRUE);
		$pinterest = $this->input->post('pinterest', TRUE);

		$featured = $this->input->post('featured', TRUE);

		$extras = $this->input->post('extras', TRUE);


		$body = html_entity_decode(str_replace('&nbsp;', ' ', $this->input->post('content', FALSE)));

		$id = $this->input->post('vendor_id', TRUE);

		$slug = $this->clean_url_str($title);

		$bus_id = $this->session->userdata('bus_id');


		$this->db->where('bus_id', $bus_id);
		$this->db->where('vendor_id', $id);
		$this->db->delete('vendor_types_int');

		if($extras != '') {

			foreach ($extras as $group_a) {

				$group_array = explode(';', $group_a);

				$group_name = $group_array[0];
				$group_type = $group_array[1];

				$insertdata = array(
					'bus_id' => $bus_id,
					'vendor_id' => $id,
					'group_name' => $group_name,
					'group_type' => $group_type

				);

				$this->db->insert('vendor_types_int', $insertdata);

			}
		}


		//VALIDATE INPUT

		if(!filter_var( $email, FILTER_VALIDATE_EMAIL )){
			$val = FALSE;
			$error = 'Email address is not valid.';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'cat_id'=> $cat_id ,
			'featured'=> $featured,
			'title'=> $title ,
			'price_from'=> $price_from,
			'price_to'=> $price_to,
			'slug'=> $slug ,
			'tel'=> $tel ,
			'cell'=> $cell ,
			'fax'=> $fax ,
			'email'=> $email ,
			'website'=> $website ,
			'postal'=> $postal ,
			'address'=> $address ,
			'region'=> $region ,
			'town'=> $town ,
			'facebook'=> $facebook ,
			'google_plus'=> $google_plus ,
			'instagram'=> $instagram ,
			'youtube'=> $youtube ,
			'twitter'=> $twitter ,
			'flickr'=> $flickr ,
			'pinterest'=> $pinterest ,
			'body'=> $body ,
			'status'=> strtolower($status)
		);



		if($val == TRUE){


			$this->db->where('vendor_id' , $id);
			$this->db->update('vendors', $insertdata);




			//LOG
			$this->admin_model->system_log('update_vendor'.$title);
			$data['basicmsg'] = 'Vendor has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}


	//+++++++++++++++++++++++++++
	//GET VENDOR GROUPS
	//++++++++++++++++++++++++++
	public function get_vendor_groups($id, $vid)
	{
		$query = $this->db->query("SELECT * FROM vendor_cat_type_groups WHERE cat_id = '".$id."'");

		if($query->result()){

			foreach($query->result() as $row){

				$types = $this->get_group_types_option($row->group_id, $row->title, $vid);

				echo '
					<div class="control-group" >
						<label class="control-label">'.$row->title.'</label>
						<div class="controls">
							'.$types.'
						</div>
					</div>
				';

			}

		}
	}

	function get_group_types_option($id, $group_title, $vid) {

		$query = $this->db->query("SELECT * FROM vendor_group_types WHERE group_id = '".$id."' ORDER BY sequence ASC");

		$str = '';

		if($query->result()){

			foreach($query->result() as $row) {

				$checked = $this->check_group_type_select($row->title, $vid);

				$str .= '<input name="extras[]" type="checkbox" value="'.$group_title.';'.$row->title.'" '.$checked.'> '.$row->title.'</br>';

			}
		}

		return $str;

	}


	function check_group_type_select($title, $vid) {

		$query = $this->db->query("SELECT id FROM vendor_types_int WHERE vendor_id = '".$vid."' AND group_type = '".$title."'");

		if($query->result()) {

			return 'checked';

		} else {

			return '';

		}


	}


	//+++++++++++++++++++++++++++
	//GET ALL VENDORS
	//++++++++++++++++++++++++++
	public function get_all_vendors()
	{
		$bus_id = $this->session->userdata('bus_id');


		$query = $this->db->query("SELECT * FROM vendors AS A
		  						   LEFT JOIN vendor_categories AS B on A.cat_id = B.cat_id
								   WHERE A.bus_id = '".$bus_id."' ORDER BY A.listing_date ASC
								   ");

		if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:30%;font-weight:normal">Category </th>
						<th style="width:20%;font-weight:normal">Listing Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr id="row-'.$row->vendor_id.'">
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer"href="'.site_url('/').'vendor/update_vendor/'.$row->vendor_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:30%">'.$row->cat_name.'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit product" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'vendor/update_vendor/'.$row->vendor_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Vendor" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_vendor('.$row->vendor_id.')">
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
			 		<h3>No Vendors added</h3>
					No vendors have been added. to add a new vendor please click on the add vendor button on the right</div>';

		}


	}


	function get_cat_groups($id) {

		$query = $this->db->query("SELECT * FROM vendor_cat_type_groups WHERE cat_id = '".$id."'");

		if($query->result()){

			foreach($query->result() as $row){

				$types = $this->get_group_types($row->group_id);

				echo '
				<div class="box span4">
					<div class="box-header">
						<h2><i class="icon-th"></i><span class="break"></span>'.$row->title.'</h2>
						<div class="box-icon">
							<a href="#" onclick="delete_group('.$row->group_id.')" ><i class="icon-remove"></i></a>
						</div>
					</div>
					<div class="box-content">

                       <form id="group_type_add_'.$row->group_id.'" name="group_type_add_'.$row->group_id.'" method="post" action="'.site_url('/').'vendor/add_group_type" class="form-inline">
                             <fieldset>
    						  <input type="hidden" name="group_id"  value="'.$row->group_id.'">
                            <div class="input-append span12">
                              <input class="span8" type="text" name="title" placeholder="Group type" value="">
                              <button class="btn btn-inverse btn type_btn" id="btn_group_'.$row->group_id.'" data-id="'.$row->group_id.'" type="button"><i class="icon-plus-sign icon-white"></i> Add Type</button>
                            </div>
                            <div class="clearfix" style="height:30px;"></div>
                           </fieldset>
                        </form>

						<div id="curr_types_'.$row->group_id.'">'.$types.'</div>

					</div>
				</div>
				';

			}




			echo "
			<script>
			$('.type_btn').click(function() {

			  var group_id = $(this).attr('data-id');

					var frm = $('#group_type_add_'+group_id);

					$('#btn_group_'+group_id).html(\"<img src='".base_url('/')."admin_src/img/loading_white.gif' /> Working...\");
					$.ajax({
					type: 'post',
					data: frm.serialize(),
					url: '".site_url('/')."vendor/add_group_type',
					success: function (data) {

					$('#result_msg').html(data);
					$('#btn_group_'+group_id).html('<i class=\"icon-plus-sign icon-white\"></i> Add Type');

					reload_group_types(group_id);

					var options = {'text':'Type added successfully','layout':'bottomLeft','type':'success'};
					noty(options);
					}
					});

			});

			function delete_group_type(id){

				$('#modal-type-delete').bind('show', function() {

					removeBtn = $(this).find('.del_btn');

					removeBtn.unbind('click').click(function(e) {
						e.preventDefault();
						$.ajax({
							url: '".site_url('/')."vendor/delete_group_type/'+id,
							success: function(data) {

								$('footer').html(data);
								$('#modal-type-delete').modal('hide');

								$('#row-'+id).remove();

							}
						});

					});

				}).modal({ backdrop: true });
			}


			function reload_group_types(group_id) {

					$.ajax({
						type: 'get',
						url: '".site_url('/')."vendor/reload_group_types/'+group_id ,
						success: function (data) {

							 $('#curr_types_'+group_id).html(data);
							 $('.datatable').dataTable({
								\"sDom\": \"<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>\",
								\"sPaginationType\": \"bootstrap\",
								\"oLanguage\": {
								\"sLengthMenu\": \"_MENU_\"
								}
							} );
						}
					});

			}

			</script>
			";

		}




	}

	function get_group_types($id) {

		$query = $this->db->query("SELECT * FROM vendor_group_types WHERE group_id = '".$id."' ORDER BY sequence ASC");

		$str = '';

		if($query->result()){

			$str.= '

				<table id="sortable" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:80%;font-weight:normal">Type </th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){


				$str.= '
					  <tr id="row-'.$row->type_id.'">
						<td style="width:80%">'.$row->title.'</td>
						<td style="width:20%;text-align:right">
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_group_type('.$row->type_id.')">
						<i class="icon-trash icon-white"></i></a></td>
					  </tr>
				';

			}

			$str.= '
				</tbody>
				</table>
				<hr />
				<div class="clearfix" style="height:30px;"></div>

			';

		} else {

			$str = '<div class="alert">No Types Added</div>';

		}

		return $str;

	}


	//+++++++++++++++
	//DELETE GROUP TYPE
	//+++++++++++++++

	public function delete_group_type($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('type_id', $id);
		$this->db->delete('vendor_group_types');

	}


	//+++++++++++++++
	//DELETE GROUP
	//+++++++++++++++

	public function delete_group($id)
	{

		$bus_id = $this->session->userdata('bus_id');


		$this->db->where('bus_id', $bus_id);
		$this->db->where('group_id', $id);
		$this->db->delete('vendor_cat_type_groups');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('group_id', $id);
		$this->db->delete('vendor_group_types');

	}




	//+++++++++++++++++++++++++++
	//GET CATEGORY DETAILS
	//++++++++++++++++++++++++++

	function get_category($id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('cat_id', $id);
		$query = $this->db->get('vendor_categories');

		return $query->row_array();

	}

	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('vendor_categories');
		if($query->result()){
			echo'

			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
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
						<td style="width:6%">'.$row->cat_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->cat_name.'</div></td>
            			<td style="width:15%;text-align:right">
            			<a title="Edit Category" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'vendor/update_category/'.$row->cat_id.'"><i class="icon-pencil"></i></a>
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
	//UPDATE CATEGORY DO
	//++++++++++++++++++++++++++
	function update_category_do()
	{
		$cat_name = $this->input->post('cat_name', TRUE);
		$cat_body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$slug = $this->clean_url_str($cat_name);
		$id = $this->input->post('cat_id', TRUE);

		$val = TRUE;

		$insertdata = array(
			'cat_name'=> $cat_name ,
			'cat_body'=> $cat_body ,
			'slug'=> $slug
		);



		if($val == TRUE){

			$this->db->where('cat_id' , $id);
			$this->db->update('vendor_categories', $insertdata);

			//success redirect
			$data['cat_id'] = $id;

			//LOG
			$this->admin_model->system_log('update-vendor-category-'. $id);
			$data['basicmsg'] = 'Vendor category has been updated successfully';
			echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";

		}else{

			echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";

		}
	}


	//+++++++++++++++
	//DELETE CATEGORY
	//+++++++++++++++

	public function delete_category($id)
	{

		$bus_id = $this->session->userdata('bus_id');

		$this->db->where('cat_id', $id);
		$this->db->where('bus_id', $bus_id);
		$query = $this->db->get('vendor_cat_type_groups');

		if($query->result()) {

			foreach($query->result() as $row){

				$this->db->where('bus_id', $bus_id);
				$this->db->where('group_id', $row->group_id);
				$this->db->delete('vendor_group_types');

			}

		}


		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_id', $id);
		$this->db->delete('vendor_categories');

		$this->db->where('bus_id', $bus_id);
		$this->db->where('cat_id', $id);
		$this->db->delete('vendor_cat_type_groups');

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
		$result1 = $this->db->get('vendor_categories');

		if($result1->num_rows() == 0){

			$insertdata = array(
				'cat_name'=> $cat_name ,
				'slug'=> $slug ,
				'bus_id'=> $bus_id,
			);

			$this->db->insert('vendor_categories', $insertdata);
		}


	}

	//Get Main Categories Typehead
	function load_category_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('vendor_categories');

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


	//+++++++++++++++
	//ADD GROUP
	//+++++++++++++++
	public function add_group()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$title = $this->input->post('title');
		$cat_id = $this->input->post('cat_id');


		$insertdata = array(
			'title'=> $title ,
			'cat_id'=> $cat_id ,
			'bus_id'=> $bus_id,
		);

		$this->db->insert('vendor_cat_type_groups', $insertdata);



	}

	//+++++++++++++++
	//ADD CATEGORY
	//+++++++++++++++
	public function add_group_type()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$title = $this->input->post('title');
		$group_id = $this->input->post('group_id');

		$slug = $this->clean_url_str($title);


		//TEST DUPLICATE CATEGORIES
		$this->db->where('title', $title);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('vendor_group_types');

		if($result1->num_rows() == 0){

			$insertdata = array(
				'title'=> $title ,
				'group_id'=> $group_id ,
				'slug'=> $slug ,
				'bus_id'=> $bus_id,
			);

			$this->db->insert('vendor_group_types', $insertdata);
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
	
	

	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	
	
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