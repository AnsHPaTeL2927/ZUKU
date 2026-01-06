<?php  $this->view('lib/header'); ?>	
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
			 				<a href="<?=base_url().'pi_follow_up'?>">PI Follow Up</a>
			 			</li>
			 			 
			 		</ol>
			 		<div class="page-header title1">
			 			<h3><?=$performainvoice_detail->invoice_no?></h3>
			 		</div>
			 	</div>
			 </div>
			 <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">PI Summary   </h3>
					<div class="dropdown pull-right">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Format
										<span class="caret"></span></button>
											<ul class="dropdown-menu">
											 <li>
												<a class="tooltips" data-toggle="tooltip" data-title="PI 1" href="<?=base_url('performa_invoice_pdf/index/'.$performainvoice_detail->performa_invoice_id)?>"><i class="fa fa-file-text-o"></i> PI 1</a>
												<a class="tooltips" data-toggle="tooltip" data-title="PI 2" href="<?=base_url('performa_invoice_pdf/index_withoutfinish/'.$performainvoice_detail->performa_invoice_id)?>"><i class="fa fa-file-text-o"></i> PI 2 (Without Finish)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 3" href="<?=base_url('performa_invoice_pdf/index_withthickness/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 3 (With Thickness)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4 (With Unit)" href="<?=base_url('performa_invoice_pdf1/index/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 4 (With Unit)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="With Image,Without Barcode" href="<?=base_url('performa_invoice_pdf2/index/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 5 (With Image,Without Barcode)</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="PI 4" href="<?=base_url('performa_invoice_pdf3/index/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i> PI 6</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf4/index/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 7</a>
											
												<a class="tooltips" data-toggle="tooltip" data-title="Zuku Format" href="<?=base_url('performa_invoice_pdf6/index/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 8 (Zuku Format)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="Other Product" href="<?=base_url('performa_invoice_pdf7/index/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 9 (With Other Product)</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_accord/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 10</a>
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf/index_olwin/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 11</a>	
												
												<a class="tooltips" data-toggle="tooltip" data-title="View" href="<?=base_url('performa_invoice_pdf11/index/'.$performainvoice_detail->performa_invoice_id)?>" ><i class="fa fa-file-text-o"></i>  PI 12 (Without Pallet)</a>
											 </li>											 
											</ul>
										</div>
             </div>
              <div class="table-responsive">
				<table class="table table-bordered table-hover display" id="datatable" width="100%">
						<thead>
								<tr> 
									<td colspan="4">PI no 	: <strong><?=$performainvoice_detail->invoice_no?></strong></td>
									<td colspan="4">PI Date : <strong><?=date('d/m/Y',strtotime($performainvoice_detail->performa_date))?></strong>	</td>
									 
						 	</tr>
							<tr> 
									<td colspan="4">Port of Loading 	: <strong><?=$performainvoice_detail->port_of_loading?></strong></td>
									<td colspan="4">Port of Discharge : <strong><?=$performainvoice_detail->port_of_discharge?>	</strong></td>
									 
						 	</tr>
							<tr> 
									<td colspan="4">Final Destination 	: <strong><?=$performainvoice_detail->final_destination?></strong></td>
									<td colspan="4">Country of Origin Of Goods : <strong><?=$performainvoice_detail->country_origin_goods?></strong>	</td>
									 
						 	</tr>
							<tr>
							 	<th class="text-center" width="10%">Size</th>
								<th class="text-center" width="10%">Design Name</th>
								<th class="text-center" width="10%">Finish</th>
								<th class="text-center" width="8%">Pallets</th>
								<th class="text-center" width="8%">Boxes</th>
								<th class="text-center" width="10%">SQM</th>
								<th class="text-center" width="10%">Rate / <?=$performainvoice_detail->per_value.' ('.strtoupper($performainvoice_detail->currency_name)?>)</th>
								<th class="text-center" width="10%">Amount </th>
						 	</tr>
						</thead>
						<tbody>
						<?php 
								$Total_plts = 0;
								$Total_box = 0;
								$Total_ammount = 0;
								$Total_pallet_weight =0;
								$total_product_sqmlm=0;
								$total_amount=0;
						for($i=0; $i<count($product_data);$i++)
				{ 
									$Total_plts 	 += $product_data[$i]->total_no_of_pallet;
									 $Total_box 	 += $product_data[$i]->total_no_of_boxes;
									  $Total_ammount += $product_data[$i]->total_product_amt;
				foreach($product_data[$i]->packing  as $packing_row)
				{
					$product_plts = '';
					
					 if($packing_row->no_of_pallet>0)
					{
						$no_of_pallet = $packing_row->no_of_pallet;
					}
					else if($packing_row->no_of_big_pallet > 0 || $packing_row->no_of_small_pallet >0)
					{
					  	$no_of_pallet =  $packing_row->no_of_big_pallet.'<br>'.$packing_row->no_of_small_pallet;
					}
					else
					{
						$no_of_pallet =  '-';
					}
					echo '<tr>
							 	<td class="text-center">'.$product_data[$i]->size_type_mm.'</td>
								<td class="text-center">'.$packing_row->model_name.'</td>
								<td class="text-center">'.$packing_row->finish_name.'</td>
								<td class="text-center">'.$no_of_pallet.'</td>
								<td class="text-center">'.$packing_row->no_of_boxes.'</td>
								<td class="text-center">'.$packing_row->no_of_sqm.'</td>
								<td class="text-center">'.number_format($packing_row->product_rate,2,'.','').'</td>
								<td class="text-center">'.number_format($packing_row->product_amt,2,'.','').'</td>
						 	</tr>';
								$total_product_sqmlm += $packing_row->no_of_sqm;
				}
				echo '<tr>
							  	<th style="text-align:right" colspan="3">Total</th>
								<th class="text-center">'.$Total_plts.'</th>
								<th class="text-center">'.$Total_box.'</th>
								<th class="text-center">'.$total_product_sqmlm.'</th>
								<th class="text-center"> </th>
								<th class="text-center">'.$Total_ammount.'</th>
								 
						 	</tr>';
			}
			?>
						</tbody>
						</table>
			</div>
           </div>
			
        </div>
        
        <div class="col-md-6">
           
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Follow Up</h3>
            </div>
             
            <form class="form-horizontal" name="pi_follow_up" id="pi_follow_up">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-4 control-label">Follow Up Date & Time</label>

                  <div class="col-sm-8">
                    <input type="text" placeholder="Follow Up Date & Time" id="followup_today" class="form-control timepicker" name="followup_today" value="<?=date('d-m-Y h:i A');?>" required title="Select Date" autocomplete="off">
                  </div>
                </div>
				
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Follow Up Source</label>

                  <div class="col-sm-8">
						<select class="select2" name="follow_up_type_id" id="follow_up_type_id">
								<option value="">Select Follow Up Source</option>
								<?php 
								foreach($followup_type as $frow)
								{
									echo "<option value='".$frow->follow_up_type_id."'>".$frow->follow_up_type."</option>";
								}
								?>
							</select>
							<label id="follow_up_type_id-error" class="error" for="follow_up_type_id"></label>
                  </div>
                </div>
				<div class="form-group">
					 	<label class="col-sm-4 control-label" for="form-field-1">
					 		Status
					 	</label>
					 	<div class="col-sm-8">
								<label >
								 <input type="radio" onclick="show_follow_up(this.value)" name="follow_up_status" id="follow_up_status1" value="Follow Up" checked=""> 
										<strong for="follow_up_status1">Follow Up</strong>
								 </label>
								 <label >
								 <input type="radio" onclick="show_follow_up(this.value)" name="follow_up_status" id="follow_up_status2" value="Confirm"> 
										<strong for="follow_up_status2">Confirm</strong>
								 </label>
								<label >
									<input type="radio" onclick="show_follow_up(this.value)" name="follow_up_status" id="follow_up_status3" value="Cancel"> 
										<strong for="follow_up_status3">Cancel</strong>
								</label>
					 	</div>
					</div>
                <div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Remarks</label>
						<div class="col-sm-8">
							<textarea class="form-control" name="remarks" id="remarks" placeholder="Remarks" required title="Enter Remarks"></textarea>
						</div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">
						<span class="date_html">Next Follow Up Date & Time</span>
				  </label>
						<div class="col-sm-8">
							<input type="text" placeholder="Next Follow Up Date & Time" id="follow_date" class="form-control timepicker" name="follow_date" value="" required title="Select Date" autocomplete="off">
						</div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">Select Follow Up By</label>

                  <div class="col-sm-8">
					<select class="select2" name="user_id" id="user_id" required title="Select Follow Up By">
								<option value="">Select Follow Up By</option>
								<?php 
								foreach($alluser as $user_row)
								{
									$sel = '';
									if($user_row->user_id == $this->session->id)
									{
										$sel ='selected="selected"';
									}
									echo "<option ".$sel." value='".$user_row->user_id."'>".$user_row->user_name."</option>";
								}
								?>
							</select>
							<label id="user_id-error" class="error" for="user_id"></label>
                  </div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">
						 Field 1 
				  </label>
						<div class="col-sm-4">
							<input type="text" placeholder="Field 1" id="field_1" class="form-control" name="field_1" value=""   title="Field 1" autocomplete="off">
						</div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">
						 Field 2 
				  </label>
						<div class="col-sm-4">
							<input type="text" placeholder="Field 2" id="field_2" class="form-control" name="field_2" value=""   title="Field 2" autocomplete="off">
						</div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">
						 Field 3 
				  </label>
						<div class="col-sm-4">
							<input type="text" placeholder="Field 3" id="field_3" class="form-control" name="field_3" value=""   title="Field 3" autocomplete="off">
						</div>
                </div>
				<div class="form-group">
                  <label for="inputPassword3" class="col-sm-4 control-label">
						 Field 4 
				  </label>
						<div class="col-sm-4">
							<input type="text" placeholder="Field 4" id="field_4" class="form-control" name="field_4" value=""   title="Field 4" autocomplete="off">
						</div>
                </div>
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                 <input type="hidden" name="performa_invoice_id" id="performa_invoice_id" value="<?=$performainvoice_detail->performa_invoice_id?>"/>
				 <input type="hidden" name="followup_from" id="followup_from" value="1" />
                <button type="submit" class="btn btn-success">Save</button>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
           
        </div>
         <div class="col-md-12">
			<div class="box box-primary">
				<div class="box-header with-border">
					<h3 class="box-title">Follow Up List   </h3>
				</div>
						<div class="table-responsive" style="margin-top:10px">
							<table class="table table-bordered table-hover display" id="datatable1" width="100%">
								<thead>
								<tr>
									<th>Sr no</th>
								 	<th>Follow Up Date</th>
									<th>Follow Up Source</th>
									<th>Follow Up Status</th>
									<th>Next Follow Up Date</th>
									<th>Remarks</th>
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
       
    </section>
		 </div>
	</div>
</div>
<?php 
$this->view('lib/footer');
$this->view('lib/addcountry');
$this->view('lib/addcurrency');
$this->view('lib/addconsigner');
?>

<script>
load_data_table()
function load_data_table()
{ 	

	datatable = $("#datatable1").dataTable({
			"bAutoWidth" : false,
			"bFilter" : true,
			"bSort" : true,
			"aaSorting": [[0]],         
            "aoColumns": [
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": true },
                { "bSortable": false }
            ],   
			"bProcessing": true,
			"searchDelay": 350,
			"bServerSide" : true,
			"bDestroy": true,
			<!--"dom": '<"wrapper"flipt>',
			-->
			"oLanguage": {
					"sLengthMenu": "_MENU_",
					"sProcessing": "<img src='"+root+"adminast/assets/images/loader.gif'/> Loading ...",
					"sEmptyTable": "No Records found in Database - Please add new record using entry form !",
					"sSearch": "",
					"sInfoFiltered":"",
			},
			"aLengthMenu": [[-1,10, 20, 30, 50], ["All",10, 20, 30, 50]],
			"iDisplayLength": 50,
			"sAjaxSource": root+'Pi_follow_up/fetch_followup_record/',
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "performa_invoice_id" , "value" : <?=$performainvoice_detail->performa_invoice_id?>});
			},
			"fnDrawCallback": function(oSettings ) {
				$('.ttip, [data-toggle="tooltip"]').tooltip();
			
					 
			},
			"fnRowCallback": function(nRow, aData, iDisplayIndex, iDisplayIndexFull) {
				if(iDisplayIndex == 0)
				{
					$("#followup_today").val(aData[4])
					
				}
			}			
			  
		});

		//Search input style
		$('.dataTables_filter input').addClass('form-control').attr('placeholder','Search');
		$('.dataTables_length select').addClass('form-control');	
			
}

function  show_follow_up(val)
{
	
	if(val == "Follow Up")
	{
		$(".date_html").html('Next Follow Up Date & Time')
		$("#follow_date").attr('placeholder','Next Follow Up Date & Time')
		//$(".follow_date_html").show()
	}
	else if(val == "Confirm")
	{
		$(".date_html").html('Confirm Date & Time')
		$("#follow_date").attr('placeholder','Confirm Date & Time')
		//$(".follow_date_html").hide()
	}
	else if(val == "Cancel")
	{
		$(".date_html").html('Cancel Date & Time')
		$("#follow_date").attr('placeholder','Cancel Date & Time')
		//$(".follow_date_html").hide()
	}
} 
$(".select2").select2({
	width:"100%"
});
 $('.timepicker').datetimepicker({
       format: "dd-mm-yyyy HH:ii P",
        showMeridian: true,
        autoclose: true,
        todayBtn: true
    });
 
 $("#pi_follow_up").validate({
		rules: {
			follow_up_type_id: {
				required: true
			}
		},
		messages: {
			follow_up_type_id: {
				required: "Select Follow Up Type"
			}
		}
	});
$("#pi_follow_up").submit(function(event) {
	event.preventDefault();
	if(!$("#pi_follow_up").valid())
	{
		return false;
	}
	 block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	 
	 var url = root+'pi_follow_up/manage';
	$.ajax({
            type: "post",
            url: url,
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
					unblock_page("success","Sucessfully Inserted.");
					setTimeout(function(){ location.reload(); },1000);
				}
				else if(obj.res==2)
				{
					unblock_page("info","Already Added.");
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

  
</script>
 
 