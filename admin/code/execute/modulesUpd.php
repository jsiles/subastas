<?php
include_once("../../core/admin.php");
include_once("../../core/files.php");
include_once("../../core/images.php");
admin::initialize('modules','modulesList',false);

$mod_uid	=	admin::toSql(safeHtml($_POST["mod_uid"]),"Text");
$mod_name	=	admin::toSql(safeHtml($_POST["mod_name"]),"Text");
$mod_alias	=	admin::toSql(safeHtml($_POST["mod_alias"]),"Text");
$mod_index	=	admin::toSql(safeHtml($_POST["mod_index"]),"Text");
$mod_status =	admin::toSql(safeHtml($_POST["mod_status"]),"Text");
$mod_parent =	admin::toSql(safeHtml($_POST["mod_parent"]),"Number");

$token = admin::getParam('token');
$nextUrl ='modulesList.php?token='.$token;

	$sql = "update sys_modules set 
	mod_alias='".$mod_alias."',
	mod_parent='".$mod_parent."',
	mod_name='".$mod_name."',
	mod_status='".$mod_status."',
	mod_index='".$mod_index."'
	where mod_uid = '".$mod_uid."' and mod_language='".$lang."'";
	$db->query($sql);
	
header('Location: ../../'.$nextUrl);
?>