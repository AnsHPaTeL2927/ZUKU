<?php
defined("BASEPATH") or exit("no direct script allowed");

class Stock extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('menu_model', 'menu');
		if (!isset($_SESSION['id'])) {
			redirect(base_url());
		}
	}

	function index()
	{
		if (!empty($this->session->id) && $this->session->title == TITLE) {
			$this->load->model('admin_company_detail');
			$menu_data = $this->menu->usermain_menu($this->session->usertype_id);
			$data = array(
				'mode' => 'Add',
				'menu_data' => $menu_data,
				'company_detail' => $this->admin_company_detail->s_select(),
			);
			$this->load->view('admin/stock', $data);
		} else {
			redirect(base_url());
		}
	}
}
