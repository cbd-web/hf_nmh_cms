<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Accountant extends CI_Controller
{


	function accountant()
	{
		parent::__construct();
		$this->load->model('accountant_model');
		//force_ssl();
	}



	//+++++++++++++++++++++++++++
	//update accountant sequence
	//++++++++++++++++++++++++++

	public function update_accountant_sequence($accountant_id, $sequence)
	{
		$data['sequence'] = $sequence;
		$this->db->where('accountant_id', $accountant_id);
		$this->db->update('accountant', $data);
	}


	//+++++++++++++++++++++++++++
	//accountant
	//++++++++++++++++++++++++++

	public function accountants()
	{
		if ($this->session->userdata('admin_id')) {

			$this->load->view('admin/accountant/accountants');

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//add new accountant
	//++++++++++++++++++++++++++

	public function add_accountant()
	{
		if ($this->session->userdata('admin_id')) {

			$this->load->view('admin/accountant/add_accountant');

		} else {

			$this->load->view('admin/login');

		}


	}

	//+++++++++++++++++++++++++++
	//ADD accountant DO
	//++++++++++++++++++++++++++

	public function add_accountant_do()
	{
		if ($this->session->userdata('admin_id')) {

			$this->accountant_model->add_accountant_do();

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//update accountant
	//++++++++++++++++++++++++++

	public function update_accountant($accountant_id)
	{
		if ($this->session->userdata('admin_id')) {

			$accountant = $this->accountant_model->get_accountant($accountant_id);
			$this->load->view('admin/accountant/update_accountant', $accountant);

		} else {

			$this->load->view('admin/login');

		}


	}


	//+++++++++++++++++++++++++++
	//UPDATE accountant DO
	//++++++++++++++++++++++++++

	public function update_accountant_do()
	{
		if ($this->session->userdata('admin_id')) {

			$this->accountant_model->update_accountant_do();

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE accountant DO
	//++++++++++++++++++++++++++

	public function delete_accountant($accountant_id)
	{
		if ($this->session->userdata('admin_id')) {

			$this->accountant_model->delete_accountant($accountant_id);

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD ITEM accountant
	//++++++++++++++++++++++++++

	public function add_accountant_item()
	{
		if ($this->session->userdata('admin_id')) {

			$this->accountant_model->add_accountant_item();

		} else {

			$this->load->view('admin/login');

		}

	}

	public function delete_accountant_item($id)
	{
		if ($this->session->userdata('admin_id')) {

			$this->accountant_model->delete_accountant_item($id);

		} else {

			$this->load->view('admin/login');

		}

	}


	public function reload_accountant_item($type_id, $type)
	{
		$this->accountant_model->get_accountant_current($type_id, $type);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */