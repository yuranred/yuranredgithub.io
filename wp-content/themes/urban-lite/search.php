<?php global $czs_options; ?>
<?php get_header(); ?>
<div id="page" class="home-page">
	<div class="content">
		<div class="article">
			<h1 class="postsby">
				<span><?php _e("Search Results for:", "czs"); ?></span> <?php the_search_query(); ?>
			</h1>	
      <?php  $j=0; $i =0; if (have_posts()) : while (have_posts()) : the_post(); ?>	
				<article class="post excerpt" >
           <div class="<?php echo 'pexcerpt'.$i++?> featured-thumbnail <?php echo (++$j % 2 == 0) ? 'last' : ''; ?>">  
              <a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow" >   
      	          <?php  if ( has_post_thumbnail() ) { ?> 
										<?php the_post_thumbnail('post',array('title' => '')); ?>
				          <?php } else { ?> 
                      <img src="<?php echo get_template_directory_uri(); ?>/images/mediumthumb.png" class="attachment-featured wp-post-image" alt="<?php the_title(); ?>">    
									<?php } ?>
				       </a> 
                <div class="post-info-home">
        					  <div class="post-info">
                        <div class="thetime"><?php the_time('j'); ?></div>
                        <div class="thedate"><?php the_time('M Y'); ?></div> 
                    </div>
                </div> 
                <?php if (function_exists('wp_review_show_total')) wp_review_show_total(); ?>  
           </div>              
          <div class="home-content">
          <header>		
						<h2 class="title">
							<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="bookmark"><?php echo czs_ShortenText(get_the_title()); ?></a>     
						</h2>
					</header><!--.header-->
					<div class="post-info-single">
                    <?php if($czs_options['czs_home_meta_info']['a'] == '1') { ?>
                        <div class="icon_profile"></div><div class="meta-desc"><?php the_author_posts_link(); ?></div>
                    <?php } ?>
                    
                    <?php if($czs_options['czs_home_meta_info']['c'] == '1') { ?>
                      <div class="icon_comment_alt"></div><div class="meta-desc"><a href="<?php comments_link(); ?>"><?php comments_number( __('No Comments','czs'), __('One Comment','czs'), __('% Comments','czs') ); ?></a> </div>
                    <?php } ?>
              </div>
					<div class="post-content image-caption-format-1">
						<p>
  						<?php $content = get_the_content();  echo wp_trim_words( $content , '18', $more = '...' ); ?>
  						<a href="<?php the_permalink() ?>" title="<?php the_title(); ?>" rel="nofollow"><?php _e( 'Read More &rarr;', 'czs' ); ?></a> 
						</p>
					</div>   
          </div>
				  </article>
			<?php endwhile; else: ?>
				<div class="no-results">
					<h5><?php _e('No Results found. We apologize for any inconvenience, please hit back on your browser or use the search form below.', 'czs'); ?></h5>
					<?php get_search_form(); ?>
				</div><!--noResults-->
      <?php endif; ?>	
			<!--Start Pagination-->

				<div class="pagination">
					<ul>
						<li class="nav-previous"><?php next_posts_link( __( '&larr; Older posts', 'czs' ) ); ?></li>
						<li class="nav-next"><?php previous_posts_link( __( 'Newer posts &rarr;', 'czs' ) ); ?></li>
					</ul>
				  </div>

			<!--End Pagination-->		
		</div>
		<?php get_sidebar(); ?>
<?php get_footer(); ?>