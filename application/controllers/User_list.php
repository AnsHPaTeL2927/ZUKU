<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_list extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('User_model','type');	
		$this->load->helper('url');	
		$this->load->model('menu_model','menu');	
		$this->load->library(array('form_validation','session'));
				
	}
	public function index()
	{	
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			 
			$this->load->model('admin_company_detail');	
			 
			   $data['result'] =$this->type->get_user_list();
			   	$data['menu_data']	 		= $this->menu->usermain_menu($this->session->usertype_id);	
			   	$data['company_detail']	 	=  $this->admin_company_detail->s_select();	
		
			 $this->load->view('admin/user_list',$data);
		}
		else
		{
			$this->load->view('admin/login');
		}
	}
 	public function manage()
	{
		 
				$data = array(
					'user_name' 	 		=> $this->input->post('user_name'),
					'address' 				=> $this->input->post('address'),
					'mobile_no' 			=> $this->input->post('mobile_no'),
					'email' 	   			=> $this->input->post('email'),
					'password' 	   			=> md5($this->input->post('password')),
					'usertype_id'    		=> $this->input->post('usertype_id'),
					'sign_pi_status' 		=> $this->input->post('sign_pi_status'),
					'contact_person_name' 	=> $this->input->post('contact_person_name'),
					'contact_no'			=> $this->input->post('contact_no'),
					'contact_email' 		=> $this->input->post('contact_email'),
					'authorised_signatury'  => $this->input->post('authorised_signatury'),
					'for_signature_name'     => $this->input->post('for_signature_name'),
					'cdate'   		       => date('Y-m-d H:i:s'),
					'status'   	  	        => 0
				);
			if(!empty($this->input->post('user_id')))
			{
					if($_FILES['sign_image']['name'] != "" )	
					{
						$deletedata = $this->type->get_userdata($this->input->post('user_id'));
						unlink('upload/user/'.$deletedata->sign_image);
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('user_sign_',$_FILES['sign_image']['name']));
						$this->upload->do_upload('sign_image');
						$upload_image = $this->upload->data();
						$data['sign_image']  = $upload_image['file_name'];
						 
					}
					
					// if($_FILES['export_sign_image']['name'] != "" )	
					// {
						// $deletedata = $this->type->get_userdata($this->input->post('user_id'));
						// unlink('upload/user/'.$deletedata->export_sign_image);
						// $this->load->library('upload');
						// $this->upload->initialize($this->set_upload_options('user_sign_',$_FILES['export_sign_image']['name']));
						// $this->upload->do_upload('export_sign_image');
						// $upload_image = $this->upload->data();
						// $data['export_sign_image']  = $upload_image['file_name'];
						 
					// }
					
					// if($_FILES['cutsomer_sign_image']['name'] != "" )	
					// {
						// $deletedata = $this->type->get_userdata($this->input->post('user_id'));
						// unlink('upload/user/'.$deletedata->cutsomer_sign_image);
						// $this->load->library('upload');
						// $this->upload->initialize($this->set_upload_options('user_sign_',$_FILES['cutsomer_sign_image']['name']));
						// $this->upload->do_upload('cutsomer_sign_image');
						// $upload_image = $this->upload->data();
						// $data['cutsomer_sign_image']  = $upload_image['file_name'];
						 
					// }
				$updateid = $this->type->updaterecord($this->input->post('user_id'),$data);
				if($updateid)
				{
					
					$row['res'] = 2;
					
				}
				else{
					$row['res'] = 0;
				}
			}
			else
			{
				if($_FILES['sign_image']['name'] != "" )	
					{
						$this->load->library('upload');
						$this->upload->initialize($this->set_upload_options('user_sign_',$_FILES['sign_image']['name']));
						$this->upload->do_upload('sign_image');
						$upload_image = $this->upload->data();
						$data['sign_image']  = $upload_image['file_name'];
						 
					}
					
				// if($_FILES['export_sign_image']['name'] != "" )	
					// {
						// $this->load->library('upload');
						// $this->upload->initialize($this->set_upload_options('user_sign_',$_FILES['export_sign_image']['name']));
						// $this->upload->do_upload('export_sign_image');
						// $upload_image = $this->upload->data();
						// $data['export_sign_image']  = $upload_image['file_name'];
						 
					// }
					
				// if($_FILES['cutsomer_sign_image']['name'] != "" )	
					// {
						// $this->load->library('upload');
						// $this->upload->initialize($this->set_upload_options('user_sign_',$_FILES['cutsomer_sign_image']['name']));
						// $this->upload->do_upload('cutsomer_sign_image');
						// $upload_image = $this->upload->data();
						// $data['cutsomer_sign_image']  = $upload_image['file_name'];
						 
					// }
				
				$insertid = $this->type->insert_user($data);
				if($insertid)
				{
					$row['res'] = 1;
					
				}
				else{
					$row['res'] = 0;
				}
			}
		 echo json_encode($row);
	}
	private function set_upload_options($newfilename,$filename)
		{   
			//upload an image options
			$config = array();
			$extension = end(explode(".", $filename));
			$config['file_name'] = $newfilename.rand(0,9999).'.'.$extension;
			$config['upload_path'] = './upload/user/';
			$config['allowed_types'] = 'gif|jpg|jpeg|png';
			$config['max_size']      = '5000';
			$config['overwrite']     = FALSE;

			return $config;
		}
	public function assignmanage()
	{
		foreach($this->input->post('customer_id') as $cust)
		{
			$data = array(
					'user_id' 	 	=> $this->input->post('user_id'),
					'customer_id' 	=> $cust,
				 	'cdate'   		=> date('Y-m-d H:i:s'),
					'status'   	   	=> 0
				);
				$insertid = $this->type->insert_user_customer($data);
		}
		 
			$row['res'] = 1;
			$row['user_id'] =  $this->input->post('user_id');
		 echo json_encode($row);
	}
	
	public function fetchcustmer_data()
	{
		$get_user_wise_customer = $this->type->get_user_wise_customer($this->input->post('user_id'));
		$row['user_cust_data'] = '';
		$str = '<table class="table table-bordered">
					<tr>
						<td>Sr NO</td>
						<td>Customer Name</td>
						<td>Action</td>
					</tr>';
					$cust_array = array();
					if(!empty($get_user_wise_customer))
					{
						$no =1;
		foreach($get_user_wise_customer as $custrow)
		{
			$str .= ' 
					<tr>
						<td>'.$no.'</td>
						<td>'.$custrow->c_companyname.'</td>
						<td>
							<a class="tooltips btn btn-danger" onclick="reamove_assign_customer('.$custrow->user_wise_customer_id.','.$custrow->user_id.')" data-title="Remove Customer" href="javascript:;" ><i class="fa fa-user-minus"></i> Remove Customer</a>
						</td>
					</tr>';
					$no++;
					array_push($cust_array,$custrow->customer_id);
		}
					}
					else
					{
						$str .= ' 
					<tr>
						<td colspan="3" class="text-center">Not Assigned Yet</td>
						 
					</tr>';
					}
			$str .= '</table>';
		
		$get_customer_name = $this->type->getcustomer();
		$row_array = array();
		$cust= '';
		foreach($get_customer_name as $cust_row)
		{
			if(!in_array($cust_row->id,$cust_array))
			{
				$cust .= '<option  value="'.$cust_row->id.'">'.$cust_row->c_companyname.'</option>';
			}
		}
		$row['cust_data'] = $cust;
		$row['assigncust'] = $str;
		
		echo json_encode($row);
	}
	
	public function remove_cust_record()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$data = array(
				 'status'    => 2
			 );
			 
	 	$updatedid = $this->type->remove_cust_record($id,$data);
		$row = array();
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}	
	
	public function deleterecord()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$data = array(
				 'status'    => 2
			 );
	 	$updatedid = $this->type->updaterecord($id,$data);
		$row = array();
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function changepincode()
	{
		$id = $this->input->post('eid');
		$Pin_Code = $this->input->post('Pin_Code');
		$data = array(
			'pin_no'    => $Pin_Code
		);
	 	$updatedid = $this->type->updaterecord($id,$data);
		$row = array();
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function changebranch()
	{
		$id = $this->input->post('e_id');
		$branch_id = $this->input->post('branch_id');
		$data = array(
			'branch_id' => $branch_id
		);
	 	$updatedid = $this->type->updaterecord($id,$data);
		$row = array();
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function get_username()
	{
		$id = $this->input->post('employee_id');
	 	$checkuser_no = $this->type->getusername($id);
		echo json_encode($checkuser_no);
	 }
	
}
