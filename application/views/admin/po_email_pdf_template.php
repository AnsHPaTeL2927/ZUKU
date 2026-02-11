<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
body {
    font-family: Arial, sans-serif;
    margin: 20px;
    padding: 0;
}
.po-container {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
}
.po-header {
    text-align: center;
    font-size: 24px;
    font-weight: bold;
    margin-bottom: 20px;
    padding: 10px;
}
.section {
    margin-bottom: 20px;
}
.section-title {
    font-weight: bold;
    font-size: 14px;
    margin-bottom: 8px;
    padding: 5px;
    background-color: #f0f0f0;
}
.info-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}
.info-table td {
    padding: 8px;
    border: 1px solid #333;
}
.info-table td.label {
    font-weight: bold;
    width: 30%;
    background-color: #f9f9f9;
}
.product-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}
.product-table th {
    background-color: #f0f0f0;
    padding: 10px 5px;
    text-align: center;
    border: 1px solid #333;
    font-weight: bold;
    font-size: 12px;
}
.product-table td {
    padding: 8px 5px;
    border: 1px solid #333;
    text-align: center;
    font-size: 11px;
}
.product-table .text-left {
    text-align: left;
}
.total-row {
    font-weight: bold;
    background-color: #f0f0f0;
}
.summary-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}
.summary-table td {
    padding: 8px;
    border: 1px solid #333;
}
.summary-table .label {
    font-weight: bold;
    width: 40%;
    background-color: #f9f9f9;
}
.two-column {
    display: table;
    width: 100%;
}
.two-column .column {
    display: table-cell;
    width: 50%;
    padding: 5px;
}
</style>
</head>
<body>
<div class="po-container">
    <!-- Header -->
    <div class="po-header">PURCHASE ORDER</div>
    
    <!-- Order Information -->
    <div class="section">
        <div class="section-title">Order Information</div>
        <table class="info-table">
            <tr>
                <td class="label">PO Number</td>
                <td><?= !empty($invoicedata->purchase_order_no) ? $invoicedata->purchase_order_no : 'N/A' ?></td>
                <td class="label">Date</td>
                <td><?= date('d/m/Y', strtotime($invoicedata->purchase_order_date)) ?></td>
            </tr>
            <tr>
                <td class="label">No of Container</td>
                <td colspan="3">
                    <?php
                    $container_str = '';
                    if(!empty($invoicedata->container_twenty)) {
                        $container_str .= $invoicedata->container_twenty . ' X 20';
                    }
                    if(!empty($invoicedata->container_twenty) && !empty($invoicedata->container_forty)) {
                        $container_str .= ' + ';
                    }
                    if(!empty($invoicedata->container_forty)) {
                        $container_str .= $invoicedata->container_forty . ' X 40';
                    }
                    echo !empty($container_str) ? $container_str . ' FCL' : 'N/A';
                    ?>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Product Details -->
    <div class="section">
        <div class="section-title">Product Details</div>
        <table class="product-table">
            <thead>
                <tr>
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
                $total_boxes = 0;
                $total_sqm = 0;
                $total_weight = 0;
                $total_amount = 0;
                
                if(!empty($product_data)) {
                    foreach ($product_data as $product) {
                        if(!empty($product->packing)) {
                            foreach($product->packing as $packing) {
                                // Calculate pallets
                                $pallets = 0;
                                if($packing->no_of_pallet > 0) {
                                    $pallets = $packing->no_of_pallet;
                                } else if($packing->no_of_big_pallet > 0 || $packing->no_of_small_pallet > 0) {
                                    $pallets = ($packing->no_of_big_pallet ?: 0) + ($packing->no_of_small_pallet ?: 0);
                                }
                                
                                // Calculate boxes per pallet
                                $boxes_per_pallet = '-';
                                if($packing->no_of_pallet > 0 && !empty($product->boxes_per_pallet)) {
                                    $boxes_per_pallet = $product->boxes_per_pallet;
                                } else if(($packing->no_of_big_pallet > 0 || $packing->no_of_small_pallet > 0)) {
                                    $big = !empty($product->box_per_big_pallet) ? $product->box_per_big_pallet : 0;
                                    $small = !empty($product->box_per_small_pallet) ? $product->box_per_small_pallet : 0;
                                    $boxes_per_pallet = ($big > 0 ? $big : '') . ($big > 0 && $small > 0 ? '/' : '') . ($small > 0 ? $small : '');
                                }
                                
                                // Get weight (use packing_gross_weight from packing data)
                                $weight = !empty($packing->packing_gross_weight) ? $packing->packing_gross_weight : (!empty($packing->packing_net_weight) ? $packing->packing_net_weight : 0);
                                
                                // Get rate and amount
                                $rate = !empty($packing->product_rate) ? number_format($packing->product_rate, 2) : '0.00';
                                $amount = !empty($packing->product_amt) ? number_format($packing->product_amt, 2) : '0.00';
                                
                                // Get SQM
                                $sqm = !empty($packing->no_of_sqm) ? number_format($packing->no_of_sqm, 2) : '0.00';
                                
                                $total_boxes += !empty($packing->no_of_boxes) ? $packing->no_of_boxes : 0;
                                $total_sqm += !empty($packing->no_of_sqm) ? $packing->no_of_sqm : 0;
                                $total_weight += $weight;
                                $total_amount += !empty($packing->product_amt) ? $packing->product_amt : 0;
                                ?>
                                <tr>
                                    <td><?= !empty($product->size_type_mm) ? $product->size_type_mm : 'N/A' ?></td>
                                    <td><?= !empty($product->series_name) ? $product->series_name : 'N/A' ?></td>
                                    <td><?= !empty($packing->finish_name) ? $packing->finish_name : 'N/A' ?></td>
                                    <td class="text-left"><?= !empty($packing->model_name) ? $packing->model_name : 'N/A' ?></td>
                                    <td><?= $boxes_per_pallet ?></td>
                                    <td><?= $pallets ?></td>
                                    <td><?= !empty($packing->no_of_boxes) ? $packing->no_of_boxes : '0' ?></td>
                                    <td><?= $sqm ?></td>
                                    <td><?= number_format($weight, 0) ?></td>
                                    <td>$<?= $rate ?></td>
                                    <td>$<?= $amount ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
                <tr class="total-row">
                    <td colspan="6" style="text-align: right;">TOTAL</td>
                    <td><?= $total_boxes ?></td>
                    <td><?= number_format($total_sqm, 2) ?></td>
                    <td><?= number_format($total_weight, 0) ?></td>
                    <td></td>
                    <td>$<?= number_format($total_amount, 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
    
    <!-- Summary -->
    <div class="section">
        <div class="section-title">Summary</div>
        <table class="summary-table">
            <tr>
                <td class="label">Total Amount</td>
                <td>$<?= number_format(!empty($invoicedata->grand_total) ? $invoicedata->grand_total : $total_amount, 2) ?></td>
            </tr>
            <tr>
                <td class="label">Total FOB Value</td>
                <td>$<?= number_format(!empty($invoicedata->grand_total) ? $invoicedata->grand_total : $total_amount, 2) ?></td>
            </tr>
            <tr>
                <td class="label">Total Amount in Words</td>
                <td><?= strtoupper(converttorsword(!empty($invoicedata->grand_total) ? $invoicedata->grand_total : $total_amount)) ?> USD ONLY</td>
            </tr>
        </table>
    </div>
    
    <!-- Shipping Information -->
    <div class="section">
        <div class="section-title">Shipping Information</div>
        <table class="info-table">
            <tr>
                <td class="label">Port of Loading</td>
                <td><?= !empty($invoicedata->port_of_loading) ? strtoupper($invoicedata->port_of_loading) : '-' ?></td>
                <td class="label">Final Destination</td>
                <td><?= !empty($invoicedata->final_destination) ? strtoupper($invoicedata->final_destination) : '-' ?></td>
            </tr>
            <tr>
                <td class="label">Country of Origin</td>
                <td>INDIA</td>
                <td class="label">Country of Final Destination</td>
                <td><?= !empty($invoicedata->country_final_destination) ? strtoupper($invoicedata->country_final_destination) : (!empty($invoicedata->final_destination) ? strtoupper($invoicedata->final_destination) : '-') ?></td>
            </tr>
        </table>
    </div>
    
    <!-- Additional Information -->
    <div class="section">
        <div class="section-title">Additional Information</div>
        <table class="info-table">
            <tr>
                <td class="label">Back side of Tiles</td>
                <td><?= !empty($invoicedata->made_in_india_status) && $invoicedata->made_in_india_status == 1 ? 'MADE IN INDIA' : '-' ?></td>
                <td class="label">AirBag</td>
                <td><?= !empty($invoicedata->air_bag_status) && $invoicedata->air_bag_status == 1 ? 'YES' : 'NO' ?></td>
            </tr>
            <tr>
                <td class="label">Pallet Cap</td>
                <td><?= !empty($invoicedata->pallet_cap_name) ? $invoicedata->pallet_cap_name : '-' ?></td>
                <td class="label">Fumigation</td>
                <td><?= !empty($invoicedata->fumigation_name) ? $invoicedata->fumigation_name : '-' ?></td>
            </tr>
            <tr>
                <td class="label">Moisture Bag</td>
                <td><?= !empty($invoicedata->mosqure_bag_status) && $invoicedata->mosqure_bag_status == 1 ? 'YES' : 'NO' ?></td>
                <td class="label">Safety Belt</td>
                <td><?= !empty($invoicedata->safety_belt) && $invoicedata->safety_belt == 1 ? 'YES' : 'NO' ?></td>
            </tr>
        </table>
    </div>
    
    <!-- Pallet Type / Box Design Summary -->
    <div class="section">
        <div class="section-title">Pallet Type / Box Design Summary</div>
        <table class="product-table">
            <thead>
                <tr>
                    <th>Size</th>
                    <th>Pcs / box</th>
                    <th>Sqm / box</th>
                    <th>Pallet Type</th>
                    <th>Box Design</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($product_data)) {
                    foreach ($product_data as $product) {
                        if(!empty($product->packing)) {
                            foreach($product->packing as $packing) {
                                ?>
                                <tr>
                                    <td><?= !empty($product->size_type_mm) ? $product->size_type_mm : 'N/A' ?></td>
                                    <td><?= !empty($product->pcs_per_box) ? $product->pcs_per_box : 'N/A' ?></td>
                                    <td><?= !empty($product->sqm_per_box) ? number_format($product->sqm_per_box, 2) : 'N/A' ?></td>
                                    <td><?= !empty($packing->pallet_type_name) ? $packing->pallet_type_name : 'N/A' ?></td>
                                    <td><?= !empty($packing->box_design_name) ? $packing->box_design_name : 'N/A' ?></td>
                                </tr>
                                <?php
                            }
                        }
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

