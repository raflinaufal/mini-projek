<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Products extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->library('pagination');
    }

    // Menampilkan daftar produk dengan pagination
public function index() {
     // Ambil nama pengguna dari sesi
    $nama_user = $this->session->userdata('nama_user');     
    // Kirim data ke view
    $data['nama_user'] = $nama_user;
    // Konfigurasi pagination
    $config = [
        'base_url' => site_url('products/index'), // URL untuk pagination
        'total_rows' => $this->Product_model->count_products($this->input->get('search')), // Total data produk
        'per_page' => 5, // Jumlah data per halaman
        'uri_segment' => 3, // Segment ke-3 akan menampilkan nomor halaman
        'attributes' => ['class' => 'page-link'] // Styling untuk pagination
    ];

    // Inisialisasi pagination
    $this->pagination->initialize($config);

    // Ambil data produk berdasarkan parameter pagination dan pencarian
    $data['products'] = $this->Product_model->get_products(
        $config['per_page'],  // Jumlah produk per halaman
        $this->uri->segment(3),  // Segment halaman
        $this->input->get('search'),  // Parameter pencarian
        $this->input->get('sort')  // Parameter pengurutan
    );

    // Ambil link pagination
    $data['pagination'] = $this->pagination->create_links();

    // Tentukan halaman konten untuk dimuat
    $data['content_page'] = 'layout/content/products/index'; // Path ke view products/index

    // Muat view dengan layout utama
    $this->load->view('layout/template/index', $data); // Gunakan layout utama dengan data yang diteruskan
}


    // Menampilkan halaman form untuk membuat produk baru
    public function create() {
        if ($this->input->post()) {
            // Konfigurasi upload gambar
            $config['upload_path'] = './uploads/';
            $config['allowed_types'] = 'jpg|png|jpeg';
            $this->load->library('upload', $config);

            $image = null;
            // Jika upload gambar berhasil
            if ($this->upload->do_upload('image')) {
                $image = $this->upload->data('file_name');
            }

            // Data produk yang akan disimpan
            $data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'image' => $image
            ];

            // Simpan produk ke database
            $this->Product_model->create_product($data);
            redirect('products');
        }

        // Tentukan halaman konten untuk form create
        $data['content_page'] = 'products/create'; // Path ke view
        // Muat view dengan layout utama
        $this->load->view('layout/template', $data); // Gunakan layout utama
    }

    // Menampilkan halaman form untuk mengedit produk
    public function edit($id) {
        $nama_user = $this->session->userdata('nama_user');     
        // Kirim data ke view
        $data['nama_user'] = $nama_user;
        // Ambil data produk berdasarkan ID
        $data['product'] = $this->Product_model->get_product_by_id($id);

        // Jika ada data yang di-submit
        if ($this->input->post()) {
            $data = [
                'name' => $this->input->post('name'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description')
            ];

            // Jika ada gambar baru yang diupload
            if (!empty($_FILES['image']['name'])) {
                $config['upload_path'] = './uploads/';
                $config['allowed_types'] = 'jpg|png|jpeg';
                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $data['image'] = $this->upload->data('file_name');
                }
            }

            // Update produk di database
            $this->Product_model->update_product($id, $data);
            redirect('products');
        }

        // Tentukan halaman konten untuk form edit
        $data['content_page'] = 'layout/content/products/edit'; // Path ke view
        // Muat view dengan layout utama
        $this->load->view('layout/template/index', $data); // Gunakan layout utama
    }

    // Menghapus produk
    public function delete($id) {
        // Hapus produk dari database
        $this->Product_model->delete_product($id);
        redirect('products');
    }
}
