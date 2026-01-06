<?php
 class Pagging_model extends CI_Model 
 {
   
	function get_datatables($aColumns,$table,$hOrder,$isJOIN,$isWhere,$get)
	{
		$pagging=$this->get_datatables_query($aColumns,$table,$hOrder,$isJOIN,$isWhere,$get);
		
		$query = $this->db->query($pagging);
	 	$return['data'] 		  = $query->result();
		$return['count_filtered'] = $query->num_rows();
		return $return;
    } 
	public function count_all($aColumns,$table,$hOrder,$isJOIN,$isWhere,$get)
    {
        $pagging=$this->get_datatables_query($aColumns,$table,$hOrder,$isJOIN,$isWhere,$get);
		$query = $this->db->query($pagging);
		return $query->num_rows();
    }
	private function get_datatables_query($aColumns,$sTable,$hOrder,$isJOIN,$isWhere,$get)
    {
		
         if(!isset($isJOIN)) {
        $isJOIN = "";
		}
		$sLimit = "";
		if ( isset( $get['iDisplayStart'] ) &&   $get['iDisplayLength'] != '-1' )
		{
			  $sLimit = "LIMIT ".intval( $get['iDisplayStart']  ).", ".
            intval( $get['iDisplayLength'] );
		}
		$sOrder = "ORDER BY $hOrder";
		if ( isset( $get['iSortCol_0'] ) && $get['iSortCol_0']!='0')
		{
		$sOrder = "ORDER BY  ";
			for ( $i=0 ; $i<intval( $get['iSortingCols'] ) ; $i++ )
			{
				if ( $get[ 'bSortable_'.intval($get['iSortCol_'.$i]) ] == "true" )
				{
					$sortcolouname= $aColumns[ intval( $get['iSortCol_'.$i] ) ];
				if(strpos($aColumns[ intval( $get['iSortCol_'.$i] ) ], "as") == true)
				{
					$string =  $aColumns[ intval( $get['iSortCol_'.$i] ) ];
					$pieces = explode(' ', $string);
					$last_word = array_pop($pieces);
				 	$sortcolouname = $last_word;
					
				}
					$sOrder .= $sortcolouname." ".($get['sSortDir_'.$i]==='asc' ? 'asc' : 'desc') .", ";
				}
			}

			$sOrder = substr_replace( $sOrder, "", -2 );
			if ( trim($sOrder) == "ORDER BY" )
			{
				$sOrder = "";
			}
		}
		 
		 $sWhere = "where ( 1 = 1 ";
		 
    if ( isset($get['sSearch']) && $get['sSearch'] != "" )
    {
		$sWhere .= " AND	( ";
        for ( $i=0 ; $i<count($aColumns) ; $i++ )
        {
            if ( isset($get['bSearchable_'.$i]) && $get['bSearchable_'.$i] == "true" )
            {	
				$colouname= $aColumns[$i];
				
				if(strpos($aColumns[$i], " as ") == true)
				{
					$string = $aColumns[$i];
					$pieces = explode(' ', $string);
					$last_word = array_pop($pieces);
					$last_word1 = array_pop($pieces);
					  
					$colouname = str_ireplace($last_word1.' '.$last_word,'',$string);
					 
				}
		       $sWhere .= $colouname."  LIKE '%".strtoupper($get['sSearch'])."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
		$sWhere .= ") ";
    }
	 
	if(isset($isWhere) && !empty(array_filter($isWhere)) && $isWhere != NULL) {
		$sWhere .= "AND ".implode(" AND ",$isWhere);
	}
	 for ( $i=0 ; $i<count($aColumns) ; $i++ )
    {
        if ( isset($get['bSearchable_'.$i]) && $get['bSearchable_'.$i] == "true" && $get['sSearch_'.$i] != '' )
        {
            /*if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }*/
			$sWhere .= " AND ";
				$colouname= $aColumns[$i];
				
				if(strpos($aColumns[$i], "as") == true)
				{
					$colouname = substr($aColumns[$i], 0, strpos($aColumns[$i], "as"));
					
				}
		      
            $sWhere .=  $colouname." LIKE '%".strtoupper($get['sSearch_'.$i])."%' ";
        }
    }

    $sWhere .= ')';

	if(str_replace(" ","",$sWhere) == "WHERE()")
		$sWhere == "";
	$sGroup='';
	if(isset($hGroupby) && is_array($hGroupby) && $hGroupby != NULL)		
	{
		$sGroup='Group by '.implode(",",$hGroupby);
	}
    if($isJOIN == "") {
        $sQuery = "SELECT    ".str_replace(" , ", " ", implode(", ", $aColumns))."
            FROM   $sTable
			$sWhere
            $sGroup			
            $sOrder			
            $sLimit
        ";
    }
    else {
        $sQuery = "SELECT   ".str_replace(" , ", " ", implode(", ", $aColumns))."
            FROM   $sTable
            ".implode(" ",$isJOIN)." 
			$sWhere
            $sGroup			
            $sOrder			
            $sLimit
        ";
    }

	
	//  echo  $sQuery;
	return  $sQuery;
	//echo '123';	
   
	   
    }
	
 
}
?>