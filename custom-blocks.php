<?php
/**
 * Plugin Name:       Custom Blocks
 * Description:       Example block scaffolded with Create Block tool.
 * Version:           0.1.0
 * Requires at least: 6.7
 * Requires PHP:      7.4
 * Author:            The WordPress Contributors
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       custom-blocks
 *
 * @package CreateBlock
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
/**
 * Registers the block using a `blocks-manifest.php` file, which improves the performance of block type registration.
 * Behind the scenes, it also registers all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
 */
function create_block_custom_blocks_block_init() {
	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` and registers the block type(s)
	 * based on the registered block metadata.
	 * Added in WordPress 6.8 to simplify the block metadata registration process added in WordPress 6.7.
	 *
	 * @see https://make.wordpress.org/core/2025/03/13/more-efficient-block-type-registration-in-6-8/
	 */
	if ( function_exists( 'wp_register_block_types_from_metadata_collection' ) ) {
		wp_register_block_types_from_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
		return;
	}

	/**
	 * Registers the block(s) metadata from the `blocks-manifest.php` file.
	 * Added to WordPress 6.7 to improve the performance of block type registration.
	 *
	 * @see https://make.wordpress.org/core/2024/10/17/new-block-type-registration-apis-to-improve-performance-in-wordpress-6-7/
	 */
	if ( function_exists( 'wp_register_block_metadata_collection' ) ) {
		wp_register_block_metadata_collection( __DIR__ . '/build', __DIR__ . '/build/blocks-manifest.php' );
	}
	/**
	 * Registers the block type(s) in the `blocks-manifest.php` file.
	 *
	 * @see https://developer.wordpress.org/reference/functions/register_block_type/
	 */
	$manifest_data = require __DIR__ . '/build/blocks-manifest.php';
	foreach ( array_keys( $manifest_data ) as $block_type ) {
		register_block_type( __DIR__ . "/build/{$block_type}" );
	}

	# Register the blocks here
	register_block_type( __DIR__ . '/build/featured-topic-block' );
}

function register_custom_blocks_post_meta() {
	// 在這裡註冊新的 post meta
	$featured_topic_block_post_meta = array(
		'_featuredTopicCount' => array(
			'type' => 'integer',
			'single' => true,
			'sanitize_callback' => 'intval',
		)
	);

	$post_meta = array_merge(
		$featured_topic_block_post_meta
	);

	foreach ( $post_meta as $meta_key => $args ) {
		register_post_meta(
			'post',
			$meta_key,
			array(
				'show_in_rest'    => isset( $args['show_in_rest'] ) ? $args['show_in_rest'] : true,
				'type'            => isset( $args['type'] ) ? $args['type'] : 'string',
				'single'          => isset( $args['single'] ) ? $args['single'] : false,
				'auth_callback'    => function () {
					return current_user_can( 'edit_posts' );
				},
			) );
	}
}

add_action( 'init', 'create_block_custom_blocks_block_init' );
add_action( 'init', 'register_custom_blocks_post_meta' );

# Admin Site Settings
add_action('admin_menu', function () {
    add_options_page(
        'Custom Blocks 設定',
        'Custom Blocks',
        'manage_options',
        'custom-blocks-settings',
        'render_custom_blocks_settings_page'
    );
});

function render_custom_blocks_settings_page() {
    // 儲存設定
    if (
        ( isset( $_POST['custom_blocks_api_url'] ) || isset( $_POST['featured_topic_endpoint'] ) ) &&
        check_admin_referer( 'custom_blocks_settings_save', 'custom_blocks_settings_nonce' )
    ) {
        if ( isset( $_POST['custom_blocks_api_url'] ) ) {
            update_option( 'custom_blocks_api_url', sanitize_text_field( $_POST['custom_blocks_api_url'] ) );
        }
        if ( isset( $_POST['featured_topic_endpoint'] ) ) {
            update_option( 'featured_topic_endpoint', sanitize_text_field( $_POST['featured_topic_endpoint'] ) );
        }
        echo '<div class="updated"><p>已儲存設定！</p></div>';
    }
    $api_url = get_option( 'custom_blocks_api_url', '' );
    $featured_topic_endpoint = get_option( 'featured_topic_endpoint', '' );
    ?>
    <div class="wrap">
        <h1>Custom Blocks 設定</h1>
        <form method="post">
            <?php wp_nonce_field( 'custom_blocks_settings_save', 'custom_blocks_settings_nonce' ); ?>
            <table class="form-table">
                <tr>
                    <th scope="row"><label for="custom_blocks_api_url">API URL</label></th>
                    <td>
                        <input name="custom_blocks_api_url" type="text" id="custom_blocks_api_url" value="<?php echo esc_attr( $api_url ); ?>" class="regular-text" />
                        <p class="description">API 網址</p>
                    </td>
                </tr>
                <tr>
                    <th scope="row"><label for="featured_topic_endpoint">Featured Topic Endpoint</label></th>
                    <td>
                        <input name="featured_topic_endpoint" type="text" id="featured_topic_endpoint" value="<?php echo esc_attr( $featured_topic_endpoint ); ?>" class="regular-text" />
                        <p class="description">Featured Topic Block 的端點</p>
                    </td>
                </tr>
            </table>
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
