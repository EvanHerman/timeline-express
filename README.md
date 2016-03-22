[![Build Status](https://travis-ci.org/EvanHerman/Timeline-Express.svg?branch=master)](https://travis-ci.org/EvanHerman/Timeline-Express)
[![Build Status](https://scrutinizer-ci.com/g/EvanHerman/Timeline-Express/badges/build.png?b=Refactor---v1.2)](https://scrutinizer-ci.com/g/EvanHerman/Timeline-Express/build-status/Refactor---v1.2)
[![Code Coverage](https://scrutinizer-ci.com/g/EvanHerman/Timeline-Express/badges/coverage.png?b=Refactor---v1.2)](https://scrutinizer-ci.com/g/EvanHerman/Timeline-Express/?branch=Refactor---v1.2)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/EvanHerman/Timeline-Express/badges/quality-score.png?b=Refactor---v1.2)](https://scrutinizer-ci.com/g/EvanHerman/Timeline-Express/?branch=Refactor---v1.2)

# Timeline Express - v1.2
This repository is a re-factor of the original code base.

### New Site & Documentation
For the new version of Timeline Express, we built out an entirely new site to showcase the features & add-ons of Timeline Express.

Additionally, the documentation for the new version of timeline express can be found at [WP Timeline Express](http://www.wp-timelineexpress.com/documentation).

### Custom Announcement Template
In version 1.2 users can now customize the announcement container for each announcement on the timeline.

Copy over `lib/public/partials/timeline-express-container.php` into your theme root, in a `timeline-express` directory (`wp-content/themes/theme_name/timeline-express/timeline-express-container.php`), and start customizing.

### Custom Single Announcement Template
In version 1.2 users can now customize the single announcement template for each announcement on the timeline.

Copy over `lib/public/partials/single.timeline-express.php` into your theme root, in a `timeline-express` directory (`wp-content/themes/theme_name/timeline-express/single.timeline-express.php`), and start customizing.

Note: Out of the box, Timeline Express looks for a single.php template inside of your theme root. If one is not found, it will check for a page.php template. Additionally, you can create a template named `single.te_announcements.php` inside of a `timeline-express` directory in your theme root (`wp-content/themes/theme_name/timeline-express-single.te_announcements.php`) for full customization of the page template loaded.

### Actions & Filters

To do...
List out the actions & filters inside of both template files.
List out the filters inside of each helper function.
