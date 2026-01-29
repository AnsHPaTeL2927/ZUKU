<?php 
class Admin_invoice_list extends CI_Model{

	public function __construct()
	{
	parent:: __construct();	
	$this->load->database();
		
	}
	public function invoice_delete($id)
	{
		$data = array("status"=>2);
		$this->db->where('performa_invoice_id',$id);
		return $this->db->update('tbl_performa_invoice',$data);	
	}
	public function select_consigner()
	{
		$q = $this->db->get('customer_detail');
		return $q->result();
	}
	public function insert_advance($data)
	{
		$cid = $this->db->insert('tbl_pi_advance_payment',$data);
		  return $cid = $this->db->insert_id();
	}
	public function confirmpi($id,$status)
	{
		// Only set confirm_date when confirming (status=1), clear it when unconfirming (status=0)
		if($status == 1) {
			$data = array("confirm_status"=>$status,"confirm_date"=>date('Y-m-d'));
		} else {
			// When unconfirming (status=0) or archiving (status=2), clear confirm_date
			$data = array("confirm_status"=>$status,"confirm_date"=>null);
		}
		$this->db->where('performa_invoice_id',$id);
		return $this->db->update('tbl_performa_invoice',$data);	
	}  
	public function update_advance($data,$id)
	{
		$q = $this->db->where('pi_advance_payment_id',$id);
		$q = $this->db->update('tbl_pi_advance_payment',$data);
		return $q;
	}  
	public function cal_export_container($performa_invoice_id)
	{
		 $sql='SELECT count(DISTINCT con_no) as total_con from tbl_pi_loading_plan where performa_invoice_id = '.$performa_invoice_id.' and already_done =1';
		$query = $this->db->query($sql);

		return $query->row();
	}
	public function get_productdetail($id,$size_id,$finish_id,$design_id)
	{
	 
		$q = $this->db->select('make.origanal_boxes,packing.*,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm')
				->from('tbl_pi_loading_plan as make')
				->join('tbl_performa_packing as packing','packing.performa_packing_id = make.performa_packing_id', 'LEFT')
			 	->join('tbl_performa_trn as mst','packing.performa_trn_id = mst.performa_trn_id', 'LEFT')
				->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
				 ->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
				->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
				->join("tbl_supplier as sup","sup.supplier_id=make.supplier_id","LEFT")
			  	->where('performa_invoice_id',$id)
				->order_by('make.con_no','asc')
			 	->get();
		 
		return  $q->result();
	}
 	public function getpacking($id,$finish_id,$design_id)
	{
		$q= $this->db->select("mst.*,,model.model_name,finish.finish_name")
			 ->from("tbl_export_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where("exportproduct_trn_id",$id)
			 ->where(!empty($finish_id)?"finish.finish_id":"model.packing_model_id !=",!empty($finish_id)?$finish_id:"")
			 ->where(!empty($design_id)?"model.packing_model_id":"model.packing_model_id !=",!empty($design_id)?$design_id:"")
		 	 ->get();
		 
		return $q->result();
	}
	public function get_remainingproductdetail($id,$size_id,$finish_id,$design_id)
	{
		$sql = 'SELECT GROUP_CONCAT(performa_trn_id) as performa_trn_id FROM `tbl_pi_loading_plan` as trn   where performa_invoice_id = '.$id;
		$query = $this->db->query($sql);
		$performa =  $query->row();
		$performa_trn_id = $performa->performa_trn_id;
		$where  = (!empty($size_id))?" and product.product_id = ".$size_id:' and product.product_id != ""';
		
		$q	=  'SELECT `trn`.*, `product`.`size_type_mm` FROM `tbl_performa_trn` as `trn` INNER JOIN `tbl_performa_invoice` as `mst` ON `mst`.`performa_invoice_id`=`trn`.`invoice_id` INNER JOIN `tbl_product` as `product` ON `product`.`product_id`=`trn`.`product_id` WHERE !find_in_set(performa_trn_id,"'.$performa_trn_id.'") AND `mst`.`status` = 0 and invoice_id ='.$id.$where;
		$q_remain = $this->db->query($q);
		foreach ($q_remain->result() as $category) 
		{
			$sub = $category->performa_trn_id;
			$category->packing = $this->getremainpacking($category->performa_trn_id,$finish_id,$design_id);
			$return[] = $category;
		}
		
		return $return;
	}
	public function getremainpacking($id,$finish_id,$design_id)
	{
		$q= $this->db->select("mst.*,,model.model_name,finish.finish_name")
			 ->from("tbl_performa_packing as mst")
			 ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			 ->where(!empty($finish_id)?"finish.finish_id":"model.packing_model_id !=",!empty($finish_id)?$finish_id:"")
			 ->where(!empty($design_id)?"model.packing_model_id":"model.packing_model_id !=",!empty($design_id)?$design_id:"")
		 	 ->where("performa_trn_id",$id)
			 ->get();
		return $q->result();
	}
	public function check_congine($array)
	{
		$sql='SELECT DISTINCT consigne_id FROM `tbl_performa_invoice` where performa_invoice_id in ('.implode(",",$array).')';
		$query = $this->db->query($sql);

		return $query->num_rows();
	}
	public function allproductsize()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_product as mst")
			  ->order_by('mst.product_id desc')
			 ->where('mst.status',"0")
			 ->get();
		  
		 return $q->result();
	}  
	public function alldesign()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_packing_model as mst")
		 	 ->where('mst.status',"0")
			 ->get();
		  
		 return $q->result();
	}  
	public function allfinish()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_finish as mst")
			  ->where('mst.status',"0")
			 ->get();
		  
		 return $q->result();
	} 
	public function get_advance_payment_data($id)
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_pi_advance_payment as mst")
			  ->where('mst.performa_invoice_id',$id)
			  ->where('mst.status',"0")
			 ->get();
		  
		 return $q->row();
	} 
	
}

?>
