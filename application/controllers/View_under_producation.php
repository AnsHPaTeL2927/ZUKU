<?php 

defined("BASEPATH") or exit("no dericet script allowed"); 

class View_under_producation extends CI_controller{

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
			
			$this->load->view('admin/view_under_producation',$data);	
		}
		else
		{
			redirect(base_url().'');

		 }			

	}
	public function view_pdf()
 	{
		$this->load->view('admin/view_under_production_pdf');
	}
	public function view_report()
	{
		$customer_id	= $this->input->post('customer_id');
		$finish_id		= $this->input->post('finish_id');
		$size_id		= $this->input->post('size_id');
		$pallet_type	= $this->input->post('pallet_type');
		$invoicedate 	= explode(" - ",$this->input->post('daterange'));
		
		$resultdata		=	$this->order->get_under_product($customer_id,$finish_id,$size_id,$pallet_type,$invoicedate[0],$invoicedate[1]);
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th colspan="10" class="text-center">Under Producation</th>
						</tr>
						<tr>
							<th>Sr No</th>
							<th>Performa Invoice No</th>
							<th>Supplier Name</th>
							<th>Size</th>
							<th>Design</th>
							<th>Finish</th>
							<th>Pallet Type</th>
							<th>Boxes</th>
							<th>SQM</th>
							<th>Amount</th>
						</tr>';
			 
						$no=1;
					$total_box = 0;	 	
					$total_sqm = 0;	 	
					$total_amout = 0;
	
				$packingtrn_array = array();				
				$packingtrnarray = array();				
		foreach($resultdata as $row)
		{
			$set_container		= 	$this->order->product_mst_set_data($row->production_mst_id,-1);
			for($i=0; $i<count($set_container);$i++)
			{
				if(!in_array($set_container[$i]->performa_packing_id,$packingtrn_array))
				{
					array_push($packingtrn_array,$set_container[$i]->performa_packing_id);
					$packingtrnarray[$set_container[$i]->performa_packing_id] = array();
				 	$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_boxes']  =$set_container[$i]->origanal_boxes;
			 	}
				else
				{
				 	$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
				}
			}
			 
			if($packingtrnarray[$row->performa_packing_id]["no_of_boxes"] < $row->no_of_boxes) 
			{
				$remaining_box = $row->no_of_boxes - $packingtrnarray[$row->performa_packing_id]["no_of_boxes"];
				$remaining_sqm = $row->no_of_sqm - $packingtrnarray[$row->performa_packing_id]["no_of_sqm"];
				$desc= !empty($row->size)?$row->size:$row->description_goods;
				$per_value = $row->per;	
				$no_of_boxes	= 	$remaining_box;		
				$no_of_sqf		= 	$remaining_sqm;	
				if($row->per == "BOX" && $row->product_id == 0)
				{
					  $no_of_boxes = $row->no_of_boxes;
					   $no_of_sqf = 0;
				}
				else if($row->per == "SQF" && $row->product_id == 0)
				{
					  $no_of_boxes =0;
					  $no_of_sqf = $row->no_of_boxes;
				}
			$str .= '<tr>
							<td>'.$no.'</td>
							<td>'.$row->invoice_no.'</td>
							<td>'.$row->supplier_name.'</td>
							<td>'.$desc.'</td>
							<td>'.$row->model_name.'</td>
							<td>'.$row->finish_name.'</td>
							<td>'.$row->pallet_type_name.'</td>
							<td>'.$no_of_boxes.'</td>
							<td>'.number_format($no_of_sqf,2,'.','').'</td>
							<td>'.number_format($row->grand_total,2,'.','').'</td>
					</tr>';
					$total_box 		+= $no_of_boxes;	 	
					$total_sqm 		+= $row->no_of_sqm;	 	
					$total_amout 	+= $row->grand_total;
						$no++;
			  }
						 
		}
		$str .= ' 
				<tr>
							<th colspan="7" style="text-align:right"> Total </th>
							<th>'.$total_box.'</th>
							<th>'.number_format($total_sqm,2,'.','').'</th>
							<th>'.number_format($total_amout,2,'.','').'</th>
					</tr>
				</table>
				</div>';
			$_SESSION['viewunderproduction'] = $str;
		echo $str;
	}
	
}

?>