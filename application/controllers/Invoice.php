<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Invoice extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_invoice','invoice');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id'])) {
			redirect(base_url());
		}
	}

	function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_bank_detail','bd');
			$exporter			= $this->invoice->select_exporter();
			$consign			= $this->invoice->select_consigner();
			$selectinvoicetype 	= $this->invoice->selectinvoicetype(1);
			$this->load->model('admin_company_detail');	
			$this->load->model('admin_country_detail');	
			$this->load->model('admin_currency_list');
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			$all_bank		 	= $this->bd->b_select();			
			$v = array(
				'consign_detail'	=> $consign,
				'bank_detail'		=> $this->bd->b_form_edit($exporter->bank_name),
				'exporter_detail'	=> $exporter,
				'menu_data'			=> $menu_data,
				'mode'			  	=> 'Add',
				'invoicetype'	  	=> $selectinvoicetype,
				'company_detail'  	=> $this->admin_company_detail->s_select(),
				'countrydata'	  	=> $this->admin_country_detail->s_select(),
				'currencydata'	  	=> $this->admin_currency_list->getcurrencydata(),
				'termsdata'		  	=> $this->invoice->gettermsdata(),
				 'all_bank'		  	=> $this->bd->b_select()
			);
		$this->load->view('admin/invoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	function manage()
	{
		$check_box_design = $this->invoice->check_terms_update($this->input->post('payment_terms'));
		$check_pi_no = $this->invoice->check_performa_no($this->input->post('invoice_no'));
		//$check_consigne = $this->invoice->check_consigne_id($this->input->post('consign_detail'));
		
			if(empty($check_box_design))
			{
				$row =array();
				$data1 = array(
									
									'payment_terms' 					=> $this->input->post('payment_terms')	
								);
								
				// $data2 = array(
					
					// 'company_status' 					=> $this->input->post('c_name')	
				// );
				$data = array(
					'exporter_detail' 			=> nl2br($this->input->post('exporter_detail')),
					'e_email' 					=> $this->input->post('e_email'),
					'e_mobile' 					=> $this->input->post('e_mobile'),
					'contactperson_name' 		=> $this->input->post('contactperson_name'),
					'consigne_id' 				=> $this->input->post('c_name'),
					'consign_detail' 			=> nl2br($this->input->post('consign_detail')),
					'invoice_currency_id'		=> ($this->input->post('invoice_currency_id')),
					'invoice_no' 				=> $this->input->post('invoice_no'),
					'country_origin_goods' 		=> $this->input->post('country_origin_goods'),
					'port_of_discharge' 		=> $this->input->post('port_of_discharge'),
					'final_destination' 		=> $this->input->post('final_destination'),
					'variation_in_quantity'		=> $this->input->post('variation_in_quantity'),
					'buy_order_no' 				=> $this->input->post('buy_order_no'),
					'notify_id' 				=> $this->input->post('notify_id'),
					'buyer_other_consign' 		=> nl2br($this->input->post('buyer_other_consign')),
					'terms_of_delivery' 		=> $this->input->post('terms_of_delivery'),
					'performa_date' 			=> date('Y-m-d',strtotime($this->input->post('date'))),
					'country_final_destination' => $this->input->post('country_final_destination'),
					'port_of_loading' 			=> $this->input->post('port_of_loading'),
					'other_reference' 			=> $this->input->post('other_reference'),
					'transhipment' 				=> $this->input->post('transhipment'),
					'partial_shipment' 			=> $this->input->post('partial_shipment'),
					'delivery_period' 			=> $this->input->post('delivery_period'),
					'container_details' 		=> $this->input->post('container_details'),
					'container_size' 			=> $this->input->post('container_size'),
					'terms_id' 					=> $this->input->post('terms_id'),
					'bank_id' 					=> $this->input->post('bank_id'),
					'bank_name' 				=> $this->input->post('bank_name'),
					'bank_address' 				=> $this->input->post('bank_address'),
					'account_name' 				=> $this->input->post('account_name'),
					'account_no' 				=> $this->input->post('account_no'),
					'ifsc_code' 				=> $this->input->post('ifsc_code'),
					'swift_code' 				=> $this->input->post('swift_code'),
					'bank_ad_code' 				=> $this->input->post('bank_ad_code'),
					'iban_number' 				=> $this->input->post('iban_number'),
					'payment_terms' 			=> $this->input->post('payment_terms'),
					'remarks' 					=> nl2br($this->input->post('remarks')),
					'export_ref_no' 			=> $this->input->post('export_ref_no'),
					'limit_container' 			=> (!empty($this->input->post('limit_container1')))?$this->input->post('limit_container1'):$this->input->post('limit_container'),
					'container_forty' 			=> $this->input->post('container_forty'),
					'container_twenty' 			=> $this->input->post('container_twenty'),
					'time' 						=> (!empty($this->input->post('time')))?date('H:i:s',strtotime($this->input->post('time'))):"",
					'user_id' 					=> $this->session->id,
					'status' 					=> 0
					);
					$row['res'] = 0;
					if(strtolower($this->input->post('mode'))=="add")
					{				
						$data['step']  = 1;
						$data['confirm_status']  = 0;
						$data['cdate'] = date('Y-m-d H:i:s');
						$data['mdate'] = date('Y-m-d H:i:s');
					// if(empty($check_consigne))
					// {  
						if(empty($check_pi_no))
						{
							$pdata = $this->invoice->terms_insert($data1);
							//$bdata = $this->invoice->bankdata_insert($data2);
							$rdata = $this->invoice->performainvoice_insert($data);
							
							if($rdata)
							{	
								$update = $this->invoice->update_invoicenumber(1,$this->input->post('invoice_series'));
								$row['res'] = 1;
								$row['invoiceid'] = $rdata;
							}
						}
						else
						{
							$row['res'] = 4;
						}
					// }
					// else
					// {
						// $row['res'] = 2;
					// }
						
					}
					else if(strtolower($this->input->post('mode'))=="edit")
					{
						$data['mdate'] = date('Y-m-d H:i:s');
						$id = $this->input->post('performa_invoice_id');
						$rs = $this->invoice->updateperformainvoice($data,$id);
						if($rs)
						{	
							$row['res'] = 3;
							$row['invoiceid'] = $id;
						}
		
					}
			}
			else
			{
				$row =array();
				
				$data = array(
					'exporter_detail' 			=> nl2br($this->input->post('exporter_detail')),
					'e_email' 					=> $this->input->post('e_email'),
					'e_mobile' 					=> $this->input->post('e_mobile'),
					'contactperson_name' 		=> $this->input->post('contactperson_name'),
					'consigne_id' 				=> $this->input->post('c_name'),
					'consign_detail' 			=> nl2br($this->input->post('consign_detail')),
					'invoice_currency_id'		=> ($this->input->post('invoice_currency_id')),
					'invoice_no' 				=> $this->input->post('invoice_no'),
					'country_origin_goods' 		=> $this->input->post('country_origin_goods'),
					'port_of_discharge' 		=> $this->input->post('port_of_discharge'),
					'final_destination' 		=> $this->input->post('final_destination'),
					'variation_in_quantity'		=> $this->input->post('variation_in_quantity'),
					'buy_order_no' 				=> $this->input->post('buy_order_no'),
					'notify_id' 				=> $this->input->post('notify_id'),
					'buyer_other_consign' 		=> nl2br($this->input->post('buyer_other_consign')),
					'terms_of_delivery' 		=> $this->input->post('terms_of_delivery'),
					'performa_date' 			=> date('Y-m-d',strtotime($this->input->post('date'))),
					'country_final_destination' => $this->input->post('country_final_destination'),
					'port_of_loading' 			=> $this->input->post('port_of_loading'),
					'other_reference' 			=> $this->input->post('other_reference'),
					'transhipment' 				=> $this->input->post('transhipment'),
					'partial_shipment' 			=> $this->input->post('partial_shipment'),
					'delivery_period' 			=> $this->input->post('delivery_period'),
					'container_details' 		=> $this->input->post('container_details'),
					'container_size' 			=> $this->input->post('container_size'),
					'terms_id' 					=> $this->input->post('terms_id'),
					'bank_id' 					=> $this->input->post('bank_id'),
					'bank_name' 				=> $this->input->post('bank_name'),
					'bank_address' 				=> $this->input->post('bank_address'),
					'account_name' 				=> $this->input->post('account_name'),
					'account_no' 				=> $this->input->post('account_no'),
					'ifsc_code' 				=> $this->input->post('ifsc_code'),
					'swift_code' 				=> $this->input->post('swift_code'),
					'bank_ad_code' 				=> $this->input->post('bank_ad_code'),
					'iban_number' 				=> $this->input->post('iban_number'),
					'payment_terms' 			=> $this->input->post('payment_terms'),
					'remarks' 					=> nl2br($this->input->post('remarks')),
					'export_ref_no' 			=> $this->input->post('export_ref_no'),
					'limit_container' 			=> (!empty($this->input->post('limit_container1')))?$this->input->post('limit_container1'):$this->input->post('limit_container'),
					'container_forty' 			=> $this->input->post('container_forty'),
					'container_twenty' 			=> $this->input->post('container_twenty'),
					'time' 						=> (!empty($this->input->post('time')))?date('H:i:s',strtotime($this->input->post('time'))):"",
					'user_id' 					=> $this->session->id,
					'status' 					=> 0
					);
					$row['res'] = 0;
					if(strtolower($this->input->post('mode'))=="add")
					{				
						$data['step']  = 1;
						$data['confirm_status']  = 0;
						$data['cdate'] = date('Y-m-d H:i:s');
						$data['mdate'] = date('Y-m-d H:i:s');
					// if(empty($check_consigne))
					// {
						if(empty($check_pi_no))
						{
							
							$rdata = $this->invoice->performainvoice_insert($data);
							
							if($rdata)
							{	
								$update = $this->invoice->update_invoicenumber(1,$this->input->post('invoice_series'));
								$row['res'] = 1;
								$row['invoiceid'] = $rdata;
							}
						}
						else
						{
							$row['res'] = 4;
						}
					// }
					// else
					// {
						// $row['res'] = 2;
					// }
						
					}
					else if(strtolower($this->input->post('mode'))=="edit")
					{
						$data['mdate'] = date('Y-m-d H:i:s');
						$id = $this->input->post('performa_invoice_id');
						$rs = $this->invoice->updateperformainvoice($data,$id);
						if($rs)
						{	
							$row['res'] = 3;
							$row['invoiceid'] = $id;
						}
		
					}
			}
			
		echo json_encode($row);

	}
 	//update 
 	public function form_edit($id)
	{
		$exporter=$this->invoice->select_exporter();
		$consign=$this->invoice->select_consigner();
		$data = $this->invoice->getinvoicedata($id);	
		$this->load->model('admin_company_detail');	
		$this->load->model('admin_country_detail');	
		$this->load->model('admin_currency_list');	
		$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
		$this->load->model('admin_bank_detail','bd');	
		$consign_other=$this->invoice->other_consigner($data->consigne_id);
		$all_bank		 	= $this->bd->b_select();
		
		$v = array(
			'consign_detail'=>$consign,
			'exporter_detail'=>$exporter,
			'menu_data'=>$menu_data,
		 	'mode'=>'Edit',
			'invoicedata'=>$data,
			'company_detail'=>$this->admin_company_detail->s_select(),
			"consignother"=>$consign_other,
			'countrydata'=>$this->admin_country_detail->s_select(),
			'currencydata'=>$this->admin_currency_list->getcurrencydata(),
			'termsdata'	=>$this->invoice->gettermsdata(),
			'notifydata'	=>$this->invoice->customerallconsignerdetail($data->consigne_id),
			'all_bank'		  => $this->bd->b_select(),
			'bank_detail'		=>$this->bd->b_form_edit($data->bank_id),
		);

		$this->load->view('admin/invoice',$v);		
			
	}
	
	public function selectcompnay()
	{
		$id=$this->input->post('e_id');
		$type=$this->input->post('type');
		$mode=$this->input->post('mode');
		if($type=='consigner')
		{
			$paymentdata = $this->invoice->payment_data($id,$mode);
			$str = '<option value="">Select Advance Payment</option>';
			if(!empty($paymentdata))
			{
				foreach($paymentdata as $payrow)
				{
					$data = date('d/m/Y',strtotime($payrow->date)).', AMT:'.$payrow->paid_amount;
					$str .= '<option value="'.$payrow->payment_id.'">'.$data.'</option>';
				}
			}
			
			$fetchdata = $this->invoice->customerdetail($id);
			$fetchdata1 = $this->invoice->customerallconsignerdetail($id);
			 
			$notify_html = '<option value="">Select Notify</option>';
			foreach($fetchdata1 as $resulrarray)
			{
				$notify_html .= '<option value="'.$resulrarray->id.'">'.$resulrarray->notify_name.'</option>';
			} 
			 $fetchdata->address = strip_tags($fetchdata->c_address);
			 $fetchdata->payment_terms = strip_tags($fetchdata->payment_terms);
			 $fetchdata->note = strip_tags($fetchdata->note);
			
			echo json_encode(array('data1'=>$fetchdata,'data2'=>$notify_html,'payment_data'=>$str));
		}
		else if($type=='consignerid')
		{
			$fetchdata1 = $this->invoice->customerconsignerdetail($id);
			 $fetchdata1->notify_address = strip_tags($fetchdata1->notify_address);
			echo json_encode($fetchdata1);
		}
	}
	public function bank_detail()
	{
		$bankid=$this->input->post('bankid');
		$this->load->model('admin_bank_detail','bd');
		$bank_detail = $this->bd->b_form_edit($bankid);
		echo json_encode($bank_detail);
	}
	
	public function search(){
 
        $term = $this->input->get('term');
 
        $this->db->like('payment_terms', $term);
		$this->db->limit(5);
		$this->db->where('status',"0");
		$this->db->where('is_active',"Yes");
        $data = $this->db->get("tbl_payment_terms")->result();
 
        echo json_encode($data);
    } 
	
	public function search1(){
 
        $term = $this->input->get('term');
 
        $this->db->like('port_name', $term);
		$this->db->limit(5);
		$this->db->where('status',"0");
		$this->db->where('is_active',"Yes");
        $data = $this->db->get("tbl_port_master")->result();
 
        echo json_encode($data);
    } 
	
	 
}
