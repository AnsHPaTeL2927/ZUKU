
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-120896120-3"></script>
 <div class="footer clearfix">
			<div class="footer-inner">
				<?=date('Y')?> &copy; <?=TITLE?>
			</div>
			<div class="footer-items">
				<span class="go-top"><i class="clip-chevron-up"></i></span>
			</div>
		</div>
		<script src="<?=base_url('adminast/assets/plugins/jQuery-lib/2.0.3/jquery.min.js')?>"></script>
		<script type="text/javascript" src="<?=base_url()?>adminast/assets/js/jquery.dataTables.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/buttons.html5.min.js"></script> 
		<script src="<?=base_url()?>adminast/assets/js/buttons.print.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/pdfmake.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/vfs_fonts.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/jquery-ui/jquery-ui-1.10.2.custom.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap/js/bootstrap.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/bootstrap-toggle.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/jquery-ui.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/jquery.blockUI.js"></script>
	 	<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-fileupload/bootstrap-fileupload.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/jquery-cookie/jquery.cookie.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/select2/select2.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-daterangepicker/moment.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/plugins/bootstrap-daterangepicker/daterangepicker.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/jquery.validate.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/toastr.js"></script>
	 	<script src="<?=base_url()?>adminast/assets/js/sweetalert.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/jquery.table2excel.js"></script>	
		<script src="<?=base_url()?>adminast/assets/js/jquery.fancybox.min.js"></script>
		<script src="<?=base_url()?>adminast/assets/js/jquery.dragscroll.js"></script>
<script type="text/javascript">
function numberWithCommas(x) {
    return x.toString().split('.')[0].length > 3 ? x.toString().substring(0,x.toString().split('.')[0].length-3).replace(/\B(?=(\d{2})+(?!\d))/g, ",") + "," + x.toString().substring(x.toString().split('.')[0].length-3): x.toString();
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
function unblock_page(type,msg)
{
	   if(type!=="" && msg!=="")
	   {
		toastr[type](msg)
	   }
	   setTimeout($.unblockUI, 500); 
   }
function js_change_hsnc(id){
			var hsnc_value =id;
			document.getElementById('hsnc_code_value').value = hsnc_value;
		  }
function isNumber(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 46 || charCode > 57)) {
        return false;
    }
    return true;
}
function main_delete(id,passurl,returnurl)
{
	Swal.fire({
  title: 'Are you sure?',
  type: 'info',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Yes, do it!'
}).then((result) => {
  if (result.value) {
	 block_page();
			  $.ajax({ 
              type: "POST", 
              url: root+passurl,
              data: {
                "id": id
              }, 
              cache: false, 
              success: function (data) { 
				var obj = JSON.parse(data);
				if(obj.res==1)
				{
					unblock_page('success',"Record Successfully Deleted");
					setTimeout(function(){ window.location=root+returnurl; },1500);
				}
                else{
					unblock_page('error',"Somthing Wrong.")
				}
              }
			});
  }
});
}
function openNav()
 {
  document.getElementById("mySidenav").style.width = "225px";
  $(".main-content").css("margin-left","225px")
  $(".navigation-toggler").css("margin-left","175px")
  $(".main-navigation-menu li .title").show();
   $(".navigation-toggler").attr("onclick","closeNav()")
}
function closeNav() 
{
  document.getElementById("mySidenav").style.width = "51px";
  $(".main-content").css("margin-left","50px")
  $(".navigation-toggler").css("margin-left","10px")
  $(".main-navigation-menu li .title").hide();
  $(".navigation-toggler").attr("onclick","openNav()")
}
</script>
  <script type="text/javascript">
	$(".tooltips").tooltip();       
function check_pallet(val,status)
{
	if(val==1)
	{
		if(status == true)
		{
			$(".pallet_calcution").show();
		}
		else
		{
			$(".pallet_calcution").hide();
		}
	}
	else if(val==2)
	{
		if(status == true)
		{
			$(".boxes_calculation").show();
		}
		else
		{
			$(".boxes_calculation").hide();
		} 
	}
	else if(val==3)
	{
		if(status == true)
		{
			$(".multipallet_calcution").show();
		}
		else
		{
			$(".multipallet_calcution").hide();
		}
	}
	allcalculation();	
}
  
 function price_cal(price_typeval)
{
		   var priceperboxval = jQuery('input[name="priceperbox"]').val();
		  if(priceperboxval>0)
		  {
			var usdprice = $("#usd_price").val();
			var europrice = $("#euro_price").val();
            var pcsperboxval = jQuery('input[name="pcsperbox"]').val();
            var sizeval = jQuery('#size').val();
            var seriesval = jQuery('#series').val();
            var boxperpltval = jQuery('input[name="boxperplt"]').val();
            var nopltcontainerval = jQuery('input[name="nopltcontainer"]').val();
            var appsqmperboxval = jQuery('input[name="appsqmperbox"]').val();
            var apwigtperboxval = jQuery('input[name="apwigtperbox"]').val();
            var boxpercontainval = boxperpltval * nopltcontainerval;
            var size_width_mmval = jQuery('#size_width_mm').val();
            var size_height_mmval = jQuery('#size_height_mm').val();
            var size_width_cmval = jQuery('#size_width_cm').val();
            var size_height_cmval = jQuery('#size_height_cm').val();
            var plat_weightval = jQuery('#plat_weight').val();
            var size_typeval = jQuery('input[name="size_type"]').val();
			var sqftval = 10.76;
			 if(size_typeval == 'cm')
			   {
				 var appsqmperboxvalcm = size_width_cmval * size_height_cmval *pcsperboxval * 100 / 1000000;
				 var sqmpercontainvalcm = boxpercontainval * appsqmperboxvalcm;
			   }
			   else
			   {
					var appsqmperboxval = size_width_mmval * size_height_mmval * pcsperboxval / 1000000;
					 var sqmpercontainval= boxpercontainval * appsqmperboxval;
			   }
          var sqftval = 10.76;
           if(price_typeval == 'Feet')
          {
            var sqmpriceval = priceperboxval * sqftval;
            var usd = sqmpriceval/usdprice;
            var euro = sqmpriceval/europrice;
            var usd_price_Value = usd.toFixed(2);
            var euro_price_Value = euro.toFixed(2);
            jQuery('input[name="sqmprice"]').val(sqmpriceval.toFixed(2));
            jQuery('#sqmprice_usd').val(usd_price_Value);
            jQuery('#sqmprice_euro').val(euro_price_Value);
          }
          else if(price_typeval == 'Box')
          {
			var sqmpriceval = priceperboxval/appsqmperboxval;
			var usd = sqmpriceval/usdprice;
            var euro = sqmpriceval/europrice;
            var usd_price_Value = usd.toFixed(2);
            var euro_price_Value = euro.toFixed(2);
            jQuery('input[name="sqmprice"]').val(sqmpriceval.toFixed(2));
            jQuery('#sqmprice_usd').val(usd_price_Value);
            jQuery('#sqmprice_euro').val(euro_price_Value);
          } 
          else if(price_typeval == 'SQM')
          {
            var sqmpriceval = priceperboxval*1;
            var usd = sqmpriceval/usdprice;
            var euro = sqmpriceval/europrice;
            var usd_price_Value = usd.toFixed(2);
            var euro_price_Value = euro.toFixed(2);
            jQuery('input[name="sqmprice"]').val(sqmpriceval.toFixed(2));
            jQuery('#sqmprice_usd').val(usd_price_Value);
            jQuery('#sqmprice_euro').val(euro_price_Value);
          }
		  }
 } 
function cal_price()
{ 
	price_cal($("#price_type").val())
}	 
 
			var dropdown = document.getElementsByClassName("dropdown-btn");
			var i;
			for (i = 0; i < dropdown.length; i++) {
			  dropdown[i].addEventListener("click", function() {
			  this.classList.toggle("active");
			  var dropdownContent = this.nextElementSibling;
			  if (dropdownContent.style.display === "block") {
			  dropdownContent.style.display = "none";
			  } else {
			  dropdownContent.style.display = "block";
			  }
			  });
			}
			$(function(){
			    var this_url = window.location.pathname;
			    var list_sidebar_link = $(".dropdown-container a");
			    $(list_sidebar_link).each(function (i, item) {
			        var the_a = list_sidebar_link[i];
			        if (this_url == $(the_a).attr('href')) {
			            $(the_a).addClass('active');
			        }
			    });
			});
function do_payment()
{
	$("body").addClass('swal-wide');
	Swal.fire({
   title: 'Account Expiration',
   customClass: 'swal-wide',
    html:
    "Your Subscription will be expired in <b><?=$_SESSION['subcription_due_days']?></b> Day(s) </br> " +
    " --Please renew for uninterrupted service -- ",
   type: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  allowOutsideClick: false,
  backdrop: true,
  confirmButtonText: 'Make Payment',
  cancelButtonText: 'Pay Letter'
  
}).then((result) => {
  if (result.value) {
	 window.location = root+'pay/index/<?=SUB_AMOUNT?>';
  }
  else
  {
	 $("body").removeClass('swal-wide'); 
  }
});
	 
}
<?php 

if($_SESSION['subcription_duesoon'] == true)
{
 	if(empty($_SESSION["loginTime"]))
	{
		 echo "do_payment();";
		 $_SESSION["loginTime"] = time();
	}
	else if($_SESSION["timeLogged"] > 1800)
	{
		 echo "do_payment();";
	 	 $_SESSION["timeLogged"] = '';
	 	 $_SESSION["loginTime"] = '';
	}
 	else if(!empty($_SESSION["timeLogged"]) || !empty($_SESSION["loginTime"]))
	{
		$_SESSION["timeLogged"] = time() - $_SESSION["loginTime"];
	}
}
else
{
	$_SESSION["timeLogged"] = '';
	$_SESSION["loginTime"] = '';
}
?>
</script>


 </body>	 
 <script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());
  gtag('config', 'UA-120896120-3');
</script>
</html>
