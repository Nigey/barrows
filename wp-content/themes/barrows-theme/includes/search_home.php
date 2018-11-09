<?php 


$location     = $_POST['location'];
$selling_type     = $_POST['propery_type'];


header('Location: http://barrows.youronlinepresence.uk/search-property?&selling_type='. $selling_type .'&location=' . $location );
// echo "hello";
// echo $minPrice;
// echo $maxPrice;
// echo $selling_type;


die();

?>