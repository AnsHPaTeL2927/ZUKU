<?php 
$this->view('lib/header'); 
?>	

<script>
function view_pdf(no) {
	window.open(root + "customer_report/view_pdf", '_blank');
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
							<a href="<?= base_url() ?>dashboard">Dashboard</a>
						</li>
						<li class="active">Customer Report</li>
					</ol>

					<div class="page-header">
						<h3>Customer Report</h3>
						<div class="pull-right form-group">
							<a class="btn btn-warning tooltips" href="javascript:;" onclick="Export()"><i class="fa fa-excel"></i> Export Excel</a> 
							<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
						</div>
					</div>
				</div>
			</div>

			<div class="panel-body">
				<div class="col-md-5">
					<label class="col-sm-4 control-label" style="margin-top: 5px;">Select Customer</label>
					<div class="col-sm-7">
						<select class="select2" name="customer_id" id="customer_id" required title="Select Customer" onchange="customer_report()">
							<option value="">All Customer</option>
							<?php 
							foreach ($customer_list as $cust) {
								echo "<option value=\"{$cust->id}\">{$cust->c_companyname}</option>";
							}
							?>
						</select>
						<label id="customer_id-error" class="error" for="customer_id"></label>
					</div>
				</div>

				<div class="col-md-5">
					<label class="col-sm-4 control-label" style="margin-top: 5px;">Select Customer Name</label>
					<div class="col-sm-7">
						<select class="select2" name="customer_id1" id="customer_id1" required title="Select Customer Name" onchange="customer_report()">
							<option value="">All Customer Name</option>
							<?php 
							foreach ($customer_name_list as $cname) {
								echo "<option value=\"{$cname->id}\">{$cname->c_name}</option>";
							}
							?>
						</select>
						<label id="customer_id1-error" class="error" for="customer_id1"></label>
					</div>
				</div>

				<div class="col-md-5">
					<label class="col-md-4 control-label" style="margin-top: 5px;">Invoice Date</label>
					<div class="col-md-7">								 
						<input type="text" name="daterange" id="daterange" class="form-control" value="" onchange="customer_report()">									
					</div> 
				</div>

				<div class="view_report col-md-12" style="overflow-x:scroll"></div>
			</div>
		</div>
	</div>
</div>

<?php $this->view('lib/footer'); ?>

<script src="<?= base_url() ?>adminast/assets/js/jquery.table2excel.js"></script>
<script>
function Export() {
	$(".view_report").table2excel({
		filename: "Customer Report.xls",
		sheetName: "Customer Report",
	});
}

function cb(start, end) {
	$('#daterange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
}
cb(moment().subtract(29, 'days'), moment());

$('#daterange').daterangepicker({
	locale: {
		format: 'YYYY-MM-DD'
	},
	autoApply: true,
	singleDatePicker: true,
	startDate: moment(),
	ranges: {
		'Today': [moment(), moment()],
		'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
		'Last 7 Days': [moment().subtract(6, 'days'), moment()],
		'Last 30 Days': [moment().subtract(29, 'days'), moment()],
		'This Month': [moment().startOf('month'), moment().endOf('month')],
		'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
		'This Year': [moment().startOf('year'), moment().endOf('year')]
	}
}, cb);

$(".select2").select2({
	width: '100%'
});

customer_report();

function customer_report() {
	block_page();
	$(".view_report").html('');
	$.ajax({          
		type: "POST",          
		url: root + 'customer_report/customerreport',         
		data: {          
			customer_id: $("#customer_id").val(),
			customer_id1: $("#customer_id1").val(),
			filterDate: $("#daterange").val()
		}, 		
		cache: false, 		
		success: function (data) { 			
			$(".view_report").html(data);
			unblock_page("", "");
		}	
	});
}
</script>
