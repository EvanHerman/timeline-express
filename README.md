Timeline Express v1.0.6
================

Timeline express allows you to create a vertical animated and responsive timeline of posts , without writing a single line of code. Sweet!

**Features**

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

**Translated**

Timeline express comes ready for translation. I would love to get things translated to as many languages as possible. At the moment the following translations are available for Timeline Express

* English
* Chinese (zh_CN) - thanks goes to <a href="http://www.vahichen.com" target="_blank">Vahi Chen</a>

### Installation

1. Download the plugin .zip file
2. Log in to yourdomain.com/wp-admin
3. Click Plugins -> Add New -> Upload
4. Activate the plugin
6. On the left hand menu, hover over 'Timeline Express' and click 'New Announcement'
7. Begin populating the timeline with events. (Note: Events will appear in chronological order according to the <strong>announcement date</strong>)
8. Once you have populated the timeline, head over to the settings page (Settings > Timeline Express) to customize your timeline.
9. Create a new page, and enter the shortcode [timeline-express] to display the vertical timeline (Note: Timeline Express displays best on full width pages)

### Frequently Asked Questions

###### How do I use this plugin?
Begin by simply installing the plugin. Once the plugin has been installed, go ahead and begin creating announcement posts. You'll find a new menu item just below 'Posts'.
After you have a substantial number of announcements set up, you're ready to display the timeline on the front end of your site.

Timeline express displays best on full width pages, but is not limited to them. Create a new page, and drop the shortcode into the page - `[timeline-express]`.
Publish your page, and view it on the front end the see your new super sweet timeline! (scroll for animation effects!)

###### What template is the single announcement post using? Can I customize it at all? I want to do x, y or z.
The single announcement post is using a custom template file that comes pre-bundled with the plugin. If you want to customize the template for whatever reason
you can do so, by creating a directory in your active theme called 'timeline-express'. Once the directory is created, simply copy the file titled 'single-timeline-express-announcement.php' into
the newly created 'timeline-express' directory in your theme. Timeline express will then automagically pull in the newly created template in your theme root. You can go ahead and customize 
it to your hearts desire without fear of losing any changes in future updates!

###### Can I create more than one timeline?
At the moment no, but I will consider adding that into a futre update if people show enough interest.

###### At what width are the breakpoints set?
Breakpoints are set at 822px. The timeline will shift/re-adjust automatically using masonry based on the height of each announcement container.

###### How can I translate this plugin?
The text-domain for all gettext functions is `timeline-express`.

If you enjoy this plugin and want to contribute, I'm always looking for people to help translate the plugin into any of the following languages, credit will be given where credit is due :

* Arabic
* Chinese
* English
* French
* German
* Greek
* Hebrew
* Hindi
* Hong Kong
* Italian
* Japanese
* Korean
* Persian
* Portuguese (Brazilian)
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

### Future Ideas

Have an idea for a future release feature? I love hearing about new ideas! You can get in contact with me through the contact form on my website, <a href="http://www.evan-herman.com/contact/" target="_blank">Evan-Herman.com</a>.


### Changelog
###### 1.0.6 
* Repaired fatal error thrown on activation for sites running older versions of PHP

###### 1.0.5
* Change priority argument on register post type function, which caused conflicts with other custom post types on certain sites

###### 1.0.4 
* Chinese language translation now included (zh_CN) - thanks goes to <a href="http://www.vahichen.com" target="_blank">Vahi Chen</a>
* Removed title and content style declerations for font-size and font-family styles

###### 1.0.3
* Included new function to retain formatting in the announcement excerpt in the timeline (te_wp_trim_words_retain_formatting())

###### 1.0.2
* Add display order setting to specify ascending or descending order of announcements in the timeline
* Fixed "cannot access settings page" when clicking on the settings tab when on the settings page already

###### 1.0.1 
* Update masonry function to include .imagesLoaded(); to prevent overlapping containers in the timeline

###### 1.0
* Initial Release to the wordpress respository

### Upgrade Notice
###### 1.0.3
* Included new function to retain formatting in the announcement excerpt in the timeline (te_wp_trim_words_retain_formatting())

###### 1.0.2
* Add display order setting to specify ascending or descending order of announcements in the timeline
* Fixed "cannot access settings page" when clicking on the settings tab when on the settings page already

###### 1.0.1 
* Update masonry function to include .imagesLoaded(); to prevent overlapping containers in the timeline

###### 1.0
* Initial Release to the wordpress respository