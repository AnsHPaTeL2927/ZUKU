<?php 
$this->view('lib/header'); 
$_SESSION['customerreport'] = ''; 
$_SESSION['customer_report'] = ''; 
?>	
<script>
function view_pdf(no)
{
	window.open(root+"customer_report/view_pdf", '_blank');
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
						<li>
							 
							<a href="<?=base_url()?>customer_report">
								All Customer report
							</a>
						</li>
						<li class="active">
							Customer Report
						</li>
						 
					</ol>
					<div class="page-header">
					<h3>Customer Report </h3>
					 <div class="pull-right form-group">
									<a class="btn btn-warning tooltips" href="javascript:;" onclick="Export()">
									<i class="fa fa-excel"></i> Export Excel</a> 
									<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);">
									<i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									 </div>
				 	</div>
					 
				</div>
			</div>
				
					<div class="panel-body">
					 
				 	<div class="col-md-5">
						<label class="col-md-4 control-label" style="margin-top: 5px;">Invoice Date</label>
						 <div class="col-md-6">
						<?php 
							$year = date('n') > 3 ? date('01-04-Y').' - '.(date('31-03-Y',strtotime("+1 year"))) : (date('01-04-Y',strtotime("-1 year"))).' - '.date('31-03-Y');
						 	$invoicedate = explode(" - ",$year);
						  ?> 
								<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="customer_report()" /> 
								<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
								<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
						 </div>     
					</div>
				 	<div class="view_report col-md-12" style="overflow-x:scroll;margin-top:50px;"></div>
					</div>
			</div>

		</div>
	</div>
	 
</div>
 
<?php $this->view('lib/footer'); ?>
 <script src="<?=base_url()?>adminast/assets/js/jquery.table2excel.js"></script>
<script>
 function Export() {
      $(".view_report").table2excel({
          filename:  "Customer Report.xls",
		  sheetName: "Customer Report",
      });
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
		width:'100%'
	})

function customer_report()
{
	if($("#customer_id").val() != "")
	{
		block_page();
		$(".view_report").html('')
		$.ajax({ 
              type: "POST", 
              url: root+'customer_report/view_report',
              data: {
                "id"		: <?=$customer_id?>, 
                "daterange" : $("#daterange"). val()
              }, 
              cache: false, 
              success: function (data) { 
				  $(".view_report").html(data)
				 unblock_page("","")
              }
			});
	}
}
 
</script>