<?php
include_once("../admin/core/admin.php");
$deadTime = admin::getParam("deadTime");

$deadTime1 = admin::getParam("deadTime1");
$sub_uid = admin::getParam("sub_uid");
$mount = admin::getParam("mount");
$pro_uid=admin::getDBvalue("SELECT pro_uid FROM mdl_product where pro_sub_uid=$sub_uid");
$catUid=admin::getDBvalue("SELECT sub_pca_uid FROM mdl_subasta where sub_uid=$sub_uid");
$sql="insert into mdl_bid values(null, $sub_uid, $pro_uid, 0, $mount,$mount, '".$deadTime."',$catUid)";
$db->query($sql);
$sql="update mdl_subasta set sub_deadtime='".$deadTime1."' where sub_uid=$sub_uid";
$db->query($sql);
//echo $sql;
$sql = "SELECT * FROM mdl_product, mdl_subasta, mdl_pro_category WHERE sub_uid=pro_sub_uid and sub_pca_uid=pca_uid and sub_delete=0 and sub_deadTime>'".$deadTime."' and sub_uid=".$sub_uid;
$db->query($sql);
//echo $sql;
$details = $db->next_record();
$moneda = admin::getDbValue("select cur_description from mdl_currency where cur_uid='".$details["sub_moneda"]."'");
	
$timetobe=admin::time_diff($details["sub_hour_end"],date('Y-m-d H:i:s'));
$timedead=admin::time_diff($details["sub_deadtime"],date(
'Y-m-d H:i:s'));
$finish=$details["sub_finish"];
$timeSubasta = $details["sub_tiempo"];
$quantityDates = ceil(((($details["sub_mountdead"]-$details["sub_mount_base"])/($details["sub_mount_unidad"]))+1));
//echo $quantityDates."<br>".$details["sub_hour_end"];
$yearTD = substr($details["sub_hour_end"],0,4);
$monthTD = substr($details["sub_hour_end"],5,2);
$dayTD = substr($details["sub_hour_end"],8,2);
$hourTD = substr($details["sub_hour_end"],11,2);
$minuteTD = substr($details["sub_hour_end"],14,2);
$secondTD = substr($details["sub_hour_end"],17,2);
//echo $hourTD."-".$minuteTD."-".$secondTD."<br>";
$sw=false;				
$fechahora=date('Y-m-d H:i:s');
$l=0;
for($k=1;$k<=$quantityDates;$k++)
{
$valTime = $k * $details["sub_tiempo"];
$arrayTime[$k] = date('Y-m-d H:i:s', mktime($hourTD,$minuteTD+$valTime,$secondTD,$monthTD,$dayTD,$yearTD));
$diffTime[$k] =admin::time_diff($arrayTime[$k],$fechahora);
if($diffTime[$k]>0) $sw=true;
if($details["sub_type"]=="COMPRA")
$mountBase[$k]=($details["sub_mount_base"]+($l*$details["sub_mount_unidad"]));
else
$mountBase[$k]=($details["sub_mount_base"]-($l*$details["sub_mount_unidad"]));
$l++;
}
/*echo "<br>";
print_r($arrayTime);
echo "<br>";
print_r($diffTime);
echo "<br>";
print_r($mountBase);
echo "<br>";
echo $timedead."<br>".$details["sub_deadtime"]."<br>".$sw;
*/
if (($timetobe>0)&&($finish==0)){
$daystobe=intval($timetobe/86400);
$timetobe=$timetobe-($daystobe*86400);
$hourstobe=intval($timetobe/3600);
$timetobe=$timetobe-($hourstobe*3600);
$minutetobe=intval($timetobe/60);
$timetobe=$timetobe-($minutetobe*60);
$faltante =$daystobe.'d '.$hourstobe.'h '.$minutetobe.'m '.$timetobe.'s ';
$timeInicio = 1;
$m=1;
}
elseif(($sw)&&($finish==0))
{
$faltante='Iniciada';
for($k=1;$k<=$quantityDates;$k++)
{
	if($diffTime[$k]>0) { $timedead=$diffTime[$k]; $m=$k; break;}
}

$daysdead=intval($timedead/86400);
$timedead=$timedead-($daysdead*86400);
$hoursdead=intval($timedead/3600);
$timedead=$timedead-($hoursdead*3600);
$minutedead=intval($timedead/60);
$timedead=$timedead-($minutedead*60);
$timeInicio = 2;
}else {
	$faltante='Concluida';
	$daystobe=0;
	$hourstobe=0;
	$minutetobe=0;
	$timetobe=0;
	$timeInicio = 3;
	$m=ceil(((($details["sub_mountdead"]-$details["sub_mount_base"])/($details["sub_mount_unidad"]))+1));
	}
$regBidsWin = admin::getDbValue("select max(bid_uid) from mdl_bid where bid_sub_uid = ".$details["sub_uid"]." and bid_cli_uid=".admin::getSession("uidClient"));
									if(isset($regBidsWin))
									{
									$regBidsWinMax = admin::getDbValue("select max(bid_uid) from mdl_bid where bid_sub_uid = ".$details["sub_uid"]);
									if($regBidsWin==$regBidsWinMax) $winMessage="Su oferta gan&oacute;";
									else
									$winMessage="Su oferta perdi&oacute;";
									}	
									
?>
<script type="text/javascript">
$(function () {
	<?php
	if($timeInicio==1)
	{
		
	?>
	var austDay = new Date();
	austDay = new Date(austDay.getFullYear() ,austDay.getMonth() ,austDay.getDate()+<?=$daystobe?>, austDay.getHours()+<?=$hourstobe?>, austDay.getMinutes()+<?=$minutetobe?>,austDay.getSeconds()+<?=$timetobe?>);
	$('#defaultCountdown').countdown({until: austDay,format: 'HMS',onExpiry: subastaOn});
	<?php
	}elseif($timeInicio==2){
	?>
	bids();
	$("#tiempoRestante").html('Fecha cierre de la subasta:');
	$('#defaultCountdown').html('<?=admin::changeFormatDate($details["sub_deadtime"],7)?>');
	$("#tiempoSubasta").show();
	$("#subastaP").fadeIn('slow');	
	var subastaDay = new Date();
	subastaDay = new Date(subastaDay.getFullYear() ,subastaDay.getMonth() ,subastaDay.getDate()+<?=$daysdead?>, subastaDay.getHours()+<?=$hoursdead?>, subastaDay.getMinutes()+<?=$minutedead?>,subastaDay.getSeconds()+<?=$timedead?>);
	$('#defaultCountdown1').countdown({until: subastaDay,format: 'MS',onExpiry: subastaOff});
	<?php 
	}else{
	?>
	$("#tiempoRestante").html('Fecha de la subasta:');
	$('#defaultCountdown').html('<?=admin::changeFormatDate($details["sub_deadtime"],7)?>');
	$("#tiempoSubasta").show();
	subastaOff();
	<?php
	}
	?>
});
function bids()
{
	$.ajax({
	   type: "POST",
	   url: "<?=$domain?>/code/valBids2.php",
	   data: "deadTime="+'<?=$details["sub_deadtime"]?>'+"&sub_uid="+<?=$details["sub_uid"]?>,
	   success: function(valBids){
		 if(valBids==1) setTimeout(function(){bids();},1000);
		 else $("#subastaDetail").html(valBids); 
	   }
	 });
	
	}
function subastaOn()
{
	bids();
	$("#tiempoSubasta").show();
	$("#subastaP").fadeIn('slow');	
	$("#tiempoRestante").html('Fecha de la subasta:');
	$('#defaultCountdown').html('<?=admin::changeFormatDate($details["sub_deadtime"],7)?>');

	var subastaDay = new Date();
	subastaDay = new Date(subastaDay.getFullYear() ,subastaDay.getMonth() ,subastaDay.getDate(), subastaDay.getHours(), subastaDay.getMinutes()+<?=$timeSubasta?>,subastaDay.getSeconds());
	$('#defaultCountdown1').countdown({until: subastaDay,format: 'MS',onExpiry: subastaOff});

}
function subastaReload()
{
	$.ajax({
	   type: "POST",
	   url: "<?=$domain?>/code/valBidsHolandesa.php",
	   data: "deadTime="+'<?=$arrayTime[$m]?>'+"&sub_uid="+<?=$details["sub_uid"]?>+"&mount="+'<?=$mountBase[$m]?>'+"&deadTime1="+'<?=$arrayTime[$m+1]?>',
	   success: function(valBids){
		 //alert(valBids);
		 //js window.location.reload();
		 location.reload();
		 //$("#subastaDetail").html(valBids);
	   }
	 });

}
function subastaOff()
{
	if(<?=$m?><<?=$quantityDates?>)
	subastaReload(); 
	else
	{
	var message = $("#message").html();
	if(!message ) message ='';
	$("#subastaP").hide();
	$("#unidadmejora").hide();
	$.ajax({
	   type: "POST",
	   url: "<?=$domain?>/code/finish.php",
	   data: "deadTime="+'<?=$details["sub_deadtime"]?>'+"&sub_uid="+<?=$details["sub_uid"]?>,
	      success: function(finish){
		 $("#defaultCountdown1").html(finish);
		 <?php
		 if($details["sub_finish"]==0)
		 {
		 ?>
		  jQuery.facebox('<form name="formBids" class="formLabel">La subasta fue concluida, '+ message+' gracias por participar!!<br><br><a href="Cerrar" onclick="$.facebox.close();return false;" class="addcart">Cerrar</a></p></form><br>');
		  <?php
		 }
		  ?>
	   }
	 });
	}
}
</script>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loading_image : '<?=$domain?>/loading.gif',
        close_image   : '<?=$domain?>/closelabel.gif'
      }) 
    })
  </script>
<div id="subastaDetail" class="details">
                                <?php
								   $bidsCompra=admin::getDBvalue("SELECT sub_type FROM mdl_subasta where sub_uid='".$details["sub_uid"]."'");
									if($bidsCompra=='COMPRA') 
									$valBids=admin::getDBvalue("SELECT max(bid_mount) FROM mdl_bid where bid_pro_uid='".$details["pro_uid"]."' and bid_cli_uid!=0");
									else
									$valBids=admin::getDBvalue("SELECT min(bid_mount) FROM mdl_bid where bid_pro_uid='".$details["pro_uid"]."' and bid_cli_uid!=0");
																		$factor = admin::getDbValue("select inc_ajuste from mdl_incoterm where inc_delete=0 and inc_cli_uid=".admin::getSession("uidClient")." and inc_sub_uid=".$details["sub_uid"]);
									
								if(!$valBids) 
								    {
										$centavos='00';//substr($mountBase[$m],-3);
										$montoGlobal=$mountBase[$m];
										$valBids=$mountBase[$m];
										}
									else
									{
										$centavos='00';//substr($valBids,-3);
										$montoGlobal=$valBids;
										}
								
									//$centavos=str_replace('.','',$centavos);
									
								?>
									<p class="left">Precio: <?=$moneda?> <?=$montoGlobal?>.<sup><?=$centavos?></sup></p>
                                    <div class="clear"></div>
                                    <?php
                                    if($factor)
									{
									?>
                                     <p class="left"> Factor de ajuste:<?=$factor?>%
                                    <div class="clear"></div>
                                    <?php
									}
                                /*    if($regBids>0)
									{
									?><p class="left">
                                    Listado de pujas:<a href="<?=$domain?>/code/listBids.php?_keycode=<?=SymmetricCrypt::encrypt(base64_encode($details["sub_uid"]))?>" rel="facebox"><label style="color:#00F"><?=$regBids?></label> puja(s)</a>
                                    <div class="clear"></div>
                                   <?php
								   if(isset($regBidsWin))
								   {
									if(($regBidsWin==$regBidsWinMax)&&($details["sub_finish"]==0))
									{   
								   ?>
                                   		<p class="left" style="color:#00F">
                                    Su oferta est&aacute; ganando</p><p style="display:none" class="rigth" id="message">
                                    felicidades su oferta ganan&oacute;</p>
                                    <div class="clear"></div>
                                    <?php
									}elseif(($regBidsWin!=$regBidsWinMax)&&($details["sub_finish"]==0))
									{
									?>
                                   		<p class="left" style="color:#00F">
                                    Su oferta est&aacute; perdiendo</p><p style="display:none" class="rigth" id="message">
                                    lo sentimos su oferta perdio</p>
                                    <div class="clear"></div>
                                    <?php
										
										}else
										{

									?>
                                   		<p class="left">
                                    <?=$winMessage?></p>
                                    <div class="clear"></div>
                                    <?php
											
											}
								   }
								   
								   }*/
                                    ?><p class="left" id="tiempoRestante" style="display:">Tiempo de inicio:&nbsp; 
 <div id="defaultCountdown" class="defCountDown"></div>
 </p>

<p class="left" id="tiempoSubasta" style="display:none">Tiempo de subasta:&nbsp;
 <div id="defaultCountdown1" class="defCountDown"></div>
 </p>

										<form name="frmContact" id="formA" action="" method="post">
		<p id="subastaP" style="display:none;">
			<label class="bold">Oferta:</label>
			<input name="ct_value" id="ct_value" type="hidden" size="15" class="inputB" value="<?=$mountBase[$m]?>"/> <a href="<?=$domain?>/code/bids2.php?uid=<?=$details["sub_uid"]?>&ofert=<?=$mountBase[$m]?>"  id="planCuentas" rel="facebox" class="addcart">Aceptar</a>
        </p>
      
									  <p id="unidadmejora"><label class="bold">Unidad de Mejora:</label> <?=$moneda?> <?=$details["sub_mount_unidad"]?></p>
                                    
           <input type="hidden" name="hOk" id="hOk" value="" />
            <input type="hidden" name="domain" id="domain" value="<?=$domain?>" />
            <input type="hidden" name="uid" id="uid" value="<?=$details["sub_uid"]?>" />
</form>
                    </div>
            
