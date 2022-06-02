<?php

	/**
	 *  Sub header Navigation bar
	 */

	use App\Madara;

	global $wp_manga_user_actions;

	$header_bottom_border = Madara::getOption( 'header_bottom_border', 'on' );
	$madara_header_style  = apply_filters( 'madara_header_style', Madara::getOption( 'header_style', 1 ) );
	$sticky_menu          = Madara::getOption( 'nav_sticky', 1 );
	$sticky_navgiation    = Madara::getOption('manga_reading_sticky_navigation', 'on');
	$sticky_reading_header = Madara::getOption( 'manga_reading_sticky_header', '' );
    $header_login_buttons = Madara::getOption('header_disable_login_buttons', 'on');
	$is_manga_reading_page = false;
	if( function_exists( 'is_manga_reading_page' ) && is_manga_reading_page() ) {
		$is_manga_reading_page = true;
	}
	
	if ( $is_manga_reading_page && $sticky_reading_header == 'on' ) {
		$sticky_menu = 1;
	}
	
	$wp_manga = madara_get_global_wp_manga();
	
	$user_enabled = ($header_login_buttons == 'on') && ! is_user_logged_in() && get_option( 'users_can_register' );
	$user_manga_logged = is_user_logged_in() && class_exists( 'WP_MANGA' );
	
	?>
	<div class="c-sub-header-nav<?php echo esc_attr( $header_bottom_border == 'on' ? ' with-border ' : '' ); ?> <?php echo esc_attr($sticky_menu == 0 ? 'hide-sticky-menu' : ''); ?>">
		<div class="container <?php echo esc_attr( $madara_header_style == '2' ? 'custom-width' : '' ); ?>">
			<div class="c-sub-nav_wrap">
				<div class="sub-nav_content">
					
					<?php madara_adult_filter_button() ;?>
					
					<?php 
					
					$menu_location = 'primary_menu';

					if ( has_nav_menu( $menu_location ) ) {
						echo '<ul class="sub-nav_list list-inline second-menu">';
						wp_nav_menu( array(
							'theme_location' => $menu_location,
							'container'      => false,
							'items_wrap'     => '%3$s'
						) );
						echo '<i class="mobile-icon icon ion-md-more"></i>';
						echo '</ul>';
					} else { ?>
						<ul class="sub-nav_list list-inline second-menu">
							<li><a href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php esc_html_e( 'Home', 'madara' ) ?></a></li>
						</ul>
					<?php } ?>
				</div>

				<?php if ( $user_enabled ) { ?>
					<div class="c-modal_item">
						<!-- Button trigger modal -->
						<a href="javascript:void(0)" data-toggle="modal" data-target="#form-login" class="btn-active-modal"><?php echo esc_html__( 'Sign in', 'madara' ); ?></a>
						<a href="javascript:void(0)" data-toggle="modal" data-target="#form-sign-up" class="btn-active-modal"><?php echo esc_html__( 'Sign up', 'madara' ); ?></a>
					</div>
				<?php } elseif ( $user_manga_logged ) { ?>
					<div class="c-modal_item">
						<?php
							if(defined('WP_MANGA_VER') && WP_MANGA_VER >= 1.6){
								$wp_manga_user_actions->get_user_section( 50, true);
							} else {
								echo wp_kses_post($wp_manga_user_actions->get_user_section());
							}
						?>
					</div>
				<?php } 
				
				?>
			</div>

			<?php if( function_exists('is_manga_reading_page') && is_manga_reading_page() && $sticky_navgiation == 'on' ){ ?>
				<div class="entry-header">
					<?php $wp_manga->manga_nav( 'footer' ); ?>
				</div>
			<?php } ?>
		</div>
	</div>