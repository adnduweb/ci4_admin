<?php

use \App\Libraries\Metronic;

?>

<link rel="shortcut icon" href="<?= assetAdmin('/favicons/favicon.ico'); ?>" />

<!-- Fonts -->
<?= Metronic::getGoogleFontsInclude(); ?>
<!--end::Fonts -->
<link href="<?= assetAdmin('/css/app.css'); ?>" rel="stylesheet" type="text/css" />
<!--begin::Page Vendors Styles(used by this page) -->
<link href="<?= assetAdmin('/plugins/custom/fullcalendar/fullcalendar.bundle.css'); ?>" rel="stylesheet" type="text/css" />

<!-- Global Theme Styles (used by all pages) -->
<?php foreach (Config('Metronic')->layout['resources']['css'] as $style) { ?>
    <link href="<?= assetAdmin($style); ?>" rel="stylesheet" type="text/css" />
<?php } ?>

<!-- Layout Themes (used by all pages) -->
<?php foreach (Metronic::initThemes() as $theme) { ?>
    <link href="<?= (Config('Metronic')->layout['self']['rtl']) ? assetAdmin(Metronic::rtlCssPath($theme)) : assetAdmin($theme); ?>" rel="stylesheet" type="text/css" />
<?php } ?>

<!-- <link href="<?= assetAdmin('/css/custom.css'); ?>" rel="stylesheet" type="text/css" /> -->

<?= $this->include('/admin/themes/' . $theme_admin . '/__partials/js_params') ?>