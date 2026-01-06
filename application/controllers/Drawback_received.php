<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Drawback_received extends CI_controller{
	
		public function __construct(){
			parent:: __construct();
		 
			$this->load->model('Expense_model','expense');
			$this->load->model('menu_model','menu');	
			if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
				redirect(base_url());
			}  
		}	
		public function index($m="")
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			{
				$data['erd']			= $m;
				$this->load->model('admin_company_detail');	
				$this->load->model('admin_bank_detail','bd');
				$data['invoice_data']	 = $this->expense->getexportinvoicedata();	
				$data['shipping_bill']	 = $this->expense->getshippingdata();	
				$data['company_detail'] = $this->admin_company_detail->s_select();	
				$data['all_bank']	  	= $this->bd->b_select();
				$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
			 	$this->load->view('admin/drawback_received',$data);
			}
			else
			{
				redirect(base_url().'');
			}
		}
		public function manage()
		{
			$data1 = array(
				"received_date" 			=>	date('Y-m-d',strtotime($this->input->post('payment_date'))),
				"bank_id" 				=>	$this->input->post('bank_id'),
				"payment_of_drawback" 	=>	'Paid' 
			);
			$upload_shipping_bill_id = $this->input->post('upload_shipping_bill_id');
			$updateid=$this->expense->update_shipping_bill($data1,$upload_shipping_bill_id);
			if($updateid)
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
			 
			$data1 = array(
				"received_date" 	 	=>	'',
				"bank_id" 				=>	0,
				"payment_of_drawback" 	=>	'' 
			);
			$upload_shipping_bill_id = $this->input->post('id');
			$updateid=$this->expense->update_shipping_bill($data1,$upload_shipping_bill_id);
			if($updateid)
			{
				$row['res'] = 1;
			}
			else{
				$row['res'] = 0;
			}
			echo json_encode($row);
		}
		 
		public function fetch_record()
		{
			 
			$date = explode(" - ",$this->input->get('date'));
			$invoicedata = $this->input->get('invoicedata');
			$shippingdata = $this->input->get('shippingdata');
			
			$where = ' and mst.date BETWEEN "'.date('Y-m-d',strtotime($date[0])).'" and "'.date('Y-m-d',strtotime($date[1])).'"';
			
	
			if(!empty($invoicedata))
			{
				$where .= ' and mst.id = '.$invoicedata;
				$_SESSION['get_invoicedata'] = $invoicedata;
			}	
			else
			{
				$_SESSION['get_invoicedata'] = '';
			}
			
			if(!empty($shippingdata))
			{
				$where .= ' and mst.id = '.$shippingdata;
				$_SESSION['get_shippingdata'] = $shippingdata;
			}	
			else
			{
				$_SESSION['get_shippingdata'] = '';
			}
		
			$this->load->model('Pagging_model');//call module 
			$aColumns = array('mst.id', 'invoice.export_invoice_no','invoice.invoice_date','mst.shipping_bill_no','mst.date','mst.drawback_amount','mst.rodtep_amount','mst.received_date','mst.exchange_rate','mst.payment_of_drawback','mst.cdate','mst.status');
			$isWhere = array("mst.status = 0".$where);
			$table = "upload_shiping_bill as mst";
			$isJOIN = array(
			 	'left join tbl_export_invoice invoice on invoice.export_invoice_id=mst.export_invoice_id' 
				);
			
			$hOrder = "mst.id desc";
			$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = $this->input->get('iDisplayStart') + 1;
			foreach($sqlReturn['data'] as $row) {
				$row_data = array();
				 
				$row_data[] = $no;
				 $row_data[] = $row->export_invoice_no;
			 	$row_data[] = date('d-m-Y',strtotime($row->invoice_date));
				
				 $row_data[] = '<a class="tooltips" data-toggle="tooltip" data-title="View Shipping Bill No" href="'.base_url('upload_shiping_bill/form_edit/'.$row->id).'" >'.$row->shipping_bill_no.'</a>';
				$row_data[] = date('d-m-Y',strtotime($row->date));
			 	$row_data[] = indian_number($row->drawback_amount,0);
			 	$row_data[] = indian_number($row->rodtep_amount,0);
			 	$row_data[] =  !empty($row->payment_of_drawback)?date('d-m-Y',strtotime($row->received_date)):"";
				$row_data[] = $row->exchange_rate;
				$row_data[] = !empty($row->payment_of_drawback)?$row->payment_of_drawback:"Pending";
			 	 
			  		 
				$row_data[] = !empty($row->payment_of_drawback)?'<a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Delete Payment" href="javascript:;" onclick="delete_record('.$row->id.')"><i class="fa fa-trash"></i></a>':'<a class="tooltips btn btn-success" data-toggle="tooltip" data-title="Click to Paid" href="javascript:;" onclick="add_payment('.$row->id.')"><i class="fa fa-money"></i></a>';
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
		 
}
?>