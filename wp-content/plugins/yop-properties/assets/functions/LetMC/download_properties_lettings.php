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

	$lettings_url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/lettings/advertised?branchID='.$branch_id.'&offset='.$offset.'&count='.$count.'&api_key='.API_credentials()[0].'';

	if (($response_xml_data = file_get_contents($lettings_url))===false){
	    echo "Error fetching XML\n :(";
	} else {
		$results=json_decode($response_xml_data, TRUE);
		if ($results['Count'] > 999) {
			$offset = 999;
			if (($response_xml_data = file_get_contents($lettings_url))===false){
			    echo "Error fetching XML\n";
			} else {
				$second_results=json_decode($response_xml_data, TRUE);

				$results = array_merge_recursive($results, $second_results);
			}
		}
		$lettings_count = 1;
		foreach ($results['Data'] as $letting) {

			$prop_id = $letting['TenancyProperty'];

			$url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/property/properties/'.$prop_id.'?api_key='.API_credentials()[0].'';

			if (($response_xml_data = file_get_contents($url))===false){
			    echo "Error fetching XML\n";
			} else {
				$prop_details=json_decode($response_xml_data, TRUE);
			}

			$slug = sanitize_title_with_dashes( $letting['OID'] );
			$pod = pods( 'letting', $slug );

			$main_photo_id = $prop_details['MainPhoto'];

			$photo_name = '400x'.$letting['OID'];

			$image_download_url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/photos/photo/'.$main_photo_id.'/download?width=400&height=300&api_key='.API_credentials()[0].'';
			$saveto = '/home/brinkleys/public_html/wp-content/uploads/property_images/listing_icons/'.$photo_name.'';

			echo $main_photo_id;
			echo "<br>";
			echo $photo_name;
			echo "<br>";
			grab_image($image_download_url,$saveto);

		    $main_img = 'http://brinkleys.co.uk/wp-content/uploads/property_images/listing_icons/'.$photo_name;

		    $pattern = "/((GIR 0AA)|((([A-PR-UWYZ][0-9][0-9]?)|(([A-PR-UWYZ][A-HK-Y][0-9][0-9]?)|(([A-PR-UWYZ][0-9][A-HJKSTUW])|([A-PR-UWYZ][A-HK-Y][0-9][ABEHMNPRVWXY])))) [0-9][ABD-HJLNP-UW-Z]{2}))/i";
			if (preg_match($pattern, $prop_details['FullAddress'], $matches)){
			    $postcode = $matches[0];
			}
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
				    'title' => $letting['OID'],
				    'letting_oid' => $letting['OID'],
					'branch_oid' => $letting['Branch'],
					'area' => $letting['Area'],
					'rentadvertised' => $letting['RentAdvertised'],
					'rentschedule' => $letting['RentSchedule'],
					'bondrequired' => $letting['BondRequired'],
					'furnished' => $letting['Furnished'],
					'isshareproperty' => $letting['IsShareProperty'],
					'isstudentproperty' => $letting['IsStudentProperty'],
					'minimumtenants' => $letting['MinimumTenants'],
					'maximumtenants' => $letting['MaximumTenants'],
					'tenancyproperty' => $letting['TenancyProperty'],
					'property_attached_oid' => $prop_details['OID'],
					'roomname' => $prop_details['RoomName'],
					'fulladdress' => $prop_details['FullAddress'],
					'description' => $prop_details['Description'],
					'mainphoto' => $main_img,
					'propertytype' => $prop_details['PropertyType'],
					'postcode' => $postcode,
					'latitude' => $latitude,
					'longitude' => $longitude,
					'post_status' => 'Publish',
				); 

				$saved_property = $pod->save( $data );
				echo $prop_details['RoomName'].' - '.$letting['OID']. ' Updated! :D';
			}else{
				$data = array( 
				    'title' => $letting['OID'],
				    'letting_oid' => $letting['OID'],
					'branch_oid' => $letting['Branch'],
					'area' => $letting['Area'],
					'rentadvertised' => $letting['RentAdvertised'],
					'rentschedule' => $letting['RentSchedule'],
					'bondrequired' => $letting['BondRequired'],
					'furnished' => $letting['Furnished'],
					'isshareproperty' => $letting['IsShareProperty'],
					'isstudentproperty' => $letting['IsStudentProperty'],
					'minimumtenants' => $letting['MinimumTenants'],
					'maximumtenants' => $letting['MaximumTenants'],
					'tenancyproperty' => $letting['TenancyProperty'],
					'property_attached_oid' => $prop_details['OID'],
					'roomname' => $prop_details['RoomName'],
					'fulladdress' => $prop_details['FullAddress'],
					'description' => $prop_details['Description'],
					'mainphoto' => $main_img,
					'propertytype' => $prop_details['PropertyType'],
					'postcode' => $postcode,
					'latitude' => $latitude,
					'longitude' => $longitude,
					'post_status' => 'Publish',
				); 

				$saved_property = $pod->add( $data ); 
				echo $prop_details['RoomName'].' - '.$letting['OID']. ' Saved! :D';
			}
			echo "<hr>";
		}
	}
}


 ?>