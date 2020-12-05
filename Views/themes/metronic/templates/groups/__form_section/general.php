<div class="form-group row">
    <label for="name" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.name')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('name') ? old('name') : $form->name; ?>" name="name" id="name">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
<div class="form-group row">
    <label for="description" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.description')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('description') ? old('description') : $form->description; ?>" name="description" id="description">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>
    <div class="form-group row">
    <label for="login_destination" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.login_destination')); ?> : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('login_destination') ? old('login_destination') : $form->login_destination; ?>" name="login_destination" id="login_destination">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>



<?php if (! empty($form->id)) { ?> <?= form_hidden('id', $form->id); ?> <?php } ?>
