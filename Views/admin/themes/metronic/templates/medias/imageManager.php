<?php if (!empty($images)) { ?>
    <?php foreach ($images as $image) { ?>
        <?php $file = new \CodeIgniter\Files\File($image->nameAbsoluteFile('thumbnail')); ?>
        <?php list($width, $height, $type, $attr) = getimagesize($image->nameAbsoluteFile('original')); ?>
        <div data-uploadmultiple="true" data-type="<?= $image->getType(); ?>" data-file-thumbnail="<?= site_url($image->namePathFile('thumbnail')); ?>" id="select-image_<?= $image->getIdMedia(); ?>" class="kt-media <?= $image->getType(); ?> select-image <?= (isset($image->select)) ? ' select-active ' : ''; ?> select-image_<?= $image->getIdMedia(); ?>" data-id-media="<?= $image->getIdMedia(); ?>">
            <div class="kt-avatar kt-avatar--outline " id="kt_user_avatar_<?= $image->getIdMedia(); ?>">
                <div class="kt-avatar__holder" style="background-image: url(<?= site_url($image->namePathFile('thumbnail')); ?>)">
                    <?php if (!preg_match('/^image/',  $image->mine)) { ?>
                        <div class="nameFile"><?= $image->nameFile(); ?></div>
                    <?php } ?>
                </div>
            </div>
        </div>
    <?php } ?>
<?php } ?>