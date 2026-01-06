<?php
class Order_report_model extends CI_model
{
	public function __construct()
	{
		parent:: __construct();	
		$this->load->database();
	}
	public function get_customer()
	{
		if($this->session->usertype_id != 1)
		{
			$q = $this->db->where('find_in_set(id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = '.$this->session->id.' and status =0)) <> ',"0");
		}
		$q = $this->db->get('customer_detail');
	 	return $q->result();
	} 
	public function get_size()
	{
		 $q= $this->db->select("mst.*,mst.size_type_mm as sizetypemm")
			 ->from("tbl_product as mst")
		 	 ->where('mst.status',"0")
			 ->group_by('mst.size_type_mm')
			 ->get();
		return $q->result();
	} 
	public function get_finish()
	{
		$q =  "SELECT `mst`.* FROM `tbl_finish` as `mst` WHERE mst.`status` = '0'";
		$query = $this->db->query($q);
		return $query->result();
	}
	public function get_pallet_type()
	{
		$q =  "SELECT * FROM `tbl_pallet_type` as `mst` WHERE mst.`status` = '0'  and pallet_type_name != ''";
		$query = $this->db->query($q);
		return $query->result();
	}
	public function get_confirm_performa($customer_id,$finish_id,$size_id,$pallet_type,$start_date,$end_date)
	{
		$where = ' and performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consigne_id = ".$customer_id;
		}
		if(!empty($finish_id))
		{
			$where .= " and  packing.finish_id = ".$finish_id;
		} 
		 
		if(!empty($size_id))
		{
			$where .= "   and  product.size_type_mm = '".$size_id."'";
		}
		if(!empty($pallet_type))
		{
			$where .= " and  type.pallet_type_id = '".$pallet_type."'";
		}
		if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		  $sql = "SELECT   mst.performa_invoice_id,packing.pallet_type_id,packing.performa_packing_id,invoice_no,performa_date,c_companyname,trn.product_id, product.size_type_mm as size,finish_name,model.model_name,trn.description_goods,packing.per,type.pallet_type_name,
		no_of_boxes, no_of_sqm,product_amt as grand_total 
		  FROM `tbl_performa_invoice` as mst 
		  left join tbl_performa_trn as trn on trn.invoice_id = mst.performa_invoice_id
		  left join tbl_performa_packing as packing on packing.performa_trn_id = trn.performa_trn_id 
	 	  left join customer_detail as cust on cust.id = mst.consigne_id 
		  left join tbl_packing_model as model on model.packing_model_id = packing.design_id 
		  left join tbl_finish as finish on finish.finish_id 		= packing.finish_id 
		  left join tbl_pallet_type as type on type.pallet_type_id 	= packing.pallet_type_id
		 
		 left join tbl_product as product on product.product_id = trn.product_id 
		 left join tbl_performa_additional_detail as detail on detail.performa_id = mst.performa_invoice_id and detail.production_mst_id = 0
		 
		 where mst.confirm_status = 1 ".$where.' order by mst.mdate desc';
		$query = $this->db->query($sql);
		return $query->result();
	}
	
	public function get_pi_list()
{
    $sql = "SELECT DISTINCT invoice_no
            FROM tbl_performa_invoice
            WHERE confirm_status = 1
            ORDER BY invoice_no ASC";

    return $this->db->query($sql)->result();
}


	
	public function get_producation_sheet_pending(
    $customer_id,
    $finish_id,
    $size_id,
    $pallet_type,
    $start_date,
    $end_date,
    $production_status = ""
	
)
{
    $where = ' AND mst.performa_date BETWEEN "' . date('Y-m-d', strtotime($start_date)) . '" 
               AND "' . date('Y-m-d', strtotime($end_date)) . '"';

    $where .= " AND ptrn.production_trn_id NOT IN 
                (SELECT production_trn_id FROM tbl_pi_loading_plan)";

    // FILTERS
    if (!empty($customer_id)) {
        $where .= " AND mst.consigne_id = " . intval($customer_id);
    }
    if (!empty($finish_id)) {
        $where .= " AND packing.finish_id = " . intval($finish_id);
    }
    if (!empty($size_id)) {
        $where .= " AND product.size_type_mm = '" . $this->db->escape_str($size_id) . "'";
    }
    if (!empty($pallet_type)) {
        $where .= " AND type.pallet_type_id = '" . $this->db->escape_str($pallet_type) . "'";
    }

    // PRODUCTION STATUS
    if ($production_status !== "" && ($production_status == 0 || $production_status == 2)) {
        $where .= " AND ptrn.production_done = " . intval($production_status);
    }

    // USER-WISE CUSTOMER
    if ($this->session->usertype_id != 1) {
        $where .= " AND FIND_IN_SET(
                        mst.consigne_id,
                        (SELECT GROUP_CONCAT(customer_id)
                         FROM tbl_user_wise_customer
                         WHERE user_id = " . intval($this->session->id) . "
                         AND status = 0)
                    )";
    }

    $sql = "SELECT
                mst.performa_invoice_id,
                packing.performa_packing_id,
                mst.invoice_no,
                mst.performa_date,
                cust.c_companyname,
                trn.product_id,
                product.size_type_mm AS size,
                finish.finish_name,
                model.model_name,
                trn.description_goods,
                packing.per,
                product_size.box_per_container,
                product_size.multi_box_per_container,
                packing.product_rate,
                type.pallet_type_name,
                ptrn.no_of_big_pallet,
                ptrn.no_of_pallet,
                ptrn.no_of_small_pallet,
                ptrn.no_of_boxes,
                ptrn.no_of_sqm,
                product_amt AS grand_total,
                ptrn.production_done
            FROM tbl_performa_invoice mst
            LEFT JOIN tbl_performa_trn trn 
                ON trn.invoice_id = mst.performa_invoice_id
            LEFT JOIN tbl_performa_packing packing 
                ON packing.performa_trn_id = trn.performa_trn_id
            INNER JOIN tbl_production_mst pmst 
                ON pmst.performa_invoice_id = mst.performa_invoice_id
            INNER JOIN tbl_production_trn ptrn 
                ON ptrn.performa_packing_id = packing.performa_packing_id
            LEFT JOIN customer_detail cust 
                ON cust.id = mst.consigne_id
            LEFT JOIN tbl_packing_model model 
                ON model.packing_model_id = packing.design_id
            LEFT JOIN tbl_finish finish 
                ON finish.finish_id = packing.finish_id
            LEFT JOIN tbl_pallet_type type 
                ON type.pallet_type_id = packing.pallet_type_id
            LEFT JOIN tbl_product product 
                ON product.product_id = trn.product_id
            LEFT JOIN tbl_product_size product_size 
                ON product_size.product_size_id = trn.product_size_id
            WHERE mst.confirm_status = 1
              AND pmst.production_status != 1
            $where
            ORDER BY mst.invoice_no ASC";

    return $this->db->query($sql)->result();
}


// public function get_producation_sheet_pending($customer_id, $finish_id, $size_id, $pallet_type, $start_date, $end_date, $production_status = "")
// {
    // $where = ' AND performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" AND "'.date('Y-m-d',strtotime($end_date)).'"';
    
    // // exclude packing ids that appear in production_trn with status = 0
    // $where .= ' AND NOT FIND_IN_SET(packing.performa_packing_id, 
              // (SELECT GROUP_CONCAT(performa_packing_id) 
               // FROM tbl_production_trn AS ptrn_sub 
               // WHERE status = 0))';
			   
// $where .= " AND ptrn.production_trn_id NOT IN (SELECT production_trn_id FROM tbl_pi_loading_plan)";

    // if (!empty($customer_id)) {
        // $where .= " AND mst.consigne_id = " . intval($customer_id);
    // }
    // if (!empty($finish_id)) {
        // $where .= " AND packing.finish_id = " . intval($finish_id);
    // }
    // if (!empty($size_id)) {
        // $where .= " AND product.size_type_mm = '" . $this->db->escape_str($size_id) . "'";
    // }
    // if (!empty($pallet_type)) {
        // $where .= " AND type.pallet_type_id = '" . $this->db->escape_str($pallet_type) . "'";
    // }
	

    // // apply production status filter
    // if ($production_status !== "" && ($production_status == 0 || $production_status == 2)) {
        // $where .= " AND ptrn.production_done = " . intval($production_status);
    // }

    // if ($this->session->usertype_id != 1) {
        // $where .= " AND FIND_IN_SET(mst.consigne_id, 
                 // (SELECT GROUP_CONCAT(customer_id) 
                  // FROM tbl_user_wise_customer 
                  // WHERE user_id = " . intval($this->session->id) . " 
                  // AND status = 0))";
    // }

    // $sql = "SELECT
                // mst.performa_invoice_id,
                // packing.performa_packing_id,
                // invoice_no,
                // performa_date,
                // c_companyname,
                // trn.product_id,
                // product.size_type_mm AS size,
                // finish_name,
                // model.model_name,
                // trn.description_goods,
                // packing.per,
                // type.pallet_type_name,
                // ptrn.no_of_boxes,
                // ptrn.no_of_sqm,
                // product_amt AS grand_total,
                // ptrn.production_done
            // FROM `tbl_performa_invoice` AS mst
            // LEFT JOIN tbl_performa_trn AS trn ON trn.invoice_id = mst.performa_invoice_id
            // LEFT JOIN tbl_performa_packing AS packing ON packing.performa_trn_id = trn.performa_trn_id
            // LEFT JOIN tbl_production_mst AS pmst ON pmst.performa_invoice_id = mst.performa_invoice_id
            // LEFT JOIN tbl_production_trn AS ptrn ON ptrn.performa_packing_id = packing.performa_packing_id
           
            // LEFT JOIN customer_detail AS cust ON cust.id = mst.consigne_id
            // LEFT JOIN tbl_packing_model AS model ON model.packing_model_id = packing.design_id
            // LEFT JOIN tbl_finish AS finish ON finish.finish_id = packing.finish_id
            // LEFT JOIN tbl_pallet_type AS type ON type.pallet_type_id = packing.pallet_type_id
            // LEFT JOIN tbl_product AS product ON product.product_id = trn.product_id
            // LEFT JOIN tbl_performa_additional_detail AS detail 
                   // ON detail.performa_id = mst.performa_invoice_id 
                  // AND detail.production_mst_id = 0
            // WHERE mst.confirm_status = 1 and pmst.production_status != 1
            // $where
            // ORDER BY invoice_no ASC";

    // return $this->db->query($sql)->result();
// }
	public function get_under_product($customer_id,$finish_id,$size_id,$pallet_type,$start_date,$end_date)
	{
		 
		$where = ' and producation_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  performa.consigne_id = ".$customer_id;
		}
		if(!empty($finish_id))
		{
			$where .= " and  packing.finish_id = ".$finish_id;
		} 
		 
		if(!empty($size_id))
		{
			$where .= "   and  pro.size_type_mm = '".$size_id."'";
		}
		if(!empty($pallet_type))
		{
			$where .= " and  type.pallet_type_id = '".$pallet_type."'";
		}
		if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(performa.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		 
		  $qry  = "select packing.performa_packing_id,supplier.supplier_name,mst.production_mst_id,performa.performa_invoice_id,performa.invoice_no,cust.c_companyname,pro.size_type_mm as size,model.model_name,finish.finish_name, trn.no_of_boxes,trn.no_of_sqm,performa.grand_total, type.pallet_type_name 
		 
			from tbl_production_mst as mst 
			LEFT join tbl_supplier as supplier on supplier.supplier_id = mst.supplier_id 
			LEFT join tbl_performa_invoice as performa on performa.performa_invoice_id = mst.performa_invoice_id 
			LEFT join customer_detail as cust on cust.id = performa.consigne_id 
			LEFT join tbl_production_trn as trn on trn.production_mst_id = mst.production_mst_id 
			LEFT join tbl_performa_packing as packing on packing.performa_packing_id = trn.performa_packing_id 
			LEFT join tbl_performa_trn as per_trn on per_trn.performa_trn_id = packing.performa_trn_id 
			LEFT join tbl_product as pro on per_trn.product_id = pro.product_id
			left join tbl_pallet_type as type on type.pallet_type_id 	= packing.pallet_type_id			
			LEFT join tbl_packing_model as model on model.packing_model_id = packing.design_id 
			LEFT join tbl_finish as finish on finish.finish_id = packing.finish_id 
		  	where mst.status =0".$where." order by performa.invoice_no asc"; 
			$q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
	public function product_set_data($id,$value)
	{
		$where = ' and make.export_done_status = 1 and make.already_done = 1 and make.export_time != 0 and pi_loading_plan_id in (SELECT pi_loading_plan_id FROM `tbl_export_loading_trn` as trn inner join tbl_export_invoice as mst on mst.export_invoice_id = trn.export_invoice_id where mst.step = 4 and mst.status = 0)';
		
		 $qry = 'SELECT `make`.origanal_boxes, `mst`.sqm_per_box,`make`.origanal_boxes,origanal_pallet,orginal_no_of_big_pallet  FROM `tbl_pi_loading_plan` as `make` 
		 LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `make`.`performa_packing_id` 
		 LEFT JOIN `tbl_performa_trn` as `mst` ON `packing`.`performa_trn_id` = `mst`.`performa_trn_id` 
	 	 WHERE `performa_invoice_id` = '.$id.$where.' ORDER BY `make`.`con_entry` ASC';
		 $q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
	public function product_mst_set_data($id,$value)
	{
		$qry = 'SELECT `make`.*, `mst`.*, `packing`.*, `model`.`model_name`, `model`.`design_file`, `finish`.`finish_name`, `pro`.`size_type_mm`, `pro`.`size_type_cm`, 
		(select count(con_entry) from tbl_pi_loading_plan where con_entry = make.con_entry and production_mst_id = '.$id.') as rowcon_no, 
		(select pallet_ids from tbl_pi_loading_plan where con_entry = make.con_entry and production_mst_id = '.$id.' and find_in_set(make.pi_loading_plan_id,pallet_ids)) as pallet_row,
		(select max(con_entry) from tbl_pi_loading_plan where  production_mst_id =  '.$id.') as max_no,
		(select (SUM(origanal_boxes) * mst.weight_per_box) from tbl_pi_loading_plan where con_entry = make.con_entry and production_mst_id =  '.$id.') as orignal_net_weight,
		(select (SUM(origanal_pallet) * mst.pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and production_mst_id =  '.$id.') as orignal_pallet_weight,
		(select (SUM(orginal_no_of_big_pallet) * mst.big_pallet_weight) from tbl_pi_loading_plan where con_entry = make.con_entry and production_mst_id =  '.$id.') as orignal_big_pallet_weight, `sup`.`company_name` FROM `tbl_pi_loading_plan` as `make` 
		 LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `make`.`performa_packing_id` 
		 LEFT JOIN `tbl_performa_trn` as `mst` ON `packing`.`performa_trn_id` = `mst`.`performa_trn_id` 
		 LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `mst`.`product_id` 
		 LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 
		 LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id` 
		 LEFT JOIN `tbl_supplier` as `sup` ON `sup`.`supplier_id`=`make`.`supplier_id` 
		 WHERE `production_mst_id` = '.$id.' ORDER BY `make`.`con_entry` ASC';
		 $q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
	public function get_produced($customer_id,$finish_id,$size_id,$pallet_type,$start_date,$end_date)
	{
		$where = ' and mst.performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consigne_id = ".$customer_id;
		}
		if(!empty($finish_id))
		{
			$where .= " and  packing.finish_id = ".$finish_id;
		} 
		 
		if(!empty($size_id))
		{
			$where .= "   and  pro.size_type_mm = '".$size_id."'";
		}
		if(!empty($pallet_type))
		{
			$where .= " and  type.pallet_type_id = '".$pallet_type."'";
		}
		if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		  
	 $qry = 'SELECT 
			mst.invoice_no, 
			MAX(pro_trn.description_goods) AS description_goods, 
			product.size_type_mm AS size, 
			MAX(cust.c_companyname) AS c_companyname, 
			model.model_name, 
			MAX(finish.finish_name) AS finish_name, 
			SUM(origanal_boxes) AS total_boxes, 
			SUM(pro_trn.sqm_per_box * origanal_boxes) AS total_sqm, 
			MAX(type.pallet_type_name) AS pallet_type_name 
		
		FROM `tbl_pi_loading_plan` AS `make` 
		INNER JOIN `tbl_production_mst` AS `pmst` ON `pmst`.`production_mst_id` = `make`.`production_mst_id` 
		INNER JOIN `tbl_performa_invoice` AS `mst` ON `make`.`performa_invoice_id` = `mst`.`performa_invoice_id` 
		INNER JOIN `customer_detail` AS `cust` ON `cust`.`id` = `mst`.`consigne_id` 
		INNER JOIN `tbl_product` AS `product` ON `product`.`product_id` = `make`.`product_id` 
		INNER JOIN `tbl_performa_packing` AS `packing` ON `packing`.`performa_packing_id` = `make`.`performa_packing_id` 
		INNER JOIN `tbl_performa_trn` AS `pro_trn` ON `packing`.`performa_trn_id` = `pro_trn`.`performa_trn_id` 
		INNER JOIN `tbl_product` AS `pro` ON `pro`.`product_id` = `pro_trn`.`product_id` 
		INNER JOIN `tbl_packing_model` AS `model` ON `model`.`packing_model_id` = `packing`.`design_id` 
		LEFT JOIN `tbl_finish` AS `finish` ON `finish`.`finish_id` = `packing`.`finish_id` 
		LEFT JOIN `tbl_performa_box_design` AS `box` ON `box`.`production_mst_id` = `make`.`production_mst_id` AND `pro`.`size_type_mm` = `box`.`size_type_mm` 
		LEFT JOIN `tbl_pallet_type` AS `type` ON `type`.`pallet_type_id` = `packing`.`pallet_type_id` 
		 
		WHERE mst.status = 0 
			AND pmst.production_status = 1
			
			' . $where . ' 
		
		GROUP BY mst.invoice_no, product.size_type_mm, model.model_name 
		ORDER BY mst.invoice_no ASC';
		
		 $q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
	public function get_ready_to_load($customer_id,$finish_id,$size_id,$pallet_type,$start_date,$end_date)
	{
		$where = ' and mst.performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consigne_id = ".$customer_id;
		}
		if(!empty($finish_id))
		{
			$where .= " and  packing.finish_id = ".$finish_id;
		} 
		 
		if(!empty($size_id))
		{
			$where .= "   and  pro.size_type_mm = '".$size_id."'";
		}
		if(!empty($pallet_type))
		{
			$where .= " and  type.pallet_type_id = '".$pallet_type."'";
		}
		
		 if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		 
		 $qry = 'SELECT 
			mst.invoice_no, 
			MAX(pro_trn.description_goods) AS description_goods, 
			product.size_type_mm AS size, 
			MAX(cust.c_companyname) AS c_companyname, 
			model.model_name, 
			MAX(finish.finish_name) AS finish_name, 
			SUM(origanal_boxes) AS total_boxes, 
			SUM(pro_trn.sqm_per_box * origanal_boxes) AS total_sqm, 
			MAX(type.pallet_type_name) AS pallet_type_name 
		
		FROM `tbl_pi_loading_plan` AS `make` 
		INNER JOIN `tbl_production_mst` AS `pmst` ON `pmst`.`production_mst_id` = `make`.`production_mst_id` 
		INNER JOIN `tbl_performa_invoice` AS `mst` ON `make`.`performa_invoice_id` = `mst`.`performa_invoice_id` 
		INNER JOIN `customer_detail` AS `cust` ON `cust`.`id` = `mst`.`consigne_id` 
		INNER JOIN `tbl_product` AS `product` ON `product`.`product_id` = `make`.`product_id` 
		INNER JOIN `tbl_performa_packing` AS `packing` ON `packing`.`performa_packing_id` = `make`.`performa_packing_id` 
		INNER JOIN `tbl_performa_trn` AS `pro_trn` ON `packing`.`performa_trn_id` = `pro_trn`.`performa_trn_id` 
		INNER JOIN `tbl_product` AS `pro` ON `pro`.`product_id` = `pro_trn`.`product_id` 
		INNER JOIN `tbl_packing_model` AS `model` ON `model`.`packing_model_id` = `packing`.`design_id` 
		LEFT JOIN `tbl_finish` AS `finish` ON `finish`.`finish_id` = `packing`.`finish_id` 
		LEFT JOIN `tbl_performa_box_design` AS `box` ON `box`.`production_mst_id` = `make`.`production_mst_id` AND `pro`.`size_type_mm` = `box`.`size_type_mm` 
		LEFT JOIN `tbl_pallet_type` AS `type` ON `type`.`pallet_type_id` = `packing`.`pallet_type_id` 
		 
		WHERE mst.status = 0 
			AND pmst.production_status != 0 
			AND pmst.qc_status != 0 
			AND pmst.pallet_status != 0 
			AND already_done = 1 ' . $where . ' 
		
		GROUP BY mst.invoice_no, product.size_type_mm, model.model_name 
		ORDER BY mst.invoice_no ASC';
$q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
	public function get_doc_pending($customer_id,$finish_id,$size_id,$pallet_type,$start_date,$end_date)
	{
		$where = ' and mst.performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consigne_id = ".$customer_id;
		}
		if(!empty($finish_id))
		{
			$where .= " and  packing.finish_id = ".$finish_id;
		} 
		 
		if(!empty($size_id))
		{
			$where .= "   and  pro.size_type_mm = '".$size_id."'";
		}
		if(!empty($pallet_type))
		{
			$where .= " and  type.pallet_type_id = '".$pallet_type."'";
		}
		 
		  if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		$qry = 'SELECT mst.invoice_no,pro_trn.description_goods,product.size_type_mm as size,cust.c_companyname,model.model_name,finish.finish_name,make.origanal_boxes,(pro_trn.sqm_per_box * make.origanal_boxes) as no_ofsqm,type.pallet_type_name  
		
		 FROM `tbl_export_loading_trn` as `make` 
		 INNER JOIN tbl_pi_loading_plan as pi_loading ON `pi_loading`.`pi_loading_plan_id` = `make`.`pi_loading_plan_id` 
		 INNER JOIN `tbl_performa_invoice` as `mst` ON `make`.`performa_invoice_id` = `mst`.`performa_invoice_id` 
		 INNER JOIN `tbl_export_invoice` as `emst` ON `emst`.`export_invoice_id` = `make`.`export_invoice_id` 
	 	 inner join customer_detail as cust on cust.id = mst.consigne_id 
		 inner join tbl_product as product on product.product_id = make.product_id 
		 inner JOIN `tbl_export_packing` as `packing` ON `packing`.`export_packing_id` = `make`.`export_packing_id` 
		 inner JOIN `tbl_exportproduct_trn` as `pro_trn` ON `packing`.`exportproduct_trn_id` = `pro_trn`.`exportproduct_trn_id` 
		 inner JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `pro_trn`.`product_id` 
		 inner JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 
		 left JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id` 
		 left JOIN `tbl_performa_packing` as `pi_packing` ON `pi_packing`.`performa_packing_id` = `pi_loading`.`performa_packing_id`  
		 left join tbl_pallet_type as type on type.pallet_type_id 	= pi_packing.pallet_type_id				 
		 
		 WHERE emst.status=0 and emst.step !=4 '.$where.' ORDER BY `make`.`con_entry` ASC';
		 $q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
	public function get_order_loaded($customer_id,$finish_id,$size_id,$pallet_type,$start_date,$end_date)
	{
		$where = ' and mst.performa_date BETWEEN "'.date('Y-m-d',strtotime($start_date)).'" and "'.date('Y-m-d',strtotime($end_date)).'"';
		if(!empty($customer_id))
		{
			$where .= " and  mst.consigne_id = ".$customer_id;
		}
		if(!empty($finish_id))
		{
			$where .= " and  packing.finish_id = ".$finish_id;
		} 
		 
		if(!empty($size_id))
		{
			$where .= "   and  pro.size_type_mm = '".$size_id."'";
		}
		if(!empty($pallet_type))
		{
			$where .= " and  type.pallet_type_id = '".$pallet_type."'";
		}
		 
		  if($this->session->usertype_id != 1)
		{
			$where .= " and find_in_set(mst.consigne_id,(SELECT GROUP_CONCAT(customer_id) FROM `tbl_user_wise_customer` where user_id = ".$this->session->id." and status =0))";
		}
		$qry = 'SELECT mst.invoice_no,pro_trn.description_goods,product.size_type_mm as size,cust.c_companyname,model.model_name,finish.finish_name,make.origanal_boxes,(pro_trn.sqm_per_box * make.origanal_boxes) as no_ofsqm,emst.export_invoice_no,
		
			type.pallet_type_name 
		
		 FROM `tbl_export_loading_trn` as `make` 
		 INNER JOIN tbl_pi_loading_plan as pi_loading ON `pi_loading`.`pi_loading_plan_id` = `make`.`pi_loading_plan_id` 
		 INNER JOIN `tbl_performa_invoice` as `mst` ON `make`.`performa_invoice_id` = `mst`.`performa_invoice_id` 
		 INNER JOIN `tbl_export_invoice` as `emst` ON `emst`.`export_invoice_id` = `make`.`export_invoice_id` 
	 	 inner join customer_detail as cust on cust.id = mst.consigne_id 
		 inner join tbl_product as product on product.product_id = make.product_id 
		 inner JOIN `tbl_export_packing` as `packing` ON `packing`.`export_packing_id` = `make`.`export_packing_id` 
		 inner JOIN `tbl_exportproduct_trn` as `pro_trn` ON `packing`.`exportproduct_trn_id` = `pro_trn`.`exportproduct_trn_id` 
		 inner JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `pro_trn`.`product_id` 
		 inner JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 
		 left JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id` 
		  left JOIN `tbl_performa_packing` as `pi_packing` ON `pi_packing`.`performa_packing_id` = `pi_loading`.`performa_packing_id`  
		 left join tbl_pallet_type as type on type.pallet_type_id 	= pi_packing.pallet_type_id				 
		
		 WHERE emst.status=0 and emst.step = 4 '.$where.' ORDER BY `make`.`con_entry` ASC';
		 $q_con = $this->db->query($qry);
			 
			 
		return $q_con->result();
	}
	public function outstanding_report()
	{
		 $q = "SELECT cust.c_companyname,cust.credit_days,currency.currency_name,currency.currency_code,datediff(CURRENT_DATE(), invoice_date) as days,grand_total,export_invoice_no,mst.export_invoice_id,mst.eta_date,mst.consiger_id,(select sum(paid_amount + bank_charge) from tbl_payment where status!=2  and bill_id = mst.export_invoice_id) as total_paid_amt, 
		 (select kasar_amt from tbl_kasar_amount where status!=2  and export_invoice_id = mst.export_invoice_id) as kasar_amt
		 from  tbl_export_invoice as mst 
		INNER JOIN customer_detail as cust ON cust.id = mst.consiger_id
		INNER JOIN tbl_currency as currency ON currency.currency_id = mst.invoice_currency_id
		where mst.step=4 and mst.status=0 order by days desc";
		$q_con = $this->db->query($q);
		return $q_con->result();
	}
	
	public function outstanding_report1() { 
    $q = "SELECT 
            cust.c_companyname,
            cust.credit_days,
            currency.currency_name,
            currency.currency_code,
            DATEDIFF(CURRENT_DATE(), mst.invoice_date) AS days, 
            mst.grand_total,
            mst.export_invoice_no,
            mst.export_invoice_id,
            cust_invoice.eta_date, 
            mst.consiger_id,
            (SELECT SUM(paid_amount + bank_charge) 
             FROM tbl_payment 
             WHERE status != 2 AND bill_id = mst.export_invoice_id) AS total_paid_amt,
            (SELECT kasar_amt 
             FROM tbl_kasar_amount 
             WHERE status != 2 AND export_invoice_id = mst.export_invoice_id) AS kasar_amt 
          FROM tbl_export_invoice AS mst  
          INNER JOIN customer_detail AS cust ON cust.id = mst.consiger_id  
          INNER JOIN tbl_currency AS currency ON currency.currency_id = mst.invoice_currency_id  
          LEFT JOIN tbl_customer_invoice AS cust_invoice ON cust_invoice.export_invoice_id = mst.export_invoice_id  
          WHERE mst.step = 4 AND mst.status = 0  
          ORDER BY days DESC";
    
    $q_con = $this->db->query($q); 
    return $q_con->result(); 
}

 

	public function factory_outstanding_report()
	{
		 $q = "SELECT party.expense_party_id,party.party_name,datediff(CURRENT_DATE(), expense_date) as days,total_amt,
		 (select sum(paid_amount + kasar_amount) from  tbl_expense_payment_trn where status!=2  and expense_id = mst.expense_id) as total_paid_amt,party.credit_days 
		 from  tbl_expense as mst 
		INNER JOIN tbl_expense_party as party ON party.expense_party_id = mst.expense_party_id
		where mst.expense_category_id=12 and mst.status!=2 order by days desc";
		$q_con = $this->db->query($q);
		return $q_con->result();
	}
	public function expense_outstanding_report()
	{
		 $q = "SELECT party.expense_party_id,party.party_name,datediff(CURRENT_DATE(), expense_date) as days,total_amt,(select sum(paid_amount + kasar_amount + tds_amount) from  tbl_expense_payment_trn where status!=2  and expense_id = mst.expense_id) as total_paid_amt,party.credit_days  from  tbl_expense as mst 
		INNER JOIN tbl_expense_party as party ON party.expense_party_id = mst.expense_party_id
		where mst.expense_category_id != 12 and mst.status!=2 order by days desc";
		$q_con = $this->db->query($q);
		return $q_con->result();
	} 
	public function drawback_pending()
	{
		$q = "SELECT mst.id,invoice.export_invoice_no,mst.drawback_amount  from upload_shiping_bill as mst 
		 INNER JOIN  tbl_export_invoice  as invoice  ON invoice.export_invoice_id = mst.export_invoice_id
		where invoice.step=4 and invoice.status=0 and payment_of_drawback =''";
		$q_con = $this->db->query($q);
		return $q_con->result();
	}
}

?>