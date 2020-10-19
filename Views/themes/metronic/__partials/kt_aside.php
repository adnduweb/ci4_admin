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
			<span class="svg-icon svg-icon svg-icon-xl">
				<!--begin::Svg Icon | path:assets/media/svg/icons/Navigation/Angle-double-left.svg--><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
					<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
						<polygon points="0 0 24 0 24 24 0 24" />
						<path d="M5.29288961,6.70710318 C4.90236532,6.31657888 4.90236532,5.68341391 5.29288961,5.29288961 C5.68341391,4.90236532 6.31657888,4.90236532 6.70710318,5.29288961 L12.7071032,11.2928896 C13.0856821,11.6714686 13.0989277,12.281055 12.7371505,12.675721 L7.23715054,18.675721 C6.86395813,19.08284 6.23139076,19.1103429 5.82427177,18.7371505 C5.41715278,18.3639581 5.38964985,17.7313908 5.76284226,17.3242718 L10.6158586,12.0300721 L5.29288961,6.70710318 Z" fill="#000000" fill-rule="nonzero" transform="translate(8.999997, 11.999999) scale(-1, 1) translate(-8.999997, -11.999999) " />
						<path d="M10.7071009,15.7071068 C10.3165766,16.0976311 9.68341162,16.0976311 9.29288733,15.7071068 C8.90236304,15.3165825 8.90236304,14.6834175 9.29288733,14.2928932 L15.2928873,8.29289322 C15.6714663,7.91431428 16.2810527,7.90106866 16.6757187,8.26284586 L22.6757187,13.7628459 C23.0828377,14.1360383 23.1103407,14.7686056 22.7371482,15.1757246 C22.3639558,15.5828436 21.7313885,15.6103465 21.3242695,15.2371541 L16.0300699,10.3841378 L10.7071009,15.7071068 Z" fill="#000000" fill-rule="nonzero" opacity="0.3" transform="translate(15.999997, 11.999999) scale(-1, 1) rotate(-270.000000) translate(-15.999997, -11.999999) " />
					</g>
				</svg>
				<!--end::Svg Icon--></span> </button>
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
				<?php foreach ($nav as $k) { ?>
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
										<span class="svg-icon menu-icon">
											<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1" class="kt-svg-icon">
												<g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
													<rect x="0" y="0" width="24" height="24" />
													<circle fill="#000000" opacity="0.3" cx="12" cy="12" r="10" />
													<path d="M12,16 C12.5522847,16 13,16.4477153 13,17 C13,17.5522847 12.5522847,18 12,18 C11.4477153,18 11,17.5522847 11,17 C11,16.4477153 11.4477153,16 12,16 Z M10.591,14.868 L10.591,13.209 L11.851,13.209 C13.447,13.209 14.602,11.991 14.602,10.395 C14.602,8.799 13.447,7.581 11.851,7.581 C10.234,7.581 9.121,8.799 9.121,10.395 L7.336,10.395 C7.336,7.875 9.31,5.922 11.851,5.922 C14.392,5.922 16.387,7.875 16.387,10.395 C16.387,12.915 14.392,14.868 11.851,14.868 L10.591,14.868 Z" fill="#000000" />
												</g>
											</svg>
										</span>
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