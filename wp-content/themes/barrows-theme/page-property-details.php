<?php
	get_header();

	$property_id = $_GET['property_id'];
	$this_property = get_post( $property_id );
	$property_type = $_GET['type'];
	$address1 = get_post_meta( $property_id, 'property-address1', TRUE );
	$address2 = get_post_meta( $property_id, 'property-address2', TRUE );
	$address3 = get_post_meta( $property_id, 'property-address3', TRUE );
	$address4 = get_post_meta( $property_id, 'property-postcode', TRUE );
	$floorplan = get_post_meta( $property_id, 'property-floorplan', TRUE );
	$address5 = 'United Kingdom';
	$property_image = get_post_meta( $property_id, 'property-mainphoto', TRUE );
    $address1 = preg_replace('/^[^,]*,\s*/', '', $address1);
	$property_name = $address1 . ", " . $address2 . ", " . $address4;
	$price = get_post_meta( $property_id, 'property-price', TRUE );
	$price_int = (int)$price;
	$price_2 = number_format($price_int);
	$content = $this_property->post_content;
	$content = apply_filters('the_content', $content);
	$description = str_replace(']]>', ']]&gt;', $content);
	$paragraph_1 = $description;
	$paragraph_2 = get_post_meta( $property_id, 'property-short-description', TRUE );
	$gImages = returnReziImages($property_id);
	$lat = get_post_meta( $property_id, 'property-latitude', TRUE );
	$long = get_post_meta( $property_id, 'property-longitude', TRUE );
?>

<div class="push_top">
	<div class="et_pb_row et_pb_gutters3 custom_width et_pb_equal_columns">
		<div class="et_pb_column et_pb_column_2_3">
			<div class="full_img">
				<div class="slick-images">
				<?php
					$full_count = 1;
					 if ($gImages) { foreach ($gImages as $gImage) {

            			$image = $gImage['meta_value']; ?>
						<div data-slide="<?php echo $full_count; ?>" class="big-image">
							<img class="big-image" src="<?php echo $image; ?>">
						</div>

					<?php
					$full_count++;

					}
				}
				 ?>
				</div>
				<!-- <img src="http://via.placeholder.com/700x400"> -->
			</div>
		</div>
		<div class="et_pb_column et_pb_column_1_3" id="slick_navigation">
			<div class="thumbnails" style="max-height: 500px;">
				<div class="et_pb_row thumbnailPics">
					<?php
					$full_count = 0;
					 if ($gImages) { foreach ($gImages as $gImage) { ?>
            			<?php $image = $gImage['meta_value']; ?>
						<div class="">
							<div class="thumb_1">
								<a data-slide="<?php echo $full_count; ?>">
									<div class="image-relative" style="background-image: url(<?php echo $image; ?>)"></div>
								</a>
							</div>
						</div>
					<?php
					$full_count++;
					}
				}
					?>
				</div>
			</div>
		</div>
	</div>
	<div class="et_pb_row et_pb_gutters3 custom_width tab_container" style="padding: 0">
		<div class="et_pb_column et_pb_column_2_3">
			<div class="tabs tab_description tab_active">
				<h2><?php echo $property_name; ?></h2>
				<h3>£ <?php echo $price_2; if ($property_type == "rent"){echo " PCM";} ?></h3>
				<p><?php echo $paragraph_1; ?></p>
				<br>
				<!--<h3>Energy Performance Certificate</h3>
				<p>Click Here to view the Energy Efficiency Rating and Environmental Impact Rating for this property</p>-->
				<h3 class="disclaimer">Disclaimer</h3>
				<p class="disclaimer" style="padding-bottom:20px!important">Barrows Forrester endeavour to maintain accurate descriptions of properties in Virtual Tours, Floor Plans and descriptions, however, these are intended only as a guide and purchasers must satisfy themselves by personal inspection.</p>
			</div>
			<div class="tabs tab_floorplan">
				<?php if ($floorplan != '') { ?>
				<img src="<?php echo $floorplan; ?>">
				<?php } else { echo '<h2 class="bold">No floorplan available<h2>'; } ?>
			</div>
			<div class="tabs tab_map">
                <? //print_r($this_property); ?>
                <div id="single_map" data-latitude='<?php echo $lat; ?>' data-longitude='<?php echo $long; ?>'></div>
			</div>
			<div class="tabs tab_map_street">
                <div id="pano" data-latitude='<?php echo $lat; ?>' data-longitude='<?php echo $long; ?>'></div>
			</div>
			<div class="tabs tab_contact">
				<?php echo do_shortcode('[contact-form-7 id="1138" title="Arrange A Viewing" property="' . $property_name . '"]'); ?>
			</div>
		</div>
		<div class="et_pb_column et_pb_column_1_3">
			<div class="button-container btn_right round-effect blue-btn">
				<a data-tab="tab_description" class="button-cta button-effect btn_tab">Description</a>
			</div>
			<div class="button-container btn_right round-effect pink-btn">
				<a data-tab="tab_contact" class="button-cta button-effect btn_tab">Arrange A Viewing</a>
			</div>
			<div class="button-container btn_right round-effect blue-btn">
				<a data-tab="tab_map" class="button-cta button-effect btn_tab">Map</a>
			</div>
<!-- 			<div class="button-container btn_right round-effect pink-btn">

				<a data-tab="tab_map_street" class="button-cta button-effect btn_tab">Street View</a>

			</div> -->
			<div class="button-container btn_right round-effect pink-btn">
				<a data-tab="tab_floorplan" class="button-cta button-effect btn_tab">Floor Plan</a>
			</div>
			<div onclick="window.history.back()" class="button-container btn_right round-effect blue-btn">
				<a class="button-cta button-effect">Go Back</a>
			</div>
			<div onclick="window.history.back()" class="button-container btn_right round-effect pink-btn">
				<a href="../wp-content/themes/barrows-theme/includes/search.php?show_search=true" class="button-cta button-effect">New Search</a>
			</div>
<!-- 			<a class="btn pink" >Go Back</a>
			<a class="btn blue" >New Search</a> -->
		</div>
	</div>
</div>

<script>
	function aftermap(){
		initMap();
		initialize();
	}

    window.initMap = function() {

    map = new google.maps.Map(document.getElementById("single_map"), {
        center: {
           	lat: <?= $lat ?>,
            lng: <?= $long ?>
        },
        disableDefaultUI: !0,
        styles: [{"featureType":"all","elementType":"labels.text.fill","stylers":[{"color":"#ffffff"}]},{"featureType":"all","elementType":"labels.text.stroke","stylers":[{"visibility":"on"},{"color":"#3e606f"},{"weight":2},{"gamma":0.84}]},{"featureType":"all","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"administrative","elementType":"geometry","stylers":[{"weight":0.6},{"color":"#1a3541"}]},{"featureType":"landscape","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"poi","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"poi.park","elementType":"geometry","stylers":[{"color":"#2c5a71"}]},{"featureType":"road","elementType":"geometry","stylers":[{"color":"#29768a"},{"lightness":-37}]},{"featureType":"transit","elementType":"geometry","stylers":[{"color":"#406d80"}]},{"featureType":"water","elementType":"geometry","stylers":[{"color":"#193341"}]}],
        zoom: 14
    });

    new google.maps.Marker({
        position: {
            lat: <?= $lat ?>,
            lng: <?= $long ?>
        },
        icon: "/wp-content/uploads/2017/11/marker.png",
        map: map,
        title: "Hello World!"
    });
	};

</script>
<?php get_footer(); ?>
<script src="https://maps.google.com/maps/api/js?key=AIzaSyBgx_pudG317XqWjLkk96q2qgqTHP5Qeec&callback=aftermap" type="text/javascript" async defer></script>
