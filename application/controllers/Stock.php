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
			$this->load->model('Admin_pdf', 'pinv');
			$menu_data = $this->menu->usermain_menu($this->session->usertype_id);
			$selected_pi = $this->input->get_post('pi_no') ? trim($this->input->get_post('pi_no')) : '';
			$selected_warehouse = $this->input->get_post('location') ? trim($this->input->get_post('location')) : '';
			$stock_list = $this->pinv->get_stock_list($selected_pi, $selected_warehouse);
			$pi_numbers = $this->pinv->get_stock_pi_numbers();
			$warehouses = $this->pinv->get_warehouses_for_stock_filter();
			$stock_warehouses = $this->pinv->get_warehouses_with_stock();
			$data = array(
				'mode' => 'Add',
				'menu_data' => $menu_data,
				'company_detail' => $this->admin_company_detail->s_select(),
				'stock_list' => $stock_list,
				'pi_numbers' => $pi_numbers,
				'selected_pi' => $selected_pi,
				'selected_warehouse' => $selected_warehouse,
				'warehouses' => $warehouses,
				'stock_warehouses' => $stock_warehouses,
			);
			$this->load->view('admin/stock', $data);
		} else {
			redirect(base_url());
		}
	}
}
