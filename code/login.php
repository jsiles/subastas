<div id="content">
				<div id="box6" class="box-style">
					<div class="title">
                        <h2><span>Sistema de Compras </span></h2>
					</div>
					<div class="content">
                                            <p>&nbsp;</p>
						<p>Para ingresar al sitio de Subastas Online, requiere del usuario y contraseña.</p>
						<p>&nbsp;</p>
						<form name="formLabel" id="formLabel" class="formLabel" autocomplete="off" method="post" action="<?=$domain.'/code/session.php'?>">
						<p>
						  <label>Usuario:</label><input name="usernameClient" id="usernameClient" type="text" value="" onkeyup="if (event.keyCode==13) document.getElementById('passwordClient').focus();"  autocomplete="off"/> </p><div class="clear"></div>
						<p><label>Contrase&ntilde;a:</label><input name="passwordClient" id="passwordClient" type="password" value="" onkeyup="if (event.keyCode==13) document.formLabel.submit();" autocomplete="off"/> </p><div class="clear"></div>
                                                <p>&nbsp;</p>
                        <a href="#" onclick="document.formLabel.submit();" class="addcart">Ingresar</a>
						<!--<p><label>C&oacute;digo de seguridad:</label><input name="password" id="password" value="" /></p>-->
						<div class="clear"></div>
                                                <p>&nbsp;</p>
                                                <p>Se recomienda que cambie peri&oacute;dicamente su contrase&ntilde;a.</p>
						</form>
                        <?php
						$arrayURL = admin::urlArray();
						$urlSubTitle = $arrayURL[$urlPositionSubtitle];
                        if(($urlSubTitle)&&($urlSubTitle==1))
						{					
                            ?><p style="color: red">Error en la contrase&ntilde;a o usuario no activo</p>
                        <?php
						}
						else if(($urlSubTitle)&&($urlSubTitle==2))
						{					
                                                    ?><p style="color: red">Usuario con otra sesion abierta, si desea cerrar las sesion de la otra cuenta haga click <a href="<?=$domain."/logout.php?uidClient=".$arrayURL[$urlPositionSubtitle2]?>">aqui!!</a></p>
                        <?php
						}
						?>
                    </div>
				</div>
			</div>
<script type="text/javascript">
jQuery(document).ready(function($) {
	$("#usernameClient").val(" ");
	$("#passwordClient").val("");
})
</script>