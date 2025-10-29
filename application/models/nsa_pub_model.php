<?php
class Nsa_pub_model extends CI_Model{
	
 	function nsa_pub_model(){
  		//parent::CI_model();
			
 	}


	public function get_pub_doc($pid, $type, $title = '') {

		$bus_id = $this->session->userdata('bus_id');
			
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->where('pub_id', $pid);
		$query = $this->db->get('nsa_pubs');

			  if($query->result()){
				  
				  $row = $query->row();
				  
				  if($type == 'doc') {
					
					$typ = '1';
								
					if($row->pub_doc != '' || $row->pub_doc != NULL) {

						echo '<pre>'.$row->pub_doc.'</pre><a href="javascript:void(0);" onclick="remove_doc('.$pid.','.$typ.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>';
						
					} else {
						$str = "$('#userfile1').click();";
						echo '
						<div class="alert">No document selected</div>
						<form action="'. site_url('/').'admin/add_nsa_doc/" method="post" accept-charset="utf-8" id="add-nsa-doc" name="add-nsa-doc" enctype="multipart/form-data"> 
						<input type="hidden" name="pid" value="'. $pid.'">
						<input type="hidden" name="type" value="'. $type.'">
						<input type="hidden" name="title" value="'. $title.'">						
						<input type="file" class="" id="userfile1"  name="userfile">
						<div class="progress progress-striped active" id="procover" style="display:none;margin-top:20px">
								   <div class="bar bar-warning" style="width: 0%;"></div>
						</div>						
						<a href="javascript:void(0)" onClick="'.$str.'" class="btn">Select Document</a>
						<button type="submit" class="btn btn-inverse" id="docbut">Add Document</button>
						</form>
						';
					}
					  
				  }
				  
				  if($type == 'data') {
					
					$typ = '2';
					
					if($row->pub_data != '' || $row->pub_data != NULL) {
						
						echo '<pre>'.$row->pub_data.'</pre><a href="javascript:void(0);" onclick="remove_doc('.$pid.','.$typ.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>';
						 
					} else {
						
						$str = "$('#userfile2').click();";
						echo '
						<div class="alert">No document selected</div>
						<form action="'. site_url('/').'admin/add_nsa_doc/" method="post" accept-charset="utf-8" id="add-nsa-data" name="add-nsa-data" enctype="multipart/form-data"> 
						<input type="hidden" name="pid" value="'.$pid.'">
						<input type="hidden" name="type" value="'.$type.'">
						<input type="hidden" name="title" value="'.$title.'"> 			
						<input type="file" class="" id="userfile2"  name="userfile">
						<div class="progress progress-striped active" id="procover2" style="display:none;margin-top:20px">
								   <div class="bar bar-warning" style="width: 0%;"></div>
						</div>						
						<a href="javascript:void(0)" onClick="'.$str.'" class="btn">Select Document</a>
						<button type="submit" class="btn btn-inverse" id="docbut2">Add Document</button>
						</form>
						';
						
					}
										  
					  					  
				  }
				  
			  }
	}
	
	
	
	public function remove_featured_document($id, $typ)
	{
		
		
		$bus_id = $this->session->userdata('bus_id');
		
		if($typ == '1') {		
			$query = $this->db->select('pub_doc');
		}
		if($typ == '2') {		
			$query = $this->db->select('pub_data');
		}
							
		$query = $this->db->where('pub_id', $id);
		$query = $this->db->get('nsa_pubs');
		
		if($query->result()){
			
			$row = $query->row_array();
			
			if($typ == '1') {		
				$doc = $row['pub_doc'];
			}
			if($typ == '2') {		
				$doc = $row['pub_data'];
			}			
			
/*			$file =  BASE_URL.'assets/documents/' . $doc; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}*/
			
			
			
				if($typ == '1') {		
					$this->db->set('pub_doc', NULL);
				}
				if($typ == '2') {		
					$this->db->set('pub_data', NULL);
				}				
				
				$this->db->where('pub_id' , $id);
				$this->db->update('nsa_pubs');
							
				
			 echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'Document removed.','layout':'bottomLeft','type':'success'};
					  noty(options);

					  </script>";		 
						 	
			
		}
	}

	//+++++++++++++++++++++++++++
	//GET ALL PUBLICATIONS
	//++++++++++++++++++++++++++
	public function get_all_pubs($cid)
	{
		
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->query("SELECT * FROM nsa_pubs WHERE bus_id = '".$bus_id."'", FALSE);
		

		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" id="sortable" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:24%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal">Listing date</th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				$status = '<span class="label label-success">Live</span>';
				if($row->active == 'Draft'){
					$status = '<span class="label label-warning">Draft</span>';
				}
				echo '<tr> 
						<td style="width:6%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" href="'.site_url('/').'admin/update_pub/'.$row->pub_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:24%">'.$this->get_category($row->cat_id).'</td>
						<td style="width:15%">'.date('d M Y',strtotime($row->listing_date)).'</td>
						<td style="width:15%;text-align:right">
						<a title="Edit Chart" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'admin/update_pub/'.$row->pub_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Entry" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_nsa_pub('.$row->pub_id.')">
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
			 		<h3>No Publications added</h3>
					No publications have been added. to add a new publication please click on the add publication button on the right</div>';
		  
		 }
		  
				
				
		
	}
	
		//+++++++++++++++++++++++++++
	//GET CHART DETAILS
	//++++++++++++++++++++++++++		 
		 
	function get_pub($pub_id){
			
		$query = $this->db->where('pub_id', $pub_id);
		$query = $this->db->get('nsa_pubs');
		return $query->row_array();	

	}

	//+++++++++++++++++++++++++++
	//GET CATEGORY
	//++++++++++++++++++++++++++		 
		 
	function get_category($cat_id){
			
		$cat = $this->db->select('cat_name');
		$cat = $this->db->where('cat_id', $cat_id);
		$cat = $this->db->get('nsa_categories');
		
		if($cat->result()){
		
		$row = $cat->row();	
		
			return $row->cat_name;
		
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
		  $query = $this->db->get('nsa_categories');
		  if($query->result()){


			foreach($query->result() as $row){
				echo '<option value="'.$row->cat_id.'">'.$row->cat_name.'</option>';
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
		  $query = $this->db->get('nsa_categories');
		  if($query->result()){


			foreach($query->result() as $row){
				
				if($id == $row->cat_id) { $sel = 'selected'; } else { $sel = ''; }
				
				echo '<option value="'.$row->cat_id.'" '.$sel.'>'.$row->cat_name.'</option>'; 
			}
			
			
		 }else{
			 
		 }
				
	}	



	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $this->db->order_by('sequence', 'ASC');
		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('nsa_categories');
		  if($query->result()){
			echo'
	
			<table id="sortable" cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Category </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr class="myDragClass">
						<input type="hidden" value="'.$row->cat_id.'" />
						<td style="width:6%">'.$row->cat_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->cat_name.'</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_chart_category('.$row->cat_id.')">
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
									var cat_id = $(this).val(), index = i;
									console.log(cat_id+" "+index); 
									 $.ajax({
										type: "post",
										
										url: "'. site_url('/').'admin/update_nsa_cat_sequence/"+cat_id+"/"+index ,
										success: function (data) {
											
										}
								});
								
							  });
						  
							
						}
						
					}).disableSelection();
				</script>';
			
		 }else{
			 
			echo '<div class="alert"><h3>No Categories added</h3> No categories have been added. Add one by using the tool on the right</div>';  
		 }
			
		
	}
		
		
	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	function add_nsa_doc()
	{
			$doc = $this->input->post('userfile', TRUE);
			$pid = $this->input->post('pid', TRUE);
			$type = $this->input->post('type', TRUE);
			$title = $this->input->post('title', TRUE);
			$file = NULL;

			//upload file
			$config['upload_path'] = BASE_URL .'assets/documents/';
			$config['allowed_types'] = 'pdf|doc|docx|csv|xls|xlsx';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = FALSE;
			//$config['file_name']  = trim(substr($img, 0, 80));
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{

					$data['error'] =  $this->upload->display_errors();

					 echo "<script>
					$.noty.closeAll()
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				  	noty(options);
					
					</script>";	
					  
					
			}	
			else
			{	

				//$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
	
				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));	
				
				if($type == 'doc') {
					
				 //populate array with values
				  $data_doc = array( 
					'pub_doc'=> $file,
					'bus_id' => $this->session->userdata('bus_id')
				  );
				  
				  
				  $this->db->where('pub_id' , $pid);
				  $this->db->update('nsa_pubs',$data_doc);				  					

				}
				
				
				if($type == 'data') {
					
				 //populate array with values
				  $data_doc = array( 
					'pub_data'=> $file,
					'bus_id' => $this->session->userdata('bus_id')
				  );
				  
				  
				  $this->db->where('pub_id' , $pid);
				  $this->db->update('nsa_pubs',$data_doc);				  					

				}				


				$this->load->model('s3_model');
				$this->s3_model->upload_s3('assets/documents/' . $file);
				

				 //populate array with values
				  $data1 = array( 
					'doc_file'=> $file,
					'bus_id' => $this->session->userdata('bus_id'),
					'title' => $this->upload->file_name
				  );
				
				  //insert into database
				  $this->db->insert('documents',$data1);

				  $data['filename'] = $file;

				 //redirect 
				  $data['basicmsg'] = 'Document added successfully!';
			  	  //echo $this->get_pub_doc();
				  echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);
					  $('#add_img').fadeOut();
					  </script>";		 
						 
					

		}

	}		
		
	
	//GET CATEGORY TYPEHEAD
	function load_category_typehead(){
      	
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $this->db->where('bus_id', $bus_id);		
		$query = $this->db->get('nsa_categories');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){
			
			$id = $row->cat_id;
			$title = $row->title;
			
			if($x == ($query->num_rows()-1)){
				
				$str = '';
				
			}else{
				
				$str = ' , ';
				
			}
				
			$result .= "'".$title."' ". $str;
			$x ++; 
			
		}
		
		$result .= '];';
		return $result;
			  
    }	
	
	
	 //GET CATEGORIES
	function get_categories(){
		$bus_id = $this->session->userdata('bus_id');
		$query = $this->db->where('bus_id', $bus_id);
		$query = $this->db->get('nsa_categories');
		return $query;	  
    }





}
?>