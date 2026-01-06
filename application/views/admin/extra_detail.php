<?php  $this->view('lib/header');  ?>

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
									&nbsp;Extra Detail
								</li>
							</ol>
							<div class="page-header" style="margin-left:20px;">
							<h3>Extra Detail Of <?=$export_data->c_companyname?></h3>
						</div>
					</div>
				</div>
				 
					 
					<div class="row">
						<div class="col-sm-12">
							 
							 <div class="panel-body form-body">
								<div class="col-md-8 col-md-offset-1">
								
										<form role="form" class="form-horizontal askform" action="javascript:;" method="post" enctype="multipart/form-data" id="extra_detail_form" name="extra_detail_form">
										
											<input type="hidden" id="exportdata<?=$export_data->export_invoice_id?>"   name="exportdata" value="<?=$export_data->export_invoice_id?>" >
										
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Transit Time (Days)
												</label>
												<div class="col-sm-4">
													<input type="text" id="shippment_days" name="shippment_days" placeholder="Shippment Days" class="form-control" value="<?=!empty($detail)?$detail->shippment_days:$export_data->shippment_days?>"  />
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
													CHA
												</label>
												<div class="col-sm-4">
												<select class="form-control select2" name="cha_id" id="cha_id<?=$chadata->cha_id?>" onchange="add_cha_modal(this.value)" title="Select Country" >
													<option value="">Select Any One</option>	
													<?php
													for($c=0;$c<count($chadata);$c++)
													{
														$select = '';
											
														if($chadata[$c]->id==@$detail->cha_id)
														{
															$select = 'selected="selected"'; 
														}
														
													?>
													<option <?=$select?> value="<?=$chadata[$c]->id?>"><?=$chadata[$c]->c_name?></option>	
													<?php
													}
													?>
													</select>
													
												</div>
												<div style="margin-top: 4px;">
													<button type="button" class="btn btn-primary tooltips" data-title="Add CHA" data-toggle="modal" data-target="#chaadd" data-keyboard="false" data-backdrop="static">+</button>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
													Forwarer 
												</label>
												<div class="col-sm-4">
												<select class="form-control select2" name="forwarer_id" id="forwarer_id<?=$forwarerdata->forwarer_id?>" onchange="add_forwarer_modal(this.value)"   title="Select Country" >
													<option value="">Select Any One</option>	
													<?php
													for($f=0;$f<count($forwarerdata);$f++)
													{
														$select = '';
											
														if($forwarerdata[$f]->id==@$detail->forwarer_id)
														{
															$select = 'selected="selected"'; 
														}
														
													?>
													<option <?=$select?> value="<?=$forwarerdata[$f]->id?>"><?=$forwarerdata[$f]->c_name?></option>	
													<?php
													}
													?>
													</select>
													
												</div>
												<div style="margin-top: 4px;">
												<button type="button" class="btn btn-primary tooltips" data-title="Add Forwarer" data-toggle="modal" data-target="#forwareradd" data-keyboard="false" data-backdrop="static">+</button>
											</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
													Shipping Line
												</label>
												<div class="col-sm-4">
												<select class="form-control select2" name="shipping_id" id="shipping_id<?=$shippingdata->shipping_id?>" title="Select Country" onchange="add_shippingline_modal(this.value)">
													<option value="">Select Any One</option>	
													<?php
													for($s=0;$s<count($shippingdata);$s++)
													{
														$select = '';
											
														if($shippingdata[$s]->shipping_id==@$detail->shipping_id)
														{
															$select = 'selected="selected"'; 
														}
														
													?>
													<option <?=$select?> value="<?=$shippingdata[$s]->shipping_id?>"><?=$shippingdata[$s]->shipping_line_name?></option>	
													<?php
													}
													?>
													</select>
													
												</div>
												<div style="margin-top: 4px;">
													<button type="button" class="btn btn-primary tooltips" data-title="Add Shipping Line" data-toggle="modal" data-target="#shippinglineadd" data-keyboard="false" data-backdrop="static">+</button>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
													Vessel
												</label>
												<div class="col-sm-4">
												<select class="form-control select2" name="vessel_id" id="vessel_id<?=$vesseldata->vessel_id?>" title="Select Country" onchange="add_vessel_modal(this.value)">
													<option value="">Select Any One</option>	
													<?php
													for($v=0;$v<count($vesseldata);$v++)
													{
														$select = '';
											
														if($vesseldata[$v]->id==@$detail->vessel_id)
														{
															$select = 'selected="selected"'; 
														}
														
													?>
													<option <?=$select?> value="<?=$vesseldata[$v]->id?>"><?=$vesseldata[$v]->name?></option>	
													<?php
													}
													?>
													</select>
													
												</div>
												<div style="margin-top: 4px;">
													<button type="button" class="btn btn-primary tooltips" data-title="Add Vessel" data-toggle="modal" data-target="#vesseladd" data-keyboard="false" data-backdrop="static">+</button>
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														DHL Tracking No
												</label>
												<div class="col-sm-4">
													<input type="text" id="track_no" name="track_no" placeholder="Courier Tracking" class="form-control" value="<?=$detail->vessel_track_no?>"/>
													
												</div>
												<div style="margin-top: 4px;" id="palneicon" name="planeicon">
													<a href = "javascript:;" 
													onclick = "this.href='https://www.dhl.com/in-en/home/tracking/tracking-express.html?submit=1&tracking-id=' + document.getElementById('track_no').value"  class="btn btn-primary tooltips" target="_blank">
														<i class="fa fa-plane"></i> 
													</a>
												</div>
											</div>
											
											<div class="form-group">
												<label for="checkpack" class="col-sm-4 control-label" >
												 Checkpack
												 </label>
												 <div class="col-sm-4">
													<input type="checkbox" id="checkpack" name="checkpack" placeholder="CheckPack" onclick="ShowHideDiv(this.checked)" value="1" <?=($detail->checkpack == "1")?"checked":""?>/>
												</div>
											</div>
											
											<div class="form-group">
												<div id="hmcontainers" name="hmcontainers" style="display: none" >
													<label class="col-sm-4 control-label" for="form-field-1">
															How Many Containers
													</label>
													<div class="col-sm-4">
														<input type="text" class="form-control" id="containers" name="containers" placeholder="How Many Containers" value="<?=$detail->containers?>"/>
													</div>											
												</div>
											</div>
											
											<div class="form-group">
												<div id="hmcontainersremark" name="hmcontainersremark" style="display: none">
													<label class="col-sm-4 control-label" for="form-field-1">
															CheckPack Remark
													</label>
													<div class="col-sm-4">
														<textarea id="checkpack_remark" name="checkpack_remark" placeholder="CheckPack Remark" class="form-control" title="Enter Remark"><?=strip_tags($detail->checkpack_remark); ?></textarea>
													</div>
												</div>
											</div>
												
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field Textbox 1
												</label>
												<div class="col-sm-4">
													<input type="text" id="field1" name="field1" placeholder="Field 1" class="form-control" value="<?=$detail->field_1?>" />
												</div>
											</div>
											
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field Textbox 2
												</label>
												<div class="col-sm-4">
													<input type="text" id="field2" name="field2" placeholder="Field 2" class="form-control" value="<?=$detail->field_2?>" />
												</div>
											</div> 
										
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field Textbox 3
												</label>
												<div class="col-sm-4">
													<input type="text" id="field3" name="field3" placeholder="Field 3" class="form-control" value="<?=$detail->field_3?>" />
												</div>
											</div> 
										
											<div class="form-group">
												<label class="col-sm-4 control-label" for="form-field-1">
														Field Textbox 4
												</label>
												<div class="col-sm-4">
													<input type="text" id="field4" name="field4" placeholder="Field 4" class="form-control" value="<?=$detail->field_4?>" />
												</div>
											</div> 								
										
											<br>
											<div class="col-md-offset-4">
												<div class="form-group " style="" >
													<button type="submit" class="btn btn-success">
														Save
													</button>
													 
													<a href="<?=base_url().'exportinvoice_listing/index'?>" class="btn btn-danger">
														Cancel
														</a>
													<?php
														if($fd == 'edit')
														{
														?>
															<!--<button type="button" class="btn btn-default" data-toggle="modal" data-target="#myModal">Add Consigner</button>-->
														<?php
			
														}
													?>
												</div>
											
											</div>
										<input type="hidden" name="exportinvoice_id" id="exportinvoice_id" value="<?=$export_data->export_invoice_id?>"/>
										<input type="hidden" name="customer_add_detail_id" id="customer_add_detail_id" value="<?=$detail->exportinvoice_id?>"/> 
										<input type="hidden" name="next" id="next" value="0"/>
										
								</form>
						
						</div>
					</div>
				</div>
			</div>			
		</div>
	</div>
</div>
<?php 
$this->view('lib/footer'); 
$this->view('lib/addcha');
$this->view('lib/addforwarer');
$this->view('lib/addshippingline');
$this->view('lib/addvessel');
?>
<script>

// function show_detail(check)
// {
	// if(check == '1')
	// {
		// $(".rex-detail").show();
	// }
	// else
	// {
		// $(".rex-detail").hide();
	// }
// }
function ShowHideDiv(checkpack)
{
       	 
		if(checkpack == true)
		{
			$("#hmcontainers").show();
			$("#hmcontainersremark").show();
		}
		else
		{
			$("#hmcontainers").hide();
			$("#hmcontainersremark").hide();
		}
}
	
function save_and_next()
{
	$("#next").val(1);
	$("#extra_detail_form").submit();
}

$(function () {
            $('input').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
        });

 $(function () {
            $('textarea').blur(function () {                     
                $(this).val(
                    $.trim($(this).val())
                );
            });
        });	
		
$("#extra_detail_form").submit(function(event) {
	event.preventDefault();
	if(!$("#extra_detail_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'Extra_detail/manage',
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
					if($("#next").val() == 1)
					{
						setTimeout(function(){ window.location = root+'extra_detail/index/<?=$export_data->export_invoice_id?>'; },100);
					}
					else
					{
						setTimeout(function(){ location.reload(); },100);
					}
			   }
			   else if(obj.res==2)
			   {
				   
					unblock_page("success","Sucessfully Updated.");
					if($("#next").val() == 1)
					{
						
						setTimeout(function(){ window.location = root+'extra_detail/index/<?=$export_data->export_invoice_id?>'; },100);
					 }
					else
					{
						setTimeout(function(){ location.reload(); },100);
					}
			   }
			   else if(obj.res==3)
			   {
				   $("#forwarer_id").focus();
				     unblock_page("error","Forwarer ID Already Assign.");
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

$("#forwarer_id").select2({
	width:'100%',
	 "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_forwarer_modal(0)'>Add New Forwarer</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 	
});
function add_forwarer_modal(val)
{
	 
	if(val==0)
	{
		$("#forwareradd").modal('show');
	}
	
}

$("#supplier_name").submit(function(event) {
	event.preventDefault();
	if(!$("#supplier_name").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
 
	$.ajax({
            type: "post",
            url: 	root+'Add_forwarer/manage',
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
				   $("#supplier_name").trigger('reset');
				    $('#countryadd').modal("hide") 
					$('#forwareradd').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#forwarer_id").append("<option value='"+obj.id+"' selected>"+obj.c_name+"</option>");
					//$("#forwarer_id").val(obj.id)
				 
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

$("#cha_id").select2({
	width:'100%',
	 "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_cha_modal(0)'>Add New CHA</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 	
});

function add_cha_modal(val)
{
	 
	if(val==0)
	{
		$("#chaadd").modal('show');
	}
	
}

$("#cha_name").submit(function(event) {
	event.preventDefault();
	if(!$("#cha_name").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
 
	$.ajax({
            type: "post",
            url: 	root+'Add_cha/manage',
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
				   $("#cha_name").trigger('reset');
				    $('#countryadd').modal("hide") 
					$('#forwareradd').modal("hide")
					$('#chaadd').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#cha_id").append("<option value='"+obj.id+"' selected>"+obj.c_name+"</option>");
					//$("#forwarer_id").val(obj.id)
				 
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

$("#shipping_id").select2({
	width:'100%',
	 "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_shippingline_modal(0)'>Add New Shipping Line</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 	
});

function add_shippingline_modal(val)
{
	 
	if(val==0)
	{
		$("#shippinglineadd").modal('show');
	}
	
}

$("#shipping_line").submit(function(event) {
	event.preventDefault();
	if(!$("#shipping_line").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
 
	$.ajax({
            type: "post",
            url: 	root+'Shippingmaster/manage',
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
				   $("#shipping_line").trigger('reset');
				    $('#countryadd').modal("hide") 
					$('#forwareradd').modal("hide")
					$('#chaadd').modal("hide")
					$('#shippinglineadd').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#shipping_id").append("<option value='"+obj.shipping_id+"' selected>"+obj.shipping_line_name+"</option>");
					//$("#forwarer_id").val(obj.id)
				 
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

$("#vessel_id").select2({
	width:'100%',
	 "language": {
			"noResults": function(){
				return "<a href='javascript:;' onclick='add_vessel_modal(0)'>Add New Vessel</a>";
			}
	},
	escapeMarkup: function (markup) {
			return markup;
	} 	
});
function add_vessel_modal(val)
{
	 
	if(val==0)
	{
		$("#vesseladd").modal('show');
	}
	
}

$("#vessel_name").submit(function(event) {
	event.preventDefault();
	if(!$("#vessel_name").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
 
	$.ajax({
            type: "post",
            url: 	root+'Vessel_data/manage',
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
				   $("#vessel_name").trigger('reset');
				    $('#countryadd').modal("hide") 
					$('#forwareradd').modal("hide")
					$('#vesseladd').modal("hide")
					unblock_page("success","Sucessfully Inserted.");
				    $("#vessel_id").append("<option value='"+obj.id+"' selected>"+obj.name+"</option>");
					//$("#forwarer_id").val(obj.id)
				 
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
<?php
$checked  = ($detail->checkpack == "1")?"true":"false";
	echo "<script>ShowHideDiv(".$checked.")</script>";
	
?>