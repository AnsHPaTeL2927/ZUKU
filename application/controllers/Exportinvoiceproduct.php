<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Exportinvoiceproduct extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_exportinvoice_product','export');
		$this->load->model('Admin_customer_detail');
		
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index($id)
	{
	 	if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data = $this->export->get_invoice_data($id);
			  
			if($data->mutiple_status == 2) 
			{
				$performa_invoice_id_array = explode("-",$data->performa_invoice_id);
				$datap = $this->export->getinvoice_productdata($id,0,0,$data->mutiple_status,$data->supplier_id,$data->direct_invoice,$data->container_status);
				if($datap == 0)
				{
						$con_entry = 0;
					    $supplier_array 	= explode("-",$data->supplier_id);	
						$productarray = $this->export->getinvoice_mutiple_record($id,$performa_invoice_id_array,$supplier_array,$con_entry,$data->container_status);
						$con_entry = $productarray;
			 	}
			 	$datap = $this->export->getinvoice_productdata($id,$data->performa_invoice_id,0,1,$data->supplier_id,$data->direct_invoice,$data->container_status);
			}
			else
			{
				 $performa_invoice_id_array = explode("-",$data->performa_invoice_id);
				$datap = $this->export->getinvoice_productdata($id,$performa_invoice_id_array,$data->container_details,$data->mutiple_status,$data->supplier_id,$data->direct_invoice,$data->container_status);
			}
			 
			//$container_data = $this->export->get_container_data($id,$datap[0]->export_invoice_id,$data->performa_invoice_id);
			$supplier_data = $this->export->get_supplier();
			$this->load->model('admin_company_detail');
			$userdata = $this->export->ciadmin_login();	
			$menu_data	 	= $this->menu->usermain_menu($this->session->usertype_id);	
		 	$v = array(
				'invoicedata'		=> $data,
				'product_data'		=> $datap,
				'company_detail'	=> $this->admin_company_detail->s_select(),
				'allproduct'		=> $this->export->allproductsize(),
				'termsdata'			=> $this->export->gettermsdata(),
				//'container_data'	=> $container_data,
				'userdata'			=> $userdata,
				'menu_data'			=> $menu_data,
				'mode'				=> "Add",
				'supplier_data'		=> $supplier_data
			);
				$this->load->view('admin/exportinvoiceproduct',$v);
			}
			else
			{
				redirect(base_url().'');
			}
	}
	public function direct($id)
	{
	 	if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data 			= $this->export->get_invoice_data($id);
			$datap 			= $this->export->loading_data($id);
			$container_data = $this->export->get_container_data($id,$datap[0]->export_invoice_id,$data->performa_invoice_id);
			$supplier_data 	= $this->export->get_supplier();
			$this->load->model('admin_company_detail');
			$userdata 		= $this->export->ciadmin_login();	
			$menu_data	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			 
		 	$v = array(
				'invoicedata'		=> $data,
				'product_data'		=> $datap,
				'company_detail'	=> $this->admin_company_detail->s_select(),
				'allproduct'		=> $this->export->allproductsize(),
				'termsdata'			=> $this->export->gettermsdata(),
				'container_data'	=> $container_data,
				'userdata'			=> $userdata,
				'menu_data'			=> $menu_data,
				'mode'				=> "Add",
				'supplier_data'		=> $supplier_data
			);
				$this->load->view('admin/exportinvoicedirectproduct',$v);
			}
			else
			{
				redirect(base_url().'');
			}
	}
	public function manage()
	{
		 
		$description_goodsarray = $this->export->hsncproductsizedetail($this->input->post('product_details'),2);
		$thickness = !empty($description_goodsarray[0]->thickness)?' - '.$description_goodsarray[0]->thickness.' MM':"";
		$description = $description_goodsarray[0]->size_type_mm.' ('.$description_goodsarray[0]->series_name.')';
			  
		$data = array(
			'export_invoice_id'		=> $this->input->post('exportinvoice_id'),
			'product_id' 			=> $this->input->post('product_details'),
			'product_size_id' 	 	=> $this->input->post('product_size_id'),
			'product_container' 	=> (!empty($this->input->post('container_check'))?$this->input->post('total_container'):0),
			'description_goods' 	=> $description,
		 	'pallet_status' 		=> $this->input->post('pallet_status'),
			'weight_per_box' 		=> $this->input->post('weight_per_box'),
			'pallet_weight'	 		=> $this->input->post('pallet_weight'),
			'big_pallet_weight'	 	=> $this->input->post('big_pallet_weight'),
			'small_pallet_weight'	=> $this->input->post('small_pallet_weight'),
			'boxes_per_pallet'  	=> $this->input->post('boxes_per_pallet'),
			'box_per_big_pallet'  	=> $this->input->post('box_per_big_pallet'),
			'box_per_small_pallet'  => $this->input->post('box_per_small_pallet'),
			'sqm_per_box' 			=> $this->input->post('sqm_per_box'),
			'pcs_per_box' 			=> $this->input->post('pcs_per_box'),
			'total_no_of_pallet' 	=> $this->input->post('total_no_of_pallet'),
			'total_no_of_boxes' 	=> $this->input->post('total_no_of_boxes'),
			'total_no_of_sqm' 		=> $this->input->post('total_no_of_sqm'),
			'total_product_amt' 	=> $this->input->post('total_product_amt'),
			'total_pallet_weight' 	=> $this->input->post('total_pallet_weight'),
			'total_net_weight' 		=> $this->input->post('total_net_weight'),
			'total_gross_weight' 	=> $this->input->post('total_gross_weight'),
			'container_half' 		=> (!empty($this->input->post('container_check'))?1:0),
			'cdate' 				=> date('Y-m-d H:i:s')
			);
	 
		 $id = $this->input->post('exportproduct_trn_id');
		 $id1 = $this->input->post('exportinvoice_id');
		if(empty($id))
		{
			$insert_id = $this->export->insert_productrecord($data);
			$no=0;
			
				foreach($this->input->post('design_id') as $design)
				{
					$packing_data = array(
						"exportproduct_trn_id"	 => $insert_id,
						"export_invoice_id"		 => $this->input->post('exportinvoice_id'),
						"design_id" 			 => $design,
						"finish_id" 			 => $this->input->post('finish_id')[$no],
						"client_name" 			 => $this->input->post('client_name')[$no],
						"barcode_no" 			 => $this->input->post('barcode_no')[$no],
						"product_rate" 			 => $this->input->post('product_rate')[$no],
						"no_of_pallet" 			 => $this->input->post('no_of_pallet')[$no],
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet')[$no],
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet')[$no],
						"no_of_boxes" 			 => $this->input->post('no_of_boxes')[$no],
						"no_of_sqm" 			 => $this->input->post('no_of_sqm')[$no],
						"per" 					 => 'SQM',
						"product_amt" 			 => $this->input->post('product_amt')[$no],
						"packing_net_weight"	 => $this->input->post('packing_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')[$no] 
						);
						$insertrecord = $this->export->insert_packing_data($packing_data);
					$no++;
				}
		 	if($insert_id)
			{	
				$row['res'] = "1";
				$row['exportproduct_trn_id'] = $rdata;
				$row['model_serice'] 		 = $this->input->post('model_serice');
			}
		}
		else
		{
			$deleterecord1 = $this->export->delete_loading_trn($id1);	
			$update_id = $this->export->update_productrecord($data,$id);
			$deletedataid = $this->export->delete_packing_data($id);
			//$deleterecord = $this->export->delete_product($id);	
			 		
				$no=0;
				foreach($this->input->post('design_id') as $design)
				{
					$packing_data = array(
						"exportproduct_trn_id"	 => $id,
						"export_invoice_id"		 => $this->input->post('exportinvoice_id'),
						"design_id" 			 => $design,
						"finish_id" 			 => $this->input->post('finish_id')[$no],
						"client_name" 			 => $this->input->post('client_name')[$no],
						"barcode_no" 			 => $this->input->post('barcode_no')[$no],
						"product_rate" 			 => $this->input->post('product_rate')[$no],
						"no_of_pallet" 			 => $this->input->post('no_of_pallet')[$no],
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet')[$no],
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet')[$no],
						"no_of_boxes" 			 => $this->input->post('no_of_boxes')[$no],
						"no_of_sqm" 			 => $this->input->post('no_of_sqm')[$no],
						"per" 					 => 'SQM',
						"product_amt" 			 => $this->input->post('product_amt')[$no],
						"packing_net_weight"	 => $this->input->post('packing_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')[$no] 
						);
						$insertrecord = $this->export->insert_packing_data($packing_data);
					$no++;
				}
				 
					
				if($update_id)
				{	
					$row['res'] = "2";
				  
					$export_data['step'] = 1;
					$export_data_update_id = $this->export->updateexport($export_data,$id1);
					
					$row['exportproduct_trn_id'] = $id;
					$row['model_serice'] = $this->input->post('model_serice');
				}
		}
		echo json_encode($row);

	}
	public function manage_price()
	{
		$no=0;
		foreach($this->input->post('export_packing_id') as $row)
		{
		 	$data = array(
					'product_rate' 	=>	$this->input->post('product_rate')[$no],
					'product_amt'	=>	$this->input->post('product_amt')[$no],
		 	); 
			$id = $row;
			 
				$updateid = $this->export->update_cointainer($data,$id);
			$no++;
		}
		 $row = array();
		 $row['res'] = 1;
			
		echo json_encode($row);
	}
	public function editloading()
	{
		$con_entry			= $this->input->post('con_entry');
		$export_invoice_id	= $this->input->post('export_invoice_id');
	 	$get_data			= $this->export->edit_loadingtrn($con_entry,$export_invoice_id);
		$str = '<table class="table table-bordered">
					<tr>
						<td class="text-center" width="10%">Product Name</td>
						<td class="text-center" width="10%">Design Name</td>
						<td class="text-center" width="10%">Finish Name</td>
						<td class="text-center" width="10%">Batch No</td>
						<td class="text-center" width="10%">Shade No</td>
						<td class="text-center" width="8%">Pallet</td>
						<td class="text-center" width="8%">Boxes</td>
						<td class="text-center" width="8%">SQM</td>
						<td class="text-center" width="8%">Rate</td>
						<td class="text-center" width="10%">Amount</td>
						 
				 	</tr>';
					$no=1;
		foreach($get_data as $packing)
		{
				$row_array['company_name'] 	   = $packing->company_name;
				$row_array['container_no'] 	   = $packing->container_no;
				$row_array['seal_no'] 	   	   = $packing->seal_no;
				$row_array['rfidseal_no'] 	   = $packing->rfidseal_no;
				$row_array['lr_no'] 	  	   = $packing->lr_no;
				$row_array['truck_no'] 	  	   = $packing->truck_no;
				$row_array['booking_no'] 	   = $packing->booking_no;
				$row_array['remark'] 	   	   = $packing->remark;
				$row_array['mobile_no'] 	   = $packing->mobile_no;
			$str .= '<tr>
						<td class="text-center">'.$packing->size_type_mm.'('.$packing->series_name.')</td> 
						<td class="text-center">'.$packing->model_name.'</td>
						<td class="text-center">'.$packing->finish_name.'</td>
						<td class="text-center">'.$packing->batch_no.'</td>
						<td class="text-center">'.$packing->shade_no.'</td>';
						$no_of_boxes = 0;
					 	if(!empty($packing->pallet_ids) || $packing->make_pallet_no == 1)
						{
							if(!empty($packing->pallet_ids))
							{
								$pallet_ids = explode(",",$packing->pallet_ids);
							 
								$str .= '<td class="text-center" rowspan="'.count($pallet_ids).'">
											'.$packing->make_pallet_no.'     
										 </td>';
							$total_pallet += $packing->make_pallet_no;
							}
						 	$total_box  +=$packing->origanal_boxes;
							$total_sqm 	+= ($packing->sqm_per_box * $packing->origanal_boxes);
						}
						else if(!empty($packing->production_mst_id) || empty($packing->pallet_row))
						{
								if($packing->origanal_pallet>0)
								{
									$boxes_per_pallet =  $packing->boxes_per_pallet;
									$no_of_boxes = $packing->origanal_pallet * $packing->boxes_per_pallet;
								}
								else if($packing->orginal_no_of_big_pallet > 0 || $packing->orginal_no_of_small_pallet)
								{
									$big= ( $packing->box_per_big_pallet > 0)? $packing->box_per_big_pallet:'';
									$small= ( $packing->box_per_small_pallet > 0)? $packing->box_per_small_pallet:'';
									$boxes_per_pallet =  $big.'<br>'.$small;
							 		$no_of_boxes = ($packing->orginal_no_of_big_pallet * $packing->box_per_big_pallet) + ($packing->orginal_no_of_small_pallet * $packing->box_per_small_pallet);
							 	}
								else
								{
									$boxes_per_pallet =  '-';
									$no_of_boxes = $packing->origanal_boxes;
								}
					 	$str .= '<td style="text-align:center">';
					 	if($packing->origanal_pallet>0)
						{
							$no_of_pallet = $packing->origanal_pallet;
						 	$str .=  $no_of_pallet;
							$total_pallet += $no_of_pallet;
					 	}
						else if($packing->orginal_no_of_big_pallet>0 || $packing->orginal_no_of_small_pallet>0)
						{
							$str .=   $packing->orginal_no_of_big_pallet.'<br>';
							$str .=  $packing->orginal_no_of_small_pallet;
							$total_pallet += $packing->orginal_no_of_big_pallet;
							$total_pallet += $packing->orginal_no_of_small_pallet;
						}
					 	$total_box  += $no_of_boxes;
						$total_sqm 	+= $no_of_boxes * $product_data[$i]->sqm_per_box;
						}
					 	$str .= '<td class="text-center">
									'.$packing->origanal_boxes.'     
								 </td>
								 <td style="text-align:center">'.($packing->sqm_per_box * $packing->origanal_boxes).'</td>
								 <td>
									<input type="text" name="product_rate[]" id="product_rate'.$packing->export_loading_trn_id.'" onblur="cal_rate('.$packing->export_loading_trn_id.','.($packing->sqm_per_box * $packing->origanal_boxes).')" onkeyup="cal_rate('.$packing->export_loading_trn_id.','.($packing->sqm_per_box * $packing->origanal_boxes).')" class="form-control" value="'.$packing->product_rate.'"/>
								 </td>
								 <td>
									<input type="text" name="product_amt[]" id="product_amt'.$packing->export_loading_trn_id.'" class="form-control" value="'.$packing->product_amt.'" readonly/>
								 </td>
								  
								  <input type="hidden" name="export_loading_trn_id[]" id="export_loading_trn_id'.$packing->export_loading_trn_id.'" value="'.$packing->export_loading_trn_id.'" />
								  <input type="hidden" name="export_packing_id[]" id="export_packing_id'.$packing->export_packing_id.'" value="'.$packing->export_packing_id.'" />
						</tr>';	
				$no++;
		}
		 $str .= '</table>';
				
				$row_array['html'] = $str;
		echo json_encode($row_array);
	}
	public function add_other_row()
	{
			$no  		=  ($this->input->post('row_count') + 1);
		$str ='<tr class="other_last_row'.$no.'">
					<td style="text-align:center">
						<textarea name="other_product_description[]" id="other_product_description'.$no.'" class="form-control" placeholder="Product Description"></textarea>
					</td>
					<td style="text-align:center">
							<input type="text" name="other_qty[]" id="other_qty'.$no.'" class="form-control"  placeholder="Qty" onblur="calc_other_amount('.$no.')" onchange="calc_other_amount('.$no.')" onkeyup="calc_other_amount('.$no.')" />
					</td>
					<td style="text-align:center">
							<select  name="other_unit_per[]" id="other_unit_per'.$no.'" class="form-control">
									<option value="SQM">SQM</option>
									<option value="BOX">BOX</option>
									<option value="SQF">SQF</option>
									<option value="PCS">PCS</option>
							</select>
							 
					</td>
					 
					<td style="text-align:center">
							<input type="text" placeholder="Rate" onblur="calc_other_amount('.$no.')" onchange="calc_other_amount('.$no.')"  onkeyup="calc_other_amount('.$no.')" name="other_rate[]" id="other_rate'.$no.'" class="form-control"/>
					</td>
				 	<td style="text-align:center">
						<input type="text" placeholder="Amount"  name="other_amt[]" id="other_amt'.$no.'" class="form-control" readonly />
					</td>
					<td style="text-align:center">
						<input type="text" name="other_gross_weight[]" placeholder="Gross Weight" id="other_gross_weight'.$no.'" class="form-control"/>
					</td>
					<td style="text-align:center">
						<input type="text" name="other_net_weight[]" placeholder="Net Weight" id="other_net_weight'.$no.'" class="form-control"/>
					</td>
					<td style="text-align:center">
						<input type="file" name="other_image[]"  id="other_image'.$no.'" class="form-control"  accept="image/*"/>
					 </td>
					<td class="text-center">
						<button type="button" onclick="remove_other_row('.$no.')" class="btn btn-danger">-</button>
				 	</td>
					</tr>';
	  
		echo $str;
	}
	public function othermanage()
	{
			$no=0;
			 
		 	foreach($this->input->post('other_product_description') as $product_row)
			{
			 	if(!empty($product_row))
				{
					$no_of_sqm = 0;
					$no_of_box = 0;
				 
					if($this->input->post('other_unit_per')[$no] == "SQM")
					{
						$no_of_sqm =  $this->input->post('other_qty')[$no];
					}
					else if($this->input->post('other_unit_per')[$no] == "BOX")
					{
						$no_of_box =  $this->input->post('other_qty')[$no];
					}
					else if($this->input->post('other_unit_per')[$no] == "SQF")
					{
						$no_of_box =  $this->input->post('other_qty')[$no];
					} 
					else if($this->input->post('other_unit_per')[$no] == "PCS")
					{
						$no_of_box =  $this->input->post('other_qty')[$no];
					} 
					$data = array(
						'export_invoice_id'			=> $this->input->post('otherexport_invoice_id'),
						'product_size_id' 	 	=> 0,
						'product_id' 			=> 0,
						'product_container' 	=> 0,
						'description_goods' 	=> $product_row,
						'pallet_status' 		=> 0,
						'weight_per_box' 		=> 0,
						'pallet_weight'	 		=> 0,
						'big_pallet_weight'	 	=> 0,
						'small_pallet_weight'	=> 0,
						'boxes_per_pallet'  	=> 0,
						'box_per_big_pallet'  	=> 0,
						'box_per_small_pallet'  => 0,
						'sqm_per_box' 			=> 0,
						'pcs_per_box' 			=> 0,
						'feet_per_box' 			=> 0,
						'total_no_of_pallet' 	=> 0,
						'total_no_of_boxes' 	=> $no_of_box,
						'total_no_of_sqm' 		=> $no_of_sqm,
						'total_product_amt' 	=> $this->input->post('other_amt')[$no],
						'total_pallet_weight' 	=> 0,
						'total_net_weight' 		=> $this->input->post('other_net_weight')[$no],
						'total_gross_weight' 	=> $this->input->post('other_gross_weight')[$no],
						'container_half' 		=> 1,
				 		'cdate' =>date('Y-m-d H:i:s')
					);
					 
					$otherexportproduct_trn_id =  $this->input->post('otherexportproduct_trn_id');
					$otherexport_packing_id 	  =  $this->input->post('otherexport_packing_id');
					
					if(!empty($otherexportproduct_trn_id))
					{
						$update_id 	= $this->export->update_productrecord($data,$otherexportproduct_trn_id);
						 
					}
					else
					{
						$insertid = $this->export->insert_productrecord($data);
						$otherexportproduct_trn_id = $insertid;
					}
					
					$packing_data = array(
						"exportproduct_trn_id"		 => $otherexportproduct_trn_id,
						"export_invoice_id"		 => $this->input->post('otherexport_invoice_id'),
						"design_id" 			 => 0,
						"finish_id" 			 => 0,
						"client_name" 			 => 0,
						"barcode_no" 			 => 0,
						"product_rate" 			 => $this->input->post('other_rate')[$no],
						"no_of_pallet" 			 => 0,
						"no_of_big_pallet" 		 => 0,
						"no_of_small_pallet" 	 => 0,
						"no_of_boxes" 			 => $no_of_box,
						"no_of_sqm" 			 => $no_of_sqm,
						"per" 					 => $this->input->post('other_unit_per')[$no],
						"product_amt" 			 => $this->input->post('other_amt')[$no],
						"packing_net_weight"	 => $this->input->post('other_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('other_gross_weight')[$no]
						);
						 
						if(!empty($_FILES['other_image']['name'][$no]))
						{
							$_FILES['filename']['name']	= $_FILES['other_image']['name'][$no];
							$_FILES['filename']['type']	= $_FILES['other_image']['type'][$no];
							$_FILES['filename']['tmp_name']= $_FILES['other_image']['tmp_name'][$no];
							$_FILES['filename']['error']	= $_FILES['other_image']['error'][$no];
							$_FILES['filename']['size'] 	= $_FILES['other_image']['size'][$no];    
						
							if($_FILES['filename']['name'] != "")	
							{
								$this->load->library('upload');
								$this->upload->initialize($this->set_upload_options('other_image',$_FILES['filename']['name'],"./upload/design/","gif|jpg|jpeg|png"));
								$this->upload->do_upload('filename');
								
								$upload_image = $this->upload->data();
								$packing_data['other_image']  = $upload_image['file_name'];
								
							}
							if(!empty($otherexport_packing_id))
							{
							 unlink(DESIGN_PATH.$this->input->post('other_image_name')[$no]);
							}
						}
						 
						if(!empty($otherexport_packing_id))
						{
							 
							$update_id 	= $this->export->update_productpackingrecord($packing_data,$otherexport_packing_id);
							
						}
						else
						{
							$insertrecord = $this->export->insert_packing_data($packing_data);
						}	 
						$no++;
				}
			}
			$row = array();
			if($insertrecord)
			{
				$row['res']	=	1;
			}
			else if($update_id)
			{
				$row['res']	=	2;
				
					$export_data['step'] = 1;
					$export_data_update_id = $this->export->updateexport($export_data,$id1);
					
			}
			else
			{
				$row['res']	=	0;
			}
		echo json_encode($row);
	}
	private function set_upload_options($newfilename,$filename,$upload_path,$allowed_types)
	{   
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 	 = $newfilename.rand(0,9999).'.'.$extension;
		$config['upload_path'] 	 = $upload_path;
		$config['allowed_types'] = $allowed_types;
		$config['max_size']      = '5000';
		$config['overwrite']     = TRUE;

		return $config;
	}
 	public function update_export()
	{
		$export_data = array(
			'calculation_operator'	=> $this->input->post('calculation_operator'),
			'certification_charge'	=> $this->input->post('certification_charge'),
			'insurance_charge'		=> $this->input->post('insurance_charge'),
			'seafright_charge'		=> $this->input->post('seafright_charge'),
			'seafright_action'		=> $this->input->post('seafright_action'),
			'courier_charge'		=> $this->input->post('courier_charge'),
			'bank_charge'			=> $this->input->post('bank_charge'),
			'discount'				=> $this->input->post('discount'),
			'export_under'			=> $this->input->post('export_under'),
			'export_under1'			=> $this->input->post('export_under1'),
			'company_rules' 		=> $this->input->post('company_rules'),
			'rex_no_detail' 		=> $this->input->post('rex_no_detail'),
		 	'epcg_licence_no'		=> $this->input->post('epcg_licence_no'),
			'grand_total'			=> $this->input->post('grand_total'),
			'before_grand_total'			=> $this->input->post('before_grand_total'),
			'Exchange_Rate_val'		=> $this->input->post('Exchange_Rate_val'),
			'remarks'				=> $this->input->post('remarks'),
			'supplier_gstib'		=> $this->input->post('supplier_gstib'),
			'supplier_invoice_no'	=> $this->input->post('supplier_invoice_no'),
			'supplier_invoice_date'	=> date('Y-m-d',strtotime($this->input->post('supplier_invoice_date'))),
			'indian_ruppe_val'		=> $this->input->post('indian_ruppe_val'),
		 	'lut_no'			    => $this->input->post('lut_no'),
			'lut_expiry'		 	=> $this->input->post('lut_expiry'),
			'notification_text'		=> $this->input->post('notification_text'),
			'commision_amt'		 	=> $this->input->post('commision_rate'),
			'lei_no'		 		=> $this->input->post('lei_no'),
			'aeo_no'		 		=> $this->input->post('aeo_no'),
			'extra_calc_name'		=> $this->input->post('extra_calc_name'),
			'extra_calc_amt'		=> $this->input->post('extra_calc_amt'),
			'extra_calc_opt'		=> $this->input->post('extra_calc_opt'),
			'indian_ruppe_after_gst'=> $this->input->post('aftergst_indian_ruppe_val'),
			);
			 
			 $step = 5;
			 
			 if($this->input->post('direct_invoice') == 1)
			 {
				 $step = 1;
			 }
			
			$export_data['step'] = ($this->input->post('step')==4)?$this->input->post('step'):$step;
			$export_data_update_id = $this->export->updateexport($export_data,$this->input->post('export_invoice_id'));
			if($this->input->post('currency_name') == "USD")
			 {
					$currency_data = array(
						"usd"				=> $this->input->post('Exchange_Rate_val'),
						"notification_text" => $this->input->post('notification_text')
					);
				$update_seting_data = $this->export->update_seting_data($currency_data,1);
			 }
			 else if($this->input->post('currency_name') == "EURO")
			 {
					$currency_data = array(
						"euro"				=> $this->input->post('Exchange_Rate_val'),
						"notification_text" => $this->input->post('notification_text')
					);
					$update_seting_data = $this->export->update_seting_data($currency_data,1);
			 }
			 else if($this->input->post('currency_name') == "GBP")
			 {
					$currency_data = array(
						"gbp"				=> $this->input->post('Exchange_Rate_val'),
						"notification_text" => $this->input->post('notification_text')
					);
					
				$update_seting_data = $this->export->update_seting_data($currency_data,1);
			 }
			 
			$this->load->model('Admin_exportinvoice');
			$htmldetele		= $this->Admin_exportinvoice->exportinvoice_html_delete($this->input->post('export_invoice_id'));
		echo 1;
	}
	public function load_design_data()
	{
		$id 			 = $this->input->post('id');
		$customer_id 	 = $this->input->post('customer_id');
		$total_container = 1;
		
		$mode = $this->input->post('mode');
			if(strtolower($mode)=="add")
			 {
				 	$data = $this->export->hsncproductsizedetail($id,2);
					$result				=$data[0];
				 	$hsnc_code			= $data[0]->hsnc_code;
					$hsncdata 			= $this->export->hsncproductcodedetail($hsnc_code);
					$hsnc 	  			= $hsncdata[0]->p_name;
					$hsncsize 			= $hsncdata[0]->size_type;
					$size_name			= $result->size_type_mm;
					$series_name		= $result->series_name;
					$thickness  		= (!empty($result->thickness))?' - '.$result->thickness.' MM':"";
					$description_goods 	= $size_name.' ('.$series_name.')';
					$packing_detail 	= $this->export->get_packing_detail($id,$customer_id);
					 $deletestatus 		= 0;
			  }
			 else if(strtolower($mode)=="edit")
			 {
				 $exportproduct_trn_id = $this->input->post('exportproduct_trn_id');
				 $product_id 			= $this->input->post('id');
				 $deletestatus 			= $this->input->post('deletestatus');
				 $fetchproductresult 	= $this->export->fetchproductrecord($exportproduct_trn_id);
				 $packing_detail 		= $this->export->get_packing_detail($id,$customer_id);
				 $description_goods 	= $fetchproductresult->description_goods;
				 
			 }
		$str = '<div class="col-md-12">
				 <div class="field-group">
					<textarea id="description_goods" name="description_goods" placeholder="Description of Goods" class="form-control" required="" title="Enter Description of Goods" style="height:50px;" >'.$description_goods.'</textarea>
				 </div>    
				</div>  
					<div class="col-md-4">
						<div>
							 <select class="select2" id="product_size_id" name="product_size_id" onchange="load_packing(this.value,&quot;'.$mode.'&quot;,'.$deletestatus.')">
								<option value="">Select Packing</option>';
						 		foreach($packing_detail as $packing_row)
								{
									$sel = '';
									
								 	if($fetchproductresult->product_size_id == $packing_row->product_size_id)
									{
										$sel = 'selected="selected"';
									}
									else if($packing_row->p_size == $packing_row->product_size_id)
									{
										$sel = 'selected="selected"';
									}
									$label = $packing_row->product_packing_name;
														if($packing_row->boxes_per_pallet > 0)
														{
															$label .= ' - '.$packing_row->boxes_per_pallet.' Boxes - '.$packing_row->total_pallent_container.' Pallets';
														}
														else if($packing_row->box_per_big_plt > 0 || $packing_row->no_small_plt_container_new >0)
														{
															$label .= ' - '.$packing_row->box_per_big_plt.' * '.$packing_row->no_big_plt_container_new.','.$packing_row->box_per_small_plt_new.' * '.$packing_row->no_small_plt_container_new.' Pallets';
														}
														else
														{
															$label .= ' - '.$packing_row->total_boxes.' Boxes';
														}
						 			$str .='<option '.$sel.' value="'.$packing_row->product_size_id.'">'.$label.'</option>';
						 		}
					 	$str .='</select>
						</div>    
				    </div>
					<div class="packing_detail"></div> ';
		
		echo $str;
	}
	public function load_packing()
	{
		$id = $this->input->post('exportproduct_trn_id');
		$product_size_id = $this->input->post('product_size_id');
		$total_container = 1;
		$mode = $this->input->post('mode');
		
			if(strtolower($mode)=="add")
			 {
				  $data = $this->export->fetch_packing_detail($product_size_id);
				  
				  $data_product = $this->export->hsncproductsizedetail($data->product_id,2);
					 
				   $fetchresult = $this->export->fetchdesign_detail($data->product_id);
					
					$result=$data;
					$checked1 = "";
					$checked2 = "";
					$checked3 = "";
					
					if($result->boxes_per_pallet>0)
					{
						$checked1 					= "checked";
						$pallet_weight 				= $result->pallet_weight;
						$boxes_per_pallet 			= $result->boxes_per_pallet;
						$no_of_pallet 				= $result->total_pallent_container;
						$no_of_pallet1 				= $result->total_pallent_container;
						$sqm_per_container 			=  $result->sqm_per_container;
						$defualt_netweight 			= $fetchproductresult->pallet_net_weight_per_container;
						$defualt_grossweight	 	= $result->pallet_gross_weight_per_container;
						$total_box_per_container 	= $result->box_per_container;
					}
					else if($result->total_boxes>0)
					{
						$checked2 					= "checked";
						$total_boxes 				= $result->total_boxes;
						$sqm_per_container 			=  $result->withoutpallet_sqm_per_container;
						$defualt_netweight 			= $fetchproductresult->withoutnet_weight_per_container;
						$defualt_grossweight 		= $result->withoutgross_weight_per_container;
						$total_box_per_container 	= $result->total_boxes;
					}
					else if($result->box_per_big_plt>0)
					{
						$checked3 					= "checked";
						$big_pallet_weight 			= $result->big_plat_weight;
						$small_pallet_weight 		= $result->small_plat_weight;
						$box_per_big_pallet 		= $result->box_per_big_plt;
						$box_per_small_pallet 		= $result->box_per_small_plt_new;
						$no_of_big_pallet 			= $result->no_big_plt_container_new;
					 	$no_of_small_pallet			= $result->no_small_plt_container_new;
						$sqm_per_container 			=  $result->multi_sqm_per_container;
						$total_box_per_container 	= $result->multi_box_per_container;
					}
						$weight_per_box 			= $result->weight_per_box;
						$sqm_per_box 				= $result->sqm_per_box;
						$pcs_per_box 				= $result->pcs_per_box;
					 
					$price							= $result->defualt_rate;
					$Total_Amount_usd				= $price * $result->sqm_per_container;
					$usdprice 						= number_format((float)$price, 2, '.', '');
					$Total_Amount_euro				= $price*$result->sqm_per_container;
					$europrice 						= number_format((float)$price, 2, '.', '');
					$totalprice 					= ($currency == "USD")? number_format((float)$Total_Amount_usd, 2, '.', '') : number_format((float)$Total_Amount_euro, 2, '.', '');
					$default_total	 				= ($currency == "USD")? number_format((float)$Total_Amount_usd, 2, '.', '') : number_format((float)$Total_Amount_euro, 2, '.', '');
					
					  
					$total_container 	= 1;
					$container_checked 	='checked';
					$displaynone 		= '';
					$series_id 			= $result->series_id;
					$model_type_id 		= $result->model_type_id;
					$defualt_status 	= 1;
					 
			 }
			 else if(strtolower($mode)=="edit")
			 {
				 $exportproduct_trn_id 	= $this->input->post('exportproduct_trn_id');
				 $product_size_id 		= $this->input->post('product_size_id');
			 	 $deletestatus 			= $this->input->post('deletestatus');
				 $fetchproductresult 	= $this->export->fetchproductrecord($exportproduct_trn_id);
			 	 $data_product 			= $this->export->hsncproductsizedetail($fetchproductresult->product_id,2);
				 $design_data 			= $this->export->fetchdesign_detail($fetchproductresult->product_id);
				 $checked1 				= ($fetchproductresult->pallet_status==1)?"checked":"";
				 $checked2		 		= ($fetchproductresult->pallet_status==2)?"checked":"";
				 $checked3				= ($fetchproductresult->pallet_status==3)?"checked":"";
				 $container_checked 	= ($fetchproductresult->product_container>0)?'checked':'';
				 $displaynone	  	 	= ($fetchproductresult->product_container==0)?'display:none':'';
			 	 $total_container 		= $fetchproductresult->product_container;
				 $weight_per_box 		= $fetchproductresult->weight_per_box;
				 $pallet_weight 		= $fetchproductresult->pallet_weight;
				 $boxes_per_pallet 		= $fetchproductresult->boxes_per_pallet;
				 $big_pallet_weight 	= $fetchproductresult->big_pallet_weight;
				 $small_pallet_weight 	= $fetchproductresult->small_pallet_weight;
				 $box_per_big_pallet 	= $fetchproductresult->box_per_big_pallet;
				 $box_per_small_pallet 	= $fetchproductresult->box_per_small_pallet;
				 $sqm_per_box 			= $fetchproductresult->sqm_per_box;
				 $pcs_per_box 			= $fetchproductresult->pcs_per_box;
				 $hsnc_code 			= $fetchproductresult->hsnc_code;
			 }
		$str = '	<div class="col-md-8">
						<div>
							With/Without Pallet :
						 	<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status1" value="1" '.$checked1.' onclick="check_pallet_status(this.value)"  />With Pallet 
							</label>
							 <label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet_status(this.value)" '.$checked2.' />Without Pallet
							</label> 
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status3" value="3" onclick="check_pallet_status(this.value)" '.$checked3.' />Multi Pallet
							</label>
						</div>    
				    </div>
					<div class="col-md-12">	</div>
					 <div class="col-md-4">					
						<div class="field-group">';
							 if($deletestatus != 1)
							 {
									$str .= '
									<lable class="col-md-12" >Total Container</lable>
										<div class=" col-md-6">
											<input onchange="change_container()" value="1" type="checkbox" id="container_check" name="container_check" data-toggle="toggle" data-on="Full" data-off="Multi" '.$container_checked.'>
										</div>
										<div class=" col-md-4">
												<input type="text" id="total_container" name="total_container" placeholder="Total Container" required="" class="form-control" required="" value="'.$total_container.'"   title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="change_container()" onblur="change_container()" style="'.$displaynone.'"/>
												</div>
								 		</div>
										';
							 }
							else{
								$str .= '
									<lable class="col-md-12" >Total Container</lable>
										<div class=" col-md-4">
											1st Delete Container
										</div>
										<div class=" col-md-4">
												<input type="hidden" id="total_container" name="total_container" placeholder="Total Container" required="" class="form-control" required="" value="'.$total_container.'"   title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="change_container()" onblur="change_container()" style="'.$displaynone.'"/>
												</div>
								 		</div>
										';
							}
			$str .= '</div>
					</div> 
					<div class="col-md-2">					
				      <div class="field-group">
				    	<lable>Weight Per Box </lable>
				         <input type="text" id="weight_per_box" name="weight_per_box" placeholder="Weight Per Box" class="form-control"  value="'.$weight_per_box.'" onkeypress="return isNumber(event)" onkeyup="cal_all_total(2)"  onblur="cal_all_total(2)" /> 
						
				    </div>                     
				    </div> 
					
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Big Pallet Weight</lable>
							<input type="text" id="big_pallet_weight" name="big_pallet_weight" placeholder="Big Pallet Weight" required="" class="form-control" value="'.$big_pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_all_total(2)" onblur="cal_all_total(2)"/>
				    </div>                     
				    </div>
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Small Pallet Weight</lable>
							<input type="text" id="small_pallet_weight" name="small_pallet_weight" placeholder="Small Pallet Weight" required="" class="form-control" value="'.$small_pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_all_total(2)" onblur="cal_all_total(2)"/>
				    </div>                     
				    </div>
					<div class="col-md-2 pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Pallet</lable>
								<input type="text" id="boxes_per_pallet" name="boxes_per_pallet" placeholder="Boxes Per Pallet" required="" class="form-control" required="" value="'.$boxes_per_pallet.'" title="Enter Boxes Per Pallet" onkeypress="return isNumber(event)" onkeyup="cal_all_total(2)"  onblur="cal_all_total(2)"/>
					 	  </div>                     
				    </div>
					
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Big Pallet</lable>
								<input type="text" id="box_per_big_pallet" name="box_per_big_pallet" placeholder="Boxes Per Big Pallet" required="" class="form-control" required="" value="'.$box_per_big_pallet.'" title="Enter Boxes Per Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_all_total(2)"   onblur="cal_all_total(2)"/>
						   </div>                     
				    </div>
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Small Pallet</lable>
								<input type="text" id="box_per_small_pallet" name="box_per_small_pallet" placeholder="Boxes Per Big Pallet" required="" class="form-control" required="" value="'.$box_per_small_pallet.'" title="Enter Boxes Per Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_all_total(2)" onblur="cal_all_total(2)"/>
									 
						  </div>                     
				    </div> 
					<div class="col-md-2">				
					 <div class="field-group">
				    	<lable>Sqm Per box</lable>
								<input type="text" id="sqm_per_box" name="sqm_per_box" placeholder="Sqm Per box" required="" class="form-control" required="" value="'.$sqm_per_box.'" readonly/>
								<input type="hidden" id="pcs_per_box" name="pcs_per_box" value="'.$pcs_per_box.'" readonly/>
									 
						  </div>                     
				    </div>
					<div class="col-md-2 pallet_calcution">					
				     <div class="field-group">
				    	<lable>Empty Pallet Weight</lable>
							<input id="pallet_weight" type="text" name="pallet_weight" placeholder="Pallet Weight" required="" class="form-control" value="'.$pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)"  onkeyup="cal_all_total(2)"  onblur="cal_all_total(2)"/>
				    </div>                     
				    </div>
					<div class="col-md-12">
					
				<table class="table table-bordered table-hover rate_table" id="">
				<tr>
					<td width="15%">Design</td>
					<td width="15%">Finish</td>
					<td width="10%">Client Name</td>
					<td width="10%">Barcode No</td>
					<td width="8%">Rate </td>
					<td width="13%" class="pallet_calcution multi_pallet_calcution">NO OF PALLET </td>
					<td width="8%">BOXES</td>
					<td width="8%">SQM</td>
					<td width="8%">Amount</td>
					<td width="5%">Add</td>
				</tr>';
				if(strtolower($mode)=="edit")
				{
						$getpacking_detail = $this->export->get_packing($id);
						 
						$no = 1;
						$str .= '<input type="hidden" id="row_cont" name="row_cont"  value="'.count($getpacking_detail).'"/>';
						foreach($getpacking_detail as $row)
						{
						 $str .='<tr class="appendtr'.$no.'">
										<td class="">
											<select class="select2" id="design_id'.$no.'" name="design_id[]" class="select2" onchange="load_finish(this.value,'.$no.')">';
											$str .= '<option value="">Select Design Name</option>';
											foreach($design_data as $design_row)
											{
												$sel = '';
												if($design_row->packing_model_id == $row->design_id)
												{
													$sel = 'selected="selected"';
												}
												$str .= '<option '.$sel.' value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
											}
									$str .= '</select>
										</td>
										<td class="">
											<select class="select2" id="finish_id'.$no.'" name="finish_id[]" class="select2" onchange="load_rate('.$no.')">';
											$fetchresult = $this->export->fetchfinish_detail($row->design_id);
													foreach($fetchresult as $finish_row)
													{
														$sel = '';
													if($finish_row->finish_id == $row->finish_id)
													{
														$sel = 'selected="selected"';
													}
														$str .= '<option '.$sel.' value="'.$finish_row->finish_id.'">'.$finish_row->finish_name.'</option>';
													}											
										$str .= '	</select>
										</td>
										<td class="">
											<input type="text" name="client_name[]" id="client_name'.$no.'" class="form-control" value="'.$row->client_name.'" />
										</td>
										<td class="">
												<input type="text" name="barcode_no[]" id="barcode_no'.$no.'" class="form-control" value="'.$row->barcode_no.'"/>
										</td>
										<td class="">
											<input type="text" name="product_rate[]" id="product_rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" value="'.$row->product_rate.'" />
										</td>
										<td class="pallet_calcution multi_pallet_calcution">
											<input type="text" name="no_of_pallet[]" id="no_of_pallet'.$no.'" class="form-control pallet_calcution"  onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" value="'.$row->no_of_pallet.'"/>
											<span class="multi_pallet_calcution"> 
												Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" value="'.$row->no_of_big_pallet.'" placeholder ="Big Pallet"/>
												Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" value="'.$row->no_of_small_pallet.'"  placeholder ="Small Pallet"/>
												</span>
										</td>
										<td class="">
											<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$no.'" class="form-control" value="'.$row->no_of_boxes.'" onkeypress="return isNumber(event)" onkeyup="cal_box_trn('.$no.')"   onblur="cal_box_trn('.$no.')"  />
										</td>
										<td class="">
											<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$no.'" class="form-control" readonly  value="'.$row->no_of_sqm.'"/>
										</td>
										<td class="">
											<input type="text" name="product_amt[]" id="product_amt'.$no.'" class="form-control" readonly   value="'.$row->product_amt.'"/>
											<input type="hidden" name="packing_net_weight[]" id="packing_net_weight'.$no.'" value="'.$row->packing_net_weight.'" />
											<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight'.$no.'"   value="'.$row->packing_gross_weight.'"/>
										</td>';
										 if($no != 1)
										 {
											$str .= '<td class="">
													<button type="button" onclick="remove_row('.$no.')"  class="btn btn-danger">-</button>
											</td>';
										 }
										 else
										 {
											 $str .= '<td class="">
													 
											</td>';
										 }
									$str .='</tr>';
									$no++;
						}
				}
				else{
				$str .='
				<input type="hidden" id="row_cont" name="row_cont"  value="1"/>
				<tr class="appendtr1">
					<td class="">
						<select class="select2" id="design_id1" name="design_id[]" class="select2" onchange="load_finish(this.value,1)">';
						$str .= '<option value="">Select Design Name</option>';
						foreach($fetchresult as $design_row)
						{
							$str .= '<option value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
						}
					$str .= '</select>
						</td>
						<td class="">
							<select class="select2" id="finish_id1" name="finish_id[]" class="select2" onchange="load_rate(1)">
							</select>
						</td>
						<td class="">
							<input type="text" name="client_name[]" id="client_name1" class="form-control" />
						</td>
						<td class="">
							<input type="text" name="barcode_no[]" id="barcode_no1" class="form-control" />
						</td>
						<td class="">
							<input type="text" name="product_rate[]" id="product_rate1" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_product_trn(1)"  onblur="cal_product_trn(1)" />
						</td>
						<td class="pallet_calcution multi_pallet_calcution">
							<input type="text" name="no_of_pallet[]" id="no_of_pallet1" class="form-control pallet_calcution" value="'.$no_of_pallet.'" onkeypress="return isNumber(event)" onkeyup="cal_product_trn(1)"  onblur="cal_product_trn(1)"/>
							<span class="multi_pallet_calcution"> 
								Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet1" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn(1)"   onkeyup="cal_product_trn(1)" value="'.$no_of_big_pallet.'" placeholder ="Big Pallet"/>
								Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet1" class="form-control "  onkeypress="return isNumber(event)" onblur="cal_product_trn(1)"   onkeyup="cal_product_trn(1)" value="'.$no_of_small_pallet.'"  placeholder ="Small Pallet"/>
							</span>
						</td>
						<td class="">
							<input type="text" name="no_of_boxes[]" id="no_of_boxes1" class="form-control"   value="'.$total_box_per_container.'"  onkeypress="return isNumber(event)" onkeyup="cal_box_trn(1)"   onblur="cal_box_trn(1)" />
						</td>
						<td class="">
							<input type="text" name="no_of_sqm[]" id="no_of_sqm1" class="form-control" readonly  value="'.$sqm_per_container.'"/>
						</td>
						<td class="">
							<input type="text" name="product_amt[]" id="product_amt1" class="form-control" readonly />
							<input type="hidden" name="packing_net_weight[]" id="packing_net_weight1" />
							<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight1"  />
						</td>
						<td class="">
							
						</td>
					</tr>';
				}	
				$str	.='<tr>
						<td colspan="5" style="text-align:right">
							Total
						</td>
						 
						<td class="pallet_calcution multi_pallet_calcution">
							<input type="text" readonly name="total_no_of_pallet" id="total_no_of_pallet" class="form-control" />
						</td>
						<td class="">
							<input type="text" name="total_no_of_boxes" id="total_no_of_boxes" class="form-control" readonly />
						</td>                         
						<td class="">                 
							<input type="text" name="total_no_of_sqm" id="total_no_of_sqm" class="form-control" readonly/>
						</td>                       
						<td class="">               
							<input type="text" name="total_product_amt" id="total_product_amt" class="form-control" readonly />
						</td>
						<td class="">
							 <button type="button" onclick="add_row()" class="btn btn-info">+</button>
						</td>
					</tr>
			</table>
			</div> <div class="col-md-12"></div>	
					 
					 <div class="col-md-6 pallet_calcution multi_pallet_calcution">	
						 <div class="field-group">
							<lable><strong>Total Pallet Weight</strong> : <span id="Pallet_Weight_html"></span> Kg</lable>
								<input type="hidden" id="total_pallet_weight" name="total_pallet_weight" value=""/>    
						</div> 
					</div>				
					<div class="col-md-6">	
					 <div class="field-group">
						<lable><strong>Net Weight</strong>   </lable>
							<input type="text" id="total_net_weight" name="total_net_weight" value="" readonly/>    
						 Kg 
							  
						</div> 
					</div>
					<div class="col-md-6">	
					 <div class="field-group">
						<lable><strong>Gross Weight</strong> 
							<input type="text" readonly id="total_gross_weight" name="total_gross_weight" value=""/>  <span>Kg</span> </lable>
						 
						</div> 
					</div>
				  </div> ';
		
		echo $str;
	}
	public function add_design_row()
	{
		$design_id 		=  $this->input->post('design_id');
		$finish_id 		=  $this->input->post('finish_id');
		$product_id		=  $this->input->post('product_id');
		$no 	   		=  ($this->input->post('no') + 1);
		$fetchresult 	= $this->export->fetchdesign_detail($product_id);
		$str .='<tr class="appendtr'.$no.'">
				<td >
					<select class="select2" id="design_id'.$no.'" name="design_id[]" class="select2" onchange="load_finish(this.value,'.$no.')">';
					$str .= '<option value="">Select Design Name</option>';
					foreach($fetchresult as $design_row)
					{
						$str .= '<option value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
					}
				$str .= '</select>
						</td>
						<td class="">
							<select class="select2" id="finish_id'.$no.'" name="finish_id[]" class="select2" onchange="load_rate('.$no.')"> 
							</select>
						</td>
						<td class="">
							<input type="text" name="client_name[]" id="client_name'.$no.'" class="form-control" />
						</td>
						<td class="">
							<input type="text" name="barcode_no[]" id="barcode_no'.$no.'" class="form-control" />
						</td>
						<td class="">
							<input type="text" name="product_rate[]" id="product_rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"  onblur="cal_product_trn('.$no.')" />
						</td>
						<td class="pallet_calcution multi_pallet_calcution">
							<input type="text" name="no_of_pallet[]" id="no_of_pallet'.$no.'" class="form-control pallet_calcution" value="" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"  onblur="cal_product_trn('.$no.')" />
							<span class="multi_pallet_calcution"> 
								Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onkeyup="cal_product_trn('.$no.')"  placeholder ="Big Pallet"/>
								Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$no.'" class="form-control "  onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')"  placeholder ="Small Pallet"/>
							</span>
						</td>
						<td class="">
							<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$no.'" class="form-control" value="" onkeypress="return isNumber(event)" onkeyup="cal_box_trn('.$no.')"   onblur="cal_box_trn('.$no.')"  />
						</td>
						<td class="">
							<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$no.'" class="form-control" readonly  value=""/>
						</td>
						<td class="">
							<input type="text" name="product_amt[]" id="product_amt'.$no.'" class="form-control" readonly />
							<input type="hidden" name="packing_net_weight[]" id="packing_net_weight'.$no.'" />
							<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight'.$no.'"  />
						</td>
						<td class="">
							<button type="button" onclick="remove_row('.$no.')" class="btn btn-danger">-</button>
						</td>
					</tr>';
	  
		echo $str;
	}
	public function load_finish_data()
	{
		
		$id 		 = $this->input->post('id');
		$customer_id = $this->input->post('customer_id');
		$product_id  = $this->input->post('product_id');
		 
		$fetchresult = $this->pinv->fetchfinish_detail($id);
		$fetchdetail_detail =  '';
		
		$str = '';
		$finish_id = 0;
		$n=0;
		foreach($fetchresult as $finish_row)
		{
			if($n == 0){$finish_id = $finish_row->finish_id;}
				 
			$str .= "<option value='".$finish_row->finish_id."'>".$finish_row->finish_name."</option>";
			$n++;
		}
	
		if(!empty($id) &&  !empty($product_id) && !empty($customer_id))
		{
			$fetchdetail_detail = $this->Admin_customer_detail->get_design_data($customer_id,$product_id,$id,$finish_id);
		}
		$array = array('html'=>$str,'design_detail'=>$fetchdetail_detail);
		echo json_encode($array);
	}
	public function load_rate()
	{
		$cust_id		  = $this->input->post('consigne_id');
		$product_id		  = $this->input->post('product_id');
		$packing_model_id = $this->input->post('design_id');
		$finish_id 		  = $this->input->post('finish_id');
		$fetchresult 	  = $this->export->getdesignrate($cust_id,$product_id,$packing_model_id,$finish_id);
		echo json_encode($fetchresult); 
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$id1 = $this->input->post('id1');
		$deleterecord = $this->export->delete_product($id);	
		$deleterecord1 = $this->export->delete_loading_trn($id1);	
		$deletedataid = $this->export->delete_packing_data($id);
	   
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
	}
	public function fetchproductdata()
	{
		$id = $this->input->post('id');
		$fetchresult = $this->export->fetchrecord($id);
		echo json_encode($fetchresult);
	}
	public function allproductsave($id){

		$rdata = $this->export->product_data_save($id);
		
			if($rdata)
			{	
				redirect(base_url('packing/index/'.$id));
			}
	}
	public function selecthsncproduct()
	{
		$hsncval=$this->input->post('hsncval');
		$resultdata=array();
		$data=$this->export->hsncproductsize($hsncval);
		
		foreach($data as $row)
		{
			$resultdata[]=array($row->size_details,$row->id);	
		}
		 echo json_encode($resultdata);
	}
	public function updateinvoice()
	{
		$invoiceid=$this->input->post('invoice_id');
		//$remarks=$this->input->post('remarks');
	 	$step=1;
		$temp_status=0;
		$updatestepinvoice = $this->export->export_invoice_stepupdate($invoiceid,$step,$temp_status);
	}
	public function make_container_fun()
	{
		$first=1;
		$no = 0;
		$mix_gross_weight = 0;
		$mix_net_weight = 0;
		$grossweight = explode(",",$this->input->post('grossweight'));
		$netweight 	= explode(",",$this->input->post('netweight'));
		foreach(explode(",",implode(",",$this->input->post('allvalues'))) as $row)
		{
			$updatedata = array(
				"container_order_by" => $this->input->post('cnt')
			);
			if($first==1)
			{
				$updatedata['rowspan_no'] = $this->input->post('no_of_row');
			}
			else
			{
				$updatedata['rowspan_no'] = 0;
			}
			  $mix_gross_weight += $grossweight[$no];
			  $mix_net_weight   += $netweight[$no];
			$update_id = $this->export->updateproductrecord($updatedata,$row);
		$first++; 
		$no++;  
		}
		 $data = array(
			'allproduct_id'		 => implode(",",$this->input->post('allvalues')),
			'mix_gross_weight'	 => $mix_gross_weight,
			'mix_net_weight'	 => $mix_net_weight,
			'exportinvoice_id'	 => $this->input->post('export_invoice_id'),
			'container_count'	 => 1,
			'container_order_by' => $this->input->post('cnt'),
			'status'			 => 0 
			); 
			$insertid = $this->export->insert_makecontainer($data);
			echo  "1";
			 
	}
	public function displaydataproduct()
	{
		$id=$this->input->post('id');
		$currency = $this->input->post('currency');
		$currency_symbol = ($currency == "Euro")?"&euro;":"$";
		$userdata = $this->export->ciadmin_login();
		$contentdata='';
		$countdata = $this->export->hsncproductsizedetail($id,1);
		$modeltype = $this->export->get_modeltype($id);
		 if($countdata>0)
		 {
			 $mode = $this->input->post('mode');
			 $no_of_container = $this->input->post('no_of_container');
			 if(strtolower($mode)=="add")
			 {
					$data = $this->export->hsncproductsizedetail($id,2);
					$result=$data[0];
					$checked1 = "";
					$checked2 = "";
					$checked3 = "";
					if($result->boxes_per_pallet>0)
					{
						$checked1 = "checked";
						$pallet_weight = $result->pallet_weight;
						$boxes_per_pallet = $result->boxes_per_pallet;
						$no_of_pallet = $result->total_pallent_container;
						$no_of_pallet1 = $result->total_pallent_container;
						$sqm_per_container =  $result->sqm_per_container;
						$defualt_netweight = $fetchproductresult->pallet_net_weight_per_container;
						$defualt_grossweight = $result->pallet_gross_weight_per_container;
						$total_box_per_container = $result->box_per_container;
					}
					else if($result->total_boxes>0)
					{
						$checked2 = "checked";
						$total_boxes = $result->total_boxes;
						$sqm_per_container =  $result->withoutpallet_sqm_per_container;
						$defualt_netweight = $fetchproductresult->withoutnet_weight_per_container;
						$defualt_grossweight = $result->withoutgross_weight_per_container;
						$total_box_per_container = $result->total_boxes;
					}
					else if($result->box_per_big_plt>0)
					{
						$checked3 = "checked";
						$big_pallet_weight = $result->big_plat_weight;
						$small_pallet_weight = $result->small_plat_weight;
						$box_per_big_pallet = $result->box_per_big_plt;
						$box_per_small_pallet = $result->box_per_small_plt_new;
						$no_big_plt = $result->no_big_plt_container_new;
						$no_big_plt1 = $result->no_big_plt_container_new;
						$no_small_plt = $result->no_small_plt_container_new;
						$no_small_plt1 = $result->no_small_plt_container_new;
					}
					$hsnc_code 		= $data[0]->hsnc_code;
					$hsncdata 		= $this->export->hsncproductcodedetail($hsnc_code);
					$hsnc 			= $hsncdata[0]->p_name;
					$hsncsize 		= $hsncdata[0]->size_type;
					$size_name		= $result->size_type_mm;
					$series_name	= $result->series_name;
					$thickness 		= (!empty($result->thickness))?' - '.$result->thickness.' MM':"";
					$description_goods =	$size_name.' ('.$series_name.')';
					$weight_per_box = $result->weight_per_box;
				 	$sqm_per_box = $result->sqm_per_box;
					$pcsperbox = $result->pcsperbox;
				
					$usdprice=$result->defualt_rate;
					 
					 $Total_Amount_euro=$euro*$result->sqmpercontain;
					$europrice = number_format((float)$euro, 2, '.', '');
					$totalprice = ($currency == "USD")? number_format((float)$Total_Amount_usd, 2, '.', '') : number_format((float)$Total_Amount_euro, 2, '.', '');
					  
					    
					$total_container = 1;
					$container_checked ='checked';
					$displaynone = '';
					$series_id = $result->series_id;
					$model_type_id = $result->model_type_id;
					$defualt_status = 1;
			 }
			 else if(strtolower($mode)=="edit")
			 {
				 $id = $this->input->post('exportproduct_trn_id');
				 $product_id = $this->input->post('id');
				 $fetchproductresult = $this->export->fetchproductrecord($id);
				 $checked1 =  ($fetchproductresult->pallet_status==1)?"checked":"";
				 $checked2 =  ($fetchproductresult->pallet_status==2)?"checked":"";
				 $checked3=  ($fetchproductresult->pallet_status==3)?"checked":"";
				 $description_goods = $fetchproductresult->description_goods;
				
				 $orignal_box_per_pallent = $fetchproductresult->orignal_box_per_pallent;
				 $orignal_total_pallet = $fetchproductresult->orignal_total_pallet;
				 $weight_per_box = $fetchproductresult->apwigtperbox;
				 $boxes_per_pallet = $fetchproductresult->Plts;
				
				 $box_per_small_pallet = $fetchproductresult->box_per_small_pallet;
				 $box_per_big_pallet = $fetchproductresult->box_per_big_pallet;
				 $big_pallet_weight = $fetchproductresult->big_pallet_weight;
				 $small_pallet_weight = $fetchproductresult->small_pallet_weight;
				 $pallet_weight = $fetchproductresult->pallet_weight;
				 $model_type_id = $fetchproductresult->model_type_id;
				
			 	 $usdprice = $fetchproductresult->Rate_In_USD;
				 $europrice = $fetchproductresult->Rate_in_euro;
				 $data = $this->export->hsncproductsizedetail($product_id,2);
				 $hsnc_code = $data[0]->hsnc_code;
				 $hsncdata = $this->export->hsncproductcodedetail($hsnc_code);
				 $hsnc = $hsncdata[0]->p_name;
				 $hsncsize = $hsncdata[0]->size_type;
				 $sqmpercontain =  $fetchproductresult->SQM;
				 $total_boxes = $fetchproductresult->total_box;
				 $total_box_per_container = $fetchproductresult->Boxes;
				 
				  $sqm_per_box = $fetchproductresult->appsqmperboxes;
			     $pcsperbox = $fetchproductresult->pcsperbox;
				
				 $total_weight = $fetchproductresult->Total_weight;
				 $total_pallet_weight = $fetchproductresult->total_pallet_weight;
				  $defualt_netweight = $fetchproductresult->Total_weight;
				 $grossweight = $fetchproductresult->grossweight;
				  $manual_netweight = $fetchproductresult->manual_netweight;
				 $manual_grossweight = $fetchproductresult->manual_grossweight;
				 $defualt_grossweight = $fetchproductresult->grossweight;
				 $totalprice = $fetchproductresult->Total_Amount;
				 $container_checked = ($fetchproductresult->container_check==1)?'checked':'';
				 $total_container = ($fetchproductresult->container_check==1)?$fetchproductresult->product_container:'0.5';
				  
				 $rate_data = $this->export->get_edit_ratedata($model_type_id,$id);
				 $defualt_status = $fetchproductresult->defualt_status;
				 
				  
				 $no_of_pallet = $fetchproductresult->total_pallet;
				 $no_of_pallet1 = $fetchproductresult->total_pallet/$total_container;
				 $no_big_plt = $fetchproductresult->total_big_pallet;
				 $no_big_plt1 = $fetchproductresult->total_big_pallet/$total_container;
				 $no_small_plt = $fetchproductresult->total_small_pallet;
				 $no_small_plt1 = $fetchproductresult->total_small_pallet/$total_container;
			 }
			$contentdata .= '<input type="hidden" value="'.$series_id.'" name="seriesid" id="seriesid"/>
					<div class="col-md-12">
						<div class="field-group">
							<textarea id="description_goods" name="description_goods" placeholder="Description of Goods" class="form-control" required="" title="Enter Description of Goods" style="height:50px;" >'.$description_goods.'</textarea>
						</div>    
				    </div>  
					<div class="col-md-4">
						<div>
							With/Without Pallet :
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status1" value="1" '.$checked1.' onclick="check_pallet_status(this.value,&quot;'.$currency.'&quot;)"  />With Pallet 
							</label>
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet_status(this.value,&quot;'.$currency.'&quot;)" '.$checked2.' />Without Pallet
							</label>
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status3" value="3" onclick="check_pallet_status(this.value)" '.$checked3.' />Multi Pallet
							</label>
						</div>    
				    </div>
					<div class="col-md-4">					
						<div class="field-group">
							 ';
								if(!empty($container_checked))
								{
									$contentdata .= '
									<lable class="col-md-12" >Total Container</lable>
										<div class=" col-md-6">
											<input onchange="change_container();" value="1" type="checkbox" id="container_check" name="container_check" '.$container_checked.' data-toggle="toggle" data-on="Full" data-off="Multi">
										</div>
									<div class="col-md-6">
										<input type="text" id="total_container" name="total_container" placeholder="Total Container" required="" class="form-control" required="" value="'.$total_container.'"  title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="change_container();" onblur="change_container();" style="'.$displaynone.'"/>
								</div>';
								}
								else{
									$contentdata .= '
									<lable class="col-md-12" >Total Container</lable>
									<div class=" col-md-10">
										1st delete Container
									 
										<input type="hidden" id="total_container" name="total_container" placeholder="Total Container" required="" class="form-control" required="" value="0.5"   title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="change_container();" />
								</div>';
								}
								
					$contentdata .= ' 	</div>                     
					</div> 
					<div class="col-md-4">					
				     <div class="field-group">
				    	<lable>Weight Per Box </lable>
				         <input type="text" id="apwigtperbox" name="apwigtperbox" placeholder="" class="form-control"  value="'.$weight_per_box.'" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"  /> 

				    </div>                     
				    </div> 
					<div class="col-md-4 pallet_calcution">					
				     <div class="field-group">
				    	<lable>Empty Pallet Weight</lable>
							<input id="pallet_weight" type="text" name="pallet_weight" placeholder="Pallet Weight" required="" class="form-control" value="'.$pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)" />
				    </div>                     
				    </div>	
					<div class="col-md-4 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Big Pallet Weight</lable>
							<input type="text" id="big_pallet_weight" name="big_pallet_weight" placeholder="Big Pallet Weight" required="" class="form-control" value="'.$big_pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)"   onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
				    </div>                     
				    </div>
					<div class="col-md-4 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Small Pallet Weight</lable>
							<input type="text" id="small_pallet_weight" name="small_pallet_weight" placeholder="Small Pallet Weight" required="" class="form-control" value="'.$small_pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)"   onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
				    </div>                     
				    </div>
					<div class="col-md-4 pallet_calcution">					
						<div class="field-group">
							<lable>Boxes Per Pallet	</lable>
								<input type="text" id="Plts" name="Plts" placeholder="Plts" required="" class="form-control" required="" value="'.$boxes_per_pallet.'" title="Enter Boxes Per Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)"  onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"  />
								<input type="hidden" id="boxes_per_pallet" name="boxes_per_pallet" value="'.$boxes_per_pallet .'" />
						</div>                     
					</div>
					<div class="col-md-4 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Big Pallet</lable>
								<input type="text" id="box_per_big_pallet" name="box_per_big_pallet" placeholder="Boxes Per Big Pallet" required="" class="form-control" required="" value="'.$box_per_big_pallet.'" title="Enter Boxes Per Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)"   onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
						   </div>                     
				    </div>
					<div class="col-md-4 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Small Pallet</lable>
								<input type="text" id="box_per_small_pallet" name="box_per_small_pallet" placeholder="Boxes Per Big Pallet" required="" class="form-control" required="" value="'.$box_per_small_pallet.'" title="Enter Boxes Per Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
									 
						  </div>                     
				    </div>
					';
					$contentdata .= '
					<div class="col-md-6">	
					 <div class="field-group">
				    	<lable>Select Rate Group</lable>
							<div class="col-md-10" style="padding-left: 0px;padding-right: 0px;">
							<select name="model_serice[]" id="model_serice"  multiple="multiple"   title="Select Group" placeholder="Select Rate Group" onchange="set_model_rate(&quot;'.$currency.'&quot;,&quot;'.$sqm_per_box.'&quot;)"  > ';
								for($m=0;$m<count($modeltype);$m++)
								{
									$select ='';
									$exploaded_grp = explode(",",$model_type_id);
									if(in_array($modeltype[$m]->seriesgroup_id,$exploaded_grp))
									{
										$select ='selected="selected"';
									}
									$contentdata .= '<option '.$select.' value="'.$modeltype[$m]->seriesgroup_id.'">'.$modeltype[$m]->seriesgroup_name.' - '.$modeltype[$m]->group_rate.' '.$currency.' </option>';
								}
					$contentdata .= '</select>
							</div>
							 
						</div>
					</div> 
					<div class="col-md-12"  style="margin-top:10px">'; 				
					
						if($defualt_status==1)
						{
							$display='display:none';
						}
						$contentdata .= '<button type="button" class="btn btn-success add_btn" style="'.$display.'" onclick="add_defualt(&quot;'.$currency.'&quot;)">+ Add Default</button>';
						 
						$contentdata .=		'</div>
									<div class="col-md-12" style="height:10px"></div>
					<div class="col-md-12">
						<table class="table table-bordered table-hover" id="rate_table">
							<tr>
								<td class="">Price Type</td>
								<td class="pallet_calcution">Pallet In 1 Container</td>
								<td class="pallet_calcution">Total Pallet </td>
								<td class="multi_pallet_calcution">Pallet In 1 Container </td>
								<td class="multi_pallet_calcution">Total Pallet</td>
								<td class="boxes_calculation"> Total Boxes </td>
								<td>Rate In '.$currency.' </td>
								<td class="pallet_calcution">Total Box</td>
								<td class="multi_pallet_calcution">Total Box</td>
								<td class=""> SQM Per Box</td>
								<td class=""> Total SQM</td>
							</tr>';
							 	$display='';
						if($defualt_status==0)
						{
							$display='display:none';
						}
			$contentdata .=	'<tr id="defualt_tr" style="'.$display.'" >
								<td class="">
								<button type="button" class="btn btn-danger" onclick="remove_defualt(&quot;'.$currency.'&quot;)">-</button>
									Default
								</td>
								<td class="pallet_calcution">
									 <input id="pallet_in_container" type="text" name="pallet_in_container" placeholder="Pallet In 1 Container" required="" class="form-control" value="'.$no_of_pallet1.'" title="Enter Total Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
							 	</td>
								<td class="pallet_calcution">
									 <input id="total_pallet" type="text" name="total_pallet" placeholder="Total Pallet" required="" class="form-control" value="'.$no_of_pallet.'" title="Enter Total Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)" readonly/>
									 
								</td>
								<td class="multi_pallet_calcution">
									<input id="big_pallet_in_container" type="text" name="big_pallet_in_container" placeholder="Total Big Pallet" required="" class="form-control" value="'.$no_big_plt1.'" title="Enter Total Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
									
									<input id="small_pallet_in_container" type="text" name="small_pallet_in_container" placeholder="Total Small Pallet" required="" class="form-control" value="'.$no_small_plt1.'" title="Enter Total Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
								</td>
								<td class="multi_pallet_calcution">
										<input id="total_big_pallet" type="text" name="total_big_pallet" placeholder="Total Big Pallet" required="" class="form-control" value="'.$no_big_plt.'" title="Enter Total Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)" readonly/>
										
										<input id="total_small_pallet" type="text" name="total_small_pallet" placeholder="Total Small Pallet" required="" class="form-control" value="'.$no_small_plt.'" title="Enter Total Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)" readonly/>
									 
							 	</td>
								
								<td class="boxes_calculation">
									<input type="text" id="total_boxes" name="total_boxes" placeholder="Total Boxes" required="" class="form-control" required="" value="'.$total_boxes.'" title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)" />
								</td>
								<td>	
									<input type="number" id="Rate_In_USD" name="Rate_In_USD" placeholder="Rate In USD" class="form-control" required value="'.$usdprice.'"" title="Enter Rate" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)"  onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>   
								</td>
								<td class="pallet_calcution"> 
								 	<input type="text" id="total_box" name="total_box" value="'.$total_box_per_container.'" readonly class="form-control"/>									
							 	</td>
								<td class="multi_pallet_calcution"> 
								 	<input type="text" id="multi_total_box" name="multi_total_box" value="'.$total_box_per_container.'" readonly class="form-control"/>									
							 	</td>
								<td class=""> 
								 	<input type="text" id="sqmperbox" name="sqmperbox" value="'.$sqm_per_box.'"  onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>									
							 	</td>
								<td class=""> 
									<span id="sqm_html">'.$sqm_per_container.' </span> 
									<input type="hidden" id="SQM" name="SQM" value="'.$sqm_per_container.'"/>
									<input type="hidden" id="default_total" name="default_total" value="'.$default_total.'"/>
									<input type="hidden" id="defualt_netweight" name="defualt_netweight" value="'.$defualt_netweight.'"/>									
									<input type="hidden" id="defualt_grossweight" name="defualt_grossweight" value="'.$defualt_grossweight.'"/>										
								</td>
								
							</tr>';
					$total_sqmpercontain = $sqm_per_container;
							if(strtolower($mode)=="edit")
							{
								
							for($m=0;$m<count($rate_data);$m++)
							{
								 
								$contentdata .= '<tr class="multiplerate" id="tr'.$rate_data[$m]->seriesgroup_id.'">
													<td class="">
														'.$rate_data[$m]->seriesgroup_name.'	
													</td>
													
											<td class="pallet_calcution">
												<input id="group_pallet_in_container'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_pallet_in_container[]" placeholder="Total Pallet" required="" class="form-control"  title="Enter Total Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  value="'.($rate_data[$m]->group_total_pallet/$total_container).'"  />
												
												 
											</td>
													<td class="pallet_calcution">
														<input id="total_pallet'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_total_pallet[]" placeholder="Total Pallet" required="" class="form-control"  title="Enter Total Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  value="'.$rate_data[$m]->group_total_pallet.'"  readonly/>
														
														 
													</td>
													<td class="multi_pallet_calcution">
											
												<input id="group_big_pallet_in_container'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_big_pallet_in_container[]" placeholder="Total Big Pallet" required="" class="form-control"  title="Enter Total Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  value="'.($rate_data[$m]->group_total_big_pallet/$total_container).'"  />
												
												<input id="group_small_pallet_in_container'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_small_pallet_in_container[]" placeholder="Total Small Pallet" required="" class="form-control"  title="Enter Total Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  value="'.($rate_data[$m]->group_total_small_pallet/$total_container).'"  />
												
												 
											</td>
													<td class="multi_pallet_calcution">
														<input id="group_total_big_pallet'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_total_big_pallet[]" placeholder="Total Big Pallet" required="" class="form-control"  title="Enter Total Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  value="'.$rate_data[$m]->group_total_big_pallet.'" readonly />
														
														 
														<input id="group_total_small_pallet'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_total_small_pallet[]" placeholder="Total Small Pallet" required="" class="form-control"  title="Enter Total Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  value="'.$rate_data[$m]->group_total_small_pallet.'"  readonly/>
														
														 
													</td>
											<td class="boxes_calculation">
												<input type="text" id="total_boxes'.$rate_data[$m]->seriesgroup_id.'" name="group_total_boxes[]" placeholder="Total Boxes" required="" class="form-control" required=""  title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"   onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  value="'.$rate_data[$m]->group_total_boxes.'" />
											</td>
											<td>	
												<input type="number" id="Rate_In_USD'.$rate_data[$m]->seriesgroup_id.'" name="group_Rate_In_USD[]" placeholder="Rate In USD" class="form-control" required value="'.$rate_data[$m]->group_rate.'" title="Enter Rate" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  />   
											</td>
											<td class="pallet_calcution"> 
												<input type="text" id="total_box'.$rate_data[$m]->seriesgroup_id.'" name="total_box" value="'.$rate_data[$m]->group_total_boxes.'" readonly class="form-control"/>									
											</td>
											<td class="multi_pallet_calcution"> 
												<input type="text" id="multi_total_box'.$rate_data[$m]->seriesgroup_id.'" name="multi_total_box" value="'.$rate_data[$m]->group_total_boxes.'" readonly class="form-control"/>									
											</td>
											<td class=""> 
												<input type="text" id="sqm_per_box'.$rate_data[$m]->seriesgroup_id.'" name="sqm_per_box[]" value="'.$rate_data[$m]->sqm_per_box.'" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"/>									
											</td>
											<td class=""> 
												<span id="sqm_html'.$rate_data[$m]->seriesgroup_id.'"> '.$rate_data[$m]->group_SQM.' </span>
												
												<input id="Boxes'.$rate_data[$m]->seriesgroup_id.'" type="hidden" name="group_Boxes[]"  required=""  value="'.$total_box_per_container.'" />
											 
												<input type="hidden" id="SQM'.$rate_data[$m]->seriesgroup_id.'" name="group_SQM[]" value="'.$rate_data[$m]->group_SQM.'"/> 
												 
												<input type="hidden" id="group_productrate'.$rate_data[$m]->seriesgroup_id.'" name="group_productrate[]" value="'.$rate_data[$m]->group_productrate.'"/> 
												
												<input type="hidden" id="group_weight'.$rate_data[$m]->seriesgroup_id.'" name="group_weight[]" value="'.$rate_data[$m]->group_weight.'"/> 
												<input type="hidden" id="group_grossweight'.$rate_data[$m]->seriesgroup_id.'" name="group_grossweight[]" value="'.$rate_data[$m]->group_grossweight.'"/> 
											</td>
										</tr> ';
										$total_sqmpercontain += $rate_data[$m]->group_SQM;
							}
							}
			$contentdata .= '</table>
					</div> ';
			$contentdata .=	'<div class="col-md-12"></div>	
					<div class="col-md-6">	
						<div class="field-group">
								<strong>HSNC Code </strong>: '.$hsnc_code.'
							<input type="hidden" id="hsnc_code_val" name="hsnc_code_val" value="'.$hsnc_code.'"/>
							<input type="hidden" id="hsnc_code_value" name="hsnc_code_value" value="'.$hsnc_code.'" >
						</div>					
					</div>
					<div class="col-md-6">	
						<div class="field-group">
							<lable><strong>Total SQM</strong> : <span id="total_sqm">'.$total_sqmpercontain.'</span> '.$hsncsize.' </lable>
								<input type="hidden" id="Per" name="Per"  value="'.$hsncsize.'"/>    
						</div> 
						</div>						
						<div class="col-md-6">	
						 <div class="field-group">
								<lable>
									<strong>Total Box Per Container</strong> : <span id="boxes_html">'.$total_box_per_container.'</span>
								</lable>
								<input id="Boxes" type="hidden" name="Boxes"  required=""  value="'.$total_box_per_container.'" />
								<input id="defualt_Boxes" type="hidden" name="defualt_Boxes"  required=""  value="'.$total_box_per_container.'" />
								<input id="appsqmperboxes" type="hidden" name="appsqmperboxes"  class="form-control" value="'.$sqm_per_box.'"/>
								<input id="pcsperbox" type="hidden" name="pcsperbox"  class="form-control" value="'.$pcsperbox.'"/>
								 
						</div>
						</div>
						 					
						<div class="col-md-6">	
						 <div class="field-group">
							<lable><strong>Net Weight</strong> : <input type="text" id="totalweight_html" name="totalweight_html" value="'.$manual_netweight.'" />   Kg</lable>
								<input type="hidden" id="Total_weight" name="Total_weight" value="'.$total_weight.'"/>    
						</div> 
						</div>
						<div class="col-md-6 pallet_calcution multi_pallet_calcution">	
						 <div class="field-group">
							<lable><strong>Total Pallet Weight</strong> : <span id="Pallet_Weight_html">'.$total_pallet_weight.'</span> Kg</lable>
								<input type="hidden" id="total_pallet_weight" name="total_pallet_weight" value="'.$total_pallet_weight.'"/>    
						</div> 
						</div>						
						<div class="col-md-6">	
						 <div class="field-group">
							<lable><strong>Gross Weight</strong> : <input type="text" id="grossweight_html" name="grossweight_html" value="'.$manual_grossweight.'"/>
								<input type="hidden" id="grossweight" name="grossweight" value="'.$grossweight.'"/>    
						</div> 
						</div>
						
						<div class="col-md-6">	
						 <div class="field-group">
							<lable><strong>Total Amount</strong> :'.$currency_symbol.' <span id="totalprice_html">'.$totalprice.'</span></lable>
								<input type="hidden" id="Total_Amount" name="Total_Amount"   value="'.$totalprice.'"/>    
							</div> 
						</div> 
				    </div>
					<input type="hidden" id="group_id" name="group_id[]" value="'.$model_type_id.'"/> 
					<input type="hidden" id="currency_id" name="currency_id" value="'.$currency.'"/>
					<input type="hidden" id="defualt_status" name="defualt_status" value="'.$defualt_status.'"> 
					<input type="hidden" id="rowspan_cnt" name="rowspan_cnt" value="'.count($rate_data).'"> 
				 	
				';
		 }
		 else{
			 $contentdata .= '<div class="col-md-6">	
						 <div class="field-group">
						 Please Add Packing detail <a href="'.base_url().'hsnc_code">Click Here</a>
						 </div>
						 </div>';
		 }
		echo $contentdata;
	}
	public function displaymodelrate()
	{
		$id = implode(",",$this->input->post('group_id'));
		$rate_data = $this->export->get_ratedata($id);
		$str = '';
		 $sqm_per_box = $this->input->post('sqm_per_box');
		for($m=0;$m<count($rate_data);$m++)
		{
			 $currency = "USD";
			$str .='<tr class="multiplerate" id="tr'.$rate_data[$m]->seriesgroup_id.'">
						<td class="">'.$rate_data[$m]->seriesgroup_name.'	</td>
						 
						 <td class="pallet_calcution">
							 <input id="group_pallet_in_container'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_pallet_in_container[]" placeholder="Total Pallet" required="" class="form-control"  title="Enter Total Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" value="1" />
							 
							 
						</td>
						<td class="pallet_calcution">
							 <input id="total_pallet'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_total_pallet[]" placeholder="Total Pallet" required="" class="form-control"  title="Enter Total Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" readonly />
							 
						</td>
						<td class="multi_pallet_calcution">
							 <input id="group_big_pallet_in_container'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_big_pallet_in_container[]" placeholder="Total Big Pallet" required="" class="form-control"  title="Enter Total Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" value="1"  />
						 				
												
							  <input id="group_small_pallet_in_container'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_small_pallet_in_container[]" placeholder="Total Small Pallet" required="" class="form-control"  title="Enter Total Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  value="1"  />
							 	 
						</td>
						<td class="multi_pallet_calcution">
							 <input id="group_total_big_pallet'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_total_big_pallet[]" placeholder="Total Big Pallet" required="" class="form-control"  title="Enter Total Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  readonly/>
						
							 					
												
							  <input id="group_total_small_pallet'.$rate_data[$m]->seriesgroup_id.'" type="text" name="group_total_small_pallet[]" placeholder="Total Small Pallet" required="" class="form-control"  title="Enter Total Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" readonly />
							 	
							 
						</td>
						<td class="boxes_calculation">
							<input type="text" id="total_boxes'.$rate_data[$m]->seriesgroup_id.'" name="group_total_boxes[]" placeholder="Total Boxes" required="" class="form-control" required=""  title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" />
						</td>
						<td>	
							<input type="number" id="Rate_In_USD'.$rate_data[$m]->seriesgroup_id.'" name="group_Rate_In_USD[]" placeholder="Rate In USD" class="form-control" required value="'.$rate_data[$m]->group_rate.'" title="Enter Rate" onkeypress="return isNumber(event)" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  />   
						</td>
						<td class="pallet_calcution"> 
								 	<input type="text" id="total_box'.$rate_data[$m]->seriesgroup_id.'" name="total_box" value="" readonly class="form-control"/>									
							 	</td>
								<td class="multi_pallet_calcution"> 
								 	<input type="text" id="multi_total_box'.$rate_data[$m]->seriesgroup_id.'" name="multi_total_box"  readonly class="form-control"/>									
							 	</td>
								<td class=""> 
								 	<input type="text" id="sqm_per_box'.$rate_data[$m]->seriesgroup_id.'" name="sqm_per_box[]" value="'.$sqm_per_box.'" 	onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" />									
							 	</td>
						<td class=""> 
							<span id="sqm_html'.$rate_data[$m]->seriesgroup_id.'"> </span>
							<input id="Boxes'.$rate_data[$m]->seriesgroup_id.'" type="hidden" name="group_Boxes[]"  required=""  value="'.$total_box_per_container.'" />
							
							<input type="hidden" id="SQM'.$rate_data[$m]->seriesgroup_id.'" name="group_SQM[]" value=""/> 
							 
							<input type="hidden" id="group_productrate'.$rate_data[$m]->seriesgroup_id.'" name="group_productrate[]" value=""/> 
							<input type="hidden" id="group_weight'.$rate_data[$m]->seriesgroup_id.'" name="group_weight[]"  /> 
							<input type="hidden" id="group_grossweight'.$rate_data[$m]->seriesgroup_id.'" name="group_grossweight[]" />
						</td>
					</tr> ';
		}
		 
		echo $str;
	}
	
	public function make_container_delete()
	{
	 
		$id = $this->input->post('id');
		$invoice_id = $this->input->post('invoice_id');
		$deleterecord = $this->export->make_containerdelete($id,$invoice_id);	
		$data = array(
			"container_order_by" => 0,
			"rowspan_no" => 0
		);
		$updaterecord = $this->export->updateinvoicecontainer($data,$id,$invoice_id);	
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
			 
	}
	public function sampleentry()
	{
	 	$export_invoice_id 		= $this->input->post('exportinvoiceid');
	 	$export_loading_trn_id 	= $this->input->post('export_loading_trn_id');
	 	$exportinvoicetrnid 	= $this->input->post('exportinvoicetrnid');
	 	$direct_invoice 		= $this->input->post('direct_invoice');
	 	 
		 
		$samplerecord 			= $this->export->deletesampleproductdata($export_loading_trn_id,$export_invoice_id,$direct_invoice,$exportinvoicetrnid);
		 	$no = 0; 
		 
		foreach($this->input->post('sample_size') as $sample_row)
		{
		  	if(!empty($sample_row)) 
			{
				
				$data = array(
						"export_id" 			=> $export_invoice_id,
						"export_loading_trn_id" => $export_loading_trn_id,
						"exportproduct_trn_id" 	=> $exportinvoicetrnid,
						"container_name" 		=> $this->input->post('container_no'),
						"product_id" 		 	=> 0,
						"sample_remarks"     	=> $this->input->post('sample_remarks')[$no],
						"product_size_id"    	=> $sample_row,
						"design_id"  	  	 	=> 0,
						"finish_id"  	  	 	=> 0,
						"no_of_pallet"  	 	=> $this->input->post('no_of_pallet')[$no],
						"pallet_no"  	 		=> $this->input->post('pallet_no')[$no],
						"no_of_boxes" 	     	=> $this->input->post('no_of_boxes')[$no],
						"sqm" 	 		     	=> $this->input->post('sample_sqm')[$no],
						"sample_per" 	      	=>  $this->input->post('sampleproductunit')[$no],
						"sample_rate" 	  	 	=> $this->input->post('sampleproductrate')[$no],
						"sample_amout" 	  	 	=> $this->input->post('sampleproductamount')[$no],
						"palletweight" 	  	 	=> 0,
						"netweight" 	  	 	=> $this->input->post('netweight')[$no],
						"grossweight" 	  	 	=> $this->input->post('grossweight')[$no],
						"status" 			 	=> 0,
						"cdate" 			 	=> date('Y-m-d H:i:s')
					);
				 	$insertid = $this->export->insert_sampleentry($data);
					
			}
			$no++;
			
		} 
		 $row = array();
		 $row['res']= 1;
		 echo json_encode($row);
		 
	}
	
	public function add_sample()
	{
		 $export_loading_trn_id	 = $this->input->post('export_loading_trn_id');
		 $container_no	 		 = $this->input->post('container_no');
		 
		$str = '';
		$allproduct = $this->export->allproductsize();
		 
		 $n=1;
		 $no=0;
		 	$str .='
					<div class="row'.$no.'">
						<input type="hidden" id="inner_row_value'.$no.'" name="inner_row_value" value="'.$n.'"/>
						<input type="hidden" id="container_no" name="container_no" value="'.$container_no.'"/>
						<div class="inner_row'.$no.'" >
							 
					
						<div class="col-md-1">					
						   <div class="field-group" >
								 Size
								 <br>
								<input class="form-control" type="text" id="sample_size'.$n.$no.'" name="sample_size[]" value="" placeholder="Size">  
							</div>  
						</div> 
					  <div class="col-md-2">					
						   <div class="field-group" >
						    Sample Remarks
								 <br>
								 <input type="text" class="form-control" id="sample_remarks'.$n.$no.'" name="sample_remarks[]" value="" placeholder="Sample Remarks"> 
						</div>  
					  </div> 
					  
					   	<div class="col-md-1">					
					    <div class="field-group">
								Pallet
								 <br>
								 
								<input id="no_of_pallet'.$n.$no.'" type="text" name="no_of_pallet[]" class="form-control" onkeypress="return isNumber(event)"  placeholder="Pallet" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->no_of_pallet.'" />
					 	</div> 
					   </div>
					   <div class="col-md-1">					
					    <div class="field-group">
								Pallet No
								 <br>
							 	<input id="pallet_no'.$n.$no.'" type="text" name="pallet_no[]" class="form-control"    placeholder="Pallet No" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->pallet_no.'" />
					 	</div> 
					   </div>
						<div class="col-md-1">					
					    <div class="field-group">
								Boxes
								 <br>
								 
								<input id="no_of_boxes'.$n.$no.'" type="text" name="no_of_boxes[]" class="form-control" onkeypress="return isNumber(event)"   placeholder="Boxes" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->no_of_boxes.'" />
					  	</div> 
					   </div>
					   <div class="col-md-1">					
					    <div class="field-group">
								 SQM
								 <br>
								 
								<input id="sample_sqm'.$n.$no.'" type="text" name="sample_sqm[]" class="form-control" onkeypress="return isNumber(event)"   placeholder="SQM" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_sqm.'" />
						</div> 
					   </div>
					    
					   <div class="col-md-1">					
					    <div class="field-group">
							  Net Weight
								 <br>
								 
								<input id="netweight'.$n.$no.'" type="text" name="netweight[]" class="form-control" onkeypress="return isNumber(event)" placeholder="Net Weight" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->netweight.'" />
								 
					 	</div> 
					   </div>
					   <div class="col-md-1">					
					    <div class="field-group">
							  GrossWeight
								 <br>
								<input id="grossweight'.$n.$no.'" type="text" name="grossweight[]" class="form-control" onkeypress="return isNumber(event)" placeholder="Gross Weight" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->grossweight.'" />
								 
					 	</div> 
					   </div>
						 <div class="col-md-1">						   
							<div class="field-group">
								  Rate
								 <br>
								<input id="sampleproductrate'.$n.$no.'" type="text" name="sampleproductrate[]" class="form-control" placeholder="Rate" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_rate.'" />
							</div> 
						 </div>
						 <div class="col-md-1">						   
							<div class="field-group">
								  Unit
								 <br>
								<input id="sampleproductunit'.$n.$no.'" type="text" name="sampleproductunit[]" class="form-control" placeholder="Unit" style="margin-top: 3px !important;" />
							</div> 
						 </div>
						<div class="col-md-1">						   
							<div class="field-group">
								  Amount
								 <br>
								<input id="sampleproductamount'.$n.$no.'" type="text" name="sampleproductamount[]" class="form-control" placeholder="Amount" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_amout.'" />
							</div> 
						 </div>						 
						<div class="col-md-1">						   
							<div class="field-group">
								 <a class="btn btn-primary tooltips" data-title="Add More Sample" onclick="add_inner_sample_product('.$no.','.$n.','.$container_name.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-plus"></i></a>
							</div> 
						 </div>	
					</div>						 
				 
				  </div>
				   <div class="col-md-12">	<hr /></div> ';
				 
				 
		$row['str'] = $str;
		echo json_encode($row);
	}
	public function add_inner_sample()
	{
		$no = $this->input->post('no');
		$con = $this->input->post('con');
		$container_name = $this->input->post('container_name');
		$str = '';
		$allproduct = $this->export->allproductsize();
		$n=1;
		 
		$no1 = $no.$con;
		 $str .='  <div class="col-md-12"> </div>
			<div class="inner_row'.$no1.'" >
						 <input type="hidden" id="container_no" name="container_no" value="'.$container_name.'"/>
					 	<div class="col-md-1">					
						   <div class="field-group" >
						    Size
								 <br>
								 <input type="text" id="sample_size'.$no1.'" name="sample_size[]" value="" placeholder="Size" class="form-control"> 
					 	</div>  
					  </div> 
						<div class="col-md-2">	
						 Sample Remarks
								 <br>
									<input type="text" id="sample_remarks'.$no1.'" name="sample_remarks[]" value="" placeholder="Sample Remarks" class="form-control"> 
						 </div>
							 
					 	<div class="col-md-1">					
							<div class="field-group">
							 Pallet
								 <br>
								<input id="no_of_pallet'.$no1.'" type="text" name="no_of_pallet[]" class="form-control" onkeypress="return isNumber(event)"   placeholder="Pallet" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->Pallet.'" />
							</div>
						</div>
						 <div class="col-md-1">					
					    <div class="field-group">
								Pallet No
								 <br>
								 
								<input id="pallet_no'.$no1.'" type="text" name="pallet_no[]" class="form-control"   placeholder="Pallet No" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->pallet_no.'" />
					 	</div> 
					   </div>
						<div class="col-md-1">					
					    <div class="field-group">
						   Boxes
								 <br>
								<input id="no_of_boxes'.$no1.'" type="text" name="no_of_boxes[]" class="form-control" onkeypress="return isNumber(event)"  placeholder="Boxes" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->no_of_boxes.'" />
						</div> 
					   </div>
					    <div class="col-md-1">					
					    <div class="field-group">
							  SQM
								 <br>
								<input id="sample_sqm'.$no1.'" type="text" name="sample_sqm[]" class="form-control" onkeypress="return isNumber(event)"   placeholder="SQM" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_sqm.'" />
						</div> 
					   </div>
					   <div class="col-md-1">					
					    <div class="field-group">
							Net Weight
								 <br>
								<input id="netweight'.$no1.'" type="text" name="netweight[]" class="form-control" onkeypress="return isNumber(event)" placeholder="Net Weight" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->netweight.'" />
								 
					 	</div> 
					   </div>
					   <div class="col-md-1">					
					    <div class="field-group">
							GrossWeight
								 <br>
								<input id="grossweight'.$no1.'" type="text" name="grossweight[]" class="form-control" onkeypress="return isNumber(event)" placeholder="Gross Weight" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->grossweight.'" />
								 
					 	</div> 
					   </div>
						 <div class="col-md-1">						   
							<div class="field-group">
							Rate
								 <br>
								<input id="sampleproductrate'.$no1.'" type="text" name="sampleproductrate[]" class="form-control"     placeholder="Rate" style="margin-top: 3px !important;"   />
							</div> 
						 </div>	
						 <div class="col-md-1">						   
							<div class="field-group">
							Unit
								 <br>
								<input id="sampleproductunit'.$no1.'" type="text" name="sampleproductunit[]" class="form-control"     placeholder="Unit" style="margin-top: 3px !important;"  />
							</div> 
						 </div>	
						<div class="col-md-1">						   
							<div class="field-group">
							Amount
								 <br>
								<input id="sampleproductamount'.$no1.'" type="text" name="sampleproductamount[]" class="form-control"     placeholder="Amount" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_amout.'" />
							</div> 
						 </div>	
						 
						<div class="col-md-1">						   
							<div class="field-group">
								 <a class="btn btn-warning tooltips" data-title="Remove Sample" onclick="remove_inner_sample_product('.$no1.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-minus"></i></a>
							</div> 
						 </div>	
					</div>						 
				  <div class="col-md-12"> </div>	
				  </div>';
				  $n++;
		 
		  
		echo $str;
	}
	public function edit_sampleentry()
	{
		$export_loading_trn_id = $this->input->post('export_loading_trn_id');
		$exportproduct_trn_id = $this->input->post('exportproduct_trn_id');
		$direct_invoice = $this->input->post('direct_invoice');
		 
		$str ='';
		$allproduct = $this->export->allproductsize();
		$no_of_sample = 0;
		  
			$sample_trn  = $this->export->only_sample_trn($export_loading_trn_id,$direct_invoice,$exportproduct_trn_id);
			  $n = 0;
			$str .=' <div class="row'.$n.' col-md-12">
						<input type="hidden" id="inner_row_value'.$n.'" name="inner_row_value" value="'.count($sample_trn).'"/>';
			$no_of_sample += count($sample_trn);
	 		
			for($no1=0;$no1<count($sample_trn);$no1++)
			{	
				$packing_detail=$this->export->get_packing_detail($sample_trn[$no1]->product_id,0);
				$data_product 	= 	$this->export->hsncproductsizedetail($sample_trn[$no1]->product_id,2);
				$design_detail	=	$this->export->fetchdesign_detail($sample_trn[$no1]->product_id);
				$container_name = $sample_trn[$no1]->container_name;
				 
				 
					$str .='
						 <div class="col-md-12"> </div>
					<div class="inner_row'.$no1.$no.'" >
					<input type="hidden" id="container_no" name="container_no" value="'.$container_name.'"/>
							<div class="col-md-1">					
								<div class="field-group" >
								   Size
								 <br>
								<input type="text" id="sample_size'.$no1.'" name="sample_size[]"  value="'.$sample_trn[$no1]->product_size_id.'" class="form-control" placeholder="Size">  
								</div>  
							</div> 
					  
					  	<div class="col-md-2">	
						Sample Remarks
								 <br>
									<input type="text" class="form-control" id="sample_remarks'.$no1.'" name="sample_remarks[]"  value="'.$sample_trn[$no1]->sample_remarks.'" placeholder="Sample Remarks"> 
								 
						</div>
						 <div class="col-md-1">					
							<div class="field-group">
							Pallet
								 <br>
								<input id="no_of_pallet'.$no1.'" type="text" name="no_of_pallet[]" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_sampledata('.$no1.',1)" placeholder="Pallet" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->no_of_pallet.'" />
							</div>
						</div>
						<div class="col-md-1">					
					    <div class="field-group">
								Pallet No
								 <br>
							 	<input id="pallet_no'.$no1.'" type="text" name="pallet_no[]" class="form-control"    placeholder="Pallet No" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->pallet_no.'" />
					 	</div> 
					   </div>
						<div class="col-md-1">					
					    <div class="field-group">
							Boxes
								 <br>
								<input id="no_of_boxes'.$no1.'" type="text" name="no_of_boxes[]" class="form-control" onkeypress="return isNumber(event)" placeholder="No Of Boxes" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->no_of_boxes.'" />
								
								<input id="sqm_per_box'.$no1.'" type="hidden" name="sqm_per_box[]"   value="'.$sample_trn[$no1]->sqm_per_box.'"/>
								<input id="weight_per_box'.$no1.'" type="hidden" name="weight_per_box[]"  value="'.$sample_trn[$no1]->weight_per_box.'" />
								 
							 	<input id="container_name'.$no1.'" type="hidden" name="container_name[]"  value="'.$sample_trn[$no1]->container_name.'" />
								
					 	</div> 
					   </div>
					   <div class="col-md-1">
					   <div class="field-group">
					   SQM
								 <br>
								<input id="sample_sqm'.$no1.'" type="text" name="sample_sqm[]" class="form-control" onkeypress="return isNumber(event)"   placeholder="SQM" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->sqm.'" />
							</div>
						</div>
					 
					   <div class="col-md-1">					
					    <div class="field-group">
						Net Weight
								 <br>
								<input id="netweight'.$no1.'" type="text" name="netweight[]" class="form-control" onkeypress="return isNumber(event)" placeholder="Net Weight" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->netweight.'" />
								 
					 	</div> 
					   </div>
					   <div class="col-md-1">					
					    <div class="field-group">
						GrossWeight  
								 <br>
								<input id="grossweight'.$no1.'" type="text" name="grossweight[]" class="form-control" onkeypress="return isNumber(event)" placeholder="Gross Weight" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->grossweight.'" />
								 
					 	</div> 
					   </div>
						 <div class="col-md-1">						   
							<div class="field-group">
							Rate  
								 <br>
								<input id="sampleproductrate'.$no1.'" type="text" name="sampleproductrate[]" class="form-control"     placeholder="Rate" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->sample_rate.'" />
							</div> 
						 </div>
						  <div class="col-md-1">						   
							<div class="field-group">
							Unit  
								 <br>
								<input id="sampleproductunit'.$no1.'" type="text" name="sampleproductunit[]" class="form-control"     placeholder="Rate" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->sample_per.'" />
							</div> 
						 </div>
						<div class="col-md-1">						   
							<div class="field-group">
							Amount  
								 <br>
								<input id="sampleproductamount'.$no1.'" type="text" name="sampleproductamount[]" class="form-control"     placeholder="Sample Amount" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->sample_amout.'" />
							</div> 
						 </div>	';
						if($no1 == 0)
						{
							$str .='<div class="col-md-1">						   
								<div class="field-group">
									<a class="btn btn-primary tooltips" data-title="Add More Sample" onclick="add_inner_sample_product('.$n.','.$no1.',0)" href="javascript:;" data-original-title="" title=""><i class="fa fa-plus"></i></a>
								</div> 
							</div>	';
						}
						else
						{
							$str .='<div class="col-md-1">						   
								<div class="field-group">
									<a class="btn btn-warning tooltips" data-title="Remove Sample" onclick="remove_inner_sample_product('.$no1.$no.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-minus"></i></a>
								</div> 
							</div>	';
						 
						}
				$str .='
				</div>';
						 
			 }
			$str .='  </div>';
				$str .='   <div class="col-md-12">	<hr /></div>	';
				  
		 
		$row= array();
		$row['str'] = $str;
		
		$row['container_name'] = $container_name;
		$row['pallent_check'] = $pallent_check;
		$row['no_of_sample'] = $no_of_sample;
		echo json_encode($row);
	}
	public function delete_sampleentry()
	{
		$exportproduct_trn_id 	= $this->input->post('exportproduct_trn_id');
		$export_invoice_id	  	= $this->input->post('export_invoice_id');
		 
		$samplerecord = $this->export->deletesampleproductdata($exportproduct_trn_id,$export_invoice_id,1,$exportproduct_trn_id);
		 echo "1";
	}
	public function deletesampleentry()
	{
		$exportproduct_trn_id 	= $this->input->post('exportproduct_trn_id');
		$export_invoice_id	  	= $this->input->post('export_invoice_id');
		 
		$samplerecord = $this->export->deletesampleproductdata($exportproduct_trn_id,$export_invoice_id,2,$exportproduct_trn_id);
		 echo "1";
	}
	public function copy_containter()
	{
		$producttrn_id 			= implode(",",$this->input->post('producttrn_id'));
		$performa_invoice_id	= $this->input->post('performa_invoice_id');
		$export_invoice_id 		= $this->input->post('export_invoice_id');
		$copyid = $this->export->copycontainter($producttrn_id,$export_invoice_id,$performa_invoice_id);
		echo "1";
	}
	public function getepcg_detail()
	{
		$supplier_id = $this->input->post('supplier_id');
		$epcgdata	= $this->export->get_epcg_data($supplier_id);
		echo "<option value=''>Select EPCG Detail</option>";
		echo "<option value='0'>Add New EPCG Detail</option>";
		foreach($epcgdata as $data)
		{
			echo "<option value='".$data->supplie_epcg_id."'>".$data->epcg_no." & Dated : ".date('d.m.Y',strtotime($data->epcg_date))."</option>";
		}
	}
}
