<!-- <?php // if(!empty($user->auth_logins)){?> -->
    <?php if (!empty($getLastConnexions)) { ?>
    <?php foreach ($getLastConnexions as $lastConnexion) { ?>
        <div class="kt-list-timeline__item">
            <span class="kt-list-timeline__badge"></span>
            <span class="kt-list-timeline__text"><?=  relative_time($lastConnexion->date); ?><br>
                <?php
                $agent = new WhichBrowser\Parser($lastConnexion->agent);
                //  print_r($agent); exit;
                if ($agent->isType('desktop') == true) { ?>
                    <code>
                        <?= ucfirst(lang('Core.desktop')); ?> |
                        <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                        <?= $agent->os->toString(); ?>  | <?= $agent->device->model; ?>
                    </code>
                <?php } ?>
                <?php  if ($agent->isType('mobile') == true) {  ?>
                    <code>
                        <?= ucfirst(lang('Core.Mobile')); ?> |
                        <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                        <?= $agent->os->toString(); ?> | <?= $agent->device->model; ?> | <?= $agent->device->identifier; ?>
                    </code>
                <?php } ?>
                <?php  if ($agent->isType('tablet') == true) {  ?>
                    <code>
                        <?= ucfirst(lang('Core.Tablet')); ?> |
                        <?= $agent->browser->name . ' ' . $agent->browser->version->value; ?> |
                        <?= $agent->os->toString(); ?> | <?= $agent->device->model; ?>
                    </code>
                <?php } ?>
            </span>
            <span class="kt-list-timeline__time"> #<?=  $lastConnexion->ip_address; ?></span>

        </div>
    <?php } ?>
<?php } ?>
