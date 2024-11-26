<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->load->library('form_validation');
		$this->load->model('Users_model');
	}

	// Halaman Login
	public function index()
	{
		$this->load->view('layout/login');
	}

	// Proses login
	public function login()
	{
		// Aturan validasi form
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[8]');

		if ($this->form_validation->run() == FALSE) {
			// Jika validasi gagal, tampilkan kembali halaman login
			$this->load->view('layout/login');
		} else {
			// Ambil data input
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));  // Gunakan MD5 untuk password

			// Ambil pengguna dari database
			$user = $this->Users_model->get_user_by_email($email);

			if ($user && $user['password'] === $password) {
				// Jika email dan password cocok, set session
				$this->session->set_userdata([
					'user_id' => $user['id'],
					'name' => $user['name'],
					'role' => $user['role'],
					'logged_in' => TRUE,
				]);

				// Redirect berdasarkan role
				if ($user['role'] === 'Admin') {
					redirect('user/dashboard'); // Admin ke halaman daftar pengguna
				} else {
					redirect('/home'); // Non-admin ke dashboard
				}
			} else {
				// Jika login gagal
				$this->session->set_flashdata('error', 'Email atau password salah.');
				redirect('auth');
			}
		}
	}


	// Logout
	public function logout()
	{
		$this->session->sess_destroy();
		redirect('auth');
	}
}
