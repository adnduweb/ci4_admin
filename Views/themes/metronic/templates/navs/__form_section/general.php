<!-- <div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.info_tabs'); ?>:</h3>
    </div>
</div> -->

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
    <label for="id_parent" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.menu_parent')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <select name="id_parent" class="form-control kt-selectpicker" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="id_parent">
            <?php foreach ($menus as $menu) { ?>
                <option <?= $menu->id == $form->id_parent ? 'selected' : ''; ?> value="<?= $menu->id; ?>"><?= ucfirst($menu->name); ?></option>
            <?php } ?>
        </select>
    </div>
</div>

<div class="form-group row lang kt-shape-bg-color-1">
    <label for="name" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.name')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <?= form_input_spread('name', $form->_prepareLang(), 'id="name" class="form-control lang"', 'text', true); ?>
    </div>
</div>

<div class="form-group row">
    <label for="class_name" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.class_name')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required class_name="text" value="<?= old('class_name') ? old('class_name') : $form->class_name; ?>" name="class_name" id="class_name">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        <span class="form-text text-muted"><?= lang('Core.le nom de la classe'); ?></span>
    </div>
</div>

<div class="form-group row">
    <label for="slug" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.slug')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('slug') ? old('slug') : $form->slug; ?>" name="slug" id="slug">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        <span class="form-text text-muted"><?= lang('Core.url par default'); ?></span>
    </div>
</div>

<div class="form-group row">
    <label for="namespace" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.namespace')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" type="text" value="<?= old('namespace') ? old('namespace') : $form->namespace; ?>" name="namespace" id="namespace">
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        <span class="form-text text-muted"><?= lang('Core.namespace'); ?></span>
    </div>
</div>

<div class="form-group row">
    <label for="controller" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.icon')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <textarea class="form-control" rows='20' name="icon" id="icon"><?= old('icon') ? old('icon') : $form->icon; ?></textarea>
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
        <span class="form-text text-muted"><?= lang('Core.namespace'); ?></span>
    </div>
</div>

<?php if (!empty($form->id)) { ?> <?= form_hidden('id', $form->id); ?> <?php } ?>
