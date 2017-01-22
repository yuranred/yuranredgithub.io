<aside class="sidebar c-4-12">
	<div id="sidebars" class="sidebar">
			<div class="sidebar_list">
				<?php if ( ! dynamic_sidebar( 'Sidebar' )) : ?>
					<div id="sidebar-search" class="widget">
						<div class="widget-home"><h3 class="widget-title"><?php _e('Search', 'czs'); ?></h3></div>
						<div class="widget-wrap">
							<?php get_search_form(); ?>
						</div>
					</div>
					<div id="sidebar-archives" class="widget">
						<div class="widget-home"><h3 class="widget-title"><?php _e('Archives', 'czs') ?></h3></div>
						<div class="widget-wrap">
							<ul>
								<?php wp_get_archives( 'type=monthly' ); ?>
							</ul>
						</div>
					</div>
					<div id="sidebar-meta" class="widget">
						<div class="widget-home"><h3 class="widget-title"><?php _e('Meta', 'czs') ?></h3> </div>
						<div class="widget-wrap">
							<ul>
								<?php wp_register(); ?>
								<li><?php wp_loginout(); ?></li>
								<?php wp_meta(); ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>
			</div>
	</div><!--sidebars-->
</aside>