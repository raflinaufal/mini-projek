<?php
defined('BASEPATH') or exit('No direct script access allowed');

function is_logged_in()
{
	$CI = &get_instance(); // Dapatkan instance CodeIgniter
	if (!$CI->session->userdata('user_id')) {
		// Jika tidak ada session user_id, redirect ke halaman login
		redirect('auth');
	}
}

function is_admin()
{
	$CI = &get_instance(); // Dapatkan instance CodeIgniter
	$role = $CI->session->userdata('role');
	return $role === 'admin';
}


