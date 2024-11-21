<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model');
		$this->load->model('Users_model');
		if (!$this->session->userdata('user_id')) {
			redirect('auth');
		}
	}

	// Halaman Dashboard
	public function dashboard()
	{
		$name = $this->session->userdata('name');
		//var_dump($name);
		$data['users'] = $this->User_model->get_all_users();
		$data['nama_user'] = $name;
		$data['content_page'] = "layout/content/dashboard";
		$this->load->view("layout/template/index", $data);
		// $this->load->view('dashboard', $data);
	}

	// Halaman Form Pengguna (Tambah/Edit)
	public function form($id = NULL)
	{
		if ($id) {
			$data['user'] = $this->User_model->get_user($id);
		} else {
			$data['user'] = NULL;
		}
		$this->load->view('user_form', $data);
	}

	// Proses tambah/edit pengguna
	public function save($id = NULL)
	{
		$this->form_validation->set_rules('name', 'Nama', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'min_length[8]');

		if ($this->form_validation->run() == FALSE) {
			$this->form($id);
		} else {
			$data = [
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'role' => $this->input->post('role')
			];

			if ($this->input->post('password')) {
				$data['password'] = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
			}

			if ($id) {
				$this->User_model->update_user($id, $data);
			} else {
				$this->User_model->insert_user($data);
			}

			redirect('user/dashboard');
		}
	}

	// Hapus pengguna
	public function delete($id)
	{
		$this->User_model->delete_user($id);
		redirect('user/dashboard');
	}


	public function user_list()
	{
		$users = $this->Users_model->get_all();
		// $data[] = $name;
		$name = $this->session->userdata('name');

		$data = array(
			'users_data' => $users,
			'nama_user' => $name

		);

		// $this->load->view('users_list', $data);
		$data['content_page'] = "layout/content/users_list";
		$this->load->view("layout/template/index", $data);
	}

	public function read($id)
	{
		$row = $this->Users_model->get_by_id($id);
		$name = $this->session->userdata('name');

		if ($row) {
			$data = array(
				'id' => $row->id,
				'name' => $row->name,
				'email' => $row->email,
				'password' => $row->password,
				'role' => $row->role,
				'created_at' => $row->created_at,
				'nama_user' => $name

			);
			// $this->load->view('users_read', $data);
			$data['content_page'] = "layout/content/users_read";
			$this->load->view("layout/template/index", $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('users'));
		}
	}

	public function create()
	{
		$data = array(
			'button' => 'Create',
			'action' => site_url('users/create_action'),
			'id' => set_value('id'),
			'name' => set_value('name'),
			'email' => set_value('email'),
			'password' => set_value('password'),
			'role' => set_value('role'),
			'created_at' => set_value('created_at'),
		);
		$this->load->view('users_form', $data);
	}

	public function create_action()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->create();
		} else {
			$data = array(
				'name' => $this->input->post('name', TRUE),
				'email' => $this->input->post('email', TRUE),
				'password' => $this->input->post('password', TRUE),
				'role' => $this->input->post('role', TRUE),
				'created_at' => $this->input->post('created_at', TRUE),
			);

			$this->Users_model->insert($data);
			$this->session->set_flashdata('message', 'Create Record Success');
			redirect(site_url('users'));
		}
	}

	public function update($id)
	{
		$row = $this->Users_model->get_by_id($id);

		if ($row) {
			$data = array(
				'button' => 'Update',
				'action' => site_url('users/update_action'),
				'id' => set_value('id', $row->id),
				'name' => set_value('name', $row->name),
				'email' => set_value('email', $row->email),
				'password' => set_value('password', $row->password),
				'role' => set_value('role', $row->role),
				'created_at' => set_value('created_at', $row->created_at),
			);
			$this->load->view('users_form', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('users'));
		}
	}

	public function update_action()
	{
		$this->_rules();

		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id', TRUE));
		} else {
			$data = array(
				'name' => $this->input->post('name', TRUE),
				'email' => $this->input->post('email', TRUE),
				'password' => $this->input->post('password', TRUE),
				'role' => $this->input->post('role', TRUE),
				'created_at' => $this->input->post('created_at', TRUE),
			);

			$this->Users_model->update($this->input->post('id', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('users'));
		}
	}

	public function delete_user($id)
	{
		$row = $this->Users_model->get_by_id($id);

		if ($row) {
			$this->Users_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('users'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('users'));
		}
	}

	public function _rules()
	{
		$this->form_validation->set_rules('name', 'name', 'trim|required');
		$this->form_validation->set_rules('email', 'email', 'trim|required');
		$this->form_validation->set_rules('password', 'password', 'trim|required');
		$this->form_validation->set_rules('role', 'role', 'trim|required');
		$this->form_validation->set_rules('created_at', 'created at', 'trim|required');

		$this->form_validation->set_rules('id', 'id', 'trim');
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
	}
}
