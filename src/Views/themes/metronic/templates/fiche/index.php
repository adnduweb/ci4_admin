<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<?= $this->extend('Adnduweb\Ci4Admin\themes\metronic\__layouts\layout_1') ?>
<?= $this->section('main') ?>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

<?php if($aside_active == 'compte-personnel'){ ?>
    <?= form_open('', ['id' => 'kt_apps_fiche'.$aside_active.'_form', 'class' => '', 'novalidate' => false]); ?>
<?php }else{ ?>
    <?= form_open('', ['id' => 'kt_apps_fiche'.$aside_active.'_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
<?php } ?>
    
    <input type="hidden" name="controller" value="AdminFicheContactController" />
    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\fiche\__partials\kt_form_toolbar') ?>



    <div id="fiche-contact" class="d-flex flex-column-fluid">
        <!--Begin::App-->
        <div class="container-fluid">
            <div class="d-flex flex-row">

                <!--Begin:: App Aside-->
                <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\fiche\__partials\kt_aside') ?>
                <!--End:: App Aside-->

                <!--Begin:: App Content-->
                <?php if ($aside_active == 'compte-entreprise') { ?>
                    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\fiche\__partials\kt-compte-entreprise') ?>
                <?php } ?>
                <?php if ($aside_active == 'compte-personnel') { ?>
                    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\fiche\__partials\kt-compte-personnel.php') ?>
                <?php } ?>
                <?php if ($aside_active == 'reseaux-sociaux') { ?>
                    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\fiche\__partials\kt-reseaux-sociaux.php') ?>
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