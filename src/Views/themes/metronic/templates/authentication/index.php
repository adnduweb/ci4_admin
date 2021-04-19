<?= $this->extend('Adnduweb\Ci4Admin\themes\metronic\__layouts\layout_login') ?>
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
                        <img src="<?= assetAdmin('/media/logos/logo-4.png'); ?>" class="max-h-70px" alt="">
                    </a>
                    <!--end::Logo-->

                    <!--begin::Signin-->
                    <div class="login-form">

                    <?= view('Adnduweb\Ci4Admin\themes\metronic\__partials\message_block') ?>

                        <!--begin::Form-->
                        <?= form_open('', ['id' => 'kt_login_singin_form', 'class' => 'form form-login']); ?>
                        <!--begin::Title-->
                        <div class="pb-5 pb-lg-15">
                            <h3 class="font-weight-bolder text-dark font-size-h2 font-size-h1-lg"><?= lang("Core.sign_in"); ?></h3>
                        </div>
                        <!--begin::Title-->

                        <!--begin::Form group-->
                        <div class="form-group">
                            <label class="font-size-h6 font-weight-bolder text-dark"><?= lang("Core.your_email"); ?></label>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="email" placeholder="<?= lang('Auth.emailOrUsername') ?>" name="login" autocomplete="off" value="admin@admin.com">
                        </div>
                        <!--end::Form group-->

                        <!--begin::Form group-->
                        <div class="form-group">
                            <div class="d-flex justify-content-between mt-n5">
                                <label class="font-size-h6 font-weight-bolder text-dark pt-5"><?= lang("Core.your_password"); ?></label>

                                <a href="/<?= CI_AREA_ADMIN; ?>/forgot-password" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">
                                    <?= lang('Auth.forgotYourPassword') ?>
                                </a>
                            </div>
                            <input class="form-control form-control-solid h-auto py-7 px-6 rounded-lg border-0" type="password" placeholder="<?= lang('Auth.password') ?>" name="password" value="123456">
                        </div>
                        <!--end::Form group-->

                        <?php if ($config->allowRemembering): ?>
                        <div class="form-group">
                            <label class="checkbox">
                                <input type="checkbox" name="remember" class="form-check-input" <?php if(old('remember')) : ?> checked <?php endif ?>>
                                <span></span>&nbsp;<?=lang('Auth.rememberMe')?>
                            </label>
						</div>
                        <?php endif; ?>

                        <!--begin::Action-->
                        <div class="pb-lg-0 pb-5">
                            <button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-primary font-weight-bolder font-size-h6 px-8 py-4 my-3 mr-3"><?= lang('Auth.loginAction') ?></button>
                        </div>
                        <!--end::Action-->
                        <?= form_close(); ?>
                        <!--end::Form-->
                    </div>
                    <!--end::Signin-->
                    <div class="kt-login__account">
                        <span class="kt-login__account-msg">
                            © <?= date('Y'); ?> <?= ucfirst(env('app.siteName')); ?>
                        </span>
                        &nbsp;&nbsp;
                        <a href="<?= base_urlFront('/vie-privee', null, false); ?>" id="" class="kt-login__account-link"><?= lang('Core.privacy'); ?></a>
                    </div>
                </div>
                <!--end::Wrapper-->
            </div>
            <!--begin::Content-->

            <!--begin::Aside-->
            <div class="login-aside order-1 order-lg-2 bgi-no-repeat bgi-position-x-right">
                <div class="login-conteiner bgi-no-repeat bgi-position-x-right bgi-position-y-bottom" style="background-image: url(<?= assetAdmin('/media/svg/illustrations/login-visual-4.svg'); ?>);">
                    <!--begin::Aside title-->
                    <h3 class="pt-lg-40 pl-lg-20 pb-lg-0 pl-10 py-20 m-0 d-flex justify-content-lg-start font-weight-boldest display5 display1-lg text-white">
                        <?= lang("Core.login__title"); ?><br />
                        <?= lang("Core.login__title2"); ?>
                    </h3>
                    <!--end::Aside title-->
                </div>
            </div>
            <!--end::Aside-->
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
    <?= $this->endSection() ?>
