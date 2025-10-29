<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class course extends CI_Controller {


	 function course()
	{
		parent::__construct();
		$this->load->model('course_model');
		//force_ssl();
	}



	//+++++++++++++++++++++++++++
	//update course sequence
	//++++++++++++++++++++++++++

	public function update_course_sequence($course_id , $sequence)
	{
		$data['sequence'] = $sequence;
		$this->db->where('course_id' , $course_id);
		$this->db->update('course', $data);
	}


	//+++++++++++++++++++++++++++
	//course
	//++++++++++++++++++++++++++

	public function courses()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/course/course');

		}else{

			$this->load->view('admin/login');

		}

	}
	public function add_category_course()
	{
		if($this->session->userdata('admin_id')){
			
			$this->course_model->add_category_course();
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}

	//+++++++++++++++++++++++++++
	//add new course
	//++++++++++++++++++++++++++

	public function add_course()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/course/add_course');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	//+++++++++++++++++++++++++++
	//ADD course DO
	//++++++++++++++++++++++++++

	public function add_course_do()
	{
		if($this->session->userdata('admin_id')){

			$this->course_model->add_course_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//update course
	//++++++++++++++++++++++++++

	public function update_course($course_id)
	{
		if($this->session->userdata('admin_id')){
			
			$course = $this->course_model->get_course($course_id);
			$this->load->view('admin/course/update_course', $course);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE course DO
	//++++++++++++++++++++++++++

	public function update_course_do()
	{
		if($this->session->userdata('admin_id')){

			$this->course_model->update_course_do();

		}else{

			$this->load->view('admin/login');

		}

	}

	public function delete_category_course($id)
	{
		if($this->session->userdata('admin_id')){
			
			$this->publication_model->delete_category_course($id);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
	}
	//+++++++++++++++++++++++++++
	//DELETE course DO
	//++++++++++++++++++++++++++

	public function delete_course($course_id)
	{
		if($this->session->userdata('admin_id')){

			$this->course_model->delete_course($course_id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD ITEM course
	//++++++++++++++++++++++++++

	public function add_course_item()
	{
		if($this->session->userdata('admin_id')){

			$this->course_model->add_course_item();

		}else{

			$this->load->view('admin/login');

		}

	}

	public function delete_course_item($id)
	{
		if($this->session->userdata('admin_id')){

			$this->course_model->delete_course_item($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	public function reload_course_item($type_id, $type)
	{
		$this->course_model->get_course_current($type_id, $type);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */