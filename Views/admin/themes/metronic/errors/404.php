<!DOCTYPE html>
<html lang="<?= service('request')->getLocale(); ?>">

<head>
	<title>404 <?= lang('HTTP.pageNotFound'); ?></title>
	<meta name="description" content="">
	<meta http-equiv="X-UA-Compatible" content="requiresActiveX=true" />
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0" />
	<meta name="apple-mobile-web-app-capable" content="yes" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black" />
	<meta name="robots" content="noindex, nofollow" />

	<!--begin::Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700|Roboto:300,400,500,600,700">
	<!--end::Fonts -->


	<!--begin::Page Custom Styles(used by this page) -->
	<link href="/front/default/css/custom.css" rel="stylesheet" type="text/css" />
	<!--end::Page Custom Styles -->

	<link href="/admin/metronic/plugins/global/plugins.bundle.css" rel="stylesheet" type="text/css" />
	<link href="/admin/metronic/css/style.bundle.css" rel="stylesheet" type="text/css" />

	<link href="/admin/metronic/css/skins/header/base/light.css" rel="stylesheet" type="text/css" />
	<link href="/admin/metronic/css/skins/header/menu/light.css" rel="stylesheet" type="text/css" />
	<link href="/admin/metronic/css/skins/brand/dark.css" rel="stylesheet" type="text/css" />
	<link href="/admin/metronic/css/skins/aside/dark.css" rel="stylesheet" type="text/css" />

	<link rel="shortcut icon" href="/admin/metronic/media/logos/favicon.ico" />

	<style>
		.kt-error-v5 {
			background-position: center;
			background-repeat: no-repeat;
			background-attachment: fixed;
			background-size: cover
		}

		.kt-error-v5 .kt-error_container .kt-error_title>h1 {
			font-size: 14rem;
			margin-left: 25rem;
			margin-top: 18rem;
			font-weight: 700;
			color: #314da7;
			-webkit-text-stroke-color: #fff
		}

		.kt-error-v5 .kt-error_container .kt-error_subtitle {
			margin-left: 26rem;
			margin-top: 3.57rem;
			font-size: 2.3rem;
			font-weight: 700;
			color: #595d6e
		}

		.kt-error-v5 .kt-error_container .kt-error_description {
			margin-left: 26rem;
			font-size: 1.8rem;
			font-weight: 500;
			line-height: 130%;
			color: #74788d
		}

		@media (min-width:1025px) and (max-width:1399px) {
			.kt-error-v5 {
				background-position: bottom -80px left 1300px
			}

			.kt-error-v5 .kt-error_container .kt-error_title>h1 {
				font-weight: 700;
				font-size: 12rem;
				margin-left: 7rem
			}

			.kt-error-v5 .kt-error_container .kt-error_subtitle {
				margin-left: 7rem;
				font-size: 2.3rem;
				font-weight: 700
			}

			.kt-error-v5 .kt-error_container .kt-error_description {
				margin-left: 7rem;
				font-size: 1.8rem;
				font-weight: 500;
				line-height: 130%
			}
		}

		@media (min-width:769px) and (max-width:1024px) {
			.kt-error-v5 .kt-error_container .kt-error_title>h1 {
				font-weight: 700;
				font-size: 12rem;
				margin-left: 7rem
			}

			.kt-error-v5 .kt-error_container .kt-error_subtitle {
				margin-left: 7rem;
				font-size: 2.3rem;
				font-weight: 700
			}

			.kt-error-v5 .kt-error_container .kt-error_description {
				margin-left: 7rem;
				font-size: 1.8rem;
				font-weight: 500;
				line-height: 130%
			}
		}

		@media (max-width:768px) {
			.kt-error-v5 .kt-error_container .kt-error_title>h1 {
				font-size: 6rem;
				margin-top: 5rem;
				margin-left: 4rem
			}

			.kt-error-v5 .kt-error_container .kt-error_subtitle {
				margin-top: 2rem;
				margin-left: 4rem;
				font-size: 2rem;
				line-height: 2rem
			}

			.kt-error-v5 .kt-error_container .kt-error_description {
				font-size: 1.4rem;
				margin-left: 4rem
			}
		}
	</style>

</head>
<!-- begin::Body -->

<body class="kt-quick-panel--right kt-demo-panel--right kt-offcanvas-panel--right kt-header--fixed kt-header-mobile--fixed kt-subheader--enabled kt-subheader--fixed kt-subheader--solid kt-aside--enabled kt-aside--fixed kt-page--loading">

	<!-- begin:: Page -->
	<div class="kt-grid kt-grid--ver kt-grid--root">
		<div class="kt-grid__item kt-grid__item--fluid kt-grid  kt-error-v5" style="background-image: url(/admin/themes/metronic/media/error/bg5.jpg);">
			<div class="kt-error_container">
				<span class="kt-error_title">
					<h1>Oops !</h1>
				</span>
				<p class="kt-error_subtitle">
					La page demandée n'existe pas
				</p>
				<p class="kt-error_description">
					<?php if (!empty($message) && $message !== '(null)') : ?>
						<?= esc($message) ?>
					<?php else : ?>
						<?= lang('HTTP.pageNotFoundTexte'); ?>
					<?php endif ?><br>
					<a style="margin-top:0.8em" class="btn btn-dark" href="/<?= env('CI_AREA_ADMIN'); ?>">Retourner sur l'écran d'accueil</a>
				</p>
			</div>
		</div>
	</div>

	<!-- end:: Page -->

	<!-- begin::Global Config(global config for global JS sciprts) -->
	<script>
		var KTAppOptions = {
			"colors": {
				"state": {
					"brand": "#5d78ff",
					"dark": "#282a3c",
					"light": "#ffffff",
					"primary": "#5867dd",
					"success": "#34bfa3",
					"info": "#36a3f7",
					"warning": "#ffb822",
					"danger": "#fd3995"
				},
				"base": {
					"label": [
						"#c5cbe3",
						"#a1a8c3",
						"#3d4465",
						"#3e4466"
					],
					"shape": [
						"#f0f3ff",
						"#d9dffa",
						"#afb4d4",
						"#646c9a"
					]
				}
			}
		};
	</script>

	<!-- end::Global Config -->
	<!--begin::Global Theme Bundle(used by all pages) -->
	<script src="/admin/metronic/plugins/global/plugins.bundle.js" type="text/javascript"></script>
	<script src="/admin/metronic/js/scripts.bundle.js" type="text/javascript"></script>
	<!--end::Global Theme Bundle -->


</body>
<!-- end::Body -->

</html>