<?php
// 後台設定頁 function
if ( ! function_exists( 'render_custom_blocks_settings_page' ) ) {
    function render_custom_blocks_settings_page() {
        if (
            ( isset( $_POST['custom_blocks_api_url'] ) ||
              isset( $_POST['featured_topic_endpoint'] ) ||
              isset( $_POST['feature_topic_marker_base_color'] ) ||
              isset( $_POST['feature_topic_marker_color_1'] ) ||
              isset( $_POST['feature_topic_marker_color_2'] ) ||
              isset( $_POST['feature_topic_marker_color_3'] )
            ) &&
            check_admin_referer( 'custom_blocks_settings_save', 'custom_blocks_settings_nonce' )
        ) {
            if ( isset( $_POST['custom_blocks_api_url'] ) ) {
                update_option( 'custom_blocks_api_url', sanitize_text_field( $_POST['custom_blocks_api_url'] ) );
            }
            if ( isset( $_POST['featured_topic_endpoint'] ) ) {
                update_option( 'featured_topic_endpoint', sanitize_text_field( $_POST['featured_topic_endpoint'] ) );
            }
            if ( isset( $_POST['feature_topic_marker_base_color'] ) ) {
                update_option( 'feature_topic_marker_base_color', sanitize_hex_color( $_POST['feature_topic_marker_base_color'] ) );
            }
            if ( isset( $_POST['feature_topic_marker_color_1'] ) ) {
                update_option( 'feature_topic_marker_color_1', sanitize_hex_color( $_POST['feature_topic_marker_color_1'] ) );
            }
            if ( isset( $_POST['feature_topic_marker_color_2'] ) ) {
                update_option( 'feature_topic_marker_color_2', sanitize_hex_color( $_POST['feature_topic_marker_color_2'] ) );
            }
            if ( isset( $_POST['feature_topic_marker_color_3'] ) ) {
                update_option( 'feature_topic_marker_color_3', sanitize_hex_color( $_POST['feature_topic_marker_color_3'] ) );
            }
            echo '<div class="updated"><p>已儲存設定！</p></div>';
        }
        $api_url = get_option( 'custom_blocks_api_url', '' );
        $featured_topic_endpoint = get_option( 'featured_topic_endpoint', '' );
        $feature_topic_marker_base_color = get_option( 'feature_topic_marker_base_color', '#444444' );
        $feature_topic_marker_color_1 = get_option( 'feature_topic_marker_color_1', '#e74c3c' );
        $feature_topic_marker_color_2 = get_option( 'feature_topic_marker_color_2', '#f39c12' );
        $feature_topic_marker_color_3 = get_option( 'feature_topic_marker_color_3', '#27ae60' );
        ?>

        <div class="wrap">
            <form method="post">
                <h1 style="font-weight: bold; margin-bottom: 20px;">Custom Blocks</h1>
                <h2>API URL 設定</h2>
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
                <h2>Featured Topic Block 設定</h2>
                <table class="form-table">
                    <tr>
                        <th scope="row"><label for="feature_topic_marker_color_1">編號 1 顏色</label></th>
                        <td>
                            <input name="feature_topic_marker_color_1" type="color" id="feature_topic_marker_color_1" value="<?php echo esc_attr( $feature_topic_marker_color_1 ); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="feature_topic_marker_color_2">編號 2 顏色</label></th>
                        <td>
                            <input name="feature_topic_marker_color_2" type="color" id="feature_topic_marker_color_2" value="<?php echo esc_attr( $feature_topic_marker_color_2 ); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="feature_topic_marker_color_3">編號 3 顏色</label></th>
                        <td>
                            <input name="feature_topic_marker_color_3" type="color" id="feature_topic_marker_color_3" value="<?php echo esc_attr( $feature_topic_marker_color_3 ); ?>" />
                        </td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="feature_topic_marker_base_color">其餘編號基本色</label></th>
                        <td>
                            <input name="feature_topic_marker_base_color" type="color" id="feature_topic_marker_base_color" value="<?php echo esc_attr( $feature_topic_marker_base_color ); ?>" />
                            <p class="description">選擇其餘編號的基本顏色</p>
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
