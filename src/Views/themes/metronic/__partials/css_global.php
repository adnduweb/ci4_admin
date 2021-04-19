<?php

use \Adnduweb\Ci4Admin\Libraries\Theme; 

?>

<link rel="shortcut icon" href="<?= assetAdminFavicons('favicon.ico'); ?>" />

<!-- Fonts -->
<?= Theme::getGoogleFontsInclude(); ?>
<!--end::Fonts -->

<!--begin::Page Vendors Styles(used by this page) -->
<link href="<?= assetAdmin('/plugins/custom/fullcalendar/fullcalendar.bundle.css'); ?>" rel="stylesheet" type="text/css" />

<!-- Global Theme Styles (used by all pages) -->
<?php foreach (Config('Theme')->layout['resources']['css'] as $style) { ?>
<link href="<?= assetAdmin($style); ?>" rel="stylesheet" type="text/css" />
<?php } ?>

<!-- Layout Themes (used by all pages) -->
<?php foreach (Theme::initThemes() as $theme) { ?>
<link href="<?= (Config('Theme')->layout['self']['rtl']) ? assetAdmin(Theme::rtlCssPath($theme)) : assetAdmin($theme); ?>" rel="stylesheet" type="text/css" />
<?php } ?>

<link href="<?= assetAdmin('/css/app.css'); ?>" rel="stylesheet" type="text/css" />

<?= $this->include('\Adnduweb\Ci4Admin\themes\/'.$theme_admin.'/\__partials\js_params') ?>