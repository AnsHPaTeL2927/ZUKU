<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Export_due_payment extends CI_controller
{
		public function __construct()
		{
			parent:: __construct();
			$this->load->helper('url');
			$this->load->library(array('form_validation','session','encrypt'));
			$this->load->model('admin_exportinvoice_list','export');
			$this->load->model('menu_model','menu');	
		 	if (!isset($_SESSION['id']) && $this->session->title == TITLE)
			{
				redirect(base_url());
			}  
		}	
		public function index()
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			{
			 	$this->load->model('admin_company_detail');	
				$data['company_detail'] = $this->admin_company_detail->s_select();	
				$data['menu_data']	 	= $this->menu->usermain_menu($this->session->usertype_id);	
				$data['consign_data']	 = $this->export->select_consigner();
			 	$this->load->view('admin/export_due_payment',$data);
			}
			else
			{
				redirect(base_url().'');
			}
		}
		public function manage()
		{
			$data = array(
				"kasar_date" 			=>	date('Y-m-d',strtotime($this->input->post('kasar_date'))),
				"kasar_amt" 			=>	$this->input->post('kasar_amt'),
				"export_invoice_id" 	=>	$this->input->post('export_invoice_id'),
				"consiger_id" 			=>	$this->input->post('consiger_id') 
		 	);
			$kasar_amount_id = $this->input->post('kasar_amount_id');
			if(!empty($kasar_amount_id))
			{
				$updateid=$this->export->update_kasar_amt($data,$kasar_amount_id);
				if($updateid)
				{
					$row['res'] = 2;
				}
				else{
					$row['res'] = 0;
				}
			}
			else
			{
				$insert_id = $this->export->insert_kasar_amt($data);
				if($insert_id)
				{
					$row['res'] = 1;
				}
				else{
					$row['res'] = 0;
				}
			}
			
			echo json_encode($row);
		}
		public function fetch_record()
		{
			 
			$invoice_status = $this->input->get('invoice_status');
			$invoicedate = explode(" - ",$this->input->get('date'));
			$cust_id = $this->input->get('cust_id');
			
			$_SESSION['export_s_date'] = $invoicedate[0];
			$_SESSION['export_e_date'] = $invoicedate[1];
		
			$where = ' and invoice_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
			
			if(!empty($cust_id))
			{
				$where .= ' and mst.consiger_id = '.$cust_id;
				$_SESSION['export_cust_id'] = $cust_id;
			}	
			else
			{
				$_SESSION['export_cust_id'] = '';
			}
		 
			 
			 if($this->session->usertype_id != 1)
			{
				$where .= " and find_in_set(mst.consiger_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			}
			$this->load->model('Pagging_model');//call module 
			$aColumns = array('mst.export_invoice_id','consign.c_name', 'mst.invoice_date','mst.export_invoice_no','consign.c_companyname','mst.container_details','(SELECT sum(no_of_boxes) from tbl_export_packing as packing  where packing.export_invoice_id = mst.export_invoice_id) as total_boxes','(SELECT sum(no_of_sqm) from tbl_export_packing as packing where packing.export_invoice_id = mst.export_invoice_id) as total_sqm','mst.grand_total','(select kasar_amt from tbl_kasar_amount where status!=2  and export_invoice_id = mst.export_invoice_id) as kasar_amt','(select sum(paid_amount + bank_charge) from tbl_payment where status!=2  and bill_id = mst.export_invoice_id) as total_paid_amt','mst.status','mst.cdate','mst.step','cur.currency_code','mst.consiger_id');
			$isWhere = array("mst.status = 0 and mst.step = 4".$where);
			$table = "tbl_export_invoice as mst";
			$isJOIN = array(
				'left join customer_detail consign on consign.id	= mst.consiger_id', 
				'left join tbl_currency cur on cur.currency_id	= mst.invoice_currency_id' 
				);
			
			$hOrder = "mst.export_invoice_id desc";
			$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = 1;
			foreach($sqlReturn['data'] as $row) {
				$row_data = array();
				$row_data[] = $no;
				$row_data[] = $row->export_invoice_no;
				$row_data[] = date('d/m/Y',strtotime($row->invoice_date));
			 	$row_data[] = $row->c_companyname;
				$row_data[] = $row->container_details;
				$row_data[] = $row->total_boxes;
					$locale='en-US'; //browser or user locale
					$currency=$row->currency_code; 
					$fmt = new NumberFormatter( $locale."@currency=$currency", NumberFormatter::CURRENCY );
					$currency_symbol = $fmt->getSymbol(NumberFormatter::CURRENCY_SYMBOL);
 
				$row_data[] =  number_format($row->total_sqm,2,'.','');
				$row_data[] = $currency_symbol.' '.number_format($row->grand_total,2,'.',',');
				$row_data[] = $currency_symbol.' '.number_format($row->kasar_amt,2,'.',',');
				$row_data[] = $currency_symbol.' '.number_format(($row->grand_total - $row->total_paid_amt - $row->kasar_amt),2,'.',',');
				
				$row_data[] =  '<a class="tooltips btn btn-success" data-toggle="tooltip" data-title="Click to Add Kasar" href="javascript:;" onclick="add_kasar('.$row->export_invoice_id.','.$row->consiger_id.',&quot;'.$row->export_invoice_no.'&quot;,&quot;'.number_format(($row->grand_total - $row->total_paid_amt - $row->kasar_amt),2,'.',',').'&quot;)"><i class="fa fa-plus"></i></a>';
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
		 public function add_kasar()
		{
			$export_invoice_id = $this->input->post('export_invoice_id');
			$get_kasar_data = $this->export->get_kasar_amt($export_invoice_id);
			if(!empty($get_kasar_data))
			{
				$get_kasar_data->kasar_date = date('d-m-Y',strtotime($get_kasar_data->kasar_date));
			}
			else
			{
				$get_kasar_data->res = 1;
			}
			echo json_encode($get_kasar_data);
		}
}
?>