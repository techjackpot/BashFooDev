Video SEO
=========
Requires at least: 4.6<br/>
Tested up to: 4.8<br/>
Stable tag: 5.1<br/>
Depends: wordpress-seo

Video SEO adds Video SEO capabilities to WordPress SEO.

Description
-----------

This plugin adds Video XML Sitemaps as well as the necessary OpenGraph markup, Schema.org videoObject markup and mediaRSS for your videos.

Installation
------------

1. Go to Plugins -> Add New.
2. Click "Upload" right underneath "Install Plugins".
3. Upload the zip file that this readme was contained in.
4. Activate the plugin.
5. Go to SEO -> Extensions and enter your license key.
6. Save settings, your license key will be validated. If all is well, you should now see the XML Video Sitemap settings.
7. Make sure to hit the "Re-index videos" button if you have videos in old posts.

Frequently Asked Questions
--------------------------

You can find the [Video SEO FAQ](https://kb.yoast.com/kb/category/video-seo/) in our knowledge base.

Changelog
=========
### 5.1: July 25th, 2017
* Fixes a bug where the `isFamilyFriendly` meta property is not set properly.

### 5.0: July 6th, 2017
* Compatibility with Yoast SEO 5.0.

### 4.9: June 7th, 2017
* Compatibility with Yoast SEO 4.9.

### 4.8: May 23rd, 2017
* Compatibility with Yoast SEO 4.8.

### 4.7: May 2nd, 2017
* Compatibility with Yoast SEO 4.7.

### 4.6: April 11th, 2017
* Compatibility with Yoast SEO 4.6.

### 4.5: March 21st, 2017
* Only invalidate sitemaps on configured post types.
* Fixes a bug where there was a fatal error thrown when the plugin was active without Yoast SEO or Yoast SEO Premium.

### 4.4: February 28th, 2017

* Adds a minimum and maximum value to the video rating field.
* Adds the `og:video:secure_url` meta tag.

### 4.3: February 14th, 2017

* Compatibility with Yoast SEO 4.3.

### 4.2.1: February 3rd, 2017

* Bugfixes
	* Fixes "Fatal error: Class 'yoast_i18n' not found". 

### 4.2: January 31st, 2017

* Bugfixes
	* Fixes translator comments that were missing or didn't follow the guidelines.

### 4.1: January 17th, 2017

* Bugfixes
    * Fixes link to google article about video sitemaps. 
    * Fixes a bug where the video-seo menu would overwrite the go premium menu item.
    * Fixes: If a post uses a custom title/description template with variables, the variables were not being replaced correctly for the Video sitemap.
    * Minor spelling & grammar fixes.
    * If a video was previously detected, but the post type has since been excluded from VideoSEO, the video opengraph and schema tags would still be added to the front-end page. This has been fixed now.
    * Fix case-sensitivity issues with video object meta tags.
    * Minor XHTML syntax fix.
    
* Enhancements
    * Improves styling for notices.
    * Minor improvements for compatibility with Yoast SEO.
    * Minor UI improvements for buttons and translations.
    * Add the video:duration tag to video page headers. 
    * Clarify what effect the option to allow videos to be embedded by other sites has.
    * Clarify the description of the "Family Friendly" option used in the metabox.
    * Improve support for the Yandex search engine by adding some Yandex specific tags. This can be turned off using the new wpseo_video_yandex_support filter (return false to turn it off).
    * Allow for adding additional schema meta tags - such as transcript to a video object using the new wpseo_video_object_meta_content filter.
    * Clarify the description for the family friendly checkbox.  

### 4.0: December 13th, 2016

* Fixes the YouTube video player URL to always use a protocol. This solves issues where the Google invalidates the sitemap and where Facebook does not recognize the player. (needs force re-index for existing posts)
