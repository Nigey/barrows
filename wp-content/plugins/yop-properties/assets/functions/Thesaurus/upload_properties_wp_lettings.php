<?php 

require_once("../../../../wp-load.php");

$url = "data.file";

if (($property_data = file_get_contents($url)) === false) {
    echo "Error fetching XML\n";
}

// $property_data = explode('\n', $property_data);
$property_data = preg_split("/\r\n|\n|\r/", $property_data);

// echo "<pre>";
// print_r($property_data);
// echo "</pre>";
// continue;

$count = 1;

foreach ($property_data as $property) {
	$property = explode('|', $property);
	// echo "<pre>";
	// print_r($property);
	// echo "</pre>";
	// continue;

	$room_titles = "";
	$room_images = "";
	$room_descriptions = "";

	foreach ($property as $key => $value) {
		// Room Titles
		if ($key >= 26 && $key <= 57) {
			// echo $key;
			$room_titles = $room_titles.'|'.$value;
			// echo "<br>";
		}
		// Room Images
		if ($key >= 58 && $key <= 89) {
			$room_images = $room_images.'|'.$value;
		}
		// Room Descriptions
		if ($key >= 90 && $key <= 121) {
			$room_descriptions = $room_descriptions.'|'.$value;
		}
	}
	$room_descriptions = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $room_descriptions);

	// echo $room_titles;
	// echo "<br>";
	// echo $room_images;
	// echo "<br>";
	// // $room_descriptions = str_replace( "/\r\n|\n|\r/", '<br />', $room_descriptions ); 
	// // $room_descriptions = trim(strip_tags($room_descriptions));
	// echo $room_descriptions;
	// echo "<br>";


	if (isset($property[4]) && !empty($property[4])) {
	    $prop_type = 'letting';
	}else{
	    $prop_type = 'for_sale_properties';
		continue; 
	}

	$slug = sanitize_title_with_dashes( $property[0] );
	$pod = pods( $prop_type, $slug );
	// echo $property[23];
    $main_img = $property[23];

    $postcode = $property[9];
	if (isset($postcode) && !empty($postcode)) {
	    $latlong = file_get_contents('http://api.postcodes.io/postcodes/' . $postcode . '');
	}
	if (isset($latlong) && !empty($latlong)) {
	    $array=explode(",",$latlong); 
	    $longitude = preg_replace('/"[\s\S]+?:/', '', $array[7]);
	    $latitude = preg_replace('/"[\s\S]+?:/', '', $array[8]);
	}

	$description = preg_replace('/[\x00-\x1F\x7F-\xFF]/', '', $property[25]);

	if ($pod->exists()) {
		$data = array( 
			'title' => $property[0],
		    'oid' => $property[0],
			'addressnumber' => $property[8],
			'address1' => $property[227],
			'address2' => $property[226],
			'address3' => $property[6],
			'address4' => $property[5],
			'postcode' => $postcode,
			// 'country' => $sale_property['Country'],
			'price' => $property[3],
			'tenure' => $property[2],
			'description' => $description,
			'receptionrooms' => $property[19],
			// 'kitchens' => $property[5],
			'bedrooms' => $property[17],
			'bathrooms' => $property[18],
			// 'bathroomsensuite' => $sale_property['BathroomsEnsuite'],
			'branch' => $property[10],
			'branch_email' => $property[13],
			'branch_telephone' => $property[11],
			'propertyownabletype' => $property[14],
			'room_title' => $room_titles,
			'room_image' => $room_images,
			'room_description' => $room_descriptions,
			'brochure' => $property[237],
			'floorplan' => $property[132],
			// 'contracttype' => $property[2],
			'state' => $property[1],
			'latitude' => $latitude,
			'longitude' => $longitude,
			'mainphoto' => $main_img,
			'post_status' => 'Publish',
		); 

		$saved_property = $pod->save( $data );
		echo $property[227].' - '.$property[0]. ' Updated! :D - '.$prop_type;
	}else{
		$data = array( 
			'title' => $property[0],
		    'oid' => $property[0],
			'addressnumber' => $property[8],
			'address1' => $property[227],
			'address2' => $property[226],
			'address3' => $property[6],
			'address4' => $property[5],
			'postcode' => $postcode,
			// 'country' => $sale_property['Country'],
			'price' => $property[3],
			'tenure' => $property[2],
			'description' => $description,
			'receptionrooms' => $property[19],
			// 'kitchens' => $property[5],
			'bedrooms' => $property[17],
			'bathrooms' => $property[18],
			// 'bathroomsensuite' => $sale_property['BathroomsEnsuite'],
			'branch' => $property[10],
			'branch_email' => $property[13],
			'branch_telephone' => $property[11],
			'propertyownabletype' => $property[14],
			'room_title' => $room_titles,
			'room_image' => $room_images,
			'room_description' => $room_descriptions,
			'brochure' => $property[237],
			'floorplan' => $property[132],
			// 'contracttype' => $property[2],
			'state' => $property[1],
			'latitude' => $latitude,
			'longitude' => $longitude,
			'mainphoto' => $main_img,
			'post_status' => 'Publish',
		); 

		$saved_property = $pod->add( $data ); 
		echo $property[227].' - '.$property[0]. ' Saved! :D - '.$prop_type;
	}
	echo "<hr>";
}


 ?>