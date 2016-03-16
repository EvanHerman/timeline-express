=== Timeline Express ===
Contributors: eherman24
Donate link: http://www.evan-herman.com/contact/?contact-reason=I%20want%20to%20make%20a%20donation%20for%20all%20your%20hard%20work
Tags: vertical, timeline, animated, css3, animations, evan, herman, evan herman, easy, time, line, font awesome, font, awesome, announcements, notifications, simple, events, calendar, scroll, triggered, scrolling, animated, fade, in, fade in
Requires at least: 3.9
Tested up to: 4.4.2
Stable tag: 1.1.8.2
License: GPLv2 or later

Timeline express allows you to create a beautiful vertical animated and responsive timeline of posts , without writing a single line of code. Sweet!

== Description ==

Timeline express allows you to create a vertical animated timeline of announcement posts , without writing a single line of code. You simply create the 'announcement' posts, set the announcement date and publish. The timeline will populate automatically in chronological order, based on the announcement date. Easily limit the announcements displayed to Upcoming announcements, past announcements or simply display all of them.


<a href="http://www.evan-herman.com/wordpress/plugins/timeline-express-demo/" title="View the demo">View the Timeline Express Demo</a>

**Features**

* Load a custom template for single announcements (new)
* Localized date formatting for international users (new)
* Hundreds of Font awesome icons included. Specify a different icon for each announcement
* CSS3 animations on scroll
* Set the color of the announcement
* Specify the length to trim each announcemnt, or randomize it
* Hide the date of the announcement
* Hide the 'read more' button for each announcement
* Specify an image to display for each announcement
* Delete announcements on uninstallation (so no orphan posts are hanging around in your database)
* Easy to use shortcode to place the timeline wherever your heart desires ( `[timeline-express]` )
* TinyMCE button to generate the shortcode
* Specify Ascending vs Descending display order
* Highly extensible
* Translatable

><strong>Pro Features</strong>

> - Setup multiple Timelines and assign announcements to any or all of the timelines.
> - Assign categories to announcements.
> - All new sorting features. Sort timelines by categories or by timeline.
> - Display categories on single announcement templates.
> - Priority support, code snippets provided when needed etc.

><a href="http://www.evan-herman.com/wordpress-plugin/timeline-express/" title="Upgrade Now!">Get the premium version now!</a>

<br />

><strong>Historical Dates</strong>

> If you need to assign dates to announcements prior to the year 1970, you may run into limitations due to the php function `strtotime()`. We have built out an additional addon allowing dates to be saved between the years 1000-9999. 

><a href="https://www.evan-herman.com/wordpress-plugin/timeline-express-historical-dates-add-on/" title="View Historical Date Addon">View Historical Dates Addon</a>

**Translated**

Timeline express comes ready for translation. I would love to get things translated into as many languages as possible. At the moment the following translations are available for Timeline Express :

* English
* Chinese (zh_CN) - thanks goes to <a href="http://www.vahichen.com" target="_blank">Vahi Chen</a>
* Portuguese (pt_BR) - thanks goes to <a href="http://toborino.com" target="_blank">Gustavo Magalhães</a>
* Polish (pl_PL) - thanks goes to Kanios
* German (de_DE) - thanks goes to <a href="http://www.fairsoft.koeln" target="_blank">Martin Gerlach</a>
* French (fr_FR) - thanks goes to <a href="http://troisplus-et-aeliin-cosplay.fr/" target="_blank">Julien Lambert</a>
* Italian (it_IT) - thanks goes to <a href="http://evalosapeva.com/" target="_blank">Eva Filoramo</a>
* Hungarian (hu_HU) - thanks goes to <a href="http://www.keszites.com/" target="_blank">Zsolt</a>

<em>We're always looking for polyglots to help with the translations. If you enjoy this plugin, speak multiple languages and want to contribute please <a href="http://www.evan-herman.com/contact/" target="_blank">contact me</a> about how you can help translate things so users around the world can benefit from this plugin.</em>

<a href="http://www.evan-herman.com/wordpress/plugins/timeline-express-demo/" title="View the demo">View the Timeline Express Demo</a>

Looking for some advancedd documentation? Check out the <a href="https://wordpress.org/plugins/timeline-express/other_notes/">other notes</a> section.
<br />
<br />
<strong>While the plugins I develop are free, maintaining and supporting them is hard work. If you find this plugin useful, or it helps in anyway, please consider making a <a href="http://www.evan-herman.com/contact/?contact-reason=I%20want%20to%20make%20a%20donation%20for%20all%20your%20hard%20work">donation</a> for its continued development.</strong>

<em>This plugin was originally inspired by the great folks at <a href="http://codyhouse.co/gem/vertical-timeline/">CodyHouse.io</a>.</em>

== Installation ==

1. Download the plugin .zip file
2. Log in to yourdomain.com/wp-admin
3. Click Plugins -> Add New -> Upload
4. Activate the plugin
6. On the left hand menu, hover over 'Timeline Express' and click 'New Announcement'
7. Begin populating the timeline with events. (Note: Events will appear in chronological order according to the <strong>announcement date</strong>)
8. Once you have populated the timeline, head over to the settings page (Settings > Timeline Express) to customize your timeline.
9. Create a new page, and enter the shortcode [timeline-express] to display the vertical timeline (Note: Timeline Express displays best on full width pages)

== Frequently Asked Questions ==

= Is there some demo I can checkout? I want to see how the plugin appears on the front end of a WordPress site before I install it. =

You can check out the demo we've set up for users displaying two separate timelines with filtering enabled.

<a href="http://www.evan-herman.com/wordpress/plugins/timeline-express-demo/" title="View the demo">View the Timeline Express Demo</a>

= Can I filter announcements by posts/ Can I create multiple timelines? =
Not in the free version, but with our pro verson you can create numerous timelines and assign posts to a single timeline or all timelines. Also with the pro version you can easily filter announcements by categories on the front end.

<a href="http://www.evan-herman.com/wordpress/plugins/timeline-express-demo/" title="View the demo">View the Timeline Express Pro Demo</a>

= How do I use this plugin? =
Begin by simply installing the plugin. Once the plugin has been installed, go ahead and begin creating announcement posts. You'll find a new menu item just below 'Posts'.
After you have a substantial number of announcements set up, you're ready to display the timeline on the front end of your site.

Timeline express displays best on full width pages, but is not limited to them. Create a new page, and drop the shortcode into the page - `[timeline-express]`.
Publish your page, and view it on the front end the see your new super sweet timeline! (scroll for animation effects!)

= What template is the single announcement post using? Can I customize it at all? I want to do x, y or z. =
The single announcement post is using a custom template file that comes pre-bundled with the plugin. If you want to customize the template for whatever reason
you can do so, by creating a directory in your active theme called 'timeline-express'. Once the directory is created, simply copy the file titled 'single-timeline-express-announcement.php' into
the newly created 'timeline-express' directory in your theme. Timeline express will then automagically pull in the newly created template in your theme root. You can go ahead and customize 
it to your hearts desire without fear of losing any changes in future updates!

= Why can't I save dates prior to 1970'? =
Due to a limitation with the built in php function `strtotime()`, you may not be able to save dates prior to 1970. We've built out a premium add-on that works with both the free and pro versions of Timeline Express to allow dates to be saved between the years 1000-9999. If this is a feature you need, please consider purchasing the <strong><a href="https://www.evan-herman.com/wordpress-plugin/timeline-express-historical-dates-add-on/">Historical Dates Add-On</a></strong>.

= Can I create more than one timeline? =
The free version limits you to one timeline. With the <a href="http://www.evan-herman.com/wordpress-plugin/timeline-express/" title="Timeline Express Pro">pro version</a>, you can create unlimited number of timelines and even assign categories to your announcements.

= Can I assign categories to my announcements? =
You can assign categories and filter your timelines by category with the <a href="http://www.evan-herman.com/wordpress-plugin/timeline-express/" title="Timeline Express Pro">pro version</a> only.

= At what width are the breakpoints set? =
Breakpoints are set at 822px. The timeline will shift/re-adjust automatically using masonry based on the height of each announcement container.

= How can I translate this plugin? =
The text-domain for all gettext functions is `timeline-express`.

If you enjoy this plugin and want to contribute, I'm always looking for people to help translate the plugin into any of the following languages, credit will be given where credit is due :

* Arabic
* English
* Greek
* Hebrew
* Hindi
* Hong Kong
* Japanese
* Korean
* Persian
* Portuguese (European)
* Romanian
* Russian
* Spanish
* Swedish
* Taiwanese
* Tamil
* Urdu
* Vietnamese
* Welsh

Read the Codex article "[I18n for WordPress Developers]"(http://codex.wordpress.org/I18n_for_WordPress_Developers) for more information. 

== Other Notes ==

Have an idea for a future release feature? I love hearing about new ideas! You can get in contact with me through the contact form on my website, <a href="http://www.evan-herman.com/contact/" target="_blank">Evan-Herman.com</a>.

<hr />

<strong>Developer Documentation</strong>

**Hooks + Filters**

**Use Custom Images Instead of Font Awesome Icons (New v1.1.6.7)**

Users can now use the custom announcement image in place of the font awesome icons by using the following filter. Huge thanks to <a href="https://petenelson.com/">Pete Nelson</a> for the pull request and making this possible and available for everyone.

Filter - timeline-express-custom-icon-html

Usage Example: https://gist.github.com/EvanHerman/6bbc8de82f34b4cb3c5c

**Use Alternate Image Size For Announcements (New v1.1.5.5)**

By default Timeline Express generates a custom image size to use within the timeline. If you would like to use another image size, you can use the following filter.

Example:
<code>
function change_timeline_express_announcement_image_size( $image_size ) {
	$image_size = 'full';
	return $image_size;
}
add_filter( 'timeline-express-announcement-img-size' , 'change_timeline_express_announcement_image_size' );
</code>

**Define your own custom fields to use in Announcement posts (New v1.1.5)**

Users can now add custom fields to Timeline Express announcement posts. This allows for greater control over the announcements and the front end display. Using this hook in conjunction with a custom single announcement template will give you the greatest control.

Example:
<code>
function add_custom_timeline_express_field( $custom_fields ) {
	$custom_fields = array(
		array(
			'name' => __( 'Example Text Field', 'timeline-express' ),
			'desc' => __( 'this is an example user defined text field.', 'timeline-express' ),
			'id'   => 'announcement_user_defined_text',
			'type' => 'text_medium',
		),
		array(
			'name' => __( 'Example WYSIWYG', 'timeline-express' ),
			'desc' => __( 'this is an example wysiwyg field.', 'timeline-express' ),
			'id'   => 'announcement_user_defined_wysiwyg',
			'type' => 'wysiwyg',
		),
		array(
			'name' => __( 'Example Email Field', 'timeline-express' ),
			'desc' => __( 'this is an example user defined email field.', 'timeline-express' ),
			'id'   => 'announcement_user_defined_money',
			'type' => 'text_email',
		)
	);
	return $custom_fields;
}
add_filter( 'timeline_express_custom_fields' , 'add_custom_timeline_express_field' );
</code>

This example would add 3 new fields below the 'Announcement Image' field on the announcement post. 

The first field is a simple text field. The second field is an example WYSIWYG, and the third is an email field.

Note: You can add as many fields as you would like, and display them on the front end using the <a href="http://codex.wordpress.org/Function_Reference/get_post_meta" target="_blank" title="WordPress Codex: get_post_meta()">get_post_meta()</a> function.

**Customize the 'announcement' slug (New v1.1.4)**

Users can now define their own slug for announcement posts using the provided filter `'timeline-express-slug'`. This alters the URL structure of the announcement, possibly for SEO purposes. You would enter the following code into your active themes functions.php file.

After you enter the code into the functions.php file, you'll want to refresh your permalinks. You can do so by going to 'Settings > Permalinks' and simply clicking save. That will prevent the 404 page you may see upon altering the slug.

Example:
<code>
// alter '/announcement/' to be '/event/'
function timeline_express_change_announcement_slug( $slug ) {
    $slug = 'event';
    return $slug;
}
add_filter('timeline-express-slug', 'timeline_express_change_announcement_slug' );
</code>

This example would change the default `/announcement/` slug, to `/event/`.

**Alter the 'Read More' button text (New v1.1.3.1)**

Users can now alter the 'Read More' button text using the provided gettext filter and the 'timeline-express' text domain.

Example:
<code>
// alter 'Read more' to say 'View Announcement'
function timeline_express_change_readmore_text( $translated_text, $untranslated_text, $domain ) {
    switch( $untranslated_text ) {
        case 'Read more':
          $translated_text = __( 'View Announcement','timeline-express' );
        break;
     }
   return $translated_text;
}
add_filter('gettext', 'timeline_express_change_readmore_text', 20, 3);
</code>

This example would alter 'Read more' to say 'View Announcement'.

**Add custom classes to the 'Read More' button (New v1.1.3.1)**

Users can now add custom classes to the 'Read More' announcement button. This allows for greater control in fitting the Timeline into your currently active theme.

Parameters :

$button_classes = default button classes assigned to the 'Read More' button

Example:
<code>
// add a custom class to the timeline express readmore link
function timeline_express_custom_readmore_class( $button_classes ) {
	return $button_classes . 'custom-class-name';
}
add_filter( 'timeline-express-read-more-class' , 'timeline_express_custom_readmore_class' );
</code>

This example would print the following 'Read More' button HTML onto the page :

`<a href="http://site.com/link-to-announcement" class="cd-read-more btn btn-primary custom-class-name">Read more</a>`

**Setup a custom date format for front end display (New v1.0.9)**

New in version 1.0.9 is the localization of dates on the front end. The date format is now controlled by your date settings inside of 'General > Settings'.

If, for one reason or another, you'd like to specify a different date format than provided by WordPress core you can use the provided filter `timeline_express_custom_date_format`.

The one parameter you need to pass into your function is $date_format, which is (as it sounds) the format of the date.

Some formatting examples:

* `m.d.Y` - 11.19.2014
* `d-m-y` - 11-19-14
* `d M y` - 19 Nov 2014
* `D j/n/Y` - Wed 11/19/2014
* `l jS \of\ F` - Wednesday 19th of November

Example:
<code>
function custom_te_date_format( $date_format ) {
	$date_format = "M d , Y"; // will print the date as Nov 19 , 2014
	return $date_format;
}
add_filter( 'timeline_express_custom_date_format' , 'custom_te_date_format' , 10 );
</code>

* d - Numeric representation of a day, with leading zeros 01 through 31.
* m - Numeric representation of a month, with leading zeros 01 through 12.
* y - Numeric representation of a year, two digits.

* D - Textual representation of a day, three letters Mon through Sun.
* j - Numeric representation of a day, without leading zeros 1 through 31.
* n - Numeric representation of a month, without leading zeros 1 through 12.
* Y - Numeric representation of a year, four digits.

* S - English ordinal suffix for the day of the month. Consist of 2 characters st, nd, rd or th.
* F - Textual representation of a month, January through December.

* M - Textual representation of a month, three letters Jan through Dec.


<em>[view more date formatting parameters](http://php.net/manual/en/function.date.php)</em>


**Load Your Own Single Announcement Template File (New v1.0.8)**

By default all single announcements will try and load a single.php template file. If that can't be found, we've done our best to implement a template for you. If your unhappy with the template file we've provided you have two options. Your first option is to copy over the single-announcement-template directory contained within the plugin into your active themes root. This will trigger the plugin to load that file instead. You can then customize this file to your hearts content without fear of losing any of your changes in the next update.

Your next option is to use our new filter for loading your own custom template file. If for whatever reason you've designed or developed your own single.php file which you would rather use, or you just want to use your themes page.php template instead, you can use the provided filter to change the loaded template. Here is an example ( you want to drop this code into your active theme's functions.php file ) :

Example:
<code>
// By default Timeline Express uses single.php for announcements
// you can load page.php instead
// just change page.php to whatever your template file is named
// keep in mind, this is looking in your active themes root for the template
function custom_timeline_express_template_file( $template_file ) {
	$template_file = 'page.php';
	return $template_file;
}
add_filter( 'timeline_express_custom_template' , 'custom_timeline_express_template_file' , 10 );
</code>

**Specify Font Awesome Version (New 1.1.7.8)**

Users can now specify which version of font awesome to load from the font awesome CDN. Alternatively, if the font awesome version is not found - the bundled fall back (version 4.5.0) will be used.

Example:
<code>
// use a different version of Font Awesome
function timeline_express_alter_font_awesome_version( $version ) {
	$version = '4.4.0';
	return $version;
}
add_filter( 'timeline_express_font_awesome_version', 'timeline_express_alter_font_awesome_version' );
</code>

The above example will load font awesome version 4.4.0 instead of the current stable version from the font awesome CDN.

== Screenshots ==

1. Timeline Express announcement post creation screen
2. Timeline Express announcement management on the 'Edit Announcements' page
3. Timeline Express sample timeline with multiple icons/colors
4. Timeline Express responsive (mobile version)
5. Timeline Express full settings page

== Changelog ==

= 1.1.8.2 - Februrary 22nd, 2016 =
* Built in filters/support for AJAX Limit add-on.

= 1.1.8.1 - Februrary 12th, 2016 =
* Fixed reversed `is_ssl()` checks.

= 1.1.8 - Februrary 10th, 2016 =
* Ensured that the minified version of font awesome is enqueued on the front end (v4.5.0)
* Ensured that the correct version (and fallback) of font awesome was used on both frontend and backend.
* Added RTL support.

= 1.1.7.9 - February 7th, 2016 =
* New hooks for add-ons implemented: `timeline_express_sanitize_date_format`, `timeline_express_admin_render_date_format`, `timeline_express_admin_column_date_format`, `timeline_express_frontend_query_args`, `timeline_express_frontend_date_filter`
* Fix background line color options not properly updating.

= 1.1.7.8 - February 5th, 2016 =
* Upgraded font awesome library from 4.3.0 to 4.5.0.
* Added a fallback for the font awesome library - when the CDN is not accessible for whatever reason.
* Added CDN responses to transient to decrease page load times.
* Included a new filter allowing users to specify a font awesome version number to load from the CDN (`timeline_express_font_awesome_version` - see other notes.).

= 1.1.7.7 - January 30th, 2016 =
* Wrapped single announcement template date in `timeline_express_custom_date_format` filter to allow users to alter that, as well as the date in the timeline.

= 1.1.7.6 - October 2nd, 2015 =
* Fixed issue with timeline icons not saving properly, and returning empty on the front end.

= 1.1.7.5 - September 28th, 2015 =
* Fixed incorrect name for default icon dropdown.

= 1.1.7.4 - September 18th, 2015 =
* Fixed adding custom fields and using an image as an icon (https://gist.github.com/EvanHerman/6bbc8de82f34b4cb3c5c#comments)

= 1.1.7.3 - July 15th, 2015 =
* Remove duplicate date picker fields on announcements

= 1.1.7.2 - July 14th, 2015 =
* Repair date picker field not being initialized properly

= 1.1.7.1 - July 11th, 2015 =
* Update to CMB2
* Fix default settings on fresh install
* Removed max length on the announcement excerpts
* Altered query to query comparison to reflect current date, not date+time (announcements save dates, not date+time)

= 1.1.7 - July 10th, 2015 =
* Included hungarian translation - props <a href="http://www.keszites.com/" target="_blank">Zsolt</a>

= 1.1.6.9 - June 22nd, 2015 =
* Remove !important declarations on frontend
* Adjusted announcement images to be 100% width

= 1.1.6.8 - May 5th, 2015 =
* Fixed incorrect version of font awesome enqueued on front end

= 1.1.6.7 - May 4th, 2015 =
* Added new filter to allow for custom images to be used in place of font awesome icons (Props Pete Nelson)

= 1.1.6.6 - April 1st, 2015 =
* Enhancement: reverted to older styles (v1.1.6.4 stylesheet)

= 1.1.6.5 - March 31st, 2015 =
* Enhancement: re-wrote part of the CSS file, to allow for native masonry layouts (uniform spacing between containers)
* Enhancement: Repaired $response typo, and missing title

= 1.1.6.4 - March 23rd, 2015 =
* Enhancement: Packaged French translation - thanks goes to <a href="http://troisplus-et-aeliin-cosplay.fr/" target="_blank">Julien Lambert</a>
* Enhancement: Fixed a few typos in the plugin

= 1.1.6.3 - March 22nd, 2015 =
* Enhancement: Added wp_error class to catch errors thrown by `wp_remote_get()` when building the bootstrap dropdown.

= 1.1.6.2 - March 18th, 2015 =
* Enhancement: Removed `add_option();` call which was breaking previously stored options on activation

= 1.1.6.1 - March 10th, 2015 =
* Enhancement: Altered new option label to be 'Exclude Announcements from Site Searches' (settings were reversed (true excluded while false included) )

= 1.1.6 - March 9th, 2015 =
* Enhancement: Fixed 404 issue on announcement posts when 'Include Announcement in Site Searches' was set to 'false'.

= 1.1.5.9 - March 6th, 2015 =
* Enhancement: Added a priority to the metabox initialization, which caused conflicts with other plugins using the same class

= 1.1.5.8 - March 5th, 2015 =
* Enhancement: Upgraded font-awesome to 4.3.0
* Enhancement: Added icon select dropdown on the settings page, to better mirror the post/page edit screens
* Enhancement: Added new setting to toggle Timeline posts from appearing in search queries on the front end (defaults to true) 
* Enhancement: Packaged German translation - thanks to <a href="http://www.fairsoft.koeln" target="_blank">Martin Gerlach</a>

= 1.1.5.7 - February 5th, 2015 =
* Enhancement: Added a dropdown to select the font awesome icon
* Enhancement: Fadded in the timeline after everything has initialized, to prevent seeing a messed up Timeline layout

= 1.1.5.6 - February 5th, 2015 =
* Fixed: Issue with the excerpt being truncated and throwing off entire timeline layout (issue occured when truncate happened mid html tag , which left a tag open)
* Fixed: Wrapped missing text in text domain

= 1.1.5.5 - February 1st, 2015 =
* Fixed: Wrapped admin column headers in get text filter
* Fixed: Sort orders by announcement date
* Enhancement: Added filter to define custom image size for announcement image

= 1.1.5.4 - January 19th, 2015 =
* Fixed: Remove unnecessary filter in the main class file

= 1.1.5.3 - January 16th, 2015 =
* Fixed: Fixed incorrect date save format

= 1.1.5.2 - January 13th, 2015 =
* Fixed: Errors thrown from new user fields hook, when no custom fields are defined by the user
* Fixed: Incorrect date format for new announcements

= 1.1.5.1 - January 10th, 2015 =
* Fixed: Data saving incorrectly to the database, causing errors to be thrown on front and back end

= 1.1.5 - January 10th, 2015 =
* Enhancement: Added new filter ( `timeline_express_custom_fields` ) which allows users to define their own custom fields to use on Timeline Announcement posts (see readme for example).
* Fixed: CMB class file causing conflicts with other plugins, and removed the old version
* Fixed: Adjusted a few styles on the announcement post page

= 1.1.4.1 - January 2nd, 2015 =
* Fixed: Issue with date storing different on backend vs front end
* Fixed: Settings link on the Timeline Express welcome page

= 1.1.4 - December 24th, 2014 =
* Enhancement: Implemented premium support licensing. Any issues that require immediate response, or custom code should purchase a support license.
* Enhancement: Added a new filter to customize the announcement slug (possibly for SEO purposes) (timeline-express-slug , check documentation for examples)
* Enhancement: Moved settings/support below Timeline Express parent menu item
* Fixed: Errors thrown when announcement images aren't set
* Fixed: Display error where announcements displayed a different date on the backend vs frontend

= 1.1.3.2 - December 11th, 2014 =
* Enhancement: Added Dutch language translation (nl_NL)  - thanks goes to <a href="http://www.kasteelschaesberg.info/wpress/" target="_blank">Kees Hessels</a>
* Fixed: A few typos throughout the plugin

= 1.1.3.1 - December 10th, 2014 =
* Enhancement: Added new filter `timeline-express-read-more-class` which allows users to add custom classes to the 'Read More' button
* Enhancement: Wrapped 'Read More' in gettext filter, to allow for text to be altered

= 1.1.3 - December 6th, 2014 =
* Fixed: Weird query issue with timeline announcements not  displaying at proper times
* Fixed: Styling issue with announcement date picker calendar arrow
* Fixed: Removed all line-breaks and hyphens from the timeline titles

= 1.1.2 - December 5th, 2014 =
* Fixed: Minor styling issues with announcement images extending outside the announcement container (added new class to the image .announcement-banner-image)

= 1.1.1 - December 4th, 2014 =
* Fixed: Minor styling issues with the mobile timeline icon size/margins
* Fixed: Minor styling issues with the mobile timeline announcement arrow appearing 1px to soon
* Fixed: Typo of 'Timeline Express' in the admin settings menu

= 1.1 - December 3rd, 2014 =
* Fixed: Fixed styles when timeline is inside posts (fixed icon size, duplicate images)
* Fixed: Fixed a few enqueue functions
* Enhancement: Polish language translation now included (pl_PL) - thanks goes to Kanios
* Enhancement: Enqueued new styles on single announcement posts to style the announcement pages a bit better
* Enhancement: Added new custom image size, to unify announcement images on the timeline ('timeline-express')
* Enhancement: Added new function `timeline_express_get_image_id()` to get attachment image IDs by URL
* Enhancement: Stripped out a lot of un-needed code

= 1.0.9 - November 19th, 2014 =
* Updated: Localized date format displayed on the front end as requested by our international users ( format now takes on what you have in 'General > Settings' )
* Updated: Fixed styling issue on date picker arrows
* Feature: Added new filter to allow users to specify a custom date format (`timeline_express_custom_date_format`)

= 1.0.8 - November 17th, 2014 =
* Updated: Single announcement template file, which was causing issues for some users on specific themes
* Feature: Added a new filter to allow users to load custom template files
* Feature: Added auto update feature for Timeline Express
* Fixed: Issue where links in the excerpt and 'read more' links couldn't be clicked due to overlapping masonry elements
* Fixed: Missing image on welcome page
* Fixed: Minor issues on welcome page including some links

= 1.0.7 - November 13th, 2014 =
* Enhancement: Portuguese language translation now included (pt_BR) - thanks goes to <a href="http://toborino.com" target="_blank">Gustavo Magalhães</a>

= 1.0.6 = 
* Fixed fatal error thrown on activation for sites running older versions of PHP

= 1.0.5 = 
* Change priority argument on register post type function, which caused conflicts with other custom post types on certain sites

= 1.0.4 = 
* Chinese language translation now included (zh_CN) - thanks goes to <a href="http://www.vahichen.com" target="_blank">Vahi Chen</a>
* Removed some un-necessary styles (timeline title/content font-size+font-family declerations)

= 1.0.3 = 
* Included new function to retain formatting in the announcement excerpt in the timeline (`te_wp_trim_words_retain_formatting()`)

= 1.0.2 = 
* Add a display order setting to set Ascending or Descending display order for announcements in the timeline
* Fixed "cannot access settings page" when clicking on the settings tab when on the settings page already

= 1.0.1 =
* Update masonry function to include .imagesLoaded(); to prevent overlapping containers in the timeline

= 1.0 =
* Initial Release to the WordPress repository

== Upgrade Notice ==

= 1.1.8.2 - Februrary 22nd, 2016 =
* Built in filters/support for AJAX Limit add-on..