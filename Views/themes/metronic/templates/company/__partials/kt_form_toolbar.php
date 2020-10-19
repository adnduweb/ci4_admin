<div class="kt-subheader   kt-grid__item" id="kt_subheader">
    <div class="kt-container  kt-container--fluid ">
        <div class="kt-subheader__main">
            <h3 class="kt-subheader__title">
                <?= lang('Core.'.$action.'_group'); ?>
            </h3>
            <span class="kt-subheader__separator kt-subheader__separator--v"></span>
            <div class="kt-subheader__group" id="kt_subheader_search">
                <?php if($action == 'edit'){ ?>
                    <span class="kt-subheader__desc" id="kt_subheader_total">
                    <?= $group->name; ?>  </span>
                <?php } ?>
            </div>
        </div>
        <div class="kt-subheader__toolbar">
            <a href="/<?= env('CI_AREA_ADMIN'); ?>/<?= $_company_id; ?>/settings-advanced/roles" class="btn btn-default btn-bold">
            <?= lang('Core.back'); ?> </a>
            <div class="btn-group">
                <button  type="submit" name="submithandler" value="save_continue" class="btn btn-brand btn-bold">
                    <?= lang('Core.saves_changes'); ?> </button>
                <button type="button" class="btn btn-brand btn-bold dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                </button>
                <div class="dropdown-menu dropdown-menu-right">
                    <ul class="kt-nav">
                        <li class="kt-nav__item">
                            <button type="submit" name="submithandler" value="save_continue" class="kt-nav__link">
                                <i class="kt-nav__link-icon flaticon2-writing"></i>
                                <span class="kt-nav__link-text"><?= lang('Admin.save_continue'); ?></span>
                            </button>
                        </li>
                        <li class="kt-nav__item">
                            <button type="submit" name="submithandler" value="save_and_new" class="kt-nav__link">
                                <i class="kt-nav__link-icon flaticon2-medical-records"></i>
                                <span class="kt-nav__link-text"><?= lang('Admin.save_and_new'); ?></span>
                            </a>
                        </li>
                        <li class="kt-nav__item">
                            <button type="submit" name="submithandler" value="save_and_exit" class="kt-nav__link">
                                <i class="kt-nav__link-icon flaticon2-hourglass-1"></i>
                                <span class="kt-nav__link-text"><?= lang('Admin.save_and_exit'); ?></span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
