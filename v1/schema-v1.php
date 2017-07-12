<?php

class dspapi_schema {

  function dspapi_get_posts_condensed_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'posts_condensed',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'page' => array(
                  'description'  => esc_html__( 'The number of the page of results.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
              'per_page' => array(
                  'description'  => esc_html__( 'The number of results per page.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
              'type' => array(
                  'description'  => esc_html__( 'The type of the post requested.  Defaults to any.', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
          ),
      );

      return $schema;
  }

  function dspapi_get_post_condensed_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'post_condensed',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'id' => array(
                  'description'  => esc_html__( 'Unique ID of the post.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
          ),
      );

      return $schema;
  }

  function dspapi_get_category_by_slug_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'cat_by_slug',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'slug' => array(
                  'description'  => esc_html__( 'The category slug.', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
          ),
      );

      return $schema;
  }

  function dspapi_search_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'search',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'search' => array(
                  'description'  => esc_html__( 'The search string.', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
          ),
      );

      return $schema;
  }

  function dspapi_get_featured_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_featured',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_random_by_type_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_random_by_type',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'type' => array(
                  'description'  => esc_html__( 'The post type to return', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
              'count' => array(
                  'description'  => esc_html__( 'Number of random posts to return', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
          ),
      );

      return $schema;
  }

  function dspapi_get_random_by_type_with_category_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_random_by_type_with_category',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'type' => array(
                  'description'  => esc_html__( 'The post type to return', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
              'category' => array(
                  'description'  => esc_html__( 'The category of the posts to return', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
              'count' => array(
                  'description'  => esc_html__( 'Number of random posts to return', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
          ),
      );

      return $schema;
  }


}