<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class firm extends CI_Controller
{


	function firm()
	{
		parent::__construct();
		$this->load->model('firm_model');
		//force_ssl();
	}



	//+++++++++++++++++++++++++++
	//update firm sequence
	//++++++++++++++++++++++++++

	public function update_firm_sequence($firm_id, $sequence)
	{
		$data['sequence'] = $sequence;
		$this->db->where('firm_id', $firm_id);
		$this->db->update('firm', $data);
	}


	//+++++++++++++++++++++++++++
	//firm
	//++++++++++++++++++++++++++

	public function firms()
	{
		if ($this->session->userdata('admin_id')) {

			$this->load->view('admin/firm/firms');

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//add new firm
	//++++++++++++++++++++++++++

	public function add_firm()
	{
		if ($this->session->userdata('admin_id')) {

			$this->load->view('admin/firm/add_firm');

		} else {

			$this->load->view('admin/login');

		}


	}

	//+++++++++++++++++++++++++++
	//ADD firm DO
	//++++++++++++++++++++++++++

	public function add_firm_do()
	{
		if ($this->session->userdata('admin_id')) {

			$this->firm_model->add_firm_do();

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//update firm
	//++++++++++++++++++++++++++

	public function update_firm($firm_id)
	{
		if ($this->session->userdata('admin_id')) {

			$firm = $this->firm_model->get_firm($firm_id);
			$this->load->view('admin/firm/update_firm', $firm);

		} else {

			$this->load->view('admin/login');

		}


	}


	//+++++++++++++++++++++++++++
	//UPDATE firm DO
	//++++++++++++++++++++++++++

	public function update_firm_do()
	{
		if ($this->session->userdata('admin_id')) {

			$this->firm_model->update_firm_do();

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE firm DO
	//++++++++++++++++++++++++++

	public function delete_firm($firm_id)
	{
		if ($this->session->userdata('admin_id')) {

			$this->firm_model->delete_firm($firm_id);

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD ITEM firm
	//++++++++++++++++++++++++++

	public function add_firm_item()
	{
		if ($this->session->userdata('admin_id')) {

			$this->firm_model->add_firm_item();

		} else {

			$this->load->view('admin/login');

		}

	}

	public function delete_firm_item($id)
	{
		if ($this->session->userdata('admin_id')) {

			$this->firm_model->delete_firm_item($id);

		} else {

			$this->load->view('admin/login');

		}

	}


	public function reload_firm_item($type_id, $type)
	{
		$this->firm_model->get_firm_current($type_id, $type);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */