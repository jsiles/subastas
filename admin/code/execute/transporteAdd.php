<?php
include_once("../../core/admin.php");
admin::initialize('subastas','docsCatAdd2',false); 
$tra_name=admin::getParam("tra_name");
$maxUid=admin::getDBvalue("SELECT max(tra_uid) FROM mdl_transporte");
$maxUid++;
// REGISTRANDO LENGUAGE DE LAS CATEGORIAS
$sql = "insert into mdl_transporte(
					tra_uid,
					tra_name, 
					tra_delete
					)
				values
					(
						'".$maxUid."', 
						'".$tra_name."', 
						0
					)";
$db->query($sql);	
// CONSTRUIMOS EL NUEVO SELECT	
?>
<select name="inc_tra_uid" id="inc_tra_uid" class="input"  >
                	<?
                    $sql = "select tra_uid, tra_name from mdl_transporte where tra_delete=0";
					$db2->query($sql);
					while ($content=$db2->next_record())
					{	
					?>
					<option value="<?=$content["tra_uid"]?>"><?=$content["tra_name"]?></option>					
					<?
					}
                    ?>
				</select>
                <a href="nuevo" onclick="changeOtherTransporte();return false;" class="small2"><?=strtolower(admin::labels('add'));?></a> | 
                <a href="borrar" onclick="deleteOtherTransporte();return false;" class="small3"><?=admin::labels('del');?></a>