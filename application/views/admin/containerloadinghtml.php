<div class="row">
        <div class="col-sm-12">
          <div class="panel-body form-body">
            <div class="col-md-10 col-md-offset-1">
              <form role="form" class="form-horizontal" action="javascript:;" method="post" enctype="multipart/form-data" name="container_loading_form" id="container_loading_form">
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1"> PI No </label>
                  <div class="col-sm-4">
                    <input type="text" placeholder="Enter PI No" autocomplete="off" style="font-weight:bold;" id="pi_no" required="" class="form-control" name="pi_no" value="<?=$set_container->invoice_no?>" title="Enter PI No" readonly>
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1"> Container No </label>
                  <div class="col-sm-4">
                    <input type="text" placeholder="Container No" id="container_no" style="font-weight:bold;" class="form-control" name="container_no" value="<?=$set_container->container_no?>" autocomplete="off" title="Container No" readonly>
                  </div>
                </div>
                <input type="hidden" id="exportdata<?=$set_container->pi_loading_plan_id?>" name="exportdata" value="<?=$set_container->pi_loading_plan_id?>" >
                <table cellspacing="0" cellpadding="0"  width="100%">