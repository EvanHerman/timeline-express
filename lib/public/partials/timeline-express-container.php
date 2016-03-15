<?php
/**
 * Timeline Express Container Markup
 *
 * @package Timeline Express
 * @since 1.2
 */

/* Store the global $post object */
global $post;

/* Retreive Timeline Express Options */
$timeline_express_options = timeline_express_get_options();
$custom_icon_html = apply_filters( 'timeline-express-custom-icon-html', '', $post, $timeline_express_options );
?>

<div class="cd-timeline-block">

	<?php
	/* Generate the Custom Icon. */
	if ( ! empty( $custom_icon_html ) ) {
		echo $custom_icon_html;
	} else {
		/* If read more visibility is set to true, wrap the icon in a link. */
		if ( 0 !== $timeline_express_options['read-more-visibility'] ) {
			?>
			<a class="cd-timeline-icon-link" href="<?php esc_attr_e( get_the_permalink( $post->ID ) ); ?>">
				<div class="cd-timeline-img cd-picture" style="background:'<?php esc_attr_e( self::get_announcement_icon_color( $post->ID ) ); ?>;">
				<span class="fa <?php esc_attr_e( self::get_announcement_icon( $post->ID ) ); ?>" title="<?php esc_attr_e( get_the_title( $post->ID ) ); ?>"></span>
				</div> <!-- cd-timeline-img -->
			</a>
			<?php
		} else {
			/* Else, no link around the icon. */
			?>
			<div class="cd-timeline-img cd-picture" style="background:<?php esc_attr_e( self::get_announcement_icon_color( $post->ID ) ); ?>;">';
				<span class="fa <?php esc_attr_e( self::get_announcement_icon( $post->ID ) ); ?>" title="<?php esc_attr_e( get_the_title( $post->ID ) ); ?>"></span>';
			</div>
			<?php
		}
	}
	?>

	<!-- Timeline Content -->
	<div class="cd-timeline-content">

		<!-- Announcement Title -->
		<span class="cd-timeline-title-container">
			<h2 class="cd-timeline-item-title">
				<?php the_title();?>
			</h2>

			<?php
			/* Generate the announcement date. */
			if ( 1 === (int) $timeline_express_options['date-visibility'] ) {
				?>
				<span class="timeline-date">
					<?php self::get_announcement_date( $post->ID ); ?>
				</span>
				<?php
			}
			?>
		</span>

		<?php
		/* Generate the announcement image. */
		esc_attr_e( self::get_announcement_image( $post->ID ) );
		?>

		<span class="the-excerpt">
			<?php
			/* Generate the announcement excerpt. */
			self::get_announcement_excerpt( $timeline_express_options['excerpt-random-length'], $timeline_express_options['excerpt-trim-length'], $timeline_express_options['read-more-visibility'], $post->ID );
			?>
		</span>
		
	</div>
</div>
