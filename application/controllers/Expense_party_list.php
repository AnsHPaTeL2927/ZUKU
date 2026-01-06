<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Expense_party_list extends CI_controller{
	
	public function __construct()
	{
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Expense_model','expense');
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
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['expense_category'] 	= $this->expense->get_expensecategory();	
		 	$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$this->load->view('admin/expense_party_list',$data);	
		}
		else
		{
			redirect(base_url().'');
		}		
	}
	public function fetch_record()
	{
	 
		$where = '';
		 
		 $this->load->model('Pagging_model');//call module 
		 $aColumns = array('mst.expense_party_id','mst.party_name','(select group_concat(expense_category_name) from tbl_expense_category where status=0 and  find_in_set(expense_category_id,mst.expense_category_id)) as expense_category_name','mst.status');
		 $isWhere = array("mst.status = 0".$where);
		 $table = "tbl_expense_party as mst";
		 $isJOIN = array();
		 $hOrder = "mst.expense_party_id desc";
		  $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
					$row_data = array();
				 	$row_data[] = $no;
				 	$row_data[] = $row->party_name;
				 	$row_data[] = $row->expense_category_name;
				  	$delete_btn = '';
					$bank_btn = '';
					 
					$delete_btn = ' <li>
								 	<a class="tooltips" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->expense_party_id.')" href="javascript:;" ><i class="fa fa-trash"></i> Detele</a>
								 </li> ';
								 
					// $bank_btn = '<li>
									// <a class="tooltips" data-title="Bank Details"  data-toggle="modal" data-target="#myModal1" ><i class="fa fa-bank"></i>Bank Details</a>
								// </li> ';
					 		 
					 $actionbtn = '<li> 
								 	<a class="tooltips" data-toggle="tooltip" data-title="Edit" href="javascript:;" onclick="editexpense_category('.$row->expense_party_id.');"><i class="fa fa-pencil"></i> Edit</a>
								 </li>
								'.$delete_btn;
					 
					$row_data[] = '<div class="dropdown">
										<button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Action
										<span class="caret"></span></button>
										<ul class="dropdown-menu">
											'.$actionbtn .'
											
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
	public function manage()
	{
		$id =  $this->input->post('eid');
		
		if(!empty($id))
		{
			$data = array(
					'expense_category_id' 	=> implode(",",$this->input->post('edit_expense_category_id')), 
					'party_name'			=> $this->input->post('edit_expense_party_name') ,
					'party_address' 		=> $this->input->post('edit_expense_party_address'), 
					'party_gst_no' 			=> $this->input->post('edit_party_gst_no'), 
					'credit_days' 			=> $this->input->post('edit_credit_days'), 
					'cdate'				 	=> date('Y-m-d H:i:s'),
					'status'			 	=> 0
				);
				$insertid = $this->expense->update_expense_party($data,$id);
		 	$row = array();
			if($insertid)
			{
				$row['res'] = 1;
			}
			else
			{
				$row['res'] = 0;
			}
		}
		else 
		{
			$data = array(
					'expense_category_id' 	=> implode(",",$this->input->post('expense_category_id')), 
					'party_address' 		=> $this->input->post('expense_party_address'), 
					'party_gst_no' 			=> $this->input->post('party_gst_no'), 
					'party_name'  			=> $this->input->post('expense_party_name'), 
					'credit_days' 			=> $this->input->post('credit_days'), 
					'cdate'				  	=> date('Y-m-d H:i:s'),
					'status'			  	=> 0
				);
				$insertid = $this->expense->insert_expense_party($data);
		 
		  $row = array();
		  if($insertid)
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
		$id=$this->input->post('id');
		$deleteid=$this->expense->delete_record_party($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->expense->get_expense_party($id);
		 
		echo json_encode($resultdata);
	}
}
?>