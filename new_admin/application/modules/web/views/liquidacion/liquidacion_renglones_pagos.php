<?php /* @var $liquidacion Liquidacion */ ?>
<?php /* @var $cliente Empresa */ ?>
<?php /* @var $evento Evento */ ?>
<section  class='content mayus' >
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Liquidacion #<?= $liquidacion->getId() ?> - <?= $liquidacion->getCliente()->getNombre() ?></h3>
            <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <div class="box-body">
            <div class="col-md-3">
                <div class="form-group">
                    <label>Evento:</label>
                    <input type="text" readonly class="form-control" value="<?= $liquidacion->getEventoMostrar() ?>"/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Total:</label>
                    <input type="text" readonly class="form-control" value="<?= $liquidacion->getTotalCobrado() ?>"/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>IVA:</label>
                    <input type="text" readonly class="form-control" value="<?= $liquidacion->getIVA() ?>"/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Comisión:</label>
                    <input type="text" readonly class="form-control" value="<?= $liquidacion->getComision() ?>"/>
                </div>
            </div>
            <div class="col-md-2">
                <div class="form-group">
                    <label>Neto:</label>
                    <input type="text" readonly class="form-control" id="neto" value="<?= $liquidacion->getTotal() ?>"/>
                </div>
            </div>
            <div class="col-md-1">
                <div class="form-group">
                    <label>Registros:</label>
                    <input type="text" readonly class="form-control" value="<?= $liquidacion->getTotalRegistros() ?>"/>
                </div>
            </div>
        </div>
    </div>

    <?= form_open("renglonePagosLiquidacion") ?>

    <div  class='box box-primary' >
        <div  class='box-header' >
            <h3 class='box-title'>Cuentas bancarias para recibir el pago ($<?= $liquidacion->getTotal() ?>)</h3></div>
        <div class='box-body'>
            <div class="row">

                <div class="col-md-12">
                    <h4>Cuentas auxiliares</h4>
                </div>
                <?php
                $cant_cuentas = 5;
                $cuentas = $liquidacion->getCuentas();
                if (count($cuentas)==0 && $liquidacion->getCliente()->getCuentaDefault()):
                    /*@var $default Empresacuenta*/
                    $default=$liquidacion->getCliente()->getCuentaDefault();
                
                    ?>
                    <div class = "col-md-12">
                        <div class = 'col-md-2' >
                            <div class = 'form-group' >
                                <label >Tipo cuenta</label>
                                <select class = "form-control" name = "destinos[50][tipo_cuenta]">
                                    <option value = "caja de ahorro">Ahorro</option>
                                    <option value = "cuenta corriente">Corriente</option>
                                </select>
                            </div>
                        </div>
                        <div class = 'col-md-1' >
                            <div class = 'form-group' >
                                <label>Nro cue</label>
                                <input type = "text" value = "<?= $default->getNro_cuenta() ?>" name = "destinos[50][nro_cuenta]" class = "form-control"/>
                            </div>
                        </div>
                        <div class = 'col-md-2' >
                            <div class = 'form-group' >
                                <label>CBU/Alias CBU</label>
                                <input type = "text" value = "<?=$default->getCbu() ?>" name = "destinos[50][cbu]" class = "form-control"/>
                            </div>
                        </div>
                        <div class = 'col-md-2' >
                            <div class = 'form-group' >
                                <label>Titular</label>
                                <input type = "text" name = "destinos[50][titular]" value = "<?=$default->getTitular()?>" class = "form-control"/>
                            </div>
                        </div>
                        <div class = 'col-md-1' >
                            <div class = 'form-group' >
                                <label>Banco</label>
                                <input type = "text" name = "destinos[50][banco]" value = "<?= $default->getBanco() ?>" class = "form-control"/>
                            </div>
                        </div>
                        <div class = 'col-md-2' >
                            <div class = 'form-group' >
                                <label>CUIT:</label>
                                <input type = "text" name = "destinos[50][cuit]" value = "<?= $default->getCuit() ?>" class = "form-control"/>
                            </div>
                        </div>
                        <div class = 'col-md-2' >
                            <div class = 'form-group' >
                                <label>Importe</label>
                                <input type = "text" name = "destinos[50][importe]" value = "<?= $liquidacion->getTotal() ?>" class = "form-control importe"/>
                            </div>
                        </div>
                    </div>
                    <?php
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
                                    <input type="text" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]->getCuenta()->getNro_cuenta() : "" ?>" name="destinos[<?= $x ?>][nro_cuenta]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>CBU/Alias CBU</label>
                                    <input type="text" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]->getCuenta()->getCbu() : "" ?>" name="destinos[<?= $x ?>][cbu]" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>Titular</label>
                                    <input type="text" name="destinos[<?= $x ?>][titular]" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]->getCuenta()->getTitular() : "" ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-1' >
                                <div class='form-group' >
                                    <label>Banco</label>
                                    <input type="text" name="destinos[<?= $x ?>][banco]" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]->getCuenta()->getBanco() : "" ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>CUIT:</label>
                                    <input type="text" name="destinos[<?= $x ?>][cuit]" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]->getCuenta()->getCuit() : "" ?>" class="form-control"/>
                                </div>
                            </div>
                            <div class='col-md-2' >
                                <div class='form-group' >
                                    <label>Importe</label>
                                    <input type="text" name="destinos[<?= $x ?>][importe]" value="<?= isset($cuentas) && isset($cuentas[$x]) ? $cuentas[$x]->getImporte() : "" ?>" class="form-control importe"/>
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
    <input  type='hidden'  value='<?= (isset($liquidacion) ? $liquidacion->getId() : "") ?>'  name='liq_id' ></input>
<?php if (!$liquidacion->getFecha_pagada()): ?>
        <div class="col-md-3 pull-right">
            <button class="form-control btn btn-primary" type="submit" >Guardar</button>
        </div>
    <?php endif; ?>
<?= form_close() ?>
</section>
