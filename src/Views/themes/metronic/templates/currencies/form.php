<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<?= $this->extend('Adnduweb\Ci4Admin\themes\metronic\__layouts\layout_1') ?>
<?= $this->section('main') ?>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

	<?= form_open('', ['id' => 'kt_apps_user_add_user_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
	<input type="hidden" name="action" value="<?= $action; ?>" />


	<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\__partials\kt_form_toolbar') ?>

	<!-- begin:: Content -->
	<div id="ContentRoles" class="d-flex flex-column-fluid">
		<!--Begin::App-->
		<div class="container-fluid">
			<div class="flex-row ">
				<div class="card card-custom py-5 px-5">
					<ul class="nav nav-tabs nav-tabs-line mb-5" role="tablist">
						<li class="nav-item">
							<a class="nav-link active" data-toggle="tab" href="<?= base_url(uri_string()); ?>#kt_user_edit_tab_1" role="tab">
								<?= Theme::getSVG('media/svg/icons/Design/Layers.svg', 'svg-icon svg-icon-sm', true); ?> 	
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
											<?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\currencies\__form_section\general') ?>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>


	<!-- end:: Content -->
	<?= form_close(); ?>
</div>
<?= $this->endSection() ?>