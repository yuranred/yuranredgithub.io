<?php
 

if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
die ('Please do not load this page directly. Thanks!');
 
if ( post_password_required() ) { ?>
	<p class="nocomments"><?php _e('This post is password protected. Enter the password to view comments','czs'); ?>.</p>
<?php return; } ?>
<!-- You can start editing here. -->
<?php if ( have_comments() ) : ?>
	<div id="comments">
		<div class="total-comments"><?php comments_number(__('No Comments','czs'), __('One Comment','czs'),  __('% Comments','czs') );?></div>
		<ol class="commentlist">
			<li class="navigation">
				<div class="alignleft"><?php previous_comments_link() ?></div>
				<div class="alignright"><?php next_comments_link() ?></div>
			</li>
			<?php wp_list_comments( array( 'callback' => 'czs_comment' ) ); ?>
			<li class="navigation bottomnav">
				<div class="alignleft"><?php previous_comments_link() ?></div>
				<div class="alignright"><?php next_comments_link() ?></div>
			</li>
		</ol>
	</div>
<?php else : // this is displayed if there are no comments so far ?>
	<?php if ('open' == $post->comment_status) : ?>
		<!-- If comments are open, but there are no comments. -->
	<?php else : // comments are closed ?>
		<!-- If comments are closed. -->
		<p class="nocomments"></p>
	<?php endif; ?>
<?php endif; ?>
<?php if ('open' == $post->comment_status) : ?>
	<div class="bordersperator2"></div>
	<div id="commentsAdd">
		<div class="box m-t-6">
			<?php global $aria_req; $comments_args = array(
				'title_reply'=>'<span>'.__('Add a Comment','czs').'</span>',
				'comment_notes_after' => '',
				'label_submit' => __('Add a Comment','czs'),
				'comment_field' => '<p class="comment-form-comment"><label for="comment">'.__('Comment:','czs').'<span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="5" aria-required="true"></textarea></p>',
				'fields' => apply_filters( 'comment_form_default_fields',
					array(
					'author' => '<p class="comment-form-author">' 
						. '<label for="author">' . __( 'Name', 'czs' ) . ':<span class="required">*</span></label>' 
						. ( $req ? '' : '' ) . '<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></p>',
						
					'email' => '<p class="comment-form-email"><label for="email">' . __( 'Email Address', 'czs' ) . ':<span class="required">*</span></label>' 
						. ( $req ? '' : '' ) . '<input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></p>',
						
					'url' => '<p class="comment-form-url"><label for="url">' . __( 'Website', 'czs' ) . ':</label>' . 
			'<input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></p>' 
			))
			); 
			comment_form($comments_args); ?>
		</div>
	</div>
<?php endif; ?>