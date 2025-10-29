<?php
class Advert_model extends CI_Model
{

	function advert_model()
	{
		//parent::CI_model();

	}

	/**
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 * //ADVERTS
	 * //END
	 * ++++++++++++++++++++++++++++++++++++++++++++
	 */


	//+++++++++++++++++++++++++++
	//GET ADVERT DETAILS
	//+++++++++++++++++++++++++++ 
	function get_advert($advert_id){

		$query = $this->db->where('advert_id', $advert_id);
		$query = $this->db->get('adverts');
		return $query->row_array();	

	}


	//+++++++++++++++++++++++++++
	//GET ALL Adverts
	//++++++++++++++++++++++++++
	public function get_all_adverts()
	{
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->order_by('sequence','ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('adverts');
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
					<input type="hidden" value="'.$row->advert_id.'" />
					<td style="width:6%">'.$status.'</td>
					<td style="width:20%"><a style="cursor:pointer" 
					href="'.site_url('/').'advert/update_advert/'.$row->advert_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
					.$row->title.'</div></a></td>
					<td style="width:34%">'.substr(strip_tags($row->body),0,80).'</td>
					<td style="width:15%">'.date('M d Y',strtotime($row->listing_date)).'</td>
					<td style="width:15%;text-align:right">
					<a title="Edit Advert" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
					href="'.site_url('/').'advert/update_advert/'.$row->advert_id.'"><i class="icon-pencil"></i></a>
					<a title="Delete Advert" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_advert('.$row->advert_id.')">
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
								console.log(advert_id+" "+index); 
								$.ajax({
									type: "post",

									url: "'. site_url('/').'admin/update_advert_sequence/"+advert_id+"/"+index ,
									success: function (data) {

									}

							});

						});

					}

				}).disableSelection();
			</script>';

		}else{
		 
		 echo '<div class="alert">
		 		<h3>No Adverts added</h3>
				No adverts have been added. to add a new advert please click on the add advert button on the right</div>';

		}
		
	}


	//+++++++++++++++++++++++++++
	//ADD ADVERT DO
	//++++++++++++++++++++++++++	
	function add_advert_do()
	{
		$title = $this->input->post('title', TRUE);
		$slug = $this->input->post('slug', TRUE);
		$url = $this->input->post('url', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$metaT = $this->input->post('metaT', TRUE);
		$metaD = $this->input->post('metaD', TRUE);
		$bus_id = $this->session->userdata('bus_id');
	  
		if($slug == ''){
			
			$slug = $this->clean_slug_str($title, $replace=array(), $delimiter='-' , 'pages');
				
		}else{
			
			$slug = $this->clean_url_str($slug);
			
		}
		
		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Advert Title Required';
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
			  'url'=> $url,
			  'body'=> $body,
			  'metaD'=> $metaD,
			  'metaT'=> $metaT,
			  'slug'=> $slug,
			  'bus_id'=>$bus_id
			);

		if($val == TRUE){

				$this->db->insert('adverts', $insertdata);
				$advertid = $this->db->insert_id();
				//LOG
				$this->admin_model->system_log('add_new_advert-'.$title);
				//success redirect	
				$this->session->set_flashdata('msg','Advert added successfully');
				$data['basicmsg'] = 'Advert has been added successfully';
				echo "
				<script type='text/javascript'>
				var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
			            noty(options);
				window.location = '".site_url('/')."advert/update_advert/".$advertid."/';
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
	//UPDATE ADVERT
	//++++++++++++++++++++++++++++	
	function update_advert_do()
	{
			$title = $this->input->post('title', TRUE);
			$slug = $this->input->post('slug', TRUE);		
			$status = $this->input->post('status', TRUE);
			$url = $this->input->post('url', TRUE);
			
			$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));

			$metaT = $this->input->post('metaT', TRUE);
			$metaD = $this->input->post('metaD', TRUE);
			$id = $this->input->post('advert_id', TRUE);
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
				$error = 'Advert Title Required';
			
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
				  'url'=> $url,
				  'body'=> $body,
				  'metaD'=> $metaD,
				  'metaT'=> $metaT,
				  'slug'=> $slug ,								  
				  'bus_id'=>$bus_id,
				  'sequence'=> $sequence
				);
			
	
			
			if($val == TRUE){
				
					$this->db->where('advert_id' , $id);
					$this->db->update('adverts', $insertdata);
					//success redirect	
					$data['advert_id'] = $id;
					
					//LOG
					$this->admin_model->system_log('update_advert-'. $id);
					
					
					
					$data['basicmsg'] = 'Advert has been updated successfully';
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				            noty(options);</script>";
					
			}else{
					
					echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
				            noty(options);</script>";
				
			}
	}


	
	//+++++++++++++++++++++++++++
	//DELETE ADVERT
	//++++++++++++++++++++++++++++	
	function delete_advert($advert_id){
      	
		if($this->session->userdata('admin_id')){

			$bus_id = $this->session->userdata('bus_id');

			//delete from database
			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('advert_id', $advert_id);
			$query =  $this->db->delete('adverts');

			$query = $this->db->where('bus_id', $bus_id);
			$query = $this->db->where('advert_id', $advert_id);
			$this->db->delete('adverts_cat_int');

			//LOG
			$this->admin_model->system_log('delete_advert-'.$advert_id);
			$this->session->set_flashdata('msg','Advert deleted successfully');
			echo '<script type="text/javascript">
			   window.location = "'.site_url('/').'advert/adverts/";
			  </script>';
						
			
		}else{
			
			redirect(site_url('/').'admin/logout/','refresh');
				
		}
    }












/*****************************************************************************************************************************************/
///////////////////////////////////////////////////////ADVERT CATEGORIES///////////////////////////////////////////////////////////////////
/*****************************************************************************************************************************************/

	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('advert_categories');
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
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_advert_category('.$row->cat_id.')">
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

	//+++++++++++++++++++++++++++
	//ADD CATEGORY
	//++++++++++++++++++++++++++
	public function add_category()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO TOPICS
		$data['title'] = $this->input->post('category');
		$data['bus_id'] = $bus_id;

		//TEST DUPLICATE CATEGORIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('advert_categories');

		if($result1->num_rows() == 0){
			$this->db->insert('advert_categories', $data);
		}


	}


	public function add_advert_category()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$data['title'] = $this->input->post('category_name');
		$data['bus_id'] = $bus_id;
		$advert_id = $this->input->post('advert_id_cat');

		//TEST DUPLICATE CATEGORIES
		$this->db->where('title', $data['title']);
		$this->db->where('bus_id', $bus_id);
		$result1 = $this->db->get('advert_categories');

		if($result1->num_rows() == 0){
			$this->db->insert('advert_categories', $data);
		}
		//GET NEW CAT ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('advert_categories');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('advert_id', $advert_id);
		$result = $this->db->get('adverts_cat_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['cat_id'] = $row['cat_id'];
			$data2['advert_id'] = $advert_id;
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('adverts_cat_int', $data2);
		}

	}



	public function add_advert_page()
	{
		$bus_id = $this->session->userdata('bus_id');

		//INSERT INTO CATEGORIES
		$data['title'] = $this->input->post('page_name');
		$data['bus_id'] = $bus_id;
		$advert_id = $this->input->post('advert_id');


		//GET NEW PAGE ID
		$this->db->where('bus_id', $bus_id);
		$this->db->where('title', $data['title']);
		$result = $this->db->get('pages');
		$row = $result->row_array();

		//TEST DUPLICATE INTERSECTION
		$this->db->where('title', $data['title']);
		$this->db->where('advert_id', $advert_id);
		$result = $this->db->get('adverts_page_int');

		if($result->num_rows() == 0){
			//INSERT INTO INTERSECTION TABLE
			$data2['page_id'] = $row['page_id'];
			$data2['advert_id'] = $advert_id;
			$data2['title'] = $data['title'];
			$data2['bus_id'] = $bus_id;
			$this->db->insert('adverts_page_int', $data2);
		}

	}




	//+++++++++++++++++++++++++++
	//DELETE CATEGORY
	//++++++++++++++++++++++++++
	public function delete_category($id)
	{
		$this->db->where('cat_id', $id);
		$this->db->delete('advert_categories');

	}


	public function delete_category_event($id)
	{
		$this->db->where('id', $id);
		$this->db->delete('adverts_cat_int');

	}


	public function delete_page_advert($id)
	{
		$this->db->where('ap_id', $id);
		$this->db->delete('adverts_page_int');

	}



	//+++++++++++++++++++++++++++++++++
	//GET MAIN CATEGORIES -- TYPEHEAD
	//+++++++++++++++++++++++++++++++++
	function load_category_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('advert_categories');

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



	//+++++++++++++++++++++++++++++++++
	//GET MAIN PAGES -- TYPEHEAD
	//+++++++++++++++++++++++++++++++++
	function load_page_typehead(){

		$bus_id = $this->session->userdata('bus_id');
		$test = $this->db->where('bus_id', $bus_id);
		$test = $this->db->get('pages');

		$result = 'var subjects = [';
		$x = 0;
		foreach($test->result() as $row){

			$id = $row->page_id;
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
	function get_categories_current($advert_id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('advert_id', $advert_id);
		$query = $this->db->get('adverts_cat_int');

		if($query->result()){

			foreach($query->result() as $row){

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_category('.$row->id.')"><i class="icon-remove icon-white"></i> '.$row->title.'</span>';

			}

		}else{

			echo '<div class="alert"> No Categories added</div>';

		}

	}


	function get_pages_current($advert_id){

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('advert_id', $advert_id);
		$query = $this->db->get('adverts_page_int');

		if($query->result()){

			foreach($query->result() as $row){

				echo '<span style="margin:5px;cursor:pointer" class="label label-important" onclick="delete_page('.$row->ap_id.')"><i class="icon-remove icon-white"></i> '.$row->title.'</span>';

			}

		}else{

			echo '<div class="alert"> No Pages added</div>';

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






























































































	//+++++++++++++++++++++++++++
	//GET CATEGORY
	//++++++++++++++++++++++++++
	function get_category($cat_id){

		$cat = $this->db->select('title');
		$cat = $this->db->where('cat_id', $cat_id);
		$cat = $this->db->get('advert_categories');

		if($cat->result()){

			$row = $cat->row();

			return $row->title;

		} else {

			return 'none';

		}

	}




	//+++++++++++++++++++++++++++
	//GET CATEGORY OPTION LIST
	//++++++++++++++++++++++++++
	public function get_category_option_list()
	{
		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->order_by('sequence', 'ASC');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('advert_categories');
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
		$query = $this->db->get('advert_categories');
		if($query->result()){


			foreach($query->result() as $row){

				if($id == $row->cat_id) { $sel = 'selected'; } else { $sel = ''; }

				echo '<option value="'.$row->cat_id.'" '.$sel.'>'.$row->title.'</option>';
			}


		}else{

		}

	}






}
?>