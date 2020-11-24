<?php 

use \Adnduweb\Ci4Admin\Libraries\Theme;

?>
<!-- begin:: Aside -->
<div class="aside aside-left  aside-fixed  d-flex flex-column flex-row-auto" id="kt_aside">

	<!-- begin:: Aside -->
	<div class="brand flex-column-auto " id="kt_brand">
		<!--begin::Logo-->
		<a href="/<?= CI_AREA_ADMIN; ?>/dashboard" class="brand-logo">
			<?= company()->raison_social; ?>
		</a>
		<!--end::Logo-->

		<!--begin::Toggle-->
		<button class="brand-toggle btn btn-sm px-0 <?= (service('settings')->setting_aside_back == '1') ? 'active' : ''; ?>" data-kt_aside="<?= service('settings')->setting_aside_back; ?>" id="kt_aside_toggle">
			<?= Theme::getSVG('assets/media/svg/icons/Navigation/Angle-double-left.svg', 'svg-icon svg-icon svg-icon-xl', true); ?> 
		 </button>
		<!--end::Toolbar-->
	</div>

	<!-- end:: Aside -->


	<!--begin::Aside Menu-->
	<div class="aside-menu-wrapper flex-column-fluid" id="kt_aside_menu_wrapper">

		<!--begin::Menu Container-->
		<div id="kt_aside_menu" class="aside-menu my-4 " data-menu-vertical="1" data-menu-scroll="1" data-menu-dropdown-timeout="500">
			<ul class="menu-nav ">
				<?php //print_r($currentUrlSegment);
				?>
				<?php foreach ($menu as $k) { ?>
					<?php if ($k->id_parent == '0' && $k->section == '0') { ?>

						<?php if (empty($k->submenu)) {
							$temp = explode('/', $k->slug);
							$slugActive = (is_array($temp) && isset($temp[1])) ?  $slugActive = $temp[1]  :  $k->slug;
						?>
							<li class="menu-item menu_item_<?= $k->id; ?> <?= isset($currentUrlSegment[$slugActive]) ? " menu-item-active menu-" . $slugActive : ''; ?>" aria-haspopup="true">
								<a href="/<?= CI_AREA_ADMIN; ?>/<?= strtolower($k->slug); ?>" class="menu-link ">
									<?php if (!empty($k->icon)) { ?>
										<span class="svg-icon menu-icon">
											<?= $k->icon; ?>
										</span>
									<?php } else { ?>
										<?= Theme::getSVG('assets/media/svg/icons/Design/Layers.svg', 'svg-icon svg-icon-sm', true); ?> 
										<
									<?php } ?>
									<span class="menu-text"><?= ucfirst($k->name); ?></span>
								</a>
							</li>
						<?php } else { ?>
							<?php if (has_permission(ucfirst($k->class_name) . '::view', user()->id)) { ?>
								<li class="menu-item menu_item_<?= $k->id; ?> menu-item-submenu <?= isset($currentUrlSegment[$k->slug]) ? "menu-item-open" : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">
									<a href="javascript:;" class="menu-link menu-toggle">
										<span class="svg-icon menu-icon">
											<?= $k->icon; ?>
										</span>
										<span class="menu-text"><?= ucfirst($k->name); ?></span>
										<i class="menu-arrow"></i>
									</a>
									<div class="menu-submenu "><span class="kt-menu__arrow"></span>
										<ul class="menu-subnav">
											<?php foreach ($k->children as $children) { ?>
												<?php if (has_permission(ucfirst($children->class_name) . '::view', user()->id)) { ?>
													<?php if (empty($children->submenu)) { ?>
														<li class="menu-item <?= isset($currentUrlSegment[$children->slug]) ? " menu-item-active" : ''; ?>" aria-haspopup="true">
															<a href="/<?= CI_AREA_ADMIN; ?>/<?= strtolower($k->slug); ?>/<?= strtolower($children->slug); ?>" class="menu-link ">
																<i class="menu-bullet menu-bullet-line"><span></span></i>
																<span class="menu-text"><?= ucfirst($children->name); ?> </span>
															</a>
														</li>
													<?php } else { ?>
														<li class="menu-item  menu-item-submenu <?= isset($currentUrlSegment[$children->slug]) ? "menu-item-open" : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">
															<a href="javascript:;" class="menu-link menu-toggle">
																<i class="menu-bullet menu-bullet-line"><span></span></i>
																<span class="menu-text"><?= ucfirst($children->name); ?></span>
																<i class="menu-arrow"></i>
															</a>
															<div class="menu-submenu "><span class="kt-menu__arrow"></span>
																<ul class="menu-subnav">
																	<?php foreach ($children->children as $souschildren) { ?>
																		<?php if (has_permission(ucfirst($souschildren->class_name) . '::view', user()->id)) { ?>
																			<?php $temp = explode('/', $souschildren->slug);
																			$slugActive = (is_array($temp)) ?  $slugActive = $temp[1]  :  '' ?>

																			<li class="menu-item <?= isset($currentUrlSegment[$slugActive]) ? " menu-item-active menu-" . $slugActive : ''; ?>" aria-haspopup="true">
																				<a href="/<?= CI_AREA_ADMIN; ?>/<?= strtolower($k->slug); ?>/<?= strtolower($souschildren->slug); ?>" class="menu-link ">
																					<i class="menu-link-bullet menu-link-bullet--dot">
																						<span></span>
																					</i>
																					<span class="menu-text"><?= ucfirst($souschildren->name); ?> </span>
																				</a>
																			</li>

																		<?php } ?>
																	<?php } ?>
																</ul>
															</div>
														</li>
													<?php } ?>
												<?php } ?>
											<?php } ?>
										</ul>
									</div>
								</li>
							<?php } ?>
						<?php } ?>

					<?php } elseif ($k->id_parent == '0' && $k->section == '1') { ?>
						<li class="kt-menu__section ">
							<h4 class="kt-menu__section-text"><?= ucfirst($k->name); ?></h4>
							<i class="kt-menu__section-icon flaticon-more-v2"></i>
						</li>
						<?php if (isset($k->submenu)) { ?>
							<?php foreach ($k->submenu as $submenu) { ?>
								<?php if (!empty($submenu->children)) { ?>
									<li class="menu-item  menu-item-submenu <?= isset($currentUrlSegment[$submenu->slug]) ? "menu-item--open" : ''; ?>" aria-haspopup="true" data-menu-toggle="hover">
										<a href="javascript:;" class="menu-link menu-toggle">
											<span class="svg-icon menu-icon">
												<?= $submenu->icon; ?>
											</span>
											<span class="menu-text"><?= ucfirst($submenu->name); ?></span>
											<i class="menu-arrow"></i>
										</a>
										<div class="menu-submenu "><span class="kt-menu__arrow"></span>
											<ul class="menu-subnav">
												<?php foreach ($submenu->children as $children) { ?>
													<?php if (has_permission(ucfirst($children->class_name) . '::view', user()->id)) { ?>
														<li class="menu-item <?= isset($currentUrlSegment[$children->slug]) ? " menu-item-active" : ''; ?>" aria-haspopup="true">
															<a href="/<?= CI_AREA_ADMIN; ?>/<?= strtolower($submenu->slug); ?>/<?= strtolower($children->slug); ?>" class="menu-link ">
																<i class="menu-bullet menu-bullet-line"><span></span></i>
																<span class="menu-text"><?= ucfirst($children->name); ?></span>
															</a>
														</li>
													<?php } ?>
												<?php } ?>
											</ul>
										</div>
									</li>
								<?php } else { ?>
									<?php if (has_permission(ucfirst($k->class_name) . '::view', user()->id)) { ?>
										<li class="menu-item  menu-item-submenu <?= isset($currentUrlSegment[$submenu->slug]) ? "menu-item--open" : ''; ?>" aria-haspopup="true">
											<a href="/<?= CI_AREA_ADMIN; ?>/<?= strtolower($k->slug); ?>/<?= strtolower($submenu->slug); ?>" class="menu-link menu-toggle">
												<i class="menu-link-bullet menu-link-bullet--dot">
													<span></span>
												</i>
												<span class="menu-text"><?= ucfirst($submenu->name); ?></span>
											</a>
										</li>
									<?php } ?>
								<?php } ?>
							<?php } ?>
						<?php } ?>
					<?php } else { ?>

					<?php } ?>

				<?php } ?>


			</ul>
		</div>
	</div>

	<!-- end:: Aside Menu -->
</div>

<!-- end:: Aside -->