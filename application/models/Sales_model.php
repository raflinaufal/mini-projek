<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sales_model extends CI_Model
{
	public function get_sales($start_date = null, $end_date = null)
	{
		if ($start_date && $end_date) {
			$this->db->where('sale_date >=', $start_date);
			$this->db->where('sale_date <=', $end_date);
		}
		return $this->db->get('sales')->result_array();
	}
}
