<?php
class Admin_pdf extends CI_model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->load->model('Admin_Producation');
	}
	public function insert_boxdesign_data($data)
	{
		$q =  $this->db->insert('tbl_performa_box_design',$data);
		return $this->db->insert_id();
	}
	public function insert_auto_load($data)
	{
		$q =  $this->db->insert('tbl_autometic_loading_plan',$data);
	 	return $this->db->insert_id();
	}
	public function get_auto_load($id,$production_trn_id,$product_id)
	{
		 $q = 'SELECT sum(origanal_boxes) as already_done_boxes,sum(origanal_sqm) as already_done_sqm FROM `tbl_pi_loading_plan` where   performa_invoice_id  = '.$id.' and production_trn_id = '.$production_trn_id.' and product_id = '.$product_id; 
		$q_con = $this->db->query($q);
		return $q_con->row();
	}
	public function insert_additional($data)
	{
		$q =  $this->db->insert('tbl_performa_additional_detail',$data);
		return $this->db->insert_id();
	}
	public function update_additional($data,$performa_additional_detail_id)
	{
		$q= $this->db->where('performa_additional_detail_id', $performa_additional_detail_id); 
		$q= $this->db->update('tbl_performa_additional_detail',$data);
	 	 
		return $q;//Set 
	}
	public function get_auto_loading_plan($id,$check,$notauto)
	{
		$where =' and full_status = 1 ';
		 if($notauto == 0)
		 {
			 $where ='';
		 }
		  $q = 'SELECT mst.*,trn.performa_packing_id, trn.production_mst_id, pmst.supplier_id,sup.company_name,packing.performa_trn_id, ptrn.pallet_status,ptrn.sqm_per_box,ptrn.boxes_per_pallet, ptrn.box_per_big_pallet,ptrn.box_per_small_pallet,big_pallet_weight,small_pallet_weight,	(SELECT COUNT(container_no) from tbl_autometic_loading_plan where status =0 and container_no = mst.container_no and  performa_invoice_id = '.$id.' and status =0 GROUP By container_no) as total_con
			FROM `tbl_autometic_loading_plan` as mst 
			inner join tbl_production_trn as trn on trn.production_trn_id = mst.production_trn_id
			inner join tbl_production_mst as pmst on pmst.production_mst_id = trn.production_mst_id
			inner join tbl_performa_packing as packing on packing.performa_packing_id = trn.performa_packing_id
			inner join tbl_performa_trn as ptrn on ptrn.performa_trn_id = packing.performa_trn_id
			inner join tbl_supplier as sup on pmst.supplier_id = sup.supplier_id
			where  mst.performa_invoice_id = '.$id.$where.' and mst.status =0 order by container_no asc';  
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	
	public function select_invoice_data($id)
	{
		$q = $this->db->select('invoice.*, consign.c_name,consign.c_companyname,cur.currency_name,cur.currency_code,cur.currency_id,term.terms_name,additional.*,fum.fumigation_name,cap.pallet_cap_name,user.sign_pi_status,user.for_signature_name,user.sign_image,user.authorised_signatury,user.contact_person_name,user.contact_no,user.contact_email,supplier.remarks_sheet,
		(select sum(container) from tbl_pi_loading_plan where performa_invoice_id = '.$id.' and export_done_status = 1 and updated_net_weight != "") as export_done_con
		')
	
			->from('tbl_performa_invoice as invoice')
			->join('tbl_performa_additional_detail as additional', 'additional.performa_id = invoice.performa_invoice_id', 'LEFT')
			->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			->join('tbl_supplier as supplier', 'supplier.supplier_id = additional.mgf_company_name', 'LEFT')
			->join('tbl_currency as cur', 'invoice.invoice_currency_id = cur.currency_id', 'LEFT')
			->join('tbl_terms as term', 'term.terms_id = invoice.terms_id', 'LEFT')
			->join('tbl_fumigation as fum', 'fum.fumigation_id = additional.fumigation_id', 'LEFT')
			->join('tbl_pallet_cap as cap', 'cap.pallet_cap_id = additional.pallet_cap_id', 'LEFT')
			->join('tbl_user as user', 'user.user_id = invoice.sign_detail_id', 'LEFT')
		 	->where('performa_invoice_id',$id)
			->order_by("performa_date", "desc")
			->get();
		  
			return $q->row();
	}
	
	public function container_data($id)
	{
		$q = $this->db->select('pi.*, consign.c_name , performa.invoice_no,  supplier.company_name,  consign.shippment_days')
			 ->from('tbl_pi_loading_plan as pi')
			->join('customer_detail as consign', 'pi.pi_loading_plan_id = consign.id', 'LEFT')
			->join('tbl_performa_invoice as performa', 'pi.performa_invoice_id = performa.performa_invoice_id', 'LEFT')
			//->join('tbl_export_invoice as export', 'pi.export_invoice_id = export.export_invoice_id', 'LEFT')
			 
			->join('tbl_supplier as supplier', 'pi.supplier_id = supplier.supplier_id', 'LEFT')
			->where('pi_loading_plan_id',$id)
			->get();
			//echo $this->db->last_query();
			return $q->row();
	}
	
	public function product_data($id)
	{
			$q = $this->db->select('mst.*,  pro.size_type_mm,pro.thickness, pro.size_type_cm, detail.p_name, detail.hsnc_code, series.series_name,pro.size_width_mm,pro.size_height_mm,size.product_packing_name, 
			size.box_per_container,size.total_pallent_container,size.no_big_plt_container_new,size.no_small_plt_container_new,size.multi_box_per_container,size.total_boxes,pro.thickness')
				->from('tbl_performa_trn as mst')
				->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
				->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
				->join('product_code_detail as detail', 'detail.hsnc_code = series.hsnc_code', 'LEFT')
				->join("tbl_product_size as size","size.product_size_id=mst.product_size_id","LEFT")
				->where('invoice_id',$id)
				->where('extra_loading',0)
				->order_by('mst.extra_product','asc')
				->order_by('mst.seq','asc')
			 	->get();
				 
			  $return = array();
			  $i=0;
			foreach ($q->result() as $category)
			{
				 $return[$i] = $category;
				 $category->packing = $this->get_packing($category->performa_trn_id);
				 $stock 			= $this->get_all_size_producation($category->product_id);
				 $total_boxes 		= $stock[0]->performa_boxes;
				 $total_boxes 		= $stock[0]->performa_boxes;
				 $producation_box 	= ($stock[0]->producation_boxes + $stock[0]->po_boxes);
				 $assign_box 		= $stock[0]->assign_boxes;
				  
				 $category->remaining   = ($producation_box - $assign_box);
			 $i++;
			 } 
		   
		return $return;
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
	public function all_size($id,$consigne_id)
	{
		$q = $this->db->select("mst.*,pro.size_type_mm,pro.thickness,performa.box_design_id as boxdesignid,performa.pallet_type_id as pallettypeid")
			->from('tbl_performa_trn as mst')
			->join("tbl_product as pro","mst.product_id=pro.product_id","LEFT")
			->join("tbl_performa_box_design as performa","pro.size_type_mm=performa.size_type_mm and performa_invoice_id =".$id,"LEFT")
			->where('invoice_id',$id) 
			->where('mst.product_id !=',0) 
			->group_by("size_type_mm") 
		 	->get(); 
	 
		 return  $q->result();
	}
	public function all_performa_size($production_mst_id,$id)
	{
		$q = $this->db->select("mst.*,pro.size_type_mm,pro.thickness,design.box_design_id,design.pallet_type_id as pallettypeid,design.pallet_type_id as designpallet_type_id")
			->from('tbl_performa_trn as mst')
			->join("tbl_product as pro","mst.product_id=pro.product_id","LEFT")
			->join("tbl_performa_box_design as design","pro.size_type_mm=design.size_type_mm and performa_invoice_id =".$id." and production_mst_id =".$production_mst_id,"LEFT")
			->where('invoice_id',$id) 
			->where('mst.product_id !=',0) 
			->group_by("size_type_mm") 
		 	->get(); 
	 
		 return  $q->result();
	}
	public function select_supplier(){
		$q = $this->db->get('tbl_supplier');
		return $q->result();
	}
	
	public function select_containerno($id){
		$q = $this->db->get('tbl_pi_loading_plan');
		return $q->result();
	}
	
	
	
	public function company_wise_detail($performa_invoice_id,$val,$supplier_id,$export_time)
	{
		$where = '';
		$where1 = '';
		 
		if($val == 1)
		{
			$where = ' and already_done = 1';
		}
		if($val == 3)
		{
			$where = ' and export_done_status = 1';
		}
		if(!empty($supplier_id))
		{
			$where  .=' and mst.supplier_id = '.$supplier_id;
			$where1  .=' and supplier_id = '.$supplier_id;
		}
		if(!empty($export_time))
		{
			$where  .=' and mst.export_time = '.$export_time;
			$where1  .=' and export_time 	= '.$export_time;
		}
		 $sql_qry = 'SELECT mst.export_done_status,mst.export_time,export.export_invoice_no,mst.con_entry,mst.performa_invoice_id,
						(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,performa_invoice_id FROM tbl_pi_loading_plan where performa_invoice_id = '.$performa_invoice_id.$where1.' GROUP BY con_entry,supplier_id) AS inner_query where performa_invoice_id = '.$performa_invoice_id.$where1.' and  supplier_id = mst.supplier_id and export_time = mst.export_time   GROUP BY inner_query.supplier_id) as total_con ,
						(select count(con_entry) from tbl_pi_loading_plan where con_entry = mst.con_entry and performa_invoice_id = '.$performa_invoice_id.' and supplier_id != mst.supplier_id and export_time = mst.export_time) as rowcon_no,
						(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id  FROM tbl_pi_loading_plan where performa_invoice_id = '.$performa_invoice_id.$where1.' GROUP BY con_entry,supplier_id) AS inner_query  where performa_invoice_id = '.$performa_invoice_id.$where1.' and  supplier_id = mst.supplier_id and export_time = mst.export_time  and container_size = 20 GROUP BY inner_query.supplier_id) as con_twenty,
						(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,container_size,performa_invoice_id FROM tbl_pi_loading_plan where performa_invoice_id = '.$performa_invoice_id.$where1.' GROUP BY con_entry,supplier_id) AS inner_query  where performa_invoice_id = '.$performa_invoice_id.$where1.' and  supplier_id = mst.supplier_id and export_time = mst.export_time and container_size = 40 GROUP BY inner_query.supplier_id) as con_fourty,
						
						(SELECT  sum(inner_query.loading_container) FROM (SELECT loading_container,supplier_id,export_time,container_size,performa_invoice_id  FROM tbl_pi_loading_plan where performa_invoice_id = '.$performa_invoice_id.$where1.' GROUP BY con_entry,supplier_id) AS inner_query  where performa_invoice_id = '.$performa_invoice_id.$where1.' and  supplier_id = mst.supplier_id and export_time = mst.export_time  and container_size = 20 GROUP BY inner_query.supplier_id) as loading_containertwenty,
						(SELECT  sum(inner_query.loading_container) FROM (SELECT loading_container,supplier_id,export_time,container_size,performa_invoice_id FROM tbl_pi_loading_plan where performa_invoice_id = '.$performa_invoice_id.$where1.' GROUP BY con_entry,supplier_id) AS inner_query  where performa_invoice_id = '.$performa_invoice_id.$where1.' and  supplier_id = mst.supplier_id and export_time = mst.export_time and container_size = 40 GROUP BY inner_query.supplier_id) as loading_containerfourty,
						
						sup.company_name,mst.supplier_id FROM `tbl_pi_loading_plan` as mst 
						inner join tbl_supplier as sup on sup.supplier_id = mst.supplier_id 
						left join tbl_export_invoice as export on export.export_invoice_id = mst.export_time 
						where mst.performa_invoice_id = '.$performa_invoice_id.$where.' group by mst.supplier_id,mst.export_time'; 
		$q_con = $this->db->query($sql_qry);
		return $q_con->result();
	}
	public function companywisedetail($performa_invoice_id)
	{
		
		$where = ' and already_done =1';
		$where1 = ' and already_done =1';
		$sql_qry = 'SELECT 
						(select count(*) from tbl_pi_loading_plan where con_entry = mst.con_entry and performa_invoice_id in ('.$performa_invoice_id.') and loading_container != "") as mix_rowspan,
						(select group_concat(supplier_id) from tbl_pi_loading_plan where con_entry = mst.con_entry and export_done_status = 0  and  performa_invoice_id in ('.$performa_invoice_id.')'.$where1.') as totalsupplier_id,
						(SELECT  sum(inner_query.container) FROM (SELECT container,supplier_id,export_time,performa_invoice_id,export_done_status FROM tbl_pi_loading_plan where  performa_invoice_id in ('.$performa_invoice_id.')'.$where1.' GROUP BY con_entry,supplier_id,performa_invoice_id) AS inner_query where  performa_invoice_id in ('.$performa_invoice_id.')'.$where1.' and  supplier_id = mst.supplier_id and export_time = mst.export_time and container >= 1 and export_done_status = 0  GROUP BY inner_query.supplier_id) as total_con, 

						
						(select count(con_entry) from tbl_pi_loading_plan where con_entry = mst.con_entry and performa_invoice_id in ('.$performa_invoice_id.') '.$where1.' and updated_net_weight !=0) as rowcon_no, 
						
					 	sup.company_name,mst.supplier_id,con_entry,mst.performa_invoice_id,loading_container FROM `tbl_pi_loading_plan` as mst inner join tbl_supplier as sup on sup.supplier_id = mst.supplier_id where performa_invoice_id in ('.$performa_invoice_id.')'.$where.' and container >= 1 and export_done_status = 0  group by mst.supplier_id,mst.performa_invoice_id'; 
		$q_con = $this->db->query($sql_qry);
		return $q_con->result();
	}
	public function mixcontainerdetail($performa_invoice_id)
	{
		
			$where = ' and already_done =1';
			  $sql_qry = 'SELECT  mst.*,sup.company_name,(select count(con_entry) from tbl_pi_loading_plan where con_entry = mst.con_entry and  performa_invoice_id in ('.$performa_invoice_id.')'.$where.' and export_done_status = 0 and container < 1  ) as rowcon_no,(select sum(container) from tbl_pi_loading_plan where con_entry = mst.con_entry and  performa_invoice_id in ('.$performa_invoice_id.')'.$where.' and export_done_status = 0 and container < 1  ) as totalcontainer,(select group_concat(supplier_id) from tbl_pi_loading_plan where con_entry = mst.con_entry and export_done_status = 0  and  performa_invoice_id in ('.$performa_invoice_id.')'.$where.') as totalsupplier_id from tbl_pi_loading_plan as mst inner join tbl_supplier as sup on sup.supplier_id = mst.supplier_id where container < 1 and export_done_status = 0 and   performa_invoice_id in ('.$performa_invoice_id.')'.$where.' order by mst.con_entry asc'; 
			$q_con = $this->db->query($sql_qry);
			return $q_con->result();
	}
	public function update_con_entry($performa_invoice_id)
	{
		//$performa_invoice_id = explode(",",$performa_invoice_id);
		
		 
			$no=0;
			$select_qry = "SELECT * FROM `tbl_pi_loading_plan` where performa_invoice_id in (".$performa_invoice_id.") and export_time= 0 and already_done =1 order by con_entry desc";
			$select_con = $this->db->query($select_qry);
			$select_result =  $select_con->result();
			$container_array = array();
			
			foreach($select_result as $row)
			{
				 
				if($row->container < 1)
				{
					if(!in_array($row->container_no,$container_array))
					{
						 $sql_query = "UPDATE tbl_pi_loading_plan SET con_entry = ".$row->con_entry.",con_no = ".$row->con_no." where container_no = '".$row->container_no."' and performa_invoice_id in (".$performa_invoice_id.")"; 
						 $q_con = $this->db->query($sql_query);
						 array_push($container_array,$row->container_no);
					}						
					 
				}
			}
		 
		return 1;
	}
	public function product_set_data($id,$value)
	{
		$where = '';
		$where1 = '';
		 
		 if($value > 0)
		 {
			 $where	= ' and export_time = '.$value;
			 $where1	= ' and export_done_status = 1';
		 }
		 else if($value == 0)
		 {
			  $where	= ' and export_done_status = 0';
			  $where1	= ' and export_done_status = 0';
		 }
		  
		 else if($value == -2)
		 {
			 $where = ' and make.export_done_status = 1 and make.already_done = 1 and make.export_time != 0 and pi_loading_plan_id in (SELECT pi_loading_plan_id FROM `tbl_export_loading_trn` as trn inner join tbl_export_invoice as mst on mst.export_invoice_id = trn.export_invoice_id where mst.step = 4 and mst.status = 0)';
		 }
	 	$qry = 'SELECT `make`.*, `mst`.*, `packing`.*, `model`.`model_name`, `model`.`design_file`, `finish`.`finish_name`, `pro`.`size_type_mm`, `pro`.`size_type_cm`,
		(select count(con_entry) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$id.$where1.' ) as rowcon_no, 
		
		(select pallet_ids from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id ='.$id.$where1.'  and find_in_set(make.pi_loading_plan_id,pallet_ids)) as pallet_row,
		(select max(con_entry) from tbl_pi_loading_plan where  performa_invoice_id = '.$id.$where1.' ) as max_no,
		
		(select sum((origanal_boxes * inner_trn.weight_per_box)) from tbl_pi_loading_plan as inner_make  LEFT JOIN `tbl_performa_trn` as `inner_trn` ON `inner_trn`.`performa_trn_id` = `inner_make`.`performa_trn_id`  where con_entry = make.con_entry and performa_invoice_id =  '.$id.$where1.' ) as orignal_net_weight,
		
		(select sum(packing_net_weight) from tbl_pi_loading_plan as inner_make  LEFT JOIN `tbl_performa_packing` as `inner_packing` ON `inner_packing`.`performa_packing_id` = `inner_make`.`performa_packing_id`  where con_entry = make.con_entry and performa_invoice_id =  '.$id.$where1.' ) as other_orignal_net_weight,
		
		(select sum(packing_gross_weight) from tbl_pi_loading_plan as inner_make  LEFT JOIN `tbl_performa_packing` as `inner_packing` ON `inner_packing`.`performa_packing_id` = `inner_make`.`performa_packing_id`  where con_entry = make.con_entry and performa_invoice_id =  '.$id.$where1.' ) as other_orignal_gross_weight,
		
		(select sum((origanal_pallet * inner_trn.pallet_weight))  from tbl_pi_loading_plan as inner_make  LEFT JOIN `tbl_performa_trn` as `inner_trn` ON `inner_trn`.`performa_trn_id` = `inner_make`.`performa_trn_id`  where con_entry = make.con_entry and performa_invoice_id =  '.$id.$where1.') as orignal_pallet_weight,
		
		(select sum((orginal_no_of_big_pallet * inner_trn.big_pallet_weight)) from tbl_pi_loading_plan as inner_make  LEFT JOIN `tbl_performa_trn` as `inner_trn` ON `inner_trn`.`performa_trn_id` = `inner_make`.`performa_trn_id`  where con_entry = make.con_entry and performa_invoice_id =  '.$id.$where1.') as orignal_big_pallet_weight,
		
	 	(select sum((orginal_no_of_small_pallet * mst.small_pallet_weight))  from tbl_pi_loading_plan as inner_make  LEFT JOIN `tbl_performa_trn` as `inner_trn` ON `inner_trn`.`performa_trn_id` = `inner_make`.`performa_trn_id`  where con_entry = make.con_entry and performa_invoice_id =  '.$id.$where1.') as orignal_small_pallet_weight,
		
		`sup`.`company_name` FROM `tbl_pi_loading_plan` as `make` 
		 LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `make`.`performa_packing_id` 
		 LEFT JOIN `tbl_performa_trn` as `mst` ON `packing`.`performa_trn_id` = `mst`.`performa_trn_id` 
		 LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `mst`.`product_id` 
		 LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 
		 LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id` 
		 LEFT JOIN `tbl_supplier` as `sup` ON `sup`.`supplier_id`=`make`.`supplier_id` 
		 WHERE `performa_invoice_id` = '.$id.$where.' ORDER BY `make`.`con_entry` ASC, make.updated_net_weight desc';  
		 $q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
	public function loading_data($performa_invoice_id,$supplier_id,$export_time)
	{
			$q = $this->db->select('make.*,mst.*,packing.*,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,pro.size_width_mm,pro.size_height_mm,
				(select pallet_ids from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$performa_invoice_id.' and find_in_set(make.pi_loading_plan_id,pallet_ids)) as pallet_row,
				
				(select sum(origanal_boxes)   from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$performa_invoice_id.' and find_in_set(pi_loading_plan_id,make.pallet_ids)) as sum_boxes,
				
				(select count(con_entry) from tbl_pi_loading_plan where con_entry = make.con_entry and supplier_id = make.supplier_id and performa_invoice_id = '.$performa_invoice_id.') as rowcon_no,
					
			 	(select (SUM(origanal_boxes) * mst.weight_per_box) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$performa_invoice_id.') as orignal_net_weight,
				(select (SUM(origanal_pallet) * mst.pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$performa_invoice_id.') as orignal_pallet_weight,
				(select (SUM(orginal_no_of_big_pallet) * mst.big_pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$performa_invoice_id.') as orignal_big_pallet_weight,
				(select (SUM(orginal_no_of_small_pallet) * mst.small_pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$performa_invoice_id.') as orignal_small_pallet_weight,sup.company_name')
				->from('tbl_pi_loading_plan as make')
				->join('tbl_performa_packing as packing','packing.performa_packing_id = make.performa_packing_id', 'LEFT')
			 	->join('tbl_performa_trn as mst','packing.performa_trn_id = mst.performa_trn_id', 'LEFT')
				->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
				 ->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
				->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
				->join("tbl_supplier as sup","sup.supplier_id=make.supplier_id","LEFT")
			  	->where('performa_invoice_id',$performa_invoice_id)
			  	->where('make.supplier_id',$supplier_id)
			  	->where('make.export_time',$export_time)
			 	->order_by('make.con_entry','asc')
			 	->get();
		   
		return $q->result();
	}
 	public function get_packing($id)
	{
		$q= 'SELECT `mst`.*, `model`.`model_name`, `model`.`design_file`, `finish`.`finish_name`, `model`.`no_of_randome`, `design`.`box_design_name`, `design`.`box_design_img`, `type`.`pallet_type_name`, `model`.`field1`, `model`.`field2` FROM `tbl_performa_packing` as `mst` LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`mst`.`design_id` LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`mst`.`finish_id` LEFT JOIN `tbl_pallet_type` as `type` ON `type`.`pallet_type_id`=`mst`.`pallet_type_id` LEFT JOIN `tbl_box_design` as `design` ON `design`.`box_design_id`=`mst`.`box_design_id` WHERE `mst`.`performa_trn_id` = "'.$id.'" AND IF(mst.design_id > 0, mst.no_of_boxes > 0, mst.design_id =0)';
		 $q_con = $this->db->query($q);
		return $q_con->result();
	}
	public function get_product_packing_data($id)
	{
		$q= $this->db->select("mst.*,trn.*,pro.size_type_mm,pro.thickness, pro.size_type_cm,series.series_name,model.model_name,model.design_file,finish.finish_name,model.field1,model.field2")
			 ->from("tbl_performa_packing as mst")
			 ->join("tbl_performa_trn as trn","trn.performa_trn_id=mst.performa_trn_id","LEFT")
			 ->join('tbl_product as pro', 'pro.product_id = trn.product_id', 'LEFT')
			 ->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
			  ->join("tbl_packing_model as model","model.packing_model_id=mst.design_id","LEFT")
			 ->join("tbl_finish as finish","finish.finish_id=mst.finish_id","LEFT")
			  ->where("mst.performa_packing_id",$id)
			 ->get();
		 
		return $q->row();
	}
	public function insert_cointainer($data)
	{
		$q = $this->db->insert('tbl_pi_loading_plan',$data);
		 
		return $this->db->insert_id();
	}
	public function update_cointainer($data,$id)
	{
		  
		 $q = 	$this->db->where('pi_loading_plan_id', $id);
		 $q =   $this->db->update('tbl_pi_loading_plan', $data);
		 
		return $q; 
	}
	public function update_export_cointainer($data,$id)
	{
		  
		$q = 	$this->db->where('pi_loading_plan_id', $id);
		$q =   $this->db->update('tbl_export_loading_trn', $data);
		 
		return $q; 
	}
	public function get_export_detail($id)
	{
		$q = $this->db->where('pi_loading_plan_id',$id);
		$q = $this->db->get('tbl_export_loading_trn');
		return $q->row();  
		 
	}
	public function delete_vgm($export_invoice_id)
	{
		 
		$q = $this->db->where('export_invoice_id',$export_invoice_id);
		$q = $this->db->delete('tbl_vgm');
		 
		return $q;
	}
	public function update_producation_mst($data,$id)
	{
		$q1 = $this->db->where('table_id',$id);
		$q1 = $this->db->where('invoice_table_name','producation_view');
		$q1 =  $this->db->delete('tbl_invoices_html');
		$this->db->where('production_mst_id', $id);
		 
		return  $this->db->update('tbl_production_mst', $data);
		 
	}
	
	public function update_loading_plan($con_entry,$performa_invoice_id,$data)
	{
		$q = $this->db->where('con_entry',$con_entry);
		$q = $this->db->where('performa_invoice_id',$performa_invoice_id);
		$q = $this->db->update('tbl_pi_loading_plan',$data);
		 
		return $q;
	}
	public function update_exportcointainer($con_entry,$performa_invoice_id,$data)
	{
	  $q1 = $this->db->where('con_entry',$con_entry);
	  $q1 = $this->db->where('performa_invoice_id',$performa_invoice_id);
	  $q1 = $this->db->update('tbl_export_loading_trn',$data);
		return $q; 
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
	public function delete_loadingtrn($con_entry,$performa_invoice_id)
	{
		$q = $this->db->where('con_entry',$con_entry);
		$q = $this->db->where('performa_invoice_id',$performa_invoice_id);
		$q = $this->db->delete('tbl_pi_loading_plan');
		 
		return $q;
	}
	public function deleteloadingtrn($pi_loading_plan_id)
	{
		 
		$q = $this->db->where('pi_loading_plan_id',$pi_loading_plan_id);
		$q = $this->db->delete('tbl_pi_loading_plan');
		 
		return $q;
	}
	public function b_insert($data){
		 $this->db->insert('performa_invoice',$data);
		 return $cid = $this->db->insert_id();
		} 
	public function p_update($data){
		
	return $this->db->insert('invoice_product_data',$data);
	}
	public function s_del($id){
		
		$this->db->where('id',$id);
		return $this->db->delete('invoice_product_data');
	}
	public function performa_invoice_stepupdate($id,$step)
	{
		$data = array(
          "step" =>$step,
		); 
		$this->db->where('performa_invoice_id', $id);
		return  $this->db->update('tbl_performa_invoice', $data);
		// echo $this->db->last_query();
	}
	public function change_full_status($data,$autometic_loading_plan_id)
	{
		 
		$q = $this->db->where('autometic_loading_plan_id', $autometic_loading_plan_id);
		$q =  $this->db->update('tbl_autometic_loading_plan', $data);
		// echo $this->db->last_query();
		return $q;
	}
	public function fields_data($id)
	{
		$q = 'SELECT * FROM `tbl_performa_packing_fields` as mst left join tbl_packing_fields as trn on trn.packing_fields_id=mst.packing_fields_id where performa_invoice_id='.$id.'   ORDER BY trn.`packing_fields_id` ASC';
		$q_con = $this->db->query($q);
		if($q_con->num_rows()==0)
		{
			$q = 'SELECT * FROM `tbl_packing_fields` ORDER BY `packing_fields_id` ASC';
			$q_con = $this->db->query($q);
			$result = $q_con->result();
		}
		else
		{
			$result = $q_con->result();
		}
		return  $result;
	} 
	public function insert_producation_mst($data)
	{
		 $this->db->insert('tbl_production_mst',$data);
		 return $cid = $this->db->insert_id();
	} 
	public function insert_producation_trn($data)
	{
		 $this->db->insert('tbl_production_trn',$data);
		 return $cid = $this->db->insert_id();
	} 
	public function delete_boxdesign_data($id)
	{
		
		$this->db->where('production_mst_id',$id);
		return $this->db->delete('tbl_performa_box_design');
	}
	public function auto_loading($id){
		
		$q = $this->db->where('performa_invoice_id',$id);
		$q = $this->db->delete('tbl_autometic_loading_plan');
		
		return $q1;
	}
	public function copycontainter($performa_trn_id,$production_mst_id)
	{
		$q  = "select * from tbl_performa_trn as mst where performa_trn_id in (".$performa_trn_id.")";
		$q_result = $this->db->query($q);
		foreach($q_result->result() as $rowcon)
		{
			$data = array(
						'production_mst_id'		=> $production_mst_id,
					 	'performa_trn_id'		=> $rowcon->performa_trn_id,
						'status'				=>  0
					);
				$insertrnid = $this->insert_producation_trn($data);
			
		}
		return 1;
	}
	public function setting_data($id)
	{
		$array = array('log_id' => $id);
		$q = $this->db->where($array);
		$q = $this->db->get('ciadmin_login');
		 //echo $this->db->last_query();
		return $q->row();
	}
	public function get_producation_data($id,$from)
	{
		$where = '';
		if($from == 1)
		{
			$setting_data 	= $this->setting_data(1);
			if(!empty($setting_data->qc_checked))
			{
				$where .= ' and mst.qc_status = 1 ';
			}
			if(!empty($setting_data->palletization_checked))
			{
				$where = '  and mst.pallet_status = 1';
			}
			
		}
		$q  = "select mst.*,sup.*,additional.readiness_date from tbl_production_mst as mst left join tbl_supplier as sup on sup.supplier_id = mst.supplier_id 
		left join tbl_performa_additional_detail as additional on additional.production_mst_id = mst.production_mst_id
		where performa_invoice_id =".$id.$where;
		$q_result = $this->db->query($q);
		$return = array();
		$con = 0;
		$i=0;
		foreach ($q_result->result() as $category) 
		{
				 $return[$i] = $category;
				 $category->production_trn = $this->producation_trn_data($category->production_mst_id);
				 $con += $category->no_of_countainer;
			 $i++;
		} 
		$return['total_con'] = $con;
		return $return;
	}
	
	public function producation_mst_data($id)
	{
		  $q  = "select *,mst.note as po_notes  from tbl_production_mst as mst 
			inner join tbl_performa_invoice as performa on performa.performa_invoice_id = mst.performa_invoice_id 
			inner join customer_detail as cust on cust.id = performa.consigne_id 
			left join tbl_performa_additional_detail as additional on additional.production_mst_id = mst.production_mst_id 
			left join tbl_fumigation as fum on additional.fumigation_id = fum.fumigation_id 
		 	left join tbl_pallet_cap as cap on additional.pallet_cap_id = cap.pallet_cap_id 
		 	left join tbl_supplier as supplier on supplier.supplier_id = mst.supplier_id 
		 	where mst.production_mst_id =".$id; 
		$q_result = $this->db->query($q);
		return $q_result->row();
		 
	}
	public function producation_trn_data($id)
	{
		$q = 'SELECT `mst`.*, `pro`.`size_type_mm`, `pro`.`size_type_cm`, `detail`.`p_name`, `detail`.`hsnc_code`, `series`.`series_name`, `pro`.`size_width_mm`, `pro`.`size_height_mm`, `pro`.`thickness` as product_thickness, `model`.`no_of_randome`, `pro_size`.`total_pallent_container`, `pro_size`.`no_big_plt_container_new`, `pro_size`.`no_small_plt_container_new`, `pro_size`.`box_per_container`, `pro_size`.`multi_box_per_container`, `pro_size`.`total_boxes`, `trn`.`description_goods`, `packing`.`other_image`, `packing`.`per`, `model`.`model_name`, `finish`.`finish_name`, `trn`.`pallet_status`, `trn`.`sqm_per_box`, `trn`.`boxes_per_pallet`, `trn`.`performa_trn_id`, `trn`.`product_id`, `model`.`design_file`, `trn`.`pcs_per_box`, `trn`.`box_per_big_pallet`, `trn`.`box_per_small_pallet`, `trn`.`extra_product`, `packing`.`client_name`, `packing`.`barcode_no`, `packing`.`packing_net_weight`, `packing`.`packing_gross_weight`, `trn`.`weight_per_box`, `autometic`.`autometic_loading_plan_id`, `autometic`.`no_of_pallet` as `auto_no_of_pallet`, `autometic`.`no_of_boxes` as `auto_no_of_boxes`, `autometic`.`no_of_sqm` as `auto_no_of_sqm`, `autometic`.`no_of_big_pallet` as `auto_no_of_big_pallet`, `autometic`.`no_of_small_pallet` as `auto_no_of_small_pallet`, `mst`.`thickness`, `design`.`box_design_name`, `design`.`box_design_img`, `type`.`pallet_type_name`, (select group_concat(production_trn_id) from tbl_pi_loading_plan where production_trn_id =mst.production_trn_id) as already_loading FROM `tbl_production_trn` as `mst`
		LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `mst`.`performa_packing_id` 
		LEFT JOIN `tbl_autometic_loading_plan` as `autometic` ON `autometic`.`production_trn_id` = `mst`.`production_trn_id` 
		LEFT JOIN `tbl_performa_trn` as `trn` ON `trn`.`performa_trn_id` = `packing`.`performa_trn_id` 
		LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `trn`.`product_id` 
		LEFT JOIN `tbl_product_size` as `pro_size` ON `pro_size`.`product_size_id` = `trn`.`product_size_id` 
		LEFT JOIN `tbl_series` as `series` ON `series`.`series_id` = `pro`.`series_id` LEFT JOIN `product_code_detail` as `detail` ON `detail`.`hsnc_code` = `series`.`hsnc_code` 
		LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 
		LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id`
		LEFT JOIN `tbl_box_design` as `design` ON `design`.`box_design_id`=`mst`.`box_design_id` 
		LEFT JOIN `tbl_pallet_type` as `type` ON `type`.`pallet_type_id`=`mst`.`pallet_type_id` WHERE `mst`.`production_mst_id` = "'.$id.'" AND   IF(`packing`.`design_id` > 0, `mst`.`no_of_boxes` > 0, `packing`.`design_id` =0) ORDER BY `packing`.`performa_packing_id` ASC';
		  $q_result = $this->db->query($q);   
			  $return = array();
			  $i=0;
			foreach ($q_result->result() as $category) {
				 $return[$i] = $category;
			  	 $category->packing = $this->get_packing($category->performa_trn_id);
			 $i++;
			 } 
		   
		return $return;
		 
	}
	public function producation_trn_multiple_data($id)
	{
		
		$q =  'SELECT `mst`.*, `pro`.`size_type_mm`, `pro`.`size_type_cm`, `detail`.`p_name`, `detail`.`hsnc_code`, `series`.`series_name`, `pro`.`size_width_mm`, `pro`.`size_height_mm`, `model`.`model_name`, `finish`.`finish_name`, `trn`.`pallet_status`, `trn`.`sqm_per_box`, `trn`.`boxes_per_pallet`, `trn`.`performa_trn_id`, `trn`.`product_id`, `model`.`design_file`, `trn`.`pcs_per_box`, `trn`.`box_per_big_pallet`, `trn`.`box_per_small_pallet`,trn.description_goods, `packing`.`client_name`, packing.per, `packing`.`barcode_no`, `pmst`.`supplier_id`, `supplier`.`company_name`, pmst.no_of_countainer,`mst`.`production_mst_id`,autometic.autometic_loading_plan_id  FROM `tbl_production_trn` as `mst` 
		INNER JOIN `tbl_production_mst` as `pmst` ON `pmst`.`production_mst_id` = `mst`.`production_mst_id` 
		LEFT JOIN 	tbl_autometic_loading_plan as autometic on  autometic.production_trn_id = mst.production_trn_id
		INNER JOIN `tbl_supplier` as `supplier` ON `supplier`.`supplier_id` = `pmst`.`supplier_id` 
		INNER JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `mst`.`performa_packing_id` 
		INNER JOIN `tbl_performa_trn` as `trn` ON `trn`.`performa_trn_id` = `packing`.`performa_trn_id` 
		LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `trn`.`product_id` 
		LEFT JOIN `tbl_series` as `series` ON `series`.`series_id` = `pro`.`series_id` 
		LEFT JOIN `product_code_detail` as `detail` ON `detail`.`hsnc_code` = `series`.`hsnc_code` 
		LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 
		LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id`
		WHERE find_in_set(`mst`.`production_trn_id`,"'.$id.'") ORDER BY `packing`.`performa_packing_id` ASC';	
		$q_result = $this->db->query($q);	  
			  $return = array();
			  $i=0;
			foreach ($q_result->result() as $category) 
			{
				 $return[$i] = $category;
				 $category->packing = $this->get_packing($category->performa_trn_id);
			 $i++;
			 } 
		   
		return $return;
		 
	}
	public function delete_producation($id){
		
		$q = $this->db->where('production_mst_id',$id);
		$q = $this->db->delete('tbl_production_mst');
		$q1 = $this->db->where('production_mst_id',$id);
		$q1 = $this->db->delete('tbl_production_trn');
		$q1 = $this->db->where('production_mst_id',$id);
		$q1 = $this->db->delete('tbl_performa_box_design');
		$q1 = $this->db->where('production_mst_id',$id);
		$q1 = $this->db->delete('tbl_performa_additional_detail');
		return 1;
	}
	public function deleteproducation($id){
		
	 	$q1 = $this->db->where('production_mst_id',$id);
		$q1 = $this->db->delete('tbl_production_trn');
		return 1;
	}
	public function get_box_design()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_box_design');
		return $q->result();
	}
	public function edit_loadingtrn($con_entry,$performa_invoice_id)
	{
		$q = $this->db->select('make.*,packing.*,mst.*,series.series_name,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,
		(select count(con_entry) from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$performa_invoice_id.') as rowcon_no,
		(select pallet_ids from tbl_pi_loading_plan where con_entry = make.con_entry and performa_invoice_id = '.$performa_invoice_id.' and find_in_set(make.pi_loading_plan_id,pallet_ids)) as pallet_row,
		(select max(con_entry) from tbl_pi_loading_plan where  performa_invoice_id = '.$performa_invoice_id.') as max_no')
				->from('tbl_pi_loading_plan as make')
				->join('tbl_performa_packing as packing','packing.performa_packing_id = make.performa_packing_id', 'LEFT')
			 	->join('tbl_performa_trn as mst','packing.performa_trn_id = mst.performa_trn_id', 'LEFT')
				->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
				 ->join('tbl_series as series', 'pro.series_id = series.series_id', 'LEFT')
				 ->join("tbl_packing_model as model","model.packing_model_id=packing.design_id","LEFT")
				->join("tbl_finish as finish","finish.finish_id=packing.finish_id","LEFT")
			  	->where('performa_invoice_id',$performa_invoice_id)
			  	->where('con_entry',$con_entry)
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
	public function get_product_size($product_id)
	{
		$q= $this->db->select("mst.*,")
			 ->from("tbl_product_size as mst")
			  ->where('mst.status',"0")
			  ->where('mst.product_id',$product_id)
			 ->get();
		  
		 return $q->result();
	}
	public function get_product_size_detail($product_size_id)
	{
	 	$q= $this->db->select("mst.*,")
			 ->from("tbl_product_size as mst")
			  ->where('mst.status',"0")
			  ->where('mst.product_size_id',$product_size_id)
			 ->get();
		 
		 return $q->row();
	}
	public function get_design($product_id)
	{
		$q= $this->db->select("mst.*,")
			 ->from("tbl_packing_model as mst")
			  ->where('mst.status',"0")
			  ->where('mst.product_id',$product_id)
			 ->get();
		  
		 return $q->result();
	}
	public function insert_productrecord($data){
		$q =  $this->db->insert('tbl_performa_trn',$data);
		return $this->db->insert_id();
	}
	public function insert_packing_data($packing_data)
	{
		 $q =  $this->db->insert('tbl_performa_packing',$packing_data);
		 return $this->db->insert_id();
	}
	
	public function updat_data($updateweight_data,$id1)
	{
		 $this->db->where('performa_invoice_id',$id1);	
	     return $this->db->update('tbl_pi_loading_plan',$updateweight_data);	
 	}
	
	
	public function hsncproductsizedetail($id,$mode)
	{
	  $q = $this->db->select('mst.*, serices.hsnc_code, pro.size_type_mm, pro.defualt_rate, pro.thickness, hsnc.p_name, serices.series_name')
			->from('tbl_product_size as mst')
			->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
			->join('tbl_series as serices','serices.series_id = pro.series_id', 'LEFT')
			->join('product_code_detail as hsnc','hsnc.hsnc_code = serices.hsnc_code', 'LEFT')
			->where('mst.product_id',$id)
			->order_by("serices.hsnc_code", "desc")
			->get();
			
		if($mode==1)
		{
			return $q->num_rows();
		}
		else
		{
			return $q->result();
		}
	}
	public function get_cust_additional_data($id)
	{
		
		$q = $this->db->select('cust.*')
			 ->from('tbl_customer_add_detail as cust')
			 ->where('customer_id',$id)
			 
			->get();	
		
		return $q->row();
	}
	public function get_fumigation()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_fumigation');
		return $q->result();
	}
	public function get_pallet_type()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_pallet_type');
		return $q->result();
	}
	public function get_pallet_cap()
	{
		$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_pallet_cap');
		return $q->result();
	}
	 public function delete_cointainer($pi_loading_plan_id)
	{
		$q = $this->db->where('pi_loading_plan_id in ('.$pi_loading_plan_id.') and pi_loading_plan_id !=','0');
	 	$q = $this->db->delete('tbl_pi_loading_plan');
		return $q;
	}
	 public function check_invoice_html($table_name,$performa_invoice_id)
	{
		$q = $this->db->where('table_id',$performa_invoice_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name',$table_name);
		$q = $this->db->get('tbl_invoices_html');
		
	 	return $q->row();
	} 
	public function insert_invoice_html($data){
		 
		$this->db->insert('tbl_invoices_html',$data);
		 return  $this->db->insert_id();
	}
	public function update_invoice_html($data,$id,$invoice_table_name)
	{
		$q1 = $this->db->where('table_id',$id);
		$q1 = $this->db->where('invoice_table_name',$invoice_table_name);		
		$q1 = $this->db->update('tbl_invoices_html',$data);
		return $q1; 		
	}
	public function html_delete($id)
	{
		$q1 = $this->db->where('table_id',$id);
		$q1 = $this->db->delete('tbl_invoices_html');
		return $q1; 		
	}
	public function get_invoice_html($cust_id,$invoice_table_name)
	{
		$q = $this->db->where('table_id',$cust_id);
		$q = $this->db->where('status',0);
		$q = $this->db->where('invoice_table_name',$invoice_table_name);
		$q = $this->db->get('tbl_invoices_html');
		 
	 	return $q->row();
	} 
	 public function get_pallet_order_pary(){
		$q = $this->db->get('tbl_pallet_party');
		return $q->result();
	} 
	
	// public function get_pallet_order_pary(){
		// $q = $this->db->get('tbl_supplier');
		// return $q->result();
	// }
	public function insert_pallet_order($data){
		 
		$cid = $this->db->insert('tbl_pallet_order',$data);
		  return $cid = $this->db->insert_id();
	}	
	public function insert_pallet_order_trn($data){
		 
		$cid = $this->db->insert('tbl_pallet_order_trn',$data);
		  return $cid = $this->db->insert_id();
	}
	public function pallet_order_update($data,$id)
	{
		 $this->db->where('production_mst_id',$id);	
	     return $this->db->update('tbl_pallet_order',$data);	
 	}
	public function pallet_order_trn_delete($id){
		$this->db->where('pallet_order_id',$id);
		return $this->db->delete('tbl_pallet_order_trn');
	}
	public function pallet_orderrecord($id)
	{
		$q= $this->db->select("mst.*")
			 ->from("tbl_pallet_order as mst")
			 ->where("mst.production_mst_id",$id)
			 ->get();
		 
		return $q->result();
	} 
	public function pallet_order($id){
		 
		$array = array('mst.production_mst_id'=>$id);
		$q = $this->db->select("mst.*,party.*,pro.producation_no,pro.producation_date,invoice.exporter_detail,order.factory")
			->from('tbl_pallet_order as mst')
		 	->join('tbl_production_mst as pro','pro.production_mst_id  = mst.production_mst_id ','LEFT')
		 	->join('tbl_performa_invoice as invoice','invoice.performa_invoice_id  = pro.performa_invoice_id ','LEFT')
		 	->join('tbl_pallet_party as party','party.pallet_party_id  = mst.pallet_party_id ','LEFT')
			->join('tbl_pallet_order_trn as order','order.pallet_order_id  = mst.pallet_order_id ','LEFT')
			//->join('tbl_pallet_type as type','type.pallet_type_id  = mst.pallet_type ','LEFT')
		 	->where($array)
	 		->get();
	 	 
		return $q->row();
	}
	public function palletordertrn($id)
	{
		 
		$array = array('mst.pallet_order_id'=>$id);
		$q = $this->db->select("mst.*,type.pallet_type_name,packing.model_name")
			->from('tbl_pallet_order_trn as mst')
			->join('tbl_pallet_type as type','type.pallet_type_id  = mst.pallet_type ','LEFT')
			->join('tbl_packing_model as packing','packing.packing_model_id  = mst.product_id ','LEFT')
			->where($array)
	 		->get();
	 	 
		return $q->result();
	}
	
	
	
	public function update_producationsheet($production_mst_id,$status)
	{
		  $data = array(
			"production_status" => $status,"production_complete_date"=>date('Y-m-d')
		  );
		$q = $this->db->where("production_mst_id in ('".$production_mst_id."') and production_mst_id !=",0);
		$q =   $this->db->update('tbl_production_mst', $data);
	 
		return $q;
	}
	public function update_producation($production_mst_id,$status)
	{
		  $data = array(
			"qc_status" => $status
		  );
		$q = $this->db->where("production_mst_id in ('".$production_mst_id."') and production_mst_id !=",0);
		$q =   $this->db->update('tbl_production_mst', $data);
	 
		return $q;
	}
	public function update_producation_pallet($production_mst_id,$status)
	{
		  $data = array(
			"pallet_status" => $status
		  );
		$q = $this->db->where("production_mst_id in ('".$production_mst_id."') and production_mst_id !=",0);
		$q =   $this->db->update('tbl_production_mst', $data);
		 
		return $q;	 
	}
	public function delete_editable($id,$invoice_table_name)
	{
		$this->db->where('table_id',$id);
		$this->db->where('invoice_table_name',$invoice_table_name);
		return $this->db->delete('tbl_invoices_html');
	}
}
