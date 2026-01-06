<?php 

defined("BASEPATH") or exit("no dericet script allowed"); 

class Profit_report extends CI_controller{

	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Export_model','export');
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
			$data['company_detail']		= $this->admin_company_detail->s_select();	
			$data['customer_list'] 		= $this->export->get_customer();	
			$data['country_list'] 		= $this->export->get_country();	
			 $data['menu_data']	 		= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/profit_report',$data);	
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
	
	public function view_report()
	{
		$customer_id	= $this->input->post('customer_id');
		$country_id		= $this->input->post('country_id');
	 	$invoicedate 	= explode(" - ",$this->input->post('daterange'));
		
		$resultdata		=	$this->export->get_profit_report($customer_id,$country_id,$invoicedate[0],$invoicedate[1]);
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th colspan="13" class="text-center">Profit Report</th>
						</tr>
						<tr>
							<th class="text-center">Sr No</th>
							<th class="text-center">Export Invoice No</th>
							<th class="text-center">Consinee Name</th>
							<th class="text-center">Date</th>
							<th class="text-center">Container</th>
							<th class="text-center">Factory Invoice</th>
							<th class="text-center">Expenses</th>
							<th class="text-center">Total Amount</th>
							<th class="text-center">Client Payment</th>
							<th class="text-center">Drawback</th>
							<th class="text-center">RODTEP</th>
							<th class="text-center">Total Receive Amount</th>
							<th class="text-center">Profit Amount</th>
						</tr>';
			 
					$no=1;
					$total_c = 0;	 	
					$total_f = 0;	 	
					$total_o = 0;	 	
					$total_e = 0;	 	
					$total_rp = 0;	 	
					$total_da = 0;	 	
					$total_rd = 0;	 	
					$total_re = 0;	 	
					$total_p = 0;	 	
		foreach($resultdata as $row)
		{
			  $total_exp 	= ($row->factory_payment + $row->other_payment);
			  $total_recive = ($row->receive_payment + $row->drawback_amount + $row->rodtep_amount);
			  $total_profit = ($total_recive - $total_exp);
			$str .= '<tr>
							<td class="text-center">'.$no.'</td>
							<td class="text-center">'.$row->export_invoice_no.'</td>
							<td class="text-center">'.$row->c_companyname.'</td>
							<td class="text-center">'.date('d/m/Y',strtotime($row->invoice_date)).'</td>
							<td style="text-align:center">'.$row->container_details.'</td>
							<td style="text-align:right">'.indian_number($row->factory_payment,0).'</td>
							<td style="text-align:right">'.indian_number($row->other_payment,0).'</td>
							<td style="text-align:right">'.indian_number($total_exp,0).'</td>
							<td style="text-align:right">'.indian_number($row->receive_payment,0).'</td>
							<td style="text-align:right">'.indian_number($row->drawback_amount,0).'</td>
							<td style="text-align:right">'.indian_number($row->rodtep_amount,0).'</td>
							<td style="text-align:right">'.indian_number($total_recive,0).'</td>
							<td style="text-align:right">'.indian_number($total_profit,0).'</td>
					</tr>';
					$total_c 	+= $row->container_details;	 	
					$total_f 	+= $row->factory_payment;	 	
					$total_o 	+= $row->other_payment;	 	
					$total_e 	+= $total_exp;	 	
					$total_rp 	+= $row->receive_payment;	 	
					$total_da 	+= $row->drawback_amount;	 	
					$total_rd 	+= $row->rodtep_amount;	 	
					$total_re 	+= $total_recive;	 	
					$total_p 	+= $total_profit;	 	
				 	$no++;
	 	}
		$str .= ' 
				<tr>
							<th colspan="4" style="text-align:right"> Total </th>
						 	<th  style="text-align:center">'.indian_number($total_c,0).'</th>
							<th  style="text-align:right">'. indian_number($total_f,0).'</th>
							<th  style="text-align:right">'. indian_number($total_o,0).'</th>
							<th  style="text-align:right">'. indian_number($total_e,0).'</th>
							<th  style="text-align:right">'. indian_number($total_rp,0).'</th>
							<th  style="text-align:right">'. indian_number($total_da,0).'</th>
							<th  style="text-align:right">'. indian_number($total_rd,0).'</th>
							<th  style="text-align:right">'. indian_number($total_re,0).'</th>
							<th  style="text-align:right">'. indian_number($total_p,0).'</th>
					</tr>
				</table>
				</div>';
		echo $str;
	}
	
}

?>