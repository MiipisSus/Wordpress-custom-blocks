<?php
// 後台設定頁 function
if ( ! function_exists( 'render_custom_blocks_settings_page' ) ) {
    function render_custom_blocks_settings_page() {
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
}

if ( ! function_exists( 'custom_blocks_settings_menu' ) ) {
    function custom_blocks_settings_menu() {
        add_options_page(
            'Custom Blocks 設定',
            'Custom Blocks',
            'manage_options',
            'custom-blocks-settings',
            'render_custom_blocks_settings_page'
        );
    }
    add_action('admin_menu', 'custom_blocks_settings_menu');
}
