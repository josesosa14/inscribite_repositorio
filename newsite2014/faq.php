<?php include_once 'includes/head.php' ?>

<div class="columnacentral" style="overflow:visible;height:auto;">
    <div class="contenidoseccioncentral">

        <div class="titu"><strong>Ayuda. </strong>Preguntas Frecuentes de Usuarios</div>
        <p>
            <strong>
                <?php
                $result1 = mysql_query('SELECT * FROM ' . pftables . 'faq ORDER BY numero ');
                while ($row1 = mysql_fetch_array($result1)) {
                    ?>
                    <a href="#<?= $row1['numero'] ?>"><?= $row1['pregunta'] ?></a><br>
<?php } ?>
            </strong>
        </p>
        <hr/>

        <?php
        mysql_data_seek($result1, 0);
        while ($row1 = mysql_fetch_array($result1)) {
            ?>
            <p>
                <strong><a name="<?= $row1['numero'] ?>"></a><?= $row1['pregunta'] ?></strong><br>
    <?= preg_replace("(\r\n|\n|\r)", "<br/>", $row1['respuesta']) ?>
<?php } ?>

    </div>

</div>

<?php include_once 'includes/colder.php' ?>