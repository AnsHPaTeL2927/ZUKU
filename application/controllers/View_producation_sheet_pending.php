<?php 

defined("BASEPATH") or exit("no dericet script allowed"); 

class View_producation_sheet_pending extends CI_controller{

	public function __construct(){
		parent:: __construct();
		$this->load->helper('url');
		$this->load->library(array('form_validation','session','encrypt'));
		$this->load->model('Order_report_model','order');
		$this->load->model('menu_model','menu');	
		if (!isset($_SESSION['id']) && $this->session->title == TITLE) 
		{
			redirect(base_url());
		}
	}	
 	public function index()
 	{
		if(!empty($this->session->id)  && $this->session->title == TITLE)
		{
			$this->load->model('admin_company_detail');	
			$data['company_detail']		= $this->admin_company_detail->s_select();	
			$data['customer_list'] 		= $this->order->get_customer();	
			$data['size_list'] 			= $this->order->get_size();	
			$data['get_pallet_type'] 	= $this->order->get_pallet_type();	
			$data['finish_list'] 		= $this->order->get_finish();	
			$data['menu_data']	 		= $this->menu->usermain_menu($this->session->usertype_id);	
			$data['pi_list'] 			= $this->order->get_pi_list();

			
			$this->load->view('admin/view_producation_sheet_pending',$data);	
		}
		else
		{
			redirect(base_url().'');

		 }			

	}
	public function view_pdf()
{
    // Load models
    $this->load->model('Order_model', 'order');

    // Read filters from GET (PDF call uses GET)
    $customer_id         = $this->input->get('customer_id');
    $finish_id           = $this->input->get('finish_id');
    $size_id             = $this->input->get('size_id');
    $pallet_type         = $this->input->get('pallet_type');
    $production_status   = $this->input->get('production_status');
    $daterange           = explode(" - ", $this->input->get('daterange'));

    // Fetch data using same model
    $resultdata = $this->order->get_producation_sheet_pending(
        $customer_id,
        $finish_id,
        $size_id,
        $pallet_type,
        $daterange[0],
        $daterange[1],
        $production_status
    );

    // ----------------------------
    // Build SAME HTML as view_report()
    // ----------------------------
    ob_start(); // buffer html

    // ---------- COPY YOUR TABLE ----------
    // I will reuse your code EXACTLY and wrap inside the buffer
?>
    <style>
        table, th, td { border:1px solid #444; border-collapse: collapse; padding:5px; font-size:11px; }
        th { background:#eee; }
    </style>

    <h3 style="text-align:center;">Production Sheet Data</h3>

    <table width="100%">
        <tr>
            <th>Sr No</th>
            <th>Performa Invoice No</th>
            <th>Consinee Name</th>
            <th>Size</th>
            <th>Design</th>
            <th>Finish</th>
            <th>Pallet Type</th>
            <th>Boxes</th>
            <th>SQM</th>
            <th>Amount</th>
            <th>Production Status</th>
        </tr>

<?php

    $no = 1;
    $total_box = 0;
    $total_sqm = 0;
    $total_amount = 0;

    $packingtrn_array = [];

    foreach ($resultdata as $row) {

        // same calculation block as your view_report
        $set_container = $this->order->product_set_data($row->performa_invoice_id, -1);

        for ($i = 0; $i < count($set_container); $i++) {

            if (!in_array($set_container[$i]->performa_packing_id, $packingtrn_array)) {

                $packingtrn_array[] = $set_container[$i]->performa_packing_id;

                $packingtrnarray[$set_container[$i]->performa_packing_id] = [
                    'no_of_boxes' => $set_container[$i]->origanal_boxes,
                    'no_of_sqm'   => ($set_container[$i]->origanal_boxes * $set_container[$i]->sqm_per_box),
                    'no_of_pallet' => $set_container[$i]->origanal_pallet,
                    'no_of_big_pallet' => $set_container[$i]->orginal_no_of_big_pallet,
                    'no_of_small_pallet' => $set_container[$i]->orginal_no_of_small_pallet
                ];

            } else {

                $id = $set_container[$i]->performa_packing_id;
                $packingtrnarray[$id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
                $packingtrnarray[$id]['no_of_sqm']   += ($set_container[$i]->origanal_boxes * $set_container[$i]->sqm_per_box);
                $packingtrnarray[$id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
                $packingtrnarray[$id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
                $packingtrnarray[$id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
            }
        }

        if ($packingtrnarray[$row->performa_packing_id]["no_of_boxes"] < $row->no_of_boxes) {

            $remaining_box = $row->no_of_boxes - $packingtrnarray[$row->performa_packing_id]["no_of_boxes"];
            $remaining_sqm = $row->no_of_sqm  - $packingtrnarray[$row->performa_packing_id]["no_of_sqm"];

            $desc = !empty($row->size) ? $row->size : $row->description_goods;

            $no_of_boxes = $remaining_box;
            $no_of_sqf   = $remaining_sqm;

            if ($row->per == "BOX" && $row->product_id == 0) {
                $no_of_boxes = $row->no_of_boxes;
                $no_of_sqf = 0;
            } elseif ($row->per == "SQF" && $row->product_id == 0) {
                $no_of_boxes = 0;
                $no_of_sqf = $row->no_of_boxes;
            }

            $row_color = ($row->production_done == 2) ? "#d4edda" : "#f8d7da";

            echo "
                <tr style='background:$row_color;'>
                    <td>{$no}</td>
                    <td>{$row->invoice_no}</td>
                    <td>{$row->c_companyname}</td>
                    <td>{$desc}</td>
                    <td>{$row->model_name}</td>
                    <td>{$row->finish_name}</td>
                    <td>{$row->pallet_type_name}</td>
                    <td>{$no_of_boxes}</td>
                    <td>".number_format($no_of_sqf, 2)."</td>
                    <td>".number_format(($no_of_boxes * $row->product_rate),2)."</td>
					
                    <td>".(($row->production_done == 2) ? "Done" : "Pending")."</td>
                </tr>";

            $total_box += $no_of_boxes;
            $total_sqm += $row->no_of_sqm;
            $total_amount += $row->grand_total;
            $no++;
        }
    }
?>

    <tr>
        <th colspan="7" style="text-align:right;">Total</th>
        <th><?= $total_box ?></th>
        <th><?= number_format($total_sqm,2) ?></th>
        <th><?= number_format($total_amount,2) ?></th>
        <th></th>
    </tr>

    </table>

<?php
    $html = ob_get_clean();

    // -------------------------------
    // Generate PDF using mPDF
    // -------------------------------
    include_once APPPATH . 'views/mpdf/mpdf.php';

    $mpdf = new mPDF('utf-8','A4-L','8','calibri',5,5,5,5);
    $mpdf->WriteHTML($html);
    $mpdf->Output("Production_Sheet_Pending.pdf", "I");
}

	
	public function view_report()
	{
		$customer_id	= $this->input->post('customer_id');
		$finish_id		= $this->input->post('finish_id');
		$size_id		= $this->input->post('size_id');
		$pallet_type	= $this->input->post('pallet_type');
		$production_status = $this->input->post('production_status');
		//$pi_no              = $this->input->post('pi_no'); 
		$invoicedate 	= explode(" - ",$this->input->post('daterange'));
		
		$resultdata		=	$this->order->get_producation_sheet_pending($customer_id,$finish_id,$size_id,$pallet_type,$invoicedate[0],$invoicedate[1],$production_status);
		$str = '<div class="table-responsive">
					<table class="table table-bordered table-hover" >
						<tr>
							<th colspan="10" class="text-center">Producation Sheet Data</th>
						</tr>
						<tr>
							<th>Sr No</th>
							<th>Performa Invoice No</th>
							<th>Consinee Name</th>
							<th>Size</th>
							<th>Design</th>
							<th>Finish</th>	
							<th>Pallet Type</th>
							<th>Boxes</th>
							<th>SQM</th>
							<!--<th>Container</th>-->
							<th>Amount</th>
							<th>Production Status</th>
							
						</tr>';
			 
						$no=1;
					$total_box = 0;	 	
					$total_sqm = 0;	 	
					$total_amout = 0;
	
				$packingtrn_array = array();				
		foreach($resultdata as $row)
		{
			$set_container		= 	$this->order->product_set_data($row->performa_invoice_id,-1);
			for($i=0; $i<count($set_container);$i++)
			{
				if(!in_array($set_container[$i]->performa_packing_id,$packingtrn_array))
				{
					array_push($packingtrn_array,$set_container[$i]->performa_packing_id);
					$packingtrnarray[$set_container[$i]->performa_packing_id] = array();
					
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_boxes']  =$set_container[$i]->origanal_boxes;
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_sqm']  =($set_container[$i]->origanal_boxes * $set_container[$i]->sqm_per_box);
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_pallet']  = $set_container[$i]->origanal_pallet;
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_big_pallet']  = $set_container[$i]->orginal_no_of_big_pallet;;
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_small_pallet']  = $set_container[$i]->orginal_no_of_small_pallet;;
				}
				else
				{
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_boxes'] += $set_container[$i]->origanal_boxes;
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_pallet'] += $set_container[$i]->origanal_pallet;
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_big_pallet'] += $set_container[$i]->orginal_no_of_big_pallet;
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_sqm']  +=($set_container[$i]->origanal_boxes * $set_container[$i]->sqm_per_box);
					$packingtrnarray[$set_container[$i]->performa_packing_id]['no_of_small_pallet'] += $set_container[$i]->orginal_no_of_small_pallet;
				}
			}
			 
			if($packingtrnarray[$row->performa_packing_id]["no_of_boxes"] < $row->no_of_boxes) 
			{
				$remaining_box = $row->no_of_boxes - $packingtrnarray[$row->performa_packing_id]["no_of_boxes"];
				$remaining_pallet = $row->no_of_pallet - $packingtrnarray[$row->performa_packing_id]["no_of_pallet"];
				$remaining_bigpallet = $row->no_of_big_pallet - $packingtrnarray[$row->performa_packing_id]["no_of_big_pallet"];
				$remaining_smallpallet = $row->no_of_small_pallet - $packingtrnarray[$row->performa_packing_id]["no_of_small_pallet"];
				$remaining_sqm = $row->no_of_sqm - $packingtrnarray[$row->performa_packing_id]["no_of_sqm"];
				$desc= !empty($row->size)?$row->size:$row->description_goods;
				$per_value = $row->per;	
				$no_of_boxes	= 	$remaining_box;		
				$no_of_sqf		= 	$remaining_sqm;	
				if($row->per == "BOX" && $row->product_id == 0)
				{
					  $no_of_boxes = $row->no_of_boxes;
					   $no_of_sqf = 0;
				}
				else if($row->per == "SQF" && $row->product_id == 0)
				{
					  $no_of_boxes =0;
					  $no_of_sqf = $row->no_of_boxes;
				}
				$row_class = ($row->production_done == 2) 
				 ? 'style="background:#d4edda;"'        // light green
				 : 'style="background:#f8d7da;"';       // light red



			$one_container = 0;
			$calc_boxes = $no_of_boxes; // remaining boxes

			// pallet based (remaining pallets)
			if (
				$remaining_pallet > 0 &&
				!empty($row->box_per_container)
			) {
				$one_container = ($calc_boxes * 100) / $row->box_per_container;
			}

			// big / small pallet based (remaining)
			elseif (
				($remaining_bigpallet > 0 || $remaining_smallpallet > 0) &&
				!empty($row->multi_box_per_container)
			) {
				$one_container = ($calc_boxes * 100) / $row->multi_box_per_container;
			}

			// direct box based
			elseif (!empty($row->total_boxes)) {
				$one_container = ($calc_boxes * 100) / $row->total_boxes;
			}

			// safety
			if ($one_container == INF || $one_container <= 0) {
				$one_container = 0;
			} else {
				$one_container = round($one_container / 100, 2);
			}

			$total_container += $one_container;

			
			
		$str .= '<tr '.$row_class.'>
						<td>'.$no.'</td>
						<td>'.$row->invoice_no.'</td>
						<td>'.$row->c_companyname.'</td>
						<td>'.$desc.'</td>
						<td>'.$row->model_name.'</td>
						<td>'.$row->finish_name.'</td>
						<td>'.$row->pallet_type_name.'</td>
						<td>'.$no_of_boxes.'</td>
						<td>'.number_format($no_of_sqf,2,'.','').'</td>
						<!--<td>'.number_format($one_container,2,'.','').'</td>-->
						<td>'.number_format(($no_of_boxes * $row->product_rate),2,'.','').'</td>
						<td>'.(($row->production_done == 2) ? 'Done' : 'Pending').'</td>
					</tr>';

					$total_box 		+= $no_of_boxes;	 	
					$total_sqm 		+= $row->no_of_sqm;	 	
					$total_amout 	+= $row->grand_total;
						$no++;
			  }
						 
		}
		$str .= ' 
				<tr>
							<th colspan="7" style="text-align:right"> Total </th>
							<th>'.$total_box.'</th>
							<th>'.number_format($total_sqm,2,'.','').'</th>
							<!--<th>'.number_format($total_container,2,'.','').'</th>-->
							<th>'.number_format($total_amout,2,'.','').'</th>
					</tr>
				</table>
				</div>';
			//$_SESSION['productionsheetpending'] = $str;
		echo $str;
	}
	
}

?>