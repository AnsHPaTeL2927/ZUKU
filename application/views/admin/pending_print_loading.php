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
												// Show the original container details
												// if(!empty($producation_mst->container_twenty)) {
													// echo $producation_mst->container_twenty . ' X 20 FCL';
												// }
												// if(!empty($producation_mst->container_twenty) && !empty($producation_mst->container_forty)) {
													// echo ", ";
												// }
												// if(!empty($producation_mst->container_forty)) {
													// echo $producation_mst->container_forty . ' X 40 FCL';
												// }

												// Add total container count based on unique container_no
												// $unique_containers = [];
												// foreach($set_container as $row) {
													// //if (!empty($row->container_no)) {
														// $unique_containers[] = $row->container_no;
													// //}
												// }
												// $total_containers = count(array_unique($unique_containers));

												// // Show total container count
												// echo "<br>Total Containers: <span>" . $total_containers . "</span>";
											?>
										</h4>


									 </th>
								 </tr> 	 
								 <tr>
										<th width="34%" style="color:#0072B9 "> Producation No : <?=$producation_mst->producation_no?> </th>
									 	<th width="33%" style="color:#0072B9 "> Producation Date : <?=date('d/m/Y',strtotime($producation_mst->producation_date))?></th>
									 	<th width="33%" style="color:#0072B9 "> Supplier Name : <?=$producation_mst->company_name?></th>
							 	 </tr>
							 	 </table>

								<table id="excel_export"  border="1" cellspacing="0" width="100%" style="text-align:center;">
								    
							 <tr>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="3%">SR No</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="7%">TRUCK NO</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="8%">CONTAINER NO</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="7%">LINE SEAL</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="7%">SELF SEAL</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="7%">MOBILE NO.</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="7%">SIZE IN CM</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="10%">DESIGN</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="10%">CLIENT DESIGN NAME</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="7%">FINISH</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="6%">BATCH NO</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="5%">LOCATION</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="8%">PALLETS</th>
    <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:8px;" width="8%">TOTAL BOXES</th>
</tr>

<?php
$co_array = array();
$no = 1;
$total_pallet = 0;
$total_box = 0;
$total_sqm = 0;
$previous_con = '';

for($i = 0; $i < count($set_container); $i++) {  
    $current_con = $set_container[$i]->con_entry;

    // Skip fully loaded containers
    if(!in_array($current_con, $remaining_con_entries)) {
        continue;
    }

    // Print subtotal row when container changes
    if($current_con != $previous_con && !empty($previous_con)) {
        ?>
        <tr>
            <th colspan="6" style="text-align:right;font-weight:bold;background-color:#C7D9F1;color:#000000;font-size:11px">TOTAL</th>
            <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:11px"><?=$total_pallet?></th>
            <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:11px"></th>
            <th style="text-align:center;background-color:#C7D9F1;color:#000000;font-size:11px"><?=$total_box?></th>
        </tr>
        <?php
        $total_pallet = 0;
        $total_box = 0;
        $total_sqm = 0;
    }

    ?>
    <tr>
        <?php
        if(!in_array($current_con, $co_array)) {
            array_push($co_array, $current_con);
            ?>
            <td rowspan="<?=($set_container[$i]->rowcon_no + 1)?>"><?=$no?></td>
            <td style="text-align:center" rowspan="<?=($set_container[$i]->rowcon_no + 1)?>"><?=$set_container[$i]->truck_no?></td>
            <td style="text-align:center;font-weight:bold" rowspan="<?=($set_container[$i]->rowcon_no + 1)?>"><?=$set_container[$i]->container_no?></td>
            <td style="text-align:center" rowspan="<?=($set_container[$i]->rowcon_no + 1)?>"><?= isset($importdata[$i]) ? $importdata[$i][1] : $set_container[$i]->seal_no?></td>
            <td style="text-align:center" rowspan="<?=($set_container[$i]->rowcon_no + 1)?>"><?= isset($importdata[$i]) ? $importdata[$i][2] : $set_container[$i]->rfidseal_no?></td>
            <td style="text-align:center" rowspan="<?=($set_container[$i]->rowcon_no + 1)?>"><?= isset($importdata[$i]) ? $importdata[$i][6] : $set_container[$i]->mobile_no?></td>
            <?php
            $no++;
        }

        if($set_container[$i]->product_id == 0) {
            ?>
            <td style="text-align:center" colspan="3"><?=$set_container[$i]->description_goods?></td>
            <?php
        } else {
            ?>
            <td style="text-align:center"><?=$set_container[$i]->size_type_cm?></td>
            <td style="text-align:center;font-weight:bold"><?=$set_container[$i]->model_name?></td>
            <td style="text-align:center;font-weight:bold"><?=$set_container[$i]->client_name?></td>
            <td style="text-align:center;font-weight:bold"><?=$set_container[$i]->finish_name?></td>
            <?php
        }
        ?>
        <td style="text-align:center"><?=$set_container[$i]->batch_no?></td>
        <td><?=$set_container[$i]->location?></td>

        <?php
        if(!empty($set_container[$i]->make_pallet_no)) {
            $pallet_ids = explode(",", $set_container[$i]->pallet_row);
            echo '<td class="text-center" rowspan="'.count($pallet_ids).'">'.$set_container[$i]->make_pallet_no.'</td>';
            $total_pallet += $set_container[$i]->make_pallet_no;
        } else if(!empty($set_container[$i]->production_mst_id) || empty($set_container[$i]->pallet_row)) {
            ?>
            <td style="text-align:center;font-weight:bold"><?=$set_container[$i]->pending_pallets?></td>
            <?php
        }
        ?>

        <td style="text-align:center"><?=$set_container[$i]->pending_boxes?></td>
    </tr>
    <?php
    $previous_con = $current_con;
    $total_box += $set_container[$i]->origanal_boxes;
    $total_sqm += ($set_container[$i]->origanal_boxes * $set_container[$i]->sqm_per_box);
}
?>

		
								<tr>
								 
									<th colspan="6"  style="text-align:right;font-weight:bold;background-color:#C7D9F1 ;color:#000000;font-size:11px">TOTAL  	</th>
									<th style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"><?=$total_pallet?></th>
									<th style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"> </th>
									<th style="text-align:center;background-color:#C7D9F1 ;color:#000000;font-size:11px"><?=$total_box?> </th>
									 
								 	 
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