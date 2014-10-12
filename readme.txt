=== WP Geocode Filter ===
Contributors: Michael Lynn
Author URI: http://www.mlynn.org
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=GDQD948MQ3G3G
Tags: geocode, geocode filter, geotag, geomarketing, geomarking, geolocation, geofilter, location, local marketing, keywords
Version: 1.0.13
Requires at least: 3.0
Tested up to: 4.0
Stable tag: 4

== Description ==

WP Geocode enables Wordpress publishers to customize content based on the Geolocation information of the reader.  

WP Geocode implements shortcodes that let publishers incorporate reader's geolocation data into posts, and post titles.  Additionally, publishers can use shortcodes in posts which let them tailor post content to the reader based on proximity or location.  This product includes GeoLite data created by MaxMind, available from http://www.maxmind.com/.

Use WP Geocode to customize the content of your blog based on the geographic location of your readers.

**Available Filter Shortcodes**

**This filter content in the article body, title based on the reader's geolocation data:**

* [wpgc_ip] - IP Address of the reader
* [wpgc_city] - City of the reader
* [wpgc_state_code] - Two letter State code of the reader
* [wpgc_country_name] - Country name of the reader
* [wpgc_country_code] - Two letter Country code of the reader
* [wpgc_latitude] - Latitude of the reader
* [wpgc_longitude] - Latitude of the reader

**Conditional Shortcodes - Only available in the body of the post:**

* [wpgc_is_city_and_state city="Yardley" state_code="PA"]
* [wpgc_is_ip" ip="xx.xx.xx.xx"]
* [wpgc_is_ips" ip="xx.xx.xx.xx,aa.bb.cc.dd"]
* [wpgc_is_not_ip" ip="xx.xx.xx.xx"]
* [wpgc_is_not_ips" ip="xx.xx.xx.xx,aa.bb.cc.dd"]
* [wpgc_is_city" city=""]
* [wpgc_is_cities" cities="city one,city two,city three"]
* [wpgc_is_not_city" city=""]
* [wpgc_is_not_cities" cities="city one,city two,city three"]
* [wpgc_is_nearby"] - Uses the value you specify in the Nearby Range setting from the administrative panel
* [wpgc_is_not_nearby"]
* [wpgc_is_within" miles="10"] 
* [wpgc_is_within kilometers="12"]
* [wpgc_is_country_name" country_name=""] 
* [wpgc_is_country_names" country_name="United States,Egypt,Albania"] 
* [wpgc_is_country_code" country_code=""]
* [wpgc_is_country_codes" country_codes="US,GB,AZ"]
* [wpgc_is_state_code" state_code=""] 
* [wpgc_is_state_codes" state_codes="PA,NJ,TX"] 
* [wpgc_is_not_country_name" country_name=""] 
* [wpgc_is_not_country_names" country_names="United States,Egypt,Albania"] 
* [wpgc_is_not_country_code" country_code=""] 
* [wpgc_is_not_country_codes" country_codes="US,GB,AZ"] 
* [wpgc_is_not_state_code" state_code=""] 
* [wpgc_is_not_state_codes" state_codes="PA,NJ,TX"] 

**Examples**

    [wpgc_is_nearby] Hi Neighbor! [/wpgc_is_nearby] - Will display "Hi Neighbor!" to readers within a configurable distance from your home base.
    [wpgc_is_within miles=10] Come on over! [/wpgc_is_within] - Will display "Come on over!" in the post body if the user is viewing the post from within 10 miles.
    [wpgc_is_ip ip=123.123.123.123] I used to own this IP Address [/wpgc_is_ip] - Will display the message only if the user has that specific IP Address.
    [wpgc_is_city city="Yardley"] Hello Fellow Yardlian [/wpgc_is_city] - Will display the message only if the user has that specific IP Address.
    [wpgc_is_not_cities cities="Yardley,Morrisville"] Glad you don't live in Yardley or Morrisville? [/wpgc_is_not_cities] - Will display only when visitor is not viewing the page from Yardley or Morrisville

Configurable options allow you to set a default phrase for each available shortcode in the event that the user was unable to be geo-located.

== Installation ==

1. Upload all the files into your wp-content/plugins directory, be sure to put them into a folder called "wpgeocode" - name is important.
2. Activate the plugin at the plugin administration page
3. Follow set-up steps on main WP Geocode settings page 

Note: You must install the MaxMind GeoLite City Database in order for this plugin to function properly.  

Please see the [wpgeocode plugin home page](http://mlynn.org/plugins/wpgeocode/) for details

== Frequently Asked Questions ==

Please visit the [wpgeocode community page](http://mlynn.org/plugins/wpgeocode/) for suggestions and help.

== Screenshots ==

1. screenshot-1.png is the administrative options screen.
2. screenshot-2.png is the plugin in action.

== Change Log ==
= 1.0.13 =
* Updated GeoLite City and testing on WP 4

= 1.0.12 =
* Fixed missing requirement

= 1.0.11 =
* Updated GeoIP PHP Api Version

= 1.0.10 =
* Updated Geocity database

= 1.0.9 =
* state_name never worked... problem with maxmind database.  I've corrected via code in this plugin.

= 1.0.8 =
* Minor fixes for country_code support.

= 1.0.7 =
* Added support for postal code shortcodes [wpgc_postal_code],[wpgc_is_postal_code],[wpgc_is_not_postal_code postal_code="12342"],[wpgc_is_postal_code postal_code="12322"],[wpgc_is_not_postal_codes postal_codes="19232,12323"]

= 1.0.6 =
* Fix conditional shortcode wpgc_is_not_country_codes

= 1.0.5 =
* Add support for multiple locations (i.e. cities, states, etc.) in conditional shortcodes eg: [wpgc_is_cities cities="one,two,three"]

= 1.0.4 =
* Fix readme

= 1.0.3 =
* Update MaxMind GeoLiteCity Database to Oct 1, 2012

= 1.0.2 =
* Adding geoip.php

= 1.0.1 =
* Fixed errant nonce declaration which prevented the plugin from saving any options
* Updated GeoLiteCity Database to August 02, 2011
* Removed extraneous copy of GeoLiteCity Database

= Version 1.0.0 =
* Initial Release

== Upgrade Notice ==

= 1.0.1 =
Upgrade to fix problem saving options.  Version 1.0.0 would not permit saving any option values.

= 1.0.2 =
Added missing geoip.php include file

= 1.0.3 =
* Update Maxmind database

= 1.0.4 =
* Fix Readme

= 1.0.5 =
* Multiple location conditional shortcodes

= 1.0.6 =
* Fixed conditional shortcode for is_not_country_codes

= 1.0.7 =
* Upgrade for postal_code support

= 1.0.8 =
* Minor fixes

= 1.0.9 =
* Corrected wpgc_state_name to correctly show state name

= 1.0.10 =
* Updated Geocity database

= 1.0.11 =
* Updated GeoIP PHP Api Version

= 1.0.12 =
* Fixed missing requirement

= 1.0.13 =
* Updated for WP 4
