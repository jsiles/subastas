<?php
include_once("../../core/admin.php");
//admin::initialize("client", "clientList", false);
$searchTerm = admin::getParam("term");
    
    //get matched data from skills table
    $dbSAP->query("SELECT LIFNR as id, NAME1 as data, STCD1 as nit, STREET as street FROM ZMM_OBT_PRO  WHERE  (STCD1 like '%".$searchTerm."%') ORDER BY NAME1 ASC");
    while ($row = $dbSAP->next_record()) {
        $data[] =  array('label' =>$row["data"] , 'id' =>$row["id"], 'nit'=> $row["nit"], 'street'=> $row["street"] );
    }
    
    //return json data
    echo json_encode($data);