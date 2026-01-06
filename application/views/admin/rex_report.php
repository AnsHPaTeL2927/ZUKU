<?php 
$this->view('lib/header'); 
 
?>	
<script>
function view_pdf(no)
{
	window.open(root+"rex_report/view_pdf", '_blank');
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
						Rex Statement
						</li>
						 
					</ol>
					<div class="page-header">
					<h3>Rex Statement </h3>
					 <div class="pull-right form-group">
									 
									<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									 </div>
				 	</div>
					 
				</div>
			</div>
				
					<div class="panel-body">
					<div class="col-md-5">
				        <label class="col-md-4 control-label" style="  margin-top: 5px;">
							Commercial Invoice Date</label>
							 <div class="col-md-7">
								<?php 
									$year = date('01-m-Y').' - '.date('t-m-Y');
									 
							 	?> 
									<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="customer_report()" /> 
									<input type="hidden" id="s_date" class="form-control" value="<?=date('01-m-Y');?>">
									<input type="hidden" id="e_date" class="form-control" value="<?=date('t-m-Y')?>">
							</div> 
				    </div>
				 <div class="col-md-12"  style="height:20px"></div>
					  	
				 
					<div class="col-md-12">
						<div class="view_report" style="overflow-x:scroll"></div>
					</div>
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
			filename:  "Performa Register.xls",
			sheetName: "Performa Register",
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
customer_report()
function customer_report()
{
 	block_page(); 	
	$(".view_report").html('')	
	$.ajax({          
		type: "POST",          
		url: root+'rex_report/view_report',         
		data: {          
		 	"daterange" 	: $("#daterange").val()  
	 	}, 		
		cache: false, 		
		success: function (data) { 			
			$(".view_report").html(data)			
			unblock_page("","")		
		}	
	});
}
 
</script>