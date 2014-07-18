=== Owl Carousel ===
Contributors: Pierre Jehan
Tags: carousel, slideshow, slider, gallery, images, photos, responsive
Tested up to: 3.9.1
License: GPL2
License URI: http://opensource.org/licenses/MIT

Add a carousel to your website. Based on the Owl Carousel, a responsive and fully customizable carousel.

== Description ==

Add a carousel to your website. Based on the Owl Carousel, a responsive and fully customizable carousel.

Special thanks to Bartosz Wojciechowski, Owl Carousel developer.

#### Features ####

* Image slide
* HTML slide
* [NEW!] Wordpress Gallery compatible
* And of course, all the Owl Carousel options!

#### How to use ####
1. Create a new Category
2. Create new slides
3. Include your carousel in any content (post, page, theme...)

You can add your carousel into any post with the following shortcode (or using the custom TinyMCE button):

[owl-carousel]
To edit the carousel options (items per slide, auto play...) you just need to add options in the shortcode:

[owl-carousel category="Uncategorized" items="1" autoPlay="true"]
Notice the category option to display items from a specific category.

You can also use the default Wordpress gallery like this (you need to enable this feature in the plugin's parameters):

[gallery ids="48,47,46,45,44", items="3"]

If you want to include Owl Carousel in your custom theme, please have a look at the do_shortcode Wordpress function:
http://codex.wordpress.org/Function_Reference/do_shortcode

You can checkout the available options on the Owl carousel website:
http://www.owlgraphic.com/owlcarousel/

And watch this video tutorial:
http://www.youtube.com/watch?v=yELCuWAY6N8


Owl Carousel version 2 is coming soon! This plugin will be compatible with the new version as soon as possible.

If you want to keep up to date with this plugin, you can have a look at my blog: http://blog.pierre-jehan.com

== Installation ==
Extract the zip file and upload the contents to the wp-content/plugins/ directory of your WordPress installation and then activate the plugin from the plugins page.

== Screenshots ==

1. Front screenshot
2. Admin screenshot

== Changelog ==

= 0.4.2 =
* Add save_parameter.php file

= 0.4.1 =
* Fix custom category

= 0.4 =
* Wordpress gallery support
* Custom category
* Fix slide limit
