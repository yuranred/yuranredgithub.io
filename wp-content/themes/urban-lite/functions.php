<?php
/*-----------------------------------------------------------------------------------*/
/*  Do not remove these lines.
/*-----------------------------------------------------------------------------------*/
load_theme_textdomain( 'czs', get_template_directory().'/lang' );
load_theme_textdomain( 'redux-framework', get_template_directory().'/lang' );
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/options/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/options/framework.php' );
}
if ( !isset( $redux_demo ) && file_exists( dirname( __FILE__ ) . '/theme-options.php' ) ) {
    require_once( dirname( __FILE__ ) . '/theme-options.php' );
}

if ( ! isset( $content_width ) ) $content_width = 780;


if ( ! function_exists( 'czs_setup' ) ) :
function czs_setup() {

/*-----------------------------------------------------------------------------------*/
/*  Title tag support
/*-----------------------------------------------------------------------------------*/
// enabling theme support for title tag

add_theme_support( 'title-tag' );
 
// title tag implementation with backward compatibility
if ( ! function_exists( '_wp_render_title_tag' ) ) {
	function czs_render_title() {
?>
<title><?php wp_title( '|', true, 'right' ); ?></title>
<?php
	}
	add_action( 'wp_head', 'czs_render_title' );
}
/*-----------------------------------------------------------------------------------*/
/*  Load Translation 
/*-----------------------------------------------------------------------------------*/
add_theme_support('automatic-feed-links');

/*-----------------------------------------------------------------------------------*/
/*  Post Thumbnail Support
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'post-thumbnails' );
set_post_thumbnail_size( 415, 220, true );
add_image_size( 'post', 415, 220, true ); //Latest posts thumb
add_image_size( 'bigthumb', 831, 392, true ); //Latest posts thumb
add_image_size( 'related', 323, 165, true ); //Latest posts thumb
add_image_size( 'widgetthumb', 60, 57, true ); //widget

/*-----------------------------------------------------------------------------------*/
/*  Custom Menu Support
/*-----------------------------------------------------------------------------------*/
add_theme_support( 'menus' );
if ( function_exists( 'register_nav_menus' ) ) {
    register_nav_menus(
        array(
          'primary-menu' => 'Primary Menu',
		  'footer-menu' => 'Footer Menu'
        )
    );
}

}
endif;
add_action( 'after_setup_theme', 'czs_setup' );


/*-----------------------------------------------------------------------------------*/
/*	Javascsript
/*-----------------------------------------------------------------------------------*/
function czs_add_scripts() {

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
	// Site wide js
	wp_enqueue_script('customscript', get_stylesheet_directory_uri() . '/js/customscript.js',array( 'jquery' ));
  wp_enqueue_script('flexslider', get_stylesheet_directory_uri() . '/js/jquery.flexslider.js',array( 'jquery' ));
}
add_action('wp_enqueue_scripts','czs_add_scripts');


/*-----------------------------------------------------------------------------------*/
/* Enqueue CSS
/*-----------------------------------------------------------------------------------*/
function czs_enqueue_css() {

    global $czs_options;
	
	wp_enqueue_style('stylesheet', get_stylesheet_directory_uri() . '/style.css', 'style');
	wp_enqueue_style('icons', get_stylesheet_directory_uri() . '/css/eleganticon_style.css', 'style');
	wp_enqueue_style('stylesheetflex', get_stylesheet_directory_uri() . '/css/flexslider.css', 'style');
	//Responsive
    if($czs_options['czs_responsive'] == '1') {
        wp_enqueue_style('responsive', get_stylesheet_directory_uri() . '/css/responsive.css', 'style');
    }

	$custom_css = "
	  a {color: #f73838;}
	  .read-more :hover   { background-color: #c41300;}
	  a:hover {color: #c41300;}
	  a:active {color: #ffb73a;}
		input#author:focus, input#email:focus, input#url:focus, #commentform textarea:focus { border-color:#f73838;}
		.top-board, .login-button a, .button, .ei-title h3, .menu .current-menu-item > a:after, .read-more a, .home-cat, #top-content{ background: #f73838;}
		.current-menu-ancestor > a.sf-with-ul, .current-menu-ancestor, .menu > li:hover > a{ color:#f73838; }	
		.menu .current-menu-item > a,.nav-previous a, .nav-next a, .header-button, .sub-menu, #commentform input#submit, .tagcloud a, #tabber ul.tabs li a.selected, .featured-cat, .et-subscribe input[type='submit'], .pagination a, .carousel-title { background-color:#f73838; color: #fff; }          
    .secondary-navigation {  background: #ffffff; }
    .no-results, #tabber, .copyrights, .postsby, .postauthor, #respond h3, #commentform, .total-comments, .commentmetadata, .post.excerpt, .flex-caption, .single_post, .ss-full-width, #content_box {  background-color: #474747;}
    .header-logo { background: #f73838; filter: brightness(0.97); -webkit-filter: brightness(0.97); -moz-filter: brightness(0.97); -o-filter: brightness(0.97); -ms-filter: brightness(0.97);}
    .widget, #login .inside {background-color: #474747;}
			";
	wp_add_inline_style( 'stylesheet', $custom_css );
}
add_action('wp_enqueue_scripts', 'czs_enqueue_css', 99);


/*-----------------------------------------------------------------------------------*/
/*  Enable Widgetized sidebar
/*-----------------------------------------------------------------------------------*/
function czs_widgets_init() {
	register_sidebar(array(
		'name'=>'Sidebar',
		'description'   => __( 'Appears on posts and pages', 'czs' ),
		'before_widget' => '<div id="%1$s" class="widget widget-sidebar %2$s">',
		'id' => 'sidebar-1',
    'after_widget' => '</div>',
		'before_title' => '<h3>',
		'after_title' => '</h3>',
	));
		$sidebars = array(1, 2, 3, 4);
	foreach($sidebars as $number) {
	register_sidebar(array(
		'name' => 'Footer ' . $number,
		'id' => 'footer-' . $number,
		'before_widget' => '<div id="%1$s" class="widget widget-sidebar %2$s">',
		'after_widget' => '</div>',
		'before_title' => '<div class="widget-home"><h3 class="widget-title">',
		'after_title' => '</h3></div>',
	));
	}
}
add_action( 'widgets_init', 'czs_widgets_init' );
/*-----------------------------------------------------------------------------------*/
/* Footer widgets
/*-----------------------------------------------------------------------------------*/
function widgetized_footer() {
?>
	<div class="f-widget f-widget-1">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 1') ) : ?>
		<?php endif; ?>
	</div>
	<div class="f-widget f-widget-2">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 2') ) : ?>
		<?php endif; ?>
	</div>
	<div class="f-widget f-widget-3">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 3') ) : ?>
		<?php endif; ?>
	</div>
	<div class="f-widget last">
		<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar('Footer 4') ) : ?>
		<?php endif; ?>
	</div>
<?php
} 

/*-----------------------------------------------------------------------------------*/
/*  Load Widgets & Shortcodes
/*-----------------------------------------------------------------------------------*/
// Add the 125x125 Ad Block Custom Widget
include("functions/widget-ad125.php");

// Add the 300x250 Ad Block Custom Widget
include("functions/widget-ad300.php");

// Add the Tabbed Custom Widget
include("functions/widget-tabs.php");

// Add Subscribe Widget
include("functions/widget-subscribe.php");

// Theme Functions
include("functions/theme-actions.php");

// Theme Comments with Avatar
include("functions/widget-comments-avatar.php");



/*-----------------------------------------------------------------------------------*/
/*	Custom Gravatar Support
/*-----------------------------------------------------------------------------------*/
if( !function_exists( 'czs_custom_gravatar' ) ) {
    function czs_custom_gravatar( $avatar_defaults ) {
        $czs_avatar = get_template_directory_uri() . '/images/gravatar.png';
        $avatar_defaults[$czs_avatar] = 'Custom Gravatar (/images/gravatar.png)';
        return $avatar_defaults;
    }
    add_filter( 'avatar_defaults', 'czs_custom_gravatar' );
}

/*-----------------------------------------------------------------------------------*/
/*	Custom Comments template
/*-----------------------------------------------------------------------------------*/
function czs_comment($comment, $args, $depth) {
	$GLOBALS['comment'] = $comment; 
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
		<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'czs' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'czs' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID() ?>">
		<div id="comment-<?php comment_ID(); ?>" style="position:relative;">
			<div class="comment-author vcard">
				<?php echo get_avatar( $comment->comment_author_email, 70 ); ?>
				<div class="comment-metadata">
				<?php printf(__('<span class="fn">%s</span>', 'czs'), get_comment_author_link()) ?>
				<div class="time"><?php comment_date(get_option( 'date_format' )); ?></div>
				<span class="comment-meta">
					<?php edit_comment_link(__('(Edit)', 'czs'),'  ','') ?>
				</span>
				<span class="reply">
					<?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
				</span>
				</div>
			</div>
			<?php if ($comment->comment_approved == '0') : ?>
				<em><?php _e('Your comment is awaiting moderation.', 'czs') ?></em>
				<br />
			<?php endif; ?>
			<div class="commentmetadata">
				<?php comment_text() ?>
			</div>
		</div>
	
<?php 	break;
	endswitch; } 
/*-----------------------------------------------------------------------------------*/
/*	Short Post Title
/*-----------------------------------------------------------------------------------*/
function czs_ShortenText($text) { // Function name czs_ShortenText
  global $czs_options;
  $chars_limit = $czs_options['czs_home_title']; // Character length
  $chars_text = strlen($text);
  $text = $text." ";
  $text = substr($text,0,$chars_limit);
  $text = substr($text,0,strrpos($text,' '));

  if ($chars_text > $chars_limit)
     { $text = $text."..."; } // Ellipsis
     return $text;
}

/*-----------------------------------------------------------------------------------*/
/* Most commented posts 
/*-----------------------------------------------------------------------------------*/
function czs_most_commented($comment_posts = 5 , $avatar_size = 60){
$comments = get_comments('status=approve&number='.$comment_posts);
foreach ($comments as $comment) { ?>
<li class="recent-comments">	
		<div class="featured-thumbnail">
			<?php echo get_avatar( $comment, $avatar_size ); ?>
		</div>
	 <div class="info">
		  <?php echo strip_tags($comment->comment_author); ?>: <a href="<?php echo get_permalink($comment->comment_post_ID ); ?>#comment-<?php echo $comment->comment_ID; ?>"><?php echo wp_html_excerpt( $comment->comment_content, 60 ); ?>... </a>
	 </div>

</li>
<?php } 
}
/*-----------------------------------------------------------------------------------*/
/*	Short Post Title
/*-----------------------------------------------------------------------------------*/
function czs_short_title($after = '', $length){
	$mytitle = get_the_title();
	if ( strlen($mytitle) > $length ){
		$mytitle = substr($mytitle,0,$length);
		echo $mytitle . $after; 
	}
	else { echo $mytitle; }
}

/*-----------------------------------------------------------------------------------*/
/* nofollow to next/previous links
/*-----------------------------------------------------------------------------------*/
function czs_pagination_add_nofollow($content) {
    return 'rel="nofollow"';
}
add_filter('next_posts_link_attributes', 'czs_pagination_add_nofollow' );
add_filter('previous_posts_link_attributes', 'czs_pagination_add_nofollow' );

/*-----------------------------------------------------------------------------------*/ 
/* nofollow to reply links
/*-----------------------------------------------------------------------------------*/
function czs_add_nofollow_to_reply_link( $link ) {
return str_replace( '")\'>', '")\' rel=\'nofollow\'>', $link );
}
add_filter( 'comment_reply_link', 'czs_add_nofollow_to_reply_link' );


/*-----------------------------------------------------------------------------------*/
/* Single Post Pagination
/*-----------------------------------------------------------------------------------*/
function czs_wp_link_pages_args_prevnext_add($args)
{
    global $page, $numpages, $more, $pagenow;
    if (!$args['next_or_number'] == 'next_and_number')
        return $args; 
    $args['next_or_number'] = 'number'; 
    if (!$more)
        return $args; 
    if($page-1) 
        $args['before'] .= _wp_link_page($page-1)
        . $args['link_before']. $args['previouspagelink'] . $args['link_after'] . '</a>'
    ;
    if ($page<$numpages) 
    
        $args['after'] = _wp_link_page($page+1)
        . $args['link_before'] . $args['nextpagelink'] . $args['link_after'] . '</a>'
        . $args['after']
    ;
    return $args;
}
add_filter('wp_link_pages_args', 'czs_wp_link_pages_args_prevnext_add');

/*-----------------------------------------------------------------------------------*/
/* Breadcrumbs
/*-----------------------------------------------------------------------------------*/
function czs_breadcrumbs(){
  /* === OPTIONS === */
	$text['home']     = __('Home','czs'); // text for the 'Home' link  
	$text['category'] = __('Archive by Category "%s"','czs'); // text for a category page
	$text['tax'] 	  = __('Archive for "%s"','czs'); // text for a taxonomy page
	$text['search']   = __('Search Results for "%s" Query','czs'); // text for a search results page
	$text['tag']      = __('Posts Tagged "%s"','czs'); // text for a tag page
	$text['author']   = __('Articles Posted by %s','czs'); // text for an author page
	$text['404']      = __('Error 404','czs'); // text for the 404 page

	$showCurrent = 1; // 1 - show current post/page title in breadcrumbs, 0 - don't show
	$showOnHome  = 0; // 1 - show breadcrumbs on the homepage, 0 - don't show
	$delimiter   = ' &raquo; '; // delimiter between crumbs
	$before      = '<span class="current">'; // tag before the current crumb
	$after       = '</span>'; // tag after the current crumb
	/* === END OF OPTIONS === */

	global $post;
	$homeLink = esc_url( home_url() )  . '/';
	$linkBefore = '<span typeof="v:Breadcrumb">';
	$linkAfter = '</span>';
	$linkAttr = ' rel="v:url" property="v:title"';
	$link = $linkBefore . '<a' . $linkAttr . ' href="%1$s">%2$s</a>' . $linkAfter;

	if (is_home() || is_front_page()) {

		if ($showOnHome == 1) echo '<div id="crumbs"><a href="' . $homeLink . '">' . $text['home'] . '</a></div>';

	} else {

		echo '<div id="crumbs" >' . sprintf($link, $homeLink, $text['home']) . $delimiter;

		
		if ( is_category() ) {
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['category'], single_cat_title('', false)) . $after;

		} elseif( is_tax() ){
			$thisCat = get_category(get_query_var('cat'), false);
			if ($thisCat->parent != 0) {
				$cats = get_category_parents($thisCat->parent, TRUE, $delimiter);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
			}
			echo $before . sprintf($text['tax'], single_cat_title('', false)) . $after;
		
		}elseif ( is_search() ) {
			echo $before . sprintf($text['search'], get_search_query()) . $after;

		} elseif ( is_day() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo sprintf($link, get_month_link(get_the_time('Y'),get_the_time('m')), get_the_time('F')) . $delimiter;
			echo $before . get_the_time('d') . $after;

		} elseif ( is_month() ) {
			echo sprintf($link, get_year_link(get_the_time('Y')), get_the_time('Y')) . $delimiter;
			echo $before . get_the_time('F') . $after;

		} elseif ( is_year() ) {
			echo $before . get_the_time('Y') . $after;

		} elseif ( is_single() && !is_attachment() ) {
			if ( get_post_type() != 'post' ) {
				$post_type = get_post_type_object(get_post_type());
				$slug = $post_type->rewrite;
				printf($link, $homeLink . '/' . $slug['slug'] . '/', $post_type->labels->singular_name);
				if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;
			} else {
				$cat = get_the_category(); $cat = $cat[0];
				$cats = get_category_parents($cat, TRUE, $delimiter);
				if ($showCurrent == 0) $cats = preg_replace("#^(.+)$delimiter$#", "$1", $cats);
				$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
				$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
				echo $cats;
				if ($showCurrent == 1) echo $before . get_the_title() . $after;
			}

		} elseif ( !is_single() && !is_page() && get_post_type() != 'post' && !is_404() ) {
			$post_type = get_post_type_object(get_post_type());
			echo $before . $post_type->labels->singular_name . $after;

		} elseif ( is_attachment() ) {
			$parent = get_post($post->post_parent);
			$cat = get_the_category($parent->ID); $cat = $cat[0];
			$cats = get_category_parents($cat, TRUE, $delimiter);
			$cats = str_replace('<a', $linkBefore . '<a' . $linkAttr, $cats);
			$cats = str_replace('</a>', '</a>' . $linkAfter, $cats);
			echo $cats;
			printf($link, get_permalink($parent), $parent->post_title);
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_page() && !$post->post_parent ) {
			if ($showCurrent == 1) echo $before . get_the_title() . $after;

		} elseif ( is_page() && $post->post_parent ) {
			$parent_id  = $post->post_parent;
			$breadcrumbs = array();
			while ($parent_id) {
				$page = get_page($parent_id);
				$breadcrumbs[] = sprintf($link, get_permalink($page->ID), get_the_title($page->ID));
				$parent_id  = $page->post_parent;
			}
			$breadcrumbs = array_reverse($breadcrumbs);
			for ($i = 0; $i < count($breadcrumbs); $i++) {
				echo $breadcrumbs[$i];
				if ($i != count($breadcrumbs)-1) echo $delimiter;
			}
			if ($showCurrent == 1) echo $delimiter . $before . get_the_title() . $after;

		} elseif ( is_tag() ) {
			echo $before . sprintf($text['tag'], single_tag_title('', false)) . $after;

		} elseif ( is_author() ) {
	 		global $author;
			$userdata = get_userdata($author);
			echo $before . sprintf($text['author'], $userdata->display_name) . $after;

		} elseif ( is_404() ) {
			echo $before . $text['404'] . $after;
		}

		if ( get_query_var('paged') ) {
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ' (';
			echo __('Page','czs') . ' ' . get_query_var('paged');
			if ( is_category() || is_day() || is_month() || is_year() || is_search() || is_tag() || is_author() ) echo ')';
		}

		echo '</div>';

	}
}
?>