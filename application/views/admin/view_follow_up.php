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
 
 