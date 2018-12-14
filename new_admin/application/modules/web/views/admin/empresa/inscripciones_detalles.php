<?php
/* @var $empresa Empresa */
?>
<section  class='content mayus' >
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Inscripciones - <?= isset($renglones["rows"]) ? utf8_decode($renglones["rows"][0]["evento"]) : "" ?></h3>
            <button type="button" class="btn btn-box-tool pull-right" data-widget="collapse">
                <i class="fa fa-minus"></i>
            </button>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="tabla_empresa" data-show-toggle="true" data-toggle="table"
                       data-search="true" data-pagination="true" data-page-list="[20, 800]" data-show-refresh="true" 
                       data-cache="false" data-height="auto" data-show-columns="true" data-search-on-enter-key="true" data-search-time-out="750" class="table table-responsive 
                       table-striped" data-page-size="20">
                    <thead>
                        <tr>
                            <th class="col-md-1"   data-align="left" data-sortable="true">Id</th>
                            <th class="col-md-1"   data-align="left" data-sortable="true">Deportista</th>
                            <th class="col-md-1"  data-align="left" data-sortable="true">Dni</th>
                            <th class="col-md-1"   data-align="left" data-sortable="true">Importe bruto</th>
                            <th class="col-md-1"   data-align="left" data-sortable="true">Comisión</th>
                            <th class="col-md-1"   data-align="left" data-sortable="true">IVA</th>
                            <th class="col-md-1"   data-align="left" data-sortable="true">Neto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($renglones["rows"] as $renglon):
                            $comision = round($renglon["comision"] * $renglon["decodificado"], 2);
                            $iva = round($comision * 0.21, 2);
                            ?>
                            <tr>
                                <td><?= $renglon["der_id"] ?></td>
                                <td><?= utf8_decode($renglon["deportista"]) ?></td>
                                <td><?= $renglon["dni"] ?></td>
                                <td><?= $renglon["decodificado"] ?></td>
                                <td><?= $comision ?></td>
                                <td><?= $iva ?></td>
                                <td><?= $renglon["decodificado"] - $comision - $iva ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>