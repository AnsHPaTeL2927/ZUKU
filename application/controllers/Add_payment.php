<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_payment extends CI_controller
{
	public function __construct(){
		parent:: __construct();
		 
		$this->load->model('Payment_list_model','payment');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index($m="")
	{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['customer_list'] 		= $this->payment->get_customer();	
			$data['payment_mode_list'] 	= $this->payment->get_payment_mode();	
			$data['bank_list']	 		= $this->payment->get_bank_detail();	
			$data['mode']				= "Add";
		  $data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/add_payment',$data);	
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }			
	}
	public function edit_payment($paymentid)
	{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['customer_list'] 		= $this->payment->get_customer();	
			$data['payment_mode_list'] 	= $this->payment->get_payment_mode();	
			$data['bank_list']	 		= $this->payment->get_bank_detail();	
			$data['payment_detail']	 		= $this->payment->getpayment_detail($paymentid);	
			$data['mode']				= "Add";
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/edit_payment',$data);	
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }			
	}
	public function manage()
	{
		$bill_no 	= $this->input->post('bill_id');
		$total_payment = str_ireplace(",","",$this->input->post('paid_amount'));
		 
		$total = 0;
		foreach($bill_no as $bill)
		{
			 $receive_payment = $this->getdueamount($bill);
		 	 $total += $receive_payment;
		}
		
		if($this->input->post('payment_recieve_type') == 1)
		{
			
			if(Floatval($total_payment) <= Floatval($total))
			{
			 
				if($_FILES['payment_file']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['payment_file']['name']));
					$config['file_name'] = 'payment_file'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/payment/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('payment_file');
					$upload_image = $this->upload->data();
					$payment_file  = $upload_image['file_name'];
					
				}
				if($_FILES['swift_file']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['swift_file']['name']));
					$config['file_name'] = 'swift_file'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/payment/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('swift_file');
					$upload_image = $this->upload->data();
					$swift_file  = $upload_image['file_name'];
				}
				$no = 1;
				foreach($bill_no as $bill)
				{
					
					if($total_payment>0)
					{ 
						$receive_payment = $this->getdueamount($bill);
						
						if(floatval($receive_payment) <= floatval($total_payment))
						{
							$bill_payment = $receive_payment;
						}
						else 
						{
							$bill_payment = $total_payment;
						}
						if($bill_payment > 0)
						{
							 
							$data=array(
										'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
										'swift_date' 					=> date('Y-m-d',strtotime($this->input->post('swift_date'))),
										'customer_id' 			=> $this->input->post('customer_id'),
										'payment_recieve_type' 	=> $this->input->post('payment_recieve_type'),
										'bill_id' 				=> $bill,
										'payment_mode_id' 		=> $this->input->post('payment_mode_id'),
										'paid_amount' 			=> $bill_payment,
								 		'bank_id' 				=> $this->input->post('bank_id'),
										'refernace_no' 		 	=> $this->input->post('refernace_no'),
										'bank_charge' 		 	=> $this->input->post('bank_charge'),
										'inr_bank_value' 		 	=> $this->input->post('inr_bank_value'),
										'remarks'		 		=> nl2br($this->input->post('remarks')),
										'total_payment'		 	=> $this->input->post('paid_amount'),
										'swift_amount' 			=> $this->input->post('swift_amount'),
										'exchange_rate' 		=> $this->input->post('exchange_rate'),
										'inr_value' 			=> $this->input->post('inr_value'),
										'cgst_per' 				=> $this->input->post('cgst_per'),
										'cgst_value' 				=> $this->input->post('cgst_value'),
										'sgst_per' 				=> $this->input->post('sgst_per'),
										'sgst_value' 			=> $this->input->post('sgst_value'),
										'igst_per' 				=> $this->input->post('igst_per'),
										'igst_value' 			=> $this->input->post('igst_value'),
										'total_gst' 			=> $this->input->post('total_gst'),
										'aginst_invoie'		 	=> implode(",",$bill_no),
										'cdate'					=> date('Y-m-d H:i:s')
								);
								if(!empty($payment_file))
								{
									$data['payment_file'] = $payment_file;
								}
								if(!empty($swift_file))
								{
									$data['swift_file'] = $swift_file;
								}
								if($no > 1)
								{
									$data['status']	=	1; 
								}
								$rdata = $this->payment->insert_payment($data);
								if($rdata)
								{
									$row['res'] = 1;
								}
								else{
									$row['res'] = 0;
								}
						}
					}
					$total_payment -= $bill_payment;
						$no++;
				}
			}
			else
			{
				$row['res'] = 2;
			}
		}
		else
		{
				 
				if($_FILES['payment_file']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['payment_file']['name']));
					$config['file_name'] = 'payment_file'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('payment_file');
					$upload_image = $this->upload->data();
					$payment_file  = $upload_image['file_name'];
				}
				if($_FILES['swift_file']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['swift_file']['name']));
					$config['file_name'] = 'swift_file'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/payment/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('swift_file');
					$upload_image = $this->upload->data();
					$swift_file  = $upload_image['file_name'];
				}
				$data=array(
										'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
										'swift_date' 					=> date('Y-m-d',strtotime($this->input->post('swift_date'))),
										'customer_id' 			=> $this->input->post('customer_id'),
										'payment_recieve_type' 	=> $this->input->post('payment_recieve_type'),
										'bill_id' 				=> '',
										'payment_mode_id' 		=> $this->input->post('payment_mode_id'),
										'paid_amount' 			=> $this->input->post('paid_amount'),
								 		'bank_id' 				=> $this->input->post('bank_id'),
										'refernace_no' 		 	=> $this->input->post('refernace_no'),
										'bank_charge' 		 	=> $this->input->post('bank_charge'),
										'inr_bank_value' 		 	=> $this->input->post('inr_bank_value'),
										'remarks'		 		=> nl2br($this->input->post('remarks')),
										'total_payment'		 	=> $this->input->post('paid_amount'),
										'swift_amount' 			=> $this->input->post('swift_amount'),
										'exchange_rate' 		=> $this->input->post('exchange_rate'),
										'inr_value' 			=> $this->input->post('inr_value'),
										'cgst_per' 				=> $this->input->post('cgst_per'),
										'cgst_value' 				=> $this->input->post('cgst_value'),
										'sgst_per' 				=> $this->input->post('sgst_per'),
										'sgst_value' 			=> $this->input->post('sgst_value'),
										'igst_per' 				=> $this->input->post('igst_per'),
										'igst_value' 			=> $this->input->post('igst_value'),
										'total_gst' 			=> $this->input->post('total_gst'),
									 	'cdate'					=> date('Y-m-d H:i:s')
								);
								if(!empty($payment_file))
								{
									$data['payment_file'] = $payment_file;
								}
								if(!empty($swift_file))
								{
									$data['swift_file'] = $swift_file;
								}
			 
			$rdata = $this->payment->insert_payment($data);
			if($rdata)
			{
				$row['res'] = 1;
		 	}
			else{
				$row['res'] = 0;
			}
		}
			
	 
		
			
		   echo json_encode($row);
		
	}	
	public function edit_manage()
	{
		$deleteid		= $this->payment->delete_payment($this->input->post('payment_id'));
		$bill_no 	= $this->input->post('bill_id');
		$total_payment = str_ireplace(",","",$this->input->post('paid_amount'));
		 
		$total = 0;
		foreach($bill_no as $bill)
		{
			 $receive_payment = $this->getdueamount($bill);
		 	 $total += $receive_payment;
		}
		
		if($this->input->post('payment_recieve_type') == 1)
		{
			 
			if(Floatval($total_payment) <= Floatval($total))
			{
				if(!empty($_FILES['payment_file']['name']))
				{
					$payment_file  = '';
				 
					if($_FILES['payment_file']['name'] != "")
					{
						$this->load->library('upload');
						$config = array();
						$extension = end(explode(".",$_FILES['payment_file']['name']));
						$config['file_name'] = 'payment_file'.rand(0,9999).'.'.$extension;
						$config['upload_path'] = './upload/payment/';
						$config['allowed_types'] = '*';
						$config['max_size']      = '50000';
						$config['overwrite']     = FALSE;
				
						$this->upload->initialize($config);
						$this->upload->do_upload('payment_file');
						$upload_image = $this->upload->data();
						$payment_file  = $upload_image['file_name'];
					}
				}
				if(!empty($_FILES['swift_file']['name']))
				{
					$swift_file  = '';
				
					if($_FILES['swift_file']['name'] != "")
					{
						$this->load->library('upload');
						$config = array();
						$extension = end(explode(".",$_FILES['swift_file']['name']));
						$config['file_name'] = 'swift_file'.rand(0,9999).'.'.$extension;
						$config['upload_path'] = './upload/payment/';
						$config['allowed_types'] = '*';
						$config['max_size']      = '50000';
						$config['overwrite']     = FALSE;
				
						$this->upload->initialize($config);
						$this->upload->do_upload('swift_file');
						$upload_image = $this->upload->data();
						$swift_file  = $upload_image['file_name'];
					}
				}
				$no = 1;
				foreach($bill_no as $bill)
				{
					
					if($total_payment>0)
					{ 
						$receive_payment = $this->getdueamount($bill);
						
						if(floatval($receive_payment) <= floatval($total_payment))
						{
							$bill_payment = $receive_payment;
						}
						else 
						{
							$bill_payment = $total_payment;
						}
						if($bill_payment > 0)
						{
							 
							$data=array(
										'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
										'swift_date' 					=> date('Y-m-d',strtotime($this->input->post('swift_date'))),
										'customer_id' 			=> $this->input->post('customer_id'),
										'payment_recieve_type' 	=> $this->input->post('payment_recieve_type'),
										'bill_id' 				=> $bill,
										'payment_mode_id' 		=> $this->input->post('payment_mode_id'),
										'paid_amount' 			=> $bill_payment,
									 	'bank_id' 				=> $this->input->post('bank_id'),
										'refernace_no' 		 	=> $this->input->post('refernace_no'),
										'bank_charge' 		 	=> $this->input->post('bank_charge'),
										'inr_bank_value' 		 	=> $this->input->post('inr_bank_value'),
										'remarks'		 		=> nl2br($this->input->post('remarks')),
										'total_payment'		 	=> $this->input->post('paid_amount'),
										'swift_amount' 			=> $this->input->post('swift_amount'),
										'exchange_rate' 		=> $this->input->post('exchange_rate'),
										'inr_value' 			=> $this->input->post('inr_value'),
										'cgst_per' 				=> $this->input->post('cgst_per'),
										'cgst_value' 				=> $this->input->post('cgst_value'),'sgst_per' 				=> $this->input->post('sgst_per'),
										'sgst_value' 			=> $this->input->post('sgst_value'),
										'igst_per' 				=> $this->input->post('igst_per'),
										'igst_value' 			=> $this->input->post('igst_value'),
										'total_gst' 			=> $this->input->post('total_gst'),
										'aginst_invoie'		 	=> implode(",",$bill_no),
										'cdate'					=> date('Y-m-d H:i:s')
								);
								if($no > 1)
								{
									$data['status']	=	1; 
								}
								
								if(!empty($payment_file))
								{
									$data['payment_file'] = $payment_file;
								}
								else 
								{
									$data['payment_file'] = $this->input->post('paymentfile');
								}
								if(!empty($swift_file))
								{
									$data['swift_file'] = $swift_file;
								}
								else
								{
									$data['swift_file'] = $this->input->post('shiftfile');
								}
								$rdata = $this->payment->insert_payment($data);
								if($rdata)
								{
									$row['res'] = 1;
								}
								else{
									$row['res'] = 0;
								}
						}
					}
					$total_payment -= $bill_payment;
						$no++;
				}
			}
			else
			{
				$row['res'] = 2;
			}
		}
		else
		{
				 
				if($_FILES['payment_file']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['payment_file']['name']));
					$config['file_name'] = 'payment_file'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('payment_file');
					$upload_image = $this->upload->data();
					$payment_file  = $upload_image['file_name'];
				}
				if($_FILES['swift_file']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['swift_file']['name']));
					$config['file_name'] = 'swift_file'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/payment/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('swift_file');
					$upload_image = $this->upload->data();
					$swift_file  = $upload_image['file_name'];
				}
				$data=array(
										'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
										'swift_date' 					=> date('Y-m-d',strtotime($this->input->post('swift_date'))),
										'customer_id' 			=> $this->input->post('customer_id'),
										'payment_recieve_type' 	=> $this->input->post('payment_recieve_type'),
										'bill_id' 				=> '',
										'payment_mode_id' 		=> $this->input->post('payment_mode_id'),
										'paid_amount' 			=> $this->input->post('paid_amount'),
										'bank_id' 				=> $this->input->post('bank_id'),
										'refernace_no' 		 	=> $this->input->post('refernace_no'),
										'bank_charge' 		 	=> $this->input->post('bank_charge'),
										'inr_bank_value' 		 	=> $this->input->post('inr_bank_value'),
										'remarks'		 		=> nl2br($this->input->post('remarks')),
										'total_payment'		 	=> $this->input->post('paid_amount'),
										'swift_amount' 			=> $this->input->post('swift_amount'),
										'exchange_rate' 		=> $this->input->post('exchange_rate'),
										'inr_value' 			=> $this->input->post('inr_value'),
										'cgst_per' 				=> $this->input->post('cgst_per'),
										'cgst_value' 				=> $this->input->post('cgst_value'),'sgst_per' 				=> $this->input->post('sgst_per'),
										'sgst_value' 			=> $this->input->post('sgst_value'),
										'igst_per' 				=> $this->input->post('igst_per'),
										'igst_value' 			=> $this->input->post('igst_value'),
										'total_gst' 			=> $this->input->post('total_gst'),
									 	'cdate'					=> date('Y-m-d H:i:s')
								);
								if(!empty($payment_file))
								{
									$data['payment_file'] = $payment_file;
								}
								else 
								{
									$data['payment_file'] = $this->input->post('paymentfile');
								}
								if(!empty($swift_file))
								{
									$data['swift_file'] = $swift_file;
								}
								else
								{
									$data['swift_file'] = $this->input->post('shiftfile');
								}
			$rdata = $this->payment->insert_payment($data);
			if($rdata)
			{
				$row['res'] = 1;
		 	}
			else{
				$row['res'] = 0;
			}
		}
		
		
			
		   echo json_encode($row);
		
	}	

	public function fetchdata()
	{
		$row =array();
		$id=$this->input->post('id');
		$payment_recieve_type=$this->input->post('payment_recieve_type');
		$aginst_invoie=$this->input->post('aginst_invoie');
		$resultdata=$this->payment->get_customer_detail($id);
		if($payment_recieve_type == 1)
		{
			$billdata=$this->payment->get_bill_detail($id);
			$str = '';
			foreach($billdata as $rowbill)
			{
				 
					$checkdata=$this->payment->get_due_amount($rowbill->export_invoice_id,'1990-01-01','2050-01-01');
					$paid_amount = $checkdata->total_paid_amt  + $checkdata->kasar_amt;
					if($checkdata->grand_total > $paid_amount || in_array($rowbill->export_invoice_id,explode(",",$aginst_invoie)))
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
	public function fetchexchnage_rate()
	{
		$bill_id = implode(",",$this->input->post('bill_id'));
		$billdata=$this->payment->exportinvoice_data($bill_id[0]);
		echo json_encode($billdata);
	}
	public function load_bill_detail()
	{
		$bill_id 		= $this->input->post('bill_id');
		$customer_id 	= $this->input->post('customer_id');
		$str = '<table class="table table-bordered">
				<tr>
					<th>No</th>
					<th>Date</th>
					<th>Swift Amount</th>
					<th>Bank Payment Received</th>
					<th>Exchange Rate</th>
					<th>INR Total</th>
				</tr>
			';
		$no =1;
		foreach($bill_id as $bill)
		{
			$billdata=$this->payment->exportinvoice_data($bill);
			$str .= ' 
				<tr>
					<td class="text-center" colspan="6">'.$billdata->export_invoice_no.'</td>
				 </tr>
			';
			$get_payment_detail = $this->payment->get_payment_detail($bill,$customer_id);
			if(!empty($get_payment_detail))
			{
				$total_amount = 0;
				$total_swit_amount = 0;
				foreach($get_payment_detail as $payment_row)
				{
					$str .= ' 
					<tr>
						<td>'.$no.'</td>
						<td>'.date('d/m/Y',strtotime($payment_row->date)).'</td>
						<td>'.$payment_row->swift_amount.'</td>
						<td>'.$payment_row->paid_amount.'</td>
						<td>'.$payment_row->exchange_rate.'</td>
						<td>'.($payment_row->paid_amount * $payment_row->exchange_rate).'</td>
					</tr>
				';
					$total_amount = $payment_row->paid_amount;
					$total_swit_amount = $payment_row->swift_amount;
					$no++;
				}
			}
			else
			{
				$str .= ' 
				<tr>
					<td class="text-center" colspan="6">No Payment Found</td>
				 </tr>
				';
			}
			$str .= ' 
				<tr>
					<td  colspan="3">Total Invoice Amount : '.$billdata->grand_total.'</td>
					<td  colspan="3">Payment Received From Client : '.$total_amount.'  SWift Copy Amount Total : '.$total_swit_amount.'</td>
				 </tr>
				 <tr>
					<td   colspan="3">Pending Payment from Client</td>
					<td   colspan="3">'.($billdata->grand_total - $total_amount).'</td>
				 </tr>
				';
		}
		$str .= '</table>';
		echo $str;
	}
	public function getdueamount($id)
	{
		 
		$resultdata=$this->payment->get_due_amount($id,'1990-01-01','2050-01-01'); 
		$grand_total = $resultdata->grand_total;
		if($resultdata->calculation_operator == 2)
		{
			$grand_total += $resultdata->certification_charge;
			$grand_total += $resultdata->seafright_charge;
			$grand_total += $resultdata->seafright_charge;
		}
		$paid_amt = $resultdata->total_paid_amt +  $resultdata->kasar_amt;
		return  $grand_total - $paid_amt;
	}

	 
}
?>