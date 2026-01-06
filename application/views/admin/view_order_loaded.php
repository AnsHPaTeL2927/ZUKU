<?php 
$this->view('lib/header'); 
?>	
<script>
function view_pdf(no)
{
	window.open(root+"view_order_loaded/view_pdf", '_blank');
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
							Order Loaded
						</li>
						 
					</ol>
					<div class="page-header">
					<h3>	Order Loaded</h3>
					 <div class="pull-right form-group">
									<a class="btn btn-warning tooltips" href="javascript:;" onclick="Export()"     ><i class="fa fa-excel"></i> Export Excel</a> 
									<a class="btn btn-info tooltips" data-title="View in Pdf" href="javascript:;" onclick="view_pdf(1);"   ><i class="fa fa-file-pdf-o"></i> Export Pdf</a>
									 </div>
				 	</div>
					 
				</div>
			</div>
				
					<div class="panel-body">
					<div class="col-md-5">
				        <label class="col-md-4 control-label" style="    margin-top: 5px;">
							Invoice Date</label>
							 <div class="col-md-7">
								<?php 
									$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
									$invoicedate = explode(" - ",$year);
							 	?> 
									<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="customer_report()" /> 
									<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
									<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
							</div> 
				    </div>
				 <div class="col-md-12"  style="height:20px"></div>
					<div class="col-md-5">
				        <label class="col-sm-4 control-label" style="margin-top: 5px;" for="form-field-1">
								Select Customer
						</label>
						<div class="col-sm-7">
							 <select class="select2" name="customer_id" id="customer_id" required title="Select Customer" onchange="customer_report()">
								<option value="">ALL Customer</option>
									<?php 	
										for($i=0; $i<count($customer_list);$i++)
										{
									?>	
											<option <?=$selected?> value="<?=$customer_list[$i]->id?>"><?=$customer_list[$i]->c_companyname?></option>	
										<?php
									}
									?>
							</select>
							<label id="customer_id-error" class="error" for="customer_id"></label>
				        </div>
				    </div> 	
					<div class="col-md-5">
				        <label class="col-sm-4 control-label" style="margin-top: 5px;" for="form-field-1">
								Select Size
						</label>
						<div class="col-sm-7">
							 <select class="select2" name="size_id" id="size_id" required title="Select Size" onchange="customer_report()">
								<option value="">ALL Size</option>
									<?php
									for($i=0; $i<count($size_list);$i++)
									{	
									?>	
										<option <?=$selected?> value="<?=$size_list[$i]->sizetypemm?>"><?=$size_list[$i]->sizetypemm?></option>	
										<?php
									}
									?>
							</select>
							<label id="customer_id-error" class="error" for="customer_id"></label>
				        </div>
				    </div> 
					 <div class="col-md-5">
				        <label class="col-sm-4 control-label" style="margin-top: 5px;" for="form-field-1">
								Select Finish
						</label>
						<div class="col-sm-7">
							 <select class="select2" name="finish_id" id="finish_id" required title="Select Finish" onchange="customer_report()">
								<option value="">ALL Finish</option>
									<?php
									for($i=0; $i<count($finish_list);$i++)
									{	
									?>	
										<option <?=$selected?> value="<?=$finish_list[$i]->finish_id?>"><?=$finish_list[$i]->finish_name?></option>	
										<?php
									}
									?>
							</select>
							<label id="customer_id-error" class="error" for="customer_id"></label>
				        </div>
				    </div> 
					<div class="col-md-5">
				        <label class="col-sm-4 control-label" style="margin-top: 5px;" for="form-field-1">
								Select Pallet Type
						</label>
						<div class="col-sm-7">
							 <select class="select2" name="pallet_type" id="pallet_type" required title="Select Pallet Type" onchange="customer_report()">
								<option value="">ALL Pallet Type</option>
									<?php
									for($i=0; $i<count($get_pallet_type);$i++)
									{	
										
									?>	
										<option <?=$selected?> value="<?=$get_pallet_type[$i]->pallet_type_id?>"><?=$get_pallet_type[$i]->pallet_type_name?></option>	
										<?php
									}
									?>
							</select>
							<label id="customer_id-error" class="error" for="customer_id"></label>
				        </div>
				    </div> 
				 	
					<div class="view_report col-md-12" style="overflow-x:scroll"></div>
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
			filename:  "Order Loaded.xls",
			sheetName: "Order Loaded",
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
		url: root+'view_order_loaded/view_report',         
		data: {          
			"customer_id" 	: $("#customer_id").val(), 
			"finish_id" 	: $("#finish_id").val(), 
			"pallet_type" 	: $("#pallet_type").val(), 
			"daterange" 	: $("#daterange").val(), 
			"size_id" 		: $("#size_id").val() 
		}, 		
		cache: false, 		
		success: function (data) { 			
			$(".view_report").html(data)			
			unblock_page("","")		
		}	
	});
}
 
</script>