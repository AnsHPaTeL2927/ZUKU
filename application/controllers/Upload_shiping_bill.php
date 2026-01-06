<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Upload_shiping_bill extends CI_controller{
	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Payment_list_model','payment');
		$this->load->model('upload_shiping_bill_model','bl');
		$this->load->model('admin_exportinvoice_product','export');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['customer_list'] 		= $this->payment->get_customer();	
			$data['payment_mode_list'] 	= $this->payment->get_payment_mode();	
			$data['bank_list']	 		= $this->payment->get_bank_detail();	
			$data['mode']				= "Add";
			$data['export_id']			= $id;
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['exportinvoice_data']	= $this->export->get_invoice_data($id);
			$data['ewb_data']	 		= $this->export->get_ewb_template($id); 
			$data['url']				= "manage";
			$data['product_data']		= $this->export->getinvoiceproductdata($id);
			
			$this->load->view('admin/upload_shiping_bill',$data);	
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }			
	}

	public function form_edit($id)
	{
		$this->load->model('admin_company_detail');	
		$data['company_detail'] 		= $this->admin_company_detail->s_select();	
		$data['mode']					= "Edit";
		$data['url']					= "manage_edit";
		$data['shipping_bill_data']		= $this->bl->get_shipping_bill($id);
		$data['shipping_bill_data_trn']	= $this->bl->get_shipping_bill_trn($data['shipping_bill_data']->id);
		$data['shiping_id']				= $id;
		$data['menu_data']				= $this->menu->usermain_menu($this->session->usertype_id);	
		$data['exportinvoice_data']		= $this->export->get_invoice_data($data['shipping_bill_data']->export_invoice_id);
		 $data['export_id']				= $data['shipping_bill_data']->export_invoice_id; 	
		 
			
		$this->load->view('admin/upload_shiping_bill',$data);

	}

	public function manage()
	{
		$Shipping_Bill_no 	= $this->input->post('Shipping_Bill_no');
				if($_FILES['bl_upload']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['bl_upload']['name']));
					$config['file_name'] = 'shipping_bill'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
					$this->upload->initialize($config);
					$this->upload->do_upload('bl_upload');
					$upload_image = $this->upload->data();
					$bl_upload  = $upload_image['file_name'];
				}
		
				$eid = $this->input->post('export_invoice_id');
				$data=array(
							'export_invoice_id'    	=> $this->input->post('export_invoice_id'),
							'shipping_bill_no' 		=> $Shipping_Bill_no,
							'ewaybill_no' 			=> $this->input->post('ewaybill_no'),
							'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
							'date_of_shipment' 		=> date('Y-m-d',strtotime($this->input->post('date_of_shipment'))),
							'exchange_rate' 		=> $this->input->post('exchange_rate'),
							'discount' 				=> $this->input->post('discount'),
							'discount_checked' 	 	=> $this->input->post('discount_checked'),
							'extra_calc_name' 	 	=> $this->input->post('extra_calc_name'),
							'extra_calc_value' 	 	=> $this->input->post('extra_calc_value'),
							'extra_checked' 	 	=> $this->input->post('extra_checked'),
							'extra_calc_opt' 	 	=> $this->input->post('extra_calc_opt'),
							'certification_amount'  => $this->input->post('certification_amount'),
							'cerificate_checked'  	=> $this->input->post('cerificate_checked'),
							'fright_amount' 	 	=> $this->input->post('fright_amount'),
							'fright_checked' 	 	=> $this->input->post('fright_checked'),
							'insurance_charge' 	 	=> $this->input->post('insurance_charge'),
							'insurance_checked'  	=> $this->input->post('insurance_checked'),
						 	'commission' 			=> $this->input->post('commission'),
						 	'commision_checked'  	=> $this->input->post('commision_checked'),
						 	'drawback_amount' 		=> $this->input->post('total_drawback_amt'),
							'drawback_per' 			=> $this->input->post('other_drawback_per'),
							'rodtep_per' 			=> $this->input->post('other_roadtep_per'),
							'rodtep_amount' 		=> $this->input->post('total_rodtep_amt'),
							'total_invoice_value' 	=> $this->input->post('total_invoice_value'),
						 	'field1' 				=> $this->input->post('field1'),
							'field2' 				=> $this->input->post('field2'),
							'bl_upload' 			=> $bl_upload,
							'remark'		 		=> nl2br($this->input->post('remark')),
							'export_invoice_id' 	=> $this->input->post('export_invoice_id'),
							'cdate' 				=> date('Y-m-d H:i:s')
							
					);
				$rdata = $this->bl->insert_bl($data);
				$no = 0;
			
				foreach($this->input->post('export_packing_id') as $exportpacking_id)
				{
					 
						$data_trn = array(
							"export_packing_id"	 	=> $exportpacking_id,
							"upload_shiping_bill_id"=> $rdata,
							"drawback_per"	 		=> $this->input->post('drawback_per')[$no],
							"drawback_amount" 	 	=> $this->input->post('drawback_amount')[$no],
						 	'rodtep_per' 			=> $this->input->post('rodtep_per')[$no], 
						 	'rodtep_amount' 		=> $this->input->post('rodtep_amount')[$no], 
							'status'				=> 0 
						);
							
						$insertrecord = $this->bl->insert_bl_trn($data_trn);
					 
					$no++;
			 	}
				$this->bl->update_bl($eid , $rdata);
			
				if($rdata)
				{
					$row['res'] = 1;
					$row['shipping_bill_id'] = $rdata;
				}
			
			else if($this->input->post('mode1')==2)
			{
				if($this->input->post('save_next_btn'))
				{
					redirect(base_url('Upload_shiping_bill/index/'.$rdata));
				}
				else
				{
					redirect(base_url('exportinvoice_listing/index'));
				}
				redirect(base_url('exportinvoice_listing/index'));
			}
			else
			{
			   if($rdata)
			   {
				   $row['res'] = 0;
				 
			   }
			}
			
		   echo json_encode($row);
		
	}	

	public function manage_edit()
	{
				$Shipping_Bill_no 	= $this->input->post('Shipping_Bill_no');
				if($_FILES['bl_upload']['name'] != "")
				{
					unlink('./upload/'.$this->input->post('shipping_file'));
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['bl_upload']['name']));
					$config['file_name'] = 'shipping_bill'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('bl_upload');
					$upload_image = $this->upload->data();
					$bl_upload  = $upload_image['file_name'];
				}
				else
				{
					$bl_upload = $this->input->post('shipping_file');
				}
		
					$eid = $this->input->post('export_invoice_id');
					  
				$data=array(
							'export_invoice_id'    	=> $this->input->post('export_invoice_id'),
							'shipping_bill_no' 		=> $Shipping_Bill_no,
							'ewaybill_no' 			=> $this->input->post('ewaybill_no'),
							'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
							'date_of_shipment' 		=> date('Y-m-d',strtotime($this->input->post('date_of_shipment'))),
							'exchange_rate' 		=> $this->input->post('exchange_rate'),
							'discount' 				=> $this->input->post('discount'),
							'discount_checked' 	 	=> $this->input->post('discount_checked'),
							'extra_calc_name' 	 	=> $this->input->post('extra_calc_name'),
							'extra_calc_value' 	 	=> $this->input->post('extra_calc_value'),
							'extra_checked' 	 	=> $this->input->post('extra_checked'),
							'extra_calc_opt' 	 	=> $this->input->post('extra_calc_opt'),
							'certification_amount'  => $this->input->post('certification_amount'),
							'cerificate_checked'  	=> $this->input->post('cerificate_checked'),
							'fright_amount' 	 	=> $this->input->post('fright_amount'),
							'fright_checked' 	 	=> $this->input->post('fright_checked'),
							'insurance_charge' 	 	=> $this->input->post('insurance_charge'),
							'insurance_checked'  	=> $this->input->post('insurance_checked'),
						 	'commission' 			=> $this->input->post('commission'),
						 	'commision_checked'  	=> $this->input->post('commision_checked'),
						 	'drawback_amount' 		=> $this->input->post('total_drawback_amt'),
							'drawback_per' 			=> $this->input->post('other_drawback_per'),
							'rodtep_per' 			=> $this->input->post('other_roadtep_per'),
							'rodtep_amount' 		=> $this->input->post('total_rodtep_amt'),
							'total_invoice_value' 	=> $this->input->post('total_invoice_value'),
						 	'field1' 				=> $this->input->post('field1'),
							'field2' 				=> $this->input->post('field2'),
							'bl_upload' 			=> $bl_upload,
							'remark'		 		=> nl2br($this->input->post('remark')),
							'export_invoice_id' 	=> $this->input->post('export_invoice_id'),
							'cdate' 				=> date('Y-m-d H:i:s')
							
					);
					$uid =  $this->input->post('shiping_id');
					$deleteid = $this->bl->delete_shipping_bill_trn($uid);
					$no=0;
				
					foreach($this->input->post('export_packing_id') as $exportpacking_id)
					{
					 
						$data_trn = array(
							"export_packing_id"	 	=> $exportpacking_id,
							"upload_shiping_bill_id"=> $uid,
							"drawback_per"	 		=> $this->input->post('drawback_per')[$no],
							"drawback_amount" 	 	=> $this->input->post('drawback_amount')[$no],
						 	'rodtep_per' 			=> $this->input->post('rodtep_per')[$no], 
						 	'rodtep_amount' 		=> $this->input->post('rodtep_amount')[$no], 
							'status'				=> 0 
						);
							
						$insertrecord = $this->bl->insert_bl_trn($data_trn);
					 
					$no++;
					}
					$rdata = $this->bl->update_upload_bl($data,$uid);
		
					
			if($rdata)
			{
				$row['res'] = 2;
		 	}
			else{
				$row['res'] = 0;
			}
			
		   echo json_encode($row);
		
	}	

	public function fetchdata()
	{
		$row =array();
		$id=$this->input->post('id');
		$payment_recieve_type=$this->input->post('payment_recieve_type');
		$resultdata=$this->payment->get_customer_detail($id);
		if($payment_recieve_type == 1)
		{
			$billdata=$this->payment->get_bill_detail($id);
			$str = '';
			foreach($billdata as $rowbill)
			{
				$checkdata=$this->payment->get_due_amount($rowbill->export_invoice_id);
				if($checkdata->grand_total >  $checkdata->total_paid_amt)
				{
					$str .= "<option value='".$rowbill->export_invoice_id."'>".$rowbill->export_invoice_no."</option>";
				}
			}
			$row['str'] = $str;
			$row['payment_recieve_type'] = $payment_recieve_type;
		}
		else if($payment_recieve_type == 2)
		{
			$billdata=$this->payment->get_total_bill_detail($id);
			$row['str'] 				 = number_format(($billdata->total_grand_total - $billdata->total_paid_amt),2);
			$row['payment_recieve_type'] = $payment_recieve_type;
		}
		echo json_encode($row);
	}
	public function getdueamount($id)
	{
		 
		$resultdata=$this->payment->get_due_amount($id);
		$grand_total = $resultdata->grand_total;
		if($resultdata->calculation_operator == 2)
		{
			$grand_total += $resultdata->certification_charge;
			$grand_total += $resultdata->seafright_charge;
			$grand_total += $resultdata->seafright_charge;
		}
		return  $grand_total - $resultdata->total_paid_amt;
	}

}
?>