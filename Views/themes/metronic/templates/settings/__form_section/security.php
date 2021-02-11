<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= ucfirst(lang('Core.info_security')); ?>:</h3>
    </div>
</div> -->
 

<div class="form-group row">
    <label for="setting_key_api" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.key_api')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-secondary generer_key_api" type="button"><?= lang('Core.generer_key_api'); ?></button>
            </div>
        <input class="form-control datakey"  required type="text" value="<?= old('setting_key_api') ? old('setting_key_api') : $form->setting_key_api; ?>" name="global[setting_key_api]" id="setting_key_api">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
    </div>
</div>