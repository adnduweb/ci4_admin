<div class="form-group row">
    <label for="setting_naneApp" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.name_app')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_naneApp') ? old('setting_naneApp') : $form->setting_naneApp; ?>" name="global[setting_naneApp]" id="setting_naneApp">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_naneShortApp" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.name_short_app')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_naneShortApp') ? old('setting_naneShortApp') : $form->setting_naneShortApp; ?>" name="global[setting_naneShortApp]" id="setting_naneShortApp">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="setting_descApp" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.desc_app')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('setting_descApp') ? old('setting_descApp') : $form->setting_descApp; ?>" name="global[setting_descApp]" id="setting_descApp">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="id_group" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.themes_admin')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="user[setting_theme_admin]" class="form-control kt-selectpicker" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="setting_theme_admin">
            <?php foreach ($getThemesAdmin as $theme) { ?>
                <?php foreach ($getThemesAdmin as $theme) { ?>
                    <option <?= $theme == $form->setting_theme_admin ? 'selected' : ''; ?> value="<?= $theme; ?>"><?= ucfirst($theme); ?></option>
                <?php } ?>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.activer_manifest')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch switch--icon">
            <label>
                <input type="checkbox" <?= ($form->activer_manifest == true) ? 'checked="checked"' : ''; ?> name="global[activer_manifest]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.activer_services_workers')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch switch--icon">
            <label>
                <input type="checkbox" <?= ($form->activer_services_workers == true) ? 'checked="checked"' : ''; ?> name="global[activer_services_workers]" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>

<!-- <div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?=  ucfirst(lang('Core.setting_env')); ?></label>
    <div class="col-lg-9 col-xl-6">
    <select required name="global[setting_env]" class="form-control file kt-selectpicker" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>"  id="global[setting_env]">
                <option <?= $form->setting_env  == "development" ? 'selected' : ''; ?> value="development">Dévelopement</option>
                <option <?= $form->setting_env  == "production" ? 'selected' : ''; ?> value="production">Production</option>
        </select>
    </div>
</div> -->


<?php if (!empty($form->id)) { ?> <?= form_hidden('_id', $form->_id); ?> <?php } ?>