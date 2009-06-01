=== Plugin Name ===
Contributors: zach
Donate link: http://www.codezach.com
Tags: upcoming,events,upcoming post
Requires at least: 2.7.1
Tested up to: 2.7.1
Stable tag: trunk

List posts tagged with a future date on a page or post. Date format, styles, title, and html template configurable. Useful for advertising upcoming events.

== Description ==

List posts tagged with a future date on a page or post. Date format, styles, title, and html template configurable. Useful for advertising upcoming events.

== Installation ==

1. Upload the plugin directory to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. Update styles, title, date format, and html templates on the Settings->Upcoming Events page.

**Usage** 
To display a list of upcoming events on a page or post, do the following:

1. Add a custom field entitled "UpcomingEvent" to the post which represents the upcoming event. Enter a 
date as "January 25th 2009" or "3:35pm May 14 2012". Full input format specs [Here](http://www.php.net/strtotime).

2. Insert [UpcomingEvents] into the post or page you want the list displayed.

Only events happening in the future will be displayed. Date output format specs can be found [Here](http://www.php.net/manual/en/function.date.php).


== Frequently Asked Questions ==

= How do I mark a post as an upcoming event? =

Add a custom field entitled "UpcomingEvent" to the post which represents the upcoming event. Enter a 
date as "January 25th 2009" or "3:35pm May 14 2012". Full input format specs [Here](http://www.php.net/strtotime). 

= How do I add a "custom field" to a post? =

When editing a post, scroll down until you see the "Add Custom Field" button. Click it. Then type "UpcomingEvent" 
into the "Name" text box and the date you want in the "Value" textbox. Don't forget to click "Update" when you're done.

= How do I show the upcoming events on a post? =

Include [UpcomingEvents] in the post you want the list displayed.

= I don't like the way it looks, can I change that? =

Yes, go to the options page Settings->Upcoming Events to edit the CSS, HTML templates, title, and date format.

== Screenshots ==
