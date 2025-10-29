<?php
class Branch_model extends CI_Model
{

	function branch_model()
	{
		//parent::CI_model();

	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //BRANCHES
	 * //END
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */


	//+++++++++++++++++++++++++++
	//GET BRANCH DETAILS
	//+++++++++++++++++++++++++++
	function get_branch($branch_id){

		$query = $this->db->where('branch_id', $branch_id);
		$query = $this->db->get('branches');
		return $query->row_array();	

	}


	//+++++++++++++++++++++++++++
	//GET ALL BRANCHES
	//++++++++++++++++++++++++++
	public function get_all_branches()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->order_by('sequence','ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('branches');

		if($query->result()){
			echo'
			<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
							<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:34%;font-weight:normal">Body </th>
						<th style="width:15%;font-weight:normal">Listing date</th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

		foreach($query->result() as $row){

			$status = '<span class="label label-success">Live</span>';

			if($row->status == 'draft'){
				$status = '<span class="label label-warning">Draft</span>';
			}

			echo '<tr class="myDragClass"> 
					<input type="hidden" value="'.$row->branch_id.'" />
					<td style="width:6%">'.$status.'</td>
					<td style="width:20%"><a style="cursor:pointer" 
					href="'.site_url('/').'branch/update_branch/'.$row->branch_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					.$row->title.'</div></a></td>
					<td style="width:34%">'.substr(strip_tags($row->body),0,80).'</td>
					<td style="width:15%">'.date('M d Y',strtotime($row->listing_date)).'</td>
					<td style="width:15%;text-align:right">
					<a title="Edit Branch" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
					href="'.site_url('/').'branch/update_branch/'.$row->branch_id.'"><i class="icon-pencil"></i></a>
					<a title="Delete Branch" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_branch('.$row->branch_id.')">
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
								console.log(branch_id+" "+index);
								$.ajax({
									type: "post",

									url: "'. site_url('/').'branch/update_branch_sequence/"+branch_id+"/"+index ,
									success: function (data) {

									}

							});

						});

					}

				}).disableSelection();
			</script>';

		}else{
		 
		 echo '<div class="alert">
		 		<h3>No Branches added</h3>
				No branches have been added. to add a new branch please click on the add branch button on the right</div>';

		}
		
	}


	//+++++++++++++++++++++++++++
	//ADD BRANCH DO
	//++++++++++++++++++++++++++	
	function add_branch_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$bus_id = $this->session->userdata('bus_id');
	  
		if($slug == ''){
			
			$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'branches');
				
		}else{
			
			$slug = $this->clean_url_str($slug);
			
		}
		
		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Branch Title Required';
		}elseif(!$this->session->userdata('admin_id')){
			
			$val = FALSE;
			$error = 'You are logged out. Please sign in again.';
		//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
				
//			}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Page Content Required';	
						
		}else{
			$val = TRUE;
		}
		
			$insertdata = array(
			  'title'=> $title,
			  'body'=> $body,
			  'metaD'=> $metaD,
			  'metaT'=> $metaT,
			  'slug'=> $slug,
			  'bus_id'=>$bus_id
			);

		if($val == TRUE){

				$this->db->insert('branches', $insertdata);
				$branchid = $this->db->insert_id();
				//LOG
				$this->admin_model->system_log('add_new_branch-'.$title);
				//success redirect	
				$this->session->set_flashdata('msg','Branch added successfully');
				$data['basicmsg'] = 'Branch has been added successfully';
				echo "
				<script type='text/javascript'>
				var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
			            noty(options);
				window.location = '".site_url('/')."branch/update_branch/".$branchid."/';
				</script>
				";

		}else{
				$data['id'] = $this->session->userdata('id');
				$data['error'] = $error;
				echo "
				<script type='text/javascript'>
				var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
			            noty(options);
				
				</script>
				";
				$this->output->set_header("HTTP/1.0 200 OK");
		}
	}


	 //+++++++++++++++++++++++++++
	//UPDATE BRANCH DO
	//++++++++++++++++++++++++++++	
	function update_branch_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);		
			$status = $this->input->post('status', TRUE);
			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$programs  = $this->input->post('programs', TRUE);
			$activities  = $this->input->post('activities', TRUE);
			$facilities  = $this->input->post('facilities', TRUE);
			$pictures  = $this->input->post('pictures', TRUE);
			$head  = $this->input->post('head', TRUE);
			$link  = $this->input->post('link', TRUE);
			$location  = $this->input->post('location', TRUE);
			$Email  = $this->input->post('email', TRUE);
			$Phone  = $this->input->post('phone', TRUE);
			$Address  = $this->input->post('address', TRUE);
			$googleMap  = $this->input->post('googleMap', TRUE);
			$id = $this->input->post('branch_id', TRUE);
		 	$bus_id = $this->session->userdata('bus_id');
			$sequence = $this->input->post('sequence', TRUE);
			
			if($slug == ''){
				
				$slug = $this->clean_url_str($title);
					
			}else{
				
				$slug = $this->clean_url_str($slug);
				
			}
			
			//VALIDATE INPUT
			if($title == ''){
				$val = FALSE;
				$error = 'Branch Title Required';
			
			}elseif(!$this->session->userdata('admin_id')){
				
				$val = FALSE;
				$error = 'You are logged out. Please sign in again.';		
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			/*}elseif(strip_tags($body) == ''){
				$val = FALSE;
				$error = 'Page Content Required';*/	
							
			}else{
				$val = TRUE;
			}
			
				$insertdata = array(
				  'title'=> $title ,
				  'status'=> strtolower($status),
				  'body'=> $body,
				  'programs' => $programs,
				  'activities' => $activities,
				  'facilities' => $facilities,
				  'head' => $head,
				  'link' => $link,
				  'Email' => $Email,
				  'Phone' => $Phone,
				  'Address' => $Address,
				  'googleMap' => $googleMap,
				  'metaD'=> $metaD,
				  'metaT'=> $metaT,
				  'slug'=> $slug ,								  
				  'bus_id'=>$bus_id,
				  'sequence'=> $sequence
				);

			if($val == TRUE){
				
					$this->db->where('branch_id' , $id);
					$this->db->update('branches', $insertdata);
					//success redirect	
					$data['branch_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_branch-'. $id);

					$data['basicmsg'] = 'Branch has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}


	
	//+++++++++++++++++++++++++++
	//DELETE BRANCH
	//++++++++++++++++++++++++++++	
	function delete_branch($branch_id){
      	
		if($this->session->userdata('admin_id')){

			$bus_id = $this->session->userdata('bus_id');

			//delete from database
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('branch_id', $branch_id);
			$query =  $this->db->delete('branches');

			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('branch_id', $branch_id);
			$this->db->delete('branch_content_int');

			//LOG
			$this->admin_model->system_log('delete_branch-'.$branch_id);
			$this->session->set_flashdata('msg','Branch deleted successfully');
			echo '<script type="text/javascript">
			   window.location = "'.site_url('/').'branch/branches/";
			  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }


	//Get Main Branch Typehead
	function load_branch_typehead(){

		$bus_id = $this->session->userdata('bus_id');

		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('branches');

		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){

			$id = $row->branch_id;
			$branch = $row->title;

			if($x == ($test->num_rows()-1)){

				$str = '';

			}else{

				$str = ' , ';

			}

			$result .= "'".$branch."' ". $str;
			$x ++;

		}

		$result .= '];';
		return $result;

	}

	//Get categories for sidebar
	function get_branches_current($type_id, $type){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('type', $type);
		$query = $this->db->where('type_id', $type_id);
		$query = $this->db->get('branch_content_int');

		if($query->result()){

			foreach($query->result() as $row){

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_branch('.$row->bc_id.')"><i class="icon-remove icon-white"></i> '.$row->branch.'</span>';

			}

		}else{

			echo '<div class="alert"> No Branches added</div>';

		}

	}

	//++++++++++++++++++++++++++++++++++++++++
	//ADD BRANCH AND INTERSECTION FOR PRODUCT
	//++++++++++++++++++++++++++++++++++++++++

	public function add_branch_item()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO BRANCHES
		$data['title'] = $this->input->post('branch_name');
		$data['bus_id'] = $bus_id;
		$type_id = $this->input->post('type_id');
		$type = $this->input->post('type');

		//TEST DUPLICATE BRANCHES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('branches');

		if($result1->num_rows() == 0){
			$this->db->insert('branches', $data);
		}

		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('branches');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('branch', $data['cat_name']);
		$this->db->where('type', $type);
		$this->db->where('type_id', $type_id);
		$result = $this->db->get('branch_content_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['branch_id'] = $row['branch_id'];
			$data2['type_id'] = $type_id;
			$data2['type'] = $type;
			$data2['branch'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('branch_content_int', $data2);
		}

	}


	//DELETE BRANCH PRODUCT
	public function delete_branch_item($id)
	{
		$this->db->where('bc_id', $id);
		$this->db->delete('branch_content_int');

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


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//CLEAN BUSINESS URL SLUG
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++		 	

	//setlocale(LC_ALL, 'en_US.UTF8');
	function clean_slug_str($str, $replace=array(), $delimiter='-' , $type) {
		if( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
	
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		
		//test Databse
		//$this->db->where('bus_id', $this->session->userdata('bus_id'));
		$this->db->where('slug', $clean);
		$res = $this->db->get($type);
		
		if($res->result()){
			
			$clean = $clean .'-'.rand(0,99);
			return $clean;
			
		}else{
			
			return $clean;
		}

	}

}
?>