<?php 
$get_msg = (!isset($_REQUEST["message"]))?"":$_REQUEST["message"];
if ($get_msg!="") $message=$get_msg; else $message=0; 
//if ($message>3) setcookie("admin",1,time() + 30*60);
//isset($_COOKIE["admin"])
$error=admin::getParam("error");
if ($message>3) {
    ?>
<script language="javascript" type="text/javascript">
document.location.href='../';
</script>
<?php } ?>
<br />
<br />
<br />
<form name="formulario" method="POST" enctype="multipart/form-data" action="code/execute/login.php">
<input type="hidden" name="message" value="<?=$message?>" />
<table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td width="77%" height="40"><span class="title"><?=admin::labels('login');?></span></td>
  </tr>
  <tr>
    <td colspan="2" id="contentListing">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top">
			<table width="98%" border="0" cellpadding="5" cellspacing="5" class="box">
			<input type="hidden" name="message" value="<?=$message?>" />
			<tr><td colspan="3" height="2"></td></tr>
			<tr>
            <td width="29%"><?=admin::labels('login','user');?>:</td>
            <td width="64%"><input name="usuario" type="text" class="inputl" size="30" value=""  onclick="setClassInputLogin(this,'ON');"  onfocus="setClassInputLogin(this,'ON');" onblur="setClassInputLogin(this,'OFF');" tabindex="1" onkeyup="if (event.keyCode==13) document.getElementById('contrasena').focus();"/></td>
            <td width="7%">&nbsp;</td>
          </tr>
		  <tr><td></td><td colspan="2"><div class="error" style="display:none;">Ingrese nombre de usuario</div></td></tr>
          <tr>
            <td><?=admin::labels('login','password');?>: </td>
            <td><input name="contrasena" id="contrasena" type="password" class="inputl" size="30"  onclick="setClassInputLogin(this,'ON');"  onfocus="setClassInputLogin(this,'ON');" onblur="setClassInputLogin(this,'OFF');" tabindex="2" onkeyup="if (event.keyCode==13) document.formulario.submit();"/></td>
            <td>&nbsp;</td>
          </tr>
		   <tr><td></td><td colspan="2"><div class="error" style="display:none;">Ingrese nombre de usuario</div></td></tr>
          <tr>
		  <td></td>
            <td colspan="2">
			<a href="javascript:document.formulario.submit();" class="button" tabindex="3">Aceptar</a>	  		</td>
          </tr>
        </table></td>
      </tr>
    </table></td>
    </tr>
</table>
</form><br />
<?php 
if ($message!=0) 
	{ 
	?>
<table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2" align="center" >
	<div class="error"><?=admin::labels('login','error');?></div>
	</td>
    </tr>
</table>
<?php }
if($error==1)
{
?>
<table width="400" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td colspan="2" align="center" >
	<div class="error">ROL Sin modulos asignados</div>
	</td>
    </tr>
</table>
<?php
}
?>
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />
<br />