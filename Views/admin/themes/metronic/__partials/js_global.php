<?php

use \App\Libraries\Metronic;
use App\Libraries\AssetsBO;
use App\Libraries\Tools;

?>
<script>
	var HOST_URL = "<?= current_url(); ?>";
</script>
<!-- begin::Global Config(global config for global JS sciprts) -->
<script>
	var KTAppSettings = <?= json_encode(config('Metronic')->layout['js'], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES); ?>;
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
<?php foreach (Config('Metronic')->layout['resources']['js'] as $script) { ?>
	<script type="text/javascript" src="<?= assetAdmin($script); ?>?v=<?= Config('Metronic')->version; ?>"></script>
<?php } ?>

<!-- Global Theme JS Bundle (used by all pages)  -->
<script type="text/javascript" src="<?= assetAdmin('/js/app.js'); ?>?v=<?= Config('App')->sp_version; ?>"></script>

<?= AssetsBO::js(); ?>


<?= Tools::message(); ?>
<!--end::Page Scripts -->
<?= $this->renderSection('extra-js') ?>