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
.container-container {
    width: 100%;
    max-width: 1000px;
    margin: 0 auto;
}
.container-header {
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
.container-table {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 15px;
}
.container-table th {
    background-color: #f0f0f0;
    padding: 10px 5px;
    text-align: center;
    border: 1px solid #333;
    font-weight: bold;
    font-size: 12px;
}
.container-table td {
    padding: 8px 5px;
    border: 1px solid #333;
    text-align: center;
    font-size: 11px;
}
.container-table .text-left {
    text-align: left;
}
</style>
</head>
<body>
<div class="container-container">
    <!-- Header -->
    <div class="container-header">CONTAINER DETAILS</div>
    
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
        </table>
    </div>
    
    <!-- Container Details -->
    <div class="section">
        <div class="section-title">Container Details</div>
        <table class="container-table">
            <thead>
                <tr>
                    <th>Container No</th>
                    <th>Container Size</th>
                    <th>Seal No</th>
                    <th>RFID Seal No</th>
                    <th>Booking No</th>
                    <th>LR No</th>
                    <th>Truck No</th>
                    <th>Mobile No</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(!empty($set_container)) {
                    foreach ($set_container as $container) {
                        ?>
                        <tr>
                            <td><?= !empty($container->container_no) ? $container->container_no : (!empty($container->con_no) ? $container->con_no : '-') ?></td>
                            <td><?= !empty($container->container_size) ? $container->container_size : '-' ?></td>
                            <td><?= !empty($container->seal_no) ? $container->seal_no : '-' ?></td>
                            <td><?= !empty($container->rfidseal_no) ? $container->rfidseal_no : '-' ?></td>
                            <td><?= !empty($container->booking_no) ? $container->booking_no : '-' ?></td>
                            <td><?= !empty($container->lr_no) ? $container->lr_no : '-' ?></td>
                            <td><?= !empty($container->truck_no) ? $container->truck_no : '-' ?></td>
                            <td><?= !empty($container->mobile_no) ? $container->mobile_no : '-' ?></td>
                        </tr>
                        <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
    
    <!-- Product Details -->
    <div class="section">
        <div class="section-title">Product Details</div>
        <table class="container-table">
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
                        ?>
                        <tr>
                            <td><?= !empty($container->container_no) ? $container->container_no : (!empty($container->con_no) ? $container->con_no : '-') ?></td>
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
            </tbody>
        </table>
    </div>
</div>
</body>
</html>

