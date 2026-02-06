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
									<select class="form-control" id="pi_no">
										<option value="">All PI Numbers</option>
										<option value="PI-001">PI-001</option>
										<option value="PI-002">PI-002</option>
										<option value="PI-003">PI-003</option>
									</select>
								</div>
								<div class="col-md-2">
									<label class="control-label"><strong>LOCATION</strong></label>
									<select class="form-control" id="location">
										<option value="">All Locations</option>
										<option value="1">Warehouse 01</option>
										<option value="2">Warehouse 02</option>
										<option value="3">Warehouse 03</option>
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
											<th>WAREHOUSE 01 [M²]</th>
											<th>WAREHOUSE 02 [M²]</th>
											<th>WAREHOUSE 03 [M²]</th>
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
										$dummy_data = array(
											array(1, '25/08/2025', 'PI-001', 'AFF-DK-6012CV', 'AFFYON DARK 120 CA...', '60X120', 'SIYARAM INDIA', 0, 0, 0, 0, 587.52, 97.92, 3.26, 75, 20, 310.08, 0, '2025-11-01', '2025-11-17', 28, 28, 91.39, 'Place Order soon'),
											array(2, '25/08/2025', 'PI-001', 'AFF-DK-6060SG', 'AFFYON DARK 060 SU...', '60X60', 'SIYARAM INDIA', 0, 0, 0, 0, 1329.48, 221.58, 7.39, 75, 20, 702.05, 0, '2025-11-01', '2025-11-17', 28, 28, 206.92, 'Place Order soon'),
											array(3, '25/08/2025', 'PI-002', 'ALW-120-MAT', 'ALASKA WHITE 120 M...', '60X120', 'SIYARAM INDIA', 0, 0, 0, 0, 445.20, 74.20, 2.47, 75, 20, 236.05, 0, '2025-11-01', '2025-11-17', 28, 28, 69.16, 'Place Order soon'),
											array(4, '26/08/2025', 'PI-002', 'ALW-6060-POL', 'ALASKA WHITE 060 PO...', '60X60', 'SIYARAM INDIA', 0, 0, 0, 0, 892.80, 148.80, 4.96, 75, 20, 473.60, 0, '2025-11-01', '2025-11-17', 28, 28, 138.88, 'Place Order soon'),
											array(5, '26/08/2025', 'PI-003', 'BRC-NR-6012', 'BARCELONA GREY 120...', '60X120', 'SIYARAM INDIA', 0, 0, 0, 0, 720.00, 120.00, 4.00, 75, 20, 380.00, 0, '2025-11-01', '2025-11-17', 28, 28, 112.00, 'Place Order soon'),
											array(6, '27/08/2025', 'PI-003', 'BRC-NR-6060', 'BARCELONA GREY 060...', '60X60', 'SIYARAM INDIA', 0, 0, 0, 0, 518.40, 86.40, 2.88, 75, 20, 273.60, 0, '2025-11-01', '2025-11-17', 28, 28, 80.64, 'Place Order soon'),
											array(7, '27/08/2025', 'PI-001', 'CVT-BK-6012', 'CAVATINA BLACK 120...', '60X120', 'SIYARAM INDIA', 0, 0, 0, 0, 655.20, 109.20, 3.64, 75, 20, 345.80, 0, '2025-11-01', '2025-11-17', 28, 28, 101.92, 'Place Order soon'),
											array(8, '28/08/2025', 'PI-002', 'CVT-BK-6060', 'CAVATINA BLACK 060...', '60X60', 'SIYARAM INDIA', 0, 0, 0, 0, 388.80, 64.80, 2.16, 75, 20, 205.20, 0, '2025-11-01', '2025-11-17', 28, 28, 60.48, 'Place Order soon'),
										);
										foreach ($dummy_data as $row) :
											list($sr, $date, $pi_no, $sku, $design, $size, $supplier, $wh1, $wh2, $wh3, $total_stock, $sales_6m, $avg_monthly, $avg_daily, $lead_time, $safety_days, $rop, $days_cover, $etd, $eta, $days_delivery, $days_out, $lost_sales, $decision) = $row;
										?>
											<tr>
												<td><?= $sr ?></td>
												<td><?= $date ?></td>
												<td><?= $pi_no ?></td>
												<td><?= $sku ?></td>
												<td><?= $design ?></td>
												<td><?= $size ?></td>
												<td><?= $supplier ?></td>
												<td class="text-right"><?= $wh1 ?></td>
												<td class="text-right"><?= $wh2 ?></td>
												<td class="text-right"><?= $wh3 ?></td>
												<td class="text-right"><?= $total_stock ?></td>
												<td class="text-right"><?= $sales_6m ?></td>
												<td class="text-right"><?= $avg_monthly ?></td>
												<td class="text-right"><?= $avg_daily ?></td>
												<td class="text-center"><?= $lead_time ?></td>
												<td class="text-center"><?= $safety_days ?></td>
												<td class="text-right"><?= $rop ?></td>
												<td class="text-center"><?= $days_cover ?></td>
												<td><?= $etd ?></td>
												<td><?= $eta ?></td>
												<td class="text-center"><?= $days_delivery ?></td>
												<td class="text-center"><?= $days_out ?></td>
												<td class="text-right"><?= $lost_sales ?></td>
												<td><a href="javascript:;" class="text-primary"><?= $decision ?></a></td>
												<td><a href="javascript:;" class="btn btn-default btn-sm"><i class="fa fa-pencil"></i> Edit Stock</a></td>
											</tr>
										<?php endforeach; ?>
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
	});
</script>
