<?php
include ("core/admin.php");
?>
                <div style="width:700px;">
                    <form name="searchForm" action="<?=$_SERVER['PHP_SELF']?>" >
                        <input id="search" type="text" class="search"  autocomplete="off" onkeyup="enableSearch()"/>
                        <input id="submit_button" type="submit" value="search" class="button" onclick="paginate(<?=$_GET['new_uid']?>);return false" disabled="disabled" />
                        <a href="toggle" id="advanced_link" onclick="javascript:toggleRelated();return false;">Avanzado</a>
                        <div id="advanced_div" style="display:none">
                        <select id="by_category" name="by_category">
                            
                            <?php 
							$sql = "select nec_uid,ncl_category 
						from mdl_news_category 
						left join mdl_news_category_languages on (nec_uid=ncl_nec_uid)
						where nec_delete<>1 and 
							  ncl_language='" . $lang . "'			
						order by nec_position";
						
				$db->query($sql);?>
                <option value="0">--Seleccionar--</option>
                <? while ($category = $db->next_record()){ ?>
				<option value="<?=$category["nec_uid"]?>" ><?=utf8_encode($category["ncl_category"])?></option>
				<? } ?>
                        </select>
                        Desde <input name="fecha1" type="text" class="input"  id="fecha1" value="" size="15" readonly="" /> <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.searchForm.fecha1);return false;" >
				<img border="0" src="calendario/icon_calendar.gif">				</a>
                        Hasta <input name="fecha2" type="text" class="input"  id="fecha2" value="" size="15" readonly="" /> <a href="javascript:void(0)" onClick="if(self.gfPop)gfPop.fPopCalendar(document.searchForm.fecha2);return false;" >
				<img border="0" src="calendario/icon_calendar.gif">				</a>
                </div>
                    </form>
                </div>
               
                <table class="box" border="0" cellpadding="5" cellspacing="5"  > 
            <tbody id="news_related2">
          	<?php 
$new_uid = admin::toSql(safeHtml($_GET['new_uid']),"Number");

			$dset = new DBmysql;
			$sqldat = "select rel_uid,nel_new_uid,nel_title  
						from mdl_news_relationship  
						LEFT JOIN mdl_news_languages on rel_new_uid2=nel_new_uid 
						where rel_new_uid=".$new_uid." 			
						and nel_language='".$lang."' 
						and rel_delete=0 
						order by rel_uid";
				$dset->query($sqldat);
				while ($row = $dset->next_record()){
			?>
                
	
                    
                    <tr id="rowbox_<?=$row['rel_new_uid2']?>"><td><?=utf8_encode($row['nel_title'])?></td><td><a href="#" onclick="delNode_rel(<?=$row['rel_new_uid2']?>);return false;"><img src="lib/close.gif" border="0" title="dere" alt="fsefs"></a></td></tr>
            
           <?php } ?>
           </tbody>      
           </table>
           <hr />
           <div align="center"><img id="img_loading" style="display:none;" src="facebox_lib/loading.gif" /></div>
                <div id="listing_container" align="center" style="display:"></div>
                <!--end of listing_container-->