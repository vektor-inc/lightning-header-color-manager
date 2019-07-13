<?php
/**
 * Plugin Name: Lightning Header Color Manager
 * Version: 0.0.1
 * Author: Vektor,Inc.
 * Description:
 * License: GPL2
 * Author URI: http://www.vektor-inc.co.jp
** /


/* ---------------------------------------------
	updater
--------------------------------------------- */

require 'inc/plugin-update-checker/plugin-update-checker.php';
$myUpdateChecker = Puc_v4_Factory::buildUpdateChecker(
	'https://github.com/vektor-inc/lightning-header-color-manager',
	__FILE__, // Full path to the main plugin file or functions.php.
	'lightning-header-color-manager'
);
$myUpdateChecker->setBranch( 'master' );

/* ---------------------------------------------
	Check Theme
--------------------------------------------- */

add_action( 'after_setup_theme', 'lhcm_plugin_active' );
function lhcm_plugin_active() {
	// テーマがLightning系じゃなかったら処理を終了
	if ( ! function_exists( 'lightning_get_theme_name' ) ) {
		return;
	}
}

/* ---------------------------------------------
	Run Function
--------------------------------------------- */

add_action( 'plugins_loaded', 'lhcm_skin_loadfunction' );
function lhcm_skin_loadfunction() {
	$skin = get_option( 'lightning_design_skin' );
	if ( $skin == '' || $skin == 'origin' || $skin == 'variety' ) {
		require plugin_dir_path( __FILE__ ) . 'inc/customize-header-color/customize-header-color.php';
	}
}
