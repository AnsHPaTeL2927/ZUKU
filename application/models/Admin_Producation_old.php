<?php
class Admin_Producation extends CI_model
{
 	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	
	public function getsupplierdata()
	{
		$q = $this->db->select('production.*, supplier.company_name')
			 ->from('tbl_production_mst as production')
			 ->join('tbl_supplier as supplier', 'production.supplier_id = supplier.supplier_id', 'LEFT')
			->where('production.status',"0")
			->group_by('production.supplier_id')
			->get();
		return $q->result();
	}
	
	public function allconsign()
	{
		 $q= $this->db->select("mst.*")
			 ->from("customer_detail as mst")
		 	 ->get();
			 
		 return $q->result();
	}
	public function all_supplier()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_supplier as mst")
		 	 ->get();
			 
		 return $q->result();
	}
	
	public function documentdata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("customer_detail as mst")
		 	 ->get();
			 
		 return $q->result();
	 }

	 public function boxdesigndata()
	 {
		 $q= $this->db->select("mst.*")
			 ->from("tbl_box_design as mst")
		 	 ->get();
			 
		 return $q->result();
	 }
	 
	public function update_step_status($productionmst_id,$step_status)
	{
		$data = array(
			"step_status" => $step_status
		);
	 	$q = $this->db->where('production_mst_id', $productionmst_id);
		$q = $this->db->update('tbl_production_mst', $data);
		return $q;
	}
	public function producation_delete($productionmst_id)
	{
		$data = array(
			"status" => 2
		);
		
	 	$q = $this->db->where('producation_id', $productionmst_id);
		$q = $this->db->update('tbl_producation', $data);
		 
		return $q;
	}
	public function select_consigner(){
		$q = $this->db->get('customer_detail');
		return $q->result();
	}
	public function get_all_pi($customer_id,$start_date,$end_date)
	{
		$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'" AND `mst`.`consigne_id` = '.$customer_id;
		}
		$q = 'SELECT `mst`.*, `con`.`c_companyname`,`con`.`c_nick_name`,(SELECT DATEDIFF(CURDATE(),performa_date) FROM `tbl_performa_invoice` as daysinvoice where daysinvoice.performa_invoice_id = mst.performa_invoice_id ) as ago_days FROM `tbl_performa_invoice` as `mst` 
			INNER JOIN `customer_detail` as `con` ON `con`.`id` = `mst`.`consigne_id` WHERE step = 3   
			'.$where.' ORDER BY `mst`.`performa_invoice_id` desc';
		$q_con = $this->db->query($q);
		return $q_con->result(); 
		 
	}
	public function get_producation_sheet($performa_invoice_id)
	{
	 
		$q = 'SELECT no_of_countainer,sup.company_name,sup.supplier_name,producation_date,producation_no FROM `tbl_production_mst` as `mst` 
			INNER JOIN `tbl_supplier` as `sup` ON `sup`.`supplier_id` = `mst`.`supplier_id` WHERE mst.status =0  
			 and performa_invoice_id ='.$performa_invoice_id;
		$q_con = $this->db->query($q);
		return $q_con->result(); 
		 
	}
	public function get_all_cofirm_pi($customer_id,$start_date,$end_date)
	{
		$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'" AND `mst`.`consigne_id` = '.$customer_id;
		}
		$q = 'SELECT `mst`.*, `con`.`c_companyname`,`con`.`c_nick_name` FROM `tbl_performa_invoice` as `mst` INNER JOIN `customer_detail` as `con` ON `con`.`id` = `mst`.`consigne_id` WHERE `mst`.`confirm_status` = 1  '.$where.' ORDER BY `mst`.`performa_invoice_id` desc';
		$q_con = $this->db->query($q);
		return $q_con->result(); 
		 
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

	public function get_all_size_producation($product_id)
	{
		$where = '';
		if(!empty($product_id))
		{
			$where = ' and mst.product_id = '.$product_id;
		}
		$sql = 'SELECT mst.product_id,size_type_mm,series.series_name,series.hsnc_code,performa_boxes,assign_boxes,producation_boxes,po_boxes,export_boxes FROM `tbl_product` as mst 
		left join tbl_series as series on series.series_id = mst.series_id
 
		left join (select sum(total_no_of_boxes) as performa_boxes,product_id from tbl_performa_trn as ptrn left join tbl_performa_invoice as performa on performa.performa_invoice_id= ptrn.invoice_id where performa.status=0 and performa.step	= 3 and performa.confirm_status =1   GROUP by product_id) as performa_boxes on performa_boxes.product_id=mst.product_id 

		left join (select sum(no_of_boxes) as assign_boxes,product_id from tbl_pi_loading_plan as make left join tbl_performa_packing as packing on packing.performa_packing_id= make.performa_packing_id where make.status=0 GROUP by product_id) as assign_boxes on assign_boxes.product_id=mst.product_id 

		left join (select sum(boxes) as producation_boxes,product_id from tbl_producation as producation where producation.status=0   GROUP by product_id) as producation_boxes on producation_boxes.product_id=mst.product_id 

		left join (select sum(total_no_of_boxes) as po_boxes,product_id from tbl_purchaseordertrn as potrn left join tbl_purchase_order as pur on pur.purchase_order_id= potrn.purchase_order_id where pur.status=0 and pur.step = 2  GROUP by product_id) as po_boxes on po_boxes.product_id=mst.product_id 

		left join (select sum(total_no_of_boxes) as export_boxes,product_id from tbl_exportproduct_trn as extrn left join tbl_export_invoice as export on export.export_invoice_id= extrn.export_invoice_id where export.status=0 and export.step = 4  GROUP by product_id) as export_boxes on export_boxes.product_id=mst.product_id 

		where mst.status = 0 '.$where.' GROUP by mst.product_id';
		$q_con = $this->db->query($sql);
		return $q_con->result();
	}
	 
	public function insert_producation($data)
	{
		$q = $this->db->insert('tbl_producation',$data);
		return $this->db->insert_id();
	}
	
	public function get_producation($id)
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_producation as mst")
			  ->where('mst.status',"0")
			  ->where('mst.producation_id',$id)
			 ->get();
			 
		 return $q->row();
	}
	
	public function fetchmodeldata($id)
	{
		$q= $this->db->select("mst.*,product.size_type_mm,finish.finish_name")
			 ->from("tbl_producation as mst")
			 ->join("tbl_product as product","product.product_id  =  mst.product_id") 
			 ->join("tbl_finish as finish","finish.finish_id  =  mst.finish_id")
			 ->where("mst.producation_id",$id)
			 ->get();
		 
		return $q->row();
	}

	public function get_producation1()
	{
		 $q= $this->db->select("*")
			 ->from("tbl_producation")
			  //->where('mst.status',"0")
			  
			 ->get();
			 
		 return $q->row();
	}
	public function update_producation($data,$id)
	{
	 	$this->db->where('producation_id', $id);
		return $this->db->update('tbl_producation', $data);
	}
	public function delete_record($id)
	{
	 	$this->db->where('producation_id', $id);
		return $this->db->delete('tbl_producation');
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
	public function get_all_productionsheet($start_date,$end_date)
	{
		$qry = 'SELECT mst.invoice_no,mst.confirm_date,sheet.production_mst_id,sheet.producation_no,sheet.producation_date,po.purchase_order_no,po.purchase_order_date,
		(SELECT GROUP_CONCAT(distinct  product.size_type_mm) from tbl_production_trn as ptrn
			inner join tbl_performa_packing as packing on packing.performa_packing_id = ptrn.performa_packing_id
			inner join tbl_performa_trn as trn on trn.performa_trn_id = packing.performa_trn_id
			inner join tbl_product as product on product.product_id = trn.product_id where production_mst_id = sheet.production_mst_id ) as size_ordered,
			(SELECT sum(no_of_boxes) from tbl_production_trn as packing   where production_mst_id = sheet.production_mst_id ) as total_boxes,
			(select group_concat(production_mst_id) from  tbl_pi_loading_plan where  production_mst_id =sheet.production_mst_id) as already_loading
			FROM `tbl_performa_invoice` as mst 
		left join tbl_production_mst as sheet on sheet.performa_invoice_id = mst.performa_invoice_id
		left join tbl_purchase_order as po on po.performa_invoice_id = mst.performa_invoice_id
		 
		WHERE  mst.status = 0 and confirm_status = 1 and mst.step=3 and performa_date between "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'" order by (select date(follow_date) from tbl_pi_followup where status=0 and performa_invoice_id = sheet.production_mst_id and followup_from =2 order by follow_date limit 1) = CURRENT_DATE() desc, mst.performa_invoice_id desc';
		$q_con = $this->db->query($qry);
		return $q_con->result();
	}
	public function get_all_pallet_followup($start_date,$end_date)
	{
		$qry = 'SELECT mst.invoice_no,mst.confirm_date,sheet.production_mst_id,sheet.producation_no,sheet.producation_date,po.purchase_order_no,po.purchase_order_date,
		(SELECT GROUP_CONCAT(distinct  product.size_type_mm) from tbl_production_trn as ptrn
			inner join tbl_performa_packing as packing on packing.performa_packing_id = ptrn.performa_packing_id
			inner join tbl_performa_trn as trn on trn.performa_trn_id = packing.performa_trn_id
			inner join tbl_product as product on product.product_id = trn.product_id where production_mst_id = sheet.production_mst_id ) as size_ordered,
			(SELECT sum(no_of_boxes) from tbl_production_trn as packing   where production_mst_id = sheet.production_mst_id ) as total_boxes,
			(select group_concat(production_mst_id) from  tbl_pi_loading_plan where  production_mst_id =sheet.production_mst_id) as already_loading
			FROM `tbl_performa_invoice` as mst 
		left join tbl_production_mst as sheet on sheet.performa_invoice_id = mst.performa_invoice_id
		left join tbl_purchase_order as po on po.performa_invoice_id = mst.performa_invoice_id
		 
		WHERE  mst.status = 0 and confirm_status = 1 and mst.step=3 and performa_date between "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'" and (select date(follow_date) from tbl_pi_followup where status=0 and performa_invoice_id = sheet.production_mst_id and followup_from = 3 order by follow_date limit 1) = ""
		order by (select date(follow_date) from tbl_pi_followup where status=0 and performa_invoice_id = sheet.production_mst_id and followup_from = 3 order by follow_date limit 1) = CURRENT_DATE() desc, mst.performa_invoice_id desc';
		$q_con = $this->db->query($qry);
		return $q_con->result();
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
		$qry = 'SELECT size_type_mm,producation_no,consign.c_companyname,trn.thickness,model.model_name,finish.finish_name,model.design_file,sum(trn.no_of_boxes) as order_boxes, pro.product_id,model.packing_model_id,finish.finish_id FROM `tbl_production_mst` as mst 
		left join tbl_production_trn as trn on trn.production_mst_id = mst.production_mst_id
		left join tbl_performa_packing as packing on packing.performa_packing_id = trn.performa_packing_id
		left join tbl_packing_model as model on model.packing_model_id = packing.design_id
		left join tbl_finish as finish on finish.finish_id = packing.finish_id
		INNER join tbl_performa_invoice as pi on pi.performa_invoice_id = mst.performa_invoice_id
		left join customer_detail consign on consign.id = pi.consigne_id
		left join tbl_performa_trn as performa_trn on performa_trn.performa_trn_id = packing.performa_trn_id
		left join tbl_product as pro on pro.product_id = performa_trn.product_id 
		WHERE  mst.status = 0 '.$where.' and performa_trn.product_id  !=0 group by model.packing_model_id,finish.finish_id';
		$q_con = $this->db->query($qry);
		return $q_con->result();
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
	public function get_loading_data1($product_id,$packing_model_id,$finish_id)
	{
		 $where = '';
		    if(!empty($finish_id))
		 {
			 $where = ' and packing.finish_id ='.$finish_id;
		 }
		$qry = 'select sum(no_of_boxes) as loaded_boxes,product_id from tbl_pi_loading_plan as make inner join tbl_performa_packing as packing on packing.performa_packing_id= make.performa_packing_id where make.status=0  and 
		  make.already_done = 1   and make.product_id ='.$product_id.' and packing.design_id ='.$packing_model_id.$where;
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
	public function check_suppier($array)
	{
		$sql='SELECT DISTINCT supplier_id FROM `tbl_production_mst` where production_mst_id in ('.implode(",",$array).')';
		$query = $this->db->query($sql);

		return $query->num_rows();
	}
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
	public function get_allfinish()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_finish as mst")
		 	 ->where('mst.status',0)
			 ->get();
			 
		 return $q->result();
	}
	public function get_followup_type()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_follow_up_type as mst")
		 	 ->where('mst.status',0)
			 ->get();
			 
		 return $q->result();
	}
	public function alluser()
	{
		 $q= $this->db->select("mst.*")
			 ->from("tbl_user as mst")
		 	 ->where('mst.status',0)
			 ->get();
			 
		 return $q->result();
	}
	public function insert_pi_followup($data)
	{
		$q = $this->db->insert('tbl_pi_followup',$data);
		return $this->db->insert_id();
	}
	public function get_latest_followup($id,$followup_from)
	{
		 $q= $this->db->select("mst.*,user.user_name")
			 ->from(" tbl_pi_followup as mst")
			 ->join('tbl_user as user', 'user.user_id = mst.user_id', 'LEFT')
			 ->where('mst.performa_invoice_id',$id)
			 ->where('mst.status',0)
			 ->where('mst.followup_from',$followup_from)
			 ->order_by('followup_today','desc')
			 ->limit(1,0)
			 ->get();
			 
		 return $q->row();
	}
	public function delete_follow_up($id)
	{
		$data = array(
			"status" => 2
		);
		
	 	$q = $this->db->where('pi_followup_id', $id);
		$q = $this->db->update('tbl_pi_followup', $data);
		 
		return $q;
	}
}

