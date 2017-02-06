<?php
/**
 * Timeline Express Help & Documentation Metabox template
 *
 * @package Timeline Express
 * @since 1.2
 */

printf(
	'<p>%1$s</p>
	<a href="https://wordpress.org/support/plugin/timeline-express" target="_blank" class="button-secondary">%2$s</a>
	<a href="https://www.wp-timelineexpress.com/documentation/" target="_blank" class="button-secondary">%3$s</a>',
	esc_html( 'If you need help, or run into any issues, you can reach out for support in the WordPress.org support forums. Additionally, please see our documentation for how-tos, frequent issues and code snippets.', 'timeline-express' ),
	esc_html( 'Support Forums', 'timeline-express' ),
	esc_html( 'Documentation', 'timeline-express' )
);
