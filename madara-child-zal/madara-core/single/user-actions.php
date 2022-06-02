<?php

	/**
	 * The Template for printing out several User Action buttions in Manga Detail page
	 *
	 * This template can be overridden by copying it to your-child-theme/madara-core/single/user-actions.php
	 *
	 * HOWEVER, on occasion Madara will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * we will list any important changes on our theme release logs.
	 * @package Madara
	 * @version 1.7.2.2
	 */
	 
	 ?>
<div class="manga-action">
	<?php if($manga_comment){?>
	<div class="count-comment">
		<div class="action_icon">
			<a href="#manga-discussion"><i class="icon ion-md-chatbubbles"></i></a>
		</div>
		<div class="action_detail">
			<?php 
			if(isset($wp_manga_settings['default_comment']) && $wp_manga_settings['default_comment'] == 'disqus'){
				?>
				<span class="disqus-comment-count" data-disqus-url="<?php echo esc_url(get_permalink());?>"><?php esc_html_e('Comments', 'madara');?></span>
				<?php 
			} else {
				$comments_count = wp_count_comments( get_the_ID() ); ?>
				<span><?php 
				
				if(function_exists('wp_manga_number_format_short')){
					printf( _n( '%s comment', '%s comments', wp_manga_number_format_short($comments_count->approved), 'madara' ), wp_manga_number_format_short($comments_count->approved) );
				} else {
					printf(esc_html__('%d comment', 'madara'),  $comments_count);
				}
				?></span>
			<?php } ?>
		</div>
	</div>
	<?php } ?>
	<?php
	
	if($user_bookmark){?>
	<div class="add-bookmark">
		<?php
			$wp_manga_functions->bookmark_link_e();
		?>
	</div>
	<?php } ?>
	<?php do_action( 'madara_single_manga_action' ); ?>
</div>