<?php

if (!function_exists('assetAdmin')) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function assetAdmin($path)
	{
		return base_url('admin/themes/' . service('settings')->setting_theme_admin . '/'.ENVIRONMENT.'/' . $path);
	}
}


if (!function_exists('assetAdminFavicons')) { 
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function assetAdminFavicons($path)
	{
		return base_url('admin/themes/' . service('settings')->setting_theme_admin . '/favicons/' . $path);
	}
}


if (!function_exists('assetAdminLanguage')) {
	/**
	 * Generate an asset path for the application.
	 *
	 * @param  string  $path
	 * @param  bool|null  $secure
	 * @return string
	 */
	function assetAdminLanguage($path)
	{
		return base_url('admin/themes/' . service('settings')->setting_theme_admin . '/language/' . $path);
	}
}