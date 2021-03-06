<?php
$sub_uid =  admin::getParam("sub_uid");
?>
<br />
<table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr><td>
            &nbsp;
        </td></tr>
  <tr>
      <td width="77%" height="40"><span class="title">Ver Reporte</span>&nbsp;<a href="code/execute/reporteTplXlsPdf.php?token=<?=admin::getParam("token")?>&pro=<?=$sub_uid?>&type=xls">
              <img src="lib/ext/excel.png" border="0" alt="Excel" title="Excel" /></a>&nbsp;<a href="code/execute/reporteTplXlsPdf.php?token=<?=admin::getParam("token")?>&pro=<?=$sub_uid?>&type=pdf"><img src="lib/ext/acrobat.png" border="0" alt="Excel" title="Excel" /></a>
    </td>
    <td width="23%" height="40">&nbsp;</td>
  </tr>
    <tr><td>
            &nbsp;
        </td></tr>
  <tr>
  
  <tr>
    <td colspan="2" id="contentListing">
    	
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
        <td width="100%" valign="top">
        
        
         <br />
         <table width="98%" border="0" cellpadding="5" cellspacing="5" class="box">
          <tr>
              <td>
          <!--INICIO-->

<?php
$sub_uid =admin::toSql(admin::getParam("sub_uid"),"Number");

$sql ="SELECT sub_sol_uid, pro_name,pca_name,pro_description,pro_quantity,pro_unidad,sub_status, sub_modalidad, sub_type, sub_hour_end, sub_mount_base, sub_mount_unidad, sub_tiempo, sub_uid 
FROM mdl_subasta, mdl_product,mdl_pro_category
WHERE sub_uid=pro_sub_uid and pca_uid=sub_pca_uid and sub_status='ACTIVE' and sub_uid='$sub_uid'";
$db->query($sql);
while ($firstPart = $db->next_record())
{ 
	$pro_name=$firstPart['pro_name'];
	$pca_name=$firstPart['pca_name'];
	$pro_description=$firstPart['pro_description'];
	$pro_quantity=$firstPart['pro_quantity'];
	$pro_unidad=$firstPart['pro_unidad'];
	$sub_status=$firstPart['sub_status'];
	$sub_modalidad=$firstPart['sub_modalidad'];
	$sub_type=$firstPart['sub_type'];
	$sub_hour_end=explode(" ", $firstPart['sub_hour_end']);
	$sub_mount_base=$firstPart['sub_mount_base'];
	$sub_mount_unidad=$firstPart['sub_mount_unidad'];
	$sub_tiempo=$firstPart['sub_tiempo'];
	$sub_uid=$firstPart['sub_uid'];
        $sub_sol_uid = $firstPart["sub_sol_uid"];
}
?>
<table width="50%">
<tr>
    <td ><img src="<?=$domain?>/lib/logo.png" width="100" />
    </td>
    <td colspan="4"><h1>Parametrizaci&oacute;n del Proceso</h1><br /><span>Fecha: <?=date("d/m/Y")?></span></td>
</tr>
<tr>
    <td colspan="5"><br /><br /></td>
    
</tr>
<tr>
    <td colspan="5"><h2>1: Datos generales del Proceso</h2></td>
</tr>
<tr>
    <td colspan="5"><br /></td>
</tr>
<tr>
    <td>Nro Solicitud:</td>
    <td align="left"><?=$sub_sol_uid?></td>
    <td></td>
    <td></td>
    <td align="left"></td>
</tr>
<tr>
    <td>Nro Proceso:</td>
    <td align="left"><?=$sub_uid?></td>
    <td></td>
    <td></td>
    <td align="left"></td>
</tr>
<tr>
    <td>Nombre:</td>
    <td align="left"><?=$pro_name?></td>
    <td></td>
    <td>Cantidad:</td>
    <td align="left"><?=admin::numberFormat($pro_quantity)?></td>
</tr>
<tr>
    <td>Categor&iacute;a:</td>
    <td align="left"><?=$pca_name?></td>
    <td></td><td width="21%">Unidades:</td>
    <td align="left"><?=$pro_unidad?></td>
</tr>
<tr>
    <td>Descripci&oacute;n:</td>
    <td></td><td width="6%"></td>
    <td></td><td width="21%"></td>
</tr>
<tr>
    <td colspan="5" align="left"><?=$pro_description?></td>
</tr>
<tr>
    <td colspan="5"><br /><br /></td>
</tr>
<tr>
    <td colspan="5"><h2>2: Datos particulares del Proceso</h2></td>
</tr>
<tr>
    <td colspan="5"><br /></td>
</tr>
<tr>
    <td>Modalidad del Proceso:</td>
    <td align="left"><?=$sub_modalidad?></td>
    <td></td>
    <td>Fecha del Proceso:</td>
    <td align="left"><?=$sub_hour_end[0]?></td>
</tr>
<tr>
    <td>Tipo:</td>
    <td align="left"><?=$sub_type?></td>
    <td></td>
    <td>Hora:</td>
    <td align="left"><?=$sub_hour_end[1]?></td>
</tr>
<tr>
    <td >Monto Referencial:</td>
    <td align="left"><?=admin::numberFormat($sub_mount_base)?></td>
    <td></td><td width="21%">Tiempo l&iacute;mite de mejora en min.:</td>
    <td align="left"><?=$sub_tiempo?></td>
</tr>
 <?php
                        if($sub_modalidad=="TIEMPO")
                        {
                        ?>
<tr>
    <td >Unidad de mejora:</td>
    <td  align="left"><?=admin::numberFormat($sub_mount_unidad)?></td>
    <td ></td><td width="21%"></td>
    <td ></td>
</tr>
                        <?php } ?>
<tr>
    <td colspan="5"><br /><br /></td>
</tr>
<tr>
    <td colspan="5"><h2>3: Proveedores habilitados</h2></td>
</tr>
<tr>
    <td colspan="5"><br /></td>
</tr>
<tr>
    <td colspan="5">
	<table width="100%">
    	<tr><th width="10%">Proveedor:</th>
            <th width="10%">Lugar de entrega:</th>
            <th width="10%">Medio de transporte:</th>
            <th width="10%">Incoterm:</th>
                <?php
    if($sub_type!='VENTA'){
    ?>

            <th width="10%">Factor de ajuste:</th>
    <?php } ?>
        </tr>
<?php

$sql ="select cli_socialreason as nombre, inc_lugar_entrega, tra_name, inl_name, inc_ajuste 
from mdl_incoterm, mdl_incoterm_language, mdl_transporte, mdl_client 
where inc_inl_uid=inl_uid and inc_tra_uid=tra_uid and inc_cli_uid=cli_uid and inc_delete=0 and inc_sub_uid='$sub_uid' 
order by inc_uid desc";
$db2->query($sql);	

while ($secPart = $db2->next_record())
{		
?>
        <tr>
            <td width="20%" align="center"><?=$secPart['nombre']?></td>
            <td width="20%" align="center"><?=$secPart['inc_lugar_entrega']?></td>
            <td width="20%" align="center"><?=$secPart['tra_name']?></td>
            <td width="20%" align="center"><?=$secPart['inl_name']?></td>
                <?php
    if($sub_type!='VENTA'){
    ?>

            <td width="20%" align="center"><?=$secPart['inc_ajuste']?></td>
    <?php } ?>
        </tr>
        <?php
 } 
?>
        </table>
</td>
</tr>
</table>

          <!--FIN-->
           <tr>
            <td width="50%" valign="top">
            <table width="98%" border="0"  align="right" cellpadding="0" cellspacing="5" class="box">
          <tr>
            <td colspan="2" class="titleBox"></td>
          </tr>
          
        </table>&nbsp;
        </td>
          </tr>
		  
        </table>
         </td>
    </tr>
</table>
</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td colspan="5" align="rigth">
        
      <div id="contentButton">
	  	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td width="59%" align="center">
                                    <a href="reporteList.php?token=<?=admin::getParam("token")?>" class="button" >Volver</a> 
				</td>
        </tr>
      </table>
      </div>
    
    </td>
   
</tr>
<tr>
    <td>&nbsp;</td>
</tr>

</table>

    