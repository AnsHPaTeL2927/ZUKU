<?php
defined("BASEPATH") or exit("no dericet script allowed"); 


class Exportinvoicesupplier extends CI_controller
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
			$data 					= $this->export->get_invoice_data($id);
			$supplier_data 			= $this->export->get_supplier();
			$export_supplier_data 	= $this->export->get_export_supplier($id);
			$product_data		 	= $this->export->get_suppiler_wise_data($id);
			$menu_data				= $this->menu->usermain_menu($this->session->usertype_id);	
			$productdata		 	= $this->export->get_packing_wise_size($id);
			$this->load->model('admin_company_detail');	
			$v = array( 
						'invoicedata'			=> $data,
						'menu_data'				=> $menu_data,
						'supplier_data'			=> $supplier_data,
						'export_supplier_data'	=> $export_supplier_data,
						'product_data'			=> $product_data,
						'productdata'			=> $productdata,
						'company_detail'		=> $this->admin_company_detail->s_select(),
				);
			$this->load->view('admin/exportinvoicesupplier',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function getsuppier_detail()
	{
		$id = $this->input->post('export_supplier_id');
	 
		$row = $this->export->getsuppier_detail($id);
		 $row->suppiler_invoice_date = date('d-m-Y',strtotime($row->suppiler_invoice_date));
		echo json_encode($row);
	}
	public function check_supplier()
	{
			$no = 0;
			foreach($this->input->post('export_loading_trn_id') as $row)
			{
				
					$data = array(
						'suppiler_id' 			=> $this->input->post('suppiler_id')[$no],
						'epcg_licence_no' 		=> $this->input->post('epcg_licence_no')[$no],
						'export_invoice_id'		=> $this->input->post('export_invoice_id'),
						'suppiler_invoice_date' => date('Y-m-d',strtotime($this->input->post('suppiler_invoice_date')[$no])),
						'suppiler_invoice_no' 	=> $this->input->post('suppiler_invoice_no')[$no],
						'suppiler_trn_id' 		=> $row,
						'suppiler_size_name' 	=> $this->input->post('size_type_mm')[$no],
						'status' => 0,
						);
						
					$check_in_suppiler = $this->export->check_export_suppiler($row);
				 
					if(empty($check_in_suppiler->export_supplier_id))
					{	
						$insert_suppiler = $this->export->insertsuppiler($data);
					}
					else
					{
						$insert_suppiler = $this->export->updatesuppiler($data,$check_in_suppiler->export_supplier_id);
					}
						$no++;
			}
				 
					$row1['res'] = 1;
			 	 
			$export_data['step'] = ($this->input->post('step')==4)?$this->input->post('step'):2;
			$export_data_update_id = $this->export->updateexport($export_data,$this->input->post('export_invoice_id'));
		echo json_encode($row1);
	}
	public function addsuppiler()
	{
	 	$data = array(
			'suppiler_id' 			=> $this->input->post('suppiler_id'),
			'epcg_licence_no' 		=> $this->input->post('epcg_licence_no'),
			'export_invoice_id' 	=> $this->input->post('export_invoice_id'),
			'suppiler_invoice_date' => date('Y-m-d',strtotime($this->input->post('suppiler_date'))),
			'suppiler_invoice_no' 	=> $this->input->post('suppiler_invoice_no'),
			'suppiler_trn_id' 		=> implode(",",$this->input->post('suppiler_product_id')),
			'suppiler_size_name' 	=> $this->input->post('suppiler_size_name'),
		 	'status' => 0,
			);
			$row['res'] = 0;
			$export_supplier_id = $this->input->post('export_supplier_id');
			if(empty($export_supplier_id))
			{		
				$insert_suppiler = $this->export->insertsuppiler($data);
			 	if($insert_suppiler)
				{ 
					$row['res'] = 1;
			 	}
				else
				{
					$row['res'] = 0;
				}
			}
			else
			{
				$update_suppiler = $this->export->update_suppiler($data,$export_supplier_id);
			 	if($update_suppiler)
				{ 
					$row['res'] = 2;
			 	}
				else
				{
					$row['res'] = 0;
				}
		 	}
				
		echo json_encode($row);

	}
	public function deleterecord()
	{
		$id = $this->input->post('export_supplier_id');
	 
		$deleterecord = $this->export->delete_export_supplier($id);
		if($deleterecord)
		{
			$row['res'] = '1';
		}
		else{
			$row['res'] = '0';
		}
		echo json_encode($row);
	}
}
