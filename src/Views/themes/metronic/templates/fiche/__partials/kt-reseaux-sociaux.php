<div class="flex-row-fluid ml-lg-8">
    <div class="card card-custom gutter-b">
        <div class="card-header py-5 mb-3">
            <div class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark"><?= lang('Core.Reseaux sociaux'); ?></span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm"><?= lang('Core.change your account settings'); ?></span>
            </div>
        </div>
        <form class="kt-form kt-form--label-right">
            <div class="card-body py-0">

                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
                            <div class="form-group row">
                                <label for="setting_reseaux_facebook" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_reseaux_facebook')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <input class="form-control" type="text" value="<?= old('setting_reseaux_facebook') ? old('setting_reseaux_facebook') : service('Settings')->setting_reseaux_facebook ?>" name="global[setting_reseaux_facebook]" id="setting_reseaux_facebook">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="setting_reseaux_twitter" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_reseaux_twitter')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <input class="form-control" type="text" value="<?= old('setting_reseaux_twitter') ? old('setting_reseaux_twitter') : service('Settings')->setting_reseaux_twitter ?>" name="global[setting_reseaux_twitter]" id="setting_reseaux_twitter">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="setting_reseaux_instagram" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_reseaux_instagram')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <input class="form-control" type="text" value="<?= old('setting_reseaux_instagram') ? old('setting_reseaux_instagram') : service('Settings')->setting_reseaux_instagram ?>" name="global[setting_reseaux_instagram]" id="setting_reseaux_instagram">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="setting_reseaux_likedin" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_reseaux_likedin')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <input class="form-control" type="text" value="<?= old('setting_reseaux_likedin') ? old('setting_reseaux_likedin') : service('Settings')->setting_reseaux_likedin ?>" name="global[setting_reseaux_likedin]" id="setting_reseaux_likedin">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="setting_reseaux_viadeo" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_reseaux_viadeo')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <input class="form-control" type="text" value="<?= old('setting_reseaux_viadeo') ? old('setting_reseaux_viadeo') : service('Settings')->setting_reseaux_viadeo ?>" name="global[setting_reseaux_viadeo]" id="setting_reseaux_viadeo">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="card-footer d-flex justify-content-between">
                <button type="submit" class="btn btn-success"><?= lang('Core.valider votre fiche'); ?></button>
            </div>
        </form>
    </div>
</div>
<input type="hidden" name="action" value="editReseauxSociaux" />