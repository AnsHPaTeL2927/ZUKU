<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Cutomerinvoiceproduct extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_exportinvoice_product');
		$this->load->model('Customer_invoice_model','cinvoice');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}
	public function index($id)
	{
	 	if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$data = $this->cinvoice->get_invoice_data($id);
			$this->load->model('admin_company_detail');
			$array 				= explode("-",$data->export_invoice_id);
		 	$loading_trn 		= $this->admin_exportinvoice_product->getinvoice_cust_data($array,0,$data->consiger_id);
			 
			$userdata			= $this->cinvoice->ciadmin_login();	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			$sample_data		= $this->admin_exportinvoice_product->getinvoicesampleproductdata(implode(",",$array),0);
							
			$v = array(
				'invoicedata'		=> $data,
				'direct_invoice' 	=> $data->direct_invoice,  
				'menu_data'			=> $menu_data,
				'company_detail'	=> $this->admin_company_detail->s_select(),
				'userdata'			=> $userdata,
				'sample_data'		=> $sample_data,
				'loading_trn'		=> $loading_trn 
			);
				$this->load->view('admin/customerproductinvoice',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	public function addproduct()
	{
		 $data = array(
			'size_type_mm'=> $this->input->post('size_type_mm'),
			'description' => $this->input->post('description'),
			'hsnc_code' => $this->input->post('hsnc_code'),
			'qty_sqm' => $this->input->post('qty_sqm'),
			'qty_boxes' => $this->input->post('qty_boxes'),
			'batch_no' =>  $this->input->post('batch_no'),
			'unit' => $this->input->post('unit'),
			'rate' => $this->input->post('rate'),
			'amount' => $this->input->post('amount'), 
			'exportproduct_trn_id' => $this->input->post('exportproduct_trn_id'), 
			'customer_invoice_id' => $this->input->post('customer_invoice_id'), 
			'status' =>'0'
			);
		$id = $this->input->post('customer_invoice_trn_id');
		if(empty($id))
		{
			$rdata = $this->cinvoice->insert_productrecord($data);
			$no=0;
		 	if($rdata)
			{	
				$row['res'] = "1";
				$row['exportproduct_trn_id'] = $rdata;
		 	}
		}
		else
		{
			$rdata = $this->cinvoice->update_productrecord($data,$id);
			  	 
					
				if($rdata)
				{	
					$row['res'] = "2";
					$row['exportproduct_trn_id'] = $id;
					 
				}
		}
		echo json_encode($row);

	}
	public function update_customer_invoice()
	{
		$export_loading_trn_id = $this->input->post('export_loading_trn_id');
		$no	= 0;
		foreach($export_loading_trn_id as $row)
		{
			$exportdata = array(
				'custhsnccode' 		 	=> $this->input->post('hsnc_code')[$no],
				'custdescriptiongoods'	=> $this->input->post('cust_description_goods')[$no],
				'custproductrate' 	 	=> $this->input->post('cust_product_rate')[$no],
				'custproductamt' 		=> $this->input->post('cust_product_amt')[$no],
		   	);
		 
			$export_data_update_id = $this->cinvoice->update_customer_invoice_data($exportdata,$row);
			$no++;
		}
		
		$export_data = array(
			'certification_charge'	=> $this->input->post('certification_charge'),
			'insurance_charge'		=> $this->input->post('insurance_charge'),
			'seafright_charge'		=> $this->input->post('seafright_charge'),
			'discount'				=> $this->input->post('discount'),
			'rex_detail_status'		=> $this->input->post('rex_detail_status'),
			'rex_no'				=> $this->input->post('rex_no'),
			'extra_calc_name'		=> $this->input->post('extra_calc_name'),
			'extra_calc_amt'		=> $this->input->post('extra_calc_amt'),
			'extra_calc_opt'		=> $this->input->post('extra_calc_opt'),
			'rex_no_detail'			=> $this->input->post('rex_no_detail'),
			'before_grand_total'			=> $this->input->post('before_grand_total'),						'grand_total'			=> $this->input->post('grand_total'),
			'remarks'				=>$this->input->post('remarks'),
			);
			$export_data['step'] = ($this->input->post('step')==4)?$this->input->post('step'):2;
			
			$export_data_update_id = $this->cinvoice->updatecustomer($export_data,$this->input->post('customer_invoice_id'));
		echo 1;
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->export->delete_product($id);	
		$deletesamplerecord = $this->export->delete_sample_product($id);	
		 
			if($deleterecord)
			{
				$row['res'] = '1';
			}
			else{
				$row['res'] = '0';
			}
			echo json_encode($row);
	}
	public function delete_from_commercial()
	{
		$export_sampletrn_id = $this->input->post('export_sampletrn_id');
		$commercial_status = $this->input->post('commercial_status');
		$deleterecord = $this->cinvoice->delete_from_commercial($export_sampletrn_id,$commercial_status);	
		 
		 
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
		//$remarks=$this->input->post('remarks');
	 	$step=1;
		$temp_status=0;
		$updatestepinvoice = $this->export->export_invoice_stepupdate($invoiceid,$step,$temp_status);
	}
	public function make_container_fun()
	{
		$first=1;
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
			 
			$update_id = $this->export->updateproductrecord($updatedata,$row);
		$first++; 
		}
		 $data = array(
			'allproduct_id'=> implode(",",$this->input->post('allvalues')),
			'exportinvoice_id'=> $this->input->post('export_invoice_id'),
			'container_count'=> 1,
			'container_order_by' => $this->input->post('cnt'),
			'status'=> 0 
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
							<select name="model_serice[]" id="model_serice" class="" multiple   title="Select Group" placeholder="Select Rate Group" onchange="set_model_rate(&quot;'.$currency.'&quot;,&quot;'.$sqm_per_box.'&quot;)" autocomplete="anyrandomstring"> ';
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
								<td class=""> SQM Per Box</td>
							 	<td class="pallet_calcution">Total Box</td>
								<td class="multi_pallet_calcution">Total Box</td>
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
								<td class=""> 
								 	<input type="text" id="sqmperbox" name="sqmperbox" value="'.$sqm_per_box.'"  onkeyup="cal_product_invoice(&quot;'.$currency.'&quot;)" onchange="cal_product_invoice(&quot;'.$currency.'&quot;)" onblur="cal_product_invoice(&quot;'.$currency.'&quot;)"/>									
							 	</td>
								<td class="pallet_calcution"> 
								 	<input type="text" id="total_box" name="total_box" value="'.$total_box_per_container.'"   class="form-control" onkeyup="cal_product_boxes()" onchange="cal_product_boxes()" onblur="cal_product_boxes()"/>									
							 	</td>
								<td class="multi_pallet_calcution"> 
								 	<input type="text" id="multi_total_box" name="multi_total_box" value="'.$total_box_per_container.'"   class="form-control" onkeyup="cal_product_boxes()" onchange="cal_product_boxes()" onblur="cal_product_boxes()"/>									
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
											<td class=""> 
												<input type="text" id="sqm_per_box'.$rate_data[$m]->seriesgroup_id.'" name="sqm_per_box[]" value="'.$rate_data[$m]->sqm_per_box.'" onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"/>									
											</td>
											<td class="pallet_calcution"> 
												<input type="text" id="total_box'.$rate_data[$m]->seriesgroup_id.'" name="total_box" value="'.$rate_data[$m]->group_total_boxes.'"   class="form-control" onkeyup="cal_product_boxes()" onchange="cal_product_boxes()" onblur="cal_product_boxes()"/>									
											</td>
											<td class="multi_pallet_calcution"> 
												<input type="text" id="multi_total_box'.$rate_data[$m]->seriesgroup_id.'" name="multi_total_box" value="'.$rate_data[$m]->group_total_boxes.'"   class="form-control" onkeyup="cal_product_boxes()" onchange="cal_product_boxes()" onblur="cal_product_boxes()"/>									
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
						<td class=""> 
								 	<input type="text" id="sqm_per_box'.$rate_data[$m]->seriesgroup_id.'" name="sqm_per_box[]" value="'.$sqm_per_box.'" 	onkeyup="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onblur="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')"  onchange="cal_product_group(&quot;'.$currency.'&quot;,'.$rate_data[$m]->seriesgroup_id.')" />									
							 	</td>
						<td class="pallet_calcution"> 
								 	<input type="text" id="total_box'.$rate_data[$m]->seriesgroup_id.'" name="total_box" value=""   class="form-control" onkeyup="cal_product_boxes()" onchange="cal_product_boxes()" onblur="cal_product_boxes()"/>									
							 	</td>
								<td class="multi_pallet_calcution"> 
								 	<input type="text" id="multi_total_box'.$rate_data[$m]->seriesgroup_id.'" name="multi_total_box"  onkeyup="cal_product_boxes()" onchange="cal_product_boxes()" onblur="cal_product_boxes()"  class="form-control"/>									
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
		$deleteid = $this->export->delete_sample($this->input->post('exportinvoicetrnid'),$this->input->post('exportinvoiceid'));
		if($this->input->post('no_of_sample') > 0)
		{
			$qry = "UPDATE `tbl_exportproduct_trn` SET `rowspan_no` = rowspan_no-".($this->input->post('no_of_sample'))." WHERE `exportproduct_trn_id` = ".$this->input->post('exportinvoicetrnid');
			$this->load->database();
			$this->db->query($qry);
		}
		$no_of_container_sample = $this->input->post('no_of_container_sample');
		$con =1;
		$no_of_sample = 0;
		for($no=0;$no<$no_of_container_sample;$no++)
		{
		 
			if(!empty($this->input->post('product_details'.$con)[0])) 
			{
				$data = array(
						"export_invoice_id" => $this->input->post('exportinvoiceid'),
						"exportinvoicetrnid" => $this->input->post('exportinvoicetrnid'),
						"container_name" =>	$con,
						"pallent_check" => 0,
						"no_of_pallet" => 0,
						"status" => 0,
						"cdate" => date('Y-m-d H:i:s')
					);
					
				 	$insertid = $this->export->insert_sampleentry($data);
				$no1=0;
				foreach($this->input->post('container_name'.$con) as $container)
				{
					if(!empty($this->input->post('product_details'.$con)[$no1])) 
					{
						$data1 = array(
								"export_sample_id" =>$insertid,
								"exportinvoicetrnid" =>$this->input->post('exportinvoicetrnid'),
								"product_id" => $this->input->post('product_details'.$con)[$no1],
								"no_of_boxes" =>$this->input->post('no_of_boxes'.$con)[$no1],
								"per"=>'SQM',
								"sqm"=>$this->input->post('sample_sqm'.$con)[$no1],
								"netweight"=>$this->input->post('netweight'.$con)[$no1],
								"grossweight"=>$this->input->post('grossweight'.$con)[$no1],
								"sample_rate"=>$this->input->post('productrate'.$con)[$no1],
								"sample_amout"=>$this->input->post('sampleproductamount'.$con)[$no1],
							);
						$no_of_sample++;
					 	$trnupdatedid = $this->export->insert_sampleentrytrn($data1);
					}
					$no1++;
				}
			}
			$con++;
		} 
				$qry = "UPDATE `tbl_exportproduct_trn` SET `rowspan_no` = rowspan_no+".($no_of_sample)." WHERE `exportproduct_trn_id` = ".$this->input->post('exportinvoicetrnid');
					$this->load->database();
					$this->db->query($qry);
		 
		
		 
		 $row = array();
		 $row['res']= 1;
		 echo json_encode($row);
		 
	}
	public function add_sample()
	{
			
		$no_of_container = $this->input->post('no_of_container');
		$container_name	 = explode(",",$this->input->post('container_name'));
		 
		$str = '';
		$allproduct = $this->export->allproductsize();
		$n=1;
		for($no=0;$no < $no_of_container;$no++)
		{	
			if(!in_array($n,$container_name))
			{
		 	$str .='
					<div class="row'.$no.'">
						<input type="hidden" id="inner_row_value'.$no.'" name="inner_row_value" value="'.$no.'"/>
						<div class="inner_row'.$no.'" >
						<div class="col-md-2">	
								<div style="padding-top: 10px;font-weight:bold;">
									Container '.$n.'
								</div>
						</div>
						
						<div class="col-md-3">					
						   <div class="field-group" >
								<select class="selectajax1" id="product_details'.$n.$no.'" name="product_details'.$n.'[]" onchange="load_data_sample(this.value,'.$n.$no.')" >
								<option value="">Select Product Name</option>';
									for($p=0;$p<count($allproduct);$p++)
									{
										$product_name = $allproduct[$p]->size_type_mm;
										 if(!empty($allproduct[$p]->thickness))
										 {
											 $product_name = $allproduct[$p]->size_type_mm.' - '.$allproduct[$p]->thickness.' MM';
										 }
										$str .='<option '.$sel.' value="'.$allproduct[$p]->product_id.'">'.$product_name.'</option>';
									 
									}
			 $str .='</select>
						</div>  
					  </div> 
						<div class="col-md-2">					
					    <div class="field-group">
								<input id="no_of_boxes'.$n.$no.'" type="text" name="no_of_boxes'.$n.'[]" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_sampledata('.$n.$no.',1)" placeholder="No Of Boxes" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->no_of_boxes.'" />
								
								<input id="appsqmperbox'.$n.$no.'" type="hidden" name="appsqmperbox'.$n.'[]"   />
								<input id="apwigtperbox'.$n.$no.'" type="hidden" name="apwigtperbox'.$n.'[]"   />
								<input id="sample_sqm'.$n.$no.'" type="hidden" name="sample_sqm'.$n.'[]"   />
								<input id="netweight'.$n.$no.'" type="hidden" name="netweight'.$n.'[]"  />
								<input id="grossweight'.$n.$no.'" type="hidden" name="grossweight'.$n.'[]"  />
								<input id="palletweight'.$n.$no.'" type="hidden" name="palletweight'.$n.'[]"   />
								<input id="container_name'.$n.$no.'" type="hidden" name="container_name'.$n.'[]"  value="'.$n.'" />
								
					 	</div> 
					   </div>
						<div class="col-md-2">						   
							<div class="field-group">
								<input id="productrate'.$n.$no.'" type="text" name="productrate'.$n.'[]" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_sampledata('.$n.$no.',1)" placeholder="Sample Rate" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_rate.'" />
							</div> 
						 </div>
						<div class="col-md-2">						   
							<div class="field-group">
								<input id="sampleproductamount'.$n.$no.'" type="text" name="sampleproductamount'.$n.'[]" class="form-control"  readonly  placeholder="Sample Amount" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_amout.'" />
							</div> 
						 </div>						 
						<div class="col-md-1">						   
							<div class="field-group">
								 <a class="btn btn-primary tooltips" data-title="Add More Sample" onclick="add_inner_sample_product('.$no.','.$n.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-plus"></i></a>
							</div> 
						 </div>	
					</div>						 
				 
				  </div>
				   <div class="col-md-12">	<hr /></div>	';
				 
				  }
			$n++;
		}
		$row['str'] = $str;
		echo json_encode($row);
	}
	public function add_inner_sample()
	{
		$no = $this->input->post('no');
		$con = $this->input->post('con');
		$str = '';
		$allproduct = $this->export->allproductsize();
		$n=1;
		 $str .='  <div class="col-md-12"> </div>
			<div class="inner_row'.$con.$no.'" >
						<div class="col-md-2">	
								 
						</div>
						
						<div class="col-md-3">					
						   <div class="field-group" >
								<select class="select'.$con.$no.'" id="product_details'.$con.$no.'" name="product_details'.$n.'[]" onchange="load_data_sample(this.value,'.$con.$no.')" >
								<option value="">Select Product Name</option>';
									 
									for($p=0;$p<count($allproduct);$p++)
									{
										$product_name = $allproduct[$p]->size_type_mm;
										 if(!empty($allproduct[$p]->thickness))
										 {
											 $product_name = $allproduct[$p]->size_type_mm.' - '.$allproduct[$p]->thickness.' MM';
										 } 
										$str .='<option '.$sel.' value="'.$allproduct[$p]->product_id.'">'.$product_name.'</option>';
									 
									}
			 $str .='</select>
						</div>  
					  </div> 
						<div class="col-md-2">					
					    <div class="field-group">
								<input id="no_of_boxes'.$con.$no.'" type="text" name="no_of_boxes'.$con.'[]" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_sampledata('.$con.$no.',1)" placeholder="No Of Boxes" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->no_of_boxes.'" />
								<input id="appsqmperbox'.$con.$no.'" type="hidden" name="appsqmperbox'.$con.'[]"   />
								<input id="apwigtperbox'.$con.$no.'" type="hidden" name="apwigtperbox'.$con.'[]"   />
								<input id="sample_sqm'.$con.$no.'" type="hidden" name="sample_sqm'.$con.'[]"    />
								<input id="netweight'.$con.$no.'" type="hidden" name="netweight'.$con.'[]"  />
								<input id="grossweight'.$con.$no.'" type="hidden" name="grossweight'.$con.'[]"  value="'.$samplerecord[$no]->grossweight.'" />
								<input id="palletweight'.$con.$no.'" type="hidden" name="palletweight'.$con.'[]"  value="'.$samplerecord[$no]->plat_weight.'" />
								<input id="container_name'.$con.$no.'" type="hidden" name="container_name'.$con.'[]"  value="'.$n.'" />
								
					 	</div> 
					   </div>
						<div class="col-md-2">						   
							<div class="field-group">
								<input id="productrate'.$con.$no.'" type="text" name="productrate'.$n.'[]" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_sampledata('.$con.$no.',1)" placeholder="Sample Rate" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_rate.'" />
							</div> 
						 </div>
						<div class="col-md-2">						   
							<div class="field-group">
								<input id="sampleproductamount'.$con.$no.'" type="text" name="sampleproductamount'.$n.'[]" class="form-control"  readonly  placeholder="Sample Amount" style="margin-top: 3px !important;" value="'.$samplerecord[$no]->sample_amout.'" />
							</div> 
						 </div>						 
						<div class="col-md-1">						   
							<div class="field-group">
								 <a class="btn btn-warning tooltips" data-title="Remove Sample" onclick="remove_inner_sample_product('.$con.$no.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-minus"></i></a>
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
		$exportproduct_trn_id = $this->input->post('exportproduct_trn_id');
		$id  				  = $this->input->post('export_invoice_id');
		$samplerecord 		  = $this->export->only_sample_mst($exportproduct_trn_id,$id);
		$str ='';
		$allproduct = $this->export->allproductsize();
		$no_of_sample = 0;
		$container_name_array = array();
		for($no=0;$no<count($samplerecord);$no++)
		{
			$sample_trn  = $this->export->only_sample_trn($samplerecord[$no]->export_sample_id);
			array_push($container_name_array,$samplerecord[$no]->container_name);
			 
			$str .=' <div class="row'.$no.'">
						<input type="hidden" id="inner_row_value'.$no.'" name="inner_row_value" value="'.count($sample_trn).'"/>';
			$no_of_sample += count($sample_trn);	
			for($no1=0;$no1<count($sample_trn);$no1++)
			{	
				
				if($no1 == 0)
				{
					$str .=' <div class="inner_row'.$no1.'" >'; 
						$str .='<div class="col-md-2">	
									<div style="padding-top: 10px;font-weight:bold;">
										Container '.$samplerecord[$no]->container_name.'
									</div>
								</div>
						';
				}
				else{
					$str .=' <div class="col-md-12"> </div> 
							<div class="inner_row'.$no1.'" >'; 
					$str .='<div class="col-md-2">	
							 </div> ';
				}
				 
					$str .='
							<div class="col-md-3">					
						   <div class="field-group" >
								<select class="editselectajax1" id="product_details'.$samplerecord[$no]->container_name.$no1.'" name="product_details'.$samplerecord[$no]->container_name.'[]" onchange="load_data_sample(this.value,'.$samplerecord[$no]->container_name.$no1.')" >
								<option value="">Select Product Name</option>';
									 
									for($p=0;$p<count($allproduct);$p++)
									{
										$product_name = $allproduct[$p]->size_type_mm;
										 if(!empty($allproduct[$p]->thickness))
										 {
											 $product_name = $allproduct[$p]->size_type_mm.' - '.$allproduct[$p]->thickness.' MM';
										 }
										 $sel ='';
										 if($sample_trn[$no1]->product_id == $allproduct[$p]->product_id)
										 {
											 $sel ="selected='selected'";
										 }
										$str .='<option '.$sel.' value="'.$allproduct[$p]->product_id.'">'.$product_name.'</option>';
									 
									}
			 $str .='</select>
						</div>  
					  </div> 
						<div class="col-md-2">					
					    <div class="field-group">
								<input id="no_of_boxes'.$samplerecord[$no]->container_name.$no1.'" type="text" name="no_of_boxes'.$samplerecord[$no]->container_name.'[]" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_sampledata('.$samplerecord[$no]->container_name.$no1.',1)" placeholder="No Of Boxes" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->no_of_boxes.'" />
								
								<input id="appsqmperbox'.$samplerecord[$no]->container_name.$no1.'" type="hidden" name="appsqmperbox'.$samplerecord[$no]->container_name.'[]"   value="'.$sample_trn[$no1]->sqm_per_box.'"/>
								<input id="apwigtperbox'.$samplerecord[$no]->container_name.$no1.'" type="hidden" name="apwigtperbox'.$samplerecord[$no]->container_name.'[]"  value="'.$sample_trn[$no1]->weight_per_box.'" />
								<input id="sample_sqm'.$samplerecord[$no]->container_name.$no1.'" type="hidden" name="sample_sqm'.$samplerecord[$no]->container_name.'[]"   value="'.$sample_trn[$no1]->sqm.'"/>
								<input id="netweight'.$samplerecord[$no]->container_name.$no1.'" type="hidden" name="netweight'.$samplerecord[$no]->container_name.'[]"  value="'.$sample_trn[$no1]->netweight.'"/>
								<input id="grossweight'.$samplerecord[$no]->container_name.$no1.'" type="hidden" name="grossweight'.$samplerecord[$no]->container_name.'[]" value="'.$sample_trn[$no1]->grossweight.'" />
								<input id="palletweight'.$samplerecord[$no]->container_name.$no1.'" type="hidden" name="palletweight'.$samplerecord[$no]->container_name.'[]" value="0"  />
								
								<input id="container_name'.$samplerecord[$no]->container_name.$no1.'" type="hidden" name="container_name'.$samplerecord[$no]->container_name.'[]"  value="'.$samplerecord[$no]->container_name.'" />
								
					 	</div> 
					   </div>
						<div class="col-md-2">						   
							<div class="field-group">
								<input id="productrate'.$samplerecord[$no]->container_name.$no1.'" type="text" name="productrate'.$samplerecord[$no]->container_name.'[]" class="form-control" onkeypress="return isNumber(event)" onkeyup="cal_sampledata('.$samplerecord[$no]->container_name.$no1.',1)" placeholder="Sample Rate" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->sample_rate.'" />
							</div> 
						 </div>
						<div class="col-md-2">						   
							<div class="field-group">
								<input id="sampleproductamount'.$samplerecord[$no]->container_name.$no1.'" type="text" name="sampleproductamount'.$samplerecord[$no]->container_name.'[]" class="form-control"  readonly  placeholder="Sample Amount" style="margin-top: 3px !important;" value="'.$sample_trn[$no1]->sample_amout.'" />
							</div> 
						 </div>	';
						if($no1 == 0)
						{
							$str .='<div class="col-md-1">						   
								<div class="field-group">
									<a class="btn btn-primary tooltips" data-title="Add More Sample" onclick="add_inner_sample_product('.$no.','.$samplerecord[$no]->container_name.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-plus"></i></a>
								</div> 
							</div>	';
						}
						else
						{
							$str .='<div class="col-md-1">						   
								<div class="field-group">
									<a class="btn btn-warning tooltips" data-title="Remove Sample" onclick="remove_inner_sample_product('.$no1.')" href="javascript:;" data-original-title="" title=""><i class="fa fa-minus"></i></a>
								</div> 
							</div>	';
						 
						}
				$str .='
				</div>						 
				 
				  </div>';
			}
				$str .='   <div class="col-md-12">	<hr /></div>	';
				  
		}
		$row= array();
		$row['str'] = $str;
		
		$row['container_name'] = implode(",",$container_name_array);
		$row['pallent_check'] = $pallent_check;
		$row['no_of_sample'] = $no_of_sample;
		echo json_encode($row);
	}
	public function delete_sampleentry()
	{
		$exportproduct_trn_id = $this->input->post('exportproduct_trn_id');
		$id  = $this->input->post('export_invoice_id');
		$no_of_sample  = $this->input->post('no_of_sample');
		$samplerecord = $this->export->deletesampleproductdata($exportproduct_trn_id,$id);
		  $qry = "UPDATE `tbl_exportproduct_trn` SET `rowspan_no` = rowspan_no-".($no_of_sample)." WHERE `exportproduct_trn_id` = ".$exportproduct_trn_id;
			$this->load->database();
			$this->db->query($qry);
	}
	public function copy_containter()
	{
		$producttrn_id = implode(",",$this->input->post('producttrn_id'));
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		$export_invoice_id = $this->input->post('export_invoice_id');
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
