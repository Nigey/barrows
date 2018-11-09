<?php 

function get_local_file_contents( $file_path ) {
    ob_start();
    // include $file_path;
    require_once($file_path);
    $contents = ob_get_clean();

    return $contents;
}

function substrwords($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $output = '';
        $i      = 0;
        while (1) {
            $length = strlen($output)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $output .= " " . $words[$i];
                ++$i;
            }
        }
        $output .= $end;
    } 
    else {
        $output = $text;
    }
    return $output;
}

function returnPropertyList($api){
    $default = '<select class="form-control" id="type" name="type"><option value="" title="">Property Type</option><option value="Terraced">Terraced</option><option value="Semi">Semi</option><option value="Detached">Detached</option><option value="Bungalow">Bungalow</option><option value="Flat">Flat</option><option value="Commercial">Commercial</option><option value="Land">Land</option></select>';
    $rezi = '<select class="form-control" id="type" name="type"><option value="" title="">Property Type</option><option value="Terraced">Terraced</option><option value="Semi">Semi</option><option value="Detached">Detached</option><option value="Bungalow">Bungalow</option><option value="Flat">Flat</option><option value="Commercial">Commercial</option><option value="Land">Land</option></select>';
    $thesaurus = '<select class="form-control" id="type" name="type"><option value="" title="">Property Type</option><option value="Terraced">Terraced</option><option value="Mews">Mews</option><option value="Semi">Semi</option><option value="Detached">Detached</option><option value="Bungalow">Bungalow</option><option value="Flat">Flat</option><option value="Maisonette">Maisonette</option><option value="Commercial">Commercial</option><option value="Land">Land</option></select>';
    return $$api;
}

function property_search() {
    if ( empty($_POST) || !wp_verify_nonce($_POST['property_search'],'add_transfer') ) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        // do your function here 
        if (isset($_POST['selling_type']) && !empty($_POST['selling_type'])) {
            $selling_type     = $_POST['selling_type'];
        }else{
            $selling_type = "for-sale";
        }
        if ($selling_type == "for-sale") {
            if (isset($_POST['min_price']) && !empty($_POST['min_price'])) {
                $min_price = $_POST['min_price'];
                if (is_array ($min_price )) 
                {
                    $tempVal = $min_price[0];
                    if (!isset($tempVal) || $tempVal == "") { $tempVal = $min_price[1]; }
                    $min_price = $tempVal;
                }
            }else{
                $min_price = "";
            }
            if (isset($_POST['max_price']) && !empty($_POST['max_price'])) {
                $max_price = $_POST['max_price'];
                if (is_array ($max_price )) 
                {
                    $tempVal = $max_price[0];
                    if (!isset($tempVal) || $tempVal == "") { $tempVal = $max_price[1]; }
                    $max_price = $tempVal;
                }
            }else{
                $max_price = "";
            }
        }elseif ($selling_type == "for-rent") {
            if (isset($_POST['min_price']) && !empty($_POST['min_price'])) {
                $min_price        = $_POST['min_price'];
            }else{
                $min_price = "";
            }
            if (isset($_POST['max_price']) && !empty($_POST['max_price'])) {
                $max_price        = $_POST['max_price'];
            }else{
                $max_price = "";
            }
        }
        if (isset($_POST['min_beds']) && !empty($_POST['min_beds'])) {
            $min_beds         = $_POST['min_beds'];
        }else{
            $min_beds = "";
        }
        if (isset($_POST['price_order']) && !empty($_POST['price_order'])) {
            $price_order      = $_POST['price_order'];
        }else{
            $price_order = "";
        }
        if (isset($_POST['display_num']) && !empty($_POST['display_num'])) {
            $display_num      = $_POST['display_num'];
        }else{
            $display_num = "";
        }
        if (isset($_POST['type']) && !empty($_POST['type'])) {
            $type             = $_POST['type'];    
        }else{
            $type = "";
        }
        if (isset($_POST['location']) && !empty($_POST['location'])) {
            $location         = $_POST['location'];
        }else{
            $location = "";
        }
        // $show_under_offer = $_POST['show_under_offer'];

        $location = str_replace(' ', '%20', $location);

        $redirect_url_for_non_ajax_request = site_url().'/property-search?min_price=' . $min_price . '&max_price=' . $max_price . '&location=' . $location . '&price_order=' . $price_order . '&min_beds=' . $min_beds . '&selling_type=' . $selling_type . '&type=' . $type . '&display_num=' . $display_num . '';
        // echo $redirect_url_for_non_ajax_request;
        wp_redirect($redirect_url_for_non_ajax_request);
        exit();
    }
}
add_action( 'admin_post_nopriv_add_transfer', 'property_search' );
add_action( 'admin_post_add_transfer', 'property_search' );

function add_pages() {
    if ( empty($_POST) || !wp_verify_nonce($_POST['add_pages'],'add_page') ) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        // Create post object

        $options = get_option( 'yop_properties_settings' );

        $theme_option = $options['yop_properties_select_field_1'];

        $page_list = array( "Home", "About", "For Sale", "For Rent", "News", "Contact", "Property Search", "Property Details", "My Profile" );

        // Check if the menu exists
        $menu_name = 'Default Menu';
        $menu_exists = wp_get_nav_menu_object( $menu_name );

        // If it doesn't exist, let's create it.
        if( !$menu_exists){
            $menu_id = wp_update_nav_menu_object( 0, array( 'menu-name' => $menu_name, 'theme_location' => 'primary-menu', 'menu_id' => 'default-nav' ) );
        }

        foreach ($page_list as $page) {
            if ($page == "About") {
                $about_id = wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $page,
                    'menu-item-url' => '#',
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'custom', // optional
                ));
                $subpage_list = array( "About Us", "Meet the Team", "Reviews", "Buyers & Sellers" );
                foreach ($subpage_list as $sub_page) {
                    $subpage_slug = sanitize_title($sub_page);
                    
                    $html = get_local_file_contents("Template Designs/default/".$subpage_slug.".html");
                    $html = str_replace("<<<SITE_URL_TO_REPLACE>>>", site_url(), $html);

                    $my_post = array(
                      'post_title'    => wp_strip_all_tags( $sub_page ),
                      'post_status'   => 'publish',
                      'post_content'  => $html,
                      'post_author'  => get_current_user_id(),
                      'post_type' => 'page',
                    );
                    wp_insert_post( $my_post );

                    $post = get_page_by_title( $sub_page, OBJECT, 'page' );

                    wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' => $sub_page,
                        'menu-item-object-id' => $post->ID,
                        'menu-item-parent-id' => $about_id,
                        'menu-item-object' => 'page',
                        'menu-item-status' => 'publish',
                        'menu-item-type' => 'post_type',
                    ));
                }
            }elseif ($page == "For Sale" || $page == "For Rent") {
                $page_slug = sanitize_title($page);
                wp_update_nav_menu_item($menu_id, 0, array(
                    'menu-item-title' => $page,
                    'menu-item-url' => site_url().'/property-search/?selling_type='.$page_slug,
                    'menu-item-status' => 'publish',
                    'menu-item-type' => 'custom', // optional
                ));
            }else{
                if ($page == "Home") {
                    $html = get_local_file_contents("Template Designs/".$theme_option."/home.html");
                    $html = str_replace("<<<SITE_URL_TO_REPLACE>>>", site_url(), $html);
                    $my_post = array(
                      'post_title'    => wp_strip_all_tags( $page ),
                      'post_status'   => 'publish',
                      'post_content'  => $html,
                      'post_author'  => get_current_user_id(),
                      'post_type' => 'page',
                    );
                }else{
                    $page_slug = sanitize_title($page);
                    $html = get_local_file_contents("Template Designs/default/".$page_slug.".html");
                    $html = str_replace("<<<SITE_URL_TO_REPLACE>>>", site_url(), $html);
                    $my_post = array(
                      'post_title'    => wp_strip_all_tags( $page ),
                      'post_status'   => 'publish',
                      'post_content'  => $html,
                      'post_author'  => get_current_user_id(),
                      'post_type' => 'page',
                    );
                }
                 
                // Insert the post into the database
                wp_insert_post( $my_post );

                if ($page == "Property Details" || $page == "Property Search" || $page == "My Profile") {
                }else{
                    $post = get_page_by_path( $page, OBJECT, 'page' );

                    wp_update_nav_menu_item($menu_id, 0, array(
                        'menu-item-title' => $page,
                        'menu-item-object-id' => $post->ID,
                        'menu-item-object' => 'page',
                        'menu-item-status' => 'publish',
                        'menu-item-type' => 'post_type',
                    ));
                }
            }
        }

        $home = get_page_by_title( 'Home' );
        update_option( 'page_on_front', $home->ID );
        update_option( 'show_on_front', 'page' );

        $selling_types = array("For Sale", "Letting");
        foreach ($selling_types as $selling_type) {
            # code...
            $category_slug = sanitize_title($selling_type);
            wp_insert_term(
                $selling_type, // the term 
                'selling_type', // the taxonomy
                array(
                    'description'=> $selling_type,
                    'slug' => $category_slug
                )
            );
        }

        $redirect_url_for_non_ajax_request = site_url().'/wp-admin/admin.php?page=yop_properties';
        // echo $redirect_url_for_non_ajax_request;
        wp_redirect($redirect_url_for_non_ajax_request);
        exit();
    }
}
add_action( 'admin_post_nopriv_add_page', 'add_pages' );
add_action( 'admin_post_add_page', 'add_pages' );

 ?>