<?php 

defined("BASEPATH") or exit("no dericet script allowed"); 

class Proforma_register extends CI_controller{

	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Performa_model','performa');
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
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['customer_list'] 		= $this->performa->get_customer();	
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/proforma_register',$data);	
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
	 	$invoicedate 	= explode(" - ",$this->input->post('daterange'));
		
		$resultdata		=	$this->performa->get_confirm_performa($customer_id,$invoicedate[0],$invoicedate[1]);
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th colspan="16" class="text-center">Proforma Register</th>
						</tr>
						<tr>
							<th class="text-center" width="2%">Sr No</th>
							<th class="text-center" width="8%">PI number </th>
							<th class="text-center" width="5%">PI Date</th>
							<th class="text-center" width="8%">Consignee Name</th>
							<th class="text-center" width="5%">Notify Party</th>
							<th class="text-center" width="6%">Country</th>
							<th class="text-center" width="6%">POD</th>
							<th class="text-center" width="8%">Payment Terms</th>
							<!--<th class="text-center" width="3%">Container </th>-->
							<th class="text-center" width="5%">Size </th>
							<th class="text-center" width="8%">Design </th>
							<th class="text-center" width="5%">finish </th>
						 	<th class="text-center" width="4%">Pallet </th>
							<th class="text-center" width="4%">Box  </th>
							<th class="text-center" width="4%">Sqm </th>
							<th class="text-center" width="4%">Amount </th>
							<th class="text-center" width="4%">Freight  </th>
							<th class="text-center" width="7%">Grand Total  </th>
						</tr>';
			 
						$no=1;
					$total_box = 0;	 	
					$total_sqm = 0;	 	
					$total_amout = 0;
	
				$packingtrn_array = array();				
		foreach($resultdata as $row)
		{
			//$set_container		= 	$this->order->product_set_data($row->performa_invoice_id,-1);
			 
			  
				 
			$str .= '<tr>
							<td class="text-center">'.$no.'</td>
							<td class="text-center">'.$row->invoice_no.'</td>
							<td class="text-center">'.date("d/m/Y",strtotime($row->performa_date)).'</td>
							<td class="text-center">'.$row->c_companyname.'</td>
							<td class="text-center">'.$row->notify_name.'</td>
							<td class="text-center">'.$row->country_final_destination.'</td>
							<td class="text-center">'.$row->port_of_discharge.'</td>
							<td class="text-center">'.$row->payment_terms.'</td>
							<!--<td class="text-center">'.$row->container_details.'</td>-->
							<td class="text-center">'.$row->size_type_mm.'</td>
							<td class="text-center">'.$row->model_name.'</td>
							<td class="text-center">'.$row->finish_name.'</td>
					 		<td class="text-center">'.$row->all_no_of_pallet.'</td>
					 		<td class="text-center">'.$row->all_no_of_boxes.'</td>
							<td class="text-center">'.number_format($row->all_no_of_sqm,2,'.','').'</td>
							<td class="text-center">'.number_format($row->all_product_amt,2,'.','').'</td>
							<td class="text-center">'.number_format($row->seafright_charge,2,'.','').'</td>
							<td class="text-center">'.number_format($row->grand_total,2,'.','').'</td>
					</tr>';
					$total_box 		+= $no_of_boxes;	 	
					$total_sqm 		+= $row->no_of_sqm;	 	
					$total_amout 	+= $row->grand_total;
						$no++;
			  
						 
		}
		$str .= ' 
				 
				</table>
				</div>';
		echo $str;
	}
	
}

?>