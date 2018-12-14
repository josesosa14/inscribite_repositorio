<?php if ($estado_cuenta): ?>
    <div  class='box box-primary' >
        <div  class='box-header' >
            <h3 class='box-title'>Estado de cuenta</h3></div>

        <div  class='box-body' >
            <?php if (isset($estado_cuenta["decodificados"])): ?>
                <div class="col-md-2">
                    <h3>
                        Decodificado
                    </h3>
                    <ul>
                        <?php foreach ($estado_cuenta["decodificados"] as $decodificado): ?>
                            <li><?= $decodificado->medio ?>: $<?= $decodificado->total ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if (isset($estado_cuenta["cobrados"])): ?>
                <div class="col-md-2">
                    <h3>
                        Cobrados
                    </h3>
                    <ul>
                        <?php foreach ($estado_cuenta["cobrados"] as $cobrado): ?>
                            <li><?= $cobrado->medio ?>: $<?= $cobrado->total ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
            <?php if (isset($estado_cuenta["liquidados"])): ?>
                <div class="col-md-2">
                    <h3>
                        Liquidado
                    </h3>
                    <ul>
                        <?php foreach ($estado_cuenta["liquidados"] as $pagado): ?>
                            <li><?= $pagado->medio ?>: $<?= $pagado->total ?></li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            <?php endif; ?>
        </div>
    </div>
<?php endif; ?>