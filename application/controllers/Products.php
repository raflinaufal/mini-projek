<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library(['pagination', 'upload']); // Load library upload
    }

    public function index() {
        $nama_user = $this->session->userdata('nama_user');
        $data['nama_user'] = $nama_user;

        $search = $this->input->get('search');
        $page = $this->uri->segment(3) ? $this->uri->segment(3) : 0;

        // Pagination Configuration
        $config['base_url'] = base_url('products/index');
        $config['total_rows'] = $this->Product_model->count_products($search);
        $config['per_page'] = 10;
        $this->pagination->initialize($config);

        // Get products
        $data['products'] = $this->Product_model->get_products($config['per_page'], $page, $search);
        $data['pagination'] = $this->pagination->create_links();

        $data['content_page'] = 'layout/products/index'; // Path ke view
        $this->load->view('layout/template/index', $data); // Gunakan layout utama
    }

    public function add() {
        $nama_user = $this->session->userdata('nama_user');
        $data['nama_user'] = $nama_user;

        if ($this->input->post()) {
            // Handle image upload
            $upload_data = $this->do_upload();
            if (isset($upload_data['error'])) {
                $data['error'] = $upload_data['error']; // Tampilkan pesan error ke view
            } else {
                $product_data = [
                    'name' => $this->input->post('name'),
                    'price' => $this->input->post('price'),
                    'description' => $this->input->post('description'),
                    'image' => $upload_data['file_name']
                ];

                $this->Product_model->insert_product($product_data);
                redirect('products');
            }
        }

        $data['content_page'] = 'layout/products/create'; // Path ke view
        $this->load->view('layout/template/index', $data); // Gunakan layout utama
    }

    public function edit($id) {
        $nama_user = $this->session->userdata('nama_user');
        $data['nama_user'] = $nama_user;
        $product = $this->Product_model->get_product($id);

        if ($this->input->post()) {
            $product_data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description')
            ];

            // Handle image upload if there is a new image
            if ($_FILES['image']['name']) {
                $upload_data = $this->do_upload();
                if (isset($upload_data['error'])) {
                    $data['error'] = $upload_data['error']; // Tampilkan pesan error ke view
                } else {
                    $product_data['image'] = $upload_data['file_name'];
                }
            }

            $this->Product_model->update_product($id, $product_data);
            redirect('products');
        }

        $data['product'] = $product;
        $data['content_page'] = 'layout/products/edit'; // Path ke view
        $this->load->view('layout/template/index', $data); // Gunakan layout utama
    }

    public function delete($id) {
        $this->Product_model->delete_product($id);
        redirect('products');
    }

    // Fungsi untuk menangani upload file
    private function do_upload() {
        $config['upload_path']   = './uploads/'; // Path folder upload
        $config['allowed_types'] = 'jpg|jpeg|png|gif'; // Tipe file yang diizinkan
        $config['max_size']      = 2048; // Ukuran maksimum (2MB)
        $config['encrypt_name']  = TRUE; // Enkripsi nama file agar unik

        if (!is_dir($config['upload_path'])) {
            mkdir($config['upload_path'], 0755, true); // Buat folder jika belum ada
        }

        $this->upload->initialize($config);

        if (!$this->upload->do_upload('image')) {
            return ['error' => $this->upload->display_errors('<p>', '</p>')];
        } else {
            return $this->upload->data(); // Return data file jika berhasil upload
        }
    }
}
