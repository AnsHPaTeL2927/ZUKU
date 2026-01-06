<body>
<head>
<style>
table {
	font-family: calibri;
	border: 0.5px solid #333;
	border-collapse: collapse;
	font-size:10px;
}
.pdf_class td {
	padding: 5px; 
}
.pdf_class th {
	padding:5px; 
}
.fontsize {
	font-size:28px;
}
</style>
<div class="main-container">
		<div class="main-content">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="panel panel-default">
								<div class="panel-body">
									<?php 
									foreach ($dispatch_list as $key => $value) { ?>
										<table id="" style="border: 1px solid black; border-collapse: collapse; width: 100%;">
											<caption style="border: 1px solid black; border-collapse: collapse; padding: 10px; ">
												<!--<img style="float: left;" src="data:image/jpeg;base64,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">-->
												<h5 style="float: right; text-align: right; margin-top: -20px;">						
													<pre>
												<b class="fontsize"><strong>Dispatch Report</strong> </b><br>
													     	<strong>Date:<?=date('d/m/Y')?></strong></pre>		
													<!--Bill No. <?=$value['customer_invoice_no']?>-->											
												</h5>																			
											</caption>
											<thead>

												<!-- <tr>
													<th colspan="10" style="border: 1px solid black; border-collapse: collapse; text-align: center;"><h4><strong> Dispatch for <?=$value['c_name']?> </strong></h4></th>
												</tr> -->

												<!-- <tr>
													<th colspan="2" style="width: 20%; border: 1px solid black; text-align: left;">Bill No. <?=$value['customer_invoice_no']?></th>
													<th colspan="8" style="width: 80%; border: 1px solid black; text-align: left;">Date : <?=date('d/m/Y',strtotime($value['dispatch_date']))?></th>
												</tr> -->

												<tr>													
													<th colspan="6" style="width: 20%; border: 1px solid black; vertical-align: top; text-align: center;">
														<pre></pre>
													</th>
													<th colspan="8" style="width: 80%; border: 1px solid black; vertical-align:middle; text-align: center;">
													<?php 
													if(!empty($value))
													{
														// echo "<b>To,</b><br></br>";
														 echo "<b>".strtoupper($value['c_companyname'])."</b><br></br>";
														// echo "<b>".$value['c_city'].",</b><br></br>";
														// echo "<b>".$value['c_state'].",</b><br></br>";
														// echo "<b>".$value['c_country'].",</b><br></br>";
														// echo "<b>".$value['c_address'].",</b><br></br>";
														// echo "<b>Pincode-".$value['c_postcode'].",</b><br></br>";
														// echo "<b>Contact-".$value['c_contact'].".</b><br></br>";
													}
													?>
													</th>
												</tr>
												<tr>													
													<th style="border: 1px solid black; vertical-align: top; text-align: center;">Dispatch Date</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center;">Export Invoice No</th>
													<!--<th style="border: 1px solid black; vertical-align: top; text-align: center;">Container Number</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center;">Truck Number</th>	-->										
													<th style="border: 1px solid black; vertical-align: top; text-align: center;">Production Date</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center;">Box Name</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center;">Size</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width:5%;">Design</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width:8%;">Finish</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width:8%">Batch No.</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width:8%">Shade No.</th>													
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width: 8%;">Big Pallet Box</th>									
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width: 8%;">Big Pallet</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width: 8%;">Small Pallet Box</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width: 8%;">Small Pallet</th>
													<th style="border: 1px solid black; vertical-align: top; text-align: center; width:5%;">Box</th>
												</tr>
											</thead>
											<tbody>											
												<tr>		
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=date('d/m/Y',strtotime($value['dispatch_date']))?></td>
													<!--<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['container_num']?></td>
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['truck_num']?></td>-->	
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['export_invoice_no']?></td>						
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=date('d/m/Y',strtotime($value['producation_date']))?></td>
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['box_design_name']?></td>	
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['size_type_mm']?></td>
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['design']?></td>
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['finish_name']?></td>
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['batch_no']?></td>
														<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['shade_no']?></td>		
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['big_pallet_box']?></td>												
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['big_pallet']?></td>
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['small_pallet_box']?></td>
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['small_pallet']?></td>
													<td style="border: 1px solid black; vertical-align: top; text-align: center;"><?=$value['dispatch_box']?></td>
												</tr>
											<tr>
												<th colspan="14" style="border: 1px solid black; vertical-align: top; text-align: left; width: 100%">	
													<!--Remarks:<br>--><br><br><br>
													<p style="float: right;">Sign______________ &nbsp;&nbsp;&nbsp;&nbsp;</p>
												</th>											
											</tr>														
											</tbody>
										</table>
										<br><br>
									<?php }	?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
</head></body>