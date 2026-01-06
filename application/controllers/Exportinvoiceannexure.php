<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Exportinvoiceannexure extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_exportinvoice_product','export');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data= $this->export->get_invoice_data($id);
			 	$datap = $this->export->getinvoiceproductdata($id);
			 
			 $container_data = $this->export->get_container_data($id,$datap[0]->export_invoice_id,$data->performa_invoice_id);
			$this->load->model('admin_company_detail');
			$userdata 		 		= $this->export->ciadmin_login();		
			$get_company_branch 		 		= $this->export->get_company_branch();		
			$get_annexuredata	 	= $this->export->getannexuredata($id);	
			$export_supplier_data 	= $this->export->get_export_supplier($id);
			$menu_data	 	= $this->menu->usermain_menu($this->session->usertype_id);	
						
			$v = array(
						'invoicedata'			=> $data,
						'product_data'			=> $datap,
						'company_detail'		=> $this->admin_company_detail->s_select(),
						'allproduct'			=> $this->export->allproductsize(),
					 	'menu_data'				=> $menu_data,
						'userdata'				=> $userdata,
						'get_company_branch'				=> $get_company_branch,
						'export_supplier_data'	=> $export_supplier_data,
						'direct_invoice'		=> $data->direct_invoice,
						'container_data'		=> $container_data,
						'annexuredata'			=> $get_annexuredata
						);
			$this->load->view('admin/exportinvoiceannexure',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}

	function manage()
	{
		
		$data = array(
			'export_invoice_id'			=> $this->input->post('export_invoice_id'),
		 	'commissionrate' 			=> $this->input->post('commissionerate'),
		 	'division' 					=> $this->input->post('division'),
		 	'ex_range' 					=> $this->input->post('range'),
			'c_no' 						=>  $this->input->post('c_no'),
			'c_date' 					=> date('Y-m-d',strtotime($this->input->post('c_date'))),
			'Shipping_bill_no' 			=> $this->input->post('Shipping_bill_no'),
			'Shipping_date' 			=> date('Y-m-d',strtotime($this->input->post('Shipping_date'))),
			'examination_date' 			=> date('Y-m-d',strtotime($this->input->post('examination_date'))),
			'name_of_superintendent' 	=> $this->input->post('name_of_superintendent'),
			'annexure_remarks' 			=> nl2br($this->input->post('annexure_remarks')),
			'description_goods_status' 	=> $this->input->post('description_goods_status'),
			'drawn_port_export' 		=> $this->input->post('drawn_port_export'),
			'seal_yesno' 				=> $this->input->post('seal_yesno'),
			'containerized_cargo' 		=> $this->input->post('containerized_cargo'),
			'company_branch_id' 		=> $this->input->post('company_branch_id'),
			'status' 					=> '0',
			'cdate' 					=> date('Y-m-d H:i:s')
			);
			 
	 
		 $id = $this->input->post('export_annexure_id');
		if(empty($id))
		{
			$step = 4;
			$updatestepinvoice = $this->export->export_invoice_stepupdate($this->input->post('export_invoice_id'),$step,0);
			$rdata = $this->export->insert_exportannexurerecord($data);
			if($rdata)
			{	
				$row['res'] = "1";
			}
		}
		else
		{
			$step = 4;
			$updatestepinvoice = $this->export->export_invoice_stepupdate($this->input->post('export_invoice_id'),$step,0);
			
			$rdata = $this->export->update_exportannexurerecord($data,$id);
			if($rdata)
			{	
				$row['res'] = "2";
			}
		}
		if(!empty($this->input->post('advance_payment_id')))
		{
			$this->load->model('Payment_list_model','payment');
			 $get_advance = $this->export->get_advance_payment($this->input->post('advance_payment_id'));
			 if($get_advance->paid_amount > $this->input->post('grand_total'))
			 {
				 $data=array(
					'date' 					=> $get_advance->date,
					'customer_id' 			=> $get_advance->customer_id,
					'payment_recieve_type' 	=> $get_advance->payment_recieve_type,
					'bill_id' 				=> '',
					'payment_mode_id' 		=> $get_advance->payment_mode_id,
					'paid_amount' 			=> ($get_advance->paid_amount - $this->input->post('grand_total')),
					'bank_id' 				=> $get_advance->bank_id,
					'refernace_no' 		 	=> $get_advance->refernace_no,
					'bank_charge' 		 	=> $get_advance->bank_charge,
					'remarks'		 		=> nl2br($get_advance->remarks),
					'total_payment'		 	=> ($get_advance->paid_amount - $this->input->post('grand_total')),
					'status'				=> 3,
					'cdate'					=> date('Y-m-d H:i:s')
				);
				$rdata = $this->payment->insert_payment($data);
			 }
		}
		echo json_encode($row);

	}
	 
	
}
