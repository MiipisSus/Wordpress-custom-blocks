<?php
/**
 * Plugin Name:       Custom Blocks
 * Description:       這是一個測試用的插件包，裡面只有一個區塊插件『精選主題』。
 * Version:           1.0.2
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       custom-blocks
 *
 * @package CreateBlock
 */

use YahnisElsts\PluginUpdateChecker\v5\PucFactory;

require 'plugin-update-checker/plugin-update-checker.php';

$updateChecker = PucFactory::buildUpdateChecker(
	'https://github.com/MiipisSus/Wordpress-custom-blocks',
	__FILE__,
	'custom-blocks'
);

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function create_block_custom_blocks_block_init() {
	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
		return;
	}

	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	}

	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/build/{$block_type}" );
	}

	# Register the blocks here
	register_block_type( __DIR__ . '/build/featured-topic-block' );
}

add_action( 'init', 'create_block_custom_blocks_block_init' );

require_once __DIR__ . '/inc/post-meta.php';
require_once __DIR__ . '/inc/settings-page.php';
