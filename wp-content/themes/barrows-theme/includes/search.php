<?php 

	$minPrice  = $_POST['minPrice'];
	$maxPrice = $_POST['maxPrice'];
	$prop_type = $_POST['prop_type'];

	$selling_type     = $_POST['group1'];
	if (empty($selling_type)) {
		$selling_type     = $_POST['selling_type'];
	}

	$minBeds     = $_POST['minBeds'];
	$maxBeds     = $_POST['maxBeds'];
	$location     = $_POST['location'];
	$show_search     = $_POST['show_search'];

// $apikey = "71BF5613-5E5F-4810-A561-F38C52D0F8C8";

// $eaid         = $_POST['eaid'];

// $xslt         = $_POST['xslt'];

// $guid         = $_POST['sessionGUID'];

if (isset($_GET['minPrice']))
{
	$minPrice = $_GET['minPrice'];
}

if (isset($_GET['maxPrice']))
{
	$maxPrice = $_GET['maxPrice'];
}

if (isset($_GET['prop_type']))
{
	$prop_type = $_GET['prop_type'];
}

if(isset($_GET['selling_type']))
{
	$selling_type = $_GET['selling_type'];
}

if (isset($_GET['minBeds']))
{
	$minBeds = $_GET['minBeds'];
}

if (isset($_GET['maxBeds']))
{
	$maxBeds = $_GET['maxBeds'];
}

if (isset($_GET['location']))
{
	$location = $_GET['location'];
}

if (isset($_GET['per_page']))
{
	$per_page = $_GET['per_page'];
}

if (isset($_GET['show_search']))
{
	$show_search = $_GET['show_search'];
}

if (isset($_GET['show_search']))
{
	$show_search = $_GET['show_search'];
}

// $selling_type     = $prop_type;

$include_sold     = $_POST['group2'];
	header('Location: http://barrows.youronlinepresence.uk/search-property?&selling_type='. $selling_type .'&minPrice=' . $minPrice . '&maxPrice=' . $maxPrice . '&location=' . $location . '&prop_type=' . $prop_type . '&minBeds=' . $minBeds . '&maxBeds=' . $maxBeds . '&include_sold=' . $include_sold . '&per_page=' . $per_page );
	die();
?>