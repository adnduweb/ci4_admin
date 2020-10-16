<?= $this->extend('/admin/themes/metronic/__layouts/layout_1') ?>
<?= $this->section('main') ?>
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
	<?= form_open('', ['id' => 'kt_apps_tabs_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
	<input type="hidden" name="action" value="<?= $action; ?>" />
	<input type="hidden" name="controller" value="AdminTabController" />

	<?= $this->include('/admin/themes/metronic/__partials/kt_form_toolbar') ?>

	<!-- begin:: Content -->
	<div id="ContentRoles" class="d-flex flex-column-fluid">
		<!--Begin::App-->
		<div class="container-fluid">
			<div class="flex-row ">
				<div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
					<div class="alert-icon">
						<span class="svg-icon svg-icon-primary svg-icon-xl">
							<!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Tools/Compass.svg-->
							<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
								<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
									<rect x="0" y="0" width="24" height="24"></rect>
									<path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"></path>
									<path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"></path>
								</g>
							</svg>
							<!--end::Svg Icon-->
						</span>
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
							<a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1" role="tab">
								<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
									<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
										<polygon points="0 0 24 0 24 24 0 24" />
										<path d="M12.9336061,16.072447 L19.36,10.9564761 L19.5181585,10.8312381 C20.1676248,10.3169571 20.2772143,9.3735535 19.7629333,8.72408713 C19.6917232,8.63415859 19.6104327,8.55269514 19.5206557,8.48129411 L12.9336854,3.24257445 C12.3871201,2.80788259 11.6128799,2.80788259 11.0663146,3.24257445 L4.47482784,8.48488609 C3.82645598,9.00054628 3.71887192,9.94418071 4.23453211,10.5925526 C4.30500305,10.6811601 4.38527899,10.7615046 4.47382636,10.8320511 L4.63,10.9564761 L11.0659024,16.0730648 C11.6126744,16.5077525 12.3871218,16.5074963 12.9336061,16.072447 Z" fill="#000000" fill-rule="nonzero" />
										<path d="M11.0563554,18.6706981 L5.33593024,14.122919 C4.94553994,13.8125559 4.37746707,13.8774308 4.06710397,14.2678211 C4.06471678,14.2708238 4.06234874,14.2738418 4.06,14.2768747 L4.06,14.2768747 C3.75257288,14.6738539 3.82516916,15.244888 4.22214834,15.5523151 C4.22358765,15.5534297 4.2250303,15.55454 4.22647627,15.555646 L11.0872776,20.8031356 C11.6250734,21.2144692 12.371757,21.2145375 12.909628,20.8033023 L19.7677785,15.559828 C20.1693192,15.2528257 20.2459576,14.6784381 19.9389553,14.2768974 C19.9376429,14.2751809 19.9363245,14.2734691 19.935,14.2717619 L19.935,14.2717619 C19.6266937,13.8743807 19.0546209,13.8021712 18.6572397,14.1104775 C18.654352,14.112718 18.6514778,14.1149757 18.6486172,14.1172508 L12.9235044,18.6705218 C12.377022,19.1051477 11.6029199,19.1052208 11.0563554,18.6706981 Z" fill="#000000" opacity="0.3" />
									</g>
								</svg> <?= lang('Core.tab_general'); ?>
							</a>
						</li>
					</ul>
					<div class="tab-content mt-5">
						<div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
							<div class="kt-form kt-form--label-right">
								<div class="kt-form__body">
									<div class="kt-section kt-section--first">
										<div class="kt-section__body">
											<?= $this->include('/admin/themes/metronic/controllers/tabs/__form_section/general') ?>
											<?= view('/admin/themes/metronic/__partials/icons_svg', [], ['cache' => 300, 'cache_name' => 'icons_svg']) ?>
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