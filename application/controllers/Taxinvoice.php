<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Taxinvoice extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_taxinvoice','taxinvoice');
		$this->load->model('menu_model','menu');	
		$this->load->model('admin_exportinvoice_product');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id){
		 
		
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$consign 			= $this->taxinvoice->select_consigner();
				$this->load->model('admin_company_detail');	
				$company 			= $this->admin_company_detail->s_select();
				$this->load->model('admin_country_detail');	
				$data				= $this->taxinvoice->select_invoice_data($id);
				$datap 	 			= $this->admin_exportinvoice_product->loading_data($data->export_invoice_id);
			 	$consign_other		= $this->taxinvoice->other_consigner($data->consigne_id);
				$selectinvoicetype 	= $this->taxinvoice->selectinvoicetype(4);
				$bank				= $this->taxinvoice->bank_detail($company[0]->bank_name);
				$sample_data		= $this->taxinvoice->get_sample_trn($id);
				$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
		$v = array( 
					'consign_detail'	=> $consign,
					'exporter_detail'	=> $exporter,
					'menu_data'			=> $menu_data,
					'mode'				=> 'Add',
					'invoicetype'		=> $selectinvoicetype,
					'company_detail'	=> $company,
					'countrydata'		=> $this->admin_country_detail->s_select(),
					'invoicedata'		=> $data,
					'product_data'		=> $datap,
					'direct_invoice'	=> $data->direct_invoice,
					"consignother"		=> $consign_other,
					"sample_data"		=> $sample_data,
					"bank"				=> $bank
				);
		$this->load->view('admin/taxinvoice',$v);
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
			'exporter_detail' 			=> ($this->input->post('exporter_detail')),
			'taxinvoice_no' 			=> $this->input->post('export_invoice_no'),
			'invoice_date' 				=> date('Y-m-d',strtotime($this->input->post('invoice_date'))),
			'export_ref_no' 			=> $this->input->post('export_ref_no'),
			'performa_date' 			=> date('Y-m-d',strtotime($this->input->post('performa_date'))),
			'export_buy_order_no' 		=> $this->input->post('export_buy_order_no'),
			'e_email' 					=> $this->input->post('e_email'),
			'e_mobile' 					=> $this->input->post('e_mobile'),
			'e_gstin' 					=> $this->input->post('e_gstin'),
			'exporter_pan' 				=> ($this->input->post('exporter_pan')),
			'exporter_iec' 				=> $this->input->post('exporter_iec'),
			'consiger_id' 				=> $this->input->post('consiger_id'),
			'consign_address' 			=> ($this->input->post('consign_address')),
			'buyer_other_consign' 		=> ($this->input->post('buyer_other_consign')),
			'pre_carriage_by' 			=> $this->input->post('pre_carriage_by'),
			'place_of_receipt' 			=> $this->input->post('place_of_receipt'),
			'country_origin_goods' 		=> $this->input->post('country_origin_goods'),
			'country_final_destination' => $this->input->post('country_final_destination'),
			'bank_detail' 				=> ($this->input->post('bank_detail')),
			'flight_name_no' 			=> $this->input->post('flight_name_no'),
			'port_of_loading' 			=> $this->input->post('port_of_loading'),
			'port_of_discharge' 		=> $this->input->post('port_of_discharge'),
			'final_destination' 		=> $this->input->post('final_destination'),
			'payment_terms' 			=> $this->input->post('payment_terms'),
			'container_details' 		=> $this->input->post('container_details'),
			'container_twenty' 			=> $this->input->post('container_twenty'),
			'container_forty' 			=> $this->input->post('container_forty'),
			'terms_of_delivery' 		=> $this->input->post('terms_of_delivery'),
			'export_under' 				=> $this->input->post('export_under'),
			'epcg_licence_no' 			=> $this->input->post('epcg_licence_no'),
			'remarks' 					=> $this->input->post('remarks'),
			'certification_charge' 		=> $this->input->post('certification_charge'),
			'insurance_charge' 			=> $this->input->post('insurance_charge'),
			'seafright_charge' 			=> $this->input->post('seafright_charge'),
			'bank_charge' 				=> $this->input->post('bank_charge'),
			'courier_charge' 			=> $this->input->post('courier_charge'),
			'extra_calc_name' 			=> $this->input->post('extra_calc_name'),
			'extra_calc_opt' 			=> $this->input->post('extra_calc_opt'),
			'extra_calc_amt' 			=> $this->input->post('extra_calc_amt'),
			'discount' 					=> $this->input->post('discount'),
			'grand_total' 				=> $this->input->post('final_total_val'),
			'gst_per' 					=> $this->input->post('gst_per'),
			'indian_ruppe_val' 			=> $this->input->post('indian_ruppe_val'),
			'indian_ruppe_after_gst' 	=> $this->input->post('indian_ruppe_after_gst'),
			'Exchange_Rate_val' 		=> $this->input->post('exchangerate'),
			'direct_invoice' 			=> $this->input->post('direct_invoice'),
			'supplier_id' 				=> $this->input->post('supplier_id'),
			'supplier_invoice_no' 		=> $this->input->post('supplier_invoice_no'),
			'status' 					=> 0,
			);		
			$row['res'] = 0;
			if(strtolower($this->input->post('mode'))=="add")
			{				
				$data['cdate'] = date('Y-m-d H:i:s');
				$data['mdate'] = date('Y-m-d H:i:s');
				
				$insertid = $this->taxinvoice->insert_taxinvoice($data);
				 		
					$t=0;
					foreach($this->input->post('exportproducttrn_id') as $key)
					{
						
						$data1 = array(
							"taxinvoice_id" 		=> $insertid,
							"description_goods" 	=> $this->input->post('description_goods')[$t],
							"total_box" 			=> $this->input->post('boxes')[$t],
							"total_sqm" 			=> $this->input->post('sqm')[$t],
							"product_rate" 			=> $this->input->post('product_rate')[$t],
							"per"					=> $this->input->post('per')[$t],
							"Total_Amount"			=> $this->input->post('product_amount')[$t],
							"exportproduct_trn_id"	=> $this->input->post('exportproducttrn_id')[$t],
					 	);
						$inserttrnid = $this->taxinvoice->insert_taxinvoicetrn($data1);
						$t++;
					}
			  
				 $no=0;
						 	 
						 foreach($this->input->post('export_sampletrn_id') as $samplekey)
						 {
						 
							$data1_sample = array(
								"taxinvoice_id" 		=> $insertid,
								"export_sampletrn_id" 	=> $samplekey,
								"sample_desc" 			=> $this->input->post('sample_desc_array')[$no],
								"no_of_boxes" 			=> $this->input->post('sample_no_of_boxes')[$no],
								"sample_sqm"			=> $this->input->post('sample_sqm')[$no],
								"per"					=> $this->input->post('sample_per')[$no],
							 	"sample_rate"			=> $this->input->post('sample_rate')[$no],
								"sample_amout"			=> $this->input->post('sample_amount')[$no],
							);
						
							 $trninsertid = $this->taxinvoice->insert_taxsampletrn($data1_sample);
							 $no++;
						 } 
				$update = $this->taxinvoice->update_invoicenumber(4,$this->input->post('invoice_series'));
				if($insertid)
				{	
				 	 $updateexportinvoice = $this->taxinvoice->update_exportinvoice($this->input->post('export_invoice_id'),1);
					$row['res'] = 1;
					$row['invoiceid'] = $insertid;
				}
			}
			else if(strtolower($this->input->post('mode'))=="edit")
			{
				$data['mdate'] = date('Y-m-d H:i:s');
				$data['Exchange_Rate_val'] = $this->input->post('exchangerate');
				 
				$id = $this->input->post('taxinvoice_id');
				$rs = $this->taxinvoice->taxinvoice_update($data,$id);
				$delete_tax_trn = $this->taxinvoice->delete_tax_trn($id);
				$t = 0;
					foreach($this->input->post('exportproducttrn_id') as $key)
					{
						
						$data1 = array(
							"taxinvoice_id" 		=> $id,
							"description_goods" 	=> $this->input->post('description_goods')[$t],
							"total_box" 			=> $this->input->post('boxes')[$t],
							"total_sqm" 			=> $this->input->post('sqm')[$t],
							"product_rate" 			=> $this->input->post('product_rate')[$t],
							"per"					=> $this->input->post('per')[$t],
							"Total_Amount"			=> $this->input->post('product_amount')[$t],
							"exportproduct_trn_id"	=> $this->input->post('exportproducttrn_id')[$t],
					 	);
						$inserttrnid = $this->taxinvoice->insert_taxinvoicetrn($data1);
						$t++;
					}
				 $no=0;
				$delete_tax_trn = $this->taxinvoice->delete_tax_sample($id);
						 	 
						 foreach($this->input->post('export_sampletrn_id') as $samplekey)
						 {
						 
							$data1_sample = array(
								"taxinvoice_id" 		=> $id,
								"export_sampletrn_id" 	=> $samplekey,
								"sample_desc" 			=> $this->input->post('sample_desc_array')[$no],
								"no_of_boxes" 			=> $this->input->post('sample_no_of_boxes')[$no],
								"sample_sqm"			=> $this->input->post('sample_sqm')[$no],
								"per"					=> $this->input->post('sample_per')[$no],
							 	"sample_rate"			=> $this->input->post('sample_rate')[$no],
								"sample_amout"			=> $this->input->post('sample_amount')[$no],
							);
						
							 $trninsertid = $this->taxinvoice->insert_taxsampletrn($data1_sample);
							 $no++;
						 }  
				if($rs)
				{	
					$row['res'] = 3;
					$row['invoiceid'] = $id;
				}
				
			}
		echo json_encode($row);

	}
	
	public function tax_edit($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
		$consign=$this->taxinvoice->select_consigner();
		
		$this->load->model('admin_company_detail');
		 
		$company = $this->admin_company_detail->s_select();
		$data= $this->taxinvoice->taxinvoice_data($id);
		$consign_other=$this->taxinvoice->other_consigner($data->consiger_id);
		$datap					= $this->taxinvoice->gettaxproductdata($id);
		$tax_sample_data		= $this->taxinvoice->gettax_sample_productdata($id);
		$this->load->model('admin_country_detail');	
		$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
		$v = array( 
					'consign_detail'	=> $consign,
					'mode'				=> 'Edit',
					'company_detail'	=> $company,
					'countrydata'		=> $this->admin_country_detail->s_select(),
					'invoicedata'		=> $data,
					'menu_data'			=> $menu_data,
					'direct_invoice'	=>  $data->direct_invoice,
					'product_data'		=> $datap,
					'sample_data'		=>  $tax_sample_data,
					"consignother"		=> $consign_other
				);
		$this->load->view('admin/taxinvoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	

}
