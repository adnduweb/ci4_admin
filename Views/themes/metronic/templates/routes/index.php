<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<?= $this->extend('Adnduweb\Ci4Admin\themes\metronic\__layouts\layout_1') ?>
<?= $this->section('main') ?>
<!-- end:: Header -->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <?= form_open('', ['id' => 'kt_apps_routes_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
    <input type="hidden" name="action" value="edit" />

    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\__partials\kt_list_toolbar') ?>
    
    <!-- begin:: Content -->
    <div id="ContentRoutes" class="d-flex flex-column-fluid">
        <!--Begin::App-->
        <div class="container-fluid">
            <div class="flex-row ">
                <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                    <div class="alert-icon">
                        <span class="svg-icon svg-icon-primary svg-icon-xl">
                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Tools/Compass.svg-->
                            <?= Theme::getSVG('media/svg/icons/Tools/Compass.svg', 'svg-icon svg-icon-sm', true); ?> 
                            <!--end::Svg Icon-->
                        </span>
                    </div>
                    <div class="alert-text">
                        <?= lang('Core.La modification du fichier <code>Routes.php</code> de l\'application n\'est pas recommendé directement ici'); ?>.
                        <br>
                        <?= lang('Core.Si vous décidez de foncer et de tout de même modifier le code directement, utilisez un gestionnaire de fichiers pour en créer une copie avec un autre nom et gardez-le près du code original. Ainsi, vous pourrez réactiver une version fonctionnelle si quelque chose tourne mal.'); ?>
                    </div>
                </div>
            </div>
 

            <div class="flex-row ">
                <div class="card card-custom py-5 px-5">

                    <?php $ressource = fopen(APPPATH . 'Config/Routes.php', 'r');  ?>

                    <div class="form-group row">
                        <div class="col-lg-9 col-xl-12">
                            <textarea class="form-control" rows='20' name="code" id="code"><?= fread($ressource, filesize(APPPATH . 'Config/Routes.php')); ?></textarea>
                            <div class="invalid-feedback"><?= lang('Core.this_field_is_requis'); ?> </div>
                            <span class="form-text text-muted"><?= lang('Core.editer le fichier route de l\'application'); ?></span>
                        </div>
                    </div>


                </div>
            </div>
        </div>

        <!--begin::Modal-->
        <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\__partials\kt_datatable_records_fetch_modal') ?>
        <!--end::Modal-->
    </div>

    <!-- end:: Content -->

<?= form_close(); ?>
</div>
<?= $this->endSection() ?>


<?= $this->section('AfterExtraJs') ?>
<script>
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
        lineNumbers: true,
        extraKeys: {
            "Ctrl-Space": "autocomplete"
        },
        //keyMap: "sublime",
        autoCloseBrackets: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        showCursorWhenSelecting: true,
        theme: "monokai",
        indentUnit: 4,
        indentWithTabs: true,
        onBlur: function() {
            editor.save();
        }
    });
    $("#code").val(editor.getValue());
</script>
<?= $this->endSection() ?>