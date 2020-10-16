<?= $this->extend('/admin/themes/metronic/__layouts/layout_1') ?>
<?= $this->section('main') ?>
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <?= $this->include('/admin/themes/metronic/__partials/kt_list_toolbar') ?>
    <div id="ContentTabs" class="d-flex flex-column-fluid">

        <div class="container-fluid">
            <div class="flex-row ">
                <div class="card card-custom gutter-b">
                    <div class="card-header flex-wrap border-0 pt-6 pb-0">
                        <div class="card-title">
                            <menu id="nestable-menu">
                                <button type="button" class="btn btn-light-primary btn-sm" data-action="expand-all"><?= lang('Core.expand All'); ?></button>
                                <button type="button" class="btn btn-light-primary btn-sm" data-action="collapse-all"><?= lang('Core.collapse All'); ?></button>
                            </menu>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="dd" id="nestable">
                            <?= (afficher_menu_nestable(0, 0, $menu, 'tabs')); ?>
                        </div>
                        <?php if (inGroups(1, user()->id)) {   ?>
                            <textarea id="nestable-output" rows="3" class="form-control"></textarea>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('extra-js') ?>
<script type="text/javascript">
    (function($) {

        'use strict';

        /*
        Update Output
        */
        var updateOutput = function(e) {
            var list = e.length ? e : $(e.target),
                output = list.data('output');
            if (window.JSON) {
                output.val(window.JSON.stringify(list.nestable('serialize')));
            } else {
                output.val('JSON browser support required for this demo.');
            }
            $.ajax({
                method: "POST",
                url: basePath + segementAdmin + "/sp-admin-ajax",
                data: {
                    ajax: true,
                    controller: "AdminTabController",
                    action: "sortmenu",
                    value: list.nestable('toArray'),
                    module: false
                },
                responseType: 'json',
                beforeSend: function(xhr) {
                    KTApp.block("#kt_aside", {
                        overlayColor: "#000000",
                        state: "primary"
                    });
                    KTApp.block("#nestable", {
                        overlayColor: "#000000",
                        state: "primary"
                    })
                },
                success: function(response, status, xhr) {
                    //Success Message
                    KTApp.unblock("#kt_aside");
                    KTApp.unblock("#nestable");
                    if (xhr.status == 200) {
                        console.log(response);
                        $('#__partialsKtSide').html(response.htmlNav);
                        $.notify({
                            title: _LANG_.updated + "!",
                            message: response.message
                        }, {
                            type: "success"
                        });
                    }
                }
            });
        }

        /*
        Nestable 1
        */
        $('#nestable').nestable({
            // group: 1,
            maxDepth: 4,
            onDragStart: function(event, item, source) {
                //console.log('dragStart', event, item, source);
            },
            beforeDragStop: function(event, item, source) {
                //console.log('beforeDragStop', event, item, source);
            },
            callback: function(l, e, p) {
                updateOutput($('#nestable').data('output', $('#nestable-output')));
            }

        });

        $('#nestable-menu').on('click', function(e) {
            var target = $(e.target),
                action = target.data('action');
            if (action === 'expand-all') {
                $('.dd').nestable('expandAll');
            }
            if (action === 'collapse-all') {
                $('.dd').nestable('collapseAll');
            }
        });
    }).apply(this, [jQuery]);
</script>
<?= $this->endSection() ?>