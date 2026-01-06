<?php 
$this->view('lib/header'); 
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
									PI (Export Done)
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>PI (Export Done) </h3>
							 </div>
							 
						</div>
					</div>
					  <div class="row">
					   
						<div class="col-md-12">
							  
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									PI (Export Done)
							 	</div>
								<div class="panel-body" style="padding-left:0px;">
									 
									<div class="col-md-4">
										<label class="col-md-4 control-label" style="    margin-top: 5px;"><strong class=""> Invoice Date</strong></label>
										 <div class="col-md-8">
										<?php 
											$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
											
											$invoicedate = explode(" - ",$year);
											$start_date = $invoicedate[0];
											$end_date 	= $invoicedate[1];
											 
											if(!empty($_SESSION['ready_s_date']))
											{
												$start_date = $_SESSION['ready_s_date'];
											}
											if(!empty($_SESSION['ready_e_date']))
											{
												$end_date = $_SESSION['ready_e_date'];
											}
										 ?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$start_date?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$end_date?>">
										 </div>     
									</div>
									<div class="col-md-4">
										<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select Consignee</strong></label>
										 <div class="col-md-7">
										<select class="select2" name="cust_id" id="cust_id"   title="Enter Consignee" onchange="load_data_table()" >
											<option value="">All Consignee</option>
												<?php 
												foreach($consign_data as $company_row)
												{
													$cust_name = (!empty($company_row->c_nick_name))?$company_row->c_nick_name:$company_row->c_companyname; 
													 $sel ='';
													 if($company_row->id == $_SESSION['ready_cust_id'])
													 {
														 $sel ='selected="selected"';
													 }
													echo "<option ".$sel." value='".$company_row->id."'>".$cust_name."</option>";
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
													<th>Sr No</th>
													 
													<th>Proforma Invoice no</th>
													<th>Consignee Name</th>
													<th>Country Name</th>
													<th>Date</th>
													<th>Container Detail Done</th>
													<th>Container Detail Export Done</th>
													<th>Action</th>
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
			 
<div id="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Open Page </h4>
            </div>
            <div class="modal-body">
				<div class="row">
				<div class="col-md-12 row">
										<label class="col-md-2 control-label "><strong class="">Select Page</strong></label>
										 <div class="col-md-10">
											<label class="radio-inline">
												<input type="radio" name="page_status" id="page_status1" value="1"  onclick="open_page(this.value)"  >Basic Detail
											</label>
											<label class="radio-inline">
												<input type="radio" name="page_status" id="page_status2" value="2"  onclick="open_page(this.value)"  >Product/Packing Page 
											</label>
										 	<label class="radio-inline">
												<input type="radio" name="page_status" id="page_status4" value="4"  onclick="open_page(this.value)" >Addition Detail page
											</label>
										 </div>     
									</div>
              </div>
              </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<input type="hidden" name="invoice_id" id="invoice_id" >
            </div>
        </div>
    </div>
</div>

<div id="myModal1" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title set_title"></h4>
            </div>
            <div class="modal-body">
					<div class="col-md-4">					
					   <div class="field-group" >
							<select class="select2" id="size_id" name="size_id"  >
								<option value="">All Product Name</option>
								<?php
								for($p=0;$p<count($allproductsize);$p++)
								{
									 
								 ?>
									<option value="<?=$allproductsize[$p]->product_id?>"><?=$allproductsize[$p]->size_type_cm?></option>
								<?php
								}
								?>
							</select>
						</div> 
					</div> 
					<div class="col-md-4">					
					   <div class="field-group" >
							<select class="select2" id="design_id" name="design_id"  >
								<option value="">All Design</option>
								<?php
								for($p=0;$p<count($alldesign);$p++)
								{
								?>
									<option value="<?=$alldesign[$p]->packing_model_id?>"><?=$alldesign[$p]->model_name?></option>
								<?php
								}
								?>
							</select>
						</div> 
					</div>
					<div class="col-md-4">					
					   <div class="field-group" >
							<select class="select2" id="finish_id" name="finish_id"  >
								<option value="">All Finish</option>
								<?php
								for($p=0;$p<count($allfinish);$p++)
								{
									 
								 ?>
									<option value="<?=$allfinish[$p]->finish_id?>"><?=$allfinish[$p]->finish_name?></option>
								<?php
								}
								?>
							</select>
						</div> 
					</div>
					<div class="col-md-12" style="height:20px;">	</div>
				<div class="productdetailhtml1"></div>
			 
			 </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
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
                <h4 class="modal-title">Company Wise Export Invoice </h4>
            </div>
			 
            <div class="modal-body" style="max-height: 600px;overflow-y: auto;">
                <div class="row">
				 	 
					<div class="col-md-12" id="company_wise_html"> </div>        
				       
				 </div>  			
				</div>
            <div class="modal-footer">
			    <button type="button"  onclick="close_modal()" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			 	 
			 
    </div>
</div>
</div>
 

	 
<?php $this->view('lib/footer'); ?>
<script type="text/javascript">

  
function close_modal()
{
	location.reload();
}
function create_multiple_export_invoice()
{
	var all_supplier_id = [];
	var all_performa_invoice_id = [];
	var container_status = [];
	var no = 1;
		$. each($("input[name='all_supplier_id[]']"), function()
		{
			if($(this).prop("checked") == true)
			{
			 	container_status.push($("#container_status"+no+$(this).val()).val());
				if($.inArray($(this).val(), all_supplier_id) == -1)
				{
					all_supplier_id.push($(this).val());
				}
			}				
			no++;			
		});
	
	var check_len = $("#all_performa_invoice_id").val().split("-").length;
	
	if(check_len > 1)
	{
		 
		if(!!container_status.reduce(function(a, b){ return (a === b) ? a : NaN; }) == true)
		{
			window.location=root+'exportinvoice/mutiplecopy/'+$("#all_performa_invoice_id").val()+'/'+all_supplier_id.join('-')+'/'+container_status[0];	
		}
		else
		{
			window.location=root+'exportinvoice/mutiplecopy/'+$("#all_performa_invoice_id").val()+'/'+all_supplier_id.join('-')+'/3';
		}
		
	}
	else
	{
		
		if(!!container_status.reduce(function(a, b){ return (a === b) ? a : NaN; }) == true)
		{
		 	window.location=root+'exportinvoice/index/'+$("#all_performa_invoice_id").val()+'/'+all_supplier_id.join('-')+'/'+container_status[0];	
		}
		else
		{
		 	window.location=root+'exportinvoice/index/'+$("#all_performa_invoice_id").val()+'/'+all_supplier_id.join('-')+'/3';
		}
		 
	}
}
function create_export_invoice()
{
	var performa_invoice_id = [];
	$. each($("input[name='allperforma_invoice[]']:checked"), function(){
		performa_invoice_id.push($(this). val());
	});
	if(performa_invoice_id.length < 2)
	{
		toastr["error"]("Please select atleast 2 invoice.")
	}
	else
	{
		block_page();
		$.ajax({ 
			type: "POST", 
			url: root+'ready_for_export/companywise_print',
			data: {
				"performa_invoice_id"	: performa_invoice_id
			}, 
			cache: false, 
			success: function (data)
			{ 
					var obj = JSON.parse(data);
					 
					if(obj.res==1)
					{
							$("#printModal").modal({
								backdrop: 'static',
								keyboard: false
							});
							$("#company_wise_html").html(obj.html);
							var checkbox = document.getElementsByName('all_supplier_id[]');
								var ln = checkbox.length;
								 
								if(ln > 1)
								{
									$(".export_sup_btn").show()
								}
								else
								{
									$(".export_sup_btn").hide()
								}
					}
					else
					{
						toastr["error"]("Consignee name are different. Allow only for same consignee.")
					}	
			
					unblock_page('',"")
			}
		});
	}
}
function company_wise_print(performa_invoice_id)
{
	block_page();
	var performa_invoice_array = [];
	performa_invoice_array.push(performa_invoice_id);
	 $.ajax({ 
           type: "POST", 
           url: root+'ready_for_export/companywise_print',
           data: {
             "performa_invoice_id"	: performa_invoice_array
           }, 
           cache: false, 
           success: function (data) { 
			var obj = JSON.parse(data);	 
			$("#printModal").modal({
				backdrop: 'static',
				keyboard: false
			});
		 
			$("#company_wise_html").html(obj.html);
				unblock_page('',"")
           }
	 });
}
$(".select2").select2({
	width:'100%'
});
function confirm_pi(id)
{
	Swal.fire({
  title: 'You want to confirm PI?',
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
              url: root+'invoice_listing/confirmpi',
              data: {
                "id": id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
				 	unblock_page('success',"PI Successfully confirmed");
					setTimeout(function(){ window.location=root+'invoice_listing'; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
		 }
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
 
$(document).ready(function (){
	 
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
			"aaSorting": [[0]],         
            "aoColumns": [
                 { "bSortable": false },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": false },
                { "bSortable": false },
                { "bSortable": false }
            ],   
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
					"sInfo":"",
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			"iDisplayLength": 50,
			"sAjaxSource": root+'exportinvoice_completed/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "cust_id" , "value" :  $("#cust_id"). val()},{ "name" : "date" , "value" :  $("#daterange"). val()} );
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
				var checkbox = document.getElementsByName('allperforma_invoice[]');
					var ln = checkbox.length;
					
					if(ln > 1)
					{
						$(".export_btn").show()
					}
					else
					{
						$(".export_btn").hide()
					}
			}
		});

		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
		
}
function delete_record(product_size_id)
{
	main_delete(product_size_id,'invoice_listing/deleterecord','invoice_listing')
}
function open_page(value)
{
	if(value==1)
	{
		window.location = root+"invoice/form_edit/"+$("#invoice_id").val();
	}
	else if(value==2)
	{
		window.location = root+"product/index/"+$("#invoice_id").val();
	}
	else if(value==4)
	{
		window.location = root+"addition_details/index/"+$("#invoice_id").val();
	}
}
function view_detail(id)
{
  $('#myModal').modal({
			backdrop: 'static',
			keyboard: false
		});
    $("#invoice_id").val(id)  
   
}
function loaded_size(performa_invoice_id,html,url)
{
	block_page();
	 $.ajax({ 
              type: "POST", 
              url: root+url,
              data: {
                "performa_invoice_id"	: performa_invoice_id,
                "size_id"				: $("#size_id").val(),
                "finish_id"				: $("#finish_id").val(),
                "design_id"				: $("#design_id").val()
              }, 
              cache: false, 
              success: function (data) 
			  { 
					 $(".set_title").html(html);
					 $("#size_id").attr("onchange","loaded_size("+performa_invoice_id+",'"+html+"','"+url+"')");
					 $("#finish_id").attr("onchange","loaded_size("+performa_invoice_id+",'"+html+"','"+url+"')");
					 $("#design_id").attr("onchange","loaded_size("+performa_invoice_id+",'"+html+"','"+url+"')");
					 
					 $(".productdetailhtml1").html(data);
					 $("#myModal1").modal('show')
					unblock_page("","");
              }
			});
}
</script>