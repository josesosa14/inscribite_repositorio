<?	$pagetitle = 'Contacto - ';
	include_once 'inc.header.php'?>
		<div class="col_left">
			<h1>Comunicate con Inscribite On Line</h1>
			<div class="subti_seccion">
				Solicita un promotor quien te asesorará sobre nuestro servicio.
			</div>
			<form action="" method="post" class="contact_form">
				<label>
					<span class="typelabel">Nombre</span>
					<input type="text" name="contacto_nombre" class="typetext"/>
				</label>
				<label>
					<span class="typelabel">Empresa</span>
					<input type="text" name="contacto_empresa" class="typetext"/>
				</label>
				<label>
					<span class="typelabel">Email</span>
					<input type="text" name="contacto_email" class="typetext"/>
				</label>
				<label>
					<span class="typelabel">Teléfono</span>
					<input type="text" name="contacto_telefono" class="typetext"/>
				</label>
				<label>
					<span class="typelabel">Consulta</span>
					<textarea name="contacto_consulta" class="typetext"></textarea>
				</label>
				<input type="submit" value="Enviar"/>
			</form>
		</div>
		<a href="http://www.epsa.org.ar/promo/"><img src="images/epsa-2012.jpg" alt="" width="235" class="banner_lateral_home"/></a>
		<div class="cont_banners_home">
			<a href="mailto:robertomelado@maritimopro.com.ar?subject=Clasificacion por Chips"><img src="images/chips450x80px.gif" alt="" width="450" height="80" class="banner1"/></a>
			<a href="mailto:instituto@epsa.org.ar?subject=Consulta por Curso de RCP"><img src="images/rcp215x80px.gif" width="215" height="80" class="banner2"/></a>
			<a href="mailto:robertomelado@maritimopro.com.ar?subject=Diseño Web"><img src="images/web450x80px.gif" alt="" width="450" height="80" class="banner1"/></a>
		</div>
		<script type="text/javascript">
		<!--
		$('input:text').attr("autocomplete", "off");
		-->
		</script>
<?php include_once 'inc.footer.php'?>