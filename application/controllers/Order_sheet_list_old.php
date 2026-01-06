<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Order_sheet_list extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		 
		
		$this->load->model('Order_sheet_list_model','mode');
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
		
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['allperforma_size']	= $this->mode->allperforma_size();
			$data['all_finish_data']	= $this->mode->get_allfinish();
			$data['result']				= $this->mode->get_producation();
			$data['order_sheet_data'] = $this->mode->get_order_sheet($size,$finish_id);
			$data['boxdesigndata']		= $this->mode->boxdesigndata();
			$data['boxdesigndata1']		= $this->mode->boxdesigndata();
			$data['getdispatchdata']		= $this->mode->getdispatchdata();
			$data['customerdata']		= $this->mode->customerdata();
			$data['exportinvoicedata']		= $this->mode->exportinvoicedata();
			
			$this->load->view('admin/order_sheet_list',$data);
			
		}
		else
		{
			redirect(base_url().'');
		}
	}
	
	public function fetch_record()
	{
		$size_id 	= $this->input->get('size_id');
		$finish_id = $this->input->get('finish_id');
		 //$where = '';
		 
	   if(!empty($finish_id))
		{
			$where .= ' and mst.finish_id = '.$finish_id;
			$_SESSION['get_finishdata'] = $finish_id;
		}	
		else
		{
			$_SESSION['get_finishdata'] = '';
		}
		
		if(!empty($size_id))
		{
			$where .= ' and pro.product_id = '.$size_id;
			$_SESSION['get_exportdata'] = $size_id;
		}	
		else
		{
			$_SESSION['get_exportdata'] = '';
		}
		
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.producation_id','mst.producation_date','cust.c_name','box.box_design_name','producation_time','pro.size_type_mm','model.model_name','finish.finish_name','boxes','dispatch_box','shade_no','batch_no','(SELECT count(*) FROM `tbl_producation`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "tbl_producation as mst";
		$isJOIN 	= array(
							
								'left join tbl_product as pro on pro.product_id = mst.product_id ',
								'left join tbl_packing_model as model on model.packing_model_id = mst.packing_model_id',
								'left join tbl_finish as finish on finish.finish_id = mst.finish_id',
								'left join customer_detail as cust on cust.id = mst.id',
								'left join tbl_box_design as box on box.box_design_id = mst.box_design_id',
								);
		 $hOrder = "mst.producation_id desc";
		 
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				
			foreach($sqlReturn['data'] as $row) {				
					
					
					$row_data = array();
				 	$row_data[] = '<input type="checkbox" name="allproductation_entry_id[]" id="allproductation_entry_id'.$row->producation_id .'" value="'.$row->id.'-'.$row->box_design_id.'-'.$row->product_id.'-'.$row->design_id.'-'.$row->finish_id.'-'.$row->packing_model_id.'-'.$row->boxes.'"   />'. $no;

				 	$row_data[] = date('d/m/Y',strtotime($row->producation_date));
					$row_data[] = $row->c_name;
					$row_data[] = $row->box_design_name;
					$row_data[] = $row->size_type_mm;
					$row_data[] = $row->model_name;
					$row_data[] = $row->finish_name;
					$row_data[] = $row->boxes;
				 	$row_data[] = $row->batch_no;
					$row_data[] = $row->shade_no;
				
				
					$actionbtn = '';
					$archivebtn = '';
				 	$delete_btn = '';
					$viewbtn ='';
					$downloadbtn = '';
					$deleteimagebtn = '';
					
					
					if($row->status==0)
					{
						
							
						
												
												
						if($row->total_cnt>=1)
						{
							$delete_btn = ' <li>
										<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->producation_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
									 </li>';
									 
									 
						}
											
						 $actionbtn = '<li> 
										<a class="tooltips" id="edit" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="edit_product('.$row->producation_id.');"><i class="fa fa-pencil"></i> Edit</a>
									 </li>
									 
									 <li> 
										<a class="tooltips" id="dispatch" data-toggle="tooltip" data-title="Dispatch" href="javascript:;" onclick="dispatch_data('.$row->producation_id.');"><i class="fa fa-excel"></i> Dispatch</a>
									 </li>
									'.$actionbtn;

					
					
					}	
					
					
					
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$action.'
											'.$delete_btn .'
											
																					
										</ul>
									</div>';
					$appData[] = $row_data;
					$no++;
				 }
			$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');
				$numrecord=$sqlReturn['data'];
			$output = array(
					"sEcho" => intval($this->input->get('sEcho')),
					"iTotalRecords" =>  $numrecord,
					"iTotalDisplayRecords" =>$totalrecord,
					"aaData" => $appData
			);
				echo json_encode( $output );
	}
	
	public function manage()
		{
			$id =  $this->input->post('eid');
			
			if(!empty($id))
			{
					// $check_box_design = $this->mode->check_doc_update($this->input->post('edit_shipping_name'));
								
					// if(empty($check_box_design) || $this->input->post('editdocumentmode') == $this->input->post('edit_shipping_name'))
					// {
						
						
						$data = array
						(
							 'id'							=> $this->input->post('edit_customer_name'),
							 'box_design_id'				=> $this->input->post('edit_box_design_name'),
							 'boxes'						=> $this->input->post('edit_producation_box'),
							 'batch_no'						=> $this->input->post('edit_batch_no'),
							 'shade_no'						=> $this->input->post('edit_shade_no'),
							 
							 'status'   	   					=> 0
						);
						
						$id = $this->input->post('eid');
						
												
						
						$updatedid = $this->mode->updatedata($data,$id);
						 if($updatedid)
						{
							 $row['id'] =  $id;
							 $row['batch_no'] = $this->input->post('edit_batch_no');
						
							 $row['res'] = 1;
							
						}
						else
						{
							$row['id'] =0;
							 $row['batch_no'] =0;
							 $row['res'] = 0;
						}
					//}
				// else
				// {
					// $row['res'] = 2;
					// $row['editdocumentmode'] = $this->input->post('editdocumentmode');
				// }
				
			}
			
			
			echo json_encode($row);
		}
		
	public function manage1()
		{
			$id1 =  $this->input->post('eid1');
			$id = $this->input->post('producation_id_dispatch');
			
			if(empty($id1))
			{
			
				$data = array
						(
							 'producation_id'				=> $this->input->post('producation_id_dispatch'),
							 'dispatch_date'				=> $this->input->post('dispatch_date'),
							 'export_invoice_id'	    	=> $this->input->post('export_invoice'),
							 'id'							=> $this->input->post('customer_name'),
							 'box_design_id'				=> $this->input->post('box_design_name'),
							 'product_id'					=> $this->input->post('size'),
							 'packing_model_id'				=> $this->input->post('design_name'),
							 'finish_id'					=> $this->input->post('finish'),
							 'boxes'						=> $this->input->post('producation_box'),
							 'batch_no'						=> $this->input->post('batch_no'),
							 'shade_no'						=> $this->input->post('shade_no'),
							 
							 'status'   	   					=> 0
						);
						
					$id = $this->input->post('producation_id_dispatch');
					
					$insertid = $this->mode->dispatch_insert($data);
					
					
					$row = array();
					
					if(!empty($insertid))
					{
						$data1 = array
						(
							
							 //'box_design_id'				=> $this->input->post('box_design_name'),
							 'dispatch_box'						=> $this->input->post('producation_box')
						
						);
				
						$updatedid1 = $this->mode->updatedata1($data1,$id);	
						
						$row['res'] = 1;
						$row['id'] = $insertid;
						
						
					}
					else
					{
						$row['res'] = 0;
					}
					
						
			
			}
			echo json_encode($row);
		}
	
	
	public function deleterecord()
	{
		$id = $this->input->post('id');
		
		$deletedata = $this->mode->get_list($id);
		
		
		$deleteid=$this->mode->delete_list_data($id);
		$row=array();
		if($deleteid)
		{
			$row['res'] = 1;
			
		}
		else
		{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function fetchsheetdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->mode->fetchmodeldata($id);
				
		echo json_encode($resultdata);
	}
	
	public function get_order_sheet()
	{
		$str = '<div class="table-responsive">
					<table class="table table-bordered  display" id="datatable" width="100%">
						<thead>
							<tr>
								<th style="text-align:center">Sr No</th>
								<th style="text-align:center">SIZE</th>
						 		<th style="text-align:center">DESIGN</th>
								<th style="text-align:center">FINISH</th>
								<th style="text-align:center">PRODUCTION REQURED BOX</th>
								<th style="text-align:center">PRODUCTION ENTRY</th>
								<th style="text-align:center">PENDING BOX</th>
								<th style="text-align:center">LOADING BOX</th>
								
								<th style="text-align:center">
									<a class="tooltips btn btn-primary" data-toggle="tooltip" data-title="ADD PRODUCTION" href="javascript:;" onclick="add_multiple_producation()"><i class="fa fa-plus"></i> </a>
								</th>
						 	</tr>
						</thead>
						 <tbody>
						 ';
						 $size 		= $this->input->post('size');
						 $finish_id = $this->input->post('finish_id');
						 $id = $this->input->post('producation_id');
						 
						$order_sheet_data = $this->mode->get_order_sheet($size,$finish_id);
			 		$sr =1;
					if(!empty($order_sheet_data))
					{
					foreach($order_sheet_data as $row)
					{
					
						$production_detail = $this->mode->get_production_data($row->product_id,$row->packing_model_id,$row->finish_id);
						$loading_detail = $this->mode->get_loading_data($row->product_id,$row->packing_model_id,$row->finish_id);
						$export_detail = $this->mode->get_export($row->product_id,$row->packing_model_id,$row->finish_id);
						 
						$order_boxes 		= $row->order_boxes - $export_detail->export_boxes;	 
						$production_boxes 	= ($production_detail->production_boxes > 0)?($production_detail->production_boxes):0;	 
						$pending_box 		= ($order_boxes - $production_boxes);
						$loading_box 		= ($loading_detail->assign_boxes > 0)?$loading_detail->assign_boxes:0;
						// $shade_no 			= $this->mode->get_producation1($id);
						
						$color = ($pending_box == 0)?"#65a465":"";
						$action = '<input type="checkbox" name="allproductation_entry_id[]" id="allproductation_entry_id'.$row->production_mst_id.'" value="'.$row->product_id.'-'.$row->packing_model_id.'-'.$row->finish_id.'-'.$order_boxes.'-'.$production_boxes.'-'.$pending_box.'"   />
												
												<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Add Production" href="javascript:;" onclick="add_producation('.$row->product_id.','.$row->packing_model_id.','.$row->finish_id.','.$order_boxes.','.$production_boxes.','.$pending_box.')"><i class="fa fa-plus"></i> </a>  ';
						if($pending_box == 0)
						{
							$action='';
						}
									$str .= '<tr style="background:'.$color.'">
												<td style="text-align:center">'.$sr.'</td>
												<td style="text-align:center">'.$row->size_type_mm.'</td>
												<td style="text-align:center">'.$row->model_name.'</td>
												<td style="text-align:center">'.$row->finish_name.'</td>
												<td style="text-align:center">'.$order_boxes.'</td>
												<td style="text-align:center"> '.$production_boxes.'</td>
												<td style="text-align:center">'.$pending_box.'</td>
												<td style="text-align:center">'.$loading_box.'</td>
												
												<td style="text-align:center">
												'.$action.'</td>';
							 
										$str .= '</tr>';
												$sr++;
						 
					}
					}
					else
					{
						$str .= '<tr><td class="text-center" colspan="9">No Data Found</td></tr>';
					}
					 
				$str .= '</tbody>
					</table>
					 </div>';
			echo $str;
	}
	
	public function add_producation()
	{
		$id 			=  $this->input->post('id');
		$box_design_id 	=  $this->input->post('box_design_id');
		$product_id 	=  $this->input->post('product_id');
		$design_id 		=  $this->input->post('design_id');
		$finish_id 		=  $this->input->post('finish_id');
		$packing_model_id 	=  $this->input->post('packing_model_id');
		$boxes 			=  $this->input->post('boxes');
		
		
		
		
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover display" id="datatable" width="100%">
						<thead>
							<tr>
								<th style="text-align:center">Sr No</th>
								<th style="text-align:center">Size</th>
						 		<th style="text-align:center">Design</th>
								<th style="text-align:center">Finish</th>
								<th style="text-align:center"> Boxes</th>
								<th style="text-align:center">Batch No</th>
								<th style="text-align:center">Shade No</th>
								
					 	 	</tr>
						</thead>
						 <tbody>
						 ';
						 $no = 1;
						 
						 for($i=0;$i<count($product_id);$i++)
						 {
							 //$producationdata = $this->producation->get_producation($id);
							 //$get_producation  = $this->producation->get_producation($shade_no[$i]);
							 $get_size 	 = $this->mode->get_size($product_id[$i]);
							 $get_design = $this->mode->get_design($packing_model_id[$i]);
							 $get_finish = $this->mode->get_finish($finish_id[$i]);
							 
							 $str .= '<tr>
										<td style="text-align:center">'.$no.'</td>
										<td style="text-align:center">'.$get_size->size_type_mm.'</td>
										<td style="text-align:center">'.$get_design->model_name.'</td>
										<td style="text-align:center">'.$get_finish->finish_name.'</td>
										
										<td style="text-align:center">
										<input type="text" readonly name="added_box[]" id="added_box'.$no.'" class="form-control" value="'.$boxes[$i].'"/>
										</td>
										
										<td style="text-align:center">
												
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

?>