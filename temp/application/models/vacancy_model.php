<?php
class Vacancy_model extends CI_Model{
	
 	function vacancy_model(){
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



	function reset_profile_password()
	{

		$db2 = $this->connect_my_db();

		$this->load->library('user_agent');

		$app_id = $this->input->post('app_id', TRUE);
		$pass = $this->input->post('pass', TRUE);
		$email = $this->input->post('email', TRUE);

		$new = $this->hash_password($email,$pass);

		$data['password'] = $new;

		$db2->where('applicant_id', $app_id);
		$db2->update('applicants',$data);

	}


	function upload_potentia() {

		$bus_id = '11636';
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
					'CLIENT_GENDER'=>$gender,
					'typ'=>'potentia'

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

				$job_title = $row['job_title'];

				//INSERT EMPLOYMENT
				$employ_data = array(
					'client_id'=>$client_id,
					'position'=>$job_title

				);
				$db2->insert('applicant_employment', $employ_data);


				//4.APPLICANT EDUCATION

				$degree = $row['qualify'];

				//INSERT EDUCATION
				$edu_data = array(
					'client_id'=>$client_id,
					'type'=>'tertiary',
					'qualification'=>$degree

				);
				$db2->insert('applicant_education', $edu_data);



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


	function update_status() {

		$db2 = $this->connect_my_db();

		$vid = $this->input->post('vacancy_id', TRUE);
		$aid = $this->input->post('applicant_id', TRUE);
		$status = $this->input->post('status', TRUE);



		$bus_id = $this->session->userdata('bus_id');

		$insertdata = array(
			'status'=> $status
		);


		$db2->where('bus_id' , $bus_id);
		$db2->where('applicant_id' , $aid);
		$db2->where('vacancy_id' , $vid);
		$db2->update('vacancy_applicants', $insertdata);
		//success redirect

		//LOG
		$this->admin_model->system_log('update_vacancy_applicant-'. $vid);
		$data['basicmsg'] = 'Vacancy Applicant Status has been updated successfully to '.strtolower($status);
		echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					noty(options);</script>";


	}


	//+++++++++++++++++++++++++++
	//Dump Applicants
	//++++++++++++++++++++++++++

	public function dump_applicants2()
	{


		$this->load->dbutil();
		$this->load->helper('download');

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT b.CLIENT_NAME AS Name, b.CLIENT_SURNAME, b.CLIENT_GENDER,b.CLIENT_DATE_OF_BIRTH, c.nationality, c.id_number, c.marital_status, c.bee, c.disability, c.drivers_type, b.CLIENT_EMAIL, b.CLIENT_CELLPHONE, b.CLIENT_TELEPHONE, d.COUNTRY_NAME, e.REGION_NAME, c.box_address, c.address, f.MAP_LOCATION FROM applicants AS a

							  INNER JOIN u_client AS b ON a.client_id = b.ID

							  INNER JOIN applicant_bio AS c ON a.client_id = c.client_id

							  LEFT JOIN a_country AS d ON b.CLIENT_COUNTRY = d.ID

							  LEFT JOIN a_map_region AS e ON b.CLIENT_COUNTRY = e.ID

							  LEFT JOIN a_map_location AS f ON b.CLIENT_CITY = f.ID

							 ", FALSE);

		if($query->result()){


			$file = $this->dbutil->csv_from_result($query);

			$name = 'data.csv';


			force_download($name, $file);


		}else{


		}


	}

	//+++++++++++++++++++++++++++
	//Dump Applicants
	//++++++++++++++++++++++++++

	public function dump_applicants()
	{


		$this->load->helper('csv');
		$this->load->helper('download');

		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');


		$query = $db2->query("SELECT a.bus_id, b.CLIENT_NAME AS Name, b.CLIENT_SURNAME AS Surname, b.CLIENT_GENDER,b.CLIENT_DATE_OF_BIRTH, c.nationality, c.id_number, c.marital_status, c.bee, c.disability, c.drivers_type, b.CLIENT_EMAIL, b.CLIENT_CELLPHONE, b.CLIENT_TELEPHONE, d.COUNTRY_NAME, e.REGION_NAME, c.box_address, c.address, f.MAP_LOCATION

							  FROM applicants AS a

							  INNER JOIN u_client AS b ON a.client_id = b.ID

							  INNER JOIN applicant_bio AS c ON a.client_id = c.client_id

							  LEFT JOIN a_country AS d ON b.CLIENT_COUNTRY = d.ID

							  LEFT JOIN a_map_region AS e ON b.CLIENT_COUNTRY = e.ID

							  LEFT JOIN a_map_location AS f ON b.CLIENT_CITY = f.ID

							  WHERE a.bus_id = '".$bus_id."' AND a.status = 'live'

							 ", FALSE);

		if($query->result()){


			echo query_to_csv($query, TRUE, 'data.csv');

		}else{


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



	//++++++++++++++++++++++++++
	//GET COUNTRY
	//++++++++++++++++++++++++++
	public function get_country($country)
	{	
	
		$db2 = $this->connect_my_db();
		
		$query = $db2->query("SELECT COUNTRY_NAME FROM a_country WHERE ID = '".$country."'", FALSE);
		
		
		if($query->result()){
		
			$row = $query->row();
			
			return $row->COUNTRY_NAME;
			
		}
		
	}
	
	//++++++++++++++++++++++++++
	//GET REGION
	//++++++++++++++++++++++++++
	public function get_region($region)
	{	
	
		$db2 = $this->connect_my_db();
		
		$query = $db2->query("SELECT REGION_NAME FROM a_map_region WHERE ID = '".$region."'", FALSE);
		
		if($query->result()){
			
			$row = $query->row();
			
			return $row->REGION_NAME;
			
		}
		
	}
	
	
	//++++++++++++++++++++++++++
	//GET CITY
	//++++++++++++++++++++++++++
	public function get_city($city)
	{	
	
		$db2 = $this->connect_my_db();
		
		$query = $db2->query("SELECT MAP_LOCATION FROM a_map_location WHERE ID = '".$city."'", FALSE);
		
		if($query->result()){
			
			$row = $query->row();
			
			return $row->MAP_LOCATION;
			
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
	//GET APP CATEGORIES
	//++++++++++++++++++++++++++
	public function get_app_categories($client_id)
	{
		  $db2 = $this->connect_my_db();  
		  
		  $query = $db2->query("SELECT * FROM applicant_categories WHERE client_id = '".$client_id."'", FALSE);
		  
		  
		  if($query->result()){
			  
			echo '<table class="table table-striped">';
			
			foreach($query->result() as $row){
				
				echo 
				'<tr><td>';
				
				if($row->sub_cat != '0') { echo $row->sub_cat; }
				if($row->sub_sub_cat != '0') { echo ' / '.$row->sub_sub_cat; }
				if($row->sub_sub_sub_cat != '0') { echo ' / '.$row->sub_sub_sub_cat; }
				
				echo 
				'</td><td> ('.$row->experience.' Experience)</td></tr>';
			
			}
			
			echo '</table>';

		 }else{
			 
			 echo '<div class="alert alert-danger alert-dismissible fade in">No Categories added</div>';
		  
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
		  echo '<span style="margin-right:5px;margin-bottom:5px;padding:5px;" class="label label-primary pull-left">'.$row->discipline.' ('.$row->experience.' Experience)</span>';	  
		}
	  }
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

	//+++++++++++++++++++++++++++
	//GET ALL PRODUCTS
	//++++++++++++++++++++++++++
	public function get_all_applicants()
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		  
		   $query = $db2->query("SELECT * FROM applicants AS A, u_client AS B WHERE A.Bus_id = '".$bus_id."' AND A.type = 'vacancy' AND A.client_id = B.ID", FALSE);
		   
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:10%;font-weight:normal">Status </th>
						<th style="width:30%;font-weight:normal">Name </th>
						<th style="width:30%;font-weight:normal">Email</th>
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
				if($row->status == 'semi'){
					$status = '<span class="label label-warning">Pending</span>';
				}				
				echo '<tr>
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a href="'.site_url('/').'vacancy/view_applicant/'.$row->client_id.'">'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</a></td>
            			<td style="width:30%">'.$row->email.'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="View Applicant" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'vacancy/view_applicant/'.$row->client_id.'"><i class="icon-eye-open"></i></a>
						<a title="Delete Applicant" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_applicant('.$row->applicant_id.')"><i class="icon-trash icon-white"></i></a></td>
					  </tr>';
			}
			
			
			echo '</tbody>
				</table>
				<hr />
				<button class="btn btn-inverse" onclick="dump_applicants()">Download Applicant List</button>
				<div class="clearfix" style="height:30px;"></div>
				<script type="text/javascript">
					
				</script>';
			
		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Vacancies added</h3>
					No vacancies have been added. to add a new vacancy please click on the add vacancy button on the right</div>';
		  
		 }
				
		
	}


	//+++++++++++++++++++++++++++
	//FILTER APPLICANTS
	//++++++++++++++++++++++++++
	public function filter_applicants()
	{
		$db2 = $this->connect_my_db();

		$bus_id = $this->session->userdata('bus_id');
		$type = $this->input->post('filter_type');
		$ids = $this->input->post('ids');

		$join = "";
		$app_type = "";

		if($type == 'discipline') {

			$join = " INNER JOIN applicant_disciplines AS c ON a.client_id = c.client_id AND c.discipline_id = '".$ids."' ";


		}

		if($type == 'vacancy') {

			$join = " INNER JOIN vacancy_applicants AS c ON a.applicant_id = c.applicant_id AND c.vacancy_id = '".$ids."' ";

		}

		if($type == 'app_type' && $ids != '0') {

			$app_type = " AND a.type = '".$ids."' ";

		}


		$query = $db2->query("SELECT * FROM applicants AS a

							  INNER JOIN u_client AS b on a.client_id = b.ID

							  ".$join."

							  WHERE a.bus_id = '".$bus_id."' ".$app_type." ", FALSE);

		if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
           				<th style="width:10%;font-weight:normal">Status </th>
						<th style="width:30%;font-weight:normal">Name </th>
						<th style="width:30%;font-weight:normal">Email</th>
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
				if($row->status == 'semi'){
					$status = '<span class="label label-warning">Pending</span>';
				}
				echo '<tr>
						<td style="width:10%">'.$status.'</td>
						<td style="width:30%"><a href="'.site_url('/').'vacancy/view_applicant/'.$row->client_id.'">'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</a></td>
            			<td style="width:30%">'.$row->email.'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="View Applicant" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'vacancy/view_applicant/'.$row->client_id.'"><i class="icon-eye-open"></i></a>
						<a title="Delete Applicant" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_applicant('.$row->applicant_id.')"><i class="icon-trash icon-white"></i></a></td>
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
			 		<h3>No Vacancies added</h3>
					No vacancies have been added. to add a new vacancy please click on the add vacancy button on the right</div>';

		}


	}




	function delete_applicant_do($id) {
			
		  $db2 = $this->connect_my_db();
			
		  //delete from database
		  $db2->where('applicant_id', $id);
		  $db2->delete('applicants');
		  
		  //delete from database
		  $db2->where('applicant_id', $id);
		  $db2->delete('vacancy_applicants');
		  	  		  	  			  		  		  		  	  		  			  	  
		  
		  //LOG
		  $this->admin_model->system_log('delete_applicant-'.$id);
		  $this->session->set_flashdata('msg','Applicant successfully deleted');
		  echo '<script type="text/javascript">
			   window.location = "'.site_url('/').'vacancy/vacancies/";
			  </script>';		
		
	}



	//+++++++++++++++++++++++++++
	//GET ALL CATEGORIES
	//++++++++++++++++++++++++++
	public function get_all_categories()
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $db2->where('bus_id', $bus_id);
		  $query = $db2->get('vacancy_careers');
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
						<td style="width:6%">'.$row->career_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->career.'</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Category" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_category('.$row->career_id.')">
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


	//+++++++++++++++
	//DELETE CATEGORY
	//+++++++++++++++

	public function delete_category($id)
	{
		
		$db2 = $this->connect_my_db();
		
	    $bus_id = $this->session->userdata('bus_id');
						
		$db2->where('bus_id', $bus_id);
		$db2->where('career_id', $id);
		$db2->delete('vacancy_careers');			

	}


	//+++++++++++++++
	//ADD CATEGORY
	//+++++++++++++++	
	public function add_category()
	{
		$bus_id = $this->session->userdata('bus_id');
		
		$db2 = $this->connect_my_db();
			
		//INSERT INTO CATEGORIES
		$career = $this->input->post('category_name');

		$slug = $this->clean_url_str($career);


		//TEST DUPLICATE CATEGORIES
		$db2->where('career', $career);
		$db2->where('bus_id', $bus_id);
		$result1 = $db2->get('vacancy_careers');
		
		if($result1->num_rows() == 0){

			$insertdata = array(
			  'career'=> $career ,
			  'slug'=> $slug ,
			  'bus_id'=> $bus_id,
			);			
			
			$db2->insert('vacancy_careers', $insertdata);	
		}
		
	}	

	//Get Main Categories Typehead
	function load_category_typehead(){
		
		$db2 = $this->connect_my_db();
      			
		$query = $db2->where('main_cat_id', '2633');		
		$query = $db2->get('product_categories');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){
			
			$id = $row->cat_id;
			$cat = $row->category_name;
			
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
	//GET ALL DISCIPLINES
	//++++++++++++++++++++++++++
	public function get_all_disciplines()
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $db2->where('bus_id', $bus_id);
		  $query = $db2->get('vacancy_disciplines');
		  if($query->result()){
			echo'
	
			<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:6%;font-weight:normal"></th>
           				<th style="width:65%;font-weight:normal">Discipline </th>
						<th style="width:15%;font-weight:normal"></th>
					</tr>
				</thead>
				<tbody>';
			
			foreach($query->result() as $row){
				
				echo '<tr>
						<td style="width:6%">'.$row->discipline_id.'</td>
						<td style="width:65%"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->discipline.'</div></td>
            			<td style="width:15%;text-align:right"><a title="Delete Discipline" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_discipline('.$row->discipline_id.')">
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
			 
			echo '<div class="alert"><h3>No Discipline added</h3> No disciplines have been added. Add one by using the tool on the right</div>';  
		 }
			
		
	}


	//+++++++++++++++
	//DELETE DISCIPLINE
	//+++++++++++++++

	public function delete_discipline($id)
	{
		
		$db2 = $this->connect_my_db();
		
	    $bus_id = $this->session->userdata('bus_id');
						
		$db2->where('discipline_id', $id);
		$db2->delete('vacancy_disciplines');			

	}


	//+++++++++++++++
	//ADD DISCIPLINE
	//+++++++++++++++	
	public function add_discipline()
	{
		$bus_id = $this->session->userdata('bus_id');
		
		$db2 = $this->connect_my_db();
			
		//INSERT INTO CATEGORIES
		$discipline = $this->input->post('discipline_name');

		$slug = $this->clean_url_str($discipline);


		//TEST DUPLICATE CATEGORIES
		$db2->where('discipline', $discipline);
		$db2->where('bus_id', $bus_id);
		$result1 = $db2->get('vacancy_disciplines');
		
		if($result1->num_rows() == 0){

			$insertdata = array(
			  'discipline'=> $discipline ,
			  'slug'=> $slug ,
			  'bus_id'=> $bus_id,
			);			
			
			$db2->insert('vacancy_disciplines', $insertdata);	
		}
		
	}	

	//Get Main DISCIPLINE Typehead
	function load_discipline_typehead(){
		
		$bus_id = $this->session->userdata('bus_id');
		
		$db2 = $this->connect_my_db();
      			
		$query = $db2->where('bus_id', $bus_id);		
		$query = $db2->get('vacancy_disciplines');
		
		$result = 'var subjects = [';
		$x = 0;
		foreach($query->result() as $row){
			
			$id = $row->discipline_id;
			$cat = $row->discipline;
			
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
	
	


	//++++++++++++++++++++++++++
	//GET QUALIFICATIONS
	//++++++++++++++++++++++++++
	public function get_qualifications($type, $select)
	{	
	
		$db2 = $this->connect_my_db();
		
		$query = $db2->query("SELECT * FROM education WHERE education_type = '".$type."'", FALSE);
		
		if($query->result()){
			
			$selected = '';
			
			foreach($query->result() as $row){
				
				if($row->education == $select) { $selected = 'selected'; } else { $selected = ''; }
				
				echo '<option value="'.$row->education.'" '.$selected.'>'.$row->education.'</option>';
				
			}
			
		}
		
	}	


	public function get_applicant_dump($client_id) {
		
		$db2 = $this->connect_my_db();
		  
		$bus_id = $this->session->userdata('bus_id');
		  		
		$this->load->library('zip');
		//$this->load->helper('download');
		
		$data='NO DOWNLOAD! :: File(s): ';


		// GET CV and ID files
		$query = $db2->query("SELECT * 
							
							FROM u_client AS A
							
							INNER JOIN applicants AS B ON A.ID = B.client_id AND B.bus_id = '".$bus_id."'
							
							LEFT JOIN applicant_bio AS C ON A.ID = C.client_id
							
							LEFT JOIN applicant_current_employee AS D ON B.applicant_id = D.applicant_id
							
							LEFT JOIN applicant_disciplines AS E ON A.ID = E.client_id

							LEFT JOIN vacancy_disciplines AS F ON E.discipline_id = F.discipline_id
							
							WHERE A.ID =  '".$client_id."'", FALSE); 
		
		if($query->result()){


			
			$row = $query->row();
			

			
				if($row->disabled == 'Y') { $disability = $row->disability; } else { $disability = ''; }
				
				
				$doc_name = strtolower($row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'_bio_'.date("dmYhis")); 
				
				$html = '';
				$html.= $this->get_applicant_avatar($row->client_id);
				$html.= '<h1>'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</h1>';	
				$html.= $row->biography;
				$html.= '
					<h1>Applicant Details:</h1>
					<table class="table table-striped">
						<tr><td><strong>Name: </strong></td><td>'.$row->CLIENT_NAME .' '. $row->CLIENT_SURNAME.' ('.$row->CLIENT_GENDER.')</td></tr>
						<tr><td><strong>Date of Birth: </strong></td><td>'.date('d M Y', strtotime($row->CLIENT_DATE_OF_BIRTH)).'</td></tr>
						<tr><td><strong>Email: </strong></td><td> '.$row->CLIENT_EMAIL.'</td></tr>
						<tr><td><strong>Tel: </strong></td><td> '.$row->CLIENT_TELEPHONE.'</td></tr>
						<tr><td><strong>Cell: </strong></td><td> '.$row->CLIENT_CELLPHONE.'</td></tr>
						<tr><td><strong>Nationality: </strong></td><td> '.$row->nationality.'</td></tr>
						<tr><td><strong>Country: </strong></td><td> '.$this->get_country($row->CLIENT_COUNTRY).'</td></tr>
						<tr><td><strong>Region: </strong></td><td> '.$this->vacancy_model->get_region($row->CLIENT_REGION).'</td></tr>
						<tr><td><strong>City: </strong></td><td> '.$this->vacancy_model->get_city($row->CLIENT_CITY).'</td></tr>
						<tr><td><strong>Racial Advantage: </strong></td><td>'. $row->bee.'</td></tr>
						<tr><td><strong>Drivers Licence: </strong></td><td> '.$row->drivers.' ('.$row->drivers_type.')</td></tr>
						<tr><td><strong>Disabiled: </strong></td><td> '.$row->disabled.'</tr>
						<tr><td><strong>Nature of Disability: </strong></td><td>'.$disability.'</td></tr>

					</table>				
				
				';
				
				$sec_edu = $this->get_education_dump('secondary', $row->ID);
				$tert_edu = $this->get_education_dump('tertiary', $row->ID);
				$course_edu = $this->get_education_dump('course', $row->ID);

				$disc = $this->get_app_disciplines_dump($row->ID);
				$exp = $this->get_app_categories_dump($row->ID);
				$skill = $this->get_app_skills_dump($row->ID);

				$achieve = $this->get_achievements_dump($row->ID);
				$employ = $this->get_employments_dump($row->ID);

				//GET EDUCATION
				$html.= '
				<h1>Education</h1>
				<h2>Secondary Education</h2>
				'.$sec_edu.'<br><br>

				<h2>Tertiary Education</h2>
				'.$tert_edu.'<br><br>

				<h2>Courses</h2>
				'.$course_edu.'<br><br>

				';

				//GET EXPERIENCE
				$html.= '
				<h1>Experience & Skills</h1>

				<h2>Disciplines</h2>
				'.$disc.'<br><br>

				<h2>Experience</h2>
				'.$exp.'<br><br>

				<h2>Skills</h2>
				'.$skill.'<br><br>

				';

				if($employ != 'No Employment History available') {
				$html.='
				<h1>Employment History</h1>

				'.$employ.'

				';
				}

				if($achieve != 'No Employments available') {
				//GET ACHIEVEMENTS
				$html.= '
				<h1>Achievements</h1>

					<table class="table table-striped table-responsive" style="margin:0px">
						<tbody>
							'.$achieve.'
						</tbody>
					</table>

				';

				}


					
				// As PDF creation takes a bit of memory, we're saving the created file in /downloads/reports/
				$pdfFilePath = BASE_URL."assets/vacancy/bio/".$doc_name.".pdf";
			
				if (file_exists($pdfFilePath) == FALSE)
				{
					ini_set('memory_limit','32M'); // boost the memory limit if it's low <img src="http://davidsimpson.me/wp-includes/images/smilies/icon_wink.gif" alt=";)" class="wp-smiley">


					$this->load->library('pdf');
					$pdf = $this->pdf->load();
					$pdf->WriteHTML($html); // write the HTML into the PDF
					$pdf->Output($pdfFilePath, 'F'); // save to file because we can
					
					$file =  BASE_URL."assets/vacancy/bio/".$doc_name.".pdf";
					
					
					$this->zip->read_file($file);

					$this->zip->force_download($doc_name.'.zip');

					 if(is_file($file)) {
					    unlink($file);
					 }	
				
			
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
	//GET Main Categories
	//++++++++++++++++++++++++++
	public function get_vacancy_applicants($vid)
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		 
		  $query = $db2->query("SELECT * FROM vacancy_applicants AS A, u_client AS B WHERE A.Bus_id = '".$bus_id."' AND  A.vacancy_id = '".$vid."' AND A.client_id = B.ID", FALSE);
		  
		  if($query->result()){
			  
			  echo '<table class="table table-striped">';
			  
			  foreach($query->result() as $row){
				  
				 echo '<tr>
				 		<td style="width:90%">'.$row->CLIENT_NAME.' '.$row->CLIENT_SURNAME.'</td>
						<td style="width:90%">
							<a title="View Applicant" rel="tooltip" class="btn btn-mini" style="cursor:pointer" href="'.site_url('/').'vacancy/view_applicant/'.$row->client_id.'"><i class="icon-eye-open"></i></a>
						</td>
					   </tr>';
				  
			  }
			  
			  echo '</table>';
			  
		  } else {
			
			echo '<div class="alert">No Applicants available</div>';  
			  
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
	 //GET APPLICANT BIO
	 //++++++++++++++++++++++++++   
	   
	 function get_applicant_bio($id){
		 
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');	   
		  
		  $query = $db2->query("SELECT * FROM applicant_bio WHERE client_id = '".$id."'", FALSE);
		  
		  return $query->row_array(); 
	
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
			
		  echo '<tr>
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
			
		  echo '<tr id="row-'.$row->app_language_id.'">
					<td>'.$row->language.'</td>
					<td>'.$row->prof_read.'</td>
					<td>'.$row->prof_write.'</td>
					<td>'.$row->prof_speak.'</td>
					<td>'.$row->first_language.'</td>					
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
			
				echo '<tr>
					<td>'.$row->first_name.' '.$row->last_name.'</td>
					<td>'.$row->organisation.'</td>
					<td>'.$row->tel.'</td>
					<td>'.$row->email.'</td>
				</tr>
				';

			}
			
		}
		
	}
	
	//+++++++++++++++++++++++++++
	//GET MY VACANCIES
	//++++++++++++++++++++++++++
	public function get_applications($client_id)
	{
		  $db2 = $this->connect_my_db(); 
		  		  
		  $bus_id = $this->session->userdata('bus_id');	  
		  

		$query = $db2->query("SELECT *, a.status AS app_status

							  FROM vacancy_applicants AS a

							  INNER JOIN vacancies AS b ON a.vacancy_id = b.vacancy_id

							  WHERE a.client_id = '".$client_id."' AND  a.bus_id = '".$bus_id."' ORDER BY a.listing_date DESC", FALSE);
		  
		  if($query->result()){
			  
			
			foreach($query->result() as $row){
				
				echo '<tr>
				<td><a href="">'.$row->title.'</td>
				<td><a href="">'.date('d-m-Y', strtotime($row->listing_date)).'</td>
				<td><a href="">'.$row->app_status.'</td>
				<td><button class="btn btn-small btn-inverse pull-right" onclick="update_status('.$row->vacancy_id.','.$row->applicant_id.')"><i class="icon-pencil icon-white" style="color:#fff"></i></button></td></tr>';
			
			}
			

		 }else{
			 
			 echo '<div class="alert">
			 		<h3>No Vacancies listed </h3>
				   </div>';
		  
		 }	
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
			
				return '';	
				
			}
		  
		  }
	
	 }		 



	 //+++++++++++++++++++++++++++
	 //GET PROJECT DETAILS
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
	//GET Career Categories
	//++++++++++++++++++++++++++
	public function get_career_categories_select($cid="")
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		 
		  $query = $db2->order_by('career', 'DESC');
		  $query = $db2->where('bus_id', $bus_id);
		  $query = $db2->get('vacancy_careers');
		  
		  if($query->result()){
			  
			  
			  foreach($query->result() as $row){
				  
				  if($row->career_id == $cid) { $selected = "selected"; } else { $selected = ""; }
				  
				  echo '<option value="'.$row->career_id.'" '.$selected.'>'.$row->career.'</option>';
				  
			  }
			  
		  }
				
	}



	//+++++++++++++++++++++++++++
	//GET Main Categories
	//++++++++++++++++++++++++++
	public function get_main_categories_select($mcid="")
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		 
		  $query = $db2->order_by('category_name', 'ASC');
		  $query = $db2->group_by('category_name');
		  $query = $db2->where('main_cat_id', '2633');
		  $query = $db2->get('product_categories');
		  
		  if($query->result()){
			  
			  
			  foreach($query->result() as $row){
				  
				  if($row->cat_id == $mcid) { $selected = "selected"; } else { $selected = ""; }
				  
				  echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$row->category_name.'</option>';
				  
			  }
			  
		  }
				
	}
	
	//+++++++++++++++++++++++++++
	//GET Sub Categories
	//++++++++++++++++++++++++++
	public function get_sub_categories_select($cat_id, $scid="")
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		 
		  $query = $db2->order_by('category_name', 'ASC');
		  $query = $db2->where('sub_cat_id', $cat_id);
		  $query = $db2->get('product_categories');
		  
		  
		  if($query->result()){
			  
			   echo '
			   <option value="0">Select a Sub Category</option>
			   ';
			  
			  foreach($query->result() as $row){
				  
				  if($row->cat_id == $scid) { $selected = "selected"; } else { $selected = ""; }
				  
				  echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$row->category_name.'</option>';
				  
			  }

			  
		  } else {
			  
			  echo '<script>$("#sub-cats-div").hide("slow");</script>';
			  
		  }
				
	}
	
	//+++++++++++++++++++++++++++
	//GET Sub Categories
	//++++++++++++++++++++++++++
	public function get_sub_sub_categories_select($cat_id, $scid="")
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		 
		  $query = $db2->order_by('category_name', 'ASC');
		  $query = $db2->where('sub_sub_cat_id', $cat_id);
		  $query = $db2->get('product_categories');
		  
		  
		  if($query->result()){
			  
			   echo '
			   <option value="0">Select a Sub Category</option>
			   ';
			  
			  foreach($query->result() as $row){
				  
				  if($row->cat_id == $scid) { $selected = "selected"; } else { $selected = ""; }
				  
				  echo '<option value="'.$row->cat_id.'" '.$selected.'>'.$row->category_name.'</option>';
				  
			  }
			  
		  } else {
			  
			  echo '<script>$("#sub-sub-cats-div").hide("slow");</script>';
			  
		  }
				
	}
	
	
	//+++++++++++++++++++++++++++
	//GET ALL PRODUCTS
	//++++++++++++++++++++++++++
	public function get_all_vacancies()
	{
		  $db2 = $this->connect_my_db();
		  
		  $bus_id = $this->session->userdata('bus_id');
		  
		  $query = $db2->where('bus_id', $bus_id);
		  $query = $db2->order_by('listing_date', 'ASC');
		  $query = $db2->get('vacancies');
		  if($query->result()){
			echo'<table cellpadding="0" cellspacing="0" style="font-size:13px" border="0" class="table table-striped datatable"  width="100%">
				<thead>
					<tr style="font-size:14px">
						<th style="width:10%;font-weight:normal">Status</th>
           				<th style="width:20%;font-weight:normal">Title </th>
						<th style="width:20%;font-weight:normal">Start Date</th>
						<th style="width:20%;font-weight:normal">End Date</th>
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
				echo '<tr>
						<td style="width:10%">'.$status.'</td>
						<td style="width:20%"><a style="cursor:pointer" 
						href="'.site_url('/').'vacancy/update_vacancy/'.$row->vacancy_id.'"><div style="top:0;left:0;right:0;bottom:0;border:none">'
						.$row->title.'</div></a></td>
            			<td style="width:20%">'.date('Y-m-d',strtotime($row->start_date)).'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->end_date)).'</td>
						<td style="width:20%">'.date('Y-m-d',strtotime($row->listing_date)).'</td>
						<td style="width:10%;text-align:right">
						<a title="Edit Vacancy" rel="tooltip" class="btn btn-mini" style="cursor:pointer" 
						href="'.site_url('/').'vacancy/update_vacancy/'.$row->vacancy_id.'"><i class="icon-pencil"></i></a>
						<a title="Delete Vacancy" rel="tooltip" class="btn btn-mini btn-danger" style="cursor:pointer" onclick="delete_vacancy('.$row->vacancy_id.')">
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
			 		<h3>No Vacancies added</h3>
					No vacancies have been added. to add a new vacancy please click on the add vacancy button on the right</div>';
		  
		 }
				
		
	}	
	
	
	function add_vacancy_do() {
		
			$db2 = $this->connect_my_db();
		
			$title = $this->input->post('title', TRUE);
			$location = $this->input->post('location', TRUE);
			$career = $this->input->post('career', TRUE);
			$ref_no = $this->input->post('ref_no', TRUE);
			$start_date = $this->input->post('start_date', TRUE);
			$end_date = $this->input->post('end_date', TRUE);
			$main_cats = $this->input->post('main_cats', TRUE);
			$sub_cats = $this->input->post('sub_cats', TRUE);
			$sub_sub_cats = $this->input->post('sub_sub_cats', TRUE);
			
			$bus_id = $this->session->userdata('bus_id');

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
				  'ref_no'=> $ref_no ,
				  'title'=> $title ,
				  'location'=> $location ,
				  'start_date'=> $start_date ,
				  'end_date'=> $end_date ,
				  'career_id'=> $career ,
				  'slug'=> $slug,
				  'bus_id'=>$bus_id
				);
			
	
			
			if($val == TRUE){
		
					$db2->insert('vacancies', $insertdata);
					$vacancyid = $db2->insert_id();
					
					$this->load->model('nsa_pub_model');
					
					//LOG
					$this->admin_model->system_log('add_new_vacancy-'.$title);
					//success redirect	
					$this->session->set_flashdata('msg','Vacancy added successfully');
					$data['basicmsg'] = 'Vacancy has been added successfully';
					echo '<div class="alert alert-success">
         			<button type="button" class="close" data-dismiss="alert">×</button>
            		'.$data['basicmsg'].'</div>
					<script type="text/javascript">
					window.location = "'.site_url('/').'vacancy/update_vacancy/'.$vacancyid.'/";
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
	
	
	function update_vacancy_do() {
		
		$db2 = $this->connect_my_db();
		
		$title = $this->input->post('title', TRUE);
		$career = $this->input->post('career', TRUE);
		$ref_no = $this->input->post('ref_no', TRUE);
		$location = $this->input->post('location', TRUE);
		$body = html_entity_decode(str_replace('&nbsp;', ' ',$this->input->post('content', FALSE)));
		$start_date = $this->input->post('start_date', TRUE);
		$end_date = $this->input->post('end_date', TRUE);
		$main_cats = $this->input->post('main_cats', TRUE);
		$sub_cats = $this->input->post('sub_cats', TRUE);
		$sub_sub_cats = $this->input->post('sub_sub_cats', TRUE);
		$id = $this->input->post('vacancy_id', TRUE);
		$status = $this->input->post('status', TRUE);
		$grading = $this->input->post('grading', TRUE);
		$secondary_education = $this->input->post('secondary_education', TRUE);
		//$tertiary_education = $this->input->post('tertiary_education', TRUE);

		$bus_id = $this->session->userdata('bus_id');

	  
		//VALIDATE INPUT
		if($title == ''){
			$val = FALSE;
			$error = 'Vacancy title Required';
				
						
		}else{
			$val = TRUE;
		}
		
			$insertdata = array(
				  'ref_no'=> $ref_no ,
				  'title'=> $title ,
				  'location'=> $location ,
				  'body'=> $body ,
				  'secondary_education'=> $secondary_education,
				  'grading'=> $grading,
				  'start_date'=> $start_date ,
				  'end_date'=> $end_date ,
				  'career_id'=> $career ,
				  'status'=> strtolower($status),
				  'bus_id'=>$bus_id
				);
		

		
		if($val == TRUE){
			
				$db2->where('vacancy_id' , $id);
				$db2->update('vacancies', $insertdata);
				//success redirect	
				$data['vacancy_id'] = $id;
				
				//LOG
				$this->admin_model->system_log('update_vacancy-'. $id);
				$data['basicmsg'] = 'Vacancy has been updated successfully'.strtolower($status);
				echo "<script>var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
						noty(options);</script>";
				
		}else{
				
				echo "<script>var options = {'text':'".$error."','layout':'bottomLeft','type':'error'};
						noty(options);</script>";
			
		}		

	}
	
	
	function delete_vacancy_do($vacancy_id) {
			
		  $db2 = $this->connect_my_db();
			
		  //delete from database
		  $db2->where('vacancy_id', $vacancy_id);
		  $db2->delete('vacancies');
		  //LOG
		  $this->admin_model->system_log('delete_vacancy-'.$vacancy_id);
		  $this->session->set_flashdata('msg','Vacancy successfully deleted');
		  echo '<script type="text/javascript">
			   window.location = "'.site_url('/').'vacancy/vacancies/";
			  </script>';		
		
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
		
			  if($row->image != ""){
				  
				  $str = "$('#feat_img').html('');";
				  
				  echo '<div id="feat_img"><div class="img-polaroid"><img src="'.NA_URL.'assets/vacancies/images/'.$row->image.'" />
				  <p style="padding:10px 10px 0px 0px;text-align:right">
				  <a href="'.site_url('/').'my_images/edit/'. urlencode($this->encrypt->encode(NA_URL.'assets/vacancies/images/'.$row->image,  $this->config->item('encryption_key'), TRUE)).'" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i></a>
				  <a href="javascript:void(0);" onclick="remove_img('.$id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>
				  </p></div></div>';
				  
				  $str = "$('#userfile').click();$('#imgbut').removeClass('disabled');";
				  echo '<div id="add_img" style="display:none">
					 <form action="'. site_url('/').'vacancy/add_featured_image/" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">  
						<fieldset>
						<input type="file" class="" id="userfile" style="display:none" name="userfile">
						<input type="hidden" name="id" value="'. $id.'">
						<input type="hidden" name="bus_id" value="'. $bus_id.'">
						
						<div id="avatar_msg"></div>
						<div class="progress progress-striped active" id="procover" style="display:none;margin-top:20px">
								   <div class="bar bar-warning" style="width: 0%;"></div>
						</div>
						
						<a href="javascript:void(0)" onClick="'.$str.'" class="btn">Select Image</a>
						<button type="submit" class="btn btn-inverse" id="imgbut">Add featured Image</button>
						</fieldset>
					  </form>
					  </div>
				 
				  ';
				
			  }else{
				  
			    $str = "$('#userfile').click();$('#imgbut').removeClass('disabled');";
				echo '<div id="feat_img"><div class="alert">No featured image selected</div></div>
				<div id="add_img">
				 <form action="'. site_url('/').'vacancy/add_featured_image/" method="post" accept-charset="utf-8" id="add-img" name="add-img" enctype="multipart/form-data">  
				  	<fieldset>
					<input type="file" class="" id="userfile" style="display:none" name="userfile">
					<input type="hidden" name="id" value="'. $id.'">
					<input type="hidden" name="bus_id" value="'. $bus_id.'">
					<div id="avatar_msg"></div>
                    <div class="progress progress-striped active" id="procover" style="display:none;margin-top:20px">
                               <div class="bar bar-warning" style="width: 0%;"></div>
                    </div>
					
					<a href="javascript:void(0)" onClick="'.$str.'" class="btn">Select Image</a>
					<button type="submit" class="btn btn-inverse disabled" id="imgbut">Add featured Image</button>
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
							
							url: "'. NA_SITE_URL.'vacancy/remove_featured_image/"+id ,
							success: function (data) {
								
								
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

					 echo "<script>
					$.noty.closeAll()
					var options = {'text':'".$data['error']."','layout':'bottomLeft','type':'error'};
				  	noty(options);
					
					</script>";	
					  
					
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
			  	  $str = '<div id="feat_img"><div class="img-polaroid"><img src="'.$image.'" /><p style="padding:10px 10px 0px 0px;text-align:right"><a href="'.site_url('/').'my_images/edit/'. rawurlencode($this->encrypt->encode(NA_URL.'assets/vacancies/images/'.$file,  $this->config->item('encryption_key'), TRUE)).'" style="margin-right:5px" class="btn btn-mini btn-primary"><i class="icon-pencil icon-white"></i></a><a href="javascript:void(0);" onclick="remove_img('.$id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></p></div></div>';
				  echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);
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
				
			 echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'Image removed.','layout':'bottomLeft','type':'success'};
					  noty(options);
					
					  </script>";		 
						 	
			
		}
	}
	
	public function get_featured_document($id) {
		
		$db2 = $this->connect_my_db();
		
		$bus_id = $this->session->userdata('bus_id');
			
		$query = $db2->select('document');
		$query = $db2->where('bus_id', $bus_id);
		$query = $db2->where('vacancy_id', $id);
		$query = $db2->get('vacancies');
		
		$row = $query->row();
		
			  if($row->document != ""){
				  
				  $str = "$('#feat_doc').html('');";
				  
				  echo '<div id="feat_doc"><pre>'.$row->document.'</pre><a href="javascript:void(0);" onclick="remove_doc('.$id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a></div>';
				  
				  $str = "$('#userfile1').click(); $('#docbut').removeClass('disabled');";
				  echo '<div id="add_doc" style="display:none">
					 <form action="'. site_url('/').'vacancy/add_featured_document/" method="post" accept-charset="utf-8" id="add-doc" name="add-doc" enctype="multipart/form-data">  
						<fieldset>
						<input type="file" class="" id="userfile1" style="display:none" name="userfile">
						<input type="hidden" name="id" value="'. $id.'">
						<input type="hidden" name="bus_id" value="'. $bus_id.'">
						
						<div id="avatar_msg2"></div>
						<div class="progress progress-striped active" id="procover2" style="display:none;margin-top:20px">
								   <div class="bar bar-warning" style="width: 0%;"></div>
						</div>
						
						<a href="javascript:void(0)" onClick="'.$str.'" class="btn">Select Document</a>
						<button type="submit" class="btn btn-inverse" id="docbut">Add featured Document</button>
						</fieldset>
					  </form>
					  </div>
				 
				  ';
				
			  }else{
				  
			    $str = "$('#userfile1').click();$('#docbut').removeClass('disabled');";
				echo '<div id="feat_doc"><div class="alert">No featured document selected</div></div>
				<div id="add_doc">
				 <form action="'. site_url('/').'vacancy/add_featured_document/" method="post" accept-charset="utf-8" id="add-doc" name="add-doc" enctype="multipart/form-data">  
				  	<fieldset>
					<input type="file" class="" id="userfile1" style="display:none" name="userfile">
					<input type="hidden" name="bus_id" value="'. $bus_id.'">
					<input type="hidden" name="id" value="'. $id.'">
					<div id="avatar_msg2"></div>
                    <div class="progress progress-striped active" id="procover2" style="display:none;margin-top:20px">
                               <div class="bar bar-warning" style="width: 0%;"></div>
                    </div>
					
					<a href="javascript:void(0)" onClick="'.$str.'" class="btn">Select Document</a>
					<button type="submit" class="btn btn-inverse disabled" id="docbut">Add featured Document</button>
					</fieldset>
				  </form>
				  </div>';	
				  
				  
			  }
		
		echo ' <script type="text/javascript">
				  	function remove_doc(id){
						$("#add_doc").fadeIn();
				  		$("#feat_doc").empty();
						
						$.ajax({
							type: "get",
							
							url: "'. NA_SITE_URL.'vacancy/remove_featured_document/"+id ,
							success: function (data) {
								
								
							}
						});
						
					}
				  </script>';
	}
	
	
	//+++++++++++++++++++++++++++
	//ADD FEATURED IMAGE
	//++++++++++++++++++++++++++

	function add_featured_document()
	{
		
			$db2 = $this->connect_my_db();
			
			$bus_id = $this->session->userdata('bus_id');
		
			$doc = $this->input->post('userfile', TRUE);
			
			echo $doc;
			
			$id = $this->input->post('id', TRUE);

			//upload file
			$config['upload_path'] = NA_BASE_URL . 'assets/vacancies/documents/vacancies/';
			$config['allowed_types'] = 'pdf|doc|docx|csv|xls|xlsx';
			$config['max_size']	= '100000';
			$config['remove_spaces']  = TRUE;
			$config['encrypt_name']  = TRUE;
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
				
					
				 //populate array with values
				  $data_doc = array( 
					'document'=> $file,
				  );
				  
				  
				  $db2->where('vacancy_id' , $id);
				  $db2->update('vacancies',$data_doc);				  					


				  $data['filename'] = $file;

				 //redirect 
				  $data['basicmsg'] = 'Document added successfully!';
			  	  $str = '<pre>'.$file.'</pre><a href="javascript:void(0);" onclick="remove_doc('.$id.')" class="btn btn-mini btn-danger"><i class="icon-trash icon-white"></i></a>';
				  echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'".$data['basicmsg']."','layout':'bottomLeft','type':'success'};
					  noty(options);
					  $('#feat_doc').html('".$str."');
					  $('#add_doc').fadeOut();
					  </script>";			 
						 
					

		}

	}	

	public function remove_featured_document($id)
	{
		
		$db2 = $this->connect_my_db();
		
		$bus_id = $this->session->userdata('bus_id');
				
		$query = $db2->select('document');
		$query = $db2->where('vacancy_id', $id);
		$query = $db2->get('vacancies');
		
		if($query->result()){
			
			$row = $query->row_array();
			
			$file =  NA_BASE_URL.'assets/vacancies/documents/vacancies/' . $row['document']; # build the full path		
			
			if (file_exists($file)) {
				unlink($file);
			}
			
				$db2->set('document' , '');
				$db2->where('vacancy_id' , $id);
				$db2->update('vacancies');
				
			 echo "<script>
					  $.noty.closeAll()
					  var options = {'text':'Document removed.','layout':'bottomLeft','type':'success'};
					  noty(options);

					  </script>";		 
						 	
			
		}
	}


	function management() {



	}



	//+++++++++++++++++++++++++++
	//RANDOM STRING GENERATOR
	//++++++++++++++++++++++++++
	function generateRandomString($length = 10) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}
		return $randomString;
	}


	//+++++++++++++++++++++++++++
	//ENCRYPRION FUNCTIONS
	//++++++++++++++++++++++++++

	public function encrypt($email, $pass)
	{
		$str = str_replace('_-_','@',$email);
		return $this->hash_password($str,$pass);

	}

	public function decrypt($str,$pass)
	{

		//echo $this->encrypt_model->hash_password($str,$pass);

		$row = $this->validate_password($str,$pass);
		if($this->validate_password($str,$pass)){

			echo 'YES';

		}else{

			echo 'No';

		}

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


		$db2 = $this->connect_my_db();

		$sql = $db2->where('bus_id', BUS_ID);
		$sql = $db2->where('email', $username);
		$sql = $db2->limit('1');
		$sql = $db2->get('applicants');



		$res = array();
		//SEE IF ROW EVEN EXISTS
		if($sql->num_rows() > 0){

			$r = $sql->row_array();
			$res['applicant_id'] = $r['applicant_id'];
			$res['level'] = $r['level'];
			$res['client_id'] = $r['client_id'];
			$res['status'] = $r['status'];
			$res['bus_id'] = $r['bus_id'];
			$res['type'] = $r['type'];
			// The first 64 characters of the hash is the salt
			$salt = substr($r['password'], 0, 64);

			$hash = $salt . $password;

			// Hash the password as we did before
			for ( $i = 0; $i < 100000; $i ++ ) {
				$hash = hash('sha256', $hash);
			}

			$hash = $salt . $hash;

			if ( $hash == $r['password'] ) {

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