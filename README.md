# Timeline Express - 1.6.0

[![Built with Grunt](https://cdn.gruntjs.com/builtwith.svg)](http://gruntjs.com)
[![Build Status](https://travis-ci.org/EvanHerman/timeline-express.svg?branch=master)](https://travis-ci.org/EvanHerman/timeline-express)
[![Code Climate](https://codeclimate.com/github/EvanHerman/timeline-express/badges/gpa.svg)](https://codeclimate.com/github/EvanHerman/timeline-express)
[![Test Coverage](https://codeclimate.com/github/EvanHerman/timeline-express/badges/coverage.svg)](https://codeclimate.com/github/EvanHerman/timeline-express/coverage)
[![Issue Count](https://codeclimate.com/github/EvanHerman/timeline-express/badges/issue_count.svg)](https://codeclimate.com/github/EvanHerman/timeline-express)
[![Project Stats](https://www.openhub.net/p/timeline-express/widgets/project_thin_badge.gif)](https://www.openhub.net/p/timeline-express)

[![Timeline Express](https://cldup.com/muOzYZg5GP.jpg)](https://www.wp-timelineexpress.com)

**Tags:**              timeline, responsive, time, line, vertical, animated, company, history, font awesome, events, calendar, scroll, dates, story, timeline express, milestone, stories <br />
**Requires at least:** WordPress v4.2 <br />
**Tested up to:**      WordPress v4.9 <br />
**Stable tag:**        1.6.0 <br />
**License:**           GPLv2 or later <br />
**License URI:**       [http://www.gnu.org/licenses/gpl-2.0.html](http://www.gnu.org/licenses/gpl-2.0.html)

[![WordPress plugin](https://img.shields.io/wordpress/plugin/v/timeline-express.svg?style=flat-square)](https://wordpress.org/plugins/timeline-express/)
[![WordPress](https://img.shields.io/wordpress/v/timeline-express.svg?style=flat-square)](https://wordpress.org/plugins/timeline-express/)
[![WordPress](https://img.shields.io/wordpress/plugin/dt/timeline-express.svg?style=flat-square)](https://wordpress.org/plugins/timeline-express/)
[![WordPress rating](https://img.shields.io/wordpress/plugin/r/timeline-express.svg?style=flat-square)](https://wordpress.org/support/plugin/timeline-express)


## Description

[Timeline Express](https://www.wp-timelineexpress.com) is a WordPress plugin that creates a vertical animated, responsive timeline of posts, in chronological order.

Timeline Express has been maintained for 2+ years, and remains the #1 WordPress Timeline Plugin on WordPress.org. While there have been a few copy cat plugins popping up recently, Timeline Express remains the most feature packed, top supported and top rated plugin timeline plugin for WordPress sites.

Timeline Express has grown to be more than just a simple timeline plugin, and can be extended for different use cases. For example, our Timeline Express Twitter Feeds Add-On converts a specified timeline into a twitter feed for a given user or search term.


## New Site & Documentation

For the new version of Timeline Express, we built out an entirely new site to showcase the features & add-ons of Timeline Express.

Additionally, the documentation for the new version of timeline express can be found at [WP Timeline Express](https://www.wp-timelineexpress.com/documentation).


## Internationalization

All of the strings contained in Timeline Express are properly prepared for translation, closely following the WordPress coding standards. That means you can create a Timeline in multiple languages, to be used on a multi-language site.

If you are multi-lingual, and want to help out with translations, feel free to [work with glotpress.org](https://translate.wordpress.org/projects/wp-plugins/timeline-express) to help provide additional translations!

Additionally, Timeline Express comes with **full WPML Support** and is the only timeline plugin [supported by WPML](https://wpml.org/plugin/timeline-express/).

Other WordPress translation plugins will work just as well, including [Polylang](https://wordpress.org/plugins/polylang/) and [qtranslate](qTranslate).


## FAQ and Documentation

#### Custom Announcement Template

Copy over `templates/timeline-express-container.php` into your theme root, in a `timeline-express` directory (`wp-content/themes/theme_name/timeline-express/timeline-express-container.php`), and start customizing.

#### Custom Single Announcement Template

Copy over `templates/single-timeline-express.php` into your theme root, in a `timeline-express` directory (`wp-content/themes/theme_name/timeline-express/single-timeline-express.php`), and start customizing.

Or to quickly and easily get the timeline announcements to look the same as your current theme, you can duplicate your existing 'single.php' template file, place it in a 'timeline-express' directory in your theme root, and replace `get_template_part();` or `the_content();` with the following Timeline Express helper function `timeline_express_content();`. Once added you can save the file, and you're all set.

#### Years Instead of Icons

Many users have asked for the ability to display the year instead of displaying the Font Awesome icons. With version 1.2, we've built in support to allow users to quickly swap out the icons for the year by dropping a single line of code into the **functions.php** file of the active theme.

```php
define( 'TIMELINE_EXPRESS_YEAR_ICONS', true );
```

Once added to your active themes **functions.php** file, you'll notice that the icon drop down no longer displays on your announcement posts - and on the front end of your site the icons are replaced with the year selected for the given announcement. If you need to style the year, or make any other sort of tweaks, you can target the element by using the following class `.`

#### Custom Container Classes
Another extremely popular request was the ability to assign custom classes to the announcement containers, for further styling. In version 1.2 we've built in a filter to allow users to add additional classes as needed - `timeline-express-announcement-container-class`.

Additionally, similar to the method mentioned above, users can drop a single line of code into their **functions.php** file, and be off to the races.

```php
define( 'TIMELINE_EXPRESS_CONTAINER_CLASSES', true );
```

Once added, you'll find a new metabox added to your announcement new/edit page titled 'Custom Container Class'. From here, you can enter the custom classes into the metabox, and save or update your post for the changes to take effect. You should now find that the newly defined classes are appended to the respective announcement containers.

#### Actions & Filters
Timeline Express is constructed with extensibility in mind. That means there are a number of actions and filters that developers can make use of, to extend the base functionality of Timeline Express.

For a visual map of the locations of the hooks within the plugin, please see [this article](#).

#### Adding Custom Metaboxes and Fields
Users have the ability to add additional meta boxes and fields as needed to the announcement post types. This can be achieved by utilizing the action hook `timeline_express_metaboxes`, or filtering the available metaboxes within the `timeline_express_custom_fields` filter. Using the `timeline_express_custom_fields` filter will allow you to add additional fields to the default 'Announcement Info.' metabox.

If you need to add custom metaboxes, it is recommended that you hook into `timeline_express_metaboxes` and define your metaboxes.

**Example**
```php
/**
 * Timeline Express Add Custom Metabox
 * @param  array $options Array of options for Timeline Express.
 */
function define_new_metabox( $options ) {
	$announcement_custom_metabox = new_cmb2_box( array(
		'id'            => 'announcement_custom_metabox',
		'title'         => __( 'Announcement Custom Metabox', 'text-domain' ),
		'object_types'  => array( 'te_announcements' ), // Post type
		'context'       => 'advanced',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );
	// Container class
	$announcement_custom_metabox->add_field( array(
		'name' => __( 'Custom Field', 'text-domain' ),
		'desc' => __( 'Custom description.', 'text-domain' ),
		'id'   => 'announcement_custom_field',
		'type' => 'text',
	) );
}
add_action( 'timeline_express_metaboxes', 'define_new_metabox' );
```

Users can then display the new meta anywhere on their site or in page templates using the built in function `timeline_express_get_custom_meta( $post->ID, 'announcement_custom_field', true )`.

Below you'll find a complete list of Actions and Filters contained within the Timeline Express code base.

### Filters

`timeline_express_slug` or `timeline-express-slug` <small>(legacy)</small>

- *Description:* Alter the default slug for all Timeline Express announcement posts. The slug is the text that appears in the URL eg: http://www.example.com/announcement/announcement-name, where 'announcement' is the slug.
- *Location:* `/timeline-express/lib/admin/cpt/cpt.announcements.php`
- *Paramaters:* `$slug`
- *Default:* 'announcement'

*Example Usage*
```php
/**
 * Alter the default Timeline Express slug
 * Change 'announcement' to 'event'
 */
function alter_timeline_express_slug( $slug ) {
	$slug = 'event';
	return $slug;
}
add_filter( 'timeline_express_slug', 'alter_timeline_express_slug' );
```

`timeline_express_singular_name`

- *Description:* This alters the 'singular_name' inside of `register_post_type()`. Alter the text in the dashboard for all instances of 'Announcement'. This filter will alter most instances of the text 'Announcement' in the admin menus, edit table etc. For all other instances of 'Announcement', you should use the [gettext](https://codex.wordpress.org/Plugin_API/Filter_Reference/gettext) filter.
- *Location:* `/timeline-express/lib/admin/cpt/cpt.announcements.php`
- *Paramaters:* `$single_name`
- *Default:* 'Announcement'

*Example Usage*
```php
/**
 * Alter most instances of 'Announcement' in the dashboard.
 * Change 'Announcement' to 'Event'
 */
function alter_timeline_express_single_name( $single_name ) {
	$single_name = 'Event';
	return $single_name;
}
add_filter( 'timeline_express_singular_name', 'alter_timeline_express_single_name' );
```

`timeline_express_plural_name`

- *Description:* This alters the 'singular_name' inside of `register_post_type()`. Alter the text in the dashboard for all instances of 'Announcements'. This filter will alter most instances of the text 'Announcements' in the admin menus, edit table etc. For all other instances of 'Announcements', you should use the [gettext](https://codex.wordpress.org/Plugin_API/Filter_Reference/gettext) filter.
- *Location:* `/timeline-express/lib/admin/cpt/cpt.announcements.php`
- *Paramaters:* `$plural_name`
- *Default:* 'Announcements'

*Example Usage*
```php
/**
 * Alter most instances of 'Announcements' in the dashboard.
 * Change 'Announcements' to 'Events'
 */
function alter_timeline_express_plural_name( $plural_name ) {
	$plural_name = 'Events';
	return $plural_name;
}
add_filter( 'timeline_express_plural_name', 'alter_timeline_express_plural_name' );
```

`timeline_express_admin_column_date_format`

- *Description:* Use this filter to alter the date format inside of the admin table, listed in the 'Announcement Date' column.
- *Location:* `/timeline-express/lib/admin/cpt/timeline-express-admin-columns.php`
- *Paramaters:* `$date_format`
- *Default:* `get_option( 'date_format' )` - WordPress date format set inside of your site settings.

*Example Usage*
```php
/**
 * Alter the date format in the admin column 'Announcement Date'.
 * Set the date format to 'January 1st, 2016' eg: `F jS, Y`
 */
function alter_timeline_express_admin_column_date_format( $date_format ) {
	$date_format = 'F jS, Y';
	return $date_format;
}
add_filter( 'timeline_express_admin_column_date_format', 'alter_timeline_express_admin_column_date_format' );
```

`timeline_express_custom_fields`

- *Description:* Add additional fields to the Timeline Express announcements. This will add fields admin side, but you will need to display them in your templates using our helper function `timeline_express_get_custom_meta()` or the built in WordPress function `get_post_meta()`.
- *Location:* `/timeline-express/lib/admin/metaboxes/metabox.announcements.php`
- *Paramaters:* `$fields`
- *Default:* Array of default Timeline Express fields.

*Example Usage*
```php
/**
 * @todo
 * Define additional custom fields to display on the Timeline Express announcements.
 */
function add_custom_timeline_express_fields( $fields ) {
	$fields[] = array();
	return $fields;
}
add_filter( 'timeline_express_custom_fields', 'add_custom_timeline_express_fields' );
```

`timeline_express_font_awesome_version`

- *Description:* Specify which version of Font Awesome you want to use to display your icons. Defaults to 4.6.1 (or latest).
- *Location:* `/timeline-express/lib/admin/metaboxes/partials/bootstrap-icon-dropdown.php`
- *Paramaters:* `$font_awesome_version`
- *Default:* Array of default Timeline Express fields.

*Example Usage*
```php
/**
 * Specify Font Awesome version 4.4.0
 */
function alter_timeline_express_font_awesome_version( $font_awesome_version ) {
	$font_awesome_version = '4.4.0';
	return $font_awesome_version;
}
add_filter( 'alter_timeline_express_font_awesome_version', 'timeline_express_font_awesome_version' );
```

`timeline_express_admin_render_date_format`

- *Description:* Alter how the date is rendered in the Announcement Date field on the edit announcement page. This field is used in our 'Historical Dates' add on. This should default to the same format as the global WordPress date format setting. **Note:** You should **not** use this filter when you have the 'Historical Dates' add on installed and active.
- *Location:* `/timeline-express/lib/admin/metaboxes/partials/time-stamp-custom.php`
- *Paramaters:* `$date_format`
- *Default:* `get_option( 'date_format' )`

*Example Usage*
```php
/**
 * Alter the way the date is rendered on the edit announcements page
 */
function alter_timeline_express_admin_date_format( $date_format ) {
	$font_awesome_version = '4.4.0';
	return $date_format;
}
add_filter( 'timeline_express_admin_render_date_format', 'alter_timeline_express_admin_date_format' );
```

`timeline_express_announcement_query_args`

- *Description:* Alter the query arguments for the Timeline query. This will alter how the Timeline is rendered on the frontend. For help see [WP_Query](https://codex.wordpress.org/Class_Reference/WP_Query).
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$announcement_args`, `$post`, `$atts`
- *Default:* Array of query arguments. Variable, depending on the Timeline Express settings.

*Example Usage*
```php
/**
 * Limit the Timeline to 5 announcements.
 */
function alter_timeline_express_front_end_query( $announcement_args, $post, $atts ) {
	$announcement_args['posts_per_page'] = 5;
	return $announcement_args;
}
add_filter( 'timeline_express_announcement_query_args', 'alter_timeline_express_front_end_query', 10, 3 );
```

`timeline_express_icon`

- *Description:* Alter the icon for ALL announcements globally, or for each individual announcement <small>(using the `$post_id` variable)</small>.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$announcement_icon`, `$post_id`
- *Default:* The icon set when you created the announcement, under the 'Announcement Icon' setting.

*Example Usage*
```php
/**
 * Set all icons to 'fa-reddit' (globally)
 */
function alter_timeline_express_icon( $announcement_icon, $post_id ) {
	$announcement_icon = 'fa-reddit';
	return $announcement_icon;
}
add_filter( 'timeline_express_icon', 'alter_timeline_express_icon', 10, 2 );
```

`timeline_express_icon_color`

- *Description:* Alter the color for ALL announcements globally, or for each individual announcement <small>(using the `$post_id` variable)</small>. **Note:** You should use a hex value.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$announcement_icon_color`, `$post_id`
- *Default:* The color set when you created the announcement, under the 'Announcement Color' setting.

*Example Usage*
```php
/**
 * Set all icons to #0000FF (blue) (globally)
 */
function alter_timeline_express_icon_color( $announcement_icon_color, $post_id ) {
	$announcement_icon_color = '#0000FF';
	return $announcement_icon_color;
}
add_filter( 'timeline_express_icon_color', 'alter_timeline_express_icon_color', 10, 2 );
```

`timeline_express_date`

- *Description:* Alter the date for ALL announcements globally, or for each individual announcement <small>(using the `$post_id` variable)</small>. To alter the date format, see the `timeline_express_date_format` filter.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$date_text`, `$post_id`
- *Default:* The text of the returned and formatted announcement date.

*Example Usage*
```php
/**
 * Alter the returned date text (globally)
 * Set it to 'Announcement Date : Date'
 */
function alter_timeline_express_date_text( $date_text, $post_id ) {
	$date_text = 'Announcement Date : ' . $date_text;
	return $date_text;
}
add_filter( 'timeline_express_date', 'alter_timeline_express_date_text', 10, 2 );
```

`timeline_express_image`

- *Description:* Alter the image for ALL announcements globally, or for each individual announcement <small>(using the `$post_id` variable)</small>. To alter the image **size** see the `timeline_express_announcement_img_size` filter.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$image_html`, `$post_id`
- *Default:* The color set when you created the announcement, under the 'Announcement Color' setting.

*Example Usage*
```php
/**
 * Remove the announcement images (globally)
 */
function alter_timeline_express_image_html( $image_html, $post_id ) {
	$image_html = '';
	return $image_html;
}
add_filter( 'timeline_express_image', 'alter_timeline_express_image_html', 10, 2 );
```

`timeline_express_announcement_img_size` or `timeline-express-announcement-img-size` <small>(legacy)</small>

- *Description:* Alter the image size for ALL announcements globally, or for each individual announcement <small>(using the `$post_id` variable)</small>. You can use any defined image size, or define your own image sizes using [add_image_size()](https://developer.wordpress.org/reference/functions/add_image_size/).
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$image_html`, `$post_id`
- *Default:* 'timeline-express' - 350x x 120px Hard Cropped - Image size defined by the plugin itself.

*Example Usage*
```php
/**
 * First define a custom image size, then and set our announcements to use the new image size.
 */

 // Register a new custom image size 'custom-size' - 750px x 300px Hard Cropped
 add_image_size( 'custom-size', '500', '300', true );

// Use our new image size on the announcements
function set_custom_timeline_express_image_size( $image_size, $post_id ) {
	$image_size = 'custom-size';
	return $image_size;
}
add_filter( 'timeline_express_announcement_img_size', 'set_custom_timeline_express_image_size', 10, 2 );
```

`timeline_express_read_more_link`

- *Description:* Alter the Timeline Express read more link markup, or set custom markup using the `$post_id` variable to set the href. **Note:** To alter the read more classes see, `timeline_express_read_more_class`. To alter the read more text, see `timeline_express_read_more_text`.
- *Location:* `/timeline-express/lib/helpers.php`
- *Paramaters:* `$read_more_html`, `$post_id`
- *Default:* HTML markup for the read more link

*Example Usage*
```php
/**
 * Wrap the read more html in <p> tags and remove the elipses (...)
 */
function custom_timeline_express_read_more_link( $read_more_html, $post_id ) {
	$read_more_html = '<p>' . str_replace( '...', '', $read_more_html ) . '</p>';
	return $read_more_html;
}
add_filter( 'timeline_express_read_more_link', 'custom_timeline_express_read_more_link', 10, 2 );
```

`timeline_express_read_more_class`

- *Description:* Alter the Timeline Express read more link class, or add additional classes.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$read_more_classes`, `$post_id`
- *Default:* 'timeline-express-read-more-link'

*Example Usage*
```php
/**
 * Add an additional class to the Timeline read more link.
 */
function add_additional_read_more_link_classes( $read_more_classes, $post_id ) {
	$read_more_classes = $read_more_classes . ' custom-read-more-class';
	return $read_more_classes;
}
add_filter( 'timeline_express_read_more_class', 'add_additional_read_more_link_classes', 10, 2 );
```

`timeline_express_read_more_text`

- *Description:* Alter the Timeline Express read more link text.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$read_more_text`, `$post_id`
- *Default:* 'timeline-express-read-more-text'

*Example Usage*
```php
/**
 * Set the read more link text from 'read more' to 'View this Announcement'
 */
function alter_timeline_express_read_more_text( $read_more_text, $post_id ) {
	$read_more_text = 'View this Announcement';
	return $read_more_text;
}
add_filter( 'timeline_express_read_more_text', 'alter_timeline_express_read_more_text', 10, 2 );
```

`timeline_express_read_more_text`

- *Description:* Alter the Timeline Express read more link text.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$read_more_text`, `$post_id`
- *Default:* 'timeline-express-read-more-text'

*Example Usage*
```php
/**
 * Set the read more link text from 'read more' to 'View this Announcement'
 */
function alter_timeline_express_read_more_text( $read_more_text, $post_id ) {
	$read_more_text = 'View this Announcement';
	return $read_more_text;
}
add_filter( 'timeline_express_read_more_text', 'alter_timeline_express_read_more_text', 10, 2 );
```

`timeline_express_frontend_excerpt`

- *Description:* Alter the Timeline Express excerpt text.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$announcement_excerpt`, `$post_id`
- *Default:* The excerpt pulled from the current announcement.

*Example Usage*
```php
/**
 * Set the timeline excerpt to something custom
 */
function alter_timeline_express_custom_excerpt_text( $announcement_excerpt, $post_id ) {
	$announcement_excerpt = 'Custom Announcement Excerpt';
	return $announcement_excerpt;
}
add_filter( 'timeline_express_frontend_excerpt', 'alter_timeline_express_custom_excerpt_text', 10, 2 );
```

`timeline_express_random_excerpt`

- *Description:* Alter the Timeline Express excerpt, when your announcements are set to random length.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$announcement_random_excerpt`, `$post_id`
- *Default:* An excerpt of random length, pulled from the current announcement.

*Example Usage*
```php
/**
 * Set the timeline random excerpt to something custom
 */
function alter_timeline_express_custom_random_excerpt_text( $announcement_random_excerpt, $post_id ) {
	$announcement_random_excerpt = 'Custom Announcement Random Excerpt';
	return $announcement_random_excerpt;
}
add_filter( 'timeline_express_random_excerpt', 'alter_timeline_express_custom_random_excerpt_text', 10, 2 );
```

`timeline_express_random_excerpt_min`

- *Description:* Alter the minimum value of the randomly generated text. The excerpt will be generated from a random number between 50 and 200.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$announcement_random_excerpt_min`, `$post_id`
- *Default:* 50

*Example Usage*
```php
/**
 * Set the minimum excerpt length to 20, when randomly generating the excerpt.
 */
function alter_timeline_express_random_excerpt_min( $announcement_random_excerpt_min, $post_id ) {
	$announcement_random_excerpt_min = 20;
	return $announcement_random_excerpt_min;
}
add_filter( 'timeline_express_random_excerpt_min', 'alter_timeline_express_random_excerpt_min', 10, 2 );
```

`timeline_express_random_excerpt_max`

- *Description:* Alter the maximum value of the randomly generated text. The excerpt will be generated from a random number between 50 and 200.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$announcement_random_excerpt_max`, `$post_id`
- *Default:* 200

*Example Usage*
```php
/**
 * Set the maximum excerpt length to 400, when randomly generating the excerpt.
 */
function alter_timeline_express_random_excerpt_max( $announcement_random_excerpt_min, $post_id ) {
	$announcement_random_excerpt_max = 400;
	return $announcement_random_excerpt_max;
}
add_filter( 'timeline_express_random_excerpt_max', 'alter_timeline_express_random_excerpt_max', 10, 2 );
```

`timeline_express_compare_sign`

- *Description:* Alter the compare sign of the WP_Query object, for the timeline.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$compare_sign`, `$post_id`
- *Default:* Variable, based on the setting assigned to the 'Announcement Time Frame' setting. Possible: '>', '', '<='

*Example Usage*
```php
/**
 * Adjust the compare sign of the WP_Query
 * Set to 'All Annoumcenets(Past+Future)' '<='
 */
function alter_timeline_express_query_compare_sign( $compare_sign, $post_id ) {
	$compare_sign = '<=';
	return $compare_sign;
}
add_filter( 'timeline_express_compare_sign', 'alter_timeline_express_query_compare_sign', 10, 2 );
```

`timeline_express_html_comment`

- *Description:* Alter the Timeline Express HTML comment generated below Timeline Express.
- *Location:* `/timeline-express/lib/classes/class-timeline-express-intialize.php`
- *Paramaters:* `$timeline_express_comment`
- *Default:* Current installed Timeline Express version with author attribution.

*Example Usage*
```php
/**
 * Remove the HTML comment generated by Timeline Express
 */
function remove_timeline_express_html_comment( $timeline_express_comment ) {
	$timeline_express_comment = '';
	return $timeline_express_comment;
}
add_filter( 'timeline_express_html_comment', 'remove_timeline_express_html_comment' );
```

`timeline_express_menu_cap`

- *Description:* Alter who can access the Timeline Express admin menu, by [capability](https://codex.wordpress.org/Roles_and_Capabilities#Capabilities).
- *Location:* `/timeline-express/lib/classes/class-timeline-express.php`
- *Paramaters:* `$menu_cap`
- *Default:* 'manage_options' - Site admins only

*Example Usage*
```php
/**
 * Allow 'Editors', or users with the 'edit_posts' capability, access to Timeline Express.
 */
function alter_timeline_express_admin_menu_cap( $menu_cap ) {
	$menu_cap = 'edit_posts';
	return $menu_cap;
}
add_filter( 'timeline_express_menu_cap', 'alter_timeline_express_admin_menu_cap' );
```

`timeline_express_tinymce_post_types`

- *Description:* Alter which post types the Timeline Express tinyMCE button appears on.
- *Location:* `/timeline-express/lib/classes/class-timeline-express.php`
- *Paramaters:* `$post_types_array`
- *Default:* `array( 'page', 'post' )`

*Example Usage*
```php
/**
 * Enable the Timeline Express tinyMCE button on the 'testimonials' post type.
 */
function alter_timeline_express_tinymce_post_types( $post_types_array ) {
	$post_types_array[] = 'testimonials';
	return $post_types_array;
}
add_filter( 'timeline_express_tinymce_post_types', 'alter_timeline_express_tinymce_post_types' );
```

`timeline_express_single_content`

- *Description:* Adjust the content on the single announcement template page.
- *Location:* `/timeline-express/lib/classes/class-timeline-express.php`
- *Paramaters:* `$single_content`, `$post_id`
- *Default:* Current announcement content.

*Example Usage*
```php
/**
 * Append custom content onto the end of the content on the single announcement template.
 */
function alter_timeline_express_single_template_content( $single_content, $post_id ) {
	$single_content = $single_content . ' | Custom content appended.';
	return $single_content;
}
add_filter( 'timeline_express_single_content', 'alter_timeline_express_single_template_content', 10, 2 );
```

`timeline_express_single_page_template` or `timeline-express-single-page-template` <small>(legacy)</small>

- *Description:* Set which template is used to display the single announcements. By default the plugin will look for a file called `single-announcement-template.php` located inside of a `/timeline-express/` directory in your theme root. If that is not found, it will look for a `single.php` template in the theme root. Finally if neither are found, it will use `page.php`.
- *Location:* `/timeline-express/lib/classes/class-timeline-express.php`
- *Paramaters:* `$single_template`
- *Default:* Default template chosen to be used for single announcements. Possible: `single.php`, `page.php`, `/path/to/custom-template.php`

*Example Usage*
```php
/**
 * Load a custom template called 'single-announcement-template.php' located in the theme root directory.
 */
function set_timeline_express_single_template( $single_template ) {
	$single_template = get_stylesheet_directory() . 'single-announcement-template.php';
}
add_filter( 'timeline_express_single_page_template', 'set_timeline_express_single_template' );
```

`timeline_express_custom_icon_html` or `timeline-express-custom-icon-html` <small>(legacy)</small>

- *Description:* Use a custom icon in place of the default loaded one.
- *Location:* `/timeline-express/lib/public/partials/timeline-express-container.php`
- *Paramaters:* `$custom_icon_markup`, `$post_id` or `$post` (`$post_id` for new filter, `$post` (global post ojbect) for legacy filter)
- *Default:* '' (empty). **Note:** Once markup is found, this will override the default icons.

*Example Usage*
```php
/**
 * @todo
 * Use a custom icon instead of the standard Font Awesome icons
 */
function set_custom_icon_html_markup( $post_id ) {
	/**
	 * To do..
	 */
}
add_filter( 'timeline_express_custom_icon_html', 'set_custom_icon_html_markup' );
```

`timeline-express-announcement-container-class`

- *Description:* Add additional classes to each announcement container on the time line.
- *Location:* `/timeline-express/lib/public/partials/timeline-express-container.php`
- *Paramaters:* `$class` & `$announcement_id`
- *Default:* 'cd-timeline-block'.

*Example Usage*
```php
/**
 * The following example will append 'custom-class' on to each announcement
 * container on the timeline.
 * @param string   $class             The default classes to filter.
 * @param integer  $announcement_id   The announcement ID to retrieve data from.
 */
public function add_additional_timeline_container_classes( $class, $announcement_id ) {
	$container_classes = array( $class );
	$container_classes[] = 'custom-class';
	return implode( ' ', $container_classes );
}
add_filter( 'timeline-express-announcement-container-class', 'add_additional_timeline_container_classes', 10, 2 );
```

### Actions

`timeline_express_metaboxes`

- *Description:* Define additional metaboxes on the announcement post new/edit screen.
- *Location:* `/timeline-express/lib/admin/cpt/cpt.announcements.php`
- *Paramaters:* `$options` - The array of Timeline Express options retreived from the databse.

**Example**
```php
/**
 * Timeline Express Add Custom Metabox
 * @param  array $options Array of options for Timeline Express.
 */
function define_new_timeline_express_metabox( $options ) {
	$announcement_custom_metabox = new_cmb2_box( array(
		'id'            => 'announcement_custom_metabox',
		'title'         => __( 'Announcement Custom Metabox', 'text-domain' ),
		'object_types'  => array( 'te_announcements' ), // Post type
		'context'       => 'advanced',
		'priority'      => 'high',
		'show_names'    => true, // Show field names on the left
	) );
	// Container class
	$announcement_custom_metabox->add_field( array(
		'name' => __( 'Custom Field', 'text-domain' ),
		'desc' => __( 'Custom description.', 'text-domain' ),
		'id'   => 'announcement_custom_field',
		'type' => 'text',
	) );
}
add_action( 'timeline_express_metaboxes', 'define_new_timeline_express_metabox' );
```

To use the newly assigned meta, you can use the helper function `timeline_express_get_custom_meta( $post_id, $meta_id );`. In the following example, we'll use the 'announcement_custom_field' that we created in the previous step, hook into `timeline-express-container-top`, and display our meta above the announcement title on the Timeline. <br /><small>Keep in mind there are a number of action hooks readily available in the plugin for you to make use of. For a visual representation of the hooks available in Timeline Express, and there locations, please see [this article](#test).</small>

```php
/**
 * Display the new custom meta, at the top of our announcement container
 * @return string The contents of the new meta field.
 */
function sample_use_custom_meta() {
	global $post;
	echo wp_kses_post( '<strong>' . timeline_express_get_custom_meta( $post->ID, 'announcement_custom_field', true ) . '</strong>' );
}
add_action( 'timeline-express-container-top', 'sample_use_custom_meta' );
```
