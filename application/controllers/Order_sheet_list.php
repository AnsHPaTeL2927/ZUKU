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
			$data['dispatch_customerdata']		= $this->mode->dispatchcustomerdata();
			$data['exportinvoicedata']		= $this->mode->exportinvoicedata();
			$this->load->view('admin/order_sheet_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}

	}

	public function fetch_record($customer_id,$size_id,$finish_id)
	{
		$_SESSION['search_customers'] = $customer_id;
		$_SESSION['search_size'] = $size_id;
		$_SESSION['search_finish'] = $finish_id;
		$_SESSION['search_date'] = $this->input->get('date');
		$invoicedate = explode(" - ",$this->input->get('date'));
		$fromdate = date('Y-m-d',strtotime($invoicedate[0]));
		$todate = date('Y-m-d',strtotime($invoicedate[1]));

		$where = ' mst.producation_date >= "'.$fromdate.'" and mst.producation_date <= "'.$todate.'" ';
		
		if($customer_id != 'All')
		{
			if($where == '')
			{
				$where .= ' mst.id = '.$customer_id;
			}else{
				$where .= ' and mst.id = '.$customer_id;
			}			
		}

		if($size_id != 'All')
		{
			if($where == '')
			{
				$where .= ' mst.product_id = '.$size_id;
			}else{
				$where .= ' and mst.product_id = '.$size_id;
			}			
		}

		if($finish_id != 'All')
		{
			if($where == '')
			{
				$where .= ' mst.finish_id = '.$finish_id;
			}else{
				$where .= ' and mst.finish_id = '.$finish_id;
			}			
		}

		// $size_id 	= $this->input->get('size_id');
		// $finish_id = $this->input->get('finish_id');	
	 //   if(!empty($finish_id))
		// {
		// 	$where .= ' and mst.finish_id = '.$finish_id;
		// 	$_SESSION['get_finishdata'] = $finish_id;
		// }
		// else
		// {
		// 	$_SESSION['get_finishdata'] = '';
		// }		

		// if(!empty($size_id))
		// {
		// 	$where .= ' and pro.product_id = '.$size_id;
		// 	$_SESSION['get_exportdata'] = $size_id;
		// }	
		// else
		// {
		// 	$_SESSION['get_exportdata'] = '';
		// }

		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.producation_id','mst.producation_date','cust.c_companyname','box.box_design_name','producation_time','pro.size_type_mm','model.model_name','finish.finish_name','mst.boxes','mst.dispatch_box as dispbox','big_pallet','small_pallet','shade_no','batch_no','(SELECT count(*) FROM `tbl_producation`) as total_cnt','mst.status');
		 $isWhere = array($where);
		 $table = "tbl_producation as mst";
		$isJOIN  = array(	
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

					$dispatchData = $this->db->select('sum(boxes) as dbox')->where('producation_id',$row->producation_id)->get('tbl_dispatch')->row_array();
					$dbox = !empty($dispatchData['dbox']) ? $dispatchData['dbox'] : "0";		
					//$BOXTOTAL = $row->boxes-$dbox;
				 	$row_data[] = $no;

				 	$row_data[] = date('d/m/Y',strtotime($row->producation_date));

					$row_data[] = $row->c_companyname;

					$row_data[] = $row->box_design_name;

					$row_data[] = $row->size_type_mm;

					$row_data[] = $row->model_name;

					$row_data[] = $row->finish_name;

					$row_data[] =  $row->boxes;

					$row_data[] =  '<a href="'.base_url().'order_sheet_list/dispatchdetails/'.$row->producation_id.'" target="_bkanck">'.$dbox.'</a>';

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
									 </li>';	
						if($dbox < $row->boxes)
						{
							$actionbtn = $actionbtn.'<li> 
										<a class="tooltips" id="dispatch" data-toggle="tooltip" data-title="Dispatch" href="javascript:;" onclick="dispatch_data('.$row->producation_id.');"><i class="fa fa-truck"></i> Dispatch</a>
									 </li>
									';
						}				

					}	

					$dispatchCheckbox = $dbox < $row->boxes ? ' &nbsp;<input type="checkbox" class="bulkdispatch" name="dispatch_productions[]" id="dispatch_productions'.$row->producation_id .'" value="'.$row->producation_id.'"/>' : '';

					$row_data[] = '<div class="dropdown">
								<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
								<span class="caret"></span></button>
								<ul class="dropdown-menu">
									'.$actionbtn .'
									'.$delete_btn .'
								</ul>										 
							</div>'.$dispatchCheckbox;

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
				$data = array
				(
					 'id' => $this->input->post('edit_customer_name'),
					 'box_design_id' => $this->input->post('edit_box_design_name'),
					 'boxes' => $this->input->post('edit_producation_box'),
					 'batch_no'	=> $this->input->post('edit_batch_no'),
					 'shade_no' => $this->input->post('edit_shade_no'), 
					 'big_pallet' => $this->input->post('edit_big_pallet'),
					 'small_pallet' => $this->input->post('edit_small_pallet'),
					 'big_pallet_box' => $this->input->post('edit_big_pallet_box'),
					 'small_pallet_box' => $this->input->post('edit_small_pallet_box'),
					 'big_pallet_no' => ($this->input->post('edit_big_pallet_box')*$this->input->post('edit_big_pallet')),
					 'small_pallet_no' => ($this->input->post('edit_small_pallet')*$this->input->post('edit_small_pallet')),
					 'status' => 0
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
				 'id'							=> $this->input->post('customer_id'),
				 'customer_id'					=> $this->input->post('customer_id'),
				 'box_design_id'				=> $this->input->post('box_design_name'),
				 'product_id'					=> $this->input->post('product_id'),
				 'packing_model_id'				=> $this->input->post('packing_model_id'),
				 'finish_id'					=> $this->input->post('finish_id'),
				 'boxes'						=> $this->input->post('producation_box'),
				 'big_pallet'					=> $this->input->post('big_pallet'),
				 'small_pallet'					=> $this->input->post('small_pallet'),
				 'big_pallet_box'				=> $this->input->post('big_pallet_box'),
				 'small_pallet_box'				=> $this->input->post('small_pallet_box'),
				 'batch_no'						=> $this->input->post('batch_no'),
				 'shade_no'						=> $this->input->post('shade_no'),	
				 'big_pallet_no' 				=> $this->input->post('big_pallet') * $this->input->post('big_pallet_box'),
				 'small_pallet_no' 				=> $this->input->post('small_pallet') * $this->input->post('small_pallet_box'),		 
				 'status'   	   				=> 0
				);						

				$id = $this->input->post('producation_id_dispatch');
				$insertid = $this->mode->dispatch_insert($data);
				$row = array();	
				if(!empty($insertid))
				{	
					$result = $this->db->select('SUM(boxes) as total')->where('producation_id',$id)->get('tbl_dispatch')->row_array();
					$this->db->query('UPDATE tbl_producation SET dispatch_box = '.$result['total'].' where producation_id ='.$id);

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

	// Created by Makwana 
	// Get multiple production data
	public function getbulkdata() 
	{
		$ids = $this->input->post('id');
		$resultdata = $this->mode->fetchmodeldata($ids);
		foreach ($resultdata as $key => $value) { 
			$dispatch_box = empty($value['dispatch_box']) ? 0 : $value['dispatch_box'];
		if($dispatch_box < $value['boxes'])
		{	
			$notdispatchBox = $value['boxes']-$dispatch_box;		
		?>
		<input type="hidden" name="producation_id_dispatch[]" value="<?=$value['producation_id']?>">
		<input type="hidden" name="customer_name[]"  value="<?=$value['id']?>">
		<input type="hidden" name="box_design_name[]" value="<?=$value['box_design_id']?>"> 
		<input type="hidden" name="product_id[]" value="<?=$value['product_id']?>">
		<input type="hidden" name="packing_model_id[]" value="<?=$value['packing_model_id']?>"> 
		<input type="hidden" name="finish[]" value="<?=$value['finish_id']?>"> 		
		<input type="hidden" name="batch_no[]" value="<?=$value['batch_no']?>">
		<input type="hidden" name="shade_no[]" value="<?=$value['shade_no']?>">				
		<tr>
			<td><?=$value['c_companyname']?></td>
			<td><?=$value['box_design_name']?></td>
			<td><?=$value['size_type_mm']?></td>
			<td><?=$value['model_name']?></td>
			<td><?=$value['finish_name']?></td>
			<td><?=$value['boxes']?>/<?=$dispatch_box?></td>
			<td><input type="number" placeholder="Box" step="1" max="<?=$notdispatchBox?>" min="0" onkeyup="imposeMinMax(this)" class="form-control probox" name="producation_box[]" autocomplete="off" value="<?=$notdispatchBox?>"></td>
			<td>
				<input type="number" name="big_pallet_box[]" value="<?=$value['big_pallet_box']?>" min="0" class="form-control">
			</td>
			<td>
				<input type="number" name="big_pallet[]" value="<?=$value['big_pallet']?>" min="0" class="form-control">
			</td>			
			<td>
				<input type="number" name="small_pallet_box[]" value="<?=$value['small_pallet_box']?>"  min="0" class="form-control">
			</td>
			<td>
				<input type="number" name="small_pallet[]"  min="0" class="form-control" value="<?=$value['small_pallet']?>">		
			</td>
			<td><?=$value['batch_no']?></td>
			<td><?=$value['shade_no']?></td>			
		</tr>	
		<?php } }
	}

	// Save multiple dis data
	public function savebulkdispatchdata()
	{	
		$bulk_dispatch_date = date('Y-m-d',strtotime($this->input->post('bulk_dispatch_date')));
		$export_invoice_id  = $this->input->post('export_invoice');
		if($this->input->post('producation_id_dispatch'))
		{
			$producation_id_dispatch = $this->input->post('producation_id_dispatch');
			$customer_name = $this->input->post('customer_name');
			$box_design_name = $this->input->post('box_design_name');
			$product_id = $this->input->post('product_id');
			$packing_model_id = $this->input->post('packing_model_id');
			$finish = $this->input->post('finish');
			$big_pallet = $this->input->post('big_pallet');
			$small_pallet = $this->input->post('small_pallet');
			$big_pallet_box = $this->input->post('big_pallet_box');
			$small_pallet_box = $this->input->post('small_pallet_box');
			$batch_no = $this->input->post('batch_no');
			$shade_no = $this->input->post('shade_no');
			$producation_box = $this->input->post('producation_box');
			$dispatchids = array();
			for ($i=0; $i < count($producation_id_dispatch); $i++) {			 
				$data = array(
					 'producation_id' => $producation_id_dispatch[$i],
					 'dispatch_date' => $bulk_dispatch_date,
					 'export_invoice_id' => $export_invoice_id,
					 'id' => $customer_name[$i],
					 'customer_id' => $customer_name[$i],
					 'box_design_id' => $box_design_name[$i],
					 'product_id' => $product_id[$i],
					 'packing_model_id' => $packing_model_id[$i],
					 'finish_id' => $finish[$i],
					 'boxes' => $producation_box[$i],
					 'batch_no' => $batch_no[$i],
					 'shade_no' => $shade_no[$i],		
					 'big_pallet' => $big_pallet[$i], 
					 'small_pallet' => $small_pallet[$i],
					 'big_pallet_box' => $big_pallet_box[$i], 
					 'small_pallet_box' => $small_pallet_box[$i],
					 'big_pallet_no' => $big_pallet[$i]*$big_pallet_box[$i],
					 'small_pallet_no' => $small_pallet_box[$i]*$small_pallet[$i],
					 'status' => 0
				);
				$dispatchids[] = $this->mode->dispatch_insert($data);
				$result = $this->db->select('SUM(boxes) as total')->where('producation_id',$producation_id_dispatch[$i])->get('tbl_dispatch')->row_array();
				$this->db->query('UPDATE tbl_producation SET dispatch_box = '.$result['total'].' where producation_id ='.$producation_id_dispatch[$i]);
			}
		}

		if($this->input->post('view_report') == 1 && !empty($dispatchids)) 
		{
			echo implode('_', $dispatchids);
		}		
	}

	public function dispatchdetails($id=0)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{ 
			$data['dispatch_list'] = $this->mode->getDispatchList($id);	

			$title = !empty($data['dispatch_list']) ? $data['dispatch_list'][0]['c_companyname'].'_order_'.time() : 'Unknown';
			$html = $this->load->view('admin/production_dispatch_list',$data,true);
			error_reporting(0);
			$this->load->view('mpdf/mpdf.php');
			$mpdf=new mPDF('c', 'A4-L');//mPDF('utf-8','A4','7','calibri',5,5,5,5,0,0); 
			$mpdf->WriteHTML($html);
			$mpdf->SetTitle($title);
			$mpdf->Output($title.".pdf","I");
		}
		else
		{
			redirect(base_url().'');
		}
	}

	// 14-04-2022 : Makwana
	public function dispatchdetailsreport($ids)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{  
			$dispatch_ids = explode('_', $ids);
			$data['dispatch_list'] = $this->mode->getBulkDispatchdata($dispatch_ids);	
			$title = 'dispatch_detail_report_order_'.time();
			$html = $this->load->view('admin/dispatch_pdf_report',$data,true);
			error_reporting(0);
			$this->load->view('mpdf/mpdf.php');
			$mpdf=new mPDF('c', 'A4-L');//mPDF('utf-8','A4','7','calibri',5,5,5,5,0,0); 
			$mpdf->WriteHTML($html);
			$mpdf->SetTitle($title);
			$mpdf->Output($title.".pdf","I");
		}
		else
		{
			redirect(base_url().'');
		}
	}

	 public function addcolumn()
	 {
		// 	$this->db->query("ALTER TABLE `tbl_dispatch` ADD `customer_id` INT UNSIGNED NULL DEFAULT NULL AFTER `id`;");
	 	// $this->db->query("ALTER TABLE `tbl_dispatch` ADD `container_num` VARCHAR(50) NULL DEFAULT NULL AFTER  
			// `batch_no`, ADD `truck_num` VARCHAR(50) NULL DEFAULT NULL AFTER `container_num`, ADD  
			// `big_pallet` VARCHAR(50) NULL DEFAULT NULL AFTER `truck_num`, ADD `small_pallet` VARCHAR(50)  
			// NULL DEFAULT NULL AFTER `big_pallet`, ADD `pallet_num` VARCHAR(50) NULL DEFAULT NULL AFTER  
			// `small_pallet`;");
	 }
}

?>