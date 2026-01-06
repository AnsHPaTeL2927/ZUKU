<?php 

defined("BASEPATH") or exit("no dericet script allowed"); 

class Export_register extends CI_controller{

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
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['customer_list'] 		= $this->export->get_customer();	
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/export_register',$data);	
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
	 	$resultdata		=	$this->export->get_export($customer_id,$invoicedate[0],$invoicedate[1]);
		$str = '<div class="table-responsive" >
					<table class="table table-bordered table-hover" >
						<tr>
							<th colspan="30" class="text-center">Export Register</th>
						</tr>
						<tr>
							<th class="text-center">Sr No</th>
							<th class="text-center">Consignee Name</th>
							<th class="text-center">Notify Party</th>
							<th class="text-center">Country</th>
							<th class="text-center">POD</th>
							<th class="text-center">PI number </th>
							<th class="text-center">Invoice Number </th>
							<th class="text-center">Date </th>
							<th class="text-center">Factory  </th>
							<th class="text-center">Product Name  </th>
							<th class="text-center">SIZE  </th>
						 	<th class="text-center">Payment Terms </th>
							<th class="text-center">Due Date  </th>
							<th class="text-center">Container  </th>
							<th class="text-center">Pallet  </th>
							<th class="text-center">Box   </th>
							<th class="text-center">Sqm </th>
							<th class="text-center">Nt Wt </th>
							<th class="text-center">Gr Wt </th>
							<th class="text-center">Amount  </th>
							<th class="text-center">Discount  </th>
							<th class="text-center">Freight   </th>
							<th class="text-center">Grand Total    </th>
							<th class="text-center">Ex. Rate   </th>
							<th class="text-center">DBK  </th>
							<th class="text-center">DBK Received Date  </th>
							<th class="text-center">SB No  </th>
							<th class="text-center">SB Date   </th>
							<th class="text-center">BL No  </th>
							<th class="text-center">BL date</th>
						</tr>';
			 
						$no=1;
					$total_box = 0;	 	
					$total_sqm = 0;	 	
					$total_amout = 0;
	 			 			
		foreach($resultdata as $row)
		{
			//$set_container		= 	$this->order->product_set_data($row->performa_invoice_id,-1);
			$s_date = '';
				$s_date_array = array();
			 if($row->s_date != "1970-01-01")
			 {
				$s_date = explode(",",$row->s_date);
			
				for($sd=0;$sd<count($s_date);$sd++)
				{
					if(!empty($s_date[$sd]) && $s_date[$sd] != "1970-01-01")
					{
						array_push($s_date_array,date('d/m/Y',strtotime($s_date[$sd])));
					}
				}
			 }
			$bl_date = '';
			$bl_date_array = array();
			 if($row->bl_date != "1970-01-01")
			 {
				$bl_date = explode(",",$row->bl_date);
				
				for($bl=0;$bl<count($bl_date);$bl++)
				{
					if(!empty($bl_date[$bl]) && $s_date[$sd] != "1970-01-01")
					{
						array_push($bl_date_array,date('d/m/Y',strtotime($bl_date[$bl])));
					}
				} 
			 }
				 $received_date = (!empty($row->received_date) && $row->received_date != '1970-01-01' && $row->received_date != '0000-00-00')?date("d/m/Y",strtotime($row->received_date)):'';
			$str .= '<tr>
							<td class="text-center">'.$no.'</td>
							<td class="text-center">'.$row->c_companyname.'</td>
							<td class="text-center">'.$row->notify_name.'</td>
							<td class="text-center">'.$row->country_final_destination.'</td>
							<td class="text-center">'.$row->port_of_discharge.'</td>
							<td class="text-center">'.$row->performa_invoice_no.'</td>
							<td class="text-center">'.$row->export_invoice_no.'</td>
							<td class="text-center">'.date("d/m/Y",strtotime($row->invoice_date)).'</td>
							<td class="text-center">'.$row->factory_name.'</td>
							<td class="text-center">'.$row->product_name.'</td>
							<td class="text-center">'.$row->size.'</td>
							<td class="text-center">'.$row->payment_terms.'</td>
							<td class="text-center"> </td>
							<td class="text-center">'.$row->container_details.'</td>
							<td class="text-center">'.$row->all_no_of_pallet.'</td>
							<td class="text-center">'.$row->all_no_of_boxes.'</td>
							<td class="text-center">'.number_format($row->all_no_of_sqm,2,'.','').'</td>
							<td class="text-center">'.$row->net_weight.'</td>
							<td class="text-center">'.$row->gross_weight.'</td>
					 		<td class="text-center">'.number_format($row->all_product_amt,2,'.','').'</td>
					 		<td class="text-center">'.number_format($row->discount,2,'.','').'</td>
					 		<td class="text-center">'.number_format($row->seafright_charge,2,'.','').'</td>
							<td class="text-center">'.number_format($row->grand_total,2,'.','').'</td>
							<td class="text-center">'.number_format($row->Exchange_Rate_val,2,'.','').'</td>
							<td class="text-center">'.number_format($row->drawback_amount,2,'.','').'</td>
							<td class="text-center">'.$received_date.' </td>
							<td class="text-center">'.$row->s_bill_no.' </td>
							<td class="text-center">'.implode(",",$s_date_array).' </td>
							<td class="text-center">'.$row->bl_no.' </td>
							<td class="text-center">'.implode(",",$bl_date_array).' </td>
							 
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