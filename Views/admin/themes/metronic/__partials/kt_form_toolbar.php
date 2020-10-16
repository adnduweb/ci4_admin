<div class="subheader py-2  subheader-solid " id="kt_subheader">
    <div class="container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">

        <div class="d-flex align-items-center flex-wrap mr-1">
            <h5 class="text-dark font-weight-bold my-2 mr-5">
                <?= ucfirst(${$action . '_title'}); ?>
            </h5>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <small class="kt-subheader__group">
                <?php if ($action == 'edit') { ?>
                    <span class="kt-subheader__desc" id="kt_subheader_total">
                        <?= ucfirst($title_detail); ?> </span>
                <?php } ?>
            </small>
        </div>

        <div class="kt-subheader__toolbar">
            <?php if ($multilangue == true) { ?>
                <?php if (service('Settings')->setting_activer_multilangue == true) { ?>
                    <?php $setting_supportedLocales = unserialize(service('Settings')->setting_supportedLocales); ?>
                    <div class="lang_tabs" data-dft-lang="<?= service('Settings')->setting_lang_iso; ?>" style="display: block;">

                        <?php foreach ($setting_supportedLocales as $k => $v) {
                            $langExplode = explode('|', $v); ?>
                            <a href="javascript:;" data-lang="<?= $langExplode[1]; ?>" data-id_lang="<?= $langExplode[0]; ?>" class="btn <?= (service('Settings')->setting_id_lang == $langExplode[0]) ? 'active'  : ''; ?> lang_tab btn-outline-brand"><?= ucfirst($langExplode[1]); ?></a>
                        <?php   } ?>
                    </div>
                <?php   } ?>
            <?php   } ?>
            <?php if (isset($toolbarBack) && $toolbarBack == true) { ?>
                <a href="/<?= env('CI_AREA_ADMIN'); ?><?= $backPathController; ?>" class="btn btn-default font-weight-bolder btn-sm">
                    <?= ucfirst(lang('Core.back')); ?>
                </a>
            <?php } ?>

            <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="submit" name="submithandler" value="save_continue" class="btn btn-light-primary font-weight-bolder btn-sm">
                    <?= ucfirst(lang('Core.saves_changes')); ?>
                </button>
                <button type="button" class="btn btn-light-primary font-weight-bolder btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                    <button type="submit" name="submithandler" value="save_continue" class="link dropdown-item">
                        <i class="kt-nav__link-icon flaticon2-writing"></i>
                        <?= ucfirst(lang('Core.save_continue')); ?>
                    </button>
                    <button type="submit" name="submithandler" value="save_and_new" class="link dropdown-item">
                        <i class="kt-nav__link-icon flaticon2-medical-records"></i>
                        <?= ucfirst(lang('Core.save_and_new')); ?>
                    </button>
                    <button type="submit" name="submithandler" value="save_and_exit" class="link dropdown-item">
                        <i class="kt-nav__link-icon flaticon2-hourglass-1"></i>
                        <?= ucfirst(lang('Core.save_and_exit')); ?>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>