<?php

// Filter the meta we get back on a post
function dspapi_post_info_meta_key_filter( $meta, $key, $image_size = 'thumb' ) {
    if($key[0] == "_" || empty($meta[0])){
      return false;
    }
    if(is_numeric($meta[0])){
      $img = wp_get_attachment_image_src($meta[0], $image_size);
      if($img){
        $image_obj = new stdClass;
        $image_obj->url = $img[0];
        $image_obj->width = $img[1];
        $image_obj->height = $img[2];
        $image_obj->generated = $img[3];
        $meta[0] = array('default'=>(int) $meta[0], 'image'=>$image_obj);
      } else {
        $meta[0] = (int) $meta[0];
      }
      return $meta;
    }
    return $meta;
}
add_filter( 'dspapi_post_info_meta_key_filter', 'dspapi_post_info_meta_key_filter', 9, 3 );