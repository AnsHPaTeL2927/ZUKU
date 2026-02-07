<?php
$this->view('lib/header');
?>
<style>
	#stock_table th,
	#stock_table td {
		padding: 10px 14px;
		white-space: nowrap;
	}
	#stock_table th { font-weight: 600; }
	/* Horizontal scroll so all columns are visible */
	#stock_table_wrapper {
		overflow-x: auto;
		overflow-y: visible;
		-webkit-overflow-scrolling: touch;
		margin-bottom: 12px;
	}
	#stock_table_wrapper::-webkit-scrollbar {
		height: 10px;
	}
	#stock_table_wrapper::-webkit-scrollbar-track {
		background: #f1f1f1;
		border-radius: 5px;
	}
	#stock_table_wrapper::-webkit-scrollbar-thumb {
		background: #337ab7;
		border-radius: 5px;
	}
	#stock_table_wrapper::-webkit-scrollbar-thumb:hover {
		background: #286090;
	}
	#stock_table {
		min-width: 2400px;
		width: 100%;
	}
	#stock_table_loader {
		position: relative;
		height: 4px;
		background: #f0f0f0;
		border-radius: 2px;
		overflow: hidden;
		margin-bottom: 12px;
		display: none;
	}
	#stock_table_loader.active {
		display: block;
	}
	#stock_table_loader .loader-bar {
		position: absolute;
		height: 100%;
		width: 35%;
		background: linear-gradient(90deg, transparent, #337ab7, transparent);
		animation: stockLoader 1.2s ease-in-out infinite;
	}
	@keyframes stockLoader {
		0% { left: -35%; }
		100% { left: 100%; }
	}
</style>
<div class="main-container">
	<?php $this->view('lib/sidebar'); ?>
	<div class="main-content">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<ol class="breadcrumb">
						<li>
							<i class="clip-pencil"></i>
							<a href="<?= base_url() ?>dashboard">Dashboard</a>
						</li>
						<li class="active">
							<a href="<?= base_url() ?>stock">Stock Details</a>
						</li>
					</ol>
					<div class="page-header title1">
						<h3>Stock Details</h3>
						<p class="text-muted" style="margin-top: 5px; font-size: 13px;">Manage and track inventory stock.</p>
					</div>
				</div>
			</div>

			<!-- Search and Filter Section -->
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-filter"></i> Search & Filter
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="col-md-2">
									<label class="control-label"><strong>SEARCH</strong></label>
									<input type="text" id="stock_search" class="form-control" placeholder="Search by design name, SKU, size, finish..." />
								</div>
								<div class="col-md-2">
									<label class="control-label"><strong>PI NO.</strong></label>
									<select class="form-control" id="pi_no" name="pi_no">
										<option value="">All PI Numbers</option>
										<?php
										$pi_numbers = isset($pi_numbers) && is_array($pi_numbers) ? $pi_numbers : array();
										$selected_pi = isset($selected_pi) ? $selected_pi : '';
										foreach ($pi_numbers as $pi) {
											$inv_no = isset($pi->invoice_no) ? htmlspecialchars($pi->invoice_no) : '';
											if ($inv_no === '') continue;
											$sel = ($selected_pi !== '' && $selected_pi === $inv_no) ? ' selected="selected"' : '';
											echo '<option value="' . htmlspecialchars($inv_no) . '"' . $sel . '>' . htmlspecialchars($inv_no) . '</option>';
										}
										?>
									</select>
								</div>
								<div class="col-md-2">
									<label class="control-label"><strong>LOCATION</strong></label>
									<select class="form-control" id="location" name="location">
										<option value="">All Locations</option>
										<?php
										$warehouses = isset($warehouses) && is_array($warehouses) ? $warehouses : array();
										$selected_warehouse = isset($selected_warehouse) ? $selected_warehouse : '';
										foreach ($warehouses as $wh) {
											$wh_id = isset($wh->id) ? (int)$wh->id : 0;
											$wh_label = isset($wh->name) && trim($wh->name) !== '' ? htmlspecialchars($wh->name) : (isset($wh->warehouse_number) ? 'WareHouse #' . htmlspecialchars($wh->warehouse_number) : 'ID ' . $wh_id);
											if ($wh_id > 0) {
												$sel = ($selected_warehouse !== '' && (string)$wh_id === (string)$selected_warehouse) ? ' selected="selected"' : '';
												echo '<option value="' . $wh_id . '"' . $sel . '>' . $wh_label . '</option>';
											}
										}
										?>
									</select>
								</div>
								<div class="col-md-2">
									<label class="control-label"><strong>DATE</strong></label>
									<input type="text" id="stock_date" class="form-control defualt-date-picker" placeholder="dd-mm-yyyy" autocomplete="off" />
								</div>
								<div class="col-md-4 text-right" style="padding-top: 25px;">
									<button type="button" class="btn btn-success"><i class="fa fa-file-excel-o"></i> Export to Excel</button>
									<button type="button" class="btn btn-danger"><i class="fa fa-file-pdf-o"></i> Export to PDF</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Stock Table -->
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-list"></i> Stock List
							<?php if (!empty($stock_list) && is_array($stock_list)): ?>
								<span class="text-muted pull-right" style="font-size: 12px; font-weight: normal;">Entries from Add to Inventory (Loading Plan)</span>
							<?php else: ?>
								<span class="text-muted pull-right" style="font-size: 12px; font-weight: normal;">Use Add to Inventory in Loading Plan to add PIs to stock</span>
							<?php endif; ?>
						</div>
						<div class="panel-body">
							<div id="stock_table_loader" class="active">
								<div class="loader-bar"></div>
							</div>
							<div class="table-responsive" id="stock_table_wrapper">
								<table class="table table-bordered table-hover table-striped" id="stock_table">
									<thead>
										<tr>
											<th>SR NO</th>
											<th>DATE</th>
											<th>PI NO.</th>
											<th>SKU CODE</th>
											<th>DESIGN NAME</th>
											<th>SIZE</th>
											<th>SUPPLIER & COUNTRY</th>
										<?php
										$stock_warehouses = isset($stock_warehouses) && is_array($stock_warehouses) ? $stock_warehouses : array();
										$selected_warehouse = isset($selected_warehouse) ? $selected_warehouse : '';
										// When a warehouse is selected in LOCATION, show only that warehouse column
										$display_warehouses = $stock_warehouses;
										if ($selected_warehouse !== '') {
											$display_warehouses = array_filter($stock_warehouses, function($wh) use ($selected_warehouse) {
												return (string)(isset($wh->id) ? $wh->id : '') === (string)$selected_warehouse;
											});
											if (empty($display_warehouses)) {
												$wh_id = (int)$selected_warehouse;
												$display_warehouses = array((object)array('id' => $wh_id, 'name' => 'WareHouse #' . $wh_id, 'warehouse_number' => $wh_id));
											}
										}
										foreach ($display_warehouses as $wh) {
												$wh_label = isset($wh->name) && trim($wh->name) !== '' ? htmlspecialchars($wh->name) : (isset($wh->warehouse_number) ? 'WareHouse #' . htmlspecialchars($wh->warehouse_number) : 'WH ' . (int)$wh->id);
												echo '<th>' . $wh_label . ' [M²]</th>';
											}
											?>
											<th>TOTAL STOCK [M²]</th>
											<th>TOTAL SALES LAST 6 MONTHS [M²]</th>
											<th>AVG. MONTHLY SALES [M²]</th>
											<th>AVG. DAILY SALES [M²]</th>
											<th>LEAD TIME [DAYS]</th>
											<th>SAFETY STOCK [DAYS]</th>
											<th>REORDER POINT ROP [M²]</th>
											<th>DAYS OF STOCK COVERAGE</th>
											<th>ETD [DEPARTURE DATE]</th>
											<th>ETA [ARRIVAL DATE]</th>
											<th>DAYS UNTIL DELIVERY</th>
											<th>DAYS OUT OF STOCK BEFORE DELIVERY</th>
											<th>LOST SALES [M²]</th>
											<th>DECISION: ORDER?</th>
											<th>ACTION</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$stock_list = isset($stock_list) && is_array($stock_list) ? $stock_list : array();
										if (!empty($stock_list)) {
											$sr = 1;
											foreach ($stock_list as $row) {
												$date = !empty($row->performa_date) ? date('d/m/Y', strtotime($row->performa_date)) : '';
												$pi_no = isset($row->invoice_no) ? htmlspecialchars($row->invoice_no) : '-';
												$sku = isset($row->sku_code) && $row->sku_code !== '' ? htmlspecialchars($row->sku_code) : (isset($row->design_id) ? 'D-' . intval($row->design_id) : '-');
												$design = isset($row->design_name) ? htmlspecialchars($row->design_name) : '-';
												$size = isset($row->size) ? htmlspecialchars($row->size) : '-';
												$total_stock_val = isset($row->total_quantity) ? (float)$row->total_quantity : 0;
												$total_stock = number_format($total_stock_val, 2, '.', '');
												$total_sales_6m_val = isset($row->total_sales_6m_sqm) ? (float)$row->total_sales_6m_sqm : 0;
												$total_sales_6m = number_format($total_sales_6m_val, 2, '.', '');
												$avg_monthly_val = $total_sales_6m_val / 6;  /* AVG. MONTHLY = TOTAL SALES 6M / 6 */
												$avg_monthly = number_format($avg_monthly_val, 2, '.', '');
												$avg_daily_val = $avg_monthly_val / 30;  /* AVG. DAILY = AVG. MONTHLY / 30 */
												$avg_daily = number_format($avg_daily_val, 2, '.', '');
												$lead_time = isset($row->lead_time_days) ? (int)$row->lead_time_days : 0;
												$safety_stock = isset($row->safety_stock_days) ? (int)$row->safety_stock_days : 0;
												$reorder_point_val = $avg_daily_val * ($lead_time + $safety_stock);  /* ROP = AVG. DAILY * (LEAD TIME + SAFETY STOCK) */
												$reorder_point = number_format($reorder_point_val, 2, '.', '');
												$days_coverage = ($avg_daily_val > 0) ? (int)($total_stock_val / $avg_daily_val) : 0;  /* DAYS OF COVERAGE = total stock / AVG. DAILY (or 0 if AVG. DAILY = 0) */
												$etd = isset($row->etd) && !empty($row->etd) ? date('d/m/Y', strtotime($row->etd)) : '-';
												$eta = isset($row->eta) && !empty($row->eta) ? date('d/m/Y', strtotime($row->eta)) : '-';
												$eta_valid = isset($row->eta) && !empty($row->eta) && !in_array($row->eta, array('0000-00-00', '1970-01-01'));
												$days_until_val = $eta_valid ? (int)round((strtotime($row->eta) - time()) / 86400) : null;  /* DAYS UNTIL DELIVERY = ETA - Today (days) */
												$days_until = ($days_until_val !== null) ? $days_until_val : '-';
												$days_out_val = ($days_until_val !== null) ? max(0, $days_until_val - $days_coverage) : null;  /* DAYS OUT = Max(0, DAYS UNTIL - Days of stock Coverage) */
												$days_out = ($days_out_val !== null) ? $days_out_val : '-';
												$lost_sales_val = ($days_out_val !== null && $days_out_val > 0) ? ($days_out_val * $avg_daily_val) : 0;  /* LOST SALES = Days out of stock before delivery * Avg. Daily Sales */
												$lost_sales = number_format($lost_sales_val, 2, '.', '');
										?>
											<tr>
												<td><?= $sr++ ?></td>
												<td><?= $date ?></td>
												<td><?= $pi_no ?></td>
												<td><?= $sku ?></td>
												<td><?= $design ?></td>
												<td><?= $size ?></td>
												<td>-</td>
												<?php foreach ($display_warehouses as $wh): $col = 'wh_' . (int)$wh->id; $qty = isset($row->$col) ? number_format((float)$row->$col, 2, '.', '') : '0'; ?>
												<td class="text-right"><?= $qty ?></td>
												<?php endforeach; ?>
												<td class="text-right"><?= $total_stock ?></td>
												<td class="text-right"><?= $total_sales_6m ?></td>
												<td class="text-right"><?= $avg_monthly ?></td>
												<td class="text-right"><?= $avg_daily ?></td>
												<td class="text-center"><?= $lead_time ?></td>
												<td class="text-center"><?= $safety_stock ?></td>
												<td class="text-right"><?= $reorder_point ?></td>
												<td class="text-center"><?= $days_coverage ?></td>
												<td><?= $etd ?></td>
												<td><?= $eta ?></td>
												<td class="text-center"><?= $days_until ?></td>
												<td class="text-center"><?= $days_out ?></td>
												<td class="text-right"><?= $lost_sales ?></td>
												<td><a href="javascript:;" class="text-primary">-</a></td>
												<td>
													<a href="javascript:;" class="btn btn-default btn-sm btn-edit-stock" data-row="<?= htmlspecialchars(json_encode(array(
														'design_name' => $design,
														'sku' => $sku,
														'warehouses' => array_map(function($wh) use ($row) { $c = 'wh_' . (int)$wh->id; return array('id' => (int)$wh->id, 'name' => (isset($wh->name) && trim($wh->name) !== '' ? $wh->name : 'WareHouse #' . (isset($wh->warehouse_number) ? $wh->warehouse_number : $wh->id)), 'value' => isset($row->$c) ? (float)$row->$c : 0); }, $display_warehouses),
														'total_stock' => $total_stock_val,
														'reorder_point' => $reorder_point_val
													)), ENT_QUOTES, 'UTF-8') ?>"><i class="fa fa-pencil"></i> Edit Stock</a>
												</td>
											</tr>
										<?php
											}
										} else {
											$colspan = 8 + count($display_warehouses) + 14;
										?>
											<tr>
												<td colspan="<?= $colspan ?>" class="text-center text-muted" style="padding: 24px;">No stock entries. Use <strong>Add to Inventory</strong> in Loading Plan to add PIs to stock.</td>
											</tr>
										<?php
										}
										?>
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

<!-- Edit Stock Details Modal -->
<div class="modal fade" id="editStockModal" tabindex="-1" role="dialog" aria-labelledby="editStockModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="editStockModalLabel">Edit Stock Details</h4>
			</div>
			<div class="modal-body">
				<form id="editStockForm">
					<div id="editStockWarehouseFields"></div>
					<div class="form-group">
						<label class="control-label">Total stock [m²]</label>
						<input type="number" step="0.01" min="0" class="form-control" id="editStockTotalStock" placeholder="0" />
					</div>
					<div class="form-group">
						<label class="control-label">Reorder Point ROP [m²]</label>
						<input type="number" step="0.01" min="0" class="form-control" id="editStockReorderPoint" placeholder="0" />
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
				<button type="button" class="btn btn-primary" id="editStockSaveBtn">Save Changes</button>
			</div>
		</div>
	</div>
</div>

<?php
$this->view('lib/footer');
?>

<script>
	$(function() {
		var $loader = $('#stock_table_loader');
		// Hide horizontal loader when table is ready (brief delay for initial paint)
		setTimeout(function() {
			$loader.removeClass('active');
		}, 400);

		// Optional: use stockTableLoader() when loading data via AJAX
		window.stockTableLoader = function(show) {
			if (show) {
				$loader.addClass('active');
			} else {
				$loader.removeClass('active');
			}
		};

		$('.defualt-date-picker').datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy'
		});
		$('#stock_search').on('keyup', function() {
			var value = $(this).val().toLowerCase();
			$('#stock_table tbody tr').filter(function() {
				$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1);
			});
		});
		// PI NO. filter: reload page with selected PI
		$('#pi_no').on('change', function() {
			var params = [];
			var pi = $(this).val();
			var loc = $('#location').val();
			if (pi) params.push('pi_no=' + encodeURIComponent(pi));
			if (loc) params.push('location=' + encodeURIComponent(loc));
			window.location.href = '<?= base_url() ?>stock' + (params.length ? '?' + params.join('&') : '');
		});
		// LOCATION filter: reload page with selected warehouse (warehouse-wise view)
		$('#location').on('change', function() {
			var params = [];
			var pi = $('#pi_no').val();
			var loc = $(this).val();
			if (pi) params.push('pi_no=' + encodeURIComponent(pi));
			if (loc) params.push('location=' + encodeURIComponent(loc));
			window.location.href = '<?= base_url() ?>stock' + (params.length ? '?' + params.join('&') : '');
		});

		// Edit Stock modal
		$(document).on('click', '.btn-edit-stock', function() {
			var dataStr = $(this).data('row');
			if (!dataStr) return;
			try {
				var row = typeof dataStr === 'string' ? JSON.parse(dataStr) : dataStr;
			} catch (e) { return; }
			var html = '';
			if (row.warehouses && row.warehouses.length) {
				row.warehouses.forEach(function(wh) {
					html += '<div class="form-group">' +
						'<label class="control-label">' + (wh.name || 'Warehouse ' + wh.id) + ' [m²]</label>' +
						'<input type="number" step="0.01" min="0" class="form-control edit-stock-wh" data-wh-id="' + wh.id + '" value="' + (wh.value || 0) + '" />' +
						'</div>';
				});
			}
			$('#editStockWarehouseFields').html(html || '<p class="text-muted">No warehouse columns for this row.</p>');
			$('#editStockTotalStock').val(row.total_stock != null ? row.total_stock : '');
			$('#editStockReorderPoint').val(row.reorder_point != null ? row.reorder_point : '');
			$('#editStockModal').modal('show');
		});
		$('#editStockSaveBtn').on('click', function() {
			// UI only - Save logic can be implemented later
			$('#editStockModal').modal('hide');
		});
	});
</script>
