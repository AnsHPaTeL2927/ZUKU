<?php 
$this->view('lib/header'); 
$company = $company_detail[0];
$export =  ($invoicedata->exporter_detail);
$performapacking_date = date('d/m/Y',strtotime($invoicedata->performa_date));
$consig_add =  ($invoicedata->consign_detail);
$buyother = ($invoicedata->buyer_other_consign);
$payment_terms =  ($invoicedata->payment_terms);
$time=(!empty((int)$invoicedata->time))?date('h:i A',strtotime($invoicedata->time)):"";

$consigee_companyname=substr($consig_add,0,strpos($consig_add,"<br />"))."<br />";
$currency_symbol = ($invoicedata->currency_name=="Euro")?"&euro;":"$";
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
  
  
  ////////////////////////////////////PI FORMATING VARIABLES
   
  $colorcode1='#d2d3d3';
  $colorcode2='#575757';
  $colorcode3='#575757';
  $colorcode4='#ffffff';
  $logo1h=100;
  $logo1w=100;
  $logo2h=48;
  $logo2w=100;
  $signh=75;
  $signw=75;

   
  $colorcode1=$company->colorcode1;
  $colorcode2=$company->colorcode2;
  $colorcode3=$company->colorcode3;
  //$logo1h=$company->logo1h;
  $logo1w=$company->logo1w;
  $logo2h=$company->logo2h;
  $logo2w=$company->logo2w;
  $signh=$company->signh;
  //$signw=$company->signw;

  
  
  
  /////////////////////////////////////////END OF VARIABLES
   
?>
<style>
/*table {
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
}*/
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
									 <div class="pull-right">
									
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
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 8 (With Other Product)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_accord/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 9</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_olwin/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 10 </a>	
												
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
								 <div class="profile-pic" style="margin-top:80px;">
										<div class="edit pull-right">
											<a href="javascript:;" style="color:#fff;font-size:12px" class="invoice_edit_btn btn btn-primary" onclick="editable_table();"><i class="fa fa-pencil fa-lg"></i>  Edit</a>
											<a href="javascript:;" class="invoice_update_btn btn btn-success" style="display:none;color:#fff" onclick="edit_invoice();">Save</a>
										</div>
									<div class="save_invoice_html">
									 <?php ob_start();?>
									<?php 
								
								if(!empty($invoice_html_data))
								{
									echo $invoice_html_data->invoice_html;
								}
								else
								{
									?>
								 <style>
body {
	/*-webkit-print-color-adjust: exact !important;*/
}
 
.clearfix:after {
	content: "";
	display: table;
	clear: both;
}
a {
	color: #58595b;
	text-decoration: none;
}
table {
	border:0;
	 
}
.table1 {
	color: #58595b;
	background: #FFFFFF;
	 
	font-size: 10px;
	 
	border:none !important;
	border-collapse: inherit !important;
	margin-bottom:0px !important;
}
/*.table1 td {
	border:none !important;
}*/

.table-borderless tbody+tbody, .table-borderless td, .table-borderless th, .table-borderless thead th {
    border: 0;
}

.frame-bdr {
	background:#575757;
}

.top-heading {
	font-size: 32px;
	 
	font-weight:700;
	 
}
.light-bg {
	background: <?=$colorcode1?>;
}
.dark-bg {
	background: <?=$colorcode2?>;
}
.light-color-text {
	color: <?=$colorcode2?>;
}
.dark-color-text {
	color: <?=$colorcode2?>;
}
.light-bdr {
	background:<?=$colorcode1?>;
}
.dark-bdr {
	background:<?=$colorcode2?>;
}
.bdr-box {
	height:2px;
}
.font-11 {
	font-size: 11px;
}
.font-12 {
	font-size: 12px;
}
.font-13 {
	font-size: 13px;
}
.font-14 {
	font-size: 14px;
}
.font-bold {
	font-family: RobotoBold;
	font-weight:700;
}
.lbg-text-color {
	color:<?=$colorcode3?>;
	letter-spacing: 0.5px;
}
.lbg-text-color span {
	font-family: RobotoBold;
	font-weight:700;
}
.dbg-text-color {
	color:<?=$colorcode3?>;
	letter-spacing: 0.5px;
}
.pad0 {
	padding:0px;
}
.pad5 {
	padding: 5px;
}
.pad10 {
	padding: 10px;
}
.pad15 {
	padding: 15px;
}
.margin10 {
	    margin: auto 0px;
}
.whitebg {
	background:#ffffff;
}
.greybg1 {
	background: #f2f3f3;
}
.greybg2 {
	background: #f8f9fa;
}
.greybg3 {
	background: #d2d3d3;
}
.text-capital {
	text-transform: uppercase;
}
.tiles-img {
	margin-right: 5px;
}
</style>
<table class="table1 table-borderless invoice_edit_cls" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" class="frame-bdr">
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="whitebg margin10">
  <tr>
    <td class="whitebg pad15">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="210"><img src="<?=base_url().'upload/'.$company->s_image?>" alt="" width="<?=$logo1w?>" height="<?=$logo1h?>"></td>
          <td>&nbsp;</td>
          <td width="270" align="right" valign="bottom" class="top-heading dark-color-text"><strong>Proforma Invoice</strong></td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td width="210" align="left" valign="middle" class="font-12 light-bg lbg-text-color pad10" bgcolor="<?=$colorcode1?>">Date<br>
            <?=date('d.m.Y',strtotime($invoicedata->performa_date))?></td>
          <td align="left" valign="middle" class="font-12 light-bg lbg-text-color pad10">Invoice No<br>
            <?=$invoicedata->invoice_no?></td>
          <td width="270" align="left" valign="middle" class="font-12 dark-bg dbg-text-color pad10"><span>Exporter's Ref. :</span><br>
            IEC Code: 
              <?=$company->s_iec?>
              <br>
            GSTIN No: 
            <?=$company->s_gst?></td>
        </tr>
      </table>
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td class="pad10 greybg1">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="170" class="font-bold font-13 light-color-text"><strong>Consignee :</strong></td>
                <td width="10">&nbsp;</td>
                <td align="left" valign="top" class="font-12"><?php 
				if($invoicedata->buyer_other_consign!='')
				{?>
                  <span class="font-bold font-13 light-color-text">Notify:</span> 
                  <?php
					 
					  }
				?></td>
                <td width="80">&nbsp;</td>
                <td width="190" class="font-bold font-13 light-color-text"><strong>Exporter :</strong></td>
                <td width="10">&nbsp;</td>
                <td width="190" class="font-bold font-13"><span class="font-bold"><strong>Bank Details</strong></span></td>
                </tr>
              
              <tr>
                <td align="left" valign="top" class="font-12"><strong><?=$consigee_companyname?></strong>
     

	 <?=str_replace($consigee_companyname,'',$consig_add)?></td>
                <td align="left" valign="top" class="font-12">&nbsp;</td>
                <td align="left" valign="top" class="font-12"><?php 
				if($invoicedata->buyer_other_consign!='')
				{?>
                   
                  <?php
					echo $invoicedata->buyer_other_consign;
					  }
				?></td>
                <td align="left" valign="top" class="font-12">&nbsp;</td>
                <td align="left" valign="top" class="font-12"><strong><?=$company->s_name?> </strong>
      <?=str_replace($company->s_name,'',$export)?>
Tel:
  <?=$invoicedata->e_mobile?>
  <br />
Email:
<?=$invoicedata->e_email?></td>
                <td align="left" valign="top" class="font-12">&nbsp;</td>
                <td align="left" valign="top" class="font-12">
                  Bank Name: 
                  <?=$bank->bank_name?>
                  <br>
                  A/c No.: 
                  <?=$bank->account_no?>
                  <br>
                  Swift Code: 
                  <?=$bank->swift_code?>
                  <br>
                  Bank Add.: 
                  <?=$bank->bank_address?></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
            </table>
          <table width="100%" border="0" cellspacing="0" cellpadding="2">
              <tr>
                <td align="center" valign="middle" class="greybg3 font-12 font-bold ">No. of Containers</td>
                <td align="center" valign="middle" width="2"></td>
                <td align="center" valign="middle" class="greybg3 font-12 font-bold ">Origin of goods</td>
                <td align="center" valign="middle" width="2"></td>
                <td align="center" valign="middle" class="greybg3 font-12 font-bold ">Port of Loading</td>
                <td align="center" valign="middle" width="2"></td>
                <td align="center" valign="middle" class="greybg3 font-12 font-bold ">Port of Discharge</td>
                <td align="center" valign="middle" width="2"></td>
                <td align="center" valign="middle" class="greybg3 font-12 font-bold ">Final Destination</td>
              </tr>
              <tr>
                <td align="center" valign="middle" class="greybg2"><?php 							
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
                <td align="center" valign="middle" width="2"></td>
                <td align="center" valign="middle" class="greybg2 font-12"><?=$invoicedata->country_origin_goods?></td>
                <td align="center" valign="middle" width="2"></td>
                <td align="center" valign="middle" class="greybg2 font-12"><?=$invoicedata->port_of_loading?></td>
                <td align="center" valign="middle" width="2"></td>
                <td align="center" valign="middle" class="greybg2 font-12"><?=$invoicedata->port_of_discharge?></td>
                <td align="center" valign="middle" width="2"></td>
                <td align="center" valign="middle" class="greybg2 font-12"><?=$invoicedata->final_destination?></td>
              </tr>
            </table>
            </td>
        </tr>
      </table>
	   <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
          <td height="2" align="left" valign="middle" class="pad0 light-bdr bdr-box" ></td>
          <td width="290" align="left" valign="middle" class="pad0 dark-bdr bdr-box"></td>
        </tr>
        <tr>
          <td height="5" colspan="2"></td>
        </tr>
      </table>
      
      <table class="font-12" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="40%" align="left" valign="middle" class="light-bg font-bold lbg-text-color font-13 pad5">Item Description</td>
          <td width="1%" align="left" valign="middle"></td>
          <td width="26%" align="left" valign="middle" class="light-bg font-bold lbg-text-color font-13 pad5">Packing Details</td>
          <td width="1%" align="left" valign="middle"></td>
          <td width="10" align="center" valign="middle" class="dark-bg font-bold dbg-text-color font-13 pad5">Qty Sqr. </td>
          <td width="1%" align="left" valign="middle"></td>
          <td width="10" align="center" valign="middle" class="dark-bg font-bold dbg-text-color font-13 pad5">Price Sqr.</td>
          <td width="1%" align="left" valign="middle"></td>
          <td width="10%" align="right" valign="middle" class="dark-bg font-bold dbg-text-color font-13 pad5">Total</td>
        </tr>
		<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
								$stringcolor=array();
								$container_order_by=0;
								$no_of_row = 8;
								$srno = 1;
								$hsn_array = array();
								$performa_trn_array = array();
								for($j=0; $j<count($product_data);$j++)
								{ 
									 
									 $Total_plts 	+= $product_data[$j]->total_no_of_pallet;
									 $Total_box 	+= $product_data[$j]->total_no_of_boxes;
									 $Total_sqm 	+= $product_data[$j]->total_no_of_sqm;
									 $Total_ammount += $product_data[$j]->total_product_amt;
									 $Total_weight  += $product_data[$j]->total_gross_weight;
									 $Total_net_weight 	+= $product_data[$j]->total_net_weight;
								  
											if(!in_array($product_data[$j]->series_name,$hsn_array))
											{												
									?>
										<tr>
											<th colspan="6" al align="left"><?=$product_data[$j]->series_name?> HSN CODE - <?=$product_data[$j]->hsnc_code?></th>
										</tr>
									<?php 
												 array_push($hsn_array,$product_data[$j]->series_name);
											}
									for($i=0; $i<count($product_data);$i++)
									{ 
										$n = 1;
										if($product_data[$i]->series_name==$product_data[$j]->series_name && !in_array($product_data[$i]->performa_trn_id,$performa_trn_array))
										{
										
								     foreach($product_data[$i]->packing  as $packing_row)
								    {
										
										if($product_data[$i]->product_container == 0)
										{
											$checkedcontainer='';
											$explodeproduct=array();
											$string='';
											$disabled = '';
										 	for($a=0;$a<count($container_data);$a++)
											{
												if(!in_array($container_data[$a]->allproduct_id,$explodeproduct))
												{
													$string .= $container_data[$a]->allproduct_id.',';
													array_push($explodeproduct,$container_data[$a]->allproduct_id);
													$no_of_product_array = explode(",",$container_data[$a]->allproduct_id);
													
													if(in_array($product_data[$i]->performa_trn_id,$no_of_product_array))
													{		
														$rowspan =  count(explode(",",$container_data[$a]->allproduct_id));
														
													}
												}
										 	}
										  	$string = array_filter(explode(",",$string));
										 	if(in_array($product_data[$i]->performa_trn_id,$string))
											{
												 $checkedcontainer ='checked="checked"';
												 $disabled ='disabled';
												 $deletestatus=1;
											}
										 array_push($button_check_array,$product_data[$i]->performa_trn_id);
										}
											
											?>
                                            
                                            <tr>
          <td align="left" valign="middle" class="greybg2 pad5 middle">
          <table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td width="35%" valign="middle" align="left">
															<p style="margin: 0 auto;width:100px;height:100px;overflow:hidden">
																<img src="<?=DESIGN_PATH.$packing_row->design_file?>" width="90"  alt="" class="tiles-img">
															</p>
												
																</td>
																<td width="2"></td>
					<td width="65%" valign="middle" align="left" class="font-12">
						
							Design Name : <?=$packing_row->model_name?> <br>
							Finish :<?=$packing_row->finish_name?><br>
							Size :<?=$product_data[$i]->size_type_mm?>
							<?=!empty($product_data[$i]->thickness)?'<br>
							Thinkness :'.$product_data[$i]->thickness.' MM':""?> 
							</td>
				</tr>
</table>
		 </td>
          <td align="left" valign="middle"></td>
          <td align="left" valign="middle" class="greybg2 pad5" style="text-align:left">
			Pallets : <span class="font-bold">
				<?php 
											 	if($packing_row->no_of_pallet>0)
												{
													$product_plts = $packing_row->no_of_pallet;
													
												}
												else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet>0)
												{
													$product_plts  =  $packing_row->no_of_big_pallet.'/'.$packing_row->no_of_small_pallet;
												}
												else
												{
													$product_plts = '-';
												}
											?><?=$product_plts?></span><br>
            Box / Pallate : <span class="font-bold"><?php 
													if($product_data[$i]->no_of_pallet>0)
													{
														$product_plts = $product_data[$i]->boxes_per_pallet;
														
													}
													else if($product_data[$i]->no_of_big_pallet > 0 || $product_data[$i]->no_of_small_pallet >0 )
													{
														$product_plts  =  $product_data[$i]->box_per_big_pallet.'/'.$product_data[$i]->box_per_small_pallet;
													}
													else
													{
														$product_plts = '-';
													}
												?><?=$product_plts?></span><br>
            Total Box : <span class="font-bold"><?=$packing_row->no_of_boxes?></span></td>
          <td align="left" valign="middle"></td>
          <td align="center" valign="middle" class="greybg2 font-bold pad5">
			<?=$packing_row->no_of_sqm?>
		 </td>
          <td align="left" valign="middle"></td>
          <td align="center" valign="middle" class="greybg2 font-bold pad5"><?=$currency_symbol?><?=number_format($packing_row->product_rate,2)?></td>
          <td align="left" valign="middle"></td>
          <td align="right" valign="middle" class="greybg2 font-bold pad5"><?=$currency_symbol?><?=number_format($packing_row->product_amt,2)?></td>
        </tr>
        <tr>
          <td height="4" colspan="9" align="left" valign="middle"></td>
        </tr>
                                            
                                            
         
        <?php 
									$no_of_row--;
									$srno++;
									$n++;
										}
										 array_push($performa_trn_array,$product_data[$i]->performa_trn_id);
									}
								}
								   
								}
								
								for($r=0;$r<$no_of_row;$r++)
								{
								 	?>
                                     <tr>
											<td align="left" valign="middle"  >&nbsp; </td>
											<td align="left" valign="middle"></td>
											<td align="left" valign="middle"  > </td>
											<td align="left" valign="middle"></td>
											<td align="center" valign="middle"  > </td>
											<td align="left" valign="middle"></td>
											<td align="center" valign="middle"> </td>
											<td align="left" valign="middle"></td>
											<td align="right" valign="middle"> </td>
									</tr>
         <tr>
          <td height="4" colspan="9" align="left" valign="middle"></td>
        </tr>
                                      <?php
								}
								?>
       
        
      
         
      </table>
      <table class="font-12" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td align="left" valign="top"><table class="font-13" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td height="10"></td>
              </tr>
              <tr>
                <td><span class="light-color-text"><strong>Weight</strong></span><br>
                  Net Weight : <?=number_format($Total_net_weight,2)?> Kgs  Gross Weight : <?=number_format($Total_weight,2)?> Kgs</td>
              </tr>
              <tr>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td><span class="light-color-text"><strong>Amount in Words</strong></span><br>
                  <?=strtoupper(convertamonttousd($invoicedata->grand_total,$invoicedata->currency_name))?> ONLY</td>
              </tr>
            </table></td>
          <td align="right" valign="top" width="380"><table class="font-13" width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="100" align="center" valign="middle" class="greybg1 font-bold pad5">Sub Total -</td>
                <td width="2" align="left" valign="middle"></td>
                <td width="100" align="right" valign="middle" class="greybg1 font-bold pad5"><?=$currency_symbol?>
                  <?=number_format($Total_ammount,2)?></td>
              </tr>
              <tr>
                <td height="4" colspan="3" align="left" valign="middle"></td>
              </tr>
              <?php 
								if($invoicedata->certification_charge > 0)
								{
								?>
              <tr>
                <td align="center" valign="middle" class="greybg1 font-bold pad5 font-14">Certification Charges</td>
                <td align="left" valign="middle"></td>
                <td align="right" valign="middle" class="greybg1 font-bold pad5 font-14"><?=$currency_symbol?>
                  <?=number_format($invoicedata->certification_charge,2)?></td>
              </tr>
               <tr>
                <td height="4" colspan="3" align="left" valign="middle"></td>
              </tr>
              <?php
								}
								?>
                                
                                <?php 
								if($invoicedata->insurance_charge > 0)
								{
								?>
              <tr>
                <td align="center" valign="middle" class="greybg1 font-bold pad5 font-14">Insurance Charges</td>
                <td align="left" valign="middle"></td>
                <td align="right" valign="middle" class="greybg1 font-bold pad5 font-14"><?=$currency_symbol?>
                  <?=number_format($invoicedata->insurance_charge,2)?></td>
              </tr>
               <tr>
                <td height="4" colspan="3" align="left" valign="middle"></td>
              </tr>
              <?php
								}
								?>
              
               <?php 
								if($invoicedata->seafright_charge > 0)
								{
								?>
               <tr>
                <td align="center" valign="middle" class="greybg1 font-bold pad5 font-14">Seafreight Charges</td>
                <td align="left" valign="middle"></td>
                <td align="right" valign="middle" class="greybg1 font-bold pad5 font-14"><?=$currency_symbol?>
                  <?=number_format($invoicedata->seafright_charge,2)?></td>
              </tr>
               <tr>
                <td height="4" colspan="3" align="left" valign="middle"></td>
              </tr>
              <?php
								}
								?>
                                 <?php 
								if($invoicedata->courier_charge > 0)
								{
								?>
               <tr>
                <td align="center" valign="middle" class="greybg1 font-bold pad5 font-14">Courier Charge</td>
                <td align="left" valign="middle"></td>
                <td align="right" valign="middle" class="greybg1 font-bold pad5 font-14"><?=$currency_symbol?>
                  <?=number_format($invoicedata->courier_charge,2)?></td>
              </tr>
              <tr>
                <td height="4" colspan="3" align="left" valign="middle"></td>
              </tr>
              <?php
								}
								?>
                                <?php 
								if($invoicedata->bank_charge > 0)
								{
								?>
               <tr>
                <td align="center" valign="middle" class="greybg1 font-bold pad5 font-14">Bank Charge</td>
                <td align="left" valign="middle"></td>
                <td align="right" valign="middle" class="greybg1 font-bold pad5 font-14"><?=$currency_symbol?>
                  <?=number_format($invoicedata->bank_charge,2)?></td>
              </tr>
               <tr>
                <td height="4" colspan="3" align="left" valign="middle"></td>
              </tr>
              <?php
								}
								 
								if(!empty($invoicedata->extra_calc_name))
								{
								?>
               <tr>
                <td align="center" valign="middle" class="greybg1 font-bold pad5 font-14"><?=$invoicedata->extra_calc_name?> (<?=($invoicedata->extra_calc_opt == 1)?'+':'-'?>) </td>
                <td align="left" valign="middle"></td>
                <td align="right" valign="middle" class="greybg1 font-bold pad5 font-14"><?=$currency_symbol?>
                  <?=number_format($invoicedata->extra_calc_amt,2)?>
                   </td>
              </tr>
              <tr>
                <td height="4" colspan="3" align="left" valign="middle"></td>
              </tr>
              <?php
								}
								?>
                                 <?php 
								if($invoicedata->discount > 0)
								{
								?>
               <tr>
                <td align="center" valign="middle" class="greybg1 font-bold pad5 font-14">Discount </td>
                <td align="left" valign="middle"></td>
                <td align="right" valign="middle" class="greybg1 font-bold pad5 font-14"><?=$currency_symbol?>
                  <?=number_format($invoicedata->discount,2)?>
                   </td>
              </tr>
              <tr>
                <td height="4" colspan="3" align="left" valign="middle"></td>
              </tr>
              <?php
								}
								?>
              <tr>
                <td align="center" valign="middle" class="dark-bg font-bold pad5 dbg-text-color">Total <?=$invoicedata->terms_name?> <?=$invoicedata->currency_name?> </td>
                <td align="left" valign="middle"></td>
                <td align="right" valign="middle" class="dark-bg font-bold pad5 dbg-text-color"><?=$currency_symbol?>
                  <?=number_format($invoicedata->grand_total,2)?></td>
              </tr>
            </table></td>
        </tr>
      </table>
      <table class="font-13" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="15"></td>
        </tr>
        <tr>
          <td> 
<?php 
		  if($invoicedata->payment_terms!='')
		  {
		 
		?>
		 <strong>Terms of Payment : <?=$invoicedata->terms_name?> <?=$invoicedata->terms_of_delivery?></strong><span class="font-12"> <?=$invoicedata->payment_terms?></span>
        <br />
          <?php
		  }
		  ?>          
          <?php 
		  if($invoicedata->payment_terms!='')
		  {
		 
		?>
		  <strong>Terms of Delivery : </strong><span class="font-12"><?=$invoicedata->delivery_period?></span>
        <br />
          <?php
		  }
		  ?>
          
		  <?php 
		  if($invoicedata->payment_terms!='')
		  {
		 
		?>
            <strong>Remarks</strong><br> <span class="font-12"><?=$invoicedata->remarks?></span>
             <?php
		  }
		  ?>
		  <br>
		  <br>
		  
         <strong> Notes :</strong> <br> 
		  1. ABOVE PRICES ARE AS PER DELIVERY TERMS & CONDITIONS ACCEPTED BY CONSIGNEE.<br>
			2. FOB / CNF ADVISABLE TO TAKE MARINE INSURANCE AT YOUR END.<br>
			3. ALL LEGAL MATTERS ARE SUBJECT TO INDIAN JURISDICTION<br>
			4. PALLET ARE FUMIGATED, AND FUMIGATION CERTIFICATE WILL BE SENT ALONG WITH ORIGINAL DOCUMENTS.<br>
			5. CNF PRICE ARE CALCULATING AS ON PERFORMA INVOICE DATE IF MORE THAN 10 DAYS BETWEEN PI DATE OR LOADING DATE DIFFERENCE IN FRIGHT RATE MORE THAN 5% DIFFERENCE WILL BE INFORMED TO YOU.<br>
			6. PALLETS DETAILS CONFIRMED BY CONSIGNEE AS PER PROFORMA INVOICE, IF THE ANY CHANGES BEFORE THE LOADING IN PACKING EXTRA COST WILL BE APPLICABLE ON CONSIGNEE ACCOUNT.<br>
			7. IN CIF IF CONTAINER ACCIDENTLY DAMAGED FOUND AT DESTINATION BEFORE THE CUT SEAL / OPENED CONTIANER/S INFORM US, IF YOU ARE NOT INFORMING US THEN INSURANCE HOLDER COMPANY NOT COVER DAMAGE CONDITIONS.<br>

          </td>
        </tr>
      </table>
      <table class="font-11" width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="20" colspan="3"></td>
        <tr>
          <td width="250" align="left" valign="middle" class="light-color-text  font-bold">For <?=$consigee_companyname?></td>
          <td rowspan="3" align="center" valign="bottom" class="light-color-text   font-bold font-13">Thank you for business with us!</td>
          <td width="250" align="right" valign="middle" class="light-color-text  font-bold">
			For, <?=!empty($invoicedata->sign_pi_status)?$invoicedata->for_signature_name:$company->s_name?>
			</td>
        </tr>
        <tr>
          <td height="50" align="left" valign="middle">&nbsp;</td>
          <td align="right" valign="middle">
			<img src="<?=!empty($invoicedata->sign_pi_status)?base_url().'upload/user/'.$invoicedata->sign_image:base_url().'upload/'.$company->s_c_sign?>" height="<?=$signh?>" width="<?=$signw?>" >&nbsp;
		</td>
        </tr>
        <tr>
          <td align="left" valign="middle" class="font-bold">Consignee Sign and Seal</td>
          <td align="right" valign="middle" class="font-bold"><?=!empty($invoicedata->sign_pi_status)?$invoicedata->authorised_signatury:$company->authorised_signatury?></td>
        </tr>
      </table>
        </td>
  </tr>
</table>
</td>
	</td>
 </tr>
</table>
								
								<?php
								}
								?>
											
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
			"performa_invoice_pdf"	: 'performa_invoice_pdf6'
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
			"invoice_table_name"	: 'performa_invoice_pdf6'  
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