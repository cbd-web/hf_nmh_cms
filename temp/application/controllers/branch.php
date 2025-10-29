<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Branch extends CI_Controller {


	 function branch()
	{
		parent::__construct();
		$this->load->model('branch_model');
		//force_ssl();
	}



	//+++++++++++++++++++++++++++
	//update Branch sequence
	//++++++++++++++++++++++++++

	public function update_branch_sequence($branch_id , $sequence)
	{
		$data['sequence'] = $sequence;
		$this->db->where('branch_id' , $branch_id);
		$this->db->update('branches', $data);
	}


	//+++++++++++++++++++++++++++
	//Branches
	//++++++++++++++++++++++++++

	public function branches()
	{
		if($this->session->userdata('admin_id')){

			$this->load->view('admin/branches/branches');

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//add new branch
	//++++++++++++++++++++++++++

	public function add_branch()
	{
		if($this->session->userdata('admin_id')){
			
			$this->load->view('admin/branches/add_branch');
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}

	//+++++++++++++++++++++++++++
	//ADD BRANCH DO
	//++++++++++++++++++++++++++

	public function add_branch_do()
	{
		if($this->session->userdata('admin_id')){

			$this->branch_model->add_branch_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//update branch
	//++++++++++++++++++++++++++

	public function update_branch($branch_id)
	{
		if($this->session->userdata('admin_id')){
			
			$branch = $this->branch_model->get_branch($branch_id);
			$this->load->view('admin/branches/update_branch', $branch);
			
		}else{
			
			$this->load->view('admin/login');
			
		}
		
		
	}


	//+++++++++++++++++++++++++++
	//UPDATE BRANCH DO
	//++++++++++++++++++++++++++

	public function update_branch_do()
	{
		if($this->session->userdata('admin_id')){

			$this->branch_model->update_branch_do();

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE BRANCH DO
	//++++++++++++++++++++++++++

	public function delete_branch($branch_id)
	{
		if($this->session->userdata('admin_id')){

			$this->branch_model->delete_branch($branch_id);

		}else{

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD ITEM BRANCH
	//++++++++++++++++++++++++++

	public function add_branch_item()
	{
		if($this->session->userdata('admin_id')){

			$this->branch_model->add_branch_item();

		}else{

			$this->load->view('admin/login');

		}

	}

	public function delete_branch_item($id)
	{
		if($this->session->userdata('admin_id')){

			$this->branch_model->delete_branch_item($id);

		}else{

			$this->load->view('admin/login');

		}

	}


	public function reload_branch_item($type_id, $type)
	{
		$this->branch_model->get_branches_current($type_id, $type);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */