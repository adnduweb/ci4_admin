    <!--begin::Aside-->
    <div class="flex-row-auto offcanvas-mobile w-300px w-xl-350px" id="kt_profile_aside">
        <!--begin::Card-->
        <div class="card card-custom">
            <!--begin::Body-->
            <div class="card-body pt-15">
                <!--begin::User-->
                <div class="text-center mb-10">
                    <div class="symbol symbol-60 symbol-circle symbol-xl-90">
                        <div class="symbol-label symbol-text"><?= $company->getRaisonSocial()[0]; ?> <?= $company->getRaisonSocial()[1]; ?></div>
                        <i class="symbol-badge symbol-badge-bottom bg-success"></i>
                    </div>

                    <h4 class="font-weight-bold my-2">
                        <?= $company->getRaisonSocial(); ?>
                    </h4>
                    <div class="text-muted mb-2">
                        <i class="flaticon2-correct kt-font-success"></i>
                        <?= $company->getCodeCompany(); ?>
                    </div>
                </div>
                <!--end::User-->

                <!--begin::Contact-->
                <div class="mb-10 text-center">

                    <div class="kt-widget__info">
                        <span class="kt-widget__label"> <?= lang('Core.email');  ?>:</span>
                        <a href="#" class="kt-widget__data"><?= $company->getEmail(); ?></a>
                    </div>
                    <div class="kt-widget__info">
                        <span class="kt-widget__label"><?= lang('Core.phone');  ?>:</span>
                        <a href="tel:<?= $company->getTelephoneFixe(); ?>" class="kt-widget__data"><?= $company->getTelephoneFixe(); ?></a>
                    </div>
                    <div class="kt-widget__info">
                        <span class="kt-widget__label"><?= lang('Core.location');  ?>:</span>
                        <span class="kt-widget__data"><?= $company->getLocation(); ?></span>
                    </div>

                </div>
                <!--end::Contact-->

                <!--begin::Nav-->
                <a href="/<?= CI_AREA_ADMIN; ?>/fiche-contact/compte-entreprise" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block <?= ($aside_active == 'compte-entreprise') ? 'active' : ''; ?>">
                    <?= lang('Core.Compte Entreprise');  ?>
                </a>
                <a href="/<?= CI_AREA_ADMIN; ?>/fiche-contact/compte-personnel" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block <?= ($aside_active == 'compte-personnel') ? 'active' : ''; ?>">
                    <?= lang('Core.Compte Personnel'); ?>
                </a>
                <a href="/<?= CI_AREA_ADMIN; ?>/fiche-contact/reseaux-sociaux" class="btn btn-hover-light-primary font-weight-bold py-3 px-6 mb-2 text-center btn-block <?= ($aside_active == 'reseaux-sociaux') ? 'active' : ''; ?>">
                    <?= lang('Core.Reseaux sociaux');  ?>
                </a>
                <!--end::Nav-->
            </div>
            <!--end::Body-->
        </div>
        <!--end::Card-->
    </div>
    <!--end::Aside-->