<?php
/**
 * Timeline Express Advertisment Metabox Template
 *
 * @package Timeline Express
 *
 * @since 1.2
 */

$ad_data       = $field->args['ad_data'];
$addon_title   = $ad_data['title'];
$addon_image   = $ad_data['image'];
$addon_content = ( ! empty( $ad_data['content'] ) ) ? $ad_data['content'] : false;
$addon_url     = $ad_data['url'];

?>

<a href="<?php echo esc_url( $addon_url ); ?>" class="advertisment-link" target="_blank" title="<?php echo esc_attr( $addon_title ); ?>">

	<img src="<?php echo esc_url( $addon_image ); ?>" style="max-width:100%;width:100%;" />

</a>

<?php if ( $addon_content ) { ?>

	<p> <?php echo wp_kses_post( $addon_content ); ?> </p>

<?php } ?>
