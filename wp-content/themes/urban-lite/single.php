<?php get_header(); ?>
<?php global $czs_options; ?>
<div id="page" class="single">
	<div class="content">
		<!-- Start Article -->
		<article class="article">		
			<?php if ( have_posts() ) while ( have_posts() ) : the_post(); ?>
				<div id="post-<?php the_ID(); ?>" <?php post_class('post'); ?>>
					<div class="single_post" >
					<?php if($czs_options['czs_breadcrumbs'] == '1') { ?>
                <?php czs_breadcrumbs() ?>
          <?php } ?>
						<header>
				          	<!-- Start Title -->
							<h1 class="title single-title"><?php the_title(); ?></h1>
							<!-- End Title -->
							<!-- Start Post Meta -->
							<div class="post-info-single">
    							
                    <div class="icon_profile"></div><div class="meta-desc"><?php _e('Author: ','czs'); ?><?php the_author_posts_link(); ?></div>

                    <div class="icon_clock_alt"></div><div class="meta-desc"><?php the_time('M j, Y'); ?> </div>

                    <div class="icon_folder"></div><div class="meta-desc"><?php _e('in ', 'czs'); ?><?php the_category(', '); ?></div>

                    <div class="icon_comment_alt"></div><div class="meta-desc"><a href="<?php comments_link(); ?>"><?php comments_number( __('No Comments','czs'), __('One Comment','czs'), __('% Comments','czs') ); ?></a> </div>
  
              </div>
              
							<!-- End Post Meta -->
						</header>
						<!-- Start Content -->
						<div class="post-single-content box mark-links">						  
							<?php the_content(); ?>
							<?php wp_link_pages(array('before' => '<div class="pagination">', 'after' => '</div>', 'link_before'  => '<span class="current"><span class="currenttext">', 'link_after' => '</span></span>', 'next_or_number' => 'next_and_number', 'nextpagelink' => __('Next','czs'), 'previouspagelink' => __('Previous','czs'), 'pagelink' => '%','echo' => 1 )); ?>
							<?php if($czs_options['czs_tags'] == '1') { ?>
								<!-- Start Tags -->
								<div class="tagcloud"><?php the_tags('<span class="tagtext">'.__('Tags','czs').':</span>',' ') ?></div>
								<!-- End Tags -->
							<?php } ?>
					
            </div>
						<!-- End Content -->
						<?php if($czs_options['czs_related_posts'] == '1') { ?>	
							<!-- Start Related Posts -->
							<?php $categories = get_the_category($post->ID); if ($categories) { $category_ids = array(); foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id; $args=array( 'category__in' => $category_ids, 'post__not_in' => array($post->ID), 'ignore_sticky_posts' => 1, 'showposts'=>4,'orderby' => 'rand' );
							$my_query = new wp_query( $args ); if( $my_query->have_posts() ) {
								echo '<div class="related-posts"><h3>'.__('Related posts','czs').'</h3><div class="postauthor-top"><ul>';
								$pexcerpt=1; $j = 0; $counter = 0; while( $my_query->have_posts() ) { ++$counter; if($counter == 4) { $postclass = 'last'; $counter = 0; } else { $postclass = ''; } $my_query->the_post();?>
                <li class="<?php echo $postclass; ?> rpexcerpt<?php echo $pexcerpt ?> <?php echo (++$j % 2 == 0) ? 'last' : ''; ?>">
									<a class="relatedthumb" href="<?php the_permalink()?>" rel="bookmark" title="<?php the_title(); ?>">
										<span class="rthumb">
											<?php if ( has_post_thumbnail() ) { ?> 
										<?php the_post_thumbnail('related',array('title' => '')); ?>
								
				          <?php } else { ?>    
									
												<img src="<?php echo get_template_directory_uri(); ?>/images/mediumthumb.png" alt="<?php the_title(); ?>" class="wp-post-image" />
											<?php } ?>
										</span>
										<span>
											<?php echo czs_ShortenText(get_the_title()); ?>
										</span>
									</a>
									<div class="meta">
										<a href="<?php comments_link(); ?>" rel="nofollow"><?php comments_number();?></a> | <?php the_time('M j, Y'); ?>
									</div> <!--end .entry-meta-->
								</li>
								<?php $pexcerpt++;?>
								<?php } echo '</ul></div></div>'; }} wp_reset_query(); ?>
							<!-- End Related Posts -->
						<?php }?>  
						<?php if($czs_options['czs_author_box'] == '1') { ?>
							<!-- Start Author Box -->
							<div class="postauthor-container">
								<div class="postauthor">
									<h5><?php _e('About Author ', 'czs'); ?> <?php the_author_meta( 'nickname' ); ?></h5>
									<?php if(function_exists('get_avatar')) { echo get_avatar( get_the_author_meta('email'), '100' );  } ?>
									<p><?php the_author_meta('description') ?></p>
								</div>
							</div>
							<!-- End Author Box -->
						<?php }?>  
					</div>
				</div>
				<?php comments_template( '', true ); ?>
			<?php endwhile; ?>
		</article>
		<!-- End Article -->
		<!-- Start Sidebar -->
		<?php get_sidebar(); ?>
		<!-- End Sidebar -->
		<?php global $czs_options; ?>
		<?php get_footer(); ?>