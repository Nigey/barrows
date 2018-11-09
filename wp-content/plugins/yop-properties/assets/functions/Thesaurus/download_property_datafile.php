<?php 

// ftp_sync - Copy directory and file structure 
function ftp_sync ($dir) { 

    global $ftp_conn; 

    if ($dir != ".") { 
        if (ftp_chdir($ftp_conn, $dir) == false) { 
            echo ("Change Dir Failed: $dir<BR>\r\n"); 
            return; 
        } 
        if (!(is_dir($dir))) 
            mkdir($dir); 
        chdir ($dir); 
    } 

    $contents = ftp_nlist($ftp_conn, "."); 
    foreach ($contents as $file) { 

        if ($file == '.' || $file == '..') 
            continue; 

        if (@ftp_chdir($ftp_conn, $file)) { 
            ftp_chdir ($ftp_conn, ".."); 
            ftp_sync ($file); 
        } 
        else 
            ftp_get($ftp_conn, $file, $file, FTP_BINARY); 
    } 

    ftp_chdir ($ftp_conn, ".."); 
    chdir (".."); 

} 

// connect and login to FTP server
$ftp_server = "www2.housescape.org.uk";
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$ftp_username = "brn1ro";
$ftp_userpass = "ua62dbld";
$login = ftp_login($ftp_conn, $ftp_username, $ftp_userpass);

$local_file = "www2.housescape.org.uk/data/data.file";
$server_file = "data.file";

ftp_sync ("/data"); 

// close connection
ftp_close($ftp_conn);

?>