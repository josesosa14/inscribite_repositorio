<?php
$transferencia = "blue";
require_once dirname(__FILE__) . '/../general/header_empresa.php';
echo '</div>';
$liq_id=addslashes(filter_input(INPUT_GET,'liq_id'));
$emp_id=$_SESSION["empresa"];

$query = "select liq_fecha_pagada,liq_id,CASE WHEN ev.id IS NULL THEN men_codigo ELSE ev.codigo END codigo,
CASE WHEN ev.id IS NULL THEN men_nombre ELSE ev.nombre END nombre,SUM(par_importe) total,pag_comision
                from liquidacion
                inner join pago on pag_liq_id=liq_id
                inner join pagos_renglones on par_pag_id=pag_id
                left join inscribite_eventos ev on ev.id=liq_evt_id
                left join mensualidades on men_id=liq_men_id
                where liq_id = ".$liq_id;

$liquidacion = getRowQuery($query, $mysqli);
$neto=round($liquidacion["total"]-($liquidacion["total"]*$liquidacion["pag_comision"])-(($liquidacion["total"]*$liquidacion["pag_comision"])*0.21),2);
error_reporting(-1);
?>

  <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Liquidacion #<?= $liquidacion["liq_id"]?></h3>
        </div>
        <div class="box-body">
			<div class="row">
				<div class="col-md-4">
					<div class="form-group">
						<label>Evento:</label>
						<input type="text" readonly class="form-control" value="<?= $liquidacion["nombre"]?>"/>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Total:</label>
						<input type="text" readonly class="form-control" value="<?= $liquidacion["total"] ?>"/>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>IVA:</label>
						<input type="text" readonly class="form-control" value="<?=ROUND(($liquidacion["total"]*$liquidacion["pag_comision"])*0.21,2) ?>"/>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Comisi&oacute;n:</label>
						<input type="text" readonly class="form-control" value="<?= ROUND($liquidacion["total"]*$liquidacion["pag_comision"],2) ?>"/>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label>Neto:</label>
						<input type="text" readonly class="form-control" id="neto" value="<?= $neto?>"/>
					</div>
				</div>
			</div>
        </div>
    </div>
	<form id="cuentas_liquidaciones">
	<div  class='box box-primary' >
        <div  class='box-header' >
            <h3 class='box-title'>Cuentas bancarias para recibir el pago ($<?= $neto ?>)</h3></div>
        <div class='box-body'>
            <div class="row">

                <div class="col-md-12">
                    <h4>Cuentas auxiliares</h4>
                </div>
                <?php
                $cant_cuentas = 5;
				$query = "select lic_importe,empb_id,empb_tipo_cuenta,empb_nro_cuenta,empb_preferente,empb_cbu,
				empb_titular,empb_cuit_titular,empb_nombre
				from liquidacion
				inner join liquidacion_cuentas on lic_liq_id=liq_id
				inner join empresa_banco on empb_id=lic_empb_id
				where liq_id=".$liq_id;
                $cuentas = getArrayQuery($query, $mysqli);
				
				$query = "select CASE WHEN lic_importe IS NULL THEN 0 ELSE lic_importe END lic_importe,empb_id,empb_tipo_cuenta,empb_nro_cuenta,empb_preferente,empb_cbu,
				empb_titular,empb_cuit_titular,empb_nombre
				from empresa 
				inner join empresa_banco on empb_emp_id=emp_id
				left join liquidacion_cuentas on lic_empb_id=empb_id
				left join liquidacion on liq_id=lic_liq_id
				where emp_id=$emp_id";
				$default = getArrayQuery($query, $mysqli);
				
				
                if (count($cuentas)==0 && $default):
					foreach($default as $cada_cuenta):
                        ?>
                        <div class="col-md-12">
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label >Tipo cuenta</label>
                                    <select class="form-control" name="destinos[<?= $x ?>][tipo_cuenta]">
                                        <option value="caja de ahorro">Ahorro</option>
                                        <option value="cuenta corriente">Corriente</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-1' >
                                <div class='form-group' >
                                    <label>Nro cue</label>
                                    <input type="text" value="<?= $cada_cuenta["empb_nro_cuenta"]  ?>" name="destinos[<?= $x ?>][nro_cuenta]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>CBU/Alias CBU</label>
                                    <input type="text" value="<?=  $cada_cuenta["empb_cbu"]?>" name="destinos[<?= $x ?>][cbu]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>Titular</label>
                                    <input type="text" name="destinos[<?= $x ?>][titular]" value="<?=$cada_cuenta["empb_titular"] ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-1' >
                                <div class='form-group' >
                                    <label>Banco</label>
                                    <input type="text" name="destinos[<?= $x ?>][banco]" value="<?=$cada_cuenta["empb_nombre"] ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>CUIT:</label>
                                    <input type="text" name="destinos[<?= $x ?>][cuit]" value="<?= $cada_cuenta["empb_cuit_titular"] ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>Importe</label>
                                    <input type="text" name="destinos[<?= $x ?>][importe]"  class="form-control importe"/>
                                </div>
                            </div>
                        </div>
                        <?php
                    endforeach;
                    for ($x = 0; $x <= $cant_cuentas; $x++):
                        ?>
                        <div class="col-md-12">
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label >Tipo cuenta</label>
                                    <select class="form-control" name="destinos[<?= $x ?>][tipo_cuenta]">
                                        <option value="caja de ahorro">Ahorro</option>
                                        <option value="cuenta corriente">Corriente</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-1' >
                                <div class='form-group' >
                                    <label>Nro cue</label>
                                    <input type="text"  name="destinos[<?= $x ?>][nro_cuenta]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>CBU/Alias CBU</label>
                                    <input type="text" name="destinos[<?= $x ?>][cbu]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>Titular</label>
                                    <input type="text" name="destinos[<?= $x ?>][titular]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-1' >
                                <div class='form-group' >
                                    <label>Banco</label>
                                    <input type="text" name="destinos[<?= $x ?>][banco]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>CUIT:</label>
                                    <input type="text" name="destinos[<?= $x ?>][cuit]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>Importe</label>
                                    <input type="text" name="destinos[<?= $x ?>][importe]" class="form-control importe"/>
                                </div>
                            </div>
                        </div>
                        <?php
                    endfor;
                else:

                    for ($x = 0; $x <= $cant_cuentas; $x++):
                        ?>
                        <div class="col-md-12">
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label >Tipo cuenta</label>
                                    <select class="form-control" name="destinos[<?= $x ?>][tipo_cuenta]">
                                        <option value="caja de ahorro">Ahorro</option>
                                        <option value="cuenta corriente">Corriente</option>
                                    </select>
                                </div>
                            </div>
                            <div class='col-md-1' >
                                <div class='form-group' >
                                    <label>Nro cue</label>
                                    <input type="text" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]["empb_nro_cuenta"] : "" ?>" name="destinos[<?= $x ?>][nro_cuenta]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>CBU/Alias CBU</label>
                                    <input type="text" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]["empb_cbu"] : "" ?>" name="destinos[<?= $x ?>][cbu]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>Titular</label>
                                    <input type="text" name="destinos[<?= $x ?>][titular]" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]["empb_titular"] : "" ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-1' >
                                <div class='form-group' >
                                    <label>Banco</label>
                                    <input type="text" name="destinos[<?= $x ?>][banco]" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]["empb_nombre"]: "" ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>CUIT:</label>
                                    <input type="text" name="destinos[<?= $x ?>][cuit]" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]["empb_cuit_titular"]: "" ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>Importe</label>
                                    <input type="text" name="destinos[<?= $x ?>][importe]" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]["lic_importe"] : "" ?>" class="form-control importe"/>
                                </div>
                            </div>
                        </div>
                        <?php
                    endfor;

                endif;
                ?>
            </div>
        </div>
    </div>
<?php if (!$liquidacion["liq_fecha_pagada"]): ?>
        <div class="col-md-3 pull-right">
            <button class="form-control btn btn-primary" type="button" id="enviar_form" >Guardar</button>
        </div>
    <?php endif; ?>
   </form>

<?php
require_once dirname(__FILE__) . '/general/footer.php';

?>

   <script>
   $("#enviar_form").click(function (e) {
	   e.preventDefault();
            $.post("http://www.inscribiteonline.com.ar/new_admin/renglonePagosLiquidacion/", {liq_id:"<?=$liquidacion["liq_id"]?>",data: $("#cuentas_liquidaciones").serializeArray()})
                    .success(function (data) {
                        if (data == 1) {
                            alert('datos guardados');
                        } else {
                            alert('fallamos, intente nuevamente mas tarde');
                        }
                    });

        });
   </script>