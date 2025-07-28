<?php
$api_url = get_option( 'custom_blocks_api_url') . get_option( 'featured_topic_endpoint');
$response = wp_remote_get( $api_url );
$data = [];
if ( is_array( $response ) && ! is_wp_error( $response ) ) {
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );
}

$feature_topic_count = isset( $attributes['featuredTopicCount'] ) ? intval( $attributes['featuredTopicCount'] ) : 5;
$feature_topic_marker_base_color = get_option( 'feature_topic_marker_base_color', '#21759b' );
$feature_topic_marker_color_1 = get_option( 'feature_topic_marker_color_1', '#e74c3c' );
$feature_topic_marker_color_2 = get_option( 'feature_topic_marker_color_2', '#f39c12' );
$feature_topic_marker_color_3 = get_option( 'feature_topic_marker_color_3', '#27ae60' );

// 只取前 $feature_topic_count 筆資料
$display_data = array_slice( $data, 0, $feature_topic_count );

if ( ! function_exists( 'get_chinese_number' ) ) {
    function get_chinese_number($num) {
        $map = ['零','一','二','三','四','五','六','七','八','九','十'];
        if ($num >= 1 && $num <= 10) {
            return $map[$num];
        }
        return $num;
    }
}
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
    <h1><?php echo get_chinese_number($feature_topic_count); ?>大看點</h1>
    <ul class="featured-topic-list">
        <?php $i = 1; foreach ( $display_data as $item ) :
            $bg_color = '';
            if ($i === 1) $bg_color = $feature_topic_marker_color_1;
            elseif ($i === 2) $bg_color = $feature_topic_marker_color_2;
            elseif ($i === 3) $bg_color = $feature_topic_marker_color_3;
            else $bg_color = $feature_topic_marker_base_color;
        ?>
            <div class="featured-topic-item">
                <div class="topic-index"
                    style="background-color: <?php echo esc_attr( $bg_color ); ?>;"
                ><?php echo $i; ?></div>
				<a class="topic-title" href="<?php echo esc_url( $item['href'] ); ?>" target="_blank" rel="noopener">
					<?php echo esc_html( $item['title'] ); ?>
				</a>
            </div>
        <?php $i++; endforeach; ?>
    </ul>
</div>
