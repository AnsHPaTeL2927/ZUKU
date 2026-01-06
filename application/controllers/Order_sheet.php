<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Order_sheet extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Admin_Producation','producation');
		$this->load->model('Admin_pdf');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id'])) {
			redirect(base_url());
		}
	}

	function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
		 	$this->load->model('admin_company_detail');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			 $data = array(
			 	'mode'				=> 'Add',
				'invoicetype'		=> $selectinvoicetype,
				'menu_data'			=> $menu_data,
				'company_detail'	=> $this->admin_company_detail->s_select(),
				'allperforma_size'	=> $this->producation->allperforma_size(),
				'all_finish_data'	=> $this->producation->get_allfinish(),
				'documentdata'		=> $this->producation->documentdata(),
				'boxdesigndata'		=> $this->producation->boxdesigndata(),

				//'producation_data'	=> $this->producation->get_order_sheet($size,$finish_id,$cust_id)
				'producation_data'	=> $this->producation->get_order_sheet($size,$finish_id,$cust_id)
				
			);
			$this->load->view('admin/order_sheet',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	public function get_order_sheet()
	{
		$str = '<div class="table-responsive">
					<table class="table table-bordered  display" id="datatable" width="100%">
						<thead>
							<tr>
								<th style="text-align:center">Sr No</th>
								<th style="text-align:center">Invoice No</th>
								<th style="text-align:center">Consignee Name</th>
								<th style="text-align:center">SIZE</th>
						 		<th style="text-align:center">DESIGN</th>
								<th style="text-align:center">FINISH</th>
								<th style="text-align:center">REQURED QUANTITY BOX</th>
								<th style="text-align:center">PRODUCTION COMPLETE</th>
								<th style="text-align:center">PENDING PRODUCTION</th>
								<!--<th style="text-align:center">LOADING BOX</th>-->
								<th style="text-align:center">
									<a class="tooltips btn btn-primary" data-toggle="tooltip" data-title="ADD PRODUCTION" href="javascript:;" onclick="add_multiple_producation()"><i class="fa fa-plus"></i> </a>
								</th>						
								<th style="text-align:center"></th>
						 	</tr>
						</thead>
						 <tbody> ';
						 $size 		= $this->input->post('size');
						 $finish_id = $this->input->post('finish_id');
						 $cust_id	 = $this->input->post('cust_id');
						 $id = $this->input->post('producation_id');
						 $order_sheet_data = $this->producation->get_order_sheet($size,$finish_id,$cust_id);
			 		    $sr =1;
						if(!empty($order_sheet_data))
						{
							foreach($order_sheet_data as $row)
							{
								if(!empty($row->packing_model_id))
								{
									$production_detail = $this->producation->get_production_data($row->product_id,$row->packing_model_id,$row->finish_id);
									$loading_detail = $this->producation->get_loading_data($row->product_id,$row->packing_model_id,$row->finish_id);
									$export_detail = $this->producation->get_export($row->product_id,$row->packing_model_id,$row->finish_id);						
									$order_boxes 		=  $row->order_boxes - $export_detail->export_boxes;
									$production_boxes 	= ($production_detail->production_boxes > 0)?($production_detail->production_boxes):0;
									$pending_box 		= ($order_boxes - $production_boxes);
									$loading_box 		= ($loading_detail->assign_boxes > 0)?$loading_detail->assign_boxes:0;
									//$dataget			= $this->producation->get_producation($id);
									$dataget = $this->input->post('producation_id');
									$color = ($pending_box == 0)?"#65a465":"";
									$action = '<input type="checkbox" name="allproductation_entry_id[]" id="allproductation_entry_id'.$row->production_mst_id.'" value="'.$row->product_id.'-'.$row->packing_model_id.'-'.$row->finish_id.'-'.$order_boxes.'-'.$production_boxes.'-'.$pending_box.'"   />					

												<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Add Production" href="javascript:;" onclick="add_producation('.$row->product_id.','.$row->packing_model_id.','.$row->finish_id.','.$order_boxes.','.$production_boxes.','.$pending_box.')"><i class="fa fa-plus"></i> </a>  

												<!--<a class="tooltips btn btn-primary" data-toggle="tooltip" data-title="EDIT PRODUCTION" href="javascript:;" onclick="edit_product('.$row->producation_id	.');"><i class="fa fa-edit"></i> </a>-->'
												;
								if($pending_box == 0)
								{
									$action='';
								}
									$str .= '<tr style="background:'.$color.'">

												<td style="text-align:center">'.$sr.'</td>

												<td style="text-align:center">'.$row->producation_no.'</td>

												<td style="text-align:center">'.$row->c_companyname.'</td>

												<!--<td> <a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product1('.$row->producation_mst_id.');">'.$row->size_type_mm.'</a></td>-->

												<td style="text-align:center">'.$row->size_type_mm.'</td>

												<td style="text-align:center">'.$row->model_name.'</td>

												<td style="text-align:center">'.$row->finish_name.'</td>

												<td style="text-align:center">'.$order_boxes.'</td>

												<td style="text-align:center"> '.$production_boxes.'</td>

												<td style="text-align:center">'.$pending_box.'</td>

												<!--<td style="text-align:center">'.$loading_box.'</td>-->			

												<td style="text-align:center">

												'.$action.'</td>';						 

												$str .= '</tr>';
												$sr++;
								}
							}
						}
						else
						{
							$str .= '<tr><td class="text-center" colspan="9">No Data Found</td></tr>';
						}			 

						$str .= '</tbody></table></div>';
						echo $str;
	}

	
	public function fetchsheetdata()
	{
		$id = $this->input->post('id');
		$resultdata=$this->producation->fetchmodeldata($id);
				
		echo json_encode($resultdata);
	}
	
	public function add_producation()
	{
		$product_id 		=  $this->input->post('product_id');
		$packing_model_id 	=  $this->input->post('packing_model_id');
		$finish_id 			=  $this->input->post('finish_id');
		$order_boxes 		=  $this->input->post('order_boxes');
		$production_boxes 	=  $this->input->post('production_boxes');
		$pending_box 		=  $this->input->post('pending_box');
		//$shade_no 			=  $this->input->post('shade_no');
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover display" id="datatable" width="100%">
						<thead> 
							<tr>
								<th style="text-align:center">Sr No</th>
								<th style="text-align:center">Size</th>
						 		<th style="text-align:center">Design</th>
								<th style="text-align:center">Finish</th>
								<th style="text-align:center"> Required Box</th>
								<th style="text-align:center">Already Added Box</th>
								<th style="text-align:center">Pening Box</th>
								<th style="text-align:center">Production Box</th>
								<th style="text-align:center">Batch No</th>
								<th style="text-align:center">Shade No</th>
								<th style="text-align:center">Big Pallet Box</th>
								<th style="text-align:center">Big Pallet</th>
								<th style="text-align:center">Small Pallet Box</th>
								<th style="text-align:center">Small Pallet</th>
					 	 	</tr>
						</thead>
						 <tbody>
						 ';
						 $no = 1;
						 
						 for($i=0;$i<count($product_id);$i++)
						 {
							 //$producationdata = $this->producation->get_producation($id);
							 //$get_producation  = $this->producation->get_producation($shade_no[$i]);
							 $get_size 	 = $this->producation->get_size($product_id[$i]);
							 $get_design = $this->producation->get_design($packing_model_id[$i]);
							 $get_finish = $this->producation->get_finish($finish_id[$i]);
							 
							 $str .= '<tr>
										<td style="text-align:center">'.$no.'</td>
										<td style="text-align:center">'.$get_size->size_type_mm.'</td>
										<td style="text-align:center">'.$get_design->model_name.'</td>
										<td style="text-align:center">'.$get_finish->finish_name.'</td>
										<td style="text-align:center">'.$order_boxes[$i].'</td>
										<td style="text-align:center">
										<input type="text" readonly name="added_box[]" id="added_box'.$no.'" class="form-control" value="'.$production_boxes[$i].'"/>
										</td>
										<td style="text-align:center">'.$pending_box[$i].'</td>
										<td style="text-align:center">
												<input type="text" name="producation_box[]" id="producation_box'.$no.'" class="form-control" onkeypress="return isNumberKey(event)"/>
												<input type="hidden" name="product_id[]" id="product_id'.$no.'" value="'.$product_id[$i].'"/>
												<input type="hidden" name="packing_model_id[]" id="packing_model_id'.$no.'" value="'.$packing_model_id[$i].'"/>
												<input type="hidden" name="finish_id[]" id="finish_id'.$no.'" value="'.$finish_id[$i].'"/>
										
										</td>
										
										<td style="text-align:center">
												<input type="text" name="batch_no[]" id="batch_no'.$no.'" class="form-control"/>							
										</td>
										
										<td style="text-align:center">
												<input type="text" name="shade_no[]" id="shade_no'.$no.'" class="form-control"/>
										</td>
										
										<td style="text-align:center">
												<input type="text" name="big_pallet_box[]" id="big_pallet_box'.$no.'" class="form-control" onkeypress="return isNumberKey(event)"/>
										</td>

										<td style="text-align:center">
												<input type="text" name="big_pallet[]" id="big_pallet'.$no.'" class="form-control" onkeypress="return isNumberKey(event)"/>
										</td>
										
										<td style="text-align:center">
												<input type="text" name="small_pallet_box[]" id="small_pallet_box'.$no.'" class="form-control" onkeypress="return isNumberKey(event)"/>
										</td>

										<td style="text-align:center">
												<input type="text" name="small_pallet[]" id="small_pallet'.$no.'" class="form-control" onkeypress="return isNumberKey(event)"/>
										</td>
										
									</tr>';
							  $no++;
						 }
		$str .= '
						</tbody>
					<table>
				</div>';
				echo $str;
						 
	}
	
}
