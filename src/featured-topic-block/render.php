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
		<?php $i = 1; foreach ( $display_data as $item ) : ?>
			<div class="featured-topic-item">
				<div class="topic-index"
				style="background-color: <?php echo esc_attr( $feature_topic_marker_base_color ); ?>;"
				><?php echo $i; ?></div>
				<div class="topic-title"><?php echo esc_html( $item['title'] ); ?></div>
			</div>
		<?php $i++; endforeach; ?>
	</ul>
</div>
