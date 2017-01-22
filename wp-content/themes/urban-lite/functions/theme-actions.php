<?php
/*------------[ Meta ]-------------*/
if ( ! function_exists( 'czs_meta' ) ) {
	function czs_meta(){
	global $czs_options
?>
<?php if ($czs_options['czs_favicon'] != ''){ ?>	
<link rel="icon" href="<?php echo $czs_options['czs_favicon']['url']; ?>" type="image/x-icon" />
<?php } ?>
<!--iOS/android/handheld specific -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<?php }
}
/*------------[ Copyrights ]-------------*/
if ( ! function_exists( 'czs_copyrights_credit' ) ) {
	function czs_copyrights_credit() { 
	global $czs_options
?> 
<!--start copyrights--> 
<div class="row" id="copyright-note">	
  <div class="copyright-left-text">
    <?php _e('Copyright &copy; ', 'czs'); ?><?php echo date("Y") ?><a href="<?php echo esc_url( home_url( '/' ) ); ?>" title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>" rel="nofollow">&nbsp;<?php bloginfo('name'); ?></a>.
  </div>
  <div class="copyright-text">
    <?php printf( __( 'Theme by %1$s.', 'czs' ), '<a href="'.esc_url("http://mythemes4wp.com").'" rel="designer">MyThemes4WP</a>' ); ?>
  </div>
  <div class="footer-navigation">		
    <?php if ( has_nav_menu( 'footer-menu' ) ) { ?>			
    <?php wp_nav_menu( array( 'theme_location' => 'footer-menu', 'menu_class' => 'menu', 'container' => '' ) ); ?>		
    <?php } else { ?>			
    <ul class="menu">				
      <?php wp_list_pages('title_li='); ?>			
    </ul>		
    <?php } ?>
  </div>
  <div class="top">
    <a href="#top" class="toplink">&nbsp;</a>
  </div>
</div>
<!--end copyrights-->
<?php }
}
?>