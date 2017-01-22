<!DOCTYPE html>
<?php global $czs_options; ?>
<html class="no-js" <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo('charset'); ?>">
	<!-- Always force latest IE rendering engine (even in intranet) & Chrome Frame -->
	<!--[if IE ]>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<![endif]-->
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<?php czs_meta(); ?>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" /> 
	<?php wp_head(); ?>
</head>
<body id ="blog" <?php body_class('main'); ?>>

		<header class="main-header">
			<div id="header">
			 	<div class="secondary-navigation">
					<div class="top-board">
             <div class="top-board-main">
                <div class="top-board-main">
                  <div class="top-right">
            			     <form method="get" id="top-searchform" action="<?php echo home_url(); ?>" >
                          <div>
                            <input type="text" size="120" name="s" id="stop" value="<?php _e('Search the site','czs'); ?>" onfocus="if(this.value==this.defaultValue)this.value='';" onblur="if(this.value=='')this.value=this.defaultValue;"/>
                          </div>
                        </form> 
            			  </div>
            			     <div class="top-right-share">
            			     <?php if ($czs_options['czs_facebook_url'] != '') { ?>
            			       <a href="<?php echo esc_url($czs_options['czs_facebook_url']); ?>"> <span class="share-info social_facebook_square"></span> </a>
                       <?php } ?> 
                       <?php if ($czs_options['czs_twitter_url'] != '') { ?>
            			       <a href="<?php echo esc_url($czs_options['czs_twitter_url']); ?>"> <span class="share-info social_twitter_square"></span> </a>
                       <?php } ?>
                       <?php if ($czs_options['czs_pinterest_url'] != '') { ?>
            			       <a href="<?php echo esc_url($czs_options['czs_pinterest_url']); ?>"> <span class="share-info social_pinterest_square"></span> </a>
                       <?php } ?>
                       <?php if ($czs_options['czs_gplus_url'] != '') { ?>
            			       <a href="<?php echo esc_url($czs_options['czs_gplus_url']); ?>"> <span class="share-info social_googleplus_square"></span> </a>
                       <?php } ?>
                       <?php if ($czs_options['czs_rss_url'] != '') { ?>
            			       <a href="<?php echo esc_url($czs_options['czs_rss_url']); ?>"> <span class="share-info social_rss_square"></span> </a>
                       <?php } ?>
                       <?php if ($czs_options['czs_linkedin_url'] != '') { ?>
            			       <a href="<?php echo esc_url($czs_options['czs_linkedin_url']); ?>"> <span class="share-info social_linkedin_square"></span> </a>
                       <?php } ?>
                       <?php if ($czs_options['czs_flickr_url'] != '') { ?>
            			       <a href="<?php echo esc_url($czs_options['czs_flickr_url']); ?>"> <span class="share-info social_flickr_square"></span> </a>
                       <?php } ?>
            			     </div>
                 </div>
             </div>
          </div>
          <nav id="navigation" >
						<?php if ( has_nav_menu( 'primary-menu' ) ) { ?>
							<?php  wp_nav_menu( array( 'theme_location' => 'primary-menu', 'menu_class' => 'menu', 'container' => '' ) ); ?>
						<?php } else { ?>
							<ul class="menu">
								<?php wp_list_categories('title_li='); ?>
							</ul>
						<?php } ?>
						<a href="#" id="pull"><?php _e('Menu','czs'); ?></a>
					</nav>
				</div>
			</div>	
			</header>
				<div class="main-container">
				<div class="header-logo">
					<?php if( is_front_page() || is_home() || is_404() ) { ?>
						<h1 id="logo" class="text-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<h2 class="description" ><?php bloginfo('description'); ?></h2>
					<?php } else { ?>
						<div id="logo" class="text-logo"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></div>
						<div class="description" ><?php bloginfo('description'); ?></div>
					<?php } ?>
       </div>
	
		