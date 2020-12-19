<div class="subheader py-2  subheader-solid " id="kt_subheader">
    <div class="container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">

        <div class="d-flex align-items-center flex-wrap mr-1">
            <h5 class="text-dark font-weight-bold my-2 mr-5">
                <?= lang('Core.your_fiche_entreprise'); ?>
            </h5>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
        </div>
        <div class="kt-subheader__toolbar">
            <?php if (service('Settings')->setting_activer_multilangue == true) { ?>
                <?php $setting_supportedLocales = json_decode(service('Settings')->setting_supportedLocales); ?>
                <div class="lang_tabs" data-dft-lang="<?= service('Settings')->setting_lang_iso; ?>" style="display: block;">

                    <?php foreach ($setting_supportedLocales as $k => $v) {
                        $langExplode = explode('|', $v); ?>
                        <a href="javascript:;" data-lang="<?= $langExplode[1]; ?>" data-id_lang="<?= $langExplode[0]; ?>" class="btn <?= (service('Settings')->setting_id_lang == $langExplode[0]) ? 'active'  : ''; ?> lang_tab btn-outline-brand"><?= ucfirst($langExplode[1]); ?></a>
                    <?php   } ?>
                </div>

            <?php   } ?>
        </div>
    </div>
</div>