<?php 
$this->view('lib/header'); 
$boxleftdata 	= ($getdispatchdata->boxes - $row->boxes);
?>	
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
         rel = "stylesheet">
      <script src = "https://code.jquery.com/jquery-1.10.2.js"></script>
      <script src = "https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
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
							Order Sheet List 
						</li>
						
					</ol>
					<div class="page-header">
						<!--<h3>
							Agent 
							<a href="<?php echo base_url('agentmaster'); ?>" style="float:right;" type="button" class="btn btn-info">
							+ Add New Agent  
							</a>
						</h3>-->
											 <div class="pull-right form-group">
									<div class="col-sm-4">
									
											<!--<a class="btn btn-info pull-right" href="<?=base_url()?>producation_list" >Producation List</a>-->
											<a href="<?php echo base_url('order_sheet'.$producation_id->producation_id); ?>" type="button" class="btn btn-info">
														Order Sheet
												</a>
											
										</div>	
									</div>
					</div>
			</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="panel panel-default">
						<div class="panel-heading">
							<i class="fa fa-external-link-square"></i>
						Order Sheet List 
						</div>
						<div class="panel-body">
						<div class="col-md-12">
							<input type="hidden" name="producation_id" id="producation_id" value="<?=$producation_id->producation_id?>" />			
								<!--<div class="col-md-4">
								
									<label class="col-md-4 control-label" style="margin-top: 5px;"><strong class=""> Select Size</strong></label>
										<div class="col-md-6">
											<select class="select2" name="size_id" id="size_id" onchange="load_data_table()">
												<option value="">All Size</option>
												<?php
													foreach($allperforma_size as $size_id)
													{
														echo '<option value="'.$size_id->product_id.'">'.$size_id->size_type_mm.' - '.$size_id->thickness.' MM</option>';
													}
												?>
											</select>
										</div>    
										
								</div>-->
								
								
								</div>
							<div class="table-responsive">
								<table class="table table-bordered table-hover" id="datatable">
									<thead>
										<tr>
										
											<th>Sr No</th>
											<th>Producation Date</th>
											<th>Customer Name</th>
											<th>Box Design Name</th>
											<th>Size</th>
											<th>Design</th>
											<th>Finish</th>
											<th>Producation Box</th>
											<th>Batch No</th>
											<th>Shade No</th>
										
									
											<th><a class="tooltips btn btn-primary" data-toggle="tooltip" data-title="ADD PRODUCTION" href="javascript:;" onclick="add_multiple_producation(<?=$row->producation_id?>)"><i class="fa fa-plus"></i> </a>Action</th>
											
										</tr>
									</thead>
									<tbody>
									
												
									</tbody>
									 <tfoot>
									   <tr>
									 	<th colspan="4" class="text-right">Total</th>
									 	<th></th>
									 	<th></th>
									 	<th></th>
									 	<th></th>
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
<div id="myModal" name="myModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
			
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			
                <h4 class="modal-title">  Order Sheet Edit </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
			 
			 	<input type="hidden" placeholder="id" id="pro_id" class="form-control" name="pro_id" value="<?php echo $row->producation_id; ?>" autocomplete="off" >
				
				<div class="modal-body">
				
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Producation Date:
						</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Producation Date" id="edit_producation_date" 
							class="form-control defualt-date-picker" name="edit_producation_date"  autocomplete="off" value=""  >
						</div>
					</div>
					
				
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Select Customer Name
						</label>
						<div class="col-sm-12">
							<select class="select2" name="edit_customer_name" id="edit_customer_name" >
								<option value="" >Select Customer </option>
								<?php
								for($p=0;$p<count($customerdata);$p++)
								{ 
									echo "<option value='".$customerdata[$p]->id."'> ".$customerdata[$p]->c_name." </option>";
								}
								?>
							</select>
							
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Select Box Design Name 
						</label>
						<div class="col-sm-12">
							<select class="select2" name="edit_box_design_name" id="edit_box_design_name" >
								<option value="" >Select Box Design </option>
								<?php
								for($p=0;$p<count($boxdesigndata);$p++)
								{ 
									echo "<option value='".$boxdesigndata[$p]->box_design_id."'> ".$boxdesigndata[$p]->box_design_name." </option>";
								}
								?>
							</select>
							
						</div>
					</div>
											
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Size:
						</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Size" id="edit_size" class="form-control" name="edit_size"  autocomplete="off" value=""  >
						</div>
					</div>	
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Design:
						</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Design Name" id="edit_design_name" class="form-control" name="edit_design_name"  autocomplete="off" value=""  >
						</div>
					</div>	
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Finish:
						</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Size" id="edit_finish" class="form-control" name="edit_finish"  autocomplete="off" value=""  >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Producation Box:
						</label>
						<div class="col-sm-12">
							<input type="text"  placeholder="Box" id="edit_producation_box" class="form-control" name="edit_producation_box"  autocomplete="off" value=""  >
						</div>
					</div>
					
					<div class="form-group one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">
							Batch No:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Batch No" id="edit_batch_no" class="form-control" name="edit_batch_no" >
						</div>
					</div>
					
					
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Shade No:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Shade No" id="edit_shade_no" class="form-control" name="edit_shade_no" value="" autocomplete="off" >
							
						</div>
					</div>
					
					
					
					
			   </div>
			   
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			
				<input type="hidden" name="eid" id="eid" />
				<input type="hidden" name="editdocumentmode" id="editdocumentmode" />
				<input type="hidden" name="producation_id1" id="producation_id1" value="<?=$row->producation_id?>" />			
			 </form>
        </div>
    </div>
</div>

<div id="myModal1" name="myModal1" class="modal fade" role="dialog">
    <div class="modal-dialog">
        
        <div class="modal-content">
			
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
			
                <h4 class="modal-title">  Dispatch <?php var_dump($getdispatchdata);?> </h4>
            </div>
			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="dispatch_form" id="dispatch_form">
				<input type="hidden" placeholder="id" id="producation_id_dispatch" class="form-control" name="producation_id_dispatch" value="<?=$result->producation_id?>" autocomplete="off" >
				
				<div class="modal-body">
				
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Dispatch Date:
						</label>
						<div class="col-sm-12">
							<input type="date"  placeholder="Dispatch Date" id="dispatch_date" class="form-control" name="dispatch_date"  autocomplete="off" value=""  >
						</div>
					</div>
					
				
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Select Export Invoice
						</label>
						<div class="col-sm-12">
							<select class="select2" name="export_invoice" id="export_invoice" >
								<option value="" readonly>Select Export Invoice </option>
								<?php
								for($p=0;$p<count($exportinvoicedata);$p++)
								{ 
									echo "<option value='".$exportinvoicedata[$p]->export_invoice_id."'> ".$exportinvoicedata[$p]->export_invoice_no." </option>";
								}
								?>
							</select>
							
						</div>
					</div>
					
					<!--<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Select Customer Name
						</label>
						<div class="col-sm-12">
							<select class="select2" name="customer_name" id="customer_name" disabled>
								<option value="">Select Customer </option>
								<?php
								for($p=0;$p<count($customerdata);$p++)
								{ 
									echo "<option value='".$customerdata[$p]->id."'> ".$customerdata[$p]->c_name." </option>";
								}
								?>
							</select>
							
						</div>
					</div>
					-->
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Customer Name: 
						</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Size" id="customer_name" class="form-control" name="customer_name"  autocomplete="off" value=""  >
						</div>
					</div>	
					
					<div class="form-group">
						<label class="control-label col-sm-12" for="form-field-1">
							Select Box Design Name 
						</label>
						<div class="col-sm-12">
							<select class="select2" name="box_design_name" id="box_design_name" >
								<option value="" >Select Box Design </option>
								<?php
								for($p=0;$p<count($boxdesigndata1);$p++)
								{ 
									echo "<option value='".$boxdesigndata1[$p]->box_design_id."'> ".$boxdesigndata1[$p]->box_design_name." </option>";
								}
								?>
							</select>
							
						</div>
					</div>
											
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Size:
						</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Size" id="size" class="form-control" name="size"  autocomplete="off" value=""  >
						</div>
					</div>	
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Design:
						</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Design Name" id="design_name" class="form-control" name="design_name"  autocomplete="off" value=""  >
						</div>
					</div>	
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Finish:
						</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Size" id="finish" readonly class="form-control" name="finish"  autocomplete="off" value="" >
						</div>
					</div>
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Producation Box:
						</label>
						<div class="col-sm-12">
							<input type="text"  placeholder="Box" id="producation_box" class="form-control" name="producation_box"  autocomplete="off" value="<?php echo $boxleftdata ?>"  >
						</div>
					</div>
					
					<div class="form-group one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">
							Batch No:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Batch No" id="batch_no" readonly class="form-control" name="batch_no" >
						</div>
					</div>
					
					
					
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">
						Shade No:
						</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Shade No" readonly id="shade_no" class="form-control" name="shade_no" value="" autocomplete="off" >
							
						</div>
					</div>
					
					
					
					
			   </div>
			   
            <div class="modal-footer">
				<button name="Submit" type="submit"  class="btn btn-info">Save</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
			
				<input type="hidden" name="eid1" id="eid1" />
				<input type="hidden" name="editdocumentmode1" id="editdocumentmode1" />
					
			 </form>
        </div>
    </div>
</div>

<div id="addproducationmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button" onclick="reload()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Producation </h4>
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
						
							
					
							<label class="col-sm-12 control-label" for="form-field-1">
							Customer Name: 
							</label>
							<div class="col-sm-12">
								<input type="text" readonly placeholder="Size" id="customer_name" class="form-control" name="customer_name"  autocomplete="off" value=""  >
							</div>
						
						
					
						<label class="control-label col-sm-12" for="form-field-1">
							Select Box Design Name 
						</label>
						<div class="col-sm-12">
							<select class="select2" name="box_design_name" id="box_design_name" >
								<option value="" >Select Box Design </option>
								<?php
								for($p=0;$p<count($boxdesigndata1);$p++)
								{ 
									echo "<option value='".$boxdesigndata1[$p]->box_design_id."'> ".$boxdesigndata1[$p]->box_design_name." </option>";
								}
								?>
							</select>
							
						</div>
					
										
					</div> 
					</div> 
					<!--<div class="col-md-12">					
					   <div class="form-group">
					 	<label class="col-sm-12 control-label" for="form-field-1">
					 		Producation Time
					 	</label>
					 	<div class="col-sm-12">
					 		<input type="text" placeholder="Producation Time" id="producation_time" class="form-control timepicker" name="producation_time" value="<?=date("h:i A")?>" required title="Enter Producation Time">
					 	</div>
					</div> 
					</div> -->
				 	 <div class="col-md-12"> <strong><u>Product Detail</u></strong></div>
				 	 <div class="col-md-12 producation_detail" style="    margin-top: 15px;">  </div>
					 
				 </div>  			
				</div>
            <div class="modal-footer">
					
							
						
					
			<input name="Submit" type="submit" value="Save" id="import_submit_btn" class="btn btn-success"  /> 
                <button type="button"  class="btn btn-default" onclick="reload()" data-dismiss="modal">Close</button>
            </div>
				<input type="hidden" name="import_customer_id" id="import_customer_id" value="<?=$invoicedata->consigne_id?>" />		
				<input type="hidden" name="producation_id" id="producation_id" value="<?=$producation_data->producation_id?>" />			
			</form>
       
    </div>
</div>
</div>

<?php $this->view('lib/footer'); ?>
<script>
   

function reload()
{
	location.reload();
}

$(".select2").select2({
	width:"100%"
});

$('.defualt-date-picker').datepicker({
	 autoclose:true,
	 format:'dd-mm-yyyy',
	 
 });
 
 load_data_table();
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
					// "sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "NO DATA ADDED YET !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"createdRow": function(row, data, dataIndex ) {
		

			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			'columnDefs': [
			{
				"targets": 0, // your case first column
				"className": "text-center",
				"width": "4%"
			}],
			"iDisplayLength": 50,
			"sAjaxSource": root+'Order_sheet_list/fetch_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "size_id" , "value" :  $("#size_id"). val()},{"name" : "finish_id" , "value" :  $("#finish_id"). val()},{ "name": "status", "value": $("#status").val() });
			},
			"fnDrawCallback": function( oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			},
			 "footerCallback": function ( row, data, start, end, display ) {
				  var api = this.api(), data;
					total = api
				 // Total over this page
					pageTotal = api
						.column( 7, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
					  
                    return  parseFloat(a) + parseFloat(b.replace(/(<([^>]+)>)/gi, "").replace(new RegExp(',', 'g'),""));
                }, 0 );
				
				 // Update footer
            
			 $( api.column( 7 ).footer() ).html(
                 numberWithCommas(pageTotal.toFixed(2))
            );
			 }
		});
		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');
}

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
	var id = [];
	var box_design_id = [];
	var product_id = [];
	var design_id = [];
	var finish_id = [];
	var packing_model_id = [];
	var boxes = [];
	 
	block_page();
	for(var i=0;i < allproductation_entry_id.length;i++)
	{
		var value_array =  allproductation_entry_id[i].split("-")
		id.push(value_array[0]);
		box_design_id.push(value_array[1]);
		product_id.push(value_array[2]);
		design_id.push(value_array[3]);
		finish_id.push(value_array[4]);
		packing_model_id.push(value_array[5]);
		boxes.push(value_array[7]);
	}
     $.ajax({ 
              type: "POST", 
              url: root+"Order_sheet_list/manage",
              data: {
				  "id"				 : id,
				  "box_design_id" 	 : box_design_id,
				  "product_id" 	 	 : product_id,
				  "design_id" 		 : design_id,
				  "finish_id" 		 : finish_id,
				  "packing_model_id" : packing_model_id,
				  "boxes"		 	 : boxes
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

// for update
	$("#edit_form").submit(function(event) {
	event.preventDefault();
	if(!$("#edit_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Order_sheet_list/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#edit_batch_no").val() == obj.editdocumentmode)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				  
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Order_sheet_list' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#company_document_form").trigger('reset');
					$(".select2").select2('val','');
				    
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

// edit form hover
function edit_product(id)
{
	block_page();
	
     $.ajax({ 
              type: "POST", 
              url: root+"Order_sheet_list/fetchsheetdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
									
					 $("#edit_producation_date").val(obj.producation_date); 
					 
				
					 
					  
					 $("#edit_customer_name").append("<option value='"+obj.id+"'>"+obj.c_name+"</option>") 
					 $("#edit_customer_name").val(obj.id).trigger('change') 
					 $("#editdocumentmode").val(obj.id);
					 
					 
					 $("#edit_box_design_name").append("<option value='"+obj.box_design_id+"'>"+obj.box_design_name+"</option>") 
					 $("#edit_box_design_name").val(obj.box_design_id).trigger('change') 
					 $("#editdocumentmode").val(obj.box_design_id); 
										
					 
					 $("#edit_size").val(obj.size_type_mm); 
					 
					  $("#edit_design_name").val(obj.model_name);
					 
					 $("#edit_finish").val(obj.finish_name);

					 $("#edit_producation_box").val(obj.boxes);
				
					 $("#edit_shade_no").val(obj.shade_no);
					 
					 $("#edit_batch_no").val(obj.batch_no);
					 
									 
					 //$("#editdocumentmode").val(obj.shade_no);
				 	unblock_page("",""); 
                  }
              
          }); 

}
	
//dispatch form	
	$("#dispatch_form").submit(function(event) {
	event.preventDefault();
	if(!$(dispatch_form).valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Order_sheet_list/manage1',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1 || $("#batch_no").val() == obj.editdocumentmode1)
			   {
				    $("#myModal1").modal('hide');
				   $("#dispatch_form").trigger('reset');
				  
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'Order_sheet_list' },1500);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Record already exist");
					//$("#company_document_form").trigger('reset');
					$(".select2").select2('val','');
				    
				}
			   else
			   {
				    unblock_page("error","Something Wrong.") 
				   
			   }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

// Dispatch form hover
function dispatch_data(id)
{
	block_page();
	
     $.ajax({ 
              type: "POST", 
              url: root+"Order_sheet_list/fetchsheetdata",
              data: {"id": id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  			
				  
				   $("#myModal1").modal({
						backdrop: 'static',
						keyboard: false
					});
					
					 $("#eid").val(id);
									
					 $("#dispatch_date").val(obj.dispatch_date); 
					 
				
					 
					   $("#customer_name").val(obj.c_name); 
					
					 
					 
					 $("#box_design_name").append("<option value='"+obj.box_design_id+"'>"+obj.box_design_name+"</option>") 
					 $("#box_design_name").val(obj.box_design_id).trigger('change') 
					 $("#editdocumentmode").val(obj.box_design_id); 
										
					 
					
					 
					 $("#size").val(obj.size_type_mm); 
					
					  $("#design_name").val(obj.model_name);
					 
					 $("#finish").val(obj.finish_name);

					 $("#producation_box").val(obj.boxes);
				
					 $("#shade_no").val(obj.shade_no);
					 
					 $("#batch_no").val(obj.batch_no);
					 
									 
					 //$("#editdocumentmode").val(obj.shade_no);
				 	unblock_page("",""); 
                  }
              
          }); 

}

function delete_record(deleleid)
{
	 main_delete(deleleid,'Order_sheet_list/deleterecord','order_sheet_list')
}

  load_order_sheet();
function load_order_sheet()
{
	 
			block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'order_sheet_list/get_order_sheet',
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