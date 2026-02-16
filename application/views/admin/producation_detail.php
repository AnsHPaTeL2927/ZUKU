<?php 
$this->view('lib/header'); 
?>	
<script>
function view_pdf(no)
{
	window.open(root+"producation_detail/view_pdf", '_blank');
}
</script>	 
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
			 				<a href="<?=base_url().'producation_detail'?>">Producation List</a>
			 			</li>
			 	 	</ol>
			 		<div class="page-header title1">
			 			<h3>
							Producation Detail
							<div class="pull-right form-group">
								<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="downloadPDF();"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
							</div>
					 	</h3>
				 	</div>
				 </div>
			 </div>
			 <?php if (!empty($production_reminder_count) && $production_reminder_count > 0): ?>
			 <div class="row">
			 	<div class="col-sm-12">
			 		<div class="alert alert-warning alert-dismissible" role="alert" style="margin-bottom: 15px;">
			 			<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span></button>
			 			<strong><i class="fa fa-bell"></i> Production Reminder:</strong> <?=$production_reminder_count?> production sheet(s) will be delivered in exactly <strong><?=isset($production_reminder_days) ? (int)$production_reminder_days : 2?></strong> day(s) (based on PSC estimated date). Please review.
			 		</div>
			 	</div>
			 </div>
			 <?php endif; ?>
			 <div class="row">
			 	<div class="col-sm-12">
			 		<div class="panel panel-default">
			 			<div class="panel-heading">
			 				<i class="fa fa-external-link-square"></i>
			 		 	</div>
                         <div class="">
			 			   <div class="panel-body form-body">
										<div class="panel-body" style="padding-left:0px;">
									 
										<div class="col-md-4">
										<label class="col-md-4 control-label" style="margin-top:5px;"><strong class=""> Producation Date</strong></label>
										 <div class="col-md-8">
										<?php 
											$year = date('n') > 3 ? date('01-04-Y').' - '.(date('31-03-Y',strtotime("+1 year"))) : (date('01-04-Y',strtotime("-1 year"))).' - '.date('31-03-Y');
											
											$invoicedate = explode(" - ",$year);
											$start_date = $invoicedate[0];
											$end_date 	= $invoicedate[1];
											if(!empty($_SESSION['po_s_date']))
											{
												$start_date = $_SESSION['po_s_date'];
											}
											if(!empty($_SESSION['po_e_date']))
											{
												$end_date = $_SESSION['po_e_date'];
											}
									 	 ?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$start_date?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$end_date?>">
										 </div>     
									</div>
									
										<div class="col-md-4">
											<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select Consignee</strong></label>
											 <div class="col-md-7">
											<select class="select2" name="cust_id" id="cust_id"   title="Enter Consignee" onchange="load_data()" >
												<option value="">All Consignee</option>
													<?php 
													foreach($consign_data as $company_row)
													{
														 
														$cust_name = (!empty($company_row->c_nick_name))?$company_row->c_nick_name:$company_row->c_companyname;  
														$sel ='';
														 if($company_row->id == $_SESSION['po_cust_id'])
														 {
															 $sel ='selected="selected"';
														 }
														echo "<option ".$sel." value='".$company_row->id."'>".$cust_name."</option>";
													}
													?>
											</select>
											 </div>     
										</div>
									
									<div class="col-md-4">
										<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select Suppier</strong></label>									
										<div class="col-md-7">
											<select class="select2" name="supplierdata" id="supplierdata" required title="Select Supplier" onchange="load_data()" >
												<option value="">All Supplier</option>
												<?php
												for($p=0;$p<count($supplier_data);$p++)
												{
														$sel = '';
														if($supplier_data[$p]->production_mst_id == $_SESSION['get_supplierdata'])
														{
															$sel = 'selected="selected"';
														}
													echo "<option ".$sel." value='".$supplier_data[$p]->supplier_id."'>".$supplier_data[$p]->company_name." </option>";
												}
												?>
												
											</select>
										</div>	
									</div>
										
								</div>
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
													<th>Sr no</th>
													<th>
														<button class="btn btn-info tooltips" data-toggle="tooltip" data-title="PO" onclick="create_po()"> + PO</button>
													</th>
													<th>Producation no</th>
													<th>PO Date</th>
													<th>PI No</th>
													<th>Consigne name</th>
													<th>Suppier Name</th>
													<th>No Of Container</th>
											 		
													
													<th>
													 
															<input type="checkbox"   name="qcproduction_mst_id" id="qcproduction_mst_id" value="" onclick="click_all_production(this.checked)"    />   
														 
															 <a  class="btn btn-info tooltips" data-toggle="tooltip" data-title="Production Done" href="javascript:;" onclick="peform_action1(3)">    
															  Production </a> 
													 
													</th>	
													
													<th>
													 
															<input type="checkbox"   name="qcproduction_mst_id" id="qcproduction_mst_id" value="" onclick="click_all(this.checked)"    />   
														 
															 <a  class="btn btn-info tooltips" data-toggle="tooltip" data-title="QC Done" href="javascript:;" onclick="peform_action(1)">    
															  QC </a> 
													 
													</th>
													<?php
													if(!empty($setting_data->palletization_checked))
													{
													?>
													<th>
														 
															<input type="checkbox"   name="qcproduction_mst_id" id="qcproduction_mst_id" value="" onclick="click_all_palletazation(this.checked)"    />   
														 
															 <a  class="btn btn-info tooltips" data-toggle="tooltip" data-title="Pallatazation Done" href="javascript:;" onclick="peform_action(2)">  Palletization</a> 
														 
													</th>	
													<?php 
													}
													?>
													<th>
														Action
													</th>
												</tr>
											</thead>
											<tbody>
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
$this->view('lib/addcountry');
$this->view('lib/addcurrency');
?>
<div id="addproducation_modal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="modal-header">
               
                <h4 class="modal-title"> All Producation 
					<div class="pull-right">
						 
					</div>
				</h4>
				
            </div>
            <div class="modal-body">
					<div class="all_producation">
						 
					</div>
				 
             </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				
				<input type="hidden" name="production_mst_id" id="production_mst_id" />
            </div>
        </div>
    </div>
</div>
 
<div id="next_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content ">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"> Send for Next Step </h4>
				
            </div>
            <div class="modal-body">
				 <div class="row">
					 <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Select Next Step
					 	</label>
					 	<div class="col-sm-12">
					 		<select class="form-control" name="step_status" id="step_status">
								<option value="1">Send For QC</option>
								<option value="2">Send For Palletazation</option>
								<option value="3">Send For Loading</option>
							</select>
					 	</div>
					</div>
				</div>
             </div>
            <div class="modal-footer">
				<button name="Submit" type="button" onclick="send_next_step()"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				 <input type="hidden" name="productionmst_id" id="productionmst_id" />
            </div>
        </div>
    </div>
</div>

<div id="psc_date_modal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">PSC Date</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label class="control-label">Today's Date</label>
                    <input type="text" id="psc_today_date" class="form-control" readonly disabled value="">
                </div>
                <div class="form-group">
                    <label class="control-label">Estimated Date</label>
                    <input type="text" id="psc_estimated_date" class="form-control" placeholder="Select Estimated Date">
                </div>
                <div class="form-group">
                    <label class="control-label">Count Days</label>
                    <input type="text" id="psc_count_days" class="form-control" readonly disabled value="" placeholder="0">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="save_psc_date();">Submit</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <input type="hidden" id="psc_production_mst_id" value="">
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="productionModal" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title">Production Details (Container Wise)</h4>
          </div>
          <div class="modal-body">
              <div id="production_modal_body">Loading...</div>
          </div>
          <div class="modal-footer">
             <button class="btn btn-success btn-disabled"
        id="final_production_btn"
        onclick="final_production_done()">
    Final Production
</button>
			  
              <button class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
      </div>
  </div>
</div>

<script>
// Fallback if block_page/unblock_page not defined by footer
if (typeof block_page !== 'function') {
	function block_page() { try { if (typeof $ !== 'undefined' && $.blockUI) $.blockUI(); } catch (e) {} }
}
if (typeof unblock_page !== 'function') {
	function unblock_page(type, msg) {
		try {
			if (typeof $ !== 'undefined' && $.unblockUI) $.unblockUI();
			if (msg && type && typeof toastr !== 'undefined') toastr[type](msg);
		} catch (e) {}
	}
}

$(document).on("shown.bs.modal", "#productionModal", function() {
    $(".pallets").each(function() {
        let row_id = this.id.replace("pallets_", "");
        calculate_from_pallets(row_id);
    });
});


function calculate_from_pallets(row_id)
{
    let pallets = Number($("#pallets_" + row_id).val());
    let boxPerPallet = Number($("#box_per_pallet_" + row_id).val());
    let sqmPerBox = Number($("#sqm_per_box_" + row_id).val());

    if (pallets < 0 || isNaN(pallets)) pallets = 0;

    let total_boxes = pallets * boxPerPallet;
    let total_sqm   = total_boxes * sqmPerBox;

    // Set values
    $("#boxes_" + row_id).val(total_boxes);
    $("#sqm_" + row_id).val(total_sqm.toFixed(2));
}



function check_all_done() {
    let pending = $(".btn-warning").length;

    if(pending == 0){
        $("#final_production_btn")
            .removeClass("btn-disabled")
            .text("Final Production – All Done ✔");
    }
}

function open_production_modal(production_trn_id) 
{
    // Set the trn id into Final Production button
    $("#final_production_btn").attr("data-mstid", production_trn_id);

    // Load container-wise details inside modal
    $("#production_modal_body").html('Loading...');

    $.post(root + "production/get_container_wise", 
    { production_trn_id: production_trn_id }, 
    function(res) {
        $("#production_modal_body").html(res);
    });

    // Show the modal
    $("#productionModal").modal("show");
}
function mark_trn_production_done(trn_id)
{
    if(!confirm("Mark this production as DONE?")) return;

    $.ajax({
        url: root + "producation_detail/mark_trn_done",
        type: "POST",
        data: { production_trn_id: trn_id },
        success: function(res){

            if ($.trim(res) == "1") {

                // Disable all inputs of this row
                $("#pallet_" + trn_id).prop("disabled", true);
                $("#big_" + trn_id).prop("disabled", true);
                $("#small_" + trn_id).prop("disabled", true);
                $("#box_" + trn_id).prop("disabled", true);
                $("#sqm_" + trn_id).prop("disabled", true);
                $("#pro_batch_" + trn_id).prop("disabled", true);
                $("#pro_shade_" + trn_id).prop("disabled", true);

                // Replace the button with DONE badge
                $("#status_btn_" + trn_id).html(
                    '<span class="label label-success">Done</span>'
                );

                // Disable UPDATE button
                $("#update_btn_" + trn_id).prop("disabled", true);

            } else {
                alert("Error updating status");
            }
        }
    });
}

function mark_master_production_done(mst_id)
{
    if(!confirm("All containers done. Mark overall Production Done?"))
        return;

    $.ajax({
        url: root + "producation_detail/mark_master_done",
        type: "POST",
        data: { production_mst_id: mst_id },
        success: function(res){
            $("#productionModal").modal("hide");
            load_data();
        }
    });
}


function confirm_final_production(production_id)
{
    if(!confirm("Are you sure you want to mark this production as DONE?"))
        return;

    $.ajax({
        url: root + "producation_detail/final_production",
        type: "POST",
        data: { production_mst_id: production_id },

        success: function(data){
            $("#productionModal").modal("hide");
            alert("Production marked as DONE!");
            load_data();
        }
    });
}


function open_production_popup(production_id)
{
    $("#production_modal_body").html("Loading...");
    $("#productionModal").modal("show");

    // Store production_mst_id on button so final_production_done can use it if AJAX fails
    $("#final_production_btn").attr("data-mstid", production_id);
    $("#final_production_btn").attr("onclick", "final_production_done()");

    $.ajax({
        url: root + "producation_detail/get_container_data",
        type: "POST",
        data: { production_mst_id: production_id },
        success: function(res){
            $("#production_modal_body").html(res);
            $("#final_production_btn").attr("onclick", "confirm_final_production("+production_id+")");
        },
        error: function(xhr) {
            $("#production_modal_body").html(
                '<div class="alert alert-danger">Failed to load container data. ' +
                (xhr.status === 500 ? 'Server error. Please try again or contact support.' : 'Error: ' + xhr.status) + '</div>'
            );
        }
    });
}

function final_production_done()
{
    var mstId = $("#final_production_btn").attr("data-mstid");
    if (mstId) {
        confirm_final_production(mstId);
    } else {
        alert("Production ID not found. Please close and reopen the popup.");
    }
}


function load_data() {
    var rows_selected = [];
    datatable = $("#datatable").dataTable({
        "bAutoWidth": false,
        "bFilter": true,
        "bSort": true,
        "aaSorting": [[0]],
        "aoColumns": [
            { "bSortable": false },
            { "bSortable": false },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": true },
            { "bSortable": false },
            { "bSortable": false },
            <?php if (!empty($setting_data->palletization_checked)) { ?>
                { "bSortable": false },
            <?php } ?>
            { "bSortable": false }
        ],
        "bProcessing": true,
        "searchDelay": 350,
        "bServerSide": true,
        "bDestroy": true,
        "oLanguage": {
            "sLengthMenu": "_MENU_",
            "sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
            "sEmptyTable": "NO DATA ADDED YET !",
            "sSearch": "",
            "sInfoFiltered": ""
        },
        "aLengthMenu": [[-1, 10, 20, 30, 50], ["All", 10, 20, 30, 50]],
        'columnDefs': [{
            "targets": [0, 1], 
            "visible": true, 
            "className": "text-center",
            "width": "4%"
        }, {
            "targets": '_all',
            "visible": true,
            "className": "text-center",
        }],
        "iDisplayLength": 50,
        dom: 'Blfrtip',
        buttons: [{
            extend: 'pdfHtml5',
            text: '<i class="fa fa-file-pdf-o"></i>',
            orientation: 'landscape',
            pageSize: 'A4',
            titleAttr: 'PDF',
			title: 'Producation Detail',
            customize: function (doc) {
                
                doc.content[1].table.body.forEach(function (row) {
                    row.splice(-1, 1); 
                    row.splice(1, 1);
                });

				var widths = [];
                  doc.content[1].table.body.forEach(function(row) {
                      row.forEach(function(cell, i) {
                          var cellText = cell.text || cell;
                          var cellLength = cellText.toString().length;
                          if (!widths[i] || cellLength > widths[i]) {
                              widths[i] = cellLength;
                          }
                      });
                  });

				  	doc.content[1].layout = {
						hLineWidth: function(i, node) { return 1; },
						vLineWidth: function(i, node) { return 1; },
						hLineColor: function(i, node) { return '#E0E0E0'; },
						vLineColor: function(i, node) { return '#E0E0E0'; },
						paddingLeft: function(i, node) { return 4; },
						paddingRight: function(i, node) { return 4; },
						paddingTop: function(i, node) { return 2; },
						paddingBottom: function(i, node) { return 4; },
						fillColor: function(i, node) { return (i === 0) ? '#F0F0F0' : null; }
					};

					// Ensure all cells are objects and set background color for header row
					doc.content[1].table.body.forEach(function(row, rowIndex) {
						row.forEach(function(cell, cellIndex) {
							if (typeof cell === 'string') {
								row[cellIndex] = { text: cell };
							}
							if (rowIndex === 0) {
								row[cellIndex].fillColor = '#0C6291';
								row[cellIndex].bold = true;
							}
						});
					});

            }
        }],
        "sAjaxSource": root + 'producation_detail/fetch_record/',
        "fnServerParams": function (aoData) {
            aoData.push({ "name": "mode", "value": "fetch" },
                        { "name": "cust_id", "value": $("#cust_id").val() },
                        { "name": "date", "value": $("#daterange").val() },
                        { "name": "supplierdata", "value": $("#supplierdata").val() });
        },
        "fnDrawCallback": function (oSettings) {
            $('.ttip, [data-toggle="tooltip"]').tooltip();
            var productionmst_id = $("#production_mst_id").val().split(",");
            for (var i = 0; i < productionmst_id.length; i++) {
                $("#allproduction_mst_id" + productionmst_id[i]).prop("checked", true)
            }
        }
    });

   
    $('.dataTables_filter input').addClass('form-control').attr('placeholder', 'Search');
    $('.dataTables_length select').addClass('form-control');
}

function downloadPDF() {
    var table = $('#datatable').DataTable();
    table.button('.buttons-pdf').trigger();
}

function click_all_production(value)
{
	if(value == true)
	{
		$("input[name='productionsheet_mst_id[]']").prop("checked",true)
	}
	else
	{
		$("input[name='productionsheet_mst_id[]']").prop("checked",false)
	}
}

function click_all(value)
{
	if(value == true)
	{
		$("input[name='qcproduction_mst_id[]']").prop("checked",true)
	}
	else
	{
		$("input[name='qcproduction_mst_id[]']").prop("checked",false)
	}
}
function click_all_palletazation(value)
{
	if(value == true)
	{
		$("input[name='palletproduction_mst_id[]']").prop("checked",true)
	}
	else
	{
		$("input[name='palletproduction_mst_id[]']").prop("checked",false)
	}
}

function peform_action1(val)
{
	if(val == 3)
	{
		var qcproduction_mst_id = '';
			$.each($("input[name='productionsheet_mst_id[]']:checked"), function(){
				qcproduction_mst_id += $(this).val()+'-';
		});
	}
	
	qcproduction_mst_id = qcproduction_mst_id.substr(0, qcproduction_mst_id.lastIndexOf("-", qcproduction_mst_id.length - 1));		 
			
				var url = "click_for_production";
			
		block_page();
		 $.ajax({ 
			type: "POST", 
			url: root+'create_producation/'+url,
			data: {
				"qcproduction_mst_id"	: qcproduction_mst_id,
			//	"producation_complete_date"	: qcproduction_mst_id,
				"status"		 		: 1 
			}, 
			cache: false, 
			success: function (data) { 
				//console.log(data);
				  unblock_page('success',"Record Successfully Updated");
					setTimeout(function(){ location.reload(); },1500);
				   
			}
		 }); 
	 
	 
}

function peform_action(val)
{
	if(val == 1)
	{
		var qcproduction_mst_id = '';
			$.each($("input[name='qcproduction_mst_id[]']:checked"), function(){
				qcproduction_mst_id += $(this).val()+'-';
		});
	}
	else
	{
		var qcproduction_mst_id = '';
			$.each($("input[name='palletproduction_mst_id[]']:checked"), function(){
				qcproduction_mst_id += $(this).val()+'-';
		});
	}
	qcproduction_mst_id = qcproduction_mst_id.substr(0, qcproduction_mst_id.lastIndexOf("-", qcproduction_mst_id.length - 1));		 
	var url = (val == 1)?"click_for_qc":"click_for_pallet";
	
		block_page();
		 $.ajax({ 
			type: "POST", 
			url: root+'create_producation/'+url,
			data: {
				"qcproduction_mst_id"	: qcproduction_mst_id,
				"status"		 		: 1 
			}, 
			cache: false, 
			success: function (data) { 
				//console.log(data);
				  unblock_page('success',"Record Successfully Updated");
					setTimeout(function(){ location.reload(); },1500);
				   
			}
		 }); 
	 
	 
}
function send_next_step()
{
	block_page();
		 $.ajax({ 
			type: "POST", 
			url: root+'producation_detail/send_next_step',
			data: {
				"productionmst_id"	: $("#productionmst_id").val(),
				"step_status"		: $("#step_status").val()
			}, 
			cache: false, 
			success: function(data)
			{ 
					var obj = JSON.parse(data);
					if(obj.res==1)
					{
						 location.reload();
					}
					else
					{
						toastr["error"]("Somthing Wrong.")
					}	
			
					unblock_page('',"")
			}
		});
}
function send_for_next(production_mst_id)
{
	$("#productionmst_id").val(production_mst_id);
	 $("#next_modal").modal({
		backdrop: 'static',
		keyboard: false
	});
}
function add_producation_detail(production_mst_id,checked)
{
	if(checked==true)
	{
		var productionmst_id = $("#production_mst_id").val().split(",");
		productionmst_id.push(production_mst_id);
		var productionmst_id = productionmst_id.filter(function(v){return v!==''});
		$("#production_mst_id").val(productionmst_id.toString())
	}
	else
	{
		var productionmst_id = $("#production_mst_id").val().split(",");
		var removeItem = production_mst_id;

			y = jQuery.grep(productionmst_id, function(value) {
				return value != removeItem;
			});
			$("#production_mst_id").val(y.toString())
	}
}
   
function create_po()
{
	var production_mst_id = [];
	$. each($("input[name='allproduction_mst_id[]']:checked"), function(){
		production_mst_id.push($(this).val());
	});
	var productionmst_id = $("#production_mst_id").val().split(",");
	if(production_mst_id.length < 2 && productionmst_id.length < 2)
	{
		toastr["error"]("Please select atleast 2 invoice.")
	}
	else
	{
		block_page();
		var pro_id = (production_mst_id.length < 2)?productionmst_id:production_mst_id;
	 
	 
		$.ajax({ 
			type: "POST", 
			url: root+'producation_detail/check_suppier',
			data: {
				"production_mst_id"	: pro_id
			}, 
			cache: false, 
			success: function (data)
			{ 
					var obj = JSON.parse(data);
					if(obj.res==1)
					{
						 window.location=root+'createpo/mutiple/'+pro_id.join('-');
					}
					else
					{
						toastr["error"]("Suppier name are different. Allow only for same Suppier.")
					}	
			
					unblock_page('',"")
			}
		});
	}
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
 
function edit_producation(producationid)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"producation_detail/fetch_producationdata",
              data: {"id": producationid}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#addproducationmodal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(producationid);
				 	$("#date").val(obj.producation_date);
				 	$("#productid").val(obj.product_id).trigger('change');
				 	$("#boxes").val(obj.boxes);
					 $(".pro_title").html('Edit Producation');
					unblock_page("",""); 
                  }
              
          }); 
}	
$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 }); 
function psc_calculate_days(estDateObj) {
	var todayStr = $("#psc_today_date").val();
	var estStr  = $("#psc_estimated_date").val();
	if (!todayStr) { $("#psc_count_days").val(""); return; }
	var todayParts = todayStr.split(/[-/]/);
	if (todayParts.length !== 3) { $("#psc_count_days").val(""); return; }
	var todayDate = new Date(parseInt(todayParts[2], 10), parseInt(todayParts[1], 10) - 1, parseInt(todayParts[0], 10));
	todayDate.setHours(0, 0, 0, 0);
	var estDate;
	if (estDateObj && estDateObj instanceof Date) {
		estDate = new Date(estDateObj);
	} else if (estStr) {
		var estParts = estStr.split(/[-/]/);
		if (estParts.length !== 3) { $("#psc_count_days").val(""); return; }
		estDate = new Date(parseInt(estParts[2], 10), parseInt(estParts[1], 10) - 1, parseInt(estParts[0], 10));
	} else {
		$("#psc_count_days").val("");
		return;
	}
	estDate.setHours(0, 0, 0, 0);
	var diffDays = Math.floor((estDate - todayDate) / (1000 * 60 * 60 * 24));
	$("#psc_count_days").val(isNaN(diffDays) ? "" : diffDays);
}
function open_psc_date_modal(production_mst_id) {
	$("#psc_production_mst_id").val(production_mst_id);
	try { $("#psc_estimated_date").datepicker("destroy"); } catch(e) {}
	$("#psc_today_date").val("");
	$("#psc_estimated_date").val("");
	$("#psc_count_days").val("");

	var today = new Date();
	var dd = ("0" + today.getDate()).slice(-2);
	var mm = ("0" + (today.getMonth() + 1)).slice(-2);
	var yyyy = today.getFullYear();
	var todayStr = dd + "-" + mm + "-" + yyyy;
	var todayDate = new Date(parseInt(yyyy,10), parseInt(mm,10)-1, parseInt(dd,10));
	todayDate.setHours(0,0,0,0);

	function initAndShowModal(prefill) {
		if (prefill && prefill.res == 1) {
			$("#psc_today_date").val(prefill.psc_date || todayStr);
			$("#psc_estimated_date").val(prefill.psc_estimated_date || "");
			$("#psc_count_days").val(prefill.psc_count_days !== null && prefill.psc_count_days !== undefined ? prefill.psc_count_days : "");
		} else {
			$("#psc_today_date").val(todayStr);
			$("#psc_estimated_date").val("");
			$("#psc_count_days").val("");
		}
		var startDateVal = $("#psc_today_date").val();
		try { $("#psc_estimated_date").datepicker("destroy"); } catch(e) {}
		$("#psc_estimated_date").datepicker({
			autoclose: true,
			format: 'dd-mm-yyyy',
			startDate: startDateVal,
			todayHighlight: true,
			beforeShowDay: function(d) {
				var dNorm = new Date(d.getFullYear(), d.getMonth(), d.getDate());
				dNorm.setHours(0,0,0,0);
				return { enabled: dNorm >= todayDate };
			}
		}).off("changeDate change keyup").on("changeDate", function(e) {
			if (e && e.date) {
				var d = e.date;
				var fd = ("0" + d.getDate()).slice(-2);
				var fm = ("0" + (d.getMonth() + 1)).slice(-2);
				var fy = d.getFullYear();
				$(this).val(fd + "-" + fm + "-" + fy);
				psc_calculate_days(d);
			}
		}).on("change", function() {
			var v = $(this).val();
			if (v && /^\d{1,2}[-\/]\d{1,2}[-\/]\d{4}$/.test(v)) {
				var parts = v.split(/[-\/]/);
				var p0 = parseInt(parts[0],10), p1 = parseInt(parts[1],10), p2 = parseInt(parts[2],10);
				if (p0 <= 12 && p1 > 12) {
					var want = ("0"+p1).slice(-2) + "-" + ("0"+p0).slice(-2) + "-" + p2;
					if ($(this).val() !== want) $(this).val(want);
				}
			}
		}).on("change keyup", function() {
			var v = $(this).val();
			if (!v) { psc_calculate_days(null); return; }
			var parts = v.split(/[-\/]/);
			if (parts.length === 3) {
				var p0 = parseInt(parts[0],10), p1 = parseInt(parts[1],10), p2 = parseInt(parts[2],10);
				if (p1 > 12 && p0 <= 12) {
					$(this).val(("0"+p1).slice(-2) + "-" + ("0"+p0).slice(-2) + "-" + p2);
				} else if (v.indexOf("/") !== -1) {
					$(this).val(v.replace(/\//g, "-"));
				}
			}
			psc_calculate_days(null);
		});
		$("#psc_date_modal").modal({ backdrop: 'static', keyboard: false });
	}

	$.ajax({
		type: "POST",
		url: root + "producation_detail/get_psc_dates",
		data: { production_mst_id: production_mst_id },
		cache: false,
		dataType: "json",
		success: function(resp) {
			initAndShowModal(resp);
		},
		error: function() {
			initAndShowModal(null);
		}
	});
}
function save_psc_date() {
	var production_mst_id = $("#psc_production_mst_id").val();
	var psc_today_date   = $("#psc_today_date").val();
	var psc_estimated_date = $("#psc_estimated_date").val();
	var psc_count_days   = $("#psc_count_days").val();
	if (!psc_estimated_date) {
		Swal.fire({ icon: 'warning', title: 'Required', text: 'Please select Estimated Date.' });
		return;
	}
	var countDays = parseInt(psc_count_days, 10);
	if (!isNaN(countDays) && countDays < 0) {
		Swal.fire({ icon: 'error', title: 'Invalid Date', text: 'Please add future and correct date. You can\'t add past dates.' });
		return;
	}
	block_page();
	$.ajax({
		type: "POST",
		url: root + "producation_detail/save_psc_date",
		data: {
			production_mst_id: production_mst_id,
			psc_today_date: psc_today_date,
			psc_estimated_date: psc_estimated_date,
			psc_count_days: psc_count_days
		},
		cache: false,
		success: function(response) {
			unblock_page("", "");
			var obj = (typeof response === "string") ? JSON.parse(response) : response;
			if (obj.res == 1) {
				$("#psc_date_modal").modal("hide");
				Swal.fire({ icon: 'success', title: 'Saved', text: 'PSC dates saved successfully.' });
				load_data();
			} else {
				Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to save PSC dates.' });
			}
		},
		error: function() {
			unblock_page("", "");
			Swal.fire({ icon: 'error', title: 'Error', text: 'Request failed.' });
		}
	});
}
$(document).ready(function () {
	load_data();	
});
 
  
$(".select2").select2({
	width:"100%"
});
function open_pdf(performa_invoice_id)
{
 	block_page(); 	
	$(".all_producation").html('')	
	$.ajax({          
		type: "POST",          
		url: root+'producation_detail/producation_pdf',         
		data: {          
			"performa_invoice_id" : performa_invoice_id
		}, 		
		cache: false, 		
		success: function (data) { 	
			$("#addproducation_modal").modal({
				backdrop: 'static',
				keyboard: false
			});		
			$(".all_producation").html(data);
			$(".tooltips").tooltip()
			unblock_page("","")		
		}	
	});
}
 function delete_record(production_mst_id,performa_invoice_id)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_producation/deleterecord',
              data: {
                "production_mst_id" : production_mst_id,
                "performa_invoice_id" : performa_invoice_id 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ location.reload(); },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
 function click_for_production(production_mst_id,status)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Sure'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_producation/click_for_production',
              data: {
                "qcproduction_mst_id" : production_mst_id,
                "status"		 	: status 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Update with Producation");
					setTimeout(function(){ location.reload(); },1000);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
} 

function click_for_qc(production_mst_id,status)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Sure'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_producation/click_for_qc',
              data: {
                "qcproduction_mst_id" : production_mst_id,
                "status"		 	: status 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Update with QC");
					setTimeout(function(){ location.reload(); },1000);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}
function click_for_pallet(production_mst_id,status)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, Sure'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'create_producation/click_for_pallet',
              data: {
                "qcproduction_mst_id" : production_mst_id,
                "status"		 	: status 
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Update With Pallatazation");
					setTimeout(function(){ location.reload(); },1000);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}

function addproducation()
{
	 $("#addproducationmodal").modal({
			backdrop: 'static',
			keyboard: false
		});
	 $(".pro_title").html('Add Producation');
}
$("#producation_form").validate({
		rules: {
			boxes: {
				required: true
			} 
		},
		messages: {
			boxes: {
				required: "Enter Boxes"
			} 
		}
	});
$("#producation_form").submit(function(event) {
	event.preventDefault();
	 if(!$("#producation_form").valid())
	{
		return false;
	}
 
	block_page();
	var postData= new FormData(this);
	
	$.ajax({
            type: "post",
            url:  root+'producation_detail/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              // console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				  $("#eid").val('');
				if(obj.res==1)
			   {
				   $("#producation_form").trigger('reset');
				    unblock_page("success","Sucessfully Inserted.");
					 $("#addproducationmodal").modal('hide');
					 load_data()
			   }
			 else if(obj.res==2)
			   {
				   $("#producation_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					 $("#addproducationmodal").modal('hide');
					 load_data()
			   }
			    $("#productid").val('').trigger('change');
			  
				 	
			  
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});
function delete_manageproduction(production_mst_id)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, delete it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'producation_detail/deletemanageproducation',
              data: {
                "production_mst_id" : production_mst_id
              
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					 
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ location.reload(); },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});	
}

function delete_producation(id)
{
	Swal.fire({
  title: 'You want to Delete?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, confirm it!'
}).then((result) => {
		 if (result.value) {
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'producation_detail/delete_producation',
              data: {
                "id": id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"Producation Sucessfully deleted.");
					load_data()
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
		});
}
</script>
 