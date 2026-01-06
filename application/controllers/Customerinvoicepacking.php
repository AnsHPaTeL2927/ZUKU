<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Customerinvoicepacking extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
	 	$this->load->model('Customer_invoice_model','custinvoice');
		$this->load->model('admin_exportinvoice_product');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		  { 
			$data= $this->custinvoice->get_invoice_data($id);
			 $array 				= explode("-",$data->export_invoice_id);
			  
			$datap = $this->admin_exportinvoice_product->getinvoice_cust_data($array,1,$data->consiger_id);
		 
		 	$this->load->model('admin_company_detail');
			$userdata = $this->custinvoice->ciadmin_login();	
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
						
			$v = array(
				'invoicedata'		=> $data,
				'product_data'		=> $datap,
				'direct_invoice' 	=> $data->direct_invoice,  
				'menu_data'			=> $menu_data,
				'company_detail'	=> $this->admin_company_detail->s_select(),
		 		'container_data'	=> $container_data,
				'userdata'			=> $userdata
				);
			$this->load->view('admin/customerinvoicepacking',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	function manage(){
		$no=0;
		  $step = ($this->input->post('export_step')==2)?3:$this->input->post('export_step');
			 
			$stepupdate = $this->custinvoice->customer_invoice_stepupdate($this->input->post('customer_invoice_id'),$step,0);
		 $row['res'] = "1";
		echo json_encode($row);

	}
	public function update_export()
	{
		$export_data = array(
			'certification_charge'=> $this->input->post('certification_charge'),
			'insurance_charge'=> $this->input->post('insurance_charge'),
			'seafright_charge'=> $this->input->post('seafright_charge'),
			'discount'=> $this->input->post('discount'),
			'export_under'=> $this->input->post('export_under'),
			'epcg_licence_no'=> $this->input->post('epcg_licence_no'),
			'grand_total'=> $this->input->post('grand_total'),
			'Exchange_Rate_val'=>$this->input->post('Exchange_Rate_val'),
			'remarks'=>$this->input->post('remarks'),
			'supplier_gstib'=>$this->input->post('supplier_gstib'),
			'supplier_invoice_no'=>$this->input->post('supplier_invoice_no'),
			'indian_ruppe_val'=>$this->input->post('indian_ruppe_val'),
			'indian_ruppe_after_gst'=>$this->input->post('aftergst_indian_ruppe_val'),
			);
			$export_data['step'] = ($this->input->post('step')==3)?$this->input->post('step'):2;
			$export_data_update_id = $this->export->updateexport($export_data,$this->input->post('export_invoice_id'));
		echo 1;
	}
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$deleterecord = $this->export->delete_sampleproduct($id);	
		$deletetrnrecord = $this->export->delete_sampletrnproduct($id);	
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
		$data = array(
			'allproduct_id'=> implode(",",$this->input->post('allvalues')),
			'invoice_id'=> $this->input->post('performainvoice_id'),
			'container_count'=> 1,
			'status'=> 0 
			);
			$insertid = $this->pinv->insert_makecontainer($data);
			echo  "1";
			 
	}
	public function displaydataproduct()
	{
		$id=$this->input->post('id');
		 
		$userdata = $this->export->ciadmin_login();
		$contentdata='';
		$countdata = $this->export->hsncproductsizedetail($id,1);
		 if($countdata>0)
		 {
			 $mode = $this->input->post('mode');
			 $no_of_container = $this->input->post('no_of_container');
			 if(strtolower($mode)=="add")
			 {
					$data = $this->export->hsncproductsizedetail($id,2);
					$result=$data[0];
					$checked1 =  ($result->pallet_status==1)?"checked":"";
					$checked2 =  ($result->pallet_status==2)?"checked":"";
					$hsnc_code = $data[0]->hsnc_code;
					$hsncdata = $this->export->hsncproductcodedetail($hsnc_code);
					$hsnc = $hsncdata[0]->p_name;
					$hsncsize = $hsncdata[0]->size_type;
					$size_name=$result->size_type_mm;
					$description_goods =$hsnc.' - HSNC'.$hsnc_code.' - '.$size_name;
					$price=$result->sqmprice;
					$usd=$price/$userdata->usd;
					$euro=$price/$userdata->euro;
					$Total_Amount=$usd*$result->sqmpercontain;
					if($usd == '' || $usd == '0')
					{
						$usdprice;
						$totalprice;
					}
					else
					{
						$usdprice = number_format((float)$usd, 2, '.', '');
						$totalprice = number_format((float)$Total_Amount, 2, '.', '');
					}
					$totalweight = $result->boxpercontain * (int)$result->apwigtperbox;
					$total_boxes = $result->total_box;
					$Plts = $result->boxperplt;
					$orignal_box_per_pallent = $result->boxperplt;
					$total_pallet = $result->nopltcontainer;
					$orignal_total_pallet = $result->nopltcontainer;
					$appoxweightperbox = $result->apwigtperbox;
					$pallet_weight = $result->plat_weight;
					$sqmpercontain =  $result->sqmpercontain;
					$total_box_per_container = $result->boxpercontain;
					$approxsqmperbox = $result->appsqmperbox;
					$pcsperbox = $result->pcsperbox;
					$total_weight = $result->appwegtpercon;
					$total_pallet_weight = ($result->plat_weight*$result->nopltcontainer);
					$grossweight = $result->appgrswetpercon;
					$total_container = 1;
					$container_checked ='checked';
			 }
			 else if(strtolower($mode)=="edit")
			 {
				 $id = $this->input->post('exportproduct_trn_id');
				 $productsize_id = $this->input->post('id');
				 $fetchproductresult = $this->export->fetchproductrecord($id);
				 $checked1 =  ($fetchproductresult->pallet_status==1)?"checked":"";
				 $checked2 =  ($fetchproductresult->pallet_status==2)?"checked":"";
				 $description_goods = $fetchproductresult->description_goods;
				 $Plts = $fetchproductresult->Plts;
				 $orignal_box_per_pallent = $fetchproductresult->orignal_box_per_pallent;
				 $total_pallet = $fetchproductresult->total_pallet;
				 $orignal_total_pallet = $fetchproductresult->orignal_total_pallet;
				 $appoxweightperbox = $fetchproductresult->apwigtperbox;
				 $pallet_weight = $fetchproductresult->pallet_weight;
				 $usdprice = $fetchproductresult->Rate_In_USD;
				 $data = $this->export->hsncproductsizedetail($productsize_id,2);
				 $hsnc_code = $data[0]->hsnc_code;
				 $hsncdata = $this->export->hsncproductcodedetail($hsnc_code);
				 $hsnc = $hsncdata[0]->p_name;
				 $hsncsize = $hsncdata[0]->size_type;
				 $sqmpercontain =  $fetchproductresult->SQM;
				 $total_boxes = $fetchproductresult->total_box;
				 $total_box_per_container = $fetchproductresult->Boxes;
				 $approxsqmperbox = $fetchproductresult->appsqmperboxes;
				 $pcsperbox = $fetchproductresult->pcsperbox;
				 $total_weight = $fetchproductresult->Total_weight;
				 $total_pallet_weight = $fetchproductresult->total_pallet_weight;
				 $grossweight = $fetchproductresult->grossweight;
				 $totalprice = $fetchproductresult->Total_Amount;
				 $container_checked = ($fetchproductresult->container_check==1)?'checked':'';
				 $total_container = ($fetchproductresult->container_check==1)?$fetchproductresult->product_container:'0.5';
			 }
			$contentdata .= '
					<div class="col-md-12">
						<div class="field-group">
							<textarea id="description_goods" name="description_goods" placeholder="Description of Goods" class="form-control" required="" title="Enter Description of Goods" style="height:50px;" >'.$description_goods.'</textarea>
						</div>    
				    </div>  
					<div class="col-md-12">
						<div>
							With/Without Pallet :
							
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status1" value="1" '.$checked1.' onclick="check_pallet_status(this.value)"  />With Pallet 
							</label>
							<label class="radio-inline">
								<input type="radio" name="pallet_status" id="pallet_status2" value="2" onclick="check_pallet_status(this.value)" '.$checked2.' />Without Pallet
							</label>
						</div>    
				    </div>
					<div class="col-md-6">					
						<div class="field-group">
							<lable class="col-md-12" >Total Container</lable>
								<div class=" col-md-4">
								<input onchange="change_container()" value="1" type="checkbox" id="container_check" name="container_check" '.$container_checked.' data-toggle="toggle" data-on="Full" data-off="Multi">
								</div>
								<div class=" col-md-6">
								<input type="text" id="total_container" name="total_container" placeholder="Total Container" required="" class="form-control" required="" value="'.$total_container.'" max="'.$no_of_container.'" title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="change_container()" />
								</div>
								
						</div>                     
					</div> 					
					<div class="col-md-6 boxes_calculation">					
						<div class="field-group">
							<lable>Total Boxes</lable>
								<input type="text" id="total_boxes" name="total_boxes" placeholder="Total Boxes" required="" class="form-control" required="" value="'.$total_boxes.'" title="Enter Total Boxes" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()" />
						</div>                     
					</div> 
					<div class="col-md-6 pallet_calcution">					
						<div class="field-group">
							<lable>Boxes Per Pallet	</lable>
								<input type="text" id="Plts" name="Plts" placeholder="Plts" required="" class="form-control" required="" value="'.$Plts.'" title="Enter Boxes Per Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()" />
								<input type="hidden" id="boxes_per_pallet" name="boxes_per_pallet" value="'.$orignal_box_per_pallent .'" />
						</div>                     
					</div> 
					<div class="col-md-12 pallet_calcution"></div>
					<div class="col-md-6 pallet_calcution">
				     <div class="field-group">
				    	<lable>No Of Pallet In Container</lable>
				        <input id="total_pallet" type="text" name="total_pallet" placeholder="Total Pallet" required="" class="form-control" value="'.$total_pallet.'" title="Enter Total Pallet" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()" />
						<input type="hidden" id="pallet_in_container" name="pallet_in_container" value="'.$orignal_total_pallet.'" />
				    </div>     
				    </div>                    
				     
				   <div class="col-md-6">					
				     <div class="field-group">
				    	<lable>Weight Per Box </lable>
				         <input type="text" id="apwigtperbox" name="apwigtperbox" placeholder="" class="form-control"  value="'.$appoxweightperbox.'" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()"  /> 

				    </div>                     
				    </div> 
					<div class="col-md-6 pallet_calcution">					
				     <div class="field-group">
				    	<lable>Empty Pallet Weight</lable>
				        <input id="pallet_weight" type="text" name="pallet_weight" placeholder="Pallet Weight" required="" class="form-control" value="'.$pallet_weight.'" title="Enter Pallet Weight" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()"  />
				    </div>                     
				    </div>                     
				   <div class="col-md-6">

				    <div class="field-group">
				    <lable>Rate In USD</lable>
				        <input type="number" id="Rate_In_USD" name="Rate_In_USD" placeholder="Rate In USD" class="form-control" required value="'.$usdprice.'"" title="Enter Rate" onkeypress="return isNumber(event)" onkeyup="cal_product_invoice()"  />    
				    </div> 
				    </div>
					<div class="col-md-12"></div>	
					<div class="col-md-6">	
						<div class="field-group">
								<strong>HSNC Code </strong>: '.$hsnc_code.'
							<input type="hidden" id="hsnc_code_val" name="hsnc_code_val" value="'.$hsnc_code.'"/>
							<input type="hidden" id="hsnc_code_value" name="hsnc_code_value" value="'.$hsnc_code.'" >
						</div>					
					</div>
					<div class="col-md-6">	
						<div class="field-group">
							<lable><strong>Per</strong> : '.$hsncsize.'</lable>
								<input type="hidden" id="Per" name="Per"  value="'.$hsncsize.'"/>    
						</div> 
						</div>						
						<div class="col-md-6">	
						 <div class="field-group">
								<lable><strong>Total Box Per Container</strong> : <span id="boxes_html">'.$total_box_per_container.'</span></lable>
								<input id="Boxes" type="hidden" name="Boxes"  required=""  value="'.$total_box_per_container.'" />
								<input id="appsqmperboxes" type="hidden" name="appsqmperboxes"  class="form-control" value="'.$approxsqmperbox.'"/>
								<input id="pcsperbox" type="hidden" name="pcsperbox"  class="form-control" value="'.$pcsperbox.'"/>
								 
						</div>
						</div>
						<div class="col-md-6">					
						 <div class="field-group"> 
								<lable>
									<strong>SQM Per Container</strong> : 
									<span id="sqm_html">'.$sqmpercontain.' </span>
								</lable>
								<input type="hidden" id="SQM" name="SQM" value="'.$sqmpercontain.'"/>    
						</div> 
						</div> 						
						<div class="col-md-6">	
						 <div class="field-group">
							<lable><strong>Net Weight</strong> : <span id="totalweight_html">'.$total_weight.'</span></lable>
								<input type="hidden" id="Total_weight" name="Total_weight" value="'.$total_weight.'"/>    
						</div> 
						</div>
						<div class="col-md-6 pallet_calcution">	
						 <div class="field-group">
							<lable><strong>Total Empty Pallet Weight</strong> : <span id="Pallet_Weight_html">'.$total_pallet_weight.'</span></lable>
								<input type="hidden" id="total_pallet_weight" name="total_pallet_weight" value="'.$total_pallet_weight.'"/>    
						</div> 
						</div>						
						<div class="col-md-6">	
						 <div class="field-group">
							<lable><strong>Gross Weight</strong> : <span id="grossweight_html">'.$grossweight.'</span></lable>
								<input type="hidden" id="grossweight" name="grossweight" value="'.$grossweight.'"/>    
						</div> 
						</div>
						
						<div class="col-md-6">	
						 <div class="field-group">
							<lable><strong>Total Amount</strong> : <span id="totalprice_html">'.$totalprice.'</span></lable>
								<input type="hidden" id="Total_Amount" name="Total_Amount"   value="'.$totalprice.'"/>    
							</div> 
						</div> 
				    </div>';
		 }
		 echo $contentdata;
	}
	public function getproduct_data()
	{
	 	$data=$this->export->getproductdata($this->input->post('product_size_id'));
		echo json_encode($data);
	}
}
