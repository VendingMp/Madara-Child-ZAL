<?php
		 
	add_action( 'wp_enqueue_scripts', 'madara_scripts_styles_child_theme' );
	function madara_scripts_styles_child_theme() {
		wp_enqueue_style( 'madara-css-child', get_parent_theme_file_uri() . '/style.css', array(
			'fontawesome',
			'bootstrap',
			'slick',
			'slick-theme'
		) );
	}
	
	/* Disable VC auto-update */
	add_action( 'admin_init', 'madara_vc_disable_update', 9 );
	function madara_vc_disable_update() {
		if ( function_exists( 'vc_license' ) && function_exists( 'vc_updater' ) && ! vc_license()->isActivated() ) {

			remove_filter( 'upgrader_pre_download', array( vc_updater(), 'preUpgradeFilter' ), 10 );
			remove_filter( 'pre_set_site_transient_update_plugins', array(
				vc_updater()->updateManager(),
				'check_update'
			) );

		}
	}
    
    /**
     * does not support Widgets Block Editor yet
     **/
    function madara_theme_support() {
        remove_theme_support( 'widgets-block-editor' );
    }
    add_action( 'after_setup_theme', 'madara_theme_support' );
	
	add_filter('madara_custom_css', 'madara_child_madara_custom_css');
	function madara_child_madara_custom_css( $css ){
		$css .= '.widget-heading{background:none}';
		
		$madara             = new App\Madara();
		$madara_option_tree = new App\Config\OptionTree();
		
		$front_page_custom_colors = get_post_meta(get_the_ID(), 'custom_colors', true);
		$site_custom_colors          = $madara->getOption('site_custom_colors', 'off');	

		$main_color = '';
		if ($site_custom_colors == 'on' || (is_page() && $front_page_custom_colors == 'on')) {
			if ($front_page_custom_colors == 'off') {		
				$main_color = $madara_option_tree::getOption('main_color', '');
			} else {
				$main_color          = $madara->getOption('main_color', '');
			}
		}
		
		if($main_color){
			$css .= '#main-sidebar .related-heading h5, #main-sidebar .widget-heading h5{color:'. $main_color .'}';	
			$css .= '.c-blog__heading.style-2 .h4, .c-blog__heading.style-2 h4, #manga-content-navs.nav-tabs .nav-link.active{border-bottom-color:'. $main_color . '}';
		}
		
		return $css;
		
	}
