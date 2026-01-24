<?php
$this->view('lib/header');

$invoicedata = $invoicedata ?? null;
$product_data = $product_data ?? array();
$company_detail = $company_detail ?? array();
$po_no = $invoicedata ? $invoicedata->purchase_order_no : '';
$po_date = $invoicedata && !empty($invoicedata->purchase_order_date) ? date('d/m/Y', strtotime($invoicedata->purchase_order_date)) : '';
$container = $invoicedata && !empty($invoicedata->container_details) ? $invoicedata->container_details : '1 X 20 FCL';
$grand_total = $invoicedata ? (float) $invoicedata->grand_total : 0;
$amount_words = function_exists('convertamonttousd') ? strtoupper(convertamonttousd($grand_total, 'USD')) : (function_exists('converttorsword') ? strtoupper(converttorsword($grand_total)) : number_format($grand_total, 2));
$supplier_name = $invoicedata && isset($invoicedata->company_name) ? $invoicedata->company_name : '';
$supplier_address = $invoicedata && !empty($invoicedata->address) ? nl2br($invoicedata->address) : '';
$port_loading = $invoicedata && !empty($invoicedata->port_of_loading) ? $invoicedata->port_of_loading : 'MUNDRA PORT';
$final_dest = $invoicedata && !empty($invoicedata->final_destination) ? $invoicedata->final_destination : '-';
$country_origin = 'INDIA';
$country_dest = $invoicedata && !empty($invoicedata->country_dest) ? $invoicedata->country_dest : 'GERMANY';
$back_side = $invoicedata && isset($invoicedata->made_in_india_status) && $invoicedata->made_in_india_status !== '' ? $invoicedata->made_in_india_status : 'MADE IN INDIA';
$pallet_cap = $invoicedata && isset($invoicedata->pallet_cap_name) && $invoicedata->pallet_cap_name !== '' ? $invoicedata->pallet_cap_name : '-';
$moisture_bag = $invoicedata && isset($invoicedata->mosqure_bag_status) && $invoicedata->mosqure_bag_status !== '' ? $invoicedata->mosqure_bag_status : 'NO';
$air_bag = $invoicedata && isset($invoicedata->air_bag_status) && $invoicedata->air_bag_status !== '' ? $invoicedata->air_bag_status : 'NO';
$fumigation = $invoicedata && isset($invoicedata->fumigation_name) && $invoicedata->fumigation_name !== '' ? $invoicedata->fumigation_name : '-';
$safety_belt = $invoicedata && isset($invoicedata->safety_belt) && $invoicedata->safety_belt !== '' ? $invoicedata->safety_belt : 'YES';
?>
<style>
.po-print-area td, .po-print-area th { border: 1px solid #333; padding: 8px; }
.po-print-area table { border-collapse: collapse; width: 100%; margin: 0; }
.po-print-area { padding: 0; margin: 0; }
.po-print-area > * { margin-left: 0 !important; padding-left: 0 !important; }
.po-print-area .po-section { margin-bottom: 32px; }
.po-print-area .po-section h4 { margin: 0 0 14px 0; font-size: 16px; }
.po-print-area .po-section .table { margin-bottom: 0; }
.po-print-area .po-note-box { background: #e8f4fc; border-left: 4px solid #1e88e5; padding: 12px 16px; margin: 24px 0; text-align: center; }
.po-print-area .po-signature-row { margin-top: 48px; margin-bottom: 24px; padding-top: 24px; border-top: 1px solid #e0e0e0; }
.po-print-area .po-signature-row .po-sig-table { width: 100%; border: 0; border-collapse: collapse; table-layout: fixed; }
.po-print-area .po-signature-row .po-sig-table td { border: 0; padding: 0 24px; vertical-align: top; width: 50%; text-align: center; }
.po-print-area .po-signature-box { display: block; text-align: center; width: 100%; max-width: 240px; margin: 0 auto; }
.po-print-area .po-signature-box .po-sig-label { font-weight: bold; font-size: 15px; margin-bottom: 0; display: block; color: #222; }
.po-print-area .po-signature-box .po-sig-gap { height: 40px; min-height: 40px; }
.po-print-area .po-signature-box .po-sig-line { width: 180px; height: 0; border-bottom: 1px solid #333; margin: 0 auto; display: block; }
.po-print-area .po-signature-box .po-sig-details { font-size: 12px; font-weight: normal; line-height: 1.4; color: #444; text-transform: uppercase; margin-top: 6px; }
.po-print-area .po-signature-box .po-sig-details .po-sig-for { margin-bottom: 2px; }
.po-print-area .po-signature-box .po-sig-img { max-width: 120px; max-height: 48px; margin: 8px auto 0; display: block; }
@media print {
	@page { margin: 8mm 8mm 8mm 8mm; size: A4; }
	html, body { 
		margin: 0 !important; 
		padding: 0 !important; 
		min-height: auto !important;
		width: 100% !important;
	}
	body * { visibility: hidden; }
	#po-print-area, #po-print-area * { visibility: visible; }
	.main-container, .main-content, .container, .row, [class*="col-"] { 
		margin: 0 !important; 
		padding: 0 !important; 
		width: 100% !important;
		max-width: 100% !important;
		position: static !important;
	}
	.container { padding-left: 0 !important; padding-right: 0 !important; }
	#po-print-area {
		position: absolute !important;
		left: 0 !important;
		top: 0 !important;
		width: 100% !important;
		margin: 0 !important;
		padding: 0 !important;
		box-sizing: border-box !important;
	}
	#po-print-area h3:first-child { margin-top: 0 !important; padding-top: 0 !important; }
	.no-print { display: none !important; }
	.po-print-area table { 
		width: 100% !important; 
		margin: 0 !important;
		padding: 0 !important;
	}
	.po-print-area .table { margin: 0 !important; padding: 0 !important; }
	.po-print-area .po-section { 
		margin-left: 0 !important; 
		margin-right: 0 !important; 
		padding-left: 0 !important; 
		padding-right: 0 !important; 
	}
	.po-print-area > div, .po-print-area > h3, .po-print-area > h4 { 
		margin-left: 0 !important; 
		padding-left: 0 !important; 
	}
	.po-print-area table td, .po-print-area table th { 
		padding: 8px !important;
		text-align: left !important;
	}
	.po-print-area .po-signature-row { margin-top: 36px; margin-bottom: 20px; break-inside: avoid; }
	.po-print-area .po-signature-row .po-sig-table { page-break-inside: avoid; }
	.po-print-area .po-signature-row .po-sig-table td { break-inside: avoid; width: 50% !important; padding: 0 24px !important; vertical-align: top !important; text-align: center !important; }
	.po-print-area .po-signature-box { max-width: 240px !important; margin-left: auto !important; margin-right: auto !important; }
	.po-print-area .po-signature-box .po-sig-gap { height: 40px !important; min-height: 40px !important; }
	.po-print-area .po-note-box { -webkit-print-color-adjust: exact; print-color-adjust: exact; break-inside: avoid; }
}
</style>
<script>
function do_print() { window.print(); }
</script>

<div class="main-container">
	<?php $this->view('lib/sidebar'); ?>
	<div class="main-content">
		<div class="container">
			<div class="row no-print">
				<div class="col-sm-12">
					<ol class="breadcrumb">
						<li><i class="clip-pencil"></i> <a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
						<li><a href="<?= base_url('purchaseorder_listing') ?>">Purchase Order</a></li>
						<li class="active">View Purchase Order</li>
					</ol>
					<div class="page-header">
						<h1 style="margin-top:0;">Purchase Order</h1>
						<div class="pull-right form-group">
							<a class="btn btn-primary" href="javascript:;" onclick="do_print();"><i class="fa fa-print"></i> Print</a>
							<a href="<?= base_url('purchaseorder_listing') ?>" class="btn btn-default">Back to List</a>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<?php ob_start(); ?>
					<div id="po-print-area" class="po-print-area">
						<h3 style="text-align:center; margin-top: 0; margin-bottom: 24px;">PURCHASE ORDER</h3>

						<div class="po-section">
							<h4>Order Information</h4>
							<table class="table table-bordered">
							<tr>
								<th width="20%">PO Number</th>
								<td><?= htmlspecialchars($po_no) ?></td>
								<th width="20%">Date</th>
								<td><?= htmlspecialchars($po_date) ?></td>
								<th width="20%">No of Container</th>
								<td><?= htmlspecialchars($container) ?></td>
							</tr>
							</table>
						</div>

						<div class="po-section">
							<h4>Product Details</h4>
							<table class="table table-bordered">
							<thead>
								<tr style="background:#f5f5f5;">
									<th>Size</th>
									<th>Collection</th>
									<th>Finish</th>
									<th>Product Name</th>
									<th>Boxes/Pallet</th>
									<th>Pallets</th>
									<th>Total Boxes</th>
									<th>Quantity (SQM)</th>
									<th>Weight</th>
									<th>Rate / SQM (USD)</th>
									<th>Amount (USD)</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$Total_box = 0; $Total_sqm = 0; $Total_amt = 0; $Total_weight = 0;
								foreach ($product_data as $row) {
									foreach ($row->packing as $p) {
										$Total_box += (float) $p->no_of_boxes;
										$Total_sqm += (float) $p->no_of_sqm;
										$rate = (float) (@$p->product_rate ?: 0);
										$sqm = (float) (@$p->no_of_sqm ?: 0);
										$amt = (float) (@$p->product_amt ?: 0);
										if ($amt == 0 && $rate > 0 && $sqm > 0) {
											$amt = $rate * $sqm;
										}
										$Total_amt += $amt;
										$wt = isset($p->packing_net_weight) ? $p->packing_net_weight : ((float) $p->no_of_boxes * (float) (@$row->weight_per_box ?: 0));
										$Total_weight += $wt;
										$size = isset($row->size_type_mm) ? $row->size_type_mm : '-';
										$coll = isset($row->series_name) ? $row->series_name : '-';
										$fin = isset($p->finish_name) ? $p->finish_name : '-';
										$design = isset($p->model_name) ? $p->model_name : '-';
										$bpp = isset($row->boxes_per_pallet) ? $row->boxes_per_pallet : '-';
										$pallets = (int) $p->no_of_pallet;
										if ($p->no_of_big_pallet > 0 || $p->no_of_small_pallet > 0) {
											$pallets = $p->no_of_big_pallet . ' / ' . $p->no_of_small_pallet;
										}
								?>
								<tr>
									<td><?= htmlspecialchars($size) ?></td>
									<td><?= htmlspecialchars($coll) ?></td>
									<td><?= htmlspecialchars($fin) ?></td>
									<td><?= htmlspecialchars($design) ?></td>
									<td><?= $bpp ?></td>
									<td><?= $pallets ?></td>
									<td><?= (int) $p->no_of_boxes ?></td>
									<td><?= number_format($sqm, 2) ?></td>
									<td><?= number_format($wt, 0) ?></td>
									<td>$<?= number_format($rate, 2) ?></td>
									<td>$<?= number_format($amt, 2) ?></td>
								</tr>
								<?php } } ?>
							</tbody>
							<tfoot>
								<tr style="font-weight:bold;">
									<td colspan="6" style="text-align:right;">TOTAL</td>
									<td><?= (int) $Total_box ?></td>
									<td><?= number_format($Total_sqm, 2) ?></td>
									<td><?= number_format($Total_weight, 0) ?></td>
									<td></td>
									<td>$<?= number_format($Total_amt, 2) ?></td>
								</tr>
							</tfoot>
							</table>
						</div>

						<div class="po-section">
							<h4>Summary</h4>
							<table class="table table-bordered">
							<tr>
								<th width="25%">Total Amount</th>
								<td>$<?= number_format($grand_total, 2) ?></td>
							</tr>
							<tr>
								<th>Total FOB Value</th>
								<td>$<?= number_format($grand_total, 2) ?></td>
							</tr>
							<tr>
								<th>Total Amount in Words</th>
								<td><?= $amount_words ?> ONLY</td>
							</tr>
							</table>
						</div>

						<div class="po-section">
							<h4>Shipping Information</h4>
							<table class="table table-bordered">
							<tr>
								<th width="25%">Port of Loading</th>
								<td><?= htmlspecialchars($port_loading) ?></td>
								<th width="25%">Final Destination</th>
								<td><?= htmlspecialchars($final_dest) ?></td>
							</tr>
							<tr>
								<th>Country of Origin</th>
								<td><?= htmlspecialchars($country_origin) ?></td>
								<th>Country of Final Destination</th>
								<td><?= htmlspecialchars($country_dest) ?></td>
							</tr>
							</table>
						</div>

						<div class="po-section">
							<h4>Additional Information</h4>
							<table class="table table-bordered">
							<tr>
								<th width="25%">Back side of Tiles</th>
								<td width="25%"><?= htmlspecialchars($back_side) ?></td>
								<th width="25%">AirBag</th>
								<td width="25%"><?= htmlspecialchars($air_bag) ?></td>
							</tr>
							<tr>
								<th>Pallet Cap</th>
								<td><?= htmlspecialchars($pallet_cap) ?></td>
								<th>Fumigation</th>
								<td><?= htmlspecialchars($fumigation) ?></td>
							</tr>
							<tr>
								<th>Moisture Bag</th>
								<td><?= htmlspecialchars($moisture_bag) ?></td>
								<th>Safety Belt</th>
								<td><?= htmlspecialchars($safety_belt) ?></td>
							</tr>
							</table>
						</div>

						<?php if (!empty($supplier_name) || !empty($supplier_address)): ?>
						<div class="po-section">
							<h4>Seller</h4>
							<p style="margin: 0;"><strong><?= htmlspecialchars($supplier_name) ?></strong><br><?= $supplier_address ?></p>
						</div>
						<?php endif; ?>

						<div class="po-section">
							<h4>Pallet Type / Box Design Summary</h4>
							<table class="table table-bordered">
							<thead>
								<tr style="background:#f5f5f5;">
									<th>Size</th>
									<th>Pcs / box</th>
									<th>Sqm / box</th>
									<th>Pallet Type</th>
									<th>Box Design</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$seen = array();
								foreach ($product_data as $row) {
									foreach ($row->packing as $p) {
										$key = (@$row->size_type_mm ?: '-') . '|' . (@$p->pallet_type_name ?: '-') . '|' . (@$p->box_design_name ?: '-');
										if (isset($seen[$key])) continue;
										$seen[$key] = true;
								?>
								<tr>
									<td><?= htmlspecialchars(@$row->size_type_mm ?: '-') ?></td>
									<td><?= (int) @$row->pcs_per_box ?></td>
									<td><?= number_format((float) @$row->sqm_per_box, 2) ?></td>
									<td><?= htmlspecialchars(@$p->pallet_type_name ?: '-') ?></td>
									<td><?= htmlspecialchars(@$p->box_design_name ?: '-') ?></td>
								</tr>
								<?php } } ?>
								<?php if (empty($seen)): ?>
								<tr><td colspan="5" class="text-center">-</td></tr>
								<?php endif; ?>
							</tbody>
							</table>
						</div>

						<div class="po-note-box">
							<p style="margin: 0;"><strong>Note:</strong> 5% PLUS OR MINUS QUANTITY WILL BE ACCEPTABLE. DECLARATION OF PERFORMANCE. CERTIFICATE. C.E LABEL.</p>
						</div>

						<div class="po-signature-row">
							<table class="po-sig-table" role="presentation">
								<tr>
									<td class="po-sig-cell po-sig-buyer">
										<div class="po-signature-box">
											<span class="po-sig-label">Buyer Signature</span>
											<div class="po-sig-gap"></div>
											<div class="po-sig-line"></div>
										</div>
									</td>
									<td class="po-sig-cell po-sig-seller">
										<div class="po-signature-box">
											<span class="po-sig-label">Seller Signature</span>
											<?php if (!empty($company_detail) && is_array($company_detail) && isset($company_detail[0])): ?>
												<?php if (!empty($company_detail[0]->s_name) || !empty($company_detail[0]->authorised_signatury)): ?>
													<div class="po-sig-details">
														<?php if (!empty($company_detail[0]->s_name)): ?><span class="po-sig-for">For, <?= htmlspecialchars(strtoupper($company_detail[0]->s_name)) ?></span><br><?php endif; ?>
														<?php if (!empty($company_detail[0]->authorised_signatury)): ?><?= htmlspecialchars(strtoupper($company_detail[0]->authorised_signatury)) ?><?php endif; ?>
													</div>
												<?php endif; ?>
												<?php if (!empty($company_detail[0]->s_c_sign)): ?>
													<img src="<?= base_url('upload/' . $company_detail[0]->s_c_sign) ?>" alt="Signature" class="po-sig-img" onerror="this.style.display='none'" />
												<?php endif; ?>
											<?php endif; ?>
											<div class="po-sig-gap"></div>
											<div class="po-sig-line"></div>
										</div>
									</td>
								</tr>
							</table>
						</div>
					</div>
					<?php
					$html = ob_get_clean();
					echo $html;
					?>
				</div>
			</div>
		</div>
	</div>
</div>

<?php $this->view('lib/footer'); ?>
