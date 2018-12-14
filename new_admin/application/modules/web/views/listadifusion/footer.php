<script type='text/javascript'>
    function actionFormatter(value, row, index) {
        return [
            '<a class="edit ml10" href="javascript:void(0)" title="Editar">',
            '<i class="glyphicon glyphicon-edit"></i>',
            '</a> &nbsp;&nbsp;',
            '<a class="delete" href="javascript:void(0)" title="Eliminar">',
            '<i class="glyphicon glyphicon-trush"></i>',
            '</a>'
        ].join('');
    }
    window.actionEvents = {
        'click .edit': function (e, value, row, index) {
            window.location.href = ('<?= base_url() ?>admin-listadifusion/' + row.id);
        },
        'click .delete': function (e, value, row, index) {
            window.location.href = ('<?= base_url() ?>admin-borrarlistadifusion/' + row.id);
        }
    };

    $("#mails").select2({
        placeholder: "Busqueda de Emails",
        minimumInputLength: 3,
        ajax: {
            url: "<?=base_url("guardaVidaemailsByAjax")?>",
            dataType: 'json',
            quietMillis: 500,
            data: function (term, page) { // page is the one-based page number tracked by Select2
                return {
                    q: term
                };
            },
            results: function (data, page) {
                return {results: data.items, more: more};
            }
        },
        formatResult: repoFormatResult, // omitted for brevity, see the source of this page
        formatSelection: repoFormatSelection, // omitted for brevity, see the source of this page
        dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
        escapeMarkup: function (m) {
            return m;
        } // we do not want to escape markup since we are displaying html in results
    });

</script>