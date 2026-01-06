<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Calculation extends CI_controller
{
	
	public function __construct()
	{
		parent::__construct();
		 $this->load->model('admin_calculation','calc');
			$this->load->model('menu_model','menu');	
		
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index(){
		 
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 { 
			$data = $this->calc->select_hsnc();
			$data1 = $this->calc->select_config();
			$this->load->model('admin_company_detail');	
			$menu_data	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$v = array(
						'config'=>$data1,
						'result'=>$data,
						'company_detail'=>$this->admin_company_detail->s_select(),
						'menu_data'=>$menu_data
					);
			$this->load->view('admin/calculation',$v);
		}
		else
		{
			$this->load->view('admin/index');
		}
	}
	 
	public function displaydatanew()
	{
		  $id=$this->input->post('id');
		  $resultset = $this->calc->select_hsnc_product_size($id);
		  $this->load->model('admin_currency_list');	
			$currencydata = $this->admin_currency_list->getcurrencydata();
			$maindetail 	= $this->calc->select_config(); 
		  $str = '';
		  if(!empty($resultset))
		  {
			  	$active1 = ($resultset->boxes_per_pallet > 0)?"active":"";
				$active2 = ($resultset->total_boxes > 0)?"active":"";
				$active3 = ($resultset->box_per_big_plt > 0)?"active":"";
				$fob_expenenses 		=  $maindetail[0]->fob_charges;
				$big_pallet_charges 	=  $maindetail[0]->big_pallet_charge;
				$small_pallet_charges 	=  $maindetail[0]->small_pallet_charges;
				$pallet_charges 		=  $maindetail[0]->pallet_charges;
				 
				$str .= '<div class="row">
							<div class="form-group col-md-12">
							<label class="col-sm-5 control-label" for="form-field-1">
								Product Detail 
							</label>
							<div class="col-sm-6">
								'.$resultset->size_type_mm.' ('.$resultset->series_name.') - '.$resultset->product_packing_name.'
							</div>    
						</div> 
							<input type="hidden" id="size_width_mm" name="size_width_mm"  value="'.$resultset->size_width_mm.'"/>
							<input type="hidden" id="size_height_mm" name="size_height_mm"  value="'.$resultset->size_height_mm.'"/>
							<input type="hidden" id="size_width_cm" name="size_width_cm"  value="'.$resultset->size_width_cm.'"/>
							<input type="hidden" id="size_type_cm" name="size_type_cm"  value="'.$resultset->size_type_cm.'"/>
						<div class="form-group col-md-6">
							<label class="col-sm-5 control-label" for="form-field-1">
								Pcs Per Box
							</label>
							<div class="col-sm-6">
								<input type="text" id="pcs_per_box" name="pcs_per_box" placeholder="" 	class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="'.$resultset->pcs_per_box.'"/>
							</div>    
						</div> 
						 <div class="form-group col-md-6">
						 	<label class="col-sm-5 control-label" for="form-field-1">
						 		Approx Weight Per Box 
						 	</label>
						 	<div class="col-sm-4">
						 		<input type="text" id="weight_per_box" name="weight_per_box" placeholder="" class="form-control"  onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="'.$resultset->weight_per_box.'"  required title="Enter Approx Weight Per Box" /> 
						 
						 	</div>  
						 	<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
						 </div> 
						<div class="form-group col-md-6">
							 	<label class="col-sm-5 control-label" for="form-field-1">
											Approx SQM Per Box
									</label>
								<div class="col-sm-6">
									<input type="text" id="sqm_per_box" name="sqm_per_box" placeholder="" class="form-control" value="'.$resultset->sqm_per_box.'" readonly />
								 </div>    
						</div>	
					
						<div class="form-group col-md-6">
							 	<label class="col-sm-5 control-label" for="form-field-1">
											Approx Feet Per Box
									</label>
								<div class="col-sm-6">
									<input type="text" id="feet_per_box" name="feet_per_box" placeholder="" class="form-control" value="'.$resultset->feet_per_box.'" />
								 </div>    
						</div>						
					</div>		
							 				
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
											<li role="presentation"  id="tab3"  class="'.$active3.'">
												<a href="#table-3" aria-controls="table-3" role="tab" data-toggle="tab">
													<label class="checkbox-inline">
														  Multi Pallet
													</label>
												</a>
											</li>
										</ul>
								<div class="tab-content">
										<div role="tabpanel" class="tab-pane '.$active1.'" id="table-1">
												<div class="row">
													<div class="form-group col-md-6">
														<label class="col-sm-5 control-label" for="form-field-1">
																Boxes Per Pallet 
														</label>
														<div class="col-sm-6">
															<input type="text" id="boxes_per_pallet" name="boxes_per_pallet" placeholder="" class="form-control"  value="'.$resultset->boxes_per_pallet.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Pallet " />
														</div>    
													</div> 
												<div class="form-group col-md-6">
														<label class="col-sm-5 control-label" for="form-field-1">
																Total Pallet In Container
														</label>
														<div class="col-sm-6">
															<input type="text" id="total_pallent_container" name="total_pallent_container" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="'.$resultset->total_pallent_container.'" onkeypress="return isNumber(event)"  required title="Enter Total Pallet In Container"  />
														</div>    
													</div> 
												<div class="form-group col-md-6">
														<label class="col-sm-5 control-label" for="form-field-1">
																Empty Pallet Weight
														</label>
														<div class="col-sm-4">
															<input type="text" id="pallet_weight" name="pallet_weight" placeholder="" class="form-control" value="'.$resultset->pallet_weight.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Pallet Weight" />
														</div>  
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
													</div> 
												 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																Boxes Per Container
														</label>
													<div class="col-sm-6">
														<input type="text" id="box_per_container" name="box_per_container" class="form-control" readonly value="'.$resultset->box_per_container.'"  />
													</div>    
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																Gross Weight Per Container
														</label>
													<div class="col-sm-4">
													<input type="text" id="pallet_gross_weight_per_container" name="pallet_gross_weight_per_container" placeholder=" " class="form-control" readonly value="'.$resultset->pallet_gross_weight_per_container.'"/>
													</div>   
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
													</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																Net Weight Per Container 
														</label>
													<div class="col-sm-4">
													<input type="text" id="pallet_net_weight_per_container" name="pallet_net_weight_per_container" placeholder="" class="form-control" readonly value="'.$resultset->pallet_net_weight_per_container.'" />
													</div>    
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																SQM Per Container
														</label>
													<div class="col-sm-6">
													<input type="text" id="sqm_per_container" name="sqm_per_container"  class="form-control" readonly value="'.$resultset->sqm_per_container.'"  />
													 
													</div>    
												</div> 
												<div class="form-group col-md-5 pallet_calcution">
													<label class="col-sm-6 control-label" for="form-field-1">
																Pallet Charge
														</label>
													<div class="col-sm-6">
														<input type="text" name="pallet_charges" id="pallet_charges" class="form-control pallet_calcution" onkeypress="return isNumber(event)" onkeyup="price_calaculation()" value="'.$pallet_charges.'" />
													</div>    
												</div>
												</div>
										</div>
									 	<div role="tabpanel" class="tab-pane '.$active2.'" id="table-2">
											 <div class="row">
												<div class="form-group  col-md-6">
											 		<label class="col-md-5 control-label">
											 				Total Boxes Per Container
											 		</label>
											 		<div class="col-md-6">
											 			<input type="text" id="total_boxes" name="total_boxes" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="'.$resultset->total_boxes.'"  required title="Enter Total Boxes Per Container" />
											 		</div>    
											 	</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																Gross Weight Per Container
														</label>
													<div class="col-sm-4">
														<input type="text" id="withoutgross_weight_per_container" name="withoutgross_weight_per_container" placeholder=" " class="form-control" readonly value="'.$resultset->withoutgross_weight_per_container.'"/>
													</div>   
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
													</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																Net Weight Per Container 
														</label>
													<div class="col-sm-4">
														<input type="text" id="withoutnet_weight_per_container" name="withoutnet_weight_per_container" placeholder="" class="form-control" readonly value="'.$resultset->withoutnet_weight_per_container.'" />
													</div>    
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																SQM Per Container
														</label>
													<div class="col-sm-6">
														<input type="text" id="withoutpallet_sqm_per_container" name="withoutpallet_sqm_per_container"  class="form-control" readonly value="'.$resultset->withoutpallet_sqm_per_container.'"  />
													</div>    
												</div> 
												</div>
										</div>
										<div role="tabpanel" class="tab-pane '.$active3.'"  id="table-3">
										    <div class="row">
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
															Boxes Per Big Pallet
													</label>
													<div class="col-sm-6">
														<input type="text" id="box_per_big_plt" name="box_per_big_plt" placeholder="" class="form-control"  value="'.$resultset->box_per_big_plt.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Big Pallet" />
													</div>    
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
															Boxes Per Small Pallet
													</label>
													<div class="col-sm-6">
														<input type="text" id="box_per_small_plt_new" name="box_per_small_plt_new" placeholder="" class="form-control"  value="'.$resultset->box_per_small_plt_new.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)" required title="Enter Boxes Per Small Pallet" />
													</div>    
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
															Total Big Pallet In Container
													</label>
													<div class="col-sm-6">
														<input type="text" id="no_big_plt_container_new" name="no_big_plt_container_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="'.$resultset->no_big_plt_container_new.'" onkeypress="return isNumber(event)"  required title="Enter Total Big Pallet In Container"/>
													</div>    
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
															Total Small Pallet In Container
													</label>
													<div class="col-sm-6">
														<input type="text" id="no_small_plt_container_new" name="no_small_plt_container_new" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="'.$resultset->no_small_plt_container_new.'" onkeypress="return isNumber(event)" required title="Enter Total Small Pallet In Container" />
													</div>    
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
															Empty Big Pallet Weight
														</label>
													<div class="col-sm-4">
														<input type="text" id="big_plat_weight" name="big_plat_weight" placeholder="" class="form-control" value="'.$resultset->big_plat_weight.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"   title="Enter Big Pallet Weight"  />
													</div> 
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;">
															<strong>KG</strong>
														</div>
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
															Empty Small Pallet Weight
													</label>
												<div class="col-sm-4">
														<input type="text" id="small_plat_weight" name="small_plat_weight" placeholder="" class="form-control" value="'.$resultset->small_plat_weight.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"   title="Enter Small Pallet Weight"  />
												</div>    
													<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;">
														<strong>KG</strong>
													</div>
											</div> 
											<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																Boxes Per Container
														</label>
													<div class="col-sm-6">
														<input type="text" id="multi_box_per_container" name="multi_box_per_container" class="form-control" readonly value="'.$resultset->multi_box_per_container.'"  />
													</div>    
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																Gross Weight Per Container
														</label>
													<div class="col-sm-4">
														<input type="text" id="multi_gross_weight_container" name="multi_gross_weight_container" placeholder=" " class="form-control" readonly value="'.$resultset->multi_gross_weight_container.'"/>
													</div>   
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
													</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																Net Weight Per Container 
														</label>
													<div class="col-sm-4">
													<input type="text" id="multi_net_weight_container" name="multi_net_weight_container" placeholder="" class="form-control" readonly value="'.$resultset->multi_net_weight_container.'" />
													</div>    
														<div class="col-sm-2" style="margin-top: 5px;padding-left: 0px;"><strong>KG</strong></div>
												</div> 
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
																SQM Per Container
														</label>
													<div class="col-sm-6">
														<input type="text" id="multi_sqm_per_container" name="multi_sqm_per_container"  class="form-control" readonly value="'.$resultset->multi_sqm_per_container.'"  />
													 
													</div>    
												</div> 
												<div class="form-group col-md-12"></div>
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
														Big Palate charge
													</label>
													<div class="col-sm-6">
														<input type="text" name="big_pallet_charges" id="big_pallet_charges class="form-control" onkeypress="return isNumber(event)" onkeyup="price_calaculation()" placeholder="Big Palate charge" value="'.$big_pallet_charges.'"/>
													</div>    
												</div>  
												<div class="form-group col-md-6">
													<label class="col-sm-5 control-label" for="form-field-1">
															Small Palate charge
													</label>
													<div class="col-sm-6">
														<input type="text" name="small_pallet_charges" id="small_pallet_charges" class="form-control" onkeypress="return isNumber(event)" onkeyup="price_calaculation()" placeholder="Small Palate charge" value="'.$small_pallet_charges.'" />
													</div>    
												</div> 
											</div>
											
										</div>
										
								 </div>
								 
							 </div>
							 <div class="row" style="margin-top:20px">
							 <div class="form-group col-md-6">
				        <label class="col-md-6 control-label" for="form-field-1">
								Select Currecy 
						</label>
				        <div class="col-sm-6">
								<select class="select2" name="invoice_currency_id" id="invoice_currency_id" required title="Select Currency" onchange="get_exchange_rate(this.value)">
									<option value="">Select Currency</option>';	
										 
										for($currency=0;$currency<count($currencydata);$currency++)
										{
												$select ='';
													if($currencydata[$currency]->currency_status == 1)
													{
														$select = 'selected="selected"'; 
													}
										  $str .= '<option '.$select.' value="'.$currencydata[$currency]->currency_code.'">'.$currencydata[$currency]->currency_name.'</option>';	
									 
										}
									 
								$str .= '</select>
				        </div>    
				    </div> 
					<div class="form-group col-md-6">
				        <label class="col-md-6 control-label" for="form-field-1">
								Exchange rate
						</label>
				        <div class="col-sm-6">
							<input type="text" id="exchange_rate" name="exchange_rate" placeholder="Exchange Rate" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" onblur="allcalculation()" 	value=""   required title="Enter Exchange rate" />
				        </div>    
				    </div>
								 <div class="form-group col-md-4">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Factory Price
							</label>
				        <div class="col-sm-6">
							<input type="text" name="facory_rate" id="facory_rate" class="form-control" onkeypress="return isNumber(event)" onkeyup="price_calaculation()" value="0" />
				        </div>    
				    </div>
					 
					<div class="form-group col-md-4">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Factory Price Unit
							</label>
				        <div class="col-sm-6">
							<select class="form-control" name="price_type" id="price_type" onchange="price_calaculation()" required title="Select Price Per">
								<option value="Feet" >Feet</option>
								<option value="Box">Box</option>
								<option value="SQM">SQM</option>
								<option value="PCS">PCS</option>
								</select>
				        </div>    
				    </div>
					<div class="form-group col-md-4">
				       <label class="col-sm-6 control-label" for="form-field-1">
									FOB Expense 
							</label>
				        <div class="col-sm-6">
							<input type="text" name="fob_expenenses" id="fob_expenenses" class="form-control" onkeypress="return isNumber(event)"  onkeyup="price_calaculation()" value="'.$fob_expenenses.'" />
				        </div>    
				    </div>
					<div class="form-group col-md-4">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Calculate Price Per In <span class="currency_code"></span>
							</label>
				        <div class="col-sm-6">
							<select class="form-control" name="our_price_type" id="our_price_type" onchange="price_calaculation()" required title="Select Price Per">
								<option value="SQM">SQM</option>
								<option value="Feet" >Feet</option>
								<option value="Box">Box</option>
							 	<option value="PCS">PCS</option>
								</select>
				        </div>    
				    </div>
						 
					<div class="form-group col-md-4">
				       <label class="col-sm-6 control-label" for="form-field-1">
									<span class="currency_code"></span> Cost Price
							</label>
				        <div class="col-sm-6">
							 <span id="usd_per_box_html">0.00</span>
				        </div>    
				    </div>
					
					<input type="hidden" id="total_price" name="total_price" value=""/>
					 
					<div class="col-md-12"></div>
					<div class="form-group col-md-4">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Our Selling Price
							</label>
				        <div class="col-sm-6">
							<input type="text" name="our_selling_price" id="our_selling_price" class="form-control" onkeypress="return isNumber(event)" onkeyup="our_price_calaculation()" value="0" />
				        </div>    
				    </div>
					<div class="form-group col-md-4">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Profit Price 
							</label>
				        <div class="col-sm-6">
							<input type="text" readonly name="profit_price" id="profit_price" class="form-control"  value="'.$packing_row->profit_price.'" />
				        </div>    
				    </div> 
							 </div>
						 
				  ';
				
		  }
		   echo $str;
	}
	public function insertdatanew()
	{
		$data=array(
			'size_type_mm' => $this->input->post('size_type_mm'),
			'size_type_cm' => $this->input->post('size_type_cm'),
			'size_width_mm' => $this->input->post('size_width_mm'),
			'size_width_cm' => $this->input->post('size_width_cm'),
			'size_height_mm' =>$this->input->post('size_height_mm'),
			'size_height_cm' =>$this->input->post('size_height_cm'),
			'series' => $this->input->post('seriesnew'),
			'pcsperbox' => $this->input->post('pcsperbox'),
			'apwigtperbox' => $this->input->post('apwigtperbox_new'),
			'boxperplt' => $this->input->post('boxperplt_new'),
			'nopltcontainer' => $this->input->post('nopltcontainer_new'),
			'appsqmperbox' => $this->input->post('appsqmperbox_new'),
			'appgrswetpercon' => $this->input->post('appgrswetpercon_new'),
			'appwegtpercon' => $this->input->post('appwegtpercon_new'),
			'sqmpercontain' => $this->input->post('sqmpercontain_new'),
			'boxpercontain' => $this->input->post('boxpercontain_new'),
			'plat_weight' => $this->input->post('plat_weight'),
			'sqmpercontain_new_cm' => $this->input->post('sqmpercontain_new_cm'),
			'appsqmperbox_new_cm' => $this->input->post('appsqmperbox_new_cm'),
			'hsnc_code'		 => $this->input->post('hsnc_code'),
			'sqmprice' 			 => $this->input->post('sqmprice'),
			'priceperbox' 		 => $this->input->post('priceperbox'),
			'pricetype' 		 => $this->input->post('price_type'),
			'cdate'		 => date('d-m-Y H:i:s'),
			'status' => 0
		);
		 
		if(strtolower($this->input->post('mode'))=="edit"){
			$id = $this->input->post('product_size_id');
			$rdata = $this->calc->b_edit($data,$id);
				if($rdata)
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

	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->calc->delete_calc($id);
			
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