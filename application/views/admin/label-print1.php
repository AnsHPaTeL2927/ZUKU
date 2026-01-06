<?php 
 $this->view('lib/header'); 
 $_SESSION['label_content'] = '';
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
									<a href="<?=base_url().'exportinvoice_listing'?>">Export Invoice List</a>
								</li>
								 
							</ol>
							<div class="page-header title1">
								<h3>View Container Label
									<div class="pull-right form-group">
									<div class="col-sm-5">
										   <div class="dropdown">
											<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format <span class="caret"></span></button>
											<ul class="dropdown-menu">
											<li> 
												<a class="tooltips" data-toggle="tooltip" data-title="1" href="<?=base_url('producation_detail/label_print1/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Label 1</a> </li>
											<li> 
												<a class="tooltips" data-toggle="tooltip" data-title="2" href="<?=base_url('producation_detail/label_print2/'.$invoicedata->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> Label 2</a> </li>
											 
											</ul>
											</div>
										</div>
									<div class="col-sm-4">
										<a class="btn btn-info tooltips" data-title="Print" href="javascript:;" onclick="printlabel('label_content');" ><i class="fa fa-print"></i> Print</a>
									</div>
									</div>
								</h3>
								
							 </div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<div class=" panel-default">
							 
							  
								<div id="label_content">
								<?php
								$n=1;
								 for($i=0; $i<count($product_data);$i++)
								{
									foreach($product_data[$i]->packing  as $packing_row)
									{
									 	?>
								<table width="100%" style="margin-bottom:20px;font-size:34px;border-collapse: collapse;" >
									<tr>
										<td colspan="2" style="text-align:center;font-weight:bold;border: 0.5px solid #333;padding: 5px;" ><?=$product_data[$i]->series_name;?></td>
									</tr>
									<tr>
										<td width="50%" style="font-weight:bold;border: 0.5px solid #333;padding: 5px;font-size:26px;text-align:center;"> DESIGN NO / NAME</td>
										<td  style="border: 0.5px solid #333;padding: 5px;font-size:26px;text-align:center;" width="50%"> <?=$packing_row->model_name;?> </td>
									</tr>
									<tr>
										<td style="font-weight:bold;border: 0.5px solid #333;padding: 5px;font-size:26px;text-align:center;"> SIZE </td>
										<td  style="border: 0.5px solid #333;padding: 5px;font-size:26px;text-align:center;"> <?=$product_data[$i]->size_type_mm;?>  </td>
									</tr>
									 
									<tr>
										<td style="font-weight:bold;border: 0.5px solid #333;padding: 5px;font-size:26px;text-align:center;"> BOXES  </td>
										<td  style="border: 0.5px solid #333;padding: 5px;font-size:26px;text-align:center;"> <?php 
										if($product_data[$i]->boxes_per_pallet > 0)
										{
											echo $product_data[$i]->boxes_per_pallet;
										}
										else if($product_data[$i]->box_per_big_pallet > 0 || $product_data[$i]->box_per_small_pallet > 0)
										{
											echo 'Big'.$product_data[$i]->boxes_per_pallet.'<br>';
											echo 'Small'.$product_data[$i]->boxes_per_pallet;
										}
										else{
											echo "-";
										}
											?> </td>
									</tr>
								 
									<tr>
										<td style="font-weight:bold;border: 0.5px solid #333;padding: 5px;font-size:26px;text-align:center;"> SQM PER PALLET</td>
										<td  style="border: 0.5px solid #333;padding: 5px;font-size:26px;text-align:center;"><?php 
										if($product_data[$i]->boxes_per_pallet > 0)
										{
											echo $product_data[$i]->boxes_per_pallet * $product_data[$i]->sqm_per_box;
										}
										else if($product_data[$i]->box_per_big_pallet > 0 || $product_data[$i]->box_per_small_pallet > 0)
										{
											echo 'Big'.($product_data[$i]->boxes_per_pallet * $product_data[$i]->sqm_per_box) .'<br>';
											echo 'Small'.($product_data[$i]->boxes_per_pallet * $product_data[$i]->sqm_per_box);
										}
										else{
											echo "-";
										}
											?> </td>
									</tr>
								</table>
							
								<?php
									if($n % 2 == 0){ echo " <pagebreak />	";}
									$n++;
								}
								}								?>
								
								</div>
								</div>
							 </div>
						</div>
					</div>
				</div>
			</div>
		 
		</div>
  
  <script>
function filterbystatus(val)
{
	if(val==1)
	{
		$(".withouthtml").show();
		$(".withhtml").hide();
	}
	else
	{
		$(".withouthtml").hide();
		$(".withhtml").show();
	}
} 
function printlabel(DivID) {
  
  //var duplicate = $("#receipt_data").clone().appendTo("#receipt_duplicate");
  var disp_setting="toolbar=yes,location=no,";
  disp_setting+="directories=yes,menubar=yes,";
  disp_setting+="scrollbars=yes,width=800, height=600, left=100, top=25";
  var content_vlue = document.getElementById(DivID).innerHTML;
  var docprint=window.open("","",disp_setting);
  docprint.document.open();
  docprint.document.write('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"');
  docprint.document.write('"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">');
  docprint.document.write('<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">');
  docprint.document.write('<head><title>Export Application</title>');
  docprint.document.write('<style type="text/css">');
  docprint.document.write(' @media print{ @page { size:A4; margin: 0.2in 0.2in 0.2in 0.2in; } }   ');	 
  docprint.document.write('body { font-family:Tahoma;color:#000;');
  docprint.document.write('font-family:Tahoma,Verdana; font-size:10px;} .dataTables_length, .dataTables_filter , .dataTables_paginate { display:none; }');
  docprint.document.write('  </style>');
  docprint.document.write('</head><body onLoad="self.print()">');
  docprint.document.write(content_vlue);
  docprint.document.write('</body></html>');
  docprint.document.close();
  docprint.focus();
	$('#table_head').show();
  
  location.reload();
}
</script>
<?php $this->view('lib/footer'); 

echo "<script>filterbystatus(".$invoicedata->igst_status.")</script>"; 
?>


