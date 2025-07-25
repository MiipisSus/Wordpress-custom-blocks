<?php
// Post meta 註冊 function
if ( ! function_exists( 'register_custom_blocks_post_meta' ) ) {
    function register_custom_blocks_post_meta() {
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
                )
            );
        }
    }
    add_action( 'init', 'register_custom_blocks_post_meta' );
}
