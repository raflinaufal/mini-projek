<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model'); // Load model untuk mengambil data produk
    }

    public function index() {
        // Ambil parameter pencarian dan sorting dari URL
        $search = $this->input->get('search');
        $order_by = $this->input->get('order_by', TRUE) ?: 'name'; // Default sort by 'name'
        $sort = $this->input->get('sort', TRUE) ?: 'asc';         // Default order ascending
        $limit = 10; // Jumlah produk per halaman
        $offset = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        // Ambil data produk dari model
        $data['products'] = $this->Product_model->get_products($limit, $offset, $search, $order_by, $sort);
        
        // Pagination config
        $this->load->library('pagination');
        $config['base_url'] = base_url('home/index');
        $config['total_rows'] = $this->Product_model->count_products($search);
        $config['per_page'] = $limit;
        $config['uri_segment'] = 3;
        $config['reuse_query_string'] = TRUE;

        // Customisasi tampilan pagination
        $config['full_tag_open'] = '<nav><ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul></nav>';
        $config['attributes'] = ['class' => 'page-link'];
        $config['first_link'] = 'First';
        $config['last_link'] = 'Last';
        $config['first_tag_open'] = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['prev_link'] = '&laquo';
        $config['prev_tag_open'] = '<li class="page-item">';
        $config['prev_tag_close'] = '</li>';
        $config['next_link'] = '&raquo';
        $config['next_tag_open'] = '<li class="page-item">';
        $config['next_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
        $config['cur_tag_close'] = '</span></li>';
        $config['num_tag_open'] = '<li class="page-item">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $data['pagination'] = $this->pagination->create_links();

        // Load view
        $this->load->view('layout/home/index', $data);
    }
}
