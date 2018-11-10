<?php get_header();

	$selling_type = $_GET['selling_type'];
	$minPrice = $_GET['minPrice'];
	$maxPrice = $_GET['maxPrice'];
	$location = $_GET['location'];
	$prop_type = $_GET['prop_type'];
	$minBeds = $_GET['minBeds'];
	$maxBeds = $_GET['maxBeds'];
	$include_sold = $_GET['include_sold'];

	if ($include_sold == "yes") $include_sold = true;
	else if ($include_sold == "no") $include_sold = false;
 
	$page = $_GET['page_'];
	$per_page = $_GET['per_page'];

	if( empty($per_page)) { $per_page = 3; }
	if (empty($page)) { $page = 1; }

	if ($include_sold === "yes") {
		$include_sold = "true";
	} else if ($include_sold === "no") {
		$include_sold = "false";
	}

	if (empty($minPrice)) { $minPrice = "0"; }
	if (empty($location)) { $location = false; }
	if (empty($maxPrice)) { $maxPrice = "9999999999"; }
	if (empty($minBeds)) { $minBeds = "0"; }
	if (empty($maxBeds)) { $maxBeds = "999"; }
	if (empty($per_page)) { $per_page = "9"; }

	// $xml = file_get_contents('http://services.jupix.co.uk/api/get_properties.php?clientID=cda934fd9f9ae99723dd1ade696d2143&passphrase=b556bed09f7d772a2f83aa05c256005a');

	// file_put_contents('property.xml', $xml);

	// $url_link = "property.xml";
	// $url_data = simplexml_load_file($url_link);
	// $total_count = count($url_data->property);

 	// foreach($url_data->property as $property) {

	// 	$price = $property->price;
	// 	$address1 = $property->addressName;
	// 	$address2 = $property->addressStreet;
	// 	$address3 = $property->address3;
	// 	$property_name = $address1 . ", " . $address2 . ", " . $address3;
	// 	$beds = $property->propertyBedrooms;

	// 	$results = stripos($property_name, $location);

	// 	if ($price > $minPrice && $price < $maxPrice) {
	// 		if ($beds >= $minBeds && $beds <= $maxBeds ) {
	// 			if ($location === false ){
	// 					$loop_times_search++;
	// 			} else {
	// 				if ($results !== false) {
	// 				    echo "<noscript>Found!</noscript>";
	// 					$loop_times_search++;
	// 				} else {
	// 				    echo "<noscript>not Found!</noscript>";
	// 				}
	// 			}
	// 		}
	// 	}
	// }

	// if ($loop_times_search == 0) {
	// 	$none_found = true;
	// }

$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;

if ($include_sold)
{
    $soldDecisionArr = 
    array(
                'relation' => 'OR', //setting relation between this inside query
                array(
                    'relation' => 'OR', //setting relation between this inside query
                    array(
                        'key' => 'underoffer',
                        'value' => '',
        	            'compare' => 'NOT EXISTS',
                    ),
                    array(
                        'key' => 'offeraccepted',
                        'value' => '',
        	            'compare' => 'NOT EXISTS',
                    ),
                ),
                array(
                    'relation' => 'OR', //setting relation between this inside query
                    array(
                        'key' => 'underoffer',
                        'value' => $include_sold,
        	            'compare' => '=',
                    ),
                    array(
                        'key' => 'offeraccepted',
                        'value' => $include_sold,
        	            'compare' => '=',
                    ),
                ),
            );
}
else
{
    $soldDecisionArr = 
    array(
        'relation' => 'AND', //setting relation between this inside query
        array(
            'key' => 'underoffer',
            'value' => '',
            'compare' => 'NOT EXISTS',
        ),
        array(
            'key' => 'offeraccepted',
            'value' => '',
            'compare' => 'NOT EXISTS',
        ),
    );
}
$args = array(

	'posts_per_page' => $per_page,
	'paged' => $paged,
	'post_status' => 'publish',
	'post_type' => 'property',
	 'tax_query' => array(

         array (
             'taxonomy' => 'selling_type',
             'field' => 'slug',
             'terms' => 'for-' . $selling_type,
        )
     ),

    'meta_key' => 'property-price', //setting the meta_key which will be used to order
    'orderby' => 'meta_value', //if the meta_key (property-price) is numeric use meta_value_num instead
    'order' => "ASC", //setting order direction
    'meta_query' => array(
        'relation' => 'AND', //setting relation between queries group
        array(
            'relation' => 'OR', //setting relation between this inside query
            array(
                'key' => 'property-postcode',
                'value' => $location,
	            'compare' => 'LIKE',
            ),
            array(
                'key' => 'property-address1',
                'value' => $location,
	            'compare' => 'LIKE',
            ),
            array(
                'key' => 'property-address2',
                'value' => $location,
	            'compare' => 'LIKE',
            ),
            array(
                'key' => 'property-postcode3',
                'value' => $location,
	            'compare' => 'LIKE',
            ),
            array(
                'key' => 'property-postcode4',
                'value' => $location,
	            'compare' => 'LIKE',
            )
        ),
        array(
            'key' => 'property-price',
            'value' => array($minPrice, $maxPrice),
            'compare' => 'BETWEEN',
            'type'    => 'numeric',
        ),
        $soldDecisionArr,
    )

);

$query = new WP_Query($args);
$total = $query->found_posts;
$how_many_times = $total / $per_page;
$how_many_pages = ceil($how_many_times);
?>

<div class="push_top">
	<div class="property-search_container">
		<div class="property-search">
			<form action="/wp-content/themes/barrows-theme/includes/search.php?per_page=<?php echo $per_page; ?>" method="post" name="searchForm">
				<div class="container">
					<h2 class="big bold">Property Search</h2>
					<div class="row">
						<div class="col l4 s12">
							<div class="search">
								<p>Location</p>
								<div class="search-wrapper card">
					       			<input name="location" placeholder="Location ( Example: Manchester )" id="search" tabindex="1">
					       			<div class="search-results"></div>
					      		</div>
					     	</div>
					    </div>
							<div class="col l4 s12">
								<div class="col l6 s12 sale-prices <?php if($selling_type == "rent" ) {echo "hide";} ?>">
									<p>Min Price</p>
								    <select name="minPrice" id="minPrice">
										<option value="" disabled selected>£   No Min</option>
										<option value="50000">£  50,000</option>
										<option value="100000">£  100,000</option>
										<option value="150000">£  150,000</option>
										<option value="200000">£  200,000</option>
										<option value="300000">£  300,000</option>
										<option value="400000">£  400,000</option>
										<option value="1000000">£  1,000,000</option>
										<option value="1500000">£  1,500,000</option>
										<option value="500000">£  500,000</option>
										<option value="600000">£  600,000</option>
										<option value="700000">£  700,000</option>
										<option value="800000">£  800,000</option>
										<option value="900000">£  900,000</option>
										<option value="2000000">£  2,000,000</option>
										<option value="2500000">£  2,500,000</option>
										<option value="3000000">£  3,000,000</option>
										<option value="3500000">£  3,500,000</option>
										<option value="4000000">£  4,000,000</option>
										<option value="4500000">£  4,500,000</option>
										<option value="5000000">£  5,000,000</option>
										<option value="5500000">£  5,500,000</option>
										<option value="6000000">£  6,000,000</option>
										<option value="6500000">£  6,500,000</option>
										<option value="7000000">£  7,000,000</option>
										<option value="7500000">£  7,500,000</option>
								    </select>
							 	</div>

								<div class="col l6 s12 sale-prices <?php if($selling_type == "rent" ) {echo "hide";} ?>">

									<p>Max Price</p>

								    <select name="maxPrice" id="maxPrice">
										<option value="" disabled selected>£   No Max</option>
										<option value="100000">£  100,000</option>
										<option value="150000">£  150,000</option>
										<option value="200000">£  200,000</option>
										<option value="300000">£  300,000</option>
										<option value="400000">£  400,000</option>
										<option value="500000">£  500,000</option>
										<option value="600000">£  600,000</option>
										<option value="700000">£  700,000</option>
										<option value="800000">£  800,000</option>
										<option value="900000">£  900,000</option>
										<option value="1000000">£  1,000,000</option>
										<option value="1500000">£  1,500,000</option>
										<option value="2000000">£  2,000,000</option>
										<option value="2500000">£  2,500,000</option>
										<option value="3000000">£  3,000,000</option>
										<option value="3500000">£  3,500,000</option>
										<option value="4000000">£  4,000,000</option>
										<option value="4500000">£  4,500,000</option>
										<option value="5000000">£  5,000,000</option>
										<option value="5500000">£  5,500,000</option>
										<option value="6000000">£  6,000,000</option>
										<option value="6500000">£  6,500,000</option>
										<option value="7000000">£  7,000,000</option>
										<option value="7500000">£  7,500,000</option>
								    </select>
							  </div>

								<div class="col l6 s12 rent-prices <?php if($selling_type == "sale" ) {echo "hide";} ?>">
									<p>Min Price</p>

								    <select  name="minPrice" id="minPrice">
										<option value="" disabled selected>£   No Min</option>
										<option value="200">£  200 PCM</option>
										<option value="300">£  300 PCM</option>
										<option value="400">£  400 PCM</option>
										<option value="500">£  500 PCM</option>
										<option value="600">£  600 PCM</option>
										<option value="700">£  700 PCM</option>
										<option value="800">£  800 PCM</option>
										<option value="900">£  900 PCM</option>
										<option value="1000">£  1000 PCM</option>
										<option value="1100">£  1100 PCM</option>
										<option value="1200">£  1200 PCM</option>
										<option value="1300">£  1300 PCM</option>
										<option value="1400">£  1400 PCM</option>
										<option value="1500">£  1500 PCM</option>
										<option value="1600">£  1600 PCM</option>
										<option value="1700">£  1700 PCM</option>
										<option value="1800">£  1800 PCM</option>
										<option value="1900">£  1900 PCM</option>
										<option value="2000">£  2000 PCM</option>
								    </select>
							  </div>

								<div class="col l6 s12 rent-prices <?php if($selling_type == "sale" ) {echo "hide";} ?>">

									<p>Max Price</p>

								    <select name="maxPrice" id="maxPrice">
										<option value="" disabled selected>£   No Max</option>
										<option value="300">£  300 PCM</option>
										<option value="400">£  400 PCM</option>
										<option value="500">£  500 PCM</option>
										<option value="600">£  600 PCM</option>
										<option value="700">£  700 PCM</option>
										<option value="800">£  800 PCM</option>
										<option value="900">£  900 PCM</option>
										<option value="1000">£  1000 PCM</option>
										<option value="1100">£  1100 PCM</option>
										<option value="1200">£  1200 PCM</option>
										<option value="1300">£  1300 PCM</option>
										<option value="1400">£  1400 PCM</option>
										<option value="1500">£  1500 PCM</option>
										<option value="1600">£  1600 PCM</option>
										<option value="1700">£  1700 PCM</option>
										<option value="1800">£  1800 PCM</option>
										<option value="1900">£  1900 PCM</option>
										<option value="2000">£  2000 PCM</option>
								    </select>
							  </div>
						</div>

						<div class="col l4 s12">
							<p>Property Type</p>
						    <select name="prop_type" id="prop_type">
								<option value="" disabled selected>Property Type</option>
								<option value="1">Bungalow</option>
								<option value="2">Commercial</option>
								<option value="3">Detached</option>
								<option value="3">End of Terrace</option>
								<option value="3">Flat/Apartment</option>
								<option value="3">Flat</option>
								<option value="3">Garage</option>
								<option value="3">Land</option>
								<option value="3">Maisonette</option>
								<option value="3">Mews House</option>
								<option value="3">Semi Detached</option>
								<option value="3">Town House</option>
						    </select>
					  	</div>
					</div>

				  	<div class="row">
						<div class="col l4 s12 center-align">
							<p class="">For Sale or Rent</p>
						  		<div class="">
							  		<div class="card radio-card">
									    <p class="sale_rent" data-type="sale" class="radio-p">
									    	<input name="group1" type="radio" id="sale" <?php if($selling_type == "sale"){echo "checked";} ?>  value="sale" />
									    	<label class="waves-effect" for="sale">For Sale</label>
									    </p>
								 	</div>

							  		<div class="card radio-card">
									    <p class="sale_rent" data-type="rent" class="radio-p">
										    <input name="group1" type="radio" id="rent" <?php if($selling_type == "rent"){echo "checked";} ?> value="rent"/>
										    <label class="waves-effect" for="rent">For Rent</label>
									    </p>
								 	</div>
								 </div>
						</div>

					<div class="col s12 l4">
							<div class="col l6 s12">
								<p>Minimum Beds</p>
								    <select name="minBeds" id="minBeds">
								      <option value="" disabled selected>Min Beds</option>
								      <option value="1">Studio</option>
								      <option value="1">1 Bed</option>
								      <option value="2">2 Beds</option>
								      <option value="3">3 Beds</option>
								      <option value="4">4 Beds</option>
								      <option value="5">5 Beds</option>
								      <option value="6">6 Beds</option>
								    </select>
							</div>

							<div class="col l6 s12">
								<p>Maximum Beds</p>
								    <select name="maxBeds" id="maxBeds">
								      <option value="" disabled selected>Max Beds</option>
								      <option value="1">Studio</option>
								      <option value="2">2 Beds</option>
								      <option value="3">3 Beds</option>
								      <option value="4">4 Beds</option>
								      <option value="5">5 Beds</option>
								      <option value="6">6 Beds</option>
								    </select>
						  	</div>
					</div>

			  		<div class="col l4 s12 center-align">
					  	<p>Include Sold?</p>
						  	<div class="card radio-card">
							    <p class="radio-p">
							      <input name="group2" type="radio" id="yes" value="yes"/>
							      <label class="waves-effect" for="yes">Yes</label>
							    </p>
							  </div>

						  	<div class="card radio-card">
							    <p class="radio-p">
							      <input name="group2" type="radio" id="no" value="no" checked/>
							      <label class="waves-effect" for="no">No</label>
							    </p>
						  </div>
					  	</div>
					</div>

					<div class="row flex">
						<input type="submit" name="submit" value="Submit" class="search_button btn btn-cen pink align-cen">
						<!-- <a class="btn btn-cen pink waves-effect">Submit</a> -->
					</div>
				</div>
			</form>
		</div>
	</div>

	<div class="tool_bar">
		<div class="per_page">
			<label>Properties Per Page</label>
			<div class="select_wrapper">

				<!-- <?php

					// $pass_variables_2 = "selling_type=".$selling_type."&minPrice=".$minPrice."&maxPrice=".$maxPrice ."&location=".$location."&per_page=".$per_page;

				 ?> -->

				<form action="../wp-content/themes/barrows-theme/includes/search.php?<?php echo $pass_variables_2; ?>" >

					<input type="hidden" name="selling_type" value="<?php echo $selling_type; ?>">
					<input type="hidden" name="minPrice" value="<?php echo $minPrice; ?>">
					<input type="hidden" name="maxPrice" value="<?php echo $maxPrice; ?>">
					<input type="hidden" name="location" value="<?php echo $location; ?>">

					<select onchange='this.form.submit()' name="per_page">
                        <option <?php if($per_page == 3){ echo "selected"; } ?> value="3">3</option>
						<option <?php if($per_page == 9){ echo "selected"; } ?> value="9">9</option>
						<option <?php if($per_page == 12){ echo "selected"; } ?> value="12">12</option>
						<option <?php if($per_page == 15){ echo "selected"; } ?> value="15">15</option>
						<option <?php if($per_page == 18){ echo "selected"; } ?> value="18">18</option>
						<option <?php if($per_page == 21){ echo "selected"; } ?> value="21">21</option>
					</select>
					<noscript><input type="submit" value="Submit"></noscript>
				</form>
			</div>
		</div>

		<div class="results_found">
			<h2>Displaying <?= $total; ?> Results</h2>
		</div>
	</div>

	<div class="property-results">
		<div class="row">
				<?php

					if($query->have_posts()) :

						while($query->have_posts()) :

						$query->the_post();
						$description = get_post_meta( get_the_ID(), 'property-description', TRUE );
						$postcode = get_post_meta( get_the_ID(), 'property-postcode', TRUE );
						$address1 = get_post_meta( get_the_ID(), 'property-address1', TRUE );
						$address2 = get_post_meta( get_the_ID(), 'property-address2', TRUE );
						$address3 = get_post_meta( get_the_ID(), 'property-address3', TRUE );
						$address4 = get_post_meta( get_the_ID(), 'property-address4', TRUE );
						$receptionrooms = get_post_meta( get_the_ID(), 'property-receptionrooms', TRUE );
						$bedrooms = get_post_meta( get_the_ID(), 'property-bedrooms', TRUE );
						$bathrooms = get_post_meta( get_the_ID(), 'property-bathrooms', TRUE );
						$underoffer = get_post_meta( get_the_ID(), 'underoffer', TRUE );
						$offeraccepted = get_post_meta( get_the_ID(), 'offeraccepted', TRUE );
						$displayForStatus = "visible";
						
                        if ($underoffer == null && $offeraccepted == null) $displayForStatus = "none";

						$statusForProperty = "";
						
                        if ($underoffer) $statusForProperty = "Under Offer";
                        if ($offeraccepted) $statusForProperty = "Offer Accepted";

                        if ($include_sold == "false" && $displayForStatus == "visible") continue; //Skip sold

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

						//echo $content;
						if (preg_match('(<p>.*[\r\n]?<\/p>)', $content, $matches)) { $content = $matches[0]; } //some descriptions break the page for some reason (Wordpresss bug), so I regex it all out

						if (!empty($content)) {
							$content = substrwords($content,300);
						}

						$address1 = preg_replace('/^[^,]*,\s*/', '', $address1);
				        $name = $address1.', '. $address2 . ', ' . $postcode;
						$price = get_post_meta( get_the_ID(), 'property-price', TRUE );
						$price = number_format($price);
						$latitude = get_post_meta( get_the_ID(), 'property-latitude', TRUE );
						$longitude = get_post_meta( get_the_ID(), 'property-longitude', TRUE );

					    if (preg_match("(([A-Z]{1,2}[0-9]{1,2})($|[ 0-9]))", trim($postcode), $match)) {
						   $postcode=$match[1];
						}

							 if (has_post_thumbnail( $post->ID ) ):
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
                                $imageURL = returnPropertyThumbnailURL($post->ID);

								// echo $imageURL;

								else:
								$image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );
								endif;
		?>

								<div class="col m4">
									<div class="single_property">
										<div class="property_image" style="background-image: url('<?php echo $imageURL; ?>')">
										    <div class="property_status" style="display: <?php echo $displayForStatus ?>"><?php echo $statusForProperty ?></div>
										</div>
										<div class="property_content">
											<h2 class="title"><?php echo $name; ?></h2>
											<h3 class="price"><span class="left">£ <?php echo $price; if($selling_type == "rent") { echo " PCM"; } ?></span>
												<div class="icons left" style="margin-left: 0px;">
													<div class="icon" style="margin-left: 0px;"><img style="margin-left: 0px;" src="https://www.barrowsandforrester.co.uk/wp-content/uploads/2018/09/soft-1.png"><?php echo $receptionrooms; ?></div>
													<div class="icon"><img src="https://www.barrowsandforrester.co.uk/wp-content/uploads/2018/09/bed-1.png"><?php echo $bedrooms; ?></div>
													<div class="icon"><img src="https://www.barrowsandforrester.co.uk/wp-content/uploads/2018/09/bathroom-1.png"><?php echo $bathrooms; ?></div>
												</div>
											</h3>

											<?php if(strlen($content) < 25) $content="No Description <br><br>"; //Filling so it does not miss align the properties?>
											<div class="description"><?php echo substrwords($content,160, "..."); ?></div>
											<a href="/property-details/?property_id=<?php echo $post->ID; ?>&type=<?php echo $selling_type ?>" class="btn waves-effect pink-outline">Details</a>
											<!-- <a href="#" class="btn waves-effect blue">Save Property</a> -->

											<?php if (is_user_logged_in()) { ?>

												<!--<a class="btn waves-effect blue save_property" href="#"><span>Save Property</span></a> -->
												<a class="btn waves-effect blue" href="https://rezianytime.com/barrowsandforrester/client_login"><span>Save Property</span></a>

											<?php  } else { ?>

												<!--<a class="btn waves-effect blue log-in-toggle-popup" href="#"><span>Save Property</span></a> -->
												<a class="btn waves-effect blue" href="https://rezianytime.com/barrowsandforrester/client_login"><span>Save Property</span></a>

											<?php  } ?>

											<div class="hide property-id"><?php echo $user_id ?></div>
											<div class="hide user_id"><?php echo $post->ID ?></div>
											<div class="hide property-name"><?php echo $name ?></div>
											<div class="hide property-price"><?php echo number_format($price); if ($selling_type == "for-rent") { echo " pcm";} ?></div>
											<div class="hide property-img"><?php echo $imageURL; ?></div>
										</div>
									</div>
								</div>
				<?php
					endwhile;
				?>
				<?php
					else:
				?>
					<h3>No Results Found</h3>
					<p>Sorry there are no properties for these search parameters, please re-enter above and try again.</p>
				<?php
					endif;
				?>

		</div>
			<div class='pagination_container'>
			<?php
		        echo paginate_links( array(
		            'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
		            'total'        => $query->max_num_pages,
		            'current'      => max( 1, get_query_var( 'paged' ) ),
		            'format'       => '?paged=%#%',
		            'show_all'     => false,
		            'type'         => 'plain',
		            'end_size'     => 0,
		            'mid_size'     => 3,
		            'prev_next'    => true,
		            'prev_text'    => sprintf( '<i class="fa fa-angle-left" aria-hidden="true"></i>', __( '<span>«</span> Prev', 'text-domain' ) ),
		            'next_text'    => sprintf( '<i class="fa fa-angle-right" aria-hidden="true"></i>', __( 'Next <span>»</span>', 'text-domain' ) ),
		            'add_args'     => false,
		            'add_fragment' => '',
		        ) );
			?>
		</div>
	</div>
</div>
<?php get_footer(); ?>
