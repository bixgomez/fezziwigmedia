<?php
// This file is generated. Do not modify it manually.
return array(
	'project-card' => array(
		'$schema' => 'https://schemas.wp.org/trunk/block.json',
		'apiVersion' => 3,
		'name' => 'create-block/project-card',
		'version' => '0.1.0',
		'title' => 'Project Card',
		'category' => 'widgets',
		'icon' => 'portfolio',
		'description' => 'A custom block to showcase a project with image, text, and a link.',
		'keywords' => array(
			'project',
			'portfolio',
			'card',
			'work'
		),
		'textdomain' => 'project-card',
		'attributes' => array(
			'imageUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'title' => array(
				'type' => 'string',
				'default' => ''
			),
			'subtitle' => array(
				'type' => 'string',
				'default' => ''
			),
			'description' => array(
				'type' => 'string',
				'default' => ''
			),
			'linkUrl' => array(
				'type' => 'string',
				'default' => ''
			),
			'linkText' => array(
				'type' => 'string',
				'default' => 'Learn More'
			)
		),
		'supports' => array(
			'html' => false
		),
		'editorScript' => 'file:./index.js',
		'editorStyle' => 'file:./index.css',
		'style' => 'file:./style-index.css',
		'viewScript' => 'file:./view.js'
	)
);
