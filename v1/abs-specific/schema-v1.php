<?php

class dspapi_abs_schema {

  function dspapi_get_featured_home_video_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_featured_home_video',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_featured_home_carousel_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_featured_home_carousel',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_featured_blog_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_featured_blog',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_featured_show_carousel_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_featured_show_carousel',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_featured_show_sections_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_featured_show_sections',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_show_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_show',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_host_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_host',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_contestant_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_contestant',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'id' => array(
                  'description'  => esc_html__( 'ID of the contestant post.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_contestants_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_contestants',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_judge_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_judge',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'id' => array(
                  'description'  => esc_html__( 'ID of the judge post.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_judges_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_judges',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_look_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_look',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'id' => array(
                  'description'  => esc_html__( 'ID of the look post.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_looks_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_looks',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_looks_by_taxonomy_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_looks',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
            'term' => array(
                  'description'  => esc_html__( 'The term of the look taxonomy', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_tutorial_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_tutorial',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'id' => array(
                  'description'  => esc_html__( 'ID of the tutorial post.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_tutorials_by_taxonomy_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_tutorials',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
            'term' => array(
                  'description'  => esc_html__( 'The term of the tutorial taxonomy', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_tutorials_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_tutorials',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_article_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_article',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'id' => array(
                  'description'  => esc_html__( 'ID of the article post.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_articles_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_articles',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_articles_by_taxonomy_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_articles',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
            'term' => array(
                  'description'  => esc_html__( 'The term of the article taxonomy', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_aired_episode_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_aired_episode',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'id' => array(
                  'description'  => esc_html__( 'ID of the aired_episode post.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_aired_episodes_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_aired_episodes',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_last_episode_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_last_episode',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_schedules_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_last_episode',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_schedules_by_range_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_last_episode',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'start' => array(
                  'description'  => esc_html__( 'The initial date (timestamp in seconds) for getting schedules', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              ),
              'end' => array(
                  'description'  => esc_html__( 'The final date (timestamp in seconds) for getting schedules', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_contest_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_contest',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
              'id' => array(
                  'description'  => esc_html__( 'ID of the contest post.', 'my-textdomain' ),
                  'type'         => 'integer',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_page_contests_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_contests',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

  function dspapi_get_page_contests_by_taxonomy_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_page_contests',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(
            'term' => array(
                  'description'  => esc_html__( 'The term of the contest taxonomy', 'my-textdomain' ),
                  'type'         => 'string',
                  'context'      => array( 'view', 'edit', 'embed' ),
                  'readonly'     => true,
              )
          ),
      );

      return $schema;
  }

  function dspapi_get_blog_featured_details_schema(){
    $schema = array(
          // This tells the spec of JSON Schema we are using which is draft 4.
          '$schema'              => 'http://json-schema.org/draft-04/schema#',
          // The title property marks the identity of the resource.
          'title'                => 'get_blog_featured_details',
          'type'                 => 'object',
          // In JSON Schema you can specify object properties in the properties attribute.
          'properties'           => array(),
      );

      return $schema;
  }

}