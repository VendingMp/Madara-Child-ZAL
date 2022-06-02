<?php if ( has_post_thumbnail() ) { ?>
    <div class="summary_image">
        <a href="<?php echo get_the_permalink(); ?>">
            <?php echo madara_thumbnail( $thumb_size ); ?>
        </a>
		<?php 
		$wp_manga_settings = get_option( 'wp_manga_settings' );
		$user_rate = isset( $wp_manga_settings['user_rating'] ) ? $wp_manga_settings['user_rating'] : 1;
		if($user_rate){
			global $wp_manga_functions;
			$rate        = $wp_manga_functions->get_total_review( $post_id );
			$vote        = $wp_manga_functions->get_total_vote( $post_id );
			?>
			<div class="post-rating">
				<?php 
				$wp_manga_functions->manga_rating_display( $post_id, true );				
				?>
			</div>
		<?php } ?>
		<?php
        $is_oneshot = is_manga_oneshot($post_id);
    
        if(!$is_oneshot){                            
            set_query_var( 'manga_id', $post_id );
            get_template_part('madara-core/single/quick-buttons');
        }
        
        ?>
    </div>
<?php } ?>
<div class="summary_content_wrap">
    <div class="summary_content">
        <div class="post-content">
            <?php get_template_part( 'html/ajax-loading/ball-pulse' ); ?>
            
            <?php do_action('wp-manga-manga-properties', $post_id);?>
            
            <?php do_action('wp-manga-after-manga-properties', $post_id);?>
			</div>
			 <div class="post-status">
			<?php do_action('wp-manga-manga-status', $post_id);?>
			</div>
			<?php } ?>            
        </div>        
</div>
