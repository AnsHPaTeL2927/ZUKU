<?php
defined("BASEPATH") or exit("no dericet script allowed"); 

class Po_payment_list extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('PO_payment_model','payment');
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
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$this->load->view('admin/po_payment_list',$data);
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
		 $aColumns = array('mst.po_payment_id','payment_date','supplier.company_name','mst.paid_amount','refernace_no','mode.payment_mode','mst.remarks','mst.status',
		 '(select group_concat(purchase_order_no) from tbl_po_payment_trn as trn inner join tbl_purchase_order as mst on mst.purchase_order_id = trn.purchase_order_id  where po_payment_id = mst.po_payment_id) as purchase_order_no');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_po_payment as mst";
		 $isJOIN = array(
						 'left join tbl_supplier as supplier on supplier.supplier_id=mst.seller_id',
						 'left join tbl_payment_mode mode on mode.payment_mode_id=mst.payment_mode_id' 
						);
		 $hOrder = "mst.payment_date desc,mst.po_payment_id desc";
		 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = date('d/m/Y',strtotime($row->payment_date));
				 	$row_data[] = $row->company_name;
				 	$row_data[] = "Purchase No : ".$row->purchase_order_no;
				 	$row_data[] = $row->paid_amount;
				 	 
				 	$row_data[] = $row->refernace_no;
				 	$row_data[] = $row->payment_mode;
				 	$row_data[] = $row->remarks;
				  	$delete_btn = '';
					 $delete_btn = ' <a class="btn btn-bricky"  onclick="delete_record('.$row->po_payment_id.')"  href="javascript:;"><i class="fa fa-trash"></i></a>';
					 
					 $update_btn = '<a class="btn btn-info"  href="'.base_url().'add_po_payment/edit_payment/'.$row->po_payment_id.'" data-title="Edit"><i class="fa fa-pencil"></i></a>';
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