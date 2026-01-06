<?php 
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
							Company Details
						</li>
						 
					</ol>
					<div class="page-header">
					<h3>Price Calculation 
						<small class="pull-right">
							<a href="<?php echo base_url('hsnc_code'); ?>" class="btn btn-info">+ Packing Detail</a>
							</small>
					</h3>
					<strong id="succecssmsg" style="color:green"></strong>
					</div>
					 
				</div>
			</div>
			 
            			<div class="row">
						<div class="col-sm-12">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
								</div>
							<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover" id="sample-table-1">
											<thead>
												<tr>
													<th>HSNC Code</th>
													<th>Size In MM (Series)</th>
													<th>PCS PER BOX</th>
													<th>APPROX WEIGHT PER BOX</th>
													<th>APPROX SQM PER BOX</th>
													<th>APPROX NET WEIGHT PER CONTIANER</th>
													<th>PRICE</th>
													<th>PRICE PER BOX</th>
													<th>PRICE TYPE</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											<?php 
											for($i=0; $i<count($result);$i++)
											{
											?>
												<tr>
													<td><?=$result[$i]->hsnc_code?></td>
													<td><?=$result[$i]->size_type_mm?></td>
													<td><?=$result[$i]->pcsperbox?></td>
													<td><?=$result[$i]->apwigtperbox?></td>
													 
													<td><?=$result[$i]->appsqmperbox?></td>
												 	<td><?=$result[$i]->appwegtpercon?></td>
												 	<td><?=$result[$i]->sqmprice?></td>
												 	<td><?=$result[$i]->priceperbox?></td>
												 	<td><?=$result[$i]->pricetype?></td>
												 	<td>
													<div class="dropdown">
														  <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
														  <span class="caret"></span></button>
														  <ul class="dropdown-menu">
															<li>
																<a class="tooltips" href="javascript:;" data-title="Price Calculation"  onclick="do_calc(<?=$result[$i]->product_size_id?>,<?=$result[$i]->hsnc_code?>)" ><i class="fa fa-calculator" aria-hidden="true"></i> Calculation</a>
															</li>
															<li>
																	<a class="tooltips" data-title="Edit Price" href="<?php echo base_url('price_calculation/editprice/'.$result[$i]->product_size_id); ?>"><i class="fa fa-pencil"></i> Edit</a>
															</li>
															<li>
																<a class="tooltips" data-title="Delete" href="javascript:;" onclick="delete_record(<?=$result[$i]->product_size_id?>)"><i class="fa fa-trash"></i> Delete</a>
															</li>
														  </ul>
													 </div>
												 
													</td>
												</tr>
										<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>
			</div>

		</div>
	</div>
	 
</div>
 
<?php $this->view('lib/footer'); ?>
<div id="çalculation_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Price Calculation</h4>
            </div>
            <div class="modal-body">
				<table class="table table-bordered table-responsive">
					<tbody id="responsehtml"></tbody>
				</table>
				 
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
$(document).ready(function () {
	$("body").addClass('navigation-small');
			$('#sample-table-1').DataTable({
			   "order": [[ 0, "asc" ]],
			    "lengthMenu": [ 50, 10, 25, 75, 100 ]
			});
		});
$(".select2").select2({
	width:'100%'
});
function delete_record(product_size_id)
{
	main_delete(product_size_id,'calculation/deleterecord','price_calculation')
}
function do_calc(id,hsnc_code)
{
	block_page();
	$.ajax({ 
              type: "POST", 
              url: root+'price_calculation/displaydataprice',
              data: {
                "id": id,
				"hsnc_code":hsnc_code
              }, 
              cache: false, 
              success: function (data) { 
				$("#çalculation_modal").modal({
						backdrop: 'static',
						keyboard: false
					});
				 $("#responsehtml").html(data)
				 unblock_page("","")
              }
			});
}
function all_calculation()
{
	 var priceperboxval3 = jQuery('input[name="priceperbox3"]').val();
}
</script>