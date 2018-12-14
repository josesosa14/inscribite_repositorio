<script type='text/javascript'>
    function actionFormatter(value, row, index) {
        return [
            '<a class="edit ml10" href="javascript:void(0)" title="Editar">',
            '<i class="glyphicon glyphicon-edit"></i>',
            '</a> &nbsp;&nbsp;'
        ].join('');
    }
    window.actionEvents = {
        'click .edit': function (e, value, row, index) {
            window.location.href = ('<?= base_url() ?>variables/' + row.id);
        }
    };

</script>