<!DOCTYPE html>
<html lang="<?= service('request')->getLocale(); ?>">

<head>
    <base href="/">
    <meta charset="utf-8" />
    <title><?= lang('Core.change_pasword'); ?> | Adnduweb</title>
    <meta name="description" content="Administration du service Adnduweb">
    <meta http-equiv="X-UA-Compatible" content="requiresActiveX=true" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0, shrink-to-fit=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="robots" content="noindex, nofollow" />
    <link rel="apple-touch-icon" sizes="57x57" href="/admin/themes/metronic/favicons/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/admin/themes/metronic/favicons/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/admin/themes/metronic/favicons/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/admin/themes/metronic/favicons/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/admin/themes/metronic/favicons/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/admin/themes/metronic/favicons/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/admin/themes/metronic/favicons/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/admin/themes/metronic/favicons/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/admin/themes/metronic/favicons/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/admin/themes/metronic/favicons/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/admin/themes/metronic/favicons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/admin/themes/metronic/favicons/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/admin/themes/metronic/favicons/favicon-16x16.png">
    <link rel="manifest" href="/admin/themes/metronic/favicons/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/admin/themes/metronic/favicons/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <?= csrf_meta() ?>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">

    <link href="/admin/themes/metronic/css/pages/login/login-3.css" rel="stylesheet" type="text/css" />
    <link href="/admin/themes/metronic/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
    <link href="/admin/themes/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />

    <link href="/admin/themes/metronic/css/skins/header/base/light.css" rel="stylesheet" type="text/css" />
    <link href="/admin/themes/metronic/css/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
    <link href="/admin/themes/metronic/css/skins/brand/dark.css" rel="stylesheet" type="text/css" />
    <link href="/admin/themes/metronic/css/skins/aside/dark.css" rel="stylesheet" type="text/css" />

    <link rel="shortcut icon" href="/admin/themes/metronic/media/logos/favicon.ico" />
</head>

<!-- end::Head -->

<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

    <!-- begin:: Page -->
    <div class="kt-grid kt-grid--ver kt-grid--root">
        <div class="kt-grid kt-grid--hor kt-grid--root  kt-login kt-login--v3 kt-login--signin" id="kt_login">
            <div class="kt-grid__item kt-grid__item--fluid kt-grid kt-grid--hor" style="background-image: url(admin/themes/metronic/media/bg/bg-3.jpg);">
                <div class="kt-grid__item kt-grid__item--fluid kt-login__wrapper">
                    <div class="kt-login__container">
                        <div class="kt-login__logo">
                            <a href="#">
                                <img src="/admin/themes/metronic/media/logos/logo-5.png">
                            </a>
                        </div>
                        <div class="kt-login__change">
                            <div class="kt-login__head">
                                <h3 class="kt-login__title"><?= lang("Admin.login__title"); ?></h3>
                                <!-- <div class="kt-login__desc">Enter your details to create your account:</div> -->
                            </div>
                            <?= form_open('change-pass', ['id' => 'login_change_form', 'class' => 'kt-form kt-form-login_change']); ?>
                            <div class="input-group">
                                <input class="form-control" type="password" placeholder="<?= lang('Auth.newPassword') ?>" name="password">
                            </div>
                            <div class="input-group">
                                <input class="form-control" type="password" placeholder="<?= lang('Auth.newPasswordRepeat') ?>" name="pass_confirm">
                            </div>
                            <div class="kt-login__actions">
                                <input type="hidden" value="<?= user()->email; ?>" name="email">
                                <button id="kt_change_password" class="btn btn-brand btn-elevate kt-login__btn-primary"><?= lang("Admin.change_mot_de_passe"); ?></button>&nbsp;&nbsp;
                            </div>
                            <?= form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end:: Page -->

    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
	    var KTAppOptions = {"colors": {"state": {"brand": "#5d78ff","dark": "#282a3c","light": "#ffffff","primary": "#5867dd","success": "#34bfa3","info": "#36a3f7","warning": "#ffb822","danger": "#fd3995"},"base": {"label": ["#c5cbe3","#a1a8c3","#3d4465","#3e4466"],"shape": ["#f0f3ff","#d9dffa","#afb4d4","#646c9a"]}}};
    </script>

    <script src="/admin/themes/metronic/plugins/global/plugins.bundle.js" type="text/javascript"></script>
    <script src="/admin/themes/metronic/js/scripts.bundle.js" type="text/javascript"></script>
    <script src="/admin/themes/metronic/js/pages/custom/login/login-general.js" type="text/javascript"></script>

    <!--begin::Lang Skins(used by all pages) -->
    <script src="/admin/themes/metronic/js/language/lang_<?= service('request')->getLocale(); ?>.js" type="text/javascript"></script>
    <script type="text/javascript">
       <?php
        $htmlJs = "";
        foreach ($data['paramJs'] as $k => $v) {
            $htmlJs .= ' var ' . $k . ' = ';
            if (preg_match('`\[(.+)\]`iU', $v)) {
                $htmlJs .=  $v;
            } else {
                $htmlJs .= "'" . $v . "'";
            }

            $htmlJs .= '; ' . "\n";
        }
        echo $htmlJs;
        ?>
    </script>
</body>

</html>