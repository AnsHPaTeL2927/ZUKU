<?php 
$this->view('lib/header'); 
$_SESSION['beenhere'] = 1;
?>	 <div class="main-container">
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
									Tax Invoice
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>Tax Invoice   </h3>
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
							
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Tax Invoice
									
								</div>
								<div class="panel-body" >
									<div class="col-md-4">
										<label class="col-md-4 control-label "><strong class="pull-right"> Invoice Date</strong></label>
										 <div class="col-md-8">
										<?php 
											$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
											
											$invoicedate = explode(" - ",$year);
										?>
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
										 </div>     
									</div>
									
									<label class="col-md-2" style="margin-top: 5px">
									<strong class=""> Select Invoice No</strong>
									</label>
									<div class="col-sm-2">
										<select class="select2" name="invoicenoid" id="invoicenoid" required title="Select Invoice No" onchange="load_data_table()" >
											<option value="">All Invoice No</option>
											<?php
											for($p=0;$p<count($invoicenodata);$p++)
											{
													$sel = '';
													if($invoicenodata[$p]->taxinvoice_id == $_SESSION['invoiceno_get_id'])
													{
														$sel = 'selected="selected"';
													}
												echo "<option ".$sel." value='".$invoicenodata[$p]->taxinvoice_id."'>".$invoicenodata[$p]->taxinvoice_no." </option>";
											}
											?> 
										</select>
									</div>
									
									<label class="col-md-2 control-label" style="margin-top: 5px;">
									<strong class=""> Select Consignee Name</strong>
									</label>
									<div class="col-sm-2">
										<select class="select2" name="consigneename" id="consigneename" required title="Select Consignee Name" onchange="load_data_table()" >
											<option value="">All Consignee Name</option>
											<?php
											for($p=0;$p<count($consigneenamedata);$p++)
											{
													$sel = '';
													if($consigneenamedata[$p]->id == $_SESSION['get_consigneename'])
													{
														$sel = 'selected="selected"';
													}
												echo "<option ".$sel." value='".$consigneenamedata[$p]->id."'>".$consigneenamedata[$p]->c_companyname." </option>";
											}
											?>
											
										</select>
									</div>
								
								</div>
								<div class="panel-body">
									
									<div class="table-responsive">
										<table class="table table-bordered table-hover display" id="datatable" width="100%">
											<thead>
												<tr>
													<th>Sr no</th>
													<th>Invoice Date</th>
													<th>Invoice no</th>
													<th>Consignee Name</th>
													<th>No of Container</th>
													<th>With GST / Without GST </th>
													<th>GST Amount</th>
													<th>Total Amount</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
											 </tbody>
												<tfoot>
													<tr>
													<th colspan="6" class="text-right">Total</th>
													<th></th>
													<th></th>
													<th></th>
													 
													</tr>
												</tfoot>
										</table>
									</div>
								</div>
							</div>
						 
						</div>
					</div>
				</div>
			  </div>
			</div>	 
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Product Detail</h4>
            </div>
            <div class="modal-body">
				<div class="productdetailhtml"></div>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<?php $this->view('lib/footer'); ?>
<script type="text/javascript">
$(".select2").select2({
	width:'100%'
});
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
 
$(document).ready(function () {
	 	load_data_table();
		
});
function filterbystatus()
{
	load_data_table()
}
function load_data_table()
{
	 
	datatable = $("#datatable").dataTable({
			"bAutoWidth" : false,
			"bFilter" : true,
			"bSort" : true,
			"bProcessing": true,
			"searchDelay": 350,
			"bServerSide" : true,
			"bDestroy": true,
			"oLanguage": {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "NO DATA ADDED YET !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"aLengthMenu": [[-1,100, 200, 300, 500], ["All",100, 200, 300, 500]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 200,
			dom: 'Blfrtip',
			 buttons :
			 [
				  
            {
                extend:    'print',
                text:      '<i class="fa fa-print"></i>',
                titleAttr: 'PRINT'
            },
            {
                extend:    'csvHtml5',
			      text:      '<i class="fa fa-file-text-o"></i>',
                titleAttr: 'CSV'
            },
            {
                extend:    'pdfHtml5',
                text:      '<i class="fa fa-file-pdf-o"></i>',
				 orientation: 'landscape',
                pageSize: 'A4',
                titleAttr: 'PDF'
            }
				 			
			],
			"sAjaxSource": root+'taxinvoice_listing/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "date" , "value" :  $("#daterange"). val()},{ "name" : "invoicenoid","value" : $("#invoicenoid").val()},{ "name" : "consigneename","value" : $("#consigneename").val()} );
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			},
			 "footerCallback": function ( row, data, start, end, display ) {
				  var api = this.api(), data;
					total = api
				 // Total over this page
					pageTotal = api
						.column( 6, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					var c = (b != '')?parseFloat(b.replace('<img src="http://i.stack.imgur.com/nGbfO.png" width="8" height="10"> ', "").replace(new RegExp(',', 'g'),"")):0
				    return  parseFloat(a) +  parseFloat(c);
                }, 0 );
				
				pageTotal1 = api
						.column( 7, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace('<img src="http://i.stack.imgur.com/nGbfO.png" width="8" height="10"> ', "").replace(new RegExp(',', 'g'),""));
                }, 0 );
				
				 
            // Update footer
            
			 $( api.column( 6 ).footer() ).html(
                '&#x20b9; ' + numberWithCommas(pageTotal.toFixed(2)) 
            );
			 $( api.column( 7).footer() ).html(
                 '&#x20b9; ' + numberWithCommas(pageTotal1.toFixed(2))
            );
		 
			  
			 }
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}
function delete_record(id,export_invoice_id)
{
	$.ajax({ 
        type: "POST", 
        url: root+"taxinvoice_listing/updateexport_invoice",
              data: {
                "id": export_invoice_id
              }, 
              cache: false, 
              success: function (data) { 
              
			}

		});  
	main_delete(id,'taxinvoice_listing/deleterecord','taxinvoice_listing');
	
}
function view_detail(id,Exchange_Rate_val)
{
	 
	$.ajax({ 
        type: "POST", 
        url: root+"taxinvoice_listing/viewproductdetail",
              data: {
                "id": id,
				"Exchange_Rate_val":Exchange_Rate_val
              }, 
              cache: false, 
              success: function (data) { 
               $('#myModal').modal({
						backdrop: 'static',
						keyboard: false
					});
                
                 $(".productdetailhtml").html(data);  
			}

		});  

}
</script>