<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Expense_payment_list extends CI_controller
{
	 	public function __construct()
		{
			parent:: __construct();
			$this->load->helper('url');
			$this->load->library(array('form_validation','session','encrypt'));
			$this->load->model('Expense_model','expense');
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
				$data['erd']			= $m;
				$this->load->model('admin_company_detail');	
				$data['company_detail'] = $this->admin_company_detail->s_select();	
				$data['payment_data']	 = $this->expense->getpaymentdata();		
				$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);
				
			 	$this->load->view('admin/expense_payment_list',$data);
			}
			else
			{
				redirect(base_url().'');
			}
		}
		public function deleterecord()
		{
			 
			$id = $this->input->post('id');
			$deleterecord = $this->expense->delete_expensepayment($id);	
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
			 $paymentdata = $this->input->get('paymentdata');
			
			$where = ' and mst.date BETWEEN "'.date('Y-m-d',strtotime($date[0])).'" and "'.date('Y-m-d',strtotime($date[1])).'"';
			  
		    if(!empty($paymentdata))
			{
				$where .= ' and mst.expense_party_id = '.$paymentdata;
				$_SESSION['get_paymentdata'] = $paymentdata;
			}	
			else
			{
				$_SESSION['get_paymentdata'] = '';
			}
			$this->load->model('Pagging_model');//call module 
			$aColumns = array('mst.expense_payment_id', 'mst.date','party.party_name','mode.payment_mode','mst.refernace_no','mst.total_paid_amount','mst.total_kasar_amt','mst.total_tds_amt','mst.expensepayment_file','mst.cdate','mst.status');
			$isWhere = array("mst.status = 0".$where);
			$table = "tbl_expense_payment as mst";
			$isJOIN = array(
			 	'left join tbl_expense_party party on party.expense_party_id=mst.expense_party_id',
				'left join  tbl_payment_mode mode on mode.payment_mode_id=mst.payment_mode_id' 
				);
			
			$hOrder = "mst.expense_payment_id desc";
			$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = $this->input->get('iDisplayStart') + 1;
			foreach($sqlReturn['data'] as $row) {
				$row_data = array();
				$paymet_file = '';
				  
				$row_data[] = $no;
			 	$row_data[] = date('d-m-Y',strtotime($row->date));
				 $row_data[] = $row->party_name;
				$row_data[] = $row->payment_mode;
			 	$row_data[] = $row->refernace_no;
				if(!empty($row->expensepayment_file))
				{
					$row_data[] = ' <a  href="'.base_url().'upload/payment/'.$row->expensepayment_file.'" target="_blank">'.indian_number($row->total_paid_amount,2).'</a>'; 
			 	}
			 	else
				{
					$row_data[] = indian_number($row->total_paid_amount,2);
				}
				$row_data[] = indian_number($row->total_kasar_amt,2);
			 	$row_data[] = indian_number($row->total_tds_amt,2);
				 
				$deletebtn = '<li>
								<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->expense_payment_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
							</li>';

				
				$actionbtn = '<li> 
								<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="'.base_url().'add_expensepayment/edit/'.$row->expense_payment_id.'"><i class="fa fa-pencil"></i> Edit</a>
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