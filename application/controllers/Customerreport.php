<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Customerreport extends CI_controller{
	public function __construct(){		
			parent:: __construct();	
			 
			$this->load->model('Payment_list_model','payment');
			$this->load->model('menu_model','menu');
			if (!isset($_SESSION['id']) && $this->session->title == TITLE)
			{			
				redirect(base_url());		
			}	
	}	 	
	public function index($id)
 	{
		 if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {	
			$this->load->model('admin_company_detail');
			$data['company_detail'] = $this->admin_company_detail->s_select();
			$data['customer_id']	= $id;
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/customerreport',$data);
		}
		else
		{
			redirect(base_url().'');
		}			
	}	
	public function view_pdf()
	{
		$this->load->view('admin/customer_report_pdf');
	}		
	 
	 
}
?>