<?php 
class subcription 
{

    function renew_before_days() 
	{
		$CI =& get_instance();
		$CI->load->model('admin_company_detail');
		 
		$company_detail = $CI->admin_company_detail->checkrenew($CI->config->config["RENEW_DAYS"],CONFIGURATION);
		 
     	if(!empty($company_detail))
		{
			$_SESSION['subcription_duesoon'] = true;
			$_SESSION['subcription_due_days'] = $company_detail->subdues_days;
		}
		else
		{
			$_SESSION['subcription_duesoon'] = false;
		}
	}

}
?>