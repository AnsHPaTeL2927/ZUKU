<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_supplier extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		 
		$this->load->model('supplier_list_model','supplier');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function index($m="")
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['mode']			= "Add";
			$this->load->model('admin_currency_list');	
			$data['currencydata'] 	= $this->admin_currency_list->getcurrencydata();
			$data['epcgdata']		= 1;
			$data['menu_data']		= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/add_supplier',$data);	
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }			
	}
	
	public function download($permission_doc = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('./upload/'.$permission_doc));
		force_download($permission_doc, $data);
	}
	
	public function manage()
	{
		
		$check_com_name = $this->supplier->check_company_name($this->input->post('company_name'));
		
		 $data=array(
			'company_name' 				=> $this->input->post('company_name'),
			'supplier_gstno' 			=> $this->input->post('supplier_gstno'),
			'supplier_panno' 			=> $this->input->post('supplier_panno'),
			'supplier_iecno' 			=> $this->input->post('supplier_iecno'),
			'address' 					=> nl2br($this->input->post('supplier_address')),
			'supplier_other_company' 			=> $this->input->post('supplier_other_company'),
			'supplier_name' 			=> $this->input->post('supplier_name'),
			'supplier_contactno' 		=> $this->input->post('supplier_contactno'),
			'permission_no' 			=> $this->input->post('permission_no'),
			'permission_file_no' 		=> $this->input->post('permission_file_no'),
			'permission_date' 			=> date('Y-m-d',strtotime($this->input->post('permission_date'))),
			'circular_date' 			=> date('Y-m-d',strtotime($this->input->post('sup_circular_date'))),
			'expiry_date' 				=> $this->input->post('expiry_date'),
		 	'issue_authority_address' 	=> nl2br($this->input->post('issue_authority_address')),
		 	'payment_terms'			  	=> nl2br($this->input->post('supplier_payment_terms')),
		 	'division'					=> $this->input->post('supplier_division'),
		 	'sup_range'				 	=> $this->input->post('sup_range'),
		 	'location_code'			 	=> $this->input->post('sup_location_code'),
			'remarks_po'			 	=> $this->input->post('remarks_po'),
			'remarks_sheet'			 	=> $this->input->post('remarks_sheet'),
		 	'circular_no'			 	=> $this->input->post('sup_circular_no'),
			'cdate'						=> date('Y-m-d H:i:s')
			);
			
			
			 if(strtolower($this->input->post('mode'))=="add")
			 {
				 
				if(empty($check_consigne))
				{
					if($_FILES['permission_doc']['name'] != "")
					{
						$this->load->library('upload');
						$config = array();
						$extension = end(explode(".",$_FILES['permission_doc']['name']));
						$config['file_name'] = 'permission_doc'.rand(0,9999).'.'.$extension;
						$config['upload_path'] = './upload/';
						$config['allowed_types'] = 'pdf|doc';
						$config['max_size']      = '5000';
						$config['overwrite']     = FALSE;
					
						$this->upload->initialize($config);
						$this->upload->do_upload('permission_doc');
						$upload_image = $this->upload->data();
						$data['permission_doc']  = $upload_image['file_name'];
					}
					$rdata = $this->supplier->supplierinsert($data);
					if(!empty($rdata))
					{
						if(!empty($this->input->post('supplier_contactno')) && !empty($this->input->post('company_name')) && !empty($this->input->post('supplier_name')))
						{
						
							$send_otp = send_suppiler_msg($this->input->post('supplier_contactno'),$this->input->post('company_name'),$this->input->post('supplier_name'));
						}
						$check_box_design = $this->supplier->check_terms_update($this->input->post('supplier_payment_terms'));
						if(empty($check_box_design ))
						{
						 $data1 = array(
											
										'payment_terms' 		=> $this->input->post('supplier_payment_terms')	
								);	
							$pdata = $this->supplier->terms_insert($data1);
						}
						
						
							$row['supplier_id'] = $rdata;
							$row['supplier_name'] = $this->input->post('supplier_name');
							$row['company_name'] = $this->input->post('company_name');
							
							$row['res'] = 1;
					}
					else
					{
						$row['res'] = 0;
					}
				  
				}
				else
				{
					$row['res'] = 3;
				}
			 }
			else
			{
				if($_FILES['permission_doc']['name'] != "")
				{
					$deletedata = $this->supplier->getsupplier_record($id);
					unlink('upload/'.$deletedata->permission_doc);
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['permission_doc']['name']));
					$config['file_name'] = 'permission_doc'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = 'pdf|doc';
					$config['max_size']      = '5000';
					$config['overwrite']     = FALSE;

					$this->upload->initialize($config);
					$this->upload->do_upload('permission_doc');
					$upload_image = $this->upload->data();
					 
					$data['permission_doc']  = $upload_image['file_name'];
					
				}
				
				$id = $this->input->post('sup_id');
				if(!empty($id))
				{					
					if(empty($check_com_name) || $this->input->post('edit_companyname') == $this->input->post('company_name'))
					{
			 
						$rdata = $this->supplier->supplierupdate($data,$id);
						if($rdata)
						{
							$row['res'] = 2;
							
						}
						else{
							$row['res'] = 0;
						}
				    }
				    else
				    {
						$row['res'] = 3;
				    }
				}
			}
		
		echo json_encode($row);
		
	}	

	public function form_edit($id){

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data['edit_record']=$this->supplier->getsupplier_record($id);
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select(); 
			$data['mode']="Edit";
			$this->load->model('admin_currency_list');	
			$data['currencydata'] = $this->admin_currency_list->getcurrencydata();
			$data['epcgdata']	= $this->supplier->get_epcg_data($id);
			$data['menu_data']		= $this->menu->usermain_menu($this->session->usertype_id);	
			
		 	$this->load->view('admin/add_supplier',$data);
		}
		else
		{
			
			redirect(base_url().'');
		}		

	}
	
	public function search(){
 
	$term = $this->input->get('term');
 
			$url = 'http://localhost/zuku_api/Payment_data';
			$ch = curl_init($url);
			$headers = array(
				'Content-Type:application/json',
				'Authorization: Basic cnBAZ21haWwuY29tOmFkbWlu' // <---
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			$result = curl_exec($ch);
			 
			curl_close($ch);
			 
         echo $result;
    } 
	 
	public function search1(){
 
        $term = $this->input->get('term');
 
			$url = 'http://localhost/zuku_api/Supplier_data';
			$ch = curl_init($url);
			$headers = array(
				'Content-Type:application/json',
				'Authorization: Basic ZGV2Lnp1a3VAZ21haWwuY29tOmFkbWlu' // <---
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			$result = curl_exec($ch);
			 
			curl_close($ch);
			 
         echo $result;
    }

	public function searchgstno(){
 
        $term = $this->input->get('term');
 
        $url = 'http://localhost/zuku_api/Supplier_data';
			$ch = curl_init($url);
			$headers = array(
				'Content-Type:application/json',
				'Authorization: Basic ZGV2Lnp1a3VAZ21haWwuY29tOmFkbWlu' // <---
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			$result = curl_exec($ch);
			 
			curl_close($ch);
			 
         echo $result;
    } 	
	
	public function searchpanno(){
 
        $term = $this->input->get('term');
 
       $url = 'http://localhost/zuku_api/Supplier_data';
			$ch = curl_init($url);
			$headers = array(
				'Content-Type:application/json',
				'Authorization: Basic ZGV2Lnp1a3VAZ21haWwuY29tOmFkbWlu' // <---
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			$result = curl_exec($ch);
			 
			curl_close($ch);
			 
         echo $result;
    } 	
	
	public function searchiecno()
	{
 
        $term = $this->input->get('term');
 
        $url = 'http://localhost/zuku_api/Supplier_data';
			$ch = curl_init($url);
			$headers = array(
				'Content-Type:application/json',
				'Authorization: Basic ZGV2Lnp1a3VAZ21haWwuY29tOmFkbWlu' // <---
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			$result = curl_exec($ch);
			 
			curl_close($ch);
			 
         echo $result;
    } 	
	
	public function searchaddress(){
 
        $term = $this->input->get('term');
 
      $url = 'http://localhost/zuku_api/Supplier_data';
			$ch = curl_init($url);
			$headers = array(
				'Content-Type:application/json',
				'Authorization: Basic ZGV2Lnp1a3VAZ21haWwuY29tOmFkbWlu' // <---
			);
			curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			
			$result = curl_exec($ch);
			 
			curl_close($ch);
			 
         echo $result;
   } 
	
	// public function searchaddress(){
 
        // $term = $this->input->get('term');
 
        // $this->db->like('authority_address', $term);
		// $this->db->limit(5);
		// $this->db->where('status',"0");
		// $this->db->where('is_active',"Yes");
        // $data = $this->db->get("tbl_authority_address")->result();
 
        // echo json_encode($data);
    // } 
	 

	 
}
?>