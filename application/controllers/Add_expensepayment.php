<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_expensepayment extends CI_controller{
	
	
	public function __construct(){
		parent:: __construct();
		 $this->load->model('Expense_model','expense');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['payment_mode_list'] 	= $this->expense->get_payment_mode();	  
			$data['export_data']		= $this->expense->get_export_invoice();
			$data['expense_party']		= $this->expense->get_expenseparty(0);
			 
			$data['mode']				= "Add";
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/add_expensepayment',$data);	
		}
		else
		{
		 	redirect(base_url().'');
		}	
	}
	 public function edit($expense_id)
	{
		 if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['payment_mode_list'] 	= $this->expense->get_payment_mode();	  
			 
	 		$data['expense_data']		= $this->expense->get_expensepaymentdata($expense_id);
			 
			$data['expense_party']		= $this->expense->get_expenseparty(0);
			 
			$data['mode']				= "Edit";
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/add_expensepayment',$data);	
		}
		else
		{
			
			redirect(base_url().'');
		}	
	}
	public function manage()
	{ 
		$data=array(
					'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
					'expense_party_id' 		=> $this->input->post('expense_party_id'),
					'payment_type' 			=> $this->input->post('payment_type'),
					'payment_mode_id' 		=> $this->input->post('payment_mode_id'),
					'total_paid_amount' 	=> $this->input->post('total_paid_amount'),
					'total_kasar_amt' 		=> $this->input->post('total_kasar_amt'),
					'total_tds_amt' 		=> $this->input->post('total_tds_amt'),
					'refernace_no' 		 	=> $this->input->post('refernace_no'),
				  	'remarks'		 		=> nl2br($this->input->post('remarks')),
			 		'cdate'					=> date('Y-m-d H:i:s')
			);
				if($_FILES['expensepayment_file']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['expensepayment_file']['name']));
					$config['file_name'] = 'expensepayment_file'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/payment/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('expensepayment_file');
					$upload_image = $this->upload->data();
					$expense_payment_file  = $upload_image['file_name'];
					$data['expensepayment_file'] = $expense_payment_file;
				}
			$expense_payment_id = $this->input->post('expense_payment_id');
			if(!empty($expense_payment_id))
			{
				$rdata = $this->expense->update_expense_payment($expense_payment_id,$data);
				$deleteid = $this->expense->delete_expense_payment($expense_payment_id);
						 
				$no=0;
				foreach($this->input->post('expense_id') as $expenserow)
				{
					if($this->input->post('paid_amount')[$no] > 0)
					{
						$expense_payment_data = array(
							"expense_id"	 		=> $expenserow,
							"paid_amount"	 		=> $this->input->post('paid_amount')[$no],
							"kasar_amount" 			=> $this->input->post('kasar_amount')[$no],
							"tds_per" 				=> $this->input->post('tds_per')[$no],
							"tds_amount" 			=> $this->input->post('tds_amount')[$no],
						 	'expense_payment_id' 	=> $expense_payment_id, 
							'status'				=> 0 
						);
						 
						$insertrecord = $this->expense->insert_expense_payment_trn($expense_payment_data);
						$no1 = 0;
						
						 
					}
					$no++;
					 
				}
				if($rdata)
				{
					$row['res'] = 2;
				}
				else{
					$row['res'] = 0;
				}
		 	}
			else
			{
				$rdata = $this->expense->insert_expense_payment($data);
				$no=0;
				foreach($this->input->post('expense_id') as $expenserow)
				{
					if($this->input->post('paid_amount')[$no] > 0)
					{
						$expense_payment_data = array(
							"expense_id"	 		=> $expenserow,
							"paid_amount"	 		=> $this->input->post('paid_amount')[$no],
							"kasar_amount" 			=> $this->input->post('kasar_amount')[$no],
							"tds_per" 				=> $this->input->post('tds_per')[$no],
							"tds_amount" 			=> $this->input->post('tds_amount')[$no],
						 	'expense_payment_id' 	=> $rdata, 
							'status'				=> 0 
						);
						 
						$insertrecord = $this->expense->insert_expense_payment_trn($expense_payment_data);
						$no1 = 0;
						
						 
					}
					$no++;
					 
				}		
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
	public function get_expenses_bill()
	{
		$id 			= $this->input->post('expense_party_id');
		 $str = '<table class="table table-bordered" style="width:100%">
					<tr>
						<td>Sr no</td>
						<td>Expense Referance No</td>
						<td>Amount</td>
						<td>Total Amount (With GST)</td>
						<td>Due Amount</td>
						<td>Paid Amount</td> 
						<td>Kasar Amount</td>
						<td>TDS (%)</td>
						<td>TDS (INR)</td>
						<td>Pending Amount</td>
				</tr>';
		$expense_payment_id = $this->input->post('expense_payment_id');		
		if(!empty($expense_payment_id))
		{
			$resultdata		= $this->expense->get_due_bill($id); 
			if(!empty($resultdata))
			{
			$no =1;
			 
					foreach($resultdata as $row)
					{
						
						$get_expension_payment =  $this->expense->get_due_bill_edit($row->expense_id,$expense_payment_id); 
						$due_amt = ($get_expension_payment->paid_amount + $get_expension_payment->kasar_amount) + ($row->total_amt - $row->paid_amount -  $row->tds_amount);
						$due_amt1 =  ($row->total_amt - $row->paid_amount -  $row->tds_amount);
						if($due_amt > 0)
						{
						$str .= '<tr>
									<td>'.$no.'</td>
									<td>'.$row->reference_no.'</td>
									<td>'.$row->amount.'</td>
									<td>'.$row->total_amt.'</td>
									<td>'.$due_amt.'</td>
									<td>
										<input type="text" name="paid_amount[]" id="paid_amount'.$no.'" class="form-control" placeholder="Paid Amount"   title="Enter Paid Amount" onchange="calc_pending('.$no.');cal_total();" onkeyup="calc_pending('.$no.');cal_total();" onblur="calc_pending('.$no.');cal_total();" autocomplete="off" value="'.$get_expension_payment->paid_amount.'" />
									</td> 
									<td>
										<input type="text" name="kasar_amount[]" id="kasar_amount'.$no.'" class="form-control" placeholder="Kasar Amount"   title="Enter Paid Amount" onchange="cal_kasar_total();calc_pending('.$no.')" onkeyup="cal_kasar_total();calc_pending('.$no.')" onblur="calc_pending('.$no.');cal_kasar_total();"  autocomplete="off" value="'.$get_expension_payment->kasar_amount.'"  />
									</td> 
									<td>
										<input type="text" name="tds_per[]" id="tds_per'.$no.'" class="form-control" placeholder="TDS(%)"   title="Enter TDS (%)" onchange="cal_tds_total();calc_pending('.$no.')" onkeyup="cal_tds_total();calc_pending('.$no.')" onblur="cal_tds_total();calc_pending('.$no.');"  autocomplete="off" value="'.$get_expension_payment->tds_per.'"  />
									</td> 
									<td>
										<input type="text" name="tds_amount[]" id="tds_amount'.$no.'" class="form-control" placeholder="TDS Amount"   title="Enter Paid Amount" onchange="cal_tds_total();calc_pending('.$no.')" onkeyup="cal_tds_total();calc_pending('.$no.')" onblur="cal_tds_total();calc_pending('.$no.');"  autocomplete="off" value="'.$get_expension_payment->tds_amount.'"    />
									</td>
									<td id="pending_html'.$no.'">
										'.$due_amt1.'
									</td>
									 <input type="hidden" name="without_amt[]" id="without_amt'.$no.'" value="'.$row->amount.'"/>
									<input type="hidden" name="due_amt[]" id="due_amt'.$no.'" value="'.$due_amt.'"/>
									<input type="hidden" name="expense_id[]" id="expense_id'.$no.'" value="'.$row->expense_id.'"/>
							</tr>
							';
							$no++;
						}
						
							
					}
				}
				else
				{
					$str .= '<tr>
								<td colspan="7" class="text-center">No Due Bills Find</td>
							</tr>
							';
				}
				if($no == 1)
				{
				
					$str .= '<tr>
								<td colspan="7" class="text-center">No Due Bills Find</td>
							</tr>
							';
				
				}
		
		}
		else
		{
			$resultdata		= $this->expense->get_due_bill($id); 
	 
		
		if(!empty($resultdata))
		{
			$no =1;
			 
			foreach($resultdata as $row)
			{
				$due_amt = $row->total_amt - $row->paid_amount;
				if($due_amt > 0)
				{
				$str .= '<tr>
							<td>'.$no.'</td>
							<td>'.$row->reference_no.'</td>
							<td>'.$row->amount.'</td>
							<td>'.$row->total_amt.'</td>
						 	<td>'.$due_amt.'</td>
							<td>
								 <input type="text" name="paid_amount[]" id="paid_amount'.$no.'" class="form-control" placeholder="Paid Amount"   title="Enter Paid Amount" onchange="calc_pending('.$no.');cal_total();" onkeyup="calc_pending('.$no.');cal_total();" onblur="calc_pending('.$no.');cal_total();" autocomplete="off" />
							</td> 
							<td>
								 <input type="text" name="kasar_amount[]" id="kasar_amount'.$no.'" class="form-control" placeholder="Kasar Amount"   title="Enter Kasar Amount" onchange="cal_kasar_total();calc_pending('.$no.')" onkeyup="cal_kasar_total();calc_pending('.$no.')" onblur="calc_pending('.$no.');cal_total();"  autocomplete="off" />
							</td> 
							<td>
										<input type="text" name="tds_per[]" id="tds_per'.$no.'" class="form-control" placeholder="TDS(%)"   title="Enter TDS (%)" onchange="cal_tds_total();calc_pending('.$no.')" onkeyup="cal_tds_total();calc_pending('.$no.')" onblur="cal_tds_total();calc_pending('.$no.');"  autocomplete="off" value="'.$get_expension_payment->tds_per.'"  />
									</td> 
									<td>
										<input type="text" name="tds_amount[]" id="tds_amount'.$no.'" class="form-control" placeholder="TDS(INR)"   title="Enter TDS Amount" onchange="cal_tds_total();calc_pending('.$no.')" onkeyup="cal_tds_total();calc_pending('.$no.')" onblur="cal_tds_total();calc_pending('.$no.');"  autocomplete="off" value="'.$get_expension_payment->tds_amount.'"    />
									</td>
							<td id="pending_html'.$no.'">
								  '.$due_amt.'
							</td>
							 <input type="hidden" name="total_amt[]" id="total_amt'.$no.'" value="'.$total_amt.'"/>
							 <input type="hidden" name="without_amt[]" id="without_amt'.$no.'" value="'.$row->amount.'"/>
							 <input type="hidden" name="due_amt[]" id="due_amt'.$no.'" value="'.$due_amt.'"/>
							 <input type="hidden" name="expense_id[]" id="expense_id'.$no.'" value="'.$row->expense_id.'"/>
					</tr>
					';
					$no++;
				}
				
					
			}
		}
		else
		{
			$str .= '<tr>
						<td colspan="7" class="text-center">No Due Bills Find</td>
					</tr>
					';
		}
		if($no == 1)
		{
		 
			$str .= '<tr>
						<td colspan="7" class="text-center">No Due Bills Find</td>
					</tr>
					';
		 
		}
		}
		$str .= '</tr>
				</table>';
		echo $str;
	} 
}
?>