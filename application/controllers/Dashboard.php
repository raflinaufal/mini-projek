<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Dashboard extends CI_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->load->model('Sales_model');
		$this->load->helper('url');
		// $this->load->library('excel'); // Untuk ekspor Excel
		$this->load->library('pdf');  // Untuk ekspor PDF
	}

	public function index()
	{
		$start_date = $this->input->get('start_date');
		$end_date = $this->input->get('end_date');
		$data['sales'] = $this->Sales_model->get_sales($start_date, $end_date);
		$data['start_date'] = $start_date;
		$data['end_date'] = $end_date;

		$this->load->view('dashboard', $data);
	}

	public function export_excel()
	{
		// Ambil data dari model
		$sales = $this->Sales_model->get_sales();

		// Buat Spreadsheet baru
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$sheet->setTitle('Sales Data');

		// Set header
		$sheet->setCellValue('A1', 'ID');
		$sheet->setCellValue('B1', 'Product Name');
		$sheet->setCellValue('C1', 'Amount');
		$sheet->setCellValue('D1', 'Sale Date');

		// Isi data
		$row = 2;
		foreach ($sales as $sale) {
			$sheet->setCellValue('A' . $row, $sale['id']);
			$sheet->setCellValue('B' . $row, $sale['product_name']);
			$sheet->setCellValue('C' . $row, $sale['amount']);
			$sheet->setCellValue('D' . $row, $sale['sale_date']);
			$row++;
		}

		// Simpan file Excel ke output
		$writer = new Xlsx($spreadsheet);
		$filename = 'sales_data.xlsx';

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="' . $filename . '"');
		header('Cache-Control: max-age=0');

		$writer->save('php://output');
	}

	public function export_pdf()
	{
		$this->load->model('Sales_model');
		$sales = $this->Sales_model->get_sales();

		// Load library PDF
		$this->load->library('pdf');

		// Buat HTML untuk PDF
		$html = '<h1>Data Penjualan</h1>';
		$html .= '<table border="1" cellpadding="5" cellspacing="0">';
		$html .= '<thead><tr><th>ID</th><th>Product Name</th><th>Amount</th><th>Sale Date</th></tr></thead><tbody>';
		foreach ($sales as $sale) {
			$html .= '<tr>';
			$html .= '<td>' . $sale['id'] . '</td>';
			$html .= '<td>' . $sale['product_name'] . '</td>';
			$html .= '<td>' . $sale['amount'] . '</td>';
			$html .= '<td>' . $sale['sale_date'] . '</td>';
			$html .= '</tr>';
		}
		$html .= '</tbody></table>';

		// Load konten HTML ke Dompdf
		$this->pdf->loadHtml($html);

		// Atur ukuran kertas dan orientasi
		$this->pdf->setPaper('A4', 'landscape');

		// Render PDF
		$this->pdf->render();

		// Unduh file PDF
		$this->pdf->stream("sales_data.pdf", array("Attachment" => 1));
	}
}
