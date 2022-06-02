<?php
use App\Madara;
$manga_single_chapters_list = Madara::getOption( 'manga_single_chapters_list', 'on' );
$chapters_list_cols = Madara::getOption( 'manga_single_chapters_list_cols', 1 );
$chapters_order             = Madara::getOption( 'manga_chapters_order', '*_desc' );
$user_id = get_current_user_id();

global $wp_manga_storage, $wp_manga_user_actions;
?>
<div class="page-content-listing single-page">
	<a href="#" title="<?php echo esc_attr__('Change Order', 'madara');?>" class="btn-reverse-order"><?php echo esc_html__('Reverse Order', 'madara');?> <i class="icon ion-md-swap"></i></a>
	<div class="listing-chapters_wrap cols-<?php echo esc_attr($chapters_list_cols);?>  <?php echo( esc_attr($manga_single_chapters_list == 'on' ? 'show-more' : '' )); ?>">

		<?php if ( $manga ) : ?>

			<?php do_action( 'madara_before_chapter_listing' );

            $single = isset( $manga['0']['chapters'] ) ? $manga['0']['chapters'] : null;
					
            ?>

			<ul class="main version-chap <?php echo ($single ? 'no-volumn':'volumns');?>">
				<?php					
					// ONE VOLUMN/NO VOLUMN

					if ( $single ) { ?>

						<?php 
						$style     = $wp_manga_functions->get_reading_style();
                        $unread_chapters = $wp_manga_user_actions->get_unread_chapters($user_id, $manga_id);
                                                                    
						foreach ( $single as $chapter ) {
							$link      = $wp_manga_functions->build_chapter_url( $manga_id, $chapter, $style );
							$time_diff = $wp_manga_functions->get_time_diff( $chapter['date'] );
							$time_diff = apply_filters( 'madara_archive_chapter_date', '<i>' . $time_diff . '</i>', $chapter['chapter_id'], $chapter['date'], $link );

							?>

							<li class="wp-manga-chapter <?php echo esc_attr($current_read_chapter == $chapter['chapter_id'] ? 'reading':'');?> <?php echo apply_filters('wp_manga_chapter_item_class','', $chapter, $manga_id);?>  <?php if(in_array($chapter['chapter_id'], $unread_chapters)) echo 'unread';?>">
								<?php do_action('wp_manga_before_chapter_name',$chapter, $manga_id);?>
								
								<a href="<?php echo esc_url( $link ); ?>">
									<?php echo isset( $chapter['chapter_name'] ) ? wp_kses_post( $chapter['chapter_name'] . $wp_manga_functions->filter_extend_name( $chapter['chapter_name_extend'] ) ) : ''; ?>
								</a>

								<?php if ( $time_diff ) { ?>
									<span class="chapter-release-date">
										<?php echo wp_kses_post( $time_diff ); ?>
									</span>
								<?php } ?>
								
								<?php do_action('wp_manga_after_chapter_name',$chapter, $manga_id);?>

							</li>
							<?php 
							if($current_read_chapter == $chapter['chapter_id']){
							?>
							<li class="chapter-bookmark">
								<div class="chapter-bookmark-content">
								<?php do_action('wp_manga_chapter_bookmark_content', $manga_id, $chapter);?>
								</div>
							</li>
							<?php
							}?>

						<?php } //endforeach ?>

						<?php unset( $manga['0'] );
					}//endif;
				?>

				<?php
				
					// with VOLUMNS

					if ( ! empty( $manga ) ) {

						if ( strpos($chapters_order, '_desc') !== false ) {
							$manga = array_reverse( $manga );
						}
						
						$style = $wp_manga_functions->get_reading_style();

						foreach ( $manga as $vol_id => $vol ) {

							$chapters = isset( $vol['chapters'] ) ? $vol['chapters'] : null;

							$chapters_parent_class = $chapters ? 'parent has-child' : 'parent no-child';
							$chapters_child_class  = $chapters ? 'has-child' : 'no-child';
							$first_volume_class    = isset( $first_volume ) ? '' : ' active';
							?>

							<li class="<?php echo esc_attr( $chapters_parent_class . ' ' . $first_volume_class ); ?>">

								<?php echo isset( $vol['volume_name'] ) ? '<a href="javascript:void(0)" class="' . $chapters_child_class . '">' . $vol['volume_name'] . '</a>' : ''; ?>
								<?php

									if ( $chapters ) { ?>
										<ul class="sub-chap list-chap" <?php echo isset( $first_volume ) ? '' : ' style="display: block;"'; ?> >
                                            <li>
                                                <ul class="sub-chap-list">
											<?php 
                                            
                                            // check if there are "unread chapters"
                                            $unread_chapters = $wp_manga_user_actions->get_unread_chapters($user_id, $manga_id);
                                            
											foreach ( $chapters as $chapter ) {
												
												$chapter['volume_slug'] = $wp_manga_storage->slugify( $vol['volume_name'] );
												$link          = $wp_manga_functions->build_chapter_url( $manga_id, $chapter, $style );
												$c_extend_name = madara_get_global_wp_manga_functions()->filter_extend_name( $chapter['chapter_name_extend'] );
												$time_diff     = $wp_manga_functions->get_time_diff( $chapter['date'] );
												$time_diff     = apply_filters( 'madara_archive_chapter_date', '<i>' . $time_diff . '</i>', $chapter['chapter_id'], $chapter['date'], $link );

												?>

												<li class="wp-manga-chapter <?php echo apply_filters('wp_manga_chapter_item_class','', $chapter, $manga_id);?> <?php if(in_array($chapter['chapter_id'], $unread_chapters)) echo 'unread';?>">
													<?php do_action('wp_manga_before_chapter_name',$chapter, $manga_id);?>
													<a href="<?php echo esc_url( $link ); ?>">
														<?php echo wp_kses_post( $chapter['chapter_name'] . $c_extend_name ) ?>
													</a>

													<?php if ( $time_diff ) { ?>
														<span class="chapter-release-date">
															<?php echo wp_kses_post( $time_diff ); ?>
														</span>
													<?php } ?>
													
													<?php do_action('wp_manga_after_chapter_name',$chapter, $manga_id);?>

												</li>

											<?php } ?>
                                                </ul>
                                            </li>
										</ul>
									<?php } else { ?>

										<span class="no-chapter"><?php echo esc_html__( 'There is no chapters', 'madara' ); ?></span>
									<?php } ?>
							</li>
							<?php $first_volume = false; ?>

						<?php } //endforeach; ?>

					<?php } //endif-empty( $volume);
				?>
			</ul>

			<?php do_action( 'madara_after_chapter_listing' ) ?>

		<?php else : ?>

			<?php echo esc_html__( 'Manga has no chapter yet.', 'madara' ); ?>

		<?php endif; ?>

		<?php if ( $manga_single_chapters_list == 'on' ) { ?>
			<div class="c-chapter-readmore">
				<span class="btn btn-link chapter-readmore">
					<?php echo esc_html__( 'Show more ', 'madara' ); ?>
				</span>
			</div>
		<?php } ?>

	</div>
</div>