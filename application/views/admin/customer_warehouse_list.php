<?php
$this->view('lib/header');
?>
	<div class="main-container">
		<?php $this->view('lib/sidebar'); ?>
		<div class="main-content">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">
						<ol class="breadcrumb">
							<li>
								<i class="clip-pencil"></i>
								<a href="<?php echo base_url(); ?>dashboard">Dashboard</a>
							</li>
							<li>
								<a href="<?php echo base_url('customer_detail'); ?>">Customer List</a>
							</li>
							<li class="active">Warehouses - <?php echo htmlspecialchars(isset($cust_data->c_companyname) ? $cust_data->c_companyname : 'Customer'); ?></li>
						</ol>
						<div class="page-header">
							<h3>
								Warehouses - <span><?php echo htmlspecialchars(isset($cust_data->c_companyname) ? $cust_data->c_companyname : ''); ?></span>
								<div class="pull-right">
									<a href="javascript:;" onclick="open_create_warehouse_modal(<?php echo (int)$customer_id; ?>)" class="btn btn-info"><i class="fa fa-plus"></i> Create Warehouse</a>
									<a href="<?php echo base_url('customer_detail'); ?>" class="btn btn-default"><i class="fa fa-arrow-left"></i> Back to Customer List</a>
								</div>
							</h3>
						</div>
						<div class="panel panel-default">
							<div class="panel-body">
								<?php if (empty($warehouses)) { ?>
									<p class="text-muted">No warehouses found for this customer. Click "Create Warehouse" to add one.</p>
								<?php } else { ?>
									<div class="table-responsive">
										<table class="table table-bordered table-striped">
											<thead>
												<tr>
													<th class="text-center" width="50">Sr No</th>
													<th>Warehouse Number</th>
													<th>Name</th>
													<th>Country</th>
													<th>Address</th>
													<th class="text-center" width="140">Created At</th>
													<th class="text-center" width="120">Action</th>
												</tr>
											</thead>
											<tbody>
												<?php
												$sr = 1;
												foreach ($warehouses as $wh) {
													$country_name = isset($wh->country_name) ? htmlspecialchars($wh->country_name) : '-';
													$created_at = !empty($wh->created_at) ? date('d M Y', strtotime($wh->created_at)) : '-';
												?>
												<tr>
													<td class="text-center"><?php echo $sr++; ?></td>
													<td><?php echo htmlspecialchars($wh->warehouse_number); ?></td>
													<td><?php echo htmlspecialchars($wh->name); ?></td>
													<td><?php echo $country_name; ?></td>
													<td><?php echo htmlspecialchars($wh->address); ?></td>
													<td class="text-center"><?php echo $created_at; ?></td>
													<td class="text-center">
														<button type="button" class="btn btn-sm btn-primary" onclick="open_edit_warehouse_modal(<?php echo (int)$wh->id; ?>)" title="Edit"><i class="fa fa-pencil"></i></button>
														<button type="button" class="btn btn-sm btn-danger" onclick="delete_warehouse_confirm(<?php echo (int)$wh->id; ?>)" title="Delete"><i class="fa fa-trash"></i></button>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Create Warehouse modal (moved from customer list) -->
<div id="create_warehouse_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 98%; max-width: 1400px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Create Warehouse</h4>
            </div>
            <form action="javascript:;" method="post" name="create_warehouse_form" id="create_warehouse_form">
                <div class="modal-body" style="max-height: 65vh; overflow-y: auto;">
                    <input type="hidden" id="create_warehouse_customer_id" name="customer_id" value="<?php echo (int)$customer_id; ?>" />
                    <div class="row" style="margin-bottom:6px;">
                        <div class="col-xs-3"><label class="control-label" style="font-size:12px;">Warehouse Number</label></div>
                        <div class="col-xs-3"><label class="control-label" style="font-size:12px;">Warehouse Country</label></div>
                        <div class="col-xs-3"><label class="control-label" style="font-size:12px;">Warehouse Name</label></div>
                        <div class="col-xs-2"><label class="control-label" style="font-size:12px;">Address</label></div>
                        <div class="col-xs-1"></div>
                    </div>
                    <div id="warehouse_rows">
                        <div class="warehouse-row panel panel-default" style="padding:6px 10px; margin-bottom:6px;">
                            <div class="row">
                                <div class="col-xs-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <input type="text" name="warehouse_number[]" class="form-control input-sm" placeholder="Number" required maxlength="100" title="Warehouse Number (required, max 100 characters)" />
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <select name="warehouse_country[]" class="form-control input-sm select2 warehouse_country" required title="Select Country (required)">
                                            <option value="">Select Country</option>
                                            <?php
                                            $countrydata_list = (isset($countrydata) && is_array($countrydata)) ? $countrydata : array();
                                            foreach ($countrydata_list as $c) {
                                                if (isset($c->id) && isset($c->c_name)) {
                                                    echo '<option value="'.(int)$c->id.'">'.htmlspecialchars($c->c_name).'</option>';
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xs-3">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <input type="text" name="warehouse_name[]" class="form-control input-sm" placeholder="Name" required maxlength="255" title="Warehouse Name (required, max 255 characters)" />
                                    </div>
                                </div>
                                <div class="col-xs-2">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <textarea name="warehouse_address[]" class="form-control input-sm warehouse-address" rows="2" placeholder="Address" required maxlength="65535" title="Address (required)" style="resize: vertical; min-height: 38px;"></textarea>
                                    </div>
                                </div>
                                <div class="col-xs-1 text-right">
                                    <button type="button" class="btn btn-danger btn-sm btn-remove-warehouse" onclick="remove_warehouse_row(this)" title="Remove warehouse" style="margin-top:0;">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin-bottom:0; margin-top:4px;">
                        <button type="button" class="btn btn-default btn-sm" onclick="add_warehouse_row()" title="Add another warehouse">
                            <i class="fa fa-plus"></i> Add Warehouse
                        </button>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Submit</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Warehouse modal -->
<div id="edit_warehouse_modal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: 600px;">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Warehouse</h4>
            </div>
            <form action="javascript:;" method="post" name="edit_warehouse_form" id="edit_warehouse_form">
                <input type="hidden" id="edit_warehouse_id" name="id" value="" />
                <input type="hidden" id="edit_warehouse_customer_id" name="customer_id" value="<?php echo (int)$customer_id; ?>" />
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label">Warehouse Number <span class="text-danger">*</span></label>
                        <input type="text" id="edit_warehouse_number" name="warehouse_number" class="form-control" placeholder="Number" required maxlength="100" title="Warehouse Number (required, max 100 characters)" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Warehouse Name <span class="text-danger">*</span></label>
                        <input type="text" id="edit_warehouse_name" name="name" class="form-control" placeholder="Name" required maxlength="255" title="Warehouse Name (required, max 255 characters)" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Country</label>
                        <select id="edit_warehouse_country" name="country" class="form-control select2 edit_warehouse_country" title="Select Country">
                            <option value="">Select Country</option>
                            <?php
                            $countrydata_list = (isset($countrydata) && is_array($countrydata)) ? $countrydata : array();
                            foreach ($countrydata_list as $c) {
                                if (isset($c->id) && isset($c->c_name)) {
                                    echo '<option value="'.(int)$c->id.'">'.htmlspecialchars($c->c_name).'</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Address <span class="text-danger">*</span></label>
                        <textarea id="edit_warehouse_address" name="address" class="form-control" rows="3" placeholder="Address" required maxlength="65535" title="Address (required)"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-info">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php $this->view('lib/footer'); ?>
<script>
var warehouseListUrl = '<?php echo base_url('customer_detail/warehouse_list/'.(int)$customer_id); ?>';
var root = '<?php echo base_url(); ?>';

function open_create_warehouse_modal(customer_id) {
	$("#create_warehouse_customer_id").val(customer_id);
	$("#warehouse_rows .warehouse-row").not(":first").remove();
	$("#warehouse_rows .warehouse-row:first").find('input, textarea, select').val('');
	$("#create_warehouse_modal").modal('show');
	if ($(".select2").length) {
		$("#create_warehouse_modal .warehouse_country").select2({ width: '100%' });
	}
}

function add_warehouse_row() {
	var $first = $("#warehouse_rows .warehouse-row:first");
	var $clone = $first.clone();
	$clone.find('.select2-container').remove();
	$clone.find('select.warehouse_country').removeClass('select2-hidden-accessible').removeAttr('aria-hidden tabindex').show().css({ width: '', visibility: '', position: '' });
	$clone.find('input, textarea').val('');
	$clone.find('select').val('');
	$clone.appendTo("#warehouse_rows");
	$clone.find('.warehouse_country').select2({ width: '100%' });
	update_warehouse_delete_buttons();
}

function remove_warehouse_row(btn) {
	var $row = $(btn).closest('.warehouse-row');
	if ($("#warehouse_rows .warehouse-row").length > 1) {
		$row.remove();
		update_warehouse_delete_buttons();
	}
}

function update_warehouse_delete_buttons() {
	var n = $("#warehouse_rows .warehouse-row").length;
	$("#warehouse_rows .btn-remove-warehouse").prop('disabled', n <= 1).css('opacity', n <= 1 ? 0.5 : 1);
}

function open_edit_warehouse_modal(warehouseId) {
	$.get(root + 'customer_detail/get_warehouse', { id: warehouseId }, function(resp) {
		try {
			var obj = typeof resp === 'string' ? JSON.parse(resp) : resp;
			if (obj.res !== 1 || !obj.data) {
				if (typeof toastr !== 'undefined') toastr.error(obj.msg || 'Warehouse not found.');
				else alert(obj.msg || 'Warehouse not found.');
				return;
			}
			var d = obj.data;
			$("#edit_warehouse_id").val(d.id);
			$("#edit_warehouse_customer_id").val(d.customer_id);
			$("#edit_warehouse_number").val(d.warehouse_number || '');
			$("#edit_warehouse_name").val(d.name || '');
			$("#edit_warehouse_address").val(d.address || '');
			$("#edit_warehouse_modal").modal('show');
			$("#edit_warehouse_country").val(d.country || '');
			if ($("#edit_warehouse_modal .edit_warehouse_country").length && (!$("#edit_warehouse_modal .edit_warehouse_country").hasClass("select2-hidden-accessible"))) {
				$("#edit_warehouse_modal .edit_warehouse_country").select2({ width: '100%' });
			}
			$("#edit_warehouse_country").trigger('change');
		} catch (e) {
			if (typeof toastr !== 'undefined') toastr.error('Request failed.');
			else alert('Request failed.');
		}
	}).fail(function() {
		if (typeof toastr !== 'undefined') toastr.error('Request failed.');
		else alert('Request failed.');
	});
}

function delete_warehouse_confirm(warehouseId) {
	if (!confirm('Are you sure you want to delete this warehouse?')) return;
	$.blockUI && $.blockUI();
	$.post(root + 'customer_detail/delete_warehouse', { id: warehouseId, customer_id: <?php echo (int)$customer_id; ?> }, function(resp) {
		$.unblockUI && $.unblockUI();
		try {
			var obj = typeof resp === 'string' ? JSON.parse(resp) : resp;
			if (obj.res == 1) {
				if (typeof toastr !== 'undefined') toastr.success(obj.msg || 'Warehouse deleted.');
				else alert(obj.msg || 'Warehouse deleted.');
				window.location.href = warehouseListUrl;
			} else {
				if (typeof toastr !== 'undefined') toastr.error(obj.msg || 'Delete failed.');
				else alert(obj.msg || 'Delete failed.');
			}
		} catch (e) {
			if (typeof toastr !== 'undefined') toastr.error('Request failed.');
			else alert('Request failed.');
		}
	}).fail(function() {
		$.unblockUI && $.unblockUI();
		if (typeof toastr !== 'undefined') toastr.error('Request failed.');
		else alert('Request failed.');
	});
}

$(document).ready(function() {
	$("#create_warehouse_form").submit(function(event) {
		event.preventDefault();
		if (!$("#create_warehouse_form")[0].checkValidity()) {
			$("#create_warehouse_form")[0].reportValidity();
			return false;
		}
		// Ensure at least one row has all required fields
		var hasCompleteRow = false;
		$("#warehouse_rows .warehouse-row").each(function() {
			var $row = $(this);
			var num = $row.find('input[name="warehouse_number[]"]').val();
			var name = $row.find('input[name="warehouse_name[]"]').val();
			var addr = $row.find('textarea[name="warehouse_address[]"]').val();
			var country = $row.find('select[name="warehouse_country[]"]').val();
			if ($.trim(num) !== '' && $.trim(name) !== '' && $.trim(addr) !== '' && (country !== '' && country !== null)) {
				hasCompleteRow = true;
				return false;
			}
		});
		if (!hasCompleteRow) {
			if (typeof toastr !== 'undefined') toastr.error('Please fill at least one warehouse row with all required fields (Number, Country, Name, Address).');
			else alert('Please fill at least one warehouse row with all required fields (Number, Country, Name, Address).');
			return false;
		}
		$.blockUI && $.blockUI();
		var postData = new FormData(this);
		$.ajax({
			type: "post",
			url: root + 'customer_detail/save_warehouses',
			data: postData,
			processData: false,
			contentType: false,
			cache: false,
			success: function(responseData) {
				try {
					var obj = typeof responseData === 'string' ? JSON.parse(responseData) : responseData;
					if (obj.res == 1) {
						if (typeof toastr !== 'undefined') toastr.success("Warehouse(s) saved successfully.");
						else alert("Warehouse(s) saved successfully.");
						$("#create_warehouse_modal").modal('hide');
						$.unblockUI && $.unblockUI();
						setTimeout(function(){ window.location.href = warehouseListUrl; }, 1000);
					} else {
						$.unblockUI && $.unblockUI();
						if (typeof toastr !== 'undefined') toastr.error(obj.msg || "Something went wrong.");
						else alert(obj.msg || "Something went wrong.");
					}
				} catch (e) {
					$.unblockUI && $.unblockUI();
					if (typeof toastr !== 'undefined') toastr.error("Request failed.");
					else alert("Request failed.");
				}
			},
			error: function() {
				$.unblockUI && $.unblockUI();
				if (typeof toastr !== 'undefined') toastr.error("Request failed.");
				else alert("Request failed.");
			}
		});
	});

	$("#edit_warehouse_form").submit(function(event) {
		event.preventDefault();
		if (!$("#edit_warehouse_form")[0].checkValidity()) {
			$("#edit_warehouse_form")[0].reportValidity();
			return false;
		}
		$.blockUI && $.blockUI();
		var postData = $(this).serialize();
		$.post(root + 'customer_detail/update_warehouse', postData, function(responseData) {
			$.unblockUI && $.unblockUI();
			try {
				var obj = typeof responseData === 'string' ? JSON.parse(responseData) : responseData;
				if (obj.res == 1) {
					if (typeof toastr !== 'undefined') toastr.success(obj.msg || "Warehouse updated.");
					else alert(obj.msg || "Warehouse updated.");
					$("#edit_warehouse_modal").modal('hide');
					setTimeout(function(){ window.location.href = warehouseListUrl; }, 800);
				} else {
					if (typeof toastr !== 'undefined') toastr.error(obj.msg || "Update failed.");
					else alert(obj.msg || "Update failed.");
				}
			} catch (e) {
				if (typeof toastr !== 'undefined') toastr.error("Request failed.");
				else alert("Request failed.");
			}
		}).fail(function() {
			$.unblockUI && $.unblockUI();
			if (typeof toastr !== 'undefined') toastr.error("Request failed.");
			else alert("Request failed.");
		});
	});
});
</script>
