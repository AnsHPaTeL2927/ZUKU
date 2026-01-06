<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Poproduct extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_purchase_order_product','po');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			  $company			= $this->po->company_select();
			  $data				= $this->po->po_data($id);
			 $datap			= $this->po->getpo_productdata($id,$data->production_mst_id,$data->container_details,$data->mutiple_status,$data->seller_id);
			$this->load->model('admin_company_detail');	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			 
			$v = array(
				'invoicedata'		=> $data,
				'product_data'		=> $datap,
				'menu_data'			=> $menu_data,
				'company_detail'	=> $this->admin_company_detail->s_select(),
				'allproduct'		=> $this->po->allproductsize()
			);
		$this->load->view('admin/po_product',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	public function manage()
	{
		$description_goodsarray = $this->po->hsncproductsizedetail($this->input->post('product_details'),2);
		$thickness 				= !empty($description_goodsarray[0]->thickness)?' - '.$description_goodsarray[0]->thickness.' MM':"";
		$description 			= $description_goodsarray[0]->size_type_mm.' ('.$description_goodsarray[0]->series_name.')';
		$rate_in_rs 			= $this->input->post('Rate_in_rs');
		  
		$data = array(
			'purchase_order_id'		=> $this->input->post('purchaseorder_id'),
			'product_id' 			=> $this->input->post('product_details'),
			'product_size_id' 	 	=> $this->input->post('product_size_id'),
			'product_container' 	=> (!empty($this->input->post('container_check'))?$this->input->post('total_container'):0),
			'description_goods' 	=> $description,
		 	'pallet_status' 		=> $this->input->post('pallet_status'),
			'weight_per_box' 	 	=> $this->input->post('weight_per_box'),
			'pallet_weight' 	 	=> $this->input->post('pallet_weight'),
			'big_pallet_weight' 	=> $this->input->post('big_pallet_weight'),
			'small_pallet_weight' 	=> $this->input->post('small_pallet_weight'),
			'boxes_per_pallet' 		=> $this->input->post('boxes_per_pallet'),	 
			'box_per_big_pallet' 	=> $this->input->post('box_per_big_pallet'),
			'box_per_small_pallet' 	=> $this->input->post('box_per_small_pallet'),
			'feet_per_box' 			=> $this->input->post('feet_per_box'),
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
	 
		 $id = $this->input->post('purchaseordertrn_id');
		 
		if(empty($id))
		{
			$insertid = $this->po->insert_productrecord($data);
			$no=0;
				foreach($this->input->post('design_id') as $design)
				{
					$packing_data = array(
						"purchaseordertrn_id"	 => $insertid,
						"purchase_order_id"	 	 => $this->input->post('purchaseorder_id'),
						"design_id" 			 => $design,
						"finish_id" 			 => $this->input->post('finish_id')[$no],
						"product_rate" 			 => $this->input->post('product_rate')[$no],
						"no_of_pallet" 			 => $this->input->post('no_of_pallet')[$no],
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet')[$no],
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet')[$no],
						"no_of_boxes" 			 => $this->input->post('no_of_boxes')[$no],
						"no_of_sqm" 			 => $this->input->post('no_of_sqm')[$no],
						"per" 					 => $this->input->post('price_type')[$no],
						"product_amt" 			 => $this->input->post('product_amt')[$no],
						"packing_net_weight"	 => $this->input->post('packing_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')[$no] 
						);
						$insertrecord = $this->po->insert_packing_data($packing_data);
					$no++;
				}
			if($insertid)
			{	
				$row['res'] = "1";
			}
			else{
				$row['res'] = "0";
			}
		}
		else
		{
			$update_id = $this->po->update_productrecord($data,$id);
			$deletedataid = $this->po->delete_packing_data($id);
			$no=0;
				foreach($this->input->post('design_id') as $design)
				{
					$packing_data = array(
						"purchaseordertrn_id"	 => $id,
						"purchase_order_id"	 	 => $this->input->post('purchaseorder_id'),
						"design_id" 			 => $design,
						"finish_id" 			 => $this->input->post('finish_id')[$no],
						"product_rate" 			 => $this->input->post('product_rate')[$no],
						"no_of_pallet" 			 => $this->input->post('no_of_pallet')[$no],
						"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet')[$no],
						"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet')[$no],
						"no_of_boxes" 			 => $this->input->post('no_of_boxes')[$no],
						"no_of_sqm" 			 => $this->input->post('no_of_sqm')[$no],
						"per" 					 => $this->input->post('price_type')[$no],
						"product_amt" 			 => $this->input->post('product_amt')[$no],
						"packing_net_weight"	 => $this->input->post('packing_net_weight')[$no],
						"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')[$no] 
						);
						$insertrecord = $this->po->insert_packing_data($packing_data);
					$no++;
				}
			if($update_id)
			{	
				$row['res'] = "2";
			}
			else{
				$row['res'] = "2";
			}
		}
		echo json_encode($row);

	}
	public function update_po()
	{
		$po_data = array(
			'sgst_value'		=> $this->input->post('sgst_value'),
			'cgst_value'		=> $this->input->post('cgst_value'),
			'igst'				=> $this->input->post('igst'),
			'sgst'				=> $this->input->post('sgst'),
			'cgst'				=> $this->input->post('cgst'),
			'roundoff'			=> $this->input->post('roundoff'),
			'grand_total'		=> $this->input->post('grand_total')
			);
			$po_data['step'] 	= $this->input->post('step');
			$po_data_update_id = $this->po->update_po($po_data,$this->input->post('purchase_order_id'));
		$no=0;$previous_id=0;
	 	$total_amt = 0;
	 	foreach(explode(",",implode(",",$this->input->post('product_rate_rs'))) as $row)
		{
			 $popacking_id = $this->input->post('popacking_id')[$no];
			  
				$updatedata = array(
					"product_rate"  => $row,
					"product_amt" 	=> $this->input->post('product_amount')[$no],
				 	"per" 			=> $this->input->post('price_type')[$no]
				);
				$update_id = $this->po->update_po_packing($updatedata,$popacking_id);
			 	if($this->input->post('purchaseordertrn_id')[$no] == $previous_id)
				{
					$total_amt += $this->input->post('product_amount')[$no];
				
					 $update_trn_data = array(
							"total_product_amt"  => $total_amt,
							"feet_per_box" 	=> $this->input->post('feet_per_box')[$no]
					 	);
						$update_id = $this->po->update_productrecord($update_trn_data,$this->input->post('purchaseordertrn_id')[$no]);
					 
				}
				else if($this->input->post('purchaseordertrn_id') != $previous_id)
				{
					$total_amt = 0;
					$total_amt = $this->input->post('product_amount')[$no];
					$update_trn_data = array(
							"total_product_amt"  => $total_amt,
							"feet_per_box" 	=> $this->input->post('feet_per_box')[$no] 
					 	);
						$update_id = $this->po->update_productrecord($update_trn_data,$this->input->post('purchaseordertrn_id')[$no]);
				}
				$previous_id = $this->input->post('purchaseordertrn_id')[$no];
				$no++;
		}
		 
		 
		
		echo 1; 
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->po->delete_product($id);	
		$deletepackingrecord = $this->po->delete_product_packing($id);	
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
		$purchaseordertrn_id = $this->input->post('purchaseordertrn_id');
		$fetchresult = $this->po->fetchrecord($purchaseordertrn_id);
		echo json_encode($fetchresult);
	}

	public function allproductsave($id){

		$rdata = $this->pinv->product_data_save($id);
		
			if($rdata)
			{	
				redirect(base_url('packing/index/'.$id));
			}
	}
	
	public function selecthsncproduct()
	{
		$hsncval=$this->input->post('hsncval');
		$resultdata=array();
		$data=$this->pinv->hsncproductsize($hsncval);
		
		foreach($data as $row)
		{
			$resultdata[]=array($row->size_details,$row->id);	
		}
		 echo json_encode($resultdata);
	}
	public function updateinvoice()
	{
		$invoiceid=$this->input->post('invoice_id');
		$remarks=$this->input->post('remarks');
	 	$step=1;
		$temp_status=0;
		$updatestepinvoice = $this->po->postepupdate($invoiceid,$step,$temp_status,$remarks);
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
			$update_id = $this->po->update_productrecord($updatedata,$row);
			 $mix_gross_weight += $grossweight[$no];
			 $mix_net_weight   += $netweight[$no];
			 $first++;  
			 $no++;
		}
		 $data = array(
			'allproduct_id'			=> implode(",",$this->input->post('allvalues')),
			'mix_gross_weight'		=> $mix_gross_weight,
			'mix_net_weight'		=> $mix_net_weight,
			'purchase_order_id'		=> $this->input->post('purchase_order_id'),
			'container_count'		=> 1,
			'container_order_by' 	=> $this->input->post('cnt'),
			'status'=> 0 
			); 
			$insertid = $this->po->insert_makecontainer($data);
			echo  "1";
			 
	}
	public function make_container_delete()
	{
	 
		$id = $this->input->post('id');
		$invoice_id = $this->input->post('invoice_id');
		$deleterecord = $this->po->make_containerdelete($id);	
		$data = array(
			"container_order_by" => 0
		);
		$updaterecord = $this->po->updateinvoicecontainer($data,$id,$invoice_id);	
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
			 
	}
	public function load_design_data()
	{
		$id = $this->input->post('id');
		$total_container = 1;
	 	$mode = $this->input->post('mode');
			if(strtolower($mode)=="add")
			 {
				 	$data = $this->po->hsncproductsizedetail($id,2);
					$result=$data[0];
				 	$hsnc_code	= $data[0]->hsnc_code;
					$hsncdata 	= $this->po->hsncproductcodedetail($hsnc_code);
					$hsnc 	  	= $hsncdata[0]->p_name;
					$hsncsize 	= $hsncdata[0]->size_type;
					$size_name	= $result->size_type_mm;
					$series_name= $result->series_name;
					$thickness  = (!empty($result->thickness))?' - '.$result->thickness.' MM':"";
					$description_goods = $size_name.' ('.$series_name.')';
					$packing_detail = $this->po->get_packing_detail($id);
					 $deletestatus = 0;
			  }
			 else if(strtolower($mode)=="edit")
			 {
				 $purchaseordertrn_id = $this->input->post('purchaseordertrn_id');
				 $product_id = $this->input->post('id');
				 $deletestatus = $this->input->post('deletestatus');
				 $fetchproductresult = $this->po->fetchproductrecord($purchaseordertrn_id);
				 $packing_detail = $this->po->get_packing_detail($id);
				 $description_goods = $fetchproductresult->description_goods;
				 
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
						 			$str .='<option '.$sel.' value="'.$packing_row->product_size_id.'">'.$packing_row->product_packing_name.'</option>';
						 		}
					 	$str .='</select>
						</div>    
				    </div>
					<div class="packing_detail"></div> ';
		
		echo $str;
	}
	
	public function load_packing()
	{
		$product_size_id = $this->input->post('product_size_id');
		$total_container = 1;
	 	$mode = $this->input->post('mode');
		if(strtolower($mode)=="add")
		{
				    $data 			= $this->po->fetch_packing_detail($product_size_id);
				    $data_product 	= $this->po->hsncproductsizedetail($data->product_id,2);
				    $fetchresult 	= $this->po->fetchdesign_detail($data->product_id);
					$result	  		= $data;
					$checked1 		= "";
					$checked2 		= "";
					$checked3 		= "";
					if($result->boxes_per_pallet>0)
					{
						$checked1 				 = "checked";
						$pallet_weight 			 = $result->pallet_weight;
						$boxes_per_pallet 		 = $result->boxes_per_pallet;
						$no_of_pallet 			 = $result->total_pallent_container;
						$no_of_pallet1 			 = $result->total_pallent_container;
						$sqm_per_container 		 =  $result->sqm_per_container;
						$defualt_netweight 		 = $fetchproductresult->pallet_net_weight_per_container;
						$defualt_grossweight 	 = $result->pallet_gross_weight_per_container;
						$total_box_per_container = $result->box_per_container;
					}
					else if($result->total_boxes>0)
					{
						$checked2 				 = "checked";
						$total_boxes 			 = $result->total_boxes;
						$sqm_per_container 		 =  $result->withoutpallet_sqm_per_container;
						$defualt_netweight 		 = $fetchproductresult->withoutnet_weight_per_container;
						$defualt_grossweight 	 = $result->withoutgross_weight_per_container;
						$total_box_per_container = $result->total_boxes;
					}
					else if($result->box_per_big_plt>0)
					{
						$checked3 = "checked";
						$big_pallet_weight 		 = $result->big_plat_weight;
						$small_pallet_weight 	 = $result->small_plat_weight;
						$box_per_big_pallet 	 = $result->box_per_big_plt;
						$box_per_small_pallet 	 = $result->box_per_small_plt_new;
						$no_of_big_pallet 		 = $result->no_big_plt_container_new;
					 	$no_of_small_pallet		 = $result->no_small_plt_container_new;
						 $sqm_per_container 	 =  $result->multi_sqm_per_container;
						$total_box_per_container = $result->multi_box_per_container;
					}
				 
					$weight_per_box 	= $result->weight_per_box;
				 	$sqm_per_box 		= $result->sqm_per_box;
				 	$feet_per_box 		= $result->feet_per_box;
					$pcs_per_box 		= $result->pcs_per_box;
				 	$price				= $result->defualt_rate;
					$Total_Amount_usd	= $price * $result->sqm_per_container;
					$usdprice 			= number_format((float)$price, 2, '.', '');
					$Total_Amount_euro	= $price*$result->sqm_per_container;
					$europrice 			= number_format((float)$price, 2, '.', '');
					$totalprice 		= ($currency == "USD")? number_format((float)$Total_Amount_usd, 2, '.', '') : number_format((float)$Total_Amount_euro, 2, '.', '');
					$default_total 		= ($currency == "USD")? number_format((float)$Total_Amount_usd, 2, '.', '') : number_format((float)$Total_Amount_euro, 2, '.', '');
					$total_container 	= 1;
					$container_checked 	= 'checked';
					$displaynone 		= '';
					$series_id 			= $result->series_id;
					$model_type_id 		= $result->model_type_id;
					$defualt_status 	= 1;
		}
		else if(strtolower($mode)=="edit")
		{
				 $purchaseordertrn_id 		= $this->input->post('purchaseordertrn_id');
				 $product_size_id 			= $this->input->post('product_size_id');
				 $deletestatus 				= $this->input->post('deletestatus');
				 
				 $fetchproductresult 		= $this->po->fetchproductrecord($purchaseordertrn_id);
				 $checked1 					= ($fetchproductresult->pallet_status==1)?"checked":"";
				 $checked2		 			= ($fetchproductresult->pallet_status==2)?"checked":"";
				 $checked3					= ($fetchproductresult->pallet_status==3)?"checked":"";
				 $container_checked 		= ($fetchproductresult->product_container>0)?'checked':'';
				 $displaynone 				= ($fetchproductresult->product_container==0)?'display:none':'';
			 	 $total_container 			= $fetchproductresult->product_container;
				 $weight_per_box 			= $fetchproductresult->weight_per_box;
				 $pallet_weight 			= $fetchproductresult->pallet_weight;
				 $boxes_per_pallet 			= $fetchproductresult->boxes_per_pallet;
				 $big_pallet_weight 		= $fetchproductresult->big_pallet_weight;
				 $small_pallet_weight 		= $fetchproductresult->small_pallet_weight;
				 $box_per_big_pallet 		= $fetchproductresult->box_per_big_pallet;
				 $box_per_small_pallet 		= $fetchproductresult->box_per_small_pallet;
				 $sqm_per_box 				= $fetchproductresult->sqm_per_box;
				 $pcs_per_box 				= $fetchproductresult->pcs_per_box;
				 $hsnc_code 				= $fetchproductresult->hsnc_code;
				 $feet_per_box 				= $fetchproductresult->feet_per_box;
				
			 }
			 
					$str .= '<div class="col-md-6">
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
							 <div class="col-md-12">	 </div>
					<div class="col-md-2">					
				      <div class="field-group">
				    	<lable>Weight Per Box </lable>
				         <input type="text" id="weight_per_box" name="weight_per_box" placeholder="Weight Per Box" class="form-control"  value="'.$weight_per_box.'" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()"  onblur="cal_product_invoice()" /> 
						
				    </div>                     
				    </div> 
					
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Big Pallet Weight</lable>
							<input type="text" id="big_pallet_weight" name="big_pallet_weight" placeholder="Big Pallet Weight" required="" class="form-control" value="'.$big_pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)"   onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
				    </div>                     
				    </div>
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Small Pallet Weight</lable>
							<input type="text" id="small_pallet_weight" name="small_pallet_weight" placeholder="Small Pallet Weight" required="" class="form-control" value="'.$small_pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()"   onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>
				    </div>                     
				    </div>
					<div class="col-md-2 pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Pallet</lable>
								<input type="text" id="boxes_per_pallet" name="boxes_per_pallet" placeholder="Boxes Per Pallet" required="" class="form-control" required="" value="'.$boxes_per_pallet.'" title="Enter Boxes Per Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()"  onblur="cal_product_invoice()"/>
					 	  </div>                     
				    </div>
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Big Pallet</lable>
								<input type="text" id="box_per_big_pallet" name="box_per_big_pallet" placeholder="Boxes Per Big Pallet" required="" class="form-control" required="" value="'.$box_per_big_pallet.'" title="Enter Boxes Per Big Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)"   onblur="cal_product_invoice()"/>
						   </div>                     
				    </div>
					<div class="col-md-2 multi_pallet_calcution">					
				     <div class="field-group">
				    	<lable>Boxes Per Small Pallet</lable>
								<input type="text" id="box_per_small_pallet" name="box_per_small_pallet" placeholder="Boxes Per Big Pallet" required="" class="form-control" required="" value="'.$box_per_small_pallet.'" title="Enter Boxes Per Small Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()" onblur="cal_product_invoice()"/>
									 
						  </div>                     
				    </div>
					<div class="col-md-2">				
					 <div class="field-group">
				    	<lable>Sqm Per box</lable>
								<input type="text" id="sqm_per_box" name="sqm_per_box" placeholder="Sqm Per box" required="" class="form-control" required="" value="'.$sqm_per_box.'" readonly/>
								<input type="hidden" id="pcs_per_box" name="pcs_per_box" value="'.$pcs_per_box.'" readonly/>
									 
						  </div>                     
				    </div>
					<div class="col-md-2">				
					 <div class="field-group">
				    	<lable>Feet Per box</lable>
								<input type="text" id="feet_per_box" name="feet_per_box" placeholder="Feet Per box" required="" class="form-control" required="" value="'.$feet_per_box.'"  onkeyup="cal_product_invoice()" onblur="cal_product_invoice()"/>
								 	 
						  </div>                     
				    </div>
					<div class="col-md-2 pallet_calcution">					
				     <div class="field-group">
				    	<lable>Empty Pallet Weight</lable>
							<input id="pallet_weight" type="text" name="pallet_weight" placeholder="Pallet Weight" required="" class="form-control" value="'.$pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)"  onkeyup="cal_product_invoice()"  onblur="cal_product_invoice()"/>
				    </div>                     
				    </div>  
					<div class="col-md-12">
						<table class="table table-bordered table-hover rate_table" id="">
							<tr>
								<td width="15%">Design</td>
								<td width="15%">Finish</td>
								<td width="10%">Rate </td>
								<td width="15%"> Per</td>
								<td width="10%" class="pallet_calcution multi_pallet_calcution">NO OF PALLET </td>
								<td width="10%">BOXES</td>
								<td width="10%">SQM</td>
								<td width="10%">Amount</td>
								<td width="5%">Add</td>
							</tr>'; 
					if(strtolower($mode)=="edit")
					{
						$getpacking_detail = $this->po->get_packing($purchaseordertrn_id);
						$no = 1;
						$str .= '<input type="hidden" id="row_cont" name="row_cont"  value="'.count($getpacking_detail).'"/>';
						foreach($getpacking_detail as $row)
						{
							$design_data = $this->po->fetchdesign_detail($fetchproductresult->product_id);
							$fetch_designrate = $this->po->getdesignrate($row->seller_id,$fetchproductresult->product_id,$row->design_id,$row->finish_id);
							$per = !empty($row->per)?$row->per:$fetch_designrate->product_rate_per;
							$product_rate = !empty($row->product_rate)?$row->product_rate:$fetch_designrate->design_rate;
						$str .= '<tr class="appendtr'.$no.'">
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
												$str .= '<option '.$sel.'  value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
											}
											$str .= '</select>
										</td>
										<td class="">
											<select class="select2" id="finish_id'.$no.'" name="finish_id[]" class="select2" >';
											$fetchresult = $this->po->fetchfinish_detail($row->design_id);
													foreach($fetchresult as $finish_row)
													{
														$sel = '';
														if($finish_row->finish_id == $row->finish_id)
														{
															$sel = 'selected="selected"';
														}
														$str .= '<option '.$sel.' value="'.$finish_row->finish_id.'">'.$finish_row->finish_name.'</option>';
													}		
											$str .= '</select>
										</td>
										 
										<td class="">
											<input type="text" name="product_rate[]" id="product_rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"  onblur="cal_product_trn('.$no.')"  value="'.$product_rate.'" />
										</td>
										<td class="">
											 <select class="form-control" name="price_type[]" id="price_type'.$no.'" onchange="cal_product_trn('.$no.')" required title="Select Price Per">
												 <option value="">Select Price per</option>';
										$feet_sel = ($per == "SQF")?'selected="selected"':'';
										$box_sel  = ($per == "BOX")?'selected="selected"':'';
										$SQM_sel  = ($per == "SQM")?'selected="selected"':'';
										$PCS_sel  = ($per == "PCS")?'selected="selected"':'';
										$str .= '<option '.$feet_sel.' value="SQF">SQF</option>
												 <option '.$box_sel.' value="BOX">BOX</option>
												 <option '.$SQM_sel.' value="SQM">SQM</option>
												 <option '.$PCS_sel.' value="PCS">PCS</option>
											 </select>
										</td>
										<td class="pallet_calcution multi_pallet_calcution">
											<input type="text" name="no_of_pallet[]" id="no_of_pallet'.$no.'" class="form-control pallet_calcution" value="'.$row->no_of_pallet.'" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"  onblur="cal_product_trn('.$no.')"/>
											<span class="multi_pallet_calcution"> 
												Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onkeyup="cal_product_trn('.$no.')" value="'.$row->no_of_big_pallet.'" placeholder ="Big Pallet"/>
												Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$no.'" class="form-control "  onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onkeyup="cal_product_trn('.$no.')" value="'.$row->no_of_small_pallet.'"  placeholder ="Small Pallet"/>
											</span>
										</td>
										<td class="">
											<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$no.'" class="form-control without_pallet_box" readonly value="'.$row->no_of_boxes.'"  onblur="cal_product_trn('.$no.')"   onkeyup="cal_product_trn('.$no.')" />
										</td>
										<td class="">
											<input type="text" name="no_of_sqm[]" id="no_of_sqm'.$no.'" class="form-control" readonly  value="'.$row->no_of_sqm.'"/>
										</td>
										<td class="">
											<input type="text" name="product_amt[]" id="product_amt'.$no.'" class="form-control" readonly value="'.$row->product_amt.'"/>
											<input type="hidden" name="packing_net_weight[]" id="packing_net_weight'.$no.'" value="'.$row->packing_net_weight.'" />
											<input type="hidden" name="packing_gross_weight[]" id="packing_gross_weight'.$no.'" value="'.$row->packing_gross_weight.'" />
										</td>';
									 
											$str .= '<td class="">
													<button type="button" onclick="remove_row('.$no.')"  class="btn btn-danger">-</button>
											</td>';
										 
									$str .='</tr>';
							$no++;
						}
				 	}
					else
					{
						$str .= '<input type="hidden" id="row_cont" name="row_cont"  value="1"/>
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
											<select class="select2" id="finish_id1" name="finish_id[]" class="select2" >
											</select>
										</td>
										 
										<td class="">
											<input type="text" name="product_rate[]" id="product_rate1" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_product_trn(1)"  onblur="cal_product_trn(1)" />
										</td>
										<td class="">
											 <select class="form-control" name="price_type[]" id="price_type1" onchange="cal_product_trn(1)" required title="Select Price Per">
												 <option value="">Select Price per</option>
												 <option value="SQF">SQF</option>
												 <option value="Box">Box</option>
												 <option value="SQM">SQM</option>
												 <option value="PCS">PCS</option>
											 </select>
										</td>
										<td class="pallet_calcution multi_pallet_calcution">
											<input type="text" name="no_of_pallet[]" id="no_of_pallet1" class="form-control pallet_calcution" value="'.$no_of_pallet.'" onkeypress="return isNumber(event)" onkeyup="cal_product_trn(1)"  onblur="cal_product_trn(1)"/>
											<span class="multi_pallet_calcution"> 
												Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet1" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn(1)"   onkeyup="cal_product_trn(1)" value="'.$no_of_big_pallet.'" placeholder ="Big Pallet"/>
												Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet1" class="form-control "  onkeypress="return isNumber(event)" onblur="cal_product_trn(1)"   onkeyup="cal_product_trn(1)" value="'.$no_of_small_pallet.'"  placeholder ="Small Pallet"/>
											</span>
										</td>
										<td class="">
											<input type="text" name="no_of_boxes[]" id="no_of_boxes1" class="form-control without_pallet_box" readonly value="'.$total_box_per_container.'" onblur="cal_product_trn(1)"   onkeyup="cal_product_trn(1)" />
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
									<td colspan="4" style="text-align:right">
										Total
									</td>
									<td class="">
										<input type="text" readonly name="total_no_of_pallet" id="total_no_of_pallet" class="form-control" />
									</td>
									<td class="pallet_calcution multi_pallet_calcution">
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
				  </div>';
		  echo $str;
	}
	public function add_design_row()
	{
		$design_id 		=  $this->input->post('design_id');
		$finish_id 		=  $this->input->post('finish_id');
		$product_id		=  $this->input->post('product_id');
		$no 	   		=  ($this->input->post('no') + 1);
		$fetchresult 	= $this->po->fetchdesign_detail($product_id);
		$str .='<tr class="appendtr'.$no.'">
					<td>
						<select class="select2" id="design_id'.$no.'" name="design_id[]" class="select2" onchange="load_finish(this.value,'.$no.')">';
						$str .= '<option value="">Select Design Name</option> ';
									foreach($fetchresult as $design_row)
									{
										$str .= '<option value="'.$design_row->packing_model_id.'">'.$design_row->model_name.'</option>';
									}
				$str .= '</select>
						</td>
						<td class="">
							<select class="select2" id="finish_id'.$no.'" name="finish_id[]" class="select2" > 
							</select>
						</td>
					 	<td class="">
							<input type="text" name="product_rate[]" id="product_rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"  onblur="cal_product_trn('.$no.')" />
						</td>
						<td class="">
							 <select class="form-control" name="price_type[]" id="price_type'.$no.'" onchange="cal_product_trn('.$no.')" required title="Select Price Per">
								 <option value="">Select Price per</option>
								 <option value="SQF">SQF</option>
								 <option value="BOX">BOX</option>
								 <option value="SQM">SQM</option>
								  <option value="PCS">PCS</option>
							 </select>
						</td>
						<td class="pallet_calcution multi_pallet_calcution">
							<input type="text" name="no_of_pallet[]" id="no_of_pallet'.$no.'" class="form-control pallet_calcution" value="" onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"  onblur="cal_product_trn('.$no.')" />
							<span class="multi_pallet_calcution"> 
								Big : <input type="text" name="no_of_big_pallet[]" id="no_of_big_pallet'.$no.'" class="form-control"  onkeypress="return isNumber(event)" onblur="cal_product_trn('.$no.')"   onkeyup="cal_product_trn('.$no.')"  placeholder ="Big Pallet"/>
								Small : <input type="text" name="no_of_small_pallet[]" id="no_of_small_pallet'.$no.'" class="form-control "  onkeypress="return isNumber(event)" onkeyup="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')"  placeholder ="Small Pallet"/>
							</span>
						</td>
						<td class="">
							<input type="text" name="no_of_boxes[]" id="no_of_boxes'.$no.'" class="form-control without_pallet_box" readonly value=""   onkeyup="cal_product_trn('.$no.')"   onblur="cal_product_trn('.$no.')" />
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
	public function designrate()
	{
		$seller_id		  	= $this->input->post('seller_id');
		$product_id		  	= $this->input->post('product_id');
		$packing_model_id 	= $this->input->post('packing_model_id');
		$finish_id 		  	= $this->input->post('finish_id');
		$fetchresult 		= $this->po->getdesignrate($seller_id,$product_id,$packing_model_id,$finish_id);
		 
		$row =array();
		if(!empty($fetchresult))
		{
			$row['rate_data'] = $fetchresult;
		}
		else
		{
			
			$row['rate_data'] = '';
	 	}
		 
		echo json_encode($row); 
	}
	public function copy_containter()
	{
		$producttrn_id = implode(",",$this->input->post('producttrn_id'));
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		$purchase_order_id = $this->input->post('purchase_order_id');
		$copyid = $this->po->copycontainter($producttrn_id,$purchase_order_id,$performa_invoice_id);
		echo "1";
	}
}
