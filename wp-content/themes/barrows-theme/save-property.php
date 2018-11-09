<?php 

function saved_property_init(){ 

    wp_register_script('saved-property-script', get_stylesheet_directory_uri() . '/assets/js/save-property-script.js', array('jquery') ); 
    wp_enqueue_script('saved-property-script');

    wp_localize_script( 'saved-property-script', 'saved_property_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => '/my-account/',
        'loadingmessage' => __('Saving Property, please wait...')
    ));

    add_action( 'wp_ajax_nopriv_saved_property', 'saved_property' );
    add_action( 'wp_ajax_saved_property', 'saved_property' );

    add_action( 'wp_ajax_nopriv_delete_saved_property', 'delete_saved_property' );
    add_action( 'wp_ajax_delete_saved_property', 'delete_saved_property' );

}
add_action('init', 'saved_property_init');

function saved_property(){
    /* GLOBAL the wpdb command for database queries */
    global $wpdb;


    /* Get the data which has been sent by input fields */
    $user_id        = get_current_user_id();
    $property_id    = $_REQUEST['propid'];
    $name           = $_REQUEST['name'];
    $price          = $_REQUEST['price'];
    $photo          = $_REQUEST['photo'];

    /* Check if the property has already been saved and return number of rows in database */
    $checkSaved = $wpdb->get_var("SELECT COUNT(*) FROM wp_savedproperties WHERE UserID = $user_id AND PropertyID = '$property_id'");

    /* If the property is not already saved then insert into database */
    // if ($checkSaved <= 0)
    // {
            /* Insert the proerty into the saved properties table */
            $wpdb->insert('wp_savedproperties', 
            array(
              'UserID'          => $user_id,
              'PropertyID'      => $property_id,
              'PropertyName'    => $name,
              'PropertyPrice'   => $price,
              'PropertyPhoto'   => $photo
            ),
            array(
              '%s',
              '%s',
              '%s',
              '%s',
              '%s'
            ) 
          ); 
    // }

    /*

    $args = array(
        'post_type'  => 'saved_property', // or your_custom_post_type
        'meta_query' => array(
            'relation' => 'AND', //setting relation between queries group
            array(
                'key' => 'saved_property_user',
                'compare' => 'LIKE',
                'value' => $_POST['userid'],
            ),
            array(
                'key' => 'saved_property_property_id',
                'compare' => 'LIKE',
                'value' => $_POST['propid'],
            ),
        )
    );
    // create a custom query
    $my_query = new WP_Query( $args );
    $total = $my_query->found_posts;
    // echo $total;
    */

    if ($total > 0) {
        die();
    }else{
        // Get the book pod object 
        // To add a new item, let's set the data first 
        $user_id = get_current_user_id();
        $property_id = $_POST['propid'];
        $name = $_POST['name'];
        $price = $_POST['price'];
        $photo = $_POST['photo'];

        /*$my_post = array(
            'post_title'    => wp_strip_all_tags( $page ),
            'post_status'   => 'publish',
            'post_author'  => get_current_user_id(),
            'post_type' => 'saved_property',
            // 'meta_input' => array(
            //     'saved_property_user' => $user_id,
            //     'saved_property_property_id' => $property_id,
            //     'saved_property_name' => $name,
            //     'saved_property_price' => $price,
            //     'saved_property_photo' => $photo,
            // )
        );
        $post_id = wp_insert_post( $my_post );

        // update_field('saved_property_user', $user_id, $postID);
        // update_field('saved_property_property_id', $property_id, $postID);
        // update_field('saved_property_name', $name, $postID);
        // update_field('saved_property_price', $price, $postID);
        // update_field('saved_property_photo', $photo, $postID);

        update_post_meta( $post_id, 'saved_property_user', $user_id );
        update_post_meta( $post_id, 'saved_property_property_id', $property_id );
        update_post_meta( $post_id, 'saved_property_name', $name );
        update_post_meta( $post_id, 'saved_property_price', $price );
        update_post_meta( $post_id, 'saved_property_photo', $photo );*/
    }

    /* This is the output of whether the property is saved to the user or not */
    //echo $user_id;
    die();
}

function delete_saved_property(){

    wp_delete_post($_POST['post_id']);

    die();
}