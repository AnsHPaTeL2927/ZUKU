<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body { font-family: Arial, sans-serif; margin: 20px; padding: 0; }
.report-container { max-width: 1000px; margin: 0 auto; }
.report-header { text-align: center; font-size: 20px; font-weight: bold; margin-bottom: 20px; padding: 10px; }
.section { margin-bottom: 20px; }
.section-title { font-weight: bold; font-size: 14px; margin-bottom: 8px; padding: 5px; background-color: #f0f0f0; }
.info-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
.info-table td { padding: 8px; border: 1px solid #333; }
.info-table td.label { font-weight: bold; width: 30%; background-color: #f9f9f9; }
.detail-table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
.detail-table th { background-color: #f0f0f0; padding: 8px 5px; text-align: center; border: 1px solid #333; font-weight: bold; font-size: 11px; }
.detail-table td { padding: 6px 5px; border: 1px solid #333; text-align: center; font-size: 11px; }
.total-row { font-weight: bold; background-color: #f0f0f0; }
</style>
</head>
<body>
<div class="report-container">
    <div class="report-header">PRODUCTION DONE REPORT</div>
    
    <div class="section">
        <div class="section-title">Production Information</div>
        <table class="info-table">
            <tr>
                <td class="label">Production No</td>
                <td><?= !empty($mst_data->producation_no) ? htmlspecialchars($mst_data->producation_no) : 'N/A' ?></td>
                <td class="label">Proforma Invoice No</td>
                <td><?= !empty($mst_data->invoice_no) ? htmlspecialchars($mst_data->invoice_no) : 'N/A' ?></td>
            </tr>
            <tr>
                <td class="label">Production Date</td>
                <td><?= !empty($mst_data->producation_date) ? date('d-m-Y', strtotime($mst_data->producation_date)) : 'N/A' ?></td>
                <td class="label">Completion Date</td>
                <td><?= !empty($mst_data->production_complete_date) ? date('d-m-Y', strtotime($mst_data->production_complete_date)) : date('d-m-Y') ?></td>
            </tr>
        </table>
    </div>
    
    <div class="section">
        <div class="section-title">Production Details (Old boxes from PI vs Current from Production)</div>
        <table class="detail-table">
            <thead>
                <tr>
                    <th>Sr</th>
                    <th>Size</th>
                    <th>Design</th>
                    <th>Finish</th>
                    <th>PI Boxes (Old)</th>
                    <th>Pallets</th>
                    <th>Box (Current)</th>
                    <th>SQM</th>
                    <th>Batch No</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sr = 1;
                $total_pallets = 0;
                $total_boxes = 0;
                $total_sqm = 0;
                if (!empty($rows)) {
                    foreach ($rows as $r) {
                        $pallets = (float)(isset($r->no_of_pallet) ? $r->no_of_pallet : 0)
                                 + (float)(isset($r->no_of_big_pallet) ? $r->no_of_big_pallet : 0)
                                 + (float)(isset($r->no_of_small_pallet) ? $r->no_of_small_pallet : 0);
                        $boxes = (float)(isset($r->no_of_boxes) ? $r->no_of_boxes : 0);
                        $sqm = (float)(isset($r->no_of_sqm) ? $r->no_of_sqm : 0);
                        $total_pallets += $pallets;
                        $total_boxes += $boxes;
                        $total_sqm += $sqm;
                ?>
                <tr>
                    <td><?= $sr++ ?></td>
                    <td><?= !empty($r->size_type_mm) ? htmlspecialchars($r->size_type_mm) : '-' ?></td>
                    <td><?= !empty($r->model_name) ? htmlspecialchars($r->model_name) : '-' ?></td>
                    <td><?= !empty($r->finish_name) ? htmlspecialchars($r->finish_name) : '-' ?></td>
                    <td><?= isset($r->pi_order_boxes) ? (int)$r->pi_order_boxes : '-' ?></td>
                    <td><?= $pallets ?></td>
                    <td><?= $boxes ?></td>
                    <td><?= number_format($sqm, 2) ?></td>
                    <td><?= !empty($r->pro_batch) ? htmlspecialchars($r->pro_batch) : '-' ?></td>
                    <td><?= !empty($r->pro_shade) ? htmlspecialchars($r->pro_shade) : '-' ?></td>
                </tr>
                <?php }
                } ?>
                <tr class="total-row">
                    <td colspan="5" style="text-align:right;">Total</td>
                    <td><?= $total_pallets ?></td>
                    <td><?= $total_boxes ?></td>
                    <td><?= number_format($total_sqm, 2) ?></td>
                    <td colspan="2"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>
