<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Products extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('Product_model');
		$this->load->library(['pagination', 'upload', 'form_validation']);
	}


	public function index()
	{
		$nama_user = $this->session->userdata('nama_user');
		$data['nama_user'] = $nama_user;

		// Ambil parameter sorting dan pencarian dari URL
		$search = $this->input->get('search');
		$order_by = $this->input->get('order_by', TRUE) ?: 'name'; // Default order by 'name'
		$sort = $this->input->get('sort', TRUE) ?: 'asc'; // Default sort ascending

		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

		// Konfigurasi pagination
		$config['base_url'] = base_url('products/index');
		$config['total_rows'] = $this->Product_model->count_products($search);
		$config['per_page'] = 10;
		$config['uri_segment'] = 3;
		$config['reuse_query_string'] = TRUE;

		// Customisasi tampilan pagination
		$config['full_tag_open'] = '<nav><ul class="pagination">';
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
		$config['last_tag_open'] = '<li class="page-item">';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><span class="page-link">';
		$config['cur_tag_close'] = '</span></li>';
		$config['num_tag_open'] = '<li class="page-item">';
		$config['num_tag_close'] = '</li>';

		$this->pagination->initialize($config);

		// Ambil data produk dari model dengan parameter sorting
		$data['products'] = $this->Product_model->get_products($config['per_page'], $page, $search, $order_by, $sort);
		$data['pagination'] = $this->pagination->create_links();
		// 'nama_user' => $name,
		$name = $this->session->userdata('name');

		// Pass order_by dan sort ke view untuk sorting UI
		$data['nama_user'] = $name;
		$data['order_by'] = $order_by;
		$data['sort'] = $sort;

		$data['content_page'] = 'layout/products/index';
		$this->load->view('layout/template/index', $data); // Gunakan layout utama
	}

	public function add()
	{
		$nama_user = $this->session->userdata('nama_user');
		$data['nama_user'] = $nama_user;

		if ($this->input->post()) {
			// Validasi input form
			$this->form_validation->set_rules('name', 'Product Name', 'required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('price', 'Price', 'required|numeric');
			$this->form_validation->set_rules('description', 'Description', 'required|max_length[255]');

			if ($this->form_validation->run() == FALSE) {
				$data['error'] = validation_errors(); // Simpan pesan error validasi
			} else {
				// Handle image upload
				$upload_data = $this->do_upload();
				if (isset($upload_data['error'])) {
					$data['error'] = $upload_data['error']; // Simpan pesan error upload
				} else {
					// Simpan data ke database jika validasi dan upload berhasil
					$product_data = [
						'name' => $this->input->post('name'),
						'price' => $this->input->post('price'),
						'description' => $this->input->post('description'),
						'image' => $upload_data['file_name']
					];

					$this->Product_model->insert_product($product_data);
					$this->session->set_flashdata('success', 'Product added successfully!');
					redirect('products');
				}
			}
		}

		$data['content_page'] = 'layout/products/create'; // Path ke view
		$this->load->view('layout/template/index', $data); // Gunakan layout utama
	}

	public function edit($id)
	{
		$nama_user = $this->session->userdata('nama_user');
		$data['nama_user'] = $nama_user;
		$product = $this->Product_model->get_product($id);

		if ($this->input->post()) {
			// Validasi input form
			$this->form_validation->set_rules('name', 'Product Name', 'required|min_length[3]|max_length[50]');
			$this->form_validation->set_rules('price', 'Price', 'required|numeric');
			$this->form_validation->set_rules('description', 'Description', 'required|max_length[255]');

			if ($this->form_validation->run() == FALSE) {
				$data['error'] = validation_errors(); // Simpan pesan error validasi
			} else {
				$product_data = [
					'name' => $this->input->post('name'),
					'price' => $this->input->post('price'),
					'description' => $this->input->post('description')
				];

				// Handle image upload if there is a new image
				if ($_FILES['image']['name']) {
					$upload_data = $this->do_upload();
					if (isset($upload_data['error'])) {
						$data['error'] = $upload_data['error']; // Simpan pesan error upload
					} else {
						$product_data['image'] = $upload_data['file_name'];
					}
				}

				$this->Product_model->update_product($id, $product_data);
				$this->session->set_flashdata('success', 'Product updated successfully!');
				redirect('products');
			}
		}

		$data['product'] = $product;
		$data['content_page'] = 'layout/products/edit'; // Path ke view
		$this->load->view('layout/template/index', $data); // Gunakan layout utama
	}

	private function do_upload()
	{
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
