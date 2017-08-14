<?php
define (SYS_LANG,$lang);
$maxLine=20;
$order=0; 
//variables para filtros de productos*******************************************
$timeNow= date("Y-m-d H:i:s");//sub_finish<>0
//echo $timeNow;
$maxLine2 = admin::toSql(admin::getParam("maxLineP"),"Number");
if ($maxLine2) {$maxLine=$maxLine2; admin::setSession("maxLineP",$maxLine2);}
else {
		$maxLine2=admin::getSession("maxLineP");
		if ($maxLine2) $maxLine=$maxLine2;
	}

if ($lang=='es') $urlFrontLang='';
else $urlFrontLang=$lang.'/';

$UrlProduct=admin::getDBvalue("select col_url FROM mdl_contents_languages where col_con_uid=3 and col_language='".$lang."'");

$contentURL = admin::getContentUrl($con_uid,SYS_LANG);

?>
<div id="DIV_WAIT1" style="display:none;"><img border="0" src="lib/loading.gif"></div>
<br>

<form name="addImport" method="post" action="code/execute/importAdd.php?token=<?=admin::getParam("token")?>" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="77%" height="40"><span class="title"><?=admin::modulesLabels()?></span></td>
    <td width="23%" height="40">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" id="contentListing"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="50%" valign="top"><table width="98%" border="0" cellpadding="5" cellspacing="5" class="box">
                <tr><td>&nbsp;</td></tr>
         <tr>
            <td colspan="3" class="titleBox">Importar datos</td>
         </tr>
          <tr><td>&nbsp;</td></tr>
         
         <tr>
            <td width="5%" >Borrar datos anteriores:</td>
            <td width="25%" ><select name="imp_del" id="imp_del" class="input" onchange="document.getElementById('div_imp_del').style.display='none';" >
                <option selected="selected" value="" class="txt10">Seleccionar</option>
                    <option value="1">SI</option>					
                    <option value="2" selected="selected">NO</option>					
		</select>
              <div style="display:none" id="div_imp_del"><span class="error">* Campo requerido</span></div>
              <br>
            </td>
                                <td width="7%">&nbsp;</td>
        </tr>
        <tr><td>&nbsp;</td></tr>
	<tr>
            <td width="5%" >Tipo de archivo:</td>
            <td width="25%" ><select name="imp_type" id="imp_type" class="input" onchange="document.getElementById('div_imp_type').style.display='none';" >
                <option selected="selected" value="" class="txt10">Seleccionar</option>
                    <option value="1">Proveedor</option>					
                    <option value="2" selected="selected">Empleado</option>					
		</select>
              <div style="display:none" id="div_imp_type"><span class="error">* Campo requerido</span></div>
            </td>
                                <td width="7%">&nbsp;</td>
        </tr>
        <tr>
            <td width="5%" >Archivo:</td>    
            <td width="20%" ><br>
                 <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Seleccione archivos</span>
                    <!-- The file input field used as target for the file upload widget -->
                    <input id="fileupload" type="file" name="files[]" accept=".csv" onchange="document.getElementById('div_imp_file').style.display='none';">
                </span>
                <br>
                <br>
                <!-- The global progress bar -->
                <div id="progress" class="progress">
                    <div class="progress-bar progress-bar-success"></div>
                </div>
                <!-- The container for the uploaded files -->
                <div id="files" class="files"></div>
                
                <input name="imp_file" id="imp_file" type="hidden" value="">
                <br>
                <div style="display:none" id="div_imp_file"><span class="error">* Campo requerido</span></div>
            <td width="7%">&nbsp;</td>
        </tr>
    </table>
    </form>
</div>
</td></tr>
</table>
    </td>
  </tr>
</table>
</form> 
<script type="text/javascript" >
function validaImport(){
    var typeImp = document.getElementById("imp_type").value;
    var fileImp = document.getElementById("imp_file").value;
    var delImp = document.getElementById("imp_del").value;
    var sw=false;
    
    if(typeImp>0) { sw=true;}
    else{
        document.getElementById("div_imp_type").style.display='';
    }
    
    if(delImp>0) { sw=true;}
    else{
        document.getElementById("div_imp_del").style.display='';
    }
    
    if(fileImp.length>0) { sw=true;}
    else{
        document.getElementById("div_imp_file").style.display='';
    }
    if(sw)
    {
        
         document.addImport.submit();
    }
    
}
</script>

<br />
      <br />
      <div id="contentButton">
	  	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
			<tr>
				<td width="59%" align="center">
				<a href="" onclick="validaImport();return false;" class="button">
				<?=admin::labels('register');?>
				</a> 
				</td>
          <td width="41%" style="font-size:11px;">
		  		<?=admin::labels('or');?> <a href="importList.php?tipUid=<?=$tipUid?>&token=<?=admin::getParam("token")?>" ><?=admin::labels('cancel');?></a> 
		  </td>
        </tr>
      </table></div>
      <br /><br />
<br />
<br />

      <br />
      <br />

