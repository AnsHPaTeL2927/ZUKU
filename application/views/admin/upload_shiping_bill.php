<?php 
if(!empty($shipping_bill_data))
{
	$shipping_bill_date = date('d-m-Y',strtotime($shipping_bill_data->date));
	
}
else
{
	$shipping_bill_date = !empty($ewb_data)?date('d-m-Y',strtotime($ewb_data->shipping_date)):'';
}
$this->view('lib/header'); 
?>	
	<div class="main-container">
		<?php $this->view('lib/sidebar'); ?>
			<div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-sm-12">
							<ol class="breadcrumb">
								<li>
									<i class="clip-pencil"></i>
									<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
								</li>
								<li class="active">
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice</a>
								</li>
							 
							</ol>
							<div class="page-header">
							<h3>  Shipping Bill 
								<?php 
								if(!empty($shipping_bill_data))
								{
									?>
									<div class="pull-right">
									 <a href="javascript:;"  type="button" class="btn btn-danger" onclick="delete_shipping_bill(<?=$shipping_bill_data->id?>)">
										Delete Shipping Bill
									 </a>
									 <?php 
								if(!empty($shipping_bill_data->bl_upload))
								{
									?>
									  <a href='<?=base_url()."upload/".$shipping_bill_data->bl_upload?>' target='_blank' type="button" class="btn btn-info">
										View Shipping Bill
									 </a>
								<?php 
								}
								?>	 
									</div>
								<?php 
								}
								?>
							</h3>
							</div>
							 
						</div>
					</div>
				<form class="form-horizontal askform col-md-offset-1" action="javascript:;"  method="post" name="payment_form" id="payment_form">
               		<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Export Invoice no
						</label>
						<div class="col-sm-4">
							 <?=$exportinvoice_data->export_invoice_no?>
				        </div>
				    </div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Export Invoice Date
						</label>
						<div class="col-sm-4">
							 <?=date("d/m/Y",strtotime($exportinvoice_data->invoice_date))?>
				        </div>
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Consign Detail 
						</label>
						<div class="col-sm-4">
							 <?=$exportinvoice_data->c_companyname?>
				        </div>
				    </div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Shipping Bill no
						</label>
						<div class="col-sm-4">
							 <input type="text" name="Shipping_Bill_no" id="Shipping_Bill_no" class="form-control" placeholder="Shipping Bill no" required title="Shipping Bill no" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->shipping_bill_no:$ewb_data->shipping_bill_no?>" />
				        </div>
				    </div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Shipping Bill Date
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date" id="date" class="form-control defualt-date-picker" autocomplete="off" value="<?=$shipping_bill_date?>" placeholder="Shipping Bill Date" required title="Select Date"/>
				        </div>
				    </div> 	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Eway Bill no
						</label>
						<div class="col-sm-4">
							 <input type="text" name="ewaybill_no" id="ewaybill_no" class="form-control" placeholder="Eway Bill no"   title="Eway Bill no" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->ewaybill_no:$ewb_data->ewaybill_no?>" />
				        </div>
				    </div>

					 <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Date of Shipment
						</label>
						<div class="col-sm-4">
							 <input type="text" name="date_of_shipment" id="date_of_shipment" class="form-control defualt-date-picker" autocomplete="off"  placeholder="Date of Shipment" required title="Select Date" value="<?=!empty($shipping_bill_data)?date('d-m-Y',strtotime($shipping_bill_data->date_of_shipment)):date("d-m-Y",strtotime($exportinvoice_data->invoice_date))?>" required />
				        </div>
				    </div>
				   <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Exchange Rate
						</label>
						<div class="col-sm-4">
							 <input type="text" onkeypress="return isNumber(event)" step="0.01" name="exchange_rate" id="exchange_rate" class="form-control" placeholder="Exchange Rate" required title="Exchange Rate" autocomplete="off" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->exchange_rate:$exportinvoice_data->Exchange_Rate_val?>" onkeyup="change_value()" onblur="change_value()" onchange="change_value()"/>
				        </div>
						<div class="col-sm-4">
							As Per invoice : <strong> <i class="fa fa-inr"> </i> <?=($exportinvoice_data->Exchange_Rate_val)?></strong> Exchange Rate
						</div>
				    </div>
					<div class="form-group">
						<div class="col-sm-12">
					 <table  width="80%" cellspacing="0" cellpadding="0"  class="table table-bordered">
						<tr>
							<th class="text-center">Product Name</th>
							<th class="text-center">Size</th>
							<th class="text-center">Model Name</th>
							<th class="text-center">Finish</th>
							<th class="text-center">Amount</th>
							<th class="text-center">Drawback (%)</th>
							<th class="text-center">Drawback Amt</th>
							<th class="text-center">RODTEP(%)</th>
							<th class="text-center">RODTEP Amt</th>
						</tr>
					<?php 
					$total_drawback_amt = 0;
					$total_rodtep_amt = 0;
					if($mode == "Add")
					{
						for($i=0; $i<count($product_data);$i++)
						{	
					?>
						<tr>
							<td class="text-center"><?=$product_data[$i]->series_name?></td>
							<td class="text-center"><?=$product_data[$i]->size_type_mm?></td>
							<td class="text-center"><?=$product_data[$i]->model_name?></td>
							<td class="text-center"><?=$product_data[$i]->finish_name?></td>
							<td class="text-center"><?=$product_data[$i]->product_amt?></td>
							<td class="text-center">
								<input type="text" onkeypress="return isNumber(event)" step="any" name="drawback_per[]"  class="form-control"  id="drawback_per<?=$product_data[$i]->export_packing_id?>"  placeholder="Drawback Per" required title="Drawback Per" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->drawback_per:1.8?>" onkeyup="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)" onblur="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)" onchange="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)"/>
							</td>
							<td class="text-center">  
								<input type="text" step="0.01" name="drawback_amount[]" id="drawback_amount<?=$product_data[$i]->export_packing_id?>" class="form-control" placeholder="Drawback Amount" required title="Drawback Amount" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->drawback_amount:number_format(((($product_data[$i]->product_amt * $exportinvoice_data->Exchange_Rate_val) * 1.8) / 100),2,'.','')?>"  readonly />
							</td>
							<td class="text-center"> 
								<input type="text" onkeypress="return isNumber(event)" step="any" name="rodtep_per[]"  class="form-control"  id="rodtep_per<?=$product_data[$i]->export_packing_id?>"  placeholder="RODTEP (%)" required title="RODTEP  (%) " value="<?=!empty($shipping_bill_data)?$shipping_bill_data->rodtep_per:1?>" onkeyup="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)" onblur="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)" onchange="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)"/>
							</td>
							<td class="text-center"> 
								<input type="text" step="0.01" name="rodtep_amount[]" id="rodtep_amount<?=$product_data[$i]->export_packing_id?>" class="form-control" placeholder="RODTEP Amount" required title="RODTEP Amount" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->rodtep_amount:number_format(((($product_data[$i]->product_amt * $exportinvoice_data->Exchange_Rate_val) * 1) / 100),2,'.','')?>"   onkeyup="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)" onblur="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)" onchange="change_drawback_value(<?=$product_data[$i]->export_packing_id?>)" readonly />
							</td>
						</tr>
						<input type="hidden" name="export_packing_id[]" id="export_packing_id<?=$product_data[$i]->export_packing_id?>" value="<?=$product_data[$i]->export_packing_id?>"/>
						<input type="hidden" name="export_product_amt[]" id="export_product_amt<?=$product_data[$i]->export_packing_id?>" value="<?=$product_data[$i]->product_amt?>"/>
					<?php 
					$total_drawback_amt +=  !empty($shipping_bill_data)?$shipping_bill_data->drawback_amount:number_format(((($product_data[$i]->product_amt * $exportinvoice_data->Exchange_Rate_val) * 1.8) / 100),2,'.','');
					$total_rodtep_amt += !empty($shipping_bill_data)?$shipping_bill_data->rodtep_amount:number_format(((($product_data[$i]->product_amt * $exportinvoice_data->Exchange_Rate_val) * 1) / 100),2,'.','');
						}
					}
					else
					{
						for($i=0; $i<count($shipping_bill_data_trn);$i++)
						{
						?>
						<tr>
							<td class="text-center"><?=$shipping_bill_data_trn[$i]->series_name?></td>
							<td class="text-center"><?=$shipping_bill_data_trn[$i]->size_type_mm?></td>
							<td class="text-center"><?=$shipping_bill_data_trn[$i]->model_name?></td>
							<td class="text-center"><?=$shipping_bill_data_trn[$i]->finish_name?></td>
							<td class="text-center"><?=$shipping_bill_data_trn[$i]->product_amt?></td>
							<td class="text-center">
								<input type="text" onkeypress="return isNumber(event)" step="any" name="drawback_per[]"  class="form-control"  id="drawback_per<?=$shipping_bill_data_trn[$i]->export_packing_id?>"  placeholder="Drawback Per" required title="Drawback Per" value="<?=!empty($shipping_bill_data_trn[$i])?$shipping_bill_data_trn[$i]->drawback_per:1.8?>" onkeyup="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)" onblur="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)" onchange="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)"/>
							</td>
							<td class="text-center">  
								<input type="text" step="0.01" name="drawback_amount[]" id="drawback_amount<?=$shipping_bill_data_trn[$i]->export_packing_id?>" class="form-control" placeholder="Drawback Amount" required title="Drawback Amount" value="<?=$shipping_bill_data_trn[$i]->drawback_amount?>"  readonly />
							</td>
							<td class="text-center"> 
								<input type="text" onkeypress="return isNumber(event)" step="any" name="rodtep_per[]"  class="form-control"  id="rodtep_per<?=$shipping_bill_data_trn[$i]->export_packing_id?>"  placeholder="RODTEP (%)" required title="RODTEP  (%) " value="<?=!empty($shipping_bill_data_trn[$i])?$shipping_bill_data_trn[$i]->rodtep_per:1?>" onkeyup="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)" onblur="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)" onchange="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)"/>
							</td>
							<td class="text-center"> 
								<input type="text" step="0.01" name="rodtep_amount[]" id="rodtep_amount<?=$shipping_bill_data_trn[$i]->export_packing_id?>" class="form-control" placeholder="RODTEP Amount" required title="RODTEP Amount" value="<?=$shipping_bill_data_trn[$i]->rodtep_amount?>"   onkeyup="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)" onblur="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)" onchange="change_drawback_value(<?=$shipping_bill_data_trn[$i]->export_packing_id?>)" readonly />
							</td>
						</tr>
						<input type="hidden" name="export_packing_id[]" id="export_packing_id<?=$shipping_bill_data_trn[$i]->export_packing_id?>" value="<?=$shipping_bill_data_trn[$i]->export_packing_id?>"/>
						<input type="hidden" name="export_product_amt[]" id="export_product_amt<?=$shipping_bill_data_trn[$i]->export_packing_id?>" value="<?=$shipping_bill_data_trn[$i]->product_amt?>"/>
						<?php
						$total_drawback_amt +=  $shipping_bill_data_trn[$i]->drawback_amount;
						$total_rodtep_amt += $shipping_bill_data_trn[$i]->rodtep_amount;
						}
					}
					?>
					<tr>
						<th>&nbsp;</th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th></th>
						<th class="total_drawback_amt"><?=number_format($total_drawback_amt,0,',','')?></th>
						 <th></th>
						<th class="total_rodtep_amt"><?=number_format($total_rodtep_amt,0,',','')?></th>
					</tr>
					
					</table>
						</div>
					</div>
					

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Discount 
						</label>
						<div class="col-sm-2">
							 <input type="text" onkeypress="return isNumber(event)" step="0.01" name="discount" id="discount" class="form-control" autocomplete="off"  placeholder="Discount"  title="Discount" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->discount:$exportinvoice_data->discount?>" onkeyup="change_value()" onblur="change_value()" onchange="change_value()" />
				        </div>
						 <div class="col-sm-3">
								<input   type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Use in calc" data-off="Not Use in calc" onclick="change_value()" onchange="change_value()"  name="discount_checked" id="discount_checked" value="1" <?=!empty($shipping_bill_data->discount_checked)?"checked":""?> >
						 </div>			 
						 

				    </div> 
					 
					<?php 
					$extra_calc_name = !empty($shipping_bill_data)?$shipping_bill_data->extra_calc_name:$exportinvoice_data->extra_calc_name;
					 
					if(!empty($extra_calc_name))
					{
						?>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
						<?=$extra_calc_name?> 
						</label>
						<div class="col-sm-2">
							 <input type="text" onkeypress="return isNumber(event)" step="0.01" name="extra_calc_value" id="extra_calc_value" class="form-control " autocomplete="off"  placeholder="<?=$extra_calc_name?>"  title="<?=$extra_calc_name?>" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->extra_calc_value:$exportinvoice_data->extra_calc_amt?>" onkeyup="change_value()" onblur="change_value()" onchange="change_value()" />
				        </div>
						<div class="col-sm-3">
								<input   type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Use in calc" data-off="Not Use in calc"   onclick="change_value()" onchange="change_value()"  name="extra_checked" id="extra_checked" <?=!empty($shipping_bill_data->extra_checked)?"checked":""?>  <?=empty($shipping_bill_data)?"checked":""?> value="1">
						 </div>	
				    </div>
					 <input type="hidden" id="extra_calc_name" name="extra_calc_name" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->extra_calc_name:$exportinvoice_data->extra_calc_name?>"  />
					 <input type="hidden" id="extra_calc_opt" name="extra_calc_opt" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->extra_calc_opt:$exportinvoice_data->extra_calc_opt?>"  />
					<?php 
					}
					?>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Cerificate Amount 
						</label>
					 	<div class="col-sm-2">
							 <input type="text" step="0.01" name="certification_amount" id="certification_amount" class="form-control" placeholder="Cerificate Amount" required title="Fright Amount" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->certification_amount:number_format($exportinvoice_data->certification_charge,2,'.','')?>" onkeyup="change_value()" onblur="change_value()" onchange="change_value()"  />
				        </div>
						<div class="col-sm-3">
								<input   type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Use in calc" data-off="Not Use in calc" onclick="change_value()" onchange="change_value()"  name="cerificate_checked" id="cerificate_checked" <?=!empty($shipping_bill_data->cerificate_checked)?"checked":""?> value="1" <?=empty($shipping_bill_data)?"checked":""?> >
						 </div>	
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Fright Amount 
						</label>
					 	<div class="col-sm-2">
							 <input type="text" step="0.01" name="fright_amount" id="fright_amount" class="form-control" placeholder="Fright Amount" required title="Fright Amount" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->fright_amount:number_format($exportinvoice_data->seafright_charge,2,'.','')?>" onkeyup="change_value()" onblur="change_value()" onchange="change_value()"   />
				        </div>
						<div class="col-sm-3">
								<input   type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Use in calc" data-off="Not Use in calc"  onclick="change_value()" onchange="change_value()"  name="fright_checked" id="fright_checked" value="1" <?=!empty($shipping_bill_data->fright_checked)?"checked":""?>>
						 </div>	
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Insurance Amount 
						</label>
					 	<div class="col-sm-2">
							 <input type="text" step="0.01" name="insurance_charge" id="insurance_charge" class="form-control" placeholder="Insurance Amount" required title="Fright Amount" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->insurance_charge:number_format($exportinvoice_data->insurance_charge,2,'.','')?>"  onkeyup="change_value()" onblur="change_value()" onchange="change_value()" />
				        </div>
						<div class="col-sm-3">
								<input   type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Use in calc" data-off="Not Use in calc" onclick="change_value()" onchange="change_value()"  name="insurance_checked" id="insurance_checked" <?=!empty($shipping_bill_data->insurance_checked)?"checked":""?> value="1">
						 </div>	
				    </div>
					
					
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
						Bank Charges
						</label>
						<div class="col-sm-2">
							 <input type="text" step="0.01" name="bank_charge" id="bank_charge" class="form-control" placeholder="Insurance Amount"  title="Bank Amount" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->bank_charge:number_format($exportinvoice_data->bank_charge,2,'.','')?>"  onkeyup="change_value()" onblur="change_value()" onchange="change_value()" />
				        </div>
						<div class="col-sm-3">
								<input   type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Use in calc" data-off="Not Use in calc" onclick="change_value()" onchange="change_value()"  name="bank_charge_checked" id="bank_charge_checked" <?=!empty($shipping_bill_data->bank_charge_checked)?"checked":""?> value="1">
						 </div>		
				    </div>
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
						Courier Charges
						</label>
						<div class="col-sm-2">
							 <input type="text" step="0.01" name="courier_charge" id="courier_charge" class="form-control" placeholder="Insurance Amount"  title="Fright Amount" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->courier_charge:number_format($exportinvoice_data->courier_charge,2,'.','')?>"  onkeyup="change_value()" onblur="change_value()" onchange="change_value()" />
				        </div>
						<div class="col-sm-3">
								<input   type="checkbox" data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-on="Use in calc" data-off="Not Use in calc" onclick="change_value()" onchange="change_value()"  name="courier_charge_checked" id="courier_charge_checked" <?=!empty($shipping_bill_data->courier_charge_checked)?"checked":""?> value="1">
						 </div>		
				    </div> 
					
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
						Commission 
						</label>
						<div class="col-sm-2">
							 <input type="text" onkeypress="return isNumber(event)" step="0.01" name="commission" id="commission" class="form-control " autocomplete="off"  placeholder="Commission"  title="Commission" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->commission:$exportinvoice_data->commision_amt?>" onkeyup="change_value()" onblur="change_value()" onchange="change_value()" />
				        </div>
							
				    </div>
					
					 <div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Total Invoice Value
						</label>
						<div class="col-sm-4">
							 <input type="text" onkeypress="return isNumber(event)" step="0.01" name="total_invoice_value" id="total_invoice_value" class="form-control" placeholder="Total Invoice Value" value="<?=!empty($shipping_bill_data)?$shipping_bill_data->total_invoice_value:$exportinvoice_data->grand_total?>" onkeyup="change_drawback_value()" onblur="change_drawback_value()" onchange="change_drawback_value()"  />
				        </div>
						<div class="col-sm-4">
							Exchange Rate : <strong> <i class="fa fa-inr"> </i> <?=($exportinvoice_data->Exchange_Rate_val)?></strong> 
							&nbsp;
							INR Value : <strong><i class="fa fa-inr"> </i> <?=!empty($shipping_bill_data)?indian_number(($shipping_bill_data->total_invoice_value * $shipping_bill_data->exchange_rate)):indian_number(($exportinvoice_data->grand_total * $exportinvoice_data->Exchange_Rate_val))?></strong>  
						</div>
						
				    </div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Other Amount Drawback(%)
 						</label>
						<div class="col-sm-4">
							<input type="text" id="other_drawback_per" name="other_drawback_per" placeholder="Other Amount Drawback (*)"   class="form-control"  value="<?=!empty($shipping_bill_data)?$shipping_bill_data->drawback_per:1.8?>" onkeyup="change_value()" onblur="change_value()" onchange="change_value()"   /> 
							</div>
							 
					</div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Total Drawback Amount
						</label>
						<div class="col-sm-4">
							<input type="text" id="total_drawback_amt" name="total_drawback_amt" placeholder="Total Drawback Amount"   class="form-control"  value="<?=$shipping_bill_data->total_drawback_amt?>" /> 
							</div>
							<div class="col-sm-4">
							In INR
						
						</div>
					</div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Other Amount RODTEP(%)
 						</label>
						<div class="col-sm-4">
							<input type="text" id="other_roadtep_per" name="other_roadtep_per" placeholder="Other Amount RODTEP(*)"   class="form-control"  value="<?=!empty($shipping_bill_data)?$shipping_bill_data->rodtep_per:1?>" onkeyup="change_value()" onblur="change_value()" onchange="change_value()"   /> 
							</div>
							 
					</div>
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Total RODTEP Amount
						</label>
						<div class="col-sm-4">
							<input type="text" id="total_rodtep_amt" name="total_rodtep_amt" placeholder=" Total RODTEP Amount"   class="form-control"  value="<?=$shipping_bill_data->total_rodtep_amt?>" />  
						</div>
						<div class="col-sm-4">
							In INR
						</div>
					</div>
				 	<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Field1
						</label>
						<div class="col-sm-4">
							<input type="text" id="field1" name="field1" placeholder="Field1"   class="form-control"  value="<?=$shipping_bill_data->field1?>" />
						</div>
					</div>

					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								 Field2
						</label>
						<div class="col-sm-4">
							<input type="text" id="field2" name="field2" placeholder="Field2"   class="form-control"  value="<?=$shipping_bill_data->field2?>" />
						</div>
					</div>	
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
								Remarks
						</label>
						<div class="col-sm-4">
							 <textarea name="remark" id="remark" class="form-control" placeholder="Remarks" ><?=strip_tags($shipping_bill_data->remark)?></textarea>
				        </div>
				    </div> 
					<div class="form-group">
				        <label class="col-sm-2 control-label" for="form-field-1">
							Upload Shipping Bill
						</label>
						<div class="col-sm-4">
							 <input type="file" name="bl_upload" id="bl_upload"  class="form-control" title="Please Upload Shipping Bill"/>
				        </div>
						<div class="col-sm-4">
							<?php 
								if(!empty($shipping_bill_data->bl_upload))
								{
									echo "<a href='".base_url()."upload/".$shipping_bill_data->bl_upload."' target='_blank' class='btn btn-info'>
												<i class='fa fa-download'></i>
											</a>";
								}
							?>
							</div>
				    </div>
					<div class="col-md-offset-2">
						<div class="form-group">
							<input name="Submit" type="submit" value="Save" class="btn btn-success" />
							<button type="submit" class="btn btn-success" name="save_next_btn" value="1">
											Save & Exit
							</button>
								<a href="<?=base_url().'exportinvoice_listing'?>" class="btn btn-danger">
												Cancel
											</a>						
						</div>    	
				</div> 	
				 	<input type="hidden" id="mode" name="mode" value="<?=$mode?>"  />
					 <input type="hidden" id="export_invoice_id" name="export_invoice_id" value="<?=$export_id?>"  />
					 <input type="hidden" id="shiping_id" name="shiping_id" value="<?=$shipping_bill_data->id?>"  />
					 <input type="hidden" id="url" name="url" value="<?=$url?>"  />
					 <input type="hidden" id="shipping_file" name="shipping_file" value="<?=$shipping_bill_data->bl_upload?>"  />
					  				
				</form>
					</div>
		 	</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer'); ?>
 
<script>
calc_all_total();
change_value();
function change_value()
{
	 
	var exchange_rate = ($("#exchange_rate").val() > 0)?$("#exchange_rate").val():0;
	var discount =  ($("#discount").val() > 0)?(parseFloat($("#discount").val()) * parseFloat(exchange_rate)):0;
	var extra_calc_value =  ($("#extra_calc_value").val() > 0)?(parseFloat($("#extra_calc_value").val()) * parseFloat(exchange_rate)):0;
	var certification_amount =  ($("#certification_amount").val() > 0)?(parseFloat($("#certification_amount").val()) * parseFloat(exchange_rate)):0;
	var insurance_charge =  ($("#insurance_charge").val() > 0)?(parseFloat($("#insurance_charge").val()) * parseFloat(exchange_rate)):0;
	var fright_amount =  ($("#fright_amount").val() > 0)?(parseFloat($("#fright_amount").val()) * parseFloat(exchange_rate)):0;
	var commission =  ($("#commission").val() > 0)?(parseFloat($("#commission").val()) * parseFloat(exchange_rate)):0;
	var bank_charge =  ($("#bank_charge").val() > 0)?(parseFloat($("#bank_charge").val()) * parseFloat(exchange_rate)):0;
	var courier_charge =  ($("#courier_charge").val() > 0)?(parseFloat($("#courier_charge").val()) * parseFloat(exchange_rate)):0;
	var other_drawback_per =  ($("#other_drawback_per").val() > 0)?$("#other_drawback_per").val():0;
	var other_roadtep_per =  ($("#other_roadtep_per").val() > 0)?$("#other_roadtep_per").val():0;
 	var drawback_amount = 0;
 	var roadtap_amount 	= 0;
	if($("#discount_checked").prop('checked') == true)
	{
		var discount_drawbak = parseFloat(discount) * parseFloat(other_drawback_per) / 100;
		var discount_roadtep = parseFloat(discount) * parseFloat(other_roadtep_per) / 100;
		drawback_amount -= discount_drawbak;
		roadtap_amount -= discount_roadtep;
	}
 	if($("#extra_checked").prop('checked') == true)
	{
		var extra_calc_value_drawbak = parseFloat(extra_calc_value) * parseFloat(other_drawback_per) / 100;
		var extra_calc_value_roadtep = parseFloat(extra_calc_value) * parseFloat(other_roadtep_per) / 100;
		if($("#extra_calc_opt").val() == 1)
		{
			drawback_amount += extra_calc_value_drawbak;
			roadtap_amount 	+= extra_calc_value_roadtep;
		}
		else
		{
			drawback_amount -= extra_calc_value_drawbak;
			roadtap_amount 	-= extra_calc_value_roadtep;
		}
	}
	 
	if($("#cerificate_checked").prop('checked') == true)
	{
		var cerificate_drawbak = parseFloat(certification_amount) * parseFloat(other_drawback_per) / 100;
		var cerificate_roadtep = parseFloat(certification_amount) * parseFloat(other_roadtep_per) / 100;
		drawback_amount += cerificate_drawbak;
		roadtap_amount  += cerificate_roadtep;
	}
	if($("#insurance_checked").prop('checked') == true)
	{
		var insurance_drawbak = parseFloat(insurance_charge) * parseFloat(other_drawback_per) / 100;
		var insurance_roadtep = parseFloat(insurance_charge) * parseFloat(other_roadtep_per) / 100;
		drawback_amount += insurance_drawbak;
		roadtap_amount  += insurance_roadtep;
	}
	if($("#fright_checked").prop('checked') == true)
	{
		var fright_drawbak = parseFloat(fright_amount) * parseFloat(other_drawback_per) / 100;
		var fright_roadtep = parseFloat(fright_amount) * parseFloat(other_roadtep_per) / 100;
		drawback_amount += fright_drawbak;
		roadtap_amount  += fright_roadtep;
	}
	if($("#commision_checked").prop('checked') == true)
	{
		var commission_drawbak = parseFloat(commission) * parseFloat(other_drawback_per) / 100;
		var commission_roadtep = parseFloat(commission) * parseFloat(other_roadtep_per) / 100;
		drawback_amount += commission_drawbak;
		roadtap_amount  += commission_roadtep;
	}
	if($("#bank_charge_checked").prop('checked') == true)
	{
		var bank_charge_drawbak = parseFloat(bank_charge) * parseFloat(other_drawback_per) / 100;
		var bank_charge_roadtep = parseFloat(bank_charge) * parseFloat(other_roadtep_per) / 100;
		drawback_amount += bank_charge_drawbak;
		roadtap_amount  += bank_charge_roadtep;
	}
	if($("#courier_charge_checked").prop('checked') == true)
	{
		var courier_charge_drawbak = parseFloat(courier_charge) * parseFloat(other_drawback_per) / 100;
		var courier_charge_roadtep = parseFloat(courier_charge) * parseFloat(other_roadtep_per) / 100;
		drawback_amount += courier_charge_drawbak;
		roadtap_amount  += courier_charge_roadtep;
	}
	calc_all_total();
	drawback_amount = ($("#total_drawback_amt").val() > 0)?parseFloat($("#total_drawback_amt").val()) + parseFloat(drawback_amount):drawback_amount;
	 
	$("#total_drawback_amt").val(drawback_amount.toFixed(0));
	roadtap_amount = ($("#total_rodtep_amt").val() > 0)?parseFloat($("#total_rodtep_amt").val()) + parseFloat(roadtap_amount):roadtap_amount;
	$("#total_rodtep_amt").val(roadtap_amount.toFixed(0));
}
 
function change_drawback_value(no)
{
	 var export_product_amt = ($("#export_product_amt"+no).val() > 0)?$("#export_product_amt"+no).val():0;
	 var drawback_per = ($("#drawback_per"+no).val() > 0)?$("#drawback_per"+no).val():0;
	 var rodtep_per = ($("#rodtep_per"+no).val() > 0)?$("#rodtep_per"+no).val():0;
	  var exchange_rate = ($("#exchange_rate").val() > 0)?$("#exchange_rate").val():0;
	 if(export_product_amt > 0 )
	 {
		 var drawback_amount = ((parseFloat(export_product_amt) * parseFloat(exchange_rate)) * parseFloat(drawback_per)) / 100;
		$("#drawback_amount"+no).val(parseFloat(drawback_amount).toFixed(2));
		
		var rodtep_amount = ((parseFloat(export_product_amt) * parseFloat(exchange_rate)) * parseFloat(rodtep_per)) / 100;
		$("#rodtep_amount"+no).val(parseFloat(rodtep_amount).toFixed(2));
	  }
	  calc_all_total();
	  change_value();
}
function calc_all_total()
{
	var inps = document.getElementsByName('drawback_amount[]');
	var total_drawback_amt = 0;
	for (var i = 0; i <inps.length; i++) 
	{
		total_drawback_amt += (parseFloat(inps[i].value) > 0)?parseFloat(inps[i].value):0;
	}
	
	 $(".total_drawback_amt").html(total_drawback_amt.toFixed(0));
	 var inps1 = document.getElementsByName('rodtep_amount[]');
	var rodtep_amount = 0;
	for (var i = 0; i <inps.length; i++) 
	{
		rodtep_amount += (parseFloat(inps1[i].value) > 0)?parseFloat(inps1[i].value):0;
	}
 	
	$(".total_rodtep_amt").html(rodtep_amount.toFixed(0));
	
	//total_drawback_amt = ($("#total_drawback_amt").val() > 0)?parseFloat($("#total_drawback_amt").val()) + parseFloat(total_drawback_amt):total_drawback_amt;
	$("#total_drawback_amt").val(total_drawback_amt.toFixed(0));
 
	 
//	rodtep_amount = ($("#total_rodtep_amt").val() > 0)?parseFloat($("#total_rodtep_amt").val()) + parseFloat(rodtep_amount):rodtep_amount;
	$("#total_rodtep_amt").val(rodtep_amount.toFixed(0));
	 
}
 $('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
  
$(".select2").select2({
	width:'100%' 
})
$("#payment_form").validate({
		rules: {
			customer_id: {
				required: true
			},
			paid_amount:{
				required: true
			}
		},
		messages: {
			customer_id: {
				required: "Select Customer"
			},
			paid_amount:{
				required: "Enter Paid Amount",
				max:"Please check due amount"
			} 
		}
	});
$("#payment_form").submit(function(event) {
	event.preventDefault();
	if(!$("#payment_form").valid())
	{
		return false;
	}
	 block_page();
	 
	var postData= new FormData(this);
	 $.ajax({
            type: "post",
            url: 	root+'upload_shiping_bill/'+$("#url").val(),
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
			   if(obj.res==1)
			   {
				    $("#payment_form").trigger('reset');
				    unblock_page("success","Sucessfully Added.");
					var val = $(document.activeElement).val();
					if(val == "1")
					{
						setTimeout(function(){ window.location=root+'exportinvoice_listing'},1500);
				 	}
					else
					{
						setTimeout(function(){ window.location = root+"upload_shiping_bill/form_edit/"+obj.shipping_bill_id },1500);
					}
					
			   }
			   else if(obj.res==2)
			   {
				    $("#payment_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					var val = $(document.activeElement).val();
					if(val == "1")
					{
						setTimeout(function(){ window.location=root+'exportinvoice_listing'},1500);
				 	}
					else
					{
						setTimeout(function(){ location.reload(); },1500);
					}
					
			   }
			   else
			   {
				    unblock_page("error","Something Wrong.") 
					 
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
 function delete_shipping_bill(id)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'exportinvoice_listing/delete_shipping_bill',
              data: {
                "id"			: id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+'upload_shiping_bill/index/'+<?=!empty($shipping_bill_data)?$shipping_bill_data->export_invoice_id:$export_id?>; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function load_due_bill(val)
{
	if(val == 1)
	{
		$(".export_bill_html").show()
	}
	else{
		$(".export_bill_html").hide()
	}
}
function load_customer_bill(value)
{
	block_page();
     $.ajax({ 
           type: "POST", 
           url: root+"add_payment/fetchdata",
           data: {
					"id": value,
					"payment_recieve_type" : $("#payment_recieve_type").val()
				 }, 
           success: function (response) { 
				var obj= JSON.parse(response);
			 	if(obj.payment_recieve_type == "1")
				{
				  $(".export_bill_html").show()
				  $("#bill_id").html(obj.str)
			 	}
				else
				{
					$(".export_bill_html").hide();
					 
				}
				 	unblock_page("",""); 
		}
     }); 
}
function load_bill(value)
{
	block_page();
     $.ajax({ 
           type: "POST", 
           url: root+"add_payment/getdueamount",
           data: {"id": value}, 
           success: function (response) { 
				//console.log(response)
                
                $("#paid_amount").attr("max",response)
			 	 	unblock_page("",""); 
		}
     }); 
}
</script>

  