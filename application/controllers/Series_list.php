<?php 
defined("BASEPATH") or exit("no dericet script allowed"); 
class Series_list extends CI_controller{
	
	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('admin_series_list','series');
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
			$data['company_detail'] = $this->admin_company_detail->s_select();	
			$data['seriesdata'] = $this->series->getseriesdata();	
			$data['hsnc_data']  = $this->series->hsncdata();	
			$data['menu_data']			= $this->menu->usermain_menu($this->session->usertype_id);	
		
			$this->load->view('admin/series_list',$data);
		}
 		else
		{
			redirect(base_url().'');
		}		
	}
	public function manage()
	{
		$series_name = $this->input->post('series_name');
		$hsnc_code = $this->input->post('hsnc_code');
		$check_data = $this->series->checkdata($series_name,$hsnc_code);
		if(!empty($check_data))
		{
			$row['id'] = $check_data->series_id;
			$row['series_name'] = $series_name;
			$row['res'] = 2;
		}
		else
		{
		$data = array(
			 'series_name' 		=> $this->input->post('series_name'),
			 'hsnc_code' 		=> $this->input->post('hsnc_code'),
			 'water_text' 		=> $this->input->post('water_absorption'),
			 'sale_unit' 		=> $this->input->post('sale_unit'),
			 'purchase_unit'	=> $this->input->post('purchase_unit'),
			 'field1' 			=> $this->input->post('field1'),
			 'field2' 			=> $this->input->post('field2'),
			 'status' 			=> 0 
		 );
		$insertid = $this->series->insertdata($data);
			if($insertid)
			{
				 $row['id'] = $insertid;
				 $row['series_name'] = $this->input->post('series_name');
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['series_name'] =0;
				 $row['res'] = 0;
			}
		}
			 echo json_encode($row);
		
	}
	public function deleterecord()
	{
		$id=$this->input->post('id');
		$deleteid=$this->series->deleterecord($id);
		if($deleteid)
		{
			$row['res'] = 1;
		}
		else{
			$row['res'] = 0;
		}
		echo json_encode($row);
	}
	public function fetchseriesdata()
	{
		$id=$this->input->post('id');
		$resultdata=$this->series->fetchmodeldata($id);
		 
		echo json_encode($resultdata);
	}
	public function edit_record()
	{
		$data = array(
		 	 'series_name' 	=> $this->input->post('edit_series_name'),
		 	 'hsnc_code' 	=> $this->input->post('edit_hsnc_code'),
			 'water_text' 	=> $this->input->post('edit_water_absorption'),
			 'sale_unit' 		=> $this->input->post('edit_sale_unit'),
			 'purchase_unit'	=> $this->input->post('edit_purchase_unit'),
			 'field1' 		=> $this->input->post('edit_field1'),
			 'field2' 		=> $this->input->post('edit_field2'),
			 'status' =>0 
		 );
			$id = $this->input->post('eid');
			$updatedid = $this->series->updatedata($data,$id);
			if($updatedid)
			{
				 $row['id'] =  $id;
				 $row['series_name'] = $this->input->post('edit_series_name');
				 $row['res'] = 1;
				
			}
			else
			{
				$row['id'] =0;
				 $row['series_name'] =0;
				 $row['res'] = 0;
			}
			 echo json_encode($row);
		
	}
}
?>