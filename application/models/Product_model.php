<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product_model extends CI_Model {

public function get_products($limit, $offset, $search = '', $order_by = 'name', $sort = 'asc') {
        if (!empty($search)) {
            $this->db->like('name', $search);
        }
        $this->db->order_by($order_by, $sort); // Tambahkan sorting
        $query = $this->db->get('products', $limit, $offset);
        return $query->result();
    }

    public function count_products($search = '') {
        if (!empty($search)) {
            $this->db->like('name', $search);
        }
        return $this->db->count_all_results('products');
    }

    public function insert_product($data) {
        return $this->db->insert('products', $data);
    }

    public function get_product($id) {
        return $this->db->get_where('products', ['id' => $id])->row();
    }

    public function update_product($id, $data) {
        return $this->db->update('products', $data, ['id' => $id]);
    }

    public function delete_product($id) {
        return $this->db->delete('products', ['id' => $id]);
    }
}

