<div class="modal modal-stick-to-bottom fade manager" id="kt_modal_manager" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('Core.gestionnaire d\'image'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <?= form_open('', ['id' => 'kt_apps_manager_media', 'class' => 'kt-form', 'novalidate' => false]); ?>
            <div class="modal-body">

                <?php if (!empty($images)) { ?>
                    <?php foreach ($images as $image) { ?>
                        <?php $file = new \CodeIgniter\Files\File($image->nameAbsoluteFile('thumbnail')); ?>
                        <?php list($width, $height, $type, $attr) = getimagesize($image->nameAbsoluteFile('original')); ?>
                        <div data-uploadmultiple="<?= $uploadmultiple; ?>" data-file-thumbnail="<?= site_url($image->namePathFile('thumbnail')); ?>" id="select-image_<?= $image->getIdMedia(); ?>" class="kt-media select-image <?= (isset($image->select)) ? ' select-active ' : ''; ?> select-image_<?= $image->getIdMedia(); ?>" data-id-media="<?= $image->getIdMedia(); ?>" data-extension="<?= $image->getExtension(); ?>">
                            <div class="kt-avatar kt-avatar--outline " id="kt_user_avatar_<?= $image->getIdMedia(); ?>">
                                <div class="kt-avatar__holder" style="background-image: url(<?= site_url($image->namePathFile('thumbnail')); ?>)"></div>
                                <button data-field="<?= $field; ?>" data-only="<?= $only; ?>" data-input="<?= $input; ?>" data-crop="true" data-crop_width="<?= $crop_width; ?>" data-crop_height="<?= $crop_height; ?>" data-uuid="<?= $image->getUuid(); ?>" data-id-media="<?= $image->getIdMedia(); ?>" type="submit" class="btn btn-light btn-icon btn-square btn-sm reCropImage"><i class="la la-crop"></i></button>
                            </div>
                            <div class="information">
                                <small> Nom du fichier : <?= $file->getBasename(); ?> </small><br />
                                <small> Taille du fichier : <?= number_format($file->getSize('kb'), 2, ',', ' '); ?>kB </small><br />
                                <small> Type du fichier : <?= $file->getMimeType(); ?> </small><br />
                                <small> Dimension du fichier : <?= $width . 'x' . $height; ?> </small><br />
                                <?php if (preg_match('/^image/',  $image->mine) && $image->extension  != 'svg') { ?>
                                    <select required name="format" class="form-control kt-selectpicker format" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="format">
                                        <option selected="selected" value="thumbnail"><?= $thumbnail_size; ?></option>
                                        <option value="small"><?= $small_size; ?></option>
                                        <option value="medium"><?= $medium_size; ?></option>
                                        <option value="large"> <?= $large_size; ?></option>
                                        <option value="original"> <?= $width; ?>x<?= $height; ?></option>
                                        <?php if (!empty($image->custom)) { ?>
                                            <?php foreach ($image->custom as $k => $v) { ?>
                                                <option value="/custom/<?= $v; ?>"> <?= $k; ?></option>
                                            <?php } ?>
                                        <?php } ?>
                                    </select>
                                <?php } ?>
                            </div>
                        </div>
                    <?php } ?>
                    <?= form_input(['type'  => 'hidden', 'name'  => 'images-select-manager', 'id'    => 'images-select-manager', 'value' => '', 'class' => 'images-select-manager']); ?>
                    <?= form_input(['type'  => 'hidden', 'name'  => 'formats-select-manager', 'id'    => 'formats-select-manager', 'value' => '', 'class' => 'formats-select-manager']); ?>
                    <?= form_input(['type'  => 'hidden', 'name'  => 'files-select-manager', 'id'    => 'files-select-manager', 'value' => '', 'class' => 'files-select-manager']); ?>
                    <?= form_input(['type'  => 'hidden', 'name'  => 'extensions-select-manager', 'id'    => 'extensions-select-manager', 'value' => '', 'class' => 'extensions-select-manager']); ?>
                <?php } ?>

            </div>

            <div class="modal-footer">
                <button type="submit" class="btn btn-secondary"><?= lang('Core.insert'); ?></button>
            </div>
            <?= form_close(); ?>
        </div>
    </div>
</div>