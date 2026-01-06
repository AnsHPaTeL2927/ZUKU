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
			 				<a href="<?=base_url().'qc_list'?>">Qc List</a>
			 			</li>
			 	 	</ol>
			 		<div class="page-header title1">
			 			<h3>
							Qc List
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
										<div class="panel-body" style="padding-left:0px;">
									 
										<div class="col-md-4">
										<label class="col-md-4 control-label" style="margin-top:5px;"><strong class=""> Select Date</strong></label>
										 <div class="col-md-8">
										<?php 
											$year = date('n') > 3 ? date('01-04-Y').' - '.(date('31-03-Y',strtotime("+1 year"))) : (date('01-04-Y',strtotime("-1 year"))).' - '.date('31-03-Y');
											
											$invoicedate = explode(" - ",$year);
									 	 ?> 
												<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data()" /> 
												<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
												<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
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
													echo "<option   value='".$company_row->id."'>".$cust_name."</option>";
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
												 	<th>Producation no</th>
													<th>Consigne name</th>
													<th>Suppier Name</th>
												 	<th>Po Date</th>
													<th>Approx Date</th>
													<th>No Of Container</th>
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

<script>
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
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
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
$(document).ready(function () {
	load_data();	
});
 function load_data()
 {
	  var rows_selected = [];
	  datatable = $("#datatable").dataTable({
				"bAutoWidth" : false,
				"bFilter" : true,
				"bSort" : true,
				"aaSorting": [[0]],         
            "aoColumns": [
                 { "bSortable": true  },
                 { "bSortable": true  },
                 { "bSortable": true  },
                 { "bSortable": true  },
                 { "bSortable": true  },
                 { "bSortable": true  },
                 { "bSortable": true  },
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
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'qc_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "cust_id" , "value" :  $("#cust_id"). val()},{ "name" : "date" , "value" :  $("#daterange"). val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
				var productionmst_id = $("#production_mst_id").val().split(",");
				for(var i = 0; i<productionmst_id.length; i++)
				{
					$("#allproduction_mst_id"+productionmst_id[i]).prop("checked",true)
				}
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
 }
  
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
 