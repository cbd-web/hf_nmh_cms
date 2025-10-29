<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class faculty extends CI_Controller {


	 function faculty()
	{
		parent::__construct();
		$this->load->model('faculty_model');
		//force_ssl();
	}



	//+++++++++++++++++++++++++++
	//update faculty sequence
	//++++++++++++++++++++++++++

	public function update_faculty_sequence($faculty_id , $sequence)
	{
		$data['sequence'] = $sequence;
		$this->db->where('faculty_id' , $faculty_id);
		$this->db->update('faculty', $data);
	}


	//+++++++++++++++++++++++++++
	//faculty
	//++++++++++++++++++++++++++

	public function faculties()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/faculty/faculty');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//add new faculty
	//++++++++++++++++++++++++++

	public function add_faculty()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/faculty/add_faculty');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	//+++++++++++++++++++++++++++
	//ADD faculty DO
	//++++++++++++++++++++++++++

	public function add_faculty_do()
	{
		if($this->session->userdata('admin_id')){

			$this->faculty_model->add_faculty_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//update faculty
	//++++++++++++++++++++++++++

	public function update_faculty($faculty_id)
	{
		if($this->session->userdata('admin_id')){
			
			$faculty = $this->faculty_model->get_faculty($faculty_id);
			$this->load->view('admin/faculty/update_faculty', $faculty);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE faculty DO
	//++++++++++++++++++++++++++

	public function update_faculty_do()
	{
		if($this->session->userdata('admin_id')){

			$this->faculty_model->update_faculty_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE faculty DO
	//++++++++++++++++++++++++++

	public function delete_faculty($faculty_id)
	{
		if($this->session->userdata('admin_id')){

			$this->faculty_model->delete_faculty($faculty_id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD ITEM faculty
	//++++++++++++++++++++++++++

	public function add_faculty_item()
	{
		if($this->session->userdata('admin_id')){

			$this->faculty_model->add_faculty_item();

		}else{

			$this->load->view('admin/login');

		}

	}

	public function delete_faculty_item($id)
	{
		if($this->session->userdata('admin_id')){

			$this->faculty_model->delete_faculty_item($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	public function reload_faculty_item($type_id, $type)
	{
		$this->faculty_model->get_faculty_current($type_id, $type);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */