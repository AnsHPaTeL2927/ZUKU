<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Product_list extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');	
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_product_list','product');
			$this->load->model('menu_model','menu');	
		
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data1 = $this->product->select_config();
			$this->load->model('admin_company_detail');	
			$menu_data	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
				'config'		 => $data1,
				'company_detail' => $this->admin_company_detail->s_select(),
				'allproduct' 	 => $this->product->seriesdata(),
				'menu_data'		 => $menu_data
			);
			$this->load->view('admin/product_list',$v);
		}
		else
		{
			redirect(base_url().'');
		}	
	}
	public function editprice()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data = $this->calc->select_hsnc();
			$data1 = $this->calc->select_config();
			$this->load->model('admin_company_detail');	
			$request_id = $this->uri->segment('3');
			$this->load->model('settingmodel');
			$menu_data	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array('config'=>$data1,'result'=>$data,'company_detail'=>$this->admin_company_detail->s_select(),'edit_record'=>$this->calc->b_form_edit($request_id),"mode"=>"Edit","maindetail"=>$this->settingmodel->afetrlogin($this->session->id),'menu_data'=>$menu_data);
			$this->load->view('admin/editprice',$v);
		}
		else
		{
			redirect(base_url().'');
		}	
	}
	
	public function displaydataprice()
	{
		$id=$this->input->post('id');
		 
		$resultset = $this->product->select_hsnc_product_size($id);
		 
		 $contentdata = "";
		  if(!empty($resultset))
		  {
				$result=$resultset[0];
					 
				 $active1 = ($result->boxes_per_pallet>0)?"active":"";
				 $active2 = ($result->total_boxes>0)?"active":"";
				 $active3 = ($result->box_per_big_plt>0)?"active":"";
			    	$contentdata .= '
<table class="table table-bordered table-responsive">					
						<tr>
							<th>Pcs Per Box</th>
							<td id="first">
								<input class="priceinput" readonly type="text" value="'.$result->pcs_per_box.'" name="pcsperbox" id="pcsperbox" width="100">
							</td>
						</tr>
						<tr>
							<th>Approx Weight Per Box</th>
							<td id="second"> 
								<input class="priceinput" readonly type="text" value="'.$result->weight_per_box.'" name="apwigtperbox" id="apwigtperbox">
							</td>
						</tr>
						</table>
					 <div role="tabpanel">
										<ul class="nav nav-tabs" role="tablist">
											<li role="presentation" class="'.$active1.'" id="tab1" >
												<a href="#table-1" aria-controls="table-1" role="tab" data-toggle="tab">
													<label class="checkbox-inline">
														 With Pallet 
													</label>
												</a>
											</li>
											<li role="presentation" id="tab2" class="'.$active2.'" >
												<a href="#table-2" aria-controls="table-2" role="tab" data-toggle="tab">
													<label class="checkbox-inline">
														 Without Pallet
													</label>
												</a>
											</li>
											<li role="presentation"  id="tab1"  class="'.$active3.'">
												<a href="#table-3" aria-controls="table-3" role="tab" data-toggle="tab">
													<label class="checkbox-inline">
														  Multi Pallet
													</label>
												</a>
											</li>
										</ul>
										<div class="tab-content">
											<div role="tabpanel" class="tab-pane '.$active1.'" id="table-1">
												<table class="table table-bordered table-responsive">	
													<tr>
														<td>Boxes Per Pallet</td>
														<td>'.$result->boxes_per_pallet.' </td>
													</tr>
													<tr>
														<td>Total Pallet In Container</td>
														<td>'.$result->total_pallent_container.' </td>
													</tr>
													<tr>
														<td>Empty Pallet Weight</td>
														<td>'.$result->pallet_weight.' KG </td>
													</tr>
													<tr>
														<td>Boxes Per Container</td>
														<td>'.$result->box_per_container.' </td>
													</tr>
													<tr>
														<td>Gross Weight Per Container</td>
														<td>'.$result->pallet_gross_weight_per_container.' KG</td>
													</tr>
													<tr>
														<td>Net Weight Per Container </td>
														<td>'.$result->pallet_net_weight_per_container.' KG</td>
													</tr>
													<tr>
														<td>SQM Per Container </td>
														<td>'.$result->sqm_per_container.'</td>
													</tr>													
												</table>
										 </div>
									  
										<div role="tabpanel" class="tab-pane '.$active2.'" id="table-2">
											<table class="table table-bordered table-responsive">	
													<tr>
														<td>Total Boxes</td>
														<td>'.$result->total_boxes.' </td>
													</tr>
													<tr>
														<td>Gross Weight Per Container</td>
														<td>'.$result->withoutgross_weight_per_container.' KG</td>
													</tr>
													<tr>
														<td>Net Weight Per Container </td>
														<td>'.$result->withoutnet_weight_per_container.' KG</td>
													</tr>
													<tr>
														<td>SQM Per Container</td>
														<td>'.$result->withoutpallet_sqm_per_container.' </td>
													</tr>
 												
											</table>
										</div>	 
										
											<div role="tabpanel" class="tab-pane '.$active3.'"  id="table-3">
												<table class="table table-bordered table-responsive">	
													<tr>
														<td>Boxes Per Big Pallet</td>
														<td>'.$result->box_per_big_plt.' </td>
													</tr>
													<tr>
														<td>Boxes Per Small Pallet</td>
														<td>'.$result->box_per_small_plt_new.' </td>
													</tr>
													<tr>
														<td>Total Big Pallet In Container</td>
														<td>'.$result->no_big_plt_container_new.' </td>
													</tr>
													<tr>
														<td>Total Small Pallet In Container</td>
														<td>'.$result->no_small_plt_container_new.' </td>
													</tr>
													<tr>
														<td>Big Pallet Weight</td>
														<td>'.$result->big_plat_weight.' KG</td>
													</tr>
													<tr>
														<td>Small Pallet Weight</td>
														<td>'.$result->small_plat_weight.' KG</td>
													</tr>
													<tr>
														<td>Boxes Per Container</td>
														<td>'.$result->multi_box_per_container.' </td>
													</tr>
													<tr>
														<td>Gross Weight Per Container</td>
														<td>'.$result->multi_gross_weight_container.' </td>
													</tr>
													<tr>
														<td>Net Weight Per Container </td>
														<td>'.$result->multi_net_weight_container.' </td>
													</tr>
													<tr>
														<td>Sqm Per Container</td>
														<td>'.$result->multi_sqm_per_container.' </td>
													</tr>
												</table>
										 </div>
									 </div>
								</div>';
					 
				}
		  echo $contentdata;
	}
	
	public function manage()
	{
		 
		if($this->input->post('mode') != "packing")
		{
			$data = array(
			 'series_id'		 => $this->input->post('series_id'),
			 'size_type_cm' 	 => $this->input->post('size_type_cm'),
			 'size_width_mm' 	 => $this->input->post('size_width_mm'),
			 'size_type_mm' 	 => $this->input->post('size_type_mm'),
			 'size_width_cm' 	 => $this->input->post('size_width_cm'),
			 'size_height_mm' 	 => $this->input->post('size_height_mm'),
			 'size_height_cm' 	 => $this->input->post('size_height_cm'),
			 'thickness' 	 	 => $this->input->post('thickness'),
			 'defualt_rate' 	 => 0,
			 'status' 			 => 0,
			 'cdate' 			 => date('Y-m-d H:i:s')
			);
		}	
		$id=$this->input->post('product_id');
			
			
			$data_size = array(
			    'product_packing_name' 	  			=> $this->input->post('product_packing_name'),
				'pcs_per_box' 			 			=> $this->input->post('pcs_per_box'),
				'feet_per_box' 		 				=> $this->input->post('feet_per_box'),
				'sqm_per_box' 			 			=> $this->input->post('sqm_per_box'),
				'weight_per_box' 			 	 	=> $this->input->post('weight_per_box'),
				'boxes_per_pallet' 		 			=> $this->input->post('boxes_per_pallet'),
				'total_pallent_container'			=> $this->input->post('total_pallent_container'),
				'pallet_weight'			 			=> $this->input->post('pallet_weight'),
				'box_per_container' 	 			=> $this->input->post('box_per_container'),
				'pallet_gross_weight_per_container' => $this->input->post('pallet_gross_weight_per_container'),
				'pallet_net_weight_per_container'   => $this->input->post('pallet_net_weight_per_container'),
				'sqm_per_container'   				=> $this->input->post('sqm_per_container'),
				'box_per_big_plt' 		  			=> $this->input->post('box_per_big_plt'),
				'box_per_small_plt_new'   			=> $this->input->post('box_per_small_plt_new'),
				'no_big_plt_container_new'			=> $this->input->post('no_big_plt_container_new'),
				'no_small_plt_container_new' 		=> $this->input->post('no_small_plt_container_new'),
				'big_plat_weight'		 			=> $this->input->post('big_plat_weight'),
				'small_plat_weight' 	 			=> $this->input->post('small_plat_weight'),
				'total_boxes' 						=> $this->input->post('total_boxes'),
				'withoutgross_weight_per_container' => $this->input->post('withoutgross_weight_per_container'),
				'withoutnet_weight_per_container'   => $this->input->post('withoutnet_weight_per_container'),
				'withoutpallet_sqm_per_container'   => $this->input->post('withoutpallet_sqm_per_container'),
				'multi_gross_weight_container'		=> $this->input->post('multi_gross_weight_container'),
				'multi_net_weight_container'		=> $this->input->post('multi_net_weight_container'),
				'multi_sqm_per_container'			=> $this->input->post('multi_sqm_per_container'),
				'multi_box_per_container'			=> $this->input->post('multi_box_per_container'),
				'cdate'		 						=> date('d-m-Y H:i:s'),
				'status' 							=> 0
			);
			
			if(!empty($id) && strtolower($this->input->post('mode')) == "edit")
			{
				$updateid = $this->product->update_product($data,$id);
				$data_size['product_id'] = $id;
				$product_size_id=$this->input->post('product_size_id');
		 
				$size_id = $this->product->update_packing_detail($data_size,$product_size_id);
					
				if($updateid)
				{
					$row['res'] = 2;
					
				}
				else{
					$row['res'] = 0;
				}
			}
			else
			{
				 
				if($this->input->post('mode') == "packing")
				{
					$product_size_id=$this->input->post('product_size_id');
					if(!empty($product_size_id))
					{
						$size_id = $this->product->update_packing_detail($data_size,$product_size_id);
						if($size_id)
						{
							$row['res'] = 4;
							
						}
						else{
							$row['res'] = 0;
						}
					}
					else
					{
						 
					 	$data_size['product_id'] = $id;
					 	$size_id = $this->product->insert_packing_detail($data_size);
						if($size_id)
						{
							$row['res'] = 1;
						}
						else
						{
							$row['res'] = 0;
						}
					}
					
				}
				else
				{
					$check_data = $this->product->checkdata($data);
					if(!empty($check_data))
					{
						$row['res'] = 3;
					}
					else
					{ 
						$insertid = $this->product->insert_product($data);
						$data_size['product_id'] = $insertid;
						
					 	$insertid = $this->product->insert_packing_detail($data_size);
						
						if($insertid)
						{
							$row['res'] = 1;
						}
						else
						{
							$row['res'] = 0;
						}
					}
				}
			}
		 
		 
		echo json_encode($row);
	}
	public function fetch_record()
	{
		 
		$where = '';
		if(!empty($this->input->get('series_id')))
		{
			$where = ' and series.series_id ='.$this->input->get('series_id'); 
		}
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.product_id', 'series.series_name','series.hsnc_code','size_type_cm','size_type_mm','thickness','defualt_rate','mst.status','mst.cdate','(SELECT count(*) FROM `tbl_packing_model` where product_id = mst.product_id) as total_cnt','hsnc.orderby');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_product as mst";
		 $isJOIN = array(
						 'left join tbl_series as series on series.series_id=mst.series_id',
						 'left join product_code_detail as hsnc on hsnc.hsnc_code=series.hsnc_code'
						 );
		 $hOrder = "hsnc.orderby asc, series.series_name asc, mst.product_id desc";
		$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no.' <a class="tooltips plusbtnhtml" data-toggle="tooltip" data-title="Show Packing"    href="javascript:;" value="'.$row->product_id.'"><i class="fa fa-plus"></i></a>';
					$thickness = (!empty($row->thickness))? $row->thickness.' MM':"";
					$row_data[] = $row->size_type_cm;
					$row_data[] = $row->size_type_mm;
					$row_data[] = $row->series_name;
					$row_data[] = $row->hsnc_code;
					$row_data[] = $thickness;
					$delete_btn = '';
					if($this->session->usertype_id == "1")
					{
						$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->product_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
					}			 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'add_product/edit/'.$row->product_id.'"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
									
								  <li>
									<a class="tooltips" data-toggle="tooltip" data-title="Add Packing Detail" href="'.base_url().'product_packing_list/index/'.$row->product_id.'"><i class="fa fa-plus"></i> Add Packing Detail</a>
								 </li>
								  <li>
									<a class="tooltips" data-toggle="tooltip" data-title="View Packing Detail" href="javascript:;" onclick="view_packing_detail('.$row->product_id.',&quot;'.$row->series_name.' - '.$row->size_type_cm.' - '.$row->thickness.' MM&quot;)"><i class="fa fa-eye"></i> View Packing Detail</a>
								 </li>
								  
								 ';
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											'.$delete_btn .'
											 
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
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->product->delete_product($id);
			
		if($deleterecord)
		{
			$row['res'] = '1';
		}
		else{
			$row['res'] = '0';
		}
		echo json_encode($row);
	}



}


?>