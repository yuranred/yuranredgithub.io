<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 * Please read them CAREFULLY.
 *
 * You also should read the changelog to know what has been changed before updating.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */

/********************* META BOX DEFINITIONS ***********************/

/**
 * Prefix of meta keys (optional)
 * Use underscore (_) at the beginning to make keys hidden
 * Alt.: You also can make prefix empty to disable it
 */
// Better has an underscore as last sign
$prefix = 'czs_mb_';

global $meta_boxes;

$meta_boxes = array();


/*-----------------------------------------------------------------------------------*/
/* GENERAL POST SETTINGS
/*-----------------------------------------------------------------------------------*/
$meta_boxes[] = array(
	'id'		=> 'ct_post_settings',
	'title'		=> __('General post options', 'czs'),
	'pages'		=> array( 'post' ),
	'context'	=> 'normal', // Where the meta box appear: normal (default), advanced, side. Optional.
	'priority'	=> 'high',
	'fields'	=> array(
	 	array(
			'name'		=> __('Show author', 'czs'),
			'desc'		=> __('Show or hide author', 'czs'),
			'id'		=> "{$prefix}show_author",
			'type'		=> 'checkbox',
			'std'		=> 1,
		),
		array(
			'name'		=> __('Show date', 'czs'),
			'desc'		=> __('Show or hide date', 'czs'),
			'id'		=> "{$prefix}show_date",
			'type'		=> 'checkbox',
			'std'		=> 1,
		),
		array(
			'name'		=> __('Show comments', 'czs'),
			'desc'		=> __('Show or hide comments', 'czs'),
			'id'		=> "{$prefix}show_comments",
			'type'		=> 'checkbox',
			'std'		=> 1,
		),
		array(
			'name'		=> __('Show categories', 'czs'),
			'desc'		=> __('Show or hide categories', 'czs'),
			'id'		=> "{$prefix}show_category",
			'type'		=> 'checkbox',
			'std'		=> 1,
		),
		array(
			'name'		=> __('Show views', 'czs'),
			'desc'		=> __('Show or hide views', 'czs'),
			'id'		=> "{$prefix}show_views",
			'type'		=> 'checkbox',
			'std'		=> 1,
		),
		array(
			'name'		=> __('Show Thumbnail/Video', 'czs'),
			'desc'		=> __('This option show or hide Thumbnail/Video above title.', 'czs'),
			'id'		=> "{$prefix}show_thumb",
			'type'		=> 'checkbox',
			'std'		=> 1,
		),
  )
);


// Metabox for Post Format: Gallery
$meta_boxes[] = array(
	'title'		=> __('Video Settings', 'czs'),
	'id'		=> 'ct_video_format',
	'fields'	=> array(
		array(
			'name'     => __('Video Type', 'czs'),
			'id'       => "{$prefix}post_video_type",
			'type'     => 'select',
			'std'		=> __('Select Type', 'czs'),
			'options'  => array(
				'vimeo' => 'Vimeo',
				'youtube' => 'Youtube',
			),
			'multiple' => false,
		),
		array(
			'name'  => __('Video ID', 'czs'),
			'id'    => "{$prefix}post_video_file",
			'desc'  => __('Add Video ID (example: 5ESHJKat6ds)', 'czs'),
			'type'  => 'text',
			'std'   => '',
			'clone' => false,
		),
	)
);

/********************* META BOX REGISTERING ***********************/

/**
 * Register meta boxes
 *
 * @return void
 */
function ct_register_meta_boxes()
{
	// Make sure there's no errors when the plugin is deactivated or during upgrade
	if ( !class_exists( 'RW_Meta_Box' ) )
		return;

	global $meta_boxes;
	foreach ( $meta_boxes as $meta_box )
	{
		new RW_Meta_Box( $meta_box );
	}
}
// Hook to 'admin_init' to make sure the meta box class is loaded before
// (in case using the meta box class in another plugin)
// This is also helpful for some conditionals like checking page template, categories, etc.
add_action( 'admin_init', 'ct_register_meta_boxes' );