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
            window.location.href = ('<?=base_url()?>decodificado_renglones/'+row.id);
        },
        'click .delete': function (e, value, row, index) {
            window.location.href = ('<?=base_url()?>borrardecodificado_renglones/'+row.id);
        }
        };

        </script>