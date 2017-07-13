# dotstudioPRO Wordpress API routes for React

A Wordpress plugin that has all of the API routes used by React for data delivery.

## Getting Started

Download the zip file and install as a plugin via Wordpress Admin

### Prerequisites

Wordpress >= 4.5

### Installing

Upload the zip file via the Plugin menu > Add Plugin

## Built With

* [Wordpress](http://www.wordpress.org) - CMS
* [Swagger Generator](https://github.com/starfishmod/WPAPI-SwaggerGenerator) - A Swagger-based generator class for parsing the API endpoints into something readable. Used in conjunction with [Swagger UI Theme](https://github.com/dufabricio/WP-SwaggerUI/tree/master/wordpress/wp-content/themes/swaggertheme) to get a Swagger theme working on Wordpress.
* [Plugin Update Checker](https://github.com/YahnisElsts/plugin-update-checker) - A really simple plugin update checker that also has a server-side component that makes the process really fluid.

## Authors

* **Matt Armstrong** - [dotstudioPRO](https://dotstudiopro.com)

## Namespace

API Namespace: dsp/{version}, i.e. dsp/v1

*Current Version*: `v1`

## Output filters:

`dspapi_post_info_meta_key_filter`: Filter individual meta properties.  This filter exists within a `foreach($meta_array = $key => $meta)` loop.
*Args*: `$meta`, `$key`, `$image_size='thumb'`

`dspapi_post_filter`: Filter post object.  This filter provides the entire `$post` object after `meta` and various other properties have been added to it.
*Args*: `$post`
