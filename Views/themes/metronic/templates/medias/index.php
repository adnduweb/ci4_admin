<?= $this->extend('/admin/themes/metronic/__layouts/layout_1') ?>
<?= $this->section('main') ?>
<!-- end:: Header -->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <?= $this->include('/admin/themes/metronic/__partials/kt_list_toolbar') ?>

    <div id="ContentMedia" class="d-flex flex-column-fluid">

        <div class="container-fluid">
            <div class="flex-row ">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label"><?= lang('Core.gestionnaire de médias'); ?>
                                <span class="d-block text-muted pt-2 font-size-sm"><?= lang('Core.row selection and group actions'); ?></span></h3>
                        </div>
                        <?php if ($toolbarExport == true) { ?>
                            <div class="card-toolbar">
                                <?= $this->include('/admin/themes/metronic/__partials/kt_export_data') ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="card-body">
                        <!--begin: Datatable -->
                        <?= form_open('', ['id' => 'kt_apps_manager_media', 'class' => 'kt-form', 'novalidate' => false]); ?>
                        <div class="dropzone dropzone-default kt_dropzone" data-acceptedFiles="null" data-maxFiles="10" data-uploadMultiple="true" data-crop="" data-field="" id="kt-dropzone">
                            <div class="dropzone-msg dz-message needsclick">
                                <h3 class="dropzone-msg-title"><?= lang('Core.Drop files here or click to upload'); ?>.</h3>
                                <span class="dropzone-msg-desc"><?= lang('Core.This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.'); ?></span>
                            </div>
                        </div>
                        <div id="imageManager">
                            <?= $this->include('/admin/themes/metronic/controllers/medias/imageManager') ?>
                        </div>
                        <?= form_close(); ?>
                    </div>
                    <!--end: Datatable -->
                </div>
            </div>
        </div>
        <!--end::Portlet-->
    </div>
    <!-- end:: Content -->
</div>
<!-- begin::Outils de gestion de média -->
<div id="imageManager_edition" class="imageManager_edition"></div>
<!-- end::Outils de gestion de média -->
<?= $this->endSection() ?>