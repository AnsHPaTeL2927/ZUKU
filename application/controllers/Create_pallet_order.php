<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Create_pallet_order extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
	 
		$this->load->model('Admin_pdf','po');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}
 	function index($id)
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $this->load->model('admin_company_detail');	
			$company			=	$this->admin_company_detail->s_select();
		 
			$getpallet_type		= $this->po->get_pallet_type();
			$producation_data 	= $this->po->producation_mst_data($id);  
		 	$producation_trn 	= $this->po->producation_trn_data($id);  
			$pallet_order_party	= $this->po->get_pallet_order_pary();
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			 
		 	$v = array(
					'palletpary_detail'	=>	$pallet_order_party,
					'menu_data'			=>	$menu_data,
					'pallet_type_data'	=>	$getpallet_type,
					'invoicedata'		=>	$producation_data,
				 	'company_detail'	=>	$company,
				 	'packing_data'		=>	$producation_trn,
					"mode"				=>	"Add"
				);
			$this->load->view('admin/create_pallet_order',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function edit($id)
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$company			= $this->po->company_select();
			$bank				= $this->po->bselect($bankid);
			$data				= $this->po->pallet_order($id);
			$supplier			= $this->po->select_supplier();
			$pallet_order_party	= $this->po->get_pallet_order_pary();
			$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			$getpallet_type		= $this->po->get_pallet_type();
			 
		 	$v = array(
					'palletpary_detail'	=>	$pallet_order_party,
					'supplier_detail'	=>	$supplier,
					'menu_data'			=>	$menu_data,
					'invoicedata'		=>	$data,
					'pallet_type_data'	=>	$getpallet_type,
				 	'company_detail'	=>	$company,
				 	'packing_data'		=>	$this->po->palletordertrn($data->pallet_order_id),
					"mode"				=>	"Edit"
				);
			$this->load->view('admin/create_pallet_order',$v);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	function manage(){
		
		$data = array(
			'production_mst_id' => ($this->input->post('production_mst_id')),
			'pallet_party_id' 	=> $this->input->post('pallet_party_id'),
		 	'export_detail'		=> nl2br($this->input->post('export_detail')),
			'factory_address' 	=> nl2br($this->input->post('factory_address')),
			'supplier_detail' 	=> nl2br($this->input->post('supplier_detail')),
			'cdate' 			=> date('Y-m-d H:i:s'),
			'status' => 0
			 
			);
			$row['res'] = 0;
			 if(strtolower($this->input->post('mode'))=="add")
			{				
				  
				$rdata = $this->po->insert_pallet_order($data);
				
				if($rdata)
				{	
					$no=0;
					foreach($this->input->post('size_type_mm') as $pallet_order_trn)
					{
						$data_trn = array(
							'pallet_order_id' 		=> $rdata,
							'description' 			=> $this->input->post('size_type_mm')[$no],
							'product_id' 			=> $this->input->post('product_id')[$no],
							'no_of_pallet'	 		=> $this->input->post('no_of_pallet')[$no],
							'no_of_big_pallet'		=> $this->input->post('no_of_big_pallet')[$no],
							'no_of_small_pallet'	=> $this->input->post('no_of_small_pallet')[$no],
							'boxes_per_pallet'		=> $this->input->post('boxes_per_pallet')[$no],
							'box_per_big_pallet'	=> $this->input->post('box_per_big_pallet')[$no],
							'box_per_small_pallet'	=> $this->input->post('box_per_small_pallet')[$no],
							'pallet_type' 			=> $this->input->post('pallet_type')[$no],
							'factory'				=> $this->input->post('factory_name')[$no],
							'rate_per_pallet'				=> $this->input->post('rate_per_pallet')[$no],
							'rate_per_big_pallet'				=> $this->input->post('rate_per_big_pallet')[$no],
							'rate_per_small_pallet'				=> $this->input->post('rate_per_small_pallet')[$no],
							'total_amount'				=> $this->input->post('total_amount')[$no],
							'remarks'				=> $this->input->post('remarks')[$no],
							'cdate' 				=> date('Y-m-d H:i:s') 
						);
						$rdata_trn = $this->po->insert_pallet_order_trn($data_trn);
						$no++;
					}
					$row['res'] = 1;
					$row['pallet_order_id'] = $this->input->post('production_mst_id');
				}
			}
			else if(strtolower($this->input->post('mode'))=="edit")
			{
				 
				$id = $this->input->post('purchase_order_id');
				$rs = $this->po->pallet_order_update($data,$id);
				$rs = $this->po->pallet_order_trn_delete($this->input->post('pallet_order_id'));
				$no=0;
				
					foreach($this->input->post('size_type_mm') as $pallet_order_trn)
					{
						$data_trn = array(
							'pallet_order_id' 		=> $this->input->post('pallet_order_id'),
							'description' 			=> $this->input->post('size_type_mm')[$no],
							'product_id' 			=> $this->input->post('product_id')[$no],
							'no_of_pallet'	 		=> $this->input->post('no_of_pallet')[$no],
							'no_of_big_pallet'		=> $this->input->post('no_of_big_pallet')[$no],
							'no_of_small_pallet'	=> $this->input->post('no_of_small_pallet')[$no],
							'boxes_per_pallet'		=> $this->input->post('boxes_per_pallet')[$no],
							'box_per_big_pallet'	=> $this->input->post('box_per_big_pallet')[$no],
							'box_per_small_pallet'	=> $this->input->post('box_per_small_pallet')[$no],
							'factory'				=> $this->input->post('factory_name')[$no],
							'rate_per_pallet'		=> $this->input->post('rate_per_pallet')[$no],
							'rate_per_big_pallet'		=> $this->input->post('rate_per_big_pallet')[$no],
							'rate_per_small_pallet'		=> $this->input->post('rate_per_small_pallet')[$no],
							'total_amount'			=> $this->input->post('total_amount')[$no],
							'remarks'				=> $this->input->post('remarks')[$no],
							'pallet_type' 			=> $this->input->post('pallet_type')[$no],
							'cdate' 				=> date('Y-m-d H:i:s') 
						);
						$rdata_trn = $this->po->insert_pallet_order_trn($data_trn);
						$no++;
					}
					$row['res'] = 2;
					$row['pallet_order_id'] = $this->input->post('production_mst_id');
			}
		echo json_encode($row);

	} 
	
}
