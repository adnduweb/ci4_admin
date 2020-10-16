<?= $this->extend('/admin/themes/metronic/__layouts/layout_1') ?>
<?= $this->section('main') ?>

<!-- end:: Header -->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

    <?= form_open('', ['id' => 'kt_apps_routes_form', 'class' => 'kt-form', 'novalidate' => false]); ?>

    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="controller" value="AdminRouteController" />

    <?= $this->include('/admin/themes/metronic/__partials/kt_form_toolbar') ?>
    
    <!-- begin:: Content -->
    <div id="ContentRoutes" class="d-flex flex-column-fluid">
        <!--Begin::App-->
        <div class="container-fluid">
            <div class="flex-row ">
                <div class="alert alert-custom alert-white alert-shadow fade show gutter-b" role="alert">
                    <div class="alert-icon">
                        <span class="svg-icon svg-icon-primary svg-icon-xl">
                            <!--begin::Svg Icon | path:/metronic/theme/html/demo1/dist/assets/media/svg/icons/Tools/Compass.svg-->
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                    <rect x="0" y="0" width="24" height="24"></rect>
                                    <path d="M7.07744993,12.3040451 C7.72444571,13.0716094 8.54044565,13.6920474 9.46808594,14.1079953 L5,23 L4.5,18 L7.07744993,12.3040451 Z M14.5865511,14.2597864 C15.5319561,13.9019016 16.375416,13.3366121 17.0614026,12.6194459 L19.5,18 L19,23 L14.5865511,14.2597864 Z M12,3.55271368e-14 C12.8284271,3.53749572e-14 13.5,0.671572875 13.5,1.5 L13.5,4 L10.5,4 L10.5,1.5 C10.5,0.671572875 11.1715729,3.56793164e-14 12,3.55271368e-14 Z" fill="#000000" opacity="0.3"></path>
                                    <path d="M12,10 C13.1045695,10 14,9.1045695 14,8 C14,6.8954305 13.1045695,6 12,6 C10.8954305,6 10,6.8954305 10,8 C10,9.1045695 10.8954305,10 12,10 Z M12,13 C9.23857625,13 7,10.7614237 7,8 C7,5.23857625 9.23857625,3 12,3 C14.7614237,3 17,5.23857625 17,8 C17,10.7614237 14.7614237,13 12,13 Z" fill="#000000" fill-rule="nonzero"></path>
                                </g>
                            </svg>
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
        <?= $this->include('/admin/themes/metronic/__partials/kt_datatable_records_fetch_modal') ?>
        <!--end::Modal-->
    </div>

    <!-- end:: Content -->

<?= form_close(); ?>
</div>
<?= $this->endSection() ?>


<?= $this->section('extra-js') ?>
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