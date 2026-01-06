<?php 

defined("BASEPATH") or exit("no dericet script allowed"); 

class Rex_report extends CI_controller{

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
			
			$this->load->view('admin/rex_report',$data);	
		}
		else
		{
			redirect(base_url().'');

		 }			

	}
	public function view_pdf()
 	{

		$this->load->view('admin/rex_report_pdf');

	}
	
	 
	public function view_report()
	{
		$invoicedate 	= explode(" - ",$this->input->post('daterange'));
		$this->load->model('admin_company_detail');	
			$company_detail	= $this->admin_company_detail->s_select();	
		$resultdata		=	$this->performa->get_commercial_invoice($invoicedate[0],$invoicedate[1]);
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" style="padding:5px;border:1px solid" >
						<tr>
							<th colspan="8" style="border:1px solid"  class="text-center">APPENDIX-III</th>
						</tr>
						<tr>
							<th colspan="8" style="border:1px solid"  class="text-center">SUMMARY OF THE "STATEMENT ON ORIGIN" AS PER DGFT NOTIFICATION</th>
						</tr>
						<tr>
							<th colspan="8" style="border:1px solid">
								Name Of Exporter : '.$company_detail[0]->s_name.'<br>
								REX NUMBER : '.$company_detail[0]->rex_no.'<br>
								Between Dated : '.date('d.m.Y',strtotime($invoicedate[0])).' to '.date('d.m.Y',strtotime($invoicedate[1])).'<br>
								
								
							</th>
						</tr>
						<tr>
							<th class="text-center" style="border:1px solid">Sr No</th>
							<th class="text-center" style="border:1px solid">HS Code </th>
							<th class="text-center" style="border:1px solid">Description</th>
							<th class="text-center" style="border:1px solid">Document NO. & Date which Statement on origin is made</th>
							<th class="text-center" style="border:1px solid">FOB Value(in dollars)</th>
							<th class="text-center" style="border:1px solid">Destination Port</th>
							<th class="text-center" style="border:1px solid">Destination Of Export</th>
							<th class="text-center" style="border:1px solid">Origin Criteria P/W followed by HS Code (4 digit)</th>
					 	</tr>';
			 
						$no=1;
					$total_box = 0;	 	
					$total_sqm = 0;	 	
					$total_amout = 0;
	
				$hsnc_code_array = array();				
		foreach($resultdata as $row)
		{
			//$set_container		= 	$this->order->product_set_data($row->performa_invoice_id,-1);
			 
			  $rowspan_no = ($row->rowspan_no>1)?$row->rowspan_no:'';
				 
			$str .= '<tr>
							<td style="border:1px solid" class="text-center">'.$no.'</td>
							<td style="border:1px solid" class="text-center">'.$row->hsnc_code.'</td>
							<td style="border:1px solid" class="text-center">'.$row->series_name.'</td>';
					if(!in_array($row->customer_invoice_no,$hsnc_code_array))
					{						
						$str .= '<td style="border:1px solid" class="text-center" rowspan="'. $rowspan_no .'">'.$row->customer_invoice_no.' <br> '.date("d/m/Y",strtotime($row->invoice_date)).'</td>
							<td style="border:1px solid" class="text-center" rowspan="'.$rowspan_no.'">'.number_format($row->grand_total,2,'.','').'</td>
							<td style="border:1px solid" class="text-center" rowspan="'.$rowspan_no.'">'.$row->port_of_discharge.'</td>
							<td style="border:1px solid" class="text-center" rowspan="'.$rowspan_no.'">'.$row->final_destination.'</td>';
							array_push($hsnc_code_array,$row->customer_invoice_no);
					}
			$str .= '	<td style="border:1px solid" class="text-center">W (6907) '.str_pad(substr($row->cust_hsnc_code, -4), strlen($row->cust_hsnc_code), ' ', STR_PAD_LEFT).'</td>
							 
					</tr>';
					$total_box 		+= $no_of_boxes;	 	
					$total_sqm 		+= $row->no_of_sqm;	 	
					$total_amout 	+= $row->grand_total;
						$no++;
			  
						 
		}
		$str .= ' 
				 <tr>
							<th colspan="8" style="border:1px solid;text-align:right">
								  '.strtoupper($company_detail[0]->name_officer).'<br>
							   
								
							</th>
						</tr>
				</table>
				</div>';
			$_SESSION['rex_report'] = $str;	
		echo $str;
	}
	
}

?>