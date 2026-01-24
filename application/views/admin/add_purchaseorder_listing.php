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

							<form id="po-form" method="post">

								<!-- BASIC INFO -->
								<div class="row">
									<div class="col-md-6">
										<div class="form-group">
											<label>PO Number (SR.NO)</label>
											<input type="text" name="po_number" id="po-number" class="form-control" placeholder="Enter PO number" required maxlength="100">
										</div>
									</div>
									<div class="col-md-6">
										<div class="form-group">
											<label>Date</label>
											<div class="date-input-wrapper">
												<input type="text" name="po_date" id="po-date" class="form-control date-picker" value="<?= date('d-m-Y') ?>" required readonly>
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

								<input type="hidden" id="weight-per-box" name="weight_per_box" value="0">
								<input type="hidden" id="sqm-per-box" name="sqm_per_box" value="0">
								<input type="hidden" id="empty-pallet-weight" value="50">
								<input type="hidden" name="product_id" id="form-product-id" value="">
								<input type="hidden" id="form-product-size-id" value="">
								<input type="hidden" name="description_goods" id="form-description-goods" value="">
								<script>
								var allSizeProductData = <?= json_encode($allsizeproduct ?? array()) ?>;
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
											<tr class="product-row product-row-empty">
												<td colspan="9" class="text-center text-muted">Select Product, Size, and Packing above to add rows.</td>
											</tr>
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
									<button type="submit" class="btn btn-success" id="po-submit-btn">Save PO</button>
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
	$('#po-date').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		orientation: 'bottom auto'
	});

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
		$('#product-tbody').html('<tr class="product-row product-row-empty"><td colspan="9" class="text-center text-muted">Select Product, Size, and Packing above to add rows.</td></tr>');
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
			// Auto-add first row
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
		}).fail(function() {
			alert('Failed to load packing details. Please try again.');
		});
	});

	$(document).on('change', '.design-select', function() {
		var designId = $(this).val();
		var $row = $(this).closest('tr');
		var $finish = $row.find('.finish-select');
		$finish.html('<option value="">Loading...</option>');
		if (!designId) { 
			$finish.html('<option value="">Select Finish</option>'); 
			return; 
		}
		$.post(root + 'purchaseorder_listing/load_finish_po', { id: designId }, function(r) {
			var d = typeof r === 'string' ? JSON.parse(r) : r;
			$finish.html(d.html || '<option value="">Select Finish</option>');
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
		
		var $btn = $('#po-submit-btn').prop('disabled', true).text('Saving...');
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
					$btn.prop('disabled', false).text('Save PO');
				}
			},
			error: function(xhr, status, error) {
				console.error('AJAX Error:', status, error);
				alert('Request failed. Please check your connection and try again.');
				$btn.prop('disabled', false).text('Save PO');
			},
			complete: function() {
				// Button state handled in success/error
			}
		});
	});
});
</script>

