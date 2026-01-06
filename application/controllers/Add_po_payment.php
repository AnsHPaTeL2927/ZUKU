<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_po_payment extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		  
		$this->load->model('PO_payment_model','payment');
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
			$data['company_detail'] 			= $this->admin_company_detail->s_select();	
			$data['suppiler_list'] 				= $this->payment->get_suppiler();	
			$data['payment_mode_list'] 			= $this->payment->get_payment_mode();	
			$data['bank_list']	 				= $this->payment->get_bank_detail();	
			
			$data['mode']						= "Add";
			$data['menu_data']					= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/add_po_payment',$data);	
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
			$data['suppiler_list'] 		= $this->payment->get_suppiler();	
			$data['payment_mode_list'] 	= $this->payment->get_payment_mode();	
			$data['bank_list']	 		= $this->payment->get_bank_detail();	
			$data['payment_detail']	 	= $this->payment->getpayment_detail($paymentid);	
			$data['mode']				= "Add";
			$data['receive_payment_part_list']	= $this->payment->get_receive_payment_part();	
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/add_po_payment',$data);	
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }			
	}
	public function manage()
	{
		 
			$data=array(
						'payment_date' 			=> date('Y-m-d',strtotime($this->input->post('date'))),
						'payment_mode_id' 		=> $this->input->post('payment_mode_id'),
						'seller_id' 			=> $this->input->post('supplier_id'),
						'paid_amount' 			=> $this->input->post('total_paid_amount'),
				 	 	'refernace_no' 		 	=> $this->input->post('refernace_no'),
						'remarks'		 		=> nl2br($this->input->post('remarks')),
						'status'				=> 0,
						'cdate'					=> date('Y-m-d H:i:s')
				);
				$row = array();
			$po_payment_id = $this->input->post('po_payment_id');
			if(!empty($po_payment_id))
			{
						$updateid = $this->payment->update_payment($data,$po_payment_id);
					 	$deleteid = $this->payment->delete_trn_payment($po_payment_id);
				$no=0;
				$n=1;
				 
				foreach($this->input->post('purchase_order_id') as $purrow)
				{
					if($this->input->post('paid_amount')[$no] > 0)
					{
						$packing_data = array(
							"po_payment_id"	 		 => $po_payment_id,
							"purchase_order_id"	 	 => $purrow,
							"seller_id" 			 => $this->input->post('supplier_id'),
							"bill_paid_amount" 		 => $this->input->post('paid_amount')[$no],
							'status'				 => 0, 
							'cdate'					 => date('Y-m-d H:i:s')
						);
						 
						$insertrecord = $this->payment->insert_po_payment_trn($packing_data);
						$no1 = 0;
						
						foreach($this->input->post('receive_payment_part_id'.$n) as $purtrnrow)
						{
							if($this->input->post('receive_amount'.$n)[$no1] > 0)
							{
								$packing_trn_data = array(
									"receive_payment_part_id"	 => $purtrnrow,
									"table_name"	 			 => 'tbl_po_payment',
									"table_main_id" 			 => $po_payment_id,
									"table_trn_id" 				 => $insertrecord,
									"amount" 					 => $this->input->post('receive_amount'.$n)[$no1],
									'status'				 	 => 0, 
									'cdate'					 	 => date('Y-m-d H:i:s')
								);
							$receive_payment_part_id = $this->payment->insert_receive_payment_part_trn($packing_trn_data);
							}
							$no1++;
						}
						
					}
					$no++;
					$n++;
				}
				
					if($updateid)
					{
						$row['res'] = 2;
					}
					else{
						$row['res'] = 0;
					}
			}
			else
			{
				$insertid = $this->payment->insert_payment($data);
				$no=0;
				$n=1;
				 
				foreach($this->input->post('purchase_order_id') as $purrow)
				{
					if($this->input->post('paid_amount')[$no] > 0)
					{
						$packing_data = array(
							"po_payment_id"	 		 => $insertid,
							"purchase_order_id"	 	 => $purrow,
							"seller_id" 			 => $this->input->post('supplier_id'),
							"bill_paid_amount" 		 => $this->input->post('paid_amount')[$no],
							'status'				 => 0, 
							'cdate'					 => date('Y-m-d H:i:s')
						);
						 
						$insertrecord = $this->payment->insert_po_payment_trn($packing_data);
						$no1 = 0;
						
						foreach($this->input->post('receive_payment_part_id'.$n) as $purtrnrow)
						{
							if($this->input->post('receive_amount'.$n)[$no1] > 0)
							{
								$packing_trn_data = array(
									"receive_payment_part_id"	 => $purtrnrow,
									"table_name"	 			 => 'tbl_po_payment',
									"table_main_id" 			 => $insertid,
									"table_trn_id" 				 => $insertrecord,
									"amount" 					 => $this->input->post('receive_amount'.$n)[$no1],
									'status'				 	 => 0, 
									'cdate'					 	 => date('Y-m-d H:i:s')
								);
							$receive_payment_part_id = $this->payment->insert_receive_payment_part_trn($packing_trn_data);
							}
							$no1++;
						}
						
					}
					$no++;
					$n++;
				}
				
				if($insertid)
				{
					$row['res'] = 1;
				}
				else{
					$row['res'] = 0;
				}
			}
		
			
		   echo json_encode($row);
		
	}	
 	public function get_bill()
	{
	 	$id 			= $this->input->post('id');
		$resultdata		= $this->payment->get_due_bill($id); 
		$receive_payment_part_list = $this->payment->get_receive_payment_part();
		 $str = '<table class="table table-bordered" style="width:100%">
					<tr>
						<td>Sr no</td>
						<td>PO NO</td>
						<td>Total Amount</td>
						<td>Due Amount</td>
						<td>Paid Amount</td>';
				foreach($receive_payment_part_list as $receive_row)
				{		
					$str .= '<td>'.$receive_row->receive_payment_part_name.'</td>';
				}
				
			$str .= '<td>Pending Amount</td>
				</tr>';
		if(!empty($resultdata))
		{
			$no =1;
			foreach($resultdata as $row)
			{
				$due_amt = $row->grand_total - $row->paid_amount;
				 
				$str .= '<tr>
							<td>'.$no.'</td>
							<td>'.$row->purchase_order_no.'</td>
							<td>'.$row->grand_total.'</td>
							<td>'.$due_amt.'</td>
							<td>
								 <input type="text" name="paid_amount[]" id="paid_amount'.$no.'" class="form-control" placeholder="Paid Amount"   title="Enter Paid Amount" onchange="cal_total();calc_pending('.$no.')" onkeyup="cal_total();calc_pending('.$no.')" autocomplete="off" />
							</td>';
				foreach($receive_payment_part_list as $receive_row)
				{
						$str .= '<td>
									<input type="text" name="receive_amount'.$no.'[]" id="receive_amount'.$receive_row->receive_payment_part_id.$no.'" class="form-control" placeholder="'.$receive_row->receive_payment_part_name.'"    onchange="calc_pending('.$no.')" onkeyup="calc_pending('.$no.')" autocomplete="off" />
								</td>
								<input type="hidden" name="receive_payment_part_id'.$no.'[]" id="receive_payment_part_id'.$receive_row->receive_payment_part_id.$no.'" value="'.$receive_row->receive_payment_part_id.'"/>
								 
								';
								
				}			
							$str .= '<td id="pending_html'.$no.'">
								  '.$due_amt.'
							</td>
							 <input type="hidden" name="grand_total[]" id="grand_total'.$no.'" value="'.$due_amt.'"/>
							 <input type="hidden" name="purchase_order_id[]" id="purchase_order_id'.$no.'" value="'.$row->purchase_order_id.'"/>
					</tr>
					';
					$no++;
			}
		}
		else
		{
			$str .= '<tr>
						<td colspan="7" class="text-center">No Due Bills Find</td>
					</tr>
					';
		}
		$str .= '</tr>
				</table>';
		echo $str;
	}

	 
}
?>