<div class="card-body pt-4">
    <!--begin::Timeline-->
    <div class="timeline timeline-6 mt-3">
        <?php if (!empty($getLastConnexions)) { ?>
        <?php foreach ($getLastConnexions as $lastConnexion) { ?>

            <div class="timeline-item align-items-start">
                <!--begin::Label-->
                <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg"><?=  relative_time($lastConnexion->date); ?></div>
                <!--end::Label-->
                <!--begin::Badge-->
                <div class="timeline-badge">
                    <i class="fa fa-genderless text-warning icon-xl"></i>
                </div>
                <!--end::Badge-->
                <!--begin::Text-->
                <div class="font-weight-mormal font-size-lg timeline-content text-muted pl-3">
                <?php
                    $agent = new WhichBrowser\Parser($lastConnexion->agent);
                    //  print_r($agent); exit;
                    if ($agent->isType('desktop') == true) { ?>
                            <?= ucfirst(lang('Core.desktop')); ?> |
                            <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                            <?= $agent->os->toString(); ?>  | <?= $agent->device->model; ?>
                    <?php } ?>
                    <?php  if ($agent->isType('mobile') == true) {  ?>
                            <?= ucfirst(lang('Core.Mobile')); ?> |
                            <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                            <?= $agent->os->toString(); ?> | <?= $agent->device->model; ?> | <?= $agent->device->identifier; ?>
                    <?php } ?>
                    <?php  if ($agent->isType('tablet') == true) {  ?>
                            <?= ucfirst(lang('Core.Tablet')); ?> |
                            <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                            <?= $agent->os->toString(); ?> | <?= $agent->device->model; ?>
                    <?php } ?><br/>
                    <a href="#" class="text-primary">#<?=  $lastConnexion->ip_address; ?></a>
                </div>
                <!--end::Text-->
            </div>

        <?php } ?>
    <?php } ?>
        </div>
    <!--end::Timeline-->
</div>

