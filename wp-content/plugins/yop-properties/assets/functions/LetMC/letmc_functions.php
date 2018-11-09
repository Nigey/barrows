<?php 
function saved_property_init(){	

	wp_register_script('saved-property-script', get_template_directory_uri() . '/assets/js/save-property-script.js', array('jquery') ); 
    wp_enqueue_script('saved-property-script');

    wp_localize_script( 'saved-property-script', 'saved_property_object', array( 
        'ajaxurl' => admin_url( 'admin-ajax.php' ),
        'redirecturl' => 'http://brinkleys.co.uk/my-brinkleys/',
        'loadingmessage' => __('Saving Property, please wait...')
    ));

    add_action( 'wp_ajax_nopriv_saved_property', 'saved_property' );
    add_action( 'wp_ajax_saved_property', 'saved_property' );

    add_action( 'wp_ajax_nopriv_delete_saved_property', 'delete_saved_property' );
    add_action( 'wp_ajax_delete_saved_property', 'delete_saved_property' );

}
add_action('init', 'saved_property_init');

function grab_image($url,$saveto){
    if(file_exists($saveto)){
    }else{
        $ch = curl_init ($url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_BINARYTRANSFER,1);
        $raw=curl_exec($ch);
        curl_close ($ch);
        $fp = fopen($saveto,'x');
        fwrite($fp, $raw);
        fclose($fp);
    }
}

function saved_property(){
	// Get the book pod object 
	$pod = pods( 'saved_property' );
    // To add a new item, let's set the data first 
    $user_id = $_POST['userid'];
    $property_id = $_POST['propid'];

	$data = array( 
	    'user_id' => $user_id,
	    'property_id' => $property_id,
	    'post_status' => 'Publish',
	); 

	// Add the new item now and get the new ID 
	$saved_property = $pod->add( $data ); 
	
    die();
}

function delete_saved_property(){
	// Get the book item with an ID of 5 
    $pod_id = $_POST['pod_id'];

	$pod = pods( 'saved_property', $pod_id ); 

	// Delete the current pod item 
	$pod->delete(); 
	
    die();
}

function API_credentials(){
	$api_key = 'h-57tjCN5Be60ppmoZyS0lc497BFOL1OBqjydsZpZhY1';
	$shortname = 'brinkleys';
	return array($api_key, $shortname);
}
function get_results($url){
	$request = new WP_Http;
	$result = $request->request( $url );
	$json = $result['body'];
	$results=json_decode($json, TRUE);

	return $results;
}


// function get_property_listing( $offset, $page, $count ) {
// 	$url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/property/properties?offset='.$offset.'&count='.$count.'&api_key='.API_credentials()[0].'';

// 	$listings = get_results($url);

// 	return $listings;
// }

function get_branches( $count ) {
	$url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/branch/branches?offset=0&count='.$count.'&api_key='.API_credentials()[0].'';

	$branches = get_results($url);

	return $branches;
}

function get_single_image($id) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/photo/photos/'.$id.'?api_key='.API_credentials()[0].'';

    $single_photo = get_results($url);

    return $single_photo;
}

function get_sales_listing( $page, $count, $min_price, $max_price, $min_beds ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/sales/advertisedsales?branchID=0004-f421-2742-3f00&offset=0&count='.$count.'&onlyDevelopement=false&onlyInvestements=false&minimumPrice='.$min_price.'&maximumPrice='.$max_price.'&minimumBeds='.$min_beds.'&api_key='.API_credentials()[0].'';

    $listings = get_results($url);

    return $listings;
}
function get_sales_listing_images( $property_id, $count ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/sales/salesinstructions/'.$property_id.'/photos?offset=0&count='.$count.'&api_key='.API_credentials()[0].'';

    $photos = get_results($url);

    return $photos;
}
function get_single_sales_listing( $property_id ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/sales/salesinstructions/'.$property_id.'?api_key='.API_credentials()[0].'';

    $property_details = get_results($url);

    return $property_details;
}
function get_single_sales_listing_rooms( $property_id, $count ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/sales/salesinstructions/'.$property_id.'/rooms?offset=0&count='.$count.'&api_key='.API_credentials()[0].'';

    $property_rooms = get_results($url);

    return $property_rooms;
}
function get_single_sales_floor_plans( $property_id ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/sales/salesinstructions/'.$property_id.'/floorplans?offset=0&count=999&api_key='.API_credentials()[0].'';

    $property_floor_plans = get_results($url);

    return $property_floor_plans;
}



function get_lettings_listing( $count ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/lettings/advertised?branchID=0004-f421-2742-3f00&offset=0&count='.$count.'&api_key='.API_credentials()[0].'';

    $listings = get_results($url);

    return $listings;
}
function get_lettings_listing_single( $prop_id ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/property/properties/'.$prop_id.'?api_key='.API_credentials()[0].'';

    $prop_details = get_results($url);

    return $prop_details;
}
function get_lettings_images( $property_id, $count ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/property/properties/'.$property_id.'/photos?offset=0&count='.$count.'&api_key='.API_credentials()[0].'';

    $photos = get_results($url);

    return $photos;
}
function get_lettings_rooms( $property_id, $count ) {
    $url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/property/properties/'.$property_id.'/rooms?offset=0&count='.$count.'&api_key='.API_credentials()[0].'';

    $property_rooms = get_results($url);

    return $property_rooms;
}

function property_search() {
    if ( empty($_POST) || !wp_verify_nonce($_POST['property_search'],'add_transfer') ) {
        echo 'You targeted the right function, but sorry, your nonce did not verify.';
        die();
    } else {
        // do your function here 
        $min_beds   = $_POST['min_beds'];
        $min_price  = $_POST['min_price'];
        $max_price  = $_POST['max_price'];
        $type       = $_POST['type'];    
        $let_type   = $_POST['let_type'];
        $location   = $_POST['location'];

        if ($let_type == "1") {
            $redirect_url_for_non_ajax_request = 'http://brinkleys.co.uk/sales?min_beds=' . $min_beds . '&min_price=' . $min_price . '&max_price=' . $max_price . '&location=' . $location . '&type=' . $type;
        }elseif ($let_type == "2"){
            $redirect_url_for_non_ajax_request = 'http://brinkleys.co.uk/letting?min_beds=' . $min_beds . '&min_price=' . $min_price . '&max_price=' . $max_price . '&location=' . $location . '&type=' . $type;
        }
        // echo $redirect_url_for_non_ajax_request;
        wp_redirect($redirect_url_for_non_ajax_request);
        exit();
    }
}
add_action( 'admin_post_nopriv_add_transfer', 'property_search' );
add_action( 'admin_post_add_transfer', 'property_search' );