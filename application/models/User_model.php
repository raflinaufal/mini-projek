<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    // Ambil semua pengguna
    public function get_all_users() {
        return $this->db->get('users')->result_array();
    }

    // Ambil data pengguna berdasarkan ID
    public function get_user($id) {
        return $this->db->get_where('users', ['id' => $id])->row_array();
    }

    // Ambil pengguna berdasarkan email
    public function get_user_by_email($email) {
        return $this->db->get_where('users', ['email' => $email])->row_array();
    }

    // Insert pengguna
    public function insert_user($data) {
        $this->db->insert('users', $data);
    }

    // Update pengguna
    public function update_user($id, $data) {
        $this->db->update('users', $data, ['id' => $id]);
    }

    // Hapus pengguna
    public function delete_user($id) {
        $this->db->delete('users', ['id' => $id]);
    }
}
