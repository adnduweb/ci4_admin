<div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.info_users'); ?>:</h3>
    </div>
</div>


<?php if (!empty($form->id)) { ?> <?= form_hidden('active', $form->active); ?> <?php } ?>
<?= form_hidden('company_id', $form->company_id); ?>
<div class="form-group row">
    <label for="fonction" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.fonction')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('fonction') ? old('fonction') : $form->fonction; ?>" name="fonction" id="fonction">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<?php if (isset($form->id)) { ?>
    <div class="form-group row">
        <label for="username" class="col-xl-3 col-lg-3 col-form-label">
            <span data-skin="dark" data-toggle="kt-tooltip" title="" data-html="true" data-content="" data-original-title="<b>Info</b><br><?= lang('Core.username_form_tooltip_info'); ?>">
                <i class="flaticon2-help"></i> <?= ucfirst(lang('Core.username')); ?>* :
            </span>
        </label>
        <div class="col-lg-9 col-xl-6">
            <input class="form-control" disabled required type="text" value="<?= $form->username; ?>" name="username" id="username">
            <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        </div>
    </div>
<?php } ?> 
<div class="form-group row">
    <label for="lastname" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.lastname')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('lastname') ? old('lastname') : $form->lastname; ?>" name="lastname" id="lastname">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="firstname" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.firstname')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('firstname') ? old('firstname') : $form->firstname; ?>" name="firstname" id="firstname">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="email" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.email')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="email" value="<?= old('email') ? old('email') : $form->email; ?>" name="email" id="email">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<div class="form-group row">
    <label for="phone" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.phone')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control phone_international phone_fixe" type="tel" value="<?= old('phone') ? old('phone') : $form->phone; ?>" name="phone" id="phone">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        <div class="invalid-feedback-phone" class="hide"></div>
    </div>
</div>
<div class="form-group row">
    <label for="phone_mobile" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.phone_mobile')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control phone_international phone_mobile" type="tel" value="<?= old('phone_mobile') ? old('phone_mobile') : $form->phone_mobile; ?>" name="phone_mobile" id="phone_mobile">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        <div class="invalid-feedback-phone_mobile" class="hide"></div>
    </div>
</div>

<div class="form-group row">
    <label for="password" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.password')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <div class="input-group">
            <div class="input-group-prepend">
                <button class="btn btn-secondary generer_mot_passe" data-password="<?= generer_mot_de_passe(20); ?>" type="button"><?= lang('Core.generer_mot_de_passe_aleatoire'); ?></button>
            </div>
            <input type="password" class="form-control datapassword" name="password" value="">
            <div class="input-group-append">
                <button data-clipboard="true" data-clipboard-target="#password" data-toggle="kt-tooltip" data-placement="top" data-original-title="<?= lang('Core.copy_element'); ?>" class="btn btn-default dataclipboard" type="button"><i class="la la-copy"></i></button>
            </div>
            <span type="text" id="password" type="text" style="text-indent:99999999999999999px;position: absolute;color: transparent;"></span>
        </div>
    </div>
</div>

<div class="form-group row">
    <label for="pass_confirm" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.password_confirm')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input type="password" class="form-control pass_confirm" name="pass_confirm" value="">
    </div>
</div>



<?= form_hidden('id_group', explode(',', $id_group)); ?>

<?php if (!empty($form->uuid)) { ?> <?= form_hidden('uuid', $form->uuid); ?> <?php } ?>
