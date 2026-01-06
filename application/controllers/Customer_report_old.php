<?php 

defined("BASEPATH") or exit("no dericet script allowed"); 

class Customer_report extends CI_controller{

	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Payment_list_model_old','payment');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) 
		{
			redirect(base_url());
		}
	}	
 	public function index()
 	{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['customer_list'] = $this->payment->get_customer();	
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/customer_report_old',$data);	
		}
		else
		{
			redirect(base_url().'');

		 }			

	}
	public function view_pdf()
 	{

		$this->load->view('admin/customer_report_pdf');

	}
	
	public function customerreport()
	{
		$id= $this->input->post('customer_id');
		$resultdata=$this->payment->get_customer_statement($id);
		
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" width="100%">
						<tr>
							<th>Sr No</th>
							<th>Name Of Buyer</th>
							<th>Bal. Amount</th>
						</tr>';
						$no=1;
						$total = 0;
			$bal = 0;			
		foreach($resultdata as $row)
		{
			$bal = ($row->open_balance_status == 1)? ($bal + $row->opening_balance):($bal - $row->opening_balance);
			$bal = $row->grand_total - ($row->paid_amount + $row->bank_charge + $row->total_kasar_amt);
			if($row->open_balance_status == 1)
			{
				$bal -= $row->opening_balance;
			}
			else if($row->open_balance_status == 2)
			{
				$bal += $row->opening_balance;
			}
			$currency_symbol =  "$";
			if($row->currency_id==2)
			{
				$currency_symbol =  "&euro;";
			}
			 
			$str .= '<tr>
							<td>'.$no.'</td>
							<td><a href="'.base_url().'customerreport/index/'.$row->id.'" > '.$row->c_companyname.'</td>
							<td> '.$currency_symbol.' '.indian_number($bal,2).'</td>
						</tr>';
						$no++;
						$total += $bal;
		}
		$str .= '<tr>
					<th colspan="2" style="text-align:right">Total</th>
					<th>'.$currency_symbol.' '.indian_number($total,2).'</th>
				</tr>
				</table>
				</div>';
				$_SESSION['customer_report'] = $str;
		echo $str;
	}
	
	public function view_report()
 	{
		
		$this->load->model('admin_company_detail');	
		$company_detail = $this->admin_company_detail->s_select();	

		$pd=$this->input->post('id');

		$date = explode(" - ",$this->input->post('daterange'));

		$custdata=$this->payment->get_customer_detail($pd);
		$currency_symbol =  "$";
			if($custdata->currency_id==2)
			{
				$currency_symbol =  "&euro;";
			}
			 
		$resultdata=$this->payment->get_customer_bill($pd,$date[0],$date[1]);
	
			$balace = 0; 
			if($custdata->open_balance_status == 1)
			{
				$balace -= $custdata->opening_balance;
			}
			else if($custdata->open_balance_status == 2)
			{
				$balace += $custdata->opening_balance;
			}
			$get_opening_blance = $this->payment->get_customer_bill_opening_balance($pd,$date[0]);
			foreach($get_opening_blance as $row_balance)
			{	
				if($row_balance->fromwhere == 1)	
				{	 
					$balace += $row_balance->grand_total;
				}
				else
				{
					$balace -= ($row_balance->grand_total + $row_balance->bank_charge);
				}
			}
			$str = '<div class="table-responsive">

						<table class="table table-bordered table-hover" >
						<tr>
								<th colspan="10" style="text-align:center"> <img src="'.base_url().'upload/'.$company_detail[0]->head_logo.'"   width="100%"/></th>
							</tr>
							<tr>
								<th colspan="10" style="text-align:center">Account Statement of '.date('d-m-Y',strtotime($date[0])).' TO '.date('d-m-Y',strtotime($date[1])).'</th>
							</tr>
							<tr>
								<th colspan="10" style="text-align:center">Customer Name : '.$custdata->c_companyname.'</th>
							</tr>';

		$str .= '<tr>                                                                                               
					<th style="text-align:center">Sr No</th>                                                        
					<th style="text-align:center">Date</th>                                                    
					<th style="text-align:center">Invoice No</th>                                                   
					<th style="text-align:center">Containers</th>                                                   
					<th style="text-align:center">AMOUNT</th>                                                       
				 	<th style="text-align:center">TOTAL PAYMENT</th>                                                
					<th style="text-align:center">CLOSING PAYMENT</th>                                             
					<th style="text-align:center">Outstanding Invoice Amt.</th>                                             
					<th style="text-align:center">Payment Terms</th>	                                            			
					<th style="text-align:center">Due Days</th>
					</tr>
				<tr> 
				
				<th style="text-align:center">1</th>
					<th style="text-align:right" colspan="5">Opening Balance</th>
					<th style="text-align:center">'.$currency_symbol.' '.$balace.'</th>
					<th style="text-align:center"></th>
					<th style="text-align:center"></th>
					<th style="text-align:center"></th>
			 	</tr>
				';

			//$billdata=$this->payment->get_bill_date($pd);

		 $no=2;

		 $export_invoice_id_array = array();
		 $closing_bal = $balace;
		 $total_sqm = 0;
		 $total_fob = 0;
		 $total_certificat_charge = 0;
		 $total_insurance_charge = 0;
		 $total_seafright_charge = 0;
		 $total_grand_total = 0;
		 $total_payment_total = 0;
		 $total_bank_total = 0;
		 $total_all_total = 0;

		 $rowspan = 0;
	 
			foreach($resultdata as $rowbill)
			{	
				 $due_date = '';
						$due_amount = '';		
								$str .= '<tr> 
											<td  style="text-align:center">'.$no.'</td>
											<td  style="text-align:center">'.date('d/m/Y',strtotime($rowbill->date)).'</td>
											
											';
											$payment_terms = '';
											
									if($rowbill->fromwhere == 1)	
									{	
										$check_full_invoice_payment = $this->payment->get_due_amount($rowbill->export_invoice_id,$date[0],$date[1]);
										
										$datetime1 = date('Y-m-d',strtotime($rowbill->date)); 
										$now = time();
										$datediff = $now - strtotime($datetime1);
										$due_date = round($datediff / (60 * 60 * 24));
										$paid_amount = $check_full_invoice_payment->total_paid_amt + $check_full_invoice_payment->kasar_amt;
										$due_amount = $currency_symbol.''.number_format($check_full_invoice_payment->grand_total - $paid_amount,2,'.','');
										 
										 $che = number_format($paid_amount,2,'.','');
										   
										if($check_full_invoice_payment->grand_total <= $che)
										{
											$due_date = 'Paid';
										}
										$closing_bal += $rowbill->grand_total;
										$payment_terms = $rowbill->payment_terms;
										
									$str .= '
											<td  style="text-align:center">
													<a href="'.base_url().'exportinvoiceview/index/'.$rowbill->export_invoice_id.'" target="_blank">'.$rowbill->export_invoice_no.'</a>
											</td>
											<td  style="text-align:center"> '.$rowbill->container_details.'</td>
											<td style="text-align:center"  >'.$currency_symbol.''.$rowbill->grand_total.'</td>
											 	<td style="text-align:center"  > </td>
											 '; 
											 $total_grand_total += $rowbill->grand_total;
								
									}
									else
									{
										$closing_bal -= ($rowbill->grand_total + $rowbill->bank_charge);
										if($rowbill->container_details =="kasar")
										{
											$str .= '<td colspan="2" style="text-align:center">
													  Kasar Of invoice No : '.$rowbill->export_invoice_no.' 
											</td>';
										}
										else
										{
											$str .= '<td colspan="2" style="text-align:center">
													  Bank : '.$rowbill->bank_name.', Payment Mode : '.$rowbill->container_details.'
											</td>';
										}
											$str .= '
											 <td style="text-align:center"  > </td>
										 	 <td style="text-align:center"  >'.$currency_symbol.''. ($rowbill->grand_total + $rowbill->bank_charge).' </td>
											';
											$payment_terms = ''; 
											$total_payment_total +=  $rowbill->grand_total;
											$total_bank_total +=  $rowbill->bank_charge;
											$total_all_total += ($rowbill->grand_total + $rowbill->bank_charge);
									}
								$str .= '		
									<td style="text-align:center" >'.$currency_symbol.''.number_format($closing_bal,2,'.',',').'</td> 
									<td style="text-align:center" >'.$due_amount.'</td> 
									<td style="text-align:center">'.$payment_terms.'</td> 
									<td style="text-align:center">'.$due_date.' </td>
							</tr> ';
			 
		 			$no++;
				
							 

			}
			$total_all_total -= $balace;
				 	$str .= '<tr>
						<td style="text-align:center" > '.$no.'</td>
						<th style="text-align:right" colspan="3"> Total</th>
						 <th style="text-align:center"> '.$currency_symbol.''.$total_grand_total.'</th>
						  <th style="text-align:center"> '.$currency_symbol.''.$total_all_total.'</th>
				 		<td> </td>
						<td> </td>
						<td> </td>
						<td> </td>
					</tr>';
			  

			 

		$str .= '</table>

				</div>';

	 	 $_SESSION['customerreport'] = $str;

		echo $str;

	}	
}

?>