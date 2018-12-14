<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>EPSA | Guardavidas</title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link href="<?= baseAdminUrl() ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= baseAdminUrl() ?>css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= baseAdminUrl() ?>css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= baseAdminUrl() ?>css/jquery-confirm.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.8.1/bootstrap-table.min.css">
        <link href="<?= baseAdminUrl() ?>css/style.css" rel="stylesheet" type="text/css" />
        <link type='image/png' rel='icon' href='<?= base_url() ?>public/images/favicon.ico'/>
    </head>
    <script>
        function get_base_url() {
            return "<?= base_url() ?>";
        }
        function get_argit_token() {
            return "<?= $this->security->get_csrf_hash(); ?>";
        }
    </script>
    <body class="skin-blue sidebar-mini fixed">