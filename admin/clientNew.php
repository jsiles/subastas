<?php 
include ("core/admin.php");
$tipUid=  admin::getParam("tipUid");
switch($tipUid){
    case 1: $opcionMenu = "client";
            $opocionSubMenu ="clientNew";
            $etiquetaCrear = "clientNew";
            $moduleListId=14;
            $moduleCrearId=15;
            break;
    case 2: $opcionMenu = "client2";
            $opocionSubMenu ="client2New";
            $etiquetaCrear = "client2New";
            $moduleListId=62;
            $moduleCrearId=63;
            break;    
    default :
            $opcionMenu = "client";
            $opocionSubMenu ="clientNew";
            $etiquetaCrear = "clientNew";
            $moduleListId=14;
            $moduleCrearId=15;
            break;
}
admin::initialize($opcionMenu, $opocionSubMenu); 
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">    
<html>
<head>
<title>Sistema de Subastas > <?=admin::labels('htmltitlepage')?></title>
<link rel="shortcut icon" href="lib/favicon.ico" />
<link rel="stylesheet" href="css/style.css" type="text/css" />
<link rel="stylesheet" href="css/dhtml_horiz.css" type="text/css" />
<!--[if gte IE 5.5]>
<script language="JavaScript" src="css/dhtml.js" type="text/JavaScript"></script>
<![endif]-->
<META NAME="author" CONTENT="DEVZONE">
<META NAME="reply-to" CONTENT="info@devzone.xyz">
<META NAME="copyright" CONTENT="Software propietario de DEVZONE">
<META NAME="rating" CONTENT="General">
<META HTTP-EQUIV="Content-Type" CONTENT="text/html; ISO-8859-1">
<script type="text/javascript">var SERVER='<?=$domain?>'; </script>
<!--Buscador proveedore -->
<link rel="stylesheet" type="text/css" href="css/jquery-ui-1.11.4.css">
<script type="text/javascript" src="js/jquery-1.10.2.js"></script>
<script type="text/javascript" src="js/jquery-ui-1.11.4.custom.js"></script>
<!--END BUSCADOR-->

<!--<script type="text/javascript" src="js/jquery.js"></script>-->
<script language="javascript" type="text/javascript" src="js/ajaxlib.js?version=<?=VERSION?>"></script>
<script type="text/javascript" src="js/pass.js?version=<?=VERSION?>"></script>
<!-- TOOLTIPS DE ACRONYM -->
<script language="javascript" type="text/javascript" src="js/addEvent.js"></script>
<script language="javascript" type="text/javascript" src="js/sweetTitles.js"></script>
<script language="javascript" type="text/javascript" src="js/client.js"></script>
<link rel="stylesheet" href="css/sweetTitles.css" type="text/css" />
<!-- FIN -->
<!--BEGINIMPROMTU-->
<link rel="stylesheet" type="text/css" href="css/impromptu.css">
<script type="text/javascript" src="js/jquery.Impromptu.js"></script>
<!--ENDIMPROMTU--> 
<script type="text/javascript">
   $(function() {
    
    $( ".proveedor" ).autocomplete({
        source: 'code/execute/searchProvSAP.php',
        select: function(event, ui) {
            
        $("#inputProveedor").append('<label>'+ui.item.nit+'</label><br>  ');
        $("#cli_nit_ci").val(ui.item.nit);
        $("#cli_nit_ci").attr('class','input');
        $("#busqueda").hide();
        $("#cli_interno").val(ui.item.id);
        $("#div_cli_interno").hide();
      //  $("#cli_interno").attr('disabled','disabled');
        $("#cli_socialreason").val(ui.item.label);
        $("#div_cli_socialreason").hide();
      //  $("#cli_socialreason").attr('disabled','disabled');
        $("#cli_legaldirection").val(ui.item.street);
        $("#botonRegistrar").show();
        $("#botonOr").show();
        $("#botonCancelar").attr('class', '');

        //$("#busqueda").hide();
        return false; // Prevent the widget from inserting the value.
        
    },
    focus: function(event, ui) {
        $(".proveedor").val('');
        return false; // Prevent the widget from inserting the value.
    }
    })
 })  
</script>
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr><td valign="top"><?php include_once("skin/header.php");?>
</td></tr>
  <tr>
    <td valign="top" id="content"><?php include_once("code/template/clientNewTpl.php"); ?></td>
  </tr>
<tr><td>
  <?php include("skin/footer.php"); ?>
  </td></tr>
</table>
</body>
</html>