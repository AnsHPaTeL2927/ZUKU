 <!DOCTYPE html>
<html lang="en" class="no-js">
<head>
<meta name="robots" content="noindex">
		<title>Export Application - <?=TITLE?>. </title>
		<link rel="shortcut icon" type="image/png" href="<?=base_url()?>adminast/assets/images/favicon.png"/>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="description" content="Export Application - Software to manage your export bussiness.">
		<meta name="keywords" content="Export Application - Software to manage your export bussiness.">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="Export Application - Software to manage your export bussiness." />
		<meta content="" name="Export Application - Software to manage your export bussiness." />
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
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/select2/select2.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/datepicker/css/datepicker.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/bootstrap-datetimepicker/css/datetimepicker.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/bootstrap-daterangepicker/daterangepicker.css">
		<link rel="stylesheet" href="<?=base_url()?>adminast/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.css" />
		 <link href="<?=base_url()?>adminast/assets/css/toastr.css" rel="stylesheet" type="text/css"/>
		 <link href="<?=base_url()?>adminast/assets/css/sweetalert.css" rel="stylesheet" type="text/css"/>
		<script>
			var root = '<?=base_url()?>';
		</script>
		<style>
			label.error{
				color: red !important;
				position: absolute;
				bottom: -21px;
				left: 26px;
			}
		</style>
</head>
	<body class="login example2">
		<div class="main-login col-sm-4 col-sm-offset-4">
			<div class="logo">Export Application</div>
		 	<div class="box-login">
				<h3>Sign in to your account</h3>
				<p>
					Please enter your name and password to log in.
				</p>
				<?php 
				
			
			 	$ck=''; 
				if(!empty($_COOKIE['remember_me']))
				{
					$ck='checked="checked"';
				}
			 	?>
               <form class="form-login" action="javascript:;" method="post" name="loginform" id="loginform">
				 	<fieldset>
						<div class="form-group" >
							<span class="input-icon">
								<input type="text" class="form-control" name="username" id="username" placeholder="Username" title="Enter Username" value="<?=$_COOKIE['remember_me']?>">
								<i class="fa fa-user"></i> </span>
						</div>
						<div class="form-group form-actions">
							<span class="input-icon">
								<input type="password" class="form-control password" name="password" id="password" placeholder="Password" title="Enter Password"  value="<?=$_COOKIE['password']?>" required title="Enter Password">
								<i class="fa fa-key"></i>
								 </span>
						</div>
						<div class="form-actions">
							<label for="remember" class="checkbox-inline">
								<input type="checkbox" class="grey remember" id="remember" name="remember" <?=$ck?> value='1'>
								Keep me signed in
							</label>
							<button type="submit" class="btn btn-bricky pull-right">
								Login <i class="fa fa-arrow-circle-right"></i>
							</button>
						</div>
					<div class="form-group form-actions login_msg" style="color:<?=($status == 1)?"green":"red"?>;font-size:20px">
						 <?=$msg?>
					</div>
					 <div class="renewplan" style="display:none">
						<h3 class="text-center">OR</h3>
						<div class="form-actions">
							<label class="col-md-6">
								<input type="radio"   id="plan_id1" name="plan_id" checked value='1'>
								Pay Online
							</label>
							<label class="col-md-6">
								<input type="radio"  id="plan_id2" name="plan_id"   value='2'>
								Pay Cash
							</label>
							<div class="text-center" style="margin-top:55px;">
								<button type="button" onclick="openmodal();" class="btn btn-info text-center">
								 Choose
								</button>
							</div>
						</div>
					</div>
					 <div class="renew_key_paycash" style="display:none">
					 <div class="form-group form-actions " style="font-size:20px;">
						If You already have renew key then please enter here. otherwise ask ZUKU TEAM for renew key.
					 </div>
						<div class="form-group" style="margin-top:10px;">
						
							<span class="col-md-11" style="margin-right: -31px;">
								<input style="padding: 16px 4px;" type="text" class="form-control" name="renew_key" id="renew_key" placeholder="Renew Key" title="Enter Renew Key" value="" >
							</span>
							<span class="col-md-1">
								<button type="button" class="btn btn-primary" onclick="renew_check_with_key()">Go</button>
							</span>
						</div>
					</div>
						 
					</fieldset>
					<input type="hidden" name="ip_address" id="ip_address" />
					<input type="hidden" name="browser" id="browser" />
					<input type="hidden" name="version" id="version" />
					<input type="hidden" name="os" id="os" />
					<input type="hidden" name="plan_amount" id="plan_amount" />
				</form>
			</div>
			 
			<div class="copyright">
				Powered By :<br>
				<a href="https://www.zuku.co.in/" target="_blank"> <img src="<?=base_url()?>adminast/assets/images/Zuku_Logo.png" style="height: 90px;" /></a>
			</div>
		</div>
		<script src="<?=base_url()?>adminast/assets/plugins/jQuery-lib/2.0.3/jquery.min.js"></script>
		<script type="text/javascript" src="<?=base_url()?>adminast/assets/js/jquery.dataTables.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/bootstrap-toggle.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/jquery-ui.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/jquery.blockUI.js"></script>
		 
	 	<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		
		<script src="<?=base_url()?>adminast/assets/plugins/select2/select2.min.js"></script>
		
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-daterangepicker/moment.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/jquery.validate.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/toastr.js"></script>
		
		<script src="<?=base_url()?>adminast/assets/js/sweetalert.js"></script>
		 
		<script src="<?=base_url()?>adminast/assets/js/jquery.cookies.js"></script>
		 
	</body>
<script>
function renew_check_with_key()
{
	block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'admin/check_key',
              data: {
                "renew_key"	 : $("#renew_key").val() 
              }, 
              cache: false, 
              success: function (responseData) 
			  { 
				var obj= JSON.parse(responseData);
				if(obj.res == 1)
				{
					$("#loginform").trigger('reset');
					unblock_page("success","Renew done. Please Login again.");
				 	$(".renewplan").hide();
					$(".renew_key_paycash").hide();
					$(".login_msg").html("Renew done. Please Login again.");
				}
				else
				{
					unblock_page("error","Renew Key Wrong.");
				}
				
              }
			});
}
function openmodal()
{
	var radioval = $('input[name="plan_id"]:checked').val();
	if(radioval == 1)
	{
		window.location = root+'pay/index/'+$("#plan_amount").val();
	}
	else
	{
		block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+'admin/send_mail',
              data: {
                "plan_amount"	 : $("#plan_amount").val() 
              }, 
              cache: false, 
              success: function (data) 
			  { 
				 unblock_page("info","Please enter renew key");
				 $(".renew_key_paycash").show();
              }
			});
		
	}
}
function block_page()
{
	   $.blockUI({ css: { 
            border: 'none', 
            padding: '0px', 
			width: '17%',
			left:'43%',
            backgroundColor: '#000', 
            '-webkit-border-radius': '10px', 
            '-moz-border-radius': '10px', 
            opacity: .5, 
            color: '#fff', 
			zIndex: '10000'
        },
		message	:  '<h3> Please wait...</h3>'	}); 
  
}
function block_page1() {
    $.blockUI({
        message: '<h3>Please wait while we redirect you to two-factor authentication.</h3>',
        css: {
            border: 'none',
            padding: '0px',
            width: '35%',
            left: '32.5%',
            backgroundColor: '#000',
            '-webkit-border-radius': '10px',
            '-moz-border-radius': '10px',
            opacity: 0.5,
            color: '#fff',
            zIndex: 10000
        }
    });
}
function unblock_page(type,msg)
{
	   if(type!=="" && msg!=="")
	   {
		toastr[type](msg)
	   }
	   setTimeout($.unblockUI, 500); 
}
   
   
$(document).ready(function() {
	
	$("#loginform").validate({
		rules: {
			username: {
				required: true
			} 
		},
		messages: {
			username: {
				required: "Enter Username"
			} 
		}
	});
  $("#browser").val(BrowserDetect.browser)
  $("#version").val(BrowserDetect.version)
  $("#os").val(BrowserDetect.OS)
 $.getJSON("https://api.ipify.org/?format=json", function(e) {
    $("#ip_address").val(e.ip);
});
});

//---------------------------------------------------------------------------------
//OTP BYPASSING
//---------------------------------------------------------------------------------
$("#loginform").submit(function(event) {
	event.preventDefault();
	if(!$("#loginform").valid())
	{
		return false;
	}
	block_page();
	var postData= new FormData(this);
	 
	$.ajax({
            type: "post",
            url: 	root+'admin/login',
            data: postData,
			processData: false,
			contentType: false,
			cache: false,
            success: function(responseData) {
              console.log(responseData);
			    var obj= JSON.parse(responseData);
				$(".loader").hide();

				if(obj.renew_key_verify.length > 0)
				{
					window.location = obj.renew_key_verify;
				}

				if(obj.res=="success")
			    {
				 	  var remember=$('input[name=remember]:Checked').val();
					if(remember=="1")
					{
						 $.cookie("remember_me", $("#username").val(), { expires : 1, path:"/" });
						$.cookie("password", $("#password").val(), { expires : 1, path:"/" });
					}
					else
					{
						$.cookie("remember_me", $("#username").val(), { expires : -1, path:"/" });
						$.cookie("password", $("#password").val(), { expires : -1, path:"/" });
					}
				 	 window.location=root+'dashboard' 
				}
			    else if(obj.res=="reject")
				{
				    $(".renewplan").show();
				    $(".login_msg").html("Login Rejected. Your subscription plan is over. Please contact software provider ZUKU team.");
				    unblock_page("error","Login Rejected. Your subscription plan is over. Please contact software provider ZUKU team.");
				    $("#plan_amount").val(obj.amount);
				}
				else if(obj.res=="blank_no")
				{ 
					$(".renewplan").show();
					$("#plan_amount").val(obj.amount);
					$(".login_msg").html("Please make payment for use ZUKU Software");
					unblock_page("error","Please make payment for use ZUKU Software") 
				}
				else if(obj.res=="invaild")
			    {
				    unblock_page("error","Username & Password Invaild");
				}
				else if(obj.res=="blank")
				{ 
					unblock_page("error","Username * Password Blank.") 
				}
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
	});
});

//---------------------------------------------------------------------------------
//THE CODE WITH OTP
//---------------------------------------------------------------------------------
// $("#loginform").submit(function(event) {
	// event.preventDefault();
	// if(!$("#loginform").valid())
	// {
		// return false;
	// }
	// block_page();
	// var postData= new FormData(this);
	 
	// $.ajax({
            // type: "post",
            // url: 	root+'admin/login',
            // data: postData,
			// processData: false,
			// contentType: false,
			// cache: false,
            // success: function(responseData) {
              // console.log(responseData);
			    // var obj= JSON.parse(responseData);
				// $(".loader").hide();
				// if (obj.res === "success" && obj.id && obj.email) {
				// block_page1();
				// // var baseUrl = 'http://localhost:8090/tt/Otp/sendOtp'; 
				// var baseUrl = root + 'Otp/sendOtp'; 

				// var data = {
					// user_id: obj.id,
					// email: obj.email,
					// user_name:obj.username
				// };

				// fetch(baseUrl, {
					// method: 'POST',
					// headers: {
						// 'Content-Type': 'application/json',
					// },
					// body: JSON.stringify(data)
				// })
				// .then(response => response.json())
				// .then(responseData => {
					// console.log('Server response:', responseData);
					// if (responseData.success) {
						// console.log('OTP request sent successfully');
						// // window.location.href = 'http://localhost:8090/tt/Otp/index';
						// window.location = root + 'Otp/index';
						
					// } 
					// else 
					// {
						// console.error('Failed to send OTP request:', responseData.error);
					// }
				// })
				// .catch(error => {
					// console.error('Error sending OTP request:', error);
				// });	
				 	// var remember=$('input[name=remember]:Checked').val();
					// if(remember=="1")
					// {
						// $.cookie("remember_me", $("#username").val(), { expires : 1, path:"/" });
						// $.cookie("password", $("#password").val(), { expires : 1, path:"/" });
					// }
					// else
					// {
						// $.cookie("remember_me", $("#username").val(), { expires : -1, path:"/" });
						// $.cookie("password", $("#password").val(), { expires : -1, path:"/" });
					// }
				 	 // window.location=root+'Dashboard/index'; 
				// }
			    // else if(obj.res=="reject")
				// {
				    // $(".renewplan").show();
				    // $(".login_msg").html("Login Rejected. Your subscription plan is over. Please contact software provider ZUKU team.");
				    // unblock_page("error","Login Rejected. Your subscription plan is over. Please contact software provider ZUKU team.");
				    // $("#plan_amount").val(obj.amount);
				// }
				// else if(obj.res=="blank_no")
				// { 
					// $(".renewplan").show();
					// $("#plan_amount").val(obj.amount);
					// $(".login_msg").html("Please make payment for use ZUKU Software");
					// unblock_page("error","Please make payment for use ZUKU Software") 
				// }
				// else if(obj.res=="invaild")
			    // {
				    // unblock_page("error","Username & Password Invaild");
				// }
				// else if(obj.res=="blank")
				// { 
					// unblock_page("error","Username * Password Blank.") 
				// }
            // },
            // error: function(jqXHR, textStatus, errorThrown) {
                // console.log(errorThrown);
            // }
	// });
// });

var BrowserDetect = {
		init: function () {
			this.browser = this.searchString(this.dataBrowser) || "An unknown browser";
			this.version = this.searchVersion(navigator.userAgent)
				|| this.searchVersion(navigator.appVersion)
				|| "an unknown version";
			this.OS = this.searchString(this.dataOS) || "an unknown OS";
		},
		searchString: function (data) {
			for (var i=0;i<data.length;i++)	{
				var dataString = data[i].string;
				var dataProp = data[i].prop;
				this.versionSearchString = data[i].versionSearch || data[i].identity;
				if (dataString) {
					if (dataString.indexOf(data[i].subString) != -1)
						return data[i].identity;
				}
				else if (dataProp)
					return data[i].identity;
			}
		},
		searchVersion: function (dataString) {
			var index = dataString.indexOf(this.versionSearchString);
			if (index == -1) return;
			return parseFloat(dataString.substring(index+this.versionSearchString.length+1));
		},
		dataBrowser: [
			{
				string: navigator.userAgent,
				subString: "Chrome",
				identity: "Chrome"
			},
			{ 	string: navigator.userAgent,
				subString: "OmniWeb",
				versionSearch: "OmniWeb/",
				identity: "OmniWeb"
			},
			{
				string: navigator.vendor,
				subString: "Apple",
				identity: "Safari",
				versionSearch: "Version"
			},
			{
				prop: window.opera,
				identity: "Opera",
				versionSearch: "Version"
			},
			{
				string: navigator.vendor,
				subString: "iCab",
				identity: "iCab"
			},
			{
				string: navigator.vendor,
				subString: "KDE",
				identity: "Konqueror"
			},
			{
				string: navigator.userAgent,
				subString: "Firefox",
				identity: "Firefox"
			},
			{
				string: navigator.vendor,
				subString: "Camino",
				identity: "Camino"
			},
			{		// for newer Netscapes (6+)
				string: navigator.userAgent,
				subString: "Netscape",
				identity: "Netscape"
			},
			{
				string: navigator.userAgent,
				subString: "MSIE",
				identity: "Explorer",
				versionSearch: "MSIE"
			},
			{
				string: navigator.userAgent,
				subString: "Gecko",
				identity: "Mozilla",
				versionSearch: "rv"
			},
			{ 		// for older Netscapes (4-)
				string: navigator.userAgent,
				subString: "Mozilla",
				identity: "Netscape",
				versionSearch: "Mozilla"
			}
		],
		dataOS : [
			{
				string: navigator.platform,
				subString: "Win",
				identity: "Windows"
			},
			{
				string: navigator.platform,
				subString: "Mac",
				identity: "Mac"
			},
			{
				   string: navigator.userAgent,
				   subString: "iPhone",
				   identity: "iPhone/iPod"
			},
			{
				string: navigator.platform,
				subString: "Linux",
				identity: "Linux"
			}
		]

	};
	BrowserDetect.init();
</script>	
</html>