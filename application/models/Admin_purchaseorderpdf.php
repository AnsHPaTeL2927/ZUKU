<?php

class Admin_purchaseorderpdf extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function po_data($id)
	{
		$q = $this->db->select('po.*,supplier.company_name,supplier.permission_no,supplier.supplier_name,supplier.address,p_add.made_in_india_status,p_add.corner_protector,p_add.separation_tiles,cap.pallet_cap_name,fumigation.fumigation_name,p_add.box_sticker_file,p_add.barcode_sticker_file,p_add.air_bag_status,p_add.quonitiy_status')
			 ->from('tbl_purchase_order as po')
			->join('tbl_supplier as supplier', 'supplier.supplier_id = po.seller_id', 'LEFT')
			->join('tbl_performa_additional_detail as p_add', 'p_add.production_mst_id = po.production_mst_id', 'LEFT')
			->join('tbl_fumigation as fumigation', 'p_add.fumigation_id = fumigation.fumigation_id ', 'LEFT')
			->join('tbl_pallet_cap as cap', 'p_add.pallet_cap_id = cap.pallet_cap_id ', 'LEFT')
			
			 ->where('purchase_order_id',$id)
			->get();
		  
			return $q->row();
	}
	 public function select_supplier(){
		$q = $this->db->get('tbl_supplier');
		return $q->result();
	}
	
	public function getpo_productdata($id,$production_mst_id)
	{
		 
		$q = $this->db->select('mst.*, pro.size_type_mm,pro.size_type_cm, pro.size_height_mm,pro.size_width_mm,packing.client_name,series.series_name,
		series.water_text,series.hsnc_code,size.product_packing_name, size.box_per_container,size.total_pallent_container,size.no_big_plt_container_new,size.no_small_plt_container_new,size.multi_box_per_container,size.total_boxes,
		(select thickness from  tbl_production_trn where performa_packing_id= packing.performa_packing_id and  production_mst_id in ('.$production_mst_id.') and  production_mst_id != 0 group by size_type_mm) as thickness
		 
			')
				->from('tbl_purchaseordertrn as mst')
				->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
				->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
				->join('tbl_performa_trn as trn', 'trn.performa_trn_id = mst.performa_trn_id', 'INNER')
				->join('tbl_performa_packing as packing', 'packing.performa_trn_id = trn.performa_trn_id', 'INNER')
				->join('tbl_product_size as size', 'size.product_size_id = mst.product_size_id', 'LEFT')
			   	->where('purchase_order_id',$id)
			 
				->get();
			 
			foreach ($q->result() as $category) {
				 $return[$category->purchaseordertrn_id] = $category;
				  
				  $category->packing = $this->getpurchaseproductrate($category->purchaseordertrn_id);
				   
			 } 
		return $return;
	}
	public function getpurchaseproductrate($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name,model.design_file, design.box_design_name,design.box_design_img,type.pallet_type_name,mst.packing_net_weight,mst.packing_gross_weight")
			 ->from("tbl_purchase_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->join("tbl_box_design as design","design.box_design_id=mst.box_design_id","LEFT")
			->join("tbl_pallet_type as type","type.pallet_type_id=mst.pallet_type_id","LEFT")
			 ->where("mst.purchaseordertrn_id",$id)
			 ->get();
		 
		return $q->result();
	}
	public function packing_data($id)
	{
		 
		$array = array('packing.purchase_order_id'=>$id);
		$q = $this->db->select("packing.*,trn.model_name,trn.model_name,trn.design_file,series.hsnc_code,detail.p_name,pro.size_width_mm,pro.size_height_mm,pro.size_type_mm,pro.product_id")
			->from('tbl_purchase_packing as packing')
			->join('tbl_purchaseordertrn as prodata','prodata.purchaseordertrn_id=packing.purchaseordertrn_id','LEFT')
			->join('tbl_product as pro', 'pro.product_id = prodata.product_id', 'LEFT')
			->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
			->join('product_code_detail as detail', 'detail.hsnc_code = series.hsnc_code', 'LEFT')
		 	->join('tbl_packing_model as trn','trn.packing_model_id=packing.design_id','LEFT')
			->where($array)
			 
			->get();
		//	 echo $this->db->last_query();
		return $q->result();
	}
	
	public function company_select(){
		
		$q = $this->db->get('tbl_company_profile');
		return $q->result();
	}
	public function bselect($id){
		$this->db->where('id',$id);
		$q = $this->db->get('bank_detail');
		return $q->row();
	}
	public function fields_data($id)
	{
		$q = 'SELECT * FROM `tbl_po_packing_fields` as mst left join tbl_packing_fields as trn on trn.packing_fields_id=mst.packing_fields_id where purchase_order_id='.$id.'   ORDER BY trn.`order_by` ASC';
		$q_con = $this->db->query($q);
		if($q_con->num_rows()==0)
		{
			$q = 'SELECT * FROM `tbl_packing_fields` ORDER BY `order_by` ASC';
			$q_con = $this->db->query($q);
			$result = $q_con->result();
		}
		else
		{
			$result = $q_con->result();
		}
		return  $result;
	}
	public function fields_data_pallet_order()
	{
		$q = 'SELECT * FROM `tbl_packing_fields` where packing_fields_id in (3,6,13) ORDER BY `order_by` ASC';
		$q_con = $this->db->query($q);
		$result = $q_con->result();
		return  $result; 
	}
	
	public function get_pallet_type()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_pallet_type');
		return $q->result();
	} 
}
