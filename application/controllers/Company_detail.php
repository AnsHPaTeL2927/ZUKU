<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Company_detail extends CI_controller{
		
		public function __construct(){
			parent:: __construct();
			 
			 $this->load->model('admin_company_detail','com_detail');
			$this->load->model('menu_model','menu');	
	
			if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
				redirect(base_url());
			}
		}	
	 	public function index($m="")
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$this->load->model('admin_bank_detail','bd');
				$this->load->model('admin_company_detail');	
				$data 				= $this->com_detail->s_edit_select(1);	
				$bank_detail	 	= $this->bd->b_form_edit($data->bank_name);	
				$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
				$v = array(
					'fd'			 => 'edit',
					'fdv'			 => $data,
					'bank_detail'	 => $bank_detail,
					'result' 		 => $this->bd->b_select(),
					'company_detail' => $this->admin_company_detail->s_select(),
					'menu_data'		 => $menu_data
				);
				$this->load->view('admin/company_detail',$v);	
			}
			else
			{
				$this->load->view('admin/index');
			}	
		}
		public function document()
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				$this->load->model('admin_bank_detail','bd');
				$this->load->model('admin_company_detail');	
				$data 				= $this->com_detail->document_data(1);	
				$bank_detail	 	= $this->bd->b_form_edit($data->bank_name);	
				$menu_data			= $this->menu->usermain_menu($this->session->usertype_id);	
			
				$v = array(
					'fd'			 => 'edit',
					'company_doc'	 => $data,
					'bank_detail'	 => $bank_detail,
					'result' 		 => $this->bd->b_select(),
					'company_detail' => $this->admin_company_detail->s_select(),
					'menu_data'		 => $menu_data
				);
				$this->load->view('admin/company_document',$v);	
			}
			else
			{
				$this->load->view('admin/index');
			}	
		}
		public function form()
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 {
				
				$this->load->model('admin_bank_detail','bd');
				$data = array('fd' => 'manage', 'result' => $this->bd->b_select());
				$v['fd']= 'manage';
				$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
				$this->load->model('admin_company_detail');	
				$data['company_detail'] = $this->admin_company_detail->s_select();	
				$this->load->view('admin/company_detail',$data);
			}
			else
			{
				$this->load->view('admin/index');
			}	
		}
		
		public function manage()
		{
			$this->load->library('upload');
			$dataInfo = array();
			$files = $_FILES;
			$cpt = count($_FILES['image']['name']);
            
			for($i=0; $i<$cpt; $i++)
			{           
				$_FILES['image']['name']= $files['image']['name'][$i];
				$_FILES['image']['type']= $files['image']['type'][$i];
				$_FILES['image']['tmp_name']= $files['image']['tmp_name'][$i];
				$_FILES['image']['error']= $files['image']['error'][$i];
				$_FILES['image']['size']= $files['image']['size'][$i];    
            
				$this->upload->initialize($this->set_upload_options());
				$this->upload->do_upload('image');
				$dataInfo[] = $this->upload->data();
			}
			$data = array(
					's_name'			 => $this->input->post('name'),
					's_email' 			 => $this->input->post('Email'),
					's_mobile' 			 => $this->input->post('Mobile'),
					'contact_person_name'=> $this->input->post('contact_person_name'),
					's_address' 		 => nl2br($this->input->post('s_address1')),
					's_gst'			 	 => $this->input->post('GST'),
					's_pan'			 	 => $this->input->post('PAN'),
					's_iec' 			 => $this->input->post('IEC'),
					's_c_register'		 => $this->input->post('c_register'),
					's_c_type'			 => $this->input->post('c_type'),
					's_image'     		 =>$dataInfo[0]['file_name'],
					's_c_sign'    	 	 => $dataInfo[1]['file_name'],
					's_image_width' 	 => $this->input->post('company_logo_width'),
					's_image_height' 	 => $this->input->post('company_logo_height'),
					's_c_sign_width' 	 => $this->input->post('s_c_sign_width'),
					's_c_sign_height' 	 => $this->input->post('s_c_sign_height'),
					'head_logo_width' 	 => $this->input->post('header_width'),
					'head_logo_height' 	 => $this->input->post('header_height'),
					'bank_name'     	 => $this->input->post('bank_name'),
					'port_of_loading' 	 => $this->input->post('port_of_loading'),
					'pre_carriage_by' 	 => $this->input->post('pre_carriage_by'),
					'district_of_origin' 	 => $this->input->post('district_of_origin'),
					'receipt_by_precarrier' 	 => $this->input->post('receipt_by_precarrier'),
					'state_of_origin' 	 => $this->input->post('state_of_origin'),
					'transhipment'		 => $this->input->post('transhipment'),
					'partial_shipment' 	 => $this->input->post('partial_shipment'),
					'terms_of_delivery'  => $this->input->post('terms_of_delivery'),
					'payment_terms' 	 => $this->input->post('payment_terms'),
					'authorised_signatury'  => $this->input->post('authorised_signatury'),
					'variation_in_quantity' => $this->input->post('variation_in_quantity'),
					'permission_no' 	 => $this->input->post('permission_no'),
					'permission_date' 	 => date('Y-m-d',strtotime($this->input->post('permission_date'))),
					'permission_expirydate' => $this->input->post('permission_expirydate'),
					'rcmc_no' 			 => $this->input->post('rcmc_no'),
					'rcmc_expiery' 		 => $this->input->post('rcmc_expiery'),
					'bank_code_no' 		 => $this->input->post('bank_code_no'),
					'gst_circular_no' 	 => $this->input->post('gst_circular_no'),
					'date_of_filing' 	 => $this->input->post('date_of_filing'),
					'circular_no' 		 => $this->input->post('circular_no'),
					'state_code' 		 => $this->input->post('state_code'),
					'shipper_address' 	 => $this->input->post('shipper_address'),
					'method_vgm' 	 	 => $this->input->post('method_vgm'),
					'weighbridge_reg_no' => $this->input->post('weighbridge_reg_no'),
					'weighbridge_slip_no'=> $this->input->post('weighbridge_slip_no'),
					'shipper_name' 		 => $this->input->post('shipper_name'),
					'rex_no' 			 => $this->input->post('rex_no'),
					'aeo_no' 			 => $this->input->post('aeo_no'),
					'lei_no' 			 => $this->input->post('lei_no'),
					'performa_detail'  	 => $this->input->post('performa_detail'),
					'quotation_terms'  	 => nl2br($this->input->post('quotation_terms')),
					'name_officer'  	 => ($this->input->post('name_officer')),
					'shipper_address'  	 => nl2br($this->input->post('shipper_address')),
					'epcg_detail'  	 	 => $this->input->post('epcg_detail')
		 	);
			
			 $rdata = $this->com_detail->s_insert($data);
			  if($rdata)
			  {
			    redirect(base_url('company_detail/index'));
			  }
		}	

		public function edit($eid)
		{

			$img = str_replace(array('-', '_', '~'),array('+', '/', '='), $eid);
			$id = $eid;	
			$data =  (object) array(
					 's_name' 					=> $this->input->post('name'),
					 's_email' 					=> $this->input->post('Email'),
					 's_mobile' 				=> $this->input->post('Mobile'),
					 'contact_person_name' 			 => $this->input->post('contact_person_name'),
					 's_address'			    => nl2br($this->input->post('s_address1')),
					 's_gst' 					=> $this->input->post('GST'),
					 's_pan' 					=> $this->input->post('PAN'),
					 's_iec' 					=> $this->input->post('IEC'),
					 's_c_register' 			=> $this->input->post('c_register'),
					 's_c_type' 				=> $this->input->post('c_type'),
					 'bank_name'      			=> $this->input->post('bank_id'),
					 's_bin'      				=> $this->input->post('BIN'),
					 's_cin'      				=> $this->input->post('CIN'),
					 's_lutno'     			 	=> $this->input->post('LUT_NO'),
					 's_lut_expiry'      		=> $this->input->post('LUT_EXPIRY'),
					 'port_of_loading' 			=> $this->input->post('port_of_loading'),
					 'pre_carriage_by' 	 		=> $this->input->post('pre_carriage_by'),
					 'district_of_origin' 	 	=> $this->input->post('district_of_origin'),
					 'receipt_by_precarrier' 	=> $this->input->post('receipt_by_precarrier'),
					 'state_of_origin' 			 => $this->input->post('state_of_origin'),
					 'transhipment' 			=> $this->input->post('transhipment'),
					 'partial_shipment' 		=> $this->input->post('partial_shipment'),
					 's_image_width' 	 		=> $this->input->post('company_logo_width'),
					 's_image_height' 	 		=> $this->input->post('company_logo_height'),
					 's_c_sign_width' 	 		=> $this->input->post('s_c_sign_width'),
					 's_c_sign_height' 	 		=> $this->input->post('s_c_sign_height'),
					 'head_logo_width' 	 		=> $this->input->post('header_width'),
					 'head_logo_height' 	    => $this->input->post('header_height'),
					 'terms_of_delivery' 		=> $this->input->post('terms_of_delivery'),
					 'payment_terms' 			=> $this->input->post('payment_terms'),
					 'authorised_signatury'  	=> $this->input->post('authorised_signatury'),
					 'variation_in_quantity' 	=> $this->input->post('variation_in_quantity'),
					 'permission_no' 			=> $this->input->post('permission_no'),
					 'permission_date' 			=> date('Y-m-d',strtotime($this->input->post('permission_date'))),
					 'permission_expirydate' 	=> $this->input->post('permission_expirydate'),
					 'issue_authority_address' 	=> nl2br($this->input->post('issue_authority_address')),
					 'rcmc_no' 				 	=> $this->input->post('rcmc_no'),
					 'rcmc_expiery' 		 	=> $this->input->post('rcmc_expiery'),
					 'bank_code_no' 		 	=> $this->input->post('bank_code_no'),
					 'gst_circular_no' 	     	=> $this->input->post('gst_circular_no'),
					 'date_of_filing' 	     	=> $this->input->post('date_of_filing'),
					 'circular_no' 		     	=> $this->input->post('circular_no'),
					 'state_code' 		     	=> $this->input->post('state_code'),
					 'shipper_address' 	     	=> $this->input->post('shipper_address'),
					 'delivery_period' 	     	=> $this->input->post('delivery_period'),
					 'method_vgm' 	 	     	=> $this->input->post('method_vgm'),
					 'weighbridge_reg_no' 	 	=> $this->input->post('weighbridge_reg_no'),
					 'weighbridge_slip_no'	 	=> $this->input->post('weighbridge_slip_no'),
					 'shipper_name' 		 	=> $this->input->post('shipper_name'),
					 'rex_no' 				 	=> $this->input->post('rex_no'),
				 	 'performa_detail' 		 	=> nl2br($this->input->post('performa_detail')),
				 	 'annexure_remarks' 	 	=> nl2br($this->input->post('annexure_remarks')),
					 'epcg_detail'  	 	 	=> $this->input->post('epcg_detail'),
					 'commissionerate'  	  	=> $this->input->post('commissionerate'),
					 'com_range'  	  			=> $this->input->post('range'),
					 'location_code'  	  	 	=> $this->input->post('location_code'),
					 'aeo_no' 			 		=> $this->input->post('aeo_no'),
					 'lei_no' 			 		=> $this->input->post('lei_no'),
					 'export_under_detail1'  	=> nl2br($this->input->post('export_under_detail1')),
					 'export_under_detail2' 	=> nl2br($this->input->post('export_under_detail2')),
					 'export_remarks'  	  	 	=> nl2br($this->input->post('export_remarks')),
					 'postal_address'  	  	 	=> nl2br($this->input->post('postal_address')),
					 'com_division'  	   		=> $this->input->post('division'),
					 'phone'  	   				=> $this->input->post('phone'),
					 'fax_no'  	   				=> $this->input->post('fax_no'),
					 'field1'  	   				=> $this->input->post('field1'),
					 'field2'  	   				=> $this->input->post('field2'),
					 'field3'  	   				=> $this->input->post('field3'),
					 'field4'  	   				=> $this->input->post('field4'),
					 'field5'  	   				=> $this->input->post('field5'),
					 'quotation_terms'  		=> nl2br($this->input->post('quotation_terms')),
					 'name_officer'  	 		=> ($this->input->post('name_officer')),
					 'vgm_remakrs'  	 		=> nl2br($this->input->post('vgm_remakrs')),
					 'website'  	   			=> $this->input->post('website')
					 );
					
					if($_FILES['image']['name'] != "" )	
					{
						$deletedata = $this->com_detail->s_edit_select(1);
						unlink('upload/'.$deletedata->s_image);
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('seal',$_FILES['image']['name']));
						$this->upload->do_upload('image');
						$upload_image = $this->upload->data();
						$data->s_image =$upload_image['file_name'];
					   
					}
					if($_FILES['sign_image']['name'] != "" )	
					{
						$deletedata = $this->com_detail->s_edit_select(1);
						unlink('upload/'.$deletedata->s_c_sign);
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('sign',$_FILES['sign_image']['name']));
						$this->upload->do_upload('sign_image');
						$upload_image = $this->upload->data();
					 	$data->s_c_sign =$upload_image['file_name'];
					  
					}
					if($_FILES['head_logo']['name'] != "" )	
					{
						$deletedata = $this->com_detail->s_edit_select(1);
						unlink('upload/'.$deletedata->head_logo);
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('head_logo',$_FILES['head_logo']['name']));
						$this->upload->do_upload('head_logo');
						$upload_image = $this->upload->data();
					 	$data->head_logo =$upload_image['file_name'];
					 
						 
					}
					if($_FILES['permission_doc']['name'] != "")
					{
						$deletedata = $this->com_detail->s_edit_select(1);
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
						$data->permission_doc =$upload_image['file_name'];
					 
					}	
					 
			 if($this->input->post('old_bank_id') == $this->input->post('bank_id') || $this->input->post('bank_status') == 1)
			 {
				$rs = $this->com_detail->s_edit($data,$id);
				if($rs)
				{
					echo "<script>alert('Company Profile is updated successfully');
						 window.location='" . base_url() . "company_detail';</script>";
				}
			 }
			 else
			 {
				 $_SESSION['otp'] = '';
				  
				 
				 $check_mobile_no = $this->com_detail->s_edit_select($id);
				 $row = array();
				 
				 if(!empty($check_mobile_no))
				 {
					$otp_mobile_no =  $this->input->post('otp_mobile_no');
					$otp = 0000;
					$send_otp = sent_msg($otp_mobile_no,$otp);
				 	$row['otp'] = $otp;
					$_SESSION['otp'] = $otp;
					$this->load->model('admin_bank_detail','bd');
					$this->load->model('admin_company_detail');	
				     
				    $bank_detail	 	= $this->bd->b_form_edit($data->bank_id);	
				    $menu_data			= $this->menu->usermain_menu($this->session->usertype_id);
					$data->s_id = $id;
					 
					$data 				= $data;	
					
					$v = array(
						'fd'			 => 'edit',
					  	'sent_otp'		 => $otp,
					  	'fdv'			 => $data,
						'bank_detail'	 => $bank_detail,
						'result' 		 => $this->bd->b_select(),
						'company_detail' => $this->admin_company_detail->s_select(),
						'menu_data'		 => $menu_data
					);
					$this->load->view('admin/company_detail',$v);
				}
				else
				{
					echo "<script>alert('Without OTP you can not change Bank Detail.');
						 window.location='" . base_url() . "company_detail';</script>";
				}
			 }
		}
		private function set_upload_options($newfilename,$filename)
		{   
			//upload an image options
			$config = array();
			$extension = end(explode(".", $filename));
			$config['file_name'] = $newfilename.rand(0,9999).'.'.$extension;
			$config['upload_path'] = './upload/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = '5000';
			$config['overwrite']     = FALSE;

			return $config;
		}
		public function del($id)
		{

			$this->com_detail->s_del($id);	
			redirect('company_detail/index');
			
		}
		public function checkotp()
		{
			$check_otp = $this->input->post('check_otp');
			$row=array();
			if($check_otp == $_SESSION['otp'])
			{
				$row['res'] = 1;
			}
			else
			{
				$row['res'] = 0;
			}
			echo json_encode($row);
		}
		public function mobile_update()
		{
			$explode_mobile_no = $this->input->post('otp_mobile_no');
			$s_id = $this->input->post('s_id');
			$_SESSION['otp'] = '';
			$check_mobile_no = $this->com_detail->s_edit_select($s_id);
			$row = array();
			if(!empty($check_mobile_no))
			{
				$otp = 0000;
				$send_otp = sent_msg('91'.$check_mobile_no->otp_mobile_no,$otp);
				$row['res'] = 4;
				$row['otp'] = $otp;
				$_SESSION['otp'] = $otp;
			}
			else
			{
				$row['res'] = 2;
				 
			}
			echo json_encode($row);
		}
		public function mobileupdate()
		{
			$mobileno = $this->input->post('mobileno');
			$s_id = $this->input->post('s_id');
				$data = array(
					 'otp_mobile_no' 					=> $this->input->post('mobileno'),
				);
				$rs = $this->com_detail->s_edit($data,$s_id);
				$row['res'] = 1;
				echo json_encode($row);
	 	}
		private function set_upload_options_document($newfilename,$filename)
		{   
			//upload an image options
			$config = array();
			$extension = end(explode(".", $filename));
			$config['file_name'] = $newfilename.rand(0,9999).'.'.$extension;
			$config['upload_path'] = './upload/company_doc/';
			$config['allowed_types'] = '*';
			$config['max_size']      = '5000';
			$config['overwrite']     = FALSE;

			return $config;
		}
	 	public function doc_manage()
		{
			$data = array();
					if($_FILES['gst_certificate']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('gst_certificate_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['gst_certificate']['name'],$_FILES['gst_certificate']['name']));
					 	$this->upload->do_upload('gst_certificate');
						$upload_file = $this->upload->data();
						$data['gst_certificate']  = $upload_file['file_name'];
					} 
					if($_FILES['iec_certificate']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('iec_certificate_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['iec_certificate']['name'],$_FILES['iec_certificate']['name']));
					 	$this->upload->do_upload('iec_certificate');
						$upload_file = $this->upload->data();
						$data['iec_certificate']  = $upload_file['file_name'];
					} 
					if($_FILES['lut_certificate']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('lut_certificate_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['lut_certificate']['name'],$_FILES['lut_certificate']['name']));
					 	$this->upload->do_upload('lut_certificate');
						$upload_file = $this->upload->data();
						$data['lut_certificate']  = $upload_file['file_name'];
					}
					if($_FILES['light_bill']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('light_bill_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['light_bill']['name'],$_FILES['light_bill']['name']));
					 	$this->upload->do_upload('light_bill');
						$upload_file = $this->upload->data();
						$data['light_bill']  = $upload_file['file_name'];
					}
					if($_FILES['telephone_bill']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('telephone_bill_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['telephone_bill']['name'],$_FILES['telephone_bill']['name']));
					 	$this->upload->do_upload('telephone_bill');
						$upload_file = $this->upload->data();
						$data['telephone_bill']  = $upload_file['file_name'];
					}
					if($_FILES['pan_card']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('pan_card_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['pan_card']['name'],$_FILES['pan_card']['name']));
					 	$this->upload->do_upload('pan_card');
						$upload_file = $this->upload->data();
						$data['pan_card']  = $upload_file['file_name'];
					}
					if($_FILES['bank_ad_code']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('bank_ad_code_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['bank_ad_code']['name'],$_FILES['bank_ad_code']['name']));
					 	$this->upload->do_upload('bank_ad_code');
						$upload_file = $this->upload->data();
						$data['bank_ad_code']  = $upload_file['file_name'];
					}
					if($_FILES['ce_certificate']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('ce_certificate_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['ce_certificate']['name'],$_FILES['ce_certificate']['name']));
					 	$this->upload->do_upload('ce_certificate');
						$upload_file = $this->upload->data();
						$data['ce_certificate']  = $upload_file['file_name'];
					}
					if($_FILES['iso_certificate']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('iso_certificate_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['iso_certificate']['name'],$_FILES['iso_certificate']['name']));
					 	$this->upload->do_upload('iso_certificate');
						$upload_file = $this->upload->data();
						$data['iso_certificate']  = $upload_file['file_name'];
					}
					if($_FILES['stuffing_permission']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('stuffing_permission_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['stuffing_permission']['name'],$_FILES['stuffing_permission']['name']));
					 	$this->upload->do_upload('stuffing_permission');
						$upload_file = $this->upload->data();
						$data['stuffing_permission']  = $upload_file['file_name'];
					}
					if($_FILES['lab_report1']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('lab_report1_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['lab_report1']['name'],$_FILES['lab_report1']['name']));
					 	$this->upload->do_upload('lab_report1');
						$upload_file = $this->upload->data();
						$data['lab_report1']  = $upload_file['file_name'];
					}
					if($_FILES['lab_report2']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('lab_report2_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['lab_report2']['name'],$_FILES['lab_report2']['name']));
					 	$this->upload->do_upload('lab_report2');
						$upload_file = $this->upload->data();
						$data['lab_report2']  = $upload_file['file_name'];
					}
					if($_FILES['lab_report3']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('lab_report3_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['lab_report3']['name'],$_FILES['lab_report3']['name']));
					 	$this->upload->do_upload('lab_report3');
						$upload_file = $this->upload->data();
						$data['lab_report3']  = $upload_file['file_name'];
					}
					if($_FILES['director1_pancard']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('director1_pancard_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['director1_pancard']['name'],$_FILES['director1_pancard']['name']));
					 	$this->upload->do_upload('director1_pancard');
						$upload_file = $this->upload->data();
						$data['director1_pancard']  = $upload_file['file_name'];
					}
					if($_FILES['director1_aadharcard']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('director1_aadharcard_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['director1_aadharcard']['name'],$_FILES['director1_aadharcard']['name']));
					 	$this->upload->do_upload('director1_aadharcard');
						$upload_file = $this->upload->data();
						$data['director1_aadharcard']  = $upload_file['file_name'];
					}
					if($_FILES['director2_pancard']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('director2_pancard_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['director2_pancard']['name'],$_FILES['director2_pancard']['name']));
					 	$this->upload->do_upload('director2_pancard');
						$upload_file = $this->upload->data();
						$data['director2_pancard']  = $upload_file['file_name'];
					}
					if($_FILES['director2_aadharcard']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('director2_aadharcard_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['director2_aadharcard']['name'],$_FILES['director2_aadharcard']['name']));
					 	$this->upload->do_upload('director2_aadharcard');
						$upload_file = $this->upload->data();
						$data['director2_aadharcard']  = $upload_file['file_name'];
					}
					if($_FILES['factory_photos1']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('factory_photos1_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['factory_photos1']['name'],$_FILES['factory_photos1']['name']));
					 	$this->upload->do_upload('factory_photos1');
						$upload_file = $this->upload->data();
						$data['factory_photos1']  = $upload_file['file_name'];
					}
					if($_FILES['factory_photos2']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('factory_photos2_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['factory_photos2']['name'],$_FILES['factory_photos2']['name']));
					 	$this->upload->do_upload('factory_photos2');
						$upload_file = $this->upload->data();
						$data['factory_photos2']  = $upload_file['file_name'];
					}
					if($_FILES['factory_photos3']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('factory_photos3_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['factory_photos3']['name'],$_FILES['factory_photos3']['name']));
					 	$this->upload->do_upload('factory_photos3');
						$upload_file = $this->upload->data();
						$data['factory_photos3']  = $upload_file['file_name'];
					}
					if($_FILES['factory_photos4']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('factory_photos4_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['factory_photos4']['name'],$_FILES['factory_photos4']['name']));
					 	$this->upload->do_upload('factory_photos4');
						$upload_file = $this->upload->data();
						$data['factory_photos4']  = $upload_file['file_name'];
					}
					if($_FILES['factory_photos5']['name'] != "")
					{
						unlink('./upload/company_doc/'.$this->input->post('factory_photos5_name'));
						$this->load->library('upload');
					  	$this->upload->initialize($this->set_upload_options_document($_FILES['factory_photos4']['name'],$_FILES['factory_photos5']['name']));
					 	$this->upload->do_upload('factory_photos5');
						$upload_file = $this->upload->data();
						$data['factory_photos5']  = $upload_file['file_name'];
					}
					$data['file_name1'] 		= $this->input->post('file_name1');
					$data['file_name1_order'] 	= $this->input->post('file_name1_order');
					$data['file_name2'] 		= $this->input->post('file_name2');
					$data['file_name2_order'] 	= $this->input->post('file_name2_order');
					$data['file_name3'] 		= $this->input->post('file_name3');
					$data['file_name3_order'] 	= $this->input->post('file_name3_order');
					$data['file_name4'] 		= $this->input->post('file_name4');
					$data['file_name4_order'] 	= $this->input->post('file_name4_order');
					$data['file_name5'] 		= $this->input->post('file_name5');
					$data['file_name5_order'] 	= $this->input->post('file_name5_order');
					$data['cdate'] 				= date('Y-m-d H:i:s');
			 
				$insertid = $this->com_detail->update_doc($data,1);
				$row = array();
			  if($insertid)
			  {
					$row['res']	= 1;
					
			  }
			  echo  json_encode($row);
		}	
		public function download_doc()
		{
			$this->load->library('zip');
			$filename	=	'Company Document_'.date('d-m-Y').'.zip';
			$file_download = $this->input->post('file_download');
			 
			foreach($file_download as $file)
			{ 
			  	$this->zip->read_file('upload/company_doc/'.$file);
			}
			 $this->zip->archive('upload/company_doc/'.$filename);
			
				//  
				// $this->zip->download($filename);
				echo $filename;
				 
		}
		public function delete_zip()
		{
			unlink('upload/company_doc/'.$this->input->post('filename'));
			echo 1;
		}
}
?>