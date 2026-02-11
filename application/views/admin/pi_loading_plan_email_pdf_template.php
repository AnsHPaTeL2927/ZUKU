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
.loading-container {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
}
.loading-header {
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
.loading-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}
.loading-table th {
    background-color: #f0f0f0;
    padding: 10px 5px;
    text-align: center;
    border: 1px solid #333;
    font-weight: bold;
    font-size: 12px;
}
.loading-table td {
    padding: 8px 5px;
    border: 1px solid #333;
    text-align: center;
    font-size: 11px;
}
.loading-table .text-left {
    text-align: left;
}
</style>
</head>
<body>
<div class="loading-container">
    <!-- Header -->
    <div class="loading-header">LOADING PLAN</div>
    
    <!-- Invoice Information -->
    <div class="section">
        <div class="section-title">Invoice Information</div>
        <table class="info-table">
            <tr>
                <td class="label">Invoice Number</td>
                <td><?= !empty($invoicedata->invoice_no) ? $invoicedata->invoice_no : 'N/A' ?></td>
                <td class="label">Date</td>
                <td><?= date('d/m/Y', strtotime($invoicedata->performa_date)) ?></td>
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
                    echo !empty($container_str) ? $container_str . ' FCL' : (!empty($invoicedata->container_details) ? $invoicedata->container_details : 'N/A');
                    ?>
                </td>
            </tr>
        </table>
    </div>
    
    <!-- Loading Plan Details -->
    <div class="section">
        <div class="section-title">Loading Plan Details</div>
        <table class="loading-table">
            <thead>
                <tr>
                    <th>Container</th>
                    <th>Size</th>
                    <th>Product Name</th>
                    <th>Finish</th>
                    <th>Pallets</th>
                    <th>Boxes</th>
                    <th>SQM</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $total_pallets = 0;
                $total_boxes = 0;
                $total_sqm = 0;
                
                if(!empty($set_container)) {
                    foreach ($set_container as $container) {
                        $pallets = 0;
                        if(!empty($container->no_of_pallet) && $container->no_of_pallet > 0) {
                            $pallets = $container->no_of_pallet;
                        } else if((!empty($container->no_of_big_pallet) && $container->no_of_big_pallet > 0) || (!empty($container->no_of_small_pallet) && $container->no_of_small_pallet > 0)) {
                            $pallets = (!empty($container->no_of_big_pallet) ? $container->no_of_big_pallet : 0) + (!empty($container->no_of_small_pallet) ? $container->no_of_small_pallet : 0);
                        }
                        
                        $boxes = !empty($container->no_of_boxes) ? $container->no_of_boxes : 0;
                        $sqm = !empty($container->no_of_sqm) ? number_format($container->no_of_sqm, 2) : '0.00';
                        
                        $total_pallets += $pallets;
                        $total_boxes += $boxes;
                        $total_sqm += !empty($container->no_of_sqm) ? $container->no_of_sqm : 0;
                        ?>
                        <tr>
                            <td><?= !empty($container->con_entry) ? $container->con_entry : (!empty($container->container_no) ? $container->container_no : '-') ?></td>
                            <td><?= !empty($container->size_type_mm) ? $container->size_type_mm : 'N/A' ?></td>
                            <td class="text-left"><?= !empty($container->model_name) ? $container->model_name : 'N/A' ?></td>
                            <td><?= !empty($container->finish_name) ? $container->finish_name : 'N/A' ?></td>
                            <td><?= $pallets ?></td>
                            <td><?= $boxes ?></td>
                            <td><?= $sqm ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
                <tr style="font-weight: bold; background-color: #f0f0f0;">
                    <td colspan="4" style="text-align: right;">TOTAL</td>
                    <td><?= $total_pallets ?></td>
                    <td><?= $total_boxes ?></td>
                    <td><?= number_format($total_sqm, 2) ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

