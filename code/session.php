<?php
include_once("../admin/core/admin.php");
$usernameClient = $_REQUEST["usernameClient"];
$passwordClient = $_REQUEST["passwordClient"];
$usernameClient = trim($usernameClient);
$passwordClient = trim($passwordClient);
$uidClient = admin::getDBValue("SELECT cli_uid FROM mdl_client WHERE (cli_mainemail='".admin::toSql($usernameClient,"Text")."' or cli_user='".admin::toSql($usernameClient,"Text")."') and cli_password='".admin::toSql($passwordClient,"Text")."' and cli_delete=0 and cli_status=0 and cli_status_main=1");
//echo $uidClient."##";echo "SELECT cli_uid FROM mdl_client WHERE (cli_mainemail='".admin::toSql($usernameClient,"Text")."' or cli_user='".admin::toSql($usernameClient,"Text")."') and cli_password='".md5(admin::toSql($passwordClient,"Text"))."' and cli_delete=0 and cli_status=0 and cli_status_main=1";die;
if (strlen($uidClient)>0)
{
	$tiempoActual = time();

	$tiempoNuevo = $tiempoActual + (60*$tiempoMax);
	//echo $tiempoNuevo. "." .$tiempoActual;//die;
/*	$controlaSesion =  admin::getDBValue("select count(*) from sys_session where (ses_user_uid=" .admin::toSql($uidClient,"Integer"). ") and ses_lastactivity>$tiempoActual and ses_registered='V'");
	echo "Control sesion:" . $controlaSesion;
        if($controlaSesion==0) { header("Location:".$domain."/logout.php?uidClient=$uidClient");}
*/	

	$iValidaSesion = admin::getDBValue("SELECT count(*) FROM sys_session WHERE (ses_user_uid=" .admin::toSql($uidClient,"Integer"). ") and (ses_ipaddress='".admin::toSql($_SERVER['REMOTE_ADDR'],"Text")."') and ses_registered='V'");
	//echo "Cantidad de sesiones" . $iValidaSesion;die;
	if($iValidaSesion==0)
	{
		admin::setSession("uidClient",$uidClient);
		admin::setSession("userAgent", $_SERVER['HTTP_USER_AGENT']);
		admin::setSession("SKey", uniqid(mt_rand(), true));  //177153914257fadbb697e9d2.75754959
		admin::setSession("IPaddress", $_SERVER['REMOTE_ADDR']);
		admin::setSession("LastActivity", $tiempoNuevo);
		$sSQL = "INSERT INTO sys_session (ses_user_uid,ses_useragent, ses_skey,ses_ipaddress, ses_lastactivity, ses_registered) VALUES($uidClient,'" .admin::getSession("userAgent"). "', '" .admin::getSession("SKey"). "', '" .admin::getSession("IPaddress"). "', '" .admin::getSession("LastActivity"). "', 'V')"; 
		//echo $sSQL;die;
        $db->query($sSQL);
		if(admin::getSession("uidClient")) {
			$uidPass = admin::getDBValue("SELECT cli_pass_change FROM mdl_client WHERE cli_uid='$uidClient'");
		    if ($uidPass == 0) header("Location:".$domain."/registro/". $uidClient."/");	
			else header("Location:". $domain."/");
			}
		else {
                    header("Location:".$domain."/session/1/"); 
                }
	}
	else
	{
		header("Location:".$domain."/session/2/". $uidClient."/");	
	}
}else
{ 
	header("Location:".$domain."/session/1/");
}
?>