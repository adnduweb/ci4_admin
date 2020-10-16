<!-- Modal -->
<div class="modal fade modal_form_<?= $form->id; ?>" id="kt_modal_loading" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle"><?= ucfirst(lang('Core.formulaire')); ?> </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">

                <div class="py-9">
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Nom:</span>
                        <?= $form->getNom(); ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Prénom:</span>
                        <?= $form->prenom; ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Email:</span>
                        <?= $form->email; ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Téléphone:</span>
                        <?= $form->telephone; ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Adresse ip:</span>
                        <?= $form->ip_address; ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Agent:</span>
                        <?= $form->user_agent; ?>
                    </div>

                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Subject:</span>
                        <?= $form->subject; ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Message:</span>
                        <?= nl2br($form->message); ?>
                    </div>
                    <div class="d-flex align-items-center justify-content-start mb-2">
                        <span class="font-weight-bold mr-2">Date:</span>
                        <?= nl2br($form->getCreated()); ?>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= lang('Core.close'); ?></button>
            </div>
        </div>
    </div>
</div>