<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<?= $this->extend('Adnduweb\Ci4Admin\themes\metronic\__layouts\layout_1') ?>
<?= $this->section('main') ?>

<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">

    <?= form_open('', ['id' => 'kt_apps_user_add_user_form', 'class' => 'kt-form', 'novalidate' => false]); ?>
    <input type="hidden" name="action" value="edit" />
    <input type="hidden" name="controller" value="AdminSettingController" />

    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\__partials\kt_form_toolbar') ?>

    <!-- begin:: Content -->
    <div id="ContentSettings" class="d-flex flex-column-fluid">
        <!--Begin::App-->
        <div class="container-fluid">
            <div class="flex-row ">
                <div class="card card-custom py-5 px-5">
                    <ul class="nav nav-tabs nav-tabs-line mb-5" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#kt_user_edit_tab_1" role="tab">
                                <?= Theme::getSVG('assets/media/svg/icons/Design/Layers.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_general')); ?>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_4" role="tab">
                               <?= Theme::getSVG('assets/media/svg/icons/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                               <?= ucfirst(lang('Core.tab_security')); ?>
                            </a>
                        </li>

                        <?php if(class_exists('\Adnduweb\Ci4Web\Web')){ ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_5" role="tab">
                                <?= Theme::getSVG('assets/media/svg/icons/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_front')); ?>
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_analitycs_rgpd" role="tab">
                                <?= Theme::getSVG('assets/media/svg/icons/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_analitycs_rgpd')); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_6" role="tab">
                                <?= Theme::getSVG('assets/media/svg/icons/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_email')); ?>
                            </a>
                        </li>
                        <?php if (inGroups(1, user()->id)) { ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_7" role="tab">
                                    <?= Theme::getSVG('assets/media/svg/icons/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                    <?= ucfirst(lang('Core.tab_language')); ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_8" role="tab">
                                <?= Theme::getSVG('assets/media/svg/icons/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_image')); ?>
                            </a>
                        </li>
                        <?php if(class_exists('\Adnduweb\Ci4Ecommerce\Shopping')){ ?>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_9" role="tab">
                                <?= Theme::getSVG('assets/media/svg/icons/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                <?= ucfirst(lang('Core.tab_ecommerce')); ?>
                            </a>
                        </li>
                        <?php } ?>
                        <?php if (inGroups(1, user()->id)) { ?>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="tab" href="#kt_user_edit_tab_10" role="tab">
                                    <?= Theme::getSVG('assets/media/svg/icons/Communication/Mail-opened.svg', 'svg-icon svg-icon-sm', true); ?> 
                                    <?= ucfirst(lang('Core.tab_command')); ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                    <div class="tab-content mt-5">
                        <div class="tab-pane active" id="kt_user_edit_tab_1" role="tabpanel">
                            <div class="kt-form kt-form--label-right">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\general') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="kt_user_edit_tab_4" role="tabpanel">
                            <div class="kt-form kt-form--label-right">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\security') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(class_exists('\Adnduweb\Ci4Web\Web')){ ?>
                        <div class="tab-pane" id="kt_user_edit_tab_5" role="tabpanel">
                            <div class="kt-form kt-form--label-right">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\front') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                       
                        <div class="tab-pane" id="kt_analitycs_rgpd" role="tabpanel">
                            <div class="kt-form kt-form--label-right">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\analitycs_rgpd') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="tab-pane" id="kt_user_edit_tab_6" role="tabpanel">
                            <div class="kt-form kt-form--label-right">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\email') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if (inGroups(1, user()->id)) { ?>
                            <div class="tab-pane" id="kt_user_edit_tab_7" role="tabpanel">
                                <div class="kt-form kt-form--label-right">
                                    <div class="kt-form__body">
                                        <div class="kt-section kt-section--first">
                                            <div class="kt-section__body">
                                                <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\language') ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="tab-pane" id="kt_user_edit_tab_8" role="tabpanel">
                            <div class="kt-form kt-form--label-right">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\images') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if(class_exists('\Adnduweb\Ci4Ecommerce\Shopping')){ ?>
                        <div class="tab-pane" id="kt_user_edit_tab_9" role="tabpanel">
                            <div class="kt-form kt-form--label-right">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\ecommerce') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="tab-pane" id="kt_user_edit_tab_10" role="tabpanel">
                            <div class="kt-form kt-form--label-right">
                                <div class="kt-form__body">
                                    <div class="kt-section kt-section--first">
                                        <div class="kt-section__body">
                                            <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\templates\settings\__form_section\command') ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= form_close(); ?>
</div>
<!-- end:: Content -->

<?= $this->endSection() ?>
<?= $this->section('extra-js') ?>

<script type="text/javascript">
    function addRemoteAddr() {
        var length = $('input#setting_maintenance_ip_restrict').attr('value').length;
        if (length > 0)
            $('input#setting_maintenance_ip_restrict').attr('value', $('input#setting_maintenance_ip_restrict').attr('value') + ';<?= service('request')->getIPAddress(); ?>');
        else
            $('input#setting_maintenance_ip_restrict').attr('value', '<?= service('request')->getIPAddress(); ?>');
    }
</script>
<?= $this->endSection() ?>