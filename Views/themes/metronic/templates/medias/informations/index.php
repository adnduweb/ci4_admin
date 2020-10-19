<?= $this->extend('/admin/themes/metronic/__layouts/layout_1') ?>
<?= $this->section('main') ?>
<!-- end:: Header -->
<!-- begin:: Content -->
<div class="content d-flex flex-column flex-column-fluid" id="kt_content">
    <?= $this->include('/admin/themes/metronic/__partials/kt_list_toolbar') ?>
    <div id="ContentInformations" class="d-flex flex-column-fluid">

        <div class="container-fluid">
            <div class="row ">
                <div class="col-xl-6">
                    <!--begin::Portlet-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Environnement</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php foreach ($envs as $env) { ?>
                                <?php if ($env['name'] == 'Cache driver') { ?>
                                    <!--begin::Accordion-->
                                    <div class="accordion accordion-light accordion-light-borderless accordion-svg-toggle" id="accordionExample7">
                                        <div class="card">
                                            <div class="card-header" id="headingOne7">
                                                <div class="card-title" data-toggle="collapse" data-target="#collapseOne7">
                                                    <span class="svg-icon svg-icon-primary">
                                                        <!--begin::Svg Icon | path:/metronic/themes/metronic/theme/html/demo1/dist/assets/media/svg/icons/Navigation/Angle-double-right.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                                                            <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                                                <polygon points="0 0 24 0 24 24 0 24" />
                                                                <path d="M12.2928955,6.70710318 C11.9023712,6.31657888 11.9023712,5.68341391 12.2928955,5.29288961 C12.6834198,4.90236532 13.3165848,4.90236532 13.7071091,5.29288961 L19.7071091,11.2928896 C20.085688,11.6714686 20.0989336,12.281055 19.7371564,12.675721 L14.2371564,18.675721 C13.863964,19.08284 13.2313966,19.1103429 12.8242777,18.7371505 C12.4171587,18.3639581 12.3896557,17.7313908 12.7628481,17.3242718 L17.6158645,12.0300721 L12.2928955,6.70710318 Z" fill="#000000" fill-rule="nonzero" />
                                                                <path d="M3.70710678,15.7071068 C3.31658249,16.0976311 2.68341751,16.0976311 2.29289322,15.7071068 C1.90236893,15.3165825 1.90236893,14.6834175 2.29289322,14.2928932 L8.29289322,8.29289322 C8.67147216,7.91431428 9.28105859,7.90106866 9.67572463,8.26284586 L15.6757246,13.7628459 C16.0828436,14.1360383 16.1103465,14.7686056 15.7371541,15.1757246 C15.3639617,15.5828436 14.7313944,15.6103465 14.3242754,15.2371541 L9.03007575,10.3841378 L3.70710678,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(9.000003, 11.999999) rotate(-270.000000) translate(-9.000003, -11.999999) " />
                                                            </g>
                                                        </svg>
                                                        <!--end::Svg Icon-->
                                                    </span>
                                                    <div class="card-label pl-4"> <?= $env['name']; ?> | <?= $env['value'][0]; ?></div>
                                                </div>
                                            </div>
                                            <div id="collapseOne7" class="collapse" data-parent="#accordionExample7">
                                                <div class="card-body pl-12">
                                                    <pre>
                                                            <?php print_r($env['value'][1]); ?>
                                                        </pre>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                    <!--end::Accordion-->
                                <?php } else { ?>
                                    <div class="d-flex align-items-center flex-wrap mb-10">
                                        <div class="symbol symbol-50 symbol-light mr-5">
                                            <span class="symbol-label">
                                                <?= $env['name'][0]; ?>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column flex-grow-1 mr-2">
                                            <span class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1"><?= $env['name']; ?></span>
                                        </div>
                                        <span class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder"><?= word_limiter($env['value'], 5); ?></span>
                                    </div>
                                <?php } ?>

                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <!--begin::Portlet-->
                    <div class="card card-custom gutter-b">
                        <div class="card-header">
                            <div class="card-title">
                                <h3 class="card-label">Dépendances</h3>
                            </div>
                        </div>

                        <div class="card-body">
                            <?php foreach ($dependencies as $k => $v) { ?>
                                <div class="d-flex align-items-center flex-wrap mb-10">
                                        <div class="symbol symbol-50 symbol-light mr-5">
                                            <span class="symbol-label">
                                                <?= $k[0]; ?>
                                            </span>
                                        </div>
                                        <div class="d-flex flex-column flex-grow-1 mr-2">
                                            <span class="font-weight-bold text-dark-75 text-hover-primary font-size-lg mb-1"><?= $k; ?></span>
                                        </div>
                                        <a target="_blank" href="https://github.com/<?= $k; ?>" class="label label-xl label-light label-inline my-lg-0 my-2 text-dark-50 font-weight-bolder"><?= $v; ?></a>
                                    </div>

                                    
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>