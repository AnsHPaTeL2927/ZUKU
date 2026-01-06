<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Add_expense extends CI_controller{
	
	
	public function __construct(){
		parent:: __construct();
		 
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
			$data['payment_mode_list'] 	= $this->expense->get_payment_mode();	  
			$data['export_data']		= $this->expense->get_export_invoice();
			$data['expense_category']	= $this->expense->get_expensecategory();
			$data['mode']				= "Add";
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/add_expense',$data);	
		}
		else
		{
			
			redirect(base_url().'');
		}	
	}
	 public function edit($expense_id)
	{
		 if(!empty($this->session->id)  && $this->session->title == TITLE)
		 {
			$this->load->model('admin_company_detail');	
			$data['company_detail'] 	= $this->admin_company_detail->s_select();	
			$data['payment_mode_list'] 	= $this->expense->get_payment_mode();	  
			$data['export_data']		= $this->expense->get_export_invoice();
			$data['expense_category']	= $this->expense->get_expensecategory();
			$data['expense_data']		= $this->expense->get_expensedata($expense_id);
			$data['mode']				= "Edit";
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/add_expense',$data);	
		}
		else
		{
			
			redirect(base_url().'');
		}	
	}
	public function manage()
	{ 
		$data=array(
					'expense_date' 			=> date('Y-m-d',strtotime($this->input->post('expense_date'))),
					'expense_category_id' 	=> $this->input->post('expense_category_id'),
					'export_invoice_id' 	=> $this->input->post('export_invoice_id'),
					'payment_mode_id' 		=> $this->input->post('payment_mode_id'),
				 	'expense_party_id' 		=> $this->input->post('expense_party_id'),
					'amount' 				=> $this->input->post('expense_amount'),
					'reference_no' 			=> $this->input->post('refernace_no'),
				 	'remarks'		 		=> nl2br($this->input->post('remarks')),
					'cgst_per' 				=> $this->input->post('cgst_per'),
					'cgst_value' 			=> $this->input->post('cgst_value'),
					'sgst_per' 				=> $this->input->post('sgst_per'),
					'sgst_value' 			=> $this->input->post('sgst_value'),
					'igst_per' 				=> $this->input->post('igst_per'),
					'igst_value' 			=> $this->input->post('igst_value'),
					'total_gst' 			=> round($this->input->post('total_gst')),
					'total_amt' 			=> round($this->input->post('total_amt')),
					'cdate'					=> date('Y-m-d H:i:s')
			);
				if($_FILES['expense_payment_file']['name'] != "")
				{
					$this->load->library('upload');
					$config = array();
					$extension = end(explode(".",$_FILES['expense_payment_file']['name']));
					$config['file_name'] = 'expense_payment_file'.rand(0,9999).'.'.$extension;
					$config['upload_path'] = './upload/payment/';
					$config['allowed_types'] = '*';
					$config['max_size']      = '50000';
					$config['overwrite']     = FALSE;
			
					$this->upload->initialize($config);
					$this->upload->do_upload('expense_payment_file');
					$upload_image = $this->upload->data();
					$expense_payment_file  = $upload_image['file_name'];
					$data['expense_payment_file'] = $expense_payment_file;
				}
			$expense_id = $this->input->post('expense_id');
			if(!empty($expense_id))
			{
				$rdata = $this->expense->update_expense($expense_id,$data);
						
				if($rdata)
				{
					$row['res'] = 2;
				}
				else{
					$row['res'] = 0;
				}
		 	}
			else
			{
				$rdata = $this->expense->insert_expense($data);
						
				if($rdata)
				{
					$row['res'] = 1;
				}
				else{
					$row['res'] = 0;
				}
			}
		   echo json_encode($row);
		
	}	
	 
	public function expense_party()
	{
		$id= $this->input->post('id');
		$resultdata=$this->expense->get_expenseparty($id);
		$str = '<option value="">Select Expense Party</option>';	
		foreach($resultdata as $party)
		{
			$str .= '<option value="'.$party->expense_party_id.'">'.$party->party_name.'</option>';
		}
		echo $str;
	} 
}
?>