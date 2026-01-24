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
	.po-field-disabled {
		background-color: #e9ecef !important;
		cursor: not-allowed;
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
						<li class="active"><?= (isset($edit_mode) && $edit_mode) ? 'Edit Purchase Order' : 'Create Purchase Order' ?></li>
					</ol>

					<div class="page-header">
						<h3><?= (isset($edit_mode) && $edit_mode) ? 'Edit Purchase Order' : 'Create Purchase Order' ?></h3>
						<p class="text-muted"><?= (isset($edit_mode) && $edit_mode) ? 'Update purchase order details' : 'Add new purchase order details' ?></p>
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

							<form id="po-form" method="post">
								<?php if (isset($edit_mode) && $edit_mode && isset($po_data) && $po_data): ?>
									<input type="hidden" name="purchase_order_id" id="purchase-order-id" value="<?= (int)$po_data->purchase_order_id ?>">
								<?php endif; ?>

								<!-- BASIC INFO -->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>PO Number (SR.NO)</label>
											<input type="text" name="po_number" id="po-number" class="form-control<?= (isset($edit_mode) && $edit_mode) ? ' po-field-disabled' : '' ?>" placeholder="Enter PO number" required maxlength="100" value="<?= (isset($edit_mode) && $edit_mode && isset($po_data) && $po_data) ? htmlspecialchars($po_data->purchase_order_no) : '' ?>"<?= (isset($edit_mode) && $edit_mode) ? ' readonly' : '' ?>>
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Date</label>
											<div class="date-input-wrapper">
												<input type="text" name="po_date" id="po-date" class="form-control date-picker<?= (isset($edit_mode) && $edit_mode) ? ' po-field-disabled' : '' ?>" value="<?= (isset($edit_mode) && $edit_mode && isset($po_data) && $po_data && !empty($po_data->purchase_order_date)) ? date('d-m-Y', strtotime($po_data->purchase_order_date)) : date('d-m-Y') ?>" required readonly>
												<i class="fa fa-calendar"></i>
											</div>
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

								<!-- PRODUCT / SIZE / PACKING (from DB) -->
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Product</label>
											<select class="form-control" id="product-select">
												<option value="">Select Product</option>
												<?php
												$products_seen = array();
												if (!empty($allsizeproduct)) {
													foreach ($allsizeproduct as $ap) {
														$key = (int)$ap->product_id;
														if (!isset($products_seen[$key])) {
															$products_seen[$key] = true;
															echo '<option value="' . $key . '" data-series="' . htmlspecialchars($ap->series_name ?? '') . '">' . htmlspecialchars($ap->series_name ?? 'Product ' . $key) . '</option>';
														}
													}
												}
												?>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Size</label>
											<select class="form-control" id="size-select">
												<option value="">Select Size</option>
											</select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Packing</label>
											<select class="form-control" id="packing-select" name="product_size_id">
												<option value="">Select Packing</option>
											</select>
										</div>
									</div>
								</div>

								<input type="hidden" id="weight-per-box" name="weight_per_box" value="<?= (isset($edit_mode) && $edit_mode && isset($po_products) && !empty($po_products) && isset($po_products[0])) ? (float)$po_products[0]->weight_per_box : '0' ?>">
								<input type="hidden" id="sqm-per-box" name="sqm_per_box" value="<?= (isset($edit_mode) && $edit_mode && isset($po_products) && !empty($po_products) && isset($po_products[0])) ? (float)$po_products[0]->sqm_per_box : '0' ?>">
								<input type="hidden" id="empty-pallet-weight" value="50">
								<input type="hidden" name="product_id" id="form-product-id" value="<?= (isset($edit_mode) && $edit_mode && isset($po_products) && !empty($po_products) && isset($po_products[0])) ? (int)$po_products[0]->product_id : '' ?>">
								<input type="hidden" id="form-product-size-id" value="<?= (isset($edit_mode) && $edit_mode && isset($po_products) && !empty($po_products) && isset($po_products[0])) ? (int)$po_products[0]->product_size_id : '' ?>">
								<input type="hidden" name="description_goods" id="form-description-goods" value="<?= (isset($edit_mode) && $edit_mode && isset($po_products) && !empty($po_products) && isset($po_products[0])) ? htmlspecialchars($po_products[0]->description_goods ?? '') : '' ?>">
								<script>
								var allSizeProductData = <?= json_encode($allsizeproduct ?? array()) ?>;
								var editMode = <?= (isset($edit_mode) && $edit_mode) ? 'true' : 'false' ?>;
								var editPoProducts = <?= (isset($edit_mode) && $edit_mode && isset($po_products)) ? json_encode($po_products) : '[]' ?>;
								</script>

								<!-- PRODUCT TABLE (Design, Finish, Pallet Type, Box Design from DB) -->
								<div class="table-responsive">
									<table class="table table-bordered table-striped product-table">
										<thead>
											<tr>
												<th>Design</th>
												<th>Finish</th>
												<th>Client Name</th>
												<th>No Of Pallet</th>
												<th>Pallet Type</th>
												<th>Boxes</th>
												<th>Box Design</th>
												<th>SQM</th>
												<th>Action</th>
											</tr>
										</thead>
										<tbody id="product-tbody">
											<?php if (isset($edit_mode) && $edit_mode && isset($po_products) && !empty($po_products)): ?>
												<?php 
												$row_count = 0;
												foreach ($po_products as $prod): 
													if (empty($prod->packing)) continue;
													foreach ($prod->packing as $pack):
														$row_count++;
												?>
												<tr class="product-row" data-row="<?= $row_count ?>">
													<td>
														<select name="design_id[]" class="form-control design-select" data-row="<?= $row_count ?>">
															<option value="">Select Design</option>
															<?php
															if (isset($designs_data[$prod->product_id])):
																foreach ($designs_data[$prod->product_id] as $d):
																	$selected = ((int)$d->packing_model_id === (int)$pack->design_id) ? 'selected' : '';
															?>
																	<option value="<?= (int)$d->packing_model_id ?>" <?= $selected ?>><?= htmlspecialchars($d->model_name) ?></option>
															<?php 
																endforeach;
															endif;
															?>
														</select>
													</td>
													<td>
														<select name="finish_id[]" class="form-control finish-select" data-row="<?= $row_count ?>" data-selected-finish="<?= (int)($pack->finish_id ?? 0) ?>">
															<option value="">Select Finish</option>
															<?php
															if (!empty($pack->design_id) && isset($finishes_data[$pack->design_id])):
																foreach ($finishes_data[$pack->design_id] as $f):
																	$selected = ((int)$f->finish_id === (int)$pack->finish_id) ? 'selected' : '';
															?>
																	<option value="<?= (int)$f->finish_id ?>" <?= $selected ?>><?= htmlspecialchars($f->finish_name) ?></option>
															<?php 
																endforeach;
															endif;
															?>
														</select>
													</td>
													<td>
														<input type="text" name="client_name[]" class="form-control" placeholder="Client Design Name" value="<?= htmlspecialchars($pack->client_name ?? '') ?>">
													</td>
													<td>
														<input type="number" name="no_of_pallet[]" value="<?= (int)$pack->no_of_pallet ?>" class="form-control pallet-qty-input" min="0">
													</td>
													<td>
														<select name="pallet_type_id[]" class="form-control">
															<option value="">Select Pallet Type</option>
															<?php foreach ($pallet_type as $p): 
																$selected = ((int)$p->pallet_type_id === (int)($pack->pallet_type_id ?? 0)) ? 'selected' : '';
															?>
																<option value="<?= (int)$p->pallet_type_id ?>" <?= $selected ?>><?= htmlspecialchars($p->pallet_type_name) ?></option>
															<?php endforeach; ?>
														</select>
													</td>
													<td>
														<input type="number" name="no_of_boxes[]" value="<?= (int)$pack->no_of_boxes ?>" class="form-control boxes-input" min="0">
													</td>
													<td>
														<select name="box_design_id[]" class="form-control">
															<option value="">Select Box Design</option>
															<?php foreach ($box_design as $b): 
																$selected = ((int)$b->box_design_id === (int)($pack->box_design_id ?? 0)) ? 'selected' : '';
															?>
																<option value="<?= (int)$b->box_design_id ?>" <?= $selected ?>><?= htmlspecialchars($b->box_design_name) ?></option>
															<?php endforeach; ?>
														</select>
													</td>
													<td>
														<input type="number" name="no_of_sqm[]" value="<?= number_format((float)$pack->no_of_sqm, 2, '.', '') ?>" step="0.01" class="form-control sqm-input" min="0" readonly>
													</td>
													<td>
														<button type="button" class="btn btn-danger btn-sm remove-row"><i class="fa fa-trash"></i> Remove</button>
													</td>
												</tr>
												<?php 
													endforeach;
												endforeach;
												if ($row_count == 0):
												?>
												<tr class="product-row product-row-empty">
													<td colspan="9" class="text-center text-muted">No product rows found.</td>
												</tr>
												<?php endif; ?>
											<?php else: ?>
												<tr class="product-row product-row-empty">
													<td colspan="9" class="text-center text-muted">Select Product, Size, and Packing above to add rows.</td>
												</tr>
											<?php endif; ?>
										</tbody>
										<tfoot>
											<tr>
												<td colspan="5" class="text-right"><strong>Totals</strong></td>
												<td><span id="total-boxes">0</span></td>
												<td></td>
												<td><span id="total-sqm">0.00</span></td>
												<td>
													<button type="button" class="btn btn-success btn-sm" id="add-product-row"><i class="fa fa-plus"></i> Add Row</button>
												</td>
											</tr>
										</tfoot>
									</table>
								</div>

								<hr>

								<!-- TOTALS & WEIGHTS -->
								<div class="summary-section">
									<div class="summary-left">
										<div class="summary-item">
											<div class="summary-label">Boxes Total</div>
											<div class="summary-value"><span id="summary-total-boxes">0</span></div>
										</div>
										<div class="summary-item">
											<div class="summary-label">SQM Total</div>
											<div class="summary-value"><span id="summary-total-sqm">0.00</span></div>
										</div>
									</div>
									<div class="summary-divider"></div>
									<div class="summary-right">
										<div class="summary-item">
											<div class="summary-label">Net Weight</div>
											<div class="summary-value"><span id="net-weight">0.00 Kg</span></div>
										</div>
										<div class="summary-item">
											<div class="summary-label">Gross Weight</div>
											<div class="summary-value"><span id="gross-weight">0.00 Kg</span></div>
										</div>
									</div>
								</div>

								<hr>

								<!-- ACTION BUTTONS -->
								<div class="text-right">
									<a href="<?= base_url('purchaseorder_listing') ?>" class="btn btn-default">Cancel</a>
									<button type="submit" class="btn btn-success" id="po-submit-btn"><?= (isset($edit_mode) && $edit_mode) ? 'Update PO' : 'Save PO' ?></button>
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
var poRowCount = 0;
var root = '<?= base_url() ?>';

function calculateWeights() {
	var weightPerBox = parseFloat($('#weight-per-box').val()) || 0;
	var emptyPalletWeight = parseFloat($('#empty-pallet-weight').val()) || 50;
	var totalBoxes = 0, totalSqm = 0, totalPallets = 0;

	$('#product-tbody tr.product-row').not('.product-row-empty').each(function() {
		var $row = $(this);
		var boxes = parseFloat($row.find('input[name="no_of_boxes[]"]').val()) || 0;
		var sqm = parseFloat($row.find('input[name="no_of_sqm[]"]').val()) || 0;
		var pallets = parseFloat($row.find('input[name="no_of_pallet[]"]').val()) || 0;
		totalBoxes += boxes;
		totalSqm += sqm;
		totalPallets += pallets;
	});

	$('#total-boxes, #summary-total-boxes').text(totalBoxes);
	$('#total-sqm, #summary-total-sqm').text(totalSqm.toFixed(2));
	var netWeight = totalBoxes * weightPerBox;
	var grossWeight = netWeight + totalPallets * emptyPalletWeight;
	$('#net-weight').text(netWeight.toFixed(2) + ' Kg');
	$('#gross-weight').text(grossWeight.toFixed(2) + ' Kg');
}

$(document).ready(function() {
	if (typeof editMode === 'undefined' || !editMode) {
		$('#po-date').datepicker({
			format: 'dd-mm-yyyy',
			autoclose: true,
			todayHighlight: true,
			orientation: 'bottom auto'
		});
	}

	// Product selection - filter sizes
	$('#product-select').on('change', function() {
		var productId = $(this).val();
		$('#size-select').html('<option value="">Select Size</option>');
		$('#packing-select').html('<option value="">Select Packing</option>');
		$('#form-product-id').val(productId);
		if (!productId) {
			$('#form-product-size-id').val('');
			$('#weight-per-box, #sqm-per-box').val(0);
			$('#product-tbody').html('<tr class="product-row product-row-empty"><td colspan="9" class="text-center text-muted">Select Product, Size, and Packing above to add rows.</td></tr>');
			calculateWeights();
			return;
		}
		var sizes = {};
		allSizeProductData.forEach(function(item) {
			if (parseInt(item.product_id) === parseInt(productId) && item.size_type_mm) {
				var sizeKey = item.size_type_mm;
				if (!sizes[sizeKey]) {
					sizes[sizeKey] = { size: sizeKey, thickness: item.thickness || '' };
				}
			}
		});
		$.each(sizes, function(key, val) {
			var label = val.size + (val.thickness ? ' - ' + val.thickness + ' MM' : '');
			$('#size-select').append('<option value="' + key + '">' + label + '</option>');
		});
		calculateWeights();
	});

	// Size selection - filter packings
	$('#size-select').on('change', function() {
		var productId = $('#product-select').val();
		var sizeType = $(this).val();
		$('#packing-select').html('<option value="">Select Packing</option>');
		if (!productId || !sizeType) {
			$('#form-product-size-id').val('');
			$('#weight-per-box, #sqm-per-box').val(0);
			$('#product-tbody').html('<tr class="product-row product-row-empty"><td colspan="9" class="text-center text-muted">Select Product, Size, and Packing above to add rows.</td></tr>');
			calculateWeights();
			return;
		}
		var packings = {};
		allSizeProductData.forEach(function(item) {
			if (parseInt(item.product_id) === parseInt(productId) && item.size_type_mm === sizeType && item.product_packing_name) {
				var packKey = parseInt(item.product_size_id);
				if (!packings[packKey]) {
					packings[packKey] = item.product_packing_name;
				}
			}
		});
		$.each(packings, function(id, name) {
			$('#packing-select').append('<option value="' + id + '">' + name + '</option>');
		});
		calculateWeights();
	});

	// Packing selection - load product details and auto-add first row
	$('#packing-select').on('change', function() {
		var id = $(this).val();
		// Only clear rows if not in edit mode or if rows are empty
		if (typeof editMode === 'undefined' || !editMode || $('#product-tbody tr.product-row').not('.product-row-empty').length === 0) {
			$('#product-tbody').html('<tr class="product-row product-row-empty"><td colspan="9" class="text-center text-muted">Select Product, Size, and Packing above to add rows.</td></tr>');
		}
		calculateWeights();
		if (!id) {
			$('#form-product-size-id').val('');
			$('#weight-per-box, #sqm-per-box').val(0);
			return;
		}
		$.post(root + 'purchaseorder_listing/load_packing_po', { product_size_id: id }, function(r) {
			var d = typeof r === 'string' ? JSON.parse(r) : r;
			if (!d.ok) {
				alert(d.msg || 'Failed to load packing details.');
				return;
			}
			$('#form-product-id').val(d.product_id);
			$('#form-product-size-id').val(id);
			$('#form-description-goods').val(d.description);
			$('#weight-per-box').val(d.weight_per_box);
			$('#sqm-per-box').val(d.sqm_per_box);
			window.poDesignHtml = d.design_html;
			// Auto-add first row only if not in edit mode or if no rows exist
			if (typeof editMode === 'undefined' || !editMode || $('#product-tbody tr.product-row').not('.product-row-empty').length === 0) {
				var pid = d.product_id;
				if (pid) {
					poRowCount = 1;
					$.post(root + 'purchaseorder_listing/add_design_row_po', { product_id: pid, row_no: poRowCount }, function(r) {
						var d2 = typeof r === 'string' ? JSON.parse(r) : r;
						if (d2.html) {
							$('.product-row-empty').remove();
							$('#product-tbody').append(d2.html);
							calculateWeights();
						}
					}).fail(function() {
						alert('Failed to add product row. Please try again.');
					});
				}
			}
		}).fail(function() {
			alert('Failed to load packing details. Please try again.');
		});
	});

	$(document).on('change', '.design-select', function() {
		var designId = $(this).val();
		var $row = $(this).closest('tr');
		var $finish = $row.find('.finish-select');
		var selectedFinish = $finish.data('selected-finish') || $finish.val();
		$finish.html('<option value="">Loading...</option>');
		if (!designId) { 
			$finish.html('<option value="">Select Finish</option>'); 
			return; 
		}
		$.post(root + 'purchaseorder_listing/load_finish_po', { id: designId }, function(r) {
			var d = typeof r === 'string' ? JSON.parse(r) : r;
			$finish.html(d.html || '<option value="">Select Finish</option>');
			// Restore selected finish if it exists
			if (selectedFinish) {
				$finish.val(selectedFinish);
			}
		}).fail(function() {
			$finish.html('<option value="">Error loading finishes</option>');
			alert('Failed to load finish options. Please try again.');
		});
	});

	$(document).on('input change', '.boxes-input, .sqm-input, .pallet-qty-input', function() {
		var $row = $(this).closest('tr');
		var sqmBox = parseFloat($('#sqm-per-box').val()) || 0;
		var boxes = parseFloat($row.find('input[name="no_of_boxes[]"]').val()) || 0;
		if (boxes < 0) {
			$row.find('input[name="no_of_boxes[]"]').val(0);
			boxes = 0;
		}
		$row.find('input[name="no_of_sqm[]"]').val((boxes * sqmBox).toFixed(2));
		calculateWeights();
	});

	$('#add-product-row').on('click', function() {
		var pid = $('#form-product-id').val();
		if (!pid) { 
			alert('Select Product (Size – Packing) first.'); 
			return; 
		}
		poRowCount++;
		$.post(root + 'purchaseorder_listing/add_design_row_po', { product_id: pid, row_no: poRowCount }, function(r) {
			var d = typeof r === 'string' ? JSON.parse(r) : r;
			if (d.html) {
				$('.product-row-empty').remove();
				$('#product-tbody').append(d.html);
				calculateWeights();
			} else {
				alert('Failed to add product row.');
			}
		}).fail(function() {
			alert('Failed to add product row. Please try again.');
		});
	});

	$(document).on('click', '.remove-row', function() {
		var $row = $(this).closest('tr');
		var n = $('#product-tbody tr.product-row').not('.product-row-empty').length;
		if (n <= 1) {
			$('#product-tbody').html('<tr class="product-row product-row-empty"><td colspan="9" class="text-center text-muted">Select Product, Size, and Packing above to add rows.</td></tr>');
		} else {
			$row.remove();
		}
		calculateWeights();
	});

	$('#po-form').on('submit', function(e) {
		e.preventDefault();
		if (!$('#form-product-id').val()) { 
			alert('Select Product, Size, and Packing.'); 
			return; 
		}
		var hasRow = $('#product-tbody tr.product-row').not('.product-row-empty').length > 0;
		if (!hasRow) { 
			alert('Add at least one product row.'); 
			return; 
		}
		
		// Validate all product rows have required fields
		var isValid = true;
		var errorMsg = '';
		$('#product-tbody tr.product-row').not('.product-row-empty').each(function() {
			var $row = $(this);
			var design = $row.find('select[name="design_id[]"]').val();
			var finish = $row.find('select[name="finish_id[]"]').val();
			var boxes = parseFloat($row.find('input[name="no_of_boxes[]"]').val()) || 0;
			var sqm = parseFloat($row.find('input[name="no_of_sqm[]"]').val()) || 0;
			
			if (!design || design === '') {
				isValid = false;
				errorMsg = 'Design is required for all product rows.';
				return false;
			}
			if (!finish || finish === '') {
				isValid = false;
				errorMsg = 'Finish is required for all product rows.';
				return false;
			}
			if (boxes <= 0) {
				isValid = false;
				errorMsg = 'Number of boxes must be greater than 0 for all product rows.';
				return false;
			}
			if (sqm <= 0) {
				isValid = false;
				errorMsg = 'SQM must be greater than 0 for all product rows.';
				return false;
			}
		});
		
		if (!isValid) {
			alert(errorMsg);
			return;
		}
		
		var btnText = (typeof editMode !== 'undefined' && editMode) ? 'Updating...' : 'Saving...';
		var $btn = $('#po-submit-btn').prop('disabled', true).text(btnText);
		$.ajax({
			url: root + 'purchaseorder_listing/save_purchase_order',
			type: 'POST',
			data: $('#po-form').serialize(),
			success: function(res) {
				var r = typeof res === 'string' ? JSON.parse(res) : res;
				if (r.res === '1') {
					alert(r.msg || 'Purchase order saved successfully.');
					window.location = root + 'purchaseorder_listing/view_po/' + r.purchase_order_id;
				} else {
					alert(r.msg || 'Error saving purchase order.');
					var btnText = (typeof editMode !== 'undefined' && editMode) ? 'Update PO' : 'Save PO';
					$btn.prop('disabled', false).text(btnText);
				}
			},
			error: function(xhr, status, error) {
				console.error('AJAX Error:', status, error);
				alert('Request failed. Please check your connection and try again.');
				var btnText = (typeof editMode !== 'undefined' && editMode) ? 'Update PO' : 'Save PO';
				$btn.prop('disabled', false).text(btnText);
			},
			complete: function() {
				// Button state handled in success/error
			}
		});
	});

	// Initialize edit mode if applicable
	if (typeof editMode !== 'undefined' && editMode && typeof editPoProducts !== 'undefined' && editPoProducts.length > 0) {
		var firstProd = editPoProducts[0];
		if (firstProd.product_id && firstProd.product_size_id) {
			// Count existing rows for poRowCount
			poRowCount = $('#product-tbody tr.product-row').not('.product-row-empty').length;
			if (poRowCount === 0) {
				poRowCount = 1;
			}
			
			// Set product
			$('#product-select').val(firstProd.product_id);
			
			// Populate sizes for this product
			var sizes = {};
			allSizeProductData.forEach(function(item) {
				if (parseInt(item.product_id) === parseInt(firstProd.product_id) && item.size_type_mm) {
					var sizeKey = item.size_type_mm;
					if (!sizes[sizeKey]) {
						sizes[sizeKey] = { size: sizeKey, thickness: item.thickness || '' };
					}
				}
			});
			$('#size-select').html('<option value="">Select Size</option>');
			$.each(sizes, function(key, val) {
				var label = val.size + (val.thickness ? ' - ' + val.thickness + ' MM' : '');
				var selected = (key === firstProd.size_type_mm) ? 'selected' : '';
				$('#size-select').append('<option value="' + key + '" ' + selected + '>' + label + '</option>');
			});
			
			// Populate packings for this product and size
			var packings = {};
			allSizeProductData.forEach(function(item) {
				if (parseInt(item.product_id) === parseInt(firstProd.product_id) && item.size_type_mm === firstProd.size_type_mm && item.product_packing_name) {
					var packKey = parseInt(item.product_size_id);
					if (!packings[packKey]) {
						packings[packKey] = item.product_packing_name;
					}
				}
			});
			$('#packing-select').html('<option value="">Select Packing</option>');
			$.each(packings, function(id, name) {
				var selected = (parseInt(id) === parseInt(firstProd.product_size_id)) ? 'selected' : '';
				$('#packing-select').append('<option value="' + id + '" ' + selected + '>' + name + '</option>');
			});
			
			// Calculate weights with existing rows
			setTimeout(function() {
				calculateWeights();
			}, 300);
		}
	}
});
</script>

