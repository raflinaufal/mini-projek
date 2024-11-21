<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('User_model');
        if (!$this->session->userdata('user_id')) {
            redirect('auth');
        }
    }

    // Halaman Dashboard
    public function dashboard() {
        $data['users'] = $this->User_model->get_all_users();
        $this->load->view('dashboard', $data);
    }

    // Halaman Form Pengguna (Tambah/Edit)
    public function form($id = NULL) {
        if ($id) {
            $data['user'] = $this->User_model->get_user($id);
        } else {
            $data['user'] = NULL;
        }
        $this->load->view('user_form', $data);
    }

    // Proses tambah/edit pengguna
    public function save($id = NULL) {
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
    public function delete($id) {
        $this->User_model->delete_user($id);
        redirect('user/dashboard');
    }
}
