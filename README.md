## Synopsis

*WPGeocode* is a [wordpress.org](wordpress plugin) that enables content publishers to leverage reader location in their pages or posts.

## Code Example

`[wpgc_city]` is an example of a shortcode enabled by wpgeocode.  Whereever this shortcode appears in your wordpress page or post it will be replaced by the reader's actual city.

## Motivation

I created this plugin to enable publishers to leverage reader location to customize content based on location.

## Installation

Standard wordpress plugin instructions apply.  Upload to your plugins folder and activate.

## API Reference

WPGeocode enables two basic types of shortcodes.  The first is a simple variable filter.  Variable filters enable the publisher to incorporate reader geo information
 inside a page or post.  For example, `[wpgc_city]` in a page or post will be replaced with the name of the reader's city.

The second type of shortcode enabled by this plugin is called a conditional shortcode.  Conditional shortcodes enable a publisher to customize a content block based
on a geo condition.  For example, `[wpgc_is_country_code country_code="US"]` THIS CONTENT WILL ONLY BE SEEN BY USERS VIEWING THE PAGE FROM THE US `[/wgpc_is_country_code]`.  The content that appears inside a conditional shortcode will appear only when the condition is true.

## Tests

To test WPGeocode, create a page or post and incorporate a shortcode such as `[wpgc_city]`.  View the page or post to verify that the city displayed is yours - or at least near.

## Contributors

Want to contribute?  Send me [email](mailto:merlynn@gmail.com)

## License

A short snippet describing the license (MIT, Apache, etc.)
