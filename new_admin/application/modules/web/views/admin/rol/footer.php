<script src="<?= baseAdminUrl() ?>plugins/jQuery/jQuery-2.1.4.min.js"></script><script src="<?= baseAdminUrl() ?>js/bootstrap.min.js" type="text/javascript"></script><script src="<?= baseAdminUrl() ?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script><script src='<?= baseAdminUrl() ?>plugins/fastclick/fastclick.min.js'></script><script src="<?= baseAdminUrl() ?>js/app.min.js" type="text/javascript"></script><script src="<?= baseAdminUrl() ?>js/demo.js" type="text/javascript"></script><link href="<?= baseAdminUrl() ?>css/select2/select2.min.css" rel="stylesheet" type="text/css" /><script src="<?= baseAdminUrl() ?>js/select2/select2.min.js"></script><script src="<?= baseAdminUrl() ?>js/select2/es.js"></script><script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.js"></script><script src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/locale/bootstrap-table-es-AR.min.js"></script><script src="<?= baseAdminUrl() ?>js/plugins/metisMenu/metisMenu.min.js"></script><script src="<?= baseAdminUrl() ?>js/jquery.validate.min.js"></script><script src="<?= baseAdminUrl() ?>js/additional-methods.min.js"></script><script src="<?= baseAdminUrl() ?>public/js/export/bootstrap-table-export.min.js"></script><script src="<?= baseAdminUrl() ?>public/js/export/tableExport.min.js"></script><script>    $(document).ready(function () {        $(".content").on("click", "a.editar", function (e) {            e.preventDefault();            var rol_id = $(this).attr("href");            $("#rol_id").val(rol_id);            $.ajax({                type: "POST",                data: {id: rol_id},                url: '<?= base_url() ?>rolByAjax',                dataType: 'json'            })                    .done(function (datos) {                        $("#rol_nombre").val(datos.rol_nombre);                        $("#rol_descripcion").val(datos.rol_descripcion);                        $("#rol_id").val(datos.rol_id);                        $("#permisos option").attr('selected', false);                        $("#permisos option").each(function (id_option, option)                        {                            option_val = $(option).val();                            $(datos.permisos).each(function (id, permiso)                            {                                if (permiso.permiso_id == option_val) {                                    $(option).attr('selected', true);                                }                            });                        });                    });        });    });</script>  </body></html>