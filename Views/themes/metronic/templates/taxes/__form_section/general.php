<div class="row">
    <label class="col-xl-3"></label>
    <div class="col-lg-9 col-xl-6">
        <h3 class="kt-section__title kt-section__title-sm"><?= lang('Core.info_taxe'); ?>:</h3>
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

<div class="form-group row kt-shape-bg-color-1">
    <label for="name" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.name')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <?= form_input_spread('name', $form->_prepareLang(), 'id="name" class="form-control lang"', 'text', true); ?>
        <span class="form-text text-muted">Nom de la taxe à afficher dans le panier et sur la facture (ex. : "TVA"). Caractères interdits: <>;=#{}</span>
    </div>
</div>
<div class="form-group row">
    <label for="rate" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.rate')); ?>* : </label>
    <div class="col-lg-9 col-xl-6">
        <input class="form-control" required type="text" value="<?= old('rate') ? old('rate') : $form->rate; ?>" name="rate" id="rate">
        <span class="form-text text-muted">Format : XX.XX ou XX.XXX (ex. : 19.60 ou 13.925)</span>
        <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
    </div>
</div>

<?php if (!empty($form->id)) { ?> <?= form_hidden('id', $form->id); ?> <?php } ?>
