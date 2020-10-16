<?php if (isset($event['count']) && $event['count'] != '0') { ?>
    <div class="kt-notification kt-margin-t-10 kt-margin-b-10 kt-scroll" data-scroll="true" data-height="300" data-mobile-height="200">
        <?php foreach ($event['lists'] as $k => $ev) { ?>
            <?php foreach ($ev['details'] as $detail) { ?>
                <!-- <a href="/<?= CI_AREA_ADMIN; ?>/public/<?= $k; ?>#<?= $detail->uuid; ?>" class="kt-notification__item"> -->
                <a href="<?= route_to($detail->getNameController() . 'List') ?>?mark-as-read=true" class="kt-notification__item">
                    <div class="kt-notification__item-icon">
                        <i class="flaticon2-psd kt-font-success"></i>
                    </div>
                    <div class="kt-notification__item-details">
                        <div class="kt-notification__item-title">
                        <?= lang('Core.new'); ?> <?= lang('Core.' . $detail->getNameController() . '_message'); ?> : 
                        </div>
                        <div class="kt-notification__item-time">
                            <?= $detail->created_at->humanize(); ?>
                        </div>
                    </div>
                </a>
            <?php } ?>
        <?php } ?>

    </div>
<?php } else { ?>
    <div class="kt-grid kt-grid--ver" style="min-height: 200px;">
        <div class="kt-grid kt-grid--hor kt-grid__item kt-grid__item--fluid kt-grid__item--middle">
            <div class="kt-grid__item kt-grid__item--middle kt-align-center">
                <?= lang('Core.All caught up!'); ?>
                <br><?= lang('Core.No new notifications.'); ?> </div>
        </div>
    </div>
<?php } ?>