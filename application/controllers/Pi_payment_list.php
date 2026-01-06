<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Pi_payment_list extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('PI_payment_model','payment');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{ 
			$this->load->model('admin_company_detail');	
			$data['menu_data']					= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['company_detail'] 			= $this->admin_company_detail->s_select();	
			$data['payment_mode_list'] 			= $this->payment->get_payment_mode();	
			$data['receive_payment_part_list']	= $this->payment->get_receive_payment_part();
			$this->load->view('admin/pi_payment_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function fetch_record()
	{
	 
		$invoicedate = explode(" - ",$this->input->get('date'));
			
		$where = ' and payment_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
			if($this->session->usertype_id != 1)
			{
				$where .= " and find_in_set(mst.customer_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			}
		  $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.pi_advance_payment_id','payment_date','cust.c_companyname','invoice.invoice_no','mst.amount','refernace_no','mode.payment_mode','mst.remarks','mst.status','mst.payment_document','mst.receive_payment_document');
		 $isWhere = array("mst.status != 2".$where);
		 $table = "tbl_pi_advance_payment as mst";
		 $isJOIN = array(
						 'left join tbl_performa_invoice as invoice on invoice.performa_invoice_id=mst.performa_invoice_id',
						  'left join tbl_payment_mode mode on mode.payment_mode_id=mst.payment_mode_id',
						 'left join customer_detail as cust on cust.id=mst.consignee_id' 
						);
		 $hOrder = "mst.payment_date desc,mst.pi_advance_payment_id desc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = date('d/m/Y',strtotime($row->payment_date));
				 	$row_data[] = $row->c_companyname;
				 	$row_data[] = "Performa Invoice No : ".$row->invoice_no;
				 	$row_data[] = $row->amount;
				 	 
				 	$row_data[] = $row->refernace_no;
				 	$row_data[] = $row->payment_mode;
				 	$row_data[] = $row->remarks;
				  	$delete_btn = '';
				  	$update_btn = '';
				  	$download_btn = '';
				  	$download_btn1 = '';
					 if($row->status == 0)
					 {
						$update_btn = '<a class="btn btn-info tooltips"  data-toggle="tooltip"  href="javascript:;" onclick="recived_payment('.$row->pi_advance_payment_id.',&quot;'.$row->invoice_no.'&quot;)" data-title="Click to Payment Done"><i class="fa fa-square"></i></a>';
					 
						$download_btn = ' <a class="btn btn-primary tooltips" data-toggle="tooltip"  href="'.base_url().'upload/'.$row->payment_document.'"  data-title="Download" target="_blank"><i class="fa fa-download"></i></a>';
					 }
					 else if($row->status == 1)
					 {
						 $update_btn = '<a class="btn btn-success tooltips"  data-toggle="tooltip"  href="javascript:;" onclick="recived_payment('.$row->pi_advance_payment_id.',&quot;'.$row->invoice_no.'&quot;)" data-title="Edit Payment Done"><i class="fa fa-check-square-o"></i></a>';
					 
						if(!empty($row->payment_document))
						{
						$download_btn = ' <a class="btn btn-primary tooltips" data-toggle="tooltip"  href="'.base_url().'upload/'.$row->payment_document.'"  data-title="Download" target="_blank"><i class="fa fa-download"></i></a>';
						}
						
						if(!empty($row->receive_payment_document))
						{
						$download_btn1 = ' <a class="btn btn-info tooltips" data-toggle="tooltip"  href="'.base_url().'upload/'.$row->receive_payment_document.'"  data-title="Download" target="_blank"><i class="fa fa-download"></i></a>';
						}
					 }
					 $row_data[] = $update_btn.$download_btn.$download_btn1;
					
					$appData[] = $row_data;
					$no++;
				 }
			
			$totalrecord = $this->Pagging_model->count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,'');
		
			$numrecord=$sqlReturn['data'];
			$output = array(
					"sEcho" => intval($this->input->get('sEcho')),
					"iTotalRecords" =>  $numrecord,
					"iTotalDisplayRecords" =>$totalrecord,
					"aaData" => $appData
			);
				echo json_encode( $output );
	}
	public function fetchpaymentdata()
	{
		$id			= $this->input->post('id');
		$resultdata	= $this->payment->get_advance_payment_data($id);
		$resultdata->receive_payment_date = date('d-m-Y',strtotime($resultdata->receive_payment_date)); 
		$resultdata->remarks =strip_tags($resultdata->remarks); 
		echo json_encode($resultdata);
	}
	 public function confirm_payment()
	 {
	  
	  $data = array(
				'receive_payment_date' 	=> date("Y-m-d",strtotime($this->input->post('receive_payment_date'))), 
				'payment_mode_id' 	   	=> $this->input->post('payment_mode_id'), 
				'payment_received' 		=> $this->input->post('paymentreceived'), 
				'refernace_no' 			=> $this->input->post('refernace_no'), 
				'remarks' 				=> nl2br($this->input->post('remarks')), 
			 	'cdate' 	   	   		=> date('Y-m-d H:i:s'),
				'status'		   		=> 1
			);
			
			$row = array();
			if(!empty($this->input->post('pi_advance_payment_id')))
			{
				if($_FILES['receive_payment_document']['name'] != "")
				{
					if(!empty($this->input->post('receive_payment_document_file')))
					{
						unlink('./upload/'.$this->input->post('receive_payment_document_file'));
					}
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['receive_payment_document']['name']));
					$config['file_name'] = 'recive_payment_document'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/';
					$config['allowed_types'] = 'pdf|doc|jpg|jpeg|png';
					$config['max_size']      = '5000';
					$config['overwrite']     = FALSE;
	
					$this->upload->initialize($config);
					$this->upload->do_upload('receive_payment_document');
					$upload_image = $this->upload->data();
					$data['receive_payment_document']  = $upload_image['file_name'];
				}
				$updateid = $this->payment->update_advance($data,$this->input->post('pi_advance_payment_id'));
				$deleteid = $this->payment->delete_trn_payment($pi_advance_payment_id);
					$no1 = 0;
						foreach($this->input->post('receive_payment_part_id') as $purtrnrow)
						{
							if($this->input->post('payment_received')[$no1] > 0)
							{
								$packing_trn_data = array(
									"receive_payment_part_id"	 => $purtrnrow,
									"table_name"	 			 => 'tbl_pi_advance_payment',
									"table_main_id" 			 => 0,
									"table_trn_id" 				 => $this->input->post('pi_advance_payment_id'),
									"amount" 					 => $this->input->post('payment_received')[$no1],
									'status'				 	 => 0, 
									'cdate'					 	 => date('Y-m-d H:i:s')
								);
							$receive_payment_part_id = $this->payment->insert_receive_payment_part_trn($packing_trn_data);
							}
							$no1++;
						}
						
				if($updateid)
				{
					$row['res'] = 1;
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
		$id = $this->input->post('id');
	 			
		$deleteid=$this->payment->delete_payment($id);
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

	 



}
?>