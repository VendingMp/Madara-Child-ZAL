<?php

	/**
	 * The Template for single manga (Manga Detail) page
	 *
	 * This template can be overridden by copying it to your-child-theme/single.php
	 *
	 * HOWEVER, on occasion Madara will need to update template files and you
	 * (the theme developer) will need to copy the new files to your theme to
	 * maintain compatibility. We try to do this as little as possible, but it does
	 * happen. When this occurs the version of the template file will be bumped and
	 * we will list any important changes on our theme release logs.
	 * @package Madara
	 * @version 1.7.2.2
	 */

	get_header();

	use App\Madara;

	$wp_manga           = madara_get_global_wp_manga();
	$wp_manga_functions = madara_get_global_wp_manga_functions();
    $thumb_size         = array(250,350);
	$post_id            = get_the_ID();
    
    $is_oneshot = is_manga_oneshot($post_id);
    
    if($is_oneshot){
        get_template_part( '/madara-core/manga', 'oneshot' );
        exit;
    }

	$madara_single_sidebar      = 'right';
	$madara_breadcrumb          = Madara::getOption( 'manga_single_breadcrumb', 'on' );
	
	$manga_profile_background = '';
	$bg_options = Madara::getOption( 'manga_profile_background' );			
	if ( is_array( $bg_options ) ) {
		$bg_options_repeat     = isset( $bg_options['background-repeat'] ) ? $bg_options['background-repeat'] : '';
		$bg_options_attachment = isset( $bg_options['background-attachment'] ) ? $bg_options['background-attachment'] : '';
		$bg_options_position   = isset( $bg_options['background-position'] ) ? $bg_options['background-position'] : '';
		$bg_options_size       = isset( $bg_options['background-size'] ) ? $bg_options['background-size'] : '';
		$bg_options_image      = isset( $bg_options['background-image'] ) ? $bg_options['background-image'] : '';
		$bg_options_color      = isset( $bg_options['background-color'] ) ? $bg_options['background-color'] : '';

		
		if ( ! empty( $bg_options ) ) {

			if ( $bg_options_color != '' ) {
				$manga_profile_background .= 'background-color:' . $bg_options_color . '; ';
			}

			if ( $bg_options_image != '' ) {
				$manga_profile_background .= 'background-image:linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(' . esc_url( $bg_options_image ) . '); ';

				if ( $bg_options_repeat != '' ) {
					$manga_profile_background .= 'background-repeat:' . $bg_options_repeat . '; ';
				}

				if ( $bg_options_attachment != '' ) {
					$manga_profile_background .= 'background-attachment:' . $bg_options_attachment . '; ';
				}

				if ( $bg_options_size != '' ) {
					$manga_profile_background .= 'background-size:' . $bg_options_size . '; ';
				}

				if ( $bg_options_position != '' ) {
					$manga_profile_background .= 'background-position:' . $bg_options_position . '; ';
				}
			}
		}
	}
	
	$manga_single_summary       = Madara::getOption( 'manga_single_summary', 'on' );

	$wp_manga_settings = get_option( 'wp_manga_settings' );
	$related_manga     = isset( $wp_manga_settings['related_manga'] ) ? $wp_manga_settings['related_manga'] : null;
?>


<?php 
do_action( 'before_manga_single' );
 ?>
<div <?php post_class();?>>
<div id="manga-header" style="<?php echo esc_attr( $manga_profile_background != '' ? $manga_profile_background : 'background-image: linear-gradient(
          rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)), url(' . get_the_post_thumbnail_url($post_id, 'full') . ')' ); ?>;background-repeat: no-repeat;   background-position: 50% 35%;    background-size: cover;">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12">
				<div id="manga-title">
					<h1>
						<?php madara_manga_title_badges_html( $post_id, 1 ); ?>
						<?php echo esc_html( get_the_title() ); ?>
					</h1>
				</div>
            </div>
        </div>
    </div>
</div>

<div class="c-page-content style-1">
    <div class="content-area">
        <div class="container">
            <div class="row <?php echo esc_attr( $madara_single_sidebar == 'left' ? 'sidebar-left' : '' ) ?>">
                <div class="main-col <?php echo esc_attr( $madara_single_sidebar !== 'full' && ( is_active_sidebar( 'manga_single_sidebar' ) || is_active_sidebar( 'main_sidebar' ) ) ? ' col-md-8 col-sm-8' : 'col-md-12 col-sm-12 sidebar-hidden' ) ?>">
                    <!-- container & no-sidebar-->
                    <div class="main-col-inner">
                        <div class="c-page">
                            <!-- <div class="c-page__inner"> -->
                            <div class="c-page__content">
								<?php
									if ( $madara_breadcrumb == 'on' ) {
										get_template_part( 'madara-core/manga', 'breadcrumb' );
									}
								?>
								
								<div class="profile-manga">
									<div class="tab-summary <?php echo has_post_thumbnail() ? '' : esc_attr( 'no-thumb' ); ?>">
									  
										<?php 
										
										set_query_var('thumb_size', $thumb_size);
										set_query_var('post_id', $post_id);
										get_template_part( '/madara-core/single/info-summary', $info_summary_layout); ?>
									</div>
								</div>
                 <div class="c-blog__heading style-2 font-heading">
                     <h2 class="h4">
											<?php echo esc_attr__( 'Sinopsis', 'madara' ); ?></h2> </div>
                        <div class="description-summary">
                           <div class="summary__content">
                                  <?php global $post; echo apply_filters('the_content',$post->post_content); ?>
                         </div>
                                </div>
								<div id="manga-chapter-releas" class="c-blog__heading style-2 font-heading">
                <i class="ion-ios-star"></i>
                <h4>LATEST CHAPTER UPDATE</h4></div>
										<?php do_action('wp-manga-chapter-listing', $post_id); ?>
										<?php
									do_action( 'wp_manga_discussion' ); ?>
							
						<?php edit_post_link(esc_html__('Edit This Novel', 'madara'));?>
						
                        <?php

							if ( $related_manga == 1 ) {
								get_template_part( '/madara-core/manga', 'related' );
							}

							if ( class_exists( 'WP_Manga' ) ) {
                                $setting = Madara::getOption('manga_single_tags_post', 'info');
                                if($setting == 'both' || $setting == 'bottom'){
                                    $GLOBALS['wp_manga']->wp_manga_get_tags();
                                }
							}
						?>

                    </div>
                </div>

				<?php
					if ( $madara_single_sidebar != 'full' && ( is_active_sidebar( 'main_sidebar' ) || is_active_sidebar( 'manga_single_sidebar' ) ) ) {
						?>
                        <div class="sidebar-col col-md-4 col-sm-4">
							<?php get_sidebar(); ?>
                        </div>
					<?php }
				?>

            </div>
        </div>
    </div>
</div>

<?php 
do_action( 'after_manga_single' ); ?>
</div>
<?php get_footer();