<div class="flex-row-fluid ml-lg-8">
    <div class="card card-custom gutter-b">
        <div class="card-header py-5 mb-3">
            <div class="card-title align-items-start flex-column">
                <span class="card-label font-weight-bolder text-dark"><?= lang('Core.Compte Entreprise'); ?></span>
                <span class="text-muted mt-3 font-weight-bold font-size-sm"><?= lang('Core.change your account settings'); ?></span>
            </div>
        </div>
        <div class="card-body py-0">
            <?= view('Adnduweb\Ci4Admin\themes\metronic\templates\companies\__form_section\general.php', ['form' => $company]) ?>
        </div>
        <div class="card-footer d-flex justify-content-between">
            <button type="submit" class="btn btn-light-primary font-weight-bold"><?= lang('Core.valider votre fiche'); ?></button>
        </div>
    </div>
</div>
<input type="hidden" name="action" value="editEntreprise" />