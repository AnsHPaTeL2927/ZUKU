<!DOCTYPE html>
<html lang="en" class="no-js">
<head>
		<title>Export Application - <?=$company_detail[0]->s_name?> <?=$fdv->c_companyname?> <?=$fdv->c_contact?> <?=$cust_data->c_companyname?> <?=$cust_data->c_contact?> </title>
		<link rel="shortcut icon" type="image/png" href="<?=base_url()?>adminast/assets/images/favicon.png"/>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/bootstrap-toggle.min.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/jquery-ui.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/fonts/style.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/AdminLTE.min.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/main.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/main-responsive.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/theme_light.css" type="text/css" id="skin_color">
		<link rel="stylesheet" type="text/css" href="<?=base_url()?>adminast/assets/css/jquery.dataTables.min.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/css/buttons.dataTables.min.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/select2/select2.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/bootstrap-daterangepicker/daterangepicker.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css" />
		 <link href="<?=base_url()?>adminast/assets/css/toastr.css" rel="stylesheet" type="text/css" />
		 <link href="<?=base_url()?>adminast/assets/css/sweetalert.css" rel="stylesheet" type="text/css" />
		 <link rel="stylesheet" type="text/css" href="<?=base_url()?>adminast/assets/css/jquery.fancybox.min.css">
		<script>
		var root = '<?=base_url()?>';
		</script>
		<style>
		label.error{
			color:red;
		}
		.blockUI 
		{
			z-index: 10000 !important;
		}
		.disabled-select {
			background-color:#d5d5d5;
			opacity:0.5;
			border-radius:3px;
			cursor:not-allowed;
			position:absolute;
			top:0;
			bottom:0;
			right:0;
			left:0;
		}
		.swal-wide{
			width:400px !important;
		}
		.swal-wide button{
			    font-size: 14px !important;
		}
		body.swal-wide > [aria-hidden="true"] {
			transition: 0.1s filter;
			filter: blur(8px);
		}
		</style>
	</head>
	<body>
		<div class="navbar navbar-inverse navbar-fixed-top">
		
		  <div class="container">
				<div class="navbar-header">
					
				 	<button data-target=".navbar-collapse" data-toggle="collapse" class="navbar-toggle" type="button">
						<span class="clip-list-2"></span>
					</button>
				 	<a class="navbar-brand" href="<?=base_url('Dashboard/index')?>">
						<?=$company_detail[0]->s_name?>
					</a>
			 	</div>
				<div class="navbar-tools">
					 <ul class="nav navbar-right">
					 <?php 
					 if($_SESSION['subcription_duesoon'] == true)
					 {
					 ?>
							<li>
								<a href="javascript:;" onclick="do_payment();" class="tooltips">
									<span class="label label-warning">	
										Account Expiration  : <?=$_SESSION['subcription_due_days']?> Days 
									</span>
								</a>
							</li>
							 
					 <?php 
				 	 }
					  
					 if(!empty($_SESSION['p_menu']))
					 {
					 ?>
							<li>
									<a href="<?=base_url('invoice')?>" class="tooltips">
										<i class="fa fa-file-text-o"></i> Proforma Invoice
									</a>
							</li>
					 <?php 
					 }
					 ?>
						<!-- <li> <a href="<?=base_url('exportinvoice/add_invoice')?>" class="tooltips">
										<i class="fa fa-file-text-o"></i> Export
									</a>
						 </li>
						 <li> <a href="<?=base_url('invoice')?>" class="tooltips">
										<i class="fa fa-file-text-o"></i> Purchase 
									</a>
						 </li>-->
						<li class="dropdown current-user">
							<a data-toggle="dropdown" data-hover="dropdown" class="dropdown-toggle" data-close-others="true" href="#">
								<img src="<?=base_url();?>adminast/assets/images/user.jpg" class="circle-img" alt="Export User" style="height:30px">
								<span class="username"><?=$_SESSION['username']?></span>
								<i class="clip-chevron-down"></i>
							</a>
							<ul class="dropdown-menu">
							 	<li>
									<a href="<?=base_url('changepassword')?>">
										<i class="clip-cog"></i>
										&nbsp;Change Password
									</a>
								</li>
							 	<li>
									<a href="<?=base_url('setting')?>">
										<i class="clip-cog"></i>
										&nbsp;Setting
									</a>
								</li>
									<li>
										<a href="<?=base_url('backup/index')?>">
											<i class="fa fa-database"></i>
											&nbsp; Only DB Back up
										</a>
									</li>
								<li>
									<a href="<?=base_url('backup/with_zip')?>">
										<i class="fa fa-hdd-o"></i>
										&nbsp;Back up (With Folder)
									</a>
								</li>
								<li>
									<a href="<?php echo base_url(); ?>admin/logout">
										<i class="clip-exit"></i>
										&nbsp;Log Out
									</a>
								</li>
							</ul>
						</li>
					 </ul>
				 </div>
			</div>
		 </div>
