<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Expense_list extends CI_controller{
	
		public function __construct(){
			parent:: __construct();
			$this->load->helper('url');
			$this->load->library(array('form_validation','session','encrypt'));
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
				$this->load->model('order_report_model');	
				$data['expense_pending_data'] 	= $this->expense->expense_outstanding_report();	
				$data['company_detail'] = $this->admin_company_detail->s_select();	
				$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
				$data['invoice_data']	 = $this->expense->getinvoicedata();	
				$data['expense_list_data']	 = $this->expense->getexpensedata();	
				
			 	$this->load->view('admin/expense_list',$data);
			}
			else
			{
				redirect(base_url().'');
			}
		}
		public function deleterecord()
		{
			 
			$id = $this->input->post('id');
			$deleterecord = $this->expense->delete_expense($id);	
				if($deleterecord)
				{
					$row['res'] = '1';
				}
				else{
					$row['res'] = '0';
				}
				echo json_encode($row);
		}
		 
		public function fetch_record()
		{
			 
			 $date = explode(" - ",$this->input->get('date'));
			 $expensedata = $this->input->get(expensedata);
			 $invoicedata = $this->input->get(invoicedata); 
			 $pendingdata = $this->input->get(pendingdata);
			
			$where = ' and expense_date BETWEEN "'.date('Y-m-d',strtotime($date[0])).'" and "'.date('Y-m-d',strtotime($date[1])).'"';
			
			if(!empty($expensedata))
			{
				$where .= ' and mst.expense_party_id = '.$expensedata;
				$_SESSION['get_expensedata'] = $expensedata;
			}	
			else
			{
				$_SESSION['get_expensedata'] = '';
			}
			
			if(!empty($invoicedata))
			{
				$where .= ' and mst.export_invoice_id = '.$invoicedata;
				$_SESSION['get_invoicedata'] = $invoicedata;
			}	
			else
			{
				$_SESSION['get_invoicedata'] = '';
			}
			
			if(!empty($pendingdata))
			{
				$where .= ' and mst.expense_party_id = '.$pendingdata;
				$_SESSION['get_expense_pendingdata'] = $pendingdata;
			}	
			else
			{
				$_SESSION['get_expense_pendingdata'] = '';
			}
			
			$this->load->model('Pagging_model');//call module 
			$aColumns = array('mst.expense_id', 'invoice.export_invoice_no','expense_date','category.expense_category_name','party.party_name','mst.reference_no','mst.amount','mst.total_amt','mst.expense_payment_file','mst.cdate','mst.status');
			$isWhere = array("mst.status = 0".$where);
			$table = "tbl_expense as mst";
			$isJOIN = array(
				'left join tbl_export_invoice invoice on invoice.export_invoice_id=mst.export_invoice_id',
				'left join tbl_expense_party party on party.expense_party_id=mst.expense_party_id',
				'left join  tbl_expense_category category on category.expense_category_id=mst.expense_category_id'  
			 
				);
			
			$hOrder = "mst.expense_id desc";
			$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = $this->input->get('iDisplayStart') + 1;
			foreach($sqlReturn['data'] as $row) {
				$row_data = array();
				$paymet_file = '';
					
						  
				$row_data[] = $no;
				$row_data[] = $row->export_invoice_no;
				$row_data[] = date('d-m-Y',strtotime($row->expense_date));
				$row_data[] = $row->expense_category_name;
				$row_data[] = $row->party_name;
				 
			 	$row_data[] = $row->reference_no;
				if(!empty($row->expense_payment_file))
				{
					$row_data[] =  '<a href="'.base_url().'upload/payment/'.$row->expense_payment_file.'" target="_blank">'.indian_number($row->amount,2).' </a>';
				}
				else
				{
					$row_data[] = indian_number($row->amount,2);
				}
			 	$row_data[] = indian_number($row->total_amt,2);
				
				
				$deletebtn = '<li>
								<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->expense_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
							</li>';

				
				$actionbtn = '<li> 
								<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'add_expense/edit/'.$row->expense_id.'"><i class="fa fa-pencil"></i> Edit</a>
							</li>';
					 
					 
				$row_data[] = '<div class="dropdown">
									<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
									<span class="caret"></span></button>
									<ul class="dropdown-menu">
										'.$actionbtn .'
								 		'.$deletebtn.'
								</div>';
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