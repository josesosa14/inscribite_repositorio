<script type='text/javascript'>
    function actionFormatter(value, row, index) {
        return [
            '<a class="inscripciones ml10" href="javascript:void(0)" title="Inscripciones">',
            '<i class="glyphicon glyphicon-search"></i>',
            '</a> &nbsp;&nbsp;'
        ].join('');
    }
    window.actionEvents = {
        'click .edit': function (e, value, row, index) {
            window.location.href = ('<?= base_url() ?>cliente/' + row.id);
        },
        'click .inscripciones': function (e, value, row, index) {
            window.location.href = ('<?= base_url() ?>cliente-inscripciones/' + row.id);
        },
        'click .delete': function (e, value, row, index) {
            if (confirm("¿Está seguro que desea eliminar la empresa: " + row.emp_nombre.toUpperCase() + "?") == true) {
                $.ajax({
                    url: '<?= base_url() ?>borrarCliente/' + row.id,
                });
                $('#tabla_empresa').bootstrapTable("refresh");
                return false;
            }
            //window.location.href = ('<?= base_url() ?>borrarCliente/' + row.id);

        }
    };
    function cargaSelectPorAjax(origen, destino, texto, url_pedida)
    {
        $(destino).removeAttr("disabled");
        $(destino).empty();
        $(destino).append('<option>' + texto + '</option>');
        id = $(origen).val();
        $.ajax({
            type: "POST",
            url: "<?= base_url() ?>" + url_pedida + id
        })
                .done(function (data) {
                    $(destino).empty();
                    var obj = jQuery.parseJSON(data);
                    $(destino).append('<option selected disable value="0">select an option</option>');
                    for (i = 0; i < obj.length; i++) {
                        $(destino).append('<option value="' + obj[i].id + '">' + obj[i].nombre + '</option>');
                    }
                });
    }
    $("#provincias").change(function () {
        cargaSelectPorAjax("#provincias", "#localidades", "cargando...", "traerLocalidades/");
    });
</script>