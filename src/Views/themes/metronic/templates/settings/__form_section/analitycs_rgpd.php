<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<div class="form-group row">
    <label for="setting_tag_manager" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_tag_manager')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_tag_manager') ? old('setting_tag_manager') : $form->setting_tag_manager ?>" name="global[setting_tag_manager]" id="setting_tag_managercode">
    </div>
</div>

<?php foreach ($languages as $language) { ?>
    <div class="form-group row">
        <label for="setting_google_analitycs_<?= $language->iso_code; ?>_code" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_google_analitycs_' . $language->iso_code . '_code')); ?>* : </label>
        <div class="col-lg-9 col-xl-6">
            <?php $setting_google_analitycs_code = 'setting_google_analitycs_' . $language->iso_code . '_code'; ?>
            <input class="form-control" type="text" value="<?= old('setting_google_analitycs_' . $language->iso_code . '_code') ? old('setting_google_analitycs_' . $language->iso_code . '_code') : $form->{$setting_google_analitycs_code} ?>" name="global[setting_google_analitycs_<?= $language->iso_code; ?>_code]" id="setting_front_meta_description">
        </div>
    </div>
    <div class="form-group row">
        <label for="setting_google_analitycs_<?= $language->iso_code; ?>_domain" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_google_analitycs_' . $language->iso_code . '_domain')); ?>* : </label>
        <div class="col-lg-9 col-xl-6">
            <?php $setting_google_analitycs_domain = 'setting_google_analitycs_' . $language->iso_code . '_domain'; ?>
            <input class="form-control" type="text" value="<?= old('setting_google_analitycs_' . $language->iso_code . '_domain') ? old('setting_google_analitycs_' . $language->iso_code . '_domain') :  $form->{$setting_google_analitycs_domain}  ?>" name="global[setting_google_analitycs_<?= $language->iso_code; ?>_domain]" id="setting_front_meta_description">
        </div>
    </div>
<?php } ?>


<div class="form-group row">
    <label for="setting_google_maps" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_google_maps')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_google_maps') ? old('setting_google_maps') : $form->setting_google_maps ?>" name="global[setting_google_maps]" id="setting_google_maps">
    </div>
</div>


<div class="form-group row">
    <label for="setting_google_maps" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_google_maps')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('setting_google_maps') ? old('setting_google_maps') : $form->setting_google_maps ?>" name="global[setting_google_maps]" id="setting_google_maps">
    </div>
</div>

<div class="kt-separator kt-separator--border-dashed kt-separator--portlet-fit kt-separator--space-lg"></div>

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_rgpd_youtube')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_rgpd_youtube == true) ? 'checked="checked"' : ''; ?> name="global[setting_rgpd_youtube]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_rgpd_facebook')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_rgpd_facebook == true) ? 'checked="checked"' : ''; ?> name="global[setting_rgpd_facebook]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_rgpd_twitter')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_rgpd_twitter == true) ? 'checked="checked"' : ''; ?> name="global[setting_rgpd_twitter]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_rgpd_store_cookie_consent')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch">
            <label>
                <input type="checkbox" <?= ($form->setting_rgpd_store_cookie_consent == true) ? 'checked="checked"' : ''; ?> name="global[setting_rgpd_store_cookie_consent]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>
