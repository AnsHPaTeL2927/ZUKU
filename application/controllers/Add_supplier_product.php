<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_supplier_product extends CI_controller
{
	public function __construct()
	{
		parent:: __construct();
		 
		$this->load->model('supplier_list_model','supplier');
		 $this->load->model('admin_currency_list');	
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['allproduct']			= $this->supplier->allproductsize(); 
			$data['alreadyadded']		= $this->supplier->getaddedproduct($id); 
			$data['supplier_detail'] 	= $this->supplier->getsupplier_record($id); 
			$data['menu_data'] 			= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['termsdata'] 			= $this->supplier->gettermsdata(); 
			$this->load->view('admin/add_supplier_product',$data);
		}
		else
		{
			redirect(base_url().'');
		}				
	}
	public function manage()
	{
		$this->supplier->delete_supplierproduct($this->input->post('supplier_id'));
		$no=0;
		foreach($this->input->post('product_id') as $row)
		{  
			$insertid = $this->supplier->insertsupplierproduct($row,$this->input->post('supplier_id'));
			$no++;
		}
		  echo "1";
		
	}	

	public function form_edit($id){

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data['edit_record']=$this->supplier->getsupplier_record($id);
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select(); 
			$data['mode']="Edit";
			$this->load->model('admin_currency_list');	
			$data['currencydata'] = $this->admin_currency_list->getcurrencydata();
			$data['menu_data'] 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/add_supplier',$data);
		}
		else
		{
			
			redirect(base_url().'');
		}	

	}
	public function deleterecord()
	{
		$row = array();
		$deleteid =  $this->supplier->delete_onesupplierproduct($this->input->post('id'));
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else
		{
			$row['res'] = 2;
		}
		echo json_encode($row);
	}
	public function change_packing($id)
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data['edit_record']=$this->supplier->getsupplierproduct_record($id);
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select(); 
			$data['mode']="Change";
			$data['menu_data'] 	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/change_supplier_packing',$data);
		}
		else
		{
			
			redirect(base_url().'');
		}	
	}
	
	public function editproduct()
	{
		$id = $this->input->post('supplier_product_id');
		$data	=	array(
				"quotation_for" 			=> $this->input->post('person_name'),
				"quotation_terms" 			=> nl2br($this->input->post('quotation_terms')),
				"terms_id" 					=> $this->input->post('terms_id'),
				"terms_of_delivery" 		=> $this->input->post('terms_of_delivery'),
				"packing_name" 				=> $this->input->post('packing_name'),
				"invoice_currency_id" 		=> $this->input->post('invoice_currency_id'),
				"exchange_rate" 			=> $this->input->post('exchange_rate'),
				"supplier_id" 				=> $this->input->post('supplier_id'), 
				"supplier_product_id" 	 	=> $this->input->post('supplier_product_id'),
				"cdate" 	 				=> date('Y-m-d H:i:s'), 
				"status" 	 				=> 0 
		);
			$insertid = $this->supplier->insert_quotation($data);
			$no =0;
			foreach($this->input->post('product_size_id') as $row)
			{
				$data_trn=array(
					'product_size_id' 				 	=> $row,
					'quotation_id' 						=> $insertid,
					'product_id' 						=> $this->input->post('product_id')[$no],
					'pcs_per_box' 						=> $this->input->post('pcs_per_box')[$no],
					'weight_per_box' 					=> $this->input->post('weight_per_box')[$no],
					'sqm_per_box' 						=> $this->input->post('sqm_per_box')[$no],
					'feet_per_box' 						=> $this->input->post('feet_per_box')[$no],
					'boxes_per_pallet'					=> $this->input->post('boxes_per_pallet')[$no],
					'total_pallent_container' 			=> $this->input->post('total_pallent_container')[$no],
					'pallet_weight' 					=> $this->input->post('pallet_weight')[$no],
					'box_per_container' 				=> $this->input->post('box_per_container')[$no],
					'pallet_gross_weight_per_container' => $this->input->post('pallet_gross_weight_per_container')[$no],
					'pallet_net_weight_per_container' 	=> $this->input->post('pallet_net_weight_per_container')[$no],
					'sqm_per_container' 				=> $this->input->post('sqm_per_container')[$no],
					'pallet_charges' 					=> $this->input->post('pallet_charges')[$no],
					'total_boxes' 						=> $this->input->post('total_boxes')[$no],
					'withoutgross_weight_per_container' => $this->input->post('withoutgross_weight_per_container')[$no],
					'withoutnet_weight_per_container' 	=> $this->input->post('withoutnet_weight_per_container')[$no],
					'withoutpallet_sqm_per_container'  	=> $this->input->post('withoutpallet_sqm_per_container')[$no],
					'box_per_big_pallet' 				=> $this->input->post('box_per_big_pallet')[$no],
					'box_per_small_pallet' 				=> $this->input->post('box_per_small_pallet')[$no],
					'big_pallet_container' 				=> $this->input->post('big_pallet_container')[$no],
					'small_pallet_container' 			=> $this->input->post('small_pallet_container')[$no],
					'big_pallet_weight' 				=> $this->input->post('big_pallet_weight')[$no],
					'small_pallent_weight' 				=> $this->input->post('small_pallent_weight')[$no],
					'multi_box_per_container' 			=> $this->input->post('multi_box_per_container')[$no],
					'multi_gross_weight_container' 		=> $this->input->post('multi_gross_weight_container')[$no],
					'multi_net_weight_container' 		=> $this->input->post('multi_net_weight_container')[$no],
					'multi_sqm_per_container' 			=> $this->input->post('multi_sqm_per_container')[$no],
					'big_pallet_charges' 				=> $this->input->post('big_pallet_charges')[$no],
					'small_pallet_charges' 			 	=> $this->input->post('small_pallet_charges')[$no],
					'facory_rate' 					 	=> $this->input->post('facory_rate')[$no],
					'price_type' 						=> $this->input->post('price_type')[$no],
					'our_price_type' 					=> $this->input->post('our_price_type')[$no],
					'fob_expenenses' 				 	=> $this->input->post('fob_expenenses')[$no],
					'total_price' 						=> $this->input->post('total_price')[$no],
					'usd_per_box' 						=> $this->input->post('per_box_price')[$no],
					'our_selling_price' 				=> $this->input->post('our_selling_price')[$no],
					'profit_price'		 				=> $this->input->post('profit_price')[$no],
					'cdate'								=> date('d-m-Y H:i:s'),
					'status' 							=> 0
				);
					$insert_trn_id = $this->supplier->insert_quotation_trn($data_trn);
					$no++;
			}
			
				if($insertid)
				 {
					$this->load->model('admin_company_detail');	
					$get_data['q_data'] 			= $this->supplier->get_quotation_data($insertid);
					$get_data['company_detail'] 	= $this->admin_company_detail->s_select();
			 						
					$quotation_pdf =  $this->load->view("admin/supilerestimate", $get_data);
					 
				 	$row['file_name'] = 'Quotation - '.$get_data['q_data']->quotation_for.'.pdf';
					
				 	$row['res'] = 1;
				 }
				 else
				 {
				 	$row['res'] = 0;
				 }
			
          
		echo json_encode($row);
	}
	public function getsupilerestimate($id)
	{

		 if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			
			 $array = explode("-",$id);
			$data['all_record']		= $this->supplier->getsupplier_product_record($array);
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select(); 
			$data['maindetail'] 	= $this->supplier->select_config(); 
			//$data['get_price'] 	= $this->supplier->get_series(); 
			$data['mode']			= "Change";
			$data['menu_data'] 		= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['termsdata'] 		= $this->supplier->gettermsdata();
			$data['currencydata']	= $this->admin_currency_list->getcurrencydata();
		 	$this->load->view('admin/getsupilerestimate',$data);
		}
		else
		{
			
			redirect(base_url().'');
		}	
	}
	public function fetchseriesdata()
	{
		$id 		 = explode(",",$this->input->post('product_size_id'));
		$edit_record = $this->supplier->getsupplierproduct_record($id);
		$packing_row = $edit_record[0];
		$pallet_status = 0;
		$maindetail 	= $this->supplier->select_config(); 
		if($packing_row->boxes_per_pallet>0)
		{
			$checked1 = "checked";
			$pallet_status = 1;
		}
		else if($packing_row->total_boxes>0)
		{
			$checked2 = "checked";
			$pallet_status = 2;
		}
		else if($packing_row->box_per_big_plt>0 || $packing_row->box_per_small_plt_new>0)
		{
			$checked3 = "checked";
			$pallet_status = 3;
		}
		
		$currencydata			= $this->admin_currency_list->getcurrencydata();
		$fob_expenenses 		= ($packing_row->fob_expenenses > 0)?:$maindetail->fob_charges;
		$big_pallet_charges 	= ($packing_row->big_pallet_charges > 0)?:$maindetail->big_pallet_charge;
		$small_pallet_charges 	= ($packing_row->small_pallet_charges > 0)?:$maindetail->small_pallet_charges;
		$pallet_charges 		= ($packing_row->pallet_charges > 0)?:$maindetail->pallet_charges;
		$str = ' 	<div class="form-group col-md-6">
				        <label class="col-md-6 control-label" for="form-field-1">
								Select Currecy 
						</label>
				        <div class="col-sm-6">
								<select class="select2" name="invoice_currency_id" id="invoice_currency_id" required title="Select Currency" onchange="get_exchange_rate(this.value)">
									<option value="">Select Currency</option>';	
										 
										for($currency=0;$currency<count($currencydata);$currency++)
										{
											 
										  $str .= '<option value="'.$currencydata[$currency]->currency_code.'">'.$currencydata[$currency]->currency_name.'</option>';	
									 
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
					<div class="col-md-12"><hr> <strong>Packing Detail </strong></div>
					<div class="col-md-12">  &nbsp;</div>
					 <div class="form-group col-md-8">
				        <label class="col-md-4 control-label">
								With/Without Pallet 
						</label>
				        <div class="col-md-8">
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status1" value="1" onclick="check_pallet_status(this.value)"  '.$checked1.'>With Pallet 
							</label>
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet_status(this.value)"  '.$checked2.'>Without Pallet
							</label>
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status3" value="3" onclick="check_pallet_status(this.value)"  '.$checked3.'>Multi Pallet
							</label>
						 </div>    
				    </div>
					 <div class="form-group col-md-4">
				        <label class="col-md-6 control-label" for="form-field-1">
								Pcs per box
						</label>
				        <div class="col-sm-6">
							<input type="text" id="pcs_per_box" name="pcs_per_box" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="'.$packing_row->pcs_per_box.'"   />
				        </div>    
				    </div> 
				  
					<div class="form-group col-md-4 pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Boxes Per Pallet
							</label>
				        <div class="col-sm-6">
							<input type="text" id="boxes_per_pallet" name="boxes_per_pallet" placeholder="" class="form-control"  value="'.$packing_row->boxes_per_pallet.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 multi_pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Boxes Per Big Pallet
							</label>
				        <div class="col-sm-6">
							<input type="text" id="box_per_big_pallet" name="box_per_big_pallet" placeholder="" class="form-control"  value="'.$packing_row->box_per_big_plt.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 multi_pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Boxes Per Small Pallet
							</label>
				        <div class="col-sm-6">
							<input type="text" id="box_per_small_pallet" name="box_per_small_pallet" placeholder="" class="form-control"  value="'.$packing_row->box_per_small_plt_new.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									 Pallet In Container
							</label>
				        <div class="col-sm-6">
							<input type="text" id="total_pallent_container" name="total_pallent_container" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="'.$packing_row->total_pallent_container.'" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 multi_pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									 Big Pallet In Container
							</label>
				        <div class="col-sm-6">
							<input type="text" id="big_pallent_container" name="big_pallent_container" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="'.$packing_row->no_big_plt_container_new.'" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 multi_pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									 Small Pallet In Container
							</label>
				        <div class="col-sm-6">
							<input type="text" id="small_pallent_container" name="small_pallent_container" placeholder="" class="form-control"  onkeyup="allcalculation()"  value="'.$packing_row->no_small_plt_container_new.'" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Empty Pallet Weight
							</label>
				        <div class="col-sm-6">
							  <input type="text" id="pallet_weight" name="pallet_weight" placeholder="" class="form-control" value="'.$packing_row->pallet_weight.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 multi_pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Empty Big Pallet Weight
							</label>
				        <div class="col-sm-6">
							  <input type="text" id="big_pallet_weight" name="big_pallet_weight" placeholder="" class="form-control" value="'.$packing_row->big_plat_weight.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 multi_pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Empty Small Pallet Weight
							</label>
				        <div class="col-sm-6">
							  <input type="text" id="small_pallet_weight" name="small_pallet_weight" placeholder="" class="form-control" value="'.$packing_row->small_plat_weight.'"  onkeyup="allcalculation()" onkeypress="return isNumber(event)"  />
				        </div>    
				    </div>
					<div class="form-group col-md-4 boxes_calculation">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Total Boxes Per Container
							</label>
				        <div class="col-sm-6">
							  <input type="text" id="total_boxes" name="total_boxes" placeholder="" class="form-control" onkeypress="return isNumber(event)"  onkeyup="allcalculation()" value="'.$packing_row->total_boxes.'"   />
				        </div>    
				    </div>
					<div class="col-md-12"> <hr> <strong>Price Calculatation</strong></div>
					<div class="col-md-12">  &nbsp;</div>
					<div class="form-group col-md-4 pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									 Pallet Charge
							</label>
				        <div class="col-sm-6">
							<input type="text" name="pallet_charges" id="pallet_charges" class="form-control pallet_calcution" onkeypress="return isNumber(event)" onkeyup="price_calaculation()" value="'.$pallet_charges.'" />
				        </div>    
				    </div>
					<div class="form-group col-md-4 multi_pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									 Big Pallet Charge
							</label>
				        <div class="col-sm-6">
							<input type="text" name="big_pallet_charges" id="big_pallet_charges" class="form-control multi_pallet_calcution" onkeypress="return isNumber(event)" onkeyup="price_calaculation()" value="'.$big_pallet_charges.'" />
				        </div>    
				    </div>
					<div class="form-group col-md-4 multi_pallet_calcution">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Small Pallet Charge
							</label>
				        <div class="col-sm-6">
							<input type="text" name="small_pallet_charges" id="small_pallet_charges" class="form-control multi_pallet_calcution" onkeypress="return isNumber(event)" onkeyup="price_calaculation()" value="'.$small_pallet_charges.'" />
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
					<div class="col-md-12 multi_pallet_calcution"></div>
					<div class="form-group col-md-4">
				       <label class="col-sm-6 control-label" for="form-field-1">
									Factory Price Unit
							</label>
				        <div class="col-sm-6">
							<select class="form-control" name="price_type" id="price_type" onchange="price_calaculation()" required title="Select Price Per">
								<option value="">Select Price per</option> 
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
									In <span class="currency_code"></span> Per Box 
							</label>
				        <div class="col-sm-6">
							 <span id="usd_per_box_html">0.00</span>
				        </div>    
				    </div>
					
					
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
					<input type="hidden" id="size_width_mm" name="size_width_mm" value="'.$packing_row->size_width_mm.'"/>
					<input type="hidden" id="size_height_mm" name="size_height_mm" value="'.$packing_row->size_height_mm.'"/>
				 	<input type="hidden" id="weight_per_box" name="weight_per_box" value="'.$packing_row->weight_per_box.'"/>
					<input type="hidden" id="sqm_per_box" name="sqm_per_box" value="'.$packing_row->sqm_per_box.'"/>
					<input type="hidden" id="feet_per_box" name="feet_per_box" value="'.$packing_row->feet_per_box.'"/>
					<input type="hidden" id="box_per_container" name="box_per_container" value="'.$packing_row->box_per_container.'"/>
					<input type="hidden" id="multi_box_per_container" name="multi_box_per_container" value="'.$packing_row->multi_box_per_container.'"/>
					
					<input type="hidden" id="sqm_per_container" name="sqm_per_container" value="'.$packing_row->sqm_per_container.'"/>
					 
					<input type="hidden" id="pallet_net_weight_per_container" name="pallet_net_weight_per_container" value="'.$packing_row->pallet_net_weight_per_container.'"/>
					
					<input type="hidden" id="multi_gross_weight_container" name="multi_gross_weight_container" value="'.$packing_row->multi_gross_weight_container.'"/>
					<input type="hidden" id="multi_net_weight_container" name="multi_net_weight_container" value="'.$packing_row->multi_net_weight_container.'"/>
					<input type="hidden" id="pallet_gross_weight_per_container" name="pallet_gross_weight_per_container" value="'.$packing_row->pallet_gross_weight_per_container.'"/>
					<input type="hidden" id="multi_sqm_per_container" name="multi_sqm_per_container" value="'.$packing_row->multi_sqm_per_container.'"/>
					<input type="hidden" id="total_price" name="total_price" value=""/>
					 
				  ';
					 
					$row['size'] = $packing_row->series_name.' ('.$packing_row->size_type_mm.') Packing Detail : '.$packing_row->product_packing_name;
					$row['pallet_status'] = $pallet_status;
					$row['html'] = $str;
					echo json_encode($row);
	}
	public function addrow()
	{
		$no = intval($this->input->post('no'))+1;
		$get_series = $this->supplier->get_series(); 
			
		$str = '<tr id="rowtr'.$no.'">
							<td>
							<select class="select2" name="series_id" id="series_id'.$no.'"  required title="Select Series" onchange="add_new_serices(this.value,'.$no.')">
							<option value="">Select Series</option>
								<option value="0">Add New Series</option>
								';
							 
								 for($s=0;$s<count($get_series);$s++)
								 {
									 $selected = '';
									  if($get_series[$s]->series_id==$edit_record->series_id)
									 {
										 $selected = 'selected="selected"';
									 }
									$str .=' <option '.$selected.' value="'.$get_series[$s]->series_id.'">'.$get_series[$s]->series_name.'</option>';
								 } 
								 
								
							$str .='</select> </td>
							<td> 
								<input type="text" name="rate" id="rate'.$no.'" class="form-control" onkeypress="return isNumber(event)" value="" onkeyup="price_calaculation('.$no.')" />
							</td>
							<td>
							<select class="form-control" name="price_type" id="price_type'.$no.'" onchange="price_calaculation('.$no.')" required title="Select Price Per">
								<option value="">Select Price per</option> 
								<option '.$select.' value="Feet" >Feet</option>
								<option '.$select1.' value="Box">Box</option>
								<option '.$select2.' value="SQM">SQM</option>
								</select>
							</td>
							<td> 
								<input type="text" name="pallet_charges" id="pallet_charges'.$no.'" class="form-control pallet_calcution" onkeypress="return isNumber(event)" onkeyup="price_calaculation('.$no.')"  />
							</td>
							<td>
								<input type="text" name="fob_expenenses" id="fob_expenenses'.$no.'" class="form-control" onkeypress="return isNumber(event)"  onkeyup="price_calaculation('.$no.')" />
							</td>
							<td> 
								<input type="text" name="our_selling_price" id="our_selling_price'.$no.'" class="form-control" onkeypress="return isNumber(event)" onkeyup="our_price_calaculation('.$no.')"  />
							</td>
							<td> 
								<input type="text" readonly  name="profit_price" id="profit_price'.$no.'" class="form-control"  />
							</td>
							<td> 
								 <button class="btn btn-danger" onclick="remove_row('.$no.')">-</button>
							</td> 
							<input type="hidden" name="usd_per_box" id="usd_per_box'.$no.'" class="form-control"    />
							
						</tr>';
			echo $str;
	}
}
?>