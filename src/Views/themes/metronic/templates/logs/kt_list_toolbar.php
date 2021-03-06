<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<!-- begin:: Content Head --> 
<div class="subheader py-2  subheader-solid " id="kt_subheader">
    <div class="container-fluid  d-flex align-items-center justify-content-between flex-wrap flex-sm-nowrap">
        <div class="d-flex align-items-center flex-wrap mr-2">
            <h5 class="text-dark font-weight-bold mt-2 mb-2 mr-5">
                <?= $controller; ?>
            </h5>
            <?php if (isset($countList)) { ?>
                <span class="subheader-separator subheader-separator-ver mt-2 mb-2 mr-5 bg-gray-200"></span>
                <div class="d-flex align-items-center" id="kt_subheader_search">
                    <span class="text-dark-50 font-weight-bold" id="kt_subheader_total">
                        <span class="kt_subheader_total"><?= count($countList); ?></span> <?= lang('Core.total'); ?> </span>
                    <form class="ml-5">
                        <div class="input-group input-group-sm input-group-solid" style="max-width: 175px">
                            <input type="text" class="form-control" placeholder="<?= lang('Core.search'); ?>" id="kt_subheader_search_form">
                            <div class="input-group-append">
                                <span class="input-group-text">
                                    <?= Theme::getSVG('media/svg/icons/General/Search.svg', 'svg-icon svg-icon-sm', true); ?> 
                                    <!--<i class="flaticon2-search-1 icon-sm"></i>-->
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="kt-subheader__group hidden" id="kt_subheader_group_actions">
                    <div class="kt-subheader__desc"><span id="kt_subheader_group_selected_rows"></span> <?= lang('Core.elements_selected'); ?>:</div>
                    <div class="btn-toolbar kt-margin-l-20">

                        <?php if ($toolbarUpdate == true) { ?>
                            <div class="dropdown m-2" id="kt_subheader_group_actions_status_change">
                                <button type="button" class="btn btn-light-dark font-weight-bolder btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <?= lang('Core.status_update'); ?>
                                </button>
                                <div class="dropdown-menu">
                                    <ul class="navi">
                                        <li class="navi-header">
                                            <span class="navi-section-text"><?= lang('Core.change_status_to'); ?>:</span>
                                        </li>
                                        <li class="navi-separator mb-3"></li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="status-change" data-status="1">
                                                <span class="navi-link-text" data-status="1"><span class="kt-badge kt-badge--unified-success kt-badge--inline kt-badge--bold"><?= lang('Core.active'); ?></span></span>
                                            </a>
                                        </li>
                                        <li class="navi-item">
                                            <a href="#" class="navi-link" data-toggle="status-change" data-status="0">
                                                <span class="navi-link-text" data-status="0"><span class="kt-badge kt-badge--unified-danger kt-badge--inline kt-badge--bold"><?= lang('Core.desactive'); ?></span></span>
                                            </a>
                                        </li>
                                        <?php if ($changeCategorie == true) { ?>
                                            <li class="navi-item">
                                                <a href="#" class="navi-link" data-toggle="status-change" data-status="0">
                                                    <span class="navi-link-text" data-status="!1" data-categorie="true">
                                                        <span class="kt-badge kt-badge--unified-dark kt-badge--inline kt-badge--bold"><?= lang('Core.change_categorie'); ?></span>
                                                    </span>
                                                </a>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if (ENVIRONMENT !== 'developement') { ?>
                            <button class="btn btn-light-success font-weight-bolder btn-sm m-2" id="kt_subheader_group_actions_fetch" data-toggle="modal" data-target="#kt_datatable_records_fetch_modal">
                                <?= lang('Core.list_selectionne'); ?>
                            </button>
                        <?php } ?>
                        <button class="btn btn-light-danger font-weight-bolder btn-sm m-2" id="kt_subheader_group_actions_delete_all">
                            <?= lang('Core.delete_all'); ?>
                        </button>
                    </div>
                </div>
            <?php }  ?>
        </div>
        <div class="kt-subheader__toolbar">
            <a href="/<?= env('app.areaAdmin'); ?>/settings-advanced/logs" class="btn btn-primary font-weight-bolder btn-sm <?= count($currentUrlSegment) == '4' ? ' active ' : '' ?>">
                <?= Theme::getSVG('media/svg/icons/General/Thunder-move.svg', 'svg-icon svg-icon-sm', true); ?> 
                <?= lang('Core.Logs système'); ?>
            </a>
            <a href="/<?= env('app.areaAdmin'); ?>/settings-advanced/logs/traffics" class="btn btn-primary font-weight-bolder btn-sm <?= isset($currentUrlSegment['traffics']) ? ' active ' : '' ?>">
                <?= Theme::getSVG('media/svg/icons/Code/Git4.svg', 'svg-icon svg-icon-sm', true); ?> 
                <?= lang('Core.Logs Traffic'); ?>
            </a>
            <a href="/<?= env('app.areaAdmin'); ?>/settings-advanced/logs/connexions" class="btn btn-primary font-weight-bolder btn-sm <?= isset($currentUrlSegment['connexions']) ? ' active ' : '' ?>">
                <?= Theme::getSVG('media/svg/icons/General/Scale.svg', 'svg-icon svg-icon-sm', true); ?> 
                <?= lang('Core.Logs Connexions'); ?>
            </a>
        </div>
    </div>
</div>


<!-- end:: Content Head -->