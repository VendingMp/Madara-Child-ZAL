<?php

	/**
	 * Hook to wrap Main Header div
	 */
	do_action( 'madara_main_header_before', 1 );

?>
    <div id="search-sidebar">
		
		<form class="manga-search-form search-form ajax" id="blog-post-search" action="<?php echo esc_url( home_url( '/' ) ); ?>" method="get">
			<input class="manga-search-field" type="text" placeholder="<?php echo esc_html__( 'Search...', 'madara' ); ?>" name="s" value="">			
			<button type="submit" class="btn-search"><i class="icon ion-ios-search"></i></button>
			<div class="loader-inner line-scale">
				<div></div>
				<div></div>
				<div></div>
				<div></div>
				<div></div>
			</div>
			<input type="hidden" name="post_type" value="wp-manga"> 
		</form>
    </div>
    <div class="c-togle__menu">
        <button type="button" class="menu_icon__open">
            <span></span> <span></span> <span></span>
        </button>
    </div>
<?php

	/**
	 * Hook to wrap Main Header div
	 */
	do_action( 'madara_main_header_after', 1 );
