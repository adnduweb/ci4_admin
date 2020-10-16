<div class="flex-row-fluid ml-lg-8">
    <div class="card card-custom gutter-b">
        <div class="card-header py-5 mb-3">
            <div class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark"><?= lang('Core.Compte Personnel'); ?></span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm"><?= lang('Core.change your account settings'); ?></span>
            </div>
        </div>
        <div class="card-body py-0">
        <?= $this->include('/admin/themes/metronic/controllers/fiche/__form_section/profile.php') ?>
        </div>
        <div class="card-footer d-flex justify-content-between">
             <button type="submit" class="btn btn-success"><?= lang('Core.valider votre fiche'); ?></button>
        </div>
    </div>
</div>
<input type="hidden" name="action" value="editPersonnel" />