<script>
    $(document).ready(function () {
        $(".importe").change(function (e) {
            var inputs = $(".importe");
            var total_imputado = 0;
            var total = parseFloat($("#neto").val());
            var valor_input = 0;
            $.each(inputs, function (key, value) {
                valor_input = parseFloat($(value).val());
                if (valor_input > 0) {
                    total_imputado = parseFloat(total_imputado) + parseFloat($(value).val());
                }
            });
            if (total < total_imputado) {
                alert("No puede poner mas importe a cobrar que el neto, reste de otra cuenta.");
                $(this).val(0);
                return;
            }
        });
    });
</script>