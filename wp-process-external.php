<?php

function adjust_link( $link_parts )
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



// based on https://regexr.com/3tjfs
function find_anchor_tags($content) {

    $pattern ="/<a(.*?)href=\"(.*?)\"(.*?)>/i";

    $content = preg_replace_callback( $pattern, 'adjust_link', $content );

    return $content;

}

add_filter('the_content', 'find_anchor_tags',11);
