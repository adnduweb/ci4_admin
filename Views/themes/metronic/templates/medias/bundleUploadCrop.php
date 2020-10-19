	<div class="dropzone dropzone-default kt_dropzone kt_dropzone<?= $field; ?>" data-input="<?= $input; ?>" data-acceptedFiles=" <?= $acceptedFiles; ?>" data-maxFilesize="<?= $maxFilesize; ?>" data-maxFiles="<?= $maxFiles; ?>" data-uploadMultiple="<?= $uploadMultiple; ?>" data-crop="<?= $crop; ?>" data-crop_width="<?= $crop_width; ?>" data-crop_height="<?= $crop_height; ?>" data-field="<?= $field; ?>" data-only="<?= $only; ?>" id="kt-dropzone<?= $field; ?>">
		<div class="dropzone-msg dz-message needsclick">
			<h3 class="dropzone-msg-title"><?= lang('Core.Drop files here or click to upload'); ?>.</h3>
			<span class="dropzone-msg-desc"><?= lang('Core.This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.'); ?></span>
		</div>
	</div>
	<a href="javascript:;" data-gestionnaire="true" data-uploadMultiple="<?= $uploadMultiple; ?>" data-input="<?= $input; ?>" data-type="<?= $type; ?>" data-id-mediaSelect="" data-item="" data-crop_width="<?= $crop_width; ?>" data-crop_height="<?= $crop_height; ?>" data-only="<?= $only; ?>" data-field="<?= $field; ?>" class="managerModal managerModal-message"><?= lang('Core.ou'); ?> <i class="fa fa-image fa-2x"></i> <?= lang('Core.choisir depuis la galerie'); ?></a>
	<div class="kt-section__content_media">

		<?php if (!empty($builder)) { ?>
			<?php if (!empty($builder->getAttrOptions())) { ?>
				<?php $getOptions = $builder->getAttrOptions(); ?>
				<div class="kt-media kt-media_<?= $getOptions->media->id; ?>" data-id-media="<?= $getOptions->media->id; ?>">
					<a href="javascript:;" class="kt-media">
						<img src="<?= $getOptions->media->filename; ?>" alt="image">
					</a>
					<label class="kt-avatar__remove deletefile" data-container="body" data-toggle="kt-tooltip" title="" data-only="<?= $only; ?>" data-input="<?= $input; ?>" data-placement="top" data-original-title="<?= lang('Core.remove'); ?>" data-id-field="<?= $builder->id_field; ?>" data-id-media="<?= $getOptions->media->id; ?>" data-format="<?= $getOptions->media->format; ?>" data-id-file="<?= $getOptions->media->filename; ?>">
						<i class="fa fa-times"></i>
					</label>
				</div>
			<?php } ?>
		<?php } ?>

	</div>
	<div style="display:none" class="cropImage" id="cropImage<?= trim($field); ?>"></div>
	<?= form_input(['type'  => 'hidden', 'name'  => 'upload_id_images', 'id'    => 'upload_id_images', 'value' => '', 'class' => 'upload_id_images']); ?>
	<?= form_input(['type'  => 'hidden', 'name'  => 'upload_formats', 'id'    => 'upload_formats', 'value' => '', 'class' => 'upload_formats']); ?>
	<?= form_input(['type'  => 'hidden', 'name'  => 'upload_file', 'id'    => 'upload_file', 'value' => '', 'class' => 'upload_file']); ?>