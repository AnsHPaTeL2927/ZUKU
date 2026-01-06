<?php 
$this->view('lib/header'); 
$company = $company_detail[0];
$export =  ($invoicedata->exporter_detail);
$performapacking_date = date('d.m.Y',strtotime($invoicedata->performa_date));
$consig_add =  ($invoicedata->consign_detail);
$buyother = ($invoicedata->buyer_other_consign);
$payment_terms =  ($invoicedata->payment_terms);
$time=(!empty((int)$invoicedata->time))?date('h:i A',strtotime($invoicedata->time)):"";
$consigee_companyname=substr($consig_add,0,strpos($consig_add,"<br />"))."<br />";
$locale='en-US'; //browser or user locale
$currency=$invoicedata->currency_code; 
$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
  
$certification_charge = ($invoicedata->certification_charge>0)? $currency_symbol.' '.$invoicedata->certification_charge:'';
$courier_charge = ($invoicedata->courier_charge>0)? $currency_symbol.' '.$invoicedata->courier_charge:'';
$bank_charge = ($invoicedata->bank_charge>0)? $currency_symbol.' '.$invoicedata->bank_charge:'';
$certification_charge = ($invoicedata->certification_charge>0)? $currency_symbol.' '.$invoicedata->certification_charge:'';
$insurance_charge = ($invoicedata->insurance_charge>0)?$currency_symbol.' '.$invoicedata->insurance_charge:'';
$seafright_charge = ($invoicedata->seafright_charge>0)?$currency_symbol.' '.$invoicedata->seafright_charge:'';
$final_total = $invoicedata->grand_total;
$discount = ($invoicedata->discount>0)?$currency_symbol.' '.$invoicedata->discount:'';
  if($invoicedata->grand_total != '')
  { 
    $amountword = convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name);
  }
 
  else{
    $amountword = 'Zero';
  }
  $invoicevalue_say = $invoicedata->terms_name;
   
?>
<style>
table {
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	page-break-inside:avoid;
}
table.packing{
	
}
td {
 	border: 0.5px solid #333;
	padding: 5px; 
}
th {
 	border: 0.5px solid #333;
	padding: 3px; 
}
  .profile-pic {
	position: relative;
	 
	padding: 2px;
}

.profile-pic:hover .edit {
	display: block;
	
}
.profile-pic:hover
{
	border: 1px solid #036df0;
}
.edit {
	padding-top: 7px;	
	padding-right: 7px;
	position: fixed;
	right: 13px;
 	display: none;
}

.edit a {
	color: blue;
}
</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"performa_invoice_pdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"performa_invoice_pdf/view_pdf";
	}
	
}
</script>
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
									PDF
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>Proforma Invoice
									 <div class="pull-right ">
								
									<div class="dropdown" style="float:left;">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu">
											 <li>
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="<?=base_url('performa_invoice_pdf/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 1 (With Finish)</a>	
											 
												<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('performa_invoice_pdf/index_withoutfinish/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="<?=base_url('performa_invoice_pdf/index_withthickness/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="<?=base_url('performa_invoice_pdf1/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="<?=base_url('performa_invoice_pdf2/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>										
												
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf4/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 6</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 7 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 8 (With Other Product)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_accord/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 9</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_olwin/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 10</a>	
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf11/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 11 (Without Pallet)</a>
											 </li>											 
											</ul>
										</div>&nbsp;
									
										 <a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									 </div>
								</h3>
								
							 </div>
						 </div>
					</div>
				 <div class="row">
						<div class="col-sm-12">
						<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
										<a href="<?=base_url()?>invoice/form_edit/<?=$invoicedata->performa_invoice_id?>">Edit Proforma Invoice</a>
								</div>
                                <div class="">
								<div class="panel-body form-body">
								<?php 
								if(!empty($invoice_html_data))
								{
									echo '<div class="pull-right">
											<a class="btn btn-danger tooltips" data-title="Delete" href="javascript:;"  onclick="delete_editable('.$invoicedata->performa_invoice_id.')"   ><i class="fa fa-trash"></i> Delete (Edited version)</a>
										</div>	
										';
								}
								?>
								 <?php ob_start();?>
								 
									<div class="profile-pic" style="margin-top:80px;">
										<div class="edit pull-right">
											<a href="javascript:;" style="color:#fff;font-size:12px" class="invoice_edit_btn btn btn-primary" onclick="editable_table();"><i class="fa fa-pencil fa-lg"></i>  Edit</a>
											<a href="javascript:;" class="invoice_update_btn btn btn-success" style="display:none;color:#fff" onclick="edit_invoice();">Save</a>
										</div>
									<div class="save_invoice_html">
									<?php 
								
								if(!empty($invoice_html_data))
								{
									echo $invoice_html_data->invoice_html;
								}
								else
								{
									?>
						 	      <table border="1" width="100%" cellspacing="0" cellpadding="0" class="invoice_edit_cls">
										<tr>
											<td colspan="2" bgcolor="#CCCCCC" style="text-align:left;font-weight: BOLD;">Manufacturer and Exporter :</td>
											<td bgcolor="#CCCCCC" style="text-align:left;font-weight: BOLD;">Proforma invoice No.: <?=$invoicedata->invoice_no?>		
  &nbsp;&nbsp;Date : &nbsp;<strong>
  <?=$performapacking_date?>
</strong></td>
										</tr>
										 
										<tr>
											<td  width="25%" style="vertical-align:top">
												 
												<strong><?=$company->s_name?> </strong>
      <?=str_replace($company->s_name,'',$export)?>

Email:
<?=$invoicedata->e_email?><br />
Tel:
  <?=$invoicedata->e_mobile?>
  <br />
  I.E. CODE NO  :  
  <?=$company_detail[0]->s_iec?>
   
										  </td>
											<td  width="25%" style="vertical-align:top;border-left:hidden"><img src="<?=base_url().'upload/'.$company_detail[0]->s_image?>" width="110">&nbsp;</td>
											<td align="left" style="text-align:left;" valign="top" >
											<strong>Consignee/Buyer's Details:
										     </strong><br />
										    <strong>
										    <?=$consigee_companyname?>
										    </strong>
                                            <?=str_replace($consigee_companyname,'',$consig_add)?>
                                            &nbsp;</td>
										</tr>
										<tr>
										  <td  style="vertical-align:central;text-align:center"><strong> PORT OF LOADING </strong></td>
										  <td   style="vertical-align:central;text-align:center"><strong>PORT OF DISCHARGE </strong></td>
										  <td bgcolor="#CCCCCC" style="text-align:left;" ><strong>Notify Party</strong></td>
										</tr>
										<tr>
										  <td style="vertical-align:central;text-align:center"><?=strtoupper($invoicedata->port_of_loading)?></td>
										  <td style="vertical-align:central;text-align:center"><?=strtoupper($invoicedata->port_of_discharge)?></td>
										  <td rowspan="2" valign="top" style="text-align:left;"><?php 
				if($invoicedata->buyer_other_consign!='')
				{?>
                                            <?php
					echo $invoicedata->buyer_other_consign;
					  }
				?>
                                          &nbsp; </td>
										</tr>
										<tr>
										  <td style="vertical-align:central;text-align:center;" ><strong>FINAL DESTINATION </strong></td>
										  <td style="vertical-align:central;text-align:center"><strong>COUNTRY OF FINAL DESTINATION </strong></td>
								    </tr>
										<tr>
										  <td style="vertical-align:top;text-align:center"> 
										    <?=$invoicedata->final_destination?>
										  </td>
										  <td style="vertical-align:top;text-align:center"><?=strtoupper($invoicedata->country_final_destination)?></td>
										  <td style="vertical-align:top;text-align:center"><strong>No. of Containers :                                          
									      </strong>										    <?php 							
if(!empty($invoicedata->container_twenty))
{
 echo $invoicedata->container_twenty.' X 20 FCL';
}								if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
{
echo ',';
}
if(!empty($invoicedata->container_forty))
{
echo $invoicedata->container_forty.' X 40 FCL';
}
?></td>
								    </tr>
										
                                        
									</table>
									<table cellspacing="0" cellpadding="0" style="" width="100%" border="1" class="invoice_edit_cls">
										<tr>
										  <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">SR NO.</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Size</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Finish</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Product Name</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Pallets</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total Boxes</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Total SQ MTR</td>
									      <td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;">Rate / Sqm (<?=strtoupper($invoicedata->currency_name)?>)</td>
										   <td style="text-align:center;font-weight:bold;border-bottom: none;">Amount (<?=strtoupper($invoicedata->currency_name)?>)</td>
							 	      </tr>
									  <tr>
										  <td colspan="9" style="vertical-align:top;text-align:center">  
										   <?php
								$hsn_array=array();
								$water_array=array();
	  							for($j=0; $j<count($product_data);$j++)
								{ 
								 
											if(!in_array($product_data[$j]->water_text,$water_array))
											{												
												array_push($water_array,$product_data[$j]->water_text);
											}
											if(!in_array($product_data[$j]->series_name.' - HSN CODE '.$product_data[$j]->hsnc_code,$hsn_array))
											{												
												array_push($hsn_array,$product_data[$j]->series_name.' - HSN CODE '.$product_data[$j]->hsnc_code);
											}
								}
								 
										?>
										  
										  <?=implode(",",$hsn_array)?><br>
										  <?=implode(",",$water_array)?>
										  </td>
								    </tr>
										 
								<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$no_of_row = 8;
								  $no = 1;
								for($i=0; $i<count($product_data);$i++)
								{ 
									 
									 $Total_plts 	+= $product_data[$i]->total_no_of_pallet;
									 $Total_box 	+= $product_data[$i]->total_no_of_boxes;
									 $Total_sqm 	+= $product_data[$i]->total_no_of_sqm;
									 $Total_ammount += $product_data[$i]->total_product_amt;
									 $Total_weight  += $product_data[$i]->total_gross_weight;
									 $n = 1;
								
								  foreach($product_data[$i]->packing  as $packing_row)
								  {
									 
								?>
									<tr>
									  <td style="text-align:center;border-right: none;"><?=$no?></td>
										<td style="text-align:center;border-right: none;"><?=$product_data[$i]->size_type_mm?></td>
										<td style="text-align:center;border-right: none;"><?=$packing_row->finish_name?></td>
										<td style="text-align:center;border-right: none;"><?=$packing_row->model_name?></td>
										<td style="text-align:center;border-right: none;"><?php 
											if($packing_row->no_of_pallet>0)
											{
											 	$no_of_pallet = $packing_row->no_of_pallet;
												 
											}
											else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet)
											{
												$no_of_pallet =  $packing_row->no_of_big_pallet.'<br>'.$packing_row->no_of_small_pallet;
										 	}
											else
											{
												 $no_of_pallet =  '-';
											}
										?>
                                        <?=$no_of_pallet?></td>
										<td style="text-align:center;border-right: none;"><?=$packing_row->no_of_boxes?></td>
										<td style="text-align:center;border-right: none;"><?=number_format($packing_row->no_of_sqm,2,'.','')?></td>
										
										<td style="text-align:center;border-right: none;"><?=$currency_symbol?><?=number_format($packing_row->product_rate,2)?></td>
										<td style="text-align:center;"><?=$currency_symbol?><?=number_format($packing_row->product_amt,2,'.','')?></td>
									</tr>
								<?php
								$Total_box += $category->packing_boxes;
								$total_product_sqmlm += $category->packing_sqmlm;
								 
								 $no_of_row--;
								 $no++;
								}
								}
								for($row=$no_of_row;$row>0;$row--)
								{	 
								?>
								<tr>
								  <th style="text-align:center;border-top:none;border-bottom:none">&nbsp;</th>
									<th style="text-align:center;border-top:none;border-bottom:none" height="55">&nbsp;</th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
									<th style="text-align:center;border-top:none;border-bottom:none"></th>
								</tr>
								<?php }  ?>
								 
			 					 <tr>
										<td colspan="4" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Total &gt;&gt;&gt;&gt;&gt;</td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"><?=($Total_plts == 0)?"-":$Total_plts?></td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none; text-align:center"><?=$Total_box?></td>
										<td  style="text-align:right;font-weight:bold;border-bottom: none;border-right: none; text-align:center"><?=number_format($Total_sqm,2,'.','')?></td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($Total_ammount,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
									if($invoicedata->certification_charge > 0)
									{
								 ?>
									 <tr>
										<td colspan="7" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Certification Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->certification_charge,2,'.','')?> 
										</td>
								 </tr>
								 
								 <?php 
								 } 
								 if($invoicedata->insurance_charge > 0)
								 {
								 ?>
									 <tr>
										<td colspan="7" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Insurance Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->insurance_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->seafright_charge > 0)
								 {
								 ?>
									 <tr>
									 	<td colspan="7" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Seafright Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->seafright_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->courier_charge > 0)
								 {
								 ?>
									 <tr>
									 	<td colspan="7" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Courier Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->courier_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								  if(!empty($invoicedata->extra_calc_name))
								 {
								 ?>
									 <tr>
										<td colspan="7" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"><?=$invoicedata->extra_calc_name?> (<?=($invoicedata->extra_calc_opt == 1)?'+':'-'?>)</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?> <?=number_format($invoicedata->extra_calc_amt,2,'.',',')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								 if($invoicedata->bank_charge > 0)
								 {
								 ?>
									 <tr>
										<td colspan="7" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Bank Charge</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->bank_charge,2,'.','')?> 
										</td>
								 </tr>
								 <?php
								 } 
								 if($invoicedata->discount > 0)
								 {
								 ?>
									 <tr>
										<td colspan="7" style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;"> </td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Discount</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->discount,2,'.','')?> 
										</td>
								 </tr>
								 <?php 
								 } 
								 
								 ?>
								 <tr>
										<td colspan="7" style="text-align:center;border-bottom: none;border-right: none;font-weight:bold"><strong>WORDS IN USD:- </strong>
										  <?=strtoupper(convertamonttousd($Total_ammount,$invoicedata->currency_name))?> 
ONLY</td>
										<td style="text-align:right;font-weight:bold;border-bottom: none;border-right: none;">Total <?=$invoicedata->terms_name?> Value</td>
									 	<td style="text-align:center;font-weight:bold;border-bottom: none;"><?=$currency_symbol?><?=number_format($invoicedata->grand_total,2,'.','')?> 
										</td>
								 </tr>
								  
								 <tr>
								   <td colspan="9" style="border-right:1px soild" valign="top" align="center"><strong>TERMS OF DELIVERY AND PAYMENT</strong>
								      : <?=$invoicedata->payment_terms?> 
								     <?=$invoicevalue_say?>
                                     <?=strtoupper($invoicedata->terms_of_delivery)?>
                                     (
                                     <?=strtoupper($invoicedata->currency_name)?>
                                     )  
                                     <?php 
				if($invoicedata->other_referance!='')
				{?>
                                   <?php
					echo $invoicedata->other_referance;
					  }
				?></td>
								   </tr>
								 <tr>
								   <td colspan="9" style="border-right:1px soild" valign="top"><?php
								    if($invoicedata->remarks!='') 
									{ 
									?>
                                    <strong>Note :</strong> <br />
                                     <?=$invoicedata->remarks?>&nbsp;
									 <?php
									  } 
									  ?></td>
								   </tr>
								 <tr>
								   <td colspan="9" align="left" style="border-right:1px soild;vertical-align:text-top"><strong>BANK INFORMATION <br />
							       BANK NAME : </strong>
                                     <?=$bank->bank_name?>
                                     <br />
                                     <strong>ADDRESS : </strong>
                                     <?=$bank->bank_address?>
                                     <br />
                                     <strong> Beneficiary Name : : </strong>
                                     <?=$bank->account_name?>
                                     <br />
                                     <strong>A/C. NO. : </strong>
                                     <?=$bank->account_no?>
                                     <br />
                                     <strong>SWIFT CODE : </strong>
                                   <?=$bank->swift_code?></td>
								   </tr>
								 <tr>
								   <td colspan="9" align="left" style="border-right:1px soild;vertical-align:text-top">Declaration : We declare that this Proforma Invoice shows the actual price of the Goods described and that all particualrs are true and correct&nbsp;</td>
								   </tr>
								
								<tr>
										<td colspan="5" align="left" style="border-right:1px soild;vertical-align:text-top;border-bottom:hidden"><strong>FOR Consignee</strong><br>
									    </td>
										
								   <td colspan="2" rowspan="2" align="left" style="border-right:1px soild;vertical-align:text-top"><br />
							       <br /></td>
								   <?php 
								 if(!empty($invoicedata->sign_pi_status))
								 {
								 ?>
								   <td colspan="2" rowspan="2" align="right" style="border-left:hidden;vertical-align:top;"><strong>For ,
                                       <?=$invoicedata->for_signature_name?>
								   </strong><br/>
									 <img src="<?=base_url().'upload/user/'.$invoicedata->sign_image?>" height="76px" width="145px">
													    <br/>
									 <?=$invoicedata->authorised_signatury?>
									 <br />
									 </td>
									 <?php
								}
								else
								{
								?>	
									<td colspan="2" rowspan="2" align="right" style="border-left:hidden;vertical-align:top;">
										<strong>For , <?=$company->s_name?> </strong><br/>
									 <img src="<?=base_url().'upload/'.$company->s_c_sign?>" width="<?=$company->s_c_sign_width?>" height="<?=$company->s_c_sign_height?>">
													    <br/>
									 <?=$company->authorised_signatury?>
									 <br />
									 </td>
								<?php 
								 }
								 
								?>	
								 </tr>
								 <tr>
								   <td colspan="5" align="left" style="border-right:1px soild;vertical-align:text-bottom;font-weight:bold"><br /><br /><br /><br /><?=$company->authorised_signatury?></td>
								   </tr>
								 <tr>
								   <td colspan="9" style="border-right:1px soild;text-align:center">ALL GOODS ARE INDIAN ORIGIN&nbsp;</td>
								   </tr>									 
					              </table>
	 <?php
								}
								?>
											</div>		 
										</div>
									<?php
								 
									 $output = ob_get_contents(); 
									 $_SESSION['performa_invoice_no'] = $invoicedata->invoice_no.' - '.$invoicedata->country_final_destination.' - '.date('d-m',strtotime($invoicedata->performa_date));
									 $_SESSION['performa_content'] = $output;
									  if($mode=="1")
									 {
										 echo "<script>view_pdf(0)</script>";
									 }
								?>
						 		
								</div>
							 	</div>
							 
						</div>
					 
					</div>
 
				</div>
			</div>
				
		</div>
 
<?php $this->view('lib/footer'); ?>
<script src="<?=base_url()?>adminast/assets/js/jquery.table2excel.js"></script>
<script>
function delete_editable(performa_invoice_id)
{
	Swal.fire({
  title: 'Delete Editable Version?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
		 if (result.value) {
	block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"performa_invoice_pdf/delete_editable",
       data:
	   {
			"performa_invoice_id"	: performa_invoice_id,
			"performa_invoice_pdf"	: 'performa_invoice_pdf3'
	   }, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
  }
		});
}
function editable_table()
{
	$(".invoice_edit_cls").attr("contenteditable",true)
	$(".invoice_edit_btn").hide();
	$(".invoice_update_btn").show();
}
function edit_invoice()
{
	 block_page();
	  
     $.ajax({ 
       type: "POST", 
       url: root+"customerinvoiceview/performa_html_update",
       data:
	   {
			"performa_invoice_id"	: <?=$invoicedata->performa_invoice_id?>, 
			"invoice_html"			: $(".save_invoice_html").html(),  
			"invoice_table_name"	: 'performa_invoice_pdf3'  
		}, 
       success: function (response)
	   {
			 unblock_page("success","invoice Updated"); 
			setTimeout(function(){ location.reload(); },1000);
	   }
       
  }); 
}
 function Export() {
      $(".main_table").table2excel({
          filename:  "<?=$invoicedata->invoice_no?>.xls",
		  sheetName: "PI",
      });
  }
</script>