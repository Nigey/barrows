<?php

        ignore_user_abort(false);
        //include 'rezi-functions.php';

        $path = preg_replace('/wp-content(?!.*wp-content).*/','',__DIR__);
        include($path.'wp-load.php');


        /* Send the JSON variables */

        /* http://developer.dezrez.com/rezi-webguide/making-requests */

        $json = '{

                    PageSize: 100,
                    IncludeStc: true

                 }';

        /* API keys and URL to get the API information */

        $apikey = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwczovL2F1dGguZGV6cmV6LmNvbS9BcGlLZXlJc3N1ZXIiLCJhdWQiOiJodHRwczovL2FwaS5kZXpyZXouY29tL3NpbXBsZXdlYmdhdGV3YXkiLCJuYmYiOjE1MjQ1NzUyNTQsImV4cCI6NDY4MDI0ODg1NCwiSXNzdWVkVG9Hcm91cElkIjoiNjI4NzIxNyIsIkFnZW5jeUlkIjoiMzkxIiwic2NvcGUiOlsiaW1wZXJzb25hdGVfd2ViX3VzZXIiLCJwcm9wZXJ0eV9iYXNpY19yZWFkIiwibGVhZF9zZW5kZXIiXX0.tBAyr6fXJCSNHHikHJZMiPs9sbm8De4CZ3rAO5xFxTg";
        $locations_url = "https://api.dezrez.com/api/simplepropertyrole/search?APIKey=" . $apikey;

        /* Initiate curl to send the JSON information using the credentials above */

        $c = curl_init();
        curl_setopt($c, CURLOPT_URL, $locations_url);
        curl_setopt($c, CURLOPT_POST, true);
        curl_setopt($c, CURLOPT_USERAGENT, 'PHP/' . phpversion());
        curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($c, CURLOPT_POSTFIELDS, $json);
        curl_setopt($c, CURLOPT_HTTPHEADER, array('Rezi-Api-Version: 1.0', 'Content-Type: application/json'));

        $result = curl_exec($c);

        if (curl_errno($c)) {
            return trigger_error('CURL error [' . curl_errno($c) . '] ' . curl_error($c));
        }

        curl_close($c);

        /* Decode the JSON information which has been returned and place it into a PHP array */
        $result = json_decode($result);
        $result = json_decode(json_encode($result), True);

        /* Start creating variables for the information which is required */
        $properties = $result['Collection'];

        //die(neatArray($properties));

        /*foreach ($properties as $property) {
            //var_dump($property);
            $flags = $property['Flags'];
            //var_dump($flags[1]['SystemName']);
            //var_dump($flags[count($flags)-1]['SystemName']);
            foreach ($flags as $flag)
            {
                $flagType = $flag['SystemName'];
                var_dump($flagType);
            }
            echo "<br>--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------<br>";
        }
        die(); */


        /* First of all, remove the properties which have been added to sync correctly */

       removeAddedProperties(returnListOfProperties());



        foreach ($properties as $property) {

            $encoded_url = rand(1000000, 1000000000);
            $description1 = $property['Descriptions'][1]['Text'];
            $description2 = $property['SummaryTextDescription'];
            $description3 = $property['Descriptions'][0]['Text'];
            $description4 = $property['Descriptions'][4]['Text'];

            if (strlen($description1) > strlen($description2) && strlen($description1) > strlen($description3) && strlen($description1) > strlen($description4)) $content = $description1;
            else if (strlen($description2) > strlen($description1) && strlen($description2) > strlen($description3) && strlen($description2) > strlen($description4)) $content = $description2;
            else if (strlen($description3) > strlen($description1) && strlen($description3) > strlen($description2) && strlen($description3) > strlen($description4)) $content = $description3;
            else $content = $description4;

            if (strlen($content) < 5) $content = "No Description";

            /* Insert the post initially */

            $insert_main_property = array(
                'post_author' => '1',
                'post_date' => dateNow(),
                'post_date_gmt' => dateNow(),
                'post_content' => $content,
                'post_title' => $property['Address']['Street'] . ', ' . $property['Address']['Postcode'],
                'post_status' => 'publish',
                'comment_status' => 'open',
                'ping_status' => 'open',
                'post_name' => $encoded_url,
                'post_modified' => dateNow(),
                'post_modified_gmt' => dateNow(),
                'post_parent' => '0',
                'guid' => '',
                'menu_order' => '0',
                'post_type' => 'property',
                'comment_count' => '0'
            );



            /* Validation to make sure that the property is not duplicating in the DB  */
            if (duplicationCheck($property['PropertyId']))
            {
                echo "Non Duplicate: " . $property['Address']['Street'] . ', ' . $property['Address']['Postcode'];
                /* Insert query */
                $postID = insertMainProperty($insert_main_property);

                /* Get the latest ID from the property which has just been created */
                //$postID = getLatestPropertyID();

                $imageNameTitle = rand(1000000, 1000000000);
                $imageURL = $property['Images'][0]['Url'];
                $uploaddir = wp_upload_dir();
                $filename = rand(100000, 100000000000) . '.jpg';
                $uploadfile = $uploaddir['path'] . '/' . $filename;
                $contents = file_get_contents($imageURL);
                $savefile = fopen($uploadfile, 'w');
                fwrite($savefile, $contents);
                fclose($savefile);
                $timestamp = date('Y/m');

                $insert_main_photo = array(
                    'post_author' => '1',
                    'post_date' => dateNow(),
                    'post_date_gmt' => dateNow(),
                    'post_content' => '',
                    'post_title' => $imageNameTitle,
                    'post_status' => 'inherit',
                    'comment_status' => 'open',
                    'ping_status' => 'closed',
                    'post_name' => $imageNameTitle,
                    'post_modified' => dateNow(),
                    'post_modified_gmt' => dateNow(),
                    'post_parent' => '0',
                    'guid' => get_site_url() . '/wp-content/uploads/'.$timestamp.'/' . $filename,
                    'menu_order' => '0',
                    'post_type' => 'attachment',
                    'post_mime_type' => 'image/jpeg',
                    'comment_count' => '0'
                );

                insertMainPhoto($insert_main_photo);
                $latestPhotoID = getLatestPhotoID();

                /* Insert the unique propertyID */
                insertPropertyDetail($postID, 'api-property-id', $property['PropertyId']);

                /* Get the property advertisement type (either sales or lettings) and match it with terms in database */
                /* Insert the property advisement type matching the property id */
                $property_type = $property['RoleType']['SystemName'];

                if ($property_type == 'Selling') {
                    if (getTermInfo('for-sale')) {
                        $property_type = getTermInfo('for-sale')['term_id'];
                    } else {
                        $property_type = '999';
                    }

                } else {
                    if (getTermInfo('for-rent')) {
                        $property_type = getTermInfo('for-rent')['term_id'];
                    } else {
                        $property_type = '999';
                    }
                }

                /* Insert into the wp_terms so that the property is linked to either for sale or for let */
                insertPropertyType($postID, $property_type);

                /* Insert the actual property details into the database */
                /* Address */
                $address = $property['Address'];
                $a_building_name = $address['OrganizationName'];
                $a_number = $address['Number'];
                $a_street = $address['Street'];
                $a_town = $address['Town'];
                $a_locality = $address['Locality'];
                $a_county = $address['County'];
                $a_postcode = $address['Postcode'];
                $lat = $address['Location']['Latitude'];
                $lon = $address['Location']['Longitude'];

                if (trim($a_number) != '') {
                    $a_street = $a_number . ', ' . $a_street;
                }

                if (trim($a_building_name) != '') {
                    $a_street = $a_building_name . ', ' . $a_street;
                }

                $uploaddir = wp_upload_dir();

                /* Insert the URL for all images found */

                $property_images = $property['Images'];

                foreach ($property_images as $pImage)
                {
                    $filename = rand(100000, 100000000000) . '.jpg';
                    $uploadfile = $uploaddir['path'] . '/' . $filename;
                    $contents = file_get_contents($pImage['Url']);
                    $savefile = fopen($uploadfile, 'w');
                    fwrite($savefile, $contents);
                    fclose($savefile);
                    $timestamp = date('Y/m');
                    insertImage($postID, get_site_url() . '/wp-content/uploads/'.$timestamp.'/' . $filename);
                }

                /* Query insert the property address details */

                insertPropertyDetail($postID, 'property-address1', $a_street);
                insertPropertyDetail($postID, 'property-address2', $a_town);
                insertPropertyDetail($postID, 'property-address3', $a_locality);
                insertPropertyDetail($postID, 'property-address4', $a_county);
                insertPropertyDetail($postID, 'property-postcode', $a_postcode);
                insertPropertyDetail($postID, 'property-latitude', $lat);
                insertPropertyDetail($postID, 'property-longitude', $lon);

                /* Branch details */

                $branch = $property['BranchDetails'];
                $branch_name = $branch['Name'];
                $branch_email = $branch['ContactDetails']['ContactItems'][0]['Value'];
                $branch_telephone = $branch['ContactDetails']['ContactItems'][2]['Value'];

                /* Query insert the property branch details */

                insertPropertyDetail($postID, 'property-branch', $branch_name);
                insertPropertyDetail($postID, 'property-branch_email', $branch_email);
                insertPropertyDetail($postID, 'property-branch_telephone', $branch_telephone);

                /* Price and type details and query insert */

                $price = $property['Price']['PriceValue'];
                insertPropertyDetail($postID, 'property-price', $price);
                insertPropertyDetail($postID, 'price', $price);

                /* Check the API flags to see which properties are featured */

                $flags = $property['Flags'];

                foreach ($flags as $flag)
                {
                    $flagType = $flag['SystemName'];

                    if ($flagType == 'Featured') {
                        insertPropertyDetail($postID, 'featured', 'true');
                    }
                    
                    if ($flagType == 'UnderOffer') {
                        insertPropertyDetail($postID, 'underoffer', 'true');
                    }
                    
                    if ($flagType == 'OfferAccepted') {
                        insertPropertyDetail($postID, 'offeraccepted', 'true');
                    }
                }

                /* Insert thumbnail image */
                insertPropertyDetail($postID, '_thumbnail_id', $latestPhotoID);

                /* Property type */
                $type = $property['PropertyType']['DisplayName'];

                if (trim($type == '')) {
                    $pType = 'N/A';
                } else {
                    $pType = $property['PropertyType']['DisplayName'];
                }

                insertPropertyDetail($postID, 'property-propertyownabletype', $pType);

                /* Room count */

                $rooms = $property['RoomCountsDescription'];
                insertPropertyDetail($postID, 'property-bedrooms', $rooms['Bedrooms']);
                insertPropertyDetail($postID, 'property-receptionrooms', $rooms['Receptions']);
                insertPropertyDetail($postID, 'property-bathrooms', $rooms['Bathrooms']);

                /* Documents */

                $documents = $property['Documents'];

                /* Search to see which one is the floorplan and which one is the brochure */

                foreach ($documents as $document)
                {
                    $dType  = $document['DocumentSubType']['SystemName'];
                    $dURL   = $document['Url'];

                    /* Check to see if it's a floorplan or brochure */

                    if ($dType == 'Floorplan') {
                        insertPropertyDetail($postID, 'property-floorplan', $dURL);
                    } else if ($dType == 'Brochure') {
                        insertPropertyDetail($postID, 'property-brochure', $dURL);
                    }
                }

                /* Terms */
                $pets_allowed = $property['Descriptions'][1]['Pairs'][0]['Value']['DisplayName'];
                insertPropertyDetail($postID, 'pet_policy', $pets_allowed);
            }
            }

            /* This can be used as a test to see what is being output from the API response */

            die();

            neatArray($result);

?>
