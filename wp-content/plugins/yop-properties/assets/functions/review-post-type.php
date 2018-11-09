<?php 

// Register the Custom Review Post Type
 
function register_cpt_review() {
 
    $labels = array(
        'name' => _x( 'Reviews', 'review' ),
        'singular_name' => _x( 'Review', 'review' ),
        'add_new' => _x( 'Add New', 'review' ),
        'add_new_item' => _x( 'Add New Review', 'review' ),
        'edit_item' => _x( 'Edit Review', 'review' ),
        'new_item' => _x( 'New Review', 'review' ),
        'view_item' => _x( 'View Review', 'review' ),
        'search_items' => _x( 'Search Reviews', 'review' ),
        'not_found' => _x( 'No review found', 'review' ),
        'not_found_in_trash' => _x( 'No review found in Trash', 'review' ),
        'parent_item_colon' => _x( 'Parent Review:', 'review' ),
        'menu_name' => _x( 'Reviews', 'review' ),
    );
 
    $args = array(
        'labels' => $labels,
        'hierarchical' => true,
        'description' => 'Reviews',
        'supports' => array( 'title', 'editor', 'author', 'thumbnail', 'trackbacks', 'custom-fields', 'comments', 'revisions', 'page-attributes' ),
        'taxonomies' => array( 'review_type' ),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'menu_icon' => 'dashicons-format-quote',
        'show_in_nav_menus' => true,
        'publicly_queryable' => true,
        'exclude_from_search' => false,
        'has_archive' => true,
        'query_var' => true,
        'can_export' => true,
        'rewrite' => true,
        'capability_type' => 'post'
    );
 
    register_post_type( 'review', $args );
}
 
add_action( 'init', 'register_cpt_review' );

function yop_review_meta_box_enqueues($hook) {
	global $post_type;
	if ( 'post.php' == $hook || 'post-new.php' == $hook ) {
		wp_enqueue_style('settings-css', '/wp-content/plugins/yop-properties/assets/css/settings.css');
		wp_enqueue_style('settings-js', '/wp-content/plugins/yop-properties/assets/js/settings.js');

	}
}
add_action('admin_enqueue_scripts', 'yop_review_meta_box_enqueues');
function yop_review_meta_boxes(){
	add_meta_box( 'yop_review_main_meta', __( 'Review Information', 'yop-review' ), 'review_main_meta_callback', 'review', 'normal', 'high' );
}
add_action( 'add_meta_boxes', 'yop_review_meta_boxes' );

/**
 * Outputs the content of the main meta box
 */

function review_main_meta_callback( $post ) {
	wp_nonce_field( basename( __FILE__ ), 'review_main_nonce' );
	$review_stored_meta = get_post_meta( $post->ID );
	?>

	<div class="container half" id="yop_property_main_meta">
		<h3>Review Details</h3>
		<div class="review-row">
			<div class="review-row-content">
				<label for="review-name"><?php _e( 'Review Name', 'yop-review' )?></label>
				<input type="text" name="review-name" id="review-name" value="<?php if ( isset ( $review_stored_meta['review-name'] ) ) echo $review_stored_meta['review-name'][0]; ?>" />
			</div>
		</div>
		<div class="review-row">
			<div class="review-row-content">
				<label for="review-date"><?php _e( 'Review Date', 'yop-review' )?></label>
				<input type="text" name="review-date" id="review-date" value="<?php if ( isset ( $review_stored_meta['review-date'] ) ) echo $review_stored_meta['review-date'][0]; ?>" />
			</div>
		</div>
		<div class="review-row">
			<div class="review-row-content">
				<label for="review-rating"><?php _e( 'Review rating', 'yop-review' )?></label>
				<input type="range" min="1" max="5" step="1" list="tickmarks"  name="review-rating" id="review-rating" value="<?php if ( isset ( $review_stored_meta['review-rating'] ) ) echo $review_stored_meta['review-rating'][0]; ?>" oninput="outputUpdate(value)" />
				<output for="review-rating" id="stars"><?php if ( isset ( $review_stored_meta['review-rating'] ) ) echo $review_stored_meta['review-rating'][0]; ?></output>
				<datalist id="tickmarks">
				  <option value="1" label="20%"><p>1</p>
				  <option value="2" label="40%">
				  <option value="3" label="60%">
				  <option value="4" label="80%">
				  <option value="5" label="100%">
				</datalist>
			</div>
		</div>
		<script type="text/javascript">
			function outputUpdate(vol) {
				document.querySelector('#stars').value = vol;
			}
		</script>
	</div>
<?php
}

/**
 * Saves the custom team meta input
 */
function yop_properties_review_meta_save( $post_id ) {
 
	// Checks save status
	$is_autosave = wp_is_post_autosave( $post_id );
	$is_revision = wp_is_post_revision( $post_id );
	$is_valid_nonce = ( isset( $_POST[ 'yop_properties_review_main_nonce' ] ) && wp_verify_nonce( $_POST[ 'yop_properties_review_main_nonce' ], basename( __FILE__ ) ) ) ? 'true' : 'false';

	// Exits script depending on save status
	if ( $is_autosave || $is_revision || !$is_valid_nonce ) {
		return;
	}

	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'review-name' ] ) ) {
		update_post_meta( $post_id, 'review-name', $_POST[ 'review-name' ] );
	} else {
		delete_post_meta( $post_id, 'review-name' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'review-date' ] ) ) {
		update_post_meta( $post_id, 'review-date', $_POST[ 'review-date' ] );
	} else {
		delete_post_meta( $post_id, 'review-date' );
	}
	// Checks for input and sanitizes/saves if needed
	if( isset( $_POST[ 'review-date' ] ) ) {
		update_post_meta( $post_id, 'review-rating', $_POST[ 'review-rating' ] );
	} else {
		delete_post_meta( $post_id, 'review-rating' );
	}

}
add_action( 'save_post', 'yop_properties_review_meta_save' );


?>