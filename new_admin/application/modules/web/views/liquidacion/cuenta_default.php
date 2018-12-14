<?php
/* @var $liquidacion Liquidacion */
/* @var $cuenta_activa Empresacuenta */
$cuenta_activa = $liquidacion->getCliente()->getCuentaActiva();
if ($cuenta_activa):
    ?>
    <div class="col-md-12">
        <h4>Cuenta preferente</h4>
        <input type="hidden" name="empb_id" value="<?=$cuenta_activa->getId()?>"/>
        <div class='col-md-2' >
            <div class='form-group' >
                <label >Tipo cuenta</label>
                <select class="form-control" name="default[tipo_cuenta]">
                    <option value="caja de ahorro"  <?= (strtolower($cuenta_activa->getTipo_cuenta()) == 'caja de ahorro') ? 'selected' : '' ?>>Caja de ahorro</option>
                    <option value="cuenta corriente" <?= (strtolower($cuenta_activa->getTipo_cuenta()) == 'cuenta corriente') ? 'selected' : '' ?> >Cuenta corriente</option>
                </select>
            </div>
        </div>
        <div class='col-md-2' >
            <div class='form-group' >
                <label>Nro cuenta</label>
                <input type="text" name="default[nro_cuenta]" value="<?= $cuenta_activa->getNro_cuenta() ?>" class="form-control"/>
            </div>
        </div>
        <div class='col-md-2' >
            <div class='form-group' >
                <label>CBU/Alias CBU</label>
                <input type="text" name="default[cbu]" value="<?= $cuenta_activa->getCbu() ?>" class="form-control"/>
            </div>
        </div>
        <div class='col-md-2' >
            <div class='form-group' >
                <label>Titular</label>
                <input type="text" name="default[titular]" value="<?= $cuenta_activa->getTitular() ?>" class="form-control"/>
            </div>
        </div>
        <div class='col-md-2' >
            <div class='form-group' >
                <label>Banco</label>
                <input type="text" name="default[banco]" value="<?= $cuenta_activa->getBanco() ?>" class="form-control"/>
            </div>
        </div>
        <div class='col-md-2' >
            <div class='form-group' >
                <label>Importe</label>
                <input type="text" name="default[importe]" value="" class="form-control importe"/>
            </div>
        </div>
    </div>
<?php endif; ?>