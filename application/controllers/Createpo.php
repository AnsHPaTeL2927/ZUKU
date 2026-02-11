<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Createpo extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
	 	$this->load->model('admin_po','po');
		$this->load->model('menu_model','menu');
		$this->load->library('Pdf_service');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		 
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$array 	= explode("-",$id);
			$exporter			=	$this->po->select_exporter();
			$supplier			=	$this->po->select_supplier();
			$selectinvoicetype 	= 	$this->po->selectinvoicetype(3);
			$this->load->model('admin_company_detail');	
			$company 			= 	$this->admin_company_detail->s_select();
			$this->load->model('admin_country_detail');	
			$data				= 	$this->po->select_invoice_data($id,$array);
			$consign_other		=	$this->po->other_consigner($data->consigne_id);
				$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
		
			$this->load->model('admin_currency_list');	
			$v = array( 
					'supplier_detail'	=> $supplier,
					'exporter_detail'	=> $exporter,
					'mode'				=> 'Add',
					'mutiple_status'	=> 1,
					'menu_data'			=>	$menu_data,
					'invoicetype'		=> $selectinvoicetype,
					'company_detail'	=> $company,
					'countrydata'		=> $this->admin_country_detail->s_select(),
					'invoicedata'		=> $data,
					'product_data'		=> $datap,
					"consignother"		=> $consign_other,
					"currencydata"		=> $this->admin_currency_list->getcurrencydata()
				);
			$this->load->view('admin/createpo',$v);
		}
		else
		{
			$this->load->view('admin/index');
		}	
	}
	function mutiple($id)
	{
		 
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$array 				= explode("-",$id);
			$lastid 			= end($array);
			$exporter			=	$this->po->select_exporter();
			$supplier			=	$this->po->select_supplier();
			$selectinvoicetype 	= 	$this->po->selectinvoicetype(3);
			$this->load->model('admin_company_detail');	
			$company 			= 	$this->admin_company_detail->s_select();
			$this->load->model('admin_country_detail');	
			$data				= 	$this->po->select_invoice_data($lastid,$array);
			$consign_other		=	$this->po->other_consigner($data->consigne_id);
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
		
			$this->load->model('admin_currency_list');	
			$v = array( 
					'supplier_detail'	=> $supplier,
					'exporter_detail'	=> $exporter,
					'mutiple_status'	=> 2,
					'mode'				=> 'Add',
					'menu_data'			=>$menu_data,
					'invoicetype'		=> $selectinvoicetype,
					'company_detail'	=> $company,
					'countrydata'		=> $this->admin_country_detail->s_select(),
					'invoicedata'		=> $data,
					'product_data'		=> $datap,
					"consignother"		=> $consign_other,
					"currencydata"		=> $this->admin_currency_list->getcurrencydata()
				);
			$this->load->view('admin/createpo',$v);
		}
		else
		{
			$this->load->view('admin/index');
		}	
	}
	function manage()
	{
		
		$data = array(
			'performa_invoice_id' 	=> ($this->input->post('performa_invoice_id')),
			'production_mst_id' 	=> ($this->input->post('production_mst_id')),
			'exporter_detail'	 	=> nl2br($this->input->post('exporter_detail')),
			'purchase_order_no' 	=> $this->input->post('purchase_order_no'),
			'purchase_order_date' 	=> date('Y-m-d',strtotime($this->input->post('purchase_order_date'))),
			'seller_ref_no' 		=> $this->input->post('seller_ref_no'),
			'port_of_loading' 		=> $this->input->post('port_of_loading'),
			'final_destination' 		=> $this->input->post('final_destination'),
			'exporter_pan' 			=> $this->input->post('exporter_pan'),
			'port_of_discharge' 	=> $this->input->post('port_of_discharge'),
			'rcmc_no' 				=> $this->input->post('rcmc_no'),
			'container_details' 	=> ($this->input->post('container_details')),
			'rcmc_expiery' 			=> $this->input->post('rcmc_expiery'),
			'delivery_time' 		=> $this->input->post('delivery_time'),
			'seller_id' 			=> ($this->input->post('seller_id')),
			'supplier_address' 		=> nl2br($this->input->post('supplier_detail')),
			'supplier_panno' 		=> nl2br($this->input->post('supplier_pan_no')),
			'supplier_gstin' 		=> nl2br($this->input->post('supplier_gstinno')),
			'payment_terms' 		=> nl2br($this->input->post('payment_terms')),
			'remarks' 				=> nl2br($this->input->post('remarks')),
			'image_status' 			=> $this->input->post('image_status'),
			'container_forty' 		=> $this->input->post('container_forty'),
			'container_twenty' 		=> $this->input->post('container_twenty'),
			'qc_by' 				=> $this->input->post('qc_by'),
			'tile_thickness' 		=> $this->input->post('tile_thickness'),
			'loading_by' 			=> $this->input->post('loading_by'),
			'pallet_by' 			=> $this->input->post('pallet_by'),
			'mutiple_status'  		=> $this->input->post('mutiple_status'),
			'status' => 0
		 	);
			$row['res'] = 0;
			if(strtolower($this->input->post('mode'))=="add")
			{				
				$data['step']  = 1;
				$data['cdate'] = date('Y-m-d H:i:s');
				 
				$rdata = $this->po->insertpo($data);
			
				if($rdata)
				{	
					$no_of_po = ($this->input->post('no_of_po')+1);
					$updateperformainvoice = $this->po->update_performa($this->input->post('performa_invoice_id'),$no_of_po);
					 
					$update_production_mst_id = explode("-",$this->input->post('production_mst_id'));
					$update_po = $this->po->update_producation_status(implode(",",$update_production_mst_id),1);
					
					$update = $this->po->update_invoicenumber(3,$this->input->post('invoice_series'));
					$row['res'] = 1;
					$row['invoiceid'] = $rdata;
					
					// 1. PO Created - Send email notification to admin (with PDF)
					$this->send_po_created_notification($rdata);
				}
			}
			else if(strtolower($this->input->post('mode'))=="edit")
			{
				$data['mdate'] = date('Y-m-d H:i:s');
				$id = $this->input->post('purchase_order_id');
				$rs = $this->po->po_update($data,$id);
				if($rs)
				{	
					$row['res'] = 3;
					$row['invoiceid'] = $id;
				}
			}
		echo json_encode($row);

	}
	public function edit($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$supplier=$this->po->select_supplier();
			$this->load->model('admin_company_detail');
			$this->load->model('admin_country_detail');			
			$company = $this->admin_company_detail->s_select();
			$data= $this->po->po_data($id);
			$this->load->model('admin_currency_list');	
				$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
		
			$v = array( 
					'supplier_detail'=>$supplier,
					'menu_data'=>$menu_data,
					'mode'=>'Edit',
					'company_detail'=>$company,
					'countrydata'=>$this->admin_country_detail->s_select(),
					'invoicedata'=>$data,
					"currencydata"=>$this->admin_currency_list->getcurrencydata()					
				);
			$this->load->view('admin/createpo',$v);
		}
		else
		{
			$this->load->view('admin/index');
		}	
	}
	public function getsupplier()
	{
		$id=$this->input->post('e_id');
		$fetchdata = $this->po->supplierdetail($id);
		$fetchdata->address 		= strip_tags($fetchdata->address);
		$fetchdata->payment_terms 	= strip_tags($fetchdata->payment_terms);
		echo json_encode($fetchdata);
	}
	
	public function search(){
 
        $term = $this->input->get('term');
 
        $this->db->like('payment_terms', $term);
		$this->db->limit(5);
        $data = $this->db->get("tbl_payment_terms")->result();
 
        echo json_encode($data);
    } 
	
	/**
	 * Send email notification to admin when PO is created
	 * @param int $po_id Purchase Order ID
	 */
	private function send_po_created_notification($po_id)
	{
		try {
			// Get admin email from company detail
			$this->load->model('admin_company_detail');
			$company_detail = $this->admin_company_detail->s_select();
			$admin_email = !empty($company_detail[0]->s_email) ? $company_detail[0]->s_email : '';
			
			if (empty($admin_email)) {
				log_message('warning', 'Admin email not found for PO created notification - PO ID: ' . $po_id);
				return;
			}
			
			// Get PO data
			$this->load->model('Admin_purchaseorderpdf', 'popdf');
			$po_data = $this->popdf->po_data($po_id);
			
			if (!$po_data) {
				return;
			}
			
			// Generate PDF
			$pdf_path = $this->generate_po_pdf($po_id);
			
			// Prepare email
			$purchase_order_no = !empty($po_data->purchase_order_no) ? $po_data->purchase_order_no : 'PO-' . $po_id;
			$subject = 'New Purchase Order Created - ' . $purchase_order_no;
			
			$body = 'Dear Admin,<br><br>';
			$body .= 'A new Purchase Order has been created by the client.<br><br>';
			$body .= '<strong>Purchase Order Details:</strong><br>';
			$body .= 'PO Number: ' . $purchase_order_no . '<br>';
			$body .= 'PO Date: ' . date('d-m-Y', strtotime($po_data->purchase_order_date)) . '<br>';
			$body .= 'Supplier: ' . (!empty($po_data->company_name) ? $po_data->company_name : 'N/A') . '<br><br>';
			$body .= 'Please find the attached PDF for details.<br><br>';
			$body .= 'Thank you.<br><br>';
			$body .= 'Best regards,<br>ZUKU App';
			
			// Send email with PDF attachment
			$email_sent = $this->pdf_service->sendEmail($admin_email, $subject, $body, $pdf_path);
			
			if ($email_sent) {
				log_message('info', 'PO created email sent successfully to admin for PO ID: ' . $po_id);
			} else {
				log_message('error', 'Failed to send PO created email to admin for PO ID: ' . $po_id);
			}
		} catch (Exception $e) {
			log_message('error', 'PO created notification error: ' . $e->getMessage());
		}
	}
	
	/**
	 * Generate PO PDF and return path
	 * @param int $po_id Purchase Order ID
	 * @return string|false PDF path or false on failure
	 */
	private function generate_po_pdf($po_id)
	{
		try {
			$this->load->model('Admin_purchaseorderpdf', 'popdf');
			$this->load->model('admin_company_detail');
			
			$company = $this->popdf->company_select();
			$data = $this->popdf->po_data($po_id);
			
			if (!$data) {
				return false;
			}
			
			// Get country_final_destination from performa invoice if available
			if (!empty($data->performa_invoice_id)) {
				$pi_data = $this->db->select('country_final_destination')
					->from('tbl_performa_invoice')
					->where('performa_invoice_id', $data->performa_invoice_id)
					->get()
					->row();
				if ($pi_data && !empty($pi_data->country_final_destination)) {
					$data->country_final_destination = $pi_data->country_final_destination;
				}
			}
			
			$datap = $this->popdf->getpo_productdata($po_id, $data->production_mst_id);
			
			$view_data = array(
				'invoicedata' => $data,
				'product_data' => $datap,
				'company_detail' => $company,
				'mode' => ''
			);
			
			// Generate HTML using the email PDF template
			$html_content = $this->load->view('admin/po_email_pdf_template', $view_data, true);
			
			$purchase_order_no = !empty($data->purchase_order_no) ? $data->purchase_order_no : 'PO-' . $po_id;
			$filename = preg_replace('/[^a-zA-Z0-9_\-\.]/', '_', $purchase_order_no) . '.pdf';
			
			$this->load->view('mpdf/mpdf.php');
			$mpdf = new mPDF('utf-8', 'A4', '7', 'calibri', 5, 5, 5, 5, 0, 0);
			$mpdf->SetFooter('<div style="text-align:right;">CREATED BY : Zuku Export Software</div>');
			$mpdf->WriteHTML($html_content);
			$mpdf->SetTitle($purchase_order_no);
			
			$upload_path = './adminast/assets/upload/';
			if (!is_dir($upload_path)) {
				mkdir($upload_path, 0755, true);
			}
			
			$file_path = $upload_path . $filename;
			$mpdf->Output($file_path, 'F');
			
			return $file_path;
		} catch (Exception $e) {
			log_message('error', 'PO PDF generation error: ' . $e->getMessage());
			return false;
		}
	}

}
