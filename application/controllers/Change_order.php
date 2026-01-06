<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Change_order extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
	 	$this->load->model('Change_order_modal','change');
		$this->load->model('Admin_product_invoice');
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
			 $all_supplier	 	= 	$this->change->all_supplier();
			 
		 	$data = array(
			 	'mode'					=> 'Add',
				'menu_data'				=> $menu_data,
				'company_detail'		=> $this->admin_company_detail->s_select(),
				'allproduct'		    => $this->change->allproductsize(),
				'all_supplier'		    => $all_supplier,
				'finishdata'		 	=> $this->change->getfinishdata(),
				'allperformainvoice'	=> $this->change->allperformainvoice(),
			);
		 	$this->load->view('admin/change_order',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function performa_detail()
	{
		$performa_invoice_id = $this->input->post('performa_invoice_id');
		$invoice_data = $this->change->getinvoicedata($performa_invoice_id);
		$pi_data = $this->change->get_pi_detail($performa_invoice_id);
		 $set_container			= 	$this->change->product_set_data($performa_invoice_id);
		 $packingtrn_array1 = array();
		 $packingtrnarray1 = array();
		 $packingtrn_array = array();
		 $packingtrnarray = array();
		 for($i=0; $i<count($set_container);$i++)
		 {
		 
			 if(!in_array($set_container[$i]->performa_packing_id,$packingtrn_array1))
			 {
			 	array_push($packingtrn_array1,$set_container[$i]->performa_packing_id);
			 	$packingtrnarray1[$set_container[$i]->performa_packing_id] = array();
			 	$packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_boxes']  		= $set_container[$i]->origanal_boxes;
			 	$packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_sqm']  	 	= $set_container[$i]->origanal_sqm;
			 	$packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_pallet']      = $set_container[$i]->origanal_pallet;
			 	$packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_big_pallet']  = $set_container[$i]->orginal_no_of_big_pallet;
			 	$packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_small_pallet']= $set_container[$i]->orginal_no_of_small_pallet;
			 	
			 }
			 else
			 {
				   
			 	 $packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
			 	
			 	 $packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_sqm']  +=($set_container[$i]->origanal_sqm);
			 	 
			 	 
			 	 $packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
			 	 $packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
			 	 $packingtrnarray1[$set_container[$i]->performa_packing_id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
			 }
			 
			 if(!in_array($set_container[$i]->production_trn_id,$packingtrn_array))
			 {
			 	array_push($packingtrn_array,$set_container[$i]->production_trn_id);
			 	$packingtrnarray[$set_container[$i]->production_trn_id] = array();
			 	$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_boxes']  = $set_container[$i]->origanal_boxes;
			  
			 	$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_sqm']  =($set_container[$i]->origanal_sqm);
			 	
			 	 
			 	$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_pallet']  = $set_container[$i]->origanal_pallet;;
			 	$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_big_pallet']  = $set_container[$i]->orginal_no_of_big_pallet;;
			 	$packingtrnarray[$set_container[$i]->production_trn_id]['no_of_small_pallet']  = $set_container[$i]->orginal_no_of_small_pallet;;
			 	
			 }
			 else
			 {
			 	 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
			 	 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_sqm']  +=($set_container[$i]->origanal_sqm);
			  	 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
			 	 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
			 	 $packingtrnarray[$set_container[$i]->production_trn_id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
			 }
		 }
		
		 $all_supplier			= 	$this->change->all_supplier($performa_invoice_id);
		 $array = array();
		$str = ' <div class="table-responsive" style="margin-bottom:50px">
								 <table class="table table-bordered" width="150%" >
									<tr>
									 	<th class="text-center" width="6%" rowspan="2">Product Name</th>
										<th class="text-center" width="5%"  rowspan="2">Size</th>
										<th class="text-center" width="6%"  rowspan="2">Design</th>
										<th class="text-center" width="5%"  rowspan="2">Finish</th>
										<th class="text-center"  colspan="5">Performa Detail</th>
										<th class="text-center" colspan="4" >Producation Sheet</th>
										<th class="text-center" colspan="5" >Purchase Order</th>
								 	</tr>';
									 
									for($i=0; $i<count($pi_data);$i++)
									{
										if($i == 0)
										{
										$str .= '
										<tr>
											<th class="text-center" width="7%" >Pallet</th>
											<th class="text-center" width="5%" >Boxes</th>
											<th class="text-center" width="5%" >SQM</th>
											<th class="text-center" width="5%" >Rate</th>
											<th class="text-center" width="5%" >Amt</th>
											<th class="text-center" width="8%" >Factory</th>
											<th class="text-center" width="7%" >Pallet</th>
											<th class="text-center" width="5%" >Boxes</th>
											<th class="text-center" width="5%" >SQM</th>
											<th class="text-center" width="7%" >Pallet</th>
											<th class="text-center" width="5%" >Boxes</th>
											<th class="text-center" width="5%" >SQM</th>
											<th class="text-center" width="5%" >Rate</th>
											<th class="text-center" width="5%" >Amt</th>
										</tr> 		 
										';
										}
										foreach($pi_data[$i]->packing  as $packing_row)
										{
											$remaining_boxes = ($packing_row->no_of_boxes - $packingtrnarray1[$packing_row->performa_packing_id]["no_of_boxes"]);
											$remaining_sqm = ($packing_row->no_of_sqm - $packingtrnarray1[$packing_row->performa_packing_id]["no_of_sqm"]);
											$done_no_of_sqm= !empty($packingtrnarray1[$packing_row->performa_packing_id]["no_of_sqm"])?$packingtrnarray1[$packing_row->performa_packing_id]["no_of_sqm"]:0;
											
											$done_no_of_boxes= !empty($packingtrnarray1[$packing_row->performa_packing_id]["no_of_boxes"])?$packingtrnarray1[$packing_row->performa_packing_id]["no_of_boxes"]:0;
											
											
											if($remaining_boxes > 0 || $remaining_sqm>0)
											{
											$pallet 		=  '';
											$big_pallet 	=  '';
											$small_pallet 	=  '';
											$no_of_sqm 		=  $remaining_sqm;
											$no_of_boxes 	=  $remaining_boxes;
														if($packing_row->no_of_pallet>0)
														{
															$pallet =  $packing_row->no_of_pallet -  $packingtrnarray1[$packing_row->performa_packing_id]["no_of_pallet"];
														}
														else if($packing_row->no_of_big_pallet>0 || $packing_row->no_of_small_pallet>0)
														{
															$big_pallet 	= $packing_row->no_of_big_pallet  -  $packingtrnarray1[$packing_row->performa_packing_id]["no_of_big_pallet"];
															$small_pallet 	= $packing_row->no_of_small_pallet  -  $packingtrnarray1[$packing_row->performa_packing_id]["no_of_small_pallet"];
												 		}
											$done_product_amt = 0;			
											if($packing_row->per == "SQM")
											{
												$product_rate 	=  number_format($packing_row->product_rate,2,'.','');
												$product_amt 	=  number_format(($remaining_sqm * $packing_row->product_rate),2,'.','');
												
												$done_product_amt 	=  number_format(($done_no_of_sqm * $packing_row->product_rate),2,'.','');
												
												
												 
											}
											else if($packing_row->per == "BOX")
											{
												$product_rate 	=  number_format($packing_row->product_rate,2,'.','');
												$product_amt 	=  number_format(($remaining_boxes * $packing_row->product_rate),2,'.','');
												
												$done_product_amt 	=  number_format(($done_no_of_boxes * $packing_row->product_rate),2,'.','');
											 }
											else if($packing_row->per == "SQF")
											{
												$sqf = ($remaining_boxes * $pi_data[$i]->feet_per_box);
												$sqf1 = ($done_no_of_boxes * $pi_data[$i]->feet_per_box);
												 
												$product_rate 	=  number_format($packing_row->product_rate,2,'.','');
												$product_amt 	=  number_format(($sqf * $packing_row->product_rate),2,'.','');
												
												$done_product_amt 	=  number_format(($sqf1 * $packing_row->product_rate),2,'.','');
											}
											else if($packing_row->per == "PCS")
											{
												$pcs = ($remaining_boxes * $pi_data[$i]->pcs_per_box);
												$pcs1 = ($done_no_of_boxes * $pi_data[$i]->pcs_per_box);
												 
												$product_rate 	=  number_format($packing_row->product_rate,2,'.','');
												$product_amt 	=  number_format(($pcs * $packing_row->product_rate),2,'.','');
												
												$done_product_amt 	=  number_format(($pcs1 * $packing_row->product_rate),2,'.','');
											}		
											
										 	$production_data = $this->change->get_production_detail($packing_row->performa_packing_id);	
											$rowspan = (count($production_data)	> 1)?count($production_data):'';
											
										
									$str .= '
										 <input type="hidden" id="pallet_status'.$packing_row->performa_packing_id.'" name="pallet_status[]"  value="'.$pi_data[$i]->pallet_status.'"/>
										
										<input type="hidden" id="boxes_per_pallet'.$packing_row->performa_packing_id.'" name="boxes_per_pallet[]"  value="'.$pi_data[$i]->boxes_per_pallet.'"/>
										
										<input type="hidden" id="box_per_big_pallet'.$packing_row->performa_packing_id.'" name="box_per_big_pallet[]"  value="'.$pi_data[$i]->box_per_big_pallet.'"/>
										
										<input type="hidden" id="box_per_small_pallet'.$packing_row->performa_packing_id.'" name="box_per_small_pallet[]"  value="'.$pi_data[$i]->box_per_small_pallet.'"/>
										
										<input type="hidden" id="big_pallet_weight'.$packing_row->performa_packing_id.'" name="big_pallet_weight[]"  value="'.$pi_data[$i]->big_pallet_weight.'"/>
										
										<input type="hidden" id="small_pallet_weight'.$packing_row->performa_packing_id.'" name="small_pallet_weight[]"  value="'.$pi_data[$i]->small_pallet_weight.'"/>
									
										<input type="hidden" id="pallet_weight'.$packing_row->performa_packing_id.'" name="pallet_weight[]"  value="'.$pi_data[$i]->pallet_weight.'"/>
									
										<input type="hidden" id="weight_per_box'.$packing_row->performa_packing_id.'" name="weight_per_box[]"  value="'.$pi_data[$i]->weight_per_box.'"/>
										
										<input type="hidden" id="sqm_per_box'.$packing_row->performa_packing_id.'" name="sqm_per_box[]"  value="'.$pi_data[$i]->sqm_per_box.'"/>
									
										<input type="hidden" id="feet_per_box'.$packing_row->performa_packing_id.'" name="feet_per_box[]"  value="'.$pi_data[$i]->feet_per_box.'"/>
										
										<input type="hidden" id="pcs_per_box'.$packing_row->performa_packing_id.'" name="pcs_per_box[]"  value="'.$pi_data[$i]->pcs_per_box.'"/>
										
										<input type="hidden" id="unit_per'.$packing_row->performa_packing_id.'" name="unit_per[]"  value="'.$packing_row->per.'"/>
									 
									
										 
										<tr>
										 	<td class="text-center"  rowspan='.$rowspan.' >'.$pi_data[$i]->series_name.' - '.$pi_data[$i]->thickness.' MM</td>
											<td class="text-center"  rowspan='.$rowspan.' >'.$pi_data[$i]->size_type_mm.'</td>
											<td class="text-center"  rowspan='.$rowspan.' >'.$packing_row->model_name.'</td>
											<td class="text-center"  rowspan='.$rowspan.' >'.$packing_row->finish_name.'</td>
											<td class="text-center"  rowspan='.$rowspan.' >';
											$pallet_weight = 0;
											$total_big_pallet_weight = 0;
											$total_small_pallet_weight = 0;
											$with_producation_sheet = ' ';
											 
											if($pallet > 0)
											{
												$done_pallet = !empty($packingtrnarray1[$packing_row->performa_packing_id]["no_of_pallet"])?$packingtrnarray1[$packing_row->performa_packing_id]["no_of_pallet"]:0;
												$str .= '	
												<div class="input-group input_change_pallet'.$packing_row->performa_packing_id.'">
													<input type="text" id="pallet'.$packing_row->performa_packing_id.'" name="pallet[]"  placeholder="Pallet" class="form-control"   value="'.$pallet.'" 
													onfocus="show_change_btn(&quot;input_change_pallet&quot;,&quot;btn_change_pallet&quot;,'.$packing_row->performa_packing_id.')"
													
													onkeypress="return isNumber(event)" 
													onkeyup="calc_product_trn('.$packing_row->performa_packing_id.',0)"
													onblur="calc_product_trn('.$packing_row->performa_packing_id.',0)"/>
													
													<span class="input-group-btn btn_change_pallet'.$packing_row->performa_packing_id.'" style="display:none;z-index:10">
														<button   class="btn btn-warning" type="button"  onclick="change_in_pi('.$packing_row->performa_packing_id.',1)"> <i class="fa fa-pencil"></i> </button>
													</span>			
													 
												</div>
												<input type="hidden" id="done_pallet'.$packing_row->performa_packing_id.'" name="done_pallet[]"     value="'.$done_pallet.'" />
												'; 
												$pallet_weight = $pallet * $pi_data[$i]->pallet_weight;
												$done_pallet_weight = $done_pallet * $pi_data[$i]->pallet_weight;
											}
											if($big_pallet > 0)
											{
												$done_big_pallet = !empty($packingtrnarray1[$packing_row->performa_packing_id]["no_of_big_pallet"])?$packingtrnarray1[$packing_row->performa_packing_id]["no_of_big_pallet"]:0;
												$str .= ' <span style="width:30%;float:left">Big :</span>
											 		
													<div class="input-group input_change_bigpallet'.$packing_row->performa_packing_id.'" style="width:70%;float:left" >
													
													<input   type="text" id="big_pallet'.$packing_row->performa_packing_id.'" name="big_pallet[]" placeholder="Big Pallet" class="form-control"
													 onfocus="show_change_btn(&quot;input_change_bigpallet&quot;,&quot;btn_change_bigpallet&quot;,'.$packing_row->performa_packing_id.')"
													
													onkeypress="return isNumber(event)" onkeyup="calc_product_trn('.$packing_row->performa_packing_id.',0)"   onblur="calc_product_trn('.$packing_row->performa_packing_id.',0)"  value="'.$big_pallet.'" />
													
													<span class="input-group-btn btn_change_bigpallet'.$packing_row->performa_packing_id.'" style="display:none;z-index:10">
														 <button onclick="change_in_pi('.$packing_row->performa_packing_id.',1)" class="btn btn-warning" type="button"><i class="fa fa-pencil"></i></button>
																 
													</span>
												</div>
													<input type="hidden" id="done_big_pallet'.$packing_row->performa_packing_id.'" name="done_big_pallet[]"     value="'.$done_big_pallet.'" />
													'; 
												$total_big_pallet_weight = $pallet * $pi_data[$i]->big_pallet_weight;
												$done_total_big_pallet_weight = $done_big_pallet * $pi_data[$i]->big_pallet_weight;
											}
											if($small_pallet > 0)
											{	
												$done_small_pallet = !empty($packingtrnarray1[$packing_row->performa_packing_id]["no_of_small_pallet"])?$packingtrnarray1[$packing_row->performa_packing_id]["no_of_small_pallet"]:0;
												$str .= '<span style="width:30%;float:left">Small :</span>
													
												<div class="input-group input_change_smallpallet'.$packing_row->performa_packing_id.'" style="width:70%;float:left" >
													 <input  type="text" id="small_pallet'.$packing_row->performa_packing_id.'" name="small_pallet[]" placeholder="Small Pallet" class="form-control"  
													
													onfocus="show_change_btn(&quot;input_change_smallpallet&quot;,&quot;btn_change_smallpallet&quot;,'.$packing_row->performa_packing_id.')"
													 
													 onkeypress="return isNumber(event)" onkeyup="calc_product_trn('.$packing_row->performa_packing_id.',0)"   onblur="calc_product_trn('.$packing_row->performa_packing_id.',0)" value="'.$small_pallet.'" />
														<span class="input-group-btn btn_change_smallpallet'.$packing_row->performa_packing_id.'" style="display:none;z-index:10">
															<button class="btn btn-warning dropdown-toggle" type="button" onclick="change_in_pi('.$packing_row->performa_packing_id.',1)"><i class="fa fa-pencil"></i> </button>
																 
													</span>
												</div>
												<input type="hidden" id="done_small_pallet'.$packing_row->performa_packing_id.'" name="done_small_pallet[]"     value="'.$done_small_pallet.'" />
												';
												$total_small_pallet_weight = $pallet * $pi_data[$i]->small_pallet_weight;
												$done_total_small_pallet_weight = $done_small_pallet * $pi_data[$i]->small_pallet_weight;
											}
											$packing_net_weight = $pi_data[$i]->weight_per_box * $no_of_boxes;
											$done_packing_net_weight = $pi_data[$i]->weight_per_box * $done_no_of_boxes;
											
											$packing_gross_weight = $packing_net_weight + $total_big_pallet_weight + $total_small_pallet_weight + $pallet_weight;
											
											$done_packing_gross_weight = $done_packing_net_weight + $done_total_big_pallet_weight + $done_total_small_pallet_weight + $done_pallet_weight;
											
											
											
											$str .= '</td>
											<td rowspan='.$rowspan.'> 
												<div class="input-group input_change_box'.$packing_row->performa_packing_id.'" >
													<input type="text" id="no_of_boxes'.$packing_row->performa_packing_id.'" name="no_of_boxes[]" placeholder="No Of Boxes" class="form-control"   value="'.$no_of_boxes.'" 
													onfocus="show_change_btn(&quot;input_change_box&quot;,&quot;btn_change_box&quot;,'.$packing_row->performa_packing_id.')"
													
													onkeypress="return isNumber(event)" onkeyup="calc_product_trn('.$packing_row->performa_packing_id.',1)"   onblur="calc_product_trn('.$packing_row->performa_packing_id.',1)" />
													
														<span class="input-group-btn btn_change_box'.$packing_row->performa_packing_id.'" style="display:none">
														   <button class="btn btn-warning" type="button"  onclick="change_in_pi('.$packing_row->performa_packing_id.',1)"><i class="fa fa-pencil"></i>  </button>
																 
													</span>
												</div>
												<input type="hidden" id="done_no_of_boxes'.$packing_row->performa_packing_id.'" name="done_no_of_boxes[]"     value="'.$done_no_of_boxes.'" />
											</td>
											<td rowspan='.$rowspan.'>  
												<input type="text" id="no_of_sqm'.$packing_row->performa_packing_id.'" name="no_of_sqm[]"  placeholder="No Of SQM" class="form-control"   value="'.$no_of_sqm.'" readonly />
												<input type="hidden" id="done_no_of_sqm'.$packing_row->performa_packing_id.'" name="done_no_of_sqm[]"     value="'.$done_no_of_sqm.'" />
											</td>
											 <td rowspan='.$rowspan.'> 
												<div class="input-group input_change_rate'.$packing_row->performa_packing_id.'" >
												
													<input type="text" id="product_rate'.$packing_row->performa_packing_id.'" name="product_rate[]" 
													onfocus="show_change_btn(&quot;input_change_rate&quot;,&quot;btn_change_rate&quot;,'.$packing_row->performa_packing_id.')"
													
													onkeypress="return isNumber(event)" 
													onkeyup="calc_product_trn('.$packing_row->performa_packing_id.',0)"   
													onblur="calc_product_trn('.$packing_row->performa_packing_id.',0)" placeholder="Rate" class="form-control"   value="'.$product_rate.'"/>
													
													<span class="input-group-btn btn_change_rate'.$packing_row->performa_packing_id.'" style="display:none">
														  
																<button class="btn btn-warning" type="button" onclick="change_in_pi('.$packing_row->performa_packing_id.',1)"><i class="fa fa-pencil"></i>
																 
													</span>
												</div>
												
												
											</td>
											  <td rowspan='.$rowspan.'> 
												 <span id="product_amt_html'.$packing_row->performa_packing_id.'"> '.$product_amt.' </span>
												
												<input type="hidden" id="product_amt'.$packing_row->performa_packing_id.'" name="product_amt[]"  value="'.$product_amt.'"/>
												
												<input type="hidden" id="done_product_amt'.$packing_row->performa_packing_id.'" name="done_product_amt[]"  value="'.$done_product_amt.'"/>
											 	
												<input type="hidden" id="packing_net_weight'.$packing_row->performa_packing_id.'" name="packing_net_weight[]"    value="'.$packing_net_weight.'"/>
												
												<input type="hidden" id="done_packing_net_weight'.$packing_row->performa_packing_id.'" name="done_packing_net_weight[]"    value="'.$done_packing_net_weight.'"/>
												 
												 <input type="hidden" id="packing_gross_weight'.$packing_row->performa_packing_id.'" name="packing_gross_weight[]"    value="'.$packing_gross_weight.'"/>
												
												<input type="hidden" id="done_packing_gross_weight'.$packing_row->performa_packing_id.'" name="done_packing_gross_weight[]"    value="'.$done_packing_gross_weight.'"/>
											 </td>';
								  				 
											if(!empty($production_data))
											{
												$tr_close = 1;	
										 		foreach($production_data  as $production_data_row)
												{
													$production_remaining_boxes = ($production_data_row->no_of_boxes - $packingtrnarray[$production_data_row->production_trn_id]["no_of_boxes"]);
													
													$production_remaining_sqm = ($production_data_row->no_of_sqm - $packingtrnarray[$production_data_row->production_trn_id]["no_of_sqm"]);
													 
													$production_done_boxes = !empty($packingtrnarray[$production_data_row->production_trn_id]["no_of_boxes"])?$packingtrnarray[$production_data_row->production_trn_id]["no_of_boxes"]:0;
													
													$production_done_sqm = !empty($packingtrnarray[$production_data_row->production_trn_id]["no_of_sqm"])?$packingtrnarray[$production_data_row->production_trn_id]["no_of_sqm"]:0;
													
													
													if($production_remaining_boxes > 0 || $production_remaining_sqm>0)
													{
													$pallet 		=  '';
													$big_pallet 	=  '';
													$small_pallet 	=  '';
													$no_of_sqm 		= $production_remaining_sqm;
													$no_of_boxes 	= $production_remaining_boxes;
												 		if($production_data_row->no_of_pallet>0)
														{
															$done_producation_pallet =  $packingtrnarray[$production_data_row->production_trn_id]["no_of_pallet"];
															
															$pallet =  $production_data_row->no_of_pallet  - $packingtrnarray[$production_data_row->production_trn_id]["no_of_pallet"];
													 	}
														else if($production_data_row->no_of_big_pallet>0 || $production_data_row->no_of_small_pallet>0)
														{
															$done_producation_big_pallet =  $packingtrnarray[$production_data_row->production_trn_id]["no_of_big_pallet"];
															
															$done_producation_small_pallet =  $packingtrnarray[$production_data_row->production_trn_id]["no_of_small_pallet"];
															
															
															$big_pallet 	= $production_data_row->no_of_big_pallet  - $packingtrnarray[$production_data_row->production_trn_id]["no_of_big_pallet"];
															$small_pallet 	= $production_data_row->no_of_small_pallet - $packingtrnarray[$production_data_row->production_trn_id]["no_of_small_pallet"];;
														}
														 if($tr_close > 1)
														 {
															 $str .= "<tr>";
														 }		 
													$str .= '
														<td>
														<select class="select1" name="factory_id" id="factory_id'.$production_data_row->production_trn_id.'" style="width:180px;" onchange="change_suppiler(this.value,'.$production_data_row->production_trn_id.','.$production_data_row->production_mst_id.')">';
															 foreach($all_supplier as $sup_row)
															 {
																 $sel ='';
																 if($sup_row->supplier_id == $production_data_row->supplier_id)
																 {
																	 $sel ='selected="selected"';
																 }
																 $str .= '<option '.$sel.' value="'.$sup_row->supplier_id.'">'.$sup_row->supplier_name.' '.$sup_row->company_name.'</option>';
															 }
														$str .='</select>
														</td>
													<td>';
											if($pallet > 0)
											{
												
												$str .= '	
												 <div class="input-group input_change_producation_pallet'.$production_data_row->production_trn_id.'" >
													<input type="text" id="producation_pallet'.$production_data_row->production_trn_id.'" name="producation_pallet[]" placeholder="Pallet" class="form-control"   value="'.$pallet.'"  
												
													onfocus="show_change_btn(&quot;input_change_producation_pallet&quot;,&quot;btn_change_producation_pallet&quot;,'.$production_data_row->production_trn_id.')"
													
													onkeypress="return isNumber(event)" 
												
													onkeyup="cal_producation_trn('.$production_data_row->production_trn_id.','.$packing_row->performa_packing_id.')"   
													onblur="cal_product_trn('.$production_data_row->production_trn_id.','.$packing_row->performa_packing_id.')" />
												 
													
													<span class="input-group-btn btn_change_producation_pallet'.$production_data_row->production_trn_id.'" style="display:none">
														  
																<button class="btn btn-warning" type="button" onclick="change_in_productionsheet('.$production_data_row->production_trn_id.',1)"><i class="fa fa-pencil"></i>
																 
													</span>
												</div>
												<input type="hidden" id="done_producation_pallet'.$production_data_row->production_trn_id.'" name="done_producation_pallet[]"  value="'.$done_producation_pallet.'"/>
												'; 
											}
											if($big_pallet > 0)
											{
												$str .= ' <span style="width:30%;float:left">Big :</span>	
												 <div class="input-group input_change_producation_bigpallet'.$production_data_row->production_trn_id.'" style="width:70%;float:left">
													
													<input   type="text" id="producation_big_pallet'.$production_data_row->production_trn_id.'" name="producation_big_pallet[]" placeholder="Big Pallet" class="form-control"  
													onfocus="show_change_btn(&quot;input_change_producation_bigpallet&quot;,&quot;btn_change_producation_bigpallet&quot;,'.$production_data_row->production_trn_id.')"
												
													onkeypress="return isNumber(event)"   
													value="'.$big_pallet.'"
													onkeyup="cal_producation_trn('.$production_data_row->production_trn_id.','.$packing_row->performa_packing_id.',0)"   
												
													onblur="cal_producation_trn('.$production_data_row->production_trn_id.','.$packing_row->performa_packing_id.',1)" />
													
													<span class="input-group-btn btn_change_producation_bigpallet'.$production_data_row->production_trn_id.'" style="display:none">
														  
																<button class="btn btn-warning" type="button" onclick="change_in_productionsheet('.$production_data_row->production_trn_id.',1)"><i class="fa fa-pencil"></i>
																 
													</span>
												</div>
												<input type="hidden" id="done_producation_big_pallet'.$production_data_row->production_trn_id.'" name="done_producation_big_pallet[]"  value="'.$done_producation_big_pallet.'"/>
												'; 
											}
											if($small_pallet > 0)
											{	
												$str .= '
												<span style="width:30%;float:left">Small :</span>	
												<div class="input-group input_change_producation_smallpallet'.$production_data_row->production_trn_id.'" style="width:70%;float:left">
													
													<input  type="text" id="producation_small_pallet'.$production_data_row->production_trn_id.'" 
												name="producation_small_pallet[]" 
												placeholder="Small Pallet" 
												class="form-control" 
												onfocus="show_change_btn(&quot;input_change_producation_smallpallet&quot;,&quot;btn_change_producation_smallpallet&quot;,'.$production_data_row->production_trn_id.')"
												
												onkeypress="return isNumber(event)" 
												value="'.$small_pallet.'" 
												onkeyup="cal_producation_trn('.$production_data_row->production_trn_id.','.$packing_row->performa_packing_id.',0)"   
												onblur="cal_producation_trn('.$production_data_row->production_trn_id.','.$packing_row->performa_packing_id.',0)" 
												
												/>
													
													<span class="input-group-btn btn_change_producation_smallpallet'.$production_data_row->production_trn_id.'" style="display:none">
														  
																<button class="btn btn-warning" type="button" onclick="change_in_productionsheet('.$production_data_row->production_trn_id.',1)"><i class="fa fa-pencil"></i>
																 
													</span>
												</div>
												<input type="hidden" id="done_producation_small_pallet'.$done_producation_small_pallet->production_trn_id.'" name="done_producation_big_pallet[]"  value="'.$done_producation_small_pallet.'"/>
												';
											}
											$str .= '</td>
											<td> 
													<div class="input-group input_change_producation_box'.$production_data_row->production_trn_id.'" >
														<input type="text" id="producation_no_of_boxes'.$production_data_row->production_trn_id.'" name="producation_no_of_boxes[]" placeholder="No Of Boxes" class="form-control"  
												value="'.$no_of_boxes.'" 
												onfocus="show_change_btn(&quot;input_change_producation_box&quot;,&quot;btn_change_producation_box&quot;,'.$production_data_row->production_trn_id.')"
													
												onkeypress="return isNumber(event)" 
												onkeyup="cal_producation_trn('.$production_data_row->production_trn_id.','.$packing_row->performa_packing_id.',1)"   
												onblur="cal_producation_trn('.$production_data_row->production_trn_id.','.$packing_row->performa_packing_id.',1)"  />
													
													<span class="input-group-btn btn_change_producation_box'.$production_data_row->production_trn_id.'" style="display:none">
														  
																<button class="btn btn-warning" type="button" onclick="change_in_productionsheet('.$production_data_row->production_trn_id.',1)"><i class="fa fa-pencil"></i>
																 
													</span>
												</div>
												<input type="hidden" id="production_done_boxes'.$production_data_row->production_trn_id.'" name="production_done_boxes[]"  value="'.$production_done_boxes.'"/>
											</td>
											<td> 
												<input type="text" id="producation_no_of_sqm'.$production_data_row->production_trn_id.'" name="producation_no_of_sqm[]" readonly placeholder="No Of SQM" class="form-control"   value="'.$no_of_sqm.'" />
												
												<input type="hidden" id="production_done_sqm'.$production_data_row->production_trn_id.'" name="production_done_sqm[]"  value="'.$production_done_sqm.'"/>
											</td>';
											if(!empty($production_data_row->production_mst_id))
											{
											 $po_data = $this->change->get_po_packing($production_data_row->production_mst_id,$production_data_row->design_id,$production_data_row->finish_id);
													if(!empty($po_data))
													{
														foreach($po_data  as $po_data)
														{
															$pallet 		=  '';
															$big_pallet 	=  '';
															$small_pallet 	=  '';
															$no_of_sqm 		= $po_data->no_of_sqm - $packingtrnarray[$production_data_row->production_trn_id]["no_of_sqm"];
															
															$no_of_boxes 	= $po_data->no_of_boxes - $packingtrnarray[$production_data_row->production_trn_id]["no_of_boxes"];
														
															$done_po_no_of_boxes = $packingtrnarray[$production_data_row->production_trn_id]["no_of_boxes"];
															
															$done_po_no_of_sqm = $packingtrnarray[$production_data_row->production_trn_id]["no_of_sqm"];
															
															$product_rate 	= $po_data->product_rate ;
														
															$product_amt 	= $po_data->product_amt;
															
															
												 		if($po_data->no_of_pallet>0)
														{
															$pallet =  $po_data->no_of_pallet - $packingtrnarray[$production_data_row->production_trn_id]["no_of_pallet"];
															
															$done_pallet =  $packingtrnarray[$production_data_row->production_trn_id]["no_of_pallet"];
															 
														}
														else if($po_data->no_of_big_pallet>0 || $po_data->no_of_small_pallet>0)
														{
															$big_pallet 	= $po_data->no_of_big_pallet  - $packingtrnarray[$production_data_row->production_trn_id]["no_of_big_pallet"];
															
															$done_big_pallet 	=  $packingtrnarray[$production_data_row->production_trn_id]["no_of_big_pallet"];
															
															 $small_pallet 	= $po_data->no_of_small_pallet  - $packingtrnarray[$production_data_row->production_trn_id]["no_of_small_pallet"];
															
															 $done_small_pallet 	=  $packingtrnarray[$production_data_row->production_trn_id]["no_of_small_pallet"];
														}
													if($po_data->per == "SQM")
													{
														$product_rate 	=  number_format($po_data->product_rate,2,'.','');
														$product_amt 	=  number_format(($no_of_sqm * $product_rate),2,'.','');
														
														$done_product_amt 	=  number_format(($done_po_no_of_sqm * $po_data->product_rate),2,'.','');
												
												
													}
													else if($po_data->per == "BOX")
													{
														$product_rate 	=  number_format($po_data->product_rate,2,'.','');
														$product_amt 	=  number_format(($no_of_boxes * $po_data->product_rate),2,'.','');
														$done_product_amt 	=  number_format(($done_po_no_of_boxes * $po_data->product_rate),2,'.','');
													}
													else if($po_data->per == "SQF")
													{
														$sqf = ($no_of_boxes * $pi_data[$i]->feet_per_box);
														$donesqf = ($done_po_no_of_boxes * $pi_data[$i]->feet_per_box);
														
														$product_rate 	=  number_format($po_data->product_rate,2,'.','');
														$product_amt 	=  number_format(($sqf * $po_data->product_rate),2,'.','');
														
														$done_product_amt 	=  number_format(($donesqf * $po_data->product_rate),2,'.','');
													}
													else if($po_data->per == "PCS")
													{
														$pcs = ($no_of_boxes * $pi_data[$i]->pcs_per_box);
														$done_pcs = ($done_po_no_of_boxes * $pi_data[$i]->pcs_per_box);
														
														$product_rate 	=  number_format($po_data->product_rate,2,'.','');
														$product_amt 	=  number_format(($pcs * $po_data->product_rate),2,'.','');
														$done_product_amt 	=  number_format(($done_pcs * $po_data->product_rate),2,'.','');
														
													}
																$po_pallet_weight = 0;										
																$po_big_pallet_weight = 0;										
																$po_small_pallet_weight = 0;										
													$str .= '<td>';
																if($pallet > 0)
																{
																	$str .= '	
																	<div class="input-group input_change_po_pallet'.$po_data->popacking_id.'" >
																	
																	<input type="text" id="po_pallet'.$po_data->popacking_id.'" name="po_pallet[]" placeholder="Pallet" class="form-control"   value="'.$pallet.'" 
																	onfocus="show_change_btn(&quot;input_change_po_pallet&quot;,&quot;btn_change_po_pallet&quot;,'.$po_data->popacking_id.')"
																	
																	onkeypress="return isNumber(event)" onkeyup="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',0)"   onblur="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',0)"  />
													
															<span class="input-group-btn btn_change_po_pallet'.$po_data->popacking_id.'" style="display:none">
														  
																<button class="btn btn-warning" type="button" onclick="change_in_posheet('.$po_data->popacking_id.',1)"><i class="fa fa-pencil"></i>
																 
															</span>
												</div>
														<input type="hidden" id="done_po_pallet'.$po_data->popacking_id.'" name="done_po_pallet[]"  value="'.$done_pallet.'"/>

														'; 
														 $po_pallet_weight = $pallet * $pi_data[$i]->pallet_weight;										
														 $done_po_pallet_weight = $done_pallet * $pi_data[$i]->pallet_weight;										
																}
																if($big_pallet > 0)
																{
																	$str .= ' <span style="width:30%;float:left">Big :</span>	
																	
																	<div class="input-group input_change_po_bigpallet'.$po_data->popacking_id.'"     style="width:70%;float:left" >
																	
																	 <input type="text" id="po_big_pallet'.$po_data->popacking_id.'" name="po_big_pallet[]" placeholder="Big Pallet" class="form-control"   
																	value="'.$big_pallet.'" 
																	onkeypress="return isNumber(event)" 
																	
																	onfocus="show_change_btn(&quot;input_change_po_bigpallet&quot;,&quot;btn_change_po_bigpallet&quot;,'.$po_data->popacking_id.')"
																	
																	onkeyup="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',0)"   
																	
																	onblur="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',0)"/>
													
																	<span class="input-group-btn btn_change_po_bigpallet'.$po_data->popacking_id.'" style="display:none">
														  
																<button class="btn btn-warning" type="button" onclick="change_in_posheet('.$po_data->popacking_id.',1)"><i class="fa fa-pencil"></i>
																 
															</span>
												</div> 
												<input type="hidden" id="done_po_big_pallet'.$po_data->popacking_id.'" name="done_po_big_pallet[]"  value="'.$done_big_pallet.'"/>
												'; 
																	
																	$po_big_pallet_weight = $big_pallet * $pi_data[$i]->big_pallet_weight;
																	 $done_po_big_pallet_weight = $done_big_pallet * $pi_data[$i]->big_pallet_weight;	
																}
																if($small_pallet > 0)
																{	
																	$str .= '<span style="width:30%;float:left">Small :</span>	
																	<div class="input-group input_change_po_smallpallet'.$po_data->popacking_id.'"     style="width:70%;float:left" >
																	 
																	 <input type="text" id="po_small_pallet'.$po_data->popacking_id.'" name="po_small_pallet[]" placeholder="Small Pallet" class="form-control"   value="'.$small_pallet.'" 
																	onkeypress="return isNumber(event)" 
																	
																	onfocus="show_change_btn(&quot;input_change_po_smallpallet&quot;,&quot;btn_change_po_smallpallet&quot;,'.$po_data->popacking_id.')"
																	
																	onkeyup="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',0)"   
																	
																	onblur="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',0)"/>
																	<span class="input-group-btn btn_change_po_smallpallet'.$po_data->popacking_id.'" style="display:none">
														  
																<button class="btn btn-warning" type="button" onclick="change_in_posheet('.$po_data->popacking_id.',1)"><i class="fa fa-pencil"></i>
																 
															</span>
												</div> 
														<input type="hidden" id="done_po_small_pallet'.$po_data->popacking_id.'" name="done_po_small_pallet[]"  value="'.$done_small_pallet.'"/>
														';
																	
																	$po_small_pallet_weight = $small_pallet * $pi_data[$i]->small_pallet_weight;
																	 $done_po_small_pallet_weight = $done_small_pallet * $pi_data[$i]->small_pallet_weight;	
																}
																
																$po_packing_net_weight = $no_of_boxes * $pi_data[$i]->weight_per_box;
																
																$done_po_packing_net_weight = $done_po_no_of_boxes * $pi_data[$i]->weight_per_box;
																
																$po_packing_gross_weight = $po_packing_net_weight + $po_pallet_weight + $po_small_pallet_weight + $po_big_pallet_weight;
																
																$done_po_packing_gross_weight = $done_po_packing_net_weight + $done_po_pallet_weight + $done_po_small_pallet_weight + $done_po_big_pallet_weight;
											$str .= '</td>
											<td> 
											
											<div class="input-group input_change_po_box'.$po_data->popacking_id.'" >
												 <input type="text" id="po_no_of_boxes'.$po_data->popacking_id.'" name="po_no_of_boxes[]" placeholder="No Of Boxes" class="form-control" 
												onkeypress="return isNumber(event)" 
												onfocus="show_change_btn(&quot;input_change_po_box&quot;,&quot;btn_change_po_box&quot;,'.$po_data->popacking_id.')"
												
												onkeyup="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',1)"  
												
												onblur="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',1)"  value="'.$no_of_boxes.'"/>
													
													<span class="input-group-btn btn_change_po_box'.$po_data->popacking_id.'" style="display:none">
													
																<button class="btn btn-warning" type="button" onclick="change_in_posheet('.$po_data->popacking_id.',1)"><i class="fa fa-pencil"></i>
																 
															</span>
												</div> 
											<input type="hidden" id="done_po_no_of_boxes'.$po_data->popacking_id.'" name="done_po_no_of_boxes[]"  value="'.$done_po_no_of_boxes.'"/>	
											</td>
											<td> 
												<input type="text" id="po_no_of_sqm'.$po_data->popacking_id.'" name="po_no_of_sqm[]" placeholder="No Of SQM" class="form-control"   value="'.$no_of_sqm.'" readonly/>
												
												<input type="hidden" id="done_po_no_of_sqm'.$po_data->popacking_id.'" name="done_po_no_of_sqm[]"  value="'.$done_po_no_of_sqm.'"/> 
											</td>
											<td> 
												<div class="input-group input_change_po_rate'.$po_data->popacking_id.'" >
												 
												 <input type="text" id="po_product_rate'.$po_data->popacking_id.'" name="po_product_rate[]" placeholder="Rate" class="form-control"    
												onfocus="show_change_btn(&quot;input_change_po_rate&quot;,&quot;btn_change_po_rate&quot;,'.$po_data->popacking_id.')"
												
												onkeyup="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',0)"  
												
												onblur="cal_po_trn('.$po_data->popacking_id.','.$packing_row->performa_packing_id.',0)"
												value="'.$product_rate.'"/>
													
													<span class="input-group-btn btn_change_po_rate'.$po_data->popacking_id.'" style="display:none">
													
																<button class="btn btn-warning" type="button" onclick="change_in_posheet('.$po_data->popacking_id.',1)"><i class="fa fa-pencil"></i>
																 
															</span>
												</div> 
												
												
											</td>
											<td> 
												<span id="po_amt_html'.$po_data->popacking_id.'"> '.$product_amt.' </span>
												 
												<input type="hidden" id="po_product_amt'.$po_data->popacking_id.'" name="po_product_amt[]"    value="'.$product_amt.'"/>
												
												<input type="hidden" id="done_po_product_amt'.$po_data->popacking_id.'" name="done_po_product_amt[]"    value="'.$done_product_amt.'"/>
												
												
												<input type="hidden" id="po_packing_net_weight'.$po_data->popacking_id.'" name="po_packing_net_weight[]"    value="'.$po_packing_net_weight.'"/>
												
												<input type="hidden" id="done_po_packing_net_weight'.$po_data->popacking_id.'" name="done_po_packing_net_weight[]"    value="'.$done_po_packing_net_weight.'"/>
												
												<input type="hidden" id="po_packing_gross_weight'.$po_data->popacking_id.'" name="po_packing_gross_weight[]"    value="'.$po_packing_gross_weight.'"/>
												
												<input type="hidden" id="done_po_packing_gross_weight'.$po_data->popacking_id.'" name="done_po_packing_gross_weight[]"    value="'.$done_po_packing_gross_weight.'"/>
												
												<input type="hidden" id="po_unit'.$po_data->popacking_id.'" name="po_unit[]"    
												value="'.$po_data->per.'"/>
												
												
											</td>';
														
														}
													}
													else
													{
														$str .='<td colspan="5" class="text-center"> No Purchase Order Found </td>';
													}
											}
											else
											{
												$str .='<td colspan="5" class="text-center"> No Purchase Order Found </td>';
											}
														$str .='</tr>';
													 
													$tr_close++;
												}
												}
											}
											else
											{
												$str .='
														<td colspan="4" class="text-center"> No Producation Sheet Found </td>
													   <td colspan="5" class="text-center"> No Purchase Order Found </td>
												</tr>';
												
											}
											}
									}
								}
								$str .= '</table>
							</div> ';
						$array['html'] = $str;
						$array['consigne_id'] = $invoice_data->consigne_id;
						$array['container_forty'] = $invoice_data->container_forty;
						$array['container_twenty'] = $invoice_data->container_twenty;
						$array['container_details'] = $invoice_data->container_details;
		echo json_encode($array);
	}
	public function checkproduction_sheet()
	{
		  
		$performa_packing_id = $this->input->post('performa_packing_id');
		 
		$check_production_sheet = $this->Admin_product_invoice->check_productionsheet($performa_packing_id);
		$row['count'] = count($check_production_sheet);
		$str = '<option value="">Select Factory</option>';
		foreach($check_production_sheet as $row1)
		{
			$str .= '<option value="'.$row1->supplier_id.' - '.$row1->production_trn_id.'">'.$row1->supplier_name.' '.$row1->company_name.'</option>';
			$row['supplier_id'] =  $row1->supplier_id;
			$row['production_trn_id'] =  $row1->production_trn_id;
		} 
		$row['str'] =  $str;
		echo json_encode($row);
	}
	public function change_in_pi()
	{ 
		$performa_packing_id = $this->input->post('performa_packing_id');
	 	$from 				 = $this->input->post('from');
		$row = array();
		if($from == 1)
		{
			$data = array(
			  	"no_of_pallet" 			 => $this->input->post('no_of_pallet'),
				"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet'),
				"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet'),
				"no_of_boxes" 			 => $this->input->post('no_of_boxes'),
				"no_of_sqm" 			 => $this->input->post('no_of_sqm'),
				"product_rate" 			 => $this->input->post('product_rate'),
				"product_amt" 			 => $this->input->post('product_amt'),
				"packing_net_weight"	 => $this->input->post('packing_net_weight'),
				"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')
		 	);
			$updateid= $this->Admin_product_invoice->update_productpackingrecord($data,$performa_packing_id);
				if($this->input->post('no_of_boxes') == 0)
				{
					$deleteid = $this->Admin_product_invoice->delete_production_mst($performa_packing_id);
					
					 
				}
				if($updateid)
				{	
					$row['res'] = "1";
			 	}
		}
		else if($from == 2)
		{
			$array = explode(" - ",$this->input->post('sheet_suppiler_id'));
			$data = array(
			  	"no_of_pallet" 			 => $this->input->post('no_of_pallet'),
				"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet'),
				"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet'),
				"no_of_boxes" 			 => $this->input->post('no_of_boxes'),
				"no_of_sqm" 			 => $this->input->post('no_of_sqm'),
				"product_rate" 			 => $this->input->post('product_rate'),
				"product_amt" 			 => $this->input->post('product_amt'),
				"packing_net_weight"	 => $this->input->post('packing_net_weight'),
				"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')
		 	);
			$updateid= $this->Admin_product_invoice->update_productpackingrecord($data,$performa_packing_id);
			
			$data_producation_trn = array(
			  	"no_of_pallet" 			 => $this->input->post('no_of_pallet'),
				"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet'),
				"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet'),
				"no_of_boxes" 			 => $this->input->post('no_of_boxes'),
				"no_of_sqm" 			 => $this->input->post('no_of_sqm'),
		 	);
			$updateid= $this->Admin_product_invoice->update_producation_trnrecord($data_producation_trn,$array[1]);
				
				if($updateid)
				{	
					$row['res'] = "1";
			 	}
				
		}
		if(!empty($this->input->post('containertwenty')) || !empty($this->input->post('containerforty')))
		{
			$data_con = array(
					'container_details' 	=> $this->input->post('containerdetails'),
					'container_twenty' 		=> $this->input->post('containertwenty'),
					'container_forty' 		=> $this->input->post('containerforty')
			);
			$rs = $this->Admin_product_invoice->update_proforma($data_con,$this->input->post('performa_invoice_id'));
		}
		echo json_encode($row);
	}
	public function change_in_productionsheet()
	{
			$data_producation_trn = array(
			  	"no_of_pallet" 			 => $this->input->post('no_of_pallet'),
				"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet'),
				"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet'),
				"no_of_boxes" 			 => $this->input->post('no_of_boxes'),
				"no_of_sqm" 			 => $this->input->post('no_of_sqm'),
		 	);
			$updateid= $this->Admin_product_invoice->update_producation_trnrecord($data_producation_trn,$this->input->post('production_trn_id'));
				
				if($updateid)
				{	
					$row['res'] = "1";
			 	}
				
		 echo json_encode($row);
	}		
	public function change_in_production()
	{
		$factory_id 		= $this->input->post('factory_id');
		$production_mst_id  = $this->input->post('production_mst_id');
		$production_trn_id  = $this->input->post('production_trn_id');
		$check_production_sheet_with_suppiler = $this->Admin_product_invoice->check_production_sheet_with_suppiler($production_mst_id,$factory_id);
					if(!empty($check_production_sheet_with_suppiler))
					{
						$row = array();
							$data_producation_trn = array(
								"supplier_id" 			 => $factory_id
						);
						$updateid= $this->Admin_product_invoice->update_producation_mstrecord($production_mst_id,$data_producation_trn);
						if($updateid)
						{	
							$row['res'] = "1";
						}
						else
						{
							$row['res'] = "0";
						}
					}
					else
					{
						$get_producation_data  = $this->Admin_pdf->producation_mst_data($production_mst_id,0);
						 
						$data_producation_sheet = array(
								"performa_invoice_id" => $this->input->post('performa_invoice_id'),
								"no_of_countainer"	  => $get_producation_data->no_of_countainer,
								"con_fourty"		  => $get_producation_data->con_fourty,
								"con_twentry"		  => $get_producation_data->con_twentry,
								"producation_date"	  => $get_producation_data->producation_date,
								"producation_no"	  => $get_producation_data->producation_no,
								"supplier_id"	 	  => $factory_id,
								"note"				  => '',
								"status"			  => 0,
								"cdate"				  => date('Y-m-d H:i:s')
							);
							$insert_producation_id = $this->Admin_pdf->insert_producation_mst($data_producation_sheet);
							
						$row = array();
							$data_producation_trn = array(
								"no_of_pallet" 			 => $this->input->post('no_of_pallet'),
								"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet'),
								"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet'),
								"no_of_boxes" 			 => $this->input->post('no_of_boxes'),
								"no_of_sqm" 			 => $this->input->post('no_of_sqm'),
								"production_mst_id" 	 => $insert_producation_id
						);
						$updateid= $this->Admin_product_invoice->update_producation_trnrecord($data_producation_trn,$production_trn_id);
						if($updateid)
						{	
							$row['res'] = "1";
						}
						else
						{
							$row['res'] = "0";
						}
					}
				echo json_encode($row);
	}
	public function change_in_posheet()
	{ 
		$popacking_id = $this->input->post('popacking_id');
	 	 $row = array();
		 
			$data = array(
			  	"no_of_pallet" 			 => $this->input->post('no_of_pallet'),
				"no_of_big_pallet" 		 => $this->input->post('no_of_big_pallet'),
				"no_of_small_pallet" 	 => $this->input->post('no_of_small_pallet'),
				"no_of_boxes" 			 => $this->input->post('no_of_boxes'),
				"no_of_sqm" 			 => $this->input->post('no_of_sqm'),
				"product_rate" 			 => $this->input->post('product_rate'),
				"product_amt" 			 => $this->input->post('product_amt'),
				"packing_net_weight"	 => $this->input->post('packing_net_weight'),
				"packing_gross_weight" 	 => $this->input->post('packing_gross_weight')
		 	);
			$updateid= $this->Admin_product_invoice->update_popackingrecord($popacking_id,$data);
				if($updateid)
				{	
					$row['res'] = "1";
			 	}
		 
		echo json_encode($row);
	}

}
