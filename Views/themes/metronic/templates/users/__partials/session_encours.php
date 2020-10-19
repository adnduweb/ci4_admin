<!-- <?php // if(!empty($user->auth_logins)){?> -->
    <?php if (!empty($getSessionsActive)) { ?>
    <?php foreach ($getSessionsActive as $k => $v) { ?>
        <div class="">
        <button id="<?= $k; ?>" type="button" class="btn btn-danger btn-elevate deleteSession" data-session_en_cours="<?= $k; ?>"><?= lang('Core.session_en_cours_a_supprrimer');?> : <?= $v; ?></button>
        </div>
    <?php } ?>
<?php } ?>
