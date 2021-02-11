<?php use \Adnduweb\Ci4Admin\Libraries\Theme; ?>
 <!--begin::Header-->
 <div id="kt_header" class="header  header-fixed ">
 	<!--begin::Container-->
 	<div class=" container-fluid  d-flex align-items-stretch justify-content-between">
 		<!--begin::Header Menu Wrapper-->
 		<div class="header-menu-wrapper header-menu-wrapper-left" id="kt_header_menu_wrapper">
 			<!--begin::Header Menu-->
 			<div id="kt_header_menu" class="header-menu header-menu-mobile  header-menu-layout-default ">
 				<ul class="menu-nav ">
 					<?php if (service('settings')->setting_activer_front == true) { ?>

 						<?php if (class_exists('\Adnduweb\Ci4_page\Controllers\Admin\AdminPageController')) { ?>
 							<li class="menu-item" aria-haspopup="true">
 								<a href="<?= CI_AREA_ADMIN; ?>/public/pages" class="menu-link btn btn-light">
								 	<?= Theme::getSVG('media/svg/icons/Design/Pencil.svg', 'svg-icon svg-icon-xl svg-icon-primary', true); ?> 
 									<span class="menu-text"><?= ucfirst(lang('Core.pages')); ?></span>
 								</a>
 							</li>
 						<?php } ?>
 						<?php if (class_exists('\Adnduweb\Ci4_blog\Controllers\Admin\AdminPostController')) { ?>
 							<li class="menu-item" aria-haspopup="true">
 								<a href="<?= CI_AREA_ADMIN; ?>/public/blog/posts" class="menu-link btn btn-light">
 									<i class="icon-md la la-book"></i>&nbsp;&nbsp;
 									<span class="menu-text"><?= ucfirst(lang('Core.blog')); ?></span>
 								</a>
 							</li>
 						<?php } ?>


 					<?php } ?>
 					<?php if (inGroups(1, user()->id)) { ?>
 						<li class="menu-item" aria-haspopup="true">
 							<a href="<?= CI_AREA_ADMIN; ?>/settings-advanced/settings" class="menu-link btn btn-light">
							 	<?= Theme::getSVG('media/svg/icons/General/Settings-2.svg', 'svg-icon svg-icon-md', true); ?> 
 								<span class="menu-text"><?= ucfirst(lang('Core.settings')); ?></span>

 							</a>
 						</li>
 						<li class="menu-item " aria-haspopup="true">
 							<a href="<?= CI_AREA_ADMIN; ?>/cache/deleteFront" class="btn btn-warning">
							 	<?= Theme::getSVG('media/svg/icons/Home/Trash.svg', 'svg-icon svg-icon-md', true); ?> 
 								<span class="menu-text"><?= ucfirst(lang('Core.delete_cache')); ?></span>

 							</a>
 						</li>
 					<?php } ?>
 				</ul>
 				<!--end::Header Nav-->
 			</div>
 			<!--end::Header Menu-->
 		</div>
 		<!--end::Header Menu Wrapper-->

 		<!-- begin:: Header Topbar -->
 		<div class="topbar">

		 	<?php if (class_exists('\Adnduweb\Ci4Front\Config\Front')) { ?>
 				<div class="dropdown">
 					<div class="topbar-item">
						<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary notification_bout">
							<a target="_blank" href="<?= base_url(); ?>" id="kt_quick_website" data-container="body" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="<?= lang('Core.accéder au site'); ?>">
								<div class="kt-header__topbar-wrapper">
									<?= Theme::getSVG('media/svg/icons/Home/Earth.svg', 'svg-icon svg-icon-xl svg-icon-primary', true); ?> 
								</div>
							</a>
			 			</div>
 					</div>
 				</div>
 			<?php } ?>


 			<!--begin: Notifications -->
 			<div class="dropdown">
 				<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px" aria-expanded="true">
 					<div class="btn btn-icon btn-clean btn-dropdown btn-lg mr-1 pulse pulse-primary notification_bout">
					 	<?= Theme::getSVG('media/svg/icons/Code/Compiling.svg', 'svg-icon svg-icon-xl svg-icon-primary', true); ?> 
 					</div>
 				</div>
 				<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
 					<form>
 						<!--begin: Head -->
 						<div class="d-flex flex-column pt-12 bgi-size-cover bgi-no-repeat rounded-top" style="background-image: url(/admin/themes/<?= $theme_admin; ?>/<?= ENVIRONMENT; ?>/media/misc/bg-1.jpg)">
 							<h4 class="d-flex flex-center rounded-top">
 								<span class="text-white"><?= lang('Core.user_notification'); ?></span>
 								&nbsp;
 								<span id="countNotif" class="btn btn-text btn-success btn-sm font-weight-bold btn-font-md ml-2">0</span>
 							</h4>
 							<ul class="nav nav-bold nav-tabs nav-tabs-line nav-tabs-line-3x nav-tabs-line-transparent-white nav-tabs-line-active-border-success mt-3 px-8" role="tablist">
 								<li class="nav-item">
 									<a class="nav-link active show notificationAction" data-kt_notification="alert" data-toggle="tab" href="#topbar_notifications_notifications" role="tab" aria-selected="true"><?= lang('Core.alerts'); ?></a>
 								</li>
 								<li class="nav-item">
 									<a class="nav-link notificationAction" data-kt_notification="event" data-toggle="tab" href="#topbar_notifications_events" role="tab" aria-selected="false"><?= lang('Core.events'); ?></a>
 								</li>
 								<li class="nav-item">
 									<a class="nav-link notificationAction" data-kt_notification="log" data-toggle="tab" href="#topbar_notifications_logs" role="tab" aria-selected="false"><?= lang('Core.logs'); ?></a>
 								</li>
 							</ul>
 						</div>

 						<!--end: Head -->
 						<div class="tab-content">
 							<div class="tab-pane active show p-8" id="topbar_notifications_notifications" role="tabpanel">
							 <?= $this->include('\Adnduweb\Ci4Admin\themes\/'.$theme_admin.'/\__partials\notifications\alerts', []); ?>
 							</div>
 							<div class="tab-pane p-8" id="topbar_notifications_events" role="tabpanel">
							 <?= $this->include('\Adnduweb\Ci4Admin\themes\/'.$theme_admin.'/\__partials\notifications\event', []); ?>
 							</div>
 							<div class="tab-pane p-8" id="topbar_notifications_logs" role="tabpanel">
							 <?= $this->include('\Adnduweb\Ci4Admin\themes\/'.$theme_admin.'/\__partials\notifications\logs', []); ?>

 							</div>
 						</div>
 					</form>
 				</div>
 			</div>
 			<!--end: Notifications -->


 			<!--begin::Search-->
 			<div class="dropdown" id="kt_quick_search_toggle">
 				<!--begin::Toggle-->
 				<div class="topbar-item" data-toggle="dropdown" data-offset="10px,0px">
 					<div class="btn btn-icon btn-clean btn-lg btn-dropdown mr-1">
						<?= Theme::getSVG('media/svg/icons/General/Search.svg', 'svg-icon svg-icon-xl svg-icon-primary', true); ?> 
 					 </div>
 				</div>
 				<!--end::Toggle-->

 				<!--begin::Dropdown-->
 				<div class="dropdown-menu p-0 m-0 dropdown-menu-right dropdown-menu-anim-up dropdown-menu-lg">
 					<div class="quick-search quick-search-dropdown" id="kt_quick_search_dropdown">
 						<!--begin:Form-->
 						<form method="get" class="quick-search-form">
 							<div class="input-group">
 								<div class="input-group-prepend">
 									<span class="input-group-text">
										 <?= Theme::getSVG('media/svg/icons/General/Search.svg', 'svg-icon svg-icon-xl svg-icon-primary', true); ?> 
 									 </span>
 								</div>
 								<input type="text" class="form-control" placeholder="<?= lang('Core.Search...'); ?>" />
 								<div class="input-group-append">
 									<span class="input-group-text">
 										<i class="quick-search-close ki ki-close icon-sm text-muted"></i>
 									</span>
 								</div>
 							</div>
 						</form>
 						<!--end::Form-->

 						<!--begin::Scroll-->
 						<div class="quick-search-wrapper scroll" data-scroll="true" data-height="325" data-mobile-height="200">
 						</div>
 						<!--end::Scroll-->
 					</div>
 				</div>
 				<!--end::Dropdown-->
 			</div>
 			<!--end::Search-->

 			<!--begin::User-->
 			<div class="topbar-item">
 				<div class="btn btn-icon btn-icon-mobile w-auto btn-clean d-flex align-items-center btn-lg px-2" id="kt_quick_user_toggle">
 					<span class="text-muted font-weight-bold font-size-base d-none d-md-inline mr-1"><?= ucfirst(lang('Core.hi')); ?>,</span>
 					<span class="text-dark-50 font-weight-bolder font-size-base d-none d-md-inline mr-3"><?= user()->firstname; ?></span>
 					<span class="symbol symbol-lg-35 symbol-25 symbol-light-success">
 						<span class="symbol-label font-size-h5 font-weight-bold"><?= user()->firstname[0]; ?> <?= user()->lastname[0]; ?></span>
 					</span>
 				</div>
 			</div>
 			<!--end::User-->
 		</div>
 		<!--end::Topbar-->
 	</div>
 	<!--end::Container-->
 </div>
 <!--end::Header-->