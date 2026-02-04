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
    <div class="modal-dialog modal-md">
        <div class="modal-content add-to-inventory-modal">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add to Inventory</h4>
            </div>
            <form id="add_to_inventory_form" action="javascript:;" method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="inventory_warehouse">
                            <strong>Select Warehouse</strong>
                        </label>
                        <div class="radio-group" style="margin-top: 10px;">
                            <label class="radio-inline" style="margin-right: 20px;">
                                <input type="radio" name="inventory_warehouse" value="Warehouse1"> Warehouse1
                            </label>
                            <label class="radio-inline" style="margin-right: 20px;">
                                <input type="radio" name="inventory_warehouse" value="Warehouse2"> Warehouse2
                            </label>
                            <label class="radio-inline">
                                <input type="radio" name="inventory_warehouse" value="Warehouse3" checked> Warehouse3
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="inventory_date">
                            <strong>Inventory Date</strong>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                            </span>
                            <input type="text" placeholder="dd-mm-yyyy" id="inventory_date" name="inventory_date" class="form-control inventory-date-picker" value="">
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="control-label" for="inventory_notes">
                            <strong>Notes (Optional)</strong>
                        </label>
                        <textarea id="inventory_notes" name="inventory_notes" class="form-control" rows="4" placeholder="Add any notes about this inventory addition..."></textarea>
                    </div>
                    
                    <input type="hidden" id="add_to_inventory_performa_invoice_id" name="performa_invoice_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add to Inventory</button>
                </div>
            </form>
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
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

#addToInventoryModal .modal-header {
    border-bottom: 1px solid #eee;
    padding: 15px 20px;
}

#addToInventoryModal .modal-title {
    font-size: 18px;
    font-weight: 600;
}

#addToInventoryModal .modal-body {
    padding: 20px 25px;
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
}

#addToInventoryModal .btn-primary {
    padding: 8px 20px;
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
	$("#add_to_inventory_form")[0].reset();
	$("input[name='inventory_warehouse'][value='Warehouse3']").prop("checked", true);
	
	$('#inventory_date').datepicker({
		autoclose: true,
		format: 'dd-mm-yyyy',
		orientation: 'bottom auto',
		todayHighlight: true
	});
	
	$("#addToInventoryModal").modal({
		backdrop: 'static',
		keyboard: false,
		show: true
	});
}

// Handle Add to Inventory form submission (design only - no backend)
$("#add_to_inventory_form").submit(function(event) {
	event.preventDefault();
	var warehouse = $("input[name='inventory_warehouse']:checked").val();
	var inventory_date = $("#inventory_date").val();
	var notes = $("#inventory_notes").val();
	// Design only: just close modal
	$("#addToInventoryModal").modal('hide');
	$("#add_to_inventory_form")[0].reset();
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
 