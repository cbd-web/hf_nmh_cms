<?php
class Video_model extends CI_Model{
	
 	function vacancy_model(){
  		//parent::CI_model();
	    $this->load->library('encrypt');
		
 	}


	//+++++++++++++++++++++++++++
	//GET GALLERY DETAILS
	//++++++++++++++++++++++++++

	function get_gallery($gal_id){

		$test = $this->db->where('gal_id', $gal_id);
		$test = $this->db->get('video_galleries');
		return $test->row_array();

	}


	//+++++++++++++++++++++++++++
	//GET ALL GALLERIES
	//++++++++++++++++++++++++++
	public function get_all_galleries()
	{

		$bus_id = $this->session->userdata('bus_id');

		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->order_by('datetime', 'ASC');
		$query = $this->db->get('video_galleries');
		if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:40%;font-weight:normal">Description </th>
						<th style="width:20%;font-weight:normal">Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

			foreach($query->result() as $row){

				echo '<tr>

						<td style="width:30%"><a style="cursor:pointer"
						href="'.site_url('/').'video/update_gallery/'.$row->gal_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
            			<td style="width:40%">'.strip_tags(substr($row->description,0,80)).'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->datetime)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Gallery" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
						href="'.site_url('/').'video/update_gallery/'.$row->gal_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Gallery" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_gallery('.$row->gal_id.')">
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
			 		<h3>No Galleries added</h3>
					No galleries have been added. to add a new gallery please click on the add gallery button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//GET GALLERY VIDEOS SORTABLE
	//++++++++++++++++++++++++++

	function load_gallery_videos_update($gal_id){


		$bus_id = $this->session->userdata('bus_id');
		// $this->db->where('bus_id', $bus_id);
		// $this->db->where('gal_id', $gal_id);
		// $test = $this->db->order_by('sequence', 'ASC');
		// $test = $this->db->get('videos');

		$test = $this->db->query("SELECT A.* , COUNT(B.vote_id) as total_votes

								   FROM videos as A

								   LEFT JOIN user_votes as B ON A.vid_id = B.type_id

								   WHERE A.gal_id = '".$gal_id."' AND A.bus_id = '".$bus_id."'

								   GROUP BY A.vid_id

								   ORDER BY A.sequence ASC", FALSE);


		if($test->result()){

			echo'<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
           				<th style="width:20%;font-weight:normal"></th>
						<th style="width:50%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';

				// var_dump($test->result());

			foreach($test->result() as $row){

				
				if ($row->title != '' && $row->heading == '') {
					$new_title = $row->title;
				} else if ($row->title == '' && $row->heading != '') {
					$new_title = $row->heading;
				} else if($row->title != '' && $row->heading != '') {
					$new_title = $row->heading .' - '.$row->title;
				} else {
					$new_title = '';
				}

				echo '<tr class="myDragClass">

						<td style="width:100%">
							<input type="hidden" value="'.$row->vid_id.'" />
							<h4>'.$new_title.'</h4>
							<div>'.$row->vid_file.'</div>
							<small>Total votes: '.$row->total_votes.'</small>
							<div>
							<a title="Edit video" rel="tooltip" class="btn btn-mini" style="cursor:pointer"
							onclick="update_video('.$row->vid_id.')"><i class="icon-pencil"></i></a>
							<a href="#" onclick="delete_video('.$row->vid_id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
							</div>
						</td>

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
									var vid_id = $(this).val(), index = i;
									console.log(vid_id+" "+index);
									 $.ajax({
										type: "post",

										url: "'. site_url('/').'admin/update_vid_sequence/"+vid_id+"/"+index ,
										success: function (data) {

										}
								});

							  });


						}

					}).disableSelection();
				</script>';


		}else{
			echo '<div class="alert">
			 		<h3>No Videos added</h3>
					No videos have been added.</div>';

		}

	}


	//+++++++++++++++++++++++++++
	//UPDATE VIDEO
	//++++++++++++++++++++++++++

	public function update_video_do()
	{
		$title = $this->input->post('vid_title', TRUE);
		$heading = $this->input->post('vid_heading', TRUE);
		$body = $this->input->post('vid_body', TRUE);
		$icon = $this->input->post('vid_icon', TRUE);
		$url = $this->input->post('vid_url', TRUE);
		$id = $this->input->post('update_vid_id', TRUE);

		//VALIDATE INPUT
		if($title == '' && $body == ''){
			$val = FALSE;
			$error = 'Video Title or description required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'heading'=> $heading ,
			'body'=> $body ,
			'icon'=> $icon ,
			'url'=> $url
		);

		if($val == TRUE){

			$this->db->where('vid_id' , $id);

			$this->db->update('videos', $insertdata);

			//LOG
			$this->admin_model->system_log('update_video-'. $id);
			$data['basicmsg'] = 'Video has been updated successfully';
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