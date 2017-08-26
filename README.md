# Making Your First Plugin at WordCamp Denver 2017

This repository will hold the steps we'll take in the "Making Your First WordPress Plugin" workshop.

## What We'll Talk About Before We Start

* What experience does everyone have with WordPress and making plugins?
* What is a WordPress plugin? What kinds of things can they do?
* What is PHP? OOP?
* What role do HTML, CSS, and JavaScript have in WordPress plugins?

## The Steps

### How to Make a Basic Plugin

1. Create a plugin by making a folder with this name.
2. Make the main file in the repo. We'll follow the common convention (which isn't required by WordPress) that the folder name and the primary-file name are the same. 
3. We'll add the plugin header to that: https://codex.wordpress.org/File_Header#Plugin_File_Header_Example

### Make a CPT

1. Register the post type using `register_post_type()` function. Set up labels and arguments for post type - see https://codex.wordpress.org/Function_Reference/register_post_type for all options
2. Hook into 'init' which runs after WP has finished loading but before any headers are sent.  Most of WP is loaded at this stage.  https://codex.wordpress.org/Plugin_API/Action_Reference/init
3. Reset Permalinks

### Make a Taxonomy

1. Register a taxonomy using `register_taxonomy()` function -- https://codex.wordpress.org/Function_Reference/register_taxonomy. Talk over label and argument options
2. Also hook into 'init'
3. Reset permalinks

### Make a Shortcode

1. Making a basic shortcode function return something -- https://codex.wordpress.org/Function_Reference/add_shortcode
2. Shortcode returns name of random testimonial using `WP_Query`, loop, `get_the_title` -- https://codex.wordpress.org/Class_Reference/WP_Query
4. Replace `get_the_title` with `the_title` and output buffering -- https://wpshout.com/output-buffering/
5. Move template to a separate template file.

### Add Styling

1. Class around the template & style it in file
2. Move style(s) into own enqueued stylesheet -- https://developer.wordpress.org/reference/functions/wp_enqueue_style/

### Make a Widget

2. Copypasta from Codex the `WP_Widget` class (need BOTH class AND hook) — https://developer.wordpress.org/reference/classes/wp_widget/
3. Show output of the widget — slime something there, add in the before title, etc boilerplate
4. Add in the loop again, or maybe use `get_posts` to output something from a real testimonial
5. Add settable title to widget (see Codex)

### Optional Extras

* Change "Title" field for the CPT to reflect that we're using that fiield for names
* Create further custom meta fields for the testimonials, using them for thing like testimonial-giver's title, company, etc

## Credits

This repository, idea, and much of the code is cribbed from a workshop run by the Fort Collins WordPress Meetup in 2016, which was presented by me with @greenhornet79, @amberhinds, @mikeselendar, and Michael Launer. The repository for that event is https://github.com/amberhinds/fcwp-testimonials. To follow the basic flow of that workshop, the &name%-notes.md files were presented in this order:

1. Jeremy -- https://github.com/amberhinds/fcwp-testimonials/blob/master/jeremy-notes.md
2. Amber -- https://github.com/amberhinds/fcwp-testimonials/blob/master/amber-notes.md
3. David -- https://github.com/amberhinds/fcwp-testimonials/blob/master/david-notes.md
4. Mike -- https://github.com/amberhinds/fcwp-testimonials/blob/master/mike-notes.md
