<?php
class My_namibia_model extends CI_Model{
	
 	function my_namibia_model(){
  		//parent::CI_model();
			
 	}


	//+++++++++++++++++++++++++++
	//GET EMAIL CONTENT
	//++++++++++++++++++++++++++
	public function get_all_businesses()
	{

		$db2 = $this->connect_my_db();
		$query = $db2->query("SELECT * FROM u_business ORDER BY BUSINESS_NAME ASC LIMIT 10 ");

		if ($query->result())
		{
			echo '
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>
			';

			foreach ($query->result() as $row)
			{

				$title = ucwords(filter_var(utf8_decode($row->BUSINESS_NAME), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW));
				echo '<tr id="it-' . $row->ID . '"><td>' . $this->shorten_string($title, 6) . '</td><td> <a href="javascript:add_business(' .$row->ID . ');"><i class="icon-plus pull-right"></i></a></td></tr>';
				//echo $row->TITLE;


			}
			echo '</tbody>
				</table>';
		}


	}

	//+++++++++++++++++++++++++++
	//SYNC TOURISM EXPO EXHIBITORS LISTING
	//++++++++++++++++++++++++++	
	public function get_business_name($data)
	{
		
		$db2 = $this->connect_my_db();
		$my = $db2->query('SELECT BUSINESS_NAME, ID FROM u_business WHERE BUSINESS_NAME like "%'.urldecode($data).'%" LIMIT 10', FALSE);
		
		if($my->result()){
			
			echo '<ul class="nav nav-pills nav-stacked">';
			foreach ($my->result() as $row){
				
				echo '<li id="cbus_'.trim($row->ID).'"><a class="btn btn-block" href="javascript:void(0)" onclick="add_business('.trim($row->ID).')"><i class="icon-chevron-left"></i> '.$row->BUSINESS_NAME.'</a></li>';	
				
			}
			echo '</ul>';
		}else{
			
			echo '<div class="alert">No Matches Found on My.na</div>';
				
		}
	
	} 


	//+++++++++++++++++++++++++++
	//GET SELECTED BUSINESSES
	//++++++++++++++++++++++++++
	public function get_selected_businesses($page_id)
	{
		
		  $bus_id = $this->session->userdata('bus_id');

		  $query = $this->db->where('bus_id', $bus_id);
		  $query = $this->db->get('na_businesses');
		
		  if($query->result()){
			
			echo '';
			
			foreach($query->result() as $row){
															
				//if($row->ID
				
				echo '<div id="busi_'.$row->na_bus_id.'" style="margin:5px;cursor:pointer" class="label label-important" onclick="remove_business('.$row->na_bus_id.')"><i class="icon-remove icon-white"></i>'.$row->name.'</div>';
				

			}
			
			
		 }else{
			 
			 echo '<div class="alert">
			 		<p>No Bussinesses added</p>
				  </div>';	
					
		 }
	}


//+++++++++++++++++++++++++++
	//SYNC TOURISM EXPO EXHIBITORS LISTING
	//++++++++++++++++++++++++++
	public function get_business_id($my_na_bus_id)
	{

		$db2 = $this->connect_my_db();
		$my = $db2->query("SELECT BUSINESS_NAME, BUSINESS_LOGO_IMAGE_NAME, BUSINESS_PHYSICAL_ADDRESS,BUSINESS_TELEPHONE, BUSINESS_CELLPHONE, BUSINESS_FAX, ID FROM u_business WHERE ID = '".$my_na_bus_id."'");

		if($my->result()){

			$row = $my->row();

			$img = $row->BUSINESS_LOGO_IMAGE_NAME;
			//Build image string
			$format = substr($img,(strlen($img) - 4),4);
			$str = substr($img,0,(strlen($img) - 4));

			if($img != ''){

				if(strpos($img,'.') == 0){

					$format = '.jpg';
					$fake_file = NA_URL.'img/timbthumb.php?w=200&h=200&src='.NA_URL.'assets/business/photos/'.$img . $format;

				}else{

					$fake_file = NA_URL.'img/timbthumb.php?w=200&h=200&src='.NA_URL.'assets/business/photos/'.$img;

				}

			}else{

				$fake_file = NA_URL.'img/timbthumb.php?w=200&h=200&src='.NA_URL.'img/bus_blank.png';

			}

			echo '
    <img src="'.$fake_file.'" class="img-polaroid pull-right" style="width:120px; height:120px">
    <address>
      <strong>'. ucwords(filter_var(utf8_decode($row->BUSINESS_NAME), FILTER_SANITIZE_STRING, FILTER_FLAG_ENCODE_LOW)).'</strong><br>
      '. $row->BUSINESS_PHYSICAL_ADDRESS.'<br />
      <abbr title="Phone">P:</abbr> '.$row->BUSINESS_TELEPHONE.'<br />
      <abbr title="Cellphone">C:</abbr> '. $row->BUSINESS_CELLPHONE.'<br />
      <abbr title="Fax">F:</abbr> '.$row->BUSINESS_FAX.'<br />
    </address>
    <a class="btn btn-inverse clearfix" href="'.NA_SITE_URL.'/b/'.$row->ID.'/" target="_blank">View on My.na</a>
    <div class="clearfix"></div>
    ';

			// echo $this->business_model->get_qr_vcard($ID,'220','220');
		}else{

			echo '<div class="alert">Not linked to any My.na business</div>';

		}

	}



	public function add_business_do($page_id, $my_id) {
		
		  $bus_id = $this->session->userdata('bus_id');		
		  $db2 = $this->connect_my_db();
		  
		  $query = $db2->where('ID', $my_id);
		  $query = $db2->get('u_business');
		  			  
		  
		  if($query->result()){
			  			  
			$row = $query->row();
													
				$insertdata = array(
				  'name'=> $row->BUSINESS_NAME,
				  'business_id'=> $row->ID,
				  'page_id'=> $page_id,
				  'bus_id'=> $bus_id
								  
				);
				
				$this->db->insert('na_businesses',$insertdata);					


				//LOG
				$this->admin_model->system_log('Business Added');
				$data['basicmsg'] = 'Business list has been saved';
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						noty(options);</script>";			
							
			  
		  } 

	}
	
	

	public function update_business_list($bid) {
		
		  $bus_id = $this->session->userdata('bus_id');			
		  $db2 = $this->connect_my_db();
		  $query = $db2->where('ID', $bid);
		  $query = $db2->get('u_business');
		  			  
		  
		  if($query->result()){
			
				$row = $query->row();			
									
				$insertdata = array(
				  'name'=> $row->BUSINESS_NAME,
				  'business_id'=> $row->ID,
				  'bus_id'=> $bus_id
								  
				);
				
				$this->db->insert('na_businesses',$insertdata);					
					
			  
		  }		
		
	}
	

	//+++++++++++++++++++++++++++
	//GET ALL PROPERTIES
	//++++++++++++++++++++++++++
	public function get_all_properties()
	{
		
		  $bus_id = $this->session->userdata('bus_id');
		  $db2 = $this->connect_my_db();
		  $query = $db2->where('BUS_ID', $bus_id);
		  $query = $db2->get('products');
		  if($query->result()){
			
			//var_dump($query);
			
			echo '
					<small>Please check all Properties you wish to add, and click on the "Save List" Button to store the changes.</small>
					<table class="table table-striped">';
						
						
						
						foreach($query->result() as $row){
							
							$checked = '';
							
							//CHECK IF ROW ALREADY EXISTS
							$this->db->where('product_id', $row->product_id);
							$query2 = $this->db->get('property_show');
							
							if($query2->result()){
								
								$row2 = $query2->row();	
								
								if($row2->product_id != $row->product_id) {
							
									
								
								} else {
								
									$checked = 'checked';	
									
								}
							
							}
							
							
							//if($row->ID
								
							echo '<tr><td style="width:5%"><input name="prop[]" type="checkbox" value="'.$row->product_id.'" '.$checked.'/></td><td>'.$row->title.'</td></tr>';
						
						}
			
			echo '</table>';
			
		 }else{
			 
			return '';
		 }
				
		
	}
	
	public function update_prop_list($pid) {
		
		  $bus_id = $this->session->userdata('bus_id');			
		  $db2 = $this->connect_my_db();
		  $query = $db2->where('product_id', $pid);
		  $query = $db2->get('products');
		  			  
		  
		  if($query->result()){
			
				$row = $query->row();			
									
				$insertdata = array(
				  'name'=> $row->title,
				  'product_id'=> $row->product_id,
				  'bus_id'=> $bus_id
								  
				);
				
				$this->db->insert('property_show',$insertdata);					
					

			  
		  }		
		
	}	
	
	
	
	
	
	
	

	//+++++++++++++++++++++++++++
	//GET ALL AGENCIES
	//++++++++++++++++++++++++++
	public function get_all_agencies()
	{
		
		  $bus_id = $this->session->userdata('bus_id');
		  $db2 = $this->connect_my_db();
		  $query = $db2->where('IS_ESTATE_AGENT', 'Y');
		  $query = $db2->get('u_business');
		  if($query->result()){
			
			//var_dump($query);
			
			echo '
					<small>Please check all Agencies you wish to add, and click on the "Save List" Button to store the changes.</small>
					<table class="table table-striped">';
						
						
						
						foreach($query->result() as $row){
							
							$checked = '';
							
							//CHECK IF ROW ALREADY EXISTS
							$this->db->where('bus_id', $bus_id);
							$this->db->where('agent_id', $row->ID);
							$query2 = $this->db->get('property_agencies');
							
							if($query2->result()){
								
								$row2 = $query2->row();	
								
								if($row2->agent_id != $row->ID) {
							
									
								
								} else {
								
									$checked = 'checked';	
									
								}
							
							}
							
							
							//if($row->ID

							echo '<tr><td style="width:5%"><input name="agent[]" type="checkbox" value="'.$row->ID.'" '.$checked.'/></td><td>'.$row->BUSINESS_NAME.'</td>
							<td><a title="View Agent Properties" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'admin/agent_properties/'.$row->ID.'"><i class="icon-eye-open"></i></a></td></tr>';
						
						}
			
			echo '</table>';
			
		 }else{
			 
			return '';
		 }
				
		
	}

	//+++++++++++++++++++++++++++
	//GET ALL AGENT PROPERTIES
	//++++++++++++++++++++++++++
	public function get_all_agent_properties($id)
	{

		$db2 = $this->connect_my_db();
		$query = $db2->where('bus_id', $id);
		$query = $db2->get('products');
		if($query->result()){

			//var_dump($query);

			echo '
					<small>Please check all Properties you wish to feature, and click on the "Save List" Button to store the changes.</small>
					<table class="table table-striped" id="prop-table">
						<thead>
							<tr style="font-size:14px">
								<th style="width:6%;font-weight:normal"></th>
								<th style="width:20%;font-weight:normal">Title </th>
								<th style="width:34%;font-weight:normal">Ref No </th>
							</tr>
						</thead>
						<tbody>
					';



			foreach($query->result() as $row){

				$prop_checked = '';

				$bus_id = $this->session->userdata('bus_id');

				//CHECK IF ROW ALREADY EXISTS
				$this->db->where('bus_id', $bus_id);
				$this->db->where('property_id', $row->product_id);
				$query2 = $this->db->get('agent_properties');

				if($query2->result()){

					$row2 = $query2->row();

					if($row2->property_id == $row->product_id) {

						$prop_checked = 'checked';

					} else {

						$prop_checked = '';

					}

				}


				//if($row->ID

				echo '<tr><td style="width:5%"><input name="property[]" type="checkbox" value="'.$row->product_id.'" '.$prop_checked.'/></td><td>'.$row->title.'</td><td></td></tr>';

			}

			echo '</tbody></table>';

		}else{

			return '';
		}


	}


	public function update_agent_property_list($pid, $aid) {

		$bus_id = $this->session->userdata('bus_id');
		$db2 = $this->connect_my_db();
		$query = $db2->where('product_id', $pid);
		$query = $db2->get('products');


		if($query->result()){

			$row = $query->row();

			$insertdata = array(
				'property_id'=> $pid,
				'agent_id'=> $aid,
				'bus_id'=> $bus_id

			);

			$this->db->insert('agent_properties',$insertdata);



		}

	}

	
	public function update_agent_list($aid) {
		
		  $bus_id = $this->session->userdata('bus_id');			
		  $db2 = $this->connect_my_db();
		  $query = $db2->where('ID', $aid);
		  $query = $db2->where('IS_ESTATE_AGENT', 'Y');
		  $query = $db2->get('u_business');
		  			  
		  
		  if($query->result()){
			
				$row = $query->row();			
									
				$insertdata = array(
				  'name'=> $row->BUSINESS_NAME,
				  'agent_id'=> $row->ID,
				  'bus_id'=> $bus_id
								  
				);
				
				$this->db->insert('property_agencies',$insertdata);					
					

			  
		  }		
		
	}


	
	//+++++++++++++++++++++++++++
	//GET ALL MEMBERS
	//++++++++++++++++++++++++++
	public function get_info()
	{
		  $bus_id = $this->session->userdata('bus_id');	
		  $db2 = $this->connect_my_db();
		  $query = $db2->where('ID', $bus_id);
		  $query = $db2->get('u_business');
		  if($query->result()){
			
			return $query->row_array();
			
		 }else{
			 
			return '';
		 }
				
		
	}
	/**
	++++++++++++++++++++++++++++++++++++++++++++
	//Upload AVATAR AJAX
	//Functions
	++++++++++++++++++++++++++++++++++++++++++++	
	 */	
	
	function add_logo_ajax()
	{
          	$this->output->set_header("Access-Control-Allow-Origin: http://www.my.na");
			$img = $this->input->post('userfile', TRUE);
			$user_id = $this->input->post('id', TRUE);
			$bus_id = $this->input->post('bus_id', TRUE);
			$name = $this->input->post('bus_name', TRUE);
 			$name1 = $name . rand(9,99999);
			
			//upload file

			$config['upload_path'] = NA_BASE_URL .'assets/business/photos/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']	= '8024';
			$config['max_width']  = '8324';
			$config['max_height']  = '8550';
			$config['min_width']  = '200';
			$config['min_height']  = '200';
			$config['remove_spaces']  = TRUE;
			//$config['encrypt_name']  = TRUE;
			$config['file_name']  = $name1;
			
			$this->load->library('upload', $config);
			
			if ( ! $this->upload->do_upload())
			{
					
					if(is_dir($config['upload_path'])){
						
						$v = 'yes';
						
					}else{
						
						$v = 'no';	
					}
					
					$data['id'] = $user_id;
					$data['bus_id'] = $bus_id;
					$data['error'] =  $this->upload->display_errors();

					 echo $data['error'].$v."<script>
					$.noty.closeAll()
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				  	noty(options);
					logo_upload_success('".$image."');
					</script>";	
					  
					
			}	
			else
			{	
				//LOAD library
				$this->load->library('image_lib');	
				//delete old photo
				$this->delete_old_logo($bus_id);
				
				$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
				$width = $this->upload->image_width;
				$height = $this->upload->image_height;	
				
				$format = substr($file,(strlen($file) - 4),4);
				$str = substr($file,0,(strlen($file) - 4));	
				//Convert To jpg
				$this->convert_logo_jpg($str, $file);
						 
					if (($width > 850) || ($height > 700)){
							 
							$this->downsize_logo($file,$bus_id);
									
					}
				//Watermark image
				$this->watermark_logo($file);
				
				   //populate array with values
					$data = array( 
					  'BUSINESS_LOGO_IMAGE_NAME'=> $file
					 
					);
					//insert into database
					$db2 = $this->connect_my_db();
					$db2->where('ID', $bus_id);
					$db2->update('u_business',$data);
					
					//Tourism DB
					$db3 = $this->connect_tourism_db();
					$db3->where('ID', $bus_id);
					$db3->update('u_business', $data);
					
					//load respective view 
				   $data['id'] = $user_id;
				   $data['bus_id'] = $bus_id;
				   //get sizes 
					$data['filename'] = $file;
					$data['width'] = $this->upload->image_width;
					$data['height'] = $this->upload->image_height;
				   $image = NA_URL . 'assets/business/photos/'.$file;
				   //redirect 
					$data['basicmsg'] = 'Logo added successfully!';
				
					echo "<script>
						$.noty.closeAll()
						var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						noty(options);
						logo_upload_success('".$image."');
						</script>";		 
						 
					

		}
			
			
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DOWNSIZE LOGO
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	//downsize image
	function downsize_logo($file, $id){

		$config = array( 
		   'image_library' => 'GD2', 
		   'source_image' => (NA_BASE_URL .'assets/business/photos/'. $file),
		   'master_dim' => 'auto',
		   'width' => '800',
		   'height' => '800',
		   'maintain_ratio' => true
		  ); 
		 
		 
		  $this->image_lib->initialize($config); 
		  if ( ! $this->image_lib->resize()) 
		  { 
			 	$data['error'] = $this->image_lib->display_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		 return;
	}
	
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	//WATERMARK LOGO
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//create a downsized thumbnail
	function watermark_logo($file){
			
			//$id = $this->input->post('pro_id');
 
		  	$config['source_image'] = NA_BASE_URL .'assets/business/photos/'. $file;
			$config['wm_type'] = 'overlay';
			$config['wm_overlay_path'] = NA_BASE_URL .'img/icons/watermark.png';
			$config['padding'] = 30;
			$config['wm_opacity'] = 80;
			//$config['wm_font_color'] = 'ffffff';
			$config['wm_vrt_alignment'] = 'bottom';
			$config['wm_hor_alignment'] = 'right';
			$config['wm_x_transp'] = 4;
			$config['wm_y_transp'] = 4;
			
			
			$this->image_lib->initialize($config); 

			$this->image_lib->watermark();
		 
		  //$this->load->library('image_lib'); 
		 
		  if ( ! $this->image_lib->watermark()) 
		  { 
			  $data['error'] = $this->image_lib->watermark_errors();
			   return $data;
		  } 
		  $this->image_lib->clear(); 
		  return;
		 }
		 
	 //+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//DELETE OLD LOGO
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	
	function delete_old_logo($bus_id){
			
			$db2 = $this->connect_my_db();
			$db2->where('ID' , $bus_id);
			$db2->from('u_business');
			$query = $db2->get();
			$row = $query->row_array();
			//has existing image
			if($row['BUSINESS_LOGO_IMAGE_NAME'] != ''){
				
				$file_large =  NA_URL .'assets/business/photos/' . $row['BUSINESS_LOGO_IMAGE_NAME']; # build the full path		
		
					   if (file_exists($file_large)) {
							unlink($file_large);
						}
						
						//delete image
						
						$idata['BUSINESS_LOGO_IMAGE_NAME'] = '';	
						$db2->where('ID' , $bus_id);
						$db2->update('u_business', $idata);
				return;
				
			//no existing image	
			}else{
				
				return;
			}
	
	}
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//CONVERT LOGO TO JPEG
	//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++	

	function convert_logo_jpg($str, $file){

		
		$config = array( 
		   'image_library' => 'ImageMagick',
		   'library_path' =>  '/usr/bin',
		   'source_image' => (NA_BASE_URL .'assets/business/photos/'. $file),
		   'new_image' => NA_BASE_URL .'assets/business/photos/'. $str . '.jpg'
		  
		  ); 

		  $this->image_lib->initialize($config); 
		 
		  $this->image_lib->clear(); 
		 return;
	}			 
	
	 //+++++++++++++++++++++++++++
	//UPDATE BUSINESS DETAILS
	//++++++++++++++++++++++++++		
	function update_my_namibia_do(){
	
			$email = $this->input->post('email', TRUE);
			$name = $this->input->post('title', TRUE);
			$tel = $this->input->post('tel', TRUE);
			$fax = $this->input->post('fax', TRUE);
			$cell2 = $this->input->post('cell', TRUE);
			$web = prep_url($this->input->post('url', TRUE));
			$pobox = $this->input->post('pobox', TRUE);
			$address = $this->input->post('address', TRUE);
			$description = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', TRUE)));
			$bus_id = $this->input->post('bus_id', TRUE);
			$id = $this->input->post('id', TRUE);

			//clean cell
			$cell = $this->clean_contact($cell2);
			//clean tel
			$tel2 = $this->clean_contact($tel);
			//clean fax
			$fax2 = $this->clean_contact($fax);
			
			$str1 = str_replace(' ', '',$cell);
			$cellNum = substr($str1,0,3);
			
			//VALIDATE INPUT
			if($this->CheckAndValidateEmail($email)){
				$val = FALSE;
				$error = 'Email address is not valid.';
					
			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';
					
			}elseif($name == ''){
				$val = FALSE;
				$error = 'Please provide us with your business name.';	
							
			//}elseif(($cell == '') || (!preg_match('/^[0-9]{1,}$/',$cell))){
//				$val = FALSE;
//				$error = 'Please provide us with a valid cellular number.';	
				
			}elseif($web != ''){
						
				if(!filter_var($web, FILTER_VALIDATE_URL)){
					$val = FALSE;
					$error = 'Please provide us with a valid website address or URL';
				}else{
				   $val = TRUE;	
				}
			
			}elseif(str_word_count($description) < 30){
				$val = FALSE;
				$error = 'Please provide a minimum of 30 words for your business description. Currently: '.str_word_count($description).' words.';	
				
			}else{
				$val = TRUE;
			}
			
		
			
				
				$this->load->library('user_agent');
				$agent = $agent = $this->agent->browser().' ver : '.$this->agent->version();
				$IP = $this->input->ip_address();
				$insertdata = array(
								  'BUSINESS_NAME'=> $name ,
								  'BUSINESS_TELEPHONE'=> '+264 ' .$tel2 ,
								   'BUSINESS_EMAIL'=> $email,
								   'BUSINESS_CELLPHONE'=> '+264 ' .$cell, 
								  'BUSINESS_FAX'=> '+264 ' .$fax2,
								  'BUSINESS_DESCRIPTION'=> $description,
								  'BUSINESS_POSTAL_BOX'=> $pobox,
								  'BUSINESS_URL' => $web,
								  'BUSINESS_PHYSICAL_ADDRESS' => $address
					);
			
	
			
			if($val == TRUE){
					
					$db2 = $this->connect_my_db();
					
					$db2->where('ID' , $bus_id);
					$db2->update('u_business', $insertdata);
					
					$this->sync_tourism_db($insertdata, $bus_id);
					//success redirect	
					$data['bus_id'] = $bus_id;

					$data['basicmsg'] = $name . ' has been updated successfully';

					$this->output->set_header("HTTP/1.0 200 OK");
					echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
				  	noty(options);</script>";
			}else{

					$data['bus_id'] = $bus_id;
					$data['error'] = $error;
				
					$this->output->set_header("HTTP/1.0 200 OK");
					echo "<script>var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				  	noty(options);</script>";	
				
			}

	}


	//+++++++++++++++++++++++++++
	//SYNC HAN/TOURISM LISTING
	//++++++++++++++++++++++++++	
	public function sync_tourism_db($data, $bus_id)
	{
		$insertdata = array(
								  'BUSINESS_NAME'=> $data['BUSINESS_NAME'] ,
								  'BUSINESS_TELEPHONE'=> '+264 ' .$data['BUSINESS_TELEPHONE'] ,
								   'BUSINESS_EMAIL'=> $data['BUSINESS_EMAIL'],
								   'BUSINESS_CELLPHONE'=> '+264 ' .$data['BUSINESS_CELLPHONE'], 
								  'BUSINESS_FAX'=> '+264 ' .$data['BUSINESS_FAX'],
								  'BUSINESS_DESCRIPTION'=> $data['BUSINESS_DESCRIPTION'],
								  'BUSINESS_POSTAL_BOX'=> $data['BUSINESS_POSTAL_BOX'],
								  'BUSINESS_URL' => $data['BUSINESS_URL'],
								  'BUSINESS_PHYSICAL_ADDRESS' => $data['BUSINESS_PHYSICAL_ADDRESS']
					);
		$db2 = $this->connect_tourism_db();
		$db2->where('ID', $bus_id);
		$db2->update('u_business', $insertdata);
	
	} 

	/**
++++++++++++++++++++++++++++++++++++++++++++
//VALIDATE EMAIL
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
function CheckAndValidateEmail($mail){
    if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
        // ok
        //list($user,$domaine)=split("@",$mail,2);
        //if(!checkdnsrr($domaine,"MX")&& !checkdnsrr($domaine,"A")){
            return FALSE;
        //}
       // else {
           // return FALSE;
        //}
    }
    else {
        return TRUE;
    }
}

/**
++++++++++++++++++++++++++++++++++++++++++++
//PHONE NUMBER VALIDATIONS
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */
  //+++++++++++++++++++++++++++
	//PREPEND CELL
	//++++++++++++++++++++++++++	
	function clean_contact($nr)
	{	
		//$nr = '+264 (0) 8171717 23';
		//remove ' ' , (, ), +
		$str1 = str_replace(' ','',str_replace(')','',str_replace('(','',str_replace('+','',$nr))));
		//get 1st 3 digits
		$str2 = substr($str1,0,3);
		
		if($str2 == '264'){

			$str3 = str_replace("264","",$str1);
			
		}else{

			$str3 = $str1;
		}
		
		return $str3;
		
		
	}		
    //+++++++++++++++++++++++++++
	//VALIDATE CELL
	//++++++++++++++++++++++++++	
	function validate_cell($nr)
	{
		switch($nr)
			{
			case '081':
			  
			  $val = FALSE;
			  return $val;
			  break;
			case '085':
			 
			 $val = FALSE;
			 return $val;
			 break;
			case '060':
			  
			 $val = FALSE;
			 return $val;
			 break;
			default:
			  $val = TRUE;
			  return $val;
			  
			}	
	}
/**
++++++++++++++++++++++++++++++++++++++++++++
//CLEAN URLS 4 MESSAGING
//Functions
++++++++++++++++++++++++++++++++++++++++++++	
 */	
function clean_url($str)
	{
		$str2 = str_replace(' ','-',str_replace("'","_",$str));
		return $str2;
	}
	
function un_clean_url($str)
	{
		$str2 = str_replace('-',' ',str_replace("_","'",$str));
		return $str2;
	}	
	//Shorten String
	function shorten_string($phrase, $max_words) {
		
   		$phrase_array = explode(' ',$phrase);
		
   		if(count($phrase_array) > $max_words && $max_words > 0){
		
      		$phrase = implode(' ',array_slice($phrase_array, 0, $max_words)).'...';
		}
			
   		return $phrase;
		
	}
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
//+eNcryption Functions
//+++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	
	/*Hash password*/
	
	function hash_password($username, $password){
		
		// Create a 256 bit (64 characters) long random salt
		// Let's add 'something random' and the username
		// to the salt as well for added security
		$salt = hash('sha256', uniqid(mt_rand(), true) . $this->config->item('encryption_key') . strtolower($username));
		
		// Prefix the password with the salt
		$hash = $salt . $password;
		
		// Hash the salted password a bunch of times
		for ( $i = 0; $i < 100000; $i ++ ) {
		  $hash = hash('sha256', $hash);
		}
		
		// Prefix the hash with the salt so we can find it back later
		$hash = $salt . $hash;
		return $hash;
		
	}
	

	/*Validate password*/
	
	function validate_password($username, $password){
		
		$sql = $this->db->query("SELECT *
			  					FROM `members`
								WHERE
				  			   `email` = '".$username."' LIMIT 1",TRUE);
		
		$res = array();	 
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){
				
			$r = $sql->row_array();
			//Store value for return
			$res['fname'] = $r['fname'];
			$res['admin_id'] = $r['admin_id'];
			$res['img_file'] = $r['img_file'];
			$res['last_login'] = $r['last_login'];
			// The first 64 characters of the hash is the salt
			$salt = substr($r['pass'], 0, 64);
			
			$hash = $salt . $password;
			
			// Hash the password as we did before
			for ( $i = 0; $i < 100000; $i ++ ) {
			  $hash = hash('sha256', $hash);
			}
			
			$hash = $salt . $hash;
			
			if ( $hash == $r['pass'] ) {
			  
			   $res['bool'] = TRUE;
			   //break;
			}else{
			  
			   $res['bool'] = FALSE;
				
			}
		}else{//no username match
			
			$res['bool'] = FALSE;
		}

		return $res;
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



	//connect to tourism db
	function connect_trip_db(){

		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'tripcom_admin';
		$config_db['password'] = 'vA!;&qZ\C;n"51x:MxfU';
		$config_db['database'] = 'tripcom_travel';

/*		$config_db['username'] = 'root';
		$config_db['password'] = '';
		$config_db['database'] = 'tripcom_travel';*/

		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
	}


	//connect to tourism db 
	function connect_my_db(){

		//connect to main database
		$config_db['hostname'] = 'nmh-db-1-cluster.cluster-cxonbylt4aio.eu-west-1.rds.amazonaws.com';
		$config_db['username'] = 'root';
		$config_db['password'] = 'OANdyn14784';
		$config_db['database'] = 'my_na';
/*				$config_db['username'] = 'root';
				$config_db['password'] = '';
				$config_db['database'] = 'my_na';*/

		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
	}

	//connect to tourism db
	function connect_tourism_db(){

		//connect to main database
		$config_db['hostname'] = 'localhost';
		$config_db['username'] = 'mynatour_usr';
		$config_db['password'] = 'aU^&1S1~8abJ';
		$config_db['database'] = 'mynatour_devdb';

		/*		$config_db['username'] = 'root';
				$config_db['password'] = '';
				$config_db['database'] = 'my_na';*/

		$config_db['dbdriver'] = 'mysql';
		$config_db['dbprefix'] = '';
		$config_db['pconnect'] = TRUE;
		$config_db['db_debug'] = TRUE;
		$config_db['cache_on'] = FALSE;
		$config_db['cachedir'] = '';
		$config_db['char_set'] = 'utf8';
		$config_db['dbcollat'] = 'utf8_general_ci';
		$config_db['swap_pre'] = '';
		$config_db['autoinit'] = TRUE;
		$config_db['stricton'] = FALSE;
		$maindb = $this->load->database($config_db, TRUE);
		$this->db->close();
		return $maindb;
	}




}
?>