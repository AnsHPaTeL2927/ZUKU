<?php 
class application_company 
{

    function check_company() 
	{

        $CI =& get_instance();
		$CI->load->model('admin_company_detail');
		$company_detail = $CI->admin_company_detail->s_select();
        
		define("TITLE",$company_detail[0]->s_name);
		
    }

}
?>