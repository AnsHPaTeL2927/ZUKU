<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Brc_master extends CI_controller{
	
		public function __construct(){
			parent:: __construct();
			$this->load->helper('url');
			$this->load->library(array('form_validation','session','encrypt'));
			$this->load->model('brc_master_model','export');
			$this->load->model('Upload_bl_model','bl');
			$this->load->model('upload_shiping_bill_model','bl1');
			$this->load->model('menu_model','menu');	
	
			if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
				redirect(base_url());
			}  
		}	
		public function index($m="")
		{
			if(!empty($this->session->id)  && $this->session->title == TITLE)
			 { 
				$row = array();
				
				$data['invoice'] = $this->export->getinvoicedata();
				$fetch=$this->export->getinvoicedata();
				$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
				
				$this->load->view('admin/brc_master',$data);
			}
			else
			{
				redirect(base_url().'');
			}
		}
		public function details($id){

			$data['invoice_record']=$this->export->get_export_data($id);
			$fetch=$this->export->get_export_data($id);
			$upload_bl = $fetch[0]->upload_bl;
			$upload_shiping_bill = $fetch[0]->upload_shiping_bill;
			$data['result']	 		= $this->bl->get_upload_bl($upload_bl);
			$data['result1']				= $this->bl1->get_upload_bl($upload_shiping_bill);
			$data['customer'] = $this->export->get_customer_data($cus_id);
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$data['payment_record']	= $this->export->get_payment_data($id);
		 	$this->load->view('admin/view_brc',$data);

		}
		public function firc($id){

			$data['invoice_record']=$this->export->get_export_data($id);
			$fetch=$this->export->get_export_data($id);
			$upload_bl = $fetch[0]->upload_bl;
			$upload_shiping_bill = $fetch[0]->upload_shiping_bill;
			$data['result']	 		= $this->bl->get_upload_bl($upload_bl);
			$data['result1']				= $this->bl1->get_upload_bl($upload_shiping_bill);
			$data['customer'] = $this->export->get_customer_data($cus_id);
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
			
			$data['payment_record']	= $this->export->get_payment_data($id);
		 	$this->load->view('admin/firc_latter',$data);

		}



		public function deleterecord()
		{
			$id = $this->input->post('id');
			$proforma_id = $this->input->post('proforma_id');
			$no_of_export = intval($this->input->post('no_of_export')) - 1;
			$deleterecord = $this->export->exportinvoicedelete($id);
			$updaterecord = $this->export->updateperformainvoice($proforma_id,$no_of_export);				
				if($deleterecord)
				{
					$row['res'] = '1';
				}
				else{
					$row['res'] = '0';
				}
				echo json_encode($row);
		}
		 
	 	public function viewproductdetail()
		{
			$id = $this->input->post('id');
			$currency_id = $this->input->post('currency_id');
			
			$result = $this->export->get_productdetail($id);	
			$ratelabel = ($currency_id==1)?"Rate In USD":"Rate In Ëuro";
			$currency_sybol = ($currency_id==1)?"$":"&euro;";
			$str = ' 
						<table class="table table-bordered table-hover" id="sample-table-1">
							<thead>
								<tr>
								
									<th>Sr No.</th>
									<th>Description od Goods</th>
									<th>Plts</th>
									<th>Boxes</th>
									<th>SQM</th>
									<th>'.$ratelabel.'</th>
									<th>Per</th>
									<th>Total Amount</th>
									
								</tr>
							</thead>
							<tbody>';
												$no=1;
					for($i=0; $i<count($result);$i++)
					{
						
						$jsondata = $result[$i];
						$rate =  $jsondata->Rate_In_USD;
						if($jsondata->defualt_status==1)
						{
							 $rowspan=(count($jsondata->serices)>0)?(count($jsondata->serices)+1):'';
							 
							 $rspan =  $rowspan;
						$str .= '<tr>
									<td rowspan="'.$rspan.'">'.$no.'</td>
									<td>'.$jsondata->description_goods.'</td>
									<td>'.$jsondata->total_pallet.'</td>
									<td>'.$jsondata->Boxes.'</td>
									<td>'.$jsondata->SQM.'</td>
									<td>'.$currency_sybol.' '.$rate.'</td>
									<td>'.$jsondata->Per.'</td>
									<td>'.$currency_sybol.'  '.$jsondata->default_total.'</td>
								 </tr>
								';
						}
						for($s=0;$s<count($jsondata->serices);$s++)
						{
							$str .= '<tr>';
							  if($jsondata->defualt_status==0)
							 {
								
								if($s==0)
								{
									
									$str .='<td rowspan="'.count($jsondata->serices).'">'.$no.'</td>';
								}
							 }
								$str .='<td>'.$jsondata->serices[$s]->description_goods.' - '.$jsondata->serices[$s]->seriesgroup_name.'</td>
								<td>'.$jsondata->serices[$s]->group_total_pallet.'</td>
								<td>'.$jsondata->serices[$s]->group_total_boxes.'</td>
								<td>'.$jsondata->serices[$s]->group_SQM.'</td>
								<td>'.$currency_sybol.' '.$jsondata->serices[$s]->group_Rate_In_USD.'</td>
								<td>'.$jsondata->Per.'</td>
								<td>'.$currency_sybol.' '.$jsondata->serices[$s]->group_productrate.'</td>
							</tr>
							';
						}
								$no++;
					}							
												
					$str .= '</tbody>
					</table>';
			echo $str;
		}
		
		public function fetch_record()
		{
			 
			$invoice_status = $this->input->get('invoice_status');
			$invoicedate = explode(" - ",$this->input->get('date'));
			
			$where = ' and invoice_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
			if($invoice_status==1)
			{
				$where = ' and mst.step=4';
			}
			else if($invoice_status==2)
			{
				$where = ' and mst.step=1';
			}
			else if($invoice_status==3)
			{
				$where = ' and mst.step=3';
			}	
			else if($invoice_status==4)
			{
				$where = ' and mst.step=2';
			} 
			else if($invoice_status==5)
			{
				$where = ' and mst.step=5';
			} 
			 if($this->session->usertype_id != 1)
			{
				$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
			}
			$this->load->model('Pagging_model');//call module 
			$aColumns = array('mst.export_invoice_id', 'mst.export_invoice_no','payment.paid_amount','payment.bank_charge', 'consign.c_companyname','mst.invoice_date','mst.container_details','mst.port_of_discharge','mst.grand_total','mst.status','mst.cdate','mst.step','mst.performa_invoice_id','mst.upload_bl','mst.upload_shiping_bill','tax_status','proforma.no_of_export','cur.currency_name','cur.currency_id','mst.certification_charge', 'mst.insurance_charge','mst.seafright_charge','mst.calculation_operator' );
			$isWhere = array("mst.status = 0".$where);
			$table = "tbl_export_invoice as mst";
			$isJOIN = array('left join customer_detail consign on consign.id=mst.consiger_id',
			'left join  tbl_performa_invoice proforma on proforma.performa_invoice_id=mst.performa_invoice_id',
			'left join tbl_currency cur on cur.currency_id=mst.invoice_currency_id',
			'left join tbl_payment payment on payment.bill_id=mst.export_invoice_id'
			);
			
			$hOrder = "mst.export_invoice_id desc";
			$sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
			$appData = array();
			$no = ($this->input->get('iDisplayStart') + 1);
			foreach($sqlReturn['data'] as $row) {
				$row_data = array();
				$step_status=$m;
				$row_data[] = $step_status;
				$row_data[] = date('d/m/Y',strtotime($row->invoice_date));
				if($row->step>1)
				{
					$row_data[] = $row->export_invoice_no;
				}
				else{
					$row_data[] = $row->export_invoice_no;
				}
				$row_data[] = $row->c_companyname;
				$grand_total = $row->grand_total;
				$paid_total = $row->paid_amount;
				$paid_total += $row->bank_charge;

				if($row->calculation_operator == 2)
				{
					$grand_total += $row->certification_charge;
					$grand_total += $row->insurance_charge;
					$grand_total += $row->seafright_charge;
				}
				$row_data[] = ($row->currency_name=="Euro")?"&euro; ".$grand_total:"$".' '.$grand_total;
				$row_data[] = ($row->currency_name=="Euro")?"&euro; ".$paid_total:"$".' '.$paid_total;
				
				
				$viewinvoice='<a class="tooltips" data-toggle="tooltip" data-title="View Details" href="'.base_url('brc_master/details/'.$row->export_invoice_id).'" > View Details</a>
								  ';
				$row_data[] = $viewinvoice;
				$appData[] = $row_data;
				$m++;
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