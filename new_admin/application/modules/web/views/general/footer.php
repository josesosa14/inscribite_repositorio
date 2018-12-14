</div><!-- /.content-wrapper -->
<footer class="main-footer">
    <div class="pull-right hidden-xs">
        <b>Version</b> 1.0
    </div>
</footer>


<!--jquery-->
<script src="<?= baseAdminUrl() ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
<!--bootstrapy-->
<script src="<?= baseAdminUrl() ?>js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?= baseAdminUrl() ?>js/datepicker/js/bootstrap-datepicker.min.js"></script>
<script src="<?= baseAdminUrl() ?>js/table/bootstrap-table.min.js"></script>
<script src="<?= baseAdminUrl() ?>js/table/locale/bootstrap-table-es-AR.min.js"></script>
<!--slim-->
<script src="<?= baseAdminUrl() ?>plugins/slimScroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<!--fast-->
<script src='<?= baseAdminUrl() ?>plugins/fastclick/fastclick.min.js'></script>
<script src="<?= baseAdminUrl() ?>js/app.min.js" type="text/javascript"></script>
<script src="<?= baseAdminUrl() ?>js/demo.js" type="text/javascript"></script>
<script src="<?= baseAdminUrl() ?>js/jquery-confirm.js" type="text/javascript"></script>
<link href="<?= baseAdminUrl() ?>css/select2/select2.min.css" rel="stylesheet" type="text/css" />
<script src="<?= baseAdminUrl() ?>js/select2/select2.min.js"></script>
<script src="<?= baseAdminUrl() ?>js/select2/es.js"></script>
<script src="<?= baseAdminUrl() ?>js/mask/jquery.mask.min.js"></script>
<script src="<?= baseAdminUrl() ?>js/validation/jquery.validate.min.js"></script>
<script src="<?= baseAdminUrl() ?>js/validation/additional-methods.min.js"></script>
<script src="<?= baseAdminUrl() ?>js/validation/localization/messages_es_AR.min.js"></script>

<script>


    function repoFormatResult(repo) {
        var markup = '<div class="row-fluid">' +
                '<div class="span10">' +
                '<div class="row-fluid">' +
                '<div class="span6">' + repo.text + '</div>' +
                '<div class="span3"><i class="fa fa-code-fork"></i> ' + repo.text + '</div>' +
                '</div>';
        if (repo.description) {
            markup += '<div>' + repo.description + '</div>';
        }
        markup += '</div></div>';
        return markup;
    }
    function repoFormatSelection(repo) {
        return repo.id;
    }
</script>
</body>
</html>