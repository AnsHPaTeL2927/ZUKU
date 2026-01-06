<?php

class Change_order_modal extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	public function getfinishdata()
	 {
		 $q = $this->db->where("status",0);
		 $q= $this->db->get("tbl_finish");
		  
		 return $q->result();
	 }
	public function allperformainvoice()
	{
		$q =  'select * from tbl_performa_invoice as mst where step = 3  and confirm_status = 1  and status!=2 ORDER BY `mst`.`performa_invoice_id` desc';
		$query =  $this->db->query($q);
		$array1 = array();
		foreach($query->result() as $row)
		{
			$array = array();
			$set_container = $this->product_set_data($row->performa_invoice_id);	
			$setcontainer = 0;
			$conarray = array();
			for($i=0; $i<count($set_container);$i++)
			{
				 
				if(!in_array($set_container[$i]->con_entry,$conarray))
				{
					$setcontainer += $set_container[$i]->container;
					array_push($conarray,$set_container[$i]->con_entry);
												
				}
			}
			if($setcontainer != $row->container_details || empty($set_container))
			{
				$array['performa_invoice_id'] = $row->performa_invoice_id;
				$array['invoice_no'] = $row->invoice_no;
				array_push($array1,$array);
					
			}
		}
		return $array1;
	}
	public function product_set_data($id)
	{
		 
	 	$qry = 'SELECT `make`.*, `mst`.*, `packing`.*, `model`.`model_name`, `model`.`design_file`, `finish`.`finish_name`, `pro`.`size_type_mm`, `pro`.`size_type_cm`, 
		   
		`sup`.`company_name` FROM `tbl_pi_loading_plan` as `make` 
		 LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `make`.`performa_packing_id` 
		 LEFT JOIN `tbl_performa_trn` as `mst` ON `packing`.`performa_trn_id` = `mst`.`performa_trn_id` 
		 LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `mst`.`product_id` 
		 LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 
		 LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id` 
		 LEFT JOIN `tbl_supplier` as `sup` ON `sup`.`supplier_id`=`make`.`supplier_id` 
		 WHERE `performa_invoice_id` = '.$id.' ORDER BY `make`.`con_entry` ASC, make.updated_net_weight desc';  
		 $q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
 
	public function get_pi_detail($id)
	{
		$q = $this->db->select("mst.*,pro.size_type_mm,pro.thickness,series.series_name,
		mst.boxes_per_pallet, pro_size.total_pallent_container, pro_size.no_big_plt_container_new, pro_size.no_small_plt_container_new, pro_size.box_per_container, pro_size.multi_box_per_container, pro_size.total_boxes
		")
			->from('tbl_performa_trn as mst')
			->join("tbl_product as pro","mst.product_id=pro.product_id","LEFT")
			->join('tbl_product_size as pro_size', 'pro_size.product_size_id = mst.product_size_id', 'LEFT')
			->join("tbl_series as series","series.series_id=pro.series_id","LEFT")
			->where('invoice_id',$id) 
			->where('extra_loading',0) 
			->order_by('seq','asc')
			->get(); 
			 
		foreach ($q->result() as $category) {
			$sub = $category->performa_trn_id;
			$category->packing = $this->get_packing($category->performa_trn_id);
			$return[] = $category;
		}
		
		return $return;
	}
	public function get_packing($id)
	{
		$q= $this->db->select("mst.*,model.model_name,finish.finish_name")
			 ->from("tbl_performa_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("performa_trn_id",$id)
			 ->get();
		return $q->result();
	}
	public function get_production_detail($id)
	{
		$q = $this->db->select('trn.*,packing.design_id,packing.finish_id,mst.supplier_id,mst.production_mst_id ')
				->from('tbl_production_trn as trn')
				->join("tbl_production_mst as mst","mst.production_mst_id=trn.production_mst_id","LEFT")
				->join("tbl_performa_packing as packing","packing.performa_packing_id=trn.performa_packing_id","LEFT")
			  	->where('trn.performa_packing_id',$id)
			  	->where('trn.no_of_boxes >',0)
				 ->get();
				 
	 	return $q->result();
		 
	}
	public function get_po_packing($production_mst_id,$design_id,$finish_id)
	{
		$q= $this->db->select("mst.*,trn.feet_per_box,trn.pcs_per_box")
			 ->from("tbl_purchase_packing as mst")
		 	 ->join("tbl_purchase_order as porder","porder.purchase_order_id=mst.purchase_order_id","LEFT")
		 	 ->join("tbl_purchaseordertrn as trn","trn.purchaseordertrn_id=mst.purchaseordertrn_id","LEFT")
			 ->where("porder.production_mst_id in (".$production_mst_id.") and mst.design_id =",$design_id)
			 ->where("mst.finish_id ",$finish_id)
			 ->get();
		  
		return $q->result();
	}
	public function getinvoicedata($id)
	{
		$this->db->where('performa_invoice_id',$id);
		$q = $this->db->get('tbl_performa_invoice');
		return $q->row();
	}
	public function all_supplier()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_supplier as mst")
		 	 ->get();
			 
		 return $q->result();
	}
	public function allproductsize()
	{
		 $q= $this->db->select("mst.*,series.series_name,detail.orderby,series.hsnc_code")
			 ->from("tbl_product as mst")
			 ->join("tbl_series as series","series.series_id=mst.series_id","LEFT")
			 ->join("product_code_detail as detail","detail.hsnc_code=series.hsnc_code","LEFT")
			 ->order_by('detail.orderby asc, series.series_name asc, mst.product_id desc')
			 ->where('mst.status',"0")
			 ->get();
		  
		 return $q->result();
	}
}

