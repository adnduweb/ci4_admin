<?php

use \Adnduweb\Ci4Admin\Libraries\Theme; ?>
<!DOCTYPE html>
<html amp style="height: 100%!important;" lang="<?= service('request')->getLocale(); ?>" class="<?= detectBrowser(true);?>">

<head>
    <base href="/">
    <meta charset="utf-8" />
    <link rel="canonical" href="<?= base_url(CI_AREA_ADMIN); ?>">
    <title><?= (isset($data['metatitle'])) ? ucfirst($data['metatitle']) : ''; ?> | <?= service('settings')->setting_naneApp; ?></title>
    <style amp-boilerplate>
        body {
            -webkit-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            -moz-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            -ms-animation: -amp-start 8s steps(1, end) 0s 1 normal both;
            animation: -amp-start 8s steps(1, end) 0s 1 normal both
        }

        @-webkit-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-moz-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-ms-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @-o-keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }

        @keyframes -amp-start {
            from {
                visibility: hidden
            }

            to {
                visibility: visible
            }
        }
    </style><noscript>
        <style amp-boilerplate>
            body {
                -webkit-animation: none;
                -moz-animation: none;
                -ms-animation: none;
                animation: none
            }
        </style>
    </noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
    <meta name="description" content="Administration du service Adnduweb">
    <meta http-equiv="X-UA-Compatible" content="requiresActiveX=true" />
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0, shrink-to-fit=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black" />
    <meta name="robots" content="index, follow" />
    <link rel="apple-touch-icon" sizes="57x57" href="<?= assetAdmin('/favicons/apple-icon-57x57.png'); ?>">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= assetAdmin('/favicons/apple-icon-60x60.png'); ?>">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= assetAdmin('/favicons/apple-icon-72x72.png'); ?>">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= assetAdmin('/favicons/apple-icon-76x76.png'); ?>">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= assetAdmin('/favicons/apple-icon-114x114.png'); ?>">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= assetAdmin('/favicons/apple-icon-120x120.png'); ?>">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= assetAdmin('/favicons/apple-icon-144x144.png'); ?>">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= assetAdmin('/favicons/apple-icon-152x152.png'); ?>">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= assetAdmin('/favicons/apple-icon-180x180.png'); ?>">
    <link rel="icon" type="image/png" sizes="192x192" href="<?= assetAdmin('/favicons/android-icon-192x192.png'); ?>">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= assetAdmin('/favicons/favicon-32x32.png'); ?>">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= assetAdmin('/favicons/favicon-96x96.png'); ?>">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= assetAdmin('/favicons/favicon-16x16.png'); ?>">
    <link rel="manifest" href="<?= assetAdmin('/favicons/manifest.json'); ?>">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= assetAdmin('/favicons/ms-icon-144x144.png'); ?>">
    <meta name="theme-color" content="#ffffff">
    <?= csrf_meta() ?>


    <link rel="shortcut icon" href="<?= assetAdmin('/media/logos/favicon.ico'); ?>" />

    <!-- Fonts -->
    <?= Theme::getGoogleFontsInclude(); ?>

    <link href="<?= assetAdmin("/css/pages/login/login-4.css"); ?>" rel="stylesheet" type="text/css" />
    <!-- Global Theme Styles (used by all pages) -->
    <?php foreach (Config('Theme')->layout['resources']['css'] as $style) { ?>
        <link href="<?= assetAdmin($style); ?>" rel="stylesheet" type="text/css" />
    <?php } ?>

    <!-- Layout Themes (used by all pages) -->
    <?php foreach (Theme::initThemes() as $theme) { ?>
        <link href="<?= (Config('Theme')->layout['self']['rtl']) ? assetAdmin(Theme::rtlCssPath($theme)) : assetAdmin($theme); ?>" rel="stylesheet" type="text/css" />
    <?php } ?>

    <link href="<?= assetAdmin('/css/app.css'); ?>" rel="stylesheet" type="text/css" />

</head>

<!-- end::Head -->

<!-- begin::Body -->


<body id="kt_body"  style="height: 100%!important;" <?= Theme::printAttrs('body'); ?> <?= Theme::printClasses('body'); ?>  style="height: 100%!important;" >

    <?= $this->renderSection('main') ?>

    <!-- begin::Global Config(global config for global JS sciprts) -->
    <script>
        var KTAppSettings = <?= json_encode(config('Theme')->layout['js'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>
    </script>

    <!-- Global Theme JS Bundle (used by all pages)  -->
    <?php foreach (Config('Theme')->layout['resources']['js'] as $script) { ?>
        <script src="<?= assetAdmin($script); ?>" type="text/javascript"></script>
    <?php } ?>

    <?= Theme::js(); ?>
    <script src="admin/themes/metronic/resources/metronic/js/pages/custom/login/login-4.js" type="text/javascript"></script>

    <!--begin::Lang Skins(used by all pages) -->
    <script src=<?= assetAdmin("/js/language/lang_" . service('request')->getLocale() . ".js"); ?> type="text/javascript"></script>
    
</body>

</html>
