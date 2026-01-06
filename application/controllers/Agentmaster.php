<?php 
class Agentmaster extends CI_Controller 
{
	public function __construct()
	{
	/*call CodeIgniter's default Constructor*/
	parent::__construct();
	
	 
	 
	/*load Model*/
	
	$this->load->model('Agentmaster_model','mode');
	$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) 
		{
			redirect(base_url());
		}
	}
	
	public function index($m="")
    {    
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			 $this->load->model('admin_company_detail');	
			 $data['mode']			= "Add";
			 $data['countrydata']		= $this->mode->getcountrydata();
			 $data['paymentmethoddata']	= $this->mode->getpaymentmethoddata();
			 $data['paymenttermsdata']	= $this->mode->getpaymenttermsdata();
			 // $data['no']	= $this->mode->getno();
			 $data['company_detail'] = $this->admin_company_detail->s_select();	
			 $data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			 $this->load->view('admin/agentmaster',$data);
			 //$this->form_validation->set_rules('shipping_name', 'shipping_name', 'trim|required|valid_shipping_name');
		}
		else
		{
			redirect(base_url().'');
		}	 
		
    }

	
	public function manage()
	{
			
			$check_box_design = $this->mode->check_terms_update($this->input->post('payment_terms'));
			$check_box_design1 = $this->mode->check_agent_update($this->input->post('agent_name'));
			if(empty($check_box_design))
			{		
					$date = '';
					if(!empty($this->input->post('date'))){
						$date = date('Y-m-d',strtotime($this->input->post('date')));
					}else if($this->input->post('date') == ''){
						$date = '0000-00-00';
					}
					
					$countries = implode(",",$this->input->post('country'));
					$data1 = array(
								
									'payment_terms' 					=> $this->input->post('payment_terms')	
							);
					$data = array(
									'agent_name' 						=> $this->input->post('agent_name'),
									'address' 							=> nl2br($this->input->post('address')),
									'city' 								=> $this->input->post('city'),
									
									'c_name' 							=> $countries,	
									'contact_no' 						=> $this->input->post('contact_no'),
									'bank_ac_no' 						=> $this->input->post('account_no'),
									'bank_details' 						=> $this->input->post('bank_details'),
									'payment_mode' 						=> $this->input->post('payment_mode'),
									'payment_terms' 					=> $this->input->post('payment_terms'),	
									'fix_amount' 						=> $this->input->post('fix_commission'),
									'percentage' 						=> $this->input->post('percentage'),
									'join_date' 						=> $date,							
									'remarks' 							=> $this->input->post('remarks'),
									'free_field_1'						=> $this->input->post('ff1'),
									'free_field_2'						=> $this->input->post('ff2'),
									'free_field_3'						=> $this->input->post('ff3'),
									'is_active'							=> $this->input->post('isactive'),
									'order_no' 							=> $this->input->post('ornumber'),
									'status'   	   	=> 0
							);
							
					if($_FILES['agreement_upload']['name'] != "" )	
						{
							$this->load->library('upload');
							 $extension = explode(".", $_FILES['agreement_upload']['name']);
							$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload']['name']));
							$this->upload->do_upload('agreement_upload');
							$upload_image = $this->upload->data();
							$data['agreement_logo']  = $upload_image['file_name'];
						
						}
						else{
							$data['agreement_logo']  = 'No file';
						}
						

					if($_FILES['agreement_upload1']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['agreement_upload1']['name']);
						$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload1']['name']));
						$this->upload->do_upload('agreement_upload1');
						$upload_image = $this->upload->data();
						$data['agreement_logo1']  = $upload_image['file_name'];
					
					}
					else{
						$data['agreement_logo1']  = 'No file';
					}
					
					
					if($_FILES['agreement_upload2']['name'] != "" )	
					{
						$this->load->library('upload');
						 $extension = explode(".", $_FILES['agreement_upload2']['name']);
						$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload2']['name']));
						$this->upload->do_upload('agreement_upload2');
						$upload_image = $this->upload->data();
						$data['agreement_logo2']  = $upload_image['file_name'];
					
					}
					else{
						$data['agreement_logo2']  = 'No file';
					}
					
				// if(empty($check_box_design1))
				// {
					if(strtolower($this->input->post('mode'))=="add")
					{
						$pdata = $this->mode->terms_insert($data1);
						$rdata = $this->mode->agentinsert($data);
						if($rdata)
						{
							$row['res'] = 1;
							$row['id'] = $rdata;
							$row['agent_name'] = $this->input->post('agent_name');
							$row['address'] = $this->input->post('address');
						}
						else{
							$row['res'] = 0;
						}
					}
				// }
				// else if(!empty($check_box_design1))
				// {
					// $row['res'] = 3;
				// }
				
				
					else
					{
						 $id= $this->input->post('id');	
						
						if($_FILES['agreement_upload']['name'] != "" )	
						{
							$this->load->library('upload');
							 $extension = explode(".", $_FILES['agreement_upload']['name']);
							$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload']['name']));
							$this->upload->do_upload('agreement_upload');
							$upload_image = $this->upload->data();
							$data['agreement_logo']  = $upload_image['file_name'];
						}
						
						if($_FILES['agreement_upload1']['name'] != "" )	
						{
							$this->load->library('upload');
							 $extension = explode(".", $_FILES['agreement_upload1']['name']);
							$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload1']['name']));
							$this->upload->do_upload('agreement_upload1');
							$upload_image = $this->upload->data();
							$data['agreement_logo1']  = $upload_image['file_name'];
						}
						
						if($_FILES['agreement_upload2']['name'] != "" )	
						{
							$this->load->library('upload');
							 $extension = explode(".", $_FILES['agreement_upload2']['name']);
							$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload2']['name']));
							$this->upload->do_upload('agreement_upload2');
							$upload_image = $this->upload->data();
							$data['agreement_logo2']  = $upload_image['file_name'];
						}
					// if(empty($check_box_design1))
					// {
							$rdata = $this->mode->agentupdate($id,$data);
							if($rdata) 
							{
								$row['res'] = 2;
								$row['id'] = $id;
							}
							else
							{
								$row['res'] = 0;
							}
						
					}
			
			}
			
			else if(!empty($check_box_design))
			{
				
					$date = '';
					if(!empty($this->input->post('date'))){
						$date = date('Y-m-d',strtotime($this->input->post('date')));
					}else if($this->input->post('date') == ''){
						$date = '0000-00-00';
					}
					
					$countries = implode(",",$this->input->post('country'));
					$data = array(
									'agent_name' 						=> $this->input->post('agent_name'),
									'address' 							=> nl2br($this->input->post('address')),
									'city' 								=> $this->input->post('city'),
									
									'c_name' 							=> $countries,	
									'contact_no' 						=> $this->input->post('contact_no'),
									'bank_ac_no' 						=> $this->input->post('account_no'),
									'bank_details' 						=> $this->input->post('bank_details'),
									'payment_mode' 						=> $this->input->post('payment_mode'),
									'payment_terms' 					=> $this->input->post('payment_terms'),	
									'fix_amount' 						=> $this->input->post('fix_commission'),
									'percentage' 						=> $this->input->post('percentage'),
									'join_date' 						=> $date,							
									'remarks' 							=> $this->input->post('remarks'),
									'free_field_1'						=> $this->input->post('ff1'),
									'free_field_2'						=> $this->input->post('ff2'),
									'free_field_3'						=> $this->input->post('ff3'),
									'is_active'							=> $this->input->post('isactive'),
									'order_no' 							=> $this->input->post('ornumber'),
									'status'   	   	=> 0
							);
							
						
						if($_FILES['agreement_upload']['name'] != "" )	
						{
							$this->load->library('upload');
							 $extension = explode(".", $_FILES['agreement_upload']['name']);
							$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload']['name']));
							$this->upload->do_upload('agreement_upload');
							$upload_image = $this->upload->data();
							$data['agreement_logo']  = $upload_image['file_name'];
						
						}
						else{
							$data['agreement_logo']  = 'No file';
						}
						

						if($_FILES['agreement_upload1']['name'] != "" )	
						{
							$this->load->library('upload');
							 $extension = explode(".", $_FILES['agreement_upload1']['name']);
							$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload1']['name']));
							$this->upload->do_upload('agreement_upload1');
							$upload_image = $this->upload->data();
							$data['agreement_logo1']  = $upload_image['file_name'];
						
						}
						else{
							$data['agreement_logo1']  = 'No file';
						}
						
						
						if($_FILES['agreement_upload2']['name'] != "" )	
						{
							$this->load->library('upload');
							 $extension = explode(".", $_FILES['agreement_upload2']['name']);
							$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload2']['name']));
							$this->upload->do_upload('agreement_upload2');
							$upload_image = $this->upload->data();
							$data['agreement_logo2']  = $upload_image['file_name'];
						
						}
						else{
							$data['agreement_logo2']  = 'No file';
						}
				
					// if(empty($check_box_design1))
					// {
						if(strtolower($this->input->post('mode'))=="add")
						{
							$rdata = $this->mode->agentinsert($data);
							if($rdata)
							{
								$row['res'] = 1;
								$row['id'] = $rdata;
								$row['agent_name'] = $this->input->post('agent_name');
								$row['address'] = $this->input->post('address');
							}
							else{
								$row['res'] = 0;
							}
						}
					// }
						// else if(!empty($check_box_design1))
						// {
							// $row['res'] = 3;
						// }
						
						else
						{
							 $id= $this->input->post('id');
							
							if($_FILES['agreement_upload']['name'] != "" )	
							{
								$this->load->library('upload');
								 $extension = explode(".", $_FILES['agreement_upload']['name']);
								$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload']['name']));
								$this->upload->do_upload('agreement_upload');
								$upload_image = $this->upload->data();
								$data['agreement_logo']  = $upload_image['file_name'];
							}
							
							if($_FILES['agreement_upload1']['name'] != "" )	
							{
								$this->load->library('upload');
								 $extension = explode(".", $_FILES['agreement_upload1']['name']);
								$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload1']['name']));
								$this->upload->do_upload('agreement_upload1');
								$upload_image = $this->upload->data();
								$data['agreement_logo1']  = $upload_image['file_name'];
							}
							
							if($_FILES['agreement_upload2']['name'] != "" )	
							{
								$this->load->library('upload');
								 $extension = explode(".", $_FILES['agreement_upload2']['name']);
								$this->upload->initialize($this->set_upload_options('document_',$_FILES['agreement_upload2']['name']));
								$this->upload->do_upload('agreement_upload2');
								$upload_image = $this->upload->data();
								$data['agreement_logo2']  = $upload_image['file_name'];
							}
							
							// if(empty($check_box_design1))
							// {
								$rdata = $this->mode->agentupdate($id,$data);
								if($rdata) 
								{
									$row['res'] = 2;
									$row['id'] = $id;
								}
								else
								{
									$row['res'] = 0;
								}
							}
						// }
						// else if(!empty($check_box_design1))
						// {
							// $row['res'] = 3;
						// }
					}
			
			
		  echo json_encode($row);
	}		
	
	private function set_upload_options($newfilename,$filename)
	{   
		$this->load->library('image_lib');
		//upload an image options
		$config = array();
		$extension = end(explode(".", $filename));
		$config['file_name'] 		= $newfilename.'_'.rand(0,9999).'.'.$extension;
		$config['upload_path'] 		= './upload/agreement_doc/';
		$config['allowed_types'] 	= 'gif|jpg|jpeg|png|pdf|jfif';
		$config['max_size']      	= '8000';
		$config['overwrite']     	= FALSE;

		return $config;
	}
	
	public function form_edit($id)
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$data['edit_record']=$this->mode->getagent_record($id);
			$this->load->model('admin_company_detail');	
			$data['company_detail'] = $this->admin_company_detail->s_select(); 
			
			$data['countrydata'] = $this->mode->getcountrydata();
			$data['paymentmethoddata']	= $this->mode->getpaymentmethoddata();
			$data['paymenttermsdata']	= $this->mode->getpaymenttermsdata();
			$data['mode']="Edit";
			$data['menu_data']		= $this->menu->usermain_menu($this->session->usertype_id);	
			
		 	$this->load->view('admin/agentmaster',$data);
		}
		else
		{
			
			redirect(base_url().'');
		}		
	 }
	 
	// public function getdata()
	// {
		// $id=$this->input->post('id');
		// $data = $this->mode->get_data($id);
	 	// echo json_encode($data);
	// }
	
 
    public function search(){
 
        $term = $this->input->get('term');
 
        $this->db->like('payment_terms', $term);
		$this->db->limit(5);
        $data = $this->db->get("tbl_payment_terms")->result();
 
        echo json_encode( $data);
    } 
	
	public function searchmethod(){
 
        $term = $this->input->get('term');
 
        $this->db->like('payment_mode', $term);
		$this->db->limit(5);
        $data = $this->db->get("tbl_payment_mode")->result();
 
        echo json_encode( $data);
    }
public function delete_image()
{
	$id=$this->input->post('id');
	$resultdata=$this->mode->fetchdocumentdata($id);
	unlink('upload/agreement_doc/'.$resultdata->agreement_logo);
	
	$data['agreement_logo']  = 'No file';
			  
	 $updatedid = $this->mode->deleteimage($data,$id);
	 
	if($updatedid)
	{
		$row['res'] = 1;
	}
	else{
		$row['res'] = 0;
	}
	echo json_encode($row);
}	

public function delete_image1()
{
	$id=$this->input->post('id');
	$resultdata=$this->mode->fetchdocumentdata($id);
	unlink('upload/agreement_doc/'.$resultdata->agreement_logo1);
	
	$data['agreement_logo1']  = 'No file';
			  
	 $updatedid = $this->mode->deleteimage($data,$id);
	 
	if($updatedid)
	{
		$row['res'] = 1;
	}
	else{
		$row['res'] = 0;
	}
	echo json_encode($row);
}	

public function delete_image2()
{
	$id=$this->input->post('id');
	$resultdata=$this->mode->fetchdocumentdata($id);
	unlink('upload/agreement_doc/'.$resultdata->agreement_logo2);
	
	$data['agreement_logo2']  = 'No file';
			  
	 $updatedid = $this->mode->deleteimage($data,$id);
	 
	if($updatedid)
	{
		$row['res'] = 1;
	}
	else{
		$row['res'] = 0;
	}
	echo json_encode($row);
}	

public function archive_record()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$deleterecord = $this->mode->archive_record($id,$status);
		
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
?>