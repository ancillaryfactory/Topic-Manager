=== Topic Manger ===

Contributors: rockgod100
Plugin Name: Topic Manager
Plugin URI: http://www.ancillaryfactory/topicmanager
Tags: wp, multi-author, topics, posts, authors
Author URI: http://www.aoa.org
Author: AOA
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 1.9
Version: 1.9

A quick way to remember post topics for single or multi-author blogs

== Installation ==

1. Upload Topic Manager folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. A 'Topic Manager' option will now be available in the left column of the dashboard.
1. To give authors a front-end table of open and assigned topics, place 
`<?php if (function_exists('topics_frontend_table')) {
    topics_frontend_table();
}  ?>` 
in a custom page template, most likely a copy of page.php



== Description ==
This plugin creates an area for site admins to jot down post ideas or assign post topics to content authors. Additionally, authors can be given due dates and suggested post types (article, video, etc). 

Admins can also e-mail authors directly through the interface using an extension of the wp_mail() function.


== Screenshots ==
1. Available topics




== Changelog ==
Version 1.9:

* Redesigned admin grid for more readability
* One click to create draft post from topic

Version 1.8:

* Added single/multi-author options. When the single author option is selected, the Author fields are hidden, along with the option to send a message to another author

* Updated options to set defaults after initial install

Version 1.7.1: 

* New options screen
* Link to Topic Manager now appears in Admin bar
* Choose permission level for access to Topic Manager admin functions


Version 1.6: 

* Recommended security update: Admin functionality is now only available to users who can manage options (admins)
* Added link in Admin bar and display of descriptions in frontend table