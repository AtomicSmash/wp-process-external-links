<?php
/*
Plugin Name: WP - Process external links
Plugin URI: https://atomicsmash.co.uk
Description: Process external links output by the_content and adds 'no-follow' and 'no-opener'
Author: Atomic Smash
Version: 0.0.1
Author URI: http://atomicsmash.co.uk
*/

// Regex find anchor tags based on https://regexr.com/3tjfs
// Then pass results to adjust_link
function wp_pel_find_anchor_tags($content)
{

    $pattern ="/<a(.*?)href=\"(.*?)\"(.*?)>/i";

    $content = preg_replace_callback( $pattern, 'wp_pel_adjust_link', $content );

    return $content;

}

// Process links to work out if links are internal or external, then adjust accordingly
function wp_pel_adjust_link( $link_parts )
{

    global $wp_query,$post;

    // echo "<pre>";
    // print_r($post->post_type);
    // echo "</pre>";
    // die();

    if ( is_array( $link_parts )) {
        $site_url = home_url();
        $link_type = 'external';

        $found = false;

        $pos = strpos( $link_parts[2], $site_url );

        // if the site_url is not found in the link URL, modify the '<a' link with external parameters
        if ($pos === false) {
            return "<strong>EXTERNAL LINK FOUND</strong><a". $link_parts[1] ."href='".$link_parts[2]."'".$link_parts[3]." rel='no-follow'>";
        }else{
            return "<strong>INTERNAL LINK FOUND</strong><a". $link_parts[1] ."href='".$link_parts[2]."'".$link_parts[3]." rel='no-follow'>";

            // Return default link
            // return $link_parts[0];

        }

    }

    return $link_parts[0];

}


add_filter('the_content', 'wp_pel_find_anchor_tags',11);
