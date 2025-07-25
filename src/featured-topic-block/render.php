<?php
echo '<pre style="background:#eee;padding:10px;">';
print_r( $attributes );
echo '</pre>';

$api_url = get_option( 'custom_blocks_api_url') . get_option( 'featured_topic_endpoint');
$response = wp_remote_get( $api_url );
$data = [];
if ( is_array( $response ) && ! is_wp_error( $response ) ) {
    $body = wp_remote_retrieve_body( $response );
    $data = json_decode( $body, true );
}

$feature_topic_count = isset( $attributes['featuredTopicCount'] ) ? intval( $attributes['featuredTopicCount'] ) : 5;

// 只取前 $feature_topic_count 筆資料
$display_data = array_slice( $data, 0, $feature_topic_count );
?>
<div <?php echo get_block_wrapper_attributes(); ?>>
	<p>五大看點</p>
	<ul>
		<?php foreach ( $display_data as $item ) : ?>
			<li><?php echo esc_html( $item['title'] ); ?></li>
		<?php endforeach; ?>
	</ul>
</div>
