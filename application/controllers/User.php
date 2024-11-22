<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// $this->load->model('User_model');
		$this->load->model('Users_model');
		$this->load->model('Sales_model');
		$this->load->helper('url');
		// $this->load->library('excel'); // Untuk ekspor Excel
		$this->load->library('pdf');  // Untuk ekspor PDF
		if (!$this->session->userdata('user_id')) {
			redirect('auth');
		}

		// Cek apakah pengguna sudah login, kecuali untuk fungsi login dan index
		if (!in_array($this->router->fetch_method(), ['index', 'login']) && !$this->session->userdata('user_id')) {
			redirect('auth'); // Redirect ke halaman login jika belum login
		}
	}

	// Halaman Dashboard
	public function dashboard()
	{
		$name = $this->session->userdata('name');
		//var_dump($name);
		$data['users'] = $this->Users_model->get_all_users();
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$data['sales'] = $this->Sales_model->get_sales($start_date, $end_date);
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;

		$data['nama_user'] = $name;
		$data['content_page'] = "layout/content/dashboard";
		$this->load->view("layout/template/index", $data);
		// $this->load->view('dashboard', $data);
	}

	public function user_list()
	{

		// if (!is_admin()) {
		// 	$this->session->set_flashdata('message', 'Access Denied: Admins only.');
		// 	redirect(site_url('user/dashboard'));
		// }
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

		// if (!is_admin()) {
		// 	$this->session->set_flashdata('message', 'Access Denied: Admins only.');
		// 	redirect(site_url('user/dashboard'));
		// }
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
		// if (!is_admin()) {
		// 	$this->session->set_flashdata('message', 'Access Denied: Admins only.');
		// 	redirect(site_url('user/dashboard'));
		// }
		$name = $this->session->userdata('name');
		$data = array(
			'nama_user' => $name,
			'content_page' =>  "layout/content/users_form"
		);
		$this->load->view("layout/template/index", $data);
	}



	public function create_action()
	{
		// if (!is_admin()) {
		// 	$this->session->set_flashdata('message', 'Access Denied: Admins only.');
		// 	redirect(site_url('user/dashboard'));
		// }
		// Aturan validasi
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]');
		$this->form_validation->set_rules('role', 'Role', 'trim|required');
		// $this->form_validation->set_rules('created_at', 'Created At', 'trim|required');

		// Jika validasi gagal
		if ($this->form_validation->run() == FALSE) {
			$this->create(); // Kembali ke form create
		} else {
			// Ambil data dari form
			$data = array(
				'name' => $this->input->post('name', TRUE),
				'email' => $this->input->post('email', TRUE),
				'password' => md5($this->input->post('password', TRUE)), // Enkripsi password
				'role' => $this->input->post('role', TRUE),
				'created_at' => date('Y-m-d H:i:s'), // Waktu sekarang
			);

			// Simpan data ke database melalui model
			$this->Users_model->insert($data);

			// Set flashdata untuk notifikasi
			$this->session->set_flashdata('message', 'Create Record Success');

			// Redirect ke halaman daftar pengguna
			redirect(site_url('user/user-list'));
		}
	}




	public function update($id)
	{
		
		$row = $this->Users_model->get_by_id($id); // Ambil data berdasarkan ID

		if ($row) {
			$name = $this->session->userdata('name'); // Ambil nama pengguna dari session
			$data = array(
				'button' => 'Update',
				'action' => site_url('user/update_action'), // Action untuk update
				'id' => $row->id,
				'name' => set_value('name', $row->name),
				'email' => set_value('email', $row->email),
				'password' => '', // Kosongkan, hanya update jika diisi
				'role' => set_value('role', $row->role),
				'nama_user' => $name,
				'content_page' => 'layout/content/users_form_update', // Form update
			);
			$this->load->view('layout/template/index', $data);
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('user/user-list'));
		}
	}

	public function update_action()
	{
		// Tambahkan aturan validasi untuk email dan password
		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email', [
			'valid_email' => 'Email harus mengandung "@" dan formatnya valid.',
		]);
		$this->form_validation->set_rules('password', 'Password', 'trim|min_length[8]', [
			'min_length' => 'Password harus memiliki setidaknya 8 karakter.',
		]);
		$this->form_validation->set_rules('role', 'Role', 'trim|required');

		// Jika validasi gagal
		if ($this->form_validation->run() == FALSE) {
			$this->update($this->input->post('id', TRUE));
		} else {
			// Ambil data dari input
			$data = array(
				'name' => $this->input->post('name', TRUE),
				'email' => $this->input->post('email', TRUE),
				'role' => $this->input->post('role', TRUE),
			);

			// Jika password diisi, tambahkan ke data
			if (!empty($this->input->post('password', TRUE))) {
				$data['password'] = md5($this->input->post('password', TRUE));
			}

			// Update data pengguna
			$this->Users_model->update($this->input->post('id', TRUE), $data);
			$this->session->set_flashdata('message', 'Update Record Success');
			redirect(site_url('user/user-list'));
		}
	}


	public function delete_user($id)
	{
		// if (!is_admin()) {
		// 	$this->session->set_flashdata('message', 'Access Denied: Admins only.');
		// 	redirect(site_url('user/dashboard'));
		// }
		$row = $this->Users_model->get_by_id($id);

		if ($row) {
			$this->Users_model->delete($id);
			$this->session->set_flashdata('message', 'Delete Record Success');
			redirect(site_url('user/user-list'));
		} else {
			$this->session->set_flashdata('message', 'Record Not Found');
			redirect(site_url('user/user-list'));
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
