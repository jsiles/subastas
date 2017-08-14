<?php
include_once("../../core/admin.php");
include_once("../../core/files.php");
include_once("../../core/images.php");
include_once("../../core/thumb.php");
set_time_limit(0);
admin::initialize('import','importAdd'); 
$token=admin::getParam("token");
$imp_type=admin::getParam("imp_type");
$imp_file=admin::getParam("imp_file");
$imp_del=admin::getParam("imp_del");
if((strlen($imp_file)>0)&&($imp_type>0)){
$fp = fopen(PATH_ROOT."/admin/jfile/server/php/files/".$imp_file, "r");

while ($line = fgets($fp)) {
$char =  split(";",$line,8); 
 list($ci, $cod_emp,$nombre,$apPat, $apMat, $correo, $usuario, $pass) = $char;
 
         
if($imp_del==1) $db->query("update  mdl_client set cli_delete=1 where cli_type=$imp_type");
 
$sql = "insert into mdl_client(cli_nit_ci,cli_interno, cli_lec_uid, cli_cov_uid, cli_socialreason, cli_mainemail, cli_legal_ci, cli_legalname, cli_legallastname,".
        " cli_user, cli_password, cli_item_uid, cli_ite_uid, cli_pts_uid, cli_status, cli_status_main, cli_delete, cli_date, cli_type) ".
        " values('$ci','$cod_emp',1,1,'".$name." ".$apPat." ".$apMat."','$correo', '$ci', '$nombre', '$apPat', '$usuario', '$pass',1,1,1,1,1,0,GETDATE(),$imp_type)"; // Generate our sql string
//echo $sql;
$db->query($sql);

}
fclose($fp);
$db->query("insert into mdl_import(imp_datetime, imp_type, imp_status, imp_delete, imp_usu_uid, imp_reset)values(getdate(), $imp_type, 'ACTIVE', 0,".admin::getSession("usr_uid").", $imp_del)");

unlink(PATH_ROOT."/admin/jfile/server/php/files/".$imp_file);
}
//die;
header("Location: ../../importList.php?token=$token");	    
?>