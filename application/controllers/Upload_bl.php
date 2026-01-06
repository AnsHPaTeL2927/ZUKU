<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Upload_bl extends CI_controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Payment_list_model','payment');
		$this->load->model('Upload_bl_model','bl');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}	
	
	public function getdata()
	{
		$id=$this->input->post('id');
		$data = $this->bl->get_data($id);
	 	echo json_encode($data);
	}
	
	public function index($id)
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$this->load->model('customer_invoice_model');
			$this->load->model('admin_customer_detail');	
			$data['shippingdata'] 		= $this->bl->shippingdata();
			$data['company_detail'] 	= $this->admin_company_detail->s_select();
			$data['getcompany'] 		= $this->customer_invoice_model->get_invoice_data($id);	
			$data['mode']				= "Add";
			$data['id']					= $id;
			$data['menu_data'] 			= $this->menu->usermain_menu($this->session->usertype_id);	
			
		  
			$this->load->view('admin/upload_bl',$data);	
		}
		 else
		 {
		 	
		 	redirect(base_url().'');
		 }			
	}

	public function view($id){
		$data['result']	 			= $this->bl->get_upload_bl($id);	
		$data['shippingdata'] 		= $this->bl->shippingdata();
		$data['mode']				= "View";
		$data['menu_data'] 			= $this->menu->usermain_menu($this->session->usertype_id);	
		$data['getcompany'] 		= $this->customer_invoice_model->get_invoice_data($id);	
		
		$this->load->view('admin/upload_bl_view',$data);	
	}

	public function form_edit($id){
		//$data['getcompany']	 			= $this->bl->get_upload_bl($id);	
		$data['mode']				= "Edit";
		$data['result']	 			= $this->bl->get_upload_bl($id);
		$this->load->model('customer_invoice_model');
		$data['getcompany'] 		= $this->customer_invoice_model->get_invoice_data($data['result']->customer_invoice_id);
		
		$data['menu_data'] 			= $this->menu->usermain_menu($this->session->usertype_id);	
		$data['shippingdata'] 		= $this->bl->shippingdata();
		$data['id']					= $data['result']->customer_invoice_id;	
		$this->load->view('admin/upload_bl',$data);	
	}

	public function manage()
	{
		$mode 	= $this->input->post('mode');
		if($mode == 'Edit')
		{
			//$bill_no 	= $this->input->post('bill_id');
			 if($_FILES['bl_upload']['name'] != "")
				{
					unlink('./upload/'.$this->input->post('bl_file'));
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['bl_upload']['name']));
					$config['file_name'] = 'bl_upload'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('bl_upload');
					$upload_image = $this->upload->data();
					$bl_upload  = $upload_image['file_name'];
					
				}
				else{
					$bl_upload  = $this->input->post('bl_file');
				}
					$data=array(
						'customer_invoice_id' 	=> $this->input->post('customer_invoice_id'),
						'shipping_id' 			=> $this->input->post('shipping_line_id'),
						'url' 					=> $this->input->post('url'),
						'bl_number' 			=> $this->input->post('bl_number'),
						'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
						'bl_type' 				=> $this->input->post('bl_type'),
						'remark'		 		=> nl2br($this->input->post('remark')),
						'bl_upload' 			=> $bl_upload,
					);

				
					$uid =  $this->input->post('bl_id');
					//$id = $this->input->post('customer_invoice_id');
					$rdata = $this->bl->update_upload_bl($data,$uid);
					
					if($rdata)
					{	
						$row['res'] = 2;
					}
					else
					{
						$row['res'] = 0;
					}
				// else if($this->input->post('mode')==2)
				// {
					// if($this->input->post('save_next_btn'))
					// {
						// redirect(base_url('Upload_bl/index/'.$rdata));
					// }
					// else
					// {
						// redirect(base_url('Upload_bl/index'));
					// }
					// redirect(base_url('Upload_bl/index'));
				// }
					
				
			 
		}
		else
		{
			
				if($_FILES['bl_upload']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['bl_upload']['name']));
					$config['file_name'] = 'bl_upload'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('bl_upload');
					$upload_image = $this->upload->data();
					$bl_upload  = $upload_image['file_name'];
				}

				$data=array(
							
							'customer_invoice_id' 	=> $this->input->post('customer_invoice_id'),
							'shipping_id' 			=> $this->input->post('shipping_line_id'),
							'url' 					=> $this->input->post('url'),
							'bl_number' 			=> $this->input->post('bl_number'),
							'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
							'bl_type' 				=> $this->input->post('bl_type'),
							'remark'		 		=> nl2br($this->input->post('remark')),
							'bl_upload' 			=> $bl_upload,
							
					);
				$rdata = $this->bl->insert_bl($data);
				 
				 
					if($rdata)
					{
						$row['id'] = $rdata;
						
						$row['res'] = 1;
					}
					else
					{
						$row['res'] = 0;
					}
			
		  
		}
		
		 echo json_encode($row);
	}	

	public function fetchdata()
	{
		$row =array();
		$id=$this->input->post('id');
		
		
			$billdata=$this->bl->get_export_data();
			$str = '';
			foreach($billdata as $rowbill)
			{
				
					$str .= "<option value='".$rowbill->export_invoice_id."'>".$rowbill->export_invoice_no."</option>";
				
			}
			$row['str'] = $str;
			$row['payment_recieve_type'] = '1';
		
		echo json_encode($row);
	}
	public function getdueamount($id)
	{
		 
		$resultdata=$this->payment->get_due_amount($id);
		$grand_total = $resultdata->grand_total;
		if($resultdata->calculation_operator == 2)
		{
			$grand_total += $resultdata->certification_charge;
			$grand_total += $resultdata->seafright_charge;
			$grand_total += $resultdata->seafright_charge;
		}
		return  $grand_total - $resultdata->total_paid_amt;
	}
	public function deleterecord()
	{
		
		$id = $this->input->post('id');
		$deletedata = $this->bl->removeupdate_bl($id);
					
		$deleteid=$this->bl->deleteupdate_bl($id);
		$row=array();
		if($deleteid)
		{
			$row['res'] = 1;
			
		}
		else
		{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	
	public function delete_image()
	{
		$id=$this->input->post('id');
		$resultdata=$this->bl->fetchdocumentdata($id);
		unlink('upload/'.$resultdata->bl_upload);
		
		$data['bl_upload']  = '';
				  
		 $updatedid = $this->bl->deleteimage($data,$id);
		 
		if($updatedid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}

	public function download($bl_upload = NULL) 
	{
		// load download helder
		$this->load->helper('download');
		// read file contents
		$data = file_get_contents(base_url('upload/'.$bl_upload));
		force_download($bl_upload, $data);
	}	
	 
}
?>