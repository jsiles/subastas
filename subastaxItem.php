<?php
include_once("admin/core/admin.php");
admin::initializeClient();
//$sql = "SELECT * FROM mdl_product, mdl_subasta, mdl_pro_category WHERE sub_uid=pro_sub_uid and sub_pca_uid=pca_uid and sub_delete=0 and pro_url='".$urlSubTitle2."'";
//$db->query($sql);
//$details = $db->next_record();

if ($content_details["col_metatitle"]) $seo = ucfirst(strtolower($content_details["col_metatitle"])).' &gt; ';
else $seo=' ';

if(file_exists(PATH_ROOT.'/img/subasta/img_'.$details["pro_image"]))
{
	$image1 = PATH_ROOT.'/img/subasta/img_'.$details["pro_image"];
	list($width, $height) = getimagesize($image1);
}
	if ($width<132) $maxAncho=132-$width;
	else $maxAncho=0;
$sub_uid=$details["sub_uid"];
    $sql = "update mdl_round set rou_flag0=1 where  rou_datetime < GETDATE()  and rou_sub_uid=$sub_uid";
    
    $db->query($sql);
    $sql = "update mdl_round set rou_flag0=0 where  rou_datetime > GETDATE()  and rou_sub_uid=$sub_uid";
    $db->query($sql);        
        
$getTimeDead = admin::getDbValue("select top 1 rou_datetime from mdl_round where rou_sub_uid=".$details["sub_uid"]." and rou_flag0=0 order by rou_uid asc");        
$wheel = admin::getDbValue("select top 1 rou_round from mdl_round where rou_sub_uid=".$details["sub_uid"]." and rou_flag0=0 order by rou_uid asc");  
if(!$wheel) $wheel=0;
$timetobe=admin::time_diff($details["sub_hour_end"],date('Y-m-d H:i:s'));
$timedead=admin::time_diff($getTimeDead,date('Y-m-d H:i:s'));
$finish=$details["sub_finish"];
$timeSubasta = $details["sub_tiempo"];
//$quantityDates = ceil(((($details["sub_mountdead"]-$details["sub_mount_base"])/($details["sub_mount_unidad"]))+1));
$yearTD = substr($details["sub_hour_end"],0,4);
$monthTD = substr($details["sub_hour_end"],5,2);
$dayTD = substr($details["sub_hour_end"],8,2);
$hourTD = substr($details["sub_hour_end"],11,2);
$minuteTD = substr($details["sub_hour_end"],14,2);
$secondTD = substr($details["sub_hour_end"],17,2);
$sw=false;				
$fechahora=date('Y-m-d H:i:s');
$l=0;
/*echo "hour end:". $details["sub_hour_end"]."<br>";
echo "hora-minuto-segundo:".$hourTD."-".$minuteTD."-".$secondTD."<br>";
echo "noow:".date("Y/m/d H:i:s");
echo "<br>";
echo "timedead:".$timedead."<br>"."sub_deadtime:".$details["sub_deadtime"]."<br>".$sw;*/

if ($timetobe>0){
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
elseif($timedead>0)
{
$faltante='Iniciada';
//echo $faltante;
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
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title></title>
<meta name="keywords" content="" />
<meta name="description" content="" />
<link href="<?=$domain?>/css/style.css" rel="stylesheet" type="text/css" media="all" />
<link rel="shortcut icon" href="<?=$domain?>/lib/favicon.ico" />
<script type="text/javascript">var SERVER='<?=$domain?>'; </script>
<script type="text/javascript" src="<?=$domain?>/js/jquery.js"></script>
<script type="text/javascript" src="<?=$domain?>/js/admin.js"></script>
<link href="<?=$domain?>/css/facebox.css" media="screen" rel="stylesheet" type="text/css"/>
<script src="<?=$domain?>/js/facebox.js" type="text/javascript"></script>
<script src="<?=$domain?>/js/jquery.fcbkcomplete.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=$domain?>/js/jquery.countdown.js" type="text/javascript" charset="utf-8"></script>
<script src="<?=$domain?>/js/jquery.countdown-es.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
$(function () {
    setInterval(function(){
   $.get('<?=$domain?>/code/keepalive.php');
}, 300000);

	<?php
	if($timeInicio==1)
	{
		
	?>
	var austDay = new Date();
	austDay = new Date(austDay.getFullYear() ,austDay.getMonth() ,austDay.getDate()+<?=$daystobe?>, austDay.getHours()+<?=$hourstobe?>, austDay.getMinutes()+<?=$minutetobe?>,austDay.getSeconds()+<?=$timetobe?>);
	$('.defCountDown').countdown({until: austDay,format: 'HMS',onExpiry: subastaOn});
	<?php
	}elseif($timeInicio==2){
	?>
	bids();
        $(".subastandose").show();
	$(".tiempoRestante").html('Fecha cierre de la compra:');
	$('.defCountDown').html('<?=admin::changeFormatDate($details["sub_deadtime"],7)?>');
	$(".tiempoSubasta").show();
	$(".subastaP").fadeIn('slow');	
	var subastaDay = new Date();
	subastaDay = new Date(subastaDay.getFullYear() ,subastaDay.getMonth() ,subastaDay.getDate()+<?=$daysdead?>, subastaDay.getHours()+<?=$hoursdead?>, subastaDay.getMinutes()+<?=$minutedead?>,subastaDay.getSeconds()+<?=$timedead?>);
	$('.defCountDown1').countdown({until: subastaDay,format: 'MS',onExpiry: subastaReload});
	<?php 
	}else{
	?>
	$(".tiempoRestante").html('Fecha de la compra:');
	$('.defCountDown').html('<?=admin::changeFormatDate($details["sub_deadtime"],7)?>');
	$(".tiempoSubasta").show();
	subastaOff();
	<?php
	}
	?>
});
function bids()
{
    
	$.ajax({
	   type: "POST",
	   url: "<?=$domain?>/code/valBidsIt.php",
	   data: "sub_type="+'<?=$details["sub_type"]?>'+"&sub_uid="+<?=$details["sub_uid"]?>,
	   success: function(valBids){
		 if(valBids){
                     setTimeout(function(){bids();},1000);
                     var data = valBids.split("|");
                     //alert(data[0]);
                     for(i=0;i<data.length;i++){
                     var datos = data[i].split(";");
                     $(function() {
                        var myId = '#p_'+ datos[0];
                            $(myId).html(datos[1]);
                          });
                     
                 }
             }
		}
	 });
}
function subastaOn()
{
	bids();
        $(".subastandose").show();
	$(".tiempoSubasta").show();
	$(".subastaP").fadeIn('slow');	
	$(".tiempoRestante").html('Fecha de la compra:');
	$('.defCountDown').html('<?=admin::changeFormatDate($details["sub_deadtime"],7)?>');

	var subastaDay = new Date();
	subastaDay = new Date(subastaDay.getFullYear() ,subastaDay.getMonth() ,subastaDay.getDate(), subastaDay.getHours(), subastaDay.getMinutes()+<?=$timeSubasta?>,subastaDay.getSeconds());
	$('.defCountDown1').countdown({until: subastaDay,format: 'MS',onExpiry: subastaReload});
}
function subastaReload()
{
	$.ajax({
	   type: "POST",
	   url: "<?=$domain?>/code/valBidsItem.php",
	   data: "deadTime="+'<?=$timedead?>'+"&sub_uid="+<?=$details["sub_uid"]?>+"&timeSubasta="+'<?=$timeSubasta?>'+"&wheel='<?=$wheel?>'",
	   success: function(valBids){
		 if(valBids==1) subastaOff();
		 else location.reload();
	   }
	 });
}
function subastaOff()
{
	//var message = $("#message").html();
	//if(!message ) message ='';
	$(".subastaP").hide();
	$(".unidadmejora").hide();
	//$(".tiempoSubasta").hide();
	$(".ronda").hide();
	$.ajax({
	   type: "POST",
	   url: "<?=$domain?>/code/finish2.php",
	   data: "sub_uid="+<?=$details["sub_uid"]?>,
	      success: function(finish){
                  $(".tiempoSubasta").html('Compra Concluida');
                  $(".mensaje").show();
		  jQuery.facebox('<form name="formBids" class="formLabel">La subasta fue concluida, gracias por participar!!<br><br><a href="Cerrar" onclick="$.facebox.close();return false;" class="addcart">Cerrar</a></p></form><br>');
	   }
	 });
}
</script>
<style type="text/css">
@import "<?=$domain?>/css/jquery.countdown.css";
/*#defaultCountdown { width: 240px; height: 45px; }*/
</style>
<style type="text/css">@import "<?=$domain?>/css/layout.css";</style>
<script type="text/javascript">
    jQuery(document).ready(function($) {
      $('a[rel*=facebox]').facebox({
        loading_image : '<?=$domain?>/loading.gif',
        close_image   : '<?=$domain?>/closelabel.gif'
      }) 
    })
  </script>
</head>
<body class="details">
<div id="wrapper">
	<div id="wrapper-bgbtm">
		<?php include("code/header.php");?>
        <?php include("code/menu_header.php");?>
        <div id="page" class="container">
            <?php include("code/subastaxItemTpl.php"); ?>
			<?php include("code/column.php");?>
		</div>
	</div>
</div>
<?php include("code/footer.php");?>
</body>
</html>