<?php $this->view('lib/header'); ?>

<link rel="stylesheet" href="<?= base_url('assets/css/purchase_order.css') ?>">

<?php $this->view('lib/sidebar'); ?>
<div class="main-container">

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

                            <form method="post" action="<?= base_url('admin/save_purchaseorder') ?>" id="po-form">

                                <!-- BASIC INFO -->
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>PO Number (SR.NO)</label>
                                            <input type="text" name="po_number" class="form-control" required>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>Date</label>
                                            <input type="date" name="po_date" class="form-control" value="<?= date('Y-m-d') ?>" required>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <!-- PALLET OPTIONS -->
                                <div class="form-group">
                                    <label>Pallet Type</label><br>
                                    <label class="radio-inline">
                                        <input type="radio" name="pallet_option" value="with" checked> With Pallet
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="pallet_option" value="without"> Without Pallet
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="pallet_option" value="multi"> Multi Pallet
                                    </label>
                                </div>

                                <!-- PRODUCT TABLE -->
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Design</th>
                                                <th>Finish</th>
                                                <th>Client Design</th>
                                                <th>No of Pallet</th>
                                                <th>Pallet Type</th>
                                                <th>Boxes</th>
                                                <th>Box Design</th>
                                                <th>SQM</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <select name="design[]" class="form-control">
                                                        <option>SWIZER WHITE</option>
                                                        <option>OPULENCE</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <select name="finish[]" class="form-control">
                                                        <option>MATT</option>
                                                        <option>GLOSSY</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" name="client_design[]" class="form-control">
                                                </td>
                                                <td>
                                                    <input type="number" name="pallet_qty[]" class="form-control">
                                                </td>
                                                <td>
                                                    <select name="pallet_type[]" class="form-control">
                                                        <option>EURO PINEWOOD</option>
                                                        <option>PLASTIC</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="boxes[]" class="form-control">
                                                </td>
                                                <td>
                                                    <select name="box_design[]" class="form-control">
                                                        <option>ITACA BRAND</option>
                                                        <option>CUSTOM</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" name="sqm[]" step="0.01" class="form-control">
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-success add-row">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <hr>

                                <!-- ACTION BUTTONS -->
                                <div class="text-right">
                                    <a href="<?= base_url('purchaseorder_listing') ?>" class="btn btn-default">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-success">
                                        Save Purchase Order
                                    </button>
                                </div>

                            </form>

                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="<?= base_url('assets/js/purchase_order.js') ?>"></script>

<?php $this->view('lib/footer'); ?>
