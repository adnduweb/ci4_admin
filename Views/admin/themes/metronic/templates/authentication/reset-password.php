<?= $this->extend('/admin/themes/metronic/__layouts/layout_login') ?>
<?= $this->section('main') ?>

<!--begin::Main-->
<div class="d-flex flex-column flex-root">
	<!--begin::Login-->
	<div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid">
		<!--begin::Content-->
		<div class="login-container order-2 order-lg-1 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-white">
			<!--begin::Wrapper-->
			<div class="login-content d-flex flex-column pt-lg-0 pt-12">
				<!--begin::Logo-->
				<a href="#" class="login-logo pb-xl-20 pb-15">
					<img src="/metronic/theme/html/demo1/dist/assets/media/logos/logo-4.png" class="max-h-70px" alt="">
				</a>
				<!--end::Logo-->
				<!--begin::Signin-->
				<div class="login-form">
					<?= form_open(uri_string(), ['id' => 'kt_login_reset_forgot_form', 'class' => 'kt-form form fv-plugins-bootstrap fv-plugins-framework', 'novalidate' => 'novalidate']); ?>
					<!--begin::Title-->
					<div class="pb-5 pb-lg-15">
						<h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg">Reset Forgotten Password ?</h3>
						<p class="text-muted font-weight-bold font-size-h4">Enter your email to reset your password</p>
					</div>
					<!--end::Title-->
					<!--begin::Form group-->
					<div class="form-group fv-plugins-icon-container">
						<input class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h" type="text" placeholder="<?= lang('Auth.token') ?>" name="token" value="<?= old('token', $token ?? '') ?>" autocomplete="off" kl_vkbd_parsed="true">
						<div class="fv-plugins-message-container"></div>
					</div>
					<!--end::Form group-->

					<!--begin::Form group-->
					<div class="form-group fv-plugins-icon-container">
						<input class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" type="email" placeholder="<?= lang('Auth.email') ?>" name="email" autocomplete="off" value="<?= old('email') ?>" autocomplete="off" kl_vkbd_parsed="true">
						<div class="fv-plugins-message-container"></div>
					</div>
					<!--end::Form group-->

					<!--begin::Form group-->
					<div class="form-group fv-plugins-icon-container">
						<input class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" type="password" placeholder="<?= lang('Auth.newPassword') ?>" name="password" autocomplete="off" kl_vkbd_parsed="true">
						<div class="fv-plugins-message-container"></div>
					</div>
					<!--end::Form group-->

					<!--begin::Form group-->
					<div class="form-group fv-plugins-icon-container">
						<input class="form-control form-control-solid h-auto py-7 px-6 border-0 rounded-lg font-size-h6" type="password" placeholder="<?= lang('Auth.newPasswordRepeat') ?>" name="pass_confirm" autocomplete="off" kl_vkbd_parsed="true">
						<div class="fv-plugins-message-container"></div>
					</div>
					<!--end::Form group-->

					<!--begin::Form group-->
					<div class="form-group d-flex flex-wrap">
						<button type="submit" id="kt_login_reset_forgot_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-4"><?= lang('Auth.valider') ?></button>
						<a href="/<?= CI_AREA_ADMIN; ?>" id="kt_login_reset_forgot_cancel" class="btn btn-light-primary font-weight-bolder font-size-h6 px-8 py-4 my-3"><?= lang('Auth.cancel') ?></a>
					</div>
					<!--end::Form group-->
					<input type="hidden" kl_vkbd_parsed="true">
					<div>
					</div>
					<?= form_close(); ?>
				</div>
				<!--end::Signin-->
			</div>
			<!--end::Wrapper-->
		</div>
		<!--begin::Content-->
		<!--begin::Aside-->
		<div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right">
			<div class="login-conteiner bgi-no-repeat bgi-position-x-right bgi-position-y-bottom" style="background-image: url(<?= assetAdmin('/media/svg/illustrations/login-visual-4.svg'); ?>);">
				<!--begin::Aside title-->
				<h3 class="pt-lg-40 pl-lg-20 pb-lg-0 pl-10 py-20 m-0 d-flex justify-content-lg-start font-weight-boldest display5 display1-lg text-white">We Got
					<br>A Surprise
					<br>For You</h3>
				<!--end::Aside title-->
			</div>
		</div>
		<!--end::Aside-->
	</div>
	<!--end::Login-->
</div>

<?= $this->endSection() ?>