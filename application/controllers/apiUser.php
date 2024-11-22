<?php
defined('BASEPATH') or exit('No direct script access allowed');

class apiUser extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// Memuat model untuk berinteraksi dengan database
		$this->load->model('Users_model');
		// Mengaktifkan header untuk JSON
		header('Content-Type: application/json');
	}

	// GET: Mengambil semua data pengguna
	public function index()
	{
		$data = $this->Users_model->get_all_users();
		echo json_encode($data);
	}

	// GET: Mengambil data pengguna berdasarkan ID
	public function get_user($id)
	{
		$data = $this->Users_model->get_by_id($id);
		if ($data) {
			echo json_encode($data);
		} else {
			echo json_encode(['error' => 'User not found']);
		}
	}


	
	// POST: Menambahkan pengguna baru
	public function create()
	{
		// Validasi input
		$this->form_validation->set_data($this->input->post());
		$this->form_validation->set_rules('name', 'Nama', 'required', [
			'required' => 'Nama tidak boleh kosong.'
		]);
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|callback_email_unique', [
			'required' => 'Email tidak boleh kosong.',
			'valid_email' => 'Format email tidak valid.'
		]);
		$this->form_validation->set_rules('phone', 'Nomor Telepon', 'required', [
			'required' => 'Nomor telepon tidak boleh kosong.'
		]);
		$this->form_validation->set_rules('password', 'Kata Sandi', 'required|min_length[6]', [
			'required' => 'Kata sandi tidak boleh kosong.',
			'min_length' => 'Kata sandi harus minimal 6 karakter.'
		]);

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['error' => $this->form_validation->error_array()]);
		} else {
			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone'),
				'password' => md5($this->input->post('password')) // Hash password
			);

			try {
				$insert_id = $this->Users_model->insert_data($data); // Proses insert data
				if ($insert_id) {
					// Tambahkan ID yang baru saja dibuat ke dalam data
					$data['id'] = $insert_id;
					unset($data['password']); // Jangan tampilkan password di respons
					echo json_encode([
						'success' => 'Pengguna berhasil ditambahkan.',
						'data' => $data // Kembalikan data pengguna
					]);
				} else {
					echo json_encode(['error' => 'Gagal menambahkan pengguna.']);
				}
			} catch (Exception $e) {
				echo json_encode(['error' => $e->getMessage()]);
			}
		}
	}

	// Validasi unik untuk email
	public function email_unique($email)
	{
		$this->load->model('Users_model');
		if ($this->Users_model->is_email_exists($email)) {
			$this->form_validation->set_message('email_unique', 'Email sudah digunakan. Gunakan email lain.');
			return FALSE;
		}
		return TRUE;
	}



	public function update($id)
	{
		// Validasi input
		$this->form_validation->set_data($this->input->post());
		$this->form_validation->set_rules('name', 'Nama', 'required', [
			'required' => 'Nama tidak boleh kosong.'
		]);
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email', [
			'required' => 'Email tidak boleh kosong.',
			'valid_email' => 'Format email tidak valid.'
		]);
		$this->form_validation->set_rules('phone', 'Nomor Telepon', 'required', [
			'required' => 'Nomor telepon tidak boleh kosong.'
		]);

		if ($this->form_validation->run() == FALSE) {
			echo json_encode(['error' => $this->form_validation->error_array()]);
		} else {
			$data = array(
				'name' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'phone' => $this->input->post('phone')
			);

			// Proses update data melalui model
			if ($this->Users_model->update_data($id, $data)) {
				echo json_encode([
					'success' => 'Pengguna berhasil diperbarui.',
					'data' => $data // Mengembalikan data yang diperbarui
				]);
			} else {
				echo json_encode(['error' => 'Pengguna tidak ditemukan atau tidak ada perubahan data.']);
			}
		}
	}



	// Validasi unik untuk email, kecuali email milik pengguna sendiri
	public function email_unique_except_self($email, $id)
	{
		$this->load->model('Users_model');
		if ($this->Users_model->is_email_exists_except_self($email, $id)) {
			$this->form_validation->set_message('email_unique_except_self', 'Email sudah digunakan oleh pengguna lain.');
			return FALSE;
		}
		return TRUE;
	}


	public function delete($id)
	{
		// Load model untuk mengakses fungsi delete
		$this->load->model('Users_model');

		// Cek apakah pengguna dengan ID tersebut ada
		if ($this->Users_model->get_user_by_id($id)) {
			if ($this->Users_model->delete_data($id)) {
				echo json_encode(['success' => 'Pengguna berhasil dihapus.']);
			} else {
				echo json_encode(['error' => 'Gagal menghapus pengguna.']);
			}
		} else {
			echo json_encode(['error' => 'Pengguna tidak ditemukan.']);
		}
	}
}
