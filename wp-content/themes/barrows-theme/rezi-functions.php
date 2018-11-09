<?php

        /* This function returns a neat array */
        function neatArray($array)
        {
            return print("<pre>".print_r($array, true)."</pre>");
        }

        /* Return the current date in the timestamp of DD-MM-YYYY HH:MM:SS */
        function dateNow()
        {
            return date('Y-m-d H:i:s');
        }

        /* Insert the main details of the property */
        function insertMainProperty($insert)
        {
            global $wpdb;
            $wpdb->insert(
                'wp_posts',
                $insert
            );
            return $wpdb->insert_id;
        }

        function insertMainPhoto($insert)
        {
            global $wpdb;
            $wpdb->insert(
                'wp_posts',
                $insert
            );
        }

        /* This function will link the property advert for either sale or let */
        function insertPropertyType($propertyID, $type)
        {
            global $wpdb;
            $wpdb->insert(
                'wp_term_relationships',
                array(
                    'object_id' => $propertyID,
                    'term_taxonomy_id' => $type
                )
            );
        }

        /* Duplication check to ensure that the property is not being duplicated */
        function duplicationCheck($propertyid)
        {
            global $wpdb;
            $checkDuplicate = $wpdb->get_var("SELECT COUNT(*) FROM `wp_postmeta` WHERE `meta_key` = 'api-property-id' AND `meta_value`='$propertyid'");
            if ($checkDuplicate <= 0)
            {
                return TRUE;
            } else {
                return FALSE;
            }
        }

        /* This function will input the property information which is sent to wp_postmeta */
        function insertPropertyDetail($propertyid, $key, $value)
        {
            global $wpdb;
            $wpdb->insert(
                'wp_postmeta',
                array(
                    'post_id' => $propertyid,
                    'meta_key' => $key,
                    'meta_value' => $value
                )
            );
        }

        /* This function will return rezi images */
        function returnReziImages($propertyID)
        {
            global $wpdb;
            $checkRows = $wpdb->get_var("SELECT COUNT(*) FROM `wp_postmeta` WHERE `meta_key`='gallery' AND `post_id`='$propertyID'");
            if ($checkRows <= 0)
            {
                return FALSE;
            } else {
                $photos = $wpdb->get_results( "SELECT * FROM `wp_postmeta` WHERE `meta_key`='gallery' AND `post_id`='$propertyID'");
                $photos = removeStdObject($photos);
                return $photos;
            }
        }

        /* This will add an image into the postmeta table in the database which can be grabbed from the frontend */
        function insertImage($propertyID, $URL)
        {
            global $wpdb;
            $wpdb->insert(
                'wp_postmeta',
                array(
                    'post_id' => $propertyID,
                    'meta_key' => 'gallery',
                    'meta_value' => $URL
                )
            );
        }

        function removeStdObject($output)
        {
            return json_decode(json_encode($output), True);
        }

        /* Return a list of properties which have been inserted via Rezi */
        function returnListOfProperties()
        {
            global $wpdb;
            $latestID = $wpdb->get_results( "SELECT * FROM `wp_postmeta` WHERE `meta_key`='api-property-id'");
            $latestID = removeStdObject($latestID);
            return $latestID;
        }

        /* Return property meta information */
        function returnPropertyThumbnail($postid)
        {
            global $wpdb;
            $propertyMeta = $wpdb->get_results( "SELECT * FROM `wp_postmeta` WHERE `post_id`='$postid' AND `meta_key`='_thumbnail_id'");
            $propertyMeta = removeStdObject($propertyMeta);
            return $propertyMeta . "?width=250px";
        }

        /* Function to remove all properties which have been automatically added */
        function removeAddedProperties($properties)
        {
            global $wpdb;
            foreach ($properties as $property)
            {
                $postid = $property['post_id'];
                $thumbnail_id = returnPropertyThumbnail($postid)[0]['meta_value'];

                /* Find the gallery and also the thumbnails and remove them from the actual uploads directory */
                /* First find a list of the pictures for the gallery, and then remove each one from the database and also the upload directory */
                $galleryPictures = $wpdb->get_results("SELECT * FROM `wp_postmeta` WHERE `post_id`='$postid' AND `meta_key`='gallery'");
                $galleryPictures = removeStdObject($galleryPictures);

                /* Remove the thumbnail which has been added */
                $uploadThumbnail = strstr(returnPropertyThumbnailURL($property['post_id']));
                unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $uploadThumbnail);

                foreach ($galleryPictures as $picture)
                {
                    $uploadLocation = strstr($picture['meta_value'], 'wp-content');
                    unlink($_SERVER['DOCUMENT_ROOT'] . '/' . $uploadLocation);
                }

                $wpdb->delete( 'wp_posts', array( 'ID' => $postid ) );
                $wpdb->delete( 'wp_postmeta', array( 'post_id' => $postid ) );
                $wpdb->delete( 'wp_posts', array( 'ID' => $thumbnail_id ) );
            }

        }

        /* Get the URL for image thumbnail */
        function returnPropertyThumbnailURL($propertyID)
        {
            $thumbnail_postID = returnPropertyThumbnail($propertyID)[0]['meta_value'];
            global $wpdb;
            $thumbnailURL = $wpdb->get_results( "SELECT * FROM `wp_posts` WHERE `ID`='$thumbnail_postID'");
            $thumbnailURL = removeStdObject($thumbnailURL);
            return $thumbnailURL[0]['guid'];
        }

        /* Get the latest propertyID */
        function getLatestPropertyID()
        {
            global $wpdb;
            $latestID = $wpdb->get_results( "SELECT * FROM `wp_posts` ORDER BY `ID` DESC LIMIT 1");
            $latestID = removeStdObject($latestID);
            return $latestID[0]['ID'];
        }

        /* Get the latest photoID */
        function getLatestPhotoID()
        {
            global $wpdb;
            $latestID = $wpdb->get_results( "SELECT * FROM `wp_posts` ORDER BY `ID` DESC LIMIT 1");
            $latestID = removeStdObject($latestID);
            return $latestID[0]['ID'];
        }

        /* Return term info based on slug, if any match */
        function getTermInfo($type)
        {
            global $wpdb;
            $checkRows = $wpdb->get_var("SELECT COUNT(*) FROM `wp_terms` WHERE `slug`='$type'");
            if ($checkRows <= 0) {
                return FALSE;
            } else {
                $terms = $wpdb->get_results("SELECT * FROM `wp_terms` WHERE `slug`='$type'");
                $terms = removeStdObject($terms);
                return $terms[0];
            }
        }
?>
