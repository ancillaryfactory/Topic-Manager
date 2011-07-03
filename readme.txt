=== Topic Manger ===

Contributors: rockgod100
Plugin Name: Topic Manager
Plugin URI: http://www.ancillaryfactory/topicmanager
Tags: wp, multi-author, topics, posts, authors
Author URI: http://www.aoa.org
Author: AOA
Requires at least: 3.0
Tested up to: 3.2
Stable tag: 1.7
Version: 1.7

A quick way to remember post topics for single or multi-author blogs

== Installation ==

1. Upload Topic Manager folder to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. A 'Topic Manager' option will now be available in the left column of the dashboard.
1. To give authors a front-end table of open and assigned topics, place `<?php topics_frontend_table(); ?>` in a custom page template, most likely a copy of page.php



== Description ==
This plugin allows site admins to assign post topics to content authors. Additionally, authors can be given 
due dates and suggested post types (article, video, etc). 

Admins can also e-mail authors directly through the interface using an extension of the wp_mail() function.


== Screenshots ==
1. Available topics




== Changelog ==
Version 1.7: 

* New options screen
* Link to Topic Manager now appears in Admin bar
* Choose permission level for access to Topic Manager admin functions