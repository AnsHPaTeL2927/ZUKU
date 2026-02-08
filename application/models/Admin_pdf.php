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

		  $q = 'SELECT mst.*,trn.performa_packing_id,trn.pro_batch,trn.pro_shade, trn.production_mst_id, pmst.supplier_id,sup.company_name,packing.performa_trn_id, ptrn.pallet_status,ptrn.sqm_per_box,ptrn.boxes_per_pallet, ptrn.box_per_big_pallet,ptrn.box_per_small_pallet,big_pallet_weight,small_pallet_weight,	(SELECT COUNT(container_no) from tbl_autometic_loading_plan where status =0 and container_no = mst.container_no and  performa_invoice_id = '.$id.' and status =0 GROUP By container_no) as total_con

			FROM `tbl_autometic_loading_plan` as mst 

			inner join tbl_production_trn as trn on trn.production_trn_id = mst.production_trn_id

			inner join tbl_production_mst as pmst on pmst.production_mst_id = trn.production_mst_id

			inner join tbl_performa_packing as packing on packing.performa_packing_id = trn.performa_packing_id

			inner join tbl_performa_trn as ptrn on ptrn.performa_trn_id = packing.performa_trn_id

			inner join tbl_supplier as sup on pmst.supplier_id = sup.supplier_id

			where  mst.performa_invoice_id = '.$id.$where.' and mst.status = 0 and trn.production_done = 2 order by container_no asc';  

		$q_con = $this->db->query($q);

		return $q_con->result();

	} 


		// public function get_auto_loading_plan($id,$check,$notauto)
// {
    // $where = ' and full_status = 1 ';
    // if ($notauto == 0) { $where = ''; }

    // $q = 'SELECT mst.*,
                 // trn.performa_packing_id,
                 // trn.production_mst_id,
                 // pmst.supplier_id,
                 // sup.company_name,
                 // packing.performa_trn_id,
                 // ptrn.pallet_status,
                 // ptrn.sqm_per_box,
                 // ptrn.boxes_per_pallet,
                 // ptrn.box_per_big_pallet,
                 // ptrn.box_per_small_pallet,
                 // ptrn.big_pallet_weight,
                 // ptrn.small_pallet_weight,
                 // palletbox.finalbatch,
                 // palletbox.finalshade,
                 // palletbox.boxcal,
                 // palletbox.boxcalpallet,
                 // palletbox.boxcalbigpallet,
                 // palletbox.boxcalsmallpallet,
                 // palletbox.total_available_box,
                 // palletbox.total_input_boxes,
                 // palletbox.total_input_pallets,
                 // palletbox.remainbox,
                 // palletbox.remainpallets,
                 // palletbox.remainbigpallets,
                 // palletbox.remainsmalpallets,
                 // palletbox.total_input_big_pallets,
                 // palletbox.total_input_small_pallets,
                 // (SELECT COUNT(container_no)
                    // FROM tbl_autometic_loading_plan
                    // WHERE status = 0
                      // AND container_no = mst.container_no
                      // AND performa_invoice_id = '.$id.'
                    // GROUP BY container_no) AS total_con
          // FROM tbl_autometic_loading_plan AS mst
          // INNER JOIN tbl_production_trn AS trn
                  // ON trn.production_trn_id = mst.production_trn_id
          // INNER JOIN tbl_production_mst AS pmst
                  // ON pmst.production_mst_id = trn.production_mst_id
          // INNER JOIN tbl_performa_packing AS packing
                  // ON packing.performa_packing_id = trn.performa_packing_id
          // INNER JOIN tbl_performa_trn AS ptrn
                  // ON ptrn.performa_trn_id = packing.performa_trn_id
          // INNER JOIN tbl_supplier AS sup
                  // ON pmst.supplier_id = sup.supplier_id
         // LEFT JOIN (
    // SELECT p.production_trn_id,
           // MAX(p.available_box)                   AS total_available_box,
           // SUM(p.input_boxes * (p.input_pallets + p.input_big_pallets + p.input_small_pallets)) AS total_input_boxes,
           // SUM(p.input_pallets)                   AS total_input_pallets,
           // p.batchno                   AS finalbatch,
           // p.shadeno                   AS finalshade,
           // p.input_boxes                   AS boxcal,
           // p.input_pallets                 AS boxcalpallet,
           // p.input_big_pallets             AS boxcalbigpallet,
           // p.input_small_pallets           AS boxcalsmallpallet,
           // SUM(p.input_big_pallets)         AS total_input_big_pallets,
           // SUM(p.input_small_pallets)       AS total_input_small_pallets,
           // GREATEST(0, COALESCE(MAX(p.available_box),0) - SUM(p.input_boxes)) AS remainbox,
           // GREATEST(0, MAX(p.available_pallets) - SUM(p.input_pallets))       AS remainpallets,
           // GREATEST(0, COALESCE(NULLIF(MAX(p.available_big_pallets),0), MAX(p.available_pallets)) - SUM(p.input_big_pallets))  AS remainbigpallets,
           // GREATEST(0, COALESCE(NULLIF(MAX(p.available_small_pallets),0), MAX(p.available_pallets)) - SUM(p.input_small_pallets)) AS remainsmalpallets
    // FROM tbl_pallet_box_entry AS p
    // GROUP BY p.production_trn_id
// ) AS palletbox
// ON palletbox.production_trn_id = trn.production_trn_id

          // WHERE mst.performa_invoice_id = '.$id.$where.'
            // AND mst.status = 0
		// AND pmst.production_status = 1
          // AND pmst.qc_status = 1
          // AND pmst.pallet_status = 1
          // ORDER BY container_no ASC';

    // $q_con = $this->db->query($q);
    // return $q_con->result();
// }

	// public function get_auto_loading_plan($id,$check,$notauto)

	// {

		// $where =' and full_status = 1 ';

		 // if($notauto == 0)

		 // {

			 // $where ='';

		 // }

		  // $q = 'SELECT mst.*,trn.performa_packing_id, trn.production_mst_id, pmst.supplier_id,sup.company_name,packing.performa_trn_id, ptrn.pallet_status,ptrn.sqm_per_box,ptrn.boxes_per_pallet, ptrn.box_per_big_pallet,ptrn.box_per_small_pallet,big_pallet_weight,small_pallet_weight,	(SELECT COUNT(container_no) from tbl_autometic_loading_plan where status =0 and container_no = mst.container_no and  performa_invoice_id = '.$id.' and status =0 GROUP By container_no) as total_con

			// FROM `tbl_autometic_loading_plan` as mst 

			// inner join tbl_production_trn as trn on trn.production_trn_id = mst.production_trn_id

			// inner join tbl_production_mst as pmst on pmst.production_mst_id = trn.production_mst_id

			// inner join tbl_performa_packing as packing on packing.performa_packing_id = trn.performa_packing_id

			// inner join tbl_performa_trn as ptrn on ptrn.performa_trn_id = packing.performa_trn_id

			// inner join tbl_supplier as sup on pmst.supplier_id = sup.supplier_id

			// where  mst.performa_invoice_id = '.$id.$where.' and mst.status =0 order by container_no asc';  

		// $q_con = $this->db->query($q);

		// return $q_con->result();

	// } 

	

	public function select_invoice_data($id)

	{

		$q = $this->db->select('invoice.*, consign_detail.note as cd_note,consign.c_name,consign.c_companyname,cur.currency_name,cur.currency_code,cur.currency_id,term.terms_name,additional.*,fum.fumigation_name,cap.pallet_cap_name,user.sign_pi_status,user.for_signature_name,user.sign_image,user.authorised_signatury,user.contact_person_name,user.contact_no,user.contact_email,supplier.remarks_sheet,

		(select sum(container) from tbl_pi_loading_plan where performa_invoice_id = '.$id.' and export_done_status = 1 and updated_net_weight != "") as export_done_con

		')

	

			->from('tbl_performa_invoice as invoice')

			->join('tbl_performa_additional_detail as additional', 'additional.performa_id = invoice.performa_invoice_id', 'LEFT')

			->join('customer_detail as consign', 'invoice.consigne_id = consign.id', 'LEFT')
			
			->join('tbl_customer_add_detail as consign_detail', 'consign_detail.customer_id = consign.id', 'LEFT')

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

			$q = $this->db->select('mst.*,  pro.size_type_mm, pro.size_type_cm, detail.p_name, detail.hsnc_code, series.series_name,pro.size_width_mm,pro.size_height_mm,size.product_packing_name, 

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
	
public function product_data11($id)
{
     $q = $this->db->select('
            mst.*,  
            pro.size_type_mm, pro.size_type_cm, detail.p_name, detail.hsnc_code, 
            series.series_name, pro.size_width_mm, pro.size_height_mm, pro.thickness,
            size.product_packing_name, size.box_per_container, size.total_pallent_container,
            size.no_big_plt_container_new, size.no_small_plt_container_new,
            size.multi_box_per_container, size.total_boxes
        ')
        ->from('tbl_performa_trn as mst')
        ->join('tbl_product as pro', 'pro.product_id = mst.product_id', 'LEFT')
        ->join('tbl_series as series', 'series.series_id = pro.series_id', 'LEFT')
        ->join('product_code_detail as detail', 'detail.hsnc_code = series.hsnc_code', 'LEFT')
        ->join('tbl_product_size as size','size.product_size_id=mst.product_size_id','LEFT')
        ->where('mst.invoice_id',$id)
        ->where('mst.extra_loading',0)
        ->order_by('mst.extra_product','asc')
        ->order_by('mst.seq','asc')
        ->get();

    $return = [];
    $i = 0;

    foreach ($q->result() as $category) {
        $packing_rows = $this->get_packing11($category->performa_trn_id);

        // filter out rows with no pending
        $pending_packings = array_filter($packing_rows, function($p) {
            return $p->pending_boxes > 0;
        });

        if (!empty($pending_packings)) {
            $category->packing = $pending_packings;
            $return[$i] = $category;
            $i++;
        }
    }

    return $return;
}

public function get_packing11($id)
{
    $q = "
        SELECT 
            mst.*,
            model.model_name, model.design_file, model.no_of_randome,
            design.box_design_name, design.box_design_img,
            finish.finish_name, finish.finish_id,
            type.pallet_type_name,
            model.field1, model.field2,
			
            -- loaded & pending boxes
            IFNULL(SUM(lp.origanal_boxes),0) as loaded_boxes,
            (mst.no_of_boxes - IFNULL(SUM(lp.origanal_boxes),0)) as pending_boxes,

            -- pending pallets
            CASE 
                WHEN mst.no_of_pallet > 0 
                THEN (mst.no_of_pallet - IFNULL(SUM(lp.origanal_pallet),0)) 
                ELSE 0
            END as pending_pallets,
			
			 -- pending big pallets
            CASE 
                WHEN mst.no_of_big_pallet > 0 
                THEN (mst.no_of_big_pallet - IFNULL(SUM(lp.orginal_no_of_big_pallet),0)) 
                ELSE 0
            END as pending_big_pallets,

            -- pending small pallets
            CASE 
                WHEN mst.no_of_small_pallet > 0 
                THEN (mst.no_of_small_pallet - IFNULL(SUM(lp.orginal_no_of_small_pallet),0)) 
                ELSE 0
            END as pending_small_pallets,
			

            -- pending sqm (assuming mst.sqm_per_box or mst.sqm_per_box)
            CASE 
                WHEN mst.no_of_sqm > 0
                THEN (mst.no_of_sqm - IFNULL(SUM(lp.origanal_sqm),0)) 
                ELSE 0
            END as pending_sqm
        FROM tbl_performa_packing as mst
        LEFT JOIN tbl_packing_model as model ON model.packing_model_id = mst.design_id
        LEFT JOIN tbl_finish as finish ON finish.finish_id = mst.finish_id
        LEFT JOIN tbl_pallet_type as type ON type.pallet_type_id = mst.pallet_type_id
        LEFT JOIN tbl_box_design as design ON design.box_design_id = mst.box_design_id
        LEFT JOIN tbl_pi_loading_plan as lp ON lp.performa_packing_id = mst.performa_packing_id
        WHERE mst.performa_trn_id = '".$id."'
          AND IF(mst.design_id > 0, mst.no_of_boxes > 0, mst.design_id = 0)
        GROUP BY mst.performa_packing_id
    ";
    $q_con = $this->db->query($q);
    return $q_con->result();
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
public function remain_data_detail($performa_invoice_id, $val, $supplier_id, $export_time)
{
    $where = '';
    $where1 = '';

    if ($val == 1) {
        $where = ' and mst.already_done = 1';
    }

    if ($val == 3) {
        $where = ' and mst.export_done_status = 1';
    }

    if (!empty($supplier_id)) {
        $where  .= ' and mst.supplier_id = ' . $supplier_id;
        $where1 .= ' and supplier_id = ' . $supplier_id;
    }

    if (!empty($export_time)) {
        $where  .= ' and mst.export_time = ' . $export_time;
        $where1 .= ' and export_time = ' . $export_time;
    }

    $sql_qry = '
        SELECT 
            mst.export_done_status,
            mst.export_time,
            export.export_invoice_no,
            mst.con_entry,
            mst.performa_invoice_id,

            -- total container already planned
            (
                SELECT SUM(inner_query.container) 
                FROM (
                    SELECT container, supplier_id, export_time, performa_invoice_id 
                    FROM tbl_pi_loading_plan 
                    WHERE performa_invoice_id = ' . $performa_invoice_id . $where1 . ' 
                    GROUP BY con_entry, supplier_id
                ) AS inner_query 
                WHERE performa_invoice_id = ' . $performa_invoice_id . $where1 . ' 
                  AND supplier_id = mst.supplier_id 
                  AND export_time = mst.export_time   
                GROUP BY inner_query.supplier_id
            ) as total_con,

            -- container_details from PI
            pi.container_details,

            -- pending calculation
            (pi.container_details - 
                COALESCE((
                    SELECT SUM(inner_query.container) 
                    FROM (
                        SELECT container, supplier_id, export_time, performa_invoice_id 
                        FROM tbl_pi_loading_plan 
                        WHERE performa_invoice_id = ' . $performa_invoice_id . $where1 . ' 
                        GROUP BY con_entry, supplier_id
                    ) AS inner_query 
                    WHERE performa_invoice_id = ' . $performa_invoice_id . $where1 . ' 
                      AND supplier_id = mst.supplier_id 
                      AND export_time = mst.export_time   
                    GROUP BY inner_query.supplier_id
                ),0)
            ) AS pending,

            sup.company_name,
            mst.supplier_id

        FROM tbl_pi_loading_plan as mst 
        INNER JOIN tbl_supplier as sup 
            ON sup.supplier_id = mst.supplier_id 
        LEFT JOIN tbl_export_invoice as export 
            ON export.export_invoice_id = mst.export_time 
        INNER JOIN tbl_performa_invoice as pi 
            ON pi.performa_invoice_id = mst.performa_invoice_id  

        WHERE mst.performa_invoice_id = ' . $performa_invoice_id . $where . ' 
        GROUP BY mst.supplier_id, mst.export_time
        HAVING pending > 0
    ';

    $q_con = $this->db->query($sql_qry);
    return $q_con->result();
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

public function loading_data_pending($performa_invoice_id, $supplier_id, $export_time)
{
    $q = $this->db->select('
                make.*,
                mst.*,
                packing.*,
                model.model_name,
                model.design_file,
                finish.finish_name, 
                pro.size_type_mm, 
                pro.size_type_cm,
                pro.size_width_mm, 
                pro.size_height_mm,
                p_trn.location,
                sup.company_name,

                -- total containers assigned for this PI
                (SELECT container_details 
                   FROM tbl_performa_invoice 
                  WHERE performa_invoice_id = '.$performa_invoice_id.') as total_containers,

                (SELECT COUNT(DISTINCT con_entry) 
                   FROM tbl_pi_loading_plan 
                  WHERE performa_invoice_id = '.$performa_invoice_id.') as used_containers,

                -- containers left
                ((SELECT container_details 
                    FROM tbl_performa_invoice 
                   WHERE performa_invoice_id = '.$performa_invoice_id.')
                 - 
                 (SELECT COUNT(DISTINCT con_entry) 
                    FROM tbl_pi_loading_plan 
                   WHERE performa_invoice_id = '.$performa_invoice_id.')
                ) as remaining_containers,

                -- already loaded qty
                (SELECT IFNULL(SUM(origanal_boxes),0) 
                   FROM tbl_pi_loading_plan 
                  WHERE performa_invoice_id = '.$performa_invoice_id.' 
                    AND mst.performa_trn_id = make.performa_trn_id) as loaded_boxes,

                (SELECT IFNULL(SUM(origanal_pallet),0) 
                   FROM tbl_pi_loading_plan 
                  WHERE performa_invoice_id = '.$performa_invoice_id.' 
                    AND mst.performa_trn_id = make.performa_trn_id) as loaded_pallets,

                (SELECT IFNULL(SUM(orginal_no_of_big_pallet),0) 
                   FROM tbl_pi_loading_plan 
                  WHERE performa_invoice_id = '.$performa_invoice_id.' 
                    AND mst.performa_trn_id = make.performa_trn_id) as loaded_big_pallets,

                (SELECT IFNULL(SUM(orginal_no_of_small_pallet),0) 
                   FROM tbl_pi_loading_plan 
                  WHERE performa_invoice_id = '.$performa_invoice_id.' 
                    AND mst.performa_trn_id = make.performa_trn_id) as loaded_small_pallets,

                -- pending compared with performa_trn
                (mst.total_no_of_boxes - 
                   (SELECT IFNULL(SUM(origanal_boxes),0) 
                      FROM tbl_pi_loading_plan 
                     WHERE performa_invoice_id = '.$performa_invoice_id.' 
                       AND mst.performa_trn_id = make.performa_trn_id)
                ) as pending_boxes,

                (mst.total_no_of_pallet - 
                   (SELECT IFNULL(SUM(origanal_pallet),0) 
                      FROM tbl_pi_loading_plan 
                     WHERE performa_invoice_id = '.$performa_invoice_id.' 
                       AND mst.performa_trn_id = make.performa_trn_id)
                ) as pending_pallets,

                (mst.box_per_big_pallet - 
                   (SELECT IFNULL(SUM(orginal_no_of_big_pallet),0) 
                      FROM tbl_pi_loading_plan 
                     WHERE performa_invoice_id = '.$performa_invoice_id.' 
                       AND mst.performa_trn_id = make.performa_trn_id)
                ) as pending_big_pallets,

                (mst.box_per_small_pallet - 
                   (SELECT IFNULL(SUM(orginal_no_of_small_pallet),0) 
                      FROM tbl_pi_loading_plan 
                     WHERE performa_invoice_id = '.$performa_invoice_id.' 
                       AND mst.performa_trn_id = make.performa_trn_id)
                ) as pending_small_pallets
            ')
            ->from('tbl_pi_loading_plan as make')
            ->join('tbl_performa_packing as packing','packing.performa_packing_id = make.performa_packing_id','LEFT')
            ->join('tbl_performa_trn as mst','packing.performa_trn_id = mst.performa_trn_id','LEFT')
            ->join('tbl_production_trn as p_trn','p_trn.production_trn_id = make.production_trn_id','LEFT')
            ->join('tbl_product as pro','pro.product_id = mst.product_id','LEFT')
            ->join('tbl_packing_model as model','model.packing_model_id = packing.design_id','LEFT')
            ->join('tbl_finish as finish','finish.finish_id = packing.finish_id','LEFT')
            ->join('tbl_supplier as sup','sup.supplier_id = make.supplier_id','LEFT')
            ->where('make.performa_invoice_id', $performa_invoice_id)
            ->where('make.supplier_id', $supplier_id)
            ->where('make.export_time', $export_time)
            ->order_by('make.con_entry','asc')
            ->get();

    return $q->result();
}


public function loading_data($performa_invoice_id,$supplier_id,$export_time)

	{

			$q = $this->db->select('make.*,mst.*,packing.*,model.model_name,model.design_file,finish.finish_name, pro.size_type_mm, pro.size_type_cm,pro.size_width_mm,pro.size_height_mm,p_trn.location,p_trn.boxes_per_pallet as trnboxes_per_pallet,p_trn.box_per_big_pallet as trnbox_per_big_pallet,p_trn.box_per_small_pallet as trnbox_per_small_pallet,

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
				
			 	->join('tbl_production_trn as p_trn','p_trn.production_trn_id  = make.production_trn_id ', 'LEFT')

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
    $q = '
        SELECT 
            mst.*, 
            model.model_name, 
            model.design_file, 
            finish.finish_name, 
            finish.field1 AS collection, 
            finish.finish_id, 
            model.no_of_randome, 
            design.box_design_name, 
            design.box_design_img, 
            type.pallet_type_name, 
            model.field1, 
            model.field2 
        FROM tbl_performa_packing AS mst 
        LEFT JOIN tbl_packing_model AS model ON model.packing_model_id = mst.design_id 
        LEFT JOIN tbl_finish AS finish ON finish.finish_id = mst.finish_id 
        LEFT JOIN tbl_pallet_type AS type ON type.pallet_type_id = mst.pallet_type_id 
        LEFT JOIN tbl_box_design AS design ON design.box_design_id = mst.box_design_id 
        WHERE mst.performa_trn_id = "'.$id.'" 
        AND IF(mst.design_id > 0, mst.no_of_boxes > 0, mst.design_id = 0)
    ';

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

	public function update_on_the_way_details($performa_invoice_id,$data)

	{

		$this->db->where('performa_invoice_id',$performa_invoice_id);

		$q = $this->db->update('tbl_pi_loading_plan',$data);

		 

		return $q;

	}

	public function insert_warehouse_inventory($data)
	{
		$this->db->insert('tbl_warehouse_inventory', $data);
		return $this->db->insert_id();
	}

	/**
	 * Transfer stock from one warehouse to another.
	 * @param int $performa_invoice_id
	 * @param int $design_id
	 * @param int $from_warehouse_id
	 * @param int $to_warehouse_id
	 * @param float $transfer_quantity_boxes quantity in boxes to transfer
	 * @return array ['success' => bool, 'msg' => string]
	 */
	public function transfer_warehouse_stock($performa_invoice_id, $design_id, $from_warehouse_id, $to_warehouse_id, $transfer_quantity_boxes)
	{
		if (!$this->db->table_exists('tbl_warehouse_inventory')) {
			return array('success' => false, 'msg' => 'Warehouse inventory table not found.');
		}
		if ($from_warehouse_id <= 0 || $to_warehouse_id <= 0 || $from_warehouse_id == $to_warehouse_id) {
			return array('success' => false, 'msg' => 'Invalid warehouse selection.');
		}
		if ($transfer_quantity_boxes <= 0) {
			return array('success' => false, 'msg' => 'Transfer quantity must be greater than 0.');
		}
		$transfer_quantity_boxes = (float) $transfer_quantity_boxes;
		$this->db->select_sum('quantity');
		$this->db->from('tbl_warehouse_inventory inv');
		$this->db->join('tbl_performa_invoice pi', 'pi.performa_invoice_id = inv.performa_invoice_id');
		$this->db->where('inv.performa_invoice_id', (int) $performa_invoice_id);
		$this->db->where('inv.design_id', (int) $design_id);
		$this->db->where('inv.warehouse_id', (int) $from_warehouse_id);
		$this->db->where('pi.status', 0);
		$q = $this->db->get();
		$row = $q ? $q->row() : null;
		$available = $row && isset($row->quantity) ? (float) $row->quantity : 0;
		if ($available < $transfer_quantity_boxes) {
			return array('success' => false, 'msg' => 'Insufficient stock. Available: ' . $available . ' boxes.');
		}
		$this->db->trans_start();
		$remaining = $transfer_quantity_boxes;
		$this->db->select('inv.id, inv.quantity, inv.pi_loading_plan_id');
		$this->db->from('tbl_warehouse_inventory inv');
		$this->db->join('tbl_performa_invoice pi', 'pi.performa_invoice_id = inv.performa_invoice_id');
		$this->db->where('inv.performa_invoice_id', (int) $performa_invoice_id);
		$this->db->where('inv.design_id', (int) $design_id);
		$this->db->where('inv.warehouse_id', (int) $from_warehouse_id);
		$this->db->where('pi.status', 0);
		$this->db->order_by('inv.id', 'ASC');
		$rows = $this->db->get()->result();
		$pi_loading_plan_id = !empty($rows[0]) && isset($rows[0]->pi_loading_plan_id) ? $rows[0]->pi_loading_plan_id : NULL;
		foreach ($rows as $r) {
			if ($remaining <= 0) break;
			$deduct = min((float) $r->quantity, $remaining);
			$this->db->set('quantity', 'quantity - ' . (float) $deduct, FALSE);
			$this->db->set('updated_at', date('Y-m-d H:i:s'));
			$this->db->where('id', (int) $r->id);
			$this->db->update('tbl_warehouse_inventory');
			$remaining -= $deduct;
		}
		$this->db->select('id, pi_loading_plan_id');
		$this->db->from('tbl_warehouse_inventory inv');
		$this->db->where('inv.performa_invoice_id', (int) $performa_invoice_id);
		$this->db->where('inv.design_id', (int) $design_id);
		$this->db->where('inv.warehouse_id', (int) $to_warehouse_id);
		$existing = $this->db->get()->row();
		if ($existing) {
			$this->db->set('quantity', 'quantity + ' . (float) $transfer_quantity_boxes, FALSE);
			$this->db->set('updated_at', date('Y-m-d H:i:s'));
			$this->db->where('id', (int) $existing->id);
			$this->db->update('tbl_warehouse_inventory');
		} else {
			$this->db->insert('tbl_warehouse_inventory', array(
				'performa_invoice_id' => (int) $performa_invoice_id,
				'pi_loading_plan_id' => $pi_loading_plan_id,
				'design_id' => (int) $design_id,
				'warehouse_id' => (int) $to_warehouse_id,
				'quantity' => $transfer_quantity_boxes,
				'notes' => 'Transferred from warehouse ' . (int) $from_warehouse_id,
				'created_by' => isset($this->session->id) ? $this->session->id : NULL,
				'created_at' => date('Y-m-d H:i:s'),
				'updated_at' => date('Y-m-d H:i:s'),
			));
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
			return array('success' => false, 'msg' => 'Transfer failed. Please try again.');
		}
		return array('success' => true, 'msg' => 'Stock transferred successfully.');
	}

	/**
	 * Record that a PI was added to stock (when "Add to Inventory" is triggered).
	 * @param array $data keys: performa_invoice_id, added_at, added_by, notes (optional)
	 * @return int|bool insert_id or false
	 */
	public function insert_pi_stock_entry($data)
	{
		if (empty($data['performa_invoice_id'])) {
			return false;
		}
		$this->db->insert('tbl_pi_stock_entry', $data);
		return $this->db->insert_id();
	}

	/**
	 * Get all warehouses for Location filter (Stock page).
	 * @return array of objects with id, name, warehouse_number
	 */
	public function get_warehouses_for_stock_filter()
	{
		if (!$this->db->table_exists('tbl_warehouse_master')) {
			return array();
		}
		$this->db->select('id, name, warehouse_number');
		$this->db->from('tbl_warehouse_master');
		$this->db->order_by('name', 'ASC');
		$query = $this->db->get();
		return $query ? $query->result() : array();
	}

	/**
	 * Get warehouses that have inventory (for dynamic columns).
	 * Uses DISTINCT warehouse_id from tbl_warehouse_inventory to ensure we always match actual data.
	 * LEFT JOINs to tbl_warehouse_master for names (handles deleted warehouses).
	 * When no inventory exists, returns default Warehouse 01/02/03 for tbl_stock_calculation fallback.
	 */
	public function get_warehouses_with_stock()
	{
		if (!$this->db->table_exists('tbl_warehouse_inventory')) {
			return $this->get_default_stock_warehouses();
		}
		$sql = "
			SELECT DISTINCT inv.warehouse_id AS id,
				COALESCE(NULLIF(TRIM(wm.name), ''), CONCAT('Warehouse ', inv.warehouse_id)) AS name,
				COALESCE(wm.warehouse_number, inv.warehouse_id) AS warehouse_number
			FROM tbl_warehouse_inventory inv
			INNER JOIN tbl_performa_invoice pi ON pi.performa_invoice_id = inv.performa_invoice_id
			LEFT JOIN tbl_warehouse_master wm ON wm.id = inv.warehouse_id
			WHERE pi.status = 0
			ORDER BY inv.warehouse_id ASC
		";
		$query = $this->db->query($sql);
		$with_stock = $query ? $query->result() : array();
		if (!empty($with_stock)) {
			return $with_stock;
		}
		return $this->get_default_stock_warehouses();
	}

	/**
	 * Default warehouse structure for stock display (Warehouse 01, 02, 03).
	 */
	private function get_default_stock_warehouses()
	{
		return array(
			(object) array('id' => 1, 'name' => 'Warehouse 01', 'warehouse_number' => '1'),
			(object) array('id' => 2, 'name' => 'Warehouse 02', 'warehouse_number' => '2'),
			(object) array('id' => 3, 'name' => 'Warehouse 03', 'warehouse_number' => '3'),
		);
	}

	/**
	 * Get distinct PI numbers (invoice_no) that have entries in stock.
	 * Uses tbl_warehouse_inventory first, falls back to tbl_stock_calculation.
	 * Used to populate the PI NO. filter dropdown on Stock page.
	 */
	public function get_stock_pi_numbers()
	{
		$result = array();
		if ($this->db->table_exists('tbl_warehouse_inventory')) {
			$this->db->select('pi.invoice_no, inv.performa_invoice_id');
			$this->db->from('tbl_warehouse_inventory inv');
			$this->db->join('tbl_performa_invoice pi', 'pi.performa_invoice_id = inv.performa_invoice_id');
			$this->db->where('pi.status', 0);
			$this->db->group_by('inv.performa_invoice_id, pi.invoice_no');
			$this->db->order_by('pi.invoice_no', 'ASC');
			$query = $this->db->get();
			$result = $query ? $query->result() : array();
		}
		if (empty($result) && $this->db->table_exists('tbl_stock_calculation')) {
			$this->db->select('pi.invoice_no, sc.performa_invoice_id');
			$this->db->from('tbl_stock_calculation sc');
			$this->db->join('tbl_performa_invoice pi', 'pi.performa_invoice_id = sc.performa_invoice_id');
			$this->db->where('pi.status', 0);
			$this->db->group_by('sc.performa_invoice_id, pi.invoice_no');
			$this->db->order_by('pi.invoice_no', 'ASC');
			$query = $this->db->get();
			$result = $query ? $query->result() : array();
		}
		return $result;
	}

	/**
	 * Get stock list for Stock module: entries from Add to Inventory (tbl_warehouse_inventory).
	 * Falls back to tbl_stock_calculation if warehouse inventory is empty.
	 * Returns one row per (PI, design) with warehouse quantities and design/PI info.
	 * @param string|null $invoice_no optional – filter by PI invoice number (e.g. PI-380/2025-26)
	 * @param int|null $warehouse_id optional – filter to show only entries for this warehouse
	 * @return array stock rows with dynamic wh_{id} columns per warehouse
	 */
	public function get_stock_list($invoice_no = null, $warehouse_id = null)
	{
		$result = array();
		$warehouses = $this->get_warehouses_with_stock();

		// Primary source: tbl_warehouse_inventory (from Add to Inventory)
		if ($this->db->table_exists('tbl_warehouse_inventory')) {
			$where_invoice = '';
			if ($invoice_no !== null && $invoice_no !== '') {
				$invoice_no_esc = $this->db->escape($invoice_no);
				$where_invoice = " AND pi.invoice_no = " . $invoice_no_esc;
			}
			$where_warehouse = '';
			if ($warehouse_id !== null && $warehouse_id !== '') {
				$wh_id = (int) $warehouse_id;
				$where_warehouse = " AND inv.warehouse_id = " . $wh_id;
			}
			$wh_columns = '';
			foreach ($warehouses as $wh) {
				$wid = (int) $wh->id;
				$col = 'wh_' . $wid;
				$wh_columns .= ", SUM(CASE WHEN inv.warehouse_id = " . $wid . " THEN inv.quantity * COALESCE(sqm_data.sqm_per_box, 0) ELSE 0 END) AS " . $col;
			}
			if ($wh_columns === '') {
				$wh_columns = ", SUM(inv.quantity * COALESCE(sqm_data.sqm_per_box, 0)) AS wh_total";
			}
			$having = '';
			if ($warehouse_id !== null && $warehouse_id !== '') {
				$wh_id = (int) $warehouse_id;
				$having = " HAVING SUM(CASE WHEN inv.warehouse_id = " . $wh_id . " THEN inv.quantity * COALESCE(sqm_data.sqm_per_box, 0) ELSE 0 END) > 0";
			}
			$sales_calc_join = '';
			$sales_calc_select = ', 0 AS total_sales_6m_sqm, 20 AS safety_stock_days';
			if ($this->db->table_exists('tbl_stock_calculation')) {
				$sales_calc_join = ' LEFT JOIN tbl_stock_calculation AS sales_calc ON sales_calc.performa_invoice_id = inv.performa_invoice_id AND sales_calc.design_id = inv.design_id';
				$sales_calc_select = ', COALESCE(MAX(sales_calc.total_sales_6m_sqm), 0) AS total_sales_6m_sqm, COALESCE(MAX(sales_calc.safety_stock_days), 20) AS safety_stock_days';
			}
			$sql = "
				SELECT
					inv.performa_invoice_id,
					inv.design_id,
					pi.invoice_no,
					pi.performa_date,
					pm.model_name AS design_name,
					(
						SELECT COALESCE(pr.size_type_mm, '')
						FROM tbl_performa_packing pp2
						INNER JOIN tbl_performa_trn pt ON pt.performa_trn_id = pp2.performa_trn_id AND pt.invoice_id = inv.performa_invoice_id
						LEFT JOIN tbl_product pr ON pr.product_id = pt.product_id
						WHERE pp2.design_id = inv.design_id
						LIMIT 1
					) AS size,
					SUM(inv.quantity * COALESCE(sqm_data.sqm_per_box, 0)) AS total_quantity,
					SUM(inv.quantity) AS total_boxes,
					COALESCE(MAX(sqm_data.sqm_per_box), 0) AS sqm_per_box,
					MAX((SELECT lp.way_date FROM tbl_pi_loading_plan lp
						INNER JOIN tbl_performa_packing pp ON pp.performa_packing_id = lp.performa_packing_id AND pp.design_id = inv.design_id
						WHERE lp.performa_invoice_id = inv.performa_invoice_id
							AND lp.way_date IS NOT NULL AND lp.way_date > '1970-01-01' AND lp.way_date != '0000-00-00'
						ORDER BY lp.way_date DESC LIMIT 1)) AS etd,
					MAX((SELECT lp.estimated_arrival_date FROM tbl_pi_loading_plan lp
						INNER JOIN tbl_performa_packing pp ON pp.performa_packing_id = lp.performa_packing_id AND pp.design_id = inv.design_id
						WHERE lp.performa_invoice_id = inv.performa_invoice_id
							AND lp.estimated_arrival_date IS NOT NULL AND lp.estimated_arrival_date > '1970-01-01' AND lp.estimated_arrival_date != '0000-00-00'
						ORDER BY lp.estimated_arrival_date DESC LIMIT 1)) AS eta
					" . $sales_calc_select . "
					" . $wh_columns . "
				FROM tbl_warehouse_inventory inv
				INNER JOIN tbl_performa_invoice pi ON pi.performa_invoice_id = inv.performa_invoice_id
				INNER JOIN tbl_packing_model pm ON pm.packing_model_id = inv.design_id
				" . $sales_calc_join . "
				LEFT JOIN (
					SELECT pt.invoice_id, pp.design_id, COALESCE(MAX(pt.sqm_per_box), 0) AS sqm_per_box
					FROM tbl_performa_packing pp
					INNER JOIN tbl_performa_trn pt ON pt.performa_trn_id = pp.performa_trn_id
					WHERE pt.sqm_per_box IS NOT NULL AND pt.sqm_per_box > 0
					GROUP BY pt.invoice_id, pp.design_id
				) AS sqm_data ON sqm_data.invoice_id = pi.performa_invoice_id AND sqm_data.design_id = inv.design_id
				WHERE pi.status = 0 " . $where_invoice . $where_warehouse . "
				GROUP BY inv.performa_invoice_id, inv.design_id, pi.invoice_no, pi.performa_date, pm.model_name
				" . $having . "
				ORDER BY pi.performa_date DESC, pi.invoice_no ASC, pm.model_name ASC
			";
			$query = $this->db->query($sql);
			$result = $query ? $query->result() : array();
		}

		// Fallback: tbl_stock_calculation when warehouse inventory is empty
		if (empty($result) && $this->db->table_exists('tbl_stock_calculation')) {
			$where_sc = 'pi.status = 0';
			if ($invoice_no !== null && $invoice_no !== '') {
				$where_sc .= " AND pi.invoice_no = " . $this->db->escape($invoice_no);
			}
			$sql_sc = "
				SELECT
					sc.performa_invoice_id,
					sc.design_id,
					MAX(sc.design_name) AS design_name,
					MAX(sc.size) AS size,
					MAX(sc.sku_code) AS sku_code,
					SUM(sc.warehouse_01_sqm) AS wh_1,
					SUM(sc.warehouse_02_sqm) AS wh_2,
					SUM(sc.warehouse_03_sqm) AS wh_3,
					SUM(sc.total_stock_sqm) AS total_quantity,
					SUM(sc.total_sales_6m_sqm) AS total_sales_6m_sqm,
					AVG(sc.avg_monthly_sales_sqm) AS avg_monthly_sales_sqm,
					AVG(sc.avg_daily_sales_sqm) AS avg_daily_sales_sqm,
					MAX(sc.lead_time_days) AS lead_time_days,
					COALESCE(MAX(sc.safety_stock_days), 20) AS safety_stock_days,
					MAX(sc.reorder_point_sqm) AS reorder_point_sqm,
					MAX(sc.days_of_stock_coverage) AS days_of_stock_coverage,
					MAX(sc.etd) AS etd,
					MAX(sc.eta) AS eta,
					MAX(sc.days_until_delivery) AS days_until_delivery,
					MAX(sc.days_out_of_stock_before_delivery) AS days_out_of_stock_before_delivery,
					SUM(sc.lost_sales_sqm) AS lost_sales_sqm,
					pi.invoice_no,
					pi.performa_date
				FROM tbl_stock_calculation sc
				LEFT JOIN tbl_performa_invoice pi ON pi.performa_invoice_id = sc.performa_invoice_id
				WHERE " . $where_sc . "
				GROUP BY sc.performa_invoice_id, sc.design_id, pi.invoice_no, pi.performa_date
				ORDER BY pi.performa_date DESC, pi.invoice_no ASC, design_name ASC
			";
			$q = $this->db->query($sql_sc);
			$result = $q ? $q->result() : array();
		}

		// Apply total_sales_6m_sqm from tbl_stock_calculation (most recent per pi/design) for fallback path
		if (!empty($result) && $this->db->table_exists('tbl_stock_calculation')) {
			$pairs = array();
			$seen = array();
			foreach ($result as $r) {
				if (!empty($r->performa_invoice_id) && !empty($r->design_id)) {
					$key = (int) $r->performa_invoice_id . '_' . (int) $r->design_id;
					if (!isset($seen[$key])) {
						$seen[$key] = true;
						$pairs[] = '(' . (int) $r->performa_invoice_id . ',' . (int) $r->design_id . ')';
					}
				}
			}
			if (!empty($pairs)) {
				$qo = $this->db->query('SELECT sc.performa_invoice_id, sc.design_id, sc.total_sales_6m_sqm, sc.safety_stock_days, sc.updated_at FROM tbl_stock_calculation sc WHERE (sc.performa_invoice_id, sc.design_id) IN (' . implode(',', $pairs) . ') ORDER BY sc.updated_at DESC');
				$rows = $qo ? $qo->result() : array();
				$map_sales = array();
				$map_safety = array();
				foreach ($rows as $o) {
					$key = (int) $o->performa_invoice_id . '_' . (int) $o->design_id;
					if (!isset($map_sales[$key])) {
						$map_sales[$key] = (float) $o->total_sales_6m_sqm;
						$map_safety[$key] = isset($o->safety_stock_days) ? (int) $o->safety_stock_days : 20;
					}
				}
				foreach ($result as $r) {
					$key = (int) $r->performa_invoice_id . '_' . (int) $r->design_id;
					if (isset($map_sales[$key])) {
						$r->total_sales_6m_sqm = $map_sales[$key];
						$r->safety_stock_days = $map_safety[$key];
					}
				}
			}
		}

		return $result;
	}

	/**
	 * Save user override for total sales last 6 months.
	 * @param int $performa_invoice_id
	 * @param int $design_id
	 * @param float $total_sales_6m_sqm
	 * @return bool
	 */
	public function save_stock_sales_override($performa_invoice_id, $design_id, $total_sales_6m_sqm)
	{
		if (!$this->db->table_exists('tbl_stock_calculation')) {
			return false;
		}
		$performa_invoice_id = (int) $performa_invoice_id;
		$design_id = (int) $design_id;
		$total_sales_6m_sqm = (float) $total_sales_6m_sqm;
		$existing = $this->db->select('id')->from('tbl_stock_calculation')
			->where('performa_invoice_id', $performa_invoice_id)->where('design_id', $design_id)
			->get()->row();
		$now = date('Y-m-d H:i:s');
		if ($existing) {
			return $this->db->where('id', (int) $existing->id)->update('tbl_stock_calculation', array(
				'total_sales_6m_sqm' => $total_sales_6m_sqm,
				'updated_at' => $now,
			));
		}
		$design = $this->db->select('model_name')->from('tbl_packing_model')->where('packing_model_id', $design_id)->get()->row();
		return $this->db->insert('tbl_stock_calculation', array(
			'performa_invoice_id' => $performa_invoice_id,
			'design_id' => $design_id,
			'design_name' => $design ? $design->model_name : null,
			'total_sales_6m_sqm' => $total_sales_6m_sqm,
			'created_at' => $now,
			'updated_at' => $now,
		));
	}

	/**
	 * Save user override for safety stock [days].
	 * @param int $performa_invoice_id
	 * @param int $design_id
	 * @param int $safety_stock_days
	 * @return bool
	 */
	public function save_stock_safety_stock_days($performa_invoice_id, $design_id, $safety_stock_days)
	{
		if (!$this->db->table_exists('tbl_stock_calculation')) {
			return false;
		}
		$performa_invoice_id = (int) $performa_invoice_id;
		$design_id = (int) $design_id;
		$safety_stock_days = (int) $safety_stock_days;
		if ($safety_stock_days < 0) {
			$safety_stock_days = 0;
		}
		$existing = $this->db->select('id')->from('tbl_stock_calculation')
			->where('performa_invoice_id', $performa_invoice_id)->where('design_id', $design_id)
			->get()->row();
		$now = date('Y-m-d H:i:s');
		if ($existing) {
			return $this->db->where('id', (int) $existing->id)->update('tbl_stock_calculation', array(
				'safety_stock_days' => $safety_stock_days,
				'updated_at' => $now,
			));
		}
		$design = $this->db->select('model_name')->from('tbl_packing_model')->where('packing_model_id', $design_id)->get()->row();
		return $this->db->insert('tbl_stock_calculation', array(
			'performa_invoice_id' => $performa_invoice_id,
			'design_id' => $design_id,
			'design_name' => $design ? $design->model_name : null,
			'safety_stock_days' => $safety_stock_days,
			'created_at' => $now,
			'updated_at' => $now,
		));
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

	public function get_producation_data($id, $from)
{
    $where = '';

    if ($from == 1)
    {
        $setting_data = $this->setting_data(1);

        if (!empty($setting_data->qc_checked))
        {
            $where .= ' AND mst.qc_status = 1 ';
        }

        if (!empty($setting_data->palletization_checked))
        {
            $where .= ' AND mst.pallet_status = 1 ';
        }
    }

    // ✅ Always include production, qc, and pallet status = 1
    // $where .= ' AND mst.production_status = 1 
                // AND mst.qc_status = 1 
                // AND mst.pallet_status = 1 ';

    $q = "
        SELECT mst.*, sup.*, additional.readiness_date 
        FROM tbl_production_mst AS mst 
        LEFT JOIN tbl_supplier AS sup 
               ON sup.supplier_id = mst.supplier_id 
        LEFT JOIN tbl_performa_additional_detail AS additional 
               ON additional.production_mst_id = mst.production_mst_id
        WHERE performa_invoice_id = ".$id.$where;

    $q_result = $this->db->query($q);

    $return = array();
    $con = 0;
    $i = 0;

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

public function get_producation_data1($id, $from)
{
    $where = '';

    // if ($from == 1)
    // {
        // $setting_data = $this->setting_data(1);

        // if (!empty($setting_data->qc_checked))
        // {
            // $where .= ' AND mst.qc_status = 1 ';
        // }

        // if (!empty($setting_data->palletization_checked))
        // {
            // $where .= ' AND mst.pallet_status = 1 ';
        // }
    // }

    // ✅ Always include production, qc, and pallet status = 1
    // $where .= ' AND mst.production_status = 1 
                // AND mst.qc_status = 1 
                // AND mst.pallet_status = 1 ';

    $q = "
        SELECT mst.*, sup.*, additional.readiness_date 
        FROM tbl_production_mst AS mst 
      
	   LEFT JOIN tbl_supplier AS sup 
               ON sup.supplier_id = mst.supplier_id 
        LEFT JOIN tbl_performa_additional_detail AS additional 
               ON additional.production_mst_id = mst.production_mst_id
        WHERE  performa_invoice_id = ".$id.$where;

    $q_result = $this->db->query($q);

    $return = array();
    $con = 0;
    $i = 0;

    foreach ($q_result->result() as $category)
    {
        $return[$i] = $category;
        $category->production_trn = $this->producation_trn_data1($category->production_mst_id);
        $con += $category->no_of_countainer;
        $i++;
    }

    $return['total_con'] = $con;
    return $return;
}


	

	public function producation_mst_data($id)

	{

		  $q  = "select *,performa.performa_date,performa.invoice_no,mst.note as po_notes  from tbl_production_mst as mst 

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
	
	

public function producation_trn_data1($id)

	{

		$q = 'SELECT `mst`.*, `pro`.`size_type_mm`, `pro`.`size_type_cm`, `detail`.`p_name`, `detail`.`hsnc_code`, `series`.`series_name`, `pro`.`size_width_mm`, `pro`.`size_height_mm`, `pro`.`thickness` as product_thickness, `model`.`no_of_randome`, `pro_size`.`total_pallent_container`, `pro_size`.`no_big_plt_container_new`, `pro_size`.`no_small_plt_container_new`, `pro_size`.`box_per_container`, `pro_size`.`multi_box_per_container`, `pro_size`.`total_boxes`, `trn`.`description_goods`, `packing`.`other_image`, `packing`.`per`, `model`.`model_name`, `finish`.`finish_name`, `finish`.`finish_id`, `trn`.`pallet_status`, `trn`.`sqm_per_box`, `trn`.`boxes_per_pallet`, `trn`.`performa_trn_id`, `trn`.`product_id`, `model`.`design_file`, `trn`.`pcs_per_box`, `trn`.`box_per_big_pallet`, `trn`.`box_per_small_pallet`, `trn`.`extra_product`, `packing`.`client_name`, `packing`.`barcode_no`, `packing`.`packing_net_weight`, `packing`.`packing_gross_weight`,`packing`.`design_id`, `trn`.`weight_per_box`, `trn`.`total_net_weight`, `trn`.`total_gross_weight`, `autometic`.`autometic_loading_plan_id`,`autometic`.`full_status`, `autometic`.`no_of_pallet` as `auto_no_of_pallet`, `autometic`.`no_of_boxes` as `auto_no_of_boxes`, `autometic`.`no_of_sqm` as `auto_no_of_sqm`, `autometic`.`no_of_big_pallet` as `auto_no_of_big_pallet`, `autometic`.`no_of_small_pallet` as `auto_no_of_small_pallet`, `mst`.`extra_pallet`, `mst`.`thickness`, `design`.`box_design_name`, `design`.`box_design_img`, `type`.`pallet_type_name`, (select group_concat(production_trn_id) from tbl_pi_loading_plan where production_trn_id =mst.production_trn_id) as already_loading FROM `tbl_production_trn` as `mst`

		LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `mst`.`performa_packing_id` 

		LEFT JOIN `tbl_autometic_loading_plan` as `autometic` ON `autometic`.`production_trn_id` = `mst`.`production_trn_id` AND `autometic`.`full_status` = "0"

		LEFT JOIN `tbl_performa_trn` as `trn` ON `trn`.`performa_trn_id` = `packing`.`performa_trn_id` 

		LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `trn`.`product_id` 

		LEFT JOIN `tbl_product_size` as `pro_size` ON `pro_size`.`product_size_id` = `trn`.`product_size_id` 

		LEFT JOIN `tbl_series` as `series` ON `series`.`series_id` = `pro`.`series_id` LEFT JOIN `product_code_detail` as `detail` ON `detail`.`hsnc_code` = `series`.`hsnc_code` 

		LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 

		LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id`

		LEFT JOIN `tbl_box_design` as `design` ON `design`.`box_design_id`=`mst`.`box_design_id` 

		LEFT JOIN `tbl_pallet_type` as `type` ON `type`.`pallet_type_id`=`mst`.`pallet_type_id` WHERE `mst`.`production_mst_id` = "'.$id.'" AND   IF(`packing`.`design_id` > 0, `mst`.`no_of_boxes` > 0, `packing`.`design_id` =0) 
		AND mst.production_done = 2	
		ORDER BY `packing`.`performa_packing_id` ASC';

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
	

	public function producation_trn_data($id)
{
    $q = 'SELECT 
            mst.*, 
            pro.size_type_mm, 
            pro.size_type_cm, 
            detail.p_name, 
            detail.hsnc_code, 
            series.series_name, 
            pro.size_width_mm, 
            pro.size_height_mm, 
            pro.thickness as product_thickness, 
            model.no_of_randome, 
            pro_size.total_pallent_container, 
            pro_size.no_big_plt_container_new, 
            pro_size.no_small_plt_container_new, 
            pro_size.box_per_container, 
            pro_size.multi_box_per_container, 
            pro_size.total_boxes, 
            trn.description_goods, 
            packing.other_image, 
            packing.per, 
            model.model_name, 
            finish.finish_name, 
            finish.finish_id, 
            finish.field1 as collection, 
            trn.pallet_status, 
            trn.sqm_per_box, 
            trn.boxes_per_pallet, 
            trn.performa_trn_id, 
            trn.product_id, 
            model.design_file, 
            trn.pcs_per_box, 
            trn.box_per_big_pallet, 
            trn.box_per_small_pallet, 
            trn.extra_product, 
            packing.client_name, 
            packing.barcode_no, 
            packing.packing_net_weight, 
            packing.packing_gross_weight,
            packing.design_id, 
            trn.weight_per_box, 
            autometic.autometic_loading_plan_id, 
            autometic.no_of_pallet as auto_no_of_pallet, 
            autometic.no_of_boxes as auto_no_of_boxes, 
            autometic.no_of_sqm as auto_no_of_sqm, 
            autometic.no_of_big_pallet as auto_no_of_big_pallet, 
            autometic.no_of_small_pallet as auto_no_of_small_pallet, 

            -- pallet summary values
            pbentry.finalbatch,
            pbentry.finalshade,
            pbentry.main_available_box,
            pbentry.total_input_boxes,
            pbentry.remainbox,
            pbentry.remainpallets,
            pbentry.remainbigpallets,
            pbentry.remainsmallpallets,
            pbentry.total_input_pallets,
            pbentry.total_input_big_pallets,
            pbentry.total_input_small_pallets,

            mst.extra_pallet, 
            mst.thickness, 
            design.box_design_name, 
            design.box_design_img, 
            type.pallet_type_name, 
            (select group_concat(production_trn_id) 
                from tbl_pi_loading_plan 
                where production_trn_id = mst.production_trn_id) as already_loading 
        FROM tbl_production_trn as mst
        LEFT JOIN tbl_performa_packing as packing 
            ON packing.performa_packing_id = mst.performa_packing_id 
        LEFT JOIN tbl_autometic_loading_plan as autometic 
            ON autometic.production_trn_id = mst.production_trn_id 
        LEFT JOIN (
            SELECT 
                p.production_trn_id,
				p.batchno              AS finalbatch,
				p.shadeno               AS finalshade,

                -- available values
                MAX(p.available_box) AS main_available_box,
                MAX(p.available_pallets) AS available_pallets,
                COALESCE(NULLIF(MAX(p.available_big_pallets),0), MAX(p.available_pallets))  AS available_big_pallets,
                COALESCE(NULLIF(MAX(p.available_small_pallets),0), MAX(p.available_pallets)) AS available_small_pallets,

                -- inputs (calculate total_input_boxes as sum of input_boxes * (input_pallets + input_big_pallets + input_small_pallets))
                SUM(p.input_boxes * (p.input_pallets + p.input_big_pallets + p.input_small_pallets)) AS total_input_boxes,
                SUM(p.input_pallets) AS total_input_pallets,
                SUM(p.input_big_pallets) AS total_input_big_pallets,
                SUM(p.input_small_pallets) AS total_input_small_pallets,

                -- remaining calculations
                GREATEST(0, COALESCE(MAX(p.available_box),0) - SUM(p.input_boxes)) AS remainbox,
                GREATEST(0, MAX(p.available_pallets) - SUM(p.input_pallets)) AS remainpallets,
                GREATEST(0, COALESCE(NULLIF(MAX(p.available_big_pallets),0), MAX(p.available_pallets)) - SUM(p.input_big_pallets))  AS remainbigpallets,
                GREATEST(0, COALESCE(NULLIF(MAX(p.available_small_pallets),0), MAX(p.available_pallets)) - SUM(p.input_small_pallets)) AS remainsmallpallets

            FROM tbl_pallet_box_entry AS p
            GROUP BY p.production_trn_id
        ) as pbentry 
            ON pbentry.production_trn_id = mst.production_trn_id

        LEFT JOIN tbl_performa_trn as trn 
            ON trn.performa_trn_id = packing.performa_trn_id 
        LEFT JOIN tbl_product as pro 
            ON pro.product_id = trn.product_id 
        LEFT JOIN tbl_product_size as pro_size 
            ON pro_size.product_size_id = trn.product_size_id 
        LEFT JOIN tbl_series as series 
            ON series.series_id = pro.series_id 
        LEFT JOIN product_code_detail as detail 
            ON detail.hsnc_code = series.hsnc_code 
        LEFT JOIN tbl_packing_model as model 
            ON model.packing_model_id = packing.design_id 
        LEFT JOIN tbl_finish as finish 
            ON finish.finish_id = packing.finish_id 
        LEFT JOIN tbl_box_design as design 
            ON design.box_design_id = mst.box_design_id 
        LEFT JOIN tbl_pallet_type as type 
            ON type.pallet_type_id = mst.pallet_type_id 
        WHERE mst.production_mst_id = "'.$id.'" 
        AND IF(packing.design_id > 0, mst.no_of_boxes > 0, packing.design_id = 0) 
        ORDER BY packing.performa_packing_id ASC';

    $q_result = $this->db->query($q);   

    $return = [];
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
    $q = 'SELECT 
            mst.*, 
            pro.size_type_mm, 
            pro.size_type_cm, 
            detail.p_name, 
            detail.hsnc_code, 
            series.series_name, 
            pro.size_width_mm, 
            pro.size_height_mm, 
            pro.thickness as product_thickness, 
            model.no_of_randome, 
            pro_size.total_pallent_container, 
            pro_size.no_big_plt_container_new, 
            pro_size.no_small_plt_container_new, 
            pro_size.box_per_container, 
            pro_size.multi_box_per_container, 
            pro_size.total_boxes, 
            trn.description_goods, 
            packing.other_image, 
            packing.per, 
            model.model_name, 
            finish.finish_name, 
            finish.finish_id, 
            finish.field1 as collection, 
            trn.pallet_status, 
            trn.sqm_per_box, 
            trn.boxes_per_pallet, 
            trn.performa_trn_id, 
            trn.product_id, 
            model.design_file, 
            trn.pcs_per_box, 
            trn.box_per_big_pallet, 
            trn.box_per_small_pallet, 
            trn.extra_product, 
            packing.client_name, 
            packing.barcode_no, 
            packing.packing_net_weight, 
            packing.packing_gross_weight,
            packing.design_id, 
            trn.weight_per_box, 
            autometic.autometic_loading_plan_id, 
            autometic.no_of_pallet as auto_no_of_pallet, 
            autometic.no_of_boxes as auto_no_of_boxes, 
            autometic.no_of_sqm as auto_no_of_sqm, 
            autometic.no_of_big_pallet as auto_no_of_big_pallet, 
            autometic.no_of_small_pallet as auto_no_of_small_pallet, 

            -- pallet summary values
            pbentry.finalbatch,
            pbentry.finalshade,
            pbentry.main_available_box,
            pbentry.total_input_boxes,
            pbentry.remainbox,
            pbentry.remainpallets,
            pbentry.remainbigpallets,
            pbentry.remainsmallpallets,
            pbentry.total_input_pallets,
            pbentry.total_input_big_pallets,
            pbentry.total_input_small_pallets,

            mst.extra_pallet, 
            mst.thickness, 
            design.box_design_name, 
            design.box_design_img, 
            type.pallet_type_name, 
            (select group_concat(production_trn_id) 
                from tbl_pi_loading_plan 
                where production_trn_id = mst.production_trn_id) as already_loading 
        FROM tbl_production_trn as mst
        LEFT JOIN tbl_performa_packing as packing 
            ON packing.performa_packing_id = mst.performa_packing_id 
        LEFT JOIN tbl_autometic_loading_plan as autometic 
            ON autometic.production_trn_id = mst.production_trn_id 
        LEFT JOIN (
            SELECT 
                p.production_trn_id,
                p.batchno AS finalbatch,
                p.shadeno AS finalshade,

                -- available values
                MAX(p.available_box) AS main_available_box,
                MAX(p.available_pallets) AS available_pallets,
                COALESCE(NULLIF(MAX(p.available_big_pallets),0), MAX(p.available_pallets))  AS available_big_pallets,
                COALESCE(NULLIF(MAX(p.available_small_pallets),0), MAX(p.available_pallets)) AS available_small_pallets,

                -- inputs (calculate total_input_boxes as sum of input_boxes * (input_pallets + input_big_pallets + input_small_pallets))
                SUM(p.input_boxes * (p.input_pallets + p.input_big_pallets + p.input_small_pallets)) AS total_input_boxes,
                SUM(p.input_pallets) AS total_input_pallets,
                SUM(p.input_big_pallets) AS total_input_big_pallets,
                SUM(p.input_small_pallets) AS total_input_small_pallets,

                -- remaining calculations
                GREATEST(0, COALESCE(MAX(p.available_box),0) - SUM(p.input_boxes)) AS remainbox,
                GREATEST(0, MAX(p.available_pallets) - SUM(p.input_pallets)) AS remainpallets,
                GREATEST(0, COALESCE(NULLIF(MAX(p.available_big_pallets),0), MAX(p.available_pallets)) - SUM(p.input_big_pallets))  AS remainbigpallets,
                GREATEST(0, COALESCE(NULLIF(MAX(p.available_small_pallets),0), MAX(p.available_pallets)) - SUM(p.input_small_pallets)) AS remainsmallpallets

            FROM tbl_pallet_box_entry AS p
            GROUP BY p.production_trn_id
        ) as pbentry 
            ON pbentry.production_trn_id = mst.production_trn_id

        LEFT JOIN tbl_performa_trn as trn 
            ON trn.performa_trn_id = packing.performa_trn_id 
        LEFT JOIN tbl_product as pro 
            ON pro.product_id = trn.product_id 
        LEFT JOIN tbl_product_size as pro_size 
            ON pro_size.product_size_id = trn.product_size_id 
        LEFT JOIN tbl_series as series 
            ON series.series_id = pro.series_id 
        LEFT JOIN product_code_detail as detail 
            ON detail.hsnc_code = series.hsnc_code 
        LEFT JOIN tbl_packing_model as model 
            ON model.packing_model_id = packing.design_id 
        LEFT JOIN tbl_finish as finish 
            ON finish.finish_id = packing.finish_id 
        LEFT JOIN tbl_box_design as design 
            ON design.box_design_id = mst.box_design_id 
        LEFT JOIN tbl_pallet_type as type 
            ON type.pallet_type_id = mst.pallet_type_id 
        WHERE FIND_IN_SET(mst.production_trn_id, "'.$id.'") 
        AND IF(packing.design_id > 0, mst.no_of_boxes > 0, packing.design_id = 0) 
        ORDER BY packing.performa_packing_id ASC';

    $q_result = $this->db->query($q);   

    $return = [];
    $i = 0;

    foreach ($q_result->result() as $category) {
        $return[$i] = $category;
        $category->packing = $this->get_packing($category->performa_trn_id);
        $i++;
    }

    return $return;
}




// public function producation_trn_data($id)

	// {

		// $q = 'SELECT `mst`.*, `pro`.`size_type_mm`, `pro`.`size_type_cm`, `detail`.`p_name`, `detail`.`hsnc_code`, `series`.`series_name`, `pro`.`size_width_mm`, `pro`.`size_height_mm`, `pro`.`thickness` as product_thickness, `model`.`no_of_randome`, `pro_size`.`total_pallent_container`, `pro_size`.`no_big_plt_container_new`, `pro_size`.`no_small_plt_container_new`, `pro_size`.`box_per_container`, `pro_size`.`multi_box_per_container`, `pro_size`.`total_boxes`, `trn`.`description_goods`, `packing`.`other_image`, `packing`.`per`, `model`.`model_name`, `finish`.`finish_name`, `finish`.`finish_id`, `trn`.`pallet_status`, `trn`.`sqm_per_box`, `trn`.`boxes_per_pallet`, `trn`.`performa_trn_id`, `trn`.`product_id`, `model`.`design_file`, `trn`.`pcs_per_box`, `trn`.`box_per_big_pallet`, `trn`.`box_per_small_pallet`, `trn`.`extra_product`, `packing`.`client_name`, `packing`.`barcode_no`, `packing`.`packing_net_weight`, `packing`.`packing_gross_weight`,`packing`.`design_id`, `trn`.`weight_per_box`, `trn`.`total_net_weight`, `trn`.`total_gross_weight`, `autometic`.`autometic_loading_plan_id`,`autometic`.`full_status`, `autometic`.`no_of_pallet` as `auto_no_of_pallet`, `autometic`.`no_of_boxes` as `auto_no_of_boxes`, `autometic`.`no_of_sqm` as `auto_no_of_sqm`, `autometic`.`no_of_big_pallet` as `auto_no_of_big_pallet`, `autometic`.`no_of_small_pallet` as `auto_no_of_small_pallet`, `mst`.`extra_pallet`, `mst`.`thickness`, `design`.`box_design_name`, `design`.`box_design_img`, `type`.`pallet_type_name`, (select group_concat(production_trn_id) from tbl_pi_loading_plan where production_trn_id =mst.production_trn_id) as already_loading FROM `tbl_production_trn` as `mst`

		// LEFT JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `mst`.`performa_packing_id` 

		// LEFT JOIN `tbl_autometic_loading_plan` as `autometic` ON `autometic`.`production_trn_id` = `mst`.`production_trn_id` AND `autometic`.`full_status` = "0"

		// LEFT JOIN `tbl_performa_trn` as `trn` ON `trn`.`performa_trn_id` = `packing`.`performa_trn_id` 

		// LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `trn`.`product_id` 

		// LEFT JOIN `tbl_product_size` as `pro_size` ON `pro_size`.`product_size_id` = `trn`.`product_size_id` 

		// LEFT JOIN `tbl_series` as `series` ON `series`.`series_id` = `pro`.`series_id` LEFT JOIN `product_code_detail` as `detail` ON `detail`.`hsnc_code` = `series`.`hsnc_code` 

		// LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 

		// LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id`

		// LEFT JOIN `tbl_box_design` as `design` ON `design`.`box_design_id`=`mst`.`box_design_id` 

		// LEFT JOIN `tbl_pallet_type` as `type` ON `type`.`pallet_type_id`=`mst`.`pallet_type_id` WHERE `mst`.`production_mst_id` = "'.$id.'" AND   IF(`packing`.`design_id` > 0, `mst`.`no_of_boxes` > 0, `packing`.`design_id` =0) ORDER BY `packing`.`performa_packing_id` ASC';

		  // $q_result = $this->db->query($q);   

			  // $return = array();

			  // $i=0;

			// foreach ($q_result->result() as $category) {

				 // $return[$i] = $category;

			  	 // $category->packing = $this->get_packing($category->performa_trn_id);

			 // $i++;

			 // } 

		   

		// return $return;

		 

	// }

	// public function producation_trn_multiple_data($id)

	// {

		

		// $q =  'SELECT `mst`.*, `pro`.`size_type_mm`, `pro`.`size_type_cm`, `detail`.`p_name`, `detail`.`hsnc_code`, `series`.`series_name`, `pro`.`size_width_mm`, `pro`.`size_height_mm`, `model`.`model_name`, `finish`.`finish_name`, `trn`.`pallet_status`, `trn`.`sqm_per_box`, `trn`.`boxes_per_pallet`, `trn`.`performa_trn_id`, `trn`.`product_id`, `model`.`design_file`, `trn`.`pcs_per_box`, `trn`.`box_per_big_pallet`, `trn`.`box_per_small_pallet`,trn.description_goods, `packing`.`client_name`, packing.per, `packing`.`barcode_no`, `pmst`.`supplier_id`, `supplier`.`company_name`, pmst.no_of_countainer,`mst`.`production_mst_id`,autometic.autometic_loading_plan_id  FROM `tbl_production_trn` as `mst` 

		// INNER JOIN `tbl_production_mst` as `pmst` ON `pmst`.`production_mst_id` = `mst`.`production_mst_id` 

		// LEFT JOIN 	tbl_autometic_loading_plan as autometic on  autometic.production_trn_id = mst.production_trn_id

		// INNER JOIN `tbl_supplier` as `supplier` ON `supplier`.`supplier_id` = `pmst`.`supplier_id` 

		// INNER JOIN `tbl_performa_packing` as `packing` ON `packing`.`performa_packing_id` = `mst`.`performa_packing_id` 

		// INNER JOIN `tbl_performa_trn` as `trn` ON `trn`.`performa_trn_id` = `packing`.`performa_trn_id` 

		// LEFT JOIN `tbl_product` as `pro` ON `pro`.`product_id` = `trn`.`product_id` 

		// LEFT JOIN `tbl_series` as `series` ON `series`.`series_id` = `pro`.`series_id` 

		// LEFT JOIN `product_code_detail` as `detail` ON `detail`.`hsnc_code` = `series`.`hsnc_code` 

		// LEFT JOIN `tbl_packing_model` as `model` ON `model`.`packing_model_id`=`packing`.`design_id` 

		// LEFT JOIN `tbl_finish` as `finish` ON `finish`.`finish_id`=`packing`.`finish_id`

		// WHERE find_in_set(`mst`.`production_trn_id`,"'.$id.'") ORDER BY `packing`.`performa_packing_id` ASC';	

		// $q_result = $this->db->query($q);	  

			  // $return = array();

			  // $i=0;

			// foreach ($q_result->result() as $category) 

			// {

				 // $return[$i] = $category;

				 // $category->packing = $this->get_packing($category->performa_trn_id);

			 // $i++;

			 // } 

		   

		// return $return;

		 

	// }

	public function delete_producation($id){

		

		$q = $this->db->where('production_mst_id',$id);

		$q = $this->db->delete('tbl_production_mst');

		$q1 = $this->db->where('production_mst_id',$id);

		$q1 = $this->db->delete('tbl_production_trn');

		$q1 = $this->db->where('production_mst_id',$id);

		$q1 = $this->db->delete('tbl_performa_box_design');

		$q1 = $this->db->where('production_mst_id',$id);

		$q1 = $this->db->delete('tbl_performa_additional_detail');

		$q1 = $this->db->where('production_mst_id',$id);

		$q1 = $this->db->delete('tbl_pi_design_details');

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
	
		public function insert_pallet_order_entry($data)
	{
		$this->db->insert('tbl_pallet_order_entry', $data);
		return $this->db->insert_id(); // Or return true if you don’t need the ID
	}

public function productio_entry_record($id)

	{

		$q= $this->db->select("mst.*")

			 ->from("tbl_pallet_box_entry as mst")

			 ->where("mst.production_mst_id",$id)

			 ->get();

		 

		return $q->result();

	} 
	
	public function pallet_ordernew($id){

		 

		$array = array('mst.production_mst_id'=>$id);

		$q = $this->db->select("mst.*,pro_mst.producation_no,pro_mst.producation_date,porderextra.no_of_pallet")

			->from('tbl_pallet_order_entry as mst')

		 	->join('tbl_pallet_order_extraentry as porderextra','porderextra.production_mst_id  = mst.production_mst_id ','LEFT')
		 	->join('tbl_production_mst as pro_mst','pro_mst.production_mst_id  = mst.production_mst_id ','LEFT')

		 	// ->join('tbl_performa_invoice as invoice','invoice.performa_invoice_id  = pro.performa_invoice_id ','LEFT')

		 	// ->join('tbl_pallet_party as party','party.pallet_party_id  = mst.pallet_party_id ','LEFT')

			// ->join('tbl_pallet_order_trn as order','order.pallet_order_id  = mst.pallet_order_id ','LEFT')

			//->join('tbl_pallet_type as type','type.pallet_type_id  = mst.pallet_type ','LEFT')

		 	->where($array)

	 		->get();

	 	 

		return $q->row();

	}
	
	
	
	public function insert_pallet_order_extraentry($data){

		 

		$this->db->insert('tbl_pallet_order_extraentry',$data);

		  return $this->db->insert_id();

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
    $array = array('mst.pallet_order_id' => $id);

    $this->db->select("mst.*, type.pallet_type_name, packing.model_name, p_size.pcs_per_box") // include required columns
        ->from('tbl_pallet_order_trn as mst')
        ->join('tbl_pallet_type as type', 'type.pallet_type_id = mst.pallet_type', 'LEFT')
        ->join('tbl_packing_model as packing', 'packing.packing_model_id = mst.product_id', 'LEFT')
        ->join(
            '(SELECT * FROM tbl_product_size GROUP BY product_id) as p_size',
            'p_size.product_id = mst.product_id',
            'LEFT'
        )
        ->where($array);

    $q = $this->db->get();

    return $q->result();
}

	public function palletordertrn1($id)
{
    $this->db->select('
        trn.*, 
        mst.producation_no, 
        pmodel.model_name, 
        f.finish_name, 
        pro.size_type_mm, 
        ptrn.sqm_per_box, 

        trn.pro_batch, 
        trn.boxes_per_pallet as trnboxes_per_pallet, 
        trn.box_per_big_pallet as trnbox_per_big_pallet, 
        trn.box_per_small_pallet as trnbox_per_small_pallet, 

        ptrn.boxes_per_pallet, 
        ptrn.box_per_big_pallet, 
        ptrn.box_per_small_pallet
    ');

    $this->db->from('tbl_production_trn trn');

    $this->db->join('tbl_production_mst mst', 'mst.production_mst_id = trn.production_mst_id', 'INNER');
    $this->db->join('tbl_performa_packing ppacking', 'ppacking.performa_packing_id = trn.performa_packing_id', 'INNER');
    $this->db->join('tbl_performa_trn ptrn', 'ptrn.performa_trn_id = ppacking.performa_trn_id', 'INNER');
    $this->db->join('tbl_product pro', 'pro.product_id = ptrn.product_id', 'INNER');
    $this->db->join('tbl_packing_model pmodel', 'pmodel.packing_model_id = ppacking.design_id', 'INNER');
    $this->db->join('tbl_finish f', 'f.finish_id = ppacking.finish_id', 'INNER');

    $this->db->where('trn.production_mst_id', $id);
    $this->db->where('trn.production_done', 2);
	
	 // ✅ show only rows where pro_batch is not empty
    //$this->db->where('trn.pro_batch IS NOT NULL', null, false);
    //$this->db->where('trn.pro_batch !=', '');
	

    /* SAME ORDERING */
    $this->db->order_by('pmodel.model_name', 'ASC');
    $this->db->order_by('IFNULL(trn.parent_trn_id, trn.production_trn_id)', 'ASC', FALSE);
    $this->db->order_by('trn.parent_trn_id IS NOT NULL', 'ASC', FALSE);
    $this->db->order_by('trn.production_trn_id', 'ASC');

    return $this->db->get()->result();
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

    // PI DESIGN DATA

	public function getDesignSizes()
	{
		return $this->db->select('DISTINCT(size_type_cm) as size_type_cm')->get('tbl_pi_design_details')->result_array();		
	}
	
	public function getSeriesName()
	{
		return $this->db->select('DISTINCT(series_name) as series_name')->get('tbl_series')->result_array();		
	}

	public function getDesignPIno()
	{
		return $this->db->select('DISTINCT(pi_no) as pi_no')->get('tbl_pi_design_details')->result_array();		
	}

	public function getPiDesigns()
	{
		return $this->db->select('DISTINCT(pdd.model_design_id) as model_design_id, pm.model_name')->join('tbl_packing_model pm','pm.packing_model_id=pdd.model_design_id')->get('tbl_pi_design_details pdd')->result_array();
	}

    public function deletePIdesignData($id)
	{
		$this->db->where('production_mst_id',$id);
		$this->db->delete('tbl_pi_design_details');		
	}

	public function insertBulkPidesignData($data)
	{
		if(!empty($data))
		{
			$this->db->insert_batch('tbl_pi_design_details', $data);
		}		
	}

	public function get_pi_design_data($pi_no='',$size='',$finish_id='',$cust_id='', $model_design_id='')
	{
		 $where = " pdd.status = 0 ";

		 if(!empty($model_design_id))
		 {
			 $where .= " and pdd.model_design_id = '".$model_design_id."'";
		 }

		 if(!empty($pi_no))
		 {
			 $where .= " and pdd.pi_no = '".$pi_no."'";
		 }

		 if(!empty($size))
		 {
			 $where .= " and pdd.size_type_cm = '".$size."'";
		 }

		 if(!empty($finish_id))
		 {
			 $where .= " and pdd.finish_id = '".$finish_id."'";
		 }
		 
		 if(!empty($cust_id))
		 {
			$where .= " and consign.id = '".$cust_id."'";
		 } 
		 
		 // if(!empty($seriesid))
		 // {
			// $where .= " and series.series_id = '".$seriesid."'";
		 // }-->

		 $qry = "SELECT pdd.*, finish.finish_name, consign.c_companyname, consign.c_nick_name, consign.c_name, supplier.supplier_name, supplier.company_name, series.series_name,series.series_id, model.model_name from tbl_pi_design_details as pdd 
		 	LEFT join tbl_packing_model as model on model.packing_model_id = pdd.model_design_id
			LEFT join tbl_product as product on product.product_id = model.product_id
		 	LEFT join tbl_series as series on series.series_id = product.series_id
		 	LEFT join tbl_finish as finish on finish.finish_id = pdd.finish_id 
		 	LEFT join tbl_performa_invoice as pi on pi.performa_invoice_id = pdd.performa_invoice_id
		    LEFT join customer_detail consign on consign.id = pi.consigne_id
			LEFT join tbl_supplier supplier on supplier.supplier_id = pdd.supplier_name
		 	WHERE ".$where;
		 $q_con = $this->db->query($qry);
			return $q_con->result();
	}

	public function delete_record($id)
	{
		$this->db->where('pi_detail_id',$id);
		$this->db->delete('tbl_pi_design_details');		
	}

	public function edit_record($id,$field,$chang_val)
	{
		$this->db->where('pi_detail_id',$id);
		$this->db->update('tbl_pi_design_details',array($field=>$chang_val));
	}
	
	public function getsizedata()
	{
		//$q = $this->db->where('status',0);
	 	$q = $this->db->get('tbl_product');
		return $q->result();
	}

}

