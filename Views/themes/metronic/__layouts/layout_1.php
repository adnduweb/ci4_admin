<?php

use \App\Libraries\Theme; ?>
<!DOCTYPE html>
<html class="<?= $html; ?>" lang="<?= service('request')->getLocale(); ?>">

<head>
	<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/head') ?>
	<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/css_global') ?>
</head>


<!-- begin::Body -->

<body id="kt_body"  <?= Theme::printAttrs('body'); ?> <?= Theme::printClasses('body'); ?> >
	<?php if (Config('Theme')->layout['page-loader']['type'] != ''){ ?>
		<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/kt_page_loader') ?>
	<?php } ?>

	<!-- begin:: Page -->

	<!--begin::Header Mobile-->
	<div id="kt_header_mobile" class="header-mobile align-items-center  header-mobile-fixed ">
		<!--begin::Logo-->
		<a href="index.html">
			<img alt="Logo" src="<?= assetAdmin('media/logos/logo-light.png'); ?>" />
		</a>
		<!--end::Logo-->

		<!--begin::Toolbar-->
		<div class="d-flex align-items-center">
			<!--begin::Aside Mobile Toggle-->
			<button class="btn p-0 burger-icon burger-icon-left" id="kt_aside_mobile_toggle">
				<span></span>
			</button>
			<!--end::Aside Mobile Toggle-->

			<!--begin::Header Menu Mobile Toggle-->
			<button class="btn p-0 burger-icon ml-4" id="kt_header_mobile_toggle">
				<span></span>
			</button>
			<!--end::Header Menu Mobile Toggle-->

			<!--begin::Topbar Mobile Toggle-->
			<button class="btn btn-hover-text-primary p-0 ml-2" id="kt_header_mobile_topbar_toggle">
				<span class="svg-icon svg-icon-xl">
					<!--begin::Svg Icon | path:assets/media/svg/icons/General/User.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
						<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
							<polygon points="0 0 24 0 24 24 0 24" />
							<path d="M12,11 C9.790861,11 8,9.209139 8,7 C8,4.790861 9.790861,3 12,3 C14.209139,3 16,4.790861 16,7 C16,9.209139 14.209139,11 12,11 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" />
							<path d="M3.00065168,20.1992055 C3.38825852,15.4265159 7.26191235,13 11.9833413,13 C16.7712164,13 20.7048837,15.2931929 20.9979143,20.2 C21.0095879,20.3954741 20.9979143,21 20.2466999,21 C16.541124,21 11.0347247,21 3.72750223,21 C3.47671215,21 2.97953825,20.45918 3.00065168,20.1992055 Z" fill="#000000" fill-rule="nonzero" />
						</g>
					</svg>
					<!--end::Svg Icon--></span> </button>
			<!--end::Topbar Mobile Toggle-->
		</div>
		<!--end::Toolbar-->
	</div>
	<!--end::Header Mobile-->

	<div class="d-flex flex-column flex-root">
		<!--begin::Page-->
		<div class="d-flex flex-row flex-column-fluid page">

			<!-- begin:: Aside -->
			<!-- <div id="__partialsKtSide"> -->
			<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/kt_aside') ?>
			<!-- </div> -->
			<!-- end:: Aside -->

			<div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">

				<!-- begin:: Header -->
				<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/kt_header') ?>
				<!-- end:: Header -->

				<?= $this->renderSection('main') ?>

				<!-- begin:: Footer -->
				<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/kt_footer') ?>
				<!-- end:: Footer -->
			</div>
		</div>
	</div>
	<!-- end:: Page -->

	<!-- begin::Quick User -->
	<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/kt_quick_user') ?>
	<!-- end::Quick User -->

	<!-- begin::Quick Panel -->
	<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/kt_quick_panel') ?>
	<!-- end::Quick Panel -->

	<!-- begin::Outils de gestion de média -->
	<div id="kt_manager" class="kt-manager"></div>
	<!-- end::Outils de gestion de média -->

	<!-- begin::Scrolltop -->
	<div id="kt_scrolltop" class="kt-scrolltop">
		<i class="fa fa-arrow-up"></i>
	</div>
	<!-- end::Scrolltop -->

	<!-- begin::Modal -->
	<div id="kt_modal_loading_wrapper"></div>
	<!-- end::Modal -->

	<?= $this->include('/admin/themes/'.$theme_admin.'/__partials/js_global') ?>
</body>

<!-- end::Body -->

</html>