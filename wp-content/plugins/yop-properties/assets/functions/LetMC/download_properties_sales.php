<?php 

require_once("../../../../wp-load.php");

$url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/branch/branches?offset=0&count=100&api_key='.API_credentials()[0].'';


$branches = get_results($url);

foreach ($branches['Data'] as $branch) {

	$slug = sanitize_title_with_dashes( $branch['Name'] );

	$pod = pods( 'letmc_branch', $slug );

	if ($pod->exists()) {
		$data = array( 
		    'oid' => $branch['OID'],
			'title' => $branch['Name'],
			'companyname' => $branch['CompanyName'],
			'address1' => $branch['Address1'],
			'address2' => $branch['Address2'],
			'address3' => $branch['Address3'],
			'address4' => $branch['Address4'],
			'postcode' => $branch['Postcode'],
			'webaddress' => $branch['WebAddress'],
			'emailaddress' => $branch['EMailAddress'],
			'landphone' => $branch['LandPhone'],
			'faxphone' => $branch['FaxPhone'],
			'county' => $branch['County'],
			'post_status' => 'Publish',
		); 

		$branch_add = $pod->save( $data ); 
	}else{
		$data = array( 
		    'oid' => $branch['OID'],
			'title' => $branch['Name'],
			'companyname' => $branch['CompanyName'],
			'address1' => $branch['Address1'],
			'address2' => $branch['Address2'],
			'address3' => $branch['Address3'],
			'address4' => $branch['Address4'],
			'postcode' => $branch['Postcode'],
			'webaddress' => $branch['WebAddress'],
			'emailaddress' => $branch['EMailAddress'],
			'landphone' => $branch['LandPhone'],
			'faxphone' => $branch['FaxPhone'],
			'county' => $branch['County'],
			'post_status' => 'Publish',
		); 

		$branch_add = $pod->add( $data ); 
	}

	$branch_id = $branch['OID'];

	$offset = 0;
	$count = 1000;

	$sales_url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/sales/advertisedsales?branchID='.$branch_id.'&offset='.$offset.'&count='.$count.'&onlyDevelopement=false&onlyInvestements=false&api_key='.API_credentials()[0].'';
	if (($response_xml_data = file_get_contents($sales_url))===false){
	    echo "Error fetching XML\n :(";
	} else {
		$results=json_decode($response_xml_data, TRUE);
		if ($results['Count'] > 999) {
			$offset = 999;
			if (($response_xml_data = file_get_contents($sales_url))===false){
			    echo "Error fetching XML\n";
			} else {
				$second_results=json_decode($response_xml_data, TRUE);

				$results = array_merge_recursive($results, $second_results);
			}
		}
		foreach ($results['Data'] as $sale_property) {

			$slug = sanitize_title_with_dashes( $sale_property['OID'] );
			$pod = pods( 'for_sale_properties', $slug );

			$photos = get_sales_listing_images($sale_property['OID'], 1);

		    // $photo_id = $main_img_id['OID'];
		    $photo_id = $photos['Data'][0]['OID'];
			$photo_name = '400x'.$sale_property['OID'];

			$image_download_url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/photos/photo/'.$photo_id.'/download?width=400&height=300&api_key='.API_credentials()[0].'';
			$saveto = '/home/brinkleys/public_html/wp-content/uploads/property_images/listing_icons/'.$photo_name.'';

			echo "<br>";
			echo $photo_id;
			echo $photo_name;
			echo "<br>";
			grab_image($image_download_url,$saveto);

		    $main_img = 'http://brinkleys.co.uk/wp-content/uploads/property_images/listing_icons/'.$photo_name;

		    $postcode = $sale_property['Postcode'];
			if (isset($postcode) && !empty($postcode)) {
			    $latlong = file_get_contents('http://api.postcodes.io/postcodes/' . $postcode . '');
			}
			if (isset($latlong) && !empty($latlong)) {
			    $array=explode(",",$latlong); 
			    $longitude = preg_replace('/"[\s\S]+?:/', '', $array[7]);
			    $latitude = preg_replace('/"[\s\S]+?:/', '', $array[8]);
			}

			if ($pod->exists()) {
				$data = array( 
					'title' => $sale_property['OID'],
				    'oid' => $sale_property['OID'],
					'addressnumber' => $sale_property['AddressNumber'],
					'address1' => $sale_property['Address1'],
					'address2' => $sale_property['Address2'],
					'address3' => $sale_property['Address3'],
					'address4' => $sale_property['Address4'],
					'postcode' => $postcode,
					'country' => $sale_property['Country'],
					'price' => $sale_property['Price'],
					'tenure' => $sale_property['Tenure'],
					'description' => $sale_property['Description'],
					'receptionrooms' => $sale_property['ReceptionRooms'],
					'kitchens' => $sale_property['Kitchens'],
					'bedrooms' => $sale_property['Bedrooms'],
					'bathrooms' => $sale_property['Bathrooms'],
					'bathroomsensuite' => $sale_property['BathroomsEnsuite'],
					'branch' => $branch_id,
					'propertyownabletype' => $sale_property['PropertyOwnableType'],
					'contracttype' => $sale_property['ContractType'],
					'state' => $sale_property['State'],
					'latitude' => $latitude,
					'longitude' => $longitude,
					'mainphoto' => $main_img,
					'post_status' => 'Publish',
				); 

				$saved_property = $pod->save( $data );
				echo $sale_property['Address1'].' - '.$sale_property['OID']. ' Updated! :D';
			}else{
				$data = array( 
					'title' => $sale_property['OID'],
				    'oid' => $sale_property['OID'],
					'addressnumber' => $sale_property['AddressNumber'],
					'address1' => $sale_property['Address1'],
					'address2' => $sale_property['Address2'],
					'address3' => $sale_property['Address3'],
					'address4' => $sale_property['Address4'],
					'postcode' => $postcode,
					'country' => $sale_property['Country'],
					'price' => $sale_property['Price'],
					'tenure' => $sale_property['Tenure'],
					'description' => $sale_property['Description'],
					'receptionrooms' => $sale_property['ReceptionRooms'],
					'kitchens' => $sale_property['Kitchens'],
					'bedrooms' => $sale_property['Bedrooms'],
					'bathrooms' => $sale_property['Bathrooms'],
					'bathroomsensuite' => $sale_property['BathroomsEnsuite'],
					'branch' => $branch_id,
					'propertyownabletype' => $sale_property['PropertyOwnableType'],
					'contracttype' => $sale_property['ContractType'],
					'state' => $sale_property['State'],
					'latitude' => $latitude,
					'longitude' => $longitude,
					'mainphoto' => $main_img,
					'post_status' => 'Publish',
				); 

				$saved_property = $pod->add( $data ); 
				echo $sale_property['Address1'].' - '.$sale_property['OID']. ' Saved! :D';
			}
			echo "<hr>";
		}
	}
}


 ?>