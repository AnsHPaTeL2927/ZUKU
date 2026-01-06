<?php
defined("BASEPATH") or exit("no dericet script allowed"); 
class Bank_detail extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		 
		$this->load->model('admin_bank_detail','bd');
		$this->load->model('menu_model','menu');	
	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index($bank="")
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
			$data['bank']= $this->bd->b_select();
			$this->load->model('admin_company_detail');
			$this->load->model('Pallet_order_party_model');
			$this->load->model('Cha_master_model');	
			$this->load->model('Admin_customer_detail');	
			$data['pallet_order_party']		= 	$this->Pallet_order_party_model->pallet_party($id);
			$data['customer_detail']		= 	$this->Admin_customer_detail->get_customer($id);
			$data['cha_master']				= 	$this->Cha_master_model->getsupplier_record($id);
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/bank_detail',$data);
		}
		else
		{
			$this->load->view('admin/index');
		}
	}


	public function manage()
	{
		$row['res'] = array();
		$_SESSION['otp'] = '';
		$check_bank = $this->bd->check_bank($this->input->post());
		
		$id = $this->input->post('eid');
	
		if(empty($check_bank) || !empty($id))
		{
			if($this->input->post('sent_msg') == "1")
			{
				$explode_mobile_no = explode("",$this->input->post('phone_no'));
				$otp = 0000;
				$send_otp = sent_msg($this->input->post('phone_no'),$otp);
				 
				$row['res'] = 4;
				$row['otp'] = $otp;
				$_SESSION['otp'] = $otp;
						
			}
			else
			{
				$data=array(
				
				'bank_name' 	=> $this->input->post('bank_name'),
				'bank_address' 	=> nl2br($this->input->post('bank_address')),
				'account_name' 	=> $this->input->post('account_name'),
				'account_no' 	=> $this->input->post('account_no'),
				'ifsc_code' 	=> $this->input->post('ifsc_code'),
				'bank_ad_code' 	=> $this->input->post('bank_ad_code'),
				'iban_number' 	=> $this->input->post('iban_number'),
				'swift_code' 	=> $this->input->post('swift_code')
				);
				
				
				
				if(empty($id))
				{
					$rdata = $this->bd->b_insert($data);
				
					if($rdata)
					{
						$row['res'] = 1;
						
						$row['bankname'] = $this->input->post('bank_name');
						$row['bank_id'] = $rdata;
					}
					else
					{
						$row['res'] = 0;
					}
		
				}
				else
				{
					$rs = $this->bd->b_edit($data,$id);
					if($rs)
					{
						$row['res'] = 2;
					}
				}
			}
			
			
		}
		else
		{
			$row['res'] = 3;
		}
		echo json_encode($row);
	}
	
	public function manage1()
	{
		$row['res'] = array();
		$_SESSION['otp'] = '';
		$check_bank = $this->bd->check_bank($this->input->post());
		
		$id = $this->input->post('eid');
	
		if(empty($check_bank) || !empty($id))
		{
			if($this->input->post('sent_msg') == "1")
			{
				$explode_mobile_no = explode("",$this->input->post('phone_no'));
				$otp =0000;
				$send_otp = sent_msg($this->input->post('phone_no'),$otp);
				 
				$row['res'] = 4;
				$row['otp'] = $otp;
				$_SESSION['otp'] = $otp;
						
			}
			else
			{
				$data=array(
				
				'bank_name' 	=> $this->input->post('bank_name'),
				'bank_address' 	=> nl2br($this->input->post('bank_address')),
				'account_name' 	=> $this->input->post('account_name'),
				'account_no' 	=> $this->input->post('account_no'),
				'ifsc_code' 	=> $this->input->post('ifsc_code'),
				'bank_ad_code' 	=> $this->input->post('bank_ad_code'),
				'iban_number' 	=> $this->input->post('iban_number'),
				'swift_code' 	=> $this->input->post('swift_code')
				);
				
				
				
				if(empty($id))
				{
					$rdata = $this->bd->b_insert1($data);
				
					if($rdata)
					{
						$row['res'] = 1;
						if($this->input->post('palletorderparty') == 1)
						{
							$data1 = array(
								'bank_id' 	=> $rdata
								);
								
								$rdata1 = $this->bd->update_pallet_party($data1,$this->input->post('eid1'));
						}
						else if($this->input->post('customerdetail') == 2)
						{
							$data2 = array(
								'bank_id' 	=> $rdata
								);
								
								$rdata2 = $this->bd->update_customer_detail($data2,$this->input->post('eid2'));
						}
						else if($this->input->post('chamaster') == 1)
						{
							$data3 = array(
								'bank_id' 	=> $rdata
								);
								
								$rdata3 = $this->bd->update_cha_detail($data3,$this->input->post('eid3'));
						}
						else if($this->input->post('forwarermaster') == 1)
						{
							$data4 = array(
								'bank_id' 	=> $rdata
								);
								
								$rdata4 = $this->bd->update_forwarer_detail($data4,$this->input->post('eid3'));
						}
						else if($this->input->post('suppliermaster') == 1)
						{
							$data5 = array(
								'bank_id' 	=> $rdata
								);
								
								$rdata5 = $this->bd->update_supplier_detail($data5,$this->input->post('eid3'));
						}
						$row['bankname'] = $this->input->post('bank_name');
						$row['bank_id'] = $rdata;
					}
					else
					{
						$row['res'] = 0;
					}
		
				}
				else
				{
					$rs = $this->bd->b_edit1($data,$id);
					if($rs)
					{
						$row['res'] = 2;
					}
				}
			}
			
			
		}
		else
		{
			$row['res'] = 3;
		}
		echo json_encode($row);
	}

	public function form_edit()
	{
		 
		 $id = $this->input->post('id');
		
	 	 $data				 = $this->bd->b_form_edit($id);
		 $data->bank_address = strip_tags($data->bank_address);
		 echo json_encode($data);
	}
	
	public function form_edit1()
	{
		 
		 $id = $this->input->post('id');
		
	 	 $data				 = $this->bd->b_form_edit1($id);
		 $data->bank_address = strip_tags($data->bank_address);
		 echo json_encode($data);
	}

	public function del(){
		$id = $this->input->post('id');
		$deleteid = $this->bd->b_del($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}

	 
}



?>