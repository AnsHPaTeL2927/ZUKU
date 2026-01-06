<?php 
$this->view('lib/header'); 
$company = $company_detail[0];
$export =  ($invoicedata->exporter_detail);
$performapacking_date = date('d/m/Y',strtotime($invoicedata->performa_date));
$consig_add =  ($invoicedata->consign_detail);
$consig_companyname=substr($consig_add,0,strpos($consig_add,"<br />"))."<br />";
$buyother = ($invoicedata->buyer_other_consign);
$payment_terms =  ($invoicedata->payment_terms);
$time=(!empty((int)$invoicedata->time))?date('h:i A',strtotime($invoicedata->time)):"";
$rowspan_packing  = 4; 
$currency_symbol  = ($invoicedata->currency_name=="Euro")?"&euro;":"$";
 
$rowspan_packing  = ($invoicedata->certification_charge>0)? $rowspan_packing+1:$rowspan_packing;
$rowspan_packing  = ($invoicedata->courier_charge>0)? $rowspan_packing+1:$rowspan_packing;
$rowspan_packing  = ($invoicedata->bank_charge>0)? $rowspan_packing+1:$rowspan_packing;
$rowspan_packing  = ($invoicedata->insurance_charge>0)?$rowspan_packing+1:$rowspan_packing;
$rowspan_packing  = ($invoicedata->seafright_charge>0)?$rowspan_packing+1:$rowspan_packing;
$rowspan_packing  = ($invoicedata->discount>0)?$rowspan_packing+1:$rowspan_packing;

?>
<style>
table {
	font-family: calibri;font-size:12px;
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
									<a href="javascript:void(0)">
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
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="<?=base_url('performa_invoice_pdf3/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 6</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf4/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 7</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 8 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 9 (With Other Product)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_accord/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 10</a>
												
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
								 <div id="print_content" style="margin-top:80px;">
									<div class="profile-pic">
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
			 <table width="100%" style="border-spacing: 0;" class="invoice_edit_cls">
	<tr>
		<td style="text-align: center;padding: 10px 0;" width="30%"><img src="<?=base_url().'upload/'.$company->s_image?>" style="width:150px;height:70px" /></td>
		<td  width="70%" style="padding: 10px 0;text-align: center;" > <span style="font-size:16px"><strong><?=$company->s_name?></strong></span> <BR /> <?=str_replace($company->s_name,'',$export)?> <br />
		Mobile :<?=!empty($invoicedata->sign_pi_status)?$invoicedata->contact_no:$invoicedata->e_mobile?>, Fax :- <?=$company->fax_no?>/ Email : <?=!empty($invoicedata->sign_pi_status)?$invoicedata->contact_email:$invoicedata->e_email?></td>
	</tr>
	<tr>
	  <td colspan="2" style="padding: 10px 0; text-align: center; border: 1px solid; font-weight: bold; font-size:15px;">PROFORMA INVOICE</td>
	  </tr>
	 
	 
	 
             </table>
 	
 
<table width="100%" style="border-spacing: 0; border: 1px solid;" class="invoice_edit_cls">
	<tr>
		<td colspan="7"  width="65%"><strong>Consignee</strong></td>
		<td colspan="3" style="border-left: 1px solid;border-bottom: 1px solid;"><strong>DATE:</strong> <?=date('d.F.Y',strtotime($invoicedata->performa_date))?> </td>
	</tr>
	<tr>
		<td colspan="7" rowspan="4" >
			<?=$consig_add?>
		</td>
		<td colspan="3" style="border-left: 1px solid;border-bottom: 1px solid;"><strong>INVOICE NO.:</strong> <?=$invoicedata->invoice_no?></td>
	</tr>
	<tr>
	 	<td colspan="3" style="border-left: 1px solid;border-bottom: 1px solid;"><strong>CURRENCY:</strong>
          <?=$invoicedata->currency_name?></td>
	</tr>
	<tr>
	 	<td colspan="3" style="border-left: 1px solid;  "><strong>SETTLEMENT:</strong> <?=$invoicedata->terms_name?>  <?=$invoicedata->terms_of_delivery?>
			  <?=($invoicedata->pallet_status  == 0)?"With Pallet":"Without Pallet"?>
</td>
	</tr>
	<tr>
	  <td colspan="3" style="border-left: 1px solid;  "><strong>PAYMENT:</strong>
        <?=$invoicedata->payment_terms?></td>
	  </tr>
	 
	 
	 
	<tr style="background: yellow;font-size: 16px; font-weight: bold;">
			<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">PHOTO</td>
			<td style="padding: 20px 0;border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">DESIGN</td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">CUSTOMER DESIGN NAME</td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">SIZE</td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">BRAND BOX</td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">PALLET</td>
		<td style="border-bottom: 1px solid #000;text-align: center;">QUANTITY<br/>(BOXS)</td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;border-left: 1px solid #000;text-align: center;">QUANTITY<br/>(m2)</td>
		<td style="padding: 20px 0;border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">PRICE FOB<br/>MUNDRA ($)</td>
		<td style="padding: 20px 0;border-bottom: 1px solid #000;text-align: center;">AMOUNT<br/>(USD)</td>
	</tr>
		<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$no_of_row = 5;
								 $series_name_array = array();
								$water_array = array();
								$size_array = array();
								for($i=0; $i<count($product_data);$i++)
								{ 
											 if(!in_array(trim($product_data[$i]->series_name),$series_name_array))
												{
													array_push($series_name_array,$product_data[$i]->series_name);
													
												}
												if(!in_array(trim($product_data[$i]->water_text),$water_array))
												{
												array_push($water_array,$product_data[$i]->water_text);
												}
												 if(!in_array($product_data[$i]->size_type_mm,$size_array))
												 {
														array_push($size_array,$product_data[$i]->size_type_mm);
													   $size_array[$product_data[$i]->size_type_mm]['size_type_mm'] = $product_data[$i]->size_type_mm;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] = $product_data[$i]->no_of_pallet;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_big_pallet;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_small_pallet;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_boxes'] = $product_data[$i]->no_of_boxes;
													   $size_array[$product_data[$i]->size_type_mm]['no_of_sqm'] = $product_data[$i]->no_of_sqm;
												 }
												 else
												 {
													 $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_pallet;
													 $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_big_pallet;
													 $size_array[$product_data[$i]->size_type_mm]['no_of_pallet'] += $product_data[$i]->no_of_small_pallet;
													 $size_array[$product_data[$i]->size_type_mm]['no_of_boxes'] += $product_data[$i]->no_of_boxes;
													 $size_array[$product_data[$i]->size_type_mm]['no_of_sqm'] += $product_data[$i]->no_of_sqm;
												 }
												 
									 $Total_plts 	+= $product_data[$i]->total_no_of_pallet;
									
									 $Total_ammount += $product_data[$i]->total_product_amt;
									 $Total_weight  += $product_data[$i]->total_gross_weight;
									 $n = 1;
								 
								  foreach($product_data[$i]->packing  as $packing_row)
								  {
									  $per = $packing_row->per;
									  $sqm = '';
									  if($per == "Sq.Ft")
									  {
										  $sqm = $packing_row->no_of_sqm * 10.76;
										   $Total_sqm 	+= $sqm;
									  }
									  else
									  {
										  $sqm = $packing_row->no_of_sqm;
										   $Total_sqm 	+= $sqm;
									  }
								?>
							
	<tr style="font-size: 16px; font-weight: bold;">
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">
												 
													 	<p style="margin: 0 auto; width:150px;height:107px;overflow:hidden">
											  <img src="<?=(!empty($packing_row->design_file))?DESIGN_PATH.$packing_row->design_file:DESIGN_PATH.'No-image-found.jpg'?>" style="width:140px"/> 
											 </p>
		</td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;"><?=$packing_row->model_name?>
          <br />
          <?=$packing_row->finish_name?>          <br /></td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;"><?=$packing_row->client_name?></td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;"><?=$product_data[$i]->size_type_mm?></td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;"><?=$packing_row->barcode_no?></td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;">
		<?php 
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
										<?=$no_of_pallet?>
										
		</td>
		<td style="border-bottom: 1px solid #000;text-align: center;"><?=$packing_row->no_of_boxes?></td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;border-left: 1px solid #000;text-align: center;"><?=number_format($packing_row->no_of_sqm,2)?></td>
		<td style="border-bottom: 1px solid #000;border-right: 1px solid #000;text-align: center;"><?=$currency_symbol?><?=number_format($packing_row->product_rate,2)?></td>
		<td style="border-bottom: 1px solid #000;text-align: center;"><?=$currency_symbol?><?=number_format($packing_row->product_amt,2)?></td>
	</tr>
								  <?php }
								}
								  ?>
 <tr style="text-align: center;  font-size: 12px;">
		<td colspan="7" style="padding: 10px 0; border-bottom: 1px solid; text-align:center">
		Description : Finishing Ceramics, <?=implode(",",$series_name_array)?> / Water Absorption is below 0.50%  </td>
		<td colspan="2" style="border-left: 1px solid; border-right:1px solid; border-bottom: 1px solid;"><strong>TOTAL(USD):</strong></td>
		<td style="border-bottom: 1px solid;text-align: center;"><strong><?=$currency_symbol?><?=number_format($Total_ammount,2)?></strong></td>
	</tr>
	<?php 
	if($invoicedata->bank_charge > 0)
	{
	?>
	<tr style="text-align: center;  font-size: 12px;">
		<td colspan="7" style="padding: 10px 0; border-bottom: 1px solid; text-align:center">
		  </td>
		<td colspan="2" style="border-left: 1px solid; border-right:1px solid; border-bottom: 1px solid;"><strong>OTHER CHARGE(USD):</strong></td>
		<td style="border-bottom: 1px solid;text-align: center;"><strong><?=$currency_symbol?><?=number_format($invoicedata->bank_charge,2)?></strong></td>
	</tr>
		<?php 
	}
	 
	 if(!empty($invoicedata->extra_calc_name))
	{
	?>
	<tr style="text-align: center;  font-size: 12px;">
		<td colspan="7" style="padding: 10px 0; border-bottom: 1px solid; text-align:center">
		  </td>
		<td colspan="2" style="border-left: 1px solid; border-right:1px solid; border-bottom: 1px solid;"><strong><?=$invoicedata->extra_calc_name?> (<?=($invoicedata->extra_calc_opt == 1)?'+':'-'?>)</strong></td>
		<td style="border-bottom: 1px solid;text-align: center;"><strong><?=$currency_symbol?><?=number_format($invoicedata->extra_calc_amt,2)?></strong></td>
	</tr>
		<?php 
	}
	 
	if($invoicedata->discount > 0)
	{
	?>
	<tr style="text-align: center;  font-size: 12px;">
		<td colspan="7" style="padding: 10px 0; border-bottom: 1px solid; text-align:center">
		  </td>
		<td colspan="2" style="border-left: 1px solid; border-right:1px solid; border-bottom: 1px solid;"><strong>DISCOUNT(USD):</strong></td>
		<td style="border-bottom: 1px solid;text-align: center;"><strong><?=$currency_symbol?><?=number_format($invoicedata->discount,2)?></strong></td>
	</tr>
		<?php 
	}
	?>
	<tr style="text-align: center; font-size: 12px; font-weight: bold;">
		<td colspan="7"   style=" border-bottom: 1px solid;text-align:center"><?=$invoicedata->container_details?> containers</td>
		<td colspan="2" style=" text-align: center;border-left: 1px solid; border-right:1px solid; border-bottom: 1px solid;">GRAND TOTAL FOB(USD):</td>
		<td style="border-bottom: 1px solid;text-align: center;"><?=$currency_symbol?><?=number_format($invoicedata->grand_total,2)?></td>
	</tr>
	 
	<tr style=" font-size: 12px; font-weight: bold;">
		<td colspan="10" style=" border-bottom: 1px solid; text-transform: uppercase;">TOTAL : <?=ucwords(convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name))?> ONLY</td>
	</tr>
	 
	<tr style=" ont-size: 14px;">
		
        <td colspan="10" style=" border-bottom: 1px solid;">
        <strong>Bank Information: </strong> <br /> <strong>Beneficiary : Olwin Tiles (India) Pvt. Ltd.</strong><br />
		  Company Add: N.H. 8 - A ,New Jambudiya, Morbi - 363 642. Dist: Rajkot, Gujarat. INDIA		<br />
		  BANK : <?=$invoicedata->bank_name?><br />
          ADD : <?=strip_tags($invoicedata->bank_address)?><br />
          A/C NO. <?=$invoicedata->account_no?><br />
          SWIFT CODE:    <?=$invoicedata->swift_code?>
		   </td>
	</tr>
	 
	  
	 
	 
	 <?php 
	 if($invoicedata->remarks!='')
	 {
		 ?>
	<tr style=" font-size: 12px;">
		<td colspan="10" style="border-bottom: 1px solid #000;"> Remarks:  <BR /><?=$invoicedata->remarks?></td>
	</tr>
    <?php
	 }
	 ?>
	 
	 
	<tr>
		
<td colspan="5" align="left" valign="top">
		Buyer, <?=$invoicedata->c_companyname?><br>
		
		 <br><br><br><br>
		<br>  
		</td>
		<td colspan="5" align="right">
		For, <?=$company->s_name?><br>
		
		<img src="<?=base_url().'upload/'.$company->s_c_sign?>" width="<?=$company->s_c_sign_width?>" height="<?=$company->s_c_sign_height?>">
		<br> <?=strtoupper($company->authorised_signatury)?>
		</td>
		
	</tr>
	 
</table>

									 <?php
								}
								?>
											</div>		 
										</div>
									<?php
								 
									 $output = ob_get_contents(); 
									 $_SESSION['performa_invoice_no'] = $invoicedata->invoice_no.' - '.$invoicedata->container_size.' X '.$invoicedata->container_details.' FCL';
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
			"performa_invoice_pdf"	: 'performa_invoice_olwin_pdf'
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
			"invoice_table_name"	: 'performa_invoice_olwin_pdf'  
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