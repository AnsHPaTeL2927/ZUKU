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
  

<script>
function company_wise_print(performa_invoice_id)
{
	block_page();
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
				unblock_page('',"")
           }
	 });
}


function remaining_pi(performa_invoice_id)
{
	block_page();
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
				unblock_page('',"")
           }
	 });
}


function export_wise_print(performa_invoice_id)
{
	block_page();
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
				unblock_page('',"")
           }
	 });
}
$(".select2").select2({
	width:"100%"
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
            { "bSortable": false }   // 11: Action
        ],

        "columnDefs": [
            { "targets": 0, "width": "5%", "className": "text-center" },  // Sr No
            { "targets": 1, "width": "10%" }, // PO No
            { "targets": 2, "width": "12%" }, // PI No
            { "targets": 3, "width": "10%" }, // PI Date
            { "targets": 4, "width": "15%" }, // Consignee
            { "targets": 5, "width": "10%" }, // No of Container
            { "targets": 6, "width": "10%" }, // Production Done
            { "targets": 7, "width": "10%" }, // Pending Loading
            { "targets": 8, "width": "10%" }, // Loading Done
            { "targets": 9, "width": "10%" }, // Ready Export
            { "targets": 10, "width": "8%" }, // Export Done
            { "targets": 11, "width": "10%" }, // Action

            { "targets": "_all", "className": "text-center" }
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
 