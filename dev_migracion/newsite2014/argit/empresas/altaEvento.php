<?php
$alta_evento = "blue";
require_once dirname(__FILE__) . '/../general/header_empresa.php';

if (!isset($_SESSION['empresa'])) {
    header('Location:'.$general_path.'empresas/index.php');
}
?>
</div>
<?php
//info de las categorias
$query = "SELECT * FROM empresa 
			LEFT JOIN empresa_contacto ON empc_emp_id = emp_id
			LEFT JOIN empresa_banco ON empb_emp_id = emp_id
			WHERE emp_id = {$_SESSION['empresa']}";
$empresa = getRowQuery($query, $mysqli);

?>
<div class="columns-container row">
    <div class="col-sm-12">
        <form class="contact-form" action="/empresas/enviarAltaEvento.php" method="post" id="formx" enctype="multipart/form-data">
		<input class="form-control" type="hidden" name="pevt_emp_id" value="<?=$_SESSION['empresa']?>"/>
            <div class="row">
                <label class="col-sm-4">Nombre Evento</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_nombre"/>
                </div>
            </div>
			
			<div class="row">
                <label class="col-sm-4">Imagen Evento (.jpg o .png)</label>
                    <div class="select-file col-sm-8 col-wrap">
                        <input type="file" name="imagen" accept=".xls,.xlsx"/>
                    </div>
			</div>                                        
            <div class="row">
                <label class="col-sm-4">Fecha Realizaci&oacute;n</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_fecha_inicio" id="datepicker" />
                </div>
            </div>
            <div class="row">
                <label class="col-sm-2">Valor 1</label>
                <div class="col-sm-4 col-wrap">
                   <input class="form-control" type="text" name="pevt_valor1"/>
                </div>
				<label class="col-sm-2">Hasta</label>
                <div class="col-sm-4 col-wrap">
                   <input class="form-control" type="text" name="pevt_venc1" id="venc1" />
                </div>
            </div>
            
			<div class="row">
                <label class="col-sm-2">Valor 2</label>
                <div class="col-sm-4 col-wrap">
                   <input class="form-control" type="text" name="pevt_valor2"/>
                </div>
				<label class="col-sm-2">Hasta</label>
                <div class="col-sm-4 col-wrap">
                   <input class="form-control" type="text" name="pevt_venc2" id="venc2" />
                </div>
            </div>
			
			<div class="row">
                <label class="col-sm-2">Valor 3</label>
                <div class="col-sm-4 col-wrap">
                   <input class="form-control" type="text" name="pevt_valor3"/>
                </div>
				<label class="col-sm-2">Hasta</label>
                <div class="col-sm-4 col-wrap">
                   <input class="form-control" type="text" name="pevt_venc3" id="venc3" />
                </div>
            </div>
			
			<div class="row">
                <label class="col-sm-4">Fecha de C&aacute;lculo</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_fecha_calculo" id="calculo" />
                </div>
            </div>
			
			
			<div class="row">
                <label class="col-sm-4">Cantidad Vacantes</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_vacantes"/>
                </div>
            </div>
			
			
			<div class="row">
                <div class="col-sm-8 col-wrap">
					<h4>Banners publicitarios (total 3, costo por banner $150)</h4>
				</div>
                <div class="col-sm-4 col-wrap">
                    <input class="form-control"  style="visibility:visible" type="checkbox" value="1" name="pevt_banner"/>
                </div>
            </div>
					
			<div class="row">
                <div class="col-sm-8 col-wrap">
					<h4>Enviar NewsLetter a los 30.000 usuarios de Inscribite (valor por cada news $390)</h4>
				</div>
				<div class="col-sm-4 col-wrap">
                    <input class="form-control" style="visibility:visible" type="checkbox" value="1" name="pevt_news"/>
                </div>
            </div>
			
			
			<div class="row">
                <label class="col-sm-4">Mail para contacto</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_email" value="<?=$empresa['empc_mail']?>" />
                </div>
            </div>
			
			<h3>Datos de la cuenta bancaria para las transferecias:</h3>
            <div class="row">
                <label class="col-sm-4">Cuenta</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_nro_cuenta" value="<?=$empresa['empb_nro_cuenta']?>" />
                </div>
            </div>
			<div class="row">
                <label class="col-sm-4">Tipo de Cuenta</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_tipo_cuenta" value="<?=$empresa['empb_tipo_cuenta']?>" />
                </div>
            </div>
			
			<div class="row">
                <label class="col-sm-4">CBU</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_cbu" value="<?=$empresa['empb_cbu']?>" />
                </div>
            </div>
			<div class="row">
                <label class="col-sm-4">Banco</label>
                <div class="col-sm-8 col-wrap">
                    <input class="form-control" type="text" name="pevt_banco" value="<?=$empresa['empb_nombre']?>" />
                </div>
            </div>
			
			<h3>Categorias:</h3>
			<div class="row">
                <label class="col-sm-1">Nombre</label>
                <div class="col-sm-2 col-wrap">
                    <input class="form-control" type="text" name="categorias[1][pcat_nombre]"/>
                </div>
				<label class="col-sm-1">Sexo</label>
                <div class="col-sm-2 col-wrap">
                    <select class="form-control" name="categorias[1][pcat_sexo]">
						<option selected >Elegir</option>
						<option>Masculino</option>
						<option>Femenino</option>
						<option>Ambos</option>
					</select>
                </div>
				<label class="col-sm-2">Edad Minima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[1][pcat_edad_minima]" placeholder="15"/>
                </div>
				<label class="col-sm-2">Edad Maxima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[1][pcat_edad_maxima]" placeholder="35"/>
                </div>
            </div>
			<div class="row">
                <label class="col-sm-1">Nombre</label>
                <div class="col-sm-2 col-wrap">
                    <input class="form-control" type="text" name="categorias[2][pcat_nombre]"/>
                </div>
				<label class="col-sm-1">Sexo</label>
                <div class="col-sm-2 col-wrap">
                    <select class="form-control" name="categorias[2][pcat_sexo]">
						<option selected >Elegir</option>
						<option>Masculino</option>
						<option>Femenino</option>
						<option>Ambos</option>
					</select>
                </div>
				<label class="col-sm-2">Edad Minima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[2][pcat_edad_minima]" placeholder="15"/>
                </div>
				<label class="col-sm-2">Edad Maxima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[2][pcat_edad_maxima]" placeholder="35"/>
                </div>
            </div>
			<div class="row">
                <label class="col-sm-1">Nombre</label>
                <div class="col-sm-2 col-wrap">
                    <input class="form-control" type="text" name="categorias[3][pcat_nombre]"/>
                </div>
				<label class="col-sm-1">Sexo</label>
                <div class="col-sm-2 col-wrap">
                    <select class="form-control" name="categorias[3][pcat_sexo]">
						<option selected >Elegir</option>
						<option>Masculino</option>
						<option>Femenino</option>
						<option>Ambos</option>
					</select>
                </div>
				<label class="col-sm-2">Edad Minima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[3][pcat_edad_minima]" placeholder="15"/>
                </div>
				<label class="col-sm-2">Edad Maxima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[3][pcat_edad_maxima]" placeholder="35"/>
                </div>
            </div>
			<div class="row">
                <label class="col-sm-1">Nombre</label>
                <div class="col-sm-2 col-wrap">
                    <input class="form-control" type="text" name="categorias[3][pcat_nombre]"/>
                </div>
				<label class="col-sm-1">Sexo</label>
                <div class="col-sm-2 col-wrap">
                    <select class="form-control" name="categorias[4][pcat_sexo]">
						<option selected >Elegir</option>
						<option>Masculino</option>
						<option>Femenino</option>
						<option>Ambos</option>
					</select>
                </div>
				<label class="col-sm-2">Edad Minima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[4][pcat_edad_minima]" placeholder="15"/>
                </div>
				<label class="col-sm-2">Edad Maxima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[4][pcat_edad_maxima]" placeholder="35"/>
                </div>
            </div>
			<div class="row">
                <label class="col-sm-1">Nombre</label>
                <div class="col-sm-2 col-wrap">
                    <input class="form-control" type="text" name="categorias[5][pcat_nombre]"/>
                </div>
				<label class="col-sm-1">Sexo</label>
                <div class="col-sm-2 col-wrap">
                    <select class="form-control" name="categorias[5][pcat_sexo]">
						<option selected >Elegir</option>
						<option>Masculino</option>
						<option>Femenino</option>
						<option>Ambos</option>
					</select>
                </div>
				<label class="col-sm-2">Edad Minima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[5][pcat_edad_minima]" placeholder="15"/>
                </div>
				<label class="col-sm-2">Edad Maxima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[5][pcat_edad_maxima]" placeholder="35"/>
                </div>
            </div>
			<div class="row">
                <label class="col-sm-1">Nombre</label>
                <div class="col-sm-2 col-wrap">
                    <input class="form-control" type="text" name="categorias[6][pcat_nombre]"/>
                </div>
				<label class="col-sm-1">Sexo</label>
                <div class="col-sm-2 col-wrap">
                    <select class="form-control" name="categorias[6][pcat_sexo]">
						<option selected >Elegir</option>
						<option>Masculino</option>
						<option>Femenino</option>
						<option>Ambos</option>
					</select>
                </div>
				<label class="col-sm-2">Edad Minima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[6][pcat_edad_minima]" placeholder="15"/>
                </div>
				<label class="col-sm-2">Edad Maxima</label>
                <div class="col-sm-1 col-wrap">
                    <input class="form-control" type="text" name="categorias[6][pcat_edad_maxima]" placeholder="35"/>
                </div>
            </div>


            <div class="row">
                <div class="btns">
                    <input class="btn green pull-right col-xs-12 col-sm-3" type="submit" value="pedir alta"/>
                    <div class="clear"></div>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="columns-container gray row">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-xs-6 col-wrap">
            <!--    <div class="col gray">

                </div>-->
            </div>
            <div class="col-xs-6 col-wrap">
                <!--<div class="col gray">

                </div>-->
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12 col-wrap">
                <!--<div class="col gray">

                </div>-->
            </div>
        </div>
    </div>

</div>
<script src="//code.jquery.com/ui/1.10.4/jquery-ui.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/smoothness/jquery-ui.css">

<script>
    $.datepicker.regional['es'] = {
        closeText: 'Cerrar',
        prevText: '<Ant',
        nextText: 'Sig>',
        currentText: 'Hoy',
        monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
        monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
        dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
        dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
        dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
        weekHeader: 'Sm',
        dateFormat: 'dd-mm-yy',
        firstDay: 1,
        isRTL: false,
        showMonthAfterYear: false,
        yearSuffix: ''
    };
    $.datepicker.setDefaults($.datepicker.regional['es']);
    $(function() {
        $("#datepicker,#venc1,#venc2,#venc3,#calculo").datepicker({
            changeMonth: true,
            changeYear: true,
            showButtonPanel: true,
            yearRange: "1914:2014"
        });
    });
</script>
<?php
include_once dirname(__FILE__) . '/../general/footer.php';
?>