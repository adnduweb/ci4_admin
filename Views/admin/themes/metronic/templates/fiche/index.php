<?= $this->extend('/admin/themes/metronic/__layouts/layout_1') ?>
<?= $this->section('main') ?>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <?= form_open('', ['id' => 'kt_apps_user_add_user_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
    <input type="hidden" name="controller" value="AdminFicheContactController" />
    <?= $this->include('/admin/themes/metronic/controllers/fiche/__partials/kt_form_toolbar') ?>



    <div id="fiche-contact" class="d-flex flex-column-fluid">
        <!--Begin::App-->
        <div class="container-fluid">
            <div class="d-flex flex-row">

                <!--Begin:: App Aside-->
                <?= view('/admin/themes/metronic/controllers/fiche/__partials/kt_aside') ?>
                <!--End:: App Aside-->

                <!--Begin:: App Content-->
                <?php if ($aside_active == 'compte-entreprise') { ?>
                    <?= $this->include('/admin/themes/metronic/controllers/fiche/__partials/kt-compte-entreprise') ?>
                <?php } ?>
                <?php if ($aside_active == 'compte-personnel') { ?>
                    <?= $this->include('/admin/themes/metronic/controllers/fiche/__partials/kt-compte-personnel.php') ?>
                <?php } ?>
                <?php if ($aside_active == 'reseaux-sociaux') { ?>
                    <?= $this->include('/admin/themes/metronic/controllers/fiche/__partials/kt-reseaux-sociaux.php') ?>
                <?php } ?>
                <!--End:: App Content-->
            </div>
        </div>
        <!--End::App-->
    </div>
    <!-- end:: Content -->
    <?= form_close(); ?>
</div>

<?= $this->endSection() ?>