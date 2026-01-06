<?php 
$this->view('lib/header'); 
 $form = "Terms"; 
?>

<div class="main-container">
  <?php $this->view('lib/sidebar'); ?>
  <div class="main-content">
    <div class="container">
      <div class="row">
        <div class="col-sm-12">
          <ol class="breadcrumb">
            <li> <i class="clip-pencil"></i> <a href="<?=base_url()?>dashboard"> Dashboard </a> </li>
            <li class="active"> <a href="#"> Master&nbsp;&nbsp; </a> /  &nbsp;&nbsp;Bank
              <?=$form?>
            </li>
          </ol>
          <div class="page-header">
            <h3>
              <?=$form?>
            </h3>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-sm-3">
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-external-link-square"></i>
              <?=$form?>
            </div>
            <div class="panel-body">
              <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="terms_add" id="terms_add">
                <div class="form-group">
                  <label class="col-sm-12 control-label" for="form-field-1"> Terms Name </label>
                  <div class="col-sm-12">
                    <input type="text" placeholder="Terms Name" id="terms_name" class="form-control" name="terms_name" value="" autocomplete="off" >
                  </div>
                </div>
                <div class="form-group col-md-12" >
                  <button type="submit" class="btn btn-success"> Save </button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="col-md-9">
          <div class="panel panel-default">
            <div class="panel-heading"> <i class="fa fa-external-link-square"></i>
              <?=$form?>
              <a href="#myModal1" class="popup-btn pull-right" data-toggle="modal"><i class="fa fa-youtube"></i></a>
              <div id="myModal1" class="modal fade">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                      <h4 class="modal-title">How To Manage Terms</h4>
                    </div>
                    <div class="modal-body">
                      <iframe id="cartoonVideo" width="560" height="315" src="https://www.youtube.com/embed/ZNzSLSFW57Y?rel=0&autoplay=0"" frameborder="0" allowfullscreen></iframe>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table class="table table-bordered table-hover" id="sample-table-1">
                  <thead>
                    <tr>
                      <th>Sr No</th>
                      <th>Terms Name</th>
                      <th>Status</th>
                      <th>Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
										$m=1;
											for($i=0; $i<count($termsdata);$i++)
											{
												 
											?>
                    <tr>
                      <td><?=$m?></td>
                      <td><?=$termsdata[$i]->terms_name?></td>
                      <td><?php
													  			if($termsdata[$i]->status==0)
																		{
																		?>
                        Active
                        <?php 
																		}
																		else
																		{
																		?>
                        Deactived
                        <?php 
																		
																		
																		}
																		
																		?></td>
                      <td><div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action <span class="caret"></span></button>
                          <ul class="dropdown-menu">
                            <li> <a class="tooltips" data-title="Edit" href="javascript:;" onclick="edit_terms(<?=$termsdata[$i]->terms_id?>);"><i class="fa fa-pencil"></i> Edit</a> </li>
                            <?php 
																		if($termsdata[$i]->status==0)
																		{
																		?>
                            <li> <a class="tooltips" data-title="Edit" href="javascript:;" onclick="change_status(<?=$termsdata[$i]->terms_id?>,1);"><i class="fa fa-check-square"></i> Click to Deactive</a> </li>
                            <?php 
																		}
																		else{
																			?>
                            <li> <a class="tooltips" data-title="Edit" href="javascript:;" onclick="change_status(<?=$termsdata[$i]->terms_id?>,0);"><i class="fa fa-square"></i> Click to Active</a> </li>
                            <?php 
																		}
																		if($termsdata[$i]->total_cnt==0)
																		{
																		?>
                            <li> <a class="tooltips" data-title="Detele" onclick="delete_record(<?=$termsdata[$i]->terms_id?>)" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a> </li>
                            <?php 
																		}
																		?>
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
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Terms </h4>
      </div>
      <form class="form-horizontal askform" action="javascript:;"  method="post" name="edit_form" id="edit_form">
        <div class="modal-body">
          <div class="form-group">
            <label class="col-sm-12 control-label" for="form-field-1"> Terms Name </label>
            <div class="col-sm-12">
              <input type="text" placeholder="Terms Name" id="edit_terms_name" class="form-control" name="edit_terms_name" value="" >
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button name="Submit" type="submit"  class="btn btn-info">Save</button>
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
        <input type="hidden" name="eid" id="eid" />
        <input type="hidden" name="edit_termsname" id="edit_termsname" />
      </form>
    </div>
  </div>
</div>
<?php $this->view('lib/footer'); ?>
<script>
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
		
$(document).ready(function(){
		/* Get iframe src attribute value i.e. YouTube video url
		and store it in a variable */
    var url = $("#cartoonVideo").attr('src');
    
    /* Assign empty url value to the iframe src attribute when
    modal hide, which stop the video playing */
    $("#myModal1").on('hide.bs.modal', function(){
        $("#cartoonVideo").attr('src', '');
    });
    
    /* Assign the initially stored url back to the iframe src
    attribute when modal is displayed again */
    $("#myModal1").on('show.bs.modal', function(){
        $("#cartoonVideo").attr('src', url);
    });
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
	main_delete(deleleid,'terms_list/deleterecord','terms_list')
}
$("#terms_add").validate({
		rules: {
			terms_name: {
				required: true
			}
		},
		messages: {
			terms_name: {
				required: "Enter Terms Name"
			}
		}
	});

$("#edit_form").validate({
	rules: {
		edit_terms_name: {
			required: true
		}
	},
	messages: {
		edit_terms_name: {
			required: "Enter Terms Name"
		}
	}
});
$("#terms_add").submit(function(event) {
	event.preventDefault();
	if(!$("#terms_add").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	postData.append("mode","add");
	$.ajax({
            type: "post",
            url : root+'terms_list/manage',
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
				   $("#terms_add").trigger('reset');
				   unblock_page("success","Sucessfully saved.");
				   setTimeout(function(){ window.location=root+'terms_list' },1500);
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","Record already exist in database");
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
            url: 	root+'terms_list/edit_record',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
               console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();
				
				if(obj.res==1 || $("#edit_terms_name").val() == obj.terms_name)
			   {
				    $("#myModal").modal('hide');
					$("#edit_form").trigger('reset');
				     unblock_page("success","Sucessfully Updated.");
					 setTimeout(function(){ window.location=root+'terms_list' },1500);
				}
				else if(obj.res==2)
			    {
				    unblock_page("info","Record already exist in database");
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

function edit_terms(terms_id)
{
	block_page();
     $.ajax({ 
              type: "POST", 
              url: root+"terms_list/fetchtermsdata",
              data: {"id": terms_id}, 
              success: function (response) { 
                   var obj = JSON.parse(response);
				  
				   $("#myModal").modal({
						backdrop: 'static',
						keyboard: false
					});
					$("#eid").val(terms_id);
				 	$("#edit_terms_name").val(obj.terms_name);
				 	$("#edit_termsname").val(obj.terms_name);
				  	 
					unblock_page("",""); 
                  }
              
          }); 

}	
function change_status(id,status)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  
}).then((result) => {
 
  if (result.value) {
	 block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+"terms_list/changestatus",
              data: {
                "id": id,
				"status":status
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					unblock_page('success',"Status Successfully Changed");
					setTimeout(function(){ window.location=root+"terms_list"; },1500);
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