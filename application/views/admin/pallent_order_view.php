<?php 
 $this->view('lib/header'); 
  
 $purchase_order_date = date('d.m.Y',strtotime($invoicedata->producation_date));
 $purchase_order_no =$invoicedata->producation_no;
 $export =  ($invoicedata->exporter_detail);
  
 $supplier_name = $invoicedata->party_name;
 $supplier_address = ($invoicedata->supplier_detail);
 $factory_name = ($invoicedata->factory);
 $factory_address = strip_tags($invoicedata->factory_address);
 $exporter_Address				= $company_detail->s_name."&#13;&#10;".strip_tags($company_detail->s_address)."&#13;&#10;";
 $pallet_type = ($invoicedata->pallet_type_name);
  
  $_SESSION['pallent_order_no'] = '';
  $_SESSION['pallent_order_content'] = '';
?>	
<style>
td {
    border: 0.5px solid #333;
    padding: 5px;
}
th{
	border: 0.5px solid #333;
    padding: 5px;
}
</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"pallent_order/viewpdf", '_blank');
	}
	else{
		window.location= root+"pallent_order/viewpdf";
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
									<a href="<?=base_url().'purchaseorder_listing'?>">Pallet Order List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
							<h1>View Pallet Order</h1>
							 <div class="pull-right form-group">
											<h4>
												<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
												 
												</h4> 
										</div>
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
								<div class="" style="padding:10px;" >
								<?php ob_start();?>
									
										<table cellspacing="0" cellpadding="0"    width="100%">
										    <tr>
										       <td colspan="3" style="font-weight:bold;text-align: center;background-color:#C7D9F1 ;color:#000000"> <h1 ><u>PALLET ORDER	</u></h1> </td>
										    </tr>
											<tr>
												<td style="vertical-align:top;font-weight:bold">PO No :<?=$purchase_order_no?></td>
												
												<td colspan="2" style="vertical-align:top;font-weight:bold"> DATE : <?=$purchase_order_date?></td>
											</tr>
											   
											<tr>
												<td style="vertical-align:top;font-weight:bold"><?=$export?> </td>
												<td colspan="2" style="vertical-align:top;font-weight:bold"> To, <br><?=$supplier_name?><br> <?=$supplier_address?></td>
												 
											</tr>	
											<tr>
												<td style="vertical-align: top">
													
												</td>
												 <td colspan="2">
												<strong> Pallet Packing Location : </strong>
													<?=$factory_name?>, <?=$factory_address?>
												</td>
											</tr>
								 	</table>
											<table cellspacing="0" cellpadding="0" width="100%">
											<tr > 
												<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>SR NO </strong></td>
												<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>Description Of Goods </strong></td>
											
												
												<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>Box Per Pallet </strong></td>
												<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>Pallet </strong></td> 
												<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>Pcs/Box </strong></td> 
												<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong> Pallet Type </strong></td>
									            <td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong> Rate/Pallet</strong></td>
												<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>Total Amount </strong></td>
                                            	<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>FACTORY </strong></td>
											 
												 
									  </tr>
									  <?php
										$srno = 1;
										$extrarow = 2;
										$total_product_plts=0;
										$total_box=0;
										$total_fcl = 0;
										
										foreach ($packing_data as $categoryll) 
										 {
									 	 
										?>
											<tr> 
												<td width="5%" style="text-align: center;"><?=$srno?></td>
												<td width="15%"  style="text-align: center;color:#2A3F5F;font-weight:bold">
													<?=$categoryll->description?> 
													 
												</td>
													
												<?php 
											 		if($categoryll->no_of_pallet>0)
													{
													 	$no_of_pallet = $categoryll->no_of_pallet;
														$total_product_plts += $categoryll->no_of_pallet;
														$product_plts = $categoryll->boxes_per_pallet;
														$total_box += $categoryll->boxes_per_pallet;
													 
													}
													else if($categoryll->no_of_big_pallet > 0)
													{
														$no_of_pallet =  $categoryll->no_of_big_pallet.'<br>'.$categoryll->no_of_small_pallet;
														$total_product_plts += $categoryll->no_of_big_pallet;
														$total_product_plts += $categoryll->no_of_small_pallet;
														$product_plts  =  $categoryll->box_per_big_pallet.'<br>'.$categoryll->box_per_small_pallet;
														$total_box += $categoryll->box_per_big_pallet;
														$total_box += $categoryll->box_per_small_pallet;
													} 
													else
													{
														 $no_of_pallet =  '-';
														 $product_plts = '-';
													}
												?>
												
													<td width="10%" style="text-align: center;">
														 <?=$product_plts?> 
														 
													</td>
													
													<td width="10%" style="text-align: center;color:#2A3F5F;font-weight:bold">
														 <?=$no_of_pallet?> 
														 
													</td>
													
													<td width="10%" style="text-align: center;color:#2A3F5F;font-weight:bold">
														 <?=$categoryll->pcs_per_box?>
														 
													</td>
													<td width="15%"  style="text-align:center;color:#2A3F5F;font-weight:bold" > 
														<?=$categoryll->pallet_type_name?>
													</td>
													<td  width="7%" style="text-align: center;color:#2A3F5F;font-weight:bold">
													<?php
													if($categoryll->no_of_pallet>0)
													{
													?>
													 	<?=$categoryll->rate_per_pallet?>
													 
													<?php
													}
													else
													{
													?>	
													 <?=$categoryll->rate_per_big_pallet.'<br>'.$categoryll->rate_per_small_pallet?>
													<?php	
													} 
													?>
													
													
													</td>
												  <td  width="7%" style="text-align: center;color:#2A3F5F;font-weight:bold"><?=$categoryll->total_amount?></td>
													<td width="16%"  style="text-align:center" > 
														<?=$categoryll->factory?>
													</td>
												  
									 	 
										  </tr>
									<?php
											 $total_fcl += $categoryll->fcl;
											$srno++;
										 
										}
									   ?>
										<tr> 
										<td style="text-align:right;background-color:#C7D9F1 ;color:#000000"></td>
										
										 
											<td style="text-align:right;background-color:#C7D9F1 ;color:#000000;text-align: center"><strong><h3>TOTAL</h3></strong></td>
										 
											<td style="text-align:center;background-color:#C7D9F1 ;color:#000000"><strong><h3><?=$total_box?></h3> </strong></td>
											<td style="text-align:center;background-color:#C7D9F1 ;color:#000000"><strong><h3><?=$total_product_plts?></h3> </strong></td>
									 
										 <td style="text-align:center;background-color:#C7D9F1 ;color:#000000" > 
														<strong>  </strong>
													</td>
										  <td style="text-align:center;background-color:#C7D9F1 ;color:#000000" > 
														<strong>  </strong>
													</td> 
													<td style="text-align:center;background-color:#C7D9F1 ;color:#000000" > 
														<strong>  </strong>
													</td>
									 <td style="text-align:center;background-color:#C7D9F1 ;color:#000000" > 
														<strong>  </strong>
													</td> <td style="text-align:center;background-color:#C7D9F1 ;color:#000000" > 
														<strong>  </strong>
													</td>
										 
									   </tr>
									   
									    <tr>
										<td colspan="9">
												<strong> Remarks : </strong>
													
														<?=$categoryll->remarks?>
										
										</td>
										</tr>
									   
										</table>
										<br>
										<br>
										<br>
										
										<!--<table cellspacing="0" cellpadding="0" width="100%">-->
										<!--	<tr>-->
										<!--		<th style="text-align: center;background-color:#C7D9F1 ;color:#000000" colspan="5"><u>PALLET UNLOADING DETAILS]</u></th>-->
										<!--	</tr>-->
										
										<!--	<tr> -->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>SR NO </strong></td>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>DATE</strong></td>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>PALLET QUANTITY</strong></td>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>FACTORY NAME </strong></td>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>SIGNATURE & STAMP OF FACTORY </strong></td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
									 <!--       <tr>-->
									 <!--           <td colspan="5"></td>-->
									 <!--       </tr>-->
										<!--	<tr>-->
										<!--		<th style="text-align: center;background-color:#C7D9F1 ;color:#000000" colspan="5"> <u>PALLET UTILIZATION DETAILS</u> </th>-->
										<!--	</tr>-->
										
										<!--	<tr> -->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>SR NO </strong></td>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>DATE</strong></td>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>PALLET QUANTITY</strong></td>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>FACTORY NAME </strong></td>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000"> <strong>SIGNATURE & STAMP OF FACTORY </strong></td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr> -->
										<!--		<td> &nbsp;</td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!--		<td> </td>-->
										<!-- 	</tr>-->
										<!--	<tr>-->
										<!--		<td style="text-align: center;background-color:#C7D9F1 ;color:#000000" colspan="5"> NOTE:- <?=$company_detail[0]->s_name?> IS RESPONSIBLE ONLY FOR THE PALLET ORDER WHICH WAS GIVEN, NOT FOR MISSING PALLETS AND DETAILS MISSING </td>-->
										<!--	</tr>-->
										<!--</table>-->
										<?php
											$output = ob_get_contents(); 
											
											$_SESSION['pallent_order_no'] = $invoicedata->purchase_order_no;
											$_SESSION['pallent_order_content'] = $output;
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
