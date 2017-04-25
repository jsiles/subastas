<?php
include_once("../../core/admin.php");
include_once("../../core/files.php");
include_once("../../core/images.php");
include_once("../../core/thumb.php");
admin::initialize('ordenCompra','ordenCompraAdd'); 
$tipUid=  admin::getParam("tipUid");
$token= admin::getParam("token");
$orc_uid =admin::getParam("orc_uid");
$orc_sol_uid=admin::getParam("orc_sol_uid");
$orc_nro_oc=admin::getParam("orc_nro_oc");
$orc_monto=admin::getParam("orc_monto");
$orc_moneda=admin::getParam("sub_moneda");
$orc_fecha=admin::getParam("orc_fecha");
$orc_hora=admin::getParam("orc_hora");
$orc_cli_uid=admin::getParam("orc_cli_uid");
$orc_aprobado=admin::getParam("orc_aprobado");
$orc_usr_uid=admin::getSession("usr_uid");
$orc_status=admin::getParam("orc_status");
$sql = "update mdl_orden_compra set
                                 orc_sol_uid=$orc_sol_uid,
                                 orc_nro_oc=$orc_nro_oc,
                                 orc_monto=$orc_monto,
                                 orc_moneda=$orc_moneda,
                                 orc_fecha='$orc_fecha',
                                 orc_hora='$orc_hora',
                                 orc_cli_uid=$orc_cli_uid,
                                 orc_aprobado='$orc_aprobado',
                                 orc_usr_uid=$orc_usr_uid,
                                 orc_datetime=GETDATE(),
                                 orc_status='$orc_status'
                                 where orc_uid=$orc_uid";
//echo $sql;die;
	$db->query($sql);

$rav_uni_uid=  admin::getParam("rav_uni_uid");
//if(is_array($rav_uni_uid)){
   admin::getDbValue("delete from mdl_orden_unidad where oru_orc_uid=$orc_uid");
//   foreach($rav_uni_uid as $value)
//   {
       $sql="insert into mdl_orden_unidad (oru_orc_uid, oru_uni_uid) values($orc_uid, $rav_uni_uid)";
       $db->query($sql);
//   }
//}
        
$FILES2 = $_FILES ['orc_document'];
if ($FILES2["name"] != '')
	{
	$ext = admin::getExtension($FILES2 ["name"]);
	$nomDOC = "oc_".$orc_nro_oc."_".$orc_uid.".".$ext;	
	classfile::uploadFile($FILES2,PATH_ROOT.'/admin/upload/oc/',$nomDOC);	
	$sql = "UPDATE mdl_orden_compra SET orc_document='".$nomDOC."' WHERE orc_uid=$orc_uid";
	$db->query($sql);
	}

header('Location: ../../ordenCompraList.php?token='.$token."&tipUid=".$tipUid);	
?>