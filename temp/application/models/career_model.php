<?php
class Career_model extends CI_Model{
	
 	function career_model(){
  		//parent::CI_model();
	    $this->load->library('encrypt');
		
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

		$config_db['dbdriver'] = 'mysqli';
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


//+++++++++++++++++++++++++++
	//GET ALL RESOURCES
	//++++++++++++++++++++++++++
	public function get_applicant_docs($client_id)
	{

		$db2 = $this->connect_my_db();
		$query = $db2->query("SELECT * FROM applicant_documents WHERE client_id = '".$client_id."' ORDER BY listing_date ASC", FALSE);

		if($query->result()){

			echo '<table class="table table-bordered table-striped"><tbody>';

			foreach($query->result() as $row){

				$title = str_replace("'", '', $row->title); //clean title

				//Get file extension
				$ext = substr($row->doc_file, strpos($row->doc_file, '.'), strlen($row->doc_file));
				$ext = strtoupper($ext);
				//End file extension

				$download_path = '<a href="'.NA_URL.'vacancy/download_applicant_document/'.$row->app_doc_id.'" title="Download File" rel="tooltip" style="cursor:pointer"><span class="btn btn-labeled btn-info"><i class="glyphicon glyphicon-download-alt"></i></span></a>';

				//End File Size
				echo '<tr>
						<td class="text-center" style="width:5%"><input name="doc_files[]" type="checkbox" value="'.$row->app_doc_id.'"></td>
						<td style="width:80%">'.$row->title.'</td>
            			<td style="text-align:right">
            				'.$download_path.'
							<a title="Delete File" rel="tooltip" style="cursor:pointer" onclick="delete_document('.$row->app_doc_id.', '."'".$title."'".')"><span class="btn btn-labeled btn-danger"><i class="glyphicon glyphicon-trash"></i></span></a>
						</td>
					  </tr>';
			}


			echo '</tbody>
				  </table>';

		} else {

			echo '<div class="alert">
			 		<h3>No Files added</h3>
					No files have been added. Please add a drop Files in the dropbox above
					</div>';

		}
	}



	function get_message($id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('msg_id', $id);
		$query = $db2->get('vacancy_auto_messages');

		return $query->row_array();

	}



	//+++++++++++++++++++++++++++
	//GET ALL MESSAGES
	//++++++++++++++++++++++++++

	public function get_all_messages()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_auto_messages WHERE bus_id = '".$bus_id."'", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
           				<th style="width:85%;font-weight:normal">Title</th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){


				$title = "'".$row->title."'";

				echo '<tr>
						<td style="width:2%"><input name="msg_files[]" type="checkbox" value="'.$row->msg_id.'"></td>
						<td style="width:30%"><a style="cursor:pointer" href="'.site_url('/').'career/update_message/'.$row->message_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:10%;text-align:right">
						<a title="Edit Message" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer" href="'.site_url('/').'career/update_message/'.$row->message_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Message" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_message('.$row->message_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Messages added</h3>
					No messages have been added. to add a new message please click on the add message button on the right</div>';

		}


	}



	function add_message_do() {

		$db2 = $this->connect_my_db();

		$title = $this->input->post('title', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Message Title Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'msg_typ'=> $slug ,
			'bus_id'=>$bus_id
		);


		if($val == TRUE){

			$db2->insert('vacancy_auto_messages', $insertdata);
			$mspid = $db2->insert_id();


			redirect(site_url('/').'career/update_message/'.$mspid.'/','refresh');


		} else {


		}
	}


	function update_message_do() {

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$msg_id = $this->input->post('msg_id', TRUE);
		$subject = $this->input->post('subject', TRUE);
		$msg_body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('body', FALSE)));
		//$sms_body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('sms_body', FALSE)));

		//VALIDATE INPUT
		if($subject == ''){
			$val = FALSE;
			$error = 'Subject Required';


		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'subject'=> $subject ,
			'msg_body'=> $msg_body
		);

		if($val == TRUE){

			$db2->where('bus_id' , $bus_id);
			$db2->where('msg_id' , $msg_id);
			$db2->update('vacancy_auto_messages', $insertdata);

		}else{


		}

	}




	function delete_message_do($mid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('msg_id', $did);
		$db2->delete('vacancy_auto_messages');

	}


	//+++++++++++++++++++++++++++
	//ACTION MESSAGE BULK
	//++++++++++++++++++++++++++
	public function action_message_bulk($type)
	{

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$msg_files = $this->input->post('msg_files');

		if(!empty($msg_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($msg_files as $mid) {

					$db2->where('msg_id', $mid);
					$db2->delete('vacancy_auto_messages');

				}

			}

		}

	}




	function get_am_nav() {

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT msg_id, title  FROM vacancy_auto_messages WHERE bus_id = '".$bus_id."' LIMIT 100", FALSE);

		if($query->result()) {

			foreach ($query->result() as $row) {

				echo '<li><a href="'.site_url('/').'career/update_message/'.$row->msg_id.'">'.$row->title.'</a></li>';

			}
		}
	}



	function update_sms_do() {

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$msg_id = $this->input->post('msg_id', TRUE);
		$sms_body = $this->input->post('sms_body', FALSE);

		$insertdata = array(
			'sms_body'=> $sms_body
		);

		$db2->where('bus_id' , $bus_id);
		$db2->where('msg_id' , $msg_id);
		$db2->update('vacancy_auto_messages', $insertdata);

	}




	function remove_potentia_entries() {

		$db2 = $this->connect_my_db();
		$query = $db2->query("SELECT ID AS client_id FROM u_client WHERE typ = 'potentia' LIMIT 100", FALSE);

		$i = 1;
		if($query->result()) {


			foreach ($query->result() as $row) {

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicants');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_achievements');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_affiliations');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_bio');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_careers');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_categories');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_core_competencies');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_disciplines');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_education');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_employment');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_languages');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_medical');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_references');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_scores');

				$db2->where('client_id', $row->client_id);
				$db2->delete('applicant_skills');
			$i++;
			}

			$db2->where('typ', 'potentia');
			$db2->delete('u_client');

			echo $i;
		}

	}

	function get_master_structure($cid, $parent='0', $role='role="tree"', $display='show') {

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$tree = '';

		$query = $db2->query("SELECT * FROM master_directories WHERE bus_id = '".$bus_id."' AND client_id = '".$cid."' AND parent = '".$parent."'", FALSE);

		if($query->result()){



			$tree .= '<ul '.$role.' id="try-'.$parent.'">';

			foreach($query->result() as $row){

				$branch = $this->get_master_structure($cid, $row->dir_id, 'role="group"', 'none');

				if($display=='none') {$style = 'style="display: none;"';} else { $style = ''; }

				$tree .= '

                   <li class="parent_li" role="treeitem" '.$style.'><span data-id="'.$row->dir_id.'" class="spot"><i class="fa fa-lg fa-folder-open"></i> '.$row->directory.'</span>
						'.$branch.'
                   </li>

				';

			}

			$tree.='</ul>';

			return $tree;

		}

	}


	//+++++++++++++++++++++++++++
	//GET ALL VACANCIES
	//++++++++++++++++++++++++++

	public function get_all_masterfiles($cat_id=0)
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		if($cat_id != '') { $qry = "AND b.dir_id = '".$cat_id."'"; } else { $qry = ""; }


		if($cat_id != 0) {

			$query2 = $db2->query("SELECT directory, client_id FROM master_directories WHERE bus_id = '" . $bus_id . "' AND dir_id = '" . $cat_id . "'", FALSE);

			$row2 = $query2->row();

			echo '<div class="row-fluit text-right"><h4><strong>Manage Documents For Directory: '.$row2->directory.'</strong></h4></div>';

			echo '<button class="btn btn-sm btn-primary "data-target="#myFiles" data-toggle="modal">Upload Documents</button>
				  <a class="btn btn-primary btn-sm dir-add" href="javascript:void(0)" data-id="'.$cat_id.'"><i class="glyphicon glyphicon-plus"></i> ADD NEW DIRECTORY</a>
				  <hr>';

			$query = $db2->query("SELECT * FROM masterfiles AS a

							  	  LEFT JOIN master_dir_int AS b ON a.master_id = b.master_id

							  	  WHERE a.bus_id = '" . $bus_id . "' AND b.dir_id = '" . $cat_id . "'

							  	  ", FALSE);

			if ($query->result()) {

				echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover dataTable no-footer" width="100%" role="grid" aria-describedby="dt_basic_info" style="width: 100%;">
				<thead>
					<tr>
						<th style="width:2%;font-weight:normal"></th>
						<th style="width:5%;font-weight:normal">Type</th>
						<th style="width:20%;font-weight:normal" class="hasinput">Title</th>
						<th style="width:20%;font-weight:normal" class="hasinput">Size</th>
           				<th style="width:20%;font-weight:normal" class="hasinput">Listing Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>

				</thead>
				<tbody>
				';

				foreach ($query->result() as $row) {

					echo '<tr>
						<td style="width:2%"><input name="doc_files[]" type="checkbox" value="' . $row->master_id . '"></td>
						<td style="width:5%"></td>
						<td style="width:20%">' . $row->title . '</td>
						<td style="width:20%">' . $row->size . '</td>
						<td style="width:10%">' . date('d.m.Y', strtotime($row->listing_date)) . '</td>
						<td style="width:10%;text-align:right">
						<a title="Delete Document" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_document(' . $row->master_id . " " . $row->title . ')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
				}


				echo '
				</tbody>
				</table>';

				echo "
				<script>
				$( '.dir-add' ).click(function() {


					var id = $(this).attr('data-id');

					$.ajax({
						type: 'get',
						url: '".site_url('/')."career/add_master_dir_do/'+id+'/'+".$row2->client_id." ,
						dataType: 'json',
						success: function (data) {


							if(data.child == 'true') {

								var item = '<li class=\"parent_li\" role=\"treeitem\" style=\"display: list-item;\"><span data-id=\"'+data.did+'\" class=\"spot\"><i class=\"fa fa-lg fa-folder-open\"></i> Test</span></li>';

							} else {

								var item = '<ul role=\"tree\" id=\"try-'+data.did+'\"><li class=\"parent_li\" role=\"treeitem\" style=\"display: list-item;\"><span data-id=\"'+data.did+'\" class=\"spot\"><i class=\"fa fa-lg fa-folder-open\"></i> Test</span></li></ul>';

							}

							$('#try-'+id).append(item);

						}
					});



				});
				</script>
				";

			} else {

				echo '<div class="alert">
			 		<h3>No Documents added</h3>
					No documents have been added. to add a new document please click on the add document button on the right</div>';

			}

		}
	}

	function add_masterfiles()
	{

		$db2 = $this->connect_my_db();

		$this->load->library('upload');  // NOTE: always load the library outside the loop

		$bus_id = $this->session->userdata('bus_id');
		$directory = $this->input->post('directory');

		$level = $this->input->post('level');

		$img_allowed =  array('gif' , 'GIF' , 'png' , 'PNG' , 'jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'tiff' , 'TIFF' , 'bmp' , 'BMP' );
		$doc_allowed =  array('doc' , 'DOC' , 'docx' , 'DOCX' , 'pdf' , 'PDF' , 'xls' , 'XLS' , 'xlsx' , 'XLXS' , 'csv' , 'CSV' );


		if(isset($_FILES['file']['name'])){

			$this->total_count_of_files = count($_FILES['file']['name']);
			/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */


			$_FILES['userfile']['name']    = $_FILES['file']['name'];
			$_FILES['userfile']['type']    = $_FILES['file']['type'];
			$_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
			$_FILES['userfile']['error']       = $_FILES['file']['error'];
			$_FILES['userfile']['size']    = $_FILES['file']['size'];

			$filename = $_FILES['file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);

			//Chech if document
			if(in_array($ext,$doc_allowed) ) {
				$dest_folder = "documents/vacancies/";
				$type = "document";
			}

			//Chech if image
			if(in_array($ext,$img_allowed) ) {
				$dest_folder = "images/";
				$type = "image";
			}


			$config['upload_path'] = NA_BASE_URL . 'assets/vacancies/'.$dest_folder;
			$config['allowed_types'] = 'jpg|jpeg|gif|png|JPEG|JPG|PNG|GIF|tiff|TIFF|bmp|BMP|doc|DOC|docx|DOCX|pdf|PDF|xls|XLS|xlsx|XLSX|csv|CSV';
			$config['overwrite']     = FALSE;
			/*
            $config['max_size']	= '0';
            $config['max_width']  = '8324';
            $config['max_height']  = '8550';
            $config['min_width']  = '200';
            $config['min_height']  = '200';
            */

			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->upload->initialize($config);

			if($this->upload->do_upload())
			{
				$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
				$size =  $this->upload->file_size;
				$oname =  $this->upload->orig_name;
				$width = $this->upload->image_width;
				$height = $this->upload->image_height;

				//populate array with values
				$data = array(
					'bus_id' => $bus_id,
					'title'=>$oname,
					'masterfile' =>$file,
					'size' => $size
				);

				//insert into database
				$db2->insert('masterfiles',$data);
				$id = $db2->insert_id();

				$data2 = array(
					'bus_id' => $bus_id,
					'master_id'=>$id,
					'dir_id' =>$directory,
				);

				//insert into database
				$db2->insert('master_dir_int',$data2);


			}else{
				//ERROR
				$val = FALSE;
				$data['error'] =  $this->upload->display_errors();

				echo $this->upload->display_errors();;


			}

			//redirect
			if($val == TRUE){

				//SUCESSS MESSAGE SCRIPT COMES HERE!!!!

			}else{

				//ERROR MESSAGE SCRIPT COMES HERE!!!!

			}
		}
	}


	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD DIRECTORY DO
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function add_master_dir_do($parent, $client){


		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		//check if child exists
		$query = $db2->query("SELECT dir_id FROM master_directories WHERE bus_id = '" . $bus_id . "' AND client_id = '".$client."' AND parent = '" . $parent . "'", FALSE);

		if ($query->result()) {

			$child = 'true';

		} else {

			$child = 'false';

		}

			$insertdata = array(
				'bus_id'=> $bus_id ,
				'client_id'=> $client ,
				'directory'=> 'test',
				'parent'=> $parent
			);

			$db2->insert('master_directories', $insertdata);

			$id = $db2->insert_id();

			$str = array('child' => $child, 'did' => $id);

			$this->output
				->set_content_type('application/json')
				->set_output(json_encode($str));


	}





	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//ADD PANELLIST DO
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function add_panellist_do(){


		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$name = $this->input->post('name', TRUE);
		$surname = $this->input->post('surname', TRUE);
		$email = $this->input->post('email', TRUE);
		$pass = $this->input->post('pass', TRUE);
		$pass2 = $this->input->post('pass2', TRUE);
		$type = $this->input->post('type', TRUE);
		$send_pass = $this->input->post('send_pass', TRUE);

		$this->session->set_flashdata('name', $name);
		$this->session->set_flashdata('surname', $surname);
		$this->session->set_flashdata('email', $email);

		$subject = 'Potentia Panellist Details';

		$msg = 'Hi '.$name.' '.$surname.',<br>
		Potentia created panellist entry for you with the following details: <br><br>Username:'.$email.'<br>Password:'.$pass.'<br><br>Please keep your password in a safe place.';


		$val = true;

		if($pass == $pass2) {

			if($pass != '') {

				$password = md5($pass);

				$val = true;
			} else {

				$val = false;
				$this->session->set_flashdata('error', 'Your Passwords do not match. Please try again.');
				redirect(site_url('/').'career/add_panellist/', 'refresh');

			}

		} else {

			$val = false;
			$this->session->set_flashdata('error', 'Your Passwords do not match. Please try again.');
			redirect(site_url('/').'career/add_panellist/', 'refresh');

		}


		if($name == '') { $val = false; }
		if($surname == '') { $val = false; }
		if($email == '') { $val = false; }

		if($val==true) {

			$insertdata = array(
				'bus_id'=> $bus_id ,
				'name'=> $name ,
				'surname'=> $surname ,
				'email'=> $email ,
				'password'=> $password,
				'type'=> $type
			);

			$db2->insert('interview_panellist', $insertdata);
			$id = $db2->insert_id();


			if($send_pass == 'Y') {

			$senddata = array(
				'name'=> 'Potentia Careers',
				'email'=> 'noreply@potentia.com.na',
				'body'=> $msg ,
				'email_to' => $email ,
				'subject' => 'Potentia Panellist Details'
			);



			$this->load->model('email_model');
			$this->email_model->send_enquiry($senddata);

			}


			redirect(site_url('/').'career/update_panellist/'.$id, 'refresh');

		} else {

			$this->session->set_flashdata('name', $name);
			$this->session->set_flashdata('surname', $surname);
			$this->session->set_flashdata('email', $email);
			$this->session->set_flashdata('error', 'Upload failed. Please make sure all mandetory fields are filled out');
			redirect(site_url('/').'career/add_panellist/', 'refresh');

		}
	}



	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	//UPDATE PANELLIST DO
	//++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function update_panellist_do(){


		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$name = $this->input->post('name', TRUE);
		$status = $this->input->post('status', TRUE);
		$surname = $this->input->post('surname', TRUE);
		$email = $this->input->post('email', TRUE);
		$pass = $this->input->post('pass', TRUE);
		$pass2 = $this->input->post('pass2', TRUE);
		$type = $this->input->post('type', TRUE);
		$send_pass = $this->input->post('send_pass', TRUE);

		$id = $this->input->post('panellist_id', TRUE);

		switch($status) {
			case TRUE:
				$status = 'live';
				break;
			case FALSE:
				$status = 'draft';
				break;
		}

		$msg = 'Hi '.$name.' '.$surname.',<br>
		Potentia created panellist entry for you with the following details: <br><br>Username:'.$email.'<br>Password:'.$pass.'<br><br>Please keep your password in a safe place.';


		$val = true;

		if($pass == $pass2) {

			if($pass != '') {

				$password = md5($pass);

				$val = true;
			} else {

				$val = false;
				$this->session->set_flashdata('error', 'Your Passwords do not match. Please try again.');
				redirect(site_url('/').'career/add_panellist/', 'refresh');

			}

		} else {

			$val = false;
			$this->session->set_flashdata('error', 'Your Passwords do not match. Please try again.');
			redirect(site_url('/').'career/add_panellist/', 'refresh');

		}


		if($name == '') { $val = false; }
		if($surname == '') { $val = false; }
		if($email == '') { $val = false; }

		if($val==true) {

			$insertdata = array(
				'name'=> $name ,
				'status'=> $status ,
				'surname'=> $surname ,
				'email'=> $email ,
				'password'=> $password ,
				'type'=> $type
			);

			$db2->where('panellist_id', $id);
			$db2->update('interview_panellist', $insertdata);



			if($send_pass == 'Y') {

				$senddata = array(
					'name'=> 'Potentia Careers',
					'email'=> 'noreply@potentia.com.na',
					'body'=> $msg ,
					'email_to' => $email ,
					'subject' => 'Potentia Panellist Details'
				);



				$this->load->model('email_model');
				$this->email_model->send_enquiry($senddata);

			}


		} else {


		}
	}



	//+++++++++++++++++++++++++++
	//GET PANELLIST
	//++++++++++++++++++++++++++

	function get_panellist($pid){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('panellist_id', $pid);
		$query = $db2->get('interview_panellist');

		return $query->row_array();

	}



	//+++++++++++++++++++++++++++
	//GET ALL Panellists
	//++++++++++++++++++++++++++

	public function get_all_panellists()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT * FROM interview_panellist WHERE bus_id = '".$bus_id."' ORDER BY listing_date ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal">Status</th>
						<th style="width:10%;font-weight:normal">Type</th>
           				<th style="width:25%;font-weight:normal">Name </th>
						<th style="width:10%;font-weight:normal">Listing Date </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Live</span>';
				}

				$name = "'".$row->name." ".$row->surname."'";

				echo '<tr>
						<td style="width:2%"><input name="pan_files[]" type="checkbox" value="'.$row->panellist_id.'"></td>
						<td style="width:10%">'.$status.'</td>
						<td style="width:10%">'.$row->type.'</td>
						<td style="width:25%"><a style="cursor:pointer" href="'.site_url('/').'career/update_panellist/'.$row->panellist_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->name.' '.$row->surname.'</div></a></td>
						<td style="width:10%">'.date('d.m.Y',strtotime($row->listing_date)).'</td>
						<td style="width:150%;text-align:right">

						<a title="Edit Panellist" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer" href="'.site_url('/').'career/update_panellist/'.$row->panellist_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Panellist" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_panellist('.$row->panellist_id.','.$name.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Panellists added</h3>
					No panellists have been added. To add a new panellist please click on the add panellist button on the top right</div>';

		}


	}

	function delete_panellist_do($pid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('panellist_id', $pid);
		$db2->delete('interview_panellist');


	}


	//+++++++++++++++++++++++++++
	//Action Panellist Bulk
	//++++++++++++++++++++++++++
	public function action_panellist_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$pan_files = $this->input->post('pan_files');

		if(!empty($pan_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($pan_files as $pid) {


					$db2->where('panellist_id', $pid);
					$db2->delete('interview_panellist');


				}

			}

			if($type > 1) {

				foreach($pan_files as $pid) {

					switch ($type) {
						case 2:
							$entry = 'live';
							break;
						case 3:
							$entry = 'draft';
							break;
						case 4:
							$entry = 'archive';
							break;

					}

					//populate array with values
					$data = array(
						'status' => $entry,
					);
					//insert into database
					$db2->where('panellist_id', $pid);
					$db2->update('interview_panellist', $data);

				}
			}


		}

	}




	//+++++++++++++++++++++++++++
	//GET JOB FILE
	//++++++++++++++++++++++++++

	function get_job_file($job_id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('job_id', $job_id);
		$query = $db2->get('interview_job_files');

		return $query->row_array();

	}



	//+++++++++++++++++++++++++++
	//GET ALL JOB FILES
	//++++++++++++++++++++++++++

	public function get_all_job_files()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT * FROM interview_job_files WHERE bus_id = '".$bus_id."' AND status != 'archive' ORDER BY listing_date ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:25%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Listing Date </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Live</span>';
				} else if ($row->status == 'archive') {
					$status = '<span class="label label-primary">Archive</span>';
				}

				$title = "'".$row->title."'";

				echo '<tr>
						<td style="width:2%"><input name="job_files[]" type="checkbox" value="'.$row->job_id.'"></td>
						<td style="width:10%">'.$status.'</td>
						<td style="width:25%"><a style="cursor:pointer" href="'.site_url('/').'career/update_job_file/'.$row->job_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:10%">'.date('d.m.Y',strtotime($row->listing_date)).'</td>
						<td style="width:150%;text-align:right">

						<a title="Edit Job File" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer" href="'.site_url('/').'career/update_job_file/'.$row->job_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Job File" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_file('.$row->job_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Job Files added</h3>
					No files have been added. To add a new file please click on the add job file button on the top right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//GET JOB VACANCIES
	//++++++++++++++++++++++++++
	public function get_job_vacancies_select($vid="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('title', 'DESC');
		$query = $db2->where('status', 'live');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('vacancies');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->vacancy_id == $vid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->vacancy_id.'" '.$selected.'>'.$row->title.'</option>';

			}

		}

	}


	//+++++++++++++++++++++++++++
	//GET JOB SURVEY
	//++++++++++++++++++++++++++
	public function get_job_survey_select($sid="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('title', 'DESC');
		$query = $db2->where('status', 'live');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('interview_surveys');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->survey_id == $sid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->survey_id.'" '.$selected.'>'.$row->title.'</option>';

			}

		}

	}


	//+++++++++++++++++++++++++++
	//GET JOB PANELLIST SELECT
	//++++++++++++++++++++++++++
	public function get_job_panellist_select()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('name', 'DESC');
		$query = $db2->where('status', 'live');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('interview_panellist');

		if($query->result()){


			foreach($query->result() as $row){

				echo '<option value="'.$row->panellist_id.'">'.$row->name.' '.$row->surname.'</option>';

			}

		}

	}


	//GET ALL JOB PENALLISTS
	//++++++++++++++++++++++++++
	public function get_all_job_panellists($job_id)
	{

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM interview_panellist_int AS A

							  RIGHT JOIN interview_panellist AS B ON A.panellist_id = B.panellist_id

							  WHERE A.bus_id = '".$bus_id."' AND A.job_id = '".$job_id."'", FALSE);



		if($query->result()){

		echo '
		<table class="table table-bordered table-striped">
			<tbody>
		';

			foreach($query->result() as $row){


				$name = "'".$row->name." ".$row->surname."'";

				echo '<tr>
						<td class="text-center" style="width:5%"><input name="pan_files[]" type="checkbox" value="'.$row->id.'"></td>
						<td>'.$row->name.' '.$row->surname.'</td>
            			<td style="text-align:right">

							<a title="Remove Panellist" rel="tooltip" style="cursor:pointer" onclick="remove_panellist('.$row->id.', '.$name.')"><span class="btn btn-labeled btn-danger"><i class="glyphicon glyphicon-trash"></i></span></a>
						</td>
					  </tr>';
			}


			echo '</tbody>
				  </table>';

		} else {

			echo '<div class="alert">No Panellists added</div>';

		}
	}


	//GET ALL JOB PENALLISTS
	//++++++++++++++++++++++++++
	public function get_all_job_shortlist($vid)
	{

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT A.va_id, A.applicant_id, A.client_id, B.CLIENT_NAME, B.CLIENT_SURNAME FROM vacancy_applicants AS A

							  RIGHT JOIN u_client AS B ON A.client_id = B.ID

							  WHERE A.bus_id = '".$bus_id."' AND A.vacancy_id = '".$vid."' AND A.status = 'short'", FALSE);



		if($query->result()){

			echo '
		<table class="table table-bordered table-striped">
			<tbody>
		';

			foreach($query->result() as $row){


				echo '<tr>

						<td>'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</td>
            			<td style="text-align:right">
							<a title="View Applicant" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer" href="'.site_url('/').'career/update_applicant/'.$row->client_id.'"><i class="glyphicon glyphicon-eye-open"></i></a>
						</td>
					  </tr>';
			}


			echo '</tbody>
				  </table>';

		} else {

			echo '<div class="alert">No Applicants in List</div>';

		}
	}



	//GET ALL JOB PENALLISTS
	//++++++++++++++++++++++++++
	public function get_all_job_documents($vid)
	{

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_documents WHERE bus_id = '".$bus_id."' AND vacancy_id = '".$vid."'", FALSE);



		if($query->result()){

			echo '
		<table class="table table-bordered table-striped">
			<tbody>
		';

			foreach($query->result() as $row){


				//Get file extension
				$ext = substr($row->doc_file, strpos($row->doc_file, '.'), strlen($row->doc_file));
				$ext = strtoupper($ext);
				//End file extension

				//Get File Size
				switch($row->type) {
					case 'document':
						$dest_folder = 'documents/vacancies';
						break;
					case 'image':
						$dest_folder = 'images';
						break;
				}

				$download_path = '<a href="'.NA_URL.'vacancy/download_vacancy_document/'.$row->doc_id.'" title="Download File" rel="tooltip" style="cursor:pointer"><span class="btn btn-labeled btn-info"><i class="glyphicon glyphicon-download-alt"></i></span></a>';

				if($row->level == 'basic') { $lev = '1'; }
				if($row->level == 'advanced') { $lev = '2'; }

				//End File Size

				echo '<tr>
						<td style="width:5%">'.$row->type.' ('.$ext.')</td>
						<td>'.$row->title.'</td>
						<td>'.$row->doc_size.'</td>
						<td>'.$row->level.'</td>
            			<td style="text-align:right">
							'.$download_path.'

						</td>
					  </tr>';
			}


			echo '</tbody>
				  </table>';

		} else {

			echo '<div class="alert">No Documents in List</div>';

		}
	}



	function add_job_file_do() {

		$db2 = $this->connect_my_db();
		$survey = $this->input->post('survey', TRUE);
		$vacancy = $this->input->post('vacancy', TRUE);
		$title = $this->input->post('title', TRUE);

		$bus_id = $this->session->userdata('bus_id');


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Vacancy title Required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';
//
		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'survey_id'=> $survey ,
			'vacancy_id'=> $vacancy ,
			'title'=> $title ,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->insert('interview_job_files', $insertdata);
			$id = $db2->insert_id();


			redirect(site_url('/').'career/update_job_file/'.$id.'/','refresh');


		} else {


		}
	}



	function add_job_panellist_do() {

		$db2 = $this->connect_my_db();
		$job_id = $this->input->post('job_id', TRUE);
		$panellist = $this->input->post('panellist', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		//CHECK IF EXISTS
		$query = $db2->query("SELECT * FROM interview_panellist_int WHERE job_id = '".$job_id."' AND panellist_id = '".$panellist."'", FALSE);

		if(!$query->result()) {

			$insertdata = array(
				'job_id' => $job_id,
				'panellist_id' => $panellist,
				'bus_id' => $bus_id
			);


			$db2->insert('interview_panellist_int', $insertdata);

		}



	}

	function remove_job_panellist_do($id) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('id', $id);
		$db2->delete('interview_panellist_int');

	}


	function delete_job_file_do($jid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('job_id', $jid);
		$db2->delete('interview_job_files');

	}


	//+++++++++++++++++++++++++++
	//Action Job Files Bulk
	//++++++++++++++++++++++++++
	public function action_job_files_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$job_files = $this->input->post('job_files');

		if(!empty($job_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($job_files as $jid) {


					$db2->where('job_id', $jid);
					$db2->delete('interview_job_files');


				}

			}

			if($type > 1) {

				foreach($job_files as $jid) {

					switch ($type) {
						case 2:
							$entry = 'live';
							break;
						case 3:
							$entry = 'draft';
							break;
						case 4:
							$entry = 'archive';
							break;

					}

					//populate array with values
					$data = array(
						'status' => $entry,
					);
					//insert into database
					$db2->where('job_id', $jid);
					$db2->update('interview_job_files', $data);

				}
			}


		}

	}


	function update_job_file_do() {

		$db2 = $this->connect_my_db();

		$survey = $this->input->post('survey', TRUE);
		$vacancy = $this->input->post('vacancy', TRUE);
		$title = $this->input->post('title', TRUE);

		$id = $this->input->post('job_id', TRUE);
		$status = $this->input->post('status', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		switch($status) {
			case TRUE:
				$status = 'live';
				break;
			case FALSE:
				$status = 'draft';
				break;
		}


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Job file title Required';


		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'survey_id'=> $survey ,
			'vacancy_id'=> $vacancy ,
			'status'=> $status ,
			'title'=> $title
		);



		if($val == TRUE){

			$db2->where('job_id' , $id);
			$db2->update('interview_job_files', $insertdata);


			redirect(site_url('/').'career/update_job_file/'.$id,'refresh');



		}else{


		}

	}




	//+++++++++++++++++++++++++++
	//GET INTERVIEW SURVEY DETAILS
	//++++++++++++++++++++++++++

	function get_interview_survey($survey_id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('survey_id', $survey_id);
		$query = $db2->get('interview_surveys');

		return $query->row_array();

	}


	//+++++++++++++++++++++++++++
	//GET ALL INTERVIEW SURVEYS
	//++++++++++++++++++++++++++

	public function get_all_interview_surveys()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT * FROM interview_surveys WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:30%;font-weight:normal">Listing Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Live</span>';
				}

				$title = "'".$row->title."'";

				echo '<tr>
						<td style="width:2%"><input name="sur_files[]" type="checkbox" value="'.$row->survey_id.'"></td>
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" href="'.site_url('/').'career/update_interview_survey/'.$row->survey_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:30%">'.date('d.m.Y',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Interview Survey" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer"
						href="'.site_url('/').'career/update_interview_survey/'.$row->survey_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Interview Survey" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_survey('.$row->survey_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Surveys added</h3>
					No surveys have been added. to add a new survey please click on the add survey button on the right</div>';

		}


	}


	function add_interview_survey_do() {

		$db2 = $this->connect_my_db();

		$title = $this->input->post('title', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('body', FALSE)));
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Survey title Required';
			redirect(site_url('/').'career/add_interview_survey/','refresh');

		}else{
			$val = TRUE;
		}

		$insertdata = array(

			'title'=> $title ,
			'body'=> $body ,
			'slug'=> $slug,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->insert('interview_surveys', $insertdata);
			$surveyid = $db2->insert_id();


			redirect(site_url('/').'career/update_interview_survey/'.$surveyid.'/','refresh');


		} else {


		}
	}


	function update_interview_survey_do() {

		$db2 = $this->connect_my_db();

		$title = $this->input->post('title', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('body', FALSE)));
		$status = $this->input->post('status', TRUE);
		$id = $this->input->post('survey_id', TRUE);


		$bus_id = $this->session->userdata('bus_id');

		switch($status) {
			case TRUE:
				$status = 'live';
				break;
			case FALSE:
				$status = 'draft';
				break;
		}


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Survey title Required';


		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'body'=> $body ,
			'status'=> strtolower($status),
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->where('survey_id' , $id);
			$db2->update('interview_surveys', $insertdata);
			//success redirect
			$data['survey_id'] = $id;

			//LOG
			$data['basicmsg'] = 'Survey has been updated successfully'.strtolower($status);


		}else{



		}

	}



	function delete_interview_survey_do($sid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('survey_id', $sid);
		$db2->delete('interview_surveys');

		$db2->where('survey_id', $sid);
		$db2->delete('interview_survey_questions');


	}



	function delete_interview_survey_question_do($qid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('question_id', $qid);
		$db2->delete('interview_survey_questions');


	}


	//+++++++++++++++++++++++++++
	//Action Vacancy Bulk
	//++++++++++++++++++++++++++
	public function action_interview_survey_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$sur_files = $this->input->post('sur_files');

		if(!empty($sur_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($sur_files as $sid) {

					$db2->where('survey_id', $sid);
					$db2->delete('interview_surveys');

					$db2->where('survey_id', $sid);
					$db2->delete('interview_survey_questions');


				}

			}

			if($type > 1) {

				foreach($sur_files as $sid) {

					switch ($type) {
						case 2:
							$entry = 'live';
							break;
						case 3:
							$entry = 'draft';
							break;

					}

					//populate array with values
					$data = array(
						'status' => $entry,
					);
					//insert into database
					$db2->where('survey_id', $sid);
					$db2->update('interview_surveys', $data);

				}
			}


		}

	}


	//SURVEY QUESTIONS
	function add_interview_survey_question_do()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');
		$question = $this->input->post('question',TRUE);
		$survey_id = $this->input->post('survey_id',TRUE);



		if($question != ''){

			$insertdata = array(
				'question'=> $question ,
				'survey_id'=> $survey_id,
				'bus_id'=> $bus_id,
				'sequence'=> 0
			);
			$db2->insert('interview_survey_questions', $insertdata);

			//LOG


		}else{

			$data['basicmsg'] = 'Please fill in the question field';


		}
	}


	//+++++++++++++++++++++++++++
	//UPDATE QUESTION DO
	//++++++++++++++++++++++++++
	public function update_interview_survey_question_do()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$question = $this->input->post('question',TRUE);


		$id = $this->input->post('question_id',TRUE);

		if($question != ''){

			//if($type == ''){ $type = 'Input';}

			$insertdata = array(
				'question'=> $question ,
				'bus_id'=> $bus_id,
				'sequence'=> 0
			);

			$db2->where('question_id', $id);
			$db2->update('interview_survey_questions', $insertdata);


		}else{

		}

	}


	//INTERVIEW SURVEY QUESTIONS
	function interview_survey_questions($survey_id)
	{

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM interview_survey_questions WHERE bus_id = '".$bus_id."' AND survey_id = '".$survey_id."' ORDER BY sequence ASC", FALSE);

		if($query->result()){

			echo '
					<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable" id="sortable">
						<thead>
							<tr style="font-size:14px;">
								<th style="width:5%;"></th>
								<th style="width:60%;font-weight:normal">Question </th>
								<th style="width:25%;min-width:60px; font-weight:normal"></th>
							</tr>
						</thead>
						<tbody>';

			foreach($query->result() as $row){


				$question = "'".$row->question."'";

				echo '<tr class="myDragClass" style="cursor: grab">
							<td style="width:5%"><input name="que_files[]" type="checkbox" value="'.$row->question_id.'"></td>
							<td>
							<input type="hidden" value="'.$row->question_id.'" />'.$row->question.'</td>
							<td class="text-right">

								<a onClick="update_question('.$row->question_id.')" data-toggle="modal" data-target="#myUpdateQuestion" class="btn btn-mini btn-success"><i class="glyphicon glyphicon-pencil"></i></a>
								<a onClick="delete_question('.$row->question_id.','.$question.')" class="btn btn-mini btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
							</td>
						  </tr>';

			}
			echo '</tbody>
				</table>
				<script type="text/javascript">

					$(document).ready(function () {
						$("#sortable tr").css("cursor", "move");
					});

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
									var img_id = $(this).val(), index = i;
									console.log(img_id+" "+index);
									 $.ajax({
										type: "post",

										url: "'. site_url('/').'career/update_interview_question_sequence/"+img_id+"/"+index ,
										success: function (data) {

										}
								});

							  });


						}

					}).disableSelection();

				</script>

				';

		}else{

			echo '<div class="alert">No Entries added</div>';

		}

	}

	public function update_interview_question_sequence($id , $sequence)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$data['sequence'] = $sequence;
		$db2->where('bus_id' , $bus_id);
		$db2->where('question_id' , $id);
		$db2->update('interview_survey_questions', $data);


	}


















	
	function sort_applicants($id, $type) {

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
	
		$insertdata = array(
			'status'=> $type ,
		);	
		
		if($type == 'short') {
			
			$db2->where('va_id' , $id);
			$db2->update('vacancy_applicants', $insertdata);			
		}
		
		if($type == 'long') {
			
			$db2->where('va_id' , $id);
			$db2->update('vacancy_applicants', $insertdata);			
		}	
		
		if($type == 'remove') {
			
			$db2->where('va_id', $id);
			$db2->delete('vacancy_applicants');			
		}			
		
	}


	function get_vacancy_applicants($id, $status) {

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		
		$query = $db2->query("SELECT A.vacancy_id, A.va_id, A.applicant_id, A.listing_date, A.weight, B.ID, B.CLIENT_NAME, B.CLIENT_SURNAME FROM vacancy_applicants AS A
							 
							  RIGHT JOIN u_client AS B ON A.client_id = B.ID
							  
							  WHERE A.bus_id = '".$bus_id."' AND A.vacancy_id = '".$id."' AND A.status = '".$status."' ORDER BY A.weight DESC", FALSE);
		
		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:2%;font-weight:normal"></th>
           				<th style="width:25%;font-weight:normal">Name </th>
						<th style="width:10%;font-weight:normal">Listing Date </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				$download_path = '<a href="'.site_url('/').'career/get_applicant_dump/'.$row->ID.'" title="Download CV File" rel="tooltip" style="cursor:pointer"><span class="btn btn-xs btn-info"><i class="glyphicon glyphicon-download-alt"></i></span></a>';

				$name = "'".$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME."'";

				//check weight

				$color = $this->get_applicant_weight($row->weight, $row->vacancy_id);




				echo '<tr>
						<td style="width:2%"><input name="app_files[]" type="checkbox" value="'.$row->va_id.'" class="app_'.$status.'"></td>
						<td style="width:25%"><i class="fa fa-fw fa-circle '.$color.'"></i>'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</td>
						<td style="width:10%">'.date('d.m.Y',strtotime($row->listing_date)).'</td>
						<td style="width:15%;text-align:right">
						'.$download_path.'
						<button title="View Applicant Details" type="button" data-id="'.$row->va_id.'" rel="tooltip" class="btn btn-xs btn-success apps" style="cursor:pointer"><i class="glyphicon glyphicon-eye-open"></i></button>
						<a title="Sort Applicant " rel="tooltip" class="btn btn-xs btn-primary" style="cursor:pointer" href="javascript:void(0)" onclick="action_applicant('.$row->va_id.','.$name.')" ><i class="glyphicon glyphicon-list"></i></a>
						</td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">No Applicants listed</div>';

		}
		
	}


	function get_applicant_weight($weight, $vid) {

		$db2 = $this->connect_my_db();

		$color = 'txt-color-red';

		$new_weight = 0;

		$query = $db2->query("SELECT id FROM vacancy_mr_int WHERE vacancy_id = '".$vid."' AND answer = 'Y'", FALSE);

		if($query->result()) {

			$rows = $query->num_rows();

			$new_weight = ($weight / $rows) * 100;

			if($new_weight <= 33) { $color = 'txt-color-red'; }
			if($new_weight > 33 && $new_weight <= 66) { $color = 'txt-color-orange';  }
			if($new_weight > 66 && $new_weight <= 100) { $color = 'txt-color-green'; }

		}

		return $color;

	}


	function get_app_messages($id) {

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_applicant_messages WHERE bus_id = '".$bus_id."' AND receiver_id = '".$id."' AND receiver_type = 'user' AND parent_id = '0'  ORDER BY listing_date ASC", FALSE);

		if($query->result()) {

			foreach ($query->result() as $row) {

				$message_replies = $this->get_app_reply_messages($id, $row->message_id);

				echo '
					<span class="timeline-seperator text-center"> <span>' . date('h:i F jS, Y', strtotime($row->listing_date)) . '</span></span>
							<div class="chat-body no-padding profile-message">
								<ul>
									<li class="message">

										<span class="message-text"> <a href="javascript:void(0);" class="username">' . $row->sender_name . ' </a> ' . $row->message . '</span>

									</li>
									' . $message_replies . '

									<li><form method="post" class="form-horizontal" id="reply-form-' . $row->message_id . '">
										<div class="input-group wall-comment-reply">

											<input type="text" name="reply_message_' . $row->message_id . '" id="reply_message_'.$row->message_id.'" class="form-control" placeholder="Type your message here...">
											<span class="input-group-btn">
												<button type="button" class="btn btn-primary replia" id="reply-butt-'.$row->message_id.'" data-id="' . $row->message_id . '" data-rec-id="' . $id . '">
													<i class="fa fa-reply"></i> Reply
												</button> </span>

										</div>
										</form>
									</li>
								</ul>

							</div>
					';

			}

			echo "


<script>


    $( '.replia' ).click(function() {

        var message_id = $(this).attr('data-id');
        var receive_id = $(this).attr('data-rec-id');
        var text = $('#reply_message_'+message_id).val();

        $.ajax({
            type: 'post',

            url: '".site_url('/')."career/post_app_reply',
            data: {
                sender_name: 'Christian Botha',
                sender_id: '1',
                message_id: message_id,
                receiver_id: receive_id,
                message: text
            },
            success: function (data) {

                $.smallBox({
                    title : 'Reply Message Posted!',
                    content : 'Operation Success',
                    color : '#659265',
                    iconSmall : 'fa fa-check fa-2x fadeInRight animated',
                    timeout : 4000
                });

				reload_messages();

				$('#reply-butt-'+message_id).html('<i class=\"fa fa-reply\"></i> Reply');

			}
		});

	});
	</script>
	";

		}
	}

	function get_app_reply_messages($id, $message_id) {

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_applicant_messages WHERE bus_id = '".$bus_id."' AND receiver_id = '".$id."' AND receiver_type = 'user' AND parent_id = '".$message_id."' ORDER BY listing_date ASC", FALSE);

		$msg = '';

		if($query->result()) {

			foreach ($query->result() as $row) {

				$message_replies = '';

				$msg.= '
					<li class="message message-reply">

						<span class="message-text"> <a href="javascript:void(0);" class="username">' . $row->sender_name . '</a> ' . $row->message . ' </span>


					</li>

					';

			}

			return $msg;
		}
	}

	//+++++++++++++++++++++++++++
	//POST APPLICANT MESSAGE
	//++++++++++++++++++++++++++
	function post_app_message() {

		$db2 = $this->connect_my_db();

		$sender_name = $this->input->post('sender_name', TRUE);
		$sender_id = $this->input->post('sender_id', TRUE);
		$receiver_id = $this->input->post('receiver_id', TRUE);
		$message = $this->input->post('message', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$insertdata = array(
			'sender_id'=> $sender_id ,
			'receiver_id'=> $receiver_id ,
			'sender_name'=> $sender_name ,
			'sender_type'=> 'admin',
			'receiver_type'=> 'user',
			'message'=> $message,
			'parent_id'=> 0,
			'bus_id'=>$bus_id
		);



		$db2->insert('vacancy_applicant_messages', $insertdata);


	}


	//+++++++++++++++++++++++++++
	//POST APPLICANT MESSAGE
	//++++++++++++++++++++++++++
	function post_app_reply() {

		$db2 = $this->connect_my_db();

		$message_id = $this->input->post('message_id', TRUE);

		$sender_name = $this->input->post('sender_name', TRUE);
		$sender_id = $this->input->post('sender_id', TRUE);
		$receiver_id = $this->input->post('receiver_id', TRUE);
		$message = $this->input->post('message', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$insertdata = array(
			'sender_id'=> $sender_id ,
			'receiver_id'=> $receiver_id ,
			'sender_name'=> $sender_name ,
			'sender_type'=> 'admin',
			'receiver_type'=> 'user',
			'message'=> $message,
			'parent_id'=> $message_id,
			'bus_id'=>$bus_id
		);



		$db2->insert('vacancy_applicant_messages', $insertdata);


	}


	//+++++++++++++++++++++++++++
	//GET CLIENT DETAILS
	//++++++++++++++++++++++++++

	function get_client($client_id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('vac_client_id', $client_id);
		$query = $db2->get('vacancy_clients');

		return $query->row_array();

	}

	//+++++++++++++++++++++++++++
	//GET ALL CLIENTS
	//++++++++++++++++++++++++++

	public function get_all_clients()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_clients WHERE bus_id = '".$bus_id."' ORDER BY listing_date ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Client </th>
						<th style="width:10%;font-weight:normal">Email</th>
						<th style="width:10%;font-weight:normal">Listing Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Live</span>';
				}

				$title = "'".$row->client_name."'";

				echo '<tr>
						<td style="width:2%"><input name="clt_files[]" type="checkbox" value="'.$row->vac_client_id.'"></td>
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" href="'.site_url('/').'career/update_client/'.$row->vac_client_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->client_name.'</div></a></td>
            			<td style="width:10%">'.$row->email.'</td>
						<td style="width:10%">'.date('d.m.Y',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Client Masterfiles" rel="tooltip" class="btn btn-mini btn-success" style="cursor:pointer" href="'.site_url('/').'career/masterfiles/'.$row->vac_client_id.'"><i class="glyphicon glyphicon-folder-open"></i></a>
						<a title="Edit Vacancy" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer" href="'.site_url('/').'career/update_client/'.$row->vac_client_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Client" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_client('.$row->vac_client_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Clients added</h3>
					No clients have been added. to add a new client please click on the add client button on the right</div>';

		}


	}

	function add_client_do() {

		$db2 = $this->connect_my_db();

		$title = $this->input->post('title', TRUE);
		$contact_name = $this->input->post('contact_name', TRUE);
		$email = $this->input->post('email', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);

		$top_level_array = array('OD and HR intervention', 'OD Recruitment', 'Peformance Management', 'Recruitment Assignments');

		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Client Name Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'client_name'=> $title ,
			'email'=> $email ,
			'slug'=> $slug,
			'bus_id'=>$bus_id
		);


		if($val == TRUE){

			$db2->insert('vacancy_clients', $insertdata);
			$clientid = $db2->insert_id();

			foreach($top_level_array as $key => $value) {

				$insertdata2 = array(
					'client_id'=> $clientid ,
					'bus_id'=> $bus_id ,
					'directory'=> $value,
					'bus_id'=>$bus_id
				);
				$db2->insert('master_directories', $insertdata2);

			}

			redirect(site_url('/').'career/update_client/'.$clientid.'/','refresh');


		} else {


		}
	}


	function update_client_do() {

		$db2 = $this->connect_my_db();

		$title = $this->input->post('title', TRUE);
		$email = $this->input->post('email', TRUE);
		$id = $this->input->post('client_id', TRUE);
		$status = $this->input->post('status', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);

		switch($status) {
			case TRUE:
				$status = 'live';
				break;
			case FALSE:
				$status = 'draft';
				break;
		}


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Client title Required';


		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'client_name'=> $title ,
			'email'=> $email ,
			'slug'=> $slug,
			'status'=> $status,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->where('vac_client_id' , $id);
			$db2->update('vacancy_clients', $insertdata);
			//success redirect
			$data['client_id'] = $id;


			$data['basicmsg'] = 'Client has been updated successfully'.strtolower($status);


		}else{


		}

	}




	function delete_client_do($cid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('vac_client_id', $cid);
		$db2->delete('vacancy_clients');

	}


	//+++++++++++++++++++++++++++
	//Action Client Bulk
	//++++++++++++++++++++++++++
	public function action_client_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$clt_files = $this->input->post('clt_files');

		if(!empty($clt_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($clt_files as $cid) {


					$db2->where('vac_client_id', $cid);
					$db2->delete('vacancy_clients');


				}

			}

			if($type > 1) {

				foreach($clt_files as $cid) {

					switch ($type) {
						case 2:
							$entry = 'live';
							break;
						case 3:
							$entry = 'draft';
							break;

					}

					//populate array with values
					$data = array(
						'status' => $entry,
					);
					//insert into database
					$db2->where('vac_client_id', $cid);
					$db2->update('vacancy_clients', $data);

				}
			}


		}

	}




	//+++++++++++++++++++++++++++
	//GET DEPARTMENT DETAILS
	//++++++++++++++++++++++++++

	function get_department($department_id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('department_id', $department_id);
		$query = $db2->get('vacancy_departments');

		return $query->row_array();

	}

	//+++++++++++++++++++++++++++
	//GET ALL DEPARTMENTS
	//++++++++++++++++++++++++++

	public function get_all_departments()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_departments WHERE bus_id = '".$bus_id."' ORDER BY department ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Department </th>
           				<th style="width:25%;font-weight:normal">Contact Person </th>
						<th style="width:10%;font-weight:normal">Email</th>
						<th style="width:10%;font-weight:normal">Listing Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Live</span>';
				}

				$title = "'".$row->department."'";

				echo '<tr>
						<td style="width:2%"><input name="dep_files[]" type="checkbox" value="'.$row->department_id.'"></td>
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" href="'.site_url('/').'career/update_department/'.$row->department_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->department.'</div></a></td>
						<td style="width:25%">'.$row->contact_name.'</td>
            			<td style="width:10%">'.$row->email.'</td>
						<td style="width:10%">'.date('d.m.Y',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Department" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer" href="'.site_url('/').'career/update_department/'.$row->department_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Department" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_department('.$row->department_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Department added</h3>
					No departments have been added. to add a new department please click on the add client button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//GET CLIENTS SELECT
	//++++++++++++++++++++++++++
	public function get_departments_select($did="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('department', 'DESC');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('vacancy_departments');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->department_id == $did) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->department_id.'" '.$selected.'>'.$row->department.'</option>';

			}

		}

	}


	function add_department_do() {

		$db2 = $this->connect_my_db();

		$department = $this->input->post('department', TRUE);
		$contact_name = $this->input->post('contact_name', TRUE);
		$email = $this->input->post('email', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($department);


		//VALIDATE INPUT
		if($department == ''){
			$val = FALSE;
			$error = 'Client Name Required';

		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'department'=> $department ,
			'contact_name'=> $contact_name ,
			'email'=> $email ,
			'slug'=> $slug,
			'bus_id'=>$bus_id
		);


		if($val == TRUE){

			$db2->insert('vacancy_departments', $insertdata);
			$depid = $db2->insert_id();


			redirect(site_url('/').'career/update_department/'.$depid.'/','refresh');


		} else {


		}
	}


	function update_department_do() {

		$db2 = $this->connect_my_db();

		$department = $this->input->post('department', TRUE);
		$contact_name = $this->input->post('contact_name', TRUE);
		$email = $this->input->post('email', TRUE);
		$id = $this->input->post('department_id', TRUE);
		$status = $this->input->post('status', TRUE);
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($department);

		switch($status) {
			case TRUE:
				$status = 'live';
				break;
			case FALSE:
				$status = 'draft';
				break;
		}


		//VALIDATE INPUT
		if($department == ''){
			$val = FALSE;
			$error = 'Department title Required';


		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'department'=> $department ,
			'contact_name'=> $contact_name ,
			'email'=> $email ,
			'slug'=> $slug,
			'status'=> $status,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->where('department_id' , $id);
			$db2->update('vacancy_departments', $insertdata);


		}else{


		}

	}




	function delete_department_do($did) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('department_id', $did);
		$db2->delete('vacancy_departments');

	}


	//+++++++++++++++++++++++++++
	//Action Department Bulk
	//++++++++++++++++++++++++++
	public function action_department_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$dep_files = $this->input->post('dep_files');

		if(!empty($dep_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($dep_files as $did) {


					$db2->where('department_id', $cid);
					$db2->delete('vacancy_departments');


				}

			}

			if($type > 1) {

				foreach($dep_files as $did) {

					switch ($type) {
						case 2:
							$entry = 'live';
							break;
						case 3:
							$entry = 'draft';
							break;

					}

					//populate array with values
					$data = array(
						'status' => $entry,
					);
					//insert into database
					$db2->where('department_id', $did);
					$db2->update('vacancy_departments', $data);

				}
			}

		}

	}





	//+++++++++++++++++++++++++++
	//GET MANAGEMENT SELECT
	//++++++++++++++++++++++++++
	public function get_management_select($mid="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('management_level');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->level_id == $mid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->level_id.'" '.$selected.'>'.$row->level.'</option>';

			}

		}

	}


	//+++++++++++++++++++++++++++
	//GET CLIENTS SELECT
	//++++++++++++++++++++++++++
	public function get_clients_select($cid="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('client_name', 'DESC');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('vacancy_clients');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->vac_client_id == $cid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->vac_client_id.'" '.$selected.'>'.$row->client_name.'</option>';

			}

		}

	}


	//+++++++++++++++++++++++++++
	//GET CLIENT TOKENS
	//++++++++++++++++++++++++++

	public function get_client_tokens($client)
	{
		$db2 = $this->connect_my_db();

		$date_today = date('d.m.Y');

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_client_tokens WHERE bus_id = '".$bus_id."' AND client = '".$client."' ORDER BY expiry_date DESC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">

           				<th style="width:30%;font-weight:normal">Expiry Date </th>
           				<th style="width:30%;font-weight:normal">Status </th>
						<th style="width:30%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				$exp_date = date('d.m.Y',strtotime($row->expiry_date));

				if($exp_date < $date_today) { $exp = 'expired'; } else { $exp = 'valid'; }

				echo '<tr>

						<td style="width:30%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.date('d.m.Y',strtotime($row->expiry_date)).'</div></td>
						<td style="width:30%">'.$exp.'</td>
						<td style="width:30%;text-align:right">
						<a title="Delete Token" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_token('.$row->token_id.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Tokens added</h3>
					No tokens have been added. to add a new token please click on the add token button</div>';

		}


	}


	function add_client_token_do() {

		$db2 = $this->connect_my_db();

		$token = $this->input->post('row_password', TRUE);
		$filo = $this->input->post('filo', TRUE);
		$client = $this->input->post('client', TRUE);
		$client_name = $this->input->post('client_name', TRUE);
		$email = $this->input->post('email', TRUE);
		$expiry_date = $this->input->post('expiry_date', TRUE);
		$send_pass = $this->input->post('send_pass', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		$expiry_date = date('Y-m-d',strtotime($expiry_date));

		$password = $this->admin_model->hash_password($email, $token);

		$files = json_encode($filo);

		$insertdata = array(
			'email'=> $email ,
			'client'=> $client ,
			'password'=> $password,
			'documents'=> $files,
			'expiry_date'=> $expiry_date,
			'bus_id'=>$bus_id
		);

		$db2->insert('vacancy_client_tokens', $insertdata);

		if($send_pass == 'Y') {

			$msg = 'Dear '.$client_name.', Potentia has opened and assigned to you a temporary login token. You can go here to login.<br><br>Your login details are:<br>Username: '.$email.'<br>Password: '.$token.'<br><br> This token will expire on '.$expiry_date;

			$senddata = array(
				'name' => 'Potentia Careers',
				'email' => 'noreply@potentia.com.na',
				'body' => $msg,
				'email_to' => $email,
				'subject' => 'Potentia Client Token Details'
			);


			$this->load->model('email_model');
			$this->email_model->send_enquiry($senddata);

		}

	}


	//++++++++++++++++++++++++++
	//GET CLIENT DOCS SELECT
	//++++++++++++++++++++++++++
	public function get_client_docs_select($cid)
	{

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');



		$query = $db2->query("SELECT * FROM masterfiles AS A

							  LEFT JOIN master_dir_int AS B ON A.master_id = B.master_id

							  LEFT JOIN master_directories AS C ON B.dir_id = C.dir_id

							  WHERE A.bus_id = '".$bus_id."' AND C.client_id = '".$cid."'", FALSE);


		if($query->result()){

			foreach($query->result() as $row){

				echo '<option value="'.$row->masterfile.'" data-id="'.$row->master_id.'">';

			}

		}

	}


	function delete_client_token_do($tid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('token_id', $tid);
		$db2->delete('vacancy_client_tokens');

	}


	//+++++++++++++++++++++++++++
	//GET ALL VACANCIES
	//++++++++++++++++++++++++++

	public function get_client_vacancies($cid)
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT * FROM vacancies WHERE bus_id = '".$bus_id."' AND status != 'archive' AND client_id = '".$cid."' ORDER BY listing_date ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:25%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Start Date</th>
						<th style="width:10%;font-weight:normal">End Date</th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Live</span>';
				} else if ($row->status == 'archive') {
					$status = '<span class="label label-primary">Archive</span>';
				}

				$title = "'".$row->title."'";

				echo '<tr>
						<td style="width:10%">'.$status.'</td>
						<td style="width:25%"><a style="cursor:pointer" href="'.site_url('/').'career/update_vacancy/'.$row->vacancy_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
            			<td style="width:10%">'.date('d.m.Y',strtotime($row->start_date)).'</td>
						<td style="width:10%">'.date('d.m.Y',strtotime($row->end_date)).'</td>

					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Vacancies added</h3>
					No vacancies have been added. to add a new vacancy please click on the add vacancy button on the right</div>';

		}


	}



	function upload_potentia() {

		$bus_id = '0';
		$db2 = $this->connect_my_db();

		$file_path = BASE_URL .'assets/potentia/applicants.csv';

		$this->load->library('csvimport');

		if ($this->csvimport->get_array($file_path)) {

			$csv_array = $this->csvimport->get_array($file_path);

			$i=0;
			foreach ($csv_array as $row) {


				//UPLOAD APPLICANT
				//----------------------------------------------------------

				//1.clean name
				$name = preg_replace('#[\s]+#', ' ', $row['name']);

				$pos = strpos($name, ' ');

				$fname = substr($name, 0, $pos);
				$sname = substr($name, $pos+1);

				$gender = '';
				if($row['gender'] == 'Male') { $gender = 'M'; }
				if($row['gender'] == 'Female') { $gender = 'F'; }


				//INSERT CLIENT
				$client_data = array(
					'CLIENT_NAME'=>$fname,
					'CLIENT_SURNAME'=>$sname,
					'CLIENT_GENDER'=>$gender

				);
				$db2->insert('u_client', $client_data);
				$client_id = $db2->insert_id();

				//INSERT APPLICANT
				$app_data = array(
					'bus_id'=>$bus_id,
					'client_id'=>$client_id,
					'type'=>'vacancy',
					'status'=>'live',
					'agreement'=>'Y'

				);
				$db2->insert('applicants', $app_data);
				$app_id = $db2->insert_id();



				//2.BIO

				if($row['pdf'] != '') {
					$pdf = $row['pdf'] . '.pdf';
					//echo $pdf . '<br>';
				}

				$current_tcc = $row['current_tcc'];
				$expected_tcc = $row['expected_tcc'];

				$job_title = $row['job_title'];
				$degree = $row['qualify'];

				$age = $row['age'];
				$ethnic = $row['ethnic'];

				$disability = '';
				if($row['disability'] == 'Yes') { $disability = 'Y'; }
				if($row['disability'] == 'No') { $disability = 'N'; }

				$country = '';
				$city = '';
				$region = '';

				if($row['location'] != '') {

					$location = explode( '>>', $row['location'] );


					$city = trim($location[0]);
					$region = trim($location[1]);
					$country_code = trim($location[2]);



					$query = $db2->where('COUNTRY_CODE', $country_code);
					$query = $db2->get('a_country');
					if ($query->result()) {

						$row2 = $query->row();
						$country = $row2->COUNTRY_NAME;

					}
				}

				//INSERT APPLICANT BIO
				$bio_data = array(
					'client_id'=>$client_id,
					'job_title'=>$job_title,
					'qualification'=>$degree,
					'current_tcc'=>$current_tcc,
					'expected_tcc'=>$expected_tcc,
					'age'=>$age,
					'ethnic'=>$ethnic,
					'disabled'=>$disability,
					'country'=>$country,
					'region'=>$region,
					'city'=>$city,
					'cv'=>$pdf

				);
				$db2->insert('applicant_bio', $bio_data);




				//3.APPLICANT EMPLOYMENT

				//$job_title = $row['job_title'];

				//INSERT EMPLOYMENT
				/*$employ_data = array(
					'client_id'=>$client_id,
					'position'=>$job_title

				);
				$db2->insert('applicant_employment', $employ_data);*/


				//4.APPLICANT EDUCATION

				//$degree = $row['qualify'];

				//INSERT EDUCATION
				/*$edu_data = array(
					'client_id'=>$client_id,
					'type'=>'tertiary',
					'qualification'=>$degree

				);
				$db2->insert('applicant_education', $edu_data);*/



				//5.APPLICANT CAREERS
				if($row['industries'] != '') {
					$industry = explode(',', $row['industries']);

					foreach ($industry as $career) {
						$career = trim($career);

						$slug = $this->clean_url_str($career);

						//check if career exists
						$query3 = $db2->where('bus_id', $bus_id);
						$query3 = $db2->where('career', $career);
						$query3 = $db2->get('vacancy_careers');
						if ($query3->result()) {

							$row3 = $query3->row();

							$career_id = $row3->career_id;

						} else {

							//INSERT VACANCY CAREER
							$career_data = array(
								'bus_id' => $bus_id,
								'career' => $career,
								'slug' => $slug

							);
							$db2->insert('vacancy_careers', $career_data);
							$career_id = $db2->insert_id();
						}

						//insert into applicant careers
						$app_career_data = array(
							'bus_id' => $bus_id,
							'client_id' => $client_id,
							'career_id' => $career_id

						);
						$db2->insert('applicant_careers', $app_career_data);

					}
				}



				//5.APPLICANT DISCIPLINES
				if($row['discipline'] != '') {
					$discipline = explode(',', $row['discipline']);

					foreach ($discipline as $disc) {
						$disc = trim($disc);

						$slug = $this->clean_url_str($disc);

						//check if discipline exists
						$query4 = $db2->where('bus_id', $bus_id);
						$query4 = $db2->where('discipline', $disc);
						$query4 = $db2->get('vacancy_disciplines');
						if ($query4->result()) {

							$row4 = $query4->row();

							$discipline_id = $row4->discipline_id;

						} else {

							//INSERT VACANCY CAREER
							$disc_data = array(
								'bus_id' => $bus_id,
								'discipline' => $disc,
								'slug' => $slug

							);
							$db2->insert('vacancy_disciplines', $disc_data);
							$discipline_id = $db2->insert_id();
						}

						//insert into applicant disciplines
						$app_disc_data = array(
							'bus_id' => $bus_id,
							'client_id' => $client_id,
							'discipline_id' => $discipline_id

						);
						$db2->insert('applicant_disciplines', $app_disc_data);

					}
				}

				$i++;
			}



		} else {

		}


	}



	//+++++++++++++++++++++++++++
	//GET ALL VACANCIES
	//++++++++++++++++++++++++++

	public function get_all_applicants()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');



		$query = $db2->query("SELECT * FROM applicants AS a

							  LEFT JOIN u_client AS b ON a.client_id = b.ID



							  WHERE a.bus_id = '".$bus_id."' AND a.type = 'vacancy'

							  ", FALSE);



		if($query->result()){

			echo '
				<table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
				<thead>
					<tr>
						<th style="width:2%;font-weight:normal"></th>
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"><input type="text" class="form-control" placeholder="Name" /></th>
						<th style="width:5%;font-weight:normal"><input type="text" class="form-control" placeholder="Level" /></th>
           				<th style="width:10%;font-weight:normal"><input type="text" class="form-control" placeholder="Job Title" /></th>
           				<th style="width:10%;font-weight:normal"><input type="text" class="form-control" placeholder="Qualification" /></th>
						<th style="width:5%;font-weight:normal"><input type="text" class="form-control" placeholder="Gender" /></th>
						<th style="width:5%;font-weight:normal"><input type="text" class="form-control" placeholder="Age" /></th>
						<th style="width:10%;font-weight:normal"><input type="text" class="form-control" placeholder="Salary" /></th>
						<th style="width:10%;font-weight:normal"><input type="text" class="form-control" placeholder="Nationality" /> </th>
						<th style="width:5%;font-weight:normal"><input type="text" class="form-control" placeholder="Drivers License" /> </th>
						<th style="width:10%;font-weight:normal; text-align: right"><button type="button" data-toggle="modal" data-target="#mySearch" class="btn btn-info">ADVANCED FILTER</button></th>
					</tr>
					<tr>
						<th style="width:2%;font-weight:normal"></th>
						<th style="width:5%;font-weight:normal">Status</th>
						<th style="width:20%;font-weight:normal" class="hasinput">Name</th>
						<th style="width:5%;font-weight:normal" class="hasinput">Level</th>
           				<th style="width:10%;font-weight:normal" class="hasinput">Job Title </th>
           				<th style="width:10%;font-weight:normal" class="hasinput">Qualification </th>
						<th style="width:5%;font-weight:normal" class="hasinput">Gender</th>
						<th style="width:5%;font-weight:normal" class="hasinput">Age</th>
						<th style="width:10%;font-weight:normal" class="hasinput">Salary</th>
						<th style="width:10%;font-weight:normal" class="hasinput">Nationality </th>
						<th style="width:5%;font-weight:normal" class="hasinput">Drivers License </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>

				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Inactive</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Active</span>';
				} else if ($row->status == 'archive') {
					$status = '<span class="label label-primary">Archive</span>';
				} else if ($row->status == 'semi') {
					$status = '<span class="label label-primary">Pending</span>';
				}

				$title = "'".$row->CLIENT_NAME." ".$row->CLIENT_SURNAME."'";

				$salary = preg_replace("/[^0-9,.]/", "", $row->current_tcc);
				$salary = round($salary, 2);

				$download_path = '<a href="'.NA_URL.'vacancy/get_applicant_dump/'.$row->client_id.'" title="Download CV File" rel="tooltip" style="cursor:pointer"><span class="btn btn-mini btn-info"><i class="glyphicon glyphicon-download-alt"></i></span></a>';

				echo '<tr>
						<td style="width:2%"><input name="app_files[]" type="checkbox" value="'.$row->client_id.'"></td>
						<td style="width:5%">'.$status.'</td>
						<td style="width:20%">'.$row->CLIENT_NAME." ".$row->CLIENT_SURNAME.'</td>
						<td style="width:5%">'.$row->level.'</td>
						<td style="width:10%">'.$row->job_title.'</td>
						<td style="width:10%">'.$row->qualification.'</td>
            			<td style="width:5%">'.$row->CLIENT_GENDER.'</td>
            			<td style="width:5%">'.$row->age.'</td>
						<td style="width:10%">'.$salary.'</td>
						<td style="width:10%">'.$row->nationality.'</td>
						<td style="width:5%">'.$row->drivers.'</td>
						<td style="width:10%;text-align:right">
						'.$download_path.'
						<a title="Edit Applicant" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer"
						href="'.site_url('/').'career/update_applicant/'.$row->client_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Applicant" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_applicant('.$row->client_id.", ".$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Applicants added</h3>
					No applicants have been added. to add a new applicant please click on the add applicant button on the right</div>';

		}


	}


	function delete_applicant_do($id) {

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		//delete from database
		$db2->where('bus_id', $bus_id);
		$db2->where('client_id', $id);
		$db2->delete('applicants');

		$db2->where('bus_id', $bus_id);
		$db2->where('client_id', $id);
		$db2->delete('vacancy_applicants');

	}


	//+++++++++++++++++++++++++++
	//Action Applicants Bulk
	//++++++++++++++++++++++++++
	public function action_applicants_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$app_files = $this->input->post('app_files');

		if(!empty($app_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($app_files as $aid) {

					//delete from database
					$db2->where('bus_id', $bus_id);
					$db2->where('client_id', $aid);
					$db2->delete('applicants');

					$db2->where('bus_id', $bus_id);
					$db2->where('client_id', $aid);
					$db2->delete('vacancy_applicants');

				}

			}

			if($type > 1 && $type < 5) {

				foreach($app_files as $aid) {

					switch ($type) {
						case 2:
							$entry = 'live';
							break;
						case 3:
							$entry = 'draft';
							break;
						case 4:
							$entry = 'archive';
							break;

					}

					//populate array with values
					$data = array(
						'status' => $entry,
					);
					//insert into database
					$db2->where('bus_id', $bus_id);
					$db2->where('client_id', $aid);
					$db2->update('applicants', $data);

				}
			}

			if($type == 5) {

				$app_array = array();

				foreach($app_files as $aid) {

					array_push($app_array, $aid);

				}

				$query = $db2->query("SELECT B.CLIENT_NAME, B.CLIENT_SURNAME, B.CLIENT_EMAIL, B.CLIENT_TELEPHONE, B.CLIENT_CELLPHONE, B.CLIENT_GENDER, B.CLIENT_DATE_OF_BIRTH, C.ethnic, C.nationality, C.country, C.region, C.city, C.marital_status, C.job_title, C.qualification, C.current_tcc, C.expected_tcc, C.id_number, C.disability, C.drivers_type, C.bee FROM applicants AS A

									  RIGHT JOIN u_client AS B ON A.client_id = B.ID

							  		  RIGHT JOIN applicant_bio AS C ON A.client_id = C.client_id

							  		  WHERE A.client_id IN (".implode(",",array_map("intval",$app_array)).") AND A.bus_id = '".$bus_id."' GROUP BY A.client_id", FALSE);

				if($query->result()){


					$this->load->dbutil();
					$this->load->helper('file');
					/* get the object   */
					$report = $query->result();
					/*  pass it to db utility function  */



					$delimiter = ",";
					$newline = "\r\n";
					ob_start();
					$new_report = $this->dbutil->csv_from_result($query, $delimiter, $newline);
					/*  Now use it to write file. write_file helper function will do it */


					$csvFilePath = BASE_URL."assets/csv/csv_file.csv";

					write_file($csvFilePath,$new_report);


				}

			}

		}

	}



	//+++++++++++++++++++++++++++
	//FILTER APPLICANTS
	//++++++++++++++++++++++++++
	public function filter_applicants()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');
		$vac_select = $this->input->post('vac_select');
		$ind_select = $this->input->post('ind_select');
		$dis_select = $this->input->post('dis_select');

		$ids = $this->input->post('ids');

		$join = "";
		$app_type = "";

		if($dis_select != '0') {

			$join.= " RIGHT JOIN applicant_disciplines AS f ON a.client_id = f.client_id AND f.discipline_id = '".$dis_select."' ";


		}

		if($vac_select != '0') {

			$join.= " RIGHT JOIN vacancy_applicants AS d ON a.applicant_id = d.applicant_id AND d.vacancy_id = '".$vac_select."' ";

		}

		if($ind_select != '0') {

			$join.= " RIGHT JOIN applicant_careers AS e ON a.client_id = e.client_id AND e.career_id = '".$ind_select."' ";

		}

		/*if($type == 'app_type' && $ids != '0') {

			$app_type = " AND a.type = '".$ids."' ";

		}*/




		$query = $db2->query("SELECT * FROM applicants AS a

							  LEFT JOIN u_client AS b ON a.client_id = b.ID

							  LEFT JOIN applicant_bio AS c ON a.client_id = c.client_id

							  ".$join."

							  WHERE a.bus_id = '".$bus_id."' AND a.type = 'vacancy'

							  ", FALSE);


		if($query->result()){
			echo '
				<table id="datatable_fixed_column" class="table table-striped table-bordered" width="100%">
				<thead>
					<tr>
						<th style="width:2%;font-weight:normal"></th>
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:20%;font-weight:normal"><input type="text" class="form-control" placeholder="Name" /></th>
						<th style="width:5%;font-weight:normal"><input type="text" class="form-control" placeholder="Level" /></th>
           				<th style="width:10%;font-weight:normal"><input type="text" class="form-control" placeholder="Job Title" /></th>
           				<th style="width:10%;font-weight:normal"><input type="text" class="form-control" placeholder="Qualification" /></th>
						<th style="width:5%;font-weight:normal"><input type="text" class="form-control" placeholder="Gender" /></th>
						<th style="width:5%;font-weight:normal"><input type="text" class="form-control" placeholder="Age" /></th>
						<th style="width:10%;font-weight:normal"><input type="text" class="form-control" placeholder="Salary" /></th>
						<th style="width:10%;font-weight:normal"><input type="text" class="form-control" placeholder="Nationality" /> </th>
						<th style="width:5%;font-weight:normal"><input type="text" class="form-control" placeholder="Drivers License" /> </th>
						<th style="width:10%;font-weight:normal; text-align: right"><button type="button" data-toggle="modal" data-target="#mySearch" class="btn btn-info">ADVANCED FILTER</button></th>
					</tr>
					<tr>
						<th style="width:2%;font-weight:normal"></th>
						<th style="width:5%;font-weight:normal">Status</th>
						<th style="width:20%;font-weight:normal" class="hasinput">Name</th>
						<th style="width:5%;font-weight:normal" class="hasinput">Level</th>
           				<th style="width:10%;font-weight:normal" class="hasinput">Job Title </th>
           				<th style="width:10%;font-weight:normal" class="hasinput">Qualification </th>
						<th style="width:5%;font-weight:normal" class="hasinput">Gender</th>
						<th style="width:5%;font-weight:normal" class="hasinput">Age</th>
						<th style="width:10%;font-weight:normal" class="hasinput">Salary</th>
						<th style="width:10%;font-weight:normal" class="hasinput">Nationality </th>
						<th style="width:5%;font-weight:normal" class="hasinput">Drivers License </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>

				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Inactive</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Active</span>';
				} else if ($row->status == 'archive') {
					$status = '<span class="label label-primary">Archive</span>';
				}

				$title = "'".$row->CLIENT_NAME." ".$row->CLIENT_SURNAME."'";

				$salary = preg_replace("/[^0-9,.]/", "", $row->current_tcc);
				$salary = round($salary, 2);

				$download_path = '<a href="'.site_url('/').'career/get_applicant_dump/'.$row->client_id.'" title="Download CV File" rel="tooltip" style="cursor:pointer"><span class="btn btn-mini btn-info"><i class="glyphicon glyphicon-download-alt"></i></span></a>';

				echo '<tr>
						<td style="width:2%"><input name="app_files[]" type="checkbox" value="'.$row->client_id.'"></td>
						<td style="width:5%">'.$status.'</td>
						<td style="width:20%">'.$row->CLIENT_NAME." ".$row->CLIENT_SURNAME.'</td>
						<td style="width:5%">'.$row->level.'</td>
						<td style="width:10%">'.$row->job_title.'</td>
						<td style="width:10%">'.$row->qualification.'</td>
            			<td style="width:5%">'.$row->CLIENT_GENDER.'</td>
            			<td style="width:5%">'.$row->age.'</td>
						<td style="width:10%">'.$salary.'</td>
						<td style="width:10%">'.$row->nationality.'</td>
						<td style="width:5%">'.$row->drivers.'</td>
						<td style="width:10%;text-align:right">
						'.$download_path.'
						<a title="Edit Applicant" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer"
						href="'.site_url('/').'career/update_applicant/'.$row->client_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Applicant" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_applicant('.$row->client_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '	<div class="row-fluid text-right"><div class="col-md-12 text-right"><hr><button type="button" data-toggle="modal" data-target="#mySearch" class="btn btn-info">ADVANCED FILTER</button></div></div>
					<div class="alert">
			 		<h3>No Applicants added</h3>
					No applicants have been added. to add a new applicant please click on the add applicant button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//GET VACNCY FILTER
	//++++++++++++++++++++++++++
	public function get_vacancy_filter()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->order_by('listing_date', 'DESC');
		$query = $db2->get('vacancies');
		if($query->result()){

			foreach($query->result() as $row){

				echo '<option value="'.$row->vacancy_id.'">'.$row->title.'</option>';

			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET INDUSTRY FILTER
	//++++++++++++++++++++++++++
	public function get_industry_filter()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('vacancy_careers');
		if($query->result()){

			foreach($query->result() as $row){


				echo '<option value="'.$row->career_id.'">'.$row->career.'</option>';


			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET DISCIPLINE FILTER
	//++++++++++++++++++++++++++
	public function get_disc_filter()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->order_by('discipline', 'DESC');
		$query = $db2->get('vacancy_disciplines');
		if($query->result()){

			foreach($query->result() as $row){


				echo '<option value="'.$row->discipline_id.'">'.$row->discipline.'</option>';


			}
		}
	}

	public function get_applicant_dump($client_id) {


		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$this->load->library('zip');
		//$this->load->helper('download');

		$data='NO DOWNLOAD! :: File(s): ';

		$info_array = array();

		$query = $db2->query("SELECT *,

							  (SELECT group_concat(CONCAT(F.type, ':', F.institution, ':', F.study_field, ':', F.qualification) SEPARATOR ',') FROM applicant_education AS F WHERE F.client_id = A.client_id) as edu,

							  (SELECT group_concat(G.skill SEPARATOR ', ') FROM applicant_skills AS G WHERE G.client_id = A.client_id) as skillz,

							  (SELECT group_concat(CONCAT(H.language, ':', H.prof_read, ':', H.prof_write, ':', H.prof_speak, ':', H.skill_read, ':', H.skill_write, ':', H.skill_speak, ':', H.first_language) SEPARATOR ',') FROM applicant_languages AS H WHERE H.client_id = A.client_id) as langs,

							  (SELECT group_concat(CONCAT(I.company, ':', I.business_type, ':', I.position, ':', I.level, ':', I.type, ':', I.salary_type, ':', I.benefits, ':', I.dur_from, ':', I.dur_to) SEPARATOR ',') FROM applicant_employment AS I WHERE I.client_id = A.client_id) as employ,

							  (SELECT group_concat(J.competency SEPARATOR ', ') FROM applicant_core_competencies AS J WHERE J.client_id = A.client_id) as comps

							  FROM applicants AS A

							  RIGHT JOIN u_client AS B ON A.client_id = B.ID

							  RIGHT JOIN applicant_bio AS C ON A.client_id = C.client_id

							  WHERE A.client_id = '".$client_id."' ", FALSE);

		if($query->result()){


				$row = $query->row();

				switch($row->CLIENT_GENDER) {
					case 'M':
						$gender = 'Male';
						break;
					case 'F':
						$gender = 'Female';
						break;
				}

				if($row->disabled == 'Y') { $disability = $row->disability; } else { $disability = ''; }


				//GET EDUCATION
				$edu = '';
				$edu2 = '';

				if($row->edu != '') {

					$go = explode(',',$row->edu);
					foreach( $go as $educ )
					{

						$go2 = explode(':',$educ);

						switch($go2[0]) {
							case 'secondary':
								$e_type = '<strong>Secondary Education:</strong>';
								break;
							case 'tertiary':
								$e_type = '<strong>Tertiary Education:</strong>';
								break;
							case 'course':
								$e_type = '<strong>Course:</strong>';
								break;
						}

						$edu.= $e_type.'<br>'.$go2[1].'<br>'.$go2[2].'<br>';
					}
					//END GET EDUCATION

				}


				//GET LANGUAGE
				$lng = '';
				$lng2 = '';

				if($row->langs != '') {

					$lgo = explode(',',$row->langs);
					foreach( $lgo as $langz )
					{

						$lgo2 = explode(':',$langz);


						$language = $lgo2[0];
						$pread = $lgo2[1];
						$pwrite = $lgo2[2];
						$pspeak = $lgo2[3];
						$sread = $lgo2[4];
						$swrite = $lgo2[5];
						$sspeak = $lgo2[6];
						$fl = $lgo2[7];

						if($sread != 'none') { $sr = '('.$sread.')'; } else { $sr = ''; }
						if($swrite != 'none') { $sw = '('.$swrite.')'; } else { $sw = ''; }
						if($sspeak != 'none') { $ss = '('.$sspeak.')'; } else { $ss = ''; }

						$lng.= '<strong>'.$language.'</strong><br>Read: '.$pread.' '.$sr.'<br>Write: '.$pwrite.' '.$sw.'<br>Speak: '.$pspeak.' '.$ss.'<br><br>';
					}
				}
				//END GET LANGUAGE

				//GET EMPLOYMENT
				$emp = '';
				$emp2 = '';

				if($row->employ != '') {

					$ego = explode(',',$row->employ);
					foreach( $ego as $employs )
					{

						$ego2 = explode(':',$employs);


						$company = $ego2[0];
						$position = $ego2[1];
						$btype = $ego2[2];
						$level = $ego2[3];
						$type = $ego2[4];
						$benefits = $ego2[5];
						$dur_from = $ego2[6];
						$dur_to = $ego2[7];


						$emp.= $type.' '.$level.' '.$position.' '.$btype.' at '.$company.' from '.date('Y', strtotime($dur_from)).' to '.date('Y', strtotime($dur_to)).'<br><strong>Benefits:</strong> '.$benefits;
					}
				}

				$doc_name = strtolower($row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'_career_bundle_'.date("dmYhis"));

				$html = '';
				$html.= $this->get_applicant_avatar($row->client_id);
				$html.= '<h1>'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</h1>';

				$html.= '
					<h2>Applicant Details:</h2>
					<table class="table table-striped">
						<tr><td><strong>Name: </strong></td><td>'.$row->CLIENT_NAME .' '. $row->CLIENT_SURNAME.'</td></tr>
						<tr><td><strong>Gender: </strong></td><td>'.$gender.'</td></tr>
						<tr><td><strong>Date of Birth: </strong></td><td>'.date('d M Y', strtotime($row->CLIENT_DATE_OF_BIRTH)).'</td></tr>
						<tr><td><strong>Email: </strong></td><td> '.$row->CLIENT_EMAIL.'</td></tr>
						<tr><td><strong>Tel: </strong></td><td> '.$row->CLIENT_TELEPHONE.'</td></tr>
						<tr><td><strong>Cell: </strong></td><td> '.$row->CLIENT_CELLPHONE.'</td></tr>
						<tr><td><strong>ID Number: </strong></td><td> '.$row->id_number.'</td></tr>
						<tr><td><strong>Job Title: </strong></td><td> '.$row->job_title.'</td></tr>
						<tr><td><strong>Qualification: </strong></td><td>'.$row->qualification.'</td></tr>
						<tr><td><strong>Current Salary: </strong></td><td>'.$row->currency.' '.$row->current_tcc.'</td></tr>
						<tr><td><strong>Expected Salary: </strong></td><td>'.$row->currency.' '.$row->expected_tcc.'</td></tr>
						<tr><td><strong>Marital Status: </strong></td><td> '.$row->marital_status.'</td></tr>
						<tr><td><strong>Nationality: </strong></td><td> '.$row->nationality.'</td></tr>
						<tr><td><strong>Ethnicity: </strong></td><td> '.$row->ethnic.'</td></tr>
						<tr><td><strong>Country: </strong></td><td> '.$row->country.'</td></tr>
						<tr><td><strong>Region: </strong></td><td> '.$row->region.'</td></tr>
						<tr><td><strong>City: </strong></td><td> '.$row->city.'</td></tr>
						<tr><td><strong>Racial Advantage: </strong></td><td>'. $row->bee.'</td></tr>
						<tr><td><strong>Drivers Licence: </strong></td><td> '.$row->drivers.' ('.$row->drivers_type.')</td></tr>
						<tr><td><strong>Disabiled: </strong></td><td> '.$row->disabled.'</tr>
						<tr><td><strong>Nature of Disability: </strong></td><td>'.$disability.'</td></tr>

					</table>
				<hr>
				';

				$html.= '<h2>Biography:</h2>'.$row->biography.'<hr>';

				$html.= '<h2>Leisure:</h2>'.$row->leisure.'<hr>';

				$html.= '<h2>Employment History:</h2>'.$emp.'<hr>';

				$html.= '<h2>Education:</h2>'.$edu.'<hr>';

				$html.= '<h2>Skills:</h2>'.$row->skillz.'<hr>';

				$html.= '<h2>Core Competencies:</h2>'.$row->comps.'<hr>';

				$html.= '<h2>Languages:</h2>'.$lng.'<hr>';


			// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
			$pdfFilePath = BASE_URL."assets/vacancy/bio/".$doc_name.".pdf";

			if (file_exists($pdfFilePath) == FALSE)
			{
				ini_set('memory_limit','64M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">


				$this->load->library('pdf');
				$pdf = $this->pdf->load();
				$pdf->WriteHTML($html); // write the HTML into the PDF
				$pdf->Output($pdfFilePath, 'F'); // save to file because we can

				$file =  BASE_URL."assets/vacancy/bio/".$doc_name.".pdf";


				$this->zip->read_file($file);


			}


			//ATTACH OTHER DOCUMENTS
			$query4 = $db2->query("SELECT * FROM applicant_documents WHERE client_id = '".$client_id."'", FALSE);

			if($query4->result()){

				foreach($query4->result() as $row4){


					$pdfFilePathA = 'https://d3rp5jatom3eyn.cloudfront.net/assets/vacancies/documents/'.$row4->doc_file;

					$data = file_get_contents($pdfFilePathA);
					$this->zip->add_data($row4->doc_file, $data);

				}

			}

			$this->zip->download($doc_name.'.zip');


		}else{


		}




	}


	//++++++++++++++++++++++++++
	//GET EMPLOYMENTS DUMP
	//++++++++++++++++++++++++++
	public function get_employments_dump($client_id)
	{

		$db2 = $this->connect_my_db();

		$str = '';

		$query = $db2->query("SELECT * FROM applicant_employment WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->dur_from != '0000-00-00') { $date_from = date('d.m.Y', strtotime($row->dur_from)); } else { $date_from = ''; }
				if($row->dur_to != '0000-00-00') { $date_to = date('d.m.Y', strtotime($row->dur_from)); } else { $date_to = ''; }

				$str.= '
		  			<strong>Company: </strong>'.$row->company.'<br>
					<strong>Posotion: </strong>'.$row->position.'<br>
					<strong>Business Type: </strong>'.$row->business_type.'<br>
					<strong>Job Level: </strong>'.$row->level.'<br>
					<strong>Job Type: </strong>'.$row->type.'<br>
					<strong>Salary Type: </strong>'.$row->salary_type.'<br>
					<strong>Salary: </strong>'.$row->salary.'<br>
					<strong>Frequency: </strong>'.$row->frequency.'<br>
					<strong>Benefits: </strong>'.$row->benefits.'<br>
					<strong>Duration: </strong>'.$date_from.' - '.$date_to.'<br><br>
				';

			}

		} else {

			$str = 'No Employment History available';

		}

		return $str;

	}


	//++++++++++++++++++++++++++
	//GET ACHIEVEMENTS DUMP
	//++++++++++++++++++++++++++
	public function get_achievements_dump($client_id)
	{

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT * FROM applicant_achievements WHERE client_id = '".$client_id."'", FALSE);

		$str = '';

		if($query->result()){

			foreach($query->result() as $row){

				if($row->receive_date != '0000-00-00') { $receive= date('d.m.Y', strtotime($row->receive_date)); } else { $receive = ''; }

				$str.= '<tr>
					<td style="width:200px">'.$row->achievement.'</td>
					<td style="width:200px">'.$row->organisation.'</td>
					<td style="width:200px">'.$receive.'</td>
					</tr>
				';

			}

		} else {

			$str = 'No Achievements available';

		}

		return $str;

	}


	//+++++++++++++++++++++++++++
	//GET APP CATEGORIES
	//++++++++++++++++++++++++++
	public function get_app_categories_dump($client_id)
	{
		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT * FROM applicant_categories WHERE client_id = '".$client_id."'", FALSE);


		$str = '';
		if($query->result()){

			$str = '<table class="table table-striped">';

			foreach($query->result() as $row){

				$str.=
					'<tr><td>';

				if($row->sub_cat != '0') { $str.=  $row->sub_cat; }
				if($row->sub_sub_cat != '0') { $str.=  ' / '.$row->sub_sub_cat; }
				if($row->sub_sub_sub_cat != '0') { $str.=  ' / '.$row->sub_sub_sub_cat; }

				$str.=
					'</td><td> ('.$row->experience.' Experience)</td></tr>';

			}

			$str.=  '</table>';

		}else{

			$str.=  '<div class="alert alert-danger alert-dismissible fade in">No Experience Categories added</div>';

		}

		return $str;
	}


	//+++++++++++++++++++++++++++
	//GET DISCIPLINES
	//++++++++++++++++++++++++++
	public function get_app_disciplines_dump($client_id)
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM applicant_disciplines AS A
	  						JOIN vacancy_disciplines AS B on A.discipline_id = B.discipline_id
							WHERE A.client_id = '".$client_id."' AND A.bus_id = '".$bus_id."'", FALSE);

		if($query->result()){
			foreach($query->result() as $row){
				$str =  '<span style="margin-right:5px;margin-bottom:5px;padding:5px;" class="label label-primary pull-left">'.$row->discipline.' ('.$row->experience.' Experience)</span>';
			}
		} else {
			$str = 'No Disciplinesavailable';
		}

		return $str;

	}


	//+++++++++++++++++++++++++++
	//GET SKILLS
	//++++++++++++++++++++++++++
	public function get_app_skills_dump($client_id)
	{
		$db2 = $this->connect_my_db();


		$query = $db2->where('client_id', $client_id);
		$query = $db2->get('applicant_skills');

		if($query->result()){
			foreach($query->result() as $row){
				$str = '<span style="margin-right:5px;margin-bottom:5px;padding:5px;" class="label label-primary pull-left">'.$row->skill.'</span>';
			}
		} else {
			$str = 'No skills available';
		}

		return $str;
	}






	//++++++++++++++++++++++++++
	//GET EDUCATION DUMP
	//++++++++++++++++++++++++++
	public function get_education_dump($type, $client_id)
	{

		$db2 = $this->connect_my_db();

		$str = '';

		$query = $db2->query("SELECT * FROM applicant_education WHERE client_id = '".$client_id."' AND type = '".$type."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->dur_from != '0000-00-00') { $date_from = date('d.m.Y', strtotime($row->dur_from)); } else { $date_from = ''; }
				if($row->dur_to != '0000-00-00') { $date_to = date('d.m.Y', strtotime($row->dur_from)); } else { $date_to = ''; }

				if($type == 'secondary') {

					$str = '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->institution.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->qualification.'</td>
						</tr>
						';

				}

				if($type == 'tertiary') {

					$str = '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->institution.'</td>
						<td>'.$row->study_field.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->qualification.'</td>
						</tr>
					';

				}

				if($type == 'course') {

					$str = '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->study_field.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->institution.'</td>
						</tr>
					';

				}

				return $str;

			}

		}

	}




	//+++++++++++++++++++++++++++
	//GET APPLICANT
	//++++++++++++++++++++++++++

	function get_applicant($id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM u_client AS a

						 		INNER JOIN applicants AS b ON a.ID = b.client_id AND b.bus_id = '".$bus_id."'

						 		INNER JOIN applicant_bio AS c ON a.ID = c.client_id

						 		WHERE a.ID = '".$id."'

						 		", FALSE);

		return $query->row_array();

	}

	//+++++++++++++++++++++++++++
	//GET APPLICANT AVATAR
	//++++++++++++++++++++++++++

	function get_applicant_avatar($id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT CLIENT_PROFILE_PICTURE_NAME FROM u_client WHERE ID = '".$id."'", FALSE);

		if($query->result()){

			$row = $query->row();

			if($row->CLIENT_PROFILE_PICTURE_NAME != "") {

				return '<img src="'.NA_URL.'assets/users/photos/'.$row->CLIENT_PROFILE_PICTURE_NAME.'" style="width:150px; margin-right:20px" class="img-polaroid pull-left">';

			} else {

				return '<img src="'.CMS_URL.'admin_src/img/placeholder-user.png" class="img-responsive">';

			}

		}

	}


	//++++++++++++++++++++++++++
	//GET General Details
	//++++++++++++++++++++++++++
	public function get_education($type, $client_id)
	{

		$db2 = $this->connect_my_db();


		$query = $db2->query("SELECT * FROM applicant_education WHERE client_id = '".$client_id."' AND type = '".$type."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->dur_from != '0000-00-00') { $date_from = date('d.m.Y', strtotime($row->dur_from)); } else { $date_from = ''; }
				if($row->dur_to != '0000-00-00') { $date_to = date('d.m.Y', strtotime($row->dur_from)); } else { $date_to = ''; }

				if($type == 'secondary') {

					echo '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->institution.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->qualification.'</td>
					</tr>
					';

				}

				if($type == 'tertiary') {

					echo '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->institution.'</td>
						<td>'.$row->study_field.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->qualification.'</td>
						</tr>
					';

				}

				if($type == 'course') {

					echo '<tr id="row-'.$row->app_education_id.'">
						<td>'.$row->study_field.'</td>
						<td>'.$date_from.' - '.$date_to.'</td>
						<td>'.$row->institution.'</td>
						</tr>
					';

				}

			}

		}

	}


	//+++++++++++++++++++++++++++
	//GET DISCIPLINES
	//++++++++++++++++++++++++++
	public function get_app_disciplines($client_id)
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM applicant_disciplines AS A
	  						JOIN vacancy_disciplines AS B on A.discipline_id = B.discipline_id
							WHERE A.client_id = '".$client_id."' AND A.bus_id = '".$bus_id."'", FALSE);

		if($query->result()){
			foreach($query->result() as $row){
				echo '<h4>'.$row->discipline.'</h4>';
			}
		}
	}


	//+++++++++++++++++++++++++++
	//GET DISCIPLINES
	//++++++++++++++++++++++++++
	public function get_app_industries($client_id)
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


	}


	//+++++++++++++++++++++++++++
	//GET SKILLS
	//++++++++++++++++++++++++++
	public function get_app_skills($client_id)
	{
		$db2 = $this->connect_my_db();


		$query = $db2->where('client_id', $client_id);
		$query = $db2->get('applicant_skills');
		if($query->result()){
			foreach($query->result() as $row){
				echo '<span style="margin-right:5px;margin-bottom:5px;padding:5px;" class="label label-primary pull-left">'.$row->skill.'</span>';
			}
		}
	}


	//++++++++++++++++++++++++++
	//GET ACHIEVEMENTS
	//++++++++++++++++++++++++++
	public function get_achievements($client_id)
	{

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT * FROM applicant_achievements WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->receive_date != '0000-00-00') { $receive= date('d.m.Y', strtotime($row->receive_date)); } else { $receive = ''; }

				echo '<tr id="row-'.$row->achievement_id.'">
					<td>'.$row->achievement.'</td>
					<td>'.$row->organisation.'</td>
					<td>'.$receive.'</td>
					<td></td>
				</tr>
				';

			}

		}

	}


	//++++++++++++++++++++++++++
	//GET EMPLOYMENTS
	//++++++++++++++++++++++++++
	public function get_employments($client_id)
	{

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT * FROM applicant_employment WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->dur_from != '0000-00-00') { $date_from = date('d.m.Y', strtotime($row->dur_from)); } else { $date_from = ''; }
				if($row->dur_to != '0000-00-00') { $date_to = date('d.m.Y', strtotime($row->dur_from)); } else { $date_to = ''; }

				echo '<tr id="row-'.$row->employment_id.'">
					<td>'.$row->company.'</td>
					<td>'.$row->position.'</td>
					<td>'.$row->business_type.'</td>
					<td>'.$row->level.'</td>
					<td>'.$row->type.'</td>
					<td>'.$row->salary_type.'</td>
					<td>'.$row->salary.'</td>
					<td>'.$row->frequency.'</td>
					<td>'.$row->benefits.'</td>
					<td>'.$date_from.' - '.$date_to.'</td>
					<td></td>
				</tr>
				';

			}

		}

	}


	//++++++++++++++++++++++++++
	//GET LANGUAGES
	//++++++++++++++++++++++++++
	public function get_languages($client_id)
	{

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT * FROM applicant_languages WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->skill_read != 'none') { $sread = '('.$row->skill_read.')'; } else { $sread = ''; }
				if($row->skill_write != 'none') { $swrite = '('.$row->skill_write.')'; } else { $swrite = ''; }
				if($row->skill_speak != 'none') { $sspeak = '('.$row->skill_speak.')'; } else { $sspeak = ''; }

				echo '<tr id="row-'.$row->app_language_id.'">
					<td>'.$row->language.' </td>
					<td>'.$row->prof_read.' '.$sread.'</td>
					<td>'.$row->prof_write.' '.$swrite.'</td>
					<td>'.$row->prof_speak.' '.$sspeak.'</td>
					<td>'.$row->first_language.'</td>
					<td></td>
				</tr>
				';

			}

		}

	}


	//++++++++++++++++++++++++++
	//GET REFERENCES
	//++++++++++++++++++++++++++
	public function get_references($client_id)
	{

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT * FROM applicant_references WHERE client_id = '".$client_id."'", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				echo '<tr id="row-'.$row->reference_id.'">
					<td>'.$row->first_name.' '.$row->last_name.'</td>
					<td>'.$row->organisation.'</td>
					<td>'.$row->tel.'</td>
					<td>'.$row->email.'</td>
					<td></td>
				</tr>
				';

			}

		}

	}




	//+++++++++++++++++++++++++++
	//ADD Discipline DO
	//++++++++++++++++++++++++++
	public function add_applicant_do()
	{

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$fname = $this->input->post('fname', TRUE);
		$mname = $this->input->post('mname', TRUE);
		$lname = $this->input->post('lname', TRUE);
		$dob = $this->input->post('dob', TRUE);
		$age = $this->input->post('age', TRUE);
		$gender = $this->input->post('gender', TRUE);
		$nationality = $this->input->post('nationality', TRUE);
		$ethnic = $this->input->post('ethnic', TRUE);
		$marital = $this->input->post('marital', TRUE);
		$job_title = $this->input->post('job_title', TRUE);
		$qualify = $this->input->post('qualify', TRUE);
		$c_salary = $this->input->post('c_salary', TRUE);
		$e_salary = $this->input->post('e_salary', TRUE);
		$tel = $this->input->post('tel', TRUE);
		$cell = $this->input->post('cell', TRUE);
		$email = $this->input->post('email', TRUE);
		$country = $this->input->post('country', TRUE);
		$region = $this->input->post('region', TRUE);
		$city = $this->input->post('city', TRUE);
		$physical = $this->input->post('physical', TRUE);
		$postal = $this->input->post('postal', TRUE);
		$level = $this->input->post('level', TRUE);


		//CHECK IF USER EXISTS IN CLIENTS
		$query = $db2->query("SELECT * FROM u_client WHERE CLIENT_EMAIL = '".$email."'", FALSE);


		if($query->result()){

			$row = $query->row();

			if(isset($row->ID)) {

				//CHECK IF USER EXISTS IN APPLICANTS
				$query2 = $db2->query("SELECT applicant_id FROM applicants WHERE client_id = '".$row->ID."'", FALSE);

				if($query2->result()){


					$query3 = $db2->query("SELECT applicant_id FROM applicants WHERE client_id = '".$row->ID."' AND bus_id = '".$bus_id."'", FALSE);

					if($query3->result()){

						echo 'email_exists';

					} else {

						$val = FALSE;

						//UPDATE U_CLIENT TABLE
						if($country != "") {
							$data['CLIENT_COUNTRY'] = $country;
							$val = TRUE;
						}

						if($region != "") {
							$data['CLIENT_REGION'] = $region;
							$val = TRUE;
						}

						if($city != "") {
							$data['CLIENT_CITY'] = $city;
							$val = TRUE;
						}

						if($gender != "") {
							$data['CLIENT_GENDER'] = $gender;
							$val = TRUE;
						}


						if($tel != "") {
							$data['CLIENT_TELEPHONE'] = $tel;
							$val = TRUE;
						}

						if($row->VERIFIED == 'N') {
							if($cell != '') {
								$data['CLIENT_CELLPHONE'] = $cell;
								$val = TRUE;
							}
						}

						if($val == TRUE) {

							$db2->where('ID', $row->ID);
							$db2->update('u_client', $data);

						}


						//--------------------

						$insertdata2 = array(
							'bus_id'=> $bus_id,
							'client_id'=> $row->ID,
							'email'=> $email,
							'level'=> $level,
							'type'=> 'vacancy'
						);

						$db2->insert('applicants', $insertdata2);
						$app_id = $db2->insert_id();

						$insertdata3 = array(
							'client_id'=> $row->ID,
							'job_title'=> $job_title,
							'qualification'=> $qualify,
							'current_tcc'=> $c_salary,
							'expected_tcc'=> $e_salary,
							'age'=> $age,
							'ethnic'=> $ethnic,
							'marital_status'=> $marital,
							'nationality'=> $nationality,
							'country'=> $country,
							'region'=> $region,
							'city'=> $city,
							'box_address'=> $postal,
							'address'=> $physical
						);

						$db2->where('client_id', $row->ID);
						$db2->update('applicant_bio', $insertdata3);


						echo $row->ID;


					}



				} else {


					//$insertdata = array();

					$val = FALSE;

					//UPDATE U_CLIENT TABLE
					if($country != "") {
						$data['CLIENT_COUNTRY'] = $country;
						$val = TRUE;
					}

					if($region != "") {
						$data['CLIENT_REGION'] = $region;
						$val = TRUE;
					}

					if($city != "") {
						$data['CLIENT_CITY'] = $city;
						$val = TRUE;
					}

					if($gender != "") {
						$data['CLIENT_GENDER'] = $gender;
						$val = TRUE;
					}


					if($tel != "") {
						$data['CLIENT_TELEPHONE'] = $tel;
						$val = TRUE;
					}

					if($row->VERIFIED == 'N') {
						if($cell != '') {
							$data['CLIENT_CELLPHONE'] = $cell;
							$val = TRUE;
						}
					}

					if($val == TRUE) {

						$db2->where('ID', $row->ID);
						$db2->update('u_client', $data);

					}


					//--------------------

					$insertdata2 = array(
						'bus_id'=> $bus_id,
						'client_id'=> $row->ID,
						'email'=> $email,
						'level'=> $level,
						'type'=> 'vacancy'
					);

					$db2->insert('applicants', $insertdata2);
					$app_id = $db2->insert_id();

					$insertdata3 = array(
						'client_id'=> $row->ID,
						'job_title'=> $job_title,
						'qualification'=> $qualify,
						'current_tcc'=> $c_salary,
						'expected_tcc'=> $e_salary,
						'age'=> $age,
						'ethnic'=> $ethnic,
						'marital_status'=> $marital,
						'nationality'=> $nationality,
						'country'=> $country,
						'region'=> $region,
						'city'=> $city,
						'box_address'=> $postal,
						'address'=> $physical
					);

					$db2->where('client_id', $row->ID);
					$db2->update('applicant_bio', $insertdata3);


					echo $row->ID;


				}

			} else {

				echo 'error';

			}

		} else {

			$insertdata = array(
				'CLIENT_EMAIL'=> $email,
				'CLIENT_NAME'=> $fname,
				'CLIENT_SURNAME'=> $lname,
				'CLIENT_CELLPHONE'=> $cell,
				'CLIENT_TELEPHONE'=> $tel,
				'CLIENT_DATE_OF_BIRTH'=> $dob,
				'CLIENT_GENDER'=> $gender
			);

			$db2->insert('u_client', $insertdata);
			$client_id = $db2->insert_id();

			if(isset($client_id)) {

				$insertdata2 = array(
					'bus_id'=> $bus_id,
					'client_id'=> $client_id,
					'email'=> $email,
					'level'=> $level,
					'type'=> 'vacancy'
				);

				$db2->insert('applicants', $insertdata2);
				$app_id = $db2->insert_id();



				$insertdata3 = array(
					'client_id'=> $client_id,
					'job_title'=> $job_title,
					'qualification'=> $qualify,
					'current_tcc'=> $c_salary,
					'expected_tcc'=> $e_salary,
					'age'=> $age,
					'ethnic'=> $ethnic,
					'marital_status'=> $marital,
					'nationality'=> $nationality,
					'country'=> $country,
					'region'=> $region,
					'city'=> $city,
					'box_address'=> $postal,
					'address'=> $physical
				);

				$db2->insert('applicant_bio', $insertdata3);
				echo $client_id;


			} else {

				echo 'error';

			}
		}


	}





	//++++++++++++++++++++++++++
	//GET COUNTRY SELECT
	//++++++++++++++++++++++++++
	public function get_country_select($country="")
	{

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT * FROM a_country", FALSE);


		if($query->result()){

			foreach($query->result() as $row){

				if($country == "") {
					if($row->COUNTRY_NAME == 'Namibia') { $selected = 'selected'; } else { $selected = '';}
				} else {
					if($row->ID == $country) { $selected = 'selected'; } else { $selected = '';}
				}

				echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->COUNTRY_NAME.'</option>';

			}

		}

	}

	//++++++++++++++++++++++++++
	//GET REGIONS SELECT
	//++++++++++++++++++++++++++
	public function get_region_select($region="")
	{

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT ID, REGION_NAME FROM a_map_region", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->ID == $region) { $selected = 'selected'; } else { $selected = '';}

				echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->REGION_NAME.'</option>';

			}

		}

	}


	//++++++++++++++++++++++++++
	//GET CITY SELECT
	//++++++++++++++++++++++++++
	public function get_city_select($city="")
	{

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT ID, MAP_LOCATION FROM a_map_location", FALSE);

		if($query->result()){

			foreach($query->result() as $row){

				if($row->ID == $city) { $selected = 'selected'; } else { $selected = '';}

				echo '<option value="'.$row->ID.'" '.$selected.'>'.$row->MAP_LOCATION.'</option>';

			}

		}

	}





	//+++++++++++++++++++++++++++
	//GET ALL DISCIPLINES
	//++++++++++++++++++++++++++

	public function get_all_disciplines()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_disciplines WHERE bus_id = '".$bus_id."' ORDER BY discipline ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
           				<th style="width:88%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				$title = "'".$row->discipline."'";

				echo '<tr>
						<td style="width:2%"><input name="dis_files[]" type="checkbox" value="'.$row->discipline_id.'"></td>
						<td style="width:88%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->discipline.'</div></td>
						<td style="width:10%;text-align:right">
						<a title="Delete Discipline" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_discipline('.$row->discipline_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Disciplines added</h3>
					No disciplines have been added. to add a new discipline please click on the add discipline button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//ADD Discipline DO
	//++++++++++++++++++++++++++
	public function add_discipline_do()
	{

		$db2 = $this->connect_my_db();

		$discipline = $this->input->post('discipline', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($discipline);

		//Check if category exists
		$query = $db2->query("SELECT * FROM vacancy_disciplines WHERE bus_id = '".$bus_id."' AND slug = '".$slug."'", FALSE);


		if($query->result()){



		} else  {

			$insertcat = array(
				'bus_id'=> $bus_id,
				'discipline'=> $discipline,
				'slug'=> $slug
			);
			$db2->insert('vacancy_disciplines',$insertcat);

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE DISCIPLINE
	//++++++++++++++++++++++++++

	function delete_discipline_do($did) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('discipline_id', $did);
		$db2->delete('vacancy_disciplines');

	}


	//+++++++++++++++++++++++++++
	//Action discipline Bulk
	//++++++++++++++++++++++++++
	public function action_discipline_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$dis_files = $this->input->post('dis_files');

		if(!empty($dis_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($dis_files as $did) {


					$db2->where('discipline_id', $did);
					$db2->delete('vacancy_disciplines');


				}

			}


		}

	}







	//+++++++++++++++++++++++++++
	//GET ALL LOCATIONS
	//++++++++++++++++++++++++++

	public function get_all_locations()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_locations WHERE bus_id = '".$bus_id."' ORDER BY location ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
           				<th style="width:88%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				$title = "'".$row->location."'";

				echo '<tr>
						<td style="width:2%"><input name="loc_files[]" type="checkbox" value="'.$row->location_id.'"></td>
						<td style="width:88%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->location.'</div></td>
						<td style="width:10%;text-align:right">
						<a title="Delete Location" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_location('.$row->location_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Locations added</h3>
					No locations have been added. to add a new location please click on the add location button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//ADD LOCATIONS DO
	//++++++++++++++++++++++++++
	public function add_location_do()
	{

		$db2 = $this->connect_my_db();

		$location = $this->input->post('location', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($location);

		//Check if category exists
		$query = $db2->query("SELECT * FROM vacancy_locations WHERE bus_id = '".$bus_id."' AND slug = '".$slug."'", FALSE);


		if($query->result()){



		} else  {

			$insert = array(
				'bus_id'=> $bus_id,
				'location'=> $location,
				'slug'=> $slug
			);
			$db2->insert('vacancy_locations',$insert);

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE LOCATIONS
	//++++++++++++++++++++++++++

	function delete_location_do($did) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('location_id', $did);
		$db2->delete('vacancy_locations');

	}


	//+++++++++++++++++++++++++++
	//Action discipline Bulk
	//++++++++++++++++++++++++++
	public function action_location_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$loc_files = $this->input->post('loc_files');

		if(!empty($loc_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($loc_files as $lid) {


					$db2->where('location_id', $lid);
					$db2->delete('vacancy_locations');


				}

			}

		}

	}


	//+++++++++++++++++++++++++++
	//GET Career Categories
	//++++++++++++++++++++++++++
	public function get_career_locations_select($lid="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('location', 'ASC');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('vacancy_locations');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->location == $lid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->location_id.'" '.$selected.'>'.$row->location.'</option>';

			}

		}

	}


	//+++++++++++++++++++++++++++
	//GET ALL MANAGEMENT LEVELS
	//++++++++++++++++++++++++++

	public function get_all_management()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM management_level WHERE bus_id = '".$bus_id."'", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
           				<th style="width:88%;font-weight:normal">Level </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				$level = "'".$row->level."'";

				echo '<tr>
						<td style="width:2%"><input name="lvl_files[]" type="checkbox" value="'.$row->level_id.'"></td>
						<td style="width:88%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->level.'</div></td>
						<td style="width:10%;text-align:right">
						<a title="Delete Level" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_level('.$row->level_id.','.$level.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Management Levels added</h3>
					No levels have been added. to add a new level please click on the add level button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//ADD LEVEL DO
	//++++++++++++++++++++++++++
	public function add_management_do()
	{

		$db2 = $this->connect_my_db();

		$level = $this->input->post('level', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($level);

		//Check if category exists
		$query = $db2->query("SELECT * FROM management_level WHERE bus_id = '".$bus_id."' AND slug = '".$slug."'", FALSE);


		if($query->result()){



		} else  {

			$insertcat = array(
				'bus_id'=> $bus_id,
				'level'=> $level,
				'slug'=> $slug
			);
			$db2->insert('management_level',$insertcat);

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE MANAGEMENT LEVEL
	//++++++++++++++++++++++++++

	function delete_management_do($lid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('level_id', $lid);
		$db2->delete('management_level');

	}


	//+++++++++++++++++++++++++++
	//Action management Bulk
	//++++++++++++++++++++++++++
	public function action_management_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$lvl_files = $this->input->post('lvl_files');

		if(!empty($lvl_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($lvl_files as $lid) {


					$db2->where('level_id', $lid);
					$db2->delete('management_level');


				}

			}

		}

	}


	function get_applicant_details($id) {

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$app_array = array();

		array_push($app_array, $id);


		$listings = $this->career_model->get_compare_applicants($id, $app_array);

		$this->output
			->set_content_type('application/json')
			->set_output(json_encode(array('app_list' => $listings)));


	}



	//+++++++++++++++++++++++++++
	//Action Long List Bulk
	//++++++++++++++++++++++++++
	public function action_long_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$app_files = $this->input->post('app_files');
		$vid = $this->input->post('vid');

		if(!empty($app_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($app_files as $aid) {


					$db2->where('va_id', $aid);
					$db2->delete('vacancy_applicants');

					$this->output
						->set_content_type('application/json')
						->set_output(json_encode(array('output' => 'remove')));


				}

			}

			//short list bulk entries
			if($type == 2) {

				foreach($app_files as $aid) {

					$insert = array(
						'status'=> 'short',
					);

					$db2->where('va_id', $aid);
					$db2->update('vacancy_applicants',$insert);

					$this->output
						->set_content_type('application/json')
						->set_output(json_encode(array('output' => 'short')));

				}

			}

			//compare bulk entries
			if($type == 3) {

				$app_array = array();

				foreach($app_files as $aid) {

					array_push($app_array, $aid);

				}

				//$this->session->set_userdata('va_list', $app_array);


				$listings = $this->get_compare_applicants($vid, $app_array);

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('output' => 'compare', 'app_list' => $listings)));

			}

			//Export to CSV
			if($type == 4) {

				$app_array = array();

				foreach($app_files as $aid) {

					array_push($app_array, $aid);

				}

				$this->export_applicant_cvs($app_array);


				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('output' => 'export')));

			}

		}

	}


	//+++++++++++++++++++++++++++
	//Action Short List Bulk
	//++++++++++++++++++++++++++
	public function action_short_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$app_files = $this->input->post('app_files');
		$vid = $this->input->post('vid');

		if(!empty($app_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($app_files as $aid) {


					$db2->where('va_id', $aid);
					$db2->delete('vacancy_applicants');

					$this->output
						->set_content_type('application/json')
						->set_output(json_encode(array('output' => 'remove')));


				}

			}

			//short list bulk entries
			if($type == 2) {

				foreach($app_files as $aid) {

					$insert = array(
						'status'=> 'long',
					);

					$db2->where('va_id', $aid);
					$db2->update('vacancy_applicants',$insert);

					$this->output
						->set_content_type('application/json')
						->set_output(json_encode(array('output' => 'short')));

				}

			}

			//compare bulk entries
			if($type == 3) {

				$app_array = array();

				foreach($app_files as $aid) {

					array_push($app_array, $aid);

				}

				//$this->session->set_userdata('va_list', $app_array);


				$listings = $this->get_compare_applicants($vid, $app_array);

				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('output' => 'compare', 'app_list' => $listings)));

			}

			//Export to CSV
			if($type == 4) {

				$app_array = array();

				foreach($app_files as $aid) {

					array_push($app_array, $aid);

				}

				$this->export_applicant_cvs($app_array);


				$this->output
					->set_content_type('application/json')
					->set_output(json_encode(array('output' => 'export')));

			}

		}

	}




	function export_applicant_cvs($app_array) {

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		//GET SELECTED APPLICANTS
		$query = $db2->query("SELECT B.CLIENT_NAME, B.CLIENT_SURNAME, B.CLIENT_EMAIL, B.CLIENT_TELEPHONE, B.CLIENT_CELLPHONE, B.CLIENT_GENDER, B.CLIENT_DATE_OF_BIRTH, C.ethnic, C.nationality, C.country, C.region, C.city, C.marital_status, C.job_title, C.qualification, C.current_tcc, C.expected_tcc, C.id_number, C.disability, C.drivers_type, C.bee

							  FROM vacancy_applicants AS A

							  RIGHT JOIN u_client AS B ON A.client_id = B.ID

							  RIGHT JOIN applicant_bio AS C ON A.client_id = C.client_id

							  WHERE A.va_id IN (".implode(",",array_map("intval",$app_array)).") GROUP BY A.client_id ORDER BY A.weight DESC", FALSE);


			$this->load->dbutil();
			$this->load->helper('file');
			/* get the object   */
			$report = $query->result();
			/*  pass it to db utility function  */


			$delimiter = ",";
			$newline = "\r\n";
			ob_start();
			$new_report = $this->dbutil->csv_from_result($query, $delimiter, $newline);
			/*  Now use it to write file. write_file helper function will do it */

			$csvFilePath = BASE_URL."assets/csv/csv_file.csv";

			write_file($csvFilePath,$new_report);

	}




	function get_compare_applicants($id,$app_array="") {


		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$info_array = array();

		$query = $db2->query("SELECT *,

							  (SELECT group_concat(CONCAT(F.type, ':', F.institution, ':', F.study_field, ':', F.qualification) SEPARATOR ',') FROM applicant_education AS F WHERE F.client_id = A.client_id) as edu,

							  (SELECT group_concat(G.skill SEPARATOR ', ') FROM applicant_skills AS G WHERE G.client_id = A.client_id) as skillz,

							  (SELECT group_concat(CONCAT(H.language, ':', H.prof_read, ':', H.prof_write, ':', H.prof_speak, ':', H.skill_read, ':', H.skill_write, ':', H.skill_speak, ':', H.first_language) SEPARATOR ',') FROM applicant_languages AS H WHERE H.client_id = A.client_id) as langs,

							  (SELECT group_concat(CONCAT(I.company, ':', I.business_type, ':', I.position, ':', I.level, ':', I.type, ':', I.salary_type, ':', I.benefits) SEPARATOR ',') FROM applicant_employment AS I WHERE I.client_id = A.client_id) as employ,

							  (SELECT group_concat(J.competency SEPARATOR ', ') FROM applicant_core_competencies AS J WHERE J.client_id = A.client_id) as comps

							  FROM vacancy_applicants AS A

							  RIGHT JOIN u_client AS B ON A.client_id = B.ID

							  RIGHT JOIN applicant_bio AS C ON A.client_id = C.client_id

							  WHERE A.va_id IN (".implode(",",array_map("intval",$app_array)).") GROUP BY A.client_id ORDER BY A.weight DESC", FALSE);

		if($query->result()){

			$info = '<tr>
						<th>Firstname</th>
						<th>Lastname</th>
						<th>Highest Qualification</th>
						<th>Current Salary</th>
						<th>Expected Salary</th>
						<th>Education</th>
						<th>Employment</th>
						<th>Skills</th>
						<th>Core Competencies</th>
						<th>Languages</th>
						<th>BEE</th>
						<th>DOB</th>
						<th>Gender</th>
						<th>Ethnicity</th>
						<th>Nationality</th>
						<th>Disability</th>
						<th>Drivers Licence</th>
					 </tr>';

			foreach($query->result() as $row){

				switch($row->CLIENT_GENDER) {
					case 'M':
						$gender = 'Male';
						break;
					case 'F':
						$gender = 'Female';
						break;
				}



				//GET EDUCATION
				$edu = '';
				$edu2 = '';


				if($row->edu != '') {

					$go = explode(',',$row->edu);
					foreach( $go as $educ )
					{

						$go2 = explode(':',$educ);

						switch($go2[0]) {
							case 'secondary':
								$e_type = '<strong>Secondary Education:</strong>';
								break;
							case 'tertiary':
								$e_type = '<strong>Tertiary Education:</strong>';
								break;
							case 'course':
								$e_type = '<strong>Course:</strong>';
								break;
						}

						$edu.= $e_type.'<br>'.$go2[1].'<br>'.$go2[2].'<br>';
					}
					//END GET EDUCATION

				}


				//GET LANGUAGE
				$lng = '';
				$lng2 = '';

				if($row->langs != '') {

					$lgo = explode(',',$row->langs);
					foreach( $lgo as $langz )
					{

						$lgo2 = explode(':',$langz);


						$language = $lgo2[0];
						$pread = $lgo2[1];
						$pwrite = $lgo2[2];
						$pspeak = $lgo2[3];
						$sread = $lgo2[4];
						$swrite = $lgo2[5];
						$sspeak = $lgo2[6];
						$fl = $lgo2[7];

						if($sread != 'none') { $sr = '('.$sread.')'; } else { $sr = ''; }
						if($swrite != 'none') { $sw = '('.$swrite.')'; } else { $sw = ''; }
						if($sspeak != 'none') { $ss = '('.$sspeak.')'; } else { $ss = ''; }

						$lng.= '<strong>'.$language.'</strong><br>Read: '.$pread.' '.$sr.'<br>Write: '.$pwrite.' '.$sw.'<br>Speak: '.$pspeak.' '.$ss.'<br>';
					}
				}
				//END GET LANGUAGE

				//GET EMPLOYMENT
				$emp = '';
				$emp2 = '';

				if($row->employ != '') {

					$ego = explode(',',$row->employ);
					foreach( $ego as $employs )
					{

						$ego2 = explode(':',$employs);


						$company = $ego2[0];
						$position = $ego2[1];
						$btype = $ego2[2];
						$level = $ego2[3];
						$type = $ego2[4];
						$benefits = $ego2[5];


						$emp.= $type.' '.$level.' '.$position.' '.$btype.' at '.$company;
					}
				}


				//END GET LANGUAGE


				$info.= '<tr>
							<td>'.$row->CLIENT_NAME.'</td>
							<td>'.$row->CLIENT_SURNAME.'</td>
							<td>'.$row->qualification.'</td>
							<td>'.$row->current_tcc.'</td>
							<td>'.$row->expected_tcc.'</td>
							<td>'.$edu.'</td>
							<td>'.$emp.'</td>
							<td>'.$row->skillz.'</td>
							<td>'.$row->comps.'</td>
							<td>'.$lng.'</td>
							<td>'.$row->bee.'</td>
							<td>'.date('d.m.Y',strtotime($row->CLIENT_DATE_OF_BIRTH)).'</td>
							<td>'.$gender.'</td>
							<td>'.$row->ethnic.'</td>
							<td>'.$row->nationality.'</td>
							<td>'.$row->disability.'</td>
							<td>'.$row->drivers_type.'</td>

						 </tr>';


				array_push($info_array, $info);

				$info = '';
			}


			return $info_array;



		}else{


		}

	}








	//+++++++++++++++++++++++++++
	//GET ALL MR
	//++++++++++++++++++++++++++

	public function get_all_mr()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT * FROM vacancy_mr WHERE bus_id = '".$bus_id."' ORDER BY title ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
           				<th style="width:88%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				$title = "'".$row->title."'";

				echo '<tr>
						<td style="width:2%"><input name="mr_files[]" type="checkbox" value="'.$row->mr_id.'"></td>
						<td style="width:88%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></td>
						<td style="width:10%;text-align:right">
						<a title="Delete MR" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_mr('.$row->mr_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Minimum Requirement Categories added</h3>
					No categories have been added. to add a new category please click on the add category button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//ADD MR DO
	//++++++++++++++++++++++++++
	public function add_mr_do()
	{

		$db2 = $this->connect_my_db();

		$mr = $this->input->post('mr', TRUE);

		$bus_id = $this->session->userdata('bus_id');


		//Check if category exists
		$query = $db2->query("SELECT * FROM vacancy_mr WHERE bus_id = '".$bus_id."' AND title = '".$mr."'", FALSE);


		if($query->result()){



		} else  {

			$insertcat = array(
				'bus_id'=> $bus_id,
				'title'=> $mr
			);
			$db2->insert('vacancy_mr',$insertcat);

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE MR
	//++++++++++++++++++++++++++

	function delete_mr_do($mid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('mr_id', $mid);
		$db2->delete('vacancy_mr');

	}


	//+++++++++++++++++++++++++++
	//Action MR Bulk
	//++++++++++++++++++++++++++
	public function action_mr_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$mr_files = $this->input->post('mr_files');

		if(!empty($mr_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($mr_files as $did) {


					$db2->where('mr_id', $did);
					$db2->delete('vacancy_mr');


				}

			}


		}

	}






	//+++++++++++++++++++++++++++
	//GET ALL CAREER CATEGORIES
	//++++++++++++++++++++++++++

	public function get_all_industry_categories()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_industries WHERE bus_id = '".$bus_id."' ORDER BY industry ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:2%;font-weight:normal"></th>
           				<th style="width:88%;font-weight:normal">Industry </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				$title = "'".$row->industry."'";

				echo '<tr>
						<td style="width:2%"><input name="ind_files[]" type="checkbox" value="'.$row->industry_id.'"></td>
						<td style="width:88%"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->industry.'</div></td>
						<td style="width:10%;text-align:right">
						<a title="Delete Industry Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_industry('.$row->industry_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Industry Categories added</h3>
					No categories have been added. To add a new category please click on the add category button on the right</div>';

		}


	}


	//+++++++++++++++++++++++++++
	//ADD INDUSTRY CATEGORY DO
	//++++++++++++++++++++++++++
	public function add_industry_category_do()
	{

		$db2 = $this->connect_my_db();

		$category = $this->input->post('category', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($category);

		//Check if category exists
		$query = $db2->query("SELECT * FROM vacancy_industries WHERE bus_id = '".$bus_id."' AND slug = '".$slug."'", FALSE);


		if($query->result()){



		} else  {

			$insertcat = array(
				'bus_id'=> $bus_id,
				'industry'=> $category,
				'slug'=> $slug
			);
			$db2->insert('vacancy_industries',$insertcat);

		}

	}

	//+++++++++++++++++++++++++++
	//DELETE INDUSTRY CAT
	//++++++++++++++++++++++++++

	function delete_industry_cat_do($cid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('career_id', $cid);
		$db2->delete('vacancy_industries');

	}


	//+++++++++++++++++++++++++++
	//Action Career Cat Bulk
	//++++++++++++++++++++++++++
	public function action_industry_cat_bulk($type)
	{

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$ind_files = $this->input->post('ind_files');

		if(!empty($ind_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($ind_files as $cid) {


					$db2->where('industry_id', $cid);
					$db2->delete('vacancy_industries');


				}

			}


		}

	}



	//+++++++++++++++++++++++++++
	//GET VACANCY SURVEY DETAILS
	//++++++++++++++++++++++++++

	function get_vacancy_survey($survey_id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('survey_id', $survey_id);
		$query = $db2->get('vacancy_surveys');

		return $query->row_array();

	}


	//+++++++++++++++++++++++++++
	//GET ALL VACANCIES
	//++++++++++++++++++++++++++

	public function get_all_vacancy_surveys()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT * FROM vacancy_surveys WHERE bus_id = '".$bus_id."' ORDER BY listing_date DESC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:30%;font-weight:normal">Title </th>
						<th style="width:30%;font-weight:normal">Listing Date </th>
						<th style="width:10%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Live</span>';
				}

				$title = "'".$row->title."'";

				echo '<tr>
						<td style="width:2%"><input name="sur_files[]" type="checkbox" value="'.$row->survey_id.'"></td>
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a style="cursor:pointer" href="'.site_url('/').'career/update_vacancy_survey/'.$row->survey_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
						<td style="width:30%">'.date('d.m.Y',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Vacancy Survey" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer"
						href="'.site_url('/').'career/update_vacancy_survey/'.$row->survey_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Vacancy Survey" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_survey('.$row->survey_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Surveys added</h3>
					No surveys have been added. to add a new survey please click on the add survey button on the right</div>';

		}


	}


	function add_vacancy_survey_do() {

		$db2 = $this->connect_my_db();

		$title = $this->input->post('title', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('body', FALSE)));
		$bus_id = $this->session->userdata('bus_id');

		$slug = $this->clean_url_str($title);


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Survey title Required';
			redirect(site_url('/').'career/add_vacancy_survey/','refresh');

		}else{
			$val = TRUE;
		}

		$insertdata = array(

			'title'=> $title ,
			'body'=> $body ,
			'slug'=> $slug,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->insert('vacancy_surveys', $insertdata);
			$surveyid = $db2->insert_id();


			redirect(site_url('/').'career/update_vacancy_survey/'.$surveyid.'/','refresh');


		} else {


		}
	}


	function update_vacancy_survey_do() {

		$db2 = $this->connect_my_db();

		$title = $this->input->post('title', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('body', FALSE)));
		$status = $this->input->post('status', TRUE);
		$id = $this->input->post('survey_id', TRUE);


		$bus_id = $this->session->userdata('bus_id');

		switch($status) {
			case TRUE:
				$status = 'live';
				break;
			case FALSE:
				$status = 'draft';
				break;
		}


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Survey title Required';


		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'title'=> $title ,
			'body'=> $body ,
			'status'=> strtolower($status),
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->where('survey_id' , $id);
			$db2->update('vacancy_surveys', $insertdata);
			//success redirect
			$data['survey_id'] = $id;

			//LOG
			$data['basicmsg'] = 'Survey has been updated successfully'.strtolower($status);


		}else{



		}

	}



	function delete_vacancy_survey_do($sid) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('survey_id', $sid);
		$db2->delete('vacancy_surveys');

		$db2->where('survey_id', $sid);
		$db2->delete('vacancy_survey_questions');

		$db2->where('survey_id', $sid);
		$db2->delete('vacancy_survey_int');

	}



	function delete_vacancy_mr_question_do($id) {

		$db2 = $this->connect_my_db();

		//delete from database
		$db2->where('id', $id);
		$db2->delete('vacancy_mr_int');


	}


	//+++++++++++++++++++++++++++
	//Action Vacancy Bulk
	//++++++++++++++++++++++++++
	public function action_vacancy_survey_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$sur_files = $this->input->post('sur_files');

		if(!empty($sur_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($sur_files as $sid) {

					$db2->where('survey_id', $sid);
					$db2->delete('vacancy_surveys');

					$db2->where('survey_id', $sid);
					$db2->delete('vacancy_survey_questions');

					$db2->where('survey_id', $sid);
					$db2->delete('vacancy_survey_int');

				}

			}

			if($type > 1) {

				foreach($sur_files as $sid) {

					switch ($type) {
						case 2:
							$entry = 'live';
							break;
						case 3:
							$entry = 'draft';
							break;

					}

					//populate array with values
					$data = array(
						'status' => $entry,
					);
					//insert into database
					$db2->where('survey_id', $sid);
					$db2->update('vacancy_surveys', $data);

				}
			}


		}

	}


	//ADD MR QUESTIONS
	function add_vacancy_mr_question_do()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');
		$mr_category = $this->input->post('mr_category',TRUE);
		$question = $this->input->post('question',TRUE);
		$vacancy_id = $this->input->post('vacancy_id',TRUE);
		$help = $this->input->post('help',TRUE);
		$elaborate = $this->input->post('elaborate',TRUE);
		$answer = $this->input->post('answer',TRUE);


		if($elaborate == 'on') { $elaborate = 'Y'; } else {  $elaborate = 'N'; }
		if($answer == 'on') { $answer = 'Y'; } else {  $answer = 'N'; }

		if($question != ''){

			$insertdata = array(

				'vacancy_id'=> $vacancy_id,
				'mr_id'=> $mr_category ,
				'mr_question'=> $question,
				'help' => $help,
				'elaborate' => $elaborate,
				'answer' => $answer,
				'sequence'=> 0
			);
			$db2->insert('vacancy_mr_int', $insertdata);

			//LOG


		}else{

			$data['basicmsg'] = 'Please fill in the minimum requirement field';

		}
	}


	//+++++++++++++++++++++++++++
	//UPDATE QUESTION DO
	//++++++++++++++++++++++++++
	public function update_vacancy_mr_question_do()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$mr_category = $this->input->post('mr_category',TRUE);

		$question = $this->input->post('question',TRUE);

		$help = $this->input->post('help',TRUE);

		$elaborate = $this->input->post('elaborate',TRUE);

		if($elaborate == 'on') { $elaborate = 'Y'; } else {  $elaborate = 'N'; }


		$answer = $this->input->post('answer',TRUE);

		if($answer == 'on') { $answer = 'Y'; } else {  $answer = 'N'; }

		$id = $this->input->post('id',TRUE);

		if($question != ''){

			//if($type == ''){ $type = 'Input';}

			$insertdata = array(
				'mr_id'=> $mr_category ,
				'mr_question'=> $question ,
				'elaborate' => $elaborate,
				'answer' => $answer,
				'help' => $help,
				'sequence'=> 0
			);

			$db2->where('id', $id);
			$db2->update('vacancy_mr_int', $insertdata);


		}else{

		}

	}


	//VACANCY MR QUESTIONS
	function vacancy_mr_questions($vid)
	{

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_mr_int AS A LEFT JOIN vacancy_mr AS B ON A.mr_id = B.mr_id WHERE A.vacancy_id = '".$vid."' ORDER BY A.sequence ASC", FALSE);

		if($query->result()){

			echo '
					<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable" id="sortable">
						<thead>
							<tr style="font-size:14px;">
								<th style="width:5%;"></th>
								<th style="width:30%;font-weight:normal">MR Category </th>
								<th style="width:35%;font-weight:normal">Minimum Requirement </th>
								<th style="width:10%;font-weight:normal">Elaborate </th>
								<th style="width:10%;font-weight:normal">Answer </th>
								<th style="width:10%;min-width:60px; font-weight:normal"></th>
							</tr>
						</thead>
						<tbody>';

			foreach($query->result() as $row){


				$question = "'".$row->title."'";

				echo '<tr class="myDragClass" style="cursor: grab">
							<td style="width:5%"><input name="que_files[]" type="checkbox" value="'.$row->id.'"></td>
							<td>
							<input type="hidden" value="'.$row->id.'" />
							'.$row->title.'</td>
							<td>'.$row->mr_question.'</td>
							<td>'.$row->elaborate.'</td>
							<td>'.$row->answer.'</td>
							<td class="text-right">

								<a onClick="update_question('.$row->id.')" data-toggle="modal" data-target="#myUpdateQuestion" class="btn btn-mini btn-success"><i class="glyphicon glyphicon-pencil"></i></a>
								<a onClick="delete_question('.$row->id.','.$question.')" class="btn btn-mini btn-danger"><i class="glyphicon glyphicon-trash"></i></a>
							</td>
						  </tr>';

			}
			echo '</tbody>
				</table>
				<script type="text/javascript">

					$(document).ready(function () {
						$("#sortable tr").css("cursor", "move");
					});

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
									var img_id = $(this).val(), index = i;
									console.log(img_id+" "+index);
									 $.ajax({
										type: "post",

										url: "'. site_url('/').'career/update_vacancy_mr_sequence/"+img_id+"/"+index ,
										success: function (data) {

										}
								});

							  });


						}

					}).disableSelection();

				</script>

				';

		}else{

			echo '<div class="alert">No Entries added</div>';

		}

	}

	public function update_vacancy_mr_sequence($id , $sequence)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$data['sequence'] = $sequence;
		$db2->where('bus_id' , $bus_id);
		$db2->where('id' , $id);
		$db2->update('vacancy_mr_int', $data);


	}


	//+++++++++++++++++++++++++++
	//GET VACANCY DETAILS
	//++++++++++++++++++++++++++

	function get_vacancy($vacancy_id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('vacancy_id', $vacancy_id);
		$query = $db2->get('vacancies');

		return $query->row_array();

	}

	//+++++++++++++++++++++++++++
	//GET ALL VACANCIES
	//++++++++++++++++++++++++++

	public function get_all_vacancies()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT * FROM vacancies WHERE bus_id = '".$bus_id."' AND status != 'archive' ORDER BY listing_date ASC", FALSE);

		if($query->result()){

			echo '
				<table id="dt_basic" class="table table-striped table-bordered table-hover" width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:5%;font-weight:normal"></th>
						<th style="width:10%;font-weight:normal">Status</th>
						<th style="width:15%;font-weight:normal">Ref </th>
           				<th style="width:25%;font-weight:normal">Title </th>
						<th style="width:10%;font-weight:normal">Start Date</th>
						<th style="width:10%;font-weight:normal">End Date</th>
						<th style="width:10%;font-weight:normal">Listing Date </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>

				';

			foreach($query->result() as $row){

				if($row->status == 'draft'){
					$status = '<span class="label label-warning">Draft</span>';
				} else if ($row->status == 'live'){
					$status = '<span class="label label-success">Live</span>';
				} else if ($row->status == 'archive') {
					$status = '<span class="label label-primary">Archive</span>';
				}

				$title = "'".$row->title."'";

					echo '<tr>
						<td style="width:2%"><input name="vac_files[]" type="checkbox" value="'.$row->vacancy_id.'"></td>
						<td style="width:10%">'.$status.'</td>
						<td style="width:15%">'.$row->ref_no.'</td>
						<td style="width:25%"><a style="cursor:pointer" href="'.site_url('/').'career/update_vacancy/'.$row->vacancy_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'.$row->title.'</div></a></td>
            			<td style="width:10%">'.date('d.m.Y',strtotime($row->start_date)).'</td>
						<td style="width:10%">'.date('d.m.Y',strtotime($row->end_date)).'</td>
						<td style="width:10%">'.date('d.m.Y',strtotime($row->listing_date)).'</td>
						<td style="width:150%;text-align:right">
						<a title="View Applicants" rel="tooltip" class="btn btn-mini btn-success" style="cursor:pointer" href="'.site_url('/').'career/vacancy_applicants/'.$row->vacancy_id.'"><i class="glyphicon glyphicon-eye-open"></i></a>
						<a title="Edit Vacancy" rel="tooltip" class="btn btn-mini btn-primary" style="cursor:pointer" href="'.site_url('/').'career/update_vacancy/'.$row->vacancy_id.'"><i class="glyphicon glyphicon-pencil"></i></a>
						<a title="Delete Vacancy" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_vacancy('.$row->vacancy_id.','.$title.')">
						<i class="glyphicon glyphicon-trash"></i></a></td>
					  </tr>';
			}


			echo '
				</tbody>
				</table>';

		}else{

			echo '<div class="alert">
			 		<h3>No Vacancies added</h3>
					No vacancies have been added. to add a new vacancy please click on the add vacancy button on the right</div>';

		}


	}

	function add_vacancy_do() {

		$db2 = $this->connect_my_db();
		$survey = $this->input->post('survey', TRUE);
		$client = $this->input->post('client', TRUE);
		$industry = $this->input->post('industry', TRUE);
		$discipline = $this->input->post('discipline', TRUE);
		$department = $this->input->post('department', TRUE);
		$level = $this->input->post('level', TRUE);
		$title = $this->input->post('title', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('body', FALSE)));
		$location = $this->input->post('location', TRUE);
		$career = $this->input->post('career', TRUE);
		$ref_no = $this->input->post('ref_no', TRUE);
		$start_date = $this->input->post('start_date', TRUE);
		$end_date = $this->input->post('end_date', TRUE);
		$bus_id = $this->session->userdata('bus_id');
		$vac_type = $this->input->post('vac_type', TRUE);

		$slug = $this->clean_url_str($title);


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Vacancy title Required';

			//}elseif($this->validate_cell($cellNum)){
//				$val = FALSE;
//				$error = 'Your cell number is not valid. A 081/085/060 number is required!';

			//}elseif($body == ''){
//				$val = FALSE;
//				$error = 'Project Content Required';
//
		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'survey_id'=> $survey ,
			'level'=> $level ,
			'client_id'=> $client ,
			'ref_no'=> $ref_no ,
			'title'=> $title ,
			'body'=> $body ,
			'location'=> $location ,
			'start_date'=> date('Y-m-d' ,strtotime($start_date)) ,
			'end_date'=> date('Y-m-d' ,strtotime($end_date)) ,
			'industry_id'=> $industry ,
			'discipline_id'=> $discipline ,
			'department_id'=> $department ,
			'slug'=> $slug,
			'type'=> $vac_type,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->insert('vacancies', $insertdata);
			$vacancyid = $db2->insert_id();


				redirect(site_url('/').'career/update_vacancy/'.$vacancyid.'/','refresh');


		} else {


		}
	}



	function update_vacancy_do() {

		$db2 = $this->connect_my_db();

		$survey = $this->input->post('survey', TRUE);
		$level = $this->input->post('level', TRUE);
		$title = $this->input->post('title', TRUE);
		$career = $this->input->post('career', TRUE);
		$industry = $this->input->post('industry', TRUE);
		$discipline = $this->input->post('discipline', TRUE);
		$client = $this->input->post('client', TRUE);
		$department = $this->input->post('department', TRUE);
		$ref_no = $this->input->post('ref_no', TRUE);
		$location = $this->input->post('location', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('body', FALSE)));
		$start_date = $this->input->post('start_date', TRUE);
		$end_date = $this->input->post('end_date', TRUE);
		//$main_cats = $this->input->post('main_cats', TRUE);
		//$sub_cats = $this->input->post('sub_cats', TRUE);
		//$sub_sub_cats = $this->input->post('sub_sub_cats', TRUE);
		$id = $this->input->post('vacancy_id', TRUE);
		$status = $this->input->post('status', TRUE);
		//$grading = $this->input->post('grading', TRUE);
		//$secondary_education = $this->input->post('secondary_education', TRUE);
		//$tertiary_education = $this->input->post('tertiary_education', TRUE);
		$vac_type = $this->input->post('vac_type', TRUE);

		$bus_id = $this->session->userdata('bus_id');

		switch($status) {
			case TRUE:$type = $this->session->userdata('type');
				$status = 'live';
				break;
			case FALSE:
				$status = 'draft';
				break;
		}


		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Vacancy title Required';


		}else{
			$val = TRUE;
		}

		$insertdata = array(
			'survey_id'=> $survey ,
			'level'=> $level ,
			'client_id'=> $client ,
			'department_id'=> $department ,
			'ref_no'=> $ref_no ,
			'title'=> $title ,
			'location'=> $location ,
			'body'=> $body ,
			'start_date'=> date('Y-m-d' ,strtotime($start_date)) ,
			'end_date'=> date('Y-m-d' ,strtotime($end_date)) ,
			'industry_id'=> $industry ,
			'discipline_id'=> $discipline ,
			'status'=> strtolower($status),
			'type'=> $vac_type ,
			'bus_id'=>$bus_id
		);



		if($val == TRUE){

			$db2->where('vacancy_id' , $id);
			$db2->update('vacancies', $insertdata);
			//success redirect
			$data['vacancy_id'] = $id;


			$data['basicmsg'] = 'Vacancy has been updated successfully'.strtolower($status);


		}else{


		}

	}


	//+++++++++++++++++++++++++++
	//GET INDUSTRY CATEGORIES
	//++++++++++++++++++++++++++
	public function get_industry_categories_select($cid="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('industry', 'DESC');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('vacancy_industries');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->industry_id == $cid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->industry_id.'" '.$selected.'>'.$row->industry.'</option>';

			}

		}

	}

	//+++++++++++++++++++++++++++
	//GET DISCIPLINE CATEGORIES
	//++++++++++++++++++++++++++
	public function get_discipline_categories_select($cid="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('discipline', 'DESC');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('vacancy_disciplines');

		if($query->result()){


			foreach($query->result() as $row){

				if($row->discipline_id == $cid) { $selected = "selected"; } else { $selected = ""; }

				echo '<option value="'.$row->discipline_id.'" '.$selected.'>'.$row->discipline.'</option>';

			}

		}

	}


	//+++++++++++++++++++++++++++
	//GET Career Surveys
	//++++++++++++++++++++++++++
	public function get_vacancy_mr_select($mid="")
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->order_by('title', 'DESC');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->get('vacancy_mr');

		if($query->result()){

			$str = '';

			foreach($query->result() as $row){

				if($row->mr_id == $mid) { $selected = "selected"; } else { $selected = ""; }

				$str.= '<option value="'.$row->mr_id.'" '.$selected.'>'.$row->title.'</option>';

			}

			return $str;

		}

	}






	function delete_vacancy_do($vid) {

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT image, document FROM vacancies WHERE vacancy_id = '".$vid."'", FALSE);

		$row = $query->row();

		if($row->image) {
			$img_file =  NA_BASE_URL.'assets/vacancies/images/' . $row->image; # build the full path
			if (file_exists($img_file)) {
				unlink($img_file);
			}
		}

		if($row->document) {
			$doc_file =  NA_BASE_URL.'assets/vacancies/documents/' . $row->document; # build the full path
			if (file_exists($doc_file)) {
				unlink($doc_file);
			}
		}


		//delete from database
		$db2->where('vacancy_id', $vid);
		$db2->delete('vacancies');

	}


	//+++++++++++++++++++++++++++
	//Action Vacancy Bulk
	//++++++++++++++++++++++++++
	public function action_vacancy_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$vac_files = $this->input->post('vac_files');

		if(!empty($vac_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($vac_files as $vid) {

					$query = $db2->query("SELECT image, document FROM vacancies WHERE vacancy_id = '".$vid."'", FALSE);

					$row = $query->row();

					$img_file =  NA_BASE_URL.'assets/vacancies/images/' . $row->image; # build the full path
					$doc_file =  NA_BASE_URL.'assets/vacancies/documents/' . $row->document; # build the full path

					if (file_exists($img_file)) {
						unlink($img_file);
					}

					if (file_exists($doc_file)) {
						unlink($doc_file);
					}

					$db2->where('vacancy_id', $vid);
					$db2->delete('vacancies');

					echo $type;

				}

			}

			if($type > 1) {

				foreach($vac_files as $vid) {

					switch ($type) {
						case 2:
							$entry = 'live';
							break;
						case 3:
							$entry = 'draft';
							break;
						case 4:
							$entry = 'archive';
							break;

					}

					//populate array with values
					$data = array(
						'status' => $entry,
					);
					//insert into database
					$db2->where('vacancy_id', $vid);
					$db2->update('vacancies', $data);

				}
			}


		}

	}


	//+++++++++++++++++++++++++++
	//Action Vacancy Bulk
	//++++++++++++++++++++++++++
	public function action_vacancy_mr_bulk($type)
	{
		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');
		$que_files = $this->input->post('que_files');

		if(!empty($que_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($que_files as $qid) {


					$db2->where('id', $qid);
					$db2->delete('vacancy_mr_int');


				}

			}


		}

	}



	//+++++++++++++++++++++++++++++++
	//UPDATE VACANCY MR QUESTIONS
	//+++++++++++++++++++++++++++++++
	public function update_vacancy_mr_question($id)
	{
		$db2 = $this->connect_my_db();
		$query = $db2->query("SELECT * FROM vacancy_mr_int WHERE id = '".$id."'", FALSE);

		if($query->result()){

			$row = $query->row();

			if($row->elaborate == 'Y') { $check = 'checked'; } else { $check = ''; }
			if($row->answer == 'Y') { $a_check = 'checked'; } else { $a_check = ''; }

			$mr_cats = $this->career_model->get_vacancy_mr_select($row->mr_id);

			echo '
                <form id="vacancy_mr_question_update" class="smart-form" method="post" action="'.site_url('/').'career/update_vacancy_mr_question_do">
                <input type="hidden" name="id" value="'.$row->id.'">
                <div class="row-fluid">
                    <div class="col-md-12">

							<div class="form-group">
                                <label>MR Category</label>
                                <label class="select">
                                    <select name="mr_category">
                                        <option value="0">Select a Category</option>
                                        '.$mr_cats.'
                                    </select>
                                    <i></i>
                                </label>
                                <br>
                            </div>

                        <div class="form-group">
                            <label>Minimum Reuirement</label>
                            <textarea class="form-control" rows="3" name="question" id="question_u" required>'.$row->mr_question.'</textarea>
                            <br>
                        </div>

                        <div class="form-group">
                            <label>Help text</label>
                            <textarea class="form-control" rows="3" name="help">'.$row->help.'</textarea>
                            <br>
                        </div>

                        <div class="form-group">
                            <label class="checkbox">
                            <input type="checkbox" name="answer" '.$a_check.'>
                            <i></i>Request Yes/No Answer</label>

                            <div class="note">
                                <strong>Note:</strong> Please check if candidate has to answer with Yes or No.
                            </div>
                            <br>
                        </div>

                        <div class="form-group">
                            <label class="checkbox">
                            <input type="checkbox" name="elaborate" '.$check.'>
                            <i></i>Elaborate</label>

                            <div class="note">
                                <strong>Note:</strong> Please check if candidate has to elaborate.
                            </div>
                        </div>

                    </div>
                </div>

                <div style="clear: both"></div>

                </form>

			';

		}



	}



	//+++++++++++++++++++++++++++
	//GET FEATURED IMAGE
	//++++++++++++++++++++++++++

	function get_featured_image($id){

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->select('image');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('vacancy_id', $id);
		$query = $db2->get('vacancies');
		$row = $query->row();
		if($row->image != NULL) {

			$str = "$('#feat_img').html('');";


			echo '<div id="feat_img"><div><img src="'.NA_URL.'assets/vacancies/images/'.$row->image.'" class="superbox-img" style="width:500px" />
				  <p style="padding:10px 10px 0px 0px;">
				  <a href="javascript:void(0);" onclick="remove_img('.$id.')"><span class="btn btn-labeled btn-danger"><i class="glyphicon glyphicon-trash"></i></span></a>
				  </p></div></div>';

			$str = "$('#userfile').click();$('#imgbut').removeClass('disabled');";
			echo '<div id="add_img" style="display:none">
					 <form action="'. NA_URL.'vacancy/add_vacancy_image/" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">
					 	<input type="hidden" value="'.$bus_id.'" name="bus_id">
						<fieldset>
						<input type="file" class="" id="userfile" style="display:none" name="userfile">
						<input type="hidden" name="id" value="'.$id.'">

						<div id="feature_msg"></div>
						<div class="progress progress-striped active" id="procover" style="display:none;">
							<div class="progress-bar bg-color-purple" role="progressbar" style="width:0%"></div>
						</div>

						<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default">Select Image</a>
						<button type="submit" class="btn btn-primary" id="imgbut">Add Feature Image</button>
						</fieldset>
					  </form>
					  </div>

				  ';

		}else{

			$str = "$('#userfile').click();$('#imgbut').removeClass('disabled');";
			echo '<div id="feat_img"><div class="alert">No feature image selected</div></div>
				<div id="add_img">
				 <form action="'. NA_URL.'vacancy/add_featured_image/" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">
				  	<fieldset>
					<input type="file" class="" id="userfile" style="display:none" name="userfile">
					<input type="hidden" value="'.$bus_id.'" name="bus_id">
					<input type="hidden" name="id" value="'. $id.'">
					<div id="feature_msg"></div>
						<div class="progress progress-striped active" id="procover" style="display:none;">
							<div class="progress-bar bg-color-purple" role="progressbar" style="width:0%"></div>
						</div>

					<a href="javascript:void(0)" onClick="'.$str.'" class="btn btn-default">Select Image</a>
					<button type="submit" class="btn btn-primary disabled" id="imgbut">Add Feature Image</button>
					</fieldset>
				  </form>
				  </div>';


		}

		echo ' <script type="text/javascript">
				  	function remove_img(id){
						$("#add_img").fadeIn();
				  		$("#feat_img").empty();

						$.ajax({
							type: "get",

							url: "'.NA_URL.'vacancy/remove_vacancy_image/"+id,
							success: function (data) {

								$("#feature_msg").html(data);

							}
						});

					}
				  </script>';


	}

	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	function add_featured_image()
	{

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$img = $this->input->post('userfile', TRUE);
		$id = $this->input->post('id', TRUE);

		//upload file
		$config['upload_path'] = NA_BASE_URL .'assets/vacancies/images/';
		$config['allowed_types'] = 'gif|jpg|jpeg|png';
		$config['max_size']	= '12000';
		$config['max_width']  = '8324';
		$config['max_height']  = '8550';
		$config['min_width']  = '200';
		$config['min_height']  = '200';
		$config['remove_spaces']  = TRUE;
		$config['encrypt_name']  = TRUE;
		//$config['file_name']  = trim(substr($img, 0, 80));

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{

			$data['error'] =  $this->upload->display_errors();


		}
		else
		{
			//LOAD library
			$this->load->library('image_lib');

			$data = array('upload_data' => $this->upload->data());
			$file =  $this->upload->file_name;
			$width = $this->upload->image_width;
			$height = $this->upload->image_height;

			$format = substr($file,(strlen($file) - 4),4);
			$str = substr($file,0,(strlen($file) - 4));

			if (($width > 1950) || ($height > 900)){

				$this->load->model('image_model');
				$this->image_model->downsize_image($file, '1800', '1000');

			}

			//populate array with values
			$data = array(
				'image'=> $file,
			);
			//insert into database
			$db2->where('vacancy_id', $id);
			$db2->update('vacancies',$data);

			$data['filename'] = $file;
			$data['width'] = $this->upload->image_width;
			$data['height'] = $this->upload->image_height;
			$image = NA_URL . 'assets/vacancies/images/'.$file;
			//redirect
			$data['basicmsg'] = 'Image added successfully!';

			$str = '<div id="feat_img"><div><img src="'.$image.'" class="superbox-img" style="width:500px" /><p style="padding:10px 10px 0px 0px;"><a href="javascript:void(0);" onclick="remove_img('.$id.')"><span class="btn btn-labeled btn-danger"><i class="glyphicon glyphicon-trash"></i></span></a></p></div></div>';

			echo "<script>

			  $('#feat_img').html('".$str."');
			  $('#add_img').fadeOut();
			  </script>";



		}

	}

	public function remove_featured_image($id)
	{

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->select('image');
		$query = $db2->where('vacancy_id', $id);
		$query = $db2->get('vacancies');

		if($query->result()){

			$row = $query->row_array();

			$file =  NA_BASE_URL.'assets/vacancies/images/' . $row['image']; # build the full path

			if (file_exists($file)) {
				unlink($file);
			}

			$db2->set('image' , '');
			$db2->where('vacancy_id' , $id);
			$db2->update('vacancies');



		}
	}


	//+++++++++++++++++++++++++++
	//GET ALL RESOURCES
	//++++++++++++++++++++++++++
	public function get_vacancy_docs($vacancy_id, $level)
	{

		$db2 = $this->connect_my_db();
		$bus_id = $this->session->userdata('bus_id');

		$query = $db2->query("SELECT * FROM vacancy_documents WHERE bus_id = '".$bus_id."' AND vacancy_id = '".$vacancy_id."' AND level = '".$level."'  ORDER BY listing_date ASC", FALSE);



		if($query->result()){

		echo '
		<table class="table table-bordered table-striped">
			<tbody>
		';

			foreach($query->result() as $row){



				$title = str_replace("'", '', $row->title); //clean title

				//Get file extension
				$ext = substr($row->doc_file, strpos($row->doc_file, '.'), strlen($row->doc_file));
				$ext = strtoupper($ext);
				//End file extension

				//Get File Size
				switch($row->type) {
					case 'document':
						$dest_folder = 'documents/vacancies';
						break;
					case 'image':
						$dest_folder = 'images';
						break;
				}

				$download_path = '<a href="'.NA_URL.'vacancy/download_vacancy_document/'.$row->doc_id.'" title="Download File" rel="tooltip" style="cursor:pointer"><span class="btn btn-labeled btn-info"><i class="glyphicon glyphicon-download-alt"></i></span></a>';

				if($row->level == 'basic') { $lev = '1'; }
				if($row->level == 'advanced') { $lev = '2'; }

				//End File Size

				echo '<tr>
						<td class="text-center" style="width:5%"><input name="doc_files[]" type="checkbox" value="'.$row->doc_id.'"></td>
						<td style="width:80%">'.$row->title.'</td>
            			<td style="text-align:right">
							'.$download_path.'
							<a title="Delete File" rel="tooltip" style="cursor:pointer" onclick="delete_document('.$row->doc_id.', '."'".$title."'".', '.$lev.')"><span class="btn btn-labeled btn-danger"><i class="glyphicon glyphicon-trash"></i></span></a>
						</td>
					  </tr>';
			}


			echo '</tbody>
				  </table>';

		} else {

			echo '<div class="alert">
			 		<h3>No Files added</h3>
					No files have been added. Please add a drop Files in the dropbox above
					</div>';

		}
	}


	function add_vacancy_docs()
	{

		$db2 = $this->connect_my_db();

		$this->load->library('upload');  // NOTE: always load the library outside the loop

		$bus_id = $this->session->userdata('bus_id');
		$vacancy_id = $this->input->post('vacancy_id');

		$level = $this->input->post('level');

		$img_allowed =  array('gif' , 'GIF' , 'png' , 'PNG' , 'jpg' , 'JPG' , 'jpeg' , 'JPEG' , 'tiff' , 'TIFF' , 'bmp' , 'BMP' );
		$doc_allowed =  array('doc' , 'DOC' , 'docx' , 'DOCX' , 'pdf' , 'PDF' , 'xls' , 'XLS' , 'xlsx' , 'XLXS' , 'csv' , 'CSV' );


		if(isset($_FILES['file']['name'])){

			$this->total_count_of_files = count($_FILES['file']['name']);
			/*Because here we are adding the "$_FILES['userfile']['name']" which increases the count, and for next loop it raises an exception, And also If we have different types of fileuploads */


			$_FILES['userfile']['name']    = $_FILES['file']['name'];
			$_FILES['userfile']['type']    = $_FILES['file']['type'];
			$_FILES['userfile']['tmp_name'] = $_FILES['file']['tmp_name'];
			$_FILES['userfile']['error']       = $_FILES['file']['error'];
			$_FILES['userfile']['size']    = $_FILES['file']['size'];

			$filename = $_FILES['file']['name'];
			$ext = pathinfo($filename, PATHINFO_EXTENSION);

			//Chech if document
			if(in_array($ext,$doc_allowed) ) {
				$dest_folder = "documents/vacancies/";
				$type = "document";
			}

			//Chech if image
			if(in_array($ext,$img_allowed) ) {
				$dest_folder = "images/";
				$type = "image";
			}


			$config['upload_path'] = NA_BASE_URL . 'assets/vacancies/'.$dest_folder;
			$config['allowed_types'] = 'jpg|jpeg|gif|png|JPEG|JPG|PNG|GIF|tiff|TIFF|bmp|BMP|doc|DOC|docx|DOCX|pdf|PDF|xls|XLS|xlsx|XLSX|csv|CSV';
			$config['overwrite']     = FALSE;
			/*
            $config['max_size']	= '0';
            $config['max_width']  = '8324';
            $config['max_height']  = '8550';
            $config['min_width']  = '200';
            $config['min_height']  = '200';
            */

			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;

			$this->upload->initialize($config);

			if($this->upload->do_upload())
			{
				$data = array('upload_data' => $this->upload->data());
				$file =  $this->upload->file_name;
				$oname =  $this->upload->orig_name;
				$width = $this->upload->image_width;
				$height = $this->upload->image_height;

				//populate array with values
				$data = array(
					'bus_id' => $bus_id,
					'vacancy_id' => $vacancy_id,
					'level' => $level,
					'type' => $type,
					'title'=>$oname,
					'doc_file' =>$file
				);

				//insert into database
				$db2->insert('vacancy_documents',$data);

				//crop
				$data['filename'] = $file;
				//$data['width'] = $this->upload->image_width;
				//$data['height'] = $this->upload->image_height;
				$val = TRUE;
				// $image = base_url('/') . 'assets/business/gallery/'.$file;

				//$this->output->set_header("HTTP/1.0 200 OK");


			}else{
				//ERROR
				$val = FALSE;
				$data['error'] =  $this->upload->display_errors();

				echo $this->upload->display_errors();;

				echo '<br>'.NA_BASE_URL . 'assets/vacancies/'.$dest_folder.$filename;

			}

			//redirect
			if($val == TRUE){

				//SUCESSS MESSAGE SCRIPT COMES HERE!!!!

			}else{

				//ERROR MESSAGE SCRIPT COMES HERE!!!!

			}
		}
	}


	//+++++++++++++++++++++++++++
	//DELETE VACANCY DOCUMENT DO
	//++++++++++++++++++++++++++
	function delete_vacancy_document_do($did) {

		$db2 = $this->connect_my_db();

		$query = $db2->query("SELECT type, doc_file FROM vacancy_documents WHERE doc_id = '".$did."'", FALSE);

		$row = $query->row();

		//Get File Size
		switch($row->type) {
			case 'document':
				$dest_folder = 'documents';
				break;
			case 'image':
				$dest_folder = 'images';
				break;
		}

		$doc_file =  NA_BASE_URL.'assets/vacancies/'.$dest_folder.'/'.$row->doc_file; # build the full path
		if (file_exists($doc_file)) {
			unlink($doc_file);
		}


		//delete from database
		$db2->where('doc_id', $did);
		$db2->delete('vacancy_documents');

	}



	//+++++++++++++++++++++++++++
	//DOWNLOAD MULTI VACANCY
	//++++++++++++++++++++++++++
	public function action_vacancy_docs_bulk() {

		$this->load->library('zip');

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');
		$level = $this->session->userdata('level');

		$doc_files = $this->input->post('doc_files');

		$type = $this->input->post('bulk');
		$title = $this->input->post('title');
		$title = str_replace(' ','_',$title);

		if(!empty($doc_files)) {

			//Remove bulk entries
			if($type == 1) {

				foreach($doc_files as $did) {

					$query = $db2->query("SELECT * FROM vacancy_documents WHERE doc_id = '".$did."' AND bus_id = '".$bus_id."'", FALSE);

					$row = $query->row();

					switch($row->type) {
						case 'document':
							$dest_folder = 'documents';
							break;
						case 'image':
							$dest_folder = 'images';
							break;
					}

					$doc_file =  NA_BASE_URL.'assets/vacancies/'.$dest_folder.'/' . $row->doc_file; # build the full path

					if (file_exists($doc_file)) {
						unlink($doc_file);
					}


					$db2->where('doc_id', $did);
					$db2->delete('vacancy_documents');


				}

			}

			if($type == 2) {

				$date = date('Y-m-d H:i:s');
				$zip_file = $title.'_'.$date;

				//$this->zip->add_dir(NA_BASE_URL.'assets/vacancies/zip/my_backup');

				foreach($doc_files as $did) {

					$query = $db2->query("SELECT * FROM vacancy_documents WHERE doc_id = '".$did."' AND bus_id = '".$bus_id."'", FALSE);

					if($query->result()){

						$row = $query->row();

							switch($row->type) {
								case 'document':
									$dest_folder = 'documents';
									break;
								case 'image':
									$dest_folder = 'images';
									break;
							}


							$file = NA_BASE_URL.'assets/vacancies/'.$dest_folder.'/'.$row->doc_file; # build the full path


							$this->zip->read_file($file);


					} //end result
				} // end for each

				$this->zip->read_file($file);

				$this->zip->download($zip_file);

			}



		} // end if empty
	} // end function


	//+++++++++++++++++++++++++++
	//DOWNLOAD VACANCY DOCUMENT
	//++++++++++++++++++++++++++
	public function download_vacancy_document($did) {

		$bus_id = $this->session->userdata('bus_id');
		$db2 = $this->connect_my_db();

		$this->load->helper('download');

		$query = $db2->query("SELECT * FROM vacancy_documents WHERE bus_id = '".$bus_id."' AND doc_id = '".$did."'", FALSE);

		$row = $query->row();

		switch($row->type) {
			case 'document':
				$dest_folder = 'documents/vacancies';
				break;
			case 'image':
				$dest_folder = 'images';
				break;
		}

		$name = $row->title;
		$file = NA_BASE_URL . 'assets/vacancies/'.$dest_folder.'/'.$row->doc_file; # build the full path
		$data = file_get_contents($file);

		force_download($name, $data);

	} // end function



	//+++++++++++++++++++++++++++
	//FILE SIZE CONVERT
	//+++++++++++++++++++++++++++

	function FileSizeConvert($bytes)
	{
		$bytes = floatval($bytes);
		$arBytes = array(
			0 => array(
				"UNIT" => "TB",
				"VALUE" => pow(1024, 4)
			),
			1 => array(
				"UNIT" => "GB",
				"VALUE" => pow(1024, 3)
			),
			2 => array(
				"UNIT" => "MB",
				"VALUE" => pow(1024, 2)
			),
			3 => array(
				"UNIT" => "KB",
				"VALUE" => 1024
			),
			4 => array(
				"UNIT" => "B",
				"VALUE" => 1
			),
		);

		foreach($arBytes as $arItem)
		{
			if($bytes >= $arItem["VALUE"])
			{
				$result = $bytes / $arItem["VALUE"];
				$result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
				break;
			}
		}
		return $result;
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