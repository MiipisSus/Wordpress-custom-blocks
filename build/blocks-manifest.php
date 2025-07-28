<?php
// This file is generated. Do not modify it manually.
return array(
	'featured-topic-block' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/featured-topic-block',
		'version' => '0.1.0',
		'title' => 'Featured Topic Block',
		'category' => 'widgets',
		'icon' => 'smiley',
		'description' => 'Example block scaffolded with Create Block tool.',
		'example' => array(
			
		),
		'supports' => array(
			'html' => false
		),
		'textdomain' => 'featured-topic-block',
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'render' => 'file:./render.php',
		'viewScript' => 'file:./view.js',
		'usesContext' => array(
			'postId',
			'postType'
		),
		'attributes' => array(
			'featuredTopicCount' => array(
				'type' => 'integer',
				'default' => 5,
				'description' => '文章主題'
			)
		)
	)
);
