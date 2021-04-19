<?php $field = isset($builder->id_field) ? $builder->id_field : "__field__"; ?>
<?php $optionsTextarea = isset($builder->id_field) ? json_decode($builder->options) : ""; ?>
<?php $settingsTextarea = isset($builder->id_field) ? json_decode($builder->settings) : ""; ?>
<div class="kt-portlet kt-portlet--height-fluid <?= ($field == '__field__') ? '' : ' kt-portlet--collapse'; ?>" id="kt_portlet_tools<?= $field; ?>">
    <div class="kt-portlet__head">
        <div class="kt-portlet__head-label">
            <div class="handle-croix"> <i class="icon-xl la la-reorder"></i></div>
            <h3 class="kt-portlet__head-title">
                <?= lang('Core.paragraphe'); ?> <?= isset($builder->handle) ? ' : ' . $builder->handle : ""; ?>
            </h3>
        </div>
        <div class="kt-portlet__head-toolbar">
            <div class="kt-portlet__head-group">
            <a href="javascript:;" data-ktportlet-tool="toggle" data-field="<?= $field; ?>" class="btn btn-sm btn-icon btn-light-primary btn-icon-md mr-2"><i class="la la-angle-down"></i></a>
                <a href="javascript:;" data-ktportlet-tool="remove" data-id_builder="<?= isset($builder->id) ? $builder->id : ""; ?>" data-field="<?= $field; ?>" class="btn btn-sm btn-icon btn-light-warning removePortlet btn-icon-md"><i class="la la-close"></i></a>
            </div>
        </div>
    </div>
    <div class="kt-portlet__body" <?= ($field == '__field__') ? '' : 'style="display: none;overflow: hidden;padding-top: 0px;padding-bottom: 0px;"'; ?>>
        <div class="kt-portlet__content">
            <div class="row li_row form_output" data-type="text" data-field="<?= $field; ?>">

                <div class="col-md-12">
                    <div class="form-group">
                        <?= form_textarea_spread([$field, 'content'], isset($builder->id_field) ? $builder->_prepareLang() : NULL, 'class="form-control lang textarea_click"', false, 'ckeditor', 'builder'); ?>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="builder[<?= $field; ?>][balise_class]" class="form-control form_input_label" value="<?= isset($builder->balise_class) ? $builder->balise_class : ""; ?>" data-field="<?= $field; ?>" placeholder="Votre class" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="builder[<?= $field; ?>][balise_id]" data-field="<?= $field; ?>" class="form-control form_input_placeholder" value="<?= isset($builder->balise_id) ? $builder->balise_id : ""; ?>" placeholder="Votre id" />
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="form-group">
                        <input type="text" name="builder[<?= $field; ?>][handle]" data-field="<?= $field; ?>" class="form-control form_input_placeholder" value="<?= isset($builder->handle) ? $builder->handle : ""; ?>" placeholder="Handle" />
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= ucfirst(lang('Core.row_start')); ?></label>
                        <div class="switch switch--icon" style="display:block">
                            <label>
                                <input type="checkbox" <?= (isset($settingsTextarea->row_start) && $settingsTextarea->row_start == true) ? 'checked="checked"' : ''; ?> name="builder[<?= $field; ?>][settings][row_start]" value="1">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="col-md-12">
                    <div class="form-group">
                        <label><?= ucfirst(lang('Core.row_end')); ?></label>
                        <div class="switch switch--icon" style="display:block">
                            <label>
                                <input type="checkbox" <?= (isset($settingsTextarea->row_end) && $settingsTextarea->row_end == true) ? 'checked="checked"' : ''; ?> name="builder[<?= $field; ?>][settings][row_end]" value="1">
                                <span></span>
                            </label>
                        </div>
                    </div>
                </div>
                <?php if ($field != "__field__") { ?>
                    <?= form_hidden('builder[' . $field . '][id]', $builder->id); ?>
                <?php } ?>
                <?= form_hidden('builder[' . $field . '][type]', 'textareafield'); ?>
                <?= form_hidden('builder[' . $field . '][id_field]', $field); ?>
                <?= form_hidden('builder[' . $field . '][id_item]', $form->id_item); ?>
                <?= form_hidden('builder[' . $field . '][id_module]', $form->id_module); ?>
            </div>
        </div>
    </div>
</div>

<?php if ($field == "__field__") { ?>
    __script__
<?php } ?>
