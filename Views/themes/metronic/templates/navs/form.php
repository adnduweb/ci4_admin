<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<?= $this->extend('Adnduweb\Ci4Admin\themes\metronic\__layouts\layout_1') ?>
<?= $this->section('main') ?>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<?= form_open('', ['id' => 'kt_apps_navs_add_user_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
	<input type="hidden" name="action" value="<?= $action; ?>" />


	<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\__partials\kt_form_toolbar') ?>

	<!-- begin:: Content -->
	<div id="ContentRoles" class="d-flex flex-column-fluid">
		<!--Begin::App-->
		<div class="container-fluid">
			<div class="flex-row ">
				<div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
					<div class="alert-icon">
						<?= Theme::getSVG('assets/media/svg/icons/Tools/Compass.svg', 'svg-icon svg-icon-sm', true); ?> 
					</div>
					<div class="alert-text">
						<?= lang('Core.Si vous modifier l\'url du <code>Menu/Controller</code> il ne faut pas oublier d\'aller dans le menu route'); ?>.
						<br>
						<?= lang('Core.Si vous décidez de foncer et de tout de même modifier le code directement, utilisez un gestionnaire de fichiers pour en créer une copie avec un autre nom et gardez-le près du code original. Ainsi, vous pourrez réactiver une version fonctionnelle si quelque chose tourne mal.'); ?>
					</div>
				</div>
			</div>



			<div class="flex-row ">
				<div class="card card-custom py-5 px-5">
					<ul class="nav nav-tabs nav-tabs-line mb-5" role="tablist">
						<li class="nav-item">
								<?= Theme::getSVG('assets/media/svg/icons/Design/Layers.svg', 'svg-icon svg-icon-sm', true); ?> 
								<?= lang('Core.tab_general'); ?>
							</a>
						</li>
					</ul>
					<div class="tab-content mt-5">
						<div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
							<div class="kt-form kt-form--label-right">
								<div class="kt-form__body">
									<div class="kt-section kt-section--first">
										<div class="kt-section__body">
											<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\navs\__form_section\general') ?>
											<?= view('Adnduweb\Ci4Admin\themes\metronic\__partials\icons_svg', [], ['cache' => 300, 'cache_name' => 'icons_svg']) ?>
										</div>
									</div>
								</div>
							</div>
						</div>
						</>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end:: Content -->
	<?= form_close(); ?>
</div>
<?= $this->endSection() ?>