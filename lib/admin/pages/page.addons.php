<?php
/**
 * Addon Template - Admin Page
 *
 * @package Timeline Express
 * @since 1.2
 */

if ( ! isset( $_GET['page'] ) || 'timeline-express-addons' !== $_GET['page']  ) {
	return;
}
/* Get our RSS items */
$items = $this->get_addons_rss_feed();
?>
<!-- addons page wrap -->
<div id="timeline-express-addons" class="wrap">
	<h1 class="page-title">
		<?php esc_attr_e( 'Addons', 'timeline-express' ); ?>
	</h1>
	<p class="intro">
		<?php esc_attr_e( 'Extend Timeline Express functionality with our powerful add-ons.', 'timeline-express' ); ?>
	</p>
	<?php
	foreach ( $items as $add_on ) {
		$title = $add_on->get_title();
		$pos = strpos( $title, 'timeline-express-addon-' );
		/* Only query timeline express addons */
		if ( false !== $pos ) {
			$title = str_replace( 'timeline-express-addon-', '', $title );
			$data = wp_strip_all_tags( $add_on->get_content(), true );
			$addon_json = json_decode( stripslashes_deep( $data ), true );
			if ( json_last_error() !== 0 ) {
				echo 'RSS Error : ' . (int) json_last_error();
				exit;
			}
			?>
			<!-- Individual add-on containers -->
			<div class="timeline-express-addon-item timeline-express-addon-status-upgrade timeline-express-first; ?>">
				<div class="timeline-express-addon-image"><img src="<?php echo esc_url( $addon_json['thumbnail'][0] ); ?>" /></div>
				<div class="timeline-express-addon-text">
					<h4><?php esc_attr_e( $addon_json['title'] ); ?></h4>
					<p class="desc"><?php echo esc_attr_e( $addon_json['content'] ); ?></p>
				</div>
				<div class="timeline-express-addon-action"><a href="<?php echo esc_url( $addon_json['purchase_url'] ); ?>" target="_blank">Buy Now</a></div>
			</div>
			<?php
		}
	}
	?>
	<div style="clear:both"></div>
</div>
