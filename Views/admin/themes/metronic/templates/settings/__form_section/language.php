<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.info_language')); ?>:</h3>
    </div>
</div> -->

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.setting_activer_multilangue')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch switch--icon">
            <label>
                <input type="checkbox" <?= ($form->setting_activer_multilangue == true) ? 'checked="checked"' : ''; ?> name="global[setting_activer_multilangue]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>
<div class="form-group row">
    <label for="setting_defaultLocale" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.language_by_default')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="global[setting_defaultLocale]" class="form-control kt-selectpicker" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="setting_defaultLocale">
            <?php foreach ($languages as $language) {
                $setting_defaultLocale = explode('|', $form->setting_defaultLocale); ?>
                <option <?= $language->iso_code == $setting_defaultLocale[1] ? 'selected' : ''; ?> value="<?= $language->id; ?>|<?= $language->iso_code; ?>"><?= ucfirst($language->name); ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<?php $setting_supportedLocales = array_flip(json_decode($form->setting_supportedLocales)); ?>
<div class="form-group row">
    <label for="setting_defaultLocale" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.language_supported')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="global[setting_supportedLocales][]" class="form-control kt-selectpicker" multiple title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="setting_supportedLocales">
            <?php foreach ($languages as $language) { ?>
                <option <?= isset($setting_supportedLocales[$language->id . '|' . $language->iso_code]) ? 'selected' : ''; ?> value="<?= $language->id; ?>|<?= $language->iso_code; ?>"><?= ucfirst($language->name); ?></option>
            <?php } ?>
        </select>
    </div>
</div>
