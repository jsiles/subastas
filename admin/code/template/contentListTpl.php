<?php
if ($lang!='es') $urlLangAux=$lang.'/';
else $urlLangAux='';

if ($lang!='es') $UrlHome=$urlLangAux.admin::getDBvalue("select col_url from mdl_contents_languages where col_con_uid=1 and col_language='".$lang."'").'/';
else $UrlHome='';
/**************Begin 1er NIVEL****************************/
$arrayscript = "<script>
subSubList =new Array();
SubList =new Array();
List =new Array();
";
$javascript = "<script type=\"text/javascript\">
$(document).ready(
    function () {

        $('div.itemList').Sortable(
            {
                accept: 'groupItem',
                helperclass: 'sortHelper',
                tolerance: 'pointer', 
                axis: 'vertically',
                onChange : function(sorted)
                {
                    serial = $.SortSerialize('itemList');
                    resetOrder (serial.hash);
                    $.ajax({
                            url: 'code/execute/contentUpdatePosition.php?token=".admin::getParam('token')."',
                            type: 'POST',
                            data: serial.hash
                            });
                },
                onStart : function()
                {
                    $.iAutoscroller.start(this, document.getElementsByTagName('body'));
                },
                onStop : function()
                {
                    $.iAutoscroller.stop();
                }                
            }
        );

";

$sSQL="select * 
		from mdl_contents
		left join mdl_contents_languages on (con_uid=col_con_uid)
		where col_language='".$lang."' and 
			  con_parent=0 and 
			  con_delete<>1 and con_uid in (select mus_mod_uid from sys_modules_users where mus_rol_uid=".$_SESSION["usr_rol"]." and mus_place='CONTENT' and mus_delete=0) order by con_position asc";			

$db->query($sSQL);
$nroReg = $db->numrows();
if ($nroReg>0)
	{
	?>
<br>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
   <tr>
      <td width="77%" height="40"><span class="title"><?=admin::labels('contents','title')?></span></td>
    <td width="23%" height="40" align="right"><a href="contentNew.php?token=<?=admin::getParam("token")?>"><?=admin::labels('contents','create');?></a></td>
  </tr>
  <tr>
    <td colspan="2" id="contentListing">
	<?php
	$regContent = $db->next_record();
	$con_uid = $regContent["con_uid"];
	$title = $regContent["col_title"];
	$cont_status = $regContent["col_status"];   
	if ($cont_status=='ACTIVE') $labels_content='status_on';
	else $labels_content='status_off';

?>
<div id="home" class="row" style="width:99%">
<table class="list" width="100%">
	<tr>
	<td width="50%">
		<span>
		<img src="lib/buttons/more_off.gif" title="<?=admin::labels('more_off')?>" alt="<?=admin::labels('more_off')?>"></span>&nbsp;	
		<?=admin::toHtml($title)?>
	</td>
	<td align="center" width="12%" height="5">
		<a href="../<?=$UrlHome?>" target="_blank">
		<img src="lib/view_es.gif" border="0" title="<?=admin::labels('view')?>" alt="<?=admin::labels('view')?>">
		</a>
	</td>
	<td align="center" width="12%" height="5">
		<a href="contentEdit.php?con_uid=<?=$con_uid?>&wys=off&token=<?=admin::getParam("token");?>">
		<img src="lib/edit_es.gif" border="0" title="<?=admin::labels('edit')?>" alt="<?=admin::labels('edit')?>">
		</a>
	</td>
	<td align="center" width="12%" height="5">
		<img src="lib/delete_off_<?=$lang?>.gif" border="0">
	</td>
	<td align="center" width="14%" height="5">
		<div id="status_<?=$con_uid?>">
        <img src="<?=PATH_DOMAIN?>/admin/lib/active_off_es.gif" border="0" title="<?=admin::labels($labels_content)?>" alt="<?=admin::labels($labels_content)?>">
	  <!-- <a href="javascript:void(0);" onclick="contentCS('<?=$con_uid?>','<?=$cont_status?>');">
		<img src="<?=admin::labels($labels_content,'linkImage')?>" border="0" title="<?=admin::labels($labels_content)?>" alt="<?=admin::labels($labels_content)?>">
		</a>-->
	</div>
	</td>
	</tr>
 </table>
</div>

<div class="itemList" id="itemList" style="width:99%"> 
<?php
$i=1;
while ($regContent = $db->next_record())
{

  $con_uid = $regContent["con_uid"];
  $title = $regContent["col_title"];
  $cont_status = $regContent["col_status"];
  if ($cont_status=='ACTIVE') $labels_content='status_on';
  else $labels_content='status_off';
  if ($i%2==0) $class='row1';
  else  $class='row2';
  $arrayscript .="List[" . $con_uid . "]=1;
     ";
/**************End 1er NIVEL****************************/
/**************Begin 2do NIVEL****************************/     
  ?> 
  <div id="category_<?=$con_uid?>" style="display:none;"><?=$class?></div>
      <div class="groupItem" id="<?=$con_uid?>">
            <div id="list_<?=$con_uid?>" class="<?=$class?>" style="width:100%">
                <table class="list" width="100%"><tr><td width="50%">
<?php
	$sSQL = "select * 
		from mdl_contents 
		left join mdl_contents_languages on (con_uid=col_con_uid) 
		where col_language='" . $lang . "' and 
			  con_parent=" . $con_uid . " and 
			  con_delete<>1 and con_uid in (select mus_mod_uid from sys_modules_users where mus_rol_uid=".$_SESSION["usr_rol"]." and mus_place='CONTENT' and mus_delete=0)
		order by con_position asc";
	$db2->query($sSQL);
	$nrmreg = $db2->numrows();
$j=0;

if ($nrmreg>0) { 

/**************End 2do NIVEL****************************/

/**************Begin 1er NIVEL****************************/    
    ?>
	<span id="div_more_<?=$con_uid?>">
		<a href="subList_<?=$con_uid?>" onclick="moreMinusContent(<?=$con_uid?>); return false;">
			<img src="lib/buttons/more.gif" border="0" alt="<?=admin::labels('more_on')?>" title="<?=admin::labels('more_on')?>">
		</a>
	</span>
	<span id="div_minus_<?=$con_uid?>" style="display:none;">
		<a href="subList_<?=$con_uid?>" onclick="moreMinusContent(<?=$con_uid?>); return false;">
		<img src="lib/buttons/minus.gif" border="0" alt="<?=admin::labels('minus_on')?>" title="<?=admin::labels('minus_on')?>">
		</a>
	</span>
	 <span id="div_more_off_<?=$con_uid?>" style="display:none;">
		<img src="lib/buttons/more_off.gif" title="<?=admin::labels('more_off')?>" alt="<?=admin::labels('more_off')?>">
	</span>&nbsp;
	<?php
/**************End 1er NIVEL****************************/
/**************Begin 2do NIVEL****************************/
	$swSubmenu=true;                              
	}
else { ?>
	<span><img src="lib/buttons/more_off.gif" title="<?=admin::labels('more_off')?>" alt="<?=admin::labels('more_off')?>"></span>&nbsp;
	<?php
	$swSubmenu=false;
	} 
/**************End 2do NIVEL****************************/
/**************Begin 1er NIVEL****************************/    
    ?>
           <?=admin::toHtml($title)?></td>
	<td align="center" width="12%" height="5">
	<?php 
	if ($nrmreg>0) 
		{ 
		$stylebuttonOn = "none";
		$stylebuttonOff = "";
		}
	else
		{ 
		$stylebuttonOn = "";  
		$stylebuttonOff = "none";
		}
		
		$nextUrl=admin::getDBvalue("select col_url from mdl_contents_languages, mdl_contents
WHERE col_con_uid = con_uid and con_parent =".$con_uid." and col_status='ACTIVE' and col_language='".$lang."' order by con_position asc limit 1");
		$nextCon_uid=admin::getDBvalue("select col_con_uid from mdl_contents_languages, mdl_contents
WHERE col_con_uid = con_uid and con_parent =".$con_uid." and col_status='ACTIVE' and col_language='".$lang."' order by con_position asc limit 1");
		if($nextUrl){
			$nextUrl2=admin::getDBvalue("select col_url from mdl_contents_languages, mdl_contents
WHERE col_con_uid = con_uid and con_parent =".$nextCon_uid." and col_status='ACTIVE' and col_language='".$lang."' order by con_position asc limit 1");
			if($nextUrl2){$nextUrl=$nextUrl.'/'.$nextUrl2.'/';}
			else{$nextUrl=$nextUrl.'/';}
		}
		 
		?>
		<span id="div_view_off_<?=$con_uid?>" style="display:<?=$stylebuttonOff?>;">
		<img src="lib/view_off_es.gif" border="0" title="<?=admin::labels('view')?>" alt="<?=admin::labels('view')?>">
		</span>
		<span id="div_view_on_<?=$con_uid?>" style="display:<?=$stylebuttonOn?>;">
		<a href="../<?=$urlLangAux.$regContent["col_url"]?>/<?=$nextUrl?>" target="_blank">
		<img src="lib/view_es.gif" border="0" title="<?=admin::labels('view')?>" alt="<?=admin::labels('view')?>">
		</a>
		</span>
	</td>
	<td align="center" width="12%" height="5">
	<?php 
	/*
	if ($nrmreg>0 && $con_uid!=2) 
		{ 
		$stylebuttonOn = "none";
		$stylebuttonOff = "";
		}
	else
		{ 
		$stylebuttonOn = "";  
		$stylebuttonOff = "none";
		}
	*/
		$stylebuttonOn = "";  
		$stylebuttonOff = "none";

	$wys = $nrmreg ||  $con_uid==4  ? "&wys=off" : "";
		?>
		<span id="div_edit_off_<?=$con_uid?>" style="display:<?=$stylebuttonOff?>;">
		<img src="lib/edit_off_<?=$lang?>.gif" border="0" title="<?=admin::labels('edit')?>" alt="<?=admin::labels('edit')?>">
		</span>
		<span id="div_edit_on_<?=$con_uid?>" style="display:<?=$stylebuttonOn?>;">
		<a href="contentEdit.php?con_uid=<?=$con_uid?><?=$wys?>&token=<?=admin::getParam("token");?>">
		<img src="lib/edit_es.gif" border="0" title="<?=admin::labels('edit')?>" alt="<?=admin::labels('edit')?>">
		</a>
		</span>
	</td>
	<td align="center" width="12%" height="5">
	<?php 
	if ( $con_uid!=4 && !$nrmreg ) 
		{ ?>
		<a href="removeList" onclick="removeList(<?=$con_uid?>,<?=$con_uid?>,1);return false;">		
			<img src="lib/delete_es.gif" border="0" title="<?=admin::labels('delete')?>" alt="<?=admin::labels('delete')?>">
		</a>		
	<?php 	} 
	else
		{ ?>		
		<img src="lib/delete_off_<?=$lang?>.gif" border="0">
	<?php	} ?>
	</td>
	<td align="center" width="14%" height="5">
	<div id="status_<?=$con_uid?>">
	   <a href="javascript:void(0);" onclick="contentCS('<?=$con_uid?>','<?=$cont_status?>');">
		<img src="<?=admin::labels($labels_content,'linkImage')?>" border="0" title="<?=admin::labels($labels_content)?>" alt="<?=admin::labels($labels_content)?>">
		</a>
	</div>
	</td>
		</tr>
	</table>
<?php
//CREACION DE SUB MENU
//echo "-->" . $swSubmenu;die;
/**************End 1er NIVEL****************************/
/**************Begin 2do NIVEL****************************/
if ($swSubmenu){
	echo "\n";
    ?>
	<div class="subList_<?=$con_uid?>" id="subList_<?=$con_uid?>" style="display:none;width:100%">
	<?php
	}   
if ($nrmreg>0) $arrayscript .="
 SubList[$con_uid]=$nrmreg;
 ";	
 
if ($nrmreg>1){
    $javascript .= "
        $('div.subList_$con_uid').Sortable(
            {
                accept: 'groupItem_$con_uid',
                helperclass: 'sortHelper',
                tolerance: 'pointer', 
                axis: 'vertically',
                onChange : function(ser)
                {
                    serial = $.SortSerialize('subList_$con_uid');
                    $.ajax({
                            url: 'code/execute/contentUpdatePosition.php?token=".admin::getParam('token')."',
                            type: 'POST',
                            data: serial.hash
                            }); 
                },
                onStart : function()
                {
                    $.iAutoscroller.start(this, document.getElementsByTagName('body'));
                },
                onStop : function()
                {
                    $.iAutoscroller.stop();
                }
            }
        );

";
 } 
while ($regSubContent=$db2->next_record()){
   $con_uid1 = $regSubContent["con_uid"];
   $title1 = $regSubContent["col_title"]; 
   $cont_status1 = $regSubContent["col_status"];   
  if ($cont_status1 =='ACTIVE') $labels_content1='status_on';
  else $labels_content1='status_off'; 
     
?>
<div class="groupItem_<?=$con_uid?>" id="<?=$con_uid1?>">
    <table class="list1a" width="100%"><tr><td width="50%">
    <li id="lista_<?=$con_uid1?>" class="<?=$class?>a">
<?php
/**************End 2do NIVEL****************************/
/**************Begin 3er NIVEL****************************/ 
    $sSQL = "select * 
        from mdl_contents 
        left join mdl_contents_languages on (con_uid=col_con_uid) 
        where col_language='" . $lang . "' and 
			  con_parent=".$con_uid1." and 
			  con_delete<>1
        order by con_position asc";

    $db3->query($sSQL);
    $nrmreg1 = $db3->numrows();
    $k=0;
    if ($nrmreg1>0) { ?>
                        <span id="div_more_<?=$con_uid1?>">
                            <a href="treeList_<?=$con_uid1?>" onclick="moreMinusSubList(<?=$con_uid1?>); return false;">
                                <img src="lib/buttons/more.gif" border="0" alt="<?=admin::labels('more_on')?>" title="<?=admin::labels('more_on')?>">
                            </a>
                        </span>
                        <span id="div_minus_<?=$con_uid1?>" style="display:none;">
                            <a href="treeList_<?=$con_uid1?>" onclick="moreMinusSubList(<?=$con_uid1?>); return false;">
                            <img src="lib/buttons/minus.gif" border="0" alt="<?=admin::labels('minus_on')?>" title="<?=admin::labels('minus_on')?>">
                            </a>
                        </span>
                        <span id="div_more_off_<?=$con_uid1?>" style="display:none;">
                        <img src="lib/buttons/more_off.gif" title="<?=admin::labels('more_off')?>" alt="<?=admin::labels('more_off')?>">
                        </span>&nbsp;         
                    
        <?php
        $swSubmenu1=true;                              
        }
    else {
        ?>
                    <span><img src="lib/buttons/more_off.gif" title="<?=admin::labels('more_off')?>" alt="<?=admin::labels('more_off')?>"></span>&nbsp;
        <?php
        $swSubmenu1=false;
        } 
/**************End 3er NIVEL****************************/
/**************Begin 2do NIVEL****************************/
    ?>    
            <?=admin::toHtml($title1)?></li></td>
            <td align="center" width="12%" height="5">
    <?php 
    if ($nrmreg1>0){ 
        $stylebuttonOn = "none";
        $stylebuttonOff = "";
    }
    else{ 
        $stylebuttonOn = "";  
        $stylebuttonOff = "none";
    }
        ?>
        <span id="div_view_off_<?=$con_uid1?>" style="display:<?=$stylebuttonOff?>;">
        <img src="lib/view_off_es.gif" border="0" title="<?=admin::labels('view')?>" alt="<?=admin::labels('view')?>">
        </span>
        <span id="div_view_on_<?=$con_uid1?>" style="display:<?=$stylebuttonOn?>;">
        <a href="../<?=$urlLangAux.$regContent["col_url"]?>/<?=$regSubContent["col_url"]?>/" target="_blank">
        <img src="lib/view_es.gif" border="0" title="<?=admin::labels('view')?>" alt="<?=admin::labels('view')?>">
        </a>
        </span>
    </td>
<td align="center" width="12%" height="5">
    <?php 
    if ($nrmreg1>0 && $con_uid!=2) { 
        $stylebuttonOn = "none";
        $stylebuttonOff = "";
    }
    else{ 
        $stylebuttonOn = "";  
        $stylebuttonOff = "none";
    }
    if ($con_uid==8 || $con_uid==9 ) $wys= "&wys=off";
    else $wys="";
    
        ?>
        <span id="div_edit_off_<?=$con_uid1?>" style="display:<?=$stylebuttonOff?>;">
        <img src="lib/edit_off_<?=$lang?>.gif" border="0" title="<?=admin::labels('edit')?>" alt="<?=admin::labels('edit')?>">
        </span>
        <span id="div_edit_on_<?=$con_uid1?>" style="display:<?=$stylebuttonOn?>;">
        <a href="contentEdit.php?con_uid=<?=$con_uid1?><?=$wys?>&token=<?=admin::getParam("token");?>">
        <img src="lib/edit_es.gif" border="0" title="<?=admin::labels('edit')?>" alt="<?=admin::labels('edit')?>">
        </a>
        </span>
    </td>

            
			        
	        <td align="center" width="12%" height="5">
		          <a href="removeList" onclick="removeList(<?=$con_uid1?>,<?=$con_uid?>,2);return false;">  
		        <img src="lib/delete_es.gif" border="0" title="<?=admin::labels('delete')?>" alt="<?=admin::labels('delete')?>">
		        </a>
	        </td>
	        <td align="center" width="14%" height="5">
	        <div id="status_<?=$con_uid1?>">
	           <a href="javascript:void(0);" onclick="contentCS('<?=$con_uid1?>','<?=$cont_status1?>');">
		        <img src="<?=admin::labels($labels_content1,'linkImage')?>" border="0" title="<?=admin::labels($labels_content1)?>" alt="<?=admin::labels($labels_content1)?>">
		        </a>
	        </div>	
	        </td></tr>
            </table>

<?php
/**************End 2do NIVEL****************************/
/**************Begin 3er NIVEL****************************/ 
//echo "-->" . $swSubmenu;die;
if ($swSubmenu1){ 

  //echo "\n";
    ?>
    <div class="treeList_<?=$con_uid1?>" id="treeList_<?=$con_uid1?>" style="display:none;width:100%">
                                        
    <?php
}   
if ($nrmreg1>0) $arrayscript .="
 subSubList[$con_uid1]=$nrmreg1;";
 
if ($nrmreg1>1){
    $javascript .= "
        $('div.treeList_$con_uid1').Sortable(
            {
                accept: 'groupSubItem_$con_uid1',
                helperclass: 'sortHelper',
                tolerance: 'pointer', 
                axis: 'vertically',
                onChange : function(ser)
                {
                    serial = $.SortSerialize('treeList_$con_uid1');
                    $.ajax({
                            url: 'code/execute/contentUpdatePosition.php',
                            type: 'POST',
                            data: serial.hash
                            }); 
                },
                onStart : function()
                {
                    $.iAutoscroller.start(this, document.getElementsByTagName('body'));
                },
                onStop : function()
                {
                    $.iAutoscroller.stop();
                }
            }
        );

";
 } 
while ($regSubSubContent=$db3->next_record()){
	$con_uid2 = $regSubSubContent["con_uid"];
	$title2 = $regSubSubContent["col_title"]; 
	$cont_status2 = $regSubSubContent["col_status"]; 
	if ($cont_status2 =='ACTIVE') $labels_content2='status_on';
	else $labels_content2='status_off';   
	?>
	<div class="groupSubItem_<?=$con_uid1?>" id="<?=$con_uid2?>">
	<table class="list2a" width="100%" border="0"><tr><td width="49%">
	<li id="lista_<?=$con_uid2?>" class="<?=$class?>b">
	<?=admin::toHtml($title2)?></li>
	</td><td align="center" width="13%" height="5">
	<a href="<?=SERVER.$urlLangAux.admin::urlsFriendly($title)."/".admin::urlsFriendly($title1)."/".admin::urlsFriendly($title2)."/"?>" target="_blank"><img src="lib/view_es.gif" border="0" alt="<?=admin::labels('view')?>" title="<?=admin::labels('view')?>"></a></td>
	<td align="center" width="11%" height="5">
	<a href="contentEdit.php?con_uid=<?=$con_uid2?>&token=<?=admin::getParam("token");?>"><img src="lib/edit_es.gif" border="0" alt="<?=admin::labels('edit')?>" title="<?=admin::labels('edit')?>"></a></td>            
	<td align="center" width="13%" height="5">
		<a href="removeList" onclick="removeList(<?=$con_uid2?>,<?=$con_uid1?>,3);return false;">
		<img src="lib/delete_es.gif" border="0" title="<?=admin::labels('delete')?>" alt="<?=admin::labels('delete')?>">		</a>	</td>
	<td align="center" width="14%" height="5">
	<div id="status_<?=$con_uid2?>">
	   <a href="javascript:contentCS('<?=$con_uid2?>','<?=$cont_status2?>');">
		<img src="<?=admin::labels($labels_content2,'linkImage')?>" border="0" title="<?=admin::labels($labels_content)?>" alt="<?=admin::labels($labels_content)?>">
	   </a>
	</div>    
	</td></tr>
	</table>
	</div>                                        
<?php

$k++;
}
if ($swSubmenu1){
?>
                                     </div>
                                     </div>
<?php
} 
else{
?> 
                                  </div>
<?php
}
/**************End 3er NIVEL****************************/

$j++;    
}
/**************Begin 2do NIVEL****************************/  
if ($swSubmenu){
	?>
	</div>
	<?php
}
$i++;
?>
	</div>
</div>
<?php
}  
/**************End 2do NIVEL****************************/
/**************Begin 1er NIVEL****************************/
?>

</div>
    </td>
    </tr>
</table><br />
<br />
<br />
<?php
} 
else{ ?>
	<br />
<br />
<div id="itemList"> 
</div>
<table width="100%" border="0" cellspacing="0" cellpadding="0">   
  <tr>
    <td colspan="2" id="contentListing">
<div  style="background-color: #f7f8f8;">
<table class="list"  width="100%">
	<tr><td height="30px" align="center" class="bold">
	No existen registros.
	</td></tr>	
 </table>
</div>
</td></tr></table>
<?php 	
} 
$javascript .= "
    }
);
function serialize(s)
{
    serial = $.SortSerialize(s);
    alert(serial.hash);
};
function resetOrder(valores)
   {
       var array = valores.split('&');
       var vector = new Array();
         for (i=0;i<array.length;i++)
         {
            vector[i] = array[i].replace('itemList[]=','');
         }
         for (i=0;i<vector.length;i++)
         {
            if (i%2!=0) document.getElementById('list_'+ vector[i]).className='row1';
            else document.getElementById('list_'+ vector[i]).className='row2';
         }

   }
function resetOrderRemove(valores,uid)
   {
       var array = valores.split('&');
       var vector = new Array();
       var nvector = new Array();
         for (i=0;i<array.length;i++)
         {
              vector[i] = array[i].replace('itemList[]=','');
         }
         j=0;
         for (i=0;i<vector.length;i++)
         {
             if (vector[i]!=uid)
             {
               nvector[j]= vector[i]; 
               j++; 
             }
         }
         for (i=0;i<nvector.length;i++)
         {
            if (i%2!=0) document.getElementById('list_'+ nvector[i]).className='row1';
            else document.getElementById('list_'+ nvector[i]).className='row2';
         }

   }
</script>";
$arrayscript .= "</script>";
echo $arrayscript;
echo $javascript;
/**************End 1er NIVEL****************************/ 
?>