<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Create_customer_invoice extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		 
		$this->load->model('Customer_invoice_model','custinvoice');
		$this->load->model('menu_model','menu');	
		
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}
	function index($id)
	{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			{
				$array 				= explode("-",$id);
				$exporter			= $this->custinvoice->select_exporter();
				$consign			= $this->custinvoice->select_consigner();
				$selectinvoicetype 	= $this->custinvoice->selectinvoicetype(5);
				$this->load->model('admin_company_detail');	
				$company 			= $this->admin_company_detail->s_select();
				$this->load->model('admin_country_detail');	
				$data				= $this->custinvoice->select_invoice_data($id,$array);
				$consign_other=$this->custinvoice->other_consigner($data->consigne_id);
				$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			  
			$bank= $this->custinvoice->bank_detail($company[0]->bank_name);
			$this->load->model('admin_currency_list');	
			$v = array( 
						'consign_detail'	=> $consign,
						'exporter_detail'	=> $exporter,
						'mode'				=> 'Add',
						'invoicetype'		=> $selectinvoicetype,
						'menu_data'			=> $menu_data,
						'company_detail'	=> $company,
						'countrydata'		=> $this->admin_country_detail->s_select(),
						'invoicedata'		=> $data,
					 	'consignother'		=> $consign_other,
						'bank'				=> $bank,
						'pastinvoicedata'	=> $pastinvoicedata,
						'currencydata'		=> $this->admin_currency_list->getcurrencydata(),
						'termsdata'			=> $this->custinvoice->gettermsdata(),
						'mutiple_status'	=> 1
				);
			$this->load->view('admin/customer_invoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function mutiple($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$array 				= explode("-",$id);
			$lastid 			= end($array);
			$exporter			= $this->custinvoice->select_exporter();
			$consign			= $this->custinvoice->select_consigner();
			$selectinvoicetype 	= $this->custinvoice->selectinvoicetype(5);
			$this->load->model('admin_company_detail');	
			$company 			= $this->admin_company_detail->s_select();
			$this->load->model('admin_country_detail');	
			$data				= $this->custinvoice->select_invoice_data($lastid,$array);
			$consign_other		= $this->custinvoice->other_consigner($data->consigne_id);
			 
			$bank				= $this->custinvoice->bank_detail($company[0]->bank_name);
			$this->load->model('admin_currency_list');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array( 
						'consign_detail'		=> $consign,
						'exporter_detail'		=> $exporter,
						'menu_data'				=> $menu_data,
						'export_invoice_id'	 	=> $id,
						'mode'					=> 'Add',
						'invoicetype'			=> $selectinvoicetype,
						'company_detail'		=> $company,
						'countrydata'			=> $this->admin_country_detail->s_select(),
						'invoicedata'			=> $data,
					 	'consignother'			=> $consign_other,
						'bank'					=> $bank,
						'currencydata'			=> $this->admin_currency_list->getcurrencydata(),
						'termsdata'				=> $this->custinvoice->gettermsdata(),
						'mutiple_status'		=> 2,
						"performa_invoice_id"	=> $id
				);
			$this->load->view('admin/customer_invoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function manage()
	{
	 	$data = array(
			'export_invoice_id' 		=> ($this->input->post('export_invoice_id')),
		 	'exporter_detail' 			=> nl2br($this->input->post('exporter_detail')),
			'customer_invoice_no'		=> $this->input->post('customer_invoice_no'),
			'invoice_date' 				=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
			'export_ref_no' 			=> $this->input->post('export_ref_no'),
			'export_date' 				=> $this->input->post('date'),
			'customer_buy_order_no' 	=> $this->input->post('customer_buy_order_no'),
			'eta_date' 					=> $this->input->post('eta_date'),
			'e_email' 					=> $this->input->post('exporter_email'),
			'e_mobile' 					=> $this->input->post('exporter_mobile'),
			'e_gstin' 					=> $this->input->post('exporter_gstin'),
			'exporter_pan' 				=> nl2br($this->input->post('exporter_pan')),
			'exporter_iec' 				=> $this->input->post('exporter_iec'),
			'consiger_id' 				=> $this->input->post('consiger_id'),
			's_bill_no' 				=> $this->input->post('s_bill_no'),
			's_date' 					=> date('Y-m-d',strtotime($this->input->post('s_date'))),
			'bl_no' 					=> $this->input->post('bl_no'),
			'bl_date' 					=> date('Y-m-d',strtotime($this->input->post('bl_date'))),
			'consign_address' 			=> nl2br($this->input->post('consign_address')),
			'invoice_currency_id' 		=> ($this->input->post('invoice_currency_id')),
			'buyer_other_consign' 		=> nl2br($this->input->post('buyer_other_consign')),
			'pre_carriage_by'			=> $this->input->post('pre_carriage_by'),
			'place_of_receipt' 			=> $this->input->post('place_of_receipt'),
			'country_origin_goods' 		=> $this->input->post('country_origin_goods'),
			'country_final_destination' => $this->input->post('country_final_destination'),
			'bank_detail' 				=> nl2br($this->input->post('bank_detail')),
			'flight_name_no' 			=> $this->input->post('flight_name_no'),
			'port_of_loading' 			=> $this->input->post('port_of_loading'),
			'port_of_discharge' 		=> $this->input->post('port_of_discharge'),
			'final_destination' 		=> $this->input->post('final_destination'),
			'payment_terms'				=> nl2br($this->input->post('payment_terms')),
			'container_details' 		=> $this->input->post('container_details'),
			'container_size' 			=> $this->input->post('container_size'),
			'terms_id' 					=> $this->input->post('terms_id'),
			'terms_of_delivery' 		=> $this->input->post('terms_of_delivery'),
			'certification_charge' 		=> $this->input->post('certification_charge'),
			'insurance_charge' 			=> $this->input->post('insurance_charge'),
			'seafright_charge' 			=> $this->input->post('seafright_charge'),
			'discount' 					=> $this->input->post('discount'),
			'bank_charge' 				=> $this->input->post('bank_charge'),
			'courier_charge' 			=> $this->input->post('courier_charge'),
			'extra_calc_name' 			=> $this->input->post('extra_calc_name'),
			'extra_calc_amt' 		 	=> $this->input->post('extra_calc_amt'),
			'extra_calc_opt' 		 	=> $this->input->post('extra_calc_opt'),
			'grand_total' 				=> $this->input->post('grand_total'),
			'mutiple_status' 			=> $this->input->post('mutiple_status'),
			'container_forty' 			=> $this->input->post('container_forty'),
			'container_twenty' 			=> $this->input->post('container_twenty'),
			'status' => 0,
			);
			$row['res'] = 0;
			if(strtolower($this->input->post('mode'))=="add")
			{				
				$data['step']  = 1;
				$data['cdate'] = date('Y-m-d H:i:s');
				$data['mdate'] = date('Y-m-d H:i:s');
				$rdata = $this->custinvoice->invoice_firststep($data);
			 	if($rdata)
				{	
					$update_export_invoice_id = explode("-",$this->input->post('export_invoice_id'));
					$update_export_invoice = $this->custinvoice->update_cust_status(implode(",",$update_export_invoice_id),1);
					$no_of_export = ($this->input->post('no_of_export')+1);
					  
					$update = $this->custinvoice->update_invoicenumber(5,$this->input->post('invoice_series'));
					$row['res'] = 1;
					$row['invoiceid'] = $rdata;
				}
				
			}
			else if(strtolower($this->input->post('mode'))=="edit")
			{
				$data['mdate'] = date('Y-m-d H:i:s');
				$id = $this->input->post('customer_invoice_id');
				$rs = $this->custinvoice->cutomerinvoice_update($data,$id);
					$update_export_invoice_id = explode("-",$this->input->post('export_invoice_id'));
					$update_export_invoice = $this->custinvoice->update_cust_status(implode(",",$update_export_invoice_id),1);
					$htmldetele		= $this->custinvoice->html_delete($id);
				if($rs)
				{	
					$row['res'] = 3;
					$row['invoiceid'] = $id;
				}

			}
		echo json_encode($row);

	}
	public function invoice_edit($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 { 
			$consign=$this->custinvoice->select_consigner();
			$this->load->model('admin_company_detail');
			$this->load->model('admin_country_detail');			
			$company = $this->admin_country_detail->s_select();
			$data= $this->custinvoice->get_invoice_data($id);
			$consign_other=$this->custinvoice->other_consigner($data->consiger_id);
	 		$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			$company 			= $this->admin_company_detail->s_select();
				
		 	 $this->load->model('admin_currency_list');
			 $v = array( 
					'consign_detail'	=> $consign,
					'menu_data'			=> $menu_data,
					'mode'				=> 'Edit',
					'company_detail'	=> $company,
					'countrydata'		=> $this->admin_country_detail->s_select(),
					'invoicedata'		=> $data,
					"consignother"		=> $consign_other,
				  	"currencydata"		=> $this->admin_currency_list->getcurrencydata(),
					'termsdata'			=> $this->custinvoice->gettermsdata()
				);
			$this->load->view('admin/customer_invoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
}
