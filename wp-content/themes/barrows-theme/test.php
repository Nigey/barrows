
<!DOCTYPE html>
<html>
<body>

<h1>Test Features</h1>

<p>
<?php

require($_SERVER['DOCUMENT_ROOT']."/wp-content/themes/barrows-theme/rezi-functions.php");

if (isset($_GET['propertyExistsID'])) {
    
    $result = propertyExists($_GET['propertyExistsID']);
    
    if($result) {
        echo $result;
    } else {
        echo "No result found";
    }
}
else{
    echo "No propertyExistsID id set.";
}

?>
</p>

</body>
</html>
