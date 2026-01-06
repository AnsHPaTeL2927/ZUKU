<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Producation_list extends CI_controller{
	
	  public function __construct(){
	  	parent:: __construct();
	  	$this->load->helper('url');
	  	$this->load->library(array('form_validation','session','encrypt'));
	  	$this->load->model('Admin_Producation','producation');
		$this->load->model('menu_model','menu');	
	  	if (!isset($_SESSION['id']) && $this->session->title == TITLE) {
	  		redirect(base_url());
	  	}
	  }	
	  public function index($m="")
	  {
	  	if( $this->session->id == 1 && $this->session->title == TITLE)
		{
			$data['erd']= $m;
			$this->load->model('admin_company_detail');	
			$data['company_detail']  = $this->admin_company_detail->s_select();	
			$data['menu_data']		 = $this->menu->usermain_menu($this->session->usertype_id);	
			$this->load->view('admin/producation_list',$data);
		}
		else
		{
			redirect(base_url().'');
		}
	  }
	  public function fetch_record()
	  {
				 
				$invoicedate = explode(" - ",$this->input->get('date'));
				$where = ' and producation_date BETWEEN "'.date('Y-m-d',strtotime($invoicedate[0])).'" and "'.date('Y-m-d',strtotime($invoicedate[1])).'"';
				 
				 
				$this->load->model('Pagging_model');//call module 
				$aColumns = array('producation_id', 'producation_date','producation_time','series.series_name','pro.size_type_mm','model.model_name','finish.finish_name','mst.boxes','mst.status','mst.cdate');
				$isWhere = array("mst.status = 0".$where);
				$table = "tbl_producation as mst";
				$isJOIN = array(
							'INNER join tbl_product as pro on pro.product_id = mst.product_id',
							'INNER join tbl_packing_model as model on model.packing_model_id = mst.design_id',
							'INNER join tbl_series as series on series.series_id = pro.series_id',
							'left join tbl_finish as finish on finish.finish_id = mst.finish_id'
						);
				$hOrder = "mst.producation_id desc";
				 $sqlReturn = $this->Pagging_model->get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$this->input->get());
				$appData = array();
				$no = ($this->input->get('iDisplayStart') + 1);
				 
				foreach($sqlReturn['data'] as $row)
				{
					$row_data = array();
					 
					$row_data[] = $no;
					 
					$row_data[] = date('d/m/Y',strtotime($row->producation_date));
					$row_data[] = $row->producation_time;
					$row_data[] = $row->series_name;
					$row_data[] = $row->size_type_mm;
					$row_data[] = $row->model_name;
					$row_data[] = $row->finish_name;
					$row_data[] = $row->boxes;
				   
					$delete=' <a class="tooltips btn btn-danger" data-toggle="tooltip" data-title="Detele"  onclick="delete_record('.$row->producation_id.')" href="javascript:;" ><i class="fa fa-trash"></i></a>';
					 
					$row_data[] = $delete;
					$appData[] = $row_data;
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
	  	$deleterecord = $this->producation->producation_delete($id);	
	  		if($deleterecord)
	  		{
	  			$row['res'] = '1';
	  		}
	  		else{
	  			$row['res'] = '0';
	  		}
	  		echo json_encode($row);
	  }
	  public function viewproductdetail(){
				$id = $this->input->post('id');
				$result = $this->invoice->get_productdetail($id);
				$currency_id = $this->input->post('currency_id');
				$ratelabel = ($currency_id==1)?"Rate In USD":"Rate In Ëuro";
				$currency_sybol = ($currency_id==1)?"$":"&euro;";
					
				$str = '<table>
							<table class="table table-bordered table-hover" id="sample-table-1">
								<thead>
									<tr>
									
										<th width="5%">Sr No.</th>
										<th width="55%">Description od Goods</th>
										<th width="5%">Plts</th>
										<th width="5%">Boxes</th>
										<th width="5%">SQM</th>
										<th width="10%">'.$ratelabel.'</th>
										<th width="5%">Per</th>
										<th width="10%">Total Amount</th>
										
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
							 
							$str .= '<tr>
										<td rowspan="'.$rowspan.'">'.$no.'</td>
										<td>'.$jsondata->description_goods.'</td>
										<td>'.$jsondata->total_pallet.'</td>
										<td>'.$jsondata->Boxes.'</td>
										<td>'.$jsondata->SQM.'</td>
										<td>'.$currency_sybol.' '.$rate.'</td>
										<td>'.$jsondata->Per.'</td>
										<td>'.$currency_sybol.' '.$jsondata->Total_Amount.'</td>
										 
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
													
						$str .= '</tbody></table>';
				echo $str;
			}
	  
	
}
?>