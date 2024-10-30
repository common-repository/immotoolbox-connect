=== ImmoToolBox Connect ===
Contributors: zebrasoft
Donate link:
Tags: immotoolbox, realestate, agency, property
Requires at least: 4.9
Tested up to: 6.5
Requires PHP: 5.9
Stable tag: 1.3.3
License: GPL3
License URI: https://www.gnu.org/licenses/gpl.html

ImmoToolBox Connect displays your properties from ImmoToolBox to your website made with WordPress. This plugin is compatible with Gutenberg blocks.

== Description ==
_ImmoToolBox Connect_ displays your properties from ImmoToolBox to your website made with WordPress.

This plugin offers an out of the box solution, but can also be highly customized to fit your theme and requirements.
Two Gutenberg blocks are available : "Property Listing" and "Property Search" (more to come)

PS : You need an [ImmoToolBox](https://intranet.immotoolbox.com) active account to use this plugin.

== Installation ==
1. Upload the plugin files to the `/wp-content/plugins/` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress
3. On [ImmoToolBox](https://intranet.immotoolbox.com) go to your agency settings page and generate an API Key from _External Apps_ tab.
4. On WordPress go to _ITB Connect_ menu to setup the plugin using this key

== Frequently Asked Questions ==

= Any Question ? =

Ask-us!

== Changelog ==

= 1.3 =
* Handle PHP versions up to 8.2
* New filter option for properties with price on request
* Fix carousel links

= 1.2 =
* Add handling of not found properties
* New visitor selection page
* Image for France DPE information
* Update french translations
* PHP version check (+5.6 minimum required)
* PDF Link in property details
* Error fix for WordPress < 5.0
* Fix url format
* Sort by Type,Country, City
* Fix contact button on mobile
* Option to disable SSL verification
* Add function `do_shortcode($content, $ignore_html = false)` in Twig to render shortcode from template
* Add search by district


= 1.1 =
* New Gutenberg blocks : "Property Listing", "Property Search", "Property Carousel"
* Optional Bootstrap JS/CSS
* Update and fix

= 1.0 =
* First stable version of the plugin
* WordPress 5.0 test

== Upgrade Notice ==
= 1.0 =
* First stable version of the plugin

== Help ==
## Pages created automatically

When this plugin is installed, 3 pages are automatically created

### Property details page
This page is used to display your properties' details.
By default only one is required but if your using a multilingual website you'll have to create of page for each language.
This page uses the `[itb_property]` shortcode

### Search results page
This page is used to display the search results when using a search engine.
This page uses the `[itb_searchresults]` shortcode (this shortcode uses the same parameters as the `[itb_listing]` shortcode)

### Visitor selection page
This page is used to display the properties added to his selection by the visitor.
This page uses the `[itb_selection]` shortcode (this shortcode uses the same parameters as the `[itb_listing]` shortcode)



## Custom pages


### Properties listing pages
You can add as many of this pages as you like. They display a paginated listing of all mathing properties which can be sorted.

#### Using the Gutenberg block :
You can use the "ImmoToolBox Property Listing" block to add the listing inside a page.
All the options of the listing are inside the Block Setting on the side bar.

#### Using the manual shortcode `[itb_listing]`
The Property Listing shortcode is `[itb_listing]`.
You can add it anywhere you want to add a listing inside a page.

Here are the shortcode parameters :

**Filter by type :**
Possible values are 'sale' or 'rental'
ex: `[itb_listing type="sale"]`

**Filter by country code :**
You have to use two-letter country codes
ex: `[itb_listing country="US"]`

**Of course you can combine this settings :**
ex: `[itb_listing type="rental" country="US"]`

**Order the results**
Possible values : date, price, area
ex: `[itb_listing type="sale" order="price" direction="desc"][/itb_listing]`

**Multi-lingual website**
If your website is multi-lingual, for each language (except WordPress main language) you have to add the parameters :
- property_page_id : the ID of the "Property details page" in the right language (you have to create this page)
- selection_page_id : the ID of the "Visitor selection page" in the right language (you have to create this page)

ex: `[itb_listing type="rental" country="US" property_page_id="123" selection_page_id="456"]`


### Slider of properties `[itb_carousel]`
This shortcode enable you to display properties inside another page with a slider

**8 properties for sale**
ex: `[itb_carousel type="sale" nbpp="8"]`

**Your properties marked as "selection" in ImmoToolBox**
ex: `[itb_carousel featured="1"]`

**Multi-lingual website**
See "Properties listing pages" information above

### Property Search engine

#### Using the Gutenberg block :
You can use the "ImmoToolBox Property Seach" block to add the search engine inside a page.
All the options of the search engine are inside the Block Setting on the side bar.

#### Using the manual shortcode `[itb_search]`
The Property Search shortcode is `[itb_search]`.

**An horizontal search engine**
ex: `[itb_search format="horizontal"]`

**Multi-lingual website**
If your website is multi-lingual, for each language (except WordPress main language) you have to add the parameter "searchresults_page_id"
Where the value of this parameter is the ID of a "Search results page" in the right language.
ex: `[itb_search format="horizontal" searchresults_page_id="123"]`


### Property details `[itb_property]`

This shortcode displays the details of the specified property. The property is either specified in the URL or directly inside the tag (`[itb_property id="123456"]`)

**Property not found**
It's possible to specify a page ID to which the visitor should be redirected when the requested property is not found using the parameter `notfound_page_id`.
ex: `[itb_property notfound_page_id="123"]`

## Advanced custom html generation
All the html content of this Gutenberg blocks and shortcodes are generated using [Twig](https://twig.symfony.com/) and can be totally customized.
By default the plugin will search for the files inside your theme directory (to avoid problems it's highly recommended to use a child theme)
The files must be located in the directory :
`/wp-content/themes/YOU-THEME-child/itb-connect/partials/`
