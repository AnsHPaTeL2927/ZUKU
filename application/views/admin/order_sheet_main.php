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
							Order Sheet
							 <div class="pull-right form-group">
									<div class="col-sm-4">
											<a class="btn btn-info" href="<?=base_url()?>producation_list" >Producation List</a>
										</div>
									</div>
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
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select Size</strong></label>
										<div class="col-md-6">
											<select class="select2" name="size_id" id="size_id" onchange="load_order_sheet()">
												<option value="">All Size</option>
												<?php
													foreach($allperforma_size as $size_id)
													{
														echo '<option value="'.$size_id->product_id.'">'.$size_id->size_type_mm.' - '.$size_id->thickness.' MM</option>';
													}
												?>
											</select>
										</div>     
								</div>
								<div class="col-md-4">
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select Finish</strong></label>
										<div class="col-md-6">
											<select class="select2" name="finish_id" id="finish_id" onchange="load_order_sheet()">
												<option value="">All Finish</option>
												<?php
													foreach($all_finish_data as $finish_row)
													{
														echo '<option value="'.$finish_row->finish_id.'">'.$finish_row->finish_name.'</option>';
													}
												?>
											</select>
										</div>     
								</div>
								<div class="panel-body">
									<div class="order_sheet" style="margin-top: 70px;"></div>
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
<div id="addproducationmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button" onclick="reload()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Producation </h4>
            </div>
			<form class="form-horizontal askform" action="javascript:;"  method="post" name="producation_form" id="producation_form">
			    <div class="modal-body">
					<div class="row">
					 <div class="col-md-12">					
					   <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Producation Date
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Producation Date" id="producation_date" class="form-control defualt-date-picker" name="producation_date" value="<?=date('d-m-Y')?>" >
					 	</div>
					</div> 
					</div> 
					<div class="col-md-12">					
					   <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Producation Time
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Producation Time" id="producation_time" class="form-control timepicker" name="producation_time" value="<?=date("h:i A")?>" required title="Enter Producation Time">
					 	</div>
					</div> 
					</div> 
				 	 <div class="col-md-12"> <strong><u>Product Detail</u></strong></div>
				 	 <div class="col-md-12 producation_detail" style="    margin-top: 15px;">  </div>
					 
				 </div>  			
				</div>
            <div class="modal-footer">
			<input name="Submit" type="submit" value="Save" id="import_submit_btn" class="btn btn-success"  /> 
                <button type="button"  class="btn btn-default" onclick="reload()" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="import_customer_id" id="import_customer_id" value="<?=$invoicedata->consigne_id?>" />			
			</form>
       
    </div>
</div>
</div>

<script>
$(".select2").select2({
	width:"100%"
});
$("#producation_form").validate({
		rules: {
			producation_date: {
				required: true
			} 
		},
		messages: {
			producation_date: {
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
	var producation_box = [];
	 
		
		$. each($("input[name='producation_box[]']"), function(){
				producation_box.push($(this).val());
		});
		for(var i=0;i < producation_box.length;i++)
		{
			if(producation_box[i] < 0 || producation_box[i] == "")
			{
				toastr["error"]("Please enter Box");
				$("#producation_box"+i).focus();
				return false;
			}
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
					 load_order_sheet()
			   }
			 else if(obj.res==2)
			   {
				   $("#producation_form").trigger('reset');
				    unblock_page("success","Sucessfully Updated.");
					 $("#addproducationmodal").modal('hide');
					 load_order_sheet()
			   }
			    $("#productid").val('').trigger('change');
			  
				 	
			  
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

function reload()
{
	location.reload();
}
 $('.timepicker').datetimepicker({
      format: 'HH:ii P',
	  autoclose: false,
      showMeridian: true,
      startView: 1,
      maxView: 1,
	  sideBySide: true,
		 
    });
	 
$('.datetimepicker-hours thead').attr('style', 'display:none;');
$('.datetimepicker-hours table').attr('style', 'width:100%');
$('.datetimepicker-minutes thead').attr('style', 'display:none;');
$('.datetimepicker-minutes table').attr('style', 'width:100%');
function add_multiple_producation()
{
	var allproductation_entry_id = [];
	$. each($("input[name='allproductation_entry_id[]']:checked"), function(){
		allproductation_entry_id.push($(this).val());
	});
	if(allproductation_entry_id.length == 0)
	{
		toastr["error"]("Please Select atleast 1 design for production entry");
		return false;
	}
	var product_id = [];
	var packing_model_id = [];
	var finish_id = [];
	var order_boxes = [];
	var production_boxes = [];
	var pending_box = [];
	 
	block_page();
	for(var i=0;i < allproductation_entry_id.length;i++)
	{
		var value_array =  allproductation_entry_id[i].split("-")
		product_id.push(value_array[0]);
		packing_model_id.push(value_array[1]);
		finish_id.push(value_array[2]);
		order_boxes.push(value_array[3]);
		production_boxes.push(value_array[4]);
		pending_box.push(value_array[5]);
	}
     $.ajax({ 
              type: "POST", 
              url: root+"order_sheet/add_producation",
              data: {
				  "product_id"		 : product_id,
				  "packing_model_id" : packing_model_id,
				  "order_boxes" 	 : order_boxes,
				  "production_boxes" : production_boxes,
				  "pending_box" 	 : pending_box,
				  "finish_id"		 : finish_id
				  }, 
              success: function (response) { 
                   
				   $("#addproducationmodal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 
					 $(".producation_detail").html(response);
					unblock_page("",""); 
                  }
              
          }); 
}
function add_producation(product_id,packing_model_id,finish_id,order_boxes,production_boxes,pending_box)
{
	block_page();
	var productid = [];
	var packing_modelid = [];
	var finishid = [];
	var productionboxes = [];
	var orderboxes = [];
	var pendingbox = [];
	 	productid.push(product_id);
		packing_modelid.push(packing_model_id);
		finishid.push(finish_id);
		orderboxes.push(order_boxes);
		productionboxes.push(production_boxes);
		pendingbox.push(pending_box);
     $.ajax({ 
              type: "POST", 
              url: root+"order_sheet/add_producation",
              data: {
				  "product_id"		 : productid,
				  "packing_model_id" : packing_modelid,
				  "order_boxes" 	 : orderboxes,
				  "production_boxes" : productionboxes,
				  "pending_box"		 : pendingbox,
				  "finish_id"		 : finishid
				  }, 
              success: function (response) { 
                   
				   $("#addproducationmodal").modal({
						backdrop: 'static',
						keyboard: false
					});
					 
					 $(".producation_detail").html(response);
					unblock_page("",""); 
                  }
              
          }); 
}	
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
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'producation_detail/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "invoice_status" , "value" :  $("input[name='invoice_status']:checked"). val()},{ "name" : "date" , "value" :  $("#daterange"). val()},{ "name" : "finish_id" , "value" :  $("#finish_id"). val()});
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			}
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
 }

    load_order_sheet();
 function load_order_sheet()
{
	 
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'order_sheet/get_order_sheet',
              data: {
                "size"		: $("#size_id").val(),
                "finish_id"	: $("#finish_id").val()
              }, 
              cache: false, 
              success: function (data) { 
				 
					$(".order_sheet").html(data);
					$(".tooltips").tooltip()
				 	unblock_page('',"");
					 
				 
                
              }
			});
		 
}
</script>
 