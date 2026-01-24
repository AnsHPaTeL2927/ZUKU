<?php 
$this->view('lib/header'); 
?>

<style>
	.manage-product-header {
		background-color: #0480BE;
		color: #ffffff;
		padding: 10px 15px;
		margin: 20px 0 15px 0;
		border-radius: 4px;
		font-weight: bold;
	}
	.summary-section {
		display: flex;
		align-items: flex-start;
		gap: 20px;
		margin: 20px 0;
	}
	.summary-left {
		flex: 1;
		padding: 15px;
	}
	.summary-right {
		flex: 1;
		background-color: #f8f9fa;
		padding: 15px;
		border-radius: 4px;
		border: 1px solid #dee2e6;
	}
	.summary-divider {
		width: 2px;
		background-color: #0480BE;
		margin: 0 10px;
	}
	.summary-item {
		margin-bottom: 10px;
	}
	.summary-item:last-child {
		margin-bottom: 0;
	}
	.summary-label {
		font-weight: bold;
		color: #495057;
		margin-bottom: 5px;
	}
	.summary-value {
		font-size: 16px;
		color: #212529;
	}
	.sequence-indicator {
		text-align: right;
		margin-bottom: 10px;
		color: #6c757d;
		font-size: 14px;
	}
	.date-input-wrapper {
		position: relative;
	}
	.date-input-wrapper .fa-calendar {
		position: absolute;
		right: 10px;
		top: 50%;
		transform: translateY(-50%);
		pointer-events: none;
		color: #6c757d;
	}
	.date-input-wrapper input {
		padding-right: 35px;
	}
	.product-table thead th {
		background-color: #f5f5f5;
		font-weight: bold;
		text-align: center;
	}
	.product-table tbody td {
		vertical-align: middle;
	}
	.product-table .form-control {
		width: 100%;
	}
</style>

<div class="main-container">
	<?php $this->view('lib/sidebar'); ?>

	<div class="main-content">
		<div class="container-fluid">

			<!-- Breadcrumb -->
			<div class="row">
				<div class="col-sm-12">
					<ol class="breadcrumb">
						<li>
							<i class="clip-pencil"></i>
							<a href="<?= base_url('dashboard') ?>">Dashboard</a>
						</li>
						<li>
							<a href="<?= base_url('purchaseorder_listing') ?>">Purchase Order</a>
						</li>
						<li class="active">Create Purchase Order</li>
					</ol>

					<div class="page-header">
						<h3>Create Purchase Order</h3>
						<p class="text-muted">Add new purchase order details</p>
					</div>
				</div>
			</div>

			<!-- FORM -->
			<div class="row">
				<div class="col-md-12">

					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-plus-square"></i> Purchase Order Details
						</div>

						<div class="panel-body">

							<form method="post" action="<?= base_url('admin/save_purchaseorder') ?>" id="po-form">

								<!-- BASIC INFO -->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>PO Number (SR.NO)</label>
											<input type="text" name="po_number" id="po-number" class="form-control"
												placeholder="Enter PO number" required>
										</div>
									</div>

									<div class="col-md-6">
										<div class="form-group">
											<label>Date</label>
											<div class="date-input-wrapper">
												<input type="text" name="po_date" id="po-date" class="form-control date-picker"
													value="<?= date('d-m-Y') ?>" required readonly>
												<i class="fa fa-calendar"></i>
											</div>
											<input type="hidden" name="po_date_hidden" id="po-date-hidden" value="<?= date('Y-m-d') ?>">
										</div>
									</div>
								</div>

								<hr>

								<!-- MANAGE PRODUCT HEADER -->
								<div class="row">
									<div class="col-md-12">
										<div class="manage-product-header">
											<i class="fa fa-cubes"></i> Manage Product
										</div>
									</div>
								</div>

								<!-- PALLET OPTIONS -->
								<div class="row">
									<div class="col-md-12">
										<div class="form-group">
											<label class="radio-inline">
												<input type="radio" id="with-pallet" name="pallet_option" value="with"> With Pallet
											</label>
											<label class="radio-inline">
												<input type="radio" id="without-pallet" name="pallet_option" value="without"> Without Pallet
											</label>
											<label class="radio-inline">
												<input type="radio" id="multi-pallet" name="pallet_option" value="multi" checked> Multi Pallet
											</label>
										</div>
									</div>
								</div>

								<!-- SIZE & PACKING -->
								<div class="row">
									<div class="col-md-3">
										<div class="form-group">
											<label>SIZE</label>
											<select class="form-control" id="size_select" name="size">
												<option value="600x600" selected>600 x 600</option>
												<option value="1200x600">1200 x 600</option>
											</select>
										</div>
									</div>
									<div class="col-md-3">
										<div class="form-group">
											<label>PACKING DETAIL</label>
											<select class="form-control" id="packing_detail" name="packing_detail">
												<option value="default" selected>DEFAULT</option>
												<option value="120_600_multi">120*600 MULTI</option>
											</select>
										</div>
									</div>
								</div>

								<!-- HIDDEN VALUES FOR CALCULATION -->
								<input type="hidden" id="weight-per-box" value="50">
								<input type="hidden" id="empty-pallet-weight" value="50">

								<!-- PRODUCT TABLE -->
								<div class="table-responsive">
									<table class="table table-bordered table-striped product-table">
										<thead>
											<tr>
												<th>Design</th>
												<th>Finish</th>
												<th>Client Design Name</th>
												<th>No Of Pallet</th>
												<th>Pallet Type</th>
												<th>Boxes</th>
												<th>Box Design</th>
												<th>SQM</th>
												<th>Add</th>
											</tr>
										</thead>
										<tbody id="product-tbody">
											<tr class="product-row">
												<td>
													<select name="design[]" class="form-control">
														<option value="">Select Design</option>
														<option>SWIZER WHITE</option>
														<option>OPULENCE</option>
														<option>MARBLE EFFECT</option>
													</select>
												</td>
												<td>
													<select name="finish[]" class="form-control">
														<option>MATT</option>
														<option selected>GLOSSY</option>
														<option>HIGH GLOSS</option>
													</select>
												</td>
												<td>
													<input type="text" name="client_design[]" class="form-control" placeholder="Client Design Name">
												</td>
												<td>
													<input type="number" name="pallet_qty[]" value="12" class="form-control pallet-qty-input" min="0">
												</td>
												<td>
													<select name="pallet_type[]" class="form-control">
														<option>EURO PINEWOOD</option>
														<option selected>PLASTIC</option>
														<option>METAL</option>
													</select>
												</td>
												<td>
													<input type="number" name="boxes[]" value="420" class="form-control boxes-input" min="0">
												</td>
												<td>
													<select name="box_design[]" class="form-control">
														<option selected>ITACA BRAI</option>
														<option>ITACA BRAND</option>
														<option>CUSTOM</option>
													</select>
												</td>
												<td>
													<input type="number" name="sqm[]" value="1134.00" step="0.01" class="form-control sqm-input" min="0">
												</td>
												<td>
													<button type="button" class="btn btn-success btn-sm add-row">
														<i class="fa fa-plus"></i> Add
													</button>
												</td>
											</tr>
										</tbody>
									</table>
								</div>

								<hr>

								<!-- TOTALS & WEIGHTS -->
								<div class="summary-section">
									<div class="summary-left">
										<div class="summary-item">
											<div class="summary-label">Boxes Total</div>
											<div class="summary-value"><span id="total-boxes">420</span></div>
										</div>
										<div class="summary-item">
											<div class="summary-label">SQM Total</div>
											<div class="summary-value"><span id="total-sqm">1134.00</span></div>
										</div>
									</div>
									<div class="summary-divider"></div>
									<div class="summary-right">
										<div class="summary-item">
											<div class="summary-label">Net Weight</div>
											<div class="summary-value"><span id="net-weight">21000.00 Kg</span></div>
										</div>
										<div class="summary-item">
											<div class="summary-label">Gross Weight</div>
											<div class="summary-value"><span id="gross-weight">21600.00 Kg</span></div>
										</div>
									</div>
								</div>

								<hr>

								<!-- ACTION BUTTONS -->
								<div class="text-right">
									<div class="sequence-indicator">Sequence 2</div>
									<a href="<?= base_url('purchaseorder_listing') ?>" class="btn btn-default">
										Cancel
									</a>
									<button type="submit" class="btn btn-success">
										Save PO
									</button>
								</div>

							</form>

						</div>
					</div>

				</div>
			</div>

		</div>
	</div>
</div>

<?php $this->view('lib/footer'); ?>

<script>
// Make calculateWeights globally accessible
window.calculateWeights = function() {
	const weightPerBox = parseFloat($('#weight-per-box').val()) || 50;
	const emptyPalletWeight = parseFloat($('#empty-pallet-weight').val()) || 50;

	let totalBoxes = 0;
	let totalSqm = 0;
	let totalPallets = 0;

	// Iterate through table rows to sum up
	$('#product-tbody tr').each(function() {
		var $row = $(this);
		var boxes = parseFloat($row.find('input[name="boxes[]"]').val()) || 0;
		var sqm = parseFloat($row.find('input[name="sqm[]"]').val()) || 0;
		var pallets = parseFloat($row.find('input[name="pallet_qty[]"]').val()) || 0;

		totalBoxes += boxes;
		totalSqm += sqm;
		totalPallets += pallets;
	});

	// Update Totals
	$('#total-boxes').text(totalBoxes);
	$('#total-sqm').text(totalSqm.toFixed(2));

	// Calculate Weights
	const netWeight = totalBoxes * weightPerBox;
	const totalEmptyWeight = totalPallets * emptyPalletWeight;
	const grossWeight = netWeight + totalEmptyWeight;

	$('#net-weight').text(netWeight.toFixed(2) + ' Kg');
	$('#gross-weight').text(grossWeight.toFixed(2) + ' Kg');
};

$(document).ready(function() {
	// Initialize date picker
	$('#po-date').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		orientation: 'bottom auto'
	}).on('changeDate', function(e) {
		// Update hidden field with Y-m-d format
		var selectedDate = e.format('yyyy-mm-dd');
		$('#po-date-hidden').val(selectedDate);
		calculateWeights();
	});

	// Attach listeners to calculation inputs
	$(document).on('input change', '.boxes-input, .sqm-input, .pallet-qty-input', function() {
		calculateWeights();
	});

	// Initial calculation
	calculateWeights();
});
</script>

<script src="<?= base_url('adminast/assets/js/purchase-order.js') ?>"></script>

