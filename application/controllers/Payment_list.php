<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Payment_list extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Payment_list_model','payment');
		$this->load->model('menu_model','menu');
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
			redirect(base_url());
        }
	}

	public function index()
	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{ 
			$data['customer_data']	 = $this->payment->getcustomerdata();	
			$data['bill_data']	 = $this->payment->getbilldata();	
			$this->load->model('admin_company_detail');	
			$data['menu_data']		= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$this->load->view('admin/payment_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	}
	public function fetch_record()
	{
	 
		$invoicedate = explode(" - ",$this->input->get('date'));
		$customer_id = $this->input->get('customer_id');
		$billdata = $this->input->get('billdata');
		
		
		$where = ' and date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
			// if($this->session->usertype_id != 1)
			// {
				// $where .= " and find_in_set(mst.customer_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			// }
			
			
		if(!empty($customer_id))
		{
			$where .= ' and mst.customer_id = '.$customer_id;
			$_SESSION['get_customerdata'] = $customer_id;
		}	
		else
		{
			$_SESSION['get_customerdata'] = '';
		}
		
		if(!empty($billdata))
		{
			$where .= ' and mst.payment_id = '.$billdata;
			$_SESSION['get_billdata'] = $billdata;
		}	
		else
		{
			$_SESSION['get_billdata'] = '';
		}
		 
		  $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.payment_id','date','consign.c_companyname','invoice.export_invoice_no','(select group_concat(export_invoice_no) from tbl_export_invoice where find_in_set(export_invoice_id,aginst_invoie)) as bill_no','mst.paid_amount','mst.swift_amount','mst.total_payment','inr_value','mst.bank_charge','bank.bank_name','refernace_no','mode.payment_mode','mst.remarks','mst.payment_file','mst.swift_file','mst.status','aginst_invoie','mst.bill_id');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_payment as mst";
		 $isJOIN = array('left join customer_detail consign on consign.id=mst.customer_id',
						 'left join tbl_payment_mode mode on mode.payment_mode_id=mst.payment_mode_id',
						 'left join bank_detail bank on bank.id=mst.bank_id',
						 'left join tbl_export_invoice invoice on invoice.export_invoice_id=mst.bill_id'
						);
		 $hOrder = "mst.date desc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
					$refernace_no = !empty($row->refernace_no)?$row->refernace_no:$row->payment_mode;
				 	$row_data[] = $no;
				 	$row_data[] = date('d/m/Y',strtotime($row->date));
				 	$row_data[] = $row->c_companyname;
				 	$row_data[] = (empty($row->bill_id))?"Customer A/c":"Bill No : ".$row->bill_no;
					$paymet_file = '';
					$swift_file = '';
					
					
				  	 if(!empty($row->swift_file))
					 {
						  $row_data[] = ' <a  href="'.base_url().'upload/payment/'.$row->swift_file.'" target="_blank">'.indian_number($row->swift_amount,0).'</a> '; 
					 }
					 else
					 {
						 $row_data[] = indian_number($row->swift_amount,0);
					 }
					 if(!empty($row->payment_file))
					 {
						 $row_data[] = ' <a href="'.base_url().'upload/payment/'.$row->payment_file.'" target="_blank">'.indian_number($row->total_payment,0).'</a> ';
					 }
					 else
					 {
						$row_data[] = indian_number($row->total_payment,0);
					 }
				 	$row_data[] = indian_number($row->bank_charge,0);
				 	$row_data[] = indian_number($row->inr_value,0);
					$row_data[] = $row->bank_name.'<br> FIRC No : '.$refernace_no;
				 	$row_data[] = $row->remarks;
				  	$delete_btn = '';
					 $delete_btn = '<a class="btn btn-bricky"  onclick="delete_record('.$row->payment_id.')"  href="javascript:;"><i class="fa fa-trash"></i></a>';
					
					 $update_btn = ' <a class="btn btn-info"  href="'.base_url().'add_payment/edit_payment/'.$row->payment_id.'" data-title="Edit"   ><i class="fa fa-pencil"></i></a>';
					 $row_data[] = $update_btn.$delete_btn;
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