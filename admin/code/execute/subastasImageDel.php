<?php
include_once("../../core/admin.php");
include_once("../../core/files.php");
admin::initialize('subasta','subastaImageDel'); 
$pro_uid = $_REQUEST["uid"];
$sql = "update mdl_subasta_languages  
		set prl_image='' 
		where prl_pro_uid=" . $pro_uid;
$db->query($sql);
?>
