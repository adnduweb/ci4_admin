<?= $this->extend('Adnduweb\Ci4Admin\themes\metronic\__layouts\layout_1') ?>
<?= $this->section('main') ?>
<!-- end:: Header -->
<div class="content  d-flex flex-column flex-column-fluid" id="kt_content">
    <?= $this->include('Adnduweb\Ci4Admin\themes\metronic\__partials\kt_list_toolbar') ?>
    <div id="ContentInformations" class="d-flex flex-column-fluid">

        <div class="container-fluid">
            <div class="row ">
                <div class="col-xl-12">
                    <!--begin::Portlet-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label"> <?= $now->toLocalizedString('d MMM yyyy à HH:mm'); ?></h3>
                            </div>
                        </div>

                        <div class="card-body">

                            <h5><?= env('app.nameApp'); ?> v1.7.3 - 22 Décembre 2020</h5>
                            <p>Mises à jours &amp; Améliorations</p>
                            <ul>
                                <li><span class="badge badge-html">HTML Admin</span> <code>Metronic v7.1.6</code>.</li>
                                <li><span class="badge badge-core">Core</span>Nettoyage <code> Controllers, Models, Views</code>.</li>
                                <li><span class="badge badge-core">Core</span>Nettoyage <code> Webpack.</code> Suppression de code superflu + installation mode dev et prod.</li>
                                <li><span class="badge badge-core">Core</span>Ajout d'une fonction <code> assetAdmin(), assetAdminFavicons(), assetAdminLanguage().</code>.</li>
                                <li><span class="badge badge-core">Core</span>Ajout de module <code> Média.</code> au sein du core.</li>
                            </ul>

                            <div class="space"></div>

                            <p>Fixes</p>
                            <ul>
                                <li><span class="badge badge-core">Core</span> Fixé <code>Suppression de commande</code>.</li>
                                <li><span class="badge badge-core">Core</span> Fixé Ajout de <code>"forgotPassword" dans les urls exclus </code>.</li>
                                <li><span class="badge badge-core">Core</span> Fixé Ajout de <code>"forgotPassword" dans les urls exclus </code>.</li>
                                <li><span class="badge badge-core">Core</span> Fixé redirection out dans le filtre maintenance.</li>
                                <li><span class="badge badge-core">Core</span> Fixé dans Tools l'apparition de la notice.</li>
                            </ul>

                            <div class="space"></div>

                        </div>

                        <div class="card-body">

                            <h5><?= env('app.nameApp'); ?> v1.7.2.3 - 31 Aout 2020</h5>
                            <p>Mises à jours &amp; Améliorations</p>
                            <ul>
                                <li><span class="badge badge-html">HTML Admin</span> <code>Metronic v7.0.9</code>.</li>
                                <li><span class="badge badge-core">Core</span>Nettoyage <code> Controllers, Models, Views</code>.</li>
                                <li><span class="badge badge-core">Core</span>Nettoyage <code> dossier Bundle, Themes.</code> Installation de Webpack.</li>
                                <li><span class="badge badge-core">Core</span>Ajout d'une fonction <code> assetAdmin().</code>.</li>
                                <li><span class="badge badge-core">Core</span>Ajout de la librairie de Géolocalisation fonction <code> IP2Location_lib.</code>.</li>
                                <li><span class="badge badge-core">Core</span>Ajout de la librairie de Métronic fonction <code> Metronic.</code>.</li>
                                <li><span class="badge badge-core">Core</span>Ajout du Module Paypal <code> Dev.</code></li>
                                <li><span class="badge badge-core">Core</span>Ajout du Module Stripe <code> Dev.</code></li>
                                <li><span class="badge badge-core">Core</span>Ajout du Module Whoops <code> Dev.</code></li>
                            </ul>

                            <div class="space"></div>

                            <p>Fixes</p>
                            <ul>
                                <li><span class="badge badge-core">Core</span> Fixé <code>Suppression de commande</code>.</li>
                                <li><span class="badge badge-core">Core</span> Fixé Ajout de <code>"forgotPassword" dans les urls exclus </code>.</li>
                                <li><span class="badge badge-core">Core</span> Fixé Ajout de <code>"forgotPassword" dans les urls exclus </code>.</li>
                                <li><span class="badge badge-core">Core</span> Fixé redirection out dans le filtre maintenance.</li>
                                <li><span class="badge badge-core">Core</span> Fixé dans Tools l'apparition de la notice.</li>
                            </ul>

                            <div class="space"></div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>