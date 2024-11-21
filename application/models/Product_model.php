<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

    // Mengambil daftar produk
    public function get_products($limit, $start, $search = null, $sort = null) {
        if ($search) {
            $this->db->like('name', $search);
        }
        
        if ($sort) {
            $this->db->order_by('price', $sort);
        }

        return $this->db->get('products', $limit, $start)->result();
    }

    // Menghitung jumlah produk yang ada
    public function count_products($search = null) {
        if ($search) {
            $this->db->like('name', $search);
        }
        
        return $this->db->count_all_results('products');
    }

    // Menambahkan produk baru
    public function create_product($data) {
        $this->db->insert('products', $data);
    }

    // Mengambil produk berdasarkan ID
    public function get_product_by_id($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    // Mengupdate produk berdasarkan ID
    public function update_product($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('products', $data);
    }

    // Menghapus produk berdasarkan ID
    public function delete_product($id) {
        $this->db->delete('products', ['id' => $id]);
    }
}
