<?php 
$this->view('lib/header'); 
?>
<style>
table 
{
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	page-break-inside:avoid;
}
table.packing
{
	
}
td {
 	border: 0.5px solid #333;
	padding: 5px; 
}
th 
{
 	border: 0.5px solid #333;
	padding: 3px; 
}
 
</style>
<script>
function view_pdf(no)
{
	if(no==1)
	{
		window.open(root+"producation_pdf/view_pdf", '_blank');
	}
	else{
		window.location= root+"Producation_pdf/view_pdf";
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
									Loading PDF
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>Loading PDF
 									 <div class="pull-right form-group">
									  	 <a class="btn btn-primary tooltips" data-title="Export Excel" href="javascript:;" onclick="exportF(this)"   ><i class="fa fa-file-excel-o"></i> Export Excel</a>
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
										<a href="<?=base_url()?>create_pi_loading/index/<?=$performa_invoice_id?>">Create loading plan</a>
								</div>
                                <div class="">
								<div class="panel-body form-body">
								 <?php ob_start();?>
									 
								<table id="excel_export"  border="1" cellspacing="0" width="100%" style="text-align:center;">
								  <tr>
										<th colspan="14" style="border:none;color:#0072B9 ;font-size:15px">
										<h4 style="text-align:center;font-weight:bold ;color:#0072B9 ;font-size:15px">
											Loading Plan
										</h4>
											<h4 style="text-align:center;font-weight:bold;color:#0072B9 ;font-size:15px">
											Order File 
											<?php
												if(!empty($invoicedata->container_twenty))
												{
													echo $invoicedata->container_twenty.' X 20 FCL';
												}
												if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty))
												{
														echo ",";
												}
												if(!empty($invoicedata->container_forty))
												{
													echo  $invoicedata->container_forty.' X 40 FCL';
												}
												 ?>
										</h4>


									 </th>
								 </tr> 	 
								 
								 <!--<tr>
										<th width="34%" style="color:#0072B9 "> Producation No : <?=$product_data->producation_no?> </th>
									 	<th width="33%" style="color:#0072B9 "> Producation Date : <?=date('d/m/Y',strtotime($product_data->producation_date))?></th>
									 	<th width="33%" style="color:#0072B9 "> Supplier Name : <?=$invoicedata->company_name?></th>--
							 	 </tr>-->
							 	 </table>

								<table id="excel_export"  border="1" cellspacing="0" width="100%" style="text-align:center;">
								    
							 	<tr>
									<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="3%">SR No</th>
									<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="7%"> TRUCK NO</th>
									<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="8%">CONTAINER NO</th>
									<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="8%">LINE SEAL</th>
									<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="8%">SELF SEAL</th>
									<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="9%">MOBILE NO.</th>
									<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="7%">SIZE IN CM</th>
									<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="9%">DESIGN </th>
								 	<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="8%">FINISH </th>
								 	<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="8%">BATCH NO </th>
									 <th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="6%">LOCATION</th>
									  	<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="5%"> BOXES/ PALLET</th>
								 	<th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="6%">PALLETS</th>
								
                                    <th  style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size: 8px;" width="8%">TOTAL BOXES</th>
									 
								 </tr>
							 <?php 
									 $co_array = array();
									 $conarray = array();
									 $no = 1;
									
										for($i=0; $i<count($product_data);$i++)
										{  
											$current_con = $product_data[$i]->con_entry; 
											if($current_con != $previous_con && !empty($previous_con))
											{
											
												?>
												<tr>
											
													<th colspan="5"  style="text-align:right;font-weight:bold;background-color:#C7D9F1 ;color:#000000;font-size:11px">TOTAL  	</th>
													
													<th style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"> </th>
													<th style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"><?=$total_pallet?></th>
													<th style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"> <?=$total_box?></th>
													 
												</tr>
													<?php
											}
										?>
												<tr>
												 <?php 
													if(!in_array($product_data[$i]->con_entry,$co_array))
													{
														 $total_pallet = 0;
														 $total_box = 0;
														 $total_sqm = 0;
														  
													?>
														<td rowspan="<?=($product_data[$i]->rowcon_no + 1)?>">
																<?=$no?>
														</td>
														<td style="text-align:center" rowspan="<?=($product_data[$i]->rowcon_no + 1)?>"><?=$product_data[$i]->truck_no?> </td> 
														<td style="text-align:center;font-weight:bold" rowspan="<?=($product_data[$i]->rowcon_no + 1)?>"><?=$product_data[$i]->container_no?> </td> 
														<td style="text-align:center" rowspan="<?=($product_data[$i]->rowcon_no + 1)?>"><?= isset($importdata[$i]) ? $importdata[$i][1] : $product_data[$i]->seal_no?> </td> 
														<td style="text-align:center" rowspan="<?=($product_data[$i]->rowcon_no + 1)?>"><?= isset($importdata[$i]) ? $importdata[$i][2] : $product_data[$i]->rfidseal_no?> </td> 
														<td style="text-align:center" rowspan="<?=($product_data[$i]->rowcon_no + 1)?>"><?= isset($importdata[$i]) ? $importdata[$i][6] : $product_data[$i]->mobile_no?> </td> 
													<?php 
													$no++;
										
														array_push($co_array,$product_data[$i]->con_entry);
												
													}
													 
													 	if($product_data[$i]->product_id == 0)
														{
															?>
															<td style="text-align:center" colspan="3"><?=$product_data[$i]->description_goods?></td> 
													 	<?php
														}
														else
														{
															?> 
														<td style="text-align:center"><?=$product_data[$i]->size_type_cm?>
														</td>
														<td style="text-align:center;font-weight:bold"><?=$product_data[$i]->model_name?></td>
													 	<td style="text-align:center;font-weight:bold"><?=$product_data[$i]->finish_name?></td>
													 
														 
														<?php
														//var_dump($product_data[$i]->batch_no);
														}
														?>
														
															<td style="text-align:center"><?=$product_data[$i]->batch_no?></td>
														

															
															<td style="text-align:center"><?=$product_data[$i]->location?></td> 
													<?php 
														$count = explode(",",$product_data[$i]->export_make_pallet_no);
														$export_rowspan = count($count);
														if(!empty($product_data[$i]->pallet_ids) || $product_data[$i]->make_pallet_no == 1)
														{
															if(!empty($product_data[$i]->pallet_ids))
															{
																$pallet_ids = explode(",",$product_data[$i]->pallet_row);
															echo  '
															<td  style="text-align:center" class="text-center" rowspan="'.count($pallet_ids).'">
																-
															</td>
															<td  style="text-align:center" class="text-center" rowspan="'.count($pallet_ids).'">
																'.$product_data[$i]->make_pallet_no.'     
															</td>';
															$total_pallet += $product_data[$i]->make_pallet_no;
															}
														}
														else if(!empty($product_data[$i]->export_make_pallet_no))
														{
															
															echo '<td class="text-center" rowspan="'.$export_rowspan.'">
																			-
																	</td>
																	<td class="text-center" rowspan="'.$export_rowspan.'">
																			'.$product_data[$i]->export_half_pallet.'  
																	</td>';
															$total_pallet += $product_data[$i]->export_half_pallet;																	
														}
														else if(!empty($product_data[$i]->production_mst_id) || empty($product_data[$i]->pallet_row))
														{
															if(empty($product_data[$i]->export_half_pallet))
															{
															echo '  <td style="text-align:center" > ';
															if($product_data[$i]->origanal_pallet > 0)
															{
																echo $product_data[$i]->boxes_per_pallet;
															
															}
															else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
															{
																if(empty($product_data[$i]->export_half_pallet))
																{
																	echo $product_data[$i]->box_per_big_pallet.'<br>'.$product_data[$i]->box_per_small_pallet;
																}
															}
															else
															{
																echo "-";
															}
															echo '  </td> 
															<td style="text-align:center" > ';
															if($product_data[$i]->origanal_pallet > 0)
																{
																	echo $product_data[$i]->origanal_pallet;
																	$total_pallet += $product_data[$i]->origanal_pallet;
																}
																else if($product_data[$i]->orginal_no_of_big_pallet > 0 || $product_data[$i]->orginal_no_of_small_pallet > 0)
																{
																	echo $product_data[$i]->orginal_no_of_big_pallet.'<br>'.$product_data[$i]->orginal_no_of_small_pallet;
																	$total_pallet += $product_data[$i]->orginal_no_of_big_pallet;
																	$total_pallet += $product_data[$i]->orginal_no_of_small_pallet;
																}
																else
																{
																	echo "-";
																}
															 
															echo '  </td> ';
															}
														}
														?>
														
														<td style="text-align:center">
															<?=$product_data[$i]->no_of_boxes?>
															
														</td>
														
														<!--default value -->
														<!--<td style="text-align:center;">
															<?php 
																if($product_data[$i]->no_of_pallet>0)
																{
																	$boxes_per_pallet =  $product_data[$i]->boxes_per_pallet;
																}
																else if($product_data[$i]->no_of_big_pallet > 0 || $product_data[$i]->no_of_small_pallet)
																{
																	$big= ( $product_data[$i]->box_per_big_pallet > 0)? $product_data[$i]->box_per_big_pallet:'';
																	$small= ( $product_data[$i]->box_per_small_pallet > 0)? $product_data[$i]->box_per_small_pallet:'';
																	$boxes_per_pallet =  $big.'<br>'.$small;
																}
																else
																{
																	$boxes_per_pallet =  '-';
																}
															?>
															<?=$boxes_per_pallet?>
														</td>-->
														
													  	<!--<td style="text-align:center;font-weight:bold"><?=$product_data[$i]->origanal_boxes?> </td>-->
													  
													</tr>
													
								<?php
								 
									$previous_con 	 = $product_data[$i]->con_entry;
									 $total_box 	+= $product_data[$i]->origanal_boxes;
									 $total_sqm 	+= ($product_data[$i]->origanal_boxes * $product_data[$i]->sqm_per_box);
							   	 
										}
							?>
		
								<tr>
								 
									<td colspan="5"  style="text-align:right;font-weight:bold;background-color:#C7D9F1 ;color:#000000;font-size:11px">TOTAL  	</td>
								
									<td style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"> </td>
										<td style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"><?=$total_pallet?></td>
									<td style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"><?=$total_box?> </td>
									 
								 	 
								</tr>
								 
							</table>
							  			
		
						 			<?php
								 
									 $output = ob_get_contents(); 
									 $_SESSION['performainvoice_no'] = $producation_mst->invoice_no.' - '.date('d-m',strtotime($producation_mst->performa_date));
									 $_SESSION['producation_content'] = $output;
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
function exportF(elem)
 {
  var table = document.getElementById("excel_export");
  var html = table.outerHTML;
  var url = 'data:application/vnd.ms-excel,' + escape(html); // Set your html table into url 
  elem.setAttribute("href", url);
  elem.setAttribute("download", "loadingfile_<?=$producation_mst->producation_no?>.xls"); // Choose the file name
  return false;
}
</script>