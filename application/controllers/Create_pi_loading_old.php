<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Create_pi_loading extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
	 	$this->load->model('Admin_pdf','pinv');
		$this->load->model('menu_model','menu');	
		
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company				=	$this->pinv->company_select();
			$bankid					=	$company[0]->bank_name;
			$bank					= 	$this->pinv->bselect($bankid);
			$data					= 	$this->pinv->select_invoice_data($id);
			$datap					= 	$this->pinv->product_data($id);
			$set_container			= 	$this->pinv->product_set_data($id,-1);
			$producation_data 		= 	$this->pinv->get_producation_data($id,0);  
			$auto_loading_plan 		= 	$this->pinv->get_auto_loading_plan($id,0,1);  
			$notauto_loading_plan 	= 	$this->pinv->get_auto_loading_plan($id,0,0);  
			$menu_data				= 	$this->menu->usermain_menu($this->session->usertype_id);	
		 	$v = array(
					'invoicedata'			=>	$data,
				 	'auto_loading_plan'		=> 	$auto_loading_plan,
				 	'notauto_loading_plan'	=> 	$notauto_loading_plan,
				 	'producationdata'		=> 	$producation_data,
					'product_data'			=>	$datap,
					'set_container'			=>	$set_container,
					'menu_data'				=>	$menu_data,
					'bank'					=>	$bank,
					'company_detail'		=>	$company,
					'mode' 					=>	 "0"
				);
			$this->load->view('admin/create_pi_loading',$v);
		}
		else
		{
			redirect(base_url().'');
		}
			 
	}
	function set_auto_loading_plan()
	{
		$performa_invoice_id 	= $this->input->post('performa_invoice_id');
		$producation_data 		= $this->pinv->get_producation_data($performa_invoice_id,0);  
			
			$make_container_array = array();
		 	foreach($producation_data as $row)
			{
			 	foreach($row->production_trn as $packing)
				{
			 		if(!empty($packing))
					{
						$total_boxes = $this->pinv->get_auto_load($performa_invoice_id,$packing->production_trn_id,$packing->product_id);
						$order_boxes = $packing->no_of_boxes - $total_boxes->already_done_boxes;
						$order_sqm	 = $packing->no_of_sqm - $total_boxes->already_done_sqm;
						 
						if($order_boxes > 0 || $order_sqm > 0)
						{

							if($packing->no_of_pallet>0)
							{
								$plts_per_container = $packing->total_pallent_container;
								$one_container 		= $order_boxes * 100 / $packing->box_per_container; 
							}
							else if($packing->no_of_big_pallet>0 || $packing->no_of_small_pallet>0)
							{
								$plts_per_container = $packing->no_big_plt_container_new.'<br>'.$packing->no_small_plt_container_new;
								$one_container = $order_boxes * 100 / $packing->multi_box_per_container; 
							}
							else
							{
								$plts_per_container = '-';
								$one_container = $order_boxes * 100 / $packing->total_boxes;
							}
							$con  = ($packing->product_id == 0 || $one_container == "INF")?0:$one_container/100;
							$row1 = array();
								$no_of_boxes 	= $order_boxes;
								$no_of_sqf		= ($product_data[$i]->feet_per_box * $order_boxes);
													
								if($packing->per == "BOX")
								{
								$no_of_boxes = $order_boxes;
								$no_of_sqf = 0;
								}
								else if($packing->per == "SQF")
								{
								$no_of_boxes =0;
								$no_of_sqf = $order_boxes;
								}
							$row1['con'] 			   = $con;
							$row1['production_trn_id'] = $packing->production_trn_id;
							$row1['product_id'] 	   = $packing->product_id;
							$row1['size_type_mm'] 	   = $packing->size_type_mm;
							$row1['description_goods'] = $packing->description_goods;
							$row1['model_name'] 	   = $packing->model_name;
							$row1['design_file'] 	   = $packing->design_file;
							$row1['no_of_boxes'] 	   = $no_of_boxes;
							$row1['no_of_sqm'] 	   	   = $packing->no_of_sqm;
							$row1['no_of_sqf'] 	   	   = $no_of_sqf;
							$row1['no_of_pallet'] 	   = $packing->no_of_pallet;
							$row1['no_of_big_pallet']  = $packing->no_of_big_pallet;
							$row1['no_of_small_pallet']= $packing->no_of_small_pallet;
							$row1['finish_name'] 	   = $packing->finish_name;
						
							array_push($make_container_array,$row1);
						}
				 	}
				}
			}
		 
			$co=1;
			$co1=1;
			$total_con=0;
			$array_key=0;
			$container_array = array();
			rsort($make_container_array);
			 
			for($c=0;$c<sizeof(array_filter($make_container_array));$c++)
			{
				 $con = number_format($make_container_array[$c]['con'],2);
				
				  	if($con == 1)
					{
						$container_array[$co1] = array();
					 	$container_array[$co1][$array_key]['production_trn_id']  = $make_container_array[$c]['production_trn_id'];
					 	$container_array[$co1][$array_key]['product_id']		 = $make_container_array[$c]['product_id'];
					 	$container_array[$co1][$array_key]['size_type_mm'] 		 = $make_container_array[$c]['size_type_mm'];
					 	$container_array[$co1][$array_key]['model_name'] 		 = $make_container_array[$c]['model_name'];
					 	$container_array[$co1][$array_key]['full_status'] 		 = 1;
					 	$container_array[$co1][$array_key]['finish_name'] 		 = $make_container_array[$c]['finish_name'];
					 	$container_array[$co1][$array_key]['design_file'] 		 = $make_container_array[$c]['design_file'];
					 	$container_array[$co1][$array_key]['no_of_boxes'] 		 = $make_container_array[$c]['no_of_boxes'];
					 	$container_array[$co1][$array_key]['no_of_sqm'] 		 = $make_container_array[$c]['no_of_sqm'];
						$container_array[$co1][$array_key]['no_of_sqf'] 		 = $make_container_array[$c]['no_of_sqf'];
					 	$container_array[$co1][$array_key]['no_of_pallet'] 		 = $make_container_array[$c]['no_of_pallet'];
					 	$container_array[$co1][$array_key]['no_of_big_pallet'] 	 = $make_container_array[$c]['no_of_big_pallet'];
					 	$container_array[$co1][$array_key]['no_of_small_pallet'] = $make_container_array[$c]['no_of_small_pallet'];
						
						$co1++;
						$array_key=0;
				 	}
					else if($make_container_array[$c]['con'] == 0)
					{
							if (array_key_exists($array_key,$container_array[0]))
							{	
								$array_key++;
							}
						 	$container_array[0][$array_key]['production_trn_id']  = $make_container_array[$c]['production_trn_id'];
							$container_array[0][$array_key]['product_id']		  = $make_container_array[$c]['product_id'];
							$container_array[0][$array_key]['size_type_mm'] 	  = $make_container_array[$c]['description_goods'];
							$container_array[0][$array_key]['model_name'] 		  = $make_container_array[$c]['model_name'];
							$container_array[0][$array_key]['full_status'] 	  	  = 0;
							$container_array[0][$array_key]['finish_name'] 		  = $make_container_array[$c]['finish_name'];
							$container_array[0][$array_key]['design_file'] 		  = $make_container_array[$c]['design_file'];
							$container_array[0][$array_key]['no_of_pallet']		  = $make_container_array[$c]['no_of_pallet'];
							$container_array[0][$array_key]['no_of_sqm']   		  = $make_container_array[$c]['no_of_sqm'];
							$container_array[0][$array_key]['no_of_boxes'] 		  = $make_container_array[$c]['no_of_boxes'];
							$container_array[0][$array_key]['no_of_sqf'] 		  = $make_container_array[$c]['no_of_sqf'];
							$container_array[0][$array_key]['no_of_big_pallet'] 		  = $make_container_array[$c]['no_of_big_pallet'];
							$container_array[0][$array_key]['no_of_small_pallet'] = $make_container_array[$c]['no_of_small_pallet']; 
							$array_key++;
					}
					else if($con > 1)
					{
						$con = ($con == (int) $con) ? (int) $con : (float) $con;
						if(is_float($con))
						{
							if (array_key_exists($array_key,$container_array[0]))
							{	
								$array_key++;
							}
						 	$container_array[0][$array_key]['production_trn_id']  = $make_container_array[$c]['production_trn_id'];
							$container_array[0][$array_key]['product_id']		  = $make_container_array[$c]['product_id'];
							$container_array[0][$array_key]['size_type_mm'] 	  = $make_container_array[$c]['description_goods'];
							$container_array[0][$array_key]['model_name'] 		  = $make_container_array[$c]['model_name'];
							$container_array[0][$array_key]['full_status'] 	  	  = 0;
							$container_array[0][$array_key]['finish_name'] 		  = $make_container_array[$c]['finish_name'];
							$container_array[0][$array_key]['design_file'] 		  = $make_container_array[$c]['design_file'];
							$container_array[0][$array_key]['no_of_pallet']		  = $make_container_array[$c]['no_of_pallet'];
							$container_array[0][$array_key]['no_of_sqm']   		  = $make_container_array[$c]['no_of_sqm'];
							$container_array[0][$array_key]['no_of_boxes'] 		  = $make_container_array[$c]['no_of_boxes'];
							$container_array[0][$array_key]['no_of_sqf'] 		  = $make_container_array[$c]['no_of_sqf'];
							$container_array[0][$array_key]['no_of_big_pallet'] 		  = $make_container_array[$c]['no_of_big_pallet'];
							$container_array[0][$array_key]['no_of_small_pallet'] = $make_container_array[$c]['no_of_small_pallet']; 
							$array_key++; 
						}
						else
						{
							for($i=0;$i<$con;$i++)
							{
								$container_array[$co1] = array();
								$container_array[$co1][$array_key]['production_trn_id']  = $make_container_array[$c]['production_trn_id'];
								$container_array[$co1][$array_key]['product_id']		 = $make_container_array[$c]['product_id'];
								$container_array[$co1][$array_key]['size_type_mm'] 		 = $make_container_array[$c]['size_type_mm'];
								$container_array[$co1][$array_key]['model_name'] 		 = $make_container_array[$c]['model_name'];
								$container_array[$co1][$array_key]['finish_name'] 		 = $make_container_array[$c]['finish_name'];
								$container_array[$co1][$array_key]['design_file'] 		 = $make_container_array[$c]['design_file'];
								$container_array[$co1][$array_key]['no_of_pallet']		 = $make_container_array[$c]['no_of_pallet']/$con;
								$container_array[$co1][$array_key]['no_of_big_pallet'] 	 = $make_container_array[$c]['no_of_big_pallet']/$con;
								$container_array[$co1][$array_key]['full_status'] 		 = 1;
								$container_array[$co1][$array_key]['no_of_boxes'] 		 = $make_container_array[$c]['no_of_boxes']/$con;
								$container_array[$co1][$array_key]['no_of_sqm'] 		 = $make_container_array[$c]['no_of_sqm']/$con;
								$container_array[$co1][$array_key]['no_of_sqf'] 		 = $make_container_array[$c]['no_of_sqf'];
								$container_array[$co1][$array_key]['no_of_small_pallet'] = $make_container_array[$c]['no_of_small_pallet']/$con;
								
								$co1++;
								$array_key=0;
							}
						}
					}
					else if($con < 1)
					{
							if (array_key_exists($array_key,$container_array[0]))
							{	
								$array_key++;
							}
							$container_array[0][$array_key]['production_trn_id']  = $make_container_array[$c]['production_trn_id'];
							$container_array[0][$array_key]['product_id']		  = $make_container_array[$c]['product_id'];
							$container_array[0][$array_key]['size_type_mm'] 	  = $make_container_array[$c]['size_type_mm'];
							$container_array[0][$array_key]['model_name'] 		  = $make_container_array[$c]['model_name'];
							$container_array[0][$array_key]['finish_name'] 		  = $make_container_array[$c]['finish_name'];
							$container_array[0][$array_key]['design_file'] 		  = $make_container_array[$c]['design_file'];
							$container_array[0][$array_key]['no_of_pallet']		  = $make_container_array[$c]['no_of_pallet'];
							$container_array[0][$array_key]['no_of_sqm']   		  = $make_container_array[$c]['no_of_sqm'];
							$container_array[0][$array_key]['no_of_boxes'] 		  = $make_container_array[$c]['no_of_boxes'];
							$container_array[0][$array_key]['no_of_sqf'] 		  = $make_container_array[$c]['no_of_sqf'];
							$container_array[0][$array_key]['no_of_big_pallet'] 		  = $make_container_array[$c]['no_of_big_pallet'];
							$container_array[0][$array_key]['no_of_small_pallet'] = $make_container_array[$c]['no_of_small_pallet']; 
							$array_key++;
						 
				 	}						
			 
			}
		 
			foreach($producation_data as $row)
			{			
					$container_20 = $row->con_twentry;
					$container_40 = $row->con_fourty;
						  					
				for($c=0;$c<$container_20;$c++)
				{
					$d=0;
					 
				 	foreach($container_array[$co] as $detail)
					{
						
						 
						$full_status = ($detail['full_status'] == 1)?$co:0; 
						$data1 = array(
							"performa_invoice_id"   => $performa_invoice_id,
							"container_no" 			=> $full_status,
							"full_status" 			=> ($detail['full_status'] == 1)?1:0,
							"container_size" 	    => ($detail['full_status'] == 1)?20:0,
							"production_trn_id" 	=> $detail['production_trn_id'],
							"size_type_mm" 			=> $detail['size_type_mm'],
							"product_id" 			=> $detail['product_id'],
							"model_name" 			=> $detail['model_name'],
							"finish_name" 			=> $detail['finish_name'],
							"no_of_sqm" 			=> $detail['no_of_sqm'],
						 	"design_file" 			=> $detail['design_file'],
							"no_of_boxes" 			=> $detail['no_of_boxes'],
							"no_of_pallet" 			=> $detail['no_of_pallet'],
							"no_of_big_pallet" 		=> $detail['no_of_big_pallet'],
							"no_of_small_pallet" 	=> $detail['no_of_small_pallet'],
							"status" 				=> 0,
							"cdate" 				=> date('Y-m-d H:i:s')
						);    
							 
				 $insertid = $this->pinv->insert_auto_load($data1);
						 
					}
					$co++;
				}
				for($c=0;$c<$container_40;$c++)
					{
						
						foreach($container_array[$co] as $detail)
						{
						 $full_status = ($detail['full_status'] == 1)?$co:0; 
							$data1 = array(
							"performa_invoice_id" 	=> $performa_invoice_id,
							"container_no" 			=> $full_status,
							"full_status" 			=> ($detail['full_status'] == 1)?1:0,
						 	"container_size" 	    => ($detail['full_status'] == 1)?40:0, 
							"production_trn_id" 	=> $detail['production_trn_id'],
							"size_type_mm" 			=> $detail['size_type_mm'],
							"product_id" 			=> $detail['product_id'],
							"model_name" 			=> $detail['model_name'],
							"finish_name" 			=> $detail['finish_name'],
							"no_of_sqm" 			=> $detail['no_of_sqm'],
						 	"design_file" 			=> $detail['design_file'],
							"no_of_boxes" 			=> $detail['no_of_boxes'],
							"no_of_pallet" 			=> $detail['no_of_pallet'],
							"no_of_big_pallet" 		=> $detail['no_of_big_pallet'],
							"no_of_small_pallet" 	=> $detail['no_of_small_pallet'],
							"status" 				=> 0,
							"cdate" 				=> date('Y-m-d H:i:s')
						);        
				 $insertid = $this->pinv->insert_auto_load($data1);
							
						}
						$co++;
					}
						
			} 
						
						
						foreach($container_array[0] as $detail)
						{
						 	$data1 = array(
								"performa_invoice_id" 	=> $performa_invoice_id,
								"container_no" 			=> 0,
								"container_size" 	    => 0,
								"full_status" 			=> 0,
								"production_trn_id" 	=> $detail['production_trn_id'],
								"size_type_mm" 			=> $detail['size_type_mm'],
								"product_id" 			=> $detail['product_id'],
								"model_name" 			=> $detail['model_name'],
								"finish_name" 			=> $detail['finish_name'],
								"design_file" 			=> $detail['design_file'],
								"no_of_sqm" 			=> $detail['no_of_sqm'],
								"no_of_boxes" 			=> $detail['no_of_boxes'],
								"no_of_pallet" 			=> $detail['no_of_pallet'],
								"no_of_big_pallet" 		=> $detail['no_of_big_pallet'],
								"no_of_small_pallet" 	=> $detail['no_of_small_pallet'],
								"status" 				=> 0,
								"cdate" 				=> date('Y-m-d H:i:s')
							);        
					 	$insertid = $this->pinv->insert_auto_load($data1);
					 	}
				 
			echo 1;
	}
	
	function companywise_print()
	{
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		$companywise_detail = $this->pinv->company_wise_detail($performa_invoice_id,0,0,0);
		$str = '
				<table class="table table-bordered">
					<tr>
						<td class="text-center">Sr No</td>
					 	<td class="text-center" >Supplier Name</td>
						<td class="text-center" >Container</td>
					 	<td class="text-center" >Export Done</td>
					 	<td class="text-center" >Print</td>
				 	</tr>
			 ';
					$no=1;
					$conarray = array();
		foreach($companywise_detail as $row)
		{
			$export_done_status = ($row->export_done_status == 1)?"Done":"Pending";
			$str .= '<tr>
						<td>'.$no.'</td>
						<td>'.$row->company_name.'</td>';
						 
						if(!in_array($row->con_entry.$row->performa_invoice_id,$conarray))
						{	
							$rowspan = ($row->rowcon_no > 0)?$row->rowcon_no:"";
							$str .= '<td rowspan="'.$rowspan.'" class="text-center">'.$row->total_con.'</td>';
							$str .= '<td class="text-center" rowspan="'.$rowspan.'">'.$export_done_status.'</td> ';
								array_push($conarray,$prow->con_entry.$prow->performa_invoice_id);
						}
						
						
				 	$str .= '
						<td class="text-center">
							<a class="tooltips btn btn-info" data-toggle="tooltip" data-title="Print" href="'.base_url().'create_pi_loading/conprint/'.$performa_invoice_id.'/'.$row->supplier_id.'/'.$row->export_time.'" data-original-title="" title=""> Print</a>
						</td>
					</tr>';
					$no++;
		}			
		echo $str;
	}
	function exportwise_print()
	{
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		$companywise_detail = $this->pinv->company_wise_detail($performa_invoice_id,3,0,0);
		$str = '<table class="table table-bordered">
					<tr>
						<td>Sr No</td>
						<td>Export Invoice No</td>
						<td>Supplier Name</td>
						<td>Container</td>
						<td>Print</td>
				 	</tr>';
					$no=1;
		foreach($companywise_detail as $row)
		{
		 	$str .= '<tr>
						<td>'.$no.'</td>
						<td>'.$row->export_invoice_no.'</td>
						<td>'.$row->company_name.'</td>
						<td>'.$row->total_con.'</td>
					 	<td><a href="'.base_url().'create_pi_loading/container_details/'.$performa_invoice_id.'/'.$row->export_time.'" type="button" class="tooltips btn btn-warning" data-title="Container Detail">
								Edit
	 				</a></td>
				 	</tr>';
					$no++;
		}			
		echo $str;
	}
	function conprint($performa_invoice_id,$supplier_id,$export_time)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company			=	$this->pinv->company_select();
			
			$set_container		= 	$this->pinv->loading_data($performa_invoice_id,$supplier_id,$export_time);
		 
			$data				= 	$this->pinv->producation_mst_data($set_container[0]->production_mst_id);
		
			$menu_data			= 	$this->menu->usermain_menu($this->session->usertype_id);	
			$companywise_detail = 	$this->pinv->company_wise_detail($performa_invoice_id,0,$supplier_id,$export_time);
			$v = array(
					'producation_mst'		=>	$data,
					'companywise_detail' 	=>	$companywise_detail,
					'set_container'			=>	$set_container,
					'performa_invoice_id' 	=>	$performa_invoice_id,
					'menu_data'				=>	$menu_data,
					'bank'					=>	$bank,
					'company_detail'		=>	$company,
					'mode' 					=>	"0"
				);
			$this->load->view('admin/print_loading',$v);
		}
		else
		{
			redirect(base_url().'');
		}
		
	}
	function container_detail_entry()
	{
		$no=0;
			 
			foreach($this->input->post('pi_loading_plan_id') as $key)
			{
				$already_done = 0;
				if(!empty($this->input->post('container_no')[$no]))
				{
					$already_done = 1;
				}
				else
				{
					$already_done = 0;
				}
			 	$data1 = array(
					"container_no" 			=> $this->input->post('container_no')[$no],
					"container_size" 		=> $this->input->post('container_size'.$key),
					"container" 			=> $this->input->post('full_container'.$key),
					"seal_no" 				=> $this->input->post('seal_no')[$no],
					"rfidseal_no" 			=> $this->input->post('rfidseal_no')[$no],
					"booking_no" 			=> $this->input->post('booking_no')[$no],
					"lr_no" 				=> $this->input->post('lr_no')[$no],
					"truck_no" 				=> $this->input->post('truck_no')[$no],
					"mobile_no" 			=> $this->input->post('mobile_no')[$no],
					"updated_net_weight" 	=> $this->input->post('net_weight')[$no],
					"updated_gross_weight" 	=> $this->input->post('gross_weight')[$no],
					"remark" 				=> $this->input->post('remarks')[$no],
					"tare_weight" 			=> $this->input->post('tare_weight')[$no],
					
					"already_done" 			=> $already_done
				);
				 
				if($this->input->post('export_done_status')[$no]  == 1)
				{
					$data2 = array(
						"container_size" 		=> $this->input->post('container_size'.$key),
						"container_no" 			=> $this->input->post('container_no')[$no],
						"seal_no" 				=> $this->input->post('seal_no')[$no],
						"self_seal_no" 			=> $this->input->post('rfidseal_no')[$no],
						"booking_no" 			=> $this->input->post('booking_no')[$no],
						"lr_no" 				=> $this->input->post('lr_no')[$no],
						"truck_no" 				=> $this->input->post('truck_no')[$no],
						"mobile_no" 			=> $this->input->post('mobile_no')[$no],
						"updated_net_weight" 	=> $this->input->post('net_weight')[$no],
						"updated_gross_weight" 	=> $this->input->post('gross_weight')[$no],
						"remark" 				=> $this->input->post('remarks')[$no],
						"tare_weight" 			=> $this->input->post('tare_weight')[$no] 
					);
					$trnupdatedid = $this->pinv->update_export_cointainer($data2,$key);
					
					
					$get_export_detail = $this->pinv->get_export_detail($key);
					$delete_vgm = $this->pinv->delete_vgm($get_export_detail->export_invoice_id);
				}
			 	 $no++; 
				 $trnupdatedid = $this->pinv->update_cointainer($data1,$key);
				
			}
			 
			 $no=0;
			foreach($this->input->post('pi_loading_plan_id') as $key)
			{
				$already_done = 0;
				if(!empty($this->input->post('container_no')[$no]))
				{
					$already_done = 1;
				}
				else
				{
					$already_done = 0;
				}
				 
				$data2 = array(
					"already_done"			=> $already_done,
					"seal_no" 	  			=> $this->input->post('seal_no')[$no],
					"rfidseal_no" 			=> $this->input->post('rfidseal_no')[$no],
					"mobile_no" 			=> $this->input->post('mobile_no')[$no],
					"truck_no" 				=> $this->input->post('truck_no')[$no],
					"lr_no" 				=> $this->input->post('lr_no')[$no],
				 	"remark" 				=> $this->input->post('remarks')[$no],
					"container_size" 		=> $this->input->post('container_size'.$key),
					"container" 			=> $this->input->post('full_container'.$key),
					"container_no" 			=> $this->input->post('container_no')[$no]
				);
				$trnupdatedid = $this->pinv->update_loading_plan($this->input->post('con_entry')[$no],$this->input->post('performainvoice_id')[$no],$data2);
					if($this->input->post('export_done_status')[$no]  == 1)
					{
						$data3 = array(
							"seal_no" 	  			=> $this->input->post('seal_no')[$no],
							"self_seal_no" 			=> $this->input->post('rfidseal_no')[$no],
							"mobile_no" 			=> $this->input->post('mobile_no')[$no],
							"lr_no" 				=> $this->input->post('lr_no')[$no],
							"truck_no" 				=> $this->input->post('truck_no')[$no],
							"remark" 				=> $this->input->post('remarks')[$no],
							"container_size" 		=> $this->input->post('container_size'.$key),
							"container_no" 			=> $this->input->post('container_no')[$no]
						);
					  	$trnupdated_id = $this->pinv->update_exportcointainer($this->input->post('con_entry')[$no],$this->input->post('performainvoice_id')[$no],$data3);
					}
				
				$no++; 
			}				
 
		 $row['res'] = "1";
		echo json_encode($row);

	}
	public function container_details($id,$export_id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$company		=	$this->pinv->company_select();
			$bankid			=	$company[0]->bank_name;
			$bank			= 	$this->pinv->bselect($bankid);
			$data			= 	$this->pinv->select_invoice_data($id);
			$set_container	= 	$this->pinv->product_set_data($id,$export_id);
		 	$menu_data		= 	$this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
					'invoicedata'		=>	$data,
					'set_container'		=>	$set_container,
					'menu_data'			=>	$menu_data,
					'allproduct'	 	=>	$this->pinv->allproductsize(),
					'bank'				=>	$bank,
					'company_detail'	=>	$company,
					'mode' 				=>	 "0"
				);
			$this->load->view('admin/pi_container_detail',$v);
		}
		else
		{
			redirect(base_url().'');
		}
			
	}
	public function manageall()
	{
		$set_container		= 	$this->pinv->product_set_data($this->input->post('performa_invoice_id'),-1);
		for($i=0; $i<count($set_container);$i++)
		{
		 	if(!in_array($set_container[$i]->autometic_loading_plan_id,$packingtrn_array))
			{
				array_push($packingtrn_array,$set_container[$i]->autometic_loading_plan_id);
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id] = array();
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['autometic_loading_plan_id']  = $set_container[$i]->autometic_loading_plan_id;
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_boxes']  =$set_container[$i]->origanal_boxes;
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_pallet']  = $set_container[$i]->origanal_pallet;;
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_big_pallet']  = $set_container[$i]->orginal_no_of_big_pallet;;
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_small_pallet']  = $set_container[$i]->orginal_no_of_small_pallet;;
			}
			else
			{
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
				$packingtrnarray[$set_container[$i]->autometic_loading_plan_id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
			}
		}
		$auto_loading_plan 	= 	$this->pinv->get_auto_loading_plan($this->input->post('performa_invoice_id'),1,1);  
		$con_no 			= $this->input->post('con_no');
		$no_of_pallet 		= $this->input->post('no_of_pallet');
		$no_of_big_pallet 	= $this->input->post('no_of_big_pallet');
		$no_of_small_pallet = $this->input->post('no_of_small_pallet');
		$no_of_boxes 		= $this->input->post('no_of_boxes');
		$no_of_sqm 			= $this->input->post('no_of_sqm');
		$batch_no 			= $this->input->post('batch_no');
		$shade_no 			= $this->input->post('shade_no');
		 
		foreach($auto_loading_plan as $detail)
		{
		 	if($detail->no_of_boxes < $packingtrnarray[$detail->autometic_loading_plan_id]['no_of_boxes'] || $packingtrnarray[$detail->autometic_loading_plan_id]['autometic_loading_plan_id'] != $detail->autometic_loading_plan_id)
			{
			 
				$data = array(
					'performa_packing_id'		=>	$detail->performa_packing_id,
					'container_no'				=>	'',
					'container_size'		 	=>	$detail->container_size,
					'con_no'					=>	$detail->container_no,
					'seal_no'					=>	'',
					'rfidseal_no'				=>	'',
					'production_mst_id'		 	=>	$detail->production_mst_id,
					'booking_no'				=>	'',
					'lr_no'					 	=>	'',
					'truck_no'					=>	'',
					'supplier_id'				=>	$detail->supplier_id,
					'mobile_no'					=>  '',
					'remark'					=>	'',
					'performa_trn_id'			=>	$detail->performa_trn_id,
					'production_trn_id'			=>	$detail->production_trn_id,
					'performa_invoice_id'		=>	$this->input->post('performa_invoice_id'),
					'container'					=>	1,
					'origanal_pallet'			=>	$no_of_pallet[$detail->container_no],
					'orginal_no_of_big_pallet'  =>	$no_of_big_pallet[$detail->container_no],
					'orginal_no_of_small_pallet'=>	$no_of_small_pallet[$detail->container_no],
					'origanal_boxes'			=>	$no_of_boxes[$detail->container_no],
					'origanal_sqm'				=>	$no_of_sqm[$detail->container_no],
					'batch_no'					=>	$batch_no[$detail->container_no],
					'shade_no'					=>	$shade_no[$detail->container_no],
				 	'product_id'				=>	$detail->product_id,
					'autometic_loading_plan_id'	=>	$detail->autometic_loading_plan_id,
					'status' 					=>	 "0"
				); 
					$data['con_entry']  = $detail->container_no;
					$insertid 			= $this->pinv->insert_cointainer($data);
				 
			}
			else
			{
				$id 		= $this->input->post('pi_loading_plan_id')[$no];
				$deleteid 	= $this->pinv->deleteloadingtrn($id);
			}
			$no++;
		}
		 $row = array();
		 $row['res'] = 1;
			
		echo json_encode($row);
			 
	}
	public function manual_manage()
	{
		$first=1;
		$no = 0;
		  
		foreach($this->input->post('performa_packing_id') as $row)
		{ 	
			if($this->input->post('no_of_boxes')[$no] > 0 || $this->input->post('no_of_sqm')[$no] > 0)
			{
				$data = array(
					'performa_packing_id'		=>	$row,
					'container_no'				=>	$this->input->post('container_no'),
					'container_size'		 	=>	$this->input->post('container_size'),
					'con_no'					=>	$this->input->post('con_no'),
					'seal_no'					=>	$this->input->post('seal_no'),
					'rfidseal_no'				=>	$this->input->post('rfidseal_no'),
					'production_mst_id'		 	=>	$this->input->post('production_mst_id')[$no],
					'booking_no'				=>	$this->input->post('booking_no'),
					'lr_no'					 	=>	$this->input->post('lr_no'),
					'truck_no'					=>	$this->input->post('truck_no'),
					'supplier_id'				=>	$this->input->post('supplier_id')[$no],
					'mobile_no'					=>	$this->input->post('mobile_no'),
					'remark'					=>	$this->input->post('remark'),
					'performa_trn_id'			=>	$this->input->post('performa_trn_id')[$no],
					'production_trn_id'			=>	$this->input->post('production_trn_id')[$no],
					'performa_invoice_id'		=>	$this->input->post('performainvoice_id'),
					'container'					=>	$this->input->post('container')[$no],
					'loading_container'			=>	$this->input->post('loading_container')[$no],
					'origanal_pallet'			=>	$this->input->post('no_of_pallet')[$no],
					'orginal_no_of_big_pallet'  =>	$this->input->post('no_of_big_pallet')[$no],
					'orginal_no_of_small_pallet'=>	$this->input->post('no_of_small_pallet')[$no],
					'origanal_boxes'			=>	$this->input->post('no_of_boxes')[$no],
					'origanal_sqm'		 		=>	$this->input->post('no_of_sqm')[$no],
					'batch_no'					=>	$this->input->post('batch_no')[$no],
					'shade_no'					=>	$this->input->post('shade_no')[$no],
					'autometic_loading_plan_id'	=>	$this->input->post('autometic_loading_plan_id')[$no],
				 	'product_id'				=>	$this->input->post('product_id')[$no],
					'status' 					=>	 "0"
				); 
			 
				$id = $this->input->post('pi_loading_plan_id')[$no];
				if(!empty($id))
				{
				 	$updateid = $this->pinv->update_cointainer($data,$id);
				}
				else
				{
					$data['con_entry'] = $this->input->post('con_entry');
				 	$insertid = $this->pinv->insert_cointainer($data);
				}
			}
			else
			{
				$id = $this->input->post('pi_loading_plan_id')[$no];
				$deleteid = $this->pinv->deleteloadingtrn($id);
			}
			$no++;
		}
		 $row = array();
		 $row['res'] = 1;
			
		echo json_encode($row);
			 
	}
	public function manage()
	{
		$first=1;
		$no = 0;
		 
		foreach($this->input->post('performa_packing_id') as $row)
		{
			 
		 	if($this->input->post('no_of_boxes')[$no] > 0)
			{
				$data = array(
					'performa_packing_id'		 =>	$row,
					'container_no'				 =>	$this->input->post('container_no'),
					'container_size'		 	 =>	$this->input->post('containersize')[$no],
					'con_no'					 =>	$this->input->post('con_no')[$no],
					'seal_no'					 =>	$this->input->post('seal_no'),
					'rfidseal_no'				 =>	$this->input->post('rfidseal_no'),
					'production_mst_id'		 	 =>	$this->input->post('production_mst_id')[$no],
					'booking_no'				 =>	$this->input->post('booking_no'),
					'lr_no'					 	 =>	$this->input->post('lr_no'),
					'truck_no'					 =>	$this->input->post('truck_no'),
					'supplier_id'				 =>	$this->input->post('supplier_id')[$no],
					'mobile_no'					 =>	$this->input->post('mobile_no'),
					'remark'					 =>	$this->input->post('remark'),
					'performa_trn_id'			 =>	$this->input->post('performa_trn_id')[$no],
					'production_trn_id'			 =>	$this->input->post('production_trn_id')[$no],
					'performa_invoice_id'		 =>	$this->input->post('performainvoice_id'),
					'container'					 =>	1,
					'origanal_pallet'			 =>	$this->input->post('no_of_pallet')[$no],
					'orginal_no_of_big_pallet'   =>	$this->input->post('no_of_big_pallet')[$no],
					'orginal_no_of_small_pallet' =>	$this->input->post('no_of_small_pallet')[$no],
					'origanal_boxes'			 =>	$this->input->post('no_of_boxes')[$no],
					'origanal_sqm'				 =>	$this->input->post('no_of_sqm')[$no],
					'batch_no'					 =>	$this->input->post('batch_no')[$no],
					'shade_no'					 =>	$this->input->post('shade_no')[$no],
				 	'product_id'				 =>	$this->input->post('product_id')[$no],
				 	'autometic_loading_plan_id'	 =>	$this->input->post('autometic_loading_plan_id')[$no],
					'status' 					 =>	 "0"
				); 
				 
				$id = $this->input->post('pi_loading_plan_id')[$no];
			 
				if(!empty($id))
				{
					$updateid = $this->pinv->update_cointainer($data,$id);
				}
				else
				{
					$data['con_entry'] = $this->input->post('con_no')[$no];
					$insertid = $this->pinv->insert_cointainer($data);
				}
			}
			else
			{
				$id = $this->input->post('pi_loading_plan_id')[$no];
				$deleteid = $this->pinv->deleteloadingtrn($id);
			}
			$no++;
		}
		 $row = array();
		 $row['res'] = 1;
			
		echo json_encode($row);
			 
	}
	
	public function add_product()
	{
		$id1= $this->input->post('pinvoice_id');
		
			$description_goodsarray = $this->pinv->hsncproductsizedetail($this->input->post('product_id'),2);
			$thickness = !empty($description_goodsarray[0]->thickness)?' - '.$description_goodsarray[0]->thickness.' MM':"";
			  $description = $description_goodsarray[0]->size_type_mm.' ('.$description_goodsarray[0]->series_name.')';
			   $pallet_status = 2;
			   if($this->input->post('no_of_pallet') > 0)
			   {
				   $pallet_status = 1;
			   }
			   else if($this->input->post('no_of_big_pallet') > 0 || $this->input->post('no_of_small_pallet') > 0)
			   {
				    $pallet_status = 3;
			   }
			  
			$data = array(
				'invoice_id'			=> $this->input->post('pinvoice_id'),
				'product_id' 			=> $this->input->post('product_id'),
				'product_size_id' 	 	=> $this->input->post('packing_id'),
		 	 	'product_container' 	=> 0,
				'description_goods' 	=> $description,
				'pallet_status' 		=> $pallet_status,
				'weight_per_box' 		=> $this->input->post('weight_per_box'),
				'pallet_weight'	 		=> $this->input->post('pallet_weight'),
				'big_pallet_weight'	 	=> $this->input->post('big_pallet_weight'),
				'small_pallet_weight'	=> $this->input->post('small_pallet_weight'),
				'boxes_per_pallet'  	=> $this->input->post('boxes_per_pallet'),
				'box_per_big_pallet'  	=> $this->input->post('big_boxes_per_pallet'),
				'box_per_small_pallet'  => $this->input->post('small_boxes_per_pallet'),
				'sqm_per_box' 			=> $this->input->post('sqm_per_box'),
				'pcs_per_box' 			=> $this->input->post('pcs_per_box'),
				'total_no_of_pallet' 	=> ($this->input->post('no_of_pallet') + $this->input->post('no_of_big_pallet') +$this->input->post('no_of_small_pallet')),
				'total_no_of_boxes' 	=> $this->input->post('boxes'),
				'total_no_of_sqm' 		=> $this->input->post('total_no_of_sqm'),
			 	'total_product_amt' 	=> 0,
				'total_pallet_weight' 	=> $this->input->post('pallet_weight'),
				'total_net_weight' 		=> $this->input->post('net_weight'),
				'total_gross_weight' 	=> $this->input->post('gross_weight'),
				'container_half' 		=> 0,
				'extra_loading'		 	=> 1,
			  	'cdate'				 	 =>date('Y-m-d H:i:s')
				);
			 
				$insertid = $this->pinv->insert_productrecord($data);
					$packing_data = array(
						"performa_trn_id"		 => $insertid,
						"design_id" 			 => $this->input->post('design_id'),
						"finish_id" 			 => $this->input->post('finish_id'),
						"client_name" 			 => $this->input->post('client_design_name'),
						"barcode_no" 			 => '',
						"product_rate" 			 => 0,
						"no_of_pallet" 			 => $this->input->post('no_of_pallet'),
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet'),
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet'),
						"no_of_boxes" 			 => $this->input->post('boxes'),
						"no_of_sqm" 			 => $this->input->post('total_no_of_sqm'),
						"per" 					 => 'SQM',
						"product_amt" 			 => 0,
						"packing_net_weight"	 => $this->input->post('net_weight'),
						"packing_gross_weight" 	 => $this->input->post('gross_weight') 
						);
						$insertrecord = $this->pinv->insert_packing_data($packing_data);
			
						
			$pi_data = array(
					'performa_packing_id'		=>	$insertrecord,
					'production_trn_id'			=>	$insertid,
					'container_no'				=>	$this->input->post('new_container_no'),
					'container_size'	 		=>	$this->input->post('new_container_size'),
					'seal_no'					=>	$this->input->post('new_seal_no'),
					'rfidseal_no'				=>	$this->input->post('new_rfidseal_no'),
					'production_mst_id'		 	=>	$this->input->post('production_mst_id'),
					'booking_no'				=>	$this->input->post('new_booking_no'),
					'lr_no'						=>	$this->input->post('new_lr_no'),
					'truck_no'					=>	$this->input->post('new_truck_no'),
					'mobile_no'					=>	$this->input->post('mobile_no'),
					'remark'					=>	$this->input->post('new_remark'),
					'tare_weight'				=>	$this->input->post('new_tare_weight'),
					'performa_trn_id'			=>	$insertid,
					'performa_invoice_id'		=>	$this->input->post('pinvoice_id'),
					'con_entry'					=>	$this->input->post('new_conentry'),
					'origanal_pallet'			=>	$this->input->post('no_of_pallet'),
					'orginal_no_of_big_pallet'  =>	$this->input->post('no_of_big_pallet'),
					'orginal_no_of_small_pallet'=>	$this->input->post('no_of_small_pallet'),
					'origanal_boxes'			=>	$this->input->post('boxes'),
				 	'product_id'				=>	$this->input->post('product_id'),
				 	'batch_no'					=>	$this->input->post('batch_no'),
				 	'shade_no'					=>	$this->input->post('shade_no'),
				 	'supplier_id'			 	=>	$this->input->post('new_supplierid'),
				 	'container'			 		=>	$this->input->post('new_container'),
					'status' 					=>	 "0"
			); 
			$insertid = $this->pinv->insert_cointainer($pi_data);
	
						
			$updateweight_data = array
						(
						
						'updated_net_weight'		=>	0,
						'updated_gross_weight'		=>	0
						
						);
						
						$insertrecord1 = $this->pinv->updat_data($updateweight_data,$id1);
						
			echo "1";
			
	}
	public function load_packing()
	{
		$product_id = $this->input->post('product_id');
		$getpacking	= $this->pinv->get_product_size($product_id);
		$str = '<option value="">Select Packing</option>';
		foreach($getpacking as $packing)
		{
			$str .= '<option value="'.$packing->product_size_id.'">'.$packing->product_packing_name.'</option>';
		}
		echo $str;
	}
	public function load_design()
	{
		$product_size_id = $this->input->post('product_size_id');
		$packing_data 	= $this->pinv->get_product_size_detail($product_size_id);
		
		$getdesign		= $this->pinv->get_design($packing_data->product_id);
		 $str = '<option value="">Select Design</option>';
		foreach($getdesign as $packing)
		{
			$str .= '<option value="'.$packing->packing_model_id.'">'.$packing->model_name.'</option>';
		}
		$row = array();
		$row['design_html'] = $str;
		$row['packing'] = $packing_data;
		
		echo json_encode($row);
	}
	public function deleteloading()
	{
		$con_entry=$this->input->post('con_entry');
		$performa_invoice_id=$this->input->post('performa_invoice_id');
		
		$deleteid=$this->pinv->delete_loadingtrn($con_entry,$performa_invoice_id);
		//$deleteid=$this->pinv->auto_loading($performa_invoice_id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function change_full_status()
	{
		$autometic_loading_plan_id = $this->input->post('autometic_loading_plan_id');
		$data = array(
			"full_status" =>0,
			"container_no" =>0
		);
	 	$deleteid=$this->pinv->change_full_status($data,$autometic_loading_plan_id);
		 
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function copy_containter()
	{
		$performa_invoice_id 		= $this->input->post('performa_invoice_id');
		$production_mst_id 			= $this->input->post('production_mst_id');
		$production_trn_id 			= $this->input->post('production_trn_id');
		$autometic_loading_plan_id 	= $this->input->post('autometic_loading_plan_id');
		$company_name 	   			= $this->input->post('company_name');
		$supplier_id 	   			= $this->input->post('supplier_id');
		$container 	  				= $this->input->post('container');
	 	$get_data					= $this->pinv->producation_trn_data($production_mst_id);
		$set_container				= $this->pinv->product_set_data($performa_invoice_id,-1);
		$packingtrn_array = array();
		for($i=0; $i<count($set_container);$i++)
		{
			if(!in_array($set_container[$i]->production_trn_id,$packingtrn_array))
			{
				array_push($packingtrn_array,$set_container[$i]->production_trn_id);
			 	$packingtrnarray[$set_container[$i]->production_trn_id] = array();
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_boxes']  =$set_container[$i]->origanal_boxes;
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_sqm']  =$set_container[$i]->origanal_sqm;
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_pallet']  = $set_container[$i]->origanal_pallet;;
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_big_pallet']  = $set_container[$i]->orginal_no_of_big_pallet;;
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_small_pallet']  = $set_container[$i]->orginal_no_of_small_pallet;;
			}
			else
			{
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_sqm'] += $set_container[$i]->no_of_sqm;
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
			}
		}
		$str = '<table class="table table-bordered">
					<tr>
						<td class="text-center" width="10%">Product Name</td>
						<td class="text-center" width="10%">Design Name</td>
						<td class="text-center" width="10%">Finish Name</td>
						<td class="text-center" width="10%">Pallet</td>
						<td class="text-center" width="10%">Boxes</td>
						<td class="text-center" width="10%">Sqm</td>
						<td class="text-center" width="10%">Unit</td>
						<td class="text-center" width="10%">Quantity</td>
						<td class="text-center" width="10%">Batch No</td>
						<td class="text-center" width="10%">Shade No</td>
					</tr>';
		foreach($get_data as $packing)
		{
				 if(in_array($packing->production_trn_id,$production_trn_id))
				 {
					 
			$str .= '  <tr>';
			 if($packing->product_id == 0)
			 {
				 $qty =0;
				 
				 if($packing->per == "SQM")
				 {
					 
					$no_of_sqm 	= ($packing->product_id == 0)?$packing->no_of_sqm:($no_of_boxes * $packing->sqm_per_box);
						
				 	$qty = '<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$packing->production_trn_id.'" value="'.$no_of_sqm.'" class="form-control" />';
				 }
				 else if($packing->per == "BOX")
				 {
					 $no_of_boxes 	= $packing->no_of_boxes - $packingtrnarray[$packing->production_trn_id]["no_of_boxes"];
				 	$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$no_of_boxes.'" onblur="cal_box_invoice('.$packing->production_trn_id.')"  onkeyup="cal_box_invoice('.$packing->production_trn_id.')" class="form-control"/>';
				 	 
				 }
				 else if($packing->per == "SQF")
				 {
					  $no_of_boxes 	= $packing->no_of_boxes - $packingtrnarray[$packing->production_trn_id]["no_of_boxes"];
				 	$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$no_of_boxes.'" onblur="cal_box_invoice('.$packing->production_trn_id.')"  onkeyup="cal_box_invoice('.$packing->production_trn_id.')" class="form-control" />';
				 }
				 else if($packing->per == "PCS")
				 {
					  $no_of_boxes 	= $packing->no_of_boxes - $packingtrnarray[$packing->production_trn_id]["no_of_boxes"];
				 	$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$no_of_boxes.'" onblur="cal_box_invoice('.$packing->production_trn_id.')"  onkeyup="cal_box_invoice('.$packing->production_trn_id.')" class="form-control" />';
				 }
				 $str .= '<td colspan="6" class="text-center">'.$packing->description_goods.'</td> ';
				 $str .= '<td class="text-center">'.$packing->per.'</td> ';
				 $str .= '<td class="text-center">'.$qty.'</td> ';
		 	 }
			 else
			 {				
				$str .= '<td class="text-center">'.$packing->size_type_mm.'('.$packing->series_name.')</td>
						 <td class="text-center">'.$packing->model_name.'</td>
						 <td class="text-center">'.$packing->finish_name.'</td>';
						 if($packing->no_of_pallet>0)
						{
							$no_of_pallet = $packing->no_of_pallet - $packingtrnarray[$packing->production_trn_id]["no_of_pallet"];
							 
						$str .= '<td class="text-center">
									<input type="text" name="no_of_pallet[]" id="no_of_pallet'.$packing->production_trn_id.'" value="'.$no_of_pallet.'" onblur="cal_product_invoice('.$packing->production_trn_id.')"  onkeyup="cal_product_invoice('.$packing->production_trn_id.')" />
									<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->production_trn_id.'" value="0"   />
									<br>
									<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->production_trn_id.'" value="0" />
								</td>';
						}
						else if($packing->no_of_big_pallet>0 || $packing->no_of_small_pallet>0)
						{
							$no_of_big_pallet 	= $packing->no_of_big_pallet - $packingtrnarray[$packing->production_trn_id]["no_of_big_pallet"];
							$no_of_small_pallet = $packing->no_of_small_pallet - $packingtrnarray[$packing->production_trn_id]["no_of_small_pallet"];
							 
							$str .= '<td class="text-center">
										<input type="hidden" name="no_of_pallet[]" id="no_of_pallet'.$packing->production_trn_id.'" value="0" class="form-control" />
										<input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->production_trn_id.'" value="'.$no_of_big_pallet.'" onblur="cal_product_invoice('.$packing->production_trn_id.')" class="form-control" onkeyup="cal_product_invoice('.$packing->production_trn_id.')"  />
										<br>
										<input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->production_trn_id.'" value="'.$no_of_small_pallet.'" onblur="cal_product_invoice('.$packing->production_trn_id.')" class="form-control"  onkeyup="cal_product_invoice('.$packing->production_trn_id.')" />
									</td>';
						}
						else  
						{
							
								$str .= '<td class="text-center">
											<input type="hidden" name="no_of_pallet[]" id="no_of_pallet'.$packing->production_trn_id.'" value="0"  />
											<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->production_trn_id.'" value="'.$packing->no_of_big_pallet.'" value="0"  />
											<br>
											<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->production_trn_id.'" value="'.$packing->no_of_small_pallet.'" value="0"/>
										</td>';
							
						}
						$no_of_boxes 	= $packing->no_of_boxes - $packingtrnarray[$packing->production_trn_id]["no_of_boxes"];
						$no_of_sqm 	= ($packing->product_id == 0)?$packing->no_of_sqm:($no_of_boxes * $packing->sqm_per_box);
						 
						if($no_of_boxes > 0)
						{							
						$str .= '<td class="text-center">
									<input type="text" class="form-control" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$no_of_boxes.'" onblur="cal_box_invoice('.$packing->production_trn_id.')"  onkeyup="cal_box_invoice('.$packing->production_trn_id.')" />
								</td>';
						}
						else
						{
								$str .= '<td class="text-center">
									 
								</td>';
						}
						$str .= '<td>
									<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$packing->production_trn_id.'" value="'.$no_of_sqm.'" class="form-control" readonly/>
								 </td>
								 <td class="text-center"> - </td> 
								 <td class="text-center"> - </td>';
			 }			
			$str .= '<td>
						<input type="text" name="batch_no[]" id="batch_no'.$packing->production_trn_id.'" value=""  />
					</td>
					<td>
						<input type="text" name="shade_no[]" id="shade_no'.$packing->production_trn_id.'" value=""  />
					</td>
					<input type="hidden" name="pallet_status[]" id="pallet_status'.$packing->production_trn_id.'" value="'.$packing->pallet_status.'" />
					<input type="hidden" name="sqm_per_box[]" id="sqm_per_box'.$packing->production_trn_id.'" value="'.$packing->sqm_per_box.'" />
					<input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet'.$packing->production_trn_id.'" value="'.$packing->boxes_per_pallet.'" />
					<input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet'.$packing->production_trn_id.'" value="'.$packing->box_per_big_pallet.'" />
					<input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet'.$packing->production_trn_id.'" value="'.$packing->box_per_small_pallet.'" />
					<input type="hidden" name="performa_packing_id[]" id="performa_packing_id'.$packing->production_trn_id.'" value="'.$packing->performa_packing_id.'" />
					<input type="hidden" name="performa_trn_id[]" id="performa_trn_id'.$packing->production_trn_id.'" value="'.$packing->performa_trn_id.'" />
					<input type="hidden" name="product_id[]" id="product_id'.$packing->performa_packing_id.'" value="'.$packing->product_id.'" />
					<input type="hidden" name="production_mst_id[]" id="production_mst_id'.$packing->production_trn_id.'" value="'.$production_mst_id.'" />
					<input type="hidden" name="production_trn_id[]" id="production_trn_id'.$packing->production_trn_id.'" value="'.$packing->production_trn_id.'" />
					<input type="hidden" name="container[]" id="container'.$packing->production_trn_id.'" value="'.$container.'" />
					<input type="hidden" name="company_name[]" id="company_name'.$packing->production_trn_id.'" value="'.$company_name.'" />
					<input type="hidden" name="autometic_loading_plan_id[]" id="autometic_loading_plan_id'.$packing->production_trn_id.'" value="'.$packing->autometic_loading_plan_id.'" />
					<input type="hidden" name="supplier_id[]" id="supplier_id'.$packing->production_trn_id.'" value="'.$supplier_id.'" />
				 </tr>';	
				 }
				 
		}
		 $str .= '</table>';
				
				 
		echo $str;
	}
	public function copy_multiple_containter()
	{
		 
		$production_trn_id = implode(",",$this->input->post('production_trn_id'));
		$performa_invoice_id =  $this->input->post('performa_invoice_id');
		
		 
		$get_data				= $this->pinv->producation_trn_multiple_data($production_trn_id);
		 $set_container			= $this->pinv->product_set_data($performa_invoice_id,-1);
		$packingtrn_array = array();
		for($i=0; $i<count($set_container);$i++)
		{
			if(!in_array($set_container[$i]->production_trn_id,$packingtrn_array))
			{
				array_push($packingtrn_array,$set_container[$i]->production_trn_id);
			 	$packingtrnarray[$set_container[$i]->production_trn_id] = array();
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_boxes']  =$set_container[$i]->origanal_boxes;
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_pallet']  = $set_container[$i]->origanal_pallet;;
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_big_pallet']  = $set_container[$i]->orginal_no_of_big_pallet;;
				$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_small_pallet']  = $set_container[$i]->orginal_no_of_small_pallet;;
			}
			else
			{
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
				 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
			}
		}
		$str = '<table class="table table-bordered">
					<tr>
						<td class="text-center" width="10%">Product Name</td>
						<td class="text-center" width="10%">Design Name</td>
						<td class="text-center" width="10%">Finish Name</td>
						<td class="text-center" width="10%">Pallet</td>
						<td class="text-center" width="10%">Boxes</td>
						<td class="text-center" width="10%">Sqm</td>
						<td class="text-center" width="10%">Unit</td>
						<td class="text-center" width="10%">Quantity</td>
						<td class="text-center" width="10%">Batch No</td>
						<td class="text-center" width="10%">Shade No</td>
					</tr>';
		 
		$no=0;
		foreach($get_data as $packing)
		{
			$container = 1;
			$loading_container = $this->input->post('remaining_container')[$packing->production_trn_id];
			 
			$str .= '  <tr>';
			
			if($packing->product_id == 0)
			 {
				 $qty =0;
				  
				 if($packing->per == "SQM")
				 {
					 
					$no_of_sqm 	= ($packing->product_id == 0)?$packing->no_of_sqm:($no_of_boxes * $packing->sqm_per_box);
						
				 	$qty = '<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$packing->production_trn_id.'" value="'.$no_of_sqm.'" class="form-control" />';
				 }
				 else if($packing->per == "BOX")
				 {
					 $no_of_boxes 	= $packing->no_of_boxes - $packingtrnarray[$packing->production_trn_id]["no_of_boxes"];
				 	$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$no_of_boxes.'" onblur="cal_box_invoice('.$packing->production_trn_id.')"  onkeyup="cal_box_invoice('.$packing->production_trn_id.')" class="form-control"/>';
				 	 
				 }
				 else if($packing->per == "SQF")
				 {
					  $no_of_boxes 	= $packing->no_of_boxes - $packingtrnarray[$packing->production_trn_id]["no_of_boxes"];
				 	$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$no_of_boxes.'" onblur="cal_box_invoice('.$packing->production_trn_id.')"  onkeyup="cal_box_invoice('.$packing->production_trn_id.')" class="form-control" />';
				 }
				 else if($packing->per == "PCS")
				 {
					  $no_of_boxes 	= $packing->no_of_boxes - $packingtrnarray[$packing->production_trn_id]["no_of_boxes"];
				 	$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$no_of_boxes.'" onblur="cal_box_invoice('.$packing->production_trn_id.')"  onkeyup="cal_box_invoice('.$packing->production_trn_id.')" class="form-control" />';
				 }
				 $str .= '<td colspan="6" class="text-center">'.$packing->description_goods.'</td> ';
				 $str .= '<td class="text-center">'.$packing->per.'</td> ';
				 $str .= '<td class="text-center">'.$qty.'</td> ';
		 	 }
			 else
			 {
						$str .= '<td>'.$packing->size_type_mm.'('.$packing->series_name.')</td>
						<td>'.$packing->model_name.'</td>
						<td>'.$packing->finish_name.'</td>';
						if($packing->no_of_pallet>0)
						{
							$no_of_pallet = $packing->no_of_pallet - $packingtrnarray[$packing->production_trn_id]["no_of_pallet"];
							 
						$str .= '<td>
									<input type="text" name="no_of_pallet[]" id="no_of_pallet'.$packing->production_trn_id.'" value="'.$no_of_pallet.'" onblur="cal_product_invoice('.$packing->production_trn_id.')"  onkeyup="cal_product_invoice('.$packing->production_trn_id.')" />
									<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->production_trn_id.'" value="0"   />
										<br>
										<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->production_trn_id.'" value="0" />
								</td>';
						}
						else if($packing->no_of_big_pallet>0 || $packing->no_of_small_pallet>0)
						{
							$no_of_big_pallet 	= $packing->no_of_big_pallet - $packingtrnarray[$packing->production_trn_id]["no_of_big_pallet"];
							$no_of_small_pallet = $packing->no_of_small_pallet - $packingtrnarray[$packing->production_trn_id]["no_of_small_pallet"];
							 
							$str .= '<td>
										<input type="hidden" name="no_of_pallet[]" id="no_of_pallet'.$packing->production_trn_id.'" value="0"  />
										<input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->production_trn_id.'" value="'.$no_of_big_pallet.'" onblur="cal_product_invoice('.$packing->production_trn_id.')"  onkeyup="cal_product_invoice('.$packing->production_trn_id.')"  />
										<br>
										<input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->production_trn_id.'" value="'.$no_of_small_pallet.'" onblur="cal_product_invoice('.$packing->production_trn_id.')"  onkeyup="cal_product_invoice('.$packing->production_trn_id.')" />
									</td>';
						}
						else  
						{
							
								$str .= '<td>
										<input type="hidden" name="no_of_pallet[]" id="no_of_pallet'.$packing->production_trn_id.'" value="0"  />
										<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->production_trn_id.'" value="'.$packing->no_of_big_pallet.'" value="0"  />
										<br>
										<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->production_trn_id.'" value="'.$packing->no_of_small_pallet.'" value="0"/>
									</td>';
							
						}
						$no_of_boxes 	= $packing->no_of_boxes - $packingtrnarray[$packing->production_trn_id]["no_of_boxes"];
						$no_of_sqm 	= ($packing->product_id == 0)?$packing->no_of_sqm:($no_of_boxes * $packing->sqm_per_box);
						 
						if($no_of_boxes > 0)
						{							
						$str .= '<td>
									<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$no_of_boxes.'" onblur="cal_box_invoice('.$packing->production_trn_id.')"  onkeyup="cal_box_invoice('.$packing->production_trn_id.')" />
								</td>';
						}
						else
						{
								$str .= '<td>
									 
								</td>';
						}
								$str .= '<td>
									<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$packing->production_trn_id.'" value="'.$no_of_sqm.'" class="form-control" readonly/>
								</td> 
								 <td class="text-center"> - </td> 
								 <td class="text-center"> - </td>';
			 }			
								$str .= '<td>
									<input type="text" name="batch_no[]" id="batch_no'.$packing->production_trn_id.'" value=""  />
								</td>
								<td>
									<input type="text" name="shade_no[]" id="shade_no'.$packing->production_trn_id.'" value=""  />
								</td>
								  <input type="hidden" name="pallet_status[]" id="pallet_status'.$packing->production_trn_id.'" value="'.$packing->pallet_status.'" />
								 <input type="hidden" name="sqm_per_box[]" id="sqm_per_box'.$packing->production_trn_id.'" value="'.$packing->sqm_per_box.'" />
								 <input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet'.$packing->production_trn_id.'" value="'.$packing->boxes_per_pallet.'" />
								 <input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet'.$packing->production_trn_id.'" value="'.$packing->box_per_big_pallet.'" />
								 <input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet'.$packing->production_trn_id.'" value="'.$packing->box_per_small_pallet.'" />
								 <input type="hidden" name="performa_packing_id[]" id="performa_packing_id'.$packing->production_trn_id.'" value="'.$packing->performa_packing_id.'" />
								 <input type="hidden" name="performa_trn_id[]" id="performa_trn_id'.$packing->production_trn_id.'" value="'.$packing->performa_trn_id.'" />
								 <input type="hidden" name="product_id[]" id="product_id'.$packing->performa_packing_id.'" value="'.$packing->product_id.'" />
								 <input type="hidden" name="production_mst_id[]" id="production_mst_id'.$packing->production_trn_id.'" value="'.$packing->production_mst_id.'" />
								 <input type="hidden" name="production_trn_id[]" id="production_trn_id'.$packing->production_trn_id.'" value="'.$packing->production_trn_id.'" />
								 <input type="hidden" name="container[]" id="container'.$packing->production_trn_id.'" value="'.$container.'" />
								 <input type="hidden" name="loading_container[]" id="loading_container'.$packing->production_trn_id.'" value="'.$loading_container.'" />
								  
								 <input type="hidden" name="company_name[]" id="company_name'.$packing->production_trn_id.'" value="'.$packing->company_name.'" />
								 <input type="hidden" name="supplier_id[]" id="supplier_id'.$packing->production_trn_id.'" value="'.$packing->supplier_id.'" />
								 <input type="hidden" name="autometic_loading_plan_id[]" id="autometic_loading_plan_id'.$packing->production_trn_id.'" value="'.$packing->autometic_loading_plan_id.'" />
						</tr>';	
			$no++;	 
				 
		}
		 $str .= '</table>';
		echo $str;
	}
	
	public function editloading()
		{
		$con_entry				= $this->input->post('con_entry');
		$performa_invoice_id	= $this->input->post('performa_invoice_id');
		
		$get_data=$this->pinv->edit_loadingtrn($con_entry,$performa_invoice_id);
		$str = '<table class="table table-bordered">
					<tr>
						<td class="text-center" width="5%">  </td>
						<td class="text-center" width="13%">Product Name</td>
						<td class="text-center" width="10%">Design Name</td>
						<td class="text-center" width="10%">Finish Name</td>
						<td class="text-center" width="9%">Pallet</td>
						<td class="text-center" width="9%">Boxes</td>
						<td class="text-center" width="9%">SQM</td>
						<td class="text-center" width="9%">Unit</td>
						<td class="text-center" width="9%">Quantity</td>
						<td class="text-center" width="9%">Batch No</td>
						<td class="text-center" width="9%">Shade No</td>
					</tr>';
					$row_array = array();
					$make_once_pallet	=  array();
					$pi_loading_plan_id = 0;
					$no	= 1;
					$n	= 1;
		foreach($get_data as $packing)
		{
			
				 
			$str .= '  <tr>
						<td class="text-center">';
					 	if(empty($packing->production_mst_id))
						{
							$pallet_ids = explode(",",$packing->pallet_row);
					 		$checked 	= ''; 
							$readonly 	= 'readonly';
							if(in_array($packing->pi_loading_plan_id,$pallet_ids))
							{
								$checked = 'checked';
								$readonly = 'disabled';
								array_push($make_once_pallet,1);
								$str .= '<input type="hidden" name="already_pi_loading_plan_id[]" id="already_pi_loading_plan_id'.$packing->pi_loading_plan_id.'" value="1"  />';
							}
							else
							{
								$pi_loading_plan_id = ($no==1)?$packing->pi_loading_plan_id:$pi_loading_plan_id;
								$str .= '<input type="hidden" name="already_pi_loading_plan_id[]" id="already_pi_loading_plan_id'.$packing->pi_loading_plan_id.'" value="2"  />';
								array_push($make_once_pallet,2);
								$no++;
							}
							$str .= '
								<input type="checkbox" name="make_pallet[]" id="make_pallet'.$packing->pi_loading_plan_id.'" value="'.$packing->pi_loading_plan_id.'" '.$checked.' '.$readonly.' style="width: 30px;height: 30px;" />
							
								<a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Delete Extra Product" onclick="delete_pallet('.$packing->con_entry.','.$performa_invoice_id.','.$packing->supplier_id.','.$packing->pi_loading_plan_id.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-trash"></i></a>
							';
					  	}
						 
				 	$str .= '
						</td>';
						
						if($packing->product_id == 0)
						{
							$str .= '<td class="text-center" colspan="6">'.$packing->description_goods.' </td>';
							$qty =0;
							if($packing->per == "SQM")
							{
								$qty = $qty = '<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$packing->production_trn_id.'" value="'.$packing->origanal_sqm.'" class="form-control" />';;
							}
							else if($packing->per == "BOX")
							{
								$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$packing->origanal_boxes.'"  class="form-control"/>';
								
							}
							else if($packing->per == "SQF")
							{
								$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$packing->origanal_boxes.'"  class="form-control"/>';
								
							}
							else if($packing->per == "PCS")
							{
								$qty = '<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$packing->production_trn_id.'" value="'.$packing->origanal_boxes.'"  class="form-control"/>';
								
							}
							$str .= '<td class="text-center">'.$packing->per.' </td>';
							$str .= '<td class="text-center">'.$qty.' </td>';
						}
						else
						{
						$str .= '<td class="text-center">'.$packing->size_type_mm.'('.$packing->series_name.')</td>
						<td class="text-center">'.$packing->model_name.'</td>
						<td class="text-center">'.$packing->finish_name.'</td>';
						if(!empty($packing->pallet_ids)  && $packing->make_pallet_no > 0)
						{
							 
							$pallet_ids = explode(",",$packing->pallet_row);
							$str .= '<td class="text-center" rowspan="'.count($pallet_ids).'">
											'.$packing->make_pallet_no.'   <a href="javascript:;" onclick="delete_pallet('.$con_entry.','.$performa_invoice_id.','.$packing->supplier_id.',&quot;'.$packing->pallet_ids.'&quot;)"  >Delete Pallet</a>
									</td>';	
						 
						}
						else if(!empty($packing->production_mst_id) || empty($packing->pallet_row))
						{
						 	if($packing->origanal_pallet>0)
							{
							
								$str .= '<td class="text-center">
										<input type="text" class="form-control" name="no_of_pallet[]" id="no_of_pallet'.$packing->performa_packing_id.'" value="'.$packing->origanal_pallet.'" onblur="cal_product_invoice('.$packing->performa_packing_id.',2)"  onkeyup="cal_product_invoice('.$packing->performa_packing_id.',2)" />
										<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->performa_packing_id.'" value="0"   />
									
										<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->performa_packing_id.'" value="0"  />
									</td>';
							}
							else if($packing->orginal_no_of_big_pallet>0 || $packing->orginal_no_of_small_pallet>0)
							{
								$str .= '<td class="text-center">
											<input type="hidden" name="no_of_pallet[]" id="no_of_pallet'.$packing->performa_packing_id.'" value="0" />
											
											<input class="form-control" type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->performa_packing_id.'" value="'.$packing->orginal_no_of_big_pallet.'" onblur="cal_product_invoice('.$packing->performa_packing_id.',2)"  onkeyup="cal_product_invoice('.$packing->performa_packing_id.',2)"  />
											<br>
											<input class="form-control" type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->performa_packing_id.'" value="'.$packing->orginal_no_of_small_pallet.'" onblur="cal_product_invoice('.$packing->performa_packing_id.',2)"  onkeyup="cal_product_invoice('.$packing->performa_packing_id.',2)" />
										</td>';
							}
							else 
							 {
								$str .= '<td class="text-center">
									
											<input type="hidden" name="no_of_pallet[]" id="no_of_pallet'.$packing->performa_packing_id.'" value="0" />
											
											<input type="hidden" name="no_of_big_pallet[]" id="no_of_big_pallet'.$packing->performa_packing_id.'" value="0"   />
											 
											<input type="hidden" name="no_of_small_pallet[]" id="no_of_small_pallet'.$packing->performa_packing_id.'" value="0" />
										</td>'; 
								 
							 }
						}
						$no_of_boxes = $packing->origanal_boxes;
					 	$no_of_sqm 	= ($packing->product_id == 0)?$packing->no_of_sqm:($no_of_boxes * $packing->sqm_per_box);
						 
						if($no_of_boxes > 0)
						{	
						$str .= '<td class="text-center">
									<input type="text" class="form-control" name="no_of_boxes[]" id="no_of_boxes'.$packing->performa_packing_id.'" value="'.$packing->origanal_boxes.'" onblur="cal_box_invoice('.$packing->performa_packing_id.',1)"  onkeyup="cal_box_invoice('.$packing->performa_packing_id.',1)" />
								</td>';
						}
						else
						{
							$str .= '<td class="text-center">
									<input type="hidden" name="no_of_boxes[]" id="no_of_boxes'.$packing->performa_packing_id.'" value="0"  />
								</td>
								';
						}							
						 
						$str .= '<td class="text-center">
									
									<span id="sqmhtml'.$packing->performa_packing_id.'">'.$no_of_sqm.'</span>
								
									<input type="hidden" name="no_of_sqm[]" id="no_of_sqm'.$packing->performa_packing_id.'" value="'.$no_of_sqm.'" />
								
								 </td>
								 <td class="text-center">-</td>
								 <td class="text-center">-</td>
								 ';
						}
						$str .= '<td class="text-center">
									<input class="form-control" type="text" name="batch_no[]" id="batch_no'.$packing->production_trn_id.'" value="'.$packing->batch_no.'"  />
								</td>
								 <td class="text-center">
									<input class="form-control" type="text" name="shade_no[]" id="shade_no'.$packing->production_trn_id.'" value="'.$packing->shade_no.'"  />
								</td>
								 <input type="hidden" name="pallet_status[]" id="pallet_status'.$packing->performa_packing_id.'" value="'.$packing->pallet_status.'" />
								 <input type="hidden" name="sqm_per_box[]" id="sqm_per_box'.$packing->performa_packing_id.'" value="'.$packing->sqm_per_box.'" />
								 <input type="hidden" name="weight_per_box[]" id="weight_per_box'.$packing->performa_packing_id.'" value="'.$packing->weight_per_box.'" />
							
								<input type="hidden" name="pallet_weight[]" id="pallet_weight'.$packing->performa_packing_id.'" value="'.$packing->pallet_weight.'" />
								
								<input type="hidden" name="big_pallet_weight[]" id="big_pallet_weight'.$packing->performa_packing_id.'" value="'.$packing->big_pallet_weight.'" />
								
								<input type="hidden" name="small_pallet_weight[]" id="small_pallet_weight'.$packing->performa_packing_id.'" value="'.$packing->small_pallet_weight.'" />
							 
								 <input type="hidden" name="boxes_per_pallet[]" id="boxes_per_pallet'.$packing->performa_packing_id.'" value="'.$packing->boxes_per_pallet.'" />
								 <input type="hidden" name="box_per_big_pallet[]" id="box_per_big_pallet'.$packing->performa_packing_id.'" value="'.$packing->box_per_big_pallet.'" />
								 <input type="hidden" name="box_per_small_pallet[]" id="box_per_small_pallet'.$packing->performa_packing_id.'" value="'.$packing->box_per_small_pallet.'" />
								 <input type="hidden" name="performa_packing_id[]" id="performa_packing_id'.$packing->performa_packing_id.'" value="'.$packing->performa_packing_id.'" />
								 <input type="hidden" name="performa_trn_id[]" id="performa_trn_id'.$packing->performa_packing_id.'" value="'.$packing->performa_trn_id.'" />
								 <input type="hidden" name="product_id[]" id="product_id'.$packing->performa_packing_id.'" value="'.$packing->product_id.'" />
								 <input type="hidden" name="pi_loading_plan_id[]" id="pi_loading_plan_id'.$packing->performa_packing_id.'" value="'.$packing->pi_loading_plan_id.'" />
								 <input type="hidden" name="production_trn_id[]" id="production_trn_id'.$packing->performa_packing_id.'" value="'.$packing->production_trn_id.'" />
								 <input type="hidden" name="production_mst_id[]" id="production_mst_id'.$packing->performa_packing_id.'" value="'.$packing->production_mst_id.'" />
								 
								 <input type="hidden" name="containersize[]" id="containersize'.$packing->performa_packing_id.'" value="'.$packing->container_size.'" /> 
								    
								<input type="hidden" name="container[]" id="container'.$packing->performa_packing_id.'" value="'.$packing->container.'" />
							 
								<input type="hidden" name="supplier_id[]" id="supplier_id'.$packing->performa_packing_id.'" value="'.$packing->supplier_id.'" />
							
								<input type="hidden" name="supplier_id[]" id="supplier_id'.$packing->performa_packing_id.'" value="'.$packing->supplier_id.'" />
								 
								 
						</tr>';	
						if($n == 1)
						{
							$supplier_id  	    = $packing->supplier_id;
							$container_no 	    = $packing->container_no;
							$container 		    = $packing->container;
							$seal_no 	  		= $packing->seal_no;
							$rfidseal_no  		= $packing->rfidseal_no;
							$booking_no   		= $packing->booking_no;
							$lr_no 		  		= $packing->lr_no;
							$truck_no	  		= $packing->truck_no;
							$mobile_no	  		= $packing->mobile_no;
							$remark 	  		= $packing->remark;
							$container_size 	  = $packing->container_size;
							 
							$row_array['supplier_id'] 		= $supplier_id;
							$row_array['container_no'] 		= $container_no;
							$row_array['seal_no'] 			= $seal_no;
							$row_array['rfidseal_no'] 		= $rfidseal_no;
							$row_array['booking_no'] 		= $booking_no;
							$row_array['lr_no'] 			= $lr_no;
							$row_array['truck_no'] 			= $truck_no;
							$row_array['mobile_no'] 		= $mobile_no;
							$row_array['remark'] 			= $remark;
							$row_array['container_size'] 	= $container_size;
							$row_array['container'] 		= $container;
							$row_array['con_entry'] 		= $con_entry;
							 
						}
						$n++;
			}
	 
		if(in_array(2,$make_once_pallet))
		{
		 $str .= '<tr>
				<td colspan="2">
					 <span class="col-md-6"> No Of Pallet :</span>
					 <div class="col-md-6">
					 <input type="text" name="make_pallet_no" id="make_pallet_no" placeholder="No Of Pallet" value="1" class="form-control " />
					 </div>
					 <br>
					 <br>
					<!-- <button type="button" onclick="make_pallet('.$con_entry.','.$performa_invoice_id.','.$supplier_id.','.$pi_loading_plan_id.')" class="btn btn-primary" >Make Pallet</button>-->
				</td>
		 </tr>';
		}
		 
		$str .= '
			<input type="hidden" name="container_no" id="container_no" value="'.$container_no.'" />
		 	<input type="hidden" name="seal_no" id="seal_no" value="'.$seal_no.'" />
			<input type="hidden" name="rfidseal_no" id="rfidseal_no" value="'.$rfidseal_no.'" />
			<input type="hidden" name="booking_no" id="booking_no" value="'.$booking_no.'" />
			<input type="hidden" name="lr_no" id="lr_no" value="'.$lr_no.'" />
			<input type="hidden" name="truck_no" id="truck_no" value="'.$truck_no.'" />
			<input type="hidden" name="mobile_no" id="mobile_no" value="'.$mobile_no.'" />
			<input type="hidden" name="remark" id="remark" value="'.$remark.'" />
			
		</table>';
				
				$row_array['html'] = $str;
		echo json_encode($row_array);
	}
	public function make_pallet()
	{
		$pi_loading_plan_id		= $this->input->post('pi_loading_plan_id');
		$piloading_plan_id		= $this->input->post('piloading_plan_id');
		$make_pallet_no			= $this->input->post('make_pallet_no');
		$data = array(
			"pallet_ids" 	 	=> implode(",",$pi_loading_plan_id),
			"make_pallet_no" 	=>	$make_pallet_no,
			"origanal_pallet" 	=>	0
		);
		 
		$deleteid=$this->pinv->update_cointainer($data,$piloading_plan_id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function delete_pallet()
	{
		$pi_loading_plan_id		= $this->input->post('pi_loading_plan_id');
	 	 
		
		$deleteid=$this->pinv->delete_cointainer($pi_loading_plan_id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
}
