<?php
class Order_sheet_list_model extends CI_model
{
 	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	

	
	public function get_producation()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_producation as mst")
			  ->where('mst.status',"0")
			// ->where('mst.producation_id',$id)
			 ->get();
			 
		 return $q->row();
	}
	
	// public function get_order_sheet()
	// {
		 // // $where = '';
		 // // if(!empty($size))
		 // // {
			 // // $where .= ' and pro.product_id ='.$size;
		 // // }
		  // // if(!empty($finish_id))
		 // // {
			 // // $where .= ' and finish.finish_id ='.$finish_id;
		 // // }
		// // $q = $this->db->select('production.*, supplier.company_name')
		// $qry = 'SELECT mst.*, trn.thickness,model.model_name,finish.finish_name,model.design_file,sum(trn.no_of_boxes) as order_boxes, pro.size_type_mm,model.packing_model_id,finish.finish_id FROM `tbl_production` as mst 
		// left join tbl_production_trn as trn on trn.production_mst_id = mst.production_mst_id
		// left join tbl_performa_packing as packing on packing.performa_packing_id = trn.performa_packing_id
		// left join tbl_packing_model as model on model.packing_model_id = packing.design_id
		// left join tbl_finish as finish on finish.finish_id = packing.finish_id
		// left join tbl_performa_trn as performa_trn on performa_trn.performa_trn_id = packing.performa_trn_id
		// left join tbl_product as pro on pro.product_id = mst.product_id 
		// WHERE   performa_trn.product_id  !=0 group by model.packing_model_id,finish.finish_id';
		// $q_con = $this->db->query($qry);
		// return $q_con->result();
	// }
	
	public function get_size($id)
	{
		 $q= $this->db->select("mst.*")
			 ->from(" tbl_product as mst")
			   ->where('mst.product_id',$id)
			 ->get();
			 
		 return $q->row();
	}
	public function get_design($id)
	{
		 $q= $this->db->select("mst.*")
			 ->from(" tbl_packing_model as mst")
			   ->where('mst.packing_model_id',$id)
			 ->get();
			 
		 return $q->row();
	}
	public function get_finish($id)
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_finish as mst")
			   ->where('mst.finish_id',$id)
			 ->get();
			 
		 return $q->row();
	}
	
	public function dispatch_insert($data)
	{
		$id = $this->db->insert('tbl_dispatch',$data); 
		return $this->db->insert_id();
	}
	
	public function updatedata($data,$id)
	{ 	
		$this->db->where('producation_id',$id);
		$updateid= $this->db->update('tbl_producation',$data);
		return $updateid;
	}
	
	public function updatedata1($data1,$id)
	{ 	
		$this->db->where('producation_id',$id);
		$updateid= $this->db->update('tbl_producation',$data1);
		return $updateid;
	}
	
	
	public function get_list($id)
	 {
		 $q = $this->db->where("producation_id",$id);
		 $q= $this->db->get("tbl_producation");
		  
		 return $q->row();
	 }
	 
	public function delete_list_data($id)
	{
		
		$this->db->where('producation_id',$id);
		$updateid= $this->db->delete('tbl_producation');
				   
		return $updateid;
	}
	
		
	 public function boxdesigndata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_box_design as mst")
			 ->where('mst.status',"0")
			 //->where('mst.box_design_id not in (select box_design_id from tbl_producation where box_design_id = mst.box_design_id and status=0) and mst.box_design_id !=',0)
			 ->get();
			  
		 return $q->result();
	 } 
	 
	 public function getdispatchdata()
	 {
		//$q = $this->db->where("dispatch_id",$id);
		$q= $this->db->get("tbl_dispatch");
		
		return $q->row();
	 } 
	 
	  public function boxdesigndata1()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_box_design as mst")
			 ->where('mst.status',"0")
			 ->where('mst.box_design_id not in (select box_design_id from tbl_producation where box_design_id = mst.box_design_id and status=0) and mst.box_design_id !=',0)
			 ->get();
			  
		 return $q->result();
	 } 
	 
	 public function customerdata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("customer_detail as mst")
			 ->where('mst.status',"0")
			 ->where('mst.id not in (select id from tbl_producation where id = mst.id and status=0) and mst.id !=',0)
			 ->get();
			  
		 return $q->result();
	 } 
	 
	 public function exportinvoicedata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_export_invoice as mst")
			 ->where('mst.status',"0")
			 //->where('mst.id not in (select id from tbl_producation where id = mst.id and status=0) and mst.id !=',0)
			 ->get();
			  
		 return $q->result();
	 }
	 
	public function fetchmodeldata($id)
	{
		$q= $this->db->select("mst.*,product.size_type_mm,finish.finish_name,model.model_name,cust.c_name,box.box_design_name")
			 ->from("tbl_producation as mst")
			 ->join("tbl_product as product","product.product_id  =  mst.product_id") 
			 ->join("tbl_finish as finish","finish.finish_id  =  mst.finish_id")
			 ->join("tbl_packing_model as model", "model.packing_model_id = mst.packing_model_id")
			 ->join("customer_detail as cust","cust.id  =  mst.id")
			 ->join("tbl_box_design as box","box.box_design_id  =  mst.box_design_id")
			 ->where("mst.producation_id",$id)
			 ->get();
		 
		return $q->row();
	}
	
	public function fetchmodeldata1($id)
	{
		$q = $this->db->where("producation_id",$id);
		$q= $this->db->get("tbl_producation");
		
		return $q->row();
	}
	
	public function allperforma_size()
	{
		$qry = 'SELECT size_type_mm,trn.thickness,pro.product_id FROM `tbl_production_mst` as mst 
		inner join tbl_production_trn as trn on trn.production_mst_id = mst.production_mst_id
		inner join tbl_performa_packing as packing on packing.performa_packing_id = trn.performa_packing_id
		inner join tbl_performa_trn as performa_trn on performa_trn.performa_trn_id = packing.performa_trn_id
		inner join tbl_product as pro on pro.product_id = performa_trn.product_id 
		WHERE  mst.status = 0 group by size_type_mm,thickness,product_id';
		$q_con = $this->db->query($qry);
		return $q_con->result();
	}
	
	public function get_allfinish()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_finish as mst")
		 	 ->where('mst.status',0)
			 ->get();
			 
		 return $q->result();
	}
	
	public function get_production_data($product_id,$packing_model_id,$finish_id)
	{
		 $where = '';
		  
		  if(!empty($finish_id))
		 {
			 $where = ' and finish_id ='.$finish_id;
		 }
		$qry = 'SELECT sum(mst.boxes) as production_boxes FROM `tbl_producation` as mst  WHERE  mst.status = 0  and product_id ='.$product_id.' and design_id ='.$packing_model_id.$where;
		$q_con = $this->db->query($qry);
		return $q_con->row();
	}
	public function get_loading_data($product_id,$packing_model_id,$finish_id)
	{
		 $where = '';
		  if(!empty($finish_id))
		 {
			 $where = ' and packing.finish_id ='.$finish_id;
		 }
		$qry = 'select sum(no_of_boxes) as assign_boxes,product_id from tbl_pi_loading_plan as make inner join tbl_performa_packing as packing on packing.performa_packing_id= make.performa_packing_id where make.status=0  and 
		  make.already_done = 0  and make.product_id ='.$product_id.' and packing.design_id ='.$packing_model_id.$where;
		$q_con = $this->db->query($qry);
		return $q_con->row();
	}
	
	public function get_export($product_id,$packing_model_id,$finish_id)
	{
		 $where = '';
		   if(!empty($finish_id))
		 {
			 $where = ' and packing.finish_id ='.$finish_id;
		 }
		$qry = 'select sum(origanal_boxes) as export_boxes,product_id from tbl_export_loading_trn as make
		inner join tbl_export_packing as packing  ON `packing`.`export_packing_id` = `make`.`export_packing_id` 
		INNER JOIN `tbl_export_invoice` as `emst` ON `emst`.`export_invoice_id` = `make`.`export_invoice_id` 
		where emst.status=0  and  emst.step = 4 and make.status=0 and direct_invoice=2  and make.product_id ='.$product_id.' and packing.design_id ='.$packing_model_id.$where;
		$q_con = $this->db->query($qry);
		return $q_con->row();
	}
	
	public function get_order_sheet($size,$finish_id)
	{
		 $where = '';
		 if(!empty($size))
		 {
			 $where .= ' and pro.product_id ='.$size;
		 }
		  if(!empty($finish_id))
		 {
			 $where .= ' and finish.finish_id ='.$finish_id;
		 }
		$qry = 'SELECT size_type_mm,trn.thickness,model.model_name,finish.finish_name,model.design_file,sum(trn.no_of_boxes) as order_boxes, pro.product_id,model.packing_model_id,finish.finish_id FROM `tbl_production_mst` as mst 
		left join tbl_production_trn as trn on trn.production_mst_id = mst.production_mst_id
		left join tbl_performa_packing as packing on packing.performa_packing_id = trn.performa_packing_id
		left join tbl_packing_model as model on model.packing_model_id = packing.design_id
		left join tbl_finish as finish on finish.finish_id = packing.finish_id
		left join tbl_performa_trn as performa_trn on performa_trn.performa_trn_id = packing.performa_trn_id
		left join tbl_product as pro on pro.product_id = performa_trn.product_id 
		WHERE  mst.status = 0 '.$where.' and performa_trn.product_id  !=0 group by model.packing_model_id,finish.finish_id';
		$q_con = $this->db->query($qry);
		return $q_con->result();
	}
	
}

?>