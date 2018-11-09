<?php
require_once("../../../../wp-load.php");

require_once('php_image_magician.php');

$url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/photo/photos?offset=0&count=100000&api_key='.API_credentials()[0].'';

if (($response_xml_data = file_get_contents($url))===false){
    echo "Error fetching XML\n";
} else {
	$results=json_decode($response_xml_data, TRUE);
	if ($results['Count'] > 999) {
		$url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/photo/photos?offset=999&count=100000&api_key='.API_credentials()[0].'';
		if (($response_xml_data = file_get_contents($url))===false){
		    echo "Error fetching XML\n";
		} else {
			$second_results=json_decode($response_xml_data, TRUE);

			$results = array_merge_recursive($results, $second_results);
		}
	}
}

// echo "<pre>";
// print_r($results);
// echo "</pre>";
foreach ($results['Data'] as $image) {
	$photo_id = $image['OID'];
	$photo_name = $image['FileName'];
	$filename = '/home/brinkleys/public_html/wp-content/uploads/property_images/'.$photo_name.'';

	if (file_exists($filename)) {
	    echo "The file $filename exists";
	    echo "<hr>";
	} else {
		$image_download_url = 'https://live-api.letmc.com/v2/tier1/'.API_credentials()[1].'/photos/photo/'.$photo_id.'/download?api_key='.API_credentials()[0].'';
		$saveto = '/home/brinkleys/public_html/wp-content/uploads/property_images/'.$photo_name.'';

		echo $photo_id;
		echo $photo_name;
	    echo "<hr>";

		grab_image($image_download_url,$saveto);

		/*	Purpose: Open image
	     *	Usage:	 resize('filename.type')
	     * 	Params:	 filename.type - the filename to open
	     */
		$magicianObj = new imageLib('/home/brinkleys/public_html/wp-content/uploads/property_images/'.$photo_name);

		/*	Purpose: Resize image
	     *	Usage:	 resizeImage([width], [height])
	     * 	Params:	 width - the new width to resize to
	     *			 height - the new height to resize to 
	     */	
		$magicianObj -> resizeImage(1920, 1020, 'landscape');

		/*	Purpose: Save image
	     *	Usage:	 saveImage('[filename.type]', [quality])
	     * 	Params:	 filename.type - the filename and file type to save as
	 	 * 			 quality - (optional) 0-100 (100 being the highest (default))
	     *				Only applies to jpg & png only
	     */
		$magicianObj -> saveImage('/home/brinkleys/public_html/wp-content/uploads/property_images/'.$photo_name, 100);

		$magicianObj->reset(); # resets the image resource
	}

}

?>