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
			 				<a href="<?=base_url()?>dashboard">
										Dashboard
									</a>
			 			</li>
			 			<li class="active">
			 				<a href="<?=base_url().'invoice_listing'?>">Invoice List</a>
			 			</li>
			 	 	</ol>
			 		<div class="page-header title1">
			 			<h3>
							Loading Plan
						</h3>
					</div>
					
			 	</div>
			 </div>
			 <div class="row">
			 	<div class="col-sm-12">
			 		<div class="panel panel-default">
			 			<div class="panel-heading">
			 				<i class="fa fa-external-link-square"></i>
			 		 	</div>
                         <div class="">
			 			   <div class="panel-body form-body">
							<div class="col-md-4">
										<label class="col-md-4 control-label" style="margin-top:5px;"><strong class=""> Performa Date</strong></label>
										 <div class="col-md-8">
										<?php 
											$year = date('n') > 3 ? date('01-04-Y').' - '.(date('31-03-Y',strtotime("+1 year"))) : (date('01-04-Y',strtotime("-1 year"))).' - '.date('31-03-Y');
											
											$invoicedate = explode(" - ",$year);
											$start_date = $invoicedate[0];
											$end_date 	= $invoicedate[1];
											if(!empty($_SESSION['assign_s_date']))
											{
												$start_date = $_SESSION['assign_s_date'];
											}
											if(!empty($_SESSION['assign_e_date']))
											{
												$end_date = $_SESSION['assign_e_date'];
											}
									 	 ?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$start_date?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$end_date?>">
										 </div>     
									</div>
								<div class="col-md-5" style="margin-bottom: 5px;">
									<label class="col-md-4 control-label" style="margin-top: 5px;">
										<strong class=""> Select Customer</strong>
									</label>
						 		 <div class="col-md-8">
										 <select class="select2" id="customer_id" name="customer_id" onchange="load_data_table()" >
											<option value="">All Customer</option>
												<?php
												for($p=0;$p<count($allconsign);$p++)
												{
													 $sel ='';
													 if($allconsign[$p]->id == $_SESSION['assign_cust_id'])
													 {
														 $sel ='selected="selected"';
													 }
											 	?>
													<option <?=$sel?> value="<?=$allconsign[$p]->id?>"><?=$allconsign[$p]->c_companyname?></option>
												<?php
												}
												?>
										</select>
						 		 </div>     
								</div>
									<!-- <div class="view_report col-md-12" style="margin-top:50px;"></div> -->
									<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
											<tr> 
    <th style="width:4%;">Sr No</th> 
    <th style="width:10%;">PO No</th>
    <th style="width:10%;">Performa Invoice No</th>
    <th style="width:10%;">Performa Invoice Date</th>
    <th style="width:15%;">Consignee Name</th>
    <th style="width:8%;">No Of Container</th>
    <th style="width:10%;">Producation Sheet Done</th>
    <th style="width:8%;">Pending For Loading</th>
    <th style="width:8%;">Loading Done</th>
    <th style="width:8%;">Ready For Export</th>
    <th style="width:8%;">Export Done</th>
    <th style="width:8%;">Way Date</th>
    <th style="width:8%;">Estimated Arrival Date</th>
    <th style="width:8%;">Action</th>
</tr>

											</thead>
											<tbody>
												<!-- Table body content goes here -->
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
	</div>
</div>
 
<?php 
$this->view('lib/footer');
 
?>
 
<div id="remainprintModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1122px">
        <!-- Modal content-->
        <div class="modal-content"  >
            <div class="modal-header">
                <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Remaining Print </h4>
            </div>
			 
            <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
                <div class="row">
				 	 
					<div class="col-md-12" id="remaindata_wise_html"> </div>        
				       
				 </div>  			
				</div>
            <div class="modal-footer">
			    <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 	 
			 
    </div>
</div>
</div>

<div id="printModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1122px">
        <!-- Modal content-->
        <div class="modal-content"  >
            <div class="modal-header">
                <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Company Wise Print </h4>
            </div>
			 
            <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
                <div class="row">
				 	 
					<div class="col-md-12" id="company_wise_html"> </div>        
				       
				 </div>  			
				</div>
            <div class="modal-footer">
			    <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 	 
			 
    </div>
</div>
</div>

<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:1122px">
        <!-- Modal content-->
        <div class="modal-content"  >
            <div class="modal-header">
                <button type="button"  onclick="close_modal()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Export Wise Edit </h4>
            </div>
			 
            <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
                <div class="row">
				 	 
					<div class="col-md-12" id="export_wise_html"> </div>        
				       
				 </div>  			
				</div>
            <div class="modal-footer">
			    <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 	 
			 
    </div>
</div>
</div>

<!-- On the Way Modal -->
<div id="onTheWayModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-md">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">
                    <i class="fa fa-truck"></i> On the Way - Update Date
                </h4>
            </div>
            <form id="on_the_way_form" action="javascript:;" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="way_date">
                            <i class="fa fa-calendar-check-o"></i> Way Date <span style="color: red;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" placeholder="dd-mm-yyyy" id="way_date" name="way_date" class="form-control defualt-date-picker" value="" required title="Select Way Date" aria-required="true">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="estimated_arrival_date">
                            <i class="fa fa-clock-o"></i> Estimated Arrival Date <span style="color: red;">*</span>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" placeholder="dd-mm-yyyy" id="estimated_arrival_date" name="estimated_arrival_date" class="form-control defualt-date-picker" value="" required title="Select Estimated Arrival Date" aria-required="true">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="on_the_way_notes">
                            <i class="fa fa-sticky-note-o"></i> Notes
                        </label>
                        <textarea id="on_the_way_notes" name="on_the_way_notes" class="form-control" rows="4" placeholder="Add any additional notes..."></textarea>
                    </div>
                    
                    <input type="hidden" id="on_the_way_performa_invoice_id" name="performa_invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        <i class="fa fa-times"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-check"></i> Save
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Add to Inventory Modal -->
<div id="addToInventoryModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="max-width: 90%; width: 1200px;">
        <div class="modal-content add-to-inventory-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add to Inventory</h4>
            </div>
            <div class="modal-body">
                <div id="warehouse_forms_container">
                    <!-- Forms will be dynamically generated here -->
                </div>
                <div id="design_preview_container" style="margin-top: 20px; display: none;">
                    <div class="panel panel-info">
                        <div class="panel-heading">
                            <strong><i class="fa fa-eye"></i> Selected Designs Preview</strong>
                        </div>
                        <div class="panel-body" id="design_preview_content">
                            <!-- Preview will be dynamically generated here -->
                        </div>
                    </div>
                </div>
                <input type="hidden" id="add_to_inventory_performa_invoice_id" value="">
                <input type="hidden" id="current_warehouse_index" value="0">
            </div>
        </div>
    </div>
</div>

<style>
/* Remove whitespace from table cells */
#datatable td {
    padding: 8px 5px !important;
}

/* Ensure date columns have no extra spacing */
#datatable td:nth-child(12),
#datatable td:nth-child(13) {
    white-space: nowrap;
    padding: 8px 3px !important;
    text-align: center;
}

/* Action column styling - allow wrapping for dropdown */
#datatable td:nth-child(14) {
    white-space: normal;
    padding: 8px 5px !important;
    text-align: center;
}

/* Remove extra spacing in date cells */
#datatable td:nth-child(12) span,
#datatable td:nth-child(13) span {
    display: inline-block;
    width: 100%;
}

/* Add to Inventory modal - match shared design */
#addToInventoryModal .modal-content {
    border-radius: 8px;
    overflow: visible;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    max-height: 90vh;
    display: flex;
    flex-direction: column;
}

#addToInventoryModal .modal-header {
    border-bottom: 1px solid #eee;
    padding: 15px 20px;
    flex-shrink: 0;
}

#addToInventoryModal .modal-title {
    font-size: 18px;
    font-weight: 600;
}

#addToInventoryModal .modal-body {
    padding: 20px 25px;
    overflow-x: visible;
    overflow-y: auto;
    max-height: calc(90vh - 120px);
    flex: 1 1 auto;
}

#addToInventoryModal .control-label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #333;
}

#addToInventoryModal .radio-inline {
    font-weight: normal;
    cursor: pointer;
}

#addToInventoryModal .modal-footer {
    border-top: 1px solid #eee;
    padding: 15px 25px;
    background: #f9f9f9;
    flex-shrink: 0;
}

#addToInventoryModal .btn-primary {
    padding: 8px 20px;
}

/* Custom Design Dropdown Styles */
.design-dropdown-wrapper {
    position: relative;
    width: 100%;
    z-index: 1;
}

#addToInventoryModal .panel-body {
    overflow: visible;
}

#addToInventoryModal .warehouse-form {
    overflow: visible;
}

/* Design Preview Table Styles */
#design_preview_content .table-responsive {
    margin: 0;
}

#design_preview_content .table {
    margin-bottom: 0;
}

#design_preview_content .table thead th {
    background-color: #f5f5f5;
    font-weight: 600;
    font-size: 13px;
}

#design_preview_content .table tbody td {
    vertical-align: middle;
}

/* Scrollable inner table */
#design_preview_content .table tbody td > div {
    max-height: 300px;
    overflow-y: auto;
    overflow-x: auto;
}

#design_preview_content .table tbody td table {
    margin-bottom: 0;
}

#design_preview_content .table tbody td table thead th {
    background-color: #e8e8e8;
    font-size: 11px;
    font-weight: 600;
    padding: 6px 8px;
    white-space: nowrap;
}

#design_preview_content .table tbody td table tbody td {
    padding: 6px 8px;
    font-size: 12px;
}

#design_preview_content .table tbody td table tbody tr:hover {
    background-color: #f9f9f9;
}

.design-dropdown-toggle {
    background-color: #fff;
    border: 1px solid #ccc;
}

.design-dropdown-toggle:hover {
    border-color: #999;
}

.design-dropdown-menu {
    max-height: 500px;
    overflow-y: auto;
    width: 100%;
    min-width: 100%;
    z-index: 1050;
    position: absolute;
}

.design-table-container {
    width: 100%;
    overflow-x: auto;
}

.design-selection-table {
    font-size: 13px;
}

.design-selection-table thead th {
    font-weight: 600;
    font-size: 12px;
    text-transform: uppercase;
    border-bottom: 2px solid #ddd;
}

.design-selection-table tbody tr {
    cursor: pointer;
    transition: background-color 0.2s;
}

.design-selection-table tbody tr:hover {
    background-color: #f5f5f5;
}

.design-selection-table tbody tr.selected {
    background-color: #e7f3ff;
}

.design-selection-table tbody tr.selected:hover {
    background-color: #d0e7ff;
}

.design-selection-table tbody td {
    padding: 8px;
    vertical-align: middle;
}

.design-selection-table tbody td:first-child {
    text-align: center;
    width: 30px;
}

.design-selection-table tbody td:last-child {
    text-align: right;
    font-weight: 600;
}

.design-selection-table tbody tr.disabled-row {
    opacity: 0.5;
    background-color: #f9f9f9;
    cursor: not-allowed;
}

.design-selection-table tbody tr.disabled-row:hover {
    background-color: #f9f9f9;
}

.design-selection-table tbody tr.disabled-row input[type="number"] {
    background-color: #f5f5f5;
    cursor: not-allowed;
}

.design-boxes-input {
    border: 1px solid #ddd;
    border-radius: 3px;
}

.design-boxes-input:focus {
    border-color: #66afe9;
    outline: 0;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
}

.design-boxes-input.has-error {
    border-color: #d9534f;
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 6px rgba(217,83,79,.6);
}

.boxes-error-message {
    font-size: 11px;
    color: #d9534f;
    font-weight: 600;
}

.boxes-max-hint {
    font-size: 10px;
    color: #999;
    font-style: italic;
}

.design-boxes-input:focus + .boxes-error-message + .boxes-max-hint {
    color: #337ab7;
}

.design-selected-text {
    display: inline-block;
}

.design-selected-count {
    color: #337ab7;
    font-weight: 600;
}

/* Theme-based styling for On the Way modal */
#onTheWayModal .modal-content {
    overflow: hidden;
    animation: modalSlideIn 0.3s ease-out;
}

@keyframes modalSlideIn {
    from {
        opacity: 0;
        transform: translateY(-50px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

#onTheWayModal .modal-content.modal-show {
    animation: modalSlideIn 0.3s ease-out;
}

/* Use theme's primary color for icons and focus states */
#onTheWayModal .control-label i {
    margin-right: 8px;
    color: inherit;
}

#onTheWayModal .form-control {
    transition: all 0.3s ease;
}

#onTheWayModal .form-control:focus {
    outline: none;
    transform: translateY(-1px);
}

/* Input group styling using theme colors */
#onTheWayModal .input-group-addon {
    transition: all 0.3s ease;
}

#onTheWayModal .input-group.datepicker-open .input-group-addon {
    background-color: rgba(0, 123, 255, 0.1);
}

#onTheWayModal .input-group .form-control:focus + .input-group-addon,
#onTheWayModal .input-group.datepicker-open .input-group-addon {
    background-color: rgba(0, 123, 255, 0.1);
}

#onTheWayModal textarea {
    transition: all 0.3s ease;
}

#onTheWayModal textarea:focus {
    outline: none;
    transform: translateY(-1px);
}

/* Button enhancements using theme classes */
#onTheWayModal .btn {
    transition: all 0.3s ease;
}

#onTheWayModal .btn-primary:hover {
    transform: translateY(-2px);
}

#onTheWayModal .btn-primary:active {
    transform: translateY(0);
}

#onTheWayModal .btn-default:hover {
    transform: translateY(-1px);
}

#onTheWayModal .control-label {
    font-weight: 600;
    margin-bottom: 8px;
    display: block;
    transition: color 0.3s ease;
}

#onTheWayModal .modal-header {
    position: relative;
}

#onTheWayModal .modal-header .modal-title i {
    margin-right: 10px;
}

#onTheWayModal .close {
    transition: all 0.3s ease;
}

#onTheWayModal .close:hover {
    opacity: 1 !important;
    transform: rotate(90deg);
}

/* Responsive adjustments */
@media (max-width: 768px) {
    #onTheWayModal .modal-dialog {
        margin: 10px;
    }
    
    #onTheWayModal .modal-body {
        padding: 20px 15px;
    }
    
    #onTheWayModal .modal-footer {
        padding: 15px;
    }
}
</style>
  

<script>
// Global helper function to safely block page - works even if block_page is not defined
function safeBlock() {
	if(typeof block_page === 'function') {
		block_page();
	} else if(typeof $.blockUI === 'function') {
		$.blockUI({ css: {
			border: 'none',
			padding: '0px',
			width: '17%',
			left:'43%',
			backgroundColor: '#000',
			'-webkit-border-radius': '10px',
			'-moz-border-radius': '10px',
			opacity: .5,
			color: '#fff',
			zIndex: '10000'
		},
		message :  '<h3> Please wait...</h3>' });
	}
}

// Global helper function to safely unblock page - works even if unblock_page is not defined
function safeUnblock(type, msg) {
	if(typeof unblock_page === 'function') {
		unblock_page(type, msg);
	} else if(typeof $.unblockUI === 'function') {
		// Fallback to direct jQuery unblockUI
		if(type !== "" && msg !== "") {
			if(typeof toastr !== 'undefined') {
				toastr[type](msg);
			}
		}
		setTimeout(function(){ $.unblockUI(); }, 500);
	} else {
		// Last resort: just show message if toastr is available
		if(typeof toastr !== 'undefined' && type !== "" && msg !== "") {
			toastr[type](msg);
		}
	}
}

function company_wise_print(performa_invoice_id)
{
	safeBlock();
	 $.ajax({ 
           type: "POST", 
           url: root+'create_pi_loading/companywise_print',
           data:
		   {
             "performa_invoice_id"	: performa_invoice_id
           }, 
           cache: false, 
           success: function (data) { 
				 
			$("#printModal").modal({
				backdrop: 'static',
				keyboard: false
			});
		 
			$("#company_wise_html").html(data);
				safeUnblock('',"")
           },
		   error: function(jqXHR, textStatus, errorThrown) {
			   console.log('AJAX Error:', errorThrown);
			   safeUnblock("error", "An error occurred. Please try again.");
		   }
	 });
}


function remaining_pi(performa_invoice_id)
{
	safeBlock();
	 $.ajax({ 
           type: "POST", 
           url: root+'create_pi_loading/remaining_pi',
           data:
		   {
             "performa_invoice_id"	: performa_invoice_id
           }, 
           cache: false, 
           success: function (data) { 
				 
			$("#remainprintModal").modal({
				backdrop: 'static',
				keyboard: false
			});
		 
			$("#remaindata_wise_html").html(data);
				safeUnblock('',"")
           },
		   error: function(jqXHR, textStatus, errorThrown) {
			   console.log('AJAX Error:', errorThrown);
			   safeUnblock("error", "An error occurred. Please try again.");
		   }
	 });
}


function export_wise_print(performa_invoice_id)
{
	safeBlock();
	 $.ajax({ 
           type: "POST", 
           url: root+'create_pi_loading/exportwise_print',
           data:
		   {
             "performa_invoice_id"	: performa_invoice_id
           }, 
           cache: false, 
           success: function (data)
		   { 
			$("#editModal").modal({
				backdrop: 'static',
				keyboard: false
			});
		  	$("#export_wise_html").html(data);
				safeUnblock('',"")
           },
		   error: function(jqXHR, textStatus, errorThrown) {
			   console.log('AJAX Error:', errorThrown);
			   safeUnblock("error", "An error occurred. Please try again.");
		   }
	 });
}
$(".select2").select2({
	width:"100%"
});

// Initialize date pickers (will be re-initialized when modal opens)
$('.defualt-date-picker').datepicker({
	autoclose: true,
	format: 'dd-mm-yyyy'
});

// Function to open On the Way modal
function open_on_the_way_modal(performa_invoice_id) {
	// Set the invoice ID
	$("#on_the_way_performa_invoice_id").val(performa_invoice_id);
	
	// Reset form first
	$("#on_the_way_form")[0].reset();
	
	// Block page while fetching data
	safeBlock();
	
	// Fetch existing data
	$.ajax({
		type: "POST",
		url: root + 'assign_producation/get_on_the_way_data',
		data: {
			"performa_invoice_id": performa_invoice_id
		},
		cache: false,
		success: function(responseData) {
			try {
				var obj = JSON.parse(responseData);
				
				// Destroy existing datepickers if any (with error handling)
				try {
					$('#way_date, #estimated_arrival_date').datepicker('destroy');
				} catch(e) {
					// Datepicker might not be initialized, ignore error
				}
				
				// Populate form fields with existing data if available
				if(obj.res == 1) {
					if(obj.way_date) {
						$("#way_date").val(obj.way_date);
					}
					if(obj.estimated_arrival_date) {
						$("#estimated_arrival_date").val(obj.estimated_arrival_date);
					}
					if(obj.on_the_way_notes) {
						$("#on_the_way_notes").val(obj.on_the_way_notes);
					}
				}
				
			// Initialize date pickers for modal fields with enhanced styling
			$('#way_date, #estimated_arrival_date').datepicker({
				autoclose: true,
				format: 'dd-mm-yyyy',
				orientation: 'bottom auto',
				todayHighlight: true,
				startDate: new Date()
			}).on('show', function() {
				$(this).closest('.input-group').addClass('datepicker-open');
			}).on('hide', function() {
				$(this).closest('.input-group').removeClass('datepicker-open');
			}).on('changeDate', function() {
				// Trigger validation when date is selected
				$(this).valid();
			});
				
				// Unblock page
				safeUnblock('', '');
				
				// Open modal with animation
				$("#onTheWayModal").modal({
					backdrop: 'static',
					keyboard: false,
					show: true
				});
				
				// Add fade-in animation
				setTimeout(function() {
					$("#onTheWayModal .modal-content").addClass('modal-show');
				}, 10);
			} catch(e) {
				safeUnblock("error", "An error occurred while processing data. Please try again.");
				console.log("Error parsing response: " + e);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			safeUnblock("error", "An error occurred while loading data. Please try again.");
			console.log("Error: " + textStatus + " - " + errorThrown);
			// Still open modal even on error so user can enter data manually
			$("#onTheWayModal").modal({
				backdrop: 'static',
				keyboard: false,
				show: true
			});
		}
	});
}

// Handle On the Way form submission
$("#on_the_way_form").submit(function(event) {
	event.preventDefault();
	
	if(!$("#on_the_way_form").valid()) {
		return false;
	}
	
	// Get form data
	var performa_invoice_id = $("#on_the_way_performa_invoice_id").val();
	var way_date = $("#way_date").val();
	var estimated_arrival_date = $("#estimated_arrival_date").val();
	var on_the_way_notes = $("#on_the_way_notes").val();
	
	// Block page while processing
	safeBlock();
	
	// AJAX call to save the data
	$.ajax({
		type: "POST",
		url: root + 'assign_producation/save_on_the_way',
		data: {
			"performa_invoice_id": performa_invoice_id,
			"way_date": way_date,
			"estimated_arrival_date": estimated_arrival_date,
			"on_the_way_notes": on_the_way_notes
		},
		cache: false,
		success: function(responseData) {
			try {
				var obj = JSON.parse(responseData);
				if(obj.res == 1) {
					safeUnblock("success", obj.msg || "On the Way information saved successfully.");
					$("#onTheWayModal").modal('hide');
					$("#on_the_way_form")[0].reset();
					// Reload the page to update the table data
					setTimeout(function() {
						window.location.reload();
					}, 1000);
				} else {
					safeUnblock("error", obj.msg || "Something went wrong. Please try again.");
				}
			} catch(e) {
				safeUnblock("error", "An error occurred while processing the response. Please try again.");
				console.log("Error parsing response: " + e);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			safeUnblock("error", "An error occurred. Please try again.");
			console.log("Error: " + textStatus + " - " + errorThrown);
		}
	});
});

// Add validation rules for On the Way form
$("#on_the_way_form").validate({
	rules: {
		way_date: {
			required: true,
			dateFormat: true
		},
		estimated_arrival_date: {
			required: true,
			dateFormat: true
		}
	},
	messages: {
		way_date: {
			required: "Way Date is required. Please select a date."
		},
		estimated_arrival_date: {
			required: "Estimated Arrival Date is required. Please select a date."
		}
	},
	errorClass: "error",
	validClass: "valid",
	errorPlacement: function(error, element) {
		error.insertAfter(element.closest('.input-group'));
	},
	highlight: function(element) {
		$(element).closest('.form-group').addClass('has-error');
	},
	unhighlight: function(element) {
		$(element).closest('.form-group').removeClass('has-error');
	},
	submitHandler: function(form) {
		// This will only be called if validation passes
		return true;
	}
});

// Add custom validation method for date format
$.validator.addMethod("dateFormat", function(value, element) {
	if (!value) {
		return false;
	}
	// Check if date is in dd-mm-yyyy format
	var datePattern = /^(\d{2})-(\d{2})-(\d{4})$/;
	if (!datePattern.test(value)) {
		return false;
	}
	var parts = value.split('-');
	var day = parseInt(parts[0], 10);
	var month = parseInt(parts[1], 10);
	var year = parseInt(parts[2], 10);
	
	// Validate date
	if (month < 1 || month > 12) return false;
	if (day < 1 || day > 31) return false;
	if (year < 1900 || year > 2100) return false;
	
	// Check if date is valid
	var date = new Date(year, month - 1, day);
	return date.getFullYear() == year && 
		   date.getMonth() == month - 1 && 
		   date.getDate() == day;
}, "Please enter a valid date in dd-mm-yyyy format");

// Function to open Add to Inventory modal
function open_add_to_inventory_modal(performa_invoice_id) {
	$("#add_to_inventory_performa_invoice_id").val(performa_invoice_id);
	$("#warehouse_forms_container").empty();
	$("#current_warehouse_index").val(0);
	$("#design_preview_container").hide();
	$("#design_preview_content").empty();
	
	// Block page while fetching warehouses and designs
	safeBlock();
	
	// Reset global variables
	window.allDesigns = [];
	window.selectedDesignsMap = {}; // warehouse_id -> array of design IDs
	window.designBoxesMap = {}; // warehouse_id -> { design_id: boxes }
	
	// Fetch both warehouses and designs
		
		$.when(
		$.ajax({
			type: "POST",
			url: root + 'assign_producation/get_warehouses',
			data: { "performa_invoice_id": performa_invoice_id },
			cache: false
		}),
		$.ajax({
			type: "POST",
			url: root + 'assign_producation/get_designs',
			data: { "performa_invoice_id": performa_invoice_id },
			cache: false
		})
	).done(function(warehousesResponse, designsResponse) {
		try {
			// Parse JSON responses - handle both string and already parsed responses
			var warehouses = typeof warehousesResponse[0] === 'string' ? JSON.parse(warehousesResponse[0]) : warehousesResponse[0];
			var designs = typeof designsResponse[0] === 'string' ? JSON.parse(designsResponse[0]) : designsResponse[0];
			
			// Validate responses
			if (!Array.isArray(warehouses)) {
				safeUnblock("error", "Invalid warehouses data received. Please try again.");
				return;
			}
			
			if (!Array.isArray(designs)) {
				safeUnblock("error", "Invalid designs data received. Please try again.");
				return;
			}
			
			// Store all designs globally
			window.allDesigns = designs || [];
			
			if (!warehouses || warehouses.length === 0) {
				safeUnblock("warning", "No warehouses found for this customer. Please add warehouses in customer details.");
				$("#addToInventoryModal").modal({
					backdrop: 'static',
					keyboard: false,
					show: true
				});
				return;
			}
			
			// Initialize selected designs map and boxes map for each warehouse
			$.each(warehouses, function(index, warehouse) {
				window.selectedDesignsMap[warehouse.id] = [];
				window.designBoxesMap[warehouse.id] = {};
			});
			
			// Create a form for each warehouse
			$.each(warehouses, function(index, warehouse) {
				var isLast = (index === warehouses.length - 1);
				var displayText = warehouse.name;
				if (warehouse.warehouse_number) {
					displayText = warehouse.warehouse_number + ' - ' + displayText;
				}
				if (warehouse.country) {
					displayText += ' (' + warehouse.country + ')';
				}
				
				var formHtml = '<form class="warehouse-form" data-warehouse-id="' + warehouse.id + '" data-warehouse-index="' + index + '" data-warehouse-name="' + displayText.replace(/'/g, "&#39;") + '" style="display: ' + (index === 0 ? 'block' : 'none') + ';">';
				formHtml += '<div class="panel panel-default">';
				formHtml += '<div class="panel-heading"><strong>Warehouse: ' + displayText + '</strong></div>';
				formHtml += '<div class="panel-body">';
				formHtml += '<div class="form-group">';
				formHtml += '<label class="control-label"><strong>Select Designs <span style="color: red;">*</span></strong></label>';
				
				// Custom dropdown with table
				formHtml += '<div class="design-dropdown-wrapper" data-warehouse-id="' + warehouse.id + '">';
				formHtml += '<div class="design-dropdown-toggle form-control" style="cursor: pointer; position: relative; min-height: 38px; padding: 6px 12px;">';
				formHtml += '<span class="design-selected-text" style="color: #999;">Click to select designs...</span>';
				formHtml += '<span class="caret" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%);"></span>';
				formHtml += '</div>';
				formHtml += '<div class="design-dropdown-menu" style="display: none; position: absolute; z-index: 1000; background: white; border: 1px solid #ddd; border-radius: 4px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); max-height: 400px; overflow-y: auto; width: 100%; margin-top: 2px;">';
				formHtml += '<div class="design-table-container">';
				formHtml += '<table class="table table-bordered table-hover design-selection-table" style="margin: 0;">';
				formHtml += '<thead style="background: #f5f5f5; position: sticky; top: 0; z-index: 10;">';
				formHtml += '<tr>';
				formHtml += '<th style="width: 30px; text-align: center;"><input type="checkbox" class="select-all-designs" /></th>';
				formHtml += '<th style="padding: 8px;">Size</th>';
				formHtml += '<th style="padding: 8px;">Finish</th>';
				formHtml += '<th style="padding: 8px;">Design Name</th>';
				formHtml += '<th style="padding: 8px; text-align: right;">Boxes</th>';
				formHtml += '</tr>';
				formHtml += '</thead>';
				formHtml += '<tbody class="design-table-body">';
				formHtml += '</tbody>';
				formHtml += '</table>';
				formHtml += '</div>';
				formHtml += '</div>';
				formHtml += '<input type="hidden" class="design-multiselect" name="designs[]" data-warehouse-id="' + warehouse.id + '" />';
				formHtml += '</div>';
				formHtml += '<small class="help-block">Click on rows to select multiple designs</small>';
				formHtml += '</div>';
				formHtml += '<div class="form-group">';
				formHtml += '<label class="control-label"><strong>Notes (Optional)</strong></label>';
				formHtml += '<textarea class="form-control warehouse-notes" name="warehouse_notes" rows="3" placeholder="Add any notes about this warehouse inventory..." data-warehouse-id="' + warehouse.id + '"></textarea>';
				formHtml += '</div>';
				formHtml += '</div>';
				formHtml += '<div class="panel-footer">';
				
				if (isLast) {
					formHtml += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
					formHtml += '<button type="submit" class="btn btn-primary pull-right">Submit</button>';
				} else {
					formHtml += '<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>';
					formHtml += '<button type="button" class="btn btn-primary pull-right btn-next-warehouse">Next</button>';
				}
				
				formHtml += '</div>';
				formHtml += '</div>';
				formHtml += '</form>';
				
				$("#warehouse_forms_container").append(formHtml);
			});
			
			// Populate design tables
			populateDesignTables();
			
			// Initialize preview
			updateDesignPreview();
			
			// Unblock page
			safeUnblock('', '');
			
			// Open modal
			$("#addToInventoryModal").modal({
				backdrop: 'static',
				keyboard: false,
				show: true
			});
		} catch(e) {
			safeUnblock("error", "An error occurred while loading data. Please try again.");
			console.log("Error parsing response: " + e);
		}
	}).fail(function(jqXHR, textStatus, errorThrown) {
		safeUnblock("error", "An error occurred while loading data. Please try again.");
		console.log("Error: " + textStatus + " - " + errorThrown);
	});
}

// Function to calculate remaining boxes for a design across all warehouses
// Includes: (1) already-saved allocations from DB (design.allocated_boxes), (2) current-session allocations (designBoxesMap)
// If warehouseId is provided, excludes that warehouse's allocation from the calculation
function getRemainingBoxes(designId, excludeWarehouseId) {
	// Get total boxes for this design
	var design = window.allDesigns.find(function(d) {
		return d.id.toString() === designId.toString();
	});
	
	if (!design) {
		return 0;
	}
	
	// Parse boxes from design
	var parts = design.name.split(' - ');
	var boxes = parts.length >= 4 ? parts[3] : (parts.length >= 3 ? parts[2] : (parts.length >= 2 ? parts[1] : '0'));
	if (design.boxes !== undefined) {
		boxes = design.boxes || '0';
	}
	
	var totalBoxes = parseInt(boxes) || 0;
	
	// Start with already-allocated from DB (from previous Add to Inventory saves)
	var allocatedBoxes = parseInt(design.allocated_boxes) || 0;
	
	// Add allocations from current session (other warehouses in this form)
	if (window.designBoxesMap) {
		$.each(window.designBoxesMap, function(warehouseId, designMap) {
			// Skip excluded warehouse (e.g. current warehouse when calculating its max)
			if (excludeWarehouseId && warehouseId.toString() === excludeWarehouseId.toString()) {
				return;
			}
			if (designMap && designMap[designId] !== undefined) {
				allocatedBoxes += parseInt(designMap[designId]) || 0;
			}
		});
	}
	
	// Return remaining boxes (do not show design if fully allocated)
	var remaining = totalBoxes - allocatedBoxes;
	return remaining > 0 ? remaining : 0;
}

// Function to populate design tables
function populateDesignTables() {
	var allSelectedDesignIds = [];
	
	// Collect all selected design IDs from all warehouses
	$.each(window.selectedDesignsMap, function(warehouseId, designIds) {
		allSelectedDesignIds = allSelectedDesignIds.concat(designIds);
	});
	
	// Update each warehouse's table
	$('.design-dropdown-wrapper').each(function() {
		var $wrapper = $(this);
		var warehouseId = $wrapper.data('warehouse-id');
		var currentSelected = window.selectedDesignsMap[warehouseId] || [];
		var $tbody = $wrapper.find('.design-table-body');
		var $hiddenInput = $wrapper.find('.design-multiselect');
		
		// Clear table body
		$tbody.empty();
		
		// Get available designs - filter based on remaining boxes
		var availableDesigns = window.allDesigns.filter(function(design) {
			// Parse boxes from design to check total boxes
			var parts = design.name.split(' - ');
			var boxes = parts.length >= 4 ? parts[3] : (parts.length >= 3 ? parts[2] : (parts.length >= 2 ? parts[1] : '0'));
			if (design.boxes !== undefined) {
				boxes = design.boxes || '0';
			}
			var totalBoxes = parseInt(boxes) || 0;
			
			// Don't show designs with 0 total boxes
			if (totalBoxes === 0) {
				return false;
			}
			
			var remainingBoxes = getRemainingBoxes(design.id);
			var isSelectedInCurrent = currentSelected.indexOf(design.id.toString()) !== -1;
			
			// Show design if:
			// 1. It has remaining boxes > 0, OR
			// 2. It's already selected in current warehouse (even if remaining is 0, to allow editing)
			return remainingBoxes > 0 || isSelectedInCurrent;
		});
		
		if (availableDesigns.length > 0) {
			var allSelectedInView = true;
			$.each(availableDesigns, function(dIndex, design) {
				var isSelected = currentSelected.indexOf(design.id.toString()) !== -1;
				if (!isSelected) {
					allSelectedInView = false;
				}
				
				// Parse design name to extract size, finish, design name, boxes
				var parts = design.name.split(' - ');
				var size = parts.length >= 4 ? parts[0] : '';
				var finish = parts.length >= 4 ? parts[1] : (parts.length >= 3 ? parts[0] : '');
				var designName = parts.length >= 4 ? parts[2] : (parts.length >= 3 ? parts[1] : (parts.length >= 2 ? parts[0] : design.name));
				var boxes = parts.length >= 4 ? parts[3] : (parts.length >= 3 ? parts[2] : (parts.length >= 2 ? parts[1] : '0'));
				
				// If we have separate fields, use them
				if (design.size !== undefined) {
					size = design.size || '';
					finish = design.finish || '';
					designName = design.design_name || design.name;
					boxes = design.boxes || '0';
				}
				
				// Calculate remaining boxes for this design (excluding current warehouse's allocation)
				var remainingBoxes = getRemainingBoxes(design.id, warehouseId);
				
				// Get current allocation in this warehouse
				var currentWarehouseAllocation = 0;
				if (window.designBoxesMap && window.designBoxesMap[warehouseId] && window.designBoxesMap[warehouseId][design.id] !== undefined) {
					currentWarehouseAllocation = parseInt(window.designBoxesMap[warehouseId][design.id]) || 0;
				}
				
				// Max boxes this warehouse can allocate = remaining + current allocation
				var maxBoxesForWarehouse = remainingBoxes + currentWarehouseAllocation;
				
				// Parse total boxes from design
				var totalBoxes = parseInt(boxes) || 0;
				
				// Get custom box quantity if exists, otherwise use max boxes available (remaining boxes)
				var customBoxes = maxBoxesForWarehouse;
				if (window.designBoxesMap && window.designBoxesMap[warehouseId] && window.designBoxesMap[warehouseId][design.id] !== undefined) {
					customBoxes = Math.round(parseInt(window.designBoxesMap[warehouseId][design.id]) || 0);
				}
				
				var currentBoxes = parseInt(customBoxes) || 0;
				
				// Ensure custom boxes doesn't exceed max boxes for this warehouse
				currentBoxes = Math.round(currentBoxes);
				if (currentBoxes > maxBoxesForWarehouse) {
					currentBoxes = maxBoxesForWarehouse;
					customBoxes = maxBoxesForWarehouse;
					// Update the stored value
					if (!window.designBoxesMap[warehouseId]) {
						window.designBoxesMap[warehouseId] = {};
					}
					window.designBoxesMap[warehouseId][design.id] = maxBoxesForWarehouse;
				}
				
				// Disable checkbox and input if no boxes available (0 remaining and not selected)
				var hasNoBoxes = maxBoxesForWarehouse === 0 && !isSelected;
				var isDisabled = hasNoBoxes;
				
				var rowClass = isSelected ? 'selected' : '';
				if (isDisabled) {
					rowClass += ' disabled-row';
				}
				
				var rowHtml = '<tr class="design-table-row ' + rowClass + '" data-design-id="' + design.id + '" data-warehouse-id="' + warehouseId + '" data-original-boxes="' + Math.round(totalBoxes) + '" data-total-boxes="' + Math.round(totalBoxes) + '" data-remaining-boxes="' + remainingBoxes + '" data-max-boxes="' + maxBoxesForWarehouse + '">';
				rowHtml += '<td style="text-align: center;"><input type="checkbox" class="design-checkbox" ' + (isSelected ? 'checked' : '') + (hasNoBoxes ? ' disabled' : '') + ' /></td>';
				rowHtml += '<td>' + (size || '-') + '</td>';
				rowHtml += '<td>' + (finish || '-') + '</td>';
				rowHtml += '<td>' + designName + '</td>';
				rowHtml += '<td style="text-align: right; padding: 4px !important; position: relative;">';
				rowHtml += '<div style="display: inline-block; position: relative;">';
				rowHtml += '<input type="number" class="form-control design-boxes-input" value="' + Math.round(customBoxes) + '" min="0" max="' + maxBoxesForWarehouse + '" step="1" placeholder="Max: ' + maxBoxesForWarehouse + '" style="width: 100px; text-align: right; display: inline-block; margin: 0; padding: 4px 8px; font-size: 13px;" data-design-id="' + design.id + '" data-warehouse-id="' + warehouseId + '" data-total-boxes="' + Math.round(totalBoxes) + '" data-remaining-boxes="' + remainingBoxes + '" data-max-boxes="' + maxBoxesForWarehouse + '" title="Maximum allowed: ' + maxBoxesForWarehouse + ' boxes (Remaining: ' + remainingBoxes + ')" ' + (isDisabled ? 'disabled' : '') + ' />';
				rowHtml += '<small class="boxes-error-message" style="display: none; color: #d9534f; font-size: 11px; position: absolute; right: 0; top: -18px; white-space: nowrap; background: white; padding: 2px 4px; border-radius: 3px; z-index: 1000;">Max: ' + maxBoxesForWarehouse + '</small>';
				rowHtml += '<small class="boxes-max-hint" style="display: block; color: #999; font-size: 10px; margin-top: 2px; text-align: right;">Remaining: ' + remainingBoxes + ' / Total: ' + totalBoxes + '</small>';
				rowHtml += '</div>';
				rowHtml += '</td>';
				rowHtml += '</tr>';
				
				$tbody.append(rowHtml);
			});
			
			// Update select all checkbox state
			var $selectAll = $wrapper.find('.select-all-designs');
			if (availableDesigns.length > 0) {
				$selectAll.prop('checked', allSelectedInView && availableDesigns.length > 0);
			} else {
				$selectAll.prop('checked', false);
			}
			
			// Update hidden input value
			$hiddenInput.val(currentSelected.join(','));
		} else {
			$tbody.append('<tr><td colspan="5" style="text-align: center; padding: 20px; color: #999;">No designs available</td></tr>');
			$wrapper.find('.select-all-designs').prop('checked', false);
		}
		
		// Update toggle text
		updateDesignToggleText(warehouseId);
	});
}

// Function to update design dropdowns based on selected designs
function updateDesignDropdowns() {
	populateDesignTables();
}

// Function to update design preview
function updateDesignPreview() {
	var hasSelections = false;
	var previewHtml = '<div class="table-responsive"><table class="table table-bordered table-striped">';
	previewHtml += '<thead><tr><th style="width: 25%;">Warehouse</th><th style="width: 75%;">Selected Designs</th></tr></thead><tbody>';
	
	$.each(window.selectedDesignsMap, function(warehouseId, designIds) {
		if (designIds && designIds.length > 0) {
			hasSelections = true;
			var warehouseForm = $('.warehouse-form[data-warehouse-id="' + warehouseId + '"]');
			var warehouseName = warehouseForm.data('warehouse-name') || 'Warehouse ' + warehouseId;
			
			// Build table for designs
			var designsTableHtml = '<div style="max-height: 300px; overflow-y: auto; border: 1px solid #ddd; border-radius: 4px;">';
			designsTableHtml += '<table class="table table-bordered table-condensed table-hover" style="margin: 0; font-size: 12px;">';
			designsTableHtml += '<thead style="background-color: #f5f5f5; position: sticky; top: 0; z-index: 10;">';
			designsTableHtml += '<tr>';
			designsTableHtml += '<th style="width: 20%; padding: 6px;">Size</th>';
			designsTableHtml += '<th style="width: 25%; padding: 6px;">Finish</th>';
			designsTableHtml += '<th style="width: 40%; padding: 6px;">Design Name</th>';
			designsTableHtml += '<th style="width: 15%; padding: 6px; text-align: right;">Boxes</th>';
			designsTableHtml += '</tr>';
			designsTableHtml += '</thead>';
			designsTableHtml += '<tbody>';
			
			$.each(designIds, function(index, designId) {
				var design = window.allDesigns.find(function(d) {
					return d.id.toString() === designId.toString();
				});
				if (design) {
					// Parse design details
					var parts = design.name.split(' - ');
					var size = parts.length >= 4 ? parts[0] : '';
					var finish = parts.length >= 4 ? parts[1] : (parts.length >= 3 ? parts[0] : '');
					var designName = parts.length >= 4 ? parts[2] : (parts.length >= 3 ? parts[1] : (parts.length >= 2 ? parts[0] : design.name));
					var boxes = parts.length >= 4 ? parts[3] : (parts.length >= 3 ? parts[2] : (parts.length >= 2 ? parts[1] : '0'));
					
					// Use separate fields if available
					if (design.size !== undefined) {
						size = design.size || '';
						finish = design.finish || '';
						designName = design.design_name || design.name;
						boxes = design.boxes || '0';
					}
					
					// Get allocated boxes for this warehouse (from designBoxesMap, or fallback to input value)
					var allocatedBoxes = 0;
					if (window.designBoxesMap && window.designBoxesMap[warehouseId] && window.designBoxesMap[warehouseId][designId] !== undefined) {
						allocatedBoxes = parseInt(window.designBoxesMap[warehouseId][designId]) || 0;
					}
					if (allocatedBoxes === 0) {
						// Fallback: read from input in case designBoxesMap not yet initialized
						var $row = $('.design-table-row[data-design-id="' + designId + '"][data-warehouse-id="' + warehouseId + '"]');
						if ($row.length) {
							var $input = $row.find('.design-boxes-input');
							allocatedBoxes = parseInt($input.val()) || parseInt($row.data('max-boxes')) || 0;
						}
					}
					
					designsTableHtml += '<tr>';
					designsTableHtml += '<td style="padding: 6px;">' + (size || '-') + '</td>';
					designsTableHtml += '<td style="padding: 6px;">' + (finish || '-') + '</td>';
					designsTableHtml += '<td style="padding: 6px;">' + designName + '</td>';
					designsTableHtml += '<td style="padding: 6px; text-align: right; font-weight: 600;">' + allocatedBoxes + '</td>';
					designsTableHtml += '</tr>';
				}
			});
			
			designsTableHtml += '</tbody>';
			designsTableHtml += '</table>';
			designsTableHtml += '</div>';
			
			previewHtml += '<tr>';
			previewHtml += '<td style="vertical-align: top;"><strong>' + warehouseName + '</strong></td>';
			previewHtml += '<td style="vertical-align: top; padding: 10px;">' + designsTableHtml + '</td>';
			previewHtml += '</tr>';
		}
	});
	
	previewHtml += '</tbody></table></div>';
	
	if (hasSelections) {
		$("#design_preview_content").html(previewHtml);
		$("#design_preview_container").show();
	} else {
		$("#design_preview_container").hide();
	}
}

// Function to update design toggle text
function updateDesignToggleText(warehouseId) {
	var $wrapper = $('.design-dropdown-wrapper[data-warehouse-id="' + warehouseId + '"]');
	var selectedDesigns = window.selectedDesignsMap[warehouseId] || [];
	var $toggleText = $wrapper.find('.design-selected-text');
	
	if (selectedDesigns.length > 0) {
		$toggleText.html('<span class="design-selected-count">' + selectedDesigns.length + ' design(s) selected</span>');
		$toggleText.css('color', '#333');
	} else {
		$toggleText.html('Click to select designs...');
		$toggleText.css('color', '#999');
	}
}

// Handle dropdown toggle click
$(document).on('click', '.design-dropdown-toggle', function(e) {
	e.stopPropagation();
	var $wrapper = $(this).closest('.design-dropdown-wrapper');
	var $menu = $wrapper.find('.design-dropdown-menu');
	
	// Close all other dropdowns
	$('.design-dropdown-menu').not($menu).hide();
	
	// Toggle current dropdown
	$menu.toggle();
});

// Close dropdown when clicking outside
$(document).on('click', function(e) {
	if (!$(e.target).closest('.design-dropdown-wrapper').length) {
		$('.design-dropdown-menu').hide();
	}
});

// Handle table row click
$(document).on('click', '.design-table-row', function(e) {
	if ($(e.target).is('input[type="checkbox"]') || $(e.target).is('input[type="number"]') || $(e.target).closest('input[type="number"]').length) {
		return; // Let checkbox and input handle their own clicks
	}
	
	var $row = $(this);
	var designId = $row.data('design-id').toString();
	var warehouseId = $row.data('warehouse-id');
	var $checkbox = $row.find('.design-checkbox');
	var maxBoxes = parseInt($row.data('max-boxes')) || 0;
	
	// Check if checkbox is disabled or if max boxes is 0
	if ($checkbox.prop('disabled') || (maxBoxes === 0 && !$checkbox.prop('checked'))) {
		return; // Don't allow selection if no boxes available
	}
	
	// Toggle checkbox
	$checkbox.prop('checked', !$checkbox.prop('checked'));
	
	// Update selection
	var selectedDesigns = window.selectedDesignsMap[warehouseId] || [];
	var index = selectedDesigns.indexOf(designId);
	
	if ($checkbox.prop('checked')) {
		if (index === -1) {
			selectedDesigns.push(designId);
		}
		$row.addClass('selected');
		// Initialize designBoxesMap with input value so preview shows correct count (not 0)
		var $input = $row.find('.design-boxes-input');
		var inputVal = $input.length ? (parseInt($input.val()) || parseInt($row.data('max-boxes')) || maxBoxes) : maxBoxes;
		if (inputVal > 0) {
			if (!window.designBoxesMap[warehouseId]) window.designBoxesMap[warehouseId] = {};
			window.designBoxesMap[warehouseId][designId] = inputVal;
		}
		} else {
			if (index !== -1) {
				selectedDesigns.splice(index, 1);
			}
			$row.removeClass('selected');
			
			// Clear boxes input when deselected (but don't remove from map yet, let user decide)
			var $input = $row.find('.design-boxes-input');
			if ($input.length > 0) {
				$input.val(0);
			}
			
			// Remove boxes allocation when deselected
			if (window.designBoxesMap && window.designBoxesMap[warehouseId] && window.designBoxesMap[warehouseId][designId] !== undefined) {
				delete window.designBoxesMap[warehouseId][designId];
			}
		}
	
	window.selectedDesignsMap[warehouseId] = selectedDesigns;
	
	// Update hidden input
	var $hiddenInput = $row.closest('.design-dropdown-wrapper').find('.design-multiselect');
	$hiddenInput.val(selectedDesigns.join(','));
	
	// Update toggle text
	updateDesignToggleText(warehouseId);
	
	// Refresh all dropdowns to update remaining boxes
	setTimeout(function() {
		populateDesignTables();
		updateDesignPreview();
	}, 100);
});

// Handle checkbox click directly
$(document).on('click', '.design-checkbox', function(e) {
	e.stopPropagation();
	var $checkbox = $(this);
	var $row = $checkbox.closest('.design-table-row');
	var designId = $row.data('design-id').toString();
	var warehouseId = $row.data('warehouse-id');
	var maxBoxes = parseInt($row.data('max-boxes')) || 0;
	
	// Check if checkbox is disabled or if max boxes is 0 and trying to check
	if ($checkbox.prop('disabled') || (maxBoxes === 0 && $checkbox.prop('checked'))) {
		$checkbox.prop('checked', false);
		return; // Don't allow selection if no boxes available
	}
	
	var selectedDesigns = window.selectedDesignsMap[warehouseId] || [];
	var index = selectedDesigns.indexOf(designId);
	
	if ($checkbox.prop('checked')) {
		if (index === -1) {
			selectedDesigns.push(designId);
		}
		$row.addClass('selected');
		// Initialize designBoxesMap with input value so preview shows correct count (not 0)
		var $input = $row.find('.design-boxes-input');
		var inputVal = $input.length ? (parseInt($input.val()) || parseInt($row.data('max-boxes')) || maxBoxes) : maxBoxes;
		if (inputVal > 0) {
			if (!window.designBoxesMap[warehouseId]) window.designBoxesMap[warehouseId] = {};
			window.designBoxesMap[warehouseId][designId] = inputVal;
		}
		} else {
			if (index !== -1) {
				selectedDesigns.splice(index, 1);
			}
			$row.removeClass('selected');
			
			// Clear boxes input when deselected (but don't remove from map yet, let user decide)
			var $input = $row.find('.design-boxes-input');
			if ($input.length > 0) {
				$input.val(0);
			}
			
			// Remove boxes allocation when deselected
			if (window.designBoxesMap && window.designBoxesMap[warehouseId] && window.designBoxesMap[warehouseId][designId] !== undefined) {
				delete window.designBoxesMap[warehouseId][designId];
			}
		}
	
	window.selectedDesignsMap[warehouseId] = selectedDesigns;
	
	// Update hidden input
	var $hiddenInput = $row.closest('.design-dropdown-wrapper').find('.design-multiselect');
	$hiddenInput.val(selectedDesigns.join(','));
	
	// Update toggle text
	updateDesignToggleText(warehouseId);
	
	// Refresh all dropdowns to update remaining boxes
	setTimeout(function() {
		populateDesignTables();
		updateDesignPreview();
	}, 100);
});

// Handle select all checkbox
$(document).on('click', '.select-all-designs', function(e) {
	e.stopPropagation();
	var $checkbox = $(this);
	var $wrapper = $(this).closest('.design-dropdown-wrapper');
	var warehouseId = $wrapper.data('warehouse-id');
	// Only select enabled rows with boxes > 0
	var $rows = $wrapper.find('.design-table-row').filter(function() {
		var $row = $(this);
		var $cb = $row.find('.design-checkbox');
		var maxBoxes = parseInt($row.data('max-boxes')) || 0;
		return !$cb.prop('disabled') && maxBoxes > 0;
	});
	var selectedDesigns = window.selectedDesignsMap[warehouseId] || [];
	
	if ($checkbox.prop('checked')) {
		$rows.each(function() {
			var $row = $(this);
			var designId = $row.data('design-id').toString();
			var maxBoxes = parseInt($row.data('max-boxes')) || 0;
			// Only select if boxes > 0
			if (maxBoxes > 0 && selectedDesigns.indexOf(designId) === -1) {
				selectedDesigns.push(designId);
			}
			$row.find('.design-checkbox').prop('checked', true);
			$row.addClass('selected');
			// Initialize designBoxesMap with input value so preview shows correct count
			var $input = $row.find('.design-boxes-input');
			var inputVal = $input.length ? (parseInt($input.val()) || maxBoxes) : maxBoxes;
			if (inputVal > 0) {
				if (!window.designBoxesMap[warehouseId]) window.designBoxesMap[warehouseId] = {};
				window.designBoxesMap[warehouseId][designId] = inputVal;
			}
		});
	} else {
		$rows.each(function() {
			var $row = $(this);
			var designId = $row.data('design-id').toString();
			var index = selectedDesigns.indexOf(designId);
			if (index !== -1) {
				selectedDesigns.splice(index, 1);
			}
			$row.find('.design-checkbox').prop('checked', false);
			$row.removeClass('selected');
			
			// Remove boxes allocation when deselected
			if (window.designBoxesMap && window.designBoxesMap[warehouseId] && window.designBoxesMap[warehouseId][designId] !== undefined) {
				delete window.designBoxesMap[warehouseId][designId];
			}
		});
	}
	
	window.selectedDesignsMap[warehouseId] = selectedDesigns;
	
	// Update hidden input
	var $hiddenInput = $wrapper.find('.design-multiselect');
	$hiddenInput.val(selectedDesigns.join(','));
	
	// Update toggle text
	updateDesignToggleText(warehouseId);
	
	// Refresh all dropdowns to update remaining boxes
	setTimeout(function() {
		populateDesignTables();
		updateDesignPreview();
	}, 100);
});

// Handle boxes input change
$(document).on('change blur input', '.design-boxes-input', function(e) {
	e.stopPropagation();
	var $input = $(this);
	var $row = $input.closest('.design-table-row');
	var designId = $input.data('design-id').toString();
	var warehouseId = $input.data('warehouse-id');
				// Get max boxes for this warehouse (remaining + current allocation)
				var maxBoxes = parseInt($input.data('max-boxes')) || parseInt($row.data('max-boxes')) || 0;
				var remainingBoxes = parseInt($input.data('remaining-boxes')) || parseInt($row.data('remaining-boxes')) || 0;
				var currentAllocated = 0;
				if (window.designBoxesMap && window.designBoxesMap[warehouseId] && window.designBoxesMap[warehouseId][designId] !== undefined) {
					currentAllocated = parseInt(window.designBoxesMap[warehouseId][designId]) || 0;
				}
				
				var boxesValue = Math.round(parseFloat($input.val()) || 0);
				var $errorMsg = $row.find('.boxes-error-message');
				
				// Remove previous error styling
				$input.removeClass('has-error');
				$errorMsg.hide();
				
				// Ensure non-negative and integer
				if (boxesValue < 0 || isNaN(boxesValue)) {
					boxesValue = 0;
					$input.val(0);
				} else {
					// Round to integer and update input value
					boxesValue = Math.round(boxesValue);
					$input.val(boxesValue);
				}
				
				// Initialize boxes map if needed
				if (!window.designBoxesMap[warehouseId]) {
					window.designBoxesMap[warehouseId] = {};
				}
				
				// Store the new value temporarily to recalculate remaining boxes correctly
				var oldValue = window.designBoxesMap[warehouseId][designId] || 0;
				if (boxesValue > 0) {
					window.designBoxesMap[warehouseId][designId] = boxesValue;
				} else {
					// Remove from map if 0
					if (window.designBoxesMap[warehouseId][designId] !== undefined) {
						delete window.designBoxesMap[warehouseId][designId];
					}
				}
				
				// Recalculate max boxes AFTER storing new value (remaining + current allocation)
				var newRemaining = getRemainingBoxes(designId, warehouseId);
				var newCurrentAllocated = boxesValue;
				var newMaxBoxes = newRemaining + newCurrentAllocated;
				
				// Validate: boxes cannot exceed max boxes
				if (boxesValue > newMaxBoxes) {
					// Restore old value if validation fails
					if (oldValue > 0) {
						window.designBoxesMap[warehouseId][designId] = oldValue;
					} else {
						delete window.designBoxesMap[warehouseId][designId];
					}
					
					boxesValue = newMaxBoxes;
					$input.val(newMaxBoxes);
					$input.addClass('has-error');
					$errorMsg.text('Maximum allowed: ' + newMaxBoxes + ' boxes').show();
					
					// Show error for 3 seconds then hide
					setTimeout(function() {
						$input.removeClass('has-error');
						$errorMsg.fadeOut();
					}, 3000);
					
					// Store corrected value
					if (boxesValue > 0) {
						window.designBoxesMap[warehouseId][designId] = boxesValue;
					}
				}
				
				// Update the row's data attribute for reference
				$row.attr('data-custom-boxes', boxesValue);
				
				// Refresh all warehouse tables to update remaining boxes
				setTimeout(function() {
					populateDesignTables();
					updateDesignPreview();
				}, 100);
});

// Prevent row click when clicking on input
$(document).on('click', '.design-boxes-input', function(e) {
	e.stopPropagation();
});

// Handle Next button click - move to next warehouse form
$(document).on('click', '.btn-next-warehouse', function() {
	var currentForm = $(this).closest('.warehouse-form');
	var currentIndex = parseInt(currentForm.data('warehouse-index'));
	var nextForm = $('.warehouse-form[data-warehouse-index="' + (currentIndex + 1) + '"]');
	
	// Validate current form
	if (!currentForm[0].checkValidity()) {
		currentForm[0].reportValidity();
		return false;
	}
	
	// Validate boxes values for current warehouse
	var currentWarehouseId = currentForm.data('warehouse-id');
	var selectedValue = currentForm.find('.design-multiselect').val() || '';
	var currentSelected = selectedValue ? selectedValue.split(',') : [];
	
	// Check if any designs are selected
	if (currentSelected.length === 0) {
		alert("Please select at least one design before proceeding.");
		currentForm.find('.design-dropdown-toggle').click();
		return false;
	}
	
	// Check if any boxes exceed max or are 0
	var hasInvalidBoxes = false;
	var invalidDesigns = [];
	$.each(currentSelected, function(index, designId) {
		var $row = currentForm.find('.design-table-row[data-design-id="' + designId + '"]');
		if ($row.length > 0) {
			var $input = $row.find('.design-boxes-input');
			var maxBoxes = parseInt($input.data('max-boxes')) || parseInt($row.data('max-boxes')) || 0;
			var enteredBoxes = parseInt($input.val()) || 0;
			
			if (enteredBoxes === 0) {
				hasInvalidBoxes = true;
				var designName = $row.find('td').eq(3).text() || 'Design';
				invalidDesigns.push(designName + ' (Boxes: 0 - Please enter box quantity)');
				
				// Highlight the input
				$input.addClass('has-error');
				$row.find('.boxes-error-message').text('Please enter box quantity').show();
			} else if (enteredBoxes > maxBoxes) {
				hasInvalidBoxes = true;
				var designName = $row.find('td').eq(3).text() || 'Design';
				invalidDesigns.push(designName + ' (Max: ' + maxBoxes + ')');
				
				// Highlight the input
				$input.addClass('has-error');
				$row.find('.boxes-error-message').text('Maximum allowed: ' + maxBoxes).show();
			}
		}
	});
	
	if (hasInvalidBoxes) {
		var errorMsg = "Please fix the following issues:\n\n" + invalidDesigns.join('\n');
		alert(errorMsg);
		// Open the dropdown to show the user
		currentForm.find('.design-dropdown-toggle').click();
		return false;
	}
	
	window.selectedDesignsMap[currentWarehouseId] = currentSelected;
	
	// Update dropdowns before showing next form
	updateDesignDropdowns();
	
	// Hide current form and show next
	currentForm.hide();
	nextForm.show();
	$("#current_warehouse_index").val(currentIndex + 1);
	
	// Update preview
	updateDesignPreview();
});

// Handle warehouse form submission
$(document).on('submit', '.warehouse-form', function(event) {
	event.preventDefault();
	
	var form = $(this);
	
	var warehouse_id = form.data('warehouse-id');
	var selected_designs_value = form.find('.design-multiselect').val() || '';
	var selected_designs = selected_designs_value ? selected_designs_value.split(',') : [];
	var performa_invoice_id = $("#add_to_inventory_performa_invoice_id").val();
	
	// Validate that at least one design is selected
	if (!selected_designs || selected_designs.length === 0) {
		alert("Please select at least one design.");
		// Open the dropdown to show the user
		form.find('.design-dropdown-toggle').click();
		return false;
	}
	
	// Validate that selected designs have boxes > 0
	var hasZeroBoxes = false;
	var zeroBoxDesigns = [];
	$.each(selected_designs, function(index, designId) {
		var $row = form.find('.design-table-row[data-design-id="' + designId + '"]');
		if ($row.length > 0) {
			var $input = $row.find('.design-boxes-input');
			var enteredBoxes = parseInt($input.val()) || 0;
			if (enteredBoxes === 0) {
				hasZeroBoxes = true;
				var designName = $row.find('td').eq(3).text() || 'Design';
				zeroBoxDesigns.push(designName);
			}
		}
	});
	
	if (hasZeroBoxes) {
		var errorMsg = "Some selected designs have 0 boxes allocated. Please enter box quantities:\n\n" + zeroBoxDesigns.join('\n');
		alert(errorMsg);
		form.find('.design-dropdown-toggle').click();
		return false;
	}
	
	// Validate boxes values - ensure none exceed total boxes
	var hasInvalidBoxes = false;
	var invalidDesigns = [];
	$('.warehouse-form').each(function() {
		var wForm = $(this);
		var wId = wForm.data('warehouse-id');
		var wDesignsValue = wForm.find('.design-multiselect').val() || '';
		var wDesigns = wDesignsValue ? wDesignsValue.split(',') : [];
		
		$.each(wDesigns, function(index, designId) {
			var $row = wForm.find('.design-table-row[data-design-id="' + designId + '"]');
			if ($row.length > 0) {
				var $input = $row.find('.design-boxes-input');
				var maxBoxes = parseInt($input.data('max-boxes')) || parseInt($row.data('max-boxes')) || 0;
				var enteredBoxes = parseInt($input.val()) || 0;
				
				if (enteredBoxes > maxBoxes) {
					hasInvalidBoxes = true;
					// Get design name for error message
					var designName = $row.find('td').eq(3).text() || 'Design';
					invalidDesigns.push(designName + ' (Max: ' + maxBoxes + ')');
					
					// Highlight the input
					$input.addClass('has-error');
					$row.find('.boxes-error-message').text('Maximum allowed: ' + maxBoxes).show();
				}
			}
		});
	});
	
	if (hasInvalidBoxes) {
		var errorMsg = "Some designs have box quantities exceeding the maximum allowed:\n\n" + invalidDesigns.join('\n');
		alert(errorMsg);
		// Open the dropdown to show the user
		form.find('.design-dropdown-toggle').click();
		return false;
	}
	
	if (!form[0].checkValidity()) {
		form[0].reportValidity();
		return false;
	}
	
	// Collect all warehouse data
	var allWarehouseData = [];
	$('.warehouse-form').each(function() {
		var wForm = $(this);
		var wId = wForm.data('warehouse-id');
		var wDesignsValue = wForm.find('.design-multiselect').val() || '';
		var wDesigns = wDesignsValue ? wDesignsValue.split(',') : [];
		var wNotes = wForm.find('.warehouse-notes').val() || '';
		if (wDesigns && wDesigns.length > 0) {
			// Collect design data with custom box quantities
			var designData = [];
			$.each(wDesigns, function(index, designId) {
				var designInfo = {
					design_id: designId,
					quantity: null // Will be set below
				};
				
				// Get custom box quantity from input field or designBoxesMap
				var $row = wForm.find('.design-table-row[data-design-id="' + designId + '"]');
				var enteredBoxes = 0;
				
				if ($row.length > 0) {
					var $input = $row.find('.design-boxes-input');
					enteredBoxes = parseInt($input.val()) || 0;
				}
				
				// Use entered boxes from input, or from designBoxesMap, or 0
				if (enteredBoxes > 0) {
					designInfo.quantity = enteredBoxes;
				} else if (window.designBoxesMap && window.designBoxesMap[wId] && window.designBoxesMap[wId][designId]) {
					designInfo.quantity = parseInt(window.designBoxesMap[wId][designId]) || 0;
				} else {
					designInfo.quantity = 0;
				}
				
				designData.push(designInfo);
			});
			
			allWarehouseData.push({
				warehouse_id: wId,
				designs: wDesigns,
				design_data: designData, // Include design data with quantities
				notes: wNotes
			});
		}
	});
	
	if (allWarehouseData.length === 0) {
		safeUnblock("error", "Please select at least one design in at least one warehouse.");
		return false;
	}
	
	// Save inventory data to backend
	safeBlock();
	
	$.ajax({
		type: "POST",
		url: root + 'assign_producation/save_inventory',
		data: {
			"performa_invoice_id": performa_invoice_id,
			"warehouse_data": JSON.stringify(allWarehouseData)
		},
		cache: false,
		success: function(responseData) {
			try {
				var obj = JSON.parse(responseData);
				if(obj.res == 1) {
					safeUnblock("success", obj.msg || "Inventory data saved successfully.");
					$("#addToInventoryModal").modal('hide');
					$("#warehouse_forms_container").empty();
					$("#design_preview_container").hide();
					$("#design_preview_content").empty();
					// Reload page after 1 second to reflect changes
					setTimeout(function() {
						window.location.reload();
					}, 1000);
				} else {
					safeUnblock("error", obj.msg || "Something went wrong. Please try again.");
				}
			} catch(e) {
				safeUnblock("error", "An error occurred while processing the response. Please try again.");
				console.log("Error parsing response: " + e);
			}
		},
		error: function(jqXHR, textStatus, errorThrown) {
			safeUnblock("error", "An error occurred. Please try again.");
			console.log("Error: " + textStatus + " - " + errorThrown);
		}
	});
});
//load_data_table()
// function load_data_table()
// {
//  	block_page(); 	
// 	$(".view_report").html('')	
// 	$.ajax({          
// 		type: "POST",          
// 		url: root+'producation_detail/all_confirm_performa',         
// 		data: {          
// 			"customer_id" : $("#customer_id").val(), 
// 			"date" 		  : $("#daterange").val() 
// 		}, 		
// 		cache: false, 		
// 		success: function (data) { 			
// 			$(".view_report").html(data);
// 			$(".tooltips").tooltip()
// 			unblock_page("","")		
// 		}	
// 	});
// }
function load_data_table() {
    var rows_selected = [];
    datatable = $("#datatable").dataTable({
        "bAutoWidth": false,
        "bFilter": true,
        "bSort": true,
        "aaSorting": [[0]],
        "aoColumns": [
            { "bSortable": false },  // 0: Sr No
            { "bSortable": false },  // 1: PO No
            { "bSortable": false },  // 2: PI No
            { "bSortable": true },   // 3: PI Date
            { "bSortable": true },   // 4: Consignee
            { "bSortable": true },   // 5: No of Container
            { "bSortable": true },   // 6: Production Done
            { "bSortable": true },   // 7: Pending Loading
            { "bSortable": true },   // 8: Loading Done
            { "bSortable": true },   // 9: Ready Export
            { "bSortable": false },  // 10: Export Done
            { "bSortable": true },   // 11: Way Date
            { "bSortable": true },   // 12: Estimated Arrival Date
            { "bSortable": false }   // 13: Action
        ],

        "columnDefs": [
            { "targets": 0, "width": "3%", "className": "text-center" },  // Sr No
            { "targets": 1, "width": "8%", "className": "text-center" }, // PO No
            { "targets": 2, "width": "8%", "className": "text-center" }, // PI No
            { "targets": 3, "width": "7%", "className": "text-center" }, // PI Date
            { "targets": 4, "width": "12%", "className": "text-left" }, // Consignee
            { "targets": 5, "width": "6%", "className": "text-center" }, // No of Container
            { "targets": 6, "width": "7%", "className": "text-center" }, // Production Done
            { "targets": 7, "width": "6%", "className": "text-center" }, // Pending Loading
            { "targets": 8, "width": "6%", "className": "text-center" }, // Loading Done
            { "targets": 9, "width": "6%", "className": "text-center" }, // Ready Export
            { "targets": 10, "width": "6%", "className": "text-center" }, // Export Done
            { "targets": 11, "width": "7%", "className": "text-center", "sType": "date" }, // Way Date
            { "targets": 12, "width": "7%", "className": "text-center", "sType": "date" }, // Estimated Arrival Date
            { "targets": 13, "width": "7%", "className": "text-center" } // Action
        ],

        "searchDelay": 350,
        "bServerSide": true,
        "bDestroy": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_",
            "sEmptyTable": "NO DATA ADDED YET !",
            "sSearch": "",
            "sInfoFiltered": ""
        },
        "lengthMenu": [[10, 20, 30, 50, -1], [10, 20, 30, 50, "All"]],
        "pageLength": 10,

        dom: 'Blfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf-o"></i>',
            orientation: 'landscape',
            pageSize: 'A4',
            titleAttr: 'PDF',
            title: 'Loading Plan',
            customize: function (doc) {
                doc.content[1].table.body.forEach(function (row) {
                    row.splice(-1, 1);
                    row.splice(1, 1);
                });
            }
        }],

        "sAjaxSource": root + 'assign_producation/fetch_record/',
        "fnServerParams": function (aoData) {
            aoData.push(
                { "name": "mode", "value": "fetch" },
                { "name": "customer_id", "value": $("#customer_id").val() },
                { "name": "date", "value": $("#daterange").val() }
            );
        },

        "fnDrawCallback": function (oSettings) {
            $('.ttip, [data-toggle="tooltip"]').tooltip();
            var productionmst_id = $("#production_mst_id").val().split(",");
            for (var i = 0; i < productionmst_id.length; i++) {
                $("#allproduction_mst_id" + productionmst_id[i]).prop("checked", true);
            }
            $(this).DataTable().processing(false);
        }
    });

    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
}


function cb(start, end) {
        $('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
    }
    cb(moment().subtract(29, 'days'), moment());
	 
$('#daterange').daterangepicker({       
 			locale: {
				format: 'DD-MM-YYYY'
			},
		"autoApply": true,	
		"startDate": $('#s_date').val(),
		"endDate": $('#e_date').val(),	
	    ranges: {
			'All': ['01-01-1970',$('#e_date').val()],
			'Today': [moment(), moment()],
			'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
			'Last 7 Days': [moment().subtract(6, 'days'), moment()],
			'Last 30 Days': [moment().subtract(29, 'days'), moment()],
			'This Month': [moment().startOf('month'), moment().endOf('month')],
			'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
			'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')],
			'This Year': [moment().startOf('year'), moment().endOf('year')]
        }
    }, cb); 
 
 
 function create_export_invoice()
{
	var performa_invoice_id = [];
	$. each($("input[name='all_performa_invoice[]']:checked"), function(){
		performa_invoice_id. push($(this). val());
	});
	if(performa_invoice_id.length < 2)
	{
		toastr["error"]("Please select atleast 2 invoice.")
	}
	else
	{
		$.ajax({ 
				type	: "POST", 
				url		: root+"invoice_listing/copy_mutiple_invoice",
				data	: {
							"performa_invoice_id": performa_invoice_id 
						  }, 
				cache	: false, 
				success	: function(data) 
				{ 
					var obj = JSON.parse(data);
					 
					if(obj.res==1)
					{
						window.location=root+'exportinvoice/mutiplecopy/'+performa_invoice_id.toString().replace(/,/g,"-");
					}
					else
					{
						toastr["error"]("Consignee name are different. Allow only for same consignee.")
					}
				}
			}); 
	}
}
</script>
 