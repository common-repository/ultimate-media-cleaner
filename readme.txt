=== Ultimate media cleaner ===
Contributors: nicearma
Tags: clean, media, files, clean files, media clean, image clean, attachment clean, delete, image not used, image unused, files unused, files not used, delete unused, delete not used image, clean up image, clean image, clean images, clean, clean wp, clean wordpress
Requires at least: 5.5
Requires PHP: 7.2
Tested up to: 5.8
Stable tag: 2.6.1

Find used medias from you from the database and/or your upload folder and give the way to delete them the ones "unused"

== Description ==

Ultimate media cleaner give you the power to find "unused files" (please read the next line) in your sites and delete them

Unused files is more "not usage found" with our detection system. You have to know that WP is easy to use, but is a very complex software.

Remember that WP can be used like e-commerce, video share platform, normal blog, etc.

So is impossible to be 100% accurate about the "unused files", so for this version we changed for "Not usage found", this phrase is more accurate about what this plugin do

=== PRO VERSION ===

We made one Pro version, we added some "nice to have feature", you can find it at [Ultimate media cleaner PRO](https://umc.nicearma.com/)

=== Crawler option ===

Even if we made all possible to try to find reference in the database, there are some files used in ways impossible to detected internally.

The only way is to use one web crawler and to detect the reference in direct in your HTML, JS and CSS code

We work in our own web crawler, you can find it at [Ultimate media cleaner Crawler](https://umc.nicearma.com/) (external and pay service)

We made one Pro version, we added some "nice to have feature", you can find it at [Ultimate media cleaner PRO](https://umc.nicearma.com/)

=== HOW THIS PLUGIN WORK ===

Is important to you to know how this plugin work, so here we go:

The plugin is composed in 5 prat

*Find files from database and find files from your folder system part*
This two parts are really similar, the unique difference is where the information is coming from.
Files from the database will show you every file and images found in the database (in your database this will be the table Post with values post_type='attachment')
And folders, are files found in the wp-upload folder. Keep in mind that some plugin use this folder to add their own files, and this plugin will not detect their usage

* After selecting from where you want to show the WP files
* The plugin will try to find out if the file is used or unused, this is made with some sql script, trying to found some physical reference in post and pages
* Try to find if the file is used in some shortcode (coming soon)
* Found if the crawler system detected the file (pay service)
* Show you the result and give you the opportunity to delete, ignored the "unused files", if is used, the plugin will not show any option
* You can ignore the file, because you know that this file is used, but the file have the "unused" label
* You can put in the delete list (this will not delete the file)

*Keep in mind that the "not usage found" label can have from 0% to 100% accuracy*

*The delete list part*

You can see every file that you want to delete, so have two option, continue and delete them or remove it from them from the list

Try to make your own verification and validate that the file you want to delete is not used in your site

*The option part*

You can found some useful configuration, like hide the delete button for children images

*The crawler part*

You can crawl your site to have better accuracy in the "not usage found" found

=== HOW TO USE IT ===

This plugin is like “one-shot usage”, you should do:

In only one day (you can take one day without making news post or page, to make this maintenance activity )

* Make one backup of your site (There are good backup plugin in WP)
* Add one test post or page with test images/files
* See if the plugin is working and detecting the test images/file are used
* Delete the unused test files or images
* See if the test post or page is working as it should
* If the plugin is working for this test, go with some productions post and page (like the oldest, the least viewed or less important posts or pages)
* See if the plugin is working and detecting the images/file are used
* Delete the unused files or images

You have two possible result: Working, not working

*Working*

* Keep going with other images and files, but trying to see if your site still working
* Delete all unused files/images
* Normally your site is free of unused files, so you can delete and forget about the plugin

*Not working*

* restore your site from the backup system
* Delete the plugin
* Find another plugin

=== IMPORTANT ===

This plugin can destroy your site IF you don't know how to use it, YES YOU CAN DESTROY IT!!!

This plugin need you to see if is working like it should, take the "not usage found" like inaccurate and go by little steps, see if is working with your WP configuration, plugins, themes, etc.

*Is very wisely to use one backup system, that take in account your upload folder and database*

=== HOW IT WORKS ===

They are some big part of this plugin:

- the search: it show you all medias in your site, from the database or you upload folder
- the verification: try to find if the media is used, if all detection fail to find reference, the media will show like is "not usage found", but again this can be inaccurate
- deletion: after you chose witch files will be deleted, the plugin will delete it from the database and from your upload folder

== Changelog ==


= Version 2.6.1 =

* Add version to the JS and style to fix cache files

= Version 2.6.0 =

* Fix some performance issues
* Refacto the crawler part
* Add basic plugin detection for Woocomerce, elementor, and Astra

= Version 2.5.1 =

* Added plugins Woocomerce compatibility
* Add crawler option for all
* Add option crawler page

= Version 2.5.1 =

* Fix $hook script charging

= Version 2.5 =

* Disable automatic licence crawler

= Version 2.4 =

* Add crawler option
* Add warning and welcome page
* Rename old warning to quiz
* Change quiz text
* Fix some bugs

= Version 2.2 =

Add delete option for attachment from server

= Version 2.1 =

Added medias from server and find ids, but without delete/ignore options

= Version 2.0 =

New release, new code back and front

= Version 1.0 =

Rewrite of DNUI and CUF in one plugin

* Find and delete media files from the database
* Find and delete media files from folders
* Page of option
* Tunnel for first person using the plugin

== Installation ==

The easy way :

1. Download this plugin direct from the page of plugin in your wordpress site.

The hard way :

1. Download the zip.
2. Connect to your server and upload the `DNUI` folder to your `/wp-content/plugins/` directory
2. Activate the plugin using the `Plugins` menu in WordPress
