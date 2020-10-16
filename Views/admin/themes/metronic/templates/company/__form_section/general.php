<div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.info_company'); ?>:</h3>
    </div>
</div>

<?php if (!empty($form->company_id)) { ?>
    <div class="form-group row">
        <label for="name" class="col-xl-3 col-lg-3 col-form-label">
            <span data-skin="dark" data-toggle="kt-tooltip" title="" data-html="true" data-content="" data-original-title="<b>Info</b><br><?= lang('Core.code_company_form_tooltip_info'); ?>">
                <i class="flaticon2-help"></i><?= ucfirst(lang('Core.code_company')); ?>* :
            </span>
        </label>
        <div class="col-lg-9 col-xl-6">
            <input disabled class="form-control" required type="text" value="<?= old('code_company') ? old('code_company') : $form->uuid_company; ?>" name="code_company" id="code_company">
            <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        </div>
    </div>
<?php } ?>
<div class="form-group row">
    <label for="description" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.raison_social')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('raison_social') ? old('raison_social') : $form->raison_social; ?>" name="raison_social" id="description">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="login_destination" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.email')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="email" value="<?= old('email') ? old('email') : $form->email; ?>" name="email" id="email">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="login_destination" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.adresse')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('adresse') ? old('adresse') : $form->adresse; ?>" name="adresse" id="adresse">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="login_destination" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.code_postal')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('code_postal') ? old('code_postal') : $form->code_postal; ?>" name="code_postal" id="code_postal">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="login_destination" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.ville')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('ville') ? old('ville') : $form->ville; ?>" name="ville" id="ville">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="id_group" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.country_id')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="country_id" class="form-control kt-selectpicker" id="country_id" data-live-search="true" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>">
            <?php foreach ($countries as $country) { ?>
                <option <?= old('country_id') ? old('country_id') : $form->country_id; ?> <?= ($country->id == $form->country_id) ? 'selected'  : ''; ?> value="<?= $country->id; ?>"><?= ucfirst($country->name); ?></option>
            <?php } ?>

        </select>
    </div>
</div>
<div class="form-group row">
    <label for="telephone_fixe" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.telephone_fixe')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control phone_fixe" type="tel" value="<?= old('telephone_fixe') ? old('telephone_fixe') : $form->telephone_fixe; ?>" name="telephone_fixe" id="phone_fixe">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        <div class="invalid-feedback-phone_fixe" class="hide"></div>
    </div>
</div>
<div class="form-group row">
    <label for="telephone_mobile" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.telephone_mobile')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control phone_mobile" type="tel" value="<?= old('telephone_mobile') ? old('telephone_mobile') : $form->telephone_mobile; ?>" name="telephone_mobile" id="phone_mobile">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        <div class="invalid-feedback-phone_mobile" class="hide"></div>
    </div>
</div>
<div class="form-group row">
    <label for="id_group" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.company_type')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select required name="company_type_id" class="form-control kt-selectpicker" id="company_type_id" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>">
            <?php foreach ($form->companyType as $companyType) { ?>
                <option <?= ($companyType->id == $form->id) ? 'selected'  : ''; ?> value="<?= $companyType->id; ?>"><?= ucfirst($companyType->nom_court); ?></option>
            <?php } ?>

        </select>
    </div>
</div>

<div class="form-group row kt-shape-bg-color-1">
    <label for="bio" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.bio')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <?= form_textarea_spread('bio', $form->_prepareLang(), 'class="form-control lang"', false); ?>
    </div>
</div>



<?php if (!empty($form->uuid_company)) { ?> <?= form_hidden('uuid_company', $form->uuid_company); ?> <?php } ?>