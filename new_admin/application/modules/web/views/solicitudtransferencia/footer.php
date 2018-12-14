<script src="http://malsup.github.com/jquery.form.js"></script>
<script type='text/javascript'>
    function actionFormatter(value, row, index) {
        return [
            '<a class="edit ml10" href="javascript:void(0)" title="Editar">',
            '<i class="glyphicon glyphicon-edit"></i>',
            '</a> &nbsp;&nbsp;',
            '<a class="delete" href="javascript:void(0)" title="Eliminar">',
            //'<i class="glyphicon glyphicon-trush"></i>',
            '<i class="fa fa-trash-o"></i>',
            '</a>'
        ].join('');
    }
    window.actionEvents = {
        'click .edit': function (e, value, row, index) {
            window.location.href = ('<?= base_url() ?>editar_solicitud_transferencia/' + row.id);
        },
        'click .delete': function (e, value, row, index) {
            if(confirm("¿Está seguro que desea eliminar la solicitud asociada al pago: " + row.sot_pago + "?") == true){
                $.ajax({
                    url: '<?= base_url() ?>borrarsolicitudtransferencia/' + row.id,
                });
                $('#tabla_solicitudtransferencia').bootstrapTable("refresh");
                return false;
            }
                //window.location.href = ('<?= base_url() ?>borrarCliente/' + row.id);
             
        }
    };
    var $table = $('.table_grilla');
    var form = $("#formSolicitudTransferencia");
    var control = $("#control");
    $(function () {
        $table.bootstrapTable({
            onPostBody: function () {
                $('.fecha').mask('00/00/0000');
                form.validate();
            }
        });
    });


    $(".table_grilla").on('change', '.nombre', function () {
        var tr = $(this).parent().parent();
        var estado = tr.find(".estado");
        cambiarEstado(estado, estado.val(), tr);
    });
    $(".table_grilla").on('change', '.date', function () {
        var tr = $(this).parent().parent();
        var estado = tr.find(".estado");
        cambiarEstado(estado, estado.val(), tr);
    });

    function cambiarEstado(input, valor, tr) {
        switch (valor) {
            case "0":
                input.val("insert");
                tr.attr("class", "info");
                break;
            case "1":
                input.val("update");
                tr.attr("class", "success");
                break;
        }
    }
    
    function formatoBtnBorrar(value, row, index) {
        if (row.control !== "0") {
            return [
                '<span class="glyphicon glyphicon-remove borrar" style="color:red;cursor:pointer"></span>'
            ].join('');
        } else {
            return '';
        }
    }
    
    function formatoBtnBorrar(value, row, index) {
        if (row.control !== "0") {
            return [
                '<span class="glyphicon glyphicon-remove borrar" style="color:red;cursor:pointer"></span>'
            ].join('');
        } else {
            return '';
        }
    }
    
    $(document).ready(function () {
        $("#pagoId").select2({
            minimumInputLength: 1,
            ajax: {
                url: "<?= base_url() ?>pagoSelect2",
                dataType: 'json',
                quietMillis: 500,
                data: function (term, page) { // page is the one-based page number tracked by Select2
                    return {
                        q: term
                    };
                },
                results: function (data, page) {
                    return {results: datos, more: more};
                }
            },
            formatResult: repoFormatResult, // omitted for brevity, see the source of this page
            formatSelection: repoFormatSelection, // omitted for brevity, see the source of this page
            dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
            escapeMarkup: function (m) {
                return m;
            }
        });
    });
    
    function repoFormatResult(repo) {
        var markup = '<div class="row-fluid">' +
                '<div class="span10">' +
                '<div class="row-fluid">' +
                '<div class="span6">' + nombre + 'xxx</div>' +
                '<div class="span3"><i class="fa fa-code-fork"></i>' + nombre + 'aaa</div>' +
                '</div>';
        if (repo.description) {
            markup += '<div>' + repo.description + 'ddd</div>';
        }
        markup += '</div></div>';
        return markup;
    }
    
    function repoFormatSelection(repo) {
        return repo.id;
    }
    
    function guardar() {
        enviarFormulario();
    }

    function enviarFormulario() {
        var options = {
            success: showResponse,
            dataType: 'json',
            timeout: 3000
        };
        form.ajaxSubmit(options);
        alert('Datos guardados');
        $('#tabla_solicitudtransferencia').bootstrapTable("refresh");
    }
    
    function showResponse(data) {
        $table.bootstrapTable("refresh");
    }
    
    window.btnBorrar = {
        'click .borrar': function (e, value, row) {
            var tr = $(this).parent().parent();
            var estado = tr.find(".estado");
            if (estado.val() === "delete") {
                estado.val("1");
                tr.attr("class", "");
            } else {
                estado.val("delete");
                control.val("1");
                tr.attr("class", "danger");
            }
        }
    };
</script>
