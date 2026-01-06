<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Qc_list extends CI_controller
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
				'allproduct'		=> $this->producation->allproductsize(),
				'consign_data'		=> $this->producation->select_consigner() 
			);
			$this->load->view('admin/qc_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	 public function fetch_record()
	 {
		$invoice_status = $this->input->get('invoice_status');
		$cust_id = $this->input->get('cust_id');
		$invoicedate = explode(" - ",$this->input->get('date'));
		 
		$where = ' and producation_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
		 if(!empty($cust_id))
		{
			$where .= ' and invoice.consigne_id = '.$cust_id;
		}	
			if($this->session->usertype_id != 1)
			{
				$where .= " and find_in_set(invoice.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			}
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('mst.production_mst_id', 'producation_no','consign.c_companyname','sup.company_name','producation_date','readiness_date','no_of_countainer','sup.supplier_name','po_status','mst.performa_invoice_id','step_status');
				$isWhere 	= array("mst.status = 0".$where);
				$table 		= "tbl_production_mst as mst";
				$isJOIN 	= array(
								'INNER join tbl_performa_invoice as invoice on  invoice.performa_invoice_id = mst.performa_invoice_id',
								'left join customer_detail consign on consign.id = invoice.consigne_id',
								'INNER join tbl_supplier as sup on sup.supplier_id = mst.supplier_id',
								'INNER join tbl_performa_additional_detail as additional on additional.production_mst_id = mst.production_mst_id'
								);
				$hOrder = "mst.production_mst_id desc";
				 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
				foreach($sqlReturn['data'] as $row) {
						$row_data 	= array();
					 	$row_data[] =  $no;
					 	$row_data[] = '<a class="tooltips" data-toggle="tooltip" data-title="View" href="'.base_url('view_producation/index/'.$row->production_mst_id).'" >'.$row->producation_no.'</a>';
						$name 		 = !empty($row->name)?' - '.$row->name:'';
						$row_data[]  = $row->c_companyname;
						$row_data[]  = $row->company_name.$name;
						$row_data[]  = date('d/m/Y',strtotime($row->producation_date));
						$row_data[]  = date('d/m/Y',strtotime($row->readiness_date));
						$row_data[]  = $row->no_of_countainer;
					 
				 	 $viewinvoice	= '';
					 $checkbox 		= '';
					 $viewinvoice	= '
							<li>
								<a class="tooltips" data-toggle="tooltip" data-title="Producation Pdf" href="'.base_url('view_producation/index/'.$row->production_mst_id).'"><i class="fa fa-file-pdf-o"></i> Producation PDF </a>
							</li>
							
							';
							$next_btn = '<li>
								<a class=" tooltips" data-toggle="tooltip" data-title="Send for Next Step" href="javascript:;" onclick="send_for_next('.$row->production_mst_id.');"> <i class="fa fa-arrow"></i>Send for Next Step </a>
							</li>';
							$po_btn = '<li>							
											<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url('create_producation/edit/'.$row->production_mst_id).'"><i class="fa fa-pencil"></i> Edit</a>
									</li>
									<li>	
										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->production_mst_id.','.$row->performa_invoice_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									</li>
									<li>
										<a class=" tooltips" data-toggle="tooltip" data-title="Create Purchase Order" href="'.base_url('createpo/index/'.$row->production_mst_id).'"> <i class="fa fa-plus"></i> Create PO </a>
									</li>';
									
							if($row->po_status == 1)
							{
								$po_btn = '<li>
											<a class=" tooltips" data-toggle="tooltip" data-title="PO Done" href="javascript:;"> <i class="fa fa-thumbs-up"></i> PO Done </a>
										</li>';
							}
							if($row->step_status == 1)
							{
								$next_btn = '<li>
											<a class=" tooltips" data-toggle="tooltip" data-title="Send for Next Step" href="javascript:;" onclick="send_for_next('.$row->production_mst_id.');"> <i class="fa fa-thumbs-up"></i> QC </a>
										</li>';
							}
							else if($row->step_status == 2)
							{
								$next_btn = '<li>
											<a class=" tooltips" data-toggle="tooltip" data-title="Send for Next Step" href="javascript:;" onclick="send_for_next('.$row->production_mst_id.');"> <i class="fa fa-thumbs-up"></i> Palletazation </a>
										</li>';
							}
							else if($row->step_status == 3)
							{
								$next_btn = '<li>
											<a class=" tooltips" data-toggle="tooltip" data-title="Send for Next Step" href="javascript:;" onclick="send_for_next('.$row->production_mst_id.');"> <i class="fa fa-thumbs-up"></i> Loading </a>
										</li>';
							}
				 	$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
									 			'.$viewinvoice.' 
												'.$po_btn.' 
												'.$next_btn.' 
									  </div>';
					 
					 $appData[] = $row_data;
					 $no++;
				}
				$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');
				$numrecord=$sqlReturn['data'];
				$output = array(
							"sEcho" 				=> intval($this->input->get('sEcho')),
							"iTotalRecords" 		=> $numrecord,
							"iTotalDisplayRecords" 	=> $totalrecord,
							"aaData" 				=> $appData
					);
				echo json_encode($output);
	  } 
	 function check_suppier()
		{
			$po_array 		= $this->input->post('production_mst_id');
		 	$checkcongine 	= $this->producation->check_suppier($po_array);
			$row=array();
			if($checkcongine == 1)
			{
				$row['res'] = 1;
			}	
			else
			{
				 $row['res'] = 2;
			}
			echo json_encode($row);
	  
		}
		function send_next_step()
		{
			$productionmst_id 	= $this->input->post('productionmst_id');
			$step_status 		= $this->input->post('step_status');
	 	
			$update_step 	= $this->producation->update_step_status($productionmst_id,$step_status);
			$row=array();
			if($update_step)
			{
				$row['res'] = 1;
			}	
			else
			{
				$row['res'] = 0;
			}
			echo json_encode($row);
	  
		}
	public function fetch_producationdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->producation->get_producation($id);
		 $resultdata->producation_date = date('d-m-Y',strtotime($resultdata->producation_date));
		echo json_encode($resultdata);
	}
	public function delete_producation()
	{
		$id=$this->input->post('id');
		$deleteid=$this->producation->delete_record($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function manage()
	{
			$data = array(
					'producation_date' => date("Y-m-d",strtotime($this->input->post('date'))), 
					'product_id' 	   => $this->input->post('productid'), 
					'boxes' 	   	   => $this->input->post('boxes'), 
					'cdate' 	   	   => date('Y-m-d H:i:s'),
					'status'		   => 0
				);
				$row = array();
		if(empty($this->input->post('eid')))
		{
			$insertid = $this->producation->insert_producation($data);
		
			if($insertid)
			{
				$row['res'] = 1;
			}
			else
			{
				$row['res'] = 0;
			}
		}
		else
		{
			$updateid = $this->producation->update_producation($data,$this->input->post('eid'));
		
			if($updateid)
			{
				$row['res'] = 2;
			}
			else
			{
				$row['res'] = 0;
			}
		}			
			echo json_encode($row);
	}
	public function all_confirm_performa()
	{
		$customer_id = $this->input->post('customer_id');
	 	$invoicedate = explode(" - ",$this->input->post('date'));
		 
		$this->load->model('Admin_pdf','pinv');
		$resultdata=$this->producation->get_all_cofirm_pi($customer_id,$invoicedate[0],$invoicedate[1]);
			$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th>Sr No</th>
						 	<th>Performa Invoice No</th>
						 	<th>Performa Invoice Date</th>
							<th>Consinee Name</th>
							<th>No Of Container</th>
							<th>Producation Sheet Done Container</th>
							<th>Pending For Loading</th>
							<th>Loading Done</th>
							<th>Ready For Export</th>
							<th>Export Done</th>
							<th>Action</th>
					 	</tr>';
						$no=1;
			if(!empty($resultdata))
					{	
				$black = array();
		foreach($resultdata as $row)
		{
				 $set_container 		 = $this->pinv->product_set_data($row->performa_invoice_id,-1);
				 $setcontainer 			 = 0;
				 $con_array 			 = array();
				 $check_container_detail = array();
				 $exportcontainer= 0;
				 $readyforexport= 0;
			 		for($i=0; $i<count($set_container);$i++)
					{
						 
						if(!in_array($set_container[$i]->con_entry,$con_array))
						{
							if(!empty($set_container[$i]->container_no))
							{
								$readyforexport += $set_container[$i]->container;
							}
							 
							$setcontainer += $set_container[$i]->container;
						 	array_push($check_container_detail,$set_container[$i]->already_done);
						 	if($set_container[$i]->export_done_status  == 1)
							{
								$exportcontainer += $set_container[$i]->container;
							}
							array_push($con_array,$set_container[$i]->con_entry);
						}
					}
				$checkbox='';	
			$btn = '<a href="'.base_url().'create_pi_loading/index/'.$row->performa_invoice_id.'" type="button" class="tooltips" data-title="PI Loading Plan">
					 + Loading Plan
	 				</a>';
			$pending_sheet_con = ($row->container_details - $setcontainer);	
				
			if(floatval($setcontainer) > 0)
			{
				$btn = '<a href="'.base_url().'create_pi_loading/index/'.$row->performa_invoice_id.'" type="button" class="tooltips" data-title="PI Loading Plan">
								+ Loading Plan
	 				</a>
					<a href="'.base_url().'create_pi_loading/container_details/'.$row->performa_invoice_id.'/0" type="button" class="tooltips" data-title="Container Detail">
								+ Container Detail
	 				</a>
					 ';
					 
						$btn .= '
						<a class="tooltips" data-toggle="tooltip" data-title="Print Company Wise" href="javascript:;" onclick="company_wise_print('.$row->performa_invoice_id.');" data-original-title="" title=""><i class="fa fa-print"></i> Loading Print </a> 
						'; 
			 }		
					if($pending_con == 0)
					 {
						$checkbox = '<input type="checkbox" name="all_performa_invoice[]" id="all_performa_invoice'.$row->performa_invoice_id.'" value="'.$row->performa_invoice_id.'" style="width: 30px;" class="form-control"/>  ';
					 }
					if($exportcontainer > 0)
					{
						$btn .= '<a class="tooltips" data-toggle="tooltip" data-title="Edit Contaier Export Wise" href="javascript:;" onclick="export_wise_print('.$row->performa_invoice_id.');" data-original-title="" title=""><i class="fa fa-pencil"></i> Edit Contaier Export Wise </a> ';
					}						
			$get_po_container = $this->Admin_pdf->get_producation_data($row->performa_invoice_id);
			 
			 
				if($get_po_container['total_con'] > 0 && $exportcontainer < $row->container_details)
				{	
					array_push($black,'true');
					$cust_name = !empty($row->c_nick_name)?$row->c_nick_name:$row->c_companyname;
			 $str .= '<tr>
						<td>'.$no.'</td>
						<td> '.$row->invoice_no.' </td>
						<td> '.date('d/m/Y',strtotime($row->performa_date)).' </td>
						<td> '.$cust_name.'</td>
						<td> '.$row->container_details.'</td>
						<td> '.$get_po_container['total_con'].'</td>
						<td> '.$pending_sheet_con.'</td>
						<td> '.$setcontainer.'</td>
						<td> '.($readyforexport - $exportcontainer).'</td>
						<td> '.$exportcontainer.'</td>
						<td> 
							 <div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											<li>	'.$btn.'	</li>
									</div>
						</td>
					 
				 	</tr>';
						$no++;
				}
					 
		}
		}
					else
					{
							$str .= '<tr> <td colspan="11" class="text-center"> No Data Found</td></tr>';
					
					}
					if(empty($black))
					{
						$str .= '<tr> <td colspan="11" class="text-center"> No Data Found</td></tr>';
				 	}
		$str .= ' 
				</table>
				</div>';
		echo $str;
	
	}
	public function allsizewise_detail()
	{
		 $product_id= $this->input->post('product_id');
		$resultdata=$this->producation->get_all_size_producation($product_id);
		
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th>Sr No</th>
							<th>Product Name</th>
							<th>Boxes</th>
							<th>(Producated + PO) Boxes</th>
							<th>Remaining Boxes</th>
						 	<th>Assign Boxes</th>
							<th>Stock Boxes</th>
							
				 		</tr>';
						$no=1;
				if(!empty($resultdata))	
				{					
		foreach($resultdata as $row)
		{
				$total_boxes = $row->performa_boxes;
				$assign_box = $row->assign_boxes;
				$producation_box = ($row->producation_boxes + $row->po_boxes);
				
				$remaining_box = 0;
				$stock_box = 0;
				if(($total_boxes - $producation_box) > 0)
				{
					$remaining_box = ($total_boxes - $producation_box);
				}
				else 
				{
					$stock_box = ($producation_box - $total_boxes);
				}
			 $str .= '<tr>
						<td>'.$no.'</td>
						<td> '.$row->size_type_mm.' ('.$row->series_name.')</td>
						<td> '.$total_boxes.'</td>
						 <td> '.$producation_box.'</td>
						 <td> '.$remaining_box.'</td>
						<td> '.$assign_box.'</td>
						<td> '.$stock_box.'</td>
						
				 	</tr>';
						$no++;
					 
		}
				}
				else{
					$str .= '<tr>
								<td class="text-center" colspan="7"> No Data Found</td>
							</tr>';
						$no++;
				}
		$str .= ' 
				</table>
				</div>';
		echo $str;
	
	}
	public function producation_pdf()
	{
		$str = '<table class="table table-bordered table-hover display" width="100%">
					<thead>
						<tr>
							<th width="2%">SR No</th>
							<th width="15%">Company Name</th>
							<th width="22%">Po Date</th>
							<th width="22%">Expected Cargo Readiness Date</th>
							<th width="22%">No Of Container</th>
						 	<th width="15%">Action</th>
						</tr>
					</thead>
					<tbody>';
					$producation_data 	= 	$this->Admin_pdf->get_producation_data($this->input->post('performa_invoice_id'));
					 
		         if(!empty($producation_data["total_con"]>0))
				{
					$sr =1;
					foreach($producation_data as $row)
					{
						 if($row->no_of_countainer> 0)
						{													
						 
								$str .= '<tr>
											<td>'.$sr.'</td>
											<td>'.$row->company_name.'</td>
											<td>'.date("d/m/Y",strtotime($row->producation_date)).'</td>
											<td>'.date("d/m/Y",strtotime($row->readiness_date)).'</td>
											<td>'.number_format($row->no_of_countainer,2).'</td>
											<td> 
												<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Producation Pdf" href="'.base_url('view_producation/index/'.$row->production_mst_id).'"><i class="fa fa-file-pdf-o"></i> Producation PDF </a>
												<a class="tooltips btn btn-warning" data-toggle="tooltip" data-title="Edit" href="'.base_url('create_producation/edit/'.$row->production_mst_id).'"><i class="fa fa-pencil"></i> Edit</a>
												<a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->production_mst_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
												
											</td>
										</tr>';
												$sr++;
						}
					}
				}
				else
				{
				 
					$str .= '<tr>
								<td colspan="4" class="text-center">No Data Found</td>
							</tr>';
					 
				}
					 
				$str .= '</tbody>
				</table> ';
			echo $str;
	}
}
