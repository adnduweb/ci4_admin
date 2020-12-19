<?= $this->extend('Adnduweb\Ci4Admin\themes\metronic\__layouts\layout_1') ?>
<?= $this->section('main') ?>
<!-- end:: Header -->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\__partials\kt_list_toolbar') ?>



    <div id="ContentUsers" class="d-flex flex-column-fluid">

        <div class="container-fluid">
            <div class="flex-row ">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <h3 class="card-label"><?= lang('Core.choisir_langue'); ?>
                                <span class="d-block text-muted pt-2 font-size-sm"><?= lang('Core.row_selection_and_group_actions'); ?></span></h3>
                        </div>
                        <?php if ($toolbarExport == true) { ?>
                            <div class="card-toolbar">
                                <?= $this->include('/admin/themes/metronic/__partials/kt_export_data') ?>
                            </div>
                        <?php } ?>
                    </div>
                    <div class="card-body ">

                        <?= form_open('', ['id' => 'search_translate', 'class' => 'kt-form', 'novalidate' => false]); ?>
                        <div class="kt-portlet__body">
                            <div class="form-group row">
                                <label for="id_group" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.choisir_langue')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <select required name="lang" class="form-control selectFilePicker kt-selectpicker" id="lang">
                                        <?php foreach (Config('App')->supportedLocales as $file) { ?>
                                            <option value="<?= $file; ?>"><?= ucfirst($file); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_group" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.rechercher_dans_core')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <select required name="fileCore" class="form-control selectFilePicker fileCore file kt-selectpicker" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="fileCore">
                                        <?php foreach ($filesCore as $file) { ?>
                                            <option value="<?= $file; ?>"><?= ucfirst(str_replace('.php', '', $file)); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_group" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.rechercher_dans_themes')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <select required name="fileTheme" class="form-control selectFilePicker fileTheme file kt-selectpicker" data-actions-box="true" title="<?= ucfirst(lang('Core.choose_one_of_the_following')); ?>" id="fileTheme">
                                        <?php foreach ($filesThemesFront as $file) { ?>
                                            <option value="<?= $file; ?>"><?= ucfirst(str_replace('.php', '', $file)); ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="id_group" class="col-xl-3 col-lg-3 col-form-label"><?= ucfirst(lang('Core.search')); ?>* : </label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="text" class="form-control" id="searchDirect" placeholder="<?= lang('Core.search_barre_translate'); ?>" name="searchDirect">
                                    <span class="form-text text-muted"><?= lang('Core.search_desc_barre_translate'); ?></span>
                                </diV>
                            </div>
                        </div>
                        <?= form_close(); ?>


                    </div>
                    <!--end: Datatable -->
                    <div id="response" class=" px-5"></div>
                </div>
                
            </div>
        
       
        </div>
    </div>
    <?= $this->endSection() ?>
