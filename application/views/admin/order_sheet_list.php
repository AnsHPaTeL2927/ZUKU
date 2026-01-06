<?php 
$this->view('lib/header');
$boxleftdata 	= ($getdispatchdata->boxes - $row->boxes);
?>	
<link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel = "stylesheet">
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
							<a href="<?=base_url()?>dashboard">Dashboard</a>
						</li>
						<li class="active">Order Sheet List</li>
					</ol>
					<div class="page-header">
						<h3>
							Stock 							
						</h3>

					<div class="pull-right form-group">
									<div class="col-sm-4">											<!--<a class="btn btn-info pull-right" href="<?=base_url()?>producation_list" >Producation List</a>-->
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
									<caption>
										<div class="col-sm-2">
											<select class="form-control" id="search_customer" onchange="load_data_table()">
												<option value="All" >All Customer</option>
												<?php
												for($sc=0;$sc<count($dispatch_customerdata);$sc++)
												{ 
													$selected_customer = $_SESSION['search_customers'] == $dispatch_customerdata[$sc]->id ? 'selected' : '';
													echo "<option $selected_customer value='".$dispatch_customerdata[$sc]->id."'> ".$dispatch_customerdata[$sc]->c_companyname." </option>";
												}
												?>
											</select>
										</div>
										<div class="col-sm-2">
											<select class="form-control" id="search_size" onchange="load_data_table()">
												<option value="All" >All Size</option>	
												<?php
													foreach($allperforma_size as $size_id)
													{
														$selected_size = $_SESSION['search_size'] == $size_id->product_id ? "selected" : "";
														echo '<option '.$selected_size.' value="'.$size_id->product_id.'">'.$size_id->size_type_mm.' - '.$size_id->thickness.' MM</option>';
													}
												?>								
											</select>
										</div>
										<div class="col-sm-2">
											<select class="form-control" id="search_finish" onchange="load_data_table()" >
												<option value="All" >All Finish</option>
												<?php
													foreach($all_finish_data as $finish_val)
													{
														$selected_finish = $_SESSION['search_finish'] == $finish_val->finish_id ? "selected" : "";
														echo '<option '.$selected_finish.' value="'.$finish_val->finish_id.'">'.$finish_val->finish_name.'</option>';
													}
												?>									
											</select>
										</div>
										<div class="col-sm-3">
										<?php 										
											if($_SESSION['search_date'])
											{
												$invoicedate = explode(" - ",$_SESSION['search_date']);
											}else{
												$year = date('n') > 3 ? date('01/04/Y').' - '.(date('31/03/Y',strtotime("+1 year"))) : (date('01/04/Y',strtotime("-1 year"))).' - '.date('31/03/Y');
												$invoicedate = explode(" - ",$year);
											}											
										?>
										<input type="text" name="daterange" id="daterange" class="form-control" value="<?=$year?>" onchange="load_data_table()"/> 
										<input type="hidden" id="s_date" class="form-control" value="<?=$invoicedate[0]?>">
										<input type="hidden" id="e_date" class="form-control" value="<?=$invoicedate[1]?>">
										</div>

										<label style="margin-top: 5px; float: right;" > <a href="javascript:void(0)" onclick="get_bulkdispatch_data()" type="button" class="btn btn-primary btn-sm">Multiple Dispatch</a> <input type="checkbox" onclick="$('.bulkdispatch').prop('checked', this.checked)"> Select All</label></caption>
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
											<th>Dispatch Box</th>
											<th>Batch No</th>
											<th>Shade No</th>
											<th>
												<a class="tooltips btn btn-primary" data-toggle="tooltip" data-title="ADD PRODUCTION" href="javascript:;" onclick="add_multiple_producation(<?=$row->producation_id?>)"><i class="fa fa-pencil"></i> </a> Action 
											</th>											
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
									echo "<option value='".$customerdata[$p]->id."'> ".$customerdata[$p]->c_companyname." </option>";
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

					<div class="form-group row">
						<div class="col-sm-6">
							<label class="control-label" for="edit_batch_no">Batch No:</label>
							<input type="text" placeholder="Batch No" id="edit_batch_no" class="form-control" name="edit_batch_no" >
						</div>
						<div class="col-sm-6">
							<label class="control-label" for="">Shade No:</label>
							<input type="text" placeholder="Shade No" id="edit_shade_no" class="form-control" name="edit_shade_no" value="" autocomplete="off" >
						</div>						
					</div>
					
					<div class="form-group row">						
						<div class="col-sm-6">
							<label class="control-label" for="edit_big_pallet_box">Big Pallet Box:</label>
							<input type="text" placeholder="Big Pallet" id="edit_big_pallet_box" class="form-control" name="edit_big_pallet_box" value="" autocomplete="off">
						</div>
						<div class="col-sm-6">
							<label class="control-label" for="form-field-1">Big Pallet:</label>
							<input type="text" placeholder="Big Pallet" id="edit_big_pallet" class="form-control" name="edit_big_pallet" value="" autocomplete="off" >
						</div>
					</div>
					
					<div class="form-group row">
						<div class="col-sm-6">
							<label class="control-label" for="edit_small_pallet">Small Pallet Box:</label>
							<input type="text" placeholder="Small Pallet" id="edit_small_pallet_box" class="form-control" name="edit_small_pallet_box" value="" autocomplete="off" >
						</div>
						<div class="col-sm-6">
							<label class="control-label" for="edit_small_pallet">Small Pallet:</label>
							<input type="text" placeholder="Small Pallet" id="edit_small_pallet" class="form-control" name="edit_small_pallet" value="" autocomplete="off" >
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


<!-- PDP -->
<div id="myModal1" name="myModal1" class="modal fade" role="dialog">

    <div class="modal-dialog">        

        <div class="modal-content">			

            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">&times;</button>			

                <h4 class="modal-title">  Dispatch </h4>

            </div>

			 <form class="form-horizontal askform" action="javascript:;"  method="post" name="dispatch_form" id="dispatch_form">

				<input type="hidden" placeholder="id" id="producation_id_dispatch" class="form-control" name="producation_id_dispatch" value="" autocomplete="off" >			

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
						<label class="control-label col-sm-12 " for="form-field-1">Size:</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Size" id="size" class="form-control" name="size"  autocomplete="off" value=""  >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">Design:</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Design Name" id="design_name" class="form-control" name="design_name"  autocomplete="off" value=""  >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">Finish:</label>
						<div class="col-sm-12">
							<input type="text" readonly placeholder="Size" id="finish" readonly class="form-control" name="finish"  autocomplete="off" value="" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">Producation Box:</label>
						<div class="col-sm-12">
							<input type="number" placeholder="Box" step="1" id="producation_box"
							 max="" min="0" onkeyup="imposeMinMax(this)" class="form-control probox" name="producation_box"  autocomplete="off" value="0" required>
						</div>
					</div>
					<div class="form-group one_by_one">
						<div class="col-sm-6">
							<label class="control-label">Big Pallet Box:</label>
							<input type="number" placeholder="Big Pallet Box" id="big_pallet_box"  onkeyup="imposeMinMax(this)"  class="form-control probox" name="big_pallet_box" value="" max="" min="0" autocomplete="off" >
						</div>
						<div class="col-sm-6">
							<label class="control-label">Big Pallet:</label>
							<input type="number" placeholder="Big Pallet" id="big_pallet"  onkeyup="imposeMinMax(this)"  class="form-control probox" name="big_pallet" value="" max="" min="0" autocomplete="off" >
						</div>
					</div>
					<div class="form-group one_by_one">
						<div class="col-sm-6">
							<label class="control-label">Small Pallet Box:</label>						
							<input type="number" placeholder="Small Pallet Box" id="small_pallet_box" onkeyup="imposeMinMax(this)"  class="form-control probox" name="small_pallet_box" max="" min="0" value="" autocomplete="off" >
						</div>					
						<div class="col-sm-6">
							<label class="control-label">Small Pallet:</label>						
							<input type="number" placeholder="Small Pallet" id="small_pallet" onkeyup="imposeMinMax(this)"  class="form-control probox" name="small_pallet" value="" max="" min="0" autocomplete="off" >
						</div>
					</div>
					<div class="form-group one_by_one">
						<label class="col-sm-12 control-label" for="form-field-1">Batch No:</label>
						<div class="col-sm-12">
							<input type="text" placeholder="Batch No" id="batch_no" readonly class="form-control" name="batch_no" >
						</div>
					</div>
					<div class="form-group">
						<label class="control-label col-sm-12 " for="form-field-1">Shade No:</label>
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

				<input type="hidden" name="product_id" id="dis_product_id" value="" />				
				<input type="hidden" name="finish_id" id="dis_finish_id" value="" />
				<input type="hidden" name="packing_model_id" id="dis_packing_model_id" value="" />
				<input type="hidden" name="customer_id" id="dis_customer_id" value="" />	
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

<!-- Start Bulk Dispatch Modal -->
<div id="dispatch_producation_formmodal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content"  style="max-height: 600px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button" onclick="reload()"  class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Dispatch Bulk Producation</h4>
            </div>
            <form class="form-horizontal" action="javascript:;"  method="post" name="dispatch_producation_form" id="dispatch_producation_form">
                <div class="modal-body">
                    <div class="row">
                     <div class="col-md-12">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="form-field-1">
	                            Dispatch Date
	                        </label>
	                        <div class="col-sm-3">
	                            <input type="text" placeholder="Producation Date" id="bulk_dispatch_date" class="form-control defualt-date-picker" name="bulk_dispatch_date" value="<?=date('d-m-Y')?>" >
	                        </div>	                        
	                        <div class="col-sm-3">
	                        	<select class="select2" name="export_invoice" required>
								<option value="">Select Export Invoice</option>
								<?php
								for($inv=0;$inv<count($exportinvoicedata);$inv++)								{ 
									echo "<option value='".$exportinvoicedata[$inv]->export_invoice_id."'> ".$exportinvoicedata[$inv]->export_invoice_no." </option>";
								}
								?>
							</select>
	                        </div>                        
                        </div> 
                    </div>                    
                    <div class="col-md-12"> <strong><u>Product Detail</u></strong></div>
                    <div class="col-md-12 table-responsive">
                    	<table class="table table-bordered table-hover">
                    		<thead>
                    			<tr>
                    			<th>Customer Name</th>
                    			<th>Box Design Name</th>
                    			<th>Size</th>
                    			<th>Design</th>
                    			<th>Finish</th>
                    			<th>Producation Box</th>
                    			<th>Dispatch Box</th>
                    			<th>Big Pallet Box</th>
                    			<th>Big Pallet</th>
								<th>Small Pallet Box</th>
								<th>Small Pallet</th>
								<th>Batch No</th>
                    			<th>Shade No</th>
                    		</tr>
                    		</thead>
                    		<tbody id="appendrows"></tbody>
                    	</table>
                    </div>
                 </div>
                </div>
	            <div class="modal-footer">
	            <input type="hidden" id="view_report" name="view_report" value="0"> 
	            	<input name="Submit" type="submit" value="Save" class="btn btn-success"/>
	            	<input name="Submit" type="submit" value="Save & View Report" onclick="$('#view_report').val(1)" class="btn btn-info"/>
	                <button type="button"  class="btn btn-default" onclick="reload()" data-dismiss="modal">Close</button>
	            </div>             
            </form>
    </div>
</div>
</div>
<!-- End Bulk Dispatch Modal -->

<?php $this->view('lib/footer'); ?>

<script>

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
	var search_customer = $('#search_customer').val();
	var search_size = $('#search_size').val();
	var search_finish = $('#search_finish').val();
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
			"sAjaxSource": root+'Order_sheet_list/fetch_record/'+search_customer+'/'+search_size+'/'+search_finish,
			"fnServerParams": function ( aoData ) {
				aoData.push( { "name": "mode", "value": "fetch" },{ "name" : "size_id" , "value" :  $("#size_id"). val()},{"name" : "finish_id" , "value" :  $("#finish_id"). val()},{ "name": "status", "value": $("#status").val() }, { "name" : "date" , "value" :  $("#daterange"). val()} );
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
						
						pageTotal1 = api
						.column( 8, { page: 'current'} )
						.data()
						.reduce( function (a, b) {
                   		 return  parseFloat(a) + parseFloat(b.replace(/(<([^>]+)>)/gi, "").replace(new RegExp(',', 'g'),""));
                		}, 0 );			

				 // Update footer  
				 $( api.column( 7 ).footer() ).html(
	                 numberWithCommas(pageTotal.toFixed(2))
	            ); 
				$( api.column( 8 ).footer() ).html(
	                 numberWithCommas(pageTotal1.toFixed(2))
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

	var producation_box_no = $("#edit_producation_box").val();
	var small_pallet_box_no = $("#edit_small_pallet_box").val();
	var big_pallet_box_no = $("#edit_big_pallet_box").val();
	var big_pallet_no = $("#edit_big_pallet").val();
	var small_pallet_no =  $("#edit_small_pallet").val();
	var total_box = (small_pallet_box_no * small_pallet_no) + (big_pallet_box_no * big_pallet_no);
	if(producation_box_no != total_box)
	{
		toastr["error"]("Big & Small Palate Not Match In Producation Box.");
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
					 $("#edit_customer_name").append("<option value='"+obj.id+"'>"+obj.c_companyname+"</option>") 
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
					 $("#edit_big_pallet").val(obj.big_pallet); 					 
					 $("#edit_small_pallet").val(obj.small_pallet);
					 $("#edit_big_pallet_box").val(obj.big_pallet_box); 					 
					 $("#edit_small_pallet_box").val(obj.small_pallet_box);
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

	var producation_box = $('#producation_box').val();
	var big_pallet = $('#big_pallet').val();
	var small_pallet = $('#small_pallet').val();
	var big_pallet_box = $('#big_pallet_box').val(); 
	var small_pallet_box = $('#small_pallet_box').val();
	var total_box = (small_pallet * small_pallet_box) + (big_pallet_box * big_pallet);
	
	if(producation_box != total_box)
	{
			toastr["error"]("Big & Small Palate Not Match In Producation Box.");
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
					 $("#producation_id_dispatch").val(id);
					 $("#dispatch_date").val(obj.dispatch_date); 
					 $("#customer_name").val(obj.c_companyname); 
					 $("#box_design_name").append("<option value='"+obj.box_design_id+"'>"+obj.box_design_name+"</option>") 
					 $("#box_design_name").val(obj.box_design_id).trigger('change') 
					 $("#editdocumentmode").val(obj.box_design_id);
					 $("#size").val(obj.size_type_mm); 				
					 $("#design_name").val(obj.model_name);
					 $("#finish").val(obj.finish_name);
					 $("#producation_box").val(obj.boxes);
					 $("#big_pallet").val(obj.big_pallet); 
					 $("#small_pallet").val(obj.small_pallet);
					 $("#big_pallet_box").val(obj.big_pallet_box); 
					 $("#small_pallet_box").val(obj.small_pallet_box);
					 $("#shade_no").val(obj.shade_no);
					 $("#batch_no").val(obj.batch_no);
					// Added by makwana
					 $("#dis_product_id").val(obj.product_id);					
					 $("#dis_finish_id").val(obj.finish_id);
					 $("#dis_packing_model_id").val(obj.packing_model_id);
					 $("#dis_customer_id").val(obj.id);
					 $('#producation_box').attr('max',obj.boxes);

					 $("#big_pallet").attr('max',obj.big_pallet); 
					 $("#small_pallet").attr('max',obj.small_pallet);
					 $("#big_pallet_box").attr('max',obj.big_pallet_box); 
					 $("#small_pallet_box").attr('max',obj.small_pallet_box);
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

// Created by makwana on date 29-03-2022
function get_bulkdispatch_data()
{
	var dispatch_productions = [];
	$. each($("input[name='dispatch_productions[]']:checked"), function(){
		dispatch_productions.push($(this).val());
	});

	if(dispatch_productions.length == 0)
	{
		toastr["error"]("Please Select atleast 1 design for production entry");
		return false;
	}
	
	block_page();
        $.ajax({ 
              type: "POST", 
              url: root+"Order_sheet_list/getbulkdata",
              data: {
				  "id":dispatch_productions				  
				  }, 
              success: function (response) {              		
			    $("#dispatch_producation_formmodal").modal({
					backdrop: 'static',
					keyboard: false
				});
				 $("#appendrows").html(response);
				 unblock_page("",""); 
              }
          }); 
}

	//dispatch Bulk Data
	$("#dispatch_producation_form").submit(function(event) {
	event.preventDefault();
	if(!$(dispatch_form).valid())
	{
		return false;
	}

		var producation_box = [];		
		var big_pallet = [];
		var small_pallet = [];
		var big_pallet_box = []; 
		var small_pallet_box = [];

		$. each($("input[name='producation_box[]']"), function(){
				producation_box.push($(this).val());
		});

		$. each($("input[name='big_pallet[]']"), function(){
				big_pallet.push($(this).val());
		});

		$. each($("input[name='small_pallet[]']"), function(){
				small_pallet.push($(this).val());
		});

		$. each($("input[name='big_pallet_box[]']"), function(){
				big_pallet_box.push($(this).val());
		});

		$. each($("input[name='small_pallet_box[]']"), function(){
				small_pallet_box.push($(this).val());
		});

		for(var i=0;i < producation_box.length;i++)
		{
			if(producation_box[i] < 0 || producation_box[i] == "")
			{
				toastr["error"]("Please enter Box");
				return false;
			}
		}

		for(var i=0;i < big_pallet.length;i++)
		{
			if(big_pallet[i] < 0 || big_pallet[i] == "")
			{
				toastr["error"]("Please enter Big Pallet");
				return false;
			}
		}
		
		for(var i=0;i < small_pallet.length;i++)
		{
			if(small_pallet[i] < 0 || small_pallet[i] == "")
			{
				toastr["error"]("Please enter Small Pallet");
				return false;
			}
		}

		for(var i=0;i < big_pallet_box.length;i++)
		{
			if(big_pallet_box[i] < 0 || big_pallet_box[i] == "")
			{
				toastr["error"]("Please enter Big Pallet Box");
				return false;
			}
		}

		for(var i=0;i < small_pallet_box.length;i++)
		{
			if(small_pallet_box[i] < 0 || small_pallet_box[i] == "")
			{
				toastr["error"]("Please enter Small Pallet Box");
				return false;
			}
		}

				
		for(var i=0;i < producation_box.length;i++)
		{
			var producation_box_no = producation_box[i];
			var small_pallet_box_no = small_pallet_box[i];
			var big_pallet_box_no = big_pallet_box[i];
			var big_pallet_no = big_pallet[i];
			var small_pallet_no = small_pallet[i];
			var total_box = (small_pallet_box_no * small_pallet_no) + (big_pallet_box_no * big_pallet_no);
			if(producation_box_no != total_box)
			{
					toastr["error"]("Big & Small Palate Not Match In Producation Box.");
					return false;
			}
		}
		
	block_page();
	var postData = new FormData(this);
	$.ajax({
            type: "post",
            url: 	root+'Order_sheet_list/savebulkdispatchdata',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {               			    
				$(".loader").hide();
				$("#dispatch_producation_formmodal").modal('hide');
			    $("#dispatch_producation_form").trigger('reset');
			    unblock_page("success","Sucessfully Updated.");
			    if(responseData.length > 0 )
			    {
			    	setTimeout(function(){ window.location=root+'order_sheet_list/dispatchdetailsreport/'+responseData },1500);
			    }else{
			    	setTimeout(function(){ window.location=root+'Order_sheet_list' },1500);
			    }			    
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});


function imposeMinMax(el){
  if(el.value != ""){
    if(parseInt(el.value) < parseInt(el.min)){
      el.value = el.min;
    }
    if(parseInt(el.value) > parseInt(el.max)){
      el.value = el.max;
    }
  }
}

$('.probox').bind('input propertychange', function(el) {
	if(el.value != ""){
    if(parseInt(el.value) < parseInt(el.min)){
      el.value = el.min;
    }
    if(parseInt(el.value) > parseInt(el.max)){
      el.value = el.max;
    }
  }
});
</script>