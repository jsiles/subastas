<?php
include_once("../../core/admin.php");
admin::initialize('subastas','docsCatAdd2',false); 
$inl_name=admin::getParam("inl_name");
$maxUid=admin::getDBvalue("SELECT max(inl_uid) FROM mdl_incoterm_language");
$maxUid++;
// REGISTRANDO LENGUAGE DE LAS CATEGORIAS
$sql = "insert into mdl_incoterm_language(
					inl_uid,
					inl_name,
					inl_delete
					)
				values
					(
						'".$maxUid."', 
						'".$inl_name."',
						0
					)";
$db->query($sql);	
?>
<select name="inc_inl_uid" id="inc_inl_uid" class="input"  >
                	<?
                    $sql = "select inl_uid, inl_name from mdl_incoterm_language where inl_delete=0";
					$db2->query($sql);
					while ($content=$db2->next_record())
					{	
					?>
					<option value="<?=$content["inl_uid"]?>"><?=$content["inl_name"]?></option>					
					<?
					}
                    ?>
				</select>
                <a href="nuevo" onclick="changeOtherIncoterm();return false;" class="small2"><?=strtolower(admin::labels('add'));?></a> | 
                <a href="borrar" onclick="deleteOtherIncoterm();return false;" class="small3"><?=admin::labels('del');?></a>