<!-- begin:: Footer -->
<div class="footer bg-white py-4 d-flex flex-lg-column " id="kt_footer">

    <div class="container-fluid d-flex flex-column flex-md-row align-items-center justify-content-between">
        <!--begin::Copyright-->
        <div class="text-dark order-2 order-md-1">
            <span class="text-muted font-weight-bold mr-2"><?= date('Y') ?>&nbsp;&copy;&nbsp;</span>
            <a href="https://www.adnduweb.com" target="_blank" class="kt-link">Spread Aurora</a> &nbsp;| <?= lang('Core.Page rendered in {elapsed_time} seconds'); ?>
        </div>
        <!--end::Copyright-->
        <!--begin::Nav-->
        <div class="nav nav-dark">
            <a href="/<?= CI_AREA_ADMIN; ?>/changelogs" target="_blank" class="nav-link pl-0 pr-5">Change Logs</a>
        </div>
        <!--end::Nav-->
    </div>
</div>
<!-- end:: Footer -->