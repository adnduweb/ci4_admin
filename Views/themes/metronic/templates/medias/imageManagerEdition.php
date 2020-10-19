<div class="modal modal-stick-to-bottom fade manager" id="kt_modal_manager_edition" data-backdrop="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?= lang('Core.Edition du fichier'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <i aria-hidden="true" class="ki ki-close"></i>
                </button>
            </div>
            <?= form_open('', ['id' => 'kt_apps_manager_media', 'class' => 'kt-form', 'novalidate' => false]); ?>
            <div class="modal-body">
                <div class="flexbox-container">
                    <div class="flexbox-container-1">
                        <?php if (!empty($image)) { ?>
                            <?php $file = new \CodeIgniter\Files\File($image->nameAbsoluteFile('original')); ?>
                            <?php list($width, $height, $type, $attr) = getimagesize($image->nameAbsoluteFile('original')); ?>
                            <div data-type="<?= $image->getType(); ?>" data-file-thumbnail="<?= site_url($image->namePathFile('thumbnail')); ?>" id="attachment-media-view_<?= $image->getIdMedia(); ?>" class="attachment-media-view <?= $image->getType(); ?> landscape attachment-media-view<?= $image->getIdMedia(); ?>" data-id-media="<?= $image->getIdMedia(); ?>">
                                <div class="thumbnail thumbnail-image" id="thumbnail-image<?= $image->getIdMedia(); ?>">
                                    <img class="details-image" src="<?= site_url($image->namePathFile('original')); ?>" width="<?= $width; ?>" height="<?= $height; ?>" />

                                </div>
                            </div>
                        <?php } ?>
                        <div id="cropImage"></div>
                    </div>
                    <div class="attachment-info flexbox-container-2">
                        <div class="information">
                            <div> <strong><?= lang('Core.Nom du fichier'); ?></strong> : <?= $file->getBasename(); ?> </div>
                            <div> <strong><?= lang('Core.Taille du fichier'); ?>r</strong> : <?= number_format($file->getSizeByUnit('mb'), 2, ',', ' '); ?>MB </div>
                            <div> <strong><?= lang('Core.Type du fichier'); ?></strong> : <?= $file->getMimeType(); ?> </div>
                            <div> <strong><?= lang('Core.Date du fichier'); ?></strong> : <?= $image->setCreatedAt($image->created_at); ?> </div>
                            <?php if ($image->getType() == 'image') { ?>
                                <div> <strong><?= lang('Core.Dimension du fichier'); ?></strong> : <?= $width . 'x' . $height; ?> </div>
                            <?php } ?>
                            <hr>
                            <?php if (service('Settings')->setting_activer_multilangue == true) { ?>
                                <?php $setting_supportedLocales = unserialize(service('Settings')->setting_supportedLocales); ?>
                                <div class="lang_tabs" data-dft-lang="<?= service('Settings')->setting_lang_iso; ?>" style="display: block;">

                                    <?php foreach ($setting_supportedLocales as $k => $v) {
                                        $langExplode = explode('|', $v); ?>
                                        <a href="javascript:;" data-lang="<?= $langExplode[1]; ?>" data-id_lang="<?= $langExplode[0]; ?>" class="btn <?= (service('Settings')->setting_id_lang == $langExplode[0]) ? 'active'  : ''; ?> lang_tab btn-outline-brand"><?= ucfirst($langExplode[1]); ?></a>
                                    <?php   } ?>
                                </div>
                                <hr>
                            <?php   } ?>
                            <?= form_open('', ['id' => 'kt_apps_imageManagerEdition', 'class' => 'kt-form', 'novalidate' => false]); ?>
                            <div class="kt-portlet__body">
                                <div class="form-group">
                                    <label><?= lang('Core.titre'); ?></label>
                                    <?= form_input_spread('titre', $image->_prepareLang(), 'id="titre" class="form-control lang"', 'text', true); ?>
                                </div>
                                <div class="form-group">
                                    <label><?= lang('Core.legende'); ?></label>
                                    <?= form_input_spread('legende', $image->_prepareLang(), 'id="titre" class="form-control lang"', 'text', true); ?>
                                </div>
                                <div class="form-group">
                                    <label><?= lang('Core.description'); ?> (Alt) </label>
                                    <?= form_input_spread('description', $image->_prepareLang(), 'id="titre" class="form-control lang"', 'text', true); ?>
                                </div>
                                <?= form_input(['type'  => 'hidden', 'name'  => 'id_media', 'id'    => 'id_media', 'value' => $image->getIdMedia(), 'class' => 'id_media']); ?>
                            </div>
                            <div class="kt-portlet__foot">
                                <div class="kt-form__actions">
                                    <button type="submit" class="btn btn-primary"><?= lang('Core.enregistrer'); ?></button>
                                    <button data-imagemanager="reload" data-uuid="<?= $image->getUuid(); ?>" data-id-media="<?= $image->getIdMedia(); ?>" type="button" class="btn btn-danger deleteFile"><?= lang('Core.supprimer file'); ?></button>
                                    <?php if (preg_match('/^image/',  $image->mine) && $image->extension  != 'svg') { ?>
                                        <button data-crop="true" data-uuid="<?= $image->getUuid(); ?>" data-id-media="<?= $image->getIdMedia(); ?>" type="button" class="btn btn-dark croppedFile"><?= lang('Core.cropped file'); ?></button>
                                    <?php } ?>
                                </div>
                            </div>
                            <?= form_close(); ?>
                            <hr>
                            <div id="imageCustom">
                                <?= $this->include('/admin/themes/metronic/controllers/medias/imageCustom') ?>
                            </div>
                        </div>
                    </div> <?= form_close(); ?>
                </div>
            </div>
        </div>
    </div>
</div>