<?php

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<script>
	var HOST_URL = "<?= current_url(); ?>";
</script>
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
	var KTAppSettings = <?= json_encode(config('Theme')->layout['js'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>;
	var optionsPortlet = {
		bodyToggleSpeed: 400,
		tooltips: true,
		tools: {
			toggle: {
				collapse: _LANG_.expand,
				expand: _LANG_.collapse
			},
			reload: _LANG_.reload,
			remove: _LANG_.remove,
			fullscreen: {
				on: 'Fullscreen',
				off: 'Exit Fullscreen'
			}
		},
		sticky: {
			offset: 300,
			zIndex: 101
		}
	};
</script>
<!-- end::Global Config -->

<!-- Global Theme JS Bundle (used by all pages)  -->
<?php foreach (Config('Theme')->layout['resources']['js'] as $script) { ?>
<script type="text/javascript" src="<?= assetAdmin($script); ?>?v=<?= Config('Theme')->version; ?>&t<?= filemtime(env('DOCUMENT_ROOT') . '/admin/themes/'.$theme_admin.'/assets/' . $script); ?>"></script>
<?php } ?> 

<!-- Global Theme JS Bundle (used by all pages)  -->
<script type="text/javascript" src="<?= assetAdmin('/js/app.js'); ?>?v=<?= Config('Theme')->version; ?>&t<?= filemtime(env('DOCUMENT_ROOT') . '/admin/themes/'.$theme_admin.'/assets/js/app.js'); ?>"></script>

<?= Theme::js(); ?>
<?= Theme::message(); ?>
<!--end::Page Scripts -->

<?= $this->renderSection('extra-js') ?>