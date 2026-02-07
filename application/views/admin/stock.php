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
											foreach ($stock_warehouses as $wh) {
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
												$total_stock = isset($row->total_quantity) ? number_format((float)$row->total_quantity, 2, '.', '') : '0';
												$total_sales_6m = isset($row->total_sales_6m_sqm) ? number_format((float)$row->total_sales_6m_sqm, 2, '.', '') : '0';
												$avg_monthly = isset($row->avg_monthly_sales_sqm) ? number_format((float)$row->avg_monthly_sales_sqm, 2, '.', '') : '0';
												$avg_daily = isset($row->avg_daily_sales_sqm) ? number_format((float)$row->avg_daily_sales_sqm, 2, '.', '') : '0';
												$lead_time = isset($row->lead_time_days) ? (int)$row->lead_time_days : 0;
												$safety_stock = isset($row->safety_stock_days) ? (int)$row->safety_stock_days : 0;
												$reorder_point = isset($row->reorder_point_sqm) ? number_format((float)$row->reorder_point_sqm, 2, '.', '') : '0';
												$days_coverage = isset($row->days_of_stock_coverage) ? (int)$row->days_of_stock_coverage : 0;
												$etd = isset($row->etd) && !empty($row->etd) ? date('d/m/Y', strtotime($row->etd)) : '-';
												$eta = isset($row->eta) && !empty($row->eta) ? date('d/m/Y', strtotime($row->eta)) : '-';
												$days_until = isset($row->days_until_delivery) ? (int)$row->days_until_delivery : '-';
												$days_out = isset($row->days_out_of_stock_before_delivery) ? (int)$row->days_out_of_stock_before_delivery : '-';
												$lost_sales = isset($row->lost_sales_sqm) ? number_format((float)$row->lost_sales_sqm, 2, '.', '') : '0';
										?>
											<tr>
												<td><?= $sr++ ?></td>
												<td><?= $date ?></td>
												<td><?= $pi_no ?></td>
												<td><?= $sku ?></td>
												<td><?= $design ?></td>
												<td><?= $size ?></td>
												<td>-</td>
												<?php foreach ($stock_warehouses as $wh): $col = 'wh_' . (int)$wh->id; $qty = isset($row->$col) ? number_format((float)$row->$col, 2, '.', '') : '0'; ?>
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
												<td><a href="javascript:;" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i> Edit Stock</a></td>
											</tr>
										<?php
											}
										} else {
											$colspan = 8 + count($stock_warehouses) + 14;
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
	});
</script>
