<?php if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Member extends CI_Controller
{


	function member()
	{
		parent::__construct();
		$this->load->model('member_model');
		//force_ssl();
	}



	//+++++++++++++++++++++++++++
	//update member sequence
	//++++++++++++++++++++++++++

	public function update_member_sequence($member_id, $sequence)
	{
		$data['sequence'] = $sequence;
		$this->db->where('member_id', $member_id);
		$this->db->update('member', $data);
	}


	//+++++++++++++++++++++++++++
	//member
	//++++++++++++++++++++++++++

	public function members()
	{
		if ($this->session->userdata('admin_id')) {

			$this->load->view('admin/member/members');

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//add new member
	//++++++++++++++++++++++++++

	public function add_member()
	{
		if ($this->session->userdata('admin_id')) {

			$this->load->view('admin/member/add_member');

		} else {

			$this->load->view('admin/login');

		}


	}

	//+++++++++++++++++++++++++++
	//ADD member DO
	//++++++++++++++++++++++++++

	public function add_member_do()
	{
		if ($this->session->userdata('admin_id')) {

			$this->member_model->add_member_do();

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//update member
	//++++++++++++++++++++++++++

	public function update_member($member_id)
	{
		if ($this->session->userdata('admin_id')) {

			$member = $this->member_model->get_member($member_id);
			$this->load->view('admin/member/update_member', $member);

		} else {

			$this->load->view('admin/login');

		}


	}


	//+++++++++++++++++++++++++++
	//UPDATE member DO
	//++++++++++++++++++++++++++

	public function update_member_do()
	{
		if ($this->session->userdata('admin_id')) {

			$this->member_model->update_member_do();

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//DELETE member DO
	//++++++++++++++++++++++++++

	public function delete_member($member_id)
	{
		if ($this->session->userdata('admin_id')) {

			$this->member_model->delete_member($member_id);

		} else {

			$this->load->view('admin/login');

		}

	}


	//+++++++++++++++++++++++++++
	//ADD ITEM member
	//++++++++++++++++++++++++++

	public function add_member_item()
	{
		if ($this->session->userdata('admin_id')) {

			$this->member_model->add_member_item();

		} else {

			$this->load->view('admin/login');

		}

	}

	public function delete_member_item($id)
	{
		if ($this->session->userdata('admin_id')) {

			$this->member_model->delete_member_item($id);

		} else {

			$this->load->view('admin/login');

		}

	}


	public function reload_member_item($type_id, $type)
	{
		$this->member_model->get_member_current($type_id, $type);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */