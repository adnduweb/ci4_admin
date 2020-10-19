<div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.info_currency'); ?>:</h3>
    </div>
</div>

<div class="form-group form-group-sm row">
    <label class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.activation')); ?></label>
    <div class="col-lg-9 col-xl-6">
        <span class="switch switch--icon">
            <label>
                <input type="checkbox" <?= ($form->active == true) ? 'checked="checked"' : ''; ?> name="active" value="1">
                <span></span>
            </label>
        </span>
    </div>
</div>

<div class="form-group row">
    <label for="name" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.name')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('name') ? old('name') : $form->name; ?>" name="name" id="name">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="iso_code" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.iso_code')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control line3" maxlength="3" required type="text" value="<?= old('iso_code') ? old('iso_code') : $form->iso_code; ?>" name="iso_code" id="iso_code">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="symbol" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.symbol')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('symbol') ? old('symbol') : $form->symbol; ?>" name="symbol" id="symbol">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="conversion_rate" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.conversion_rate')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input required class="form-control currency" type="text" value="<?= old('conversion_rate') ? old('conversion_rate') : $form->conversion_rate; ?>" name="conversion_rate" id="conversion_rate">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>


<?php if (!empty($form->id)) { ?> <?= form_hidden('id', $form->id); ?> <?php } ?>
