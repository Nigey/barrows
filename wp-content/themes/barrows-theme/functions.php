<?php 
include 'save-property.php';
include 'rezi-functions.php';

add_filter( 'shortcode_atts_wpcf7', 'custom_shortcode_atts_wpcf7_filter', 10, 3 );
 
function custom_shortcode_atts_wpcf7_filter( $out, $pairs, $atts ) {
    $my_attr = 'property';
 
    if ( isset( $atts[$my_attr] ) ) {
        $out[$my_attr] = $atts[$my_attr];
    }
 
    return $out;
}

    function get_saved_properties()
    {
        /* Get UserID to check if there are any properties saved */
        $userid = get_current_user_id();

        global $wpdb;

        $checkSaved = $wpdb->get_var("SELECT COUNT(*) FROM wp_savedproperties WHERE UserID = $userid");

        /* If the user does not have any saved properties then return false */
        if ($checkSaved <= 0)
        {
            return FALSE;
        } else {
            /* Properties have been found, get them and send array */
            $properties = $wpdb->get_results( "SELECT * FROM wp_savedproperties WHERE UserID = $userid" );
            return $properties;
        }
    }

//Page Slug Body Class
function add_slug_body_class( $classes ) {
global $post;
if ( isset( $post ) ) {
$classes[] = $post->post_type . '-' . $post->post_name;
}
return $classes;
}
add_filter( 'body_class', 'add_slug_body_class' );
function kryps_enqueue_scripts() {
      wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' );
      // wp_enqueue_style( 'nice-select-css', get_template_directory_uri().'/assets/css/nice-select.css' );
    wp_enqueue_style( 'font-awesome', get_stylesheet_directory_uri().'/assets/css/font-awesome.min.css' );
    wp_enqueue_style( 'font', 'https://fonts.googleapis.com/css?family=Poppins:400,700,900' );
    wp_enqueue_style( 'slick', get_stylesheet_directory_uri().'/assets/css/slick.css' );
    wp_enqueue_style( 'materialize', get_stylesheet_directory_uri().'/assets/css/materialize.css' );
    wp_enqueue_style( 'slick-theme', get_stylesheet_directory_uri().'/assets/css/slick-theme.css' );
    wp_enqueue_script( 'slick-js', get_stylesheet_directory_uri() . '/assets/js/slick.min.js', array( 'jquery' ),null,true );
    wp_enqueue_script( 'nice-select-js', get_stylesheet_directory_uri() . '/assets/js/jquery.nice-select.min.js', array( 'jquery' ),null,true );
    // wp_enqueue_script( 'materialize', get_stylesheet_directory_uri() . '/assets/js/materialize.min.js');
    wp_enqueue_script( 'main-js', get_stylesheet_directory_uri() . '/assets/js/barrows_forrester-0.1.0.min.js', array( 'jquery' ),null,true );
    // wp_enqueue_script( 'save-js', get_stylesheet_directory_uri() . '/assets/js/save-property-script.js', array( 'jquery' ),null,true );
    // wp_enqueue_script( get_stylesheet_directory_uri() . 'https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyB9nipQ6B_IBb_bQg0BzSkamspph78dul0&callback=initMap', array( 'jquery' ),null,true );
}
add_action( 'wp_enqueue_scripts', 'kryps_enqueue_scripts' );

function home_property() {
    $args = array(
        'posts_per_page' =>  3,
        'post_status' => 'publish',
        'post_type' => 'property',
        // 'meta_key' => 'property-price', //setting the meta_key which will be used to order
        'meta_key'   => 'featured',
        'meta_value' => 'true',
        'orderby' => 'meta_value', //if the meta_key (property-price) is numeric use meta_value_num instead
        'order' => 'DESC' //setting order direction
        // 'offset' => $a['offset']
    );

    $query = new WP_Query($args);

    if($query->have_posts()) :
        while($query->have_posts()) :

            $description = get_post_meta( get_the_ID(), 'property-description', TRUE );
            $postcode = get_post_meta( get_the_ID(), 'property-postcode', TRUE );
            $address1 = get_post_meta( get_the_ID(), 'property-address1', TRUE );
			$address2 = get_post_meta( get_the_ID(), 'property-address2', TRUE );
			$address3 = get_post_meta( get_the_ID(), 'property-address3', TRUE );
			$address4 = get_post_meta( get_the_ID(), 'property-address4', TRUE );
            $receptionrooms = get_post_meta( get_the_ID(), 'property-receptionrooms', TRUE );
            $bedrooms = get_post_meta( get_the_ID(), 'property-bedrooms', TRUE );
            $bathrooms = get_post_meta( get_the_ID(), 'property-bathrooms', TRUE );
            if(empty($bathrooms)) {
                $bathrooms = 0;
            }
            if(empty($bedrooms)) {
                $bedrooms = 0;
            }
            if(empty($receptionrooms)) {
                $receptionrooms = 0;
            }
            ob_start();
            the_content();
            $content = ob_get_clean();
            if (!empty($content)) {
                $content = substrwords($content,300);
            }
            
            $price = get_post_meta( get_the_ID(), 'property-price', TRUE );
            if (preg_match("(([A-Z]{1,2}[0-9]{1,2})($|[ 0-9]))", trim($postcode), $match)) {
               $postcode=$match[1];
            }

            if (has_post_thumbnail( $post->ID ) ): 
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                $imageURL = returnPropertyThumbnailURL($post->ID);
                else: 
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
            endif; 
            
            $name = $address1.', '. $address2 . ', ' . $postcode;

          $output = '

            <div style="background-image: url('.$image.')" class="et_pb_column et_pb_column_1_3">
                <div class="property-layout">
                    <div class="property-box box-hover">
                        <div class="property-price">£'.$price.'</div>
                        <div class="property-text hover-content">
                            <h4>'.$name.'</h4>
                            <a href="/property-details/?id='.$property->propertyID.'">View Property</a>
                        </div>
                    </div>
                </div>
            </div>

          ';
          // return $output;
        endwhile;
    endif;

    return $output;

    // -------------------------------------------------------------------------------
    // This is what was here before I modifed it, above is what I started pulling from
    // -------------------------------------------------------------------------------

    // $output = $output . '
    //     <div style="background-image: url('.$image.')" class="et_pb_column et_pb_column_1_3">
    //         <div class="property-layout">
    //             <div class="property-box box-hover">
    //                 <div class="property-price">£'.$price.'</div>
    //                 <div class="property-text hover-content">
    //                     <h4>'.$property_name.'</h4>
    //                     <a href="/property-details/?id='.$property->propertyID.'">View Property</a>
    //                 </div>
    //             </div>
    //         </div>
    //     </div>
    // ';
    // }
    //     return $output;

}
add_shortcode( 'home_featured_property', 'home_property' );



function display_properties_func( $atts ){
    $a = shortcode_atts( array(
        'offset' => 0,
        'display' => 3,
    ), $atts );

    $args = array(
        'posts_per_page' =>  $a['display'],
        'post_status' => 'publish',
        'post_type' => 'property',
        'meta_key'   => 'featured',
        'meta_value' => 'true',
        'orderby' => 'meta_value', //if the meta_key (property-price) is numeric use meta_value_num instead
        'order' => 'DESC', //setting order direction
        // 'offset' => $a['offset'],
        // 'tax_query' => array(
        //     array (
        //         'taxonomy' => 'selling_type',
        //         'field' => 'slug',
        //         'terms' => 'for-sale',
        //     )
        // ),
    );

    $query = new WP_Query($args);

    $property_html = "";

    $property_count = 1;

    if($query->have_posts()) :
        while($query->have_posts()) :
            global $user;
            global $post;
            $query->the_post();

            $user_id = get_current_user_id();

            $description = get_post_meta( get_the_ID(), 'property-description', TRUE );
            $postcode = get_post_meta( get_the_ID(), 'property-postcode', TRUE );
            $address1 = get_post_meta( get_the_ID(), 'property-address1', TRUE );
			$address2 = get_post_meta( get_the_ID(), 'property-address2', TRUE );
			$address3 = get_post_meta( get_the_ID(), 'property-address3', TRUE );
			$address4 = get_post_meta( get_the_ID(), 'property-address4', TRUE );
            $receptionrooms = get_post_meta( get_the_ID(), 'property-receptionrooms', TRUE );
            $bedrooms = get_post_meta( get_the_ID(), 'property-bedrooms', TRUE );
            $bathrooms = get_post_meta( get_the_ID(), 'property-bathrooms', TRUE );
            if(empty($bathrooms)) {

                $bathrooms = 0;

            }
            if(empty($bedrooms)) {
                $bedrooms = 0;
            }
            if(empty($receptionrooms)) {
                $receptionrooms = 0;
            }
            ob_start();
            the_content();
            $content = ob_get_clean();

            if (!empty($content)) {

                $content = substrwords($content,300);

            }
            
            $address1 = preg_replace('/^[^,]*,\s*/', '', $address1);

            $name = $address1.', '. $address2 . ', ' . $postcode;
            $price = get_post_meta( get_the_ID(), 'property-price', TRUE );
            $price = number_format($price);
            $latitude = get_post_meta( get_the_ID(), 'property-latitude', TRUE );
            $longitude = get_post_meta( get_the_ID(), 'property-longitude', TRUE );

            if (has_post_thumbnail( $post->ID ) ): 
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                $imageURL = returnPropertyThumbnailURL($post->ID);
            else: 
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                $imageURL = returnPropertyThumbnailURL($post->ID);

            endif;

            $property_html .= '

            <div style="background-image: url('.$imageURL.')" class="et_pb_column et_pb_column_1_3">
                <div class="property-layout">
                    <div class="property-box box-hover">
                        <div class="property-price">£'.$price.'</div>
                        <div class="property-text hover-content">
                            <h4>'.$name.'</h4>
                            <a href="/property-details/?property_id='.$post->ID.'">View Property</a>
                        </div>
                    </div>
                </div>
            </div>

            ';
            
        endwhile;
    endif;

    wp_reset_query();

    ob_start();
    ?> <?php echo $property_html; ?> <?php
    return ob_get_clean();
}
add_shortcode( 'display_properties', 'display_properties_func' );

function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  }	
  $excerpt = preg_replace('`[[^]]*]`','',$excerpt);
  return $excerpt;
}
 
function content($limit) {
  $content = explode(' ', get_the_content(), $limit);
  if (count($content)>=$limit) {
    array_pop($content);
    $content = implode(" ",$content).'...';
  } else {
    $content = implode(" ",$content);
  }	
  $content = preg_replace('/[.+]/','', $content);
  $content = apply_filters('the_content', $content); 
  $content = str_replace(']]>', ']]&gt;', $content);
  return $content;
}

?>