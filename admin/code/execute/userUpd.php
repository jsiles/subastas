<?php
include_once("../../core/admin.php");
include_once("../../core/files.php");
include_once("../../core/images.php");
admin::initialize('users','usersEdit',false);
$use_uidA = $_POST["use_uidA"];
$usr_loginA = admin::toSql(safeHtml($_POST["usr_login"]),"String");
$usr_passA = $_POST["usr_pass"];
$usr_firstnameA = admin::toSql(safeHtml($_POST["usr_firstname"]),"String");
$usr_lastnameA = admin::toSql(safeHtml($_POST["usr_lastname"]),"String");
$usr_emailA = admin::toSql(safeHtml($_POST["usr_email"]),"String");
$usr_photoA = admin::toSql(safeHtml($_POST["usr_photo"]),"String");
$usr_statusA = admin::toSql(safeHtml($_POST["usr_status"]),"String");
$usr_rolA = admin::toSql(safeHtml($_POST["usr_rol"]),"Number");
if ($usr_passA!=""){ $changepassA = "usr_pass='" . md5($usr_passA) . "',";}

$sql = "update sys_users set
			usr_login='".$usr_loginA."',
			usr_firstname='".$usr_firstnameA."', 
			usr_lastname='".$usr_lastnameA."',";
if($usr_statusA!='') {$sql .= "usr_status='".$usr_statusA."', ";}
                       $sql .= $changepassA." usr_email='".$usr_emailA."' where usr_uid=".$use_uidA;
$db->query($sql);
// SUBIENDO LA IMAGEN
$FILES = $_FILES ['usr_photo'];
		
        $allowedTypes = array("jpeg","jpg","gif","bmp", "png");
        $validFile = $FILES['name'] != '' && in_array( strtolower(pathinfo($FILES["name"],PATHINFO_EXTENSION)),$allowedTypes) ? true : false;		
		
if ($validFile && $FILES['error']==0)
	{
	// DATOS DE ARCHIVO EN SU FORMATO ORIGINAL
	$extensionFile = admin::getExtension($FILES["name"]);
	$fileName = admin::imageName($usr_loginA)."_".$use_uidA.".".$extensionFile;
	// DATOS DE REDIMENCION DE IMAGENES
	$nomIMG = admin::imageName($usr_loginA)."_".$use_uidA.".jpg";
	$nomIMG2 = "thumb_".$nomIMG;
	$nomIMG22 = "thumb2_".$nomIMG;
	$nomIMG3 = "img_".$nomIMG;
	// Subimos el archivo con el nombre original
	classfile::uploadFile($FILES,PATH_ADMIN . '/upload/profile/',$fileName);
	// redimencionamos al mismo pero con extencion jpg en el mismo tama�o
	redimImgPercent(PATH_ADMIN . "/upload/profile/" . $fileName, PATH_ADMIN . "/upload/profile/". $nomIMG,100,100);
	// Redimencionamos el nuevo jpg por el ancho definido
	redimImgWH(PATH_ADMIN . "/upload/profile/" . $nomIMG, PATH_ADMIN . "/upload/profile/". $nomIMG2,60,100);
	// Redimencionamos el nuevo jpg por el ancho definido
	redimImgWidth(PATH_ADMIN . "/upload/profile/" . $nomIMG, PATH_ADMIN . "/upload/profile/". $nomIMG22,31,100);	
	// Redimencionamos el nuevo jpg por el ancho definido
	redimImgWidth(PATH_ADMIN . "/upload/profile/" . $nomIMG, PATH_ADMIN . "/upload/profile/". $nomIMG3,300,100);
	// GUARDAMOS LA PRINCIPAL EN BASE DE DATOS
	$sql = "UPDATE sys_users SET usr_photo='".$nomIMG."' WHERE usr_uid=".$use_uidA;
	$db->query($sql);
	}
	
	$sql = "update mdl_roles_users set rus_rol_uid=".$usr_rolA." where rus_usr_uid=".$use_uidA;
	$db->query($sql);

        $token=admin::getParam("token");		
header("Location: ../../userList.php?token=".$token);		
?>