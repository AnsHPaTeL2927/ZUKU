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
            <li> <i class="clip-pencil"></i> <a href="<?=base_url()?>dashboard"> Dashboard </a> </li>
            <li class="active"> Shiping Bill MASTER </li>
          </ol>
          <div class="page-header">
            <h3> Shiping Bill MASTER </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-external-link-square"></i> Shiping Bill MASTER
              <?php
									//print_r('<pre>');
									//print_r($invoice);
									?>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="sample-table-1">
                  <thead>
                    <tr>
                      <th>Sr No</th>
                      <th>Export Invoice No</th>
                      <th>Shipping Bill No</th>
                      <th>Shipping Bill Date</th>
                      <th>Drawback Amount</th>
                      <th>Payment Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
										$m=1;
											for($i=0; $i<count($result);$i++)
											{
												 
											?>
                    <tr>
                      <td><?=$m?></td>
                      <td><?=$invoice[$i][0]->export_invoice_no?></td>
                      <td><?=$result[$i]->Shipping_Bill_no?></td>
                      <td><?=date('d/m/Y',strtotime($result[$i]->date))?></td>
                      <td><?=$result[$i]->drawback_amount?></td>
                      <td><? if($result[$i]->Payment_of_drawback == '') { echo '<strong style="color:red">Pending</strong>'; } else { echo '<strong style="color:green">Received</strong>'; } ?></td>
                      <td><div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li> <a class="tooltips" data-title="Edit" href="<?=base_url().'shiping_bill/form_edit/'.$result[$i]->export_invoice_id.'/'.$result[$i]->id?>" ><i class="fa fa-pencil"></i>Edit</a> </li>
                            <li> <a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_product(<?=$result[$i]->id?>);"><i class="fa fa-pencil"></i> Add Drawback Payment</a> </li>
                          </ul>
                        </div></td>
                    </tr>
                    <?php
											$m++;
										} ?>
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
<?php $this->view('lib/footer'); ?>
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Add Payment </h4>
      </div>
      <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-12 control-label" for="form-field-1"> Received Drawback Amount in bank </label>
            <div class="col-sm-12">
              <input type="text" name="Payment_of_drawback_received"  id="Payment_of_drawback_received" class="form-control " autocomplete="off"  placeholder="Received Drawback Amount in bank"  title="Received Drawback Amount in bank"/>
            </div>
          </div>
          <div class="form-group">
            <label class="col-sm-12 control-label" for="form-field-1"> Payment Received Date </label>
            <div class="col-sm-12">
              <input type="text" name="received_date" id="received_date" class="form-control defualt-date-picker" autocomplete="off"  placeholder="Payment Received Date"  title="Payment Received Date"/>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button name="Submit" type="submit"  class="btn btn-info">Add</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <input type="hidden" name="eid" id="eid" />
        <input type="hidden" name="edit_supplier_id" id="edit_supplier_id" value="<?=$edit_record->id?>" />
      </form>
    </div>
  </div>
</div>
<script>
$('.defualt-date-picker').datepicker({
	autoclose:true,
	format:'dd-mm-yyyy',
	
});
$(document).ready(function () {
	$('#sample-table-1').DataTable({
	   "order": [[ 0, "asc" ]],
	   "lengthMenu": [ 50, 10, 25, 75, 100 ],
	   'columnDefs': [
		{
			"targets": 0, // your case first column
			"className": "text-center",
			"width": "4%"
		}]
	});
});
 
function delete_record(deleleid)
{
	main_delete(deleleid,'cha_master/deleterecord','cha_master')
}
$("#model_add").validate({
		rules: {
			model_name: {
				required: true
			}
		},
		messages: {
			model_name: {
				required: "Enter Model Name"
			}
		}
	});

	$("#edit_form").validate({
		rules: {
			edit_model_name: {
				required: true
			}
		},
		messages: {
			edit_model_name: {
				required: "Enter Model Name"
			}
		}
	});

$("#model_add").submit(function(event) {
	event.preventDefault();
	if(!$("#model_add").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url: 	root+'Model_list/manage',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			   {
				   $("#model_add").trigger('reset');
				   $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Inserted.");
					 setTimeout(function(){ window.location=root+'model_list' },1500);
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
            url: 	root+'shiping_bill/edit_record',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				if(obj.res==1)
			   {
				    $("#myModal").modal('hide');
				   $("#edit_form").trigger('reset');
				  // $(".select2").select2('val','');
				    unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'shiping_bill' },1500);
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

function edit_product(packing_model_id)
{

	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"shiping_bill/fetchmodeldata",
              data: {"id": packing_model_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				   var d = obj.date.slice(0, 10).split('-');   
					var date =	d[2] +'/'+ d[1] +'/'+ d[0];
				
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(packing_model_id);
					$("#Payment_of_drawback_received").val(obj.drawback_amount);
					$("#received_date").val(date);
					//$("#edit_product_size_id").select2("val",obj.product_size_id);
					//$("#edit_model_name").val(obj.model_name);
					 
					unblock_page("",""); 
                  }
              
          }); 

}	

</script>