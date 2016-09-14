<?php
/**
 * Addon Template - Admin Page
 *
 * @package Timeline Express
 * @since 1.2
 */

if ( ! isset( $_GET['page'] ) || ( 'timeline-express-addons' !== $_GET['page'] && 'timeline-express-welcome' !== $_GET['page'] ) ) {
	return;
}
/* Get our RSS items */
$items = $this->get_addons_rss_feed();
?>
<!-- addons page wrap -->
<div id="timeline-express-addons" class="wrap">
	<h1 class="page-title">
		<?php esc_attr_e( 'Timeline Express Add-ons', 'timeline-express' ); ?>
	</h1>
	<p class="intro" style="max-width:800px;">
		<?php esc_attr_e( "Extend the base Timeline Express functionality with our powerful add-ons. We're constantly looking to build out additional add-ons. If you have a great idea for a new add-on, get in contact with us!", 'timeline-express' ); ?>
	</p>
	<?php
	foreach ( $items as $add_on ) {
		$title = $add_on->get_title();
		$pos = strpos( $title, 'timeline-express-addon-' );
		$add_on_slug = str_replace( 'limits', 'limit', str_replace( 'timeline-express-addon-', '', sanitize_title( $title ) ) );
		$plugin_active = is_plugin_active( $add_on_slug . '/' . $add_on_slug . '.php' );
		$disabled_button = ( $plugin_active ) ? 'disabled="disabled";' : '';
		$button_text = ( $plugin_active ) ? __( 'Add-on Installed', 'timeline-express' ) : __( 'Buy Now', 'timeline-express' );
		/* Only query timeline express addons */
		if ( false !== $pos ) {
			$data = wp_strip_all_tags( $add_on->get_content(), true );
			$addon_json = json_decode( stripslashes_deep( $data ), true );
			if ( json_last_error() !== 0 ) {
				echo 'RSS Error : ' . (int) json_last_error();
				exit;
			}
			$button_atts = ( $plugin_active ) ? array(
				'disabled="disabled"',
				'class="button-addon-installed"',
			) : array(
				'target="_blank"',
				'href="' . esc_url( $addon_json['purchase_url'] ) . '"',
			);
			?>
			<!-- Individual add-on containers -->
			<div class="timeline-express-addon-item timeline-express-addon-status-upgrade timeline-express-first; ?>">
				<div class="timeline-express-addon-image"><img src="<?php echo esc_url( $addon_json['thumbnail'][0] ); ?>" /></div>
				<div class="timeline-express-addon-text">
					<h4><?php echo esc_attr( str_replace( 'u2013', '', $addon_json['title'] ) ); ?></h4>
					<p class="desc"><?php echo esc_attr( $addon_json['content'] ); ?></p>
				</div>
				<div class="timeline-express-addon-action">
					<a <?php echo implode( ' ', $button_atts ); ?>>
						<?php echo esc_attr( $button_text ); ?>
					</a>
				</div>
			</div>
			<?php
		}
	}
	?>
	<div style="clear:both"></div>
</div>
