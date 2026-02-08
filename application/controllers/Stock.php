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

	/**
	 * AJAX: Transfer stock from one warehouse to another.
	 */
	function transfer_stock()
	{
		$result = array('res' => 0, 'msg' => '');
		if (empty($this->session->id)) {
			$result['msg'] = 'Unauthorized';
			echo json_encode($result);
			return;
		}
		$performa_invoice_id = (int) $this->input->post('performa_invoice_id');
		$design_id = (int) $this->input->post('design_id');
		$from_warehouse_id = (int) $this->input->post('from_warehouse_id');
		$to_warehouse_id = (int) $this->input->post('to_warehouse_id');
		$quantity_type = $this->input->post('quantity_type'); // 'boxes' or 'sqm'
		$quantity_value = (float) $this->input->post('quantity_value');
		$sqm_per_box = (float) $this->input->post('sqm_per_box');
		if ($performa_invoice_id <= 0 || $design_id <= 0) {
			$result['msg'] = 'Invalid stock item.';
			echo json_encode($result);
			return;
		}
		if ($from_warehouse_id <= 0 || $to_warehouse_id <= 0) {
			$result['msg'] = 'Please select both current and transfer warehouse.';
			echo json_encode($result);
			return;
		}
		if ($quantity_value <= 0) {
			$result['msg'] = 'Please enter transfer quantity.';
			echo json_encode($result);
			return;
		}
		$transfer_boxes = $quantity_value;
		if ($quantity_type === 'sqm') {
			if ($sqm_per_box <= 0) {
				$result['msg'] = 'Cannot convert SQM to boxes: per box sqm is missing or zero.';
				echo json_encode($result);
				return;
			}
			$transfer_boxes = $quantity_value / $sqm_per_box;
		}
		$this->load->model('Admin_pdf', 'pinv');
		$transfer_result = $this->pinv->transfer_warehouse_stock($performa_invoice_id, $design_id, $from_warehouse_id, $to_warehouse_id, $transfer_boxes);
		if ($transfer_result['success']) {
			$result['res'] = 1;
			$result['msg'] = $transfer_result['msg'];
		} else {
			$result['msg'] = $transfer_result['msg'];
		}
		echo json_encode($result);
	}

	/**
	 * AJAX: Save total sales last 6 months override.
	 */
	function save_sales_6m()
	{
		$result = array('res' => 0, 'msg' => '');
		if (empty($this->session->id)) {
			$result['msg'] = 'Unauthorized';
			echo json_encode($result);
			return;
		}
		$performa_invoice_id = (int) $this->input->post('performa_invoice_id');
		$design_id = (int) $this->input->post('design_id');
		$total_sales_6m_sqm = (float) $this->input->post('total_sales_6m_sqm');
		if ($performa_invoice_id <= 0 || $design_id <= 0) {
			$result['msg'] = 'Invalid stock item.';
			echo json_encode($result);
			return;
		}
		$this->load->model('Admin_pdf', 'pinv');
		$ok = $this->pinv->save_stock_sales_override($performa_invoice_id, $design_id, $total_sales_6m_sqm);
		if ($ok) {
			$result['res'] = 1;
			$result['msg'] = 'Saved.';
		} else {
			$result['msg'] = 'Failed to save. Run migration for tbl_stock_calculation if needed.';
		}
		echo json_encode($result);
	}

	/**
	 * AJAX: Save safety stock [days] override.
	 */
	function save_safety_stock()
	{
		$result = array('res' => 0, 'msg' => '');
		if (empty($this->session->id)) {
			$result['msg'] = 'Unauthorized';
			echo json_encode($result);
			return;
		}
		$performa_invoice_id = (int) $this->input->post('performa_invoice_id');
		$design_id = (int) $this->input->post('design_id');
		$safety_stock_days = (int) $this->input->post('safety_stock_days');
		if ($performa_invoice_id <= 0 || $design_id <= 0) {
			$result['msg'] = 'Invalid stock item.';
			echo json_encode($result);
			return;
		}
		if ($safety_stock_days < 0) {
			$safety_stock_days = 0;
		}
		$this->load->model('Admin_pdf', 'pinv');
		$ok = $this->pinv->save_stock_safety_stock_days($performa_invoice_id, $design_id, $safety_stock_days);
		if ($ok) {
			$result['res'] = 1;
			$result['msg'] = 'Saved.';
		} else {
			$result['msg'] = 'Failed to save. Run migration for tbl_stock_calculation if needed.';
		}
		echo json_encode($result);
	}
}
