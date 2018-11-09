<?php 

// Register the Custom Property Post Type
 
function register_cpt_property() {
 
    $labels = array(
        'name' => _x( 'Properties', 'property' ),
        'singular_name' => _x( 'Property', 'property' ),
        'add_new' => _x( 'Add New', 'property' ),
        'add_new_item' => _x( 'Add New Property', 'property' ),
        'edit_item' => _x( 'Edit Property', 'property' ),
        'new_item' => _x( 'New Property', 'property' ),
        'view_item' => _x( 'View Property', 'property' ),
        'search_items' => _x( 'Search Properties', 'property' ),
        'not_found' => _x( 'No property found', 'property' ),
        'not_found_in_trash' => _x( 'No property found in Trash', 'property' ),
        'parent_item_colon' => _x( 'Parent Property:', 'property' ),
        'menu_name' => _x( 'Properties', 'property' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Properties',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'property_type' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-admin-multisite',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'property', $args );
}
 
add_action( 'init', 'register_cpt_property' );

//hook into the init action and call create_topics_nonhierarchical_taxonomy when it fires
 
add_action( 'init', 'create_topics_nonhierarchical_taxonomy', 0 );
 
function create_topics_nonhierarchical_taxonomy() {
 
// Labels part for the GUI
 
  $labels = array(
    'name' => _x( 'Selling Type', 'taxonomy general name' ),
    'singular_name' => _x( 'Selling Types', 'taxonomy singular name' ),
    'search_items' =>  __( 'Search Selling Types' ),
    'popular_items' => __( 'Popular Selling Types' ),
    'all_items' => __( 'All Selling Types' ),
    'parent_item' => null,
    'parent_item_colon' => null,
    'edit_item' => __( 'Edit Selling Type' ), 
    'update_item' => __( 'Update Selling Type' ),
    'add_new_item' => __( 'Add New Selling Type' ),
    'new_item_name' => __( 'New Selling Type Name' ),
    'separate_items_with_commas' => __( 'Separate Selling Type with commas' ),
    'add_or_remove_items' => __( 'Add or remove Selling Types' ),
    'choose_from_most_used' => __( 'Choose from the most used Selling Types' ),
    'menu_name' => __( 'Selling Type' ),
  ); 
 
// Now register the non-hierarchical taxonomy like tag
 
  register_taxonomy('selling_type','property',array(
    'hierarchical' => true,
    'labels' => $labels,
    'show_ui' => true,
    'show_admin_column' => true,
    'update_count_callback' => '_update_post_term_count',
    'query_var' => true,
    'rewrite' => array( 'slug' => 'selling_type' ),
  ));
}

function yop_property_meta_box_enqueues($hook) {
	global $post_type;
	if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
		if ( 'property' == $post_type ){
			wp_enqueue_style('settings-css', '/wp-content/plugins/yop-properties/assets/css/settings.css');
			wp_enqueue_script('meta-box-js', '/wp-content/plugins/yop-properties/assets/js/meta-box-rooms.js', array('jquery', 'jquery-ui-sortable'));
			wp_enqueue_script('settings-js', '/wp-content/plugins/yop-properties/assets/js/settings.js', array('jquery', 'jquery-ui-sortable'));
		}
	}
}
add_action('admin_enqueue_scripts', 'yop_property_meta_box_enqueues');
function yop_property_meta_boxes(){
	add_meta_box( 'yop_property_main_meta', __( 'Property Information', 'yop-property' ), 'property_main_meta_callback', 'property', 'normal', 'high' );
	add_meta_box( 'yop_property_room_meta', __( 'Room Information', 'yop-property' ), 'gnd_project_main_meta_cb', 'property', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'yop_property_meta_boxes' );

/**
 * Outputs the content of the main meta box
 */

function property_main_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'property_main_nonce' );
	$property_stored_meta = get_post_meta( $post->ID );
	?>

	<div class="address_details container half">
		<h3>Address Details</h3>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-address1"><?php _e( 'Address 1', 'yop-property' )?></label>
				<input type="text" name="property-address1" id="property-address1" value="<?php if ( isset ( $property_stored_meta['property-address1'] ) ) echo $property_stored_meta['property-address1'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-address2"><?php _e( 'Address 2', 'yop-property' )?></label>
				<input type="text" name="property-address2" id="property-address2" value="<?php if ( isset ( $property_stored_meta['property-address2'] ) ) echo $property_stored_meta['property-address2'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-address3"><?php _e( 'Address 3', 'yop-property' )?></label>
				<input type="text" name="property-address3" id="property-address3" value="<?php if ( isset ( $property_stored_meta['property-address3'] ) ) echo $property_stored_meta['property-address3'][0]; ?>" />
				<span class="helper">This is searched by the Location input on the property search form.</span>
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-address4"><?php _e( 'Address 4', 'yop-property' )?></label>
				<input type="text" name="property-address4" id="property-address4" value="<?php if ( isset ( $property_stored_meta['property-address4'] ) ) echo $property_stored_meta['property-address4'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-postcode"><?php _e( 'Postcode', 'yop-property' )?></label>
				<input type="text" name="property-postcode" id="property-postcode" value="<?php if ( isset ( $property_stored_meta['property-postcode'] ) ) echo $property_stored_meta['property-postcode'][0]; ?>" />
				<span class="helper">This is searched by the Location input on the property search form.</span>
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-country"><?php _e( 'Country', 'yop-property' )?></label>
				<input type="text" name="property-country" id="property-country" value="<?php if ( isset ( $property_stored_meta['property-country'] ) ) echo $property_stored_meta['property-country'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-latitude"><?php _e( 'Latitude', 'yop-property' )?></label>
				<input type="text" name="property-latitude" id="property-latitude" value="<?php if ( isset ( $property_stored_meta['property-latitude'] ) ) echo $property_stored_meta['property-latitude'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-longitude"><?php _e( 'Longitude', 'yop-property' )?></label>
				<input type="text" name="property-longitude" id="property-longitude" value="<?php if ( isset ( $property_stored_meta['property-longitude'] ) ) echo $property_stored_meta['property-longitude'][0]; ?>" />
			</div>
		</div>
		<h3>Branch Details</h3>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-branch"><?php _e( 'branch', 'yop-property' )?></label>
				<input type="text" name="property-branch" id="property-branch" value="<?php if ( isset ( $property_stored_meta['property-branch'] ) ) echo $property_stored_meta['property-branch'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-branch_telephone"><?php _e( 'branch_telephone', 'yop-property' )?></label>
				<input type="text" name="property-branch_telephone" id="property-branch_telephone" value="<?php if ( isset ( $property_stored_meta['property-branch_telephone'] ) ) echo $property_stored_meta['property-branch_telephone'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-branch_email"><?php _e( 'branch_email', 'yop-property' )?></label>
				<input type="text" name="property-branch_email" id="property-branch_email" value="<?php if ( isset ( $property_stored_meta['property-branch_email'] ) ) echo $property_stored_meta['property-branch_email'][0]; ?>" />
			</div>
		</div>
	</div>
	<div class="property_details container half">
		<h3>Property Details</h3>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-price"><?php _e( 'price', 'yop-property' )?></label>
				<input type="text" name="property-price" id="property-price" value="<?php if ( isset ( $property_stored_meta['property-price'] ) ) echo $property_stored_meta['property-price'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-propertyownabletype"><?php _e( 'propertyownabletype', 'yop-property' )?></label>
				<input type="text" name="property-propertyownabletype" id="property-propertyownabletype" value="<?php if ( isset ( $property_stored_meta['property-propertyownabletype'] ) ) echo $property_stored_meta['property-propertyownabletype'][0]; ?>" />
				<span class="helper">This is the type of property (bungalow, detached, flat etc...)</span>
				<span class="helper">If no API is selected, the default types are: Terraced, Semi, Detached, Bungalow, Flat, Commercial, Land.</span>
		</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-state"><?php _e( 'state', 'yop-property' )?></label>
				<input type="text" name="property-state" id="property-state" value="<?php if ( isset ( $property_stored_meta['property-state'] ) ) echo $property_stored_meta['property-state'][0]; ?>" />
				<span class="helper">This is to declare whether the property is sold or not (for the search form).</span>
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-short-description"><?php _e( 'short-description', 'yop-property' )?></label>
				<?php 
					$settings = array( 'textarea_rows' => 5 );
					wp_editor(htmlspecialchars_decode( $property_stored_meta['property-short-description'][0]) , 'property-short-description', $settings);

				 ?>
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-receptionrooms"><?php _e( 'receptionrooms', 'yop-property' )?></label>
				<input type="text" name="property-receptionrooms" id="property-receptionrooms" value="<?php if ( isset ( $property_stored_meta['property-receptionrooms'] ) ) echo $property_stored_meta['property-receptionrooms'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-kitchens"><?php _e( 'kitchens', 'yop-property' )?></label>
				<input type="text" name="property-kitchens" id="property-kitchens" value="<?php if ( isset ( $property_stored_meta['property-kitchens'] ) ) echo $property_stored_meta['property-kitchens'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-bedrooms"><?php _e( 'bedrooms', 'yop-property' )?></label>
				<input type="text" name="property-bedrooms" id="property-bedrooms" value="<?php if ( isset ( $property_stored_meta['property-bedrooms'] ) ) echo $property_stored_meta['property-bedrooms'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-bathrooms"><?php _e( 'bathrooms', 'yop-property' )?></label>
				<input type="text" name="property-bathrooms" id="property-bathrooms" value="<?php if ( isset ( $property_stored_meta['property-bathrooms'] ) ) echo $property_stored_meta['property-bathrooms'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-bathroomsensuite"><?php _e( 'bathroomsensuite', 'yop-property' )?></label>
				<input type="text" name="property-bathroomsensuite" id="property-bathroomsensuite" value="<?php if ( isset ( $property_stored_meta['property-bathroomsensuite'] ) ) echo $property_stored_meta['property-bathroomsensuite'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-brochure"><?php _e( 'brochure', 'yop-property' )?></label>
				<input type="text" name="property-brochure" id="property-brochure" value="<?php if ( isset ( $property_stored_meta['property-brochure'] ) ) echo $property_stored_meta['property-brochure'][0]; ?>" />
			</div>
		</div>
		<div class="property-row">
			<div class="property-row-content">
				<label for="property-floorplan"><?php _e( 'floorplan', 'yop-property' )?></label>
				<input type="text" name="property-floorplan" id="property-floorplan" value="<?php if ( isset ( $property_stored_meta['property-floorplan'] ) ) echo $property_stored_meta['property-floorplan'][0]; ?>" />
			</div>
		</div>
	</div>
<?php
}

/**
* Outputs the content of the team side meta box
*/
function gnd_project_main_meta_cb( $post ){
	wp_nonce_field( basename( __FILE__ ), 'property_main_nonce' );
	// $project_stored_meta = get_post_meta( $post->ID );
	$gallery_ids = get_post_meta( $post->ID, 'meta-project-gallery-id', true );

	// echo "<pre>";
	// print_r($gallery_ids);
	// echo "</pre>";
?>

	<div class="portfolio-row">
		<div id="gallery-metabox" class="portfolio-col">
			<h3>Add Room</h3>
			<button class="gallery-add button" type="button" data-uploader-title="Add image(s) to project" data-uploader-button-text="Add image(s)">Add Room</button>
			<h3>Rooms</h3>
			<ul id="gallery-metabox-list">
			<?php if ($gallery_ids) : ?>
				<?php foreach ($gallery_ids as $gallery_img => $data) : $image = wp_get_attachment_image_src($data['id']); ?>
			  <li>
			    <input type="hidden" name="meta-project-gallery-id[<?php echo $gallery_img; ?>][id]" value="<?php echo $data['id']; ?>">
			    <img class="image-preview" src="<?php echo $image[0]; ?>">
			    <input type="text" name="meta-project-gallery-id[<?php echo $gallery_img; ?>][title]" value="<?php echo $data['title']; ?>">
			    <textarea name="meta-project-gallery-id[<?php echo $gallery_img; ?>][description]" style="width:100%;"><?php echo  $data['description']; ?></textarea>
			    <button class="change-image button button-small" type="button" data-uploader-title="Change image" data-uploader-button-text="Change image">Change image</button><br>
			    <small><button class="remove-image button button-small" type="button">Remove image</button></small>
			  </li>
			<?php endforeach; ?>
			<?php endif; ?>
			</ul>
		</div>
	</div>

<?php
}

/**
 * Saves the custom team meta input
 */
function yop_property_property_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'yop_property_property_main_nonce' ] ) && wp_verify_nonce( $_POST[ 'yop_property_property_main_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'meta-project-gallery-id' ] ) ) {
		update_post_meta( $post_id, 'meta-project-gallery-id', $_POST[ 'meta-project-gallery-id' ] );
	} else {
		delete_post_meta( $post_id, 'meta-project-gallery-id' );
	}
 
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-addressnumber' ] ) ) {
		update_post_meta( $post_id, 'property-addressnumber', $_POST[ 'property-addressnumber' ] );
	} else {
		delete_post_meta( $post_id, 'property-addressnumber' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-address1' ] ) ) {
		update_post_meta( $post_id, 'property-address1', $_POST[ 'property-address1' ] );
	} else {
		delete_post_meta( $post_id, 'property-address1' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-address2' ] ) ) {
		update_post_meta( $post_id, 'property-address2', $_POST[ 'property-address2' ] );
	} else {
		delete_post_meta( $post_id, 'property-address2' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-address3' ] ) ) {
		update_post_meta( $post_id, 'property-address3', $_POST[ 'property-address3' ] );
	} else {
		delete_post_meta( $post_id, 'property-address3' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-address4' ] ) ) {
		update_post_meta( $post_id, 'property-address4', $_POST[ 'property-address4' ] );
	} else {
		delete_post_meta( $post_id, 'property-address4' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-postcode' ] ) ) {
		update_post_meta( $post_id, 'property-postcode', $_POST[ 'property-postcode' ] );
	} else {
		delete_post_meta( $post_id, 'property-postcode' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-country' ] ) ) {
		update_post_meta( $post_id, 'property-country', $_POST[ 'property-country' ] );
	} else {
		delete_post_meta( $post_id, 'property-country' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-price' ] ) ) {
		update_post_meta( $post_id, 'property-price', $_POST[ 'property-price' ] );
	} else {
		delete_post_meta( $post_id, 'property-price' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-short-description' ] ) ) {
		update_post_meta( $post_id, 'property-short-description', $_POST[ 'property-short-description' ] );
	} else {
		delete_post_meta( $post_id, 'property-short-description' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-receptionrooms' ] ) ) {
		update_post_meta( $post_id, 'property-receptionrooms', $_POST[ 'property-receptionrooms' ] );
	} else {
		delete_post_meta( $post_id, 'property-receptionrooms' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-kitchens' ] ) ) {
		update_post_meta( $post_id, 'property-kitchens', $_POST[ 'property-kitchens' ] );
	} else {
		delete_post_meta( $post_id, 'property-kitchens' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-bedrooms' ] ) ) {
		update_post_meta( $post_id, 'property-bedrooms', $_POST[ 'property-bedrooms' ] );
	} else {
		delete_post_meta( $post_id, 'property-bedrooms' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-bathrooms' ] ) ) {
		update_post_meta( $post_id, 'property-bathrooms', $_POST[ 'property-bathrooms' ] );
	} else {
		delete_post_meta( $post_id, 'property-bathrooms' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-bathroomsensuite' ] ) ) {
		update_post_meta( $post_id, 'property-bathroomsensuite', $_POST[ 'property-bathroomsensuite' ] );
	} else {
		delete_post_meta( $post_id, 'property-bathroomsensuite' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-branch' ] ) ) {
		update_post_meta( $post_id, 'property-branch', $_POST[ 'property-branch' ] );
	} else {
		delete_post_meta( $post_id, 'property-branch' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-branch_telephone' ] ) ) {
		update_post_meta( $post_id, 'property-branch_telephone', $_POST[ 'property-branch_telephone' ] );
	} else {
		delete_post_meta( $post_id, 'property-branch_telephone' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-branch_email' ] ) ) {
		update_post_meta( $post_id, 'property-branch_email', $_POST[ 'property-branch_email' ] );
	} else {
		delete_post_meta( $post_id, 'property-branch_email' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-propertyownabletype' ] ) ) {
		update_post_meta( $post_id, 'property-propertyownabletype', $_POST[ 'property-propertyownabletype' ] );
	} else {
		delete_post_meta( $post_id, 'property-propertyownabletype' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-state' ] ) ) {
		update_post_meta( $post_id, 'property-state', $_POST[ 'property-state' ] );
	} else {
		delete_post_meta( $post_id, 'property-state' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-mainphoto' ] ) ) {
		update_post_meta( $post_id, 'property-mainphoto', $_POST[ 'property-mainphoto' ] );
	} else {
		delete_post_meta( $post_id, 'property-mainphoto' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-latitude' ] ) ) {
		update_post_meta( $post_id, 'property-latitude', $_POST[ 'property-latitude' ] );
	} else {
		delete_post_meta( $post_id, 'property-latitude' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-longitude' ] ) ) {
		update_post_meta( $post_id, 'property-longitude', $_POST[ 'property-longitude' ] );
	} else {
		delete_post_meta( $post_id, 'property-longitude' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-brochure' ] ) ) {
		update_post_meta( $post_id, 'property-brochure', $_POST[ 'property-brochure' ] );
	} else {
		delete_post_meta( $post_id, 'property-brochure' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'property-floorplan' ] ) ) {
		update_post_meta( $post_id, 'property-floorplan', $_POST[ 'property-floorplan' ] );
	} else {
		delete_post_meta( $post_id, 'property-floorplan' );
	}

}
add_action( 'save_post', 'yop_property_property_meta_save' );


?>