<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Fumigationpdf extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));

		 $this->load->model('Admin_create_fumigation', 'fumigation');
        $this->load->model('menu_model', 'menu');    
	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	// function index($id)
	// {
		// if(!empty($this->session->id)  && $this->session->title == TITLE)
		 // {
			// $this->load->model('admin_company_detail');	
			// $company = $this->admin_company_detail->s_select();
			// $data= $this->vgm->vgm_data($id);
			// $datap= $this->vgm->vgmtrn_data($data->vgm_id);
			// $menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			// $v = array( 
					  // 'consign_detail'=>$consign,
					  // 'exporter_detail'=>$exporter,
					  // 'menu_data'=>$menu_data,
					  // 'mode'=>'1',
					  // 'company_detail'=>$company,
					  // 'invoicedata'=>$data,
					  // 'vgmdata'=>$datap 
				 // );
			// $this->load->view('admin/view_fumigation',$v);
		// }
		// else
		// {
			// redirect(base_url().'');
		// }
	// }
	function view_pdf()
	{
			$this->load->model('admin_company_detail');    
            $company = $this->admin_company_detail->s_select();
            $data = $this->fumigation->select_invoice_data($id); 
            $menu_data = $this->menu->usermain_menu($this->session->usertype_id);    
            $v = array( 
                'menu_data'      => $menu_data,
                'mode'           => 'Add',
                'company_detail' => $company,
                'invoicedata'    => $data,
                'export_invoice_id' => $id 
            );
		 $this->load->view('admin/fumigationpdf',$v);
	}
	

 
}
