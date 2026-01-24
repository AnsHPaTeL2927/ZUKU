<?php
defined("BASEPATH") or exit("no dericet script allowed");
class Purchaseorder_listing extends CI_controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation', 'session', 'encrypt'));
		$this->load->model('admin_purchaseorder_list', 'po');
		$this->load->model('admin_product_invoice', 'pinv');
		$this->load->model('menu_model', 'menu');
		// if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
		// redirect(base_url());
		// }
	}

	public function index($m = "")
	{
		if (!empty($this->session->id)  && $this->session->title == TITLE) {
			$data['erd'] = $m;
			$this->load->model('admin_company_detail');
			$data['company_detail'] = $this->admin_company_detail->s_select();
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);

			$this->load->view('admin/purchaseorder_listing', $data);
		} else {
			redirect(base_url() . '');
		}
	}
	public function deleterecord()
	{
		$id = $this->input->post('purchase_order_id');


		$updateperformainvoice = $this->po->update_performa($this->input->post('production_mst_id'));
		$deleterecord = $this->po->delete_purchase($id);
		$deleterecord = $this->po->delete_purchasetrn($id);

		if ($deleterecord) {
			$row['res'] = '1';
		} else {
			$row['res'] = '0';
		}
		echo json_encode($row);
	}
	public function fetch_record()
	{

		$invoice_status = $this->input->get('invoice_status');
		$invoicedate = explode(" - ", $this->input->get('date'));
		$where = ' and purchase_order_date BETWEEN "' . date('Y-m-d', strtotime($invoicedate[0])) . '" and "' . date('Y-m-d', strtotime($invoicedate[1])) . '"';
		if ($invoice_status == 1) {
			$where = ' and step=2';
		} else if ($invoice_status == 2) {
			$where = ' and step=1';
		}
		$_SESSION['pur_s_date'] = $invoicedate[0];
		$_SESSION['pur_e_date'] = $invoicedate[1];

		$this->load->model('Pagging_model'); //call module 
		$aColumns = array('purchase_order_id', 'purchase_order_no', 'seller_ref_no', 'supplier.supplier_name', 'supplier.company_name', 'purchase_order_date', 'mst.grand_total', 'mst.status', 'mst.cdate', 'mst.step', 'mst.production_mst_id');
		$isWhere = array("mst.status = 0" . $where);
		$table = "tbl_purchase_order as mst";
		$isJOIN = array('left join  tbl_supplier supplier on supplier.supplier_id=mst.seller_id');
		$hOrder = "mst.purchase_order_id desc";
		$sqlReturn = $this->Pagging_model->get_datatables($aColumns, $table, $hOrder, $isJOIN, $isWhere, $this->input->get());
		$appData = array();
		$no = ($this->input->get('iDisplayStart') + 1);

		foreach ($sqlReturn['data'] as $row) {
			$row_data = array();
			$step_status = '';
			$viewinvoice = '';
			$viewinvoice1 = '';
			$pallet_order = '';
			if ($row->step == 2) {

				$viewinvoice = '<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View" href="' . base_url('purchaseorderview/index/' . $row->purchase_order_id) . '" ><i class="fa fa-file-text-o"></i> View PO</a>
								<a class="tooltips" data-toggle="tooltip" data-title="View" href="' . base_url('purchaseorderview1/index/' . $row->purchase_order_id) . '" ><i class="fa fa-file-text-o"></i> View PO(Option 2)</a>
								<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="' . base_url('purchaseorderview1/other_product/' . $row->purchase_order_id) . '" ><i class="fa fa-file-text-o"></i> View PO(Other Product)</a>
								 <a class="tooltips" data-toggle="tooltip" data-title="View in Pdf" href="' . base_url('purchaseorderview/purchase_pdf/' . $row->purchase_order_id) . '" target="_blank" ><i class="fa fa-file-pdf-o"></i> View PO Pdf</a>
							   </li>' . $pallet_order;
				$viewinvoice1 = '<li>
								<a class="tooltips" data-toggle="tooltip" data-title="View" href="' . base_url('purchaseorderview/index/' . $row->purchase_order_id) . '" ><i class="fa fa-file-text-o"></i> View PO</a>
								<a class="tooltips" data-toggle="tooltip" data-title="View" href="' . base_url('purchaseorderview1/index/' . $row->purchase_order_id) . '" ><i class="fa fa-file-text-o"></i> View PO(Option 2)</a>
								<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="' . base_url('purchaseorderview1/other_product/' . $row->purchase_order_id) . '" ><i class="fa fa-file-text-o"></i> View PO(Other Product)</a>
								 <a class="tooltips" data-toggle="tooltip" data-title="View in Pdf" href="' . base_url('purchaseorderview/purchase_pdf/' . $row->purchase_order_id) . '" target="_blank" ><i class="fa fa-file-pdf-o"></i> View PO Pdf</a>
							   </li>';
			}

			if ($row->step == 1) {
				$step_status = '<a class="btn btn-warning tooltips" data-toggle="tooltip" data-title="Add Product Pending" href="' . base_url() . 'poproduct/index/' . $row->purchase_order_id . '"><i class="glyphicon glyphicon-stop"></i></a>';
			} else if ($row->step == 2) {
				$step_status = '<a class="btn btn-success tooltips" data-toggle="tooltip" data-title="Purchase Order Done" href="javascript:;"><i class="fa fa-check-square-o"></i></a>';
			}

			$row_data[] = $step_status;
			$row_data[] = $row->seller_ref_no;

			if ($row->step != 1) {
				$row_data[] = '<div class="dropdown">
								<a class="tooltips" data-toggle="dropdown">' . $row->purchase_order_no . '
								<span class="caret"></span></button>
								<ul class="dropdown-menu">
								 	 ' . $viewinvoice1 . '
						 	</div>';
			} else {
				$row_data[] = $row->purchase_order_no;
			}
			$row_data[] = date('d/m/Y', strtotime($row->purchase_order_date));
			$row_data[] = $row->company_name . ' - ' . $row->supplier_name;

			$row_data[] =  "&#x20b9; " . indian_number($row->grand_total);

			$edit = '
			<li>
				<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="' . base_url() . 'createpo/edit/' . $row->purchase_order_id . '"><i class="fa fa-pencil"></i>Edit</a>
				
			</li>';
			$delete = ' <li><a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record(' . $row->purchase_order_id . ',&quot;' . $row->production_mst_id . '&quot;)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
			</li>';
			if ($row->export_status == 1) {
				$edit = '';
				$delete = '';
			}
			$row_data[] = '<div class="dropdown">
								<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
								<span class="caret"></span></button>
								<ul class="dropdown-menu">
									 ' . $edit . '
									 ' . $viewinvoice . '
									 ' . $delete . '
							</div>';
			$appData[] = $row_data;
		}
		$totalrecord = $this->Pagging_model->count_all($aColumns, $table, $hOrder, $isJOIN, $isWhere, '');
		$numrecord = $sqlReturn['data'];
		$output = array(
			"sEcho" => intval($this->input->get('sEcho')),
			"iTotalRecords" =>  $numrecord,
			"iTotalDisplayRecords" => $totalrecord,
			"aaData" => $appData
		);
		echo json_encode($output);
	}

	public function create_purchase_order()
	{
		if (!empty($this->session->id) && $this->session->title == TITLE) {
			$this->load->model('admin_company_detail');
			$this->load->model('admin_po', 'po_master');
			$suppliers = $this->po_master->select_supplier();
			$pallet_type = $this->pinv->get_pallet_type();
			$box_design = $this->pinv->get_box_design();
			$allsizeproduct = $this->pinv->allsizeproduct();
			$menu_data = $this->menu->usermain_menu($this->session->usertype_id);
			$data = array(
				'menu_data' => $menu_data,
				'company_detail' => $this->admin_company_detail->s_select(),
				'suppliers' => $suppliers,
				'pallet_type' => $pallet_type,
				'box_design' => $box_design,
				'allsizeproduct' => $allsizeproduct,
			);
			$this->load->view('admin/add_purchaseorder_listing', $data);
		} else {
			redirect(base_url() . '');
		}
	}

	/**
	 * AJAX: Load packing details, designs for a product size. Design, finish, pallet, box from DB.
	 */
	public function load_packing_po()
	{
		$product_size_id = (int) $this->input->post('product_size_id');
		if (!$product_size_id) {
			echo json_encode(array('ok' => 0, 'msg' => 'Invalid product size'));
			return;
		}
		$data = $this->pinv->fetch_packing_detail($product_size_id);
		if (!$data) {
			echo json_encode(array('ok' => 0, 'msg' => 'Packing not found'));
			return;
		}
		$prod = $this->pinv->hsncproductsizedetail($data->product_id, 2, 0);
		$desc = isset($prod[0]) ? $prod[0]->size_type_mm . ' (' . $prod[0]->series_name . ')' : $data->product_id;
		$designs = $this->pinv->fetchdesign_detail($data->product_id);
		$design_html = '<option value="">Select Design</option>';
		foreach ($designs as $d) {
			$design_html .= '<option value="' . (int) $d->packing_model_id . '">' . htmlspecialchars($d->model_name) . '</option>';
		}
		$out = array(
			'ok' => 1,
			'product_id' => (int) $data->product_id,
			'description' => $desc,
			'design_html' => $design_html,
			'weight_per_box' => isset($data->weight_per_box) ? $data->weight_per_box : 0,
			'sqm_per_box' => isset($data->sqm_per_box) ? $data->sqm_per_box : 0,
			'boxes_per_pallet' => isset($data->boxes_per_pallet) ? $data->boxes_per_pallet : 0,
			'pallet_weight' => isset($data->pallet_weight) ? $data->pallet_weight : 0,
		);
		echo json_encode($out);
	}

	/**
	 * AJAX: Load finish options for a design. From DB (tbl_finish).
	 */
	public function load_finish_po()
	{
		$design_id = (int) $this->input->post('id');
		if (!$design_id) {
			echo json_encode(array('html' => '<option value="">Select Finish</option>'));
			return;
		}
		$rows = $this->pinv->fetchfinish_detail($design_id);
		$html = '<option value="">Select Finish</option>';
		foreach ($rows as $r) {
			$html .= '<option value="' . (int) $r->finish_id . '">' . htmlspecialchars($r->finish_name) . '</option>';
		}
		echo json_encode(array('html' => $html));
	}

	/**
	 * AJAX: Add product row HTML with design, finish, pallet type, box design from DB.
	 */
	public function add_design_row_po()
	{
		$product_id = (int) $this->input->post('product_id');
		$row_no = (int) $this->input->post('row_no');
		if (!$row_no) $row_no = 1;
		$designs = $this->pinv->fetchdesign_detail($product_id);
		$pallet_type = $this->pinv->get_pallet_type();
		$box_design = $this->pinv->get_box_design();
		$design_opts = '<option value="">Select Design</option>';
		foreach ($designs as $d) {
			$design_opts .= '<option value="' . (int) $d->packing_model_id . '">' . htmlspecialchars($d->model_name) . '</option>';
		}
		$pallet_opts = '<option value="">Select Pallet Type</option>';
		foreach ($pallet_type as $p) {
			$pallet_opts .= '<option value="' . (int) $p->pallet_type_id . '">' . htmlspecialchars($p->pallet_type_name) . '</option>';
		}
		$box_opts = '<option value="">Select Box Design</option>';
		foreach ($box_design as $b) {
			$box_opts .= '<option value="' . (int) $b->box_design_id . '">' . htmlspecialchars($b->box_design_name) . '</option>';
		}
		$html = '<tr class="product-row" data-row="' . $row_no . '">' .
			'<td><select name="design_id[]" class="form-control design-select" data-row="' . $row_no . '">' . $design_opts . '</select></td>' .
			'<td><select name="finish_id[]" class="form-control finish-select" data-row="' . $row_no . '"><option value="">Select Finish</option></select></td>' .
			'<td><input type="text" name="client_name[]" class="form-control" placeholder="Client Design Name"></td>' .
			'<td><input type="number" name="no_of_pallet[]" value="0" class="form-control pallet-qty-input" min="0"></td>' .
			'<td><select name="pallet_type_id[]" class="form-control">' . $pallet_opts . '</select></td>' .
			'<td><input type="number" name="no_of_boxes[]" value="0" class="form-control boxes-input" min="0"></td>' .
			'<td><select name="box_design_id[]" class="form-control">' . $box_opts . '</select></td>' .
			'<td><input type="number" name="no_of_sqm[]" value="0" step="0.01" class="form-control sqm-input" min="0" readonly></td>' .
			'<td><button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i> Remove</button></td>' .
			'</tr>';
		echo json_encode(array('html' => $html, 'row_no' => $row_no));
	}

	/**
	 * Save standalone purchase order. Design, finish, pallet type, box design from form (DB-driven dropdowns).
	 */
	public function save_purchase_order()
	{
		$po_number = trim($this->input->post('po_number'));
		$po_date = trim($this->input->post('po_date'));
		$seller_id = (int) $this->input->post('seller_id');
		$seller_ref_no = trim($this->input->post('seller_ref_no'));
		
		// Basic validation
		if (empty($po_number) || empty($po_date)) {
			echo json_encode(array('res' => '0', 'msg' => 'PO Number and Date are required.'));
			return;
		}
		
		$design_ids = $this->input->post('design_id');
		$product_id = (int) $this->input->post('product_id');
		$product_size_id = (int) $this->input->post('product_size_id');
		$description_goods = trim($this->input->post('description_goods'));
		
		if (empty($design_ids) || !is_array($design_ids)) {
			echo json_encode(array('res' => '0', 'msg' => 'Add at least one product row with design.'));
			return;
		}
		
		if (!$product_id || !$product_size_id) {
			echo json_encode(array('res' => '0', 'msg' => 'Invalid product or product size selected.'));
			return;
		}
		
		// Validate product rows
		$finish_ids = $this->input->post('finish_id');
		$no_of_boxes = $this->input->post('no_of_boxes');
		$no_of_sqm = $this->input->post('no_of_sqm');
		$no_of_pallet = $this->input->post('no_of_pallet');
		$valid_rows = 0;
		foreach ($design_ids as $i => $design_id) {
			if (empty($design_id)) continue;
			$finish_id = isset($finish_ids[$i]) ? (int) $finish_ids[$i] : 0;
			$boxes = isset($no_of_boxes[$i]) ? (float) $no_of_boxes[$i] : 0;
			$sqm = isset($no_of_sqm[$i]) ? (float) $no_of_sqm[$i] : 0;
			$pallets = isset($no_of_pallet[$i]) ? (int) $no_of_pallet[$i] : 0;
			
			if ($finish_id <= 0) {
				echo json_encode(array('res' => '0', 'msg' => 'Finish is required for all product rows.'));
				return;
			}
			if ($boxes <= 0) {
				echo json_encode(array('res' => '0', 'msg' => 'Number of boxes must be greater than 0 for all product rows.'));
				return;
			}
			if ($sqm <= 0) {
				echo json_encode(array('res' => '0', 'msg' => 'SQM must be greater than 0 for all product rows.'));
				return;
			}
			$valid_rows++;
		}
		
		if ($valid_rows == 0) {
			echo json_encode(array('res' => '0', 'msg' => 'Add at least one valid product row with design, finish, boxes, and SQM.'));
			return;
		}
		
		// Check for duplicate PO number
		$this->load->model('admin_po', 'po_master');
		$existing = $this->db->select('purchase_order_id')
			->from('tbl_purchase_order')
			->where('purchase_order_no', $po_number)
			->where('status', 0)
			->get()
			->row();
		if ($existing) {
			echo json_encode(array('res' => '0', 'msg' => 'PO Number already exists. Please use a different PO number.'));
			return;
		}
		
		// Date validation
		$po_date_obj = date_create_from_format('d-m-Y', $po_date);
		if (!$po_date_obj) {
			echo json_encode(array('res' => '0', 'msg' => 'Invalid date format. Please use DD-MM-YYYY format.'));
			return;
		}
		$po_date_sql = $po_date_obj->format('Y-m-d');
		
		// Start database transaction
		$this->db->trans_start();
		
		$po_data = array(
			'purchase_order_no' => $po_number,
			'purchase_order_date' => $po_date_sql,
			'seller_id' => $seller_id ?: 0,
			'seller_ref_no' => $seller_ref_no ?: $po_number,
			'production_mst_id' => 0,
			'performa_invoice_id' => 0,
			'container_details' => '',
			'step' => 1,
			'status' => 0,
			'grand_total' => 0,
			'cdate' => date('Y-m-d H:i:s'),
		);
		$po_id = $this->po_master->insertpo($po_data);
		if (!$po_id) {
			$this->db->trans_rollback();
			echo json_encode(array('res' => '0', 'msg' => 'Failed to create PO.'));
			return;
		}
		
		$this->load->model('admin_purchase_order_product', 'po_product');
		$grand_total = 0;
		$client_names = $this->input->post('client_name');
		$pallet_type_ids = $this->input->post('pallet_type_id');
		$box_design_ids = $this->input->post('box_design_id');
		$wb_global = (float) $this->input->post('weight_per_box');
		$sb_global = (float) $this->input->post('sqm_per_box');
		
		$errors = array();
		for ($i = 0; $i < count($design_ids); $i++) {
			if (empty($design_ids[$i])) continue;
			
			$boxes = isset($no_of_boxes[$i]) ? (float) $no_of_boxes[$i] : 0;
			$sqm = isset($no_of_sqm[$i]) ? (float) $no_of_sqm[$i] : 0;
			$finish_id = isset($finish_ids[$i]) ? (int) $finish_ids[$i] : 0;
			$design_id = (int) $design_ids[$i];
			
			// Validate values are positive
			if ($boxes <= 0 || $sqm <= 0 || $finish_id <= 0) {
				continue; // Skip invalid rows (already validated above)
			}
			
			$rate_row = $this->po_product->get_design_rate_from_tbl_design_rate($product_id, $finish_id);
			$rate = $rate_row && isset($rate_row->design_rate) ? (float) $rate_row->design_rate : 0;
			$per = ($rate_row && !empty($rate_row->product_rate_per)) ? $rate_row->product_rate_per : 'SQM';
			$amt = (float) $rate * (float) $sqm;
			$grand_total += $amt;
			$wb = $wb_global;
			$sb = $sb_global;
			$pallets = isset($no_of_pallet[$i]) ? max(0, (int) $no_of_pallet[$i]) : 0;
			
			$trn = array(
				'purchase_order_id' => $po_id,
				'performa_trn_id' => 0,
				'product_id' => $product_id,
				'product_size_id' => $product_size_id,
				'product_container' => 0,
				'description_goods' => $description_goods ?: '',
				'pallet_status' => 1,
				'weight_per_box' => $wb,
				'pallet_weight' => 0,
				'big_pallet_weight' => 0,
				'small_pallet_weight' => 0,
				'boxes_per_pallet' => 0,
				'box_per_big_pallet' => 0,
				'box_per_small_pallet' => 0,
				'feet_per_box' => 0,
				'sqm_per_box' => $sb,
				'pcs_per_box' => 0,
				'total_no_of_pallet' => $pallets,
				'total_no_of_boxes' => $boxes,
				'total_no_of_sqm' => $sqm,
				'total_product_amt' => $amt,
				'total_pallet_weight' => 0,
				'total_net_weight' => $boxes * $wb,
				'total_gross_weight' => $boxes * $wb,
				'container_half' => 0,
				'rowspan_no' => 0,
				'container_order_by' => 0,
				'extra_product' => 0,
				'cdate' => date('Y-m-d H:i:s'),
			);
			$trn_id = $this->po_product->insert_productrecord($trn);
			if (!$trn_id) {
				$errors[] = 'Failed to insert product record for row ' . ($i + 1);
				continue;
			}
			
			$pack = array(
				'purchaseordertrn_id' => $trn_id,
				'purchase_order_id' => $po_id,
				'design_id' => $design_id,
				'finish_id' => $finish_id,
				'client_name' => isset($client_names[$i]) ? trim($client_names[$i]) : '',
				'no_of_pallet' => $pallets,
				'no_of_big_pallet' => 0,
				'no_of_small_pallet' => 0,
				'no_of_boxes' => $boxes,
				'no_of_sqm' => $sqm,
				'product_amt' => $amt,
				'product_rate' => $rate,
				'per' => $per,
				'packing_net_weight' => $boxes * $wb,
				'packing_gross_weight' => $boxes * $wb,
			);
			if (isset($pallet_type_ids[$i]) && $pallet_type_ids[$i] !== '') {
				$pack['pallet_type_id'] = (int) $pallet_type_ids[$i];
			}
			if (isset($box_design_ids[$i]) && $box_design_ids[$i] !== '') {
				$pack['box_design_id'] = (int) $box_design_ids[$i];
			}
			$pack_id = $this->po_product->insert_packing_data($pack);
			if (!$pack_id) {
				$errors[] = 'Failed to insert packing data for row ' . ($i + 1);
			}
		}
		
		if (!empty($errors)) {
			$this->db->trans_rollback();
			echo json_encode(array('res' => '0', 'msg' => 'Error saving product data: ' . implode(', ', $errors)));
			return;
		}
		
		// Update grand total
		$this->db->where('purchase_order_id', $po_id);
		$this->db->update('tbl_purchase_order', array('grand_total' => $grand_total));
		
		// Complete transaction
		$this->db->trans_complete();
		
		if ($this->db->trans_status() === FALSE) {
			echo json_encode(array('res' => '0', 'msg' => 'Transaction failed. Please try again.'));
			return;
		}
		
		echo json_encode(array('res' => '1', 'msg' => 'Purchase order saved successfully.', 'purchase_order_id' => $po_id));
	}

	/**
	 * View PO page (final PO). Print only.
	 * Uses get_po_view_data + get_standalone_po_trns + packing (design, finish from tbl_finish).
	 */
	public function view_po($id)
	{
		if (empty($this->session->id) || $this->session->title != TITLE) {
			redirect(base_url() . '');
			return;
		}
		$data = $this->po->get_po_view_data($id);
		if (!$data) {
			show_404();
			return;
		}
		$trns = $this->po->get_standalone_po_trns($id);
		$this->load->model('Admin_purchaseorderpdf', 'po_pdf');
		$product_data = array();
		foreach ($trns as $t) {
			$t->packing = $this->po_pdf->getpurchaseproductrate($t->purchaseordertrn_id);
			$product_data[$t->purchaseordertrn_id] = $t;
		}
		$this->load->model('admin_company_detail');
		$v = array(
			'invoicedata' => $data,
			'product_data' => $product_data,
			'company_detail' => $this->admin_company_detail->s_select(),
			'menu_data' => $this->menu->usermain_menu($this->session->usertype_id),
		);
		$this->load->view('admin/view_purchaseorder_listing', $v);
	}
}
