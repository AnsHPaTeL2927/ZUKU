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
        $this->load->view('admin/add_purchaseorder_listing');
    }
}
