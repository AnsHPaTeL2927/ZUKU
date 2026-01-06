<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 

class View_order_loaded extends CI_controller{

	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Order_report_model','order');
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
			$data['customer_list'] 		= $this->order->get_customer();	
			$data['size_list'] 			= $this->order->get_size();	
			$data['get_pallet_type'] 	= $this->order->get_pallet_type();	
			$data['finish_list'] 		= $this->order->get_finish();	
			$data['menu_data']	 		= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/view_order_loaded',$data);	
		}
		else
		{
			redirect(base_url().'');

		 }			

	}
	public function view_pdf()
 	{
		$this->load->view('admin/view_order_loaded_pdf');
	}
	public function view_report()
	{
		$customer_id	= $this->input->post('customer_id');
		$finish_id		= $this->input->post('finish_id');
		$size_id		= $this->input->post('size_id');
		$pallet_type	= $this->input->post('pallet_type');
		$invoicedate 	= explode(" - ",$this->input->post('daterange'));
		
		$resultdata		=	$this->order->get_order_loaded($customer_id,$finish_id,$size_id,$pallet_type,$invoicedate[0],$invoicedate[1]);
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th colspan="9" class="text-center">View Produced</th>
						</tr>
						<tr>
							<th>Sr No</th>
							<th>Performa Invoice No</th>
							<th>Export Invoice No</th>
							<th>Consinee Name</th>
							<th>Size</th>
							<th>Design</th>
							<th>Finish</th>
							<th>Pallet Type</th>
							<th>Boxes</th>
							<th>SQM</th>
					 	</tr>';
			 
						$no=1;
					$total_box = 0;	 	
					$total_sqm = 0;	 	
					$total_amout = 0;
	
				$packingtrn_array = array();				
				$packingtrnarray = array();				
		foreach($resultdata as $row)
		{
			 $desc= !empty($row->size)?$row->size:$row->description_goods;
			$str .= '<tr>
							<td>'.$no.'</td>
							<td>'.$row->invoice_no.'</td>
							<td>'.$row->export_invoice_no.'</td>
							<td>'.$row->c_companyname.'</td>
							<td>'.$desc.'</td>
							<td>'.$row->model_name.'</td>
							<td>'.$row->finish_name.'</td>
							<td>'.$row->pallet_type_name.'</td>
							<td>'.$row->origanal_boxes.'</td>
							<td>'.number_format($row->no_ofsqm,2,'.','').'</td>
							 
					</tr>';
					$total_box 		+= $row->origanal_boxes;	 	
					$total_sqm 		+= $row->no_ofsqm;	 	
					 
						$no++;
	 	}
		$str .= ' 
				<tr>
							<th colspan="8" style="text-align:right"> Total </th>
							<th>'.$total_box.'</th>
							<th>'.number_format($total_sqm,2,'.','').'</th>
						 
					</tr>
				</table>
				</div>';
			$_SESSION['vieworderloaded'] = $str;
		echo $str;
	}
	
}

?>