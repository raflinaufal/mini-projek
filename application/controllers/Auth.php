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

		// Jika validasi gagal, tampilkan halaman login
		if ($this->form_validation->run() == FALSE) {
			$this->load->view('layout/login');
		} else {
			// Ambil email dan password yang dimasukkan
			$email = $this->input->post('email');
			$password = md5($this->input->post('password'));  // Menggunakan MD5 untuk password
			// Validasi pengguna berdasarkan email
			$user = $this->User_models->get_user_by_email($email);
			// var_dump($user);exit;

			if ($user && $user['password'] === $password) {  // Bandingkan password MD5
				// Jika valid, set session data
				$this->session->set_userdata('user_id', $user['id']);
				$this->session->set_userdata('name', $user['name']);
				$this->session->set_userdata('role', $user['role']);
				redirect('user/dashboard');
			} else {
				// Jika login gagal, tampilkan pesan error
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
