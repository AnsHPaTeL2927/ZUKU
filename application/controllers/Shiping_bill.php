<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Shiping_bill extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('cha_master_model','supplier');
		$this->load->model('upload_shiping_bill_model','bl');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index()
	{

		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{ 
			$row = array();
			$data['result']=$this->bl->shiping_bill_select();
			$fetch=$this->bl->shiping_bill_select();
			foreach($fetch as $fet){
				$export_id = $fet->export_invoice_id;
				$Invoice = $this->bl->get_export_data($export_id);
				$data['invoice'][] = $Invoice;
				$data['menu_data']	= $this->menu->usermain_menu($this->session->usertype_id);	
			
			}
			array_push($row,$data);
		
			$this->load->view('admin/shiping_bill_master',$row[0]);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function form_edit($export_id,$id)
	{
		$export_data = $this->bl->get_export_data($export_id);
		$consign_id = $export_data[0]->consiger_id;
		$data['export_invoice_no'] = $this->bl->get_export_data($export_id);
		$data['customer'] = $this->bl->get_customer_data($consign_id);

		// print_r('<pre>');
		// print_r($data['customer']);
		// print_r($consign_id);
		//$data['export_invoice_no'] = $fetch->export_invoice_no;
		$data['mode']				= "Edit";
		$data['result']				= $this->bl->get_upload_bl($id);
		$data['shiping_id']				= $id;
		$data['menu_data']		= $this->menu->usermain_menu($this->session->usertype_id);	
			
		$this->load->view('admin/shiping_bill_edit',$data);

	}

	public function manage_edit()
	{
		$Shipping_Bill_no 	= $this->input->post('Shipping_Bill_no');
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
				else{
					$bl_upload = $this->input->post('bill_image');
				}
		
					$eid = $this->input->post('export_invoice_id');
				$data=array(
							'Shipping_Bill_no' 		=> $Shipping_Bill_no,
							'date' 					=> date('Y-m-d',strtotime($this->input->post('date'))),
							'exchange_rate' 		=> $this->input->post('exchange_rate'),
							'drawback_amount' 		=> $this->input->post('drawback_amount'),
							'total_invoice_value' 	=> $this->input->post('total_invoice_value'),
							'date_of_shipment' 		=> date('Y-m-d',strtotime($this->input->post('date_of_shipment'))),
							'Discount' 				=> $this->input->post('Discount'),
							'commission' 			=> $this->input->post('commission'),
							
							
							'field1' 				=> $this->input->post('field1'),
							'field2' 				=> $this->input->post('field2'),
							'bl_upload' 			=> $bl_upload,
							'remark'		 		=> nl2br($this->input->post('remark')),
							'export_invoice_id' 	=> $this->input->post('export_invoice_id'),
							
					);
					$uid =  $this->input->post('shiping_id');
					$rdata = $this->bl->update_upload_bl($data,$uid);
		
					
			if($rdata)
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
		$deletedata = $this->supplier->getsupplier_record($id);
					
		$deleteid=$this->supplier->delete_supplier($id);
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

	 
	public function fetchmodeldata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->bl->fetchmodeldata($id);
		echo json_encode($resultdata);
	}

	public function edit_record()
	{
		$data = array(
			 'Payment_of_drawback' => $this->input->post('Payment_of_drawback_received'),
			 'received_date' => date('Y-m-d',strtotime($this->input->post('received_date'))),
			 'payment_status' =>'received' 
		 );
			$id = $this->input->post('eid');
			
			
			$updatedid = $this->bl->updatedata($data,$id);
			 if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['model_name'] = $this->input->post('edit_model_name');
					 
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['model_name'] =0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
		
	}

}

?>