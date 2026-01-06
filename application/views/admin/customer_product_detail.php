<?php 
$this->view('lib/header'); 
 
?>	
	<div class="main-container">
		<?php 
		
		$this->view('lib/sidebar'); 
		
		?>
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
									<a href="<?=base_url().'customer_detail'?>">Customer List</a>
									
								</li>
								 
							</ol>
							<div class="page-header">
							<h3>
								Set Design Data Of	<span><?=$cust_data->c_companyname?>  </span>
								<div class="pull-right">
									 
									<a href="<?=base_url().'add_notify_detail/index/'.$cust_data->id?>" class="btn btn-primary" > Next </a>
								</div>
							 </h3>
							
							</div>
							 <div class="panel-body form-body">
							 
							 <div class="col-md-4">
										<label class="col-md-5 control-label" style="margin-top: 5px;"><strong class=""> Select Product </strong></label>
										 <div class="col-md-7">
										<select class="select2" name="filter_product_id" id="filter_product_id" required title="Select Product" onchange="load_data();" >
												<option value="">All Product</option>
												<?php 
												foreach($get_product_name_data as $product_row)
												{
													 
													$thickness = (!empty($product_row->thickness))?" - ".$product_row->thickness." MM":"";
													$product_name = $product_row->size_type_mm." (".$product_row->series_name.")".$thickness;
													$sel = '';
													if($product_row->product_id == $_SESSION['customer_barcode_product_id'])
													 {
														 $sel ='selected="selected"';
													 }
													echo "<option ".$sel."  value='".$product_row->product_id."'>".$product_name."</option>";
												}
												 
												?>
										</select>
										 </div>     
									</div>
								 
								  <div class="show_data"></div>
								  <div class="text-center">
									<div class="form-group">
										<input name="Submit" type="button" value="Save"  onclick="save_all()" class="btn btn-success" />
									 </div>    	
								</div> 
					 	</div>
					</div>
					 
				 </div>
			</div>
		 </div>
	 </div>
 </div>
<?php $this->view('lib/footer');
 $this->view('lib/addseries'); ?>
 <script>
$(".select2").select2({
	width:"100%"
});
 
load_data();
 
function load_data()
{
	 
	 block_page();
        $.ajax({ 
              type: "POST", 
              url:  root+"customer_detail/load_product_data",
              data: {
					"cust_id"					: <?=$cust_data->id?>,
					"filter_product_id"			: $("#filter_product_id").val() 
              }, 
              cache: false, 
              success: function (data) { 
					 $(".show_data").html(data);
					 $(".tooltips").tooltip();
					 unblock_page("","");
                  }

            });  

}
function save_all()
{
	 
       block_page();
	   var productid		  		=  document.getElementsByName('product_id[]');
	   	var productid_array 		= [];
	   	var cust_product_name_array	= [];
	   	var cust_hsncode_array		= [];
	   	var show_export_array		= [];
	   	var show_cust_array			= [];
	   	var show_bl_array			= [];
	   	var show_coo_array			= [];
	   	var cust_product_detail_id  = [];
		for (var i = 0; i < productid.length; i++) { 
				var p = productid[i]; 
				productid_array.push(p.value); 
				 
				cust_product_name_array.push($("#cust_product_name"+p.value).val()); 
				cust_hsncode_array.push($("#cust_hsncode"+p.value).val()); 
				show_export_array.push($("#show_export"+p.value).is(':checked')?1:0); 
				show_cust_array.push($("#show_cust"+p.value).is(':checked')?1:0); 
				show_bl_array.push($("#show_bl"+p.value).is(':checked')?1:0); 
				show_coo_array.push($("#show_coo"+p.value).is(':checked')?1:0); 
				cust_product_detail_id.push($("#cust_product_detail_id"+p.value).val()); 
			} 
			
	   
	    $.ajax({ 
              type: "POST", 
              url:  root+"customer_detail/update_product_detail",
              data: {
					"cust_id"					: <?=$cust_data->id?>,
					"productid_array"			: productid_array,
					"cust_product_name_array"	: cust_product_name_array,
					"cust_hsncode_array"		: cust_hsncode_array,
					"show_export_array"			: show_export_array,
			 		"show_cust_array"			: show_cust_array,
				 	"show_bl_array"				: show_bl_array,
				 	"cust_product_detail_id"	: cust_product_detail_id,
					"show_coo_array"			: show_coo_array 
              }, 
              cache: false, 
              success: function (data) { 
					var obj= JSON.parse(data);
					  if(obj.res==1)
					   {
						  							  
							unblock_page("success","Sucessfully Updated.");
							setTimeout(function(){  location.reload() },1000);
					    }
					 	else
					   {
							unblock_page("error","Something Wrong.") 
					   } 
                  }

            });  

}
 function import_excel()
{
	$("#excelModal").modal({
		backdrop: 'static',
		keyboard: false
	});

}
$("#import_form").validate({
		rules: {
			import_file: {
				required: true
			}
		},
		messages: {
			import_file: {
				required: "Select CSV File"
			} 
		}
	});
$("#import_form").submit(function(event) {
	event.preventDefault();
	if(!$("#import_form").valid())
	{
		return false;
	}
	 
	block_page();
	var postData= new FormData(this);
	var url = root+'add_design_detail/import_cust_data'; 
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
				   unblock_page("success","Sucessfully Imported.");
				   setTimeout(function(){ location.reload(); },1000);
				 
			 	}
				else if(obj.res==2)
				{
					unblock_page("error","Worng File. Coloum Doesn't Match");
		 		}
				else if(obj.res==3)
				{
					unblock_page("error","Worng File. Coloum Name Doesn't Match");
		 		}
				else if(obj.res==4)
				{
					$(".product_html").hide();
					$(".error_html").show();
					$(".error_html").html(obj.error_html);
			 		unblock_page("error","Some Record having error.");
		 		}
			 	else if(obj.res==0)
				{
					unblock_page("error","File Not Upload.") 
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

 function update_price(packing_model_id,product_id,n,design_rate_id,finish_id)
{
	 
       block_page();
        $.ajax({ 
              type: "POST", 
              url:  root+"add_design_detail/updatedesigndetail",
              data: {
					"cust_id"			: <?=$cust_data->id?>,
					"packing_model_id"	: packing_model_id,
					"finish_id"			: finish_id,
				 	"product_id"		: product_id,
					"cust_design_name"	: $("#cust_design_name"+n).val(), 
					"barcode_no"		: $("#barcode_no"+n).val(), 
					"extra_flied"		: $("#extra_flied"+n).val(), 
				 	"design_rate_id"	: design_rate_id
              }, 
              cache: false, 
              success: function (data) { 
					var obj= JSON.parse(data);
					  if(obj.res==1)
					   {
						  							  
							unblock_page("success","Sucessfully Inserted.");
							setTimeout(function(){  location.reload() },1000);
						 
					   }
					else if(obj.res==2)
					   {
						  							  
							unblock_page("success","Sucessfully Updated.");
							setTimeout(function(){  location.reload() },1000);
						 
					   }
				 	else
					   {
							unblock_page("error","Something Wrong.") 
					   } 
                  }

            });  

    } 
</script>
 
  