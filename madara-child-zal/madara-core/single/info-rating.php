<?php
	/**
	 * The Template for printing out a manga property (Rating) in Manga Detail page
	 *
	 * This template can be overridden by copying it to your-child-theme/madara-core/single/info-rating.php
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

<?php if($vote > 0){?>
<div class="post-content_item">
	<div class="summary-heading">
		<h5><?php echo esc_attr__( 'Rating', 'madara' ); ?></h5>
	</div>	
	<div class="summary-content vote-details" vocab="https://schema.org/" typeof="AggregateRating">
		<span property="itemReviewed" typeof="Book"><span class="rate-title" property="name" title="<?php echo esc_attr(get_the_title($manga_id));?>"><?php echo esc_html(get_the_title($manga_id));?></span></span><?php echo sprintf(wp_kses(__('<span> <span> Average <span property="ratingValue" id="averagerate"> %s</span> / <span property="bestRating">5</span> </span> </span> out of <span property="ratingCount" id="countrate">%s</span>', 'madara'), array('span' => array('rel'=>1,'typeof'=>1,'property'=>1,'id'=>1))), $rate, $vote ? $vote : 0);?>
	</div>	
</div>
<?php } ?>