<script>
    var $table = $('#tabla_reporte');
    $ok = $('#ok');

    $(function () {
        $ok.click(function () {
            $table.bootstrapTable('refresh');
            $.get("<?= base_url("rep-cuenta-ajax-totales") ?>", {cliente: $('#fil_cliente').val(), eventos: $('#fil_eventos').val()})
                    .done(function (data) {
                        $("#estado_cuenta_totales").empty();
                        $("#estado_cuenta_totales").append(data);
                    });
        });
    });
    function queryParams(p) {
        var params = {};
        params['cliente'] = $('#fil_cliente').val();
        params['eventos'] = $('#fil_eventos').val();
        params['search'] = p.search;
        params['sort'] = p.sort;
        params['order'] = p.order;
        params['limit'] = p.limit;
        params['offset'] = p.offset;
        return params;
    }
</script>